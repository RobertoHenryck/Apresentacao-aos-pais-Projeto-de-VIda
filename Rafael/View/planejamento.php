<?php
session_start();
require '../conexao.php';

require_once '../auth.php';
atualizarFotoSessao($conn); // Atualiza a foto de perfil da sessão


if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$mensagem = '';
$mensagemCor = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function post($key) {
        return isset($_POST[$key]) ? trim($_POST[$key]) : null;
    }

    $id = $_SESSION['id'];

    $dados = [
        'meusonho' => post('meusonho'),
        'escolha' => post('escolha'),
        'listesonho' => post('listesonho'),
        'oquejafaz' => post('oquejafaz'),
        'alcancar' => post('alcancar'),
        'objetivodecurtoprazo' => post('objetivodecurtoprazo'),
        'objetivodemedioprazo' => post('objetivodemedioprazo'),
        'objetivodelongoprazo' => post('objetivodelongoprazo'),
        'daquidezanos' => post('daquidezanos'),
    ];

    $campos = array_keys($dados);
    $placeholders = array_map(fn($campo) => "$campo = ?", $campos);
    $sql = "UPDATE users SET " . implode(', ', $placeholders) . " WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $valores = array_values($dados);
    $valores[] = $id;

    try {
        $stmt->execute($valores);
        $mensagem = "Dados salvos com sucesso!";
        $mensagemCor = "green";
    } catch (PDOException $e) {
        $mensagem = "Erro ao salvar os dados: " . $e->getMessage();
        $mensagemCor = "red";
    }
}

// Recuperar dados do banco
$id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Projeto de Vida</title>
    <link rel="stylesheet" href="inicio.css">

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
    color: #004080;
    font-size: 18px;
    margin-bottom: 15px;
}

label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #004080;
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

button a {
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
    text-decoration: none;
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
    background-color: #004080;
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

.voltar-btn {
    
    margin-top: 20px;
    padding: 12px 25px;
    background-color: #004080;
    color: white;
    border: none;
    border-radius: 10px;
    width: fit-content;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

    </style>
</head>
<body>

<?php include 'topo.php'; ?>

<div class="form-container">
    <h1>Planejamento do Futuro</h1>

    <?php if ($mensagem): ?>
        <p class="mensagem" style="color: <?= $mensagemCor ?>;"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="POST">
        <h2>Meu Sonho de Infância</h2>
        <textarea name="meusonho"><?= htmlspecialchars($usuario['meusonho'] ?? '') ?></textarea>

        <h2>Escolha Profissional</h2>
        <textarea name="escolha"><?= htmlspecialchars($usuario['escolha'] ?? '') ?></textarea>

        <h2>Meus Sonhos Hoje</h2>
        <div class="sonhos">
            <input type="text" name="listesonho" placeholder="Liste Seus Sonhos" value="<?= htmlspecialchars($usuario['listesonho'] ?? '') ?>">
            <input type="text" name="oquejafaz" placeholder="O que você já está fazendo" value="<?= htmlspecialchars($usuario['oquejafaz'] ?? '') ?>">
            <input type="text" name="alcancar" placeholder="O que falta para alcançar" value="<?= htmlspecialchars($usuario['alcancar'] ?? '') ?>">
        </div>

        <h2>Meus Objetivos</h2>
        <input type="text" name="objetivodecurtoprazo" placeholder="Curto Prazo" value="<?= htmlspecialchars($usuario['objetivodecurtoprazo'] ?? '') ?>">
        <input type="text" name="objetivodemedioprazo" placeholder="Médio Prazo" value="<?= htmlspecialchars($usuario['objetivodemedioprazo'] ?? '') ?>">
        <input type="text" name="objetivodelongoprazo" placeholder="Longo Prazo" value="<?= htmlspecialchars($usuario['objetivodelongoprazo'] ?? '') ?>">
        <input type="text" name="daquidezanos" placeholder="Como você se vê daqui a 10 anos" value="<?= htmlspecialchars($usuario['daquidezanos'] ?? '') ?>">

        <button type="submit">Salvar</button>
    

    <button><a href="inicio.php">Voltar ao Inicio</a></button>
</div>
</form>
</body>
</html>
