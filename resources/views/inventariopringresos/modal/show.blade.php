<div class="modal fade text-left" id="ModalShow{{ $prestamoingreso->id }}" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">

                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('PRESTAMO INGRESO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                    <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">
                                    
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="row">

                            <div class="form-group col-md-6 g-3">
                                <label for="fecha" class="text-sm">
                                    {{ __('FECHA DE CREACIÓN') }} 
                                </label>
                                <input class="form-control form-control-sm" value="{{ $prestamoingreso->created_at }}" disabled>
                            </div>  
                                                    
                            <div class="form-group col-md-6 g-3">
                                <label for="" class="text-sm">
                                    {{ __('ESTADO DEL PRESTAMO RECIBIDO') }} <strong>{{ $prestamoingreso->destino }}</strong>
                                </label>
                                <input class="form-control form-control-sm" value="{{ $prestamoingreso->estado }}" disabled>
                            </div>                        

                            <div class="form-group col-md-6 g-3">
                                <label for="" class="text-sm">
                                    {{ __('PRESTAMO CREADO POR') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $prestamoingreso->usuario_creador }}" disabled>
                            </div>

                            @if($prestamoingreso->condicion == 'CON DEVOLUCIÓN')
                            <div class="form-group col-md-6 g-3">
                                <label for="inventarioingreso_fin" class="text-sm">
                                    {{ __('RECEPTOR DE LA DEVOLUCIÓN') }}
                                </label>

                                @if($prestamoingreso->usuario_devol_confirm)
                                <input class="form-control form-control-sm" value="{{ $prestamoingreso->usuario_devol_confirm }}"
                                    disabled>
                                @else
                                <input class="form-control form-control-sm" value="Aún no devolvemos los artículos prestados" style="color:red"
                                    disabled>
                                @endif                            
                            </div>
                            @endif

                            

                            <div class="form-group col-md-4 g-3">
                                    <label for="responsable" class="text-sm">
                                        {{ __('DOCUMENTO RESPONSABLE') }}
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" value="{{ $prestamoingreso->documento_responsable }}"
                                            disabled>
                                        <button class="btn btn-sm btn-secondary" type="button" id="buscar_proveedor_btn" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 25 25"
                                                style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                                <path
                                                    d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                    <label for="nombre_proveedor" class="text-sm">
                                        {{ __('NOMBRE RESPONSABLE') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $prestamoingreso->nombre_responsable }}" disabled>
                            </div>
                                

                            

                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <textarea class="form-control form-control-sm" disabled>{{ $prestamoingreso->observacion ? $prestamoingreso->observacion : 'No hay observación' }}</textarea>
                            </div>

                            <div class="mt-2 col-md-12">
                                @if (count($prestamoingreso->productos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('PRODUCTO DEL PRESTAMO') }}
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
                                            @foreach ($prestamoingreso->productos as $producto)
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

                            

              
                        </div>
                    </div>

           
        </div>
    </div>
</div>

