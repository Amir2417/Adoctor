<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\PushNotifications\PushNotifications;
use App\Models\Admin\AdminNotification;
use App\Constants\NotificationConst;
use App\Http\Helpers\Response;
use App\Models\Admin\Doctor;
use App\Models\Admin\HealthPackage;
use App\Models\Admin\HospitalBranch;
use App\Models\Admin\HospitalDepartment;
use App\Models\Admin\HospitalTestPackage;
use App\Models\Admin\HospitalTests;
use App\Models\Admin\Investigation;
use App\Models\Admin\Journal;
use App\Models\DoctorAppointment;
use App\Models\HomeTestService;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Dashboard";

        $total_user = (User::toBase()->count() == 0) ? 1 : User::toBase()->count();
        $unverified_user = User::toBase()->where('email_verified', 0)->count();
        $active_user = User::toBase()->where('status', true)->count();
        $banned_user = User::toBase()->where('status', false)->count();
        $user_percent =(($active_user * 100) / $total_user);

        if($user_percent > 100){
            $user_percent = 100;
        }

        $total_journals   = Journal::toBase()->count();
        $active_journal   = Journal::toBase()->where('status',true)->count();
        $pending_journal = Journal::toBase()->where('status',false)->count();
        $journal_percent  = (($active_journal *100) / $total_journals);

        if($journal_percent > 100){
            $journal_percent = 100;
        }

        $total_branches      = (HospitalBranch::toBase()->count() == 0) ? 1 : HospitalBranch::toBase()->count();
        $active_branches     = HospitalBranch::toBase()->where('status',true)->count();
        $pending_branches    = HospitalBranch::toBase()->where('status',false)->count();
        $branch_percent      = (($active_branches * 100) / $total_branches);
        
        if($branch_percent > 100){
            $branch_percent = 100;
        }

        $total_departments    = (HospitalDepartment::toBase()->count() == 0) ? 1 : HospitalDepartment::toBase()->count();
        $active_departments   = HospitalDepartment::toBase()->where('status',true)->count();
        $pending_departments  = HospitalDepartment::toBase()->where('status',false)->count();
        $department_percent   = (($active_departments * 100) / $total_departments);

        if($total_departments > 100){
            $total_departments = 100;
        }

        $total_hospital_tests   = (Investigation::toBase()->count() ==0 ) ? 1 : Investigation::toBase()->count();
        $active_hospital_tests  = Investigation::toBase()->where('status',true)->count();
        $pending_hospital_tests = Investigation::toBase()->where('status',false)->count();
        $hospital_test_percent  = (($active_hospital_tests * 100) / $total_hospital_tests);

        if($hospital_test_percent > 100){
            $hospital_test_percent = 100;
        }

        $total_packages         = (HealthPackage::toBase()->count() == 0) ? 1 : HealthPackage::toBase()->count();
        $active_packages        = HealthPackage::toBase()->where('status',true)->count();
        $pending_packages       = HealthPackage::toBase()->where('status',false)->count();
        $package_percent        = (($active_packages * 100 ) / $total_packages);

        if($package_percent > 100){
            $package_percent = 100;
        }

        $total_doctors          = (Doctor::toBase()->count() == 0) ? 1 : Doctor::toBase()->count();
        $active_doctors         = Doctor::toBase()->where('status',true)->count();
        $pending_doctors        = Doctor::toBase()->where('status',false)->count();
        $doctor_percent         = (($active_doctors * 100) / $total_doctors);

        if($doctor_percent > 100){
            $doctor_percent = 100;
        }

        $appointment_booking    = (DoctorAppointment::toBase()->count() == 0) ? 1 : DoctorAppointment::toBase()->count();
        $active_appointment     = DoctorAppointment::toBase()->where('status',true)->count();
        $pending_appointment    = DoctorAppointment::toBase()->where('status',false)->count();
        $appointment_percent    = (($active_appointment * 100) / $appointment_booking);

        if($appointment_percent > 100){
            $appointment_percent = 100;
        }

        $total_home_service     = (HomeTestService::toBase()->count() == 0) ? 1 : HomeTestService::toBase()->count();
        $active_home_service    = HomeTestService::toBase()->where('status',true)->count();
        $pending_home_service   = HomeTestService::toBase()->where('status',false)->count();
        $home_service_percent   = (($active_home_service * 100) / $total_home_service);
        
        if($home_service_percent > 100){
            $home_service_percent = 100;
        }
        $user_chart = [$active_user, $banned_user,$unverified_user,$total_user];

        $appointment_booking_chart = [ $appointment_booking, $active_appointment, $pending_appointment];

        $home_service_chart           = [ $total_home_service, $active_home_service, $pending_home_service];
        $data                   = [
            'total_user'      => $total_user,
            'unverified_user' => $unverified_user,
            'active_user'     => $active_user,
            'user_percent'    => $user_percent,

            'total_journals'      => $total_journals,
            'active_journal'     => $active_journal,
            'pending_journal'   => $pending_journal,
            'journal_percent'    => $journal_percent,

            'total_branches'      => $total_branches,
            'active_branches'     => $active_branches,
            'pending_branches'    => $pending_branches,
            'branch_percent'      => $branch_percent,

            'total_departments'   => $total_departments,
            'active_departments'  => $active_departments,
            'pending_departments' => $pending_departments,
            'department_percent'  => $department_percent,

            'total_hospital_tests' => $total_hospital_tests,
            'active_hospital_tests' => $active_hospital_tests,
            'pending_hospital_tests' => $pending_hospital_tests,
            'hospital_test_percent' => $hospital_test_percent,

            'total_packages'      =>  $total_packages,
            'active_packages'      =>  $active_packages,
            'pending_packages'      =>  $pending_packages,
            'package_percent'      =>  $package_percent,

            'total_doctors'       => $total_doctors,
            'active_doctors'      => $active_doctors,
            'pending_doctors'      => $pending_doctors,
            'doctor_percent'      => $doctor_percent,

            'appointment_booking'  => $appointment_booking,
            'active_appointment'   => $active_appointment,
            'pending_appointment'  => $pending_appointment,
            'appointment_percent'  => $appointment_percent,

            'total_home_service'   => $total_home_service,
            'active_home_service'  => $active_home_service,
            'pending_home_service' => $pending_home_service,
            'home_service_percent' => $home_service_percent,

            'user_chart_data'           => $user_chart,
            'appointment_booking_chart' => $appointment_booking_chart,
            'home_service_chart'     => $home_service_chart,

        ];
        
        $recent_appointment = DoctorAppointment::with(['doctors'])->where('status',true)->latest()->take(5)->get();

        return view('admin.sections.dashboard.index',compact(
            'page_title',
            'data',
            'recent_appointment',
        ));
    }


    /**
     * Logout Admin From Dashboard
     * @return view
     */
    public function logout(Request $request) {

        $push_notification_setting = BasicSettingsProvider::get()->push_notification_config;

        if($push_notification_setting) {
            $method = $push_notification_setting->method ?? false;

            if($method == "pusher") {
                $instant_id     = $push_notification_setting->instance_id ?? false;
                $primary_key    = $push_notification_setting->primary_key ?? false;

                if($instant_id && $primary_key) {
                    $pusher_instance = new PushNotifications([
                        "instanceId"    => $instant_id,
                        "secretKey"     => $primary_key,
                    ]);

                    $pusher_instance->deleteUser("".Auth::user()->id."");
                }
            }

        }

        $admin = auth()->user();
        try{
            $admin->update([
                'last_logged_out'   => now(),
                'login_status'      => false,
            ]);
        }catch(Exception $e) {
            // Handle Error
        }

        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    /**
     * Function for clear admin notification
     */
    public function notificationsClear() {
        $admin = auth()->user();

        if(!$admin) {
            return false;
        }

        try{
            $admin->update([
                'notification_clear_at'     => now(),
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went wrong! Please try again.']];
            return Response::error($error,null,404);
        }

        $success = ['success' => ['Notifications clear successfully!']];
        return Response::success($success,null,200);
    }
}
