<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username',64)->unique();
            $table->string('email',256)->unique();
            $table->integer('age')->autoIncrement(false);
            $table->string('phone_number',16)->nullable();
            $table->text('picture')->nullable();
            $table->integer('created_by')->autoIncrement(false);
            $table->foreign('created_by')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('modified_by')->autoIncrement(false);
            $table->foreign('modified_by')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('modified_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
