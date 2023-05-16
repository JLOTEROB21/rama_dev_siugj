<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");

	header("charset=utf-8");
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			registrarDocumentoSGP();
		break;
		case 2:
			firmarDocumentoSGP();
		break;
		case 3:
			generarDocumentoPDFSGP();
		break;
		case 4:
			obtenerUnidadesGestionEdificio();
		break;
		case 5:
			obtenerSalasUnidadesGestion();
		break;
		case 6:
			obtenerEventosSalas();
		break;
		case 7:
			obtenerParticipantesSolicitud();
		break;
		case 8:
			removerParticipanteSolicitud();
		break;
		case 9:
			obtenerDelitosSolicitud();
		break;
		case 10:
			removerDelitoSolicitud();
		break;
		case 11:
			obtenerDatosEventoAudienciaControl();
		break;
		case 12:
			registrarModificacionEdificioUnidadGestion();
		break;
		case 13:
			obtenerJuecesDisponiblesUnidadGestionEvento();
		break;
		case 14:
			registrarModificacionJuez();
		break;
		case 15:		
			registrarModificacionFechaSala();
		break;
		case 16:		
			obtenerEventosModificacionFechaSala();
		break;
		case 17:		
			obtenerSujetosProcesalesCarpetaAdministrativa();
		break;
		case 18:
			obtenerProcesosCarpetaAdministrativa();
		break;
		case 19:
			obtenerDocumentosCarpetaAdministrativa();
		break;
		case 20:
			obtenerAccionesTableroControlDisponibles();
		break;
		case 21:
			obtenerHistorialAudiencias();
		break;
		case 22:
			obtenerHistorialAccionesAudiencia();
		break;
		case 23:
			registrarDocumentoAdjuntoReferenciaProceso();
		break;
		case 24:	
			registrarDocumentoAdjuntoCarpetaAdministrativa();
		break;
		case 25:
			obtenerEventosAudienciaAuxiliarSala();
		break;
		case 26:
			registrarDocumentoEventoAudiencia();
		break;
		case 27:
			obtenerFigurasJuridicasNotificacion();
		break;
		case 28:
			asignarNotificadorSolicitud();
		break;
		case 29:
			obtenerAuxiliaresSalaDisponibles();
		break;
		case 30:
			asignarAuxiliarSalaEvento();
		break;
		case 31:
			obtenerEntidadesCitacion();
		break;
		case 32:
			verificarCedulaProfesional();
		break;
		case 33:
			obtenerElementoApoyoBilioteca();
		break;
		case 34:
			obtenerConfiguracionProcesoTablero();
		break;
		case 35:
			obtenerActorProcesoDocumentos();
		break;
		case 36:
			obtenerDatosSolicitudAudienciaIntermedia();
		break;
		case 37:
			obtenerOtrasAudienciasPosteriorEvento();
		break;
		case 38:
			registrarDocumentoPromociones();
		break;
		case 39:
			obtenerEventosJuezAgenda();
		break;
		case 40:
			obtenerRegistroAplicacionAccionAudiencia();
		break;
		case 41:
			obtenerResolutivosAccionesEventoAudiencia();
		break;
		case 42:
			obteneDatosParticipanteAudiencia();
		break;
		case 43:
			obtenerProcesoOrigen();
		break;
		case 44:
			obtenerFolioRegistroSolicitud();
		break;
		case 45:
			obtenerProcesosAsociadosFormulario();
		break;
		case 46:
			marcarNotificacionesTableroControl();
		break;
		case 47:
			buscarCarpetaAdministrativa();
		break;
		case 48:
			obtenerEventosAudienciaSGJP();
		break;
		case 49:
			obtenerEventosAudienciaJuez();
		break;
		case 50:
			obtenerCarpetasAdministrativasUnidadGestion();
		break;
		case 51:
			obtenerRegistroIncompetencia();
		break;
		case 52:
			obtenerRegistroProgramacionAudiencia();
		break;
		case 53:
			obtenerEventosAudienciaSGJPCarpetaJudicial();
		break;
		case 54:
			obtenerRegistroProgramacionAudienciaCarpeta();
		break;
		case 55:
			obtenerArbolCarpetaJudicial();
		break;
		case 56:
			removerDocumentoCarpetaAdministrativa();
		break;
		case 57:
			actualizarTipoDocumento();
		break;
		case 58:
			obtenerRegistroProceso();
		break;
		case 59:
			obtenerRegistroModificacionAudiencia();
		break;
		case 60:
			generarReporteAudiencias();
		break;
		case 61:
			obtenerEventosAudienciaSGJPReporte();
		break;
		case 62:
			obtenerCarpetasAdministrativasReporte();
		break;
		case 63:
			obtenerResolutivosAudiencia();
		break;
		case 64:
			guardarInformeAudiencia();
		break;
		case 65:
			finalizarInformeEventoAudiencia();
		break;
		case 66:
			registrarMedidaCautelar();
		break;
		case 67:
			obtenerMedidasCautelaresActividad();
		break;
		case 68:
			removerMedidaCautelar();
		break;
		case 69:
			actualizarTipoAudienciaEvento();
		break;
		case 70:
			obtenerRegistroRemisionUGA();
		break;
		case 71:
			guardarModificacionHoraDesarrolloAudiencia();
		break;
		case 72:
			obtenerRegistroTribunalEnjuiciamiento();
		break;
		case 73:
			obtenerRegistroEjecucion();
		break;
		case 74:
			obtenerMedidasProteccionActividad();
		break;
		case 75:
			obtenerMedidasSuspensionCondicionalActividad();
		break;
		case 76:
			registrarMedidaProteccion();
		break;
		case 77:
			registrarMedidaSuspension();
		break;
		case 78:
			removerMedidaProteccion();
		break;
		case 79:
			removerCondicionSuspension();
		break;
		
	}



function registrarDocumentoSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode(bD($cadObj));
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	if($obj->idRegistroFormato==-1)
	{
		$consulta[$x]="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,cuerpoFormato,idFormulario,idRegistro,idReferencia,firmado,cadenaFirma,formatoPDF,idFormularioProceso)
				VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoFormato.",'".$obj->cuerpoFormato."',".$obj->idFormulario.",".$obj->idRegistro.",".$obj->idReferencia.
				",0,'','',".$obj->idFormularioProceso.")";
		$x++;		
		$consulta[$x]="set @idRegistroFormato:=(select last_insert_id())";
		$x++;
				
		
	}
	else
	{
		$consulta[$x]="set @idRegistroFormato:=".$obj->idRegistroFormato;
		$x++;
		$query="SELECT * FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$fFormato=$con->obtenerPrimeraFila($query);	
		if($fFormato[4]!=$obj->cuerpoFormato)
		{
			$consulta[$x]="INSERT INTO 3001_respaldoFormatoRegistrados(idRegistroFormato,fechaRegistro,idResponsableRegistro,cuerpoFormato) 
						    SELECT idRegistroFormato,fechaRegistro,idResponsableRegistro,cuerpoFormato FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$x++;
			$consulta[$x]="UPDATE 3000_formatosRegistrados SET fechaRegistro='".date("Y-m-d H:i:s")."',idResponsableRegistro='".$_SESSION["idUsr"]."',cuerpoFormato='".$obj->cuerpoFormato.
							"' WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$x++;
		}
		
	}
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		if($obj->idRegistroFormato==-1)
		{
			$query="select @idRegistroFormato";
			$obj->idRegistroFormato=$con->obtenerValor($query);
		}
		echo "1|".$obj->idRegistroFormato;
	}
	
	
}

function firmarDocumentoSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$idDocumento="NULL";
	$documentoBloqueado=0;
	
	
	$consulta="SELECT idFormulario,idRegistro FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
	$fFormato=$con->obtenerPrimeraFila($consulta);
	
	if(isset($obj->idArchivo))
	{
		
		$consulta="SELECT tipoFormato FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$tipoFormato=$con->obtenerValor($consulta);
		
		$consulta="SELECT categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoFormato;
		$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
		
		$idRegistro=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->cadena,$fDatosDocumento[0]);
		if($idRegistro==-1)
		{
			return;
		}	
		$idDocumento=$idRegistro;
		$obj->cadena="";
		$documentoBloqueado=1;
		
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
		registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idRegistro,$fFormato[0],$fFormato[1]);
		registrarDocumentoResultadoProceso($fFormato[0],$fFormato[1],$idRegistro);
			
	}

	$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena."',firmado=1,responsableFirma=".$_SESSION["idUsr"].",documentoBloqueado=".$documentoBloqueado." 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
				
	if($con->ejecutarConsulta($consulta))
	{
		
		if(isset($obj->idArchivo))
		{
			echo "1|";
		}
		else
		{
			if(generarDocumentoPDFFormato($obj->idRegistroFormato,true,1))
			{
				echo "1|1";
			}
		}
	}
}

function generarDocumentoPDFSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	if(generarDocumentoPDFFormato($obj->idRegistroFormato,false,0))
	{
		echo "1|1";
	}
}

function obtenerUnidadesGestionEdificio()
{
	global $con;
	$idEdifico=$_POST["idEdificio"];
	$consulta="SELECT id__17_tablaDinamica,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) FROM _17_tablaDinamica WHERE idReferencia=".$idEdifico." ORDER BY claveUnidad";
	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrUnidadesGestion;
	
}

function obtenerSalasUnidadesGestion()
{
	global $con;
	$idUnidadGestion=$_POST["idUnidadGestion"];
	$consulta="SELECT id__15_tablaDinamica,CONCAT('[',s.claveSala,'] ',nombreSala)  FROM _55_tablaDinamica t,_15_tablaDinamica s WHERE t.idReferencia=".$idUnidadGestion." AND s.id__15_tablaDinamica=t.salasVinculadas ORDER BY s.claveSala";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrSalas;
	
}

function obtenerEventosSalas()
{
	global $con;
	$idSala=$_POST["idSala"];
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) FROM 7000_eventosAudiencia a
				WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."'";

	$arrEventos="";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$e='{"editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
		
	echo '['.$arrEventos.']';
	
}

function obtenerParticipantesSolicitud()
{
	
	global $con;
	$idActividad=$_POST["idActividad"];
	$figuraJuridica=$_POST["figuraJuridica"];
	$consulta="SELECT id__47_tablaDinamica AS idRegistro,figuraJuridica AS tipoFigura,tipoPersona,nombre,apellidoPaterno AS apPaterno,apellidoMaterno AS apMaterno,edad,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (Víctima)') SEPARATOR '<br>') 
				FROM _47_chkVictimas c,_47_tablaDinamica p WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica ORDER BY nombre,apellidoPaterno,apellidoMaterno) as asesorados,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (Imputado)') SEPARATOR '<br>') 
				FROM _47_chkImputados c,_47_tablaDinamica p WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica ORDER BY nombre,apellidoPaterno,apellidoMaterno) as defendidos,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (',f.nombreTipo,')') SEPARATOR ', ') 
				FROM _47_chkImputadosVictimas c,_47_tablaDinamica p,_5_tablaDinamica f,7005_relacionFigurasJuridicasSolicitud rf 
				WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica and rf.idParticipante=p.id__47_tablaDinamica and rf.idFiguraJuridica=f.id__5_tablaDinamica and rf.idFiguraJuridica in (2,4)
				ORDER BY nombre,apellidoPaterno,apellidoMaterno) as representados,
				requiereDefensoria,imputadoDetenido as detenido,
				if(imputadoDetenido=1,if(lugarReclusorio=1,'Galeras','Reclusorio'),'') as lugarDetencion,
				(SELECT nombre FROM _2_tablaDinamica WHERE id__2_tablaDinamica=t.reclusorioDetencion) as reclusorio,cedulaProfesional,
				(if(".$figuraJuridica."=5,'1','0')) as tipoDefensor				
				 FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r WHERE r.idActividad=t.idActividad and 
				 r.idFiguraJuridica=".$figuraJuridica." and t.id__47_tablaDinamica=r.idParticipante and 
				t.idActividad=".$idActividad." order by nombre,apellidoPaterno,apellidoMaterno";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	
}

