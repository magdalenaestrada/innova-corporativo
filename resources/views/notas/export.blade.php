<table>
    <thead>
        <tr>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Placa</th>
            <th>Kilometraje inicial</th>
            <th>Kilometraje final</th>
            <th>Km recorridos</th>
            <th>Producto</th>
            <th>Cantidad total</th>
            <th>Consumo por km</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
            <tr>
                <td>{{ $fila['fecha_inicio'] }}</td>
                <td>{{ $fila['fecha_fin'] }}</td>
                <td>{{ $fila['placa'] }}</td>
                <td>{{ $fila['km_inicial'] }}</td>
                <td>{{ $fila['km_final'] }}</td>
                <td>{{ $fila['km_recorridos'] }}</td>
                <td>{{ $fila['producto'] }}</td>
                <td>{{ $fila['cantidad_total'] }}</td>
                <td>{{ $fila['consumo_por_km'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
