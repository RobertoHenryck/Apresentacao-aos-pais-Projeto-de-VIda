<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php'; // Ajuste conforme a estrutura do seu projeto

$msg = ''; // Variável para exibir mensagens de erro ou sucesso

// Verifica se a requisição foi feita via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Etapa 1: Usuário envia o e-mail
  if (isset($_POST['email']) && !isset($_POST['nova_senha'])) {
    $email = trim($_POST['email']); // Obtém o e-mail do formulário

    // Verifica se o e-mail existe no banco de dados
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Se o e-mail for encontrado no banco de dados
    if ($stmt->rowCount() > 0) {
      $_SESSION['redefinir_email'] = $email; // Armazena o e-mail na sessão
    } else {
      $msg = "E-mail não encontrado."; // Mensagem de erro
    }
  }

  // Etapa 2: Usuário envia a nova senha
  if (isset($_POST['nova_senha']) && isset($_SESSION['redefinir_email'])) {
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT); // Criptografa a nova senha
    $email = $_SESSION['redefinir_email']; // Recupera o e-mail da sessão

    // Atualiza a senha do usuário no banco de dados
    $stmt = $pdo->prepare("UPDATE users SET senha = :senha WHERE email = :email");
    $stmt->bindParam(':senha', $nova_senha);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Mensagem de sucesso
    $msg = "Senha redefinida com sucesso!";
    unset($_SESSION['redefinir_email']); // Limpa a variável de sessão
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Redefinir Senha</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Platypi', serif;
      background-color: #fc8087;
    }

    header {
      padding: 20px;
      font-weight: bold;
      font-size: 24px;
      color: #560726;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 80vh;
    }

    .box {
      background-color: #560726;
      border-radius: 25px;
      padding: 40px;
      text-align: center;
      width: 350px;
      color: #fc8087;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 20px;
      background: transparent;
      border: none;
      border-bottom: 2px solid #fc8087;
      color: #fc8087;
      font-size: 14px;
      outline: none;
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

    p.msg {
      color: white;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <header>Projeto de Vida</header>

  <div class="container">
    <div class="box">
      <h2>Redefinir Senha</h2>
      <p class="msg"><?= $msg ?></p>

      <form method="POST">
        <!-- Exibe o campo de e-mail apenas se não estiver na sessão de redefinição -->
        <?php if (!isset($_SESSION['redefinir_email'])): ?>
          <p>Informe o e-mail para redefinir a senha:</p>
          <input type="email" name="email" required placeholder="Seu e-mail" />
          <button type="submit">Avançar</button>
          <br>
          <a href="login.php">voltar</a>  
        <?php else: ?>
          <!-- Exibe o campo para digitar a nova senha -->
          <p>Digite sua nova senha:</p>
          <input type="password" name="nova_senha" required placeholder="Nova senha" />
          <button type="submit">Redefinir</button>
          <br>
          <a href="login.php">voltar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
</body>

</html>