<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResultsTable extends Migration
{
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('branch');
            $table->integer('year');
            $table->integer('semester');
            $table->float('subject1_cgpa')->nullable();
            $table->float('subject2_cgpa')->nullable();
            $table->float('subject3_cgpa')->nullable();
            $table->float('subject4_cgpa')->nullable();
            $table->float('subject5_cgpa')->nullable();
            $table->float('subject6_cgpa')->nullable();
            $table->float('overall_semester_cgpa')->nullable();
            $table->float('sgpi')->nullable();
            $table->boolean('kt_flag')->default(false);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('student_results');
    }
}