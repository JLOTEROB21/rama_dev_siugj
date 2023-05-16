<?php include_once("conexionBD.php");

	function obtenerProcesoJudicialDespachoAsignado($idFormulario,$idRegistro)
	{
		global $con;
		$arrResultado=array();
		
		$consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$arrResultado["codigoInstitucion"]=$con->obtenerValor($consulta);
		$arrResultado["carpetaAdministrativa"]=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		
		switch($idFormulario)
		{
			case 944:
				$consulta="SELECT despachoAsignado,carpetaAdministrativa2daInstancia FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				if(($fRegistroBase["carpetaAdministrativa2daInstancia"]!="")&&($fRegistroBase["carpetaAdministrativa2daInstancia"]!="N/E"))
				{
					$arrResultado["codigoInstitucion"]=$fRegistroBase["despachoAsignado"];
					$arrResultado["carpetaAdministrativa"]=$fRegistroBase["carpetaAdministrativa2daInstancia"];
				}
			break;
		}
		
		
		return $arrResultado; 
		
	}

	function obtenerDetalleProcesoJudicialApelacionAuto($idFormulario,$idRegistro)
	{
		global $con;
		
		if($idFormulario!=944)
		{
			$arrDatosBase=obtenerRegistroPadre($idFormulario,$idRegistro);
			$idFormulario=$arrDatosBase["idFormulario"];
			$idRegistro=$arrDatosBase["idRegistro"];
			
		}
		$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;
		$fDatosApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$lblTipoApelacion="Sobre Sentencia";
		if($fDatosApelacion["tipoApelacion"]==1)
		{
			$lblTipoApelacion="Sobre Auto";
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDatosApelacion["autoRecurso"];
			$nombreAuto=$con->obtenerValor($consulta);
			$lblTipoApelacion.=" (".$nombreAuto.")";

		}
		$lblDetalle="'Folio: ".$fDatosApelacion["codigo"].", Tipo Apelación: ".$lblTipoApelacion."'";
		return $lblDetalle;
	}
	
	function obtenerDetalleProcesoActuacion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nombreInterviniente=obtenerNombreParticipante($fRegistro["promovente"]);
		
		$tipoApelacion="";
		if($fRegistro["tipoActuacion"]==25)
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistro["autoApelacion"];
			$nombreAuto=$con->obtenerValor($consulta);
			$tipoApelacion="<br>Auto: ".$nombreAuto;
		}
		
		$lblDetalle="'Folio: ".$fRegistro["codigo"].", Interviniente: ".$nombreInterviniente.$tipoApelacion."'";
		return $lblDetalle;
	}
	
	
	function obtenerDetalleProcesoApelacion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _930_tablaDinamica WHERE id__930_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nombreInterviniente=obtenerNombreParticipante($fRegistro["promovente"]);
		
		$tipoApelacion="";
		if($fRegistro["tipoApelacion"]==1)
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistro["autoRecurso"];
			$nombreAuto=$con->obtenerValor($consulta);
			$tipoApelacion="<br>Apelación sobre Auto: ".$nombreAuto;
		}
		else
		{
			$tipoApelacion="<br>Apelación sobre Sentencia";
		}
		
		$lblDetalle="'Folio: ".$fRegistro["codigo"].", Interviniente: ".$nombreInterviniente.$tipoApelacion."'";
		return $lblDetalle;
	}
	
	function obtenerDetalleProcesoGeneracionAuto($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fRegistro["tipoDocumento"];
		$nombreFormato=$con->obtenerValor($consulta);
		
		$lblDetalle="'Folio: ".$fRegistro["codigo"].", Tipo de Auto: ".$nombreFormato."'";
		return $lblDetalle;
	}
	
	function obtenerDetalleProcesoNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$fRegistro["tipoNotificacion"];
		$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	
		
		$consulta="SELECT asunto FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$asuntoMensaje=$con->obtenerValor($consulta);
		
		$detalleAdicional="<br>Destinatarios: ";
		
		$arrNotificados="";
		$consulta="SELECT * FROM _665_gPersonasNotificar WHERE idReferencia=".$fRegistro["id__665_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$fDetalle=((($fila["idPersona"]!=-1) && ($fila["idPersona"]!=""))?obtenerNombreParticipante($fila["idPersona"]):$fila["nombrePersona"]). " (".$fila["email"].")";
			if($arrNotificados=="")
				$arrNotificados=$fDetalle;
			else
				$arrNotificados.="<br>".$fDetalle;
		}
		
		$detalleAdicional.="<br><br>".$arrNotificados;
		$detalleAdicional.="<br><br>Documentos Adjuntos:";
		
		$arrNotificados="";
		$consulta="SELECT * FROM _665_gridDocumentosNotificar WHERE idReferencia=".$fRegistro["id__665_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$fDetalle=$fila["nombreDocumento"];
			if($arrNotificados=="")
				$arrNotificados=$fDetalle;
			else
				$arrNotificados.="<br>".$fDetalle;
		}
		
		$detalleAdicional.=($arrNotificados==""?"<br><br>(Sin Adjuntos)":("<br><br>".$arrNotificados));
		
		$lblDetalle="'Folio: ".$fRegistro["codigo"].", Asunto: ".$asuntoMensaje.$detalleAdicional."'";
		return $lblDetalle;
	}

	function obtenerDetalleProcesoProvidencia($idFormulario,$idRegistro)
	{
		global $con;
		
		
		
		$consulta="SELECT * FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT nombreActuacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$fRegistro["providenciaAplicar"];
		$nombreProvidencia=$con->obtenerValor($consulta);
		
		if($fRegistro["providenciaAplicar"]==15)
		{
			$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13376 AND valor=".$fRegistro["sentidoFalloSentencia"];
			$sentidoFalloSentencia=$con->obtenerValor($consulta);
			$nombreProvidencia.=", Sentido del Fallo: ".$sentidoFalloSentencia;
		}
		
		$lblDetalle="'Folio: ".$fRegistro["codigo"].", Providencia: ".$nombreProvidencia."'";

		return $lblDetalle;
	}
	
	
	function requiereCrearResumenActuacion($idFormulario,$idRegistro)
	{
		global $con;
		$cAdministrativa="";
		switch($idFormulario)
		{
			case 699:
				$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
				$cAdministrativa=$con->obtenerValor($consulta);
			break;
			default:
				$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			break;
		}
		
		
		$consulta="SELECT id__1056_tablaDinamica FROM _1056_tablaDinamica WHERE carpetaAdministrativa='".$cAdministrativa."'";

		$iRegistro=$con->obtenerValor($consulta);
		if($iRegistro=="")
			return 1;
		cambiarEtapaFormulario(1056,$iRegistro,1.5,"",-1,"NULL","NULL",0);
		cambiarEtapaFormulario(1056,$iRegistro,2,"",-1,"NULL","NULL",0);
		return 0;
		
	}
	
	function requiereCrearResumenActuacionMemorialAlegatos($idFormulario,$idRegistro)
	{
		global $con;
		$cAdministrativa="";
		switch($idFormulario)
		{
			case 699:
				$consulta="SELECT carpetaAdministrativaActuacionesIntervinientes FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
				$cAdministrativa=$con->obtenerValor($consulta);
			break;
			default:
				$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			break;
		}
		
		
		$consulta="SELECT id__1056_tablaDinamica FROM _1056_tablaDinamica WHERE carpetaAdministrativa='".$cAdministrativa."' and idEstado in(1.8,3.1)";

		$iRegistro=$con->obtenerValor($consulta);
		if($iRegistro=="")
			return 1;
		cambiarEtapaFormulario(1056,$iRegistro,2.1,"",-1,"NULL","NULL",0);
		return 0;
		
	}
	
	function requiereCrearResumenActuacionMemorialAlegatosVencida($idFormulario,$idRegistro)
	{
		global $con;
		$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT id__1056_tablaDinamica FROM _1056_tablaDinamica WHERE carpetaAdministrativa='".$cAdministrativa."' order by id__1056_tablaDinamica desc";
		$iRegistro=$con->obtenerValor($consulta);
		if($iRegistro=="")
			return 1;
		
		cambiarEtapaFormulario(1056,$iRegistro,2.1,"",-1,"NULL","NULL",0);
		return 0;
		
	}
	
	function obtenerTipoActuacionResumenMemoriales($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT tipoActuacion FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
		$tipoActuacion=$con->obtenerValor($consulta);
		
		return $tipoActuacion;
		
	}
	
	
	
	function requiereCrearResumenActuacionProcesoExternoTemporizador($idFormulario,$idRegistro)
	{
		global $con;
		$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idRegistroElementoMacroProceso FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		if($idRegistroElementoMacroProceso!="")
		{
			return 0;
		}
		
		$consulta="SELECT id__1056_tablaDinamica FROM _1056_tablaDinamica WHERE carpetaAdministrativa='".$cAdministrativa."'";

		$iRegistro=$con->obtenerValor($consulta);
		if($iRegistro=="")
			return 1;
		
		cambiarEtapaFormulario(1056,$iRegistro,2,"",-1,"NULL","NULL",0);
		return 0;
		
	}
	
	function requiereCrearResumenActuacionVencida($idFormulario,$idRegistro)
	{
		global $con;
		$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT id__1056_tablaDinamica FROM _1056_tablaDinamica WHERE carpetaAdministrativa='".$cAdministrativa."'";
		$iRegistro=$con->obtenerValor($consulta);
		if($iRegistro=="")
			return 1;
		
		cambiarEtapaFormulario(1056,$iRegistro,3,"",-1,"NULL","NULL",0);
		return 0;
		
	}
	
	
	function esProcesoCalificacionHuelga($idFormulario,$idRegistro)
	{
		global $con;
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";

		$tipoProceso=$con->obtenerValor($consulta);
		if($tipoProceso==13)
			return 1;
		return 0;
	}
	
	function cambiarEtapaRecursoSuplica($idFormulario,$idRegistro)
	{
		global $con;	
		$consulta="SELECT tipoDocumento,idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;

		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		
		switch($fRegistro["tipoDocumento"])
		{
			case 650://Se cofirma
				cambiarEtapaFormulario(1072,$fRegistro["idReferencia"],5.1,"",-1,"NULL","NULL",0);
			break;
			case 651: //Se revoca
				cambiarEtapaFormulario(1072,$fRegistro["idReferencia"],6.1,"",-1,"NULL","NULL",0);
			break;
		}
		$consulta="INSERT INTO 9074_documentosRegistrosProceso(idFormulario,idRegistro,idDocumento,tipoDocumento)
				SELECT '1072' as idFormulario,'".$fRegistro["idReferencia"]."' as idRegistro,idDocumento,tipoDocumento 
				FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND tipoDocumento=2";
		
		$con->ejecutarConsulta($consulta);
		return 1;
		
	}
	
	function existeVinculacionPartes($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="SELECT vinculacionAccionado FROM _1081_tablaDinamica WHERE idReferencia=".$idReferencia;
		$vinculacionAccionado=$con->obtenerValor($consulta);
		return $vinculacionAccionado==1?1:0;
	}
	
	function seSolicitanPruebasAdicionales($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="SELECT requierePruebaAdicional FROM _1081_tablaDinamica WHERE idReferencia=".$idReferencia;
		$vinculacionAccionado=$con->obtenerValor($consulta);
		return $vinculacionAccionado==1?1:0;
	}
	
	
	function seSolicitaPruebasDemandante($idFormulario,$idRegistro)
	{
		global $con;
		
		if(esDestinatarioNotificacionDemandante($idFormulario,$idRegistro)==0)
			return 0;
			
		$consulta="SELECT idReferencia FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idReferencia;
		$idEventoAudiencia=$con->obtenerValor($consulta);	
		
		
		$consulta="SELECT * FROM _1100_tablaDinamica WHERE idReferencia=".$idEventoAudiencia;
		$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		return $fAudiencia["pruebaActor"];
			
	}
	
	function seSolicitaPruebasDemandando($idFormulario,$idRegistro)
	{
		global $con;
		if(esDestinatarioNotificacionDemandado($idFormulario,$idRegistro)==0)
			return 0;
			
		$consulta="SELECT idReferencia FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idReferencia;
		$idEventoAudiencia=$con->obtenerValor($consulta);	
		
		
		$consulta="SELECT * FROM _1100_tablaDinamica WHERE idReferencia=".$idEventoAudiencia;
		$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		return $fAudiencia["pruebaDemandado"];
	}
	
	function seSolicitaCertificacionSuperIntendencia($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT COUNT(*) FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro." AND idPersona=480592";
		$numRegistros=$con->obtenerValor($consulta);
		if($numRegistros==0)
			return 0;
			
		$consulta="SELECT idReferencia FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idReferencia;
		$idEventoAudiencia=$con->obtenerValor($consulta);	
		
		
		$consulta="SELECT * FROM _1100_tablaDinamica WHERE idReferencia=".$idEventoAudiencia;
		$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		return $fAudiencia["certificacionSuperIntendencia"];
	}
	
	
	function esProcesoOrdinarioUnicaInstancia($idFormulario,$idRegistro)
	{
		global $con;
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";

		$tipoProceso=$con->obtenerValor($consulta);
		if($tipoProceso==20)
			return 1;
		return 0;
	}
	
	function esProcesoOrdinarioPrimeraInstancia($idFormulario,$idRegistro)
	{
		global $con;
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";

		$tipoProceso=$con->obtenerValor($consulta);
		if($tipoProceso!=20)
			return 1;
		return 0;
	}
	
	
	function obtenerIdUsuarioDemandadoProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica 
					IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
		$idCuentaAcceso=$con->obtenerValor($consulta);
	
		if($idCuentaAcceso=="")
		{
			$idCuentaAcceso=0;
		}
		
		return "'".$idCuentaAcceso."'";
			
	}
	
	function obtenerActorUsuarioDemandadoProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		

		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica 
					IN(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
		$idCuentaAcceso=$con->obtenerValor($consulta);
	
		if($idCuentaAcceso=="")
		{
			$idCuentaAcceso=0;
		}
		
		return "'".$idCuentaAcceso."'";
			
	}
	
	
	function esNotificacionSolicitudEmbargo($idFormulario,$idRegistro)
	{
		global $con;
		

		$consulta="SELECT tipoNotificacion FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$tipoNotificacion=$con->obtenerValor($consulta);
		if($tipoNotificacion==14)
			return 1;
		return 0;
	}
	
	function obtenerAuxiliarJusticiaDesignado($idFormulario,$idRegistro)
	{
		global $con;
		/*$consulta="SELECT idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		
		$consulta="SELECT auxiliarJusticia FROM _1194_tablaDinamica WHERE idReferencia=".$idReferencia;
		$auxiliarJusticia=$con->obtenerValor($consulta);
		$consulta="SELECT idUsuario FROM _1177_tablaDinamica WHERE id__1177_tablaDinamica=".$auxiliarJusticia;
		$idUsuario=$con->obtenerValor($consulta);*/
		
		$idUsuario=4403;
		return "'".$idUsuario."'";
	}
	
	function existeApelacionProcesoOrdinarioPrimeraInstancia($idFormulario,$idRegistro)
	{
		global $con;

		if(esProcesoOrdinarioPrimeraInstancia($idFormulario,$idRegistro))
		{
			$consulta="SELECT * FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
			$fDatosAuto=$con->obtenerPrimeraFilaAsoc($consulta);
			$idAudiencia=$fDatosAuto["idReferencia"];
			
			$consulta="SELECT * FROM _782_tablaDinamica WHERE idReferencia=".$idAudiencia;
			$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($fAudiencia)
			{
				if(($fAudiencia["sentenciaApelada"]==1)&&($fAudiencia["concedeApelacion"]==1))
				{
					return 1;
				}
			}
			
		}

		return 0;
	}
	
	
	function ejecutarDisparadoresMacroProceso($idMacroProceso,$iFormulario,$iRegistro)
	{
		global $con;	
//		echo $idMacroProceso."_".$idMacroProceso."_".$iRegistro."<br>";
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($iFormulario,$iRegistro);
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$tipoProceso=$con->obtenerValor($consulta);
		
		
		
		switch($idMacroProceso)
		{

			case 1: //Juicios Ordinarios
				$arrJuiciosOrdinarios["1"]=1;
				$arrJuiciosOrdinarios["3"]=1;
				$arrJuiciosOrdinarios["4"]=1;
				$arrJuiciosOrdinarios["5"]=1;
				$arrJuiciosOrdinarios["16"]=1;
				$arrJuiciosOrdinarios["20"]=1;
				if(isset($arrJuiciosOrdinarios[$tipoProceso]))
				{
					return 1;
				}
			break;
			case 2: //Segunda Instancia
				$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$tipoCarpetaAdministrativa=$con->obtenerValor($consulta);
				if($tipoCarpetaAdministrativa==2)
					return 1;
				return 0;
			break;
			case 3: //Exequatur
				if($tipoProceso==9)
				{
					return 1;
				}
			break;
			
			case 4: //Registro de Nulidad Laudo Arbitral
				if($tipoProceso==15)
				{
					return 1;
				}
			break;
			case 5: //Calificacion de Huelga
				if($tipoProceso==13)
				{
					return 1;
				}
			break;
			case 6: //Recurso de Casacion
				return 1;
			break;
			case 7: //Tutela
				if($tipoProceso==6)
				{
					return 1;
				}
			break;
			case 8: //Medio de Control de Nulidad
				$arrJuiciosNulidad["7"]=1;
				$arrJuiciosNulidad["10"]=1;
				$arrJuiciosNulidad["11"]=1;
				$arrJuiciosNulidad["12"]=1;
				if(isset($arrJuiciosNulidad[$tipoProceso]))
				{
					return 1;
				}
			break;
			case 9: //Accion Pública de Incostitucionalidad
				if($tipoProceso==8)
				{
					return 1;
				}
			break;
			case 10: //Recurso de Revisión
				if($tipoProceso==19)
				{
					return 1;
				}
			break;
			case 12: //Embargo y secuestro
					return 1;

			break;
			case 13: //Depósitos judiciales
				return 1;
			break;
		}
		
		
		return 0;
		
		
		
	}
	
	function esActuacionDemandanteProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT promovente FROM _967_tablaDinamica WHERE id__967_tablaDinamica=".$idRegistro;
		$promovente=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*)FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE idActividad=".$idActividad." AND idParticipante=".$promovente."
    				AND r.idFiguraJuridica=f.id__5_tablaDinamica AND f.naturalezaFigura='A'";
		
		
		$numReg=$con->obtenerValor($consulta);
		
		return $numReg>0?1:0;
		
		
	}
	
	function esActuacionDemandoProcesoJudicial($idFormulario,$idRegistro)
	{
		global $con;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT promovente FROM _967_tablaDinamica WHERE id__967_tablaDinamica=".$idRegistro;
		$promovente=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*)FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE idActividad=".$idActividad." AND idParticipante=".$promovente."
    				AND r.idFiguraJuridica=f.id__5_tablaDinamica AND f.naturalezaFigura='D'";
		
		
		$numReg=$con->obtenerValor($consulta);
		
		return $numReg>0?1:0;
		
		
	}

	function enviarApelacionEstudio($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT * FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$fDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fDocumento["idProcesoPadre"]==330)
			cambiarEtapaFormulario(944,$fDocumento["idReferencia"],10,"",-1,"NULL","NULL",0);
		return true;
	}
	
	
	function obtenerFolioProcesoTableroControl($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT codigo FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$codigo=$con->obtenerValor($consulta);
		return "'".$codigo."'";
		
		
	}
	
?>