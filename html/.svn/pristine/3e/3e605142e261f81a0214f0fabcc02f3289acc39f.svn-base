<?php 
include_once("conexionBD.php");
include_once("utiles.php");
include_once("nusoap/nusoap.php");

function notificarEventoAudienciaCICERO01($objConf)
{
	global $con;
	
	$idSesion=obtenerIDSesionCicero($objConf);
	$objConf["sesionID"]=$idSesion;
	$esRegistroNuevoEventoAudiencia=esRegistroNuevoEventoAudienciaCicero($objConf["idEvento"]);

	if($idSesion=="")
	{
		if($esRegistroNuevoEventoAudiencia)
			@registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],1,0,"","","No se pudo generar token de sesión");
		else
			@registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],2,0,"","","No se pudo generar token de sesión");
	
		return false;
	}
	
	//Registro/Modificación audiencia
	if($esRegistroNuevoEventoAudiencia)
	{
		return registrarEventoAudienciaCicero($objConf);
		
		
	}
	else
	{
		return modificarEventoAudienciaCicero($objConf);
	}
	
		
}

function notificarCancelacionEventoAudienciaCICERO01($objConf)
{
	$idSesion=obtenerIDSesionCicero($objConf);
	$objConf["sesionID"]=$idSesion;
	$tipoNotificacion=7;
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$idEventoCICERO=obtenerIDEventoAudienciaCicero($objConf["idEvento"]);
	if($idEventoCICERO=="")
		return;
	
	$objConf["idEventoCICERO"]=$idEventoCICERO;
	
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:CancelProceedingAction>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <proceedingActionLocalID>'.$idEventoCICERO.'</proceedingActionLocalID>
						 <cancellationMotiveLocalID>1</cancellationMotiveLocalID>
						 <cancellationMotiveComments>'.$objConf["motivoCancelacion"].'</cancellationMotiveComments>
					  </int:CancelProceedingAction>
				   </soapenv:Body>
				</soapenv:Envelope>';
	
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO);
				cancelarEventoAudienciaSala($objConf);

			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO,((String)$cXML->operation[0]["descr"][0]));
				eliminarEventoAudienciaCICERO01($objConf);				
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}	
		
}

function eliminarEventoAudienciaCICERO01($objConf)
{
	$tipoNotificacion=9;
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$idEventoCICERO=obtenerIDEventoAudienciaCicero($objConf["idEvento"]);
	if($idEventoCICERO=="")
		return;
	
	$objConf["idEventoCICERO"]=$idEventoCICERO;
	
	cancelarEventoAudienciaSala($objConf);
	
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:DeleteProceedingAction>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <proceedingActionLocalID>'.$idEventoCICERO.'</proceedingActionLocalID>
					  </int:DeleteProceedingAction>
				   </soapenv:Body>
				</soapenv:Envelope>';

	
			
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO,((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}	
		
}

///

function obtenerIDSesionCicero($objConf)
{
	global $con;
	$idSesion="";

	$tipoNotificacion=1;	
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:LogInUser>
						 <domain>S19001-CISE-01</domain>
						 <login>siugj</login>
						 <password>AXM2022*</password>
					  </int:LogInUser>
				   </soapenv:Body>
				</soapenv:Envelope>';
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	


			
			if(($cXML->operation[0]["returncode"][0]==0) && isset($cXML->operation[0]["idsession"][0]))
			{
				$idSesion=(String)$cXML->operation["idsession"][0];
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			return $idSesion;
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			return $idSesion;
			
		}
	}
	catch(Exception $e)
	{
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);
		return $idSesion;
	}
	
	
}

