<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("funcionesNeotrai.php");
	
	
	include_once("sgjp/siajop.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');

	
	function existeRepositorioDocumentos($idDocumento)
	{
		
		global $con;
		global $arrRutasAlmacenamientoRepositorioAuxiliarDocumentos;
	
		$ruta="";	
		foreach($arrRutasAlmacenamientoRepositorioAuxiliarDocumentos  as $directorio)
		{
			$ruta=$directorio."\\documento_".$idDocumento;
			$ruta2=$directorio."\\archivo_".$idDocumento;
			
			if(file_exists($ruta) || file_exists($ruta2))
				return 1;//consultoria multi
		}
		return 0;
	}
	
	


	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('existeRepositorioDocumentos',array('idDocumento'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);
?>