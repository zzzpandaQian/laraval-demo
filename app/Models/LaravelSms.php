<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaravelSms extends Model
{
    protected $fillable = [
        'to',
        'temp_id',
        'data',
        'content',
        'voice_code',
        'fail_times',
        'last_fail_time',
        'sent_time',
        'result_info'
    ];
}
