<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['language' => 'English', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['language' => 'French', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['language' => 'Yoruba', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['language' => 'Igbo', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['language' => 'Hausa', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['language' => 'Swahili', 'status' => '1', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('languages')->insert($languages);
    }
}
