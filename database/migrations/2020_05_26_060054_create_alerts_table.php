<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('master')->nullable();
            $table->unsignedBigInteger('class')->nullable();
            $table->json('info')->nullable();
            $table->string('date')->nullable();
            $table->text('users')->nullable();
            $table->string('status')->nullable();
            $table->text('absents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
