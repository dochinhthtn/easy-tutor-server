<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UpdateProfileRequest;
use App\Http\Requests\UserRequest\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {

    public  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getInfo() {
        return new UserResource($this->currentUser);
    }

    public function getSubjects() {
        $collection = SubjectResource::collection($this->currentUser->subjects()->get());
        $collection->wrap('subjects');
        return $collection;
    }

    public function updateSubjects(UpdateSubjectRequest $request) {
        $add = $request->input('add');
        if ($add != null) {
            $this->currentUser->subjects()->syncWithoutDetaching($add);
        }

        $remove = $request->input('remove');
        if ($remove != null) {
            $this->currentUser->subjects()->detach($remove);
        }

        return response()->json([
            'message' => 'Update subjects successfully',
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $profile = $this->currentUser->profile()->firstOrNew();

        $profile->user_id = $this->currentUser->id;
        $profile->sex = $request->input('sex');
        $profile->address = $request->input('address');
        $profile->achievements = json_encode($request->input('achivements', []));
        if ($request->has('avatar')) {
            $profile->avatar = $this->uploadAvatar($request->file('avatar'));
        }
        $profile->save();

        return response()->json([
            'message' => 'Update profile successfully',
        ]);
    }

    public function uploadAvatar(UploadedFile $image) {
        Storage::disk("local")->put("public/", $image);
        return asset("storage/{$image->hashName()}");
    }

    public function getProfile(?User $user = null) {
        if ($user == null) {
            return new UserResource($this->currentUser->load('profile'));
        } else {
            return new UserResource($user->load('profile'));
        }
    }
}
