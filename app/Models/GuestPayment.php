<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPayment extends Model
{
    use HasFactory;
    protected $table = 'guest_payment';
    // Allow mass assignment on the listed fields
    protected $fillable = [
        'guest_id',        
        'payment_status', 
        'payment_comment',
        'daily',
        'monthly',
        'total_amount',
        'paid_amount',
        'pending_amount'
    ];
}
