<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Maklumat Aduan</h3>
    </div>
    {!! Form::open(array('route' => ['complain.update',$editComplain->complain_id],'method'=>'put','class'=>"form-horizontal")) !!}
    <div class="panel-body">

        {{--<div class="form-group">--}}
            {{--<div id="clock" class="jqclock2 col-sm-1"></div>--}}
            {{--<input type="hidden" id="servertime" value="{{time()}}">--}}
        {{--</div>--}}
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
                <p class="form-control-static">{{$editComplain->user->name}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Bagi Pihak</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$editComplain->bagiPihak->name}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Kategori</label>
            <div class="col-sm-3">
                <p class="form-control-static">
                    @if (!empty($hide_dropdown_category) && $hide_dropdown_category !='Y')
                        {!! Form::select('complain_category_id',$complain_categories,$editComplain->complain_category_id.'-'.$editComplain->unit_id,['class'=>'form-control chosen','id'=>'complain_category_id']) !!}

                    @else
                        {{ $editComplain->complain_category->description}}
                        <input type="hidden" name="hide_dropdown_category" value="Y">
                    @endif
                </p>
            </div>
        </div>
        @if($hide_branch_location_asset=='N')
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 col-xs-12 control-label">Cawangan</label>
                <div class="col-sm-3 col-xs-10">
                    <p class="form-control-static">

                            @if(Entrust::hasRole('user'))
                                @if($editComplain->assets_location)
                                    <input type="hidden" name="branch_id" value="{{$editComplain->branch_id}}">
                                {{ $editComplain->assets_location->branch->branch_description }}

                                @endif
                            @else
                            {!! Form::select('branch_id',$branch,$editComplain->branch_id,['class'=>'form-control chosen','id'=>'branch_id'])!!}
                            @endif

                    </p>
                </div>

            </div>
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 col-xs-12 control-label">Lokasi</label>
                <div class="col-sm-3 col-xs-10">
                    {!! Form::select('lokasi_id',$asset_location,$editComplain->lokasi_id,['class'=>'form-control chosen','id'=>'lokasi_id'])!!}
                </div>
                <label class="col-sm-1 col-xs-2 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 control-label">Aset</label>
                <div class="col-sm-3">
                    {!! Form::select('ict_no',$ict_no,$editComplain->ict_no,['class'=>'form-control chosen','id'=>'ict_no']) !!}
                </div>
                <label class="col-sm-1 col-xs-2 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
        @else
            <input type="hidden" name="exclude_branch_asset" value="Y">
        @endif
        <div class="form-group">
            <label class="col-sm-2 control-label">Bahagian/Unit </label>
            <div class="col-sm-3 form-control-static ">
                @if (!empty($hide_dropdown_category) && $hide_dropdown_category !='Y')
                    {!! Form::select('unit_id',$unit_id,$editComplain->unit_id,['class'=>'form-control chosen','id'=>'unit_id'])!!}
                @else
                    {{ $editComplain->unit_id }}
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
            <label class="col-sm-2 control-label">Aduan</label>
            <div class="col-sm-3">
                <p class="form-control-static">{{$editComplain->complain_description}}</p>
            </div>
        </div>
        <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
            <label class="col-sm-2 control-label">Fail Lampiran</label>
            <div class="col-sm-6">
                @foreach($editComplain->attachments as $attachment)
                    <?php
                    $img_extension = ['png','jpg','bmp','gif','jpeg'];
                    $extension = File::extension($attachment->attachment_filename) ?>
                    @if(in_array($extension,$img_extension))
                        <div class="col-md-3" >
                            <a href="{{ url('uploads/'.$attachment->attachment_filename) }}" class="thumbnail">
                            <img src="{{ url('uploads/'.$attachment->attachment_filename)}}" alt="" >
                            </a>
                        </div>
                        @else
                        <p><a href="{{ url('uploads/'.$attachment->attachment_filename)}}" alt="">{{ $attachment->attachment_filename }}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Kemaskini</button>
                <a href="{{route('complain.index')}}" class="btn btn-default">Kembali</a>
            </div>
        </div>
        {!! Form::close() !!}
        {{--</form>--}}
    </div>
</div>