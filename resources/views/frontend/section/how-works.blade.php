@php
    $app_local = get_default_language_code();
@endphp
<section class="how-it-work-section ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="fas fa-qrcode"></i> {{ $how_its_work->value->language->$app_local->title ?? '' }}</span>
                    <h2 class="section-title">{{ $how_its_work->value->language->$app_local->heading ?? '' }}</h2>
                    <p>{{ $how_its_work->value->language->$app_local->sub_heading ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="how-it-works-wrapper">
            <div class="row justify-content-center mb-30-none">
                @if(isset($how_its_work->value->items))
                    @php
                        $step_key = 0;
                        $how_its_works = $how_its_work->value->items ?? [];
                    @endphp
                    @foreach ($how_its_works as $key => $item)
                        @php
                            $step_key++;
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                            <div class="how-it-works-item">
                                <div class="how-it-works-icon-wrapper">
                                    <div class="how-it-works-icon">
                                        <i class="{{ $item->icon ?? '' }}"></i>
                                    </div>
                                </div>
                                <div class="how-it-works-content">
                                    <span  class="sub-title">{{ __("Step") }} {{ $step_key }}</span>
                                    <h4 class="title">{{ $item->language->$app_local->item_title ?? '' }}</h4>
                                </div>
                                @if($step_key < count((array) $how_its_works))
                                    <span class="process-devider"></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
