<?php

require_once __DIR__ . "/../controlador/historial-controller.php";

$id = (int) $_GET['id'];
devolver($id);

header("Location: /vista/tablas/historial.php");
exit;