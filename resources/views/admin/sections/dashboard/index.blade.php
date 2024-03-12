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
    ], 'active' => __("Dashboard")])
@endsection

@section('content')
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Users")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_user']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __('Active') }} {{ $data['active_user'] }}</span>
                                    <span class="badge badge--warning">{{ __('Unverified') }} {{ $data['unverified_user'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart6" data-percent="{{ $data['user_percent'] }}"><span>{{ round($data['user_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Journals")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_journals']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__('Active') }} {{ $data['active_journal']}}</span>
                                    <span class="badge badge--warning">{{__('Pending') }} {{ $data['pending_journal'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart7" data-percent="{{ $data['journal_percent'] }}"><span>{{ round($data['journal_percent']) }}%</span></div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Hospital Branch")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_branches'])}}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{__("Active") }} {{ $data['active_branches']}}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_branches']}}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart10" data-percent="{{ $data['branch_percent'] }}"><span>{{ round($data['branch_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Hospital Departments")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_departments']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Active") }} {{ $data['active_departments']}}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_departments']}}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart11" data-percent="{{ $data['department_percent'] }}"><span>{{ round($data['department_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Hospital Tests")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_hospital_tests']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Active") }} {{ $data['active_hospital_tests'] }}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_hospital_tests'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart8" data-percent="{{ $data['hospital_test_percent'] }}"><span>{{ round($data['hospital_test_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Hospital Packages")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_hospital_tests']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Active") }} {{ $data['active_packages'] }}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_packages'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart9" data-percent="{{ $data['package_percent'] }}"><span>{{ round($data['package_percent'])}}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Doctors")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_doctors']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Active")}} {{ $data['active_doctors'] }}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_doctors'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart13" data-percent="{{ $data['doctor_percent'] }}"><span>{{ round($data['doctor_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Doctor Appointments")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['appointment_booking']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Confirm")}} {{ $data['active_appointment'] }}</span>
                                    <span class="badge badge--warning">{{__("Pending") }} {{ $data['pending_appointment'] }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart12" data-percent="{{ $data['appointment_percent'] }}"><span>{{ round($data['appointment_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{__("Total Home Service Bookings")}}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ formatNumberInKNotation($data['total_home_service']) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{__("Active")}} {{ $data['active_home_service'] }}</span>
                                    <span class="badge badge--warning">{{__("Pending")}} {{ $data['pending_home_service']}}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart14" data-percent="{{ $data['home_service_percent'] }}"><span>{{ round($data['home_service_percent']) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chart-area mt-15">
        <div class="row mb-15-none">
            <div class="col-xxxl-6 col-xxl-3 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">{{__("User Analytics Chart")}}</h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart1" class="balance-chart" data-user_chart_data="{{ json_encode($data['user_chart_data']) }}"></div>
                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="{{ setRoute('admin.users.index') }}" class="btn--base w-100">{{__("View User")}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">{{__("Doctor Appointment Booking Chart")}}</h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart2" class="sales-chart" data-appointment_booking_chart="{{ json_encode($data['appointment_booking_chart']) }}"></div>
                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="{{ setRoute('admin.booking.index') }}" class="btn--base w-100">{{__("View Doctor Appointment")}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxxl-12 col-xxl-3 col-xl-12 col-lg-12 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">{{__("Home Service Chart")}}</h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart3" data-home_service_chart="{{json_encode($data['home_service_chart']) }}"></div>
                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="{{ setRoute("admin.home.service.index") }}" class="btn--base w-100">{{__("View Home Service")}}</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Recent Appointments") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __("Patient Name") }}</th>
                            <th>{{ __("Email") }}</th>
                            <th>{{ __("Phone") }}</th>
                            <th>{{ __("Age") }}</th>
                            <th>{{ __("Gender") }}</th>
                            <th>{{ __("Type") }}</th>
                            <th>{{ __("Doctor Name") }}</th>
                            <th>{{ __("Speciality") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent_appointment as $data)
                            <tr>
                                
                                <td><span>{{ $data->name ?? ""}}</span></td>
                                <td>{{ $data->email ?? "" }}</td>
                                <td>{{ $data->phone ?? "" }}</td>
                                <td>{{ $data->age ?? "" }}</td>
                                <td class="text-capitalize">{{ $data->gender ?? "" }}</td>
                                <td class="text-capitalize">{{ $data->type ?? "" }}</td>
                                <td><span class="text--info">{{$data->doctors->name ?? "" }}</span></td>
                                <td>{{ $data->doctors->speciality ?? "" }}</td>
                                <td>
                                    @include('admin.components.link.custom',[
                                        'href'          => "#send-reply",
                                        'class'         => "btn btn--base reply-button modal-btn",
                                        'icon'          => "las la-reply-all",
                                        'permission'    => "admin.booking.messages.reply",
                                    ])
                                    <a href="{{ setRoute('admin.booking.details',$data->slug)}}" class="btn btn--base btn--primary"><i class="las la-info-circle"></i></a>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 10])
                        @endforelse
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Send Mail Modal --}}
    @if (admin_permission_by_name("admin.booking.messages.reply"))
        <div id="send-reply" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header px-0">
                    <h5 class="modal-title">{{ __("Send Reply") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="card-form" action="{{ setRoute('admin.booking.messages.reply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="target" value="{{ old('target') }}">
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => __("Subject")."*",
                                    'name'          => "subject",
                                    'data_limit'    => 150,
                                    'placeholder'   => __("Write Subject")."...",
                                    'value'         => old('subject'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input-text-rich',[
                                    'label'         => __("Details")."*",
                                    'name'          => "message",
                                    'value'         => old('message'),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.button.form-btn',[
                                    'class'         => "w-100 btn-loading",
                                    'permission'    => "admin.subscriber.send.mail",
                                    'text'          => __("Send Email"),
                                ])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        openModalWhenError("send-reply","#send-reply");
        $(".reply-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            $("#send-reply").find("input[name=target]").val(oldData.id);
        });
    </script>

    <script>
        // apex-chart
var chart2 = $('#chart2');
var appointment_booking_chart = chart2.data('appointment_booking_chart');

var options = {
  series: appointment_booking_chart,
  chart: {
  width: 350,
  type: 'pie'
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['{{ __("All") }}', '{{ __("Confirm") }}', '{{ __("Pending") }}'],
responsive: [{
  breakpoint: 1480,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}],
legend: {
  position: 'bottom'
},
};

var chart = new ApexCharts(document.querySelector("#chart2"), options);
chart.render();







var chart1 = $('#chart1');
var user_chart_data = chart1.data('user_chart_data');

var options = {
  series: user_chart_data,
  chart: {
  width: 350,
  type: 'pie'
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['{{ __("Active") }}', '{{ __("Unverified") }}', '{{ __("Banned") }}', '{{ __("All") }}'],
responsive: [{
  breakpoint: 1480,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}],
legend: {
  position: 'bottom'
},
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();

var chart3 = $("#chart3");
var home_service_chart = chart3.data('home_service_chart');
var options = {
  series: home_service_chart,
  chart: {
  width: 350,
  type: 'donut',
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['{{ __("All") }}', '{{ __("Active") }}', '{{ __("Pending") }}'],
legend: {
    position: 'bottom'
},
responsive: [{
  breakpoint: 1600,
  options: {
    chart: {
      width: 100,
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}]
};

var chart = new ApexCharts(document.querySelector("#chart3"), options);
chart.render();

    </script>
@endpush