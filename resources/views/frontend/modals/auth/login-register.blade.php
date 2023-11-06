<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="account-section">
    <div class="account-bg"></div>
    <div class="account-area change-form">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-start">
                <a href="{{ setRoute('index')}}" class="site-logo">
                    <img src="{{ get_logo($basic_settings) }}" alt="logo">
                </a>
            </div>
            <h5 class="title">{{ __("Log in and Stay Connected") }}</h5>
            <p>{{ __("Log in and Stay Connected Our secure login process ensures the confidentiality of your information. Log in today and stay connected to your finances, anytime and anywhere.") }}</p>
            <form action="{{ setRoute('user.login.submit') }}" class="account-form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <input type="email" required class="form-control form--control" name="credentials" placeholder="{{ __("Email") }}" spellcheck="false" data-ms-editor="true">
                    </div>
                    <div class="col-lg-12 form-group" id="show_hide_password">
                        <input type="password" required class="form-control form--control" name="password" placeholder="{{ __("Password") }}">
                        <a href="" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-12 form-group">
                        <div class="forgot-item">
                            <label><a href="{{ setRoute('user.password.forgot') }}">{{ __("Forgot Password") }}?</a></label>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100">{{ __("Login Now") }}</button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label>{{ __("Don't Have An Account") }}? <a href="#0" class="account-control-btn">{{ __("Register Now") }}</a></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="account-area">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-start">
                <a class="site-logo" href="{{ setRoute('index') }}"><img src="{{ get_logo($basic_settings) }} " alt="logo"></a>
            </div>
            <h5 class="title">{{ __("Register for an Account Today") }}</h5>
            <p>{{ __("Become a part of our community by registering for an account today. Enjoy a range of benefits and features tailored to meet your needs. Our registration page makes it easy to create your account, providing a seamless and user-friendly experience.") }}</p>
            <form action="{{ setRoute('user.register.submit') }}" method="POST" class="account-form">
                @csrf
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <input type="text" class="form-control form--control" name="firstname" placeholder="{{ __("First Name") }}" spellcheck="false" data-ms-editor="true">
                    </div>
                    <div class="col-lg-6 form-group">
                        <input type="text" class="form-control form--control" name="lastname" placeholder="{{ __("Last Name") }}" spellcheck="false" data-ms-editor="true">
                    </div>
                    <div class="col-lg-12 form-group">
                        <input type="email" class="form-control form--control" name="email" placeholder="{{ __("Email") }}">
                    </div>
                    <div class="col-lg-12 form-group" id="show_hide_password">
                        <input type="password" class="form-control form--control" name="password" placeholder="{{ __("Password") }}">
                        <a href="" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-12 form-group">
                        <div class="custom-check-group">
                            <input type="checkbox" name="agree" id="level-1">
                            @php
                                $data       = App\Models\Admin\UsefulLink::where('type',global_const()::USEFUL_LINK_PRIVACY_POLICY)->first();
                            @endphp
                            <label for="level-1">{{ __("I have agreed with") }}<a href="{{ setRoute('link',$data->slug) }}" class="text--base">{{ __("Terms Of Use") }} &amp; {{ __("Privacy Policy") }}</a></label>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100">{{ __("Register Now") }}</button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label>{{ __("Already Have An Account?") }} <a href="#0" class="account-control-btn">{{ __("Login Now") }}</a></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


