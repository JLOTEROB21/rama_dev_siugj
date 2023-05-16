<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obteneInformacionOficioOrigen();
		break;
		case 2:
			obtenerUsuariosRespuestaDocumentos();
		break;
		case 3:
			obtenerOficiosUGASDestinatarios();
		break;
	}
	
	function obteneInformacionOficioOrigen()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$consulta="SELECT idRegistroFormato,fechaRegistro,carpetaAdministrativa FROM 7047_registroDocumentosRelacion WHERE idRegistro=".$idRegistro;
		$fDatosBase=$con->obtenerPrimeraFila($consulta);
		$idRegistroFormatoResponde=$fDatosBase[0];
		
		$consulta="SELECT idFormulario,idRegistro,fechaRegistro,responsableFirma FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$idRegistroFormatoResponde;
		$filaDocumentoResponde=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT datosParametros FROM 7035_informacionDocumentos WHERE idRegistro=".$filaDocumentoResponde[1];
		$filaInfoDocumento=$con->obtenerPrimeraFila($consulta);
		
		$arrCarpetasAntecesoras=obtenerCarpetasAntecesoras($fDatosBase[2]);
		$listaCarpetasAntecesoras="";
		foreach($arrCarpetasAntecesoras as $c)
		{
			if($listaCarpetasAntecesoras=="")
			{
				$listaCarpetasAntecesoras="'".$c."'";
			}
			else
				$listaCarpetasAntecesoras.=",'".$c."'";
		}
		
		
		$imputado="";
		$noOficioResponde="";
		$fechaOficio="";
		$fechaVinculacionProceso="";
		$nombreDestinatario="";
		$puestoDestinatario="";
		if($filaInfoDocumento[0]!='')
		{
			$obj=json_decode(bD($filaInfoDocumento[0]));
			$imputado=$obj->imputados;
			
			$consulta="SELECT carpetaInvestigacion,idActividad,carpetaAdministrativaBase,unidadGestion 
						FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->carpetaJudicial."'";
			$filaCarpeta=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT nombreUnidad,claveFolioCarpetas FROM _17_tablaDinamica WHERE  claveUnidad='".$filaCarpeta[3]."'";
			$filaUGA=$con->obtenerPrimeraFila($consulta);
			
			$noUGA=$filaUGA[1]*1;
			
			
			$noOficioResponde="UGJ".$noUGA."/".str_pad($obj->noOficioAsignar,4,"0",STR_PAD_LEFT)."/".date("Y",strtotime($filaDocumentoResponde[2]));
			$fechaOficio=date("Y-m-d",strtotime($fDatosBase[1]));
			$consulta="SELECT e.fechaEvento FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,3013_registroResolutivosAudiencia r 
						WHERE con.carpetaAdministrativa in(".$listaCarpetasAntecesoras.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento 
						AND r.idEvento=e.idRegistroEvento AND r.tipoResolutivo=50 and r.valor=1";
			$fechaVinculacionProceso=$con->obtenerValor($consulta);
		}
		
		$idDestinatario=$filaDocumentoResponde[3]!=""?$filaDocumentoResponde[3]:-1;
		$nombreDestinatario=mb_strtoupper(obtenerNombreUsuario($idDestinatario));
		if($idDestinatario!=-1)
		{
			$consulta="SELECT puestoOrganozacional FROM _421_tablaDinamica WHERE usuarioAsignado=".$idDestinatario." AND fechaInicioFunciones<='".date("Y-m-d").
					"' ORDER BY fechaInicioFunciones DESC";
			$puestoOrganozacional=$con->obtenerValor($consulta);
			if($puestoOrganozacional=="")
			{
				$consulta="SELECT * FROM _26_tablaDinamica WHERE usuarioJuez=".$idDestinatario;
				$filaJuez=$con->obtenerPrimeraFila($consulta);
				if($filaJuez)
				{
					$consulta="SELECT tipoMateria FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$filaJuez[1];
					$tipoMateria=$con->obtenerValor($consulta);
					if($tipoMateria==2)
						$puestoDestinatario="JUEZ DEL SISTEMA PROCESAL PENAL ACUSATORIO EN \nMATERIA DE JUSTICIA PARA ADOLESCENTES \nDE LA CIUDAD DE MÉXICO";
					else
						$puestoDestinatario="JUEZ DEL SISTEMA PROCESAL PENAL ACUSATORIO \nDE LA CIUDAD DE MÉXICO";
						
				}
			}
			else
			{
				$consulta="SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=".$puestoOrganozacional;
				$puestoDestinatario=$con->obtenerValor($consulta);
			}
		}
		echo '1|[{"imputado":"'.$imputado.'","noOficioResponde":"'.cv($noOficioResponde).'","fechaOficio":"'.$fechaOficio.
				'","fechaVinculacionProceso":"'.$fechaVinculacionProceso.'","nombreDestinatario":"'.cv($nombreDestinatario).
				'","puestoDestinatario":"'.cv($puestoDestinatario).'"}]';
		
		
	}
	
	
	function obtenerUsuariosRespuestaDocumentos()
	{
		global $con;
		$iT=$_POST["iT"];
		$cD=$_POST["cD"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);

		$idRol="";
		switch($cD)
		{
			case 52://Oficio para USMECA
				$idRol="185";
			break;
			case 60://Oficio para INCIFO
				$idRol="192";
			break;
		}
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT u.idUsuario,u.Nombre FROM 807_usuariosVSRoles ur,800_usuarios u WHERE idRol=".$idRol." AND u.idUsuario=ur.idUsuario
					AND u.cuentaActiva=1 and ".$cadCondWhere." ORDER BY u.Nombre";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE idUsuarioDestinatario=".$fila[0]." AND idNotificacion=-10";
			$tareasAsignadas=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE idUsuarioDestinatario=".$fila[0]." AND idNotificacion=-10 and idNotificacionBase=".$iT;
			$asignado=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE idUsuarioDestinatario=".$fila[0]." AND idNotificacion=-10 and idEstado=2";
			$tareasAtendidas=$con->obtenerValor($consulta);
			$o='{"idUsuario":"'.$fila[0].'","nombre":"'.cv($fila[1]).'","tareasAsignadas":"'.$tareasAsignadas.
			'","tareasAtendidas":"'.$tareasAtendidas.'","tareasPorAtender":"'.($tareasAsignadas-$tareasAtendidas).'","asignado":"'.$asignado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
														
														
																
														
	}
	
	
	function obtenerOficiosUGASDestinatarios()
	{
		global $con;
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$unidadGestion=$_POST["unidadGestion"];
		$tipoOficio=$_POST["tipoOficio"];
		
		
		$consulta="SELECT f.fechaFirma,i.carpetaAdministrativa,c.unidadGestion,d.nombreFormato,f.idRegistroFormato,idDocumento FROM 7035_informacionDocumentos i,3000_formatosRegistrados f, _10_tablaDinamica d,
					7006_carpetasAdministrativas c
					WHERE f.firmado=1 and f.fechaFirma>='2019-09-17' and f.fechaFirma>='".$fechaInicio."' AND f.fechaFirma<='".$fechaFin." 23:59:59' AND f.idFormulario=-2 
					AND f.idRegistro=i.idRegistro AND d.id__10_tablaDinamica=f.tipoFormato
					AND d.categoriaDocumento IN(".$tipoOficio.") and i.carpetaAdministrativa=c.carpetaAdministrativa "; 
		if($unidadGestion!="0")
		{
			$consulta="SELECT f.fechaFirma,i.carpetaAdministrativa,c.unidadGestion,d.nombreFormato,f.idRegistroFormato,idDocumento FROM 7035_informacionDocumentos i,3000_formatosRegistrados f, _10_tablaDinamica d,7006_carpetasAdministrativas c
						WHERE f.firmado=1 and f.fechaFirma>='2019-09-17'  AND f.fechaFirma>='".$fechaInicio."' AND f.fechaFirma<='".$fechaFin." 23:59:59' AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro 
						AND d.id__10_tablaDinamica=f.tipoFormato AND d.categoriaDocumento IN(".$tipoOficio.") AND i.carpetaAdministrativa=c.carpetaAdministrativa 
						AND c.unidadGestion='".$unidadGestion."' ORDER BY f.fechaFirma"	;		
		}

		$arrRegistros="";
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$consulta="SELECT idRegistro,carpetaAdministrativa FROM 7047_registroDocumentosRelacion WHERE idRegistroFormato=".$fila["idRegistroFormato"];
			$fRegistroBase=$con->obtenerPrimeraFila($consulta);			
			
			$arrDocumentosRespuesta="";
			
			$fechaRespuesta="";
			$consulta="SELECT f.* FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE carpetaAdministrativa='".$fRegistroBase[1]."'  
				and i.idFormulario=-5 AND i.idReferencia=".($fRegistroBase[0]==""?-1:$fRegistroBase[0])."  and f.idFormulario=-2 AND f.idRegistro=i.idRegistro 
				and (f.firmado=1 or (f.documentoBloqueado=1 AND f.idDocumentoAdjunto IS NOT NULL)) ORDER BY fechaCreacion";			
			$resRespuesta=$con->obtenerFilas($consulta);
			while($filaRespuesta=mysql_fetch_assoc($resRespuesta))
			{

				$fechaRespuesta=$filaRespuesta["fechaFirma"]==""?$filaRespuesta["fechaRegistro"]:$filaRespuesta["fechaFirma"];
				$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$filaRespuesta["idDocumento"];
				$nomArchivoOriginal=$con->obtenerValor($consulta);
				$o="['".$filaRespuesta["idDocumento"]."','".cv($nomArchivoOriginal)."','".$fechaRespuesta."']";
				if($arrDocumentosRespuesta=="")
					$arrDocumentosRespuesta=$o;
				else
					$arrDocumentosRespuesta.=",".$o;
			}
			
			$situacionRespuesta=0;
			if($arrDocumentosRespuesta!="")
				$situacionRespuesta=1;
			
			$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE iFormulario=-5 AND iRegistro=".$fila["idRegistroFormato"];
			$totalTareasEmitidas=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE iFormulario=-5 AND iRegistro=".$fila["idRegistroFormato"]." and fechaVisualizacion is not null";
			$totalTareasVisualizadas=$con->obtenerValor($consulta);
			$objDoc='{"fechaRegistro":"'.$fila["fechaFirma"].'","carpetaJudicial":"'.$fila["carpetaAdministrativa"].'","unidadGestion":"'.$fila["unidadGestion"].
					'","tipoSolicitud":"'.$fila["nombreFormato"].'","situacionRespuesta":"'.$situacionRespuesta.'","totalTareasEmitidas":"'.$totalTareasEmitidas.'",
					"totalTareasVisualizadas":"'.$totalTareasVisualizadas.'","folioRegistro":"'.$fila["idRegistroFormato"].'","fechaRespuesta":"'.$fechaRespuesta.
					'","idDocumento":"'.$fila["idDocumento"].'","arrDocumentosRespuesta":['.$arrDocumentosRespuesta.'],"iFormulario":"-5","iRegistro":"'.
					$fila["idRegistroFormato"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$objDoc;
			else	
				$arrRegistros.=",".$objDoc;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';	
	}
?>