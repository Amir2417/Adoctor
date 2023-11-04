<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Doctor;
use App\Models\Admin\DoctorHasSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors = array(
          array('hospital_branch_id' => '2','hospital_department_id' => '7','slug' => '582127aa-ca29-4b50-8a99-66d61f07eff6','name' => 'Dr. Iris Hanson','doctor_title' => 'Professor','qualification' => 'MBBS','speciality' => 'Dental','language' => 'Bangla,English','designation' => 'Consultant','contact' => '123456785555','floor_number' => '63','room_number' => '794','address' => '08 W 36th St, New YorkNY 10001','fees' => '5','off_days' => 'Saturday,Sunday','image' => 'seeder/doctor1.webp','status' => '1','created_at' => '2023-07-27 12:09:53','updated_at' => NULL),
          array('hospital_branch_id' => '3','hospital_department_id' => '13','slug' => '451346fc-ed20-4061-9c81-394ce23c99cb','name' => 'Dr. Arianna Clark','doctor_title' => 'Chairman','qualification' => 'MBBS','speciality' => 'Medicine','language' => 'bangla,english','designation' => 'Doctor','contact' => '12345678','floor_number' => '63','room_number' => '661','address' => '08 W 36th St, New YorkNY 10001','fees' => '3','off_days' => 'Saturday,Sunday,Monday','image' => 'seeder/doctor2.webp','status' => '1','created_at' => '2023-07-27 12:09:53','updated_at' => NULL),
          array('hospital_branch_id' => '3','hospital_department_id' => '4','slug' => '6943505e-c36c-4046-b964-963acfa5983d','name' => 'Dr. Lyla Briggs','doctor_title' => 'Head Of The Department','qualification' => 'MBBS','speciality' => 'Medicine','language' => 'Bangla','designation' => 'Phd','contact' => '12345','floor_number' => '635','room_number' => '461','address' => '08 W 36th St, New YorkNY 10001','fees' => '2','off_days' => 'Saturday,Sunday,Monday','image' => 'seeder/doctor3.webp','status' => '1','created_at' => '2023-07-27 12:09:53','updated_at' => NULL),
          array('hospital_branch_id' => '4','hospital_department_id' => '3','slug' => 'dcb9b72b-2d99-49ac-9355-d3d0c7554916','name' => 'Dr. Emi Martinez','doctor_title' => 'Professor & Head Of The Department','qualification' => 'MBBS, MD (Gastro)','speciality' => 'Medicine','language' => 'English,Spanish','designation' => 'Consultant','contact' => '+88 09610009787','floor_number' => '2nd Floor(Hospital Bhaban)','room_number' => '207','address' => '225 8th Ave, New York, NY 199980, USA','fees' => '4','off_days' => 'Friday & Govt. Holiday','image' => 'seeder/doctor4.webp','status' => '1','created_at' => '2023-07-27 12:17:09','updated_at' => '2023-07-27 12:17:09'),
          array('hospital_branch_id' => '5','hospital_department_id' => '5','slug' => 'd358e429-68f8-401d-8366-2daf175eb000','name' => 'Dr. Cuti Romero','doctor_title' => 'Professor & Head Of The Department','qualification' => 'MBBS','speciality' => 'Medicine','language' => 'English','designation' => 'Doctor','contact' => '+88 09610009585','floor_number' => '3rd Floor(Hospital Bhaban)','room_number' => '312','address' => '225 8th Ave, New York, NY 199980, USA','fees' => '3','off_days' => 'Saturday & Govt. Holiday','image' => 'seeder/doctor5.webp','status' => '1','created_at' => '2023-07-27 12:20:23','updated_at' => '2023-07-27 12:20:23'),
          array('hospital_branch_id' => '1','hospital_department_id' => '4','slug' => '3c4fdaa5-f09f-410f-acf2-7bfbf1b8d422','name' => 'Dr. Rodrego','doctor_title' => 'Professor & Head Of The Department','qualification' => 'MBBS, MD (Gastro)','speciality' => 'Medicine','language' => 'English,Spanish','designation' => 'Doctor','contact' => '+88 09610009768','floor_number' => '4th Floor(Hospital Bhaban)','room_number' => '412','address' => '225 8th Ave, New York, NY 199980, USA','fees' => '5','off_days' => 'Monday & Govt. Holiday','image' => 'seeder/doctor6.webp','status' => '1','created_at' => '2023-07-27 12:22:37','updated_at' => '2023-07-27 12:22:37'),
          array('hospital_branch_id' => '1','hospital_department_id' => '1','slug' => '6abba95f-eca9-424d-b8a3-4a7a7ab6d2ca','name' => 'Dr. Adam Davis','doctor_title' => 'Professor & Head Of The Department','qualification' => 'MBBS, MD (Gastro)','speciality' => 'Medicine, Liver & GIT Specialist','language' => 'English,Bangla,Hindi','designation' => 'Consultant','contact' => '+88 09610009616','floor_number' => '2nd Floor(Hospital Bhaban)','room_number' => '309','address' => '1/1, Uttara,Dhaka-1216','fees' => '4','off_days' => 'Friday & Govt. Holiday','image' => 'seeder/doctor7.webp','status' => '1','created_at' => '2023-07-27 12:09:53','updated_at' => NULL),
          array('hospital_branch_id' => '3','hospital_department_id' => '4','slug' => 'e67624bb-9d5f-4140-bea0-dd8d4938cd82','name' => 'Dr. Alice Murphy','doctor_title' => 'Dental Specialist','qualification' => 'MBBS','speciality' => 'Skin','language' => 'Bangla','designation' => 'Doctor','contact' => '12345678','floor_number' => '34','room_number' => '345','address' => 'Dolor voluptatum ex','fees' => '5','off_days' => 'Saturday,Sunday,Monday','image' => 'seeder/doctor8.webp','status' => '1','created_at' => '2023-07-27 12:09:53','updated_at' => NULL)
        );


        Doctor::insert($doctors);

        //DoctorHasSchedule Data insert

        $doctor_has_schedules = array(
            array('id' => '1','doctor_id' => '1','week_id' => '3','from_time' => '02:01','to_time' => '04:01','max_patient' => '35','status' => '1','created_at' => '2023-06-23 03:59:17','updated_at' => NULL),
            array('id' => '2','doctor_id' => '1','week_id' => '1','from_time' => '03:52','to_time' => '04:52','max_patient' => '27','status' => '1','created_at' => '2023-06-23 03:59:47','updated_at' => NULL),
            array('id' => '3','doctor_id' => '2','week_id' => '2','from_time' => '01:52','to_time' => '02:52','max_patient' => '38','status' => '1','created_at' => '2023-06-23 03:59:47','updated_at' => NULL),
            array('id' => '4','doctor_id' => '2','week_id' => '5','from_time' => '15:38','to_time' => '19:35','max_patient' => '45','status' => '1','created_at' => '2023-06-23 04:00:44','updated_at' => NULL),
            array('id' => '5','doctor_id' => '3','week_id' => '2','from_time' => '15:40','to_time' => '20:40','max_patient' => '100','status' => '1','created_at' => '2023-06-23 04:00:44','updated_at' => NULL),
            array('id' => '6','doctor_id' => '3','week_id' => '6','from_time' => '21:06','to_time' => '22:06','max_patient' => '45','status' => '1','created_at' => '2023-06-23 04:01:34','updated_at' => NULL),
            array('id' => '7','doctor_id' => '4','week_id' => '4','from_time' => '13:00','to_time' => '15:00','max_patient' => '35','status' => '1','created_at' => '2023-06-23 04:01:34','updated_at' => NULL),
            array('id' => '8','doctor_id' => '4','week_id' => '5','from_time' => '13:00','to_time' => '15:00','max_patient' => '25','status' => '1','created_at' => '2023-06-23 04:05:41','updated_at' => NULL),
            array('id' => '9','doctor_id' => '5','week_id' => '4','from_time' => '17:00','to_time' => '19:00','max_patient' => '24','status' => '1','created_at' => '2023-06-23 04:05:41','updated_at' => NULL),
            array('id' => '10','doctor_id' => '6','week_id' => '3','from_time' => '19:00','to_time' => '21:00','max_patient' => '30','status' => '1','created_at' => '2023-07-27 12:17:09','updated_at' => NULL),
            array('id' => '11','doctor_id' => '7','week_id' => '3','from_time' => '19:00','to_time' => '20:00','max_patient' => '20','status' => '1','created_at' => '2023-07-27 12:20:23','updated_at' => NULL),
            array('id' => '12','doctor_id' => '7','week_id' => '4','from_time' => '13:00','to_time' => '21:00','max_patient' => '24','status' => '1','created_at' => '2023-07-27 12:20:23','updated_at' => NULL),
            array('id' => '13','doctor_id' => '8','week_id' => '2','from_time' => '18:00','to_time' => '20:00','max_patient' => '20','status' => '1','created_at' => '2023-07-27 12:22:37','updated_at' => NULL)
          );

        DoctorHasSchedule::insert($doctor_has_schedules);

    }
}
