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
            'name'  => __("Health Package"),
            'url'   => setRoute("admin.health.package.index")
        ]
    ], 'active' => __("Health Package Edit")])
@endsection

@section('content')
<div class="custom-card">
    <div class="card-header">
        <h6 class="title">{{ __($page_title) }}</h6>
    </div>
    <div class="card-body">
        <form class="card-form" action="{{ setRoute('admin.health.package.update',$package->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row mb-10-none">
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'             => "Package Name*",
                        'name'              => "name",
                        'placeholder'       => "Write Name...",
                        'value'             => old('name',$package->name),
                        
                    ])
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'             => "Package Title",
                        'name'              => "title",
                        'placeholder'       => "Write Title...",
                        'value'             => old('title',$package->title),  
                    ])
                </div>
                
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Regular Price*",
                        'name'          => 'price',
                        'class'         => "number-input",
                        'placeholder'   => 'Write Price...',
                        'value'         => old('price',$package->price),
                    ])
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Offer Price",
                        'name'          => "offer_price",
                        'class'         => "number-input",
                        'placeholder'   => "Write Offer Price...",
                        'value'         => old('offer_price',$package->offer_price),
                    ])
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    @include('admin.components.button.form-btn',[
                        'class'         => "w-100 btn-loading",
                        'text'          => "Update",
                        'permission'    => "admin.health.package.update"
                    ])
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('script')
    <script>

       
    </script>
@endpush