<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeScreenshotColumnInDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('Screenshot');
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('Screenshot')->after('Amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('Screenshot');
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('Screenshot');
        });
    }
}
