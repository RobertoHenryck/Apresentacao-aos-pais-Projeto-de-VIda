<?php
require '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se todos os campos foram preenchidos
    if (!isset($_POST['name'], $_POST['email'], $_POST['senha'], $_POST['data']) || 
        empty(trim($_POST['name'])) || empty(trim($_POST['email'])) || empty(trim($_POST['senha'])) || empty(trim($_POST['data']))) {
        echo "<p style='color: red;'>Todos os campos são obrigatórios!</p>";
        exit;
    }

    $nome = trim($_POST['name']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data = $_POST['data'];

    // Verifica se o e-mail já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<p style='color: red;'>Este e-mail já está cadastrado!</p>";
        exit;
    }

    // Insere no banco de dados
    $foto_padrao = 'image.png'; // Caminho da imagem padrão

    $sql = "INSERT INTO users (nome, email, senha, data_nascimento, foto_perfil, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$nome, $email, $senha, $data, $foto_padrao]);
        header("Location: ../index.php"); // Redireciona para a tela de login
        exit;
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
    }
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastrar.css">
    <title>PROJETO DE VIDA</title>
</head>
<body>

    <div>
        <h1 class="titulo">INSIRA SEUS DADOS PARA 
            CRIAR UMA CONTA
        </h1>
    </div>

    <div class="cabecalho">
        <form class="formulario" method="POST" action="">
            <h2>Insira seus Dados</h2>

            <input type="text" name="name" placeholder="Digite seu nome" class="input-grande" required>
            <input type="email" name="email" id="email" placeholder="Email" class="input-grande" required>
            <input type="password" name="senha" id="senha" placeholder="Senha" class="input-grande" required>
            <input type="date" name="data" placeholder="Data de Nascimento" class="input-grande" required>

            <button type="submit" class="botao">Cadastrar-se</button>
            <a href="../index.php" class="botao" style="display: block; text-align: center; margin-top: 10px;">Já tem conta? Entrar</a>

            <div class="social-login">
                <button type="button" class="botao-social">Login Facebook</button>
                <button type="button" class="botao-social" style="margin-top: 10px;">Login Google</button>
            </div>
        </form>
    </div>

</body>
</html>

