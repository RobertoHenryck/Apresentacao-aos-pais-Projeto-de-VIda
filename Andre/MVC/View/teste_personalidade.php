<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['usuario_id'];


    $respostas = [
        $_POST['q1'],
        $_POST['q2'],
        $_POST['q3'],
        $_POST['q4'],
        $_POST['q5'],
        $_POST['q6'],
        $_POST['q7'],
        $_POST['q8'],
        $_POST['q9'],
        $_POST['q10'],
        $_POST['q11'],
        $_POST['q12'],
        $_POST['q13'],
        $_POST['q14'],
        $_POST['q15'],
        $_POST['q16']
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
        ':q1' => $respostas[0],
        ':q2' => $respostas[1],
        ':q3' => $respostas[2],
        ':q4' => $respostas[3],
        ':q5' => $respostas[4],
        ':q6' => $respostas[5],
        ':q7' => $respostas[6],
        ':q8' => $respostas[7],
        ':q9' => $respostas[8],
        ':q10' => $respostas[9],
        ':q11' => $respostas[10],
        ':q12' => $respostas[11],
        ':q13' => $respostas[12],
        ':q14' => $respostas[13],
        ':q15' => $respostas[14],
        ':q16' => $respostas[15],
        ':resultado' => $resultado
    ]);

    // Redireciona para a página de resultado
    header("Location: resultado_personalidade.php?tipo=" . urlencode($resultado));
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/teste_personalidade.css">
    <title>Teste de Personalidade</title>
</head>

<body>

    <h2>Teste de Personalidade</h2>
    <form method="POST">
        <?php
        $perguntas = [
            "Como você costuma resolver um problema difícil?",
            "Qual dessas atividades te deixa mais animado?",
            "O que te motiva a sair da cama todos os dias?",
            "Quando algo inesperado acontece, o que você faz primeiro?",
            "O que mais te incomoda em outras pessoas?",
            "Como você costuma agir em trabalhos em grupo?",
            "Quando algo muda de repente, como você reage?",
            "Qual desses valores representa melhor você?",
            "Como você se enxerga na maioria das vezes?",
            "Qual é o seu jeito preferido de tomar decisões importantes?",
            "Você prefere trabalhar em qual dessas situações?",
            "O que costuma te deixar mais estressado?",
            "Que tipo de tarefa você sente mais facilidade em fazer?",
            "O que te traz mais satisfação ao final do dia?",
            "Como você lida com situações de muita pressão?",
            "Qual dessas palavras melhor define sua personalidade?"
        ];

        $opcoes = [
            ["A - De forma lógica e estratégica", "B - Usando criatividade", "C - Conversando com alguém", "D - Agindo rapidamente"],
            ["A - Resolver enigmas ou desafios", "B - Criar algo artístico", "C - Estar com amigos", "D - Cumprir metas práticas"],
            ["A - Superar obstáculos", "B - Ter novas ideias", "C - Estar com pessoas", "D - Alcançar resultados"],
            ["A - Analiso a situação", "B - Confio na intuição", "C - Converso com os outros", "D - Tomo uma atitude"],
            ["A - Falta de lógica", "B - Falta de originalidade", "C - Falta de empatia", "D - Falta de ação"],
            ["A - Organizado e focado", "B - Traz novas ideias", "C - Ouve e colabora", "D - Objetivo e direto"],
            ["A - Penso antes de reagir", "B - Vejo como oportunidade", "C - Busco apoio", "D - Me adapto e sigo em frente"],
            ["A - Conhecimento", "B - Criatividade", "C - Conexões humanas", "D - Eficiência"],
            ["A - Frio e racional", "B - Imaginativo", "C - Sensível e acolhedor", "D - Focado e prático"],
            ["A - Com base em dados", "B - Pela minha intuição", "C - Depois de ouvir opiniões", "D - Pelo que funcionou antes"],
            ["A - Sozinho, com foco", "B - Onde posso criar", "C - Com outras pessoas", "D - Onde há objetivos claros"],
            ["A - Perder o controle", "B - Ficar preso à rotina", "C - Se sentir isolado", "D - Falta de resultado"],
            ["A - Análises e pesquisas", "B - Expressar ideias", "C - Comunicar-se bem", "D - Produzir resultados"],
            ["A - Resolver algo complexo", "B - Criar algo novo", "C - Ajudar alguém", "D - Concluir tarefas"],
            ["A - Com calma e estratégia", "B - Pensando fora da caixa", "C - Buscando apoio emocional", "D - Agindo com rapidez"],
            ["A - Lógico", "B - Inovador", "C - Empático", "D - Determinado"]
        ];
        

        for ($i = 0; $i < 16; $i++) {
            echo "<p>" . ($i + 1) . ". " . $perguntas[$i] . "</p>";
            foreach ($opcoes[$i] as $opcao) {
                echo "<input type='radio' name='q" . ($i + 1) . "' value='" . substr($opcao, 0, 1) . "' required> $opcao <br>";
            }
        }
        ?>
        <button type="submit">Enviar Respostas</button>
    </form>

</body>

</html>