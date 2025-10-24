<header>
    <img src="/imgs/logo-mustreaming.png" alt="logo-mustreaming">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigation.php'; ?>
    <?php
    if (preg_match('/^\/tarifas.*$/', $_SERVER["REQUEST_URI"])) {
        $tarifas = leer_json($ruta_json_tarifas);
    ?>
        <form action="/tarifas" id="menu-desplegable-tarifas" method="get">
            <select name="tarifa" id="menu-desplegable" onchange="document.getElementById('menu-desplegable-tarifas').submit()">
                <option value="" disabled selected>Selecciona una tarifa</option>
                <?php
                foreach ($tarifas as $indice => $tarifa) {
                    $indice_ficticio = $indice + 1;
                    echo "<option value='{$indice_ficticio}'>Tarifa {$indice_ficticio}</option>";
                }
                ?>
            </select>
        </form>
    <?php } ?>
</header>