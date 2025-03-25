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
            $table->integer('user_id')->nullable();
            $table->string('language', 50)->nullable();
            $table->integer('transcription_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->text('sentence')->nullable();
            $table->string('sentence_domain')->nullable();
            $table->string('citation')->nullable();
            $table->decimal('write_duration', 8, 2)->unsigned()->nullable();
            $table->boolean('flag')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('transcribed', ['1', '0'])->default('0');

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
