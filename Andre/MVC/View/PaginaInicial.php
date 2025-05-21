<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
    header('Location: index.php');
    exit;
}

// Obter os dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, data_nascimento FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/Página_Inicial.css">
    <title>Dashboard Principal</title>
</head>

<body>
    <style>
        .caixas {
            display: flex;
            justify-content: space-evenly;
            margin: 0 auto;
            padding: 20px;
            height: 500px;

        }

        button {
            border: none;
            background: none;
            outline: none;
            padding: 10px 20px;
            cursor: pointer;
            color: black;
            font-size: 30px;
        }
    </style>



    <header>
        <h1 class="titulo">Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
        <div class="header-direita">
            <a href="perfil.php">
                <img class="foto-perfil" src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil">
            </a>

            <form action="logout.php" method="POST" class="form-sair">
                <button type="submit">Sair</button>
            </form>
        </div>
    </header>



    <main>


        <h1 class="titulo2">Faça seu Projeto de Vida</h1>

        <div class="caixas">

            <div class="bloco1">
                <h2>Teste de Inteligência</h2>
                <h3><a href="teste_inteligencia.php">Faça agora!</a></h3>
                <a href="teste_inteligencia.php"> <img src="../../img/inteligencia.png" alt="" width="200px" height="200px"></a>
                <p>O teste de inteligência avalia habilidades cognitivas, como lógica e resolução de problemas, ajudando no autoconhecimento e desenvolvimento pessoal.</p>
            </div>

            <div class="bloco2">
                <h2>Teste de Personalidade</h2>
                <h3><a href="teste_personalidade.php">Faça agora!</a></h3>
                <a href="teste_personalidade.php"> <img src="../../img/personalidade.png" alt="" width="200px" height="200px"></a>
                <p>O teste de personalidade avalia traços psicológicos, como comportamentos e emoções, ajudando a entender melhor preferências e relações interpessoais.</p>
            </div>
            <div class="bloco3">
                <h2>Planeje o Futuro</h2>
                <h3><a href="planejamento_futuro.php">Planeje seu Futuro</a></h3>
                <a href="planejamento_futuro.php"> <img src="../../img/planejamento do futuro.png" alt="" width="200px" height="200px"></a>
                <p>O teste de personalidade avalia traços psicológicos, como comportamentos e emoções, ajudando a entender melhor preferências e relações interpessoais.</p>
            </div>



        </div>
    </main>



    <footer>
        <p>&copy; 2025 André. Todos os direitos reservados.</p>
    </footer>

</body>

</html>