@if (count($invsalidasrapidas) > 0)
    @foreach ($invsalidasrapidas as $invsalidarapida)
        <tr style="font-size:13px">
            <td scope="row">
                {{ $invsalidarapida->id }}
            </td>
                                                    
            <td scope="row">
                {{ $invsalidarapida->nombre_solicitante }}
            </td>
                                                                                                        
            <td scope="row" class="text-center">
                @if (count( $invsalidarapida->productos)>0)
                    
                    {{  $invsalidarapida->productos[0]->nombre_producto }}

                    
                @endif
            </td>
                                                    
                                                    
            <td scope="row">
                                                        {{ $invsalidarapida->created_at }}
            </td>
                                                                                                    
            <td>
                                                        <div class="btn-group align-items-center">
                                                        @if ($invsalidarapida->estado !== 'ANULADO' && $invsalidarapida->created_at >= $today)
                                                            <a href="{{ route('invsalidasrapidas.anular', $invsalidarapida->id) }}" class="bin-button btn anular" style="margin-left: 5px;">
                                                                <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none"
                                                                        viewBox="0 0 39 7"
                                                                        class="bin-top">

                                                                        <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                                                        <line
                                                                        stroke-width="3"
                                                                        stroke="white"
                                                                        y2="1.5"
                                                                        x2="26.0357"
                                                                        y1="1.5"
                                                                        x1="12"
                                                                        ></line>
                                                                </svg>
                                                                <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none"
                                                                        viewBox="0 0 33 39"
                                                                        class="bin-bottom"
                                                                        >
                                                                        <mask fill="white" id="path-1-inside-1_8_19">
                                                                        <path
                                                                            d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                                                        ></path>
                                                                        </mask>
                                                                        <path
                                                                        mask="url(#path-1-inside-1_8_19)"
                                                                        fill="white"
                                                                        d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                                        ></path>
                                                                        <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                                                        <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                                                </svg>
                                                                <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none"
                                                                        viewBox="0 0 89 80"
                                                                        class="garbage"
                                                                        >
                                                                        <path
                                                                        fill="white"
                                                                        d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"
                                                                        ></path>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                        
                                                        @if ($invsalidarapida->estado   == 'ANULADO')
                                                            <p class="text-red">ANULADO</p>
                                                        @endif

                                                        <a href="{{ route('invsalidasrapidas.prnpriview', $invsalidarapida->id) }}" class="btnprn" style="margin-left: 5px;">

                                                        <div class="printer">
                                                            <div class="paper">

                                                                <svg viewBox="0 0 8 8" class="svg">
                                                                    <path fill="#0077FF" d="M6.28951 1.3867C6.91292 0.809799 7.00842 0 7.00842 0C7.00842 0 6.45246 0.602112 5.54326 0.602112C4.82505 0.602112 4.27655 0.596787 4.07703 0.595012L3.99644 0.594302C1.94904 0.594302 0.290039 2.25224 0.290039 4.29715C0.290039 6.34206 1.94975 8 3.99644 8C6.04312 8 7.70284 6.34206 7.70284 4.29715C7.70347 3.73662 7.57647 3.18331 7.33147 2.67916C7.08647 2.17502 6.7299 1.73327 6.2888 1.38741L6.28951 1.3867ZM3.99679 6.532C2.76133 6.532 1.75875 5.53084 1.75875 4.29609C1.75875 3.06133 2.76097 2.06018 3.99679 2.06018C4.06423 2.06014 4.13163 2.06311 4.1988 2.06905L4.2414 2.07367C4.25028 2.07438 4.26057 2.0758 4.27406 2.07651C4.81533 2.1436 5.31342 2.40616 5.67465 2.81479C6.03589 3.22342 6.23536 3.74997 6.23554 4.29538C6.23554 5.53084 5.23439 6.532 3.9975 6.532H3.99679Z"></path>
                                                                    <path fill="#0055BB" d="M6.756 1.82386C6.19293 2.09 5.58359 2.24445 4.96173 2.27864C4.74513 2.17453 4.51296 2.10653 4.27441 2.07734C4.4718 2.09225 5.16906 2.07947 5.90892 1.66374C6.04642 1.58672 6.1743 1.49364 6.28986 1.38647C6.45751 1.51849 6.61346 1.6647 6.756 1.8235V1.82386Z"></path>
                                                                </svg>

                                                            </div>
                                                            <div class="dot"></div>
                                                            <div class="output">
                                                                <div class="paper-out"></div>
                                                            </div>
                                                        </div>
                                                        </a>
                                                        </div>                                                   
            </td>
        </tr>
    @endforeach
@else
    <tr colspan="9" class="text-center text-muted">
                                                <td colspan="10" class="text-center text-muted">
                                                    {{ __('No hay datos disponibles') }} 
                                                </td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        $('.btnprn').printPage();

    });
</script>