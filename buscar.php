<?php
include("conexion.php");

if (!isset($_POST['codigo']) || !ctype_digit($_POST['codigo']) || $_POST['codigo'] <= 0) {
    die("Ingrese un código válido.");
}

$codigo = (int)$_POST['codigo'];
$consulta = "SELECT codigo, nombre, correo, edad, dni FROM alumnos WHERE codigo = $codigo";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error al buscar el registro: " . mysqli_error($conexion));
}

$encontrado = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar alumno</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <h2>Resultado de la búsqueda</h2>
    <table border="1">
        <tr>
            <td>Código</td>
            <td>Nombre</td>
            <td>Correo</td>
            <td>Edad</td>
            <td>DNI</td>
        </tr>
        <?php
        while ($fila = mysqli_fetch_array($resultado)) {
            $encontrado = 1;
            echo "<tr>";
            echo "<td>" . $fila['codigo'] . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['correo']) . "</td>";
            echo "<td>" . $fila['edad'] . "</td>";
            echo "<td>" . $fila['dni'] . "</td>";
            echo "</tr>";
        }

        if ($encontrado == 0) {
            echo "<tr><td colspan='5'>No se encontró el alumno.</td></tr>";
        }

        mysqli_free_result($resultado);
        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
