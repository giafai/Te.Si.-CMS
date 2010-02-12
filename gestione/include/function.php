<?php 

/*
function creaSysAdmin(){
	$conn = connessione();
	
	$sql = preparaSql("S", array("user"), array("COUNT(ID_user)"), array("login = 'sysadmin'"));
	echo $sql;
	$numero = $conn->exec($sql);
	//echo $numero;
	
//	$r = $conn->fetch();
//	print_r($r);
	
	if($numero != 0)
		return false;
	
	echo "qui?";
	
	$sql = preparaSql("I", array("group"), array("nome", "data"), array("'sysadmin'", "NOW()"));
	echo $sql;
	
	$conn->query($sql);
	$ID_group = $conn->lastInsertId();
	
	$sql = preparaSql("I", array("user"), array("login", "password", "ID_group"), array("'sysadmin'", "MD5('g14nluc4')", "$ID_group"));
	echo $sql;
	
	$conn->query($sql);
	
	$sql = preparaSql("S", array("user"), '', array("login = 'sysadmin'"));
	
	echo "numero utenti: " . $conn->exec($sql);
	
}*/

function creaSysAdmin(){
echo "x";
	$conn = new conn();
	
	$sql = preparaSql("S", array("user"), '', array("login = 'sysadmin'"));
	
	$conn->exec_query($sql);
	echo print_r($conn->fetch());
	
	if($conn->numrows() > 0)
		return false;
	
	
	$sql = preparaSql("I", array("group"), array("nome", "data"), array("'sysadmin'", "NOW()"));
	
	$conn->exec_query($sql);
	
	$ID_group = $conn->lastID();
	
	$sql = preparaSql("I", array("user"), array("login", "password", "ID_group"), array("'sysadmin'", "MD5('g14nluc4')", "$ID_group"));
	
	$conn->exec_query($sql);
	echo "qui?";
	
}

?>