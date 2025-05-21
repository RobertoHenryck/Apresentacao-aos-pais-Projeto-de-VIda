<?php
session_start();
require 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Pegar dados do formulário
$dados = [
    'aspiracoes' => $_POST['aspiracoes'],
    'sonhos_hoje' => $_POST['sonhos_hoje'],
    'infancia' => $_POST['infancia'],
    'faco_agora' => $_POST['faco_agora'],
    'vou_fazer' => $_POST['vou_fazer'],
    'profissao' => $_POST['profissao'],
];

// Verifica se já existe registro
$sql = "SELECT COUNT(*) FROM sonhos WHERE usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$existe = $stmt->fetchColumn();

if ($existe) {
    // Atualizar
    $sql = "UPDATE sonhos SET aspiracoes = :aspiracoes, sonhos_hoje = :sonhos_hoje, infancia = :infancia,
            faco_agora = :faco_agora, vou_fazer = :vou_fazer, profissao = :profissao WHERE usuario_id = :usuario_id";
} else {
    // Inserir
    $sql = "INSERT INTO sonhos (aspiracoes, sonhos_hoje, infancia, faco_agora, vou_fazer, profissao, usuario_id)
            VALUES (:aspiracoes, :sonhos_hoje, :infancia, :faco_agora, :vou_fazer, :profissao, :usuario_id)";
}

$stmt = $pdo->prepare($sql);
$dados['usuario_id'] = $usuario_id;
$stmt->execute($dados);

header("Location: perfil2.php");
exit();
