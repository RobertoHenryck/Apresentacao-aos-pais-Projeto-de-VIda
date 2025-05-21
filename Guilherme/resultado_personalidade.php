<?php
session_start();
require_once 'Controller/UsuarioController.php';
require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);


if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

$resultado = $_GET['tipo'] ?? "Não definido";

$descricao_personalidade = [
    "Líder Visionário - Você gosta de desafios e de inspirar pessoas." => "Você tem uma mente estratégica e inspiradora...",
    "Analítico e Prático - Você é focado em lógica e organização." => "Você se destaca por sua habilidade...",
    "Criativo e Comunicativo - Você gosta de inovação e interação." => "Você é movido pela criatividade...",
    "Equilibrado e Adaptável - Você consegue se ajustar a qualquer situação." => "Você possui um equilíbrio impressionante..."
];

$descricao = $descricao_personalidade[$resultado] ?? "Perfil não identificado.";

$user_id = $_SESSION['usuario_id'];
$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16 FROM teste_personalidade WHERE user_id = :user_id ORDER BY data DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

$respostas = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$respostas || !is_array($respostas)) {
    echo "<p>Você ainda não respondeu ao teste de personalidade.</p>";
    exit;
}

$pontuacao = array_count_values($respostas);

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
    <link rel="stylesheet" href="estilo.css">
     <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
     <header>


        <div class="menu">

            <a href="painel.php">
                <div>Início</div>
            </a>

            <div class="image">

                <a href="perfil.php">
                    <div><img src="<?= $foto_perfil ?>" alt=""></div>
                </a>
            </div>

            <a href="index.php">
                <div><i class="fa-solid fa-right-from-bracket"></i></div>
            </a>
        </div>

    </header>
    <main>
        <section>

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
                            backgroundColor: ['rgba(255, 0, 55, 0.6)', 'rgba(0, 153, 255, 0.6)', 'rgba(255, 183, 0, 0.6)', 'rgba(0, 255, 13, 0.6)'],
                            borderColor: ['rgb(255, 0, 55)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
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
        </section>
    </main>

    <footer class="footer">
        <div>
            <p> © Todos os direitos reservados</p>
        </div>
    </footer>
</body>

</html>