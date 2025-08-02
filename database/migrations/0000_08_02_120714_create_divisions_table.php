<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type')->nullable(); // e.g., region, department, arrondissement, commune, village
            $table->foreignId('parent_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['name', 'parent_id']); // Ensure unique name within the same parent division
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
