<?php	include_once("conexionBD.php");

	function realizarRepartoAsunto($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _698_tablaDinamica WHERE id__698_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$cuantiaProceso=$fRegistro["cuantiaProceso"];
		if(($fRegistro["carpetaAdministrativa"]!="N/E")&&($fRegistro["carpetaAdministrativa"]!=""))
		{
			return true;
		}
		
		if($fRegistro["idProcesoPadre"]==285)
		{
			$iFormulario=obtenerFormularioBase($fRegistro["idProcesoPadre"]);
			$iRegistro=$fRegistro["idReferencia"];
			
			$cAdminitrativa="";
			if($iFormulario==699)
			{
				$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$iRegistro;
				$cAdminitrativa=$con->obtenerValor($consulta);
			}
			else
				$cAdminitrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			

			$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdminitrativa."'";
			$cveDespacho=$con->obtenerValor($consulta);
		}
		else
		{
			$consulta="SELECT id__642_tablaDinamica FROM _642_tablaDinamica WHERE aplicableA=1 and idEstado=2";
			$listaGrupos=$con->obtenerListaValores($consulta);
			
			if($listaGrupos=="")
				$listaGrupos=-1;
				
			$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fRegistro["jurisdiccion"]." AND especialidad=".$fRegistro["especialidad"].
						" and tipoProceso=".$fRegistro["tipoProceso"]." 
						AND cmbTema=".$fRegistro["temaProceso"]." order by id__643_tablaDinamica asc";
						
			$listaAmbitos=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas==0)
			{
				
				$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fRegistro["jurisdiccion"]." AND especialidad=".$fRegistro["especialidad"].
						" and tipoProceso=".$fRegistro["tipoProceso"]."  order by id__643_tablaDinamica asc";
						
				$listaAmbitos=$con->obtenerListaValores($consulta);
				if($con->filasAfectadas==0)
				{
	
					$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
							and jurisdiccion=".$fRegistro["jurisdiccion"]." AND especialidad=".$fRegistro["especialidad"].
							"  order by id__643_tablaDinamica asc";
					$listaAmbitos=$con->obtenerListaValores($consulta);
					if($con->filasAfectadas==0)
					{
						
						$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
							and jurisdiccion=".$fRegistro["jurisdiccion"]."  order by id__643_tablaDinamica asc";
						$listaAmbitos=$con->obtenerListaValores($consulta);
						if($con->filasAfectadas==0)
						{
						
							$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
										 order by id__643_tablaDinamica asc";
							$listaAmbitos=$con->obtenerListaValores($consulta);
	
						}
					}
				}
			}
			
			
			
			if($listaAmbitos=="")
				$listaAmbitos=-1;
	
			$filaGrupo=null;
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=1 ";
	
			$rAmbitos=$con->obtenerFilas($consulta);
			while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
			{
				$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica=".$filaGrupoAux["id__643_tablaDinamica"].
							" and '".$cuantiaProceso."'".$filaGrupoAux["opCuantiaMinima"]."montoCuantiaMinima AND '".$cuantiaProceso.
							"'".$filaGrupoAux["opCuantiaMaxima"]."montoCuantiaMaxima";
				
				$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($filaGrupo)
					break;
			}
	
			
			if(!$filaGrupo)
			{
				$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=0 order by  id__643_tablaDinamica asc";
				$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
			}
			
			$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".$filaGrupo["idReferencia"];
			$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT despacho FROM _644_tablaDinamica d,817_organigrama o WHERE d.idReferencia=".$filaGrupo["idReferencia"]." and 
						o.codigoUnidad=d.despacho order by";
						
			if($fGrupoReparto["metodoAsignacion"]==1) //Aleatorio
			{
				$consulta.=" rand()";
			}
			else
			{
				$consulta.=" claveDepartamental";
			}
						
			$universoDespachos=$con->obtenerListaValores($consulta);
			$arrConfiguracion["tipoAsignacion"]="";
			$arrConfiguracion["serieRonda"]="GrupoReparto_".$filaGrupo["idReferencia"];
			$arrConfiguracion["universoAsignacion"]=$universoDespachos;
			$arrConfiguracion["idObjetoReferencia"]=-1;
			$arrConfiguracion["pagarDeudasAsignacion"]=false;
			$arrConfiguracion["considerarDeudasMismaRonda"]=false;
			$arrConfiguracion["limitePagoRonda"]=0;
			$arrConfiguracion["escribirAsignacion"]=true;
			$arrConfiguracion["idFormulario"]=$idFormulario;
			$arrConfiguracion["idRegistro"]=$idRegistro;
			
			
			$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
			$cveDespacho=$resultado["idUnidad"];
		}

		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		
		$consulta="SELECT carpetaAdministrativa,idActividad,tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	
		
		if(($fDatosCarpeta[0]!="")&&($fDatosCarpeta[0]!="N/E"))
			return true;
		$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$fDatosCarpeta[2],$idFormulario,$idRegistro);	
		$carpetaAdministrativa=$arrCodigoUnico[0];
		
		$fechaCarpetaJudicial=date("Y-m-d H:i:s");
		$idActividad=$fDatosCarpeta[1];
		
		$query="SELECT id__626_tablaDinamica FROM _626_tablaDinamica WHERE idReferencia=".$fRegistro["tipoProceso"];
		$claseProceso=$con->obtenerValor($query);
		
		$query="SELECT id__627_tablaDinamica FROM _627_tablaDinamica WHERE idReferencia=".$claseProceso;
		$subClaseProceso=$con->obtenerValor($query);
		if($subClaseProceso=="")
			$subClaseProceso="NULL";
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idTRD="NULL";
		$version="NULL";
		$serie="NULL";
		$subserie="NULL";
		$idPerfilAcceso="-1";
		
		$query="SELECT perfilAccesoDefault FROM _1250_tablaDinamica WHERE id__1250_tablaDinamica=".$fRegistro["tipoProceso"];
		$idPerfilAcceso=$con->obtenerValor($query);
		 
		
		$arrDatos=obtenerTRDExpediente($cveDespacho,$fechaCarpetaJudicial,$fRegistro["tipoProceso"]);
		if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
		{
			$idTRD=$arrDatos["idTablaRetencion"];
			$version=$arrDatos["version"];
			$serie=$arrDatos["idSerie"];
			$subserie=$arrDatos["idSubserie"];
			
		}
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema,
						idTRD,VERSION,serie,subserie,idPerfilAcceso) 
						VALUES('".$carpetaAdministrativa."','".$fechaCarpetaJudicial."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',1,".$idActividad.",'',1,'".$cveDespacho."',".$fRegistro["especialidad"].",".
						$fRegistro["tipoProceso"].",".$claseProceso.",".$subClaseProceso.
						",".$fRegistro["temaProceso"].",".$fRegistro["subtemaProceso"].",".$idTRD.",".$version.",".$serie.",".$subserie.
						",".$idPerfilAcceso.")";
		$x++;
		
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa='".$carpetaAdministrativa.
					"',codigoInstitucion='".$cveDespacho."',despachoAsignado='".$cveDespacho.
					"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		if(!existeRol("'31_0'"))
		{
			$consulta[$x]="UPDATE _".$idFormulario."_tablaDinamica SET fechadeRecepcion='".date("Y-m-d")."',horadeRecepcion='".date("H:i:s").
						"' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$x++;
			
			$anioExpediente=date("Y",strtotime($fechaCarpetaJudicial));
			$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
					cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
					(".$_SESSION["idUsr"].",@idCarpeta,'".$carpetaAdministrativa."',".
					$fRegistro["especialidad"].",1,'".$fechaCarpetaJudicial."','".$cveDespacho."',".$anioExpediente.
					",-1)";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($consulta))
		{
	
			$query="SELECT * FROM 9503_documentosRegistradosProceso WHERE idActividad=".$idActividad." and idDocumento IS NOT NULL";
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchAssoc($rDocumentos))
			{
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento["idDocumento"],$idFormulario,$idRegistro);
			}
			
			
			return true;
	
		}
		return false;
		
	}
	
	function realizarRepartoAsuntoTutela($idFormulario,$idRegistro)
	{
		global $con;
		
		$idUsuarioAgregadoSesion=-1;
		$anioExpediente="";
		$consulta="SELECT carpetaAdministrativa,'2' as especialidad,'NULL' as claseProceso,'6' as tipoProceso,'NULL' as subClaseProceso,'NULL' as temaProceso,'NULL' as subtemaProceso FROM _717_tablaDinamica WHERE id__717_tablaDinamica=".$idRegistro;
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$cuantiaProceso=0;
		
		if(($fRegistro["carpetaAdministrativa"]!="N/E")&&($fRegistro["carpetaAdministrativa"]!=""))
		{
			
			return true;
		}

		
		
		$cveDespacho="100000030017000100010001";
		
		$consulta="SELECT * FROM 7006_repartoManual WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$fReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fReparto)
		{
			$cveDespacho=$fReparto["despachoAsignado"];
		}
		
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		
		$consulta="SELECT carpetaAdministrativa,idActividad,'6' as tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

		$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	
		
		if(($fDatosCarpeta[0]!="")&&($fDatosCarpeta[0]!="N/E"))
		{
			
			return true;
		}
		
		$carpetaAdministrativa="";
		if(!$fReparto)
		{
			$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$fDatosCarpeta[2],$idFormulario,$idRegistro);	
			$carpetaAdministrativa=$arrCodigoUnico[0];
		}
		else
		{
			$carpetaAdministrativa=$fReparto["cup"];
		}
		$fechaCarpetaJudicial=date("Y-m-d H:i:s");
		$idActividad=$fDatosCarpeta[1];
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idTRD="0";
		$version="0";
		$serie="0";
		$subserie="0";
		$idPerfilAcceso="0";
		
		$query="SELECT perfilAccesoDefault FROM _1250_tablaDinamica WHERE id__1250_tablaDinamica=".$fRegistro["tipoProceso"];
		$idPerfilAcceso=$con->obtenerValor($query);
		
		$arrDatos=obtenerTRDExpediente($cveDespacho,$fechaCarpetaJudicial,$fRegistro["tipoProceso"]);
		if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
		{
			$idTRD=$arrDatos["idTablaRetencion"];
			$version=$arrDatos["version"];
			$serie=$arrDatos["idSerie"];
			$subserie=$arrDatos["idSubserie"];
			
		}
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema,
						idTRD,VERSION,serie,subserie,idPerfilAcceso) 
						VALUES('".$carpetaAdministrativa."','".$fechaCarpetaJudicial."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',1,".$idActividad.",'',1,'".$cveDespacho."',".$fRegistro["especialidad"].",".
						$fRegistro["tipoProceso"].",".$fRegistro["claseProceso"].",".$fRegistro["subClaseProceso"].
						",".$fRegistro["temaProceso"].",".$fRegistro["subtemaProceso"].",".$idTRD.",".$version.",".$serie.",".$subserie.
						",".$idPerfilAcceso.")";
		$x++;
		
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa='".$carpetaAdministrativa.
					"',codigoInstitucion='".$cveDespacho."',despachoAsignado='".$cveDespacho.
					"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		$anioExpediente=date("Y",strtotime($fechaCarpetaJudicial));
		if(!existeRol("'31_0'"))
		{
			$consulta[$x]="UPDATE _".$idFormulario."_tablaDinamica SET fechaRecepcionRegistroTutela='".date("Y-m-d")."',horaRecepcionRegistroTutela='".date("H:i:s").
						"' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$x++;
			
			
			$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
					cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
					(".$_SESSION["idUsr"].",@idCarpeta,'".$carpetaAdministrativa."',".
					$fRegistro["especialidad"].",1,'".$fechaCarpetaJudicial."','".$cveDespacho."',".$anioExpediente.
					",-1)";
			$x++;
			
			$idUsuarioAgregadoSesion=$_SESSION["idUsr"];
		}
		
		
		$query="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad;
		$res=$con->obtenerFilas($query);
		while($fFigura=$con->fetchAssoc($res))
		{
			$idUsuarioAcceso=$fFigura["idCuentaAcceso"];
			if($idUsuarioAcceso=="")
			{
				$idUsuarioAcceso=convertirParticipanteProcesoCuentaSistema($fFigura["idParticipante"],"10000004","23");
			}
			
			if(($idUsuarioAgregadoSesion!=$idUsuarioAcceso)&&($idUsuarioAcceso!=-1))
			{
			
				$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
								cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
								(".$idUsuarioAcceso.",@idCarpeta,'".$carpetaAdministrativa."',".
								$fRegistro["especialidad"].",1,'".$fechaCarpetaJudicial."','".$cveDespacho."',".$anioExpediente.
								",".$fFigura["idParticipante"].")";
				$x++;
			}
			
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
	
			$query="SELECT * FROM 9503_documentosRegistradosProceso WHERE idActividad=".$idActividad." and idDocumento IS NOT NULL";
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchAssoc($rDocumentos))
			{
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento["idDocumento"],$idFormulario,$idRegistro);
			}
			
			
			return true;
	
		}
		return false;
		
		
	}
	
	function obtenerPlantillaAuto($idFormularioEvaluacion,$idFormulario,$idRegistro,$actor)
	{
		global $con;
			
		$consulta="SELECT tipoDocumento FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return $tipoDocumento;
	}
	
	function obtenerTipoNotificacionAcuerdo($idFormulario,$idRegistro)
	{
		global $con;
		
		$tipoDocumento="";
		if($idFormulario==899)
		{
			$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
			$providenciaAplicar=$con->obtenerValor($consulta);
			$consulta="SELECT plantillaAsociada FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
			$tipoDocumento=$con->obtenerValor($consulta);
		}
		else
		{
		
			$consulta="SELECT tipoDocumento FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;	
			$tipoDocumento=$con->obtenerValor($consulta);
		}
		$consulta="SELECT id__666_tablaDinamica FROM _666_tablaDinamica t,_666_gDocumentosAsociados gA 
			WHERE t.id__666_tablaDinamica=gA.idReferencia AND gA.tipoDocumento=".$tipoDocumento;
		$idNotificacon=$con->obtenerValor($consulta);
		if($idNotificacon=="")
			$idNotificacon=2;
		return $idNotificacon;
	}
	
	function obtenerDocumentacionRequeridaClaseProceso($idFormulario,$idRegistro,$sL=false)
	{
		global $con;
		
		$arrRegistros="";
		if($sL)
		{
			$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$documentoDigital="";
				$tamano=0;
				if($fila["idDocumento"]!="")
				{
					$consulta="SELECT nomArchivoOriginal,tamano FROM 908_archivos WHERE idArchivo=".$fila["idDocumento"];
					$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$nombreDocumento=$fDatosDocumento["nomArchivoOriginal"];
					$documentoDigital=$nombreDocumento."|".$fila["idDocumento"];
					$tamano=$fDatosDocumento["tamano"];
				}
				
								
				
				$obligatorio=0;
				$oReg="['".$fila["idRegistro"]."','".cv($fila["idTipoDocumento"])."',true,'".cv($documentoDigital)."','".$obligatorio."','".$tamano."']";
				if($arrRegistros=="")
					$arrRegistros=$oReg;
				else
					$arrRegistros.=",".$oReg;
			}
			return "[".$arrRegistros."]";
		}
		
		$arrRegistros="";
		switch($idFormulario)
		{
			case 1225:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				$arrRegistros="";
				     
					
				$consulta="select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria in(164,165) ORDER BY nombreCategoria";	
				
				
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 1116:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				
				$claseProceso=32;
				
				     
					
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 677:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				
				$claseProceso=27;
				
				     
					
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 632:
			case 698:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				$consulta="SELECT (SELECT id__626_tablaDinamica FROM _626_tablaDinamica WHERE idReferencia=t.tipoProceso limit 0,1) as claseProceso,idActividad,
							medidaProvisional,tipoProceso
							 FROM ".$nombreTabla." t WHERE id_".$nombreTabla."=".$idRegistro;
				$fDatosProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				$claseProceso=$fDatosProceso["claseProceso"];
				$idActividad=$fDatosProceso["idActividad"];
				$arrRegistros="";
				     
					
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				if(($fDatosProceso["medidaProvisional"]==1)&&($fDatosProceso["tipoProceso"]==4))
				{
					$consulta="select * from (SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio,nombreCategoria 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido 
							
							union
							
							select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria=62
							) as tmp
							
							ORDER BY nombreCategoria";	
				}
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 699:
				$consulta="SELECT tipoActuacion,medidaProvisional FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
				$fRegistroActuacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$tActuacion=$fRegistroActuacion["tipoActuacion"];
				
				$consulta="SELECT '-1' AS idRegistro,idTipoDocumento AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatorio AS obligatorio 
								FROM _700_gDocumentosRequeridos d,908_categoriasDocumentos c
								WHERE d.idReferencia=".$tActuacion." AND c.idCategoria=d.idTipoDocumento ORDER BY c.nombreCategoria";	
				
				
				if($fRegistroActuacion["medidaProvisional"]==1)
				{
					$consulta="select * from (SELECT '-1' AS idRegistro,idTipoDocumento AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatorio AS obligatorio,nombreCategoria 
							FROM _700_gDocumentosRequeridos d,908_categoriasDocumentos c
							WHERE d.idReferencia=".$tActuacion." AND c.idCategoria=d.idTipoDocumento 
							
							union
							
							select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria=62
							) as tmp
							
							ORDER BY nombreCategoria";	
				}
				
				
				
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];
					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$idRegistroDocumento=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$idRegistroDocumento=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$idRegistroDocumento."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
				
			break;
			case 717:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				$consulta="SELECT '9' as claseProceso,idActividad,medidaProvisional FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
				$fDatosProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				$claseProceso=$fDatosProceso["claseProceso"];
				$arrRegistros="";
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				if($fDatosProceso["medidaProvisional"]==1)
				{
					$consulta="select * from (SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio,nombreCategoria 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido 
							
							union
							
							select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria=132
							) as tmp
							
							ORDER BY nombreCategoria";	
				}
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
				
				
			break;
			
			case 1004:
			case 1009:
			case 1010:
			case 1013:
			case 1021:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				$consulta="SELECT claseProceso,idActividad FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

				$fDatosProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				$claseProceso=$fDatosProceso["claseProceso"];
				$idActividad=$fDatosProceso["idActividad"];
				$arrRegistros="";
				     
				$sentenciaCastellano=false;	
				$acreditaEnvioDemanda=false;
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				

				if($idFormulario=="1009")
				{
					$query="SELECT sentenciaCastellano FROM _1009_tablaDinamica WHERE id__1009_tablaDinamica=".$idRegistro;
					$sentenciaCastellano=$con->obtenerValor($query);
					$sentenciaCastellano=$sentenciaCastellano==0?true:false;
				}
				if($sentenciaCastellano)
				{
					$consulta="select * from (SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio,nombreCategoria 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido
							
							union
							
							select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria=111
							) as tmp
							
							ORDER BY nombreCategoria";	

				}
				
				if($idFormulario=="1010")
				{
					$query="SELECT acreditaEnvioDemanda FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$idRegistro;
					$acreditaEnvioDemanda=$con->obtenerValor($query);
					$acreditaEnvioDemanda=$acreditaEnvioDemanda==1?true:false;
				}
				

				if($acreditaEnvioDemanda)
				{
					$consulta="select * from (SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio,nombreCategoria 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido
							
							union
							
							select '-1' as idRegistro,idCategoria AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,'1' AS obligatorio,nombreCategoria from 908_categoriasDocumentos where idCategoria=112
							) as tmp
							
							ORDER BY nombreCategoria";	

				}
				


				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 1163:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				
				$claseProceso=35;
				
				     
					
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			case 1162:
				$nombreTabla=obtenerNombreTabla($idFormulario);
				
				$claseProceso=34;
				
				     
					
				$consulta="SELECT '-1' AS idRegistro,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
							FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
							WHERE idReferencia=".$claseProceso." AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria";	
				
				
				
				

				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idTipoDocumento=".$fila["idDocumento"];

					$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$iRegistro=-1;
					$presentaDocumento=0;
					$documentoDigital="";
					if($fRegistroDocumento)
					{
						$iRegistro=$fRegistroDocumento["idRegistro"];
						$presentaDocumento=1;
						$documentoDigital=$fRegistroDocumento["idDocumento"];
						if($fRegistroDocumento["idDocumento"]!="")
						{
							$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
							$nombreDocumento=$con->obtenerValor($consulta);
							$documentoDigital=$nombreDocumento."|".$documentoDigital;
						}
					}
					
					
					$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				
				}
				
			break;
			default:
				$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$documentoDigital="";
					$tamano="";
					if($fila["idDocumento"]!="")
					{
						$consulta="SELECT nomArchivoOriginal,tamano FROM 908_archivos WHERE idArchivo=".$fila["idDocumento"];
						$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
						$nombreDocumento=$fDatosDocumento["nomArchivoOriginal"];
						$tamano=$fDatosDocumento["tamano"];
						$documentoDigital=$nombreDocumento."|".$fila["idDocumento"];
					}
					
					
					
					$obligatorio=0;
					$oReg="['".$fila["idRegistro"]."','".cv($fila["idTipoDocumento"])."',true,'".cv($documentoDigital)."','".$obligatorio."','".$tamano."']";
					if($arrRegistros=="")
						$arrRegistros=$oReg;
					else
						$arrRegistros.=",".$oReg;
				}
				
				
			break;
		}
		return "[".$arrRegistros."]";
		
		
	}
	
	
	function obtenerSustanciadorAsignado($idFormulario,$idRegistro,$actorDestinatario)
	{
		global $con;
		$arrDestinatarios=array();	
		
		$rolActor=obtenerTituloRol($actorDestinatario);
		
		if($idFormulario==696)
		{
			$nombreTabla=obtenerNombreTabla($idFormulario);
			$consulta="SELECT idProcesoPadre,idReferencia FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
			$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
			$idProcesoPadre=$fRegistroBase["idProcesoPadre"];
			if($idProcesoPadre==0)
			{
				return $arrDestinatarios;
				
			}
			else
			{
				$idFormulario=obtenerFormularioBase($idProcesoPadre);
				$idRegistro=$fRegistroBase["idReferencia"];
			}
		}
		
		$idFormularioSustanciador=0;
		$consulta="SELECT idProceso FROM 900_formularios WHERE idFormulario=".$idFormulario;
		$idProceso=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT nombreTabla FROM 900_formularios WHERE idProceso=".$idProceso;
		$listaTablas=$con->obtenerListaValores($consulta,"'");
		$consulta="SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME IN(".$listaTablas.") AND COLUMN_NAME='sustanciadorAsignado'";
		
		$resTablas=$con->obtenerFilas($consulta);
		while($fTablas=$con->fetchAssoc($resTablas))
		{
		
			$nombreTabla=$fTablas["TABLE_NAME"];
			
			$consulta="SELECT sustanciadorAsignado FROM ".$nombreTabla." WHERE idReferencia=".$idRegistro;	
	
			$resDestinatarios=$con->obtenerFilas($consulta);
			while($fDestinatario=$con->fetchAssoc($resDestinatarios))	
			{
				
				$nombreUsuario=obtenerNombreUsuario($fDestinatario["sustanciadorAsignado"])." (".$rolActor.")";
				$o='{"idUsuarioDestinatario":"'.$fDestinatario["sustanciadorAsignado"].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
				$oDestinatario=json_decode($o);
				
				array_push($arrDestinatarios,$oDestinatario);
			}
			
		}
		return $arrDestinatarios;
	}
	
	
	function analizarRutaNotificacionEnvio($idFormulario,$idRegistro)
	{
		global $con;
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nFila=1;
		$consulta="SELECT * FROM _665_gPersonasNotificar WHERE idReferencia=".$fNotificacion["id__665_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fDestinatario=$con->fetchAssoc($res))
		{
			if($nFila>1)
			{
				$query[$x]="INSERT INTO _665_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo,medioNotificacion,
							carpetaAdministrativa,tipoEnvioNotificacion,cuerpoNotificacion,tipoNotificacion,idProcesoPadre,idTipoDocumentoPrincipal,expedienteDespacho)
							SELECT idReferencia,fechaCreacion,responsable,1.5,codigoUnidad,codigoInstitucion,concat(codigo,'-".($nFila-1)."'),medioNotificacion,
							carpetaAdministrativa,tipoEnvioNotificacion,cuerpoNotificacion,tipoNotificacion,idProcesoPadre,idTipoDocumentoPrincipal,expedienteDespacho 
							FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$fNotificacion["id__665_tablaDinamica"];
				$x++;
				$query[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
				
				$query[$x]="UPDATE _665_gPersonasNotificar SET idReferencia=@idRegistro WHERE id__665_gPersonasNotificar=".$fDestinatario["id__665_gPersonasNotificar"];
				$x++;
				
				$query[$x]="INSERT INTO _665_gridDocumentosNotificar(idReferencia,idDocumento,nombreDocumento,tamanoDoc,categoriaDocumento)
						SELECT @idRegistro,idDocumento,nombreDocumento,tamanoDoc,categoriaDocumento FROM _665_gridDocumentosNotificar WHERE idReferencia=".$fNotificacion["id__665_tablaDinamica"];
				$x++;
				
			}
			$nFila++;
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT * FROM _665_tablaDinamica WHERE idReferencia=".$fNotificacion["idReferencia"]." and idEstado=1.5";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{

				if($fila["medioNotificacion"]!=2)
				{

					cambiarEtapaFormulario(665,$fila["id__665_tablaDinamica"],2.5,"",-1,"NULL","NULL",1419);
					prepararEnvioNotificacionV2(665,$fila["id__665_tablaDinamica"]);
				}
				else
					cambiarEtapaFormulario(665,$fila["id__665_tablaDinamica"],3.1,"",-1,"NULL","NULL",1419);
				
			}
			return true;
		}
	}
	
	
	function prepararEnvioNotificacionV2($idFormulario,$idRegistro)
	{
		global $con;
		$fechaActual=strtotime(date("Y-m-d H:i:s"));
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

		if($fRegistro["tipoEnvioNotificacion"]==1)
		{

			cambiarEtapaFormulario($idFormulario,$idRegistro,1.6,"",-1,"NULL","NULL",0);
			return enviarCorreoNotificacionV2($idFormulario,$idRegistro);
		}
		else
		{
			$fechaEnvio=strtotime($fRegistro["fechaEnvio"]." ".$fRegistro["horaEnvio"]);
			if($fechaEnvio<=$fechaActual)
			{
				cambiarEtapaFormulario($idFormulario,$idRegistro,1.6,"",-1,"NULL","NULL",0);
				return enviarCorreoNotificacionV2($idFormulario,$idRegistro);
			}
		}
			
	}
	
	function enviarCorreoNotificacionV2($idFormulario,$idRegistro)
	{
		global $con;
		global $funcionEnvioCorreoElectronico;
		global $urlSitio;
		global $versionLatis;
		$urlSitioHTTPS=str_replace("http://","https://",$urlSitio);
		$arrArchivos=array();
		$arrDestinatario=array();

		$consulta="select HEX(AES_ENCRYPT('".$idRegistro."', '".bD($versionLatis)."')) as idNotificacion";		
		$idNotificacion=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$fRegistro["tipoNotificacion"];
		$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT cuerpoNotificacion FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT asunto FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$asuntoMensaje=$con->obtenerValor($consulta);
		
		
		
		$cuerpoMensaje=generarCuerpoNotificacion($fRegistro["tipoNotificacion"],$fRegistro["carpetaAdministrativa"],$idFormulario,$idRegistro);

		
		$consulta="SELECT o.unidad,c.idActividad,c.especialidad,idCarpeta,c.unidadGestion,c.fechaCreacion FROM 7006_carpetasAdministrativas c,
					817_organigrama o WHERE c.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		

		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["codigoInstitucion"]."'";
		$arrParametros["nombreDespacho"]=$con->obtenerValor($consulta);
		$arrParametros["codigoUnicoProceso"]=$fRegistro["carpetaAdministrativa"];
		
		
		$idActividad=$fDatosCarpetas["idActividad"];
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica=2 ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demantante=="")
				$demantante=$nombre;
			else
				$demantante.=", ".$nombre;
		}
		
		$demandados="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}

		
		if($idActividad==-1)
		{
			$demantante="------";
			$demandados="------";
		}
		
		$arrParametros["demandante"]=$demantante;
		$arrParametros["demandado"]=$demandados;
		$arrParametros["lblEnlaceDocumentos"]="";

		if($fRegistro["idProcesoPadre"]==324)
		{
			$consulta="SELECT o.unidad FROM _911_tablaDinamica rI,817_organigrama o WHERE rI.despachoAsignado=o.codigoUnidad AND rI.id__911_tablaDinamica=".$fRegistro["idReferencia"];
			$arrParametros["salaDestinataria"]=$con->obtenerValor($consulta);
		}
		
		if($fRegistro["idProcesoPadre"]==330)
		{
			$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$fRegistro["idReferencia"];
			$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$arrParametros["codigoUnicoProceso2daInstancia"]=$fRegistroBase["carpetaAdministrativa2daInstancia"];
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["despachoAsignado"]."'";
			$arrParametros["nombreDespacho"]=$con->obtenerValor($consulta);

		}

		
		
		$totalDocumentos=0;
		$tabla="<tablaDocumentos><table style='border-top-style:solid;border-top-width:1px;border-top-color:#999'>";
		$consulta="SELECT * FROM _665_gridDocumentosNotificar WHERE idReferencia=".$idRegistro;
		$resDest=$con->obtenerFilas($consulta);
		while($fArchivo=$con->fetchAssoc($resDest))
		{
			$paginaGetFile=$urlSitioHTTPS."modulosEspeciales_SIUGJ/paginasFunciones/getDocumentNotify.php";
			$consulta="SELECT sha512 FROM 908_archivos WHERE idArchivo=".$fArchivo["idDocumento"];
			$sha512=$con->obtenerValor($consulta);
			$arrExtension=explode(".",$fArchivo["nombreDocumento"]);
			$extension=$arrExtension[sizeof($arrExtension)-1];
			$tabla.='<tr><td><a href="'.$paginaGetFile.'?f='.$sha512.'"><img src="'.$urlSitioHTTPS.'imagenesDocumentos/16/file_extension_'.mb_strtolower($extension).'.png"></a></td><td><a href="'.$paginaGetFile.'?f='.$sha512.'"><span style="font-size:13px"><b>'.$fArchivo["nombreDocumento"].'</b> ('.bytesToSize($fArchivo["tamanoDoc"],0).')</span></a></td></tr>';
			$totalDocumentos++;
		}

		if($totalDocumentos>1)
			$tabla.="<tr><td align='center' colspan='2'><span style=\"font-size:13px\"><a href='".$paginaGetFile."?nfy=".$idNotificacion."' target=\"_blank\">Descargar todos los archivos</a></span></td></tr></table>";
		else
			$tabla.="</table></tablaDocumentos>";	
		$arrParametros["fechaEnvio"]="";


		$consulta="SELECT * FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$resDest=$con->obtenerFilas($consulta);
		while($fDestinatario=$con->fetchAssoc($resDest))
		{
			
			$arrDestinatario=array();
			$arrMails=explode(",",$fDestinatario["email"]);
			foreach($arrMails as $m)
			{
				$oD[0]=$m;
				$oD[1]="";
				array_push($arrDestinatario,$oD);
			}
			if(sizeof($arrMails)==0)
				continue;
			$idCuentaAcceso=-1;
			$tipoCuentaAcceso=0;
			if(($fDestinatario["idPersona"]!="")&&($fDestinatario["idPersona"]!="-1"))
			{
				if($fDestinatario["idPersona"]>0)
				{
					$tipoCuentaAcceso=2;
					$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idParticipante=".$fDestinatario["idPersona"];
	
					$idCuentaAcceso=$con->obtenerValor($consulta);
	
					if($idCuentaAcceso=="")
					{

						foreach($arrMails as $m)
						{
							$consulta="SELECT idUsuario FROM 805_mails WHERE Mail='".$m."'";
							
							$idCuentaAcceso=$con->obtenerValor($consulta);
							if($idCuentaAcceso!="")
							{
								$tipoCuentaAcceso=2;
								break;
							}
						}
						
						if($idCuentaAcceso=="")
						{
							
							$consulta="SELECT * FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fDestinatario["idPersona"];
							$fCuentaAcceso=$con->obtenerPrimeraFilaAsoc($consulta);
	
							$idCuentaAcceso=crearBaseUsuario($fCuentaAcceso["apellidoPaterno"],$fCuentaAcceso["apellidoMaterno"],$fCuentaAcceso["nombre"],$arrMails[0],"1000","","23","","",-1);
							$tipoCuentaAcceso=1;
						}
						
						
						$consulta="UPDATE 7005_relacionFigurasJuridicasSolicitud SET idCuentaAcceso=".$idCuentaAcceso." WHERE idParticipante=".$fDestinatario["idPersona"];
						$con->ejecutarConsulta($consulta);
					}
				}
				else
				{
					$tipoCuentaAcceso=2;
					$idCuentaAcceso=abs($fDestinatario["idPersona"]);
				}
			}
			

			$fechaActual=strtotime(date("Y-m-d H:i:s"));
			$arrParametros["nombreDestinatario"]=$fDestinatario["nombrePersona"];
			$arrParametros["horaEnvio"]=date("H:i",$fechaActual);
			$arrParametros["fechaEnvio"]=convertirFechaLetra(date("Y-m-d",$fechaActual),false,false);
			
			$cuerpoMensajeFinal=$cuerpoMensaje;
			
			
			foreach($arrParametros as $campo=>$valor)
			{
				$cuerpoMensajeFinal=str_replace("[".$campo."]",$valor,$cuerpoMensajeFinal);
			}
			if(($totalDocumentos>0)&&(strpos($cuerpoMensajeFinal,"<tablaDocumentos>")===false))
			{
				$cuerpoMensajeFinal.=$tabla;
			}
			$consulta="select HEX(AES_ENCRYPT('".$idRegistro."', '".bD($versionLatis)."')) as idRegistroEnvio";		
			$idRegistroEnvioEx=$con->obtenerValor($consulta);
			if(strpos($cuerpoMensajeFinal,"<mensajeConfirme>")===false)
				$cuerpoMensajeFinal.="<mensajeConfirme><br><span><b><span style='font-size:12px'>Por favor confirme la recepci&oacute;n del presente mensaje dando click <a href='".$urlSitioHTTPS."modulosEspeciales_SIUGJ/paginasFunciones/setNotifyRecive.php?iM=".$idRegistroEnvioEx."'><span style='color:#F00'>AQUI</span></a></span></b></span></mensajeConfirme>";
			
			if($idCuentaAcceso!=-1)
			{
				$consulta="SELECT COUNT(*) FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$idCuentaAcceso.
							" AND carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
							
				$numReg=$con->obtenerValor($consulta);			
				if($numReg==0)
				{
					$anioExpediente=date("Y",strtotime($fDatosCarpetas["fechaCreacion"]));
					$consulta="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
							cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
							(".$idCuentaAcceso.",".$fDatosCarpetas["idCarpeta"].",'".$fRegistro["carpetaAdministrativa"]."',".
							$fDatosCarpetas["especialidad"].",1,'".date("Y-m-d H:i:s")."','".$fDatosCarpetas["unidadGestion"]."',".$anioExpediente.
							",".$fDestinatario["idPersona"].")";
				
					$con->ejecutarConsulta($consulta);
				}
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(PASSWORD), '".bD($versionLatis)."') as password FROM 800_usuarios WHERE idUsuario=".$idCuentaAcceso;
				
				$fDatosUsuario=$con->obtenerPrimerafila($consulta);
				
				
				$tablaDatosAcceso="<tablaCuenta><table style='border-top-style:solid;border-top-width:1px;border-top-color:#999'>";
				$lblMensage="";
				$consulta="SELECT tituloSistema FROM 903_variablesSistema";
				$tituloSistema=$con->obtenerValor($consulta);
				switch($tipoCuentaAcceso)
				{
					case 1:
						$lblMensage="Se ha creado una cuenta de acceso al ".$tituloSistema.", sus datos de acceso son:";
					break;
					case 2:
						$lblMensage="A continuaci&oacute;n se le recuerdan sus datos de acceso al ".$tituloSistema.":";
					break;
				}
				
				$tablaDatosAcceso.="<tr><td colspan='2'><span style='font-size:12px'>".$lblMensage."</span></td></tr>";
				$tablaDatosAcceso.="<tr><td width='100'><span style='font-size:12px'><b>URL:</b></span></td><td><a href='".$urlSitio."'><span style='font-size:12px'>".$urlSitio."</a></span></td></tr>";
				$tablaDatosAcceso.="<tr><td ><span style='font-size:12px'><b>Usuario:</b></span></td><td><span style='font-size:12px'>".$fDatosUsuario[0]."</span></td></tr>";
				$tablaDatosAcceso.="<tr><td ><span style='font-size:12px'><b>Password:</b></span></td><td><span style='font-size:12px'>".$fDatosUsuario[1]."</span></td></tr>";
				$tablaDatosAcceso.="</table></tablaCuenta>";
				
				$cuerpoMensajeFinal.="<br><br>".$tablaDatosAcceso;
				
			}
			
			$_SESSION["resultadoEnvioCorreo"]="";
			eval('$resultado=@'.$funcionEnvioCorreoElectronico.'($arrDestinatario,$asuntoMensaje,$cuerpoMensajeFinal,"","",$arrArchivos,null,null);');
			if(!$resultado)
			{
				$consulta="UPDATE _665_gPersonasNotificar SET notificado=2,msgError='".cv($_SESSION["resultadoEnvioCorreo"])."' WHERE id__665_gPersonasNotificar=".$fDestinatario["id__665_gPersonasNotificar"];
				

				$con->ejecutarConsulta($consulta);
				cambiarEtapaFormulario($idFormulario,$idRegistro,2.6,"",-1,"NULL","NULL",0);
			}
			else
			{
				$arrCuerpo=explode("<tablaCuenta>",$cuerpoMensajeFinal);
				$consulta="UPDATE _665_tablaDinamica SET fechaEnvio='".date("Y-m-d",$fechaActual)."',horaEnvio='".date("H:i",$fechaActual)."',cuerpoNotificacion='".cv($arrCuerpo[0])."' WHERE id__665_tablaDinamica=".$idRegistro;
				$con->ejecutarConsulta($consulta);
				
				$consulta="UPDATE _665_gPersonasNotificar SET notificado=1 WHERE id__665_gPersonasNotificar=".$fDestinatario["id__665_gPersonasNotificar"];
				$con->ejecutarConsulta($consulta);
				
				$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND 
						idParticipante=".$fDestinatario["idPersona"]." AND idFiguraJuridica=4";
				$numReg=$con->obtenerValor($consulta);
				if($numReg>0)
					registrarTerminosAccion($idFormulario,$idRegistro,3);
					
					
					
				cambiarEtapaFormulario($idFormulario,$idRegistro,3,"",-1,"NULL","NULL",0);
				
			}
			
		}
		
		return true;
		
	}
	
	
	function analizarRutaEsperaNotificacionDemanda($idFormulario,$idRegistro)
	{
		global $con;

		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and etapaActual=10";

		$fBitacora=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fBitacora)
		{
			
			$consulta="SELECT tipoDocumento FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$fBitacora["referencia2"];
			$tipoDocumento=$con->obtenerValor($consulta);
			$numEtapa=11;
			switch($tipoDocumento)
			{
				case 530://Auto de Admisión de Demanda
					$numEtapa=11;
				break;
				case 540://Auto de Reasignación por Impedimento
					$numEtapa=5;
				break;	
				case 541://541	Auto de Reasignación por Falta de Competencia
					$numEtapa=6;
				break;	
				case 542://Auto de Inadmisión
					$numEtapa=4;
				break;	

			}
			
			cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa,"",-1,"NULL","NULL",0);
			
			
		}
		
	}
	
	
	function obtenerInstitucionProcesoJudicialBase($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa="";
		
		if($idFormulario==699)
		{
			$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes,tipoActuacion FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
			$fDatosActuacion=$con->obtenerPrimeraFilaAsoc($consulta);
			$carpetaAdministrativa=$fDatosActuacion["carpetaAdministrativaActuacionesIntervinientes"];
			$tipoActuacion=$fDatosActuacion["tipoActuacion"];
			
			if($tipoActuacion==30)
			{
				$consulta="SELECT idReferencia FROM _917_tablaDinamica WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$idRegistroPaquete=$con->obtenerValor($consulta);
				if($idRegistroPaquete=="")
					$idRegistroPaquete=-1;
				$consulta="SELECT despachoAsignado FROM _990_tablaDinamica WHERE id__990_tablaDinamica=".$idRegistroPaquete;
				$despachoAsignado=$con->obtenerValor($consulta);
				return "'".$despachoAsignado."'";
			}
			
		}
		else
		{
			if($idFormulario==706)
			{
				$consulta="SELECT carpetaAdministrativaContestacionExcepcionPrevia FROM _706_tablaDinamica WHERE id__706_tablaDinamica=".$idRegistro;
				$fDatosActuacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$carpetaAdministrativa=$fDatosActuacion["carpetaAdministrativaContestacionExcepcionPrevia"];
			}
			else
				$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		}

		$consulta="SELECT etapaProcesalActual FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and tipoCarpetaAdministrativa=1";
		$tCarpetaAdministrativa=$con->obtenerValor($consulta);
		if($tCarpetaAdministrativa=="")
		{
			$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			$tCarpetaAdministrativa=$con->obtenerValor($consulta);
			
		}
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and tipoCarpetaAdministrativa=".$tCarpetaAdministrativa." order by idCarpeta desc";
		$institucion=$con->obtenerValor($consulta);
		return "'".$institucion."'";
	}
	
	function copiarDocumentosRegistradosFormularioBase($idFormulario,$idRegistro)
	{
		global $con;


		$nombreTabla=obtenerNombreTabla($idFormulario);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$idFormularioBase=-1;
		$idRegistroBase=-1;
		if($con->existeCampo("iFormulario",$nombreTabla))
		{
			$consulta="SELECT iFormulario,iRegistro FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$idFormularioBase=$fRegistro["iFormulario"];
			$idRegistroBase=$fRegistro["iRegistro"];

		}
		else
		{

			$consulta="SELECT idProcesoPadre,idReferencia FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$idFormularioBase=obtenerFormularioBase($fRegistro["idProcesoPadre"]);
			$idRegistroBase=$fRegistro["idReferencia"];

		}
		
		$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormularioBase." AND idReferencia=".$idRegistroBase;

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT COUNT(*) FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idTipoDocumento=".$fila["idTipoDocumento"];
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				$query[$x]="INSERT INTO 9503_documentosRegistradosProceso(idActividad,idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
							VALUES(".$fila["idActividad"].",".$fila["idTipoDocumento"].",".($fila["idDocumento"]==""?"NULL":$fila["idDocumento"]).",".
							$fila["presentaDocumento"].",".$idFormulario.",".$idRegistro.")";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($query))
		{

			$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormularioBase." AND idReferencia=".$idRegistroBase." and idDocumento is not null";
			
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{

				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fila["idDocumento"],$idFormulario,$idRegistro);
			}
			return true;
		}
	}
	
		
	function obtenerDatosProcesoActuacionReferido($idFormulario,$idRegistro,$campoTablaDestino)
	{
		global $con;
		
		$consulta="SELECT * FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

		$arrDatosDemanda=obtenerIdFormularioDemanda($fRegistro["carpetaAdministrativaActuacionesIntervinientes"]);
		switch($fRegistro["tipoActuacion"])
		{
			/*case 2: //CONTESTACIÓN DE DEMANDA
			case 41:
			case 3: //REGISTRO DE REFORMA DE DEMANDA
			case 4:	//REGISTRO DE ESCRITO DE SUBSANACION DE DEMANDA
			case 6: //REGISTRO DE EXCEPCIONES PREVIAS O DE MÉRITO
			case 17:
			case 18:
			case 19:
			case 20:
			case 11:
			case 22:
			case 25:
			case 26:
			case 37:
			case 12:
			case 42:
			case 43:

				$idProceso=obtenerIdProcesoFormularioBase($arrDatosDemanda["idFormulario"]);
				$idRegistroProceso=$arrDatosDemanda["idRegistro"];

				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso;
					break;
				}
			break;*/
			case 5://CONESTACION DE REFORMA
				$consulta="SELECT * FROM _702_tablaDinamica WHERE carpetaAdministrativaReformaDemanda='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."'";
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(702);
				$idRegistroProceso=$fContestacion["id__702_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 7://CONTESTACION DE EXCEPCIONES A DEMANDA
				$consulta="SELECT * FROM _701_tablaDinamica WHERE carpetaAdministrativalExcepcionPrevia='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."'";
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(701);
				$idRegistroProceso=$fContestacion["id__701_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			
			break;
			case 13://REGISTRO DE ESCRITO DE SUBSANACIÓN DE CONTESTACIÓN DE DEMANDA
				$consulta="SELECT * FROM _707_tablaDinamica WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."' AND promovente=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(707);
				$idRegistroProceso=$fContestacion["id__707_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 14://SUBSANACIÓN DE REFORMA DE DEMANDA
				$consulta="SELECT * FROM _702_tablaDinamica WHERE carpetaAdministrativaReformaDemanda='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."' AND promovente=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(702);
				$idRegistroProceso=$fContestacion["id__702_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			
			break;
			case 15://SUBSANACIÓN DE CONTESTACIÓN DE REFORMA
				$consulta="SELECT * FROM _767_tablaDinamica WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."' AND promovente=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(767);
				$idRegistroProceso=$fContestacion["id__767_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 16://SUBSANACIÓN DE CONTESTACIÓN DE EXCEPCIONES PREVIAS
				$consulta="SELECT * FROM _706_tablaDinamica WHERE carpetaAdministrativaContestacionExcepcionPrevia='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."' AND promovente=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(706);
				$idRegistroProceso=$fContestacion["id__706_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 21://REGISTRO DE INFORME DE ACCIONANTE
				$consulta="SELECT * FROM _899_tablaDinamica t  WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].
						"' AND providenciaAplicar in(5,37)";
				
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(899);
				$idRegistroProceso=$fContestacion["id__899_tablaDinamica"];
				if(!$fContestacion)
				{
					$idProceso=-1;
					$idRegistroProceso=-1;
				}
				
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 22://IMPUGNACIÓN DE FALLO
				$consulta="SELECT * FROM _899_tablaDinamica t WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].
						"' AND providenciaAplicar=8";
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);

				$idProceso=obtenerIdProcesoFormularioBase(899);
				$idRegistroProceso=$fContestacion["id__899_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 23://REGISTRO DE INFORME DE IMPUGNACIÓN
				$consulta="SELECT * FROM _899_tablaDinamica t,_899_chkPartesJuridicasAplica c WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].
						"' AND providenciaAplicar=9 AND c.idPadre=t.id__899_tablaDinamica and c.idOpcion=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(899);
				$idRegistroProceso=$fContestacion["id__899_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 24://REGISTRO DE PRUEBAS DE IMPUGNACIÓN
				$consulta="SELECT * FROM _899_tablaDinamica t,_899_chkPartesJuridicasAplica c WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].
						"' AND providenciaAplicar=10 AND c.idPadre=t.id__899_tablaDinamica and c.idOpcion=".$fRegistro["promovente"];
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$idProceso=obtenerIdProcesoFormularioBase(899);
				$idRegistroProceso=$fContestacion["id__899_tablaDinamica"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			case 27:
			case 28:
			case 29:
				$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."' order by idCarpeta desc";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase($fRegistro["idFormulario"]);
				$idRegistroProceso=$fRegistro["idRegistro"];
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
				
			break;
			case 30:
				$consulta="SELECT * FROM _917_tablaDinamica t WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"]."'";
						
				$fContestacion=$con->obtenerPrimeraFilaAsoc($consulta);
				$idProceso=obtenerIdProcesoFormularioBase(917);
				if($idProceso=="")
					$idProceso=-1;
				$idRegistroProceso=$fContestacion["id__917_tablaDinamica"];
				if($idRegistroProceso=="")
					$idRegistroProceso=-1;
				switch($campoTablaDestino)
				{
					case "idProcesoPadre":					
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
			
		
			default:
			
				$idProceso=obtenerIdProcesoFormularioBase($arrDatosDemanda["idFormulario"]);
				$idRegistroProceso=$arrDatosDemanda["idRegistro"];

				switch($campoTablaDestino)
				{
					case "idProcesoPadre":
						return $idProceso==""?-1:$idProceso;
					break;
					case "idReferencia":
						return $idRegistroProceso==""?-1:$idRegistroProceso;
					break;
				}
			break;
		}
		
		
		
		
	}
	
	
	function seleccionRutaContestacionDemanda_205($idFormulario,$idRegistro)
	{
		global $con;
		
		$numEtapa=0;
		
		$carpetaAdministrativa="";
		switch($idFormulario)
		{
			case 754:
				$consulta="SELECT carpetaAdministrativaSubsanacion FROM _754_tablaDinamica WHERE id__754_tablaDinamica=".$idRegistro;
				$carpetaAdministrativa=$con->obtenerValor($consulta);
			break;
			default:
				$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			break;
		}
		
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud r,7006_carpetasAdministrativas c
				WHERE c.carpetaAdministrativa='".$carpetaAdministrativa."' AND r.idActividad=c.idActividad AND r.idFiguraJuridica=4";
		$numDemandados=$con->obtenerValor($consulta);

		
		if($numDemandados==1)
			$numEtapa=2.2;
		else
			$numEtapa=2.1;
		
		cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa,"",-1,"NULL","NULL",0);
		
	}
	
	
	function ocutarSiDemandaVerbal($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT COUNT(*) FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro." AND tipoProceso=3";
		$numReg=$con->obtenerValor($consulta);
		
		return $numReg>0?0:1;	
	}
	
	
	function analisisRutaRecepcionDemandaVentanilla($idFormulario,$idRegistro)
	{
		global $con;
		$numReg=0;
		$consulta="SELECT tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$tipoProceso=$con->obtenerValor($consulta);
		switch($tipoProceso)
		{
			case 3:
				$numEtapa=2.06;
			break;
			case 4:
				$numEtapa=2.3;
			break;
			default:	
				$numEtapa=2.1;
			break;
		}
		
		cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa,"",-1,"NULL","NULL",0);
		
		
	}
	
	
	function cuestionarioAudienciaLlenado($idRegistro)
	{
		echo "window.parent.recargarCuestionario(".$idRegistro.");return;";
	}
	
	
	function seleccionRutaContestacionReformaDemanda_200($idFormulario,$idRegistro)
	{
		global $con;
		
		$numEtapa=0;
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud r,7006_carpetasAdministrativas c
				WHERE c.carpetaAdministrativa='".$carpetaAdministrativa."' AND r.idActividad=c.idActividad AND r.idFiguraJuridica=4";
		$numDemandados=$con->obtenerValor($consulta);

		
		if($numDemandados==1)
			$numEtapa=2.5;
		else
			$numEtapa=2;
		
		cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa,"",-1,"NULL","NULL",0);
		
	}
	
	
	
	function obtenerDatosContestacionDemandaAuto($idFormulario,$idRegistro,$campoTablaDestino)
	{
		global $con;
		$arrInformacion=array();
		if($idFormulario==707)
		{
			$consulta="SELECT * FROM _846_tablaDinamica WHERE idReferencia=".$idRegistro;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			if($fRegistro["existenExcepcionesPrevias"]==1)
			{
				$arrInformacion["tipoDocumento"]=571;
				$arrInformacion["tituloAuto"]='"Auto para Correr Traslado de Excepciones"';
			}
			else
			{
				$arrInformacion["tipoDocumento"]=546;
				$arrInformacion["tituloAuto"]='"Auto de Aceptacion de Contestación de Demanda"';
			}
		}
		return $arrInformacion[$campoTablaDestino];
	}
	
	function esDemandaSinMedicaCautelar($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT medidaProvisional FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$medidaCautelar=$con->obtenerValor($consulta);
		return $medidaCautelar==1?0:1;
	
	}
	
	function esDemandaConMedicaCautelar($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT medidaProvisional FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

		$medidaCautelar=$con->obtenerValor($consulta);
		return $medidaCautelar;
	
	}
	
	
	function cambiarEtapaDemandaSinMedidaCautelar($idFormulario,$idRegistro)
	{
		global $con;
		if(esDemandaSinMedicaCautelar($idFormulario,$idRegistro)==0)
		{
			return cambiarEtapaFormulario($idFormulario,$idRegistro,3.2,"",-1,"NULL","NULL",0);
		}
		return true;
	}
	
	
	function esAutoRequiereNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT seNotificaAuto FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
		$seNotificaAuto=$con->obtenerValor($consulta);
		return (($seNotificaAuto==1)||($seNotificaAuto==10))?1:0;
	}
	
	function esAutoRequiereNotificacionAutomatica($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT seNotificaAuto FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
		$seNotificaAuto=$con->obtenerValor($consulta);
		return (($seNotificaAuto==2)||($seNotificaAuto==10))?1:0;
	}
		
	function esAutoDecretaMedidaCautelar($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return $tipoDocumento==572?1:0;
	}
		
	function obtenerDatosProcesoOriginalReferido($idFormulario,$idRegistro,$campoTablaDestino)
	{
		global $con;
		
		$consulta="";
		
		
		if($con->existeCampo("carpetaAdministrativaActuacionesIntervinientes","_".$idFormulario."_tablaDinamica"))
		{
			$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		}
		else
		{
			$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		}
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nombreTabla=obtenerNombreTabla($fRegistro["idFormulario"]);
		
		$consulta="SELECT * FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fRegistro["idRegistro"];
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		return "'".$fRegistroBase[$campoTablaDestino]."'";
		
		
		
		
	}
		
	function copiarDocumentosActuacionEjecucionSentencia($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT idProcesoPadre,idReferencia FROM _698_tablaDinamica WHERE id__698_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

		$iFormulario=obtenerFormularioBase($fRegistro["idProcesoPadre"]);
		$iRegistro=$fRegistro["idReferencia"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$iFormulario." AND idReferencia=".$iRegistro;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT COUNT(*) FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idTipoDocumento=".$fila["idTipoDocumento"];
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				$query[$x]="INSERT INTO 9503_documentosRegistradosProceso(idActividad,idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
							VALUES(-1,".$fila["idTipoDocumento"].",".($fila["idDocumento"]==""?"NULL":$fila["idDocumento"]).",".
							$fila["presentaDocumento"].",".$idFormulario.",".$idRegistro.")";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		
		return $con->ejecutarBloque($query);
		
	}
		
	function copiarDerechosVulneradosTutela($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT idReferencia FROM _847_tablaDinamica WHERE id__847_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="INSERT INTO _847_gridDerechoVulnerableRegistroTutela(idReferencia,derechoVulnerableRegistroTutela)
				SELECT '".$idRegistro."' as idReferencia,derechoVulnerableRegistroTutela FROM _717_gridDerechoVulnerableRegistroTutela WHERE idReferencia=".$idReferencia;
		return $con->ejecutarConsulta($consulta);
	}
	
	function registrarInformacionNotificacionAutomatica($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT idProcesoPadre,idReferencia,tipoNotificacion,figuraNotifica,carpetaAdministrativa,tipoDocumentosAdjunta,idCategoriaDocumento,
					idTipoDocumentoPrincipal,idUsuarioNotifica 
					FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$idProcesoPadre=$fNotificacion["idProcesoPadre"];

		if($fNotificacion["idTipoDocumentoPrincipal"]=="")
			$fNotificacion["idTipoDocumentoPrincipal"]=-1;
		

		if(($idProcesoPadre!=283)&&($idProcesoPadre!=323)&&(($fNotificacion["figuraNotifica"]=="")||($fNotificacion["figuraNotifica"]=="N/E")))
		{
			return true;
		}
		$arrPersonas=array();
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$iFormulario=obtenerFormularioBase($idProcesoPadre);
		$nombreTabla=obtenerNombreTabla($iFormulario);
		$buscarPersonas=true;
		$figuraNotifica="";
		$idUsuarioNotifica=$fNotificacion["idUsuarioNotifica"];
		if(($fNotificacion["figuraNotifica"]!="")&&($fNotificacion["figuraNotifica"]!="N/E"))
		{
			$figuraNotifica=$fNotificacion["figuraNotifica"];
		}
		else
		{
			
			if($iFormulario==899)
			{

				$consulta="SELECT idOpcion FROM _899_chkPartesJuridicasAplica WHERE idPadre=".$fNotificacion["idReferencia"];

				$rPartes=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($rPartes))
				{
					array_push($arrPersonas,$fila["idOpcion"]);
				}
				
				if(count($arrPersonas)>0)
				{
					$buscarPersonas=false;
				}
				else
				{
					$figuraNotifica=4;
				}
				
			}
			else
			{

				$consulta="SELECT * FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fNotificacion["idReferencia"];
				$fAuto=$con->obtenerPrimeraFilaAsoc($consulta);
				$figuraNotifica=$fAuto["figuraNotifica"];
				if(($figuraNotifica=="")&&($idFormulario==665))
					$figuraNotifica=4;
			}
		}
		
		
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fNotificacion["carpetaAdministrativa"]."'";
		$idActividad=$con->obtenerValor($consulta);		
		$arrPersonasBusqueda=array();
		$listaPersonas="";
		
		if(($idUsuarioNotifica!="")&&($idUsuarioNotifica!=-1))
		{
			$arrPersonasBusqueda[$idUsuarioNotifica*-1]=1;
			$buscarPersonas=false;
		}
		
		if($figuraNotifica==4)//Definidos en plantilla
		{
			$buscarPersonas=false;
			$consulta="SELECT COUNT(*) FROM _10_sujetosProcesalesNotifica WHERE idPadre=".$fNotificacion["idTipoDocumentoPrincipal"]." AND idOpcion='A'";
			$demandante=$con->obtenerValor($consulta);
			

			if($demandante>0)
			{
				$aAux=obtenerPersonasNotificaNaturalezaActor($idActividad);
				
				foreach($aAux as $p)
				{
					$arrPersonasBusqueda[$p]=1;
				}
			}
			
			
			$consulta="SELECT COUNT(*) FROM _10_sujetosProcesalesNotifica WHERE idPadre=".$fNotificacion["idTipoDocumentoPrincipal"]." AND idOpcion='D'";
			$demandado=$con->obtenerValor($consulta);

			if($demandado>0)
			{
				$aAux=obtenerPersonasNotificaNaturalezaDemandante($idActividad);
				
				foreach($aAux as $p)
				{
					$arrPersonasBusqueda[$p]=1;
				}
			}
			
			$consulta="SELECT COUNT(*) FROM _10_sujetosProcesalesNotifica WHERE idPadre=".$fNotificacion["idTipoDocumentoPrincipal"]." AND idOpcion='V'";
			$viculado=$con->obtenerValor($consulta);
			
			if($viculado>0)
			{
				$aAux=obtenerPersonasNotificaNaturalezaVinculado($idActividad);
				
				foreach($aAux as $p)
				{
					$arrPersonasBusqueda[$p]=1;
				}
			}
			
		        	
			
			$consulta="SELECT rolNotifica FROM _10_gRolesNotificar WHERE idReferencia=".$fNotificacion["idTipoDocumentoPrincipal"];
			
			$rNotifica=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($rNotifica))
			{
				$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE codigoRol='".$fila["rolNotifica"]."_0'";
				$rDestinatario=$con->obtenerFilas($consulta);
				while($fDestinatario=$con->fetchAssoc($rDestinatario))
				{
					
					
					$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idCuentaAcceso=".($fDestinatario["idUsuario"]);

					$idParticipante=$con->obtenerValor($consulta);
					
					if(($idParticipante!="")&&($idParticipante!="-1"))
					{
						$arrPersonasBusqueda[$idParticipante]=1;
						$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$idParticipante;

						$numRegistros=$con->obtenerValor($consulta);
						if($numRegistros==0)
						{
							$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion,idCuentaAcceso,etapaProcesal,situacionProcesal,cuentaAccesoGenerica)
										values(".$idActividad.",".$idParticipante.",11,1,".($fDestinatario["idUsuario"]).",1,1,0)";
							$x++;
						}
					}
					else
					{
						$arrPersonasBusqueda[$fDestinatario["idUsuario"]*-1]=1;
					}
					
					
					
				}
			}
			
			foreach($arrPersonasBusqueda as $idPersonas=>$resto)
			{
				array_push($arrPersonas,$idPersonas);
			}
		}
		
		if($buscarPersonas)
		{
			switch($figuraNotifica)
			{
				case 1://Actor
				
					$arrPersonasBusqueda=obtenerPersonasNotificaNaturalezaActor($idActividad);
				break;
				case 2: //Demandados
					$arrPersonasBusqueda=obtenerPersonasNotificaNaturalezaDemandante($idActividad);
				break;
				case 3: //Todos
					$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad;
					$rPartes=$con->obtenerFilas($consulta);
					while($fila=$con->fetchAssoc($rPartes))
					{
						array_push($arrPersonasBusqueda,$fila["idParticipante"]);
					}
				break;

			}
			
			
			foreach($arrPersonasBusqueda as $p)
			{
				array_push($arrPersonas,$p);
			}
		
		}
		

		
	
		
		foreach($arrPersonas as $p)
		{
			if($p>0)
			{	
				$cadParticipante=obtenerDatosParticipante($p);
				$oParticipante=json_decode($cadParticipante);

				foreach($oParticipante->correos as $c)
				{
					
					$query[$x]="INSERT INTO _665_gPersonasNotificar(idReferencia,tipoPersona,nombrePersona,email,idPersona,notificado)
								VALUES(".$idRegistro.",".$oParticipante->tipoPersona.",'".cv($oParticipante->nombre)."','".cv($c->mail)."',".$p.",0)";
					$x++;			
				}
			}
			else
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".abs($p);
				$resMail=$con->obtenerFilas($consulta);
				while($filaMail=$con->fetchAssoc($resMail))
				{
					$query[$x]="INSERT INTO _665_gPersonasNotificar(idReferencia,tipoPersona,nombrePersona,email,idPersona,notificado)
								VALUES(".$idRegistro.",2,'".cv(obtenerNombreUsuario(abs($p)))."','".cv($filaMail["Mail"])."',".$p.",0)";
					$x++;
				}
			}
		}
		$cuerpoNotificacion=generarCuerpoNotificacion($fNotificacion["tipoNotificacion"],$fNotificacion["carpetaAdministrativa"],$idFormulario,$idRegistro);
		$query[$x]="UPDATE _665_tablaDinamica SET cuerpoNotificacion='".cv($cuerpoNotificacion)."' WHERE id__665_tablaDinamica=".$idRegistro;
		$x++;
		$query[$x]="delete from _665_gridDocumentosNotificar where idReferencia=".$idRegistro;
		$x++;
		$query[$x]="INSERT INTO _665_gridDocumentosNotificar(idReferencia,idDocumento,nombreDocumento,tamanoDoc,categoriaDocumento)
					SELECT '".$idRegistro."' AS idReferencia,r.idDocumento,a.nomArchivoOriginal,tamano,categoriaDocumentos FROM 9074_documentosRegistrosProceso r,908_archivos a WHERE 
					a.idArchivo=r.idDocumento AND idFormulario=".$iFormulario." AND idRegistro=".$fNotificacion["idReferencia"];
		
		switch($fNotificacion["tipoDocumentosAdjunta"])
		{
			case "1":
			case "2":
				$query[$x].=" and r.tipoDocumento=".$fNotificacion["tipoDocumentosAdjunta"];
			break;
		}


		if(($fNotificacion["idCategoriaDocumento"]!="")&&($fNotificacion["idCategoriaDocumento"]!="N/E"))
		{
			$query[$x].=" and a.categoriaDocumentos in(".$fNotificacion["idCategoriaDocumento"].")";
		}
		$x++;
		$query[$x]="commit";
		$x++;

		if($con->ejecutarBloque($query))
		{
			return cambiarEtapaFormulario($idFormulario,$idRegistro,1.5,"",-1,"NULL","NULL",0);
		}
	}
	
	
	
	function obtenerPersonasNotificaNaturalezaActor($idActividad)
	{
		global $con;
		$arrPersonasAux=array();
		$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A')";

		$rPartes=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($rPartes))
		{

			array_push($arrPersonasAux,$fila["idParticipante"]);
			$consulta="SELECT idParticipante FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idActorRelacionado= ".$fila["idRelacion"]." and situacion=1";
			$rPartesAux=$con->obtenerFilas($consulta);
			while($filaAux=$con->fetchAssoc($rPartesAux))
			{
				
				$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$filaAux["idParticipante"];
				$filaAux["idParticipante"]=$con->obtenerValor($consulta);
				array_push($arrPersonasAux,$filaAux["idParticipante"]);
			}
		}
		
		return $arrPersonasAux;
	}
	function obtenerPersonasNotificaNaturalezaDemandante($idActividad)
	{
		global $con;
		$arrPersonasAux=array();
		$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
		$rPartes=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($rPartes))
		{
			array_push($arrPersonasAux,$fila["idParticipante"]);
			$consulta="SELECT idParticipante FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idActorRelacionado= ".$fila["idRelacion"]." and situacion=1";
			$rPartesAux=$con->obtenerFilas($consulta);
			while($filaAux=$con->fetchAssoc($rPartesAux))
			{
				
				$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$filaAux["idParticipante"];
				$filaAux["idParticipante"]=$con->obtenerValor($consulta);
				array_push($arrPersonasAux,$filaAux["idParticipante"]);
			}
		}
		
		return $arrPersonasAux;
	}
	
	
	function obtenerPersonasNotificaNaturalezaVinculado($idActividad)
	{
		global $con;
		$arrPersonasAux=array();
		$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='V')";
		$rPartes=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($rPartes))
		{
			array_push($arrPersonasAux,$fila["idParticipante"]);
			$consulta="SELECT idParticipante FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idActorRelacionado= ".$fila["idRelacion"]." and situacion=1";
			$rPartesAux=$con->obtenerFilas($consulta);
			while($filaAux=$con->fetchAssoc($rPartesAux))
			{
				
				$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$filaAux["idParticipante"];
				$filaAux["idParticipante"]=$con->obtenerValor($consulta);
				array_push($arrPersonasAux,$filaAux["idParticipante"]);
			}
		}
		
		return $arrPersonasAux;
	}
	
	function generarCuerpoNotificacion($tN,$cA,$idFormulario=-1,$idRegistro=-1)
	{
		global $con;
		
		
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$tN;
		$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT * FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$fMensajeEnvio=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT cuerpoMensaje FROM 2013_cuerposMensajes WHERE idMensaje=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		$consulta="SELECT o.unidad,c.idActividad,c.tipoProceso FROM 7006_carpetasAdministrativas c,817_organigrama o WHERE c.carpetaAdministrativa='".$cA.
				"' AND o.codigoUnidad=c.unidadGestion ";

		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$arrParametros["codigoUnicoProceso"]=$cA;
		$arrParametros["comentariosAdicionales"]=$fNotificacion["comentarioCuerpo"]==""?"(Sin Comentarios)":$fNotificacion["comentarioCuerpo"];
		$idActividad=$fDatosCarpetas["idActividad"];
		
		if($fNotificacion["idProcesoPadre"]==331)
		{
			$consulta="SELECT carpetaAdministrativa2aInstancia FROM _952_tablaDinamica WHERE id__952_tablaDinamica=".$fNotificacion["idReferencia"];
			$arrParametros["codigoUnicoProceso2daInstancia"]=$con->obtenerValor($consulta);
		}
		
		
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demantante=="")
				$demantante=$nombre;
			else
				$demantante.=", ".$nombre;
		}
		
		$demandados="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}
		
		if($idActividad==-1)
		{
			$demantante="------";
			$demandados="------";
		}
		
		$arrParametros["etDemandante"]="DEMANDANTE";
		$arrParametros["etDemandado"]="DEMANDADO";
		$arrParametros["demandante"]=$demantante;
		$arrParametros["demandado"]=$demandados;
		if($fDatosCarpetas["tipoProceso"]==6)
		{
			$arrParametros["etDemandante"]="ACCIONANTE";
			$arrParametros["etDemandado"]="ACCIONADO";
		}
		
		foreach($arrParametros as $campo=>$valor)
		{
			$cuerpoMensaje=str_replace("[".$campo."]",$valor,$cuerpoMensaje);
		}
		
		return $cuerpoMensaje;
	}
	
	function obtenerDatosParticipante($idParticipante)
	{
		global $con;
		$tblMail="7025_correosElectronico";
		$tblTelefono="7025_telefonos";
		$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
					yCalle,otrasReferencias,idRegistro  FROM 7025_datosContactoParticipante 
					WHERE idParticipante=".$idParticipante." order by fechaCreacion desc";
		$fila=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fila)
		{
			$tblMail="_48_correosElectronico";
			$tblTelefono="_48_telefonos";
			$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
						yCalle,otrasReferencias,id__48_tablaDinamica as idRegistro FROM _48_tablaDinamica WHERE idReferencia=".$idParticipante;	
			
			$fila=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if(!$fila)
			{
				$consulta="SELECT '' as calle,'' as  noExt,'' as noInterior,'' as colonia,'' as codigoPostal,-1 as entidadFederativa,-1 as municipio,'' as localidad,'' as entreCalle,
						'' as yCalle,'' as  otrasReferencias,'-1' as idRegistro ";	
			
				$fila=$con->obtenerPrimeraFilaAsoc($consulta);
			
			}
		}
		
		$arrCorreos="";
		$consulta="SELECT correo FROM ".$tblMail." WHERE idReferencia=".$fila["idRegistro"];
		$res=$con->obtenerFilas($consulta);
		while($f=$con->fetchRow($res))
		{
			$oM='{"mail":"'.$f[0].'"}';
			if($arrCorreos=="")
				$arrCorreos=$oM;
			else
				$arrCorreos.=",".$oM;
		}
		
		$arrTelefonos="";
		$consulta="SELECT tipoTelefono,lada,numero,extension FROM ".$tblTelefono." WHERE idReferencia=".$fila["idRegistro"];
		$res=$con->obtenerFilas($consulta);
		while($f=$con->fetchRow($res))
		{
			$oM='{"tipoTelefono":"'.$f[0].'","lada":"'.$f[1].'","numero":"'.$f[2].'","extension":"'.$f[3].'"}';
			if($arrTelefonos=="")
				$arrTelefonos=$oM;
			else
				$arrTelefonos.=",".$oM;
		}
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fila["entidadFederativa"]."'";
		$lblEstado=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fila["municipio"]."'";
		$lblMunicipio=$con->obtenerValor($consulta);
		
		$lblDireccion=$fila["calle"];
		
		if($fila["noExt"]!="")
		{
			if($lblDireccion!="")
				$lblDireccion.=" #".$fila["noExt"];
			else
				$lblDireccion="#".$fila["noExt"];
		}
		
		if($fila["noInterior"]!="")
		{
			if($lblDireccion!="")
				$lblDireccion.=" Int. ".$fila["noInterior"];
			else
				$lblDireccion="Int. ".$fila["noInterior"];
		}
		
		if($fila["colonia"]!="")
		{
			if($lblDireccion!="")
				$lblDireccion.=" Colonia ".$fila["colonia"];
			else
				$lblDireccion="Colonia ".$fila["colonia"];
		}
		
		
		if($fila["codigoPostal"]!="")
		{
			if($lblDireccion!="")
				$lblDireccion.=" C.P. ".$fila["codigoPostal"];
			else
				$lblDireccion="C.P. ".$fila["codigoPostal"];
		}
		
		if($fila["localidad"]!="")
		{
			if($lblDireccion!="")
				$lblDireccion.=". ".$fila["localidad"];
			else
				$lblDireccion=$fila["localidad"];
		}
		
		if($lblMunicipio!="")
		{
			if($fila["localidad"]!="")
				$lblDireccion.=", ".$lblMunicipio;
			else
			{
				if($lblDireccion!="")
					$lblDireccion.=". ".$lblMunicipio;
				else
					$lblDireccion=$lblMunicipio;
			}
		}
		
		if($lblEstado!="")
		{
			if(($fila["localidad"]!="")||($lblMunicipio!=""))
				$lblDireccion.=", ".$lblEstado;
			else
			{
				if($lblDireccion!="")
					$lblDireccion.=". ".$lblEstado;
				else
					$lblDireccion=$lblEstado;
			}
		}
		
		$consulta="SELECT apellidoPaterno,apellidoMaterno,nombre,tipoPersona FROM _47_tablaDinamica WHERE id__47_tablaDinamica='".$idParticipante."'";
		$res=$con->obtenerPrimeraFila($consulta);
		$nombre=$res[2]." ".$res[0]." ".$res[1];
		
		
		$obj='{"nombre":"'.cv($nombre).'","tipoPersona":"'.$res[3].'","calle":"'.cv($fila["calle"]).'","noExt":"'.cv($fila["noExt"]).'","noInt":"'.cv($fila["noInterior"]).'","colonia":"'.cv($fila["colonia"]).
			'","cp":"'.$fila["codigoPostal"].'","estado":"'.($fila["entidadFederativa"]==-1?"":$fila["entidadFederativa"]).'","lblEstado":"'.$lblEstado.'","municipio":"'.cv($fila["municipio"]=="-1"?"":$fila["municipio"]).
			'","lblMunicipio":"'.$lblMunicipio.'","localidad":"'.cv($fila["localidad"]).'","entreCalle":"'.cv($fila["entreCalle"]).'","yCalle":"'.cv($fila["yCalle"]).
			'","referencias":"'.cv($fila["otrasReferencias"]).'","telefonos":['.$arrTelefonos.'],"correos":['.$arrCorreos.'],"lblDireccion":"'.cv($lblDireccion).'"}';
	
		return $obj;
	}
	
	function existeAutoMedidaCautelarProvisional($idFormulario,$idRegistro)
	{
		global $con;
		$cAdminitrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);

		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa con,908_archivos a WHERE 
				con.carpetaAdministrativa='".$cAdminitrativa."' AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
				AND a.categoriaDocumentos IN(66,63)";
	
		$numReg=$con->obtenerValor($consulta);
		
		return $numReg>1?1:0;
		
	}
	
	function noExisteAutoMedidaCautelarProvisional($idFormulario,$idRegistro)
	{
		global $con;
		$cAdminitrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);

		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa con,908_archivos a WHERE 
				con.carpetaAdministrativa='".$cAdminitrativa."' AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
				AND a.categoriaDocumentos IN(66,63)";
	
		$numReg=$con->obtenerValor($consulta);
		
		return $numReg==0?1:0;
		
	}
	
	function esAutoAutorizaRetiroTutela($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return (($tipoDocumento==585) || ($tipoDocumento==586))?1:0;
	}
	
	function esAutoAutorizaRetiroDemanda($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return (($tipoDocumento==587) || ($tipoDocumento==588))?1:0;
	}
	
	
	function seNotificaInmediatamenteAuto($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;

		$providenciaAplicar=$con->obtenerValor($consulta);
		$consulta="SELECT tipoNotificacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
		$tipoNotificacion=$con->obtenerValor($consulta);
		
		return $tipoNotificacion==2?1:0;
	}
	
	function seNotificaAutoMedianteOrdenNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;

		$providenciaAplicar=$con->obtenerValor($consulta);
		$consulta="SELECT tipoNotificacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
		$tipoNotificacion=$con->obtenerValor($consulta);
		
		return $tipoNotificacion==1?1:0;
	}
	
	
	
	function registrarInformacionNotificacionAutomaticaProvidenciasJuez($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tNotificacion,carpetaAdministrativa FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
		$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrPersonas=array();
		$x=0;
		$query[$x]="begin";
		$x++;
		
		
		
		
		$listaPersonas="";

		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fNotificacion["carpetaAdministrativa"]."'";
		$idActividad=$con->obtenerValor($consulta);
		
		switch($fNotificacion["tNotificacion"])
		{
			case 1://Actor
			
				$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A')";
				$rPartes=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($rPartes))
				{
					array_push($arrPersonas,$fila["idParticipante"]);
					$consulta="SELECT idParticipante FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idActorRelacionado= ".$fila["idParticipante"];
					$rPartesAux=$con->obtenerFilas($consulta);
					while($filaAux=$con->fetchAssoc($rPartesAux))
					{
						array_push($arrPersonas,$filaAux["idParticipante"]);
					}
				}
			break;
			case 2: //Demandados
				$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
				$rPartes=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($rPartes))
				{
					array_push($arrPersonas,$fila["idParticipante"]);
					$consulta="SELECT idParticipante FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idActorRelacionado= ".$fila["idParticipante"];
					$rPartesAux=$con->obtenerFilas($consulta);
					while($filaAux=$con->fetchAssoc($rPartesAux))
					{
						array_push($arrPersonas,$filaAux["idParticipante"]);
					}
				}
			break;
			case 3: //Todos
				$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad;
				$rPartes=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($rPartes))
				{
					array_push($arrPersonas,$fila["idParticipante"]);
				}
			break;
		}
		
		foreach($arrPersonas as $p)
		{
			$query[$x]="INSERT INTO _899_chkPartesJuridicasAplica(idPadre,idOpcion)VALUES(".$idRegistro.",".$p.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		return $con->ejecutarBloque($query);
		
	}
	
	
	function obtenerPromoventeProcesoPadre($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT idProcesoPadre,idReferencia FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$iFormulario=obtenerFormularioBase($fRegistro["idProcesoPadre"]);
		$iRegistro=$fRegistro["idReferencia"];
		
		$nombreTabla=obtenerNombreTabla($iFormulario);
		
		$consulta="SELECT promovente FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$iRegistro;
		$promovente=$con->obtenerValor($consulta);
		
		
		return $promovente;
	}
	
	function esAutoAceptacionApelacionDespacho($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return $tipoDocumento==534?1:0;
	}
	
	function obtenerTitularPuestoV2($idFormulario,$idRegistro,$actorDestinatario)
	{
		global $con;
		global $tipoMateria;
		$carpetaAdministrativa="";
		$nombreTablaBase="_".$idFormulario."_tablaDinamica";
		
		$continuar=true;
		$unidadGestion="";
	
		
		$consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

		$unidadGestion=$con->obtenerValor($consulta);
		$rolActor=obtenerTituloRol($actorDestinatario);

		$arrDestinatario=array();
		$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
					r.codigoRol='".$actorDestinatario."' AND ad.Institucion='".$unidadGestion."'";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$nombreUsuario=obtenerNombreUsuario($fila[0])." (".$rolActor.")";
			$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}

		
		
		return $arrDestinatario;
	}
	
	
	function actualizarFechaEnvioCorteConstitucional($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _917_tablaDinamica WHERE id__917_tablaDinamica=".$idRegistro;
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if(($fRegistroBase["folioCorteConstitucional"]!="")&&($fRegistroBase["folioCorteConstitucional"]!="N/E"))
		{
			return true;
		}
		
		$cveDespacho="100000010003";
		$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoTutelaCorteConstitucional($cveDespacho,"2021",30,$idFormulario,$idRegistro);	
		$carpetaAdministrativa=$arrCodigoUnico[0];
		
		$fechaCarpetaJudicial=date("Y-m-d H:i:s");
		
		
		$query="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistroBase["carpetaAdministrativa"]."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($query);
		$idActividad=$fRegistro["idActividad"];
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
						VALUES('".$carpetaAdministrativa."','".$fechaCarpetaJudicial."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',1,".$fRegistro["idActividad"].",'".$fRegistroBase["carpetaAdministrativa"]."',30,'".$cveDespacho."',".
						($fRegistro["especialidad"]==""?"NULL":$fRegistro["especialidad"]).",".
						($fRegistro["tipoProceso"]==""?"NULL":$fRegistro["tipoProceso"]).",".($fRegistro["claseProceso"]==""?"NULL":$fRegistro["claseProceso"]).
						",".($fRegistro["subclaseProceso"]==""?"NULL":$fRegistro["subclaseProceso"]).
						",".($fRegistro["tema"]==""?"NULL":$fRegistro["tema"]).",".($fRegistro["subtema"]==""?"NULL":$fRegistro["subtema"]).")";
		$x++;
		
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		
		$consulta="UPDATE _917_tablaDinamica SET fechaEnvioCorteConstitucional='".date("Y-m-d H:i:s")."',folioCorteConstitucional='".$carpetaAdministrativa."' WHERE id__917_tablaDinamica=".$idRegistro;
		return $con->ejecutarConsulta($consulta);
	}
	
	
	function obtenerSiguienteCodigoUnicoProcesoTutelaCorteConstitucional($idUnidadGestion,$anio,$tipoCarpeta,$idFormulario,$idRegistro)
	{
		global $con;
		
		$agregarSecuencia=false;
		$query="select folioActual FROM 7004_seriesUnidadesGestion WHERE idUnidadGestion='".$idUnidadGestion.
					"' AND anio=".$anio." and tipoDelito='".$tipoCarpeta."'";
		$folioActual=$con->obtenerValor($query);
		
		if($folioActual=="")
		{
			$folioActual=1;
			$agregarSecuencia=true;	
		}
		else
		{
			$folioActual++;
		}
					
		
		
		//-------
		$folioCorreccion=$folioActual-10;
		if($folioCorreccion<1)
			$folioCorreccion=1;
		$query="SELECT claveRegistro,claveUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$idUnidadGestion."'";
		$fRegistroUnidad=$con->obtenerPrimeraFila($query);
		$cveUnidadGestion=$fRegistroUnidad[0];
		$cvAdscripcion=$fRegistroUnidad[1];
		$formatoCarpeta= "T.[folioCarpeta]";
		
		
		
		
		$carpetaAdministrativa=str_replace("[folioCarpeta]",str_replace(",",".",number_format($folioCorreccion,0)),$formatoCarpeta);
		while(existeCarpetaAdministrativa($carpetaAdministrativa,""))
		{
			$folioCorreccion++;	
			$carpetaAdministrativa=str_replace("[folioCarpeta]",str_replace(",",".",number_format($folioCorreccion,0)),$formatoCarpeta);
		}
		
		
		if($folioCorreccion<$folioActual)
		{
			registrarRecuperacionCodigoUnico($idUnidadGestion,$carpetaAdministrativa,'');
		}
		$folioActual=$folioCorreccion;
		///
		if($agregarSecuencia)
		{
			$query="INSERT INTO 7004_seriesUnidadesGestion(idUnidadGestion,anio,folioActual,tipoDelito) VALUES('".$idUnidadGestion.
					"',".$anio.",".$folioActual.",'".$tipoCarpeta."')";
		}
		else
		{
			$query="update 7004_seriesUnidadesGestion set folioActual=".$folioActual." where idUnidadGestion='".$idUnidadGestion.
					"' and anio=".$anio." and tipoDelito='".$tipoCarpeta."'";
		}	
		
		
		if($con->ejecutarConsulta($query))
		{
			$arrResultado[0]=$carpetaAdministrativa;
			$arrResultado[1]=$folioActual;
			return $arrResultado;
		}
		
		
		
		
	}
	
	
	function sendMensajeEnvioWebMailServer($arrDestinatario,$asunto,$mensaje,$emisor="",$nombreEmisor="",$arrArchivos=null,$arrCopiaOculta=null,$arrCopia=null,$arrImagenesEmbebidas=null)
	{
		global $habilitarEnvioCorreo;
		global $mailAdministrador;
		global $nombreEmisorAdministrador;
		global $SO;
		global $urlSitio;
		global $con;
		global $versionLatis;
		
		return sendMensajeEnvioTwilio($arrDestinatario,$asunto,$mensaje,$emisor,$nombreEmisor,$arrArchivos,$arrCopiaOculta,$arrCopia);
		
		$consulta="SELECT mailDefaultSalida FROM 903_variablesSistema";
		$mailDefaultSalida=$con->obtenerValor($consulta);
		$consulta="SELECT hostSMTP,puertoSMTP,autenticacionSMTP,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis)."')as contrasena 
					FROM 805_configuracionMailSMTP WHERE idRegistro=".$mailDefaultSalida;
		$fDatosMail=$con->obtenerPrimeraFilaAsoc($consulta);

		if(!$habilitarEnvioCorreo)
			return true;
		$em=$mailAdministrador;
	
		if($emisor!="")
			$em=$emisor;
		$nomEmisor=$nombreEmisor;
		$mail = new PHPMailer();
		if($emisor!="")
		{
			$em=$emisor;
			$nomEmisor=$nombreEmisor;
		}
		
		$mail->IsSMTP();        
		
		$mail->From = $em;
	
		if($nombreEmisor!="")
			$mail->FromName=$nomEmisor;
		$mail->Timeout =   60;
		$mail->SMTPDebug =0;
		//$mail->Debugoutput = function($str, $level) 
		//			{
  		//			  file_put_contents('smtp.log', gmdate('Y-m-d H:i:s'). "\t$level\t$str\n", FILE_APPEND | LOCK_EX);
		//			};

		if(isset($_SESSION) && isset($_SESSION["habiltarDebugCorreo"]) && ($_SESSION["habiltarDebugCorreo"]==1))
		{
//			$mail->SMTPDebug = 100;
		}
		$mail->Debugoutput = 'html';
		$mail->Host = $fDatosMail["hostSMTP"];  // specify main and backup server
		$mail->Port = $fDatosMail["puertoSMTP"] ;
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $fDatosMail["mail"];  // SMTP username
		$mail->Password = $fDatosMail["contrasena"];
		if($fDatosMail["autenticacionSMTP"]==1)
		{
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
										'ssl' => array(
														'verify_peer' => false,
														'verify_peer_name' => false,
														'allow_self_signed' => true
													)
			);
		}
		$mail->SetFrom ($fDatosMail["mail"],$fDatosMail["mail"]);
		
		foreach($arrDestinatario as $destinatario)
		{
			
			if($destinatario[0]!="")
				$mail->AddAddress(trim($destinatario[0]));
		}
		//$mail->AddReplyTo($em, $nomEmisor);
		$mail->WordWrap = 70;  
		if(sizeof($arrCopiaOculta)>0)
		{
			foreach($arrCopiaOculta as $c)
				$mail->AddBCC($c[0],$c[1]);
		}
		if(sizeof($arrCopia)>0)
		{
			foreach($arrCopia as $c)
				$mail->AddCC($c[0],$c[1]);
		}
		if(sizeof($arrArchivos)>0)
		{
			$nArchivos=sizeof($arrArchivos);
			for($x=0;$x<$nArchivos;$x++)
			{
				
				$mail->AddAttachment($arrArchivos[$x][0],$arrArchivos[$x][1]);         
			}
		}
		
		if(sizeof($arrImagenesEmbebidas)>0)
		{
			$pos=0;
			foreach($arrImagenesEmbebidas as $img)
			{
				$mail->addEmbeddedImage($img[0],"imgEmb_".$pos,$img[1]);
				$pos++;
			}
		}
		
	
		if($SO==2)
		{
			$mail->Subject = utf8_decode($asunto);
			$mail->Body    = utf8_decode($mensaje);	
		}
		else
		{
			$mail->Subject = utf8_decode($asunto);
			$mail->Body    = utf8_decode($mensaje);
		}
		$mail->IsHTML(true);  

		if($mail->Send())
			return true;
		if(isset($_SESSION) && isset($_SESSION["resultadoEnvioCorreo"]))                     
		{
			$_SESSION["resultadoEnvioCorreo"]=$mail->ErrorInfo;
		}
		return false;

			
	}
	
	function esAutoAceptacionApelacionOrdinarioDespacho($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return $tipoDocumento==604?1:0;
	}
	
	
	function completarInformacionApelacionOrdinario($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if(($fRegistroBase)&&($fRegistroBase["idProcesoPadre"]!=""))
		{
			$formularioBase=obtenerFormularioBase($fRegistroBase["idProcesoPadre"]);
			$consulta="SELECT idProcesoPadre,idReferencia FROM _".$formularioBase."_tablaDinamica WHERE id__".$formularioBase."_tablaDinamica=".$fRegistroBase["idReferencia"];
			$fRegistroBase2=$con->obtenerPrimeraFilaAsoc($consulta);
			$formularioBase2=obtenerFormularioBase($fRegistroBase2["idProcesoPadre"]);
			$consulta="SELECT * FROM _".$formularioBase2."_tablaDinamica WHERE id__".$formularioBase2."_tablaDinamica=".$fRegistroBase2["idReferencia"];
			$fRegistroInicial=$con->obtenerPrimeraFilaAsoc($consulta);
			$x=0;
			$query[$x]="begin";
			$x++;
			
			$query[$x]="UPDATE _944_tablaDinamica SET comentariosAdicionales='".$fRegistroInicial["comentariosAdicionales"]."',fechaRegistroEnvioApelacionTribunalSuperiorJusticia='".
					date("Y-m-d")."',horaRecepcionEnvioApelacionTribunalSuperiorJusticia='".date("H:i").
					"',promovente=".$fRegistroInicial["promovente"].",tipoApelacion=".$fRegistroInicial["tipoApelacion"].",autoRecurso=".($fRegistroInicial["autoRecurso"]==""?"NULL":$fRegistroInicial["autoRecurso"]).
					" WHERE id__944_tablaDinamica=".$idRegistro;
			$x++;
			
			
			$query[$x]="INSERT INTO 9503_documentosRegistradosProceso(idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
						SELECT idTipoDocumento,idDocumento,presentaDocumento,'".$idFormulario."' as idFormulario,'".$idRegistro."' as idReferencia FROM 9503_documentosRegistradosProceso
						WHERE idFormulario=".$formularioBase2." AND idReferencia=".$fRegistroBase2["idReferencia"];
			$x++;
			if($fRegistroInicial["tipoApelacion"]==1)
			{
				$consulta="SELECT categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$fRegistroInicial["autoRecurso"];
				$tipoDocumento=$con->obtenerValor($consulta);
				
				$query[$x]="INSERT INTO 9503_documentosRegistradosProceso(idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
							VALUES(".$tipoDocumento.",".$fRegistroInicial["autoRecurso"].",1,".$idFormulario.",".$idRegistro.")";
				$x++;
			
			}
			
			$query[$x]="INSERT INTO 9503_documentosRegistradosProceso(idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
						SELECT a.categoriaDocumentos,idDocumento,1,".$idFormulario.",".$idRegistro." FROM 9074_documentosRegistrosProceso d,
						908_archivos a WHERE idFormulario=".$formularioBase." AND idRegistro=".$fRegistroBase["idReferencia"].
						" AND d.tipoDocumento=2 AND a.idArchivo=d.idDocumento";
			$x++;
			
			$query[$x]="commit";
			$x++;
			
			return $con->ejecutarBloque($query);
			
		}
	}
	
	function asentarHoraEnvioTribunalSuperior($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="UPDATE _944_tablaDinamica SET fechaEnvioTS='".date("Y-m-d H:i:s")."' WHERE id__944_tablaDinamica=".$idRegistro;
		return $con->ejecutarConsulta($consulta);
	}
	
	
	function asignarDespachoTribunalSuperiorApelacionOrdinarios($idFormulario,$idRegistro)
	{
		global $con;
		
		
		$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		if(($fRegistro["despachoAsignado"]!="N/E")&&($fRegistro["despachoAsignado"]!=""))
		{
			return true;
		}
		
		$consulta="SELECT id__642_tablaDinamica FROM _642_tablaDinamica WHERE aplicableA=2 and idEstado=2";
		$listaGrupos=$con->obtenerListaValores($consulta);
		
		if($listaGrupos=="")
			$listaGrupos=-1;
		
		
		/*$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);	*/
		$consulta="select * from 7006_carpetasAdministrativas where carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$fDatosBase["jurisdiccion"]="4";
		
		
		$nombreTabla=obtenerNombreTabla($fDatosBase["idFormulario"]);
		
		$fDatosBase["cuantiaProceso"]=0;
		if($con->existeCampo("cuantiaProceso",$nombreTabla))
		{
			$consulta="SELECT cuantiaProceso FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fDatosBase["idRegistro"];
			$fDatosBase["cuantiaProceso"]=$con->obtenerValor($consulta);
		}

		
		
		
		
		
		
		$cuantiaProceso=$fDatosBase["cuantiaProceso"];
		$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
					" and tipoProceso=".$fDatosBase["tipoProceso"]." 
					AND cmbTema=".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"])." order by id__643_tablaDinamica asc";
					
		$listaAmbitos=$con->obtenerListaValores($consulta);
		if($con->filasAfectadas==0)
		{
			
			$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
					" and tipoProceso=".$fDatosBase["tipoProceso"]."  order by id__643_tablaDinamica asc";
					
			$listaAmbitos=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas==0)
			{
	
				$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
						"  order by id__643_tablaDinamica asc";
				$listaAmbitos=$con->obtenerListaValores($consulta);
				if($con->filasAfectadas==0)
				{
					
					$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fDatosBase["jurisdiccion"]."  order by id__643_tablaDinamica asc";
					$listaAmbitos=$con->obtenerListaValores($consulta);
					if($con->filasAfectadas==0)
					{
					
						$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
									 order by id__643_tablaDinamica asc";
						$listaAmbitos=$con->obtenerListaValores($consulta);
	
					}
				}
			}
		}
		
		if($listaAmbitos=="")
			$listaAmbitos=-1;

		$filaGrupo=null;
		$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=1 ";
		$rAmbitos=$con->obtenerFilas($consulta);
		while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica=".$filaGrupoAux["id__643_tablaDinamica"].
						" and '".$cuantiaProceso."'".$filaGrupoAux["opCuantiaMinima"]."montoCuantiaMinima AND '".$cuantiaProceso.
						"'".$filaGrupoAux["opCuantiaMaxima"]."montoCuantiaMaxima";
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
			if($filaGrupo)
				break;
		}
	
		

		if(!$filaGrupo)
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=0 order by  id__643_tablaDinamica asc";
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
		}
		
		$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".$filaGrupo["idReferencia"];
		$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT despacho FROM _644_tablaDinamica d,817_organigrama o WHERE d.idReferencia=".$filaGrupo["idReferencia"]." and 
					o.codigoUnidad=d.despacho order by";
					
		if($fGrupoReparto["metodoAsignacion"]==1) //Aleatorio
		{
			$consulta.=" rand()";
		}
		else
		{
			$consulta.=" claveDepartamental";
		}
		
	
		$universoDespachos=$con->obtenerListaValores($consulta);
		
		$arrConfiguracion["tipoAsignacion"]="";
		$arrConfiguracion["serieRonda"]="GrupoReparto_".$filaGrupo["idReferencia"];
		$arrConfiguracion["universoAsignacion"]=$universoDespachos;
		$arrConfiguracion["idObjetoReferencia"]=-1;
		$arrConfiguracion["pagarDeudasAsignacion"]=false;
		$arrConfiguracion["considerarDeudasMismaRonda"]=false;
		$arrConfiguracion["limitePagoRonda"]=0;
		$arrConfiguracion["escribirAsignacion"]=true;
		$arrConfiguracion["idFormulario"]=$idFormulario;
		$arrConfiguracion["idRegistro"]=$idRegistro;
		$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		$cveDespacho=$resultado["idUnidad"];
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		
		
	
	

		//$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstancia($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
		$carpetaAdministrativa=$fRegistro["carpetaAdministrativa"];
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
						VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',2,".$idActividad.",NULL,2,'".$cveDespacho."',".($fDatosBase["especialidad"]==""?"NULL":$fDatosBase["especialidad"]).",".
						($fDatosBase["tipoProceso"]==""?"NULL":$fDatosBase["tipoProceso"]).",".($fDatosBase["claseProceso"]==""?"NULL":$fDatosBase["claseProceso"]).
						",".($fDatosBase["subclaseProceso"]==""?"NULL":$fDatosBase["subclaseProceso"]).
						",".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"]).",".($fDatosBase["subtema"]==""?"NULL":$fDatosBase["subtema"]).")";
		

		$x++;
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		/*$consulta[$x]="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa2aInstancia='".$carpetaAdministrativa.
					"',despachoAsignado='".$cveDespacho."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;*/
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set despachoAsignado='".$cveDespacho."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		
		$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET etapaProcesalActual=2 WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$x++;
		/*$query="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idCuentaAcceso=".$_SESSION["idUsr"];
		$idUsuarioExpediente=$con->obtenerValor($query);
		if($idUsuarioExpediente=="")	
			$idUsuarioExpediente="NULL";
		$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
						cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente)
						values(".$fRegistro["responsable"].",@idCarpeta,'".$carpetaAdministrativa."',".$fDatosBase["especialidad"].",1,'".date("Y-m-d H:i:s").
						"','".$cveDespacho."',".$anio.",".$idUsuarioExpediente.")";
		$x++;*/
	
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
	
			/*$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro);	
			}*/
			//registrarCambioEtapaProcesalCarpeta($fRegistro["carpetaAdministrativa"],2,$idFormulario,$idRegistro,-1);
			return true;
	
		}
		return false;
		
	}
	
	function asignarDespachoTribunalSuperiorApelacionOrdinariosCambiaCUP($idFormulario,$idRegistro)
	{
		global $con;
		
		
		$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$tipoCarpetaAdministrativa=3;
		if($fRegistro["tipoApelacion"]==2)
			$tipoCarpetaAdministrativa=2;
		
		if(($fRegistro["despachoAsignado"]!="N/E")&&($fRegistro["despachoAsignado"]!=""))
		{
			return true;
		}
		
		$consulta="SELECT id__642_tablaDinamica FROM _642_tablaDinamica WHERE aplicableA=2 and idEstado=2";
		$listaGrupos=$con->obtenerListaValores($consulta);
		
		if($listaGrupos=="")
			$listaGrupos=-1;
		
		
		
		$consulta="select * from 7006_carpetasAdministrativas where carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$fDatosBase["jurisdiccion"]="4";
		
		
		$nombreTabla=obtenerNombreTabla($fDatosBase["idFormulario"]);
		
		$fDatosBase["cuantiaProceso"]=0;
		if($con->existeCampo("cuantiaProceso",$nombreTabla))
		{
			$consulta="SELECT cuantiaProceso FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fDatosBase["idRegistro"];
			$fDatosBase["cuantiaProceso"]=$con->obtenerValor($consulta);
		}

		
		$cuantiaProceso=$fDatosBase["cuantiaProceso"];
		$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
					" and tipoProceso=".$fDatosBase["tipoProceso"]." 
					AND cmbTema=".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"])." order by id__643_tablaDinamica asc";
					
		$listaAmbitos=$con->obtenerListaValores($consulta);
		if($con->filasAfectadas==0)
		{
			
			$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
					" and tipoProceso=".$fDatosBase["tipoProceso"]."  order by id__643_tablaDinamica asc";
					
			$listaAmbitos=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas==0)
			{
	
				$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
						"  order by id__643_tablaDinamica asc";
				$listaAmbitos=$con->obtenerListaValores($consulta);
				if($con->filasAfectadas==0)
				{
					
					$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$fDatosBase["jurisdiccion"]."  order by id__643_tablaDinamica asc";
					$listaAmbitos=$con->obtenerListaValores($consulta);
					if($con->filasAfectadas==0)
					{
					
						$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
									 order by id__643_tablaDinamica asc";
						$listaAmbitos=$con->obtenerListaValores($consulta);
	
					}
				}
			}
		}
		
		if($listaAmbitos=="")
			$listaAmbitos=-1;

		$filaGrupo=null;
		$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=1 ";
		$rAmbitos=$con->obtenerFilas($consulta);
		while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica=".$filaGrupoAux["id__643_tablaDinamica"].
						" and '".$cuantiaProceso."'".$filaGrupoAux["opCuantiaMinima"]."montoCuantiaMinima AND '".$cuantiaProceso.
						"'".$filaGrupoAux["opCuantiaMaxima"]."montoCuantiaMaxima";
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
			if($filaGrupo)
				break;
		}
	
		

		if(!$filaGrupo)
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=0 order by  id__643_tablaDinamica asc";
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
		}
		
		$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".$filaGrupo["idReferencia"];
		$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT despacho FROM _644_tablaDinamica d,817_organigrama o WHERE d.idReferencia=".$filaGrupo["idReferencia"]." and 
					o.codigoUnidad=d.despacho order by";
					
		if($fGrupoReparto["metodoAsignacion"]==1) //Aleatorio
		{
			$consulta.=" rand()";
		}
		else
		{
			$consulta.=" claveDepartamental";
		}
		
	
		$universoDespachos=$con->obtenerListaValores($consulta);
		
		$asignacionAntecedente=false;
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$fRegistro["carpetaAdministrativa"]."' AND tipoCarpetaAdministrativa IN(2,3) ORDER BY fechaCreacion DESC limit 0,1";
		$universoAuxiliar=$con->obtenerListaValores($consulta);
		
		if($universoAuxiliar!="")
		{
			$universoDespachos=$universoAuxiliar;
			$asignacionAntecedente=true;
		}
		$arrConfiguracion["tipoAsignacion"]="";
		$arrConfiguracion["serieRonda"]=$asignacionAntecedente?"Reparto_Antecedente":("GrupoReparto_".$filaGrupo["idReferencia"]);
		$arrConfiguracion["universoAsignacion"]=$universoDespachos;
		$arrConfiguracion["idObjetoReferencia"]=-1;
		$arrConfiguracion["pagarDeudasAsignacion"]=false;
		$arrConfiguracion["considerarDeudasMismaRonda"]=false;
		$arrConfiguracion["limitePagoRonda"]=0;
		$arrConfiguracion["escribirAsignacion"]=true;
		$arrConfiguracion["idFormulario"]=$idFormulario;
		$arrConfiguracion["idRegistro"]=$idRegistro;
		
		
		
		$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		$cveDespacho=$resultado["idUnidad"];
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");

		$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
		$carpetaAdministrativa=$arrCodigoUnico[0];
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
						VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',2,".$idActividad.",'".$fRegistro["carpetaAdministrativa"]."',".$tipoCarpetaAdministrativa.",'".$cveDespacho."',".($fDatosBase["especialidad"]==""?"NULL":$fDatosBase["especialidad"]).",".
						($fDatosBase["tipoProceso"]==""?"NULL":$fDatosBase["tipoProceso"]).",".($fDatosBase["claseProceso"]==""?"NULL":$fDatosBase["claseProceso"]).
						",".($fDatosBase["subclaseProceso"]==""?"NULL":$fDatosBase["subclaseProceso"]).
						",".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"]).",".($fDatosBase["subtema"]==""?"NULL":$fDatosBase["subtema"]).")";
		

		$x++;
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set asignadoAntecedente=".($asignacionAntecedente?1:0).",despachoAsignado='".$cveDespacho."',carpetaAdministrativa2daInstancia='".$carpetaAdministrativa."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		
		$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET etapaProcesalActual=2 WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$x++;
		
	
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
	
			$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro);	
			}
			
			$query="select idDocumento from 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and idDocumento is not null";
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro);	
			}
			
			return true;
	
		}
		return false;
		
	}
	
	function asignarDespachoTribunalSuperiorApelacionOrdinariosReasignacion($idFormulario,$idRegistro)
	{
		global $con;
		
		$esSalaVirtual=false;
		$consulta="SELECT * FROM _952_tablaDinamica WHERE id__952_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$anio=date("Y");

		if(($fRegistro["despachoAsignado"]!="N/E")&&($fRegistro["despachoAsignado"]!=""))
		{
			return true;
		}
		
		$consulta="select * from 7006_carpetasAdministrativas where carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa="";
		$resultado=NULL;
		
		if($fDatosBase["tipoProceso"]==19)
		{
			$arrCarpetas=array();
			obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
			array_push($arrCarpetas,$fRegistro["carpetaAdministrativa"]);
			$listaExclusion="";
			foreach($arrCarpetas as $c)
			{
				$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion,tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$c."'";
				$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
				$tipoProceso=$fDatosCarpeta["tipoProceso"];
				
				if($tipoProceso==19)
				{
					$consulta="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$fDatosCarpeta["unidadGestion"]."' AND presideSala=1";
					$sala=$con->obtenerValor($consulta);
					if($listaExclusion=="")
						$listaExclusion=$sala;
					else
						$listaExclusion.=",".$sala;
					
					
				}
			}
			
			if($listaExclusion=="")
				$listaExclusion=-1;
			
			
			$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='10000002' and id__992_tablaDinamica in(11,12,13) 
						and id__992_tablaDinamica not in(".$listaExclusion.")";
			$universoDespachos=$con->obtenerListaValores($consulta);
			$arrConfiguracion["tipoAsignacion"]="";
			$arrConfiguracion["serieRonda"]="GrupoReparto_".$idFormulario;
			$arrConfiguracion["universoAsignacion"]=$universoDespachos;
			$arrConfiguracion["idObjetoReferencia"]=-1;
			$arrConfiguracion["pagarDeudasAsignacion"]=false;
			$arrConfiguracion["considerarDeudasMismaRonda"]=false;
			$arrConfiguracion["limitePagoRonda"]=0;
			$arrConfiguracion["escribirAsignacion"]=true;
			$arrConfiguracion["idFormulario"]=$idFormulario;
			$arrConfiguracion["idRegistro"]=$idRegistro;
			$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
			$cveDespacho=$resultado["idUnidad"];
			
			$esSalaVirtual=true;
				
			$anio=date("Y");
			
			$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$cveDespacho." AND presideSala=1";
			$cveDespacho=$con->obtenerValor($consulta);
			
		
			
	
			$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,1,$idFormulario,$idRegistro);	
			$carpetaAdministrativa=$arrCodigoUnico[0];
			
			$universoDespachos=$con->obtenerListaValores($consulta);
			if($universoDespachos=="")
			{
				$query="update _".$idFormulario."_tablaDinamica set despachoAsignado='0000000000' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	
				return $con->ejecutarConsulta($query);
			}
		}
		else
		{

			
			if(($fDatosBase["tipoProceso"]==20)||($fDatosBase["tipoProceso"]==1)||($fDatosBase["tipoProceso"]==3)||($fDatosBase["tipoProceso"]==4)||($fDatosBase["tipoProceso"]==5)||($fDatosBase["tipoProceso"]==6))
			{
				$arrCarpetas=array();
				obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
				array_push($arrCarpetas,$fRegistro["carpetaAdministrativa"]);
				$listaExclusion="";
				foreach($arrCarpetas as $c)
				{
					
					$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$c."'";
					$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
					
					if($listaExclusion=="")
						$listaExclusion="'".$fDatosCarpeta["unidadGestion"]."'";
					else
						$listaExclusion.=",'".$fDatosCarpeta["unidadGestion"]."'";
						
						
					
				}
				
				if($listaExclusion=="")
					$listaExclusion=-1;
				
				$consulta="SELECT idReferencia FROM _644_tablaDinamica WHERE despacho='".$fDatosBase["unidadGestion"]."'";
				$iGrupoReparto=$con->obtenerValor($consulta);
				$consulta="SELECT despacho FROM _644_tablaDinamica WHERE idReferencia=".$iGrupoReparto." AND despacho NOT in(".$listaExclusion.")";
				$universoDespachos=$con->obtenerListaValores($consulta);
				
				
				$arrConfiguracion["tipoAsignacion"]="";
				$arrConfiguracion["serieRonda"]="GrupoReparto_".$idFormulario;
				$arrConfiguracion["universoAsignacion"]=$universoDespachos;
				$arrConfiguracion["idObjetoReferencia"]=-1;
				$arrConfiguracion["pagarDeudasAsignacion"]=false;
				$arrConfiguracion["considerarDeudasMismaRonda"]=false;
				$arrConfiguracion["limitePagoRonda"]=0;
				$arrConfiguracion["escribirAsignacion"]=true;
				$arrConfiguracion["idFormulario"]=$idFormulario;
				$arrConfiguracion["idRegistro"]=$idRegistro;
				$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
				$cveDespacho=$resultado["idUnidad"];
				
				$esSalaVirtual=false;
					
				
				
				$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,1,$idFormulario,$idRegistro);	
				$carpetaAdministrativa=$arrCodigoUnico[0];
				
				$universoDespachos=$con->obtenerListaValores($consulta);
				if($universoDespachos=="")
				{
					$query="update _".$idFormulario."_tablaDinamica set despachoAsignado='0000000000' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
					return $con->ejecutarConsulta($query);
				}
			}
			else
			{
				if($fDatosBase["tipoCarpetaAdministrativa"]==20)
				{
					$arrCarpetas=array();
					obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
					array_push($arrCarpetas,$fRegistro["carpetaAdministrativa"]);
					$listaExclusion="";
					foreach($arrCarpetas as $c)
					{
						$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$c."'";
						$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
						$tipoCarpetaAdministrativa=$fDatosCarpeta["tipoCarpetaAdministrativa"];
						
						if($tipoCarpetaAdministrativa==20)
						{
							$consulta="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$fDatosCarpeta["unidadGestion"]."' AND presideSala=1";
							$sala=$con->obtenerValor($consulta);
							if($listaExclusion=="")
								$listaExclusion=$sala;
							else
								$listaExclusion.=",".$sala;
							
							
						}
					}
					
					if($listaExclusion=="")
						$listaExclusion=-1;
					
					
					$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002' and id__992_tablaDinamica in(24,25,26) and id__992_tablaDinamica not in(".$listaExclusion.")";
					$universoDespachos=$con->obtenerListaValores($consulta);
					$arrConfiguracion["tipoAsignacion"]="";
					$arrConfiguracion["serieRonda"]="GrupoReparto_".$idFormulario;
					$arrConfiguracion["universoAsignacion"]=$universoDespachos;
					$arrConfiguracion["idObjetoReferencia"]=-1;
					$arrConfiguracion["pagarDeudasAsignacion"]=false;
					$arrConfiguracion["considerarDeudasMismaRonda"]=false;
					$arrConfiguracion["limitePagoRonda"]=0;
					$arrConfiguracion["escribirAsignacion"]=true;
					$arrConfiguracion["idFormulario"]=$idFormulario;
					$arrConfiguracion["idRegistro"]=$idRegistro;
					$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
					$cveDespacho=$resultado["idUnidad"];
					
					$esSalaVirtual=true;
						
					$anio=date("Y");
					
					$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$cveDespacho." AND presideSala=1";
					$cveDespacho=$con->obtenerValor($consulta);
					
				
					
			
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,20,$idFormulario,$idRegistro);	
					$carpetaAdministrativa=$arrCodigoUnico[0];
					
					$universoDespachos=$con->obtenerListaValores($consulta);
					if($universoDespachos=="")
					{
						$query="update _".$idFormulario."_tablaDinamica set despachoAsignado='0000000000' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
			
						return $con->ejecutarConsulta($query);
					}
				}
				else
				{
					$consulta="SELECT id__642_tablaDinamica FROM _642_tablaDinamica WHERE aplicableA=2 and idEstado=2";
					$listaGrupos=$con->obtenerListaValores($consulta);
					
					if($listaGrupos=="")
						$listaGrupos=-1;
					
					
					/*$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
					$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);	*/
					
					
					$fDatosBase["jurisdiccion"]="4";
					
					$consulta="select unidadGestion from 7006_carpetasAdministrativas where carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
					$listaExclusion=$con->obtenerListaValores($consulta,"'");
					if($listaExclusion=="")
						$listaExclusion=-1;
					
					$nombreTabla=obtenerNombreTabla($fDatosBase["idFormulario"]);
					
					$fDatosBase["cuantiaProceso"]=0;
					if($con->existeCampo("cuantiaProceso",$nombreTabla))
					{
						$consulta="SELECT cuantiaProceso FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fDatosBase["idRegistro"];
						$fDatosBase["cuantiaProceso"]=$con->obtenerValor($consulta);
					}
			
					$cuantiaProceso=$fDatosBase["cuantiaProceso"];
					$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
								and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
								" and tipoProceso=".$fDatosBase["tipoProceso"]." 
								AND cmbTema=".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"])." order by id__643_tablaDinamica asc";
								
					$listaAmbitos=$con->obtenerListaValores($consulta);
					if($con->filasAfectadas==0)
					{
						
						$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
								and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
								" and tipoProceso=".$fDatosBase["tipoProceso"]."  order by id__643_tablaDinamica asc";
								
						$listaAmbitos=$con->obtenerListaValores($consulta);
						if($con->filasAfectadas==0)
						{
				
							$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
									and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
									"  order by id__643_tablaDinamica asc";
							$listaAmbitos=$con->obtenerListaValores($consulta);
							if($con->filasAfectadas==0)
							{
								
								$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
									and jurisdiccion=".$fDatosBase["jurisdiccion"]."  order by id__643_tablaDinamica asc";
								$listaAmbitos=$con->obtenerListaValores($consulta);
								if($con->filasAfectadas==0)
								{
								
									$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
												 order by id__643_tablaDinamica asc";
									$listaAmbitos=$con->obtenerListaValores($consulta);
				
								}
							}
						}
					}
					
					if($listaAmbitos=="")
						$listaAmbitos=-1;
			
					$filaGrupo=null;
					$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=1 ";
					$rAmbitos=$con->obtenerFilas($consulta);
					while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
					{
						$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica=".$filaGrupoAux["id__643_tablaDinamica"].
									" and '".$cuantiaProceso."'".$filaGrupoAux["opCuantiaMinima"]."montoCuantiaMinima AND '".$cuantiaProceso.
									"'".$filaGrupoAux["opCuantiaMaxima"]."montoCuantiaMaxima";
						$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
						if($filaGrupo)
							break;
					}
				
					
			
					if(!$filaGrupo)
					{
						$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=0 order by  id__643_tablaDinamica asc";
						$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
					}
					
					$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".$filaGrupo["idReferencia"];
					$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$consulta="SELECT despacho FROM _644_tablaDinamica d,817_organigrama o WHERE d.idReferencia=".$filaGrupo["idReferencia"]." and 
								o.codigoUnidad=d.despacho and d.despacho not in(".$listaExclusion.") order by";
								
					if($fGrupoReparto["metodoAsignacion"]==1) //Aleatorio
					{
						$consulta.=" rand()";
					}
					else
					{
						$consulta.=" claveDepartamental";
					}
					
			 
					$universoDespachos=$con->obtenerListaValores($consulta);
					if($universoDespachos=="")
					{
						$query="update _".$idFormulario."_tablaDinamica set despachoAsignado='0000000000' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
			
						return $con->ejecutarConsulta($query);
					}
					
					$arrConfiguracion["tipoAsignacion"]="";
					$arrConfiguracion["serieRonda"]="GrupoReparto_".$filaGrupo["idReferencia"];
					$arrConfiguracion["universoAsignacion"]=$universoDespachos;
					$arrConfiguracion["idObjetoReferencia"]=-1;
					$arrConfiguracion["pagarDeudasAsignacion"]=false;
					$arrConfiguracion["considerarDeudasMismaRonda"]=false;
					$arrConfiguracion["limitePagoRonda"]=0;
					$arrConfiguracion["escribirAsignacion"]=true;
					$arrConfiguracion["idFormulario"]=$idFormulario;
					$arrConfiguracion["idRegistro"]=$idRegistro;
					$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
					$cveDespacho=$resultado["idUnidad"];
					
					$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
					$idUnidadGestion=$con->obtenerValor($consulta);
					if($idUnidadGestion=="")
						$idUnidadGestion=-1;
						
					$carpetaAdministrativa=$fRegistro["carpetaAdministrativa"];
				}
		
			}
		}
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
						VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',1,".$idActividad.",'".$fRegistro["carpetaAdministrativa"]."',".$fDatosBase["tipoCarpetaAdministrativa"].",'".$cveDespacho."',".
						($fDatosBase["especialidad"]==""?"NULL":$fDatosBase["especialidad"]).",".
						($fDatosBase["tipoProceso"]==""?"NULL":$fDatosBase["tipoProceso"]).",".($fDatosBase["claseProceso"]==""?"NULL":$fDatosBase["claseProceso"]).
						",".($fDatosBase["subclaseProceso"]==""?"NULL":$fDatosBase["subclaseProceso"]).
						",".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"]).",".($fDatosBase["subtema"]==""?"NULL":$fDatosBase["subtema"]).")";
		

		$x++;
	
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set despachoAsignado='".$cveDespacho."',carpetaAdministrativa2aInstancia='".$carpetaAdministrativa."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		$consulta[$x]="UPDATE 00013_registrosMacroProceso SET codigoInstitucion='".$cveDespacho."' WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND idElemento=20  AND situacionActual=1";
		$x++;
		
		
		$query="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idCuentaAcceso=".$_SESSION["idUsr"];
		$idUsuarioExpediente=$con->obtenerValor($query);
		if($idUsuarioExpediente=="")	
			$idUsuarioExpediente="NULL";
		$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
						cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente)
						values(".$fRegistro["responsable"].",@idCarpeta,'".$carpetaAdministrativa."',".$fDatosBase["especialidad"].",1,'".date("Y-m-d H:i:s").
						"','".$cveDespacho."',".$anio.",".$idUsuarioExpediente.")";
		$x++;
	
		if($esSalaVirtual)
		{
			$orden=1;
			$query="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$resultado["idUnidad"]." AND presideSala=0";
			$resSalas=$con->obtenerFilas($query);
			while($filaSala=$con->fetchAssoc($resSalas))
			{
				$consulta[$x]="INSERT INTO 7006_carpetasAdministrativasDespachosColegiados(carpetaAdministrativa,despachoAsignado,orden) 
							VALUES('".$carpetaAdministrativa."','".$filaSala["despachoAsigando"]."',".$orden.")";
				$x++;
				$orden++;
			}
		
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
	
			return true;
	
		}
		return false;
		
	}
	
	
	function obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($idUnidadGestion,$anio,$tipoCarpeta,$idFormulario,$idRegistro)
	{
		global $con;
		
		
		$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatosRadicacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$procesoJudicialOrigen=substr($fDatosRadicacion["carpetaAdministrativa"],0,strlen($fDatosRadicacion["carpetaAdministrativa"])-2);
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa LIKE 
					'".$procesoJudicialOrigen."%' ORDER BY carpetaAdministrativa DESC";
		$ultimoProceso=$con->obtenerValor($consulta);
		$maxValor=substr($ultimoProceso,strlen($fDatosRadicacion["carpetaAdministrativa"])-2,2);
		
		$folioCorreccion=($maxValor*1)+1;
		
		$folioCorreccion-=5;
		if($folioCorreccion<1)
			$folioCorreccion=1;
		
		$carpetaAdministrativa=$procesoJudicialOrigen.str_pad($folioCorreccion,2,"0",STR_PAD_LEFT);
		
		
		while(existeCarpetaAdministrativa($carpetaAdministrativa,""))
		{
			$carpetaAdministrativa=$procesoJudicialOrigen.str_pad($folioCorreccion,2,"0",STR_PAD_LEFT);
			$folioCorreccion++;	
			
		}
		
		$folioActual=$folioCorreccion;
				
		$arrResultado[0]=$carpetaAdministrativa;
		$arrResultado[1]=$folioActual;
		return $arrResultado;
		
		
		
		
	}
	
	function obtenerInstitucionProcesoJudicialIngresoApelacionTimer6Meses($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa="";
		
		
		$consulta="SELECT carpetaAdministrativa2daInstancia FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;	
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and tipoCarpetaAdministrativa in(2,3) order by idCarpeta desc";
		$institucion=$con->obtenerValor($consulta);
		return "'".$institucion."'";
	}
	
	function esProcesoApelacionAuto($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);

		$consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$codigoInstitucion=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and unidadGestion='".$codigoInstitucion."' AND tipoCarpetaAdministrativa=3";
		$numReg=$con->obtenerValor($consulta);
		
		
		return $numReg>0?1:0;
	}
	
	function esProcesoApelacionSentencia($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$codigoInstitucion=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and unidadGestion='".$codigoInstitucion."' AND tipoCarpetaAdministrativa=2";
		$numReg=$con->obtenerValor($consulta);
		
		
		return $numReg>0?1:0;
	}
	
	
	function generarFolioProcesosPaqueteTutela($idFormulario,$idRegistro)
	{
		global $con;
		
		$anio=date("Y");
		
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="select folioActual FROM 7003_administradorFoliosProcesos WHERE idFormulario=".$idFormulario." AND anio=".$anio." for update";
	
			$folioActual=$con->obtenerValor($query);
			if($folioActual=="")
			{
				$folioActual=1;
				
				$query="INSERT INTO 7003_administradorFoliosProcesos(idFormulario,anio,folioActual) VALUES(".$idFormulario.",".$anio.",".$folioActual.")";
				
			}
			else
			{
				$folioActual++;
				$query="update 7003_administradorFoliosProcesos set folioActual=".$folioActual." where idFormulario=".$idFormulario." and anio=".$anio;
			}
				
			if($con->ejecutarConsulta($query))
			{
				$query="commit";
				$con->ejecutarConsulta($query);
				
				
				
				return "P".str_pad($folioActual,5,"0",STR_PAD_LEFT)."/".$anio;
				
			}
				
			
		}
		
		return 0;
		
	}
	
	function actualizarSalaPreside($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT idReferencia,presideSala FROM _993_tablaDinamica WHERE id__993_tablaDinamica=".$idRegistro;
		$filaBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($filaBase["presideSala"]==1)
		{
			$consulta="UPDATE _993_tablaDinamica SET presideSala=0 WHERE idReferencia=".$filaBase["idReferencia"]." and id__993_tablaDinamica<>".$idRegistro;
			$con->ejecutarConsulta($consulta);
		}
		
		
	}
	
	
	function realizarRepartoDespachoPreseleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _990_tablaDinamica WHERE id__990_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRegistro["despachoAsignado"]!="N/E")
		{
		
			return true;	
		}
						
		$consulta="SELECT d.despachoAsigando FROM _993_tablaDinamica d, _992_tablaDinamica s WHERE d.idReferencia=s.id__992_tablaDinamica AND 
					s.idEstado=2 AND s.tipoSala=1 AND d.idEstado=2 ORDER BY d.id__993_tablaDinamica";						
		$universoDespachos=$con->obtenerListaValores($consulta);
		$arrConfiguracion["tipoAsignacion"]="";
		$arrConfiguracion["serieRonda"]="GrupoReparto_PreSeleccion";
		$arrConfiguracion["universoAsignacion"]=$universoDespachos;
		$arrConfiguracion["idObjetoReferencia"]=-1;
		$arrConfiguracion["pagarDeudasAsignacion"]=false;
		$arrConfiguracion["considerarDeudasMismaRonda"]=false;
		$arrConfiguracion["limitePagoRonda"]=0;
		$arrConfiguracion["escribirAsignacion"]=true;
		$arrConfiguracion["idFormulario"]=$idFormulario;
		$arrConfiguracion["idRegistro"]=$idRegistro;
		$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		$cveDespacho=$resultado["idUnidad"];
		
		$carpetaAdministrativa=$fRegistro["codigo"];
		
		
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,tipoProceso) 
						VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',2,-1,NULL,40,'".$cveDespacho."',6)";
		

		$x++;
		
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set despachoAsignado='".$cveDespacho.
					"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($consulta))
		{
			$query="SELECT * FROM _917_tablaDinamica WHERE idReferencia=".$idRegistro;
			$res=$con->obtenerFilas($query);
			while($fila=$con->fetchAssoc($res))
				cambiarEtapaFormulario(917,$fila["id__917_tablaDinamica"],4,"",-1,"NULL","NULL",0);
			
			return true;
	
		}
		return false;
		
	}
	
	function generarFolioProcesosPreSeleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$anio=date("Y");
		
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="select folioActual FROM 7003_administradorFoliosProcesos WHERE idFormulario=".$idFormulario." AND anio=".$anio." for update";
	
			$folioActual=$con->obtenerValor($query);
			if($folioActual=="")
			{
				$folioActual=1;
				
				$query="INSERT INTO 7003_administradorFoliosProcesos(idFormulario,anio,folioActual) VALUES(".$idFormulario.",".$anio.",".$folioActual.")";
				
			}
			else
			{
				$folioActual++;
				$query="update 7003_administradorFoliosProcesos set folioActual=".$folioActual." where idFormulario=".$idFormulario." and anio=".$anio;
			}
				
			if($con->ejecutarConsulta($query))
			{
				$query="commit";
				$con->ejecutarConsulta($query);
				
				
				
				return "PRE-SEL-".str_pad($folioActual,5,"0",STR_PAD_LEFT)."/".$anio;
				
			}
				
			
		}
		
		return 0;
		
	}
	
	function generarFolioProcesosSeleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$anio=date("Y");
		
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="select folioActual FROM 7003_administradorFoliosProcesos WHERE idFormulario=".$idFormulario." AND anio=".$anio." for update";
	
			$folioActual=$con->obtenerValor($query);
			if($folioActual=="")
			{
				$folioActual=1;
				
				$query="INSERT INTO 7003_administradorFoliosProcesos(idFormulario,anio,folioActual) VALUES(".$idFormulario.",".$anio.",".$folioActual.")";
				
			}
			else
			{
				$folioActual++;
				$query="update 7003_administradorFoliosProcesos set folioActual=".$folioActual." where idFormulario=".$idFormulario." and anio=".$anio;
			}
				
			if($con->ejecutarConsulta($query))
			{
				$query="commit";
				$con->ejecutarConsulta($query);
				
				
				
				return "SEL-".str_pad($folioActual,5,"0",STR_PAD_LEFT)."/".$anio;
				
			}
				
			
		}
		
		return 0;
		
	}

	function validarEnvioSalaPreseleccion($idFormulario,$idRegistro)
	{
		global $con;
		$arrErrores=array();
		$consulta="SELECT COUNT(*) FROM _917_tablaDinamica WHERE idReferencia=".$idRegistro;
		$numReg=$con->obtenerValor($consulta);
		if($numReg==0)
		{
			$oError["seccion"]="Tutelas";
			$oError["mensajeError"]="Almenos debe asociar un registro de Tutela al Paquete";
			
			array_push($arrErrores,$oError);
		}
		
		return $arrErrores;
		
	}
	
	function validarEnvioInformeSeleccion($idFormulario,$idRegistro)
	{
		global $con;
		$arrErrores=array();
		$consulta="SELECT COUNT(*) FROM _917_tablaDinamica WHERE idReferencia=".$idRegistro." and idEstado<>5";
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
		{
			$oError["seccion"]="Tutelas";
			$oError["mensajeError"]="Para generar el informe de selecci&oacute;n primero debe concluir el estudio de las tutelas asignadas";
			
			array_push($arrErrores,$oError);
		}
		
		return $arrErrores;
		
	}
	
	
	function obtenerFechaAudienciaCorreTraslado($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT idProcesoPadre,idReferencia FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$fProvidencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT fechaSesion FROM _1002_tablaDinamica WHERE idReferencia=".$fProvidencia["idReferencia"];
		$fechaSesion=$con->obtenerValor($consulta);
		
		return "'".$fechaSesion."'";
		
	}
	
	function obtenerMagistradoSalaPreseleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT codigoInstitucion FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$codigoInstutcion=$con->obtenerValor($consulta);
		
		$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='96_0' AND ad.Institucion='".$codigoInstutcion."'";
		
		$listaMagistrado=$con->obtenerListaValores($consulta);
		return "'".$listaMagistrado."'";
	}

	function esAutoInformeSeleccionTutela($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

		$tipoDocumento=$con->obtenerValor($consulta);
		return $tipoDocumento==617?1:0;
	}
	
	
	function obtenerIDRegistroCarpetaAdministrativa($idFormulario,$idRegistro)
	{
		global $con;
		

		$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		return "'".$fRegistro["idRegistro"]."'";
		
		
		
		
	}
	
	function enviarTutelasSalaRevision($idFormulario,$idRegistro)
	{
		global $con;
		
		
		$consulta="SELECT idReferencia FROM _1008_tablaDinamica WHERE id__1008_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__917_tablaDinamica FROM _917_tablaDinamica t,_996_tablaDinamica s WHERE t.idreferencia=".$idReferencia." AND t.salaRevision='N/E'
					AND s.idReferencia=t.id__917_tablaDinamica AND s.tutelaSeleccionable=1 ORDER BY t.carpetaAdministrativa";
		
		$res=$con->obtenerFilas($consulta);
		
		while($fila=$con->fetchAssoc($res))
		{
			//varDUmp($fila);
			cambiarEtapaFormulario(917,$fila["id__917_tablaDinamica"],7,"",-1,"NULL","NULL",0);
		}
		
		return true;
	}
	
	
	function obtenerMagistradosSalaSeleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
	
	
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa.
			"' AND tipoCarpetaAdministrativa=30";
			
		$unidadGestion=$con->obtenerListaValores($consulta,"'");	
		if($unidadGestion=="")	
		{	
			$consulta="	SELECT despachoAsignado as unidadGestion FROM 7006_carpetasAdministrativasDespachosColegiados 
					WHERE carpetaAdministrativa='".$carpetaAdministrativa."'
					union 
					SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			$unidadGestion=$con->obtenerListaValores($consulta,"'");
		}
	
		$arrMagistrados=array();
		$consulta="SELECT ad.idUsuario,ad.Institucion FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='96_0' AND ad.Institucion in(".$unidadGestion.") order by ad.idUsuario";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			if(!isset($arrMagistrados[$fila["Institucion"]]))
			{
				$arrMagistrados[$fila["Institucion"]]=$fila["idUsuario"];
			}
		}
		$listaMagistrado="";
		foreach($arrMagistrados as $unidad=>$idUsuario)
		{
			if($listaMagistrado=="")
				$listaMagistrado=$idUsuario;
			else
				$listaMagistrado.=",".$idUsuario;
		}
		return "'".$listaMagistrado."'";
	}	
	
	function esActuacionSentenciaRevisionTutela($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$numReg=$con->obtenerValor($consulta);

		return (($numReg==25) || ($numReg==29)|| ($numReg==32)|| ($numReg==43))?1:0;
		/*global $con;
		
		$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$providenciaAplicar=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT plantillaAsociada FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
		$plantillaAsociada=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT metodoFirma FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$plantillaAsociada;
		$metodoFirma=$con->obtenerValor($consulta);
		return ($metodoFirma==2)?1:0;*/	
	}
	
	function esActuacionDiferenteSentenciaRevisionTutela($idFormulario,$idRegistro)
	{
		global $con;

		/*$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$numReg=$con->obtenerValor($consulta);*/

		$numReg=esActuacionSentenciaRevisionTutela($idFormulario,$idRegistro);

		return $numReg==1?0:1;	
	}
	
	
	function obtenerFechaAudienciaAutoGeneraAudiencia($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla=obtenerNombreTabla($idFormulario);
		$consulta="SELECT idReferencia FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
		$idAudiencia=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM _781_tablaDinamica WHERE idReferencia=".$idAudiencia;
		$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		return "'".$fAudiencia["fechaAudiencia"]."'";
		
		
	}
	
	
	function marcarTerminotemporizadorAtendido($idFormulario,$idRegistro)
	{
		global $con;
		
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$cadParametros='{"iFormulario":"'.$idFormulario.'","iRegistro":"'.$idRegistro.'","idFormulario":"'.$idFormulario.
						'","idRegistro":"'.$idRegistro.'","idProceso":"'.$idProceso.
						'","idActorProceso":"0","campoTablaDestino":"","etapa":"0","idMacroProceso":"","idRegistroProcesoEtapaMacroProceso":"","idElementoEvaluacion":"","tipoElemento":"","idRegistroElemento":"","lblEtiquetaElemento":""}';
		$objParametros=json_decode($cadParametros);	
		
		
		$consulta="SELECT idRegistroElementoMacroProceso as idRegistro FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fila=$con->obtenerPrimeraFilaAsoc($consulta);

		if($fila["idRegistro"]!="")
		{
			$cAdmonMacroProceso=new cMacroProcesoAdmon($idFormulario,$idRegistro,$objParametros);
			$cAdmonMacroProceso->marcarRegistroMacroProcesoAtendido($fila["idRegistro"]);
		}
	}
	
	function obtenerFechaLimiteAtencionTermino($idFormulario,$idRegistro)
	{
		global $con;
		$nombreTabla="_".$idFormulario."_tablaDinamica";
		if($con->existeCampo("idRegistroElementoMacroProceso",$nombreTabla))
		{
			$consulta="SELECT idRegistroElementoMacroProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

			$idRegistroElementoMacroProceso=$con->obtenerValor($consulta);
			if($idRegistroElementoMacroProceso!="")
			{
				$consulta="SELECT fechaMaximaAtencion FROM 00013_registrosMacroProceso WHERE idRegistro=".$idRegistroElementoMacroProceso;
				
				$fechaMaximaAtencion=$con->obtenerValor($consulta);
				
				return "'".$fechaMaximaAtencion."'";
			}
			else
			{
				$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				switch($idFormulario)
				{
					case 707:
					
						$consulta="SELECT idReferenciaArrancador FROM _707_tablaDinamica WHERE carpetaAdministrativa='".$fRegistroBase["carpetaAdministrativa"].
								"' AND codigoInstitucion='".$fRegistroBase["codigoInstitucion"]."' AND promovente=".$fRegistroBase["promovente"]." and idReferenciaArrancador is not null";
							
						$idReferenciaArrancador=$con->obtenerValor($consulta);
						
						if($idReferenciaArrancador!="")
						{
							$consulta="SELECT fechaMaximaAtencion FROM 00013_registrosMacroProceso WHERE idRegistro=".$idReferenciaArrancador;
				
							$fechaMaximaAtencion=$con->obtenerValor($consulta);
							
							return "'".$fechaMaximaAtencion."'";
						}
						
					break;
				}
			}
			
		}
		
		return "''";
		
		
	}
	
	
	function validarDocumentoAdjuntoConcepto($idFormulario,$idRegistro)
	{
		global $con;
		$arrErrores=array();
		$cadRes="";
		$consulta="SELECT COUNT(*) FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario.
					" AND idRegistro=".$idRegistro." AND tipoDocumento=1";

		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$o["seccion"]="General";
			$o["mensajeError"]="Debe adjuntar el documento a radicar";
			array_push($arrErrores,$o);
			
		}
		
		
		return $arrErrores;	
	}
	
	
	function notificarEventoAudienciaSIAJOPSIUGJ($idEvento)
	{
		global $con;
		
		$idRegistroBitacora=registrarBitacoraNotificacionSIAJOP($idEvento);
		$response="";
		$idWS=0;
		try
		{
			$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
			$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			
			$idWS=$fDatosEvento["idEdificio"]*10;
			$xml=reportarAudienciaSiajopSIUGJ($idEvento);
			
			
			$direccionIP="189.211.178.198";
			
			$urlWebServices="http://".$direccionIP.":8080/ServiceSIAJOP.asmx";
			$client = new nusoap_client($urlWebServices."?wsdl","wsdl");
			$parametros=array();
			$parametros["xml"]=$xml;
			$response = $client->call("SynchronizationAudience", $parametros);
			
			
			if($response=="")
			{
				@actualizarBitacoraNotificacionSIAJOP($idRegistroBitacora,0,"No se pudo establecer conexion con el servidor",0,bE(""),$idWS);
				return;
			}
			$response=$response["SynchronizationAudienceResult"];
			
			$cXML=simplexml_load_string($response);	
			$resultado=(string)$cXML->resultado[0];
			@actualizarBitacoraNotificacionSIAJOP($idRegistroBitacora,$resultado,(string)$cXML->datosComplementarios[0],0,bE($response),$idWS);
			
		}
		catch(Exception $e)
		{
			
			@actualizarBitacoraNotificacionSIAJOP($idRegistroBitacora,0,$e->getMessage(),1,bE($response),$idWS);
			
			
			
		}		
			
	}
	
	function reportarAudienciaSiajopSIUGJ($idEvento,$formato=1)
	{
		global $con;
		$consulta="SELECT * FROM 7000_eventosAudiencia WHERE  idRegistroEvento=".$idEvento;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
	
		$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
		$fDatosCarpetaJudicial=$con->obtenerPrimeraFila($consulta);
		$carpetaAdministrativa=$fDatosCarpetaJudicial[0];
		if($carpetaAdministrativa=="")
		{
			return true;
		}
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		
		if(($fDatosCarpetaJudicial[1]!=-1)&&($fDatosCarpetaJudicial[1]!=""))
			$consulta.=" and idCarpeta=".$fDatosCarpetaJudicial[1];
			
		$idActividad=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
		$res=$con->obtenerFilas($consulta);
		
		$arrJueces="";
		while($fJuez=$con->fetchRow($res))
		{
			//$fJuez[0]=4065;
			$o='<id_judge>'.$fJuez[0].'</id_judge>';
			$arrJueces.=$o;
		}
	
		$arrParticipantes="";    
		$consulta="SELECT (CONCAT(IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno),
	' ',IF(nombre IS NULL,'',nombre))) AS participante,r.idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idFiguraJuridica IN(2,4,1) AND p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=".$idActividad;
			//echo $consulta;
		$rParticipantes=$con->obtenerFilas($consulta);		
		while($fParticipante=$con->fetchRow($rParticipantes))
		{
	
			$o='<participant participantType="'.$fParticipante[1].'" protectedWitness="0">'.cv(str_replace('"','',$fParticipante[0])).'</participant>';
			$arrParticipantes.=$o;
		}
		
		
	
		//$carpetaAdministrativa="1010";
		//$fRegistro["idCentroGestion"]=54;
		$xml="";
		if($formato==1)
		{
			$xml='<?xml version="1.0" encoding="utf-8" ?>
					<siajop>
						<audience id="'.$idEvento.'" status="1" isVirtual="0">
							<id_audience_type>'.$fRegistro["tipoAudiencia"].'</id_audience_type>
							<expedient>'.$carpetaAdministrativa.'</expedient>
							<id_management_unit>'.$fRegistro["idCentroGestion"].'</id_management_unit>
							<id_offense>1</id_offense>
							<id_room>'.$fRegistro["idSala"].'</id_room>
							<recording_date>'.date("d/m/Y",strtotime($fRegistro["horaInicioEvento"])).'</recording_date>
							<recording_time>'.date("H:i:s",strtotime($fRegistro["horaInicioEvento"])).'</recording_time>
							<judges> 
								   '.$arrJueces.'
							</judges>
							<participants>						
								'.$arrParticipantes.'
							</participants>
							<telepresence></telepresence>
							<diligence></diligence>
						</audience>
					</siajop>';
		}
		else
		{
			$xml='<audience id="'.$idEvento.'" status="1">
					  <id_audience_type>'.$fRegistro["tipoAudiencia"].'</id_audience_type>
					  <expedient>'.$carpetaAdministrativa.'</expedient>
					  <id_management_unit>'.$fRegistro["idCentroGestion"].'</id_management_unit>
					  <id_room>'.$fRegistro["idSala"].'</id_room>
					  <recording_date>'.date("d/m/Y",strtotime($fRegistro["horaInicioEvento"])).'</recording_date>
					  <recording_time>'.date("H:i:s",strtotime($fRegistro["horaInicioEvento"])).'</recording_time>
					  <judges> 
							 '.$arrJueces.'
					  </judges>
					  <participants>						
						  '.$arrParticipantes.'
					  </participants>
				  </audience>';
		}
		if(($fRegistro["situacion"]==3)||($fRegistro["situacion"]==6))
			$xml=str_replace('status="1"','status="0"',$xml);
		
		return $xml;
	}
	

