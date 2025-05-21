<?php
session_start();
require_once 'Controller/UsuarioController.php';
require 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Buscar os testes do usuário logado no banco `teste_inteligencia`
$sql = "SELECT id, data FROM teste_inteligencias WHERE user_id = :user_id ORDER BY data DESC";
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
    <title>Resultado do Teste de Inteligências</title>
    <link rel="stylesheet" href="estilo.css">
     <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 400px;
            /* Reduzindo o tamanho do gráfico */
            max-height: 300px;
            margin: 20px auto;
        }
    </style>
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


            <h2>Selecione um teste anterior:</h2>
            <select id="selecionar_teste">
                <option value="">Escolha um teste</option>
                <?php foreach ($testes as $teste): ?>
                    <option value="<?= $teste['id'] ?>">Teste de <?= date("d/m/Y H:i", strtotime($teste['data'])) ?></option>
                <?php endforeach; ?>
            </select>


            <h2 id="resultado_tipo">Tipo de inteligência:</h2>
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
        </section>
    </main>
    <footer class="footer">
        <div>
            <p> © Todos os direitos reservados</p>
        </div>
    </footer>
</body>

</html>