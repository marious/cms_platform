<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcProductCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_product_collections', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->json('name');
//            $table->string('slug');
            $table->json('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('status', 40)->default('published');
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
        Schema::dropIfExists('ec_product_collections');
    }
}
