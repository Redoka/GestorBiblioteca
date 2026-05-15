<?php
require_once __DIR__ . "/../../Modelo/usuario.php";
require_once __DIR__ . "/../../Controlador/usuario-controller.php";

$id = $_GET['id'] ?? null;
$usuario = new usuario();
session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;
if ($id) {
  $usuario = getUsuarioById($_GET);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ficha de usuario</title>

  <style>
    body {
      margin: 0;
      font-family: system-ui, Arial, sans-serif;
      background: #f6f7fb;
      color: #1f2937;
    }

    .layout {
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: 220px;
      background: #111827;
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .sidebar h1 {
      font-size: 18px;
      margin-bottom: 15px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.08);
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.18);
    }

    /* CONTENIDO */
    .content {
      flex: 1;
      padding: 30px;
    }

    .card {
      background: white;
      max-width: 700px;
      margin: auto;
      padding: 25px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .title {
      font-size: 26px;
      margin-bottom: 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .campo {
      background: #f9fafb;
      padding: 12px;
      border-radius: 10px;
    }

    .label {
      font-size: 12px;
      color: #6b7280;
      text-transform: uppercase;
    }

    .valor {
      margin-top: 5px;
      font-weight: 500;
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      background: #e0e7ff;
      color: #3730a3;
      font-size: 12px;
    }

    .back {
      display: inline-block;
      margin-bottom: 15px;
      text-decoration: none;
      color: #4f46e5;
    }

    .back:hover {
      text-decoration: underline;
    }

    .add-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 15px;
    }

    .delete-button {
      display: flex;
      justify-content: center;
      align-items: center;

      width: 45px;
      height: 45px;

      background: #ef4444;
      color: white;

      font-size: 24px;
      font-weight: bold;
      text-decoration: none;

      border-radius: 50%;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);

      transition: all 0.2s ease;
      user-select: none;
    }

    .delete-button:hover {
      background: #b91c1c;
      transform: scale(1.1);
    }

    .delete-button:active {
      transform: scale(0.95);
    }
  </style>

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