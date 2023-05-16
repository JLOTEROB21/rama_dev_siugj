<?php 
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	
	
	$arrResultConsulta=null;
	function getInfoThotReporterExport($reportID,$xmlParams,$sistemKey)
	{
		global $con;
		global $idReporte;
		global $resultadoGlobal;
		global $arrResultConsulta;
		
		$cXML=NULL;
		if($xmlParams!="")
			$cXML=simplexml_load_string($xmlParams);
		
		$idReporte=bD($reportID);//
		
		$consulta="SELECT parametro FROM 9015_parametrosReporte WHERE idReporte=".$idReporte;
		$resParam=$con->obtenerFilas($consulta);
		$arrValorParamReporte="";
		$cadenaHiddenParam="";
		$paramAmbiente='"idReporte":"'.$idReporte.'"';
		while($filaParam=mysql_fetch_row($resParam))
		{
			$vParam="";
			if($cXML)
			{
				$exp='$vParam=(string)$cXML->'.$filaParam[0].";";
				eval($exp);
			}
			$paramAmbiente.=',"'.$filaParam[0].'":"'.$vParam.'"';
			if($arrValorParamReporte=="")
				$arrValorParamReporte='"p'.$filaParam[0].'":"'.$vParam.'"';
			else
				$arrValorParamReporte.=',"p'.$filaParam[0].'":"'.$vParam.'"';
				
		}
		
		
		$cadObj='{"p2":{'.$arrValorParamReporte.'},"parametrosAmbiente":{'.$paramAmbiente.'}}';
		$paramObj=json_decode($cadObj);
	
		$ojParametrosReporte=$paramObj->p2;
		$parametrosAmbiente=$paramObj->parametrosAmbiente;
		$arrResultConsulta=resolverQueries($idReporte,1,$paramObj,true);
		$resultadoGlobal='<?xml version="1.0" encoding="ISO-8859-1"?><dataReport>';
		$resultadoGlobal.=crearElementosReporte();
		$resultadoGlobal.="</dataReport>";
		
		return $resultadoGlobal;
	}
	
	function crearElementosReporte($idPadre=null,$posZIndex=1)
	{
		global $idReporte;
			global $toWord;
			global $urlSitio;
			global $baseDir;
			global $funcionesJava;
			global $con;
			global $et;
			global $objParametros;
			global $idReporte;
			global $nTabla;
			global $ojParametrosReporte;
			$nombreTabla=$nTabla;
			global $calibrarCtrl;
			global $cc;
			global $numElementos;
			global $arrElementosFocus;
			global $nElementosFocus;
			global $arrResultConsulta;
			$cadEtiquetaElementos="";
			global $posX;
			global $posY;
			global $parametrosAmbiente;
			global $funcionesJavaInicio;
			$idCtrlPadre="-1";
			$divPadre=0;
			$maxValorY=0;
			$strParam="";
			$grafica=null;
			$idRol="'-1'";
			if(isset($_SESSION["idRol"]))
				$iRol=$_SESSION["idRol"];
				
			$idUsr="'-1'";	
			if(isset($_SESSION["idUsr"]))
				$idUsr=$_SESSION["idUsr"];
			$consulta="select idGrupoElemento from 9011_elementosReportesExclusion where idReporte=".$idReporte.
					" and ((usuarioExclusion in (".$idRol.") and tipoUsuario=0) or (usuarioExclusion = (".$idUsr.") and tipoUsuario=1))";
			$listaElemExclusion=$con->obtenerListaValores($consulta);
			if($listaElemExclusion=="")
				$listaElemExclusion="-1";
			
			$resultadoGlobal="";
			$etiqueta="";
			if($idPadre==null)
				$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where  idPadre=-1 
						and idGrupoElemento not in (".$listaElemExclusion.") and idReporte=".$idReporte.
						" and tipoElemento not in (1,26,23) and idReporte=".$idReporte."";
			else
			{
				$query="select idGrupoElemento,nombreCampo,tipoElemento, posX,posY,eliminable 
				from 9011_elementosReportesThot where tipoElemento not in (1,23) and idGrupoElemento not in (".$listaElemExclusion.
					") and idReporte=".$idReporte." and idPadre=".$idPadre;
			}
	
			$res=$con->obtenerFilas($query);
			$filaE=array();
			while($fElemento=mysql_fetch_row($res))
			{
	
				$numElementos++;
				
				$val='';
				$nombreControl="dataElement_".$fElemento[0]."";	
				$resultadoGlobal.="<".$nombreControl.">";
				switch($fElemento[2])					
				{
					
					case 25:  //Seccion repetible
						
						$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE idSeccion=".$fElemento[0]." and principal=1";
						$idAlmacen=$con->obtenerValor($consulta);
						$almacen=$arrResultConsulta[$idAlmacen]["resultado"];
						$conAux=NULL;
						
						if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
						{
							$conAux=$arrResultConsulta[$idAlmacen]["conector"];
							$conAux->inicializarRecurso($almacen);
						}
	
						$numCt=1;
						$fila=array();
						$etiqueta="<recordDataElement>";
						while($fila=$conAux->obtenerSiguienteFilaAsoc($almacen))
						{
	
							$etiqueta.=crearElementosRepetible($fElemento[0],0,$fila,0,0,$numCt);
							
							$numCt++;
							
						}
						$etiqueta.="</recordDataElement>";
					break;
					case 28: //Expresion
						$anchoAsterisco=1;
						$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
	
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tVinculacion=$filaE[9];
						$idAlmacen=$filaE[10];
						$campoRef=$filaE[11];
						$valor="";
						$posIncY=0;
						$alto="10";
						switch($tVinculacion)					
						{
							case "1":
							case "2":
								if($arrResultConsulta[$idAlmacen]["ejecutado"]==1)
								{
	
									if($tVinculacion==2)
										$valor=$arrResultConsulta[$idAlmacen]["resultado"];
									else
									{
										$filaRef=array();
										if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
										{	
											$conAux=$arrResultConsulta[$idAlmacen]["conector"];
											$resultado=$arrResultConsulta[$idAlmacen]["resultado"];
											$conAux->inicializarRecurso($resultado);
											$filaRef=$conAux->obtenerSiguienteFilaAsoc($resultado);
										}
										$cNormalizado=str_replace(".","_",$campoRef);
										
										if(isset($filaRef[$cNormalizado]))
											$valor=$filaRef[$cNormalizado];
									}
									
								}
								else
								{
									$valor="";
								}	
								if(strpos($valor,"'")===0)
									$valor=substr($valor,1,strlen($valor)-2);
							break;
							case "3":
								eval  ('if(isset($parametrosAmbiente->'.$filaE[10].')) {$valor=$parametrosAmbiente->'.$filaE[10].';}');
							break;
							case "4":
								  $arrCache=NULL;
								  $objParametro=json_decode('{"param1":""}');
								  $objParametro->param1=$parametrosAmbiente;
	
								  $valor=resolverExpresionCalculoPHP($filaE[10],$objParametro,$arrCache);
							break;
							
						}
						
						if($filaE[2]=="")
							$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='height:".$alto."px' name='_lbl".$fElemento[0]."'>".$valor."</span>";
						else
							$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='width:".$filaE[2]."px; height:".$alto."px; overflow:hidden; display:inline-block' name='_lbl".$fElemento[0]."'>".$valor."</span>";
						if($filaE[14]!="")
						{
							$funcionesJavaInicio.="asignarValorFormatoRenderer('".$filaE[14]."',-1,'_lbl".$fElemento[0]."',".$fElemento[0].");";
						}
					break;
					case 31:  //Alamcen de graficos
						$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$ancho=$filaE[2];
						$alto=$filaE[3];
						$tipoGrafico=$filaE[4];
						
						
						$idAlmacen=$filaE[6];
						$tipoValor=$filaE[7];
						$cadConf=$filaE[8];
						$objConf=json_decode($cadConf);
						
						$consulta="SELECT nombreGraficoPHP,idCategoria FROM 9026_tiposGraficos WHERE idTiposGraficos=".$tipoGrafico;
						$fGrafico=$con->obtenerPrimeraFila($consulta);
						$nTipoGrafico=$fGrafico[0];
						$idCategoriaGrafico=$fGrafico[1];
						
						/*if($cadConf=="")
							$cadConf="{}";
					
						$objConf=json_decode($cadConf);
						
						$formatoValoresMostrar=0;
						
						if(isset($objConf->showValues))
							$formatoValoresMostrar=$objConf->showValues;
						
						if($objConf->showValues!=0)
							$objConf->showValues=1;
						
						$fuenteTitulo="Calibri";
						$tamanoTitulo=14;
						$colorTitulo="000000";
						if(isset($objConf->baseFontTitulo)&&($objConf->baseFontTitulo!=""))
							$fuenteTitulo=$objConf->baseFontTitulo;
						if(isset($objConf->baseFontSizeTitulo)&&($objConf->baseFontSizeTitulo!=""))
							$tamanoTitulo=$objConf->baseFontSizeTitulo;
						if(isset($objConf->baseFontColorTitulo)&&($objConf->baseFontColorTitulo!=""))
							$colorTitulo=$objConf->baseFontColorTitulo;
						$origenColor=1;
						if(isset($objConf->origenColor))
							$origenColor=$objConf->origenColor;
						
						$decimalPrecision=0;
						$fuenteSubTitulo="Calibri";
						$tamanoSubTitulo=14;
						$colorSubTitulo="000000";
						if(isset($objConf->baseFontSubTitulo)&&($objConf->baseFontSubTitulo!=""))
							$fuenteSubTitulo=$objConf->baseFontSubTitulo;
						if(isset($objConf->baseFontSizeSubTitulo)&&($objConf->baseFontSizeSubTitulo!=""))
							$tamanoSubTitulo=$objConf->baseFontSizeSubTitulo;
						if(isset($objConf->baseFontColorSubTitulo)&&($objConf->baseFontColorSubTitulo!=""))
							$colorSubTitulo=$objConf->baseFontColorSubTitulo;
						
						$grafica->defineStyle("subtitulo","font","font=".$fuenteSubTitulo.";size=".$tamanoSubTitulo.";color=".$colorSubTitulo.";");
						$grafica->applyStyle("SUBCAPTION","subtitulo");
						
						$convertirProcentajes=false;
						
						if(isset($objConf->convertirPorcentaje)&&($objConf->convertirPorcentaje!=0))
						{
							$convertirProcentajes=true;
							
						}
						$comp="";
						$strParam="formatNumberScale=0;showAboutMenuItem=0;exportAtClient=0;exportAction=download;exportHandler=".$urlSitio."/include/latis/ExportHandlers/PHP/FCExporter.php;
									exportFormats=PNG=Exportar como PNG;exportDialogMessage=Capturando imagen, por favor espere ;showPrintMenuItem=0;exportFileName=".str_replace(" ","",$fElemento[1]).";";
									
						$reflectionClase = new ReflectionObject($objConf);
						foreach ($reflectionClase->getProperties() as $property => $value) 
						{
							$nombre=$value->getName();
							$valor=$value->getValue($objConf);
							$strParam.=$nombre."=".$valor.";";
						}
						
						
						$sufijo="";
						if(isset($objConf->numberSuffix))
							$sufijo=$objConf->numberSuffix;
						
						$prefijo="";
						if(isset($objConf->numberPrefix))
							$prefijo=$objConf->numberPrefix;
						if(isset($objConf->decimalPrecision))
							$decimalPrecision=$objConf->decimalPrecision;
						
						*/
						$tipoOrigenCategorias="";
						$tipoOrigenSeries="";
						
						$consulta="SELECT nombreCategoria,idCategoriaAlmacenGrafico,color,tipoCategorias,comp1,valor FROM 9014_categoriasAlmacenesGraficos WHERE idAlmacen=".$idAlmacen." order by idCategoriaAlmacenGrafico";
	
						$resCat=$con->obtenerFilas($consulta);
						
						$arrCategorias=array();
						while($fCat=mysql_fetch_row($resCat))
						{
							$tipoOrigenCategorias=$fCat[3];
							
							switch($tipoOrigenCategorias)
							{
								case 0:
								case 1:
									$obj=array();
									$obj[0]=$fCat[5];
									$obj[1]=$fCat[0];
									$obj[2]=normalizarValorRGB($fCat[2]);
									$obj[3]=array();
									$obj[4]=$fCat[1];
									$arrValores=explode(",",$obj[0]);
									
									foreach($arrValores as $v)
									{
										$v=substr($v,1);
										$v=substr($v,0,strlen($v)-1);
										if($v!="")
											array_push($obj[3],$v);
									}
									array_push($arrCategorias,$obj);
								break;
								case 2:
									
									$cadObj='{"idReporte":"'.$idReporte.'","params":'.json_encode($objParametros).'}';
									$objParam=json_decode($cadObj);
									$cache=NULL;
									$arrValores=resolverExpresionCalculoPHP($fCat[4],$objParam,$cache);
									foreach($arrValores as $v)
									{
										$obj=array();
										$obj[0]=$v["id"];
										$obj[1]=$v["etiqueta"];
										$obj[2]=normalizarValorRGB($v["color"]);
										$obj[3]=array();
										$obj[4]=$fCat[1]."_".$v["id"];
										$arrValores=explode(",",$obj[0]);
										foreach($arrValores as $v)
										{
											if(strpos($v,"'")===0)
											{
												$v=substr($v,1);
												$v=substr(0,strlen($v)-2);
											}
											if($v!="")
												array_push($obj[3],$v);
										}
										array_push($arrCategorias,$obj);
									}
									
								break;
							}
						}
								
						
						$consulta="SELECT titulo,idSerieAlmacenGrafico,color,tipoSerie,comp1,valor FROM 9014_seriesAlmacenesGraficos WHERE idAlmacen=".$idAlmacen." order by idSerieAlmacenGrafico";
						$resSerie=$con->obtenerFilas($consulta);
						
						$arrSeries=array();
						$arrMatrizValoresAux=array();
						while($fSerie=mysql_fetch_row($resSerie))
						{
							$tipoOrigenSeries=$fSerie[3];
							
							switch($tipoOrigenSeries)
							{
								case 0:
								case 1:
									$obj=array();
									$obj[0]=$fSerie[5];
									$obj[1]=$fSerie[0];
									$obj[2]=normalizarValorRGB($fSerie[2]);
									$obj[3]=array();
									$obj[4]=$fSerie[1];
									$arrValores=explode(",",$obj[0]);
									
									foreach($arrValores as $v)
									{
										$v=substr($v,1);
										$v=substr($v,0,strlen($v)-1);
										if($v!="")
											array_push($obj[3],$v);
									}
									array_push($arrSeries,$obj);
								break;
								case 2:
									$cadObj='{"idReporte":"'.$idReporte.'","params":'.json_encode($objParametros).'}';
									$objParam=json_decode($cadObj);
									$cache=NULL;
									$arrValores=resolverExpresionCalculoPHP($fSerie[4],$objParam,$cache);
									foreach($arrValores as $v)
									{
										$obj=array();
										$obj[0]=$v["id"];
										$obj[1]=$v["etiqueta"];
										$obj[2]=normalizarValorRGB($v["color"]);
										$obj[3]=array();
										$obj[4]=$fSerie[1]."_".$v["id"];
										$arrValores=explode(",",$obj[0]);
										foreach($arrValores as $v)
										{
											if(strpos($v,"'")===0)
											{
												$v=substr($v,1);
												$v=substr(0,strlen($v)-2);
											}
											if($v!="")
												array_push($obj[3],$v);
										}
										array_push($arrSeries,$obj);
									}
									
								break;
							}
						}
						
						
						$generaSerie=false;
						
						if(sizeof($arrSeries)==0)
						{
							if($tipoOrigenCategorias==1)
							{
								$generaSerie=true;
								
								$objSerie=array();
								$objSerie[0]="";
								$objSerie[1]="Serie 1";
								$objSerie[2]="";
								$objSerie[3]=array();
								$objSerie[4]="";
								
								array_push($arrSeries,$objSerie);
								
								$consulta="select complementario from 9014_almacenesDatos where idDataSet=".$idAlmacen;
								
								$complementario=$con->obtenerValor($consulta);	
	
								$objComp=json_decode($complementario);
								$idConexion=$objComp->idConexion;
								
								
	
								$consulta="select ".$objComp->campo." from ".$objComp->tablaOrigen;
								$listRegistros="";
								if(isset($objComp->condicionFiltro)&&($objComp->condicionFiltro!=""))
								{
									$objFiltro=json_decode($objComp->condicionFiltro);
									switch($objFiltro->tipoValor)
									{
										case 1:
											$listRegistros=$objFiltro->valor;
										break;
										case 7:  //Consulta auxiliar
											if(isset($arrResultConsulta[$objFiltro->idAlmacen]))
											{
												if($arrResultConsulta[$objFiltro->idAlmacen]["ejecutado"]==1)
													$listRegistros=str_replace("'","",$arrResultConsulta[$objFiltro->idAlmacen]["resultado"]);
											}
										break;
										case 11:  //Almacén de datos
											if(isset($arrResultConsulta[$objFiltro->idAlmacen]))
											{
												if($arrResultConsulta[$objFiltro->idAlmacen]["ejecutado"]==1)
												{
													$conAux=$arrResultConsulta[$objFiltro->idAlmacen]["conector"];
													$resTmp=$arrResultConsulta[$objFiltro->idAlmacen]["resultado"];
													$conAux->inicializarRecurso($resTmp);
													$fDatos=$conAux->obtenerSiguienteFilaAsoc($resTmp);
													$cNomalizado=str_replace(".","_",$objFiltro->campoMysql);
													if(isset($fDatos[$cNomalizado]))
														$listRegistros=$fDatos[$cNomalizado];
												}
											}
										break;
										case 22:  //Invocacion de funcion
											$objParametrosValorSerie=array();
											$reflectionClase = new ReflectionObject($ojParametrosReporte);
											foreach ($reflectionClase->getProperties() as $property => $value) 
											{
												$objParametrosValorSerie[$value->getName()]=$value->getValue($ojParametrosReporte);	
											}
											$cadObj='{"idReporte":"'.$idReporte.'","params":'.json_encode($objParametrosValorSerie).'}';
											$objParam=json_decode($cadObj);
											$cache=NULL;
											$valorTmp=resolverExpresionCalculoPHP($objFiltro->funcion,$objParam,$cache);
											$listRegistros=str_replace("'","",$valorTmp);
										break;
									}
								}
								$conAux=$con;
								if($idConexion!=0)
									$conAux=generarInstanciaConector($idConexion);
								if(!$conAux->conexion)	
									continue;
								if($listRegistros!="")
								{
									$campoLlave=$conAux->obtenerCampoLlave($objComp->tablaOrigen);
									$consulta.=" where ".$campoLlave." in (".$listRegistros.")";
								}
								$resRegistros=NULL;
								if($conAux->existeCampo($objComp->campo,$objComp->tablaOrigen))
								{
									$resRegistros=$conAux->obtenerFilas($consulta);
								}
								else
								{
									if((strpos($objComp->tablaOrigen,"tablaDinamica")!==false)&&($conAux->esSistemaLatis()))
									{
										$queryAux="SELECT tipoElemento FROM 901_elementosFormulario WHERE nombreCampo='".$objComp->campo."'";
										$tipoCampo=$conAux->obtenerValor($queryAux);
										switch($tipoCampo)
										{
											case 17:
											case 18:
											case 19:
												$arrTablaDinamica=explode("_",$objComp->tablaOrigen);
												$nTablaDinamica="_".$arrTablaDinamica[1]."_".$objComp->campo;
												if($conAux->existeTabla($nTablaDinamica))
												{
													$consulta="select idOpcion FROM ".$nTablaDinamica;
													if($listRegistros!="")
														$consulta.=" WHERE idPadre IN(".$listRegistros.")";
													$resRegistros=$conAux->obtenerFilas($consulta);
												}
											break;
										}
										
									}
								}
								
								
								while($fCont=$conAux->obtenerSiguienteFila($resRegistros))
								{
									foreach($arrCategorias as $c)
									{
										if(existeValor($c[3],$fCont[0]))
										{
											if(isset($arrMatrizValoresAux[$c[4]]))
												$arrMatrizValoresAux[$c[4]]++;
											else
												$arrMatrizValoresAux[$c[4]]=1;
											break;
										}
									}
								}
								
								foreach($arrCategorias as $c)
								{
									if(!isset($arrMatrizValoresAux[$c[4]]))
									{
										$arrMatrizValoresAux[$c[4]]=0;
									}
								}
								
								
							}
	
						}
						
						$arrMatrizValores=array();
						$arrTotalSerie=array();
						
						
						$valor=0;
						$llave=0;
						$posSerie=0;
						$posCategoria=0;
						$arrTotalCategoria=array();
						$matrizValoresProcesados=array();
						$totalSerieProcesado=array();
						foreach($arrSeries as $s)
						{
							$total=0;
							$posCategoria=0;
							foreach($arrCategorias as $c)
							{
								$valor=0;
								$fValor=array();
								$fValor[2]="";
								if(!$generaSerie)
								{
									$etiqueta="";
									$consulta="SELECT tipoValor,valor,color,etiqueta FROM 9014_valoresAlmacenGrafico WHERE idAlmacen=".$idAlmacen." AND idCategoria=".$c[4]." AND idSerie=".$s[4];
									$fValor=$con->obtenerPrimeraFila($consulta);
									
									if($fValor)
									{
										if($fValor[3]!="")
											$etiqueta=$fValor[3];
										else
											$etiqueta=$c[1];	
										switch($fValor[0])
										{
											case 1:  //Valor constante
												$valor=$fValor[1];
											break;
											case 7:  //Consulta auxiliar
												$arrValor=explode("|",$fValor[1]);
												if(isset($arrResultConsulta[$arrValor[0]]))
												{
													if($arrResultConsulta[$arrValor[0]]["ejecutado"]==1)
													{
														$valor=str_replace("'","",$arrResultConsulta[$arrValor[0]]["resultado"]);
														
														if(!is_numeric($valor))
															$valor=0;
													}
													else
													{
														$consulta=$arrResultConsulta[$arrValor[0]]["query"];
														
	
														if(sizeof($c[3])>0)
															$consulta=str_replace("'@idCategoria'",$c[0],$consulta);
														if(sizeof($s[3])>0)	
															$consulta=str_replace("'@idSerie'",$s[0],$consulta);
														
	
														if(strpos($consulta,"'@")===false)
														{
															$conAux=$arrResultConsulta[$arrValor[0]]["conector"];
															$valor=$conAux->obtenerValor($consulta);
															if(!is_numeric($valor))
																$valor=0;
															
														}
														else
															$valor=0;
														
													}
												}
												
												
											break;
											case 11:  //Almacén de datos
												$valor=0;
												$arrValor=explode("|");
												if(isset($arrResultConsulta[$arrValor[0]]))
												{
													if($arrResultConsulta[$arrValor[0]]["ejecutado"]==1)
													{
														$resTmp=$arrResultConsulta[$arrValor[0]]["resultado"];
														
														$conAux=$arrResultConsulta[$arrValor[0]]["conector"];
														$resTmp=$arrResultConsulta[$arrValor[0]]["resultado"];
														$conAux->inicializarRecurso($resTmp);
														$fDatos=$conAux->obtenerSiguienteFilaAsoc($resTmp);
														$cNomalizado=str_replace(".","_",$arrValor[1]);
														if(isset($fDatos[$cNomalizado]))
															$valor=$fDatos[$cNomalizado];
														if(!is_numeric($valor))
															$valor=0;
															
														
														
													}
													else
													{
														$consulta=$arrResultConsulta[$arrValor[0]]["query"];
														if(sizeof($c[3])>0)
															$consulta=str_replace("'@idCategoria'",$c[0],$consulta);
														if(sizeof($s[3])>0)	
															$consulta=str_replace("'@idSerie'",$s[0],$consulta);
		
														if(strpos($consulta,"'@")===false)
														{
															$conAux=$arrResultConsulta[$arrValor[0]]["conector"];
															$resTmp=$conAux->obtenerFilas($consulta);
															$fDatos=$conAux->obtenerSiguienteFilaAsoc($resTmp);
															$cNomalizado=str_replace(".","_",$arrValor[1]);
															if(isset($fDatos[$cNomalizado]))
																$valor=$fDatos[$cNomalizado];
															if(!is_numeric($valor))
																$valor=0;
														}
														else
															$valor=0;
														
													}
												}
												
											break;
											case 22:  //Invocacion de funcion
												$objParametrosValorSerie=array();
												$objParametrosValorSerie["idSerie"]=$s[4];
												$objParametrosValorSerie["valorSerie"]=implode(",",$s[3]);
												$objParametrosValorSerie["idCategoria"]=$c[4];
												$objParametrosValorSerie["valorCategoria"]=implode(",",$c[3]);
												$reflectionClase = new ReflectionObject($objParametros);
												
												foreach ($reflectionClase->getProperties() as $property => $value) 
												{
													$objParametrosValorSerie[$value->getName()]=$value->getValue($objParametros);	
												}
												$cadObj='{"idReporte":"'.$idReporte.'","params":'.json_encode($objParametrosValorSerie).'}';
												$objParam=json_decode($cadObj);
												$cache=NULL;
												$valorTmp=resolverExpresionCalculoPHP($fValor[1],$objParam,$cache);
													
												if(gettype($valorTmp)=="array")
												{
													$fValor[2]=$valorTmp["color"];
													$valor=$valorTmp["valor"];
													if(isset($valorTmp["etiqueta"]))
														$etiqueta=$valorTmp["etiqueta"];
												}
												else
													$valor=$valorTmp;
												$valor=str_replace("'","",$valor);
												if(!is_numeric($valor))
													$valor=0;
												
											break;
										}
									}
								}
								else
								{
									$etiqueta=$c[1];	
									$valor=$arrMatrizValoresAux[$c[4]];
								}
								$total+=$valor;
								if(!isset($arrTotalCategoria[$posCategoria]))
									$arrTotalCategoria[$posCategoria]=$valor;
								else
									$arrTotalCategoria[$posCategoria]+=$valor;	
								
								
								if(!isset($totalSerieProcesado[$c[4]]))
									$totalSerieProcesado[$c[4]]=0;
								
								$totalSerieProcesado[$c[4]]+=$valor;
								
								$objData[0]=$valor;
								$objData[1]=normalizarValorRGB($fValor[2]);
								$objData[2]=$etiqueta;
								
								
								if(!isset($matrizValoresProcesados[$c[4]]))
									$matrizValoresProcesados[$c[4]]=array();
								$matrizValoresProcesados[$c[4]][$s[4]]=$objData;
									
								$arrMatrizValores[$llave]=array();
								$arrMatrizValores[$llave][0]=$valor;
								$arrMatrizValores[$llave][1]=normalizarValorRGB($fValor[2]);
								$arrMatrizValores[$llave][2]=$etiqueta;
								$llave++;
								$posCategoria++;
								
								
							}
							
							
							$arrTotalSerie[$posSerie]=$total;
							/*if($idCategoriaGrafico==1)
								break;*/
							$posSerie++;
							
							
						}	
						
						$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
						$nombreDataSet=$con->obtenerValor($consulta);
						$nombreDataSet=str_replace(" ","_",$nombreDataSet);
						$etiqueta="<almacen_".$nombreDataSet.">";
						foreach($arrCategorias as $c)
						{
							$etiqueta.="<dataSet_".$c[1].">";
							foreach($arrSeries as $s)
							{
								$etiqueta.="<serie_".$s[1].">".$matrizValoresProcesados[$c[4]][$s[4]][0]."</serie_".$s[1].">";
							}
							$etiqueta.="<dataSet_".$c[1]."/>";
						}
						$etiqueta.="</almacen_".$nombreDataSet.">";
					break;		
				}	
				
				$resultadoGlobal.=$etiqueta."</".$nombreControl.">";
			}
	
			return $resultadoGlobal;
	}
	
	function crearElementosRepetible($idPadre=null,$posZIndex=1,$filaRegistro,$posIncX,$posIncY,$numCt)
	{
	
			global $toWord;
			global $urlSitio;
			global $funcionesJava;
			global $con;
			global $et;
			global $idReporte;
			global $nTabla;
			$nombreTabla=$nTabla;
			global $calibrarCtrl;
			global $cc;
			global $numElementos;
			global $arrElementosFocus;
			global $nElementosFocus;
			global $arrResultConsulta;
			global $toWord;
			global $posX;
			global $posY;
			global $maxPosYHoja;
			global $factorAjuste;
			global $nHojas;
			$cadEtiquetaElementos="";
			$idCtrlPadre="-1";
			$divPadre=0;
			$valorPuro="";
			
			
			
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where 
					tipoElemento not in (1,23) and idPadre=".$idPadre;
	
			$res=$con->obtenerFilas($query);
			$filaE=array();
			while($fElemento=mysql_fetch_row($res))
			{
				$numElementos++;
				$val='';
				$nombreControl=str_replace(".","_",$fElemento[1]);	
				$valorEtiqueta="";
				
				switch($fElemento[2])					
				{
					
					case 25:
						
						$cc++;
						$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE idSeccion=".$fElemento[0]." and principal=1";
						$idAlmacen=$con->obtenerValor($consulta);
						$almacen=$arrResultConsulta[$idAlmacen]["resultado"];
						if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
							mysql_data_seek($almacen,0);
						$cadHijos="";
						$posIncY=0;
						$numCt=1;
						$valorEtiqueta.="<recordDataElement>";
						while($fila=mysql_fetch_assoc($almacen))
						{
							$valorEtiqueta.=crearElementosRepetible($fElemento[0],0,$fila,0,0,$numCt);
							$numCt++;
						}
						$valorEtiqueta.="</recordDataElement>";
						$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE  idSeccion=".$fElemento[0];
						$filasAlmacen=$con->obtenerPrimeraFila($consulta);
						
					break;
					case 26:
						$valorPuro=$filaRegistro[str_replace(".","_",$fElemento[1])];
						
						$valorEtiqueta.="<![CDATA[".cv($valorPuro)."]]>";
					break;
					case 27:
						$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$alto=$filaE[3];
						$vInicial=$filaE[5];
						$vIncremento=$filaE[4];
						$numValor=$vInicial+(($numCt-1)*$vIncremento);
						$valorPuro=$numValor;
						$valorEtiqueta.="<![CDATA[".cv($valorPuro)."]]>";
						$nombreControl="element_".$fElemento[0];	
						
					break;
					case 28: //Calculo
						$anchoAsterisco=1;
						$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tVinculacion=$filaE[9];
						$idAlmacen=$filaE[10];
						$campoRef=$filaE[11];
						$valor="";
						
						switch($tVinculacion)					
						{
							case "1":
							case "2":
								if($arrResultConsulta[$idAlmacen]["ejecutado"]==1)
								{
									if($tVinculacion==2)
										$valor=$arrResultConsulta[$idAlmacen]["resultado"];
									else
									{
										$filaRef=array();
										if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
										{	mysql_data_seek($arrResultConsulta[$idAlmacen]["resultado"],0);
											$filaRef=mysql_fetch_row($arrResultConsulta[$idAlmacen]["resultado"]);
										}
										$fila=convertirFilasAlmacenArrayAsoc($idAlmacen,$filaRef);	
										$valor=$fila[$campoRef];
									}
									
								}
								else
								{
									$consulta=$arrResultConsulta[$idAlmacen]["query"];	
									$paramPendientes=$arrResultConsulta[$idAlmacen]["paramPendientes"];
									foreach($paramPendientes as $param)
									{
										$datosParam=explode("|",$param);
										$consulta=str_replace($datosParam[1],$filaRegistro[$datosParam[0]],$consulta);	
									}
									if((!isset($arrResultConsulta[$idAlmacen]["consultaReferencia"]))||($arrResultConsulta[$idAlmacen]["consultaReferencia"]!=$consulta))
									{
										$filaRegAux=$con->obtenerPrimeraFila($consulta);
										$fila=convertirFilasAlmacenArrayAsoc($idAlmacen,$filaRegAux);
										$arrResultConsulta[$idAlmacen]["consultaReferencia"]=$consulta;
										$arrResultConsulta[$idAlmacen]["arrRegistro"]=$fila;
									}
									else
										$fila=$arrResultConsulta[$idAlmacen]["arrRegistro"];
									
									if(isset($fila[$campoRef]))
										$valor=$fila[$campoRef];
									else
										$valor=$filaRegAux[0];
								}	
								
							break;
						}
						$valorPuro=$valor;
						if($filaE[2]=="")
							$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='height:".$alto."px'>".$valor."</span>";
						else
							$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='width:".$filaE[2]."px; height:".$alto."px; overflow:hidden; display:inline-block'>".$valor."</span>";
					break;
				}
				$cadEtiquetaElementos.="<".$nombreControl.">";	
				$cadEtiquetaElementos.=$valorEtiqueta;		
				$cadEtiquetaElementos.="</".$nombreControl.">";
				
				
			}
	
			return $cadEtiquetaElementos;
	}
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('getInfoThotReporterExport',array('reportID'=>'xsd:string','xmlParams'=>'xsd:string','sistemKey'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);
?>