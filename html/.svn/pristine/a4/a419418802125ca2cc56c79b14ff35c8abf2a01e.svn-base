<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");

	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerPartesExpediente();
		break;
		case 2:
			obtenerCarpetasAdministrativasUnidadGestion();
		break;
		case 3:
			obtenerEventosAudienciaSGJJuzgados();
		break;
		case 4:
			obtenerEventosAudienciaJuezJuzgado();
		break;
		case 5:
			validarExistenciaExpediente();
		break;
		case 6:
			obtenerEventosModificacionFechaSalaJuzgado();
		break;
		case 7:
			registrarDatosPerito();
		break;
		case 8:
			actualizarSituacionAudiencia();
		break;
		case 9:
			obtenerCarpetasAdministrativasUnidadGestionPenalTradicional();
		break;
		case 10:
			registrarEventoControlPenalTradicional();
		break;
		case 11:
			registrarCambioMagistradoInstructor();
		break;
		case 12:	
			obtenerCarpetasAdministrativaSalaConstitucional();
		break;
		case 13:	
			buscarNoOficioSalaConstitucional();
		break;
	}
	
	function obtenerPartesExpediente()
	{
		global $con;
		
		$numReg=0;
		$idActividad=$_POST["idActividad"];
		$consulta="	SELECT idRelacion,idFiguraJuridica,
					CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre,
					id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad."
					AND  p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";

		$res=$con->obtenerfilas($consulta);
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$relacion="";
			
			$consulta="SELECT idOpcion FROM _47_personasAsocia WHERE idPadre=".$fila[3]."
						UNION
						SELECT 	idActorRelacionado FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idParticipante=".$fila[3];
			$listaRelacionados=$con->obtenerListaValores($consulta);
			if($listaRelacionados!="")
			{
				$consulta="SELECT CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre FROM
						_47_tablaDinamica p WHERE p.id__47_tablaDinamica in(".$listaRelacionados.") ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
				$resAsocia=$con->obtenerfilas($consulta);	
				while($filaAsocia=mysql_fetch_row($resAsocia))
				{
					if($relacion=="")
						$relacion=$filaAsocia[0];
					else
						$relacion.="<br>".$filaAsocia[0];
				}
			}
			$o='{"idParticipante":"'.$fila[0].'","idRegistro":"'.$fila[3].'","nombreParticipante":"'.cv($fila[2]).'","figura":"'.$fila[1].'","relacion":"'.cv($relacion).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerCarpetasAdministrativasUnidadGestion()
	{
		global $con;
		global $tipoMateria;
		$uG=$_POST["uG"];
		$anio=$_POST["anio"];
		$tC=$_POST["tC"];
		
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
						$condiciones=" and c.carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
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
		$secretariaAsignada="";
		if($tipoMateria=="SC")
		{
			$consulta="SELECT idOpcion FROM _556_secretariaAsociada sA,_556_tablaDinamica r WHERE sA.idPadre=r.id__556_tablaDinamica
						AND r.rol IN(".$_SESSION["idRol"].")";
			$secretariaAsignada=$con->obtenerListaValores($consulta,"'");
		}
		if($secretariaAsignada=="")
			$secretariaAsignada="-1";
		$arrRegistro="";
		$numReg=0;
		$consulta="SELECT c.carpetaAdministrativa,c.situacion,etapaProcesalActual,c.tipoCarpetaAdministrativa,c.carpetaAdministrativaBase,
					c.fechaCreacion,c.idActividad, c.carpetaInvestigacion,idCarpeta as idCarpetaAdministrativa,idFormulario,idRegistro 
					FROM 7006_carpetasAdministrativas  c,_478_tablaDinamica s
					WHERE c.unidadGestion='".$uG."'";
		
		
		
		if($tC!=0)
		{
			$consulta.=" and c.tipoCarpetaAdministrativa='".$tC."'";
		}
		
		switch($tipoMateria)
		{
			case "SC":
				$consulta.="  and  s.anioExpediente='".$anio."' and s.id__478_tablaDinamica=c.idRegistro
						 ".$condiciones." and c.secretariaAsignada in(".$secretariaAsignada.") ORDER BY carpetaAdministrativa";
			break;
			
			default:
				$consulta.="  and  s.anioExpediente='".$anio."' and s.id__478_tablaDinamica=c.idRegistro
						 ".$condiciones." ORDER BY carpetaAdministrativa";
			break;
		}
	
		if($tipoMateria=="SCC")
		{
			$consulta="SELECT c.carpetaAdministrativa,c.situacion,etapaProcesalActual,c.tipoCarpetaAdministrativa,c.carpetaAdministrativaBase,
					c.fechaCreacion,c.idActividad, c.carpetaInvestigacion,idCarpeta as idCarpetaAdministrativa,idFormulario,idRegistro 
					FROM 7006_carpetasAdministrativas  c,_478_tablaDinamica s,_589_tablaDinamica iE 
					WHERE c.unidadGestion='".$uG."' ";
		
		
		
			if($tC!=0)
			{
				$consulta.=" and c.tipoCarpetaAdministrativa='".$tC."'";
			}
			
			$consulta.="  and  iE.anioExpediente='".$anio."' and iE.idReferencia=s.id__478_tablaDinamica
							 ".$condiciones." ORDER BY carpetaAdministrativa";

		}

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$lblAcciones="";	
			
			$folioCarpetaInvestigacion=$fila[7];
			$cInicial="";
			
			
			if($fila[6]=="")	
				$fila[6]=-1;
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$demandados=$con->obtenerValor($consulta);
			
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$actores=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT juez,tipoJuicio,tipoExpediente FROM _478_tablaDinamica WHERE carpetaAdministrativa='".$fila[0]."' and id__478_tablaDinamica=".$fila[10];
			if($tipoMateria=="SCC")
			{
			}
			$fRegistroSolicitud=$con->obtenerPrimeraFila($consulta);
			if(!$fRegistroSolicitud)
			{
				$fRegistroSolicitud[0]=0;
				$fRegistroSolicitud[1]=0;
			}
			$ultimoJuez=obtenerNombreUsuario($fRegistroSolicitud[0]==""?-1:$fRegistroSolicitud[0]);
			
			$tipoAccion="";
			$consulta="SELECT * FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$fila[10];
			$fExpediente=$con->obtenerPrimeraFilaAsoc($consulta);
			if($tipoMateria=="SC")
			{	
				
				if($fExpediente)
				{
					$consulta="SELECT * FROM _551_tablaDinamica WHERE idReferencia=".$fExpediente["id__478_tablaDinamica"];
					$fComp=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$tipoAccion=$fComp["tipoAccion"]!=""?($fComp["tipoAccion"]=="AP"?"Acción Personal (AP)":"Acción Real (AR)"):"";
				}
			}
			$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[5].
				'","accionesCarpeta":"'.$lblAcciones.'","juez":"'.cv($ultimoJuez).'","demandados":"'.cv($demandados).
				'","actores":"'.cv($actores).'","tipoJuicio":"'.$fRegistroSolicitud[1].'","idCarpetaAdministrativa":"'.
				$fila[8].'","tipoAccion":"'.$tipoAccion.'","secretaria":"'.(isset($fExpediente["secretariaAsignada"])?$fExpediente["secretariaAsignada"]:"").
				'","tipoExpediente":"'.$fRegistroSolicitud[2].'"}';
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
	}
	
	function obtenerEventosAudienciaSGJJuzgados()
	{
		global $con;
		$idEvento="";
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
					case "idEvento":
						$idEvento=$filter[$x]["data"]["value"];
					break;
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
						if($filter[$x]["data"]["value"]!=0)
						{
							$c=" and idSala in(".$filter[$x]["data"]["value"].")";
							if($condiciones=="")
								$condiciones=$c;
							else
								$condiciones.=" ".$c;
						}
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
				}
			}
			
		}
		
		$uG=$_POST["uG"];
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		

		if(isset($_POST["sala"]) && ($_POST["sala"]!=0))
		{
			$condiciones.=" and idSala in(".$_POST["sala"].")";
		}
		
		$idActividad=-1;
		$arrRegistros="";//carpetaAdministrativa
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
				horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio,otroTipoAudiencia 
				FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null
				".$condiciones." " ;		
		
		
		if($uG!=0)		
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
			$iUnidad=$con->obtenerValor($query);
			$consulta.=" and idCentroGestion=".$iUnidad;
		}
		

		
		$numReg=0;
		if(isset($_POST["iEdificio"]))
		{
			$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
		}
			
		if($idEvento!="")
		{
			$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
					idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
					horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio,otroTipoAudiencia 
					FROM 7000_eventosAudiencia where idRegistroEvento = ".$idEvento ;
		}

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$query="SELECT GROUP_CONCAT(CONCAT('(',noJuez,') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
						7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];

			$jueces=$con->obtenerValor($query);
			
			if($juez!="")
			{
				if(stripos($jueces,$juez)===false)
				{
				
					continue;
				}
			}
			$tipoJuicio=0;
			$secretario="";
			$carpeta="";
			$tipoAudiencia=$fila[8];
			$tAudiencia="";
			$carpetaInvestigacion="";
			$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
					WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];

			$fDatos=$con->obtenerPrimeraFila($consulta);
			if($fDatos)
			{
				$carpeta=$fDatos[0];
				$consulta="SELECT idActividad,carpetaInvestigacion,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE 
						carpetaAdministrativa='".$carpeta."' and idCarpeta=".$fDatos[1];


				$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
				$idActividad=$fCarpetaInvestigacion[0];
				if($idActividad=="")
				{
					$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
				}
				
				$carpetaInvestigacion=$fCarpetaInvestigacion[1];
				
				$consulta="SELECT tipoJuicio,secretario FROM  _478_tablaDinamica WHERE id__478_tablaDinamica=".$fCarpetaInvestigacion[3];
				
				$fDatosJuicio=$con->obtenerPrimeraFila($consulta);

				$tipoJuicio=$fDatosJuicio[0];
				$secretario=obtenerNombreUsuario($fDatosJuicio[1]==""?-1:$fDatosJuicio[1]);
			}
			
			if($carpetaAdministrativa!="")
			{
				if(strpos($carpeta,$carpetaAdministrativa)!==0)
				{
					
					continue;
				}
			}
			
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
			
			
			$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".($fila[7]==""?-1:$fila[7]);

			$canal=$con->obtenerValor($consulta);
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$demandados=$con->obtenerListaValores($consulta);
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$actores=$con->obtenerListaValores($consulta);
			
			$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb not in(1000,99) ORDER BY fecha DESC	";
			$fRegistroNotificacionMajo=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb=99 ORDER BY fecha DESC	";
			$fRegistroNotificacionMail=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT tipoDelito FROM _17_gridDelitosAtiende WHERE idReferencia=".$fila[6];
			$tipoMateria=$con->obtenerValor($consulta);
			$o='{"urlCanal":"'.$canal.'","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
				'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
				"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
				'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","horaInicialReal":"'.$fila[11].
				'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
				'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
				"notificacionMAJO":"'.$fRegistroNotificacionMajo[0].'","mensajeMAJO":"'.cv($fRegistroNotificacionMajo[1]).
				'","edificio":"'.$fila[14].'","actores":"'.cv($actores).'","demandados":"'.cv($demandados).
				'","tipoJuicio":"'.$tipoJuicio.'","secretario":"'.cv($secretario).'","idCarpeta":"'.($fDatos[1]==""?-1:$fDatos[1]).
				'","otroTipoAudiencia":"'.cv($fila[15]).'","notificacionMail":"'.$fRegistroNotificacionMail[0].
				'","mensajeMail":"'.cv($fRegistroNotificacionMail[1]).'","tipoMateria":"'.$tipoMateria.'"}';
			
			$o=str_replace("\n","",$o);
			$o=str_replace("\r","",$o);
			$o=str_replace("\t","",$o);
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerEventosAudienciaJuezJuzgado()
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
		
		//$iJuez=$_POST["iJuez"];
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$idActividad=-1;
		
		$idCentroGestion=$_POST["j"];
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$idCentroGestion."'";
		$idCentroGestion=$con->obtenerValor($consulta);
		$arrRegistros="";//carpetaAdministrativa
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud ,urlMultimedia
				FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null and idCentroGestion=".$idCentroGestion."
				".$condiciones;
				
				
		/*if($iJuez!=0)		
		{
			$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud ,urlMultimedia
				FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null and j.idRegistroEvento=e.idRegistroEvento and j.idJuez=".$iJuez." 
				and situacion in (1,2,3,4,5)
				".$condiciones;
		}*/

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
			$tipoJuicio=0;
			$secretario="";
			$carpeta="";
			$idActividad="";
			$tipoAudiencia=$fila[8];
			
			$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
			$fDatos=$con->obtenerPrimeraFila($consulta);
			if($fDatos)
			{
				$carpeta=$fDatos[0];
				$consulta="SELECT idActividad,carpetaInvestigacion,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."' and idCarpeta=".$fDatos[1];
				$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
				$idActividad=$fCarpetaInvestigacion[0];
				if($idActividad=="")
				{
					$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
				}
				
				$consulta="SELECT tipoJuicio,secretario FROM  _478_tablaDinamica WHERE id__478_tablaDinamica=".$fCarpetaInvestigacion[3];
				$fDatosJuicio=$con->obtenerPrimeraFila($consulta);
				$tipoJuicio=$fDatosJuicio[0];
				$secretario=obtenerNombreUsuario($fDatosJuicio[1]);
				
			}
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
			$demandados=$con->obtenerListaValores($consulta);
			
			$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
					i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
			$actores=$con->obtenerListaValores($consulta);
			
			$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
			$canal=$con->obtenerValor($consulta);
			
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
				'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","edificio":"'.$fila[5].'","actores":"'.cv($actores).
				'","demandados":"'.cv($demandados).'","urlCanal":"'.$canal.'","urlMultimedia":"'.$fila[11].'","iFormularioSituacion":"'.$iFormularioSituacion.
				'","iRegistroSituacion":"'.$iRegistroSituacion.'","tipoJuicio":"'.$tipoJuicio.'","secretario":"'.cv($secretario).'"}';
			
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
		}
		
		echo '{"numReg":"","registros":['.$arrRegistros.']}';
	}
	
	function validarExistenciaExpediente()
	{
		global $con;
		
		$arrRegistros="";
		$j=$_POST["j"];
		$nE=$_POST["nE"];
		$anio=$_POST["anio"];
		$idRegistro=$_POST["iR"];
		$prefijo="";
		if(isset($_POST["prefijo"]))
			$prefijo=$_POST["prefijo"]."/";
		$resultado=0;
		$carpetaJudicial=str_pad($nE,4,"0",STR_PAD_LEFT)."/".$anio;
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa like '".($prefijo.$carpetaJudicial)."%' AND unidadGestion='".$j.
				"' and idRegistro<>".$idRegistro;

		$resRegistros=$con->obtenerFilas($consulta);
		$numReg=1;
		while($fila=mysql_fetch_assoc($resRegistros))
		{
			
			
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila["idActividad"]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$demandados=$con->obtenerValor($consulta);
			
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila["idActividad"]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$actores=$con->obtenerValor($consulta);
			
			$consulta="SELECT * FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$fila["idRegistro"];
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			$lblRegistro="<b>Folio de registro:</b> ".$fRegistro["codigo"]."<br>";
			$lblRegistro="<b>Fecha de registro:</b> ".date("d/m/Y H:i",strtotime($fRegistro["fechaCreacion"]))."<br>";
			$lblRegistro.="<b>Expediente:</b> <span style='color:#F00'>".$fRegistro["carpetaAdministrativa"]."</span><br>";
			$lblRegistro.="<b>Actor:</b> ".$actores."<br>";
			$lblRegistro.="<b>Demandado:</b> ".$demandados."<br><br>";
			
			$o="['".$numReg."','".cv($lblRegistro)."','".$fila["idFormulario"]."','".$fila["idRegistro"]."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		$arrRegistros="[".$arrRegistros."]";
		
	
		
		echo "1|".$arrRegistros."|".$numReg;
		
		
	}
	
	function obtenerEventosModificacionFechaSalaJuzgado()
	{
		global $con;
		global $tipoMateria;
		global $arrColoresSecretarias;
		
		$idEvento=$_POST["iEvento"];
		$idUnidadGestion=-1;
		
		if(isset($_POST["iU"]))
			$idUnidadGestion=$_POST["iU"];
		
		$idSala=$_POST["idSala"];
		$colorearSecretarias=$_POST["colorearSecretarias"];
		
		
		
		
		
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
		
		$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idUnidadGestion;
		$codigoInstitucion=$con->obtenerValor($consulta);			
		$asignacionJuez=0;
		
		$idJueces=-1;
		$consulta="SELECT usuarioJuez FROM _26_tablaDinamica WHERE idReferencia=".$idUnidadGestion;
		$idJueces=$con->obtenerListaValores($consulta);
		if($idJueces=="")
		{
			$idJueces=-1;
		}
			
		$fechaLimiteAtencion="";
		$arrEventos="";
		
		$listaEventosIgnorar=$idEvento;
		
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
		
		
		
		$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),idRegistroEvento,idSala FROM 7000_eventosAudiencia a
					WHERE idCentroGestion=".$idUnidadGestion." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
					a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
					and idRegistroEvento<>".$idEvento;
	
		if($idSala<>-1)
			$consulta.=" and a.idSala=".$idSala;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			array_push($arrFilasEventos,$fila);
		}
		
		foreach($arrFilasEventos as $fila)
		{
			$color="030";
			if($colorearSecretarias==1)
			{
				$consulta="SELECT claveSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica='".$fila[4]."'";	
				$claveSala=$con->obtenerValor($consulta);
				$arrSala=explode("_",$claveSala);
				$color=$arrColoresSecretarias[$arrSala[1]];
			}
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
			$cAdministrativa=$con->obtenerValor($consulta);
			$e='{"id":"e_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).' ['.$cAdministrativa.']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#'.$color.'"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		
		
		
		$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t WHERE 
					t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND t.codigoInstitucion='".$codigoInstitucion."' and idEstado=2";
		$iSala=$con->obtenerFilas($consulta);
		while($fIncidencia=mysql_fetch_row($iSala))
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
			$e='{"id":"iS_'.$fila[4].'","editable":false,"title":"El juzgado ha sido marcada como No disponible","start":"'.($start."T".$horaInicial).'","end":"'.($start."T".$horaFinal).'","color":"#B55381"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
	
		$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica,hInicio,hFin,tipoIntervalo,usuarioJuez FROM _20_tablaDinamica 
					WHERE usuarioJuez in(".$idJueces.") and fechaInicial<='".$start."' and fechaFinal>='".$start.
					"' and idEstado=1 ";

		$iJuez=$con->obtenerFilas($consulta);
		while($fIncidencia=mysql_fetch_row($iJuez))
		{
			
			if($fIncidencia[5]==1)
				$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez '.obtenerNombreUsuario($fIncidencia[6]).' se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
			else
				$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez '.obtenerNombreUsuario($fIncidencia[6]).'se reporta como No disponible","start":"'.($start."T".$fIncidencia[3]).'","end":"'.($start."T".$fIncidencia[4]).'","color":"#3D00CA"}';	
			
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		echo '['.$arrEventos.']';
		
	}
	
	function registrarDatosPerito()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="INSERT INTO 7046_catalogoPeritos(nombre,apPaterno,apMaterno) VALUES('".cv($obj->nombre).
				"','".cv($obj->apPaterno)."','".cv($obj->apMaterno)."')";
				
		if($con->ejecutarConsulta($consulta))
		{
			$idPerito=$con->obtenerUltimoID();
			$consulta="SELECT idRegistro,CONCAT(nombre,' ',apPaterno,' ',apMaterno) FROM 7046_catalogoPeritos";
			$arrPeritos=$con->obtenerFilasArreglo($consulta);
			
			echo "1|".$arrPeritos."|".$idPerito;
		}
		
	}
	
	function actualizarSituacionAudiencia()
	{
		global $con;
		$lAudiencias=$_POST["lAudiencias"];
		$arrAudiencias=explode(",",$lAudiencias);
		$s=$_POST["s"];
		$c=$_POST["c"];
		switch($s)
		{
			case 1:
				foreach($arrAudiencias as $a)
					enviarNotificacionMAJO($a);
			break;
			case 3:
				foreach($arrAudiencias as $a)
					notificarCancelacionEventoMAJO($a);
			break;
		}
		$consulta="UPDATE 7000_eventosAudiencia SET situacion=".$s.",comentariosAdicionales='".cv($c)."' WHERE idRegistroEvento IN(".$lAudiencias.")";
		eC($consulta);
		
	}
	
	
	function obtenerCarpetasAdministrativasUnidadGestionPenalTradicional()
	{
		global $con;
		global $tipoMateria;
		$uG=$_POST["uG"];
		$anio=$_POST["anio"];
		$tC=$_POST["tC"];
		
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
						$condiciones=" and c.carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
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
		$secretariaAsignada="";
		
		$arrRegistro="";
		$numReg=0;
		
		$consulta="SELECT c.carpetaAdministrativa,c.situacion,etapaProcesalActual,c.tipoCarpetaAdministrativa,c.carpetaAdministrativaBase,
					c.fechaCreacion,c.idActividad, c.carpetaInvestigacion,idCarpeta as idCarpetaAdministrativa,idFormulario,idRegistro 
					FROM 7006_carpetasAdministrativas  c,_486_tablaDinamica s
					WHERE c.unidadGestion='".$uG."'";
		
		
		
		if($tC!=0)
		{
			$consulta.=" and c.tipoCarpetaAdministrativa='".$tC."'";
		}
		
		$consulta.="  and  s.anioExpediente='".$anio."' and s.id__486_tablaDinamica=c.idRegistro
						 ".$condiciones."  ORDER BY carpetaAdministrativa";
		
		
		

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$lblAcciones="";	
			
			$folioCarpetaInvestigacion=$fila[7];
			$cInicial="";
			
			
			if($fila[6]=="")	
				$fila[6]=-1;
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$demandados=$con->obtenerValor($consulta);
			
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$actores=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT -1 as juez,'' as tipoJuicio,'1' as tipoExpediente FROM _486_tablaDinamica WHERE carpetaAdministrativa='".$fila[0]."' and id__486_tablaDinamica=".$fila[10];
			
			$fRegistroSolicitud=$con->obtenerPrimeraFila($consulta);
			if(!$fRegistroSolicitud)
			{
				$fRegistroSolicitud[0]=0;
				$fRegistroSolicitud[1]=0;
			}
			$ultimoJuez=obtenerNombreUsuario($fRegistroSolicitud[0]==""?-1:$fRegistroSolicitud[0]);
			
			$tipoAccion="";
			
			
			$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[5].
				'","accionesCarpeta":"'.$lblAcciones.'","juez":"'.cv($ultimoJuez).'","demandados":"'.cv($demandados).
				'","actores":"'.cv($actores).'","tipoJuicio":"'.$fRegistroSolicitud[1].'","idCarpetaAdministrativa":"'.
				$fila[8].'","tipoAccion":"'.$tipoAccion.'","secretaria":"","tipoExpediente":"'.$fRegistroSolicitud[2].'"}';
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
	}
	
	
	function registrarEventoControlPenalTradicional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$horaInicio=$obj->fecha." ".$obj->horaInicio;
		$horaFin=$obj->fecha." ".$obj->horaFin;
		if(!existeDisponibilidadSala($obj->idEvento,$obj->sala,$obj->fecha,$horaInicio,$horaFin))
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
					",situacion=1 where idRegistroEvento=".$obj->idEvento;
			$x++;
			$query[$x]="set @idRegistro:=".$obj->idEvento;
			$x++;
			
		}
		else
		{
			$etapa=obtenerEtapaProcesalCarpetaAdministrativa($obj->carpetaAdministrativa);
			$query[$x]="insert into 7000_eventosAudiencia(fechaEvento,horaInicioEvento,horaFinEvento,situacion,fechaAsignacion,idEdificio,idCentroGestion,
						idSala,idFormulario,idRegistroSolicitud,idReferencia,idEtapaProcesal,tipoAudiencia,fechaLimiteAtencion,fechaSolicitud,tipoTribunal)
						values('".$obj->fecha."','".$horaInicio."','".$horaFin."',1,'".date("Y-m-d H:i:s").
						"',".$obj->edificio.",".$obj->unidadGestion.",".$obj->sala.",".$obj->idFormulario.",".$obj->idRegistroSolicitud.",-1,".$etapa.",".
						$obj->tipoAudiencia.",NULL,'".date("Y-m-d H:i:s")."',1)";
			$x++;	
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;	
		}
		
		$query[$x]="DELETE FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=@idRegistro";
		$x++;	
		$noRondaMaxima=0;
		$serieRondaMaxima=0;	
	
	
		$lJuecesAsignados="";
		foreach($obj->jueces as $j)
		{
			if(!existeDisponibilidadJuez($j->idUsuario,$obj->fecha,$horaInicio,$horaFin,$obj->idEvento,"",true))
			{
				echo '0|<br>Ya no existe disponibilidad del Juez: '.obtenerNombreUsuario($j->idUsuario).'<br>';
				return;
			}
			
			if($lJuecesAsignados=="")
				$lJuecesAsignados=$j->idUsuario;
			else
				$lJuecesAsignados.=",".$j->idUsuario;
			
			$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$j->idUsuario;
			$noJuez=$con->obtenerValor($consulta);
			$query[$x]="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,ministerioLey,serieRonda,noRonda,idUGARonda) 
			VALUES(@idRegistro,".$j->idUsuario.",".$j->tipoJuez.",'".cv($j->participacion)."','".$noJuez."',".
			$j->ministerioLey.",'".$j->serieRonda."',".($j->noRonda==""?"NULL":$j->noRonda).",".$obj->unidadGestion.")";
			$x++;	
			
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
			
			$consulta="select @idRegistro";
			$idEventoAgenda=$con->obtenerValor($consulta);
			foreach($obj->jueces as $j)
			{		
				
				if($idJuezAnterior!=$j->idUsuario)
				{
					if($idJuezAnterior!="")
					{
						$consulta="UPDATE 7001_asignacionesJuezAudiencia SET situacion=6 WHERE idJuez=".$idJuezAnterior.
									" AND idEventoAudiencia= ".$idEventoAgenda;
						$con->ejecutarConsulta($consulta);
					}
					
					if($j->pagoAdeudo==1)
					{
						$consulta="SELECT idAsignacion FROM 7001_asignacionesJuezAudiencia 
									WHERE idJuez=".$j->idUsuario." AND tipoRonda='".$j->serieRonda."' 
									AND situacion=4 AND idUnidadGestion=".$obj->unidadGestion;
						$idAsignacion=$con->obtenerValor($consulta);
						if($idAsignacion!="")
						{
							$consulta="UPDATE 7001_asignacionesJuezAudiencia SET idEventoAudienciaPago=idEventoAudiencia , idEventoAudiencia=".$idEventoAgenda.
									",situacion=1, rondaPagada='".$j->noRonda."' WHERE idAsignacion=".$idAsignacion;
							
							$con->ejecutarConsulta($consulta);
						}
					}
					else
					{
						$arrParametros["idFormulario"]=$obj->idFormulario;
						$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
						$arrParametros["fechaEvento"]=$obj->fecha;
						$arrParametros["idJuez"]=$j->idUsuario;
						$arrParametros["tipoRonda"]=str_replace("'","",$j->serieRonda);
						$arrParametros["noRonda"]=$j->noRonda;
						$arrParametros["situacion"]=1;
						$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
						$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
						registrarAsignacionJuez($arrParametros);
					}
				}
					
				foreach($j->arrJuecesBloquear as $jBloqueo)
				{
					$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia WHERE idJuez=".$jBloqueo->idJuez.
							" AND tipoRonda='".$jBloqueo->serieRonda."' AND noRonda='".$jBloqueo->noRonda.
							"' AND idUnidadGestion=".$obj->unidadGestion;
					$nRegistros=$con->obtenerValor($consulta);
					if($nRegistros==0)
					{
						$arrParametros["idFormulario"]=$obj->idFormulario;
						$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
						$arrParametros["fechaEvento"]=$obj->fecha;
						$arrParametros["idJuez"]=$jBloqueo->idJuez;
						$arrParametros["tipoRonda"]=$jBloqueo->serieRonda;
						$arrParametros["noRonda"]=$jBloqueo->noRonda;
						$arrParametros["situacion"]=$jBloqueo->tipoBloqueo;
						$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
						$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
						$arrParametros["comentariosAdicionales"]=isset($jBloqueo->comentariosAdicionales)?$jBloqueo->comentariosAdicionales:"";
						registrarAsignacionJuez($arrParametros);
					}
				}
			}
				
			if($obj->arrJuezOriginal!="")
			{
				$oJuezOriginal=json_decode(bD($obj->arrJuezOriginal));
				
				
				$consulta="SELECT idAsignacion FROM 7001_asignacionesJuezAudiencia 
									WHERE idJuez=".$oJuezOriginal->idJuez." AND idEventoAudiencia=".$idEventoAgenda;
						
				$idAsignacion=$con->obtenerValor($consulta);
				if($idAsignacion=="")
				{
					
					$arrParametros["idFormulario"]=$obj->idFormulario;
					$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
					$arrParametros["fechaEvento"]=$obj->fecha;
					$arrParametros["idJuez"]=$oJuezOriginal->idJuez;
					$arrParametros["tipoRonda"]=$oJuezOriginal->serieRonda;
					$arrParametros["noRonda"]=$oJuezOriginal->noRonda;
					$arrParametros["situacion"]=6;
					$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
					$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
					$arrParametros["comentariosAdicionales"]=urldecode($oJuezOriginal->comentariosAdicionales);
					registrarAsignacionJuez($arrParametros);
				}
				else
				{
					
					$consulta="UPDATE 7001_asignacionesJuezAudiencia SET situacion=6 WHERE idAsignacion=".$idAsignacion;
					$con->ejecutarConsulta($consulta);
				}
				foreach($obj->jueces as $j)
				{
					$consulta="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,
							idJuezOriginal,idJuezCambio,comentariosAdicionales,idRegistroJuez)
						VALUES(".$idEventoAgenda.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$oJuezOriginal->idJuez.",".$j->idUsuario.",'".
						cv(urldecode($oJuezOriginal->comentariosAdicionales))."',".($idAsignacion==""?-1:$idAsignacion).")";
					$con->ejecutarConsulta($consulta);
				}
	
			}
	
			registrarAudienciaCarpetaAdministrativa($obj->idFormulario,$obj->idRegistroSolicitud,$idEventoAgenda);
			$consulta="SELECT idEstado FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistroSolicitud;
			$idEstado=$con->obtenerValor($consulta);
			switch($obj->idFormulario)
			{
				case 185:
					//if(($idEstado==1)||($idEstado==1.1))
					{
						desHabilitaraTareaAsignacionEventoJuez(185,$obj->idRegistroSolicitud,$lJuecesAsignados);
						cambiarEtapaFormulario(185,$obj->idRegistroSolicitud,5,"",-1,"NULL","NULL",648);
					}
					
				break;
			}
			@enviarNotificacionMAJO($idEventoAgenda);
			
			echo "1|".$idEventoAgenda;
			
		}
		else
			echo "0|";
		
		
	}
	
	function registrarCambioMagistradoInstructor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 7001_asignacionesObjetos SET situacion=2 WHERE idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro.
				" AND idUnidadReferida=".$obj->idUsuarioOriginal."  AND tipoRonda='MI' and tipoAsignacion='".$obj->tipoAsignacion."'";
		
		$x++;
		$consulta[$x]="INSERT INTO _589_bitacoraCambiosMagistradoInstructor(idMagistradoOriginal,idMagistradoCambio,fechaCambio,motivoCambio,responsableCambio,iFormulario,iRegistro)
				VALUES(".$obj->idUsuarioOriginal.",".$obj->idUsuarioCambio.",'".date("Y-m-d H:i:s")."','".cv($obj->motivoCambio)."',".$_SESSION["idUsr"].",".
				$obj->idFormulario.",".$obj->idRegistro.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		

		eB($consulta);
	}
	
	function obtenerCarpetasAdministrativaSalaConstitucional()
	{
		global $con;
		global $tipoMateria;
		$uG=$_POST["uG"];
		$anio=$_POST["anio"];
		$tC=$_POST["tC"];
		
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
						$condiciones=" and c.carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
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
		$secretariaAsignada="";
		
		
		
		$arrRegistro="";
		$numReg=0;
		
		$consulta="SELECT distinct c.carpetaAdministrativa,c.situacion,etapaProcesalActual,c.tipoCarpetaAdministrativa,c.carpetaAdministrativaBase,
				c.fechaCreacion,c.idActividad, c.carpetaInvestigacion,idCarpeta as idCarpetaAdministrativa,idFormulario,idRegistro,s.tiposAsuntosRecibidos,
				c.idJuezTitular 
				FROM 7006_carpetasAdministrativas  c,_478_tablaDinamica s,_593_tablaDinamica iE 
				WHERE c.unidadGestion='".$uG."' ";
	
	
	
		if($tC!=0)
		{
			$consulta.=" and c.tipoCarpetaAdministrativa='".$tC."'";
		}
		
		$consulta.="  and  iE.anioExpediente='".$anio."' and iE.idReferencia=s.id__478_tablaDinamica
						 ".$condiciones." and s.id__478_tablaDinamica=c.idRegistro ORDER BY carpetaAdministrativa";

		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$lblAcciones="";	
			
			$folioCarpetaInvestigacion=$fila[7];
			$cInicial="";
			
			
			if($fila[6]=="")	
				$fila[6]=-1;
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$demandados=$con->obtenerValor($consulta);
			
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order by nombre,apellidoPaterno,apellidoMaterno";

			$actores=$con->obtenerValor($consulta);
			
			
			$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[5].
				'","magistradoInstructor":"'.cv(obtenerNombreUsuario($fila[12])).'","demandados":"'.cv($demandados).
				'","actores":"'.cv($actores).'","tipoAsunto":"'.$fila[11].'","idCarpetaAdministrativa":"'.
				$fila[8].'"}';
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
	}
	
	
	function buscarNoOficioSalaConstitucional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$consulta="SELECT id__534_tablaDinamica AS idRegistro,dirigidoA,fechaOficio,noOficio,asunto,
					(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta= idCarpetaAdministrativa) AS carpetaAdministrativa 
					FROM _534_tablaDinamica WHERE noOficio=".$obj->folio." AND anio='".$obj->anio."' AND codigoInstitucion='".$_SESSION["codigoInstitucion"].
					"' AND id__534_tablaDinamica<>".$obj->idRegistro;
					
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		
		echo '1|'.$arrRegistros;					
		
	}
?>