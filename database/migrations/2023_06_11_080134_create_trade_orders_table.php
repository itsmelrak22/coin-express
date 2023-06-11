<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_orders', function (Blueprint $table) {
            $table->id();
            $table->string('User_code');
            $table->string('user_account');
            $table->string('contract');
            $table->string('type');
            $table->string('seconds');
            $table->string('trading');
            $table->string('quantity');
            $table->string('preset')->nullable();
            $table->string('result')->nullable();
            $table->string('profit');
            $table->string('opening_price');
            $table->string('closing_price');
            $table->string('order_time');
            $table->string('closing_time')->nullable();
            $table->string('Updated_by')->nullable();
            $table->string('complete_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_orders');
    }
}
