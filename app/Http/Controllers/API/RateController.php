<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest\EvaluateRequest;
use App\Http\Requests\RateRequest\RateEditorRequest;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RateController extends Controller {
    //

    private  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getTutorRates(User $user) {
        if(!$user->checkRole('tutor')) {
            return response()->json([
                'message' => 'This user is not a tutor'
            ], 400);
        }

        $result = DB::table('rates')
            ->selectRaw('COUNT(id) AS rateCount')
            ->selectRaw('AVG(star) AS avgStar')
            ->where('tutor_id', $user->id)
            ->groupBy('tutor_id')
            ->first();
        
        return response()->json($result);
    }

    public function getTutorRatesDetail(User $user) {
        if(!$user->checkRole('tutor')) {
            return response()->json([
                'message' => 'This user is not a tutor'
            ], 400);
        }

        $collection = RateResource::collection($user->rates()->with('assessor')->paginate(15));
        $collection->wrap('rates');
        return $collection;
    }
    
    public function evaluateTutor(EvaluateRequest $request, User $user) {
        if(!$user->checkRole('tutor')) {
            return response()->json([
                'message' => 'This user is not a tutor'
            ], 400);
        }

        //TODO: check if rate exist

        $rate = Rate::create([
            'assessor_id' => $this->currentUser->id,
            'tutor_id' => $user->id,
            'star' => $request->input('star'),
            'comment' => $request->input('comment')
        ]);

        return new RateResource($rate);
    }
}
