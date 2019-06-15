<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('writtenBy');
            $table->unsignedInteger('group_type_id');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->integer('views')->default('0');
            $table->foreign('writtenBy')->references('id')->on('users');
            $table->foreign('group_type_id')->references('id')->on('group_type');
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
        Schema::dropIfExists('groups');
    }
}
