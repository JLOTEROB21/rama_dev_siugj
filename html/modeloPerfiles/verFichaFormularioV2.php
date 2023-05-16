<?php 

$ignorarSesion=false;
if(isset($_POST["ignSesion"])||isset($_GET["ignSesion"]))	
	$ignorarSesion=true;
if(!$ignorarSesion)
	include("sesiones.php");
include("conexionBD.php"); 

include("configurarIdioma.php");
include("funcionesPortal.php");

$idFormulario="-1";

$idFormulario=obtenerValorParametro("idFormulario");

$configuracion=obtenerValorParametro("configuracion");

if(($idFormulario=="-1")&&($configuracion=="")&&(!$ignorarSesion))
{
	return;
	header('location:../principal/inicio.php');
}

$calibrarCtrl="";
$cc=0;
$arrConfiguraciones="var arrParamConfiguraciones=new Array();";

function crearElementosFormulario()
{
		global $funcionesJava;
		global $funcionesJavaInicio;
		global $con;
		global $et;
		global $idFormulario;
		global $existeT;
		global $arrColumnasDatos;
		global $nombreTabla;
		global $idRegistro;
		global $calibrarCtrl;
		global $arrConfiguraciones;
		global $arrValoresReemplazo;
		global $cc;
		global $arrQueries;		
		global $idProceso;
		global $idReferencia;
		global $idProcesoP;
		$arrValoresParametros=array();
		$arrValoresParametros["idFormulario"]=$idFormulario;
		$arrValoresParametros["idRegistro"]=$idRegistro;
		$arrValoresParametros["idReferencia"]=$idReferencia;
		$arrValoresParametros["idProceso"]=$idProceso;
		$arrValoresParametros["idProcesoP"]=$idProcesoP;
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,idGrupoElementoRef from 937_elementosVistaFormulario where tipoElemento in (1,13,30) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"];
		//echo $query."<br>";
		$res=$con->obtenerFilas($query);
		$estiloDiv="";
		while($filas=$con->fetchRow($res))
		{
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$filas[0];
			$fConfiguracionElemento=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$funcionRenderer=$fConfiguracionElemento["campoConf18"];
			
			if($funcionRenderer!="")
			{
				$consulta="SELECT COUNT(*) FROM 9033_rolesFuncionesScripts WHERE idFuncion=".$funcionRenderer;
				$numElementos=$con->obtenerValor($consulta);
				if($numElementos>0)
				{
					$consulta="SELECT COUNT(*) FROM 9033_rolesFuncionesScripts WHERE idFuncion=".$funcionRenderer." AND rol IN(".$_SESSION["idRol"].")";
					$numElementos=$con->obtenerValor($consulta);
					if($numElementos==0)
					{
						$funcionRenderer="";
						
					}
				}
			}
			
			$query="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
			$filaE=$con->obtenerPrimeraFila($query);
			$estilo=$filaE[13];
			$HRef="";
			$cHRef="";
			$estiloAdicional="";
			if($filaE[14])
				$estiloAdicional="width:".$filaE[14]."px;";
			if($filaE[5]!="")
			{
				$HRef=generarEnlaceEtiqueta($filaE[5],$filas[0],$arrValoresParametros);
				$cHRef="</a>";	
			}
			
			switch($filas[2])
			{
				case "1":
					$estiloDiv='z-index:10;';
					$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($query);
					
					
					$etiqueta="<div class='".$estilo."' id='_lbl".$filas[0]."' style='width: ".$filaE[2]."px;height: ".$filaE[3]."px'>".$HRef."<span id='sp_".$filas[0]."'>".$filas[1]."</span>".$cHRef."</div>";
				break;
				case "13":
					$estiloDiv='z-index:0;';
					$query="select campoConf1,campoConf2 from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
					$confCampo=$con->obtenerPrimeraFila($query);
					
					$etiqueta="<fieldset class='frameHijoV3' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px; '  ><legend> ".$filas[1]."</legend></fieldset>";
				break;
				case "30":
					$estiloDiv='z-index:10;';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaO=$con->obtenerPrimeraFila($consulta);
					/*$HRef="";
					$cHRef="";
					if($filaE[2]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}*/
					if(!isset($controlesQuery[$filaO[2]]))
						$controlesQuery[$filaO[2]]=array();
					array_push($controlesQuery[$filaO[2]],"_".$filas[1]."vch");

					/*if($arrQueries[$filaO[2]]["ejecutado"]==1)
					{
						
						if(gettype($arrQueries[$filaO[2]]["resultado"])!='resource')
							$valor=$arrQueries[$filaO[2]]["resultado"];
						else
						{
							if($arrQueries[$filaO[2]]["filasAfectadas"]>0)
							{

								$resQuery=$arrQueries[$filaO[2]]["resultado"];
								$conAux=$arrQueries[$filaO[2]]["conector"];
								$conAux->inicializarRecurso($resQuery);	
								$filaRes=$conAux->obtenerSiguienteFilaAsoc($resQuery);
								$cNormalizado=str_replace(".","_",$filaO[3]);
								$valor=$filaRes[$cNormalizado];
							}
							else
								$valor="";
						}
					}
					else
						$valor='';*/

					if($arrQueries[$filaE[2]]["ejecutado"]==1)
					{
						
						if((gettype($arrQueries[$filaE[2]]["resultado"])!='resource')&&(gettype($arrQueries[$filaE[2]]["resultado"])!='object'))
						{

							$valor=$arrQueries[$filaE[2]]["resultado"];
						}
						else
						{

							if($arrQueries[$filaE[2]]["filasAfectadas"]>0)
							{
								
								$arrCamposProy=explode('@@',$filaE[3]);
								$resQuery=$arrQueries[$filaE[2]]["resultado"];
								$conAux=$arrQueries[$filaE[2]]["conector"];
								$conAux->inicializarRecurso($resQuery);	
								$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"6","imprimir":"0","campoID":""}';
								$obj=json_decode($cadObj);
								$obj->resQuery=$resQuery;
								$obj->idAlmacen=$filaE[2];
								$obj->arrCamposProy=$arrCamposProy;
								$obj->itemSelect=-1;
								$obj->conector=$conAux;
								$valor=generarFormatoOpcionesQuery($obj);
							}
							else
								$valor="";
						}
						if($valor==-1)
							$valor="";
					}
					else
					{
						if((strlen($arrQueries[$filaE[2]]["arrParamControl"])>0)&&($idRegistro!=-1))
						{

							$queryTmp=$arrQueries[$filaE[2]]["query"];
							$arrControles=explode(",",$arrQueries[$filaE[2]]["arrParamControl"]);
							foreach($arrControles as $ctrl)
							{
								if(trim($ctrl)=="")
									continue;
								$queryTmp2="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='".$ctrl."' AND tipoElemento<>1";
								$idCtrlParam=$con->obtenerValor($queryTmp2);
								$queryTmp=str_replace("@Control_".$idCtrlParam,$arrColumnasDatos[$ctrl],$queryTmp);
								
								
							}

							$conAux=$arrQueries[$filaE[2]]["conector"];
							$resQuery=$conAux->obtenerFilas($queryTmp);
							if($conAux->filasAfectadas>0)
							{
								$arrCamposProy=explode('@@',$filaE[3]);
								$conAux->inicializarRecurso($resQuery);	
								$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"6","imprimir":"0","campoID":""}';
								$obj=json_decode($cadObj);
								$obj->resQuery=$resQuery;
								$obj->idAlmacen=$filaE[2];
								$obj->arrCamposProy=$arrCamposProy;
								$obj->itemSelect=-1;
								$obj->conector=$conAux;
								$valor=generarFormatoOpcionesQuery($obj);
							}
							else
								$valor="";
						}
						else
							$valor='';
					}
					
					$etiqueta="<div class='".$filaE[13]."' id='_".str_replace("]","",str_replace("[","",$filas[1]))."vch' idAlmacen='".$filaO[2]."' enlace='".$filaO[5]."'>".$HRef.'<span id="sp_'.$filas[0].'" funcRenderer="'.$funcionRenderer.'">'.convertirEnterToBR($valor)."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$filas[0]."',".$filas[0].");";
					}
				break;	
			}
			
			$tabla=	 "	<table>
    						<tr>
                    			<td>".$etiqueta."</td>
                    		</tr>
    					</table>";
			$div="<div id='div_".$filas[0]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute;".$estiloAdicional.";".$estiloDiv."' >".$tabla."</div>";			
			echo $div;	
			if($calibrarCtrl=="")
				$calibrarCtrl="['div_".$filas[0]."']";
			else
				$calibrarCtrl.=",['div_".$filas[0]."']";
			$cc++;
		}
		$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
		$idProceso=$con->obtenerValor($consulta);
		$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		
		if($tipoProceso!=1)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,orden from 937_elementosVistaFormulario where tipoElemento not in (-2,-1,1,13,0,20,30) and idFormulario=".$idFormulario." order by orden";
		else
			$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,orden from 937_elementosVistaFormulario where tipoElemento not in (-1,1,13,20,0,30) and idFormulario=".$idFormulario." order by orden";
		$res=$con->obtenerFilas($query);
		$claseRespuesta="small";
		$ctParamFunciones=0;
		while($fElemento=$con->fetchRow($res))
		{
			
			
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$fElemento[0];
			$fConfiguracionElemento=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$funcionRenderer=$fConfiguracionElemento["campoConf18"];
			
			if($funcionRenderer!="")
			{
				$consulta="SELECT COUNT(*) FROM 9033_rolesFuncionesScripts WHERE idFuncion=".$funcionRenderer;
				
				$numElementos=$con->obtenerValor($consulta);
				if($numElementos>0)
				{
					$consulta="SELECT COUNT(*) FROM 9033_rolesFuncionesScripts WHERE idFuncion=".$funcionRenderer." AND rol IN(".$_SESSION["idRol"].")";

					$numElementos=$con->obtenerValor($consulta);
					if($numElementos==0)
						$funcionRenderer="";
				}
			}
			
			$query="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
				
			$filaE=$con->obtenerPrimeraFila($query);
			$estiloAdicional="";
			if($filaE[14])
				$estiloAdicional="width:".$filaE[14]."px;";
			$HRef="";
			$cHRef="";
			if($filaE[5]!="")
			{
				
				$consulta="select * from 9041_parametrosEnlaces where idEnlace=".$filaE[5];
				$resEnlace=$con->obtenerFilas($consulta);
				$parametros="";
				while($filaEnlace=$con->fetchRow($resEnlace))
				{
					$valor="";
					switch($filaEnlace[3])
					{
						case "1";
							$valor=$filaEnlace[4];
						break;
						case "3":
							$consulta="select valorSesion,valorReemplazo from 8003_valoresSesion where idValorSesion=".$valor;
							$filaSesion=$con->obtenerPrimeraFila($consulta);
							$valor="'".$_SESSION[$filaSesion[0]]."'";
						break;
						case "4":
							switch($valor)
							{
								case 8:
									$valor=date("Y-m-d");
								break;
								case 9:
									$valor=date("H:i");
								break;	
							}
						break;
						case "5":
							$valor=$filaEnlace[4];
							switch($valor)
							{
								case 1:
									$valor=$idFormulario;
								break;
								case 2:
									$valor=$idRegistro;
								break;
								case 3:
									$valor=$idReferencia;
								break;
								case 4:
									$valor=$idProceso;
								break;
								case 5:
									$valor=$idProcesoP;
								break;	
							}
						break;
					}
					$obj="['".$filaEnlace[2]."','".$valor."']";
					if($parametros=="")
						$parametros=$obj;
					else
						$parametros.=",".$obj;
						
				}
				$consulta="SELECT * FROM 9040_listadoEnlaces WHERE idEnlace=".$filaE[5];
				$filaEnlace=$con->obtenerPrimeraFila($consulta);
				$HRef="<a title='".$filaEnlace[1]."' alt='".$filaEnlace[1]."' id='link_".$filas[0]."' href='javascript:verEnlaceFormularioLink(\"".bE($filaEnlace[4])."\",\"".bE($filaEnlace[2])."\",\"".bE('['.$parametros.']')."\")'>";
				$cHRef="</a>";	
			}
			$val='';
			$asteriscoRojo='';
			$nColumna=str_replace("[","",$fElemento[1]);
			$nColumna=str_replace("]","",$nColumna);
			$valorCelda="";
			
			if(($existeT==1)&&($fElemento[2]>1)&&($fElemento[2]!=13)&&(!(($fElemento[2]>=17)&&($fElemento[2]<=19)))&&($fElemento[2]!=23)&&($fElemento[2]!=29)&&($fElemento[2]!=33))
			{
				$valorCelda=$arrColumnasDatos[$nColumna];	
			}
			else
				$valorCelda="";
			$query="select campoConf12 from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
			$claseRespuesta=$con->obtenerValor($query);
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);	
			$nombreControlOriginal=str_replace("[","",$nombreControl);
			$nombreControlOriginal=str_replace("]","",$nombreControlOriginal);
			$queryAyuda="select mensajeAyuda from 914_mensajesAyuda where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$fElemento[0];
			$msgAyuda=$con->obtenerValor($queryAyuda);
			$idRef=$idRegistro;
			$idRegistroD="-1";
			$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
			$filaFormulario=$con->obtenerPrimeraFila($consulta);
			
			
			
			switch($fElemento[2])					
			{
				case -2:
						  $consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
						  $idProceso=$con->obtenerValor($consulta);
						  $consulta="select idFormulario,nombreTabla from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
						  $fFormulario=$con->obtenerPrimeraFila($consulta);
						  
						  $consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
						  
						  $tipoProceso=$con->obtenerValor($consulta);
						  $display='';
						  if($tipoProceso>=3)
						  	$display="style='display:none'";
						
					  $etiqueta="	<table class='tablaMenu' width='200' ".$display.">";
					  if($idRegistro!="-1")
					  {
						  
						  if($fFormulario)
						  {
							  $idFormularioBase=$fFormulario[0];
							  $nombreTablaBase=$fFormulario[1];
						  }
						  else
						  {
							  $consulta="select idFormulario,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
							  $fFormulario=$con->obtenerPrimeraFila($consulta);
							  $idFormularioBase=$fFormulario[0];
							  $nombreTablaBase=$fFormulario[1];
						  }
						  $idEtapa=obtenerEtapaRegistroBase($idRegistro,$idFormulario,$nombreTablaBase,$idFormularioBase);
						  
						  switch($tipoProceso)
						  {
							  case "3":
							  case "4":
							  case "5":
							  
							  		$consulta="select idFormulario from 203_elementosDTD where idProceso=".$idProceso;
									$frmDTD=$con->obtenerListaValores($consulta);
									if($frmDTD=="")
										$frmDTD="-1";
	  							  	$consulta="select distinct(f.idFormulario),f.titulo,f.frmRepetible,f.nombreTabla,f.tipoFormulario 
								  			from 900_formularios f,4037_etapas e  where e.numEtapa=f.idEtapa and 
											f.idFrmEntidad=".$idFormulario." and e.numEtapa<=".$idEtapa." and f.idFormulario in(".$frmDTD.")";
							  break;
							  default:
							  		$consulta="select distinct(f.idFormulario),f.titulo,f.frmRepetible,f.nombreTabla,f.tipoFormulario  from 900_formularios f,4037_etapas e  where e.numEtapa=f.idEtapa and f.idFrmEntidad=".$idFormulario." and f.tipoFormulario<>10 and e.numEtapa<=".$idEtapa;
						  }

						 $resFrm=$con->obtenerFilas($consulta);
						  if(($con->numRows($resFrm)>0))
						  {
							  $dependencias=true;
							  while($filaFrm=$con->fetchRow($resFrm))
							  {
								  if($filaFrm[4]!="10")
								  {
									  if($filaFrm[2]==0)
									  {
										  $nomTablaD=$filaFrm[3];
										  $consulta="select id_".$nomTablaD." from ".$nomTablaD." where idReferencia=".$idRegistro;
										  $idRegistroD=$con->obtenerValor($consulta);
										  if($idRegistroD=='')
											  $idRegistroD='-1';
									  }
									  $etiqueta.= "<tr height='23'>
													  <td width='30'>&nbsp;<a href='javaScript:enviarAsociadoNormal(".$filaFrm[0].",".$idRegistroD.",".$filaFrm[2].",".$idRef.")'><img src='../images/icon_code.gif'></a></td>
													  <td class='letraFichaRespuesta' align='left' ><a href='javaScript:enviarAsociadoNormal(".$filaFrm[0].",".$idRegistroD.",".$filaFrm[2].",".$idRef.")'>".$filaFrm[1]."</a></td>
												  </tr>";
								  }
								  else
								  {
									  	$consulta="select modulo,paginaAsociada from 200_modulosPredefinidosProcesos where idGrupoModulo=".$filaFrm[1]." and idIdioma=".$_SESSION["idUsr"];
										$filaR=$con->obtenerPrimeraFila($consulta);		
									  	$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."]=new Array();";
										$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][0]='".$filaR[1]."';";
										
										$consulta="select nombreParametro,valorParametro from 242_parametrosEnlaces where idEnlace=".$filaFrm[1]." and tipoEnlace=0";
										$arrParametros=$con->obtenerFilasArreglo($consulta);	
										$numParam=sizeof($arrValoresReemplazo);
										for($pos=0;$pos<$numParam;$pos++)
										{
											$arrParametros=str_replace($arrValoresReemplazo[$pos][0],$arrValoresReemplazo[$pos][1],$arrParametros);	
										}
										
										
										
										$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][1]=".$arrParametros.";";
									  	$etiqueta.= "<tr height='23'>
													  <td width='30'>&nbsp;<a href=\"javaScript:enviarPaginaEnlace(".$ctParamFunciones.")\"><img src='../images/icon_code.gif'></a></td>
													  <td class='letraFichaRespuesta' align='left' ><a href=\"javaScript:enviarPaginaEnlace(".$ctParamFunciones.")\">".$filaR[0]."</a></td>
												  </tr>";
										$ctParamFunciones++;
								  }
								  
							  }
						  }
						  
					  }
					  $etiqueta.="</table>";	
					  $ignorarLimites='ignorarLimites="actualizar"';
					  $mostrarEliminar=false;
					
					
				break;
				case -1:
					$etiqueta="<input type='button' value='".$et["lblBtnAceptar"]."' class='btnAceptar' onclick=\"cancelarSinConfirmar()\">";
				break;
				case 2: //pregunta cerrada-Opciones Manuales
					$queryOpt="select contenido from 902_opcionesFormulario where valor='".$valorCelda."' and idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$etiqueta=	$con->obtenerValor($queryOpt);	
					$etiqueta= "<div class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$filaFormulario[19]."'>".$etiqueta."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div >".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$etiqueta."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 3: //pregunta cerrada-Opciones intervalo
					if(strpos($valorCelda,".")!==false)
						$valorCelda=removerCerosDerecha($valorCelda);
					$etiqueta= "<div class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$filaFormulario[19]."'>".($valorCelda)."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".($valorCelda)."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 4: //pregunta cerrada-Opciones tabla
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					
					$autocompletar=$filaE[9];
					$anchoC=$filaE[11];
					if($autocompletar==2)
					{
						$consulta="SELECT idOpcion FROM _".$idFormulario."_grid".ucfirst (str_replace("]","",str_replace("[","",$fElemento[1])))." WHERE idPadre=".$idRegistro;
						$valorCelda=$con->obtenerListaValores($consulta,"'");
					}
					
					if($valorCelda!="")
					{
						
						if(strpos($filaE["2"],"[")===false)
						{
							$filaE["4"]=str_replace("distinct","",$filaE[4]);
							$query="select concat(".$filaE["3"].") from ".$filaE["2"]." where ".$filaE["4"]."=".$valorCelda;	
							$valorCelda=$con->obtenerValor($query);
						}
						else
						{
							
							$tablaOD=$filaE["2"];
							$tablaOD=str_replace("[","",$tablaOD);
							$tablaOD=str_replace("]","",$tablaOD);
							$arrCamposProy=explode('@@',$filaE[3]);
							$campoId=$filaE[4];
							
							if($arrQueries[$tablaOD]["ejecutado"]==1)
							{
								
								$resQuery=$arrQueries[$tablaOD]["resultado"];
								$conAux=$arrQueries[$tablaOD]["conector"];
								$conAux->inicializarRecurso($resQuery);	
								$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","mutiValor":'.($autocompletar==2?"true":"false").',"arrCamposProy":[],"formato":"4","imprimir":"0","query":"'.$arrQueries[$tablaOD]["query"].'","campoID":"'.$campoId.'"}';
								$obj=json_decode($cadObj);
								$obj->resQuery=$resQuery;
								$obj->idAlmacen=$tablaOD;
								$obj->arrCamposProy=$arrCamposProy;
								$obj->itemSelect=$valorCelda;
								$obj->conector=$conAux;
								$valorCelda=generarFormatoOpcionesQuery($obj);
								$obtenerOpciones=false;
							}
							else
							{
								
								if((strlen($arrQueries[$tablaOD]["arrParamControl"])>0)&&($idRegistro!=-1))
								{
									$queryTmp=$arrQueries[$tablaOD]["query"];
									$arrControles=explode(",",$arrQueries[$tablaOD]["arrParamControl"]);
									foreach($arrControles as $ctrl)
									{
										$queryTmp2="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='".$ctrl."' AND tipoElemento<>1";
										$idCtrlParam=$con->obtenerValor($queryTmp2);
										$queryTmp=str_replace("@Control_".$idCtrlParam,$arrColumnasDatos[$ctrl],$queryTmp);
										
										
									}
									$conAux=$arrQueries[$tablaOD]["conector"];
									$resQuery=$conAux->obtenerFilas($queryTmp);
									
									if($conAux->filasAfectadas>0)
									{
										$conAux->inicializarRecurso($resQuery);	
										$cadObj='{"queryReemplazo":"","conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"4","imprimir":"0","query":"'.$arrQueries[$tablaOD]["query"].'","campoID":"'.$campoId.'"}';
										$obj=json_decode($cadObj);
										$obj->resQuery=$resQuery;
										$obj->idAlmacen=$tablaOD;
										$obj->arrCamposProy=$arrCamposProy;
										$obj->itemSelect=$valorCelda;
										$obj->conector=$conAux;
										$obj->queryReemplazo=$queryTmp;
										$valorCelda=generarFormatoOpcionesQuery($obj);
										
									}
									else
										$valorCelda="";
								}
								else
									$valorCelda='';
								
							}
						}
					}
					$etiqueta= "<div ".($anchoC!=""?"style='width:".$anchoC."px'":"")." class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$filaFormulario[19]."'>".$valorCelda."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div ".($anchoC!=""?"style='width:".$anchoC."px'":"").">".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$valorCelda."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 5: //Texto Corto
					$etiqueta= "<div class='".$claseRespuesta."' id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'><span>".$HRef.$valorCelda.$cHRef."</span></div>";
					if($valorCelda=="")
						$etiqueta= "<div ><span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</span></div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 6: //Número entero
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$sepMiles=$filaE[3];
					$mascara="#".$sepMiles."###";
					$funcionesJavaInicio.="msk_".$nombreControlOriginal."=new Mask('".$mascara."','number');msk_".$nombreControlOriginal.".attach(gE('".$nombreControlOriginal."'));gE('".$nombreControlOriginal."').innerHTML=msk_".$nombreControlOriginal.".format('".$valorCelda."');";
					$etiqueta= "<div funcRenderer='".$funcionRenderer."' class='".$claseRespuesta."' id='".$nombreControlOriginal."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div  id='".$nombreControlOriginal."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
						
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'".$nombreControlOriginal."',".$fElemento[0].");";
					}
				break;
				case 7: //Número decimal
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($consulta);
					$sepDecimales=$filaE[4];
					$sepMiles=$filaE[3];
					$nDecimales=$filaE[7];
					$valorCelda=number_format($valorCelda,$nDecimales,$sepDecimales,$sepMiles);
					$etiqueta= "<div class='".$claseRespuesta."' id='".$nombreControlOriginal."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div  id='".$nombreControlOriginal."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'".$nombreControlOriginal."',".$fElemento[0].");";
					}
				break;
				case 8: //Fecha
					if($valorCelda!="")
					{
						$arrValor=explode("-",$valorCelda);
						$valorCelda=$arrValor[2]."/".$arrValor[1]."/".$arrValor[0];
					}
					$etiqueta= "<div id='sp_".$fElemento[0]."' class='".$claseRespuesta."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 9://Texto Largo 
					
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<div funcRenderer='".$funcionRenderer."' id='divTexto_".$fElemento[0]."' class='".$claseRespuesta."' style='width:".$filaE[2]."px;height:".$filaE[3]."px;overflow: auto;' >".$HRef.convertirEnterToBR($valorCelda).$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div funcRenderer='".$funcionRenderer."'  style='width:".$filaE[2]."px;height:".$filaE[3]."px;overflow: auto;' funcRenderer='".$funcionRenderer."'>".$HRef.convertirEnterToBR($valorCelda).$cHRef."</div>";
					else	
						$funcionesJavaInicio.='$("#divTexto_'.$fElemento[0].'").dblclick(function(){abrirTextoCompleto("'.bE($fElemento[0]).'","'.bE($idRegistro).'")});';		
					
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'divTexto_".$fElemento[0]."',".$fElemento[0].");";
					}	
						
				break;
				case 10: //Texto Enriquecido
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaEO=$con->obtenerPrimeraFila($consulta);
					$anchoTexto=$filaEO[2];
					if($filaE[14]!="")
						$anchoTexto=$filaE[14];
					$vEstilo=$filaE[16];
					$estiloAux="";
					switch($vEstilo)
					{
						case "":
						case "0":
						break;
						case 1:
							$estiloAux="text-align:left !important;";
						break;
						case 2:
							$estiloAux="text-align:right !important;";
						break;
						case 3:
							$estiloAux="text-align:justify !important;";
						break;
					}
					if($filaE[15]==0)
					{
						$valorCelda=($valorCelda);
					}
					
					
						
						//$valorCeldaFinal=bE(str_replace("'","\\'",$valorCelda));
						


					
					$etiqueta= "<div id='divTexto_".$fElemento[0]."' class=".$filaE[13]." style='overflow: auto;padding:7px;".$estiloAux."' >
								<span name='txtEnriquecido_".$fElemento[0]."' id='txtEnriquecido_".$fElemento[0]."' val='".$val."'></span>
								</div>";
					$funcionesJavaInicio.="crearTextoEnriquecido('".$nombreControl."','txtEnriquecido_".$fElemento[0]."',".$filaEO[2].",".$filaEO[3].",'".bE($valorCelda)."','../../modeloPerfiles/Scripts/configCKEditorSL.js',0);";
					$funcionesJavaInicio.='$("#divTexto_'.$fElemento[0].'").dblclick(function(){abrirTextoCompleto("'.bE($fElemento[0]).'","'.bE($idRegistro).'")});';	
				break;
				case 11: //Correo Electrónico
				
					$etiqueta= "<div class='".$claseRespuesta."' id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div  id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 12: //Archivo
					$descargarArchivo="";
					if(($valorCelda!='')&&($valorCelda!='-1'))
					{
						$val='';
						
						$consulta="SELECT lower(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$valorCelda;
						$nomArchivoOriginal=$con->obtenerValor($consulta);
						$arrNombreArchivo=explode(".",$nomArchivoOriginal);
						$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
						
						$descargarArchivo="<a href='javascript:visualizarDocumentoAdjuntoB64(\"".bE($valorCelda)."\",\"".bE($extension)."\")'><img src='../images/magnifier.png' alt='Ver Documento' title='Ver Documento'></a>&nbsp;&nbsp;".$nomArchivoOriginal."";
						
						
					}
					else
						$valorCelda="-1";
					$etiqueta=$descargarArchivo;
				break;
				case 14:
					$queryOpt="select contenido from 902_opcionesFormulario where valor='".$valorCelda."' and idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$etiqueta=	$con->obtenerValor($queryOpt);	
					$etiqueta= "<div class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$etiqueta."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div >".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$etiqueta."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 15:
					$etiqueta= "<div class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".removerCerosDerecha($valorCelda)."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div >".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".removerCerosDerecha($valorCelda)."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 16:
					
				
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($valorCelda!='')
					{
						if(strpos($filaE["2"],"[")===false)
						{
							$query="select concat(".$filaE["3"].") from ".$filaE["2"]." where ".$filaE["4"]."=".$valorCelda;	
							$valorCelda=$con->obtenerValor($query);
						}
						else
						{
							$tablaOD=$filaE["2"];
							$tablaOD=str_replace("[","",$tablaOD);
							$tablaOD=str_replace("]","",$tablaOD);
							$arrCamposProy=explode('@@',$filaE[3]);
							$campoId=$filaE[4];
							
							if($arrQueries[$tablaOD]["ejecutado"]==1)
							{
								$resQuery=$arrQueries[$tablaOD]["resultado"];
								$conAux=$arrQueries[$tablaOD]["conector"];
								$conAux->inicializarRecurso($resQuery);	
								$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"4","imprimir":"0","query":"'.$arrQueries[$tablaOD]["query"].'","campoID":"'.$campoId.'"}';
								$obj=json_decode($cadObj);
								$obj->resQuery=$resQuery;
								$obj->idAlmacen=$tablaOD;
								$obj->arrCamposProy=$arrCamposProy;
								$obj->itemSelect=$valorCelda;
								$obj->conector=$conAux;
								
								
								$valorCelda=generarFormatoOpcionesQuery($obj);
								
							}
							else
							{
								if((strlen($arrQueries[$tablaOD]["arrParamControl"])>0)&&($idRegistro!=-1))
								{
									$queryTmp=$arrQueries[$tablaOD]["query"];
									$arrControles=explode(",",$arrQueries[$tablaOD]["arrParamControl"]);
									foreach($arrControles as $ctrl)
									{
										$queryTmp2="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='".$ctrl."' AND tipoElemento<>1";
										$idCtrlParam=$con->obtenerValor($queryTmp2);
										$queryTmp=str_replace("@Control_".$idCtrlParam,$arrColumnasDatos[$ctrl],$queryTmp);
										
										
									}
									$conAux=$arrQueries[$tablaOD]["conector"];
									$resQuery=$conAux->obtenerFilas($queryTmp);
									if($conAux->filasAfectadas>0)
									{
										$conAux->inicializarRecurso($resQuery);	
										$cadObj='{"queryReemplazo":"","conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"4","imprimir":"0","query":"'.$arrQueries[$tablaOD]["query"].'","campoID":"'.$campoId.'"}';
										$obj=json_decode($cadObj);
										$obj->resQuery=$resQuery;
										$obj->idAlmacen=$tablaOD;
										$obj->arrCamposProy=$arrCamposProy;
										$obj->itemSelect=$valorCelda;
										$obj->conector=$conAux;
										$obj->queryReemplazo=$queryTmp;
										$valorCelda=generarFormatoOpcionesQuery($obj);
									}
									else
										$valorCelda="";
								}
								else
									$valorCelda='';
								
							}
						}
						
						
					}
					
					
					$etiqueta= "<div class='".$claseRespuesta."'>".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$valorCelda."</span>".$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div >".$HRef."<span id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$valorCelda."</span>".$cHRef."</div>";
					if($filaFormulario[19]!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$filaFormulario[19]."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 17:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$etiqueta="<div id='span".$nombreControl."'><table >";
					$nCol=0;
					$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$nControlSinSuf=str_replace("[","",$nControlSinSuf);
					$nControlSinSuf=str_replace("]","",$nControlSinSuf);
					$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					$ctNumSel=0;
					$resTabla=$con->obtenerFilas($queryTabla);
					$primerElemento="";
					$dibujaFila=1;
					
					while($fRes=$con->fetchRow($resOpt))
					{
						if($dibujaFila==1)
						{
							$etiqueta.='<tr height="23">';
							$dibujaFila=0;
						}

						if(existeRegistro($fRes[0],$resTabla))
						{
							
							$etiqueta.='<td width="'.$anchoCelda.'" class="'.$claseRespuesta.'"><span name="sp_'.$fElemento[0].'_'.$fRes[0].'" id="sp_'.$fElemento[0].'_'.$fRes[0].'" funcRenderer="'.$funcionRenderer.'">'.$fRes[1].'</span></td><td width="20"></td>';
							$nCol++;
							if($funcionRenderer!="")
							{
								$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',-1,'sp_".$fElemento[0]."_".$fRes[0]."',".$fElemento[0].");";
							}
						}
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$dibujaFila=1;
							$nCol=0;
						}
					}
					$etiqueta.="</table></div><input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'> <input type='hidden' id='".$nombreControl."' val='min' name='".$nombreControl."' tipo='checkBox'  minSel='".$fConfCampo[10]."'  value='".$arrNomTabla[0]."_".$nControlSinSuf."' controlF='".$primerElemento."'>";
					
				break;
				case 18:
					$etiqueta="<div id='span".$nombreControl."'><table >";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$nControlSinSuf=str_replace("[","",$nControlSinSuf);
					$nControlSinSuf=str_replace("]","",$nControlSinSuf);
					$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					
					$resTabla=$con->obtenerFilas($queryTabla);
					$dibujaFila=1;
					if($filaE[2]<$filaE[3])
					{
						for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
						{
							if($dibujaFila==1)
							{
								$etiqueta.='<tr height="23">';
								$dibujaFila=0;
							}
							if(existeRegistro($x,$resTabla))
							{
	
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$claseRespuesta.'"><span name="sp_'.$fElemento[0].'_'.$x.'" id="sp_'.$fElemento[0].'_'.$x.'" funcRenderer="'.$funcionRenderer.'">'.removerCerosDerecha($x).'</span></td><td width="20"></td>';
								$nCol++;
								if($funcionRenderer!="")
								{
									$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',-1,'sp_".$fElemento[0]."_".$x."',".$fElemento[0].");";
								}
							}
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$dibujaFila=1;
								$nCol=0;
							}
						}
					}
					else
					{
						for($x=$filaE[2];$x>=$filaE[3];$x-=$filaE[4])
						{
							if($dibujaFila==1)
							{
								$etiqueta.='<tr height="23">';
								$dibujaFila=0;
							}
							if(existeRegistro($x,$resTabla))
							{
	
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$claseRespuesta.'"><span name="sp_'.$fElemento[0].'_'.$x.'" id="sp_'.$fElemento[0].'_'.$x.'" funcRenderer="'.$funcionRenderer.'">'.removerCerosDerecha($x).'</span></td><td width="20"></td>';
								$nCol++;
								if($funcionRenderer!="")
								{
									$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',-1,'sp_".$fElemento[0]."_".$x."',".$fElemento[0].");";
								}
							}
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$dibujaFila=1;
								$nCol=0;
							}
						}
					}
					$etiqueta.="</table></div>";
					
				break;
				case 19:
					$etiqueta="<div id='span".$nombreControl."'><table >";
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($consulta);
					
					$queryOpt="select distinct ".$filaE[4].",".$filaE[3]." from ".$filaE[2]." order by ".$filaE[3];
					$tablaOD=$filaE[2];
					$campoId=$filaE[4];
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$obtenerOpciones=true;
					$arrElemento=NULL;
					$condWhere="";
					while($filaFiltro=$con->fetchRow($resFiltro))
						$condWhere.=str_replace('@codigoUnidad',$_SESSION["codigoInstitucion"],$filaFiltro[0])." ";
					if($condWhere!="")
						$condWhere=" where ".$condWhere;
					if(strpos($tablaOD,"[")===false)
					{
						$queryOpt="select ".str_replace('"',"",$filaE[4]).",".str_replace('"',"",$filaE[3])." from ".$filaE[2]." ".$condWhere."  order by ".$filaE[3];
						
					}
					else
					{
						$tablaOD=str_replace("[","",$tablaOD);
						$tablaOD=str_replace("]","",$tablaOD);
						$arrCamposProy=explode('@@',$filaE[3]);
						if($arrQueries[$tablaOD]["ejecutado"]==1)
						{
							$resQuery=$arrQueries[$tablaOD]["resultado"];
							$conAux=$arrQueries[$tablaOD]["conector"];
							$conAux->inicializarRecurso($resQuery);	
							$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'"}';
							$obj=json_decode($cadObj);
							$obj->resQuery=$resQuery;
							$obj->idAlmacen=$tablaOD;
							$obj->arrCamposProy=$arrCamposProy;
							$obj->conector=$conAux;
							$arrElemento=generarFormatoOpcionesQuery($obj);
							$obtenerOpciones=false;
							
						}
						else
						{
							if((strlen($arrQueries[$tablaOD]["arrParamControl"])>0)&&($idRegistro!=-1))
							{
								$queryTmp=$arrQueries[$tablaOD]["query"];
								$arrControles=explode(",",$arrQueries[$tablaOD]["arrParamControl"]);
								foreach($arrControles as $ctrl)
								{
									$queryTmp2="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='".$ctrl."' AND tipoElemento<>1";
									$idCtrlParam=$con->obtenerValor($queryTmp2);
									$queryTmp=str_replace("@Control_".$idCtrlParam,$arrColumnasDatos[$ctrl],$queryTmp);
									
									
								}
								$conAux=$arrQueries[$tablaOD]["conector"];
								$resQuery=$conAux->obtenerFilas($queryTmp);
								if($conAux->filasAfectadas>0)
								{
									$conAux->inicializarRecurso($resQuery);	
									$cadObj='{"queryReemplazo":"","conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'"}';
									$obj=json_decode($cadObj);
									$obj->resQuery=$resQuery;
									$obj->idAlmacen=$tablaOD;
									$obj->arrCamposProy=$arrCamposProy;
									$obj->itemSelect=$valorCelda;
									$obj->conector=$conAux;
									$obj->queryReemplazo=$queryTmp;
									$arrElemento=generarFormatoOpcionesQuery($obj);
								}
							}
							$obtenerOpciones=false;
						}
					}
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf=str_replace("]","",str_replace("[","",substr( $nombreControl,1,sizeof($nombreControl)-4)));
					$nControlSinSuf=str_replace("[","",$nControlSinSuf);
					$nControlSinSuf=str_replace("]","",$nControlSinSuf);
					$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					
					$resTabla=$con->obtenerFilas($queryTabla);
					$dibujaFila=1;
					$nCol=0;
					if($obtenerOpciones)	
					{
						$resOpt=$con->obtenerFilas($queryOpt);
						
						while($fRes=$con->fetchRow($resOpt))
						{
							if($dibujaFila==1)
							{
								$etiqueta.='<tr height="23">';
								$dibujaFila=0;
							}
	
							if(existeRegistro($fRes[0],$resTabla))
							{
								
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$claseRespuesta.'"><span name="sp_'.$fElemento[0].'_'.$fRes[0].'" id="sp_'.$fElemento[0].'_'.$fRes[0].'" funcRenderer="'.$funcionRenderer.'">'.$fRes[1].'</span></td><td width="20"></td>';
								$nCol++;
								if($funcionRenderer!="")
								{
									$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',-1,'sp_".$fElemento[0]."_".$fRes[0]."',".$fElemento[0].");";
								}
							}
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$dibujaFila=1;
								$nCol=0;
							}
						}
					}
					else
					{
						if($arrElemento!=NULL)	
						{
							foreach($arrElemento as $e)
							{
								if($dibujaFila==1)
								{
									$etiqueta.='<tr height="23">';
									$dibujaFila=0;
								}
		
								if(existeRegistro($e[0],$resTabla))
								{
									
									$etiqueta.='<td width="'.$anchoCelda.'" class="'.$claseRespuesta.'"><span name="sp_'.$fElemento[0].'_'.$e[0].'" id="sp_'.$fElemento[0].'_'.$e[0].'" funcRenderer="'.$funcionRenderer.'">'.$e[1].'</span></td><td width="20"></td>';
									$nCol++;
									if($funcionRenderer!="")
									{
										$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',-1,'sp_".$fElemento[0]."_".$e[0]."',".$fElemento[0].");";
									}
								}
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$dibujaFila=1;
									$nCol=0;
								}
							}
						}
					}
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$etiqueta.="</table></div>";
					
				break;
				case 21: //Hora
					if($valorCelda!="")
						$valorCelda=date("h:i A",strtotime($valorCelda));
					$etiqueta= "<div class='".$claseRespuesta."'  id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div  id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}	
						
				break;
				case 22:
					$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<div class='".$filaE[13]."' id='".$nombreControl."'  id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$valorCelda."</div>";
					if($valorCelda=="")
						$etiqueta="<div  id='".$nombreControl."'  id='sp_".$fElemento[0]."' funcRenderer='".$funcionRenderer."'>".$valorCelda."</div>";
					$truncar='false';
					if($filaE[5]=="2")
						$truncar='true';
					$funcionesJava.="var fValor=formatearNumero('".$valorCelda."','".$filaE[2]."','".$filaE[4]."','".$filaE[3]."',".$truncar.");
									reemplazarEtiqueta('".$nombreControl."',fValor,'".$filaE[13]."');";
					
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'sp_".$fElemento[0]."',".$fElemento[0].");";
					}
				break;
				case 23: //Imagen
					$nombreControl=str_replace("_","",$nombreControl);
					$etiqueta= "<div  id='_img".$fElemento[0]."' enlace='".$filaE[5]."'>".$HRef."<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>".$cHRef."</div>";
					/*$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$nombreControl=str_replace("[","",$nombreControl);
					$nombreControl=str_replace("]","",$nombreControl);												 
					$etiqueta= "<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";*/
							
				break;
				case 24: //Moneda
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($valorCelda=="")
						$valorCelda="0";
					$filaE=$con->obtenerPrimeraFila($consulta);
					$sepDecimales=$filaE[4];
					$sepMiles=$filaE[3];
					$nDecimales=$filaE[2];
					//$cadNDecimales=generarCadenaRepetible("0",$nDecimales);
					//$mascara="#,###".$sepDecimales.$cadNDecimales;
					
					$valorCelda="$ ".number_format($valorCelda,$nDecimales,$sepDecimales,$sepMiles);					
					$etiqueta= "<div class='".$claseRespuesta."' id='".$nombreControlOriginal."'   funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					if($valorCelda=="")
						$etiqueta= "<div  id='".$nombreControlOriginal."'  funcRenderer='".$funcionRenderer."'>".$HRef.$valorCelda.$cHRef."</div>";
					
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',0,'".$nombreControlOriginal."',".$fElemento[0].");";
					}
				break;
				case 25: //Fecha/hora
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$anchoCtrl=$filaE[2];
						$formato=$filaE[3];
						$origenHora=$filaE[4];
						
						$etiqueta= "<input funcRenderer='".$filaE[19]."' type='text' readOnly=true name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."'  size='".$anchoCtrl."' class='".$filaE[13]."'>";
						
						
						
					break;
				case 29:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<span id='contenedorSpanGrid_".$fElemento[0]."' permiteModificar='".$filaE[5]."' permiteEliminar='".$filaE[6]."' val='".$val."'><span id='spanGrid_".$fElemento[0]."'></span></span>";
					$consulta="SELECT * FROM 9039_configuracionesColumnasCampoGrid WHERE idElemento=".$fElemento[0]." order by orden";

					$resConf=$con->obtenerFilas($consulta);
					$arrCampos="{name: 'idRegistro'},{name: 'idReferencia'}";
					$arrCabeceras="";
					$mPermisos="";
					$visible='true';
					$nTabla=$filaE[4];
					$camposQuerySelect="id_".$nTabla." as idRegistro,idReferencia";
					while($filaConf=$con->fetchRow($resConf))
					{
						if($filaConf[6]!=12)
							$camposQuerySelect.=",".$filaConf[3];
						else
						{
							$camposQuerySelect.=",(if(".$filaConf[3]." is null,'',concat((select nomArchivoOriginal FROM 908_archivos WHERE idArchivo=t.".$filaConf[3]."),'|',".$filaConf[3].")))";
						}
						$confComp="";
						
						$asterisco="";
						$tipoCampo=$filaConf[6];
						$editorColumn="null";
						$rendererCtrl="function(val)
										{
											return val;	
										}";
						switch($tipoCampo)
						{
							case 1: //Entero
								$confComp=",css:'text-align:right;'";
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:false})";
								$rendererCtrl="function (val,meta,registro,fila,columna)
												{
													return Ext.util.Format.number(val,'0,000');
												}";
							break;
							case 2: //Decimal
								$confComp=",css:'text-align:right;'";
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true,decimalPrecision:4 })";
								$rendererCtrl="function (val,meta,registro,fila,columna)
												{
													return removerCerosDerecha(Ext.util.Format.number(val,'0,000.0000')+'');
													//return Ext.util.Format.number(val,'0,000.0000');
												}";
							break;
							case 3:  //texto
								$editorColumn="new Ext.form.TextField({id:'editor_".$filaConf[3]."'})";
							break;
							case 4:  //Vinculado a tabla
								$tabla=$filaConf[8];
								$campoProy=$filaConf[10];
								$campoLlave=$filaConf[12];
								$consulta="select ".$campoLlave.",".$campoProy." from ".$tabla." order by ".$campoProy;
								$arrOpciones=$con->obtenerFilasArreglo($consulta);
								$editorColumn="crearComboExt('editor_".$filaConf[3]."',".$arrOpciones.",0,0,null,{ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'})";
								$rendererCtrl="function (val,meta,registro,fila,columna,almacen)
												{
													var almacen=gEx('editor_".$filaConf[3]."').getStore();
													var pos=obtenerPosFila(almacen,'id',val);
													if(pos!=-1)
														return almacen.getAt(pos).get('nombre');
													else
														return val;
												}";
							break;
							case 5:  //Moneda
								$confComp=",css:'text-align:right;'";
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true})";
								$rendererCtrl="'usMoney'";
							break;
							case 6:	//Fecha
								$editorColumn="new Ext.form.DateField({id:'editor_".$filaConf[3]."',format:'d/m/Y'})";
								$rendererCtrl="function (val,meta,registro,fila,columna)
												{
													if((val=='')||(val=='0000-00-00'))
														return '';
													else
														if(val instanceof Date)
															return val.format('d/m/Y');
														else
														
															return convertirCadenaFecha(val).format('d/m/Y');
												}";
							break;
							case 7:	//Hora
								$editorColumn="crearCampoHoraExt('editor_".$filaConf[3]."')";
								$rendererCtrl="function (val,meta,registro,fila,columna,almacen)
														{
															var pos=obtenerPosFila(almacen,'id',val);
															if(pos!=-1)
																return almacen.getAt(pos).get('nombre');
															else
																return val;		
														}";
							break;	
							case 10: //Almacen de datos
									$tablaOD=$filaConf[8];
									$campoProy=$filaConf[10];
									$campoLlave=$filaConf[12];
									$arrElemento='[]';
									if($arrQueries[$tablaOD]["ejecutado"]==1)
									{
										$resQuery=$arrQueries[$tablaOD]["resultado"];
										$conAux=$arrQueries[$tablaOD]["conector"];
										$conAux->inicializarRecurso($resQuery);	
										$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"1","imprimir":"0","campoID":"'.$campoLlave.'"}';
										$obj=json_decode($cadObj);
										$obj->resQuery=$resQuery;
										$obj->idAlmacen=$tablaOD;
										$obj->arrCamposProy[0]=$campoProy;
										$obj->conector=$conAux;
										$arrElemento=generarFormatoOpcionesQuery($obj);
										
									}
									$arrOpciones="[".$arrElemento."]";
									
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														var almacen=[".$arrElemento."];
														var pos=existeValorMatriz(almacen,val);
														
														if(pos!=-1)
															return almacen[pos][1];
														else
															return val;
													}";
							break;
							case 11:
									$editorColumn="{xtype:'checkbox'}";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														if((val)&&(val=='1'))
															return \"<img src='../images/icon_big_tick.gif' height='12' width='12'>\";
														else
															return \"<img src='../images/cross.png' height='12' width='12'>\";
														
													}";
							break;
							case 12: //Archivo
									$rendererCtrl="textoBotonRenderer";
								break;
							case 14:	//Area de texto
									
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return '<div style=\"width:100%\">'+cvTextArea(val)+'</div>';
													}";
									
								break;
						}
						
						if($filaConf[7]=="1")
							$asterisco=' <font color="red">*</font>';
						$oculto='false';
						if($filaConf[14]=="0")
						{
							$oculto='true';
							$asterisco="";
						}
						$sumary="";
						switch($filaConf[16])											
							{
								case "1":
									$sumary=",summaryType: 'max'";
								break;
								case "2":
									$sumary=",summaryType: 'min'";
								break;
								case "3":
									$sumary=",summaryType: 'count'";
								break;
								case "4":
									$sumary=",summaryType: 'average'";
								break;
								case "5":
									$sumary=",summaryType: 'sum'";
								break;
								case "6":
									$sumary=",summaryRenderer: function()
																{
																	return '".$filaConf[18]."';
																}";
								break;
									
							}
							
							switch($filaConf[17])											
							{
								case "1": //Moneda
									$confComp=",css:'text-align:right;'";
									$rendererCtrl="'usMoney'";
								break;
								case "2": //num Entero
									$confComp=",css:'text-align:right;'";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return Ext.util.Format.number(val,'0,000');
													}";
								break;
								case "3": //Num decimal
									$confComp=",css:'text-align:right;'";
									$nDecimales=$filaConf[20];
									if(($nDecimales=="")||($nDecimales=="0"))
										$nDecimales=4;
									$cadDecimales=".".str_pad("",$nDecimales,"0",STR_PAD_RIGHT);
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return removerCerosDerecha(Ext.util.Format.number(val,'0,000".$cadDecimales."')+'');
													}";
								break;
							}
							
						$arrCampos.=",{name:'".$filaConf[3]."'}";
						$objCabecera="{
															header:'".$filaConf[4].$asterisco."',
															width:".$filaConf[5].",
															sortable:true,
															menuDisabled :true,
															dataIndex:'".$filaConf[3]."',
															hidden:".$oculto.",
															editor:".$editorColumn.$confComp.",
															renderer:".$rendererCtrl.$sumary."
										}";
						if($arrCabeceras=="")
							$arrCabeceras=$objCabecera;
						else
							$arrCabeceras.=",".$objCabecera;
							
					}
					$arrCampos="[".$arrCampos."]";
					$arrCabeceras="[".$arrCabeceras."]";
					$habilitado="false";
					
					if($filaE[13]==0)
						$habilitado="true";
					
					$funcionesJava.='var objConf={"etAgregar":"'.$filaE[9].'","etRemover":"'.$filaE[10].'"';
					
					
					$estilo=$fConfiguracionElemento["campoConf12"];
					if($estilo!="")
					{
						$funcionesJava.=',"ctCls":"'.$estilo.'"';
					}
						
						$funcionesJava.='};';
					
					$consulta="select ".$camposQuerySelect." from ".$nTabla." t where idReferencia=".$idRegistro." order by id_".$nTabla;;

					$arrDatosGrid=$con->obtenerFilasArreglo($consulta);

					$funcionesJava.="crearCampoGridFormularioEjecucion(".$fElemento[0].",'grid_".$fElemento[0]."','spanGrid_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.",".$visible.",".$arrDatosGrid.",objConf);";
					
				break;
				case 31:
						
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];

						$filaE=$con->obtenerPrimeraFila($consulta);
						$HRef="";
						$cHRef="";
						if($filaE[5]!="")
						{
							$HRef=generarEnlaceEtiqueta($filaE[5],$fElemento[0],$arrValoresParametros);
							$cHRef="</a>";
						}
						$valor="";
						
						if($idRegistro=="-1")
						{
							eval('if(isset($objParametros->'.$filaE[4].')) $valor=$objParametros->'.$filaE[4].'; else $valor="N/E";');
						}
						else
						{
							$valor=$valorCelda;
						}
						$query="select campoConf12 from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
						$claseRespuesta=$con->obtenerValor($query);
						$etiqueta="<div class='".$claseRespuesta."' id='_".$fElemento[1]."vch' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$fElemento[0].'">'.convertirEnterToBR($valor)."</span>".$cHRef."</div>";
						if($valorCelda=="")
							$etiqueta="<div id='_".$fElemento[1]."vch' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$fElemento[0].'">'.$valor."</span>".$cHRef."</div>";
						
					break;
				case 33: //galeria Imagenes
					$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$arregloGaleria="";
					$consulta="SELECT idArchivoImagen,a.tamano,a.nomArchivoOriginal FROM 9058_imagenesControlGaleria i,908_archivos a 
								WHERE idElementoFormulario=".$fElemento[0]." and idRegistro=".$idRegistro." and  a.idArchivo=i.idArchivoImagen order by idImagenGaleria";

					$resGaleria=$con->obtenerFilas($consulta);
					while($fGaleria=$con->fetchRow($resGaleria))
					{
						$o='{"imagen":"../documentosUsr/archivo_'.$fGaleria[0].'","idArchivo":"'.$fGaleria[0].'","tamano":"'.$fGaleria[1].'","nombreArchivo":"'.cv($fGaleria[2]).'"}';
						if($arregloGaleria=="")
							$arregloGaleria=$o;
						else
							$arregloGaleria.=",".$o;
					}
					
					if($arregloGaleria=="")
						$arregloGaleria='{"imagen":"../images/imgNoDisponible.jpg","idArchivo":"-1","tamano":"0","nombreArchivo":""}';
						
					$etiqueta="<span name='galeriaDocumento' idCtrl='".$fElemento[0]."' id='_lbl".$fElemento[0]."'><span id='sp_".$fElemento[0]."' ancho='".$filaE[2]."' alto='".$filaE[3]."' arrElementos='".bE("[".$arregloGaleria."]")."'></span><span style='position:relative;top:-40px;left:".($filaE[2]-20)."px;z-index:10;'></span></span>";
					
					$funcionesJava.="generarGaleriaImagen([".$arregloGaleria."],".$fElemento[0].",".$filaE[2].",".$filaE[3].");";
				break;
			}	
			/*$ayuda="";
			if($msgAyuda!="")
				$ayuda='&nbsp;&nbsp;<img id="imgAyuda_'.$fElemento[0].'" src="../images/formularios/sInterrogacion.jpg" height="16" width="16" alt="'.$msgAyuda.'" title="'.$msgAyuda.'">';
			]*/
			
			$ayuda="";
			if($msgAyuda!="")
			{
				$ayuda='&nbsp;&nbsp;<span data-ot="'.htmlentities($msgAyuda).'" data-ot-border-width="2" data-ot-stem-length="18" data-ot-stem-base="20" data-ot-tip-joint="top" data-ot-border-color="#317CC5" data-ot-style="glass" ><img id="imgAyuda_'.$fElemento[0].'" src="../images/question.png" height="16" width="16"></span>';
			}
			
			$tabla=	 "	<table>
    						<tr>
								<td valign='top'>".$asteriscoRojo."</td>
                    			<td>".$etiqueta."</td>
								<td>".$ayuda."</td>
                    		</tr>
    					</table>";
			if($fElemento[2]=='-2')
			{
				$fElemento[4]=100;
				$fElemento[5]=270;
			}
			$div="<div id='div_".$fElemento[0]."'  style='top:".$fElemento[5]."px; left:".$fElemento[4]."px; position:absolute;".$estiloAdicional."'>".$tabla."</div>";			
			echo $div;	
			if($fElemento[2]!='-2')
			{
				if($calibrarCtrl=="")
					$calibrarCtrl="['div_".$fElemento[0]."']";
				else
					$calibrarCtrl.=",['div_".$fElemento[0]."']";
			}
			$cc++;
		}
		
		$consulta="SELECT idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,orden FROM 901_elementosFormulario WHERE tipoElemento  IN (31) AND idFormulario=".$idFormulario." ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$valorCelda=$arrColumnasDatos[$fila[1]];	
			
			echo '<input type="hidden" name="_'.$fila[1].'vch" value="'.$valorCelda.'">';
		}
}

