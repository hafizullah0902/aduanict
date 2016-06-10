@extends('layout.app')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Senarai Aduan</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10">
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
            <div class="table col-sm-12">
            <table class="table-responsive table-hover">

                <tr>
                    <th>Bil. Aduan</th>
                    <th>Tarikh Aduan</th>
                    <th>Pengadu</th>
                    <th>Aduan</th>
                    <th>Status</th>
                    <th>Saluran</th>
                    <th>Id Daftar</th>
                    <th>Kategori</th>
                    <th>Tindakan</th>
                    <th>Tarikh Tindakan</th>
                    <th width="5%"></th>

                </tr>

                @foreach($complain2 as $rekodcomplain)

                <tr>
                    <tr>
                        <td>{{ $rekodcomplain->complain_id }}
                        <?php $id=$rekodcomplain->complain_id; ?>
                        </td>
                        <td>{{ $rekodcomplain->created_at }}</td>
                        <td> @if($rekodcomplain->user)
                                {{ $rekodcomplain->user_emp_id }} - {{$rekodcomplain->user->name }}
                             @else
                                {{ $rekodcomplain->user_emp_id }}
                             @endif
                                </td>
                        <td>{{ str_limit($rekodcomplain->complain_description,40) }}</td>
                        <td>
                            @if ($rekodcomplain->complain_status_id == 1)
                                <span class="label label-primary">Baru</span>
                            @elseif ($rekodcomplain->complain_status_id == 2)
                                <span class="label label-info">Tindakan</span>
                            @elseif ($rekodcomplain->complain_status_id == 3)
                                <span class="label label-success">Sahkan (P)</span>
                            @elseif ($rekodcomplain->complain_status_id == 4)
                                <span class="label label-success">Sahkan (H)</span>
                            @elseif ($rekodcomplain->complain_status_id == 5)
                                <span class="label label-success">Selesai</span>
                            @elseif ($rekodcomplain->complain_status_id == 7)
                                <span class="label label-warning">Agihan</span>
                            @endif</td>
                        <td>{{ $rekodcomplain->complain_source_id }}</td>
                        <td>{{ $rekodcomplain->user_id }}</td>
                        <td>{{ $rekodcomplain->complain_category_id }}</td>
                        <td>{{ str_limit($rekodcomplain->action_comment,40) }}</td>
                        <td>{{ $rekodcomplain->action_date }}</td>
                        <td>

                            {!! Form::open(array('route' => ['complain.destroy',$rekodcomplain->complain_id],'method'=>'delete','class'=>"form-horizontal")) !!}
                                <div class="btn-group btn-group-sm">

                                    @if($rekodcomplain->complain_status_id == 1)
                                        @if(Entrust::can('action_complain')&& Entrust::hasRole('ict_helpdesk'))
                                            <a href="{{route('complain.action',$rekodcomplain->complain_id)}}" class="btn btn-warning">
                                                <span class="glyphicon glyphicon-wrench"></span> Kemaskini</a>
                                        @elseif (Entrust::can('edit_complain'))
                                            <a href="{{route('complain.edit',$rekodcomplain->complain_id)}}" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>
                                        @elseif (Entrust::can('delete_complain'))
                                            <button type="button" class="glyphicon glyphicon-trash" data-destroy></button>
                                        @else
                                            <a href="" class="glyphicon glyphicon-pencil" role="button">Tegok Sajo</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 2)
                                        @if(Entrust::can('technical_action'))
                                            <a href="{{route('complain.technical_action',$rekodcomplain->complain_id)}}" class="glyphicon glyphicon-pencil" role="button">Tindakan</a>
                                        @else
                                            <a href="" class="glyphicon glyphicon-pencil" role="button">Tegok Sajo</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 3 &&)
                                        @if(Entrust::can('verify_complain'))
                                            <a href="{{route('complain.edit',$rekodcomplain->complain_id)}}" class="glyphicon glyphicon-pencil" role="button">Pengesahan(P)</a>
                                        @else
                                            <a href="" class="glyphicon glyphicon-pencil" role="button">Tegok Sajo</a>
                                        @endif

                                    @elseif($rekodcomplain->complain_status_id == 4)
                                        @if(Entrust::can('action_complain')&& Entrust::hasRole('ict_helpdesk'))
                                            <a href="{{route('complain.action',$rekodcomplain->complain_id)}}" ><span class="glyphicon glyphicon-wrench">Pengesahan (H)</span></a>
                                        @else
                                            <a href="" class="glyphicon glyphicon-pencil" role="button">Tegok Sajo</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 6)

                                    @else
                                            <a href="" class="glyphicon glyphicon-pencil" role="button">Tegok Sajo</a>

                                    @endif
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
