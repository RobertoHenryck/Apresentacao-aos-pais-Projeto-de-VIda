<?php
require_once "config.php";
require_once "Controller/UsuarioController.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['operacao'] === 'criar') {


    // Preparar a SQL com placeholders
    $stmt = $pdo->prepare("
        INSERT INTO perfil_usuario (
            nome, idade, sexo, sobre_voce, lembrancas,
            pontos_fortes, pontos_fracos, valores, aptidoes, familia, amigos, escola, sociedade,
            gostos, nao_gostos, rotina, lazer, estudos, vida_escolar,
            visao_fisica, visao_intelectual, visao_emocional,
            visao_amigos, visao_familia, visao_professores,
            autoestima, autoconfianca,
            aspiracoes, sonho_infancia, profissao_desejada,
            sonho_1, faco_sonho_1, preciso_sonho_1,
            objetivo_curto, objetivo_medio, objetivo_longo,
            visao_10_anos
        ) VALUES (
            :nome, :texto, :assunto, :idade, :sexo, :sobre_voce, :lembrancas,
            :pontos_fortes, :pontos_fracos, :valores, :aptidoes, :familia, :amigos, :escola, :sociedade,
            :gostos, :nao_gostos, :rotina, :lazer, :estudos, :vida_escolar,
            :visao_fisica, :visao_intelectual, :visao_emocional,
            :visao_amigos, :visao_familia, :visao_professores,
            :autoestima, :autoconfianca,
            :aspiracoes, :sonho_infancia, :profissao_desejada,
            :sonho_1, :faco_sonho_1, :preciso_sonho_1,
            :objetivo_curto, :objetivo_medio, :objetivo_longo,
            :visao_10_anos
        )
    ");

    // Executar a query com os dados do formulário
    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':idade' => $_POST['idade'],
        ':sexo' => $_POST['sexo'],
        ':sobre_voce' => $_POST['sobre_voce'],
        ':lembrancas' => $_POST['lembrancas'],
        ':pontos_fortes' => $_POST['pontos_fortes'],
        ':pontos_fracos' => $_POST['pontos_fracos'],
        ':valores' => $_POST['valores'],
        ':aptidoes' => $_POST['aptidoes'],
        ':familia' => $_POST['familia'],
        ':amigos' => $_POST['amigos'],
        ':escola' => $_POST['escola'],
        ':sociedade' => $_POST['sociedade'],
        ':gostos' => $_POST['gostos'],
        ':nao_gostos' => $_POST['nao_gostos'],
        ':rotina' => $_POST['rotina'],
        ':lazer' => $_POST['lazer'],
        ':estudos' => $_POST['estudos'],
        ':vida_escolar' => $_POST['vida_escolar'],
        ':visao_fisica' => $_POST['visao_fisica'],
        ':visao_intelectual' => $_POST['visao_intelectual'],
        ':visao_emocional' => $_POST['visao_emocional'],
        ':visao_amigos' => $_POST['visao_amigos'],
        ':visao_familia' => $_POST['visao_familia'],
        ':visao_professores' => $_POST['visao_professores'],
        ':autoestima' => $_POST['autoestima'],
        ':autoconfianca' => $_POST['autoconfianca'],
        ':aspiracoes' => $_POST['aspiracoes'],
        ':sonho_infancia' => $_POST['sonho_infancia'],
        ':profissao_desejada' => $_POST['profissao_desejada'],
        ':sonho_1' => $_POST['sonho_1'],
        ':faco_sonho_1' => $_POST['faco_sonho_1'],
        ':preciso_sonho_1' => $_POST['preciso_sonho_1'],
        ':objetivo_curto' => $_POST['objetivo_curto'],
        ':objetivo_medio' => $_POST['objetivo_medio'],
        ':objetivo_longo' => $_POST['objetivo_longo'],
        ':visao_10_anos' => $_POST['visao_10_anos']
    ]);
}



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
     <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <title>Quem sou eu?</title>
</head>

