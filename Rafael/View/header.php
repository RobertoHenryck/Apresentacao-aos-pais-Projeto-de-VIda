<?php
// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../conexao.php';

// Redireciona para login se não estiver logado
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

// Verifica se a imagem está salva na sessão; se não estiver, busca do banco e salva
if (!isset($_SESSION['foto_perfil'])) {
    $stmt = $conn->prepare("SELECT foto_perfil FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $usuario['foto_perfil']) {
        $_SESSION['foto_perfil'] = $usuario['foto_perfil'];
    }
}

// Caminho da imagem (com fallback)
$foto = isset($_SESSION['foto_perfil']) && $_SESSION['foto_perfil'] !== ''
    ? "../" . $_SESSION['foto_perfil']
    : "../image.png";
?>

<style>
    .principal {
        background-color: #004080;
        color: white;
        padding: 20px 0;
    }

    .cabecalho {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .img2 {
        height: 80px;
    }

    .imgs {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.2s;
    }

    .imgs:hover {
        transform: scale(1.05);
    }

    h1 {
        font-size: 28px;
    }
</style>

<header class="principal">
    <div class="cabecalho">
        <img class="img2" src="../logo.png" alt="Logo Projeto de Vida">
        <h1>MEU PERFIL</h1>
        <a href="perfil.php">
            <img class="imgs" src="<?= htmlspecialchars($foto) ?>" alt="Foto de Perfil">
        </a>
    </div>
</header>
