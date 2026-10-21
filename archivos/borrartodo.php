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

    echo "Todos los registros fueron borrados.";
    exit;
}
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