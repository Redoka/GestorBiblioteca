<?php
require_once __DIR__ . "/../Controlador/historial-controller.php";
$id = (int)$_GET['id'];

deleteRegistro($id);

// rediriges con mensaje
 header("Location: /Vista/tablas/tabla-historial.php");
exit;