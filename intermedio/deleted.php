<?php
require_once __DIR__ . "/../Controlador/libro-controller.php";
$id = (int)$_GET['id'];

deleteLibro($id);

// rediriges con mensaje
 header("Location: /Vista/tablas/tabla-libro.php");
exit;