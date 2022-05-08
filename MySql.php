<?php
	//Para execução é necessário criar as constantes HOST,DB,USER,PASS
	//Créditos à Guilherme C. Grilo - Danki Code  

	class MySql{

		private static $pdo;

		public static function connect(){
			if(self::$pdo == null){
				try{
				self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				}catch(Exception $e){
					echo 'erro ao conectar';
				}
			}

			return self::$pdo;
		}


	}

?>