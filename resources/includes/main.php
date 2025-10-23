<main id="home">
    <?php
    $ruta_json_articulos = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "bbdd" . DIRECTORY_SEPARATOR . "articulos.json";
    $articulos = leer_json($ruta_json_articulos);

    if (count($articulos) != 0) {
        foreach ($articulos as $articulo) {
            $imagen = $articulo['imagen'];
            $titulo = $articulo['titulo'];
            $contenido = $articulo['contenido'];
            
            include 'article.php';
        }
    }else{
        echo "<h3>No hay articulos disponibles para mostrar</h3>";
    }
    ?>
</main>