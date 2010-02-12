<?php 

/*
 * Progetto: Te.Si. CMS
 */
session_start("tesi");


include_once('../include/config.php');
include_once('../class/conn.php');
include_once('../class/db.php');
include_once('../class/ambiente.php');

include_once('include/function.php');


//include("class/label.php");
include("../class/user.php");
include("../class/html_gestione.php");
//include("class/training.php");
include("../class/messaggi.php");


		$messaggi = new Messaggi();


switch($_GET["save"]){
	case 'login':
		User::login($_POST["username"], $_POST["password"]);
		header('Location:index.php');
	break;
	case 'logout':
		User::logout();
		header('Location:index.php');
	break;
	case 'i_training':
		$user = new User($_SESSION["id_user"]);
		$user->i_training();
		header('Location:index.php');
	break;
	case 'i_profilo':
		$user = new User($_SESSION["id_user"]);
		$user->i_profilo();
		header('Location:index.php?action=profilo');
	break;
	case 'i_competenze':
		$user = new User($_SESSION["id_user"]);
		$user->i_competenze($messaggi);
	break;
}


if($_SESSION["id_user"] == ''){
	Html::login();
}else{
	$user = new User($_SESSION["id_user"]);
	ob_start();
	Html::header();
	
	
	Html::messaggi($messaggi);
	
	Html::menu();
	

	switch($_GET["action"]){
		case 'users':
			Html::users();
		break;
		case 'profilo':
			Html::profilo();
		break;
		case 'database':
			Html::database();
		break;
		case 'config':
			Html::config();
		break;
		default:
			Html::home();
		break;
	}
	
	Html::footer();
	ob_end_flush();
}





?>