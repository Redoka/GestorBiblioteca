<?php
require_once __DIR__ . "/../Controlador/descatalogado-controller.php";
$id = (int)$_GET['id'];

deleteDescatalogado($id);

// rediriges con mensaje
 header("Location: /Vista/tablas/descatalogado.php");
exit;