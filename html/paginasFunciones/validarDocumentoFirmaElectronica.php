<?php	session_start();
	include("conexionBD.php");
	global $con;
	global $baseDir;

	$archivoValidar=bE(leerContenidoArchivo($_FILES["fileValidate"]["tmp_name"]));
	
	$client = new nusoap_client("http://10.6.5.178/firmaLatis.asmx?wsdl","wsdl");
	$parametros=array();
	$parametros["contenidoDocument"]=$archivoValidar;
	

	$response = $client->call("validarFirmaDocumento", $parametros);

	echo "1|".$response["validarFirmaDocumentoResult"];

?>