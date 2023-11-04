@extends('frontend.layouts.master')
@php
    $app_local = get_default_language_code();
@endphp


@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-120">
    <div class="container">
        <div class="row mb-30">
            <div class="col-xl-8 col-lg-7 col-md-12 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        <div class="blog-item-details">
                            <div class="blog-thumb">
                                <img src="{{ get_image($journal->data->image ?? '', 'site-section') }}" alt="blog">
                            </div>
                            <div class="blog-content">
                                <h3 class="title">{{ $journal->data->language->$app_local->title ?? "" }}</h3>
                                {!! $journal->data->language->$app_local->description ?? "" !!}
                                <div class="blog-tag-wrapper">
                                    <span>{{ __("Tags") }}:</span>
                                    <ul class="blog-footer-tag">
                                        @php
                                            $tags    = $journal->data->language->$app_local->tags ?? [];
                                        @endphp
                                        @foreach ($tags as $item)
                                            <li><a href="#0">{{ $item }}</a></li>
                                        @endforeach    
                                    </ul>
                                </div>
                                <div class="blog-social-area d-flex flex-wrap justify-content-between align-items-center">
                                    <h3 class="title">{{ __("Share This Post") }}</h3>
                                    <ul class="blog-social">
                                        <li><a href="{{ 'https://www.facebook.com/sharer.php?u='.url('/').'/journal-details/'.$journal->slug.'&display=popup' }}" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                                        <li><a href="{{ 'https://twitter.com/intent/tweet?url='.url('/').'/journal-details/'.$journal->slug.'&display=popup' }}" target="_blank" class="active"><i class="lab la-twitter"></i></a></li>
                                        <li><a href="{{ 'http://pinterest.com/pin/create/bookmarklet/?url='.url('/').'/journal-details/'.$journal->slug.'&display=popup' }} " target="_blank"><i class="lab la-pinterest-p"></i></a></li>
                                        <li><a href="{{ 'https://www.linkedin.com/sharing/share-offsite/?url='.url('/').'/journal-details/'.$journal->slug.'&display=popup' }}" target="_blank"><i class="lab la-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-12 mb-30">
                <div class="blog-sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Recent Posts") }}</h4>
                        <div class="popular-widget-box">
                            @foreach ($total_journals as $item)
                                <div class="single-popular-item d-flex flex-wrap align-items-center">
                                    <div class="popular-item-thumb">
                                        <a href=""><img src="{{ get_image($item->data->image ?? '' , 'site-section') }}" alt="blog"></a>
                                    </div>
                                    <div class="popular-item-content">
                                        <span class="date">{{ $item->created_at }}</span>
                                        <h5 class="title"><a href="{{ setRoute('frontend.journal.details',$item->slug) }}">{{ $item->data->language->$app_local->title ?? '' }}</a></h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection