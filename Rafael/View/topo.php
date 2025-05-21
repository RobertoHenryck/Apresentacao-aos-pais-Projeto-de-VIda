<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<header class="principal">
    <div class="cabecalho">
        <img class="img2" src="../DALL·E 2025-03-26 07.40.11 - A modern and inspiring logo for a website about _Projeto de Vida_ (Life Project). The logo should feature a clean, minimalist design with vibrant colo-Photoroom (2).png" alt="Logo Projeto de Vida">
        <h1>MEU PERFIL</h1>

        <div class="perfil-container">
            <form action="perfil.php" method="get" class="perfil-form">
                <?php if (!empty($_SESSION['foto_perfil'])): ?>
                    <button type="submit" class="img-button">
                        <img src="../<?= htmlspecialchars($_SESSION['foto_perfil']) ?>" alt="Foto de Perfil" class="imgs">
                    </button>
                <?php else: ?>
                    <button type="submit" class="img-button">
                        <img src="../image.png" alt="Sem foto" class="imgs">
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</header>

<style>
.perfil-container {
    display: inline-block;
}

.perfil-form {
    margin: 0;
    padding: 0;
    border: none;
    background: none;
}

.img-button {
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
}
</style>