function removerParticipanteSolicitud()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$figuraJuridica=$_POST["figuraJuridica"];
	
	$consulta="DELETE FROM 7005_relacionFigurasJuridicasSolicitud WHERE  idParticipante=".$idRegistro." AND idFiguraJuridica=".$figuraJuridica;
	$con->ejecutarConsulta($consulta);
	$consulta="select count(*) from 7005_relacionFigurasJuridicasSolicitud WHERE  idParticipante=".$idRegistro;
	$nReg=$con->obtenerValor($consulta);
	if($nReg==0)
	{
		$consulta="delete FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idRegistro;
		eC($consulta);
	}
	else
		echo "1|";
	
	
	
}

function obtenerDelitosSolicitud()
{
	
	global $con;
	$idActividad=$_POST["idActividad"];
	$consulta="SELECT id__61_tablaDinamica AS idRegistro,tituloDelito,capituloDelito,denominacionDelito,modalidadDelito,calificativo,gradoRealizacion 
			FROM _61_tablaDinamica WHERE idActividad=".$idActividad;
	//$arrRegistros=$con->obtenerFilasJSON($consulta);
	$arrRegistros="";
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$consulta="SELECT d.idReferencia AS capitulo,c.idReferencia AS titulo FROM _35_denominacionDelito AS d,_35_tablaDinamica c 
					WHERE id__35_denominacionDelito=".$fila[3]." AND c.id__35_tablaDinamica=d.idReferencia";
		$filaDelito=$con->obtenerPrimeraFila($consulta);
		
		
		
		$lblImputable="";
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(p.nombre,' ',p.apellidoPaterno,' ',p.apellidoMaterno))  FROM _61_chkDelitosImputado d,
					_47_tablaDinamica p WHERE idPadre=".$fila[0]." AND p.id__47_tablaDinamica=d.idOpcion";
		$lblImputable=$con->obtenerListaValores($consulta);
		
		
		$o='{"idRegistro":"'.$fila[0].'","tipoDelito":"'.$filaDelito[1].'","capitulo":"'.$filaDelito[0].'","denominacion":"'.$fila[3].
			'","modalidadDelito":"'.$fila[4].'","calificativo":"'.$fila[5].'","gradoRealizacion":"'.$fila[6].'","imputableA":"'.$lblImputable.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function removerDelitoSolicitud()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$consulta="delete FROM _61_tablaDinamica WHERE id__61_tablaDinamica=".$idRegistro;
	eC($consulta);
	
}

function obtenerDatosEventoAudienciaControl()
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
		
	$consulta="SELECT CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
	$nombreUnidadGestion=$con->obtenerValor($consulta);
	
	if($fDatosEvento["idSala"]=="")
		$fDatosEvento["idSala"]=-1;
	$consulta="SELECT CONCAT('[',claveSala,'] ',nombreSala) FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fDatosEvento["idSala"];
	$nombreSala=$con->obtenerValor($consulta);
	
	$arrJueces="";
	$consulta="SELECT idRegistroEventoJuez,idJuez,tipoJuez,titulo FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$resJueces=$con->obtenerFilas($consulta);
	while($fJueces=mysql_fetch_row($resJueces))
	{
		$consulta="SELECT CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica t,800_usuarios u WHERE usuarioJuez=u.idUsuario AND u.idUsuario=".$fJueces[1];//." AND idReferencia=".$fDatosEvento["idCentroGestion"];

		$nombreJuez=$con->obtenerValor($consulta);
		
		$oJueces='{"idRegistroEventoJuez":"'.$fJueces[0].'","idJuez":"'.$fJueces[1].'","tipoJuez":"'.$fJueces[2].'","titulo":"'.cv($fJueces[3]).'","nombreJuez":"'.cv($nombreJuez).'"}';
		if($arrJueces=="")
			$arrJueces=$oJueces;
		else
			$arrJueces.=",".$oJueces;
	}
	
	$consulta="SELECT CONCAT('[',claveAudiencia,'] ',tipoAudiencia) FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fDatosEvento["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$carpetaJudicial=$con->obtenerValor($consulta);
	
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
	
	$cadObj='{"carpetaJudicial":"'.$carpetaJudicial.'","idTipoAudiencia":"'.$fDatosEvento["tipoAudiencia"].'","tipoAudiencia":"'.$tipoAudiencia.'","fechaEvento":"'.$fDatosEvento["fechaEvento"].'","horaInicio":"'.
			$fDatosEvento["horaInicioEvento"].'","horaFin":"'.$fDatosEvento["horaFinEvento"].
			'","horaInicioReal":"'.$fDatosEvento["horaInicioReal"].'","horaFinReal":"'.$fDatosEvento["horaTerminoReal"].'","urlMultimedia":"'.$fDatosEvento["urlMultimedia"].
			'","idEdificio":"'.$fDatosEvento["idEdificio"].'","edificio":"'.cv($nombreInmueble).'","idUnidadGestion":"'.$fDatosEvento["idCentroGestion"].
			'","unidadGestion":"'.cv($nombreUnidadGestion).'","idSala":"'.$fDatosEvento["idSala"].'","sala":"'.cv($nombreSala).'","jueces":['.$arrJueces.
			'],"situacion":"'.$fDatosEvento["situacion"].'","lblSituacion":"'.cv($lblSituacion).'",
			"iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'"}';
	
	echo "1|".$cadObj;
	
}

function registrarModificacionEdificioUnidadGestion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="SELECT idEdificio,idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEdificio=$con->obtenerPrimeraFila($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 3004_bitacoraCambiosEdificioUnidadGestion(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idEdificioOriginal,idUnidadGestionOriginal,idEdificioCambio,idUnidadGestionCambio,idMotivoCambio,comentariosAdicionales)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$fEdificio[0].",".$fEdificio[1].",".$obj->idEdificio.",".$obj->idUnidadGestion.",".$obj->motivoCambio.",'".cv($obj->comentariosAdicionales)."')";
	$x++;
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET idEdificio=".$obj->idEdificio.",idCentroGestion=".$obj->idUnidadGestion." where idRegistroEvento=".$obj->idEvento;
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	
	eB($query);
	
}

function obtenerJuecesDisponiblesUnidadGestionEvento()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$idUnidadGestion=bD($_POST["iUG"]);
	$mostrarTodosJueces=false;
	if(isset($_POST["mostrarTodosJueces"]))
	{
		$mostrarTodosJueces=$_POST["mostrarTodosJueces"]==1;
	}
	
	$datosEvento=obtenerDatosEventoAudiencia($idEvento);
	
	
	$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$listaJueces=$con->obtenerListaValores($consulta);
	if($listaJueces=="")
		$listaJueces=-1;
	
	$consulta="SELECT tipoJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$tipoJuez=$con->obtenerValor($consulta);
	if($tipoJuez=="")
		$tipoJuez=1;
	
	$arrJueces="";
	$consulta="SELECT usuarioJuez,CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica t,
			800_usuarios u,_26_tipoJuez tj WHERE idReferencia=".$idUnidadGestion." AND u.idUsuario=t.usuarioJuez  
			and tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=".$tipoJuez." and 
			u.idUsuario not in(".$listaJueces.") ORDER BY clave";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
			$comp="";
			$conDisponibilidad=existeDisponibilidadJuez($fila[0],$datosEvento->fechaEvento,$datosEvento->horaInicio,$datosEvento->horaFin,-1,"",true);
			if(!$conDisponibilidad)
			{
				if(!$mostrarTodosJueces)
					continue;
				else
				{
					$comp="Sin disponibilidad";
				}
			}
			
		
			if(esJuezTramite($fila[0],$datosEvento->fechaEvento))
			{
				if($comp=="")
					$comp="Juez de tr&aacute;mite";
				else
					$comp.=" / Juez de tr&aacute;mite";
			}
		
			if($comp!="")
				$comp=" (".$comp.")";
			$oJuez="['".$fila[0]."','".cv($fila[1].$comp)."']";
			if($arrJueces=="")
				$arrJueces=$oJuez;
			else
				$arrJueces.=",".$oJuez;
		
	}
	
	echo "1|[".$arrJueces."]";
}

function registrarModificacionJuez()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="SELECT idEdificio,idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEdificio=$con->obtenerPrimeraFila($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idRegistroJuez,idJuezOriginal,idJuezCambio,idMotivoCambio,comentariosAdicionales)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idRegistroJuez.",".$obj->idJuezOriginal.",".$obj->idJuezCambio.",".$obj->motivoCambio.
				",'".cv($obj->comentariosAdicionales)."')";
	$x++;
	
	$query[$x]="UPDATE 7001_eventoAudienciaJuez SET idJuez=".$obj->idJuezCambio." WHERE idRegistroEventoJuez=".$obj->idRegistroJuez;
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	
	eB($query);
	
}

function registrarModificacionFechaSala()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="SELECT idJuez,tipoJuez,idRegistroEventoJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento;
	$fDatosJuez=$con->obtenerPrimeraFila($consulta);
	$idJuez=$fDatosJuez[0];
	$tipoJuez=$fDatosJuez[1];
	$idRegistroEventoJuez=$fDatosJuez[2];
	
	$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idSala,idCentroGestion,idEdificio,idFormulario,idRegistroSolicitud,tipoAudiencia 
			FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEvento=$con->obtenerPrimeraFila($consulta);
	
	if(!existeDisponibilidadJuez($idJuez,$obj->fechaEvento,$obj->horaInicio,$obj->horaFin,$obj->idEvento)||($idJuez==-1))
	{

		if($obj->asignacionJuez==0)
		{
			echo '<br>No existe disponibilidad del juez<br>';
			return;
		}
		else
		{
			
			$oDatosAudiencia=array();
			$oDatosAudiencia["idRegistroEvento"]=$obj->idEvento;
			$oDatosAudiencia["idEdificio"]=$fEvento[5];
			$oDatosAudiencia["listaEdificiosIgnorar"]=-1;
			$oDatosAudiencia["idUnidadGestion"]=$fEvento[4];
			$oDatosAudiencia["listaUnidadesGestionIgnorar"]=-1;
			$oDatosAudiencia["idSala"]=$fEvento[3];
			$oDatosAudiencia["listaSalasIgnorar"]=-1;
			$oDatosAudiencia["fecha"]=$obj->fechaEvento;
			$oDatosAudiencia["horaInicio"]=$obj->horaInicio;
			$oDatosAudiencia["horaFin"]=$obj->horaFin;			
			
			$oDatosParametros=array();
			$oDatosParametros["idFormulario"]=$fEvento[6];
			$oDatosParametros["idRegistro"]=$fEvento[7];
			$oDatosParametros["idReferencia"]=-1;
			$oDatosParametros["tipoAudiencia"]=$fEvento[8];
			$oDatosParametros["oDatosAudiencia"]=$oDatosAudiencia;
			$oDatosParametros["notificarMAJO"]=false;
			$oDatosParametros["nivelAsignacion"]=4; //1 Hasta UGJ; 2 Total
			$oDatosParametros["juecesRequeridos"]=array();
			
			
			$consulta="SELECT * FROM _27_tablaDinamica";
			$fConfiguracion=$con->obtenerPrimeraFilaAsoc($consulta);	
			
			$oDatosParametros["fechaSolicitud"]=date("Y-m-d H:i:s");		
			$oDatosParametros["idRegistroConfiguracionAgenda"]=$fConfiguracion["id__27_tablaDinamica"];
			$oDatosParametros["criterioBalanceoEdificio"]=$fConfiguracion["tipoBalanceoEdificio"];
			$oDatosParametros["criterioBalanceoUnidadGestion"]=$fConfiguracion["criterioBalanceoUnidadGestion"];
			$oDatosParametros["criterioBalanceoSala"]=$fConfiguracion["tipoBalanceoAsignacionSala"];
			$oDatosParametros["criterioBalanceoJuez"]=$fConfiguracion["tipoBalanceoAsignacionJuez"];	
			$oDatosParametros["horasMaximaAsignablesJuez"]=$fConfiguracion["horasMaximaAsignablesJuez"];	
			
			$consulta="SELECT promedioDuracion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEvento[8];
			$duracionAudiencia=$con->obtenerValor($consulta);
				
			$oDatosParametros["duracionAudiencia"]=$duracionAudiencia;			
			
			$oDatosParametros["fechaMaximaAudiencia"]=NULL;
			$oDatosParametros["fechaMinimaAudiencia"]="";
			$oDatosParametros["considerarDiaHabil"]=true;
			$oDatosParametros["funcionDiaHabil"]="";
			$oDatosParametros["esSolicitudUgente"]=true;	
				
			$oDatosParametros["fechaBasePeriodo"]="";

			$oDatosParametros["metodoBalanceoEventosJuez"]=1;
			$fechaInicialPeriodo=date("Y-06-16",strtotime($oDatosAudiencia["fecha"]));
			$fechaFinalPeriodo=date("Y-m-d");
			
			

			$idJuezCambio=asignarJuezAudiencia($oDatosAudiencia,$oDatosParametros,$tipoJuez,$idJuez,$fechaInicialPeriodo,$fechaFinalPeriodo);
			$consulta="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idRegistroJuez,idJuezOriginal,idJuezCambio,idMotivoCambio,comentariosAdicionales)
						values(".$obj->idEvento.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idRegistroEventoJuez.",".$idJuez.",".$idJuezCambio.",2,'EL juez no contaba con disponibilidad de horario')";
			
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="update 7001_eventoAudienciaJuez set idJuez=".$idJuezCambio." where idRegistroEvento=".$obj->idEvento;
				$con->ejecutarConsulta($consulta);
			}
			
		}
	}
	
	

	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 3006_bitacoraCambiosSalaFecha(idEventoAudiencia,fechaOperacion,idResponsableOperacion,fechaOriginal,horaInicioOriginal,horaTerminoOriginal,
				idSalaOriginal,fechaCambio,horaInicioCambio,horaTerminoCambio,idSalaCambio,idMotivoCambio,comentariosAdicionales,asignacionJuez)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$fEvento[0]."','".$fEvento[1]."','".$fEvento[2]."',".$fEvento["3"].
				",'".$obj->fechaEvento."','".$obj->horaInicio."','".$obj->horaFin."','".$obj->idSala."','".$obj->idMotivoCambio."','".
				cv($obj->comentariosAdicionales)."',".$obj->asignacionJuez.")";
	$x++;
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET  fechaEvento='".$obj->fechaEvento."',horaInicioEvento='".$obj->horaInicio."',horaFinEvento='".$obj->horaFin."',idSala=".$obj->idSala." where idRegistroEvento=".$obj->idEvento;
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	
	eB($query);
	
}

