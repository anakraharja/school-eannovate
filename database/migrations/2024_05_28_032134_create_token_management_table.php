<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_management', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('created_by')->autoIncrement(false);
            $table->foreign('created_by')->references('id')->on('admin')->onDelete('cascade')->onUpdate('cascade');
            $table->string('access_token');
            $table->timestamp('expired_at');
            $table->tinyInteger('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_management');
    }
}
