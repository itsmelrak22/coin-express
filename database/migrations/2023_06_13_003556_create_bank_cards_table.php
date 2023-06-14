<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cards', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('UserID')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('bankdeposit')->nullable();
            $table->string('depositbranch')->nullable();
            $table->string('bankaccount')->nullable();
            $table->string('ifsc')->nullable();
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
        Schema::dropIfExists('bank_cards');
    }
}