function notificarActualizacionCatalogoSIAJOPSIUGJ($idCatalogo,$direccionIP)
{
	global $con;
	$idWS=1000;
	$urlWebServices="";
	$xml=obtenerInformacionCatalogoSiugj($idCatalogo);
	
	$idRegistroBitacora=registrarBitacoraNotificacionOperadores(bE($xml),1,1,$idWS);
	$response="";
	
	try
	{
		
		
		
		$urlWebServices="http://".$direccionIP.":8080/ServiceSIAJOP.asmx";
		$client = new nusoap_client($urlWebServices."?wsdl","wsdl");
		$parametros=array();
		$parametros["xml"]=$xml;
		echo $xml;
		$response = $client->call("SynchronizationCatalogs", $parametros);
		
		$response=($response["SynchronizationCatalogsResult"]);
		$cXML=simplexml_load_string($response);	
		$resultado=(string)$cXML->resultado[0];

		actualizarBitacoraNotificacionOperadores($idRegistroBitacora,$resultado,(string)$cXML->datosComplementarios[0],bE($response));
		
	}
	catch(Exception $e)
	{
		actualizarBitacoraNotificacionOperadores($idRegistroBitacora,0,$e->getMessage(),bE($response));
		
		
		
	}		
		
}


function obtenerInformacionCatalogoSiugj($idCatalogo)
{
	global $con;
	
	$xmlRespuesta="<?xml version=\"1.0\" encoding=\"utf-8\"?><siajop><catalog_type>".$idCatalogo."</catalog_type><records>";
	
	switch($idCatalogo)
	{
		case 1: //Audiencias
			$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'">'.cv($fila[1]).'</record>';
				$xmlRespuesta.=$oXML;	
			}
		
		break;
		case 2: //Jueces
			$consulta="SELECT usuarioJuez,clave,u.Nombre FROM _26_tablaDinamica j,800_usuarios u WHERE u.idUsuario=j.usuarioJuez";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'"  judgeCode="'.$fila[1].'" status="1">'.cv($fila[2]).'</record>';
				$xmlRespuesta.=$oXML;	
			}
		
		break;
		case 3: //UGJ
			$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'" unitCode="'.$fila[1].'">'.cv($fila[2]).'</record>';
				$xmlRespuesta.=$oXML;	
			}
		
		break;
		case 4: //Salas
			$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica WHERE idReferencia 
					IN(SELECT idReferencia FROM _17_tablaDinamica WHERE cmbCategoria=1)";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'">'.cv($fila[1]).'</record>';
				$xmlRespuesta.=$oXML;	
			}
		
		break;
		case 5: //Tipos de participantes
			$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'">'.cv($fila[1]).'</record>';
				$xmlRespuesta.=$oXML;	
			}
		
		break;
		case 6: //Motivos de pausa
		
			$oXML='<record id="1">Receso</record><record id="2">Cambio de sala</record><record id="3">Fallas técnicas</record><record id="4">Otros</record>';
			$xmlRespuesta.=$oXML;	
		
			/*$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'">'.cv($fila[1]).'</record>';
				$xmlRespuesta.=$oXML;	
			}*/
		
		break;
		case 7: //Telepresncias
		
			$oXML='<record id="1">Reclusorio Norte</record><record id="2">Reclusorio Sur</record><record id="3">Reclusorio Oriente</record><record id="4">Santa Martha</record>';
			$xmlRespuesta.=$oXML;	
		
			/*$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$oXML='<record id="'.$fila[0].'">'.cv($fila[1]).'</record>';
				$xmlRespuesta.=$oXML;	
			}*/
		
		break;
	}
	$xmlRespuesta.="</records></siajop>";
	return $xmlRespuesta;
	
}

