<?php	session_start();
include("conexionBD.php");
	
try
{
	global $con;
	global $baseDir;
	global $respaldarDocumentoPrevioFirma;
	$respaldarDocumentoPrevioFirma=true;
	$folioQR="";
	$cadObj=$_POST["cadObj"];
	$objMater=json_decode($cadObj);
	$obj=$objMater->objOriginal;
	
	$idDocumento="NULL";

	
	$consulta="SELECT idFormulario,idRegistro,idDocumentoAdjunto,documentoBloqueado FROM 3000_formatosRegistrados 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
	$fFormato=$con->obtenerPrimeraFila($consulta);
	
	$iFormulario=$fFormato[0];
	$iRegistro=$fFormato[1];

	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
	
	$fDatosInformacion=NULL;
	$tipoDocumentoDefault="";
	if($fFormato[0]==-2)
	{
		$consulta="SELECT idFormulario,idReferencia,tipoDocumento,tituloDocumento FROM 7035_informacionDocumentos WHERE idRegistro=".$fFormato[1];
		$fDatosInformacion=$con->obtenerPrimeraFila($consulta);
		$tipoDocumentoDefault=$fDatosInformacion[2];
		$iFormulario=$fDatosInformacion[0];
		$iRegistro=$fDatosInformacion[1];
	
		
	}
	$documentoBloqueado=$obj->documentoFinal==0?2:1;
	
	$urlUpload="http://validmobile.iqsec.mx/SubirAudio/Upload.ashx";
	$urlCreatePkcs7="https://validmobile.iqsec.mx/WSCommerceFiel/WebService.asmx";
	$urlDescarga="https://validmobile.iqsec.mx/documentos";
	$idTransaccion=$objMater->transfer;
	$archivoBase=$objMater->archivoDestino;
	
	
	$cf = new CURLFile($archivoBase);
	$ch = curl_init($urlUpload);
	curl_setopt($ch, CURLOPT_URL, $urlUpload);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, ["audio" => $cf]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);

	$oResp=json_decode($result);

	
	if(($oResp)||($oResp->archivos[0]->status==0))
	{
		$xmlSolicitud='<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
						<Header>
							<AuthSoap xmlns="www.XMLWebServiceSoapHeaderAuth.net">
								<User>userws</User>
								<Password>BU47MIcINw6gKdwuvRZGxJjVnXIDyeGkTPBITfmOWBo=</Password>
								<Entity>pjem</Entity>
							</AuthSoap>
						</Header>
						<Body>
							<WSCreatePkcs7FromNs xmlns="www.XMLWebServiceSoapHeaderAuth.net">
								<referencia></referencia>
								<source>C:\\inetpub\\wwwroot\\SubirAudio\\subidas\\'.$oResp->archivos[0]->nombre.'</source>
								<target>C:\\inetpub\\wwwroot\\documentos\\'.$oResp->archivos[0]->nombre.'.p7s</target>
								<ens>'.$idTransaccion.'</ens>
							</WSCreatePkcs7FromNs>
						</Body>
					</Envelope>';
					
		$curl = curl_init($urlCreatePkcs7);
		$curl_post_data = $xmlSolicitud;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8'
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);
		$curl_response=str_replace("soap:","",$curl_response);
		
		$objXml=simplexml_load_string($curl_response,'SimpleXMLElement', LIBXML_NOWARNING);
		if($objXml)
		{
			$estado=(String)$objXml->Body[0]->WSCreatePkcs7FromNsResponse->WSCreatePkcs7FromNsResult->State;
			$msgError=(String)$objXml->Body[0]->WSCreatePkcs7FromNsResponse->WSCreatePkcs7FromNsResult->Description;
			
			if($estado==0)
			{
				$xmlSolicitud='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xw="www.XMLWebServiceSoapHeaderAuth.net">
							   <soapenv:Header>
								  <xw:AuthSoapHd>
									 <xw:Usuario>userws</xw:Usuario>
									 <xw:Clave>BU47MIcINw6gKdwuvRZGxJjVnXIDyeGkTPBITfmOWBo=</xw:Clave>
									 <xw:Entidad>pjem</xw:Entidad>
								  </xw:AuthSoapHd>
							   </soapenv:Header>
							   <soapenv:Body>
								  <xw:PwuObtienePdf>
									 <xw:reference></xw:reference>
									 <xw:source>C:\\inetpub\\wwwroot\\documentos\\'.$oResp->archivos[0]->nombre.'.p7s</xw:source>
									 <xw:target>C:\\inetpub\\wwwroot\\documentos\\'.$oResp->archivos[0]->nombre.'.p7s.pdf</xw:target>
								  </xw:PwuObtienePdf>
							   </soapenv:Body>
							</soapenv:Envelope>';
				$curl = curl_init($urlCreatePkcs7);
				$curl_post_data = $xmlSolicitud;
				
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
				curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
																'Content-Type: text/xml;charset=UTF-8'
																)                                                                       
							);                                                                                                                   
											
				$curl_response = curl_exec($curl);
				$curl_response=str_replace("soap:","",$curl_response);
				
				$objXml=simplexml_load_string($curl_response,'SimpleXMLElement', LIBXML_NOWARNING);
				if($objXml)
				{
					$estado=(String)$objXml->Body[0]->PwuObtienePdfResponse->PwuObtienePdfResult->State;
					$msgError=(String)$objXml->Body[0]->PwuObtienePdfResponse->PwuObtienePdfResult->Descript;
					if($estado==0)
					{
						$directorioDestino=$baseDir."/archivosTemporales/";
						
						
						$documento1=file_get_contents($urlDescarga."/".$oResp->archivos[0]->nombre.'.p7s.pdf');
						$documento2=file_get_contents($urlDescarga."/".$oResp->archivos[0]->nombre.'.p7s');
						
						if($documento1!="")
						{
							$cuerpoDocumentoSinFirma=leerContenidoArchivo($objMater->archivoDestino);
							$r1=escribirContenidoArchivo($objMater->archivoDestino,$documento1);
							$archivoTemporalDestino=str_replace(".pdf","",$objMater->archivoDestino).".pkcs7";
							$r2=escribirContenidoArchivo($archivoTemporalDestino,$documento2);
							
							if($r1 && $r2)
							{
								
								if($fFormato[2]!="") //Documento adjunto
								{
									
									$idDocumento=$fFormato[2];
									
									$archivoOrigen=obtenerRutaDocumento($fFormato[2]);
									
									//actualizar en repositorio
									if(copy($objMater->archivoDestino,$archivoOrigen)&&copy($archivoTemporalDestino,$archivoOrigen.".pkcs7"))
									{
									
									
										if($respaldarDocumentoPrevioFirma)
										{
											$numRespaldo=1;
											
											$nombreRespaldo=$archivoOrigen.".resp";
											while(file_exists($nombreRespaldo))
											{
												$nombreRespaldo=$archivoOrigen.".resp".$numRespaldo;
												$numRespaldo++;
											}
											$r1=escribirContenidoArchivo($nombreRespaldo,$cuerpoDocumentoSinFirma);
										}
										
										$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumento;
										$nomArchivoOriginal=$con->obtenerValor($consulta);
										$arrArchivos=explode(".",$nomArchivoOriginal);
										
										
										$arrArchivos[sizeof($arrArchivos)-1]=".pdf";
										
										$nomArchivoOriginal=implode("",$arrArchivos);
										$sha512=strtoupper(hash_file ( "sha512" , $objMater->archivoDestino,false ));
										$consulta="update 908_archivos set folioQR=NULL, nomArchivoOriginal='".$nomArchivoOriginal."',tamano='".filesize($objMater->archivoDestino).
													"',sha512='".$sha512."'  WHERE idArchivo=".$idDocumento;
										$con->ejecutarConsulta($consulta);
										if($documentoBloqueado==1)
										{
											if($carpetaAdministrativa!="")
												registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,$iFormulario,$iRegistro);			
											registrarDocumentoResultadoProceso($iFormulario,$iRegistro,$idDocumento);
										}
									
										
										
										$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena.
												"',firmado=1,responsableFirma=".$_SESSION["idUsr"].
												",documentoBloqueado=".$documentoBloqueado."	WHERE idRegistroFormato=".$obj->idRegistroFormato;
										if($con->ejecutarConsulta($consulta))
										{
											if(isset($obj->etapaEnvioFirma))
											{
												cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
											}
											echo '{"resultado":"1","mensaje":""}';
										}
										
										
										unlink($objMater->archivoDestino);
										unlink($archivoTemporalDestino);
										return;
									}
									
								}
								else  //plantilla
								{
									$consulta="SELECT cuerpoFormato,cadenaFirma,documentoBloqueado,tipoFormato,idFormulario,idRegistro FROM 3000_formatosRegistrados 
											WHERE idRegistroFormato=".$obj->idRegistroFormato;
									
									$fDocumento=$con->obtenerPrimeraFila($consulta);
									$iFormulario=$fDocumento[4];
									$iRegistro=$fDocumento[5];
									$cuerpoFormato=$fDocumento[0];
									
									descomponerDocumentoMarcadores($obj->idRegistroFormato,$cuerpoFormato);
									
									
									$consulta="SELECT nombreFormato,categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fDocumento[3];
									$fDocumentoFinal=$con->obtenerPrimeraFila($consulta);
									if(!$fDocumentoFinal)
									{
										$fDocumentoFinal[0]="Documento General";
										$fDocumentoFinal[1]=0;
									}
						
									$nombreArchivoPDF=$fDocumentoFinal[0].".pdf";
									
									$idRegistro=registrarDocumentoServidorRepositorio(basename($objMater->archivoDestino),$nombreArchivoPDF,$fDocumentoFinal[1]);
									if($idRegistro==-1)
									{
										return false;
									}	
									$idDocumento=$idRegistro;
				
									
									if($documentoBloqueado==1)
									{
			
										$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fDocumento[4],$fDocumento[5]);
			
										if($carpetaAdministrativa!="")
										{

											$categoriaDocumento=$fDocumentoFinal[1];
											registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idRegistro,$iFormulario,$iRegistro,-1,$categoriaDocumento);
											registrarDocumentoResultadoProceso($iFormulario,$iRegistro,$idDocumento);
										}
									}
			
									$consulta="update 3000_formatosRegistrados set formatoPDF=1,documentoBloqueado=".$documentoBloqueado.
												",idDocumento=".$idDocumento.",idDocumentoAdjunto=".$idDocumento.",fechaBloqueo=".
												($documentoBloqueado==1?("'".date("Y-m-d H:i:s")."'"):"NULL").
												",fechaFirma='".date("Y-m-d H:i:s")."',firmado=1,responsableFirma=".$_SESSION["idUsr"].
												",cadenaFirma='".$obj->cadena."' where idRegistroFormato=".$obj->idRegistroFormato;
									if($con->ejecutarConsulta($consulta))
									{
										if(file_exists($objMater->archivoDestino))
										{
											unlink($objMater->archivoDestino);
											unlink($archivoTemporalDestino);
										}
										if(isset($obj->etapaEnvioFirma))
										{
											cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
										}
										echo '{"resultado":"1","mensaje":""}';
										return;
									}
									
								}
								
								
							}
							else
							{
								
								echo '{"resultado":"0","mensaje":"'.bE("No se han podido guardar los documentos firmados").'"}';
								return ;
							}
						}
						else
						{
							
							echo '{"resultado":"0","mensaje":"'.bE("No se pudo descargar documento firmado").'"}';
							return ;
						}
						
						
					}
					else
					{
						echo '{"resultado":"0","mensaje":"'.bE($msgError).'"}';
						return;
					}
				
				}
				else
				{
					echo '{"resultado":"0","mensaje":"'.bE("No se ha podido generar el archivo PDF firmado").'"}';
					return;
				}
				
			}
			else
			{
				echo '{"resultado":"0","mensaje":"'.bE($msgError).'"}';
				return;
			}
			
		}
		else
		{
			echo '{"resultado":"0","mensaje":"'.bE("No se ha podido generar el archivo Pkcs7").'"}';
			return;
		}
		
	}
	else
	{
		echo '{"resultado":"0","mensaje":"'.bE("No se ha podido realizar la subida del documento al servidor").'"}';
		return;
	}
	
		
}
catch(Exception $e)
{

	echo '{"resultado":"0","mensaje":"'.bE($e->getMessage()).'"}';

}
	
	
	
?>