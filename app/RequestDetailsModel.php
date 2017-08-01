<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestDetailsModel extends Model
{
	protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['request_id', 'Req_Sequence','LoggedBy','Status','FirstName','LastName','Place','City','State','Country', 'Email','PhoneNumber','TypeOfWork','Category','Details','PreferredTime','Amount','AssignedToEmail','SMSTrigger','MailTrigger','PaymentFlag','userId'];
    protected $table = "RequestDetails";
}
