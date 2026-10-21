<?php
include("conexion.php");

if (!isset($_POST['codigo']) || !ctype_digit($_POST['codigo']) || $_POST['codigo'] <= 0) {
    die("Ingrese un código válido.");
}

$codigo = (int)$_POST['codigo'];
$consulta = "SELECT * FROM alumnos WHERE codigo = $codigo";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error al buscar el registro: " . mysqli_error($conexion));
}

$fila = mysqli_fetch_array($resultado);
mysqli_free_result($resultado);
mysqli_close($conexion);

if (!$fila) {
    die("No se encontró el registro.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar registro</title>
</head>
<body>
    <h2>Modificar registro</h2>
    <form action="modificado.php" method="POST">
        Código: <input type="text" name="codigo" value="<?php echo $fila['codigo']; ?>" readonly>
        <br><br>
        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" required>
        <br><br>
        Correo: <input type="email" name="correo" value="<?php echo htmlspecialchars($fila['correo']); ?>" required>
        <br><br>
        Edad: <input type="number" name="edad" value="<?php echo $fila['edad']; ?>" required>
        <br><br>
        DNI: <input type="number" name="dni" value="<?php echo $fila['dni']; ?>" required>
        <br><br>
        Nueva contraseña: <input type="password" name="contrasena">
        <br>
        Deje vacío el campo para conservar la contraseña actual.
        <br><br>
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>
