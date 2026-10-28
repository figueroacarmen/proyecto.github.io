<?php
if (!isset($_POST['id']) || trim($_POST['id']) == "") {
    die("Ingrese el ID que desea modificar.");
}

$id = trim($_POST['id']);
$encontrado = false;
$archivo = fopen("datos.txt", "r") or die("No se pudo abrir el archivo de datos.");

while (($linea = fgets($archivo)) !== false) {
    $campos = explode("|", trim($linea));
    if (count($campos) == 7 && $campos[0] == $id) {
        $encontrado = true;
        break;
    }
}
fclose($archivo);

if (!$encontrado) {
    die("No se encontró el registro.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar registro</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <h2>Modificar registro</h2>
    <p>Fecha: <?php echo htmlspecialchars($campos[1]); ?></p>
    <form action="modificado.php" method="POST">
        ID: <input type="text" name="id" value="<?php echo htmlspecialchars($campos[0]); ?>" readonly>
        <br><br>
        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($campos[2]); ?>" required>
        <br><br>
        Correo: <input type="email" name="email" value="<?php echo htmlspecialchars($campos[3]); ?>" required>
        <br><br>
        Edad: <input type="number" name="edad" value="<?php echo htmlspecialchars($campos[4]); ?>" required>
        <br><br>
        DNI: <input type="number" name="dni" value="<?php echo htmlspecialchars($campos[5]); ?>" required>
        <br><br>
        Teléfono: <input type="number" name="telefono" value="<?php echo htmlspecialchars($campos[6]); ?>" required>
        <br><br>
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>