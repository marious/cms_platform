<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcShippingRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_shipping_rules', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 120);
            $table->mediumInteger('shipping_id')->unsigned();
            $table->enum('type', ['base_on_price', 'base_on_weight'])->default('base_on_price')->nullable();
            $table->smallInteger('currency_id')->unsigned()->nullable();
            $table->decimal('from', 15, 2)->default(0)->nullable();
            $table->decimal('to', 15, 2)->default(0)->nullable();
            $table->decimal('price', 15, 2)->default(0)->nullable();
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
        Schema::dropIfExists('ec_shipping_rules');
    }
}
