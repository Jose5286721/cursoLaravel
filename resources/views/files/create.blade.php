<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('files.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="archivos">Archivo</label><br>
        <input type="file" id="archivos" name="archivo" /><br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>