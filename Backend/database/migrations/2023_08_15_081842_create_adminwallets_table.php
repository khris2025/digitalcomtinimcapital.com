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
        Schema::create('adminwallets', function (Blueprint $table) {
            $table->id();
            $table->string('btc_address_bitcoin');
            $table->string('btc_address_bep20');

            $table->string('eth_address_erc20');
            $table->string('eth_address_bep20');

            $table->string('usdt_address_trc20');
            $table->string('usdt_address_bep20');
            $table->string('usdt_address_erc20');


            $table->string('Phrase_min_amount');
            $table->string('daily_earning');



            $table->string('btc_address_bitcoin_qr');
            $table->string('btc_address_bep20_qr');
            $table->string('eth_address_erc20_qr');
            $table->string('eth_address_bep20_qr');
            $table->string('usdt_address_trc20_qr');
            $table->string('usdt_address_bep20_qr');
            $table->string('usdt_address_erc20_qr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adminwallets');
    }
};
