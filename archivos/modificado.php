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
include("funciones.php");

if (!isset($_POST['id'], $_POST['nombre'], $_POST['email'], $_POST['edad'], $_POST['dni'], $_POST['telefono'])) {
    die("Complete todos los campos del formulario.");
}

$id = trim($_POST['id']);
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$edad = trim($_POST['edad']);
$dni = trim($_POST['dni']);
$telefono = trim($_POST['telefono']);
$error = "";

if (!is_numeric($id) || $id <= 0) {
    $error .= "El ID no es válido.\n";
}
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

$lineas = file("datos.txt");
if ($lineas === false) {
    die("No se pudo leer el archivo de datos.");
}

$encontrado = false;
for ($i = 0; $i < count($lineas); $i++) {
    $campos = explode("|", trim($lineas[$i]));
    if (count($campos) == 7 && $campos[0] == $id) {
        $lineas[$i] = $id . "|" . $campos[1] . "|" . $nombre . "|" . $email . "|" . $edad . "|" . $dni . "|" . $telefono . "\n";
        $encontrado = true;
        break;
    }
}

if (!$encontrado) {
    die("No se encontró el registro.");
}

$archivo = fopen("datos.txt", "w") or die("No se pudo guardar el archivo de datos.");
foreach ($lineas as $linea) {
    if (fwrite($archivo, $linea) === false) {
        fclose($archivo);
        die("No se pudieron guardar los cambios.");
    }
}
fclose($archivo);

echo "Registro modificado correctamente.";
?>
    </p>
</main>
</body>
</html>