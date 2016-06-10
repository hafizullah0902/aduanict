
{!! Form::open(array('route' => ['complain.verify',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal", 'id'=>"form1")) !!}
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Pengesahan Aduan</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Staf Tindakan</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->action_emp_id}}</p>
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
        <div class="form-group {{ $errors->has('user_comment') ? 'has-error' : false }}">
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