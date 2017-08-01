<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawyerDetails extends Model
{
    protected $fillable = ['id', 'Name', 'Email', 'PhoneNumber', 'UserRole'];
    protected $table = 'LawyerDetails';
}
