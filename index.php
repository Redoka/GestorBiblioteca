<?php
if (!isset($_POST["usuario"])) {
  header("Location: /vista/login.php");
  exit;
}

require("controlador/usuario-controller.php");
$admin = false;
if (getLogin($_POST)) {
  require_once "modelo/usuario.php";
  session_start();
  $usuario = getUsuarioByLogin($_POST);
  $_SESSION['usuario'] = serialize($usuario);
  $admin = $usuario->tipoUsuario == 1;
} else {
  header("Location: /vista/login.php");
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

    <a href="vista/tablas/historial.php">Historial</a>
    <a href="vista/tablas/libros.php">Libros</a>
    <?php
    if ($admin) {
      echo "<a href='vista/tablas/descatalogado.php'>Descatalogados</a>";
      echo "<a href='vista/tablas/usuarios.php'>Usuarios</a>";
    }
    ?>
    <a href="vista/fichas/usuario.php">Mi usuario</a>
  </div>

</body>

</html>