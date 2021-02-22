<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcDiscountCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_discount_customers', function (Blueprint $table) {
            $table->bigInteger('discount_id', false, true);
            $table->integer('customer_id', false, true);
            $table->primary(['discount_id', 'customer_id']);

            $table->foreign('discount_id')->references('id')->on('ec_discounts');
            $table->foreign('customer_id')->references('id')->on('ec_customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_discount_customers');
    }
}
