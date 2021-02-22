<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductWithAttributeSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_with_attribute_set', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->mediumInteger('attribute_set_id')->unsigned()->index();
            $table->bigInteger('product_id')->unsigned()->index();
            $table->tinyInteger('order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('ec_products');
            $table->foreign('attribute_set_id')->references('id')->on('ec_product_attribute_sets');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_product_with_attribute_set');
    }
}
