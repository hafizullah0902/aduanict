@extends('layout.app')
@section('content')

    @include('layout/alert_message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Hantar Aduan</h3>
        </div>
        <div class="panel-body">

            {{--<form class="form-horizontal">--}}
            {!! Form::open(array('route' => 'complain.store', 'class'=>"form-horizontal")) !!} {{-- Untuk tujuan security (form + security token) --}}

                <div class="form-group">
                    <label class="col-sm-2 col-xs-2 control-label">Tarikh </label>
                    <div class="col-sm-2 col-xs-10">
                        <p class="form-control-static">{{ date('d/m/Y')}}</p>
                    </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-2 col-xs-2 control-label">Masa </label>
                    <div class="col-sm-2 col-xs-10">
                        <p class="form-control-static">{{date('H:i:s')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pengadu </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{Auth::user()->name}} </p>
                    </div>
                    <label class="col-sm-2 control-label">No. Pekerja </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{Auth::user()->emp_id}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bagi Pihak</label>
                    <div class="col-sm-6">
                        <div class="input-group">

                            {!! Form::select('user_emp_id',$users,'',['class'=>'form-control chosen']); !!}
                        </div><!-- /input-group -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Kategori</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('complain_category_id',$complain_categories,'',['class'=>'form-control chosen','id'=>'complain_category_id'])!!}
                        {{--<select class="form-control input-sm" name="complain_category_id">--}}
                            {{--<option value="1">Zakat2u</option>--}}
                            {{--<option value="2">Call Center</option>--}}
                            {{--<option value="3">Aplikasi</option>--}}
                        {{--</select>--}}
                    </div>
                    <label class="col-sm-1 col-xs-2 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_byCategory">
                    <label class="col-sm-2 col-xs-12 control-label">Cawangan</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('branch_id',$branch,'',['class'=>'form-control chosen','id'=>'branch_id'])!!}
                    </div>
                    <label class="col-sm-1 col-xs-2 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_byCategory">
                    <label class="col-sm-2 col-xs-12 control-label">Lokasi</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('location_id',$asset_location,'',['class'=>'form-control chosen','id'=>'lokasi_id']) !!}
                    </div>
                    <label class="col-sm-1 col-xs-2 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_byCategory">
                    <label class="col-sm-2 control-label">Aset</label>
                    <div class="col-sm-6">
                        {!! Form::select('ict_no',$ict_no,'',['class'=>'form-control chosen','id'=>'ict_no']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kaedah</label>
                    <div class="col-sm-3">
                        {!! Form::select('complain_source_id',$complain_sources,'',['class'=>'form-control chosen']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
                    <label class="col-sm-2 control-label">Aduan</label>
                    <div class="col-sm-6">
                        <textarea name="complain_description" class="form-control" rows="3">{{old('complain_description')}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Hantar</button>
                    <a href="{{route('complain.index')}}" class="btn btn-default">Kembali</a>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
        </div>
    </div>

@endsection
{{--end section content --}}
@section('modal')
        <!-- Large modal -->
        <div id="bagiPihak" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Bagi Pihak</h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item active">
                                Firdaus
                            </a>
                            <a href="#" class="list-group-item">Syahril</a>
                            <a href="#" class="list-group-item">Ruzaini</a>
                            <a href="#" class="list-group-item">Rahmat</a>
                            <a href="#" class="list-group-item">Mohammad</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Large modal -->
        <div id="Aset" class="modal fade bs-example-modal-lg" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel2">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel2">Senarai Aset</h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item active">
                                Komputer Kaunter
                            </a>
                            <a href="#" class="list-group-item">Komputer 1</a>
                            <a href="#" class="list-group-item">Komputer 2</a>
                            <a href="#" class="list-group-item">Komputer 3</a>
                            <a href="#" class="list-group-item">Printer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
{{--end section modal --}}
@section('script')
    <script type="text/javascript">

        $( document ).ready(function() {


            $( "#complain_category_id" ).change(function() {
                var complain_category_id = $(this).val();

                show_hide_byCategory(complain_category_id);

            });

            $( "#branch_id" ).change(function() {
                var branch_id = $(this).val();
                get_location_byBranch(branch_id);

            });

            $( "#lokasi_id" ).change(function() {
                var lokasi_id = $(this).val();
                get_asset_byLocation(lokasi_id);
            });

            function get_location_byBranch(branch_id)
            {
//                alert(branch_id);
                $.ajax({
                    type: "GET",
                    url: base_url + '/complain/locations',
                    dataType:"json",
                    data:
                    {
                        branch_id : branch_id
                    },
                    beforeSend: function() {

                    },
                    success: function (location_data) {

                        console.log(location_data);
                        $("#lokasi_id").empty();

                        $.each(location_data,function (key,value) {

                            $("#lokasi_id").append("<option value='"+ key + "'>" + value + "</option>");
                        });

                        $("#lokasi_id").val('');
                        $("#lokasi_id").trigger("chosen:updated");

                    }
                });

            }

            function get_asset_byLocation(lokasi_id)
            {
//                alert(lokasi_id);
                $.ajax({
                    type: "GET",
                    url: base_url + '/complain/assets',
                    dataType:"json",
                    data:
                    {
                        lokasi_id : lokasi_id
                    },
                    beforeSend: function() {

                    },
                    success: function (asset_data) {

                        $("#ict_no").empty();

                        $.each(asset_data,function (key,value) {

                            $("#ict_no").append("<option value='"+ key + "'>" + value + "</option>");
                        });

                        $("#ict_no").val('');
                        $("#ict_no").trigger("chosen:updated");


                    }
                });

            }

            function show_hide_byCategory(complain_category_id) {

                var esp_complain_category_id = complain_category_id.split('-');

                complain_category_id= esp_complain_category_id[0];

                if(complain_category_id=='5'||complain_category_id=='6')
                {
                    $('.hide_byCategory').hide();
                }
                else
                {
                    $('.hide_byCategory').show();
                }
            }

        });

    </script>
    @endsection