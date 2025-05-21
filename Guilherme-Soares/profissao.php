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
    <title>Document</title>
</head>

<body>
    <header>



        <h1>Profissão</h1>



        <div class="menu">

            <a href="painel.php">
                <div>Inicio</div>
            </a>

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
        <section class="section">
            <div>
                <h2>Análise e Desenvolvimento de Sistemas</h2>
                <p>O mercado de trabalho para o profissional de Análise e Desenvolvimento de Sistemas é propício para atuação, logo que é uma das áreas que envolve tecnologia e atualmente a dinâmica social e comercial é regida através dela.</p><br>

                <p>De tal maneira que antes de concluir o curso o aluno já pode está ingressando no mercado de trabalho. Por ser uma profissão que pode atender vários segmentos o profissional não fica limitado, podendo atuar em:</p><br>
                <li>Indústria; </li>
                <li>Negócios; </li>
                <li> Empresas de tecnologia, entre outros.</li>

                <p> Já que sua atuação é responsável pelos sistemas e verificar os processos (projetar, documentar, especificar, testar, implantar e na manutenção).

                    Além de está associado a uma empresa é possível trabalhar de maneira autônoma e sem dúvidas não falta oportunidade de trabalho, pois cada vez mais necessita da tecnologia em vários setores.

                    Segundo um relatório realizado pelo Instituto de Pesquisa Econômica Aplicada (Ipea) a Análise e desenvolvimento de sistemas é uma das principais geradoras de emprego de 2009 e 2012, responsável por empregar 49.535 pessoas.
                </p><br>
                <h2>Como está o mercado de trabalho em Análise e Desenvolvimento de Sistemas</h2><br>

                <p>Hoje em dia o Análise e Desenvolvimento de Sistemas é uma das atividades mais procuradas pelas empresas. Porque a era é guiada pelos meios de produção e as relações sociais estão cada vez mais orientadas pela tecnologia, fazendo que seja uma profissão promissora, pois a demanda por profissionais das áreas cresce ainda mais.

                    E para aumentar as chances do profissional ter uma oportunidade de emprego é que existem poucos profissionais nesta área, sendo que a demanda é grande e tem poucas pessoas capazes para desempenhar essa função. Tudo isso torna um mercado de trabalho abrangente e sem muita competição.

                    Aliás com a pandemia a tecnologia que já era muito usada se tornou ainda mais, visto que muito do comportamento humano e das atividades tradicionais precisaram ser reinventadas. Diante disso, a procura por profissionais de TI aumentou ainda mais, pois foi necessário se adaptar à nova realidade e usá-la a favor.
                </p><br>
                <h2> Quem se forma em Análise e Desenvolvimento de Sistema trabalha onde</h2><br><br>
                <p>Hoje em dia todas as empresas e organizações tanto privada quanto públicas necessitam de um sistema e artefatos tecnológicos que possam auxiliar na sua rotina, por isso o analista pode atuar:</p>

                <li>Indústria;</li>
                <li>Comércios;</li>
                <li>Empresas;</li>
                <li>Instituições públicas ou privadas.</li><br><br>
                <p> Há inúmeras formas para atuar no mercado nessa área, além que alguns optam por fornecer seus serviços de maneira autônoma, possibilitando mais flexibilidade e independência.</p>
            </div>
        </section>
        <section class="section">
            <div>
                <h2>Principais áreas de atuação</h2>
                <p>Existem algumas áreas de atuação que é comum encontrar profissionais dessa área. Dentre elas estão:</p>

                <h3>Desenvolvimento de Software</h3>
                <p>Muitas empresas precisam de software que possa auxiliar na rotina empresarial, dessa forma o profissional dessa área vai usar de códigos e linguagem da programação para criar uma sequência lógica para apresentação de resultados.

                    Nesse sentido, os analistas podem se especializar em desenvolver programas operacionais para celulares, internet, caixas automáticos, tablets e muito mais, já que há uma gama de linguagens de programação que podem ser usadas para determinados fins.
                </p>
                <h3>Administração de Bancos de dados</h3>
                <p>Não é somente ter um programa é necessário gerir e com isso os analistas vão criar bancos de dados, capazes de armazenar informações importantes. Além disso, vai monitorar o uso, verificando a necessidade de atualizações, manutenções e melhorias.

                    Com a intenção de manter segura as informações do software.
                </p>
                <h3>Administrador de redes</h3>
                <p>Nesta área o analista é responsável pela infraestrutura de TI de toda a empresa. Desse modo instalações, parametrizações e configurações dos sistemas já contidos serão monitorados por ele.

                    Ainda mais, vai garantir estabilidade para o sistema e o cuidado para manter as informações seguras da rede.
                </p>
                <h3>Produção de software </h3>
                <p>Nesse seguimento o analista precisa ter domínio sobre os processos de implementação, arquitetura, desenvolvimento, testes e evoluções dos sistemas de software. Dessa forma precisa ter conhecimento em engenharia de software para conseguir dar conta de todo o processo que vai passar para a sua criação.
                </p>
                <h3>Infraestrutura de TI</h3>
                <p>Será o responsável pela implementação das soluções computacionais ou seja vai usar de recurso de hardware, sendo os parques computacionais, infraestrutura de rede, integração entre hardware e software. Nesse sentido será um facilitador para empresas, atendendo suas necessidades tecnológicas.
                </p>
                <h3>Negócios</h3>
                <p>O analista pode participar diretamente dos negócios da empresa através das reuniões e briefings com os clientes, com a intenção de apresentar os requisitos e especificar o uso, tornando ainda mais compreensível a atuação dele na empresa.

                    Para desempenhar bem essa parte, é preciso que o analista de sistemas entenda de negócios, assim ele poderá otimizar e atrair ainda mais.
                </p>


            </div>
        </section>

        <section class="section">
            <div>
                <h2>Salário</h2>
                <p>O salário de um profissional de Análise e Desenvolvimento de Sistemas pode variar de acordo com a experiência, a localização e a área de atuação. No geral, DEVs formados recentemente, como técnicos ou assistentes, tendem a começar com uma remuneração entre R$ 3.000 e R$ 4.500. Com o tempo e o avanço na carreira, os analistas do nível pleno e sênior e especializados podem alcançar faixas salariais entre R$ 7.000 e R$ 10.000.</p>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div>
            <p> © Todos os direitos reservados</p>
        </div>
    </footer>
</body>

</html>