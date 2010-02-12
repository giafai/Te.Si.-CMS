<?php 


if(!empty($_POST["variabile"]) AND !empty($_POST["valore"]))
	Ambiente::setVariabile($_POST["variabile"], $_POST["valore"]);


?>

<div id="main">
<h2>Configurazione dell'ambiente</h2>

<form action="?action=config" method="post">

Nome variabile: <input type="text" name="variabile" />
Valore: <input type="text" name="valore" />
<input type="submit" value="Salva" />
</form>

<h3>Elenco delle variabili d'ambiente</h3>
</div>