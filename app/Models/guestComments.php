<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guestComments extends Model
{
    use HasFactory;
    protected $table = 'guest_comments';
    protected $fillable = [
        'guest_id',
        'comment'
    ];
}
