<div class="modal fade text-left" id="ModalShow{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('REQUERIMIENTO') }}
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
                            



                            <div class="form-group col-md-4 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control" value="{{ $lote->created_at }}" disabled>
                            </div>




                            <div class="form-group col-md-4 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('CÓDIGO') }}
                                </label>
                                <input class="form-control" value="{{ $lote->codigo }}" disabled>
                            </div>


                            <div class="form-group col-md-4 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('NOMBRE DEL LOTE') }}
                                </label>
                                <input class="form-control" value="{{ $lote->nombre }}"
                                    disabled>
                            </div>





                            @if (count($lote->clientes) > 0)
                            <div class="mt-2 col-md-12">
                                
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('DOCUMENTO DEL CLIENTE') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('NOMBRE DEL CLIENTE') }}
                                                </th>

                                                


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lote->clientes as $cliente)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $cliente->documento }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $cliente->nombre }}
                                                    </td>

                                                




                                                </tr>
                                            @endforeach
                                        </tbody>








                                    </table>
                            </div>

                            @endif

                        



                          



                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

  


