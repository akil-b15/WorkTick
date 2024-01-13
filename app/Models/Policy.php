<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description','company_id'
    ];

    protected $casts = [
        'company_id' => 'integer',
    ];


    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function noticeStatus(): MorphMany
    {
        return $this->morphMany(EmployeeNoticeStatus::class, 'noticeable');
    }

}
