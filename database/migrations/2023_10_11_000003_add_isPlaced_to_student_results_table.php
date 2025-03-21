<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPlacedToStudentResultsTable extends Migration
{
    public function up()
    {
        Schema::table('student_results', function (Blueprint $table) {
            $table->enum('isPlaced', ['yes', 'no', 'hs'])->default('no')->after('kt_flag');
        });
    }
    
    public function down()
    {
        Schema::table('student_results', function (Blueprint $table) {
            $table->dropColumn('isPlaced');
        });
    }
}
