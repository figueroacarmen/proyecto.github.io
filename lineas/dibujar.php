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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../estilo.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 32px 16px;
            background: linear-gradient(135deg, #fff5fa, #fce4ef);
            color: #684357;
            font-family: Arial, sans-serif;
        }

        main {
            width: min(760px, 100%);
            margin: auto;
            padding: 30px;
            border: 2px solid #f4c5d9;
            border-radius: 24px;
            background: #fffafd;
            box-shadow: 0 12px 32px #d99bb833;
        }

        h1, h2 {
            color: #a64d78;
            text-align: center;
        }

        h1 {
            margin-top: 0;
        }

        .intro, .ayuda {
            text-align: center;
        }

        .navegacion {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 22px 0 30px;
        }

        .boton {
            display: inline-block;
            padding: 11px 16px;
            border: 2px solid #e9a9c5;
            border-radius: 999px;
            background: #fff0f7;
            color: #85415f;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .boton:hover {
            transform: translateY(-2px);
            background: #fbd8e8;
        }

        .boton-inicio {
            border-color: #d783a8;
            background: #f7c9dc;
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            max-width: 520px;
            margin: 0 auto;
        }

        label {
            display: grid;
            gap: 7px;
            color: #754d63;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #e9b7cc;
            border-radius: 10px;
            background: white;
            color: #684357;
            font: inherit;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            grid-column: 1 / -1;
            margin-top: 6px;
        }

        .mensaje {
            color: #a33f68;
            text-align: center;
        }

        .lienzo {
            display: block;
            width: min(402px, 100%);
            height: auto;
            margin: 0 auto;
            border: 2px solid #edb5cc;
            border-radius: 14px;
            background-color: #fff;
            background-image: linear-gradient(#f9eaf1 1px, transparent 1px),
                              linear-gradient(90deg, #f9eaf1 1px, transparent 1px);
            background-size: 20px 20px;
        }

        @media (max-width: 480px) {
            main {
                padding: 22px 16px;
            }

            form {
                grid-template-columns: 1fr;
            }

            .acciones {
                grid-column: auto;
            }
        }
    </style>
</head>
<body>
    <main>
        <h1><?php echo $titulo; ?></h1>
        <p class="intro">¡Vamos a crear un dibujito bonito!</p>

        <nav class="navegacion" aria-label="Navegación de líneas">
            <a class="boton boton-inicio" href="../index.html">Volver al menú</a>
            <a class="boton" href="horizontales.php">Horizontal</a>
            <a class="boton" href="verticales.php">Vertical</a>
            <a class="boton" href="curva.php">Curva</a>
            <a class="boton" href="curvaderecha.php">Curva a la derecha</a>
        </nav>

        <section aria-labelledby="coordenadas-titulo">
            <h2 id="coordenadas-titulo">Ingresá las coordenadas</h2>
            <p class="ayuda">Usá números del 0 al 400.</p>
            <form method="POST">
                <label>X inicial
                    <input type="number" name="x1" min="0" max="400" value="50" required>
                </label>
                <label>Y inicial
                    <input type="number" name="y1" min="0" max="400" value="50" required>
                </label>
                <label>X final
                    <input type="number" name="x2" min="0" max="400" value="350" required>
                </label>
                <label>Y final
                    <input type="number" name="y2" min="0" max="400" value="350" required>
                </label>
                <div class="acciones">
                    <button class="boton" type="submit" name="dibujar">Dibujar línea</button>
                    <button class="boton" type="submit" name="borrar">Borrar todas</button>
                </div>
            </form>
        </section>

        <?php if ($mensaje !== ""): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <section aria-labelledby="dibujo-titulo">
            <h2 id="dibujo-titulo">Tu dibujo</h2>
            <svg class="lienzo" viewBox="0 0 402 402" role="img" aria-label="Dibujo de líneas">
                <?php
                foreach ($_SESSION['lineas'] as $linea) {
                    if ($linea[0] == "horizontal") {
                        echo "<line x1='$linea[1]' y1='$linea[2]' x2='$linea[3]' y2='$linea[2]' stroke='#d96b9a' stroke-width='4' stroke-linecap='round' />";
                    } elseif ($linea[0] == "vertical") {
                        echo "<line x1='$linea[1]' y1='$linea[2]' x2='$linea[1]' y2='$linea[4]' stroke='#d96b9a' stroke-width='4' stroke-linecap='round' />";
                    } elseif ($linea[0] == "curva") {
                        $medioX = ($linea[1] + $linea[3]) / 2;
                        $medioY = ($linea[2] + $linea[4]) / 2 - 50;
                        echo "<path d='M $linea[1] $linea[2] Q $medioX $medioY $linea[3] $linea[4]' fill='none' stroke='#d96b9a' stroke-width='4' stroke-linecap='round' />";
                    } else {
                        $medioX = ($linea[1] + $linea[3]) / 2 + 50;
                        $medioY = ($linea[2] + $linea[4]) / 2;
                        echo "<path d='M $linea[1] $linea[2] Q $medioX $medioY $linea[3] $linea[4]' fill='none' stroke='#d96b9a' stroke-width='4' stroke-linecap='round' />";
                    }
                }
                ?>
            </svg>
        </section>
    </main>
</body>
</html>
