<?php include_once("conexionBD.php");
include_once("numeroToLetra.php");

	function registrarUnidadOrganigrama($idFormulario,$idRegistro,$printRefresh=true)
	{
		global $con;
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="";
		switch($idFormulario)
		{
			case 1:
				$consulta="SELECT unidadPadre,nombreInmueble as nombreUnidad,claveUnidad as cveUnidad,cveInmueble as cveRegistro,tipoUnidad FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idRegistro;
			break;
			case 17:
				$consulta="SELECT unidadPadre,nombreUnidad as nombreUnidad,claveUnidad as cveUnidad,claveRegistro as cveRegistro,tipoUnidad, consecReparto as consec FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idRegistro;
			break;
			case 992:
				$consulta="SELECT unidadPadre,nombreSala as nombreUnidad,claveUnidad as cveUnidad,cveSala as cveRegistro,tipoUnidad FROM _992_tablaDinamica WHERE id__992_tablaDinamica=".$idRegistro;
			break;	
		}
		
		$fila=$con->obtenerPrimeraFilaAsoc($consulta);
		if(($fila["cveUnidad"]=="")||($fila["cveUnidad"]=="N/E"))
		{
			$consulta="SELECT MAX(codigoIndividual) FROM 817_organigrama WHERE unidadPadre='".$fila["unidadPadre"]."'";
			$maxCodigo=$con->obtenerValor($consulta);
			if(($maxCodigo=="")||($maxCodigo=="0"))
				$maxCodigo=1;
			else
				$maxCodigo++;
			
			$codigoIndividual=str_pad($maxCodigo,4,"0",STR_PAD_LEFT);
			$codigo=$fila["unidadPadre"].$codigoIndividual;
			$fila["cveUnidad"]=$codigo;
			$query[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,
						codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,responsableCreacion,STATUS,instColaboradora)
						VALUES('".cv($fila["nombreUnidad"])."','".$codigo."','".$codigo."','',".$fila["tipoUnidad"].",'','".$fila["unidadPadre"].
						"','".$codigoIndividual."','','".cv($fila["cveRegistro"])."','".$_SESSION["codigoInstitucion"]."','".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].",1,1)";
			$x++;
			
			$query[$x]="select @idOrganigrama:=(select last_insert_id())";
			$x++;
			
			$query[$x]="UPDATE _".$idFormulario."_tablaDinamica SET claveUnidad='".$fila["cveUnidad"]."' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$x++;
			if($idFormulario==992)
			{
				$corporacion=substr($fila["unidadPadre"],0,strlen($fila["unidadPadre"])-4);
				$query[$x]="UPDATE _".$idFormulario."_tablaDinamica SET corporacion='".$corporacion."' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$x++;
			}
			
		}
		else
		{
			
			$query[$x]="UPDATE 817_organigrama SET unidad='".cv($fila["nombreUnidad"])."',codigoDepto='".cv($fila["cveRegistro"])."',claveDepartamental='".cv($fila["cveRegistro"]).
						"' WHERE codigoUnidad='".$fila["cveUnidad"]."'";
			$x++;
			$query[$x]="set @idOrganigrama:=(select idOrganigrama FROM 817_organigrama WHERE codigoUnidad='".$fila["cveUnidad"]."')";
			$x++;
			
		}

		//JL 17-05-2023: Se incorpora seteo de consecutivo inicial
		if(($idFormulario=17)&&(isset($fila["consec"])))
		{
			//Parametros, TODO: validar uso de tipo carpeta
			$anioActual=date("Y");
			$tipoCarpeta=0;
			$consulta="SELECT folioActual FROM 7004_seriesUnidadesGestion WHERE idunidadGestion='".$fila["cveUnidad"]."' AND anio=".$anioActual." and tipoDelito='".$tipoCarpeta."'";
			$folioActual=$con->obtenerValor($consulta);
			if(($folioActual=="")&&($fila["consec"]>1))
			{
				//Creamos consecutivo
				$query[$x]="INSERT INTO 7004_seriesUnidadesGestion(idUnidadGestion,anio,folioActual,tipoDelito) VALUES('".$fila["cveUnidad"].
						"',".$anioActual.",".($fila["consec"]-1).",'".$tipoCarpeta."')";
				$x++;

			}
			elseif($folioActual<($fila["consec"]-1))
			{
				//Actualizamos consecutivo
				$query[$x]="update 7004_seriesUnidadesGestion set folioActual=".($fila["consec"]-1)." where idUnidadGestion='".$fila["cveUnidad"].
						"' and anio=".$anioActual." and tipoDelito='".$tipoCarpeta."'";
				$x++;

			}
		}
		
		
		$query[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($query))
		{
			
			$consulta="select @idOrganigrama";
			$idOrganigrama=$con->obtenerValor($consulta);
			if($printRefresh)
				echo "window.parent.parent.invocarEjecucionFuncionIframe('frameContenido','recargarOrganigrama','\'".$fila["cveUnidad"]."\',\'".$idOrganigrama."\'');";
			return true;
		}
		
	}
	
	
	function asignarDespachoAsunto($idFormulario,$idRegistro)
	{
		global $con;
		
		
		$_SESSION["funcionCargaProceso"]="obtenerAcuseRadicacion()";
		$_SESSION["funcionCargaUnicaProceso"]=1;
		$_SESSION["funcionRetrasoCargaProceso"]=1000;
	

		$consulta="SELECT * FROM _632_tablaDinamica WHERE id__632_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$cuantiaProceso=$fRegistro["cuantiaProceso"];
		$etapaContinuacion="2.1";
		
		if(($fRegistro["carpetaAdministrativa"]!="N/E")&&($fRegistro["carpetaAdministrativa"]!=""))
		{
			cambiarEtapaFormulario($idFormulario,$idRegistro,$etapaContinuacion,"",-1,"NULL","NULL",1206);
			return true;
		}
		
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
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
						VALUES('".$carpetaAdministrativa."','".$fechaCarpetaJudicial."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',1,".$idActividad.",'',".$fDatosCarpeta[2].",'".$cveDespacho."',".$fRegistro["especialidad"].",".
						$fRegistro["tipoProceso"].",".$fRegistro["claseProceso"].",".$fRegistro["subClaseProceso"].
						",".$fRegistro["temaProceso"].",".$fRegistro["subTemaProceso"].")";
		$x++;
		
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa='".$carpetaAdministrativa.
					"',codigoInstitucion='".$cveDespacho."',despachoAsignado='".$cveDespacho.
					"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$x++;
		if(existeRol("'23_0'"))
		{
			$consulta[$x]="UPDATE _632_tablaDinamica SET fechaRecepcionDemanda='".date("Y-m-d")."',horaRecepcionDemanda='".date("H:i:s").
						"' WHERE id__632_tablaDinamica=".$idRegistro;
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
	
			$query="SELECT documentoAdjunto,idDocumento FROM _632_documentacionRequerida WHERE idReferencia=".$idRegistro;
	
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				convertirDocumentoUsuarioDocumentoResultadoProceso($fDocumento[0],$idFormulario,$idRegistro,"",$fDocumento[1]);
			}
			
			
			cambiarEtapaFormulario($idFormulario,$idRegistro,$etapaContinuacion,"",-1,"NULL","NULL",1206);
			return true;
	
		}
		return false;
		
	}
	
	
	function obtenerSiguienteCodigoUnicoProceso($idUnidadGestion,$anio,$tipoCarpeta,$idFormulario,$idRegistro)
	{
		global $con;
		$tratarComoRadicacion=true;
		
		$tipoCarpeta=0;
		$consulta="SELECT * FROM _632_tablaDinamica WHERE id__632_tablaDinamica=".$idRegistro;
		$fDatosRadicacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$generarCodigoUnico=true;
		if(!$tratarComoRadicacion)
		{
			switch($tipoCarpeta)
			{
				case "1"://Radicación Inicial
					$generarCodigoUnico=true;
				break;
				case "2"://Radicación Segunda Instancia
				case "3"://Registro de Casación
				case "4"://Revisión de Expediente
						$generarCodigoUnico=false;
				break;
			}
			
		}
		
		$agregarSecuencia=false;
		if($generarCodigoUnico)
		{
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
			$formatoCarpeta= $fRegistroUnidad[0]."-".$anio."[folioCarpeta]";
			$formatoCarpeta.="00";
			
			
			
			$carpetaAdministrativa=str_replace("[folioCarpeta]",str_pad($folioCorreccion,5,"0",STR_PAD_LEFT),$formatoCarpeta);
			while(existeCarpetaAdministrativa($carpetaAdministrativa,""))
			{
				$folioCorreccion++;	
				$carpetaAdministrativa=str_replace("[folioCarpeta]",str_pad($folioCorreccion,5,"0",STR_PAD_LEFT),$formatoCarpeta);
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
		else
		{
			$procesoJudicialOrigen=substr($fDatosRadicacion["procesoJudicialOrigen"],0,strlen($fDatosRadicacion["procesoJudicialOrigen"])-2);
			$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa LIKE 
						'".$procesoJudicialOrigen."%' ORDER BY carpetaAdministrativa DESC";
			$ultimoProceso=$con->obtenerValor($consulta);
			$maxValor=substr($ultimoProceso,strlen($fDatosRadicacion["procesoJudicialOrigen"])-2,2);
			
			$folioCorreccion=($maxValor*1)+1;
			
			$folioCorreccion=$folioActual-5;
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
		
		
		
	}
		
	function registrarRecuperacionCodigoUnico($idUnidad,$folio,$tipoCarpeta)
	{
		global $con;
		$consulta="INSERT INTO 7048_registroRecuperacionFolio(idUnidadGestion,folioRecuperado,fechaRecuperacion,tipoCarpeta) 
				VALUES('".$idUnidad."','".$folio."','".date("Y-m-d H:i:s")."','".$tipoCarpeta."')";
		return $con->ejecutarConsulta($consulta);
	}
		
	function mostrarSeccionEdicionOficioAceptacionAcuerdo($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
	{
		global $con;
		$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";

		$documentoBloqueado=$con->obtenerValor($consulta);	
		if($documentoBloqueado==1)
			return 0;
		$arrActores=array();
		$arrActores[1251]=1;
		if($con->filasAfectadas>0)
		{
			$arrActores[1252]=1;
			$arrActores[1253]=1;
			$arrActores[1254]=1;
			$arrActores[1255]=1;
			$arrActores[1256]=1;
			$arrActores[1257]=1;
		}
		
		if(isset($arrActores[$actor]))
			return 1;
		return 0;
	}
	
	function mostrarSeccionEdicionOficioRechazoAcuerdo($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
	{
		global $con;
		$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";

		$documentoBloqueado=$con->obtenerValor($consulta);	
		if($documentoBloqueado==1)
			return 0;
		$arrActores=array();
		$arrActores[1253]=1;
		
		if($con->filasAfectadas>0)
		{
			$arrActores[1252]=1;
			$arrActores[1253]=1;
			$arrActores[1254]=1;
			$arrActores[1255]=1;
			$arrActores[1256]=1;
			$arrActores[1257]=1;
		}
		if(isset($arrActores[$actor]))
			return 1;
		return 0;
	}
	
	function registrarCambioBitacoraDocumentoEdicion($idFormulario,$idRegistro)
	{
		global $con;
	
		
		$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$idRegistroDoc=$con->obtenerValor($consulta);
		if($idRegistroDoc=="")
			return true;
		$consulta="SELECT idRegistroFormato FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$idRegistroDoc;
		$idRegistroFormato=$con->obtenerValor($consulta);
		if($idRegistroFormato=="")
			return true;
		$consulta="SELECT idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$etapaActual=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario.
					" AND idRegistro=".$idRegistro." AND etapaActual=".$etapaActual." ORDER BY fechaCambio DESC";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="INSERT INTO 3000_bitacoraFormatos(idRegistroFormato,idEstadoAnterior,fechaCambio,idEstadoActual,
						responsableCambio,comentariosAdicionales)
						VALUES(".$idRegistroFormato.",".$fRegistro["etapaAnterior"].",'".$fRegistro["fechaCambio"].
						"',".$etapaActual.",".$fRegistro["idUsuarioCambio"].",'".cv($fRegistro["comentarios"])."')";
		return	$con->ejecutarConsulta($consulta);
	}
	
	function obtenerTitularPuestoProcesoJudicialDestino($idFormulario,$idRegistro,$actorDestinatario)
	{
		global $con;
		$rolActor=obtenerTituloRol($actorDestinatario);

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$arrDestinatario=array();
		$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
					r.codigoRol='".$actorDestinatario."' AND ad.Institucion='".$unidadGestion."'";
	
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$nombreUsuario=trim(obtenerNombreUsuario($fila[0]))." (".$rolActor.")";
			$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}
		
		
		
		return $arrDestinatario;
	}
	
	
	function registrarAutorizacionAccesoProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _656_tablaDinamica WHERE id__656_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$fRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="SELECT * FROM _657_tablaDinamica WHERE idReferencia=".$idRegistro;
		$fEvaluacion=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fEvaluacion)
		{
			$consulta="SELECT * FROM _658_tablaDinamica WHERE idReferencia=".$idRegistro;
			$fEvaluacion=$con->obtenerPrimeraFilaAsoc($consulta);
		}

		if($fEvaluacion)
		{
			$query[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,situacion,
					fechaInicio,unidadGestion,anioExpediente,cveMateria)
					values(".$fRegistro["responsable"].",".$fRegistroCarpeta["idCarpeta"].",'".$fRegistro["carpetaAdministrativa"]."',1,'".date("Y-m-d H:i:s").
					"','".$fRegistroCarpeta["unidadGestion"]."',".date("Y",strtotime($fRegistroCarpeta["fechaCreacion"])).
					",'".$fRegistroCarpeta["especialidad"]."')";
			$x++;
			
			
			
			if($fEvaluacion["participante"]!=0)
			{
				
				$query[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET idCuentaAcceso=".$fRegistro["responsable"].
						" WHERE idActividad=".$fRegistroCarpeta["idActividad"]." AND idParticipante=".$fEvaluacion["participante"];
				
				$x++;
			}
			else
			{
				$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idCuentaAcceso=".$fRegistro["responsable"];
				$idParticipante=$con->obtenerValor($consulta);
				
				if($idParticipante=="")
				{
					$consulta="SELECT * FROM 802_identifica WHERE idUsuario=".$fRegistro["responsable"];
					$fRegistroCta=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$arrDatos["tipoPersona"]=1;
					$arrDatos["nombre"]=$fRegistroCta["Nombre"];
					$arrDatos["apellidoPaterno"]=$fRegistroCta["Paterno"];
					$arrDatos["apellidoMaterno"]=$fRegistroCta["Materno"];
					$arrDatos["genero"]=$fRegistroCta["Genero"];

					$arrDatos["fechaNacimiento"]=$fRegistroCta["fechaNacimiento"];
					$arrDatos["tipoIdentificacion"]=$fRegistroCta["tipoIdentificacion"];
					$arrDatos["folioIdentificacion"]=$fRegistroCta["noIdentificacion"];
					$arrDatos["rfcEmpresa"]=$fRegistroCta["RFC"];
					$arrDatos["idActividad"]=$fRegistroCarpeta["idActividad"];
					$arrDatos["figuraJuridica"]=$fEvaluacion["tiposFigura"];
					$arrDatos["otraIdentificacion"]=$fRegistroCta["noIdentificacion"];
					$arrDatos["aceptaNotificacionMail"]=1;
					$arrDocumentos=NULL;
					$idParticipante=crearInstanciaRegistroFormulario(47,-1,1,$arrDatos,$arrDocumentos,-1,0);
				
					$query[$x]="INSERT INTO 7025_datosContactoParticipante(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
								colonia,codigoPostal,entidadFederativa,municipio)
								SELECT -47,-1,'".$idParticipante."' AS idParticipante,'".date("Y-m-d H:i:s")."' AS fechaCreacion,Calle,
								Numero,NumeroInt,Colonia,CP,Estado,Municipio 
								FROM 803_direcciones WHERE idUsuario=".$fRegistro["responsable"];
					$x++;
					$query[$x]="set @idDireccion:=(select last_insert_id())";
					$x++;
					$query[$x]="INSERT INTO 7025_correosElectronico(idReferencia,correo)
								SELECT @idDireccion,Mail FROM 805_mails WHERE idUsuario=".$fRegistro["responsable"];
					$x++;
					$query[$x]="INSERT INTO 7025_telefonos (idReferencia,tipoTelefono,lada,numero,extension,idPais)
								SELECT @idDireccion,Tipo2,Lada,Numero,Extension,codArea FROM 804_telefonos WHERE idUsuario=".$fRegistro["responsable"];
					$x++;
				}
				
				$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,
							situacion,idCuentaAcceso,etapaProcesal,situacionProcesal)
							VALUES(".$fRegistroCarpeta["idActividad"].",".$idParticipante.",".
							$fEvaluacion["tiposFigura"].",1,".$fRegistro["responsable"].",1,1)";	
				$x++;
				$query[$x]="set @idRelacion:=(select last_insert_id())";
				$x++;
				if($fEvaluacion["relacionadoCon"]!="")
				{
					$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion) values
								(".$fRegistroCarpeta["idActividad"].",".$idParticipante.",".$fEvaluacion["tiposFiguravch"].",".$fEvaluacion["relacionadoCon"].",1)";
					$x++;
				}
			}
			
		}
		
		$query[$x]="commit";
		$x++;
		
		return $con->ejecutarBloque($query);
	}
	
	function enviarConfirmacionCitaDiaControl($idFormulario,$idRegistro)
	{
		global $con;
		
		$datosCita="";
		
		$consulta="SELECT * FROM _662_tablaDinamica WHERE id__662_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$datosCita=convertirFechaLetra($fRegistro["fechaCita"],false,false);
		$datosCita.=" de las ".date("H:i",strtotime($fRegistro["horaInicialCita"]))." hrs. a las ".date("H:i",strtotime($fRegistro["horaFinalCita"])).
					" hrs. (Duraci&oacute;n: ".$fRegistro["duracionCita"]." minutos)";
		
		$arrParam["nombreDestinatario"]=$fRegistro["nombreMedicoEspecialista"];
		$arrParam["mailDestinatario"]=trim($fRegistro["correoElectronico"]);
		$arrParam["datosCita"]=$datosCita;
		
		return @enviarMensajeEnvio(15,$arrParam,$funcionEnvioCorreoElectronico);
	}
	
	function prepararEnvioNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		$fechaActual=strtotime(date("Y-m-d H:i:s"));
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRegistro["tipoEnvioNotificacion"]==1)
		{
			return enviarCorreoNotificacion($idFormulario,$idRegistro);
		}
		else
		{
			$fechaEnvio=strtotime($fRegistro["fechaEnvio"]." ".$fRegistro["horaEnvio"]);
			if($fechaEnvio<=$fechaActual)
			{
				return enviarCorreoNotificacion($idFormulario,$idRegistro);
			}
		}
			
	}
	
	function enviarCorreoNotificacion($idFormulario,$idRegistro)
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
		
		$consulta="SELECT o.unidad,c.idActividad,c.especialidad,idCarpeta,c.unidadGestion,c.fechaCreacion FROM 7006_carpetasAdministrativas c,
					817_organigrama o WHERE c.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros["nombreDespacho"]=$fDatosCarpetas["unidad"];
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
		
		$arrParametros["demandante"]=$demantante;
		$arrParametros["demandado"]=$demandados;
		$arrParametros["lblEnlaceDocumentos"]="";
		
		$totalDocumentos=0;
		$tabla="<table style='border-top-style:solid;border-top-width:1px;border-top-color:#999'>";
		$consulta="SELECT * FROM _665_gridDocumentosNotificar WHERE idReferencia=".$idRegistro;
		$resDest=$con->obtenerFilas($consulta);
		while($fArchivo=$con->fetchAssoc($resDest))
		{
			$paginaGetFile=$urlSitioHTTPS."modulosEspeciales_SGJ/paginasFunciones/getDocumentNotify.php";
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
			$tabla.="</table>";	
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
			if($fDestinatario["idPersona"]!="")
			{
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
			
			$arrParametros["nombreDestinatario"]=$fDestinatario["nombrePersona"];
			$arrParametros["horaEnvio"]=date("H:i");
			$arrParametros["fechaEnvio"]=convertirFechaLetra(date("Y-m-d"),false,false);
			
			$cuerpoMensajeFinal=$cuerpoMensaje;
			foreach($arrParametros as $campo=>$valor)
			{
				$cuerpoMensajeFinal=str_replace("[".$campo."]",$valor,$cuerpoMensajeFinal);
			}
			
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
				$tablaDatosAcceso="<table style='border-top-style:solid;border-top-width:1px;border-top-color:#999'>";
				$lblMensage="";
				
				switch($tipoCuentaAcceso)
				{
					case 1:
						$lblMensage="Se ha creado una cuenta de acceso al SGJ, sus datos de acceso son:";
					break;
					case 2:
						$lblMensage="A continuaci&oacute;n se le recuerdan sus datos de acceso al SGJ:";
					break;
				}
				
				$tablaDatosAcceso.="<tr><td colspan='2'>".$lblMensage."</td></tr>";
				$tablaDatosAcceso.="<tr><td width='100'><b>URL:</b></td><td><a href='".$urlSitio."'>".$urlSitio."</a></td></tr>";
				$tablaDatosAcceso.="<tr><td ><b>Usuario:</b></td><td>".$fDatosUsuario[0]."</td></tr>";
				$tablaDatosAcceso.="<tr><td ><b>Password:</b></td><td>".$fDatosUsuario[1]."</td></tr>";
				$tablaDatosAcceso.="</table>";
				
				$cuerpoMensajeFinal.="<br><br>".$tablaDatosAcceso;
			}
			
			
			if($totalDocumentos>0)
			{
				$cuerpoMensajeFinal.="<br><br>".$tabla;
			}
			
			$resultado="";
			eval('$resultado=@'.$funcionEnvioCorreoElectronico.'($arrDestinatario,$asuntoMensaje,$cuerpoMensajeFinal,"","",$arrArchivos,null,null);');
			if(!$resultado)
			{
				$consulta="UPDATE _665_gPersonasNotificar SET notificado=2 WHERE id__665_gPersonasNotificar=".$fDestinatario["id__665_gPersonasNotificar"];
				$con->ejecutarConsulta($consulta);
				
			}
			else
			{
				$consulta="UPDATE _665_gPersonasNotificar SET notificado=1 WHERE id__665_gPersonasNotificar=".$fDestinatario["id__665_gPersonasNotificar"];
				$con->ejecutarConsulta($consulta);
				
				$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND 
						idParticipante=".$fDestinatario["idPersona"]." AND idFiguraJuridica=4";
				$numReg=$con->obtenerValor($consulta);
				if($numReg>0)
					registrarTerminosAccion($idFormulario,$idRegistro,3);
				
			}
			
		}
		cambiarEtapaFormulario($idFormulario,$idRegistro,3,"",-1,"NULL","NULL",0);
		return true;
		
	}
	
	
	function mostrarSeccionEdicionMemorial($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
	{
		global $con;
		$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";

		$documentoBloqueado=$con->obtenerValor($consulta);	
		if($documentoBloqueado==1)
			return 0;
		$arrActores=array();
		$arrActores[1287]=1;
		
		
		if(isset($arrActores[$actor]))
			return 1;
		return 0;
	}
	
	
	function obtenerPartesProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		$arrDestinatario=array();
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT idCuentaAcceso,f.nombreTipo FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f 
				WHERE idActividad=".$idActividad." AND r.situacion=1 AND idCuentaAcceso IS NOT NULL
				AND f.id__5_tablaDinamica=r.idFiguraJuridica";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$nombreUsuario=trim(obtenerNombreUsuario($fila[0]))." (".$fila[1].")";
			$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}
		
		
		
		return $arrDestinatario;
	}
	
	function enviarCorreoNotificacionSentencia($idFormulario,$idRegistro)
	{
		global $con;
		global $funcionEnvioCorreoElectronico;
		global $urlSitio;
		global $versionLatis;
		$idMensajeNotificacion=0;
		$consulta="";
		
		switch($idFormulario)
		{
			case 633:
				$idMensajeNotificacion=17;
				$consulta="SELECT carpetaAdministrativa,fechaSentencia,resumenSentencia,fechaEjecutorio,comentariosAdicionales,'' as sentidoSentencia,juezSentenciador FROM _633_tablaDinamica WHERE id__633_tablaDinamica=".$idRegistro;
			break;
			case 682:
				$idMensajeNotificacion=21;
				$consulta="SELECT carpetaAdministrativa,fechaSentencia,resumenSentencia,'' as fechaEjecutorio,comentariosAdicionales,sentidoSentencia,
						(SELECT usuarioJuez FROM _26_tablaDinamica jD,_17_tablaDinamica d,7006_carpetasAdministrativas c WHERE jD.idReferencia=d.id__17_tablaDinamica
						AND d.claveUnidad=c.unidadGestion AND c.carpetaAdministrativa=r.carpetaAdministrativa) as juezSentenciador 
						FROM _682_tablaDinamica r WHERE id__682_tablaDinamica=".$idRegistro;
			break;	
		}

		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		$tipoCarpetaAdministrativa=$con->obtenerValor($consulta);
		
		$urlSitioHTTPS=str_replace("http://","https://",$urlSitio);
		
		$consulta="select HEX(AES_ENCRYPT('".$idRegistro."', '".bD($versionLatis)."')) as idNotificacion";		
		$idNotificacion=$con->obtenerValor($consulta);
		
		
		$arrArchivos=array();
		$arrDestinatario=array();

		$consulta="SELECT cuerpoMensaje FROM 2013_cuerposMensajes WHERE idMensaje=".$idMensajeNotificacion;
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT asunto FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$idMensajeNotificacion;
		$asuntoMensaje=$con->obtenerValor($consulta);
		
		$consulta="SELECT o.unidad,c.idActividad,c.especialidad,idCarpeta,c.unidadGestion,c.fechaCreacion FROM 7006_carpetasAdministrativas c,
					817_organigrama o WHERE c.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros["nombreDespacho"]=$fDatosCarpetas["unidad"];
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
		
		$arrParametros["demandante"]=$demantante;
		$arrParametros["demandado"]=$demandados;
		
		$totalDocumentos=0;
		$tabla="<table style='border-top-style:solid;border-top-width:1px;border-top-color:#999'>";
		
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal,a.sha512,a.tamano FROM 9074_documentosRegistrosProceso d,908_archivos a
					WHERE d.idFormulario=".$idFormulario." AND d.idRegistro=".$idRegistro." and a.idArchivo=d.idDocumento";
		$resDest=$con->obtenerFilas($consulta);
		while($fArchivo=$con->fetchAssoc($resDest))
		{
			$paginaGetFile=$urlSitioHTTPS."modulosEspeciales_SGJ/paginasFunciones/getDocumentNotify.php";
			$sha512=$fArchivo["sha512"];
			$arrExtension=explode(".",$fArchivo["nomArchivoOriginal"]);
			$extension=$arrExtension[sizeof($arrExtension)-1];
			$tabla.='<tr><td><a href="'.$paginaGetFile.'?f='.$sha512.'"><img src="'.$urlSitioHTTPS.'imagenesDocumentos/16/file_extension_'.mb_strtolower($extension).'.png"></a></td><td><a href="'.$paginaGetFile.'?f='.$sha512.'"><span style="font-size:13px"><b>'.$fArchivo["nomArchivoOriginal"].'</b> ('.bytesToSize($fArchivo["tamano"],0).')</span></a></td></tr>';
			$totalDocumentos++;
		}
		if($totalDocumentos>1)
			$tabla.="<tr><td align='center' colspan='2'><span style=\"font-size:13px\"><a href='".$paginaGetFile."?nfys=".$idNotificacion."' target=\"_blank\">Descargar todos los archivos</a></span></td></tr></table>";
		else
			$tabla.="</table>";
		$arrParametros["fechaEnvio"]="";
		
		$consulta="SELECT p.* FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p
					WHERE r.idActividad=".$idActividad." AND r.situacion=1 AND p.id__47_tablaDinamica=r.idParticipante";
		$resDest=$con->obtenerFilas($consulta);
		while($fDestinatario=$con->fetchAssoc($resDest))
		{
			$arrDestinatario=array();
			$cadObj=obtenerUltimoDomicilioFiguraJuridica($fDestinatario["id__47_tablaDinamica"]);
			$obj=json_decode($cadObj);
			$listaMails="";
			foreach($obj->correos as $mail)
			{
				$oD[0]=$mail->mail;
				$oD[1]="";
				array_push($arrDestinatario,$oD);
				if($listaMails=="")
					$listaMails=$mail->mail;
				else
					$listaMails.=", ".$mail->mail;
			}
			
			if(sizeof($arrDestinatario)==0)
				continue;
			
			
			$arrParametros["nombreDestinatario"]=trim($fDestinatario["nombre"]." ".$fDestinatario["apellidoPaterno"]." ".$fDestinatario["apellidoMaterno"]);
			$arrParametros["horaEnvio"]=date("H:i");
			$arrParametros["fechaEnvio"]=convertirFechaLetra(date("Y-m-d"),false,false);
			$arrParametros["fechaSentencia"]=convertirFechaLetra($fRegistro["fechaSentencia"],false,false);
			$arrParametros["fechaEjecutorio"]=convertirFechaLetra($fRegistro["fechaEjecutorio"],false,false);
			$arrParametros["juezSentenciador"]=obtenerNombreUsuario($fRegistro["juezSentenciador"]);
			
			$cuerpoMensajeFinal=$cuerpoMensaje;
			
			$consulta="INSERT INTO _689_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,fechaNotificacion,
						destinatario,mailDestinatario,asuntoNotificacion,cuerpoNotificacion,carpetaAdministrativa,idParticipante,
						iFormulario,iRegistro) values('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"].
						"','','".cv($arrParametros["nombreDestinatario"])."','".$listaMails."','".cv($asuntoMensaje)."','".cv($cuerpoMensajeFinal).
						"','".cv($fRegistro["carpetaAdministrativa"])."',".$fDestinatario["id__47_tablaDinamica"].",".$idFormulario.",".$idRegistro.")";

			$con->ejecutarConsulta($consulta);
			
			$idRegistroEnvio=$con->obtenerUltimoID();
			
			
			
			$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
			$rDocumentos=$con->obtenerFilas($query);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				registrarDocumentoResultadoProceso(689,$idRegistroEnvio,$fDocumento[0]);	
			}
			
			
			foreach($arrParametros as $campo=>$valor)
			{
				$cuerpoMensajeFinal=str_replace("[".$campo."]",$valor,$cuerpoMensajeFinal);
			}
			
			$consulta="select HEX(AES_ENCRYPT('".$idRegistroEnvio."', '".bD($versionLatis)."')) as idRegistroEnvio";		
			$idRegistroEnvioEx=$con->obtenerValor($consulta);
			
			$cuerpoMensajeFinal.="<b><span style='font-size:11px'>Por favor confirme la recepci&oacute;n del presente mesaje dando click <a href='".$urlSitioHTTPS."modulosEspeciales_SGJ/paginasFunciones/setNotifyRecive.php?iM=".$idRegistroEnvioEx."'><span style='color:#F00'>AQUI</span></a></span></b>";
			
			if($totalDocumentos>0)
			{
				
				$cuerpoMensajeFinal.="<br><br>".$tabla;
				
			}
			$consulta="UPDATE _689_tablaDinamica SET cuerpoNotificacion='".cv($cuerpoMensajeFinal)."' WHERE id__689_tablaDinamica=".$idRegistroEnvio;
			$con->ejecutarConsulta($consulta);
			
			//echo $cuerpoMensajeFinal;
			$resultado="";
			eval('$resultado=@'.$funcionEnvioCorreoElectronico.'($arrDestinatario,$asuntoMensaje,$cuerpoMensajeFinal,"","",$arrArchivos,null,null);');
			
			if(!$resultado)
			{
				
			}
			else
			{
				$consulta="UPDATE _689_tablaDinamica SET fechaNotificacion='".date("Y-m-d H:i:s")."' WHERE id__689_tablaDinamica=".$idRegistroEnvio;
				$con->ejecutarConsulta($consulta);
				
				cambiarEtapaFormulario(689,$idRegistroEnvio,2,"",-1,"NULL","NULL",0);
			}
			
		}
		cambiarEtapaFormulario($idFormulario,$idRegistro,7,"",-1,"NULL","NULL",0);
		
		if($idFormulario==682)
		{
			
			if($tipoCarpetaAdministrativa==2)
				$consulta="SELECT id__672_tablaDinamica as idRegistro,carpetaAdministrativa FROM _672_tablaDinamica WHERE carpetaAdministrativa2aInstancia='".$fRegistro["carpetaAdministrativa"]."'";
			else
				$consulta="SELECT id__677_tablaDinamica  as idRegistro,carpetaAdministrativa FROM _677_tablaDinamica WHERE carpetaAdministrativa2aInstancia='".$fRegistro["carpetaAdministrativa"]."'";

			$fDatosApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
			$idRegistroApelacion=$fDatosApelacion["idRegistro"];
			
			$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$iRegistrosAux=$con->obtenerValor($consulta);
			if($iRegistrosAux=="")
				$iRegistrosAux=-1;
			$consulta="SELECT idDocumento FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$iRegistrosAux;
			$idSentencia=$con->obtenerValor($consulta);
			
			if($idSentencia=="")
				$idSentencia=-1;
			
			
			if($tipoCarpetaAdministrativa==2)
			{
				$consulta="INSERT INTO _684_tablaDinamica(idReferencia,fechaCreacion,fechaSentencia,sentidoSentencia,resumenSentencia,comentariosAdicionales,sentencia)
							SELECT '".$idRegistroApelacion."' AS idReferencia,'".date("Y-m-d H:i:s")."' AS fechaCreacion,fechaSentencia,sentidoSentencia,
							resumenSentencia,comentariosAdicionales,'".$idSentencia."' AS sentencia
							FROM _682_tablaDinamica WHERE id__682_tablaDinamica=".$idRegistro;
			
				if($con->ejecutarConsulta($consulta))
				{
					
					
					$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
					
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($fDatosApelacion["carpetaAdministrativa"],$fDocumento[0],$idFormulario,$idRegistro);	
						registrarDocumentoResultadoProceso(672,$idRegistroApelacion,$fDocumento[0]);	
					}
					
					
					cambiarEtapaFormulario(672,$idRegistroApelacion,18,"",-1,"NULL","NULL",0);
				}
			
			}
			else
			{
				$consulta="INSERT INTO _687_tablaDinamica(idReferencia,fechaCreacion,fechaSentencia,sentidoSentencia,resumenSentencia,comentariosAdicionales,sentencia)
							SELECT '".$idRegistroApelacion."' AS idReferencia,'".date("Y-m-d H:i:s")."' AS fechaCreacion,fechaSentencia,sentidoSentencia,
							resumenSentencia,comentariosAdicionales,'".$idSentencia."' AS sentencia
							FROM _682_tablaDinamica WHERE id__682_tablaDinamica=".$idRegistro;
				if($con->ejecutarConsulta($consulta))
				{
					$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
					
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($fDatosApelacion["carpetaAdministrativa"],$fDocumento[0],$idFormulario,$idRegistro);	
						registrarDocumentoResultadoProceso(677,$idRegistroApelacion,$fDocumento[0]);	
					}
					
					
					cambiarEtapaFormulario(677,$idRegistroApelacion,18,"",-1,"NULL","NULL",0);
				}
			}
			
		}
		
		return true;
		
	}
	
	function existeDisponibilidadParticipante($idEvento,$idParticipante,$fecha,$horaInicio,$horaFin)
	{
		
		global $con;
		
		global $considerarDisponibilidadSujetosProcesajes;
		if(!$considerarDisponibilidadSujetosProcesajes)
		{
			return true;
		}
		$qAux=generarConsultaIntervalos($horaInicio,$horaFin,"if(a.horaInicioReal is null,a.horaInicioEvento,a.horaInicioReal)",
				"if(a.horaTerminoReal is null,a.horaFinEvento,a.horaTerminoReal)",false,true);
		
		
		$consulta="SELECT a.idRegistroEvento, a.fechaEvento, a.horaInicioEvento, a.horaFinEvento, idSala, situacion, fechaAsignacion
				 FROM 7000_eventosAudiencia a, 7000_participantesEventoAudiencia p WHERE a.fechaEvento='".$fecha."'   and ".$qAux."
				 and a.idRegistroEvento<>".$idEvento." and a.situacion in 
				(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)
				and p.idRegistroEvento=a.idRegistroEvento and p.idPersona in(".$idParticipante.")";
		
		$res=$con->obtenerFilas($consulta);
		return $con->filasAfectadas>0?false:true;
	}
	
	
	
	function existeDisponibilidadSalaSGJ($idEvento,$idSala,$fechaAudiencia,$horaInicio,$horaFin)
	{
		global $con;	
		global $tipoMateria;
		$arrEventos=array();
		
		$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$idSala;
		$perfilSala=$con->obtenerValor($consulta);
		if(($perfilSala==3)||($perfilSala==4))
			return true;
		
		$qAux=generarConsultaIntervalos($horaInicio,$horaFin,"if(a.horaInicioReal is null,a.horaInicioEvento,a.horaInicioReal)",
				"if(a.horaTerminoReal is null,a.horaFinEvento,a.horaTerminoReal)",false,true);
		
		$consulta="SELECT a.idRegistroEvento, a.fechaEvento, a.horaInicioEvento, a.horaFinEvento, idSala, situacion, fechaAsignacion
				 FROM 7000_eventosAudiencia a WHERE a.fechaEvento='".$fechaAudiencia."'   and ".$qAux." and idSala=".$idSala."
				 and a.idRegistroEvento<>".$idEvento." and a.situacion in 
				(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
		
		
		
		/*if($idSala==156)
		{
			$consulta="SELECT a.idRegistroEvento, a.fechaEvento, a.horaInicioEvento, a.horaFinEvento, idSala, situacion, fechaAsignacion
				 FROM 7000_eventosAudiencia a WHERE a.fechaEvento='".$fechaAudiencia."'   and ".$qAux." and idSala in(156,3021)
				 and a.idRegistroEvento<>".$idEvento." and a.situacion in 
				(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
		}*/
	
		$res=$con->obtenerFilas($consulta);
		while($fEvento=$con->fetchRow($res))
		{
			array_push($arrEventos,$fEvento);
		}
		
		$consulta="SELECT idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
		$consulta="SELECT idReferencia FROM _25_gDespachosAsignados WHERE despacho=".$idUnidadGestion;	
		$listaIncidencias=$con->obtenerValor($consulta);
		if($listaIncidencias=="")
			$listaIncidencias=-1;
		
		$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s 
					WHERE s.idReferencia=t.id__25_tablaDinamica AND '".$fechaAudiencia."'>=t.fechaInicial AND '".$fechaAudiencia.
					"'<=t.fechaFinal AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=1
					union
					SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s 
					WHERE s.idReferencia=t.id__25_tablaDinamica AND '".$fechaAudiencia."'>=t.fechaInicial AND '".$fechaAudiencia.
					"'<=t.fechaFinal AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=0 and id__25_tablaDinamica in(".
					$listaIncidencias.")";
					
		$res=$con->obtenerFilas($consulta);
		while($fIncidencia=$con->fetchRow($res))
		{
			
			$horaInicial="00:00:00";
			$horaFinal="23:59:59";
			if($fIncidencia[1]=="")
				$fIncidencia[1]=$horaInicial;
			
			if($fIncidencia[3]=="")
				$fIncidencia[3]=$horaFinal;
				
			
			
			if($fIncidencia[5]==2)
			{
				
				if($fIncidencia[0]==$fechaAudiencia)
				{
					$horaInicial=$fIncidencia[1];
				}
				
				
				if($fIncidencia[2]==$fechaAudiencia)
				{
					$horaFinal=$fIncidencia[3];
				}
				
			}
			else
			{
				$horaInicial=$fIncidencia[1];
				$horaFinal=$fIncidencia[3];
			}
			
			$fechaInicio=$fechaAudiencia." ".$horaInicial;
			$fechaFinal=$fechaAudiencia." ".$horaFinal;
			
			
			if(colisionaTiempo($horaInicio,$horaFin,$fechaInicio,$fechaFinal,false))
				array_push($arrEventos,$fIncidencia);
		}		
		
		if(($tipoMateria=="C")&&($idSala==70)) //Eliminar Sala
		{
			if(date("w",strtotime($fechaAudiencia))==4)
			{
				$fRegIncidencia[0]=$fechaAudiencia." 00:00";
				$fRegIncidencia[1]=$fechaAudiencia." 23:59";
				
				array_push($arrEventos,$fRegIncidencia);
			}
		}
	
		
		
	
		return (sizeof($arrEventos)>0)?false:true;
		
		
	}
	
	function obtenerSalasAudienciaDisponibleDespacho($idUnidadGestion,$idEdificio,$tipoAudiencia,$carpetaAdministrativa)
	{
		global $con;
		
		
		$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idUnidadGestion;
		$claveUnidad=$con->obtenerValor($consulta);
		
		/*$consulta="SELECT COUNT(*) FROM _55_tablaDinamica se,_15_tablaDinamica s WHERE se.idReferencia=".$idUnidadGestion." 
					AND salasVinculadas=s.id__15_tablaDinamica AND s.id__15_tablaDinamica not in(152) and s.idReferencia=".$idEdificio."
					and perfilSala in(1,2)";
	
		$nSalas=$con->obtenerValor($consulta);
		if($nSalas>0)
		{
			$consulta="SELECT distinct id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala) as nombreSala,perfilSala  FROM _55_tablaDinamica t,
				_15_tablaDinamica s WHERE (t.idReferencia=".$idUnidadGestion." AND s.id__15_tablaDinamica=t.salasVinculadas AND 
				s.idReferencia=".$idEdificio." and perfilSala in(1,2)) or (id__15_tablaDinamica in (152,154))";
		
		}
		else
		{
			$consulta="SELECT distinct id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala)  as nombreSala,perfilSala FROM 
				_15_tablaDinamica s WHERE (s.idReferencia=".$idEdificio." and perfilSala in(1,2)) or (id__15_tablaDinamica in (152,154))";
		
		
		}*/
		
		
		
		$consulta="SELECT COUNT(*) FROM _671_gSalasAsignadas sA,_671_tablaDinamica s WHERE
									sA.idReferencia=s.id__671_tablaDinamica AND s.idReferencia=".$idEdificio." AND
									despachoAsociado='".$claveUnidad."'";
							
		$nSalas=$con->obtenerValor($consulta);
		if($nSalas>0)
		{
			$consulta="SELECT distinct id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala) as nombreSala  FROM 
				_15_tablaDinamica s,_671_gSalasAsignadas sA,_671_tablaDinamica d WHERE d.idReferencia=".$idEdificio.
				" and d.despachoAsociado='".$claveUnidad."' and s.id__15_tablaDinamica=sA.idSalaAsignada 
				and sA.idReferencia=d.id__671_tablaDinamica";
		}
		else
		{
			$consulta="SELECT distinct id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala) as nombreSala  FROM 
				_15_tablaDinamica s WHERE s.idReferencia=".$idEdificio." or id__15_tablaDinamica in (152,154)";
				
			
				
				
		}
		
		$agregarClausulaOrder=false;
		
		/*if(($tipoAudiencia!=-1)&&($carpetaAdministrativa!=""))
		{
			$query="SELECT permiteAudienciaVirtual FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			$permiteAudienciaVirtual=$con->obtenerValor($query);
			if($permiteAudienciaVirtual==1)
			{
				$query="SELECT permiteAgendarAudienciaVirtual FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tipoAudiencia;
				$permiteAgendarAudienciaVirtual=$con->obtenerValor($query);
				if($permiteAgendarAudienciaVirtual==1)
				{
					$query="SELECT idReferencia FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idUnidadGestion;
					$iEdificioUnidad=$con->obtenerValor($query);
					if($iEdificioUnidad==$idEdificio)
					{
						$consulta.=" union
									(SELECT id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala) as nombreSala,perfilSala  FROM 
									_15_tablaDinamica s WHERE s.idReferencia=".$iEdificioUnidad." and perfilSala in(3,4))";
						$consulta="select * from(".$consulta.") as tmp order by perfilSala,nombreSala";
						$agregarClausulaOrder=false;
					}
					
				}
				
			}
		}
		
		if($agregarClausulaOrder)
			$consulta.=" ORDER BY s.nombreSala";*/
	
	
		
		
		$consulta="select * from (".$consulta.") as tmp ORDER BY nombreSala";

		$arrSalas=$con->obtenerFilasArreglo($consulta);
		
		return $arrSalas;
	}
	
	function enviarCorreoNotificacionAudiencia($idAudiencia,$tipoNotificacion,$comentariosAdicionales="")
	{
		global $con;
		global $funcionEnvioCorreoElectronico;
		global $urlSitio;
		global $versionLatis;
		$idMensajeNotificacion=-1;
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idAudiencia;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

		
		$arrArchivos=array();
		$arrDestinatario=array();
		
		switch($tipoNotificacion)
		{
			case 1://Programación de Audiencia
				$idMensajeNotificacion=18;
			break;
			case 2://Modificación de Audiencia
				$idMensajeNotificacion=19;
			break;
			case 3://Cancelacion
				$idMensajeNotificacion=20;
			break;
			case 9://Aplazamiento
				$idMensajeNotificacion=20;
			break;
		}
		
		$consulta="SELECT cuerpoMensaje FROM 2013_cuerposMensajes WHERE idMensaje=".$idMensajeNotificacion;
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT asunto FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$idMensajeNotificacion;
		$asuntoMensaje=$con->obtenerValor($consulta);
		
		$arrParametros=array();
		$arrParametros["comentariosDespacho"]=$comentariosAdicionales;
		switch($tipoNotificacion)
		{
			
			case 3://Cancelacion
				$asuntoMensaje="SIUGJ - Notificación de Cancelación de Audiencia";
				$arrParametros["situacionAudiencia"]="cancelada";
				
			break;
			case 9://Aplazamiento
				$asuntoMensaje="SIUGJ - Notificación de Aplazamiento de Audiencia";
				$arrParametros["situacionAudiencia"]="aplazada";
			break;
		}
		
		$consulta="SELECT o.unidad,c.idActividad,c.especialidad,idCarpeta,c.unidadGestion,c.fechaCreacion FROM 7006_carpetasAdministrativas c,
					817_organigrama o WHERE c.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros["nombreDespacho"]=$fDatosCarpetas["unidad"];
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
		
		$arrParametros["demandante"]=$demantante;
		$arrParametros["demandado"]=$demandados;
		$arrParametros["lblDatosAudiencia"]=bD(formatearEventoAudienciaSGJRenderer($idAudiencia));
		
		$arrParametros["fechaEnvio"]="";
		
		$consulta="SELECT tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idAudiencia;
		$tipoAudiencia=$con->obtenerValor($consulta);
		
		$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tipoAudiencia;
		$tAudiencia=$con->obtenerValor($consulta);
		$arrParametros["tipoAudiencia"]=$tAudiencia;
		$consulta="SELECT * FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=".$idAudiencia;
		$resDest=$con->obtenerFilas($consulta);
		while($fDestinatario=$con->fetchAssoc($resDest))
		{
			$arrDestinatario=array();
			$arrMails=explode(",",$fDestinatario["mail"]);
			foreach($arrMails as $m)
			{
				$oD[0]=$m;
				$oD[1]="";
				array_push($arrDestinatario,$oD);
			}
			if(sizeof($arrMails)==0)
				continue;
			
			$arrParametros["nombreDestinatario"]=$fDestinatario["nombrePersona"];
			$arrParametros["horaEnvio"]=date("H:i");
			$arrParametros["fechaEnvio"]=convertirFechaLetra(date("Y-m-d"),false,false);
			
			$cuerpoMensajeFinal=$cuerpoMensaje;
			foreach($arrParametros as $campo=>$valor)
			{
				$cuerpoMensajeFinal=str_replace("[".$campo."]",$valor,$cuerpoMensajeFinal);
			}
			
			
			/*for($x=0;$x<strlen($cuerpoMensajeFinal);$x++)
			{
				echo ord($cuerpoMensajeFinal[$x])."=".$cuerpoMensajeFinal[$x]."<br>";
			}
			*/
			$arrCaracteres[chr(194)]=1;
			$arrCaracteres[chr(160)]=1;
			foreach($arrCaracteres as $campo=>$valor)
				$cuerpoMensajeFinal=str_replace($campo,"",$cuerpoMensajeFinal);
			
			
			
			$resultado="";
			eval('$resultado=@'.$funcionEnvioCorreoElectronico.'($arrDestinatario,$asuntoMensaje,$cuerpoMensajeFinal,"","",$arrArchivos,null,null);');
			if(!$resultado)
			{
				return false;
			}
			else
			{
				$consulta="UPDATE 7000_participantesEventoAudiencia SET notificado=1 WHERE idRegistro=".$fDestinatario["idRegistro"];
				$con->ejecutarConsulta($consulta);
			}
			
		}
		
		return true;
		
	}
	
	
	function formatearEventoAudienciaSGJRenderer($idEventoAudiencia)
	{
		global $con;
		
		$datosEventos=obtenerDatosEventoAudiencia($idEventoAudiencia);
		
		
		$fechaEvento=utf8_encode(convertirFechaLetra($datosEventos->fechaEvento,true));
		$duracionEstimada=obtenerDiferenciaMinutos($datosEventos->horaInicio,$datosEventos->horaFin)." minutos";
		
		$lblHorario="";
		
		$fechaHoraInicio=strtotime($datosEventos->horaInicio);
		$fechaHoraFin=strtotime($datosEventos->horaFin);
		$comp='';
		if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
		{
			$comp=' del '.utf8_encode(convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true));
		}
		
		$lblJueces='';            
				
		foreach($datosEventos->jueces as $j)
		{
			$lblJueces.=$j->nombreJuez.' ('.$j->titulo.')<br>';
		}
		
		$lblHorario='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.utf8_encode(convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true));
		
		$tabla='	<table width="800px">';
		$tabla.='	<tr height="23"><td align="right" colspan="4" style="border-bottom-style:solid;border-bottom-color:#777;border-bottom-width:2px;" ><br><span class="SeparadorSeccion" style="width:800px"><b>Datos de la audiencia</b></span><br></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Fecha de la audiencia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$fechaEvento.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Tipo de audiencia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$datosEventos->tipoAudiencia.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Duraci&oacute;n estimada:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$duracionEstimada.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Horario:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$lblHorario.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Sala asignada:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$datosEventos->sala.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Centro de Gesti&oacute;n:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$datosEventos->unidadGestion.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Sede:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$datosEventos->edificio.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left" style="vertical-align:top; padding-top:4px"><span class="TSJDF_Etiqueta">'.((sizeof($datosEventos->jueces)==1)?'Juez asignado:':'Jueces asignados:').'</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'.$lblJueces.'</span></td></tr>';
		$tabla.='	<tr height="23"><td align="left" width="200"></td><td width="200"></td><td width="200"></td><td width="200" align="left"><span class="TSJDF_Control"></span></td></tr>';
		$tabla.='	</table>';
		
		
		return '"'.bE($tabla).'"';
		
	}
	
	
	function registrarSuspensionAplazamientoAudiencia($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT * FROM _323_tablaDinamica WHERE id__323_tablaDinamica=".$idRegistro;
		$fDatosRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$etapaContinuacion=2;
		$situacionAudiencia=0;
		switch($fDatosRegistro["movimientoRegistra"])
		{
			case 2://Cancelacion
				$etapaContinuacion=4;
				$situacionAudiencia=3;
				$consulta="UPDATE 7000_eventosAudiencia SET situacion=".$situacionAudiencia." WHERE idRegistroEvento=".$fDatosRegistro["idEvento"];
				notificarCancelacionEventoAudienciaSala($fDatosRegistro["idEvento"],$fDatosRegistro["comentariosAdicionales"]);
			break;
			case 1://Aplazamiento
				$etapaContinuacion=3;
				
				if($fDatosRegistro["realizoAudiencia"]==1)
				{
					$situacionAudiencia=9;
					$consulta="UPDATE 7000_eventosAudiencia SET situacion=".$situacionAudiencia.",horaInicioReal='".
						$fDatosRegistro["fechaAudiencia"]." ".$fDatosRegistro["cmbHoraInicioAudiencia"]."',horaTerminoReal='".
						$fDatosRegistro["fechaAudiencia"]." ".$fDatosRegistro["cmbHoraFinAudiencia"]."' WHERE idRegistroEvento=".$fDatosRegistro["idEvento"];
					notificarCancelacionEventoAudienciaSala($fDatosRegistro["idEvento"],$fDatosRegistro["comentariosAdicionales"]);
				}
				else
				{
					$situacionAudiencia=10;
					$consulta="UPDATE 7000_eventosAudiencia SET situacion=".$situacionAudiencia.",horaInicioReal=NULL,horaTerminoReal=NULL WHERE idRegistroEvento=".$fDatosRegistro["idEvento"];
				}
			break;
		}
		
		
		if($con->ejecutarConsulta($consulta))
		{
			cambiarEtapaFormulario($idFormulario,$idRegistro,$etapaContinuacion,"",-1,"NULL","NULL",0);
			return enviarCorreoNotificacionAudiencia($fDatosRegistro["idEvento"],$situacionAudiencia,$fDatosRegistro["comentariosAdicionales"]);
		}
		return false;
		
	}
	
	
	function registrarFinalizacionAudienciaSGJ($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT idEvento,fechaFinalizacion,cmbHoraInicioAudiencia,cmbHoraFinAudiencia FROM _321_tablaDinamica WHERE id__321_tablaDinamica=".$idRegistro;
		$fDatosRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$fDatosRegistro["idEvento"];
		$fDatosAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		$consulta="UPDATE 7000_eventosAudiencia SET situacion=2,horaInicioReal='".$fDatosRegistro["fechaFinalizacion"]." ".$fDatosRegistro["cmbHoraInicioAudiencia"].
				"',horaTerminoReal='".$fDatosRegistro["fechaFinalizacion"]." ".$fDatosRegistro["cmbHoraFinAudiencia"]."'
				 WHERE idRegistroEvento=".$fDatosRegistro["idEvento"];
		
		
		
		 return $con->ejecutarConsulta($consulta);	
		
	}

	function obtenerParticipantesInvitadosAudiencia($idFormulario,$idRegistro)
	{
		global $con;
		$arrDestinatario=array();
		$consulta="";
		if($idFormulario==185)
			$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND idRegistroSolicitud=".$idRegistro;
		else
			$consulta="SELECT idEvento FROM _323_tablaDinamica WHERE id__323_tablaDinamica=".$idRegistro;
		

		$idRegistroEvento=$con->obtenerValor($consulta);
		
		$consulta="SELECT distinct f.idCuentaAcceso FROM 7000_participantesEventoAudiencia p,7005_relacionFigurasJuridicasSolicitud f 
					WHERE idRegistroEvento=".$idRegistroEvento." AND f.idParticipante=p.idPersona AND f.idCuentaAcceso IS NOT NULL";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$nombreUsuario=trim(obtenerNombreUsuario($fila["idCuentaAcceso"]))." (Participante Audiencia)";
			$o='{"idUsuarioDestinatario":"'.$fila["idCuentaAcceso"].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}
		

		
		return $arrDestinatario;
	}

	function registrarCambioBitacoraDocumentoEdicionAmpliado($idFormulario,$idRegistro,$idFormularioProceso)
	{
		global $con;
	
		
		$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idFormularioProceso=".$idFormularioProceso;
		$idRegistroDoc=$con->obtenerValor($consulta);
		
		$consulta="SELECT idRegistroFormato FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$idRegistroDoc;
		$idRegistroFormato=$con->obtenerValor($consulta);
		
		$consulta="SELECT idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$etapaActual=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario.
					" AND idRegistro=".$idRegistro." AND etapaActual=".$etapaActual." ORDER BY fechaCambio DESC";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="INSERT INTO 3000_bitacoraFormatos(idRegistroFormato,idEstadoAnterior,fechaCambio,idEstadoActual,
						responsableCambio,comentariosAdicionales)
						VALUES(".$idRegistroFormato.",".$fRegistro["etapaAnterior"].",'".$fRegistro["fechaCambio"].
						"',".$etapaActual.",".$fRegistro["idUsuarioCambio"].",'".cv($fRegistro["comentarios"])."')";
		return	$con->ejecutarConsulta($consulta);
	}


	function mostrarSeccionEdicionAcuerdo($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
	{
		global $con;
		$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";
	
		$documentoBloqueado=$con->obtenerValor($consulta);	
		if($documentoBloqueado==1)
			return 0;
		$arrActores=array();
		
		switch($idFormularioEvaluacion)
		{
			case 675:
				$arrActores[1308]=1;
				$arrActores[1310]=1;
				$arrActores[1313]=1;
				$arrActores[1311]=1;
				
			break;
			case 676:
				
				$arrActores[1315]=1;
				$arrActores[1316]=1;
				$arrActores[1317]=1;
				$arrActores[1318]=1;
			break;
			case 685:
				$arrActores[1322]=1;
				$arrActores[1323]=1;
				$arrActores[1324]=1;
				$arrActores[1325]=1;
				
			break;
			case 686:
				
				$arrActores[1328]=1;
				$arrActores[1329]=1;
				$arrActores[1330]=1;
				$arrActores[1331]=1;
			break;
		}
		
		if(isset($arrActores[$actor]))
			return 1;
		return 0;
	}


	function esNotificarApelacionConcecion($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
				$consulta="SELECT dictamenFinal FROM _673_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==1)
					return 1;
				return 0;
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _674_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==1)
					return 1;
				return 0;
			break;
		}
		
	}

	function esNotificarApelacionRechazado($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
				$consulta="SELECT dictamenFinal FROM _673_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==2)
					return 1;
				return 0;			
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _674_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==2)
					return 1;
				return 0;	
			break;
		}
		
		
	}

	function esNotificarApelacionImpedido($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
					return 0;
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _674_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==3)
					return 1;
				return 0;
			break;
		}
		
		
	}


	function asignarDespachoTribunalSuperior($idFormulario,$idRegistro)
	{
		global $con;
		
		
		/*$_SESSION["funcionCargaProceso"]="obtenerAcuseRadicacion()";
		$_SESSION["funcionCargaUnicaProceso"]=1;
		$_SESSION["funcionRetrasoCargaProceso"]=1000;
	*/
	
		$consulta="SELECT * FROM _911_tablaDinamica WHERE id__911_tablaDinamica=".$idRegistro;
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


	function obtenerSiguienteCodigoUnicoProceso2daInstancia($idUnidadGestion,$anio,$tipoCarpeta,$idFormulario,$idRegistro)
	{
		global $con;
		$tratarComoRadicacion=true;
		
		
		$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatosRadicacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$generarCodigoUnico=true;
		/*if(!$tratarComoRadicacion)
		{
			switch($tipoCarpeta)
			{
				case "1"://Radicación Inicial
					$generarCodigoUnico=true;
				break;
				case "2"://Radicación Segunda Instancia
				case "3"://Registro de Casación
				case "4"://Revisión de Expediente
						$generarCodigoUnico=false;
				break;
			}
			
		}*/
		
		$agregarSecuencia=false;
		if($generarCodigoUnico)
		{
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
			$formatoCarpeta= $fRegistroUnidad[0]."-".$anio."[folioCarpeta]";
			$formatoCarpeta.="01";
			
			
			
			$carpetaAdministrativa=str_replace("[folioCarpeta]",str_pad($folioCorreccion,5,"0",STR_PAD_LEFT),$formatoCarpeta);
			while(existeCarpetaAdministrativa($carpetaAdministrativa,""))
			{
				$folioCorreccion++;	
				$carpetaAdministrativa=str_replace("[folioCarpeta]",str_pad($folioCorreccion,5,"0",STR_PAD_LEFT),$formatoCarpeta);
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
		else
		{
			$procesoJudicialOrigen=substr($fDatosRadicacion["procesoJudicialOrigen"],0,strlen($fDatosRadicacion["procesoJudicialOrigen"])-2);
			$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa LIKE 
						'".$procesoJudicialOrigen."%' ORDER BY carpetaAdministrativa DESC";
			$ultimoProceso=$con->obtenerValor($consulta);
			$maxValor=substr($ultimoProceso,strlen($fDatosRadicacion["procesoJudicialOrigen"])-2,2);
			
			$folioCorreccion=($maxValor*1)+1;
			
			$folioCorreccion=$folioActual-5;
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
		
		
		
	}
	
	function obtenerTitularPuestoProcesoJudicialDestino2daInstancia($idFormulario,$idRegistro,$actorDestinatario)
	{
		global $con;
		$rolActor=obtenerTituloRol($actorDestinatario);
		
		$consulta="";
		
		
		if($con->existeCampo("carpetaAdministrativa2aInstancia","_".$idFormulario."_tablaDinamica"))
		{
			$consulta="SELECT carpetaAdministrativa2aInstancia FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		}
		else
		{
			$consulta="SELECT carpetaAdministrativa2daInstancia FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		}
		
		
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$arrDestinatario=array();
		$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
					r.codigoRol='".$actorDestinatario."' AND ad.Institucion='".$unidadGestion."'";
	
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$nombreUsuario=trim(obtenerNombreUsuario($fila[0]))." (".$rolActor.")";
			$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}
		
		
		
		return $arrDestinatario;
	}
	
	function asignarDespachoCorteSupremaJustica($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT * FROM _677_tablaDinamica WHERE id__677_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		if(($fRegistro["carpetaAdministrativa2aInstancia"]!="N/E")&&($fRegistro["carpetaAdministrativa2aInstancia"]!=""))
		{
			return true;
		}
		
		
		
		$arrCarpetas=array();
		obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
		if(sizeof($arrCarpetas)==0)
		{
			array_push($arrCarpetas,$cupj);
		}
		

		
		$carpetaBase=$arrCarpetas[0];	
		
		
		$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$carpetaBase."'";

		$fDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);	
		$cuantiaProceso=$fDatosBase["cuantiaProceso"];
		
		/*$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$fDatosBase["jurisdiccion"]." AND especialidad=".$fDatosBase["especialidad"].
					" and tipoProceso=".$fDatosBase["tipoProceso"]." 
					AND cmbTema=".$fDatosBase["temaProceso"]." order by id__643_tablaDinamica asc";
					
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
		}*/
		
		$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002' and id__992_tablaDinamica in(24,25,26)";
		$esSalaVirtual=true;					
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
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		
		$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$cveDespacho." AND presideSala=1";
		$cveDespacho=$con->obtenerValor($consulta);
		
	
		

		$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,20,$idFormulario,$idRegistro);	
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
						$cveDespacho."',3,".$idActividad.",'".$fRegistro["carpetaAdministrativa"]."',20,'".$cveDespacho."',".$fDatosBase["especialidad"].",14,".
						$fDatosBase["claseProceso"].",".$fDatosBase["subClaseProceso"].
						",".$fDatosBase["temaProceso"].",".$fDatosBase["subTemaProceso"].")";
		$x++;
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		$consulta[$x]="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa2aInstancia='".$carpetaAdministrativa.
					"',despachoAsignado='".$cveDespacho."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
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
			//registrarCambioEtapaProcesalCarpeta($fRegistro["carpetaAdministrativa"],3,$idFormulario,$idRegistro,-1);
			
			
			/*$consulta="SELECT carpetaAdministrativaBase FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
			$cBase=$con->obtenerValor($consulta);*/
			//registrarCambioEtapaProcesalCarpeta($cBase,3,$idFormulario,$idRegistro,-1);
			return true;
	
		}
		return false;
		
	}
	
	function esNotificarCasacionConcecion($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
				$consulta="SELECT dictamenFinal FROM _1080_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==1)
					return 1;
				return 0;
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _1080_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==1)
					return 1;
				return 0;
			break;
		}
		
	}

	function esNotificarCasacionRechazado($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
				$consulta="SELECT dictamenFinal FROM _1080_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==2)
					return 1;
				return 0;			
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _1080_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==2)
					return 1;
				return 0;	
			break;
		}
		
		
	}

	function esNotificarCasacionImpedido($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		switch($etapa)
		{
			case 7:
					return 0;
			break;
			case 17:
				$consulta="SELECT dictamenFinal FROM _681_tablaDinamica WHERE idReferencia=".$idRegistro;
				$dictamenFinal=$con->obtenerValor($consulta);
				if($dictamenFinal==3)
					return 1;
				return 0;
			break;
		}
		
		
	}
	
	function obtenerTitularPuestoProcesoJudicialCarpetaAdministrativa($idFormulario,$idRegistro,$actorDestinatario)
	{
		global $con;
		$rolActor=obtenerTituloRol($actorDestinatario);

		$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$arrDestinatario=array();
		$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
					r.codigoRol='".$actorDestinatario."' AND ad.Institucion='".$unidadGestion."'";
	
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$nombreUsuario=trim(obtenerNombreUsuario($fila[0]))." (".$rolActor.")";
			$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
			$o=json_decode($o);
			array_push($arrDestinatario,$o);
		}
		
		
		
		return $arrDestinatario;
	}
	
	function mostrarSeccionEdicionSentencia($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _682_tablaDinamica WHERE id__682_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$tipoCarpeta=$con->obtenerValor($consulta);
		
		$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";
	
		$documentoBloqueado=$con->obtenerValor($consulta);	
		if($documentoBloqueado==1)
			return 0;
			
		switch($idFormularioEvaluacion)
		{
			case 683:
			
			if($tipoCarpeta==3)
				return 0;
			break;
			case 688:
				if($tipoCarpeta==2)
					return 0;
			break;
			
		}
		$arrActores=array();
		$arrActores[1333]=1;
		$arrActores[1334]=1;
		$arrActores[1335]=1;
		$arrActores[1336]=1;
		
		if(isset($arrActores[$actor]))
			return 1;
		return 0;
	}
	
	
	function cerrarProceso($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa,comentariosCierreProceso as comentarios,codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fRegistro["carpetaAdministrativa"];
		
		$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND unidadGestion='".$fRegistro["codigoInstitucion"]."'";
		$idCarpeta=$con->obtenerValor($consulta);
		registrarCambioSituacionCarpetaSIUGJ($carpetaAdministrativa,3,$idFormulario,$idRegistro,-1,"",-1);
		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpeta,"Cierre de Proceso Judicial.<br><br>Comentarios Adicionales: ".$fRegistro["comentarios"],8);
		return $con->ejecutarConsulta($consulta);
	}
	
	function aperturarProceso($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa,comentariosAdicionales as comentarios,codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fRegistro["carpetaAdministrativa"];
		
		
		$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND unidadGestion='".$fRegistro["codigoInstitucion"]."'";
		$idCarpeta=$con->obtenerValor($consulta);
		
		
		registrarCambioSituacionCarpetaSIUGJ($carpetaAdministrativa,1,$idFormulario,$idRegistro,-1,"",-1);
		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpeta,"Reapertura de Proceso Judicial.<br><br>Comentarios Adicionales: ".$fRegistro["comentarios"],9);
		return $con->ejecutarConsulta($consulta);
	}
	
	
	
	function obtenerHistoriaProcesoJudicial($cAministrativa)
	{
		global $con;		
		
		$arrHistorialCarpeta=array();
	
		$cBase=obtenerCarpetaBaseOriginal($cAministrativa);
	
		$consulta="SELECT idTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
		$listaCarpetas=$con->obtenerListaValores($consulta);
		$arrCarpetas=obtenerCarpetasDerivadas($cBase,$listaCarpetas);
		
		$arrCarpetasHistoria=array();
		$arrCarpetasHistoria[$cBase]=1;
		if($arrCarpetas!="")
		{
			$aTemp=explode(",",$arrCarpetas);
			foreach($aTemp as $t)
			{
				$cAux=str_replace("'","",$t);
				$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAux."'";
				$arrCarpetasHistoria[$cAux]=$con->obtenerValor($consulta);
			}
		}
		
	
		$arrSabanaCarpeta=array();
		$arrSabanaCarpeta["carpeta"]=$cAministrativa;
		$arrSabanaCarpeta["etapaInicial"]=array();
		$arrSabanaCarpeta["etapaApelacion"]=array();
		$arrSabanaCarpeta["etapaCasacion"]=array();

		
		$etapaIntermedia=false;
		foreach($arrCarpetasHistoria as $carpeta=>$resto)
		{
			$arrHistorialCarpeta[$carpeta]=array();
			
			$consulta="SELECT e.*  FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e 
						WHERE carpetaAdministrativa='".$carpeta."' AND tipoContenido=3 AND e.idRegistroEvento=
						c.idRegistroContenidoReferencia ORDER BY fechaEvento ASC";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				
				$oResolutivo=obtenerResolutivosAudienciaHistorialProcesoJudicial($fila["idRegistroEvento"]);
				
				switch($resto)
				{
					case 1:  //Inicial
						array_push($arrSabanaCarpeta["etapaInicial"],$oResolutivo);
					break;
					case 2:  //Intermedia
						array_push($arrSabanaCarpeta["etapaApelacion"],$oResolutivo);
					break;
					case 3:	//Juicio oral
						array_push($arrSabanaCarpeta["etapaCasacion"],$oResolutivo);
					break;
					
				}
				
				
				
	
			}
			
			
		}
		return $arrSabanaCarpeta;
	}
	
	
	function obtenerResolutivosAudienciaHistorialProcesoJudicial($idEvento)
	{
		global $con;	
		
		global $arrMesLetra;
		$arrResultado=array();
		
		$arrDiasSemana[0]="Domingo";
		$arrDiasSemana[1]="Lunes";
		$arrDiasSemana[2]="Martes";
		$arrDiasSemana[3]="Mi&eacute;rcoles";
		$arrDiasSemana[4]="Jueves";
		$arrDiasSemana[5]="Viernes";
		$arrDiasSemana[6]="S&aacute;bado";
		
		$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
		$fEvento=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEvento["tipoAudiencia"];
		$arrResultado["tipoAudiencia"]=$con->obtenerValor($consulta);
	
		$dEvento=obtenerDatosEventoAudiencia($idEvento);
		
		
		$fechaEvento=strtotime($dEvento->fechaEvento!=""?$dEvento->fechaEvento:$fEvento["fechaAsignacion"]);
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
				AND idRegistroContenidoReferencia=".$idEvento;
		$arrResultado["carpetaJudicial"]=$con->obtenerValor($consulta);
		$arrResultado["idEventoAudiencia"]=$idEvento;
		$arrResultado["lugar"]=$dEvento->edificio;
		$arrResultado["fechaAudiencia"]=($arrDiasSemana[date("w",$fechaEvento)])." ".date("d",$fechaEvento)." de ".$arrMesLetra[(date("m",$fechaEvento)*1)-1]." de ".date("Y",$fechaEvento);
		$arrResultado["fechaAudienciaRaw"]=date("Y-m-d",$fechaEvento);
		$arrResultado["horaProgramada"]=date("H:i",strtotime($dEvento->horaInicio));
		$arrResultado["fechaAsignacion"]=$fEvento["fechaAsignacion"];
		$arrResultado["situacion"]=$fEvento["situacion"];
		$arrResultado["desarrollo"]="";
		
		
		
		if($fEvento["horaInicioReal"]!="")
		{
			$hInicioReal=strtotime($fEvento["horaInicioReal"]);
			$horaTerminoReal=strtotime($fEvento["horaTerminoReal"]);
			if(date("d/m/Y",$hInicioReal)==date("d/m/Y",$horaTerminoReal))
			{
				$fechaAudiencia=$arrDiasSemana[date("w",$hInicioReal)]." ".date("d",$hInicioReal)." de ".$arrMesLetra[(date("m",$hInicioReal)*1)-1]." de ".date("Y",$hInicioReal);
				
				$arrResultado["desarrollo"]=" De las ".date("H:i",$hInicioReal)." a las ".date("H:i",$horaTerminoReal)." hrs. del ".$fechaAudiencia;
			}
			else
			{
				$fechaAudiencia=$arrDiasSemana[date("w",$hInicioReal)]." ".date("d",$hInicioReal)." de ".$arrMesLetra[(date("m",$hInicioReal)*1)-1]." de ".date("Y",$hInicioReal);
				$fechaAudienciaFinal=$arrDiasSemana[date("w",$horaTerminoReal)]." ".date("d",$horaTerminoReal)." de ".$arrMesLetra[(date("m",$horaTerminoReal)*1)-1]." de ".date("Y",$horaTerminoReal);
				$arrResultado["desarrollo"]=" De las ".date("H:i",$hInicioReal)." hrs. del ".$fechaAudiencia." a las ".date("H:i",$horaTerminoReal)." hrs. del ".$fechaAudienciaFinal;
			}
		}
		$arrResultado["urlVideo"]="";
		if($fEvento["urlMultimedia"]!="")
		{
			$arrResultado["urlVideo"]=$fEvento["urlMultimedia"];
		}
		
		
		$arrResultado["unidadGestion"]=$dEvento->unidadGestion;
		$arrResultado["sala"]=$dEvento->sala;
		$consulta="SELECT u.nombre FROM 800_usuarios u,7001_eventoAudienciaJuez j WHERE j.idRegistroEvento=".$idEvento." AND  
				idUsuario=j.idJuez ORDER BY u.nombre";
		$arrResultado["jueces"]=$con->obtenerListaValores($consulta);
		$arrResultado["idFormulario"]=$fEvento["idFormulario"];
		$arrResultado["idRegistro"]=$fEvento["idRegistroSolicitud"];
		$arrResultado["arrDocumentos"]=array();
		
		if($arrResultado["idFormulario"]=="")
			$arrResultado["idFormulario"]=-1;
		
		if($arrResultado["idRegistro"]=="")
			$arrResultado["idRegistro"]=-1;
			
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 9074_documentosRegistrosProceso d,908_archivos a WHERE 
				idFormulario=".$arrResultado["idFormulario"]." AND idRegistro=".$arrResultado["idRegistro"]." AND a.idArchivo=d.idDocumento";
		$rDocumento=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($rDocumento))
		{
			array_push($arrResultado["arrDocumentos"],$fila);
		}
		
		
		$arrResultado["resolutivos"]=array();
		
		$arrResultado["medidasCautelares"]=array();
		
		
		
		$arrResultado["acuerdosReparatorios"]=array();	
		
		
		$arrResultado["medidasProteccion"]=array();
		
		
		$arrResultado["suspensionCondicional"]=array();	
		
		return $arrResultado;
	}
	
	
	
	function obtenerDatosProcesoJudicial($carpeta)
	{
		global $con;	
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";
	
		$idActividad=$con->obtenerValor($consulta);
		
		if($idActividad=="")
			$idActividad=-1;
		$arrSujetosProcesales=array();
		$arrFiguras="";
		$consulta="SELECT id__5_tablaDinamica,etiquetaPlural FROM _5_tablaDinamica ORDER BY codigo";
		$rFiguras=$con->obtenerFilas($consulta);
		while($fFiguras=$con->fetchRow($rFiguras))
		{
			$arrSujetosProcesales[$fFiguras[0]]=array();
			
			$arrPersonas="";
			$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre,requiereDefensoria FROM 
						_47_tablaDinamica r,7005_relacionFigurasJuridicasSolicitud f WHERE f.idActividad=".$idActividad.
					" and f.idParticipante=r.id__47_tablaDinamica and f.idFiguraJuridica=".$fFiguras[0]." order by nombre,apellidoPaterno,apellidoMaterno";
			
	
			$rPersona=$con->obtenerFilas($consulta);
			while($fPersona=$con->fetchRow($rPersona))
			{
				$oFigura=array();
				
				$oFigura["idRegistro"]=$fPersona[0];
				$oFigura["tipoPersona"]=$fPersona[1];
				$oFigura["apellidoPaterno"]=$fPersona[2];
				$oFigura["apellidoMaterno"]=$fPersona[3];
				$oFigura["nombre"]=$fPersona[4];
				
				
				switch($fFiguras[0])
				{
					
					case 4:
						$oFigura["requiereDefensorOficio"]=0;
						$oFigura["delitos"]=array();
						
						
						
					break;
					case 5:
						$oFigura["defendidos"]=array();			
						
						$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputados i WHERE 
									i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
									
						$rDependientes=$con->obtenerFilas($consulta);			
						while($fDependientes=$con->fetchRow($rDependientes))
						{
							$asesorado=array();
							$asesorado["idRegistro"]=$fDependientes[0];
							$asesorado["tipoPersona"]=$fDependientes[1];
							$asesorado["apellidoPaterno"]=$fDependientes[2];
							$asesorado["apellidoMaterno"]=$fDependientes[3];
							$asesorado["nombre"]=$fDependientes[4];
							array_push($oFigura["defendidos"],$asesorado);
						}
					break;
					case 6:
						$oFigura["representados"]=array();		
						$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputadosVictimas i WHERE 
									i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
									
						$rDependientes=$con->obtenerFilas($consulta);			
						while($fDependientes=$con->fetchRow($rDependientes))
						{
							$asesorado=array();
							$asesorado["idRegistro"]=$fDependientes[0];
							$asesorado["tipoPersona"]=$fDependientes[1];
							$asesorado["apellidoPaterno"]=$fDependientes[2];
							$asesorado["apellidoMaterno"]=$fDependientes[3];
							$asesorado["nombre"]=$fDependientes[4];
							array_push($oFigura["representados"],$asesorado);
						}
					break;
				}
				array_push($arrSujetosProcesales[$fFiguras[0]],$oFigura);	
			}
		}
		
		
		
		
		
		
		
		return $arrSujetosProcesales;
		
		
	}
	
	
	function registrarTerminosAccion($idFormulario,$idRegistro,$tipoAccion)
	{
		global $con;
		return true;
		$fechaActualRef=strtotime(date("Y-m-d H:i:s"));
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas where carpetaAdministrativa='".$carpetaAdministrativa."'";
		$tipoProceso=$con->obtenerValor($consulta);
		$consulta="";
		switch($tipoAccion)
		{
			case 1://Una vez asignado el proceso al despacho
			
				
				$consulta="SELECT * FROM _625_tablaDinamica tP,_654_tablaDinamica s WHERE tP.id__625_tablaDinamica=".$tipoProceso.
						" AND s.idReferencia=tP.id__625_tablaDinamica AND periodoBase=".$tipoAccion;
				
			break;
			case 2://Una vez aceptado el proceso por el despacho
				$consulta="SELECT * FROM _625_tablaDinamica tP,_654_tablaDinamica s WHERE tP.id__625_tablaDinamica=".$tipoProceso.
						" AND s.idReferencia=tP.id__625_tablaDinamica AND periodoBase=".$tipoAccion;
				
			break;
			case 3://Una vez notificado al demando
				
				$consulta="SELECT tipoNotificacion FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
				$tipoNotificacion=$con->obtenerValor($consulta);
				$consulta="SELECT * FROM _625_tablaDinamica tP,_654_tablaDinamica s WHERE tP.id__625_tablaDinamica=".$tipoProceso.
						" AND s.idReferencia=tP.id__625_tablaDinamica AND periodoBase=".$tipoAccion." and tipoNotificacion=".$tipoNotificacion;
				
			break;
			case 4://Al realizar una actuación
				
				$consulta="SELECT cmbActuaciones FROM _630_tablaDinamica WHERE id__630_tablaDinamica=".$idRegistro;
				$tipoActuacion=$con->obtenerValor($consulta);
				if($tipoActuacion=="")	
					$tipoActuacion=-1;                     
				$consulta="SELECT * FROM _625_tablaDinamica tP,_654_tablaDinamica s WHERE tP.id__625_tablaDinamica=".$tipoProceso.
						" AND s.idReferencia=tP.id__625_tablaDinamica AND periodoBase=".$tipoAccion." and tipoActuacion=".$tipoActuacion;
				
			break;
			case 5://Al agendar una audiencia
				
				$consulta="SELECT tipoAudiencia,horaInicioEvento FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND idRegistroSolicitud=".$idRegistro;
				$fEvento=$con->obtenerPrimeraFila($consulta);
				$tipoAudiencia=$fEvento[0];
				
				if($tipoAudiencia=="")	
					$tipoAudiencia=-1;                     
				$consulta="SELECT * FROM _625_tablaDinamica tP,_654_tablaDinamica s WHERE tP.id__625_tablaDinamica=".$tipoProceso.
						" AND s.idReferencia=tP.id__625_tablaDinamica AND periodoBase=".$tipoAccion." and tipoAudiencia=".$tipoAudiencia;
				$fechaActualRef=strtotime($fEvento[1]);
			break;
		}
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$intervalo="";
			if($fila["periodoTiempoRealizacion"]==1)
				$intervalo="days";
			else
				$intervalo="hours";
			$fechaActual=date("Y-m-d H:i:s",strtotime("+".$fila["tiempoRealizacion"]." ".$intervalo,$fechaActualRef));
			$arrValores=array();
			$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
			$arrValores["descripcion"]=$fila["tituloTermino"];
			$arrValores["valorReferencia1"]=-1;
			$arrValores["valorReferencia2"]="";
			$arrValores["tipoAlerta"]=7;
			$arrValores["diasRecordatorios"]=$fila["tiempoRecordatorio"];
			$arrValores["intervaloRecordario"]=$fila["periodoRecordatorio"];
			$arrValores["idTitularAlerta"]="NULL";
			$arrValores["fechaAlerta"]=$fechaActual;
			
			registrarAlertaNotificacionSistema($arrValores);
		}
		
		
	}
	
	function registrarAcuerdoCarpetaBase($idFormulario,$idRegistro,$idFormularioProceso)
	{
		global $con;
		return true;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idFormularioProceso=".$idFormularioProceso;
		$idRegistroDoc=$con->obtenerValor($consulta);
		if($idRegistroDoc!="")
		{
			
			$consulta="SELECT idDocumento FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$idRegistroDoc;
			$idDocumento=$con->obtenerValor($consulta);
			
			$arrCarpetas=array();
			$cBase=obtenerCarpetaBaseOriginal($carpetaAdministrativa);
			array_push($arrCarpetas,$cBase);
			$consulta="SELECT idTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
			$listaCarpetas=$con->obtenerListaValores($consulta);
			$lCarpetas=obtenerCarpetasDerivadas($cBase,$listaCarpetas);
			$arrCarpetasDerivadas=explode(",",$lCarpetas);
			
			foreach($arrCarpetasDerivadas as $c)
			{
				$c=str_replace("'","",$c);
				array_push($arrCarpetas,$c);
				
			}
			
			foreach($arrCarpetas as $c)
			{
				registrarDocumentoCarpetaAdministrativa($c,$idDocumento,$idFormulario,$idRegistro);	
				
			}
			
			
		}
		return true;
	}
	
	function existePermisoVisualizacion($idArchivo,$procesoJudicial=-1)
	{
		global $con;
		$consulta="SELECT perfilAcceso FROM 908_archivos WHERE idArchivo=".$idArchivo;
		$perfilAcceso=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM _659_gridRoles WHERE idReferencia=".$perfilAcceso;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			if(existeRol("'".$fila["rol"]."_0'"))
				return true;
		}
		
		
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$procesoJudicial."'";
		$idActividad=$con->obtenerValor($consulta);
		if($idActividad=="")
			$idActividad=-1;
		
		$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idCuentaAcceso=".$_SESSION["idUsr"];
		$listaFiguras=$con->obtenerListaValores($consulta);
		if($listaFiguras=="")
			$listaFiguras=-1;
		
		$consulta="SELECT count(*) FROM _659_gridTipoFigura WHERE idReferencia=".$perfilAcceso." and figura in(".$listaFiguras.")";
		$numFig=$con->obtenerValor($consulta);
		return $numFig>0;
	}
	
	
	function registrarEventoAsociadoProcesoJudicial($idFormulario,$idRegistro,$tituloEvento)
	{
		global $con;
		
		$consulta="SELECT COUNT(*) FROM 7006_registrosAsociadosCarpetaAdministrativa WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro;
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
			return true;
			
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			
			
		$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;	
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	
		
		$fechaRegistro=$fRegistro["fechaCreacion"];
		if(isset($fRegistro["fechaRecepcion"]) && $fRegistro["fechaRecepcion"]!="")
		{
			$fechaRegistro=$fRegistro["fechaRecepcion"]." ".$fRegistro["horaRecepcion"];
		}
			
		$consulta="INSERT INTO 7006_registrosAsociadosCarpetaAdministrativa(carpetaAdministrativa,iFormulario,iRegistro,fechaRegistro,tituloRegistroAsociado)
				VALUES('".$carpetaAdministrativa."',".$idFormulario.",".$idRegistro.",'".$fechaRegistro."','".cv($tituloEvento)."')";
				
				
		return $con->ejecutarConsulta($consulta);		
		
	}

?>
