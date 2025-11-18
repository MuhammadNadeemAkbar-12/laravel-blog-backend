<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('is_deleted')->default(0); // optional if you use softDeletes
            $table->timestamps(); // created_at + updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
