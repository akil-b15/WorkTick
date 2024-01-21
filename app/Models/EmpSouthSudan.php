<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpSouthSudan extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'state',
        'town',
        'payam_one',
        'payam_two',
        'payam_three',
        'gender',

    ];
}
