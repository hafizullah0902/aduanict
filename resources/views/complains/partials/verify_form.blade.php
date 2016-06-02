<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Maklumat Aduan</h3>
    </div>
    {!! Form::open(array('route' => ['complain.update',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal")) !!}
    <div class="panel-body">
        {{--<form class="form-horizontal">--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Tarikh </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{ $editComplain->created_at->format('d/m/Y') }}</p>
            </div>
            <label class="col-sm-2 control-label">Masa </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{ $editComplain->created_at->format('H:i:s') }}</p>
            </div>

        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">No.Id </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->complain_id}}</p>
            </div>
            <label class="col-sm-2 control-label">No. Pekerja </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->user_id}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Bagi Pihak</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->user_emp_id}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Kategori</label>
            <div class="col-sm-3">
                <p class="form-control-static">{!! Form::select('complain_category_id',$complain_categories,$editComplain->complain_category_id,['class'=>'form-control chosen']) !!} </p>
            </div>
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
                {!! Form::select('lokasi_id',$asset_location,'',['class'=>'form-control chosen','id'=>'lokasi_id'])!!}
            </div>
            <label class="col-sm-1 col-xs-2 control-label">
                <span class="pull-left symbol"> * </span>
            </label>
        </div>
        <div class="form-group hide_byCategory">
            <label class="col-sm-2 control-label">Aset</label>
            <div class="col-sm-6">
                {{--{!! Form::select('ict_no',$ict_no,'',['class'=>'form-control chosen','id'=>'ict_no']) !!}--}}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Bahagian/Unit </label>
            <div class="col-sm-2">
                <p class="form-control-static">Unit Perkakasan & Perisian</p>
            </div>
        </div>
        <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
            <label class="col-sm-2 control-label">Aduan</label>
            <div class="col-sm-6">
                <textarea name="complain_description" class="form-control">{{$editComplain->complain_description}}</textarea>
            </div>
        </div>
        {!! Form::close() !!}
        {{--</form>--}}
    </div>
</div>

{!! Form::open(array('route' => ['complain.verify',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal", 'id'=>"form1")) !!}
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Tarikh/Masa - {{$editComplain->created_at}} </h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Staf Tindakan</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->action_by}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tindakan </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{ $editComplain->action_comment }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Sebab Lewat</label>
            <div class="col-sm-6">
                <p class="form-control-static">
                {{ $editComplain->delay_reason }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Sebab (Tidak Selesai)</label>
            <div class="col-sm-6">
                <p class="form-control-static">
                    <textarea name="user_comment" class="form-control" ></textarea>
            </div>
        </div>
        @if($editComplain->complain_status_id==3)
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                    <input type="hidden" name="submit_type" value="{{ old('submit_type')}}" id="submit_type" />

                    <button type="button" class="btn btn-success" name="submit_finish" id="submit_finish">
                        <span class="glyphicon glyphicon-ok"></span> Selesai
                    </button>
                    <button type="button" class="btn btn-info" name="submit_reject" id="submit_reject">
                        <span class="glyphicon glyphicon-remove"></span> Tidak Selesai
                    </button>
                </div>
            </div>
        @endif

    </div>
</div>
{!! Form::close() !!}
<!--end-->