@extends('admin.layout')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">

                    <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                            {{ __('PERMISOS') }}
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ url('permissions/create') }}" class="btn btn-special float-end"> {{ __('CREAR NUEVO PERMISO') }}</a>
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
                                @foreach ($permissions as $permission)
                                    
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <a href="{{ url('permissions/'.$permission->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                        <a href="{{ url('permissions/'.$permission->id.'/delete') }}" class="btn btn-sm btn-danger ">Delete</a>
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
