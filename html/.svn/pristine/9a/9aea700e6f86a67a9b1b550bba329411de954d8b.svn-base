<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	
	$idConsulta=$_GET["ref"];
	$consulta="select AES_DECRYPT(UNHEX('".$idConsulta."'), '".bD($versionLatis)."') AS PASSWORD";
	$idConsulta=$con->obtenerValor($consulta);
	$arrDatos=explode("_",$idConsulta);
	$idConsulta=$arrDatos[0];
	
	
	
	$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idConsulta;
	$nombreFuncion=$con->obtenerValor($consulta);
	$nombreFuncion="WS_".quitarAcentos(str_replace(" ","_",$nombreFuncion));
	
	
	$listaParametros="";
	$arrParametros=array();
	$arrParametros["keyAccess"]="xsd:string";
	$consulta="SELECT parametro FROM 993_parametrosConsulta WHERE idConsulta=".$idConsulta;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$arrParametros[$fila["parametro"]]="xsd:string";
		
		if($listaParametros=="")
			$listaParametros='$'.$fila["parametro"];
		else
			$listaParametros.=',$'.$fila["parametro"];
	
	}
	
	$cadFuncion='function '.$nombreFuncion.'('.$listaParametros.'){}';
	
	eval($cadFuncion);
	

	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register($nombreFuncion,$arrParametros,array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
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