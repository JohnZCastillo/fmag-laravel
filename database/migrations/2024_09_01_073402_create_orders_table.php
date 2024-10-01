<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->string('reference')->index()->nullable();
            $table->boolean('refunded')->default(false);
            $table->enum('status', [
                \App\Enums\OrderStatus::PENDING->value,
                \App\Enums\OrderStatus::COMPLETED->value,
                \App\Enums\OrderStatus::FAILED->value,
                \App\Enums\OrderStatus::CANCELLED->value,
                \App\Enums\OrderStatus::DELIVERY->value,
            ]);
            $table->enum('state', [
                \App\Enums\OrderState::PENDING->value,
                \App\Enums\OrderState::PAYMENT->value,
                \App\Enums\OrderState::PROCESSING->value,
                \App\Enums\OrderState::COMPLETED->value,
            ]);
            $table->enum('checkout_type', [
                \App\Enums\CheckoutType::CART->value,
                \App\Enums\CheckoutType::PRODUCT->value,
            ]);
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
