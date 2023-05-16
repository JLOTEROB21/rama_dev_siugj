<?php session_start();
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
//include("FusionCharts_Gen.php");

$posX=40;
$posY=30;

$ajustePtX=6.3;
$ajustePtY=2.85;
$ajusteAncho=7;
$ajusteAlto=4;
$numElementos=0;
$nHojas=0;
$maxPosYHoja=857;
$minPosYHoja=0;
$factorAjuste=0;

function conversionPxToPt($valor)
{
	return $valor/1.333333;
}

function obtenerCoordenadaXWord($valor)
{
	global $ajustePtX;
	//echo $valor."=".conversionPxToPt($valor)-$ajustePtX."<br>";
	return conversionPxToPt($valor)-$ajustePtX;
}

function obtenerCoordenadaYWord($valor)
{
	global $ajustePtY;
	//echo $valor."=".conversionPxToPt($valor)-$ajustePtY."<br>";
	return conversionPxToPt($valor)-$ajustePtY;
}

function ajustarAnchoWord($valor)
{
	global $ajusteAncho;
	return conversionPxToPt($valor)+$ajusteAncho;
}

function ajustarAltoWord($valor)
{
	global $ajusteAlto;
	return conversionPxToPt($valor)+$ajusteAlto;
}

function obtenerValorParametroThot($parametro)
{
	$valor="";
	if(isset($_POST[$parametro]))
		$valor=$_POST[$parametro];
	else
		if(isset($_GET[$parametro]))
			$valor=$_GET[$parametro];
	return $valor;
}

