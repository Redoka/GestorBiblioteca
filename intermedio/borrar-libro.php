<?php
require_once __DIR__ . "/../controlador/libro-controller.php";
$id = (int)$_GET['id'];

deleteLibro($id);

// rediriges con mensaje
 header("Location: /vista/tablas/libros.php");
exit;