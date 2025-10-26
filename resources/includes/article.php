<article>
    <?php
    if ($imagen != "") { ?>
        <img src="/imgs/usuario/<?= htmlspecialchars($imagen) ?>" alt="imagen-articulo">
    <?php } ?>
    <div class="entradilla-articulo">
        <h3><?= htmlspecialchars($codigo) ?></h3>
        <p><?= htmlspecialchars($autor) . " | " . htmlspecialchars($email) ?></p>
    </div>
</article>