function crearElementosReporte($idPadre=null,$posZIndex=1)
{
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
		$funcionesJavaInicio.="var color = Chart.helpers.color;var colorNames = Object.keys(window.chartColors);";
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
		$consulta="select idGrupoElemento from 9011_elementosReportesExclusion where idReporte=".$idReporte." and ((usuarioExclusion in (".$idRol.") and tipoUsuario=0) or (usuarioExclusion = (".$idUsr.") and tipoUsuario=1))";
		$listaElemExclusion=$con->obtenerListaValores($consulta);
		if($listaElemExclusion=="")
			$listaElemExclusion="-1";
		
	
		
		if($idPadre!=null)
		{
			$idCtrlPadre=$idPadre;
			$divPadre=$idPadre;
		}
		if($idPadre==null)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where  tipoElemento=1 and idPadre=-1 and idGrupoElemento not in (".
					$listaElemExclusion.") and idReporte=".$idReporte." and idIdioma in(".$_SESSION["leng"].",0)";
		else			
		{
			$query="SELECT posX,posY FROM 9011_elementosReportesThot WHERE idGrupoElemento=".$idPadre;
			$fPadre=$con->obtenerPrimeraFilaAsoc($query);
			
			$posYPadre=$fPadre["posY"];
			$posXPadre=$fPadre["posX"];
			
			$query="select idGrupoElemento,nombreCampo,tipoElemento,(posX-".$posXPadre.")as posX,(posY-".$posYPadre.") as posY,eliminable 
					from 9011_elementosReportesThot where  idGrupoElemento not in (".$listaElemExclusion.") and idReporte=".$idReporte." and tipoElemento=1 and idPadre=".$idPadre." and idIdioma in(".$_SESSION["leng"].",0)";
		}

		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		while($filas=mysql_fetch_row($res))
		{
			$posXElemento=$posX+$filas[3];
			$posYElemento=$posY+$filas[4];
			$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$filas[0];

			$filaE=$con->obtenerPrimeraFila($consulta);
			
			$colorFondo=$filaE[14];
			if($filaE[3]!="")
			{
				if(strpos($filaE[3],"{")!==false)
				{
					$obj=json_decode($filaE[3]);
					if(isset($obj->formula))
					{
						$formula="";
						foreach($obj->formula as $t)
						{
							$valor=$t->toke;
							if(strpos($valor,"[")!==false)
							{
								$valor=str_replace("[","",$valor);
								$valor=str_replace("]","",$valor);
								$valor=$arrResultConsulta[$valor]["resultado"];
							}
							if($formula=="")
								$formula=$valor;
							else	
								$formula.=$valor;
						}
						eval('$filas[1]='.$formula.';');

						
					}
				}
			}
			if($filaE[2]=="")
				$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$filas[0]."' name='_lbl".$filas[0]."'>".$filas[1]."</span>";
			else
				$etiqueta="<span  funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$filas[0]."' style='width:".$filaE[2]."px; overflow:hidden; display:inline-block' name='_lbl".$filas[0]."'>".$filas[1]."</span>";
			
			if($filaE[14]!="")
			{
				$funcionesJavaInicio.="asignarValorFormatoRenderer('".$filaE[14]."',-1,'_lbl".$filas[0]."',".$filas[0].");";
			}
			
			$btnEliminar="";
			$tabla=	 "	<table class='tablaControl'>
    						<tr>
                    			<td id='td_".$filas[0]."'>".$etiqueta;
			$columnas="";
			$ancho=105;
			mysql_data_seek($res5,0);
			while($fila5=mysql_fetch_row($res5))
			{		
			
				$queryAux10="select nombreCampo from 9011_elementosReportesThot where idGrupoElemento=".$filas[0]." and idIdioma=".$fila5[0];
				$valorEt=$con->obtenerValor($queryAux10);

			}
								
			$tabla.=	"</td><td valign='top'>".$btnEliminar."	</td>
                    		</tr>
    					</table>";
			if(!$toWord)			
				$div="<div id='div_".$filas[0]."' style='top:".$posYElemento."px; left:".$posXElemento."px; position:absolute; background-color:".$colorFondo.";'>".$tabla."</div>";			
			else
			{
				$comp="";
				if($filaE[2]!="")
					$comp.='width:'.$ajustarAnchoWord($filaE[2]).'pt;';
				$div='<v:shape id="et'.$filas[0].'" o:spid="et'.$filas[0].'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($filas[3]).'pt;margin-top:'.obtenerCoordenadaYWord($filas[4]).'pt;
																														'.$comp.'z-index:251659264;visibility:visible;
                                                                                                                         mso-wrap-style:none;mso-width-percent:0;mso-height-percent:0;
                                                                                                                         mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
                                                                                                                         mso-wrap-distance-bottom:0;mso-position-horizontal:absolute;
                                                                                                                         mso-position-horizontal-relative:text;mso-position-vertical:absolute;
                                                                                                                         mso-position-vertical-relative:text;mso-width-percent:0;mso-height-percent:0;
                                                                                                                         mso-width-relative:page;mso-height-relative:margin;v-text-anchor:top\'>
					</v:shape>
					<div v:shape="et'.$filas[0].'" class=shape>
						<span class="'.$filaE[13].'">'.$filas[1].'</span>
					</div>
						
					';
			}
			echo $div;
			
		}
		$etiqueta="";
		
		// idGrupoElemento=321 and
		if($idPadre==null)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where  idPadre=-1 and idGrupoElemento not in (".$listaElemExclusion.
					") and idReporte=".$idReporte." and tipoElemento not in (1) and idReporte=".$idReporte."";
		else
		{
			$query="SELECT posX,posY FROM 9011_elementosReportesThot WHERE idGrupoElemento=".$idPadre;
			$fPadre=$con->obtenerPrimeraFilaAsoc($query);
			
			$posYPadre=$fPadre["posY"];
			$posXPadre=$fPadre["posX"];
			$query="select idGrupoElemento,nombreCampo,tipoElemento,(posX-".$posXPadre.") as posX,(posY-".$posYPadre.") as posY,eliminable from 9011_elementosReportesThot where tipoElemento not in 
					(1) and idGrupoElemento not in (".$listaElemExclusion.") and idReporte=".$idReporte." and idPadre=".$idPadre;
		}

		$res=$con->obtenerFilas($query);
		$filaE=array();
		while($fElemento=mysql_fetch_row($res))
		{
			$posXElemento=$posX+$fElemento[3];
			$posYElemento=$posY+$fElemento[4];
			$numElementos++;
			$ignorarLimites="";
			if($fElemento["5"]=="1")
				$mostrarEliminar=true;
			else
				$mostrarEliminar=false;
			
			$val='';
			$asteriscoRojo='';
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);	
			$habilitado="";
			$anchoAsterisco="1";
			if($asteriscoRojo!="")
				$anchoAsterisco=10;
			switch($fElemento[2])					
			{
				case 23: //Imagen
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<img src='@url/media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";
					
				break;
				case 25:
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$anchoTabla=$filaE[2];
					$altoTabla=$filaE[3];
					$colorFondo1=$filaE[14];
					$colorFondo2=$filaE[13];
					$colorBackGround=$colorFondo1;

					$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE idSeccion=".$fElemento[0]." and principal=1";
					$idAlmacen=$con->obtenerValor($consulta);
					$almacen=$arrResultConsulta[$idAlmacen]["resultado"];
					$conAux=NULL;
					if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
					{
						$conAux=$arrResultConsulta[$idAlmacen]["conector"];
						$conAux->inicializarRecurso($almacen);
					}

					$altoFila=$filaE[3];
					$cadHijos="";
					$posIncY=0;
					$numCt=1;
					$fila=array();
					while($fila=$conAux->obtenerSiguienteFilaAsoc($almacen))
					{
						
						$cadHijos="";
						$cadHijos=crearElementosRepetible($fElemento[0],($posZIndex+1),$fila,$posXElemento,($posYElemento+$posIncY),$numCt);
						
						$etiqueta= "<table  style='width:".$anchoTabla."px' id='_secc".$fElemento[0]."'>
											<tr style='height:".$altoTabla."px' id='filaPrincipal_".$fElemento[0]."'>
											<td>
											</td>
											</tr>
										</table>
									";
						$tabla=	 "	<table class='tablaControl'>
									<tr >
										<td width='".$anchoAsterisco."'>".$asteriscoRojo."</td>
										<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
									</tr>
								</table>";
					
						$div="	<div style='z-Index:".$posZIndex.";
									top:".($posYElemento+$posIncY)."px; left:".$posXElemento."px; position:absolute;background-color:".
									$colorBackGround.";border-style:solid; border-color:#FFF; border-width:1px; height:".$altoFila."px;'>".$tabla."</div>";							
						if(!$toWord)
						{
							echo $div;
							echo $cadHijos;
						}
						$numCt++;
						$posIncY+=$altoFila;
						if($colorBackGround==$colorFondo1)
							$colorBackGround=$colorFondo2;
						else
							$colorBackGround=$colorFondo1;
					}
				break;
				case 28:
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
				case 31:
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$ancho=$filaE[2];
					$alto=$filaE[3];
					$tipoGrafico=$filaE[4];
					
					$objTipoGrafico="";
					$optionAxes="";
					$stackedX="false";
					$stackedY="false";
					switch($tipoGrafico)
					{
						case "1":
							$objTipoGrafico="pie";
						break;
						case "2":
							$objTipoGrafico="doughnut";
						break;
						case "6":
							$objTipoGrafico="bar";
						break;
						case "7":
							$objTipoGrafico="bar";
							$optionAxes="indexAxis: 'y',";
						break;
						case "9":
							$objTipoGrafico="line";
						break;
						case "10":
							$objTipoGrafico="bar";
							$stackedX="true";
							$stackedY="true";
						break;
						case "12":
							$objTipoGrafico="bar";
							$stackedX="true";
							$stackedY="true";
							$optionAxes="indexAxis: 'y',";
						break;
					}
					
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
					
					//varDUmp($matrizValoresProcesados);
					//varDUmp($totalSerieProcesado);
					$llave=0;
					$posSerie=0;
					$nSeries=sizeof($arrSeries);
					
					$totalAcumulado=0;
					$nCategorias=sizeof($arrCategorias);
					$posCategoria=0;
					$totalAcumuladoCategoria=array();
					
					$etiquetasDataSet="";
					
					foreach($arrSeries as $s)
					{
						if($etiquetasDataSet=="")
							$etiquetasDataSet="'".cv($s[1])."'";
						else
							$etiquetasDataSet.=",'".cv($s[1])."'";
						
					}
					$arrDatasets="";
					foreach($arrCategorias as $c)
					{
						$arrDatos="";
						$arrColores="";
						foreach($arrSeries as $s)
						{
							$valor="'".$matrizValoresProcesados[$c[4]][$s[4]][0]."'";
							if($arrDatos=="")
								$arrDatos=$valor;
							else
								$arrDatos.=",".$valor;
								
							if($arrColores=="")
								$arrColores="color('#".$s[2]."').alpha(0.8).rgbString()";
							else
								$arrColores.=",color('#".$s[2]."').alpha(0.8).rgbString()";
							
								
						}
						$dataSet="
									{
										label: '".cv($c[1])."',
										backgroundColor: [".$arrColores."],
										borderColor: '#".$c[2]."',
										borderWidth: 1,
										data: 	[".$arrDatos."]
									}";
									

						if($arrDatasets=="")
							$arrDatasets=$dataSet;
						else
							$arrDatasets.=",".$dataSet;
					

					}
					
					
					
					$confDataChar=" 
									var chartData_".$fElemento[0]." = {
																		labels: [".$etiquetasDataSet."],
																		datasets: [".$arrDatasets."]
															
																	};
																	
																	
									var ctx = document.getElementById('canvasChar_".$fElemento[0]."').getContext('2d');
									window.myHorizontalBar = new Chart(ctx, {
																			type: '".$objTipoGrafico."',
																			data: chartData_".$fElemento[0].",
																			plugins: [ChartDataLabels],
																			options: {
																						".$optionAxes."
																						elements: {
								                                                        				bar: {
																												borderWidth: 2,
																											}
																									},
																						responsive: true,
																						legend: {
																									position: 'bottom'
																								},
																						title: {
																									display: true,
																									fontSize:14,
																									text: '".cv($objConf->caption)."'
																								}
																					}
																		}
																	);
					
																	
																	
																	";
					

					
					$funcionesJavaInicio.=$confDataChar;
					$etiqueta="<canvas style='width:".$filaE[2]."px; height: ".$filaE[3]."px;' id='canvasChar_".$fElemento[0]."'></canvas>";
					/*foreach($arrSeries as $s)
					{
						$totalAcumulado=0;
						
						if($etiquetasDataSet=="")
							$etiquetasDataSet="'".cv($s[1])."'";
						else
							$etiquetasDataSet.=",'".cv($s[1])."'";
						
						$posCategoria=0;
						
						foreach($arrCategorias as $c)
						{
							
							$objData=$matrizValoresProcesados[$c[4]][$s[4]];
							
							$valor=$objData[0];
							$color=$objData[1];
							$etiqueta=$objData[2];
							$llave++;
							if($convertirProcentajes)
							{
								if(!isset($totalAcumuladoCategoria[$posCategoria]))
									$totalAcumuladoCategoria[$posCategoria]=0;
								if($objConf->convertirPorcentaje==1)
								{
									if($posCategoria==$nCategorias-1)
									{
										$valor=(100-$totalAcumulado);
										$valor=str_replace(",","",number_format($valor,$decimalPrecision));
									}
									else
									{
										if($arrTotalSerie[$posSerie]!=0)
										{
											$valor=($valor/$arrTotalSerie[$posSerie])*100;
											$valor=str_replace(",","",number_format($valor,$decimalPrecision));
											if(($totalAcumulado+$valor)>100)
											{
												$valor=($totalAcumulado+$valor)-100;
												$valor=str_replace(",","",number_format($valor,$decimalPrecision));
											}
												
										}
										else
											$valor=0;
									}
								}
								else
								{	
									
									if($posSerie==$nSeries-1)
									{
										$valor=(100-$totalAcumuladoCategoria[$posCategoria]);
										$valor=str_replace(",","",number_format($valor,$decimalPrecision));
									}
									else
									{
										if($arrTotalCategoria[$posCategoria]!=0)
										{
											$valor=($valor/$arrTotalCategoria[$posCategoria])*100;
											$valor=str_replace(",","",number_format($valor,$decimalPrecision));
											if(($totalAcumuladoCategoria[$posCategoria]+$valor)>100)
											{
												$valor=($totalAcumuladoCategoria[$posCategoria]+$valor)-100;
												$valor=str_replace(",","",number_format($valor,$decimalPrecision));
											}
												
										}
										else
											$valor=0;
									}
								}
								$totalAcumulado+=$valor;
								$totalAcumuladoCategoria[$posCategoria]+=$valor;
							}
							$posCategoria++;
							
							$displayValue=$sufijo.$valor.$prefijo.$comp;
							switch($formatoValoresMostrar)
							{
								case 0:
									$displayValue="";
								break;
								case 1:
									$comp2="";
									if($etiqueta!="")
										$comp2=", ".$etiqueta;
									$displayValue=$sufijo.$valor.$prefijo.$comp2.$comp;
								break;
								case 2:
									$comp2="";
									if($etiqueta!="")
										$comp2=", ".$etiqueta;
									$displayValue=$sufijo.$valor.$prefijo.$comp;
								break;
								case 3:
									$comp2="";
									if($etiqueta!="")
										$comp2=$etiqueta;
									$displayValue=$comp2.$comp;
								break;
								
							}
							
							$grafica->addChartData($valor,"displayValue=".$displayValue);
						}
						
						
						if($idCategoriaGrafico==1)
							break;
						$posSerie++;
						
					}*/
				break;		
			}	
			$colorFondo=$filaE[14];			
			$btnEliminar="";
			$ayuda="";
			
			if($toWord)
			{
				switch($fElemento[2])
				{
					case 23:
						$ancho=conversionPxToPt($filaE[2]);
						$alto=conversionPxToPt($filaE[3]);
						$etiqueta=str_replace("@url",$urlSitio,$etiqueta);
						$valor=$etiqueta;
						$comp="";
						if($filaE[2]!="")
							$comp.='width:'.ajustarAnchoWord($filaE[2]).'pt;';
						$div='<v:shape id="et'.$fElemento[0].'" o:spid="et'.$fElemento[0].'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($fElemento[3]).'pt;margin-top:'.obtenerCoordenadaYWord($fElemento[4]).'pt;
																																'.$comp.'z-index:251659264;visibility:visible;width:'.$ancho.'pt;height:'.$alto.'pt\'>
								<v:imagedata src="'.$urlSitio.'/media/mostrarImgFrm.php?id='.base64_encode($filaE[4]).'" o:title=""/>
							</v:shape>
							
								
							';
							
													/*	<div v:shape="et'.$fElemento[0].'" class=shape>
								<span class="'.$filaE[13].'">'.$valor.'</span>
							</div>*/

						echo $div;
					break;
					case 28:
						$comp="";
						if($filaE[2]!="")
							$comp.='width:'.ajustarAnchoWord($filaE[2]).'pt;';
						$div='<v:shape id="et'.$fElemento[0].'" o:spid="et'.$fElemento[0].'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($fElemento[3]).'pt;margin-top:'.obtenerCoordenadaYWord($fElemento[4]).'pt;
																																'.$comp.'z-index:251659264;visibility:visible;
																																 mso-wrap-style:none;mso-width-percent:0;mso-height-percent:0;
																																 mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
																																 mso-wrap-distance-bottom:0;mso-position-horizontal:absolute;
																																 mso-position-horizontal-relative:text;mso-position-vertical:absolute;
																																 mso-position-vertical-relative:text;mso-width-percent:0;mso-height-percent:0;
																																 mso-width-relative:page;mso-height-relative:margin;v-text-anchor:top\'>
							</v:shape>
							<div v:shape="et'.$fElemento[0].'" class=shape>
								<span class="'.$filaE[13].'">'.$valor.'</span>
							</div>
								
							';
						echo $div;
					break;
				}
			}
			else
			{
				$etiqueta=str_replace("@url","..",$etiqueta);
				switch($fElemento[2])
				{
					case 31:
						
						if($maxValorY==0)
							$maxValorY=6;
						$strParam=str_replace("@maxY",($maxValorY*1.40),$strParam);
						
						$tabla=	 "	<table class='tablaControl'>
										<tr >
											<td width='".$anchoAsterisco."'>".$asteriscoRojo."
											<div id='fcDiv_".$fElemento[0]."' align='center'></div>
											
											</td>
											<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
										</tr>
									</table>";
						/*if($fElemento[0]!=530)*/
						if(((isset($_SESSION["debuggerCalculos"]))&&($_SESSION["debuggerCalculos"]==1))||((isset($_SESSION["debuggerQueries"]))&&($_SESSION["debuggerQueries"]==1))||((isset($_SESSION["debuggerBloque"]))&&($_SESSION["debuggerBloque"]==1))||((isset($_SESSION["debuggerConsulta"]))&&($_SESSION["debuggerConsulta"]==1)))
							$tabla="";
						$div="	<div style='z-Index:".$posZIndex.";
									top:".$posYElemento."px; left:".$posXElemento."px; position:absolute;background-color:".$colorFondo.";'>".$tabla."</div>";							
						echo $div;
					break;
					
					
					default:
						
						$tabla="	<table class='tablaControl'>
										<tr >
											<td width='".$anchoAsterisco."'>".$asteriscoRojo."</td>
											<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
										</tr>
									</table>";
						
						$div="	<div style='z-Index:".$posZIndex.";
									top:".$posYElemento."px; left:".$posXElemento."px; position:absolute;background-color:".$colorFondo.";'>".$tabla."</div>";							
						if($fElemento[0]==95)
							echo $div;
					break;
				}
			}
		}
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
		
		$query="SELECT posX,posY FROM 9011_elementosReportesThot WHERE idGrupoElemento=".$idPadre;
		$fPadre=$con->obtenerPrimeraFilaAsoc($query);
		
		$posYPadre=$fPadre["posY"];
		$posXPadre=$fPadre["posX"];
		$query="select idGrupoElemento,nombreCampo,tipoElemento,(posX-".$posXPadre.") as posX,(posY-".$posYPadre.") as posY,eliminable from 9011_elementosReportesThot where tipoElemento=1 and idPadre=".$idPadre." and idIdioma in(".$_SESSION["leng"].",0)";
		
		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		while($filas=mysql_fetch_row($res))
		{
			$alto="";
			$numElementos++;
			$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$filas[0];
			$filaE=$con->obtenerPrimeraFila($consulta);
			$colorFondo=$filaE[14];
			if($filaE[2]=="")
				$etiqueta="<span class='".$filaE[13]."' id='_lbl".$filas[0]."'>".$filas[1]."</span>";
			else
				$etiqueta="<span class='".$filaE[13]."' id='_lbl".$filas[0]."' style='width:".$filaE[2]."px; overflow:hidden; display:inline-block'>".$filas[1]."</span>";
			$btnEliminar="";
			$tabla=	 "	<table class='tablaControl'>
    						<tr>
                    			<td id='td_".$filas[0]."'>".$etiqueta;
			$columnas="";
			$ancho=105;
			mysql_data_seek($res5,0);
			while($fila5=mysql_fetch_row($res5))
			{		
				$queryAux10="select nombreCampo from 9011_elementosReportesThot where idGrupoElemento=".$filas[0]." and idIdioma=".$fila5[0];
				$valorEt=$con->obtenerValor($queryAux10);
				
			}
			$tabla.=	"</td><td valign='top'>".$btnEliminar."	</td>
                    		</tr>
    					</table>";
			if(!$toWord)			
				$div="<div id='div_".$filas[0]."' style='top:".($filas[4]+$posIncY)."px; left:".($filas[3]+$posIncX)."px; position:absolute; background-color:".$colorFondo.";'>".$tabla."</div>";			
			else
			{
				$comp="";
				if($filaE[2]!="")
					$comp.='width:'.ajustarAnchoWord($filaE[2]).'pt;';
				if($alto=="")
					$alto=25;
					
				$comp.='height:'.ajustarAltoWord($alto).'pt;';
				
				$posYElemento=$filas[4]+$posIncY-$posY-$factorAjuste;
				if($posYElemento>$maxPosYHoja)
				{
					echo "<br clear=all style='mso-special-character:line-break;page-break-before:always'>";
					$factorAjuste+=$posYElemento;
					$posYElemento=$posYElemento-$factorAjuste;
					$nHojas++;
				}
				$div='<v:shape id="et'.$filas[0]."_".$numElementos.'" o:spid="et'.$filas[0]."_".$numElementos.'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($filas[3]+$posIncX-$posX).'pt;margin-top:'.obtenerCoordenadaYWord($posYElemento).'pt;
																														'.$comp.'z-index:251659264;visibility:visible;
                                                                                                                         mso-wrap-style:none;mso-width-percent:0;mso-height-percent:0;
                                                                                                                         mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
                                                                                                                         mso-wrap-distance-bottom:0;mso-position-horizontal:absolute;
                                                                                                                         mso-position-horizontal-relative:text;mso-position-vertical:absolute;
                                                                                                                         mso-position-vertical-relative:text;mso-width-percent:0;mso-height-percent:0;
                                                                                                                         mso-width-relative:page;mso-height-relative:margin;v-text-anchor:top\'>
					</v:shape>
					<div v:shape="et'.$filas[0]."_".$numElementos.'" class=shape>
						<span class="'.$filaE[13].'">'.$filas[1].'</span>
					</div>
						
					';
			}
			
			echo $div;
			$cc++;
		}
		
		
		$query="SELECT posX,posY FROM 9011_elementosReportesThot WHERE idGrupoElemento=".$idPadre;
		$fPadre=$con->obtenerPrimeraFilaAsoc($query);
		
		$posYPadre=$fPadre["posY"];
		$posXPadre=$fPadre["posX"];
		
		$query="select idGrupoElemento,nombreCampo,tipoElemento,(posX-".$posXPadre.") as posX,(posY-".$posYPadre.") as posY,eliminable from 9011_elementosReportesThot where tipoElemento not in (1) and idPadre=".$idPadre;
		$res=$con->obtenerFilas($query);
		$filaE=array();
		while($fElemento=mysql_fetch_row($res))
		{
			$numElementos++;
			$ignorarLimites="";
			if($fElemento["5"]=="1")
				$mostrarEliminar=true;
			else
				$mostrarEliminar=false;
			
			$val='';
			$asteriscoRojo='';
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);	
			$habilitado="";
			$anchoAsterisco="1";
			if($asteriscoRojo!="")
				$anchoAsterisco=10;
			$alto="";
			switch($fElemento[2])					
			{
				
				case 23: //Imagen
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."_".$posIncY."'>";
					$valorPuro="src='".$urlSitio."/media/mostrarImgFrm.php?id=".base64_encode($filaE[4]);		
				break;
				case 25:
				
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$anchoTabla=$filaE[2];
					$altoTabla=$filaE[3];
					$calibrarCtrl.="calibrarCtrl[".$cc."]='div_".$fElemento[0]."';";
					$cc++;
					$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE idSeccion=".$fElemento[0]." and principal=1";
					$idAlmacen=$con->obtenerValor($consulta);
					$almacen=$arrResultConsulta[$idAlmacen]["resultado"];
					if($arrResultConsulta[$idAlmacen]["filasAfectadas"]>0)
						mysql_data_seek($almacen,0);
					$altoFila=$filaE[3];
					$cadHijos="";
					$posIncY=0;
					$numCt=1;
					while($fila=mysql_fetch_assoc($almacen))
					{
						$cadHijos.=crearElementosRepetible($fElemento[0],($posZIndex+1),$fila,$posXElemento,($posYElemento+$posIncY),$numCt);
						$posIncY+=$altoFila;
						$numCt++;
					}
					$etiqueta= "<table  style='width:".$anchoTabla."px' id='_secc".$fElemento[0]."'>
										<tr style='height:".$altoTabla."px' id='filaPrincipal_".$fElemento[0]."'>
										<td>
										</td>
										</tr>
									</table>
								";
					$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE  idSeccion=".$fElemento[0];
					$filasAlmacen=$con->obtenerPrimeraFila($consulta);
					$attComp="almacenVinculado='0'";
					if($filasAlmacen)
						$attComp="almacenVinculado='1'";
					echo $cadHijos;
				break;
				case 26:
					
					$anchoAsterisco=1;
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$alto=$filaE[3];
					$valorPuro=$filaRegistro[str_replace(".","_",$fElemento[1])];
					if($filaE[2]=="")
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='height:".$alto."px'>".$valorPuro."</span>";
					else
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='width:".$filaE[2]."px; height:".$alto."px; overflow:hidden; display:inline-block'>".$valorPuro."</span>";
					
				break;
				case 27:
					$anchoAsterisco=1;
					$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$alto=$filaE[3];
					$vInicial=$filaE[5];
					$vIncremento=$filaE[4];
					$numValor=$vInicial+(($numCt-1)*$vIncremento);
					if($filaE[2]=="")
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='height:".$alto."px'>".$numValor."</span>";
					else
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."_".$posIncY."' style='width:".$filaE[2]."px; height:".$alto."px; overflow:hidden; display:inline-block'>".$numValor."</span>";
					$valorPuro=$numValor;
				break;
				case 28:
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
			$colorFondo=$filaE[14];		
			$btnEliminar="";
			$ayuda="";
			
			$tabla=	 "	<table class='tablaControl'>
    						<tr >
								<td width='".$anchoAsterisco."'>".$asteriscoRojo."</td>
                    			<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
							</tr>
    					</table>";
			
			if($toWord)
			{
				
				$posYElemento=$fElemento[4]+$posIncY-$posY-$factorAjuste;
				if($posYElemento>$maxPosYHoja)
				{
					echo "<br clear=all style='mso-special-character:line-break;page-break-before:always'>";
					$factorAjuste+=$posYElemento;
					$posYElemento=$posYElemento-$factorAjuste;
					$nHojas++;
				}
				
				
				switch($fElemento[2])
				{
					case 23:
						$ancho=conversionPxToPt($filaE[2]);
						$alto=conversionPxToPt($filaE[3]);
						$div='<v:shape id="et'.$fElemento[0].'_'.$numElementos.'" o:spid="et'.$fElemento[0].'_'.$numElementos.'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($fElemento[3]+$posIncX-$posX).'pt;margin-top:'.obtenerCoordenadaYWord($posYElemento).'pt;
																																'.$comp.'z-index:251659264;visibility:visible;width:'.$ancho.'pt;height:'.$alto.'pt\'>
								<v:imagedata src="'.$urlSitio.'/media/mostrarImgFrm.php?id='.base64_encode($filaE[4]).'" o:title=""/>
							</v:shape>';
						echo $div;
					break;
					default:
						$comp="";
						if($filaE[2]!="")
							$comp.='width:'.ajustarAnchoWord($filaE[2]).'pt;';
						if($alto=="")
							$alto=25;
						$comp.='height:'.ajustarAltoWord($alto).'pt;';
						$div='<v:shape id="et'.$fElemento[0]."_".$numElementos.'" o:spid="et'.$fElemento[0]."_".$numElementos.'" type="#_x0000_t202" filled="f" stroked="f" style=\'position:absolute;margin-left:'.obtenerCoordenadaXWord($fElemento[3]+$posIncX-$posX).'pt;margin-top:'.obtenerCoordenadaYWord($posYElemento).'pt;
																																'.$comp.'z-index:251659264;visibility:visible;
																																 mso-wrap-style:none;mso-width-percent:0;mso-height-percent:0;
																																 mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
																																 mso-wrap-distance-bottom:0;mso-position-horizontal:absolute;
																																 mso-position-horizontal-relative:text;mso-position-vertical:absolute;
																																 mso-position-vertical-relative:text;mso-width-percent:0;mso-height-percent:0;
																																 mso-width-relative:page;mso-height-relative:margin;v-text-anchor:top\'>
							</v:shape>
							<div v:shape="et'.$fElemento[0]."_".$numElementos.'" class=shape>
								<span class="'.$filaE[13].'">'.$valorPuro.'</span>
							</div>
							';
						echo $div;
						$div="";
					break;
				}
			}
			else
			{
				$div="	<div style='z-Index:".$posZIndex.";top:".($fElemento[4]+$posIncY)."px; left:".($fElemento[3]+$posIncX)."px; position:absolute;background-color:".$colorFondo.";'>".$tabla."</div>";
			}
			/*if($fElemento[2]!=26)
			{
				$div="	<div 
						style='z-Index:".$posZIndex.";top:".($fElemento[4]+$posIncY)."px; left:".($fElemento[3]+$posIncX)."px; position:absolute;background-color:".$colorFondo.";'>".$tabla."</div>";			
			}
			else
			{
				$div="	<div  
						style='z-Index:".$posZIndex.";top:".($fElemento[4]+$posIncY)."px; left:".($fElemento[3]+$posIncX)."px; position:absolute;background-color:".$colorFondo.";'>".$tabla."</div>";							
			}*/
			
			
			if($idPadre==null)
				echo $div;
			else
				$cadEtiquetaElementos.=$div;
			
		}
		return $cadEtiquetaElementos;
}


$toWord=false;
if((isset($_POST["pWord"]))||(isset($_GET["pWord"])))
{
	header('Content-type: application/vnd.ms-word');
	header("Content-Disposition: attachment; filename=reporte_".date("Y_m_d").".doc");
	header("Pragma: no-cache");
	header("Expires: 0");
	header('charset=utf-8');
	$toWord=true;
	
	$paramPOST=true;
	$paramGET=true;
	$arrPOST=array_values($_POST);
	$ctPOST=sizeof($arrPOST);
	$arrGET=array_values($_GET);
	$ctGET=sizeof($arrGET);
	$arrValores=null;
	$arrLlaves=null;
	$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina FROM 4081_colorEstilo";
	$unico= $con->obtenerPrimeraFila($sqlmax);
	$banner=$unico[0];
	$textoInfIzq=$unico[1];
	$textoInfDer=$unico[2];
	$tituloPagina=$unico[3];
	$nomPagina=$_SERVER["PHP_SELF"];
	$arrPagina=	explode("/",$nomPagina);
	$nElementos=sizeof($arrPagina);
	$nomPagina=$arrPagina[$nElementos-1];
	$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
	$arrPagina=explode(".",$nomPagina);
	$nomPagina=$arrPagina[0];
	$guardarConfSession=true;
	$pagRegresar="../principal/inicio.php";
	if(($paramPOST)&&($ctPOST>0))
	{
		$arrLlaves=array_keys($_POST);
		$arrValores=array_values($_POST);
	}
	else
	{
		if(($paramGET)&&($ctGET>0))
		{
			$arrLlaves=array_keys($_GET);
			$arrValores=array_values($_GET);
		}
	}
	
	$ctParams=sizeof($arrLlaves);
	
	$parametros='';
	for($x=0;$x<$ctParams;$x++)
	{
		if($parametros=='')
		{
		  $parametros='"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';
		}
		else
		{
		  $parametros.=',"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';	
		}
	}
	if($parametros!='')
		$parametros.=',"paginaConf":"../'.$rutaNomPagina.'"';
	else
		$parametros.='"paginaConf":"../'.$rutaNomPagina.'"';
	$parametros='{'.$parametros.'}';
	$objParametros=json_decode($parametros);
	
	
	$idReporte="-1";
	if(isset($objParametros->r))
		$idReporte=bD($objParametros->r);
	$consulta="select ancho,alto from 9010_reportesThot where idReporte=".$idReporte;

	$filaGrid=$con->obtenerPrimeraFila($consulta);
	$anchoGrid=$filaGrid[0];
	$altoGrid=$filaGrid[1];
	$cc=0;
	$calibrarCtrl="var calibrarCtrl=new Array();";
	
	$consulta="SELECT parametro FROM 9015_parametrosReporte WHERE idReporte=".$idReporte;
	$resParam=$con->obtenerFilas($consulta);
	$arrValorParamReporte="";
	while($filaParam=mysql_fetch_row($resParam))
	{
		$vParam="";
		$exp='if(isset($objParametros->'.$filaParam[0].'))
				$vParam=$objParametros->'.$filaParam[0].';';
		eval($exp);

		
		if($arrValorParamReporte=="")
			$arrValorParamReporte='"p'.$filaParam[0].'":"'.$vParam.'"';
		else
			$arrValorParamReporte.=',"p'.$filaParam[0].'":"'.$vParam.'"';
			
	}
	$cadObj='{"p2":{'.$arrValorParamReporte.'}}';
	$paramObj=json_decode($cadObj);
//								varDump($paramObj);
	$arrResultConsulta=resolverQueries($idReporte,1,$paramObj);
	
?>
	<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 14">
<meta name=Originator content="Microsoft Word 14">
<style>

 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520092929 1073786111 9 0 415 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-fareast-language:EN-US;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-fareast-language:EN-US;}
@page WordSection1
	{size:612.0pt 792.0pt;
	margin:70.85pt 3.0cm 70.85pt 3.0cm;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
<?php
	$query="select idEstilo,nombreEstilo from 932_estilos";
	$res=$con->obtenerFilas($query);
	while($fila=mysql_fetch_row($res))
	{
		$obj=".".$fila[1]."{";
		$query="select propiedadCss,valor from 933_elementosEstilo where idEstilo=".$fila[0];
		$resEst=$con->obtenerFilas($query);
		while($filaEst=mysql_fetch_row($resEst))
		{
			$obj.=$filaEst[0].":".$filaEst[1].";";
		}
		$obj.="}";
		echo $obj;
	}
?>
</style>
</head>

<body lang=ES-MX style='tab-interval:35.4pt'>
	<?php
    	echo crearElementosReporte();
    ?>
        	
</body>
</html>
<?php	
	return;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<style>
<?php
	generarFuentesLetras();
?>

	body
    {
		min-height:450px;
    	
    }
</style>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="description" content=""/>
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<?php
if(!isset($excluirExt))
{
?>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<?php
}
?>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesGenerales.js"></script>


<?php 
$idEstiloMenu=0;
$procesoName="";
$mostrarRegresar=true;
$ocultarRegresar=!$mostrarOpcionRegresar;
$soloContenido=false;
$mostrarRegresarBajo=false;
$mostrarMenuNivel1=true;
$mostrarMenuNivel2=true;
$mostrarMenuIzq=false;
$mostrarTitulo=true;
$respetarEspacioRegresar=false;
$tamColumIzq="210";
$mostrarUsuario=true;
$mostrarPiePag=true;
$ocultarFormulariosEnvio=false;
$paginaDestino="";

$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,Menu,txTabla3,txTabla4,TiTabla FROM 4081_colorEstilo";
$unico= $con->obtenerPrimeraFila($sqlmax);
$banner=$unico[0];
$textoInfIzq=$unico[1];
$textoInfDer=$unico[2];
$tituloPagina=$unico[3];
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
$arrPagina=explode(".",$nomPagina);
$nomPagina=$arrPagina[0];
$paramPOST=true;
$paramGET=false;
$guardarConfSession=false;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$txMenuIncluye="";
$mostrarBotonesControlSistema=false;
$tituloModulo="";
?>

<!-- InstanceBeginEditable name="EditRegion5" -->
<?php
$paramGET=true;
$mostrarMenuIzq=false;
$mostrarRegresar=false;
$consulta="SELECT DISTINCT archivoJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
$resScript=$con->obtenerFilas($consulta);
while($fScript=mysql_fetch_row($resScript))
{
	echo '<script type="text/javascript" src="'.$fScript[0].'"></script>';
}

?>
<script src="../Scripts/ChartsJS/Chart.min.js"></script>
<script src="../Scripts/ChartsJS/utils.js"></script>
<script src="../Scripts/ChartsJS/chartjs-plugin-datalabels.min.js"></script>

<script type="text/javascript" src="../Scripts/base64.js"></script>

<!-- InstanceEndEditable -->

<?php



$arrValores=null;
$arrLlaves=null;
$nConfiguracion="-1";
if(($paramPOST)&&($ctPOST>0))
{
	$arrLlaves=array_keys($_POST);
	$arrValores=array_values($_POST);
}
else
{
	if(($paramGET)&&($ctGET>0))
	{
		$arrLlaves=array_keys($_GET);
		$arrValores=array_values($_GET);
	}
}


$ctParams=sizeof($arrLlaves);
$parametros='';
for($x=0;$x<$ctParams;$x++)
{
	if(gettype($arrValores[$x])=='array')
	{
		$cadAux="";
		foreach($arrValores[$x] as $v)
		{
			if($cadAux=="")
				$cadAux="'".$v."'";
			else
				$cadAux.=",'".$v."'";
		}
		$arrValores[$x]=$cadAux;
	}
	if($parametros=='')
	{
	  $parametros='"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';
	}
	else
	{
	  $parametros.=',"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';	
	}
}
if($parametros!='')
	$parametros.=',"paginaConf":"../'.$rutaNomPagina.'"';
else
	$parametros.='"paginaConf":"../'.$rutaNomPagina.'"';
$parametros='{'.$parametros.'}';
$objParametros=json_decode($parametros);
$pConfRegresar="";
$nConfRegresar="";


?>
<!-- InstanceBeginEditable name="doctitle" -->

<!-- InstanceEndEditable -->
<?php
if($guardarConfSession)
{
	if(isset($objParametros->configuracion))
	{
		$nConfiguracion=$objParametros->configuracion;
		$parametros=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];			
		$objParametros=json_decode($parametros);
		if(isset($objParametros->confReferencia))
		{
			if(isset($_SESSION["configuracionesPag"][$objParametros->confReferencia]))
			{
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
			//eliminarReferencia($nConfiguracion);
		}
	}
	else
	{
		if(isset($_SESSION["configuracionesPag"]))
		{
			$nConfiguracion=sizeof($_SESSION["configuracionesPag"])-1;
			
			$ultimaConf=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];
			if($ultimaConf!=$parametros)
				$nConfiguracion++;
		}
		else
			$nConfiguracion=0;
		$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"]=$parametros;
		$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;
		if(isset($objParametros->confReferencia))
		{
			if($objParametros->confReferencia!="-1")
			{
				$_SESSION["configuracionesPag"][$nConfiguracion]["referencia"]=$objParametros->confReferencia;
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
		}
	}
	
	
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
}
else
{
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
	{
		$parametros="";
		if($ctPOST>0)
		{
			$aLlaves=array_keys($_POST);
			$aValores=array_values($_POST);
			for($nCtParam=0;$nCtParam<$ctPOST;$nCtParam++)
			{
				$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
			}
		}
		else
		{
			if($ctGET>0)
			{
				$aLlaves=array_keys($_GET);
				$aValores=array_values($_GET);
				for($nCtParam=0;$nCtParam<$ctGET;$nCtParam++)
				{
					$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
				}
			}
		}
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
	}
}
?>


<!-- InstanceBeginEditable name="head" -->

<!-- InstanceEndEditable -->

<?php 
$tipoConsult="";
$permisosArray=array();
if($procesoName!="")
{
	$consulta="select permisos from 942_funcionesRoles where proceso='".$procesoName."' and rol in (".$_SESSION["idRol"].")";
	$procesoResult=$con->obtenerFilas($consulta);
	while($procesoRow=mysql_fetch_row($procesoResult))
	{
		$permisos=$procesoRow[0];
		$arrPermisosArray=explode("_",$permisos);
		$ctPermisos=sizeof($arrPermisosArray);
		for($x=0;$x<$ctPermisos;$x++)
		{
			$permisosArray[$arrPermisosArray[$x]]=true;
		}
	}
}


$configuracion="";
if(isset($objParametros->configuracion))
	$configuracion=$objParametros->configuracion;
$cPagina="";
$iFrame=false;
if(isset($objParametros->cPagina))
	$cPagina=$objParametros->cPagina;

if(isset($objParametros->iFrame))
	$iFrame=$objParametros->iFrame;

$arrParam=array();
	
if($cPagina!="")	
{
	$arrConf=explode("|",$cPagina);
	$nConf=sizeof($arrConf);
	for($x=0;$x<$nConf;$x++)
	{
		$arrDatosP=explode("=",$arrConf[$x]);
		$arrParam[$arrDatosP[0]]=$arrDatosP[1];
	}
	if(isset($arrParam["b"]))
		$mostrarTitulo=false;
	if(isset($arrParam["mI"]))
		$mostrarMenuIzq=false;
	if(isset($arrParam["mnu1"]))
		$mostrarMenuNivel1=false;
	if(isset($arrParam["mnu2"]))
		$mostrarMenuNivel2=false;
	if(isset($arrParam["mR1"]))
		$mostrarRegresar=false;
	if(isset($arrParam["mR2"]))
		$mostrarRegresarBajo=true;
	if(isset($arrParam["mPie"]))
		$mostrarPiePag=false;
	if(isset($arrParam["sFrm"]))
		$soloContenido=true;
	if(isset($arrParam["gConfS"]))
		$guardarConfSession=false;
	
}

$consulta="SELECT idIdioma,idioma,imagen FROM 8002_idiomas ORDER BY idioma";
$res=$con->obtenerFilas($consulta);
?>
<title><?php echo $tituloPagina ?></title>
<script language="javascript">
	function enviar(lenguaje)
	{
		gE('leng').value=lenguaje;
		gE('formLenguaje').submit();
	}
	
	function regresarPagina()
	{
		if(gE('configuracionRegresar').value!='')
			gE('frmRegresar').submit();
		else
			recargarPagina();
	}
	
	function recargarPagina()
	{
		gE('frmRefrescarPagina').submit();
	}
	
</script>
<?php
	if($soloContenido)
	{
?>
	<style>
	#main_content
	{
		padding: 0px !important;
	}
	.p15
	{
		padding: 0px !important;
	}
	#example_content
	{
		padding: 0px !important;
		margin-bottom: 0px !important;
	}
	</style>
<?php		
	}
?>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
</head>

<?php
		$main_single="main_single";
		$wrapper="wrapper";
		$main_hayas="main_hayas";
		$bgColor="";
		if($soloContenido)
		{
			$main_single="";
			$wrapper="";
			$main_hayas="";
			$bgColor='style=" background:#FFFFFF !important"';
		}
		
	?>

<body <?php echo $bgColor ?>>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<?php
	if(!$soloContenido)
	{
?>
<div id="main_title">
  <div class="wrapper">
  <?php
  	if($mostrarTitulo)
	{
		echo $banner; 
	} 
	?>
    <div class="transparencia" >
    	<table >
        	<tr height="25">
            	<td >
                	<?php
					if(!esUsuarioLog()&&$mostrarBotonesControlSistema)
					{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:ingresarSistema()"><img src="../images/botonIngreso.png"  /></a><a href="javascript:mostrarVentanaDuda()"><img src="../images/botonSoporte.png"  /></a>
                                </td>
                                <td align="left">
	                                
                                </td>
                            </tr>
                        </table>
                    <?php
					}
					else
					{
						if($mostrarBotonesControlSistema)
						{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:cerrarSesion()"><img src="../images/botonSalir.png" /></a>
                                </td>
                                <td align="left">
	                               <!-- &nbsp;<a href="javascript:cerrarSesion()">Cerrar sesión</a>-->
                                </td>
                            </tr>
                        </table>
						
					<?php
						}
					}
					
                    ?>
                </td>
                <td>
                </td>
            </tr>
       </table>
    </div>
  </div>
</div>
	
	<div id="navigation_hayas">
	<div class="wrapper_hayas">
    	
    	<div class="links_hayas">
		<ul class="tabs_hayas"  style="z-index:200 !important">
			<?php 
				
				if($mostrarMenuNivel1)
				{
					
					genearOpcionesMenusPrincipal($nomPagina,1,$idEstiloMenu);
				}
				
			?>
		</ul>
		<div class="clearer">&nbsp;</div>
		</div>

	</div>
	</div>
	<div id="subnavigation_hayas">
	<div class="wrapper">
		<div class="content">
			<div class="links">
            	<ul class="menu2" >
			<?php
				if($mostrarMenuNivel2)
				{
					genearOpcionesMenusPrincipal($nomPagina,2,$idEstiloMenu);
				}
			
			?>
            	</ul>
			<div class="clearerx">&nbsp;</div>
		  </div>
	  </div>
	</div>
</div>
<?php
	}
?>
	

	<div id="<?php echo $main_hayas ?>">
	<div class="<?php echo $wrapper ?>">

		<div id="main_content">		
		<div id="<?php echo $main_single ?>" class="p15">
		<div > 
			  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
               
			    <tr>    
					<?php  
					if((($mostrarMenuIzq)&&(!$soloContenido))||((isset($arrParam["mI"]))&&($arrParam["mI"]=='true')))
					{
					?>	
                    <td valign="top" style="width:<?php echo $tamColumIzq?>px" id="tdMenuIzq">
					
               		<div id="example_content" style="width:<?php echo $tamColumIzq?>px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top">
                        	<?php
                            genearOpcionesMenusPrincipal($nomPagina,3,$idEstiloMenu);
                            ?>
						</td>
						
                      </tr>
					  <tr>
					  <td>
					 
					  <!-- InstanceBeginEditable name="menu_left2" -->
					  
					  <!-- InstanceEndEditable -->
					  </td>
					  </tr>
                    </table>
					 </div>
                
                     </td>
					 <?php
					 }
					 ?>
                  <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
                  <td width="81%" bgcolor="#FFFFFF" valign="top">
				  <div id="example_content">  
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  	<td align="right">
						<table width="100%">
						<tr>
						<td>
							<?php 	
									if(!$ocultarRegresar)
									{

										if((($mostrarRegresar)&&(!$soloContenido))||((isset($arrParam["mR1"]))&&($arrParam["mR1"]=='true')))
										{
								?> 
											<table align="left" id="tblRegresar1">
											<tr>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img width="24" height="24" src="../images/flechaizq.gif" border="0" /></a>
											</td>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
											</td>
											</tr>
											</table>
											<br />
								<?php 
										}
									}
									if($respetarEspacioRegresar)
										echo "<br><br>";
									echo "<input type=\"hidden\" value=\"".$_SESSION["leng"]."\" id=\"hLeng\"> ";
									
							?>
						</td>
						</tr>
						</table>
					</td>
				</tr>
				  <!-- InstanceBeginEditable name="content2" --> 
                   <tr>
                        <td align="center">
                        	<script type="text/javascript" src="Scripts/funcionesVisorThot.js.php"></script>
                            <script type="text/javascript" src="../thotReporter/Scripts/visorThot.js.php"></script>
                        	<?php 
								$idReporte="-1";
								$ojParametrosReporte=null;
								if(isset($objParametros->r))
									$idReporte=bD($objParametros->r);
								$consulta="select ancho,alto from 9010_reportesThot where idReporte=".$idReporte;

								$filaGrid=$con->obtenerPrimeraFila($consulta);
								$anchoGrid=$filaGrid[0];
								$altoGrid=$filaGrid[1];
								$cc=0;
								$calibrarCtrl="var calibrarCtrl=new Array();";
								
								$consulta="SELECT parametro FROM 9015_parametrosReporte WHERE idReporte=".$idReporte;
								$resParam=$con->obtenerFilas($consulta);
								$arrValorParamReporte="";
								$cadenaHiddenParam="";
								$paramAmbiente='"idReporte":"'.$idReporte.'"';
								while($filaParam=mysql_fetch_row($resParam))
								{
									
									
									$vParam="";
									$exp='if(isset($objParametros->'.$filaParam[0].'))
											$vParam=$objParametros->'.$filaParam[0].';';
									eval($exp);
									
									$paramAmbiente.=',"'.$filaParam[0].'":"'.$vParam.'"';

									
									if($arrValorParamReporte=="")
										$arrValorParamReporte='"p'.$filaParam[0].'":"'.$vParam.'"';
									else
										$arrValorParamReporte.=',"p'.$filaParam[0].'":"'.$vParam.'"';
									$cadenaHiddenParam.='<input type="hidden" name="hParametros" id="'.$filaParam[0].'" value="'.$vParam.'">';
										
								}
								
								
								$cadObj='{"p2":{'.$arrValorParamReporte.'},"parametrosAmbiente":{'.$paramAmbiente.'}}';
								$paramObj=json_decode($cadObj);
								$ojParametrosReporte=$paramObj->p2;
								$parametrosAmbiente=$paramObj->parametrosAmbiente;
								$arrResultConsulta=resolverQueries($idReporte,1,$paramObj,true);
								$funcionesJavaInicio="";
								

							?>
                        	<table id='tblGrid' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px">
                            	<tr>
                                	<td id="tdContenedor" class="" align="left">
                                    <?php
										
										//var_dump($arrResultConsulta);
								   		crearElementosReporte();
									?>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" value="<?php echo $idReporte?>" id="idReporte" />
                            <input type="hidden" value="<?php echo $_SESSION["leng"]?>" id="hIdIdioma" />
                            <?php
                            	echo $cadenaHiddenParam;
                            ?>
                        <script>
							<?php
							echo $calibrarCtrl;
							?>
							function ejecutarFuncionesInicio()
							{
								
						<?php
								echo $funcionesJavaInicio;
						?>
								
							}
						</script>
                        </td>
                   </tr>
				  <!-- InstanceEndEditable -->
				  <tr>
				  <td><br />
                  <?php
						if(!$ocultarFormulariosEnvio)
						{
				  ?>
                            <form method="post"	action="" id='frmEnvioDatos'>
                                <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
                                
                                <?php
									if($soloContenido)
									{
								?>
                                 <input type="hidden" name="cPagina" value="sFrm=true|mR1=true" />
                                <?php
									}
								?>
                                
                            </form>
                            <form method="post"	action="<?php echo $pConfRegresar?>" id='frmRegresar'>
                                <input type="hidden" name="configuracion" id="configuracionRegresar" value="<?php echo $nConfRegresar ?>" />
                            </form>
                            <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
                                <input type="hidden" name="configuracion" value="<?php echo $nConfiguracion ?>" />
                            </form>    
                        
				  	<?php 	
						}
					
							if(($mostrarRegresarBajo)&&(!$soloContenido))
							{
							?> 
							<table align="left" id="tblRegresar2">
							<tr>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img src="../images/flechaizq.gif" border="0" /></a>
							</td>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
							</td>
							</tr>
							</table>
							<?php 
									}
							?>
				  </td>
				  </tr> 
				   </table>
				 </div>
				  </td>
				
                </tr>
              </table>
			  <div class="clearer">&nbsp;</div>
		 


			<div class="clearer">&nbsp;</div>
		</div>
	</div>
</div>
<?php
if(($mostrarPiePag)&&(!$soloContenido))
{
?>
<div id="footer">
	<div class="wrapper">
		<div class="content">

			<table width="100%">
            	<tr>
                	<td width="33%" align="left">
                        <span class="small">
                        <?php
                            echo $textoInfIzq;
                        ?>
                        </span>
                    </td>
                    <td width="34%"></td>
                    <td width="33%" align="right">
                    	<span class="small">
						<?php
                            echo $textoInfDer;
                        ?>
                        </span>
                    </td>
                    
                </tr>
            </table>
	  </div>
	</div>
</div>
<?php
}
?>
</body>
<!-- InstanceEnd --></html>
