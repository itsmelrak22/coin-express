<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->tinyInteger('never_admin')->default(1)->after('email');
            $table->tinyInteger('is_agent')->default(1)->after('never_admin');
            $table->string('invitation_code')->nullable()->after('is_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('never_admin');
            $table->dropColumn('is_agent');
            $table->dropColumn('invitation_code');
        });
    }
}
