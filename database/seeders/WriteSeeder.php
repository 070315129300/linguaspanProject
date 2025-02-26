<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('writes')->insert([
            [
                'user_id' => 1, // Ensure this user exists in the users table
                'language' => 'English',
                'file_name' => 'written_english.docx',
                'file_path' => 'uploads/writes/written_english.docx',
                'sentence' => 'This is a well-written English sentence.',
                'sentence_domain' => 'Education',
                'citation' => 'Doe, J. (2024). Academic Writing Guide',
                'write_duration' => 12.5,
                'flag' => false,
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'language' => 'French',
                'file_name' => 'written_french.docx',
                'file_path' => 'uploads/writes/written_french.docx',
                'sentence' => 'Le français est une belle langue.',
                'sentence_domain' => 'Linguistics',
                'citation' => 'Dupont, M. (2023). French Grammar Essentials',
                'write_duration' => 8.3,
                'flag' => true,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
