<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'institution',
        'qualification_attained',
        'field_of_study_one',
        'field_of_study_two',
        'employee_id',
        'completion_year',
        'qualification_obtained_in',
        'highest_qualification',
    ];
}
