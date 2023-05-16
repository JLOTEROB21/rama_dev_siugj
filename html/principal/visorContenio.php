<?php
	include("conexionBD.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
	<table width="100%">
    <tr>
    	<td align="center">
        <table>
        <tr>
        	<td align="left">
<?php
				$tabla="";
				if(isset($_POST["t"]))
					$tabla=bD($_POST["t"]);
				$idRegistro="-1";
				if(isset($_POST["iR"]))
					$idRegistro=bD($_POST["iR"]);
				$nombreCampoContenido="";
				if(isset($_POST["cc"]))
					$nombreCampoContenido=bD($_POST["cc"]);
				$nombreCampoId="";
				if(isset($_POST["cI"]))
					$nombreCampoId=bD($_POST["cI"]);
				
				
				$consulta="SELECT ".$nombreCampoContenido." FROM ".$tabla." WHERE ".$nombreCampoId."=".$idRegistro;
				$fila=$con->obtenerPrimeraFila($consulta);
				echo $fila[0];
?>
			</td>
        </tr>
        </table>
		</td>
    </tr>
	</table>
</body>
</html>