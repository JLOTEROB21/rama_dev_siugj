<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");
	include_once("sgjp/funcionesInterconexionSGJ.php");
	include_once("sgjp/cSendMail.php");
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerOrdenesNotificacion();
		break;
		case 2:
			obtenerAudienciasCarpetaJudicial();
		break;
		case 3:
			obtenerDocumentosNotificacion();
		break;
		case 4:
			registrarSolicitudNotificacion();
		break;
		case 5:
			removerSolicitudNotificacion();
		break;
		case 6:
			agregarDocumentosSolicitudNotificacion();
		break;
		case 7:
			removerDocumentosSolicitudNotificacion();
		break;
		case 8:
			registrarDocumentoAdjuntoCarpetaAdministrativaSolicitudNotificacion();
		break;
		case 9:
			enviarOdenAJUDNotificadores();
		break;
		case 10:
			obtenerOrdenesNotificacionProceso();
		break;
		case 11:
			obtenerDocumentosprocesoNotificacion();
		break;
		case 12:
			registrarDocumentoAdjuntoReferenciaProcesoSolicitudNotificacion();
		break;
		case 13:
			obtenerDatosSolicitudNotificacion();
		break;
		case 14:
			obtenerNotificadoresAsignados();
		break;
		case 15:
			obtenerNotificadoresDisponibles();
		break;
		case 16:
			registrarAsignacionNotificadorOrden();
		break;
		case 17:
			obtenerOrdenesNotificacionJUDNotificadores();
		break;
		case 18:
			obtenerOrdenesNotificacionNotificadores();
		break;
		case 19:
			obtenerPartesProcesalesCarpetas();
		break;
		case 20:
			agregarPartesProcesalesCarpeta();
		break;
		case 21:
			obtenerMediosNotificacion();
		break;
		case 22:
			generarDiligenciaNotificacion();
		break;
		case 23:
			registrarDiligenciaNotificacion();
		break;
		case 24:
			obtenerDiligenciasOrdenNotificicacion();
		break;
		case 25:
			obtenerActaAperturadaNotificacion();
		break;
		case 26:
			cerrarActaNotificacion();
		break;
		case 27:	
			obtenerDatosSolicitudNotificacionNotificador();
		break;
		case 28;
			agregarCorreoElectonicoNotificacion();
		break;
		case 29:
			obtenerTextoNotificacionMail();
		break;
		case 30:
			registrarConfiguracionSMTP();
		break;
		case 31:
			obtenerConfiguracionSMTP();
		break;
		case 32:
			modificarDatosPartesProcesalesCarpeta();
		break;
		case 33:
			agregarTelefonoNotificacion();
		break;
		case 34:
			obtenerDocumentosOrdenNotificacion();
		break;
		case 35:
			enviarMailNotificacion();
		break;
		case 36:
			obtenerCorreosEnviados();
		break;
		case 37:
			obtenerBuzonesCorreos();
		break;
		case 38:
			obtenerCorreosBuzon();
		break;
		case 39:
			obtenerDocumentoAdjuntoMail();
		break;
		case 40:
			obtenerPartesProcesalesCarpetasNotificacion();
		break;
		case 41:
			cerrarOrdenNotificacion();
		break;
		case 42:
			reenviarDiligenciaCentralNotificadores();
		break;
		case 43:
			modificarDatosPartesProcesalesExpediente();
		break;
	}

function obtenerOrdenesNotificacion()
{
	global $con;
	$iU=$_POST["iU"];
	$situacion=$_POST["situacion"];
	
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	$consulta="SELECT o.idOrden,folioOrden,carpetaJudicial,o.idCarpeta,fechaRegistro,tipoNotificacion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=o.idResponsable) AS solicitadoPor, 
				o.situacion,(SELECT group_concat(concat('(',DATE_FORMAT(fechaAsignacion,'%d/%m/%Y %H:%i'),') ',nombre) separator '<br>') FROM 800_usuarios u,3020_responsablesTareas r WHERE iFormulario=-7042 AND 
				iRegistro=o.idOrden and idUsuario=r.responsableTarea order by fechaAsignacion) AS notificadorAsignado,comentariosAdicionales,
				
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion, fechaDeterminacion,nombreDeterminacion,idEventoDeriva FROM 7042_ordenesNotificacion o,7006_carpetasAdministrativas c 
				WHERE c.carpetaAdministrativa=o.carpetaJudicial and o.situacion in(".$situacion.") and c.unidadGestion='".$iU."' and ".$cadCondWhere." ORDER BY idOrden";

	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';		
}

function obtenerAudienciasCarpetaJudicial()
{
	global $con;
	$cA=$_POST["cA"];
	$iC=$_POST["iC"];
	$consulta="SELECT idRegistroEvento,CONCAT(DATE_FORMAT(horaInicioEvento,'%d/%m/%Y - %H:%i'),', ',t.tipoAudiencia ) AS tipoAudiencia,fechaEvento 
			FROM 7007_contenidosCarpetaAdministrativa c, 7000_eventosAudiencia e,_4_tablaDinamica t 
			WHERE carpetaAdministrativa='".$cA."' and c.idCarpetaAdministrativa in(-1,".$iC.") AND e.idRegistroEvento=c.idRegistroContenidoReferencia
			AND t.id__4_tablaDinamica=e.tipoAudiencia AND c.tipoContenido=3 AND e.situacion IN(1,2,4,5,6) ORDER BY horaInicioEvento";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);	
	echo "1|".$arrAudiencias."";
}

function obtenerDocumentosNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	
	
	$nRegistros=0;
	$arrRegistros="";
	
	$consulta="SELECT idDocumento FROM 7043_documentosNotificacion WHERE idOrden=".$iO;
	
	$resDocumentos=$con->obtenerFilas($consulta);
	while($fDocumento=mysql_fetch_row($resDocumentos))
	{
		$consulta="SELECT nomArchivoOriginal,tamano,fechaCreacion FROM 908_archivos WHERE idArchivo=".$fDocumento[0];
		$fArchivo=$con->obtenerPrimeraFila($consulta);
		if(!$fArchivo)
			continue;
		$arrDatosArchivo=explode(".",$fArchivo[0]);
		$consulta="SELECT * FROM 9049_visoresDocumentos WHERE extension='".$arrDatosArchivo[sizeof($arrDatosArchivo)-1]."'";
		$fConfiguracionVisor=$con->obtenerPrimeraFila($consulta);
		
		if(strlen($arrDatosArchivo[0])>18)		
			$nombreDocumentoCorto=mb_substr($arrDatosArchivo[0],0,12)."...(".$arrDatosArchivo[1].")";
		else
			$nombreDocumentoCorto=$arrDatosArchivo[0]." (".$arrDatosArchivo[1].")";
		
		
		
		$o='{"idDocumento":"'.$fDocumento[0].'","nombreDocumento":"'.cv(($fArchivo[0])).'","nombreDocumentoCorto":"'.cv(($nombreDocumentoCorto)).'","tamanoDocumento":"'.bytesToSize($fArchivo[1],0).'","fechaDocumento":"'.date("d/m/Y H:i",strtotime($fArchivo[2])).' hrs.","extension":"'.strtolower($arrDatosArchivo[1]).'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$nRegistros++;
	}
	
	
	echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';
}

function registrarSolicitudNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="";
	if($obj->idOrden==-1)
	{
		$consulta="INSERT INTO 7042_ordenesNotificacion(carpetaJudicial,idCarpeta,fechaRegistro,tipoNotificacion,idEventoDeriva,nombreDeterminacion,
					idResponsable,situacion,comentariosAdicionales,fechaDeterminacion,iFormulario,iRegistro) VALUES
					('".$obj->carpetaJudicial."',".$obj->idCarpeta.",'".date("Y-m-d H:i:s")."',".$obj->tipoNotificacion.",".
					($obj->idEventoAudiencia==""?"NULL":$obj->idEventoAudiencia).",'".cv($obj->nombreDeterminacion)."',".$_SESSION["idUsr"].
					",1,'".cv($obj->comentariosAdicionales)."',".($obj->fechaDeterminacion==""?"NULL":"'".$obj->fechaDeterminacion."'").
					",".(isset($obj->idFormulario)?$obj->idFormulario:"NULL").",".(isset($obj->idRegistro)?$obj->idRegistro:"NULL").")";
	}
	else
	{
		$consulta="update 7042_ordenesNotificacion set carpetaJudicial='".$obj->carpetaJudicial."',idCarpeta=".$obj->idCarpeta.",tipoNotificacion=".
					$obj->tipoNotificacion.",idEventoDeriva=".($obj->idEventoAudiencia==""?"NULL":$obj->idEventoAudiencia).
					",nombreDeterminacion='".cv($obj->nombreDeterminacion)."',comentariosAdicionales='".cv($obj->comentariosAdicionales).
					"',fechaDeterminacion=".($obj->fechaDeterminacion==""?"NULL":"'".$obj->fechaDeterminacion."'")." where idOrden=".$obj->idOrden;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$folio="";
		$idOrden=$obj->idOrden;
		if($idOrden==-1)
		{
			$idOrden=$con->obtenerUltimoID();
			$folio= generarFolioProcesos(-7042,$idOrden);
			$consulta="UPDATE 7042_ordenesNotificacion SET folioOrden='".$folio."' WHERE idOrden=".$idOrden;
			$con->ejecutarConsulta($consulta);
			
		}
		echo "1|".$idOrden."|".$folio;
	}
	
	
	
}

function removerSolicitudNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="DELETE FROM 7042_ordenesNotificacion WHERE idOrden=".$iO;
	$x++;
	$consulta[$x]="DELETE FROM 7043_documentosNotificacion WHERE idOrden=".$iO;
	$x++;
	$consulta[$x]="DELETE FROM 7028_actaNotificacion WHERE idOrden=".$iO;
	$x++;
	$consulta[$x]="DELETE FROM 7030_documentosAdjuntosDiligencia WHERE idDiligencia 
				IN(SELECT idRegistro FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$iO.")";
	$x++;
	$consulta[$x]="DELETE FROM 7030_medioNotificacionDiligencia WHERE idDiligencia IN(SELECT idRegistro 
				FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$iO.")";
	$x++;
	$consulta[$x]="DELETE FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$iO;
	$x++;
	
	



	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
	
	

}

function agregarDocumentosSolicitudNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$arrDocumentos=explode(",",$obj->listaDocumentos);
	foreach($arrDocumentos as $d)
	{
		$query="SELECT count(*) FROM 7043_documentosNotificacion WHERE idOrden=".$obj->idOrden." AND idDocumento=".$d;
		$nReg=$con->obtenerValor($query);
		if($nReg==0)
		{
			$consulta[$x]="INSERT INTO 7043_documentosNotificacion(idOrden,idDocumento) VALUES(".$obj->idOrden.",".$d.")";
			$x++;
		}
	}
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
	
	
}

function  removerDocumentosSolicitudNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	$iD=$_POST["iD"];
	$consulta="DELETE FROM 7043_documentosNotificacion WHERE idOrden=".$iO." AND idDocumento=".$iD;
	eC($consulta);
}

function registrarDocumentoAdjuntoCarpetaAdministrativaSolicitudNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);

	if(($idDocumento!=-1)&&(!isset($obj->esDocumentoAdjuntoMail)))
	{
		if(registrarDocumentoCarpetaAdministrativa($obj->carpetaAdministrativa,$idDocumento))
		{
			if(!isset($obj->noDocumentoNotificacion))
			{
				$consulta="INSERT INTO 7043_documentosNotificacion(idOrden,idDocumento) VALUES(".$obj->idOrden.",".$idDocumento.")";
				$con->ejecutarConsulta($consulta);
			}
			echo "1|".$idDocumento."|".$obj->nombreArchivo;
		}
	}
	else
	{
		if($idDocumento!=-1)
		{
			$consulta="INSERT INTO 908_documentosAdjuntosNoCarpeta(idDocumento,idUsuario) VALUES(".$idDocumento.",".$_SESSION["idUsr"].")";
			$con->ejecutarConsulta($consulta);
			echo "1|".$idDocumento."|".$obj->nombreArchivo;
		}
		else
			echo "0|No se pudo guardar el documento";
	}
	
	
	
}

function enviarOdenAJUDNotificadores()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="UPDATE 7042_ordenesNotificacion SET situacion=2,fechaEnvioJUDRegistro='".date("Y-m-d H:i:s")."' WHERE idOrden=".$obj->idOrden;
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="SELECT carpetaJudicial,idCarpeta FROM 7042_ordenesNotificacion WHERE idOrden=".$obj->idOrden;
		$fCarpeta=$con->obtenerPrimeraFila($consulta);		
		$arrDestinatarios=obtenerTitularPuestoCarpeta($fCarpeta[0],$fCarpeta[1],"38_0");

		foreach($arrDestinatarios as $d)
		{
			registrarNotificacionOrdenNotificacion(4,"Nueva orden de notificación recibida",$d->idUsuarioDestinatario,"38_0",$fCarpeta[0],$_SESSION["idUsr"],"",$obj->idOrden);
		}
		echo "1";
	}
}

function obtenerOrdenesNotificacionProceso()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$situacion=$_POST["situacion"];
	$complementario="";
	$carpetaAdministrativa="";
	if(isset($_POST["carpetaAdministrativa"]))
	{
		$complementario.=" and carpetaJudicial='".$_POST["carpetaAdministrativa"]."'";
		if(isset($_POST["idCarpeta"]) &&($_POST["idCarpeta"]!=-1))
			$complementario." AND idCarpeta=".$_POST["idCarpeta"];	
	}
	
	

	
	$consulta="SELECT o.idOrden,folioOrden,carpetaJudicial,o.idCarpeta,fechaRegistro,tipoNotificacion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=o.idResponsable) AS solicitadoPor, 
				o.situacion,(SELECT group_concat(concat('(',DATE_FORMAT(fechaAsignacion,'%d/%m/%Y %H:%i'),') ',nombre) separator '<br>') FROM 800_usuarios u,3020_responsablesTareas r WHERE iFormulario=-7042 AND 
				iRegistro=o.idOrden and idUsuario=r.responsableTarea order by fechaAsignacion) AS notificadorAsignado,comentariosAdicionales,
				
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion, fechaDeterminacion,nombreDeterminacion,idEventoDeriva,
				(SELECT group_concat(f.idDocumento) FROM 3000_formatosRegistrados f,7028_actaNotificacion a WHERE f.idFormulario=-1 
				AND f.idRegistro=a.idRegistro AND f.firmado=1 AND a.idOrden=o.idOrden) as actasFirmadas
				 FROM 7042_ordenesNotificacion o
				WHERE  iFormulario=".$idFormulario." and iRegistro=".$idRegistro.$complementario." and o.situacion in(".$situacion.") ORDER BY idOrden";

	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';		
}

