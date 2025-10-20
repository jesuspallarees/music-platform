<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo = htmlspecialchars($_POST["codigo"]);
    $fecha_alta = htmlspecialchars($_POST["fecha_alta"]);
    $fecha_baja = htmlspecialchars($_POST["fecha_baja"]);
    $cantidad = htmlspecialchars($_POST["cantidad"]);
    $usuario = htmlspecialchars($_POST["usuario"]);
    $email = htmlspecialchars($_POST["email"]);

    if (!preg_match('/cod[0-9]{4,5}/', $codigo)) {
        $errores["error_codigo"] = "El código debe seguir la siguiente estructura: cod-[4-5 números]";
    }

    if (!isset($fecha_alta) || !isset($fecha_baja)) {
        if ($fecha_alta < $fecha_baja) {
            $errores['error_fechas'] = "La fecha de baja no puede ser menor que la fecha de alta";
        }
    } else {
        $errores["error_fechas"] = "Debe de cumplimentar la fecha de alta y fecha de baja de la tarifa";
    }

    if (!preg_match('/[0-9]{1,3}/', $cantidad)) {
        $errores["error_cantidad"] = "La cantidad debe ser entre 0 y 999";
    }

    if (!preg_match('/[A-z]{3,15}/', $usuario)) {
        $errores['error_usuario'] = "El usuario debe ser de 3 a 15 caracteres alfabéticos";
    }

    if (!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['error_email'] = "Introduzca un email válido";
    }

    if (isset($imagen) && $imagen['error'] === UPLOAD_ERR_OK) {
        $archivoTemporal = $imagen['tmp_name'];
        $tamanyoMaximo = 2 * 1024 * 1024;
        if ($imagen['size'] > $tamanyoMaximo) {
            $errores['error_imagen'] = "La imagen es demasiado grande.";
        } else {
            $tiposPermitidos = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
            $tipoImagen = exif_imagetype($archivoTemporal);
            if (!in_array($tipoImagen, $tiposPermitidos)) {
                $errores['error_imagen'] = "Solo se permiten imágenes PNG y JPG.";
            } else {
                $extension = image_type_to_extension($tipoImagen, false);
                $nombre_archivo_nuevo = uniqid('', true) . '.' . $extension;
                $rutaDestino = 'imgs/usuario/' . $nombre_archivo_nuevo;
                if (!move_uploaded_file($archivoTemporal, $rutaDestino)) {
                    $errores['error_imagen'] = "Error al mover la imagen subida.";
                }
            }
        }
    } else {
        $nombre_archivo_nuevo = "";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<?php require dirname(__DIR__) . '/includes/head.php' ?>

<body>
    <form action="/alta" method="post" enctype="multipart/form-data">
        <?php if (isset($errores["error_codigo"])) echo "<p class='error'> {$errores['error_codigo']} </p>" ?>
        <label for="codigo">Código:</label><br />
        <input type="text" name="codigo" id="codigo"><br />
        <label for="fecha_alta">Fecha alta:</label><br />
        <input type="date" name="fecha_alta" id="fecha_alta"><br />
        <label for="fecha_baja">Fecha baja:</label><br />
        <input type="date" name="fecha_baja" id="fecha_baja"><br />
        <label for="cantidad">Cantidad base:</label><br />
        <input type="text" name="cantidad" id="cantidad"><br />
        <label for="usuario">usuario usuario:</label><br />
        <input type="text" name="usuario" id="usuario"><br />
        <label for="email">Email:</label><br />
        <input type="text" name="email" id="email"><br />
        <label for="imagen">Imagen: </label><br />
        <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png"><br />
        <label for="tarifa">Tarifa base:</label><br />
        <input type="text" name="tarifa" id="tarifa"><br />
        <label for="max_rebaja">Máxima rebaja:</label><br />
        <input type="text" name="max_rebaja" id="max_rebaja"><br />
        <input type="submit" value="Enviar">
    </form>
</body>

</html>