@extends('admin.app')

@section('content_filter')



<div class="panel panel-info">
    <div class="panel-heading">Carian Pengguna</div>
    <div class="panel-body">

        {!! Form::open(array('route' => 'admin.users.index', 'method'=>'GET')) !!}

        <div class="row">
            <div class="col-lg-4">
                {!! Form::text('name',Request::get('name'),array('class'=>'form-control','placeholder'=>'Enter Name')) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::text('email',Request::get('email'),array('class'=>'form-control','placeholder'=>'Enter Email')) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::submit(trans('Cari'),array('class'=>'btn btn-primary')) !!}
            </div>
        </div>

        {!! Form::close() !!}


    </div>
</div>


@endsection

@section('heading', 'Users')

@section('content')

<h1> Senarai Pengguna </h1>
<hr>

<div class="models-actions">
    <p>
        <a class="btn btn-labeled btn-primary" href="{{ route('admin.users.create') }}"><span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Tambah Pengguna</a>
    </p>
</div>
<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Actions</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>

            @if($user->roles)

            @foreach($user->roles as $role)
            <code> {{ $role->display_name }} </code>
            <br>
            @endforeach

            @endif
        </td>
        <td class="col-xs-3">

            {!! Form::open(['data-remote','route' => ['admin.users.destroy',$user->id], 'method' => 'DELETE']) !!}

            @permission('edit_user')

            <a class="btn btn-labeled btn-default" href="{{ route('admin.users.edit', $user->id) }}"><span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span> Kemaskini</a>

            @endpermission

            @permission('delete_user')

            <button type="button" data-destroy="data-destroy" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="glyphicon glyphicon-trash"></i></span> Delete</button>

            @endpermission

            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>

{{ $users->appends(Request::except('page'))->links() }}

<div class="text-center">

</div>
@endsection