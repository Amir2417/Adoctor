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
    ], 'active' => __("Investigations")])
@endsection

@section("content")
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __($page_title)}}</h5>
                <div class="table-btn-area">
                    @include("admin.components.link.add-default",[
                        'text'        => __("Add Investigation"),
                        'href'        => "#add-investigation",
                        "class"       => "modal-btn",
                        'permission'  => "admin.investigation.store"

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
                            <th>{{ __("Category") }}</th>
                            <th>{{ __("Last Edit By") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($investigations ?? [] as $key => $item)
                            <tr data-item="{{ $item }}">
                                <td>{{ $item->name }}</td>
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
                                       'options'     => [__("Enable") => 1, __("Disable") => 0 ],
                                       'onload'      => true,
                                       'data_target' => $item->id,
                                    ])
                                </td>
                                <td>
                                    @if ($item->home_service == true)
                                        <span class="badge badge--primary">{{ __("Home Service") }}</span>
                                      
                                    @else
                                        <span class="badge badge--danger">{{ __("Investigation") }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->admin->full_name}}</td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'class'  => "edit-modal-button",
                                        'permission' => "admin.investigation.update"
                                    ])
                                    <button class="btn btn--base btn--danger delete-modal-button"><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include("admin.components.alerts.empty",["colspan" =>4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ get_paginate($investigations) }}
    </div>
    @include("admin.components.modals.investigation.add")

    @include("admin.components.modals.investigation.edit")
@endsection

@push('script')
    <script>
        openModalWhenError("add-investigation","#add-investigation");
        $(document).ready(function(){
            switcherAjax("{{ setRoute('admin.investigation.status.update') }}");
        });
        
        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var actionRoute = "{{ setRoute('admin.investigation.delete') }}";
            var target = oldData.id;
            var message = `Are you sure to <span>delete</span> this test?`;

            openDeleteModal(actionRoute,target,message);
        });
    </script>
@endpush