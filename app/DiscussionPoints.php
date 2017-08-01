<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionPoints extends Model
{
    protected $fillable = ['Notes','AddedBy','request_id', 'Req_Sequence'];
    protected $table = 'DiscussionPoints';
}