function obtenerDocumentosprocesoNotificacion()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];

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
		
	$numReg=0;
	$arrRegistros="";
	
		
	$consulta="select distinct * from (SELECT ".$idFormulario.",".$idRegistro.",(SELECT fechaCreacion FROM 908_archivos WHERE idArchivo=d.idDocumento)as fechaRegistro,idDocumento FROM 
				9074_documentosRegistrosProceso d WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro."
			union
				SELECT ".$idFormulario.",".$idRegistro.",(SELECT fechaCreacion FROM 908_archivos WHERE idArchivo=f.idDocumento)as fechaRegistro,idDocumento FROM 
				7035_informacionDocumentos i,3000_formatosRegistrados f WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro.
				" AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro	AND (documentoBloqueado=1 or situacionActual=50)) as tmp order by fechaRegistro";

	$rDocumentos=$con->obtenerFilas($consulta);
	while($fDocumentos=mysql_fetch_row($rDocumentos))
	{
		if($fDocumentos[3]=="")
			continue;
		$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fDocumentos[3]." and ".$cadCondWhere;

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
			
			$o='{"fechaRegistro":"'.date("Y-m-d",strtotime($fDocumentos[2])).'","idDocumento":"'.$fDatosDocumento[0].'","etapaProcesal":"0","nomArchivoOriginal":"'.cv($nomArchivoOriginal).'","tamano":"'.$fDatosDocumento[8].
				'","fechaCreacion":"'.$fDatosDocumento[2].'","descripcion":"'.cv($fDatosDocumento[11]).'","categoriaDocumentos":"'.$fDatosDocumento[12].
				'","idFormulario":"'.$fDocumentos[0].'","idRegistro":"'.$fDocumentos[1].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		
			$numReg++;	
		}
			
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function registrarDocumentoAdjuntoReferenciaProcesoSolicitudNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);
	
	if($idDocumento!=-1)
	{
		if(registrarDocumentoReferenciaProceso($obj->idFormulario,$obj->idRegistro,$idDocumento))
		{
			if(!isset($obj->noDocumentoNotificacion))
			{
				$consulta="INSERT INTO 7043_documentosNotificacion(idOrden,idDocumento) VALUES(".$obj->idOrden.",".$idDocumento.")";
				$con->ejecutarConsulta($consulta);
			}
			echo "1|".$idDocumento."|".$obj->nombreArchivo;
		}
	}
	echo "";
	
	
}

function obtenerDatosSolicitudNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	$consulta="SELECT idOrden,folioOrden,carpetaJudicial,tipoNotificacion,idEventoDeriva,nombreDeterminacion,comentariosAdicionales,
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia 
								AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion,fechaDeterminacion FROM 7042_ordenesNotificacion o WHERE idOrden=".$iO;
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	
	echo "1|".$arrRegistros;
}

function obtenerNotificadoresAsignados()
{
	global $con;
	$idOrden=$_POST["idOrden"];
	
	$consulta="SELECT responsableTarea AS idNotificador,(SELECT nombre FROM 800_usuarios WHERE idUsuario=r.responsableTarea) AS notificador,fechaAsignacion,comentariosAdicionales 
				FROM 3020_responsablesTareas  r WHERE iFormulario=-7042 AND iRegistro=".$idOrden." ORDER BY fechaAsignacion";
				
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';	
}

function obtenerNotificadoresDisponibles()
{
	global $con;
	$idOrden=$_POST["idOrden"];
	$consulta="SELECT carpetaJudicial,idCarpeta FROM 7042_ordenesNotificacion WHERE idOrden=".$idOrden;
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fCarpeta[0]."' AND idCarpeta=".$fCarpeta[1];
	$unidadGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT u.idUsuario,u.Nombre FROM 807_usuariosVSRoles ur,800_usuarios u,801_adscripcion a 
				WHERE idRol='32_0' AND u.idUsuario=ur.idUsuario and u.cuentaActiva=1 AND a.idUsuario=u.idUsuario 
				AND a.Institucion='".$unidadGestion."' AND u.idUsuario NOT IN(SELECT responsableTarea FROM 3020_responsablesTareas 
				WHERE iFormulario=-7042 AND iRegistro=".$idOrden.") ORDER BY u.Nombre";
				
	$arrRegistros=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrRegistros;
}

function registrarAsignacionNotificadorOrden()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$query="SELECT COUNT(*) FROM 3020_responsablesTareas WHERE iFormulario=-7042 AND iRegistro=".$obj->idOrden." AND responsableTarea=".$obj->idNotificador;
	$nReg=$con->obtenerValor($query);
	if($nReg>0)
	{
		echo "1|";
		return;
	}
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="UPDATE 7042_ordenesNotificacion SET situacion=3 WHERE idOrden=".$obj->idOrden;
	$x++;
	$consulta[$x]="INSERT INTO 3020_responsablesTareas(iFormulario,iRegistro,responsableTarea,comentariosAdicionales,fechaAsignacion) 
				VALUES(-7042,".$obj->idOrden.",".$obj->idNotificador.",'".cv($obj->comentariosAdicionales)."','".date("Y-m-d H:i:s")."')";
	$x++;
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		$query="SELECT carpetaJudicial,idCarpeta FROM 7042_ordenesNotificacion WHERE idOrden=".$obj->idOrden;
		$fCarpeta=$con->obtenerPrimeraFila($query);	
		registrarNotificacionOrdenNotificacionNotificador(4,"Nueva orden de notificación recibida",$obj->idNotificador,"32_0",$fCarpeta[0],$_SESSION["idUsr"],"38_0",$obj->idOrden);
		echo "1|";
	}
		
}

function obtenerOrdenesNotificacionJUDNotificadores()
{
	global $con;
	$iU=$_POST["iU"];
	$situacion=$_POST["situacion"];
	
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	$consulta="SELECT o.idOrden,folioOrden,carpetaJudicial,o.idCarpeta,fechaEnvioJUDRegistro ,tipoNotificacion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=o.idResponsable) AS solicitadoPor, 
				o.situacion,(SELECT group_concat(concat('(',DATE_FORMAT(fechaAsignacion,'%d/%m/%Y %H:%i'),') ',nombre) separator '<br>') FROM 800_usuarios u,3020_responsablesTareas r WHERE iFormulario=-7042 AND 
				iRegistro=o.idOrden and idUsuario=r.responsableTarea order by fechaAsignacion) AS notificadorAsignado,o.comentariosAdicionales,
				
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion, fechaDeterminacion,nombreDeterminacion,idEventoDeriva,
				(SELECT group_concat(f.idDocumento) FROM 3000_formatosRegistrados f,7028_actaNotificacion a WHERE f.idFormulario=-1 
				AND f.idRegistro=a.idRegistro AND f.firmado=1 AND a.idOrden=o.idOrden) as actasFirmadas 
				
				FROM 7042_ordenesNotificacion o,7006_carpetasAdministrativas c 
				WHERE c.carpetaAdministrativa=o.carpetaJudicial and o.situacion in(".$situacion.
				") and c.unidadGestion='".$iU."' and ".$cadCondWhere." ORDER BY idOrden desc";

	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';		
}

function obtenerOrdenesNotificacionNotificadores()
{
	global $con;
	$iU=$_POST["iU"];
	$situacion=$_POST["situacion"];
	$idUsuario=$_POST["iUsr"];
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	$consulta="SELECT o.idOrden,folioOrden,carpetaJudicial,o.idCarpeta,r.fechaAsignacion,tipoNotificacion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=o.idResponsable) AS solicitadoPor, 
				o.situacion,(SELECT nombre FROM 800_usuarios WHERE idUsuario=r.responsableTarea) AS notificadorAsignado,r.comentariosAdicionales,
				
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion, fechaDeterminacion,nombreDeterminacion,idEventoDeriva,
				(SELECT group_concat(f.idDocumento) FROM 3000_formatosRegistrados f,7028_actaNotificacion a WHERE f.idFormulario=-1 
				AND f.idRegistro=a.idRegistro AND f.firmado=1 AND a.idOrden=o.idOrden) as actasFirmadas 
				 
				FROM 7042_ordenesNotificacion o,7006_carpetasAdministrativas c, 3020_responsablesTareas r
				WHERE r.iFormulario=-7042 AND r.iRegistro=o.idOrden AND responsableTarea=".$idUsuario." 
				and c.carpetaAdministrativa=o.carpetaJudicial and o.situacion in(".$situacion.") and c.unidadGestion='".$iU."' 
				and ".$cadCondWhere."  ORDER BY idOrden desc";

	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';		
}

function obtenerPartesProcesalesCarpetas()
{
	global $con;
	global $tipoMateria;
	$iC=$_POST["iC"];
	$cA=$_POST["cA"];
	$iA=-1;
	$iP=-1;
	if(isset($_POST["iA"]))
		$iA=$_POST["iA"];
	if(isset($_POST["iP"]))
		$iP=$_POST["iP"];
	$iO=-1;
	$moduloNotificaciones=0;
	if(isset($_POST["moduloNotificaciones"]))
		$moduloNotificaciones=1;
	
	
	
	$check=0;
	if(isset($_POST["check"]))
		$check=1;
	if(isset($_POST["iO"]))
		$iO=$_POST["iO"];
	
	
	$consulta="SELECT COUNT(*) FROM _17_tablaDinamica u,7006_carpetasAdministrativas c,_17_gridDelitosAtiende g WHERE claveUnidad=c.unidadGestion
				AND c.carpetaAdministrativa='".$cA."' AND g.idReferencia=u.id__17_tablaDinamica AND g.tipoDelito IN('D','EA')";
	$carpetaAdolescentes=$con->obtenerValor($consulta);
	
	$carpetaAdolescentes=$carpetaAdolescentes>0;
	
	$sujetosProcesales="";
	if(isset($_POST["sujetosProcesales"]))
		$sujetosProcesales=$_POST["sujetosProcesales"];
	
	if($iA==-1)
	{	
		$consulta="SELECT idFormulario,idRegistro,idActividad FROM 7006_carpetasAdministrativas 
					WHERE carpetaAdministrativa='".$cA."'";
					
		if($iC!=-1)
			$consulta.=" and idCarpeta in(".$iC.")";
		
		$fCarpeta=$con->obtenerPrimeraFila($consulta);
		
		$idActividad=$fCarpeta[2];
		if(($fCarpeta[2]=="")||($fCarpeta[2]==-1))
		{
			$consulta="SELECT idActividad FROM _".$fCarpeta[0]."_tablaDinamica WHERE id__".$fCarpeta[0]."_tablaDinamica=".$fCarpeta[1];
			$idActividad=$con->obtenerValor($consulta);
		}
	}
	else
		$idActividad=$iA;
	
	$arrFiguras="";
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombrePlural FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombrePlural FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."')) as etiquetaPlural 
	
	 FROM _5_tablaDinamica t".(($sujetosProcesales!="")?" where id__5_tablaDinamica in(".
			$sujetosProcesales.")":"")." ORDER BY codigo";
	if($carpetaAdolescentes)
	{
		$consulta="SELECT id__5_tablaDinamica,if(id__5_tablaDinamica=4,'Adolescentes',etiquetaPlural) FROM _5_tablaDinamica ".(($sujetosProcesales!="")?" where id__5_tablaDinamica in(".
			$sujetosProcesales.")":"")." ORDER BY codigo";
	}
	$rFiguras=$con->obtenerFilas($consulta);

	while($fFiguras=mysql_fetch_row($rFiguras))
	{
		$arrPersonas="";
		$consulta="SELECT id__47_tablaDinamica,tipoPersona,upper(apellidoPaterno),upper(apellidoMaterno),upper(nombre),tipoDefensor,r.situacion FROM _47_tablaDinamica p,
					7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica and r.idActividad=".$idActividad."	
					and r.idFiguraJuridica=".$fFiguras[0]." and r.cuentaAccesoGenerica=0 order by nombre,apellidoPaterno,apellidoMaterno";
		
		$rPersona=$con->obtenerFilas($consulta);
		while($fPersona=mysql_fetch_row($rPersona))
		{
			$arrRelaciones="";
			$consulta="SELECT id__47_tablaDinamica,tipoPersona,upper(apellidoPaterno),upper(apellidoMaterno),upper(nombre),r.situacion FROM 7005_relacionParticipantes r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad."	AND idParticipante=".$fPersona[0].
					" AND r.idFiguraJuridica=".$fFiguras[0]." and p.id__47_tablaDinamica=r.idActorRelacionado";
			$rRelacion=$con->obtenerFilas($consulta);		
			while($fRelacion=mysql_fetch_row($rRelacion))
			{
				
				$iconoRel="bullet_green.png";
				
				$texto=$fRelacion[4]." ".$fRelacion[2]." ".$fRelacion[3];
				if($fRelacion[5]==2)
				{
					$texto="<span style='color:#777;'><i>(Eliminado) ".$texto."</i></span>";
					$iconoRel="bullet_red.png";
				}
				else
				{
					if($fRelacion[5]==0)
					{
						$texto="<span style='color:#900;'><i>(Inactivo) ".$texto."</i></span>";
						$iconoRel="bullet_white.png";
					}
				}
				$oRelacion='{'.($moduloNotificaciones==1?('"cls":"cssNodoParticipante",'):"").'"id":"r_'.$fRelacion[0].'_'.$fPersona[0].'","icon":"../images/'.$iconoRel.'","tipo":"5","text":"'.cv($texto).'","nombre":"'.cv($fRelacion[4]." ".$fRelacion[2]." ".$fRelacion[3]).'","idPersona":"'.$fRelacion[0].
							'","leaf":true,"situacion":"'.$fRelacion[5].'"}';
				
				if($arrRelaciones=="")
					$arrRelaciones=$oRelacion;
				else
					$arrRelaciones.=",".$oRelacion;
				
				
			}
			
			$comp='"leaf":true';
			if($arrRelaciones!="")
			{
				$comp='"leaf":false,expanded:true,"children":['.$arrRelaciones.']';
			}
			
			$icono="user.png";
			if($fPersona[1]!=1)
			{
				$icono="chart_organisation.png";
			}
			$id='p_'.$fPersona[0]."_".$fFiguras[0];
			
			$iconAsistencia="";
			
			if($check==1)
			{
				if($iP!=-1)
				{
					$consulta="SELECT COUNT(*) FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad.
							" AND idParticipante=".$iP." AND idActorRelacionado=".$fPersona[0];
					$nReg=$con->obtenerValor($consulta);
					$comp.=",checked:".($nReg>0?"true":"false");
				}
				else
					$comp.=",checked:false";
			}
			$texto=$fPersona[4]." ".$fPersona[2]." ".$fPersona[3].($fPersona[5]==1?' (P&uacute;blico)':($fPersona[5]==2?' (Privado)':''));
			if($fPersona[6]==2)
			{
				$texto="<span style='color:#777;'><i>(Eliminado) ".$texto."</i></span>";
			}
			else
				{
					if($fPersona[6]==0)
					{
						$texto="<span style='color:#900;'>(Inactivo) ".$texto."</span>";
						
					}
				}
			$mails="";	
			$cadObj=obtenerUltimoDomicilioFiguraJuridica($fPersona[0]);	
			$obj=json_decode($cadObj);
			
			foreach($obj->correos as $mail)
			{
				if($mails=="")
					$mails=$mail->mail;
				else
					$mails.=",".$mail->mail;
			}
			
			
			$iconoNodo='"icon":"../images/'.$icono.'",';
			//if($moduloNotificaciones==1)
				$iconoNodo='"icon":"../images/s.gif",';
			
			
			
			$oP='{"cls":"cssNodoParticipante","idPersona":"'.$fPersona[0].'",'.$iconoNodo.'"personaJuridica":"'.$fFiguras[0].'","tipo":"1","nombre":"'.cv($fPersona[4]." ".$fPersona[2]." ".
				$fPersona[3]).'","situacion":"'.$fPersona[6].'","detalleFigura":"'.$fPersona[5].'","id":"'.$id.
				'","text":"'.cv($texto).'","mail":"'.$mails.'",'.$comp.'}';
			if($arrPersonas=="")
				$arrPersonas=$oP;
			else
				$arrPersonas.=",".$oP;
		}
		
		if($arrPersonas!="")
		{
			$icono='"icon":"../images/bullet_green.png",';
			//if($moduloNotificaciones==1)
				$icono='"icon":"../images/s.gif","iconCls":"cssNodoParticipanteImagen",';
			
			$o='{"cls":"cssNodoTipoParticipante","tipo":"0","expanded":true,'.$icono.'"id":"f_'.$fFiguras[0].'","text":"'.cv($fFiguras[1]).'","leaf":false,children:['.$arrPersonas.']}';
			if($arrFiguras=="")
				$arrFiguras=$o;
			else
				$arrFiguras.=",".$o;
		}
	}
	
	if($iO!="-1")
	{
		$arrActas="";
		$consulta="SELECT f.idDocumento FROM 3000_formatosRegistrados f,7028_actaNotificacion a WHERE f.idFormulario=-1 AND f.idRegistro=a.idRegistro AND f.firmado=1 AND
				a.idOrden=".$iO;
		$rActas=$con->obtenerFilas($consulta);
		while($fActa=mysql_fetch_row($rActas))
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fActa[0];
			$nombreArchivo=$con->obtenerValor($consulta);
			$oActa='{"id":"acta_'.$fActa[0].'","idDocumento":"'.$fActa[0].'","text":"'.cv($nombreArchivo).'","nombreDocumento":"'.cv($nombreArchivo).
				'","icon":"../imagenesDocumentos/16/file_extension_pdf.png","tipo":"3",leaf:true}';
			if($arrActas=="")
				$arrActas=$oActa;
			else
				$arrActas.=",".$oActa;
		}
		
		$o='{"tipo":"2","expanded":true,"icon":"../s.gif","id":"f_-10","text":"<span style=\'color:#000; font-weight:bold\'>--- Actas firmadas ---</span>","leaf":false';
		if($arrActas=="")
			$o.=',"leaf":true}';
		else
			$o.=',"leaf":false,"children":['.$arrActas.']}';
		if($arrFiguras=="")
			$arrFiguras=$o;
		else
			$arrFiguras.=",".$o;
	}
	echo '['.$arrFiguras.']';
	
}


