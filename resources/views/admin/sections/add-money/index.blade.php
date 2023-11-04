@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Add Money Logs'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ $page_title }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions  as $key => $item)
                            <tr>
                                <td>{{ $item->user->fullname }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ $item->user->username }}</td>
                                <td>{{ $item->user->mobile ?? '' }}</td>
                                <td>{{ $item->amount }}</td>
                                <td><span class="text--info">{{ $item['payment_gateway']->name }}</span></td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="badge badge--warning">Pending</span>
                                    @else
                                        <span class="badge badge--success">Success</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d-m-y h:i:s A') }}</td>
                                <td>
                                    @if ($item->status == 0)
                                        <button type="button" class="btn btn--base bg--success"><i
                                                class="las la-check-circle"></i></button>
                                        <button type="button" class="btn btn--base bg--danger"><i
                                                class="las la-times-circle"></i></button>
                                        <a href="add-logs-edit.html" class="btn btn--base"><i class="las la-expand"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-primary">{{ __('No data found!') }}</div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ get_paginate($transactions) }}
        </div>
    </div>
@endsection

@push('script')
@endpush
