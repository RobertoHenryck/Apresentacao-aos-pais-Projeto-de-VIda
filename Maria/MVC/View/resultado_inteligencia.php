<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}

// Obter os dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, data_nascimento FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Buscar os dados do usuário logado
$sql = "SELECT nome, foto_perfil FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $user_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Erro: Usuário não encontrado.");
}

// Buscar os testes de inteligência desse usuário
$sqlTestes = "SELECT id, data FROM teste_inteligencia WHERE user_id = :user_id ORDER BY data DESC";
$stmtTestes = $pdo->prepare($sqlTestes);
$stmtTestes->execute(['user_id' => $user_id]);
$testes = $stmtTestes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Projeto de Vida</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
        font-family: 'Platypi', serif;
        text-align: center;
        padding: 20px;
        margin: 0;
        background-color: #f87f7f; /* fundo da página de teste */
    }

    .left-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-profile img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        color: #FFA3A3;
        font-size: 14px;
    }

    .user-info a {
        color: #FFA3A3;
        text-decoration: underline;
        font-size: 14px;
    }

    nav a {
        margin-left: 20px;
        text-decoration: none;
        color: #FFA3A3;
        font-size: 18px;
    }

    h2 {
        text-align: center;
        font-size: 28px;
        margin: 30px 0 10px 0;
        color: #500A27;
    }

    canvas {
        max-width: 400px;
        max-height: 300px;
        display: block;
        margin: 20px auto;
    }

    .select-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #resultado_tipo {
        text-align: center;
        font-size: 18px;
        color: #500A27;
        margin-top: 20px;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 30px;
        color: #56052b;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

  </style>
</head>
<body>

  <div class="select-container">
    <h2>Selecione um teste anterior:</h2>
    <select id="selecionar_teste">
      <option value="">Escolha um teste</option>
      <?php foreach ($testes as $teste): ?>
        <option value="<?= $teste['id'] ?>">Teste de <?= date("d/m/Y H:i", strtotime($teste['data'])) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <canvas id="graficoInteligencias"></canvas>
  <div id="resultado_tipo"></div>

  <a href="inicio.php">Voltar</a>

  <script>
    document.getElementById('selecionar_teste').addEventListener('change', function() {
      let testeId = this.value;
      if (testeId) {
        fetch('buscar_resultado.php?id=' + testeId)
          .then(response => response.json())
          .then(data => {
            console.log(data); // <-- Adicione isso para ver o que está vindo do PHP
            if (data.resultado) {
              myChart.data.labels = Object.keys(data.resultado);
              myChart.data.datasets[0].data = Object.values(data.resultado);
              myChart.update();
              document.getElementById("resultado_tipo").innerText = "Você é mais: " + data.tipo;
            } else {
              document.getElementById("resultado_tipo").innerText = "Erro: Resultado não encontrado.";
            }
          })
          .catch(error => {
            console.error('Erro ao buscar o teste:', error);
            document.getElementById("resultado_tipo").innerText = "Erro ao buscar os dados.";
          });
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

</body>
</html>
