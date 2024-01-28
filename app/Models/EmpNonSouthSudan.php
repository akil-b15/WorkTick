<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpNonSouthSudan extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'birth_country',
        'arrival_year',
        'language',
        'employee_id',
        'gender',
        'disability',
        'disability_info',
    ];
}
