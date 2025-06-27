<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('amount_paid', 12, 2)->nullable()->after('amount');
            $table->string('payment_coin', 50)->nullable()->after('currency');
            $table->string('payment_address')->nullable()->after('ipn_token');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['amount_paid', 'payment_coin', 'payment_address']);
        });
    }
};
