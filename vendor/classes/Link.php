<?php 
require("PDOConnection.php"); 

class Link extends PDOConnection{
	private $link = ""; 
	private $hash = ""; 

	public function __construct(){
	}

	private function digestLink( $link ){
		return hash('adler32', $link, false); 
	}

	public function setData( $link ){
		$this->link = $link; 
		$this->hash = self::digestLink($link); 
	}

	public function save(){
		$con = parent::getInstance(); 

		$query = $con->prepare("SELECT * FROM link WHERE hash = ?"); 
		$query->bindParam(1,$this->hash); 
		$query->execute(); 

		if( $query->fetchColumn() > 0 )
			return $this->hash; 

		$query = $con->prepare("INSERT INTO link (link,hash) VALUES(?, ?)"); 
		$query->bindParam(1,$this->link);
		$query->bindParam(2,$this->hash);

		if($query->execute())
			return $this->hash; 

		return false; 
	}


	public function find($hash){
		$con = parent::getInstance(); 

		$query = $con->prepare("SELECT * FROM link WHERE hash = ?"); 
		$query->bindParam(1, $hash); 
		$query->execute(); 

		$result = $query->fetchAll(); 

		var_dump($result); 
		var_dump($hash); 
		var_dump($con); 

		if(count($result) < 0)
			return null; 

		foreach($result as $row )
			return $row['link']; 
	}
}