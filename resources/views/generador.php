<!DOCTYPE html>
<html lang="es">
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php' ?>

<body>

</body>
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ?>
<main>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    ?>
        <form action="/generador.php" method="get">
        <div class="popup">
            <label for="cantidad">¿Cuánto está dispuesto a pagar?</label>
            <input type="text" name="cantidad" id="cantidad">
            <input type="submit" value="Encontrar ofertas">
        </div>
        </form>
    <?php
    }else{
    ?>
    <?php
        $precio_base = 50;
        $cantidad = $_GET["cantidad"]; 
        if(isset($cantidad)){
            
        }
    }
    ?>
</main>
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php' ?>

</html>