<?php

  class Painel{
    //Verifica se o site está com protocolo https
    public static function https(){
      if ($_SERVER['HTTPS'] != "on"){
        self::redirecionar(INCLUDE_PATH.$_GET['url']);
      }
    }

    //Substitui , por .
    public static function numeroPHP($post){
      foreach ($post as $key => $value) {
        $dados[$key] = str_replace(',', '.', $post[$key]);
      }
      return $dados;
    }
    
    public static function convertMoney($valor){
      return number_format($valor,2,',','.');
    }
      
    public static function formatarMoedaBd($valor){
      $valor  = str_replace('.', '', $valor);
      $valor = str_replace(',', '.', $valor);

      return $valor;
    }
    
    public static function atualizarPG($newGet = null){
      if (count($_GET) > 1) {
        $quantidade = count($_GET);
        $get = '';

        foreach ($_GET as $key => $value) {
          if ($key == 'url') {
            continue;
          }
          $get .= $key.'='.$value.'&';
        }

        if (is_null($newGet)) {
          echo "<script>location.href='".INCLUDE_PATH.$_GET['url'].'?'.$get."'</script>";
          die();
        }else{
          echo "<script>location.href='".INCLUDE_PATH.$_GET['url'].'?'.$get.$newGet."'</script>";
          die();
        }
      }else{
        if (is_null($newGet)) {
          echo "<script>location.href='".INCLUDE_PATH.@$_GET['url']."'</script>";
          die();
        }else{
          echo "<script>location.href='".INCLUDE_PATH.@$_GET['url'].'&'.$newGet."'</script>";
          die();
        }
      }
    }
    
    public static function generateSlug($str){
      $str = mb_strtolower($str);
      $str = preg_replace('/(â|á|ã)/', 'a', $str);
      $str = preg_replace('/(ê|é)/', 'e', $str);
      $str = preg_replace('/(í|Í)/', 'i', $str);
      $str = preg_replace('/(ú)/', 'u', $str);
      $str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
      $str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
      $str = preg_replace('/( )/', '-',$str);
      $str = preg_replace('/ç/','c',$str);
      $str = preg_replace('/(-[-]{1,})/','-',$str);
      $str = preg_replace('/(,)/','-',$str);
      $str=strtolower($str);
      return $str;
    }

    public static function redirect($url){
      echo "<script>location.href='".$url."'</script>";
      die();
    }

    public static function alert($msg){
      ?>
        <script type="text/javascript">
          alert('<?php echo $msg ?>');
        </script>
      <?php
    }

    public static function logado(){
      return isset($_SESSION['login']) ? true : false;
    }

    public static function uploadFile($file){
      $formatoArquivo = explode('.', $file['name']);
      $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
      if (move_uploaded_file($file['tmp_name'],BASE_DIR.'/img/'.$imagemNome)) {
         # code...
        return $imagemNome;
       }else{
        return false;
       }
    }

    public static function deleteFile($file){
      @unlink($file);
    }

    public static function imagemValida($img){
      if ($img['type'] == 'image/jpg' || 
          $img['type'] == 'image/jpeg' ||
          $img['type'] == 'image/png') {

        $tamanho = intval($img['size']/1024);//intval -> deixa número redondo
      // /1024 -> converte de bytes para KB
        if ($tamanho < 300) {
          # code... tamanho maximo de 300KB
          return true;
        }else{
          return false;
        }
        # code...
        
      }else{
        return false;
      }
    }
}

?>
