<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('user_id');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 8);
            $table->string('status')->default('pending');
            $table->string('ipn_token')->nullable();
            $table->string('txid_in')->nullable();
            $table->string('txid_out')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
