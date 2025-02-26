<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranscriptionRequest;
use App\Services\TranscriptionService;
use Illuminate\Http\Request;

class TranscriptionController extends Controller
{
    protected $transcriptionService;

    public function __construct(TranscriptionService $transcriptionService)
    {
        $this->transcriptionService = $transcriptionService;
    }

    // General Transcription Methods
    public function index()
    {
        return $this->transcriptionService->getAllTranscriptions();
    }

    public function store(TranscriptionRequest $request)
    {
        var_dump('cayleb');
        die();
        return $this->transcriptionService->createTranscription($request->validated());
    }

    // Speak API
    public function getSpeak()
    {
        return $this->transcriptionService->getTranscriptionsByType('speak');
    }

    public function createSpeak(TranscriptionRequest $request)
    {
        return $this->transcriptionService->createTranscription(array_merge($request->validated(), ['type' => 'speak']));
    }

    // Review API
    public function getReview()
    {
        return $this->transcriptionService->getAllReview();
    }


    public function createReview(TranscriptionRequest $request)
    {
        return $this->transcriptionService->createTranscription(array_merge($request->validated(), ['type' => 'review']));
    }
    public function updateReview(Request $request,$id)
    {
        return $this->transcriptionService->updateReview($request, $id);
    }

    public function getNextReview()
    {
        return $this->transcriptionService->getNextReview();
    }



    // Listen API
    public function getListen()
    {
        return $this->transcriptionService->getTranscriptionsByType('listen');
    }

    public function createListen(TranscriptionRequest $request)
    {
        return $this->transcriptionService->createTranscription(array_merge($request->validated(), ['type' => 'listen']));
    }

    // Write API
    public function getWrite()
    {
        return $this->transcriptionService->getTranscriptionsByType('write');
    }

    public function createWrite(TranscriptionRequest $request)
    {
        return $this->transcriptionService->createTranscription(array_merge($request->validated(), ['type' => 'write']));
    }

    // Reward API (assuming a separate table for rewards)
    public function getReward()
    {
        return $this->transcriptionService->getAllRewards();
    }

    public function createReward(Request $request)
    {
        return $this->transcriptionService->createReward($request->all());
    }

}
