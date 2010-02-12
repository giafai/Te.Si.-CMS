<?php 

class Messaggi{	
	
	var $conteiner = '';
	
	function Messaggi(){
	
	}
	
	
	function aggiungi($stringa){
		/*if(!is_array($_SESSION["messaggi"])){
			$_SESSION["messaggi"] = array();
		}
			$_SESSION["messaggi"][] = $stringa;
			*/
		//	echo "passo di qua?";
		$this->conteiner .= $stringa;
	}
	function stampa(){
	//	if(is_array($_SESSION["messaggi"]) and $_SESSION["messaggi"][0] != ''){

	/*		foreach($_SESSION["messaggi"] as $id=>$msg){
				echo "<p>" . $msg . "</p>";
				$_SESSION["messaggi"][$id] = '';
			}*/
		echo $this->conteiner;
		$this->conteiner = '';
	
	//	}
	}
	function hasMessaggio(){
		if($this->conteiner != '')
			return true;
	}
	static function getMessaggio(){
	
		return array_shift($_SESSION["messaggi"]);
	}
}
?>