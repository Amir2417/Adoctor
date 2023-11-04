@extends('frontend.layouts.master')

@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="banner-flotting-section home pt-120 mb-20">
    <div class="container">
        <div class="banner-flotting-item">
            <form action="{{ setRoute('frontend.health.package.search') }}" method="GET">
                <div class="row mb-30-none justify-content-center">
                    <div class="col-lg-9 col-md-9 col-sm-8 mb-30">
                        <input type="search" name="package" value="{{ $search_string ?? "" }}" class="form--control" placeholder="{{ __("Search") }}...">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 mb-30">
                        <div class="branch-btn-search">
                            <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i>{{ __("Search") }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start  Investigation Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="investigation-section pb-120 pt-30">
    <div class="container">
        <div class="investigation-area">
            <div class="row justify-content-center mb-30-none">
                @forelse ($packages as $item)
                    <div class="col-lg-3 col-md-6 mb-30">
                        <div class="investigation-item">
                            <h3 class="title">{{ $item->name ?? "" }}</h3>
                            @if ($item->offer_price)
                                <span class="price text--base">{{ __("Price") }}: {{ get_amount($item->offer_price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span>
                                <span class="price-cut">{{ get_amount($item->price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span>
                            @else
                                <span class="price text--base">{{ __("Price") }}: {{ get_amount($item->price)  ?? ""}} {{App\Providers\Admin\CurrencyProvider::default()->code}}</span>
                            @endif
                            
                            <p>{{ $item->title ?? "" }}</p>
                        </div>
                    </div>
                @empty
                <div class="col-lg-12">
                    <h5 class="text-danger text-center">{{ __("Health Package not found") }}!</h5>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  Investigation Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection