<table style="width: 100%" width="100%">
    <thead>
    <tr>
        <th  width="60" style="width: 60px;"><strong>Título en Español</strong></th>
        <th  width="100" style="width: 100px;"><strong>Resumen en Español</strong></th>
        <th  width="60" style="width: 60px;"><strong>Título en Inglés</strong></th>
        <th  width="100" style="width: 100px;"><strong>Resumen en Inglés</strong></th>
        <th  width="40" style="width: 40px;"><strong>Categoría</strong></th>
        <th  width="40" style="width: 40px;"><strong>Mentor</strong></th>
        <th  width="40" style="width: 40px;"><strong>Sitio Web</strong></th>
        <th  width="40" style="width: 40px;"><strong>Linkedin</strong></th>
        <th  width="40" style="width: 40px;"><strong>Facebook</strong></th>
        <th  width="40" style="width: 40px;"><strong>Twitter</strong></th>
        <th  width="40" style="width: 40px;"><strong>Instagram</strong></th>
        <th  width="40" style="width: 40px;"><strong>Youtube</strong></th>
        <th  width="40" style="width: 40px;"><strong>Flickr</strong></th>
        <th  width="20" style="width: 20px;"><strong>Fecha de Registro</strong></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $rs)
        <tr>
            <td style="vertical-align: middle;">{{ $rs['title'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['resume'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['title_en'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['resume_en'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['category'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['mentor'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['website'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['linkedin'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['facebook'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['twitter'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['instagram'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['youtube'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['flickr'] }}</td>
            <td style="vertical-align: middle;">{{ $rs['created_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>