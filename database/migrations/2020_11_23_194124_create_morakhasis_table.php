<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMorakhasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morakhasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('fullname')->nullable();
            $table->string('dalil');
            $table->json('guardmessage')->nullable();
            $table->string('datetime');
            $table->string('dayli_date')->nullable();
            $table->string('fromtime_1')->nullable();
            $table->string('totime_1')->nullable();
            $table->string('fromdate')->nullable();
            $table->string('todate')->nullable();
            $table->string('fromtime_2')->nullable();
            $table->string('totime_2')->nullable();
            $table->integer('status');
            $table->integer('sms_sent')->nullable();
            $table->text('reject_dalil')->nullable();
            $table->integer('exit_ok')->nullable();
            $table->string('accepted_by')->nullable();
            $table->integer('checked')->nullable();
            $table->integer('late')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('morakhasis');
    }
}
