@php
    $app_local    = get_default_language_code();
@endphp
<div class="banner-slider">
    <div class="swiper-wrapper">
        @foreach ($banner->value->items ?? [] as $key => $item)
            @if ($item->status == 1)
                <div class="swiper-slide">
                    <section class="banner-section bg-overlay-black-two bg_img" data-background="{{ get_image($item->image,'site-section') ?? '' }}">
                        <div class="container">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-9 text-center">
                                    <div class="banner-content">
                                        <h2 class="title"> {{ $item->language->$app_local->heading ?? '' }} </h2>
                                        <h3 class="sub-title"> {{ $item->language->$app_local->sub_heading ?? '' }} </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endif
        @endforeach
        
        {{-- <div class="swiper-slide">
            <section class="banner-section bg-overlay-black-two bg_img" data-background="assets/images/banner/banner2.jpg">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-9 text-center">
                            <div class="banner-content">
                                <h2 class="title">Booking Appointment Anytime Anyway</h2>
                                <h3 class="sub-title">easy way of booking a doctor's appointment online.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide">
            <section class="banner-section bg-overlay-black-two bg_img" data-background="assets/images/banner/banner3.jpg">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-9 text-center">
                            <div class="banner-content">
                                <h2 class="title">Booking Appointment Anytime Anyway</h2>
                                <h3 class="sub-title">easy way of booking a doctor's appointment online.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide">
            <section class="banner-section bg-overlay-black-two bg_img" data-background="assets/images/banner/banner4.jpg">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-9 text-center">
                            <div class="banner-content">
                                <h2 class="title">Booking Appointment Anytime Anyway</h2>
                                <h3 class="sub-title">easy way of booking a doctor's appointment online.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> --}}  
    </div>
    <div class="slider-prev slider-nav">
        <i class="las la-angle-left"></i>
    </div>
    <div class="slider-next slider-nav">
        <i class="las la-angle-right"></i>
    </div>
</div>
