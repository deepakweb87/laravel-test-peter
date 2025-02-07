<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function store(StoreSubmissionRequest $request)
    {
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('images', 'Files');
            }
        }

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePaths[] = $file->store('documents', 'Files');
            }
        }

        $submission = Submission::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'street' => $request->street,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'images' => json_encode($imagePaths),
            'files' => json_encode($filePaths),
        ]);

        return response()->json(['message' => 'Submission successful!', 'submission' => $submission]);
    }

}
