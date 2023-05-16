<?php session_start();
	include_once("conexionBD.php");
	include_once("funcionesActores.php");
	include_once("utiles.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");


	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerInfoCodigoProcesoUnico();
		break;
		case 2:
			obtenerPlantillaNotificacion();
		break;
		case 3:
			obtenerDocumentosGeneradosAudiencia();
		break;
		case 4:
			registrarTipoDocumentoGeneradosAudiencia();
		break;
		case 5:
			obtenerActorTipoDocumentoGeneradosAudiencia();
		break;
		case 6:
			cancelarDocumentoAudiencia();
		break;
		case 7:
			obtenerResultadosBusquedaProcesoGeneral();
		break;
		case 8:
			registrarNotificacionMensajeSedeJudicial();
		break;
		case 9:
			obtenerReporteEstado();
		break;
		case 10:
			obtenerTutelasRecibidas();
		break;
		case 11:	
			crearPaqueteTutelas();
		break;
		case 12:
			obtenerPaqueteTutelasRecibidas();
		break;
		case 13:
			registrarTutelasPaquete();
		break;
		case 14:	
			removerTutelasPaquete();
		break;
		case 15:	
			obtenerInformacionTutela();
		break;
		case 16:	
			obtenerVotacionesMagistradosRevisionTutela();
		break;
		case 17:
			aperturarVotacionMagistrado();
		break;
		case 18:
			registrarResultadoVotacion();
		break;
		case 19:
			obtenerFechasInhabiles();
		break;
		case 20:
			obtenerInformacionAmbitosAplicacion();
		break;
		case 21:
			obtenerDistritosAmbitosAplicacion();
		break;
		case 22:
			obtenerCircuitosAmbitosAplicacion();
		break;
		case 23:
			obtenerMunicipiosAmbitosAplicacion();
		break;
		case 24:
			obtenerDespachoAmbitosAplicacion();
		break;
		case 25:
			registrarFechaAmbitosAplicacion();
		break;
		case 26:
			removerFechaAmbitosAplicacion();
		break;
		
		
		case 27:
			obtenerDistritosAmbitosAplicacionPerfilLaboral();
		break;
		case 28:
			obtenerCircuitosAmbitosAplicacionPerfilLaboral();
		break;
		case 29:
			obtenerMunicipiosAmbitosAplicacionPerfilLaboral();
		break;
		case 30:
			obtenerDespachoAmbitosAplicacionPerfilLaboral();
		break;
		case 31:
			registrarFechaAmbitosAplicacionPerfilLaboral();
		break;
		case 32:
			obtenerPerfilesLaborales();
		break;
		case 33:
			obtenerInformacionAmbitosAplicacionPerfilesLaborales();
		break;
		case 34:
			obtenerHorarioPerfilesLaborales();
		break;
		case 35:
			removerAmbitosAplicacionPerfilesLaborales();
		break;
		case 36:
			compartirReporte();
		break;
		case 37:
			obtenerEventosAudienciaSIUGJ();
		break;
		case 38:
			obtenerActuacionesSIUGJ();
		break;
		case 39:
			obtenerNotificacionesSIUGJ();
		break;
		case 40:
			registrarPerfilCuentaServiciosAmbitosAplicacionPerfilLaboral();
		break;
		case 41:
			obtenerPerfilesCuentasServiciosNube();
		break;
		case 42:
			removerPerfilesCuentasServiciosNube();
		break;
		case 43:
			obtenerIdRegistroResolutivos();
		break;
		case 44:
			verificarBloqueoResolutivos();
		break;
		case 45:
			registrarRepartoManual();
		break;
		case 46:
			consultarEmpleadoCC();
		break;
	}


	function obtenerInfoCodigoProcesoUnico($cupj="")
	{
		global $con;
		
		$vReasignacion=0;
		if(isset($_POST["vReasignacion"]))
			$vReasignacion=$_POST["vReasignacion"];
		
		
		if(isset($_POST["cupj"]))
			$cupj=$_POST["cupj"];
		
		$lblNombreAuto="";
		$arrCUPS=explode(",",$cupj);
		
		$arrEtiquetasAdicionales=array();
		$arrCamposProyecta=array();
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$arrCUPS[0]."'";
		$fRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);


		if($fRegistroCarpeta["tipoCarpetaAdministrativa"]==60)
		{
			
		  $fRegistro=$fRegistroCarpeta;
		  
		  $consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
		  $despacho=$con->obtenerValor($consulta);
		  
		  $especialidad="";
		  $claseProceso="";
		  $subClaseProceso="";
		  $tema="";
		  $subTemaProceso="";
		  $tipoProceso="";
		  
		  $consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
		  $tipoProceso=$con->obtenerValor($consulta);
		  
		  
		  $demantante="";
		  $consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					  FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					  AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
		  
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
					  AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
		  
		  $res=$con->obtenerFilas($consulta);
		  while($filaImputado=$con->fetchRow($res))
		  {
			  $nombre=trim($filaImputado[0]);
			  if($demandados=="")
				  $demandados=$nombre;
			  else
				  $demandados.=", ".$nombre;
		  }
		  
		  

		  
		  $departamento="";
		  $municipio="";
		  $leyenda="";
		  $fRegistroBase=array();
		  
		  

		  $fRegistroBase["tituloProceso"]="";
	

	  
		  $consulta="SELECT * FROM _1163_tablaDinamica WHERE id__1163_tablaDinamica=".$fRegistroCarpeta["idRegistro"];
		  $fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		  $arrCamposProyecta["Tipo de Proceso"]=cv($tipoProceso);
		  $arrCamposProyecta["Consignatario"]=cv($demantante);
		  $arrCamposProyecta["Beneficiarios"]=cv($demandados);
		  $arrCamposProyecta["Despacho"]=cv($despacho);
		  $arrCamposProyecta["Cuantía"]=cv("$ ".number_format($fRegistroBase["cuantia"],2));
			  
		  
		  
		  
		  
		  $leyenda=generarTablaProcesoJudicial($arrCamposProyecta);
		  
		  $obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				  '","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			  cv($tipoProceso).'","tituloProceso":"'.cv(isset($fRegistroBase["tituloProceso"])?$fRegistroBase["tituloProceso"]:"").'","demandantes":"'.cv($demantante).
			  '","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			  '","leyenda":"'.$leyenda.'"}';
	  
		  echo "1|".$obj;
			return;
		}
		
		
		if($fRegistroCarpeta["tipoCarpetaAdministrativa"]==61)
		{
			
		  $fRegistro=$fRegistroCarpeta;
		  
		  $consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
		  $despacho=$con->obtenerValor($consulta);
		  
		  $especialidad="";
		  $claseProceso="";
		  $subClaseProceso="";
		  $tema="";
		  $subTemaProceso="";
		  $tipoProceso="";
		  
		  $consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
		  $tipoProceso=$con->obtenerValor($consulta);
		  
		  $consulta="SELECT * FROM _1204_tablaDinamica WHERE id__1204_tablaDinamica=".$fRegistroCarpeta["idRegistro"];
		  $fRegistroCosta=$con->obtenerPrimeraFilaAsoc($consulta);
		  
		  $consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistroCosta["carpetaAdministrativa"]."'";
		  $fRegistroCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
		  
		  $demantante="";
		  $consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					  FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					  AND r.idActividad=".$fRegistroCarpetaBase["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
		  
		  $res=$con->obtenerFilas($consulta);
		  while($filaImputado=$con->fetchRow($res))
		  {
			  $nombre=trim($filaImputado[0]);
			  if($demantante=="")
				  $demantante=$nombre;
			  else
				  $demantante.=", ".$nombre;
		  }
		  
		  $departamento="";
		  $municipio="";
		  $leyenda="";
		  $fRegistroBase=array();
		  
		  

		  $fRegistroBase["tituloProceso"]="";
		  
		  $demandados="";
		  $consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					  FROM _47_tablaDinamica where id__47_tablaDinamica=".$fRegistroCosta["promoventeCostes"]." ORDER BY nombre,nombre,apellidoMaterno";
		  
		  $res=$con->obtenerFilas($consulta);
		  while($filaImputado=$con->fetchRow($res))
		  {
			  $nombre=trim($filaImputado[0]);
			  if($demandados=="")
				  $demandados=$nombre;
			  else
				  $demandados.=", ".$nombre;
		  }
		  
		  
		  
		  
		  $arrCamposProyecta["Tipo de Proceso"]=cv($tipoProceso);
		  $arrCamposProyecta["Consignatario"]=cv($demantante);
		  $arrCamposProyecta["Beneficiarios"]=cv($demandados);
		  $arrCamposProyecta["Despacho"]=cv($despacho);
		  $arrCamposProyecta["Cuantía"]=cv("$ ".number_format($fRegistroCosta["montoCostes"],2));
			
		  $leyenda=generarTablaProcesoJudicial($arrCamposProyecta);
		  
		  $obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				  '","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			  cv($tipoProceso).'","tituloProceso":"'.cv(isset($fRegistroBase["tituloProceso"])?$fRegistroBase["tituloProceso"]:"").'","demandantes":"'.cv($demantante).
			  '","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			  '","leyenda":"'.$leyenda.'"}';
	  
		  echo "1|".$obj;
			return;
		}
		

		if($fRegistroCarpeta["tipoCarpetaAdministrativa"]==3)
		{
			
			$arrCarpetas=array();
			obtenerCarpetasPadre($arrCUPS[0],$arrCarpetas);
			
			if(sizeof($arrCarpetas)==0)
			{
				array_push($arrCarpetas,$carpetaAdministrativo);
			}
			
			$carpetaAdministrativaBase=$arrCarpetas[0];	
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' and tipoCarpetaAdministrativa=1";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
			$despacho=$con->obtenerValor($consulta);
			
			$especialidad="";
			$claseProceso="";
			$subClaseProceso="";
			$tema="";
			$subTemaProceso="";
			$tipoProceso="";
			
			if($fRegistro["tipoProceso"]!=6)
			{
				$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".$fRegistro["especialidad"];
				$especialidad=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistro["claseProceso"];
				$claseProceso=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreSubclaseProceso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fRegistro["subclaseProceso"];
				$subClaseProceso=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreTema FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRegistro["tema"];
				$tema=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreSubtema FROM _629_tablaDinamica WHERE id__629_tablaDinamica=".$fRegistro["subtema"];
				$subTemaProceso=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
				$tipoProceso=$con->obtenerValor($consulta);
			}
			else
			{
				$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
				$tipoProceso=$con->obtenerValor($consulta);
			}
			
			
			
			$demantante="";
			
			
			
			
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
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
						AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			
			$arrCarpetas=array();
			obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
			if(sizeof($arrCarpetas)==0)
			{
				array_push($arrCarpetas,$fRegistro["carpetaAdministrativa"]);
			}
			
			$carpetaBase=$arrCarpetas[0];
			
			$lblDespachoSegundaInstancia="";
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$arrCUPS[0]."' and tipoCarpetaAdministrativa=3 order by idCarpeta desc";
			$fRegistro2=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($fRegistro2)
			{
				$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro2["unidadGestion"]."'";
				$despacho2=$con->obtenerValor($consulta);
				if($vReasignacion==0)
				{
					$arrEtiquetasAdicionales["Despacho de Segunda Instancia"]=cv($despacho2);
				}
				$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$fRegistro2["idRegistro"];
				$fDatosApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13166 AND valor='".$fDatosApelacion["tipoApelacion"]."'";
				$tipoApelacion=$con->obtenerValor($consulta);
				
				if($fDatosApelacion["tipoApelacion"]==1)
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDatosApelacion["autoRecurso"];
					$nombreAuto=$con->obtenerValor($consulta);
					$tipoApelacion.=": ".$nombreAuto."";

					$arrEtiquetasAdicionales["Tipo de Apelaci&oacute;n"]=cv($tipoApelacion);
				}
				

				
			}
			
			
			$departamento="";
			$municipio="";
			$leyenda="";
			$fRegistroBase=array();
		
			$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
			$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
			$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
			$departamento=$con->obtenerValor($consulta);
		
			$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
			$municipio=$con->obtenerValor($consulta);
			
			if($especialidad!="")
			{
				$arrCamposProyecta["Especialidad"]=cv($especialidad);
				
			}
			if($tipoProceso!="")
			{
				$arrCamposProyecta["Tipo de Proceso"]=cv($tipoProceso);
				
			}
			
			$lugarRadicacion="";
			if($municipio!="")
			{
				$lugarRadicacion=$municipio;
				
			}
			
			if($departamento!="")
			{
				if($lugarRadicacion=="")
					$lugarRadicacion=$departamento;
				else
					$lugarRadicacion.=", ".$departamento;
				
			}
			
			
			if($lugarRadicacion!="")
			{
				$arrCamposProyecta["Lugar de Radicaci&oacute;n"]=cv($lugarRadicacion);
				
			}
			
			
			$arrCamposProyecta["Demandante"]=cv($demantante);
			$arrCamposProyecta["Demandado"]=cv($demandados);
			$arrCamposProyecta["Despacho"]=cv($despacho);
			
			
			foreach($arrEtiquetasAdicionales as $etiqueta=>$valor)
			{
				$arrCamposProyecta[$etiqueta]=$valor;
			}

			$leyenda=generarTablaProcesoJudicial($arrCamposProyecta);
			
			
			
			$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
					'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
				cv($tipoProceso).'","tituloProceso":"'.cv(isset($fRegistroBase["tituloProceso"])?$fRegistroBase["tituloProceso"]:"").'","demandantes":"'.cv($demantante).
				'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
				'","leyenda":"'.$leyenda.'"}';
		
			echo "1|".$obj;
		}
		else
		{
			if($fRegistroCarpeta["tipoCarpetaAdministrativa"]==40)
			{
				$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistroCarpeta["unidadGestion"]."'";
				$despacho=$con->obtenerValor($consulta);
				$especialidad="";
				$claseProceso="";
				$subClaseProceso="";
				$tema="";
				$subTemaProceso="";
				$tipoProceso=6;
				
				
				$consulta="SELECT COUNT(*) FROM _917_tablaDinamica WHERE idReferencia=".$fRegistroCarpeta["idRegistro"];
				$totalTutelas=$con->obtenerValor($consulta);
				
				
				$arrCamposProyecta["Tipo de Expediente"]="Paquete de Tutelas para Revisi&oacute;n";
				
				$arrCamposProyecta["Despacho"]=cv($despacho);
				$arrCamposProyecta["Total de Tutelas Contenidas"]=cv($totalTutelas);
				
				$leyenda=generarTablaProcesoJudicial($arrCamposProyecta);
				
				$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
						'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
					cv($tipoProceso).'","tituloProceso":"","demandantes":"","demandado":"","departamento":"","municipio":"","leyenda":"'.cv($leyenda).'"}';
			
				echo "1|".$obj;
				
			}
			else
			{
				$arrCarpetas=array();
				if($fRegistroCarpeta["tipoCarpetaAdministrativa"]!=1)
				{
				
					obtenerCarpetasPadre($arrCUPS[0],$arrCarpetas);
				}
				if(sizeof($arrCarpetas)==0)
				{
					array_push($arrCarpetas,$arrCUPS[0]);
				}
	
				$carpetaBase=$arrCarpetas[0];
				
				$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaBase."' and tipoCarpetaAdministrativa in(1)";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				
				$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
				$despacho=$con->obtenerValor($consulta);
				
				$especialidad="";
				$claseProceso="";
				$subClaseProceso="";
				$tema="";
				$subTemaProceso="";
				$tipoProceso="";
				
				switch($fRegistro["tipoProceso"])
				{
					case 6:
						$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
						$tipoProceso=$con->obtenerValor($consulta);
					break;
					default:
					
						$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".($fRegistro["especialidad"]==""?-1:$fRegistro["especialidad"]);
						$especialidad=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".($fRegistro["claseProceso"]==""?-1:$fRegistro["claseProceso"]);
						$claseProceso=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreSubclaseProceso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".($fRegistro["subclaseProceso"]==""?-1:$fRegistro["subclaseProceso"]);
						$subClaseProceso=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreTema FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".($fRegistro["tema"]==""?-1:$fRegistro["tema"]);
						$tema=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreSubtema FROM _629_tablaDinamica WHERE id__629_tablaDinamica=".($fRegistro["subtema"]==""?-1:$fRegistro["subtema"]);
						$subTemaProceso=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".($fRegistro["tipoProceso"]==""?-1:$fRegistro["tipoProceso"]);
						$tipoProceso=$con->obtenerValor($consulta);
					break;
				}
				
				
				$demantante="";
				$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
							FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
							AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
				
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
							AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
				
				$res=$con->obtenerFilas($consulta);
				while($filaImputado=$con->fetchRow($res))
				{
					$nombre=trim($filaImputado[0]);
					if($demandados=="")
						$demandados=$nombre;
					else
						$demandados.=", ".$nombre;
				}
				
				$lblDespachoSegundaInstancia="";
				$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$arrCUPS[0]."' and tipoCarpetaAdministrativa=2 order by idCarpeta DESC";
				$fRegistro2=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fRegistroCarpeta["tipoCarpetaAdministrativa"]==20)
				{
					$arrCarpetasHistorial=array();
					obtenerCarpetasPadre($arrCUPS[0],$arrCarpetasHistorial);
					
					if(sizeof($arrCarpetasHistorial)==0)
					{
						array_push($arrCarpetasHistorial,$arrCUPS[0]);
					}
					$pos=count($arrCarpetasHistorial)-1;
					for(count($arrCarpetasHistorial)-1;$pos>0;$pos--)
					{
						$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$arrCarpetasHistorial[$pos]."'   order by idCarpeta DESC";
						$fRegistro2=$con->obtenerPrimeraFilaAsoc($consulta);
						if(($fRegistro2["tipoCarpetaAdministrativa"]==2)||($fRegistro2["tipoCarpetaAdministrativa"]==3))
						{
							break;
						}
					}
					
					
					
					$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro2["unidadGestion"]."'";
					$despacho2=$con->obtenerValor($consulta);
					//if($vReasignacion==0)
					
					$arrEtiquetasAdicionales["Despacho de Segunda Instancia"]=cv($despacho2);
					if($tipoProceso=="")
						$tipoProceso="RECURSO DE CASACIÓN";
					else
						$tipoProceso.=" (RECURSO DE CASACIÓN)";
					
					
				}
				if($fRegistro2)
				{
					$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro2["unidadGestion"]."'";
					$despacho2=$con->obtenerValor($consulta);
					if($vReasignacion==0)
					{

						$arrEtiquetasAdicionales["Despacho de Segunda Instancia"]=cv($despacho2);
					
					}
					$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$fRegistro2["idRegistro"];
					$fDatosApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13166 AND valor='".$fDatosApelacion["tipoApelacion"]."'";
					$tipoApelacion=$con->obtenerValor($consulta);
					
					if($fDatosApelacion["tipoApelacion"]==1)
					{
						$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDatosApelacion["autoRecurso"];
						$nombreAuto=$con->obtenerValor($consulta);
						$tipoApelacion.=": ".$nombreAuto."";
						$arrEtiquetasAdicionales["Tipo de Apelaci&oacute;n"]=cv($tipoApelacion);
					}
					
	
					
				}

				
				$departamento="";
				$municipio="";
				$leyenda="";
				$fRegistroBase=array();
				if($fRegistro["tipoProceso"]!=6)
				{
					$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
					$fDatosCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$nombreTabla=obtenerNombreTabla($fDatosCarpetaBase["idFormulario"]);
					
					
					$consulta="SELECT * FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$fDatosCarpetaBase["idRegistro"];
					$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
					
					if(isset($fRegistroBase["departamento"]))
					{
						$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
						$departamento=$con->obtenerValor($consulta);
					}
					
					if(isset($fRegistroBase["municipio"]))
					{
						$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
						$municipio=$con->obtenerValor($consulta);
					}
					
					
					if(!isset($fRegistroBase["tituloProceso"]))
					{
						$fRegistroBase["tituloProceso"]="";
					}
					
					
					
					if($especialidad!="")
					{
						$arrCamposProyecta["Especialidad"]=cv($especialidad);

					}
					
					
					
					
					if($tipoProceso!="")
					{
						$arrCamposProyecta["Tipo de Proceso"]=cv($tipoProceso);
					}
					
					$lugarRadicacion="";
					if($municipio!="")
					{
						$lugarRadicacion=$municipio;
						
					}
					
					if($departamento!="")
					{
						if($lugarRadicacion=="")
							$lugarRadicacion=$departamento;
						else
							$lugarRadicacion.=", ".$departamento;
						
					}
					
					
					if($lugarRadicacion!="")
					{
						$arrCamposProyecta["Lugar de Radicaci&oacute;n"]=cv($lugarRadicacion);
					}
					
					$arrCamposProyecta["Demandante"]=cv($demantante);
					$arrCamposProyecta["Demandado"]=cv($demandados);
					$arrCamposProyecta["Despacho"]=cv($despacho);
					
				
				}
				else
				{

					$fRegistroBase["tituloProceso"]="";
					$consulta="SELECT * FROM _847_tablaDinamica WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
					$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
					$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["DepartamentoRegistroTutela"]."'";
					$departamento=$con->obtenerValor($consulta);
				
					$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["ciudadRegistroTutela"]."'";
					$municipio=$con->obtenerValor($consulta);

				
					
					
					$arrCamposProyecta["Tipo de Proceso"]=cv($tipoProceso);
					$arrCamposProyecta["Lugar de Radicaci&oacute;n"]=cv($municipio).", ".cv($departamento);
					$arrCamposProyecta["Accionantes"]=cv($demantante);
					$arrCamposProyecta["Accionado"]=cv($demandados);
					$arrCamposProyecta["Despacho"]=cv($despacho);
					
				}
				
				
				foreach($arrEtiquetasAdicionales as $etiqueta=>$valor)
				{
					$arrCamposProyecta[$etiqueta]=$valor;
				}

				$leyenda=generarTablaProcesoJudicial($arrCamposProyecta);
				
				$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
						'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
					cv($tipoProceso).'","tituloProceso":"'.cv(isset($fRegistroBase["tituloProceso"])?$fRegistroBase["tituloProceso"]:"").'","demandantes":"'.cv($demantante).
					'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
					'","leyenda":"'.$leyenda.'"}';
			
				echo "1|".$obj;
			}
		}
		
			
	}
	
	
	function generarTablaProcesoJudicial($arrCamposProyecta)
	{
		$fila1="";
		$fila2="";
		$numItem=0;

		
		$leyenda="<table width='890' id='principal'>";
			
		
		foreach($arrCamposProyecta as $etiqueta=>$valor)
		{
			
			
			if($numItem==0)
			{
				$fila1="<tr height='35'><td width='400' align='left' valign='top'><span class='SIUGJ_Etiqueta'>".$etiqueta."</span></td><td width='90'></td>";
				$fila2="<tr height='45'><td  align='left' valign='top'><span class='SIUGJ_ControlEtiqueta'>".cv($valor)."</span></td><td  valign='top'></td>";
			}
			else
			{
				$fila1.="<td width='400' align='left' valign='top'><span class='SIUGJ_Etiqueta'>".$etiqueta."</span></td></tr>";
				$fila2.="<td valign='top'><span class='SIUGJ_ControlEtiqueta'>".cv($valor)."</span></td></tr>";
			}
			
			$numItem++;
			if($numItem==2)
			{
				$leyenda.=$fila1.$fila2;
				$numItem=0;
				$fila1="";
				$fila2="";
			}
		}
		if($numItem==1)
		{
			$fila1.="<td width='400' align='left' valign='top'></td></tr>";
			$fila2.="<td valign='top'><span class='SIUGJ_ControlEtiqueta'></span></td></tr>";
			$leyenda.=$fila1.$fila2;
		}
		

		
		
		
		$leyenda.="</table>";
		return $leyenda;
	}
	
	function obtenerPlantillaNotificacion()
	{
		global $con;
		$tN=$_POST["tN"];
		$cA=$_POST["cA"];
	
	
	
		$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$tN;
		$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT * FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".($fTipoNotificacion["plantillaMensajeEnvio"]==""?-1:$fTipoNotificacion["plantillaMensajeEnvio"]);
		$fMensajeEnvio=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT cuerpoMensaje FROM 2013_cuerposMensajes WHERE idMensaje=".($fTipoNotificacion["plantillaMensajeEnvio"]==""?-1:$fTipoNotificacion["plantillaMensajeEnvio"]);
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		$consulta="SELECT o.unidad,c.idActividad,c.tipoProceso FROM 7006_carpetasAdministrativas c,817_organigrama o WHERE c.carpetaAdministrativa='".$cA.
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros["nombreDespacho"]=$fDatosCarpetas["unidad"];
		$arrParametros["codigoUnicoProceso"]=$cA;
		$idActividad=$fDatosCarpetas["idActividad"];
		if($idActividad=="")
			$idActividad=-1;
		
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(2,7) ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(4,8) ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}
		$arrParametros["etDemandante"]="ACTOR";
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
		
		echo "1|".bE($cuerpoMensaje);
		
	}
	
	function obtenerDocumentosGeneradosAudiencia()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		
		$consulta=" SELECT id__696_tablaDinamica AS idRegistro,'696' AS idFormulario,fechaCreacion AS fechaRegistro,tipoDocumento AS tipoDocumento,idEstado as situacionActual
				 FROM _696_tablaDinamica WHERE idProcesoPadre=0 AND idReferencia=".$idEvento." and idEstado<>15 ORDER BY fechaCreacion";
		
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function registrarTipoDocumentoGeneradosAudiencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$rol="175_0";
		$numEtapa=1;
		$idRegistro=-1;
		$consulta=" SELECT id__696_tablaDinamica AS idRegistro,'696' AS idFormulario,fechaCreacion AS fechaRegistro,tipoDocumento AS tipoDocumento,idEstado as situacionActual
				 FROM _696_tablaDinamica WHERE idProcesoPadre=0 AND idReferencia=".$obj->idEvento." and tipoDocumento=".$obj->tipoDocumento." and idEstado =1 ORDER BY fechaCreacion";	
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRegistro)
		{
			$idRegistro=$fRegistro["idRegistro"];
			$numEtapa=$fRegistro["situacionActual"];
		}
		else
		{
			
			$consulta="SELECT nombreFormato,seNotificaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$obj->tipoDocumento;
			$fRegistroPlantilla=$con->obtenerPrimeraFilaAsoc($consulta);
			$nombreFormato=$fRegistroPlantilla["nombreFormato"];
			
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$obj->idEvento;
			$carpetaAdministrativa=$con->obtenerValor($consulta);
			$arrValores=array();
			$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
			$arrValores["tipoDocumento"]=$obj->tipoDocumento;
			$arrValores["seNotificaAuto"]=$fRegistroPlantilla["seNotificaDocumento"];
			$arrValores["tituloAuto"]=$fRegistroPlantilla["nombreFormato"];
			$arrValores["figuraNotifica"]=4;
			$arrValores["idProcesoPadre"]=0;
			$arrDocumentos=array();
			
			



			
			$idRegistro=crearInstanciaRegistroFormulario(696,$obj->idEvento,1,$arrValores,$arrDocumentos,-1,0);
		}
		
		

		$a=bE("auto");
		$idProceso=283;
		$actor=obtenerActorProcesoIdRol(283,$rol,$numEtapa);
		$act=bE($actor);
		
		


		echo "1|".$idRegistro."|".$a."|".$act;
	}
	
	
	function obtenerActorTipoDocumentoGeneradosAudiencia()
	{
		global $con;
		$idFormulario=bD($_POST["iF"]);
		$idRegistro=bD($_POST["iR"]);
		$rol="175_0";
		$numEtapa=1;
		
		$consulta=" SELECT idEstado 
				 FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro." and idEstado<>15";	
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		$numEtapa=$fRegistro["idEstado"];
		
		

		$a=bE("auto");
		$idProceso=283;
		$actor=obtenerActorProcesoIdRol(283,$rol,$numEtapa);
		$act=bE($actor);
		
		


		echo "1|".$idRegistro."|".$a."|".$act;
	}
	
	function cancelarDocumentoAudiencia()
	{
		global $con;
		$idFormulario=bD($_POST["iF"]);
		$idRegistro=bD($_POST["iR"]);
		
		
		if(cambiarEtapaFormulario($idFormulario,$idRegistro,15,"",-1,"NULL","NULL",0))
			echo "1|";
	}
	
	function obtenerResultadosBusquedaProcesoGeneral()
	{
		global $con;
		
		$criterioBusqueda=$_POST["criterioBusqueda"];
		$obj=json_decode($criterioBusqueda);
		
		
		
		$condWhere=" 1=1 ";
		
		if($obj->depacho!='')
		{
			$condWhere.=" and unidadGestion='".$obj->depacho."'";
		}
		
		if($obj->especialidad!='')
		{
			$condWhere.=" and especialidad=".$obj->especialidad;
		}
		
		if($obj->tipoProceso!='')
		{
			$condWhere.=" and tipoProceso=".$obj->tipoProceso;
		}
		
		if($obj->claseProceso!='')
		{
			$condWhere.=" and claseProceso=".$obj->claseProceso;
		}
		
		
		
		if($obj->fechaInicioRegistro!='')
		{
			
			if($obj->condFInicioFiltro=="=")
				$condWhere.=" and fechaCreacion>='".$obj->fechaInicioRegistro."' and fechaCreacion<='".$obj->fechaInicioRegistro." 23:59:59'";
			else
				$condWhere.=" and fechaCreacion".$obj->condFInicioFiltro."'".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!='')
		{
			if($obj->condFFinFiltro=="=")
				$condWhere.=" and fechaCreacion>='".$obj->fechaFinRegistro."' and fechaCreacion<='".$obj->fechaFinRegistro." 23:59:59'";
			else
				$condWhere.=" and fechaCreacion".$obj->condFFinFiltro."'".$obj->fechaFinRegistro."'";
		}
		
		if($obj->estadoProceso!="")
		{
			$condWhere.=" and situacion=".$obj->estadoProceso;
		}
		
		if($obj->procesoJudicial!="")
		{
			$condWhere.=" and carpetaAdministrativa like '".$obj->procesoJudicial."%'";
		}
		
		if($obj->nombreParticipante!="")
		{
			if($obj->tipoFigura!=-10)
			{
				$tipoCriterio=1;
				$arrValoresBusqueda=explode(" ",trim($obj->nombreParticipante));
				for($x=0;$x<sizeof($arrValoresBusqueda);$x++)
				{
					$arrValoresBusqueda[$x]=normalizaToken($arrValoresBusqueda[$x]);
				}
				
				$listaActividades="-1";
				$resultado=buscarCoincidenciasCriterio($tipoCriterio,urldecode($obj->nombreParticipante),60,$obj->tipoFigura);
				$arrResultados=$resultado[2];
				foreach($arrResultados as $idActividad=>$resto)
				{
					if($listaActividades=="-1")
						$listaActividades=$idActividad;
					else
						$listaActividades.=",".$idActividad;
				}
				
				$condWhere.=" and idActividad in (".$listaActividades.")";
			}
			else
			{
				$consulta="SELECT se.carpetaAdministrativa FROM _1194_tablaDinamica aa,_1177_tablaDinamica ax,_1178_tablaDinamica se WHERE aa.auxiliarJusticia=ax.id__1177_tablaDinamica
							AND MATCH(primerNombreAuxiliarJusticia, segundoNombreAuxiliarJusticia,apellidoPaternoAuxiliarJusiticia,apellidoMaternoAuxiliarJusticia)
							AGAINST('".trim($obj->nombreParticipante)."' IN NATURAL LANGUAGE MODE) AND se.id__1178_tablaDinamica=aa.idReferencia;";
			
				$listaCarpetas=$con->obtenerListaValores($consulta,"'");
				if($listaCarpetas=="")
					$listaCarpetas=-1;
				$condWhere.=" and carpetaAdministrativa in (".$listaCarpetas.")";
			}
			
		}
		
		if($obj->noDocumento!="")
		{
			$listaActividades="-1";
			$consulta="SELECT i.idActividad FROM _47_tablaDinamica i,7005_relacionFigurasJuridicasSolicitud r WHERE i.tipoIdentificacion=".$obj->tipoDocumento." AND i.folioIdentificacion='".cv($obj->noDocumento)."'
					AND  i.id__47_tablaDinamica=r.idParticipante";
			$resParticipantes=$con->obtenerFilas($consulta);
			while($fParticipante=$con->fetchAssoc($resParticipantes))
			{
				if($listaActividades=="-1")
					$listaActividades=$fParticipante["idActividad"];
				else
					$listaActividades.=",".$fParticipante["idActividad"];
			}
			
			$condWhere.=" and idActividad in (".$listaActividades.")";
		}
		
		
		if($obj->folioRadiacion!="")
		{
			$obj->folioRadiacion=urldecode($obj->folioRadiacion);
			$condWhereAux="";
			$consulta="SELECT DISTINCT idFormulario FROM 7006_carpetasAdministrativas";
			$rFormulario=$con->obtenerFilas($consulta);
			while($fFormulario=$con->fetchAssoc($rFormulario))
			{
				$nombreTabla=obtenerNombreTabla($fFormulario["idFormulario"]);
				
				$consulta="SELECT id_".$nombreTabla." FROM ".$nombreTabla." WHERE codigo='".$obj->folioRadiacion."'";
				$idRegistroFolio=$con->obtenerValor($consulta);
				
				if($idRegistroFolio!="")
				{
					if($condWhereAux=="")
						$condWhereAux="(idFormulario=".$fFormulario["idFormulario"]." and idRegistro=".$idRegistroFolio.")";
					else
						$condWhereAux.=" or (idFormulario=".$fFormulario["idFormulario"]." and idRegistro=".$idRegistroFolio.")";
									
				}
			}
			
			if($condWhereAux!="")
			{
				$condWhere.=" and (".$condWhereAux.")";
			}
			else
			{
				$condWhere.=" and 1=2";
			}
			
		}
		
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT * FROM 7006_carpetasAdministrativas where ".$condWhere;
		$consulta.=" ORDER BY fechaCreacion";


		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$idActividad=$fila["idActividad"];
			$cBase=obtenerCarpetaBaseOriginal($fila["carpetaAdministrativa"]);
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cBase."'";
			$fBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT * FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".($fBase["idRegistro"]==""?-1:$fBase["idRegistro"]);

			$fRadicacionBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($fRadicacionBase)
			{
				if(!isset($fRadicacionBase["tituloProceso"]))
				{
					$fRadicacionBase["tituloProceso"]="";
				}
				
				if(!isset($fRadicacionBase["departamentos"]))
				{
					$fRadicacionBase["departamentos"]="";
					if(isset($fRadicacionBase["departamento"]))
					{
						$fRadicacionBase["departamentos"]=$fRadicacionBase["departamento"];
					}
					
				}
				
				$consulta="SELECT codigo FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".$fila["idRegistro"];
				$folioRegistro=$con->obtenerValor($consulta);
				
				if($idActividad=="")
					$idActividad=-1;
	
				$consulta="SELECT group_concat(upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
				$actor=$con->obtenerValor($consulta);
				
				$consulta="SELECT group_concat(upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
				$demandado=$con->obtenerValor($consulta);
				
				$o='{"idFormulario":"'.$fila["idFormulario"].'","idRegistro":"'.$fila["idRegistro"].
					'","folioRegistro":"'.$folioRegistro.'","fechaRegistro":"'.$fila["fechaCreacion"].'","codigoUnicoProceso":"'.$fila["carpetaAdministrativa"].
					'","tituloProceso":"'.cv($fRadicacionBase["tituloProceso"]).'","especialidad":"'.$fila["especialidad"].'","departamento":"'.$fRadicacionBase["departamentos"].
					'","despacho":"'.$fila["unidadGestion"].'","estadoProceso":"'.$fila["situacion"].
					'","tipoProceso":"'.$fila["tipoProceso"].'","idCarpeta":"'.$fila["idCarpeta"].'","tipoCarpeta":"'.$fila["tipoCarpetaAdministrativa"].
					'","actor":"'.cv($actor).'","demandado":"'.cv($demandado).'","claseProceso":"'.$fila["claseProceso"].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	
	function registrarNotificacionMensajeSedeJudicial()
	{
		global $con;
		$idNotificacion=$_POST["iR"];
		
		
		$consulta="SELECT COUNT(*) FROM _722_tablaDinamica WHERE idReferencia=".$idNotificacion." and medioNotificacionResultadoNotificacion=3";
		 $numReg=$con->obtenerValor($consulta);
		 if($numReg==0)
		 {
			 $consulta="INSERT INTO _722_tablaDinamica(idReferencia,fechaCreacion,responsable,fechaRealizacionDiligenciaResultadoNotificacion,
						horaRealizacionDiligenciaResultadoNotificacion,
						realizarNotificacionResultadoNotificacion,medioNotificacionResultadoNotificacion,confirmadoMedianteCorreo)
						VALUES(".$idNotificacion.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".date("Y-m-d")."','".date("H:i")."',1,3,0)";
			 $con->ejecutarConsulta($consulta);
			 
			 $idRegistro=$con->obtenerUltimoID();
			 asignarFolioRegistro(722,$idRegistro);
			 
		 }

		 if(cambiarEtapaFormulario(665,$idNotificacion,5.6,"",-1,"NULL","NULL",0))
		 {
		 	echo "1|";
		 }
	}
	
	
	function obtenerReporteEstado()
	{
		global $con;
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		
		
		$consulta="SELECT a.idArchivo AS idDocumento,a.nomArchivoOriginal AS nombreAuto,a.categoriaDocumentos AS tipoDocumento,f.fechaBloqueo AS  fechaCreacion,
					0 AS enviadoEstado,'' AS fechaEnvioEstado,i.carpetaAdministrativa,i.idFormulario AS iFormulario,i.idReferencia AS iFormulario
					FROM 3000_formatosRegistrados f,7035_informacionDocumentos i,7006_carpetasAdministrativas c,908_archivos a,908_categoriasDocumentos cD,908_tipoDocumentos tD 
					WHERE f.fechaBloqueo>='".$fechaInicio."' 
					AND f.fechaBloqueo <='".$fechaFin." 23:59:59'
					AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$_SESSION["codigoInstitucion"]."'
					AND a.idArchivo=f.idDocumento AND cD.idCategoria=a.categoriaDocumentos AND tD.idRegistro=cD.idCategoriaDocumento AND tD.seNotificaEstado=1 ORDER BY f.fechaBloqueo";
		

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerTutelasRecibidas()
	{
		global $con;
		$idReferencia="-1";
		$fechaInicio=NULL;
		$fechaFin=NULL;
		
		$ss=0;
		if(isset($_POST["ss"]))
			$ss=$_POST["ss"];
		
		
		if(isset($_POST["iRef"]))
			$idReferencia=$_POST["iRef"];
			
		if(isset($_POST["fechaInicio"]))	
			$fechaInicio=$_POST["fechaInicio"];
		if(isset($_POST["fechaFin"]))	
			$fechaFin=$_POST["fechaFin"];	
			
		$consulta="SELECT id__917_tablaDinamica as idRegistro,'917' AS idFormulario,fechaCreacion,codigo AS folioRegistro,folioCorteConstitucional,carpetaAdministrativa,
					(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=d.codigoInstitucion ) AS despachoEnvio,
					(SELECT COUNT(*) FROM _989_tablaDinamica WHERE idReferencia=d.id__917_tablaDinamica) as cuentaFicha ,if(idEstado>4,5,idEstado) as idEstado,
					(SELECT candidatoSeleccion FROM _995_tablaDinamica WHERE idReferencia=d.id__917_tablaDinamica) as candidato,
					(SELECT COUNT(*) FROM _997_tablaDinamica WHERE idReferencia=d.id__917_tablaDinamica) as existeInsistencia,
					(SELECT tutelaSeleccionable FROM _996_tablaDinamica WHERE idReferencia=d.id__917_tablaDinamica) as seleccionada,
					if(idEstado>5,6,idEstado) as estado6,
					(SELECT nombreSala FROM _992_tablaDinamica WHERE id__992_tablaDinamica=if(d.salaRevision='N/E',-1,d.salaRevision) ) AS despachoSeleccion
					
					
					FROM _917_tablaDinamica d WHERE 1=1 and idReferencia=".$idReferencia;
		if($fechaInicio)
			$consulta.=" and fechaCreacion>='".$fechaInicio."' and fechaCreacion<='".$fechaFin." 23:59:59'";

		if($idReferencia==-1)
			$consulta.=" and idEstado=2";
		
		if($ss==1)
		{
			$consulta="select * from (".$consulta.") as tmp where seleccionada=1";
		}

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));

		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function crearPaqueteTutelas()
	{
		global $con;
		global $servidorPruebas;
		global $tipoMateria;
		$iR=$_POST["iR"];
		$a="";
		$act="";

		if($iR==-1)
		{
			$consulta="INSERT INTO _990_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,despachoAsignado) 
						VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$_SESSION["idUsr"]."','N/E')";
			
			if($con->ejecutarConsulta($consulta))
			{
				$iR=$con->obtenerUltimoID();
				asignarFolioRegistro(990,$iR);
			}
			
		}
	
		
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(990);
		
		$rol='234_0'; 
			
		
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,1);
		$act=bE($actor);
		
		echo "1|".$iR."|".$a."|".$act;
		
	}
	
	function obtenerPaqueteTutelasRecibidas()
	{
		global $con;
		
		$consulta="SELECT id__990_tablaDinamica as idRegistro,'990' AS idFormulario,fechaCreacion,codigo AS folioRegistro,
					(SELECT COUNT(*) FROM _917_tablaDinamica WHERE idReferencia=d.id__990_tablaDinamica) as totalTutelas,
					(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=d.despachoAsignado ) AS despachoAsignado,idEstado as situacionActual 
					FROM _990_tablaDinamica d order by fechaCreacion desc";
			
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));

		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	
	function registrarTutelasPaquete()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$arrRegistros=explode(",",$obj->arrRegistros);
		foreach($arrRegistros as $r)
		{
			
			$consulta[$x]="UPDATE _917_tablaDinamica SET idReferencia=".$obj->idRegistro.",idProcesoPadre=339 WHERE id__917_tablaDinamica=".$r;
			$x++;
		}
		
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			foreach($arrRegistros as $r)
			{
				
				cambiarEtapaFormulario(917,$r,3,"",-1,"NULL","NULL",0);
			}
			echo "1|";
		}
		
	}
	
	function removerTutelasPaquete()
	{
		global $con;
		$arrRegistros=$_POST["arrRegistros"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE _917_tablaDinamica SET idReferencia=-1,idEstado=2,idProcesoPadre=NULL WHERE id__917_tablaDinamica IN(".$arrRegistros.")";
		$x++;
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}
		
	}
	
	function obtenerInformacionTutela()
	{
		global $con;
		global $servidorPruebas;
		global $tipoMateria;
		$iR=$_POST["iR"];
		$a="";
		$act="";
		
		$consulta="SELECT idEstado FROM _917_tablaDinamica WHERE id__917_tablaDinamica=".$iR;
		$etapa=$con->obtenerValor($consulta);
		
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(917);
		
		$rol='235_0'; 
		if(isset($_POST["rolIngreso"]))	
			$rol=$_POST["rolIngreso"];
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);
		$act=bE($actor);
		
		echo "1|".$iR."|".$a."|".$act;
		
	}
	
	function obtenerVotacionesMagistradosRevisionTutela()
	{
		global $con;
		
		$idEstado=0;
		$numReg=0;
		$arrRegistros="";
		$iA=$_POST["iA"];
		
		$consulta="SELECT idMagistrado FROM _1027_tablaDinamica WHERE idEvento=".$iA;
		$listaMagistrados=$con->obtenerListaValores($consulta);
		
		$consulta="SELECT * FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=-".$iA;
		
		if($listaMagistrados!="")
		{
			$consulta.=" and nombrePersona in(".$listaMagistrados.")";
		}
		
		$consulta." ORDER BY idRegistro";	
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT dictamenFinal,comentariosAdicionales FROM _1027_tablaDinamica b,_1028_tablaDinamica d
						WHERE d.idReferencia=b.id__1027_tablaDinamica AND b.idEvento=".$iA." AND b.idMagistrado=".$fila["nombrePersona"];
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$idEstado=$fRegistro["dictamenFinal"];
			if($idEstado=="")
			{
				$consulta="SELECT * FROM _1027_tablaDinamica WHERE idEvento=".$iA." AND idMagistrado=".$fila["nombrePersona"];
				$fRegistroPersona=$con->obtenerPrimeraFilaAsoc($consulta);
				$idEstado=0;	
			}
			$o='{"idMagistrado":"'.$fila["nombrePersona"].'","nombreMagistrado":"'.cv(obtenerNombreUsuario($fila["nombrePersona"]).($arrRegistros==""?" (Ponente)":"")).
				'","votacion":"'.$idEstado.'","comentariosAdicionales":"'.cv($fRegistro["comentariosAdicionales"]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;

			$numReg++;
		}
		if($listaMagistrados=="")
			$idEstado=5;
		else
			$idEstado=0;
		$consulta="SELECT dictamenVotacion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$iA;
		$dictamenVotacion=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"situacionVotacion":"'.$idEstado.'","votacionAbierta":"'.($dictamenVotacion!=0?0:1).'"}';
	}
	
	
	function aperturarVotacionMagistrado()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoCarpetaAdministrativa=30";
		$res=$con->obtenerFilas($consulta);
		if($con->filasAfectadas==0)
		{
			
			$consulta="	SELECT despachoAsignado as unidadGestion FROM 7006_carpetasAdministrativasDespachosColegiados 
						WHERE carpetaAdministrativa='".$carpetaAdministrativa."'
						union 
						SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			$res=$con->obtenerFilas($consulta);
		}
		
		while($fila=$con->fetchAssoc($res))
		{
			$arrValores=array();
			$arrDocumentos=array();
			
			$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='96_0' AND ad.Institucion in('".$fila["unidadGestion"]."') order by ad.idUsuario  limit 0,1";

			$idMagistrado=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT COUNT(*) FROM _1027_tablaDinamica WHERE    idMagistrado=".$idMagistrado." AND idEvento=".$idEvento;
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				$arrValores["codigoInstitucion"]=$fila["unidadGestion"];
				$arrValores["idMagistrado"]=$idMagistrado;
				$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
				$arrValores["responsable"]=$idMagistrado;
				$arrValores["idEvento"]=$idEvento;
				$idRegistroInstancia=crearInstanciaRegistroFormulario(1027,$idEvento,1,$arrValores,$arrDocumentos,-1,0);
			}
			
		}
		
		echo "1|";
		
	}
	
	function registrarResultadoVotacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="UPDATE 7000_eventosAudiencia SET dictamenVotacion=".$obj->dictamenFinal.",comentariosAdicionales='".cv(isset($obj->comentariosFinales)?$obj->comentariosFinales:"")."' WHERE idRegistroEvento=".$obj->idEvento;

		eC($consulta);
	}
	
	
	function obtenerFechasInhabiles()
	{
		global $con;
		
		$anio=$_POST["anio"];
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegistro,fechaInicio,fechaTermino,motivoDiaNoHabil,ambitoGeneral,situacion FROM 7022_diasNOHabiles where fechaInicio>='".$anio."-01-01' and fechaInicio<='".$anio.
					"-12-31' and  situacion=1 ORDER BY fechaInicio";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$distrito="";
			
			
			$consulta="SELECT unidad as nombreDistrito FROM 817_organigrama WHERE  codigoUnidad  in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=1)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($distrito=="")
					$distrito=$fElemento["nombreDistrito"];
				else
					$distrito.="<br>".$fElemento["nombreDistrito"];
			}
			
			$circuito="";
			
			$consulta="SELECT unidad as nombreCircuito FROM 817_organigrama WHERE codigoUnidad 
				in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$fila["idRegistro"]." AND tipoAmbito=2)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($circuito=="")
					$circuito=$fElemento["nombreCircuito"];
				else
					$circuito.="<br>".$fElemento["nombreCircuito"];
			}
			
			$municipio="";
			
			$consulta="SELECT unidad as nombreMunicipio  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=3)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($municipio=="")
					$municipio=$fElemento["nombreMunicipio"];
				else
					$municipio.="<br>".$fElemento["nombreMunicipio"];
			}
			
			$despacho="";
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$fila["idRegistro"]." AND 
					tipoAmbito=4) ORDER BY nombreUnidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($despacho=="")
					$despacho=$fElemento["nombreUnidad"];
				else
					$despacho.="<br>".$fElemento["nombreUnidad"];
			}

			
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaInicio":"'.$fila["fechaInicio"].'","fechaTermino":"'.$fila["fechaTermino"].
					'","motivoDiaNoHabil":"'.cv($fila["motivoDiaNoHabil"]).'","distrito":"'.cv($distrito).'","circuito":"'.cv($circuito).'","municipio":"'.cv($municipio).
					'","despacho":"'.cv($despacho).'","general":"'.$fila["ambitoGeneral"].'","situacionActual":"'.$fila["situacion"].'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'",registros:['.$arrRegistros.']}';
		
		
		
	}
	
	function obtenerInformacionAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$tipoAmbito=$_POST["tA"];
		
		$consulta="";
		switch($tipoAmbito)
		{
			case 1:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
						in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro.
					" AND tipoAmbito=1)ORDER BY unidad";
			break;
			case 2:
				
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro.
					" AND tipoAmbito=2)ORDER BY unidad";
			break;
			case 3:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro.
					" AND tipoAmbito=3)ORDER BY unidad";	
					
			break;
			case 4:
			
				$consulta="SELECT claveUnidad as cveElemento,nombreUnidad as nombreElemento FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro." AND 
					tipoAmbito=4)  ORDER BY nombreUnidad";
			
			break;
			
		}
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerDistritosAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveDistrito,unidad as nombreDistrito FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' 
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro." AND tipoAmbito=1)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerCircuitosAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveCircuito,unidad as nombreCircuito FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro." AND tipoAmbito=2)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerMunicipiosAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveMunicipio,unidad as nombreMunicipio  FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro." AND tipoAmbito=3)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerDespachoAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$query=$_POST["query"];
		
		
		$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionFechaInhabil WHERE idFechaReferencia=".$idRegistro." AND 
					tipoAmbito=4) and nombreUnidad like '%".$query."%' and tipoUnidad IN(SELECT idCategoriaUnidadOrganigrama 
					FROM 817_categoriasUnidades WHERE esJuzgado=1) ORDER BY nombreUnidad";
		
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function registrarFechaAmbitosAplicacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 7022_diasNOHabiles(fechaInicio,fechaTermino,motivoDiaNoHabil,situacion,fechaRegistro,idResponsableRegistro,ambitoGeneral)
						VALUES ('".$obj->fechaInicio."','".$obj->fechaFin."','".cv($obj->nombreEvento)."',1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->ambitoGeneral."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 7022_diasNOHabiles set fechaInicio='".$obj->fechaInicio."',fechaTermino='".$obj->fechaFin."',motivoDiaNoHabil='".cv($obj->nombreEvento).
						"',ambitoGeneral=".$obj->ambitoGeneral." where idRegistro=".$obj->idRegistro;
						
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		
		$consulta[$x]="delete from 7022_ambitoAplicacionFechaInhabil where idFechaReferencia=@idRegistro";
		$x++;
		
		
		foreach($obj->arrDistritos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionFechaInhabil(idFechaReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,1,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrCircuitos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionFechaInhabil(idFechaReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,2,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrMunicipios as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionFechaInhabil(idFechaReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,3,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrDespachos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionFechaInhabil(idFechaReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,4,'".$e->cveElemento."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerFechaAmbitosAplicacion()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		$consulta="UPDATE 7022_diasNOHabiles SET situacion=2,fechaEliminacion='".date("Y-m-d H:i:s")."',idResponsableEliminacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$idRegistro;
		eC($consulta);
	}
	
	
	function obtenerDistritosAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveDistrito,unidad as nombreDistrito FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' 
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro." AND tipoAmbito=1)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerCircuitosAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveCircuito,unidad as nombreCircuito FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro." AND tipoAmbito=2)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerMunicipiosAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveMunicipio,unidad as nombreMunicipio  FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro." AND tipoAmbito=3)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerDespachoAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$query=$_POST["query"];
		
		
		$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad not in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro.
					" AND tipoAmbito=4) and nombreUnidad like '%".$query."%' and
					tipoUnidad IN(SELECT idCategoriaUnidadOrganigrama FROM 817_categoriasUnidades WHERE esJuzgado=1) ORDER BY nombreUnidad";
		
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function registrarFechaAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 7022_perfilesHorario(nombrePerfil,situacion,fechaRegistro,idResponsableRegistro,ambitoGeneral)
						VALUES ('".cv($obj->nombrePerfil)."',1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->ambitoGeneral."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 7022_perfilesHorario set nombrePerfil='".cv($obj->nombrePerfil).
						"',ambitoGeneral=".$obj->ambitoGeneral." where idRegistro=".$obj->idRegistro;
						
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		
		$consulta[$x]="delete from 7022_ambitoAplicacionPerfilHorario where idReferencia=@idRegistro";
		$x++;
		$consulta[$x]="DELETE FROM 7022_diasHorarioPerilHorario WHERE idReferencia=@idRegistro";
		$x++;
		
		
		foreach($obj->arrHorarios as $e)
		{
			$consulta[$x]="INSERT INTO 7022_diasHorarioPerilHorario(idReferencia,dia,horaInicial,horaTermino) VALUES(@idRegistro,".$e->dia.",'".$e->horaInicial."','".$e->horaFinal."')";
			$x++;
		}
		
		foreach($obj->arrDistritos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilHorario(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,1,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrCircuitos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilHorario(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,2,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrMunicipios as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilHorario(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,3,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrDespachos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilHorario(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,4,'".$e->cveElemento."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function obtenerPerfilesLaborales()
	{
		global $con;
		global $arrDiasSemana;

		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegistro,nombrePerfil,ambitoGeneral,situacion FROM 7022_perfilesHorario where situacion=1 ORDER BY nombrePerfil";




		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$distrito="";
			
			
			$consulta="SELECT unidad as nombreDistrito FROM 817_organigrama WHERE  codigoUnidad  in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=1)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($distrito=="")
					$distrito=$fElemento["nombreDistrito"];
				else
					$distrito.="<br>".$fElemento["nombreDistrito"];
			}
			
			$circuito="";
			
			$consulta="SELECT unidad as nombreCircuito FROM 817_organigrama WHERE codigoUnidad 
				in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$fila["idRegistro"]." AND tipoAmbito=2)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($circuito=="")
					$circuito=$fElemento["nombreCircuito"];
				else
					$circuito.="<br>".$fElemento["nombreCircuito"];
			}
			
			$municipio="";
			
			$consulta="SELECT unidad as nombreMunicipio  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=3)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($municipio=="")
					$municipio=$fElemento["nombreMunicipio"];
				else
					$municipio.="<br>".$fElemento["nombreMunicipio"];
			}
			
			$despacho="";
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$fila["idRegistro"]." AND 
					tipoAmbito=4) ORDER BY nombreUnidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($despacho=="")
					$despacho=$fElemento["nombreUnidad"];
				else
					$despacho.="<br>".$fElemento["nombreUnidad"];
			}

			$horarioLaboral="";
			
			$consulta="SELECT * FROM 7022_diasHorarioPerilHorario WHERE idReferencia=".$fila["idRegistro"]." ORDER BY dia";
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				$o=utf8_encode($arrDiasSemana[$fElemento["dia"]].".- De las ".$fElemento["horaInicial"]." hrs. a las ".$fElemento["horaTermino"]." hrs.");
				if($horarioLaboral=="")	
					$horarioLaboral=$o;
				else
					$horarioLaboral.="<br>".$o;
			}
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","perfilHorario":"'.cv($fila["nombrePerfil"]).'","horarioLaboral":"'.cv($horarioLaboral).'","distrito":"'.cv($distrito).'","circuito":"'.cv($circuito).'","municipio":"'.cv($municipio).
					'","despacho":"'.cv($despacho).'","general":"'.$fila["ambitoGeneral"].'","situacionActual":"'.$fila["situacion"].'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'",registros:['.$arrRegistros.']}';
		
		
		
	}
	
	
	function obtenerInformacionAmbitosAplicacionPerfilesLaborales()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$tipoAmbito=$_POST["tA"];
		
		$consulta="";
		switch($tipoAmbito)
		{
			case 1:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
						in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro.
					" AND tipoAmbito=1)ORDER BY unidad";
			break;
			case 2:
				
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro.
					" AND tipoAmbito=2)ORDER BY unidad";
			break;
			case 3:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro.
					" AND tipoAmbito=3)ORDER BY unidad";	
					
			break;
			case 4:
			
				$consulta="SELECT claveUnidad as cveElemento,nombreUnidad as nombreElemento FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilHorario WHERE idReferencia=".$idRegistro." AND 
					tipoAmbito=4)  ORDER BY nombreUnidad";
			
			break;
			
		}
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerHorarioPerfilesLaborales()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		$consulta="SELECT idRegistro,dia,horaInicial as horaInicio,horaTermino as horaFin FROM 7022_diasHorarioPerilHorario WHERE  idReferencia=".$idRegistro." ORDER BY dia,horaInicial";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function removerAmbitosAplicacionPerfilesLaborales()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		$consulta="UPDATE 7022_perfilesHorario SET situacion=2,fechaEliminacion='".date("Y-m-d H:i:s")."',idResponsableEliminacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$idRegistro;

		eC($consulta);
	}
	
	function compartirReporte()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrDocumentos=array();
		$arrValores=array();
		$arrValores["tipoReporte"]=$obj->idReporte;
		$arrValores["destinatarioReporte"]=$obj->idUsuarioDestinatario;
		$arrValores["responsable"]=$obj->idUsuarioDestinatario;
		$arrValores["detallesAdicionalesReporte"]=$obj->comentariosAdicionales;
		


		$idRegistroInstancia=crearInstanciaRegistroFormulario(1212,-1,2,$arrValores,$arrDocumentos,-1,0);
		echo "1|";
	}
	
	function obtenerEventosAudienciaSIUGJ()
	{
		global $con;
		global $tipoMateria;
		
		$carpetaAdministrativa="";
		$juez="";
		$condiciones="";
		if(isset($_POST["filter"]))
		{
			$filter=$_POST["filter"];
			$nFiltros=sizeof($filter);
			
			for($x=0;$x<$nFiltros;$x++)
			{
				switch($filter[$x]["field"])
				{
					case "juez":
						$juez=$filter[$x]["data"]["value"];
					break;
					case "situacion":
						$c=" and situacion in(".$filter[$x]["data"]["value"].")";
						if($condiciones=="")
							$condiciones=$c;
						else
							$condiciones.=" ".$c;
					break;
					case "carpetaAdministrativa":
						$carpetaAdministrativa=$filter[$x]["data"]["value"];
						//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
					break;
					case "fechaEvento":
					
						$arrFecha=explode('/',$filter[$x]["data"]["value"]);
						$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
						$operador="";
						switch($filter[$x]["data"]["comparison"])
						{
							case "gt":
								$operador=">";
							break;
							case "lt":
								$operador="<";
							break;
							case "eq":
								$operador="=";
							break;
						}
						$c=" and fechaEvento ".$operador." ".$valor;
	
						if($condiciones=="")
							$condiciones=$c;
						else
							$condiciones.=" ".$c;
						
					break;
					case "sala":
						$c=" and idSala in(".$filter[$x]["data"]["value"].")";
						if($condiciones=="")
							$condiciones=$c;
						else
							$condiciones.=" ".$c;
					break;
					case "edificio":
						$c=" and idEdificio=".$filter[$x]["data"]["value"];
						if($condiciones=="")
							$condiciones=$c;
						else
							$condiciones.=" ".$c;
					break;
					case "tipoAudiencia":
						$c=" and tipoAudiencia=".$filter[$x]["data"]["value"];
						if($condiciones=="")
							$condiciones=$c;
						else
							$condiciones.=" ".$c;
					break;
					case "conRecursosAdicionales":
					
							$considerarConRecursos=$filter[$x]["data"]["value"];
					
					break;
				}
			}
			
		}
		
		
		$idActividad=-1;
		$arrRegistros="";//carpetaAdministrativa
		
		
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,e.situacion,
					idEdificio,idCentroGestion,idSala,tipoAudiencia,e.idFormulario,idRegistroSolicitud,
					horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio,c.idActividad,c.carpetaAdministrativa,c.tipoProceso
					FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
					where tipoContenido=3 AND idRegistroContenidoReferencia=e.idRegistroEvento and con.carpetaAdministrativa=c.carpetaAdministrativa 
					and horaInicioEvento is not null and horaFinEvento is not null";		
		
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if($obj->depacho!="")
		{
			$consulta.=" and idCentroGestion in(".$obj->depacho.")";
		}
		
		if($obj->especialidad!="")
		{
			$consulta.=" and c.especialidad=".$obj->especialidad;
		}
		
		if($obj->tipoProceso!="")
		{
			$consulta.=" and c.tipoProceso=".$obj->tipoProceso;
		}
		
		
		
		if($obj->claseProceso!="")
		{
			$consulta.=" and c.claseProceso=".$obj->claseProceso;
		}
		
		if($obj->sala!="")
		{
			$consulta.=" and e.idSala=".$obj->sala;
		}
		
		if($obj->situacionAudiencia!="")
		{
			$consulta.=" and e.situacion=".$obj->situacionAudiencia;
		}
		
		if($obj->tipoAudiencia!="")
		{
			$consulta.=" and e.tipoAudiencia=".$obj->tipoAudiencia;
		}
		
		if($obj->procesoJudicial!="")
		{
			$consulta.=" and c.carpetaAdministrativa like '%".$obj->procesoJudicial."%'";
		}
		
		if($obj->fechaInicioRegistro!="")
		{
			$consulta.=" and e.fechaEvento ".$obj->condFInicioFiltro." '".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!="")
		{
			$consulta.=" and e.fechaEvento ".$obj->condFFinFiltro." '".$obj->fechaFinRegistro."'";
		}
		

		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
	
			$query="SELECT GROUP_CONCAT(CONCAT('(',if(noJuez is null,'',noJuez),') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
						7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila["idRegistroEvento"];
			
			$jueces=$con->obtenerValor($query);
			
			if($juez!="")
			{
				if(stripos($jueces,$juez)===false)
				{
					continue;
				}
			}
			
			$carpeta="";

			$tAudiencia="";
			
			
			$iFormularioSituacion=-1;
			$iRegistroSituacion=-1;
			
			switch($fila["situacion"])
			{
				case "2"://Finalizada
					$iFormularioSituacion=321;
					$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;
				break;
				case "6"://Resuelta por acuerdo
					$iFormularioSituacion=322;
	
					$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;
				break;
				case "9"://Cancelado
				case "3"://Cancelado
					$iFormularioSituacion=323;
					$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;	
				break;
			}
			
			
			
			$o='{"idEvento":"'.$fila["idRegistroEvento"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","fechaEvento":"'.$fila["fechaEvento"].
				'","horaInicial":"'.$fila["horaInicioEvento"].'","horaFinal":"'.$fila["horaFinEvento"].'",
				"tipoAudiencia":"'.$fila["tipoAudiencia"].'","sala":"'.$fila["idSala"].'","unidadGestion":"'.$fila["idCentroGestion"].
				'","situacion":"'.$fila["situacion"].'","juez":"'.$jueces.'","horaInicialReal":"'.$fila["horaInicioReal"].
				'","horaFinalReal":"'.$fila["horaTerminoReal"].'","urlMultimedia":"'.$fila["urlMultimedia"].'","iFormulario":"'.$fila["idFormulario"].
				'","iRegistro":"'.$fila["idRegistroSolicitud"].'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'"'.
				',"edificio":"'.$fila["idEdificio"].'"}';
			
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	
	function obtenerActuacionesSIUGJ()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT a.id__699_tablaDinamica AS idRegistro,c.carpetaAdministrativa,a.codigo AS folioRegistro,a.fechaCreacion AS fechaRegistro,
				a.tipoActuacion,c.unidadGestion  AS despacho,c.tipoProceso,c.claseProceso,a.idEstado AS situacionActual,
				(SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica WHERE id__47_tablaDinamica= a.promovente) 
				AS promovente,'699' AS  iFormulario,a.id__699_tablaDinamica AS iRegistro
				 FROM _699_tablaDinamica a,7006_carpetasAdministrativas c WHERE a.carpetaAdministrativaActuacionesIntervinientes=c.carpetaAdministrativa";
	
		if($obj->depacho!="")
		{
			$consulta.=" and c.unidadGestion='".$obj->depacho."'";	
		}
		
		if($obj->especialidad!="")
		{
			$consulta.=" and c.especialidad='".$obj->especialidad."'";	
		}
		
		if($obj->tipoProceso!="")
		{
			$consulta.=" and c.tipoProceso='".$obj->tipoProceso."'";	
		}
		
		if($obj->procesoJudicial!="")
		{
			$consulta.=" and c.carpetaAdministrativa like '%".$obj->procesoJudicial."%'";	
		}
		
		if($obj->claseProceso!="")
		{
			$consulta.=" and c.claseProceso='".$obj->claseProceso."'";	
		}
		
		if($obj->tipoActuacion!="")
		{
			$consulta.=" and a.tipoActuacion='".$obj->tipoActuacion."'";	
		}
		
		if($obj->situacionActuacion!="")
		{
			if($obj->situacionActuacion!="1")
				$consulta.=" and a.idEstado>1";
			else	
				$consulta.=" and a.idEstado=1";
		}
		
		if($obj->fechaInicioRegistro!="")
		{
			$consulta.=" and a.fechaCreacion ".$obj->condFInicioFiltro." '".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!="")
		{
			$consulta.=" and a.fechaCreacion ".$obj->condFFinFiltro." '".$obj->fechaFinRegistro."'";
		}

		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerNotificacionesSIUGJ()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$arrRegistros="";
		$consulta="SELECT n.fechaCreacion,n.carpetaAdministrativa,codigo,
				medioNotificacion AS tipoNotificacion,id__665_tablaDinamica as idRegistro, c.unidadGestion,
				(SELECT GROUP_CONCAT(nombreDocumento) FROM _665_gridDocumentosNotificar WHERE idReferencia=n.id__665_tablaDinamica 
				ORDER by nombreDocumento) as documentosNotifica,
				(SELECT GROUP_CONCAT(nombrePersona) FROM _665_gPersonasNotificar WHERE idReferencia=n.id__665_tablaDinamica 
				 ORDER BY nombrePersona) as personaNotifica,
				 c.tipoProceso,c.claseProceso,n.idEstado
				FROM _665_tablaDinamica n,7006_carpetasAdministrativas c  where n.carpetaAdministrativa=c.carpetaAdministrativa";
	
	
		if($obj->depacho!="")
		{
			$consulta.=" and c.unidadGestion='".$obj->depacho."'";
		}
		
		if($obj->especialidad!="")
		{
			$consulta.=" and c.especialidad='".$obj->especialidad."'";
		}
		
		if($obj->tipoProceso!="")
		{
			$consulta.=" and c.tipoProceso='".$obj->tipoProceso."'";
		}
		
		if($obj->procesoJudicial!="")
		{
			$consulta.=" and c.carpetaAdministrativa like '%".$obj->procesoJudicial."%'";
		}
		
		if($obj->claseProceso!="")
		{
			$consulta.=" and c.claseProceso='".$obj->claseProceso."'";
		}
		
		if($obj->tipoNotificacion!="")
		{
			$consulta.=" and n.medioNotificacion='".$obj->tipoNotificacion."'";
		}
		
		
		if($obj->fechaInicioRegistro!="")
		{
			$consulta.=" and n.fechaCreacion ".$obj->condFInicioFiltro." '".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!="")
		{
			$consulta.=" and n.fechaCreacion ".$obj->condFFinFiltro." '".$obj->fechaFinRegistro."'";
		}
		
		
		if($obj->situacionNotificacion!="")
		{
			$consulta.=" and n.idEstado='".$obj->situacionNotificacion."'";
		}
		
		if($obj->folioNotificacion!="")
		{
			$consulta.=" and n.codigo like '%".$obj->folioNotificacion."%'";
		}
				
				
		$consulta.=" ORDER BY n.fechaCreacion";
		$arrRegistros="";
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT fechaRealizacionDiligenciaResultadoNotificacion,
						horaRealizacionDiligenciaResultadoNotificacion,
						medioNotificacionResultadoNotificacion AS medioNotificacion
						FROM _722_tablaDinamica WHERE idReferencia=".$fila["idRegistro"];
		
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fRegistro)
			{
				$fila["notificado"]="1";
				$fila["fechaNotificacion"]=$fRegistro["fechaRealizacionDiligenciaResultadoNotificacion"]." ".$fRegistro["horaRealizacionDiligenciaResultadoNotificacion"];
				$fila["medioNotificacion"]=$fRegistro["medioNotificacion"];
			}
			else
			{
				$fila["notificado"]="0";
				$fila["fechaNotificacion"]="";
				$fila["medioNotificacion"]="";
			}
			
			if($obj->estadoAcuseRecibo!=="")
			{
				if($obj->estadoAcuseRecibo==1)
				{
					if(!$fRegistro)
						continue;
				}
				else
				{
					if($fRegistro)
						continue;
				}
			}
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","claseProceso":"'.$fila["claseProceso"].
				'","tipoProceso":"'.$fila["tipoProceso"].'","fechaRegistro":"'.$fila["fechaCreacion"].'","folio":"'.$fila["codigo"].
				'","tipoNotificacion":"'.$fila["tipoNotificacion"].'","documentoNotificacion":"'.cv($fila["documentosNotifica"]).'",
				"destinatario":"'.cv($fila["personaNotifica"]).'","despacho":"'.$fila["unidadGestion"].'","notificado":"'.$fila["notificado"].
				'","fechaNotificacion":"'.$fila["fechaNotificacion"].'","medioNotificacion":"'.$fila["medioNotificacion"].
				'","idEstado":"'.$fila["idEstado"].'"}';
				
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	
	}
	
	
	function registrarPerfilCuentaServiciosAmbitosAplicacionPerfilLaboral()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 7022_perfilesServicioNubeSistema(cuentaServicio,situacion,fechaRegistro,idResponsableRegistro,ambitoGeneral,comentariosAdicionales)
						VALUES ('".cv($obj->cuentaServicio)."',1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->ambitoGeneral."','".cv($obj->comentariosAdicionales)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 7022_perfilesServicioNubeSistema set cuentaServicio='".cv($obj->cuentaServicio).
						"',ambitoGeneral=".$obj->ambitoGeneral.",comentariosAdicionales='".cv($obj->comentariosAdicionales)."' 
						where idRegistro=".$obj->idRegistro;
						
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		
		$consulta[$x]="delete from 7022_ambitoAplicacionPerfilServicioNube where idReferencia=@idRegistro";
		$x++;
		
		
		foreach($obj->arrDistritos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilServicioNube(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,1,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrCircuitos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilServicioNube(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,2,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrMunicipios as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilServicioNube(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,3,'".$e->cveElemento."')";
			$x++;
		}
		
		
		foreach($obj->arrDespachos as $e)
		{
			$consulta[$x]="INSERT INTO 7022_ambitoAplicacionPerfilServicioNube(idReferencia,tipoAmbito,cveElemento) VALUES(@idRegistro,4,'".$e->cveElemento."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function obtenerPerfilesCuentasServiciosNube()
	{
		global $con;
		global $arrDiasSemana;

		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegistro,cuentaServicio,ambitoGeneral,p.situacion,comentariosAdicionales FROM 
					7022_perfilesServicioNubeSistema p,20001_conexionesServiciosNube c where 
					 c.idConexion=p.cuentaServicio ORDER BY c.nombreConexion";




		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$distrito="";
			
			
			$consulta="SELECT unidad as nombreDistrito FROM 817_organigrama WHERE  codigoUnidad  in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilServicioNube WHERE idReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=1)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($distrito=="")
					$distrito=$fElemento["nombreDistrito"];
				else
					$distrito.="<br>".$fElemento["nombreDistrito"];
			}
			
			$circuito="";
			
			$consulta="SELECT unidad as nombreCircuito FROM 817_organigrama WHERE codigoUnidad 
				in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilServicioNube WHERE idReferencia=".$fila["idRegistro"]." AND tipoAmbito=2)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($circuito=="")
					$circuito=$fElemento["nombreCircuito"];
				else
					$circuito.="<br>".$fElemento["nombreCircuito"];
			}
			
			$municipio="";
			
			$consulta="SELECT unidad as nombreMunicipio  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilServicioNube WHERE idReferencia=".$fila["idRegistro"].
					" AND tipoAmbito=3)ORDER BY unidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($municipio=="")
					$municipio=$fElemento["nombreMunicipio"];
				else
					$municipio.="<br>".$fElemento["nombreMunicipio"];
			}
			
			$despacho="";
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM 7022_ambitoAplicacionPerfilServicioNube WHERE idReferencia=".$fila["idRegistro"]." AND 
					tipoAmbito=4) ORDER BY nombreUnidad";
					
			$rElementos=$con->obtenerFilas($consulta);
			while($fElemento=$con->fetchAssoc($rElementos))
			{
				if($despacho=="")
					$despacho=$fElemento["nombreUnidad"];
				else
					$despacho.="<br>".$fElemento["nombreUnidad"];
			}

			
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","cuentaServicio":"'.cv($fila["cuentaServicio"]).'","comentariosAdicionales":"'.
				cv($fila["comentariosAdicionales"]).'","distrito":"'.cv($distrito).'","circuito":"'.cv($circuito).'","municipio":"'.cv($municipio).
					'","despacho":"'.cv($despacho).'","general":"'.$fila["ambitoGeneral"].'","situacionActual":"'.$fila["situacion"].'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'",registros:['.$arrRegistros.']}';
		
		
		
	}
	
	function removerPerfilesCuentasServiciosNube()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		$consulta="UPDATE 7022_perfilesServicioNubeSistema SET situacion=2,fechaEliminacion='".date("Y-m-d H:i:s")."',idResponsableEliminacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$idRegistro;

		eC($consulta);
	}
	
	function obtenerIdRegistroResolutivos()
	{
		global $con;
		$idAudiencia=$_POST["idAudiencia"];
		$idFormulario=$_POST["idFormulario"];
		
		
		$consulta="SELECT id__".$idFormulario."_tablaDinamica FROM _".$idFormulario."_tablaDinamica WHERE idReferencia=".$idAudiencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		echo "1|".$idRegistro;
		
	}
	
	function verificarBloqueoResolutivos()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$idCuestionario=$_POST["idCuestionario"];
		
		$consulta="SELECT id__10_tablaDinamica FROM _10_tablaDinamica WHERE categoriaDocumento=103";
		$listaActasAudiencia=$con->obtenerListaValores($consulta);
		if($listaActasAudiencia=="")
			$listaActasAudiencia=-1;
		$consulta="SELECT COUNT(*) FROM _696_tablaDinamica WHERE idReferencia=".$idEvento." AND tipoDocumento IN(".$listaActasAudiencia.") and idEstado=5";
		$numReg=$con->obtenerValor($consulta);
		if($numReg==0)
		{
			echo "1|0";
		}
		else
		{
			$consulta="SELECT id__".$idCuestionario."_tablaDinamica FROM _".$idCuestionario."_tablaDinamica WHERE idReferencia=".$idEvento;
			$idRegistro=$con->obtenerValor($consulta);
			
			
			if($idRegistro=="")
				$idRegistro=-1;
			echo "1|1|".$idRegistro;
		}
		
	}
	
	
	function registrarRepartoManual()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
	
		$consulta="SELECT * FROM 7006_repartoManual WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;	
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRegistro)
		{
			$consulta="update 7006_repartoManual set despachoAsignado='".cv($obj->despachoAsignado)."',cup='".cv($obj->cup).
						"',noRadicacion='".cv($obj->noRadicacion)."',comentariosAdicionales='".cv($obj->comentariosAdicionales)."'
						where idRegistro=".$fRegistro["idRegistro"];

		}
		else
		{
			$consulta="INSERT INTO 7006_repartoManual(idFormulario,idReferencia,despachoAsignado,cup,noRadicacion,comentariosAdicionales,fechaRegistro,usuarioRegistro)
						values(".$obj->idFormulario.",".$obj->idRegistro.",'".cv($obj->despachoAsignado)."','".cv($obj->cup)."','".cv($obj->noRadicacion).
						"','".cv($obj->comentariosAdicionales)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
		}
		
		
		eC($consulta);
		
		
	}
	
	function consultarEmpleadoCC()
	{
		global $con;
		$cc=$_POST["cc"];
		$resultado=buscarInformacionEFinomina($cc);

		$resultadoOperacion=0;
		$msgError="";
		
		if($resultado["Respuesta"]==1)
		{
			$consulta="SELECT * FROM 802_identifica i WHERE tipoIdentificacion=4 AND noIdentificacion='".$cc."'";
			$fila=$con->obtenerPrimeraFilaAsoc($consulta);

			if($fila)
			{
				$msgError="Ya existe un usuario con el n&uacute;mero de identificaci&oacute;n: ".$cc." (ID de usuario: ".$fila["idUsuario"].")";
				$resultadoOperacion="2";
			}
			else
			{
				$resultadoOperacion="1";
				if($resultado["estadoempleado"]!="Activo")
				{
					$resultadoOperacion=4;
					$msgError="El empleado NO se encuentra activo";
				}
				else
				{
					$apPaterno=$resultado["ApellidoPaterno"];
					$apMaterno=$resultado["ApellidoMaterno"];
					$nombre=$resultado["Nombres"];
					$email=$resultado["CorreoElectronico"];
					$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE unidad='".cv($resultado["ultimaDependencia"])."'";
					$adscripcion=$con->obtenerValor($consulta);
					if($adscripcion=="")
						$adscripcion="10000004";
					
					$idUsuario=crearBaseUsuario($apPaterno,$apMaterno,$nombre,$email,$adscripcion,"","-1000","","",-1,false);
				
					$x=0;
					$query[$x]="begin";
					$x++;
					
					$query[$x]="UPDATE 802_identifica SET Genero=".($resultado["sexo"]=="F"?1:0).",tipoIdentificacion=4,noIdentificacion='".$cc."' WHERE idUsuario=".$idUsuario;
					$x++;
					$query[$x]="UPDATE 803_direcciones SET Calle='".cv($resultado["Direccion"])."' WHERE idUsuario=".$idUsuario;
					$x++;
					if(trim($resultado["Telefono"])!="")
					{
						$query[$x]="INSERT INTO 804_telefonos(Numero,Tipo,Tipo2,idUsuario,verificado) VALUES('".cv($resultado["Telefono"])."',0,1,".$idUsuario.",0)";
						$x++;
					}
					
					$query[$x]="UPDATE 801_adscripcion SET statusNomina='".mb_strtoupper($resultado["estatusActualNomina"])."',institucionAbierto='".cv($resultado["ultimaDependencia"])."',puestoAbierto='".cv($resultado["ultimoCargo"])."' WHERE idUsuario=".$idUsuario;
					$x++;
					
					$query[$x]="commit";
					$x++;
					
					if($con->ejecutarBloque($query))
					{
						$resultadoOperacion=1;
						$msgError=$idUsuario;
					}
				
				}
				
			}
		}
		else
		{
			$msgError="No se pudo establecer conexión con EFINOMINA";
		}
		
		echo "1|".$resultadoOperacion."|".$msgError;
	}
?>