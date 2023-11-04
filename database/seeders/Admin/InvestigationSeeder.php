<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\HospitalTests;
use App\Models\Admin\Investigation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospital_tests = array(
            array('name' => '11A INTRA OPAL PA X-RAY EACH','slug' => '11a-intra-opal-pa-x-ray-each','price' => '6','offer_price' => '4','status' => '1','home_service' => '0','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Blood Test','slug' => 'blood-test','price' => '4','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Blood Count','slug' => 'blood-count','price' => '5','offer_price' => '4','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Urinalysis','slug' => 'urinalysis','price' => '4','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Cholesterol Test','slug' => 'cholesterol-test','price' => '4','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Ultrasonography','slug' => 'ultrasonography','price' => '5','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Liver Function Tests','slug' => 'liver-function-tests','price' => '6','offer_price' => '4','status' => '1','home_service' => '0','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Biopsy','slug' => 'biopsy','price' => '4','offer_price' => '3','status' => '1','home_service' => '0','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Pap Smear','slug' => 'pap-smear','price' => '4','offer_price' => '2','status' => '1','home_service' => '0','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'ESR','slug' => 'esr','price' => '3','offer_price' => '2','status' => '1','home_service' => '0','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Bone Scan','slug' => 'bone-scan','price' => '4','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Angiography','slug' => 'angiography','price' => '4','offer_price' => '3','status' => '1','home_service' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now())
          );
        Investigation::insert($hospital_tests);
    }
}
