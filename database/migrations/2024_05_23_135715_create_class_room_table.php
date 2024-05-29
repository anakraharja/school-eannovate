<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class', function (Blueprint $table) {
            $table->integer('id',11)->autoIncrement();
            $table->string('name',64);
            $table->string('major',64);
            $table->integer('created_by',11)->autoIncrement(false);
            $table->foreign('created_by')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('modified_by',11)->autoIncrement(false);
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
        Schema::dropIfExists('class');
    }
}
