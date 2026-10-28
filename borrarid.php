<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del borrado</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
<main>
    <h1>Resultado del borrado</h1>
    <p>
<?php
include("conexion.php");

if (!isset($_POST['codigo']) || !ctype_digit($_POST['codigo']) || $_POST['codigo'] <= 0) {
    die("Ingrese un código válido.");
}

$codigo = (int)$_POST['codigo'];
$consulta = "DELETE FROM alumnos WHERE codigo = $codigo";

if (mysqli_query($conexion, $consulta)) {
    if (mysqli_affected_rows($conexion) > 0) {
        echo "Registro borrado correctamente.";
    } else {
        echo "No se encontró el registro.";
    }
} else {
    echo "Error al borrar el registro: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
    </p>
</main>
</body>
</html>
