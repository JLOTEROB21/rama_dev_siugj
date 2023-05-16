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
	$pagRedireccion="../modeloPerfiles/registroFormulario.php";
	$arrParam=array();
	$idFormulario=bD($_GET["iF"]);
	$consulta="SELECT id__".$idFormulario."_tablaDinamica FROM _".$idFormulario."_tablaDinamica WHERE idReferencia=".($_GET["iU"]);
	$nReg=$con->obtenerValor($consulta);
	if($nReg!="")
		$pagRedireccion="../modeloPerfiles/verFichaFormulario.php";
	else
		$nReg=-1;
	$arrParam[0][0]="cPagina";
	$arrParam[0][1]="mR1=false|sFrm=true";
	$arrParam[1][0]="idFormulario";
	$arrParam[1][1]=$idFormulario;
	$arrParam[2][0]="idRegistro";
	$arrParam[2][1]=$nReg;
	
		
	if($nReg==-1)
	{
		$arrParam[3][0]="idReferencia";
		$arrParam[3][1]=($_GET["iU"]);
	}
	else
	{
		$arrParam[3][0]="sLectura";
		$arrParam[3][1]=1;
	}
	$arrParam[4][0]="eJs";
	$arrParam[4][1]=bE("window.close();return;");
	$arrParam[5][0]="paginaRedireccion";
	$arrParam[5][1]="../paginasFunciones/white.php";
	$arrParam[6][0]="accionCancelar";
	$arrParam[6][1]="window.close();";
	
	

	enviarPagina($pagRedireccion,$arrParam)
?>
<body>
</body>
</html>