function agregarPartesProcesalesCarpeta()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$cadObj=str_replace("undefined","",$cadObj);	
	$obj=json_decode($cadObj);

	$idActividad=-1;
	if(isset($obj->idActividad))
		$idActividad=$obj->idActividad;
	if(isset($obj->idCarpeta) && ($obj->idCarpeta!=-1))
	{
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$obj->idCarpeta;
		$idActividad=$con->obtenerValor($consulta);
		if($idActividad=="")
			$idActividad=-1;
	}
		
	if($idActividad==-1)
	{
		$idActividad=generarIDActividad(-7042);
		$consulta="UPDATE 7006_carpetasAdministrativas SET idActividad=".$idActividad." WHERE idCarpeta=".$obj->idCarpeta;
		$con->ejecutarConsulta($consulta);
		
		
	}
	
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$cedulaProfesional="NULL";
	if(isset($obj->cedulaProfesional)&&($obj->cedulaProfesional!=""))
	{
		$cedulaProfesional=$obj->cedulaProfesional;
	}
	
	$fechaNacimiento="NULL";
	if(isset($obj->fechaNacimiento)&&($obj->fechaNacimiento!=""))
	{
		$fechaNacimiento="'".$obj->fechaNacimiento."'";
	}
	
	$edad="NULL";
	if(isset($obj->edad)&&($obj->edad!=""))
	{
		$edad=$obj->edad;
	}
	
	$query[$x]="INSERT INTO _47_tablaDinamica(tipoPersona,apellidoPaterno,apellidoMaterno,nombre,genero,otraNacionalidad,esMexicano,idActividad,
			figuraJuridica,tipoDefensor,curp,cedulaProfesional,rfcEmpresa,fechaNacimiento,edad,estadoCivil,tipoIdentificacion,
			otraIdentificacion,folioIdentificacion,nacionalidad,grupoEtnico,discapacidad,aceptaNotificacionMail,tarjetaProfesional,
			fechaIdentificacion,tipoEntidad,desconoceNIT,desconoceIdentificacion,desconoceDomicilio,busquedaWS) 
			VALUES(".$obj->tipoPersona.",'".cv(trim($obj->apPaterno))."','".cv(trim($obj->apMaterno))."','".cv(trim($obj->nombre))."',
			".$obj->genero.",'".cv($obj->otraNacionalidad)."',".$obj->nacionalidadMexicana.",".$idActividad.",".$obj->tipoFigura.
			",".($obj->detallePersona==""?"NULL":$obj->detallePersona).",'".cv(isset($obj->curp)?$obj->curp:"")."',".$cedulaProfesional.
			",'".cv(isset($obj->rfc)?$obj->rfc:"")."',".$fechaNacimiento.",".$edad.
			",'".(isset($obj->estadoCivil)?$obj->estadoCivil:"")."','".(isset($obj->identificacionPresentada)?$obj->identificacionPresentada:"").
			"','".cv(isset($obj->otraIdentificacion)?$obj->otraIdentificacion:"").
			"','".cv(isset($obj->otraIdentificacion)?$obj->otraIdentificacion:"")."','".$obj->nacionalidad.
			"',".cv((isset($obj->grupoEtnico)&&($obj->grupoEtnico!=""))?$obj->grupoEtnico:"NULL").",".
			cv((isset($obj->discapacidad)&&($obj->discapacidad!=""))?$obj->discapacidad:"NULL").
			",".cv(isset($obj->aceptaNotificacionMail)?$obj->aceptaNotificacionMail:"").",'".cv($obj->tarjetaProfesional)."',".
			($obj->fechaIdentificacion==""?"NULL":"'".$obj->fechaIdentificacion."'").",".($obj->tipoEntidad==""?"NULL":$obj->tipoEntidad).
			",".$obj->desconoceNIT.",".$obj->desconoceIdentificacion.",".$obj->desconoceDatosContacto.",".$obj->resultadoBusquedaWS.")";
	$x++;
	
	$query[$x]="set @idParticipante:=(select last_insert_id())";
	$x++;
	foreach($obj->alias as $a)
	{
		$query[$x]="INSERT INTO _47_gAlias(idReferencia,nombre,apPaterno,apMaterno) 
					VALUES(@idParticipante,'".cv(trim($a->nombre))."','".cv(trim($a->apPaterno))."','".cv(trim($a->apMaterno))."')";
		$x++;
	}
	$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion)
				VALUES(".$idActividad.",@idParticipante,".$obj->tipoFigura.",1)";
	$x++;
	
	$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
				situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
				(".$idActividad.",@idParticipante,".$obj->tipoFigura.",-1,NULL,1,'".date("Y-m-d H:i:s").
				"',".$_SESSION["idUsr"].",'')";
	$x++;
	
	if(isset($obj->relacionadoCon))
	{
		if($obj->relacionadoCon!="")
		{
			$arrRelacion=explode(",",$obj->relacionadoCon);
			foreach($arrRelacion as $r)
			{
				$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
					VALUES(".$idActividad.",@idParticipante,".$obj->tipoFigura.",".$r.",1)";
				$x++;
				$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
					situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
					(".$idActividad.",@idParticipante,".$obj->tipoFigura.",".$r.",NULL,1,'".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].",'')";
				$x++;
			}
		}
	}
	
	
	if(isset($obj->datosContacto))
	{
		$o=$obj->datosContacto;
		$query[$x]="INSERT INTO 7025_datosContactoParticipante(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias)
					VALUES(".$o->idFormulario.",".$o->idRegistro.",@idParticipante,'".date("Y-m-d H:i:s")."','".cv($o->calle).
					"','".cv($o->noExt)."','".cv($o->noInt)."','".cv($o->colonia)."','".cv($o->cp)."','".cv($o->estado).
					"','".cv($o->municipio)."','".cv($o->localidad)."','".cv($o->entreCalle)."','".cv($o->yCalle)."','".cv($o->referencias)."')";
		$x++;
		
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		foreach($o->mail as $m)
		{
			$query[$x]="INSERT INTO 7025_correosElectronico(idReferencia,correo) VALUES(@idRegistro,'".cv($m->mail)."')";
			$x++;
		}

		foreach($o->arrTelefonos as $t)
		{
			if($t->numero!="NO REGISTRO")
			{
				$query[$x]="INSERT INTO 7025_telefonos(idReferencia,tipoTelefono,lada,numero,extension,idPais,verificado) VALUES(@idRegistro,'".$t->tipoTelefono.
						"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->pais.",".($t->verificado==""?0:$t->verificado).")";
				$x++;
			}	
		}
		
	}
	$query[$x]="commit";
	$x++;
	if($con->ejecutarBloque($query))
	{
		$consulta="select @idParticipante";
		$iRegistro=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
					IF(apellidoMaterno IS NULL,'',apellidoMaterno)) FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r
					WHERE r.idActividad=".$idActividad." AND t.id__47_tablaDinamica=r.idParticipante  and r.idFiguraJuridica=".$obj->tipoFigura."
					ORDER BY t.nombre,t.apellidoPaterno,t.apellidoMaterno";
		
		$arrParticipantes=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
					IF(apellidoMaterno IS NULL,'',apellidoMaterno)) FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r
					WHERE r.idActividad=".$idActividad." AND t.id__47_tablaDinamica=r.idParticipante  ORDER BY t.nombre,t.apellidoPaterno,t.apellidoMaterno";
		
		$arrParticipantesGlobal=$con->obtenerFilasArreglo($consulta);
		
		$idUsuarioSistema=@convertirParticipanteProcesoCuentaSistema($iRegistro,"10000004","23");
		if($idUsuarioSistema!=-1)
		{
			$consulta="UPDATE 802_identifica SET grupoEtnico=".((isset($obj->grupoEtnico)&&($obj->grupoEtnico!=""))?$obj->grupoEtnico:"NULL").
			",discapacidad=".((isset($obj->discapacidad)&&($obj->discapacidad!=""))?$obj->discapacidad:"NULL").
			", datosValidados=".$obj->datosValidados." WHERE idUsuario=".$idUsuarioSistema;
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|".$iRegistro."|".trim($obj->nombre)." ".trim($obj->apPaterno)." ".trim($obj->apMaterno)."|".$arrParticipantes."|".$arrParticipantesGlobal;
	}
	
	
	
}

function obtenerMediosNotificacion()
{
	global $con;
	$tipoDiligencia=$_POST["tipoDiligencia"];
	$tipoPersona=$_POST["tipoPersona"];
	$detalle=$_POST["detalle"];
	
	$arrHijos="";
	$consulta="SELECT DISTINCT * FROM (SELECT medioNotificacion,(SELECT medioNotificacion FROM _415_tablaDinamica 
			WHERE id__415_tablaDinamica=p.medioNotificacion) AS lblMedioNotificacion
			FROM _436_tablaDinamica p WHERE tipoNotificacion=".$tipoDiligencia." AND parteProcesal=".$tipoPersona." AND detalleParteProcesal=".$detalle.") 
			AS tmp ORDER BY lblMedioNotificacion";

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o='{"icon":"s.gif","expanded":true,"id":"'.$fila[0].'"';
		$consulta="SELECT DISTINCT * FROM (
			SELECT detalleMedioNotificacion,
			(SELECT descripcion FROM _415_gEspecificaciones WHERE idReferencia = p.medioNotificacion AND idDetalle=p.detalleMedioNotificacion) AS lblDetalleMedioNotificacion
			FROM _436_tablaDinamica p WHERE tipoNotificacion=".$tipoDiligencia." AND parteProcesal=".$tipoPersona." AND detalleParteProcesal=".$detalle.
			" and medioNotificacion=".$fila[0]." and detalleMedioNotificacion<>-1) AS tmp ORDER BY lblDetalleMedioNotificacion";
		

		$res2=$con->obtenerFilas($consulta);
		if($con->filasAfectadas>0)
		{
			
			$arrNivel2="";
			while($fila2=mysql_fetch_row($res2))
			{
				$o2='{"icon":"s.gif","expanded":true,"id":"'.$fila[0].'_'.$fila2[0].'"';			
				
				$consulta="SELECT DISTINCT * FROM (select
					detalleMedio2,
					(SELECT descripcion FROM _415_gEspecificaciones WHERE  idReferencia = 2 AND idDetalle=p.detalleMedio2) AS lblDetalleMedio2 
					FROM _436_tablaDinamica p WHERE tipoNotificacion=".$tipoDiligencia." AND parteProcesal=".$tipoPersona." AND detalleParteProcesal=".$detalle.
					" and medioNotificacion=".$fila[0]." and detalleMedioNotificacion=".$fila2[0]." and detalleMedio2<>-1) AS tmp ORDER BY lblDetalleMedio2";

				
				$res3=$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					$arrNivel3="";
					while($fila3=mysql_fetch_row($res3))
					{
						$o3='{"icon":"s.gif","expanded":true,"id":"'.$fila[0].'_'.$fila2[0].'_'.$fila3[0].'","text":"@input'.cv($fila3[1]).'","leaf":true,"elegible":"1"}';
						if($arrNivel3=="")
							$arrNivel3=$o3;
						else
							$arrNivel3.=",".$o3;
					}
					
						
					$o2.=',"leaf":false,"children":['.$arrNivel3.'],"text":"<span style=\'color:#000\'><b>-- '.cv($fila2[1]).' --</b></span>","elegible":"0"';	
				}
				else
				{
					$o2.=',"leaf":true,"text":"'.cv($fila2[1]).'","elegible":"1"';	
				}
				$o2.='}';
				
				if($arrNivel2=="")
					$arrNivel2=$o2;
				else
					$arrNivel2.=",".$o2;
			}
			
			
			$o.=',"leaf":false,"children":['.$arrNivel2.'],"text":"<span style=\'color:#000\'><b>-- '.cv($fila[1]).' --</b></span>","elegible":"0"';	
		}
		else
		{
			
			$o.=',"leaf":true,"text":"'.cv($fila[1]).'","elegible":"1"';	
			
		}
		$o.='}';
		if($arrHijos=="")
			$arrHijos=$o;
		else
			$arrHijos.=",".$o;
		
	}
	
	echo '['.str_replace("@input","",$arrHijos).']';
	

	
}

