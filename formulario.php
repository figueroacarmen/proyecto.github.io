<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del registro</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
<main>
    <h1>Resultado del registro</h1>
    <p>
<?php
include("conexion.php");
include("funciones.php");

if (!isset($_POST['nombre'], $_POST['correo'], $_POST['edad'], $_POST['dni'], $_POST['contrasena'])) {
    die("Complete el formulario.");
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$contrasena = $_POST['contrasena'];
$error = "";

$error = Validar_Nombre($nombre, $error);
$error = Validar_Correo($correo, $error);
$error = Validar_Edad($edad, $error);
$error = Validar_DNI($dni, $error);

if ($error != "") {
    echo nl2br($error);
} else {
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $correo = mysqli_real_escape_string($conexion, $correo);
    $edad = (int)$edad;
    $dni = (int)$dni;
    $contrasena = mysqli_real_escape_string($conexion, password_hash($contrasena, PASSWORD_DEFAULT));

    $consulta = "INSERT INTO alumnos (nombre, correo, edad, dni, `contraseña`)
                 VALUES ('$nombre', '$correo', $edad, $dni, '$contrasena')";

    if (mysqli_query($conexion, $consulta)) {
        echo "Alumno guardado correctamente. Código: " . mysqli_insert_id($conexion);
    } else {
        echo "Error al guardar el registro: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>
    </p>
</main>
</body>
</html>
