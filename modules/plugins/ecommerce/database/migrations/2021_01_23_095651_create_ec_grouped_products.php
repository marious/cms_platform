<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcGroupedProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_grouped_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_product_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('fixed_qty')->default(1);

            $table->foreign('parent_product_id')->references('id')->on('ec_products');
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
        Schema::dropIfExists('ec_grouped_products');
    }
}
