<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('listens')->insert([
            [
                'user_id' => 1, // Ensure this user exists in the users table
                'language' => 'English',
                'file_name' => 'english_audio.mp3',
                'file_path' => 'uploads/audio/english_audio.mp3',
                'sentence_domain' => 'Education',
                'description' => 'Listening practice for English learners',
                'audio_duration' => 3.45,
                'hours' => 2,
                'flag' => false,
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'language' => 'Spanish',
                'file_name' => 'spanish_audio.mp3',
                'file_path' => 'uploads/audio/spanish_audio.mp3',
                'sentence_domain' => 'Business',
                'description' => 'Spanish listening comprehension',
                'audio_duration' => 5.20,
                'hours' => 3,
                'flag' => false,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
