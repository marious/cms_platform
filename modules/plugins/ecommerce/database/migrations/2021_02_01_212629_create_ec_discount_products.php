<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcDiscountProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_discount_products', function (Blueprint $table) {
            $table->bigInteger('discount_id', false, true);
            $table->bigInteger('product_id', false, true);
            $table->primary(['discount_id', 'product_id']);

            $table->foreign('discount_id')->references('id')->on('ec_discounts');
            $table->foreign('product_id')->references('id')->on('ec_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_discount_products');
    }
}
