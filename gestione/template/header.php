<html>
<head><title>Te.Si. CMS</title>

<?php 

Html::style();

?>
</head>
<body>
<div id="header">
<h1>Te.Si. CMS</h1>
<p><a href="?action=profilo"><?php echo $_SESSION["nome"]?></a> <a href="<?php echo Ambiente::getVariabile("web_url"); ?>" target="_blank">ICONA SITO</a></p>
</div>