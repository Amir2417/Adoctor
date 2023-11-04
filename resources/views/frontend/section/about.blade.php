<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start about section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@php
    $app_local = get_default_language_code();
@endphp
<section class="about-section pb-120 {{ $class ?? "" }}">
    <div class="container">
        <div class="row mb-30-none align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 mb-30">
                <div class="about-content-wrapper">
                    <div class="about-content-area">
                        <div class="section-header">
                            <span class="section-sub-titel"><i class="fas fa-briefcase-medical"></i> {{ $about->value->language->$app_local->title ?? "" }}</span>
                            <h2 class="section-title">{{ $about->value->language->$app_local->heading ?? ""}}</h2>
                            <p>{{ $about->value->language->$app_local->sub_heading ?? ""}}</p>
                        </div>
                    </div>
                    <div class="about-feature-area">
                        <ul class="feature-list">
                            @if(isset($about->value->items))
                                @foreach($about->value->items ?? [] as $key => $item)
                                    <li>{{__( $item->language->$app_local->title ?? "") }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="feature-statistics-wrapper">
                        <div class="row mb-30-none">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-30">
                                <div class="statistics-item">
                                    <div class="statistics-content">
                                        <div class="odo-area">
                                            @php
                                                $about_statistic = numeric_unit_converter($about->value->language->$app_local->statistic_first_value ?? "");
                                            @endphp
                                            <h3 class="odo-title odometer" data-odometer-final="{{ $about_statistic->number }}">0</h3>
                                            <h3 class="title">{{ $about_statistic->unit }}</h3>
                                        </div>
                                        <p>{{ $about->value->language->$app_local->statistic_first_title ?? "" }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-30">
                                <div class="statistics-item">
                                    <div class="statistics-content">
                                        <div class="odo-area">
                                            @php
                                                $about_statistic = numeric_unit_converter($about->value->language->$app_local->statistic_second_value ?? "");
                                            @endphp
                                            <h3 class="odo-title odometer" data-odometer-final="{{ $about_statistic->number }}">0</h3>
                                            <h3 class="title">{{ $about_statistic->unit }}</h3>
                                        </div>
                                        <p>{{ $about->value->language->$app_local->statistic_second_title ?? "" }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-30">
                                <div class="statistics-item border-0">
                                    <div class="statistics-content">
                                        <div class="odo-area">
                                            @php
                                                $about_statistic = numeric_unit_converter($about->value->language->$app_local->statistic_last_value ?? "");
                                            @endphp
                                            <h3 class="odo-title odometer" data-odometer-final="{{ $about_statistic->number }}">0</h3>
                                            <h3 class="title">{{ $about_statistic->unit }}</h3>
                                        </div>
                                        <p>{{ $about->value->language->$app_local->statistic_last_title ?? ""}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 mb-30">
                <div class="about-thumb text-md-center">
                    <img src="{{ get_image($about->value->images->image ?? null,'site-section') ?? ''}}" alt="about">
                    <a class="video-icon" data-rel="lightcase:myCollection" href="{{ $about->value->language->$app_local->video_link ?? '' }}">
                        <i class="las la-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End about section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->