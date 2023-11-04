@extends('frontend.layouts.master')

@section('content')

@include('frontend.section.single-search')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start  branch Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="branch-section pb-120 pt-30">
    <div class="container">
        <div class="branch-area">
            <div class="row justify-content-center mb-50-none">
                @forelse ($branches as $item)
                    <div class="col-lg-3 col-md-6 mb-50">
                        <div class="branch-item">
                            <div class="icon-wrapper">
                                <div class="icon-area">
                                    <i class="las la-hospital"></i>
                                </div>
                            </div>
                            <h4>{{ $item->name ?? "" }}</h4>
                            <span>{{ $item->description ?? "" }}</span>
                            <div class="mt-10">{{__("Email:")}} <span class="text--base">{{ $item->email ?? "" }}</span></div>
                            <div class="mt-1">{{__("Web: ")}}<span class="text--base">{{ $item->web ?? "" }}</span></div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <h5 class="text-danger text-center">{{ __("Branch not found") }}!</h5>
                    </div>
                @endforelse 
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  branch Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection