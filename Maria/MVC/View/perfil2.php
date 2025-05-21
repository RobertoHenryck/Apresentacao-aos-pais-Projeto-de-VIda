<?php
session_start();
require 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar informações do usuário
$sql = "SELECT nome, foto_perfil, data_nascimento, email, sobre_mim FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar informações do "Quem sou eu?"
$sql_quem_sou = "SELECT * FROM sonhos WHERE usuario_id = ?";
$stmt_quem_sou = $pdo->prepare($sql_quem_sou);
$stmt_quem_sou->execute([$usuario_id]);
$quem_sou = $stmt_quem_sou->fetch(PDO::FETCH_ASSOC);

// Função para exibir dados ou mensagem personalizada
function exibirInfo($campo) {
    return !empty($campo) ? nl2br(htmlspecialchars($campo)) : 'Você ainda não preencheu esta informação.';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Perfil</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Platypi', serif;
      background-color: #FF7E7E;
    }
    header {
      background-color: #5B0A29;
      color: #fcb3b3;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .left-header { display: flex; flex-direction: column; }
    .logo { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
    }
    .user-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid white;
    }
    .user-text { display: flex; flex-direction: column; }
    .user-text a {
      color: #fcb3b3;
      font-size: 14px;
      text-decoration: underline;
    }
    nav a {
      margin-left: 20px;
      text-decoration: none;
      color: #fcb3b3;
      font-size: 18px;
    }
    .container {
      display: flex;
      justify-content: space-around;
      padding: 40px;
      align-items: flex-start;
    }
    .profile-photo {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
    .profile-photo img {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background-color: #ccc;
      object-fit: cover;
    }
    .form-section, .about-section {
      color: #5B0A29;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .form-section h2, .about-section h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }
    .form-section div p {
      margin: 8px 0;
    }
    .about-section p {
      width: 250px;
      background-color: #fca0a0;
      border-radius: 25px;
      padding: 15px;
      white-space: pre-line;
    }
   
    .footer {
      background-color: #5B0A29;
      color: #FFB3B3;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 200px;
    }
  </style>
</head>
<body>

<header>
  <div class="left-header">
    <div class="logo">Projeto de vida</div>
    <div class="user-info">
      <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
      <div class="user-text">
        <?php echo htmlspecialchars($usuario['nome']); ?>
        <a href="perfil.php">editar perfil</a>
      </div>
    </div>
  </div>
  <nav>
    <a href="inicio.php">Home</a>
    <a href="formulario.php">Teste personalidade</a>
    <a href="plano.php">Teste de inteligencia</a> 
    <a href="sonhos.php">Quem sou eu?</a>
  </nav>
</header>

<div class="container">
  <div class="profile-photo">
    <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
  </div>

  <div class="form-section">
    <h2>Informações do usuário</h2>
    <div>
      <p><strong>Nome de usuário:</strong> <?= htmlspecialchars($usuario['nome']) ?></p>
      <p><strong>Data de nascimento:</strong> <?= date('d/m/Y', strtotime($usuario['data_nascimento'])) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
    </div>
  </div>

  <div class="about-section">
    <h2>Quem sou eu?</h2>
    <p><strong>Aspiracoes:</strong> <?= exibirInfo($quem_sou['aspiracoes']) ?></p>
     <p><strong>Sonho de Infância:</strong> <?= exibirInfo($quem_sou['infancia']) ?></p> 
     <p><strong>Sonhos de hoje:</strong> <?= exibirInfo($quem_sou['vou_fazer']) ?></p> 
     <p><strong>O que vou fazer:</strong> <?= exibirInfo($quem_sou['sonhos_hoje']) ?></p>
   <p><strong>O que faço agora:</strong> <?= exibirInfo($quem_sou['faco_agora']) ?></p>
   <p><strong>Profissão:</strong> <?= exibirInfo($quem_sou['profissao']) ?></p> 
  </div>
  
    

  <div class="about-section">
    <h2>Sobre mim</h2>
    <p><?= nl2br(htmlspecialchars($usuario['sobre_mim'])) ?></p>
  </div>
</div>



<footer class="footer">
  <p>&copy; 2025 Projeto de Vida. Todos os direitos reservados.</p>
</footer>

</body>
</html>
