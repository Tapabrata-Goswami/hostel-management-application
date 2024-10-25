<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $table = 'guest';
    // Allow mass assignment on the listed fields
    protected $fillable = [
        'archive_status',
        'first_name', 
        'last_name', 
        'check_in_date', 
        'room_number',
        'bed_number', 
        'booking', 
        'flyer',
        'interdependent', 
        'passport_scan', 
        'contact_no', 
        'email',
        'code'
    ];
}