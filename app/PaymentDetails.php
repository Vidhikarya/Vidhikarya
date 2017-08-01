<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $fillable = ['amount','firstname','phone','hash','txnid','productInfo','email','userId','linkPart','paymentStatus','loggedBy','request_id','Req_Sequence'];
    protected $table = 'PaymentDetails';
}
