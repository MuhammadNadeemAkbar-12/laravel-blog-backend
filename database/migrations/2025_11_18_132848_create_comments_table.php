<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade'); // foreign key to tasks
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // foreign key to users
            $table->text('comment_text'); // comment text
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
