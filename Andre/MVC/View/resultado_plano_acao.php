<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\MVC\Controller\Controller.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

// Áreas de plano de ação
$areas = ['Relacionamento Familiar', 'Estudos'];

$planos_acao = [];

foreach ($areas as $area) {
    $area_underscore = str_replace(' ', '_', $area);
    $sql = "SELECT descricao, prazo, passo1, passo2, passo3 FROM plano_acao WHERE user_id = :user_id AND area = :area";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':area', $area);
    $stmt->execute();
    $planos_acao[$area_underscore] = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/resultado_plano_acao.css">
    <title>Plano de Ação - Listagem</title>
    <style>
    a{
        display:flex;
        justify-content: center;
        text-decoration: none;
        color:black;
    }
</style>
</head>
<body>
    <h1>Planos de Ação</h1>

    <!-- Tabela de dados -->
    <table>
        <thead>
            <tr>
                <th>Área</th>
                <th>Descrição</th>
                <th>Prazo</th>
                <th>Passo 1</th>
                <th>Passo 2</th>
                <th>Passo 3</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
                <?php $area_underscore = str_replace(' ', '_', $area); ?>
                <tr>
                    <td><?php echo htmlspecialchars($area); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['descricao'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['prazo'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo1'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo2'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo3'] ?? 'Não informado'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Essa é a lista dos seus planos de ação. Se necessário, você pode editá-los a qualquer momento.</p>

    <a href="editar_plano_acao.php">Editar Plano de Ação</a>
    <a href="perfil.php">Voltar</a>
</body>
</html>
