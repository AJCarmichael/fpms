<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'roll_no',
        'name',
        'seat_no',
        'branch',
        'year',
        'lifetime_kt_count',
    ];
    
    public function results()
    {
        return $this->hasMany(StudentResult::class);
    }
    
    // Returns the latest result record (by semester)
    public function latestResult()
    {
        return $this->hasOne(StudentResult::class)->latestOfMany('semester');
    }
} 