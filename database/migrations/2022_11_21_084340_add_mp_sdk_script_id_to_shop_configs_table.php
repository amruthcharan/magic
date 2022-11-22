<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMpSdkScriptIdToShopConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_configs', function (Blueprint $table) {
            $table->string('mp_sdk_script_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_configs', function (Blueprint $table) {
            $table->dropColumn('mp_sdk_script_id');
        });
    }
}
