<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('status', ['pending', 'completed', 'cancelled', 'returned'])->default('pending');
            $table->enum('fulfillment_status', ['unfulfilled', 'fulfilled'])->default('unfulfilled');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_session_id')->nullable(); // NOTE - May be this cannot be nullable
            $table->string('payment_session_url')->nullable(); // NOTE - May be this cannot be nullable
            $table->string('payment_intent_id')->nullable();
            $table->decimal('shipping_price', 10, 2)->default(0.00);
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('state')->nullable();
            $table->foreignUlid('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
