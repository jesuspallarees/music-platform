<?php
declare(strict_types=1);

$peticion = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$lista_blanca = [
    '/' => 'home.php',
];

$estructura_carpetas = dirname(__DIR__) . '/views/';

if (array_key_exists($peticion, $lista_blanca)) {
    require $estructura_carpetas . $lista_blanca[$peticion];
} else {
    require $estructura_carpetas . '404.php';
}
