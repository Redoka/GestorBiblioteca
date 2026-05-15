<?php

require_once __DIR__ . "/../Controlador/historial-controller.php";

$idLibro = (int) $_GET['id'];
$idUsuario = (int) $_GET['usuario'];; // o el de sesión

setHistorial($idLibro, $idUsuario);

header("Location: /Vista/tablas/tabla-libro.php");
exit;