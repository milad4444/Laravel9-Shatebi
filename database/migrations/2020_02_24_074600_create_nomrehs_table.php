<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomrehsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('nomrehs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('classha_id');
            $table->string('classname');
            $table->string('mastername')->nullable();
            $table->string('mellicode');
            $table->json('info')->nullable();
            $table->string('date');
            $table->string('persiandate')->nullable();
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
        Schema::dropIfExists('nomrehs');
    }
}