function generarDiligenciaNotificacion()
{
	global $con;
	global $arrMesLetra;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$lblSentenciado="";
	
	

	$arrMedioNotificacion=explode("_",$obj->medioNotificacion);
	if(!isset($arrMedioNotificacion[1]))
		$arrMedioNotificacion[1]=-1;
	
	if(!isset($arrMedioNotificacion[2]))
		$arrMedioNotificacion[2]=-1;
	
	$consulta="SELECT tipoCarpetaAdministrativa,carpetaAdministrativa,unidadGestion,etapaProcesalActual FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$obj->idCarpeta;
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	$tCarpeta=$fCarpeta[0];
	$carpetaAdministrativa=$fCarpeta[1];
	
	switch($fCarpeta[3]==1)
	{
		case 5:
			$lblSentenciado="acusado";
		break;
		case 6:
			$lblSentenciado="sentenciado";
		break;
		default:
			$lblSentenciado="imputado";
		break;
	}
	
	
	
	$consulta="SELECT LOWER(tituloUnidad) FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta[2]."'";
	$unidadSede=$con->obtenerValor($consulta);
	
	$arrValores=array();
	
	/*$arrValores["diaDiligencia"]=date("d",$fDiligencia);
	$arrValores["mesDiligencia"]=$arrMesLetra[(date("m",$fDiligencia)*1)-1];
	$arrValores["anioDiligencia"]=date("Y",$fDiligencia);
	$arrValores["diaDeterminacion"]=date("d",$fDeterminacion);
	$arrValores["mesDeterminacion"]=$arrMesLetra[(date("m",$fDeterminacion)*1)-1];
	$arrValores["anioDeterminacion"]=date("Y",$fDeterminacion);
	
	$arrValores["fechaDiligencia"]=$arrValores["diaDiligencia"]." de ".$arrValores["mesDiligencia"]." de ".$arrValores["anioDiligencia"];*/
	
	$reflectionClase = new ReflectionObject($obj);
	foreach ($reflectionClase->getProperties() as $property => $value) 
	{
		$nombre=$value->getName();
		$valor=$value->getValue($obj);
		$arrValores[$nombre]=$valor;
	}
	
	//$arrValores["fechaDeterminacion"]=$arrValores["diaDeterminacion"]." de ".$arrValores["mesDeterminacion"]." de ".$arrValores["anioDeterminacion"];
	
	$consulta="SELECT medioNotificacion FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$arrMedioNotificacion[0];
	$medio1=$con->obtenerValor($consulta);
	$consulta="SELECT descripcion FROM _415_gEspecificaciones WHERE idReferencia=".$arrMedioNotificacion[0]." AND idDetalle=".$arrMedioNotificacion[1];
	$medio2=$con->obtenerValor($consulta);
	$consulta="SELECT descripcion FROM _415_gEspecificaciones WHERE idDetalle=".$arrMedioNotificacion[2];
	$medio3=$con->obtenerValor($consulta);
	$arrValores["medio1"]=$medio1;
	$arrValores["medio2"]=$medio2;
	$arrValores["medio3"]=$medio3;
	//$arrValores["medioOtro"]=$obj->detalle3;
	
	if(isset($arrValores["medioOtro"]) &&($arrMedioNotificacion[0]!=""))
	{
		if($arrValores["medio3"]=="OTRO")
			$arrValores["medio3"]=mb_strtoupper($arrValores["medioOtro"]);
		if($arrValores["medio2"]=="OTRO")
			$arrValores["medio2"]=mb_strtoupper($arrValores["medioOtro"]);
	}
	
	$consulta="SELECT * FROM 7042_ordenesNotificacion WHERE idOrden=".$obj->idOrden;
	$fDatosOrden=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$arrValores["seNotifico"]=$obj->resultado;
	$arrValores["citatorio"]=$obj->citatorio!=1?0:1;
	$arrValores["nombreDeterminacion"]=$fDatosOrden["nombreDeterminacion"]==""?"________":$fDatosOrden["nombreDeterminacion"];
	$arrValores["fechaDeterminacion"]=$fDatosOrden["fechaDeterminacion"];
	if($arrValores["fechaDeterminacion"]!="")
	{
		$fechaDeterminacion=strtotime($arrValores["fechaDeterminacion"]);
		$arrValores["fechaDeterminacion"]=date("d",$fechaDeterminacion)." de ".$arrMesLetra[(date("m",$fechaDeterminacion)*1)-1].
									" de ".date("Y",$fechaDeterminacion);
	}
	$arrValores["unidadSede"]=str_replace(" En "," en ",str_replace(" De "," de ", ucwords($unidadSede)));

	
	$textoFinal="";
	$consulta="SELECT * FROM _436_tablaDinamica WHERE tipoNotificacion=".$obj->tipoDiligencia." AND medioNotificacion=".$arrMedioNotificacion[0].
				" AND detalleMedioNotificacion=".$arrMedioNotificacion[1]." AND detalleMedio2=".$arrMedioNotificacion[2].
				" AND parteProcesal=".$obj->parteProcesal." AND detalleParteProcesal=".$obj->detalleParteProcesal;

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$aplica=true;
		
		if(($fila["funcionAPlicacion"]!="")&&($fila["funcionAPlicacion"]!="-1"))
		{
			$cache=NULL;
			$aplica=removerComillasLimite(resolverExpresionCalculoPHP($fila["funcionAPlicacion"],$obj,$cache))==1;
		}
		
		if($aplica)
		{
			$txtDiligencia=$fila["txtDiligencia"];
			foreach($arrValores as $llave=>$valor)
			{
				$txtDiligencia=str_replace("[".$llave."]",$valor,$txtDiligencia);
			}

			$txtDiligencia=str_replace("Unidad de Gestión Judicial Especializada en Ejecución de Sanciones Penales sede________________","Unidad de Gestión Judicial",$txtDiligencia);
			
			$txtDiligencia=str_replace("audiencia de Audiencia","Audiencia",$txtDiligencia);
			
			$txtDiligencia=str_replace("sentenciado",$lblSentenciado,$txtDiligencia);
			

			if($textoFinal=="")
				$textoFinal=$txtDiligencia;
			else
				$textoFinal.="<br><br>".$txtDiligencia;
				
				
				
		}
	}
	
	echo '1|{"exposicionDiligencia":"'.bE($textoFinal).'"}';
	
}

function registrarDiligenciaNotificacion()
{
	global $con;
	
	
	$objDiligencia=$_POST["objDiligencia"];
	$oDiligencia=json_decode($objDiligencia);
	
	$detalleDiligencia=json_decode(bD($oDiligencia->objDiligencia));
	
	$notificado=1;
	if(isset($detalleDiligencia->notificado))
	{
		$notificado=$detalleDiligencia->notificado;
	}
	$x=0;
	$query[$x]="begin";
	$x++;
	if($oDiligencia->idDiligencia==-1)
	{
		
		$consulta="select idRegistro from 7028_actaNotificacion where idOrden=".$oDiligencia->idOrden." and situacion=1";
		$idActaCircunstanciada=$con->obtenerValor($consulta);
		if($idActaCircunstanciada=="")
		{
			$consulta="select count(*) from 7028_actaNotificacion where idOrden=".$oDiligencia->idOrden;
			$nActa=$con->obtenerValor($consulta);
			$nActa++;
			$query[$x]="INSERT 7028_actaNotificacion(fechaCreacion,idResponsableRegistro,fechaActa,tipoActa,nombreDeterminacion,fechaDeterminacion,idEventoAudiencia,
						comentariosAdicionales,situacion,carpetaAdministrativa,idOrden,noActa)
						SELECT '".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",NULL,tipoNotificacion,nombreDeterminacion,fechaDeterminacion,idEventoDeriva,
						comentariosAdicionales,1,carpetaJudicial,idOrden,'".$nActa."' FROM 7042_ordenesNotificacion WHERE idOrden=".$oDiligencia->idOrden;

			$x++;
			$query[$x]="set @idActaCircunstanciada:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="set @idActaCircunstanciada:=".$idActaCircunstanciada;
			$x++;
		}
		
		$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden+1 WHERE idOrden=".$oDiligencia->idOrden.
					" AND orden>=".$oDiligencia->orden." and idActaCircunstanciada=@idActaCircunstanciada";
		$x++;
		$query[$x]="INSERT INTO 7029_diligenciaActaNotificacion(idOrden,fechaCreacion,idResponsable,fechaDiligencia,tipoDiligencia,
					otroTipoDiligencia,idParteProcesal,idDetalleParteProcesal,idNombreParteProcesal,nombreParte,idResponsableDiligencia,lblOtroResponsable,
					exposicionDiligencia,orden,objDiligencia,idActaCircunstanciada,notificado,seEnviaCentralNotificadores,enviadoCentralNotificadores) values ('".$oDiligencia->idOrden."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$oDiligencia->fechaDiligencia.
					"',".$oDiligencia->tipoDiligencia.",'".cv($oDiligencia->otroTipoDiligencia)."',".$oDiligencia->parteProcesal.",".
					($oDiligencia->detalleParteProcesal==""?"NULL":$oDiligencia->detalleParteProcesal).",".($oDiligencia->idParteProcesal==""?"NULL":$oDiligencia->idParteProcesal).
					",'".cv($oDiligencia->nombreParteProcesal)."',".$oDiligencia->idResponsableDiligencia.",'".cv($oDiligencia->nombreResponsableDiligencia).
					"','".cv(bD($oDiligencia->exposicionDiligencia))."',".$oDiligencia->orden.",'".$oDiligencia->objDiligencia.
					"',@idActaCircunstanciada,".$notificado.",".$oDiligencia->enviadoCentralNotificadores.",0)";
		$x++;
		
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		
	}
	else
	{
		$consulta="select orden,idActaCircunstanciada,enviadoCentralNotificadores from 7029_diligenciaActaNotificacion  where idRegistro=".$oDiligencia->idDiligencia;
		$fActa=$con->obtenerPrimeraFila($consulta);
		$ordenOriginal=$fActa[0];
		$idActa=$fActa[1];
		
		if($ordenOriginal!=$oDiligencia->orden)
		{
			if($ordenOriginal>$oDiligencia->orden)
			{
				$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden+1 WHERE idActaCircunstanciada=".$oDiligencia->idActa.
					" and orden>=".$oDiligencia->orden." AND orden<=".$ordenOriginal;
				$x++;
			}
			else
			{
				$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden-1 WHERE idActaCircunstanciada=".$oDiligencia->idActa.
					" and orden>=".$ordenOriginal." AND orden<=".$oDiligencia->orden;
				$x++;
			}
		}
		
		echo "13";
		
		$query[$x]="update 7029_diligenciaActaNotificacion set fechaUltimaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"].
					",fechaDiligencia='".$oDiligencia->fechaDiligencia."',tipoDiligencia=".$oDiligencia->tipoDiligencia.",
					otroTipoDiligencia='".cv($oDiligencia->otroTipoDiligencia)."',idParteProcesal=".$oDiligencia->parteProcesal.
					",idDetalleParteProcesal=".($oDiligencia->detalleParteProcesal==""?"NULL":$oDiligencia->detalleParteProcesal).
					",idNombreParteProcesal=".($oDiligencia->idParteProcesal==""?"NULL":$oDiligencia->idParteProcesal).
					",nombreParte='".cv($oDiligencia->nombreParteProcesal)."',idResponsableDiligencia=".$oDiligencia->idResponsableDiligencia.
					",lblOtroResponsable='".cv($oDiligencia->nombreResponsableDiligencia)."',orden=".$oDiligencia->orden.
					",exposicionDiligencia='".cv(bD($oDiligencia->exposicionDiligencia)).
					"',objDiligencia='".$oDiligencia->objDiligencia."',notificado=".$notificado." where idRegistro=".$oDiligencia->idDiligencia;
		$x++;
		$query[$x]="set @idRegistro:=".$oDiligencia->idDiligencia;
		$x++;
	}
	
	
	if($oDiligencia->objDiligencia!='')
	{
		$oDatosDiligencia=json_decode(bD($oDiligencia->objDiligencia));
		
		if(isset($oDatosDiligencia->arrSeguimientoTelefonico))
		{
			$query[$x]="delete from 7036_alertasNotificaciones where valorReferencia1=-7029 and valorReferencia2=@idRegistro";
			$x++;
			$ultimoSeguimiento=$oDatosDiligencia->arrSeguimientoTelefonico[0];
			$detalle=json_decode(bD($ultimoSeguimiento->detalle));
		
			if($ultimoSeguimiento->situacion==2)
			{
				$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
						IF(apellidoMaterno IS NULL,'',apellidoMaterno)) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$oDiligencia->idParteProcesal;
				$destinatario=$con->obtenerValor($consulta);
				$recordatorioLlamada="Llamar a ".$destinatario." al número: ".$ultimoSeguimiento->telefono." a las ".date("H:i",strtotime($ultimoSeguimiento->fechaDiligencia))." hrs. ";
				$consulta="SELECT carpetaJudicial FROM 7042_ordenesNotificacion WHERE idOrden=".$oDiligencia->idOrden;
				$carpetaJudicial=$con->obtenerValor($consulta);
				$query[$x]="INSERT INTO 7036_alertasNotificaciones(carpetaAdministrativa,situacion,descripcion,valorReferencia1,valorReferencia2,
						fechaRegistro,responsableRegistro,tipoAlerta,fechaAlerta,idTitularAlerta)
						VALUES('".$carpetaJudicial."',1,'".cv($recordatorioLlamada." ".urldecode($detalle->detallesProximaLlamada))."',-7029,@idRegistro,'".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].",6,'".date("Y-m-d",strtotime($ultimoSeguimiento->fechaDiligencia))."',".$_SESSION["idUsr"].")";
				$x++;
				
				$query[$x]="set @idAlerta:=(select last_insert_id())";
				$x++;
				
				$query[$x]="INSERT INTO 7037_recordatoriosPreviosNotificacion(fechaRecordatorio,idAlertaNotificacion) 
							VALUES('".date("Y-m-d H:i:s",strtotime($ultimoSeguimiento->fechaDiligencia))."',@idAlerta)";
				$x++;
			}
			
		}
	}
	
	$query[$x]="DELETE FROM 7030_medioNotificacionDiligencia WHERE idDiligencia=@idRegistro";
	$x++;
	
	foreach($oDiligencia->arrMedioNotificacion as $m)
	{
		$query[$x]="INSERT INTO 7030_medioNotificacionDiligencia(idDiligencia,idMedio,detalle1,detalle2,detalle3,resultadoNotificacion,dejoCitatorio)
					values(@idRegistro,".$m->idMedio.",".($m->detalle1==""?"NULL":$m->detalle1).",".($m->detalle2==""?"NULL":$m->detalle2).
					",'".cv($m->detalle3)."',".$m->resultado.",".($m->citatorio==""?"NULL":$m->citatorio).")";
		$x++;
	}
	
	
	$query[$x]="DELETE FROM 7030_documentosAdjuntosDiligencia WHERE idDiligencia=@idRegistro";
	$x++;
	
	foreach($oDiligencia->arrDocumentos as $d)
	{
		$idDocumento=$d->idDocumento;
		if(strpos($d->idDocumento,"_")!==false)
		{
			$idDocumento=registrarDocumentoServidorRepositorio($d->idDocumento,$d->nombreDocumento,0,"");
	
		}
		$query[$x]="INSERT INTO 7030_documentosAdjuntosDiligencia(idDiligencia,idDocumento)
					values(@idRegistro,".$idDocumento.")";
		$x++;
	}
	
	
	
	
	$query[$x]="commit";
	$x++;

	if($con->ejecutarBloque($query))
	{
		
		if($oDiligencia->enviadoCentralNotificadores==1)
		{

			$consulta="select @idRegistro";
			$idDiligencia=$con->obtenerValor($consulta);
			$consulta="SELECT seEnviaCentralNotificadores,enviadoCentralNotificadores FROM 7029_diligenciaActaNotificacion WHERE idRegistro=".$idDiligencia;
			
			$fDatosDiligencia=$con->obtenerPrimeraFila($consulta);

			$enviadoCentralNotificadores=$fDatosDiligencia[1];
			$seEnviaCentralNotificadores=$fDatosDiligencia[0];
			if(($seEnviaCentralNotificadores==1)&&($enviadoCentralNotificadores==0))
			{
				
				$objResp=enviarDiligenciaCentralNotificadores($idDiligencia);
				
				if($objResp->resultado==1)
				{
					echo "1|1|";
				}
				else
				{
					echo "1|0|".$objResp->mensaje;
				}
			}
			
		}
		else
		{
			echo "1|1";
		}

	}
	
}

