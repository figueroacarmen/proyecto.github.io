<?php
function contadorVisitas()
{
    $archivo = fopen("contadorV.txt", "r") or die("No se pudo abrir el contador.");
    $id = fgets($archivo);
    fclose($archivo);

    $id = (int)$id + 1;

    $archivo = fopen("contadorV.txt", "w") or die("No se pudo guardar el contador.");
    if (fwrite($archivo, $id) === false) {
        fclose($archivo);
        die("No se pudo guardar el contador.");
    }
    fclose($archivo);

    return $id;
}

function Validar_Nombre($nombre, $error)
{
    if (trim($nombre) == "") {
        $error .= "Ingrese un nombre.\n";
    }
    return $error;
}

function Validar_Correo($email, $error)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "Ingrese un correo válido.\n";
    }
    return $error;
}

function Validar_DNI($dni, $error)
{
    if (!is_numeric($dni) || $dni <= 0) {
        $error .= "Ingrese un DNI válido.\n";
    }
    return $error;
}

function Validar_Edad($edad, $error)
{
    if (!is_numeric($edad) || $edad <= 0) {
        $error .= "Ingrese una edad válida.\n";
    }
    return $error;
}

function Validar_Tel($telefono, $error)
{
    if (!is_numeric($telefono) || $telefono <= 0) {
        $error .= "Ingrese un teléfono válido.\n";
    }
    return $error;
}

function Validar_Separador($valor, $error)
{
    if (strpos($valor, "|") !== false) {
        $error .= "No use el carácter | en los campos.\n";
    }
    return $error;
}
?>
