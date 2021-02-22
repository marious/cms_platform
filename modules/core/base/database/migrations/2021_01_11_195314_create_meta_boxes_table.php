<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_boxes', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('meta_key');
            $table->text('meta_value')->nullable();
            $table->integer('reference_id')->unsigned()->index();
            $table->string('reference_type', 120);
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
        Schema::dropIfExists('meta_boxes');
    }
}
