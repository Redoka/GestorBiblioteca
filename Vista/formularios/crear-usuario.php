<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f2f2f2;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .container{
            background:white;
            padding:25px;
            border-radius:10px;
            width:380px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        input, select{
            width:100%;
            padding:10px;
            margin-top:10px;
            border:1px solid #ccc;
            border-radius:5px;
            box-sizing:border-box;
        }

        button{
            width:100%;
            padding:10px;
            margin-top:20px;
            background:#28a745;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#218838;
        }

        .login-link{
            text-align:center;
            margin-top:15px;
        }

        .login-link a{
            color:#007bff;
            text-decoration:none;
        }

        .login-link a:hover{
            text-decoration:underline;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Registrar Usuario</h2>

    <form action="/Vista/login.php" method="POST">

        <input type="text" name="numeroIDentificacionPersonal" placeholder="Nº Identificación" required>

        <input type="text" name="nombre" placeholder="Nombre completo" required>

        <input type="text" name="telefono" placeholder="Teléfono o contacto" required>

        <input type="text" name="usuario" placeholder="Usuario" required>

        <input type="text" name="contrasena" placeholder="Contraseña" required>

        <button type="submit">Registrar</button>

    </form>

    <div class="login-link">
        <a href="/Vista/login.php">Ya tengo cuenta</a>
    </div>

</div>

</body>
</html>