<?php
if($_SERVER["REQUEST_URI"] == "/"){
    $nombre_pagina = "Home";
}else if($_SERVER["REQUEST_URI"] == "/alta"){
    $nombre_pagina = "Alta de tarifas";
}else if($_SERVER["REQUEST_URI"] == "/tarifas"){
    $nombre_pagina = "Tarifas";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$nombre_pagina . $preparado_cabecera?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
