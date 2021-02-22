<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcDiscountProductCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_discount_product_collections', function (Blueprint $table) {
            $table->bigInteger('discount_id', false, true);
            $table->mediumInteger('product_collection_id', false, true);
            $table->primary(['discount_id', 'product_collection_id'], 'discount_product_collections_primary_key');

            $table->foreign('discount_id')->references('id')->on('ec_discounts');
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
        Schema::dropIfExists('ec_discount_product_collections');
    }
}