function obtenerEventosModificacionFechaSala()
{
	global $con;
	$idSala=$_POST["idSala"];
	$idEvento=$_POST["iEvento"];
	$asignacionJuez=$_POST["asignacionJuez"];
	
	
	
	$listaEventosIgnorar=$idEvento;
	
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),
				idCentroGestion,fechaEvento,idRegistroEvento,idSala,fechaLimiteAtencion FROM 7000_eventosAudiencia a WHERE 
				idRegistroEvento=".$idEvento;
	
	$fila=$con->obtenerPrimeraFila($consulta);
	

	$fechaLimiteAtencion=$fila[7];
	$e='{"id":"e_'.$fila[5].'","editable":true,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
	$arrEventos=$e;
	
	/*$consulta="SELECT horaInicial,horaFinal FROM _17_horario WHERE idReferencia=".$fila[3]." and dia=".date("N",strtotime($fila[4]));
	$fHorarioUnidadGestion=$con->obtenerPrimeraFila($consulta);
	
	$e='{"id":"hNormal","editable":false,"title":"Horario normal","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." ".$fHorarioUnidadGestion[0])).
		'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." ".$fHorarioUnidadGestion[1])).'","color":"#F3F09D","rendering":"background"}';	
	$arrEventos.=",".$e;
	if($fHorarioUnidadGestion)
	{
		$e='{"id":"hExtra1","editable":false,"title":"Horario extraordinario","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." 00:00:00")).
			'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." ".$fHorarioUnidadGestion[0])).'","color":"#777","rendering":"background"}';	
		$arrEventos.=",".$e;
		
		$e='{"id":"hExtra2","editable":false,"title":"Horario extraordinario","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." ".$fHorarioUnidadGestion[1])).
			'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." 23:59:59")).'","color":"#777","rendering":"background"}';	
		$arrEventos.=",".$e;
	}
	else
	{
		$e='{"id":"hExtra1","editable":false,"title":"Horario extraordinario","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." 00:00:00")).
			'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[4]." 23:59:59")).'","color":"#777","rendering":"background"}';	
		$arrEventos.=",".$e;
	}
	*/
	
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),idRegistroEvento FROM 7000_eventosAudiencia a
				WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
				a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
				and idRegistroEvento<>".$idEvento;


	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$listaEventosIgnorar.=",".$fila[3];
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
		$cAdministrativa=$con->obtenerValor($consulta);
		
		
		$e='{"id":"e_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).' ['.$fila[3].']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
		$arrEventos.=",".$e;
	}
	
	
	if($asignacionJuez==0)
	{
		$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
		$rJuez=$con->obtenerFilas($consulta);
		while($fJuez=mysql_fetch_row($rJuez))
		{
	
			$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),'Evento de Juez',a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
						WHERE e.idJuez=".$fJuez[0]." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
						fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
						and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				
				$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
				$arrEventos.=",".$e;
			}
			
			$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica FROM _20_tablaDinamica WHERE usuarioJuez=".$fJuez[0]." and fechaInicial<='".$start."' and fechaFinal>='".$start."'";
			$iJuez=$con->obtenerFilas($consulta);
			while($fIncidencia=mysql_fetch_row($iJuez))
			{
				$e='{"id":"iJ_'.$fila[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T00:00:00").'","color":"#3D00CA"}';	
				$arrEventos.=",".$e;
			}
			
		}
	}
	$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
				AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=".$idSala;
	$iSala=$con->obtenerFilas($consulta);
	while($fIncidencia=mysql_fetch_row($iSala))
	{
		$horaInicial="00:00:00";
		if($fIncidencia[1]!="")
		{
			if($fIncidencia==$start)
			{
				$horaInicial=$fIncidencia[1];
			}
		}
		
		$horaFinal="23:59:59";
		if($fIncidencia[3]!="")
		{
			if($fIncidencia[2]==$start)
			{
				$horaFinal=$fIncidencia[3];
			}
		}
		
		$e='{"id":"iS_'.$fila[4].'","editable":false,"title":"La sala ha sido marcada como No disponible","start":"'.($start."T".$horaInicial).'","end":"'.($start."T".$horaFinal).'","color":"#B55381"}';	
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
			$e='{"id":"limiteAtencion","editable":false,"title":"Fuera del límite máximo de atención","start":"'.($start."T".$horaInicial).'","end":"'.($start."T".$horaFinal).'","color":"#000"}';	
			$arrEventos.=",".$e;
		}
	}
	
	echo '['.$arrEventos.']';
	
}

