<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id' => 1, // Ensure this user exists in the users table
                'transcription_id' => 1, // Ensure this transcription exists in the transcriptions table
                'language' => 'English',
                'file_name' => 'reviewed_english.mp3',
                'file_path' => 'uploads/reviews/reviewed_english.mp3',
                'sentence_domain' => 'Education',
                'sentence' => 'This is a well-transcribed English sentence.',
                'review_score' => 4.5,
                'flag' => false,
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'transcription_id' => 2,
                'language' => 'Spanish',
                'file_name' => 'reviewed_spanish.mp3',
                'file_path' => 'uploads/reviews/reviewed_spanish.mp3',
                'sentence_domain' => 'Business',
                'sentence' => 'The Spanish transcription requires minor corrections.',
                'review_score' => 3.8,
                'flag' => false,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
