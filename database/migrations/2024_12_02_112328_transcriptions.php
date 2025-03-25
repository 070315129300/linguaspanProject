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
        Schema::create('transcriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('userId')->nullable();
            $table->integer('write_id')->nullable();
            $table->integer('speak_id')->nullable();
            $table->string('fileName')->nullable();
            $table->string('fileurl')->nullable();
            $table->enum('type',['write','speak','listen','review'])->default('speak');
            $table->string('language')->nullable();
            $table->string('quality')->nullable();
            $table->string('hours')->nullable();
            $table->string('sentence_domain')->nullable();
            $table->text('sentence')->nullable();
            $table->text('review', 8, 2)->nullable();
            $table->integer('updatedby-userId')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcriptions');
    }
};
