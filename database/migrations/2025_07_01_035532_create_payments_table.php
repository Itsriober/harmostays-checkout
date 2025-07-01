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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('property_name');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->text('booking_details');
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('USDC');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
