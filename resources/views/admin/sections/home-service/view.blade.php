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
            'name'  => __("Home Service"),
            'url'   => setRoute("admin.home.service.index"),
        ]
    ], 'active' => __("Booking Details")])
@endsection
@section('content')
<div class="row mb-30-none">
    <div class="col-lg-12 mb-30">
        <div class="booking-area">
            <h4 class="title"><i class="fas fa-user text--base me-2"></i>{{ __("Patient Information") }}</h4>
            <div class="content pt-0">
                <div class="list-wrapper">
                    @php
                        $types  = implode(', ',$appointment->type ?? []);
                    @endphp
                    <ul class="list">
                        <li>{{ __("Name") }}:<span>{{ $appointment->name ?? "" }}</span></li>
                        <li>{{ __("Email") }}:<span>{{ $appointment->email ?? "" }}</span></li>
                        <li>{{ __("Phone") }}:<span>{{ $appointment->phone ?? "" }}</span></li>
                        <li>{{ __("Gender") }}:<span>{{ $appointment->gender ?? "" }}</span></li>
                        <li>{{ __("Type") }}:<span>{{ $types ?? "" }}</span></li>
                        <li>{{ __("Schedule") }}:<span>{{ $appointment->schedule ?? "" }}</span></li>
                        <li>{{ __("Address") }}:<span>{{ $appointment->address ?? "" }}</span></li>
                        <li>{{ __("Message") }}:<span>{{ $appointment->message ?? "" }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
