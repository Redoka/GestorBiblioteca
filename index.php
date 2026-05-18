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
  <link rel="stylesheet" href="/estilo.css">
</head>

<body class="menu-page">

  <div class="menu">
    <h1>Menú principal</h1>

    <a href="Vista/tablas/tabla-historial.php">Historial</a>
    <a href="Vista/tablas/tabla-libro.php">Libros</a>
    <a href="Vista/fichas/ficha-usuario.php">Mi usuario</a>
    <?php
    if ($admin) {
      echo "<a href='Vista/tablas/tabla-usuario.php'>Usuarios</a>";
    }
    ?>
  </div>

</body>

</html>