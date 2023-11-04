<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@php
    $app_local  = get_default_language_code();
@endphp



<section class="faq-section pb-120 {{ $class ?? ""}}">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="fas fa-briefcase-medical"></i> {{ $faq->value->language->$app_local->title ?? "" }} </span>
                    <h2 class="section-title"> {{ $faq->value->language->$app_local->heading ?? "" }}</h2>
                    <p>{{ $faq->value->language->$app_local->sub_heading ?? "" }}</p>
                </div>
            </div>
        </div>
        @php
            $items    = $faq->value->items;
            $itemsData = (array) $items;

            $data = array_chunk($itemsData, ceil(count($itemsData) / 2));

            $part1 = $data[0];
            $part2 = $data[1];
        @endphp
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="faq-wrapper">
                    @foreach ($part1 as $item)
                        @if ($item->status == 1)
                            <div class="faq-item">
                                <h3 class="faq-title"><span class="title">{{ $item->language->$app_local->question ?? "" }}</span><span class="right-icon"></span></h3>
                                <div class="faq-content">
                                    <p>{{ $item->language->$app_local->answer ?? "" }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach 
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="faq-wrapper">
                    @foreach ($part2 as $item)
                        @if ($item->status == 1)
                            <div class="faq-item">
                                <h3 class="faq-title"><span class="title">{{ $item->language->$app_local->question ?? "" }}</span><span class="right-icon"></span></h3>
                                <div class="faq-content">
                                    <p>{{ $item->language->$app_local->answer ?? "" }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <div class="row mb-30-none">
            @foreach ($faq->value->items ?? [] as $key => $item)
                @if ($item->status == 1)
                    <div class="col-xl-6 col-lg-6 mb-30">
                        <div class="faq-wrapper">
                            <div class="faq-item">
                                <h3 class="faq-title"><span class="title">{{ $item->language->$app_local->question ?? ""}}</span><span class="right-icon"></span></h3>
                                <div class="faq-content">
                                    <p>{{ $item->language->$app_local->answer ?? ""}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach 
        </div> --}}
    </div>
</section>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
