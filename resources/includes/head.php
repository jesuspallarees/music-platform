<?php
if (preg_match('/^\/alta/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Alta de tarifas";
} else if (preg_match('/^\/tarifas.*$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Tarifas";
} else if (preg_match('/^\/generador/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Generador de tarifas";
} else if (preg_match('/^\/.*$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Home";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nombre_pagina . $preparado_cabecera ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>