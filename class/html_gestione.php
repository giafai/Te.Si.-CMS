<?php 

class Html{

		
	static function style($cat_id='', $pag_id=''){
		global $style;
		$conn = new conn();
		$where = array("variabile = 'style_gestione'");
		
		if($cat_id != '')
			$where[] = "ID_directory = $cat_id";
		
			
		if($pag_id != '')
			$where[] = "ID_page = $pag_id";
		
		$sql = preparaSql("S", array("config"), '', $where);
		$conn->exec_query($sql);
		$r = $conn->fetch();
		$style = $r["valore"];
		include("template/style.php");
	}

	static function login(){
		include("template/login.php");
	}
	
	static function header(){
		include("template/header.php");
	}
	
	static function footer(){
		include("template/footer.php");
	}

	static function messaggi($messaggi){
	
		include("template/messaggi.php");
		
	}
	
	static function menu(){
//		if($_SESSION["admin"]){
//			include("template/menu_admin.php");
//		}else{
			include("template/menu.php");
//		}
	}

	static function home(){
//		if($_SESSION["admin"]){
//			include("template/home_admin.php");
//		}else{
			include("template/home.php");
//		}
	}
	
	static function database(){
		include("template/database.php");
	}
	
	static function config(){
		include("template/config.php");
	}
	
	static function users(){
		include("template/users.php");
	}
	
	static function training(){
		if($_SESSION["admin"]){
			include("template/training_admin.php");
		}else{
			include("template/training_user.php");
		}
	}
	
	static function competenze(){
		if($_SESSION["admin"]){
			include("template/competenze_admin.php");
		}else{
			include("template/competenze_user.php");
		}
	}
	
	static function profilo(){
		if($_SESSION["admin"]){
			include("template/profilo_admin.php");
		}else{
			include("template/profilo_user.php");
		}
	}
}

?>