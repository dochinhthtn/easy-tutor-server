<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function addSubject() {

    }

    public function editSubject() {

    }

    public function findSubjects(string $keyword) {

    }
}
