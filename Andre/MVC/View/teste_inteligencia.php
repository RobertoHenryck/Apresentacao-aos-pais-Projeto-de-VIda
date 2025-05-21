<?php
session_start();

require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['usuario_id'];

    $respostas = [];
    for ($i = 1; $i <= 16; $i++) {
        $respostas[$i] = isset($_POST["q$i"]) ? $_POST["q$i"] : "N";
    }

    // Mapeia cada pergunta a um tipo de inteligência
    $mapa_inteligencias = [
        1 => "musical",
        2 => "logico",
        3 => "corporal",
        4 => "linguistica",
        5 => "interpessoal",
        6 => "intrapessoal",
        7 => "naturalista",
        8 => "emocional",
        9 => "musical",
        10 => "logico",
        11 => "corporal",
        12 => "linguistica",
        13 => "interpessoal",
        14 => "intrapessoal",
        15 => "naturalista",
        16 => "emocional"
        
    ];

    // Inicializa a contagem de pontuações
    $pontuacoes = array_fill_keys(array_values($mapa_inteligencias), 0);

    // Atribui 1 ponto para cada resposta "A"
    foreach ($respostas as $num => $resposta) {
        if ($resposta == 'A') {
            $tipo = $mapa_inteligencias[$num];
            $pontuacoes[$tipo]++;
        }
    }

    $resultado_json = json_encode($pontuacoes);

    // Insere no banco de dados
    $sql = "INSERT INTO teste_inteligencia (user_id, " . implode(",", array_map(fn($i) => "q$i", range(1, 16))) . ", resultado)
            VALUES (:user_id, " . implode(",", array_map(fn($i) => ":q$i", range(1, 16))) . ", :resultado)";
    
    $stmt = $pdo->prepare($sql);
    $params = [':user_id' => $user_id, ':resultado' => $resultado_json];
    for ($i = 1; $i <= 16; $i++) {
        $params[":q$i"] = $respostas[$i];
    }
    $stmt->execute($params);

    // Redireciona para página de resultado
    $last_id = $pdo->lastInsertId();
    header("Location: resultado_inteligencias.php?id=$last_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/teste_inteligencia.css">
    <title>Teste de Múltiplas Inteligências</title>
</head>
<body>

    <h2>Teste de Múltiplas Inteligências</h2>
    <form method="POST">

        <?php
        $perguntas = [
            "Gosto de aprender ouvindo músicas e sons.",
            "Tenho facilidade em resolver problemas matemáticos.",
            "Prefiro atividades físicas e esportes.",
            "Aprendo melhor lendo e escrevendo.",
            "Gosto de trabalhar em equipe e conversar com outras pessoas.",
            "Gosto de refletir sobre meus sentimentos e pensamentos.",
            "Tenho uma conexão forte com a natureza e os animais.",
            "Percebo rapidamente as emoções das pessoas ao meu redor.",
            "Sou bom em reconhecer padrões musicais e ritmos.",
            "Adoro quebra-cabeças e desafios lógicos.",
            "Tenho facilidade para aprender coreografias e movimentos.",
            "Gosto de contar histórias e escrever textos.",
            "Sou bom em falar e convencer as pessoas.",
            "Prefiro atividades individuais e gosto de momentos de reflexão.",
            "Tenho curiosidade sobre o meio ambiente e como as coisas funcionam.",
            "Entendo facilmente o comportamento e expressões das pessoas."
        ];

        $opcoes = ["A" => "Sim", "B" => "Não"];

        // Exibindo as perguntas com numeração correta
        foreach ($perguntas as $index => $pergunta) {
            // A numeração começa de 1 e incrementa
            echo "<p>" . ($index + 1) . ". " . $pergunta . "</p>";  
            // Exibindo as opções de resposta
            foreach ($opcoes as $key => $value) {
                echo "<input type='radio' name='q" . ($index + 1) . "' value='$key' required> $value ";
            }
            echo "<br><br>";
        }
        ?>

        <br>
        <button type="submit">Enviar</button>
    </form>

</body>
</html>
