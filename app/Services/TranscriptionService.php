<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Transcription;
use App\Models\Reward;
use App\Models\Write;
use Illuminate\Support\Facades\DB;

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
            // Create Transcription
            $transcription = Transcription::create([
                'user_id' => $data['user_id'] ?? null,
                'language' => $data['language'] ?? null,
                'type' => $data['type'] ?? null,
                'file_name' => $data['file_name'] ?? null,
                'file_path' => $data['file_path'] ?? null,
                'sentence' => $data['sentence'] ?? null,
                'sentence_domain' => $data['sentence_domain'] ?? null,
                'citation' => $data['citation'] ?? null,
            ]);

            // Create Review
            $review = Review::create([
                'user_id' => $data['user_id'] ?? null,
                'transcription_id' => $transcription->id,
                'language' => $data['language'] ?? null,
                'file_name' => $data['file_name'] ?? null,
                'file_path' => $data['file_path'] ?? null,
                'sentence_domain' => $data['sentence_domain'] ?? null,
                'sentence' => $data['sentence'] ?? null,
                'flag' => $data['flag'] ?? false,
                'status' => $data['status'] ?? 'pending',
            ]);

            // Create Write
            $write = Write::create([
                'user_id' => $data['user_id'] ?? null,
                'language' => $data['language'] ?? null,
                'file_name' => $data['file_name'] ?? null,
                'file_path' => $data['file_path'] ?? null,
                'sentence' => $data['sentence'] ?? null,
                'sentence_domain' => $data['sentence_domain'] ?? null,
                'citation' => $data['citation'] ?? null,
                'flag' => $data['flag'] ?? false,
                'status' => $data['status'] ?? 'pending',
            ]);

            return [
                'transcription' => $transcription,
                'review' => $review,
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
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->update(['status' => $request->status]);

        return response()->json(['message' => 'Review updated successfully']);
    }

    public function getAllReview()
    {
        $reviews = Review::whereNull('status')
            ->orWhereIn('status', ['pending', 'rejected'])
            ->inRandomOrder() // Shuffle results at the query level
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function getNextReview()
    {
        $review = Review::whereNull('status')
            ->orWhere('status', 'pending')
            ->inRandomOrder() // Shuffle results
            ->first();

        if (!$review) {
            return response()->json(['message' => 'No more reviews available']);
        }

        return response()->json($review);
    }

}
