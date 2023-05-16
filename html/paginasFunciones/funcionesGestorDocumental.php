<?php session_start();
	include("conexionBD.php"); 
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
		
	}	
	
	switch($funcion)
	{
		case 1: 
			registrarDatosTRD();
		break;
		case 2:
			registrarRegistroTRD();
		break;
		case 3:
			obtenerRegistrosTRD();
		break;
		case 4:
			removerRegistroTRD();
		break;
		case 5:
			buscarMetaDato();
		break;
		case 6:
			validarHashDocumentos();
		break;
		case 7:
			importacionExpediente();
		break;
		case 8:
			obtenerVersionTRD();
		break;
		case 9:
			registrarVersionTRD();
		break;
		case 10:
			obtenerTiposProcesos();
		break;
		case 11:
			registrarDespachosTRD();
		break;
		case 12:
			obtenerDespachosTRD();
		break;
		case 13:
			removerDespachosTRD();
		break;
		case 14:
			clonarVersionTRD();
		break;
		case 15:
			removerVersionTRD();
		break;
		case 16:
			modificarSituacionVersionTRD();
		break;
		case 17:
			importacionTRDs();
		break;
	}
	
	
	function registrarDatosTRD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 908_tablasRetencionDocumental(cveTabla,nombreTabla,descripcion,version,idResponsableCreacion,
						fechaCreacion,procesoArchivoGestion,procesoArchivoCentral) 
					VALUES('".cv($obj->cveTabla)."','".cv($obj->nombreTabla)."','".cv($obj->descripcion)."','".cv($obj->version)."',".$_SESSION["idUsr"].
					",'".date("Y-m-d H:i:s")."','".$obj->procesoArchivoGestion."','".$obj->procesoArchivoCentral."')";
		
		
			if($con->ejecutarConsulta($consulta))
				$obj->idRegistro=$con->obtenerUltimoID();
			
			$codigoRegistro=generarFolioProcesos(-908,$obj->idRegistro);	
			$consulta="UPDATE 908_tablasRetencionDocumental SET folioRegistro='".$codigoRegistro."' WHERE idTablaRetencion=".$obj->idRegistro;	
			$con->ejecutarConsulta($consulta);
		}
		else
		{
			$consulta="update 908_tablasRetencionDocumental set cveTabla='".cv($obj->cveTabla)."',nombreTabla='".cv($obj->nombreTabla).
					"',descripcion='".cv($obj->descripcion)."',version='".cv($obj->version)."',procesoArchivoGestion=".
					$obj->procesoArchivoGestion.",procesoArchivoCentral=".$obj->procesoArchivoCentral." where idTablaRetencion=".$obj->idRegistro;
			$con->ejecutarConsulta($consulta);
			$comentarioAdicionalSQL="Se modifica datos generales. Datos modificados:".bE($cadObj);
			guardarRegistroBitacoraSistema("../gestorDocumental/tablaRetencionDocumental.php",$obj->idRegistro,13,("TRD: ".$obj->nombreTabla.".- ".$comentarioAdicionalSQL));
		}
		
		echo "1|".$obj->idRegistro;
	}
	
	
	function registrarRegistroTRD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		$idTablaRetencion=$obj->idTablaRetencion;
		
		
		$consulta="SELECT nombreTabla,VERSION FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion;
		$fTablaRetencion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nomTablaTRD=$fTablaRetencion["nombreTabla"]."(V. ".$obj->version.")";
		
		$idSerie=isset($obj->idSerie)?$obj->idSerie:"NULL";
		$idSubSerie=isset($obj->idSubSerie)?$obj->idSubSerie:"NULL";
		$tipoDocumento=isset($obj->tipoDocumento)?$obj->tipoDocumento:"NULL";
		
		$retencionArchivoGestion="NULL";
		$unidadRetencionArchivoGestion="NULL";
		$retencionArchivoCentral="NULL";
		$unidadRetencionArchivoCentral="NULL";
		
		$conservacionTotal="0";
		$eliminacion="0";
		$microfilmacionDigitalizacion="0";
		$seleccion="0";
		$procedimiento="NULL";
		
		$tipoElemento=$obj->tipoRegistro;
		$cveElemento=$obj->cveElemento;
		
		$arrSoporte=explode(",",$obj->soporte);
		
		$soporteFisico=existeValor($arrSoporte,1)?1:0;
		$soporteElectronico=existeValor($arrSoporte,2)?1:0;
		
		if($obj->tRetencionGestion!="")
			$retencionArchivoGestion=$obj->tRetencionGestion;
		if($obj->pRetencionGestion!="")
			$unidadRetencionArchivoGestion=$obj->pRetencionGestion;
		
		if($obj->tRetencionCentral!="")
			$retencionArchivoCentral=$obj->tRetencionCentral;
		
		if($obj->pRetencionCentral!="")
			$unidadRetencionArchivoCentral=$obj->pRetencionCentral;
		
		
		switch($obj->disposicionFinal)
		{
			case 1://CT
				$conservacionTotal=1;
			break;
			case 2://E
				$eliminacion=1;
			break;
			case 3://MT
				$microfilmacionDigitalizacion=1;
			break;
			case 4://S
				$seleccion=1;
			break;
		}
		
		$consultaAux=array();
		
		
		$x=0;
		$consultaAux[$x]="begin";
		$x++;
		
		$procedimiento=$obj->procedimiento;
		$tituloElemento=isset($obj->tituloElemento)?$obj->tituloElemento:"";
		
		$consulta="";
		if($obj->idRegistro==-1)
		{
			switch($tipoElemento)
			{
				case '1':
					
					$comentarioAdicionalSQL="Se agrega Serie: ".$tituloElemento;
				break;
				case '2':
					$comentarioAdicionalSQL="Se agrega SubSerie: ".$tituloElemento;
				break;
				case '3':
					
					$arrTiposDocumentales=explode(",",$tipoDocumento);
					if(count($arrTiposDocumentales)==1)
						$comentarioAdicionalSQL="Se agrega Tipo Documental: ";
					else
						$comentarioAdicionalSQL="Se agregan los Tipos Documentales: ";
					
					
					$tDocumentales="";	
					foreach($arrTiposDocumentales as $t)
					{	
						$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$t;
						$nombreCategoria=$con->obtenerValor($consulta);
						
						if($tDocumentales=="")	
							$tDocumentales=$nombreCategoria;
						else
							$tDocumentales.=", ".$nombreCategoria;
					}
					
					$comentarioAdicionalSQL.=$tDocumentales;
					
					
				break;
				
			}
			
			
			if($tipoElemento!=3)
			{
			
				$consultaAux[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,
									unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,
									tipoElemento,cveElemento,tituloElemento,version) values(".$idTablaRetencion.",".$idSerie.",".$idSubSerie.",".$tipoDocumento.",".$soporteFisico.",".$soporteElectronico.",".$retencionArchivoGestion.
									",".$unidadRetencionArchivoGestion.",".$retencionArchivoCentral.",".$unidadRetencionArchivoCentral.",".$conservacionTotal.",".$eliminacion.",".$microfilmacionDigitalizacion.",".$seleccion.
									",'".cv($procedimiento)."',".$tipoElemento.",'".cv($cveElemento)."','".cv($tituloElemento)."',".$obj->version.")";
				$x++;
				
				$consultaAux[$x]="select @idSerie:=(select last_insert_id())";
				$x++;
				
				if(isset($obj->arrTipoProcesos))
				{
						
					$arrTiposProcesos=explode(",",$obj->arrTipoProcesos);

					foreach($arrTiposProcesos as $p)
					{
						if($p!="")
						{
							$consultaAux[$x]="INSERT INTO 908_seriesTiposProcesos(idSerie,tipoProceso) VALUES(@idSerie,".$p.")";
							$x++;
						}
					}
				}
				
				
			}
			else
			{
				$arrTiposDocumentales=explode(",",$tipoDocumento);
				foreach($arrTiposDocumentales as $t)
				{
					$consulta="SELECT COUNT(*) FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND
								idSerie=".$idSerie." AND idSubSerie=".$idSubSerie." AND tipoDocumento=".$t." AND version=".$obj->version." AND tipoElemento=3";
					$numElementos=$con->obtenerValor($consulta);
					
					
					if($numElementos==0)
					{
						$consultaAux[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,
											unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,
											tipoElemento,cveElemento,tituloElemento,version) values(".$idTablaRetencion.",".$idSerie.",".$idSubSerie.",".$t.",".$soporteFisico.",".$soporteElectronico.",".$retencionArchivoGestion.
											",".$unidadRetencionArchivoGestion.",".$retencionArchivoCentral.",".$unidadRetencionArchivoCentral.",".$conservacionTotal.",".$eliminacion.",".$microfilmacionDigitalizacion.",".$seleccion.
											",'".cv($procedimiento)."',".$tipoElemento.",'".cv($cveElemento)."','".cv($tituloElemento)."',".$obj->version.")";
						$x++;
					}
				}
			}
			$comentarioAdicionalSQL.=". Informaci&oacute; Agregada: ".bE($cadObj);
		}
		else
		{
			$query="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$obj->idRegistro;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($query);
			$objInformacion=$con->obtenerFilasJSON($query);
			switch($fRegistro["tipoElemento"])
			{
				case '1':
					
					$comentarioAdicionalSQL="Modificaci&oacute;n de Serie: ".($fRegistro["tituloElemento"]==$tituloElemento?$fRegistro["tituloElemento"]:($fRegistro["tituloElemento"]."/".$tituloElemento));
				break;
				case '2':
					$comentarioAdicionalSQL="Modificaci&oacute;n de SubSerie: ".($fRegistro["tituloElemento"]==$tituloElemento?$fRegistro["tituloElemento"]:($fRegistro["tituloElemento"]."/".$tituloElemento));
				break;
				case '3':
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$tipoDocumento;
					$nuevoTipoDocumental=$con->obtenerValor($consulta);
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$fRegistro["tipoDocumento"];
					$nombreCategoria=$con->obtenerValor($consulta);
					$comentarioAdicionalSQL="Modificaci&oacute;n de Tipo Documental: ".($nombreCategoria==$nuevoTipoDocumental?$nombreCategoria:($nombreCategoria."/".$nuevoTipoDocumental));
				break;
				
			}
			$consultaAux[$x]="update 908_registrosTablasRetencionDocumental set idSerie=".$idSerie.",idSubSerie=".$idSubSerie.",tipoDocumento=".$tipoDocumento.",soporteFisico=".$soporteFisico.
					",soporteElectronico=".$soporteElectronico.",retencionArchivoGestion=".$retencionArchivoGestion.",unidadRetencionArchivoGestion=".$unidadRetencionArchivoGestion.
					",retencionArchivoCentral=".$retencionArchivoCentral.",unidadRetencionArchivoCentral=".$unidadRetencionArchivoCentral.",conservacionTotal=".$conservacionTotal.
					",eliminacion=".$eliminacion.",microfilmacionDigitalizacion=".$microfilmacionDigitalizacion.",seleccion=".$seleccion.",procedimiento='".cv($procedimiento)."',
					cveElemento='".cv($cveElemento)."',tituloElemento='".cv($tituloElemento)."'
					where idRegistro=".$obj->idRegistro;
			$x++;
			
			
			if(isset($obj->arrTipoProcesos))
			{
				$consultaAux[$x]="delete from 908_seriesTiposProcesos where idSerie=".$obj->idRegistro;
				$x++;
				$arrTiposProcesos=explode(",",$obj->arrTipoProcesos);
				foreach($arrTiposProcesos as $p)
				{
					if($p!="")
					{	
						$consultaAux[$x]="INSERT INTO 908_seriesTiposProcesos(idSerie,tipoProceso) VALUES(".$obj->idRegistro.",".$p.")";
						$x++;
					}
				}
			}
			
			$comentarioAdicionalSQL.=". Informaci&oacute; Anterior: ".bE($objInformacion).".Informaci&oacute; Actual: ".bE($cadObj);
		}
		
		
		$consultaAux[$x]="commit";
		$x++;

 		if($con->ejecutarBloque($consultaAux))
		{
			guardarRegistroBitacoraSistema("../gestorDocumental/tablaRetencionDocumental.php",$idTablaRetencion,13,("TRD: ".$nomTablaTRD.".- ".$comentarioAdicionalSQL));
			echo "1|";
		}
	}
	
	
	function obtenerRegistrosTRD()
	{
		global $con;
		$idTablaRetencion=$_POST["idTablaRetencion"];
		$version=$_POST["version"];
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT idRegistro,idSerie,idSubSerie,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
					conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tituloElemento,cveElemento,tipoElemento FROM 908_registrosTablasRetencionDocumental WHERE 
					idTablaRetencion=".$idTablaRetencion." and version=".$version." AND tipoElemento=1 ORDER BY cveElemento";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$consulta="SELECT tipoProceso FROM 908_seriesTiposProcesos WHERE idSerie=".$fila["idRegistro"];
			$listaTiposProcesos=$con->obtenerListaValores($consulta);
			
			if($listaTiposProcesos=="")
				$listaTiposProcesos=-1;
			
			$consulta="SELECT especialidad,id__625_tablaDinamica FROM _625_tablaDinamica WHERE id__625_tablaDinamica IN(".$listaTiposProcesos.")";
			$arrTiposProcesos=$con->obtenerFilasArreglo($consulta);
						
			$o='{"idRegistro":"'.$fila["idRegistro"].'","idSerie":"","cveSerie":"'.$fila["cveElemento"].'","idSubSerie":"","cveSubSerie":"","tipoDocumento":"'.cv($fila["tituloElemento"]).
			'","soporteFisico":'.($fila["soporteFisico"]==1?"true":"false").',"soporteElectronico":'.
				($fila["soporteElectronico"]==1?"true":"false").',"retencionArchivoGestion":"'.$fila["retencionArchivoGestion"].'","unidadRetencionArchivoGestion":"'.$fila["unidadRetencionArchivoGestion"].'",
					"retencionArchivoCentral":"'.$fila["retencionArchivoCentral"].'","unidadRetencionArchivoCentral":"'.$fila["unidadRetencionArchivoCentral"].
					'","conservacionTotal":'.($fila["conservacionTotal"]==1?"true":"false").',"eliminacion":'.($fila["eliminacion"]==1?"true":"false").
					',"microfilmacionDigitalizacion":'.($fila["microfilmacionDigitalizacion"]==1?"true":"false").
					',"seleccion":'.$fila["seleccion"].',"procedimiento":"'.cv($fila["procedimiento"]).'","tipoElemento":"'.$fila["tipoElemento"].
					'","arrTiposProcesos":'.$arrTiposProcesos.'}';
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;	
				
			$consulta="SELECT idRegistro,idSerie,idSubSerie,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
					conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tituloElemento,cveElemento,tipoElemento FROM 908_registrosTablasRetencionDocumental WHERE 
					idTablaRetencion=".$idTablaRetencion." and ((tipoElemento=2 and idSerie=".$fila["idRegistro"].
					") or (tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=0)) ORDER BY cveElemento";
			$resSubserie=$con->obtenerFilas($consulta);
			while($filaSubserie=mysql_fetch_assoc($resSubserie))
			{
				$consulta="SELECT tipoProceso FROM 908_seriesTiposProcesos WHERE idSerie=".$filaSubserie["idRegistro"];
				$listaTiposProcesos=$con->obtenerListaValores($consulta);
				
				if($listaTiposProcesos=="")
					$listaTiposProcesos=-1;
				
				$consulta="SELECT especialidad,id__625_tablaDinamica FROM _625_tablaDinamica WHERE id__625_tablaDinamica IN(".$listaTiposProcesos.")";
				$arrTiposProcesos=$con->obtenerFilasArreglo($consulta);
				$o='{"idRegistro":"'.$filaSubserie["idRegistro"].'","idSerie":"'.$fila["idRegistro"].'","cveSerie":"'.$fila["cveElemento"].'","idSubSerie":"'.$filaSubserie["idRegistro"].
					'","cveSubSerie":"'.cv($filaSubserie["cveElemento"]).'","tipoDocumento":"'.cv($filaSubserie["tipoElemento"]==3?$filaSubserie["tipoDocumento"]:$filaSubserie["tituloElemento"]).
				'","soporteFisico":'.($filaSubserie["soporteFisico"]==1?"true":"false").',"soporteElectronico":'.
					($filaSubserie["soporteElectronico"]==1?"true":"false").',"retencionArchivoGestion":"'.$filaSubserie["retencionArchivoGestion"].'","unidadRetencionArchivoGestion":"'.
					$filaSubserie["unidadRetencionArchivoGestion"].'",
						"retencionArchivoCentral":"'.$filaSubserie["retencionArchivoCentral"].'","unidadRetencionArchivoCentral":"'.$filaSubserie["unidadRetencionArchivoCentral"].
						'","conservacionTotal":'.($filaSubserie["conservacionTotal"]==1?"true":"false").',"eliminacion":'.($filaSubserie["eliminacion"]==1?"true":"false").
						',"microfilmacionDigitalizacion":'.($filaSubserie["microfilmacionDigitalizacion"]==1?"true":"false").
						',"seleccion":'.$filaSubserie["seleccion"].',"procedimiento":"'.cv($filaSubserie["procedimiento"]).
						'","tipoElemento":"'.$filaSubserie["tipoElemento"].'","arrTiposProcesos":'.$arrTiposProcesos.'}';
			
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;		
				
				$numReg++;
				
				
				$consulta="SELECT idRegistro,idSerie,idSubSerie,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
					conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tituloElemento,cveElemento,tipoElemento FROM 908_registrosTablasRetencionDocumental WHERE 
					idTablaRetencion=".$idTablaRetencion." and idSerie=".$fila["idRegistro"]." and idSubSerie=".$filaSubserie["idRegistro"]." AND tipoElemento=3 ORDER BY cveElemento";
				$resTipoDocumental=$con->obtenerFilas($consulta);
				while($filaTipoDocumental=mysql_fetch_assoc($resTipoDocumental))
				{
					$o='{"idRegistro":"'.$filaTipoDocumental["idRegistro"].'","idSerie":"'.$fila["idRegistro"].'","cveSerie":"'.$fila["cveElemento"].'","idSubSerie":"'.$filaSubserie["idRegistro"].
						'","cveSubSerie":"'.cv($filaSubserie["cveElemento"]).'","tipoDocumento":"'.cv($filaTipoDocumental["tipoDocumento"]).
					'","soporteFisico":'.($filaTipoDocumental["soporteFisico"]==1?"true":"false").',"soporteElectronico":'.
						($filaTipoDocumental["soporteElectronico"]==1?"true":"false").',"retencionArchivoGestion":"'.$filaTipoDocumental["retencionArchivoGestion"].'","unidadRetencionArchivoGestion":"'.
						$filaTipoDocumental["unidadRetencionArchivoGestion"].'",
							"retencionArchivoCentral":"'.$filaTipoDocumental["retencionArchivoCentral"].'","unidadRetencionArchivoCentral":"'.$filaTipoDocumental["unidadRetencionArchivoCentral"].
							'","conservacionTotal":'.($filaTipoDocumental["conservacionTotal"]==1?"true":"false").',"eliminacion":'.($filaTipoDocumental["eliminacion"]==1?"true":"false").
							',"microfilmacionDigitalizacion":'.($filaTipoDocumental["microfilmacionDigitalizacion"]==1?"true":"false").
							',"seleccion":'.$filaTipoDocumental["seleccion"].',"procedimiento":"'.cv($filaTipoDocumental["procedimiento"]).'","tipoElemento":"'.$filaTipoDocumental["tipoElemento"].'"}';
				
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;		
					
					$numReg++;
				}
				
			}
		}
		
		
		$arrSeries="";
		$consulta="SELECT idRegistro,CONCAT('[',cveElemento,'] ',tituloElemento) AS serie FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".
					$idTablaRetencion." and tipoElemento=1 and version=".$version." ORDER BY tituloElemento";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$consulta="SELECT idRegistro,CONCAT('[',cveElemento,'] ',tituloElemento) AS subserie FROM 908_registrosTablasRetencionDocumental WHERE 
					idTablaRetencion=".$idTablaRetencion." and idSerie=".$fila["idRegistro"]." and tipoElemento=2  ORDER BY tituloElemento";
		
			$arrSubserie=$con->obtenerFilasArreglo($consulta);
			$o="['".$fila["idRegistro"]."','".cv($fila["serie"])."',".$arrSubserie."]";
			if($arrSeries=="")
				$arrSeries=$o;
			else
				$arrSeries.=",".$o;
		}
		
		$consulta="SELECT COUNT(*) FROM 908_despachosTablaRetencion WHERE idTablaRetencion=".$idTablaRetencion." AND version=".$version;
		$totalDespachos=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"arrSeries":['.$arrSeries.'],"totalDespachos":'.$totalDespachos.'}';
		
		
	}
	
	function removerRegistroTRD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($query);
		$objInformacion=$con->obtenerFilasJSON($query);
		$idTablaRetencion=$fRegistro["idTablaRetencion"];
		$query="SELECT nombreTabla,VERSION FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$fRegistro["idTablaRetencion"];
		$fTablaRetencion=$con->obtenerPrimeraFilaAsoc($query);
		$nomTablaTRD=$fTablaRetencion["nombreTabla"]."(V. ".$fTablaRetencion["VERSION"].")";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$obj->idRegistro;
		$x++;
		switch($obj->tipoElemento)
		{
			case '1':
				$consulta[$x]="DELETE FROM 908_registrosTablasRetencionDocumental WHERE idSerie=".$obj->idRegistro;
				$x++;
				$comentarioAdicionalSQL="Eliminación de Serie: ".$fRegistro["tituloElemento"];
			break;
			case '2':
				$consulta[$x]="DELETE FROM 908_registrosTablasRetencionDocumental WHERE idSubSerie=".$obj->idRegistro;
				$x++;
				$comentarioAdicionalSQL="Eliminación de SubSerie: ".$fRegistro["tituloElemento"];
			break;
			case '3':
				$query="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$fRegistro["tipoDocumento"];
				$nombreCategoria=$con->obtenerValor($query);
				$comentarioAdicionalSQL="Eliminación de Tipo Documental: ".$nombreCategoria;
			break;
			
		}
		$comentarioAdicionalSQL.=". Informaci&oacute; Eliminada: ".bE($objInformacion);
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			guardarRegistroBitacoraSistema("../gestorDocumental/tablaRetencionDocumental.php",$idTablaRetencion,13,("TRD: ".$nomTablaTRD.".- ".$comentarioAdicionalSQL));
			echo "1|";
		}
	}
	
	function buscarMetaDato()
	{
		global $con;
		
		$criterio=$_POST["criterio"];
		
		$numRegistros=0;
		$arrMetaDatos="";
		$consulta="SELECT idMetaDato,cveMetaDato,nombreMetaDato,metodoResolucion,tipoDatoEntrada,funcionSistema,fuenteDatos FROM 20003_catalogoMetaDatos where 
					(nombreMetaDato like '%".$criterio."%' or  cveMetaDato like '%".$criterio."%')";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$lblDetalle="Tipo de Entrada: ";
			switch($fila["metodoResolucion"])
			{
				case 0:
					$lblDetalle="Campo Abierto";
					switch($fila["tipoDatoEntrada"])
					{
						case 0:
							$lblDetalle.=" (Texto Corto)";
						break;
						case 1:
							$lblDetalle.=" (Texto Largo)";
						break;
						case 2:
							$lblDetalle.=" (Entero)";
						break;
						case 3:
							$lblDetalle.=" (Decimal)";
						break;
						
					}
				break;
				case 1:
					$lblDetalle="Mediante Funci&oacute;n de Sistema";
					$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila["funcionSistema"];
					$lblFuncion=$con->obtenerValor($consulta);
					$lblDetalle.=" (".$lblFuncion.")";
				break;
				case 2:
					$lblDetalle="Opciones Cerradas (Combo)";
					
				break;	
			}
			
			$o='{"idMetaDato":"'.$fila["idMetaDato"].'","nombreMetaDato":"'.cv($fila["cveMetaDato"]."] ".$fila["nombreMetaDato"]).'","detallesAdicionales":"'.cv($lblDetalle).'"}';
		
			if($arrMetaDatos=="")
				$arrMetaDatos=$o;
			else
				$arrMetaDatos.=",".$o;
			$numRegistros++;
		}
		
		echo '{"numReg":"'.$numRegistros.'","registros":['.$arrMetaDatos.']}';
		
	}
	
	function validarHashDocumentos()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$arrRegistros="";
		foreach($obj->arrRegistros as $r)
		{
			$consulta="SELECT idArchivo,nomArchivoOriginal,sha512 FROM 908_archivos WHERE sha512='".$r->hash."'";
			$fila=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$permiteMostrar="true";
			if($fila)
			{
				$permiteMostrar=permiteObservarDocumento($fila["idArchivo"])?"true":"false";
			}
			
			$o='{"idArchivo":"'.(isset($fila["idArchivo"])?$fila["idArchivo"]:"").'","nomArchivoOriginal":"'.cv($fila['nomArchivoOriginal']==""?"---------":$fila['nomArchivoOriginal']).'","sha512":"'.$r->hash.'","permiteMostrar":"'.$permiteMostrar.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		echo "1|[".$arrRegistros."]";
	}
	
	function importacionExpediente()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$objRespuesta="";
		
		$consulta="SELECT idFuncionAsociada FROM 20007_perfilesImportacionExportacionExpedientes WHERE idRegistroPerfil=".$obj->idPerfilImportacion;
		$idFuncionAsociada=$con->obtenerValor($consulta);
		$cadObj='{"idArchivo":"'.$obj->idArchivo.'","nombreArchivo":"'.cv($obj->nombreArchivo).'","tipoOperacion":"'.$obj->tipoOperacion.
				'","despacho":"'.(!isset($obj->despacho)?"":$obj->despacho).'","expediente":"'.(!isset($obj->expediente)?"":$obj->expediente).'"}';
		$objParametros=json_decode($cadObj);
			
		$resultado=resolverExpresionCalculoPHP($idFuncionAsociada,$objParametros,$cacheCalculos);
		
		if($obj->tipoOperacion==1)
		{
			
			if((gettype($resultado)=="array")&&(!isset($resultado["unidadGestion"])))
			{
				$arrErrores="";
				
				foreach($resultado as $r)
				{
					$o="['".$r["no"]."','".cv($r["texto"])."']";
					if($arrErrores=="")
					{
						$arrErrores=$o;
					}
					else
					{
						$arrErrores.=",".$o;
					}
				}
					echo '1|{"error":"1","mensajeError":['.$arrErrores.']}';
				return;
			}
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$resultado["unidadGestion"]."'";
			$lblUnidadGestion=$con->obtenerValor($consulta);
			$objRespuesta='{"carpetaAdministrativa":"'.cv($resultado["carpetaAdministrativa"]).
						'","unidadGestion":"'.cv($resultado["unidadGestion"]).'","lblUnidadGestion":"'.
						cv($lblUnidadGestion).'","idArchivo":"'.$obj->idArchivo.'","nombreArchivo":"'.cv($obj->nombreArchivo).
						'","idPerfilImportacion":"'.$obj->idPerfilImportacion.'","error":"0"}';
		
			echo "1|".$objRespuesta;
			return;
		}
		else
		{
			if(isset($resultado["error"]))
			{
				echo "<br>".$resultado["error"];
				return;
			}
			
			$consulta="INSERT INTO 20008_importacionesRegistros(fechaRegistro,nombreArchivo,totalArchivosImportados,perfilImportacion,
						totalSubCarpetasImportadas,carpetaAdministrativa,despacho,responsableImportacion) 
						VALUES('".date("Y-m-d H:i:s")."','".cv($obj->nombreArchivo)."',".$resultado["totalArchivosImportados"].
						",".$obj->idPerfilImportacion.",".$resultado["totalSubCarpetas"].",'".cv($obj->expediente)."','".$obj->despacho.
						"',".$_SESSION["idUsr"].")";
			$con->ejecutarConsulta($consulta);
			
			$objRespuesta="";
			if($resultado)
			{
				$aRegistros="['1','Total de archivos importados: ".$resultado["totalArchivosImportados"].
								"'],['2','Total subcarpetas importadas: ".$resultado["totalSubCarpetas"]."']";
				echo '1|{"error":"0","informacion":['.$aRegistros.']}';
				
				return;
			}
		}
		
		echo '1|';
	}
	
	
	function obtenerVersionTRD()
	{
		global $con;
		$iT=$_POST["iT"];
		
		$consulta="SELECT idRegistro,version,situacionActual,fechaAplicacion FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$iT." order by version";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
		
		
	}
	
	function registrarVersionTRD()
	{
		global $con;
		$iT=$_POST["iT"];
		
		$consulta="SELECT MAX(VERSION) FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$iT;
		$ultimaVersion=$con->obtenerValor($consulta);
		if($ultimaVersion=="")
			$ultimaVersion=0;
		$ultimaVersion++;
		
		$consulta="INSERT INTO 908_versionesTablasRetencionDocumental(idTablaRetencion,version,situacionActual)
				VALUES(".$iT.",".$ultimaVersion.",1)";
	
		if($con->ejecutarConsulta($consulta))
		{
			
			echo "1|".$ultimaVersion;
		}
	
	}
	
	function obtenerTiposProcesos()
	{
		global $con;
		$consulta="SELECT id__625_tablaDinamica as idTipoProceso,especialidad FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarDespachosTRD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$arrDespacho=explode(",",$obj->arrDespachos);
		foreach($arrDespacho as $d)
		{
			$consulta="SELECT COUNT(*) FROM 908_despachosTablaRetencion WHERE idTablaRetencion=".$obj->iR." AND version=".$obj->v." AND despacho=".$d."";
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
			
				$query[$x]="INSERT INTO 908_despachosTablaRetencion(idTablaRetencion,VERSION,despacho) VALUES(".$obj->iR.",".$obj->v.",".$d.")";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;

		eB($query);
		
	}
	
	
	function obtenerDespachosTRD()
	{
		global $con;
		$iR=$_POST["iR"];
		$v=$_POST["v"];
		
		
		$consulta="SELECT idRegistro,o.codigoUnidad,o.unidad AS nombreDespacho FROM 908_despachosTablaRetencion d,817_organigrama o
					WHERE o.codigoUnidad=d.despacho AND d.idTablaRetencion=".$iR." AND d.version=".$v." order by unidad";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';	
		
	}
	
	function removerDespachosTRD()
	{
		global $con;
		$arrDespachos=$_POST["arrDespachos"];
		
		$consulta="DELETE FROM 908_despachosTablaRetencion WHERE idRegistro IN(".$arrDespachos.")";
		eC($consulta);
	}
	
	function clonarVersionTRD()
	{
		global $con;
		$iR=$_POST["iT"];
		$v=$_POST["v"];
		
		$consulta="SELECT MAX(VERSION) FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$iR;
		$version=$con->obtenerValor($consulta);
		if($version=="")
			$version=0;
		$version++;
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="INSERT INTO 908_versionesTablasRetencionDocumental(idTablaRetencion,version,situacionActual)
				VALUES(".$iR.",".$version.",1)";
		$x++;
		
		
		$query[$x]="INSERT INTO 908_despachosTablaRetencion(idTablaRetencion,version,despacho)
					SELECT idTablaRetencion,'".$version."' as version,despacho FROM 908_despachosTablaRetencion WHERE idTablaRetencion=".$iR." AND version=".$v;
		$x++;
		
		$consulta="SELECT idRegistro FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$iR." AND VERSION=".$v." and tipoElemento=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,
						cveElemento,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,
						unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
						conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,
						tipoElemento,tituloElemento,VERSION)
						SELECT idTablaRetencion,idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
						soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,
						unidadRetencionArchivoCentral,conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,
						procedimiento,tipoElemento,tituloElemento,'".$version."' as version FROM
						908_registrosTablasRetencionDocumental WHERE idRegistro=".$fila["idRegistro"];
			$x++;
			$query[$x]="set @idSerie:=(select last_insert_id())";
			$x++;
			$query[$x]="INSERT INTO 908_seriesTiposProcesos(idSerie,tipoProceso)
							SELECT @idSerie,tipoProceso FROM 908_seriesTiposProcesos WHERE idSerie=".$fila["idRegistro"];
			$x++;
			$consulta="SELECT idRegistro FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$iR.
						" AND VERSION=".$v." and tipoElemento=2 and idSerie=".$fila["idRegistro"];
			$resSerie=$con->obtenerFilas($consulta);
			while($filaSerie=mysql_fetch_assoc($resSerie))
			{
				$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,
						cveElemento,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,
						unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
						conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,
						tipoElemento,tituloElemento,VERSION)
						SELECT idTablaRetencion,@idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
						soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,
						unidadRetencionArchivoCentral,conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,
						procedimiento,tipoElemento,tituloElemento,'".$version."' as version FROM
						908_registrosTablasRetencionDocumental WHERE idRegistro=".$filaSerie["idRegistro"];
				$x++;
				$query[$x]="set @idSubSerie:=(select last_insert_id())";
				$x++;
				$query[$x]="INSERT INTO 908_seriesTiposProcesos(idSerie,tipoProceso)
							SELECT @idSubSerie,tipoProceso FROM 908_seriesTiposProcesos WHERE idSerie=".$filaSerie["idRegistro"];
				$x++;
				
				$consulta="SELECT idRegistro FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$iR.
						" AND VERSION=".$v." and tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=".$filaSerie["idRegistro"];
				$resTipoDocumental=$con->obtenerFilas($consulta);
				while($filaTipoDocumental=mysql_fetch_assoc($resTipoDocumental))
				{
					$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,
							cveElemento,tipoDocumento,soporteFisico,soporteElectronico,retencionArchivoGestion,
							unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
							conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,
							tipoElemento,tituloElemento,VERSION)
							SELECT idTablaRetencion,@idSerie,@idSubSerie,cveElemento,tipoDocumento,soporteFisico,
							soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,
							unidadRetencionArchivoCentral,conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,
							procedimiento,tipoElemento,tituloElemento,'".$version."' as version FROM
							908_registrosTablasRetencionDocumental WHERE idRegistro=".$filaTipoDocumental["idRegistro"];
					$x++;
				}
			}
			
			
			

		}
		$query[$x]="commit";
		$x++;

		if($con->ejecutarBloque($query))
		{
			echo "1|".$version;
		}
		
	}
	
	
	function removerVersionTRD()
	{
		global $con;
		$iR=$_POST["iT"];
		$v=$_POST["v"];
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="DELETE FROM 908_despachosTablaRetencion WHERE idTablaRetencion=".$iR." AND VERSION=".$v;
		$x++;
		$query[$x]="DELETE FROM 908_seriesTiposProcesos WHERE idSerie IN
					(SELECT idRegistro FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$iR." AND VERSION=".$v.") ";
		$x++;
		$query[$x]="DELETE FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$iR." AND VERSION=".$v;
		$x++;
		$query[$x]="DELETE FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$iR." AND VERSION=".$v;
		$x++;
		
		
		$query[$x]="commit";
		$x++;

		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT MAX(VERSION) FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$iR;
			$version=$con->obtenerValor($consulta);
			if($version=="")
				$version=-1;
			echo "1|".$version;
		}
	}
	
	function modificarSituacionVersionTRD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT nombreTabla FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$obj->iR;
		$nombreTabla=$con->obtenerValor($consulta);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 908_versionesTablasRetencionDocumental SET situacionActual=".$obj->situacion.",fechaAplicacion=".($obj->fechaAplicacion==""?"NULL":"'".$obj->fechaAplicacion.
					"'")." WHERE idTablaRetencion=".$obj->iR." AND version=".$obj->v;
		$x++;
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			$lblSituacion="";
			switch($obj->situacion)
			{
				case 2:
					$lblSituacion="<b>Situaci&oacute;n:</b> Activo";
				break;
				case 3:
					$lblSituacion="<b>Situaci&oacute;n:</b> Inactivo";
				break;
			}
			
			if($obj->fechaAplicacion!="")
			{
				$lblSituacion.=" (Fecha de aplicación: ".date("d/m/Y",strtotime($obj->fechaAplicacion)).")";
			}

			$comentarioAdicionalSQL="Se modifica la situaci&oacute;n de la versi&oacute;n de la TRD.<br>".$lblSituacion."<br>".($obj->situacion==2?"Comentarios adicionales":"Motivo del cambio").":<br>".
									cv($obj->comentariosAdicionales==""?"(Sin comentarios)":$obj->comentariosAdicionales);
			guardarRegistroBitacoraSistema("../gestorDocumental/tablaRetencionDocumental.php",$obj->iR,13,("TRD: ".$nombreTabla." (V. ".$obj->v.").- ".$comentarioAdicionalSQL));
		
			echo "1|";
		}
		
		
	}
	
	
	function importacionTRDs()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$objRespuesta="";
		
		$nombreTRD="";
		$totalSeriesImportadas=0;
		$totalSubSeriesImportadas=0;
		$totalTiposDocumentalesImportadas=0;
		$versionTRD=0;
		
		$objJson=null;
		$arrArchivos=explode(".",$obj->nombreArchivo);
		try
		{
			$extension=$arrArchivos[count($arrArchivos)-1];
			switch(strtolower($extension))
			{
				case "json":
					$cadJSON=leerContenidoArchivo($baseDir."/archivosTemporales/".$obj->idArchivo);
					$objJson=json_decode($cadJSON);
					
					if(!$objJson)
					{
						echo "1|[['1','El formato del archivo JSON NO es v&aacute;lido']]";
						
						return;
					}
					
					if(!isset($objJson->nombreTabla))
					{
						echo "1|[['1','El formato del archivo JSON NO es v&aacute;lido']]";
						return;
					}
					
				break;
				case "xlsx":
					$libro=new cExcel($baseDir."/archivosTemporales/".$obj->idArchivo,true,"Excel2007");
					
					$titulo=$libro->getValor("A3");
					if($titulo!="TABLA DE RETENCIÓN DOCUMENTAL")
					{
						echo "1|[['1','El formato del archivo Excel NO es v&aacute;lido']]";
						return;
					}
					$fecha=$libro->getValor("L7");
					$nombreTabla=$libro->getValor("C5");
					$cveTabla=$libro->getValor("C6");
					$version=$libro->getValor("C7");
					$arrRegistrosTRD="";
					
					$numFila=11;
					
					$arrSeriesExcel=array();
					$serieActual="";
					$subSerieActual="0";
					while($libro->getValor("C".$numFila)!="")
					{
						if(($libro->getValor("A".$numFila)!="")&&($libro->getValor("B".$numFila)==""))//Serie
						{
							$tipoElemento=1;
							$serieActual=str_replace("'","",$libro->getValor("A".$numFila));
							$serie=str_replace("'","",$libro->getValor("A".$numFila));
							$subserie=str_replace("'","",$libro->getValor("B".$numFila));
							$subSerieActual="0";
							$tituloElemento=str_replace("'","",$libro->getValor("C".$numFila));
							$soporteFisico=str_replace("'","",$libro->getValor("D".$numFila));
							$soporteElectronico=str_replace("'","",$libro->getValor("E".$numFila));
							$retencionArchivoGestion=str_replace("'","",$libro->getValor("F".$numFila));
							$retencionArchivoCentral=str_replace("'","",$libro->getValor("G".$numFila));
							$conservacionTotal=str_replace("'","",$libro->getValor("H".$numFila));
							$eliminacion=str_replace("'","",$libro->getValor("I".$numFila));
							$microfilmacionDigitalizacion=str_replace("'","",$libro->getValor("J".$numFila));
							$seleccion=str_replace("'","",$libro->getValor("K".$numFila));
							$procedimiento=str_replace("'","",$libro->getValor("L".$numFila));
							
							$oRegistro='{"serie":"'.cv($serie).'","subserie":"'.cv($subserie).'","tituloElemento":"'.cv($tituloElemento).
										'","soporteFisico":"'.($soporteFisico!=""?1:0).'","soporteElectronico":"'.($soporteElectronico!=""?1:0).'","retencionArchivoGestion":"'.
										$retencionArchivoGestion.'","retencionArchivoCentral":"'.$retencionArchivoCentral.'","conservacionTotal":"'.
										($conservacionTotal!=""?1:0).'","eliminacion":"'.($eliminacion!=""?1:0).'","microfilmacionDigitalizacion":"'.
										($microfilmacionDigitalizacion!=""?1:0).'","seleccion":"'.($seleccion!=""?1:0).'","procedimiento":"'.cv($procedimiento).
										'","tipoElemento":"'.$tipoElemento.'","arrElementosHijos":[]}';
							
							
							$arrSeriesExcel[$serieActual]["data"]["fila"]=json_decode($oRegistro);
							$arrSeriesExcel[$serieActual]["data"]["subserie"]=array();
							
							
							
						}
						
						if(($libro->getValor("A".$numFila)!="")&&($libro->getValor("B".$numFila)!=""))//subserie
						{
							$tipoElemento=2;
							$subSerieActual=str_replace("'","",$libro->getValor("B".$numFila));
							
							$serie=str_replace("'","",$libro->getValor("A".$numFila));
							$subserie=str_replace("'","",$libro->getValor("B".$numFila));
							$tituloElemento=str_replace("'","",$libro->getValor("C".$numFila));
							$soporteFisico=str_replace("'","",$libro->getValor("D".$numFila));
							$soporteElectronico=str_replace("'","",$libro->getValor("E".$numFila));
							$retencionArchivoGestion=str_replace("'","",$libro->getValor("F".$numFila));
							$retencionArchivoCentral=str_replace("'","",$libro->getValor("G".$numFila));
							$conservacionTotal=str_replace("'","",$libro->getValor("H".$numFila));
							$eliminacion=str_replace("'","",$libro->getValor("I".$numFila));
							$microfilmacionDigitalizacion=str_replace("'","",$libro->getValor("J".$numFila));
							$seleccion=str_replace("'","",$libro->getValor("K".$numFila));
							$procedimiento=str_replace("'","",$libro->getValor("L".$numFila));
							
							
							$oRegistro='{"serie":"'.cv($serie).'","subserie":"'.cv($subserie).'","tituloElemento":"'.cv($tituloElemento).
										'","soporteFisico":"'.($soporteFisico!=""?1:0).'","soporteElectronico":"'.($soporteElectronico!=""?1:0).'","retencionArchivoGestion":"'.
										$retencionArchivoGestion.'","retencionArchivoCentral":"'.$retencionArchivoCentral.'","conservacionTotal":"'.
										($conservacionTotal!=""?1:0).'","eliminacion":"'.($eliminacion!=""?1:0).'","microfilmacionDigitalizacion":"'.
										($microfilmacionDigitalizacion!=""?1:0).'","seleccion":"'.($seleccion!=""?1:0).'","procedimiento":"'.cv($procedimiento).
										'","tipoElemento":"'.$tipoElemento.'","arrElementosHijos":[]}';
							
							
							
							$arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["fila"]=json_decode($oRegistro);
							$arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"]=array();
						}
						
						if(($libro->getValor("A".$numFila)=="")&&($libro->getValor("B".$numFila)==""))//tipoDoumental
						{
							
							$tipoElemento=3;
							$serie=str_replace("'","",$libro->getValor("A".$numFila));
							$subserie=str_replace("'","",$libro->getValor("B".$numFila));
							$tituloElemento=str_replace("'","",$libro->getValor("C".$numFila));
							$soporteFisico=str_replace("'","",$libro->getValor("D".$numFila));
							$soporteElectronico=str_replace("'","",$libro->getValor("E".$numFila));
							$retencionArchivoGestion=str_replace("'","",$libro->getValor("F".$numFila));
							$retencionArchivoCentral=str_replace("'","",$libro->getValor("G".$numFila));
							$conservacionTotal=str_replace("'","",$libro->getValor("H".$numFila));
							$eliminacion=str_replace("'","",$libro->getValor("I".$numFila));
							$microfilmacionDigitalizacion=str_replace("'","",$libro->getValor("J".$numFila));
							$seleccion=str_replace("'","",$libro->getValor("K".$numFila));
							$procedimiento=str_replace("'","",$libro->getValor("L".$numFila));		
							
							if($serieActual=="")
							{
								echo "1|[['1','El tipo documental <b>".$tituloElemento."</b> NO se encuentra asociado a alguna serie']]";
						
								return;
							}
							
							$oRegistro='{"serie":"'.cv($serieActual).'","subserie":"'.cv($subSerieActual==0?"":$subSerieActual).'","tituloElemento":"'.cv($tituloElemento).
										'","soporteFisico":"'.($soporteFisico!=""?1:0).'","soporteElectronico":"'.($soporteElectronico!=""?1:0).'","retencionArchivoGestion":"'.
										$retencionArchivoGestion.'","retencionArchivoCentral":"'.$retencionArchivoCentral.'","conservacionTotal":"'.
										($conservacionTotal!=""?1:0).'","eliminacion":"'.($eliminacion!=""?1:0).'","microfilmacionDigitalizacion":"'.
										($microfilmacionDigitalizacion!=""?1:0).'","seleccion":"'.($seleccion!=""?1:0).'","procedimiento":"'.cv($procedimiento).
										'","tipoElemento":"'.$tipoElemento.'","arrElementosHijos":[]}';
							
							
							
							
							
							if(!isset($arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"]))
							{
								$arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["fila"]=null;
								$arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"]=array();
							}
							array_push($arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"],json_decode($oRegistro));
						}
						
						$numFila++;
					}
					
					
					$arrRegistrosTRD="";
					foreach($arrSeriesExcel as $serieActual=>$dataSerie)//Series
					{
						$arrSubseries="";
						foreach($arrSeriesExcel[$serieActual]["data"]["subserie"] as $subSerieActual=>$dataSubSerie)//SubSeries
						{
							if($subSerieActual==0)
							{
								$arrTiposDocumentales='';
								foreach($arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"] as $t)//SubSeries
								{
									$oRegistro='{"serie":"'.($t->serie).'","subserie":"'.($t->subserie).'","tituloElemento":"'.cv($t->tituloElemento).
										'","soporteFisico":"'.($t->soporteFisico).'","soporteElectronico":"'.($t->soporteElectronico).'","retencionArchivoGestion":"'.
										($t->retencionArchivoGestion).'","retencionArchivoCentral":"'.($t->retencionArchivoCentral).'","conservacionTotal":"'.
										($t->conservacionTotal).'","eliminacion":"'.($t->eliminacion).'","microfilmacionDigitalizacion":"'.
										($t->microfilmacionDigitalizacion).'","seleccion":"'.($t->seleccion).'","procedimiento":"'.cv($t->procedimiento).
										'","tipoElemento":"3","arrElementosHijos":[]}';
									if($arrSubseries=="")
										$arrSubseries=$oRegistro;
									else
										$arrSubseries.=",".$oRegistro;
								}
							}
							else
							{
								$arrTiposDocumentales='';
								foreach($arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["tipoDocumental"] as $t)//SubSeries
								{
									$oRegistro='{"serie":"'.($t->serie).'","subserie":"'.($t->subserie).'","tituloElemento":"'.cv($t->tituloElemento).
										'","soporteFisico":"'.($t->soporteFisico).'","soporteElectronico":"'.($t->soporteElectronico).'","retencionArchivoGestion":"'.
										($t->retencionArchivoGestion).'","retencionArchivoCentral":"'.($t->retencionArchivoCentral).'","conservacionTotal":"'.
										($t->conservacionTotal).'","eliminacion":"'.($t->eliminacion).'","microfilmacionDigitalizacion":"'.
										($t->microfilmacionDigitalizacion).'","seleccion":"'.($t->seleccion).'","procedimiento":"'.cv($t->procedimiento).
										'","tipoElemento":"3","arrElementosHijos":[]}';
									if($arrTiposDocumentales=="")
										$arrTiposDocumentales=$oRegistro;
									else
										$arrTiposDocumentales.=",".$oRegistro;
								}
								
								$o2=$arrSeriesExcel[$serieActual]["data"]["subserie"][$subSerieActual]["data"]["fila"];
								$oRegistro='{"serie":"'.($o2->serie).'","subserie":"'.($o2->subserie).'","tituloElemento":"'.cv($o2->tituloElemento).
									'","soporteFisico":"'.($o2->soporteFisico).'","soporteElectronico":"'.($o2->soporteElectronico).'","retencionArchivoGestion":"'.
									($o2->retencionArchivoGestion).'","retencionArchivoCentral":"'.($o2->retencionArchivoCentral).'","conservacionTotal":"'.
									($o2->conservacionTotal).'","eliminacion":"'.($o2->eliminacion).'","microfilmacionDigitalizacion":"'.
									($o2->microfilmacionDigitalizacion).'","seleccion":"'.($o2->seleccion).'","procedimiento":"'.cv($o2->procedimiento).
									'","tipoElemento":"2","arrElementosHijos":['.$arrTiposDocumentales.']}';
								if($arrSubseries=="")
									$arrSubseries=$oRegistro;
								else
									$arrSubseries.=",".$oRegistro;
							}
							
							
						}
						$o=$arrSeriesExcel[$serieActual]["data"]["fila"];
						$oRegistro='{"serie":"'.($o->serie).'","subserie":"'.($o->subserie).'","tituloElemento":"'.cv($o->tituloElemento).
												'","soporteFisico":"'.($o->soporteFisico).'","soporteElectronico":"'.($o->soporteElectronico).'","retencionArchivoGestion":"'.
												($o->retencionArchivoGestion).'","retencionArchivoCentral":"'.($o->retencionArchivoCentral).'","conservacionTotal":"'.
												($o->conservacionTotal).'","eliminacion":"'.($o->eliminacion).'","microfilmacionDigitalizacion":"'.
												($o->microfilmacionDigitalizacion).'","seleccion":"'.($o->seleccion).'","procedimiento":"'.cv($o->procedimiento).
												'","tipoElemento":"1","arrElementosHijos":['.$arrSubseries.']}';
						if($arrRegistrosTRD=="")
							$arrRegistrosTRD=$oRegistro;
						else
							$arrRegistrosTRD.=",".$oRegistro;
					}
					
					
					
					$arrOficinasProductoras="";
					
					$libro->cambiarHojaActiva(1);
					$numFila=2;
					while($libro->getValor("A".$numFila)!="")
					{
						$codigoUnidad=$libro->getValor("A".$numFila);
						$claveDepartamental=$libro->getValor("B".$numFila);
						$unidad=$libro->getValor("C".$numFila);
						
						$oOficina='{"codigoUnidad":"'.cv(str_replace("'","",$codigoUnidad)).'","claveDepartamental":"'.cv(str_replace("'","",$claveDepartamental)).'","unidad":"'.cv($unidad).'"}';
						if($arrOficinasProductoras=="")
							$arrOficinasProductoras=$oOficina;
						else
							$arrOficinasProductoras.=",".$oOficina;
						$numFila++;
					}
					
					$arrSeriesSubseries="";
					
					$libro->cambiarHojaActiva(2);
					$numFila=2;
					while($libro->getValor("A".$numFila)!="")
					{
						$serie=str_replace("'","",$libro->getValor("A".$numFila));
						$subserie=str_replace("'","",$libro->getValor("B".$numFila));
						$claveEspecialidadDespacho=str_replace("'","",$libro->getValor("C".$numFila));
						$nombreEspecialidadDespacho=$libro->getValor("D".$numFila);
						$claveTipoProceso=str_replace("'","",$libro->getValor("E".$numFila));
						$nombreTipoProceso=$libro->getValor("F".$numFila);
						
						
						
						$oSerie='{"serie":"'.cv($serie).'","subserie":"'.cv($subserie).
								'","claveEspecialidadDespacho":"'.cv($claveEspecialidadDespacho).
								'","nombreEspecialidadDespacho":"'.cv($nombreEspecialidadDespacho).
								'","claveTipoProceso":"'.cv($claveTipoProceso).
								'","nombreTipoProceso":"'.cv($nombreTipoProceso).'"}';
						if($arrSeriesSubseries=="")
							$arrSeriesSubseries=$oSerie;
						else
							$arrSeriesSubseries.=",".$oSerie;
						$numFila++;
					}
					
					
					$cadJSON='{"fecha":"'.$fecha.'","nombreTabla":"'.cv($nombreTabla).'","cveTabla":"'.cv($cveTabla).'","version":"'.$version.
							'","registrosTRD":['.$arrRegistrosTRD.'],"oficinasProductoras":['.$arrOficinasProductoras.'],"Series_Subseries_Tipos":['.$arrSeriesSubseries.']}';
									
					$objJson=json_decode($cadJSON);
					
				break;
				case "xml":
					$xml=leerContenidoArchivo($baseDir."/archivosTemporales/".$obj->idArchivo);
					$cXML=simplexml_load_string($xml);
					
					if(!$cXML)
					{
						echo "1|[['1','El formato del archivo XML NO es v&aacute;lido']]";
						return;
					}
					$nombreTabla=(string)$cXML->nombreTabla[0];
					if($nombreTabla=="")
					{
						echo "1|[['1','El formato del archivo XML NO es v&aacute;lido']]";
						return;
					}
					
					$fecha=(string)$cXML->fecha[0];
					
					$cveTabla=(string)$cXML->cveTabla[0];
					$version=(string)$cXML->version[0];
					$arrRegistrosTRD="";
					
					foreach($cXML->registrosTRD[0] as $o)
					{
						$arrSubseries="";
						
						foreach($o->arrElementosHijos[0] as $o2)
						{
							$arrTiposDocumentales="";
							foreach($o2->arrElementosHijos[0] as $o3)
							{
								$oRegistro='{"serie":"'.((string)$o3->serie[0]).'","subserie":"'.((string)$o3->subserie[0]).'","tituloElemento":"'.cv((string)$o3->tituloElemento[0]).
									'","soporteFisico":"'.((string)$o3->soporteFisico[0]).'","soporteElectronico":"'.((string)$o3->soporteElectronico[0]).'","retencionArchivoGestion":"'.
									((string)$o3->retencionArchivoGestion[0]).'","retencionArchivoCentral":"'.((string)$o3->retencionArchivoCentral[0]).'","conservacionTotal":"'.
									((string)$o3->conservacionTotal[0]).'","eliminacion":"'.((string)$o3->eliminacion[0]).'","microfilmacionDigitalizacion":"'.
									((string)$o3->microfilmacionDigitalizacion[0]).'","seleccion":"'.((string)$o3->seleccion[0]).'","procedimiento":"'.cv((string)$o3->procedimiento[0]).
									'","tipoElemento":"'.((string)$o3->tipoElemento[0]).'","arrElementosHijos":[]}';
								if($arrTiposDocumentales=="")
									$arrTiposDocumentales=$oRegistro;
								else
									$arrTiposDocumentales.=",".$oRegistro;
							}
							$oRegistro='{"serie":"'.((string)$o2->serie[0]).'","subserie":"'.((string)$o2->subserie[0]).'","tituloElemento":"'.cv((string)$o2->tituloElemento[0]).
								'","soporteFisico":"'.((string)$o2->soporteFisico[0]).'","soporteElectronico":"'.((string)$o2->soporteElectronico[0]).'","retencionArchivoGestion":"'.
								((string)$o2->retencionArchivoGestion[0]).'","retencionArchivoCentral":"'.((string)$o2->retencionArchivoCentral[0]).'","conservacionTotal":"'.
								((string)$o2->conservacionTotal[0]).'","eliminacion":"'.((string)$o2->eliminacion[0]).'","microfilmacionDigitalizacion":"'.
								((string)$o2->microfilmacionDigitalizacion[0]).'","seleccion":"'.((string)$o2->seleccion[0]).'","procedimiento":"'.cv((string)$o2->procedimiento[0]).
								'","tipoElemento":"'.((string)$o2->tipoElemento[0]).'","arrElementosHijos":['.$arrTiposDocumentales.']}';
							if($arrSubseries=="")
								$arrSubseries=$oRegistro;
							else
								$arrSubseries.=",".$oRegistro;
						}
						
						$oRegistro='{"serie":"'.((string)$o->serie[0]).'","subserie":"'.((string)$o->subserie[0]).'","tituloElemento":"'.cv((string)$o->tituloElemento[0]).
								'","soporteFisico":"'.((string)$o->soporteFisico[0]).'","soporteElectronico":"'.((string)$o->soporteElectronico[0]).'","retencionArchivoGestion":"'.
								((string)$o->retencionArchivoGestion[0]).'","retencionArchivoCentral":"'.((string)$o->retencionArchivoCentral[0]).'","conservacionTotal":"'.
								((string)$o->conservacionTotal[0]).'","eliminacion":"'.((string)$o->eliminacion[0]).'","microfilmacionDigitalizacion":"'.
								((string)$o->microfilmacionDigitalizacion[0]).'","seleccion":"'.((string)$o->seleccion[0]).'","procedimiento":"'.cv((string)$o->procedimiento[0]).
								'","tipoElemento":"'.((string)$o->tipoElemento[0]).'","arrElementosHijos":['.$arrSubseries.']}';
						if($arrRegistrosTRD=="")
							$arrRegistrosTRD=$oRegistro;
						else
							$arrRegistrosTRD.=",".$oRegistro;
					}
					
					
					$arrOficinasProductoras="";
					foreach($cXML->oficinasProductoras[0] as $o)
					{
						$oOficina='{"codigoUnidad":"'.((string)$o->codigoUnidad[0]).'","claveDepartamental":"'.((string)$o->claveDepartamental[0]).'","unidad":"'.cv((string)$o->unidad[0]).'"}';
						if($arrOficinasProductoras=="")
							$arrOficinasProductoras=$oOficina;
						else
							$arrOficinasProductoras.=",".$oOficina;
					}
					
					$arrSeriesSubseries="";
					foreach($cXML->Series_Subseries_Tipos[0] as $o)
					{
						
						$oSerie='{"serie":"'.((string)$o->serie[0]).'","subserie":"'.((string)$o->subserie[0]).
								'","claveEspecialidadDespacho":"'.cv((string)$o->claveEspecialidadDespacho[0]).
								'","nombreEspecialidadDespacho":"'.((string)$o->nombreEspecialidadDespacho[0]).
								'","claveTipoProceso":"'.((string)$o->claveTipoProceso[0]).
								'","nombreTipoProceso":"'.((string)$o->nombreTipoProceso[0]).'"}';
						if($arrSeriesSubseries=="")
							$arrSeriesSubseries=$oSerie;
						else
							$arrSeriesSubseries.=",".$oSerie;
					}
					
					$cadJSON='{"fecha":"'.$fecha.'","nombreTabla":"'.cv($nombreTabla).'","cveTabla":"'.cv($cveTabla).'","version":"'.$version.
								'","registrosTRD":['.$arrRegistrosTRD.'],"oficinasProductoras":['.$arrOficinasProductoras.'],"Series_Subseries_Tipos":['.$arrSeriesSubseries.']}';
					
					$objJson=json_decode($cadJSON);
					
					
					
				break;
			}
			
			$numErrores=1;
			$arrFormatos="";
			foreach($objJson->registrosTRD as $r)
			{
				foreach($r->arrElementosHijos as $r2)
				{
					if($r2->tipoElemento==3)
					{
						$consulta="SELECT idCategoria FROM 908_categoriasDocumentos WHERE nombreCategoria='".cv($r2->tituloElemento)."'";
						$tipoDocumento=$con->obtenerValor($consulta);
						if($tipoDocumento=="")
						{
							/*$o="['".$numErrores."','El tipo documental <b>".cv($r2->tituloElemento)."</b> no se encuentra registrado en el sistema, NO se puede importar el archivo']";
							if($arrFormatos=="")
								$arrFormatos=$o;
							else
								$arrFormatos.=",".$o;
							$numErrores++;*/
							
							$consulta="INSERT INTO 908_categoriasDocumentos(nombreCategoria,idCategoriaDocumento,idPerfilMetaDatos,situacionActual)
									 VALUES('".cv($r2->tituloElemento)."',1,1,1)";
							$con->ejecutarCOnsulta($consulta);
							$tipoDocumento=$con->obtenerUltimoID();
							
							
						}
					}
					foreach($r2->arrElementosHijos as $r3)
					{
						
						$consulta="SELECT idCategoria FROM 908_categoriasDocumentos WHERE nombreCategoria='".cv($r3->tituloElemento)."'";
						$tipoDocumento=$con->obtenerValor($consulta);
						if($tipoDocumento=="")
						{
							/*$o="['".$numErrores."','El tipo documental <b>".cv($r3->tituloElemento)."</b> no se encuentra registrado en el sistema, NO se puede importar el archivo']";
							if($arrFormatos=="")
								$arrFormatos=$o;
							else
								$arrFormatos.=",".$o;
							$numErrores++;*/
							$consulta="INSERT INTO 908_categoriasDocumentos(nombreCategoria,idCategoriaDocumento,idPerfilMetaDatos,situacionActual)
									 VALUES('".cv($r3->tituloElemento)."',1,1,1)";
							$con->ejecutarCOnsulta($consulta);
							$tipoDocumento=$con->obtenerUltimoID();
						}
						
					}
				}
			}
			
			if($arrFormatos!="")
			{
				echo "1|[".$arrFormatos."]";
				return;
			}
			
			
			
			$consulta="SELECT * FROM 908_tablasRetencionDocumental WHERE cveTabla='".cv(trim($objJson->cveTabla))."' AND nombreTabla='".cv(trim($objJson->nombreTabla))."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($obj->validarExistencia==1)
			{
				if($fRegistro)
				{
					echo "2|";
					return;
				}
			}
			$nombreTRD=$objJson->nombreTabla;
			$x=0;
			$query[$x]="begin";
			$x++;
			
			if($obj->crearNuevaTRD==1)
			{
				$query[$x]="INSERT INTO 908_tablasRetencionDocumental(cveTabla,nombreTabla,idResponsableCreacion,fechaCreacion)
							VALUES('".cv($objJson->cveTabla)."','".cv($objJson->nombreTabla)."',".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."')";
				$x++;
				$query[$x]="set @idTabla:=(select last_insert_id())";
				$x++;			
				$versionTRD=1;
				$query[$x]="INSERT INTO 908_versionesTablasRetencionDocumental(idTablaRetencion,VERSION,situacionActual)
							VALUES(@idTabla,".$versionTRD.",1)";
				$x++;
			}
			else
			{
				$query[$x]="set @idTabla:=".$fRegistro["idTablaRetencion"];
				$x++;
				
				$consulta="SELECT MAX(VERSION) FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$fRegistro["idTablaRetencion"];
				$versionTRD=$con->obtenerValor($consulta);
				if($versionTRD=="")
				{
					$versionTRD=0;
				}
				$versionTRD++;
				$query[$x]="INSERT INTO 908_versionesTablasRetencionDocumental(idTablaRetencion,VERSION,situacionActual)
							VALUES(@idTabla,".$versionTRD.",1)";
				$x++;
			}
			
			foreach($objJson->registrosTRD as $r)
			{
				$totalSeriesImportadas++;
				$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
							 soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
							 conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tipoElemento,tituloElemento,VERSION) VALUES
							 (@idTabla,NULL,NULL,'".cv($r->serie)."',NULL,".$r->soporteFisico.",".$r->soporteElectronico.",".
							 ($r->retencionArchivoGestion==""?"NULL":$r->retencionArchivoGestion).",".($r->retencionArchivoGestion==""?"NULL":"3").
							 ",".($r->retencionArchivoCentral==""?"NULL":$r->retencionArchivoCentral).",".($r->retencionArchivoCentral==""?"NULL":"3").
							 ",".$r->conservacionTotal.",".$r->eliminacion.",".$r->microfilmacionDigitalizacion.",".$r->seleccion.
							 ",'".cv($r->procedimiento)."',1,'".cv($r->tituloElemento)."',".$versionTRD.")";
				$x++;
				
				$query[$x]="set @idElemento_".$r->serie."_:=(select last_insert_id())";
				$x++;
				
				foreach($r->arrElementosHijos as $r2)
				{
					if($r2->tipoElemento==2)
					{
						$totalSubSeriesImportadas++;
						$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
							 soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
							 conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tipoElemento,tituloElemento,VERSION) VALUES
							 (@idTabla,@idElemento_".$r->serie."_,NULL,'".cv($r2->subserie)."',NULL,".$r2->soporteFisico.",".$r2->soporteElectronico.",".
							 ($r2->retencionArchivoGestion==""?"NULL":$r2->retencionArchivoGestion).",".($r2->retencionArchivoGestion==""?"NULL":"3").
							 ",".($r2->retencionArchivoCentral==""?"NULL":$r2->retencionArchivoCentral).",".($r2->retencionArchivoCentral==""?"NULL":"3").
							 ",".$r2->conservacionTotal.",".$r2->eliminacion.",".$r2->microfilmacionDigitalizacion.",".$r2->seleccion.
							 ",'".cv($r2->procedimiento)."',".$r2->tipoElemento.",'".cv($r2->tituloElemento)."',".$versionTRD.")";
						$x++;
						$query[$x]="set @idElemento_".($r->serie."_".$r2->subserie).":=(select last_insert_id())";
						$x++;
					}
					else
					{
						$totalTiposDocumentalesImportadas++;
						$consulta="SELECT idCategoria FROM 908_categoriasDocumentos WHERE nombreCategoria='".cv($r2->tituloElemento)."'";
						$tipoDocumento=$con->obtenerValor($consulta);
						$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
							 soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
							 conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tipoElemento,tituloElemento,VERSION) VALUES
							 (@idTabla,@idElemento_".$r->serie."_,0,'',".$tipoDocumento.",".$r2->soporteFisico.",".$r2->soporteElectronico.",".
							 ($r2->retencionArchivoGestion==""?"NULL":$r2->retencionArchivoGestion).",".($r2->retencionArchivoGestion==""?"NULL":"3").
							 ",".($r2->retencionArchivoCentral==""?"NULL":$r2->retencionArchivoCentral).",".($r2->retencionArchivoCentral==""?"NULL":"3").
							 ",".$r2->conservacionTotal.",".$r2->eliminacion.",".$r2->microfilmacionDigitalizacion.",".$r2->seleccion.
							 ",'".cv($r2->procedimiento)."',".$r2->tipoElemento.",'',".$versionTRD.")";
						$x++;
						$query[$x]="set @idElemento_".($r->serie."_0").":=(select last_insert_id())";
						$x++;
					}
					
					
					foreach($r2->arrElementosHijos as $r3)
					{
						$totalTiposDocumentalesImportadas++;
						$consulta="SELECT idCategoria FROM 908_categoriasDocumentos WHERE nombreCategoria='".cv($r3->tituloElemento)."'";
						$tipoDocumento=$con->obtenerValor($consulta);
						if($tipoDocumento=="")
						{
							$consulta="INSERT INTO 908_categoriasDocumentos(nombreCategoria,idCategoriaDocumento,idPerfilMetaDatos,situacionActual)
									 VALUES('".cv($r3->tituloElemento)."',1,1,1)";
							$con->ejecutarConsulta($consulta);
							$tipoDocumento=$con->obtenerUltimoID();
						}
						
						$query[$x]="INSERT INTO 908_registrosTablasRetencionDocumental(idTablaRetencion,idSerie,idSubSerie,cveElemento,tipoDocumento,soporteFisico,
								 soporteElectronico,retencionArchivoGestion,unidadRetencionArchivoGestion,retencionArchivoCentral,unidadRetencionArchivoCentral,
								 conservacionTotal,eliminacion,microfilmacionDigitalizacion,seleccion,procedimiento,tipoElemento,tituloElemento,VERSION) VALUES
								 (@idTabla,@idElemento_".$r->serie."_,@idElemento_".($r->serie."_".$r2->subserie).",'',".$tipoDocumento.",".$r3->soporteFisico.",".$r3->soporteElectronico.",".
								 ($r3->retencionArchivoGestion==""?"NULL":$r3->retencionArchivoGestion).",".($r3->retencionArchivoGestion==""?"NULL":"3").
								 ",".($r3->retencionArchivoCentral==""?"NULL":$r3->retencionArchivoCentral).",".($r3->retencionArchivoCentral==""?"NULL":"3").
								 ",".$r3->conservacionTotal.",".$r3->eliminacion.",".$r3->microfilmacionDigitalizacion.",".$r3->seleccion.
								 ",'".cv($r3->procedimiento)."',3,'',".$versionTRD.")";
						$x++;
					}
					
				}
				
				
			}
			
			foreach($objJson->oficinasProductoras as $o)
			{
				$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE claveRegistro='".$o->claveDepartamental."'";
				$despacho=$con->obtenerValor($consulta);
				if($despacho!="")
				{
					$query[$x]="INSERT INTO 908_despachosTablaRetencion(idTablaRetencion,VERSION,despacho) 
								VALUES(@idTabla,".$versionTRD.",'".$despacho."')";
					$x++;
				}
			}
			
			foreach($objJson->Series_Subseries_Tipos as $s)
			{
				$consulta="SELECT id__637_tablaDinamica,claveEspecialidadDespacho,nombreEspecialidadDespacho FROM 
						_637_tablaDinamica WHERE nombreEspecialidadDespacho='".cv(trim($s->nombreEspecialidadDespacho))."'";
				$fEspecialidad=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if(!$fEspecialidad)
				{
					$fEspecialidad=array();
					$fEspecialidad["claveEspecialidadDespacho"]=$fEspecialidad["claveEspecialidadDespacho"];
					$fEspecialidad["nombreEspecialidadDespacho"]=$fEspecialidad["nombreEspecialidadDespacho"];
					$arrDocumentos=NULL;
					$fEspecialidad["id__637_tablaDinamica"]=crearInstanciaRegistroFormulario(637,-1,2,$fEspecialidad,$arrDocumentos,-1,0);
					
				}
				
				$consulta="SELECT id__625_tablaDinamica,claveTipoProceso,nombreTipoProceso FROM _625_tablaDinamica 
							WHERE nombreTipoProceso='".cv(trim($s->nombreTipoProceso))."' AND especialidad='".
							$fEspecialidad["id__637_tablaDinamica"]."'";
					
				$fTipoProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if(!$fTipoProceso)
				{
					$fTipoProceso=array();
					$fTipoProceso["claveTipoProceso"]=$fEspecialidad["claveEspecialidadDespacho"];
					$fTipoProceso["nombreTipoProceso"]=$fEspecialidad["nombreEspecialidadDespacho"];
					$arrDocumentos=NULL;
					$fTipoProceso["id__625_tablaDinamica"]=crearInstanciaRegistroFormulario(625,-1,2,$fTipoProceso,$arrDocumentos,-1,0);
				}
				
				$query[$x]="INSERT INTO 908_seriesTiposProcesos(idSerie,tipoProceso) VALUES(@idElemento_".($s->serie."_".$s->subserie).",".$fTipoProceso["id__625_tablaDinamica"].")";
				$x++;
				
			}
			$query[$x]="INSERT INTO 908_importacionesTRDs(fechaRegistro,nombreArchivo,totalSeriesImportadas,totalSubSeriesImportadas,totalTiposDocumentalesImportadas,
						versionImportada,responsableImportacion,idTRDImportacion,tipoImportacion,nombreTRD)
						VALUES('".date("Y-m-d H:i:s")."','".$obj->nombreArchivo."',".$totalSeriesImportadas.",".$totalSubSeriesImportadas.",".$totalTiposDocumentalesImportadas.
						",".$versionTRD.",".$_SESSION["idUsr"].",@idTabla,".$obj->crearNuevaTRD.",'".cv($nombreTRD)."')";
			$x++;
						
			$query[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($query))
			{
				$resumen="<b>Tipo de acci&oacute;n:</b> ".($obj->crearNuevaTRD==1?"Se crea nueva TRD":"Se actualiza TRD")."<br>";
				$resumen.="<b>Versi&oacute;n de TRD importada:</b> ".$versionTRD."<br>";
				$resumen.="<b>Total series importadas:</b> ".$totalSeriesImportadas."<br>";
				$resumen.="<b><b>Total subseries importadas:</b> ".$totalSubSeriesImportadas."<br>";
				$resumen.="<b>Total tipos documentales importados:</b> ".$totalTiposDocumentalesImportadas."<br>";
				
				$comentarioAdicionalSQL="Se importa versión ".$versionTRD." de TRD. Rs&uacute;men de la operaci&oacute;n:<br><br>".$resumen;
				guardarRegistroBitacoraSistema("../gestorDocumental/tablaRetencionDocumental.php",$obj->nombreArchivo,13,("TRD: ".trim($objJson->nombreTabla).".- ".$comentarioAdicionalSQL));
				
				echo "1|[['1','<b>Nombre de la TRD:</b> ".cv($nombreTRD)."'],['2','<b>Tipo de acci&oacute;n:</b> ".($obj->crearNuevaTRD==1?"Se crea nueva TRD":"Se actualiza TRD")."'],['3','<b>Versi&oacute;n de TRD importada:</b> ".$versionTRD.
						"'],['4','<b>Total series importadas:</b> ".$totalSeriesImportadas.
						"'],['5','<b>Total subseries importadas:</b> ".$totalSubSeriesImportadas.
						"'],['6','<b>Total tipos documentales importados:</b> ".$totalTiposDocumentalesImportadas."']]";
			}
			
			
			
		}
		catch(Exception $e)
		{
			echo "1|[['1','".cv($e->getMessage())."']]";
		}
	}
?>