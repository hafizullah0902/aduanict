@extends('layout.app')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Senarai Aduan</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10 col-xs-2">
                    <a href="{{route('complain.create')}}" class="btn btn-warning">Tambah Aduan</a>

                    <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        10 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">9</a></li>
                        <li><a href="#">8</a></li>
                        <li><a href="#">7</a></li>
                    </ul>
                </div>
                <div class="col-sm-2 col-xs-10">
                    <input type="text" class="form-control" placeholder="Cari..." aria-describedby="basic-addon1">
                </div>
            </div>
            <hr>
            <div class="table-responsive">
            <table class="table table-hover">

                <tr>
                    <th>Bil.Aduan</th>
                    <th>User Id</th>
                    <th>Aduan</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                    <th>Id Daftar</th>
                    <th width="10%"></th>

                </tr>
                @foreach($complain2 as $rekodcomplain)
                <tr>
                    <tr>
                        <td>{{ $rekodcomplain->ADUAN_ID }}
                        <?php $id=$rekodcomplain->ADUAN_ID; ?>
                        </td>
                        <td>{{ $rekodcomplain->EMP_ID_ADUAN }}</td>
                        <td>{{ str_limit($rekodcomplain->ADUAN,40) }}</td>
                        <td>
                            @if ($rekodcomplain->KOD_STATUS == 1)
                                <span class="label label-primary">Baru</span>
                            @elseif ($rekodcomplain->KOD_STATUS == 2)
                                <span class="label label-info">Tindakan</span>
                            @elseif ($rekodcomplain->KOD_STATUS == 3)
                                <span class="label label-success">Selesai</span>
                            @endif</td>
                        <td>{{ str_limit($rekodcomplain->TINDAKAN,40) }}</td>
                        <td>{{ $rekodcomplain->LOGIN_DAFTAR }}</td>
                        <td>

                            {{--<div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('complain.edit',$id)}}">Kemaskini</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>--}}
                            {!! Form::open(array('route' => ['complain.destroy',$rekodcomplain->ADUAN_ID],'method'=>'delete','class'=>"form-horizontal")) !!}
                                <div class="btn-group btn-group-sm">
                                <a href="{{route('complain.edit',$id)}}" class="glyphicon glyphicon-pencil btn-default" href="#" role="button"></a>
                                <button type="submit" class="glyphicon glyphicon-remove btn-danger"></button>
                                </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                </tr>
                @endforeach
            </table>
            <nav class="navbar-form navbar-right">
               {{--pagination--}}
                {{ $complain2->appends(Request::except('page'))->links()}}
            </nav>
        </div>
        </div>
    </div>

@endsection
