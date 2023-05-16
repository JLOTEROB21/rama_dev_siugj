<?php
include("conexionBD.php");
include_once("funcionesFormularios.php");


$iC=bD($_GET["iC"]);
$iR=bD($_GET["iR"]);

$consulta="SELECT campoConf12 FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$iC;

$clase=$con->obtenerValor($consulta);

$valor=obtenerValorControlFormularioBase($iC,$iR);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />

</head>

<body style="background-color:#FFF">
<table width="100%">
	<tr>
    	<td>
        	<span class="<?php echo $clase?>">
            <?php
			echo convertirEnterToBR($valor);
			?>
            </span>
        </td>
    </tr>
</table>
</body>
</html>