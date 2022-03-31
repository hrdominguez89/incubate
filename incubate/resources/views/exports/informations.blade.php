<table style="width: 100%" width="100%">
    <thead>
    <tr>
        <th  width="60" style="width: 60px;"><strong>Título en Español</strong></th>
        <th  width="100" style="width: 100px;"><strong>Contenido en Español</strong></th>
        <th  width="60" style="width: 60px;"><strong>Título en Inglés</strong></th>
        <th  width="100" style="width: 100px;"><strong>Contenido en Inglés</strong></th>
        <th  width="40" style="width: 40px;"><strong>Nombre del botón</strong></th>
        <th  width="20" style="width: 20px;"><strong>Fecha de Registro</strong></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $rs)
        <tr>
             <td style="vertical-align: middle;">{{ $rs['title'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['content'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['title_en'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['content_en'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['boton_name'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['created_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>