function obtenerDiligenciasOrdenNotificicacion()
{
	global $con;
	$idOrden=$_POST["idOrden"];
	
	
	$arrRegistros="";
	$o="";
	$numReg=0;
	

	
	$consulta="SELECT * FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$idOrden." ORDER BY idActaCircunstanciada,orden desc";
	$res=$con->obtenerFilas($consulta);
	
	while($fila=mysql_fetch_assoc($res))
	{
		$lblNombreParteProcesal="";
		if($fila["idNombreParteProcesal"]!="")
		{
			$consulta="SELECT CONCAT(if(nombre is null,'',nombre),' ',if(apellidoPaterno is null,'',apellidoPaterno),
						' ',if(apellidoMaterno is null,'',apellidoMaterno)) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila["idNombreParteProcesal"];
			$lblNombreParteProcesal=$con->obtenerValor($consulta);
		}
		
		
		$consulta="SELECT idMedio,detalle1,detalle2,detalle3,resultadoNotificacion AS  resultado,dejoCitatorio AS citatorio  
					FROM 7030_medioNotificacionDiligencia WHERE idDiligencia=".$fila["idRegistro"]." ORDER BY idRegistro";
		$arrMedios=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$arrDocumentos="";
		$consulta="SELECT d.idDocumento,nomArchivoOriginal,nomArchivoOriginal,tamano,fechaCreacion 
					FROM 7030_documentosAdjuntosDiligencia d,908_archivos a WHERE d.idDiligencia=".$fila["idRegistro"]." and a.idArchivo=d.idDocumento";
					
		$resDocumentos=$con->obtenerFilas($consulta);
	
		while($fDocumento=mysql_fetch_row($resDocumentos))
		{
			$arrExtension=explode(".",$fDocumento[1]);
			$o='{"idDocumento":"'.$fDocumento[0].'","nombreDocumento":"'.cv($fDocumento[1]).'","nombreDocumentoCorto":"'.cv($fDocumento[1]).
				'","tamanoDocumento":"0","fechaDocumento":"'.$fDocumento[4].'","extension":"'.$arrExtension[sizeof($arrExtension)-1].'"}';
			if($arrDocumentos=="")
				$arrDocumentos=$o;
			else
				$arrDocumentos.=",".$o;
		}
		
		$consulta="SELECT situacion,noActa FROM 7028_actaNotificacion WHERE idRegistro=".$fila["idActaCircunstanciada"];
		$fActa=$con->obtenerPrimeraFila($consulta);
		
		$o='{"idDiligencia":"'.$fila["idRegistro"].'","fechaCreacion":"'.$fila["fechaCreacion"].'","fechaDiligencia":"'.$fila["fechaDiligencia"].
			'","tipoDiligencia":"'.$fila["tipoDiligencia"].'","otroTipoDiligencia":"'.cv($fila["otroTipoDiligencia"]).'",
			"idParteProcesal":"'.$fila["idParteProcesal"].'","idDetalleParteProcesal":"'.$fila["idDetalleParteProcesal"].
			'","idNombreParteProcesal":"'.$fila["idNombreParteProcesal"].'","nombreParte":"'.cv($fila["nombreParte"]).
			'","exposicionDiligencia":"'.cv($fila["exposicionDiligencia"]).'","lblNombreParteProcesal":"'.cv($lblNombreParteProcesal).'",
			"idResponsableDiligencia":"'.$fila["idResponsableDiligencia"].'","lblOtroResponsable":"'.cv($fila["lblOtroResponsable"]).
			'","arrMediosNotificacion":'.$arrMedios.',"orden":"'.$fila["orden"].'","objDiligencia":"'.$fila["objDiligencia"].
			'","arrDocumentos":['.$arrDocumentos.'],"idActa":"'.$fila["idActaCircunstanciada"].'","situacionActa":"'.$fActa[0].
			'","noActa":"'.$fActa[1].'","enviadoCentralNotificadores":"'.$fila["enviadoCentralNotificadores"].
			'","fechaEnvioCentralNotificadores":"'.$fila["fechaEnvioCentralNotificadores"].'","seEnviaCentralNotificadores":"'.
			$fila["seEnviaCentralNotificadores"].'","idAcuseEnvioCentralNotificadores":"'.$fila["idAcuseEnvioCentralNotificadores"].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}'	;
	
}


function obtenerActaAperturadaNotificacion()
{
	global $con;
	$idOrden=$_POST["idOrden"];
	$consulta="SELECT idRegistro FROM 7028_actaNotificacion WHERE idOrden=".$idOrden." AND situacion=1";
	
	$idActa=$con->obtenerValor($consulta);
	
	if($idActa=="")
		$idActa=-1;
	
	echo "1|".$idActa;
	
}

function cerrarActaNotificacion()
{
	global $con;
	$idActa=$_POST["idActa"];
	$consulta="UPDATE 7028_actaNotificacion SET situacion=2 WHERE idRegistro=".$idActa;
	eC($consulta);
}

function obtenerDatosSolicitudNotificacionNotificador()
{
	global $con;
	$iO=$_POST["iO"];
	//AND responsableTarea=".$_SESSION["idUsr"];
	$consulta="SELECT idOrden,folioOrden,carpetaJudicial,tipoNotificacion,idEventoDeriva,nombreDeterminacion,
				(select comentariosAdicionales from 3020_responsablesTareas r where iFormulario=-7042 AND iRegistro=o.idOrden  order by idRegistro desc limit 0,1
				) as comentariosAdicionales,
				IF(tipoNotificacion=1,CONCAT(nombreDeterminacion, ' [Fecha de la determinación: ',DATE_FORMAT(fechaDeterminacion,'%d/%m/%Y'),']'),
								(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
								7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia 
								AND e.idRegistroEvento=o.idEventoDeriva)) 
				AS descripcionNotificacion,fechaDeterminacion FROM 7042_ordenesNotificacion o WHERE idOrden=".$iO;
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	
	echo "1|".$arrRegistros;
}

function agregarCorreoElectonicoNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	
	$tblMail="7025_correosElectronico";
	$tblTelefono="7025_telefonos";
	$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
				yCalle,otrasReferencias,idRegistro  FROM 7025_datosContactoParticipante 
				WHERE idParticipante=".$obj->idParticipante." order by fechaCreacion desc";
	$fila=$con->obtenerPrimeraFilaAsoc($consulta);
	if(!$fila)
	{
		$tblMail="_48_correosElectronico";
		$tblTelefono="_48_telefonos";
		$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
					yCalle,otrasReferencias,id__48_tablaDinamica as idRegistro FROM _48_tablaDinamica WHERE idReferencia=".$obj->idParticipante;	
		
		$fila=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fila)
		{
			$tblMail="7025_correosElectronico";
			$tblTelefono="7025_telefonos";
			$query[$x]="INSERT INTO 7025_datosContactoParticipante(idParticipante,fechaCreacion) VALUES(".$obj->idParticipante.
						",'".date("Y-m-d H:i:s")."')";
			$x++;
			
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;

		}
		else
		{
			$query[$x]="set @idRegistro:=".$fila["idRegistro"];
			$x++;
		}
		
	}
	else
	{
		$query[$x]="set @idRegistro:=".$fila["idRegistro"];
		$x++;
	}
	
	if(isset($obj->mail))
	{
		$query[$x]="INSERT into ".$tblMail."(idReferencia,correo) VALUES(@idRegistro,'".cv($obj->mail)."')";
		$x++;
	}
	
	$query[$x]="commit";
	$x++;
	
	eB($query);
	
	
}

function obtenerTextoNotificacionMail()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT *,l.nombreLey,l.prefijo FROM 7031_fundamentoLegalMedioNotificacion f,_422_tablaDinamica l WHERE llaveMedioNotificacion in ('".$obj->medio.
					"') and l.id__422_tablaDinamica=f.idLey order by l.nombreLey,articulo,fraccion,inciso,complementario";

		
	$rMedioFundamento=$con->obtenerFilas($consulta);
	while($fMedioFundameto=mysql_fetch_assoc($rMedioFundamento))
	{
		if($fMedioFundameto["articulo"]=="")
			$fMedioFundameto["articulo"]="-";
		
		if($fMedioFundameto["fraccion"]=="")
			$fMedioFundameto["fraccion"]="-";
		
		if($fMedioFundameto["inciso"]=="")
			$fMedioFundameto["inciso"]="-";
		if($fMedioFundameto["complementario"]=="")
			$fMedioFundameto["complementario"]="-";	
		
		$considerar=true;
		if(($fMedioFundameto["idFuncionAplicacion"]!="")&&($fMedioFundameto["idFuncionAplicacion"]!=-1))
		{
			eval('$considerar=funcionFundamento_'.$fMedioFundameto["idFuncionAplicacion"].'($obj->tipoDiligencia,$obj->detallePersona,$obj->carpetaJudicial);');				
		}
		if($considerar)
		{
			$llaveFundamento=$fMedioFundameto["idLey"]."_".$fMedioFundameto["articulo"]."_".$fMedioFundameto["fraccion"]."_".$fMedioFundameto["inciso"]."_".$fMedioFundameto["complementario"];
			$arrFundamentos[$llaveFundamento]=0;
			$arrFundamentosLeyes[$fMedioFundameto["idLey"]]=trim($fMedioFundameto["prefijo"]." ".$fMedioFundameto["nombreLey"]);
		}
			
		
	}
	
	$nTokens=1;
	$fundamento="";
	
	//ksort($arrFundamentos);

	foreach($arrFundamentosLeyes as $idLey=>$nombreLey)
	{
		$tokenLey="";
		
		$token="";
		foreach($arrFundamentos as $f=>$leyFundamento)
		{
			
			$aFundamento=explode("_",$f);
			if($idLey==$aFundamento[0])
			{
				$token=$aFundamento[1];
				if($aFundamento[2]!="-")
				{
					$token.=" fracción ".$aFundamento[2];
				}
				
				if($aFundamento[3]!="-")
				{
					$token.="-_- inciso ".$aFundamento[3];
				}
				
				if($aFundamento[4]!="-")
				{
					$token.=" ".$aFundamento[4];
				}
				
				if($tokenLey=="")
					$tokenLey=$token;
				else
					$tokenLey.=", ".$token;
			}
		}
		
		
		$arrTokens=explode(",",$tokenLey);
		$tokenLey="";
		$nTokens=1;
		foreach($arrTokens as $t)
		{
			$t=trim($t);
			if($tokenLey=="")
				$tokenLey=$t;
			else
			{
				if($nTokens==sizeof($arrTokens))
					$tokenLey.=" y ".$t;
				else
					$tokenLey.=", ".$t;
			}
			$nTokens++;
		}
		
		$tokenLey=str_replace("-_-",",",$tokenLey);
		$tokenLey.=" ".$nombreLey;
		
		if($fundamento=="")
			$fundamento=$tokenLey;
		else
			$fundamento.=", así como ".$tokenLey;
	}
	
	
	if(sizeof($arrFundamentos)==1)
		$fundamento="el artículo: ".$fundamento;
	else
		$fundamento="los artículos: ".$fundamento;
		
		
	$textoCorreo=	"<br>Con fundamento en ".$fundamento.", le hago de su conocimiento la ".mb_strtolower($obj->tDiligencia).
					" relativa a la carpeta judicial ".$obj->carpetaJudicial	;
	echo "1|".bE($textoCorreo);
	
}

function registrarConfiguracionSMTP()
{
	global $con;
	global $versionLatis;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$comp="";
	if($obj->utilizarSSL==1)
	{
		$comp="/ssl";
	}
	$c=new cSendMail("{".$obj->hostIMAP.":".$obj->puertoIMAP.$comp."/novalidate-cert".$comp."}",$obj->usuario,bD($obj->passwd));
	if($c->conectarServidor())
	{
		$c->cerrarConexionServidor();
		$consulta="SELECT idRegistro FROM 805_configuracionMailSMTP WHERE idUsuario=".$obj->idUsuario;
		$idRegistro=$con->obtenerValor($consulta);
		
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 805_configuracionMailSMTP(idUsuario,mail,contrasena,hostSMTP,puertoSMTP,autenticacionSMTP,hostIMAP,puertoIMAP,utilizarSSL) 
						VALUES(".$obj->idUsuario.",'".cv($obj->usuario).
						"',HEX(AES_ENCRYPT('".bD($obj->passwd)."', '".bD($versionLatis)."')),'".cv($obj->hostSMTP)."',".$obj->puertoSMTP.
						",".$obj->autenticacionSMTP.",'".cv($obj->hostIMAP)."',".$obj->puertoIMAP.",".$obj->utilizarSSL.")";
		}
		else
		{
			$consulta="update 805_configuracionMailSMTP set mail='".cv($obj->usuario)."',contrasena=HEX(AES_ENCRYPT('".bD($obj->passwd).
					"', '".bD($versionLatis)."')),hostSMTP='".cv($obj->hostSMTP)."',puertoSMTP=".$obj->puertoSMTP.
					",autenticacionSMTP=".$obj->autenticacionSMTP.",hostIMAP='".cv($obj->hostIMAP)."',puertoIMAP=".$obj->puertoIMAP.
					",utilizarSSL=".$obj->utilizarSSL." where idRegistro=".$idRegistro;
		}
		
		eC($consulta);	
	}
	else
	{
		echo "<br>No se pudo conectar con el serviodr, verifique sus datos de conexi&oacute;n";
	}


	
	
	
	
}

function obtenerConfiguracionSMTP()
{
	global $con;
	$idUsr=bD($_POST["u"]);
	$consulta="SELECT mail,hostSMTP,puertoSMTP,autenticacionSMTP,hostIMAP,puertoIMAP,utilizarSSL FROM 805_configuracionMailSMTP WHERE idUsuario=".$idUsr;
	$arrObjetos=utf8_encode($con->obtenerFilasJSON($consulta));

	echo "1|".bE($arrObjetos);
	
	
}

