<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'version'               => '1.0.0',
            'splash_screen_image'   => 'seeder/splash_screen.png',
            'url_title'             => 'Download App',
            'android_url'           => 'https://play.google.com/store/apps/developer?id=AppDevsX',
            'iso_url'               => 'https://www.apple.com/app-store/',
            'created_at'            => now(),
        ];

        AppSettings::firstOrCreate($data);
    }
}