function notificarCancelacionEventoAudienciaSIAJOPSIUGJ($idEvento)
{
	global $con;
	$direccionIP="189.211.178.198";
	$idRegistroBitacora=registrarBitacoraNotificacionSIAJOP($idEvento);
	$response="";
	$idWS=100;
	try
	{
		$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
		$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
		$idWS=$fDatosEvento["idEdificio"]*10;
		
		$xml=reportarAudienciaSiajop($idEvento);
		
		$xml=str_replace('status="1"','status="0"',$xml);
		$urlWebServices="http://".$direccionIP.":8080/ServiceSIAJOP.asmx";
		$client = new nusoap_client($urlWebServices."?wsdl","wsdl");
		$parametros=array();
		$parametros["xml"]=$xml;
		
		$response = $client->call("SynchronizationAudience", $parametros);
		

		$response=$response["SynchronizationAudienceResult"];
		
		$cXML=simplexml_load_string($response);	
		$resultado=(string)$cXML->resultado[0];
		
		actualizarBitacoraNotificacionSIAJOP($idRegistroBitacora,$resultado,(string)$cXML->datosComplementarios[0],0,bE($response),$idWS);
		
	}
	catch(Exception $e)
	{
		
		actualizarBitacoraNotificacionSIAJOP($idRegistroBitacora,0,$e->getMessage(),1,bE($response),$idWS);
		
		
		
	}		
		
}

