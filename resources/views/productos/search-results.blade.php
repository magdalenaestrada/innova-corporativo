@if (count($productos) > 0)
    @foreach ($productos as $producto)
        <tr style="font-size:13px" class="text-center">
            <td scope="row">
                {{ $producto->id }}
            </td>

            <td scope="row">
                {{ $producto->nombre_producto }}
                @if ($producto->stock == 0)
                    <span class="text-danger"
                        style="font-style: Monospace;font-weight:600; font-size: 16px"> (SIN
                        STOCK)</span>
                @endif
            </td>



            <td scope="row">
                @if ($producto->stock)
                    {{ $producto->stock }}
                @else
                    {{ __('-') }}
                @endif

            </td>


            <td scope="row" class="text-center">
                @if ($producto->precio)
                    s/{{ $producto->precio }}
                @else
                    {{ __('-') }}
                @endif

            </td>

            <td scope="row">
                @if ($producto->unidad)
                    {{ $producto->unidad->nombre }}
                @else
                    {{ __('-') }}
                @endif

            </td>

            <td>
                <div class="btn-group">
                    <div class="mr-1">
                        <a class="btn btn-secondary btn-sm" href="{{ route('productos.show', $producto->id) }}">
                            {{ __('VER') }}
                        </a>
                    </div>

                    <div>
                        <a class="btn btn-outline-info btn-sm" href="{{ route('productos.edit', $producto->id) }}">
                            {{ __('EDITAR') }}
                        </a>
                    </div>

                    <div>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bin-button btn anular anular-producto"
                                style="margin-left: 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 39 7"
                                    class="bin-top">

                                    <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5">
                                    </line>
                                    <line stroke-width="3" stroke="white" y2="1.5" x2="26.0357" y1="1.5"
                                        x1="12"></line>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 33 39"
                                    class="bin-bottom">
                                    <mask fill="white" id="path-1-inside-1_8_19">
                                        <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z">
                                        </path>
                                    </mask>
                                    <path mask="url(#path-1-inside-1_8_19)" fill="white"
                                        d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z">
                                    </path>
                                    <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                    <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 89 80"
                                    class="garbage">
                                    <path fill="white"
                                        d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div>
                        <a class="Btn-rotacion" href="{{route('product.dailyrotation', $producto->id)}}">
                            <div class="svgWrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 42 42"
                                    class="svgIcon">
                                    <path stroke-width="5" stroke="#fff"
                                        d="M9.14073 2.5H32.8593C33.3608 2.5 33.8291 2.75065 34.1073 3.16795L39.0801 10.6271C39.3539 11.0378 39.5 11.5203 39.5 12.0139V21V37C39.5 38.3807 38.3807 39.5 37 39.5H5C3.61929 39.5 2.5 38.3807 2.5 37V21V12.0139C2.5 11.5203 2.6461 11.0378 2.91987 10.6271L7.89266 3.16795C8.17086 2.75065 8.63921 2.5 9.14073 2.5Z">
                                    </path>
                                    <rect stroke-width="3" stroke="#fff" rx="2" height="4" width="11"
                                        y="18.5" x="15.5"></rect>
                                    <path stroke-width="5" stroke="#fff" d="M1 12L41 12"></path>
                                </svg>
                                <div class="text">Rotación</div>
                            </div>
                        </a>
                    </div>



                </div>



            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="text-center text-muted">
            {{ __('No hay datos disponibles') }}
        </td>
    </tr>
@endif
