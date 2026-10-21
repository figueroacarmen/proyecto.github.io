<?php
include("conexion.php");

if (isset($_POST['confirmar'])) {
    $consulta = "DELETE FROM alumnos";

    if (mysqli_query($conexion, $consulta)) {
        echo "Todos los registros fueron borrados.";
    } else {
        echo "Error al borrar los registros: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
    exit;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar todos los registros</title>
</head>
<body>
    <h2>¿Está seguro de borrar todos los registros?</h2>
    <form action="borrartodo.php" method="POST">
        <input type="submit" name="confirmar" value="Sí, borrar todos">
    </form>
</body>
</html>
