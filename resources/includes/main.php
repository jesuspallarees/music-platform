<main id="home">
    <?php
    $articulos = leer_json($ruta_json_tarifas);

    if (count($articulos) != 0) {
        foreach ($articulos as $articulo) {
            $imagen = $articulo['imagen'];
            $titulo = $articulo['codigo'];
            $contenido = $articulo['nombre_usuario'];
            
            include 'article.php';
        }
    }else{
        echo "<h3>No hay articulos disponibles para mostrar</h3>";
    }
    ?>
</main>