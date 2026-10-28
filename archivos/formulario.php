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
include("funciones.php");

if (!isset($_POST['nombre'], $_POST['email'], $_POST['edad'], $_POST['dni'], $_POST['telefono'])) {
    die("Complete el formulario de registro.");
}

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$edad = trim($_POST['edad']);
$dni = trim($_POST['dni']);
$telefono = trim($_POST['telefono']);
$error = "";

$error = Validar_Nombre($nombre, $error);
$error = Validar_Correo($email, $error);
$error = Validar_DNI($dni, $error);
$error = Validar_Edad($edad, $error);
$error = Validar_Tel($telefono, $error);
$error = Validar_Separador($nombre, $error);
$error = Validar_Separador($email, $error);
$error = Validar_Separador($edad, $error);
$error = Validar_Separador($dni, $error);
$error = Validar_Separador($telefono, $error);

if ($error != "") {
    echo nl2br(htmlspecialchars($error));
    exit;
}

$fecha = date("Y-m-d H:i:s");
$id = contadorVisitas();
$archivo = fopen("datos.txt", "a") or die("No se pudo abrir el archivo de datos.");
$linea = $id . "|" . $fecha . "|" . $nombre . "|" . $email . "|" . $edad . "|" . $dni . "|" . $telefono . "\n";

if (fwrite($archivo, $linea) === false) {
    fclose($archivo);
    die("No se pudo guardar el registro.");
}
fclose($archivo);

echo "Registro guardado correctamente. ID: " . htmlspecialchars((string)$id);
?>
    </p>
</main>
</body>
</html>