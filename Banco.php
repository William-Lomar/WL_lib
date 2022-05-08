<?php 
  class Banco{
    public static function pesquisa($busca,$tabela){
      $sql = MySql::conectar()->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB."' AND TABLE_NAME = '$tabela'");
      $sql->execute();
      $colunas = $sql->fetchAll();
      $query = "SELECT * FROM `$tabela` WHERE ";

      foreach ($colunas as $key => $value) {
        if ($value[0] == 'id') {
          continue;
        }

        if (count($colunas)-1 == $key) {
          $query .= "$value[0] LIKE '%$busca%'";
        }else{
          $query .= "$value[0] LIKE '%$busca%' OR ";
        }
      }

      $sql = MySql::conectar()->prepare($query);
      $sql->execute();
      return $sql->fetchAll();
    }

    public static function select($tabela,$pesquisa = null,$start = null,$end = null){
      if ($start == null && $end == null && $pesquisa == null) {
        $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela`");
      }elseif($start != null && $end != null){
        $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` LIMIT $start,$end");
      }elseif($pesquisa != null){
        //exemplo pesquisa: $query = " WHERE nome like '%$busca%' OR email LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%'";
        $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` $pesquisa");
      }
      $sql->execute();

      return $sql->fetchAll();
    }

    public static function deletar($tabela,$id=false){
      if ($id == false) {
        $sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
      }else{
        $sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
      }
      if ($sql->execute()) {
        return true;
      }else{
        return false;
      }
    }

    public static function selecionarID($tabela,$id){
      $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE id = ?");
      $sql->execute(array($id));
      $dados = $sql->fetchAll();
      return $dados;
    }

     public static function update($arr,$single = false){
      $certo = true;
      $first = false;
      $nome_tabela = $arr['nome_tabela'];

      $query = "UPDATE `$nome_tabela` SET ";
      foreach ($arr as $key => $value) {
        $nome = $key;
        $valor = $value;
        if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
          continue;
        /*if($value == ''){
          $certo = false;
          break;
        }*/
        
        if($first == false){
          $first = true;
          $query.="$nome=?";
        }
        else{
          $query.=",$nome=?";
        }

        $parametros[] = $value;
      }

      if($certo == true){
        if($single == false){
          $parametros[] = $arr['id'];
          $sql = MySql::conectar()->prepare($query.' WHERE id=?');
          $sql->execute($parametros);
        }else{
          $sql = MySql::conectar()->prepare($query);
          $sql->execute($parametros);
        }
      }
      return $certo;
    }

    public static function insert($post,$nomeTabela){
      $tag = true;
      
      $query = "INSERT INTO `$nomeTabela` VALUES (null";
      foreach ($post as $key => $value) {
        # code...
        if ($key == 'enviar') {
         continue;
        }
        /*if ($value == '') {
          # code...
          $tag = false;
          break;
        }*/
        $query .= ",?";
        $parametros[] = $value;
      }

      $query .= ")";

      if ($tag == true) {
        # code...
        $sql = MySql::conectar()->prepare($query);
        $sql->execute($parametros);
      }
      return $tag;
    }
  }

?>
