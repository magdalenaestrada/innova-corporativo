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
                                    {{ __('VER PROGRAMACIÓN') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('programacion.index') }}">
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
                                    <span class="badge text-bg-secondary">{{ $programacion->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                    {{ $programacion->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                    {{ $programacion->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @if ($programacion->updated_at != $programacion->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $programacion->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                        {{ $programacion->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                        {{ $programacion->updated_at->format('H:i:s') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Esta programacion aún no ha sido actualizado') }}
                                        </strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>


                            <div class="form-group col-md-3 g-3">
                                <label for="programacion_inicio">
                                    {{ __('PROGRAMACIÓN INICIO') }}
                                </label>
                                <input class="form-control" value="{{ $programacion->programacion_inicio }}" disabled>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="programacion_fin">
                                    {{ __('PROGRAMACIÓN FIN') }}
                                </label>
                                <input class="form-control" value="{{ $programacion->programacion_fin }}" disabled>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="ejecucion_inicio">
                                    {{ __('EJECUCION INICIO') }}
                                </label>
                                <input class="form-control" value="{{ $programacion->ejecucion_inicio }}" disabled>
                            </div>

                            <div class="form-group col-md-3 g-3">
                                <label for="ejecucion_fin">
                                    {{ __('EJECUCION FIN') }}
                                </label>
                                <input class="form-control" value="{{ $programacion->ejecucion_finalizada }}" disabled>
                                <br>
                            </div>




                            <div class="ml-1">
                                <h4>PROGRAMADOS</h4>
                                <ul>
                                    @foreach ($registros as $registro)
                                        <li>{{ $registro->id }}. fecha creación: {{ $registro->created_at->format('Y-m-d H:i:s') }}, TONELADAS: {{ $registro->toneladas }}, CLIENTE: {{ $registro->datos_cliente }} ({{ $registro->documento_cliente }})</li>
                                    @endforeach
                                </ul>


                                <h4>EJECUTADOS</h4>
                                <ul>
                                    @foreach ($registros_ejecutados as $registro)
                                        <li>{{ $registro->id }}. fecha creación: {{ $registro->created_at->format('Y-m-d H:i:s') }}, TONELADAS: {{ $registro->toneladas }}, CLIENTE: {{ $registro->datos_cliente }} ({{ $registro->documento_cliente }})</li>
                                    @endforeach
                                </ul>
                            </div>



                            <p class="col-md-12 text-end g-3 h3 mt-3">Toneladas programadas: {{ $sum_of_tons_programado_total }}</p>
                            <p class="col-md-12 text-end g-3 h4 mt-3">Toneladas ejecutadas: {{ $sum_of_tons_ejecutado_total }}</p>
                            <p class="col-md-12 text-end g-3 h5 mt-3">Toneladas restantes: {{ $tons_restantes }}</p>






                            <div class="form-group col-md-12 g-3">
                                <label for="observacion">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $programacion->observacion ? $registro->observacion : 'No hay observación' }}</textarea>
                            </div>

                            @if ($programacion->estado != 'finalizada')
                            <div class="mt-3 text-center">
                                <a class="btn btn-light" href="{{ route('programacion.createrequerimiento', $programacion->id) }}">
                                {{ __('AÑADIR REQUERIMIENTO') }}
                            </a>
                            </div>
                            @endif

                            <div class="mt-2">
                                @if (count($programacion->productos) > 0)
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
                                                {{ __('PRECIO') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('FECHA DE CREACIÓN') }}
                                            </th>
                                            @if ($programacion->estado != 'finalizada')
                                            <th class="text-center">
                                                {{ __('ACCIÓN') }}
                                            </th>
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($programacion->productos as $producto)
                                        <tr class="text-center">
                                            <td scope="row">
                                                {{ $producto->nombre_producto }}
                                            </td>
                                            <td scope="row">
                                                {{ $producto->pivot->cantidad }} gramos
                                            </td>
                                            <td scope="row">
                                                $ {{ $producto->precio }}
                                            </td>
                                            <td scope="row">
                                                {{ ($producto->pivot->created_at) }}
                                            </td>
                                            
                                           
                                            @if ($programacion->estado != 'finalizada')
                                            <td class="text-center">
                                                <form class="eliminar-requerimiento" action="{{ route('programacion.destroyrequerimiento', ['programacion' => $programacion->id, 'producto' => $producto->id, 'pivotId' => $producto->pivot->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        {{ __('ELIMINAR') }}
                                                    </button>
                                                </form>
    
                                            </td>
                                            @endif
    
                                            
    
    
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                                @endif
                            </div>
                            
                            
                            



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
