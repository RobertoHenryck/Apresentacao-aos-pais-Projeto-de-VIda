<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Conectar ao banco de dados
require_once 'C:/Turma2/xampp/htdocs/projeto_de_vida/MVC/config/config.php';


// Verificar se os formulários foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Variáveis de pontuação
    $pontuacao_personalidade = 0;
    $pontuacao_inteligencia = 0;

    // Processar respostas de personalidade
    if (isset($_POST['pergunta1'])) {
        $pontuacao_personalidade += ($_POST['pergunta1'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta2'])) {
        $pontuacao_personalidade += ($_POST['pergunta2'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta3'])) {
        $pontuacao_personalidade += ($_POST['pergunta3'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta4'])) {
        $pontuacao_personalidade += ($_POST['pergunta4'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta5'])) {
        $pontuacao_personalidade += ($_POST['pergunta5'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta6'])) {
        $pontuacao_personalidade += ($_POST['pergunta6'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta7'])) {
        $pontuacao_personalidade += ($_POST['pergunta7'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta8'])) {
        $pontuacao_personalidade += ($_POST['pergunta8'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta9'])) {
        $pontuacao_personalidade += ($_POST['pergunta9'] == 'sim') ? 1 : 0;
    }
    if (isset($_POST['pergunta10'])) {
        $pontuacao_personalidade += ($_POST['pergunta10'] == 'sim') ? 1 : 0;
    }

    // Processar respostas de inteligência
    if (isset($_POST['q1']) && $_POST['q1'] == 'C') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 1
    if (isset($_POST['q2']) && $_POST['q2'] == 'C') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 2
    if (isset($_POST['q3']) && $_POST['q3'] == 'D') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 3
    if (isset($_POST['q4']) && $_POST['q4'] == 'C') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 4
    if (isset($_POST['q5']) && $_POST['q5'] == 'A') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 5
    if (isset($_POST['q6']) && $_POST['q6'] == 'B') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 6
    if (isset($_POST['q7']) && $_POST['q7'] == 'C') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 7
    if (isset($_POST['q8']) && $_POST['q8'] == 'A') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 8
    if (isset($_POST['q9']) && $_POST['q9'] == 'A') { $pontuacao_inteligencia += 1; }  // Resposta correta para a questão 9
    if (isset($_POST['q10']) && $_POST['q10'] == 'D') { $pontuacao_inteligencia += 1; } // Resposta correta para a questão 10

    // Obter o id do usuário logado
    $usuario_id = $_SESSION['usuario_id'];

    // Inserir os resultados de Personalidade no banco
    $stmt = $pdo->prepare("INSERT INTO resultados_personalidade (usuario_id, pontuacao) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $pontuacao_personalidade]);

    // Inserir os resultados de Inteligência no banco
    $stmt = $pdo->prepare("INSERT INTO resultados_inteligencia (usuario_id, pontuacao) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $pontuacao_inteligencia]);

    // Redirecionar para a página de resultados com as pontuações
    header('Location: resultados.php?pontuacao_personalidade=' . $pontuacao_personalidade . '&pontuacao_inteligencia=' . $pontuacao_inteligencia);
    exit;
}
?>
