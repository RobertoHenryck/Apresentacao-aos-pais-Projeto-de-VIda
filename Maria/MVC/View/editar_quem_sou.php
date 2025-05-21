<?php
session_start();
require 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM sonhos WHERE usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Quem Sou</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
<style> 


* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Platypi', serif;
  background-color: #FF7E7E;
}

/* Cabeçalho */
header {
  background-color: #5B0A29;
  color: #fcb3b3;
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.left-header {
  display: flex;
  flex-direction: column;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
}

.user-info img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid white;
}

.user-text {
  display: flex;
  flex-direction: column;
}

.user-text a {
  color: #fcb3b3;
  font-size: 14px;
  text-decoration: underline;
}

/* Navegação */
nav a {
  margin-left: 20px;
  text-decoration: none;
  color: #fcb3b3;
  font-size: 18px;
}

/* Conteúdo principal */
.container {
  display: flex;
  justify-content: space-around;
  padding: 40px;
  align-items: flex-start;
}

/* Foto de perfil */
.profile-photo {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.profile-photo img {
  width: 130px;
  height: 130px;
  border-radius: 50%;
  background-color: #ccc;
  object-fit: cover;
}

/* Seções do formulário e descrição */
.form-section,
.about-section {
  color: #5B0A29;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.form-section h2,
.about-section h2 {
  font-size: 22px;
  margin-bottom: 20px;
}

.form-section div p {
  margin: 8px 0;
}

.about-section p {
  width: 250px;
  background-color: #fca0a0;
  border-radius: 25px;
  padding: 15px;
  white-space: pre-line;
}

/* Rodapé */
.footer {
  background-color: #5B0A29;
  color: #FFB3B3;
  text-align: center;
  padding: 15px;
  font-size: 14px;
  margin-top: 200px;
}
/* Centralização geral */
.centralizado {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Botão personalizado */
.botao {
  background-color: #5B0A29;
  color: #fcb3b3;
  border: none;
  padding: 12px 24px;
  border-radius: 25px;
  font-size: 16px;
  font-family: 'Platypi', serif;
  cursor: pointer;
  margin-top: 20px;
  transition: background-color 0.3s ease;
}

.botao:hover {
  background-color: #7a143a;
}



</style> 
</head>
<body>
  <h2>Editar informações de "Quem sou"</h2>
  <form action="salvar_quem_sou.php" method="post">
    <label>Aspirações:</label><br>
    <input type="text" name="aspiracoes" value="<?= htmlspecialchars($dados['aspiracoes'] ?? '') ?>"><br><br>

    <label>O que ainda vou fazer:</label><br>
    <input type="text" name="sonhos_hoje" value="<?= htmlspecialchars($dados['sonhos_hoje'] ?? '') ?>"><br><br>

    <label>Meus sonhos de infância:</label><br>
    <input type="text" name="infancia" value="<?= htmlspecialchars($dados['infancia'] ?? '') ?>"><br><br>

    <label>O que já estou fazendo:</label><br>
    <input type="text" name="faco_agora" value="<?= htmlspecialchars($dados['faco_agora'] ?? '') ?>"><br><br>

    <label>Meus sonhos hoje:</label><br>
    <input type="text" name="vou_fazer" value="<?= htmlspecialchars($dados['vou_fazer'] ?? '') ?>"><br><br>

    <label>Profissão dos sonhos:</label><br>
    <input type="text" name="profissao" value="<?= htmlspecialchars($dados['profissao'] ?? '') ?>"><br><br>

    <button type="submit">Salvar</button>
  </form>


</body>
</html>
