<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacementDrive extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'company_name',
        'drive_date',
        'location',
        'eligibility_branch',
        'eligibility_year',
        'kt_threshold',
        'min_cgpa',
        'min_sgpi',
    ];
} 