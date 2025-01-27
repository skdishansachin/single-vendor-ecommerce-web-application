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
        Schema::create('carts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id'); // INFO - Makeing this nullable able to implement guest cart
            $table->enum('type', ['cart', 'order'])->default('cart');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->timestamps();
            // TODO - Add `shipping_address` and `billing_address`
        });

        Schema::create('cart_product', function (Blueprint $table) {
            $table->foreignUlid('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('purchase_price')->default(0.00);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2)->default(0.00);

            $table->unique(['cart_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_product');
    }
};
