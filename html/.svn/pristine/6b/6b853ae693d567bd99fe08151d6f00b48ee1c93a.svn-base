<?php	session_start();
include("conexionBD.php");
include_once("cConectoresGestorContenido/cOneDrive.php");	
	
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
		
		$consulta="SELECT idFormulario,idRegistro,if(idDocumento is not null,idDocumento,idDocumentoAdjunto) as idDocumentoAdjunto,documentoBloqueado FROM 3000_formatosRegistrados 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$fFormato=$con->obtenerPrimeraFila($consulta);
		$iFormulario=$fFormato[0];
		$iRegistro=$fFormato[1];
		$idDocumentoAdjunto=$fFormato[2];

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
		
		if($fFormato[3]==1)
		{
			echo '{"resultado":"1","mensaje":""}';
			return;
		}
		
		
		$esOffice365=false;
		$datosParametros=NULL;
		$fDatosInformacion=NULL;
		$tipoDocumentoDefault="";
		if($fFormato[0]==-2)
		{
			$consulta="SELECT idFormulario,idReferencia,tipoDocumento,tituloDocumento,datosParametros FROM 7035_informacionDocumentos WHERE idRegistro=".$fFormato[1];
			$fDatosInformacion=$con->obtenerPrimeraFila($consulta);
			$tipoDocumentoDefault=$fDatosInformacion[2];
			$iFormulario=$fDatosInformacion[0];
			$iRegistro=$fDatosInformacion[1];
			$datosParametros=$fDatosInformacion[3];
			if($datosParametros!="")
			{
				$datosParametros=json_decode($datosParametros);
				if(($datosParametros)&&(isset($datosParametros->office365)))
				{
					$esOffice365=true;
				}
			}
			else
				$datosParametros=NULL;
		
			
		}
		$documentoBloqueado=$obj->documentoFinal==0?2:1;
		
		if(isset($obj->idArchivo))//Firma mediante documento
		{
			
			$consulta="SELECT tipoFormato FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$tipoFormato=$con->obtenerValor($consulta);
			
			if($tipoFormato!=0)
			{
				$consulta="SELECT categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoFormato;
				$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
				$tipoDocumentoDefault=$fDatosDocumento[0];
			}
			
			$idRegistro="";
			if($idDocumentoAdjunto=="")
			{
				$idRegistro=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->cadena,$tipoDocumentoDefault);
			}
			else
			{
				$cuerpoDocumento=leerContenidoArchivo($baseDir."/archivosTemporales/".$obj->idArchivo);
				reemplazarArchivoRepositorio($idDocumentoAdjunto,$cuerpoDocumento);	
				unlink($baseDir."/archivosTemporales/".$obj->idArchivo);
				$idRegistro=$idDocumentoAdjunto;
			}
			
			if($idRegistro==-1)
			{
				return;
			}	
			$idDocumento=$idRegistro;
			$obj->cadena="";
			
	
			$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena.
							"',firmado=1,responsableFirma=".$_SESSION["idUsr"].",documentoBloqueado=".$documentoBloqueado." 
						WHERE idRegistroFormato=".$obj->idRegistroFormato;
			
			if($con->ejecutarConsulta($consulta))
			{
				
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
				
				
				if($documentoBloqueado==1)
				{
					if($carpetaAdministrativa!="")
						registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idRegistro,$iFormulario,$iRegistro);
					if($iFormulario>0)
						registrarDocumentoResultadoProceso($iFormulario,$iRegistro,$idRegistro);
					
				}
				if(isset($obj->etapaEnvioFirma))
				{
					cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
				}
				
				
				if($esOffice365)
				{
					$infoComp["idConexion"]=$datosParametros->idConexion;
					$cDrive=new cOneDrive("","","","",$infoComp);
					$cDrive->conectar();
					$cDrive->removerRecurso("/".$datosParametros->nombreDocumento);
				}
				
				echo '{"resultado":"1","mensaje":""}';
			}
			return;
		}
		else
		{
			if($fFormato[2]!="")  //DOcumento adjunto
			{
				$idDocumento=$fFormato[2];
				$directorioDestino=$baseDir."/archivosTemporales";
				$archivoTemporalDestino=$directorioDestino."/".generarNombreArchivoTemporal();
				$archivoDestino=$archivoTemporalDestino.".pdf";
				$cuerpoDocumentoTmp=bD(obtenerCuerpoDocumentoB64($fFormato[2]));
				
				escribirContenidoArchivo($archivoTemporalDestino,$cuerpoDocumentoTmp);
				
				
				$consulta="SELECT LOWER(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$fFormato[2];
				$nombreArchivoOrigen=$con->obtenerValor($consulta);
				
				$arrNombreArchivo=explode(".",$nombreArchivoOrigen);
				$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
				if(($fFormato[3]==0)&&($extension!="pdf"))
				{
					convertirWordToPDFServidorConversion($archivoTemporalDestino,$archivoDestino);
				}
				else
				{
					copy($archivoTemporalDestino,$archivoDestino);
				}

				if(file_exists($archivoDestino))
				{
					
					echo '{"resultado":"1","sha256":"'.bE(hash_file("sha256", $archivoDestino,true)).'","archivoDestino":"'.$archivoDestino.'","mensaje":""}';
					return;
				}
				else
				{
					echo '{"resultado":"0","mensaje":"'.bE("No se ha podido generar la versión PDF del documento").'"}';
					return;
				}
				
				
			}
			else
			{
				$resultado=generarDocumentoPDFFormatoFirmaElectronicaIQSEC($obj->idRegistroFormato,true,$documentosAnexos,$documentoBloqueado);
				echo $resultado;
				return;
			}
		}
		
	}
	catch(Exception $e)
	{

		echo '{"resultado":"0","mensaje":"'.bE($e->getMessage()).'"}';
  
	}
	
	
	
