<?php
session_start();
require_once 'config.php';
require_once 'Controller/UsuarioController.php';

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
    $sql = "INSERT INTO teste_inteligencias (user_id, " . implode(",", array_map(fn($i) => "q$i", range(1, 16))) . ", resultado)
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
    <title>Teste de Múltiplas Inteligências</title>
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
                    echo"<div class='botaoteste'>";
                    echo "<input type='radio' name='q" . ($index + 1) . "' value='$key' required> $value ";
                    echo"</div>";
                }
                echo "<br><br>";
            }
            ?>

            <br>
            <div class="buton"><button type="submit">Enviar</button></div>
        </form>
    </section>

    </main>
 <footer class="footer">
       <div> <p > © Todos os direitos reservados</p></div>
    </footer>
</body>

</html>