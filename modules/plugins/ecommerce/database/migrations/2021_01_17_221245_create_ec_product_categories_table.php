<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_categories', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name');
            $table->mediumInteger('parent_id')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('status', 40)->default('published');
            $table->mediumInteger('order')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->tinyInteger('is_featured')->unsigned()->default(0);
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
        Schema::dropIfExists('ec_product_categories');
    }
}
