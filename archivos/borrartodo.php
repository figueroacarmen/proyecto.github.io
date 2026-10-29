<?php
if (isset($_POST['confirmar'])) {
    $archivo = fopen("datos.txt", "w") or die("No se pudo abrir el archivo de datos.");
    fclose($archivo);

    $archivo = fopen("contadorV.txt", "w") or die("No se pudo abrir el contador.");
    if (fwrite($archivo, "0") === false) {
        fclose($archivo);
        die("No se pudo reiniciar el contador.");
    }
    fclose($archivo);

    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros borrados</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <main>
        <h1>Todos los registros fueron borrados.</h1>
        <a class="boton-volver-menu" href="../index.html" target="_top">Volver al menú</a>
    </main>
</body>
</html>';
    exit;
}
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