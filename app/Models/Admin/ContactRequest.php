<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts  = [
        'name'        => 'string',
        'email'       => 'string',
        'message'     => 'string',
    ];
}
