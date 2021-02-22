<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120)->nullable();
            $table->string('code', 20)->unique()->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('total_used')->unsigned()->default(0);
            $table->double('value')->nullable();
            $table->string('type', 60)->default('coupon')->nullable();
            $table->boolean('can_use_with_promotion')->default(false);
            $table->string('discount_on', 20)->nullable();
            $table->integer('product_quantity', false, true)->nullable();
            $table->string('type_option', 100)->default('amount');
            $table->string('target', 100)->default('all-orders');
            $table->decimal('min_order_price', 15, 2)->nullable();
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
        Schema::dropIfExists('ec_discounts');
    }
}
