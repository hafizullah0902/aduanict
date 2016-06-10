<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Maklumat Aduan</h3>
    </div>
        <div class="panel-body">
            <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tarikh / Masa <br>Aduan </label>
                <div class="col-sm-2">
                    <p class="form-control-static">{{ $editComplain->created_at->format('d/m/Y')}} {{ $editComplain->created_at->format('H:i:s') }}</p>
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
                    <p class="form-control-static">
                        @if($editComplain->bagiPihak)
                            {{$editComplain->bagiPihak->name}}
                        @else
                            {{$editComplain->user_emp_id}}
                        @endif
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$editComplain->complain_category->description}} </p>
                </div>
            </div>
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 col-xs-12 control-label">Cawangan</label>
                <div class="col-sm-3 col-xs-10">
                    <p class="form-control-static">
                        {{$editComplain->assets_location->branch->branch_description}}
                    </p>
                </div>
                <label class="col-sm-1 col-xs-2 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 col-xs-12 control-label">Lokasi</label>
                <div class="col-sm-3 col-xs-10">
                    <p class="form-control-static">
                        {{$editComplain->lokasi->butiran}}
                    </p>
                </div>
            </div>
            <div class="form-group hide_byCategory">
                <label class="col-sm-2 control-label">Aset</label>
                <div class="col-sm-6">
                    {{--{{$editComplain->assets->butiran}}--}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bahagian/Unit </label>
                <div class="col-sm-2">
                    <p class="form-control-static">
                        {{$editComplain->unit_id}}
                    </p>
                </div>
            </div>
            <div class="form-group {{ $errors->has('complain_description') ? 'has-error' : false }} ">
                <label class="col-sm-2 control-label">Aduan</label>
                <div class="col-sm-6">
                    <p class="form-control-static"> {{ $editComplain->complain_description }} </p>
                </div>
            </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        </div>
                </div>
            </form>
        </div>

</div>