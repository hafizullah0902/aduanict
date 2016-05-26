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
                    <th>Bil. Aduan</th>
                    <th>Tarikh Aduan</th>
                    <th>User Id</th>
                    <th>Aduan</th>
                    <th>Status</th>
                    <th>SUMBER</th>
                    <th>Id Daftar</th>
                    <th>Kategori</th>
                    <th>Tindakan</th>
                    <th>Tarikh Tindakan</th>
                    <th></th>

                </tr>
                @foreach($complain2 as $rekodcomplain)
                <tr>
                    <tr>
                        <td>{{ $rekodcomplain->complain_id }}
                        <?php $id=$rekodcomplain->complain_id; ?>
                        </td>
                        <td>{{ $rekodcomplain->created_at }}</td>
                        <td>{{ $rekodcomplain->user_id }}</td>
                        <td>{{ str_limit($rekodcomplain->complain_description,40) }}</td>
                        <td>
                            @if ($rekodcomplain->complain_status_id == 1)
                                <span class="label label-primary">Baru</span>
                            @elseif ($rekodcomplain->complain_status_id == 2)
                                <span class="label label-info">Tindakan</span>
                            @elseif ($rekodcomplain->complain_status_id == 3)
                                <span class="label label-success">Selesai</span>
                            @endif</td>
                        <td>{{ $rekodcomplain->complain_source_id }}</td>
                        <td>{{ $rekodcomplain->user_emp_id }}</td>
                        <td>{{ $rekodcomplain->complain_category_id }}</td>
                        <td>{{ str_limit($rekodcomplain->action_comment,40) }}</td>
                        <td>{{ $rekodcomplain->action_date }}</td>
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
                            {!! Form::open(array('route' => ['complain.destroy',$rekodcomplain->complain_id],'method'=>'delete','class'=>"form-horizontal")) !!}
                                <div class="btn-group btn-group-sm">
                                    @if ($rekodcomplain->complain_status_id != 3)
                                        <a href="{{route('complain.edit',$id)}}" class="glyphicon glyphicon-pencil btn-default" href="#" role="button"></a>
                                    @endif
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
