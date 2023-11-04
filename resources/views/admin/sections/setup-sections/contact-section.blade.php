@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp

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
    ], 'active' => __("Contact Section")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Contact Section") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.setup.sections.section.update',$slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center mb-10-none">
                    
                    <div class="col-xl-12 col-lg-12">
                        <div class="product-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#{{$item->name}}" type="button" role="tab" aria-controls="{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="{{ $item->name }}" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => __("Section Title")."*",
                                                'name'          => $item->code . "_title",
                                                'placeholder'=> __('Section Title').'...',
                                                'value'         => old($item->code . "_title",$data->value->language->$lang_code->title ?? "")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => __("Description")."*",
                                                'name'          => $item->code . "_description",
                                                'placeholder'=> __('Description').'...',
                                                'value'         => old($item->code . "_description",$data->value->language->$lang_code->description ?? "")
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom my-3"></div>
                    <div class="form-group">
                        @include('admin.components.form.input',[
                            'label'         => __("Phone")."*",
                            'name'          => "phone",
                            'placeholder'   => __("Phone")."...",
                            'value'         => old("phone",$data->value->phone ?? "")
                        ])
                    </div>
                    <div class="form-group">
                        @include('admin.components.form.input',[
                            'label'         => __("Address")."*",
                            'name'          => "address",
                            'placeholder'   => __("Address")."...",
                            'value'         => old("address",$data->value->address ?? "")
                        ])
                    </div>    
                    <div class="form-group">
                        @include('admin.components.form.input',[
                            'label'         => __("Email")."*",
                            'name'          => "email",
                            'placeholder'   => __("Email")."...",
                            'value'         => old("email",$data->value->email ?? "")
                        ])
                    </div> 
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.setup.sections.section.update"
                        ])
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
@endsection
