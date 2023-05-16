<?php
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("latisErrorHandler.php");
	include("cInformacionSistema.php");

	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '4096M');
	ini_set('upload_max_filesize', '4096M');
	
	function obtenerInformacionTablaDetalleSistema($nombreTabla,$token)
	{
		
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerInformacionTablaDetalleSistema($nombreTabla);
	}

	function obtenerRegistrosTablaDetalleSistema($nombreTabla,$token)
	{
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerRegistrosTablaDetalleSistema($nombreTabla);
	}

	function obtenerInformacionTablaSistema($token)
	{
		
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerInformacionTablaSistema();
	}

	function obtenerInformacionVistasDetalleSistema($token)
	{
		
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerInformacionVistasDetalleSistema();
	}
	
	function obtenerInformacionProcedimientosAlmacenadosDetalleSistema($token)
	{
		
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerInformacionProcedimientosAlmacenadosDetalleSistema();
	}
	
	function obtenerInformacionTriggersDetalleSistema($token)
	{
		
		global $con;
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)));
		
		if($aResultado[0]==0)
			return $aResultado[1];
		
		$c=new cInformacionSistema();
		return $c->obtenerInformacionTriggersDetalleSistema();
	}
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('obtenerInformacionTablaDetalleSistema',array('nombreTabla'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerRegistrosTablaDetalleSistema',array('nombreTabla'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	$server->register('obtenerInformacionTablaSistema',array('token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInformacionVistasDetalleSistema',array('token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	$server->register('obtenerInformacionProcedimientosAlmacenadosDetalleSistema',array('token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInformacionTriggersDetalleSistema',array('token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	
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