<?php
require_once 'config.php';
require_once 'Controller/UsuarioController.php';


session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($usuario['nome']) ?></title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>

</head>

<header>



    <h1>Atualize seu perfil</h1>



    <div class="menu">

        <a href="painel.php">
            <div>Início</div>
        </a>

        <a href="index.php">
            <div><i class="fa-solid fa-right-from-bracket"></i></div>
        </a>
    </div>

</header>

<body>
    <main class="perfil">
        <section class="contperfil">
            <div class="corpologin">




            <form action="" method="post" enctype="multipart/form-data">

                <label for="name">Nome</label>
                <input type="text" name="nome"><br>

                <label for="email">Email</label>
                 <input type="email" name="email"><br>

               <label for="senha">Senha</label>
               <input type="password" name="senha"><br>

                <label for="data_nascimento">Data de nascimento</label>
                <input type="date" name="data_nascimento"><br>

                <label for="name">Sobre mim</label> <input class="peni" name="sobre_mim"><br>
</div>
        </section>
        <section class="contperfil">

            <div class="fotoperfil"><img src="<?= $foto_perfil ?>" alt=""></div>
            Foto de Perfil: <input type="file" name="foto_perfil"><br>

            <div class="buton"><button type="submit">Atualizar Perfil</button></div>
            </form>

            <?php

            if (!empty($_POST)) {

                $id = $_SESSION['usuario_id']; // ID do usuário

                // Dados enviados via POST
                $nome = $_POST['nome'] ?? null;
                $email = $_POST['email'] ?? null;
                $data_nascimento = $_POST['data_nascimento'] ?? null;
                $sobre_mim = $_POST['sobre_mim'] ?? null;
                $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

                // Verifica se foi feito upload de imagem
                $foto_perfil = null;
                if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                    $nome_arquivo = uniqid() . '_' . basename($_FILES['foto_perfil']['name']);
                    $caminho = __DIR__ . '/uploads/' . $nome_arquivo;

                    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho)) {
                        $foto_perfil = 'uploads/' . $nome_arquivo;
                    }
                }

                // Monta a SQL dinamicamente
                $campos = [];
                if ($nome) $campos[] = "nome = :nome";
                if ($email) $campos[] = "email = :email";
                if ($data_nascimento) $campos[] = "data_nascimento = :data_nascimento";
                if ($sobre_mim) $campos[] = "sobre_mim = :sobre_mim";
                if ($senha) $campos[] = "senha = :senha";
                if ($foto_perfil) $campos[] = "foto_perfil = :foto_perfil";

                if (empty($campos)) {
                    echo "<div class='avisoneutro'>";
                    echo "Nenhum dado para atualizar.";
                    echo "</div>";
                    exit;
                }

                $sql = "UPDATE users SET " . implode(", ", $campos) . " WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                // Bind dos parâmetros
                $stmt->bindParam(':id', $id);
                if ($nome) $stmt->bindParam(':nome', $nome);
                if ($email) $stmt->bindParam(':email', $email);
                if ($data_nascimento) $stmt->bindParam(':data_nascimento', $data_nascimento);
                if ($sobre_mim) $stmt->bindParam(':sobre_mim', $sobre_mim);
                if ($senha) $stmt->bindParam(':senha', $senha);
                if ($foto_perfil) $stmt->bindParam(':foto_perfil', $foto_perfil);

                // Executa a atualização
                if ($stmt->execute()) {
                    echo "<div class='avisocadastro'>";
                    echo "Perfil atualizado com sucesso!";
                    echo "</div>";
                } else {
                    echo "<div class'aviso'>";
                    echo "Erro ao atualizar o perfil.";
                    echo "</div>";
                }
            }



            ?>
        </section>
    </main>
    <footer class="footer">
        <div>
            <p> © Todos os direitos reservados</p>
        </div>
    </footer>

</body>



</html>