<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'fileName' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'quality' => 'required|string',
            'hours' => 'required|numeric',
            'sentence_domain' => 'required|string|max:255',
            'sentence' => 'nullable|string',
            'review' => 'nullable|numeric|min:0|max:5',
            'updated_by_user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }
}
