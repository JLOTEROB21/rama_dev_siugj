<?php
include_once("nusoap/nusoap.php");
function latisErrorHandler($errno, $errstr, $errfile, $errline) 
{
	
	$client = new nusoap_client("http://grupolatis.net/webServices/wsLicencias.php?wsdl","wsdl");


	$parametros=array();
	$parametros["tokenAcceso"]="1984";
	$parametros["claveLicencia"]="L34O-4482-A8847-7778-T882-7778-I112-8887-S747-IIIUX-DEV01";
	$parametros["reporte"]=base64_encode("{\"NoError\":\"".cvHandler($errno)."\",\"Linea\":\"".cvHandler($errline)."\",\"Archivo\":\"".cvHandler($errfile)."\",\"Mensaje\":\"".cvHandler($errstr)."\"}");
	$response = $client->call("reporteIncidentesInstancias", $parametros);
	$oResp=json_decode($response);
		
   throw new Exception("Error: ".$errstr.". Archivo: ".$errfile.". Linea: ".$errline);
}


function cvHandler($valor,$hTrim=true)
	{
		/*if($hTrim)
			return mysql_real_escape_string(html_entity_decode(trim(str_replace("#R","",$valor)),ENT_NOQUOTES, 'UTF-8'));
		else
			return mysql_real_escape_string(html_entity_decode(str_replace("#R","",$valor),ENT_NOQUOTES, 'UTF-8'));*/
		$cadena="";
		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		if($hTrim)
			$cadena=html_entity_decode(trim(str_replace("#R","",$valor)),ENT_NOQUOTES, 'UTF-8');
		else
			$cadena=html_entity_decode((str_replace("#R","",$valor)),ENT_NOQUOTES, 'UTF-8');
		return str_replace($search, $replace, $cadena);
	}

set_error_handler("latisErrorHandler");
?>