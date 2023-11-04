<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppOnboardScreens;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppOnboardScreensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_onboard_screens = array(
            array('title' => 'Booking Appointment Anytime Anywhere','sub_title' => 'easy way of booking a doctor\'s appointment online','image' => 'seeder/onboard1.png','status' => '1','last_edit_by' => '1','created_at' => '2023-07-13 06:51:47','updated_at' => '2023-07-13 06:51:47'),
            array('title' => 'Make Your Life More Easier With Adoctor','sub_title' => 'easy way of booking a doctor\'s appointment online','image' => 'seeder/onboard2.png','status' => '1','last_edit_by' => '1','created_at' => '2023-07-13 06:52:27','updated_at' => '2023-07-13 06:52:27'),
            array('title' => 'Find A Best Doctor With Your Perception','sub_title' => 'easy way of booking a doctor\'s appointment online','image' => 'seeder/onboard3.png','status' => '1','last_edit_by' => '1','created_at' => '2023-07-13 06:53:10','updated_at' => '2023-07-13 06:53:10')
        );

        AppOnboardScreens::insert($app_onboard_screens);
    }
}
