@extends('layouts.admin.app')

@section('content')
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- <script src="{{ asset('js/admin/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/admin/utils.js') }}"></script> -->
<div class="content-wrapper">
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
    @endif
@endforeach
	<div id="embed-api-auth-container"></div>
	<div><a href="javascript:void(0)" class="logout_analytics" style="display: none;">Logout Of Analytics</a></div>
	<div id="view-selector-1-container"></div>
	
		
		<!--  report   sumary   --->
			  <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span> <a href="{{ route('admin.dashboard')}}" class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                     
					  
					 
						
                     
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Today's Orders</span>
                          <h4>{{ $today_orders }}</h4>
                          <span class="report-count">
						  <a href="{{route('admin.orders.list')}}">View All</a>
						  </span>
                        </div>
                        <div class="inner-card-icon bg-warning">
                          <i class="icon-globe-alt"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Today's Revenue</span>
                          <h4>£ {{ $today_revinew }}</h4>
                          <span class="report-count"> 
						   <a href="{{route('admin.orders.list')}}">View All</a>
						  </span>
                        </div>
                        <div class="inner-card-icon bg-primary">
                          <i class="icon-diamond"></i>
                        </div>
                      </div>
                       <div class=" col-md -6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Total orders</span>
                          <h4>{{ $total_orders }}</h4>
                          <span class="report-count"> 
                            <a href="{{route('admin.orders.list')}}">View All</a>
                          </span>
                        </div>
                        <div class="inner-card-icon bg-success">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                       <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Total Revenue</span>
                          <h4>£ {{ $total_revinew}}</h4>
                          <span class="report-count"> 
                            <a href="{{route('admin.orders.list')}}">View All</a>
                           </span>
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-briefcase"></i>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
			
	
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Orders By status</h4>
                    <div class="aligner-wrapper">
                      <canvas id="sessionsDoughnutChart" height="210"></canvas>
                      <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                        <h2 class="text-center mb-0 font-weight-bold">{{$total_orders}}</h2>
                        <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total Orders</small>
                      </div>
                    </div>
                    <div class="wrapper mt-4 d-flex flex-wrap align-items-cente">
                      <div class="d-flex">
                        <span class="square-indicator bg-danger ml-2"></span>
                        <p class="mb-0 ml-2">Completed</p>
                      </div>
                      <div class="d-flex">
                        <span class="square-indicator bg-success ml-2"></span>
                        <p class="mb-0 ml-2">Despatched</p>
                      </div>
                      <div class="d-flex">
                        <span class="square-indicator bg-warning ml-2"></span>
                        <p class="mb-0 ml-2">Pending</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body performane-indicator-card">
                    <div class="d-sm-flex">
                      <h4 class="card-title flex-shrink-1">Orders Indicator</h4>
                      <p class="m-sm-0 ml-sm-auto flex-shrink-0">
                       <!--  <span class="data-time-range ml-0">7d</span>
                        <span class="data-time-range active">2w</span>
                        <span class="data-time-range">1m</span>
                        <span class="data-time-range">3m</span>
                        <span class="data-time-range">6m</span> -->
                      </p>
                    </div>
                    <div class="d-sm-flex flex-wrap">
                      <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-primary ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold">Total orders ({{$total_orders}})</p>
                      </div>
                      <!-- <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-info ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold"> Task Done (1123)</p>
                      </div>
                      <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-danger ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold">Attends (876)</p>
                      </div> -->
                    </div>
                    <div id="performance-indicator-chart" class="ct-chart mt-4"></div>
                  </div>
                </div>
              </div>
            </div>
			
</div>

<!-- Plugin js for this page -->
    <script src="{{ asset('js/admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/admin/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/admin/vendors/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/admin/vendors/chartist/chartist.min.js') }}"></script>
    <!-- End plugin js for this page -->
<script>

(function ($) {
  'use strict';
  $(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#income-expense-summary-chart-daterange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#income-expense-summary-chart-daterange').daterangepicker({
      opens: 'left',
      startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    // Income Expenses Summary Chart with chartist line chart

    var data = {
      // A labels array that can contain any sort of values
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      // Our series array that contains series objects or in this case series data arrays
      series: [
        [505, 781, 480, 985, 410, 822, 388, 874, 350, 642, 320, 796],
        [700, 430, 725, 390, 686, 392, 757, 500, 820, 400, 962, 420]
      ]
    };

    var options = {
      height:300,
      fullWidth:true,
      axisY: {
        high: 1000,
        low: 250,
        referenceValue: 1000,
        type: Chartist.FixedScaleAxis,
        ticks: [250, 500, 750, 1000]
      },
      showArea: true,
      showPoint: false
    }
    
    var responsiveOptions = [
      ['screen and (max-width: 480px)', {
        height: 150,
        axisX: {
          labelInterpolationFnc: function (value) {
            return value;
          }
        }
      }]
    ];
    // Create a new line chart object where as first parameter we pass in a selector
    // that is resolving to our chart container element. The Second parameter
    // is the actual data object.
    new Chartist.Line('#income-expense-summary-chart', data, options, responsiveOptions);

    //Sessions by Channel doughnut chart

    var doughnutChartCanvas = $("#sessionsDoughnutChart").get(0).getContext("2d");
            var doughnutPieData = {
                datasets: [{
                    data: [{{$totalComplete}},{{$orderDispatch}},{{$orderPlace}}],
                    backgroundColor: [
                        '#ffca00',
                        '#38ce3c',
                        '#ff4d6b'
                    ],
                    borderColor: [
                      '#ffca00',
                      '#38ce3c',
                      '#ff4d6b'
                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Reassigned',
                    'Not Assigned',
                    'Assigned'
                ]
            };
            var doughnutPieOptions = {
                cutoutPercentage: 75,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
                maintainAspectRatio: true,
                showScale: true,
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            };
            var doughnutChart = new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        
          //performance indicator bar chart

          new Chartist.Bar('#performance-indicator-chart', {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'may', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [
              [{{$series}}]
            ]
          }, {
            stackBars: true,
            height: 200,
            axisY: {
              type: Chartist.FixedScaleAxis,
              ticks: [{{$series}}]
            },
            showGridBackground: false
          },
          [
            ['screen and (max-width: 480px)', {
              height: 150,
            }]
          ]
        );

        //Pro purchase banner close
        $('.purchace-popup .popup-dismiss').on('click', function(){
          $('.purchace-popup').hide();
        })
  });
})(jQuery);
</script>
@endsection