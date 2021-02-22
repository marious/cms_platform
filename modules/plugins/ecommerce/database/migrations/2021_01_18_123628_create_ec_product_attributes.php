<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('attribute_set_id')->unsigned();
            $table->json('title');
            $table->json('slug')->nullable();
            $table->string('color', 50);
            $table->string('image');
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->tinyInteger('order')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();

            $table->foreign('attribute_set_id')
                    ->references('id')
                    ->on('ec_product_attribute_sets')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_product_attributes');
    }
}
