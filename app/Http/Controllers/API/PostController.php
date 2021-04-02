<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest\PostEditorRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller {
    //

    public ?User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getOwnPosts() {
        $query = $this->currentUser->posts()->orderBy('created_at', 'desc');
        return PostResource::collection($query->paginate(15));
    }

    public function getRecommendedPosts() {
        $subjectIds = $this->currentUser->subjects()->get(['id'])->toArray();
        $query = Post::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->with('user');
        return PostResource::collection($query->paginate(15));
    }

    public function getAllPosts() {
        return PostResource::collection(Post::orderBy('created_at', 'desc')->with('user')->paginate(15));
    }

    public function getPost(Post $post) {
        return new PostResource($post->with('applicants'));
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
        if($post->user_id != $this->currentUser->id) {
            return response()->json([
                'message' => 'You are not owned this post'
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

    public function applyPost(Post $post) {
        if($this->currentUser != '2') {
            return response()->json([
                'message' => 'You are not a tutor'
            ], 401);
        }

        $appliedPosts = $this->currentUser->appliedPosts()->where('post_id', '=', $post->id)->get();
        if($appliedPosts->count() > 0) {
            return response()->json([
                'message' => 'You have already applied this post'
            ], 403);
        } else {
            $this->currentUser->appliedPosts()->attach($post->id);
            return response()->json([
                'message' => 'Successfully applied this post'
            ]);
        }
    }

    public function acceptTutor(Post $post, User $user) {

        if($user->role_id != 2) {
            return response()->json([
                'message' => 'User is not a tutor'
            ], 403);
        }

        $post->update([
            'tutor_id' => $user->id 
        ]);

        return response()->json([
            'message' => 'Successfully accepted tutor'
        ]);
    }

}
