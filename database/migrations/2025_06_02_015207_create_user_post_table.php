<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->text('post_content')->nullable();
            $table->enum('restriction_type', ['public', 'friends-only', 'private'])->default('public');
            $table->unsignedBigInteger('post_like_count')->default(0);
            $table->unsignedBigInteger('post_comment_count')->default(0);
            $table->datetime('post_created_at');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_post');
    }
};
