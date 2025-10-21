<main>
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

    if (count($tarifas) != 0) {
        foreach ($tarifas as $tarifa) {
        }
    }else{
        echo "<h3>No hay tarifas disponibles para mostrar</h3>";
    }
    ?>
</main>