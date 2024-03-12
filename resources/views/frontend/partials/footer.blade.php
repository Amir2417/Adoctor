@php
    $app_local     = get_default_language_code();
@endphp


<footer class="footer-section pt-40 pb-20 bg_img" data-background="{{ asset('public/frontend/images/element/footer-element.jpg')}} ">
    <div class="container">
        <div class="footer-wrapper">
            <div class="row mb-30-none">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                    
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a class="site-logo site-title" href="{{ setRoute('index') }}"><img src=" {{ @$footer->value->footer->image ? get_image($footer->value->footer->image,'site-section') : get_logo($basic_settings)  }} " alt="site-logo"></a>
                        </div>
                        <div class="footer-content">
                            <p>{{ $footer->value->footer->language->$app_local->description ?? ''}}</p>
                        </div>
                        <div class="footer-content-bottom">
                            <ul class="footer-list logo">
                                @php
                                    $items = $footer->value->communication_links?? [];
                                @endphp                                
                                @foreach ($items as $item)
                                    @php
                                        $phone_number  = remove_special_char($item->communication_link);
                                    @endphp
                                    @if (is_numeric($phone_number))
                                    <li><a href="tel:{{ $item->communication_link}}" style="text-transform: lowercase;"><i class="{{ $item->communication_icon ?? '' }} "></i> {{ $item->communication_link ?? '' }}</a></li>
                                    @else
                                        <li><a href="mailto:{{ $item->communication_link}}" style="text-transform: lowercase;"><i class="{{ $item->communication_icon ?? '' }} "></i> {{ $item->communication_link ?? '' }}</a></li>  
                                    @endif    
                                @endforeach    
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{__("Usefull Links")}}</h4>
                        <ul class="footer-list">
                            @if($useful_links)
                                @foreach ($useful_links as $item)
                                    <li><a href="{{ setRoute('link',$item->slug)}}">{{ $item->title->language?->$app_local?->title ?? "" }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{ __("Download App") }}</h4>
                        <p>{{ __($app_settings->url_title) ?? '' }}</p>
                        <ul class="footer-list two">
                            <li><a href="{{ $app_settings->android_url ?? '' }}" class="app-img" target="_blank"><img src="{{ asset('public/frontend/images/app/play_store.png')}} " alt="app"></a></li>
                            <li><a href="{{ $app_settings->iso_url ?? '' }}" class="app-img" target="_blank"><img src="{{ asset('public/frontend/images/app/app_store.png')}} " alt="app"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{ $news_letter->value->language->$app_local->title ?? '' }}</h4>
                        <p>{{ $news_letter->value->language->$app_local->description ?? '' }}</p>
                        <form id="subscribe-form" class="footer-list two" action="{{ setRoute('subscribe') }} " method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" placeholder="{{ __("Name") }}" name="name" class="form--control">
                                <span class="input-icon"><i class="las la-user"></i></span>
                            </div>
                            <div class="form-group">
                                <input type="email" placeholder="{{ __("Email") }}" name="email" class="form--control" required>
                                <span class="input-icon"><i class="las la-envelope"></i></span>
                            </div>
                            <div class="footer-btn-area">
                                <button type="submit" class="btn--base sub-btn">{{__("Subscribe")}} <i class="las la-arrow-right ms-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="copyright-area">
                <div class="copyright-wrapper">
                    <p>© {{ __("Created by") }} <span class="text--base">{{ $basic_settings->site_name}}</span> 2024.</p>
                    <ul class="footer-social-list">
                        @php
                            $items = $footer->value->social_links ?? [];
                        @endphp
                        
                        @foreach ($items as $item)
                            <li>
                                <a href="{{ $item->link }}" target="_blank"><i class="{{ $item->icon }}"></i></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
