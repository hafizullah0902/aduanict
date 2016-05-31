@extends('layout.app')
@section('content')

    @include('layout/alert_message')

    {!! Form::open(array('route' => ['complain.update_action',$complain2->complain_id],'method'=>'put','class'=>"form-horizontal")) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Maklumat Aduan</h3>
        </div>
        <div class="panel-body">
            {{--<form class="form-horizontal">--}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tarikh/Masa </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{$complain2->created_at}}</p>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">No.Id </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{$complain2->complain_id}}</p>
                    </div>
                    <label class="col-sm-2 control-label">No. Pekerja </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{$complain2->user_id}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bagi Pihak</label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{$complain2->bagiPihak->name}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kategori</label>
                    <div class="col-sm-3">
                        <p class="form-control-static">{!! Form::select('complain_category_id',$complain_categories,$complain2->complain_category_id,['class'=>'form-control chosen']); !!} </p>
                    </div>
                </div>
                {{--<div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Cawangan</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('branch_id',$branch,$complain2->branch_id,['class'=>'form-control chosen','id'=>'branch_id']); !!}
                        --}}{{--<select class="form-control input-sm" name="complain_category_id">--}}{{--
                        --}}{{--<option value="1">Zakat2u</option>--}}{{--
                        --}}{{--<option value="2">Call Center</option>--}}{{--
                        --}}{{--<option value="3">Aplikasi</option>--}}{{--
                        --}}{{--</select>--}}{{--
                    </div>
                    <label class="col-sm-1 col-xs-2 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Lokasi</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('lokasi_id',$asset_location,$complain2->lokasi_id,['class'=>'form-control chosen','id'=>'lokasi_id']); !!}
                        --}}{{--<select class="form-control input-sm" name="complain_category_id">--}}{{--
                        --}}{{--<option value="1">Zakat2u</option>--}}{{--
                        --}}{{--<option value="2">Call Center</option>--}}{{--
                        --}}{{--<option value="3">Aplikasi</option>--}}{{--
                        --}}{{--</select>--}}{{--
                    </div>
                </div>--}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Aset</label>
                    <div class="col-sm-2">
                        <p class="form-control-static">Komputer 1 </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kaedah</label>
                    <div class="col-sm-2">
                        <p class="form-control-static">{{$complain2->complain_source->description}}</p>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
                    <label class="col-sm-2 control-label">Aduan</label>
                    <div class="col-sm-6">
                        <textarea name="complain_description" class="form-control">{{$complain2->complain_description}}</textarea>
                    </div>
                </div>
            {{--</form>--}}
        </div>
    </div>
    <!--end-->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Tindakan ICT Helpdeck</h3>
        </div>
        <div class="panel-body">
            {{--<form class="form-horizontal">--}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tarikh/Masa </label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><input type="hidden" class="form-control" name="action_date" value="<?php echo date('Y-m-d H:i:s'); ?>"><?php echo date('Y-m-d H:i:s'); ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bahagian/Unit </label>
                    <div class="col-sm-2">
                        <p class="form-control-static">Unit Perkakasan & Perisian</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Status</label>
                    <div class="col-sm-3 col-xs-10">
                        {!! Form::select('complain_status_id',$complain_status,$complain2->complain_status_id,['class'=>'form-control chosen']) !!}
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Tindakan</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="action_comment">{{ old('action_comment',$complain2->action_comment) }}</textarea>
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Sebab Lewat</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="delay_reason">{{ old('delay_reason',$complain2->delay_reason) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Hantar</button>
                        <a href="{{route('complain.index')}}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            {{--</form>--}}
        </div>
    </div>

    {!! Form::close() !!}
@endsection