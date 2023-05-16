<?php 
include_once("conexionBD.php");
include_once("utiles.php");


function obtenerMagistradoPresidente($idFormulario,$idRegistro,$actorDestinatario)
{
	global $con;
	global $tipoMateria;
	
	$arrDestinatario=array();
	$rolActor=obtenerTituloRol($actorDestinatario);
	$fechaActual=date("Y-m-d");
	
	$consulta="SELECT nombreMagistrado FROM _588_tablaDinamica WHERE '".$fechaActual."'>=periodoInicio AND '".$fechaActual."'<=periodoFin AND idEstado=2";

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$nombreUsuario=obtenerNombreUsuario($fila[0])." (".$rolActor.")";
		$o='{"idUsuarioDestinatario":"'.$fila[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
		$o=json_decode($o);
		array_push($arrDestinatario,$o);
	}
	
	$nombreUsuario=obtenerNombreUsuario(1)." (".$rolActor.")";
	$o='{"idUsuarioDestinatario":"1","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
	$o=json_decode($o);
	array_push($arrDestinatario,$o);

	return $arrDestinatario;
}


function obtenerMagistradoInstructor($idFormulario,$idRegistro,$actorDestinatario)
{
	global $con;
	global $tipoMateria;
	$arrDestinatario=array();
	$rolActor=obtenerTituloRol($actorDestinatario);

	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
	$consulta="SELECT idJuezTitular FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";

	$idJuezTitular=$con->obtenerValor($consulta);
	$nombreUsuario=obtenerNombreUsuario($idJuezTitular)." (".$rolActor.")";
	$o='{"idUsuarioDestinatario":"'.$idJuezTitular.'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
	$o=json_decode($o);
	array_push($arrDestinatario,$o);
	
	$nombreUsuario=obtenerNombreUsuario(1)." (".$rolActor.")";
	$o='{"idUsuarioDestinatario":"1","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
	$o=json_decode($o);
	array_push($arrDestinatario,$o);

	return $arrDestinatario;
}

function asignarMagistradoInstructorExpediente($idUnidadGestion,$idFormulario,$idRegistro)
{
	global $con;
	$fechaReferencia=date("Y-m-d");
	
	
	$consulta="SELECT idUnidadReferida FROM 7001_asignacionesObjetos WHERE tipoAsignacion='".$idUnidadGestion."' AND tipoRonda='MI' and 
				idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND situacion=1";
	
	$idUnidadReferida=$con->obtenerValor($consulta);
	if($idUnidadReferida!="")
		return $idUnidadReferida; 
	
	$consulta="SELECT usuarioJuez FROM _26_tablaDinamica t,_26_tipoJuez j WHERE idReferencia=".$idUnidadGestion." AND j.idPadre=t.id__26_tablaDinamica
				AND j.idOpcion=5 order by clave";
	$lista=$con->obtenerListaValores($consulta);
	$arrConfiguracion["tipoAsignacion"]=$idUnidadGestion;
	$arrConfiguracion["serieRonda"]="MI";
	$arrConfiguracion["universoAsignacion"]=$lista;
	$arrConfiguracion["idObjetoReferencia"]=-1;
	$arrConfiguracion["pagarDeudasAsignacion"]=false;
	$arrConfiguracion["considerarDeudasMismaRonda"]=false;
	$arrConfiguracion["limitePagoRonda"]=1;
	$arrConfiguracion["escribirAsignacion"]=true;
	$arrConfiguracion["idFormulario"]=$idFormulario;
	$arrConfiguracion["idRegistro"]=$idRegistro;
	$arrConfiguracion["funcValidacionPagoDeuda"]="esJuezDisponibleIncidencia(@idUnidad,'".$fechaReferencia."')";
	$arrConfiguracion["funcValidacionSeleccion"]="";
	$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
	
	

	return $resultado["idUnidad"];
}

