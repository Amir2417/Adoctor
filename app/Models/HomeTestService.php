<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTestService extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'name'           => 'string',
        'phone'          => 'string',
        'email'          => 'string',
        'type'           => 'object',
        'gender'         => 'string',
        'schedule'       => 'string',
        'address'        => 'string',
        'message'        => 'string',
        'status'         => 'integer',
    ];
}
