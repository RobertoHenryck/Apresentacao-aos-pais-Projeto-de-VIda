<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<p style='color: red;'>Usuário não encontrado!</p>";
        exit;
    }

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['id'] = $usuario['id'];
        header("Location: View/inicio.php"); // Redireciona corretamente agora
        exit;
    } else {
        echo "<p style='color: red;'>Email ou senha incorretos!</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>PROJETO DE VIDA</title>
</head>

<body>

    <div>
        <h1 class="titulo">QUE TAL SE CADASTRAR E CONHECER <br>
            MELHOR MEU PROJETO DE VIDA!</h1>
    </div>

    <div class="cabecalho">
        <form class="formulario" method="POST" action="">
            <h2>Insira seus Dados</h2>


            <input type="email" name="email" id="email" placeholder="Email" class="input-grande" required>
            <input type="password" name="senha" id="senha" placeholder="Senha" class="input-grande" required>

            <button class="botao" type="submit">Entrar</button>
            <a href="View/cadastrar.php" class="botao"
                style="display: block; text-align: center; margin-top: 10px;">Cadastrar-se</a>

                <a href="View/redefinir_senha.php" class="botao" style="display: block; text-align: center; margin-top: 10px;">Esqueci minha senha</a>


            <div class="social-login" style="margin-top: 20px;">
                <button class="botao-social" type="button">Login Facebook</button>
                <button class="botao-social" type="button" style="margin-top: 10px;">Login Google</button>
            </div>
        </form>
    </div>

</body>

</html>