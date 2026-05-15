<?php
if (isset($_POST["isbn"])) {

    require_once __DIR__ . "/../../Controlador/libro-controller.php";

    $b = true;
    for ($i = 0; $i < $_POST["cantidad"]; $i++) {
        $b = setLibros($_POST);
        if (!$b) {
            break;
        }
    }
    if ($b) {
        echo "<script>alert('Se ha añadido el libro');</script>";
    } else {
        echo "<script>alert('Error al añadir el libro');</script>";
    }

    $_POST = [];
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Libro</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 380px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>Crear Libro</h2>

        <form action="/Vista/formularios/crear-libro.php" method="POST">

            <input type="text" name="isbn" placeholder="ISBN" required>

            <input type="text" name="titulo" placeholder="Título" required>

            <input type="text" name="autor" placeholder="Autor" required>

            <input type="date" name="fechaDePublicacion" required>

            <input type="number" name="cantidad" min="1" value="1" required>

            <button type="submit">Guardar libro</button>

        </form>

        <a href="/Vista/tablas/tabla-libro.php">Volver</a>

    </div>

</body>

</html>