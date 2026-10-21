<?php
//incio la sesion para acordarme de las lineas que ya dibuje
session_start();

// si todavia no hay lineas, creo una lista vacia para poder guardar las lineas en el 
//array
if (!isset($_SESSION['lineas'])) {
    $_SESSION['lineas'] = array();
}

$mensaje = "";

//este boton manda las coordenadas del formulario
if (isset($_POST['dibujar'])) {
    // paso lo que escribio el usuario a numeros enteros
    $x1 = (int)$_POST['x1'];
    $y1 = (int)$_POST['y1'];
    $x2 = (int)$_POST['x2'];
    $y2 = (int)$_POST['y2'];

    // reviso que las coordenadas queden adentro del dibujo
    if ($x1 >= 0 && $x1 <= 400 && $y1 >= 0 && $y1 <= 400 &&
        $x2 >= 0 && $x2 <= 400 && $y2 >= 0 && $y2 <= 400) {
        // guardo el tipo de linea y sus cuatro coordenadas
        $_SESSION['lineas'][] = array($tipoLinea, $x1, $y1, $x2, $y2);
    } else {
        $mensaje = "Usá números entre 0 y 400.";
    }
}

// este boton empieza el dibujo de nuevo
if (isset($_POST['borrar'])) {
    $_SESSION['lineas'] = array();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
</head>
<body>
    <h1><?php echo $titulo; ?></h1>

    <p>Elegí otro tipo de línea:</p>
    <a href="horizontales.php">Horizontal</a> |
    <a href="verticales.php">Vertical</a> |
    <a href="curva.php">Curva</a> |
    <a href="curvaderecha.php">Curva a la derecha</a>

    <h2>Ingresá las coordenadas</h2>
    <p>Usá números del 0 al 400.</p>
    <form method="POST">
        X inicial: <input type="number" name="x1" min="0" max="400" value="50" required>
        Y inicial: <input type="number" name="y1" min="0" max="400" value="50" required>
        <br><br>
        X final: <input type="number" name="x2" min="0" max="400" value="350" required>
        Y final: <input type="number" name="y2" min="0" max="400" value="350" required>
        <br><br>
        <input type="submit" name="dibujar" value="Dibujar línea">
        <input type="submit" name="borrar" value="Borrar todas">
    </form>

    <p><?php echo $mensaje; ?></p>
    <h2>Tu dibujo</h2>

    // este cuadro es el lugar donde aparecen las lineas 
    <svg width="402" height="402" style="border: 1px solid black;">
        <?php
        // vuelvo a dibujar todas las lineas guardadas
        foreach ($_SESSION['lineas'] as $linea) {
            if ($linea[0] == "horizontal") {
                // una linea horizontal mantiene la misma altura
                echo "<line x1='$linea[1]' y1='$linea[2]' x2='$linea[3]' y2='$linea[2]' stroke='blue' stroke-width='3' />";
            } elseif ($linea[0] == "vertical") {
                // una linea vertical mantiene el mismo ancho
                echo "<line x1='$linea[1]' y1='$linea[2]' x2='$linea[1]' y2='$linea[4]' stroke='blue' stroke-width='3' />";
            } elseif ($linea[0] == "curva") {
                // calculo un punto en el medio para doblar la linea
                $medioX = ($linea[1] + $linea[3]) / 2;
                $medioY = ($linea[2] + $linea[4]) / 2 - 50;
                echo "<path d='M $linea[1] $linea[2] Q $medioX $medioY $linea[3] $linea[4]' fill='none' stroke='blue' stroke-width='3' />";
            } else {
                // muevo el punto del medio para hacer una curva a la derecha
                $medioX = ($linea[1] + $linea[3]) / 2 + 50;
                $medioY = ($linea[2] + $linea[4]) / 2;
                echo "<path d='M $linea[1] $linea[2] Q $medioX $medioY $linea[3] $linea[4]' fill='none' stroke='blue' stroke-width='3' />";
            }
        }
        ?>
    </svg>
</body>
</html>
