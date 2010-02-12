<?php 

class User{

	public $loginuser = '';
	public $id_user = '';
	public $admin = false;
	public $nome = '';
	
	function User($iduser){
		if($iduser == 1){
			$_SESSION["loginuser"] = 'admin';
			$_SESSION["id_user"] = 1;
			$_SESSION["admin"] = true;
			$_SESSION["nome"] = 'Administrator';
	
			$this->loginuser = 'admin';
			$this->id_user = 1;
			$this->admin = true;
			$this->nome = 'Administrator';
		
		}else{
			$_SESSION["loginuser"] = 'pippo';
			$_SESSION["id_user"] = 1;
			$_SESSION["admin"] = false;
			$_SESSION["nome"] = 'Pippo';
	
			$this->loginuser = 'pippo';
			$this->id_user = 1;
			$this->admin = false;
			$this->nome = 'Pippo';
		}
	}
	
	/*
	 * Autenticazione degli utenti
	 */
	static function login($userlogin, $password){
		/*
		 * Controlla l'esistenza dell'utente
		 */
		$conn = new conn();
		$sql = preparaSql("S", array("user"), '', array("login = '{$userlogin}'", "password = MD5('{$password}')"));
		$conn->exec_query($sql);
		echo $conn->numrows();
		
		if($conn->numrows() == 0)
			return false;

			echo "qui?";
		$r = $conn->fetch();
		print_r($r);
		$user = new User($r["id"]);
		return $user;
	}
	
	/*
	 * Disconnessione degli utenti
	 */
	static function logout(){
		$_SESSION["loginuser"] = '';
		$_SESSION["id_user"] = '';
		$_SESSION["admin"] = false;
		$_SESSION["nome"] = '';
		
		unset($_SESSION["loginuser"]);
		unset($_SESSION["id_user"]);
		unset($_SESSION["admin"]);
		unset($_SESSION["nome"]);
		
	}
	
	/*
	 * Crea un nuovo utente
	 */
	static function newUser($username, $password){
	global $messaggi;

		if(User::existUser($username)){
			
			return false;
		}

		$conn = new conn();
		$sql = preparaSql("I", array('user'), array('login', 'password'), array("'{$username}'", "MD5('{$password}')"));
		$conn->exec_query($sql);
		
		return $conn->lastID();
			
	} 
	static function existUser($username){
		$conn = new conn();
		$sql = preparaSql("S", array('user'), '', array("login = '{$username}'"));
		$conn->exec_query($sql);
		if($conn->numrows() > 0)
			return true;
		else
			return false;
	}
	
	static function lista(){
		$conn = new conn();
		$sql = preparaSql("S", array('user'));
		$conn->exec_query($sql);
		$users = array();
		while($r = $conn->fetch()){
			$users[$r["ID_user"]] = array('login'=>$r["login"]);
		}
		
		return $users;
	}
	
}

?>