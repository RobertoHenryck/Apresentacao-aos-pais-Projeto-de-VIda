<?php
session_start();
require '../conexao.php';

require_once '../auth.php';
atualizarFotoSessao($conn); // Atualiza a foto de perfil da sessão


if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_SESSION['id'];

// Processa o formulário se ele for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $fale_sobre_voce = $_POST['fale_sobre_voce'];
    $lembrancas = $_POST['lembrancas'];
    $pontos_fortes = $_POST['pontos_fortes'];
    $pontos_fracos = $_POST['pontos_fracos'];
    $valores = implode(',', $_POST['valores'] ?? []);
    $aptidoes = implode(',', $_POST['aptidoes'] ?? []);
    $familia = $_POST['familia'];
    $amigos = $_POST['amigos'];
    $escola = $_POST['escola'];
    $sociedade = $_POST['sociedade'];
    $gosto_fazer = $_POST['gosto_fazer'];
    $nao_gosto = $_POST['nao_gosto'];
    $rotina = $_POST['rotina'];
    $lazer = $_POST['lazer'];
    $estudos = $_POST['estudos'];
    $vida_escolar = $_POST['vida_escolar'];
    $visao_fisica = $_POST['visao_fisica'];
    $visao_intelectual = $_POST['visao_intelectual'];
    $visao_emocional = $_POST['visao_emocional'];
    $visao_amigos = $_POST['visao_amigos'];
    $visao_familia = $_POST['visao_familia'];
    $visao_professores = $_POST['visao_professores'];
    $autovalorizacao = json_encode($_POST['autovalorizacao'] ?? []);

    // Atualiza os dados no banco de dados
    $stmt = $conn->prepare("UPDATE users SET 
        nome = ?, email = ?, data_nascimento = ?, fale_sobre_voce = ?, lembrancas = ?, 
        pontos_fortes = ?, pontos_fracos = ?, valores = ?, aptidoes = ?, familia = ?, amigos = ?, 
        escola = ?, sociedade = ?, gosto_fazer = ?, nao_gosto = ?, rotina = ?, lazer = ?, estudos = ?, 
        vida_escolar = ?, visao_fisica = ?, visao_intelectual = ?, visao_emocional = ?, 
        visao_amigos = ?, visao_familia = ?, visao_professores = ?, autovalorizacao = ? 
        WHERE id = ?");
    
    $stmt->execute([$nome, $email, $data_nascimento, $fale_sobre_voce, $lembrancas, 
                    $pontos_fortes, $pontos_fracos, $valores, $aptidoes, $familia, $amigos, 
                    $escola, $sociedade, $gosto_fazer, $nao_gosto, $rotina, $lazer, $estudos, 
                    $vida_escolar, $visao_fisica, $visao_intelectual, $visao_emocional, 
                    $visao_amigos, $visao_familia, $visao_professores, $autovalorizacao, $id]);

    // Mensagem de sucesso
    $mensagem = "Dados salvos com sucesso!";
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Sou Eu</title>
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
    background-color: #ffffff;
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


    </style>
</head>
<body>

    <?php include 'topo.php'; ?>
    <h1 style="text-align:center;">Quem Sou Eu</h1>

    <form class="container" method="POST">
        
        <fieldset>
            <legend>Dados Pessoais</legend>
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" readonly>
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" readonly>
            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>" readonly>
        </fieldset>

        <fieldset>
            <legend>Fale Sobre Você</legend>
            <textarea name="fale_sobre_voce"><?= htmlspecialchars($usuario['fale_sobre_voce'] ?? '') ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Minhas Lembranças</legend>
            <textarea name="lembrancas"><?= htmlspecialchars($usuario['lembrancas'] ?? '') ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Pontos Fortes</legend>
            <input type="text" name="pontos_fortes" value="<?= htmlspecialchars($usuario['pontos_fortes'] ?? '') ?>">
        </fieldset>

        <fieldset>
            <legend>Pontos Fracos</legend>
            <input type="text" name="pontos_fracos" value="<?= htmlspecialchars($usuario['pontos_fracos'] ?? '') ?>">
        </fieldset>

        <fieldset>
            <legend>Meus Valores</legend>
            <select name="valores[]" multiple>
                <?php 
                $valores = explode(',', $usuario['valores'] ?? '');
                $opcoes = ['Respeito', 'Honestidade', 'Coragem', 'Empatia'];
                foreach ($opcoes as $v): ?>
                    <option value="<?= htmlspecialchars($v) ?>" <?= in_array($v, $valores) ? 'selected' : '' ?>><?= htmlspecialchars($v) ?></option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset>
            <legend>Minhas Principais Aptidões</legend>
            <select name="aptidoes[]" multiple>
                <?php
                $aptidoes = explode(',', $usuario['aptidoes'] ?? '');
                $lista = ['Comunicação', 'Organização', 'Liderança', 'Trabalho em equipe'];
                foreach ($lista as $apt): ?>
                    <option value="<?= htmlspecialchars($apt) ?>" <?= in_array($apt, $aptidoes) ? 'selected' : '' ?>><?= htmlspecialchars($apt) ?></option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset>
            <legend>Meus Relacionamentos</legend>
            <input type="text" name="familia" placeholder="Família" value="<?= htmlspecialchars($usuario['familia'] ?? '') ?>">
            <input type="text" name="amigos" placeholder="Amigos" value="<?= htmlspecialchars($usuario['amigos'] ?? '') ?>">
            <input type="text" name="escola" placeholder="Escola" value="<?= htmlspecialchars($usuario['escola'] ?? '') ?>">
            <input type="text" name="sociedade" placeholder="Sociedade" value="<?= htmlspecialchars($usuario['sociedade'] ?? '') ?>">
        </fieldset>

        <fieldset>
            <legend>Meu Dia a Dia</legend>
            <textarea name="gosto_fazer" placeholder="O que gosto de fazer"><?= htmlspecialchars($usuario['gosto_fazer'] ?? '') ?></textarea>
            <textarea name="nao_gosto" placeholder="O que não gosto"><?= htmlspecialchars($usuario['nao_gosto'] ?? '') ?></textarea>
            <textarea name="rotina" placeholder="Rotina"><?= htmlspecialchars($usuario['rotina'] ?? '') ?></textarea>
            <textarea name="lazer" placeholder="Lazer"><?= htmlspecialchars($usuario['lazer'] ?? '') ?></textarea>
            <textarea name="estudos" placeholder="Estudos"><?= htmlspecialchars($usuario['estudos'] ?? '') ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Minha Vida Escolar</legend>
            <textarea name="vida_escolar"><?= htmlspecialchars($usuario['vida_escolar'] ?? '') ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Minha Visão Sobre Mim</legend>
            <input type="text" name="visao_fisica" placeholder="Física" value="<?= htmlspecialchars($usuario['visao_fisica'] ?? '') ?>">
            <input type="text" name="visao_intelectual" placeholder="Intelectual" value="<?= htmlspecialchars($usuario['visao_intelectual'] ?? '') ?>">
            <input type="text" name="visao_emocional" placeholder="Emocional" value="<?= htmlspecialchars($usuario['visao_emocional'] ?? '') ?>">
        </fieldset>

        <fieldset>
            <legend>A Visão das Pessoas Sobre Mim</legend>
            <input type="text" name="visao_amigos" placeholder="Amigos" value="<?= htmlspecialchars($usuario['visao_amigos'] ?? '') ?>">
            <input type="text" name="visao_familia" placeholder="Família" value="<?= htmlspecialchars($usuario['visao_familia'] ?? '') ?>">
            <input type="text" name="visao_professores" placeholder="Professores" value="<?= htmlspecialchars($usuario['visao_professores'] ?? '') ?>">
        </fieldset>

        <fieldset>
    <legend>Minha Autovalorização</legend>
    <label for="autovalorizacao">Selecione suas qualidades:</label><br>
    <select name="autovalorizacao[]" id="autovalorizacao" multiple size="3">
        <?php
        $autovalorizacao = json_decode($usuario['autovalorizacao'] ?? '[]', true) ?? [];
        $autovalor = ['Confiança', 'Autoestima', 'Amor próprio'];

        foreach ($autovalor as $av): ?>
            <option value="<?= htmlspecialchars($av) ?>" <?= in_array($av, $autovalorizacao) ? 'selected' : '' ?>>
                <?= htmlspecialchars($av) ?>
            </option>
        <?php endforeach; ?>
    </select>
</fieldset>



        <button type="submit">Salvar</button>
    </form>

    <?php if (!empty($mensagem)): ?>
        <div style="text-align:center; color: green; font-weight: bold; margin-top: 20px;">
            <?= htmlspecialchars($mensagem) ?>
        </div>
        
        <div style="text-align:center;">
            <a href="inicio.php" class="voltar-btn">Voltar ao Início</a>
        </div>
    <?php endif; ?>

</body>
</html>
