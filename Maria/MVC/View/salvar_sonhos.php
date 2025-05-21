<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Coleta os dados do formulário
$aspiracoes = $_POST['aspiracoes'] ?? null;
$sonhos_hoje = $_POST['sonhos_hoje'] ?? null;
$infancia = $_POST['infancia'] ?? null;
$faco_agora = $_POST['faco_agora'] ?? null;
$vou_fazer = $_POST['vou_fazer'] ?? null;
$profissao = $_POST['profissao'] ?? null;

// Validação simples (opcional)
if (empty($aspiracoes) && empty($sonhos_hoje) && empty($infancia) && empty($faco_agora) && empty($vou_fazer) && empty($profissao)) {
    echo "Por favor, preencha pelo menos um campo.";
    exit;
}

// Prepara e executa a inserção
$sql = "INSERT INTO sonhos (usuario_id, aspiracoes, sonhos_hoje, infancia, faco_agora, vou_fazer, profissao)
        VALUES (:usuario_id, :aspiracoes, :sonhos_hoje, :infancia, :faco_agora, :vou_fazer, :profissao)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->bindParam(':aspiracoes', $aspiracoes);
$stmt->bindParam(':sonhos_hoje', $sonhos_hoje);
$stmt->bindParam(':infancia', $infancia);
$stmt->bindParam(':faco_agora', $faco_agora);
$stmt->bindParam(':vou_fazer', $vou_fazer);
$stmt->bindParam(':profissao', $profissao);

if ($stmt->execute()) {
    header('Location: sucesso.php'); // Crie uma página de sucesso se quiser
    exit;
} else {
    echo "Erro ao salvar os dados.";
}
?>
