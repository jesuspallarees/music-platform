<?php
$ruta_json_tarifas = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "bbdd" . DIRECTORY_SEPARATOR . "tarifas.json";
$tarifas = leer_json($ruta_json_tarifas);
$tarifas_indice = [];

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
}

function leer_json(string $ruta_json): array
{
    $contenido = file_get_contents($ruta_json);
    $datos = json_decode($contenido, true);
    if ($datos === null) {
        return [];
    }
    return $datos;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'aside.php' ?>
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
                <input type="submit" value="Anterior">
            </form>

            <form method="get">
                <input type="hidden" name="tarifa" value="<?php
                                                            if ($tarifa_int + 1 > count($tarifas_indice)) {
                                                                echo 1;
                                                            } else {
                                                                echo $tarifa_int + 1;
                                                            }
                                                            ?>">
                <input type="submit" value="Siguiente">
            </form>

        </div>
        <?php

        echo "<h3>Tarifa {$tarifa_int}</h3>";
        mostrar_tarifa($tarifas_indice, $tarifa_int);

        function mostrar_tarifa(array $tarifas_indice, int $indice_tarifa): void
        {
            $precio_meses = $tarifas_indice[$indice_tarifa]['precio_meses'];
            $ruta_imagen = "/imgs/usuario/{$tarifas_indice[$indice_tarifa]['imagen']}";
            echo "<div class='datos-usuario'>";
            
            echo "<img src='{$ruta_imagen}' alt='imagen-tarifa'>";
            echo "Nombre de usuario: " . $tarifas_indice[$indice_tarifa]["nombre_usuario"] . "<br/>";
            echo "Email de usuario: " . $tarifas_indice[$indice_tarifa]["email"] . "<br/>";
            echo "Código: " . $tarifas_indice[$indice_tarifa]["codigo"] . "<br/>";
            echo "Fecha de alta: " . $tarifas_indice[$indice_tarifa]["fecha_alta"] . "<br/>";
            echo "Fecha de baja: " . $tarifas_indice[$indice_tarifa]["fecha_baja"] . "<br/>";
            echo "Tarifa base: " . $tarifas_indice[$indice_tarifa]["tarifa"] . "<br/>";
            echo "Máxima rebaja: " . $tarifas_indice[$indice_tarifa]["max_rebaja"] . "<br/>";
            
            echo "<h4>Precio por mes:</h4>";
            echo '<table style="border: 2px solid black; border-collapse: collapse;">';
            foreach ($precio_meses as $indice => $precio_mes) {
                echo '<tr style="background-color: #f2f2f2;">';  
                echo '<td style="border: 1px solid black; padding: 5px;">' . $indice . '</td>'; 
                echo '<td style="border: 1px solid black; padding: 5px;">' . $precio_mes . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</body>

</html>