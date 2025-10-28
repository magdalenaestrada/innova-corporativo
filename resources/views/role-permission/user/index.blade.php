@extends('admin.layout')

@section('content')
    <br>
    <div class="container">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('USUARIOS REGISTRADOS') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ url('users/create') }}" class="btn btn-special">
                                {{ __('AÑADIR USUARIO') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px">
                                @foreach ($users as $user)
                                    
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <label class="badge bg-dark mx-1">{{ $rolename }}</label>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                        <a href="{{ url('users/'.$user->id.'/delete') }}" class="btn btn-sm btn-danger ">Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

            </div>
        </div>
    </div>
@endsection
