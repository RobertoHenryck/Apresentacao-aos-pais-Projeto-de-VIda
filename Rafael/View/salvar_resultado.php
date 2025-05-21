<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['id']) || !isset($_POST['resultado'])) {
    http_response_code(400);
    exit('Erro: dados ausentes');
}

$id = $_SESSION['id'];
$resultado = $_POST['resultado'];

if (!in_array($resultado, ['A', 'B', 'C'])) {
    http_response_code(400);
    exit('Resultado inválido.');
}

try {
    $stmt = $conn->prepare("INSERT INTO resultados (user_id, resultado, data_resposta) VALUES (?, ?, NOW())");
    if ($stmt->execute([$id, $resultado])) {
        http_response_code(200);
        echo "Resultado salvo com sucesso.";
    } else {
        http_response_code(500);
        echo "Erro ao salvar resultado.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro no banco de dados: " . $e->getMessage();
}
