<main id="home">
    <?php
    $articulos = leer_json($ruta_json_tarifas);

    if (count($articulos) != 0) {
        foreach ($articulos as $articulo) {
            $imagen = $articulo['imagen'];
            $codigo = $articulo['codigo'];
            $autor = $articulo['nombre_usuario'];
            $email = $articulo['email'];
            
            include 'article.php';
        }
    }else{
        echo "<h3>No hay articulos disponibles para mostrar</h3>";
    }
    ?>
</main>