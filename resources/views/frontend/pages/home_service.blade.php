@extends('frontend.layouts.master')

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="booking-section ptb-120">
    <div class="container">
        <form class="booking-form" action="{{ setRoute('frontend.home.service.store') }}" method="POST">
            @csrf
        <div class="row mb-30-none">
            
                <div class="col-lg-5 mb-30">
                    <div class="booking-area">
                        <div class="title-area text-center mb-30">
                            <h4 class="title">{{ __("SERVICE") }} <span class="text--base">{{ __("AT YOUR DOORSTEP") }}</span></h4>
                            <p>{{ __("No more waiting rooms, no more long commutes, and no more hassle. With our service, you can now book a doctor appointment and have a qualified healthcare professional visit you at your preferred location and time") }}.</p>
                        </div>
                        <div class="content pt-0">
                            <div class="list-wrapper">
                                <ul class="list">
                                    <li>{{ __("Address") }}:<span class="text--base">{{ $contact->value->address ?? "" }}</span></li>
                                    <li>{{ __("Contact") }}:<span class="text--base text-lowercase">{{ $contact->value->email ?? "" }}</span></li>
                                </ul>
                            </div>
                            <div class="list-wrapper pt-20">
                                <h4 class="title text--base"><i class="fas fa-history"></i> {{ __("Schedule")}}</h4>
                                <div class="shedule-option pt-10">
                                    @foreach ($dates as $key=>$date)
                                        <div class="shedule-item">
                                            <div class="shedule-inner">
                                                <input type="radio" name="schedule" value="{{ $date['day'].','.$date['date'].' '.$date['Month'].' '.$date['Year']}}" class="hide-input" id="shedule_{{ $key }}">
                                                <label for="shedule_{{ $key }}" class="package--amount">
                                                    <strong>{{ $date['day']}} {{ $date['date'] }}th</strong>
                                                    <sup>{{ $date['month']}} {{ $date['year'] }}</sup>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 mb-30">
                    <div class="booking-area fixed">
                        
                            <h3 class="title"><i class="fas fa-info-circle text--base mb-20"></i>{{ __("Appointment Form") }}</h3>
                            <div class="row justify-content-center mb-20-none">
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Patient Name").'<span class="text--base">*</span>',
                                        'name'         => 'name',
                                        'placeholder'  => __("Enter Name").'...',
                                        'value'        => old('name'),
                                    ])
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Mobile").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                        'name'         => 'phone',
                                        'placeholder'  => __("Mobile").'...',
                                        'value'        => old('phone'),
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    <label>{{ __("Age") }} <span class="text--base">*</span></label>
                                    @php
                                        $age = old("age_type");
                                    @endphp
                                    <div class="input-group">
                                        <input type="number" name="age" class="form--control" value="{{ old('age')}}" min="1" placeholder="{{ __("Enter your age") }}">
                                        <select name="age_type" class="form--control">
                                            <option  selected value="Years" @if($age == "Years") selected @endif>{{ __("Years") }}</option>
                                            <option value="Months" @if($age == "Months") selected @endif>{{ __("Months") }}</option>
                                            <option value="Days" @if($age == "Days") selected @endif>{{ __("Days") }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @php
                                        $gender   = old('gender');
                                    @endphp
                                    <label>{{ __("Gender")}}<span class="text--base">*</span></label>
                                    <select class="form--control" name="gender">
                                        <option selected disabled>{{ __("Select Gender") }}</option>
                                        <option value="{{ global_const()::GENDER_MALE }}" @if ($gender== global_const()::GENDER_MALE) selected @endif>{{ global_const()::GENDER_MALE }}</option>
                                        <option value="{{ global_const()::GENDER_FEMALE }}" @if ($gender== global_const()::GENDER_FEMALE) selected @endif>{{ global_const()::GENDER_FEMALE }}</option>
                                        <option value="{{ global_const()::GENDER_OTHER }}" @if ($gender== global_const()::GENDER_OTHER) selected @endif>{{ global_const()::GENDER_OTHER }}</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Email").'<span class="text--base">*</span>',
                                        'name'         => 'email',
                                        'placeholder'  => __("Email").'...',
                                        'value'        => old('email'),
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Address") .'<span class="text--base">*</span>',
                                        'name'         => 'address',
                                        'placeholder'  => __("Enter Address").'...',
                                        'value'        => old('address'),
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    <div class="home-check-area custom-check-group">
                                        @foreach ($hospital_tests as $item)
                                            <div class="home-check-wrapper">
                                                <input type="checkbox" name="type[]" value="{{ $item->name }}" id="home_{{$item->id}}">
                                                <label for="home_{{$item->id}}">{{ $item->name ?? ""}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.textarea',[
                                        'label'         => __("Message").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                        'name'          => 'message',
                                        'placeholder'   => __("Write Here")."...",
                                        'value'        => old('message'),
                                    ])
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn--base small">{{ __("Submit")}} <i class="fas fa-paper-plane ms-1"></i></button>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


@endsection