function modificarDatosPartesProcesalesCarpeta()
{
	global $con;
	$cadObj=$_POST["cadObj"];	
	$obj=json_decode($cadObj);
	
	
	
	$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idParticipante=".$obj->idPersona." AND idCuentaAcceso IS NOT NULL";
	$idCuentaAcceso=$con->obtenerValor($consulta);
	
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="INSERT INTO _47_respadoDatosIdentificacion(idPersonaRegistro,fechaCambio,responsableCambio,
				tipoPersona,esMexicano,nacionalidad,otraNacionalidad,rfcEmpresa,curp,cedulaProfesional,
				nombre,apellidoPaterno,apellidoMaterno,genero,fechaNacimiento,edad,estadoCivil,
				tipoIdentificacion,otraIdentificacion,	detalleFiguraJuridica,folioIdentificacion,
				grupoEtnico,discapacidad,aceptaNotificacionMail,tarjetaProfesional,fechaIdentificacion,
				tipoEntidad,desconoceNIT,desconoceIdentificacion,desconoceDomicilio)		
				SELECT '".$obj->idPersona."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",tipoPersona,esMexicano,
				nacionalidad,otraNacionalidad,rfcEmpresa,curp,cedulaProfesional,nombre,apellidoPaterno,apellidoMaterno,
				genero,fechaNacimiento,edad,estadoCivil,tipoIdentificacion,otraIdentificacion,tipoDefensor,folioIdentificacion,
				grupoEtnico,discapacidad,aceptaNotificacionMail,tarjetaProfesional,fechaIdentificacion,tipoEntidad,desconoceNIT,
				desconoceIdentificacion,desconoceDomicilio 
				FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$obj->idPersona;
	$x++;
	$query[$x]="set @idRegistroPersona:=(select last_insert_id())";
	$x++;
	$query[$x]="INSERT INTO _47_respaldoAlias(idRegistroRespaldo,nombre,apPaterno,apMaterno)
				SELECT @idRegistroPersona,nombre,apPaterno,apMaterno FROM _47_gAlias WHERE idReferencia=".$obj->idPersona;
	$x++;
	
	$query[$x]="UPDATE _47_tablaDinamica SET tipoPersona=".$obj->tipoPersona.",esMexicano=".$obj->nacionalidadMexicana.
				",nacionalidad='".$obj->nacionalidad."',otraNacionalidad='".cv($obj->otraNacionalidad)."',rfcEmpresa='".cv($obj->rfc).
				"',curp='".cv($obj->curp)."',cedulaProfesional=".($obj->cedulaProfesional==""?"NULL":$obj->cedulaProfesional).",
				apellidoPaterno='".cv(trim($obj->apPaterno))."',apellidoMaterno='".cv(trim($obj->apMaterno))."',nombre='".cv(trim($obj->nombre)).
				"',genero=".$obj->genero.",fechaNacimiento=".($obj->fechaNacimiento==""?"NULL":"'".$obj->fechaNacimiento."'").
				",edad=".($obj->edad==""?"NULL":$obj->edad).",estadoCivil='".$obj->estadoCivil."',tipoIdentificacion='".$obj->identificacionPresentada.
				"',folioIdentificacion='".cv($obj->otraIdentificacion)."',otraIdentificacion='".cv($obj->otraIdentificacion).
				"',tipoDefensor=".($obj->detallePersona==""?"NULL":$obj->detallePersona).
				",grupoEtnico=".($obj->grupoEtnico==""?"NULL":$obj->grupoEtnico).",discapacidad=".($obj->discapacidad==""?"NULL":$obj->discapacidad).
				",aceptaNotificacionMail=".($obj->aceptaNotificacionMail==""?"NULL":$obj->aceptaNotificacionMail).
				",tarjetaProfesional='".$obj->tarjetaProfesional."',fechaIdentificacion=".($obj->fechaIdentificacion==""?"NULL":"'".$obj->fechaIdentificacion."'").
				",tipoEntidad=".($obj->tipoEntidad==""?"NULL":$obj->tipoEntidad).",desconoceNIT=".$obj->desconoceNIT.
				",desconoceIdentificacion=".$obj->desconoceIdentificacion.",desconoceDomicilio=".$obj->desconoceDatosContacto.
				" WHERE id__47_tablaDinamica=".$obj->idPersona;
	$x++;
	
	if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
	{
		$query[$x]="UPDATE 802_identifica SET Nacionalidad='".$obj->nacionalidad."',RFC='".cv($obj->rfc).
					"',CURP='".cv($obj->curp)."',cedulaProf=".($obj->cedulaProfesional==""?"NULL":$obj->cedulaProfesional).",
					Paterno='".cv(trim($obj->apPaterno))."',Materno='".cv(trim($obj->apMaterno))."',Nom='".cv(trim($obj->nombre)).
					"',Genero=".$obj->genero.",fechaNacimiento=".($obj->fechaNacimiento==""?"NULL":"'".$obj->fechaNacimiento."'").
					",tipoIdentificacion='".$obj->identificacionPresentada."',
					noIdentificacion='".cv($obj->otraIdentificacion)."' WHERE idUsuario=".$idCuentaAcceso;
		$x++;
	}
	
	$query[$x]="delete from _47_gAlias WHERE idReferencia=".$obj->idPersona;
	$x++;
	
	
	$query[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET idFiguraJuridica=".$obj->tipoFigura." WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idPersona;
	$x++;
	
	foreach($obj->alias as $a)
	{
		$query[$x]="insert into _47_gAlias(idReferencia,nombre,apPaterno,apMaterno) values(".$obj->idPersona.",'".cv($a->nombre)."','".cv($a->apPaterno)."','".cv($a->apMaterno)."')";
		$x++;
	}
		
	if(isset($obj->relacionadoCon))
	{
		$arrRelacion=explode(",",$obj->relacionadoCon);
		$query[$x]="delete from 7005_relacionParticipantes where idActividad=".$obj->idActividad." and idParticipante=".$obj->idPersona;
		$x++;
		$query[$x]="delete from 7005_bitacoraCambiosFigurasJuridicas where idActividad=".$obj->idActividad.
				" and idParticipante=".$obj->idPersona." and idActorRelacionado<>-1";
		$x++;
		foreach($arrRelacion as $r)
		{
			if($r=="")
				continue;	
			$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
				VALUES(".$obj->idActividad.",".$obj->idPersona.",".$obj->tipoFigura.",".$r.",1)";
			$x++;
			$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
				situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
				(".$obj->idActividad.",".$obj->idPersona.",".$obj->tipoFigura.",".$r.",NULL,1,'".date("Y-m-d H:i:s").
				"',".$_SESSION["idUsr"].",'')";
			$x++;
		}
	}
	
	if(isset($obj->datosContacto))
	{
		
		$consulta="SELECT idRegistro FROM 7025_datosContactoParticipante WHERE idParticipante=".$obj->idPersona;
		$idRegistro=$con->obtenerValor($consulta);
		
		if($idRegistro=="")
			$idRegistro=-1;
		
		$o=$obj->datosContacto;
		
		$query[$x]=" INSERT INTO 7025_datosContactoParticipanteRespaldos(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,responsableModificacion,
					 fechaModificacion)				
					SELECT idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,
					 ".$_SESSION["idUsr"]." as responsableModificacion,'".date("Y-m-d H:i:s")."' fechaModificacion FROM
					 7025_datosContactoParticipante WHERE idParticipante=".$obj->idPersona;
		$x++;
		$query[$x]="set @iRegistroRespaldo:=(select last_insert_id())";
		$x++;
		
		$query[$x]="INSERT INTO 7025_correosElectronicoRespaldos(idReferencia,correo)
					SELECT  @iRegistroRespaldo,correo FROM 7025_correosElectronico WHERE idReferencia=".$idRegistro;
		$x++;
		$query[$x]="INSERT INTO 7025_telefonosRespaldos( idReferencia,tipoTelefono,lada,numero,extension,idPais,verificado)
					SELECT  @iRegistroRespaldo,tipoTelefono,lada,numero,extension,idPais,verificado FROM 7025_telefonos WHERE idReferencia=".$idRegistro;
		$x++;						
						 
		$query[$x]="update 7025_datosContactoParticipante set fechaCreacion='".date("Y-m-d H:i:s")."',calle='".cv($o->calle)."',
					noExt='".cv($o->noExt)."',noInterior='".cv($o->noInt)."',colonia='".cv($o->colonia)."',codigoPostal=".cv($o->cp==""?"NULL":"'".$o->cp."'").",
					entidadFederativa='".cv($o->estado)."',municipio='".cv($o->municipio)."',localidad='".cv($o->localidad)."',
					entreCalle='".cv($o->entreCalle)."',yCalle='".cv($o->yCalle)."',otrasReferencias='".cv($o->referencias)."'
					where idRegistro=".$idRegistro;
					
		$x++;
		
		
		if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
		{
			$query[$x]="UPDATE 803_direcciones SET Calle='".cv($o->calle)."',Numero='".cv($o->noExt)."',Colonia='".cv($o->colonia).
						"',Ciudad='".cv($o->localidad)."',CP=".cv($o->cp==""?"NULL":"'".$o->cp."'").",Estado='".cv($o->estado)."',Municipio='".cv($o->municipio)."',NumeroInt='".cv($o->noInt)."'
						WHERE idUsuario=".$idCuentaAcceso;	
			$x++;
		}
		
		$query[$x]="set @idRegistro:=".$idRegistro;
		$x++;
		
		$query[$x]="delete from 7025_correosElectronico where idReferencia=@idRegistro";
		$x++;
		foreach($o->mail as $m)
		{
			$query[$x]="INSERT INTO 7025_correosElectronico(idReferencia,correo) VALUES(@idRegistro,'".cv($m->mail)."')";
			$x++;
		}
		$query[$x]="delete from 7025_telefonos where idReferencia=@idRegistro";
		$x++;
		foreach($o->arrTelefonos as $t)
		{
			$query[$x]="INSERT INTO 7025_telefonos(idReferencia,tipoTelefono,lada,numero,extension,idPais,verificado) VALUES(@idRegistro,'".$t->tipoTelefono.
						"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->pais.",".$t->verificado.")";
			$x++;
		}
		
		if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
		{
			$query[$x]="delete from 805_mails where idUsuario=".$idCuentaAcceso;
			$x++;
			foreach($o->mail as $m)
			{
				$query[$x]="INSERT INTO 805_mails(idUsuario,Mail,Tipo,Notificacion) VALUES(".$idCuentaAcceso.",'".cv($m->mail)."',0,1)";
				$x++;
			}
			$query[$x]="delete from 804_telefonos where idUsuario=".$idCuentaAcceso;
			$x++;
			foreach($o->arrTelefonos as $t)
			{
				$query[$x]="INSERT INTO 804_telefonos(idUsuario,Tipo2,Lada,Numero,Extension,codArea,Tipo,verificado) VALUES(".$idCuentaAcceso.",'".$t->tipoTelefono.
							"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->pais.",0,".$t->verificado.")";
				$x++;
			}
		}
		
		
		
		
	}
	
	
	$query[$x]="commit";
	$x++;

	if($con->ejecutarBloque($query))
	{
		echo "1|".$obj->idPersona;
	}
	
	
	
}

function agregarTelefonoNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	

	$tblTelefono="7025_telefonos";
	$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
				yCalle,otrasReferencias,idRegistro  FROM 7025_datosContactoParticipante 
				WHERE idParticipante=".$obj->idParticipante." order by fechaCreacion desc";
	$fila=$con->obtenerPrimeraFilaAsoc($consulta);
	if(!$fila)
	{

		$tblTelefono="_48_telefonos";
		$consulta="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
					yCalle,otrasReferencias,id__48_tablaDinamica as idRegistro FROM _48_tablaDinamica WHERE idReferencia=".$obj->idParticipante;	
		
		$fila=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fila)
		{

			$tblTelefono="7025_telefonos";
			$query[$x]="INSERT INTO 7025_datosContactoParticipante(idParticipante,fechaCreacion) VALUES(".$obj->idParticipante.
						",'".date("Y-m-d H:i:s")."')";
			$x++;
			
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;

		}
		else
		{
			$query[$x]="set @idRegistro:=".$fila["idRegistro"];
			$x++;
		}
		
	}
	else
	{
		$query[$x]="set @idRegistro:=".$fila["idRegistro"];
		$x++;
	}
	
	
	$query[$x]="INSERT into ".$tblTelefono."(idReferencia,tipoTelefono,lada,numero,extension) 
				VALUES(@idRegistro,'".$obj->tipoTel."','".$obj->lada."','".$obj->numero."',".($obj->extension==''?"NULL":("'".$obj->extension."'")).")";
	$x++;
	
	
	$query[$x]="commit";
	$x++;
	
	eB($query);
	
	
}

function obtenerDocumentosOrdenNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	
	
	$nRegistros=0;
	$arrRegistros="";
	
	$consulta="SELECT idDocumento FROM 7043_documentosNotificacion WHERE idOrden=".$iO;
	
	$resDocumentos=$con->obtenerFilas($consulta);
	while($fDocumento=mysql_fetch_row($resDocumentos))
	{
		$consulta="SELECT nomArchivoOriginal,tamano,fechaCreacion,categoriaDocumentos,descripcion FROM 908_archivos WHERE idArchivo=".$fDocumento[0];
		$fArchivo=$con->obtenerPrimeraFila($consulta);
		if(!$fArchivo)
			continue;
		$arrDatosArchivo=explode(".",$fArchivo[0]);
		$consulta="SELECT * FROM 9049_visoresDocumentos WHERE extension='".$arrDatosArchivo[sizeof($arrDatosArchivo)-1]."'";
		$fConfiguracionVisor=$con->obtenerPrimeraFila($consulta);
		
		if(strlen($arrDatosArchivo[0])>18)		
			$nombreDocumentoCorto=mb_substr($arrDatosArchivo[0],0,12)."...(".$arrDatosArchivo[1].")";
		else
			$nombreDocumentoCorto=$arrDatosArchivo[0]." (".$arrDatosArchivo[1].")";
		
		$consulta="SELECT etapaProcesal,idFormulario,idRegistro FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fDocumento[0];
		$fContenido=$con->obtenerPrimeraFila($consulta);
		
		$o='{"idDocumento":"'.$fDocumento[0].'","nomArchivoOriginal":"'.cv($fArchivo[0]).'","tamano":"'.$fArchivo[1].'","fechaCreacion":"'.$fArchivo[2].
			'","categoriaDocumentos":"'.$fArchivo[3].'","descripcion":"'.$fArchivo[4].'","etapaProcesal":"'.$fContenido.'","fechaRegistro":"'.
			date("Y-m-d",strtotime($fArchivo[2])).'","idFormulario":"'.$fContenido[1].'","idRegistro":"'.$fContenido[2].'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$nRegistros++;
	}
	
	
	echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';
}

