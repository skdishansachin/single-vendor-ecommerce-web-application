<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(\App\Models\User::class, 'sender_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->json('roles');
            $table->json('permissions')->nullable();
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancel'])->default('pending');
            $table->timestamps();

            $table->index(['email', 'token']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
