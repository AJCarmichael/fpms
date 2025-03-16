<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('roll_no')->unique();
            $table->string('name');
            $table->string('seat_no')->nullable();
            $table->string('branch');
            $table->integer('year');
            $table->integer('lifetime_kt_count')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('students');
    }
} 