function enviarMailNotificacion()
{
	global $con;
	global $versionLatis;
	global $baseDir;
	
	$arregloArchivosEliminar=array();
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	$arrArchivos=array();
	
	
	$query="SELECT idArchivo,nomArchivoOriginal,documentoRepositorio FROM 908_archivos WHERE idArchivo IN (".($obj->documentosAdjuntos==""?-1:$obj->documentosAdjuntos).")";
	$res=$con->obtenerFilas($query);
	
	while($fila=mysql_fetch_row($res))
	{
		$objDoc=array();
		$objDoc[0]=obtenerRutaDocumento($fila[0]);
		$objDoc[1]=$fila[1];
		$cuerpoDocumento="";
		$crearArchivoTemporal=false;
		if($objDoc[0]!="")
		{
			if(strpos($rutaDocumento,"http")!==false)
			{
				$cuerpoDocumento=file_get_contents($rutaDocumento);
				$crearArchivoTemporal=true;

			}
			
		}
		else
		{
			if($fila[2]!="")
			{
				$cadObj=file_get_contents("http://172.19.202.115:8000/api/document?instanceName=tsj&idGlobal=".$fila[2]);
				$objDocumento=json_decode($cadObj);
				
				$cuerpoDocumento= bD($objDocumento->file64);
				$crearArchivoTemporal=true;
				
			}
			else
			{
				$cuerpoDocumento=file_get_contents("http://10.19.5.9/paginasFunciones/obtenerDocumentoEditorArchivos.php?id=".bE($fila[0])."&nombreArchivo=".$fila[1]);
				$crearArchivoTemporal=true;
			
			}
		}
		if($crearArchivoTemporal)
		{
			$objDoc[0]=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
			escribirContenidoArchivo($objDoc[0],$cuerpoDocumento);
			array_push($arregloArchivosEliminar,$objDoc[0]);
	
		}
		array_push($arrArchivos,$objDoc);
		
	}
	
	
	
	
	
	$arrCopia=null;
	$arrDestinatarios=explode(",",$obj->destinatario);
	if(sizeof($arrDestinatarios)>1)
	{
		$arrCopia=array();
		for($x=1;$x<sizeof($arrDestinatarios);$x++)
		{
			$objCC=array();
			$objCC[0]=$arrDestinatarios[$x];
			$objCC[1]=$arrDestinatarios[$x];
			array_push($arrCopia,$objCC);
		}
	}
	
	$query="SELECT hostSMTP,puertoSMTP,autenticacionSMTP,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idUsuario=".$_SESSION["idUsr"];
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	$datosSMTP=array();
	$datosSMTP["hostSMTP"]=$fDatos[0];
	$datosSMTP["puerto"]=$fDatos[1]; 
	$datosSMTP["requiereAutenticacion"]=$fDatos[2];
	$datosSMTP["mail"]=$fDatos[3];
	$datosSMTP["password"]=$fDatos[4];
	$fechaEnvio=date("Y-m-d H:i:s");
	$llaveMail=date("YmdHis",strtotime($fechaEnvio)).rand(1000,9999).rand(1000,9999);
	
	$tblCadena="<br><br><table width='100%'><tr><td align='right'><span style='font-size:9px'>".$llaveMail."</span></td></tr></table>";
	$respuestaEnvio=enviarMailSMTP($datosSMTP,$obj->destinatario,$obj->asunto,($obj->cuerpoMail.$tblCadena),$arrArchivos,$arrCopia);
	if($respuestaEnvio[0])
	{
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="	INSERT INTO 7044_correosEnviados(fechaEnvio,destinatario,documentosAdjuntos,asunto,cuerpoMail,idFormulario,
						idRegistro,complementario1,complementario2,llaveMail)
						VALUES('".$fechaEnvio."','".cv($obj->destinatario)."','".cv($obj->documentosAdjuntos).
						"','".cv($obj->asunto)."','".cv($obj->cuerpoMail)."',-7029,".$obj->idOrden.
						",'".$obj->tipoNotificacion."',".$obj->idParticipante.",'".$llaveMail."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			foreach($arregloArchivosEliminar as $archivo)
			{
				unlink($archivo);
			}
			echo "1|";
		}
	}
	else
	{
			echo "<br>".$respuestaEnvio[1];
	}
	
	
}

function obtenerCorreosEnviados()
{
	global $con;
	$idOrden=$_POST["iO"];
	$idParticipante=$_POST["iP"];
	$tipoNotificacion=$_POST["tN"];
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT idCorreo AS idMail,fechaEnvio,destinatario,situacion,cuerpoMail,asunto FROM 7044_correosEnviados WHERE idFormulario=-7029 
			AND idRegistro=".$idOrden."	AND complementario1='".$tipoNotificacion."' AND complementario2='".$idParticipante."' ORDER BY fechaEnvio DESC";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$obj='{"idMail":"'.$fila[0].'","fechaEnvio":"'.$fila[1].'","destinatario":"'.$fila[2].'","situacion":"'.$fila[3].
				'","detallesAdicionales":"'.cv($fila[4]).'<br><br>","asunto":"'.cv($fila[5]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$obj;
		else
			$arrRegistros.=",".$obj;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}


function obtenerBuzonesCorreos()
{
	global $con;
	global $versionLatis;
	$idCuentaMail=$_POST["iC"];

	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idRegistro=".$idCuentaMail;
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$arrDirectorio=$c->obtenerDirectorioBuzon();

		foreach($arrDirectorio as $directorio)
		{
			$arrDirectorio=explode("}",$directorio->name);
			
			$arrSubCarpetas=explode("/",$arrDirectorio[1]);
			for($nivel=0;$nivel<sizeof($arrSubCarpetas);$nivel++)
			{
				$subIndex="";
				for($nivelBase=0;$nivelBase<=$nivel;$nivelBase++)
				{
					$subIndex.='["'.$arrSubCarpetas[$nivelBase].'"]';
				}
				
				eval('if(!isset($aDirectorios'.$subIndex.'))$aDirectorios'.$subIndex.'=array();');
				
			}
			
			
			
		}
		
		
		foreach($aDirectorios as $directorio=>$resto)
		{
			if(strtoupper($directorio)=="[GMAIL]")
			{
				continue;
			}
			$llaveBase=$baseMail.$directorio;
			
			$nodosHijos=obtenerNodosHijosDirectorio($resto,$llaveBase);

			$infoComplementaria="";
			if($nodosHijos=="[]")
				$infoComplementaria=',"leaf":true';
			else
				$infoComplementaria=',"leaf":false,"expanded":true,children:'.$nodosHijos;

			$textoNodo=mb_strtoupper(str_replace("]","",str_replace("[","",str_replace("INBOX","Recibidos",$directorio))));
			
			if($nodosHijos!="[]")
			{
				$textoNodo='<b>'.$textoNodo.'</b>';
			}
				
			$o='{"icon":"../images/bullet_green.png","id":"'.$llaveBase.'","text":"'.cv($textoNodo).
				'"'.$infoComplementaria.'}';
				
			if($arrDirectoros=="")
				$arrDirectoros=$o;
			else
				$arrDirectoros.=",".$o;
		}
		
		$c->cerrarConexionServidor();
		
	}
	
	echo '['.$arrDirectoros.']';
	
}

function obtenerNodosHijosDirectorio($nodoBase,$llaveBasePadre)
{
	$arrDirectoros="";
	foreach($nodoBase as $directorio=>$resto)
	{
		$llaveBase=$llaveBasePadre."/".$directorio;
		
		$nodosHijos=obtenerNodosHijosDirectorio($resto,$llaveBase);
		$infoComplementaria="";
		if($nodosHijos=="[]")
			$infoComplementaria=',"leaf":true';
		else
			$infoComplementaria=',"leaf":false,children:'.$nodosHijos;
		
		$textoNodo=mb_strtoupper(str_replace("]","",str_replace("[","",$directorio)));
			
		if($nodosHijos!="[]")
		{
			$textoNodo='<b>'.$textoNodo.'</b>';
		}
			
			
		$o='{"icon":"../images/bullet_green.png","id":"'.$llaveBase.'","expanded":true,"text":"'.cv($textoNodo).'"'.$infoComplementaria.'}';
			
		if($arrDirectoros=="")
			$arrDirectoros=$o;
		else
			$arrDirectoros.=",".$o;
	}
	
	return '['.$arrDirectoros.']';
}

function obtenerCorreosBuzon()
{
	global $con;
	global $versionLatis;
	
	$arrMails="";
	$bandeja=$_POST["b"];
	$idOrden=$_POST["iO"];
	$idParticipante=$_POST["iP"];
	$tipoNotificacion=$_POST["tN"];
	
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$final=$start+$limit-1;
	
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT fechaEnvio FROM 7044_correosEnviados WHERE idFormulario=-7029 
			AND idRegistro=".$idOrden."	AND complementario1='".$tipoNotificacion."' AND complementario2='".$idParticipante."' ORDER BY fechaEnvio DESC";
	$fechaEnvio=$con->obtenerValor($consulta);
	if($fechaEnvio=="")
		$fechaEnvio=date("Y-m-d");

	$fechaEnvio=strtotime($fechaEnvio);
	$fechaEnvio=date("d",$fechaEnvio)."-".date("M",$fechaEnvio)."-".date("Y",$fechaEnvio);
	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idUsuario=".$_SESSION["idUsr"];
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$numReg=0;
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$arrCorreos=$c->obtenerCorreosBandeja($bandeja,"SINCE ".$fechaEnvio);
		$arrCorreosAuxiliar=array();
		for($x=sizeof($arrCorreos)-1;$x>0;$x--)
		{	
			array_push($arrCorreosAuxiliar,$arrCorreos[$x]);
		}
		$arrCorreos=$arrCorreosAuxiliar;
		
		if($final>sizeof($arrCorreos)-1)
		{
			$final=sizeof($arrCorreos)-1;
		}
		
		for($posMail=$start;$posMail<=$final;$posMail++)
		{
			$iC=$arrCorreos[$posMail];
			$asunto=$c->obtenerAsuntoMail($iC);
			$aRemitente=$c->obtenerRemitente($iC);
			$remitente="";
			if(trim($aRemitente[0])<>trim($aRemitente[1]))
				$remitente=$aRemitente[0]."<br>[".$aRemitente[1]."]";
			else
				$remitente=$aRemitente[0];
			$adjuntos=$c->obtenerAdjuntosMail($iC);
			$arrAdjuntos="";
			foreach($adjuntos as $a)
			{
				$o="['".cv($a["filename"])."','".strlen($a["attachment"])."']";
				if($arrAdjuntos=="")
					$arrAdjuntos=$o;
				else
					$arrAdjuntos.=",".$o;
			}
			$fechaRecepcion=$c->obtenerFechaMail($iC);
			$cuerpo=$c->obtenerCuerpoMail($iC,false);
			
			$oMail='{"idMail":"'.$iC.'","asunto":"'.cv($asunto).'","remitente":"'.cv($remitente).
				'","adjuntos":['.$arrAdjuntos.'],"fechaRecepcion":"'.$fechaRecepcion.'","cuerpo":"'.bE(utf8_encode($cuerpo)).'"}';
			if($arrMails=="")
				$arrMails=$oMail;
			else
				$arrMails.=",".$oMail;
				
			
			
			
		}
		$c->cerrarConexionServidor();
		echo '{"numReg":"'.sizeof($arrCorreos).'","registros":['.$arrMails.']}';
	}
}

function obtenerDocumentoAdjuntoMail()
{
	global $con;
	global $baseDir;
	global $versionLatis;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idUsuario=".$_SESSION["idUsr"];
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$numReg=0;
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$adjuntos=$c->obtenerAdjuntosMail($obj->idMail);
		$arrAdjuntos="";
		foreach($adjuntos as $a)
		{
			if($a["filename"]==$obj->nombreArchivo)
			{
				$nombreArchivo=rand()."_".date("dmY_Hms");
				$rutaFinal=$baseDir."/archivosTemporales/".$nombreArchivo;
				escribirContenidoArchivo($rutaFinal,$a["attachment"]);
				echo "1|".$nombreArchivo;
				return;
			}
		}
	}
}

function obtenerPartesProcesalesCarpetasNotificacion()
{
	global $con;
	$iC=$_POST["iC"];
	$cA=$_POST["cA"];
	$iA=-1;
	$iP=-1;
	if(isset($_POST["iA"]))
		$iA=$_POST["iA"];
	if(isset($_POST["iP"]))
		$iP=$_POST["iP"];
	$iO=-1;
	
	$check=0;
	if(isset($_POST["check"]))
		$check=1;
	if(isset($_POST["iO"]))
		$iO=$_POST["iO"];
	
	
	$sujetosProcesales="";
	if(isset($_POST["sujetosProcesales"]))
		$sujetosProcesales=$_POST["sujetosProcesales"];
	
	if($iA==-1)
	{	
		$consulta="SELECT idFormulario,idRegistro,idActividad FROM 7006_carpetasAdministrativas 
					WHERE carpetaAdministrativa='".$cA."'";
					
		if($iC!=-1)
			$consulta.=" and idCarpeta in(".$iC.")";
		
		$fCarpeta=$con->obtenerPrimeraFila($consulta);
		
		$idActividad=$fCarpeta[2];
		if(($fCarpeta[2]=="")||($fCarpeta[2]==-1))
		{
			$consulta="SELECT idActividad FROM _".$fCarpeta[0]."_tablaDinamica WHERE id__".$fCarpeta[0]."_tablaDinamica=".$fCarpeta[1];
			$idActividad=$con->obtenerValor($consulta);
		}
	}
	else
		$idActividad=$iA;
	
	$arrFiguras="";
	$consulta="SELECT id__5_tablaDinamica,etiquetaPlural FROM _5_tablaDinamica ".(($sujetosProcesales!="")?" where id__5_tablaDinamica in(".
			$sujetosProcesales.")":"")." ORDER BY codigo";
	
	$rFiguras=$con->obtenerFilas($consulta);

	while($fFiguras=mysql_fetch_row($rFiguras))
	{
		$oFigura=determinarLeyendaFiguraJuridica($fFiguras[0],-1,$cA)	;
		

		$fFiguras[1]=$oFigura[3];
			
		$arrPersonas="";
		$consulta="SELECT id__47_tablaDinamica,tipoPersona,upper(apellidoPaterno),upper(apellidoMaterno),upper(nombre),tipoDefensor,r.situacion FROM _47_tablaDinamica p,
					7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica and r.idActividad=".$idActividad."	
					and r.idFiguraJuridica=".$fFiguras[0]." and r.situacion=1 order by nombre,apellidoPaterno,apellidoMaterno";
		
		$rPersona=$con->obtenerFilas($consulta);
		while($fPersona=mysql_fetch_row($rPersona))
		{
			$arrRelaciones="";
			$consulta="SELECT id__47_tablaDinamica,tipoPersona,upper(apellidoPaterno),upper(apellidoMaterno),upper(nombre),r.situacion FROM 7005_relacionParticipantes r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad."	AND idParticipante=".$fPersona[0].
					" AND r.idFiguraJuridica=".$fFiguras[0]." and p.id__47_tablaDinamica=r.idActorRelacionado and  r.situacion=1";
			$rRelacion=$con->obtenerFilas($consulta);		
			while($fRelacion=mysql_fetch_row($rRelacion))
			{
				
				$iconoRel="s.gif";
				
				$texto=$fRelacion[4]." ".$fRelacion[2]." ".$fRelacion[3];
				if($fRelacion[5]==0)
				{
					$texto="<span style='color:#BBB;'><i>".$texto."</i></span>";
					$iconoRel="bullet_red.png";
				}
				$oRelacion='{"id":"r_'.$fRelacion[0].'_'.$fPersona[0].'","icon":"../images/'.$iconoRel.'","tipo":"5","text":"'.cv($texto).'","nombre":"'.cv($fRelacion[4]." ".$fRelacion[2]." ".$fRelacion[3]).'","idPersona":"'.$fRelacion[0].
							'","leaf":true,"situacion":"'.$fRelacion[5].'"}';
				
				if($arrRelaciones=="")
					$arrRelaciones=$oRelacion;
				else
					$arrRelaciones.=",".$oRelacion;
				
				
			}
			
			$comp='"leaf":true';
			if($arrRelaciones!="")
			{
				$comp='"leaf":false,expanded:true,"children":['.$arrRelaciones.']';
			}
			
			$icono="bullet_white.png";
			
			$consulta="SELECT COUNT(*) FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$iO.
					" AND idNombreParteProcesal=".$fPersona[0]." AND notificado=1";
			
			$nNotificaciones=$con->obtenerValor($consulta);
			if($nNotificaciones>0)
			{
					$icono="bullet_green.png";
			}
			else
			{
				$consulta="SELECT COUNT(*) FROM 7029_diligenciaActaNotificacion WHERE idOrden=".$iO.
					" AND idNombreParteProcesal=".$fPersona[0]." AND notificado=0";
				$nNotificaciones=$con->obtenerValor($consulta);
				if($nNotificaciones>0)
				{
					$icono="bullet_red.png";
				}
			}
			
			$id='p_'.$fPersona[0]."_".$fFiguras[0];
			
			$iconAsistencia="";
			
			if($check==1)
			{
				if($iP!=-1)
				{
					$consulta="SELECT COUNT(*) FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad.
							" AND idParticipante=".$iP." AND idActorRelacionado=".$fPersona[0];
					$nReg=$con->obtenerValor($consulta);
					$comp.=",checked:".($nReg>0?"true":"false");
				}
				else
					$comp.=",checked:false";
			}
			$texto=$fPersona[4]." ".$fPersona[2]." ".$fPersona[3];
			
			if($fPersona[5]!="")
			{
				$consulta="SELECT etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$fFiguras[0]." AND idDetalle=".$fPersona[5];
				$etiquetaDetalle=$con->obtenerValor($consulta);
				$texto.=" (".$etiquetaDetalle.")";
			}
			
			
			
			if($fPersona[6]==0)
			{
				$texto="<span style='color:#BBB;'><i>".$texto."</i></span>";
			}
			$oP='{"idPersona":"'.$fPersona[0].'","personaJuridica":"'.$fFiguras[0].'","tipo":"1","nombre":"'.cv($fPersona[4]." ".$fPersona[2]." ".
				$fPersona[3]).'","situacion":"'.$fPersona[6].'","detalleFigura":"'.$fPersona[5].'","icon":"../images/'.$icono.'","id":"'.$id.'","text":"'.cv($texto).'",'.$comp.'}';
			if($arrPersonas=="")
				$arrPersonas=$oP;
			else
				$arrPersonas.=",".$oP;
		}
		
		if($arrPersonas!="")
		{
			$o='{"tipo":"0","expanded":true,"icon":"../images/s.gif","id":"f_'.$fFiguras[0].'","text":"<span style=\'color:#900; font-weight:bold\'>'.cv($fFiguras[1]).
				'</span>","leaf":false,children:['.$arrPersonas.'],"tipoFigura":"'.$oFigura[2].'"}';
			if($arrFiguras=="")
				$arrFiguras=$o;
			else
				$arrFiguras.=",".$o;
		}
	}
	
	if($iO!="-1")
	{
		$arrActas="";
		$consulta="SELECT f.idDocumento FROM 3000_formatosRegistrados f,7028_actaNotificacion a WHERE f.idFormulario=-1 AND f.idRegistro=a.idRegistro AND f.firmado=1 AND
				a.idOrden=".$iO;
		$rActas=$con->obtenerFilas($consulta);
		while($fActa=mysql_fetch_row($rActas))
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fActa[0];
			$nombreArchivo=$con->obtenerValor($consulta);
			$oActa='{"id":"acta_'.$fActa[0].'","idDocumento":"'.$fActa[0].'","text":"'.cv($nombreArchivo).'","nombreDocumento":"'.cv($nombreArchivo).
				'","icon":"../imagenesDocumentos/16/file_extension_pdf.png","tipo":"3",leaf:true}';
			if($arrActas=="")
				$arrActas=$oActa;
			else
				$arrActas.=",".$oActa;
		}
		
		$o='{"tipo":"2","expanded":true,"icon":"../s.gif","id":"f_-10","text":"<span style=\'color:#000; font-weight:bold\'>--- Actas firmadas ---</span>","leaf":false';
		if($arrActas=="")
			$o.=',"leaf":true}';
		else
			$o.=',"leaf":false,"children":['.$arrActas.']}';
		if($arrFiguras=="")
			$arrFiguras=$o;
		else
			$arrFiguras.=",".$o;
	}
	echo '['.$arrFiguras.']';
	
}

