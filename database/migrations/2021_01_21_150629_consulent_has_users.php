<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConsulentHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulent_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulent_id');
            $table->foreign('client_id')->references('id')->on('users');
            $table->unsignedBigInteger('client_id');
            $table->foreign('consulent_id')->references('id')->on('users');
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
        Schema::dropIfExists('consulent_clients');
    }
}
