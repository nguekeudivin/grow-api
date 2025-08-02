<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('association_id')->constrained('associations')->cascadeOnDelete();
            $table->decimal('budget', 12, 2)->default(0);
            $table->tinyInteger('status')->default(0); // planned=0; ongoing=1; completed=2; cancelled=3;
            $table->timestamps();
            $table->unique(['name', 'association_id']); // optional uniqueness within association
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
