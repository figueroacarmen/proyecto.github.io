<?php
include("conexion.php");

if (isset($_POST['confirmar'])) {
    $consulta = "DELETE FROM alumnos";

    if (mysqli_query($conexion, $consulta)) {
        $mensaje = "Todos los registros fueron borrados.";
    } else {
        $mensaje = "Error al borrar los registros: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del borrado</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <main>
        <h1>' . htmlspecialchars($mensaje) . '</h1>
        <a class="boton-volver-menu" href="../index.html" target="_top">Volver al menú</a>
    </main>
</body>
</html>';
    exit;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar todos los registros</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <h2>¿Está seguro de borrar todos los registros?</h2>
    <form action="borrartodo.php" method="POST">
        <input type="submit" name="confirmar" value="Sí, borrar todos">
    </form>
    <a class="boton-volver-menu" href="../index.html" target="_top">Volver al menú</a>
</body>
</html>
