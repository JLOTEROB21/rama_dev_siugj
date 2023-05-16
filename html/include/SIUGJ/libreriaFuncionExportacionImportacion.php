<?php	include_once("conexionBD.php");
		ini_set('default_socket_timeout', 160000);
		ini_set("memory_limit","4096M");

	function importarExpedienteXML($nombreArchivo,$tipoOperacion,$idArchivo,$expediente,$despacho)
	{
		global $con;
		global $baseDir;
		$ruta=$baseDir."/archivosTemporales/".$idArchivo;

			
		$arrInformacion=array();
		$xml=leerContenidoArchivo($ruta);
		
		$arrNodosEstructura=array();
		$arrNodosEstructura["expedientes"]=1;
		$arrNodosEstructura["ExpedienteElectronico"]=1;
		$arrNodosEstructura["procesoJudial"]=1;
		$arrNodosEstructura["expedientTable"]=1;
		$arrNodosEstructura["documentosExpedientes"]=1;
		$arrNodosEstructura["expedientesAsociados"]=1;

		$arrErrores=array();
		$pos=1;
		foreach($arrNodosEstructura as $llave=>$valor)
		{

			if(strpos($xml,"<".$llave.">")===false)
			{
				$o["no"]=$pos;
				$o["texto"]=cv("Estructura del XML no v&aacute;lida, falta nodo: <b>".$llave."</b>");
				array_push($arrErrores,$o);

			}
			$pos++;
		}
		
		
		if(count($arrErrores)>0)
		{

			return $arrErrores; 
		}
		
		$cXML=simplexml_load_string($xml);
		
		if($tipoOperacion==1)
		{
			
			
			
			$expediente=(string)$cXML->ExpedienteElectronico[0]->procesoJudial[0];
			$arrInformacion["carpetaAdministrativa"]=$expediente;
			$expedientTable=$cXML->ExpedienteElectronico[0]->expedientTable[0];
			foreach($expedientTable as $campo=>$etiqueta)
			{
				if($campo=="unidadGestion")
				{
					$arrInformacion["unidadGestion"]=(string)$etiqueta;
				}
				
			}
			
			
			return $arrInformacion;
			
		}
		else
		{
			$arrEstadisticas=array();
			$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".cv($expediente)."' AND unidadGestion='".cv($despacho)."'";
			$numReg=$con->obtenerValor($consulta);
			if($numReg>0)
			{
				$arrEstadisticas["error"]="El c&oacute;digo &uacute;nico de proceso ingresado ya existe en el despacho seleccionado";
				
				return $arrEstadisticas;
			}
			$query=array();
			$xAux=0;
			$query[$xAux]="begin";
			$xAux++;
			$arrEstadisticas=array();
			$arrEstadisticas["totalArchivosImportados"]=0;
			$arrEstadisticas["totalSubCarpetas"]=0;
			registroImportacionExpediente($cXML->ExpedienteElectronico[0],$query,$xAux,$expediente,$despacho,0,"",-1,$arrEstadisticas);
			$query[$xAux]="commit";
			$xAux++;
			
			
			if( $con->ejecutarBloque($query))
			{
				return $arrEstadisticas;
			}
			return null;
			
		}
		
		return "1";
	}
	
	
	function registroImportacionExpediente($nodoExpediente,&$query,&$xAux,$expediente,$despacho,$nivel,$expedientePadre="",$idExpedientePadre=-1,&$arrEstadisticas)
	{
		global $con;
		global $baseDir;
		$arrExpedienteTabla=array();
		$expedientTable=$nodoExpediente->expedientTable[0];

		if($nivel>0)
		{
			$expediente=(string)$nodoExpediente->procesoJudial[0];
			$arrEstadisticas["totalSubCarpetas"]++;
		}
		foreach($expedientTable as $campo=>$etiqueta)
		{
			if($campo!="idCarpeta")
			{
				$arrExpedienteTabla[(string)$campo]=(string)$etiqueta;
				
				if($nivel==0)
				{
					if($campo=="carpetaAdministrativa")
						$arrExpedienteTabla[(string)$campo]=$expediente;
					
					if($campo=="carpetaAdministrativaBase")
						$arrExpedienteTabla[(string)$campo]="";
					if($campo=="idCarpetaAdministrativaBase")
						$arrExpedienteTabla[(string)$campo]="-1";
				}
				/*else
				{
					if($campo=="carpetaAdministrativaBase")
						$arrExpedienteTabla[(string)$campo]=$expedientePadre;
					if($campo=="idCarpetaAdministrativaBase")
						$arrExpedienteTabla[(string)$campo]=$idExpedientePadre;
				}*/
				if($campo=="unidadGestion")
					$arrExpedienteTabla[(string)$campo]=$despacho;
			}
		}
		
		$arrCampos="";
		$arrValores="";
		foreach($arrExpedienteTabla as $campo=>$valor)
		{
			if($valor=="")
				$valor="NULL";
			else
			{
				if((strpos($valor,"idCarpeta_")===false)&&(strpos($valor,"@carpetaAdministrativa")===false))
					$valor="'".cv($valor)."'";
			}
			if($arrCampos=="")
			{
				$arrCampos=$campo;
				$arrValores=$valor;
			}
			else
			{
				$arrCampos.=",".$campo;
				$arrValores.=",".$valor;
			}
		}
		$idCarpetaNombre="@idCarpeta_".$xAux;
		$nombreCarpeta="@carpetaAdministrativa_".$xAux;
		if($nivel==0)
		{
			$idCarpetaNombre="@idCarpeta_0";
			$nombreCarpeta="@carpetaAdministrativa_0";
		}
		
		$query[$xAux]="insert into 7006_carpetasAdministrativas(".$arrCampos.") values(".$arrValores.")";
		$xAux++;
		
		
		
		
		
		if($nivel==0)
		{
			$query[$xAux]="set ".$idCarpetaNombre.":=-1";
			$xAux++;
		}
		else
		{
			$query[$xAux]="set ".$idCarpetaNombre.":=(select last_insert_id())";
			$xAux++;
		}
		
		
		
		
		$query[$xAux]="set ".$nombreCarpeta.":='".$expediente."' COLLATE utf8_spanish2_ci";
		$xAux++;
		
		if($nivel==1)
		{
			$query[$xAux]="set @idCarpetaPadre:=if(".$idExpedientePadre."=-1,(select idCarpeta from 7006_carpetasAdministrativas 
							where carpetaAdministrativa=".$expedientePadre." limit 0,1),".$idExpedientePadre.") ";
			$xAux++;
			$query[$xAux]="INSERT INTO 7006_carpetasAdministrativasRelacionadas(carpetaAdministrativaBase,idCarpetaBase,tipoRelacion,carpetaAdministrativa,idCarpeta)
							values(".$expedientePadre.",@idCarpetaPadre,6,".$nombreCarpeta.",".$idCarpetaNombre.")";
			$xAux++;	
		}
		
		foreach($nodoExpediente->documentosExpedientes[0] as $nodoDocumento)
		{
			$arrTablaArchivo=array();
			$tablaArchivo=$nodoDocumento->archiveTable[0];
			$cuerpoBase64=(string)$nodoDocumento->cuerpoBase64Documento[0];
			
			$idDocumento=rand()."_".date("dmY_Hms");;
			$nombreDocumento=(string)$nodoDocumento->Nombre_Documento[0];
			$nombreArchivoDest=$baseDir."/archivosTemporales/".$idDocumento;
			
			
			escribirContenidoArchivo($nombreArchivoDest,bD($cuerpoBase64));
			$sha512=strtoupper(hash_file("sha512" ,$nombreArchivoDest,false));
			$idDocumentoServidor=registrarDocumentoServidor($idDocumento,$nombreDocumento);
			

			foreach($tablaArchivo as $campo=>$etiqueta)
			{
				if(($campo!="idArchivo")&&($campo!="sha512"))
				{
					$arrTablaArchivo[(string)$campo]=(string)$etiqueta;
				}
				
			}
			
			$arrCampos="";

			foreach($arrTablaArchivo as $campo=>$valor)
			{
				if($valor=="")
					$valor="NULL";
				else
				{
					if((strpos($valor,"@idCarpeta_")===false)&&(strpos($valor,"@carpetaAdministrativa")===false))
						$valor="'".cv($valor)."'";
				}
				if($arrCampos=="")
				{
					$arrCampos=$campo."=".$valor;
					
				}
				else
				{
					$arrCampos.=",".$campo."=".$valor;
				}
			}
			
			$query[$xAux]="update 908_archivos set ".$arrCampos." where idArchivo=".$idDocumentoServidor;
			$xAux++;
			
			
			
			$metaDatos=$nodoDocumento->metaDataDocumento[0];
			$arrTablaMetaDatos=array();
			if(count($metaDatos)>0)
			{

				foreach($metaDatos as $mDato)
				{
					$arrTablaMetaDatos=array();
					foreach($mDato as $campo=>$valor)
					{
						if($campo!="idRegistro")
						{
							$arrTablaMetaDatos[(string)$campo]=(string)$valor;
						
							if($campo=="idArchivo")
							{
								$arrTablaMetaDatos[(string)$campo]=$idDocumentoServidor;
							}
						}
					}
					
					$arrCampos="";
					$arrValores="";
					foreach($arrTablaMetaDatos as $campo=>$valor)
					{
						if($valor=="")
							$valor="NULL";
						else
						{
							$valor="'".cv($valor)."'";
						}
						if($arrCampos=="")
						{
							$arrCampos=$campo;
							$arrValores=$valor;
						}
						else
						{
							$arrCampos.=",".$campo;
							$arrValores.=",".$valor;
						}
					}
					
					
					$query[$xAux]="insert into 908_metaDataArchivos(".$arrCampos.") values(".$arrValores.")";
					$xAux++;
				}
				
				
				
			}
			
			
			$arrTablaContenido=array();
			$tablaContent=$nodoDocumento->archiveContentTable[0];	
			foreach($tablaContent as $campo=>$etiqueta)
			{
				if($campo!="idContenido")
				{
					$arrTablaContenido[(string)$campo]=(string)$etiqueta;
					
					if($campo=="idRegistroContenidoReferencia")
					{
						$arrTablaContenido[(string)$campo]=$idDocumentoServidor;
					}
					
					if($campo=="carpetaAdministrativaRaiz")
					{
						$arrTablaContenido[(string)$campo]="@carpetaAdministrativa_0";
					}
					
					if($campo=="idCarpetaAdministrativaRaiz")
					{
						$arrTablaContenido[(string)$campo]="@idCarpeta_0";
					}
					
					if($campo=="carpetaAdministrativa")
					{
						$arrTablaContenido[(string)$campo]=$nombreCarpeta;
					}
					
					if($campo=="idCarpetaAdministrativa")
					{
						$arrTablaContenido[(string)$campo]=$idCarpetaNombre;
					}
					
				}
				
				
				
			}
			

			
			$arrCampos="";
			$arrValores="";
			foreach($arrTablaContenido as $campo=>$valor)
			{
				if($valor=="")
					$valor="NULL";
				else
				{
					if((strpos($valor,"@idCarpeta_")===false)&&(strpos($valor,"@carpetaAdministrativa")===false))
						$valor="'".cv($valor)."'";
				}
				if($arrCampos=="")
				{
					$arrCampos=$campo;
					$arrValores=$valor;
				}
				else
				{
					$arrCampos.=",".$campo;
					$arrValores.=",".$valor;
				}
			}
			
			
			$arrEstadisticas["totalArchivosImportados"]++;

			
			$query[$xAux]="insert into 7007_contenidosCarpetaAdministrativa(".$arrCampos.") values(".$arrValores.")";
			$xAux++;
			
		}
		
		
		$nivel++;
		foreach($nodoExpediente->expedientesAsociados[0] as $nodoExpedienteAux)
		{
			
			registroImportacionExpediente($nodoExpedienteAux,$query,$xAux,$expediente,$despacho,$nivel,$nombreCarpeta,$idCarpetaNombre,$arrEstadisticas);
		}
		
		
	}
?>