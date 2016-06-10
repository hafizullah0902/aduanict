@extends('layout.app')
@section('content')

    @include('layout/alert_message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Hantar Aduan</h3>
        </div>
        <div class="panel-body">

            {{--<form class="form-horizontal">--}}
            {!! Form::open(array('route' => 'complain.store', 'class'=>"form-horizontal", 'files'=>true)) !!} {{-- Untuk tujuan security (form + security token) --}}

                <div class="form-group">
                    <label class="col-sm-2 col-xs-2 control-label">Tarikh </label>
                    <div class="col-sm-2 col-xs-10">
                        <p class="form-control-static">{{ date('d/m/Y')}}</p>
                    </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-2 col-xs-2 control-label">Masa </label>
                    <div class="col-sm-2 col-xs-10">
                        <div id="clock"></div>
                        <input type="hidden" id="servertime" value="{{time()}}">
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
                    <div class="col-sm-1">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('bagi_pihak', 'Y',false,['id'=>"bagi_pihak"]) }} Ya
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3 hide_div" id="hide_bagiPihak">
                        <div class="input-group">
                            {!! Form::select('user_emp_id',$users,'user_emp_id',['class'=> 'form-control','id'=>'user_emp_id'])!!}
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
                        {!! Form::select('lokasi_id',$asset_location,'',['class'=>'form-control chosen','id'=>'lokasi_id']) !!}
                    </div>
                    <label class="col-sm-1 col-xs-2 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_byCategory {{ $errors->has('complain_description') ? 'has-error' : false }}">
                    <label class="col-sm-2 control-label">Aset</label>
                    <div class="col-sm-6">
                        {!! Form::select('ict_no',$ict_no,'',['class'=>'form-control chosen','id'=>'ict_no']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kaedah</label>
                    <div class="col-sm-3">
                        {!! Form::select('complain_source_id',$complain_sources,'',['class'=>'form-control chosen','id'=>'complain_source_id']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
                    <label class="col-sm-2 control-label">Aduan</label>
                    <div class="col-sm-6">
                        <textarea name="complain_description" class="form-control" rows="3">{{old('complain_description')}}</textarea>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('complain_attachment') ? 'has-error' : false }}">
                    <label class="col-sm-2 control-label">Muatnaik Gambar/<br>fail</label>
                    <div class="col-sm-6">
                        {!! Form::file('complain_attachment',['class'=>'form-control']) !!}
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

@endsection
{{--end section modal --}}
@section('script')
    @include('complains.partials.form_script')
    @endsection