function registrarProcesoJudicialCicero($objConf)
{
	
	global $con;
	$tipoNotificacion=2;
	if(existeProcesoJudicialAudienciaCicero($objConf["carpetaAdministrativa"],$objConf["unidadGestion"]))
	{
		return;
	}
	
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$consulta="SELECT idReferencia FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$objConf["idSala"];
	$idSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveUnidad FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idSede;
	$cveSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT cC.cveDespacho,cC.tipoDespacho,cC.especialidad,cC.idJuez,cC.idSecretario 
				FROM _1273_tablaDinamica cD,_1273_gConfiguracionesCicero cC 
				WHERE cD.despacho='".$objConf["unidadGestion"]."' AND cC.idReferencia=cD.id__1273_tablaDinamica
				AND sede='".$cveSede."'";
	$fConfCicero=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$objConf["carpetaAdministrativa"].
			"' AND unidadGestion='".$objConf["unidadGestion"]."'";
	$tipoProceso=$con->obtenerValor($consulta);
	
	$consulta="SELECT cC.cveTipoProceso FROM _1275_tablaDinamica cD,_1275_gConfiguracionesCicero cC 
				WHERE cD.tipoProceso='".$tipoProceso."' AND cC.idReferencia=cD.id__1275_tablaDinamica
				AND sede='".$cveSede."'";
	$cveTipoProceso=$con->obtenerValor($consulta);
	
	
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
			   <soapenv:Header/>
			   <soapenv:Body>
				<int:CreateProceeding>
					 <login>siugj</login>
					 <sessionID>'.$objConf["sesionID"].'</sessionID>
					 <proceedingSgpID>'.$objConf["carpetaAdministrativa"].'</proceedingSgpID>
					 <judicialIssueLocalID>'.$fConfCicero["cveDespacho"].'</judicialIssueLocalID>
					 <judicialIssueTypeLocalID>'.$fConfCicero["tipoDespacho"].'</judicialIssueTypeLocalID>
					 <judicialIssueOrderTypeLocalID>'.$fConfCicero["especialidad"].'</judicialIssueOrderTypeLocalID>
					 <proceedingTypeLocalID>'.$cveTipoProceso.'</proceedingTypeLocalID>
					 <proceedingName>'.str_replace("-","",$objConf["carpetaAdministrativa"]).'</proceedingName>
					 <proceedingComments>Proceso SIUGJ ['.$objConf["idEvento"].']</proceedingComments>
				 </int:CreateProceeding>
			   </soapenv:Body>
			</soapenv:Envelope>';
	
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				$idProcesoCICERO=(String)$cXML->operation[0]->proceeding[0]["proceedingLocalID"][0];
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idProcesoCICERO);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],"",((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}
	
}


function registrarEventoAudienciaCicero($objConf)
{
	global $con;
	$tipoNotificacion=3;
	@registrarProcesoJudicialCicero($objConf);
	
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$consulta="SELECT idReferencia FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$objConf["idSala"];
	$idSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveUnidad FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idSede;
	$cveSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT cC.cveDespacho,cC.tipoDespacho,cC.especialidad,cC.idJuez,cC.idSecretario 
				FROM _1273_tablaDinamica cD,_1273_gConfiguracionesCicero cC 
				WHERE cD.despacho='".$objConf["unidadGestion"]."' AND cC.idReferencia=cD.id__1273_tablaDinamica
				AND sede='".$cveSede."'";
	$fConfCicero=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT cC.cveTipoAudiencia FROM _1261_tablaDinamica cD,_1261_gConfiguracionesCicero cC 
				WHERE cD.tipoAudiencia='".$objConf["tipoAudiencia"]."' AND cC.idReferencia=cD.id__1261_tablaDinamica
				AND sede='".$cveSede."'";
	$cveTipoAudiencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$objConf["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$idProcesoJudicial=obtenerIDProcesoJudicialAudienciaCicero($objConf["carpetaAdministrativa"],$objConf["unidadGestion"]);
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:CreateProceedingAction>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <proceedingActionSgpID>SIUGJ_'.$objConf["idEvento"].'</proceedingActionSgpID>
						 <proceedingLocalID>'.$idProcesoJudicial.'</proceedingLocalID>
						 <proceedingActionTypeLocalID>'.$cveTipoAudiencia.'</proceedingActionTypeLocalID>
						 <secretaryLocalID>'.$fConfCicero["idSecretario"].'</secretaryLocalID>
						 <judgeLocalID>'.$fConfCicero["idJuez"].'</judgeLocalID>
						 <date>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaInicioEvento"])).'</date>
						 <dateto>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaFinEvento"])).'</dateto>
						 <secret>2</secret>
						 <publish>1</publish>
						 <publishPrivate>1</publishPrivate>
						 <proceedingActionComments>SIUGJ Audiencia: '.$tipoAudiencia.' </proceedingActionComments>
						 <asociateDefaultProceedingSpeakers>1</asociateDefaultProceedingSpeakers>
						 <authorizeReserve>1</authorizeReserve>
					  </int:CreateProceedingAction>
				   </soapenv:Body>
				</soapenv:Envelope>';
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				$idEventoCICERO=(String)$cXML->operation[0]->proceedingAction[0]["proceedingActionLocalID"][0];
				$objConf["idEventoCICERO"]=$idEventoCICERO;
				
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO);
				asociarEventoAudienciaSala($objConf);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],"",((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}
}

