@extends('user.layouts.master')

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="body-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="booking-area">
                <h4 class="title"><i class="fas fa-user text--base me-2"></i>{{__("Home Service History Details")}}</h4>
                
                <div class="content">
                    <div class="list-wrapper">
                        <ul class="list">
                            @php
                                $types  = implode(', ',$booking->type ?? []);
                            @endphp
                            <li>{{ __("Name") }}:<span>{{ $booking->name ?? "" }}</span></li>
                            <li>{{ __("Email") }}:<span>{{ $booking->email ?? "" }}</span></li>
                            <li>{{ __("Contact") }}:<span>{{ $booking->phone?? "" }}</span></li>
                            <li>{{ __("Gender") }}:<span>{{ $booking->gender ?? "" }}</span></li>
                            <li>{{ __("Type") }}:<span>{{ $types ?? "" }}</span></li>
                            <li>{{ __("Schedule") }}:<span>{{ $booking->schedule ?? "" }}</span></li>
                            <li>{{ __("Address") }}:<span>{{ $booking->address ?? "" }}</span></li>
                            <li>{{ __("Message") }}:<span>{{ $booking->message ?? "" }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection