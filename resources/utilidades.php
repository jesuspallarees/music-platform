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

function escribir_json_tarifa(string $ruta_json, Tarifa $tarifa): void
{
    $tarifas = leer_json($ruta_json);
    $tarifas[] = (array) $tarifa;
    file_put_contents($ruta_json, json_encode($tarifas, JSON_PRETTY_PRINT));
}

function calculo_precio_meses(string $tarifa, string $rebaja): array
{
    $tarifa_int = intval($tarifa);
    $rebaja_int = intval($rebaja);
    $precios = [];

    for ($i = 1; $i <= 24; $i++) {
        $rebaja_mes = ($rebaja_int / 24) * $i;
        $precio_actual = $tarifa_int * (1 - $rebaja_mes / 100);
        $precios[$i] = round($precio_actual, 2);
    }

    return $precios;
}