{!! Form::open(array('route' => ['complain.update_assign_staff',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal",'id'=>"form1")) !!}
<!--end-->
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Agihan Tugas</h3>
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
                {!! Form::select('action_emp_id',$unit_staff_list,'',['class'=>'form-control ']) !!}
            </div>
            <label class="col-sm-1 col-xs-1 control-label">
                <span class="pull-left symbol"> * </span>
            </label>
        </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                    <input type="hidden" name="submit_type" value="{{ old('submit_type')}}" id="submit_type" />

                    <button type="button" class="btn btn-success" name="submit_agih" id="submit_agih">
                        <span class="glyphicon glyphicon-user"></span> Agih Tugas
                    </button>

                </div>
            </div>


        {!! Form::close() !!}
        {{--</form>--}}
    </div>
</div>