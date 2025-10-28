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
                        <a class="btn btn-danger btn-sm" href="{{ route('productosfamilias.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="editar-productosfamilias"
                    action="{{ route('productosfamilias.update', $productosfamilia->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">


                        <div class="form-group col-md-6 g-3">
                            <label for="productosfamilia_id" class="text-success">
                                <b>
                                    {{ __('FAMILIA PADRE') }}
                                </b>
                            </label>
                            <select name="productosfamilia_id" id="productosfamilia_id"
                                class="form-select @error('productosfamilia_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($productosfamilias as $familia)
                                    @if ($familia->id != $productosfamilia->id)
                                        <option value="{{ $familia->id }}"
                                            {{ old('productosfamilia_id') == $familia->id ? 'selected' : '' }}>
                                            {{ $familia->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>









                        <div class="form-group col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('AÑADIR A LA FAMILIA') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('.editar-registro').submit(function(e) {
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
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        </script>
        @if ($errors->has('guia_remision') || $errors->has('guia_transportista'))
            <script>
                let errorMessage = '';

                @if ($errors->has('guia_remision'))
                    errorMessage += '<p>{{ $errors->first('guia_remision') }}</p>';
                @endif

                @if ($errors->has('guia_transportista'))
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
