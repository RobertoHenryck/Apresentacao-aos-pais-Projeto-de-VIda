<?php
require_once('config.php');

class UsuarioModel
{
    public $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function criarUsuario($nome, $email, $senha, $data_nascimento, $sobre_mim)
    {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, senha, data_nascimento, sobre_mim) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash, $data_nascimento, $sobre_mim]);
    }

    public function editarUsuario($id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET  WHERE id = ?");
        $stmt->execute([$id]);
    }

    function getFotoPerfil($idUsuario) {
        $stmt = $this->pdo->prepare("SELECT foto_perfil FROM users WHERE id = :id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado && !empty($resultado['foto_perfil'])) {
                return $resultado['foto_perfil'];
            } else {
                return 'img/free-user-icon-3296-thumb.png'; // Caminho padrão
            }
        }
    
        return null;
    }
    

   

}

?>