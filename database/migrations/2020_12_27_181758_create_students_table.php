<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 250)->nullable();
            $table->text('address')->nullable();
            $table->string('grade',20)->default(0);
            $table->string('photo')->nullable();
            $table->date('date_of_birth');
            $table->integer('city_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('is_active')->comment('1 = Active, 0 = In-Active')->default(1);
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
        Schema::dropIfExists('students');
    }
}
