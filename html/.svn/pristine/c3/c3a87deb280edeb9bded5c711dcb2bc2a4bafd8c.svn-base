<?php	session_start();
include("conexionBD.php");
	error_reporting(E_ALL);
	
	try
	{
		
		global $con;
		global $baseDir;
		global $utilizarServidorQR;
		global $respaldarDocumentoPrevioFirma;
		$folioQR="";
		
		$esFirmaElectronica=false;
		$cadObj="";
		if(!isset($_POST["cadObj"]))
		{
			$esFirmaElectronica=true;
			foreach($_POST as $campo=>$valor)
			{
				$campoValor='"'.$campo.'":"'.cv($valor).'"';
				if($cadObj=="")
					$cadObj=$campoValor;
				else
					$cadObj.=",".$campoValor;
			}
	
			$cadObj='{'.$cadObj.'}';
		}
		else
		{
			$cadObj=$_POST["cadObj"];
		}
		$obj=json_decode($cadObj);
		

		
		$documentosAnexos="";
		if(isset($obj->documentosAnexos))
			$documentosAnexos=$obj->documentosAnexos;
		
		$idDocumento="NULL";
		$documentoBloqueado=0;
		
		
		
		
		$consulta="SELECT idFormulario,idRegistro,idDocumentoAdjunto,documentoBloqueado FROM 3000_formatosRegistrados 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$fFormato=$con->obtenerPrimeraFila($consulta);
		$iFormulario=$fFormato[0];
		$iRegistro=$fFormato[1];
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
		
		if($fFormato[3]==1)
		{
			echo '{"resultado":"1","mensaje":""}';
			return;
		}
		
		
		
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
		
		if(isset($obj->idArchivo))
		{
			
			$consulta="SELECT tipoFormato FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$tipoFormato=$con->obtenerValor($consulta);
			
			if($tipoFormato!=0)
			{
				$consulta="SELECT categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoFormato;
				$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
				$tipoDocumentoDefault=$fDatosDocumento[0];
			}
			$idRegistro=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->cadena,$tipoDocumentoDefault);
			if($idRegistro==-1)
			{
				return;
			}	
			$idDocumento=$idRegistro;
			$obj->cadena="";
			
	
			
			
			
			if($carpetaAdministrativa!="")
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idRegistro,$iFormulario,$iRegistro);
			if($iFormulario>0)
				registrarDocumentoResultadoProceso($iFormulario,$iRegistro,$idRegistro);
				
		}
		else
		{
			if($fFormato[2]!="")
			{
				$idDocumento=$fFormato[2];
			}
		}
		
		
		if(isset($obj->idArchivo)||($fFormato[2]!=""))//Doc adjunto
		{
			
			if(($fFormato[2]!="")&&(!isset($obj->idArchivo)))
			{
				
				$directorioDestino=$baseDir."/archivosTemporales/";
				$archivoOrigen=obtenerRutaDocumento($fFormato[2]);
				$cuerpoDocumentoSinFirma=bD(obtenerCuerpoDocumentoB64($fFormato[2]));
				$infoOrigen=pathinfo($archivoOrigen);
				
				$archivoDestino=$directorioDestino."/".$infoOrigen["basename"].".pdf";
				$archivoTemporalDestino=$directorioDestino."/".$infoOrigen["basename"];
				
				
				$consulta="SELECT LOWER(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$fFormato[2];
				$nombreArchivoOrigen=$con->obtenerValor($consulta);
				
				$arrNombreArchivo=explode(".",$nombreArchivoOrigen);
				$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
				if(($fFormato[3]==0)&&($extension!="pdf"))
				{
					convertirWordToPDFServidorConversion($archivoOrigen,$archivoDestino);
				}
				else
				{
					copy($archivoOrigen,$archivoDestino);
				}

				if(file_exists($archivoDestino))
				{
					$archivoCER="";
					$archivoKEY="";
					if($obj->tipoFirma==1)
					{
						$archivoCER=bE(leerContenidoArchivo($_FILES["fCer"]["tmp_name"]));
						$archivoKEY=bE(leerContenidoArchivo($_FILES["fKey"]["tmp_name"]));
					}
					else
					{
						$archivoCER=bE(leerContenidoArchivo($_FILES["fCer"]["tmp_name"]));
					}
					$passwd=decodificarAES_Encrypt($obj->passwd,$valInicio,$valFin);
					
					$tipoCertificado=$obj->tipoFirma;
					
					$cuerpoDocumento=bE(leerContenidoArchivo($archivoDestino));
					
					if(($utilizarServidorQR)&&($documentoBloqueado==1))
					{
						$pdf = new FPDI();

						$pdf->setSourceFile($archivoDestino); 
						// import page 1 
						$tplIdx = $pdf->importPage(1); 
						$arrTamano=$pdf->getTemplateSize($tplIdx);
						$pdf->Close();
						
						$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$_SESSION["codigoInstitucion"]."'";
						$areaEmisora=$con->obtenerValor($consulta);
						
						$consulta="SELECT Nombre FROM 800_usuarios WHERE idUsuario=".$_SESSION["idUsr"];
						$usuarioEmisor=$con->obtenerValor($consulta);
						
						$objDocumentoPDF=array();
						$objDocumentoPDF["areaEmisora"]=$areaEmisora;
						$objDocumentoPDF["usuarioEmisor"]=$usuarioEmisor;
						$objDocumentoPDF["documentoPDF"]=$cuerpoDocumento;
						$objDocumentoPDF["nombreDocumento"]=$infoOrigen["basename"].".pdf";
						$objDocumentoPDF["fechaDocumento"]=date("Y-m-d");
						$objDocumentoPDF["posX"]=182;
						$factorEscala=(0.94779819-((342.9-$arrTamano["h"])*0.00042543));
						$objDocumentoPDF["posY"]=$arrTamano["h"]*$factorEscala;
						$respuestaResultado=generarCodigoQRPDF($objDocumentoPDF);
						if(!$respuestaResultado)
						{
							echo '{"resultado":"0","mensaje":"'.bE("NO se ha podido generar el c&oacute;digo QR del documento").'"}';
							return;
						}
						else
						{
							if($respuestaResultado["estatus"]==1)
							{
								$folioQR=$respuestaResultado["n_documento"];
								$cuerpoDocumento=$respuestaResultado["pdfSellado"];
							}
							else
							{
								echo '{"resultado":"0","mensaje":"'.bE($respuestaResultado["mensaje"]).'"}';
								return;
							}

						}
					}
					
					unlink($archivoDestino);
					
					$client = new nusoap_client($URLServidorFirma."?wsdl","wsdl");
					$parametros=array();
					$parametros["tipoCertificado"]=$tipoCertificado;
					$parametros["documentoDestino"]=$infoOrigen["basename"].".pdf";
					$parametros["contenidoDocument"]=$cuerpoDocumento;
					$parametros["contenidoCer"]=$archivoCER;
					$parametros["contenidoKey"]=$archivoKEY;
					$parametros["passwd"]=$passwd;
					$parametros["llaveFirmado"]=$llaveFirmado;
					$parametros["idUsuarioFirma"]=$_SESSION["idUsr"];
					varDUmp($parametros);
					$response = $client->call($nombreFuncionFirma, $parametros);
					$oResp=json_decode($response[$nombreFuncionFirma."Result"]);
	
					if($oResp->resultado==1)
					{
						
						$r1=escribirContenidoArchivo($archivoTemporalDestino,bD($oResp->documento));
						$r2=escribirContenidoArchivo($archivoTemporalDestino.".pkcs7",bD($oResp->PKCS7));
						
						if($r1 && $r2)
						{
							if(copy($archivoTemporalDestino,$archivoOrigen)&&copy($archivoTemporalDestino.".pkcs7",$archivoOrigen.".pkcs7"))
							{
								unlink($archivoTemporalDestino);
								unlink($archivoTemporalDestino.".pkcs7");
								
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
								$sha512=strtoupper(hash_file ( "sha512" , $archivoOrigen,false ));
								$consulta="update 908_archivos set folioQR='".$folioQR."', nomArchivoOriginal='".$nomArchivoOriginal."',tamano='".filesize($archivoOrigen).
											"',sha512='".$sha512."'  WHERE idArchivo=".$idDocumento;
								$con->ejecutarConsulta($consulta);
								if($documentoBloqueado==1)
								{
									
									if($carpetaAdministrativa!="")
										registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,$iFormulario,$iRegistro);			
									registrarDocumentoResultadoProceso($iFormulario,$iRegistro,$idDocumento);
								}
							
								
								
								$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena.
										"',firmado=1,responsableFirma=".$_SESSION["idUsr"].",documentoBloqueado=".$documentoBloqueado."	WHERE idRegistroFormato=".$obj->idRegistroFormato;
								if($con->ejecutarConsulta($consulta))
								{
									if(isset($obj->etapaEnvioFirma))
									{
										cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
									}
									echo '{"resultado":"1","mensaje":""}';
								}
								return;
							}
							else
							{
	
								echo '{"resultado":"0","mensaje":"'.bE("No se han podido guardar los documentos firmadosen el directorio de repositorio").'"}';
								return ;
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
						
						echo '{"resultado":"0","mensaje":"'.cv($oResp->mensaje).'"}';
						return;
					}
					
					
					
				}
				else
				{
					echo '{"resultado":"0","mensaje":"'.bE("No se ha podido generar la versión PDF del documento").'"}';
					return;
				}
			}
			else
			{
				
				
				$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena."',firmado=1,responsableFirma=".$_SESSION["idUsr"].",documentoBloqueado=".$documentoBloqueado." 
											WHERE idRegistroFormato=".$obj->idRegistroFormato;
				if($con->ejecutarConsulta($consulta))
				{
					if(isset($obj->etapaEnvioFirma))
					{
						cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
					}
					$nomArchivoOriginal="";
					
					if($fFormato[2]!="")
					{
						$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fFormato[2];
						$nomArchivoOriginal=$con->obtenerValor($consulta);
						$arrArchivos=explode(".",$nomArchivoOriginal);
						$arrArchivos[sizeof($arrArchivos)-1]=".pdf";
						$nomArchivoOriginal=implode("",$arrArchivos);
					}
					else
					{
						if($fDatosInformacion)
						{
							$nomArchivoOriginal=$fDatosInformacion[3].".pdf";
						}
					}
					
					if($nomArchivoOriginal!="")
					{
						$consulta="UPDATE 908_archivos SET nomArchivoOriginal='".$nomArchivoOriginal."' WHERE idArchivo=".$idDocumento;				
						$con->ejecutarConsulta($consulta);
					}
					echo '{"resultado":"1","mensaje":""}';
				}
				return;
			}
			
		}
		else //Plantilla
		{
			
			$archivoCER="";
			$archivoKEY="";
			if($obj->tipoFirma==1)
			{
				$archivoCER=bE(leerContenidoArchivo($_FILES["fCer"]["tmp_name"]));
				$archivoKEY=bE(leerContenidoArchivo($_FILES["fKey"]["tmp_name"]));
			}
			else
			{
				$archivoCER=bE(leerContenidoArchivo($_FILES["fCer"]["tmp_name"]));
			}
			$passwd=decodificarAES_Encrypt($obj->passwd,$valInicio,$valFin);
			$resultado=generarDocumentoPDFFormatoFirmaElectronica($obj->idRegistroFormato,true,$obj->tipoFirma,$archivoCER,$archivoKEY,$passwd,$documentosAnexos,$documentoBloqueado);
			if($resultado->resultado)
			{
				
				$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s").
							"',cadenaFirma='".$obj->cadena."',firmado=1,responsableFirma=".$_SESSION["idUsr"].
							",documentoBloqueado=".$documentoBloqueado." WHERE idRegistroFormato=".$obj->idRegistroFormato;
				if($con->ejecutarConsulta($consulta))
				{
					if(isset($obj->etapaEnvioFirma))
					{
						cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
					}
					echo '{"resultado":"1","mensaje":""}';
				}
			}
			else
			{
				echo '{"resultado":"0","mensaje":"'.cv($resultado->mensaje).'"}';
			}
		}
	
	}
	catch(Exception $e)
	{

		echo '{"resultado":"0","mensaje":"'.bE($e->getMessage()).'"}';
  
	}
?>