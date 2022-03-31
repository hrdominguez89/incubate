<table style="width: 100%" width="100%">
    <thead>
        <tr>
            <th  width="20" style="width: 20px;"><strong>Nombre y apellido</strong></th>
            <th  width="20" style="width: 20px;"><strong>CUIT</strong></th>
            <th  width="20" style="width: 20px;"><strong>Teléfono</strong></th>
            <th  width="40" style="width: 40px;"><strong>Correo electrónico</strong></th>
            <th  width="20" style="width: 20px;"><strong>Cargo</strong></th>
            <th  width="20" style="width: 20px;"><strong>Repartición</strong></th>
            <th  width="20" style="width: 20px;"><strong>Ministerio</strong></th>
            <th  width="20" style="width: 20px;"><strong>Nombre de asistente</strong></th>
            <th  width="20" style="width: 20px;"><strong>Teléfono de asistente</strong></th>
            <th  width="40" style="width: 40px;"><strong>Correo electrónico de asistente</strong></th>
            <th  width="20" style="width: 20px;"><strong>Nombre de jefe de gabinete</strong></th>
            <th  width="20" style="width: 20px;"><strong>Teléfono de jefe de gabinete</strong></th>
            <th  width="40" style="width: 40px;"><strong>Correo electrónico de jefe de gabinete</strong></th>
            <th  width="20" style="width: 20px;"><strong>Estatus</strong></th>
            <th  width="20" style="width: 20px;"><strong>Fecha de Registro</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $rs)
        <tr>
            <td style="vertical-align: middle;">{{ $rs['name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['cuit'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['phone'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['email'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['charge'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['distribution'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['ministerie'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['assistant_name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['assistant_phone'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['assistant_email'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['boss_name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['boss_email'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['boss_phone'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['status'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['created_at'] }}</td>

        </tr>
        @endforeach
    </tbody>
</table>