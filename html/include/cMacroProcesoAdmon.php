<?php include_once("funcionesNomina.php"); 

	class cMacroProcesoAdmon
	{
		var $filaRegistro;
		var $idFormulario;
		var $idRegistro;
		var $nombreTabla;
		var $objParametros;
		var $idProceso;
		var $cacheCalculos;
		var $funcionesEjecutar;
		var $arrParametros;
		function cMacroProcesoAdmon($idFormulario,$idRegistro,$objParams)
		{
			global $con;
			$this->idFormulario=$idFormulario;
			$this->idRegistro=$idRegistro;
			$this->idProceso=obtenerIdProcesoFormulario($this->idFormulario);
			$this->nombreTabla=obtenerNombreTabla($this->idFormulario);
			$consulta="select * from ".$this->nombreTabla." where id_".$this->nombreTabla."=".$this->idRegistro;
			$this->filaRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			$this->objParametros=$objParams;
			$this->cacheCalculos=NULL;
			$this->funcionesEjecutar=array();
			$this->arrParametros=array();
			$this->arrIDsRegistros=array();
		}
		
		function asentarRegistroMacroProceso()
		{
			global $con;
			$this->funcionesEjecutar=array();
			$this->arrParametros=array();
			$this->arrIDsRegistros=array();
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$query="SELECT distinct m.* FROM 00001_macroProcesos m,00009_etapasProcesosMacroprocesos e WHERE e.idRegistroMacroproceso=m.idRegistro
				AND e.idProceso=".$this->idProceso." AND etapa=".$this->objParametros->etapa;

			$rMacroProcesos=$con->obtenerFilas($query);
			while($fMacroprocesos=mysql_fetch_assoc($rMacroProcesos))
			{

				$aplicaMacroProceso=true;
				$this->objParametros->idMacroProceso=$fMacroprocesos["idRegistro"];
				if($fMacroprocesos["idFuncionAplicacion"]!=-1)
				{
					$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fMacroprocesos["idFuncionAplicacion"],$this->objParametros,$this->cacheCalculos));
			
					if($resultadoEvaluacion==0)
					{
						$aplicaMacroProceso=false;
					}
				}
				
				if($aplicaMacroProceso)
				{
					$aplicaProceso=true;
					$query="SELECT eM.*,pA.campoProcesoJudicial,pA.idFuncionDeterminadoraProcesoJudicia FROM 00009_etapasProcesosMacroprocesos eM,00002_procesosAsociadosMacroProceso pA 
							WHERE eM.idRegistroMacroproceso=".$fMacroprocesos["idRegistro"]." AND eM.idProceso=".$this->idProceso.
							" and pA.idProceso=eM.idProceso and pA.idMacroProceso=eM.idRegistroMacroproceso AND eM.etapa=".$this->objParametros->etapa;

					$rProcesos=$con->obtenerFilas($query);
					while($fProceso=mysql_fetch_assoc($rProcesos))
					{
						$aplicaProceso=true;
						$iFormularioBase=$this->objParametros->idFormulario;
						$nombreTablaBase=obtenerNombreTabla($iFormularioBase);
						
						$query="SELECT ".$fProceso["campoProcesoJudicial"].",codigoInstitucion FROM ".$nombreTablaBase." WHERE id_".$nombreTablaBase."=".$this->objParametros->idRegistro;
						$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($query);
						
						
						if(($fProceso["idFuncionDeterminadoraProcesoJudicia"]!=-1)&&($fProceso["idFuncionDeterminadoraProcesoJudicia"]!=""))
						{
							$resultadoEvaluacion=resolverExpresionCalculoPHP($fProceso["idFuncionDeterminadoraProcesoJudicia"],$this->objParametros,$this->cacheCalculos);
							$fDatosCarpeta[$fProceso["campoProcesoJudicial"]]=$resultadoEvaluacion["carpetaAdministrativa"];
							$fDatosCarpeta["codigoInstitucion"]=$resultadoEvaluacion["codigoInstitucion"];
						}
						
						$query="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fDatosCarpeta[$fProceso["campoProcesoJudicial"]].
										"' AND unidadGestion='".$fDatosCarpeta["codigoInstitucion"]."'";
						$iCarpeta=$con->obtenerValor($query);
						
						$this->objParametros->idRegistroProcesoEtapaMacroProceso=$fProceso["idRegistro"];
						switch($fProceso["metodoAplicacion"])
						{
							
							case 1:
								$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fProceso["idFuncionAplicacion"],$this->objParametros,$this->cacheCalculos));
								if($resultadoEvaluacion==0)
								{
									$aplicaProceso=false;
								}
							break;
							case 2:
														
							
							
								$cadObjCondWhere='{"arrCondiciones":'.$fProceso["condicionesAplicacion"].'}';
								$objCondWhere=json_decode($cadObjCondWhere);
								
								$condWhere="";
								foreach($objCondWhere->arrCondiciones as $c)
								{
									
									$tokenConsulta=$this->resolverTokenConsulta($c);
									if($condWhere=="")
										$condWhere=$tokenConsulta;
									else
										$condWhere.=" ".$tokenConsulta;
								}
								
								$query="select * from ".$this->nombreTabla." where id_".$this->nombreTabla."=".$this->idRegistro;
								if($condWhere!="")
									$query.=" and (".$condWhere.")";
								
								
								$fRegistroCond=$con->obtenerPrimeraFilaAsoc($query);
								if(!$fRegistroCond)
								{
									$aplicaProceso=false;
								}
								
								
								
								
							break;
						}
						
						if($aplicaProceso)
						{
				
							$query="SELECT * FROM 00010_elementosEtapasProcesosMacroprocesos WHERE idRegistroEtapaProcesoMacroproceso=".$fProceso["idRegistro"]."  ORDER BY idRegistro";

							$resElemento=$con->obtenerFilas($query);
							while($fElemento=mysql_fetch_assoc($resElemento))
							{

								$aplicaElemento=true;
								$this->objParametros->idElementoEvaluacion=$fElemento["idRegistro"];
								$this->objParametros->tipoElemento=$fElemento["tipoElemento"];
								$this->objParametros->idRegistroElemento=$fElemento["idRegistroElemento"];
								
								
								if($fElemento["idFuncionAplicacion"]!=-1)
								{

									$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fElemento["idFuncionAplicacion"],$this->objParametros,$this->cacheCalculos));

									if($resultadoEvaluacion==0)
									{
										$aplicaElemento=false;
									}
								}
								
								
								
								if($aplicaElemento)
								{
									
									$arrInfoRegistro=array();
									$arrInfoRegistro["carpetaAdministrativa"]=$fDatosCarpeta[$fProceso["campoProcesoJudicial"]];
									$arrInfoRegistro["idCarpetaAdministrativa"]=$iCarpeta;
									$arrInfoRegistro["codigoInstitucion"]=$fDatosCarpeta["codigoInstitucion"];
									$arrInfoRegistro["iFormulario"]=$this->objParametros->idFormulario;
									$arrInfoRegistro["iRegistro"]=$this->objParametros->idRegistro;
									$arrInfoRegistro["idMacroProceso"]=$fMacroprocesos["idRegistro"];
									$arrInfoRegistro["idRegistroElemento"]=$fElemento["idRegistroElemento"];
									$arrInfoRegistro["tipoRegistro"]=$fElemento["tipoElemento"];
									$arrInfoRegistro["idElemento"]=$fElemento["idRegistro"];
									$arrInfoRegistro["lblEtiquetaRegistro"]="";
									$arrInfoRegistro["llaveRegistro"]="";
									$arrInfoRegistro["metaInformacion"]="";
									$arrInfoRegistro["fechaMaximaAtencion"]="";
									$arrInfoRegistro["cveElemento"]="";
									$arrInfoRegistro["valorComplementario1"]="";
									$arrInfoRegistro["valorComplementario2"]="";
									$arrInfoRegistro["detalleComplementario"]="";
									$arrInfoRegistro["idUsuarioAsignacion"]="";

									if($fElemento["idFuncionDetalle"]!=-1)
									{
										$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fElemento["idFuncionDetalle"],$this->objParametros,$this->cacheCalculos));
										$arrInfoRegistro["detalleComplementario"]=$resultadoEvaluacion;
									}
									
									
									if($fElemento["idFuncionUsuarioAsignado"]!=-1)
									{
										$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fElemento["idFuncionUsuarioAsignado"],$this->objParametros,$this->cacheCalculos));
										$arrInfoRegistro["idUsuarioAsignacion"]=$resultadoEvaluacion;
									}
									
									$arrInfoRegistro["llaveRegistro"]=bE($arrInfoRegistro["iFormulario"]."_".$arrInfoRegistro["iRegistro"]."_".$this->objParametros->etapa."_".$arrInfoRegistro["idElemento"]);
									$etiquetaElemento="";
									
									$objComp=$fElemento["objConfiguracion"]==""?NULL:json_decode($fElemento["objConfiguracion"]);
									
									$query="SELECT COUNT(*) FROM 00013_registrosMacroProceso WHERE llaveRegistro='".$arrInfoRegistro["llaveRegistro"]."'";
									$numReg=$con->obtenerValor($query);
									if($numReg==0)
									{
										switch($fElemento["tipoElemento"])
										{
											case 2: //"Actuaci&oacute;n
												$query="SELECT cveEtiquetaActuacion,etiquetaActuacion,idRegistro FROM 00003_etiquetasActuaciones WHERE idRegistro=".$fElemento["idRegistroElemento"];
												$fRegistroElemento=$con->obtenerPrimeraFilaAsoc($query);
												$arrInfoRegistro["cveElemento"]=$fRegistroElemento["cveEtiquetaActuacion"];
												$etiquetaElemento='['.$fRegistroElemento["cveEtiquetaActuacion"].'] '.$fRegistroElemento["etiquetaActuacion"];
												$this->objParametros->lblEtiquetaElemento=$etiquetaElemento;
											
											break;
											case 3: //Cambio de Etapa Procesal
												$query="SELECT cveEtiquetaEtapa,etiquetaEtapa,idRegistro FROM 00007_etiquetasEtapasProcesales WHERE idRegistro=".$fElemento["idRegistroElemento"];
												$fRegistroElemento=$con->obtenerPrimeraFilaAsoc($query);
												$arrInfoRegistro["cveElemento"]=$fRegistroElemento["cveEtiquetaEtapa"];
												$etiquetaElemento='['.$fRegistroElemento["cveEtiquetaEtapa"].'] '.$fRegistroElemento["etiquetaEtapa"];
												$this->objParametros->lblEtiquetaElemento=$etiquetaElemento;
											
											break;
											case 4: //T&eacute;rmino Procesal
												$query="SELECT cveTermino,tituloTermino,idRegistro FROM 00005_etiquetaTerminosProcesales WHERE idRegistro=".$fElemento["idRegistroElemento"];
												$fRegistroElemento=$con->obtenerPrimeraFilaAsoc($query);

												$arrInfoRegistro["cveElemento"]=$fRegistroElemento["cveTermino"];
												$etiquetaElemento="[".$fRegistroElemento["cveTermino"]."] ".$fRegistroElemento["tituloTermino"];
												$this->objParametros->lblEtiquetaElemento=$etiquetaElemento;
												$fechaActual=date("Y-m-d H:i:s");
												$arrInfoRegistro["fechaInicio"]=date("Y-m-d");
												
												if($objComp->datosGenerales->tipoIntervaloTiempo==1)
												{
													if($objComp->datosGenerales->cvePeriodoTiempo>0)
													{
														$periodoTiempo=$objComp->datosGenerales->periodoTiempo;
														switch($periodoTiempo)
														{
															case 1://Horas
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d H:i",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." hours",strtotime($fechaActual)));
															
															break;
															case 2://D\xEDas Habiles
																$numDias=1;
																if(isset($objComp->datosGenerales->aPartirDe))
																{
																	if($objComp->datosGenerales->aPartirDe==2)
																	{
																		$fechaActual=date("Y-m-d H:i:s",strtotime("+1 day",strtotime($fechaActual)));
																		$objComp->datosGenerales->cvePeriodoTiempo;
																		if(!esDiaHabilInstitucion($fechaActual))
																		{
																			$numDias--;
																		}
																	}
																	
																	$arrInfoRegistro["fechaInicio"]=date("Y-m-d",strtotime($fechaActual));
																	
																	$fechaActual=date("Y-m-d H:i:s",strtotime($fechaActual));
																}
																
																
															
																
																$fechaBase=strtotime($fechaActual);
																
																
																
																while($numDias<$objComp->datosGenerales->cvePeriodoTiempo)
																{
																	$fechaBase=strtotime("+1 day",$fechaBase);
																	if(esDiaHabilInstitucion(date("Y-m-d",$fechaBase)))
																	{
																		$numDias++;
																	}
																
																}
																
															
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d",$fechaBase)." ".(isset($objComp->datosGenerales->horaLimite)?$objComp->datosGenerales->horaLimite:"23:59:59");
																
																
																
															break;
															case 3://D\xEDas Naturales
																if(isset($objComp->datosGenerales->aPartirDe))
																{
																	if($objComp->datosGenerales->aPartirDe==2)
																	{
																		
																		$fechaActual=strtotime("+1 day",strtotime($fechaActual));
																		$arrInfoRegistro["fechaInicio"]=date("Y-m-d",$fechaActual);
																		$fechaActual=date("Y-m-d",$fechaActual);
																		$objComp->datosGenerales->cvePeriodoTiempo;
																		
																	}
																}
																
																
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." days",strtotime($fechaActual)))." ".(isset($objComp->datosGenerales->horaLimite)?$objComp->datosGenerales->horaLimite:"23:59:59");
															break;
															case 4://Meses
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." month",strtotime($fechaActual))." ".(isset($objComp->datosGenerales->horaLimite)?$objComp->datosGenerales->horaLimite:"23:59:59"));
															
															break;
														}
												
													}
												}
												else
												{
													
													
													
													$resultadoFechas=resolverExpresionCalculoPHP($objComp->datosGenerales->txtFuncionPeriodoTermino,$this->objParametros,$this->cacheCalculos);
													if(gettype($resultadoFechas)=="array")
													{
														$arrInfoRegistro["fechaInicio"]=$resultadoFechas["fechaInicio"];
														$arrInfoRegistro["fechaMaximaAtencion"]=$resultadoFechas["fechaMaximaAtencion"];
													}
													else
														$arrInfoRegistro["fechaMaximaAtencion"]=removerComillasLimite($resultadoFechas);
												}
												




												$this->ejecutarConfiguracionAccion($objComp->arranqueTermino,"_".$fElemento["idRegistro"],$consulta,$x,1);
												
											break;
											case 5: //Temporizador
												$query="SELECT cveTemporizador,tituloTemporizador,idRegistro FROM 00011_etiquetaTemporizadores WHERE idRegistro=".$fElemento["idRegistroElemento"];
												$fRegistroElemento=$con->obtenerPrimeraFilaAsoc($query);
												$etiquetaElemento="[".$fRegistroElemento["cveTemporizador"]."] ".$fRegistroElemento["tituloTemporizador"];
												$arrInfoRegistro["cveElemento"]=$fRegistroElemento["cveTemporizador"];
												$this->objParametros->lblEtiquetaElemento=$etiquetaElemento;
												$fechaActual=date("Y-m-d H:i:s");
												$arrInfoRegistro["fechaInicio"]=date("Y-m-d");
												if($objComp->datosGenerales->tipoIntervaloTiempo==1)
												{
													if($objComp->datosGenerales->cvePeriodoTiempo>0)
													{
														$periodoTiempo=$objComp->datosGenerales->periodoTiempo;
														switch($periodoTiempo)
														{
															case 1://Horas
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d H:i",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." hours",strtotime($fechaActual)));
															
															break;
															case 2://D\xEDas Habiles
																$numDias=1;
																if(isset($objComp->datosGenerales->aPartirDe))
																{
																	if($objComp->datosGenerales->aPartirDe==2)
																	{
																		$fechaActual=date("Y-m-d",strtotime("+1 day",strtotime($fechaActual)));
																		if(!esDiaHabilInstitucion($fechaActual))
																		{
																			$numDias--;
																		}
																	}
																	
																	$arrInfoRegistro["fechaInicio"]=date("Y-m-d",strtotime($fechaActual));
																	
																	$fechaActual=date("Y-m-d H:i:s",strtotime($fechaActual));
																}
															
																
																$fechaBase=strtotime($fechaActual);
																while($numDias<$objComp->datosGenerales->cvePeriodoTiempo)
																{
																	$fechaBase=strtotime("+1 day",$fechaBase);
																	if(esDiaHabilInstitucion(date("Y-m-d",$fechaBase)))
																	{
																		$numDias++;
																	}
																}
																
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d",$fechaBase)." ".(isset($objComp->datosGenerales->horaLimite)?$objComp->datosGenerales->horaLimite:"23:59:59");
																
																
															break;
															case 3://D\xEDas Naturales
															
																if(isset($objComp->datosGenerales->aPartirDe))
																{
																	if($objComp->datosGenerales->aPartirDe==2)
																	{
																		
																		$fechaActual=strtotime("+1 day",strtotime($fechaActual));
																		$arrInfoRegistro["fechaInicio"]=date("Y-m-d",$fechaActual);
																		$fechaActual=date("Y-m-d",$fechaActual);
																		
																	}
																}
															
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." days",strtotime($fechaActual)))." ".(isset($objComp->datosGenerales->horaLimite)?$objComp->datosGenerales->horaLimite:"23:59:59");
															break;
															case 4://Meses
																$arrInfoRegistro["fechaMaximaAtencion"]=date("Y-m-d H:i",strtotime("+".$objComp->datosGenerales->cvePeriodoTiempo." month",strtotime($fechaActual)));
															
															break;
														}
												
													}
												}
												else
												{
													
												
													$resultadoFechas=resolverExpresionCalculoPHP($objComp->datosGenerales->txtFuncionPeriodoTermino,$this->objParametros,$this->cacheCalculos);
													if(gettype($resultadoFechas)=="array")
													{
														$arrInfoRegistro["fechaInicio"]=$resultadoFechas["fechaInicio"];
														$arrInfoRegistro["fechaMaximaAtencion"]=$resultadoFechas["fechaMaximaAtencion"];
													}
													else
														$arrInfoRegistro["fechaMaximaAtencion"]=removerComillasLimite($resultadoFechas);
												
												}
												
												
												
												
												
												$this->ejecutarConfiguracionAccion($objComp->cumplimientoTermino,$fElemento["idRegistro"],$consulta,$x,1);
												
												
											break;
											case 6: //Notificaci&oacute;n
												$fNotificacion["idProceso"]=$this->idProceso;
												$fNotificacion["etapa"]=$this->objParametros->etapa;
												$fNotificacion["tipoNotificacion"]=$fElemento["idRegistroElemento"];
												$fNotificacion["funcionAplicacion"]=$fElemento["idFuncionAplicacion"];
												$fNotificacion["actorDestinatario"]=$objComp->actorDestinatario;
												$fNotificacion["funcionAsignacionDestinatario"]=$objComp->funcionAsignacionDestinatario;
												$fNotificacion["permiteAccesoProceso"]=$objComp->permiteAccesoProceso;
												$fNotificacion["actorAccesoProceso"]=$objComp->actorAccesoProceso;
												$fNotificacion["notificacionActiva"]=$objComp->notificacionActiva;
												$fNotificacion["idPerfil"]=$objComp->idPerfil;
												$fNotificacion["marcarAtendidaCambioEtapa"]=$objComp->marcarAtendidaCambioEtapa;
												$fNotificacion["confComplementaria"]=$objComp->confComplementaria;	
												
												$query="SELECT tituloNotificacion FROM 9067_notificacionesProceso WHERE idNotificacion=".$fNotificacion["tipoNotificacion"];
												
												$etiquetaElemento=$con->obtenerValor($query);
												$rolActor="";
											
												if($this->objParametros->idActorProceso!=0)
												{
													$query="SELECT actor,tipoActor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$this->objParametros->idActorProceso;
										
													$fActor=$con->obtenerPrimeraFila($query);
													if($fActor[1]==1)
														$rolActor=obtenerTituloRol($fActor[0]);
													else
													{
														$query="SELECT nombreComite FROM 2006_comites WHERE idComite=".$fActor[0];
														$rolActor='Comite: '.$con->obtenerValor($query);
													}
												}
												else
												{
													$rolActor="Actor de sólo lectura";
												}
										
										
												$nombreUsuarioRemitente=obtenerNombreUsuario($_SESSION["idUsr"]).' ('.$rolActor.')';
												
												$cadParametros='{"idFormulario":"'.$this->idFormulario.'","idRegistro":"'.$this->idRegistro.'","idReferencia":"-1","idProceso":"'.$this->idProceso.
															'","idActorProceso":"'.$this->objParametros->idActorProceso.'","etapa":"'.$this->objParametros->etapa.'","idUsuarioRemitente":"'.$_SESSION["idUsr"].
															'","nombreUsuarioRemitente":"'.$nombreUsuarioRemitente.'","idUsuarioDestinatario":"","nombreUsuarioDestinatario":"","permiteAccesoProceso":"'.
															$fNotificacion["permiteAccesoProceso"].'","actorAccesoProceso":"'.($fNotificacion["actorAccesoProceso"]==""?0:$fNotificacion["actorAccesoProceso"]).
															'","idRegistroElemento":"'.$fElemento["idRegistro"].'","iFormulario":"'.$this->idFormulario.'","iRegistro":"'.$this->idRegistro.'"}';
															
												$objParametrosNotificacion=json_decode($cadParametros);
												
												$actorDestinatario=$fNotificacion["actorDestinatario"]==""?0:$fNotificacion["actorDestinatario"];
												$funcionAsignacionDestinatario=$fNotificacion["funcionAsignacionDestinatario"];
												
												$arrDestinatariosNotificacion=array();
												
												if(($funcionAsignacionDestinatario!="")&&($funcionAsignacionDestinatario!=-1))
												{
										
													$cadParametros='{"idFormulario":"'.$this->idFormulario.'","idRegistro":"'.$this->idRegistro.'","idProceso":"'.$this->idProceso.
																	'","idActorProceso":"'.($this->objParametros->idActorProceso==""?0:$this->objParametros->idActorProceso).
																	'","etapa":"'.$this->objParametros->etapa.'","actorDestinatario":"'.$actorDestinatario.
																	'","iFormulario":"'.$this->idFormulario.'","iRegistro":"'.$this->idRegistro.'"}';
													$objParametrosAsignacionDestinatario=json_decode($cadParametros);
													
													
													
													$arrDestinatariosNotificacion=resolverExpresionCalculoPHP($funcionAsignacionDestinatario,$objParametrosAsignacionDestinatario,$this->cacheCalculos);
													
													
												}
												else
												{
													if($actorDestinatario!="")		
													{
														$rolActor=obtenerTituloRol($actorDestinatario);
										
														$query="SELECT u.idUsuario FROM 800_usuarios u,807_usuariosVSRoles r WHERE u.idUsuario=r.idUsuario AND ";				
														
														$arrDestinatarios=explode("_",$actorDestinatario);
														if($arrDestinatarios[1]==0)
															$query.="r.idRol=".$arrDestinatarios[0];
														else
															$query.="r.codigoRol='".$actorDestinatario."'";						
														
														$resDestinatarios=$con->obtenerFilas($query);
														while($fDestinatario=mysql_fetch_row($resDestinatarios))	
														{
															
															$nombreUsuario=obtenerNombreUsuario($fDestinatario[0])." (".$rolActor.")";
															$nombreUsuario=str_replace(" (Suplantado)","",$nombreUsuario);
															$o='{"idUsuarioDestinatario":"'.$fDestinatario[0].'","nombreUsuarioDestinatario":"'.$nombreUsuario.'"}';
															$oDestinatario=json_decode($o);
															
															array_push($arrDestinatariosNotificacion,$oDestinatario);
														}					
														
													}
												}
												
												
												foreach($arrDestinatariosNotificacion as $d)
												{
													
													if(isset($d->actorDestinatario))
													{
														$objParametrosNotificacion->actorAccesoProceso=$d->actorDestinatario;
													}
													
													$objParametrosNotificacion->idUsuarioDestinatario=$d->idUsuarioDestinatario;	
													$objParametrosNotificacion->nombreUsuarioDestinatario=$d->nombreUsuarioDestinatario;

													@$this->registrarNotificacionTableroControl($fElemento["idRegistro"],$fNotificacion["tipoNotificacion"],$objParametrosNotificacion,$consulta,$x);
										
												}
												
											break;
										}
	
	
										if($fElemento["idFuncionRenderer"]!=-1)
										{
											
											$resultadoRenderer=resolverExpresionCalculoPHP($fElemento["idFuncionRenderer"],$this->objParametros,$this->cacheCalculos);
											if(gettype($resultadoRenderer)=='string')
												$etiquetaElemento=removerComillasLimite($resultadoRenderer);
											else
											{
												$etiquetaElemento=$resultadoRenderer["etiquetaElemento"];
												$arrInfoRegistro["valorComplementario1"]=$resultadoRenderer["valorComplementario1"];
												$arrInfoRegistro["valorComplementario2"]=isset($resultadoRenderer["valorComplementario2"])?$resultadoRenderer["valorComplementario2"]:"";
											}
										}
										$arrInfoRegistro["lblEtiquetaRegistro"]=$etiquetaElemento;
										$campoConsulta="";
										$valoresConsulta="";
										foreach($arrInfoRegistro as $clave=>$resto)
										{
											$campoConsulta.=",".$clave;
											$valoresConsulta.=",".($resto==""?"NULL":"'".cv($resto)."'");
										}
										
										$query="SELECT COUNT(*) FROM 00013_registrosMacroProceso WHERE llaveRegistro='".$arrInfoRegistro["llaveRegistro"]."'";
										$numReg=$con->obtenerValor($query);
										if($numReg==0)
										{
											$consulta[$x]="INSERT INTO 00013_registrosMacroProceso(fechaRegistro,idResponsable".$campoConsulta.") VALUES('".date("Y-m-d H:i:s")."','".$_SESSION["idUsr"]."'".$valoresConsulta.")";
											$x++;
											$consulta[$x]="set @idRegistroMacroProceso_".$fElemento["idRegistro"].":=(select last_insert_id())";
											$x++;
											$this->arrIDsRegistros["idRegistroMacroProceso_".$fElemento["idRegistro"]]="";
											
											
										}
									}
								}
							}
						}
					}
				}
			}
			$consulta[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($consulta))
			{
				return $this->ejecutarFuncionesFinales();
			}
		}
		
		function ejecutarFuncionesFinales()
		{
			global $con;
			foreach($this->arrIDsRegistros as $claveID=>$valor)
			{
				$consulta="select @".$claveID;
				$this->arrIDsRegistros[$claveID]=$con->obtenerValor($consulta);
			}
			

			foreach($this->funcionesEjecutar as $clave=>$arrFunciones)
			{
				foreach($arrFunciones as $funcion)
				{
					$query="select ".$clave;
					$idValorRegistro=$con->obtenerValor($query);	
					
					$funcionFinal=str_replace("@idRegistro","'".$idValorRegistro."'",$funcion);
					foreach($this->arrParametros as $claveParametro=>$valor)
					{
						$funcionFinal=str_replace("[".$claveParametro."]",'$this->arrParametros[\''.$claveParametro.'\']',$funcionFinal);
					}
					
					foreach($this->arrIDsRegistros as $claveID=>$valor)
					{
						$funcionFinal=str_replace("[".$claveID."]",$valor,$funcionFinal);
					}

					eval($funcionFinal);
				
				
				}
			}
			return true;
		}
		
		function asociarRegistroProcesoElementoMacroProceso($idFormulario,$idRegistro,$idRegistroElementoMacroProceso,$tiempoAccion)
		{
			global $con;
			
			if(strpos($idRegistroElementoMacroProceso,"_")!==false)
			{
				
				
				$consulta="select @idRegistroMacroProceso_".str_replace("_","",$idRegistroElementoMacroProceso);
				$idRegistroElementoMacroProceso=$con->obtenerValor($consulta);
				
			}
			
			$nombreTabla=obtenerNombreTabla($idFormulario);
			if($con->existeCampo("idRegistroElementoMacroProceso",$nombreTabla)=="")
			{
				
				$consulta="alter table `".$nombreTabla."` add column `idRegistroElementoMacroProceso` bigint(20) default NULL";
				$con->ejecutarConsulta($consulta);	
				
				$idProceso=obtenerIdProcesoFormulario($idFormulario);
				
				$consulta="INSERT INTO 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable,situacion,marcaFinProceso) VALUES(".$idProceso.
							",1000,'Cancelado por Vencimiento de Tarea',0,1,0)";
				$con->ejecutarConsulta($consulta);	
								
			}
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="UPDATE ".$nombreTabla." SET idRegistroElementoMacroProceso=".$idRegistroElementoMacroProceso." WHERE id_".$nombreTabla."=".$idRegistro;
			$x++;
			$query[$x]="INSERT INTO 00014_registrosCreadosElementosMacroProceso(idRegistroElemento,iFormulario,iRegistro,nombreTabla,tiempoEjecucion)VALUES(".
						$idRegistroElementoMacroProceso.",".$idFormulario.",".$idRegistro.",'".$nombreTabla."',".$tiempoAccion.")";
			$x++;
			$query[$x]="commit";
			$x++;
			
			return $con->ejecutarBloque($query);
		}
		
		function resolverTokenConsulta($t)
		{
			global $con;
			$condicion="";
			$arrToken=explode("|",$t->tipoValor);
			switch($arrToken[0])
			{
				case 0:	
				case 1:
					$condicion=" ".$t->tokenMysql;
				break;
			}
			
			return $condicion;
		}
		
		function ejecutarConfiguracionAccion($objConfiguracion,$idRegistroElemento,&$query,&$x,$tiempoAccion)
		{
			global $con;
			if($objConfiguracion->funcionEjecucion!=-1)
			{
				$ejecucion=removerComillasLimite(resolverExpresionCalculoPHP($objConfiguracion->funcionEjecucion,$this->objParametros,$this->cacheCalculos));
			}
			
			
			if($objConfiguracion->procesoArranque!=0)
			{
				$continuar=true;
				if(isset($objConfiguracion->funcionCondicionalArranque) && ($objConfiguracion->funcionCondicionalArranque!=-1))
				{
					$ejecucion=removerComillasLimite(resolverExpresionCalculoPHP($objConfiguracion->funcionCondicionalArranque,$this->objParametros,$this->cacheCalculos));
					
					$continuar=($ejecucion==1);
				
				}
				if($continuar)
				{
				
				
					$arrValores=array();
					$arrDocumentos=NULL;
					$idFormularioBaseDestino=obtenerFormularioBase($objConfiguracion->procesoArranque);

					foreach($objConfiguracion->valoresArranque as $vA)
					{
						$this->objParametros->campoTablaDestino=$vA->campoDestino;
						$fArrancador=array();
						$fArrancador["campoTablaDestino"]=$vA->campoDestino;
						$fArrancador["valor"]=$vA->valor;
						$fArrancador["tipoLlenado"]=$vA->tipoLlenado;
					
						
						
						
						$valorCampo="";
						$valor=$fArrancador["valor"];
						switch($fArrancador["tipoLlenado"])
						{
							case 0: //Ninguno
								
								
							break;
							case 7: //Funci\xF3n de sistema
								if($valor!="")
								{
									$valorCampo=removerComillasLimite(resolverExpresionCalculoPHP($valor,$this->objParametros,$this->cacheCalculos));
								}
								
							
							
							break;
							case 6: //Valor de formulario base
								if($valor!="")
								{
									if($valor>0)
									{
										$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$valor;
										$campoMysql=$con->obtenerValor($consulta);
									}
									else
									{
										$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$valor;
										$campoMysql=$con->obtenerValor($consulta);
										
										if($valor==-28)
										{
											$campoMysql="id__".$this->objParametros->idFormulario."_tablaDinamica";
										}
										
										
										
									}
		
									$valorCampo=$this->filaRegistro[$campoMysql];
								}
							break;
							case 1: //Valor de sesi\xF3n
								$consulta="SELECT valorSesion FROM 8003_valoresSesion WHERE idValorSesion=".$valor;
								$valor=$con->obtenerValor($consulta);
								$valorCampo=$_SESSION[$valor];
							break;
							case 8: //Valor manual
								$valorCampo=$valor;			
							break;
							case 2: //'Valor de sistema
								switch($valor)
								{
									case 8:  //Fecha del sistema
										$valorCampo=date("Y-m-d");
									break;
									case 9:	//Hora del sistema
										$valorCampo=date("H:i:s");
									break;
									case 10:	//Hora del sistema
										$valorCampo=date("Y-m-d H:i:s");
									break;
								}
							break;
						}
						
						if($valorCampo!="")
							$arrValores[$fArrancador["campoTablaDestino"]]=$valorCampo;
					}

					$this->crearInstanciaRegistroFormularioConsulta($idFormularioBaseDestino,-1,$objConfiguracion->etapaArranque,$arrValores,$arrDocumentos,-1,0,"",$idRegistroElemento,$query,$x,$tiempoAccion);
				}
			}
			
		}
		
		function ejecutarConfiguracionAccionTrigger($objConfiguracion,$idRegistroElemento,$tiempoAccion)
		{
			global $con;
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$this->ejecutarConfiguracionAccion($objConfiguracion,$idRegistroElemento,$consulta,$x,$tiempoAccion);
				
			$consulta[$x]="commit";
			$x++;

			if( $con->ejecutarBloque($consulta))
			{
				return $this->ejecutarFuncionesFinales();
			}
			
		}
		
		function crearInstanciaRegistroFormularioConsulta($idFormulario,$idReferencia,$etapaActual,$arrValores,$arrDocumentosReferencia,$idPerfil=-1,$actor=0,$comentariosAdicionales="",$idRegistroElemento,&$consulta,&$x,$tiempoAccion) //Modificado
		{
			global $con;
			
			$cadenaCampo="";
			$cadenaValores="";
			
			foreach($arrValores as $campo=>$valor)
			{
	
				$valor=trim($valor." ");
				if(($campo!='fechaCreacion')&&($campo!='responsable')&&($campo!='codigoUnidad')&&($campo!='codigoInstitucion')&&($campo!='codigo')&&($campo!='idReferencia')&&($campo!='idEstado'))
				{
					$cadenaCampo.=",".$campo;
				
					
					
					
					if(($valor=="")&&($valor!="0"))
						$valor="NULL";
					
					
					
					
					if($valor!="NULL")
						$cadenaValores.=",'".cv($valor)."'";
					else
						$cadenaValores.=",".$valor."";
				}
			}
			
			if(isset($arrValores["idReferencia"])&&($arrValores["idReferencia"]!=-1)&&($arrValores["idReferencia"]!=""))
			{
				$idReferencia=$arrValores["idReferencia"];
			}
			
			$fechaCreacion=(isset($arrValores["fechaCreacion"]) && ($arrValores["fechaCreacion"]!=""))?$arrValores["fechaCreacion"]:date("Y-m-d H:i:s");
			$responsable=(isset($arrValores["responsable"]) && ($arrValores["responsable"]!=""))?$arrValores["responsable"]:$_SESSION["idUsr"];
			$codigo=(isset($arrValores["codigo"]) && ($arrValores["codigo"]!=""))?$arrValores["codigo"]:"";
			$codigoUnidad=(isset($arrValores["codigoUnidad"]) && ($arrValores["codigoUnidad"]!=""))?$arrValores["codigoUnidad"]:$_SESSION["codigoUnidad"];
			$codigoInstitucion=(isset($arrValores["codigoInstitucion"]) && ($arrValores["codigoInstitucion"]!=""))?$arrValores["codigoInstitucion"]:$_SESSION["codigoInstitucion"];
	
			$consulta[$x]="INSERT INTO _".$idFormulario."_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo".$cadenaCampo.")
						VALUES(".$idReferencia.",'".$fechaCreacion."',".$responsable.",1,'".$codigoUnidad."','".$codigoInstitucion."','".$codigo."'".$cadenaValores.")";
			$x++;
			
			
			$consulta[$x]="set @idRegistro_".$idRegistroElemento.":=(select last_insert_id())";
			$x++;
			
			$this->funcionesEjecutar["@idRegistro_".$idRegistroElemento]=array();
			
			if(!isset($arrValores["codigo"])||($arrValores["codigo"]==""))
			{
				$objEjecucion='asignarFolioRegistro('.$idFormulario.',@idRegistro);';
				array_push($this->funcionesEjecutar["@idRegistro_".$idRegistroElemento],$objEjecucion);
			}
				
			
	
			
			if($arrDocumentosReferencia!=NULL)
			{
				foreach($arrDocumentosReferencia as $idDocumento)
				{
					
					
					$objEjecucion='registrarDocumentoReferenciaProceso('.$idFormulario.',@idRegistro,'.$idDocumento.');';
					array_push($this->funcionesEjecutar["@idRegistro_".$idRegistroElemento],$objEjecucion);
					
				}
			}
			
			$objEjecucion='$this->asociarRegistroProcesoElementoMacroProceso('.$idFormulario.',@idRegistro,"'.$idRegistroElemento.'","'.$tiempoAccion.'");';
			array_push($this->funcionesEjecutar["@idRegistro_".$idRegistroElemento],$objEjecucion);
			if($etapaActual>0)
			{
				
				$this->arrParametros["comentarios_".$idRegistroElemento]=$comentariosAdicionales;
				$objEjecucion='cambiarEtapaFormulario('.$idFormulario.',@idRegistro,'.$etapaActual.',[comentarios_'.$idRegistroElemento.'],-1,"NULL","NULL",\''.$actor.'\');';
				array_push($this->funcionesEjecutar["@idRegistro_".$idRegistroElemento],$objEjecucion);
				
			}
			return true;
		}
		
		function registrarNotificacionTableroControl($idRegistroElemento,$idNotificacion,$objParametrosNotificacion,&$query,&$x)
		{
			global $con;
			global $considerarSecretariasTareas;
			global $funcionEnvioCorreoElectronico;


			$arrQueries=resolverQueries($idNotificacion,9067,$objParametrosNotificacion,true);
			$consulta="SELECT * FROM 9067_notificacionesProceso WHERE idNotificacion=".$idNotificacion;

			
			$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
			$tableroControlAsociado=$fNotificacion["tableroControlAsociado"];
			$nombreTabla="9060_tableroControl_".$tableroControlAsociado;
			$consulta="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."' ORDER BY COLUMN_NAME";
			$listaCamposTabla=$con->obtenerListaValores($consulta,"'");
			if($listaCamposTabla=="")
				$listaCamposTabla=-1;
				
			$arrCamposValor=array();
			$listaCampos="";
			$listaValores="";
			$consulta="SELECT campoTablero,tipoLlenado,valor FROM 9068_configuracionNotificacionTableroControl WHERE 
						idNotificacion=".$idNotificacion." and tipoLlenado is not null and campoTablero in (".$listaCamposTabla.") and campoTablero not in('llaveTarea')";
		
			$rCamposTablero=$con->obtenerFilas($consulta);
			while($fCampoTablero=mysql_fetch_row($rCamposTablero))
			{
				$valor=$fCampoTablero[2];
				$valorFinal="NULL";
				switch($fCampoTablero[1])
				{
					case 1://Valor de sesión
						$consulta="SELECT valorSesion FROM 8003_valoresSesion WHERE idValorSesion=".$valor;
						
						$valor=$con->obtenerValor($consulta);
						$valorFinal="'".$_SESSION[$valor]."'";
					break;
					case 2://valor de sistema
						switch($valor)
						{
							case 8:  //Fecha del sistema
								$valorFinal="'".date("Y-m-d")."'";
							break;
							case 9:	//Hora del sistema
								$valorFinal="'".date("H:i:s")."'";
							break;
							case 10:	//Hora del sistema
								$valorFinal="'".date("Y-m-d H:i:s")."'";
							break;
						}
					break;
					case 3: //Consulta auxiliar			
						if(isset($arrQueries[$valor]))
						{
							if($arrQueries[$valor]["ejecutado"]==1)
							{
								$valorFinal="'".removerComillasLimite($arrQueries[$valor]["resultado"])."'";
							}
						}			
					break;
					case 4: //Almacén de datos	
						if($valor!="")
						{
							$valor=json_decode($valor);
							
							if(isset($arrQueries[$valor->idAlmacen]))
							{
								if($arrQueries[$valor->idAlmacen]["ejecutado"]==1)
								{
									$res=$arrQueries[$valor->idAlmacen]["resultado"];
									
									$conAux=$arrQueries[$valor->idAlmacen]["conector"];
									$conAux->inicializarRecurso($res);
									
									while($f=$conAux->obtenerSiguienteFilaAsoc($res))
									{
										$nCampo=str_replace(".","_",$valor->campo);
										
										
										if(isset($f[$nCampo]))
										{
											$valorFinal="'".$f[$nCampo]."'";
											
										}
										break;
									}
								}
							}			
						}
					break;
					case 5:
						eval('$valorFinal=isset($objParametrosNotificacion->'.$valor.')?"\'".$objParametrosNotificacion->'.$valor.'."\'":"NULL";');
						
					break;
					case 6:		
						
						if($valor!="")
						{
							if($valor>0)
							{
								
								$valorFinal="'".obtenerValorControlFormularioBase($valor,$objParametrosNotificacion->idRegistro)."'";
								
								
							}
							else
							{
								
								$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$valor;
								$campoMysql=$con->obtenerValor($consulta);
								
								$consulta="SELECT ".$campoMysql." FROM _".$objParametrosNotificacion->idFormulario."_tablaDinamica WHERE id__".$objParametrosNotificacion->idFormulario."_tablaDinamica=".$objParametrosNotificacion->idRegistro;
								$valorFinal="'".$con->obtenerValor($consulta)."'";
								
							}
						}
						
					break;
					case 7:	
						//funcion de sistema
						
						$objParametros=$objParametrosNotificacion;
						if($valor!="")
							$valorFinal="'".removerComillasLimite(resolverExpresionCalculoPHP($valor,$objParametros,$cacheCalculos))."'";
						
					break;
					case 8:
						$valorFinal="'".$valor."'";				
						
					break;
					
					
				}
		
				
				$arrCamposValor[$fCampoTablero[0]]=$valorFinal;
		
				
				
			}	

			foreach($arrCamposValor as $campo=>$valor)
			{
				$listaCampos.=",".$campo;
				$listaValores.=",".$valor;
				
			}
			
			$contenidoMensaje=$fNotificacion["cuerpoNotificacion"];
			
			$arrValoresCuerpo=$fNotificacion["arrValoresCuerpo"];
			if($arrValoresCuerpo!="[]")
			{
				$arrValoresCuerpo=json_decode('{"valores":'.$arrValoresCuerpo.'}');
			
				foreach($arrValoresCuerpo->valores as $r)
				{
					$valor=resolverParametroCuerpoNotificacion($r,$objParametrosNotificacion,$arrQueries);
					
					$contenidoMensaje=str_replace($r->lblVariable,$valor,$contenidoMensaje);
				}
			}
		
			$objConfiguracion="";	
			
			if($objParametrosNotificacion->permiteAccesoProceso==1)
			{
				$objConfiguracion='{"actorAccesoProceso":"'.$objParametrosNotificacion->actorAccesoProceso.'","idElementoMacroProceso":"'.$objParametrosNotificacion->idRegistroElemento.
								'","funcionApertura":"mostrarVentanaAperturaProcesoNotificacionMacroProceso"}';
			}
			
			$llaveTarea=bE($objParametrosNotificacion->idFormulario."_".$objParametrosNotificacion->idRegistro."_".$idNotificacion."_".(removerCerosDerecha($objParametrosNotificacion->etapa)));
		
			if($objParametrosNotificacion->idReferencia=="")
				$objParametrosNotificacion->idReferencia=-1;
			
			$nReg=0;
			if($fNotificacion["repetible"]==0)
			{
				$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE idUsuarioDestinatario=".$objParametrosNotificacion->idUsuarioDestinatario.
						" AND idNotificacion=".$fNotificacion["idNotificacion"]." and iFormulario=".$objParametrosNotificacion->idFormulario.
						" and iRegistro=".$objParametrosNotificacion->idRegistro." and usuarioDestinatario='".
						cv($objParametrosNotificacion->nombreUsuarioDestinatario)."' and llaveTarea='".$llaveTarea."'";
				
				$nReg=$con->obtenerValor($consulta);	
			}
			
			$agregarSecretaria=false;
			$numEtapaRegistro=$objParametrosNotificacion->etapa;
			if($nReg==0)
			{
				
				$query[$x]="INSERT INTO ".$nombreTabla."(codigoUnidad,fechaAsignacion,idNotificacion,tipoNotificacion,
							usuarioRemitente,idUsuarioRemitente,usuarioDestinatario,idUsuarioDestinatario,idEstado,contenidoMensaje,
							iFormulario,iRegistro,iReferencia,objConfiguracion,permiteAbrirProceso,numEtapaRegistro,llaveTarea".$listaCampos.")
							values('".$codigoUnidad."','".date("Y-m-d H:i:s")."',".$fNotificacion["idNotificacion"].",'".
							cv($fNotificacion["tituloNotificacion"])."','".cv($objParametrosNotificacion->nombreUsuarioRemitente).
							"',".$objParametrosNotificacion->idUsuarioRemitente.",'".cv($objParametrosNotificacion->nombreUsuarioDestinatario).
							"',".$objParametrosNotificacion->idUsuarioDestinatario.",1,'".cv($contenidoMensaje)."',".
							$objParametrosNotificacion->idFormulario.",".$objParametrosNotificacion->idRegistro.",".
							$objParametrosNotificacion->idReferencia.",'".cv($objConfiguracion)."',".
							$objParametrosNotificacion->permiteAccesoProceso.",".$numEtapaRegistro.",'".$llaveTarea."'".$listaValores.")";
				$x++;
				
				$llaveParametro="@idNotificacion_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
				$query[$x]="set ".$llaveParametro.":=(select last_insert_id())";
				$x++;
				
				
				
				
				if($fNotificacion["enviarMail"]==1)
				{
					$this->funcionesEjecutar[$llaveParametro]=array();
					 	
					if($con->existeCampo("notificadoMail",$nombreTabla)=="")
					{
						
						$consulta="alter table `".$nombreTabla."` add column `notificadoMail` int(11) default 0";
						$con->ejecutarConsulta($consulta);					
					}
					$arrDestinatario=array();
					$arrDocumentos=NULL;
					$arrCCO=NULL;
					$arrCC=NULL;
					
					$resultado="";
					$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$objParametrosNotificacion->idUsuarioDestinatario;
					$resMailDestinatario=$con->obtenerFilas($consulta);
					while($filaMail=mysql_fetch_row($resMailDestinatario))
					{
						$m=$filaMail[0];
						$objMail[0]=$m;
						$objMail[1]="";
						if(esEmail($m))
						{
							if(existeValorMatriz($arrDestinatario,$m)==-1)
								array_push($arrDestinatario,$objMail);
						}
					}
					
					$llaveArrDestinatario="arrDestinatario_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveArrDestinatario]=$arrDestinatario;
					
					
					$llaveTituloNotificacion="tituloNotificacion_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveTituloNotificacion]=$fNotificacion["tituloNotificacion"];

					$llaveContenidoMensajeNotificacion="contenidoMensaje_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveContenidoMensajeNotificacion]=$contenidoMensaje;
					
					$llaveArrDocumentos="arrDocumentos_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveArrDocumentos]=$arrDocumentos;
					
					$llaveArrCCO="arrCCO_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveArrCCO]=$arrCCO;
					
					$llaveArrCC="arrCC_".$idRegistroElemento."_".$objParametrosNotificacion->idUsuarioDestinatario;
					$this->arrParametros[$llaveArrCC]=$arrCC;
					
					$objEjecucion='$this->enviarCorreoElectronicoNotificacion(@idRegistro,\''.$nombreTabla.'\',['.$llaveArrDestinatario.'],['.$llaveTituloNotificacion.'],['.$llaveContenidoMensajeNotificacion.'],"","",['.$llaveArrDocumentos.'],['.$llaveArrCCO.'],['.$llaveArrCC.']);';
					array_push($this->funcionesEjecutar[$llaveParametro],$objEjecucion);
				}
				
				$objEjecucion='$this->asociarRegistroTareaElementoMacroProceso(\''.$nombreTabla.'\',@idRegistro,[idRegistroMacroProceso_'.$idRegistroElemento.']);';
				array_push($this->funcionesEjecutar[$llaveParametro],$objEjecucion);
				
			}
			
			return true;
		}
		
		function asociarRegistroTareaElementoMacroProceso($nombreTablaTablero,$idRegistro,$idRegistroElementoMacroProceso)
		{
			global $con;
			$x=0;
			$query=array();
			$query[$x]="begin";
			$x++;
			$query[$x]="INSERT INTO 00014_registrosCreadosElementosMacroProceso(idRegistroElemento,iFormulario,iRegistro,nombreTabla) 
					VALUES(".$idRegistroElementoMacroProceso.",NULL,".$idRegistro.",'".cv($nombreTablaTablero)."')";
			$x++;
			$query[$x]="commit";
			$x++;

			return $con->ejecutarBloque($query);
		}
		
		
		function enviarCorreoElectronicoNotificacion($idNotificacion,$nombreTabla,$arrDestinatario,$tituloNotificacion,$contenidoMensaje,$valor1,$valor2,$arrDocumentos,$arrCCO,$arrCC)
		{
			global $con;
			global $funcionEnvioCorreoElectronico;

			$x=0;
			$query[$x]="begin";
			$x++;
			
			if(count($arrDestinatario)>0)
			{

				eval('$resultado=@'.$funcionEnvioCorreoElectronico.'($arrDestinatario,$tituloNotificacion,$contenidoMensaje,$valor1,$valor2,$arrDocumentos,$arrCCO,$arrCC);');
				if($resultado)
				{
					$query[$x]="UPDATE ".$nombreTabla." SET notificadoMail=1 WHERE idRegistro=".$idNotificacion;
					$x++;
				}
				else
				{
					$query[$x]="UPDATE ".$nombreTabla." SET notificadoMail=2 WHERE idRegistro=".$idNotificacion;
					$x++;
				}
			}
			else
			{
				$query[$x]="UPDATE ".$nombreTabla." SET notificadoMail=-1 WHERE idRegistro=".$idNotificacion;
				$x++;
			}
			$query[$x]="commit";
			$x++;
			
			return $con->ejecutarBloque($query);
		}
		
		
		function marcarRegistroMacroProcesoArranque($idRegistro)
		{
			global $con;
			
			$consulta="SELECT eM.objConfiguracion,eM.idRegistro FROM 00013_registrosMacroProceso rM,00010_elementosEtapasProcesosMacroprocesos eM WHERE rM.idRegistro=".$idRegistro."
					AND eM.idRegistro=rM.idElemento";

			$fRegistroMacroproceso=$con->obtenerPrimeraFilaAsoc($consulta);
			$cadObjConfiguracion=$fRegistroMacroproceso["objConfiguracion"];
			$objConfiguracion=json_decode($cadObjConfiguracion);
			
			if($this->ejecutarConfiguracionAccionTrigger($objConfiguracion->arranqueTermino,$idRegistro,1))
			{
				
				return $con->ejecutarConsulta($consulta);
			}
		}
		
		function marcarRegistroMacroProcesoAtendido($idRegistro)
		{
			global $con;
			$consulta="SELECT eM.objConfiguracion,eM.idRegistro FROM 00013_registrosMacroProceso rM,00010_elementosEtapasProcesosMacroprocesos eM WHERE rM.idRegistro=".$idRegistro."
					AND eM.idRegistro=rM.idElemento";
			$fRegistroMacroproceso=$con->obtenerPrimeraFilaAsoc($consulta);

			$cadObjConfiguracion=$fRegistroMacroproceso["objConfiguracion"];
			$objConfiguracion=json_decode($cadObjConfiguracion);
			
			if($this->ejecutarConfiguracionAccionTrigger($objConfiguracion->cumplimientoTermino,$idRegistro,2))
			{
				$consulta="UPDATE 00013_registrosMacroProceso SET situacionActual=2,fechaCambioSituacion='".date("Y-m-d H:i:s")."' WHERE idRegistro=".$idRegistro;
				return $con->ejecutarConsulta($consulta);
			}
		}
		
		function marcarRegistroMacroProcesoIncumplido($idRegistro)
		{
			global $con;
			$consulta="SELECT eM.objConfiguracion,eM.idRegistro FROM 00013_registrosMacroProceso rM,00010_elementosEtapasProcesosMacroprocesos eM WHERE rM.idRegistro=".$idRegistro."
					AND eM.idRegistro=rM.idElemento";
			$fRegistroMacroproceso=$con->obtenerPrimeraFilaAsoc($consulta);
			$cadObjConfiguracion=$fRegistroMacroproceso["objConfiguracion"];
			$objConfiguracion=json_decode($cadObjConfiguracion);
			if($this->ejecutarConfiguracionAccionTrigger($objConfiguracion->vencimientoTermino,$idRegistro,3))
			{
				$x=0;
				$query[$x]="begin";
				$x++;
				$query[$x]="UPDATE 00013_registrosMacroProceso SET situacionActual=3,fechaCambioSituacion='".date("Y-m-d H:i:s")."' WHERE idRegistro=".$idRegistro;
				$x++;
				
				$consulta="SELECT iFormulario,iRegistro FROM 00014_registrosCreadosElementosMacroProceso WHERE idRegistroElemento=".$idRegistro." and tiempoEjecucion=1";
				$fRegistroCreado=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fRegistroCreado && ($fRegistroCreado["iFormulario"]!=""))
				{
					$consulta="SELECT id__".$fRegistroCreado["iFormulario"]."_tablaDinamica FROM _".$fRegistroCreado["iFormulario"]."_tablaDinamica WHERE idRegistroElementoMacroProceso=".$idRegistro;
					

					$iRegistro=$con->obtenerValor($consulta);
					$idProceso=obtenerIdProcesoFormulario($fRegistroCreado["iFormulario"]);
					
					
					$consulta="SELECT COUNT(*) FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=1000";
					$numRegAux=$con->obtenerValor($consulta);
					
					if($numRegAux==0)
					{
						$consulta="INSERT INTO 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable,situacion,marcaFinProceso) VALUES(".$idProceso.
							",1000,'Cancelado por Vencimiento de Tarea',0,1,0)";
						$con->ejecutarConsulta($consulta);
					}
					
					
					cambiarEtapaFormulario($fRegistroCreado["iFormulario"],$iRegistro,1000,"Registro Cancelado de Manea Automatica por Vencimiento de Tarea",-1,"NULL","NULL",0);
				}
				
				
				$query[$x]="commit";
				$x++;
				

				

				return $con->ejecutarBloque($query);
			}

			
			
		}
	}
?>