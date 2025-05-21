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
$stmt->bindParam(':id', $usuario_id); // <- Correção aqui
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_SESSION['usuario_id'];

  $respostas = [
      $_POST['q1'],
      $_POST['q2'],
      $_POST['q3'],
      $_POST['q4'],
      $_POST['q5'],
      $_POST['q6'],
      $_POST['q7'],
      $_POST['q8'],
      $_POST['q9'],
      $_POST['q10'],
      $_POST['q11'],
      $_POST['q12'],
      $_POST['q13'],
      $_POST['q14'],
      $_POST['q15'],
      $_POST['q16']
  ];

  // Mapeia as respostas para traços de personalidade
  $pontuacao = array_count_values($respostas);

  // Determina o tipo de personalidade
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_SESSION['usuario_id'];

  // Pegue as respostas do formulário
  $respostas = [];
  for ($i = 1; $i <= 16; $i++) {
    $respostas[] = isset($_POST['q' . $i]) ? $_POST['q' . $i] : null;
  }

  // Mapeia as respostas para traços de personalidade
  $pontuacao = array_count_values($respostas);

  // Determina o tipo de personalidade
  if (($pontuacao['A'] ?? 0) >= 10) {
      $resultado = "Líder Visionário - Você gosta de desafios e de inspirar pessoas.";
  } elseif (($pontuacao['B'] ?? 0) >= 10) {
      $resultado = "Analítico e Prático - Você é focado em lógica e organização.";
  } elseif (($pontuacao['C'] ?? 0) >= 10) {
      $resultado = "Criativo e Comunicativo - Você gosta de inovação e interação.";
  } else {
      $resultado = "Equilibrado e Adaptável - Você consegue se ajustar a qualquer situação.";
  }

  // Salva os dados no banco de dados
  $sql = "INSERT INTO teste_personalidade (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, resultado, data)
          VALUES (:user_id, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :q11, :q12, :q13, :q14, :q15, :q16, :resultado, NOW())";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
      ':user_id' => $user_id,
      ':q1' => $respostas[0],
      ':q2' => $respostas[1],
      ':q3' => $respostas[2],
      ':q4' => $respostas[3],
      ':q5' => $respostas[4],
      ':q6' => $respostas[5],
      ':q7' => $respostas[6],
      ':q8' => $respostas[7],
      ':q9' => $respostas[8],
      ':q10' => $respostas[9],
      ':q11' => $respostas[10],
      ':q12' => $respostas[11],
      ':q13' => $respostas[12],
      ':q14' => $respostas[13],
      ':q15' => $respostas[14],
      ':q16' => $respostas[15],
      ':resultado' => $resultado
  ]);

  // Redireciona para a página de resultado
  header("Location: resultado.personalidade.php?tipo=" . urlencode($resultado));
  exit;
}

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de Personalidade</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Platypi', serif;
      background-color: #FF7E7E;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #5B0A29;
      color: white;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #C4C4C4;
    }

    .profile-info {
      color: #FFA3A3;
      font-size: 14px;
    }

    .profile-info strong {
      font-size: 18px;
      display: block;
    }

    .profile-info a {
      color: #FFA3A3;
      text-decoration: none;
      font-size: 14px;
    }

    .profile-info a:hover {
      text-decoration: underline;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 40px;
      margin: 0;
      padding: 0;
    }

    nav ul li a {
      color: #FFA3A3;
      text-decoration: none;
      font-size: 20px;
    }

    .main {
      padding: 40px;
    }
 /* Título */
    h1 {
      font-size: 24px;
      font-weight: bold;
      color: #5B0A29;
      margin-bottom: 30px; /* Espaço entre o título e o gráfico */
       text-align: center; /* Garantir que o título esteja centralizado */
    }
  

    h2 {
      text-align: center;
      color: #5B0A29;
      font-size: 32px;
      margin-bottom: 30px;
    }

    form {
      background-color: #FFB3B3;
      padding: 30px;
      border-radius: 20px;
      max-width: 900px;
      margin: auto;
      box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
    }

    p {
      font-size: 18px;
      color: #5B0A29;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type="radio"] {
      margin-right: 8px;
    }

    button[type="submit"] {
      display: block;
      margin: 30px auto 0;
      background-color: #5B0A29;
      color: #FFA3A3;
      border: none;
      padding: 10px 30px;
      border-radius: 10px;
      font-size: 18px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #7E0E3B;
    }

    .footer {
      background-color: #5B0A29;
      color: #FFB3B3;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 40px;
    } 
   
  </style>
