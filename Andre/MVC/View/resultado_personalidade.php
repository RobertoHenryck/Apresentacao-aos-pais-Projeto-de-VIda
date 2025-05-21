<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

// Obtém o tipo de personalidade passado pela URL
$resultado = $_GET['tipo'] ?? "Não definido";

// Descrições para cada tipo de personalidade
$descricao_personalidade = [
    "Líder Visionário - Você gosta de desafios e de inspirar pessoas." => "Você tem uma mente estratégica e inspiradora, sempre buscando motivar quem está ao seu redor e liderar com propósito.",
    "Analítico e Prático - Você é focado em lógica e organização." => "Você se destaca por sua habilidade de tomar decisões racionais, resolver problemas com eficiência e manter tudo sob controle.",
    "Criativo e Comunicativo - Você gosta de inovação e interação." => "Você é movido pela criatividade e pela troca de ideias, sendo uma pessoa expressiva e cheia de novas soluções.",
    "Equilibrado e Adaptável - Você consegue se ajustar a qualquer situação." => "Você possui um equilíbrio impressionante entre razão, emoção e ação, conseguindo lidar bem com mudanças e se adaptar facilmente."
];

// Escolhe a descrição com base no tipo
$descricao = $descricao_personalidade[$resultado] ?? "Perfil não identificado.";

// Pega as últimas respostas do usuário
$user_id = $_SESSION['usuario_id'];
$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16 
        FROM teste_personalidade 
        WHERE user_id = :user_id 
        ORDER BY data DESC 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

$respostas = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$respostas || !is_array($respostas)) {
    echo "<p>Você ainda não respondeu ao teste de personalidade.</p>";
    exit;
}

// ✅ Corrigido: conta os valores corretamente
$pontuacao = array_count_values(array_values($respostas));

// Prepara dados para o gráfico
$labels = json_encode(["Líder", "Analítico", "Criativo", "Equilibrado"]);
$valores = json_encode([
    $pontuacao['A'] ?? 0,
    $pontuacao['B'] ?? 0,
    $pontuacao['C'] ?? 0,
    $pontuacao['D'] ?? 0
]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Teste</title>
    <link rel="stylesheet" href="../View/css/resultado_personalidade.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: black;
            background-color: #f0f0f0;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        a:hover {
            background-color: #ddd;
        }

        canvas {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h2>Seu Resultado</h2>
    <p><strong>Tipo de Personalidade:</strong> <?php echo $resultado; ?></p>
    <p><?php echo $descricao; ?></p>

    <canvas id="graficoPersonalidade" width="300" height="300"></canvas>

    <script>
        const ctx = document.getElementById('graficoPersonalidade').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $labels; ?>,
                datasets: [{
                    label: 'Pontuação',
                    data: <?php echo $valores; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 16
                    }
                }
            }
        });
    </script>

    <a href="perfil.php">Voltar</a>

</body>
</html>
