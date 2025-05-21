<?php
session_start();
require_once 'config.php';
require_once 'Controller/UsuarioController.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['usuario_id'];

   
    $respostas = [
        $_POST['q1'], $_POST['q2'], $_POST['q3'], $_POST['q4'], $_POST['q5'], $_POST['q6'], $_POST['q7'], $_POST['q8'],
        $_POST['q9'], $_POST['q10'], $_POST['q11'], $_POST['q12'], $_POST['q13'], $_POST['q14'], $_POST['q15'], $_POST['q16']
    ];

    // Mapeia as respostas para traços de personalidade
    $pontuacao = array_count_values($respostas);

    // Determina o tipo de personalidade
    if (($pontuacao['A'] ?? 0) >= 10) {
        $resultado = "Líder Visionário - Você gosta de desafios e de inspirar pessoas.";
    } elseif (($pontuacao['B'] ?? 0) >= 10) {
        $resultado = "Analítico e Prático - Você é focado em lógica e organização.";
    } elseif (($pontuacao['C'] ?? 0) >= 10) {
        $resultado = "Criativo e Comunicativo - Você gosta de inovação e interação.";
    } else {
        $resultado = "Equilibrado e Adaptável - Você consegue se ajustar a qualquer situação.";
    }

    // Salva os dados no banco de dados
    $sql = "INSERT INTO teste_personalidade (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, resultado, data)
            VALUES (:user_id, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :q11, :q12, :q13, :q14, :q15, :q16, :resultado, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':q1' => $respostas[0], ':q2' => $respostas[1], ':q3' => $respostas[2], ':q4' => $respostas[3],
        ':q5' => $respostas[4], ':q6' => $respostas[5], ':q7' => $respostas[6], ':q8' => $respostas[7],
        ':q9' => $respostas[8], ':q10' => $respostas[9], ':q11' => $respostas[10], ':q12' => $respostas[11],
        ':q13' => $respostas[12], ':q14' => $respostas[13], ':q15' => $respostas[14], ':q16' => $respostas[15],
        ':resultado' => $resultado
    ]);

    // Redireciona para a página de resultado
    header("Location: resultado_personalidade.php?tipo=" . urlencode($resultado));
    exit;
}
$controller = new UsuarioController($pdo);
$foto_perfil = $controller->getFotoPerfil($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
     <script src="https://kit.fontawesome.com/11db660343.js" crossorigin="anonymous"></script>
    <title>Teste de Personalidade</title>
</head>
<body>

<header>


        <div class="menu">

            <a href="painel.php">
                <div>Início</div>
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

    <h2>Teste de Personalidade</h2>
    <form method="POST">
        <?php
        $perguntas = [
            "Como você resolve problemas?",
            "Qual atividade você prefere?",
            "O que mais te motiva?",
            "Como você lida com desafios?",
            "O que mais te irrita?",
            "Como você trabalha em equipe?",
            "Como reage a mudanças?",
            "O que é mais importante para você?",
            "Como você se descreve?",
            "Como você toma decisões?",
            "Prefere trabalhar sozinho ou em equipe?",
            "O que mais te estressa?",
            "Qual tipo de tarefa prefere?",
            "O que te faz sentir realizado?",
            "Como lida com pressão?",
            "Qual característica mais te define?"
        ];

        $opcoes = [
            ["A - Analítico", "B - Criativo", "C - Social", "D - Prático"],
            ["A - Planejamento", "B - Artes", "C - Conversar", "D - Construir"],
            ["A - Resolver problemas", "B - Criar algo novo", "C - Ajudar pessoas", "D - Resultados"],
            ["A - Estratégia", "B - Intuição", "C - Trabalho em equipe", "D - Ação"],
            ["A - Falta de lógica", "B - Falta de inovação", "C - Falta de empatia", "D - Falta de praticidade"],
            ["A - Organizado", "B - Inspirador", "C - Comunicativo", "D - Objetivo"],
            ["A - Analisando", "B - Experimentando", "C - Perguntando", "D - Agindo"],
            ["A - Conhecimento", "B - Criatividade", "C - Pessoas", "D - Eficiência"],
            ["A - Racional", "B - Sonhador", "C - Emocional", "D - Determinado"],
            ["A - Com dados", "B - Por intuição", "C - Em grupo", "D - Pela experiência"],
            ["A - Sozinho", "B - Tanto faz", "C - Em equipe", "D - Depende"],
            ["A - Falta de controle", "B - Rotina monótona", "C - Distância de pessoas", "D - Ineficiência"],
            ["A - Análises", "B - Criatividade", "C - Comunicação", "D - Resultados"],
            ["A - Resolver problemas", "B - Expressar-se", "C - Relacionar-se", "D - Produzir"],
            ["A - Calmamente", "B - Criativamente", "C - Conversando", "D - Ativamente"],
            ["A - Lógico", "B - Inovador", "C - Empático", "D - Determinado"]
        ];

        for ($i = 0; $i < 16; $i++) {
            echo "<p>" . ($i + 1) . ". " . $perguntas[$i] . "</p>";
            foreach ($opcoes[$i] as $opcao) {
                echo "<input type='radio' name='q" . ($i + 1) . "' value='" . substr($opcao, 0, 1) . "' required> $opcao <br>";
            }
        }
        ?>
        <div class="buton"><button type="submit">Enviar Respostas</button></div>
    </form>
</section>
</main>
 <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>
</html>