function generarFolioCarpetaExpedienteSalaConstitucional($idFormulario,$idRegistro)
{
	global $con;
	
	$anio=date("Y");
	$query="SELECT idActividad,s.codigoInstitucion,carpetaAdministrativa,a.noExpediente,a.anioExpediente,-1,a.numeracionExpediente,
			s.tiposAsuntosRecibidos ,a.noAccion
			FROM _478_tablaDinamica s,_593_tablaDinamica a 
			WHERE a.idReferencia=id__478_tablaDinamica and s.id__478_tablaDinamica =".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFila($query);
	$prefijo="";
	$carpetaAdministrativa=$fRegistro[2];
	
	
	switch($fRegistro[7])
	{
		case 1://Controversia Constitucional
			$prefijo="CC".$fRegistro[8]."/";
		break;
		case 2://Acción de Inconstitucionalidad
			$prefijo="AI".$fRegistro[8]."/";
		break;
		case 3://Acción por Omisión Legislativa
			$prefijo="OL".$fRegistro[8]."/";
		break;
		case 4://Acción de Cumplimiento en Contra de las Personas Titulares de los Poderes Públicos, los Organismos Autónomos y las Alcaldías
			$prefijo="AC".$fRegistro[8]."/";
		break;
		case 5://Impugnación de Resoluciones Definitivas Dictadas por Jueces de Tutela
			$prefijo="";
		break;
		case 6://Impugnación que se Presenta en el Desarrollo del Procedimiento de Referendum para Declarar la Procedencia, Periodicidad y Validez de Éste
			$prefijo="R".$fRegistro[8]."/";
		break;
		case 7://Revisión de Jueces de Tutela
			$prefijo="IJT".$fRegistro[8]."/";
		break;
		case 8://Acción Consultiva Solicitada
			$prefijo="FC".$fRegistro[8]."/";
		break;
		case 9://Acción Efectiva de Derechos Humanos
			$prefijo="AE".$fRegistro[8]."/";
		break;
		case 10://PROTECCIÓN DERECHOS PUEBLOS INDÍGENAS
			$prefijo="PO".$fRegistro[8]."/";
		break;
	}
	if(($fRegistro[2]=="N/E")||($fRegistro[2]==""))
	{
		$carpetaAdministrativa=$prefijo.str_pad($fRegistro[3],4,"0",STR_PAD_LEFT)."/".parteEntera($fRegistro[4]);
	}
	
	if($fRegistro[6]>1)
	{
		$query="SELECT nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=30 AND claveElemento='".$fRegistro[6]."'";
		$sufijo=$con->obtenerValor($query);
		if($sufijo=="")
			$sufijo=$fRegistro[6];
		$carpetaAdministrativa.=" ".$sufijo;
	}
	
	
	$tipoExpediente=1;
	$idActividad=$fRegistro[0];
	$carpetaInvestigacion="";
	$query="SELECT claveFolioCarpetas,claveUnidad,id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro[1]."'";
	
	$fRegistroUnidad=$con->obtenerPrimeraFila($query);
	$cvAdscripcion=$fRegistroUnidad[1];
	$idUnidadGestion=$fRegistroUnidad[2];
	
	$idJuezTitular=$fRegistro[5];


	
	if(existeCarpetaAdministrativa($carpetaAdministrativa,$cvAdscripcion))
	{
		$query="update _".$idFormulario."_tablaDinamica set carpetaAdministrativa='".$carpetaAdministrativa."',numeracionExpediente='".$fRegistro[6].
				"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		return $con->ejecutarConsulta($query);
	}
		
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
					idRegistro,unidadGestion,etapaProcesalActual,idActividad,tipoCarpetaAdministrativa,carpetaInvestigacion,
					llaveCarpetaInvestigacion,idJuezTitular,secretariaAsignada) 
					VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".$cvAdscripcion."',1,".$idActividad.",".$tipoExpediente.",(SELECT UPPER('".$carpetaInvestigacion."')),'".
					cv(generarLlaveCarpetaInvestigacion($carpetaInvestigacion))."','".$idJuezTitular."','')";
	$x++;
	$consulta[$x]="update _".$idFormulario."_tablaDinamica set noAccion='".$fRegistro[8]."',carpetaAdministrativa='".$carpetaAdministrativa."',idMagistradoInstructor=".$idJuezTitular.
				",numeracionExpediente='".$fRegistro[6]."' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$x++;
	$consulta[$x]="set @idCarpeta:=(select  last_insert_id())";
	$x++;
	$consulta[$x]="commit";

	
	if($con->ejecutarBloque($consulta))
	{

		$query="select @idCarpeta";
		$idCarpeta=$con->obtenerValor($query);
		$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and tipoDocumento<>3";
		$rDocumentos=$con->obtenerFilas($query);
		while($fDocumento=mysql_fetch_row($rDocumentos))
		{
			registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro,$idCarpeta);	
		}

		
		
	}
	
	return false;
	
}

