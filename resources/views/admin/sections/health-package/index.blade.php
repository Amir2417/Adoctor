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
    ], 'active' => __("Health Packages")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __($page_title) }}</h5>
                <div class="table-btn-area">
                    @include("admin.components.link.add-default",[
                        'text'        => __("Add Health Package"),
                        'href'        => "#add-health-package",
                        "class"       => "modal-btn",
                        'permission'  => "admin.health.package.store"

                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("Price") }}</th>
                            <th>{{ __("Status") }}</th>
                            <th>{{ __("Last Edit By") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($health_packages ?? [] as $key => $item)
                            <tr data-item="{{ $item }}">
                                <td>{{ $item->name ?? ''}}</td>
                                
                                <td>
                                    @if($item->offer_price)
                                    <span class="price">{{ get_amount($item->offer_price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span>
                                    <del>{{ get_amount($item->price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</del>
                                    @else
                                    <span>{{ get_amount($item->price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span>
                                    @endif
                                </td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'        => 'status',
                                        'value'       => $item->status,
                                        'options'     => [__("Enable") => 1, __("Disable") => 0],
                                        'onload'      => true,
                                        'data_target' => $item->id,
                                    ])
                                </td>
                                <td>{{ $item->admin->full_name ?? ''}}</td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'class'  => "edit-modal-button",
                                        'permission' => "admin.health.package.update"
                                    ])
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ get_paginate($health_packages) }}
    </div>
    @include('admin.components.modals.health-package.add')

    @include('admin.components.modals.health-package.edit')
    
@endsection
@push('script')
    <script>
        openModalWhenError("add-health-package","#add-health-package");
        $(".delete-modal-button").click(function(){
            var oldData     = JSON.parse($(this).parents("tr").attr("data-item"));
            var actionRoute = "{{ setRoute('admin.health.package.delete') }}";
            var target      = oldData.id;
            var message     = `Are you sure to <strong>delete</strong> this Package?`;

            openDeleteModal(actionRoute,target,message);

        });

        $(document).ready(function(){
            // Switcher
            switcherAjax("{{ setRoute('admin.health.package.status.update') }}");
        })
    </script>
@endpush