<?php include_once("conexionBD.php");
	include_once("nusoap/nusoap.php");

class cInformacionSistema
{
	var $sitioRemoto;
	
	function __construct($ipSitioRemoto="")
	{
		$this->sitioRemoto=$ipSitioRemoto;	
	}
	
	
	function obtenerInformacionTablaSistema()//Listo
	{
		
		global $con;
		try
		{
			$consulta="select TABLE_NAME,ENGINE,TABLE_TYPE,TABLE_COLLATION  from information_schema.TABLES where TABLE_SCHEMA='".$con->bdActual."' AND TABLE_TYPE<>'VIEW'";
			$arrRegistros=$con->obtenerFilasJSON($consulta);
			
			
			$cadObj='{"resultado":"1","registros":'.$arrRegistros.'}';
			
			return $cadObj;
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}
	
	function obtenerInformacionTablaDetalleSistema($nombreTabla)
	{
		
		global $con;
		try
		{
			$consulta="select TABLE_NAME,ENGINE,TABLE_TYPE,TABLE_COLLATION  from information_schema.TABLES where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='".$nombreTabla."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if(!$fRegistro)
			{
				$cadObj='{"resultado":"0","error":"La tabla solicitada NO existe","codigoError":"20"}';
			}
			else
			{
				$arrInfoTablas="";
				
				$arrEsquema="";
				$consulta="SELECT COLUMN_NAME,COLUMN_DEFAULT,IS_NULLABLE,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,NUMERIC_PRECISION,COLUMN_TYPE,
						COLUMN_KEY,EXTRA FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."'
						order by ORDINAL_POSITION";
				
				$rConsulta=$con->obtenerFilas($consulta);
				while($filaEsquema=$con->fetchAssoc($rConsulta))
				{
					$aEstructura="";
					foreach($filaEsquema as $campo=>$valor)
					{

						$oEstructura='"'.$campo.'":"'.cv($valor=="NULL"?"":$valor).'"';
						if($aEstructura=="")
							$aEstructura=$oEstructura;
						else
							$aEstructura.=",".$oEstructura;
						
					}
					
					$aEstructura='{'.$aEstructura.'}';
					if($arrEsquema=="")
						$arrEsquema=$aEstructura;
					else
						$arrEsquema.=",".$aEstructura;
				}
				
				$arrEsquema="[".$arrEsquema."]";
						
				
				
				$aIndice=array();
				$arrIndice="";
				$infoTbl='{"TABLE_NAME":"'.$fRegistro["TABLE_NAME"].'","ENGINE":"'.$fRegistro["ENGINE"].'","TABLE_TYPE":"'.$fRegistro["TABLE_TYPE"].
							'","TABLE_COLLATION":"'.$fRegistro["TABLE_COLLATION"].'"}';
				$consulta="SHOW INDEX FROM ".$nombreTabla;
				$resIndice=$con->obtenerFilas($consulta);
				while($fIndice=$con->fetchAssoc($resIndice))
				{
					if(!isset($aIndice[$fIndice["Key_name"]]))
					{
						$aIndice[$fIndice["Key_name"]]=array();
						$aIndice[$fIndice["Key_name"]]="";
					}
					if($aIndice[$fIndice["Key_name"]]=="")
						$aIndice[$fIndice["Key_name"]]="'".$fIndice["Column_name"]."'";
					else
						$aIndice[$fIndice["Key_name"]].=",'".$fIndice["Column_name"]."'";
					
				}
				foreach($aIndice as $nombreIndice=>$campos)
				{
					$oIndice='{"nombreIndice":"'.cv($nombreIndice).'","campos":"'.$campos.'"}';
					if($arrIndice=="")
						$arrIndice=$oIndice;
					else
						$arrIndice.=",".$oIndice;
				}
				$infoTabla='{"tablaBase":'.$infoTbl.',"esquema":'.$arrEsquema.',"indices":['.$arrIndice.']}';
				
				
				$cadObj= '{"resultado":"1","infoTabla":['.$infoTabla.']}';
			}
			return $cadObj;
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}

	function obtenerRegistrosTablaDetalleSistema($nombreTabla)
	{
		global $con;
		
		try
		{
			$consulta="select TABLE_NAME,ENGINE,TABLE_TYPE,TABLE_COLLATION  from information_schema.TABLES where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='".$nombreTabla."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if(!$fRegistro)
			{
				$cadObj='{"resultado":"0","error":"La tabla solicitada NO existe","codigoError":"20"}';
			}
			else
			{
				$consulta="SELECT * FROM ".$nombreTabla;
				
				$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));	
				
				
				$cadObj= '{"resultado":"1","arrRegistros":'.$arrRegistros.'}';
			}
			return $cadObj;
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}

	function obtenerInformacionVistasDetalleSistema()
	{
		
		global $con;
		
		try
		{
			$arrRegistros='';
			$consulta="SELECT TABLE_NAME,VIEW_DEFINITION FROM information_schema.VIEWS WHERE TABLE_SCHEMA='".$con->bdActual."'";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$o='{"TABLE_NAME":"'.$fila["TABLE_NAME"].'","VIEW_DEFINITION":"'.bE($fila["VIEW_DEFINITION"]).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
			
			$cadObj='{"resultado":"1","registros":['.$arrRegistros.']}';
			return $cadObj;
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}
	
	function obtenerInformacionProcedimientosAlmacenadosDetalleSistema()
	{
		
		global $con;
		
		try
		{
			$arrRegistros='';
			$consulta="SELECT ROUTINE_NAME,ROUTINE_DEFINITION FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA='".$con->bdActual."'";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$consulta="SHOW CREATE PROCEDURE ".$con->bdActual.".".$fila["ROUTINE_NAME"];
				$fProcedimiento=$con->obtenerPrimeraFilaAsoc($consulta);

				$consulta="SELECT PARAMETER_NAME,DATA_TYPE  FROM information_schema.PARAMETERS WHERE SPECIFIC_SCHEMA='".$con->bdActual.
						"' AND SPECIFIC_NAME='".cv($fila["ROUTINE_NAME"])."' ORDER BY ORDINAL_POSITION";
				$arrParametros=$con->obtenerFilasJSON($consulta);		
				$o='{"ROUTINE_NAME":"'.$fila["ROUTINE_NAME"].'","ROUTINE_DEFINITION":"'.bE($fila["ROUTINE_DEFINITION"]).'","PARAMETERS":'.$arrParametros.'}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
			
			$cadObj='{"resultado":"1","registros":['.$arrRegistros.']}';
			return $cadObj;
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}
	
	function obtenerInformacionTriggersDetalleSistema()
	{
		
		global $con;
		
		try
		{
			$arrRegistros='';
			$consulta="SELECT TRIGGER_NAME,ACTION_TIMING,EVENT_MANIPULATION,EVENT_OBJECT_TABLE,ACTION_STATEMENT FROM 
						information_schema.TRIGGERS WHERE TRIGGER_SCHEMA='".$con->bdActual."'";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$o='{"TRIGGER_NAME":"'.$fila["ACTION_TIMING"].'","EVENT_MANIPULATION":"'.$fila["EVENT_MANIPULATION"].'","EVENT_OBJECT_TABLE":"'.
					$fila["EVENT_OBJECT_TABLE"].'","ACTION_STATEMENT":"'.bE($fila["ACTION_STATEMENT"]).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
			
			$cadObj='{"resultado":"1","registros":['.$arrRegistros.']}';
			return $cadObj;
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","error":"'.cv($e->getMessage()).'","codigoError":"30"}';

		}
	}
	
	function obtenerTablasSistemas($naturalezaLocalhost) //1 Sistema Base (origen);2 Sistema de referencia 
	{
		global $con;
		$objResp1=json_decode($this->obtenerInformacionTablaSistema());
		//varDUmp($objResp);
		
		
		$client = new nusoap_client($this->sitioRemoto."/webServices/wsServiciosUtilesSIUGJ.php?wsdl","wsdl");
		
		$parametros=array();
		$parametros["token"]="B2A9B137D32676A56D96C2E160152A2C";
		$response = $client->call("obtenerInformacionTablaSistema", $parametros);
		$objResp2=json_decode($response);

		$objBase=NULL;
		$objDestino=NULL;
		
		if($naturalezaLocalhost==1)
		{
			$objBase=$objResp1;
			$objDestino=$objResp2;
		}
		else
		{
			$objBase=$objResp2;
			$objDestino=$objResp1;
		}
		
		$x=0;
		$consulta=array();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 000_sincronizacionBaseDatos";
		$x++;
		$consulta[$x]="ALTER TABLE 000_sincronizacionBaseDatos AUTO_INCREMENT=1";
		$x++;
		foreach($objBase->registros as $r)
		{
			$consulta[$x]="INSERT INTO 000_sincronizacionBaseDatos(origenTabla,origenEngine,origenCollation) VALUES('".
							cv($r->TABLE_NAME)."','".cv($r->ENGINE)."','".cv($r->TABLE_COLLATION)."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$x=0;
			$consulta=array();
			$consulta[$x]="begin";
			$x++;
			foreach($objDestino->registros as $r)
			{
			
				$query="SELECT idRegistro FROM 000_sincronizacionBaseDatos WHERE origenTabla='".cv($r->TABLE_NAME)."'";
				
				
				$idRegistro=$con->obtenerValor($query);
				
				if($idRegistro=="")
				{	
					$consulta[$x]="INSERT INTO 000_sincronizacionBaseDatos(destinoTabla,destinoEngine,destinoCollation) VALUES('".
									cv($r->TABLE_NAME)."','".cv($r->ENGINE)."','".cv($r->TABLE_COLLATION)."')";
					$x++;
				}
				else
				{
					$consulta[$x]="update 000_sincronizacionBaseDatos set destinoTabla='".cv($r->TABLE_NAME)."',destinoEngine='".cv($r->ENGINE).
								"',destinoCollation='".cv($r->TABLE_COLLATION)."' where idRegistro=".$idRegistro; 

					$x++;
				}
			}
			
			
			$consulta[$x]="commit";
			$x++;
			$con->ejecutarBloque($consulta);
		}
		
		
		
		
		
	}
	
   	function compararTablasSistema()
	{
		global $con;
		$consulta="SELECT * FROM 000_sincronizacionBaseDatos";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=$con->fetchAssoc($res))
		{
			$this->realizarComparacionTabla($fila);
			return;	
		}
		
	}
	
	function realizarComparacionTabla($fila) //1 Sistema Base (origen);2 Sistema de referencia 
	{
		$objDatos1=NULL;
		$objDatos2=NULL;
		
		$hashDatos1="";
		$hashDatos2="";
		if($fila["origenTabla"]!="")
		{
			$resultado=$this->obtenerInformacionTablaDetalleSistema($fila["origenTabla"]);
			$hashDatos1=bE($resultado);		
			$objDatos1=json_decode($resultado);
				
		
		}
		
		if($fila["destinoTabla"]!="")
		{
			$client = new nusoap_client($this->sitioRemoto."/webServices/wsServiciosUtilesSIUGJ.php?wsdl","wsdl");
		
			$parametros=array();
			$parametros["nombreTabla"]=$fila["destinoTabla"];
			$parametros["token"]="B2A9B137D32676A56D96C2E160152A2C";
			$response = $client->call("obtenerInformacionTablaDetalleSistema", $parametros);
			$hashDatos1=bE($response);			
			$objDatos2=json_decode($response);
		}
		
		$consulta="UPDATE 000_sincronizacionBaseDatos SET origenHastTabla='".$hashDatos1."',destinoHastTabla='".$hashDatos2."' WHERE idRegistro=".$fila["idRegistro"];
		return $con->ejecutarCOnsulta($consulta);
		
	}
	
}    


?>