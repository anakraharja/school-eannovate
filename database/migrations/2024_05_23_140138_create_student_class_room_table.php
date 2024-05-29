<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('student_id')->autoIncrement(false);
            $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('class_id')->autoIncrement(false);
            $table->foreign('class_id')->references('id')->on('class')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('created_by')->autoIncrement(false);
            $table->foreign('created_by')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_class');
    }
}
