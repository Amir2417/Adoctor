@extends('frontend.layouts.master')

@push('css')
    <style>
        .package--amount img{
            height: 50px;
            width: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin: 10px;
            object-fit: contain;
            border: 1px solid #e4dfdf;
        }
    </style>
@endpush

@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="booking-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 col-md-12 mb-30">
                <div class="booking-area">
                    <form action="{{ setRoute('frontend.appointment.booking.confirm',$patient->slug) }}" method="post">
                        @csrf
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
                                    <li>{{ __("Docrtor Fees") }}:<span>{{ get_amount($patient->details->doctor_fees,get_default_currency_code()) }}</span></li>
                                    <li>{{ __("Fees & Charges") }}:<span>{{ get_amount($patient->details->total_charge,get_default_currency_code()) }}</span></li>
                                    <li>{{ __("Payable Amount") }}:<span>{{ get_amount($patient->details->payable_amount,get_default_currency_code()) }}</span></li>
                                </ul>
                            </div>
                            <div class="payment-type pt-4">
                                <div class="form-group">
                                    <h4 class="title text--base"><i class="fas fa-spinner"></i> {{ __("Select Payment Method") }} *</h4>
                                    <div class="shedule-option pt-10">
                                        <div class="shedule-item">
                                            <div class="shedule-inner">
                                                <input type="radio" id="cashPayment" class="hide-input" value="{{ global_const()::CASH_PAYMENT }}" checked name="selected_payment_method">
                                                <label for="cashPayment" class="package--amount d-flex align-items-center justify-content-center"><img src="{{ asset("public/frontend/images/cashpay.png") }}" alt="icon">{{ __("Cash-Payment") }}</label>
                                            </div>
                                        </div>
                                        <div class="shedule-item">
                                            <div class="shedule-inner">
                                                <input type="radio" id="onlinePayment" class="hide-input" value="" name="selected_payment_method">
                                                <label for="onlinePayment" class="package--amount d-flex align-items-center justify-content-center"><img src="{{ asset("public/frontend/images/cashpay.png") }}" alt="icon">{{ __("Online-Payment") }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shedule-option collapse pt-10">
                                        @foreach ($payment_gateway as $item)
                                        <div class="shedule-item">
                                            <div class="shedule-inner">
                                                <input type="radio" id="level_{{ $item->id }}" class="hide-input" name="payment_method" value="{{ $item->alias }}">
                                                <label for="level_{{ $item->id }}" class="package--amount d-flex align-items-center justify-content-center"><img src="{{ get_image($item->image ,'payment-gateways') }}" alt="icon">{{ $item->gateway->name }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="btn-area mt-20">
                                @if ($patient->status == 1 )
                                    <button disabled class="btn--base small w-100">{{ __("Already Confirmed") }}<i class="fas fa-check-circle ms-1"></i></button>
                                @else
                                    <button type="submit" class="btn--base small w-100" >{{ __("Confirm Appointment") }}<i class="fas fa-check-circle ms-1"></i></button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
        var onlinePaymentRadio = document.getElementById('onlinePayment');
        var cashPaymentRadio = document.getElementById('cashPayment');
        var collapseElement = document.querySelector('.shedule-option.collapse');

        onlinePaymentRadio.addEventListener('change', function() {
            if (this.checked) {
                collapseElement.style.display = 'flex';
            }
        });

        cashPaymentRadio.addEventListener('change', function() {
            if (this.checked) {
                collapseElement.style.display = 'none';
            }
        });
    });
    
</script>
@endpush