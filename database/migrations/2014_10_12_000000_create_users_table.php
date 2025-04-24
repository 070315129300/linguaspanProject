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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('sex')->nullable();
            $table->string('profession')->nullable();
            $table->string('language')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('nationality')->nullable();
            $table->text('address')->nullable();
            $table->enum('role',['admin','agent','user'])->default('user');
            $table->enum('status',['active','inactive'])->default('active'); 
            $table->string('balance')->nullable();
            $table->string('otp')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