function obtenerCarpetaAdministrativaActuacion($idFormulario,$idRegistro)
{
	global $con;
	$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	
	return "'".$carpetaAdministrativa."'";
}


function obtenerDocumentoPrincipalProvidencia($idFormulario,$idRegistro)
{
	global $con;
	
	$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
	$providenciaAplicar=$con->obtenerValor($consulta);
	
	$consulta="SELECT plantillaAsociada FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
	$plantillaAsociada=$con->obtenerValor($consulta);
	
	
	return "'".$plantillaAsociada."'";
	
	
}


function obtenerAutoAdmiteImpedimento($idFormulario,$idRegistro)
{
	global $con;
	
	$consulta="SELECT carpetaAdministrativa2aInstancia FROM _952_tablaDinamica WHERE id__952_tablaDinamica=".$idRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoProceso=$con->obtenerValor($consulta);
	
	switch($tipoProceso)
	{
		case 19:
			return "'691'";
		break;
		default:
			return "'645'";
		break;
	}
	
}

function obtenerAutoRechazoImpedimento($idFormulario,$idRegistro)
{
	global $con;
	
	$consulta="SELECT carpetaAdministrativa2aInstancia FROM _952_tablaDinamica WHERE id__952_tablaDinamica=".$idRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoProceso=$con->obtenerValor($consulta);
	
	switch($tipoProceso)
	{
		case 1:
		case 3:
		case 4:
		case 5:
		case 6:
		case 20:
			return "'542'";
		break;
		case 19:
			return "'692'";
		break;
		default:
			return "'658'";
		break;
	}
	
}