<body>

    <header>



        <h1>Formulário</h1>



        <div class="menu">

            <a href="sobremim.php">
                <div>Sobre mim</div>
            </a>

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
            <div >
                <div>
                    <form method="POST">
                        <h2>Quem Sou Eu?</h2>

                        <!-- Dados Pessoais -->
                         <div class="quemsou">
                        <h3>Dados Pessoais</h3>
                        <input name="nome" placeholder="Nome">
                        <input name="idade" placeholder="Idade">
                        <input name="sexo" placeholder="Sexo">
                    </div>

                        <!-- Fale sobre você --> 
                         <div class="quemsou">
                        <h3>Fale sobre você</h3>
                        <textarea name="sobre_voce" placeholder="Fale um pouco sobre você..."></textarea>
                    </div>

                        <!-- Minhas Lembranças -->
                          <div class="quemsou">
                        <h3>Minhas Lembranças</h3>
                        <textarea name="lembrancas" placeholder="Suas lembranças marcantes..."></textarea>
                    </div>

                        <!-- Pontos Fortes e Fracos -->
                          <div class="quemsou">
                        <h3>Pontos Fortes</h3>
                        <input name="pontos_fortes" placeholder="Liste suas qualidades">
                        <h3>Pontos Fracos</h3>
                        <input name="pontos_fracos" placeholder="Liste suas dificuldades">
                    </div>

                        <!-- Meus Valores -->
                          <div class="quemsou">
                        <h3>Meus Valores</h3>
                        <input name="valores" placeholder="Ex: Respeito, Honestidade, Amor...">
                    </div>

                        <!-- Minhas Aptidões -->
                          <div class="quemsou">
                        <h3>Minhas Principais Aptidões</h3>
                        <select name="aptidoes">
                            <option value="Liderança">Liderança</option>
                            <option value="Criatividade">Criatividade</option>
                            <option value="Resolução de Problemas">Resolução de Problemas</option>
                            <option value="Comunicação">Comunicação</option>
                        </select>
                    </div>


                        <!-- Meus Relacionamentos -->
                          <div class="quemsou">
                        <h3>Meus Relacionamentos</h3>
                        <input name="familia" placeholder="Relação com a família">
                        <input name="amigos" placeholder="Relação com os amigos">
                        <input name="escola" placeholder="Relação com a escola">
                        <input name="sociedade" placeholder="Relação com a sociedade">
                    </div>

                        <!-- Meu Dia a Dia -->
                          <div class="quemsou">
                        <h3>Meu Dia a Dia</h3>
                        <input name="gostos" placeholder="O que gosto de fazer">
                        <input name="nao_gostos" placeholder="O que não gosto de fazer">
                        <input name="rotina" placeholder="Descreva sua rotina">
                        <input name="lazer" placeholder="Atividades de lazer">
                        <input name="estudos" placeholder="Como você estuda?">
                    </div>

                        <!-- Minha Vida Escolar -->
                          <div class="quemsou">
                        <h3>Minha Vida Escolar</h3>
                        <textarea name="vida_escolar" placeholder="Fale sobre sua vida escolar..."></textarea>
                    </div>

                        <!-- Minha Visão Sobre Mim -->
                          <div class="quemsou">
                        <h3>Minha Visão Sobre Mim</h3>
                        <input name="visao_fisica" placeholder="Visão sobre seu corpo físico">
                        <input name="visao_intelectual" placeholder="Visão sobre sua mente">
                        <input name="visao_emocional" placeholder="Visão sobre seus sentimentos">
                    </div>

                        <!-- A Visão das Pessoas Sobre Mim -->
                          <div class="quemsou">
                        <h3>A Visão das Pessoas Sobre Mim</h3>
                        <input name="visao_amigos" placeholder="O que os amigos dizem">
                        <input name="visao_familia" placeholder="O que a família diz">
                        <input name="visao_professores" placeholder="O que os professores dizem">
                    </div>

                        <!-- Autovalorização -->
                         <div class="quemsou">
                        <h3>Autovalorização</h3>

                        <input name="autoestima" placeholder="Autoestima de 1 a 10">
                        <input name="autoconfianca" placeholder="Autoconfiança de 1 a 10">
                    </div>

                        <h2>Módulo 2: Planejamento de Futuro</h2>

                        <!-- Minhas Aspirações -->
                          <div class="quemsou">
                        <h3>Minhas Aspirações</h3>
                        <textarea name="aspiracoes" placeholder="O que você aspira para seu futuro?"></textarea>
                    </div>

                        <!-- Meu Sonho de Infância -->
                         <div class="quemsou">
                        <h3>Meu Sonho de Infância</h3>
                         
                        <textarea name="sonho_infancia" placeholder="O que você sonhava ser quando criança?"></textarea>
                    </div>

                        <!-- Escolha Profissional --> 
                        <div class="quemsou">
                        <h3>Escolha Profissional</h3>

                        <input name="profissao_desejada" placeholder="Digite a profissão que você deseja">
                    </div>

                        <!-- Meus Sonhos Hoje -->
                         <div class="quemsou">
                        <h3>Meus Sonhos Hoje</h3>
                         
                        <input name="sonho_1" placeholder="Sonho atual 1">
                        <input name="faco_sonho_1" placeholder="O que já faço por ele?">
                        <input name="preciso_sonho_1" placeholder="O que ainda preciso fazer?">
                    </div>

                        <!-- Meus Principais Objetivos -->
                         <div class="quemsou">
                        <h3>Meus Principais Objetivos</h3>
                         
                        <input name="objetivo_curto" placeholder="Objetivo para 1 ano">
                        <input name="objetivo_medio" placeholder="Objetivo para 3 anos">
                        <input name="objetivo_longo" placeholder="Objetivo para 7 anos">
                    </div>

                        <!-- Visão de Futuro -->
                          <div class="quemsou">
                        <h3>Como me imagino daqui 10 anos?</h3>
                        <textarea name="visao_10_anos" placeholder="Descreva sua vida ideal daqui 10 anos..."></textarea>
                    </div>

                        <!-- Botão de envio -->
                        <input type="hidden" name="operacao" value="criar">
                        <div class="buton"><button type="submit">Salvar Tudo</button>
                    
                    </form>

                </div>
            </div>
        </section>
    </main>
     <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>

</html>