function obtenerSujetosProcesalesCarpetaAdministrativa()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	$sujetosProcesales="";
	if(isset($_POST["sP"]))
		$sujetosProcesales=bD($_POST["sP"]);
	
	
	$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$consulta="SELECT idActividad FROM _".$fCarpeta[0]."_tablaDinamica WHERE id__".$fCarpeta[0]."_tablaDinamica=".$fCarpeta[1];
	$idActividad=$con->obtenerValor($consulta);

	
	$arrFiguras="";
	$consulta="SELECT id__5_tablaDinamica,etiquetaPlural FROM _5_tablaDinamica ".(($sujetosProcesales!="")?" where id__5_tablaDinamica in(".$sujetosProcesales.")":"")." ORDER BY codigo";
	$rFiguras=$con->obtenerFilas($consulta);
	while($fFiguras=mysql_fetch_row($rFiguras))
	{
		$consulta="SELECT idPadre FROM _47_chParticipacionJuridica p,_47_tablaDinamica s WHERE s.idActividad=".$idActividad." AND  p.idPadre=s.id__47_tablaDinamica and p.idOpcion=".$fFiguras[0];
		$lPersonas=$con->obtenerLIstaValores($consulta);
		if($lPersonas=="")
			$lPersonas=-1;
			
		$arrPersonas="";
		$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE idActividad=".$idActividad.
				" and (figuraJuridica=".$fFiguras[0]." or id__47_tablaDinamica in(".$lPersonas.")) order by nombre,apellidoPaterno,apellidoMaterno";
		$rPersona=$con->obtenerFilas($consulta);
		while($fPersona=mysql_fetch_row($rPersona))
		{
			
			$comp='"leaf":true';
			
			switch($fFiguras[0])
			{
				case 3:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkVictimas v WHERE 
								v.idPadre=".$fPersona[0]."  AND v.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=mysql_fetch_row($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pA_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					
					$comp='"expanded":true,"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA0","text":"<b>Asesor de:</b>","leaf":false,children:['.$arrHijos.']}]';		
				break;
				case 5:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputados i WHERE 
								i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=mysql_fetch_row($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pD_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					
					$comp='"expanded":true,"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA1","text":"<b>Defensor de:</b>","leaf":false,children:['.$arrHijos.']}]';
					
				break;
				case 6:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputadosVictimas i WHERE 
								i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=mysql_fetch_row($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pR_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					
					$comp='"expanded":true,"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA2","text":"<b>Representante de:</b>","leaf":false,children:['.$arrHijos.']}]';
				break;
			}
			
			$icono="user.png";
			if($fPersona[1]!=1)
			{
				$icono="chart_organisation.png";
			}
			$id='p_'.$fPersona[0]."_".$fFiguras[0];
			
			$consulta="SELECT COUNT(*) FROM _228_tablaDinamica WHERE idUsuario=".$fPersona[0]." AND idEvento=".$idEvento." AND presentoAudiencia=1";
			$nReg=$con->obtenerValor($consulta);
			
			$iconAsistencia="<img width='13' height='13' src='../images/cross.png' title='NO se presento a audiencia' alt='NO se presento a audiencia' >";
			if($nReg!=0)
			{
				$iconAsistencia="<img width='13' height='13' src='../images/icon_big_tick.gif' title='Asisti&oacute; a audiencia' alt='Asisti&oacute; a audiencia' >";
			}
			$oP='{"checked":false,"tipo":"1","icon":"../images/'.$icono.'","id":"'.$id.'","text":"'.$iconAsistencia." ".cv($fPersona[4]." ".$fPersona[3]." ".$fPersona[2]).'",'.$comp.'}';
			if($arrPersonas=="")
				$arrPersonas=$oP;
			else
				$arrPersonas.=",".$oP;
		}
		
		if($fFiguras[0]==5)
		{
			$consulta="SELECT DISTINCT notificador,d.idReferencia FROM _82_tablaDinamica d,_80_tablaDinamica s WHERE d.idReferencia=s.id__80_tablaDinamica AND s.idEstado=3 AND s.carpetaAdministrativa='".$carpetaAdministrativa."'";
			$res=$con->obtenerFilas($consulta);
			while($fDefensor=mysql_fetch_row($res))
			{
				
				$consulta="SELECT DISTINCT imputado FROM _82_tablaDinamica WHERE idReferencia=".$fDefensor[1]." AND notificador=".$fDefensor[0];
				$listaImputados=$con->obtenerListaValores($consulta);
				if($listaImputados=="")
					$listaImputados=-1;
				$arrHijos="";
				$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d  WHERE 
							id__47_tablaDinamica in(".$listaImputados.")  order by nombre,apellidoPaterno,apellidoMaterno";
							
				$rDependientes=$con->obtenerFilas($consulta);			
				while($fDependientes=mysql_fetch_row($rDependientes))
				{
					$icono="user.png";
					if($fDependientes[1]!=1)
					{
						$icono="chart_organisation.png";
					}
					
					$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pD_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
					if($arrHijos=="")
						$arrHijos=$oP;
					else
						$arrHijos.=",".$oP;
				}
							
				
				$comp='"expanded":true,"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pDO'.$fDefensor[0].'","text":"<b>Defensor de:</b>","leaf":false,children:['.$arrHijos.']}]';
				
				
				$icono="user.png";
			
				$id='pDO_'.$fDefensor[0]."_".$fFiguras[0];
				
				$consulta="SELECT nombre,apPaterno,apMaterno FROM _154_tablaDinamica WHERE id__154_tablaDinamica=".$fDefensor[0];
				$fPersona=$con->obtenerPrimeraFila($consulta);
				
				
				
				
				
				$iconAsistencia="<img width='13' height='13' src='../images/cross.png' title='NO se presento a audiencia' alt='NO se presento a audiencia' >";
				$oP='{"checked":false,"tipo":"1","icon":"../images/'.$icono.'","id":"'.$id.'","text":"'.$iconAsistencia." (Público) ".cv($fPersona[0]." ".$fPersona[1]." ".$fPersona[2]).'",'.$comp.'}';
				if($arrPersonas=="")
					$arrPersonas=$oP;
				else
					$arrPersonas.=",".$oP;
				
			}
			
			
			
			
					
		}
		
		
		
		
		if($arrPersonas!="")
		{
			$o='{"tipo":"0","expanded":true,"icon":"../images/bullet_green.png","id":"f_'.$fFiguras[0].'","text":"<span style=\'color:#900; font-weight:bold\'>'.cv($fFiguras[1]).'</span>","leaf":false,children:['.$arrPersonas.']}';
			if($arrFiguras=="")
				$arrFiguras=$o;
			else
				$arrFiguras.=",".$o;
		}
	}
	
	
	//$consulta="SELECT tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE idActividad=";
	
	echo '['.$arrFiguras.']';
	
	
	
}

function obtenerProcesosCarpetaAdministrativa()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	
	$arrRegistros="";
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$arrProcesos="";
		$consulta="SELECT idFormulario,idRegistro,fechaRegistro FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0]." and tipoContenido=2 order by fechaRegistro";
		$rProceso=$con->obtenerFilas($consulta);
		while($fProceso=mysql_fetch_row($rProceso))
		{
			$consulta="SELECT p.nombre,f.idProceso FROM 900_formularios f,4001_procesos p WHERE f.idFormulario=".$fProceso[0]." and p.idProceso=f.idProceso";
			$fFormulario=$con->obtenerPrimeraFila($consulta);

			$consulta="SELECT fechaCreacion,idEstado FROM _".$fProceso[0]."_tablaDinamica WHERE id__".$fProceso[0]."_tablaDinamica=".$fProceso[1];
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fFormulario[1]." AND numEtapa=".$fRegistro[1];
			$fEtapa=$con->obtenerPrimeraFila($consulta);
			
			$situacion=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
			
			
			$o='{"tipo":"1","icon":"../images/cog.png","id":"p_'.$fProceso[0].'_'.$fProceso[1].'","idFormulario":"'.$fProceso[0].'","idRegistro":"'.$fProceso[1].'","text":"'.cv($fFormulario[0]).
				'","fechaCreacion":"'.date("d/m/Y H:i",strtotime($fRegistro[0])).'","situacion":"'.cv($situacion).'",leaf:true}';
			
			if($arrProcesos=="")
				$arrProcesos=$o;
			else
				$arrProcesos.=",".$o;
			
		}
		
		
		if($arrProcesos!="")
		{
			$o='{"tipo":"0","fechaCreacion":"","situacion":"","expanded":true,"icon":"../images/bullet_green.png","id":"e_'.$fila[0].'","text":"<span style=\'color:#900\'><b>'.cv($fila[1]).'</b></span>","leaf":false,"children":['.$arrProcesos.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	
	echo '['.$arrRegistros.']';
	
}

function obtenerDocumentosCarpetaAdministrativa()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);

	$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);

	$cadCondWhere=str_replace("fechaCreacion"," cast(fechaCreacion as date)",$cadCondWhere);	
		
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales
				union 
				select 0,'Sin etapa',0 as orden 
				 ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$consulta="SELECT idFormulario,idRegistro,fechaRegistro,idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0]." and tipoContenido=1 order by fechaRegistro";

		$rDocumentos=$con->obtenerFilas($consulta);
		while($fDocumentos=mysql_fetch_row($rDocumentos))
		{
			if($fDocumentos[3]=="")
				continue;
			$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fDocumentos[3]." and ".$cadCondWhere;

			$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
			if($fDatosDocumento)
			{
				$o='{"fechaRegistro":"'.date("Y-m-d",strtotime($fDocumentos[2])).'","idDocumento":"'.$fDatosDocumento[0].'","etapaProcesal":"'.$fila[0].'","nomArchivoOriginal":"'.cv($fDatosDocumento[6]).'","tamano":"'.$fDatosDocumento[8].
					'","fechaCreacion":"'.$fDatosDocumento[2].'","descripcion":"'.cv($fDatosDocumento[11]).'","categoriaDocumentos":"'.$fDatosDocumento[12].
					'","idFormulario":"'.$fDocumentos[0].'","idRegistro":"'.$fDocumentos[1].'"}';
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

function obtenerAccionesTableroControlDisponibles()
{
	global $con;
	
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	$idPerfil=bD($_POST["iP"]);
	$numReg=0;
	$consulta="SELECT id__99_gridAccionesDisponibles,lblEtiquetaAccion,tipoModulo,proceso,moduloJs,archivoJS 
				FROM _99_gridAccionesDisponibles WHERE idReferencia=".$idPerfil." ORDER BY lblEtiquetaAccion";	


	
	$arrAcciones="";
	
	$res=$con->obtenerFilas($consulta);				
	while($fila=mysql_fetch_row($res))
	{
		$ejecutarFuncion="";
		$objConf="";
		
		
		if($fila[2]==1) //Modulo predefinido
		{
			$ejecutarFuncion=$fila[4];
			$objConf='{"idEvento":"'.$idEvento.'","carpetaAdministrativa":"'.$carpetaAdministrativa.'"}';
		}
		else
		{
			$rol='54_0';
			$idPerfil=obtenerIdPerfilEscenario($fila[3],1,$rol,true);
			$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$fila[3].
							" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
				
			$idActorAgregar=$con->obtenerValor($consulta);
			
			$idFormulario=obtenerFormularioBase($fila[3]);
			$ejecutarFuncion="abrirVentanaFancy";
			$objConf='{"url":"../modeloPerfiles/vistaDTDv3.php","params":[[\'idEvento\',\''.$idEvento.
						'\'],[\'idReferencia\',\''.$idEvento.'\'],[\'carpetaAdministrativa\',\''.$carpetaAdministrativa.
						'\'],[\'idFormulario\',\''.$idFormulario.'\'],[\'idRegistro\',\'-1\'],[\'dComp\',\''.bE("agregar").
						'\'],[\'actor\',\''.$idActorAgregar.'\']],"ancho":"100%","alto":"100%","modal":"true"}';
		}
		
		$datosConfiguracion='{"ejecutarFuncion":"'.$ejecutarFuncion.'","objConf":'.$objConf.'}';
		$o='{"idAccion":"'.$fila[0].'","etiqueta":"'.cv($fila[1]).'","tipoModulo":"'.$fila[2].'","datosConfiguracion":"'.bE($datosConfiguracion).'"}';
		if($arrAcciones=="")
			$arrAcciones=$o;
		else
			$arrAcciones.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrAcciones.']}';
}

function obtenerHistorialAudiencias()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
	$idEvento=-1;
	if(isset($_POST["iE"]))
		$idEvento=bD($_POST["iE"]);
	
	
	$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$eventoReferencia=$con->obtenerValor($consulta);
	
	
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa 
					WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoContenido=3 
					and etapaProcesal=".$fila[0];
		$listaEventos=$con->obtenerListaValores($consulta);
		if($listaEventos=="")
			$listaEventos=-1;
			
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,horaInicioReal,horaTerminoReal,tipoAudiencia 
					FROM 7000_eventosAudiencia WHERE idRegistroEvento in (".$listaEventos.") and idRegistroEvento<>".$idEvento;
					
		if($eventoReferencia!="")			
			$consulta.=" AND horaInicioEvento<='".$eventoReferencia."'";
		$consulta.=" ORDER BY horaInicioEvento"	;
		
		$resEventos=$con->obtenerFilas($consulta);
		while($fEvento=mysql_fetch_row($resEventos))
		{
			$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEvento[7];
			$tipoAudiencia=$con->obtenerValor($consulta);
			
			
			$lblHorario="";	
			$fechaHoraInicio=strtotime($fEvento[2]);
			$fechaHoraFin=strtotime($fEvento[3]);
			$comp='';
			if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
			{
				$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
			}
			
			$lblHorario='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
			
			
			$lblHorarioReal="";
			if($fEvento[5]!="")
			{
				$fechaHoraInicio=strtotime($fEvento[5]);
				$fechaHoraFin=strtotime($fEvento[6]);
				$comp='';
				if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
				{
					$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
				}
				
				$lblHorarioReal='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
				
			}
			
			
			$o='{"idEvento":"'.$fEvento[0].'","fechaEvento":"'.$fEvento[1].'","situacion":"'.$fEvento[4].'","tipoAudiencia":"'.cv($tipoAudiencia).
				'","horarioProgramado":"'.$lblHorario.'","horarioReal":"'.$lblHorarioReal.'","etapaProcesal":"'.$fila[0].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;	
		}
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerHistorialAccionesAudiencia()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idRegistro,iFormulario,iRegistro FROM 7012_historialAccionesEvento WHERE idRegistroEvento=".$idEvento." ORDER BY fechaAccion ASC";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT p.nombre,f.idProceso FROM 900_formularios f,4001_procesos p WHERE f.idFormulario=".$fila[1]." and p.idProceso=f.idProceso";
		$fFormulario=$con->obtenerPrimeraFila($consulta);

		$consulta="SELECT fechaCreacion,idEstado FROM _".$fila[1]."_tablaDinamica WHERE id__".$fila[1]."_tablaDinamica=".$fila[2];
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fFormulario[1]." AND numEtapa=".$fRegistro[1];
		$fEtapa=$con->obtenerPrimeraFila($consulta);
		
		$situacion=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
		
		$actor=obtenerActorProcesoIdRol($fFormulario[1],'54_0',$fRegistro[1]);
		if($actor=="")
			$actor=0;
		
		$o='{"idRegistro":"'.$fila[0].'","iFormulario":"'.$fila[1].'","iRegistro":"'.$fila[2].'","etiqueta":"'.cv($fFormulario[0]).
			'","situacion":"'.cv($situacion).'","actor":"'.$actor.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarDocumentoAdjuntoReferenciaProceso()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);

	if($idDocumento!=-1)
	{
		if(registrarDocumentoReferenciaProceso($obj->idFormulario,$obj->idRegistro,$idDocumento))
		{
			echo "1|";
		}
	}
	echo "";
	
	
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
			echo "1|";
	}
	echo "";
	
	
}


function obtenerEventosAudienciaAuxiliarSala()
{
	global $con;
	$fechaEvento=$_POST["fE"];
	$carpeta=$_POST["cA"];
	$situacion=$_POST["s"];
	
	$arrRegistros="";
	$numReg=0;
	
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$centroGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion from 
	7000_eventosAudiencia e WHERE fechaEvento='".$fechaEvento."' AND situacion=".$situacion." and idCentroGestion=".$centroGestion;
	
	if($carpeta!="")
	{
		$consultaAux="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpeta."' AND tipoContenido=3";	
		$listaEventos=$con->obtenerListaValores($consultaAux);
		if($listaEventos=="")
			$listaEventos=-1;
		
		$consulta.=" and 	idRegistroEvento in (".$listaEventos.")";
	}
	

	
	$res=$con->obtenerFilas($consulta);
	while($filaRegistros=mysql_fetch_row($res))
	{
		
		$fechaEvento=convertirFechaLetra($filaRegistros[1],true);
		
		$lblHorario="";
		
		$fechaHoraInicio=strtotime($filaRegistros[2]);
		$fechaHoraFin=strtotime($filaRegistros[3]);
		$comp='';
		if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
		{
			$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
		}
		
		$lblHorario='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE idRegistroContenidoReferencia=".$filaRegistros[0]." AND tipoContenido=3";
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		
		$o='{"idEventoAudiencia":"'.$filaRegistros[0].'","fechaEvento":"'.$filaRegistros[1].'","carpetaAdministrativa":"'.$carpetaAdministrativa.'","horarioEvento":"'.cv(utf8_encode($lblHorario)).'","situacion":"'.$filaRegistros[4].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
			
		$numReg++	;
			
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}
function registrarDocumentoEventoAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idRegistro=-1;
	if($obj->registroUnico==1)
	{
		$consulta="SELECT id__101_tablaDinamica FROM _101_tablaDinamica WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);	
		if($idRegistro=="")
			$idRegistro=-1;
	}
	
	if($idRegistro==-1)
	{
		$consulta="INSERT INTO _101_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,idEvento,carpetaAdministrativa,idFormatoImpresion) 
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"]."',".$obj->idEvento.",'".$obj->carpetaAdministrativa."',".$obj->idDocumento.")";
		if($con->ejecutarConsulta($consulta))
		{
			$idRegistro=$con->obtenerUltimoID();
			registrarProcesoEventoAudiencia(101,$idRegistro,$obj->idEvento);
			cambiarEtapaFormulario(101,$idRegistro,1,"",-1,"NULL","NULL",304);
			asignarFolioRegistro(101,$idRegistro);
			
			
		}
	}
	
	echo "1|".$idRegistro;
	
}

