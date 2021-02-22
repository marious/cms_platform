<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductCollectionProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_collection_products', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->bigInteger('product_id')->unsigned()->index();
            $table->mediumInteger('product_collection_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('ec_products');
            $table->foreign('product_collection_id')->references('id')->on('ec_product_collections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_product_collection_products');
    }
}
