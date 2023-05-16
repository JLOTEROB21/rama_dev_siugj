<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");
	include_once("sgjp/libreriaFuncionesAlzada.php");

	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerEventosAudienciaCarpeta();
		break;
		case 2:
			obtenerCarpetasAdministrativasTrubunalAlzada();
		break;
		case 3:
			obtenerEventosAudienciaSGJAlzada();
		break;
		case 4:
			obtenerEventosAudienciaJuezAlzada();
		break;
		case 5:
			validarExistenciaExpediente();
		break;
		case 6:
			obtenerMagistradosTribunal();
		break;
		case 7:
			registrarEventoTribunalAlzada();
		break;
		case 8:
			obtenerFiguraJuridicaCarpetaJudicial();
		break;
		case 9:
			registrarFiguraJuridicaApelante();
		break;
		case 10:
			registrarJuezMinisterioLey();
		break;
		case 11:
			registrarEventoJuzgadoTradicional();
		break;
	}
	
	function obtenerEventosAudienciaCarpeta()
	{
		global $con;
		
		$cA=$_POST["cA"];
		
		$aCarpetasAntecesoras=obtenerCarpetasAntecesoras($cA);
		$lCarpetas="";
		foreach($aCarpetasAntecesoras as $c)
		{
			if($lCarpetas=="")
				$lCarpetas="'".$c."'";
			else
				$lCarpetas.=",'".$c."'";
		}
		
		$consulta="SELECT idRegistroEvento,CONCAT(DATE_FORMAT(horaInicioEvento,'%d/%m/%Y %H:%i'),' ',a.tipoAudiencia) AS audiencia,
					(SELECT GROUP_CONCAT(idJuez) FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=e.idRegistroEvento) AS juez FROM 
					7007_contenidosCarpetaAdministrativa con,7000_eventosAudiencia e, _4_tablaDinamica a WHERE
					con.carpetaAdministrativa IN(".$lCarpetas.") AND con.tipoContenido=3 AND e.idRegistroEvento=con.idRegistroContenidoReferencia
					AND a.id__4_tablaDinamica=e.tipoAudiencia AND e.situacion IN(0,1,2,4,5) ORDER BY e.horaInicioEvento desc";
		
		$arrEventos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEventos;
	}
	
	function obtenerCarpetasAdministrativasTrubunalAlzada()
	{
		global $con;
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
						$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
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
		$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,tipoCarpetaAdministrativa,carpetaAdministrativaBase,
					fechaCreacion,idActividad, carpetaInvestigacion,idCarpeta as idCarpetaAdministrativa,idFormulario,idRegistro FROM 7006_carpetasAdministrativas 
					WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
					and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones." ORDER BY carpetaAdministrativa";
					
	
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$lblAcciones="";	
			
			$folioCarpetaInvestigacion=$fila[7];
			$cInicial="";
			
			if($fila[6]=="")	
				$fila[6]=-1;	
			
			$o='{"carpetaAdministrativa":"'.$fila[0].'","carpetaApelada":"'.$fila[4].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[5].
				'","accionesCarpeta":"'.$lblAcciones.'","idCarpetaAdministrativa":"'.$fila[8].'"}';
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
	}
	
	function obtenerEventosAudienciaSGJAlzada()
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
				horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
				FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null
				".$condiciones." " ;		
				
		if($uG!=0)		
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
			$iUnidad=$con->obtenerValor($query);
			$consulta.=" and idCentroGestion=".$iUnidad;
		}
		else
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=3";
			$iUnidad=$con->obtenerListaValores($query);
			$consulta.=" and idCentroGestion in(".$iUnidad.")";
		}
		
		$numReg=0;
		if(isset($_POST["iEdificio"]))
		{
			$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
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
			$tipoAudiencia=$fila[8];
			$tAudiencia="";
			$carpetaInvestigacion="";
			$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
			$fDatos=$con->obtenerPrimeraFila($consulta);
			if($fDatos)
			{
				$carpeta=$fDatos[0];
				$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."' and idCarpeta=".$fDatos[1];
				$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
				$idActividad=$fCarpetaInvestigacion[0];
				if($idActividad=="")
				{
					$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
				}
				$carpetaInvestigacion=$fCarpetaInvestigacion[1];
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
			
			
			$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
			$canal=$con->obtenerValor($consulta);
			
			
			
			$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion WHERE idEvento=".$fila[0]." and servicioWeb<>1000 ORDER BY fecha DESC	";
			$fRegistroNotificacionMajo=$con->obtenerPrimeraFila($consulta);
			
			
			
			$o='{"urlCanal":"'.$canal.'","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
				'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
				"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
				'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","horaInicialReal":"'.$fila[11].
				'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
				'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
				"notificacionMAJO":"'.$fRegistroNotificacionMajo[0].'","mensajeMAJO":"'.cv($fRegistroNotificacionMajo[1]).
				'","edificio":"'.$fila[14].'"}';
			
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
	
	function obtenerEventosAudienciaJuezAlzada()
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
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud ,urlMultimedia
				FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null
				".$condiciones;
				
				
		if($iJuez!=0)		
		{
			$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud ,urlMultimedia
				FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null and j.idRegistroEvento=e.idRegistroEvento and j.idJuez=".$iJuez." 
				and situacion in (1,2,3,4,5)
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
			$idActividad="";
			$tipoAudiencia=$fila[8];
			
			$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
			$fDatos=$con->obtenerPrimeraFila($consulta);
			if($fDatos)
			{
				$carpeta=$fDatos[0];
				$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."' and idCarpeta=".$fDatos[1];
				$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
				$idActividad=$fCarpetaInvestigacion[0];
				if($idActividad=="")
				{
					$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
				}
				
			}
			
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
				'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","edificio":"'.$fila[5].
				'","urlCanal":"'.$canal.'","urlMultimedia":"'.$fila[11].'","iFormularioSituacion":"'.$iFormularioSituacion.
				'","iRegistroSituacion":"'.$iRegistroSituacion.'"}';
			
			
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
		$t=$_POST["t"];
		$cA=$_POST["cA"];
		
		$idRegistro=$_POST["iR"];
		$resultado=0;
		$carpetaJudicial=$cA;
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."' AND unidadGestion='".$t."'";
		$nRegistros=$con->obtenerValor($consulta);
		if($nRegistros==0)
		{
			$consulta="SELECT COUNT(*) FROM _487_tablaDinamica WHERE carpetaAdministrativa='".$cA.
						"' AND codigoInstitucion='".$t."' and id__487_tablaDinamica<>".$idRegistro;
			$nRegistros=$con->obtenerValor($consulta);
			
			if($nRegistros>0)
			{
				$resultado=2;	
			}
		}
		else
			$resultado=1;
		
		echo "1|".$resultado;
		
		
	}
	
	function obtenerMagistradosTribunal()
	{
		global $con;
		$iU=$_POST["iU"];
		
		$consulta="SELECT usuarioJuez as idUsuario,nombre  as magistrado,
						'' as participacion, 0 as ministerioLey,0 as idMagistradoOriginal,'false' as participante 
						FROM _26_tablaDinamica, 800_usuarios u WHERE idReferencia=".$iU."
						and idUsuario=usuarioJuez ORDER BY Nombre";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.str_replace('"participante":"false"','"participante":false',$arrRegistros).'}';
		
		
	}
	
	function registrarEventoTribunalAlzada()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);

		$horaInicio=$obj->fecha." ".$obj->horaInicio;
		$horaFin=$obj->fecha." ".$obj->horaFin;
		if($obj->sala!=-1)
		{
			if(!existeDisponibilidadSala($obj->idEvento,$obj->sala,$obj->fecha,$horaInicio,$horaFin))
			{
				echo "0|<br>La sala seleccionada ya no se encuentra disponible<br>";
				return;
			}
		}
		$otroTipoAudiencia='';
		if(isset($obj->otroTipoAudiencia))
			$otroTipoAudiencia=$obj->otroTipoAudiencia;
		$x=0;
		$query[$x]="begin";
		$x++;	
		
		if($obj->idEvento!="-1")
		{
			$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idCentroGestion,idSala,idEdificio,tipoAudiencia,tipoTribunal
						  FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
			$fEvento=$con->obtenerPrimeraFila($consulta);
			$arrJuez="";
			$consulta=" select * from (SELECT usuarioJuez AS idUsuario,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=usuarioJuez) AS magistrado 
						 FROM _26_tablaDinamica WHERE idReferencia=".$fEvento[3]." OR usuarioJuez IN(SELECT idJuez FROM 
						 7001_eventoAudienciaJuez e WHERE idRegistroEvento=".$obj->idEvento.")) as tmp order by magistrado";
			$resJuez=$con->obtenerFilas($consulta);
			while($fJuez=mysql_fetch_row($resJuez))
			{
				$consulta="SELECT titulo,ministerioLey FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento." and idJuez=".$fJuez[0];
				$fDatosAsignacion=$con->obtenerPrimeraFila($consulta);
				if($fDatosAsignacion)	
				{
					$oJuez='{"idUsuario":"'.$fJuez[0].'","magistrado":"'.cv($fJuez[1]).'","participacion":"'.cv($fDatosAsignacion[0]).'","ministerioLey":"'.
								($fDatosAsignacion[1]==""?0:$fDatosAsignacion[1]).'","idMagistradoOriginal":"","participante":'.($fDatosAsignacion?"true":"false").'}';
					if($arrJuez=="")
						$arrJuez=$oJuez;
					else
						$arrJuez.=",".$oJuez;
				}
									
			}
			
			$oEventoAudiencia='{"fechaEvento":"'.$fEvento[0].'","horaInicioEvento":"'.date("H:i",strtotime($fEvento[1])).
							'","horaFinEvento":"'.date("H:i",strtotime($fEvento[2])).
							'","idCentroGestion":"'.$fEvento[3].'","idSala":"'.$fEvento[4].'","idEdificio":"'.$fEvento[5].
							'","tipoAudiencia":"'.$fEvento[6].'","tipoTribunal":"'.$fEvento[7].'","arrJuez":['.$arrJuez.']}';
			
			
			$query[$x]="INSERT INTO 3004_bitacoraCambiosAudienciaAlzada(fechaOperacion,datosOriginales,datosCambio,responsableCambio,idEvento)
						VALUES('".date("Y-m-d H:i:s")."','".bE($oEventoAudiencia)."','".bE($cadObj)."',".$_SESSION["idUsr"].",".$obj->idEvento.")";
			$x++;
			
			$query[$x]="update 7000_eventosAudiencia set 
					fechaEvento='".$obj->fecha."',horaInicioEvento='".$horaInicio."',
					horaFinEvento='".$horaFin."',fechaAsignacion='".date("Y-m-d H:i:s").
					"',idSala=".$obj->sala.",fechaLimiteAtencion=NULL,tipoTribunal=".$obj->tipoTribunal.",
					fechaSolicitud='".date("Y-m-d H:i:s")."',tipoAudiencia=".$obj->tipoAudiencia.
					",tipoTribunal=".$obj->tipoTribunal." where idRegistroEvento=".$obj->idEvento;
			$x++;
			$query[$x]="set @idRegistro:=".$obj->idEvento;
			$x++;
			
		}
		else
		{
			$query[$x]="insert into 7000_eventosAudiencia(fechaEvento,horaInicioEvento,horaFinEvento,situacion,fechaAsignacion,idEdificio,idCentroGestion,
						idSala,idFormulario,idRegistroSolicitud,idReferencia,idEtapaProcesal,tipoAudiencia,fechaLimiteAtencion,fechaSolicitud,tipoTribunal,otroTipoAudiencia)
						values('".$obj->fecha."','".$horaInicio."','".$horaFin."',1,'".date("Y-m-d H:i:s").
						"',".$obj->edificio.",".$obj->tribunal.",".$obj->sala.",-1,-1,-1,0,".$obj->tipoAudiencia.",NULL,'".date("Y-m-d H:i:s")."',".
						$obj->tipoTribunal.",'".cv($otroTipoAudiencia)."')";
			$x++;	
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;	
		}
		
		$query[$x]="DELETE FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=@idRegistro";
		$x++;	
		

		foreach($obj->jueces as $j)
		{
			if(!existeDisponibilidadJuez($j->idUsuario,$obj->fecha,$horaInicio,$horaFin,$obj->idEvento))
			{
				echo '0|<br>No existe disponibilidad del Juez: '.obtenerNombreUsuario($j->idUsuario).'<br>';
				return;
			}
			$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$j->idUsuario;
			$noJuez=$con->obtenerValor($consulta);
			$query[$x]="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,ministerioLey) 
			VALUES(@idRegistro,".$j->idUsuario.",5,'".cv($j->participacion)."','".$noJuez."',".$j->ministerioLey.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
			
			
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$idEventoAgenda=$con->obtenerValor($consulta);
			
			enviarNotificacionMAJO($idEventoAgenda);

			registrarAudienciaToca(-1,-1,$idEventoAgenda,$obj->toca,$obj->tribunal);
			echo "1|".$idEventoAgenda;
			
		}
		else
			echo "0|";
		
		
	}
	
	function obtenerFiguraJuridicaCarpetaJudicial()
	{
		global $con;
		$iA=$_POST["iA"];
		$fJ=$_POST["fJ"];
		
		
		$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno)
				,' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$iA." AND r.idFiguraJuridica=".$fJ." AND p.id__47_tablaDinamica=r.idParticipante ORDER BY 
				p.nombre,p.apellidoPaterno,p.apellidoMaterno";
		
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros;
		
	}
	
	function registrarFiguraJuridicaApelante()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO _47_tablaDinamica(fechaCreacion,responsable,idEstado,tipoPersona,apellidoPaterno,apellidoMaterno,nombre,figuraJuridica,idActividad)
						VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,".$obj->tipoPersona.",'".cv($obj->apPaterno)."','".cv($obj->apMaterno).
						"','".cv($obj->nombre)."',".$obj->tipoFigura.",".$obj->idActividad.")";
		$x++;	
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica) 
					VALUES(".$obj->idActividad.",@idRegistro,".$obj->tipoFigura.")";
		$x++;
		$query[$x]="commit";
		$x++;
			
			
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$iRegistro=$con->obtenerValor($consulta);
			echo "1|".$iRegistro;	
		}
		
		
	}
	
	
	function registrarJuezMinisterioLey()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		
		$obj=json_decode($cadObj);
		
		$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$obj->tribunalAlzada;
		$adscripcion=$con->obtenerValor($consulta);
		$idUsuario=crearBaseUsuario($obj->apPaterno,$obj->apMaterno,$obj->nombre,"",$adscripcion,"",153);
		echo "1|".$idUsuario;	
			
		
		
	}
	
	function registrarEventoJuzgadoTradicional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);

		$horaInicio=$obj->fecha." ".$obj->horaInicio;
		$horaFin=$obj->fecha." ".$obj->horaFin;
		
		$otroTipoAudiencia='';
		if(isset($obj->otroTipoAudiencia))
			$otroTipoAudiencia=$obj->otroTipoAudiencia;
		$x=0;
		$query[$x]="begin";
		$x++;	
		
		if($obj->idEvento!="-1")
		{
			$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idCentroGestion,idSala,idEdificio,tipoAudiencia,tipoTribunal
						  FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
			$fEvento=$con->obtenerPrimeraFila($consulta);
			$arrJuez="";
			$consulta=" select * from (SELECT usuarioJuez AS idUsuario,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=usuarioJuez) AS magistrado 
						 FROM _26_tablaDinamica WHERE idReferencia=".$fEvento[3]." OR usuarioJuez IN(SELECT idJuez FROM 
						 7001_eventoAudienciaJuez e WHERE idRegistroEvento=".$obj->idEvento.")) as tmp order by magistrado";
			$resJuez=$con->obtenerFilas($consulta);
			while($fJuez=mysql_fetch_row($resJuez))
			{
				$consulta="SELECT titulo,ministerioLey FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento." and idJuez=".$fJuez[0];
				$fDatosAsignacion=$con->obtenerPrimeraFila($consulta);
				if($fDatosAsignacion)	
				{
					$oJuez='{"idUsuario":"'.$fJuez[0].'","magistrado":"'.cv($fJuez[1]).'","participacion":"'.cv($fDatosAsignacion[0]).'","ministerioLey":"'.
								($fDatosAsignacion[1]==""?0:$fDatosAsignacion[1]).'","idMagistradoOriginal":"","participante":'.($fDatosAsignacion?"true":"false").'}';
					if($arrJuez=="")
						$arrJuez=$oJuez;
					else
						$arrJuez.=",".$oJuez;
				}
									
			}
			
			$oEventoAudiencia='{"fechaEvento":"'.$fEvento[0].'","horaInicioEvento":"'.date("H:i",strtotime($fEvento[1])).
							'","horaFinEvento":"'.date("H:i",strtotime($fEvento[2])).
							'","idCentroGestion":"'.$fEvento[3].'","idSala":"'.$fEvento[4].'","idEdificio":"'.$fEvento[5].
							'","tipoAudiencia":"'.$fEvento[6].'","tipoTribunal":"'.$fEvento[7].'","arrJuez":['.$arrJuez.']}';
			
			
			$query[$x]="INSERT INTO 3004_bitacoraCambiosAudienciaAlzada(fechaOperacion,datosOriginales,datosCambio,responsableCambio,idEvento)
						VALUES('".date("Y-m-d H:i:s")."','".bE($oEventoAudiencia)."','".bE($cadObj)."',".$_SESSION["idUsr"].",".$obj->idEvento.")";
			$x++;
			
			$query[$x]="update 7000_eventosAudiencia set 
					fechaEvento='".$obj->fecha."',horaInicioEvento='".$horaInicio."',
					horaFinEvento='".$horaFin."',fechaAsignacion='".date("Y-m-d H:i:s").
					"',idSala=".$obj->sala.",fechaLimiteAtencion=NULL,tipoTribunal=".$obj->tipoTribunal.",
					fechaSolicitud='".date("Y-m-d H:i:s")."',tipoAudiencia=".$obj->tipoAudiencia.
					",tipoTribunal=".$obj->tipoTribunal." where idRegistroEvento=".$obj->idEvento;
			$x++;
			$query[$x]="set @idRegistro:=".$obj->idEvento;
			$x++;
			
		}
		else
		{
			$query[$x]="insert into 7000_eventosAudiencia(fechaEvento,horaInicioEvento,horaFinEvento,situacion,fechaAsignacion,idEdificio,idCentroGestion,
						idSala,idFormulario,idRegistroSolicitud,idReferencia,idEtapaProcesal,tipoAudiencia,fechaLimiteAtencion,fechaSolicitud,tipoTribunal,otroTipoAudiencia)
						values('".$obj->fecha."','".$horaInicio."','".$horaFin."',1,'".date("Y-m-d H:i:s").
						"',".$obj->edificio.",".$obj->tribunal.",".$obj->sala.",-1,-1,-1,0,".$obj->tipoAudiencia.",NULL,'".date("Y-m-d H:i:s")."',".
						$obj->tipoTribunal.",'".cv($otroTipoAudiencia)."')";
			$x++;	
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;	
		}
		
		$query[$x]="DELETE FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=@idRegistro";
		$x++;	
		

		foreach($obj->jueces as $j)
		{
			$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$j->idUsuario;
			$noJuez=$con->obtenerValor($consulta);
			$query[$x]="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,ministerioLey) 
			VALUES(@idRegistro,".$j->idUsuario.",5,'".cv($j->participacion)."','".$noJuez."',".$j->ministerioLey.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
			
			
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$idEventoAgenda=$con->obtenerValor($consulta);
			
			enviarNotificacionMAJO($idEventoAgenda);

			registrarAudienciaToca(-1,-1,$idEventoAgenda,$obj->toca,$obj->tribunal);
			echo "1|".$idEventoAgenda;
			
		}
		else
			echo "0|";
		
		
	}
?>