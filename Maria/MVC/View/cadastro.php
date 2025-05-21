<?php
session_start();

require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Corrigido os nomes conforme os campos do formulário
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $data_nascimento = $_POST['data_nascimento'];
  $senha = $_POST['senha'];

  // Verificar se o email já está cadastrado
  $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':email', $email);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $erro = "Este email já está cadastrado!";
  } else {
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir usuário no banco de dados
    $sql = "INSERT INTO users (nome, email, data_nascimento, senha) 
            VALUES (:nome, :email, :data_nascimento, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':senha', $senha_criptografada);

    if ($stmt->execute()) {
      $_SESSION['usuario_nome'] = $nome;
      $_SESSION['usuario_email'] = $email;
      $_SESSION['data_nascimento'] = $data_nascimento;

      header('Location: login.php');
      exit;
    } else {
      $erro = "Erro ao cadastrar o usuário. Tente novamente!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Platypi', serif;
      background-color: #FF7E7E;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }

    .header {
      position: absolute;
      top: 15px;
      left: 20px;
      font-size: 20px;
      font-weight: bold;
      color: #4D0028;
    }

    .form-container {
      background-color: #5B0A29;
      padding: 40px;
      border-radius: 15px;
      color: #FFA3A3;
      width: 400px;
      text-align: center;
      box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    label {
      display: block;
      text-align: left;
      font-size: 16px;
      margin-top: 15px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: none;
      border-bottom: 2px solid #FFA3A3;
      background: transparent;
      color: #FFA3A3;
      font-size: 16px;
    }

    input:focus {
      outline: none;
      border-bottom: 2px solid #FFC1C1;
    }

    .button-container {
      margin-top: 20px;
      text-align: center;
    }


    button:hover {
      background-color: #7E0E3B;
    }

    .erro {
      color: #FFDADA;
      margin-bottom: 15px;
    }
    button,a {
      background-color: #fc8087;
      color: #560726;
      border: none;
      padding: 6px 20px;
      border-radius: 20px;
      font-family: 'Platypi', serif;
      font-size: 14px;
      cursor: pointer;
      text-decoration: none;
      margin: 20px;
      
    }
  </style>
</head>

<body>

  <div class="header">Projeto de vida</div>

  <div class="form-container">
    <h2>CADASTRE-SE</h2>

    <?php if (!empty($erro)): ?>
      <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <label for="nome">Nome de usuário</label>
      <input type="text" id="nome" name="nome" required>

      <label for="data_nascimento">Data de nascimento</label>
      <input type="date" id="data_nascimento" name="data_nascimento" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required>

      <div class="button-container">
        <button type="submit">Próximo</button>
        <a href="login.php">fazer login</a>
      </div>
    </form>
  </div>
</body>
</html>
