<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHsAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_phone', 20)->nullable();
            $table->string('patient_email', 150)->nullable();
            $table->dateTime('appointment_date');
            $table->unsignedBigInteger('department_id');
            $table->string('message', 255)->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('hs_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_appointments');
    }
}
