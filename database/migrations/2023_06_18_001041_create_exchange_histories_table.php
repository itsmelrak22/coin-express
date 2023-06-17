<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->integer('client_id');
            $table->string('inviter_email');
            $table->string('client_name');
            $table->string('exchange_name');
            $table->string('email');
            $table->float('prev_Asset')->nullable();
            $table->float('Asset')->nullable();
            $table->string('Amount');
            $table->string('invitation_code');
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
        Schema::dropIfExists('exchange_histories');
    }
}
