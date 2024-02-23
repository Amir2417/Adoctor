@extends('frontend.layouts.master')

@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="booking-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 col-md-12 mb-30">
                <div class="booking-area">
                    <div class="content pt-0">
                        <h3 class="title"><i class="fas fa-info-circle text--base mb-20"></i>{{ __("Appointment Preview") }}</h3>
                        <div class="list-wrapper">
                            <ul class="list">
                                <li>{{ __("Doctor Name") }}:<span>{{ $patient->doctors->name ?? "" }}</span></li>
                                <li>{{ __("Speciality") }}:<span>{{ $patient->doctors->speciality ?? "" }}</span></li>
                                <li>{{ __("Schedule") }}:<span>{{ $patient->schedules->week->day ?? "" }}</span></li>
                                <li>{{ __("Patient Name") }}:<span>{{ $patient->name ?? "" }}</span></li>
                                <li>{{ __("Mobile") }}:<span>{{ $patient->phone ?? "" }}</span></li>
                                <li>{{ __("Email") }}:<span class="text-lowercase">{{ $patient->email ?? "" }}</span></li>
                                <li>{{ __("Type") }}:<span>{{ $patient->type ?? "" }}</span></li>
                                <li>{{ __("Gender") }}:<span>{{ $patient->gender ?? "" }}</span></li>
                                <li>{{ __("Total Fees") }}:<span>{{ $patient->details->total_charge ?? "" }}</span></li>
                                <li>{{ __("Payable Amount") }}:<span>{{ $patient-> ?? "" }}</span></li>
                                <li>{{ __("Gender") }}:<span>{{ $patient->gender ?? "" }}</span></li>
                            </ul>
                        </div>
                        <div class="btn-area mt-20">
                            @if ($patient->status == 1 )
                                <button disabled class="btn--base small w-100">{{ __("Already Confirmed") }}<i class="fas fa-check-circle ms-1"></i></button>
                            @else
                                <a class="btn--base small w-100" href="{{ setRoute('frontend.appointment.booking.confirm',$patient->slug) }}">{{ __("Confirm Appointment") }}<i class="fas fa-check-circle ms-1"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection