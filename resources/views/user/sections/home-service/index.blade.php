@extends('user.layouts.master')

@section('content')

<div class="body-wrapper">
    <div class="table-area mt-10">
        <div class="table-wrapper">
            <div class="dashboard-header-wrapper">
                <h4 class="title">{{ __("History List") }}</h4>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            
                            <th>{{ __("Patient Name") }}</th>
                            <th>{{ __("Email") }}</th>
                            <th>{{ __("Schedule") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($booking_appointments as $item)
                            <tr>
                                
                                <td data-label="Patient Name">{{ $item->name ?? "" }}</td>
                                <td data-label="Email">{{ $item->email ?? "" }}</td>
                                <td data-label="Schedule">{{ $item->schedule ?? "" }}</td>
                                <td data-label=""><a href="{{ setRoute('user.home.service.details',$item->slug)}}" class="btn btn--base btn--primary"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @empty
                            @include('user.components.alerts.empty',['colspan' => 6])
                        @endforelse   
                    </tbody>
                </table>
            </div>
        </div>
        
        {{ get_paginate($booking_appointments) }}
    </div>
</div>
    
@endsection