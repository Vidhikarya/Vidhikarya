<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallSchedule extends Model
{
    protected $fillable = ['request_id','Req_Sequence','ScheduleBy','ScheduleOn','ScheduleMessage','Status'];
    protected $table = 'CallSchedule';
}
