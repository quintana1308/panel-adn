<?php

$cookie_options = array(
  'expires' => time() + 60*60*24*30,
  'path' => '/',
  'domain' => '.domain.com', // leading dot for compatibility or use subdomain
  'secure' => true, // or false
  'httponly' => false, // or false
  'samesite' => 'None' // None || Lax || Strict
);

setcookie('cors-cookie', 'my-site-cookie', $cookie_options);

//error_reporting(0);
class Conexion2{
	private $conect;
	private static $instance = null;

	private function __construct(){

		$connectionString = "mysql:host=".DB_HOST_PRINCIPAL.";dbname=".DB_NAME_PRINCIPAL.";charset=".DB_CHARSET_PRINCIPAL;
		try{
			$this->conect = new PDO($connectionString, DB_USER_PRINCIPAL, DB_PASSWORD_PRINCIPAL);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //echo "conexión exitosa";
		}catch(PDOException $e){
			$this->conect = 'Error de conexión';
		    echo "ERROR: " . $e->getMessage();
		}
	}

	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function conect(){
		return $this->conect;
	}

	public function closeConnection(){
		$this->conect = null;
		self::$instance = null;
	}

	public function __destruct(){
		$this->conect = null;
	}
}

?>