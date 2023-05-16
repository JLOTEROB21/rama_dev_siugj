<?php 	session_start();
		include("conexionBD.php");	
		if(isset($_SESSION["idUsr"]))
		{
			if($_SESSION["idUsr"]=="-1")
			{
				$_SESSION["idUsr"]="1";
				$_SESSION["login"]="";
				$_SESSION["idRol"]="'-1000_0'";
				$_SESSION["codigoUnidad"]="0001";
				$_SESSION["codigoInstitucion"]="0001";
			}
		}
		else
		{
			$_SESSION["idUsr"]="1";
			$_SESSION["login"]="";
			$_SESSION["idRol"]="'-1000_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";
		}
		
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<?php
	$pagRedireccion="../modulosProcesos/listaAsistencia.php";
	$arrParam=array();
	$arrParam[0][0]="cPagina";
	$arrParam[0][1]="mR1=false|sFrm=true";
	enviarPagina($pagRedireccion,$arrParam)
?>
<body>
</body>
</html>