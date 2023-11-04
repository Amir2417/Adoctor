@php
    $menues = DB::table('setup_pages')->where('status', 1)->get();
@endphp

<header class="header-section {{ $class ?? "" }}">
    <div class="header">
        <div class="header-middle-area">
            <div class="container">
                <div class="header-middle-wrapper">
                    <a class="site-logo site-title" href="{{ setRoute('index') }}"><img src="{{ get_logo($basic_settings) }} " alt="site-logo"></a>
                    <div class="header-middle-content">
                        <div class="header-address-area">
                            <div class="header-address-item">
                                <a href="mailto:{{$contact->value->email}}" class="thumb">
                                    <img src="{{ asset('public/frontend/images/icon/support.gif')}} " alt="l">
                                </a>
                                <div class="content">
                                    @php
                                        use Illuminate\Mail\Markdown;
                                    @endphp
                                    <span>{{ $contact->value->address ?? "" }}</span>
                                    <a href="mailto:{{$contact->value->email}}" class="title">{{ $contact->value->email ?? "" }}</a>
                                </div>
                            </div>
                            <div class="header-address-item">
                                <a href="tel:{{$contact->value->phone}}" class="thumb">
                                    <img src="{{ asset('public/frontend/images/icon/phone.gif')}} " alt="l">
                                </a>
                                <div class="content">
                                    <span>{{ __("Contact Us") }}</span>
                                    <a href="tel:{{$contact->value->phone}}" class="title">{{ $contact->value->phone ?? "" }}</a>
                                </div>
                            </div>
                        </div>
                        <ul class="header-social-list">
                            @php
                                $items      = $footer->value->social_links ?? [];
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
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ setRoute('index') }}"><img src="{{ get_logo($basic_settings) }}" alt="site-logo"></a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            @php
                                $current_url = URL::current();
                            @endphp
                            <ul class="navbar-nav main-menu me-auto">

                                @foreach ($menues as $item)
                                    @php
                                        $title = $item->title ?? "";
                                    @endphp
                                    <li><a href="{{ url($item->url) }}" class=" @if($current_url == url($item->url)) active @endif ">{{ __($title) }} <i class="fas fa-caret-right"></i></a></li>
                                @endforeach
                                @auth
                                <li><a href="{{ setRoute('user.profile.index') }}" >{{__("Dashboard")}} <i class="fas fa-caret-right"></i></a></li>
                                @else
                                <li><a href="javascript:void(0)" class="account-area-btn">{{__("Login")}} <i class="fas fa-caret-right"></i></a></li>
                                @endauth
                                
                            </ul>
                            <div class="header-action">
                                <div class="language-select">
                                    @php
                                        $__current_local = session("local") ?? get_default_language_code();
                                    @endphp
                                    <select class="form--control nice-select" name="lang_switcher" id="">
                                        @foreach ($__languages as $__item)
                                            <option value="{{ $__item->code }}" @if ($__current_local == $__item->code)
                                                @selected(true)
                                            @endif>{{ $__item->name }}</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                                <a href="javascript:void(0)" class="btn--base" data-bs-toggle="modal" data-bs-target=".bd-example-modal-app"><i class="lab la-google-play me-2"></i>{{__("Download App")}}</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


@push('script')
<script>
    $("select[name=lang_switcher]").change(function(){
        var selected_value = $(this).val();
        var submitForm = `<form action="{{ setRoute('languages.switch') }}" id="local_submit" method="POST"> @csrf <input type="hidden" name="target" value="${$(this).val()}" ></form>`;
        $("body").append(submitForm);
        $("#local_submit").submit();
    });
</script>
@endpush

