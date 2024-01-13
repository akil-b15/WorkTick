<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title','company_id','department_id','description','summary','start_date','end_date'
    ];

    protected $casts = [
        'department_id' => 'integer',
        'company_id'    => 'integer',
    ];


    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function noticeStatus(): MorphMany
    {
        return $this->morphMany(EmployeeNoticeStatus::class, 'noticeable');
    }
}
