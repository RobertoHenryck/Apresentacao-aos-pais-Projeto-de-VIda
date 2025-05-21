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
?>


<?php

require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['usuario_id'];

    $respostas = [];
    for ($i = 1; $i <= 16; $i++) {
        $respostas[$i] = isset($_POST["q$i"]) ? $_POST["q$i"] : "N";
    }

    // Mapeia cada pergunta a um tipo de inteligência
    $mapa_inteligencias = [
        1 => "musical",
        2 => "logico",
        3 => "corporal",
        4 => "linguistica",
        5 => "interpessoal",
        6 => "intrapessoal",
        7 => "naturalista",
        8 => "emocional",
        9 => "musical",
        10 => "logico",
        11 => "corporal",
        12 => "linguistica",
        13 => "interpessoal",
        14 => "intrapessoal",
        15 => "naturalista",
        16 => "emocional"
    ];

    // Inicializa a contagem de pontuações
    $pontuacoes = array_fill_keys(array_values($mapa_inteligencias), 0);

    // Atribui 1 ponto para cada resposta "A"
    foreach ($respostas as $num => $resposta) {
        if ($resposta == 'A') {
            $tipo = $mapa_inteligencias[$num];
            $pontuacoes[$tipo]++;
        }
    }

    $resultado_json = json_encode($pontuacoes);

    // Insere no banco de dados
    $sql = "INSERT INTO teste_inteligencia (user_id, " . implode(",", array_map(fn($i) => "q$i", range(1, 16))) . ", resultado)
            VALUES (:user_id, " . implode(",", array_map(fn($i) => ":q$i", range(1, 16))) . ", :resultado)";
   
    $stmt = $pdo->prepare($sql);
    $params = [':user_id' => $user_id, ':resultado' => $resultado_json];
    for ($i = 1; $i <= 16; $i++) {
        $params[":q$i"] = $respostas[$i];
    }
    $stmt->execute($params);

    // Redireciona para página de resultado
    $last_id = $pdo->lastInsertId();
    header("Location: resultado_inteligencia.php?id=$last_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Projeto de Vida</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>

body {
  font-family: 'Platypi', serif;
  background-color: #FF7E7E;
  margin: 0;
  padding: 0;
}

header {
  background-color: #5B0A29;
  color: white;
  padding: 20px 40px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
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
  color: #FFA3A3;
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
  background-color: #C4C4C4;
}

.user-info {
  display: flex;
  flex-direction: column;
  color: #FFA3A3;
  font-size: 14px;
}

.user-info a {
  color: #FFA3A3;
  text-decoration: none;
  font-size: 14px;
}

.user-info a:hover {
  text-decoration: underline;
}

nav a {
  margin-left: 30px;
  text-decoration: none;
  color: #FFA3A3;
  font-size: 20px;
}

h2 {
  text-align: center;
  color: #5B0A29;
  font-size: 32px;
  margin-top: 40px;
  margin-bottom: 30px;
}

form {
  background-color: #FFB3B3;
  padding: 30px;
  border-radius: 20px;
  max-width: 900px;
  margin: auto;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
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
  padding: 12px 30px;
  border-radius: 12px;
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
  padding: 15px 0;
  font-size: 14px;
  margin-top: 40px;
  font-family: 'Platypi', serif;
}


  </style>
</head>
<body>

  <header>
    <div class="left-header">
      <div class="logo">Projeto de vida</div>
      <div class="user-profile">
      <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
        <div class="user-info">
        <?php echo htmlspecialchars($usuario['nome']); ?>
          <a href="perfil.php">editar perfil</a>
        </div>
      </div>
    </div>
    <nav>
      <a href="inicio.php">Home</a>
      <a href="formulario.php">Teste personalidade</a>
      <a href="sonhos.php">Quem sou eu?</a>
   
    </nav>
  </header>

 <title>Teste de Múltiplas Inteligências</title>
</head>
<body>

    <h2>Teste de Múltiplas Inteligências</h2>
    <form method="POST">

        <?php
        $perguntas = [
            "Gosto de aprender ouvindo músicas e sons.",
            "Tenho facilidade em resolver problemas matemáticos.",
            "Prefiro atividades físicas e esportes.",
            "Aprendo melhor lendo e escrevendo.",
            "Gosto de trabalhar em equipe e conversar com outras pessoas.",
            "Gosto de refletir sobre meus sentimentos e pensamentos.",
            "Tenho uma conexão forte com a natureza e os animais.",
            "Percebo rapidamente as emoções das pessoas ao meu redor.",
            "Sou bom em reconhecer padrões musicais e ritmos.",
            "Adoro quebra-cabeças e desafios lógicos.",
            "Tenho facilidade para aprender coreografias e movimentos.",
            "Gosto de contar histórias e escrever textos.",
            "Sou bom em falar e convencer as pessoas.",
            "Prefiro atividades individuais e gosto de momentos de reflexão.",
            "Tenho curiosidade sobre o meio ambiente e como as coisas funcionam.",
            "Entendo facilmente o comportamento e expressões das pessoas."
        ];

        $opcoes = ["A" => "Sim", "B" => "Não"];

        // Exibindo as perguntas com numeração correta
        foreach ($perguntas as $index => $pergunta) {
            // A numeração começa de 1 e incrementa
            echo "<p>" . ($index + 1) . ". " . $pergunta . "</p>";  
            // Exibindo as opções de resposta
            foreach ($opcoes as $key => $value) {
                echo "<input type='radio' name='q" . ($index + 1) . "' value='$key' required> $value ";
            }
            echo "<br><br>";
        }
        ?>

        <br>
        <button type="submit">Enviar</button>
    </form>

 
 <footer class="footer">
    <p>&copy; 2025 Projeto de Vida. Todos os direitos reservados.</p>
  </footer>
  
</body>
</html>
