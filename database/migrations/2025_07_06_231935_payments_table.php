<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contribution_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->tinyInteger('method'); // 1=ORANGE_MONEY 2=MTN_MOMO
            $table->decimal('amount', 10, 2);
            $table->string('phone_number');
            $table->string('transaction_id')->nullable();
            $table->tinyInteger('status'); // 0=pending,1=completed,2=failed.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
