<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('speaks')->insert([
            [
                'user_id' => 1, // Ensure this user exists in the users table
                'language' => 'English',
                'file_name' => 'example_audio.mp3',
                'file_path' => 'uploads/audio/example_audio.mp3',
                'sentence_domain' => 'Education',
                'description' => 'Sample description for speaking test',
                'speak_duration' => 5.75,
                'hours' => 2,
                'flag' => false,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'language' => 'French',
                'file_name' => 'french_audio.mp3',
                'file_path' => 'uploads/audio/french_audio.mp3',
                'sentence_domain' => 'Business',
                'description' => 'French speaking practice',
                'speak_duration' => 7.20,
                'hours' => 3,
                'flag' => false,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
