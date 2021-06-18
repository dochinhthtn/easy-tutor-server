<?php

namespace App\Http\Controllers\API;

use App\Events\PostEvent\NewApplicantEvent;
use App\Events\TaskEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest\AddPostApplicantsRequest;
use App\Http\Requests\PostRequest\HandleTutorRequest;
use App\Http\Requests\PostRequest\PostEditorRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller {
    //

    public  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getOwnPosts() {

        $collection = PostResource::collection(
            $this->currentUser
                ->posts()
                ->orderBy('created_at', 'desc')
                ->with(['applicants', 'tutor', 'user'])
                ->paginate(15)
        );
        $collection->wrap('posts');
        return $collection;
    }

    public function getRecommendedPosts() {
        $subjectIds = $this->currentUser->subjects()->get(['id'])->toArray();

        $collection = PostResource::collection(
            Post::whereIn('subject_id', $subjectIds)
                ->orderBy('created_at', 'desc')
                ->with(['applicants', 'tutor', 'user'])
                ->paginate(15)
        );

        $collection->wrap('posts');
        return $collection;
    }

    public function getAllPosts() {
        $collection = PostResource::collection(
            Post::orderBy('created_at', 'desc')
                ->with(['applicants', 'tutor', 'user'])
                ->paginate(15)
        );
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
        ]);

        return new PostResource($post);
    }

    public function addPostApplicant(AddPostApplicantsRequest $request, Post $post) {
        $applicant = User::find($request->input('userId'));
        $post->applicants()->syncWithoutDetaching($applicant->id);

        event(new NewApplicantEvent($post, $applicant));
        return response()->json([
            'message' => 'Successfully added applicant',
        ]);
    }

    public function handleTutor(HandleTutorRequest $request, Post $post) {

        $userId = $request->input('userId');
        $action = $request->input('action');

        if ($action == 'accept') {
            $post->update([
                'tutor_id' => $userId,
            ]);
        } else if ($action == 'decline') {
            $post->update([
                'tutor_id' => null,
            ]);
        }

        return response()->json([
            'message' => 'Successfully',
        ]);
    }
}
