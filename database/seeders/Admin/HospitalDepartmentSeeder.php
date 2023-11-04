<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\HospitalDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $hospital_departments = array(
            array('slug' => 'medicine-nephrology','name' => 'Medicine & Nephrology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'respiratory-pulmonology-medicine','name' => 'Respiratory / Pulmonology Medicine','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'general-surgery','name' => 'General Surgery','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'orthopedic-surgery-knee','name' => 'Orthopedic Surgery (Knee)','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'spine-surgery','name' => 'Spine Surgery','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'neuro-surgery','name' => 'Neuro Surgery','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'orthopedic-surgery','name' => 'Orthopedic Surgery','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'oncology','name' => 'Oncology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'gynaecology-obstetrics','name' => 'Gynaecology & Obstetrics','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'skin-vd','name' => 'Skin & VD','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'ent','name' => 'E.N.T','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'paediatric-haematology-oncology','name' => 'Paediatric Haematology & Oncology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'pediatrics','name' => 'Pediatrics','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'pediatric-surgery','name' => 'Pediatric Surgery','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'pediatric-pulmonology','name' => 'Pediatric & Pulmonology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'nephrology','name' => 'Nephrology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'ophthalmology','name' => 'Ophthalmology','status' => '1','last_edit_by' => '1','created_at' => now()),
            array('slug' => 'dental','name' => 'Dental','status' => '1','last_edit_by' => '1','created_at' => now())
        );

        HospitalDepartment::insert($hospital_departments);
    }
}
