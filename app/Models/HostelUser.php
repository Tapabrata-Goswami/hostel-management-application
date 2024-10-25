<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelUser extends Model
{
    use HasFactory;
    protected $table = 'hostel_user';
    // Allow mass assignment on the listed fields
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'user_type', 
        'fname', 
        'lname', 
        'mobile_number'
    ];
}
