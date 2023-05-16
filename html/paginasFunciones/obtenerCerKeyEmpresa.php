<?php
include("conexionBD.php");

if(isset($_GET['e'])) 
{	
	$idEmpresa=bD($_GET['e']);
	$tipoElemento=bD($_GET['t']);
	
	$extension="";
	switch($tipoElemento)
	{
		case '1':
			$extension="cer";
		break;
		case '2':
			$extension="key";
		break;	
	}
	$consulta="SELECT CONCAT(rfc1,rfc2,rfc3) FROM 6927_empresas WHERE idEmpresa=".$idEmpresa;
	$rfc=$con->obtenerValor($consulta);
	$archivo=$baseDir."/tesoreria/fiel/".$idEmpresa.".".$extension;
	header("Content-length: ".filesize($archivo)); 
	header("Content-Disposition: attachment; filename=".$rfc.".".$extension);
	readfile($archivo);
	
}
?>