<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest\SubjectEditorRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubjectController extends Controller {
    //

    public function getSubjects(Request $request) {
        $query = Subject::query();
        $this->attachSearch($query, $request);
        $collection = SubjectResource::collection($query->paginate(15));
        $collection->wrap('subjects');
        return $collection;
    }

    public function getSubject(Subject $subject) {
        return new SubjectResource($subject);
    }

    public function addSubject(SubjectEditorRequest $request) {
        Subject::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'message' => 'Create subject successfully'
        ]);
    }

    public function editSubject(SubjectEditorRequest $request, Subject $subject) {
        $subject->name = $request->input('name');
        $subject->save();
        return response()->json([
            'message' => 'Update subject successfully'
        ]);
    }

    public function attachSearch(Builder $query, Request $request) {
        $keyword = $request->query('keyword');
        if(!empty($keyword)) $query->where('name', 'like', "%$keyword%");
        return $query;
    }
}
