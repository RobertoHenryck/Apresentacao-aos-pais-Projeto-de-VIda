<?php
session_start();

require_once 'C:\Turma2\xampp\htdocs\PROJETO-DE-VIDA-ANDRE\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT nome, foto_perfil, sobre_mim FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';
$sobre_mim_atual = $usuario['sobre_mim'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="../View/css/perfil.css">
<style>
    .upload-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
    }

    .file-input {
        display: none;
    }

    .file-label {
        background-color: #7e7e86;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .file-label:hover {
        background-color: #7e7e86;
    }

    .file-text {
        color: #666;
        font-size: 14px;
        font-style: italic;
    }
    img{
        width: 150px;
        height: 150px;
        border-radius: 100%;
    }
    .botao,a, button{
        font-size: 20px;
        border: none;
    background: none;
    outline: none;
    padding: 10px 20px;
    cursor: pointer;
    color: black;
    
    }
    .links2 {
    flex-wrap: wrap;
    gap: 40px;
    font-size: 18px;
    display: flex;
    justify-content: center;


}
</style>

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
</head>

<body>
    <header>
        <h1>Perfil</h1>
       
        <div class="header-direita">
            
            <form action="logout.php" method="POST" class="form-sair">
                <button class='sair'   type="submit">Sair</button>
            </form>
        </div>
    </header>

    <main>
        <container>
            <div class="perfil">
                <div class="foto_perfil">
                    <h1 class="nome"><?= htmlspecialchars($usuario['nome']) ?></h1>
                    <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de Perfil" ><br><br>

                    <form id="formFoto" enctype="multipart/form-data">
                        <div class="upload-wrapper">
                            <input type="file" id="arquivo" name="arquivo" class="file-input" accept="image/*" required>
                            <label for="arquivo" class="file-label">Escolher arquivo</label>
                        </div>
                        <br><br>
                        <button class= 'botao'type="submit">Atualizar Foto</button>
                    </form>
                </div>
            </div>

            <hr>

            <div class="sobre_mim">
                <h2>Sobre você</h2>
                <?= nl2br(htmlspecialchars($sobre_mim_atual ?: 'Você ainda não escreveu nada sobre si mesmo.')) ?>
            </div>
        </container>
    </main>

    <section>
        <div class="links">
            <a href="teste_personalidade.php">Teste de Personalidade</a>
            <a href="teste_inteligencia.php">Teste de Inteligência</a>
            <a href="quem_sou.php">Quem sou?</a>
            <a href="sobre_mim.php">Escreva sobre você</a>
            <a href="planejamento_futuro.php">Planejamento do Futuro</a>
            <a href="plano_acao.php">Plano de ação</a>
        </div>
        <div class="links2">
            <a href="resultado_personalidade.php">Minha Personalidade</a>
            <a href="resultado_inteligencias.php">Meu teste de Inteligência</a>
            <a href="listar_quem_sou.php">Lista quem sou</a>
            <a href="resultado_planejamento_futuro.php">Meu Planejamento do Futuro</a>
            <a href="resultado_plano_acao.php">Meu plano de Acao</a>
    </section>

    <script>
        const formFoto = document.getElementById('formFoto');

        formFoto.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(formFoto);

            fetch('atualizar_foto.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'sucesso') {
                    const novaFoto = 'users/' + data.arquivo;
                    document.querySelector('.foto_perfil img').src = novaFoto + '?t=' + new Date().getTime();
                   
                } else {
                    alert(data.mensagem);
                }
            })
            .catch(() => {
                alert('Erro ao enviar a foto.');
            });
        });
    </script>
</body>
</html>
