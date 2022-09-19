@extends('layouts.admin.master')

@section('title', 'SITAMPAN')

@push('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endpush

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/yearpicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
<style>
	.title{
		font-size: 13px;
	}
	.ui-datepicker-calendar {
       display: none;
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<h3>Dashboard</h3>
			</div>
		</div>
	</div>
	@if(Auth::user()->level == 1)
		@include("admin.dashboard.admin")
	@elseif(Auth::user()->level == 3)
		@include("admin.dashboard.farmer")
	@endif
</div>
@push('scripts')
<script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/yearpicker.js')}}"></script>
@if(Auth::user()->level == 1)
<script>
		var optionscolumnchart = {
		labels: [],
		series: [],
		legend: {
			show: false
		},
		chart: {
			type: 'bar',
			height: 380
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%',
			}
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			colors: ['transparent'],
			curve: 'smooth',
			lineCap: 'butt'
		},
		grid: {
			show: false,
			padding: {
				left: 0,
				right: 0
			}
		},
		xaxis: {
			categories: [],
		},
		fill: {
			colors:['#4CAF50', '#009688', '#DD363D', '#FF9800'],
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.1,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.9,
				stops: [0, 100]
			}
		}
	};	

	$(document).ready(function(){
		$("#yearpicker").yearpicker()
		var chartColumnChartPlant = new ApexCharts(
			document.querySelector('#chart-plant'),
			optionscolumnchart
		)
		var chartColumnChartProduction = new ApexCharts(
			document.querySelector('#chart-production'),
			optionscolumnchart
		)
		chartColumnChartPlant.render();
		chartColumnChartProduction.render();
		
	$(document).on('submit','#chart',function(e){
	    e.preventDefault();

		var chartColumnChartPlant = new ApexCharts(
			document.querySelector('#chart-plant'),
			optionscolumnchart
		)

		// var chartColumnChartHarvest = new ApexCharts(
		// 	document.querySelector('#chart-harvest')
		// 	optionscolumnchart
		// )

		var chartColumnChartProduction = new ApexCharts(
			document.querySelector('#chart-production'),
			optionscolumnchart
		)

		var commodity	= $("[name='commodity']").val();
		var date 		= $("[name='date']").val();
		if(commodity == '') return toastAlert('info','Pilih Komoditas Terlebih Dahulu')
		if(date == '') return toastAlert('info','Pilih Tahun Terlebih Dahulu')
		var data = { id_komoditas: commodity, year: date};
		chartColumnChartPlant.render();
		chartColumnChartProduction.render();
		initChartPlant(data);
		initChartProduction(data);
	});

	function initChartPlant(data){
		$.ajax({
			url 		: "{{ url('dashboard/chart/plant') }}",
			type 		: "GET",
			dataType	: "json",
			data 		: data,
			success: function(response){
				if (response.status_code == 500) return toastAlert("error", response
                    .message);

                var labels  = Object.values(response)[0].labels.map(label => {
						return label;
				});

				var series  = Object.values(response).map(item => {
					return { name: item.title, data: item.dataset };
				});

				initChart(chartColumnChartPlant, labels, series);
			}
		})
	}

	function initChartProduction(data){
		$.ajax({
			url 		: "{{ url('dashboard/chart/production') }}",
			type 		: "GET",
			dataType	: "json",
			data 		: data,
			success: function(response){
				if (response.status_code == 500) return toastAlert("error", response
                    .message);

                var labels  = Object.values(response)[0].labels.map(label => {
						return label;
				});

				var series  = Object.values(response).map(item => {
					return { name: item.title, data: item.dataset };
				});

				initChart(chartColumnChartProduction, labels, series);
			}
		})
	}

	function initChart(target, labels, series) {
		var option	= {
			labels,
			series
		};

        target.updateOptions(option);
    }
	})
</script>
@endif
@endpush
@endsection
