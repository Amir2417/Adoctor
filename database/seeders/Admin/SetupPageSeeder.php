<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\SetupPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SetupPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setup_pages = array(
            array('slug' => 'home','title' => 'Home','url' => '/','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => '2024-03-12 04:15:43'),
            array('slug' => 'find','title' => 'Find','url' => '/find-doctors','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => NULL),
            array('slug' => 'about','title' => 'About','url' => '/about','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => NULL),
            array('slug' => 'faq','title' => 'Faq','url' => '/faq','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => NULL),
            array('slug' => 'web-journal','title' => 'Web Journal','url' => 'journals','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => NULL),
            array('slug' => 'contact','title' => 'Contact','url' => '/contact','last_edit_by' => '1','status' => '1','created_at' => '2024-03-12 04:14:08','updated_at' => NULL)
        );

        SetupPage::insert($setup_pages);
    }
}
