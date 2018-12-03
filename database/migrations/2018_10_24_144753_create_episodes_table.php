<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('uploaded_by');
            $table->integer('number');
            $table->string('description');
            $table->string('image')->nullable();
            $table->integer('views')->default('0');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->unique(['group_id', 'number']);
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
        Schema::dropIfExists('episodes');
    }
}
