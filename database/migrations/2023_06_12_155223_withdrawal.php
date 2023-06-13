<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Withdrawal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal', function (Blueprint $table) {
            $table->id();
            $table->string('OrderNumber')->nullable();
            $table->string('UserID')->nullable();
            $table->string('UserAccount')->nullable();
            $table->string('Type')->nullable();
            $table->string('Amount')->nullable();
            $table->string('State')->nullable();
            $table->string('Methods')->nullable();
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
        Schema::dropIfExists('withdrawal');
    }
}
