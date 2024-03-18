@extends('frontend.layouts.master')


@php
    $app_local  = get_default_language_code();
@endphp
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    {{-- Start Blog   {{ setRoute('frontend.journal.details',$item->id) }} --}}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-120">
    <div class="container">
        <div class="row mb-30-none">
            <div class="col-xl-8 col-lg-8 col-md-12 mb-30">
                <div class="row mb-50-none">
                    @foreach ($journal as $item)
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-50">
                            <div class="blog-item">
                                <div class="thumb">
                                    <img src="{{ get_image($item->data->image ?? '' , 'site-section') ?? '' }}" alt="">
                                </div>
                                <div class="icon-wrapper">
                                    <div class="icon">
                                        <i class="{{ $item->data->language->$app_local->icon ?? "" }}"></i>
                                    </div>
                                </div>
                                <div class="content">
                                    <a href="{{ setRoute('frontend.journal.details',$item->slug) }}" class="title">{{ Str::words($item->data->language->$app_local->title ?? '',5,'...') }}</a>
                                    <p>{!! Str::words($item->data->language->$app_local->description ?? '' , 10 , '...') !!}</p>
                                </div>
                                <div class="blog-item-btn-area text-center">
                                    <a href="{{ setRoute('frontend.journal.details',$item->slug) }}"><i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-30">
                <div class="blog-sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Recent Posts") }}</h4>
                        <div class="popular-widget-box">
                            @foreach ($journal as $item)
                                <div class="single-popular-item d-flex flex-wrap align-items-center">
                                    <div class="popular-item-thumb">
                                        <a href=""><img src="{{ get_image($item->data->image,'site-section') ?? ''}}" alt="blog"></a>
                                    </div>
                                    <div class="popular-item-content">
                                        @php
                                            $date = $item->created_at ?? "";
                                            $formattedDate = date('M d, Y', strtotime($date));
                                        @endphp
                                        <span class="date">{{ $formattedDate }}</span>
                                        <h5 class="title"><a href="{{ setRoute('frontend.journal.details',$item->slug) }}">{{ Str::words($item->data->language->$app_local->title ?? '',5,'...') }}</a></h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <nav>
            {{ get_paginate($journal) }}
        </nav>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection