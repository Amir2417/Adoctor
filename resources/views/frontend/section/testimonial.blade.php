<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@php
    $app_local = get_default_language_code();
@endphp
<section class="testimonial-section pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="fas fa-briefcase-medical"></i> {{ $testimonial->value->language->$app_local->title ?? "" }} </span>
                    <h2 class="section-title"> {{ $testimonial->value->language->$app_local->heading ?? "" }} </h2>
                    <p>{{ $testimonial->value->language->$app_local->sub_heading ?? "" }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider-wrapper">
            <div class="testimonial-slider">
                <div class="swiper-wrapper">
                    @if(isset($testimonial->value->items))
                        @foreach ($testimonial->value->items ?? [] as $key=>$item)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="testimonial-user-area">
                                        <div class="user-area">
                                            <img src="{{ get_image($item->image ?? "",'site-section') ?? "" }}" alt="user">
                                        </div>
                                        <div class="title-area">
                                            <h5>{{ $item->name ?? "" }}</h5>
                                            <p>&lt; {{ $item->designation ?? "" }} &gt;</p>
                                        </div>
                                    </div>
                                    <p class="pt-20">{{ $item->language->$app_local->comment ?? "" }}</p>
                                    <div class="testimonial-bottom-wrapper">
                                        <ul class="testimonial-icon-list">
                                            @for ($initial = 1; $initial <= $item->rating; $initial++)
                                                <li><i class="las la-star"></i></li>
                                            @endfor
                                        </ul>
                                        <span class="testimonial-date"><i class="las la-history"></i> {{ \Carbon\Carbon::parse($item->created_at)->format("d-m-Y") }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($testimonial->value->items)
                    <div class="slider-nav-area">
                        <div class="slider-prev slider-nav">
                            <i class="las la-angle-left"></i>
                        </div>
                        <div class="slider-next slider-nav">
                            <i class="las la-angle-right"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
