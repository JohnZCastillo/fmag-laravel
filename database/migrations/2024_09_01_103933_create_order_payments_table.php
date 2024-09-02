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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0);
            $table->foreignId('order_id')->index()->constrained();
            $table->boolean('verified')->default(false);
            $table->enum('payment_method', [
                \App\Enums\PaymentMethod::CASH->value,
                \App\Enums\PaymentMethod::GCASH->value,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
