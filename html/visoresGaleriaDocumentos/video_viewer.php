<?php
	include("conexionBD.php");
	$urlDoc=bD($_POST["urlDoc"]);
	
?>

<html>
	<body>
    <iframe style="width:100%; height:97%" frameborder="0" src = "./ViewerVideo/viewer.php?urlDoc=<?php echo $urlDoc ?>" allowfullscreen webkitallowfullscreen></iframe>
    </body>
</html>