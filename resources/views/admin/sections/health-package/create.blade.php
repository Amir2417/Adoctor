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
            'name'  => __("Health Packages"),
            'url'   => setRoute("admin.health.package.index"),
        ]
    ], 'active' => __("Health Package Create")])
@endsection

@section('content')
<div class="custom-card">
    <div class="card-header">
        <h6 class="title">{{ __($page_title) }}</h6>
    </div>
    <div class="card-body">
        <form class="card-form" action="{{ setRoute('admin.health.package.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-10-none">
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'             => "Package Name*",
                        'name'              => "name",
                        'placeholder'       => "Write Name...",
                        'value'             => old('name'),  
                    ])
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'             => "Package Title",
                        'name'              => "title",
                        'placeholder'       => "Write Title...",
                        'value'             => old('title'),  
                    ])
                </div>
                
                {{-- <div class="col-xl-12 col-lg-12 form-group">
                    <label for="test"> {{ __("Test Name*") }} </label>
                    <div class="custom-check-list">
                        @foreach ($hospital_tests as $item)
                        
                        <div class="custom-check-group">
                            <input type="checkbox" class="payment-gateway-currency" name="tests[]" value="{{ $item->id}}" id="dp-{{$item->id}}">
                            <label for="dp-{{$item->id}}">{{$item->name}}</label>
                        </div>
                        
                        @endforeach
                    </div>
                </div> --}}
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Regular Price*",
                        'name'          => 'price',
                        'class'         => "number-input",
                        'placeholder'   => 'Write Price...',
                        'value'         => old('price'),
                    ])
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Offer Price",
                        'name'          => "offer_price",
                        'class'         => "number-input",
                        'placeholder'   => "Write Offer Price...",
                        'value'         => old('offer_price'),
                    ])
                </div>
                
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.button.form-btn',[
                        'class'         => "w-100 btn-loading",
                        'text'          => "Submit",
                        'permission'    => "admin.health.package.store"
                    ])
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