function esProcesoJudicialRecursoRevision($idFormulario,$idRegistro)
{
	global $con;
	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
	
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoProceso=$con->obtenerValor($consulta);
	
	return $tipoProceso==19?1:0;
	
}

function obtenerCarpetaAdministrativaProcesoSIUGJ($idFormulario,$idRegistro)
{
	global $con;	
	$carpetaAdministrativa="";
	$nombreTablaBase="_".$idFormulario."_tablaDinamica";
	
	$campoLlave="id_".$nombreTablaBase;
	if($idFormulario==0)
	{
		return "";
	}
	else
	{
		if($idFormulario<0)
		{
			$consulta="SELECT nombreTabla,campoLlave FROM 900_formulariosVirtuales WHERE idFormulario=".abs($idFormulario);

			$fFormularioVirtual=$con->obtenerPrimeraFila($consulta);

			$nombreTablaBase=$fFormularioVirtual[0];
			$campoLlave=$fFormularioVirtual[1];
			if($nombreTablaBase=="")
				return "";
		}
	}
	
	$campoCarpetaAdminsitrativa="";
	if($con->existeCampo("carpetaAdministrativa",$nombreTablaBase))
	{
		$campoCarpetaAdminsitrativa="carpetaAdministrativa";
	}
	else
	{
		if($con->existeCampo("carpetaAdministrativaActuacionesIntervinientes",$nombreTablaBase))
		{
			$campoCarpetaAdminsitrativa="carpetaAdministrativaActuacionesIntervinientes";
		}
		else
		{
			if($con->existeCampo("idCarpetaAdministrativa",$nombreTablaBase))
			{
				$campoCarpetaAdminsitrativa="idCarpetaAdministrativa";
			}
			else
			{
				if($con->existeCampo("carpetaAministrativaOrdenNotificacion",$nombreTablaBase))
				{
					$campoCarpetaAdminsitrativa="carpetaAministrativaOrdenNotificacion";
				}
			}
		}
	}
	
	if($campoCarpetaAdminsitrativa!="")
	{
		$consulta="select ".$campoCarpetaAdminsitrativa." from ".$nombreTablaBase." where ".$campoLlave."=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		
		
		
	}
	
	if($carpetaAdministrativa=="")
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
	}
	
	return $carpetaAdministrativa;
}


