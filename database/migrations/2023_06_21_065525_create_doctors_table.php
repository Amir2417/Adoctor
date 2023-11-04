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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("hospital_branch_id");
            $table->unsignedBigInteger("hospital_department_id");
            $table->string('slug');
            $table->string('name');
            $table->string('doctor_title')->nullable();
            $table->string('qualification');
            $table->string('speciality')->nullable();
            $table->string('language')->nullable();
            $table->string('designation');
            $table->string('contact');
            $table->string('floor_number')->nullable();
            $table->string('room_number')->nullable();
            $table->string('address')->nullable();
            $table->decimal('fees',28,8)->default(0);
            $table->string('off_days');
            $table->string('image')->nullable();
            $table->boolean("status")->default(true);
            $table->timestamps();

            $table->foreign("hospital_branch_id")->references("id")->on("hospital_branches")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("hospital_department_id")->references("id")->on("hospital_departments")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
