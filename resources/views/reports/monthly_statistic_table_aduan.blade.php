

@extends('layout.app')

@section('filter')

    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading"> Carian</div>
            <div class="panel-body">
                {!! Form::open(array('route'=>'reports.monthly_statistic_table_aduan','method'=>'GET','id'=>'form1')) !!}
                <div class="row">
                    {{--<div class="col-md-3">--}}
                        {{--{!! Form::select('branch_id',$branch,Request::get('branch_id'),['class'=>'form-control chosen','id'=>'branch_id'])!!}--}}
                    {{--</div>--}}
                    <div class="col-md-2">
                        {!! Form::text('start_date',Request::get('start_date'),['class'=>'form-control datepicker','id'=>'start_date'])!!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('end_date',Request::get('end_date'),['class'=>'form-control datepicker','id'=>'end_date'])!!}
                    </div>
                    <div class="col-md-5">
                        <input type="hidden" name="submit_type" value="{{ old('submit_type')}}" id="submit_type" />
                        <button type="button" class="btn btn-success" id="carian">Carian</button>
                        <button type="button" class="btn btn-success" id="downloadPdf">Download PDF</button>
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
                <div class="table col-md-12">
                    <table class="table-responsive" width="100%">
                        <tr>
                            <td>Kategori</td>
                            <td>Jan</td>
                            <td>Feb</td>
                            <td>Mac</td>
                            <td>April</td>
                            <td>May</td>
                            <td>Jun</td>
                            <td>Julai</td>
                            <td>Ogos</td>
                            <td>Sept</td>
                            <td>Okt</td>
                            <td>Nov</td>
                            <td>Dis</td>
                        </tr>
                        @foreach($complains_statistic_row as $key => $value)
                            <tr>
                                <td>{{$key}}</td>

                                @foreach($value as $month_total)
                                    <td>{{ $month_total }}</td>


                                    @endforeach
                            </tr>
                            @endforeach
                    </table>
                </div>
        </div>
    </div>
@endsection

        @section('script')
            <script type="text/javascript">
                $( document).ready(function () {

                    $("#carian").click(function () {
                        var submit_type='carian';
                        submit_form(submit_type);

                    });

                    $("#downloadPdf").click(function () {
                        var submit_type='downloadPdf';
                        submit_form(submit_type);

                    });

                    function submit_form(submit_type) {
                        $('#submit_type').val(submit_type);

                        $('#form1').submit();

                    }

                });

            </script>
@endsection