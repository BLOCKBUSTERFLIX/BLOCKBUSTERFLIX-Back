<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/app.css">
  <title>Activa tu cuenta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    :root {
      --color-primero: #24acdc;
      --color-segundo: #76c3e4;
      --color-tercero: #c3d3da;
      --color-cuarto: #7f7f7f;
      --color-quinto: #6c6c6c;
      --color-sexto: #5c5c5c;
    }
    .titulo{
      color: #24acdc;
    }
    .equipo{
      color: var(--color-sexto);
        }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="offset-3 col-6 text-center">
        <h1 class="titulo">Código generado, {{$name}}!</h1>
      </div>
      <div class="col-12 text-center">
        <p>{{$code}}</p></p>
      </div>
      <div class="offset-9 col-3 equipo">
        <p>— 2FA</p>
      </div>
    </div>
  </div>
</body>
</html>