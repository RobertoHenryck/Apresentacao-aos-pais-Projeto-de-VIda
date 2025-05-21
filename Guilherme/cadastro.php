<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Cadastro - Projeto de Vida</title>
</head>

<body>


    <main class="log">
        <section>

            <div>
                <div class="login">
                    <h1>CADASTRAR</h1>
                </div>

                <div class="corpologin">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <label for="nome">Nome</label>
                        <div><input type="text" name="nome" required></div>
                        <br>

                        <label for="data_nascimento">Data de nascimento</label>
                        <div><input type="date" name="data_nascimento" required></div>
                        <br>

                        <label for="sobre_mim">Sobre mim</label>
                        <div><input type="text" name="sobre_mim" required></div>

                        <br>

                        <label for="email">Email</label>
                        <div><input type="email" name="email" required></div>
                        <br>

                        <label for="senha">Senha</label>
                        <div><input type="password" name="senha" required></div>
                        <br>
                        <div class="buton">
                            <button type="submit">CADASTRAR</button>
                        </div>
                        <br>
                        <div class="link">
                            <div><b>Já tem uma conta? <a href="index.php">Clique aqui para entrar</a></b>
                            </div>
                        </div>
                    </form>


                    <?php

                    session_start();

                    if (isset($_SESSION["logado"])) {
                        header("Location: index.php");
                    }

                    require_once("Controller/UsuarioController.php");





                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                   
                        $controller = new UsuarioController($pdo);
                        $controller->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['data_nascimento'], $_POST['sobre_mim']);


                        echo "<div class='avisocadastro'>";
                        echo "Cadastrado com Sucesso";
                        echo "</div>";

                        header("Location: index.php");
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