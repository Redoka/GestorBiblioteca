<?php
require_once __DIR__ . "/../Controlador/usuario-controller.php";
$id = (int)$_GET['id'];
$tipo = $_GET['usuario'];

deleteUsuario($id);

if ($tipo == 0) {
    // rediriges con mensaje
    header("Location: /Vista/login.php");
    exit;
}
header("Location: /Vista/tablas/usuario.php");
exit;
