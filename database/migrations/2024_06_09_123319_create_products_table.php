<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(\App\Models\Collection::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('available')->default(0);
            $table->timestamps();

            $table->unique(['slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
