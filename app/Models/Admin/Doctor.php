<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'hospital_branch_id'     => 'integer',
        'hospital_department_id' => 'integer',
        'slug'                   => 'string',
        'name'                   => 'string',
        'doctor_title'           => 'string',
        'qualification'          => 'string',
        'speciality'             => 'string',
        'language'               => 'string',
        'designation'            => 'string',
        'contact'                => 'string',
        'floor_number'           => 'string',
        'room_number'            => 'string',
        'address'                => 'string',
        'fees'                   => 'decimal:8',
        'status'                 => 'integer',
    ];

    public function schedules(){
        return $this->hasMany(DoctorHasSchedule::class,'doctor_id');
    }
    public function department(){
        return $this->belongsTo(HospitalDepartment::class,'hospital_department_id');
    }
    public function branch(){
        return $this->belongsTo(HospitalBranch::class,'hospital_branch_id');
    }
}