function existeRegistro($valor,$res)
{
	global $con;
	if($con->numRows($res)==0)
		return false;
	$con->dataSeek($res,0);
	while($fila=$con->fetchRow($res))
	{
		if($valor==$fila[0])
			return true;
	}
	return false;
}

function obtenerValorSesion($tipoValor)
{
	switch($tipoValor)
	{
		case 1:
			return $_SESSION["leng"];
		break;
		case 2:
			return $_SESSION["idRol"];
		break;
		case 3:
			return $_SESSION["idUsr"];
		break;
		case 4:
			return $_SESSION["login"];
		break;
		case 5:
			return $_SESSION["nombreUsr"];
		break;
		case 6:
			return date('Y-m-d');
		break;
		case 7:
			return date("G:H:s");
		break;
	}
}

function obtenerEtapaRegistroBase($idRegistro,$idFormulario,$nombreTablaBase,$idFormularioBase)
{
	global $con;
	$consulta="";
	if($idFormulario==$idFormularioBase)
	{
		$consulta="select idEstado from ".$nombreTablaBase." where id_".$nombreTablaBase."=".$idRegistro;
		$idEtapa=$con->obtenerValor($consulta);
		return $idEtapa;
	}
	else
	{
		$consulta="select nombreTabla,idFrmEntidad from 900_formularios where idFormulario=".$idFormulario;
		$fRes=$con->obtenerPrimeraFila($consulta);
		$nombreTabla=$fRes[0];
		$frmEntidad=$fRes[1];

		$consulta="select idReferencia from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
		$idRef=$con->obtenerValor($consulta);
		if($idRef!="-1")
			return obtenerEtapaRegistroBase($idRef,$frmEntidad,$nombreTablaBase,$idFormularioBase);
		else
		{
			$consulta="select idEstado from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
			$idEtapa=$con->obtenerValor($consulta);
			return $idEtapa;
		}
	}
}

