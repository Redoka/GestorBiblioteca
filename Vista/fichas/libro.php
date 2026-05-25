<?php
require_once __DIR__ . "/../../controlador/libro-controller.php";
require_once __DIR__ . "/../../modelo/usuario.php";

session_start();

$usuarioSesion = unserialize($_SESSION['usuario']);
$admin = $usuarioSesion->tipoUsuario == 1;

$id = $_GET['id'] ?? null;

if (!$id) {
  die("ID no proporcionado");
}

$libro = getLibrobyId(['id' => $id]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Ficha del libro</title>
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

          <?php if ($admin): ?>

            <form action="/vista/formularios/libro.php" method="POST">
              <input type="hidden" name="id" value="<?= $libro->id ?>">
              <input type="hidden" name="editar" value="true">
              <button type="submit" class="edit-button">✎</button>
            </form>

            <a class="delete-button"
              href="/intermedio/descatalogar.php?id=<?= $libro->id ?>">
              ×
            </a>

          <?php endif; ?>

        </div>

        <div class="title"><?= $libro->titulo ?></div>

        <div class="grid">

          <div class="campo">
            <div class="label">ID</div>
            <div class="valor"><?= $libro->id ?></div>
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
                : $libro->fechaDePublicacion ?>
            </div>
          </div>

          <div class="campo">
            <div class="label">Descripción</div>
            <div class="valor"><?= $libro->descripcion ?></div>
          </div>

        </div>

      </div>

    </main>

  </div>

</body>

</html>