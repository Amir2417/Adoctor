<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\HealthPackage;
use App\Models\Admin\HospitalTestPackage;
use App\Models\Admin\PackageHasTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $health_packages = array(
            array('name' => 'HCP01','slug' => 'hcp01','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '10','offer_price' => '8','status' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP02','slug' => 'hcp02','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '15','offer_price' => null,'status' => '1','last_edit_by' => '1','created_at' => now(),           'updated_at' => now()),
            array('name' => 'HCP03','slug' => 'hcp03','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '22','offer_price' => '20','status' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP04','slug' => 'hcp04','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '15','offer_price' => '12','status' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP05','slug' => 'hcp05','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '12','offer_price' => '10','status' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP06','slug' => 'hcp06','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '15','offer_price' => '11','status' => '1','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP07','slug' => 'hcp07','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '10','offer_price' => null,'status' => '1','last_edit_by' => '1',           'created_at' => now(),'updated_at' => now()),
            array('name' => 'HCP08','slug' => 'hcp08','title' => 'Basic Health Check-up For Male/Female (Adult).','price' => '25','offer_price' => null,'status' => '1','last_edit_by' => '1',           'created_at' => now(),'updated_at' => now())
        );

        HealthPackage::insert($health_packages);

        //PackageHasTest

        

    }
}
