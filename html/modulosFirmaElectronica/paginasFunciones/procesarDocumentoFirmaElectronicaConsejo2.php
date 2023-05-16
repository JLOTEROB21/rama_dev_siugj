<?php	session_start();
include("conexionBD.php");
include("SIUGJ/cFirmaConsejo.php");

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
	$modoColegiadoNativo=true;
	
	
	$idDocumento="NULL";
	
	$idUsuarioPonente=8242;
	$oUsuarioPonente["login"]="usuarioprueba1@deaj.ramajudicial.gov.co";
	$oUsuarioPonente["password"]="SiujUnidadInformatica*";
	
	
	
	$consulta="SELECT login,password FROM 7052_usuariosFirmaElectronica WHERE idUsuario=".$_SESSION["idUsr"];
	$fDatosCuenta=$con->obtenerPrimeraFilaAsoc($consulta);
	if($fDatosCuenta)
	{
		
		$oUsuarioPonente["login"]=$fDatosCuenta["login"];
		$oUsuarioPonente["password"]=$fDatosCuenta["password"];
	}
	else
	{
		echo '{"resultado":"0","mensaje":"'.bE("NO ha configurado una cuenta para firmar electr&oacute;nicamente"),'"}';
		return;
	}
	
	$c=new cFirmaConsejo($oUsuarioPonente["login"],$oUsuarioPonente["password"]);
	
	
	
	$consulta="SELECT idFormulario,idRegistro,idDocumentoAdjunto,documentoBloqueado,tipoFormato FROM 3000_formatosRegistrados 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
	$fFormato=$con->obtenerPrimeraFila($consulta);
	
	$iFormulario=$fFormato[0];
	$iRegistro=$fFormato[1];
	$tipoFormato=$fFormato[4];
	
	
	$consulta="SELECT * FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoFormato;
	$fDatosFormato=$con->obtenerPrimeraFilaAsoc($consulta);
	$nombreArchivo=$fDatosFormato["nombreFormato"].".pdf";
	
	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
	
	$esFirmaColegiada=$fDatosFormato["metodoFirma"]==2;
	$esRegistroPrimerFirmante=false;
	
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
		$datosParametros=json_decode($fDatosInformacion[4]==""?"{}":$fDatosInformacion[4]);
		if(!isset($datosParametros->idDocumentoFirmaColegiada))
		{
			$esRegistroPrimerFirmante=true;
		}
			
		
	}
	
	
	
	$documentoBloqueado=$obj->documentoFinal==0?2:1;
	$archivoBase=$objMater->archivoDestino;
	$hashRepositorio="";
	$cuerpoArchivo=leerContenidoArchivo($objMater->archivoDestino);
	$resultado=NULL;
	$cadDatosParametros="";
	if((!$esFirmaColegiada)||(!$modoColegiadoNativo))
	{
		if($esFirmaColegiada)
			$documentoBloqueado=2;
		
		$resultado=$c->firmarElectronicamenteDocumento(bE($cuerpoArchivo),$nombreArchivo,$fDatosFormato["nombreFormato"]);
	}
	else
	{
		if($esRegistroPrimerFirmante)
		{
			$oFirmantes="";
			$correosFirmantes=array();
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativasDespachosColegiados WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY orden";
			$rDespachos=$con->obtenerFilas($consulta);
			while($fDespacho=mysql_fetch_assoc($rDespachos))
			{
				
				$consulta="SELECT uF.* FROM 801_adscripcion a,807_usuariosVSRoles u,800_usuarios us ,7052_usuariosFirmaElectronica uF 
							WHERE a.Institucion='".$fDespacho["despachoAsignado"]."'
							AND u.idUsuario=a.idUsuario AND u.idRol IN(56,96) AND us.idUsuario=u.idUsuario AND us.cuentaActiva=1
							AND uF.idUsuario=us.idUsuario limit 0,1";
				$fDatosJuez=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fDatosJuez)
				{
					
					$oFirmante=array();
					$oFirmante["idUsuario"]=$fDatosJuez["idUsuarioFirma"];
					$oFirmante["mail"]=$fDatosJuez["login"];			
					array_push($correosFirmantes,$oFirmante);
				}
			}
			
			
			$documentoBloqueado=2;
			$resultado=$c->firmarElectronicamenteDocumentoPonente(bE($cuerpoArchivo),$nombreArchivo,$fDatosFormato["nombreFormato"],$correosFirmantes);
			if($resultado)
			{
				
				foreach($correosFirmantes as $f)
				{
					$oFirmante='{"idUsuario":"'.$f["idUsuario"].'","mail":"'.$f["mail"].'"}';
					if($oFirmantes=="")
						$oFirmantes=$oFirmante;
					else
						$oFirmantes.=",".$oFirmante;
				}
				
				if(!isset($datosParametros->idDocumentoFirmaColegiada))
				{
					$datosParametros=setAtributoObjJson($datosParametros,"idDocumentoFirmaColegiada",$resultado->datosComplementarios[0]->idArhivoFirmaElectronica);
				}
				
				if(!isset($datosParametros->idUsuarioPonente))
				{
					$datosParametros=setAtributoObjJson($datosParametros,"idUsuarioPonente",$idUsuarioPonente);
				}
				
				if(!isset($datosParametros->arrFirmantes))
				{
					$datosParametros=setAtributoObjJson($datosParametros,"arrFirmantes","");
				}
				
				$cadDatosParametros=convertirCadenaJson($datosParametros);
				$cadDatosParametros=str_replace('"arrFirmantes":""','"arrFirmantes":['.$oFirmantes.']',$cadDatosParametros);
				
			}
			
			
		}
		else
		{
			
			$documentoBloqueado=2;
			$consulta="SELECT * FROM 7006_carpetasAdministrativasDespachosColegiados WHERE carpetaAdministrativa='".$carpetaAdministrativa.
						"' AND despachoAsignado='".$_SESSION["codigoInstitucion"]."'";
			$fila=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT  * FROM _04001_firmasColegiadasDocumentos WHERE iFormulario=".$iFormulario." AND iRegistro=".$iRegistro.
						" AND despachoFimante='".$fila["despachoAsignado"]."'";
			$fFirmado=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fFirmado["firmado"]==1)
			{
				echo '{"resultado":"1","mensaje":""}';
				return;
			}
			
			
			$oFirmante=$datosParametros->arrFirmantes[$fFirmado["orden"]];
			
			
			$consulta="SELECT idUsuario FROM 7052_usuariosFirmaElectronica WHERE idUsuarioFirma=".$oFirmante->idUsuario;
			$idUsuarioLocalFirma=$con->obtenerValor($consulta);
			
			if($idUsuarioLocalFirma!=$_SESSION["idUsr"])
			{
				echo '{"resultado":"0","mensaje":"'.bE('No esta autorizado para firmar este documento').'"}';
				return;
			}
			

			$consulta="SELECT COUNT(*) FROM _04001_firmasColegiadasDocumentos WHERE iFormulario=".$iFormulario." AND iRegistro=".$iRegistro.
					" AND  firmado=1";

			$totalFirmados=$con->obtenerValor($consulta);
			$totalFirmados+=2;
			
			$consulta="SELECT COUNT(*) FROM _04001_firmasColegiadasDocumentos WHERE iFormulario=".$iFormulario." AND iRegistro=".$iRegistro;
			$totalFirmantes=$con->obtenerValor($consulta);
			$totalFirmantes+=1;
			
			
			$esFirmaFinal=(($totalFirmantes-$totalFirmados)==0?true:false);

			if($esFirmaFinal)
			{
				$documentoBloqueado=1;
			}

			$resultado=$c->firmarElectronicamenteDocumentoColaborador($datosParametros->idDocumentoFirmaColegiada,2,$obj->comentariosAdicionales);
			
			
			if($resultado)
			{
				$estado=$resultado->resultado;
				$msgError=$resultado->msgErr;
				if(($estado==1)&&($esFirmaFinal))
				{
					$consulta="SELECT * FROM 7052_usuariosFirmaElectronica WHERE idUsuarioFirma=".$datosParametros->idUsuarioPonente;
					$fPonente=$con->obtenerPrimeraFilaAsoc($consulta);
					$c=new cFirmaConsejo($fPonente["login"],$fPonente["password"]);
					$resultado=$c->firmarElectronicamenteDocumentoColegiado($datosParametros->idDocumentoFirmaColegiada);
				}
			}
			
			
		}
	}
	
	
	if($resultado)
	{
		$estado=$resultado->resultado;
		$msgError=$resultado->msgErr;
		if($estado==1)
		{
			$hashRepositorio=$resultado->datosComplementarios[0]->hash;
			$directorioDestino=$baseDir."/archivosTemporales/";
			$cuerpoDocumentoSinFirma=leerContenidoArchivo($objMater->archivoDestino);
			$r1=escribirContenidoArchivo($objMater->archivoDestino,bD($resultado->datosComplementarios[0]->archivo));
			if($r1)
			{
				
				if($fFormato[2]!="") //Documento adjunto
				{
					
					$idDocumento=$fFormato[2];
					
					//actualizar en repositorio
					if(reemplazarArchivoRepositorio($idDocumento,bD($resultado->datosComplementarios[0]->archivo)))
					{
						$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumento;
						$nomArchivoOriginal=$con->obtenerValor($consulta);
						
						if($respaldarDocumentoPrevioFirma)
						{
							$numRespaldo=1;
							
							$nombreRespaldo=$nomArchivoOriginal."_resp_".date("YmdHis")."_".rand(1000,9999);
							/*while(file_exists($nombreRespaldo))
							{
								$nombreRespaldo=$archivoOrigen.".resp".$numRespaldo;
								$numRespaldo++;
							}*/
							$r1=registrarRespaldoArchivoRepositorio($idDocumento,$cuerpoDocumentoSinFirma,$nombreRespaldo);
						}
						
						
						$arrArchivos=explode(".",$nomArchivoOriginal);
						
						
						$arrArchivos[sizeof($arrArchivos)-1]=".pdf";
						
						$nomArchivoOriginal=implode("",$arrArchivos);
						$sha512=strtoupper(hash_file ( "sha512" , $objMater->archivoDestino,false ));
						$consulta="update 908_archivos set folioQR=NULL, nomArchivoOriginal='".$nomArchivoOriginal."',tamano='".filesize($objMater->archivoDestino).
									"',sha512='".$sha512."',hashRepositorio='".$hashRepositorio."',idDocumentoOPC=".$resultado->datosComplementarios[0]->idArhivoFirmaElectronica."  WHERE idArchivo=".$idDocumento;
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
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,$iFormulario,$iRegistro,-1);
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
						$consulta="update 908_archivos set hashRepositorio='".$hashRepositorio."'  WHERE idArchivo=".$idDocumento;
						$con->ejecutarConsulta($consulta);
						if(file_exists($objMater->archivoDestino))
						{
							unlink($objMater->archivoDestino);
							
						}
						if(isset($obj->etapaEnvioFirma))
						{
							cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
						}
						if($cadDatosParametros!="")
						{
							$consulta="UPDATE 7035_informacionDocumentos SET datosParametros='".cv($cadDatosParametros)."' WHERE idRegistro=".$fFormato[1];
							$con->ejecutarConsulta($consulta);
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
catch(Exception $e)
{

	echo '{"resultado":"0","mensaje":"'.bE($e->getMessage()).'"}';

}
?>