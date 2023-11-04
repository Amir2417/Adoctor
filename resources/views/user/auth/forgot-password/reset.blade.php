<!DOCTYPE html>
<html lang="en">
    @include('frontend.partials.head')
    @include('partials.header-asset')
<body>

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@include('frontend.partials.preloader')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start body overlay
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div id="body-overlay" class="body-overlay"></div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End body overlay
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="account-section active">
    <div class="account-area change-form">
        <div class="account-form-area">
            <div class="account-logo text-center">
                <a class="site-logo" href="{{ setRoute('index') }}"><img src="{{ get_logo($basic_settings)}}" alt="logo"></a>
            </div>
            <h5 class="title">{{ __("Set New Password") }}</h5>
            <p>{{ __("Please Enter your new password and get login access on your Dashboard.") }}</p>
            <form class="account-form" action="{{ setRoute('user.password.reset',$token) }}" method="POST">
                @csrf
                <div class="row ml-b-20">
                    <div class="col-xl-12 col-lg-12 form-group show_hide_password">
                        <input type="password" name="password" class="form--control" placeholder="{{ __("New Password") }}">
                        <a href="" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group show_hide_password">
                        <input type="password" name="password_confirmation" class="form--control" placeholder="{{ __("Confirm Password") }}">
                        <a href="" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100">{{ __("Confirm") }}</button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label>{{ __("Already Have An Account?") }}<a href="{{ route('index')}}" class="account-control-btn">{{ __("Login Now")}}</a></label>
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


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start bubbles
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<ul class="bg-bubbles">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End bubbles
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@include('partials.footer-asset')


<script>
    $(document).ready(function() {
        $(".show_hide_password .show-pass").on('click', function(event) {
            event.preventDefault();
            if($(this).parent().find("input").attr("type") == "text"){
                $(this).parent().find("input").attr('type', 'password');
                $(this).find("i").addClass( "fa-eye-slash" );
                $(this).find("i").removeClass( "fa-eye" );
            }else if($(this).parent().find("input").attr("type") == "password"){
                $(this).parent().find("input").attr('type', 'text');
                $(this).find("i").removeClass( "fa-eye-slash" );
                $(this).find("i").addClass( "fa-eye" );
            }
        });
    });
</script>


</body>
</html>