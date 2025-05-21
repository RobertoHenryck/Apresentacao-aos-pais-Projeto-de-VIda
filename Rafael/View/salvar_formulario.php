<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

function post($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : null;
}

$id = $_SESSION['id'];

$dados = [
    'minhasinspiracoes' => post('minhasinspiracoes'),
    'meusonho' => post('meusonho'),
    'escolha' => post('escolha'),
    'listesonho' => post('listesonho'),
    'objetivodecurtoprazo' => post('objetivodecurtoprazo'),
    'objetivodemedioprazo' => post('objetivodemedioprazo'),
    'objetivodelongoprazo' => post('objetivodelongoprazo'),
    'daquidezanos' => post('daquidezanos'),
    'fale_sobre_voce' => post('fale_sobre_voce'),
    'lembrancas' => post('lembrancas'),
    'pontos_fortes' => post('pontos_fortes'),
    'pontos_fracos' => post('pontos_fracos'),
    'valores' => isset($_POST['valores']) ? implode(',', $_POST['valores']) : '',
    'aptidoes' => isset($_POST['aptidoes']) ? implode(',', $_POST['aptidoes']) : '',
    'familia' => post('familia'),
    'amigos' => post('amigos'),
    'escola' => post('escola'),
    'sociedade' => post('sociedade'),
    'gosto_fazer' => post('gosto_fazer'),
    'nao_gosto' => post('nao_gosto'),
    'rotina' => post('rotina'),
    'lazer' => post('lazer'),
    'estudos' => post('estudos'),
    'vida_escolar' => post('vida_escolar'),
    'visao_fisica' => post('visao_fisica'),
    'visao_intelectual' => post('visao_intelectual'),
    'visao_emocional' => post('visao_emocional'),
    'visao_amigos' => post('visao_amigos'),
    'visao_familia' => post('visao_familia'),
    'visao_professores' => post('visao_professores'),
    'autovalorizacao' => isset($_POST['autovalorizacao']) ? json_encode($_POST['autovalorizacao']) : json_encode([]),
];

// Monta dinamicamente os campos para atualização
$campos = array_keys($dados);
$placeholders = array_map(fn($campo) => "$campo = ?", $campos);
$sql = "UPDATE users SET " . implode(', ', $placeholders) . " WHERE id = ?";

$stmt = $conn->prepare($sql);
$valores = array_values($dados);
$valores[] = $id;

try {
    $stmt->execute($valores);
    echo "<p style='color: green; text-align: center; font-size: 18px;'>Dados salvos com sucesso!</p>";
    echo "<div style='text-align: center; margin-top: 20px;'><a href='inicio.php' style='text-decoration: none; color: white; background-color: #007bff; padding: 10px 20px; border-radius: 10px;'>Voltar para o início</a></div>";
} catch (PDOException $e) {
    echo "<p style='color: red; text-align: center;'>Erro ao salvar os dados: " . $e->getMessage() . "</p>";
}
?>
