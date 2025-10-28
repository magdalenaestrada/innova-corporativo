@extends('admin.layout')

@section('content')
    <div class="container mt-5">
        <br>
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                            {{ __('ROLES')}}
                            </div>
                            <div class="col-md-6 text-right">
                            <a href="{{ url('roles/create') }}" class="btn btn-special float-end">
                                {{ __('CREAR NUEVO ROL') }}
                            </a>
                            </div>
                        
                    </div>

                    
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px">
                                @foreach ($roles as $role)
                                    
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-sm btn-warning">
                                            Add / Edit Role Permission
                                        </a>
                                        @can('edit role')
                                        <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                        @endcan

                                        @can('delete role')
                                        <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-sm btn-danger">Delete</a>
                                        @endcan

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