function cerrarOrdenNotificacion()
{
	global $con;
	$iO=$_POST["iO"];
	
	$consulta="UPDATE 7042_ordenesNotificacion SET situacion=4,idResponsableCierre=".$_SESSION["idUsr"].",fechaCierre='".date("Y-m-d H:i:s")."' WHERE idOrden=".$iO;
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="SELECT iFormulario,iRegistro,carpetaJudicial,idCarpeta FROM 7042_ordenesNotificacion WHERE idOrden=".$iO;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		if(($fRegistro[0]!=-1)&&($fRegistro[1]!=-1))
		{
			$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro[2]."'";
			if($fRegistro[3]!="-1")
			{
				$consulta.=" and idCarpeta=".$fRegistro[3];
			}
			$unidadGestion=$con->obtenerValor($consulta);
			$consulta="SELECT u.idUsuario FROM 807_usuariosVSRoles u,801_adscripcion a WHERE u.codigoRol='38_0'
						AND a.idUsuario=u.idUsuario AND a.Institucion='".$unidadGestion."'";
			$res=$con->obtenerFilas($consulta);			
			while($fila=mysql_fetch_row($res))			
				registrarNotificacionOrdenNotificacionNotificador(5,"Orden de notificaci&oacute;n cerrada",$fila[0],"38_0",$fRegistro[2],$_SESSION["idUsr"],"32_0",$iO);	
		}
		echo "1|";
	}
}

function reenviarDiligenciaCentralNotificadores()
{
	global $con;
	$idNotificacion=$_POST["idNotificacion"];
	
	$objResp=enviarDiligenciaCentralNotificadores($idNotificacion);
	
	if($objResp->resultado==1)
	{
		$consulta="SELECT idAcuseEnvioCentralNotificadores FROM 7029_diligenciaActaNotificacion WHERE idRegistro=".$idNotificacion;
		$idAcuseEnvioCentralNotificadores=$con->obtenerValor($consulta);	
		echo "1|1|".$idAcuseEnvioCentralNotificadores;
	}
	else
	{
		echo "1|0|".$objResp->mensaje;
	}
	
}


function modificarDatosPartesProcesalesExpediente()
{
	global $con;
	$cadObj=$_POST["cadObj"];	
	$obj=json_decode($cadObj);

	$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idParticipante=".$obj->idPersona." AND idCuentaAcceso IS NOT NULL";
	$idCuentaAcceso=$con->obtenerValor($consulta);
	
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="INSERT INTO _47_respadoDatosIdentificacion(idPersonaRegistro,fechaCambio,responsableCambio,
				tipoPersona,esMexicano,nacionalidad,otraNacionalidad,rfcEmpresa,curp,cedulaProfesional,
				nombre,apellidoPaterno,apellidoMaterno,genero,fechaNacimiento,edad,estadoCivil,
				tipoIdentificacion,otraIdentificacion,	detalleFiguraJuridica,folioIdentificacion,
				grupoEtnico,discapacidad,aceptaNotificacionMail,tarjetaProfesional,fechaIdentificacion,
				tipoEntidad,desconoceNIT,desconoceIdentificacion,desconoceDomicilio)		
				SELECT '".$obj->idPersona."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",tipoPersona,esMexicano,
				nacionalidad,otraNacionalidad,rfcEmpresa,curp,cedulaProfesional,nombre,apellidoPaterno,apellidoMaterno,
				genero,fechaNacimiento,edad,estadoCivil,tipoIdentificacion,otraIdentificacion,tipoDefensor,folioIdentificacion,
				grupoEtnico,discapacidad,aceptaNotificacionMail,tarjetaProfesional,fechaIdentificacion,tipoEntidad,desconoceNIT,
				desconoceIdentificacion,desconoceDomicilio 
				FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$obj->idPersona;
	$x++;
	$query[$x]="set @idRegistroPersona:=(select last_insert_id())";
	$x++;
	$query[$x]="INSERT INTO _47_respaldoAlias(idRegistroRespaldo,nombre,apPaterno,apMaterno)
				SELECT @idRegistroPersona,nombre,apPaterno,apMaterno FROM _47_gAlias WHERE idReferencia=".$obj->idPersona;
	$x++;
	
	$query[$x]="UPDATE _47_tablaDinamica SET tipoPersona=".$obj->tipoPersona.",nacionalidad='".$obj->nacionalidad."',otraNacionalidad='".cv($obj->otraNacionalidad).
				"',rfcEmpresa='".cv($obj->rfc)."',apellidoPaterno='".cv(trim($obj->apPaterno))."',apellidoMaterno='".cv(trim($obj->apMaterno))."',nombre='".cv(trim($obj->nombre)).
				"',genero=".$obj->genero.",fechaNacimiento=".($obj->fechaNacimiento==""?"NULL":"'".$obj->fechaNacimiento."'").
				",edad=".($obj->edad==""?"NULL":$obj->edad).",tipoIdentificacion='".$obj->identificacionPresentada.
				"',folioIdentificacion='".cv($obj->otraIdentificacion)."',otraIdentificacion='".cv($obj->otraIdentificacion).
				"',grupoEtnico=".($obj->grupoEtnico==""?"NULL":$obj->grupoEtnico).",discapacidad=".($obj->discapacidad==""?"NULL":$obj->discapacidad).
				",aceptaNotificacionMail=".($obj->aceptaNotificacionMail==""?"NULL":$obj->aceptaNotificacionMail).
				",tarjetaProfesional='".$obj->tarjetaProfesional."',fechaIdentificacion=".($obj->fechaIdentificacion==""?"NULL":"'".$obj->fechaIdentificacion."'").
				",tipoEntidad=".($obj->tipoEntidad==""?"NULL":$obj->tipoEntidad)." WHERE id__47_tablaDinamica=".$obj->idPersona;
	$x++;
	
	if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
	{
		$query[$x]="UPDATE 802_identifica SET Nacionalidad='".$obj->nacionalidad."',RFC='".cv($obj->rfc).
					"',Paterno='".cv(trim($obj->apPaterno))."',Materno='".cv(trim($obj->apMaterno))."',Nom='".cv(trim($obj->nombre)).
					"',Genero=".$obj->genero.",fechaNacimiento=".($obj->fechaNacimiento==""?"NULL":"'".$obj->fechaNacimiento."'").
					",tipoIdentificacion='".$obj->identificacionPresentada."',
					noIdentificacion='".cv($obj->otraIdentificacion)."' WHERE idUsuario=".$idCuentaAcceso;
		$x++;
	}
	
	if(isset($obj->relacionadoCon))
	{
		$arrRelacion=explode(",",$obj->relacionadoCon);
		$query[$x]="delete from 7005_relacionParticipantes where idActividad=".$obj->idActividad." and idParticipante=".$obj->idPersona;
		$x++;
		$query[$x]="delete from 7005_bitacoraCambiosFigurasJuridicas where idActividad=".$obj->idActividad.
				" and idParticipante=".$obj->idPersona." and idActorRelacionado<>-1";
		$x++;
		foreach($arrRelacion as $r)
		{
			if($r=="")
				continue;	
			$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
				VALUES(".$obj->idActividad.",".$obj->idPersona.",".$obj->tipoFigura.",".$r.",1)";
			$x++;
			$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
				situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
				(".$obj->idActividad.",".$obj->idPersona.",".$obj->tipoFigura.",".$r.",NULL,1,'".date("Y-m-d H:i:s").
				"',".$_SESSION["idUsr"].",'')";
			$x++;
		}
	}
	
	if(isset($obj->datosContacto))
	{
		
		$consulta="SELECT idRegistro FROM 7025_datosContactoParticipante WHERE idParticipante=".$obj->idPersona;
		$idRegistro=$con->obtenerValor($consulta);
		
		if($idRegistro=="")
			$idRegistro=-1;
		
		$o=$obj->datosContacto;
		
		$query[$x]=" INSERT INTO 7025_datosContactoParticipanteRespaldos(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,responsableModificacion,
					 fechaModificacion)				
					SELECT idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,
					 ".$_SESSION["idUsr"]." as responsableModificacion,'".date("Y-m-d H:i:s")."' fechaModificacion FROM
					 7025_datosContactoParticipante WHERE idParticipante=".$obj->idPersona;
		$x++;
		$query[$x]="set @iRegistroRespaldo:=(select last_insert_id())";
		$x++;
		
		$query[$x]="INSERT INTO 7025_correosElectronicoRespaldos(idReferencia,correo)
					SELECT  @iRegistroRespaldo,correo FROM 7025_correosElectronico WHERE idReferencia=".$idRegistro;
		$x++;
		$query[$x]="INSERT INTO 7025_telefonosRespaldos( idReferencia,tipoTelefono,lada,numero,extension,idPais)
					SELECT  @iRegistroRespaldo,tipoTelefono,lada,numero,extension,idPais FROM 7025_telefonos WHERE idReferencia=".$idRegistro;
		$x++;						
						 
		$query[$x]="update 7025_datosContactoParticipante set fechaCreacion='".date("Y-m-d H:i:s")."',calle='".cv($o->calle)."',
					noExt='".cv($o->noExt)."',noInterior='".cv($o->noInt)."',colonia='".cv($o->colonia)."',codigoPostal=".cv($o->cp==""?"NULL":("'".$o->cp."'")).",
					entidadFederativa='".cv($o->estado)."',municipio='".cv($o->municipio)."',localidad='".cv($o->localidad)."',
					entreCalle='".cv($o->entreCalle)."',yCalle='".cv($o->yCalle)."',otrasReferencias='".cv($o->referencias)."'
					where idRegistro=".$idRegistro;
					
		$x++;
		
		
		if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
		{
			$query[$x]="UPDATE 803_direcciones SET Calle='".cv($o->calle)."',Numero='".cv($o->noExt)."',Colonia='".cv($o->colonia).
						"',Ciudad='".cv($o->localidad)."',CP=".cv($o->cp==""?"NULL":("'".$o->cp."'")).",Estado='".cv($o->estado)."',Municipio='".cv($o->municipio)."',NumeroInt='".cv($o->noInt)."'
						WHERE idUsuario=".$idCuentaAcceso;	
			$x++;
		}
		
		$query[$x]="set @idRegistro:=".$idRegistro;
		$x++;
		
		$query[$x]="delete from 7025_correosElectronico where idReferencia=@idRegistro";
		$x++;
		foreach($o->mail as $m)
		{
			$query[$x]="INSERT INTO 7025_correosElectronico(idReferencia,correo) VALUES(@idRegistro,'".cv($m->mail)."')";
			$x++;
		}
		$query[$x]="delete from 7025_telefonos where idReferencia=@idRegistro";
		$x++;
		foreach($o->arrTelefonos as $t)
		{
			$query[$x]="INSERT INTO 7025_telefonos(idReferencia,tipoTelefono,lada,numero,extension,idPais) VALUES(@idRegistro,'".$t->tipoTelefono.
						"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->pais.")";
			$x++;
		}
		
		if(($idCuentaAcceso!="")&&($idCuentaAcceso!=-1))
		{
			$query[$x]="delete from 805_mails where idUsuario=".$idCuentaAcceso;
			$x++;
			foreach($o->mail as $m)
			{
				$query[$x]="INSERT INTO 805_mails(idUsuario,Mail,Tipo,Notificacion) VALUES(".$idCuentaAcceso.",'".cv($m->mail)."',0,1)";
				$x++;
			}
			$query[$x]="delete from 804_telefonos where idUsuario=".$idCuentaAcceso;
			$x++;
			foreach($o->arrTelefonos as $t)
			{
				$query[$x]="INSERT INTO 804_telefonos(idUsuario,Tipo2,Lada,Numero,Extension,codArea,Tipo) VALUES(".$idCuentaAcceso.",'".$t->tipoTelefono.
							"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->pais.",0)";
				$x++;
			}
		}
		
		
		
		
	}
	
	
	$query[$x]="commit";
	$x++;

	if($con->ejecutarBloque($query))
	{
		echo "1|";
	}
	
	
	
}

?>
