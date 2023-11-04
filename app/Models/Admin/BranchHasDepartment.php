<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchHasDepartment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'hospital_department_status'        => 'integer',
        'hospital_branch_id'                => 'integer',
        'hospital_department_id'            => 'integer',
    ];
    
    public function branch() {
        return $this->belongsTo(HospitalBranch::class,'hospital_branch_id');
    }

    public function department() {
        return $this->belongsTo(HospitalDepartment::class,'hospital_department_id');
    }
    
}
