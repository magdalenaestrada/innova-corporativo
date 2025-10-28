<div class="modal fade text-left" id="ModalCreate"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR SOCIEDAD') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                            <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-sociedad" action="{{ route('lqsociedades.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form mb-1 col-md-4">
                            <input name="codigo" id="codigo" class=" form-control form-control-sm" placeholder="CÓDIGO DE LA SOCIEDAD..." required="" type="text">
                            <span class="-border"></span>
                        </div>   

                        <div class="form col-md-8">
                            <input name="nombre" id="nombre" class=" form-control form-control-sm" placeholder="INGRESE EL NOMBRE DE LA SOCIEDAD" required="" type="text">
                            <span class="-border"></span>
                        </div>  

                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ __('CLIENTES') }}
                                    </th>
                                    <th>
                                        <button class="btn-add" type="button" onclick="create_tr('table_body')" id="addMoreButton">
                                            <div class="add-sign">+</div>
                                            <div class="add-text">AÑADIR</div>
                                        </button>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="table_body">
                                <tr>
                                    <td>
                                        <select name="clientes[]" class="form-control form-control-sm buscador cart-product" style="width: 400px">
                                            <option value="">{{ __('-- SELECCIONE UNA OPCIÓN') }}</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}"
                                                    {{ in_array($cliente->id, old('clientes', [])) ? 'selected' : '' }}>
                                                    {{ strtoupper($cliente->nombre) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <button class="button-remove" type="button" onclick="remove_tr(this)">
                                            <svg viewBox="0 0 448 512" class="remove-icon">
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  

                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('GUARDAR') }}
                            </button>   
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{asset('js/interactive.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.buscador').select2({theme: "classic"});
    });
</script>

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'ERROR DE VALIDACIÓN',
            html: '@foreach($errors->all() as $error)<p>{{ strtoupper($error) }}</p>@endforeach',
        });
    </script>
@endif
@endpush
