<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('project_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('name');
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->decimal('budget', 12, 2)->default(0);
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->tinyInteger('status')->default(0); // status=0; in_progress=1; completed=2;
            $table->timestamps();

            $table->unique(['project_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_phases');
    }
};