function obtenerCarpetaAdministrativaProcesoSIUGJTableroControl($idFormulario,$idRegistro)
{
	global $con;	
	$carpetaAdministrativa="";
	$nombreTablaBase="_".$idFormulario."_tablaDinamica";
	
	$campoLlave="id_".$nombreTablaBase;
	if($idFormulario==0)
	{
		return "";
	}
	else
	{
		if($idFormulario<0)
		{
			$consulta="SELECT nombreTabla,campoLlave FROM 900_formulariosVirtuales WHERE idFormulario=".abs($idFormulario);

			$fFormularioVirtual=$con->obtenerPrimeraFila($consulta);

			$nombreTablaBase=$fFormularioVirtual[0];
			$campoLlave=$fFormularioVirtual[1];
			if($nombreTablaBase=="")
				return "";
		}
	}
	
	$campoCarpetaAdminsitrativa="";
	if($con->existeCampo("carpetaAdministrativa",$nombreTablaBase))
	{
		$campoCarpetaAdminsitrativa="carpetaAdministrativa";
	}
	else
	{
		if($con->existeCampo("carpetaAdministrativaActuacionesIntervinientes",$nombreTablaBase))
		{
			$campoCarpetaAdminsitrativa="carpetaAdministrativaActuacionesIntervinientes";
		}
		else
		{
			if($con->existeCampo("idCarpetaAdministrativa",$nombreTablaBase))
			{
				$campoCarpetaAdminsitrativa="idCarpetaAdministrativa";
			}
			else
			{
				if($con->existeCampo("carpetaAministrativaOrdenNotificacion",$nombreTablaBase))
				{
					$campoCarpetaAdminsitrativa="carpetaAministrativaOrdenNotificacion";
				}
			}
		}
	}
	
	if($campoCarpetaAdminsitrativa!="")
	{
		$consulta="select ".$campoCarpetaAdminsitrativa." from ".$nombreTablaBase." where ".$campoLlave."=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		
		
		
	}
	
	if($carpetaAdministrativa=="")
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
	}
	
	return "'".$carpetaAdministrativa."'";
}




