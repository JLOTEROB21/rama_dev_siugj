<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	
	function verificaLicenciaLatis($claveLicencia)
	{
		global $con;
		
		$consulta="SELECT * FROM _1052_tablaDinamica WHERE REPLACE(claveLicencia,'-','')='".cv($claveLicencia)."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$cadObj='{"resultado":"0"}';
		if($fRegistro)
		{	

			
			
			$cadObj='{"titularLicencia":"'.cv($fRegistro["titularLicencia"]).'","tipoUso":"'.cv($fRegistro["tipoUso"]).'","claseLicencia":"'.cv($fRegistro["claseLicencia"]).'","fechaInicioVigencia":"'.cv($fRegistro["fechaInicioVigencia"]).
					'","vigenciaLicencia":"'.cv($fRegistro["vigenciaLicencia"]).'","fechaFinVigencia":"'.cv($fRegistro["fechaFinVigencia"]).'","licenciasUsuariosFInales":"'.cv($fRegistro["licenciasUsuariosFInales"]).
					'","MACAddress":"'.cv($fRegistro["MACAddress"]).'","resultado":"1","descripcionProducto":"'.cv(utf8_encode($fRegistro["descripcionProducto"])).'"}';
		}
		
	
		return $cadObj;
	}
	
	function reporteIncidentesInstancias($tokenAcceso,$claveLicencia,$reporte)
	{
		global $con;
		
		$consulta="INSERT INTO 20900_reporteErroresInstancias(fechaRegistro,claveLicencia,reporte) VALUES('".date("Y-m-d H:i:s")."','".$claveLicencia."','".cv($reporte)."')";
		if($con->ejecutarConsulta($consulta))
		{
			$cadObj='{"resultado":"1"}';
			return $cadObj;
		}
		
		return '{"resultado":"0"}';
	
	}
	
	
	function registrarLicenciaLatis($claveLicencia,$macAddress)
	{
		global $con;
		
		$consulta="SELECT * FROM _1052_tablaDinamica WHERE REPLACE(claveLicencia,'-','')='".cv($claveLicencia)."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$cadObj='{"resultado":"0"}';
		if($fRegistro)
		{	
			if($fRegistro["MACAddress"]=="")
			{
				$continuar=false;
				if($fRegistro["tipoUso"]!=1)//Licencia de Usuario
				{
					$continuar=true;
				}
				else
				{
					$consulta="SELECT COUNT(*) FROM _1052_tablaDinamica WHERE MACAddress='".$macAddress."' AND tipoUso=1";
					$numReg=$con->obtenerValor($consulta);
					if($numReg==0)
						$continuar=true;
				}
				if($continuar)
				{
					$consulta="UPDATE _1052_tablaDinamica SET MACAddress='".$macAddress."' WHERE id__1052_tablaDinamica=".$fRegistro["id__1052_tablaDinamica"];
					if($con->ejecutarConsulta($consulta))
					{
						$cadObj='{"resultado":"1","descripcionProducto":"'.cv($fRegistro["descripcionProducto"]).'","tipoLicencia":"'.cv($fRegistro["tipoUso"]).'"}';
					}
					else
					{
						$cadObj='{"resultado":"2"}';
					}
				}
				else
				{
					$cadObj='{"resultado":"4"}';
				}
			}
			else
			{
				if($fRegistro["MACAddress"]!=$macAddress)
				{
					$cadObj='{"resultado":"3"}';
				}
				else
				{
					$cadObj='{"resultado":"1","descripcionProducto":"'.cv($fRegistro["descripcionProducto"]).'","tipoLicencia":"'.cv($fRegistro["tipoUso"]).'"}';
				}
			}
			
		}
		
	
		return $cadObj;
	}
	
	
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('verificaLicenciaLatis',array('claveLicencia'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarLicenciaLatis',array('claveLicencia'=>'xsd:string','macAddress'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('reporteIncidentesInstancias',array('tokenAcceso'=>'xsd:string','claveLicencia'=>'xsd:string','reporte'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
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