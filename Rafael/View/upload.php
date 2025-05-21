<?php
session_start();
require '../conexao.php';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $id = $_SESSION['id'];
    $nomeTemporario = $_FILES['foto']['tmp_name'];
    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nomeUnico = uniqid() . '.' . $extensao;
    $diretorioDestino = 'uploads/';
    $caminhoFinal = $diretorioDestino . $nomeUnico;

    if (!is_dir($diretorioDestino)) {
        mkdir($diretorioDestino, 0755, true);
    }

    if (move_uploaded_file($nomeTemporario, "../" . $caminhoFinal)) {
        // Atualiza o caminho da foto no banco
        $stmt = $conn->prepare("UPDATE users SET foto_perfil = ? WHERE id = ?");
        $stmt->execute([$caminhoFinal, $id]);

        // Atualiza na sessão
        $_SESSION['foto_perfil'] = $caminhoFinal;

        echo "<h2>Foto enviada com sucesso!</h2>";
        echo "<img src='../$caminhoFinal' style='width:150px; height:150px; border-radius: 50%; object-fit: cover;'>";
    } else {
        echo "Erro ao salvar o arquivo.";
    }
} else {
    echo "Nenhuma foto foi enviada ou houve erro no envio.";
}
?>