function obtenerFigurasJuridicasNotificacion()
{
	
	global $con;
	$numReg=0;
	$idRegistro=$_POST["idRegistro"];
	$iFormularioSolicitud=$_POST["iFormularioSolicitud"];
	$idRegistroSolicitud=$_POST["idRegistroSolicitud"];
	$arrRegistros="";
	$consulta="SELECT id__72_tablaDinamica,fechaCreacion,responsable,carpetaAdministrativa,idPersonaNotificar,idFiguraJuridica,
				tipoFigura,tipoDocumento,idEstado,codigo
				FROM _72_tablaDinamica WHERE iFormulario=".$iFormularioSolicitud." AND iRegistro=".$idRegistroSolicitud;
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT nombreElemento FROM 1018_catalogoVarios WHERE claveElemento=".$fila[6]." AND tipoElemento=15";
		$tipoFigura=$con->obtenerValor($consulta);
		
		$tipoDocumento="";
		if($fila[7]!=0)
		{
			$consulta="SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fila[7];
			$tipoDocumento=$con->obtenerValor($consulta);
		}
		else
		{
			$tipoDocumento="Documento adjunto de la solicitud";
		}
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=96 AND numEtapa=".$fila[8];
		$fEstado=$con->obtenerPrimeraFila($consulta);
		$situacion=removerCerosDerecha($fEstado[0]).".- ".$fEstado[1];
		
		$personaNotificar="";
		if($fila[6]==1)
		{
			$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila[4];
			$personaNotificar=$con->obtenerValor($consulta);
		}
		else
		{
			$consulta="SELECT nombreInstancia FROM _149_tablaDinamica  WHERE id__149_tablaDinamica=".$fila[4];
			$personaNotificar=$con->obtenerValor($consulta);
		}
		
		$actor=obtenerActorProcesoIdRol(96,'38_0',$fila[8]);
		if($actor=="")
			$actor=0;
		
		$o='{"folioRegistro":"'.$fila[9].'","idRegistro":"'.$fila[0].'","fechaAsignacion":"'.$fila[1].'","notificadorAsignado":"'.obtenerNombreUsuario($fila[2]).
			'","personaNotificar":"'.cv($personaNotificar).'","idFiguraJuridica":"'.$fila[5].'","tipoFigura":"'.cv($tipoFigura).
			'","tipoDocumento":"'.cv($tipoDocumento).'","situacionRegistro":"'.cv($situacion).'","actor":"'.$actor.'"}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function asignarNotificadorSolicitud()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT carpetaAdministrativa FROM _".$obj->iFormulario."_tablaDinamica WHERE id__".$obj->iFormulario."_tablaDinamica=".$obj->iRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$arrValores["responsable"]=$obj->idNotificador;
	$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
	$arrValores["idPersonaNotificar"]=$obj->destinatario;
	$arrValores["iFormulario"]=$obj->iFormulario;
	$arrValores["iRegistro"]=$obj->iRegistro;
	$arrValores["idFiguraJuridica"]=$obj->figuraJuridica;
	$arrValores["idEvento"]=$obj->idEvento==""?-1:$obj->idEvento;
	$arrValores["tipoFigura"]=$obj->tipoFigura;
	$arrValores["tipoDocumento"]=$obj->documento;


	$actor="385";
	$arrDocumentosReferencia=array();
	$idEtapa=1;
	if($obj->documento==0)
	{
		$consulta="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$obj->iFormulario.
				" AND idRegistro=".$obj->iRegistro." AND tipoDocumento=1";
			
		$res=$con->obtenerFilas($consulta);		
		while($fila=mysql_fetch_row($res))
		{
			array_push($arrDocumentosReferencia,$fila[0]);
		}
	
		$actor=522;
		$idEtapa=7;
	}
	
	
	$idRegistro=crearInstanciaRegistroFormulario(72,-1,$idEtapa,$arrValores,$arrDocumentosReferencia,-1,314);
	if($idRegistro!=-1)
	{
		$arFormasNotificacion=explode(",",$obj->arrMediosNotificacion);		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		foreach($arFormasNotificacion as $medioNotificacion)
		{
			$query[$x]="INSERT INTO _72_chdMedioNotificacion(idPadre,idOpcion) values(".$idRegistro.",".$medioNotificacion.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			echo "1|".$idRegistro."|".$actor;
		}
	}
}

function obtenerAuxiliaresSalaDisponibles()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fEvento=$con->obtenerPrimeraFilaAsoc($consulta);			
	$arrRegistros="";
	$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fEvento["idCentroGestion"];
	$centroGestion=$con->obtenerValor($consulta);
	$consulta="SELECT u.idUsuario,u.Nombre FROM 807_usuariosVSRoles r,800_usuarios u,801_adscripcion a WHERE r.idRol=16 AND u.idUsuario=r.idUsuario
				AND a.idUsuario=u.idUsuario AND a.codigoUnidad='".$centroGestion."'";
	$resAuxiliar=$con->obtenerFilas($consulta);				
	while($filaAuxiliar=mysql_fetch_row($resAuxiliar))
	{
		if(existeDisponibilidadAuxiliar($filaAuxiliar[0],$fEvento["horaInicioEvento"],$fEvento["horaFinEvento"],$idEvento))
		{
			$o="['".$filaAuxiliar[0]."','".cv($filaAuxiliar[1])."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	
	echo "1|[".$arrRegistros."]";

}

function asignarAuxiliarSalaEvento()
{
	global $con;
	$iE=$_POST["iE"];
	$iA=$_POST["iA"];
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$consulta="SELECT idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$iE;
	$fEvento=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT idRegistroAuxiliar FROM 3007_auxiliarSalaEvento WHERE idFormulario=".$fEvento[0]." AND idReferencia=".$fEvento[1];
	$idRegistroAuxiliar=$con->obtenerValor($consulta);
	if($idRegistroAuxiliar=="")
	{
		$query[$x]="INSERT INTO 3007_auxiliarSalaEvento(idFormulario,idReferencia,idAuxiliarSala)
					VALUES(".$fEvento[0].",".$fEvento[1].",".$iA.")";
		$x++;
	}
	else
	{
		$query[$x]="UPDATE 3007_auxiliarSalaEvento SET idAuxiliarSala=".$iA." WHERE idRegistroAuxiliar=".$idRegistroAuxiliar;
		$x++; 
	}
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET idAuxiliarSala=".$iA." WHERE idRegistroEvento=".$iE;
	$x++;
	$query[$x]="commit";
	$x++;
	
	eB($query);
}


function obtenerEntidadesCitacion()
{
	global $con;
	$carpetaAdministrativa=$_POST["cA"];
	$tipoFigura=$_POST["tF"];
	$idRegistro=$_POST["iR"];
	
	$consulta="SELECT tipoSolicitud FROM _67_tablaDinamica WHERE id__67_tablaDinamica=".$idRegistro;
	$tipoSolicitud=$con->obtenerValor($consulta);
	
	$arrPersonas="";
	$numReg=0;
	
	switch($tipoFigura)
	{
		case "1": //Figura juridica
			$datosCarpeta=obtenerDatosSujetosProcesalesDelitosCarpetaAdministrativa($carpetaAdministrativa);
			
			$consulta="SELECT distinct idReferencia FROM _5_gridCitacionNotificacion WHERE aplicableA=".$tipoSolicitud;
			$resFiguras=$con->obtenerFilas($consulta);
			while($fFigura=mysql_fetch_row($resFiguras))
			{
				$consulta="SELECT  nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica =".$fFigura[0];
				$lblTipoFigura=$con->obtenerValor($consulta);
				$nombreTipo="";
				switch($fFigura[0])
				{
					case "1":
						$nombreTipo="Denunciantes";
					break;
					case "2":
						$nombreTipo="Víctimas";
					break;
					case "3":
						$nombreTipo="Asesores";
					break;
					case "4":
						$nombreTipo="Imputados";
					break;
					case "5":
						$nombreTipo="Defensores";
					break;
					case "6":
						$nombreTipo="Representantes";
					break;
					case "7":
						$nombreTipo="Testigos";
					break;
				}
				
				
				if(isset($datosCarpeta[$nombreTipo]))
				{
					foreach($datosCarpeta[$nombreTipo] as $d)
					{
						$arrFormatos="";
						$arrMediosNotificacion="";
						
						$consulta="SELECT t.id__10_tablaDinamica,concat('[',t.cveFormato,'] ',t.nombreFormato) FROM _5_gridCitacionNotificacion g,_10_tablaDinamica t 
								WHERE g.formatoNotificacion=t.id__10_tablaDinamica AND g.aplicableA=".$tipoSolicitud." AND g.idReferencia=".$fFigura[0];
						
						
						$arrFormatos=$con->obtenerFilasArreglo($consulta);	
						
						$consulta="SELECT idOpcion FROM _64_tablaDinamica c,_64_tipoMedioNotificacion m WHERE m.idPadre=c.id__64_tablaDinamica AND
								c.idReferencia=".$d["idRegistro"];
						
						$listaCheck=$con->obtenerListaValores($consulta);
						
						if($listaCheck=="")
						{
							$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica";
							$listaCheck=$con->obtenerListaValores($consulta);
						}
						
						
						
						
						$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica where id__63_tablaDinamica in (".$listaCheck.")";
						$arrMediosNotificacion=$con->obtenerFilasArreglo($consulta);
						
						
						$o="['".$d["idRegistro"]."','".($d["nombre"]." ".$d["apellidoPaterno"]." ".$d["apellidoMaterno"])." (".cv($lblTipoFigura).")','".$d["tipoPersona"]."',".$arrFormatos.",".$arrMediosNotificacion.",'".$fFigura[0]."']";
						
						if($arrPersonas=="")
							$arrPersonas=$o;
						else
							$arrPersonas.=",".$o;
							
						$numReg++;
					}
					
				
				}
			
			}
			
			
			
		
		
		break;
		case "2":  //Institucion
			$consulta="SELECT id__149_tablaDinamica,nombreInstancia FROM _149_tablaDinamica";
			$resFiguras=$con->obtenerFilas($consulta);
			while($fFigura=mysql_fetch_row($resFiguras))
			{
				$arrFormatos="";
				$arrMediosNotificacion="";
				
				$consulta="SELECT t.id__10_tablaDinamica,concat('[',t.cveFormato,'] ',t.nombreFormato) FROM _149_gridConfiguracionCitacionesNotificaciones g,_10_tablaDinamica t 
						WHERE g.formatoNotificacion=t.id__10_tablaDinamica AND g.aplicableA=".$tipoSolicitud." AND g.idReferencia=".$fFigura[0];
				
				
				$arrFormatos=$con->obtenerFilasArreglo($consulta);	
				
				$consulta="SELECT idOpcion FROM _149_cheMediosNotificacion m  WHERE m.idPadre=".$fFigura[0];
				
				$listaCheck=$con->obtenerListaValores($consulta);
				
				if($listaCheck=="")
				{
					$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica";
					$listaCheck=$con->obtenerListaValores($consulta);
				}
				
				$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica where id__63_tablaDinamica in (".$listaCheck.")";
				$arrMediosNotificacion=$con->obtenerFilasArreglo($consulta);
				
				$o="['".$fFigura[0]."','".($fFigura[1])."','1',".$arrFormatos.",".$arrMediosNotificacion.",'0']";
				if($arrPersonas=="")
					$arrPersonas=$o;
				else
					$arrPersonas.=",".$o;
					
				$numReg++;
			}
			
		break;
		
	}
	
	
	echo "1|[".$arrPersonas."]";
	
	
	
}

function verificarCedulaProfesional()
{
	global $con;
	$noCedula=$_POST["noCedula"];
	$resultado=utf8_encode(consultarPaginaCedulaProfesional($noCedula));
		
	echo "1|".$resultado;
}


function consultarPaginaCedulaProfesional($noCedula)
{
	$params["json"]='{"maxResult":"1000","idCedula":"'.$noCedula.'","nombre":"","paterno":"","materno":"",
					"h_genero":"","genero":"","annioInit":"","annioEnd":"","insedo":"","inscons":"",
					"institucion":"TODAS"}';
	$postData=http_build_query	(
									$params
								);
								
	$opciones=array();
	$opciones["http"]["method"]="POST";
	$opciones["http"]["header"]="Content-type: application/x-www-form-urlencoded";
	$opciones["http"]["content"]=$postData;
	$context  = stream_context_create($opciones);
	
	$result = file_get_contents('http://www.cedulaprofesional.sep.gob.mx/cedula/buscaCedulaJson.action', false, $context);

	return $result;							
}

