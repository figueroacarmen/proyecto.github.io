<?php
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

function Validar_Edad($edad, $error)
{
    if (!ctype_digit((string)$edad) || $edad <= 0) {
        $error .= "Ingrese una edad válida.\n";
    }
    return $error;
}

function Validar_DNI($dni, $error)
{
    if (!ctype_digit((string)$dni) || $dni <= 0) {
        $error .= "Ingrese un DNI válido.\n";
    }
    return $error;
}
?>
