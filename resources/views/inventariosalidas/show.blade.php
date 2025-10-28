@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('REQUERIMIENTO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('inventariosalidas.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>
                                        {{ __('Estás viendo el ID') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $inventariosalida->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                    {{ $inventariosalida->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                    {{ $inventariosalida->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                            </div>



                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->created_at }}" disabled>
                            </div>




                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('ESTADO DEL REQUERIMIENTO') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->estado }}" disabled>
                            </div>


                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('CREADOR DEL REQUERIMIENTO') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->usuario_requerimiento }}"
                                    disabled>
                            </div>



                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('ORDEN ENTREGADA POR') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->usuario_entrega }}" disabled>
                            </div>













                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $inventariosalida->descripcion ? $inventariosalida->descripcion : 'No hay observación' }}</textarea>
                            </div>



                            <div class="mt-2">
                                @if (count($inventariosalida->productos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('CANTIDAD') }}
                                                </th>

                                                <th scope="col">
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventariosalida->productos as $producto)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $producto->nombre_producto }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>

                                                    <td scope="row">
                                                        {{ $producto->pivot->created_at }}
                                                    </td>






                                                </tr>
                                            @endforeach
                                        </tbody>








                                    </table>
                                @endif
                            </div>

                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('CÓDIGO DE REQUERIMIENTO') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->documento->codigo }}" disabled>
                            </div>


                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('AREA SOLICITANTE') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->documento->area_solicitante }}"
                                    disabled>
                            </div>

                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('PRIORIDAD') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->documento->prioridad }}" disabled>
                            </div>



                            <div class="form-group col-md-4 g-3">
                                <label for="documento_solicitante">
                                    {{ __('DOCUMENTO SOLICITANTE') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control"
                                        value="{{ $inventariosalida->documento->documento_solicitante }}" disabled>
                                    <button class="btn btn-secondary" type="button" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                            <path
                                                d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="nombre_solicitante">
                                    {{ __('NOMBRE SOLICITANTE') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->documento->nombre_solicitante }}"
                                    disabled>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  

@endsection
