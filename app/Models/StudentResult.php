<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'branch',
        'year',
        'semester',
        'subject1_cgpa',
        'subject2_cgpa',
        'subject3_cgpa',
        'subject4_cgpa',
        'subject5_cgpa',
        'subject6_cgpa',
        'overall_semester_cgpa',
        'sgpi',
        'kt_flag',
        'isPlaced',
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}