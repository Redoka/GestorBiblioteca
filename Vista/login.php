<?php
if (isset($_POST["numeroIDentificacionPersonal"])) {
    require_once __DIR__ . "/../Controlador/usuario-controller.php";


    if (isset($_POST["contrasena"])) {
        $b = setUsuario($_POST);

        if ($b) {
            echo "<script>alert('Se ha añadido el usuario');</script>";
        } else {
            echo "<script>alert('Error al añadir el usuario');</script>";
        }

        $_POST = [];
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Biblioteca</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .crear-usuario {
            text-align: center;
            margin-top: 15px;
        }

        .crear-usuario a {
            text-decoration: none;
            color: #007bff;
        }

        .crear-usuario a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Biblioteca</h2>

        <form action="/index.php" method="POST">

            <input
                type="text"
                name="usuario"
                placeholder="Usuario"
                required>

            <input
                type="text"
                name="password"
                placeholder="Contraseña"
                required>

            <button action="/index.php" method="POST">Iniciar sesión</button>

        </form>

        <div class="crear-usuario">
            <a href="/Vista/formularios/crear-usuario.php" class="link-texto">
                Crear usuario
            </a>
        </div>
    </div>

</body>

</html>