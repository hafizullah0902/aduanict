@extends('layout.app')

@section('filter')

    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading"> Carian</div>
            <div class="panel-body">
                  {!! Form::open(array('route'=>'reports.monthly_statistic_aduan','method'=>'GET')) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::select('complain_category_id',$complain_categories,Request::get('complain_category_id'),['class'=>'form-control chosen','id'=>'complain_category_id'])!!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::select('branch_id',$branch,Request::get('branch_id'),['class'=>'form-control chosen','id'=>'branch_id'])!!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('start_date',Request::get('start_date'),['class'=>'form-control datepicker','id'=>'start_date'])!!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('end_date',Request::get('end_date'),['class'=>'form-control datepicker','id'=>'end_date'])!!}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Carian</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="panel panel-success">
        <div class="panel-heading"> Report Aduan Bulanan</div>
        <div class="panel-body">
            <h3 class="text-center"> Statistik Aduan bermula {!! $date_search[0] !!}  hingga {!! $date_search[1] !!} </h3>
            <canvas id="monthly_report" width="100%" height="50%"> </canvas>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script>
        var ctx = document.getElementById("monthly_report");
        var bar_data = {
            labels: {!! $month_name !!},
            datasets: [
                {
                    label: "Bilangan Aduan",
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(255,99,132,0.4)",
                    hoverBorderColor: "rgba(255,99,132,1)",
                    data: {{ $monthly_total }},
                }
            ]
        };


        var myChart = new Chart(ctx, {
            type: 'bar',
            data: bar_data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection