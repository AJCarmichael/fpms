<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacementGroup extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'thumbnail',
    ];
    
    // Relationship: group has many placement drives
    public function placementDrives()
    {
        return $this->hasMany(\App\Models\PlacementDrive::class);
    }
}
