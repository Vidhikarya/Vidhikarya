<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUpLog extends Model
{
    protected $fillable = ['PickedUpBy','request_id','Req_Sequence'];
    protected $table = 'PickUpLog';
}
