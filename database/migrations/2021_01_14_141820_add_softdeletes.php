<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('scans', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('results', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('scans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('results', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
