<?php
require_once __DIR__ . "/../controlador/descatalogado-controller.php";
$id = $_POST['id'];

deleteDescatalogado($id);

// rediriges con mensaje
 header("Location: /vista/tablas/descatalogado.php");
exit;