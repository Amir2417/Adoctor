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
        Schema::create('branch_has_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("hospital_branch_id");
            $table->unsignedBigInteger("hospital_department_id");
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
        Schema::dropIfExists('branch_has_departments');
    }
};
