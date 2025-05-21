<?php
session_start();

require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['data_nascimento'] = $usuario['data_nascimento'];

            header('Location: PaginaInicial.php');
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/index.css">
    <title>Login</title>

 <style>
    
    button {
    width: 100%;
    padding: 10px;
    background-color: #7e7e86;
    border: none;
    border-radius: 5px;
    color:white;
    font-size: 16px;
    cursor: pointer;
}
button:hover{
     background-color: #7e7e86;
   font-size: 20px;
   transition: 0.9s;
}
 </style>
    
</head>
<body>

<form method="POST">
    <h1>LOGIN</h1>
    <p>E-mail</p>
    <input type="email" name="email" placeholder="Email" required>
    <p>Senha</p>
    <input type="password" name="senha" placeholder="Senha" required>
    <div class="botao">
            <button  type="submit">Entrar</button>
    </div>


  
    <?php if (isset($erro)) echo "<div class='mensagem-erro'><p>$erro</p></div>"; ?>

    <p><a href="CadastrarUsuario.php">Não tem uma conta? Cadastre-se aqui</a></p>
</form>

</body>
</html>
