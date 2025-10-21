<main>
    <h1>Esto será mi main</h1
    <?php
        function leer_json(string $json): array{
            $contenido = file_get_contents($json);
            $datos = json_decode($contenido, true);
            $articulos = [];
            foreach($datos as $articulo){
                $articulos[] = new Articulo($articulo['codigo'], $articulo['nombre'], $articulo['precio']);
            }

            return $articulos;
        }

        $ruta_json_articulos = dirname(__DIR__) . "/bbdd/tarifas.json";
        $articulos = leer_json($ruta_json_articulos);
        
        foreach ($articulos as $articulo) {     
        }
    ?>
</main>