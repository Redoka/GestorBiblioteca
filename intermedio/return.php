<?php

require_once __DIR__ . "/../Controlador/historial-controller.php";

$id = (int) $_GET['id'];
devolver($id);

header("Location: /Vista/tablas/tabla-historial.php");
exit;