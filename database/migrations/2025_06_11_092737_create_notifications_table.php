<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // The user who receives the notification
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relationship to the entity generating the notification
            $table->morphs('notifiable'); // notifiable_id, notifiable_type

            // Notification content
            $table->string('title');
            $table->string('content');
            $table->string('link')->nullable();

            // Read status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable(); // ← needs to be nullable

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
