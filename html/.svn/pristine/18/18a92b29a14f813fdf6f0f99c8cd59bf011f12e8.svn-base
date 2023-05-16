<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	
	
	include_once("sgjp/siajop.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	
	
	
	
	function notificarConsolidadacionGrabacion($datosEvento)
	{
		global $con;
		$idBitacora=-1;
		$resultado="";
		try
		{

			$cXML=simplexml_load_string($datosEvento);	
			$idEventoAudiencia=(string)$cXML->idEvento[0];
			$idBitacora=registrarBitacoraSolicitudWebServicesOperador(1,bE($datosEvento));
			/*
			<?xml version="1.0" encoding="ISO-8859-1"?>
				<datosEventosAudiencia>
					<idEvento></idEvento>
				</datosEventosAudiencia>
			*/
			$consulta="SELECT direccionIP,puerto FROM 000_instanciasSistema WHERE ".$idEventoAudiencia.">=idEventoInicial AND ".$idEventoAudiencia."<=idEventoFinal";
			$fEvento=$con->obtenerPrimeraFila($consulta);
			
			if($fEvento)
			{
				$client = new nusoap_client("http://".$fEvento[0].":".($fEvento[1]==""?"80":$fEvento[1])."/webServices/wsSIAJOP.php?wsdl","wsdl"); 
				$parametros=array();
				$parametros["datosEvento"]=$datosEvento;
				$response = $client->call("notificarConsolidadacionGrabacion", $parametros);
				return $response;
			}
			
			$consulta="select count(*) from 7000_eventosAudiencia WHERE idRegistroEvento=".$idEventoAudiencia;
			
			$nRegistros=$con->obtenerValor($consulta);
		
		
			if($nRegistros==0)
			{
				$resultado='<?xml version="1.0" encoding="ISO-8859-1"?>
						<datosResultado><resultado>0</resultado><datosComplementarios>El ID de evento reportado NO existe</datosComplementarios></datosResultado>';
				actualizarSituacionBitacoraWebServices($idBitacora,0,"El ID de evento reportado NO existe");
				return $resultado;	
			}
			$consulta="UPDATE 7000_eventosAudiencia SET grabacionConsolidada=1 WHERE idRegistroEvento=".$idEventoAudiencia;
			if($con->ejecutarConsulta($consulta))
			{
				$resultado='<?xml version="1.0" encoding="ISO-8859-1"?><datosResultado><resultado>1</resultado><datosComplementarios></datosComplementarios></datosResultado>';
				actualizarSituacionBitacoraWebServices($idBitacora,1,"");
			}
		}
		catch(Exception $e)
		{
			$resultado='<?xml version="1.0" encoding="ISO-8859-1"?><datosResultado><resultado>0</resultado><datosComplementarios>'.$e->getMessage().'</datosComplementarios></datosResultado>';
			actualizarSituacionBitacoraWebServices($idBitacora,0,$e->getMessage());
		}
	}
	
	function obtenerRegistrosCatalogo($idCatalogo)
	{
		global $con;
		
		return obtenerInformacionCatalogo($idCatalogo);
		
	}
	
	function notificarInformacionAudiencia($datosEvento)
	{
		global $con;
		$idBitacora=-1;
		$resultado="";
		try
		{
			$idBitacora=registrarBitacoraSolicitudWebServicesOperador(1,bE($datosEvento));
			$cXML=simplexml_load_string(utf8_encode($datosEvento));	
				
			/*
			
			

			
			<?xml version="1.0" encoding="utf-8" ?>
			<siajop>
		       <audience id="9917"  status="3">
		     		<recording_start>04/01/2016 11:00:00</recording_start>
		            <recording_end>04/01/2016 11:00:00</recording_end>
		            <rtmp>rtmp://IP_STREAM_ONDEMAND:1935/audiencias/A_5959.mp4</rtmp>
	             	<pauses>                     
						<pause>
							<start>04/01/2016 11:00:00</start>
							<end>04/01/2016 11:00:00</end>
							<pause_reason>Fallas ténicas</pause_reason>
							<pause_duration>30 minutos </pause_duration>
						</pause>
             		</pauses>          
		       </audience>
			</siajop
			*/
			
			$idEventoAudiencia=(string)$cXML->audience[0]["id"];
			
			
			
			/*$consulta="SELECT direccionIP,puerto FROM 000_instanciasSistema WHERE ".$idEventoAudiencia.">=idEventoInicial AND ".$idEventoAudiencia."<=idEventoFinal";
			$fEvento=$con->obtenerPrimeraFila($consulta);
			
			if($fEvento)
			{
				$client = new nusoap_client("http://".$fEvento[0].":".($fEvento[1]==""?"80":$fEvento[1])."/webServices/wsSIAJOP.php?wsdl","wsdl"); 
				$parametros=array();
				$parametros["datosEvento"]=$datosEvento;
				$response = $client->call("notificarInformacionAudiencia", $parametros);
				return $response;
			}*/
			
			$consulta="select count(*) from 7000_eventosAudiencia WHERE idRegistroEvento=".$idEventoAudiencia;
			
			$nRegistros=$con->obtenerValor($consulta);
		
		
			if($nRegistros==0)
			{
				$resultado='<?xml version="1.0" encoding="utf-8" ?><siajop><audience>0</audience></siajop>';
				actualizarSituacionBitacoraWebServices($idBitacora,0,"El ID de evento reportado NO existe");
				return $resultado;	
			}
			$horaInicioReal=formatearFechaEventoSIAJOP((string)$cXML->audience[0]->recording_start[0]);
			
				
			$horaTerminoReal=formatearFechaEventoSIAJOP((string)$cXML->audience[0]->recording_end[0]);
			
				
			
			$duracion=obtenerDiferenciaHoraMinutos($horaInicioReal,$horaTerminoReal); 
			
			
			
			$updateComplementario="";
			
			$consulta="SELECT horaInicioReal FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEventoAudiencia;
			$fInicio=$con->obtenerValor($consulta);
			if($fInicio=="")
			{
				$updateComplementario=", horaInicioReal='".$horaInicioReal."',horaTerminoReal='".$horaTerminoReal."',duracionAudiencia=".$duracion;
			}
			
			$consulta="UPDATE 7000_eventosAudiencia SET grabacionConsolidada=1,situacion=2,horaInicioRealMAJO='".$horaInicioReal."',horaTerminoRealMAJO='".$horaTerminoReal."',
					fechaNotificacionMultimedia='".date("Y-m-d H:i:s")."',urlMultimedia='".((string)$cXML->audience[0]->rtmp)."',
					duracionAudienciaMAJO=".$duracion.
					" ".$updateComplementario." WHERE idRegistroEvento=".$idEventoAudiencia;

			if($con->ejecutarConsulta($consulta))
			{
				//@registrarTerminacionRecursosEventos($idEventoAudiencia,$horaInicioReal,$horaTerminoReal);
				
				if(sizeof($cXML->audience[0]->pauses[0])>0)
				{
					foreach($cXML->audience[0]->pauses[0] as $pausa)
					{
						//
						$duracion=((string)$pausa->pause_duration);
						if(($duracion=="")||($duracion=="-1"))
							$duracion=0;
						$consulta="INSERT INTO 7018_registroPausasEventoAudiencia(idEventoAudiencia,horaInicio,horaFin,duracion,idMotivoPausa) 
								VALUES(".$idEventoAudiencia.",'".formatearFechaEventoSIAJOP((string)$pausa->start)."','".
								formatearFechaEventoSIAJOP((string)$pausa->end)."',".$duracion.",".(((string)$pausa->pause_reason)==""?-1:((string)$pausa->pause_reason)).")";
						
						
						$con->ejecutarConsulta($consulta);
					}
				}
				
				
				if(sizeof($cXML->audience[0]->marks[0])>0)
				{
					foreach($cXML->audience[0]->marks[0] as $marca)
					{
						
						$consulta="INSERT INTO 7018_registroMarcasEventoAudiencia(idEventoAudiencia,idMarca,tiempoMarca,observaciones)
									VALUES(".$idEventoAudiencia.",'".cv((string)$marca["id"])."','".((string)$marca->time)."','".cv((string)$marca->observations)."')";
						$con->ejecutarConsulta($consulta);
					}
				}
				if(((string)$cXML->audience[0]->rtmp)!="")
					@reportarURLAudiencia($idEventoAudiencia);

				$resultado='<?xml version="1.0" encoding="utf-8" ?><siajop><audience>1</audience></siajop>';
				actualizarSituacionBitacoraWebServices($idBitacora,1,"");
			}
			
			
		}
		catch(Exception $e)
		{
			$resultado='<?xml version="1.0" encoding="utf-8" ?><siajop><audience>0</audience></siajop>';
			actualizarSituacionBitacoraWebServices($idBitacora,0,$e->getMessage());
			
		}
		return ($resultado);
	}
	
	function actualizarStatusAudiencia($datosEvento) //NOTIFICACIÓN DE EVENTO 
	{
		global $con;
		$idBitacora=-1;
		$resultado="";
		try
		{
			$idBitacora=registrarBitacoraSolicitudWebServicesOperador(1,bE($datosEvento));
			$cXML=simplexml_load_string($datosEvento);	
			$idEventoAudiencia=(string)$cXML->audience[0]["id"];		
			/*
			/*
			<?xml version="1.0" encoding="utf-8" ?>
			<siajop>			
				   <audience id="9917" status="4">			
						 <recording_start>04/01/2016 11:00:00</recording_start>			
						 <recording_end></recording_end>
						 <pause_reason></pause_reason>			
						 <pause_duration></pause_duration>			
				   </audience>			
			</siajop>
			*/
			$consulta="SELECT direccionIP,puerto FROM 000_instanciasSistema WHERE ".$idEventoAudiencia.">=idEventoInicial AND ".$idEventoAudiencia."<=idEventoFinal";
			$fEvento=$con->obtenerPrimeraFila($consulta);
			
			if($fEvento)
			{
				$client = new nusoap_client("http://".$fEvento[0].":".($fEvento[1]==""?"80":$fEvento[1])."/webServices/wsSIAJOP.php?wsdl","wsdl"); 
				$parametros=array();
				$parametros["datosEvento"]=$datosEvento;
				$response = $client->call("actualizarStatusAudiencia", $parametros);
				return $response;
			}
			
			

			if(registrarCambioStatusAudiencia($idEventoAudiencia,(string)$cXML->audience[0]["status"],-1,-1,-1,$cXML))
			{
				
				$resultado='<?xml version="1.0" encoding="utf-8" ?><siajop><audience>1</audience></siajop>';
				actualizarSituacionBitacoraWebServices($idBitacora,1,"");
			}
			
		}
		catch(Exception $e)
		{
			$resultado='<?xml version="1.0" encoding="utf-8" ?><siajop><audience>0</audience></siajop>';
			actualizarSituacionBitacoraWebServices($idBitacora,0,$e->getMessage());
			
		}
		return ($resultado);
	}
	
	function obtenerAudienciasProgramadasUnidadGestion($idCentroGestion,$fecha)
	{
		global $con;		
		
		$xml='<?xml version="1.0" encoding="utf-8" ?>
				<siajop>
					<audiences>';
		
		$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE idCentroGestion=".$idCentroGestion." 
				AND fechaEvento='".$fecha."' AND situacion=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$xml.=reportarAudienciaSiajop($fila[0],2);
		}
		$xml.="		</audiences>
				</siajop>";
		
		return $xml;
	}
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('obtenerRegistrosCatalogo',array('idCatalogo'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('actualizarStatusAudiencia',array('datosEvento'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('notificarInformacionAudiencia',array('datosEvento'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');	
	$server->register('obtenerAudienciasProgramadasUnidadGestion',array('idCentroGestion'=>'xsd:string','fecha'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');	

	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);