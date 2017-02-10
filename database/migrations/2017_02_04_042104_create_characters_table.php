<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'characters',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50)->unique();
                $table->integer('stock')->default(0);
                $table->integer('state_id')->nullable();;
                $table->timestamps();
                $table->foreign('state_id')
                      ->references('id')
                      ->on('states');
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
        Schema::drop('characters');
    }
}
