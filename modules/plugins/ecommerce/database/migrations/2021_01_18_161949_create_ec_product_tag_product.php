<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductTagProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_tag_product', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->bigInteger('product_id')->unsigned()->index();
            $table->mediumInteger('tag_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('ec_products');
            $table->foreign('tag_id')->references('id')->on('ec_product_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_product_tag_product');
    }
}
