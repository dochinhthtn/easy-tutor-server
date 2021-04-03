<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest\SubjectEditorRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;

class SubjectController extends Controller {
    //

    public function getSubjects() {
        return SubjectResource::collection(Subject::paginate(15));
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

    public function findSubjects(string $keyword) {
        $query = Subject::whereRaw("name LIKE '%$keyword%'")->paginate(15);
        return SubjectResource::collection($query);
    }
}
