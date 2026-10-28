<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la modificación</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
<main>
    <h1>Resultado de la modificación</h1>
    <p>
<?php
include("conexion.php");
include("funciones.php");

if (!isset($_POST['codigo'], $_POST['nombre'], $_POST['correo'], $_POST['edad'], $_POST['dni'], $_POST['contrasena'])) {
    die("Complete el formulario.");
}

if (!ctype_digit($_POST['codigo']) || $_POST['codigo'] <= 0) {
    die("Ingrese un código válido.");
}

$codigo = (int)$_POST['codigo'];
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

    if ($contrasena == "") {
        $consulta = "UPDATE alumnos SET nombre = '$nombre', correo = '$correo',
                     edad = $edad, dni = $dni WHERE codigo = $codigo";
    } else {
        $contrasena = mysqli_real_escape_string($conexion, password_hash($contrasena, PASSWORD_DEFAULT));
        $consulta = "UPDATE alumnos SET nombre = '$nombre', correo = '$correo',
                     edad = $edad, dni = $dni, `contraseña` = '$contrasena'
                     WHERE codigo = $codigo";
    }

    if (mysqli_query($conexion, $consulta)) {
        if (mysqli_affected_rows($conexion) > 0) {
            echo "Registro modificado correctamente.";
        } else {
            $verificar = mysqli_query($conexion, "SELECT codigo FROM alumnos WHERE codigo = $codigo");
            if ($verificar && mysqli_num_rows($verificar) > 0) {
                echo "El registro no tuvo cambios.";
            } else {
                echo "No se encontró el registro.";
            }
            if ($verificar) {
                mysqli_free_result($verificar);
            }
        }
    } else {
        echo "Error al modificar el registro: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>
    </p>
</main>
</body>
</html>
