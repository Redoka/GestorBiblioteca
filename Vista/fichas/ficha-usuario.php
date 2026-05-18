<?php
require_once __DIR__ . "/../../Modelo/usuario.php";
require_once __DIR__ . "/../../Controlador/usuario-controller.php";

$id = $_GET['id'] ?? null;
$usuario = new usuario();
session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;
if ($id) {
  $usuario = updateUsuario($_GET);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ficha de usuario</title>
  <link rel="stylesheet" href="/estilo.css">

</head>

<body>

  <div class="layout">

    <aside class="sidebar">
      <h1>Menú</h1>

      <a href="/Vista/tablas/tabla-historial.php">Historial</a>
      <a href="/Vista/tablas/tabla-libro.php">Libros</a>
      <a href="/Vista/fichas/ficha-usuario.php">Mi usuario</a>
      <?php if ($admin) {
        echo "<a href=\"/Vista/tablas/tabla-usuario.php\">Usuarios</a>";
      } ?>
    </aside>

    <main class="content">

      <div class="card">

        <a class="back" href="javascript:history.back()">← Volver</a>

        <div class="add-container">
          <form action='/Vista/formularios/crear-usuario.php' method='POST' style='display:flex;margin-right: 5px;'>
            <input type='hidden' name='id' value='{$usuario->id}'>
            <input type='hidden' name='editar' value='true'>
            <button type='submit' class='edit-button'>✎</button>
          </form>

                    

          <?php
          if ($admin) {
            echo "<a class=\"delete-button\" href=\"/intermedio/deleted-user.php?id=$usuario->id&usuario=1\">×</a>";
          } else {
            echo "<a class=\"delete-button\" href=\"/intermedio/deleted-user.php?id=$usuario->id&usuario=0\">×</a>";
          }



          ?>
        </div>

        <div class="title">Ficha de usuario</div>

        <div class="grid">

          <div class="campo">
            <div class="label">ID Personal</div>
            <?php echo "<div class=\"valor\"> $usuario->id </div>" ?>
          </div>

          <div class="campo">
            <div class="label">Nombre</div>
            <?php echo "<div class=\"valor\"> $usuario->nombre </div>" ?>
          </div>

          <div class="campo">
            <div class="label">Usuario</div>
            <?php echo "<div class=\"valor\"> $usuario->usuario </div>" ?>
          </div>

          <div class="campo">
            <div class="label">Contraseña</div>
            <?php echo "<div class=\"valor\"> $usuario->contraseña </div>" ?>
          </div>

          <div class="campo">
            <div class="label">Telefono</div>
            <?php echo "<div class=\"valor\"> $usuario->telefono </div>" ?>
          </div>

        </div>

      </div>

    </main>

  </div>

</body>

</html>