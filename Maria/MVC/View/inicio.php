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

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Projeto de Vida - Início</title>
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
    nav ul li {
      display: inline;
    }
    nav ul li a {
      color: #FFA3A3;
      text-decoration: none;
      font-size: 20px;
    }
    .main {
      background-color: #FF7E7E;
      padding: 40px 0;
      display: flex;
      justify-content: center;
    }
    .cards {
      display: flex;
      justify-content: space-between;
      gap: 50px;
      max-width: 900px;
      width: 100%;
    }
    .card {
      background-color: #FFB3B3;
      padding: 30px;
      text-align: center;
      width: 250px;
      height: 120px;
      border-radius: 20px;
      box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-size: 18px;
      color: #5B0A29;
      font-weight: bold;
    }
    .card a {
      display: inline-block;
      margin-top: 10px;
      background-color: #5B0A29;
      color: #FFA3A3;
      padding: 8px 15px;
      border-radius: 10px;
      text-decoration: none;
      font-size: 16px;
    }
    .card a:hover {
      background-color: #7E0E3B;
    }
    .footer {
      background-color: #5B0A29;
      color: #FFB3B3;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 520px;
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
        <li><a href="formulario.php">Teste de personalidade</a></li>
        <li><a href="plano.php">Teste de inteligencia</a></li>
         <li><a href="sonhos.php">Quem sou eu?</a></li>
        <li><a href="logout.php" style="color: #FFA3A3; font-size: 20px;">Sair</a></li>
      </ul>
    </nav>
  </div>

  <!-- Conteúdo Principal -->
  <div class="main">
    <div class="cards">
      <div class="card">
    Teste de personalidade
        <a href="formulario.php">Acessar</a>
      </div>
      <div class="card">
       Quem sou eu?
        <a href="sonhos.php">Acessar</a>
      </div>
      <div class="card">
       Teste de inteligencia
        <a href="plano.php">Acessar</a>
      </div>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2025 Projeto de Vida. Todos os direitos reservados.</p>
  </footer>

</body>
</html>
