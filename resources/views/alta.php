<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo = htmlspecialchars($_POST["codigo"]);
    $fecha_alta = htmlspecialchars($_POST["fecha_alta"]);
    $fecha_baja = htmlspecialchars($_POST["fecha_baja"]);
    $cantidad = htmlspecialchars($_POST["cantidad"]);
    $usuario = htmlspecialchars($_POST["usuario"]);
    $email = htmlspecialchars($_POST["email"]);
    $imagen = $_FILES["imagen"];
    $tarifa = htmlspecialchars($_POST["tarifa"]);
    $max_rebaja = htmlspecialchars($_POST["max_rebaja"]);
    $errores = [];

    if (!preg_match('/cod-[0-9]{4,5}/', $codigo) || !isset($codigo)) {
        $errores["error_codigo"] = "El código debe seguir la siguiente estructura: cod-[4-5 números]";
    }

    if (!isset($fecha_alta) && strtotime($fecha_alta) !== false) {
        $errores["error_fecha_alta"] = "Debe de cumplimentar la fecha de alta de forma correcta: 2023-10-21";
    }

    if (!isset($fecha_baja) && strtotime($fecha_baja) !== false) {
        $errores["error_fecha_baja"] = "Debe de cumplimentar la fecha de baja de forma correcta: 2023-10-21";
    }

    if (!array_key_exists("error_fecha_alta", $errores) && !array_key_exists("error_fecha_baja", $errores)) {
        if (strtotime($fecha_baja) < strtotime($fecha_alta)) {
            $errores["error_fecha_menor"] = "La fecha de baja no puede ser menor que la fecha de alta";
        }
    }

    if (!preg_match('/[0-9]{1,3}/', $cantidad) || !isset($cantidad)) {
        $errores["error_cantidad"] = "La cantidad debe ser entre 0 y 999";
    }

    if (!preg_match('/[a-zA-Z]{3,15}/', $usuario) || !isset($usuario)) {
        $errores['error_usuario'] = "El usuario debe ser de 3 a 15 caracteres alfabéticos";
    } else {
        $usuario = strtolower($usuario);
    }

    if (!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['error_email'] = "Introduzca un email válido";
    }

    if (isset($imagen) && $imagen['error'] === UPLOAD_ERR_OK) {
        $archivo_temporal = $imagen['tmp_name'];
        $tamanyo_maximo = 2 * 1024 * 1024;
        if ($imagen['size'] > $tamanyo_maximo) {
            $errores['error_imagen'] = "La imagen es demasiado grande.";
        } else {
            $tipos_permitidos = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
            $tipo_imagen = exif_imagetype($archivo_temporal);
            if (!in_array($tipo_imagen, $tipos_permitidos)) {
                $errores['error_imagen'] = "Solo se permiten imágenes PNG y JPG.";
            } else {
                $extension = image_type_to_extension($tipo_imagen, false);
                $nombre_archivo_nuevo = uniqid('', true) . '.' . $extension;
                $ruta_destino = "C:" . DIRECTORY_SEPARATOR . "xampp\htdocs\proyecto1\public\imgs\usuario" . DIRECTORY_SEPARATOR . $nombre_archivo_nuevo;
                if (!move_uploaded_file($archivo_temporal, $ruta_destino)) {
                    $errores['error_imagen'] = "Error al mover la imagen subida.";
                }
            }
        }
    } else {
        $nombre_archivo_nuevo = "";
    }

    if (!preg_match('/^\d+$/', $tarifa) || !isset($tarifa)) {
        $errores['error_tarifa'] = "Debe establecer una tarifa base y debe ser numérica";
    }

    if (!preg_match('/^(100|[1-9]?[0-9])$/', $max_rebaja) || !isset($max_rebaja)) {
        $errores['error_rebaja'] = "Debe establecer una rebaja máxima de 0 a 100 (%)";
    }

    if (count($errores) === 0) {
        $ruta_json_tarifas = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "bbdd" . DIRECTORY_SEPARATOR . "tarifas.json";
        $precio_meses = calculo_precio_meses($tarifa, $max_rebaja);
        $tarifa = new Tarifa($codigo, $fecha_alta, $fecha_baja, $cantidad, $usuario, $email, $imagen, $tarifa, $max_rebaja, $precio_meses);
        escribir_json_tarifa($ruta_json_tarifas, $tarifa);
    }
}

function leer_json(string $ruta_json): array {
    $contenido = file_get_contents($ruta_json);
    $datos = json_decode($contenido, true);
    if ($datos === null) {
        return [];
    }
    return $datos;
}

function escribir_json_tarifa(string $ruta_json, Tarifa $tarifa): void {
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
?>

<!DOCTYPE html>
<html lang="es">
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
    <main>
        <form action="/alta" method="post" enctype="multipart/form-data">
            <label for="codigo">Código:</label><br />
            <?php if (isset($errores["error_codigo"])) echo "<p class='error'> {$errores['error_codigo']}</p>" ?>
            <input type="text" name="codigo" id="codigo"><br />

            <?php if (isset($errores["error_fecha_menor"])) echo "<p class='error'> {$errores['error_fecha_menor']}</p>" ?>
            <label for="fecha_alta">Fecha alta:</label><br />
            <?php if (isset($errores["error_fecha_alta"])) echo "<p class='error'> {$errores['error_fecha_alta']}</p>" ?>
            <input type="text" name="fecha_alta" id="fecha_alta"><br />

            <label for="fecha_baja">Fecha baja:</label><br />
            <?php if (isset($errores["error_fecha_baja"])) echo "<p class='error'> {$errores['error_fecha_baja']}</p>" ?>
            <input type="text" name="fecha_baja" id="fecha_baja"><br />

            <label for="cantidad">Cantidad base:</label><br />
            <?php if (isset($errores["error_cantidad"])) echo "<p class='error'> {$errores['error_cantidad']}</p>" ?>
            <input type="text" name="cantidad" id="cantidad"><br />

            <label for="usuario">Nombre usuario:</label><br />
            <?php if (isset($errores["error_usuario"])) echo "<p class='error'> {$errores['error_usuario']}</p>" ?>
            <input type="text" name="usuario" id="usuario"><br />

            <label for="email">Email:</label><br />
            <?php if (isset($errores["error_email"])) echo "<p class='error'> {$errores['error_email']}</p>" ?>
            <input type="text" name="email" id="email"><br />

            <label for="imagen">Imagen: </label><br />
            <?php if (isset($errores["error_imagen"])) echo "<p class='error'> {$errores['error_imagen']}</p>" ?>
            <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png"><br />

            <label for="tarifa">Tarifa base:</label><br />
            <input type="text" name="tarifa" id="tarifa"><br />

            <label for="max_rebaja">Máxima rebaja: (% en 24 meses aplicables)</label><br />
            <input type="text" name="max_rebaja" id="max_rebaja"><br />

            <input type="submit" value="Enviar">
        </form>
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</body>

</html>