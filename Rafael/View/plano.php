<?php
session_start();

require_once '../auth.php';
require_once '../conexao.php';

atualizarFotoSessao($conn); // Isso vem depois da conexão


if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$id_usuario = $_SESSION['id'];

$mensagem = "";
$dados_preenchidos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dados_preenchidos = $_POST;
    $dados_json = json_encode($_POST, JSON_UNESCAPED_UNICODE);

    try {
        $stmt = $conn->prepare("INSERT INTO planos (id_usuario, dados) VALUES (:id_usuario, :dados)");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':dados', $dados_json, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $mensagem = "<p class='mensagem sucesso'>Plano salvo com sucesso!</p>";
        } else {
            $mensagem = "<p class='mensagem erro'>Erro ao salvar o plano.</p>";
        }
    } catch (PDOException $e) {
        $mensagem = "<p class='mensagem erro'>Erro ao salvar: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

$areas = [
    "Relacionamento Familiar",
    "Estudos",
    "Saúde",
    "Futura Profissão",
    "Religião (opcional)",
    "Amigos",
    "Namorado(a) (opcional)",
    "Comunidade",
    "Tempo Livre"
];
?>


<!-- HTML permanece o mesmo -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Projeto de Vida</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         <style>
    /* Estilos gerais do corpo da página */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
}

h1 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    color: black;
}

/* Cabeçalho da página */
.principal {
    background-color: #004080;
    color: white;
    padding: 20px 0;
}

.cabecalho {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.img2 {
    height: 80px;
}

.imgs {
    width: 80px;
    height: 80px;
    transition: transform 0.2s;
}

.imgs:hover {
    transform: scale(1.05);
}

/* Formulário */
form {
    max-width: 900px;
    margin: 30px auto;
    background-color: #004080;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

fieldset {
    margin-bottom: 25px;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px;
}

legend {
    font-weight: bold;
    color: white;
    font-size: 18px;
    margin-bottom: 15px;
}

label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: bold;
    color: white;
}

input[type="text"],
input[type="date"],
input[type="email"],
textarea,
select {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border 0.2s;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="email"]:focus,
textarea:focus,
select:focus {
    border-color: #004080;
    outline: none;
}

textarea {
    resize: vertical;
}

/* Botões */
button {
    background-color: #004080;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    display: block;
    margin: 30px auto;
    width: 60%;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #003366;
}

button:focus {
    outline: none;
}

/* Botões de navegação */
.voltar-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    background-color: #004080;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.voltar-btn:hover {
    background-color: #003366;
}

.voltar-btn:focus {
    outline: none;
}

/* Containers para as seções */
.container {
    background-color: white;
    color: white;
    padding: 30px 0;
}

/* Mensagens de sucesso e erro */
.mensagem {
    text-align: center;
    font-weight: bold;
    margin-top: 20px;
}

.mensagem.sucesso {
    color: green;
}

.mensagem.erro {
    color: red;
}




</style>
    </style>
</head>
<body>

<?php include 'topo.php'; ?>

<?= $mensagem ?>

<h1>O QUE DEVO FAZER PARA MELHORAR MEU:</h1>

<div class="container">
    <form method="POST">
        <?php foreach ($areas as $area): 
            $name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $area)); ?>
            <fieldset>
                <legend><?= $area ?></legend>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <label>Passo <?= $i ?>:</label>
                    <input type="text" name="<?= "{$name}_passo_$i" ?>" 
                        value="<?= isset($dados_preenchidos["{$name}_passo_$i"]) ? htmlspecialchars($dados_preenchidos["{$name}_passo_$i"]) : '' ?>">
                <?php endfor; ?>
                <label>Como irei fazer?</label>
                <textarea name="<?= "{$name}_como_fazer" ?>" rows="3"><?= isset($dados_preenchidos["{$name}_como_fazer"]) ? htmlspecialchars($dados_preenchidos["{$name}_como_fazer"]) : '' ?></textarea>
                <label>Prazo:</label>
                <input type="date" name="<?= "{$name}_prazo" ?>" 
                    value="<?= isset($dados_preenchidos["{$name}_prazo"]) ? htmlspecialchars($dados_preenchidos["{$name}_prazo"]) : '' ?>">
            </fieldset>
        <?php endforeach; ?>
        <button type="submit">Salvar Plano de Ação</button>
    </form>
    <a href="inicio.php">
        <button>Voltar ao Início</button>
    </a>
</div>

</body>
</html>