function modificarEventoAudienciaCicero($objConf)
{
	global $con;
	$tipoNotificacion=4;
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$consulta="SELECT idReferencia FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$objConf["idSala"];
	$idSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveUnidad FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idSede;
	$cveSede=$con->obtenerValor($consulta);
	
	$consulta="SELECT cC.cveDespacho,cC.tipoDespacho,cC.especialidad,cC.idJuez,cC.idSecretario 
				FROM _1273_tablaDinamica cD,_1273_gConfiguracionesCicero cC 
				WHERE cD.despacho='".$objConf["unidadGestion"]."' AND cC.idReferencia=cD.id__1273_tablaDinamica
				AND sede='".$cveSede."'";
	$fConfCicero=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT cC.cveTipoAudiencia FROM _1261_tablaDinamica cD,_1261_gConfiguracionesCicero cC 
				WHERE cD.tipoAudiencia='".$objConf["tipoAudiencia"]."' AND cC.idReferencia=cD.id__1261_tablaDinamica
				AND sede='".$cveSede."'";
	$cveTipoAudiencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$objConf["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$idEventoCICERO=obtenerIDEventoAudienciaCicero($objConf["idEvento"]);
	if($idEventoCICERO=="")
		return;

	$objConf["idEventoCICERO"]=$idEventoCICERO;

	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:ModifyProceedingAction>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <proceedingActionLocalID>'.$idEventoCICERO.'</proceedingActionLocalID>
						 <proceedingActionTypeLocalID>'.$cveTipoAudiencia.'</proceedingActionTypeLocalID>
						 <secretaryLocalID>'.$fConfCicero["idSecretario"].'</secretaryLocalID>
						 <date>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaInicioEvento"])).'</date>
						 <dateto>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaFinEvento"])).'</dateto>
						 <secret>2</secret>
						 <publish>1</publish>
						 <publishPrivate>1</publishPrivate>
						 <proceedingActionComments>SIUGJ Audiencia: '.$tipoAudiencia.'</proceedingActionComments>
						 <proceedingActionActive>1</proceedingActionActive>
						 <authorizeReserve>1</authorizeReserve>
					  </int:ModifyProceedingAction>
				   </soapenv:Body>
				</soapenv:Envelope>';
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idEventoCICERO);
				cancelarEventoAudienciaSala($objConf);
				asociarEventoAudienciaSala($objConf);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],"",((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}
}

function asociarEventoAudienciaSala($objConf)
{
	global $con;
	
	$tipoNotificacion=5;
	/*if(existeReservaAudienciaSalaCicero($objConf["idEvento"]))
		return;*/
	
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$consulta="SELECT valorComplementario,claveSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$objConf["idSala"];
	$fSalaCicero=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:BookCourtRoom>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <proceedingActionLocalID>'.$objConf["idEventoCICERO"].'</proceedingActionLocalID>
						 <courtRoomLocalID>'.$fSalaCicero["valorComplementario"].'</courtRoomLocalID>
						 <bookingDescription>Asignación de Sala: '.$fSalaCicero["claveSala"].' a Evento '.$objConf["idEventoCICERO"].' (SIUGJ '.$objConf["idEvento"].') </bookingDescription>
						 <bookingStartDateTime>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaInicioEvento"])).'</bookingStartDateTime>
						 <bookingEndDateTime>'.date("Y-m-d\TH:i:s",strtotime($objConf["horaFinEvento"])).'</bookingEndDateTime>
					  </int:BookCourtRoom>
				   </soapenv:Body>
				</soapenv:Envelope>';
			
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				$idBloqueoCICERO=(String)$cXML->operation[0]->booking[0]["bookingLocalID"][0];
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idBloqueoCICERO);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],"",((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}
	
}

