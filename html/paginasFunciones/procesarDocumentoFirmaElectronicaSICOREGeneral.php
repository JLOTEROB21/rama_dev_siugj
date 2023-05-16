<?php	session_start();
	include("conexionBD.php");
	include_once("latisErrorHandler.php");
	global $con;
	global $baseDir;
	
	try
	{
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
	
		$archivoDestino=$baseDir."/archivosTemporales/".$obj->idDocumento;
		if(file_exists($archivoDestino."_doc"))
			$archivoDestino.="_doc";
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
			//unlink($archivoDestino);
			
			$client = new nusoap_client($URLServidorFirma."?wsdl","wsdl");
			$parametros=array();
			$parametros["tipoCertificado"]=$tipoCertificado;
			$parametros["documentoDestino"]="temporal.pdf";
			$parametros["contenidoDocument"]=$cuerpoDocumento;
			$parametros["contenidoCer"]=$archivoCER;
			$parametros["contenidoKey"]=$archivoKEY;
			$parametros["passwd"]=$passwd;
			$parametros["llaveFirmado"]=$llaveFirmado;
	
			$response = $client->call($nombreFuncionFirma, $parametros);
	
			$oResp=json_decode($response[$nombreFuncionFirma."Result"]);
			
			if($oResp->resultado==1)
			{
				$idDocumento=registrarDocumentoServidorRepositorio($obj->idDocumento,$obj->nombreDocumento,1);
				$archivoOrigen=obtenerRutaDocumento($idDocumento);
				$infoOrigen=pathinfo($archivoOrigen);
				
				$directorioDestino=$baseDir."/archivosTemporales/";
				$archivoDestino=$directorioDestino."/".$infoOrigen["basename"].".pdf";
				$archivoTemporalDestino=$directorioDestino."/".$infoOrigen["basename"];
				
				
				$r1=escribirContenidoArchivo($archivoTemporalDestino,bD($oResp->documento));
				$r2=escribirContenidoArchivo($archivoTemporalDestino.".pkcs7",bD($oResp->PKCS7));
				
				if($r1 && $r2)
				{
					if(copy($archivoTemporalDestino,$archivoOrigen)&&copy($archivoTemporalDestino.".pkcs7",$archivoOrigen.".pkcs7"))
					{
						unlink($archivoTemporalDestino);
						unlink($archivoTemporalDestino.".pkcs7");
						if(file_exists($directorioDestino."/".$obj->idDocumento))
							@unlink($directorioDestino."/".$obj->idDocumento);
						if(file_exists($directorioDestino."/".$obj->idDocumento."_doc"))
							@unlink($directorioDestino."/".$obj->idDocumento."_doc");
						$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumento;
						$nomArchivoOriginal=$con->obtenerValor($consulta);
						
						$arrArchivos=explode(".",$nomArchivoOriginal);
						
						
						$arrArchivos[sizeof($arrArchivos)-1]=".pdf";
						
						$nomArchivoOriginal=implode("",$arrArchivos);
						$sha512=strtoupper(hash_file ( "sha512" , $archivoOrigen,false ));
						$consulta="update 908_archivos set nomArchivoOriginal='".$nomArchivoOriginal."',tamano='".filesize($archivoOrigen).
									"',sha512='".$sha512."'  WHERE idArchivo=".$idDocumento;
						$con->ejecutarConsulta($consulta);
						
						echo '{"resultado":"1","mensaje":"","idDocumento":"'.$idDocumento.'"}';
							
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
	catch(Exception $e)
	{
		echo '{"resultado":"0","mensaje":"'.bE($e->getMessage()).'"}';
		

	}

?>