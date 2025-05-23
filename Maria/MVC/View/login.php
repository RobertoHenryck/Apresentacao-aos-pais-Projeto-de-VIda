<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Apresentacao-aos-pais-Projeto-de-VIda\Maria\MVC\config\config.php';

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

            header('Location: inicio.php');
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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="#" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Platypi:ital,wght@0,300..800;1,300..800&display=swap');

        body {
            font-family: "Platypi", serif;
            background-color: #FF7E7E;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }

        .header {
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 20px;
            font-weight: bold;
            color: #4D0028;
        }

        .form-container {
            background-color: #5B0A29;
            padding: 50px;
            border-radius: 30px;
            color: #FFA3A3;
            width: 350px;
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

        button {
            background-color: #FF7E7E;
            color: #5B0A29;
            padding: 8px 30px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 18px;
            font-family: "Platypi", serif;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background-color: #FFC1C1;
        }

        .forgot-password,
        .no-account {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .forgot-password a,
        .no-account a {
            color: #4D0028;
            text-decoration: none;
        }

        .forgot-password a:hover,
        .no-account a:hover {
            text-decoration: underline;
        }

        .erro {
            color: white;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">Projeto de vida</div>

    <div class="form-container">
        <h2>LOGIN</h2>
        <?php if (isset($erro)) echo "<div class='erro'>$erro</div>"; ?>

        <form action="" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <div class="button-container">
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>

    <div class="forgot-password">
        <a href="senha.php">ESQUECI MINHA SENHA</a>
    </div>

    <div class="no-account">
        <a href="cadastro.php">NÃO POSSUO CADASTRO</a>
    </div>

</body>

</html>