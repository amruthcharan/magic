<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->string('sdk_url')->nullable();
            $table->boolean('is_identity_enabled')->default(true);
            $table->boolean('is_idl_aync')->default(false);
            $table->boolean('is_idl_optimised')->default(true);
            $table->string('identity_url')->nullable();
            $table->string('cookie_key')->nullable();
            $table->integer('cache_time')->default(60);
            $table->string('active_theme_id')->nullable();
            $table->integer('id_type')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_configs');
    }
}
