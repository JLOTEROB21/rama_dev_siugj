<?php session_start();

	

	include_once("conexionBD.php");
	
	include_once("funcionesActores.php");
	include_once("cConectoresServicios/cAdministradorConectoresServiciosNube.php");
	
	include_once("cConectoresServicios/cMicrosoftGraph.php");
	include_once("cConectoresServicios/cConectorCalendarOffice365.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");
	include_once("SIUGJ/libreriasFuncionesDespachos.php");
	
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];

	
	switch($funcion)
	{
		case 1:
			obtenerDocumentacionRequeridaClaseProcesoV1();
		break;
		case 2:
			obtenerInfoCodigoProcesoUnico();
		break;
		case 3:
			obtenerProcesosDespacho();
		break;
		case 4:
			obtenerInfoMetadataDocumento();
		break;
		case 5:
			actualizarMetaDataDocumento();
		break;
		case 6:
			crearNuevoUsuarioPortal();
		break;
		case 7:	
			recuperarDatosAcceso();
		break;
		case 8:
			obtenerCarpetasUsuario();
		break;
		case 9:
			obtenerDocumentosCarpetaAdministrativaPortalUsuario();
		break;
		case 10:
			obtenerResultadosBusquedaProceso();
		break;
		case 11:
			obtenerDocumentosResultadosBusquedaProceso();
		break;
		case 12:
			obtenerAgendaCitaDiasControl();
		break;
		case 13:
			registrarDocumentoAdjuntoCarpetaAdministrativa();
		break;
		case 14:	
			obtenerPlantillaNotificacion();
		break;
		case 15:
			obtenerRegistroProgramacionAudienciaProcesoJudicial();
		break;
		case 16:
			registrarAudienciaSGJ();
		break;
		case 17:	
			obtenerSalasDisponiblesDespacho();
		break;
		case 18;
			obtenerEventosSalaAudiencia();
		break;
		case 19:
			obtenerAsistenciaPartesAudiencia();
		break;
		case 20:
			registrarAsistenciaAudiencia();
		break;
		case 21:
			obtenerEventosAgendaAudiencia();
		break;
		case 22:
			obtenerDatosEventoAudienciaSGJ();
		break;
		case 23:
			obtenerEventosAudienciaSGJ();
		break;
		case 24:
			obtenerResultadosBusquedaAudiencia();
		break;
		case 25:
			obtenerInfoCodigoProcesoUnicoApelacion();
		break;
		case 26:
			obtenerInfoCodigoProcesoUnicoCasacion();
		break;
		case 27:
			obtenerInfoCodigoProcesoUnicoCierre();
		break;
		case 28:
			obtenerAudienciasExpedienteSGJ();
		break;
		case 29:
			obtenerDocumentosCarpetaAdministrativa();
		break;
		case 30:
			obtenerInfoMetadataProceso();
		break;
		case 31:
			obtenerIdRegistroAudiencia();
		break;
		case 32:
			obtenerTipoDocumentales();
		break;
		case 33:
			registrarMetaDataDocumento();
		break;
		case 34:
			actualizarMetaDataDocumentoPerfil();
		break;
		case 35:
			actualizarPerfilAccesoExpediente();
		break;
		case 36:
			buscarIdentificacionRegistroUsuario();
		break;		
		case 37:
			existeMailRegistroUsuario();
		break;
		case 38:
			enviarSMSValidacionCelular();
		break;
		case 39:
			validarSMSValidacionCelular();
		break;
		
	}
	
	
	function obtenerDocumentacionRequeridaClaseProcesoV1()
	{
		global $con;
		$claseProceso=$_POST["cP"];
		$consulta="SELECT '-1' AS idRegistro,'-1' AS idReferencia,documentoRequerido AS idDocumento,false AS presentaDocumento,'' AS documentoAdjunto,obligatoio AS obligatorio 
					FROM _626_documentosRequeridosProceso d,908_categoriasDocumentos c
					WHERE idReferencia=4 AND c.idCategoria=d.documentoRequerido ORDER BY c.nombreCategoria=".$claseProceso;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo "1|".$arrRegistros;
	}
	
	
	function obtenerInfoCodigoProcesoUnico($cupj="")
	{
		global $con;
		if(isset($_POST["cupj"]))
			$cupj=$_POST["cupj"];
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
		$despacho=$con->obtenerValor($consulta);
		
		
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
		
		
		
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=2 ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
		
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
		$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		$leyenda="<div style='line-height:21px'><b>T&iacute;tulo del Proceso:</b> ".cv($fRegistroBase["tituloProceso"])."<br><b>Especialidad:</b> ".cv($especialidad).", <b>Tipo de Proceso:</b> ".
				cv($tipoProceso).", <b>Lugar de Radicaci&oacute;n:</b> ".cv($municipio).", ".cv($departamento)."<br><b>Demandante: </b> ".$demantante."<br><b>Demandados: </b>".$demandados."</div>";
		
		
		
		
		$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			cv($tipoProceso).'","tituloProceso":"'.cv($fRegistroBase["tituloProceso"]).'","demandantes":"'.cv($demantante).
			'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			'","leyenda":"'.$leyenda.'"}';
		
		echo "1|".$obj;
		
		
			
	}
	
	function obtenerProcesosDespacho()
	{
		global $con;
		$uG=$_POST["uG"];
		$anio=$_POST["anio"];
		$tC=$_POST["tC"];
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		
		$consulta="SELECT campoUsr,campoMysql FROM 9017_camposControlFormulario";
		$arrCampos=$con->obtenerFilasArregloAsocPHP($consulta);
		
		$condiciones="";
		if(isset($_POST["filter"]))
		{
			$filter=$_POST["filter"];
			$nFiltros=sizeof($filter);
			
			for($x=0;$x<$nFiltros;$x++)
			{
				switch($filter[$x]["field"])
				{
					
					case "carpetaAdministrativa":
						$carpetaAdministrativa=$filter[$x]["data"]["value"];
						$condiciones=" and carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "etapaProcesal":
						$condiciones=" and etapaProcesalActual in(".$filter[$x]["data"]["value"].")";
					break;			
					case "carpetaBase":
						$condiciones=" and carpetaAdministrativaBase like '%".$filter[$x]["data"]["value"]."%'";
					break;	
					default:
						$f=$filter[$x];
						$campo=$f["field"];
						
						if(isset($arrCampos[$campo]))
							$campo=$arrCampos[$campo];
						
						$condicion=" like ";
						if(isset($f["data"]["comparison"]))
						{
							switch($f["data"]["comparison"])
							{
								case "gt":
									$condicion=">";
								break;
								case "lt":
									$condicion="<";
								break;
								case "eq":
									$condicion="=";
								break;
							}
						}
						
						$valor="";
						switch($f["data"]["type"])
						{
							case "numeric":
								$valor=$f["data"]["value"];
							break;
							case "date":
								$fecha=$f["data"]["value"];
								$arrFecha=explode('/',$fecha);
								$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
							break;
							case "list":
								$condicion=" in ";
								$arrValores=explode(',',$f["data"]["value"]);
								$nCt=sizeof($arrValores);
								for($xAux=0;$xAux<$nCt;$xAux++)
								{
									if($valor=='')
										$valor=$arrValores[$xAux];
									else
										$valor.=",".$arrValores[$xAux];
								}
								
								
								$valor="(".$valor.")";
							break;
							default:
								$valor="'".$f["data"]["value"]."%'";
							break;
						}
						
						$condiciones.=" and ".$campo.$condicion.$valor;
					break;
					
				}
			}
			
		}
		
		
		
		$arrRegistro="";
		$numReg=0;
		$consulta="SELECT count(*) from 7006_carpetasAdministrativas  c
					WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
					and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones;
		$numReg=$con->obtenerValor($consulta);			
		$consulta="SELECT *
					
					 FROM 7006_carpetasAdministrativas  c
					WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
					and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones." ORDER BY carpetaAdministrativa limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);
	
		while($fila=$con->fetchAssoc($res))
		{
			
			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
			$resParte=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($resParte))
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
						AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$resParte=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($resParte))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$arrCarpetas=array();
			obtenerCarpetasPadre($fila["carpetaAdministrativa"],$arrCarpetas);
			if(sizeof($arrCarpetas)==0)
			{
				array_push($arrCarpetas,$fila["carpetaAdministrativa"]);
			}
			
			$carpetaBase=$arrCarpetas[0];
			
			$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaBase."' AND tipoCarpetaAdministrativa in(1,40)";
			$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
			if(!$fCarpetaBase)
				continue;
			$campos="";
			switch($fCarpetaBase["idFormulario"])
			{
				case 990:
					$campos="'' AS tituloProceso,'' AS departamento,'' AS municipio ";
				break;
				case 717:
					$campos="'' AS tituloProceso,departamentosRegistroTutela AS departamento,ciudadRegistroTutela AS municipio ";
					
				break;
				case 698:
					$campos="tituloProceso,departamentos as departamento,municipio ";
					
				break;
				case 1013:
					$campos="'' as tituloProceso,departamento,municipios as municipio ";
				break;
				default:
				
					if($con->existeCampo("tituloProceso","_".$fCarpetaBase["idFormulario"]."_tablaDinamica"))
						$campos="tituloProceso,departamento,municipio ";
					else
						$campos="'' as tituloProceso,departamento,municipio ";
					
					
					
					
					
				break;
			}
			
			$campoCarpeta="carpetaAdministrativa";
			if(!$con->existeCampo("carpetaAdministrativa","_".$fCarpetaBase["idFormulario"]."_tablaDinamica"))
			{
				$campoCarpeta="codigo";
			}
			$consulta="SELECT ".$campos." FROM _".$fCarpetaBase["idFormulario"]."_tablaDinamica WHERE ".$campoCarpeta."='".$arrCarpetas[0]."'";

			$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			
			
			$o='{"carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","situacion":"'.$fila["situacion"].'","fechaCreacion":"'.$fila["fechaCreacion"].
					'","demandados":"'.cv($demandados).'","tipoCarpeta":"'.$fila["tipoCarpetaAdministrativa"].'","demandantes":"'.cv($demantante).
				'","idCarpetaAdministrativa":"'.$fila["idCarpeta"].'","unidadGestion":"'.$fila["unidadGestion"].
				'","tituloProceso":"'.cv($fRegistroBase["tituloProceso"]==""?"------":$fRegistroBase["tituloProceso"]).'","tipoProceso":"'.$fila["tipoProceso"].
				'","departamento":"'.$fRegistroBase["departamento"].'","municipio":"'.$fRegistroBase["municipio"].
				'","idFormulario":"'.$fila["idFormulario"].'","idRegistro":"'.$fila["idRegistro"].'"}';
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
	}
	
	function obtenerInfoMetadataDocumento()
	{
		global $con;
		$idDocumento=$_POST["iD"];
		$idRegistroContenido=$_POST["idRegistroContenido"];
		
		$numReg=0;
		$arrRegistros="";
		
		$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$idDocumento;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrDocumento=explode(".",$fRegistro["nomArchivoOriginal"]);
		
		$o='{"idMeta":"-1","metaData":"Nombre del Documento","valor":"'.cv(mb_strtoupper($arrDocumento[0])).'"}';
		$arrRegistros=$o;
		$numReg++;
		
		$o='{"idMeta":"-2","metaData":"Tipo de Archivo","valor":"'.cv(mb_strtoupper($arrDocumento[sizeof($arrDocumento)-1])).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$fRegistro["categoriaDocumentos"];
		$categoria=$con->obtenerValor($consulta);
		
		$o='{"idMeta":"-3","metaData":"Categor&iacute;a del Documento","valor":"'.cv($categoria).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$o='{"idMeta":"-4","metaData":"Tamaño del Archivo","valor":"'.cv($fRegistro["tamano"]).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$o='{"idMeta":"-5","metaData":"Fecha de Registro","valor":"'.cv(date("d/m/Y H:i",strtotime($fRegistro["fechaCreacion"]))).' hrs."}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$o='{"idMeta":"-6","metaData":"Registrado Por","valor":"'.cv(obtenerNombreUsuario($fRegistro["responsable"])).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		
		$consulta="SELECT documentoRepositorio,repositorioDocumento FROM 908_archivos WHERE idArchivo=".$idDocumento;
		$fRegistroArchivos=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$rutaDocumento=$fRegistroArchivos["repositorioDocumento"]==0?obtenerRutaDocumento($idDocumento):$fRegistroArchivos["documentoRepositorio"];
		
		$o='{"idMeta":"-7","metaData":"Ruta de Almacenamiento","valor":"'.cv($rutaDocumento).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$o='{"idMeta":"-8","metaData":"Firma SHA 512","valor":"'.cv($fRegistro["sha512"]).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		//$consulta="SELECT valor FROM 908_metaDataArchivos WHERE idArchivo=".$idDocumento." AND idMetaDato=-9";
		//$perfilAcceso=$con->obtenerValor($consulta);
		$consulta="SELECT idPerfilAcceso FROM 7007_contenidosCarpetaAdministrativa WHERE idContenido=".$idRegistroContenido;
		$perfilAcceso=$con->obtenerValor($consulta);
		$o='{"idMeta":"-9","metaData":"Perfil de Acceso","valor":"'.$perfilAcceso.'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		$consulta="SELECT COUNT(*) FROM 3000_formatosRegistrados WHERE idDocumento=".$idDocumento;
		$numFilas=$con->obtenerValor($consulta);
		if($numFilas>0)
		{
			$o='{"idMeta":"-10","metaData":"<b>Historial del Documento</b>","valor":"<a href=\"javascript:abrirHistorialDocumento(\''.bE($idDocumento).'\')\">Ver ...</a>"}';
			$arrRegistros.=",".$o;
			$numReg++;
		}
		
		$consulta="SELECT categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$idDocumento;
		$categoriaDocumentos=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPerfilMetaDatos FROM 908_categoriasDocumentos WHERE idCategoria=".$categoriaDocumentos;
		$idPerfilMetaDatos=$con->obtenerValor($consulta);
		
		$consulta="SELECT FROM 20006_metaDatoPerfil p WHERE idPerfilMetaDato=".$idPerfilMetaDatos."";
		
		
		$consulta="SELECT p.*,m.nombreMetaDato,m.idMetaDato,m.tipoDatoEntrada FROM 20006_metaDatoPerfil p,20003_catalogoMetaDatos m 
				 WHERE idPerfilMetaDato=".$idPerfilMetaDatos." AND m.idMetaDato=p.idMetaDato ORDER BY m.nombreMetaDato";

		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT * FROM 908_metaDataArchivos WHERE idArchivo=".$idDocumento." AND idMetaDato=".$fila["idMetaDato"];
			$fInfoMetaDato=$con->obtenerPrimeraFilaAsoc($consulta);
			$valor=$fInfoMetaDato["valor"];
			$o='{"idMeta":"'.$fila["idMetaDato"].'","perfilMetadata":"1","metaData":"'.cv($fila["nombreMetaDato"]).'","valor":"'.cv($valor).
				'","arrOpciones":[],"tipoEntrada":"'.$fila["tipoDatoEntrada"].'","valorEtiqueta":"'.$fInfoMetaDato["valorEtiqueta"].'"}';
			$arrRegistros.=",".$o;
			$numReg++;
		}
			
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function actualizarMetaDataDocumento()
	{
		global $con;
		$tipoMetadata=$_POST["iM"];
		$valor=$_POST["valor"];
		$idDocumento=$_POST["idDocumento"];
		
		$consulta="";
		switch($tipoMetadata)
		{
			case 1:
				$consulta="UPDATE 908_archivos SET perfilAcceso=".$valor." WHERE idArchivo=".$idDocumento;
				
			break;
		}
		
		eC($consulta);
		
	}
	
	function crearNuevoUsuarioPortal()
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		global $funcionEnvioCorreoElectronico;
		global $versionLatis;
		
		$cadObjJson=$_POST["datosAutor"];
		
		$objJson=json_decode($cadObjJson);
		
		
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$prefijo="";
		if(isset($objJson->prefijo))
			$prefijo=$objJson->prefijo;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$codInstitucion="";
		if(isset($objJson->codInstitucion))
			$codInstitucion=$objJson->codInstitucion;
		$codDepto="";
		if(isset($objJson->codDepto))
			$codDepto=$objJson->codDepto;
			
		
		$idIdioma="1";
		$password=generarPassword();
		$sexo=0;
		if(isset($objJson->sexo))
			$sexo=$objJson->sexo;
		$mailUsr=$mail;
		$status="5";
		$telefonos="";
		
		if(isset($objJson->telefonos))
		{
			$telefonos=$objJson->telefonos;
		}
		
		
		
		
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma,cuentaActiva,cambiarDatosUsr,tipoCreacion) values('".
			cv(trim($mail))."',".$status.",'".date('Y-m-d')."',HEX(AES_ENCRYPT('".$password."', '".bD($versionLatis)."')),'".cv($nombreC)."',".$idIdioma.",0,2,1)";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		
		
		
		
		
		$idUsuario=$con->obtenerUltimoID();
		$_SESSION["idUsr"]=$idUsuario;
		
		$idArchivoIdentificacion="NULL";
		if($objJson->identificacion!="")
		{
			$idArchivoIdentificacion=registrarDocumentoServidorRepositorio($objJson->identificacion,$objJson->nombreDocumento,14,"");
			$_SESSION["idUsr"]=-1;
			if($idArchivoIdentificacion==-1)
			{
				echo "No ha podido guardar la identificaci&oacute;n";
				return;
			}
		}
		
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$arrRolesUsuario["23_0"]="1";
		
		foreach($arrRolesUsuario as $rol=>$resto)
		{
			$arrDatos=explode("_",$rol);
			$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",".$arrDatos[0].",".$arrDatos[1].",'".$rol."')";
			$x++;
		}
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario,Prefijo,Genero,fechaNacimiento,idArchivoIdentificacion,
						tipoIdentificacion,noIdentificacion,fechaExpedicionDocumento,grupoEtnico,discapacidad,datosValidados) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.",'".$prefijo."',".
					  $sexo.",".(isset($objJson->fechaNacimiento)?"'".$objJson->fechaNacimiento."'":"NULL").",".
					  $idArchivoIdentificacion.",".$objJson->tipoIdentificacion.",'".cv($objJson->noIdentificacion)."',".
					  ($objJson->fechaExpDocumento==''?"NULL":"'".$objJson->fechaExpDocumento)."',".$objJson->grupoEtnico.",".$objJson->discapacidad.",".
					  $objJson->datosValidados.")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		
		if(isset($objJson->direccion))
		{
			$oDireccion=$objJson->direccion;
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo,Calle,Numero,Colonia,CP,Estado,Municipio,NumeroInt,Pais) values(".$idUsuario.
							",0,'".cv($oDireccion->calle)."','".cv($oDireccion->noExt)."','".cv($oDireccion->colonia)."',".
							($oDireccion->cp==""?"NULL":$oDireccion->cp).",'".cv($oDireccion->estado).
							"','".cv($oDireccion->municipio)."','".cv($oDireccion->noInt)."',52)";
			$x++;
		}
		else
		{
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
			$x++;
		}
		
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		if($telefonos!="")
		{
			$arrTelefonos=explode(",",$telefonos);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode("__",$arrTelefonos[$y]);
				$tipo=$datosTel[0];
				$codArea=$datosTel[1];
				$lada=$datosTel[2];
				$tel=$datosTel[3];
				$ext=$datosTel[4];
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario,verificado) 
								values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo.",".$idUsuario.",1)";
				$x++;
			}
		}
		
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))		
		{
			$query="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr 
					from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$idUsuario;
			$fila=$con->obtenerPrimeraFila($query);
			
			
			
			/*$query="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
			$resRoles=$con->obtenerFilas($query);
			$listaGrupo="";
			while($fRoles=$con->fetchRow($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
*/			
			
			$arrParam["login"]=$mail;
			$arrParam["password"]=$password;
			$arrParam["nombreUsuario"]=$nombreC;
			$arrParam["idUsuario"]=$idUsuario;
			$arrParam["idActivacion"]=bE("cuenta:".$idUsuario);
			$arrParam["mailDestinatario"]=trim($mail);
			if(@enviarMensajeEnvio(13,$arrParam,$funcionEnvioCorreoElectronico))
			{
				echo "1|";
			}
			else
			{
				echo "Ha ocurrido un problema con el proveedor de envio de correos electr&oacute;nicos";
			}
			
		}
		else
			echo "|";
	}
	
	function recuperarDatosAcceso()
	{
		global $con;
		global $funcionEnvioCorreoElectronico;
		global $versionLatis;
		$mail=$_POST["mail"];
		$consulta="SELECT idUsuario FROM 805_mails WHERE Mail='".cv($mail)."' ORDER BY idMail DESC";
		$idUsuario=$con->obtenerValor($consulta);
		
		if($idUsuario=="")
		{
			echo "1|";
		}
		else
		{
			$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$idUsuario;
			$fUsr=$con->obtenerPrimeraFila($consulta);
			
			$arrParam["nombreUsuario"]=$fUsr[2];
			$arrParam["idUsuario"]=$idUsuario;
			$arrParam["login"]=$fUsr[0];
			$arrParam["password"]=$fUsr[1];
			$arrParam["mailDestinatario"]=trim($mail);
			
			@enviarMensajeEnvio(14,$arrParam,$funcionEnvioCorreoElectronico);
			echo "1|";
		}
	}
	
	
	function obtenerCarpetasUsuario()
	{
		global $con;
		
		
		$anio=$_POST["anio"];
		$noExpediente=$_POST["noExpediente"];
		$compNoExpediente="";
		if($noExpediente!="")
			$compNoExpediente.=" and u.carpetaAdministrativa like '%".$noExpediente."%'";
		$arrRegistros="";
		$consulta="SELECT DISTINCT distinct upper(e.nombreEspecialidadDespacho) as nombreEspecialidadDespacho,u.idUsuario,c.especialidad
				FROM 7006_usuariosVSCarpetasAdministrativas u,7006_carpetasAdministrativas c, 
					_637_tablaDinamica e WHERE idUsuario=".$_SESSION["idUsr"]." and u.situacion=1 
					and c.carpetaAdministrativa=u.carpetaAdministrativa and
					e.id__637_tablaDinamica=c.especialidad";

		if($anio!=0)
		{
			$consulta.=" and u.anioExpediente=".$anio;
		}

		$consulta.=" ".$compNoExpediente." ORDER BY nombreEspecialidadDespacho";
		
		

		$rMateria=$con->obtenerFilas($consulta);
		while($fMateria=$con->fetchAssoc($rMateria))
		{
			$arrJuzgados="";
			
			$consulta="SELECT DISTINCT unidadGestion FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$fMateria["idUsuario"].
					" AND cveMateria='".$fMateria["especialidad"]."'";

			$rJuzgado=$con->obtenerFilas($consulta);
			while($fJuzgado=$con->fetchRow($rJuzgado))
			{
				$nombreJuzgado="";
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fJuzgado[0]."'";
				$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
				$nombreJuzgado=$fNombreJuzgado[0];
				
				$arrExpedientes="";
				$oExpediente="";
				$consulta="SELECT distinct idCarpetaAdministrativa,u.carpetaAdministrativa,c.tipoProceso FROM 7006_usuariosVSCarpetasAdministrativas u,7006_carpetasAdministrativas c WHERE 
						idUsuario=".$fMateria["idUsuario"]." and u.situacion=1 and c.carpetaAdministrativa=u.carpetaAdministrativa and (c.carpetaAdministrativaBase is null or c.carpetaAdministrativaBase='')";
						
				if($anio!=0)
				{
					$consulta.=" AND  anioExpediente=".$anio;
				}
				$consulta.="  ".$compNoExpediente." and cveMateria='".$fMateria["especialidad"].
						"' AND u.unidadGestion='".$fJuzgado[0]."' ORDER BY u.carpetaAdministrativa";
				$rExpedientes=$con->obtenerFilas($consulta);
				while($fExpediente=$con->fetchRow($rExpedientes))
				{
					$arrExpedientesHijos=obtenerExpedientesDerivados($fExpediente[1],$fExpediente[0],$_POST);
					
					$oExpediente='{"icon":"../images/s.gif","id":"e_'.$fExpediente[0].'","text":"'.$fExpediente[1].'","expediente":"'.$fExpediente[1].
								'","idExpediente":"'.$fExpediente[0].'","tipo":"3","leaf":'.($arrExpedientesHijos=='[]'?"true":"false").
								',expanded:true,"unidadGestion":"'.$fJuzgado[0].
								'","tipoCarpeta":"'.$fExpediente[2].'","idMateria":"'.$fMateria["especialidad"].'","accesoVideograbaciones":"1",cls:"cssExpedientes","children":'.$arrExpedientesHijos.'}';
					if($arrExpedientes=="")
						$arrExpedientes=$oExpediente;
					else
						$arrExpedientes.=",".$oExpediente;
				}
				
				if($arrExpedientes=="")
					continue;
				
				$oJuzgado='{"icon":"../images/s.gif","id":"'.$fJuzgado[0].'","tipo":"2","juzgado":"'.cv(mb_strtoupper($nombreJuzgado)).'","text":"'.cv($nombreJuzgado).'","leaf":false,"children":['.$arrExpedientes.'],expanded:true,cls:"cssDespachos"}';
				if($arrJuzgados=="")
				{
					$arrJuzgados=$oJuzgado;
				}
				else
					$arrJuzgados.=",".$oJuzgado;
			}
			
			if($arrJuzgados=="")	
				continue;
			
			$o='{"icon":"../images/s.gif","id":"e_'.$fMateria["especialidad"].'","materia":"'.cv($fMateria["especialidad"]).
			'","tipo":"1","text":"ESPECIALIDAD: '.cv($fMateria["nombreEspecialidadDespacho"]).
			'","leaf":false,"children":['.$arrJuzgados.'],expanded:'.($noExpediente!=""?"true":"false").', cls:"cssEspecialidad"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
	}
	
	
	function obtenerExpedientesDerivados($carpetaAdministrativa,$idCarpeta,$parametros)
	{
		global $con;
		
		$anio=$_POST["anio"];
		$noExpediente=$_POST["noExpediente"];
		$compNoExpediente="";
		if($noExpediente!="")
			$compNoExpediente.=" and carpetaAdministrativa like '%".$noExpediente."%'";
		
		$arrJuzgados="";
		
		
		$consulta="SELECT DISTINCT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$carpetaAdministrativa."'";	
		$rJuzgado=$con->obtenerFilas($consulta);
		while($fJuzgado=$con->fetchRow($rJuzgado))
		{
			$arrExpedientes="";
			$nombreJuzgado="";
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fJuzgado[0]."'";
			$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
			$nombreJuzgado=$fNombreJuzgado[0];
			
			$arrExpedientes="";
			$oExpediente="";
			$consulta="SELECT c.idCarpeta,c.carpetaAdministrativa,especialidad,c.tipoProceso FROM 7006_carpetasAdministrativas c WHERE 
						c.carpetaAdministrativaBase='".$carpetaAdministrativa."'";
					
			if($anio!=0)
			{
				$consulta.=" AND  fechaCreacion>='".$anio."-01-01' AND fechaCreacion<='".$anio."-12-31 23:59:59'";
			}
			$consulta.="  ".$compNoExpediente."  AND c.unidadGestion='".$fJuzgado[0]."' ORDER BY carpetaAdministrativa";
			$rExpedientes=$con->obtenerFilas($consulta);
			while($fExpediente=$con->fetchRow($rExpedientes))
			{
				$arrExpedientesHijos="[]";
				if($carpetaAdministrativa!=$fExpediente[1])
					$arrExpedientesHijos=obtenerExpedientesDerivados($fExpediente[1],$fExpediente[0],$_POST);
				
				$oExpediente='{"icon":"../images/s.gif","id":"e_'.$fExpediente[0].'","text":"'.$fExpediente[1].'","expediente":"'.$fExpediente[1].
							'","idExpediente":"'.$fExpediente[0].'","tipo":"3","leaf":'.($arrExpedientesHijos=='[]'?"true":"false").
							',expanded:true,"unidadGestion":"'.$fJuzgado[0].
							'","tipoCarpeta":"'.$fExpediente[3].'","idMateria":"'.$fExpediente[2].'","accesoVideograbaciones":"1",cls:"cssExpedientes","children":'.$arrExpedientesHijos.'}';
				if($arrExpedientes=="")
					$arrExpedientes=$oExpediente;
				else
					$arrExpedientes.=",".$oExpediente;
			}
			
			if($arrExpedientes=="")
				continue;
			
			$oJuzgado='{"icon":"../images/s.gif","id":"'.$carpetaAdministrativa."_".$fJuzgado[0].'","tipo":"2",cls:"cssDespachos","juzgado":"'.cv(mb_strtoupper($nombreJuzgado)).'","text":"'.cv($nombreJuzgado).'","leaf":false,"children":['.$arrExpedientes.'],expanded:true}';
			if($arrJuzgados=="")
			{
				$arrJuzgados=$oJuzgado;
			}
			else
				$arrJuzgados.=",".$oJuzgado;
		}
		
		$arrJuzgados="[".$arrJuzgados."]";
		
		return $arrJuzgados;
	}
	
	function obtenerDocumentosCarpetaAdministrativaPortalUsuario()
	{
		global $con;
		$carpetaAdministrativa=bD($_POST["cA"]);
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$idCarpetaAdministrativa=-1;
		if(isset($_POST["idCarpetaAdministrativa"]))
			$idCarpetaAdministrativa=$_POST["idCarpetaAdministrativa"];
		
		$compCarpeta=" and idCarpetaAdministrativa in(-1";
		if($idCarpetaAdministrativa!=-1)
		{
			$compCarpeta.=",".$idCarpetaAdministrativa;
		}
		$compCarpeta.=")";
		$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);
	
		$cadCondWhere=str_replace("fechaCreacion"," cast(fechaCreacion as date)",$cadCondWhere);	
		
		$tDocumentos=-1;
		if(isset($_POST["tDocumentos"]))
			$tDocumentos=$_POST["tDocumentos"];
			
			
		$consulta="SELECT count(*) FROM 
						7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
						"' and tipoContenido=1 ".$compCarpeta." order by fechaRegistro";	
	
		$numDocumentos=$con->obtenerValor($consulta);
		
		if($numDocumentos==0)
		{
			$consulta="SELECT carpetaAdministrativa,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE 
					carpetaAdministrativa='".$carpetaAdministrativa."'";
					
			if($idCarpetaAdministrativa!=-1)
			{
				$consulta.=" and idCarpeta=".$idCarpetaAdministrativa;
			}
			
	
			$fCarpeta=$con->obtenerPrimeraFila($consulta);
			if(($fCarpeta)&&($fCarpeta[1]!=-1))
			{
				$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$fCarpeta[1]." AND idRegistro=".$fCarpeta[2];
				
				$rDocumentos=$con->obtenerFilas($query);
				while($fDocumento=$con->fetchRow($rDocumentos))
				{
					registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);	
				}
				
				
				switch($fCarpeta[1])
				{
					case 385:
						$consulta="SELECT 	* FROM _412_tablaDinamica WHERE idReferencia=".$fCarpeta[2];
						$fRegistroComplementario=$con->obtenerPrimeraFilaAsoc($consulta);
						if(($fRegistroComplementario["setencia"]!="")&&($fRegistroComplementario["setencia"]!="-1"))
						{
							
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["setencia"],-1,-1,"",3);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["setencia"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
							
						if(($fRegistroComplementario["auto"]!="")&&($fRegistroComplementario["auto"]!="-1"))
						{
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["auto"],-1,-1,"",3);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["auto"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
						if(($fRegistroComplementario["actaMinima"]!="")&&($fRegistroComplementario["actaMinima"]!="-1"))
						{
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["actaMinima"],-1,-1,"",12);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["actaMinima"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
					break;
				}
				
			}
		}
		
			
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales
					union 
					select 0,'Sin etapa',0 as orden 
					 ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$consulta="SELECT idFormulario,idRegistro,fechaRegistro,idRegistroContenidoReferencia FROM 
						7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0].
						" and tipoContenido=1 ".$compCarpeta." order by fechaRegistro";
	
			$rDocumentos=$con->obtenerFilas($consulta);
			while($fDocumentos=$con->fetchRow($rDocumentos))
			{
				if($fDocumentos[3]=="")
					continue;
				$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fDocumentos[3].($tDocumentos!=-1?" and categoriaDocumentos in(".$tDocumentos.
						") ":"")." and eliminado=0 and ".$cadCondWhere;
				$consulta.=" and categoriaDocumentos not in(53)";
	
				$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
				
				if($fDatosDocumento)
				{
					$arrNombreOriginal=explode(".",$fDatosDocumento[6]);
					$nomArchivoOriginal="";
					for($x=0;$x<sizeof($arrNombreOriginal);$x++)
					{
						if($x==(sizeof($arrNombreOriginal)-1))
						{
							$nomArchivoOriginal.=".".$arrNombreOriginal[$x];
						}
						else
							if($nomArchivoOriginal=="")
								$nomArchivoOriginal=$arrNombreOriginal[$x];
							else
								$nomArchivoOriginal.="_".$arrNombreOriginal[$x];
					}
					
					$etapaProcesal=$fila[0];
					if(($fDatosDocumento[16]!="")&&($fDatosDocumento[2]==""))
					{
						$nomArchivoOriginal="En espera de digitalizaci&oacute;n";
						$etapaProcesal=-1000;
					}
					
					$subidorPor="";
					if($fDatosDocumento[3]==2390)
						$subidorPor="PGJ";
					else
						$subidorPor="Unidad de Gesti&oacute;n";
					
					$o='{"fechaRegistro":"'.date("Y-m-d",strtotime($fDocumentos[2])).'","idDocumento":"'.$fDatosDocumento[0].'","etapaProcesal":"'.$etapaProcesal.'","nomArchivoOriginal":"'.cv($nomArchivoOriginal).'","tamano":"'.$fDatosDocumento[8].
						'","fechaCreacion":"'.$fDatosDocumento[2].'","descripcion":"'.cv($fDatosDocumento[11]).'","categoriaDocumentos":"'.$fDatosDocumento[12].
						'","idFormulario":"'.$fDocumentos[0].'","idRegistro":"'.$fDocumentos[1].'","subidorPor":"'.$subidorPor.'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				
					$numReg++;	
				}
			}		
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerResultadosBusquedaProceso()
	{
		global $con;
		
		$criterioBusqueda=$_POST["criterioBusqueda"];
		$obj=json_decode($criterioBusqueda);
		
		$condWhere="where carpetaAdministrativa in(SELECT carpetaAdministrativa FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].")";
		
		
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
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT * FROM 7006_carpetasAdministrativas  ".$condWhere;

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$cBase=obtenerCarpetaBaseOriginal($fila["carpetaAdministrativa"]);
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cBase."'";
			$fBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT * FROM _632_tablaDinamica WHERE id__632_tablaDinamica=".$fBase["idRegistro"];
			$fRadicacionBase=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT codigo FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".$fila["idRegistro"];
			$folioRegistro=$con->obtenerValor($consulta);
			
			
			
			$o='{"idFormulario":"'.$fila["idFormulario"].'","idRegistro":"'.$fila["idRegistro"].
				'","folioRegistro":"'.$folioRegistro.'","fechaRegistro":"'.$fila["fechaCreacion"].'","codigoUnicoProceso":"'.$fila["carpetaAdministrativa"].
				'","tituloProceso":"'.cv($fRadicacionBase["tituloProceso"]).'","especialidad":"'.$fila["especialidad"].'","departamento":"'.$fRadicacionBase["departamento"].
				'","despacho":"'.$fila["unidadGestion"].'","estadoProceso":"'.$fila["situacion"].
				'","tipoProceso":"'.$fila["tipoProceso"].'","idCarpeta":"'.$fila["idCarpeta"].'","tipoCarpeta":"'.$fila["tipoCarpetaAdministrativa"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerDocumentosResultadosBusquedaProceso()
	{
		global $con;
		
		$criterioBusqueda=$_POST["criterioBusqueda"];
		$objCriterio=json_decode($criterioBusqueda);
		
		$obj=$objCriterio->objProceso;
		$objArchivo=$objCriterio->objDocumento;
		
		
		$condWhere="where carpetaAdministrativa in(SELECT carpetaAdministrativa FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].")";
		
		
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
		
		if($obj->fechaInicioRegistro!='')
		{
			$condWhere.=" and fechaCreacion".$obj->condFInicioFiltro."'".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!='')
		{
			$condWhere.=" and fechaCreacion".$obj->condFFinFiltro."'".$obj->fechaFinRegistro."'";
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
		
		
		
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT distinct carpetaAdministrativa FROM 7006_carpetasAdministrativas  ".$condWhere;
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
		
		$condWhereArchivo="WHERE con.carpetaAdministrativa IN(".$listaCarpetas.") AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
							and u.idUsuario=a.responsable and c.carpetaAdministrativa=con.carpetaAdministrativa";
		
		
		if($objArchivo->formato!="")
		{
			$condFormado="";
			$arrFormatos=explode(",",$objArchivo->formato);
			
			foreach($arrFormatos as $f)
			{
				if($condFormado=="")
					$condFormado=" nomArchivoOriginal like '%.".$f."' ";
				else
					$condFormado.=" or nomArchivoOriginal like '%.".$f."' ";
			}
			$condWhereArchivo.=" and (".$condFormado.")";
		}
		
		if($objArchivo->categoriaDocumento!="")
		{
			$condWhereArchivo.=" and categoriaDocumentos=".$objArchivo->categoriaDocumento;
		}
		
		if($objArchivo->registradoPor!="")
		{
			$condWhereArchivo.=" and u.Nombre like '%".$objArchivo->registradoPor."%'";
		}
		
		if($objArchivo->fechaInicioRegistro!='')
		{
			$condWhereArchivo.=" and a.fechaCreacion".$objArchivo->condFInicioFiltro."'".$objArchivo->fechaInicioRegistro."'";
		}
		
		if($objArchivo->fechaFinRegistro!='')
		{
			$condWhereArchivo.=" and a.fechaCreacion".$objArchivo->condFFinFiltro."'".$objArchivo->fechaFinRegistro."'";
		}			
		
		
		if($objArchivo->cuerpoDocumento!="")
		{
			if($objArchivo->condCuerpoDocumento==2)
				$condWhereArchivo.=" and  MATCH(cuerpoDocumento) AGAINST('".$objArchivo->cuerpoDocumento."' IN NATURAL LANGUAGE MODE)";
		}
			
			
		
		$consulta="SELECT a.*,con.idFormulario,con.idRegistro,con.carpetaAdministrativa,c.idCarpeta,c.tipoCarpetaAdministrativa FROM 908_archivos a,7007_contenidosCarpetaAdministrativa con,
				800_usuarios u,7006_carpetasAdministrativas c ".$condWhereArchivo;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$permiteVisualizacion=existePermisoVisualizacion($fila["idArchivo"],$fila["carpetaAdministrativa"]);
			if(!$permiteVisualizacion)
				continue;
			
			
			$considerar=true;
			if($objArchivo->nombreDocumento!="")
			{
				$arrDatosDocumentos=explode(".",$fila["nomArchivoOriginal"]);
				
				$nombreArchivo="";
				for($x=0;$x<count($arrDatosDocumentos)-1;$x++)
				{
					$nombreArchivo.=$arrDatosDocumentos[$x];
				}
				
				$nombreArchivo=mb_strtoupper($nombreArchivo);
				$objArchivo->nombreDocumento=mb_strtoupper($objArchivo->nombreDocumento);
				switch($objArchivo->condNombreDocumento)
				{
					case 1://Inicia con
						if(strpos($nombreArchivo,$objArchivo->nombreDocumento)!==0)
						{
							$considerar=false;
						}
						
					break;
					case 2://Contiene
						
						
						if(strpos($nombreArchivo,$objArchivo->nombreDocumento)===false)
						{
							$considerar=false;
						}
						
					break;
					case 3://Termina con
						$tamanoCampo=strlen($objArchivo->nombreDocumento);
						$offset=strlen($nombreArchivo)-$tamanoCampo;
						if($offset<0)
							continue;
						if(strpos($nombreArchivo,$objArchivo->nombreDocumento,$offset)===false)
						{
							$considerar=false;
						}
						
					break;
				}
			}
			
			if(!$considerar)
				continue;
			if($fila["idFormulario"]=="")
				$fila["idFormulario"]=-1;
			if($fila["idRegistro"]=="")
				$fila["idRegistro"]=-1;
			
			$o='{"idDocumento":"'.$fila["idArchivo"].'","nomArchivoOriginal":"'.cv($fila["nomArchivoOriginal"]).'","tamano":"'.$fila["tamano"].
				'","fechaCreacion":"'.$fila["fechaCreacion"].'","descripcion":"'.cv($fila["descripcion"]).
				'","idFormulario":"'.$fila["idFormulario"].'","idRegistro":"'.$fila["idRegistro"].'","categoriaDocumentos":"'.$fila["categoriaDocumentos"].
				'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","idCarpeta":"'.$fila["idCarpeta"].'","tipoCarpeta":"'.$fila["tipoCarpetaAdministrativa"].'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerAgendaCitaDiasControl()
	{
		global $con;
		$tipoRecurso=$_POST["tipoRecurso"];
		$idRecurso=$_POST["idRecurso"];
		$idRegistroIgnorar=-1;
		if(isset($_POST["idRegistroIgnorar"]))
		{
			$idRegistroIgnorar=$_POST["idRegistroIgnorar"];
			
		}
		$start=$_POST["start"];
		$end=$_POST["end"];
		$minutosDesplazamiento=$_POST["minDesplazamiento"];
		$arrEventos="";
		$arrAsignaciones=array();
		$consulta="SELECT *	FROM _662_tablaDinamica WHERE idEstado>=2 and idEstado<>5 and  fechaCita>='".$start."' and fechaCita<='".$end."' and
					id__662_tablaDinamica not in(".$idRegistroIgnorar.")";
	
		$res=$con->obtenerFilas($consulta);
		while($fRecurso=$con->fetchAssoc($res))
		{
			$hInicioRecurso=$fRecurso["fechaCita"]." ".$fRecurso["horaInicialCita"];
			$hFinRecurso=$fRecurso["fechaCita"]." ".$fRecurso["horaFinalCita"];
			$fechaInicio=strtotime("-".$minutosDesplazamiento." minutes",strtotime($hInicioRecurso));
			$fechaFin=strtotime("-".$minutosDesplazamiento." minutes",strtotime($hFinRecurso));
					
					
			$color="";
			switch($fRecurso["idEstado"])
			{
				case 2:
				case 4:
				case 6:
					$color="006";
				break;	
				case 3:
					$color="030";
				break;
				
				
				
			}
					
			$title="Solicitud ".$fRecurso["codigo"]." - Solicitado por: ".obtenerNombreUsuario($fRecurso["responsable"]);
			$e='{"id":"e_'.$fRecurso["id__662_tablaDinamica"].'","editable":false,"title":"'.cv($title).
			'","start":"'.date("Y-m-d\TH:i:s",$fechaInicio).'","end":"'.date("Y-m-d\TH:i:s",$fechaFin).
			'","color":"#'.$color.'","eliminable":"false","iFormulario":"662","iRegistro":"'.$fRecurso["id__662_tablaDinamica"].'"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		echo '['.$arrEventos.']';
	}
	
	function registrarDocumentoAdjuntoCarpetaAdministrativa()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
	
		$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);
	
		if($idDocumento!=-1)
		{
			if(registrarDocumentoCarpetaAdministrativa($obj->carpetaAdministrativa,$idDocumento))
			{
				echo "1|".$idDocumento."|".$obj->nombreArchivo;
			}
		}
		else
		{
			echo "0|No se pudo guardar el documento";
		}
		
		
		
	}
	
	function obtenerPlantillaNotificacion()
	{
		global $con;
		$tN=$_POST["tN"];
		$cA=$_POST["cA"];
	
	
	
		$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$tN;
		$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT * FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$fMensajeEnvio=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT cuerpoMensaje FROM 2013_cuerposMensajes WHERE idMensaje=".$fTipoNotificacion["plantillaMensajeEnvio"];
		$cuerpoMensaje=$con->obtenerValor($consulta);
		
		$consulta="SELECT o.unidad,c.idActividad FROM 7006_carpetasAdministrativas c,817_organigrama o WHERE c.carpetaAdministrativa='".$cA.
				"' AND o.codigoUnidad=c.unidadGestion ";
		$fDatosCarpetas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros["nombreDespacho"]=$fDatosCarpetas["unidad"];
		$arrParametros["codigoUnicoProceso"]=$cA;
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
		
		foreach($arrParametros as $campo=>$valor)
		{
			$cuerpoMensaje=str_replace("[".$campo."]",$valor,$cuerpoMensaje);
		}
		
		echo "1|".bE($cuerpoMensaje);
		
	}
	
	function obtenerRegistroProgramacionAudienciaProcesoJudicial()
	{
		global $con;
		global $servidorPruebas;
		global $tipoMateria;
		$iE=$_POST["iE"];
		$cA=$_POST["cA"];
		$idCarpeta=$_POST["idCarpeta"];
		$iR=-1;
		$a="";
		$act="";

		$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion,tipoCarpetaAdministrativa,tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA.
				"' and unidadGestion='".$_SESSION["codigoInstitucion"]."'";
		if($idCarpeta!=-1)
		{
			$consulta.=" and idCarpeta=".$idCarpeta;
		}
		


		$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);

		$tCarpeta=$fDatosCarpeta[0];
		
		$consulta="SELECT cJ.usuarioJuez FROM _17_tablaDinamica j,_26_tablaDinamica cJ WHERE cJ.idReferencia=j.id__17_tablaDinamica AND j.claveUnidad='".$fDatosCarpeta[1]."'";
		$juezAsignar=$con->obtenerValor($consulta);
		if($juezAsignar=="")
			$juezAsignar=-1;
		if($tCarpeta==40)
		{
			
			$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
					r.codigoRol='96_0' AND ad.Institucion='".$fDatosCarpeta[1]."'";

			$juezAsignar=$con->obtenerListaValores($consulta);
		}
		
		if($tCarpeta==30)
		{
			$juezAsignar="";
			$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."' AND tipoCarpetaAdministrativa=30 ORDER BY idCarpeta";
			$resConsulta=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($resConsulta))
			{
				$consulta="SELECT ad.idUsuario FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
						r.codigoRol='96_0' AND ad.Institucion='".$fila["unidadGestion"]."'";
				$j=$con->obtenerValor($consulta);
				if($juezAsignar=="")
					$juezAsignar=$j;
				else
					$juezAsignar.=",".$j;
			}
		}
		
		$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."' and carpetaAdministrativa='".$cA.
				"' and idEstado=1";
				
		if($idCarpeta!=-1)
		{
			$consulta.=" and idCarpetaAdministrativa=".$idCarpeta;
		}		
		$consulta.=" order by id__185_tablaDinamica desc";	
		$fRegistro=$con->obtenerPrimeraFila($consulta);

		if(!$fRegistro)
		{
			
			$consulta="SELECT id__4_tablaDinamica,promedioDuracion FROM _4_tablaDinamica a,_785_tablaDinamica tp,_4_chkTipoExpediente tE WHERE
					tp.tipoAudiencia=a.id__4_tablaDinamica AND tE.idPadre=a.id__4_tablaDinamica AND tp.idReferencia=".$fDatosCarpeta[3]." AND tE.idOpcion=".$fDatosCarpeta[2];


			$fAudiencia=$con->obtenerPrimeraFila($consulta);
			$duracionAudiencia=$fAudiencia[1];
			$tAudiencia=$fAudiencia[0];
			
			$consulta="INSERT INTO _185_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion,codigoUnidad,carpetaAdministrativa,tipoAudiencia,
					idCarpetaAdministrativa,fechaEstimadaAudiencia,parametrosFechaMinima,duracionRequerida,
					idEventoReferencia,juezAsignar) VALUES(-1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$fDatosCarpeta[1]."','".$fDatosCarpeta[1].
					"','".$cA."',".$tAudiencia.",".$idCarpeta.",'".date("Y-m-d")."',1,'".$duracionAudiencia."',-1,'".$juezAsignar."')";
			

			
			if($con->ejecutarConsulta($consulta))
			{
				$idRegistroAudiencia=$con->obtenerUltimoID();
				$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$idRegistroAudiencia;
				$fRegistro=$con->obtenerPrimeraFila($consulta);
			}
		}
	
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(185);
		if($tipoMateria=="P")
		{
			$rol='69_0';//SUbdirector de Causa y Sala
			if($tCarpeta==6)
			{
				$rol='81_0';//SUbdirector de salas
			}
		}
		else
		{
			$rol='69_0';  //SUbdirector de Causa y Sala
			
		}
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro[1]);
		$act=bE($actor);
		
		echo "1|".$iR."|".$a."|".$act;
		
	}
	
	
	function registrarAudienciaSGJ()
	{
		global $con;
		global $urlSitio;
		$modificado=false;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas c,_17_tablaDinamica d
						WHERE c.unidadGestion=d.claveUnidad AND c.carpetaAdministrativa='".$obj->carpetaAdministrativa.
						"' AND d.id__17_tablaDinamica=".$obj->unidadGestion;
		$idActividad=$con->obtenerValor($consulta);
		$horaInicio=$obj->fecha." ".$obj->horaInicio;
		$horaFin=$obj->fecha." ".$obj->horaFin;
		
		
		
		
		if(!existeDisponibilidadSalaSGJ($obj->idEvento,$obj->sala,$obj->fecha,$horaInicio,$horaFin))
		{
			echo "0|<br>La sala seleccionada ya no se encuentra disponible<br>";
			return;
		}
		
		$x=0;
		$query[$x]="begin";
		$x++;	
		$idJuezAnterior="";
		if($obj->idEvento!="-1")
		{
			$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento;
			$idJuezAnterior=$con->obtenerValor($consulta);
				
			$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idCentroGestion,idSala,idEdificio,tipoAudiencia,tipoTribunal
						  FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
			$fEvento=$con->obtenerPrimeraFila($consulta);
			if($fEvento[0]!="")
			{
				$query[$x]="INSERT INTO 3006_bitacoraCambiosSalaFecha(idEventoAudiencia,fechaOperacion,idResponsableOperacion,fechaOriginal,horaInicioOriginal,horaTerminoOriginal,
						idSalaOriginal,fechaCambio,horaInicioCambio,horaTerminoCambio,idSalaCambio,idMotivoCambio,comentariosAdicionales,asignacionJuez)
						VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$fEvento[0]."','".$fEvento[1].
						"','".$fEvento[2]."',".($fEvento["4"]==""?-1:$fEvento["4"]).
						",'".$obj->fecha."','".$horaInicio."','".$horaFin."','".$obj->sala."','0','',".($idJuezAnterior==""?"NULL":$idJuezAnterior).")";
				$x++;
			}
			$query[$x]="update 7000_eventosAudiencia set 
					fechaEvento='".$obj->fecha."',horaInicioEvento='".$horaInicio."',
					horaFinEvento='".$horaFin."',fechaAsignacion='".date("Y-m-d H:i:s").
					"',idEdificio=".$obj->edificio.",idSala=".$obj->sala.",fechaLimiteAtencion=NULL,
					fechaSolicitud='".date("Y-m-d H:i:s")."',tipoAudiencia=".$obj->tipoAudiencia.
					",nombreEvento='".cv($obj->nombreEvento)."',descripcionEvento='".cv($obj->descripcionEvento).
					"' where idRegistroEvento=".$obj->idEvento;
			$x++;
			$query[$x]="set @idRegistro:=".$obj->idEvento;
			$x++;
			$modificado=true;
		}
		else
		{
			$etapa=obtenerEtapaProcesalCarpetaAdministrativa($obj->carpetaAdministrativa);
			$query[$x]="insert into 7000_eventosAudiencia(fechaEvento,horaInicioEvento,horaFinEvento,situacion,fechaAsignacion,idEdificio,idCentroGestion,
						idSala,idFormulario,idRegistroSolicitud,idReferencia,idEtapaProcesal,tipoAudiencia,fechaLimiteAtencion,fechaSolicitud,tipoTribunal,
						nombreEvento,descripcionEvento)
						values('".$obj->fecha."','".$horaInicio."','".$horaFin."',1,'".date("Y-m-d H:i:s").
						"',".$obj->edificio.",".$obj->unidadGestion.",".$obj->sala.",".$obj->idFormulario.",".$obj->idRegistroSolicitud.",-1,".$etapa.",".//Situacion=1
						$obj->tipoAudiencia.",NULL,'".date("Y-m-d H:i:s")."',1,'".cv($obj->nombreEvento)."','".cv($obj->descripcionEvento)."')";
			$x++;	
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;	
		}
		
		$query[$x]="DELETE FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=@idRegistro";
		$x++;
		
		foreach($obj->participantes as $p)
		{
			if(!existeDisponibilidadParticipante($obj->idEvento,$p->idPersona,$obj->fecha,$horaInicio,$horaFin))
			{
				echo "0|<br>El participante ".$p->nombre." ya no cuenta con disponibilidad<br>";
				return;
			}
			
			
			$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$p->idPersona;
			$idFiguraJuridica=$con->obtenerValor($consulta);
			
			if($idFiguraJuridica==5)
			{
				$consulta="SELECT folioIdentificacion FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$p->idPersona;
				$folioIdentificacion=$con->obtenerValor($consulta);
				
				$arrResultados=buscarInformacionSirna($folioIdentificacion,1);
				switch($arrResultados["Respuesta"])
				{
					case 1:
						if($arrResultados["Estado"]!="Vigente")
						{
							echo "0|<br>La tarjeta profesional de ".$p->nombre." NO se encuentra vigente<br>";
							return;
						}
					break;
				}
				
				
				
			}
			
			$query[$x]="INSERT INTO 7000_participantesEventoAudiencia(idRegistroEvento,tipoPersona,nombrePersona,mail,idPersona)
						VALUES(@idRegistro,".$p->tipoPersona.",'".cv($p->nombre)."','".$p->mail."',".$p->idPersona.")";
			$x++;
		}

		$query[$x]="DELETE FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=@idRegistro";
		$x++;	
		
		
		
		$noRondaMaxima=0;
		$serieRondaMaxima=0;	
	
	
		$numJuez=1;
		$lJuecesAsignados="";
		foreach($obj->jueces as $j)
		{
			$arrJuecez=explode(",",$j->idUsuario);
			foreach($arrJuecez as $juez)
			{	
				if(!existeDisponibilidadJuez($juez,$obj->fecha,$horaInicio,$horaFin,$obj->idEvento,"",true))
				{
					echo '0|<br>Ya no existe disponibilidad del Juez: '.obtenerNombreUsuario($juez).'<br>';
					return;
				}
				
				if($lJuecesAsignados=="")
					$lJuecesAsignados=$juez;
				else
					$lJuecesAsignados.=",".$juez;
				
				$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$juez;
				$noJuez=$con->obtenerValor($consulta);
				
				if($obj->tipoAudiencia==257)
				{
					if($numJuez==1)
						$j->participacion="Ponente";
					else
						$j->participacion="";
				}
				
				$query[$x]="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,ministerioLey,serieRonda,noRonda,idUGARonda) 
				VALUES(@idRegistro,".$juez.",".$j->tipoJuez.",'".cv($j->participacion)."','".$noJuez."',".
				$j->ministerioLey.",'".$j->serieRonda."',".($j->noRonda==""?"NULL":$j->noRonda).",".$obj->unidadGestion.")";
				$x++;
				$numJuez++;	
			}
			if($noRondaMaxima<$j->noRonda)
			{
				$noRondaMaxima=$j->noRonda;
			}	
			$serieRondaMaxima=$j->serieRonda;
			 
		}
	
		if(strpos($serieRondaMaxima,"_D")===false)
		{
			if($serieRondaMaxima!="G")
			{
				$consulta="SELECT noRonda FROM 7004_seriesRondaAsignacion WHERE idUGARonda=".$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'";
				$nRondaActual=$con->obtenerValor($consulta);
				
				if($nRondaActual<$noRondaMaxima)
				{
					$query[$x]="UPDATE 7004_seriesRondaAsignacion SET noRonda='".$noRondaMaxima."' WHERE idUGARonda=".
								$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'";
					$x++;
				}
			}
			else
			{
				$idPeriodoGuardia=obtenerIdPeriodoGuardia($obj->unidadGestion);	
				$consulta="SELECT noRonda FROM 7004_seriesRondaAsignacionGuardia WHERE idUGARonda=".$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'
							and idPeriodoGuardia=".$idPeriodoGuardia;
							
				$nRondaActual=$con->obtenerValor($consulta);
				
				if($nRondaActual<$noRondaMaxima)
				{
					$query[$x]="UPDATE 7004_seriesRondaAsignacionGuardia SET noRonda='".$noRondaMaxima."' WHERE idUGARonda=".
								$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."' and idPeriodoGuardia=".$idPeriodoGuardia;
					$x++;
				}
			}
		}
		$query[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT id__15_tablaDinamica as idSala,perfilSala,funcionesNotificacion,funcionCancelacion,urlServicioGrabacion,
					valorComplementario,enviarNotificacion FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$obj->sala;
			$fDatosSala=$con->obtenerPrimeraFilaAsoc($consulta);
	
			$consulta="select @idRegistro";
			$idEventoAgenda=$con->obtenerValor($consulta);
			registrarAudienciaCarpetaAdministrativa($obj->idFormulario,$obj->idRegistroSolicitud,$idEventoAgenda);
			@notificarEventoAudienciaSala($idEventoAgenda);
			if($fDatosSala["enviarNotificacion"]==1)
			{
				enviarCorreoNotificacionAudiencia($idEventoAgenda,1);
			}
			$numEtapaCambio="";
			if($modificado)
			{
				$numEtapaCambio=10;
				
			}
			else
			{
				$numEtapaCambio=5;
			}
			
			cambiarEtapaFormulario(185,$obj->idRegistroSolicitud,$numEtapaCambio,"",-1,"NULL","NULL",1695);
			echo "1|".$idEventoAgenda;
			
		}
		else
			echo "0|";
		
		
	}
	
	
	
	
	function obtenerSalasDisponiblesDespacho()
	{
		global $con;
		$idUnidadGestion=$_POST["idUnidadGestion"];
		$tipoAudiencia=-1;
		if(isset($_POST["tipoAudiencia"]))
			$tipoAudiencia=$_POST["tipoAudiencia"];
		$idEdificio=$_POST["idEdificio"];
		
		$carpetaAdministrativa="";
		if(isset($_POST["carpetaAdministrativa"]))
			$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		
		$arrSalas=obtenerSalasAudienciaDisponibleDespacho($idUnidadGestion,$idEdificio,$tipoAudiencia,$carpetaAdministrativa);
		
		
		
		echo "1|".$arrSalas;
		
	}
	
	
	function obtenerEventosSalaAudiencia()
	{
		global $con;
		global $tipoMateria;
		global $considerarDisponibilidadSujetosProcesajes;

		$idSala=$_POST["idSala"];
		$idEvento=$_POST["iEvento"];
		$idUnidadGestion=-1;
		if(isset($_POST["iU"]))
			$idUnidadGestion=$_POST["iU"];
			
		$asignacionJuez=0;
		if(isset($_POST["asignacionJuez"]))
			$asignacionJuez=$_POST["asignacionJuez"];
			
		$idJueces=-1;
		if(isset($_POST["idJueces"]))
			$idJueces=$_POST["idJueces"];	
		
		$carpetaAdministrativa="";
		if(isset($_POST["carpetaAdministrativa"]))
			$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas where carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);	
		
		$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad;
		$idCuentaAcceso=$con->obtenerListaValores($consulta);
		if($idCuentaAcceso=="")
			$idCuentaAcceso=-1;
			
		$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idCuentaAcceso IN(".$idCuentaAcceso.")";
		$listaParticipantes=$con->obtenerListaValores($consulta);
		if($listaParticipantes=="")
			$listaParticipantes=-1;
			
		$fechaLimiteAtencion="";
		$arrEventos="";
		
		$listaEventosIgnorar=$idEvento;
		
		
		$cServiciosNube=new cAdministradorConectoresServiciosNube();
		
		$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),
					idCentroGestion,fechaEvento,idRegistroEvento,idSala,fechaLimiteAtencion FROM 7000_eventosAudiencia a WHERE 
					idRegistroEvento=".$idEvento;
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila)
		{
			$fechaLimiteAtencion=$fila[7];
			$e='{"id":"e_'.$fila[5].'","editable":true,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
			$arrEventos=$e;
		}
		
		
		$start=$_POST["start"];
		$end=$_POST["end"];
		$arrFilasEventos=array();
		
		$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$idSala;
		$perfilSala=$con->obtenerValor($consulta);
		$ignorarEventosSala=false;
		if(($perfilSala==3)||($perfilSala==4))
			$ignorarEventosSala=true;
		
		if(!$ignorarEventosSala)
		{
			$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
						(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),idRegistroEvento FROM 7000_eventosAudiencia a
						WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
						a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
						and idRegistroEvento<>".$idEvento;
	
	
		
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				array_push($arrFilasEventos,$fila);
			}
		
		}
	
		foreach($arrFilasEventos as $fila)
		{
			//$listaEventosIgnorar.=",".$fila[3];
			
			
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
			$cAdministrativa=$con->obtenerValor($consulta);
			
			
			$e='{"id":"e_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).' ['.$fila[3].']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		
		if(($asignacionJuez==0)&&($idJueces==-1))
		{
			$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento." and idJuez<>0";
			$rJuez=$con->obtenerFilas($consulta);
			while($fJuez=$con->fetchRow($rJuez))
			{
		
				$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),'Evento de Juez',a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
							WHERE e.idJuez=".$fJuez[0]." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
							fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
							and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
				
				
	
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchRow($res))
				{
	
					$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
				}
				
				$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica,hInicio,hFin,tipoIntervalo FROM _20_tablaDinamica 
						WHERE usuarioJuez=".$fJuez[0]." and fechaInicial<='".$start."' and fechaFinal>='".$start.
						"' and idEstado=1 ";
	
				$iJuez=$con->obtenerFilas($consulta);
				while($fIncidencia=$con->fetchRow($iJuez))
				{
					
					if($fIncidencia[5]==1)
						$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
					else
						$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T".$fIncidencia[3]).'","end":"'.($start."T".$fIncidencia[4]).'","color":"#3D00CA"}';	
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
				}
				
				$nEventoCalendario=1;
				$arrEventosCalendariosUsuario=$cServiciosNube->obtenerEventosCalendariosUsuario($fJuez[0],$start." 00:00:00",$end." 23:59:59",true,"Evento de Juez (".obtenerNombreUsuario($fParticipante["idCuentaAcceso"]).")");
				foreach($arrEventosCalendariosUsuario as $e)
				{
					$nEventoCalendario=1;
					$e='{"id":"eJC_'.$nEventoCalendario.'","editable":false,"title":"'.cv($e["actividad"]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($e["inicio"])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($e["fin"])).'","color":"#E56A4B"}';	
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
					$nEventoCalendario++;
				}
				
			}
		
		
			
			
		
		
		}
		
		
		if($idJueces!=-1)
		{
			$arrJueces=explode(",",$idJueces);
			
			foreach($arrJueces as $j)
			{
				if($j==0)
					continue;
				$nombreUsuario=obtenerNombreUsuario($j);
				$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),'Evento :".$nombreUsuario."',a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
							WHERE e.idJuez=".$j." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
							fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
							and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
				
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchRow($res))
				{
	
					$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
				}
				
				$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica,hInicio,hFin,tipoIntervalo  FROM _20_tablaDinamica 
						WHERE usuarioJuez=".$j." and fechaInicial<='".$start."' and fechaFinal>='".$start."' and idEstado=1";
				$iJuez=$con->obtenerFilas($consulta);
				while($fIncidencia=$con->fetchRow($iJuez))
				{
					
					if($fIncidencia[5]==1)
						$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"'.$nombreUsuario.' se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
					else
						$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"'.$nombreUsuario.' se reporta como No disponible","start":"'.($start."T".$fIncidencia[3]).'","end":"'.($start."T".$fIncidencia[4]).'","color":"#3D00CA"}';	
	
					
					
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
				}
				
				
				
				$nEventoCalendario=1;
				$arrEventosCalendariosUsuario=$cServiciosNube->obtenerEventosCalendariosUsuario($j,$start." 00:00:00",$end." 23:59:59",true,"Evento de Juez (".obtenerNombreUsuario($j).")");

				foreach($arrEventosCalendariosUsuario as $e)
				{
					$nEventoCalendario=1;
					$e='{"id":"eJC_'.$nEventoCalendario.'","editable":false,"title":"'.cv($e["actividad"]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($e["inicio"])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($e["fin"])).'","color":"#E56A4B"}';	
					
					if($arrEventos=="")
						$arrEventos=$e;
					else
						$arrEventos.=",".$e;
					$nEventoCalendario++;
				}
				
			}
		}
		
		if($idUnidadGestion==-1)
		{
			if($idEvento!=-1)
			{
				$consulta="SELECT idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
				$idUnidadGestion=$con->obtenerValor($consulta);
				if($idUnidadGestion=="")
					$idUnidadGestion=-1;
			}
			
		}
		
		
		$consulta="SELECT idReferencia FROM _25_gDespachosAsignados WHERE despacho=".$idUnidadGestion;	
	
		$listaIncidencias=$con->obtenerListaValores($consulta);
		if($listaIncidencias=="")
			$listaIncidencias=-1;
		
		$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
					AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=1
					union
					SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
					AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=0 and id__25_tablaDinamica in(".
					$listaIncidencias.")";
	
		$iSala=$con->obtenerFilas($consulta);
		while($fIncidencia=$con->fetchRow($iSala))
		{
			
			$horaInicial="00:00:00";
			$horaFinal="23:59:59";
			if($fIncidencia[1]=="")
				$fIncidencia[1]=$horaInicial;
			
			if($fIncidencia[3]=="")
				$fIncidencia[3]=$horaFinal;
				
			
			
			if($fIncidencia[5]==2)
			{
				
				if($fIncidencia[0]==$start)
				{
					$horaInicial=$fIncidencia[1];
				}
				
				
				if($fIncidencia[2]==$start)
				{
					$horaFinal=$fIncidencia[3];
				}
				
			}
			else
			{
				$horaInicial=$fIncidencia[1];
				$horaFinal=$fIncidencia[3];
			}
			$e='{"id":"iS_'.$fIncidencia[4].'","editable":false,"title":"La sala ha sido marcada como No disponible","start":"'.
				($start."T".str_pad($horaInicial,5,"0",STR_PAD_LEFT)).'","end":"'.($start."T".str_pad($horaFinal,5,"0",STR_PAD_LEFT)).'","color":"#B55381"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
	
		if($fechaLimiteAtencion!="")
		{
			$fechaLimiteAtencion=strtotime($fechaLimiteAtencion);
			if(strtotime(date("Y-m-d",$fechaLimiteAtencion))<=strtotime($start))
			{
				$horaInicial="00:00:00";		
				if(strtotime(date("Y-m-d",$fechaLimiteAtencion))==strtotime($start))
				{
					$horaInicial=date("H:i:s",$fechaLimiteAtencion);
				}
				
				$horaFinal="23:59:59";			
				$e='{"id":"limiteAtencion","editable":false,"title":"Fuera del límite máximo de atención","start":"'.($start."T".str_pad($horaInicial,5,"0",STR_PAD_LEFT)).'","end":"'.($start."T".str_pad($horaFinal,5,"0",STR_PAD_LEFT)).'","color":"#000"}';	
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
		}
		
		if($considerarDisponibilidadSujetosProcesajes)
		{
		$consulta="SELECT distinct if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
					'Evento de Participante de Audiencia',a.idRegistroEvento FROM 7000_eventosAudiencia a,7000_participantesEventoAudiencia p
							WHERE  fechaEvento>='".$start."' AND 
							fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
							and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)
							and p.idRegistroEvento=a.idRegistroEvento and p.idPersona in(".$listaParticipantes.")";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{

			$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"Evento de Participante de Audiencia","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#A89D07"}';	
			
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad;
		$rParticipantes=$con->obtenerFilas($consulta);
		while($fParticipante=$con->fetchAssoc($rParticipantes))
		{
			$nEventoCalendario=1;
			$arrEventosCalendariosUsuario=$cServiciosNube->obtenerEventosCalendariosUsuario($fParticipante["idCuentaAcceso"],$start." 00:00:00",$end." 23:59:59",true,"Evento de Participante de Audiencia (".obtenerNombreUsuario($fParticipante["idCuentaAcceso"]).")");
			foreach($arrEventosCalendariosUsuario as $e)
			{
				$nEventoCalendario=1;
				$e='{"id":"ePC_'.$nEventoCalendario.'","editable":false,"title":"'.cv($e["actividad"]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($e["inicio"])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($e["fin"])).'","color":"#A89D07"}';	
				
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
				$nEventoCalendario++;
			}
		}
		}
		echo '['.$arrEventos.']';
		
	}
	
	
	function obtenerAsistenciaPartesAudiencia()
	{
		global $con;
		$idEventoAudiencia=$_POST["idEventoAudiencia"];
		$idActividad=$_POST["idActividad"];
		
		$consulta="SELECT COUNT(*) FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=-".$idEventoAudiencia;
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEventoAudiencia;
			
			$res=$con->obtenerFilas($consulta);
			//$idJuez=$con->obtenerValor($consulta);	
			while($fila=$con->fetchAssoc($res))
			{
				$consulta="INSERT INTO 7000_participantesEventoAudiencia(idRegistroEvento,tipoPersona,nombrePersona,notificado)
						VALUES(-".$idEventoAudiencia.",1,'".$fila["idJuez"]."',0)";
				
				$con->ejecutarConsulta($consulta);
			}
		}
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegistro,nombrePersona,asistencia,horaEntrada,horaSalida,comentariosAdicionales,idRegistroEvento,idPersona FROM 7000_participantesEventoAudiencia WHERE
					idRegistroEvento=".$idEventoAudiencia." OR idRegistroEvento=-".$idEventoAudiencia;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$tarjetNoVigente=0;
			
			$tipoPersona=1;
			if($fila["idRegistroEvento"]<0)
			{
				$tipoPersona=2;
				
				$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles WHERE idUsuario=".$fila["nombrePersona"]." AND codigoRol='96_0'";
				$numElementos=$con->obtenerValor($consulta);
				if($numElementos>0)
					$tipoPersona=3;
				$fila["nombrePersona"]=obtenerNombreUsuario($fila["nombrePersona"]);
			}
			
			if($fila["horaEntrada"]=="")
			{
				$consulta="SELECT IF(horaInicioReal IS NULL,horaInicioEvento,horaInicioReal),IF(horaTerminoReal IS NULL,horaFinEvento,horaFinEvento) 
						FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEventoAudiencia;
				$fEvento=$con->obtenerPrimeraFila($consulta);
				$fila["horaEntrada"]=date("H:i",strtotime($fEvento[0]));
				$fila["horaSalida"]=date("H:i",strtotime($fEvento[1]));
			}
			else
			{
				$fila["horaEntrada"]=date("H:i",strtotime($fila["horaEntrada"]));
				$fila["horaSalida"]=date("H:i",strtotime($fila["horaSalida"]));
			}
			
			if($fila["idPersona"]!="")
			{
				$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$fila["idPersona"];
				$idFiguraJuridica=$con->obtenerValor($consulta);
				
				if($idFiguraJuridica==5)
				{
					$consulta="SELECT folioIdentificacion FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila["idPersona"];
					$folioIdentificacion=$con->obtenerValor($consulta);
					
					$arrResultados=buscarInformacionSirna($folioIdentificacion,1);
					switch($arrResultados["Respuesta"])
					{
						case 1:
							if($arrResultados["Estado"]!="Vigente")
							{
								$tarjetNoVigente=1;
							}
						break;
						case 0:
							$tarjetNoVigente=2;
						break;
					}
					
					
					
				}
			}
			$o='{"idParticipante":"'.$fila["idRegistro"].'","nombreParticipante":"'.cv($fila["nombrePersona"]).'","asistencia":"'.$fila["asistencia"].
				'","horaEntrada":"'.$fila["horaEntrada"].'","horaSalida":"'.$fila["horaSalida"].'","comentariosAdicionales":"'.$fila["comentariosAdicionales"].
				'","tipoParticipante":"'.$tipoPersona.'","tarjetaNoVigente":"'.$tarjetNoVigente.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarAsistenciaAudiencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$consulta="UPDATE 7000_participantesEventoAudiencia SET asistencia=".$obj->asistio.",horaEntrada='".$obj->horaEntrada."',horaSalida='".$obj->horaSalida.
				"',comentariosAdicionales='".cv($obj->comentariosAdicionales)."' WHERE idRegistro=".$obj->idRegistro;
		
	
		eC($consulta);
	}
	
	
	function obtenerEventosAgendaAudiencia()
	{
		global $con;
		
		$arrEventos="";
		$tipoVista=$_POST["tipoVista"];
		$idReferencia=$_POST["idReferencia"];
		$from=$_POST["start"];
		$to=$_POST["end"];
		
		$arrSituaciones=array();
		$consulta="SELECT idSituacion,descripcionSituacion,icono FROM 7011_situacionEventosAudiencia";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arrSituaciones[$fila[0]]["etiqueta"]=$fila[1];
			$arrSituaciones[$fila[0]]["icono"]=$fila[2];
		}
		
		switch($tipoVista)
		{
			case 1: //Juez
				$consulta="SELECT distinct fechaEvento,if(horaInicioReal is null,horaInicioEvento,horaInicioReal) as horaInicio,
						if(horaTerminoReal is null,horaFinEvento,horaTerminoReal) as horaFin,
						e.situacion,e.idRegistroEvento,ta.tipoAudiencia,nombreEvento,con.carpetaAdministrativa,e.idCentroGestion  
						FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j,_4_tablaDinamica ta,7007_contenidosCarpetaAdministrativa con
						WHERE j.idRegistroEvento=e.idRegistroEvento and ta.id__4_tablaDinamica=e.tipoAudiencia 
						AND fechaEvento>='".$from."' AND fechaEvento<='".$to."' AND j.idJuez=".$idReferencia." and con.tipoContenido=3 AND 
						con.idRegistroContenidoReferencia=e.idRegistroEvento order by horaInicio";
			break;
			case 2: //Despacho
				$consulta="SELECT distinct fechaEvento,if(horaInicioReal is null,horaInicioEvento,horaInicioReal) as horaInicio,
						if(horaTerminoReal is null,horaFinEvento,horaTerminoReal) as horaFin,
						e.situacion,e.idRegistroEvento,ta.tipoAudiencia,nombreEvento,con.carpetaAdministrativa,e.idCentroGestion 
						FROM 7000_eventosAudiencia e,_4_tablaDinamica ta,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c
						WHERE fechaEvento>='".$from."' AND fechaEvento<='".$to."' and ta.id__4_tablaDinamica=e.tipoAudiencia 
						and con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento and c.carpetaAdministrativa=con.carpetaAdministrativa
						and c.unidadGestion='".$idReferencia."' order by horaInicio";

			break;
			case 3: //Usuario
				$consulta="SELECT distinct fechaEvento,if(horaInicioReal is null,horaInicioEvento,horaInicioReal) as horaInicio,
						if(horaTerminoReal is null,horaFinEvento,horaTerminoReal) as horaFin,
						e.situacion,e.idRegistroEvento,ta.tipoAudiencia,nombreEvento, con.carpetaAdministrativa,e.idCentroGestion 
						FROM 7000_eventosAudiencia e,7000_participantesEventoAudiencia p,_4_tablaDinamica ta,7005_relacionFigurasJuridicasSolicitud r,
						7007_contenidosCarpetaAdministrativa con
						WHERE p.idRegistroEvento=e.idRegistroEvento and ta.id__4_tablaDinamica=e.tipoAudiencia and e.situacion>0
						AND fechaEvento>='".$from."' AND fechaEvento<='".$to."' AND r.idParticipante=p.idPersona and 
						r.idCuentaAcceso=".$idReferencia." and con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento order by horaInicio";
			break;
		}
		
		
		
		$resJueces=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($resJueces))
		{
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["idCentroGestion"];
			$lblDespacho=$con->obtenerValor($consulta);
			
			$imagen="<img src='../images/".$arrSituaciones[$fila["situacion"]]["icono"]."' title='".$arrSituaciones[$fila["situacion"]]["etiqueta"].
					"' alt='".$arrSituaciones[$fila["situacion"]]["etiqueta"]."' height='14' width='14'>";
			$titulo=cv("ID ".$fila["idRegistroEvento"]."__".$fila["tipoAudiencia"]."__[".$fila["carpetaAdministrativa"]."]__".$lblDespacho);

			

			
			$e='{"id":"e_'.$fila["idRegistroEvento"].'","editable":false,"title":"'.$titulo.'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila["horaInicio"])).'","end":"'.
			date("Y-m-d\TH:i:s",strtotime($fila["horaFin"])).'","color":"#F1F7FF"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		
		
		echo '['.$arrEventos.']';
		
	}
	
	
	function obtenerDatosEventoAudienciaSGJ()
	{
		global $con;
		$idEvento=$_POST["iE"];
		$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
		$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fDatosEvento["idEdificio"]=="")
			$fDatosEvento["idEdificio"]=-1;
		
		$consulta="SELECT CONCAT('[',cveInmueble,'] ',nombreInmueble) FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$fDatosEvento["idEdificio"];
		$nombreInmueble=$con->obtenerValor($consulta);
			
		if($fDatosEvento["idCentroGestion"]=="")
			$fDatosEvento["idCentroGestion"]=-1;	
		
		if($con->existeCampo("claveFolioCarpetas","_17_tablaDinamica"))
			$consulta="SELECT CONCAT('[',if(claveFolioCarpetas is null,'',claveFolioCarpetas),'] ',nombreUnidad) FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
		else
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
	
		
		$nombreUnidadGestion=$con->obtenerValor($consulta);
		
		if($fDatosEvento["idSala"]=="")
			$fDatosEvento["idSala"]=-1;
		$consulta="SELECT CONCAT('[',claveSala,'] ',nombreSala) FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fDatosEvento["idSala"];
		$nombreSala=$con->obtenerValor($consulta);
		
		
		
		$consulta="SELECT CONCAT('[',if(claveAudiencia is null,'',claveAudiencia),'] ',tipoAudiencia) FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fDatosEvento["tipoAudiencia"];
		$tipoAudiencia=$con->obtenerValor($consulta);
		
		if($fDatosEvento["otroTipoAudiencia"]!="")
			$tipoAudiencia.=": ".$fDatosEvento["otroTipoAudiencia"];
			
		$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	
		$fContenidos=$con->obtenerPrimeraFila($consulta);
		
		$carpetaJudicial=$fContenidos[0];
		
		$consulta="SELECT carpetaAdministrativa,tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaJudicial."'";
		if($fContenidos[1]!="-1")
		{
			$consulta.=" and idCarpeta=".$fContenidos[1];
		}
		
	
		 $fDatosCarpetaJudicial=$con->obtenerPrimeraFila($consulta);
	
		
		
		$consulta="SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=".$fDatosEvento["situacion"];
		
		$lblSituacion=$con->obtenerValor($consulta);
		
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fDatosEvento["situacion"])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;
	
				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		$requiereResguardo=0;
		$requiereMesaEvidencia=0;
		$requiereTelePresencia=0;
		$requiereTestigoProtegido=0;
		$idAuxiliar=-1;
		$idEtapaSolicitud=0;
		switch($fDatosEvento["idFormulario"])
		{
			case 46:
			case 185:
			
				$consulta="select * from _".$fDatosEvento["idFormulario"]."_tablaDinamica WHERE id__".$fDatosEvento["idFormulario"]."_tablaDinamica=".$fDatosEvento["idRegistroSolicitud"];
				$fDatosSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				$idEtapaSolicitud=$fDatosSolicitud["idEstado"];
				$requiereResguardo=(!isset($fDatosSolicitud["requiereResguardo"]) || ($fDatosSolicitud["requiereResguardo"]!=1))?0:1;
				$requiereMesaEvidencia=(!isset($fDatosSolicitud["requiereMesaEvidencia"]) || ($fDatosSolicitud["requiereMesaEvidencia"]!=1))?0:1;
				$requiereTelePresencia=(!isset($fDatosSolicitud["requiereTelePresencia"]) || ($fDatosSolicitud["requiereTelePresencia"]!=1))?0:1;
				$requiereTestigoProtegido=(!isset($fDatosSolicitud["requiereTestigoProtegido"]) || ($fDatosSolicitud["requiereTestigoProtegido"]!=1))?0:1;
			
			
				$consulta="SELECT idAuxiliarSala FROM  3007_auxiliarSalaEvento WHERE idFormulario=".$fDatosEvento["idFormulario"].
							" AND idReferencia=".$fDatosEvento["idRegistroSolicitud"];
				$idAuxiliar=$con->obtenerValor($consulta);
				if($idAuxiliar=="")
					$idAuxiliar=-1;
			
			break;
		}
		
		$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$idAuxiliar;
		$nombre=$con->obtenerValor($consulta);
		
		
		$arrRecursosAdicionalesRequeridos="";
		
		if($con->existeTabla("7001_recursosAdicionalesAudiencia"))
		{
			$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fDatosEvento["idRegistroEvento"]." AND situacionRecurso IN
						(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
				
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fila["tipoRecurso"];
				$tipoRecurso=$con->obtenerValor($consulta);
				$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fila["idRecurso"];
				$nombreRecurso=$con->obtenerValor($consulta);
				$oRecurso='{"tipoRecurso":"'.cv($tipoRecurso).'","nombreRecurso":"'.cv($nombreRecurso).'"}';
				if($arrRecursosAdicionalesRequeridos=="")
					$arrRecursosAdicionalesRequeridos=$oRecurso;
				else
					$arrRecursosAdicionalesRequeridos.=",".$oRecurso;
			}
		}
		$objRequerimiento='{"requiereResguardo":"'.$requiereResguardo.'","requiereMesaEvidencia":"'.$requiereMesaEvidencia.
							'","requiereTelePresencia":"'.$requiereTelePresencia.'","requiereTestigoProtegido":"'.$requiereTestigoProtegido.'"}';
		
		
		
		
		
		$consulta="SELECT COUNT(*) FROM _1060_gRolesRestriccion WHERE concat(rol,'_0') in(".$_SESSION["idRol"].")";
		$existeRestriccion=$con->obtenerValor($consulta);
	
		$arrRestricciones=array();
		$consulta="SELECT idOpcion FROM _1060_chkInformacionRestringida";
		$res=$con->obtenerFilas($consulta);
		while($filaRestringida=$con->fetchAssoc($res))
		{
			$arrRestricciones[$filaRestringida["idOpcion"]]=1;
		}
		
		$leyendaReservado="(Reservado)";
		$reservadoParticipantes=false;
		$juecesReservado=false;
		$duracionReservada=0;
		$fechaRestringida=0;
		$horarioRestringido=0;
		if($existeRestriccion)
		{
			if(isset($arrRestricciones[1]))
			{
				$carpetaJudicial=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[2]))
			{
				$reservadoParticipantes=true;
			}
			
			
			if(isset($arrRestricciones[3]))
			{
					
				$fDatosEvento["nombreEvento"]=$leyendaReservado;	
					
			}
			
			if(isset($arrRestricciones[4]))
			{
				$fDatosEvento["descripcionEvento"]=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[5]))
			{
				$fechaRestringida=1;
			}
			
			if(isset($arrRestricciones[6]))
			{
				$horarioRestringido=1;
			}
			
			if(isset($arrRestricciones[7]))
			{
				$tipoAudiencia=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[8]))
			{
				$duracionReservada=1;
			}
			
			if(isset($arrRestricciones[9]))
			{
				$nombreSala=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[10]))
			{
				$nombreUnidadGestion=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[11]))
			{
				$nombreInmueble=$leyendaReservado;
			}
			
			if(isset($arrRestricciones[12]))
			{
				$juecesReservado=true;
			}
			
			
		}
		
		
		$arrJueces="";
		$consulta="SELECT idRegistroEventoJuez,idJuez,tipoJuez,titulo,noJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
		$resJueces=$con->obtenerFilas($consulta);
		while($fJueces=$con->fetchRow($resJueces))
		{
			$nombreJuez="[".$fJueces[4]."] ".obtenerNombreUsuario($fJueces[1]);
			
			$oJueces='{"idRegistroEventoJuez":"'.$fJueces[0].'","idJuez":"'.$fJueces[1].'","tipoJuez":"'.$fJueces[2].'","titulo":"'.cv($fJueces[3]).'","nombreJuez":"'.cv($juecesReservado?$leyendaReservado:$nombreJuez).'"}';
			if($arrJueces=="")
				$arrJueces=$oJueces;
			else
				$arrJueces.=",".$oJueces;
		}
		
		$arrParticipantes="";
		$consulta="SELECT * FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=".$fDatosEvento["idRegistroEvento"]." ORDER BY nombrePersona";
		$rParticipantes=$con->obtenerFilas($consulta);
		while($fParticipante=$con->fetchAssoc($rParticipantes))
		{
			$oParticipante='{"idParticipante":"'.$fParticipante["idRegistro"].'","nombre":"'.cv(!$reservadoParticipantes?$fParticipante["nombrePersona"]:$leyendaReservado).'"}';
			if($arrParticipantes=="")
				$arrParticipantes=$oParticipante;
			else
				$arrParticipantes.=",".$oParticipante;
		}
		
		$cadObj='{"idCarpeta":"'.($fContenidos[1]==""?-1:$fContenidos[1]).'","carpetaJudicial":"'.$carpetaJudicial.'","tipoCarpeta":"'.$fDatosCarpetaJudicial[1].
				'","idTipoAudiencia":"'.$fDatosEvento["tipoAudiencia"].'","tipoAudiencia":"'.$tipoAudiencia.'","fechaEvento":"'.$fDatosEvento["fechaEvento"].'","horaInicio":"'.
				$fDatosEvento["horaInicioEvento"].'","horaFin":"'.$fDatosEvento["horaFinEvento"].
				'","horaInicioReal":"'.$fDatosEvento["horaInicioReal"].'","horaFinReal":"'.$fDatosEvento["horaTerminoReal"].'","urlMultimedia":"'.$fDatosEvento["urlMultimedia"].
				'","idEdificio":"'.$fDatosEvento["idEdificio"].'","edificio":"'.cv($nombreInmueble).'","idUnidadGestion":"'.$fDatosEvento["idCentroGestion"].
				'","unidadGestion":"'.cv($nombreUnidadGestion).'","idSala":"'.$fDatosEvento["idSala"].'","sala":"'.cv($nombreSala).'","jueces":['.$arrJueces.
				'],"situacion":"'.$fDatosEvento["situacion"].'","lblSituacion":"'.cv($lblSituacion).'","idEvento":"'.$idEvento.'",
				"iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'","requerimientosEspeciales":'.
				$objRequerimiento.',"idAuxiliarSala":"'.$idAuxiliar.'","lblNombreAuxiliarSala":"'.cv($nombre).'","idEtapaSolicitud":"'.
				$idEtapaSolicitud.'","arrRecursosAdicionalesRequeridos":['.$arrRecursosAdicionalesRequeridos.'],"nombreEvento":"'.cv($fDatosEvento["nombreEvento"]).
				'","descripcionEvento":"'.cv($fDatosEvento["descripcionEvento"]).'","arrParticipantes":['.$arrParticipantes.']
				,"duracionReservada":"'.$duracionReservada.'","fechaRestringida":"'.$fechaRestringida.'","horarioRestringido":"'.$horarioRestringido.'"}';
		
		echo "1|".$cadObj;
		
	}
	
	
	function obtenerEventosAudienciaSGJ()
	{
		global $con;
		
		$considerarConRecursos="";
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
		
		$idParticipante=$_POST["idParticipante"];
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$idActividad=-1;
		
		$arrRegistros="";//carpetaAdministrativa
		
		$consulta="";
		
		$consulta="SELECT distinct e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,e.situacion,
					idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
					horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
					FROM 7000_eventosAudiencia e,7000_participantesEventoAudiencia p,7005_relacionFigurasJuridicasSolicitud r 
					where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
					and horaInicioEvento is not null and horaFinEvento is not null
					".$condiciones." and p.idRegistroEvento=e.idRegistroEvento and p.idPersona=r.idParticipante 
					and r.idCuentaAcceso=".$idParticipante;		
		
		
		/*if($uG!="0")		
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad in('".$uG."')";
			$iUnidad=$con->obtenerListaValores(str_replace("''","'",$query));
			$consulta.=" and idCentroGestion in(".$iUnidad.")";
		}
		else
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
			$iUnidad=$con->obtenerListaValores($query);
			$consulta.=" and idCentroGestion in(".$iUnidad.")";
		}*/
	
		if(isset($_POST["iEdificio"]))
		{
			$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
		}
		
		$consulta.=" order by horaInicioEvento";
		
		
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
	
			$query="SELECT GROUP_CONCAT(CONCAT('(',if(noJuez is null,'',noJuez),') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
						7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		
			$jueces=$con->obtenerValor($query);
			
			if($juez!="")
			{
				if(stripos($jueces,$juez)===false)
				{
					continue;
				}
			}
			
			$carpeta="";
			$tipoAudiencia=$fila[8];
			$tAudiencia="";
			$carpetaInvestigacion="";
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
			
			$fDatos=$con->obtenerPrimeraFila($consulta);
			
			$carpetaAdministrativa=$fDatos[0];
			
			
			$iFormularioSituacion=-1;
			$iRegistroSituacion=-1;
			
			switch($fila[4])
			{
				case "2"://Finalizada
					$iFormularioSituacion=321;
					$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;
				break;
				case "6"://Resuelta por acuerdo
					$iFormularioSituacion=322;
	
					$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;
				break;
				case "9"://Cancelado
				case "3"://Cancelado
					$iFormularioSituacion=323;
					$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
					$iRegistroSituacion=$con->obtenerValor($consulta);
					if($iRegistroSituacion=="")
						$iRegistroSituacion=-1;	
				break;
			}
			
			
			
	
	
			$canal="";
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
			
			
			$imputado=$con->obtenerListaValores($consulta);
			
			$tImputados=$con->filasAfectadas;
			
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A')";
			
			
			$victima=$con->obtenerListaValores($consulta);
			
			
			
			
			$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
			$perfilSala=$con->obtenerValor($consulta);
			
			$participantesConfirmados=0;
			
			$arrEstadoConsideraReunon[1]=1;
			$arrEstadoConsideraReunon[2]=1;
			$arrEstadoConsideraReunon[4]=1;
			$arrEstadoConsideraReunon[5]=1;
			
			
			$urlVideoConferencia="";
			if(isset($arrEstadoConsideraReunon[$fila[4]]))
			{
				$consulta="SELECT valorComplementario3 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento=".$fila[0]." AND tipoAccion=10 AND notificado=1";
				
				
				$urlVideoConferencia=$con->obtenerValor($consulta);
			}
			
			$o='{"urlCanal":"'.$canal.'","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpetaAdministrativa.'","fechaEvento":"'.$fila[1].
				'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
				"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
				'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
				'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
				'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
				"notificacionMAJO":"","mensajeMAJO":"","delitos":"","edificio":"'.$fila[14].'","carpetaInvestigacion":"","imputado":"'.cv($imputado).
				'","victima":"'.cv($victima).'","notificacionCabina":"","recursosAdicionales":"","mensajeCabina":"","conRecursosAdicionales":"","audienciaVirtual":"'.((($perfilSala==3)||($perfilSala==4))?1:0).
				'","participantesConfirmados":"","urlAudiencia":"","urlVideoConferencia":"'.$urlVideoConferencia.'"}';
			
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerResultadosBusquedaAudiencia()
	{
		global $con;
		
		$criterioBusqueda=$_POST["criterioBusqueda"];
		$obj=json_decode($criterioBusqueda);
		$condWhere=" where 1=1 ";
		$condWhereArchivo="";
		
		switch($obj->tipoVista)
		{
			case 1: //Juez
				$condWhereArchivo.=" and eJ.idJuez=".$obj->idReferencia;
			break;
			case 2: //Despacho
				$condWhere.=" and despachoAsignado='".$obj->idReferencia."'";

			break;
			case 3: //Usuario//4089
				$condWhereArchivo.=" and e.idRegistroEvento in(SELECT DISTINCT idRegistroEvento FROM 7000_participantesEventoAudiencia p,
									7005_relacionFigurasJuridicasSolicitud r 
										WHERE r.idCuentaAcceso=".$obj->idReferencia." and  r.idParticipante=p.idPersona )";
			break;
		}
		
		//$condWhere="where (responsable=".$_SESSION["idUsr"]." or carpetaAdministrativa in(SELECT carpetaAdministrativa FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"]."))";
		
		
		if($obj->depacho!='')
		{
			$condWhere.=" and despachoAsignado='".$obj->depacho."'";
		}
		
		if($obj->especialidad!='')
		{
			$condWhere.=" and especialidad=".$obj->especialidad;
		}
		
		if($obj->tipoProceso!='')
		{
			$condWhere.=" and tipoProceso=".$obj->tipoProceso;
		}
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT distinct carpetaAdministrativa FROM _632_tablaDinamica  ".$condWhere;

		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;

		$condWhereArchivo.=" and con.carpetaAdministrativa IN(".$listaCarpetas.")";
		
		
		
		
		if($obj->fechaInicioRegistro!='')
		{
			$condWhereArchivo.=" and e.fechaEvento".$obj->condFInicioFiltro."'".$obj->fechaInicioRegistro."'";
		}
		
		if($obj->fechaFinRegistro!='')
		{
			$condWhereArchivo.=" and e.fechaEvento".$obj->condFFinFiltro."'".$obj->fechaFinRegistro."'";
		}			
			
			
			
			
		if($obj->nombreEvento!='')
		{
			$condWhereArchivo.=" and e.nombreEvento like '".cv($obj->nombreEvento)."'";
		}	
		
		if($obj->situacionAudiencia!='')
		{
			$condWhereArchivo.=" and e.situacion=".$obj->situacionAudiencia;
		}	
		
		if($obj->nombreParticipante!='')
		{
			$condWhereArchivo.=" and e.idRegistroEvento IN(SELECT idRegistroEvento FROM 7000_participantesEventoAudiencia 
								WHERE nombrePersona LIKE '%".$obj->nombreParticipante."%')";
		}	
			
		  
    
			
		
		$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,e.situacion,
				(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) AS sede,
				(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=e.idCentroGestion) AS despacho,
				(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=idSala) AS sala,
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) AS tipoAudiencia,
				con.carpetaAdministrativa,
				u.Nombre AS juez,
				(SELECT GROUP_CONCAT(nombrePersona SEPARATOR '<br>') FROM 7000_participantesEventoAudiencia WHERE idRegistroEvento=e.idRegistroEvento) AS participantes,
				nombreEvento,descripcionEvento,horaInicioReal,horaTerminoReal
				FROM 7000_eventosAudiencia  e,7001_eventoAudienciaJuez eJ,800_usuarios u,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c
				WHERE eJ.idRegistroEvento=e.idRegistroEvento AND u.idUsuario=eJ.idJuez AND tipoContenido=3 
				AND idRegistroContenidoReferencia=e.idRegistroEvento AND c.carpetaAdministrativa=con.carpetaAdministrativa
				".$condWhereArchivo;

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$o='{"idRegistroEvento":"'.$fila["idRegistroEvento"].'","fechaEvento":"'.$fila["fechaEvento"].'","horaInicioEvento":"'.$fila["horaInicioEvento"].
				'","horaFinEvento":"'.$fila["horaFinEvento"].'","situacion":"'.$fila["situacion"].'","sede":"'.cv($fila["sede"]).'","despacho":"'.cv($fila["despacho"]).
				'","sala":"'.cv($fila["sala"]).'","tipoAudiencia":"'.cv($fila["tipoAudiencia"]).'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].
				'","juez":"'.cv($fila["carpetaAdministrativa"]).'","participantes":"'.cv($fila["participantes"]).'","horaInicioRealEvento":"'.$fila["horaInicioReal"].
				'","horaFinRealEvento":"'.$fila["horaTerminoReal"].'","nombreEvento":"'.cv($fila["nombreEvento"]).'","descripcionEvento":"'.cv($fila["descripcionEvento"]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerInfoCodigoProcesoUnicoApelacion($cupj="",$idFormulario=0)
	{
		global $con;
		if(isset($_POST["cupj"]))
			$cupj=$_POST["cupj"];
		
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
			
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	
		if($fRegistro["tipoCarpetaAdministrativa"]==3)
		{
			
			obtenerInfoCodigoProcesoUnicoCasacionSentencia($cupj);
			return;
		}
			
		$arrCarpetas=array();
		obtenerCarpetasPadre($cupj,$arrCarpetas);
		if(sizeof($arrCarpetas)==0)
		{
			array_push($arrCarpetas,$cupj);
		}
		

		
		$carpetaBase=$arrCarpetas[0];	
			
		
		
		
		
		if($idFormulario!=0)
		{
			switch($idFormulario)
			{
				case 682:
					$cupj=$carpetaBase;
				break;
			}
		}
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM _633_tablaDinamica WHERE carpetaAdministrativa='".$cupj."'";
		$fApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		
		$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
		$despacho=$con->obtenerValor($consulta);
		
		
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
		
		
		
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=2 ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}
		
		
		
		$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 908_archivos a,9074_documentosRegistrosProceso d WHERE 
					a.idArchivo=d.idDocumento AND a.categoriaDocumentos=16 AND d.idFormulario=633 AND d.idRegistro=".$fApelacion["id__633_tablaDinamica"];
		$fDocumentoSentencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrNombreArchivo=explode(".",$fDocumentoSentencia["nomArchivoOriginal"]);
		$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
		$extension=mb_strtolower($extension);
		
		$btnDocumento="<a href='javascript:mostrarVisorDocumentoProceso(\\\"".($extension)."\\\",\\\"".($fDocumentoSentencia["idArchivo"])."\\\")'><img src=\'../imagenesDocumentos/16/file_extension_".$extension.".png\'></a>";
		
		$leyenda="	<div style='line-height:21px'><b>T&iacute;tulo del Proceso:</b> ".cv($fRegistroBase["tituloProceso"])."<br>".
					"<b>Especialidad:</b> ".cv($especialidad).", <b>Tipo de Proceso:</b> ".cv($tipoProceso).", <b>Lugar de Radicaci&oacute;n:</b> ".cv($municipio).", ".cv($departamento)."<br>".
					"<b>Demandante: </b> ".cv($demantante)."<br>".
					"<b>Demandados: </b>".cv($demandados)."<br>";
		if($idFormulario==682)
		{
			$leyenda.="<b>Proceso Judicial en Despacho: </b>".cv($cupj)."<br>";
		}
		$leyenda.=	"<b>Depacho: </b>".cv($despacho)."<br>".
					"<b>Resumen de Sentencia: </b>".$btnDocumento."<br><br><div style=\'width:800px; height:130px; overflow: scroll;\'>".cv($fApelacion["resumenSentencia"])."</div></b><br>".
					"<b>Fecha de Sentencia: </b>".date("d/m/Y",strtotime($fApelacion["fechaSentencia"]))."<br>".
					"<b>Fecha de Ejecutoria: </b>".date("d/m/Y",strtotime($fApelacion["fechaEjecutorio"]))."<br></div>";
					
		
		
		
		$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			cv($tipoProceso).'","tituloProceso":"'.cv($fRegistroBase["tituloProceso"]).'","demandantes":"'.cv($demantante).
			'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			'","leyenda":"'.$leyenda.'","idDocumentoSentencia":"'.$fDocumentoSentencia["idArchivo"].'","nombreDocumento":"'.$fDocumentoSentencia["nomArchivoOriginal"].'"}';
		
		echo "1|".$obj;
		
		
			
	}
	
	function obtenerInfoCodigoProcesoUnicoCasacion()
	{
		global $con;
		$cupj=$_POST["cupj"];
		
		$arrCarpetas=array();
		obtenerCarpetasPadre($cupj,$arrCarpetas);
		if(sizeof($arrCarpetas)==0)
		{
			array_push($arrCarpetas,$cupj);
		}
		

		$carpetaBase=$arrCarpetas[0];	
			
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM _682_tablaDinamica WHERE carpetaAdministrativa='".$cupj."'";
		$fApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["unidadGestion"]."'";
		$despacho=$con->obtenerValor($consulta);
		
		
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
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=2 ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}
		
		$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$arrCarpetas[0]."'";
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 908_archivos a,9074_documentosRegistrosProceso d WHERE 
					a.idArchivo=d.idDocumento AND a.categoriaDocumentos=16 AND d.idFormulario=682 AND d.idRegistro=".$fApelacion["id__682_tablaDinamica"];
		$fDocumentoSentencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrNombreArchivo=explode(".",$fDocumentoSentencia["nomArchivoOriginal"]);
		$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
		$extension=mb_strtolower($extension);
		
		$lblSentidoSentencia="";
		
		
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=10854 AND valor=".$fApelacion["sentidoSentencia"];
		$lblSentidoSentencia=$con->obtenerValor($consulta);
		
		$btnDocumento="<a href='javascript:mostrarVisorDocumentoProceso(\\\"".($extension)."\\\",\\\"".($fDocumentoSentencia["idArchivo"])."\\\")'><img src=\'../imagenesDocumentos/16/file_extension_".$extension.".png\'></a>";
		
		$leyenda="	<div style='line-height:21px'><b>T&iacute;tulo del Proceso:</b> ".cv($fRegistroBase["tituloProceso"])."<br>".
					"<b>Especialidad:</b> ".cv($especialidad).", <b>Tipo de Proceso:</b> ".cv($tipoProceso).", <b>Lugar de Radicaci&oacute;n:</b> ".cv($municipio).", ".cv($departamento)."<br>".
					"<b>Demandante: </b> ".cv($demantante)."<br>".
					"<b>Demandados: </b>".cv($demandados)."<br>".
					"<b>Depacho en Tribunal Superior: </b>".cv($despacho)."<br>".
					"<b>Sentido de Sentencia: </b>".cv($lblSentidoSentencia)."<br>".
					"<b>Resumen de Sentencia: </b>".$btnDocumento."<br><br><div style=\'width:800px; height:160px; overflow: scroll;\'>".cv($fApelacion["resumenSentencia"])."</div></b><br>".
					"<b>Fecha de Sentencia: </b>".date("d/m/Y",strtotime($fApelacion["fechaSentencia"]))."<br></div>";
					
		
		
		
		$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			cv($tipoProceso).'","tituloProceso":"'.cv($fRegistroBase["tituloProceso"]).'","demandantes":"'.cv($demantante).
			'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			'","leyenda":"'.$leyenda.'","idDocumentoSentencia":"'.$fDocumentoSentencia["idArchivo"].'","nombreDocumento":"'.$fDocumentoSentencia["nomArchivoOriginal"].'"}';
		
		echo "1|".$obj;
		
		
			
	}
	
	function obtenerInfoCodigoProcesoUnicoCasacionSentencia($cupj="")
	{
		global $con;
		if(isset($_POST["cupj"]))
			$cupj=$_POST["cupj"];
		
			
			
		$arrCarpetas=array();
		obtenerCarpetasPadre($cupj,$arrCarpetas);
		if(sizeof($arrCarpetas)==0)
		{
			array_push($arrCarpetas,$cupj);
		}
		

		
		$carpetaBase=$arrCarpetas[0];	
			
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativaBase"]."'";
		
		
		$fRegistroTS=$con->obtenerPrimeraFilaAsoc($consulta);

		
		$consulta="SELECT * FROM _682_tablaDinamica WHERE carpetaAdministrativa='".$fRegistroTS["carpetaAdministrativa"]."'";
		$fApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistroTS["unidadGestion"]."'";
		$despacho=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".$fRegistroTS["especialidad"];
		$especialidad=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistroTS["claseProceso"];
		$claseProceso=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreSubclaseProceso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fRegistroTS["subclaseProceso"];
		$subClaseProceso=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreTema FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRegistroTS["tema"];
		$tema=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreSubtema FROM _629_tablaDinamica WHERE id__629_tablaDinamica=".$fRegistroTS["subtema"];
		$subTemaProceso=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistroTS["tipoProceso"];
		$tipoProceso=$con->obtenerValor($consulta);
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=2 ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}
		
		$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$carpetaBase."'";
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);

		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistroBase["departamento"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistroBase["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 908_archivos a,9074_documentosRegistrosProceso d WHERE 
					a.idArchivo=d.idDocumento AND a.categoriaDocumentos=16 AND d.idFormulario=682 AND d.idRegistro=".$fApelacion["id__682_tablaDinamica"];
		$fDocumentoSentencia=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrNombreArchivo=explode(".",$fDocumentoSentencia["nomArchivoOriginal"]);
		$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
		$extension=mb_strtolower($extension);
		
		$lblSentidoSentencia="";
		
		
		$consulta="SELECT nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=38 AND claveElemento=".$fApelacion["sentidoSentencia"];
		$lblSentidoSentencia=$con->obtenerValor($consulta);
		
		$btnDocumento="<a href='javascript:mostrarVisorDocumentoProceso(\\\"".($extension)."\\\",\\\"".($fDocumentoSentencia["idArchivo"])."\\\")'><img src=\'../imagenesDocumentos/16/file_extension_".$extension.".png\'></a>";
		
		$leyenda="	<div style='line-height:21px'><b>T&iacute;tulo del Proceso:</b> ".cv($fRegistroBase["tituloProceso"])."<br>".
					"<b>Especialidad:</b> ".cv($especialidad).", <b>Tipo de Proceso:</b> ".cv($tipoProceso).", <b>Lugar de Radicaci&oacute;n:</b> ".cv($municipio).", ".cv($departamento)."<br>".
					"<b>Demandante: </b> ".cv($demantante)."<br>".
					"<b>Demandados: </b>".cv($demandados)."<br>".
					"<b>Proceso Judicial en Tribunal Superior: </b>".cv($fRegistro["carpetaAdministrativaBase"])."<br>".
					"<b>Depacho en Tribunal Superior: </b>".cv($despacho)."<br>".
					"<b>Sentido de Sentencia en Tribunal Superior: </b>".cv($lblSentidoSentencia)."<br>".
					"<b>Resumen de Sentencia en Tribunal Superior: </b>".$btnDocumento."<br><br><div style=\'width:800px; height:130px; overflow: scroll;\'>".cv($fApelacion["resumenSentencia"])."</div></b><br>".
					"<b>Fecha de Sentencia en Tribunal Superior: </b>".date("d/m/Y",strtotime($fApelacion["fechaSentencia"]))."<br></div>";
					
		
		
		
		$obj='{"despacho":"'.cv($despacho).'","especialidad":"'.cv($especialidad).'","claseProceso":"'.cv($claseProceso).
				'","subClaseProceso":"'.cv($subClaseProceso).'","tema":"'.cv($tema).'","subTemaProceso":"'.cv($subTemaProceso).'","tipoProceso":"'.
			cv($tipoProceso).'","tituloProceso":"'.cv($fRegistroBase["tituloProceso"]).'","demandantes":"'.cv($demantante).
			'","demandado":"'.cv($demandados).'","departamento":"'.cv($departamento).'","municipio":"'.cv($municipio).
			'","leyenda":"'.$leyenda.'","idDocumentoSentencia":"'.$fDocumentoSentencia["idArchivo"].'","nombreDocumento":"'.$fDocumentoSentencia["nomArchivoOriginal"].'"}';
		
		echo "1|".$obj;
		
		
			
	}
	
	function obtenerInfoCodigoProcesoUnicoCierre()
	{
		global $con;
		$cupj=$_POST["cupj"];
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cupj."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	
		switch($fRegistro["tipoCarpetaAdministrativa"])
		{
			case 1:
				obtenerInfoCodigoProcesoUnico($cupj);
			break;
			case 2:
				obtenerInfoCodigoProcesoUnicoApelacion($cupj,682);
			break;
			case 3:
				obtenerInfoCodigoProcesoUnicoCasacionSentencia($cupj);
			break;
		}
	}
	
	function obtenerAudienciasExpedienteSGJ()
	{
		global $con;
		$exp=$_POST["exp"];
		$arrAudiencias="";
		$totalAudiencias=0;
		
		/*
		consulta="SELECT e.idRegistroEvento AS idEvento,fechaEvento,horaInicioEvento AS horaInicial,horaFinEvento AS horaFinal,
					e.horaInicioReal,e.horaTerminoReal,e.urlMultimedia,e.situacion,e.descripcionEvento AS  comentariosAdicionales,
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica= e.tipoAudiencia) AS tipoAudiencia,
					(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica= e.idSala) AS sala,
					(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica= e.idCentroGestion) AS unidadGestion,
					(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica= e.idEdificio) AS edificio,
					(SELECT GROUP_CONCAT(u.Nombre)  FROM 7001_eventoAudienciaJuez eJ,800_usuarios u WHERE eJ.idRegistroEvento= 
					e.idRegistroEvento AND u.idUsuario=eJ.idJuez) AS juez,con.carpetaAdministrativa
					FROM 7000_eventosAudiencia e,7000_participantesEventoAudiencia p,7005_relacionFigurasJuridicasSolicitud r,7007_contenidosCarpetaAdministrativa con 
					WHERE p.idRegistroEvento=e.idRegistroEvento AND r.idParticipante=p.idPersona AND r.idCuentaAcceso=4146 AND
					con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND con.carpetaAdministrativa='".$exp."' ORDER BY horaInicioEvento";         */
		
		$numReg=0;
		$arrAudiencias="";
		$consulta="SELECT e.idRegistroEvento AS idEvento,fechaEvento,horaInicioEvento AS horaInicial,horaFinEvento AS horaFinal,
					e.horaInicioReal,e.horaTerminoReal,e.urlMultimedia,e.situacion,e.descripcionEvento AS  comentariosAdicionales,
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica= e.tipoAudiencia) AS tipoAudiencia,
					(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica= e.idSala) AS sala,
					(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica= e.idCentroGestion) AS unidadGestion,
					(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica= e.idEdificio) AS edificio,
					(SELECT GROUP_CONCAT(u.Nombre)  FROM 7001_eventoAudienciaJuez eJ,800_usuarios u WHERE eJ.idRegistroEvento= 
					e.idRegistroEvento AND u.idUsuario=eJ.idJuez) AS juez,con.carpetaAdministrativa,
					(
					SELECT urlReunion FROM 7000_participantesEventoAudiencia p,7005_relacionFigurasJuridicasSolicitud r 
					WHERE p.idRegistroEvento=e.idRegistroEvento AND r.idParticipante=p.idPersona AND r.idCuentaAcceso=".$_SESSION["idUsr"]." LIMIT 0,1
					) as urlVideoConferencia
					
					FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con 
					WHERE	con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND con.carpetaAdministrativa='".
					$exp."' ORDER BY horaInicioEvento"; 
		
		$arrAudiencias=utf8_encode($con->obtenerFilasJSON($consulta));				
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrAudiencias.'}';
			
		
		
	}
	
	function obtenerDocumentosCarpetaAdministrativa()
	{
		global $con;
		$carpetaAdministrativa=bD($_POST["cA"]);
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$idCarpetaAdministrativa=-1;
		if(isset($_POST["idCarpetaAdministrativa"]))
			$idCarpetaAdministrativa=$_POST["idCarpetaAdministrativa"];
		
		$compCarpeta=" and idCarpetaAdministrativa in(-1";
		if($idCarpetaAdministrativa!=-1)
		{
			$compCarpeta.=",".$idCarpetaAdministrativa;
		}
		$compCarpeta.=")";
		$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);
	
		$cadCondWhere=str_replace("fechaCreacion"," cast(fechaCreacion as date)",$cadCondWhere);	
		
		$tDocumentos=-1;
		if(isset($_POST["tDocumentos"]))
			$tDocumentos=$_POST["tDocumentos"];
			
			
		$consulta="SELECT count(*) FROM 
						7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
						"' and tipoContenido=1 ".$compCarpeta." order by fechaRegistro";	
	
		$numDocumentos=$con->obtenerValor($consulta);
		
		if($numDocumentos==0)
		{
			$consulta="SELECT carpetaAdministrativa,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE 
					carpetaAdministrativa='".$carpetaAdministrativa."'";
					
			if($idCarpetaAdministrativa!=-1)
			{
				$consulta.=" and idCarpeta=".$idCarpetaAdministrativa;
			}
			
	
			$fCarpeta=$con->obtenerPrimeraFila($consulta);
			if(($fCarpeta)&&($fCarpeta[1]!=-1))
			{
				$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$fCarpeta[1]." AND idRegistro=".$fCarpeta[2];
				
				$rDocumentos=$con->obtenerFilas($query);
				while($fDocumento=$con->fetchRow($rDocumentos))
				{
					registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);	
				}
				
				
				switch($fCarpeta[1])
				{
					case 385:
						$consulta="SELECT 	* FROM _412_tablaDinamica WHERE idReferencia=".$fCarpeta[2];
						$fRegistroComplementario=$con->obtenerPrimeraFilaAsoc($consulta);
						if(($fRegistroComplementario["setencia"]!="")&&($fRegistroComplementario["setencia"]!="-1"))
						{
							
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["setencia"],-1,-1,"",3);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["setencia"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
							
						if(($fRegistroComplementario["auto"]!="")&&($fRegistroComplementario["auto"]!="-1"))
						{
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["auto"],-1,-1,"",3);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["auto"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
						if(($fRegistroComplementario["actaMinima"]!="")&&($fRegistroComplementario["actaMinima"]!="-1"))
						{
							convertirDocumentoUsuarioDocumentoResultadoProceso($fRegistroComplementario["actaMinima"],-1,-1,"",12);
							registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fRegistroComplementario["actaMinima"],$fCarpeta[1],$fCarpeta[2],$idCarpetaAdministrativa);
						}
					break;
				}
				
			}
		}
		
			
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales
					union 
					select 0,'Sin etapa',0 as orden 
					 ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$consulta="SELECT idFormulario,idRegistro,fechaRegistro,idRegistroContenidoReferencia FROM 
						7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0].
						" and tipoContenido=1 ".$compCarpeta." order by fechaRegistro";
	
			$rDocumentos=$con->obtenerFilas($consulta);
			while($fDocumentos=$con->fetchRow($rDocumentos))
			{
				if($fDocumentos[3]=="")
					continue;
				$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fDocumentos[3].($tDocumentos!=-1?" and categoriaDocumentos in(".$tDocumentos.
						") ":"")." and eliminado=0 and ".$cadCondWhere;
				$consulta.=" and categoriaDocumentos not in(53)";
	
				$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
				
				if($fDatosDocumento)
				{
					
					$permiteVisualizacion=existePermisoVisualizacion($fDatosDocumento[0],$carpetaAdministrativa);
					if(!$permiteVisualizacion)
						continue;
					
					$arrNombreOriginal=explode(".",$fDatosDocumento[6]);
					$nomArchivoOriginal="";
					for($x=0;$x<sizeof($arrNombreOriginal);$x++)
					{
						if($x==(sizeof($arrNombreOriginal)-1))
						{
							$nomArchivoOriginal.=".".$arrNombreOriginal[$x];
						}
						else
							if($nomArchivoOriginal=="")
								$nomArchivoOriginal=$arrNombreOriginal[$x];
							else
								$nomArchivoOriginal.="_".$arrNombreOriginal[$x];
					}
					
					$etapaProcesal=$fila[0];
					if(($fDatosDocumento[16]!="")&&($fDatosDocumento[2]==""))
					{
						$nomArchivoOriginal="En espera de digitalizaci&oacute;n";
						$etapaProcesal=-1000;
					}
					
					$subidorPor="";
					if($fDatosDocumento[3]==2390)
						$subidorPor="PGJ";
					else
						$subidorPor="Unidad de Gesti&oacute;n";
					
					$o='{"fechaRegistro":"'.date("Y-m-d",strtotime($fDocumentos[2])).'","idDocumento":"'.$fDatosDocumento[0].'","etapaProcesal":"'.$etapaProcesal.'","nomArchivoOriginal":"'.cv($nomArchivoOriginal).'","tamano":"'.$fDatosDocumento[8].
						'","fechaCreacion":"'.$fDatosDocumento[2].'","descripcion":"'.cv($fDatosDocumento[11]).'","categoriaDocumentos":"'.$fDatosDocumento[12].
						'","idFormulario":"'.$fDocumentos[0].'","idRegistro":"'.$fDocumentos[1].'","subidorPor":"'.$subidorPor.'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				
					$numReg++;	
				}
			}		
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function obtenerInfoMetadataProceso()
	{
		global $con;
		$carpetaAdministrativa=bD($_POST["cA"]);
		$tipoCarpeta=$_POST["tipoCarpeta"];
		$idCarpeta=-1;
		if(isset($_POST["idCarpeta"]))
			$idCarpeta=$_POST["idCarpeta"];	
		
		$cBase="";
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpeta!=-1)
		{
			$consulta.=" and idCarpeta=".$idCarpeta;
		}
		
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if($tipoCarpeta==11)
		{
			$idCarpetaBase="";
			if($fRegistro["idCarpetaAdministrativaBase"]==-1)
			{
				$consulta="SELECT idCarpetaBase FROM 7006_carpetasAdministrativasRelacionadas WHERE idCarpeta=".$idCarpeta;
				$idCarpetaBase=$con->obtenerValor($consulta);
			}
			else
			{
				$idCarpetaBase=$fRegistro["idCarpetaAdministrativaBase"];
				
			}
			
			$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idCarpetaBase;
			$cBase=$con->obtenerValor($consulta);
			
		}
		else
		{
			
			$cBase=obtenerCarpetaBaseOriginal($carpetaAdministrativa);		
		}
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cBase."'";
		$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);

		
		
		if($tipoCarpeta==11)
		{
			$arrCamposBase["especialidad"]="";
			$arrCamposBase["tipoProceso"]="";
			$arrCamposBase["claseProceso"]="";
			$arrCamposBase["subclaseProceso"]="";
			$arrCamposBase["tema"]="";
			$arrCamposBase["subtema"]="";
			$arrCamposBase["idTRD"]="";
			$arrCamposBase["version"]="";
			$arrCamposBase["serie"]="";
			$arrCamposBase["subserie"]="";
			$arrCamposBase["idActividad"]="";
			foreach($arrCamposBase as $campo=>$valor)
			{
				$fRegistro[$campo]=$fCarpetaBase[$campo];
			}
		}
		
		
		$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
		$tipoProceso=$con->obtenerValor($consulta);
		
		$idFiguraActor=2;
		$idFiguraDemandado=4;

		
		if($fRegistro["tipoProceso"]==6)
		{
			$idFiguraActor=7;
			$idFiguraDemandado=8;
		}

		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(select id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
		
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
					AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(select id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demandados=="")
				$demandados=$nombre;
			else
				$demandados.=", ".$nombre;
		}


		$consulta="SELECT nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta=".$fRegistro["tipoCarpetaAdministrativa"];
		$tipoCarpetaAdministrativa=$con->obtenerValor($consulta);
		$consulta="SELECT descripcion FROM 7014_situacionCarpetaAdministrativa WHERE idRegistro=".$fRegistro["situacion"];
		$situacionActual=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM _".$fCarpetaBase["idFormulario"]."_tablaDinamica WHERE id__".$fCarpetaBase["idFormulario"]."_tablaDinamica= ".$fCarpetaBase["idRegistro"];
		$fRegsitroInicial=$con->obtenerPrimeraFilaAsoc($consulta);
		

		$numReg=0;
		$arrRegistros="";
		
		if($tipoCarpeta==11)
		{
			$o='{"idMeta":"6","metaData":"Fecha de Registro","valor":"'.cv(date("d/m/Y H:i",strtotime($fRegistro["fechaCreacion"]))).' hrs."}';//
			$arrRegistros=$o;
			$numReg++;
			$o='{"idMeta":"7","metaData":"Tipo de Expediente","valor":"Cuadernillo"}';
			$arrRegistros.=",".$o;
			$numReg++;
			
			$arrDatos=array();
			if($fRegistro["idTRD"]=="")
			{
				$arrDatos=obtenerTRDExpediente($fRegistro["unidadGestion"],$fRegistro["fechaCreacion"],$fRegistro["tipoProceso"]);
				if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
				{
					$consulta="UPDATE 7006_carpetasAdministrativas SET idTRD=".$arrDatos["idTablaRetencion"].",VERSION=".$arrDatos["version"].
						",serie=".$arrDatos["idSerie"].",subserie=".$arrDatos["idSubserie"]." WHERE idCarpeta=".$fila["idCarpeta"];
			
					$con->ejecutarConsulta($consulta);
				}
				$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
			}
	
			$nombreTRD="";
			$versionTRD=$fRegistro["version"];
			$serie="";
			$subserie="";
			
			
			$consulta="SELECT nombreTabla FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".($fRegistro["idTRD"]==""?-1:$fRegistro["idTRD"]);
			$nombreTRD=$con->obtenerValor($consulta);
			if($nombreTRD=="")
				$nombreTRD="----";
			
			
	
			$consulta="SELECT tituloElemento FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$fRegistro["serie"];
			$serie=$con->obtenerValor($consulta);
			if($serie=="")
				$serie="----";
			
			
			$consulta="SELECT tituloElemento FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$fRegistro["subserie"];
			$subserie=$con->obtenerValor($consulta);
			if($subserie=="")
				$subserie="----";
	
			$o='{"idMeta":"12","metaData":"TRD","valor":"'.cv($nombreTRD).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			
			$o='{"idMeta":"13","metaData":"Versi&oacute;n","valor":"'.cv($versionTRD==""?"----":$versionTRD).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
	
			$o='{"idMeta":"14","metaData":"Serie","valor":"'.cv($serie).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			
			$o='{"idMeta":"15","metaData":"Subserie","valor":"'.cv($subserie).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
		}
		else
		{
			$o='{"idMeta":"1","metaData":"Tipo de Proceso","valor":"'.cv($tipoProceso).'"}';
			$arrRegistros=$o;
			$numReg++;
			if($fRegistro["tipoProceso"]!=6)
			{
				if(isset($fRegsitroInicial["tituloProceso"]))
				{
					$o='{"idMeta":"2","metaData":"T&iacute;tulo del Proceso","valor":"'.cv($fRegsitroInicial["tituloProceso"]).'"}';
					$arrRegistros.=",".$o;
					$numReg++;
				}
				if(isset($fRegsitroInicial["tituloProceso"]))
				{
				
					$o='{"idMeta":"3","metaData":"Cuant&iacute;a","valor":"$ '.cv(number_format($fRegsitroInicial["cuantiaProceso"],2)).'"}';
					$arrRegistros.=",".$o;
					$numReg++;
				}
				$o='{"idMeta":"4","metaData":"Demandante","valor":"'.cv($demantante).'"}';
				$arrRegistros.=",".$o;
				$numReg++;
				
				$o='{"idMeta":"5","metaData":"Demandado","valor":"'.cv($demandados).'"}';
				$arrRegistros.=",".$o;
				$numReg++;
			}
			else
			{
				$o='{"idMeta":"4","metaData":"Accionante","valor":"'.cv($demantante).'"}';
				$arrRegistros.=",".$o;
				$numReg++;
				
				$o='{"idMeta":"5","metaData":"Accionado","valor":"'.cv($demandados).'"}';
				$arrRegistros.=",".$o;
				$numReg++;
			}
			
			$o='{"idMeta":"6","metaData":"Fecha de Registro","valor":"'.cv(date("d/m/Y H:i",strtotime($fRegistro["fechaCreacion"]))).' hrs."}';//
			$arrRegistros.=",".$o;
			$numReg++;
			$o='{"idMeta":"7","metaData":"Tipo de Expediente","valor":"'.cv($tipoCarpetaAdministrativa).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			if($fRegistro["tipoCarpetaAdministrativa"]==3)
			{
				$o='{"idMeta":"10","metaData":"Tipo de Apelaci&oacute;n","valor":"Apelaci&oacute;n Auto"}';
				$arrRegistros.=",".$o;
				$numReg++;
				$consulta="SELECT a.nomArchivoOriginal FROM _944_tablaDinamica r,908_archivos a WHERE id__944_tablaDinamica=".$fRegistro["idRegistro"]." AND a.idArchivo=r.autoRecurso";
				$nombreAuto=$con->obtenerValor($consulta);
				
				$o='{"idMeta":"11","metaData":"Auto","valor":"'.cv($nombreAuto).'"}';
				$arrRegistros.=",".$o;
				$numReg++;
			}
			$o='{"idMeta":"8","metaData":"Estado Actual","valor":"'.cv($situacionActual).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			$o='{"idMeta":"9","metaData":"Time Line","valor":"<a href=\'javascript:visualizarTimeLine(\"'.bE($cBase).'\")\'>Ver...</a>"}';
			$arrRegistros.=",".$o;
			$numReg++;
	
			
			$arrDatos=array();
			if($fRegistro["idTRD"]=="")
			{
				$arrDatos=obtenerTRDExpediente($fRegistro["unidadGestion"],$fRegistro["fechaCreacion"],$fRegistro["tipoProceso"]);
				if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
				{
					$consulta="UPDATE 7006_carpetasAdministrativas SET idTRD=".$arrDatos["idTablaRetencion"].",VERSION=".$arrDatos["version"].
						",serie=".$arrDatos["idSerie"].",subserie=".$arrDatos["idSubserie"]." WHERE idCarpeta=".$fila["idCarpeta"];
			
					$con->ejecutarConsulta($consulta);
				}
				$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
			}
	
			$nombreTRD="";
			$versionTRD=$fRegistro["version"];
			$serie="";
			$subserie="";
			
			
			$consulta="SELECT nombreTabla FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".($fRegistro["idTRD"]==""?-1:$fRegistro["idTRD"]);
			$nombreTRD=$con->obtenerValor($consulta);
			if($nombreTRD=="")
				$nombreTRD="----";
			
			
	
			$consulta="SELECT tituloElemento FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$fRegistro["serie"];
			$serie=$con->obtenerValor($consulta);
			if($serie=="")
				$serie="----";
			
			
			$consulta="SELECT tituloElemento FROM 908_registrosTablasRetencionDocumental WHERE idRegistro=".$fRegistro["subserie"];
			$subserie=$con->obtenerValor($consulta);
			if($subserie=="")
				$subserie="----";
	
			$o='{"idMeta":"12","metaData":"TRD","valor":"'.cv($nombreTRD).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			
			$o='{"idMeta":"13","metaData":"Versi&oacute;n","valor":"'.cv($versionTRD==""?"----":$versionTRD).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
	
			$o='{"idMeta":"14","metaData":"Serie","valor":"'.cv($serie).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
			
			$o='{"idMeta":"15","metaData":"Subserie","valor":"'.cv($subserie).'"}';
			$arrRegistros.=",".$o;
			$numReg++;
		}
		
		$o='{"idMeta":"100","metaData":"Perfil de acceso","valor":"'.cv($fRegistro["idPerfilAcceso"]).'"}';
		$arrRegistros.=",".$o;
		$numReg++;
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	
	function obtenerIdRegistroAudiencia()
	{
		
		global $con;
		$iA=$_POST["iA"];
		$consulta="SELECT idRegistroSolicitud FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$iA;
		$idRegistroSolicitud=$con->obtenerValor($consulta);
		
		echo "1|".$idRegistroSolicitud;
	}
	
	function obtenerTipoDocumentales()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT idCategoria as idTipoDocumento,nombreCategoria as nombreDocumento FROM 908_categoriasDocumentos WHERE nombreCategoria LIKE '%".$criterio."%' ORDER BY nombreCategoria";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
		
	}
	
	function registrarMetaDataDocumento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->metaDatos as $m)
		{
			if($m->idPropiedad!=0)
			{
				$query="SELECT * FROM 20003_catalogoMetaDatos WHERE idMetaDato=".$m->idPropiedad;
				$fMetaDato=$con->obtenerPrimeraFilaAsoc($query);
				
				$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
								VALUES(".$obj->idDocumento.",'".cv($m->idPropiedad)."','".cv($m->valor)."','".cv($m->valorEtiqueta).
								"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
								"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
								",'".cv($fMetaDato["tagMeta"])."')";
				$x++;
			}
		}
		
		
		$cacheCalculos=NULL;
		
		$query="SELECT idPerfilMetaDatos FROM 908_categoriasDocumentos WHERE idCategoria=".$obj->tipoDocumental;
		$idPerfilMetaDatos=$con->obtenerValor($query);

		$query="SELECT cM.idMetaDato,cM.nombreMetaDato,cM.metodoResolucion,
				cM.tipoDatoEntrada,cM.funcionSistema,cM.tagMeta FROM 20006_metaDatoPerfil m,20003_catalogoMetaDatos cM 
				WHERE idPerfilMetaDato=".$idPerfilMetaDatos." and cM.idMetaDato=m.idMetaDato and cM.metodoResolucion=1";
		$res=$con->obtenerFilas($query);
		while($fMetaDato=$con->fetchAssoc($res))
		{
			$cadParametros='{"idMetaDato":"'.$fMetaDato["idMetaDato"].'","carpetaAdministrativa":"'.$obj->carpetaAdministrativa.
							'","idCarpetaAdministrativa":"'.$obj->idCarpetaAdministrativa.'","idDocumento":"'.$obj->idDocumento.'"}';
			$objParametros=json_decode($cadParametros);
			$resultado=removerComillasLimite(resolverExpresionCalculoPHP($fMetaDato["funcionSistema"],$objParametros,$cacheCalculos));
			
			$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
								VALUES(".$obj->idDocumento.",'".cv($fMetaDato["idMetaDato"])."','".cv($resultado)."','".cv($resultado).
								"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
								"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
								",'".cv($fMetaDato["tagMeta"])."')";
			$x++;
		}
		$consulta[$x]="UPDATE 908_archivos SET categoriaDocumentos=".$obj->tipoDocumental." WHERE idArchivo=".$obj->idDocumento;
		$x++;
		
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
	}
	
	
	function actualizarMetaDataDocumentoPerfil()
	{
		global $con;

		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$query="SELECT * FROM 908_metaDataArchivos WHERE idArchivo=".$obj->idDocumento." AND idMetaDato=".$obj->idMetadato;
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($query);		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$valorOriginal="";
		$fMetaDato["nombreMetaDato"]="Perfil de Acceso";
		if($obj->idMetadato>0)
		{
			$query="SELECT * FROM 20003_catalogoMetaDatos WHERE idMetaDato=".$obj->idMetadato;
			$fMetaDato=$con->obtenerPrimeraFilaAsoc($query);
			if(!$fRegistro)
			{
				$valorOriginal="Sin valor original";
				$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
								VALUES(".$obj->idDocumento.",'".cv($obj->idMetadato)."','".cv($obj->valor)."','".cv($obj->valorEtiqueta).
								"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
								"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
								",'".cv($fMetaDato["tagMeta"])."')";
				$x++;
			}
			else
			{
				$valorOriginal=$fRegistro["valorEtiqueta"];
				$consulta[$x]="UPDATE 908_metaDataArchivos SET valor='".cv($obj->valor)."',valorEtiqueta='".cv($obj->valorEtiqueta).
								"' WHERE idRegistro=".$fRegistro["idRegistro"];
				$x++;
			}
		
		}
		else
		{
			if($obj->idMetadato==-9)
			{
				$consulta[$x]="UPDATE 7007_contenidosCarpetaAdministrativa SET idPerfilAcceso=".$obj->valorEtiqueta." WHERE idContenido=".$obj->idRegistroContenido;
				$x++;
			}
			else
			{
				if($fRegistro)
				{
					$valorOriginal=$fRegistro["valorEtiqueta"];
					$consulta[$x]="UPDATE 908_metaDataArchivos SET valor='".cv($obj->valor)."',valorEtiqueta='".cv($obj->valorEtiqueta).
									"' WHERE idRegistro=".$fRegistro["idRegistro"];
					$x++;
				}
				else
				{
					$valorOriginal="Sin valor original";
					$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
									VALUES(".$obj->idDocumento.",'".cv($obj->idMetadato)."','".cv($obj->valor)."','".cv($obj->valorEtiqueta).
									"','".cv($fMetaDato["nombreMetaDato"])."',NULL,NULL,-1,'')";
					$x++;
				}
			}
			
			
			
		}
		
		
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
		{
			$query="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$obj->idDocumento;
			$nomArchivoOriginal=$con->obtenerValor($query);
			$comentariosAdicionales="Modificación del metadato \"".$fMetaDato["nombreMetaDato"]."\" del archivo \"".$nomArchivoOriginal.
								"\". Valor original: ".$valorOriginal."; Nuevo valor: ".$obj->valorEtiqueta;
			guardarRegistroBitacoraSistema("Modificación de información de metadato",$obj->idDocumento,17,$comentariosAdicionales);
			echo "1|";
		}
	}
	
	
	function  actualizarPerfilAccesoExpediente()
	{
		global $con;

		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET idPerfilAcceso=".$obj->perfilAcceso." WHERE carpetaAdministrativa='".cv($obj->carpetaAdministrativa)."'";
		if($obj->idCarpetaAdministrativa!=-1)
			$consulta[$x].=" and idCarpeta=".$obj->idCarpetaAdministrativa;
		
		$x++;
		
		if($obj->modificarPerfilContenido==1)
		{
			$consulta[$x]="UPDATE 7007_contenidosCarpetaAdministrativa SET idPerfilAcceso=".$obj->perfilAcceso.
						" WHERE carpetaAdministrativa='".cv($obj->carpetaAdministrativa)."'";
			if($obj->idCarpetaAdministrativa!=-1)			
				$consulta[$x].=" AND idCarpetaAdministrativa=".$obj->idCarpetaAdministrativa;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function buscarIdentificacionRegistroUsuario()
	{
		global $con;
		$tIdentificacion=$_POST["tIdentificacion"];
		$noIdentificacion=$_POST["noIdentificacion"];
		$idUsuario=isset($_POST["iU"])?$_POST["iU"]:-1;
		
		//$consulta="SELECT COUNT(*) FROM _47_tablaDinamica WHERE tipoIdentificacion=".$tIdentificacion." AND folioIdentificacion='".cv($noIdentificacion)."'";
		$consulta="SELECT COUNT(*) FROM 802_identifica WHERE tipoIdentificacion=".$tIdentificacion.
				" AND noIdentificacion='".cv($noIdentificacion)."' and idUsuario<>".$idUsuario;
		
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
			echo "3|";
		else
			echo "1|";
	}
	
	function existeMailRegistroUsuario()
	{
		global $con;
		$mail=$_POST["mail"];
		$consulta="select idMail from 805_mails where Mail='".$mail."'";
		$filaMail=$con->obtenerPrimeraFila($consulta);
		if($filaMail)
			echo "2|";
		else
			echo "1|";
	}
	
	
	function enviarSMSValidacionCelular($omitirResultado=false)
	{
		global $con;
		$numeroCelular=$_POST["numeroCelular"];
		$numeroConfirmacion=rand(100000,999999);
		$_SESSION["validacionCel"]["numeroCel"]=$numeroCelular;
		$_SESSION["validacionCel"]["numeroConfirmacion"]=$numeroConfirmacion;
		
		$consulta="SELECT codigoTelefono FROM 238_paises WHERE idPais=".$_POST["p"];

		
		$prefijoCelular=$con->obtenerValor($consulta);
		$cuerpoMensaje=$numeroConfirmacion." es el código de validación que debe usar en el registro al sistema de la Rama judicial SIUGJ";
		$resultado=enviarMensajeSMSTwilio($numeroCelular,$cuerpoMensaje,$prefijoCelular,"");

		if($resultado->resultado==1)
		{
			if(!$omitirResultado)
				echo "1|".$numeroConfirmacion;
			
		}
		else
		{
			if($resultado->resultado==4)
			{
				echo "4|";
			}
			else
				echo $resultado->mensajeError;
		}
		
		
		
		
	}
	
	
	function validarSMSValidacionCelular()
	{
		$numeroCelular=$_POST["numeroCelular"];
		$codigo=$_POST["codigo"];

		if(isset($_SESSION["validacionCel"])&&(isset($_SESSION["validacionCel"]["numeroCel"])))
		{
			if(($_SESSION["validacionCel"]["numeroCel"]==$numeroCelular)&& ($_SESSION["validacionCel"]["numeroConfirmacion"]==$codigo))
			{
				echo "1|1";
			}
			else
			{
				echo "1|2";
			}
		}
		else
		{
			enviarSMSValidacionCelular(true);
			echo "1|0";
		}
		
	}
?>