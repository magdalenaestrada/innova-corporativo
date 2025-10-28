@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA COMENZAR LA EJECUCIÓN') }}
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
                <form class="editar-programacion" action="{{ route('programacion.updatestart', $programacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        
                        
                        <div class="form-group col-md-12 g-3">
                            <label for="ejecucion_inicio" class="text-muted">
                                {{ __('EJECUCIÓN FECHA INICIO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="datetime-local" name="ejecucion_inicio"
                                placeholder="Ingrese la fecha del Inicio de la Ejecución" class="form-control">
                        </div>
                        


                        
                        
                       
                        
                       
                       
                        <div class="form-group col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('ACTUALIZAR REGISTRO') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('.editar-registro').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿actualizar registro?',
                    icon: 'warning',
                    ShowCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
        @if($errors->has('guia_remision') || $errors->has('guia_transportista'))
            <script>
                let errorMessage = '';
        
                @if($errors->has('guia_remision'))
                    errorMessage += '<p>{{ $errors->first('guia_remision') }}</p>';
                @endif
        
                @if($errors->has('guia_transportista'))
                    errorMessage += '<p>{{ $errors->first('guia_transportista') }}</p>';
                @endif
        
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: errorMessage,
                });
            </script>
        @endif
    @endpush
@endsection