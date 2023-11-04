<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Language;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'              => "English",
                'code'              => "en",
                'status'            => 1,
                'last_edit_by'      => 1,
                'dir'               =>'ltr'
            ],
            [
                'name'              => "Spanish",
                'code'              => "es",
                'status'            => 0,
                'last_edit_by'      => 1,
                'dir'               =>'ltr'
            ],
            [
                'name'              => "Arabic",
                'code'              => "ar",
                'status'            => 0,
                'last_edit_by'      => 1,
                'dir'               =>'rtl'
            ]
        ];
        Language::upsert($data,['code'],['name','code','status','last_edit_by','created_at','dir']);
    }
}
