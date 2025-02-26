<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('writes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('language', 50);
            $table->string('file_name');
            $table->string('file_path');
            $table->text('sentence')->nullable();
            $table->string('sentence_domain');
            $table->string('citation')->nullable();
            $table->decimal('write_duration', 8, 2)->unsigned();
            $table->boolean('flag')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writes');
    }
};
