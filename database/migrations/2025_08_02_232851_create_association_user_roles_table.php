<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('association_user_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('association_user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('role_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['association_user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('association_user_roles');
    }
};
