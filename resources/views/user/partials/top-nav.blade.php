<nav class="navbar-wrapper">
    <div class="dashboard-title-part">
        <div class="left">
            <div class="icon">
                <button class="sidebar-menu-bar">
                    <i class="fas fa-exchange-alt"></i>
                </button>
            </div>
            <div class="dashboard-path">
                <span class="main-path"><a href="{{ setRoute('user.profile.index') }}">{{__("Dashboard")}}</a></span>
                <i class="las la-angle-right"></i>
                <span class="active-path">{{ __($breadcrumb) ?? ""}}</span>
            </div>
            
        </div>
        <div class="right">
            <div class="user-lang-wrapper">
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
            <div class="header-push-wrapper">
                <button class="push-icon">
                    <i class="las la-bell"></i>
                </button>
                <div class="push-wrapper">
                    <div class="push-header">
                        <h5 class="title">{{__("Notification")}}</h5>
                    </div>
                    <ul class="push-list">
                        @forelse ($notifications as $item)
                            <li>
                                <div class="thumb">
                                    <img src="@if ($user->image){{ get_image($user->image ?? '', 'user-profile') ?? '' }}@else{{ asset('public/frontend/') }}/images/user/2.jpg  @endif" alt="user">
                                </div>
                                <div class="content">
                                    <div class="title-area">
                                        <strong class="title">{{ $item->message ?? "" }}</strong>
                                        <span class="time">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at ?? "")->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                        <li><strong class="title text--danger">{{__("Notification Not Found!")}}</strong></li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="header-user-wrapper">
                <a class="header-user-thumb" href="{{ setRoute('user.profile.index')}}"><img src="{{ auth()->user()->userImage ?? asset('public/frontend/images/user/2.jpg') }}" alt="client"></a>
            </div>
        </div>
    </div>
</nav>
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