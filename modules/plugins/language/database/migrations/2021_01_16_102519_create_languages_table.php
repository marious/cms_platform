<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->mediumIncrements('lang_id');
            $table->string('lang_name', 50);
            $table->string('lang_locale', 20);
            $table->string('lang_code', 20);
            $table->string('lang_flag', 20)->nullable();
            $table->tinyInteger('lang_is_default')->unsigned()->default(0);
            $table->smallInteger('lang_order')->default(0);
            $table->tinyInteger('lang_is_rtl')->unsigned()->default(0);
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
        Schema::dropIfExists('languages');
    }
}
