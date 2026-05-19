<?php
if (isset($_POST["registrar"])) {
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
    <link rel="stylesheet" href="/estilo.css">
</head>

<body class="login-page">

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