</head>
<body>

 <!-- Cabeçalho -->
  <div class="header">
    <div class="profile">
    <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
      <div class="profile-info">
        <strong>Projeto de Vida</strong>
        <?php echo htmlspecialchars($usuario['nome']); ?>
        <br>
        <a href="perfil.php">editar perfil</a>
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="inicio.php">Home</a></li>
        <li><a href="plano.php">Teste de inteligencia</a></li>
        <li><a href="sonhos.php">Quem sou eu?</a></li>
      </ul>
    </nav>
     <!-- Título acima das perguntas -->
 
  </div>

 <h1>Teste de Personalidade</h1>
</body>
</html>


      <?php
      $perguntas = [
          "Como você costuma resolver um problema difícil?",
          "Qual dessas atividades te deixa mais animado?",
          "O que te motiva a sair da cama todos os dias?",
          "Quando algo inesperado acontece, o que você faz primeiro?",
          "O que mais te incomoda em outras pessoas?",
          "Como você costuma agir em trabalhos em grupo?",
          "Quando algo muda de repente, como você reage?",
          "Qual desses valores representa melhor você?",
          "Como você se enxerga na maioria das vezes?",
          "Qual é o seu jeito preferido de tomar decisões importantes?",
          "Você prefere trabalhar em qual dessas situações?",
          "O que costuma te deixar mais estressado?",
          "Que tipo de tarefa você sente mais facilidade em fazer?",
          "O que te traz mais satisfação ao final do dia?",
          "Como você lida com situações de muita pressão?",
          "Qual dessas palavras melhor define sua personalidade?"
      ];

      $opcoes = [
          ["A - De forma lógica e estratégica", "B - Usando criatividade", "C - Conversando com alguém", "D - Agindo rapidamente"],
          ["A - Resolver enigmas ou desafios", "B - Criar algo artístico", "C - Estar com amigos", "D - Cumprir metas práticas"],
          ["A - Superar obstáculos", "B - Ter novas ideias", "C - Estar com pessoas", "D - Alcançar resultados"],
          ["A - Analiso a situação", "B - Confio na intuição", "C - Converso com os outros", "D - Tomo uma atitude"],
          ["A - Falta de lógica", "B - Falta de originalidade", "C - Falta de empatia", "D - Falta de ação"],
          ["A - Organizado e focado", "B - Traz novas ideias", "C - Ouve e colabora", "D - Objetivo e direto"],
          ["A - Penso antes de reagir", "B - Vejo como oportunidade", "C - Busco apoio", "D - Me adapto e sigo em frente"],
          ["A - Conhecimento", "B - Criatividade", "C - Conexões humanas", "D - Eficiência"],
          ["A - Frio e racional", "B - Imaginativo", "C - Sensível e acolhedor", "D - Focado e prático"],
          ["A - Com base em dados", "B - Pela minha intuição", "C - Depois de ouvir opiniões", "D - Pelo que funcionou antes"],
          ["A - Sozinho, com foco", "B - Onde posso criar", "C - Com outras pessoas", "D - Onde há objetivos claros"],
          ["A - Perder o controle", "B - Ficar preso à rotina", "C - Se sentir isolado", "D - Falta de resultado"],
          ["A - Análises e pesquisas", "B - Expressar ideias", "C - Comunicar-se bem", "D - Produzir resultados"],
          ["A - Resolver algo complexo", "B - Criar algo novo", "C - Ajudar alguém", "D - Concluir tarefas"],
          ["A - Com calma e estratégia", "B - Pensando fora da caixa", "C - Buscando apoio emocional", "D - Agindo com rapidez"],
          ["A - Lógico", "B - Inovador", "C - Empático", "D - Determinado"]
      ];?>
<form method="POST" action="">
    <?php
    for ($i = 0; $i < 16; $i++) {
        echo "<p>" . ($i + 1) . ". " . $perguntas[$i] . "</p>";
        foreach ($opcoes[$i] as $opcao) {
            echo "<input type='radio' name='q" . ($i + 1) . "' value='" . substr($opcao, 0, 1) . "' required> $opcao <br>";
        }
    }
    ?>
    <button type="submit">Enviar</button>
</form>

 <footer class="footer">
    <p>&copy; 2025 Projeto de Vida. Todos os direitos reservados.</p>
  </footer>
  
</body>
