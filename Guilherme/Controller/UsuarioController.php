<?php

require_once ('Model/UsuarioModel.php');

class UsuarioController
{

    public $usuarioModel;
    public function __construct($pdo)
    {
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function criarUsuario($nome, $email, $senha, $data_nascimento, $sobre_mim)
    {
        $this->usuarioModel->criarUsuario($nome, $email, $senha, $data_nascimento, $sobre_mim);
    }

    public function editarUsuario($id)
    {
        $this->usuarioModel->editarUsuario($id);
    }

    public function getFotoPerfil($idUsuario) {
        return $this->usuarioModel->getFotoPerfil($idUsuario);
    }
    
   


}

?>