function cancelarEventoAudienciaSala($objConf)
{
	global $con;
	
	$tipoNotificacion=6;
	$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$objConf["idEvento"]);
	$urlWebServices=$objConf["urlServicioGrabacion"];
	
	$idBloqueoCICERO=obtenerIDReservaAudienciaSalaCicero($objConf["idEvento"]);
	
	$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://interfaces.api.cicero.xtream.es">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <int:CancelBookingForCourtRoom>
						 <login>siugj</login>
						 <sessionID>'.$objConf["sesionID"].'</sessionID>
						 <bookingLocalID>'.$idBloqueoCICERO.'</bookingLocalID>
					  </int:CancelBookingForCourtRoom>
				   </soapenv:Body>
				</soapenv:Envelope>';
	
			
	try
	{
		$curl = curl_init($urlWebServices);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		
		$info = curl_getinfo($curl);
		
		$arrRespuesta=explode("<S:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</S:Body>",$xml);
			$xml=$arrRespuesta[0];
			$cXML=simplexml_load_string($xml);	
			
			if($cXML->operation[0]["returncode"][0]==0)
			{
				$idBloqueoCICERO=(String)$cXML->operation[0]->booking[0]["bookingLocalID"][0];
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,1,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],$idBloqueoCICERO);
			}
			else
			{
				registrarSituacionAccionEventoAudienciaOperador($objConf["idEvento"],$tipoNotificacion,0,$objConf["carpetaAdministrativa"],$objConf["unidadGestion"],"",((String)$cXML->operation[0]["descr"][0]));
			}
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,$cXML->operation[0]["returncode"][0],$curl_response,$urlWebServices);
			
		}
		else
		{
			@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1000","Sin respuesta del servicio",$urlWebServices);
			
			
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		@actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$xmlSolicitud,"-1001",$e->getMessage(),$urlWebServices);

	}
	
}



///
function esRegistroNuevoEventoAudienciaCicero($idEventoAudiencia)
{
	global $con;
	$consulta="SELECT COUNT(*) FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento=".$idEventoAudiencia." AND tipoAccion=3 AND notificado=1";
	$numReg=$con->obtenerValor($consulta);
	return $numReg==0;
}

function existeProcesoJudicialAudienciaCicero($carpetaAdministrativa,$unidadGestion)
{
	global $con;
	$consulta="SELECT COUNT(*) FROM 7000_notificacionesEventosOperadoresServicios WHERE idReferencia1='".$carpetaAdministrativa.
			"' AND idReferencia2='".$unidadGestion."' and tipoAccion=2 AND notificado=1";


	$numReg=$con->obtenerValor($consulta);
	
	return $numReg>0;
}

function existeReservaAudienciaSalaCicero($idEventoAudiencia)
{
	global $con;
	$consulta="SELECT COUNT(*) FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento='".$idEventoAudiencia.
			"' and tipoAccion=5 AND notificado=1";


	$numReg=$con->obtenerValor($consulta);
	
	return $numReg>0;
}

function obtenerIDReservaAudienciaSalaCicero($idEventoAudiencia)
{
	global $con;
	$consulta="SELECT valorComplementario1 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento='".$idEventoAudiencia.
			"' and tipoAccion=5 AND notificado=1 order by idRegistro desc";


	$idReserva=$con->obtenerValor($consulta);
	
	return $idReserva;
}

function obtenerIDProcesoJudicialAudienciaCicero($carpetaAdministrativa,$unidadGestion)
{
	global $con;
	$consulta="SELECT valorComplementario1 FROM 7000_notificacionesEventosOperadoresServicios WHERE idReferencia1='".$carpetaAdministrativa.
			"' AND idReferencia2='".$unidadGestion."' and tipoAccion=2 AND notificado=1";
	$idProceso=$con->obtenerValor($consulta);
	return $idProceso;
}

function obtenerIDEventoAudienciaCicero($idEventoAudiencia)
{
	global $con;
	$consulta="SELECT valorComplementario1 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento='".$idEventoAudiencia.
			"' AND tipoAccion=3 AND notificado=1";
	$idEventoCicero=$con->obtenerValor($consulta);
	return $idEventoCicero;
}


?>