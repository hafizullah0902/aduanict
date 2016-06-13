@extends('layout.app')
@section('filter')
        <div class="panel panel-success">
            <div class="panel-heading"> Carian</div>
            <div class="panel-body">
                {!! Form::open(array('route'=>'complain.index','method'=>'GET','id'=>'form1')) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::select('complain_status_id',$complain_status,Request::get('complain_status_id'),['class'=>'form-control chosen','id'=>'complain_status_id'])!!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::text('carian',Request::get('carian'),['class'=>'form-control','id'=>'branch_id'])!!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('start_date',Request::get('start_date'),['class'=>'form-control datepicker','id'=>'start_date'])!!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('end_date',Request::get('end_date'),['class'=>'form-control datepicker','id'=>'end_date'])!!}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Carian</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
@endsection
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
                </div>
            </div>
            <hr>
            <div class="col-sm-12">
            <table class=" table table-responsive table-hover">

                <tr>
                    <th>No.Aduan</th>
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
                            {!! Helper::get_status_panel($rekodcomplain->complain_status_id) !!}
                        </td>
                        <td>{{ $rekodcomplain->complain_source->description or $rekodcomplain->complain_source_id }}</td>
                        <td>{{ $rekodcomplain->bagiPihak->name or $rekodcomplain->user_emp_id}}</td>
                        <td>{{ $rekodcomplain->complain_category->description or $rekodcomplain->complain_category_id}}</td>
                        <td>{{ str_limit($rekodcomplain->action_comment,40) }}</td>
                        <td>{{ $rekodcomplain->action_date }}</td>
                        <td>

                            {!! Form::open(array('route' => ['complain.destroy',$rekodcomplain->complain_id],'method'=>'delete','class'=>"form-horizontal")) !!}
                                <div class="btn-group btn-group-sm">

                                    {!! Helper::get_function_button($rekodcomplain) !!}

                                    {{--@if($rekodcomplain->complain_status_id == 1)
                                        @if(Entrust::can('action_complain')&& Entrust::hasRole('ict_helpdesk'))
                                            <a href="{{route('complain.action',$rekodcomplain->complain_id)}}" class="btn btn-warning">
                                                <span class="glyphicon glyphicon-wrench"></span> Kemaskini</a>
                                        @elseif (Entrust::can('edit_complain')&& ($rekodcomplain->user_id==Auth::user()->emp_id || $rekodcomplain->user_emp_id==Auth::user()->emp_id))
                                            <a href="{{route('complain.edit',$rekodcomplain->complain_id)}}" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>
                                        @elseif (Entrust::can('delete_complain'))
                                            <button type="button" class="glyphicon glyphicon-trash" data-destroy></button>
                                        @else
                                            <a href="{{route('complain.show',$rekodcomplain->complain_id)}}" class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 2 && $rekodcomplain->action_emp_id == Auth::user()->emp_id)
                                        @if(Entrust::can('technical_action'))
                                            <a href="{{route('complain.technical_action',$rekodcomplain->complain_id)}}" class="glyphicon glyphicon-pencil" role="button">Tindakan</a>
                                        @elseif( Entrust::can('action_complain'))
                                            <a href="{{route('complain.action',$rekodcomplain->complain_id)}}" class="btn btn-warning">
                                                <span class="glyphicon glyphicon-wrench"></span> Kemaskini</a>
                                        @else
                                            <a href="{{route('complain.show',$rekodcomplain->complain_id)}}" class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 3)
                                        @if(Entrust::can('verify_complain')&& ($rekodcomplain->user_id==Auth::user()->emp_id || $rekodcomplain->user_emp_id==Auth::user()->emp_id))
                                            <a href="{{route('complain.edit',$rekodcomplain->complain_id)}}" class="btn btn-success">
                                                <span class="glyphicon glyphicon-copy"></span> Pengesahan(P)</a>
                                        @else
                                            <a href="{{route('complain.show',$rekodcomplain->complain_id)}}" class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>
                                        @endif

                                    @elseif($rekodcomplain->complain_status_id == 4)
                                        @if(Entrust::can('action_complain')&& Entrust::hasRole('ict_helpdesk'))
                                            <a href="{{route('complain.action',$rekodcomplain->complain_id)}}" class="btn btn-success">
                                                <span class="glyphicon glyphicon-header"></span> Pengesahan (H)</a>
                                        @else
                                            <a href="{{route('complain.show',$rekodcomplain->complain_id)}}" class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>
                                        @endif
                                    @elseif($rekodcomplain->complain_status_id == 6)

                                    @else
                                        <a href="{{route('complain.show',$rekodcomplain->complain_id)}}" class="btn btn-info">
                                            <span class="glyphicon glyphicon-eye-open"></span> Papar</a>

                                    @endif--}}
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
