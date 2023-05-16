<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");
	include_once("sgjp/funcionesInterconexionSGJ.php");
	

	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerRegistrosLibroExpedientes();
		break;
		case 2:
			obtenerRegistrosLibroExhortos();
		break;
		case 3:
			obtenerRegistrosLibroPromociones();
		break;
		case 4:
			obtenerRegistrosLibroAmparos();
		break;
		case 5:
			obtenerRegistrosLibroApelaciones();
		break;
		case 6:
			obtenerRegistrosLibroIngresoValores();
		break;
		case 7:
			obtenerRegistrosLibroEgresoValores();
		break;
		case 8:
			obtenerRegistrosLibroFianzas();
		break;
		case 9:
			obtenerRegistrosLibroSentencia();
		break;
		case 10:
			obtenerRegistrosLibroOficios();
		break;
		case 11:
			obtenerRegistrosLibroActuarios();
		break;
		case 12:
			obtenerRegistrosLibroPeritos();
		break;
		case 13:
			obtenerRegistrosLibroNotarios();
		break;
		case 14:
			obtenerRegistrosLibroMultas();
		break;
		case 15:
			obtenerRegistrosLibroMP();
		break;
		case 16:
			obtenerRegistrosLibroEnvioArchivo();
		break;
		case 17:
			obtenerRegistrosLibroSolicitudArchivo();
		break;
		case 18:
			obtenerRegistrosLibroEnvioArchivoDestruccion();
		break;
		case 19;
			obtenerRegistroLibroMediosConstitucionales();
		break;
		case 20:
			obtenerRegistroLibroOficialiaPartes();
		break;
		case 21:
			obtenerRegistroLibroPromociones();
		break;
		case 22:
			obtenerRegistroLibroAsuntosPasanAcuerdo();
		break;
		case 23:
			obtenerRegistroLibroAudiencias();
		break;
		case 24:
			modificarSituacionRegistroLibroGobierno();
		break;
		case 25:
			obtenerRegistroLibroOficios();
		break;
	}

	function obtenerRegistrosLibroExpedientes()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$noFolio=1;
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_478_tablaDinamica e WHERE
					tipoLibro=4 AND anio=".$anio." AND unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__478_tablaDinamica=pr.iRegistro
					AND tipoExpediente=1 and secretariaAsignada IN(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__478_tablaDinamica AS idRegistro,'478' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa AS noExpediente,
					tipoJuicio, CONCAT(fechaRecepcion,' ',horaRecepcion) AS fechaRecepcion,e.idActividad,e.secretariaAsignada,c.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_478_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=4 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__478_tablaDinamica=pr.iRegistro
					AND tipoExpediente<>2  and c.secretariaAsignada IN(".$secretarias.") and c.idRegistro=e.id__478_tablaDinamica
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$noFolio.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","secretaria":"'.$fila[7].'","tipoExpediente":"'.$fila[8].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$noFolio++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroExhortos()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$ctReg=1;
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_478_tablaDinamica e WHERE
					tipoLibro=5 AND anio=".$anio." AND unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__478_tablaDinamica=pr.iRegistro
					AND tipoExpediente=2 and secretariaAsignada IN(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__478_tablaDinamica AS idRegistro,'478' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa AS noExpediente,
					tipoJuicio, CONCAT(fechaRecepcion,' ',horaRecepcion) AS fechaRecepcion,e.idActividad,e.secretariaAsignada,c.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_478_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=5 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__478_tablaDinamica=pr.iRegistro
					AND tipoExpediente=2 and c.secretariaAsignada IN(".$secretarias.")  and c.idRegistro=e.id__478_tablaDinamica order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _491_tablaDinamica WHERE idReferencia=".$fila[0];
			$fExhorto=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","tipoIngreso":"'.$fExhorto["tipoIngreso"].'","noExpedienteExhorto":"'.
				$fExhorto["noExpediente"].'","noOficio":"'.$fExhorto["noOficio"].'","autoridadExhortante":"'.$fExhorto["autoridadExhortante"].
				'","secretaria":"'.$fila[7].'","tipoExpediente":"'.$fila[8].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroPromociones()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_96_tablaDinamica e WHERE
					tipoLibro=3 AND anio=".$anio." AND unidadGestion='".$_SESSION["codigoInstitucion"]."' 
					AND e.id__96_tablaDinamica=pr.iRegistro and e.secretariaAsignada IN(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__96_tablaDinamica AS idRegistro,'96' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, concat(e.fechaRecepcion,' ',e.horaRecepcion) AS fechaRecepcion,ex.idActividad,e.numeroPromocion,e.tipoPromociones,
					e.noBillete,e.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_96_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=3 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__96_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and e.secretariaAsignada IN(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noPromocion":"'.$fila[7].'","tipoAsunto":"'.
				$fila[8].'","noBillete":"'.$fila[9].'","secretaria":"'.$fila[10].'","tipoExpediente":"'.$fila[11].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroAmparos()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_501_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=2 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__501_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__501_tablaDinamica AS idRegistro,'501' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, e.fechaCreacion AS fechaRecepcion,ex.idActividad,e.noAmpararo as noAmparo,organoJurisdiccionalRequiriente as juzgado,
					quejoso,actoReclamado,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_501_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=2 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__501_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) ))
						 FROM _47_tablaDinamica i WHERE id__47_tablaDinamica in(".$fila[9].")";
			$quejoso=$con->obtenerListaValores($consulta);
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noAmparo":"'.$fila[7].'","juzgado":"'.
				$fila[8].'","quejoso":"'.cv($quejoso).'","actoReclamado":"'.cv($fila[10]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroApelaciones()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_497_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=1 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__497_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__497_tablaDinamica AS idRegistro,'497' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, e.fechaCreacion AS fechaRecepcion,ex.idActividad,e.noApelacion,gradoRecurso,fechaActoAdmite,cA.secretariaAsignada
					,cA.tipoCarpetaAdministrativa FROM 7044_procesosLibrosGobierno pr,_497_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=1 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__497_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) ))
						 FROM _47_tablaDinamica i WHERE id__47_tablaDinamica in(".$fila[9].")";
			$quejoso=$con->obtenerListaValores($consulta);
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _499_tablaDinamica WHERE idReferencia=".$fila[0];
			$fRemision=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noApelacion":"'.$fila[7].'","gradoRecurso":"'.
				$fila[8].'","fechaActoAdmite":"'.$fila[9].'","fechaRemisionSala":"'.$fRemision["fechaRemision"].'","fechaRecepcionSala":"'.
				$fRemision["fechaRecepcionSala"].'","noOficio":"'.$fRemision["noOficioRemision"].'","secretaria":"'.$fila[10].
				'","tipoExpediente":"'.$fila[11].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroIngresoValores()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=6 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__509_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__509_tablaDinamica AS idRegistro,'509' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, concat(e.fechaRecepcion,' ',e.horaRecepcion) AS fechaRecepcion,ex.idActividad,e.noBillete,
					e.idActividad as idActividadValor,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=6 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__509_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _508_tablaDinamica WHERE idReferencia=".$fila[0];
			$fBillete=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=105";
			$beneficiario=$con->obtenerListaValores($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noBillete":"'.$fila[7].'","noOrden":"'.$fBillete["noOrden"].
				'","fechaExpedicion":"'.$fBillete["fechaExpedicion"].'","importe":"'.$fBillete["importe"].'","expedidor":"'.cv($fBillete["expedidor"]).
				'","beneficiario":"'.cv($beneficiario).'","tipoDocumento":"'.$fBillete["tipoDocumento"].'","secretaria":"'.$fila[9].
				'","tipoExpediente":"'.$fila[10].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}

	function obtenerRegistrosLibroEgresoValores()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=6 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__509_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__509_tablaDinamica AS idRegistro,'509' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, concat(e.fechaRecepcion,' ',e.horaRecepcion) AS fechaRecepcion,ex.idActividad,e.noBillete,
					e.idActividad as idActividadValor,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=6 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__509_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _508_tablaDinamica WHERE idReferencia=".$fila[0];
			$fBillete=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=105";
			$beneficiario=$con->obtenerListaValores($consulta);
			
			$consulta="SELECT * FROM _511_tablaDinamica WHERE idReferencia=".$fila[0];
			$fEgreso=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".($fEgreso["beneficiarios"]==""?-1:$fEgreso["beneficiarios"]);
			

			$personaRecibe=$con->obtenerValor($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noBillete":"'.$fila[7].'","noOrden":"'.$fBillete["noOrden"].
				'","fechaExpedicion":"'.$fBillete["fechaExpedicion"].'","importe":"'.$fBillete["importe"].'","expedidor":"'.cv($fBillete["expedidor"]).
				'","beneficiario":"'.cv($beneficiario).'","personaRecibe":"'.cv($personaRecibe).'","identificacionPresentada":"'.$fEgreso["identificacionPresentada"].
				'","noFojas":"'.$fEgreso["noFojas"].'","fechaAuto":"'.$fEgreso["fechaAuto"].'","otraIdentificacion":"'.cv($fEgreso["otraIdentificacion"]).
				'","tipoDocumento":"'.$fBillete["tipoDocumento"].'","secretaria":"'.$fila[9].'","tipoExpediente":"'.$fila[10].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroFianzas()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=8 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__509_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__509_tablaDinamica AS idRegistro,'509' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, concat(e.fechaRecepcion,' ',e.horaRecepcion) AS fechaRecepcion,ex.idActividad,e.noBillete,
					e.idActividad as idActividadValor,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_509_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=8 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__509_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _508_tablaDinamica WHERE idReferencia=".$fila[0];
			$fBillete=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=105";
			$beneficiario=$con->obtenerListaValores($consulta);
			
			
			$consulta="SELECT * FROM _531_tablaDinamica WHERE fianza=".$fila[0]." and idEstado>1";
			$fIncumplimiento=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","noBillete":"'.$fila[7].'","noOrden":"'.$fBillete["noOrden"].
				'","fechaExpedicion":"'.$fBillete["fechaExpedicion"].'","importe":"'.$fBillete["importe"].'","expedidor":"'.cv($fBillete["expedidor"]).
				'","beneficiario":"'.cv($beneficiario).'","vigenciaFianza":"'.$fBillete["vigenciaFianza"].'","concepto":"'.cv($fBillete["concepto"]).
				'","incumplimiento":"'.($fIncumplimiento?1:0).'","motivoIncumplimiento":"'.cv($fIncumplimiento["motivoIncumplimiento"]).'","fechaOficio":"'.
				$fIncumplimiento["fechaOficio"].'","noOficio":"'.$fIncumplimiento["noOficio"].'","idIncumplimiento":"'.
				$fIncumplimiento["id__531_tablaDinamica"].'","secretaria":"'.$fila[9].'","tipoExpediente":"'.$fila[10].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$ctReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroSentencia()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_532_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=9 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__532_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		
		
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__532_tablaDinamica AS idRegistro,'532' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, '' AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,cA.secretariaAsignada
					,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_532_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=9 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__532_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _532_tablaDinamica WHERE id__532_tablaDinamica=".$fila[0];
			$fSentencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaSentencia":"'.$fSentencia["fechaSentencia"].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","comentariosdAdicionales":"'.cv($fSentencia["comentariosAdicionales"]).
				'","secretaria":"'.$fila[9].'","tipoExpediente":"'.$fila[10].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroOficios()
	{
		
		global $con;
		$ctReg=1;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		
		
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_534_tablaDinamica e WHERE
					tipoLibro=10 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__534_tablaDinamica=pr.iRegistro ";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__534_tablaDinamica AS idRegistro,'534' AS idFormulario,noRegistro AS folio, 
					pr.fechaRegistro,noOficio,dirigidoA,asunto,responsable
					 FROM 7044_procesosLibrosGobierno pr,_534_tablaDinamica e WHERE
					tipoLibro=10 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__534_tablaDinamica=pr.iRegistro
					
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","fechaRegistro":"'.$fila[3].
				'","datosParticipantes":"'.cv($datosParticipantes).'","noOficio":"'.cv($fila[4]).'","dirigidoA":"'.cv($fila[5]).
				'","asunto":"'.cv($fila[6]).'","responsable":"'.cv(obtenerNombreUsuario($fila[7])).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$ctReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	}
	
	function obtenerRegistrosLibroActuarios()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_535_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=11 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' 
					AND e.id__535_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__535_tablaDinamica AS idRegistro,'535' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, '' AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,fechaDiligencia,descripcionDiligencia,
					responsableDiligencia,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_535_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=11 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__535_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaDiligencia":"'.$fila[9].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","descripcionDiligencia":"'.cv($fila[10]).
				'","responsableDiligencia":"'.cv($fila[11]).'","secretaria":"'.$fila[12].'","tipoExpediente":"'.$fila[13].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroPeritos()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_536_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=12 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' 
					AND e.id__536_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__536_tablaDinamica AS idRegistro,'536' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,motivoPeritaje,
					(select concat(nombre,' ',apPaterno,' ',apMaterno) from 7046_catalogoPeritos where idRegistro=e.perito) as nombrePerito,
					cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_536_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=12 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__536_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","motivoPeritaje":"'.cv($fila[9]).
				'","perito":"'.cv($fila[10]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$ctReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
		
	function obtenerRegistrosLibroNotarios()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_539_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=13 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__539_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__539_tablaDinamica AS idRegistro,'539' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,cA.idActividad as idActividadValor,
					CONCAT(nombreNotario,' ',apPaternoNotario,' ',apMaternoNotario) as nombreNotario,noNotaria,estadoNotaria,fechaConocimiento,
					cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_539_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=13 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__539_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _540_tablaDinamica WHERE idReferencia=".($fila[0]==""?-1:$fila[0]);
			
			$fDocumentosEntregados=$con->obtenerPrimeraFilaAsoc($consulta);
			$consulta="SELECT nombreDocumento FROM _540_gDocumentosEntregados WHERE idReferencia=".
					($fDocumentosEntregados["id__540_tablaDinamica"]==""?-1:$fDocumentosEntregados["id__540_tablaDinamica"])." ORDER BY nombreDocumento";
			$documentosEntregados=$con->obtenerListaValores($consulta);
			$consulta="SELECT * FROM _541_tablaDinamica WHERE idReferencia=".($fila[0]==""?-1:$fila[0]);
			$fDocumentosDevolucion=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$consulta="SELECT idOpcion FROM _541_documentosDevueltos WHERE idPadre=".($fDocumentosDevolucion["id__541_tablaDinamica"]==""?-1:$fDocumentosDevolucion["id__541_tablaDinamica"]);
			$listaDocumentos=$con->obtenerListaValores($consulta);
			if($listaDocumentos=="")
				$listaDocumentos=-1;
			$consulta="SELECT nombreDocumento FROM _540_gDocumentosEntregados WHERE id__540_gDocumentosEntregados in (".
					$listaDocumentos.")
						union
						SELECT nombreDocumento FROM _541_gOtrosDocumentos WHERE idReferencia=".($fDocumentosDevolucion["id__541_tablaDinamica"]==""?-1:$fDocumentosDevolucion["id__541_tablaDinamica"])."
					
					 ORDER BY nombreDocumento";
			
				
			$documentosDevueltos=$con->obtenerListaValores($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","nombreNotario":"'.cv($fila[7]).
				'","noNotaria":"'.cv($fila[8]).'","estadoNotaria":"'.cv($fila[9]).'","fechaAcuse":"'.$fDocumentosEntregados["fechaAcuse"].
				'","documentosEntregados":"'.cv($documentosEntregados).'","fechaDevolucin":"'.$fDocumentosDevolucion["fechaDevolucin"].
				'","documentosDevueltos":"'.cv($documentosDevueltos).'","fechaConocimiento":"'.$fila[10].
				'","comentariosEntrega":"'.cv($fDocumentosEntregados["comentariosAdicionales"]).'","comentariosDevolucion":"'.
				cv($fDocumentosDevolucion["comentariosAdicionales"]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroMultas()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_542_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=14 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__542_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__542_tablaDinamica AS idRegistro,'542' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,cA.idActividad as idActividadValor,
					fechaMulta,montoMulta,motivoMulta,comentariosAdicionales,personaMultada,e.idEstado,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_542_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=14 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__542_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT * FROM _544_tablaDinamica WHERE idReferencia=".$fila[0];
			$fCobro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila[11];
			$personaMultada=$con->obtenerValor($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","fechaMulta":"'.cv($fila[7]).
				'","montoMulta":"'.cv($fila[8]).'","motivoMulta":"'.cv($fila[9]).'","comentariosAdicionales":"'.cv($fila[10]).
				'","personaMultada":"'.cv($personaMultada).'","cobrado":"'.cv($fila[12]>=3?'Sí':'No').
				'","fechaCobro":"'.$fCobro["fechaCobro"].
				'","comentariosCobro":"'.cv($fCobro["comentariosAdicionales"]).'","secretaria":"'.$fila[13].'","tipoExpediente":"'.$fila[14].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroMP()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");

		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_545_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=15 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__545_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__545_tablaDinamica AS idRegistro,'545' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,fechaConocimiento,
					fechaAcuse,nombreMP,comentariosAdicionales,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_545_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=15 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__545_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","fechaConocimiento":"'.cv($fila[9]).
				'","fechaAcuse":"'.$fila[10].'","nombreMP":"'.cv($fila[11]).'","comentariosAdicionales":"'.cv($fila[12]).
				'","secretaria":"'.$fila[13].'","tipoExpediente":"'.$fila[14].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroEnvioArchivo()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=16 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__546_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__546_tablaDinamica AS idRegistro,'546' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,fechaEnvio,
					comentariosAdicionales,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=16 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__546_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
		
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","fechaEnvio":"'.cv($fila[9]).
				'","comentariosAdicionales":"'.cv($fila[10]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroSolicitudArchivo()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=17 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__546_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__546_tablaDinamica AS idRegistro,'546' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,fechaEnvio,
					comentariosAdicionales,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=17 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__546_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$consulta="SELECT fechaRecepcion,comentariosAdicionales FROM _548_tablaDinamica WHERE idReferencia=".$fila[0];
			$fIngreso=$con->obtenerPrimeraFila($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","fechaEnvio":"'.cv($fIngreso[0]).
				'","comentariosAdicionales":"'.cv($fIngreso[1]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$ctReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosLibroEnvioArchivoDestruccion()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anio=$_POST["anioJudicial"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		$ctReg=1;
		$consulta="SELECT idOpcion FROM _556_secretariaAsociada s,_556_tablaDinamica t WHERE s.idPadre=t.id__556_tablaDinamica
				AND t.rol IN(".$_SESSION["idRol"].")";
		$secretarias=$con->obtenerListaValores($consulta,"'");
		
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,7006_carpetasAdministrativas cA WHERE
					tipoLibro=18 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__546_tablaDinamica=pr.iRegistro and cA.idCarpeta=e.idCarpetaAdministrativa and cA.secretariaAsignada in(".$secretarias.")
		
		";
		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.id__546_tablaDinamica AS idRegistro,'546' AS idFormulario,noRegistro AS folio,cA.carpetaAdministrativa AS noExpediente,
					ex.tipoJuicio, fechaRegistro AS fechaRecepcion,ex.idActividad,'',cA.idActividad as idActividadValor,fechaEnvio,
					comentariosAdicionales,cA.secretariaAsignada,cA.tipoCarpetaAdministrativa
					 FROM 7044_procesosLibrosGobierno pr,_546_tablaDinamica e,_478_tablaDinamica ex,7006_carpetasAdministrativas cA WHERE
					tipoLibro=18 AND anio=".$anio." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"]."' AND e.id__546_tablaDinamica=pr.iRegistro
					and cA.idCarpeta=e.idCarpetaAdministrativa and ex.id__478_tablaDinamica= cA.idRegistro and cA.secretariaAsignada in(".$secretarias.")
					order by idRegistroLibro limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$ctReg.'","noExpediente":"'.$fila[3].
				'","tipoJuicio":"'.$fila[4].'","fechaRegistro":"'.$fila[5].'","demandado":"'.cv($arrDemandados).'","actor":"'.cv($arrActores).
				'","datosParticipantes":"'.cv($datosParticipantes).'","fechaEnvio":"'.cv($fila[9]).
				'","comentariosAdicionales":"'.cv($fila[10]).'","secretaria":"'.$fila[11].'","tipoExpediente":"'.$fila[12].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$ctReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistroLibroMediosConstitucionales()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=20;
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$idFormulario=478;
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

		$numReg=$con->obtenerValor($consulta);
		
		$numFila=1;
		$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
				"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,e.carpetaAdministrativa,
				CONCAT(fechaRecepcion,' ',horaRecepcion),idMagistradoInstructor,tiposAsuntosRecibidos,idActividad,
				pr.idRegistroLibro,pr.situacion,pr.fechaCancelacion,pr.motivoCancelacion
			  
			 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and idEstado>=1.5 order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			$consulta="  SELECT f.fechaFirma FROM 7035_informacionDocumentos i,3000_formatosRegistrados f 
  					  WHERE i.idFormulario=478 AND i.idReferencia=".$fila[0]."   AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro
					    AND f.idFormularioProceso=505";
			
  			$fechaAuto=$con->obtenerValor($consulta);
			
			$consulta="SELECT comentariosAdicionales FROM _589_tablaDinamica WHERE idReferencia=".$fila[0];
			$observaciones=$con->obtenerValor($consulta);
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila[3].
				'","comentariosAdicionales":"'.cv($fila[5]).'","noExpediente":"'.$fila[4].'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","fechaRecepcion":"'.$fila[5].'","magistradoInstructor":"'.obtenerNombreUsuario((($fila[6]=="")|| ($fila[6]=="N/E") )?-1:$fila[6]).
				'","tipoMedioControl":"'.$fila[7].'","fechaAuto":"'.$fechaAuto.'","datosParticipantes":"'.cv($datosParticipantes).
				'","observaciones":"'.cv($observaciones).'","situacion":"'.$fila[10].
				'","fechaCancelacion":"'.$fila[11].'","motivoCancelacion":"'.cv($fila[12]).'","iRegistroLibro":"'.$fila[9].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}
	
	function obtenerRegistroLibroOficialiaPartes()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=19;
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$idFormulario=478;
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

		$numReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_96_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__96_tablaDinamica=pr.iRegistro";

		$numReg+=$con->obtenerValor($consulta);
		
		$numFila=1;
		$consulta="select * from(SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
				"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,e.carpetaAdministrativa,
				CONCAT(fechaRecepcion,' ',horaRecepcion),idMagistradoInstructor,tiposAsuntosRecibidos,idActividad,
				noOficio,noCopiasAnexos,nombrePromovente,observaciones,terminoConcedido,pr.idRegistroLibro,pr.situacion,
				pr.fechaCancelacion,pr.motivoCancelacion,e.noAnexos
			  
			 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and idEstado>=1.5
			
			union
			
			SELECT e.id__96_tablaDinamica AS idRegistro,'96' AS idFormulario,noRegistro AS folio,e.fechaCreacion,c.carpetaAdministrativa,
				CONCAT(fechaRecepcion,' ',horaRecepcion),c.idJuezTitular as idMagistradoInstructor,e.tipoPromocion as tiposAsuntosRecibidos,c.idActividad,
				noOficio,noCopiasAnexos,usuarioPromovente as nombrePromovente,observaciones,terminoConcedido,pr.idRegistroLibro,pr.situacion,
				pr.fechaCancelacion,pr.motivoCancelacion,e.noAnexos
			  
			 FROM 7044_procesosLibrosGobierno pr,_96_tablaDinamica e,7006_carpetasAdministrativas c WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__96_tablaDinamica=pr.iRegistro and idEstado>=1.5 and c.idCarpeta=e.idCarpetaAdministrativa
			
			
			
			) as tmp order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_row($res))
		{
			
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[8]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			
			
			$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila[3].
				'","noExpediente":"'.$fila[4].'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","fechaRecepcion":"'.$fila[5].'","noOficio":"'.$fila[9].'","tipoMedioControl":"'.$fila[7].'","noCopiasAnexos":"'.$fila[10].
				'","terminoConcedido":"'.cv($fila[13]).'","datosParticipantes":"'.cv($datosParticipantes).'","observaciones":"'.cv($fila[12]).
				'","promovente":"'.cv(obtenerNombreImplicado($fila[11]==""?-1:$fila[11])).'","situacion":"'.$fila[15].
				'","fechaCancelacion":"'.$fila[16].'","motivoCancelacion":"'.cv($fila[17]).'","iRegistroLibro":"'.$fila[14].
				'","noAnexos":"'.$fila[18].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}
	
	function obtenerRegistroLibroOficios()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=13;
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$idFormulario=534;
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND pr.anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

		$numReg=$con->obtenerValor($consulta);
		
		$numFila=1;
		$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
				"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,e.asunto,
				(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=e.idCarpetaAdministrativa) as carpetaAdministrativa, noOficio,
				pr.idRegistroLibro,pr.situacion,pr.fechaCancelacion,pr.motivoCancelacion,e.dirigidoA,e.fechaOficio,e.fechaEntrega,e.comentariosAdicionales,idCarpetaAdministrativa
			  
			 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND pr.anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and idEstado>=1
			order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_assoc($res))
		{
			$tipoMedio=-1;
			$consulta="SELECT carpetaAdministrativa,idActividad,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE idCarpeta=".($fila["idCarpetaAdministrativa"]==""?-1:$fila["idCarpetaAdministrativa"]);
			$filaCarpeta=$con->obtenerPrimeraFila($consulta);
			$carpetaAdministrativa=$filaCarpeta[0];
			$idActividad=$filaCarpeta[1];
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			if($filaCarpeta)
			{
				$consulta="SELECT tiposAsuntosRecibidos FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$filaCarpeta[3];
				$tipoMedio=$con->obtenerValor($consulta);
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
                                                       
														
			$o=	'{"idRegistro":"'.$fila["idRegistro"].'","idFormulario":"'.$fila["idFormulario"].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila["fechaCreacion"].
				'","noExpediente":"'.$carpetaAdministrativa.'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","noOficio":"'.$fila["noOficio"].'","datosParticipantes":"'.cv($datosParticipantes).'","observaciones":"'.cv($fila["comentariosAdicionales"]).
				'","situacion":"'.$fila["situacion"].
				'","fechaCancelacion":"'.$fila["fechaCancelacion"].'","motivoCancelacion":"'.cv($fila["motivoCancelacion"]).
				'","iRegistroLibro":"'.$fila["idRegistroLibro"].'","tipoMedioControl":"'.$tipoMedio.'","destinatario":"'.cv($fila["dirigidoA"]).
				'","fechaOficio":"'.$fila["fechaOficio"].'","fechaEntrega":"'.$fila["fechaEntrega"].'","asunto":"'.cv($fila["asunto"]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}
	
	
	function obtenerRegistroLibroAsuntosPasanAcuerdo()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=23;
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$idFormulario=96;
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

		$numReg=$con->obtenerValor($consulta);
		
		$numFila=1;
		$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
				"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,c.carpetaAdministrativa,
				(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario.
				" AND idRegistro=e.id__".$idFormulario."_tablaDinamica AND etapaActual=1.5 order by idRegistroEstado desc limit 0,1 ) as fechaRecepcion, 
				noOficio,noCopiasAnexos,observaciones,c.idActividad,tipoPromocion,usuarioPromovente,
				pr.idRegistroLibro,pr.situacion,pr.fechaCancelacion,pr.motivoCancelacion
			  
			 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and idEstado>=2 and c.idCarpeta=e.idCarpetaAdministrativa 
			order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_assoc($res))
		{
			
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			$observaciones="";
			$contanciasRelativa="";
			
			$consulta="SELECT * FROM _591_tablaDinamica WHERE idReferencia=".$fila["idRegistro"];
			$fDatosArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fDatosArchivo["observaciones"])
			{
				
				$observaciones=$fDatosArchivo["observaciones"];
				$consulta="SELECT GROUP_CONCAT(nombreContancia SEPARATOR  '<br />') FROM _591_gConstanciasAsunto WHERE idReferencia=".$fDatosArchivo["id__591_tablaDinamica"];
				$contanciasRelativa=$con->obtenerValor($consulta);
			}
			
			$promovente=obtenerNombreImplicado($fila["usuarioPromovente"]);
			
			$o=	'{"idRegistro":"'.$fila["idRegistro"].'","idFormulario":"'.$fila["idFormulario"].'","folio":"'.$numFila.'","fechaRegistro":"'.$fDatosArchivo["fechaCreacion"].
				'","noExpediente":"'.$fila["carpetaAdministrativa"].'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","fechaRecepcion":"'.$fila["fechaRecepcion"].'","noOficio":"'.$fila["noOficio"].
				'","tipoPromocion":"'.$fila["tipoPromocion"].'","contanciasRelativa":"'.$contanciasRelativa.'","datosParticipantes":"'.
				cv($datosParticipantes).'","observaciones":"'.cv($observaciones).'","promovente":"'.cv($promovente).'","situacion":"'.$fila["situacion"].
				'","fechaCancelacion":"'.$fila["fechaCancelacion"].'","motivoCancelacion":"'.cv($fila["motivoCancelacion"]).
				'","iRegistroLibro":"'.$fila["idRegistroLibro"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}
	
	
	function obtenerRegistroLibroAudiencias()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$consulta="SELECT count(*) FROM 7000_eventosAudiencia e,
					7006_carpetasAdministrativas c,_185_tablaDinamica rA,_478_tablaDinamica rE WHERE
					e.fechaAsignacion>='".$anioJudicial."-01-01' AND e.fechaAsignacion<='".$anioJudicial."-12-31 23:59:59' AND
					rA.id__185_tablaDinamica=e.idRegistroSolicitud AND c.idCarpeta=rA.idCarpetaAdministrativa
					AND c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and rE.id__478_tablaDinamica=c.idRegistro";
		$numReg=$con->ObtenerValor($consulta);
		
		$consulta="SELECT e.*,c.idActividad,rA.fechaAuto,rA.comentariosAdicionales,c.carpetaAdministrativa,rE.tiposAsuntosRecibidos FROM 7000_eventosAudiencia e,
					7006_carpetasAdministrativas c,_185_tablaDinamica rA,_478_tablaDinamica rE WHERE
					e.fechaAsignacion>='".$anioJudicial."-01-01' AND e.fechaAsignacion<='".$anioJudicial."-12-31 23:59:59' AND
					rA.id__185_tablaDinamica=e.idRegistroSolicitud AND c.idCarpeta=rA.idCarpetaAdministrativa
					AND c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and rE.id__478_tablaDinamica=c.idRegistro limit ".$start.",".$limit;
		
		$numFila=1;
		

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_assoc($res))
		{
			
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			$consulta="SELECT * FROM _323_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
			$fCancelacion=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$o=	'{"idRegistro":"'.$fila["idRegistroSolicitud"].'","idFormulario":"'.$fila["idFormulario"].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila["fechaAsignacion"].
				'","noExpediente":"'.$fila["carpetaAdministrativa"].'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","fechaHoraAudiencia":"'.$fila["horaInicioEvento"].'","tipoMedioControl":"'.$fila["tiposAsuntosRecibidos"].
				'","tipoAudiencia":"'.$fila["tipoAudiencia"].'","situacionAudiencia":"'.$fila["situacion"].'","datosParticipantes":"'.
				cv($datosParticipantes).'","observaciones":"'.cv($fila["comentariosAdicionales"]).'","fechaAuto":"'.cv($fila["fechaAuto"]).
				'","iRegistroLibro":"'.$fila["idRegistroEvento"].'","fechaCancelacion":"'.$fCancelacion["fechaCreacion"].'","motivoCancelacion":"'.cv($fCancelacion["comentariosAdicionales"]).
				'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}
	
	function modificarSituacionRegistroLibroGobierno()
	{
		global $con;
		$tipoLibro=$_POST["tL"];
		$situacion=$_POST["s"];
		$comentarios=$_POST["c"];
		$idRegistro=$_POST["iR"];
		$fRegistro=null;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		switch($tipoLibro)
		{
			
			case 13://OFICIOS
				$query="SELECT iFormulario,iRegistro FROM 7044_procesosLibrosGobierno WHERE idRegistroLibro=".$idRegistro;
				$fRegistro=$con->obtenerPrimeraFila($query);
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE idRegistroLibro=".$idRegistro;
				$x++;
				
				
				
			break;
			case 19://LIBRO DE CONTROL DE OFICIALÍA DE PARTES
				$query="SELECT iFormulario,iRegistro FROM 7044_procesosLibrosGobierno WHERE idRegistroLibro=".$idRegistro;
				$fRegistro=$con->obtenerPrimeraFila($query);
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE idRegistroLibro=".$idRegistro;
				$x++;
				
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE iFormulario=".$fRegistro[0]." and iRegistro=".$fRegistro[1]." and idRegistroLibro<>".$idRegistro;
				$x++;	
				
				if($fRegistro[0]==478)
				{
					
					$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET situacion=22 WHERE idFormulario=478 AND idRegistro=".$fRegistro[1];
					$x++;
				}
			break;
			case 20://LIBRO DE REGISTRO DE MEDIOS DE CONTROL CONSTITUCIONAL
			
			$query="SELECT iFormulario,iRegistro FROM 7044_procesosLibrosGobierno WHERE idRegistroLibro=".$idRegistro;
			$fRegistro=$con->obtenerPrimeraFila($query);
			$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
						"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
						" WHERE idRegistroLibro=".$idRegistro;
			$x++;
			if($fRegistro[0]==478)
			{
				$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET situacion=22 WHERE idFormulario=478 AND idRegistro=".$fRegistro[1];
				$x++;
			}
			
			break;
			case 21://AGENDA DE AUDIENCIAS
			
				$consulta[$x]="INSERT INTO _323_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,idEvento,motivoCancelacion,comentariosAdicionales)
								VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'001','".$idRegistro."','7','".cv($comentarios)."')";
				$x++;
				$consulta[$x]="set @idRegistroCancelacion:=(select last_insert_id())";
				$x++;
			
			break;
			
			
			case 23://RECEPCIÓN DE PROMOCIONES
				$query="SELECT iFormulario,iRegistro FROM 7044_procesosLibrosGobierno WHERE idRegistroLibro=".$idRegistro;
				$fRegistro=$con->obtenerPrimeraFila($query);
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE idRegistroLibro=".$idRegistro;
				$x++;
				
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE iFormulario=".$fRegistro[0]."  and iRegistro=".$fRegistro[1]." and tipoLibro not in(19) 
							and idRegistroLibro<>".$idRegistro;
				$x++;	
				
			break;
			case 24://LISTA DE EXPEDIENTES QUE PASAN A ACUERDO
				$query="SELECT iFormulario,iRegistro FROM 7044_procesosLibrosGobierno WHERE idRegistroLibro=".$idRegistro;
				$fRegistro=$con->obtenerPrimeraFila($query);
				$consulta[$x]="UPDATE 7044_procesosLibrosGobierno SET situacion=".$situacion.",fechaCancelacion='".date("Y-m-d H:i:s").
							"',motivoCancelacion='".cv($comentarios)."',responsableCancelacion=".$_SESSION["idUsr"].
							" WHERE idRegistroLibro=".$idRegistro;
				$x++;
				
				
			break;
			default:
				
						
			break;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			switch($tipoLibro)
			{
				case 13://LIBRO DE REGISTRO DE MEDIOS DE CONTROL CONSTITUCIONAL
					cambiarEtapaFormulario($fRegistro[0],$fRegistro[1],10,$comentarios,-1,"NULL","NULL",0);
				break;
				case 19://LIBRO DE CONTROL DE OFICIALÍA DE PARTES
				case 20://LIBRO DE REGISTRO DE MEDIOS DE CONTROL CONSTITUCIONAL
					
					cambiarEtapaFormulario($fRegistro[0],$fRegistro[1],30,$comentarios,-1,"NULL","NULL",($fRegistro[0]==478?1118:950));
				break;
				case 21:
					$query="select @idRegistroCancelacion";
					$idRegistroCancelacion=$con->obtenerValor($query);
					cambiarEtapaFormulario(323,$idRegistroCancelacion,2,$comentarios,-1,"NULL","NULL",1119);
					$query="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idRegistro;
					$fAudiencia=$con->obtenerPrimeraFilaAsoc($query);
					cambiarEtapaFormulario($fAudiencia["idFormulario"],$fAudiencia["idRegistroSolicitud"],30,$comentarios,-1,"NULL","NULL",1120);
				break;
			}
			echo "1|";
		}
	}
	
	
	function obtenerRegistroLibroPromociones()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=23;
		$ctReg=1;
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		$idFormulario=96;
		$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

		$numReg=$con->obtenerValor($consulta);
		
		$numFila=1;
		$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
				"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,c.carpetaAdministrativa,
				CONCAT(fechaRecepcion,' ',horaRecepcion) as fechaRecepcion, noOficio,noCopiasAnexos,observaciones,c.idActividad,tipoPromocion,
				pr.idRegistroLibro,pr.situacion,pr.fechaCancelacion,pr.motivoCancelacion,e.noAnexos
			  
			 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
			tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
			"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and idEstado>=1.5 and c.idCarpeta=e.idCarpetaAdministrativa 
			order by idRegistroLibro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);					
		while($fila=mysql_fetch_assoc($res))
		{
			
			$datosParticipantes="";
			$arrDemandados="";
			$arrActores="";
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]."  and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$resActores=$con->obtenerFilas($consulta);
			while($filaActor=mysql_fetch_row($resActores))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaActor[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				$datosParticipantes.='<tr height="21"><td><b>Actor:</b></td><td>'.$filaActor[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrActores=="")
					$arrActores=$filaActor[0];
				else
					$arrActores.=",".$filaActor[0];
			}
			
			$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
						id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$resDemandados=$con->obtenerFilas($consulta);
			while($filaDemandado=mysql_fetch_row($resDemandados))
			{
				$objDomicilio=obtenerUltimoDomicilioFiguraJuridica($filaDemandado[1]);
				$oDomicilio=json_decode($objDomicilio);
				$domicilio=formatearDomicilio($oDomicilio);
				
				$datosParticipantes.='<tr><td><b>Demandado:</b></td><td>'.$filaDemandado[0].'</td><td>'.$domicilio.'</td></tr>';
				if($arrDemandados=="")
					$arrDemandados=$filaDemandado[0];
				else
					$arrDemandados.=",".$filaDemandado[0];
			}
			
			if($datosParticipantes!="")
			{
				$datosParticipantes='<table width="780"><tr><td width="80"></td><td width="250"></td><td width="450" align="left"><b>Domiclio</b></td></tr>'.$datosParticipantes.'</table>';
			}
			
			
			$o=	'{"idRegistro":"'.$fila["idRegistro"].'","idFormulario":"'.$fila["idFormulario"].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila["fechaCreacion"].
				'","noExpediente":"'.$fila["carpetaAdministrativa"].'","actor":"'.cv($arrActores).'","demandado":"'.cv($arrDemandados).
				'","fechaRecepcion":"'.$fila["fechaRecepcion"].'","noOficio":"'.$fila["noOficio"].
				'","tipoPromocion":"'.$fila["tipoPromocion"].'","noCopiasAnexos":"'.$fila["noCopiasAnexos"].'","datosParticipantes":"'.
				cv($datosParticipantes).'","observaciones":"'.cv($fila["observaciones"]).'","situacion":"'.$fila["situacion"].
				'","fechaCancelacion":"'.$fila["fechaCancelacion"].'","motivoCancelacion":"'.cv($fila["motivoCancelacion"]).
				'","iRegistroLibro":"'.$fila["idRegistroLibro"].'","noAnexos":"'.$fila["noAnexos"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numFila++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
				
	}