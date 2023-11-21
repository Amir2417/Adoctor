<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\BasicSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'site_name'         => "ADoctor",
            'site_title'        => "Hospital Doctor Booking",
            'base_color'        => "#1bbde4",
            'otp_exp_seconds'   => "3600",
            'timezone'          => "Asia/Dhaka",
            'user_registration'  => 1,
            'email_verification' => 1,
            'agree_policy'       => 1,
            'broadcast_config'  => [
                "method" => "pusher", 
                "app_id" => "1539602", 
                "primary_key" => "39079c30de823f783dbe", 
                "secret_key" => "78b81e5e7e0357aee3df", 
                "cluster" => "ap2" 
            ],
            'push_notification_config'  => [
                "method" => "pusher", 
                "instance_id" => "809313fc-1f5c-4d0b-90bc-1c6751b83bbd", 
                "primary_key" => "58C901DC107584D2F1B78E6077889F1C591E2BC39E9F5C00B4362EC9C642F03F"
            ],
            'kyc_verification'  => true,
            'mail_config'       => [
                "method" => "smtp", 
                "host" => "appdevs.net",
                "port" => "465", 
                "encryption" => "ssl",
                "username" => "system@appdevs.net",
                "password" => "QP2fsLk?80Ac",
                "from" => "system@appdevs.net", 
                "app_name" => "ADoctor",
            ],
           
            'site_logo_dark'    => 'seeder/web_logo.png',
            'site_logo'         => 'seeder/web_logo.png',
            'site_fav_dark'     => 'seeder/fav_icon.png',
            'site_fav'          => 'seeder/fav_icon.png',
            'web_version'       => 'v1.2.0',
        ];
        BasicSettings::truncate();
        BasicSettings::firstOrCreate($data);
    }
}
