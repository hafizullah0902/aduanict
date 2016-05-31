@extends('admin.app')

@section('content_filter')

    <div class="panel panel-info">
        <div class="panel-heading">Carian Hak Kebenaran</div>
        <div class="panel-body">

            {!! Form::open(array('route' => 'admin.permissions.index', 'method'=>'GET')) !!}

            <div class="row">
                <div class="col-lg-4">
                    {!! Form::text('name',Request::get('name'),array('class'=>'form-control','placeholder'=>'Enter Name')) !!}
                </div>
                <div class="col-lg-4">
                    {!! Form::submit('Cari',array('class'=>'btn btn-primary')) !!}
                </div>
            </div>

            {!! Form::close() !!}


        </div>
    </div>


@endsection

@section('heading', 'Permissions')

@section('content')
    <div class="models-actions">
        <p>
            <a class="btn btn-labeled btn-primary" href="{{ route('admin.permissions.create') }}"><span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Tambah Hak</a>
        </p>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th>Display Name</th>
            <th>Name</th>
            <th></th>
        </tr>
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->display_name }}</th>
                <td>{{ $permission->name }}</th>
                <td class="col-xs-3 text-right">

                    {!! Form::open(['data-remote','route' => ['admin.permissions.destroy',$permission->id], 'method' => 'DELETE']) !!}

                    @permission('edit_permission')

                    <a class="btn btn-labeled btn-default" href="{{ route('admin.permissions.edit', $permission->id) }}"><span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span> Kemaskini</a>

                    @endpermission

                    @permission('delete_permission')

                    <button type="button" data-destroy="data-destroy" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="glyphicon glyphicon-trash"></i></span> Delete</button>

                    @endpermission

                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>

    {{ $permissions->appends(Request::except('page'))->links() }}

    <div class="text-center">

    </div>
@endsection