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
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('birth_date')->nullable();
            $table->string('password');

            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('origin_location_id')->nullable();

            // Current Residence (foreign keys)
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('origin_location_id')->references('id')->on('locations')->nullOnDelete();

            // Profile
            $table->text('about')->nullable();

            // Verification
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('verified_at')->nullable(); // admin or system identity verification
            $table->rememberToken();
            $table->timestamps();

            // Foreign Key Constraints
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
