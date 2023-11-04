<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalDepartment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts  = [
        'slug'        => 'string',
        'name'       => 'string',
        'hospital_department_status'        => 'integer',
    ];
    
    public function admin() {
        return $this->belongsTo(Admin::class,'last_edit_by','id');
    }

    public function branch() {
        return $this->belongsTo(HospitalBranch::class,'hospital_branch_id');
    }
    
}
