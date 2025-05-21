<?php
session_start();
require '../conexao.php';
require_once '../auth.php';
atualizarFotoSessao($conn);

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_SESSION['id'];

// Atualização de dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data = $_POST['data_nascimento'];
    $sobre = $_POST['sobre_mim'];
    $foto = null;

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($ext), $ext_permitidas)) {
            $nomeFoto = uniqid('perfil_', true) . "." . strtolower($ext);
            $caminho = "../uploads/" . $nomeFoto;
            $foto = "uploads/" . $nomeFoto;

            $mime_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            $mime = mime_content_type($_FILES['foto_perfil']['tmp_name']);

            if (in_array($mime, $mime_permitidos)) {
                if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho)) {
                    die("Erro ao mover a imagem para a pasta de uploads.");
                }
            } else {
                die("Tipo de arquivo não é uma imagem válida.");
            }
        } else {
            die("Formato de imagem não permitido. Use jpg, jpeg, png ou gif.");
        }
    }

    $sql = "UPDATE users SET nome = ?, email = ?, data_nascimento = ?, sobre_mim = ?, updated_at = NOW()";
    $params = [$nome, $email, $data, $sobre];

    if ($foto) {
        $sql .= ", foto_perfil = ?";
        $params[] = $foto;
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // ✅ Atualizar a sessão com a nova foto
    atualizarFotoSessao($conn);

    header("Location: perfil.php");
    exit;
}

// Carregar dados do usuário
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Caminho para a imagem de perfil ou imagem padrão
$fotoPerfilHeader = !empty($_SESSION['foto_perfil']) && file_exists('../' . $_SESSION['foto_perfil'])
    ? '../' . $_SESSION['foto_perfil']
    : '../imagens/default.png';

$fotoPerfilForm = $fotoPerfilHeader;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #BFBFBF;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
        }

        img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        label {
            font-weight: bold;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            img {
                width: 100px;
                height: 100px;
            }

            .container {
                padding: 10px;
            }
        }

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
            border-radius: 50%;
            object-fit: cover;
        }

        .imgs:hover {
            transform: scale(1.05);
        }

        h1 {
            font-size: 28px;
        }

        #preview {
            display: none;
            margin-top: 10px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

    <script>
        function mostrarPreview() {
            const input = document.getElementById('foto');
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>

<header class="principal">
    <div class="cabecalho">
        <img class="img2" src="../DALL·E 2025-03-26 07.40.11 - A modern and inspiring logo for a website about _Projeto de Vida_ (Life Project). The logo should feature a clean, minimalist design with vibrant colo-Photoroom (2).png" alt="Logo Projeto de Vida">
        <h1>MEU PERFIL</h1>
        <img src="<?= htmlspecialchars($fotoPerfilHeader) ?>" alt="Foto de Perfil" class="imgs">
    </div>
</header>

<div class="container">
    <h1>Editar Perfil</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label>Data de nascimento</label>
        <input type="date" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>" required>

        <label>Sobre mim</label>
        <textarea name="sobre_mim" rows="4"><?= htmlspecialchars($usuario['sobre_mim']) ?></textarea>

        <label>Foto de perfil</label><br>
        <img src="<?= htmlspecialchars($fotoPerfilForm) ?>" alt="Foto de Perfil">

        <input type="file" name="foto_perfil" id="foto" onchange="mostrarPreview()">
        <img id="preview" alt="Preview da nova foto">

        <button type="submit">Salvar alterações</button>
    </form>

    <a href="../index.php" style="color: red; display:block; margin-top: 20px;">Sair</a>
    <br>
    <a href="inicio.php"><button type="button">Voltar ao Início</button></a>
</div>

</body>
</html>
