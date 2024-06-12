<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessSubmission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubmissionController extends Controller
{
    public function submit(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data input',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // Dispatch job
        try {
            ProcessSubmission::dispatch($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Submission is being processed'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error dispatching job', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your submission'
            ], 500); // 500 Internal Server Error
        }
    }
}
