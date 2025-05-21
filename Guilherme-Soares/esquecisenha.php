
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main class="log">
        <section>
            <div>

           <div class="login"> <h1>Alterar Senha</h1></div>

           <div class="corpologin">
            <form method="POST">
                <label for="email">E-mail cadastrado:</label>
                <input type="email" id="email" name="email" required>

                <label for="new_password">Nova Senha:</label>
                <input type="password" id="new_password" name="new_password" required>

                <div class="buton"><button type="submit">Alterar Senha</button></div>
            </div>
            </form>
            

            <div>

            <?php
session_start();
include_once 'C:/Turma2/xampp/htdocs/ProjetoVida/Controller/UsuarioController.php';
include_once 'C:/Turma2/xampp/htdocs/ProjetoVida/config.php';

$Controller = new UsuarioController($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verificar se o e-mail e senha atual estão corretos
    $stmt = $pdo->prepare("SELECT id, senha FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $new_password != $user['password']) {
        $stmt = $pdo->prepare("UPDATE users SET senha = ? WHERE id = ?");
        $stmt->execute([$new_password, $user['id']]);

        echo "<p>Senha alterada com sucesso!</p>";
        header("Location: index.php");
    } else {
        echo "<div class='aviso'>";
        echo "<p>E-mail incorreto!</p>";
        echo "</div>";
    }
}

?>





            </div>

        </div>
        </section>
    </main>
     <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>

</html>