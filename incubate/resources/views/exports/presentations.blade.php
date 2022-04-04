<table style="width: 100%" width="100%">
    <thead>
        <tr>
            <th  width="20" style="width: 20px;"><strong>Nombre</strong></th>
            <th  width="40" style="width: 40px;"><strong>Apellido</strong></th>
            <th  width="10" style="width: 10px;"><strong>DNI</strong></th>
            <th  width="40" style="width: 40px;"><strong>Correo electrónico</strong></th>
            <th  width="10" style="width: 10px;"><strong>Teléfono</strong></th>
            <th  width="10" style="width: 10px;"><strong>Tipo de Persona</strong></th>
            <th  width="10" style="width: 10px;"><strong>Nombre del Proyecto</strong></th>
            <th  width="10" style="width: 10px;"><strong>Descripción</strong></th>
            <th  width="30" style="width: 30px;"><strong>Categoría</strong></th>
            <th  width="10" style="width: 10px;"><strong>Sitio Web</strong></th>
            <th  width="10" style="width: 10px;"><strong>Cantidad de Miembros</strong></th>
            <th  width="30" style="width: 30px;"><strong>Dedicación de los miembros</strong></th>
            <th  width="20" style="width: 10px;"><strong>Estadío</strong></th>
            <th  width="30" style="width: 30px;"><strong>Interés</strong></th>
            <th  width="20" style="width: 20px;"><strong>Fecha de Registro</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $rs)
        <tr>
            <td style="vertical-align: middle;">{{ $rs['name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['last_name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['dni'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['email'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['phone'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['person'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['project_name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['description'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['category'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['website'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['members'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['dedicated'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['state'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['interest'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['created_at'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>