<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TranscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transcriptions')->insert([
            [
                'userId' => 1, // Ensure this user exists in the users table
                'fileName' => 'transcription_audio.mp3',
                'type' => 'speak',
                'language' => 'English',
                'quality' => 'high',
                'hours' => '2',
                'sentence_domain' => 'Education',
                'sentence' => 'This is a transcribed sentence.',
                'review' => 4.5,
                'updatedby-userId' => 3, // Ensure this user exists in the users table
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'userId' => 2,
                'fileName' => 'transcription_audio2.mp3',
                'type' => 'listen',
                'language' => 'French',
                'quality' => 'medium',
                'hours' => '1.5',
                'sentence_domain' => 'Linguistics',
                'sentence' => 'Le français est une belle langue.',
                'review' => 3.8,
                'updatedby-userId' => 4,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
