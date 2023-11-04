<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    
    protected $casts = [
        'status'                => 'integer',
        'email_verified'        => 'integer',
        'sms_verified'          => 'integer',
        'kyc_verified'          => 'integer',
    ];
}
