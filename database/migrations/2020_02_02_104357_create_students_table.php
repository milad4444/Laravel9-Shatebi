<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Fname');
            $table->string('Lname');
            $table->string('Aks')->nullable();
            $table->string('FatherName');
            $table->integer('juz')->nullable();
            // $table->integer('hafezkol')->default(0);
            $table->integer('ziafat')->nullable();
            $table->string('ziafatdate')->nullable();
            $table->string('Mellicode');
            $table->string('Birthday')->nullable();
            $table->string('Birthplace')->nullable();
            $table->string('Entryday')->nullable();
            $table->string('FatherJob');
            $table->string('Phone')->nullable();
            $table->string('TelPhone')->nullable();
            $table->string('ParentPhone')->nullable();
            $table->string('Ostan');
            $table->string('City');
            $table->string('Vilage')->nullable();
            $table->string('Adress')->nullable();
            $table->string('Educating')->nullable();
            $table->string('StudentCode');
            $table->string('Referer')->nullable();
            $table->string('EconomicStatus')->nullable();
            $table->string('status');
            $table->string('course')->nullable();
            $table->string('master_status')->nullable();
            $table->string('Health')->nullable();
            $table->string('Description')->nullable();
            $table->string('endDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
