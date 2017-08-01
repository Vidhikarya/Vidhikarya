<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentLog extends Model
{
    protected $fillable = ['AssignBy', 'AssignTo', 'request_id', 'Req_sequence'];
    protected $table = 'AssignmentLog';
}
