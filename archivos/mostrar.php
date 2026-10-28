<?php
$archivo = fopen("datos.txt", "r") or die("No se pudo abrir el archivo de datos.");
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros guardados</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
<h2>Registros guardados</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Fecha y hora</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Edad</th>
        <th>DNI</th>
        <th>Teléfono</th>
    </tr>
    <?php
    $hayRegistros = false;
    while (($linea = fgets($archivo)) !== false) {
        $campos = explode("|", trim($linea));
        if (count($campos) == 7) {
            $hayRegistros = true;
            echo "<tr>";
            for ($i = 0; $i < count($campos); $i++) {
                echo "<td>" . htmlspecialchars($campos[$i]) . "</td>";
            }
            echo "</tr>";
        }
    }
    fclose($archivo);
    ?>
</table>
<?php
if (!$hayRegistros) {
    echo "<p>No hay registros guardados.</p>";
}
?>
<a class="boton-volver-menu" href="../index.html" target="_top">Volver al menú</a>
</body>
</html>