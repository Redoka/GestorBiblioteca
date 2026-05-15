<?php
if (!isset($_POST["usuario"])) {
  header("Location: /Vista/login.php");
  exit;
}

require("Controlador/usuario-controller.php");
$admin = false;
if (getLogin($_POST)) {
  require_once "Modelo/usuario.php";
  session_start();
  $usuario = getUsuarioByLogin($_POST);
  $_SESSION['usuario'] = serialize($usuario);
  $admin = $usuario->tipoUsuario == 1;
} else {
  header("Location: /Vista/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Menú principal</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f6f7fb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .menu {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }

    h1 {
      font-size: 20px;
      margin-bottom: 20px;
    }

    .menu a {
      display: block;
      padding: 12px;
      margin: 10px 0;
      text-decoration: none;
      background: #4f46e5;
      color: white;
      border-radius: 8px;
      transition: 0.2s;
    }

    .menu a:hover {
      background: #3730a3;
      transform: translateY(-2px);
    }
  </style>

</head>

<body>

  <div class="menu">

    <h1> Menú principal</h1>

    <a href="Vista/tablas/tabla-historial.php">Historial</a>
    <a href="Vista/tablas/tabla-libro.php">Libros</a>
    <a href="Vista/fichas/ficha-usuario.php">Mi usuario</a>
    <?php if ($admin) {
      echo "<a href=\"/Vista/tablas/tabla-usuario.php\">Usuarios</a>";
    } ?>

  </div>

</body>

</html>