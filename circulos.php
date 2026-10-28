<?php
// inicio la sesion para guardar los dibujos mientras la pagina esta abierta
session_start();

// si todavia no hay dibujos, creo una lista vacia
if (!isset($_SESSION['circulos'])) {
    $_SESSION['circulos'] = array();
}

// este boton borra todos los dibujos guardados
if (isset($_POST['borrar'])) {
    $_SESSION['circulos'] = array();
}

// este boton manda los datos del formulario
if (isset($_POST['dibujar'])) {
    // paso los valores del formulario a numeros enteros
    $centroX = (int)$_POST['x'];
    $centroY = (int)$_POST['y'];
    $radio = (int)$_POST['radio'];
    $cantidad = (int)$_POST['cantidad'];
    $forma = $_POST['forma'];

    // reviso que los valores esten dentro de los limites
    if ($centroX >= 0 && $centroX <= 400 &&
        $centroY >= 0 && $centroY <= 400 &&
        $radio >= 5 && $radio <= 80 &&
        $cantidad >= 2 && $cantidad <= 50) {
        // guardo la forma, el centro, el radio y la cantidad
        $_SESSION['circulos'][] = array($forma, $centroX, $centroY, $radio, $cantidad);
    }
}

// preparo el cuadro donde voy a dibujar
header("Content-Type: image/svg+xml; charset=UTF-8");
echo "<svg xmlns='http://www.w3.org/2000/svg' width='402' height='402' style='border: 1px solid black;'>";

// vuelvo a dibujar todos los circulos que guarde en la sesion
foreach ($_SESSION['circulos'] as $circulo) {
    // saco los datos de este dibujo de la lista
    $forma = $circulo[0];
    $centroX = $circulo[1];
    $centroY = $circulo[2];
    $radio = $circulo[3];
    $cantidad = $circulo[4];

    if ($forma == "uno") {
        // dibujo un circulo usando el radio elegido
        echo "<circle cx='$centroX' cy='$centroY' r='$radio' fill='none' stroke='red' stroke-width='2' />";
    } elseif ($forma == "filas") {
        // repito los circulos en tres filas
        for ($fila = 0; $fila < 3; $fila++) {
            for ($i = 0; $i < $cantidad; $i++) {
                $x = 10 + ($i * 380 / $cantidad);
                $y = $centroY - $radio + ($fila * $radio);
                echo "<circle cx='$x' cy='$y' r='$radio' fill='none' stroke='red' stroke-width='2' />";
            }
        }
    } elseif ($forma == "equis") {
        // pongo puntos en dos diagonales para formar una X
        for ($i = 0; $i < $cantidad; $i++) {
            // calculo cuanto avance para repartir los puntos
            $paso = $i / ($cantidad - 1);
            $x = $centroX - $radio + ($paso * $radio * 2);
            $y = $centroY - $radio + ($paso * $radio * 2);
            echo "<circle cx='$x' cy='$y' r='5' fill='none' stroke='red' stroke-width='2' />";

            // calculo el punto de la otra diagonal
            $y = $centroY + $radio - ($paso * $radio * 2);
            echo "<circle cx='$x' cy='$y' r='5' fill='none' stroke='red' stroke-width='2' />";
        }
    } elseif ($forma == "concentricos") {
        // dibujo circulos con el mismo centro y radios diferentes
        for ($i = 1; $i <= $cantidad; $i++) {
            $radioNuevo = $radio * $i / $cantidad;
            echo "<circle cx='$centroX' cy='$centroY' r='$radioNuevo' fill='none' stroke='red' stroke-width='2' />";
        }
    } elseif ($forma == "tamanos") {
        // dibujo una fila de circulos que aumentan de tamaño
        for ($i = 0; $i < $cantidad; $i++) {
            $x = 10 + ($i * 380 / $cantidad);
            $radioNuevo = $radio * ($i + 1) / $cantidad;
            echo "<circle cx='$x' cy='$centroY' r='$radioNuevo' fill='none' stroke='red' stroke-width='2' />";
        }
    } elseif ($forma == "redondo") {
        // uso seno y coseno para ubicar puntos alrededor del centro
        for ($i = 0; $i < $cantidad; $i++) {
            // el angulo cambia para repartir los puntos en una vuelta
            $angulo = 2 * pi() * $i / $cantidad;
            $x = sin($angulo) * $radio + $centroX;
            $y = cos($angulo) * $radio + $centroY;
            echo "<circle cx='$x' cy='$y' r='5' fill='none' stroke='red' stroke-width='2' />";
        }
    } elseif ($forma == "flor") {
        // ubico circulos alrededor del centro para formar una flor
        for ($i = 0; $i < $cantidad; $i++) {
            $angulo = 2 * pi() * $i / $cantidad;
            $x = sin($angulo) * $radio / 2 + $centroX;
            $y = cos($angulo) * $radio / 2 + $centroY;
            echo "<circle cx='$x' cy='$y' r='$radio' fill='none' stroke='red' stroke-width='2' />";
        }
    }
}

// cierro el cuadro del dibujo
echo "</svg>";
?>
