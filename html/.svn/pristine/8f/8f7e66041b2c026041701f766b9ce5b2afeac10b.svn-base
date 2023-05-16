<?php
	include("conexionBD.php");
	$urlDoc=bD($_POST["urlDoc"]);
	
	$urlDoc=str_replace("../",$urlSitio,$urlDoc);
?>

<html>
	<body style="margin:3px !important">
    <iframe style="width:100%; height:97%" frameborder="0" src = "./ViewerJSScan/index.php?file=<?php echo $urlDoc ?>" allowfullscreen webkitallowfullscreen></iframe>
    <input type="hidden" id="urlDoc" value="<?php echo $urlDoc ?>">
    </body>
</html>