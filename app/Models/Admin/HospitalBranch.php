<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalBranch extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts  = [
        'slug'                      => 'string',
        'name'                      => 'string',
        'status'                    => 'integer',
        'last_edit_by'              => 'integer',
        'hospital_department_status'        => 'integer',
    ];
    public function admin() {
        return $this->belongsTo(Admin::class,'last_edit_by','id');
    }

    public function departments() {
        return $this->hasMany(BranchHasDepartment::class,'hospital_branch_id');
    }

}
