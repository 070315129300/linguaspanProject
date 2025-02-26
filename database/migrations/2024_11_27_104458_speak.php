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
        Schema::create('speaks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained('users')->onDelete('cascade');
            $table->string('language', 50);
            $table->string('file_name');
            $table->string('file_path');
            $table->string('sentence_domain');
            $table->text('description')->nullable();
            $table->decimal('speak_duration', 8, 2)->unsigned();
            $table->integer('hours')->unsigned();
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
        Schema::dropIfExists('speaks');
    }
};
