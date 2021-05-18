<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest\RateEditorRequest;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use App\Models\User;

class RateController extends Controller {
    //

    private  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getTutorRates(User $tutor) {
        if(!$tutor->checkRole('tutor')) {
            return response()->json([
                'message' => 'This user is not a tutor'
            ], 400);
        }

        return RateResource::collection($tutor->rates()->with('assessor')->get());
    }

    public function addRate(RateEditorRequest $request) {
        $rate = Rate::factory()->create([
            'assessor_id' => $request->input('assessorId'),
            'tutor_id' => $request->input('tutorId'),
            'star' => $request->input('star'),
            'comment' => $request->input('comment')
        ]);

        return new RateResource($rate);
    }
}
