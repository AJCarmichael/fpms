<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlacementGroupIdToPlacementDrivesTable extends Migration
{
    public function up()
    {
        Schema::table('placement_drives', function (Blueprint $table) {
            $table->foreignId('placement_group_id')->nullable()->constrained('placement_groups')->onDelete('set null')->after('id');
        });
    }
    
    public function down()
    {
        Schema::table('placement_drives', function (Blueprint $table) {
            $table->dropForeign(['placement_group_id']);
            $table->dropColumn('placement_group_id');
        });
    }
}
