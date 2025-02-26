<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Transcription;
use App\Models\Reward;

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
        return Transcription::create($data);
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
            ->get()
            ->shuffle();




        return view('reviews.index', compact('reviews'));
    }

    public function getNextReview()
    {
        $review = Review::whereNull('status')
            ->orWhereIn('status', ['pending'])
            ->first();

        if (!$review) {
            return response()->json(['message' => 'No more reviews available']);
        }

        return response()->json($review);
    }
}
