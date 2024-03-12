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
        ]
    ], 'active' => __("Home Service")])
@endsection
@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __($page_title) }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __("Patient Name") }}</th>
                            <th>{{ __("Patient Email") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($booking_appointments ?? [] as $key => $item)
                            <tr data-item="{{ json_encode($item->only(['id'])) }}">
                                <td>{{ $key + $booking_appointments->firstItem() }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                
                                <td>
                                    @include('admin.components.link.custom',[
                                        'href'          => "#send-reply",
                                        'class'         => "btn btn--base reply-button modal-btn",
                                        'icon'          => "las la-reply-all",
                                        'permission'    => "admin.home.service.messages.reply",
                                    ])
                                    <a href="{{ setRoute('admin.home.service.details',$item->slug)}}" class="btn btn--base btn--primary"><i class="las la-info-circle"></i></a>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ get_paginate($booking_appointments) }}
    </div>
    {{-- Send Mail Modal --}}
    @if (admin_permission_by_name("admin.home.service.messages.reply"))
        <div id="send-reply" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header px-0">
                    <h5 class="modal-title">{{ __("Send Reply") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="card-form" action="{{ setRoute('admin.home.service.messages.reply') }}" method="POST">
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
                                    'permission'    => "admin.home.service.messages.reply",
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
