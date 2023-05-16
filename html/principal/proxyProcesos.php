<?php
	$tipoProceso=base64_decode($_POST["tipo"]);
	$idProceso=base64_decode($_POST["iP"]);
	$confReferencia=$_POST["confReferencia"];
	switch($tipoProceso)
	{
		case "9":
			$pagRedireccion="../procesoPOA/poaAdmon.php";
			$hValores='<input type="hidden" name="idProceso" value="'.$idProceso.'">';
		break;
	}
?>

<html>
	<body>
    	<form method="post" action="<?php echo $pagRedireccion?>" id="frmEnvio">
        	<?php
				echo $hValores;
            ?>
	        <input type="hidden" name="confReferencia" value="<?php echo $confReferencia?>">
        </form>
    	<script>
			document.getElementById('frmEnvio').submit();
		</script>
    </body>
</html>