function conDisparador($idFormulario)
{
	global $con;
	$consulta="select idDisparador from 911_disparadores where idFormulario=".$idFormulario;
	$idDisparador=$con->obtenerValor($consulta);
	if($idDisparador=="")
	{
		$consulta="select idFormulario from 900_formularios where idFrmEntidad=".$idFormulario;
		$res=$con->obtenerFilas($consulta);
		if($con->filasAfectadas>0)
		{
			while($filas=$con->fetchRow($res))
			{
				return conDisparador($filas[0]);
			}
		}
		return false;
	}
	else
		return true;
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
	$mostrarMenuIzq=false;
	$paramGET=true;
	$evitarMarcos=false;
	if((isset($_POST["eliminarEspacios"]))||(isset($_GET["eliminarEspacios"])))
		$evitarMarcos=true;
?>
<style>
<?php
	
	if($evitarMarcos)
	{
	?>
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
	<?php
	}
	?>
	
	.x-window
	{
		z-index:11501 !important;
	}
	.ext-el-mask
	{
		z-index:11500 !important;
	}
	.x-combo-list
	{
		z-index:11510 !important;
	}
	.x-shadow
	{
		z-index:11501 !important;
	}
	
	
	#sticky 
	{
		position: fixed;
		top: 5px;
		width: 97%;
		background-color: #F5F5F5;
		z-index:10000;
		text-align:center;
		
	}
	
	@font-face
	{
		font-family:'Lato-Regular';
		src: local('Lato-Regular');
		src: url('../fuentes/Lato2OFL/Lato-Regular.ttf');
		src: url('../fuentes/Lato2OFL/Lato-Regular.ttf?#iefix') format('embedded-opentype'),
		
		
	}
	
	@font-face
	{
		font-family:'Lato-Bold';
		src: local('Lato-Bold');
		src: url('../fuentes/Lato2OFL/Lato-Bold.ttf');
		src: url('../fuentes/Lato2OFL/Lato-Bold.ttf?#iefix') format('embedded-opentype'),
		
		
	}
	
</style>
<!-- InstanceEndEditable -->

<?php



$arrValores=array();
$arrLlaves=array();
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


$ctParams=count($arrLlaves);
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
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GridSummary.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/GridSummary.js"></script>

<script type="text/javascript" src="../Scripts/ux/checkColumn.js"></script>

<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
<script type="text/javascript" src="../Scripts/masks.js"></script>
<script type="text/javascript" src="../modeloPerfiles/Scripts/funcionesFormulario.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/cleanSlider/resources/cleanSlider.css"/>
<script type="text/javascript" src="../Scripts/cleanSlider/resources/jquery.cleanSlider.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos/dataView.css" media="screen" />
<script src="../Scripts/cImagen.js.php"></script>
<script type="text/javascript" src="../modeloPerfiles/Scripts/galeriaImagenes.js.php"></script>

<link rel="stylesheet" type="text/css" href="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/opentip/opentip.css" media="screen" />

<script type="text/javascript" src="../Scripts/opentip/opentip-jquery-excanvas.min.js"></script>


<?php

	

	$paramGET=true;
	$guardarConfSession=true;
	
?>
<script src="../Scripts/ckeditor/ckeditor.js" ></script>
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
	while($procesoRow=$con->fetchRow($procesoResult))
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
                   		<?php
						
							$alineacion="left";
							/*if(isset($objParametros->cPagina))
								$alineacion="left";
								*/
							$consulta="select idEtapa,configuracionFormulario,titulo from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($consulta);
							$idEtapa=$fila[0];
							$configuracionFormulario=$fila[1];	
							
							$tituloModulo=$fila[2]. " [<span style='color:#000'>Ficha</span>]";
							$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;

							
						?>
                   
	                   <td align="<?php echo $alineacion?>">
                       <script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>
                       <script type="text/javascript" src="../modeloPerfiles/Scripts/registroFormularioV2.js.php?iF=<?php echo bE($objParametros->idFormulario)?>"></script>
						<script type="text/javascript" src="../modeloPerfiles/Scripts/verFichaFormularioV2.js.php"></script>
                       <?php
					   		$idRegistro="-1";
							$idRegistroG="-1";
							$idFormulario="-1";
							$idReferencia="-1";
							
							if($objParametros!=null)
							{
								if(isset($objParametros->idFormulario))
									$idFormulario=$objParametros->idFormulario;
							}
							
							if(isset($objParametros->idRegistro))
							{
								$idRegistro=$objParametros->idRegistro;			
								$idRegistroG=$objParametros->idRegistro;			
							}
							
							if(isset($objParametros->idReferencia))
								$idReferencia=$objParametros->idReferencia;			
							
					   		if(isset($objParametros->formularioNormal))
							{
								echo formatearTituloPagina($tituloModulo,false,0,"left",false);
							}
							
					   		if($configuracionFormulario!="")
							{
								$objConf=json_decode($configuracionFormulario);

								if(isset($objConf->paginasScripts))
								{
									$arrPaginas=explode(",",$objConf->paginasScripts);
									if(sizeof($arrPagina)>0)
									{
										foreach($arrPaginas as $p)
										{
											echo '<script type="text/javascript" src="'.$p.'?iF='.bE($idFormulario).'&m=1&iR='.bE($idRegistroG).'&iRef='.$idReferencia.'"></script>';
										}
									}
								}
							}
							
							$pComp="";
							if(isset($objParametros->pComp))
								$pComp=$objParametros->pComp;
								
							if(isset($pathScriptsPaginasDinamicas)&&($pathScriptsPaginasDinamicas!=""))
							{
								$idFormulario=obtenerValorParametro("idFormulario","");
								$pathScript=str_replace("../","",$pathScriptsPaginasDinamicas);
								$rutaScriptBase1=$baseDir."/".$pathScript.'/_'.$idFormulario.'_tablaDinamica'.$tipoMateria.'.js.php';
								$rutaScriptBase2=$baseDir."/".$pathScript.'/_'.$idFormulario.'_tablaDinamica.js.php';
						
								if(file_exists($rutaScriptBase1))
									echo '<script type="text/javascript" src="'.$pathScriptsPaginasDinamicas.'/_'.$idFormulario.'_tablaDinamica'.$tipoMateria.'.js.php?iPP='.bE(isset($objParametros->idProcesoP)?$objParametros->idProcesoP:-1).'&iF='.bE($idFormulario).'&m=1&iR='.bE($idRegistroG).'&iRef='.$idReferencia.'&pComp='.$pComp.'"></script>';
								else
									if(file_exists($rutaScriptBase2))
										echo '<script type="text/javascript" src="'.$pathScriptsPaginasDinamicas.'/_'.$idFormulario.'_tablaDinamica.js.php?iPP='.bE(isset($objParametros->idProcesoP)?$objParametros->idProcesoP:-1).'&iF='.bE($idFormulario).'&m=1&iR='.bE($idRegistroG).'&iRef='.$idReferencia.'&pComp='.$pComp.'"></script>';
							}
							
							
							
							$consulta="SELECT DISTINCT archivoJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
							$resScript=$con->obtenerFilas($consulta);
							while($fScript=$con->fetchRow($resScript))
							{
								echo '<script type="text/javascript" src="'.$fScript[0].'?iF='.bE($idFormulario).'&m=1&iR='.bE($idRegistroG).'&iRef='.$idReferencia.'&pComp='.$pComp.'"></script>';
							}


					   ?>
                       
                       
                       
                   		<table>
                        <tr>
                        
                   		<?php
						
						$actorProceso="";
						if(isset($objParametros->actor))
							$actorProceso=$objParametros->actor;
						
						
						$eJE="";
						if(isset($objParametros->eJE))
							$eJE=$objParametros->eJE;
						
						$eJs="";
						if(isset($objParametros->eJs))
							$eJs=$objParametros->eJs;
						
						$idReferencia="-1";
						if(isset($objParametros->idReferencia))
							$idReferencia=$objParametros->idReferencia;
						if($idRegistro!="-1")
						{
							$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;

							$idReferencia=$con->obtenerValor($consulta);
						}
						
						$arrValoresReemplazo[0][0]="@formulario";
						$arrValoresReemplazo[0][1]=$idFormulario;
						$arrValoresReemplazo[1][0]="@registro";
						$arrValoresReemplazo[1][1]=$idRegistro;
						
						
						$pConsulta=false;
						$pModificar=false;
						$pEliminar=false;
						$pCancelar=false;
						$mostrarSinPermisos=false;
						$ignorarValidacionPermisos=0;
						if(isset($objParametros->ignoraPermisos))
							$ignorarValidacionPermisos=$objParametros->ignoraPermisos;
							
						if($ignorarValidacionPermisos==0)
						{	
							$consulta="select p.idTipoProceso from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso and f.idFormulario=".$idFormulario;
							$tipoProceso=$con->obtenerValor($consulta);
							if((($tipoProceso==1)||($tipoProceso==2))&&(!isset($objParametros->sLectura)||($objParametros->sLectura==0)))
							{
							
								$consulta="select permisos from 4002_rolesVSEtapas where etapa=".$idEtapa." and idRol in(".$_SESSION["idRol"].")";
								$res=$con->obtenerFilas($consulta);
								while($fila=$con->fetchRow($res))
								{
									$permisos=$fila[0];
									if(!(strpos($permisos,"C")===false))
										$pConsulta=true;
									if(!(strpos($permisos,"M")===false))
										$pModificar=true;
									if(!(strpos($permisos,"E")===false))
										$pEliminar=true;
								}
								
								if(!$pConsulta)
								{
									$mostrarSinPermisos=true;
									$mostrarMenuIzq=false;
									$mostrarRegresar=false;
								}
							}
						
						}
						else
							$mostrarSinPermisos=false;
							
							
							
							
						$respetarEspacioRegresar=true;
						$funcionesJava="";
						$funcionesJavaInicio="";
						$idEstado='-1';
						$consulta="select vf.nombreTabla,f.estadoInicial,vf.anchoGrid,vf.altoGrid,vf.mostrarMarco from 939_configuracionVistaFormularios vf,900_formularios f  where f.idFormulario=vf.idFormulario and  vf.idFormulario=".$idFormulario;
						$fila=$con->obtenerPrimeraFila($consulta);
						$nombreTabla=$fila[0];
						$idEstado=$fila[1];
						$anchoGrid=$fila[2];
						$altoGrid=$fila[3];
						$mMarco=$fila[4];
						if(isset($objParametros->ocultarMarco))
							$mMarco=0;
						
						
						$idProceso=obtenerIdProcesoFormulario($idFormulario);
						$arrColumnasDatos;
						$numEtapaPadre=obtenerEtapaProcesoActual($idRegistro,$idReferencia,$idFormulario);
						$idUsuarioResp=obtenerResponsableProcesoActual($idRegistro,$idReferencia,$idFormulario);
						if($idUsuarioResp=="-1")
								$idUsuarioResp=$_SESSION["idUsr"];
						$cadParam="";
						$reflectionClase = new ReflectionObject($objParametros);
						foreach ($reflectionClase->getProperties() as $property => $value) 
						{
							$nombre=$value->getName();
							$valor=$value->getValue($objParametros);
							$o='"'.$nombre.'":"'.$valor.'"';
							if($cadParam=="")
								$cadParam=$o;
							else
								$cadParam.=",".$o;
						}
						$cadObj='{"paramAmbiente":{'.$cadParam.'},"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"'.$idRegistro.'","p4":"'.$numEtapaPadre.'","p5":"'.$idReferencia.'","p6":"'.$idUsuarioResp.'"}}';
						
						$paramObj=json_decode($cadObj);
						$arrQueries=resolverQueries($idFormulario,5,$paramObj,true);
						
						
						if($con->existeTabla($nombreTabla))
						{
							$existeT=1;
							$consulta="select * from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
							
							//echo $consulta;
							$res=$con->obtenerFilas($consulta);
							$numColumnas=$con->numFields($res);
							$filaDatos=$con->fetchRow($res);
							
							for($x=0;$x<$numColumnas;$x++)
							{
								$arrColumnasDatos[$con->fieldName($res,$x)]=$filaDatos[$x];			
							}
						}
						else
							$existeT=0;
						//if(isset($objParametros->paginaRedireccion))
							//$pagRegresar=$objParametros->paginaRedireccion;
					   		
                            if($mostrarSinPermisos)
                            {
                        ?>
                            <td align="left">
                                <fieldset class="frameHijo"><legend><b>SIN PRIVILEGIOS</b></legend>
                                <table width="100%"   >
                                    <tr>
                                        <td width="145">
                                            <img src="../images/prohibido.png" />
                                        </td>
                                        <td><span class="letraRoja"><font style="font-size:13px">Usted no cuenta con los permisos suficientes para ingresar a esta página.</font></span><span class="corpo8"><br />
                                        <br />
                                        </span>
                                            <span class="letraFicha"><font style="font-size:12px"><b>
                                            En breve será redireccionado a la página anterior...</b>
                                            </font>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                            <script>
                                setTimeout("history.back(1)",3000);
                            </script>
                            </td>
                        <?php
                            }
                            else
                            {	
								$consulta="select titulo,frmRepetible,idEtapa from 900_formularios where idFormulario=".$idFormulario;
								$filaForm=$con->obtenerPrimeraFila($consulta);
								$titulo=$filaForm[0];
								$repetible=$filaForm[1];
								$idEtapa=$filaForm[2];
								$btnModificar="";
								$btnEliminar="";
								
								/*if(!conDisparador($idFormulario))
								{
									if($pEliminar)
										$btnEliminar="&nbsp;<a href='javascript:eliminarRegistro(".$idRegistro.")'><img src='../images/cancel_round.png' alt='".$et["lblEliminarRegAct"]."' title='".$et["lblEliminarRegAct"]."'></a>";
									
									if($pModificar)
										$btnModificar="&nbsp;<a href='javascript:modificarRegistro(".$idRegistro.")'><img src='../images/edit_f2.png' height='16' width='16' alt='".$et["lblModificarRegAct"]."' title='".$et["lblModificarRegAct"]."'></a>";
								}*/
								
								if(isset($objParametros->pM))
									$pModificar=($objParametros->pM==1)?true:false;
								
								if(isset($objParametros->pE))
									$pEliminar=($objParametros->pE==1)?true:false;
								
								if(isset($objParametros->pC))
									$pCancelar=($objParametros->pC==1)?true:false;
								$consulta="select max(posY) from 901_elementosFormulario where idFormulario=".$idFormulario;
								$altura=$con->obtenerValor($consulta);
								$altura+=10;
								$claseFrame="frameHijo gridRejillaSinFondo";
								if($mMarco==0)
								{
									$titulo="";
									$claseFrame="gridRejillaSinFondo";
								}
							?>
                                <td align="left" height="<?php echo $altoGrid?>px" width="<?php echo $anchoGrid?>px" id='tdContenedor' valign="top"  >
                                	<?php
										/*if($pModificar||$pEliminar||$pCancelar)
											echo "<br /><br /><br /><br />";*/
									?>
                                	
                                    <fieldset class="<?php echo $claseFrame?>" id='frameTitulo' s style="height:<?php echo $altoGrid ?>px; width:<?php echo $anchoGrid ?>px" ><legend ><b><?php echo $titulo ?></b></legend>
                                    <span style="top:40px; position:absolute"><?php echo $btnModificar.$btnEliminar?></span>
                                   </fieldset>
                                   <?php
								   	
                                        crearElementosFormulario();
                                   ?>
                                </td>
                                <td >
                                	<input type="hidden" id='pEliminar' value="<?php echo ($pEliminar)?1:0 ?>" />
                                    <input type="hidden" id='pModificar' value="<?php echo ($pModificar)?1:0 ?>" />
                                    <input type="hidden" id='pCancelar' value="<?php echo ($pCancelar)?1:0 ?>" />
                                    <input type="hidden" id='idFormulario' value="<?php echo $idFormulario?>" />
                                    <input type="hidden" id='sL' value="1" />
                                    <input type="hidden" id='eJE' value="<?php echo $eJE?>" />
                                    <input type="hidden" id='eJs' value="<?php echo $eJs?>" />
                                    <input type="hidden" id='idRegistroG' value="<?php echo $idRegistro?>" />
                                    <input type="hidden" id="idReferencia" value="<?php echo $idReferencia?>" />
                                    <input type="hidden" name="hCtrlCalibrar" value="<?php echo bE("[".$calibrarCtrl."]")?>" id="hCtrlCalibrar" />
                                    <input type="hidden" name="actorProceso" value="<?php echo $actorProceso ?>" />
                                    <script>
									
                                       
                                     var arrFuncionesGridDeposito=new Object();
                                	function ejecutarFuncionesInicio()
									{
								<?php
										echo $arrConfiguraciones;
                                        echo $funcionesJava;
										echo $funcionesJavaInicio;
								?>
									}
									if((typeof(ejecutarInicializar)!='undefined')&&(ejecutarInicializar==1))
									{
										
										ejecutarFuncionesInicio();
									}
									ejecutarInicializar=1;
                                    </script>
                                     
                                </td>
                            <?php
							}
							?>
							</tr>
                        </table>
                        <?php
							if($pEliminar||$pModificar||$pCancelar)
							{
						?>
                         <div id="sticky" >
                         	<table width="100%">
                            <tr>
                            	<td align="center">
                                    <table>
                                        <tr>
                                            <td><span id="contenedor3"></span></td>
                                            <td width="20">
                                            </td>
                                            <td><span id="contenedor2"></span></td>
                                            <td width="20">
                                            </td>
                                            <td><span id="contenedor1"></span></td>
                                        </tr>
                                    </table>
                                </td>
                          	</tr>
                            </table>
                            
                          </div>
                         <?php
							}
						 ?>
                        
                        
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
