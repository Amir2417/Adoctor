<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\BranchHasDepartment;
use App\Models\Admin\HospitalBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospital_branches = array(
            array('name' => 'Uttara','slug' => 'uttara','email' => 'demo5@appdevs.net','web' => 'https://www.appdevs.net/','description' => 'ADoctor Diagnostic & Imaging Center, 4126 O Conner Street, Valdosta, GA, Georgia, 31601, UTC-5','status' => '1','last_edit_by' => '1','created_at' => '2023-07-22 06:07:36','updated_at' => '2023-07-23 09:38:32'),
            array('name' => 'Banani','slug' => 'banani','email' => 'demo4@appdevs.net','web' => 'https://www.appdevs.net/','description' => 'ADoctor Diagnostic & Imaging Center, 4126 O Conner Street, Valdosta, GA, Georgia, 31601, UTC-5','status' => '1','last_edit_by' => '1','created_at' => '2023-07-22 06:07:36','updated_at' => '2023-07-23 09:38:07'),
            array('name' => 'Gazipur','slug' => 'gazipur','email' => 'demo2@appdevs.net','web' => 'https://www.appdevs.net/','description' => 'ADoctor Diagnostic & Imaging Center, 4126 O Conner Street, Valdosta, GA, Georgia, 31601, UTC-5','status' => '1','last_edit_by' => '1','created_at' => '2023-07-22 06:07:36','updated_at' => '2023-07-23 09:37:46'),
            array('name' => 'Mirpur','slug' => 'mirpur','email' => 'demo1@appdevs.net','web' => 'https://www.appdevs.net/','description' => 'ADoctor Diagnostic & Imaging Center, 4126 O Conner Street, Valdosta, GA, Georgia, 31601, UTC-5','status' => '1','last_edit_by' => '1','created_at' => '2023-07-22 06:07:36','updated_at' => '2023-07-23 09:37:29'),
            array('name' => 'Mohammadpur','slug' => 'mohammadpur','email' => 'demo@appdevs.net','web' => 'https://www.appdevs.net/','description' => 'ADoctor Diagnostic & Imaging Center, 4126 O Conner Street, Valdosta, GA, Georgia, 31601, UTC-5: Eastern Standard Time (EST)','status' => '1','last_edit_by' => '1','created_at' => '2023-07-22 06:07:36','updated_at' => '2023-07-23 09:34:52')
          );
        HospitalBranch::insert($hospital_branches);


        //Branch Has Department

        $branch_has_departments = array(
            array('hospital_branch_id' => '1','hospital_department_id' => '1','created_at' => '2023-06-21 06:27:17','updated_at' => NULL),
            array('hospital_branch_id' => '4','hospital_department_id' => '1','created_at' => '2023-06-21 10:56:31','updated_at' => NULL),
            array('hospital_branch_id' => '4','hospital_department_id' => '2','created_at' => '2023-06-21 10:56:31','updated_at' => NULL),
            array('hospital_branch_id' => '4','hospital_department_id' => '3','created_at' => '2023-06-21 10:56:31','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '4','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '3','hospital_department_id' => '4','created_at' => '2023-06-21 06:27:47','updated_at' => NULL),
            array('hospital_branch_id' => '4','hospital_department_id' => '4','created_at' => '2023-06-21 10:56:31','updated_at' => NULL),
            array('hospital_branch_id' => '1','hospital_department_id' => '4','created_at' => '2023-06-21 06:27:17','updated_at' => NULL),
            array('hospital_branch_id' => '4','hospital_department_id' => '5','created_at' => '2023-06-21 10:56:31','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '5','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '2','hospital_department_id' => '6','created_at' => '2023-06-21 06:27:29','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '6','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '3','hospital_department_id' => '7','created_at' => '2023-06-21 06:27:47','updated_at' => NULL),
            array('hospital_branch_id' => '2','hospital_department_id' => '7','created_at' => '2023-06-21 06:27:29','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '7','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '8','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '1','hospital_department_id' => '8','created_at' => '2023-06-21 06:27:17','updated_at' => NULL),
            array('hospital_branch_id' => '2','hospital_department_id' => '8','created_at' => '2023-06-21 06:27:29','updated_at' => NULL),
            array('hospital_branch_id' => '5','hospital_department_id' => '9','created_at' => '2023-06-21 10:57:00','updated_at' => NULL),
            array('hospital_branch_id' => '2','hospital_department_id' => '9','created_at' => '2023-06-21 06:27:29','updated_at' => NULL),
            array('hospital_branch_id' => '3','hospital_department_id' => '10','created_at' => '2023-06-21 06:27:47','updated_at' => NULL),
            array('hospital_branch_id' => '2','hospital_department_id' => '10','created_at' => '2023-06-21 06:27:29','updated_at' => NULL),
            array('hospital_branch_id' => '1','hospital_department_id' => '10','created_at' => '2023-06-21 06:27:17','updated_at' => NULL),
            array('hospital_branch_id' => '3','hospital_department_id' => '12','created_at' => '2023-06-21 06:27:47','updated_at' => NULL),
            array('hospital_branch_id' => '3','hospital_department_id' => '13','created_at' => '2023-06-21 06:27:47','updated_at' => NULL)
        );
        BranchHasDepartment::insert($branch_has_departments);
    }
}