function obtenerElementoApoyoBilioteca()
{
	global $con;
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
	$consulta="SELECT id__170_tablaDinamica AS idRegistro,tituloRecursos,tiposRecurso as tipoRecurso,
	if(descripcion<>'',descripcion,'(Sin descripción)') as descripcion,origenRecurso,url,documentoAdjunto,
	formaVisualizacion FROM _170_tablaDinamica WHERE situacionRecurso=1 and tiposRecurso>1 and ".$cadCondWhere;
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}

function obtenerConfiguracionProcesoTablero()
{
	global $con;
	$cadProceso=$_POST["cadProceso"];
	$oProceso=json_decode($cadProceso);
	
	$idFormulario=obtenerFormularioBase($oProceso->proceso);
	$idRegistro=-1;
	$rol="54_0";
	$dComp="agregar";
	$actor="";
	if($oProceso->repetible==0)
	{
		$consulta="";
		$nombreTabla="_".$idFormulario."_tablaDinamica";
		if($oProceso->multiplesSujetos==1)
		{
			$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM ".$nombreTabla." 
						WHERE idEvento=".$oProceso->idEvento;
		}
		else
		{
			$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM ".$nombreTabla." 
						WHERE  idEvento=".$oProceso->idEvento;
						
			if($con->existeCampo("idUsuario",$nombreTabla))			
			{
				$consulta.=" and idUsuario=".$oProceso->idUsuario;
			}
						
			if($con->existeCampo("figuraJuridica",$nombreTabla))			
			{
				$consulta.=" AND figuraJuridica=".$oProceso->figuraJuridica;
			}
			

						
			
		}
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$etapa=1;
		if($fRegistro)
		{
			$etapa=$fRegistro[1];
			$idRegistro=$fRegistro[0];
			$dComp="auto";
			$actor=obtenerActorProcesoIdRol($oProceso->proceso,$rol,$etapa);
			if($actor=="")
				$actor=0;
		}
		else
		{
			$idPerfil=obtenerIdPerfilEscenario($oProceso->proceso,1,$rol,true);	
			$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$oProceso->proceso.
						" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
			
			$actor=$con->obtenerValor($consulta);
		}
		
		
		
	}
	else
	{
		$idPerfil=obtenerIdPerfilEscenario($oProceso->proceso,1,$rol,true);	
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$oProceso->proceso.
						" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
			
		$actor=$con->obtenerValor($consulta);
	}
	if($actor=="")
		$actor=0;
	echo '1|{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","dComp":"'.$dComp.'","actor":"'.$actor.'"}';
	
}

function obtenerActorProcesoDocumentos()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idProceso=obtenerIdProcesoFormulario($obj->idFormulario);
	$idActor=obtenerActorProcesoIdRol($idProceso,$obj->idRol,$obj->idEtapa);
	if($idActor=="")
		$idActor=0;
	
	echo "1|".$idActor;	
	
}

function obtenerDatosSolicitudAudienciaIntermedia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idProceso=obtenerIdProcesoFormulario(185);
	$objResp="";
	$rol="54_0";
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia=".$obj->idEventoReferencia;
	$fDatodAudiencia=$con->obtenerPrimeraFila($consulta);
	if(!$fDatodAudiencia)
	{
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
							" and idAccion=8 and actor ='".$rol."' and idPerfil=-1";
				
		$actor=$con->obtenerValor($consulta);
		if($actor=="")
			$actor=0;
		$objResp='{"arrEspecificaciones":"","idRegistro":"-1","dComp":"agregar","actor":"'.$actor.'"}';
	}
	else
	{
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fDatodAudiencia[1]);
		if($actor=="")
			$actor=0;
		$objResp='{"arrEspecificaciones":"","idRegistro":"'.$fDatodAudiencia[0].'","dComp":"auto","actor":"'.$actor.'"}';
	}
	
	echo "1|".$objResp;
	
}

function obtenerOtrasAudienciasPosteriorEvento()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$arrRegistros="";
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoContenido=3";
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
	
	$numReg=0;
	$consulta="SELECT fechaEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fechaEvento=$con->obtenerValor($consulta);
	$consulta="SELECT idRegistroEvento,situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento IN (".$listaEventos.
				") AND fechaEvento>='".$fechaEvento."'";//."' AND idRegistroEvento<>".$idEvento;
	
		
	$resEventos=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resEventos))
	{
		$datos=obtenerDatosEventoAudiencia($fila[0]);
		$consulta="SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=".$fila[1];
		$situacion=$con->obtenerValor($consulta);
		$o='{"idEvento":"'.$fila[0].'","fechaAudiencia":"'.$datos->fechaEvento.'","horaInicial":"'.$datos->horaInicio.
			'","horaTermino":"'.$datos->horaFin.'","tipoAudiencia":"'.$datos->tipoAudiencia.'","situacion":"'.$situacion.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarDocumentoPromociones()
{
	
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT id__123_tablaDinamica FROM _123_tablaDinamica WHERE iFormulario=".$obj->iFormulario.
				" AND iRegistro=".$obj->iRegistro." AND tipoDocumento=".$obj->tipoDocumento;
				
	$idRegistro=$con->obtenerValor($consulta);				
	
	$idEstado="1.1";
	switch($obj->iFormulario)
	{
		case "96":
			$consulta="SELECT imputado,figurasJuridicas,carpetaAdministrativa FROM _96_tablaDinamica WHERE id__96_tablaDinamica=".$obj->iRegistro;
		break;
		case "197":
			$idEstado="1.2";
			$consulta="SELECT idUsuario,4,carpetaAdministrativa FROM _197_tablaDinamica WHERE id__197_tablaDinamica=".$obj->iRegistro;
		break;
		
	}
	$fFiguras=$con->obtenerPrimeraFila($consulta);
	
	if($idRegistro=="")
	{
		$arrValores=array();
		$arrDocumentosReferencia=NULL;
		$arrValores["idPersona"]=$fFiguras[0];
		$arrValores["tipoFigura"]=$fFiguras[1];
		$arrValores["tipoDocumento"]=$obj->tipoDocumento;
		$arrValores["iFormulario"]=$obj->iFormulario;
		$arrValores["iRegistro"]=$obj->iRegistro;
		$arrValores["carpetaAdministrativa"]=$fFiguras[2];
		
		$idRegistro=crearInstanciaRegistroFormulario(123,-1,$idEstado,$arrValores,$arrDocumentosReferencia,-1,426);	
		
	}
	
	
	$consulta="SELECT idEstado FROM _123_tablaDinamica WHERE id__123_tablaDinamica= ".$idRegistro;
				
	$idEstado=$con->obtenerValor($consulta);	
	
	$idProceso=obtenerIdProcesoFormulario(123);
	$rol="36_0";
	if($obj->iFormulario==197)
	{
		$rol="65_0";
	}
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$idEstado);
	
	$oObj='{"idRegistro":"'.$idRegistro.'","actor":"'.$actor.'"}';
	
	
	echo "1|".$oObj;
				
	
}

function obtenerEventosJuezAgenda()
{
	global $con;
	$idJuez=$_POST["idJuez"];
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT idRegistroEvento FROM 7001_eventoAudienciaJuez WHERE idJuez=".$idJuez;
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) FROM 7000_eventosAudiencia a
				WHERE  fechaEvento>='".$start."' AND fechaEvento<='".$end."' and idRegistroEvento in (".$listaEventos.")";

	$arrEventos="";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$e='{"editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
		
	echo '['.$arrEventos.']';
	
}

function obtenerRegistroAplicacionAccionAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idProceso=obtenerIdProcesoFormulario(233);
	$objResp="";
	$rol="54_0";
	$consulta="SELECT id__233_tablaDinamica,idEstado FROM _233_tablaDinamica WHERE idEvento=".$obj->idEventoReferencia." and idAccion=".$obj->idAccion;
	$fDatodAudiencia=$con->obtenerPrimeraFila($consulta);
	if(!$fDatodAudiencia)
	{
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
							" and idAccion=8 and actor ='".$rol."' and idPerfil=-1";
				
		$actor=$con->obtenerValor($consulta);
		if($actor=="")
			$actor=0;
		$objResp='{"idRegistro":"-1","dComp":"agregar","actor":"'.$actor.'"}';
	}
	else
	{
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fDatodAudiencia[1]);
		if($actor=="")
			$actor=0;
		$objResp='{"idRegistro":"'.$fDatodAudiencia[0].'","dComp":"auto","actor":"'.$actor.'"}';
	}
	
	echo "1|".$objResp;
}

function obtenerResolutivosAccionesEventoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$arrRegistros="";
	$numReg=0;
	$rol="54_0";
	$consulta="SELECT idFormulario,idRegistro,tituloContenido FROM 7016_contenidosEventoAudiencia WHERE idRegistroEvento=".$idEvento." ORDER BY idContenido";
	$rResolutivo=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($rResolutivo))
	{
		$idProceso=obtenerIdProcesoFormulario($fila[0]);
		$consulta="SELECT idEstado FROM _".$fila[0]."_tablaDinamica WHERE id__".$fila[0]."_tablaDinamica=".$fila[1];
		$numEtapa=$con->obtenerValor($consulta);
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$numEtapa);
		if($actor=="")
			$actor=0;
		$o='{"idFormulario":"'.$fila[0].'","idRegistro":"'.$fila[1].'","tituloContenido":"'.cv($fila[2]).'","actor":"'.$actor.'"}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function obteneDatosParticipanteAudiencia()
{
	global $con;
	$idFigura=$_POST["idFigura"];
	$idParticipante=$_POST["idParticipante"];
	$idEvento=$_POST["idEvento"];
	
	
	$consulta="SELECT id__228_tablaDinamica FROM _228_tablaDinamica WHERE idUsuario=".$idParticipante.
				" AND idEvento=".$idEvento." AND presentoAudiencia=1";
	$idRegistro=$con->obtenerValor($consulta);
	if($idRegistro=="")
		$idRegistro=-1;
	$o='{"idFormulario":"228","idRegistro":"'.$idRegistro.'","descripcion":"Asistió a audiencia","cumple":"'.($idRegistro==-1?0:1).'"}';	
	$arrDatos=$o;
	
	$consulta="SELECT id__72_tablaDinamica,idEstado FROM _72_tablaDinamica WHERE idPersonaNotificar=".$idParticipante.
				" AND idEvento=".$idEvento;
				
	
	$fNotificacion=$con->obtenerPrimeraFila($consulta);
	
	if(!$fNotificacion)
		$idRegistro=-1;
	else
		$idRegistro=$fNotificacion[0];
	
	$cumple=0;	
	if($idRegistro==-1)	
	{
		$cumple=0;
		$situacionNotificacion="Orden de notificación NO realizada";
	}
	else
	{
		if(($fNotificacion[1]>=4)&&($fNotificacion[1]!=7))
			$cumple=1;
		
		$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=96 AND numEtapa=".$fNotificacion[1];
		$situacionNotificacion=$con->obtenerValor($consulta);
	}
		
	$o='{"idFormulario":"72","idRegistro":"'.$fNotificacion[0].'","descripcion":"Notificación ('.cv($situacionNotificacion).')","cumple":"'.$cumple.'"}';	
	$arrDatos.=",".$o;	
	
	echo '{"numReg":"0","registros":['.$arrDatos.']}';
	
}

