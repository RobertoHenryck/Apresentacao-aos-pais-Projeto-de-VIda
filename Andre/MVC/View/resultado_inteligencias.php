<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Buscar os testes do usuário logado no banco `teste_inteligencia`
$sql = "SELECT id, data FROM teste_inteligencia WHERE user_id = :user_id ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$testes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica se encontrou registros
if (!$testes) {
    echo "<p>Nenhum teste encontrado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/resultado_inteligencias.css">
    <title>Resultado do Teste de Inteligências</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 400px;
            /* Reduzindo o tamanho do gráfico */
            max-height: 300px;
            margin: 20px auto;
        }

        header {
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 400px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h2>Selecione um teste anterior:</h2>
        <select id="selecionar_teste">
            <option value="">Escolha um teste</option>
            <?php foreach ($testes as $teste): ?>
                <option value="<?= $teste['id'] ?>">Teste de <?= date("d/m/Y H:i", strtotime($teste['data'])) ?></option>
            <?php endforeach; ?>
        </select>
    </header>

    <canvas id="graficoInteligencias"></canvas>

    <script>
        document.getElementById('selecionar_teste').addEventListener('change', function() {
            let testeId = this.value;
            console.log(testeId);
            if (testeId) {
                fetch('buscar_resultado.php?id=' + testeId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.resultado) {
                            myChart.data.labels = Object.keys(data.resultado);
                            myChart.data.datasets[0].data = Object.values(data.resultado);
                            myChart.update();


                            document.getElementById("resultado_tipo").innerText = "Você é mais: " + data.tipo;
                        }
                    })
                    .catch(error => console.error('Erro ao buscar o teste:', error));
            }
        });

        // Inicializa o gráfico vazio
        let ctx = document.getElementById('graficoInteligencias').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Pontuação',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <h2 id="resultado_tipo">Tipo de inteligência:</h2>
    <a href="perfil.php">Voltar</a>
</body>

</html>