function generarDocumentoPDFFormatoFirmaElectronicaIQSEC($idRegistroFormato,$descomponerDocumentoMarcadores=true,$documentosAnexos="",$bloquearDocumento=1)
{
	global $con;
	global $baseDir;
	global $comandoLibreOffice;
	global $respaldarDocumentoPrevioFirma;
	
	$arrExtensionesImagen["jpg"]=1;
	$arrExtensionesImagen["jpeg"]=1;
	$arrExtensionesImagen["png"]=1;
	$arrExtensionesImagen["gif"]=1;

	$objResultado=json_decode('{"resultado":"","mensaje":""}');
	

	$conversorPDF=-1;
	$consulta="SELECT cuerpoFormato,cadenaFirma,documentoBloqueado,tipoFormato,idFormulario,idRegistro FROM 3000_formatosRegistrados 
			WHERE idRegistroFormato=".$idRegistroFormato;
	
	$fDocumento=$con->obtenerPrimeraFila($consulta);
	$iFormulario=$fDocumento[4];
	$iRegistro=$fDocumento[5];
	$datosParametros=NULL;
	$objInfo=false;
	$esOffice365=false;
	if($iFormulario==-2)
	{
		$consulta="SELECT idFormulario,idReferencia,tipoDocumento,tituloDocumento,datosParametros FROM 7035_informacionDocumentos WHERE idRegistro=".$iRegistro;
		$fDatosInformacion=$con->obtenerPrimeraFila($consulta);
		
		$iFormulario=$fDatosInformacion[0];
		$iRegistro=$fDatosInformacion[1];
		if($fDatosInformacion[4]!="")
		{
			$objInfo=json_decode($fDatosInformacion[4]);
			if($objInfo && $objInfo->office365)
				$esOffice365=true;
		}
	}

	if($fDocumento[2]==1)
	{
		echo '{"resultado":"0","mensaje":"'.bE("El documento ya ha sido firmado anteriormente y se encuentra bloqueado").'"}';
		
		return $objResultado;
	}
	
	$cuerpoFormato="";
	$nombreArchivo="";
	$archivoTemporal="";
	if(!$esOffice365)
	{
		$cuerpoFormato=bD($fDocumento[0]);
		
		$nombreArchivo=rand()."_".date("dmY_Hms");
		
		$archivoTemporal=$baseDir."/archivosTemporales/".$nombreArchivo.".html";
		if($conversorPDF==-1)
		{
			$consulta="SELECT metodoConversionPDF FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fDocumento[3];
			$conversorPDF=$con->obtenerValor($consulta);
			if($conversorPDF=="")
				$conversorPDF=1;
		}
	
		if($conversorPDF==2)
		{
			$cuerpoFormato=prepararFormatoImpresionWord($cuerpoFormato);
		}
	}
	else
	{
		$nombreArchivo=$objInfo->nombreDocumento;
		$infoComp["idConexion"]=$objInfo->idConexion;
		$cDrive=new cOneDrive("","","","",$infoComp);
		$cDrive->conectar();
		$cuerpoFormato=$cDrive->obtenerDocumentoPDF("/".$objInfo->nombreDocumento);
		if(!$cuerpoFormato)
		{
			return '{"resultado":"0","mensaje":"'.bE("No se ha podido generar el pdf del documento").'"}';
		}
		$archivoTemporal=$baseDir."/archivosTemporales/".$nombreArchivo.".pdf";
		//escribirContenidoArchivo($directorioDestino."/".$nombreArchivo.".pdf",$cuerpoFormato);
		
	}
	
	
	if(escribirContenidoArchivo($archivoTemporal,$cuerpoFormato))
	{
		$directorioDestino=$baseDir."/archivosTemporales";
		if(!$esOffice365)
		{
			
	
			if($conversorPDF==-1)
			{
				$consulta="SELECT metodoConversionPDF FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fDocumento[3];
				$conversorPDF=$con->obtenerValor($consulta);
				if($conversorPDF=="")
					$conversorPDF=1;
			}
	
			switch($conversorPDF)
			{
				case 2:
					generarDocumentoPDF($archivoTemporal,false,false,true,"","MS_OFFICE",$directorioDestino);
				break;
				default:
					generarDocumentoPDF($archivoTemporal,false,false,false,"",$comandoLibreOffice,$directorioDestino);
				break;
			}
		}
		
		if(file_exists($directorioDestino."/".$nombreArchivo.".pdf"))
		{
			
			if($documentosAnexos!="")
			{
				$arrRutasEliminar=array();
				$merge = new PDFMerger();
				$merge->addPDF($directorioDestino."/".$nombreArchivo.".pdf");
				$arrDocumentosAnexos=explode(",",$documentosAnexos);
				foreach($arrDocumentosAnexos as $d)
				{
					$consulta="SELECT LOWER(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$d;
					$nArchivo=$con->obtenerValor($consulta);
					
					$aDocumentoAnexo=explode(".",$nArchivo);
					$rutaDocumentoAnexo=obtenerRutaDocumento($d);
					if($aDocumentoAnexo[sizeof($aDocumentoAnexo)-1]=='pdf')
					{
						$merge->addPDF($rutaDocumentoAnexo);
						
					}
					else
					{
						if(isset($arrExtensionesImagen[$aDocumentoAnexo[sizeof($aDocumentoAnexo)-1]]))
						{
							$rutaDocumentoAnexoTmp=$directorioDestino."/".rand()."_".date("dmY_Hms");
							
							$rutaImagen=$rutaDocumentoAnexoTmp.".".$aDocumentoAnexo[sizeof($aDocumentoAnexo)-1];
							$rutaPdf=$rutaDocumentoAnexoTmp.".pdf";
							
							copy($rutaDocumentoAnexo,$rutaImagen);
							array_push($arrRutasEliminar,$rutaImagen);
							array_push($arrRutasEliminar,$rutaPdf);
							$arrDatosImagen=getimagesize($rutaImagen);
							$pdf = new FPDF();
							$pdf->AddPage();							
							$pdf->image($rutaImagen,0,0);							
							$pdf->Output($rutaPdf,'F');
							$merge->addPDF($rutaPdf);
						}
					}
					
					
					
					
				}
				

				$merge->merge("file",$directorioDestino."/".$nombreArchivo.".pdf");
				foreach($arrRutasEliminar as $d)
				{
					if(file_exists($d))
					{
						unlink($d);
					}
				}
			}

			//rename($directorioDestino."/".$nombreArchivo.".pdf",$directorioDestino."/".$nombreArchivo);
			
			
			$consulta="SELECT nombreFormato,categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fDocumento[3];
			$fDocumentoFinal=$con->obtenerPrimeraFila($consulta);
			if(!$fDocumentoFinal)
			{
				$fDocumentoFinal[0]="Documento General";
				$fDocumentoFinal[1]=0;
			}

			$nombreArchivoPDF=$fDocumentoFinal[0];
			$nombreArchivoPDF.=".pdf";
			
			
				
			
			return '{"resultado":"1","sha256":"'.bE(hash_file("sha256", $directorioDestino."/".$nombreArchivo.".pdf",true)).
					'","archivoDestino":"'.($directorioDestino."/".$nombreArchivo.".pdf").
					'","nombreArchivo":"'.basename($directorioDestino."/".$nombreArchivo.".pdf").'","mensaje":""}';
					
			
		}
		else
		{

			return '{"resultado":"0","mensaje":"'.bE("No se ha podido generar la versión PDF del documento").'"}';
					
			
		}
	}
	
	
	
	
	
}
	
?>