function obtenerProcesoOrigen()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT * FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$objReg='{"iFormulario":"'.$fRegistro["iFormulario"].'","iRegistro":"'.$fRegistro["iRegistro"].'"}';
	
	echo "1|".$objReg;
	
	
}

function obtenerFolioRegistroSolicitud()
{
	global $con;
	$idFormulario=$_POST["iF"];
	$idRegistro=$_POST["iR"];
	
	$consulta="select codigo from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$folio=$con->obtenerValor($consulta);
	echo "1|".$folio;
	
}

function obtenerProcesosAsociadosFormulario()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$actor=$_POST["actor"];
	
	$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
	$rol=$con->obtenerValor($consulta);
	$arrRegistros="";
	$nReg=0;
	
	$consulta="SELECT iFormulario,iRegistro,descripcion FROM 3008_procesosAsociadosFormulario WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$idProceso=obtenerIdProcesoFormulario($fila[0]);
		
		$consulta="SELECT idEstado FROM _".$fila[0]."_tablaDinamica WHERE id__".$fila[0]."_tablaDinamica=".$fila[1];
		
		$idEstado=$con->obtenerValor($consulta);
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$idEstado;
		$fConsulta=$con->obtenerPrimeraFila($consulta);
		$situacion=removerCerosDerecha($fConsulta[0]).".- ".cv($fConsulta[1]);
		
		$descripcion=$fila[2];
		if($descripcion!="")
		{
			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
			$descripcion=$con->obtenerValor($consulta);
		}
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$idEstado);
		if($actor=="")
			$actor=0;
			
		$o='{"iFormulario":"'.$fila[0].'","iRegistro":"'.$fila[1].'","situacion":"'.$situacion.'","descripcion":"'.cv($descripcion).'","actor":"'.$actor.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$nReg++;
			
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';	
}

function marcarNotificacionesTableroControl()
{
	global $con;
	$listaNotificaciones=$_POST["l"];
	$status=$_POST["s"];
	$iT=$_POST["iT"];
	
	
	$consulta="update 9060_tableroControl_".$iT." set idEstado=".$status." where idRegistro in (".$listaNotificaciones.")";
	eC($consulta);
	
}

function buscarCarpetaAdministrativa()
{
	global $con;
	$criterio=$_POST["criterio"];
	$numReg=0;
	$arrCarpetas="";
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$_SESSION["codigoInstitucion"]."'";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o='{"carpetaAdministrativa":"'.$fila[0].'"}';
		if($arrCarpetas=="")
			$arrCarpetas=$o;
		else
			$arrCarpetas.=",".$o;
		$numReg++;
	}

	echo '{"numReg":"'.$numReg.'","registros":['.$arrCarpetas.']}';
	
	
	
	
}

function obtenerEventosAudienciaSGJP()
{
	global $con;
	
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
					$c=" and idSala=".$filter[$x]["data"]["value"];
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
			}
		}
		
	}
	
	$uG=$_POST["uG"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia  
			FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null
			".$condiciones;
			
			
	if($uG!=0)		
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
		$iUnidad=$con->obtenerValor($query);
		$consulta.=" and idCentroGestion=".$iUnidad;
	}

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
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
		$tipoAudiencia="";
		$tAudiencia="";
		switch($fila[9])
		{
			case 11:
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
			case 46:
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia,idActividad FROM _46_tablaDinamica WHERE id__46_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				$idActividad=$fDatos[2];
				
			break;
			case 185:
				$idActividad=-1;
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
				
			break;
			case 6:
				continue;
			break;
			case 5:
			case 7:
				$consulta="SELECT carpetaAdministrativa,idTipoAudiencia FROM otrasSolicitudes WHERE tipo=".$fila[9]." and idSolicitud=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
		}
		
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica=4";
		$tImputados=$con->obtenerValor($consulta);
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerEventosAudienciaJuez()
{
	global $con;
	
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
					$condiciones=" and idSala=".$filter[$x]["data"]["value"];
				break;
				case "tipoAudiencia":
					$condiciones=" and tipoAudiencia=".$filter[$x]["data"]["value"];
				break;
			}
		}
		
	}
	
	$iJuez=$_POST["iJuez"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud 
			FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null
			".$condiciones;
			
			
	if($iJuez!=0)		
	{
		$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud 
			FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null and j.idRegistroEvento=e.idRegistroEvento and j.idJuez=".$iJuez." 
			and situacion in (1,3)
			".$condiciones;
	}

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
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
		$tipoAudiencia="";
		$tAudiencia="";
		switch($fila[9])
		{
			case 11:
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
			case 46:
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia,idActividad FROM _46_tablaDinamica WHERE id__46_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				$idActividad=$fDatos[2];
				
			break;
			case 185:
				$idActividad=-1;
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
				
			break;
			case 6:
				continue;
			break;
			case 5:
			case 7:
				$consulta="SELECT carpetaAdministrativa,idTipoAudiencia FROM otrasSolicitudes WHERE tipo=".$fila[9]." and idSolicitud=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
		}
		
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica=4";
		$tImputados=$con->obtenerValor($consulta);
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerCarpetasAdministrativasUnidadGestion()
{
	global $con;
	$uG=$_POST["uG"];
	$anio=$_POST["anio"];
	
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
					$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				
			}
		}
		
	}
	
	
	$arrRegistro="";
	$numReg=0;
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual FROM 7006_carpetasAdministrativas 
				WHERE unidadGestion='".$uG."' and fechaCreacion>='".$anio."-01-01 00:00:01' and fechaCreacion<='".$anio.
				"-12-31 23:59:59' ".$condiciones." ORDER BY carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","etapaProcesal":"'.$fila[2].'"}';
		if($arrRegistro=="")
			$arrRegistro=$o;
		else
			$arrRegistro.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
}

function obtenerRegistroIncompetencia()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__307_tablaDinamica,idEstado FROM _307_tablaDinamica WHERE carpetaAdministrativa='".$cA."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(264);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(307);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerRegistroProgramacionAudiencia()
{
	global $con;
	$iE=$_POST["iE"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(265);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(185);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerEventosAudienciaSGJPCarpetaJudicial()
{
	global $con;
	
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
					$condiciones=" and idSala=".$filter[$x]["data"]["value"];
				break;
				case "tipoAudiencia":
					$condiciones=" and tipoAudiencia=".$filter[$x]["data"]["value"];
				break;
			}
		}
		
	}
	
	$cJ=$_POST["cJ"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	
	$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$cJ."' AND tipoContenido=3";
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia 
			FROM 7000_eventosAudiencia where idRegistroEvento in(".$listaEventos.") and
			horaInicioEvento is not null and horaFinEvento is not null
			".$condiciones." order by horaInicioEvento";
			
			
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta=$cJ;
		$tipoAudiencia=$fila[8];

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
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","horaInicialReal":"'.$fila[11].'","horaFinalReal":"'.$fila[12].
			'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerRegistroProgramacionAudienciaCarpeta()
{
	global $con;
	$iE=$_POST["iE"];
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."' and carpetaAdministrativa='".$cA."' and idEstado=1";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(265);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(185);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerArbolCarpetaJudicial()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
		
	$arrHijos="[".obtenerCarpetasHijas($carpetaAdministrativa)."]";	
		
	$obj='{expanded:true,"icon":"../images/s.gif","id":"'.$carpetaAdministrativa.'","text":"'.$carpetaAdministrativa.'",children:'.$arrHijos.',leaf:'.(($arrHijos=="[]")?"true":"false").'}';
		
		
	echo '['.$obj.']'	;
		
}

function obtenerCarpetasHijas($cA)
{
	global $con;
	$arrHijos="";
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$cA."'";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrHijos2="[".obtenerCarpetasHijas($fila[0])."]";	
		
		$obj='{expanded:true,"icon":"../images/s.gif","id":"'.$fila[0].'","text":"'.$fila[0].'",children:'.$arrHijos2.',leaf:'.(($arrHijos2=="[]")?"true":"false").'}';
		if($arrHijos=="")
			$arrHijos=$obj;
		else
			$arrHijos.=",".$obj;
	}
	
	
	
	
	return $arrHijos;
}

function removerDocumentoCarpetaAdministrativa()
{
	global $con;
	
	$cA=$_POST["cA"];
	$idDocumento=$_POST["iD"];
	$motivo=$_POST["motivo"];
	
	$consulta="UPDATE 7007_contenidosCarpetaAdministrativa SET tipoContenido=tipoContenido*-1,complementario1='".date("Y-m-d H:i:s")."',complementario2='".$_SESSION["idUsr"]."',complementario3='".cv($motivo)."' 
			WHERE carpetaAdministrativa='".$cA."' AND tipoContenido=1 AND idRegistroContenidoReferencia=".$idDocumento;
	eC($consulta);
}

function actualizarTipoDocumento()
{
	global $con;
	
	$tD=$_POST["tD"];
	$iD=$_POST["iD"];
	$consulta="UPDATE 908_archivos SET categoriaDocumentos=".$tD." WHERE idArchivo IN(".$iD.")";
	eC($consulta);
}

function obtenerRegistroProceso()
{
	global $con;
	
	$iFormulario=$_POST["iFormulario"];
	$iEvento=$_POST["iE"];
	
	$rol="69_0";
	
	$idRegistro=-1;
	$idProceso=obtenerIdProcesoFormulario($iFormulario);
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$etapa=1;
	$dComp="agregar";
	if($fRegistro)
	{

		$etapa=$fRegistro[1];
		$idRegistro=$fRegistro[0];
		$dComp="auto";
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);
		if($actor=="")
			$actor=0;
	}
	else
	{

		$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$rol,true);	
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
					" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
		
		$actor=$con->obtenerValor($consulta);
	}
	
	
	echo "1|".$idRegistro."|".bE($dComp)."|".bE($actor);
	
	
}

function obtenerRegistroModificacionAudiencia()
{
	global $con;
	
	$iFormulario=$_POST["iFormulario"];
	$iEvento=$_POST["iE"];
	
	$rol="69_0";
	
	$idRegistro=-1;
	$idProceso=obtenerIdProcesoFormulario($iFormulario);
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento." and idEstado in(1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	if(!$fRegistro)
	{
		$arrValores=array();
		$objDatosAudienciaOriginal="";
		$arrValores["objDatosAudienciaOriginal"]=$objDatosAudienciaOriginal;
		$arrValores["objDatosAudienciaCambio"]=$objDatosAudienciaOriginal;
		$arrDocumentosReferencia=array();
		crearInstanciaRegistroFormulario(324,-1,1,$arrValores,$arrDocumentosReferencia,-1,314);
	}
	
	
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento." and idEstado in(1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	$etapa=$fRegistro[1];
	$idRegistro=$fRegistro[0];
	$dComp="auto";
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);
	if($actor=="")
		$actor=0;
	
	
	echo "1|".$idRegistro."|".bE($dComp)."|".bE($actor);
	
	
}

