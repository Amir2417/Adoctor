@php
    $app_local = get_default_language_code();
@endphp
<section class="blog-section pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="fas fa-briefcase-medical"></i> {{ $journal_top->value->language->$app_local->title ?? '' }}</span>
                    <h2 class="section-title">{{ $journal_top->value->language->$app_local->heading ?? '' }}</h2>
                    <p>{{ $journal_top->value->language->$app_local->sub_heading ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-60-none justify-content-center">
            @foreach ($journals ?? [] as $key => $item)
                <div class="col-xl-4 col-lg-4 col-md-6 mb-60">
                    <div class="blog-item">
                        <div class="thumb">
                            <img src="{{ get_image($item->data->image ?? '','site-section') ?? '' }}" alt="">
                        </div>
                        <div class="icon-wrapper">
                            <div class="icon">
                                {{-- @dd() --}}
                                <i class="{{ $item->data->language->$app_local->icon ?? "" }}"></i>
                            </div>
                        </div>
                        <div class="content">
                            <a href="{{ setRoute('frontend.journal.details',$item->slug) }}" class="title">{{ Str::words($item->data->language->$app_local->title ?? '',10,'...') }}</a>
                            <p>{!! Str::words($item->data->language->$app_local->description ?? '' , 20, '...') !!}</p>
                        </div>
                        <div class="blog-item-btn-area text-center">
                            <a href="{{ setRoute('frontend.journal.details',$item->slug) }}"><i class="las la-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
        @if (count($journals) > 3)
            <div class="blog-item-btn-area text-center mt-60">
                <a href="{{ setRoute('journals')}}" class="btn--base"><i class="las la-briefcase-medical me-1"></i>{{ __("View More") }}</a>
            </div>
        @endif
        
    </div>
</section>
