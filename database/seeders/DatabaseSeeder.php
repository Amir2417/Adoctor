<?php

namespace Database\Seeders;


use Database\Seeders\Admin\AdminHasRoleSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\AppOnboardScreensSeeder;
use Database\Seeders\Admin\CurrencySeeder;
use Database\Seeders\Admin\SetupKycSeeder;
use Database\Seeders\Admin\SetupSeoSeeder;
use Database\Seeders\Admin\ExtensionSeeder;
use Database\Seeders\Admin\AppSettingsSeeder;
use Database\Seeders\Admin\SiteSectionsSeeder;
use Database\Seeders\Admin\BasicSettingsSeeder;
use Database\Seeders\Admin\DoctorSeeder;
use Database\Seeders\Admin\HealthPackageSeeder;
use Database\Seeders\Admin\HospitalBranchSeeder;
use Database\Seeders\Admin\HospitalDepartmentSeeder;
use Database\Seeders\Admin\InvestigationSeeder;
use Database\Seeders\Admin\LanguageSeeder;
use Database\Seeders\Admin\PaymentGatewaySeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\SetupPageSeeder;
use Database\Seeders\Admin\TransactionSettingSeeder;
use Database\Seeders\Admin\UsefulLinkSeeder;
use Database\Seeders\Admin\WeekSeeder;
use Database\Seeders\User\DoctorAppointmentSeeder;
use Database\Seeders\User\HomeTestServiceSeeder;
use Database\Seeders\User\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            BasicSettingsSeeder::class,
            SetupSeoSeeder::class,
            AppSettingsSeeder::class,
            AppOnboardScreensSeeder::class,
            ExtensionSeeder::class,
            AdminHasRoleSeeder::class,
            SetupPageSeeder::class,
            PaymentGatewaySeeder::class,
            TransactionSettingSeeder::class,
            CurrencySeeder::class,
            SetupKycSeeder::class,
            LanguageSeeder::class,
            SiteSectionsSeeder::class,
            UsefulLinkSeeder::class,

            // /**
            //  * Demo seeder
            // */
            UserSeeder::class,
            WeekSeeder::class,
            HospitalDepartmentSeeder::class,
            HospitalBranchSeeder::class,
            DoctorSeeder::class,
            InvestigationSeeder::class,
            HealthPackageSeeder::class,
            HomeTestServiceSeeder::class,
            DoctorAppointmentSeeder::class,

        ]);
    }
}