/*function generarReporteAudiencias()
{
	global $con;
	
	$arrUnidad="";
	$periodoInicial=$_POST["fechaInicio"];
	$periodoFinal=$_POST["fechaFin"];	
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='001'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"15","unidadGestion":"UGJ 1","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;		
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='002'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"16","unidadGestion":"UGJ 2","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='003'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"17","unidadGestion":"UGJ 3","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='004'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"25","unidadGestion":"UGJ 4","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//005
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa not like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa not like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"32","unidadGestion":"UGJ 5","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	
	
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='006'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"33","unidadGestion":"UGJ 6","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='007'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"34","unidadGestion":"UGJ 7","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='008'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"35","unidadGestion":"UGJ 8","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='009'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"36","unidadGestion":"UGJ 9","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa  like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa  like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$audienciasContinuacion=0;
	$listaAudienciasContinuacion="";
	
	$o1='{"idUnidadGestion":"032","unidadGestion":"Tribunal de enjuiciamiento","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$audienciasContinuacion.'","listaAudienciasContinuacion":"'.$listaAudienciasContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$audienciasContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	echo '{"numReg":"","registros":['.$arrUnidad.']}';
	
	
}
*/
function generarReporteAudiencias()
{
	global $con;
	
	$arrUnidad="";
	$periodoInicial=$_POST["fechaInicio"];
	$periodoFinal=$_POST["fechaFin"];	
	
	//UGA 1
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='001'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=15 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"15","unidadGestion":"UGJ 1","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;		
		
	//UGA 2
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	

	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='002'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=16 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=16 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=16 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"16","unidadGestion":"UGJ 2","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 3	
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='003'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=17 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"17","unidadGestion":"UGJ 3","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 4
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='004'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=25 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"25","unidadGestion":"UGJ 4","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 005
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa not like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa not like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=32 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosContinuacion++;
			if($listaEventosContinuacion=="")
				$listaEventosContinuacion=$fila[0];
			else
				$listaEventosContinuacion.=",".$fila[0];
		}
		
		
	}
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	

	
	
	$o1='{"idUnidadGestion":"32","unidadGestion":"UGJ 5","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	//UGA 6
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='006'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=33 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"33","unidadGestion":"UGJ 6","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
	
	//UGA 7
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='007'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=34 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"34","unidadGestion":"UGJ 7","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 8
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='008'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=35 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"35","unidadGestion":"UGJ 8","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
	
	//UGA 9
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='009'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=36 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"36","unidadGestion":"UGJ 9","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
		
	//Tribunal
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa  like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa  like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=32 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosContinuacion++;
			if($listaEventosContinuacion=="")
				$listaEventosContinuacion=$fila[0];
			else
				$listaEventosContinuacion.=",".$fila[0];
		}
		
		
	}
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	
	$o1='{"idUnidadGestion":"032","unidadGestion":"Tribunal de enjuiciamiento","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	echo '{"numReg":"","registros":['.$arrUnidad.']}';
	
	
}



function obtenerEventosAudienciaSGJPReporte()
{
	global $con;
	
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
					$c=" and idSala=".$filter[$x]["data"]["value"];
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
			}
		}
		
	}
	
	$listaAudiencias=$_POST["listaAudiencias"];
	
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia  
			FROM 7000_eventosAudiencia where idRegistroEvento in (".$listaAudiencias.")
			".$condiciones;
			
			
	

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
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
		$tipoAudiencia="";
		$tAudiencia="";
		switch($fila[9])
		{
			case 11:
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
			case 46:
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia,idActividad FROM _46_tablaDinamica WHERE id__46_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				$idActividad=$fDatos[2];
				
			break;
			case 185:
				$idActividad=-1;
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
				
			break;
			case 6:
				continue;
			break;
			case 5:
			case 7:
				$consulta="SELECT carpetaAdministrativa,idTipoAudiencia FROM otrasSolicitudes WHERE tipo=".$fila[9]." and idSolicitud=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
		}
		
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica=4";
		$tImputados=$con->obtenerValor($consulta);
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerCarpetasAdministrativasReporte()
{
	global $con;
	$listaCarpetas=$_POST["listaCarpetas"];

	
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
					$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				
			}
		}
		
	}
	
	
	$arrRegistro="";
	$numReg=0;
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,fechaCreacion FROM 7006_carpetasAdministrativas 
				WHERE carpetaAdministrativa in(".$listaCarpetas.") ORDER BY carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[3].'"}';
		if($arrRegistro=="")
			$arrRegistro=$o;
		else
			$arrRegistro.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
}

function obtenerResolutivosAudiencia()
{
	global $con;
	$idEventoAudiencia=$_POST["iE"];
	
	$consulta="SELECT tipoResolutivo FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEventoAudiencia;
	$tipoResolutivo=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEventoAudiencia;
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT idReferencia FROM _327_gridTiposAudiencia WHERE tipoAudiencia=".$tipoAudiencia;
	$listaResolutivos=$con->obtenerListaValores($consulta);
	if($listaResolutivos!="")
	{
		if($tipoResolutivo=="")
			$tipoResolutivo=$listaResolutivos;
		else
			$tipoResolutivo.=",".$listaResolutivos;
	}
	
	
	$consulta="SELECT DISTINCT idReferencia FROM _327_gridTiposAudiencia";
	$lAudiencias=$con->obtenerListaValores($consulta);
	if($lAudiencias=="")
		$lAudiencias=-1;
	
	
	$consulta="SELECT id__327_tablaDinamica FROM _327_tablaDinamica WHERE id__327_tablaDinamica NOT IN(".$lAudiencias.")";
	$listaResolutivos=$con->obtenerListaValores($consulta);
	if($listaResolutivos!="")
	{
		if($tipoResolutivo=="")
			$tipoResolutivo=$listaResolutivos;
		else
			$tipoResolutivo.=",".$listaResolutivos;
	}
	
	if($tipoResolutivo=="")
		$tipoResolutivo=-1;
	
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT id__327_tablaDinamica,descripcionResolutivo,tipoResultado,prioridad FROM _327_tablaDinamica 
			WHERE id__327_tablaDinamica IN(".$tipoResolutivo.") ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$consulta="SELECT idRegistro,valor,comentariosAdicionales FROM 3013_registroResolutivosAudiencia WHERE tipoResolutivo=".
				$fila[0]." AND idEvento=".$idEventoAudiencia;
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$aplicado="false";
		if($fRegistro)
		{
			$aplicado="true";
		}
		
		$o='{"aplicado":'.$aplicado.',"idResolutivo":"'.$fila[0].'","resolutivo":"'.cv($fila[1]).'","tipoValor":"'.
			$fila[2].'","prioridad":"'.$fila[3].'","valor":"'.cv($fRegistro[1]).'","comentariosAdiconales":"'.cv($fRegistro[2]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
		
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}


function guardarInformeAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	varDump($obj);
	return;
	
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="delete from 3013_registroResolutivosAudiencia where idEvento=".$obj->idEvento;
	$x++;
	foreach($obj->registros as $r)
	{
		$query[$x]="INSERT INTO 3013_registroResolutivosAudiencia(tipoResolutivo,valor,idEvento,comentariosAdicionales)  
					VALUES(".$r->idResolutivo.",'".cv($r->valor)."','".$obj->idEvento."','".cv($r->comentariosAdicionales)."')";
		$x++;
	}
	
	
	$query[$x]="commit";
	$x++;
	
	
	if($con->ejecutarBloque($query))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		echo "1|";
	}
	
	
}

function finalizarInformeEventoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT COUNT(*) FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEvento;
	$nResolutivos=$con->obtenerValor($consulta);	
	
	$consulta="SELECT COUNT(*) FROM 3014_registroMedidasCautelares WHERE idEventoAudiencia=".$idEvento;
	$nMedidas=$con->obtenerValor($consulta);	
	
	if(($nResolutivos+$nMedidas)==0)
	{
		echo "<br>Almenos debe registrar alg&uacute;n resolutivo / medida cautelar";
		return;
	}
	
	$consulta="UPDATE 3014_registroResutadoAudiencia SET situacion=1,fechaRegistro='".date("Y-m-d H:i:s")."',responsable=".$_SESSION["idUsr"]." WHERE idEvento=".$idEvento;
	eC($consulta);
}

function registrarMedidaCautelar()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	$valorComp1="";
	$valorComp2="";
	$valorComp3="";
	switch($obj->datosMedida->idMedida)
	{
		case 1:
			$valorComp1=$obj->datosMedida->autoridad;
		break;	
		case 2:
			$valorComp1=$obj->datosMedida->montoGarantia;	
			$valorComp2=$obj->datosMedida->noPagos;	
		break;	
		default:
		break;
	}
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasCautelares(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,valorComp1,valorComp2,valorComp3,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"','".cv($valorComp1)."','".cv($valorComp2)."','".cv($valorComp3)."',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasCautelares set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."',valorComp1='".cv($valorComp1)."',
				valorComp2='".cv($valorComp2)."',valorComp3='".cv($valorComp3)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}

function obtenerMedidasCautelaresActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales,
				valorComp1,valorComp2,valorComp3 FROM 3014_registroMedidasCautelares WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}

function removerMedidaCautelar()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasCautelares WHERE idRegistro=".$idMedida;
	eC($consulta);
}

function actualizarTipoAudienciaEvento()
{
	global $con;
	
	$idEvento=$_POST["iE"];
	$tipoAudiencia=$_POST["tA"];
	
	$consulta="SELECT idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if($fRegistro[1]=="")
		$fRegistro[1]=-1;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE 7000_eventosAudiencia SET tipoAudiencia=".$tipoAudiencia." WHERE idRegistroEvento=".$idEvento;
	$x++;
	switch($fRegistro[0])
	{
		case 46:
			$query[$x]="UPDATE _46_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__46_tablaDinamica=".$fRegistro[1];
			$x++;
		break;
		case 185:
			$query[$x]="UPDATE _185_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__185_tablaDinamica=".$fRegistro[1];
			$x++;
			
			$consulta="SELECT iFormulario,iRegistro FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fRegistro[1];
			$fPromocion=$con->obtenerPrimeraFila($consulta);
			if($fPromocion[1]=="")
				$fPromocion[1]=-1;
			
			if($fPromocion[0]==96)
			{
				$query[$x]="UPDATE _96_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__96_tablaDinamica=".$fPromocion[1];
				$x++;
				
			}
			
			
		break;
	}
	
	
	$query[$x]="commit";
	$x++;	
	eB($query);
}

function obtenerRegistroRemisionUGA()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__329_tablaDinamica,idEstado FROM _329_tablaDinamica WHERE carpetaAdministrativa='".$cA."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(295);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(329);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function guardarModificacionHoraDesarrolloAudiencia()
{
	global $con;
	$idEvento=$_POST["iE"];
	$hInicio=$_POST["hInicio"];
	$hFin=$_POST["hFin"];
	
	
	$consulta="SELECT horaInicioReal,horaTerminoReal,respHorarioReal FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fDatosAudiencia=$con->obtenerPrimeraFila($consulta);
	
	
	if($fDatosAudiencia[0]=="")
	{
		$consulta="UPDATE 7000_eventosAudiencia SET horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"]." WHERE idRegistroEvento=".$idEvento;
	}
	else
	{
		if($fDatosAudiencia[2]=="0")
		{
			$consulta="UPDATE 7000_eventosAudiencia SET horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"].",horaInicioRealMAJO=horaInicioReal,horaTerminoRealMAJO=horaTerminoReal 
					WHERE idRegistroEvento=".$idEvento;
		}
		else
		{
			$consulta="UPDATE 7000_eventosAudiencia SET horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"]." WHERE idRegistroEvento=".$idEvento;
		}
	}
	
	
	eC($consulta);
	
	
	
}

function obtenerRegistroTribunalEnjuiciamiento()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__320_tablaDinamica,idEstado FROM _320_tablaDinamica WHERE carpetaAdministrativa='".$cA."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(301);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(320);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerRegistroEjecucion()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__316_tablaDinamica,idEstado FROM _316_tablaDinamica WHERE carpetaAdministrativa='".$cA."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(297);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(316);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerMedidasProteccionActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales
				 FROM 3014_registroMedidasProteccion WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}


function obtenerMedidasSuspensionCondicionalActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales
				 FROM 3014_registroMedidasSuspencionCondicional WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}

function registrarMedidaProteccion()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasProteccion(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasProteccion set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}

function registrarMedidaSuspension()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasSuspencionCondicional(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasSuspencionCondicional set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}


function removerMedidaProteccion()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasProteccion WHERE idRegistro=".$idMedida;
	eC($consulta);
}


function removerCondicionSuspension()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasSuspencionCondicional WHERE idRegistro=".$idMedida;
	eC($consulta);
}

?>