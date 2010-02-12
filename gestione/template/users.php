<?php 

if($_POST["username"] != ''){
	if(User::newUser($_POST["username"], $_POST["password"])){
		$messaggi->aggiungi("Il nuovo utente creato correttamente.");
	}else{
		$messaggi->aggiungi("Il nuovo utente non è stato creato perché lo UserName è già in uso.");
	}
}

?>
<div id="main">
<h2>Gestione utenti</h2>

<form action="?action=users" method="post">
<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" /></p>
<p><label for="username">Username</label><input type="text" id="username" name="username" /></p>
<p><label for="password">Password</label><input type="text" id="password" name="password" /></p>
<p><label for="repassword">RE-Password</label><input type="text" id="repassword" name="repassword" /></p>

<p><input type="submit" value="salva" /></p>

</form>

<h3>Lista utenti</h3>

<?php foreach(User::lista() as $id_user=>$user ) {?>

<?php echo $id_user ?>) 
<?php echo $user["login"] ?>

<?php }?>

</div>