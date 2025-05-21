<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT resultado FROM resultados WHERE user_id = ? ORDER BY data_resposta DESC LIMIT 1");
$stmt->execute([$id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Nenhum resultado encontrado.";
    exit;
}

$perfil = $result['resultado'];

$descricoes = [
    'A' => [
        'titulo' => 'Você é uma pessoa que busca propósito!',
        'descricao' => 'Você está em uma jornada de autoconhecimento e quer alinhar sua vida com seus valores mais profundos. Está focado em encontrar sentido nas suas escolhas e viver com intenção.'
    ],
    'B' => [
        'titulo' => 'Você é determinado e ambicioso!',
        'descricao' => 'Você gosta de metas claras e desafios. Está sempre em busca de crescimento profissional e pessoal, e não tem medo de se dedicar para alcançar seus sonhos.'
    ],
    'C' => [
        'titulo' => 'Você valoriza equilíbrio e bem-estar!',
        'descricao' => 'Você preza pela tranquilidade, qualidade de vida e harmonia nas suas relações. Busca um estilo de vida leve, mas com significado.'
    ],
];

if (!isset($descricoes[$perfil])) {
    echo "Resultado inválido.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seu Resultado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #BFBFBF;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .resultado-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }

        h1 {
            color: #2c3e50;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        a:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="resultado-container">
        <h1><?= $descricoes[$perfil]['titulo'] ?></h1>
        <p><?= $descricoes[$perfil]['descricao'] ?></p>
        <a href="inicio.php">Voltar para o inicio</a>
    </div>
</body>
</html>
