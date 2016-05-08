<?php 
class PDOConnection{
	private static $con; 
	private $user     = "root"; 
	private $password = ""; 
	private $dbname   = "cutlink";

	protected function  getInstance(){
		if(self::$con == null){
			try{
				self::$con = new PDO("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)); 
			}catch(Exception $e){
				die("Error ao se conectar ao banco de dados ". $e->getMessage()); 
			}
			return self::$con; 
		}
		return self::$con; 
	}
}; 