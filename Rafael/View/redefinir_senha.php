<?php
require '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $novaSenha = trim($_POST['nova_senha']);

    // Verifica se o email existe
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Atualiza a senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET senha = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$senhaHash, $email]);

        echo "<p style='color: green;'>Senha redefinida com sucesso. <a href='index.php'>Voltar ao login</a></p>";
    } else {
        echo "<p style='color: red;'>E-mail não encontrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div>
        <h1 class="titulo">Redefinir Senha</h1>
    </div>

    <div class="cabecalho">
        <form class="formulario" method="POST">
            <h2>Digite seu e-mail e nova senha</h2>
            <input type="email" name="email" placeholder="Email cadastrado" class="input-grande" required>
            <input type="password" name="nova_senha" placeholder="Nova senha" class="input-grande" required>
            <button><a href="../index.php">Redefinir</a></button>
        </form>
    </div>

</body>
</html>
