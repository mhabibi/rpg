<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'states',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 255);
                $table->text('description');
                $table->integer('cost');
            }
        );

        Schema::create(
            'options',
            function (Blueprint $table) {
                $table->integer('parent');
                $table->integer('child');
                $table->primary(['parent', 'child']);
                $table->foreign('parent')
                      ->references('id')
                      ->on('states')
                      ->onDelete('cascade');
                $table->foreign('child')
                      ->references('id')
                      ->on('states')
                      ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('states');
        Schema::drop('options');
    }
}