function mostrarSeccionEdicionDocumentoSalaConstitucional($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
{
	global $con;	
	
	$arrUsuarioPermitidos["170_0"]=1;	//Secretario General de Acuerdos
	$arrUsuarioPermitidos["176_0"]=1;	//Magistrado Presidente
	$arrUsuarioPermitidos["177_0"]=1;	//Magistrado Instructor
	$arrUsuarioPermitidos["97_0"]=1;	//Resp. Digitalización
	$arrUsuarioPermitidos["143_0"]=1;	//Resp. Digitalización
	$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;

	$rol=$con->obtenerValor($consulta);
	if(!isset($arrUsuarioPermitidos[$rol]))
	{
		return 0;
	}
	
	$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";
	$documentoBloqueado=$con->obtenerValor($consulta);	
	if($documentoBloqueado==1)
		return 0;
	return 1;
	
}


function asignarMagistradoInstructorCarpeta($idFormulario,$idRegistro)
{
	global $con;
	$consulta="SELECT idMagistradoInstructor FROM _589_tablaDinamica WHERE idReferencia=".$idRegistro;
	$idMagistradoInstructor=$con->obtenerValor($consulta);
	$x=0;
	$query[$x]="UPDATE 7006_carpetasAdministrativas SET  idJuezTitular=".$idMagistradoInstructor." WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
	$x++;
	$query[$x]="UPDATE _478_tablaDinamica SET  idMagistradoInstructor=".$idMagistradoInstructor." WHERE id__478_tablaDinamica=".$idRegistro;
	$x++;
	return $con->ejecutarBloque($query);
	
}


function asignarSentidoResolucionAsunto1($idFormulario,$idRegistro)
{
	global $con;
	
	$consulta="SELECT dictamenFinal FROM _595_tablaDinamica WHERE idReferencia=".$idRegistro." order by id__595_tablaDinamica desc";
	$resolucion=$con->obtenerValor($consulta);
	if($resolucion=="")
	{
		$consulta="SELECT dictamenFinal FROM _594_tablaDinamica WHERE idReferencia=".$idRegistro;
		$resolucion=$con->obtenerValor($consulta);
	}
	$consulta="UPDATE _478_tablaDinamica SET tipoAccionRealizada=".$resolucion." WHERE id__478_tablaDinamica=".$idRegistro;
	return $con->ejecutarConsulta($consulta);
	
}



function llenarPlantillaDocumentoJuzgadoOficio($idFormulario,$idRegistro)
{
	global $con;
	$juzgado=$_SESSION["codigoInstitucion"];
	$consulta="SELECT idFormulario,idReferencia FROM 7035_informacionDocumentos WHERE idRegistro=".$idRegistro;

	$fDatosBase=$con->obtenerPrimeraFila($consulta);
	if($fDatosBase)
	{
		$consulta="SELECT codigoInstitucion FROM  _".$fDatosBase[0]."_tablaDinamica WHERE id__".$fDatosBase[0]."_tablaDinamica=".$fDatosBase[1];
		$juzgado=$con->obtenerValor($consulta);
	}
	$consulta="SELECT upper(nombreUnidad) FROM _17_tablaDinamica WHERE claveUnidad='".$juzgado."'";

	$arrValores["juzgado"]=trim($con->obtenerValor($consulta));
	
	$consulta="SELECT noOficio,fechaCreacion,anio FROM _534_tablaDinamica WHERE id__534_tablaDinamica=".$idRegistro;

	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$noOficio=$fRegistro[0];
	$anio=date("Y",strtotime($fRegistro[1]));
	if($fRegistro[2]!="N/E")
	{
		$anio=$fRegistro[2];
	}
	else
	{
		$consulta="UPDATE _534_tablaDinamica SET anio='".$anio."' WHERE id__534_tablaDinamica=".$idRegistro;
		$con->ejecutarConsulta($consulta);
	}
	
	$arrValores["noOficio"]="SC/".str_pad($noOficio,4,"0",STR_PAD_LEFT)."/".$anio;
	return $arrValores;
}

function mostrarSeccionOficioSalaConstitucional($idFormulario,$idRegistro,$idFormularioEvaluacion,$actor)
{
	global $con;	
	
	$arrUsuarioPermitidos["170_0"]=1;	//Secretario General de Acuerdos
	$arrUsuarioPermitidos["176_0"]=1;	//Magistrado Presidente
	$arrUsuarioPermitidos["177_0"]=1;	//Magistrado Instructor
	$arrUsuarioPermitidos["143_0"]=1;	//Auxiliar
	$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;

	$rol=$con->obtenerValor($consulta);
	if(!isset($arrUsuarioPermitidos[$rol]))
	{
		return 0;
	}
	
	$consulta="SELECT documentoBloqueado FROM 7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND 
				i.idFormularioProceso=".$idFormularioEvaluacion." AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND f.idFormularioProceso=i.idFormularioProceso";
	$documentoBloqueado=$con->obtenerValor($consulta);	
	if($documentoBloqueado==1)
		return 0;
	return 1;
	
}


function existeCarpetaJudicialAsociada($idFormulario,$idReferencia)
{
	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idReferencia);
	if(($carpetaAdministrativa=='')||($carpetaAdministrativa=='N/E')||($carpetaAdministrativa==-1))
	{
		return 0;
	}
	return 1;
}
?>