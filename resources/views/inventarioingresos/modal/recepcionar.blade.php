<div class="modal fade text-left" id="ModalRecepcionar{{ $inventarioingreso->id }}" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="card-header">
        <div class="row justify-content-between">
          <div class="col-md-6">
            <h6 class="mt-2">{{ __('RECEPCIONAR ORDEN DE COMPRA') }}</h6>
          </div>
          <div class="col-md-6 text-right">
            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
              <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
            </button>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{{ route('inventarioingresos.updaterecepcionar', $inventarioingreso->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="form-group col-md-3 g-3">
              <label class="text-sm">{{ __('FECHA DE CREACIÓN') }}</label>
              <input class="form-control form-control-sm" value="{{ $inventarioingreso->created_at }}" readonly>
            </div>
            <div class="form-group col-md-3 g-3">
              <label class="text-sm">{{ __('ESTADO DE LA ORDEN') }}</label>
              <input class="form-control form-control-sm" value="{{ $inventarioingreso->estado }}" readonly>
            </div>
            <div class="form-group col-md-3 g-3">
              <label class="text-sm">{{ __('CREADOR DE LA ORDEN') }}</label>
              <input class="form-control form-control-sm" value="{{ $inventarioingreso->usuario_ordencompra }}" readonly>
            </div>
            <div class="form-group col-md-3 g-3">
              <label class="text-sm">{{ __('ORDEN PAGADA POR') }}</label>
              <input class="form-control form-control-sm" value="{{ $inventarioingreso->usuario_cancelacion }}" readonly>
            </div>

            <div class="form-group col-md-12 g-3">
              <label class="text-sm">{{ __('DESCRIPCIÓN') }}</label>
              <textarea class="form-control form-control-sm" readonly>{{ $inventarioingreso->descripcion ?: 'No hay observación' }}</textarea>
            </div>

            @if ($inventarioingreso->productos->count() > 0)
              <table class="table table-responsive table-striped table-hover">
                <thead>
                  <tr class="text-center">
                    <th>{{ __('SELECCIONAR') }}</th>
                    <th>{{ __('INGRESAR CANTIDAD RECIBIDA') }}</th>
                    <th>{{ __('PRODUCTO DEL REQUERIMIENTO') }}</th>
                    <th>{{ __('CANTIDAD') }}</th>
                    <th>{{ __('CANTIDAD RECIBIDA') }}</th>
                    <th>{{ __('CANTIDAD POR RECIBIR') }}</th>
                    <th>{{ __('FECHA DE CREACIÓN') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($inventarioingreso->productos as $producto)
                    @php
                      $pivotId     = $producto->pivot->id;
                      $por_recibir = $producto->pivot->cantidad - $producto->pivot->cantidad_ingresada;
                    @endphp
                    <tr class="text-center">
                      <td>
                        @if($por_recibir > 0)
                          <input
                            type="checkbox"
                            class="product-checkbox"
                            name="selected_products[]"
                            value="{{ $pivotId }}"
                            data-target="#qty-{{ $pivotId }}"
                          >
                        @else
                          COMPLETO
                        @endif
                      </td>

                      <td>
                        <div class="input-fields" id="wrap-{{ $pivotId }}" style="display:none;">
                          <input
                            id="qty-{{ $pivotId }}"
                            type="number"
                            class="form-control form-control-sm additional-info"
                            name="qty_arrived[{{ $pivotId }}]"
                            min="1"
                            max="{{ $por_recibir }}"
                            placeholder="0"
                          >
                          <small class="text-muted">Máx: {{ $por_recibir }}</small>
                        </div>
                      </td>

                      <td class="text-left">{{ $producto->nombre_producto }}</td>
                      <td>{{ $producto->pivot->cantidad }}</td>
                      <td>{{ $producto->pivot->cantidad_ingresada }}</td>
                      <td>{{ $por_recibir }}</td>
                      <td>{{ $producto->pivot->created_at }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif

            <div class="form-group col-md-4 g-3 text-sm">
              <label for="guiaingresoalmacen">{{ __('GUIA DE INGRESO AL ALMACEN') }}</label>
             
              <input class="form-control form-control-sm"  type="text" name="guiaingresoalmacen">
            </div>

            <div class="col-md-12 text-right g-3">
              <button type="submit" class="btn btn-sm btn-warning">
                {{ __('CONFIRMAR INGRESO DE LOS PRODUCTOS AL ALMACEN') }}
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.product-checkbox').forEach(function(chk) {
    chk.addEventListener('change', function() {
      const input = document.querySelector(this.dataset.target);
      const id    = this.dataset.target.replace('#qty-', '');
      const wrap  = document.querySelector('#wrap-' + id);

      if (this.checked) {
        wrap.style.display = 'block';
        input.required = true;
        input.focus();
      } else {
        wrap.style.display = 'none';
        input.required = false;
        input.value = '';
      }
    });
  });
});
</script>
