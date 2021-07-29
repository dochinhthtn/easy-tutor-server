<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UpdateProfileRequest;
use App\Http\Requests\UserRequest\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\Profile;
use App\Models\User;
use App\Enums\EProfileFileType;

class UserController extends Controller {

    public  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getInfo($id = 0) {
        $user = User::find($id);

        if(empty($user)) {
            $user = $this->currentUser;
        }

        return new UserResource($user->load('profile'));
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
        $profile->save();

        if($request->has('achievements') && !empty($request->input('achievements'))) {
            File::query()->whereIn('id', $request->input('achievements'))->update([
                'type' => EProfileFileType::ACHIEVEMENT,
                'model_type' => Profile::class,
                'model_id' => $profile->id
            ]);
        }

        if($request->has('avatar') && !empty($request->input('avatar'))) {
            File::find($request->input('avatar'))->update([
                'type' => EProfileFileType::AVATAR,
                'model_type' => Profile::class,
                'model_id' => $profile->id
            ]);
        }

        return response()->json([
            'message' => 'Update profile successfully',
        ]);
    }

    public function getProfile(?User $user = null) {
        if ($user == null) {
            return new UserResource($this->currentUser->load(['profile', 'profile.avatar', 'profile.achievements', 'subjects']));
        } else {
            return new UserResource($user->load(['profile', 'profile.avatar', 'profile.achievements', 'subjects']));
        }
    }
}
