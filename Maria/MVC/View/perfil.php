<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

$usuario_id = $_SESSION['usuario_id'];
$msg = '';

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $data_nascimento = $_POST['data_nascimento'] ?? '';
  $senha = $_POST['senha'] ?? '';
  $sobre_mim = $_POST['sobre_mim'] ?? '';
  $foto_perfil = null;

  // Upload da imagem
  if (!empty($_FILES['foto_perfil']['name'])) {
    $arquivo_tmp = $_FILES['foto_perfil']['tmp_name'];
    $nome_arquivo = uniqid() . '_' . $_FILES['foto_perfil']['name'];
    $destino = 'uploads/' . $nome_arquivo;

    if (move_uploaded_file($arquivo_tmp, $destino)) {
      $foto_perfil = $destino;
    }
  }

  $sql = "UPDATE users SET nome = :nome, email = :email, data_nascimento = :data_nascimento, sobre_mim = :sobre_mim"
       . ($foto_perfil ? ", foto_perfil = :foto_perfil" : "")
       . ($senha ? ", senha = :senha" : "") . " WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':data_nascimento', $data_nascimento);
  $stmt->bindParam(':sobre_mim', $sobre_mim);
  if ($foto_perfil) $stmt->bindParam(':foto_perfil', $foto_perfil);
  if ($senha) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt->bindParam(':senha', $senha_hash);
  }
  $stmt->bindParam(':id', $usuario_id);
  $stmt->execute();

  $msg = "Dados atualizados com sucesso!";
}

$stmt = $pdo->prepare("SELECT nome, email, data_nascimento, sobre_mim, foto_perfil FROM users WHERE id = :id");
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Platypi', serif;
      background-color: #FF7E7E;
      color: #5B0A29;
    }

    header {
      background-color: #5B0A29;
      color: #FFB3B3;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    nav a {
      color: #FFB3B3;
      margin-left: 20px;
      text-decoration: none;
      font-size: 18px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      padding: 40px;
    }

    .profile-photo,
    .form-fields,
    .sobre-mim {
      flex: 1 1 250px;
      margin: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .profile-photo img {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      object-fit: cover;
      background-color: #ccc;
    }

    label[for="foto_perfil"] {
      margin-top: 10px;
      text-decoration: underline;
      cursor: pointer;
    }

    input[type="file"] {
      display: none;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    textarea {
      width: 100%;
      max-width: 300px;
      border: none;
      border-bottom: 2px solid #5B0A29;
      background: transparent;
      padding: 8px;
      font-size: 16px;
      margin-bottom: 15px;
    }

    textarea {
      height: 150px;
      resize: none;
      background-color: #fca0a0;
      border-radius: 20px;
      padding: 10px;
    }

    button {
      background-color: #5B0A29;
      color: #fca0a0;
      border: none;
      padding: 10px 25px;
      border-radius: 20px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 20px;
    }

    .msg {
      text-align: center;
      font-size: 18px;
      color: green;
      margin-top: 20px;
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

    .footer {
      background-color: #5B0A29;
      color: #FFB3B3;
      text-align: center;
      padding: 20px;
      font-size: 15px;
      margin-top: 400px;
    }
  </style>
<header>
  <div class="left-header">
    <div class="logo">Projeto de vida</div>
    <div class="user-info">
    <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
      <div class="user-text">
      <?php echo htmlspecialchars($usuario['nome']); ?>
        <a href="perfil2.php">perfil</a>
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

<form method="POST" enctype="multipart/form-data">
  <div class="container">

    <!-- Foto -->
    <div class="profile-photo">
      <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'https://via.placeholder.com/130') ?>" alt="Foto de perfil">
      <label for="foto_perfil">Alterar foto de perfil</label>
      <input type="file" name="foto_perfil" id="foto_perfil">
    </div>

    <!-- Campos -->
    <div class="form-fields">
      <h2>Informações Pessoais</h2>
      <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" placeholder="Nome" required>
      <input type="date" name="data_nascimento" value="<?= $usuario['data_nascimento'] ?>" required>
      <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" placeholder="Email" required>
      <input type="password" name="senha" placeholder="Nova senha (opcional)">
    </div>

    <!-- Sobre -->
    <div class="sobre-mim">
      <h2>Sobre Mim</h2>
      <textarea name="sobre_mim" placeholder="Conte sobre você..."><?= htmlspecialchars($usuario['sobre_mim']) ?></textarea>
    </div>

  </div>

  <div style="text-align: center;">
    <button type="submit">Salvar Alterações</button>
  </div>
</form>

<?php if ($msg): ?>
  <p class="msg"><?= $msg ?></p>
<?php endif; ?>

<div class="footer">
  &copy; <?= date('Y') ?> Projeto de Vida. Todos os direitos reservados.
</div>

</body>
</html>
