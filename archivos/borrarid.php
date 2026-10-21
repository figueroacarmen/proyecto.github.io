<?php
if (!isset($_POST['id_registro']) || trim($_POST['id_registro']) == "") {
    die("Ingrese el ID que desea borrar.");
}

$id = trim($_POST['id_registro']);
if (!is_numeric($id) || $id <= 0) {
    die("El ID no es válido.");
}

$lineas = file("datos.txt");
if ($lineas === false) {
    die("No se pudo leer el archivo de datos.");
}

$lineasNuevas = array();
$encontrado = false;
foreach ($lineas as $linea) {
    $campos = explode("|", trim($linea));
    if (count($campos) == 7 && $campos[0] == $id) {
        $encontrado = true;
    } else {
        $lineasNuevas[] = $linea;
    }
}

if (!$encontrado) {
    die("No se encontró el registro.");
}

$archivo = fopen("datos.txt", "w") or die("No se pudo abrir el archivo para guardar los cambios.");
foreach ($lineasNuevas as $linea) {
    if (fwrite($archivo, $linea) === false) {
        fclose($archivo);
        die("No se pudo guardar el archivo de datos.");
    }
}
fclose($archivo);

echo "Registro borrado correctamente.";
?>