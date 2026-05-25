<?php
require_once __DIR__ . "/../vontrolador/historial-controller.php";
$id = (int)$_GET['id'];

deleteRegistro($id);

// rediriges con mensaje
 header("Location: /vista/tablas/historial.php");
exit;