function permiteObservarDocumento($idDocumento)
{
	return true;
}

function registrarCambioSituacionCarpetaSIUGJ($carpeta,$etapaActual,$idFormulario,$idRegistro,$idEvento,$comentarios="",$idCarpeta=-1)
{
	global $con;
	
	
	$consulta="SELECT situacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";
	if($idCarpeta!=-1)
		$consulta.=" and idCarpeta=".$idCarpeta;

	$situacion=$con->obtenerValor($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="INSERT INTO 7015_bitacotaCambioSituacionCarpetaAdministrativa(carpetaAdministrativa,fechaCambio,
				idEstadoAnterior,idEstadoActual,responsableCambio,idFormulario,idRegistro,idEventoAudiencia,
				comentariosAdiciones,idCarpeta)
			VALUES('".$carpeta."','".date("Y-m-d H:i:s")."',".$situacion.",".$etapaActual.",".$_SESSION["idUsr"].
			",".$idFormulario.",".$idRegistro.",".$idEvento.",'".cv($comentarios)."',".$idCarpeta.")";

	$x++;
	
	$query[$x]="UPDATE 7006_carpetasAdministrativas SET situacion=".$etapaActual." WHERE carpetaAdministrativa='".$carpeta."'";
	if($idCarpeta!=-1)
		$query[$x].=" and idCarpeta=".$idCarpeta;
	
	
		
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	return $con->ejecutarBloque($query);
	
}


function registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpeta,$movimiento,$tMovimiento)
{
	global $con;
	
	$arrExpediente=obtenerCarpetaRaiz($carpetaAdministrativa,$idCarpeta);
	
	$consulta="INSERT  INTO 7006_movimientosCarpetasAdministrativas(carpetaAdmnistrativa,idCarpeta,idResponsable,
				fechaOperacion,movimiento,idTipoMovimiento,carpetaAdministrativaRaiz,idCarpetaAdministrativaRaiz)
				VALUES('".$carpetaAdministrativa."',".$idCarpeta.",".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s").
				"','".cv($movimiento)."',".$tMovimiento.",'".$arrExpediente["carpetaAdministrativa"].
				"',".($arrExpediente["idCarpeta"]==""?-1:$arrExpediente["idCarpeta"]).")";

	return $con->ejecutarConsulta($consulta);
}

