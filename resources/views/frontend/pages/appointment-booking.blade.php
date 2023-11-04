@extends('frontend.layouts.master')



@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="booking-section ptb-120">
    <div class="container">
        <form class="booking-form" action="{{ setRoute('frontend.appointment.booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="doctor" value="{{ $doctor->slug }}">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-5 col-lg-6 col-md-12 mb-30">
                    <div class="booking-area">
                        <div class="thumb">
                            <img src="{{ get_image($doctor->image ?? '' , 'site-section') ?? '' }}" alt="profile">
                        </div>
                        <div class="content">
                            <h4 class="title"><i class="fas fa-user text--base me-2"></i>{{ $doctor->name ?? "" }}</h4>
                            <div class="list-wrapper">
                                <ul class="list">
                                    <li>{{ __("Qualifications") }}:<span>{{ $doctor->qualification ?? "" }}</span></li>
                                    <li>{{ __("Speciality") }}:<span>{{ $doctor->speciality ?? "" }}</span></li>
                                    <li>{{ __("Language Spoken") }}:<span>{{ $doctor->language?? "" }}</span></li>
                                    <li>{{ __("Designation") }}:<span>{{ $doctor->designation ?? "" }}</span></li>
                                    <li>{{ __("Department Name") }}:<span>{{ $doctor['department']['name'] ?? ""}}</span></li>
                                </ul>
                            </div>
                            <div class="list-wrapper pt-20">
                                <h4 class="title text--base"><i class="fas fa-info-circle"></i> {{__("Chamber")}}</h4>
                                <ul class="list">
                                    <li>{{ __("Contact") }}:<span>{{ $doctor->contact ?? ""}}</span></li>
                                    <li>{{ __("Off Day") }}:<span>{{ $doctor->off_days ?? "" }}</span></li>
                                    <li>{{ __("Floor Number") }}:<span>{{ $doctor->floor_number ?? "" }}</span></li>
                                    <li>{{ __("Room Number") }}:<span>{{ $doctor->room_number ?? "" }}</span></li>
                                    <li>{{ __("Branch Name") }}:<span>{{ $doctor['branch']['name'] ?? "" }}</span></li>
                                    <li>{{ __("Address") }}:<span>{{ $doctor->address ?? "" }}</span></li>
                                    <li>{{ __("Fees") }}:<span>{{ get_amount($doctor->fees) ?? "" }} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span></li>
                                </ul>
                            </div>
                            <div class="list-wrapper pt-20">
                                <h4 class="title text--base"><i class="fas fa-history"></i> {{__("Schedule")}}</h4>
                                <div class="shedule-option pt-10">
                                    @foreach ($doctor->schedules as $day)
                                        <div class="shedule-item">
                                            @php
                                                $from_time = $day->from_time ?? '';
                                                $parsed_from_time = \Carbon\Carbon::createFromFormat('H:i', $from_time)->format('h A');

                                                $to_time   = $day->to_time ?? '';
                                                $parsed_to_time = \Carbon\Carbon::createFromFormat('H:i', $to_time)->format('h A');
                                            @endphp
                                            <div class="shedule-inner">
                                                <input type="radio" name="schedule" value="{{ $day->id }}" class="hide-input" id="shedule_{{$day->id}}">
                                                <label for="shedule_{{$day->id}}" class="package--amount">
                                                    <strong>{{ $day->week->day }}</strong>
                                                    <sup>
                                                        {{ $parsed_from_time }} -
                                                    </sup>
                                                    <sup>
                                                        {{ $parsed_to_time }}
                                                    </sup>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($validated_user)
                    <div class="col-xl-7 col-lg-6 col-md-12 mb-30">
                        <div class="booking-area fixed">
                            <h3 class="title"><i class="fas fa-info-circle text--base mb-20"></i> {{__("Appointment Form")}}</h3>
                            <div class="row justify-content-center mb-20-none">
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Patient Name").'<span class="text--base">*</span>',
                                        'name'         => 'name',
                                        'value'        => $validated_user->fullName,
                                        'attribute'    => "readonly",
                                        'placeholder'  => __("Enter Name").'...',
                                    ])
                                </div>
                                @if ($validated_user->full_mobile)
                                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                        @include('admin.components.form.input',[
                                            'label'        => __("Mobile").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                            'name'         => 'phone',
                                            'value'        => $validated_user->full_mobile,
                                            'attribute'    => "readonly",
                                            'placeholder'  => __("Mobile").'...',
                                        ])
                                    </div> 
                                @else
                                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                        @include('admin.components.form.input',[
                                            'label'        => __("Mobile").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                            'name'         => 'phone',
                                            'value'        => old('phone'),
                                            'placeholder'  => __("Mobile").'...',
                                        ])
                                    </div>
                                @endif
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Email").'<span class="text--base">*</span>',
                                        'name'         => 'email',
                                        'value'        => $validated_user->email,
                                        'attribute'    => 'readonly',
                                        'placeholder'  => __("Email").'...'
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    <label>{{ __("Age") }} <span class="text--base">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="age" min="1" class="form--control" placeholder="{{ __("Enter your age") }}">
                                        <select name="age_type" class="form--control">
                                            <option  selected value="Years">{{ __("Years") }}</option>
                                            <option value="Months">{{ __("Months") }}</option>
                                            <option value="Days">{{ __("Days") }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label>{{ __("Type") }}<span class="text--base">*</span></label>
                                        <select class="form--control" name="type">
                                            <option selected disabled>{{ __("Select Type") }}</option>
                                            <option value="{{ global_const()::APPOINTMENT_TYPE_NEW }}">{{ global_const()::APPOINTMENT_TYPE_NEW }}</option>
                                            <option value="{{ global_const()::APPOINTMENT_TYPE_REPORT }}">{{ global_const()::APPOINTMENT_TYPE_REPORT }}</option>
                                            <option value="{{ global_const()::APPOINTMENT_TYPE_FOLLOWUP }}">{{ global_const()::APPOINTMENT_TYPE_FOLLOWUP }}</option>
                                        </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label>{{ __("Gender") }}<span class="text--base">*</span></label>
                                        <select class="form--control" name="gender">
                                            <option selected disabled>{{ __("Select Gender") }}</option>
                                            <option value="{{ global_const()::GENDER_MALE }}">{{ global_const()::GENDER_MALE }}</option>
                                            <option value="{{ global_const()::GENDER_FEMALE }}">{{ global_const()::GENDER_FEMALE }}</option>
                                            <option value="{{ global_const()::GENDER_OTHER }}">{{global_const()::GENDER_OTHER }}</option>
                                        </select>
                                </div>
                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.textarea',[
                                        'label'         => __("Message").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                        'name'          => 'message',
                                        'placeholder'   => __("Write Here")."...",
                                        'value'         => old("message")
                                    ])
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn--base small w-100">{{__("Proceed")}} <i class="fas fa-chevron-circle-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div> 
                @else
                    <div class="col-xl-7 col-lg-6 col-md-12 mb-30">
                        <div class="booking-area fixed">
                            <h3 class="title"><i class="fas fa-info-circle text--base mb-20"></i>{{ __("Appointment Form") }}</h3>
                            <div class="row justify-content-center mb-20-none">
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Patient Name").'<span class="text--base">*</span>',
                                        'name'         => 'name',
                                        'value'        => old('name'),
                                        'placeholder'  => __("Enter Name").'...',
                                    ])
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Mobile").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                        'name'         => 'phone',
                                        'value'        => old('phone'),
                                        'placeholder'  => __("Mobile").'...',
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'        => __("Email").'<span class="text--base">*</span>',
                                        'name'         => 'email',
                                        'value'        => old('email'),
                                        'placeholder'  => __("Email").'...'
                                    ])
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    <label>{{ __("Age") }} <span class="text--base">*</span></label>
                                    @php
                                        $age_type   = old("age_type");  
                                    @endphp
                                    <div class="input-group">
                                        <input type="number" name="age" value="{{ old("age") }}" min="1" class="form--control" placeholder="{{ __("Enter your age") }}">
                                        <select name="age_type" class="form--control">
                                            <option  selected value="Years" @if ($age_type == "Years") selected @endif>{{ __("Years") }}</option>
                                            <option value="Months" @if ($age_type == "Months") selected @endif>{{ __("Months") }}</option>
                                            <option value="Days" @if ($age_type == "Days") selected @endif>{{ __("Days") }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label>{{ __("Type")}} <span class="text--base">*</span></label>
                                        @php
                                            $type = old("type");
                                        @endphp
                                        <select class="form--control" name="type">
                                            <option selected disabled>{{ __("Select Type") }}</option>
                                            <option value="{{ global_const()::APPOINTMENT_TYPE_NEW }}"  @if ($type == global_const()::APPOINTMENT_TYPE_NEW ) selected @endif>{{ global_const()::APPOINTMENT_TYPE_NEW }}</option>

                                            <option value="{{ global_const()::APPOINTMENT_TYPE_REPORT }}"  @if ($type == global_const()::APPOINTMENT_TYPE_REPORT ) selected @endif>{{ global_const()::APPOINTMENT_TYPE_REPORT }}</option>

                                            <option value="{{ global_const()::APPOINTMENT_TYPE_FOLLOWUP }}" @if ($type == global_const()::APPOINTMENT_TYPE_FOLLOWUP ) selected @endif>{{ global_const()::APPOINTMENT_TYPE_FOLLOWUP }}</option>
                                        </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label>{{ __("Gender")}}<span class="text--base">*</span></label>
                                    @php
                                        $gender  = old("gender");
                                    @endphp
                                    <select class="form--control" name="gender" value="{{ old('gender')}}">
                                        <option selected disabled>{{ __("Select Gender") }}</option>
                                        <option value="{{ global_const()::GENDER_MALE }}" @if ($gender == global_const()::GENDER_MALE ) selected @endif>{{ global_const()::GENDER_MALE }}</option>
                                        <option value="{{ global_const()::GENDER_FEMALE }}" @if ($gender == global_const()::GENDER_FEMALE ) selected @endif>{{ global_const()::GENDER_FEMALE }}</option>
                                        <option value="{{global_const()::GENDER_OTHER }}" @if ($gender == global_const()::GENDER_OTHER ) selected @endif>{{global_const()::GENDER_OTHER }}</option>
                                    </select>
                                </div>
                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.textarea',[
                                        'label'         => __("Message").'<span class="text--warning">'.'('.__("Optional").')'.'</span>',
                                        'name'          => 'message',
                                        'value'         => old('message'),
                                        'placeholder'   => __("Write Here")."...",
                                    ])    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn--base small w-100">{{ __("Proceed") }}<i class="fas fa-chevron-circle-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>  
                @endif
                
            </div>
        </form>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Booking section  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection