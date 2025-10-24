<?php
$tarifas = leer_json($ruta_json_tarifas);
$tarifas_indice = [];
$hay_tarifas = true;
$raiz_tarifa = false;

if (count($tarifas) === 0) {
    $hay_tarifas = false;
} else {
    foreach ($tarifas as $indice => $tarifa) {
        $tarifas_indice[$indice + 1] = $tarifa;
    }

    if (isset($_GET["tarifa"])) {
        $tarifa_int = intval($_GET["tarifa"]);
        if ($tarifa_int < 1) {
            $tarifa_int = count($tarifas_indice);
        } else {
            $tarifa_int;
        }
        if ($tarifa_int > count($tarifas_indice)) {
            $tarifa_int = 1;
        } else {
            $tarifa_int;
        }
    } else {
        $raiz_tarifa = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
    <main>
        <div class="botonera">
            <form method="get">
                <input type="hidden" name="tarifa" value="<?php
                                                            if ($tarifa_int - 1 < 1) {
                                                                echo count($tarifas_indice);
                                                            } else {
                                                                echo $tarifa_int - 1;
                                                            }
                                                            ?>">
                <input type="submit" value="Anterior" <?php echo !$hay_tarifas ? 'disabled' : ''; ?>>

            </form>

            <form method="get">
                <input type="hidden" name="tarifa" value="<?php
                                                            if ($tarifa_int + 1 > count($tarifas_indice)) {
                                                                echo 1;
                                                            } else {
                                                                echo $tarifa_int + 1;
                                                            }
                                                            ?>">
                <input type="submit" value="Siguiente" <?php echo !$hay_tarifas ? 'disabled' : ''; ?>>
            </form>

        </div>
        <?php
        if (!$hay_tarifas && $raiz_tarifa || !$hay_tarifas && !$raiz_tarifa) {
            echo "<h2>No se ha encontrado ninguna tarifa</h2>";
        } else if ($hay_tarifas && $raiz_tarifa) {
            echo "<h2>Utilice la botonera para navegar entre tarifas</h2>";
        } else {
            echo "<h3>Tarifa {$tarifa_int}</h3>";
            mostrar_tarifa($tarifas_indice, $tarifa_int);
        }

        function mostrar_tarifa(array $tarifas_indice, int $indice_tarifa): void
        {
            $precio_meses = $tarifas_indice[$indice_tarifa]['precio_meses'];
            if ($tarifas_indice[$indice_tarifa]['imagen'] != "") {
                $ruta_imagen = "/imgs/usuario/{$tarifas_indice[$indice_tarifa]['imagen']}";
                echo "<img src='{$ruta_imagen}' alt='imagen-tarifa'><br/>";
            }
        ?>
            <div class='datos-usuario'>
                <?php
                echo "Nombre de usuario: " . $tarifas_indice[$indice_tarifa]["nombre_usuario"] . "<br/>";
                echo "Email de usuario: " . $tarifas_indice[$indice_tarifa]["email"] . "<br/>";
                ?>
            </div>
            <div class='datos-tarifa'>
                <?php
                echo "Código: " . $tarifas_indice[$indice_tarifa]["codigo"] . "<br/>";
                echo "Fecha de alta: " . $tarifas_indice[$indice_tarifa]["fecha_alta"] . "<br/>";
                echo "Fecha de baja: " . $tarifas_indice[$indice_tarifa]["fecha_baja"] . "<br/>";
                echo "Tarifa base: " . $tarifas_indice[$indice_tarifa]["tarifa"] . "€<br/>";
                echo "Máxima rebaja: " . $tarifas_indice[$indice_tarifa]["max_rebaja"] . "%<br/>";
                ?>
            </div>
        <?php
            echo "<h4>Precio por mes:</h4>";
            echo '<table>';
            echo '<tr>';
            foreach ($precio_meses as $indice => $precio_mes) {
                echo '<th>' . $indice . '</th>';
            }
            echo '</tr>';
            echo '<tr>';
            foreach ($precio_meses as $indice => $precio_mes) {
                echo '<td>' . $precio_mes . '</td>';
            }
            echo '</tr>';

            echo '</table>';
        }
        ?>
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</body>

</html>