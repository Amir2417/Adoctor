@extends('admin.layouts.master')

@push('css')

    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ],
        [
            'name'  => __("Appointments"),
            'url'   => setRoute("admin.booking.index"),
        ]
    ], 'active' => __("Booking Details")])
@endsection
@section('content')
<div class="row mb-30-none">
    <div class="col-lg-4 mb-30">
        <div class="booking-area">
            <h4 class="title"><i class="fas fa-user text--base me-2"></i>{{ __("Doctor Information") }}</h4>
            <div class="thumb">
                <img src="{{ get_image($appointment->doctors->image ?? '','site-section') ?? '' }}" alt="profile">
            </div>
            <div class="content">
                <div class="list-wrapper">
                    <ul class="list">
                        <li>{{ __("Name") }}:<span>{{ $appointment->doctors->name ?? "" }}</span></li>
                        <li>{{ __("Qualifications") }}:<span>{{ $appointment->doctors->qualification ?? "" }}</span></li>
                        <li>{{ __("Speciality") }}:<span>{{ $appointment->doctors->speciality ?? "" }}</span></li>
                        <li>{{ __("Contact") }}:<span>{{ $appointment->doctors->contact ?? "" }}</span></li>
                        <li>{{ __("Floor Number") }}:<span>{{ $appointment->doctors->floor_number ?? "" }}</span></li>
                        <li>{{ __("Room Number") }}:<span>{{ $appointment->doctors->room_number ?? "" }}</span></li>
                        <li>{{ __("Max") }} {{ __("Patient") }}:<span>{{ $appointment->schedules->max_patient ?? "" }}</span></li>
                        <li>{{ __("Fees") }}:<span>{{ get_amount($appointment->doctors->fees ?? "") }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-30">
        <div class="booking-area">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="title mb-0"><i class="fas fa-user text--base me-2"></i>{{ __("Patient Information") }}</h4>
                <div>
                    @include('admin.components.link.custom',[
                        'href'          => "#send-reply",
                        'class'         => "btn btn--base reply-button modal-btn",
                        'icon'          => "las la-reply-all",
                        'permission'    => "admin.booking.messages.reply",
                    ])
                </div>
            </div>
           
            <div class="content pt-0">
                <div class="list-wrapper">
                    <ul class="list">
                        <li>{{ __("Name") }}:<span>{{ $appointment->name ?? "" }}</span></li>
                        <li>{{ __("Email") }}:<span>{{ $appointment->email ?? "" }}</span></li>
                        <li>{{ __("Phone") }}:<span>{{ $appointment->phone ?? "" }}</span></li>
                        <li>{{ __("Gender") }}:<span>{{ $appointment->gender ?? "" }}</span></li>
                        <li>{{ __("Type") }}:<span>{{ $appointment->type?? "" }}</span></li>
                        <li>{{ __("Message") }}:<span>{{ $appointment->message ?? "" }}</span></li>
                        <li>{{ __("Patient Number") }}:<span>{{ $appointment->patient_number ?? "" }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-30">
        <div class="booking-area">
            <h4 class="title"><i class="fas fa-user text--base me-2"></i>{{ __("Schedule Information") }}</h4>
            <div class="content pt-0">
                <div class="list-wrapper">
                    <ul class="list">
                        @php
                            $from_time = $appointment->schedules->from_time ?? '';
                            $parsed_from_time = \Carbon\Carbon::createFromFormat('H:i', $from_time)->format('h A');

                            $to_time   = $appointment->schedules->to_time ?? '';
                            $parsed_to_time = \Carbon\Carbon::createFromFormat('H:i', $to_time)->format('h A');
                        @endphp
                        <li>{{ __("Day") }}:<span>{{ $appointment->schedules->week->day ?? "" }}</span></li>
                        <li>{{ __("From Time") }}:<span>{{ $parsed_from_time ?? "" }}</span></li>
                        <li>{{ __("To Time") }}:<span>{{ $parsed_to_time ?? "" }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@if (admin_permission_by_name("admin.booking.messages.reply"))
        <div id="send-reply" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header px-0">
                    <h5 class="modal-title">{{ __("Send Reply") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="card-form" action="{{ setRoute('admin.booking.messages.reply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="target" value="{{ old('target') }}">
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __("Subject")."*",
                                    'name'          => "subject",
                                    'data_limit'    => 150,
                                    'placeholder'   => __("Write Subject")."...",
                                    'value'         => old('subject'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input-text-rich',[
                                    'label'         => __("Details")."*",
                                    'name'          => "message",
                                    'value'         => old('message'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.button.form-btn',[
                                    'class'         => "w-100 btn-loading",
                                    'permission'    => "admin.subscriber.send.mail",
                                    'text'          => __("Send Email"),
                                ])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


@endsection
@push('script')
    <script>
        openModalWhenError("send-reply","#send-reply");
        $(".reply-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            $("#send-reply").find("input[name=target]").val(oldData.id);
        });
    </script>
@endpush