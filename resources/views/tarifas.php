<?php
function leer_json(string $ruta_json): array
{
    $contenido = file_get_contents($ruta_json);
    $datos = json_decode($contenido, true);
    if ($datos === null) {
        return [];
    }
    return $datos;
}

$ruta_json_tarifas = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "bbdd" . DIRECTORY_SEPARATOR . "tarifas.json";
$tarifas = leer_json($ruta_json_tarifas);
$tarifas_indice = [];

foreach ($tarifas as $indice => $tarifa) {
    $tarifas_indice[$indice] = $tarifa;
}

if (isset($_GET["tarifa"])) {
    $tarifa_int = intval($_GET["tarifa"]);
}

// function manejo_navegacion(int $tarifa_int, int $valor): int
// {
//     $tarifa_int = $tarifa_int + $valor;
//     return $tarifa_int;
// }
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
                <input type="hidden" name="tarifa" value="<?=$tarifa_int-1?>">
                <input type="submit" value="Anterior">
            </form>
            <form method="get">
                <input type="hidden" name="tarifa" value="<?=$tarifa_int+1?>">
                <input type="submit" value="Siguiente">
            </form>
        </div>
        <?php
        echo "<h3>Tarifa {$tarifa_int}</h3>";
        var_dump($tarifas_indice[$tarifa_int]);
        ?>
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</body>

</html>