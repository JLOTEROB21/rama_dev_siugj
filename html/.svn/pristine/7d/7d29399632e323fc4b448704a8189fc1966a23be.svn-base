<?php
	include("conexionBD.php");
	$urlDoc=bD($_POST["urlDoc"]);

	
	$urlDoc=str_replace("../",$urlSitio,$urlDoc);
	$urlDoc=str_replace("&","____",$urlDoc);
	$urlDoc.="____rand=".generarNombreArchivoTemporal();
	$arrParametros=explode("____",$urlDoc);
	
	if(count($arrParametros)>1)
	{
		for($x=1;$x<count($arrParametros);$x++)
		{
			$urlDoc.="&".$arrParametros[$x];
		}
	}
?>

<html>
	<body style="margin:3px !important">
    <iframe style="width:100%; height:97%" frameborder="0" src = "./ViewerJS2/index.php?file=<?php echo $urlDoc ?>" allowfullscreen webkitallowfullscreen></iframe>
    <input type="hidden" id="urlDoc" value="<?php echo $urlDoc ?>">
    </body>
</html>