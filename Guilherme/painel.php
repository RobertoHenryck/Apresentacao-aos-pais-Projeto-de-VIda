<?php
require_once 'Controller/UsuarioController.php';
require_once 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=H1, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>


    <header>



        <h1>Bem vindo</h1>



        <div class="menu">

            <a href="sobremim.php"><div>Sobre mim</div></a>
            
            <div class="image">

                <a href="perfil.php">
                    <div><img src="<?= $foto_perfil ?>" alt=""></div>
                </a>
            </div>

            <a href="index.php"> <div><i class="fa-solid fa-right-from-bracket"></i> </div></a>
        </div>

    </header>

    <main>
        <section class="section">
            <div class="teste">

                <div>
                    <a href="teste_inteligencia.php">
                        <div><img src="img/9-tipos-de-inteligencia.webp" alt=""></div>
                        <h2>Teste de inteligência</h2>
                    </a>
                </div>



            </div>

            <div class="teste">

                <div>
                    <a href="teste_personalidade.php">
                        <div><img src="img/o_que_e_a_dominancia_cerebral_250_0_600.jpg" alt=""></div>
                        <h2>Teste de personalidade</h2>
                    </a>
                </div>


            </div>
        </section>
    </main>

    <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>

</html>