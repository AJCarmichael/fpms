<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacementDrivesTable extends Migration
{
    public function up()
    {
        Schema::create('placement_drives', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->date('drive_date');
            $table->string('location');
            $table->string('eligibility_branch');
            $table->integer('eligibility_year');
            $table->integer('kt_threshold');
            $table->float('min_cgpa');
            $table->float('min_sgpi');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('placement_drives');
    }
} 