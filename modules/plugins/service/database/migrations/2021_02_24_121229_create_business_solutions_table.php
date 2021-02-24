<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_solutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('icon', 100);
            $table->text('description');
            $table->text('content');
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
        Schema::dropIfExists('business_solutions');
    }
}
