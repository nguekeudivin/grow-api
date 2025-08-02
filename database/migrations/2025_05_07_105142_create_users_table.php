<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Identity Info
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password');

            // Current Residence (foreign keys)
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('origin_location_id')->references('id')->on('locations')->nullOnDelete();


            // Profile
            $table->string('photo')->nullable(); // profile picture path or URL
            $table->text('about')->nullable();

            // Language Preference (FK)
            $table->unsignedBigInteger('language_id')->nullable();

            // Verification
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('verified_at')->nullable(); // admin or system identity verification
            $table->rememberToken();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('language_id')->references('id')->on('languages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
