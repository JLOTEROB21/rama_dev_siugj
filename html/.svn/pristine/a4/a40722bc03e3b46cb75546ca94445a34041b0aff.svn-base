<?php session_start();
	$_SESSION["idUsr"]=1;
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("funcionesNeotrai.php");
	
	
	include_once("sgjp/siajop.php");
	include_once("latisErrorHandler.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	
	function registrarDigitacionDocumento($datosDocumento)
	{
		global $con;
		$idFolioSolicitud="";
		try
		{
			$consulta="INSERT INTO 8000_notificacionesDocumentosEscaner(fechaRegistro,valorRecibido,situacion) VALUES('".date("Y-m-d H:i:s").
					"','".bE($datosDocumento)."',0)";
			if($con->ejecutarConsulta($consulta))
			{
				$objDocs=json_decode(str_replace('" ','"',$datosDocumento));
				$idFolioSolicitud=$con->obtenerUltimoID();
				
				$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=1";
				$iFormularioMaterias=$con->obtenerValor($consulta);
				
				if($objDocs->IdAplicativo==1)
				{
					$consulta="SELECT idCsDocs,idExpediente FROM _478_expedientesVSArchivos WHERE idDocumento=".$objDocs->IdDocumento;
					$fBusqueda=$con->obtenerPrimeraFila($consulta);
					if($fBusqueda)
					{
						$datosDocumento=str_replace('"IdAplicativo":"1.0",','"IdAplicativo":"'.$fBusqueda[0].'","idExpediente":"'.$fBusqueda[1].'",',$datosDocumento);
						$objDocs=json_decode(str_replace('" ','"',$datosDocumento));
					}
					else
					{
						$consulta="SELECT idArchivo FROM 908_archivos WHERE idDocumentoOPC=".$objDocs->IdDocumento;
						$idArchivo=$con->obtenerValor($consulta);
						$consulta="SELECT idFormulario,idRegistro FROM 9074_documentosRegistrosProceso WHERE idDocumento=".$idArchivo." AND tipoDocumento=3";
						
						$fDatosDocumentosBase=$con->obtenerPrimeraFila($consulta);
						
						$consulta="SELECT tipoDelito FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u,_17_gridDelitosAtiende d WHERE 
								u.claveUnidad=c.unidadGestion AND d.idReferencia=u.id__17_tablaDinamica AND c.idFormulario=".$fDatosDocumentosBase[0].
								" AND c.idRegistro=".$fDatosDocumentosBase[1];
						
						$tDelito=$con->obtenerValor($consulta);
						$consulta="SELECT idCsDocs FROM _".$iFormularioMaterias."_tablaDinamica WHERE claveMateria='".$tDelito."'";
						$objDocs->IdAplicativo=$con->obtenerValor($consulta);
					}
				}
				
				
				$consulta="SELECT claveOPC,materia,idCsDocs,ipServidor,puerto FROM _".$iFormularioMaterias."_tablaDinamica WHERE idCsDocs=".$objDocs->IdAplicativo;
				$fMateria=$con->obtenerPrimeraFila($consulta);
				if(!$fMateria)
				{
					$consulta="UPDATE 8000_notificacionesDocumentosEscaner SET situacion=2 WHERE idRegistro=".$idFolioSolicitud;
					$con->ejecutarConsulta($consulta);
					
					return '{"status":"0","noError":"1","mensaje":"La clave de materia NO existe"}';
					
				}	
				
			
				if($fMateria[3]=='127.0.0.1')
				{
					
					//if(isset($objDocs->idExpediente))
					{
						$consulta="SELECT idArchivo FROM 908_archivos WHERE idDocumentoOPC=".$objDocs->IdDocumento;

	
						$iArchivo=$con->obtenerValor($consulta);
						if($iArchivo=="")
							$iArchivo=-1;
						
						$objDocs->IdDocumento=$iArchivo;
						
					}
					$nombreDocumento="";
					$arrNombreDoc=explode(".",$objDocs->nombreDocumento);
					for($x=0;$x<sizeof($arrNombreDoc)-1;$x++)
					{
						if($nombreDocumento=="")
							$nombreDocumento=$arrNombreDoc[$x];
						else
							$nombreDocumento.="-".$arrNombreDoc[$x];
					}
					$nombreDocumento.=".".$arrNombreDoc[sizeof($arrNombreDoc)-1];
					$consulta="UPDATE 908_archivos SET fechaCreacion='".$objDocs->created_at."',tamano=".$objDocs->tamanoArchivo.",documentoRepositorio=".$objDocs->idGlobal.
							",nomArchivoOriginal='".cv($nombreDocumento)."' WHERE idArchivo=".$objDocs->IdDocumento;

					if($con->ejecutarConsulta($consulta))
					{
						$consulta="UPDATE 9074_documentosRegistrosProceso SET tipoDocumento=2 WHERE idDocumento=".$objDocs->IdDocumento." AND tipoDocumento=3";
						$con->ejecutarConsulta($consulta);
						
						$consulta="SELECT idFormulario,idRegistro FROM 9074_documentosRegistrosProceso WHERE idDocumento=".$objDocs->IdDocumento;
						$fInfoDoc=$con->obtenerPrimeraFila($consulta);
						if($fInfoDoc)
						{
							$estadoCambio=0;
							$cAdministrativa=obtenerCarpetaAdministrativaProceso($fInfoDoc[0],$fInfoDoc[1]);
							$idCarpetaAdministrativa=-1;
							switch($fInfoDoc[0])
							{
								case 478:
									$consulta="SELECT idCarpeta FROM _478_tablaDinamica rE,7006_carpetasAdministrativas c WHERE id__478_tablaDinamica=".$fInfoDoc[1].
												" AND c.carpetaAdministrativa=rE.carpetaAdministrativa AND c.unidadGestion=rE.codigoInstitucion";
									$idCarpetaAdministrativa=$con->obtenerValor($consulta);
									
									
									$consulta="SELECT idEstado FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$fInfoDoc[1];
									$idEstadoActual=$con->obtenerValor($consulta);
									
									switch($idEstadoActual)
									{
										case 1.6:
											$estadoCambio=3;
										break;
										case 2:
											$estadoCambio=4;
										break;
									}
									
								break;
							}
							registrarDocumentoCarpetaAdministrativa($cAdministrativa,$objDocs->IdDocumento,$fInfoDoc[0],$fInfoDoc[1],$idCarpetaAdministrativa);
							if($estadoCambio!=0)
							{
								cambiarEtapaFormulario($fInfoDoc[0],$fInfoDoc[1],$estadoCambio,"",-1,"NULL","NULL",851);
							}
						}
						$consulta="UPDATE 8000_notificacionesDocumentosEscaner SET situacion=1 WHERE idRegistro=".$idFolioSolicitud;
						$con->ejecutarConsulta($consulta);
						return '{"status":"1","noError":"","mensaje":""}';	
					}
					
				}
				else
				{
					$urlWebServices="http://".$fMateria[3].":".$fMateria[4]."/webServices/wsEscaner.php?wsdl";
		
					$client = new nusoap_client($urlWebServices,"wsdl"); 
					$parametros=array();
					$parametros["datosDocumento"]=$datosDocumento;
					$docXML = $client->call("registrarDigitacionDocumento", $parametros);
					
					$oResp=json_decode($docXML);
					/*if($oResp->status==1)
					{
						$consulta="delete from 8000_notificacionesOPC  WHERE idRegistro=".$idFolioSolicitud;
						$con->ejecutarConsulta($consulta);
					}*/
					
					return $docXML;
					
				}
			
				
			}
		}
		catch(Exception $e)
		{
			$consulta="UPDATE 8000_notificacionesDocumentosEscaner SET situacion=6 WHERE idRegistro=".$idFolioSolicitud;
			$con->ejecutarConsulta($consulta);
			return '{"status":"0","noError":"6","mensaje":"'.cv($e->$e->getMessage()).'"}';

		}
		
		
	}
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('registrarDigitacionDocumento',array('datosDocumento'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
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