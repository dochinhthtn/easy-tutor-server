<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest\AddPostApplicantsRequest;
use App\Http\Requests\PostRequest\HandleTutorRequest;
use App\Http\Requests\PostRequest\PostEditorRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification\AcceptTutorNotification;
use App\Notifications\PostNotification\NewApplicantNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller {
    //

    public  ?User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getOwnPosts(Request $request) {
        $query = Post::query()
            ->where('user_id', $this->currentUser->id)
            ->orderBy('created_at', 'desc')
            ->with(['applicants', 'tutor', 'user']);

        $this->attachFilter($query, $request);

        $collection = PostResource::collection($query->paginate(15));
        $collection->wrap('posts');
        return $collection;
    }

    public function getRecommendedPosts(Request $request) {
        $subjectIds = $this->currentUser->subjects()->get(['id'])->toArray();
        $query = Post::whereIn('subject_id', $subjectIds)
            ->orderBy('created_at', 'desc')
            ->with(['applicants', 'tutor', 'user']);

        $this->attachFilter($query, $request);

        $collection = PostResource::collection($query->paginate(15));

        $collection->wrap('posts');
        return $collection;
    }

    public function getAllPosts(Request $request) {
        $query = Post::orderBy('created_at', 'desc')
            ->with(['applicants', 'tutor', 'user']);

        $this->attachFilter($query, $request);

        $collection = PostResource::collection($query->paginate(15));
        $collection->wrap('posts');
        return $collection;
    }

    public function getPost(Post $post) {
        return new PostResource($post->load(['applicants', 'user', 'tutor']));
    }

    public function getPostApplicants(Post $post) {
        $collection = UserResource::collection($post->applicants()->get());
        $collection->wrap('applicants');
        return $collection;
    }

    public function getPostTutor(Post $post) {
    }

    public function addPost(PostEditorRequest $request) {
        $post = Post::create([
            'subject_id' => $request->input('subjectId'),
            'user_id' => $this->currentUser->id,
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'offer' => $request->input('offer'),
            'grade' => $request->input('grade')
        ]);

        return new PostResource($post);
    }

    public function editPost(PostEditorRequest $request, Post $post) {
        if ($post->user_id != $this->currentUser->id) {
            return response()->json([
                'message' => 'You are not owned this post',
            ], 401);
        }

        $post->update([
            'subject_id' => $request->input('subjectId'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'offer' => $request->input('offer'),
            'grade' => $request->input('grade')
        ]);

        return new PostResource($post);
    }

    public function addPostApplicant(AddPostApplicantsRequest $request, Post $post) {
        $applicant = User::find($request->input('userId'));
        if(!$applicant->checkRole('tutor')) {
            return response()->json([
                'message' => 'This user is not a tutor'
            ], 400);
        }
        $post->applicants()->syncWithoutDetaching($applicant->id);

        // event(new NewApplicantEvent($post, $applicant));
        Notification::send($this->currentUser, new NewApplicantNotification($post, $applicant));
        return response()->json([
            'message' => 'Successfully added applicant',
        ]);
    }

    public function handleTutor(HandleTutorRequest $request, Post $post) {
        $userId = $request->input('userId');
        $action = $request->input('action');

        $tutor = User::find($userId);
        if(!$tutor->checkRole('tutor')) {
            return response()->json([
                'message' => "This user is not a tutor"
            ], 403);
        }

        if ($action == 'accept') {
            $post->update([
                'tutor_id' => $userId,
            ]);
            Notification::send($tutor, new AcceptTutorNotification($post));
        } else if ($action == 'decline') {
            $post->update([
                'tutor_id' => null,
            ]);
        }

        return response()->json([
            'message' => 'Successfully',
        ]);
    }

    public function attachFilter(Builder $query, Request $request) {
        $address = $request->query('address');
        $minOffer = $request->query('minOffer');
        $maxOffer = $request->query('maxOffer');
        $subjects = $request->query('subjects', '');
        $minGrade = $request->query('minGrade');
        $maxGrade = $request->query('maxGrade');
        $hasApplicant = $request->query('hasApplicant');

        if (!empty($address)) $query->where('address', 'like', "%$address%");

        if (is_numeric($minOffer)) $query->where('offer', '>=', $minOffer);
        if (is_numeric($maxOffer)) $query->where('offer', '<=', $maxOffer);

        if (!empty($subjects)) $query->whereIn('subject_id', explode(',', $subjects));
        if (!empty($hasApplicant) && $hasApplicant == 'true') $query->whereHas('applicants');

        if (is_numeric($minGrade)) $query->where('grade', '>=', $minGrade);
        if (is_numeric($maxGrade)) $query->where('grade', '<=', $maxGrade);
        return $query;
    }

    public function testPost(Request $request) {
        return response()->json([
            'query' => $request->query()
        ]);
    }
}
