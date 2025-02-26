<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(AdminAccountsSeeder::class);
        $this->call(SpeakSeeder::class);
        $this->call(ListenSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(WriteSeeder::class);
        $this->call(TransciptionsSeeder::class);

    }
}
