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