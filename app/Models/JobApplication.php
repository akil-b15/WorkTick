<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $guarded = [];

    public function jobs()
    {
        return $this->hasOne('App\Models\Job', 'id', 'job_id');
    }
}
