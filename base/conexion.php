<?php
$conexion = mysqli_connect("localhost", "root", "", "escuelita");

if (!$conexion) {
    die("No se pudo conectar con la base de datos: " . mysqli_connect_error());
}

if (!mysqli_set_charset($conexion, "utf8")) {
    die("No se pudo configurar la conexión.");
}
?>
