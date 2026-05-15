<?php
require_once __DIR__ . "/../../Controlador/libro-controller.php";

$id = $_GET['id'] ?? null;

if (!$id) {
  die("ID no proporcionado");
}

$libro = getLibrobyId($_GET);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ficha del libro</title>

  <style>
    body {
      margin: 0;
      font-family: system-ui, Arial, sans-serif;
      background: #f6f7fb;
      color: #1f2937;
    }

    /* LAYOUT */
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
      transition: 0.2s;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.18);
    }

    /* CONTENIDO */
    .content {
      flex: 1;
      padding: 30px;
    }

    /* CARD */
    .card {
      background: white;
      max-width: 700px;
      margin: auto;
      padding: 25px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    /* TITULO */
    .title {
      margin-top: 10px;
      font-size: 26px;
    }

    /* GRID */
    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-top: 20px;
    }

    /* CAMPOS */
    .campo {
      padding: 10px;
      border-radius: 10px;
      background: #f9fafb;
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

    /* BADGE */
    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      background: #e0e7ff;
      color: #3730a3;
      font-size: 12px;
    }

    /* BACK */
    .back {
      display: inline-block;
      margin-bottom: 10px;
      text-decoration: none;
      color: #4f46e5;
    }

    .back:hover {
      text-decoration: underline;
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
      <a href="/Vista/tablas/tabla-usuario.php">Usuarios</a>
    </aside>

    <main class="content">

      <div class="card">

        <a class="back" href="javascript:history.back()">← Volver</a>

        <h1 class="title"><?= $libro->titulo ?></h1>

        <div class="grid">

          <div class="campo">
            <div class="label">ID</div>
            <div class="valor">
              <span class="badge"><?= $libro->id ?></span>
            </div>
          </div>

          <div class="campo">
            <div class="label">ISBN</div>
            <div class="valor"><?= $libro->isbn ?></div>
          </div>

          <div class="campo">
            <div class="label">Autor</div>
            <div class="valor"><?= $libro->autor ?></div>
          </div>

          <div class="campo">
            <div class="label">Fecha de publicación</div>
            <div class="valor">
              <?= $libro->fechaDePublicacion instanceof DateTime
                ? $libro->fechaDePublicacion->format('d-m-Y')
                : $libro->fechaDePublicacion
              ?>
            </div>
          </div>

        </div>

      </div>

    </main>

  </div>
</body>

</html>