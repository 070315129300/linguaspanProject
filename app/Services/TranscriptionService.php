<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Transcription;
use App\Models\Reward;
use App\Models\Write;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TranscriptionService
{
    public function getAllTranscriptions()
    {
        return Transcription::all();
    }

    public function getTranscriptionsByType($type)
    {
        return Transcription::where('type', $type)->get();
    }



    public function createTranscription($data)
    {
        return DB::transaction(function () use ($data) {
            $language = $data['language'] ?? 'default';

            // Fetch the latest file name for the given language
            $lastFile = Write::where('language', $language)
                ->orderBy('created_at', 'desc')
                ->first();

            // Extract and increment the file number
            if ($lastFile && preg_match('/file_(\d+)\.txt/', $lastFile->file_name, $matches)) {
                $nextFileNumber = str_pad($matches[1] + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $nextFileNumber = '01'; // Start from 01 if no previous file
            }

            $fileName = "file_{$nextFileNumber}.txt";

            // Create Write
            $write = Write::create([
                'user_id' => $data['user_id'] ?? null,
                'language' => $language,
                'file_name' => $fileName,
                'file_path' => "",
                'sentence' => $data['sentence'] ?? null,
                'sentence_domain' => $data['sentence_domain'] ?? null,
                'citation' => $data['citation'] ?? null,
                'flag' => $data['flag'] ?? false,
                'status' => $data['status'] ?? 'pending',
            ]);

            return [
                'success' => true,
                'write' => $write,
            ];
        });
    }

    public function getAllRewards()
    {
        return Reward::all();
    }

    public function createReward($data)
    {
        return Reward::create($data);
    }

    public function updateReview($request, $id)
    {
        $review = Write::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $filePath = null; // Keep this null unless uploading

        if ($request->status === 'approved') {
            $language = $review->language ?? 'default'; // Ensure language exists
            $fileName = $review->file_name ?? "default_file.txt"; // Get filename from Write table
            $sentence = $review->sentence ?? ''; // Get sentence from Write table

            // Define AWS S3 path with subfolders (e.g., english/reviews/myfile.txt)
            $filePath = "{$language}/reviews/{$fileName}";

            // Upload text file to S3 (DO NOT save file path in DB)
            Storage::disk('s3')->put($filePath, $sentence, 'public');
        }

        // ✅ Update the `Write` table but DO NOT store the `file_path`
        $review->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Review updated and sentence uploaded to AWS successfully',
            's3_path' => $request->status === 'approved' ? $filePath : null
        ]);
    }


    public function getAllReview()
    {
       // $language = $request->query('language'); // Get language from request

        $query = Write::whereNull('status')
            ->orWhereIn('status', ['pending']);

        $reviews = $query->inRandomOrder()->get();

        return view('reviews.index', compact('reviews'));
    }

    public function getNextReview()
    {
        $language = request()->query('language'); // Fetch language from query parameters



        $query = Write::whereNull('status')
            ->orWhere('status', 'pending');

        // Apply language filter if selected
        if ($language) {
            $query->where('language', $language);
        }

        $review = $query->inRandomOrder()->first(); // Fetch a random review

        if (!$review) {
            return response()->json(['message' => 'Not available'], 404);
        }

        return response()->json([
            'id'       => $review->id,
            'sentence' => $review->sentence, // Ensure the column name is correct
            'status'   => $review->status,
            'language' => $review->language
        ]);
    }


}
