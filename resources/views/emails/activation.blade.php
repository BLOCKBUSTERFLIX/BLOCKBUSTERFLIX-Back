<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <title>Activa tu cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1{
            text-align: center;
            color:#25acd8;
            font-size: 3rem;
        }
        hr{
            border: 0;
            height: 2px;
            background-color: #25acd8;
            width: 50%;
            margin: auto;
        }
        span {
            text-align:right;
            color:#814792;
            font-size: .5rem;
        }        
        .btn {
            padding: 0.3rem;
            color: white; 
            text-decoration: none; 
            display: block;
            width: 200px;
            height: 50px;
            margin: 20px auto;
            background-color: #25acd8;
            text-align: center;
            border-radius: 30px;
            line-height: 50px;
            font-size: 1.2rem;
        }
        .btn:hover {
            background-color: #16637c;
            color: #fff;
        }
        .team {
            text-align: right;
        }
        .pText{
            font-size:20px;
            font-weight:400;
            color:#303030;
            text-align: center;
        }
        .parrafo{
            font-size:18px;
            font-weight:400;
            color:#303030;
            text-align: center;
        }
    </style>
</head>
<body>
    <br><br><br><br>  
    <hr>
    <h1>Bienvenido, {{$name}}</h1>
    <div>
        <p class="parrafo">Para verificar su cuenta ingrese a:</p>
        <br>
        <a href="{{$url}}" class="btn">Activar cuenta</a>
        <span class="team">— 2FA</span>
    </div>
</body>
</html>
