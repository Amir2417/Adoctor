<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("doctor_id");
            $table->unsignedBigInteger("schedule_id");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string('slug');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('age');
            $table->string('type')->comment('Appointment Type');
            $table->string('gender');
            $table->text('message')->nullable();
            $table->integer('patient_number');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign("doctor_id")->references("id")->on("doctors")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("schedule_id")->references("id")->on("doctor_has_schedules")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_appointments');
    }
};
