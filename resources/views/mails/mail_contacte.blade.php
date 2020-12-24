<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Missatge de: {{$usuari->name}}</title>
</head>
<body>
    <ul>
        <li>Nom: {{$usuari->name}}</li>
        <li>Teléfono: {{$usuari->telefon}}</li>
        <li>Email: {{$usuari->email}}</li>
        <li>Missatge: {{$usuari->message}}</li>
    </ul>
</body>
</html>