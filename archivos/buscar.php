<?php
if (!isset($_POST['id']) || trim($_POST['id']) == "") {
    die("Ingrese el ID que desea buscar.");
}

$id = trim($_POST['id']);
$encontrado = false;
$archivo = fopen("datos.txt", "r") or die("No se pudo abrir el archivo de datos.");
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar registro</title>
</head>
<body>
<h2>Resultado de la búsqueda</h2>
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
    while (($linea = fgets($archivo)) !== false) {
        $campos = explode("|", trim($linea));
        if (count($campos) == 7 && $campos[0] == $id) {
            $encontrado = true;
            echo "<tr>";
            for ($i = 0; $i < count($campos); $i++) {
                echo "<td>" . htmlspecialchars($campos[$i]) . "</td>";
            }
            echo "</tr>";
            break;
        }
    }
    fclose($archivo);
    ?>
</table>
<?php
if (!$encontrado) {
    echo "<p>No se encontró el registro.</p>";
}
?>
</body>
</html>