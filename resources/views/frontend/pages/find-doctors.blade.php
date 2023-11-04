@extends('frontend.layouts.master')



@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.section.banner-floting',[
    'class' => "home pt-120 mb-20"
])
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start  Doctor Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="doctor-list-section pb-120 pt-40">
    <div class="container">
        <div class="row mb-30-none">
            @if(isset($doctors))
                @forelse ($doctors as $item)
                    <div class="col-lg-6 mb-30">
                        <div class="doctor-item">
                            <div class="doctor-thumb">
                                <img src=" {{ get_image($item->image ?? '','site-section') ?? '' }}" alt="doctor-image">
                            </div>
                            <div class="content">
                                <h5 class="title"><i class="fas fa-user text--base me-1"></i>{{ $item->name ?? "" }}</h5>
                                <p>{{ $item->doctor_title ?? "" }}</p>
                                <h6 class="title">{{ $item->qualification ?? "" }}</h6>
                                <p>{{ $item->speciality ?? "" }}</p>
                                <p class="text--base">[ {{ $item->designation ?? "" }} ]</p>
                                <div class="booking-btn mt-20">
                                    <a href="{{ setRoute('frontend.appointment.booking.index',$item->slug)}}" class="btn--base">{{ __("Book Now") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <h5 class="text-danger text-center">{{ __("Doctor not found!") }}</h5>
                    </div>
                @endforelse
                
            @endif
            
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  Doctor Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection
