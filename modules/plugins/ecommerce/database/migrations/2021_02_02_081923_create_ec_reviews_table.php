<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->float('star');
            $table->string('comment');
            $table->string('status', 40)->default('published');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('ec_customers');
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
        Schema::dropIfExists('ec_reviews');
    }
}
