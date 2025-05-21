<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

// Buscar os dados do usuário
$id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT foto_perfil FROM users WHERE id = ?");
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
        body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f0f2f5;
}

.principal {
    background: linear-gradient(to right, #003366, #0059b3);
    color: white;
    padding: 20px 0;
}

.cabecalho {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.img2 {
    height: 70px;
}

.imgs {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.2s ease-in-out;
}

.imgs:hover {
    transform: scale(1.1);
}

h1 {
    font-size: 28px;
    text-align: center;
    flex: 1;
}

.assunto {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 900px;
    margin: 30px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 0px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.assunto:hover {
    transform: translateY(-3px);
}

.assunto h3 {
    font-size: 22px;
    color: #333;
}

.assunto img {
    height: 65px;
    border-radius: 50%;
}

.assunto2 {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 25px auto;
    padding: 18px 35px;
    border-radius: 25px;
    background-color: #0066cc;
    width: fit-content;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.assunto2 a {
    text-decoration: none;
    color: white;
    font-size: 20px;
    font-weight: bold;
}

.assunto2:hover {
    background-color: #004d99;
    transform: scale(1.05);
}

</style>

</head>

<body>
    <header class="principal">
        <div class="cabecalho">
            <img class="img2" src="../DALL·E 2025-03-26 07.40.11 - A modern and inspiring logo for a website about _Projeto de Vida_ (Life Project). The logo should feature a clean, minimalist design with vibrant colo-Photoroom (2).png" alt="Logo Projeto de Vida">
            <h1>MEU PROJETO DE VIDA</h1>

            <?php
$foto = '../' . ($usuario['foto_perfil'] ?? 'image.png');
if (!file_exists($foto)) {
    $foto = '../image.png'; // Caminho da imagem padrão
}
?>

<a href="perfil.php">
    <img class="imgs" src="<?= htmlspecialchars($foto) ?>" alt="Foto de Perfil">
</a>

        </div>
    </header>

    <main>
        <div class="assunto">
            <h3>Quem sou eu?</h3>
            <a href="quemsu.php"><img class="imgs" src="../image copy.png" alt="Quem Sou Eu"></a>
        </div>

        <div class="assunto">
            <h3>Planejamento do Futuro</h3>
            <a href="planejamento.php"><img class="imgs" src="../image copy 2.png" alt="Planejamento"></a>
        </div>

        <div class="assunto">
            <h3>Plano de Ação</h3>
            <a href="plano.php"><img class="imgs" src="../image copy 3.png" alt="Plano de Ação"></a>
        </div>

        <div class="assunto2">
            <a href="testepers.php">Teste de Personalidade</a>
        </div>

        <div class="assunto2">
            <a href="quiz.php">Quiz Sobre Projeto de Vida</a>
        </div>
    </main>
</body>
</html>
