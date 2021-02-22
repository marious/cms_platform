<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_meta', function (Blueprint $table) {
            $table->mediumIncrements('lang_meta_id');
            $table->mediumInteger('reference_id')->unsigned()->index();
            $table->string('reference_type', 120);
            $table->text('lang_meta_code')->nullable();
            $table->string('lang_meta_origin', 255);
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
        Schema::dropIfExists('language_meta');
    }
}
