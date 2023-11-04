<!-- favicon -->
<link rel="shortcut icon" href="{{ get_fav($basic_settings) ?? "" }}" type="image/x-icon">
<!-- fontawesome css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/fontawesome-all.min.css')}}">
<!-- line-awesome-icon css -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/line-awesome.min.css')}}">
<!-- bootstrap css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.min.css')}}">
<!-- swipper css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/swiper.min.css')}}">
<!-- nice-select css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/nice-select.css')}}">
<!-- select2-select css link -->
<link rel="stylesheet" href="{{ asset('public/backend/css/select2.min.css') }}">
<!-- animate css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/animate.css')}}">
<!-- odometer css -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/odometer.css')}}">
<!-- lightcase css -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/lightcase.css')}}">
<!-- Popup  -->
<link rel="stylesheet" href="{{ asset('public/backend/library/popup/magnific-popup.css') }}">
<!-- main style css link -->
<link rel="stylesheet" href="{{ asset('public/frontend/css/style.css')}}">

@php
    $color = @$basic_settings->base_color ?? '#1bbde4';
@endphp

<style>
    :root {
        --primary-color: {{$color}};
    }
</style>