<?php
  
  class Usuario{
    public static function atualizarUsuario($password,$imagem){
      $sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET password = ?, img = ? WHERE user = ?");
      if ($sql->execute(array($password,$imagem,$_SESSION["usuario"]))) {
        return true;
      }else{
        return false;
      }
    }

    public static function userExist($user){
      $sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.usuarios` WHERE user =?");
      $sql->execute(array($user));
      if ($sql->rowCount() == 1) {
        return true;
      }else{
        return false;
      }
    }

    public static function cadastrarUsuario($user,$password,$cargo){
      $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES (null,?,?,'',?)");
      $sql->execute(array($user,$password,$cargo));
    }
  }
?>