function obtenerCarpetaRaiz($carpetaAdministrativa,$idCarpeta)
{
	$arrCarpeta=array();
	global $con;
	
	$consulta="SELECT carpetaAdministrativaBase,idCarpetaAdministrativaBase,tipoCarpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	if($idCarpeta!=-1)
		$consulta.=" AND idCarpeta=".$idCarpeta;
	
	$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
	if($fCarpeta["carpetaAdministrativaBase"]=="")
	{
		if($fCarpeta["tipoCarpetaAdministrativa"]==0)
		{
			$consulta="SELECT carpetaAdministrativaBase as carpetaAdministrativa,idCarpetaBase as idCarpeta FROM 7006_carpetasAdministrativasRelacionadas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'
					AND idCarpeta=".$idCarpeta;
			$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);

		}
		else
		{
			$fCarpeta["carpetaAdministrativa"]=$carpetaAdministrativa;
			$fCarpeta["idCarpeta"]=$fCarpeta["idCarpeta"];
			
		}
		return $fCarpeta;
	}
	else
	{
		return obtenerCarpetaRaiz($fCarpeta["carpetaAdministrativaBase"],$fCarpeta["idCarpetaAdministrativaBase"]);
	}
	
}

function obtenerAuxiliarJudicialAsignado($idFormulario,$idRegistro)
{
	global $con;
	
	
	$consulta="SELECT j.idUsuario FROM _1194_tablaDinamica a,_1177_tablaDinamica j WHERE a.idReferencia=".$idRegistro."
				AND j.id__1177_tablaDinamica=a.auxiliarJusticia";
	$idUsuario=$con->obtenerValor($consulta);
	return "'".$idUsuario."'";			
}


function obtenerDocumentacionRequeridaRegistroDocumentos($idFormulario,$idRegistro,$idFormularioProceso,$sL=false)
{
		global $con;
		
		$arrRegistros="";
		if($sL)
		{
			$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$documentoDigital="";
				$tamano=0;
				if($fila["idDocumento"]!="")
				{
					$consulta="SELECT nomArchivoOriginal,tamano FROM 908_archivos WHERE idArchivo=".$fila["idDocumento"];
					$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
					$nombreDocumento=$fDatosDocumento["nomArchivoOriginal"];
					$documentoDigital=$nombreDocumento."|".$fila["idDocumento"];
					$tamano=$fDatosDocumento["tamano"];
				}
				
								
				
				$obligatorio=0;
				$oReg="['".$fila["idRegistro"]."','".cv($fila["idTipoDocumento"])."',true,'".cv($documentoDigital)."','".$obligatorio."','".$tamano."']";
				if($arrRegistros=="")
					$arrRegistros=$oReg;
				else
					$arrRegistros.=",".$oReg;
			}
			return "[".$arrRegistros."]";
		}
		
		
		$consulta="SELECT '-1' AS idRegistro,d.tipoDocumento AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatorio AS obligatorio,
					d.funcionAplicacion FROM 3025_documentosPermitidosRegistro d,908_categoriasDocumentos c
					WHERE d.idFormularioProceso=".$idFormularioProceso." AND c.idCategoria=d.tipoDocumento ORDER BY c.nombreCategoria";	
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT * FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
					" and idTipoDocumento=".$fila["idDocumento"];

			$fRegistroDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
			$iRegistro=-1;
			$presentaDocumento=0;
			$documentoDigital="";
			if($fRegistroDocumento)
			{
				$iRegistro=$fRegistroDocumento["idRegistro"];
				$presentaDocumento=1;
				$documentoDigital=$fRegistroDocumento["idDocumento"];
				if($fRegistroDocumento["idDocumento"]!="")
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistroDocumento["idDocumento"];
					$nombreDocumento=$con->obtenerValor($consulta);
					$documentoDigital=$nombreDocumento."|".$documentoDigital;
				}
			}
			
			
			$oReg="['".$iRegistro."','".cv($fila["idDocumento"])."',".($presentaDocumento==1?"true":"false").",'".cv($documentoDigital)."','".$fila["obligatorio"]."']";
			if($arrRegistros=="")
				$arrRegistros=$oReg;
			else
				$arrRegistros.=",".$oReg;
		
		}
		
		
		return "[".$arrRegistros."]";
		
		
	}
	
	
	function generarFolioPublicaciones($idFormulario,$idRegistro)
	{
		global $con;
		
		$anio=date("Y");
		
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="select folioActual FROM 7003_administradorFoliosProcesos WHERE idFormulario=".$idFormulario." AND anio=".$anio." for update";
	
			$folioActual=$con->obtenerValor($query);
			if($folioActual=="")
			{
				$folioActual=1;				
				$query="INSERT INTO 7003_administradorFoliosProcesos(idFormulario,anio,folioActual) VALUES(".$idFormulario.",".$anio.",".$folioActual.")";
				
			}
			else
			{
				$folioActual++;
				$query="update 7003_administradorFoliosProcesos set folioActual=".$folioActual." where idFormulario=".$idFormulario." and anio=".$anio;
			}
				
			if($con->ejecutarConsulta($query))
			{
				$query="commit";
				$con->ejecutarConsulta($query);
				
				return str_pad($folioActual,5,"0",STR_PAD_LEFT);
			}
		}
		
		return 0;
		
	}
	
	function modificarFechaPublicacionNotificacion($idRegistro,$cadObj)
	{
		global $con;
	
		$obj=json_decode(bD($cadObj));
		
		
		
		$consulta="INSERT INTO 3505_fechaPublicacionModificaciones(iFormulario,iRegistro,fechaOriginal,fechaActual,motivoCambio,fechaCambio,responsableCambio)
					VALUES(".$obj->iFormulario.",".$idRegistro.",'".$obj->fechaOriginal."','".$obj->fechaActual."','".cv($obj->motivoCambio)."','".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].")";
		return $con->ejecutarConsulta($consulta);
		
		
	}
	
	function sendMensajeEnvioTwilio($arrDestinatario,$asunto,$mensaje,$emisor="",$nombreEmisor="",$arrArchivos=null,$arrCopiaOculta=null,$arrCopia=null)
	{
		global $habilitarEnvioCorreo;
		global $mailAdministrador;
		global $nombreEmisorAdministrador;
		global $SO;
		global $urlSitio;
		global $con;
		global $versionLatis;
		
		$consulta="SELECT mailDefaultSalida FROM 903_variablesSistema";

		$mailDefaultSalida=$con->obtenerValor($consulta);
		$consulta="SELECT hostSMTP,puertoSMTP,autenticacionSMTP,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis)."')as contrasena 
					FROM 805_configuracionMailSMTP WHERE idRegistro=".$mailDefaultSalida;
		$fDatosMail=$con->obtenerPrimeraFilaAsoc($consulta);

		/*if(!$habilitarEnvioCorreo)
			return true;*/
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00002/2023'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$urlWebServices=$fRegistro["urlConexion"];

		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}

		$arrMails="";
		foreach($arrDestinatario as $destinatario)
		{
			
			if($destinatario[0]!="")
			{
				$oMail='{"email":"'.$destinatario[0].'","name":"'.$destinatario[0].'"}';
				if($arrMails=="")
					$arrMails=$oMail;
				else
					$arrMails.=",".$oMail;
			}
		}

		
		$attachment="";
		$arrAdjuntos="";
		if(sizeof($arrArchivos)>0)
		{
			$nArchivos=sizeof($arrArchivos);
			for($x=0;$x<$nArchivos;$x++)
			{
				$oAdjunto='{"content": "'.bE(leerContenidoArchivo($arrArchivos[$x][0])).'", "type": "application/octet-stream", "filename": "'.$arrArchivos[$x][1].'"}';
				if($arrAdjuntos=="")
					$arrAdjuntos=$oAdjunto;
				else
					$arrAdjuntos.=",".$oAdjunto;
				$attachment=',"attachments": ['.$arrAdjuntos.']';    
			}
		}
		
		
		$objCadena='{"personalizations":[{"to":['.$arrMails.'],"subject":"'.cv($asunto).'"}],"content": [{"type": "text/html", "value": "'.str_replace("\\'","'",cv($mensaje)).'"}],"from":{"email":"'.$fDatosMail["mail"].'","name":"'.$nombreEmisor.'"}'.$attachment.'}';
		$curl = curl_init();

		curl_setopt_array($curl, array
		(
		  CURLOPT_URL => $urlWebServices,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$objCadena,
		  CURLOPT_HEADER=> 1,
		  CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer '.$arrParametros["Bearer"]["valor"],
			'Content-Type: application/json'
		  ),
		));
		
		$response = curl_exec($curl);
		
		$headers = curl_getinfo($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$body = substr($response, $header_size);
		
		
		curl_close($curl);
		if($headers["http_code"]=="202")
		{
			return true;
		}
		
		$objRespuesta=json_decode($body);
		if(isset($_SESSION) && isset($_SESSION["resultadoEnvioCorreo"]))                     
		{
			$_SESSION["resultadoEnvioCorreo"]=$objRespuesta->errors[0]->message;
		}
		return false;

			
	}
	
	function headersToArray( $str )
	{
		$headers = array();
		$headersTmpArray = explode( "\r\n" , $str );
		for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
		{
			// we dont care about the two \r\n lines at the end of the headers
			if ( strlen( $headersTmpArray[$i] ) > 0 )
			{
				// the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
				if ( strpos( $headersTmpArray[$i] , ":" ) )
				{
					$headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
					$headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
					$headers[$headerName] = $headerValue;
				}
			}
		}
		return $headers;
	}
	
	
	function cerrarExpedienteCompensacion($idFormulario,$idRegistro,$carpetaAdministrativa,$despacho,$compenzar=false,$comentariosAdicionales="")
	{
		global $con;
		global $versionLatis;
		
		
		$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND unidadGestion='".$despacho."'";
		$idCarpeta=$con->obtenerValor($consulta);
		registrarCambioSituacionCarpetaSIUGJ($carpetaAdministrativa,3,$idFormulario,$idRegistro,-1,"",-1);
		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpeta,
		"Cierre de Proceso Judicial.<br><br>Comentarios Adicionales: ".($comentariosAdicionales==""?"(Sin comentarios)":$comentariosAdicionales),8);
		
		if($compenzar)
		{
			$x=0;
			$query[$x]="begin";
			$x++;
			$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND unidadGestion='".$despacho."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fRegistro)
			{		
				$consulta="SELECT * FROM 7001_asignacionesObjetos WHERE idFormulario=".$fRegistro["idFormulario"]." AND idRegistro=".$fRegistro["idRegistro"];
				$fAsignacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				
				
				if($fAsignacion)
				{
					$query[$x]="UPDATE 7001_asignacionesObjetos SET situacion=20 WHERE idAsignacion=".$fAsignacion["idAsignacion"];
					$x++;
					
					
					$query[$x]="INSERT INTO 7001_asignacionesObjetos(idFormulario,idRegistro,idObjetoReferido,idUnidadReferida,
								fechaAsignacion,tipoRonda,noRonda,situacion,rondaPagada,comentariosAdicionales,tipoAsignacion,
								idAsignacionPagada,objParametros) values (".$fAsignacion["idFormulario"].",".$fAsignacion["idRegistro"].
								",'".$fAsignacion["idObjetoReferido"]."',
								'".$fAsignacion["idUnidadReferida"]."','".date("Y-m-d H:i:s")."','".$fAsignacion["tipoRonda"]."',
								'".$fAsignacion["noRonda"]."',2,'".$fAsignacion["rondaPagada"]."',HEX(AES_ENCRYPT('".$comentariosAdicionales.
								"', '".bD($versionLatis)."')),'".$fAsignacion["tipoAsignacion"]."',HEX(AES_ENCRYPT('".$fAsignacion["idAsignacion"].
								"', '".bD($versionLatis)."')),'".
								$fAsignacion["objParametros"]."')";
					$x++;
					
				}
			
			}
			
			$query[$x]="commit";
			$x++;

			return $con->ejecutarBloque($query);
			
			
		}
		
		
		
	}
	
	
	function aperturarProcesoJudicial($idFormulario,$idRegistro,$carpetaAdministrativa,$despacho,$comentariosAdicionales="")
	{
		global $con;
		
		if($comentariosAdicionales=="")
			$comentariosAdicionales="(Sin comentarios)";	
		
		$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND unidadGestion='".$despacho."'";
		$idCarpeta=$con->obtenerValor($consulta);
		
		
		registrarCambioSituacionCarpetaSIUGJ($carpetaAdministrativa,1,$idFormulario,$idRegistro,-1,"",-1);
		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpeta,"Reapertura de Proceso Judicial.<br><br>Comentarios Adicionales: ".$comentariosAdicionales,9);
		return $con->ejecutarConsulta($consulta);
	}
	

?>