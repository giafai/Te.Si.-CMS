<?php 
class Ambiente{
	static function existVariabile($var){
		$conn = new conn();
		$sql = preparaSql("S", array("config"), '', array("variabile = '$var'"));
		$conn->exec_query($sql);
		$r = $conn->fetch();
		return ($r["ID_config"] != '') ? true : false;
	}

	static function getVariabile($var){
		$conn = new conn();
		$sql = preparaSql("S", array("config"), '', array("variabile = '$var'"));
		$conn->exec_query($sql);
		$r = $conn->fetch();
		return $r["valore"];
	}
	
	static function setVariabile($var, $value){
	
		$conn = new conn();
		if(Ambiente::existVariabile($var)){
			$sql = preparaSql("U", array("config"), array("valore = '{$value}'"), array("variabile = '$var'"));
		}else{
			$sql = preparaSql("I", array("config"), array('variabile', 'valore'), array("'{$var}'", "'{$value}'"));
		}
		$conn->exec_query($sql);
		$r = $conn->fetch();
	}
	
	static function getUserPref($var){
	
	
	}
}
?>