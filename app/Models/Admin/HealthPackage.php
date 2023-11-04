<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPackage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts  = [
        'slug'                  => 'string',
        'name'                  => 'string',
        'title'                 => 'string',
        'status'                => 'integer',
        'last_edit_by'          => 'integer',
        
    ];

    public function admin() {
        return $this->belongsTo(Admin::class,'last_edit_by','id');
    }

    
}
