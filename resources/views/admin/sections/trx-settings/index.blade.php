@extends('admin.layouts.master')

@push('css')

@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Fees & Charges")])
@endsection

@section('content')
        @include('admin.components.trx-settings-charge-block',[
            'route'         => setRoute('admin.trx.settings.charges.update'),
            'title'         => $transaction_charges->title,
            'data'          => $transaction_charges,
        ])
@endsection

@push('script')

@endpush
