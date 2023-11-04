<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts  = [
        'name'                  => 'string',
        'slug'                  => 'string',
        'price'                 => 'decimal:8',
        'offer_price'           => 'decimal:8',
        'status'                => 'integer',
        'home_service'          => 'integer',
        'last_edit_by'          => 'integer',
    ];

    public function admin() {
        return $this->belongsTo(Admin::class,'last_edit_by','id');
    }
}
