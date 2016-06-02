{!! Form::open(array('route' => ['complain.update_action',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal",'id'=>"form1")) !!}
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
            <label class="col-sm-2 col-xs-12 control-label">Status</label>
            <div class="col-sm-3 col-xs-10">
                {!! Form::select('complain_status_id',$complain_status,$editComplain->complain_status_id,['class'=>'form-control ']) !!}
            </div>
            <label class="col-sm-1 col-xs-1 control-label">
                <span class="pull-left symbol"> * </span>
            </label>
        </div>
        @if($editComplain->complain_status_id!=4)
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Tindakan</label>
                <div class="col-sm-6 col-xs-10">
                    <textarea class="form-control" rows="3" name="action_comment">{{ old('action_comment',$editComplain->action_comment) }}</textarea>
                </div>
                <label class="col-sm-1 col-xs-1 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Sebab Lewat</label>
                <div class="col-sm-6 col-xs-10">
                    <textarea class="form-control" rows="3" name="helpdesk_delay_reason">{{ old('helpdesk_delay_reason',$editComplain->helpdesk_delay_reason) }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span>Hantar</button>
                    <a href="{{route('complain.index')}}" class="btn btn-default">Kembali</a>
                </div>
            </div>

        @else
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                    <input type="hidden" name="submit_type" value="{{ old('submit_type')}}" id="submit_type" />

                    <button type="button" class="btn btn-success" name="submit_finish" id="submit_finish">
                        <span class="glyphicon glyphicon-flag"></span> Tutup Aduan
                    </button>
                </div>
            </div>
        @endif

        {!! Form::close() !!}
        {{--</form>--}}
    </div>
</div>