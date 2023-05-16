<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");

	
$_SESSION["debuggerConsulta"]=0;
	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerRegistrosLibrosGobierno();
		break;
	}
	
	function obtenerRegistrosLibrosGobierno()
	{
		global $con;
		$anioJudicial=$_POST["anioJudicial"];
		$tipoLibro=$_POST["tLibro"];
		
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$arrRegistros="";
		$o="";
		$numReg=0;
		$datosParticipantes="";
		
		
		
		switch($tipoLibro)
		{
			case 1:
				$idFormulario=92;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaExhorto ,e.fechaCreacion,
					 CONCAT(fechaRecepcion,' ',horaRepepcion) AS fechaRecepcion,c.idActividad,e.autoridaExhortante,e.resumen,e.responsable
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and c.carpetaAdministrativa=e.carpetaExhorto
					order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					$consulta="SELECT fechaAtencion,comentariosAdicionales FROM _370_tablaDinamica WHERE idReferencia=".$fila[0];
					$fExhorto=$con->obtenerPrimeraFila($consulta);
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT delito,otroDelito FROM _92_gDelitos WHERE idReferencia=".$fila[0];
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d="";
						if($fDelito[0]==0)
						{
							$d="OTRO: ".$fDelito[1];
						}
						else
						{
							$consulta="SELECT denominacionDelito FROM _35_denominacionDelito WHERE id__35_denominacionDelito=".$fDelito[0];
							$d=$con->obtenerValor($consulta);
						}
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
				
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[6]." and
							i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
					$resDemandados=$con->obtenerFilas($consulta);
					while($filaDemandado=$con->fetchRow($resDemandados))
					{

						if($arrImputados=="")
							$arrImputados=$filaDemandado[0];
						else
							$arrImputados.=",".$filaDemandado[0];
					}
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$fila[2].'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","fechaRecepcion":"'.$fila[5].'","imputado":"'.cv($arrImputados).'","delito":"'.cv($delitos).
						'","autoridadExhortante":"'.cv($fila[7]).'","diligenciaRealizar":"'.cv($fila[8]).'","fechaDevolucion":"'.$fExhorto[0].'",
						"observaciones":"'.cv($fExhorto[1]).'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[9])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			break;
			case 2:
				$idFormulario=434;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.fechaOrden,imputado,ordenEntregadoA,nombre,ministerioPublico,fechaEntregaOrden,fechaPrescripcion,apPaterno,apMaterno,
					 e.responsable
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and c.carpetaAdministrativa=e.carpetaAdministrativa
					order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					$entregadaA="";
					switch($fila[8])
					{
						case 1:
							$entregadaA="Ministerio p&uacute;blico";
							$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".($fila[10]==""?-1:$fila[10]);
							$nombreMP=$con->obtenerValor($consulta);
							if(trim($nombreMP)!="")
							{
								$entregadaA.=": ".$nombreMP;
							}
							
						break;
						case 2:
							$entregadaA="Oficina de PGJ";
						break;
						case 3:
							$nombreOtro=$fila[9]." ".$fila[13]." ".$fila[14];
							$entregadaA="Otro ".trim($nombreOtro)!=""?(": ".$nombreOtro):"";
						break;
						
					}
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$fila[2].'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","fechaPrescripcion":"'.cv($fila[12]).'","fechaOrden":"'.cv($fila[6]).'","entregadaA":"'.$entregadaA.'",
						"fechaEntrega":"'.cv($fila[11]).'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[15])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			break;
			case 3:
				$idFormulario=293;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,imputado,e.codigo,pr.fechaRegistro,fechaRequerido,dteHoraRequerido,
					 reclusorios,idEvento
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and c.carpetaAdministrativa=e.carpetaAdministrativa
					order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=293 AND idRegistro=".$fila[0].
							" AND etapaActual=2.5 ORDER BY fechaCambio ASC";
					$fechaConfirmacionRecepcion=$con->obtenerValor($consulta);
					
					$consulta="SELECT a.tipoAudiencia FROM 7000_eventosAudiencia e,_4_tablaDinamica a WHERE 
								e.idRegistroEvento=".$fila[13]." AND a.id__4_tablaDinamica=e.tipoAudiencia";
					$diligencia=$con->obtenerValor($consulta);
					
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$fila[2].'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","noTraslado":"'.cv($fila[8]).'","fechaSolicitud":"'.cv($fila[9]).'","fechaPresentacion":"'.$fila[10].'",
						"horaPresentacion":"'.cv($fila[11]).'","diligencia":"'.cv($diligencia).'","centroPenitenciario":"'.$fila[12].
						'","fechaConfirmacionRecepcion":"'.$fechaConfirmacionRecepcion.'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[6])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			break;
			case 4:
				$idFormulario=297;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,imputado,e.codigo, reclusorio,dteFecha,horaLibertad,motivoLibertad
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and c.carpetaAdministrativa=e.carpetaAdministrativa
					order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					$consulta="SELECT fechaCambio,idUsuarioCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=297 AND idRegistro=".$fila[0].
							" AND etapaActual=5 ORDER BY fechaCambio ASC";
					$fechaConfirmacionRecepcion=$con->obtenerPrimeraFila($consulta);
					$consulta="SELECT fechaLiberacion,horaLiberacion,detallesAdicionales FROM _344_tablaDinamica WHERE idReferencia=".$fila[0];
					$fLiberacion=$con->obtenerPrimeraFila($consulta);
					$fechaLibertad=$fila[10];
					$motivoLibertad=$fila[12];
					$servidorPublicoConfirmaLibertad=obtenerNombreUsuario($fechaConfirmacionRecepcion[1]==""?-1:$fechaConfirmacionRecepcion[1]);
					$fechaHoraConfirmacionLibertad=$fechaConfirmacionRecepcion[0];
					$observaciones=$fLiberacion[2];
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$fila[2].'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","numeroLibertad":"'.cv($fila[8]).'","fechaLibertad":"'.cv($fechaLibertad).'","motivoLibertad":"'.cv($motivoLibertad).'",
						"servidorPublicoConfirmaLibertad":"'.cv($servidorPublicoConfirmaLibertad).'","fechaHoraConfirmacionLibertad":"'.
						cv($fechaHoraConfirmacionLibertad).'","centroPenitenciario":"'.$fila[9].'","observaciones":"'.$observaciones.'","responsableRegistro":"'.
						cv(obtenerNombreUsuario($fila[6])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			break;//----------- numFila
			case "7_5":  //Poliza
				$idFormulario=563;
				$tipoLibro=7;
				$numFila=1;
				
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=2";
				$numReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,e.parteExhibe,e.fechaRecepcion,e.horaRecepcion,e.tipoValor,
					 e.otroValor,e.noFianzaPoliza,e.fechaExpedicion,e.nombreAfianzadora,e.monto,
					 e.concepto,e.procedeOtraUnidad,e.unidadGestionOrigen,e.carpetaOrigen,e.idEstado,e.responsable
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=2 
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					$fEgreso=NULL;
					
					if($fila[20]>2)
					{
						
						$consulta="SELECT motivoEgreso,otroMotivo,fechaOperacion,comentariosAdicionales FROM _564_tablaDinamica WHERE idReferencia=".$fila[0];
						$fEgreso=$con->obtenerPrimeraFila($consulta);
					}
					
					$consulta="SELECT fechaCambio,idUsuarioCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=563 AND idRegistro=".$fila[0].
							" AND etapaActual>2 ORDER BY fechaCambio ASC";
					$fechaCambio=$con->obtenerPrimeraFila($consulta);
					
					$motivoEgreso="";
					$observaciones="";
					if($fEgreso)
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=9158 AND valor=".$fEgreso[0];
						$motivoEgreso=$con->obtenerValor($consulta);
						if($fEgreso[0]==3)
						{
							$motivoEgreso.=": ".$fEgreso[1];
						}
						$observaciones="<b>Motivo del Egreso:</b> ".$motivoEgreso;
						$observaciones.=". <b>Comentarios adicionales:</b> ".$fEgreso[3];
					}
					
					$procedencia="";
					if($fila[17]==1)
					{
						$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[18]."'";
						$procedencia=$con->obtenerValor($consulta);
						if($fila[19]!="")
						{
							$procedencia.=", <b>Carpeta Judicial:</b> ".$fila[19];
						}
					}
					else
					{
						$procedencia="NUEVO";
					}
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","folioBillete":"'.$fila[12].'","fechaExpedicion":"'.$fila[13].'","nombreAfianzadora":"'.cv($fila[14]).
						'","parteExhibe":"'.cv(obtenerNombreImputadoID($fila[7])).'","monto":"'.$fila[15].'","concepto":"'.cv($fila[16]).
						'","fechaPresentacion":"'.$fila[8].'","procedencia":"'.$procedencia.'","fechaEntregaValidez":"'.($fEgreso[2]).'",
						"observaciones":"'.cv($observaciones).'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[21])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			break;
			case "7_6": //Billetes
				$idFormulario=563;
				$tipoLibro=7;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=1";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,e.parteExhibe,e.fechaRecepcion,e.horaRecepcion,e.tipoValor,
					 e.otroValor,e.noFianzaPoliza,e.fechaExpedicion,e.nombreAfianzadora,e.monto,
					 e.concepto,e.procedeOtraUnidad,e.unidadGestionOrigen,e.carpetaOrigen,e.idEstado,e.responsable
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=1
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					$fEgreso=NULL;
					
					if($fila[20]>2)
					{
						$consulta="SELECT motivoEgreso,otroMotivo,fechaOperacion,comentariosAdicionales FROM _564_tablaDinamica WHERE idReferencia=".$fila[0];
						$fEgreso=$con->obtenerPrimeraFila($consulta);
					}
					
					$consulta="SELECT fechaCambio,idUsuarioCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=563 AND idRegistro=".$fila[0].
							" AND etapaActual>2 ORDER BY fechaCambio ASC";
					$fechaCambio=$con->obtenerPrimeraFila($consulta);
					
					$motivoEgreso="";
					$observaciones="";
					if($fEgreso)
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=9158 AND valor=".$fEgreso[0];
						$motivoEgreso=$con->obtenerValor($consulta);
						if($fEgreso[0]==3)
						{
							$motivoEgreso.=": ".$fEgreso[1];
						}
						$observaciones="<b>Motivo del Egreso:</b> ".$motivoEgreso;
						$observaciones.=". <b>Comentarios adicionales:</b> ".$fEgreso[3];
					}
					
					$procedencia="";
					if($fila[17]==1)
					{
						$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[18]."'";
						$procedencia=$con->obtenerValor($consulta);
						if($fila[19]!="")
						{
							$procedencia.=", <b>Carpeta Judicial:</b> ".$fila[19];
						}
					}
					else
					{
						$procedencia="NUEVO";
					}
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","folioBillete":"'.$fila[12].'","fechaExpedicion":"'.$fila[13].'","institucionFinanciera":"'.cv($fila[14]).
						'","parteExhibe":"'.cv(obtenerNombreImputadoID($fila[7])).'","monto":"'.$fila[15].'","concepto":"'.cv($fila[16]).
						'","fechaPresentacion":"'.$fila[8].'","procedencia":"'.$procedencia.'","fechaEntregaValidez":"'.($fEgreso[2]).'",
						"observaciones":"'.cv($observaciones).'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[21])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			break;
			case "7_7": //Otros
				$idFormulario=563;
				$tipoLibro=7;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=3";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,e.parteExhibe,e.fechaRecepcion,e.horaRecepcion,e.tipoValor,
					 e.otroValor,e.noFianzaPoliza,e.fechaExpedicion,e.nombreAfianzadora,e.monto,
					 e.concepto,e.procedeOtraUnidad,e.unidadGestionOrigen,e.carpetaOrigen,e.idEstado,e.responsable
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro and e.tipoValor=3
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;
				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM _47_tablaDinamica i WHERE i.id__47_tablaDinamica=".$fila[7];
					$imputado=$con->obtenerValor($consulta);
					
					$fEgreso=NULL;
					
					if($fila[20]>2)
					{
						$consulta="SELECT motivoEgreso,otroMotivo,fechaOperacion,comentariosAdicionales FROM _564_tablaDinamica WHERE idReferencia=".$fila[0];
						$fEgreso=$con->obtenerPrimeraFila($consulta);
					}
					
					$consulta="SELECT fechaCambio,idUsuarioCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=563 AND idRegistro=".$fila[0].
							" AND etapaActual>2 ORDER BY fechaCambio ASC";
					$fechaCambio=$con->obtenerPrimeraFila($consulta);
					
					$motivoEgreso="";
					$observaciones="";
					if($fEgreso)
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=9158 AND valor=".$fEgreso[0];
						$motivoEgreso=$con->obtenerValor($consulta);
						if($fEgreso[0]==3)
						{
							$motivoEgreso.=": ".$fEgreso[1];
						}
						$observaciones="<b>Motivo del Egreso:</b> ".$motivoEgreso;
						$observaciones.=". <b>Comentarios adicionales:</b> ".$fEgreso[3];
					}
					
					$procedencia="";
					if($fila[17]==1)
					{
						$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[18]."'";
						$procedencia=$con->obtenerValor($consulta);
						if($fila[19]!="")
						{
							$procedencia.=", <b>Carpeta Judicial:</b> ".$fila[19];
						}
					}
					else
					{
						$procedencia="NUEVO";
					}
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($imputado).'","delitos":"'.cv($delitos).
						'","folioValor":"'.$fila[12].'","fechaExpedicion":"'.$fila[13].'","parteExhibe":"'.cv(obtenerNombreImputadoID($fila[7])).
						'","monto":"'.$fila[15].'","concepto":"'.cv($fila[16]).
						'","fechaExhibicion":"'.$fila[8].'","procedencia":"'.$procedencia.'","fechaEntregaValidez":"'.($fEgreso[2]).'",
						"observaciones":"'.cv($observaciones).'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[21])).
						'","tipoValor":"'.cv($fila[11]).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			break;
			case 8:
				$idFormulario=451;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,e.resolucionImpugnada,nombreResolucion,nombreApelante,
					 fechaEmision,juezResolucion,eventoResolucion,agraviosOral,domicilioDiferenteNotificaciones,noToca,salaPenal,
					 figuraJuridica
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".($fila[5]==""?-1:$fila[5])." ORDER BY de.denominacionDelito";
					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
					
					
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".($fila[5]==""?-1:$fila[5])." and
							i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
					$resDemandados=$con->obtenerFilas($consulta);
					while($filaDemandado=$con->fetchRow($resDemandados))
					{

						if($arrImputados=="")
							$arrImputados=$filaDemandado[0];
						else
							$arrImputados.=",".$filaDemandado[0];
					}
					/*
					
					$consulta="SELECT fechaCambio,idUsuarioCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=563 AND idRegistro=".$fila[0].
							" AND etapaActual>2 ORDER BY fechaCambio ASC";
					$fechaCambio=$con->obtenerPrimeraFila($consulta);*/
					
					$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[16]."'";
					$salaApelacion=$con->obtenerValor($consulta);
					$fechaEjecutoria="";
					
					$apelante=obtenerNombreImputadoID($fila[9]);
					$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".($fila[17]==""?-1:$fila[17]);
					
					$figuraJuridica=$con->obtenerValor($consulta);
					
					$apelante.=" (".$figuraJuridica.")";
					
					$fechaEmisionResolucion="";
					$juezResolucion="";
					if($fila[7]==1)
					{
						$consulta="SELECT fechaEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".($fila[12]==""?-1:$fila[12]);

						$fechaEmisionResolucion=$con->obtenerValor($consulta);
						$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".($fila[12]==""?-1:$fila[12]);
						$juezResolucion=$con->obtenerValor($consulta);
					}
					else
					{
						$fechaEmisionResolucion=$fila[10];
						$juezResolucion=$fila[11];
					}
					$consulta="SELECT COUNT(*) FROM _458_tablaDinamica WHERE idProcesoPadre=200 AND idReferencia=".$fila[0];


					$nContestaciones=$con->obtenerValor($consulta);
					$suscitaContestacion=$nContestaciones>0?1:0;
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($arrImputados).'","delitos":"'.cv($delitos).
						'","tocaApelacion":"'.$fila[15].'","salaApelacion":"'.cv($salaApelacion).'","fechaEjecutoria":"'.$fechaEjecutoria.
						'","apelante":"'.cv($apelante).'","resolucionImpugnada":"'.$fila[7].'","nombreResolucion":"'.cv($fila[8]).
						'","fechaEmisionResolucion":"'.$fechaEmisionResolucion.'","juezResolucion":"'.cv(obtenerNombreUsuario($juezResolucion==""?-1:$juezResolucion)).
						'","expresanAgraviosOrales":"'.$fila[13].'","domicilioDiferente":"'.$fila[14].'","suscitaContestacion":"'.$suscitaContestacion.
						'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[6])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			break;
			case 9:
				$idFormulario=346;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,carpetaAmparo,CONCAT(fechaRecepcion,' ',horaRecepcion)AS fechaIngreso,
					 noJuicioAmparo,organoJurisdiccionalRequiriente,noOficio,categoriaAmparo,
					 (SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa=e.carpetaAdministrativa) as idActividadCarpetaBase
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro
					and c.carpetaAdministrativa=e.carpetaAmparo order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					if($fila[13]=="")
						$fila[13]=-1;
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[13]." ORDER BY de.denominacionDelito";

					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
										
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[13]." and
							i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";

					$resDemandados=$con->obtenerFilas($consulta);
					while($filaDemandado=$con->fetchRow($resDemandados))
					{

						if($arrImputados=="")
							$arrImputados=$filaDemandado[0];
						else
							$arrImputados.=",".$filaDemandado[0];
					}
					
					$arrQuejosos="";
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[5]." and
							i.id__47_tablaDinamica=r.idParticipante";

					$resQuejosos=$con->obtenerFilas($consulta);
					while($filaQuejoso=$con->fetchRow($resQuejosos))
					{

						if($arrQuejosos=="")
							$arrQuejosos=$filaQuejoso[0];
						else
							$arrQuejosos.=",".$filaQuejoso[0];
					}
					
					$actosReclamados="";
					$consulta="SELECT idActoReclamado,detalles FROM _346_gActosReclamados WHERE idReferencia=".$fila[0];
					$resActos=$con->obtenerFilas($consulta);
					while($filaActos=$con->fetchRow($resActos))
					{
						if($filaActos[0]=="")
							$filaActos[0]=-1;
						$consulta="SELECT actoReclamado FROM _456_tablaDinamica WHERE id__456_tablaDinamica=".$filaActos[0];
						$acto=$con->obtenerValor($consulta);
						if(trim($filaActos[1])!="")
						{
							$acto.=": ".$filaActos[1];
						}
						
						if($actosReclamados=="")
							$actosReclamados=$acto;
						else
							$actosReclamados.=", ".$acto;
					}
					$consulta="SELECT tp.tipoPromocion,p.espeifique FROM _460_tablaDinamica p,_461_tablaDinamica tp WHERE 
							p.idProcesoPadre=164 AND p.idReferencia=".$fila[0]." and tp.id__461_tablaDinamica=p.tipoPromocion 
							ORDER BY id__460_tablaDinamica ASC LIMIT 0,1";
					$fPromocion=$con->obtenerPrimeraFila($consulta);
					
					$informeRequerido=$fPromocion[0];
					if($fPromocion[1]!="")
					{
						$informeRequerido=": ".$fPromocion[1];
					}
					$fechaEjecutoria="";
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($arrImputados).'","delitos":"'.cv($delitos).
						'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[6])).'","carpetaAmparo":"'.$fila[7].'","fechaIngreso":"'.$fila[8].'"
						,"noAmparoJuzgado":"'.$fila[9].'","quejoso":"'.cv($arrQuejosos).'","autoridadFederal":"'.$fila[10].
						'","actoReclamado":"'.cv($actosReclamados).'","informeRequerido":"'.cv($informeRequerido).'",
						"noOficioRequiriente":"'.cv($fila[11]).'","fechaEjecutoria":"'.$fechaEjecutoria.'","tipoAmparo":"'.$fila[12].'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			break;
			case 10:
				$idFormulario=565;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,tipoMulta,monto,enContraDe,fechaAutoOrdena,fechaOficio,comentariosAdicionales
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";

					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
										
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[5]." and
							i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";

					$resDemandados=$con->obtenerFilas($consulta);
					while($filaDemandado=$con->fetchRow($resDemandados))
					{

						if($arrImputados=="")
							$arrImputados=$filaDemandado[0];
						else
							$arrImputados.=",".$filaDemandado[0];
					}
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($arrImputados).'","delitos":"'.cv($delitos).
						'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[6])).'","tipoMulta":"'.$fila[7].'","monto":"'.$fila[8].'",
						"enContraDe":"'.cv(obtenerNombreImputadoID($fila[9])).'","fechaAuto":"'.$fila[10].'","fechaRecepcion":"'.$fila[11].
						'","observaciones":"'.cv($fila[12]).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			break;
			case 11:
				
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,7034_prescripciones e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.idRegistro=pr.iRegistro and e.situacion=1";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.idRegistro,'' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.idResponsableRegistro,sentenciado,idPena,fechaSustraccion,fechaPrescripcion,fechaUltimoActoAutoridad,
					 abonoPrisionPreventiva,abonoPrisionPunitiva
					 FROM 7044_procesosLibrosGobierno pr,7034_prescripciones e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.idRegistro=pr.iRegistro
					and c.carpetaAdministrativa=e.carpetaAdministrativa and e.situacion=1 order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{

					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";

					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
										
					
					$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$fila[8];
					$filaPena=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$consulta="SELECT pena,tipoEntrada,privativaLibertad FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$filaPena["idPena"];	
					
					$fConfPena=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$descripcion=$fConfPena["pena"];
					$esPrivativaLibertad=$fConfPena["privativaLibertad"];
					$tipoEntrada=$fConfPena["tipoEntrada"];
					$objDetalle=$filaPena["objDetalle"];
					$periodoCompurga="";
					$periodoPena="[]";
					$lblDetallePena="";
					$periodoPenaPrivativa="NO aplica";
					if($objDetalle!="")
					{
						$oDetalle=json_decode($objDetalle);
						
						if(isset($oDetalle->monto))
						{
							$lblDetallePena=", Monto: $ ".number_format($oDetalle->monto);
						}
						else
						{
							$arrPena=array();
							$arrPena[0]=$oDetalle->anios;
							$arrPena[1]=$oDetalle->meses;
							$arrPena[2]=$oDetalle->dias;
							
							$periodoCompurga=$arrPena[0]."_".$arrPena[1]."_".$arrPena[2];
							
							$periodoPenaPrivativa=convertirLeyendaComputo($arrPena);
							
						}
						
					}
					
					$descripcion.=$lblDetallePena;
					
					$abonoPrisionPreventiva="No aplica";
					$abonoPrisionPunitiva="No aplica";
					
					if($periodoPenaPrivativa!="NO aplica")
					{
						if($fila[12]!="")
						{
							$arrPrisionPreventiva=array();
							$arrPrisionPreventiva=explode("_",$fila[12]);
							$abonoPrisionPreventiva=convertirLeyendaComputo($arrPrisionPreventiva);
						}
						
						if($fila[13]!="")
						{
							$arrPrisionPunitiva=array();
							$arrPrisionPunitiva=explode("_",$fila[13]);
							$abonoPrisionPunitiva=convertirLeyendaComputo($arrPrisionPunitiva);
						}
					}
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv(obtenerNombreImputadoID($fila[7])).'","delitos":"'.cv($delitos).
						'","responsableRegistro":"'.cv(obtenerNombreUsuario($fila[6])).'","penaMedidaSeguridad":"'.cv($descripcion).'",
						"periodoPenaPrivativa":"'.cv($periodoPenaPrivativa).'","fechaSustraccionSentencia":"'.$fila[9].'","fechaUltimoActoAutoridad":"'.$fila[11].'",
						"ubicacionSentenciado":"","abonoPrisionPreventiva":"'.cv($abonoPrisionPreventiva).'","abonoPrisionPunitiva":"'.
						cv($abonoPrisionPunitiva).'","fechaPrescripcion":"'.$fila[10].'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			break;
			case 12:
				
				$idFormulario=96;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativa ,e.fechaCreacion,
					 c.idActividad,e.responsable,'' as comentariosAdicionales,CONCAT(fechaRecepcion,' ',horaRecepcion) as fechaRecepcion,
					 asuntoPromocion as asunto,'' as noOficio,apPaterno,apMaterno,nombre,usuarioPromovente,figuraPromovente
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e,7006_carpetasAdministrativas c WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro
					and c.carpetaAdministrativa=e.carpetaAdministrativa order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$remitente="";
					if($fila[14]!=-1)
					{
						$remitente=obtenerNombreImputadoID($fila[14]);
					}
					else
					{
						$remitente=$fila[13]." ".$fila[12]." ".$fila[11];
					}
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","fechaRecepcion":"'.$fila[8].'","observaciones":"'.cv($fila[7]).
						'","noOficio":"'.cv($fila[10]).'","asunto":"'.cv($fila[9]).'","remitente":"'.cv($remitente).'","responsableRegistro":"'.
						cv(obtenerNombreUsuario($fila[6])).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			
			break;
			case 13:
				
				$idFormulario=596;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.carpetaAdministrativaAsocia ,e.fechaCreacion,
					 
					 if(asociaCarpeta=1,(select c.idActividad from 7006_carpetasAdministrativas c where c.carpetaAdministrativa=e.carpetaAdministrativaAsocia),-1)
					  as idActividad,e.responsable, comentariosAdicionales, asunto,noOficioAsignado,dirigidoA,e.idEstado,e.institucionDestino,
					  e.unidadDestinataria,e.txtUnidadDestinataria
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro  order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					$arrImputados="";
					
					$delitos="";
					$consulta="SELECT de.denominacionDelito FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
								d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=".$fila[5]." ORDER BY de.denominacionDelito";

					$rDelitos=$con->obtenerFilas($consulta);	
					while($fDelito=$con->fetchRow($rDelitos))
					{
						$d=$fDelito[0];
						
						if($delitos=="")
							$delitos=$d;
						else
							$delitos.=", ".$d;
					}
					
										
					
					$consulta="SELECT upper(concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )),
								id__47_tablaDinamica FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[5]." and
							i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";

					$resDemandados=$con->obtenerFilas($consulta);
					while($filaDemandado=$con->fetchRow($resDemandados))
					{

						if($arrImputados=="")
							$arrImputados=$filaDemandado[0];
						else
							$arrImputados.=",".$filaDemandado[0];
					}
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","carpetaAdministrativa":"'.$fila[3].
						'","fechaRegistro":"'.$fila[4].'","imputado":"'.cv($arrImputados).'","delitos":"'.cv($delitos).'","comentariosAdicionales":"'.cv($fila[7]).
						'","noOficioAsignado":"'.cv($fila[9]).
						'","asunto":"'.cv($fila[8]).'","dirigidoA":"'.cv($fila[10]).'","responsableRegistro":"'.
						cv(obtenerNombreUsuario($fila[6])).'","situacionActual":"'.$fila[11].
						'","institucionDestinataria":"'.$fila[12].'","areaDestinataria":"'.cv($fila[12]=="000"?$fila[14]:$fila[13]).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			
			break;
			case 14:
				
				$idFormulario=600;
				$consulta="SELECT count(*) 	 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro";

				$numReg=$con->obtenerValor($consulta);
				
				$numFila=1;
				$consulta="SELECT e.id__".$idFormulario."_tablaDinamica AS idRegistro,'".$idFormulario.
						"' AS idFormulario,noRegistro AS folio,e.fechaCreacion,
					 e.responsable, comentariosAdicionales, asunto,noOficioAsignado,dirigidoA,e.idEstado,e.institucionDestino,
					  e.unidadDestinataria,e.txtUnidadDestinataria
					 FROM 7044_procesosLibrosGobierno pr,_".$idFormulario."_tablaDinamica e WHERE
					tipoLibro=".$tipoLibro." AND anio=".$anioJudicial." AND pr.unidadGestion='".$_SESSION["codigoInstitucion"].
					"' AND e.id__".$idFormulario."_tablaDinamica=pr.iRegistro  order by idRegistroLibro limit ".$start.",".$limit;

				$res=$con->obtenerFilas($consulta);					
				while($fila=$con->fetchRow($res))
				{
					
					
					
					$o=	'{"idRegistro":"'.$fila[0].'","idFormulario":"'.$fila[1].'","folio":"'.$numFila.'","fechaRegistro":"'.$fila[3].
						'","comentariosAdicionales":"'.cv($fila[5]).'","noOficioAsignado":"'.cv($fila[7]).
						'","asunto":"'.cv($fila[6]).'","dirigidoA":"'.cv($fila[8]).'","responsableRegistro":"'.
						cv(obtenerNombreUsuario($fila[4])).'","situacionActual":"'.$fila[9].
						'","institucionDestinataria":"'.$fila[10].'","areaDestinataria":"'.cv($fila[10]=="000"?$fila[12]:$fila[11]).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numFila++;
				}
			
			
			break;
			
			
		}
		
		
		
		
			
			
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
?>