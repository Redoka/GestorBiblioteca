<?php
require_once __DIR__ . "/../../modelo/usuario.php";
require_once __DIR__ . "/../../controlador/usuario-controller.php";

$id = $_GET['id'] ?? null;
$usuario = null;
session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;
if ($id) {
  $usuario = getUsuariobyId($_GET);
} else {
  $_GET['id'] = $usuario->id;
  $usuario = getUsuariobyId($_GET);
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

      <a href="/vista/tablas/historial.php">Historial</a>
      <a href="/vista/tablas/libros.php">Libros</a>
      <?php
      if ($admin) {
        echo "<a href='/vista/tablas/descatalogado.php'>Descatalogados</a>";
        echo "<a href='/vista/tablas/usuarios.php'>Usuarios</a>";
      }
      ?>
      <a href="/vista/fichas/usuario.php">Mi usuario</a>
    </aside>

    <main class="content">

      <div class="card">

        <div class="add-container">
          <form action='/vista/formularios/usuario.php' method='POST' style='display:flex;margin-right: 5px;'>
            <input type='hidden' name='id' value='<?php echo $usuario->id; ?>'>
            <input type='hidden' name='editar' value='true'>
            <button type='submit' class='edit-button'>✎</button>
          </form>



          <?php
          if ($admin) {
            echo "<a class=\"delete-button\" href=\"/intermedio/borrar-usuario.php?id=$usuario->id&usuario=1\">×</a>";
          } else {
            echo "<a class=\"delete-button\" href=\"/intermedio/borrar-usuario.php?id=$usuario->id&usuario=0\">×</a>";
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
            <div class="valor">
              <?= $usuario->contacto?->telefono ?? '' ?>
            </div>
          </div>

          <div class="campo">
            <div class="label">email</div>
            <div class="valor">
              <?= $usuario->contacto?->email ?? '' ?>
            </div>
          </div>

          <div class="campo">
            <div class="label">Dirección</div>
            <div class="valor">
              <?= $usuario->contacto?->domicilio ?? '' ?>
            </div>
          </div>

          <div class="campo">
            <div class="label">Fecha de Nacimiento</div>
            <div class="valor">
              <?= $usuario->fechaNacimiento instanceof DateTime
                ? $usuario->fechaNacimiento->format('d-m-Y')
                : $usuario->fechaNacimiento
              ?>
            </div>
          </div>

        </div>

      </div>

    </main>

  </div>

</body>

</html>