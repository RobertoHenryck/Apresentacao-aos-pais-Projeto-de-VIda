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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
     <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <title>Quem sou eu</title>
</head>

<body>

    <header>



        <h1>Sobre mim</h1>



        <div class="menu">

            <a href="painel.php">
                <div>Inicio</div>
            </a>

             <a href="profissao.php"><div>Profissão</div></a>

              <a href="quemsoueu.php"><div>Quem sou eu?</div></a>

            <div class="image">

                <a href="perfil.php">
                    <div><img src="<?= $foto_perfil ?>" alt=""></div>
                </a>
            </div>

            <a href="index.php">
                <div><i class="fa-solid fa-right-from-bracket"></i></div>
            </a>
        </div>

    </header>

    <main>

    
        <section>

        <div class="foto"><img src="img/download.png" alt="">Guilherme Soares de Oliveira</div>
            <div>

                <h2>Minhas inspirações</h2>
                <p>Ter uma carreira profissional, na qual possa ser feliz e garantir um amplo network, crescer e viver
                    confortavelmente. </p>


            </div>
            <br><br>



            <div>

                <h2>Meu sonho de infância</h2>
                <p>Tinha sonho de ser policial ou bombeiro, áreas que ajudavam pessoas, quando um pouco mais velho,
                    jogador de futebol.</p>


            </div>

            <br><br>

            <div>
                <h2>Meus sonhos hoje</h2>
                <h3>Passar em uma boa faculdade</h3>

                  <p>  O que já estou fazendo: Preparando com estudos para o Enem ou vestibulares.

                    O que ainda preciso fazer: Abdicar da procrastinação e me dedicar mais ao estudo.</p>
            </div>

            <br><br>

            <div>
                <h2>Meus principais objetivos</h2>
                
                <h3>Curto prazo</h3>

                  <p> Entrar em uma faculdade, trabalhar e tirar CNH.</p>

                  <h3>Médio prazo</h3>
                  <p>Ganhando bem, com um emprego estável.</p>

                  <h3>Longo prazo</h3>
                  <p>Estar bem com minha família, saudável, cuidando de meus pais.</p>

                  <h3>Em dez anos...</h3>
                  <p>Daqui a dez anos, espero ser um homem mais sábio, calmo e com muito vigor, para melhorar sempre. </p>
            </div>
            <br><br>
        </section>



        <div class="profissao">
            <a href="profissao.php">
                <section>

                    <div>

                        <h2>Profissão</h2>
                        <p>Detalhes, áreas de atuação, salários.</p>


                    </div>

                </section>
            </a>
        </div>

        <div class="profissao">
            <a href="quemsoueu.php">
                <section>

                    <div>

                        <h2>Quem sou eu?</h2>
                        <p>Formulário visando compreender a si mesmo.</p>


                    </div>

                </section>
            </a>
        </div>
        
    </main>

 <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>

</html>