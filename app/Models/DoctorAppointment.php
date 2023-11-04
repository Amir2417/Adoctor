<?php

namespace App\Models;

use App\Models\Admin\DoctorHasSchedule;
use App\Models\Admin\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'name'              => 'string',
        'phone'             => 'string',
        'email'             => 'string',
        'type'              => 'string',
        'gender'            => 'string',
        'message'           => 'string',
        'status'            => 'integer',
    ];
    public function schedules(){
        return $this->belongsTo(DoctorHasSchedule::class,'schedule_id');
    }
    public function doctors(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
