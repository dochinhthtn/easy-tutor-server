<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller {

    protected ?User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function uploadFile(Request $request) {

        if ($request->hasFile('file')) {
            // dd($request->file('file'));
            return new FileResource($this->saveFile($request->file('file')));
        }

        return response()->json([
            'message' => 'File upload not found'
        ], 400);
    }

    public function uploadMultipleFiles(Request $request) {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $fileCollection = array_map(function ($uploadedFile) {
            return $this->saveFile($uploadedFile);
        }, $request->allFiles()['files']);

        return response()->json([
            'files' => $fileCollection
        ]);
    }

    protected function saveFile(UploadedFile $file) {
        $hashName = $file->hashName();
        Storage::put('public/', $file);
        $file = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => asset('storage/' . $hashName),
            'user_id' => $this->currentUser->id
        ]);

        return $file;
    }
}
