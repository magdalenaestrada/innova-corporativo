<div class="modal fade text-left" id="ModalShow{{ $salida->reposicioncaja->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl"  role="document">
        <div class="modal-content">
        
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('SALIDA PARA REPOSICIÓN DE CAJA') }}
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
                                <label for="salida_fin">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $salida->reposicioncaja->created_at->format('d/m/y h:i:s') }}" disabled>
                            </div>

                            {{-- <div class="form-group col-md-4 g-3">
                                <label for="salida_fin">
                                    {{ __('BALANCE ANTERIOR') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $salida->reposicioncaja->ultimo_balance_caja }}" disabled>
                            </div> --}}

                            <div class="form-group col-md-4 g-3">
                                <label for="salida_fin">
                                    {{ __('REPOSICIÓN MONTO') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $salida->reposicioncaja->monto }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="salida_fin">
                                    {{ __('REPOSICIÓN MONTO') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ strtoupper($salida->reposicioncaja->caja->nombre) }}" disabled>
                            </div>
                            

                         

                            <div class="mt-2 col-md-12 table-responsives">
                                @if (count($salida->reposicioncaja->salidascaja) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                               
                                                <th scope="col">
                                                    {{ __('FECHA') }}
                                                </th>
            
                                                <th scope="col">
                                                    {{ __('CAJA') }}
                                                </th>
            
            
                                                <th>
                                                    {{ __('TIPO COMPR.') }}
                                                </th>
            
                                                <th>
                                                    {{ __('NRO COMPR.') }}
                                                </th>
            
                                                <th>
                                                    {{ __('FECHA COMPR.') }}
                                                </th>
            
            
                                                <th scope="col">
                                                    {{ __('MOTIVO') }}
                                                </th>
                                         
                                                <th scope="col">
                                                    {{ __('BENEFICIARIO') }}
                                                </th>
            
                                                <th scope="col">
                                                    {{ __('DESCRIPCION') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('MONTO') }}
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salida->reposicioncaja->salidascaja as $salidacaja)
                                            <tr>
                                                <td scope="row">
                                                    {{ \Carbon\Carbon::parse($salidacaja->created_at)->format('d/m/Y H:i') }}
                                                </td>
    
    
    
    
    
    
                                                <td scope="row">
                                                    @if ($salidacaja->caja)
                                                        {{ strtoupper($salidacaja->caja->nombre) }}
                                                    @endif
                                                </td>
    
                                                <td scope="row">
                                                    @if ($salidacaja->tipocomprobante)
                                                        {{ strtoupper($salidacaja->tipocomprobante->nombre) }}
                                                    @endif
                                                </td>
    
                                                <td scope="row">
                                                    @if ($salidacaja->comprobante_correlativo)
                                                        {{ strtoupper($salidacaja->comprobante_correlativo) }}
                                                    @else
                                                     IN-{{$salidacaja->id}}
                                                        @endif
    
    
                                                </td>
    
                                                <td scope="row">
                                                    @if ($salidacaja->fecha_comprobante)
                                                        {{ \Carbon\Carbon::parse($salidacaja->fecha_comprobante)->format('d/m/Y') }}
                                                    @endif
                                                </td>
    
    
    
                                                <td scope="row">
                                                    @if ($salidacaja->motivo)
                                                        {{ strtoupper($salidacaja->motivo->nombre) }}
                                                    @endif
    
    
                                                </td>
    

    
                                                <td scope="row">
                                                    @if ($salidacaja->beneficiario)
                                                        {{ strtoupper($salidacaja->beneficiario->nombre) }}
                                                    @endif
    
    
                                                </td>
    
    
                                                <td scope="row">
                                                    {{ $salidacaja->descripcion }}
    
                                                </td>
                                                <td scope="row" style="min-width: 100px">
    
                                                    <div class="d-flex justify-content-between">
                                                        <p>S/.</p>
                                                        <p> -{{ number_format($salidacaja->monto, 2) }}</p>
                                                    </div>
    
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

  


