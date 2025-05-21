<?php
// Verifica se a sessão já foi iniciada, se não, inicia a sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'conexao.php'; // Ajuste o caminho conforme seu projeto

// Função para garantir que o usuário esteja logado
function garantirUsuarioLogado()
{
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }
}

// Função para atualizar a foto de perfil na sessão (carrega do banco)
function atualizarFotoSessao(PDO $conn)
{
    if (!isset($_SESSION['id'])) return;

    $stmt = $conn->prepare("SELECT foto_perfil FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['foto_perfil'] = $usuario['foto_perfil'] ?? null;
}

?>
