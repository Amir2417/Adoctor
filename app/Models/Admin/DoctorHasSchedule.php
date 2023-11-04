<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorHasSchedule extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'doctor_id'  => 'integer',
        'week_id'    => 'integer',
        'from_time'  => 'string',
        'to_time'    => 'string',
        'max_patient' => 'integer',
        'status' => 'integer',
    ];
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function week(){
        return $this->belongsTo(Week::class,'week_id');
    }
}
