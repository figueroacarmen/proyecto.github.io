<?php
include("conexion.php");
$consulta = "SELECT codigo, nombre, correo, edad, dni FROM alumnos";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error al mostrar los registros: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos guardados</title>
</head>
<body>
    <h2>Alumnos guardados</h2>
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
            echo "<tr>";
            echo "<td>" . $fila['codigo'] . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['correo']) . "</td>";
            echo "<td>" . $fila['edad'] . "</td>";
            echo "<td>" . $fila['dni'] . "</td>";
            echo "</tr>";
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
