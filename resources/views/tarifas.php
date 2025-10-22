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

foreach($tarifas as $indice => $tarifa){
    $tarifas_indice[$indice] = $tarifa;
}

var_dump($tarifas_indice[1]);
?>

<!DOCTYPE html>
<html lang="es">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>
<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'aside.php' ?>
    <main>
        
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</body>
</html>