<?php

require_once __DIR__ . "/../controlador/historial-controller.php";

$idLibro = (int) $_GET['id'];
$idUsuario = (int) $_GET['usuario'];; // o el de sesión

setHistorial($idLibro, $idUsuario);

header("Location: /vista/tablas/libros.php");
exit;