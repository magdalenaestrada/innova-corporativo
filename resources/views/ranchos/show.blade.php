@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER TICKET DE COMEDOR') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('ranchos.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                           

                            
                           

                            <div class="form-group col-md-4 g-3">
                                <label for="documento_trabajador">
                                    {{ __('DOCUMENTO TRABAJADOR') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $rancho->documento_trabajador }}" disabled>
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
                                <label for="datos_trabajador">
                                    {{ __('DATOS TRABAJADOR') }}
                                </label>
                                <input class="form-control" value="{{ $rancho->datos_trabajador }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="cantidad" class="text-success">
                                    {{ __('CANTIDAD') }}
                                </label>
                                <input class="form-control" value="{{ $rancho->cantidad ?? 0 }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="lote">
                                    {{ __('LOTE') }}
                                </label>
                                <input class="form-control" value="{{ $rancho->lote }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="fecha">
                                    {{ __('CREACIÓN') }}
                                </label>
                                <input class="form-control" value="{{ $rancho->created_at }}" disabled>
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-muted">
                                    {{ __('DESCRIPCION') }}
                                </label>
                                <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                    placeholder="De ser el caso, ingrese una descripción o comentario..." disabled>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
