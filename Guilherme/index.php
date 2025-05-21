<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <main class="log">
        <section>
            <div>


                <div class="login">
                    <h1>LOGIN</h1>
                </div>

                <div class="corpologin">

                    <form method="POST">

                        <label for="email">E-mail</label>
                        <div><input type="email" name="email" id="email"></div><br><br>

                        <label for="senha">Senha</label>
                        <div><input type="password" name="senha" id="senha"></div><br><br>

                        <div class="buton"><button type="submit">Entrar</button></div>



                    </form>
                    <div class="link">
                        <div><b> <a href="esquecisenha.php">Esqueci senha</a></b></div>
                        <div><b>Não tem conta? <a href="cadastro.php">Clique aqui para cadastrar</a></b></div>

                    </div>


                    <?php
                    session_start();
                    include 'config.php'; // Inclui a conexão com o banco de dados

                    // Verifica se o formulário foi enviado
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $email = $_POST['email'];
                        $senha = $_POST['senha'];

                        // Verifica se os campos não estão vazios
                        if (empty($email) || empty($senha)) {
                            echo "<div class='aviso'> ";
                            echo "Por favor, preencha todos os campos!";
                            echo "</div>";
                        } else {
                            // Prepara a consulta SQL para verificar se o usuário existe
                            $sql = "SELECT * FROM users WHERE email = :email";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                            $stmt->execute();


                            // Verifica se o usuário existe
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($usuario) {
                                // Verifica se a senha informada corresponde à senha armazenada no banco de dados
                                if (password_verify(
                                    $senha,
                                    $usuario['senha']
                                )) {
                                    // Login bem-sucedido
                                    $_SESSION['usuario_id'] = $usuario['id'];
                                    $_SESSION['usuario_email'] = $usuario['email'];
                                    header('Location: painel.php'); // Redireciona para a página do painel
                                    exit;
                                } else {
                                    // Senha incorreta
                                    echo "<div class='aviso'>";
                                    echo "Senha incorreta!";
                                    echo "</div>";
                                }
                            } else {
                                // Usuário não encontrado
                                echo "<div class='aviso'>";
                                echo "Usuário não encontrado!";
                                echo "</div>";
                            }
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