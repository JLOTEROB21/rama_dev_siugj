<?php 	session_start();

	if(!isset($_GET["ref"]))
	{
		header('Location:../principalCensida/inicio.php');
	}
	$arrCadena=explode("_",base64_decode($_GET["ref"]));
	
	$idUsuario=$arrCadena[1];

	include("conexionBD.php");	
	if(isset($_SESSION["idUsr"]))
	{
		if($_SESSION["idUsr"]=="-1")
		{
			$_SESSION["idUsr"]=$idUsuario;
			$_SESSION["login"]="";
			$_SESSION["idRol"]="'-1000_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";
		}
	}
	else
	{
		$_SESSION["idUsr"]=$idUsuario;
		$_SESSION["login"]="";
		$_SESSION["idRol"]="'-1000_0'";
		$_SESSION["codigoUnidad"]="0001";
		$_SESSION["codigoInstitucion"]="0001";
	}
		
	
	$consulta="SELECT id__564_tablaDinamica FROM _564_tablaDinamica WHERE idUsuario=".$idUsuario;
	$idRegistro=$con->obtenerValor($consulta);
	if($idRegistro=="")
		$idRegistro=-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<?php
	$pagRedireccion="../modeloPerfiles/registroFormularioV2.php";
	$arrParam=array();
	$arrParam[0][0]="idFormulario";
	$arrParam[0][1]=564;
	$arrParam[1][0]="idRegistro";
	$arrParam[1][1]=$idRegistro;
	
	$arrParam[2][0]="funcPHPEjecutarNuevo";
	$arrParam[2][1]=bE("cerrarSesionFormulario()");
	
	$arrParam[3][0]="accionCancelar";
	$arrParam[3][1]="cerrarSesion(true);window.close()";
	$arrParam[4][0]="cPagina";
	$arrParam[4][1]="mR1=false|sFrm=true";
	$arrParam[5][0]="ignoraPermisos";
	$arrParam[5][1]="1";
	$arrParam[6][0]="idUsuario";
	$arrParam[6][1]=$idUsuario;
	$arrParam[7][0]="funcPHPEjecutarModif";
	$arrParam[7][1]=bE("cerrarSesionFormulario()");
	enviarPagina($pagRedireccion,$arrParam)
?>
<body>
</body>
</html>