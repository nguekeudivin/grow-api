<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('status'); // active=1; inactive=0;
            $table->timestamps();

            $table->unique(['name', 'location_id']); // optional, enforce unique per location
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
