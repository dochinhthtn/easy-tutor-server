<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller {
    //

    public User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getOwnPosts() {
        $query = $this->currentUser->posts()->orderBy('created_at', 'desc');
        return PostResource::collection($query->paginate(15));
    }

    public function getRecommendedPosts() {
        $subjectIds = $this->currentUser->subjects()->get(['id'])->toArray();
        $query = Post::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc');
        return PostResource::collection($query->paginate(15));
    }

    public function getAllPosts() {
        return PostResource::collection(Post::orderBy('created_at', 'desc')->paginate(15));
    }

    public function getPost(Post $post) {
        return new PostResource($post->with('applicants'));
    }

    public function addPost() {

    }

    public function editPost() {

    }

    public function applyPost() {

    }

}
