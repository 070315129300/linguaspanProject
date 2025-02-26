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
            $table->integer('userId');
            $table->string('fileName');
            $table->enum('type',['write','speak','listen','review'])->default('speak');
            $table->string('language');
            $table->string('quality');
            $table->string('hours');
            $table->string('sentence_domain');
            $table->text('sentence')->nullable();
            $table->text('review', 8, 2);
            $table->integer('updatedby-userId');
            $table->string('status');
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
