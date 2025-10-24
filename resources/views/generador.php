<?php
$presupuesto = isset($_GET['presupuesto']) ? floatval($_GET['presupuesto']) : null;
?>

<!DOCTYPE html>
<html lang="es">
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
    <main>
        <?php if ($presupuesto === null): ?>
            <div class="popup">
                <form action="" method="get">
                    <label for="presupuesto">¿Cuánto quieres pagar por mes? (€)</label><br>
                    <input type="text" id="presupuesto" name="presupuesto" required>
                    <button type="submit">Buscar tarifas</button>
                </form>
            </div>
        <?php else: ?>
            <?php
            $tarifas = leer_json($ruta_json_tarifas);
            $hay_tarifas = false;

            foreach ($tarifas as $tarifa) {
                $codigo         = htmlspecialchars($tarifa['codigo']);
                $nombre_usuario = htmlspecialchars($tarifa['nombre_usuario']);
                $email          = htmlspecialchars($tarifa['email']);
                $tarifa_base    = floatval($tarifa['tarifa']);
                $max_rebaja     = floatval($tarifa['max_rebaja']);
                $precios_meses  = $tarifa['precio_meses'];

                $tarifas_aptas = [];
                foreach ($precios_meses as $meses => $precio_mes) {
                    if ($precio_mes <= $presupuesto) {
                        $tarifas_aptas[] = [
                            'meses' => (int)$meses,
                            'precio_mes' => $precio_mes,
                            'total' => round($precio_mes * $meses, 2),
                        ];
                    }
                }

                if (!empty($tarifas_aptas)) {
                    $hay_tarifas = true;

                    $min_meses = $tarifas_aptas[0]['meses'];
                    $max_meses = $tarifas_aptas[count($tarifas_aptas) - 1]['meses'];


                    echo "<h3>Tarifa usuario: $nombre_usuario &lt;$email&gt; (Código: $codigo)</h3>";
                    echo "<p id='generador'>Tarifa mínima: $min_meses meses<br>Mejor tarifa (máximo meses): $max_meses meses</p>";

                    echo '<table>';
                    echo '<thead><tr><th>Meses contratados</th><th>Precio por mes (€)</th><th>Total a pagar (€)</th></tr></thead><tbody>';

                    foreach ($tarifas_aptas as $tarifa) {
                        echo '<tr>';
                        echo "<td>{$tarifa['meses']}</td>";
                        echo "<td>" . number_format($tarifa['precio_mes'], 2) . "</td>";
                        echo "<td>" . number_format($tarifa['total'], 2) . "</td>";
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }
            }

            if (!$hay_tarifas) {
                echo "<h2>No hay tarifas disponibles dentro del presupuesto de €" . number_format($presupuesto, 2) . ". </h2>";
            }
            ?>
            <button><a href="/generador">Volver</a></button>
        <?php endif; ?>
    </main>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>
</body>

</html>