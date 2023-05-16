<?php 

$ignorarSesion=false;
if(isset($_POST["ignSesion"])||isset($_GET["ignSesion"]))	
	$ignorarSesion=true;
if(!$ignorarSesion)
	include("sesiones.php");
else
	session_start();
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

//return;


function resolverTokensGrid($tipoToken,$valorToken,$arrQueries,$objParametros,$objProceso)
{
	global $con;
	global $diccionario;
	$valor="NULL";
	switch($tipoToken)
	{
		case "0":  //Operadores y variables acumuladoras
		case "21":
			$valor='"'.$valorToken.'"';
		break;	
		case "1":  //Valor constante
			$valor='"'.$valorToken.'"';
		break;
		case 3:	//Valor de sesion
				$consulta="select valorSesion,valorReemplazo from 8003_valoresSesion where idValorSesion=".$valorToken;
				$filaSesion=$con->obtenerPrimeraFila($consulta);
				$valor='"'.$_SESSION[$filaSesion[0]].'"';
			break;
		case 4:	//Valor de sistema
				$datosConsulta=explode("|",$valorToken);
				switch($datosConsulta[1])
				{
					case "8":
						$valor='"'.date("Y-m-d").'"';
					break;
					case "9":
						$valor='"'.date("H:i").'"';
					break;
				}
		break;
		case 5: //Parametros registrados
		case 6:
			eval('$valParam=$objParametros->'.$valorToken.';');
			$valor='"'.$valParam.'"';
		break;
		case 7: //valor consulta auxilizar
			$datosConsulta=explode("|",$valorToken);
			if($arrQueries[$datosConsulta[0]]["ejecutado"]==1)
				$valor='"'.$arrQueries[$datosConsulta[0]]["resultado"].'"';
			else
				$valor='""';
		break;
		case 11: //valor almacen 
			$datosConsulta=explode("|",$valorToken);
			if($arrQueries[$datosConsulta[0]]["ejecutado"]==1)
			{
				$resultado=$arrQueries[$datosConsulta[0]]["resultado"];
				
				if(gettype ($arrQueries[$datosConsulta[0]]["resultado"])=="resource")
				{
					$conAux=$arrQueries[$datosConsulta[0]]["conector"];
					$conAux->inicializarRecurso($resultado);
					$filaRes=$conAux->obtenerSiguienteFilaAsoc($resultado);
					
					
					if(!$filaRes)
						$valor='""';
					else
					{
						$fila=convertirFilasAlmacenArrayAsoc($datosConsulta[0],$filaRes);		
						$valor='"'.$fila[$datosConsulta[1]].'"';
					}
				}
				else
				{
					$valor='"'.$resultado.'"';
				}
					
			}
			else
				$valor='""';
		break;
		case 16:

			switch($valorToken)
			{
				case 1:
					$valor='"'.$objProceso->p16->p1.'"';
				break;
				case 2:
					$valor='"'.$objProceso->p16->p2.'"';
				break;
				case 3:
					$valor='"'.$objProceso->p16->p3.'"';
				break;
				case 4:
					$valor='"'.$objProceso->p16->p4.'"';
				break;
				case 5:	
					$valor='"'.$objProceso->p16->p5.'"';
				break;
				case 6:
					$valor='"'.$objProceso->p16->p6.'"';
				break;	
			}
		break;
		case 22: //Invocacion a funcion
			$objFuncion=json_decode($valorToken);
			$arrParametros="";
			foreach($objFuncion->parametros as $param)
			{
				$oParametro=resolverValoresTokens($param->tipoValor,$param->valorSistema,$arrQueries,$objParametros);
				if($arrParametros=="")
					$arrParametros="'".$oParametro."'";	
				else
					$arrParametros.=",'".$oParametro."'";	
			}
			$valor='"'.eval($objFuncion->nFuncion."(".$arrParametros.")").'"';
		
		break;
		case 24: //Valor de fila grid
			$valor="\"'+registro.get('".$valorToken."')+'\"";
		break;
		case 25:
			$valor="\"'+obtenerValorCampo('".$diccionario[$valorToken][0]."')+'\"";
		break;
	}	
	return $valor;	
}

function elementoBloquedo($idElemento,$numEtapa)
{
	global $con;
	$consulta="select idElemento from 901_elementosBloqueados where (idElemento=".$idElemento." and numEtapa=".$numEtapa.") or (idElemento=".$idElemento." and numEtapa=-1)";
	$fila=$con->obtenerPrimeraFila($consulta);
	if($fila)
		return true;
	return false;
}

function crearElementosFormulario()
{
		global $funcionesControles;
		global $funcionesJava;
		global $funcionesJavaInicio;
		global $funcionesDisparadores;
		global $con;
		global $et;
		global $idFormulario;
		global $existeT;
		global $arrColumnasDatos;
		global $nombreTabla;
		global $idRegistro;
		global $dependencias;
		global $pagRegresar;
		global $calibrarCtrl;
		global $arrConfiguraciones;
		global $arrValoresReemplazo;
		global $cc;
		global $dependencias;
		global $ctrlEnfocar;
		global $arrCamposGrid;
		global $idProcesoP;
		global $idReferencia;
		global $arrQueries;
		global $arrEnlacesControles;
		global $controlesQuery;
		global $controlesQueryNormalizado;
		global $scriptComplementario;
		global $diccionario;
		global $numEtapaPadre;
		global $paramObj;
		global $objParametros;
		global $idProceso;
		global $idUsuarioResp;
		global $ocultarBotonesAccion;
		
		$arrValoresParametros=array();
		$arrValoresParametros["idFormulario"]=$idFormulario;
		$arrValoresParametros["idRegistro"]=$idRegistro;
		$arrValoresParametros["idReferencia"]=$idReferencia;
		$arrValoresParametros["idProceso"]=$idProceso;
		$arrValoresParametros["idProcesoP"]=$idProcesoP;
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,visible from 901_elementosFormulario where tipoElemento in (1,13,30) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"];
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
			
			$visible="display:;";
			if($filas[7]=="0")
				$visible="display:none;";
			switch($filas[2])
			{
				case "1":
					$estiloDiv='z-index:10;';
					$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($query);
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef=generarEnlaceEtiqueta($filaE[5],$filas[0],$arrValoresParametros);
						$cHRef="</a>";
					}
					$etiqueta="<div class='".$filaE[13]."' id='_lbl".$filas[0]."'  style='width: ".$filaE[2]."px;height: ".$filaE[3]."px'>".$HRef."<span id='sp_".$filas[0]."'>".$filas[1]."</span>".$cHRef."</div>";
				break;
				case "13":
					$estiloDiv='z-index:0;';
					$query="select campoConf1,campoConf2 from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$confCampo=$con->obtenerPrimeraFila($query);
					$etiqueta="<fieldset class='frameHijoV3' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px; '  ><legend> ".$filas[1]."</legend></fieldset>";
				break;	
				case "30":

					$estiloDiv='z-index:10;';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef=generarEnlaceEtiqueta($filaE[5],$filas[0],$arrValoresParametros);
						$cHRef="</a>";
					}
					
					$tablaOD=$filaE[2];
					$tablaOD=str_replace("[","",$tablaOD);
					$tablaOD=str_replace("]","",$tablaOD);
					if(!isset($controlesQuery[$tablaOD]))
						$controlesQuery[$tablaOD]=array();
					array_push($controlesQuery[$tablaOD],"_".$filas[1]."vch");
					
					$nombreControl=generarNombre($filas[1],$filas[2]);
					$diccionario[$filas[1]][0]=$nombreControl;
					$diccionario[$filas[1]][1]=$filas[0];
					$diccionario[$filas[1]][2]=$filas[2];
					
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
							$resQuery=$con->obtenerFilas($queryTmp);
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
					
					$etiqueta="<div funcRenderer='".$funcionRenderer."' class='".$filaE[13]."' id='".$nombreControl."' idAlmacen='".$filaE[2]."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">'.convertirEnterToBR($valor)."</span>".$cHRef."</div>";
					if($funcionRenderer!="")
					{
						$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$filas[2].",'".$nombreControl."',".$filas[0].");";
					}
				break;	
						
			}
			
			$tabla=	 "	<table>
    						<tr>
                    			<td>".$etiqueta."</td>
                    		</tr>
    					</table>";
			$div="<div id='div_".$filas[0]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute; ".$visible.$estiloDiv."' >".$tabla."</div>";			
			echo $div;	
			if($calibrarCtrl=="")
				$calibrarCtrl="['div_".$filas[0]."']";
			else
				$calibrarCtrl.=",['div_".$filas[0]."']";
			
			$cc++;
		}
		
		$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
		$idProceso=$con->obtenerValor($consulta);
		$consulta="select idFormulario,nombreTabla from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$fFormulario=$con->obtenerPrimeraFila($consulta);
	  	$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		$comp="";
		$compCtrl="";
		if($tipoProceso==1000)
			$compCtrl=",-1";
			
		if($ocultarBotonesAccion)
			$compCtrl.=",-1,0";
			
		if($tipoProceso!=1)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,orden,visible,habilitado from 901_elementosFormulario where tipoElemento not in (-1,0,-2,1,13,20,30".$compCtrl.") and idFormulario=".$idFormulario." order by orden";
		else
			$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,orden,visible,habilitado from 901_elementosFormulario where tipoElemento not in (-1,0,1,13,20,30".$compCtrl.") and idFormulario=".$idFormulario." order by orden";
		$res=$con->obtenerFilas($query);
		$ctParamFunciones=0;
		$scriptComplementario="";
		while($fElemento=$con->fetchRow($res))
		{
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$fElemento[0];
			$fConfiguracionElemento=$con->obtenerPrimeraFilaAsoc($consulta);

			$funcionRenderer=isset($fConfiguracionElemento["campoConf18"])?$fConfiguracionElemento["campoConf18"]:"";
			
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
			
			
			if($fElemento[3]=='1')
			{
				$val='obl';
				$asteriscoRojo='<font color="red">*</font>&nbsp;';
			}
			else
			{
				$val='';
				$asteriscoRojo='';
			}
			$asteriscoRojo='';	
				
			if(($existeT==1)&&($fElemento[2]>1)&&($fElemento[2]<>13)&&(!(($fElemento[2]>=17)&&($fElemento[2]<=19)))&&($fElemento[2]<>23)&&($fElemento[2]<>29)&&($fElemento[2]<>33))
			{
				
				
				$valorCelda=$arrColumnasDatos[$fElemento[1]];
				if(($idRegistro==-1)&&($fConfiguracionElemento["campoConf16"]!=""))
				{
					$valorCelda=$fConfiguracionElemento["campoConf16"];
				}
					
			}
			else
			{
				$valorCelda="";
				
				
				
			}
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);
			$diccionario[$fElemento[1]][0]=$nombreControl;
			$diccionario[$fElemento[1]][1]=$fElemento[0];
			$diccionario[$fElemento[1]][2]=$fElemento[2];
			$funcionComboCambio="";
			if(isset($arrEnlacesControles[$fElemento[1]]))
			{
				
				$accion="";
				$accionExt="";
				switch($fElemento[2])
				{
					case 2:
					case 3:
					
					case 24:
							$accion="change";
					break;
					case 4:
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$autocompletar=$filaE[9];
						if(($autocompletar=="0")||($autocompletar==""))
							$accion="change";
						else
							$funcionComboCambio="funcElementoSel:funcionEventoCambio,";
						
					break;
					case 5:
					case 6:
					case 7:
					case 11:
					case 24:
						$accion="blur";
					break;
					case 8:
					case 21:
						$accionExt="select";					
					break;
				}
				if($accion!="")
				{
					$scriptComplementario.="asignarEvento('".$nombreControl."','".$accion."',funcionEventoCambio);";
				}
				if($accionExt!="")
				{
					$scriptComplementario.="gEx('f_sp".$nombreControl."').on('".$accionExt."',funcionEventoCambio);";
					//varDUmp($scriptComplementario);
				}
			}
			$queryAyuda="select mensajeAyuda from 914_mensajesAyuda where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$fElemento[0];
			$msgAyuda=$con->obtenerValor($queryAyuda);
			$habilitado="";
			if($fElemento[8]=="0")
				$habilitado="disabled='disabled'";
			$visible="display:";
			if($fElemento[7]=="0")
			{
				$visible="display:none";
			}
			
			
			$idRef=$idRegistro;
			$idRegistroD="-1";
			$idCtrl="";
			
			$consulta="select * from 985_controlesAccionVSAcciones where idElemFormulario=".$fElemento[0];
			$resCtrlAccion=$con->obtenerFilas($consulta);
			$nFilasAccion=$con->filasAfectadas;
			$funcionAccion="";
			if($nFilasAccion>0)
			{
				$funcionAccion="function funcionAccion_".$fElemento[0]."(objCtrl,registro)
								{ 

									var nControlAux;
									var tipo=objCtrl.nodeName;
									var valor='';
									switch(tipo)
									{
										case 'SELECT':
											valor=objCtrl.options[objCtrl.selectedIndex].value;
										break;
										case 'INPUT':
											valor=objCtrl.value;
										break;
									}
									
								";
				$arrAcciones=array();
				while($filaCtrl=$con->fetchRow($resCtrlAccion))
				{
					$consulta="select tipoElemento,nombreCampo from 901_elementosFormulario where idGrupoElemento=".$filaCtrl[3];
					
					$filaElementoFrm=$con->obtenerPrimeraFila($consulta);
					$tipoControl=$filaElementoFrm[0];
					$accionCtrl=$filaCtrl[4];
					if(strpos($accionCtrl,"O")!==false)	
						$cadAccion="nControlAux='".generarNombre($filaElementoFrm[1],$tipoControl)."';ocultarControl(nControlAux,".$tipoControl.",".$filaCtrl[3].",".$fElemento[0].");";
					if(strpos($accionCtrl,"M")!==false)	
						$cadAccion="nControlAux='".generarNombre($filaElementoFrm[1],$tipoControl)."';mostrarControl(nControlAux,".$tipoControl.",".$filaCtrl[3].",".$fElemento[0].");";
					if(strpos($accionCtrl,"D")!==false)	
						$cadAccion="nControlAux='".generarNombre($filaElementoFrm[1],$tipoControl)."';desHabilitarControl(nControlAux,".$tipoControl.",".$fElemento[0].");";
					if(strpos($accionCtrl,"H")!==false)	
						$cadAccion="nControlAux='".generarNombre($filaElementoFrm[1],$tipoControl)."';habilitarControl(nControlAux,".$tipoControl.",".$fElemento[0].");";
						
					if(!isset($arrAcciones[$filaCtrl[2]]))
						$arrAcciones[$filaCtrl[2]]=$cadAccion;
					else
						$arrAcciones[$filaCtrl[2]].=$cadAccion;
						
						
						
					
				}
				$funcionAccion.='switch(valor)
								{';
				
				foreach($arrAcciones as $optAccion => $cuerpo)
				{
					if($optAccion!="-100")
						$funcionAccion.="case '".$optAccion."': ".$cuerpo;
					else
						$funcionAccion.="default: ".$cuerpo;
					$funcionAccion.='break;';
				}
				
				$funcionAccion.="}
							}";
			}
			$accionEvento="";
			if(!elementoBloquedo($fElemento[0],$numEtapaPadre))
			{
				switch($fElemento[2])					
				{
					case -2:
						$display='';
						if($tipoProceso>=3)
						
						  $display="style='display:none'";
					  
					$etiqueta="	<table class='tablaMenu' width='200' ".$display.">";
				   
					if($idRegistro!="-1")
					{
						$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
						$idProceso=$con->obtenerValor($consulta);
						$consulta="select idFormulario,nombreTabla from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
						$fFormulario=$con->obtenerPrimeraFila($consulta);
						$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
						$tipoProceso=$con->obtenerValor($consulta);
						
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
							
								  $consulta="select idFormulario from 203_elementosDTD where idProceso=".$idProceso;
								  $frmDTD=$con->obtenerListaValores($consulta);
								  if($frmDTD=="")
									  $frmDTD="-1";
								  $consulta="select distinct(f.idFormulario),f.titulo,f.frmRepetible,f.nombreTabla,f.tipoFormulario 
										  from 900_formularios f,4037_etapas e  where e.numEtapa=f.idEtapa and 
										  f.idFrmEntidad=".$idFormulario." and e.numEtapa<=".$idEtapa." and f.idFormulario in(".$frmDTD.")";
							break;
							default:
								  $consulta="select distinct(f.idFormulario),f.titulo,f.frmRepetible,f.nombreTabla,f.tipoFormulario from 900_formularios f,4037_etapas e  where e.numEtapa=f.idEtapa and f.idFrmEntidad=".$idFormulario." and f.tipoFormulario<>10 and e.numEtapa<=".$idEtapa;
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
					else
					{
						$consulta="select idProceso,estadoInicial from 900_formularios where idFormulario=".$idFormulario;
						$fila=$con->obtenerPrimeraFila($consulta);
						$idProceso=$fila[0];
						$idEtapa=$fila[1];
						$consulta="select idFormulario from 203_elementosDTD where idProceso=".$idProceso;
						$frmDTD=$con->obtenerListaValores($consulta);
						if($frmDTD=="")
							$frmDTD="-1";
						$consulta="select distinct(f.idFormulario),f.titulo,f.frmRepetible,f.nombreTabla,f.tipoFormulario 
								from 900_formularios f,4037_etapas e  where e.numEtapa=f.idEtapa and 
								f.idFrmEntidad=".$idFormulario." and e.numEtapa<=".$idEtapa." and f.idFormulario in(".$frmDTD.")";
						  $filas=$con->obtenerFilas($consulta);
						  if($con->filasAfectadas>0)
							  $dependencias=true;
					}
					
					$etiqueta.="</table>";	
					
					if(!$dependencias)
					  $etiqueta="";
					$ignorarLimites='ignorarLimites="actualizar"';
					$mostrarEliminar=false;
				  
			  		break;
					case -1:
						$idCtrl="btnCancelar";
						$etiqueta="<input type='button' id='".$idCtrl."' value='".$et["lblCancelar"]."' class='btnCancelar' onclick=\"confirmarCierre()\">";
						
					break;
					case 0://button
						$idCtrl="btnGuardar";
						if($tipoProceso==1000)
						{
							$et["lblGuardar"]="Aceptar";
							$filaE[13]="btnAceptar";
						}
						else
							$filaE[13]="btnGuardar";
						$etiqueta="<input type='button'  id='".$idCtrl."' value='".$et["lblGuardar"]."' class='".$filaE[13]."' onclick=\"validarFrm('frmEnvio')\">";
					break;
					case 2: //pregunta cerrada-Opciones Manuales
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$anchoC=$filaE[11];
						$estiloAncho="";
						if($anchoC!="")
							$estiloAncho=' style="width: '.$anchoC.'px" ';
						$vDefault=$filaE[17];	
						if($vDefault=="")
							$vDefault="-1";
						if($idRegistro==-1)
							$valorCelda=$vDefault;
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$condWhere="";
						$btnAgregarElemento="";
						/*if($filaE[14]=="1")
							$btnAgregarElemento='<a href="javascript:agregarElemento(\''.bE($fElemento[0]).'\')"><img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento"></a>';*/
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=$filaFiltro[0]." ";
						$orden="";	
						switch($filaE[2])
						{
							case "":
							case "0":
								$orden="order by contenido";
							break;
							case "1":
								$orden="order by valor";
							break;
							case "2":
							break;
						}	
							
						if($condWhere=='')
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
						else
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;
						
						$etiqueta="	
									<table>
										<tr>
											<td>
												<select ".$estiloAncho." funcRenderer='".$funcionRenderer."' val='".$val."' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' class='".$filaE[13]."' ><option value='-1' valDefault='1'>Elija una opción</option>";
												$etiqueta.=	$con->generarOpcionesSelectNoImp($queryOpt,$valorCelda);	
						$etiqueta.="			</select>
											</td>
											<td>
												&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
											</td>
										</tr>
									</table>";
						if($nFilasAccion>0)
					  	{
							$funcionesJava.=$funcionAccion."asignarEvento('".$nombreControl."','change',funcionAccion_".$fElemento[0].");";
						 	$funcionesDisparadores.="lanzarEvento('".$nombreControl."','change');";
					  	}

						if($funcionRenderer!="")
						{
							
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 3: //pregunta cerrada-Opciones intervalo
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$anchoC=$filaE[11];
						$estiloAncho="";
						if($anchoC!="")
							$estiloAncho=' style="width: '.$anchoC.'px" ';
						$vDefault=$filaE[17];	
						if($vDefault=="")
							$vDefault="-1";
						if($idRegistro==-1)
							$valorCelda=$vDefault;
						$etiqueta= "	<select ".$estiloAncho." funcRenderer='".$funcionRenderer."' val='".$val."' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' class='".$filaE[13]."'><option value='-1' valDefault='1'>Elija una opción</option>";
											$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];		
											$filaE=$con->obtenerPrimeraFila($queryOpt);
											$etiqueta.=$con->generarNumeracionSelectNoImp($filaE[2],$filaE[3],$valorCelda,$filaE[4]);
						$etiqueta.=	"	</select>";
						if($nFilasAccion>0)
					  	{
							$funcionesJava.=$funcionAccion."asignarEvento('".$nombreControl."','change',funcionAccion_".$fElemento[0].");";
							$funcionesDisparadores.="lanzarEvento('".$nombreControl."','change');";
					  	}
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 4: //pregunta cerrada-Opciones tabla
						$arrParams="";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						
						
						
						$vDefault=$filaE[17];	
						if($vDefault=="")
							$vDefault="-1";
						$compNombre="";
						$tablaOD=$filaE[2];
						$campoProy=$filaE[3];
						$campoId=$filaE[4];
						$campoToolTip=$filaE[20];
						$campoFiltro=$filaE[8];
						$condicionFiltro=$filaE[7];
						$controlFiltro="_".$filaE[6]."vch";
						$controlDestino=$fElemento[1];
						$autocompletar=$filaE[9];
						$cBusqueda=$filaE[10];
						$anchoC=$filaE[11];
						$altoControl=$filaE[12];
						$multiSelect=$filaE[21];
						if($multiSelect==1)
						{
							$multiSelect="multiple='multiple'";
							$compNombre="[]";
						}
						$estiloAncho="";
						if($anchoC!="")
							$estiloAncho=' style="width: '.$anchoC.'px; @alto " ';
						if(($altoControl!="")&&($altoControl!=0))
						{
							if($estiloAncho=="")
								$estiloAncho=' style="height: '.$altoControl.'px;" ';
							else
								$estiloAncho=str_replace("@alto","height: ".$altoControl."px;",$estiloAncho );
						}
						else
							$estiloAncho=str_replace("@alto","",$estiloAncho );
						$camposEnvio=$filaE[15];
						$condicionFiltroComp=$filaE[16];
						$btnAgregarElemento="";
						
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$condWhere="";
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=$filaFiltro[0]." ";
						$obtenerOpciones=true;
						$arrElemento="";
						
						if(($autocompletar=="0")||($autocompletar=='')||($autocompletar=="2"))
						{
							if($idRegistro==-1)
								$valorCelda=$vDefault;
								
							
							if($filaE[5]=='1')
							{

								$controlDestino=$fElemento[1];
								if(($con->existeTabla($nombreTabla))&&($filaE[12]!='1'))
								{
									$consulta="select ".$filaE[6]." from ".$nombreTabla." where id_".$nombreTabla."='".$idRegistro."'";
									$valorCampo=$con->obtenerValor($consulta);
									if($valorCampo=="")
										$valorCampo=-1;
								}
								else
									$valorCampo='-1';
								
								if($filaE[12]!="1")
								{
									$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');
													comboD.setAttribute('cDestino','".$controlDestino."');comboD.setAttribute('camposDependencias','".$camposEnvio."');comboD.setAttribute('condComp','".bE($condicionFiltroComp)."');asignarEventoChange(comboD); ";
								}
								
								$arrCamposEnvio=explode(",",$camposEnvio);
								foreach ($arrCamposEnvio as $campo) 
								{
									$valor="-100584";
									if(isset($arrColumnasDatos[$campo]))
										$valor=$arrColumnasDatos[$campo];
									$condicionFiltroComp=str_replace("@".$campo."@",$valor,$condicionFiltroComp);
								}
								if($condWhere=="")
									$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' ".$condicionFiltroComp." order by ".$campoProy;
								else
									$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." ".$condicionFiltroComp." order by ".$campoProy;
								
							}
							else
							{
								
								if(strpos($tablaOD,"[")===false)
								{
									if($condWhere=="")
										$query="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
									else
										$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
								}
								else
								{
									$tablaOD=str_replace("[","",$tablaOD);
									$tablaOD=str_replace("]","",$tablaOD);
									$arrCamposProy=explode('@@',$filaE[3]);

									if(!isset($controlesQuery[$tablaOD]))
										$controlesQuery[$tablaOD]=array();
									array_push($controlesQuery[$tablaOD],$nombreControl);
									
									/*if($fElemento[0]==8661)
									{
											varDump($arrQueries[$tablaOD]);
									}*/

									if($arrQueries[$tablaOD]["ejecutado"]==1)
									{

										$resQuery=$arrQueries[$tablaOD]["resultado"];
										$conAux=$arrQueries[$tablaOD]["conector"];
										$conAux->inicializarRecurso($resQuery);	
										$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"'.($autocompletar==2?1:2).'","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';
										$obj=json_decode($cadObj);
										$obj->resQuery=$resQuery;
										$obj->idAlmacen=$tablaOD;
										$obj->arrCamposProy=$arrCamposProy;
										$obj->itemSelect=$valorCelda;
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
												$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"'.($autocompletar==2?1:2).'","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';
												$obj=json_decode($cadObj);
												$obj->resQuery=$resQuery;
												$obj->idAlmacen=$tablaOD;
												$obj->arrCamposProy=$arrCamposProy;
												$obj->itemSelect=$valorCelda;
												$obj->conector=$conAux;
												$arrElemento=generarFormatoOpcionesQuery($obj);
											}
											else
												$valor="";
										}
										else
											$valor='';
										$obtenerOpciones=false;
									}
										
								}	
								
							}
							
							if($autocompletar!="2")
							{
								if($nFilasAccion>0)
								{
									  $funcionesJava.=$funcionAccion."asignarEvento('".$nombreControl."','change',funcionAccion_".$fElemento[0].");";
									  $funcionesDisparadores.="lanzarEvento('".$nombreControl."','change');";
									  
									 
									  
									  
								}
								$etiqueta="	
										<table>
											<tr>
												<td>
														<select ".$multiSelect." ".$estiloAncho." funcRenderer='".$filaE[19]."'  val='".$val."' ".$habilitado." name='".$nombreControl.$compNombre."' id='".$nombreControl."' class='".$filaE[13]."' >";
														if($multiSelect=="")
															$etiqueta.="<option value='-1' valDefault='1'>Elija una opción</option>";
														if($obtenerOpciones)
															$etiqueta.=	$con->generarOpcionesSelectNoImp($query,$valorCelda);	
														else
															$etiqueta.= $arrElemento;
													
								$etiqueta.="			</select>
												</td>
												<td>
													&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
												</td>
											</tr>
										</table>";
								
								$accionEvento="change";	
							}
							else
							{
								
								$funcChange=$funcionComboCambio;
								if($nFilasAccion>0)
								{
									if($funcChange=="")
										$funcChange="funcionAccion_".$fElemento[0];
									else
									{
										$arrFuncion=explode(":",$funcChange);
										$funcComplementaria=$arrFuncion[1];
										$funcComplementaria=str_replace(",","",$funcComplementaria);
										$funcChange="function(cmb,registro){funcionAccion_".$fElemento[0]."(cmb,registro);".$funcComplementaria."(cmb,registro);}";
									}
									
								}
								
								
								$consulta="SELECT idOpcion FROM _".$idFormulario."_grid".ucfirst ($fElemento[1])." WHERE idPadre=".$idRegistro;
								$valorCelda=$con->obtenerListaValores($consulta);
								/*if($valorCelda=="")
									$valorCelda="";*/
								$nombreControl=substr($nombreControl,0,strlen($nombreControl)-3);
								$nombreControl.="arr";

								$etiqueta="	
									<table>
										<tr>
											<td>
													<span id='t_".$nombreControl."'>
													<input type='hidden' name='optListTabla_".$nombreControl."'  value='_".$idFormulario."_grid".$fElemento[1]."'>
													<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' val='".$val."' extId='ext_".$nombreControl."'>
											</td>
											<td>
												&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
											</td>
										</tr>
									</table>";
								$funcionesJava.="crearComboExt('ext_".$nombreControl."',[".$arrElemento."],0,0,".(($anchoC=="")?100:$anchoC).",{multiSelect:true,renderTo:'t_".$nombreControl."'});";
								if($habilitado=="true")
								{
									$funcionesJava.="gEx('ext_".$nombreControl."').disable();";
								}
								$funcionesJava.="gEx('ext_".$nombreControl."').setValue('".$valorCelda."');";
								$funcionesJava.="gEx('ext_".$nombreControl."').on('change',selElementoCheckBoxMultiple);";
								if($funcChange!="")
								{
									$funcionesJava.="gEx('ext_".$nombreControl."').on('change',".$funcChange.");";
								}
							}
						}
						else
						{
							$funcChange=$funcionComboCambio;
							if($nFilasAccion>0)
							{
								if($funcChange=="")
									$funcChange="funcElementoSel:funcionAccion_".$fElemento[0].",";
								else
								{
									$arrFuncion=explode(":",$funcChange);
									$funcComplementaria=$arrFuncion[1];
									$funcComplementaria=str_replace(",","",$funcComplementaria);
									$funcChange="funcElementoSel:function(cmb,registro){funcionAccion_".$fElemento[0]."(cmb,registro);".$funcComplementaria."(cmb,registro);},";
								}
								
							}
							
							$deshabilitado="false";
							if($habilitado!="")
								$deshabilitado="true";
							$tablaOD=$filaE[2];
							$valorCarga="";
							
							if(strpos($tablaOD,"[")===false)
							{	
								$consulta="select concat(".$filaE[3].") from ".$filaE[2]." where ".$filaE[4]." = '".$valorCelda."'";
								
								$valorCarga=$con->obtenerValor($consulta);
							}
							else
							{
								
								$tablaOD=str_replace("[","",$tablaOD);
								$tablaOD=str_replace("]","",$tablaOD);
								$arrCamposProy=explode('@@',$filaE[3]);
								if(!isset($controlesQuery[$tablaOD]))
									$controlesQuery[$tablaOD]=array();
								array_push($controlesQuery[$tablaOD],$nombreControl);
								if($arrQueries[$tablaOD]["ejecutado"]==1)
								{
									$resQuery=$arrQueries[$tablaOD]["resultado"];
									$conAux=$arrQueries[$tablaOD]["conector"];
									$conAux->inicializarRecurso($resQuery);	
									$consulta=$arrQueries[$tablaOD]["query"];
									$valorCarga="";
									if($valorCelda=="")
									{
										$valorCelda="-1";
										$valorCarga="";
									}
									else
									{
										$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"4","imprimir":"0","query":"'.$arrQueries[$tablaOD]["query"].'","campoID":"'.$campoId.'","itemSelect":"'.$valorCelda.'","campoToolTip":"'.$campoToolTip.'"}';
										$obj=json_decode($cadObj);
										$obj->resQuery=$resQuery;
										$obj->idAlmacen=$tablaOD;
										$obj->arrCamposProy=$arrCamposProy;
										$obj->itemSelect=$valorCelda;
										$obj->conector=$conAux;
										$valorCarga=generarFormatoOpcionesQuery($obj);
									}
									
								}
								else
								{
									
									$valorCarga=$valorCelda;
									
									$consulta=$arrQueries[$tablaOD]["query"];
									$arrParamControlAux=array();
									if($arrQueries[$tablaOD]["arrParamControl"]!="")
										$arrParamControlAux=explode(",",$arrQueries[$tablaOD]["arrParamControl"]);
										
									foreach($arrParamControlAux as $pCtrl)
									{
										$queryAux="SELECT idGrupoElemento,tipoElemento FROM 901_elementosFormulario WHERE 
													idFormulario=".$idFormulario." AND nombreCampo='".$pCtrl."'";
										
										$fControl=$con->obtenerPrimeraFila($queryAux);
										$nombreControlRef=generarNombre($pCtrl,$fControl[1]);
										
										$consulta=str_replace("@Control_".$fControl[0],"[".$nombreControlRef."]",$consulta);
										if($arrParams=="")
											$arrParams="'".$nombreControlRef."'";
										else
											$arrParams.=",'".$nombreControlRef."'";
									}
										
										
								}
							}
							$etiqueta="	
									<table>
										<tr>
											<td>
													<div id='".$nombreControl."_container' style='width:".($anchoC+10)."px'>
											
													<input type='text' name='t_".$nombreControl."' id='t_".$nombreControl."' value=''>
													<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' val='".$val."' extId='ext_".$nombreControl."' autocompletarExt='1'>
													</div>
											</td>
											<td>
												&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
											</td>
										</tr>
									</table>";
								
							$funcionesJavaInicio.="	function antesCargaExt_".$nombreControl."(dSet)
												{
													
													var query=bD('".bE($consulta)."');
													query=resolverConsultaQuery(query,[".$arrParams."]);
													var aValor=Ext.getCmp('ext_".$nombreControl."').getRawValue();
													dSet.baseParams.criterio=aValor;
													dSet.baseParams.idGrupoControl=".$fElemento[0].";
													dSet.baseParams.qy=bE(query);
													gE('".$nombreControl."').value='';
												};
												crearComboExtAutocompletar(
																			{
																				idCombo:'ext_".$nombreControl."',
																				txtDestino:'t_".$nombreControl."',
																				anchoCombo:".$anchoC.",
																				ctCls:'".$fConfiguracionElemento["campoConf12"]."',
																				listClass:'".$fConfiguracionElemento["campoConf13"]."',
																				campoHDestino:'".$nombreControl."',
																				funcAntesCarga:antesCargaExt_".$nombreControl.",
																				valorCarga:'".$valorCarga."',".$funcChange."
																				desHabilitado:".$deshabilitado."
																			}
																		);";
						}

						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 5: //Texto Corto
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$maxPalabras=$filaE[4];
						if($maxPalabras=="")
							$maxPalabras=0;
						$maxLogitud=$filaE[3];
						if($maxLogitud=="")
							$maxLogitud=0;
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						if($filaE[5]=="1")
						{
							if(($maxPalabras>0)||($maxLogitud>0))
							{
								$display="";
								if($maxLogitud>0)
									$display='#input caracteres de #max';
								if($maxPalabras>0)
								{
									if($display!="")
										$display.=" | #words palabras de #maxWord";
									else
										$display="#words palabras de #maxWord";
								}
								$funcionesJavaInicio.=' var options_'.$nombreControl.' = {
																		  \'maxCharacterSize\': '.$maxLogitud.',
																		  \'originalStyle\': \'originalDisplayInfo\',
																		  \'warningStyle\' : \'warningTextareaInfo\',
																		  \'warningNumber\': 40,
																		  \'maxWordSize\':'.$maxPalabras.',
																		  \'displayFormat\': \''.$display.'\'
																	  };
														  $(\'#'.$nombreControl.'\').textareaCount(options_'.$nombreControl.');';
							}
						}
						
						$etiqueta= "<input funcRenderer='".$filaE[19]."' spellcheck='".($fConfiguracionElemento["campoConf15"]==1?"true":"false")."' type='text' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' value='".str_replace("'","&#39;",$valorCelda)."' maxlength='".$maxLogitud."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."'  >";
						
					break;
					case 6: //Número entero
						if($val=='')
							$val='num';
						else
							$val.='|num';
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						$sepMiles=$filaE[3];
						$mascara="#".$sepMiles."###";
						$funcionesJavaInicio.="msk_".$nombreControl."=new Mask('".$mascara."','number');msk_".$nombreControl.".attach(gE('".$nombreControl."'));gE('".$nombreControl."').value=msk_".$nombreControl.".format('".$valorCelda."');";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);	
						$etiqueta= "<input type='text' spellcheck='false' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' size='".$filaE[2]."' class='".$filaE[13]."' onkeypress='return soloNumero(event,false,false)' val='".$val."' >";
						//$idCtrl=$nombreControl;	
					break;
					case 7: //Número decimal
						if($val=='')
							$val='flo';
						else
							$val.='|flo';
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						$sepDecimales=$filaE[4];
						$sepMiles=$filaE[3];
						$nDecimales=$filaE[7];
						$cadNDecimales=generarCadenaRepetible("0",$nDecimales);
						$mascara="#,###".$sepDecimales.$cadNDecimales;
						$funcionesJavaInicio.="msk_".$nombreControl."=new Mask('".$mascara."','number');msk_".$nombreControl.".attach(gE('".$nombreControl."'));gE('".$nombreControl."').value=msk_".$nombreControl.".format('".$valorCelda."');";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);	
						$etiqueta= "<input type='text' spellcheck='false' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' size='".$filaE[2]."' class='".$filaE[13]."' onkeypress='return soloNumero(event,true,false,this)' val='".$val."' >";
						//$idCtrl=$nombreControl;		
					break;
					case 8: //Fecha
						if($valorCelda!="")
						{
							$arrValor=explode("-",$valorCelda);
							$valorCelda=$arrValor[2]."/".$arrValor[1]."/".$arrValor[0];
						}

						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta= "	<div id='sp".$nombreControl."' style='width: ".(($fConfiguracionElemento["campoConf10"]==""?"":$fConfiguracionElemento["campoConf10"])+10)."px'></div>
										<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' val='".$val."'  extId='f_sp".$nombreControl."'>";
						$fMax=$filaE[3];
						$fMin=$filaE[2];
						$diasSel=$filaE[4];
						$compHabilitado="";
						if($habilitado!="")
							$compHabilitado="Ext.getCmp('f_sp".$nombreControl."').disable();";
						$fechaMinima='null';
						$fechaMaxima='null';
						
						
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						if(strpos($fMin,'[')===false)
						{
							if($fMin!="")
								$fechaMinima=$fMin;
						}
						else
						{
							if($fMin!="[]")
							{
								$fechaMinima=evaluarCadenaExpresion($fMin,$arrQueries);
								$arrFecha=explode("|",$fechaMinima->tokenMysql);
								
								$fechaMinima=$arrFecha[0];
							}
							
						}
						
						if(strpos($fMax,'[')===false)
						{
							if($fMax!="")
								$fechaMaxima=$fMax;
						}
						else
						{
							if($fMax!="[]")
							{
								$fechaMaxima=evaluarCadenaExpresion($fMax,$arrQueries);
								
								$arrFecha=explode("|",$fechaMaxima->tokenMysql);
								
								$fechaMaxima=$arrFecha[0];
							}
						}
						
						$estilo=$fConfiguracionElemento["campoConf12"];
						//echo "crearCampoFecha('sp".$nombreControl."','".$nombreControl."','".$fechaMinima."','".$fechaMaxima."')";
						
						$objConf='{';
						$estilo=$fConfiguracionElemento["campoConf12"];
						if($estilo!="")
						{
							$objConf.='"ctCls":"'.$estilo.'","cls":"cls'.$estilo.'"';
						}
						
						if($fConfiguracionElemento["campoConf10"]!="")
						{
							if($objConf=='{')
								$objConf.='"width":'.$fConfiguracionElemento["campoConf10"];
							else
								$objConf.=',"width":'.$fConfiguracionElemento["campoConf10"];
						}
						
						$objConf.='}';
						//echo "crearCampoFecha('sp".$nombreControl."','".$nombreControl."','".$fechaMinima."','".$fechaMaxima."')";
						$funcionesJava.="crearCampoFecha('sp".$nombreControl."','".$nombreControl."','".$fechaMinima."','".$fechaMaxima."',null,".$objConf.").setDisabledDays([".$diasSel."]);".$compHabilitado;
						//$idCtrl=$nombreControl;
					break;
					case 9://Texto Largo 
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$maxPalabras=$filaE[4];
						if($maxPalabras=="")
							$maxPalabras=0;
						$maxLogitud=$filaE[5];
						if($maxLogitud=="")
							$maxLogitud=0;
						$tablaOD=$filaE[6];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						if(($maxPalabras>0)||($maxLogitud>0))
						{
							$display="";
							if($maxLogitud>0)
								$display='#input caracteres de #max';
							if($maxPalabras>0)
							{
								if($display!="")
									$display.=" | #words palabras de #maxWord";
								else
									$display="#words palabras de #maxWord";
							}
							$funcionesJavaInicio.=' var options_'.$nombreControl.' = {
																	  \'maxCharacterSize\': '.$maxLogitud.',
																	  \'originalStyle\': \'originalDisplayInfo\',
																	  \'warningStyle\' : \'warningTextareaInfo\',
																	  \'warningNumber\': 40,
																	  \'maxWordSize\':'.$maxPalabras.',
																	  \'displayFormat\': \''.$display.'\'
																  };
													  $(\'#'.$nombreControl.'\').textareaCount(options_'.$nombreControl.');';
						}
						
						$etiqueta="<textarea funcRenderer='".$filaE[19]."' spellcheck='".($fConfiguracionElemento["campoConf15"]==1?"true":"false")."' name='".$nombreControl."' ".$habilitado." id='".$nombreControl."' style='width:".$filaE[2]."px !important; height:".$filaE[3]."px !important' class='".$filaE[13]."' val='".$val."' >".$valorCelda."</textarea>";
						//$idCtrl=$nombreControl;
					break;
					case 10: //Texto Enriquecido
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$valorCeldaFinal=bE($valorCelda);
						$etiqueta= "<span name='txtEnriquecido_".$fElemento[0]."' id='txtEnriquecido_".$fElemento[0]."' val='".$val."'></span><input type='hidden'  name='".$nombreControl."' id='".$nombreControl."' value='".$valorCeldaFinal."'>";
						
						//$valorCeldaFinal=bE(str_replace("'","\\'",$valorCelda));
						


						$funcionesJava.="crearTextoEnriquecido('".$nombreControl."','txtEnriquecido_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",'".$valorCeldaFinal."','".$filaE[4]."',".$fElemento[8].",".($fConfiguracionElemento["campoConf15"]==1?"1":"0").");arrTextRich.push('".$nombreControl."');gE('".$nombreControl."').setAttribute('val','".$val."');gE('".$nombreControl."').setAttribute('richText','txt".$nombreControl."');";
						
						//$idCtrl=$nombreControl;
					break;
					case 11: //Correo Electrónico
						if($val=='')
							$val='mail';
						else
							$val.='|mail';
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						$etiqueta="<input type='text' spellcheck='false' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."' >";
						//$idCtrl=$nombreControl;
					break;
					case 12: //Archivo
						$nombreControlFile=$fElemento[1];
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$descargarArchivo="";
						if(($valorCelda!='')&&($valorCelda!='-1'))
						{
							$val='';
							$descargarArchivo="<a href='../paginasFunciones/obtenerArchivos.php?id=".bE($valorCelda)."'><img src='../images/download.png' alt='Descargar documento' title='Descargar documento'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
							$consulta="SELECT lower(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$valorCelda;
							$nomArchivoOriginal=$con->obtenerValor($consulta);
							$arrNombreArchivo=explode(".",$nomArchivoOriginal);
							$extension=$arrNombreArchivo[count($arrNombreArchivo)-1];
							
							$descargarArchivo="<a href='javascript:visualizarDocumentoAdjuntoB64(\"".bE($valorCelda)."\",\"".bE($extension)."\")'><img src='../images/magnifier.png' alt='Ver Documento' title='Ver Documento'></a>&nbsp;&nbsp;";
						}
						else
							$valorCelda="-1";
					
						$controlFile="<input class='".$fConfiguracionElemento["campoConf12"]."' type=\"file\" ".$habilitado."  name='".$nombreControlFile."' id='".$nombreControlFile."' val='".$val."' />";
						$etiqueta=$descargarArchivo.$controlFile."<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' >";
						//$idCtrl=$nombreControl;
					break;
					case 14: //Radio opciones manuales
						$lanzadorEvento="";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$fConfCampo=$con->obtenerPrimeraFila($consulta);
						$filaE=$fConfCampo;
						$orden="";	
						switch($fConfCampo[2])
						{
							case "":
							case "0":
								$orden="order by contenido";
							break;
							case "1":
								$orden="order by valor";
							break;
							case "2":
							break;
						}	
						$numColumnas=$fConfCampo[9];
						$anchoCelda=$fConfCampo[11];
						$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."'>";
						$nCol=0;
						
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$condWhere="";
						
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=$filaFiltro[0]." ";
						if($condWhere=='')
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
						else
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;

						$resOpt=$con->obtenerFilas($queryOpt);
						$arrRadios="";
						$nCt=1;
						if($valorCelda=='')
						{
							$valorCelda=$fConfCampo[10];
							
							if($valorCelda=='100584')
								$valorCelda='';
						}
						if($nFilasAccion>0)
						{
							  $funcionesJava.=$funcionAccion;
						}
						$arrRadios="";
						$optSel="";
						while($fRes=$con->fetchRow($resOpt))
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
	
							if($valorCelda==$fRes[0])
							{
								$optSel="opt".$nombreControl."_".$fRes[0];
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$fConfCampo[13].'">
											<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'"  onclick="selOpcion(this)" checked="checked" >
											</td><td width="5"></td><td><span name="et'.$nombreControl.'" >'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';
								$lanzadorEvento.='lanzarEvento(gE(\'opt'.$nombreControl.'_'.$fRes[0].'\'),\'click\');';
							}
							else
							{
								$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$fConfCampo[13].'">
											<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'"  onclick="selOpcion(this)" ></td>
											<td width="5"></td><td><span name="et'.$nombreControl.'">'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';
							}
							$radio="['".$fRes[0]."','".$fRes[1]."']";
							if($arrRadios=='')
								$arrRadios=$radio;
							else
								$arrRadios.=','.$radio;
							$nCol++;
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$nCol=0;
							}
							if($valorCelda==-1)
								$valorCelda="";
							if($nFilasAccion>0)
							{
								  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$fRes[0]."','click',funcionAccion_".$fElemento[0].");".$lanzadorEvento;
							}
							
							$nCt++;
						}
						if($optSel!="")
						{
							$funcionesJava.="if(typeof(funcionAccion_".$fElemento[0].")!='undefined') funcionAccion_".$fElemento[0]."(gE('".$optSel."'));";
						}
						$etiqueta.="</table></span><input type='hidden' funcRenderer='".$funcionRenderer."' name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1' ><input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
						//$idCtrl=$nombreControl;
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 15:  //Radio opciones intervalos
						$lanzadorEvento="";
						$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' >";
						$nCol=0;
						$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($queryOpt);
						$arrRadios="";
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[11];
						$nCt=1;
						if($valorCelda=='')
						{
							$valorCelda=$filaE[10];
							
							if($valorCelda=='100584')
								$valorCelda='';
						}
						if($nFilasAccion>0)
						{
							$funcionesJava.=$funcionAccion;
						}
						$arrRadios="";
						if($filaE[2]<$filaE[3])
						{
							for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
		
								if($valorCelda==$x)
								{
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
												<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)" checked="checked">
												</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
									$lanzadorEvento.='lanzarEvento(gE(\'opt'.$nombreControl.'_'.$x.'\'),\'click\');';
								}
								else
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
												<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)">
												</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
								$nCol++;
								$radio="['".$x."','".$x."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								$nCt++;
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$x."','click',funcionAccion_".$fElemento[0].");".$lanzadorEvento;
									  
								}
								
							}
						}
						else
						{
							for($x=$filaE[2];$x>=$filaE[3];$x-=$filaE[4])
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
		
								if($valorCelda==$x)
								{
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
												<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)" checked="checked">
												</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
									$lanzadorEvento.='lanzarEvento(gE(\'opt'.$nombreControl.'_'.$x.'\'),\'click\');';
								}
								else
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
												<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)">
												</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
								$nCol++;
								$radio="['".$x."','".$x."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								$nCt++;
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$x."','click',funcionAccion_".$fElemento[0].");".$lanzadorEvento;
									  
								}
								
							}
	
						}
						if($valorCelda==-1)
							$valorCelda="";
						$etiqueta.="</table></span><input type='hidden' funcRenderer='".$funcionRenderer."'  name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1'> <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
						//$idCtrl=$nombreControl;
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 16: //Radio base de datos
						$lanzadorEvento="";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' >";
						$nCol=0;
						$tablaOD=$filaE[2];
						$campoProy=$filaE[3];
						$campoId=$filaE[4];
						$campoToolTip=$filaE[20];
						$campoFiltro=$filaE[8];
						$condicionFiltro=$filaE[7];
						$controlFiltro="_".$filaE[6]."vch";
						$controlDestino=$fElemento[1];
						$obtenerOpciones=true;
						$arrElemento=NULL;
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$condWhere="";
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=$filaFiltro[0]." ";
	
						if($filaE[5]=='1')
						{
							if(($con->existeTabla($nombreTabla))&&($filaE[12]!='1'))
							{
	
								$consulta="select ".$filaE[6]." from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
								$valorCampo=$con->obtenerValor($consulta);
							}
							else
								$valorCampo='-1';
							
							if($filaE[12]!='1')
							{
								//$funcion="actualizarListado(this,'".$campoFiltro."','".$condicionFiltro."','tbl".$nombreControl."');";
								$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');asignarEventoChangeListado(comboD,16); ";
							}
							
							if($condWhere=="")
								$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' order by ".$campoProy;
							else
								$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." order by ".$campoProy;
						}
						else
						{
							if(strpos($tablaOD,"[")===false)
							{
								if($condWhere=='')
									$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
								else
									$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
							}
							else
							{
								$tablaOD=str_replace("[","",$tablaOD);
								$tablaOD=str_replace("]","",$tablaOD);
								$arrCamposProy=explode('@@',$filaE[3]);
								if(!isset($controlesQuery[$tablaOD]))
									$controlesQuery[$tablaOD]=array();
								array_push($controlesQuery[$tablaOD],$nombreControl);
								if($arrQueries[$tablaOD]["ejecutado"]==1)
								{
									$resQuery=$arrQueries[$tablaOD]["resultado"];
									$conAux=$arrQueries[$tablaOD]["conector"];
									$conAux->inicializarRecurso($resQuery);	
									$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';

									$obj=json_decode($cadObj);
									$obj->resQuery=$resQuery;
									$obj->idAlmacen=$tablaOD;
									$obj->arrCamposProy=$arrCamposProy;
									$obj->conector=$conAux;
									$arrElemento=generarFormatoOpcionesQuery($obj);
									$obtenerOpciones=false;
									//$query=$arrQueries[$tablaOD]["query"];
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
											$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';
											$obj=json_decode($cadObj);
											$obj->resQuery=$resQuery;
											$obj->idAlmacen=$tablaOD;
											$obj->arrCamposProy=$arrCamposProy;
											$obj->itemSelect=$valorCelda;
											$obj->conector=$conAux;
											$arrElemento=generarFormatoOpcionesQuery($obj);
										}
										
									}
									$obtenerOpciones=false;
								}
							}
						}
						
						$arrRadios="";
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[11];
						$nCt=1;
						if($valorCelda=='')
						{
							$valorCelda=$filaE[10];
							if($valorCelda=='100584')
								$valorCelda='';
						}
						if($nFilasAccion>0)
						{
							$funcionesJava.=$funcionAccion;
							
						}
						if($obtenerOpciones)
						{
							$resOpt=$con->obtenerFilas($queryOpt);
							while($fRes=$con->fetchRow($resOpt))
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
								if($valorCelda==$fRes[0])
								{
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'"><table><tr>
									<td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" onclick="selOpcion(this)" checked="checked"></td>
									<td wdth="5"></td><td><span class="'.$filaE[13].'" name="et'.$nombreControl.'" id="et_opt'.$nombreControl.'_'.$e[0].'">'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';
									
									$lanzadorEvento.='lanzarEvento(gE(\'opt'.$nombreControl.'_'.$e[0].'\'),\'click\');';
								}
								else
									$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
									<table><tr><td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" onclick="selOpcion(this)"></td>
									<td wdth="5"></td><td><span class="'.$filaE[13].'" name="et'.$nombreControl.'" id="et_opt'.$nombreControl.'_'.$e[0].'">'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';						
								$radio="['".$fRes[0]."','".$fRes[1]."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;
								$nCol++;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								$nCt++;
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$fRes[0]."','click',funcionAccion_".$fElemento[0].");".$lanzadorEvento;
									  
								}
							}
						}
						else
						{
							if($arrElemento!=NULL)	
							{
								foreach($arrElemento as $e)
								{
									$cadenaTooltip="";
									if(isset($e[2])&&(trim($e[2])!=""))
									{
										$cadenaTooltip=' data-ot="'.htmlentities($e[2]).'" data-ot-border-width="2" data-ot-stem-length="18" data-ot-stem-base="20" data-ot-tip-joint="top" data-ot-border-color="#317CC5" data-ot-style="glass"';
									}
									
									if($nCol==0)
										$etiqueta.='<tr height="23">';
									if($valorCelda==$e[0])
									{
										$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'"><table><tr>
													<td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$e[0].'" name="opt'.$nombreControl.'" value="'.$e[0].'" onclick="selOpcion(this)" checked="checked"></td>
													<td width="5"></td><td><span '.$cadenaTooltip.' id="et_opt'.$nombreControl.'_'.$e[0].'" name="et'.$nombreControl.'">'.$e[1].'</span></td></tr></table></td><td width="20"></td>';
										$lanzadorEvento.='lanzarEvento(gE(\'opt'.$nombreControl.'_'.$e[0].'\'),\'click\');';
									}
									else
										$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'"><table><tr>
													<td><input type="radio" '.$habilitado.' id="opt'.$nombreControl.'_'.$e[0].'" name="opt'.$nombreControl.'" value="'.$e[0].'" onclick="selOpcion(this)"></td>
													<td width="5"></td><td><span '.$cadenaTooltip.' id="et_opt'.$nombreControl.'_'.$e[0].'" name="et'.$nombreControl.'">'.$e[1].'</span></td></tr></table></td><td width="20"></td>';						
									$radio="['".$e[0]."','".$e[1]."']";
									if($arrRadios=='')
										$arrRadios=$radio;
									else
										$arrRadios.=','.$radio;
									$nCol++;
									if($nCol==$numColumnas)
									{
										$etiqueta.='</tr>';
										$nCol=0;
									}
									$nCt++;
									if($nFilasAccion>0)
									{
										  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$e[0]."','click',funcionAccion_".$fElemento[0].");".$lanzadorEvento;
										  
									}
								}
							}
							else
							{
								$etiqueta.='<td class="'.$filaE[13].'" width="150" >Sin opciones disponibles</td>';
							}
						}
						if($valorCelda==-1)
							$valorCelda="";
						$etiqueta.="</table></span><input type='hidden' funcRenderer='".$funcionRenderer."'  value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'> <input clase='".$filaE[13]."' type='hidden' name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1'> <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 17: //Check box manual
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];						
						$fConfCampo=$con->obtenerPrimeraFila($consulta);
						//$filaE[19]=$fConfCampo;
						$numColumnas=$fConfCampo[9];
						$anchoCelda=$fConfCampo[11];
						$orden="";	
						switch($fConfCampo[2])
						{
							case "":
							case "0":
								$orden="order by contenido";
							break;
							case "1":
								$orden="order by valor";
							break;
							case "2":
							break;
						}	
						$etiqueta="<span id='span".$nombreControl."'><table >";
						$nCol=0;
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$condWhere="";
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=$filaFiltro[0]." ";
						if($condWhere=='')
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
						else
							$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;
						$resOpt=$con->obtenerFilas($queryOpt);
						$arrRadios="";
						$arrNomTabla=explode('_',$nombreTabla);
						$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
						$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;
						$ctNumSel=0;
						$resTabla=$con->obtenerFilas($queryTabla);
						$primerElemento="";
						if($nFilasAccion>0)
						{
							$funcionesJava.=$funcionAccion;
						}
						$arrRadios="";
						while($fRes=$con->fetchRow($resOpt))
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
							
							$checado="";
							if(existeRegistro($fRes[0],$resTabla))
							{
								$checado='checked="checked"';
								$ctNumSel++;
							}
							
							if($primerElemento=='')
								$primerElemento='opt'.$nombreControl.'_'.$fRes[0];
								
							$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$fConfCampo[13].'">
										<table><tr><td><input type="checkbox" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt_'.$nombreControl.'[]" value="'.$fRes[0].'" '.$checado.' onclick="selCheck(this)"  >
										</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';
								
							$nCol++;
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$nCol=0;
							}
							$radio="['".$fRes[0]."','".$fRes[1]."']";
							if($arrRadios=='')
								$arrRadios=$radio;
							else
								$arrRadios.=','.$radio;
	
							if($nFilasAccion>0)
							{
								  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$fRes[0]."','click',funcionAccion_".$fElemento[0].");";
								  
							}
						}

						$etiqueta.="</table></span><input   type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'> <input type='hidden' funcRenderer='".$funcionRenderer."' id='".$nombreControl."' val='min' name='".$nombreControl."' tipo='checkBox'  minSel='".$fConfCampo[10]."'  value='_".$arrNomTabla[1]."_".$nControlSinSuf."' controlF='".$primerElemento."'><input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
						//$idCtrl=$nombreControl;
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 18: //Check box numerico
						$etiqueta="<span id='span".$nombreControl."'><table>";
						$nCol=0;
						$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						
						$filaE=$con->obtenerPrimeraFila($queryOpt);
						$arrRadios="";
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[11];
						$arrNomTabla=explode('_',$nombreTabla);
						$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
						$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;
						$resTabla=$con->obtenerFilas($queryTabla);
						$ctNumSel=0;
						$primerElemento="";
						if($nFilasAccion>0)
						{
							$funcionesJava.=$funcionAccion;
						}
						$arrRadios="";
						if($filaE[2]<$filaE[3])
						{
							for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
									
								$checado="";
								if(existeRegistro($x,$resTabla))
								{
									$checado='checked="checked"';
									$ctNumSel++;
								}
								if($primerElemento=='')
									$primerElemento='opt'.$nombreControl.'_'.$x;
									
								$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
											<table><tr><td><input type="checkbox" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt_'.$nombreControl.'[]" value="'.$x.'" '.$checado.' onclick="selCheck(this)"  >
											</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
									
								$radio="['".$x."','".$x."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;	
								$nCol++;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$x."','click',funcionAccion_".$fElemento[0].");";
									  
								}
							}
						}
						else
						{
							for($x=$filaE[2];$x>=$filaE[3];$x-=$filaE[4])
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
									
								$checado="";
								if(existeRegistro($x,$resTabla))
								{
									$checado='checked="checked"';
									$ctNumSel++;
								}
								if($primerElemento=='')
									$primerElemento='opt'.$nombreControl.'_'.$x;
									
								$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'">
											<table><tr><td><input type="checkbox" '.$habilitado.' id="opt'.$nombreControl.'_'.$x.'" name="opt_'.$nombreControl.'[]" value="'.$x.'" '.$checado.' onclick="selCheck(this)"  >
											</td><td width="5"></td><td><span name="et'.$nombreControl.'">'.$x.'</span></td></tr></table></td><td width="20"></td>';
									
								$radio="['".$x."','".$x."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;	
								$nCol++;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$x."','click',funcionAccion_".$fElemento[0].");";
									  
								}
							}	
						}
						$arrNomTabla=explode('_',$nombreTabla);
						$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
						$etiqueta.="</table></span><input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'><input type='hidden' funcRenderer='".$funcionRenderer."' id='".$nombreControl."' name='".$nombreControl."' val='min' value='_".$arrNomTabla[1]."_".$nControlSinSuf."' tipo='checkBox'  minSel='".$filaE[10]."' controlF='".$primerElemento."'><input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">  ";
						//$idCtrl=$nombreControl;
						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 19: //Checkbox consulta
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' style='".$visible." !important' >";
						$nCol=0;
						$tablaOD=$filaE[2];
						$campoProy=$filaE[3];
						$campoId=$filaE[4];
						$campoToolTip=$filaE[20];
						$campoFiltro=$filaE[8];
						$condicionFiltro=$filaE[7];
						$controlFiltro="_".$filaE[6]."vch";
						$controlDestino=$fElemento[1];
						$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
						$resFiltro=$con->obtenerFilas($consulta);
						$obtenerOpciones=true;
						$arrElemento=NULL;
						$condWhere="";
						while($filaFiltro=$con->fetchRow($resFiltro))
							$condWhere.=str_replace('@codigoUnidad',$_SESSION["codigoInstitucion"],$filaFiltro[0])." ";
						
						if($filaE[5]=='1')
						{
							if(($con->existeTabla($nombreTabla))&&($filaE[12]!='1'))
							{
	
								$consulta="select ".$filaE[6]." from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
								$valorCampo=$con->obtenerValor($consulta);
							}
							else
								$valorCampo='-1';
							
							if($filaE[12]!='1')
							{
								//$funcion="actualizarListado(this,'".$campoFiltro."','".$condicionFiltro."','tbl".$nombreControl."');";
								
								$funcionesJavaInicio.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');if((gEx('ext_".$controlFiltro."')==null)||(gEx('ext_".$controlFiltro."')==undefined)) {asignarEventoChangeListado(comboD,19);}else{gEx('ext_".$controlFiltro."').on('change',function(combo,valor){actualizarListado(gE('".$controlFiltro."').value,'".$campoFiltro."','".$condicionFiltro."','".$controlDestino."',19)})}";
								
							}
							
							if($condWhere=='')
								$queryOpt="select ".str_replace('"',"",$campoId).",".str_replace('"',"",$campoProy)." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' order by ".$campoProy;
							else
								$queryOpt="select ".str_replace('"',"",$campoId).",".str_replace('"',"",$campoProy)." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." order by ".$campoProy;
							
						}
						else
						{
							
							if(strpos($tablaOD,"[")===false)
							{
								if($condWhere=='')
									$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
								else
									$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
							}
							else
							{
								
								$tablaOD=str_replace("[","",$tablaOD);
								$tablaOD=str_replace("]","",$tablaOD);
								$arrCamposProy=explode('@@',$filaE[3]);
								if(!isset($controlesQuery[$tablaOD]))
									$controlesQuery[$tablaOD]=array();
								array_push($controlesQuery[$tablaOD],$nombreControl);
								if($arrQueries[$tablaOD]["ejecutado"]==1)
								{
									$resQuery=$arrQueries[$tablaOD]["resultado"];
									$conAux=$arrQueries[$tablaOD]["conector"];
									$conAux->inicializarRecurso($resQuery);	
									$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';
									$obj=json_decode($cadObj);
									$obj->resQuery=$resQuery;
									$obj->idAlmacen=$tablaOD;
									$obj->arrCamposProy=$arrCamposProy;
									$obj->conector=$conAux;
									$arrElemento=generarFormatoOpcionesQuery($obj);
									$obtenerOpciones=false;
									//$query=$arrQueries[$tablaOD]["query"];
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
											$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$campoId.'","campoToolTip":"'.$campoToolTip.'"}';
											$obj=json_decode($cadObj);
											$obj->resQuery=$resQuery;
											$obj->idAlmacen=$tablaOD;
											$obj->arrCamposProy=$arrCamposProy;
											$obj->itemSelect=$valorCelda;
											$obj->conector=$conAux;
											$arrElemento=generarFormatoOpcionesQuery($obj);
										}
										
									}
									
									$obtenerOpciones=false;
								}
							}
							
						}
						
						
						$arrRadios="";
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[11];
						$arrNomTabla=explode('_',$nombreTabla);
						$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
						$queryTabla="select idOpcion from _".$arrNomTabla[1]."_".$nControlSinSuf." where idPadre=".$idRegistro;

						$ctNumSel=0;
						
						$resTabla=NULL;

						if($con->existeTabla("_".$arrNomTabla[1]."_".$nControlSinSuf.""))
						{

							$resTabla=$con->obtenerFilas($queryTabla);
						}
						
						$primerElemento="";
						if($nFilasAccion>0)
						{
							  $funcionesJava.=$funcionAccion;
							  
						}
						if($obtenerOpciones)
						{
							$resOpt=$con->obtenerFilas($queryOpt);
							while($fRes=$con->fetchRow($resOpt))
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
								$checado="";
								if($resTabla&&(existeRegistro($fRes[0],$resTabla)))
								{
									$checado='checked="checked"';
									$ctNumSel++;
								}
								if($primerElemento=='')
									$primerElemento='opt'.$nombreControl.'_'.$fRes[0];
										
								$etiqueta.='<td  width="'.$anchoCelda.'" class="'.$filaE[13].'" >
											<table><tr><td><input type="checkbox" '.$habilitado.' id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt_'.$nombreControl.'[]" value="'.$fRes[0].'" '.$checado.' onclick="selCheck(this)" >
											</td><td width="5"></td><td><span class="'.$filaE[13].'" name="et'.$nombreControl.'">'.$fRes[1].'</span></td></tr></table></td><td width="20"></td>';
								$radio="['".$fRes[0]."','".$fRes[1]."']";
								if($arrRadios=='')
									$arrRadios=$radio;
								else
									$arrRadios.=','.$radio;	
								$nCol++;
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$nCol=0;
								}
								if($nFilasAccion>0)
								{
									  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$fRes[0]."','click',funcionAccion_".$fElemento[0].");";
									  
								}
							}
							
						}
						else
						{
							if($arrElemento!=NULL)	
							{
								foreach($arrElemento as $e)
								{
									
									$cadenaTooltip="";
									if(isset($e[2])&&(trim($e[2])!=""))
									{
										$cadenaTooltip=' data-ot="'.htmlentities($e[2]).'" data-ot-border-width="2" data-ot-stem-length="18" data-ot-stem-base="20" data-ot-tip-joint="top" data-ot-border-color="#317CC5" data-ot-style="glass"';
									}
									
									if($nCol==0)
										$etiqueta.='<tr height="23">';
									$checado="";
									if(existeRegistro($e[0],$resTabla))
									{
										$checado='checked="checked"';
										$ctNumSel++;
									}
									if($primerElemento=='')
										$primerElemento='opt'.$nombreControl.'_'.$e[0];
											
									$etiqueta.='<td  width="'.$anchoCelda.'"  class="'.$filaE[13].'">
												<table><tr><td><input type="checkbox" '.$habilitado.' id="opt'.$nombreControl.'_'.$e[0].'" name="opt_'.$nombreControl.'[]" value="'.$e[0].'" '.$checado.' onclick="selCheck(this)" >
												</td><td width="5"></td><td><span '.$cadenaTooltip.' name="et'.$nombreControl.'">'.$e[1].'</span></td></tr></table></td><td width="20"></td>';
									$radio="['".$e[0]."','".$e[1]."']";
									if($arrRadios=='')
										$arrRadios=$radio;
									else
										$arrRadios.=','.$radio;	
									$nCol++;
									if($nCol==$numColumnas)
									{
										$etiqueta.='</tr>';
										$nCol=0;
									}
									if($nFilasAccion>0)
									{
										  $funcionesJava.="asignarEvento('opt".$nombreControl."_".$e[0]."','click',funcionAccion_".$fElemento[0].");";
										  
									}
								}
								
							}
						}
						$arrNomTabla=explode('_',$nombreTabla);
						$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
						$etiqueta.="</table></span><input type='hidden' value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'> <input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'><input clase='".$filaE[13]."' funcRenderer='".$filaE[19]."' type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='min' value='_".$arrNomTabla[1]."_".$nControlSinSuf."' tipo='checkBox'  minSel='".$filaE[10]."' controlF='".$primerElemento."'><input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";

						if($funcionRenderer!="")
						{
							$funcionesJava.="asignarValorFormatoRenderer('".$funcionRenderer."',".$fElemento[2].",'".$nombreControl."',".$fElemento[0].");";
						}
					break;
					case 21: //Hora
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						//echo $consulta;
						$filaE=$con->obtenerPrimeraFila($consulta);
						if($valorCelda!="")
							$valorCelda=date("H:i",strtotime($valorCelda));
						$etiqueta= "	<div id='sp".$nombreControl."' style='width:".($fConfiguracionElemento["campoConf10"]==""?"120":($fConfiguracionElemento["campoConf10"]+0))."px'></div>
										<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' val='".$val."'  extId='f_sp".$nombreControl."'>";
						$fMax=$filaE[2];
						$fMin=$filaE[3];
						$intervalo=$filaE[4];
	
						if($fMax=='')
							$fMax="null";
						else
							$fMax="'".$fMax."'";
						if($fMin=='')
							$fMin="null";
						else
							$fMin="'".$fMin."'";
						$compHabilitado="";
						if($habilitado!="")
							$compHabilitado="Ext.getCmp('f_sp".$nombreControl."').disable();";
						
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						$objConf='{';
						$estilo=$fConfiguracionElemento["campoConf12"];
						if($estilo!="")
						{
							$objConf.='"ctCls":"'.$estilo.'","listClass":"'.$estilo.'List"';
						}
						
						if($fConfiguracionElemento["campoConf10"]!="")
						{
							if($objConf=='{')
								$objConf.='"width":'.$fConfiguracionElemento["campoConf10"];
							else
								$objConf.=',"width":'.$fConfiguracionElemento["campoConf10"];
						}
						
						$objConf.='}';
						$funcionesJava.="crearCampoHora('sp".$nombreControl."','".$nombreControl."',".$fMin.",".$fMax.",".$intervalo.",".$objConf.");".$compHabilitado;
						//$idCtrl=$nombreControl;
					break;
					case 22: //etiqueta expresion
						$consulta="select * from 929_operacionesCampoExpresion where idElemFormulario=".$fElemento[0];
						$resOperaciones=$con->obtenerFilas($consulta);
						$cadena="";
						$obj="";
						$arrExp="";
						$funcionesEvento="";
						$asignacionEvento="";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						while($filaOperacion=$con->fetchRow($resOperaciones))
						{
							
							$obj='["'.$filaOperacion[3].'","'.$filaOperacion[2].'","'.$filaOperacion[4].'"]';
							if($arrExp=="")
								$arrExp=$obj;
							else
								$arrExp.=",".$obj;
							if($filaOperacion[4]==2)
							{
								$funcionesEvento.="funcionCalcular= function (evento)
																{
																	evaluarExpresion('".$nombreControl."');
																};";
								$asignacionEvento.="asignarEvento('".$filaOperacion[3]."','change',funcionCalcular);";
								
								
							}
						}
						
						
						//1861757
						
						$etiqueta="	<label name='lbl_".$nombreControl."' id='lbl_".$nombreControl."' class='".$filaE[13]."'></label>
									<input type='hidden' name='exp_".$nombreControl."' id='exp_".$nombreControl."' value='[".$arrExp."]'>
									<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value=''>
									<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[2]."'>
									<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
									<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
									<input type='hidden' name='tratoDec_".$nombreControl."' id='tratoDec_".$nombreControl."' value='".$filaE[5]."'>
									
						";
						$funcionesJava.="evaluarExpresion('".$nombreControl."');";
						$funcionesJava.=$funcionesEvento.$asignacionEvento;
						
					break;
					case 23: //Imagen
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						
						$filaE=$con->obtenerPrimeraFila($consulta);
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
						$nombreControl=str_replace("_","",$nombreControl);
						$etiqueta= "<span  id='_img".$fElemento[0]."' enlace='".$filaE[5]."'>".$HRef."<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>".$cHRef."</span>";
					break;
					case 24: //Moneda
						if($val=='')
							$val='flo';
						else
							$val.='|flo';
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$tablaOD=$filaE[5];
						if($tablaOD!="")
						{
							$objAlmacen=json_decode($tablaOD);
							$tablaOD=$objAlmacen->almacen;
							if(!isset($controlesQuery[$tablaOD]))
								$controlesQuery[$tablaOD]=array();
							array_push($controlesQuery[$tablaOD],$nombreControl);
						}
						
						$sepDecimales=$filaE[4];
						$sepMiles=$filaE[3];
						$nDecimales=$filaE[2];
						$cadNDecimales=generarCadenaRepetible("0",$nDecimales);
						if($valorCelda=="")
							$valorCelda=0;
						$valorCelda="$ ".number_format($valorCelda,$nDecimales,$sepDecimales,$sepMiles);		
						$mascara="$ #,###".$sepDecimales.$cadNDecimales;
						$funcionesJavaInicio.="msk_".$nombreControl."=new Mask('".$mascara."','number');msk_".$nombreControl.".attach(gE('".$nombreControl."'));";
						$etiqueta= "<input type='text' ".$habilitado." spellcheck='false' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' size='".$filaE[7]."' class='".$filaE[13]."' onkeypress='return soloNumero(event,true,false,this)' val='".$val."' >";
						//$idCtrl=$nombreControl;		
					break;
					
					case 25: //Texto Corto
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$anchoCtrl=$filaE[2];
						$formato=$filaE[3];
						$origenHora=$filaE[4];
						
						$etiqueta= "<input funcRenderer='".$filaE[19]."' type='text' spellcheck='false' readOnly=true name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."'  size='".$anchoCtrl."' class='".$filaE[13]."'>";
						
						if($valorCelda=="")						
						{
							$hInicial="'".date("Y-m-d H:i:s")."'";
							if($origenHora==2)
								$hInicial="null";
							$funcionesJava.="habilitarCampoTiempoSL('".$nombreControl."','".$formato."',".$hInicial.");";
						}
						
					break;
					
					case 29://Grid
						$funcionesControles.="arrFuncionesAfterEdit['func_".$fElemento[0]."']=new Array();";
						$funcAfterEdit="";
						$funcAdd="";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						
						$filaE=$con->obtenerPrimeraFila($consulta);
						$objConfOD=NULL;
						if($filaE[11]!="")
						{
							$objConfOD=json_decode($filaE[11]);
						}
						$ocultarCabecera=0;
						$cadConf=$filaE[8];
						if($filaE[13]=="")
							$filaE[13]=1;	
						
						
						
						$funcionesControles.="var funcAux2=function(grid,obj){";
						$cuerpoValidacionGrid=" return true;";
						if($cadConf!="")
						{
							$obj=json_decode($cadConf);
							$msgRepeticion=$obj->msgRepeticion;
							$camposValidacion=$obj->camposValidacion;
							
							
							$condicionGrid="";
							
							if($camposValidacion!="")
							{
								$arrCamposVal=explode(",",$camposValidacion);
								foreach($arrCamposVal as $campo)
								{
									$condicion="(obj.".$campo."==fila.get('".$campo."'))";
									if($condicionGrid=="")
										$condicionGrid=$condicion;
									else
										$condicionGrid.="&&".$condicion;
									
								}
								
								
								$cuerpoValidacionGrid=" var x; 
														var fila;
														for(x=0;x<grid.getStore().getCount();x++)
														{
															fila=grid.getStore().getAt(x);
															
															if(".$condicionGrid.")
															{
																msgBox('".$msgRepeticion."');
																return false;
															}
														}
														return true;
														";
													
							}
							
							
						}
						$funcionesControles.=$cuerpoValidacionGrid." };";
						$etiqueta="<span msgCampo='".bE($filaE[7])."' name='".$nombreControl."' id='contenedorSpanGrid_".$fElemento[0]."' permiteModificar='".$filaE[5]."' permiteEliminar='".$filaE[6]."' val='".$val."'><span id='spanGrid_".$fElemento[0]."'></span></span>";
						$consulta="SELECT * FROM 9039_configuracionesColumnasCampoGrid WHERE idElemento=".$fElemento[0]." order by orden";
						
						$resConf=$con->obtenerFilas($consulta);
						$arrCampos="{name: 'idRegistro'},{name: 'idReferencia'}";
						$arrCabeceras="";
						$mPermisos="";
						
						
						if(($filaE[7]=="1")||($filaE[7]==="")||($filaE[7]===NULL))
							$mPermisos="A";
						if($filaE[5]=="1")
							$mPermisos.="M";
						if($filaE[6]=="1")
							$mPermisos.="E";
						
						$visible='true';
						if($fElemento[7]=="0")
							$visible='false';
						$nTabla=$filaE[4];
						$cuerpoFuncionDeposito="";
						$camposQuerySelect="id_".$nTabla." as idRegistro,idReferencia";
						$arrCamposValor=array();
						$arrCamposValor[0]="idRegistro";
						$arrCamposValor[1]="idReferencia";
						
						while($filaConf=$con->fetchRow($resConf))
						{
							
							array_push($arrCamposValor,$filaConf[0]);
							if($filaConf[6]!=12)
								$camposQuerySelect.=",".$filaConf[3];
							else
							{
								$camposQuerySelect.=",(if(".$filaConf[3]." is null,'',concat((select nomArchivoOriginal FROM 908_archivos WHERE idArchivo=t.".$filaConf[3]."),'|',".$filaConf[3].")))";
							}
							
							$sumary="";
							$asterisco="";
							$tipoCampo=$filaConf[6];
							$depositarPieEn=$filaConf[19];
							$editorColumn="null";
							$rendererCtrl="function(val)
											{
												return val;	
											}";
							$confComp="";
							switch($tipoCampo)
							{
								
								case 1: //Entero
									$confComp=",css:'text-align:right;'";
									$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:false,cls:'controlSIUGJ'})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return Ext.util.Format.number(val,'0,000');
													}";
								break;
								case 2: //Decimal
									$confComp=",css:'text-align:right;'";
									$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true,decimalPrecision:4 ,cls:'controlSIUGJ'})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														
														return removerCerosDerecha(Ext.util.Format.number(val,'0,000.0000')+'');
													}";
								break;
								case 3:  //texto
									$editorColumn="new Ext.form.TextField({id:'editor_".$filaConf[3]."_".$fElemento[0]."',cls:'controlSIUGJ'})";
									
								break;
								case 4:  //Vinculado a tabla
									$tabla=$filaConf[8];
									$campoProy=$filaConf[10];
									$campoLlave=$filaConf[12];
									$consulta="select ".$campoLlave.",".$campoProy." from ".$tabla." order by ".$campoProy;
									
									$arrOpciones=$con->obtenerFilasArreglo($consulta);
									
									
									
									$editorColumn="crearComboExt('editor_".$filaConf[3]."',".$arrOpciones.",0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'})";
									
									$rendererCtrl="function (val,meta,registro,fila,columna)
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
									$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true,cls:'controlSIUGJ'})";
									$rendererCtrl="'usMoney'";
								break;
								case 6:	//Fecha
									$editorColumn="new Ext.form.DateField({cls:'campoFechaGrid',ctCls:'campoFechaSIUGJ',id:'editor_".$filaConf[3]."_".$fElemento[0]."',format:'d/m/Y'})";
									
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
									$editorColumn="crearCampoHoraExt('editor_".$filaConf[3]."_".$fElemento[0]."','00:00','23:59',5,true,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'})";
									//$editorColumn="null";
									$rendererCtrl="function (val,meta,registro,fila,columna,almacen)
															{
																var pos=obtenerPosFila(almacen,'id',val);
																if(pos!=-1)
																	return almacen.getAt(pos).get('nombre');
																else
																	return val;		
															}";
								break;
								case 8:  //Calculo
									$param=$filaConf[15];
									$objValor='';
									$arrObj=json_decode($param);
									$nElemArreglo=sizeof($arrObj);
									$arrCondicion="";
									if($nElemArreglo>0)
									{
										foreach($arrObj as $obj)
										{
											$valor=resolverTokensGrid($obj->tipoValor,$obj->valorSistema,$arrQueries,NULL,$paramObj);
											$objLinea='"'.$obj->parametro.'":'.$valor;
											if($objValor=='')			
												$objValor=$objLinea;
											else
												$objValor.=",".$objLinea;
											
										}
									}
									
									$objValor="'{".$objValor."}'";
									
									$funcionesControles.="var funcObj=function(obj,registro,pos,idGrid)
																{
																	var cadObj=".$objValor.";
																	function funcAjax_".$filaConf[0]."()
																	{
																		var resp=peticion_http.responseText;
																		arrResp=resp.split('|');
																		if(arrResp[0]=='1')
																		{
																			registro.set('".$filaConf[3]."',arrResp[1]);
																			var posAc=pos+1;
																			var arrFunciones=eval('arrFuncionesAfterEdit.func_'+idGrid);
																			if((typeof(arrFunciones[posAc])!='undefined')&&(arrFunciones[posAc]!=null))
																			{
																				arrFunciones[posAc](obj,registro,posAc,idGrid);
																			}
																		}
																		else
																		{
																			msgBox('No se ha podido llevar a acbo la operaci&oacute;n debido al siguiente problema: <br />'+arrResp[0]);
																		}
																	}
																	obtenerDatosWeb('../paginasFunciones/funcionesGridDinamico.php',funcAjax_".$filaConf[0].", 'POST','funcion=3&obj='+cadObj+'&func=".$filaConf[12]."',true);
																};";
									$funcionesControles.="arrFuncionesAfterEdit['func_".$fElemento[0]."'].push(funcObj);";																																
								break;	
								case 10: //Almacen de datos
									$tablaOD=$filaConf[8];
									$campoProy=$filaConf[10];
									$campoLlave=$filaConf[12];
									$arrElemento='';
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
										//$obj->itemSelect=$valorCelda;
										
										$arrElemento=generarFormatoOpcionesQuery($obj);
										
									}
									$arrOpciones="[".$arrElemento."]";
									$editorColumn="crearComboExt('editor_".$filaConf[3]."',".$arrOpciones.",0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														var editor=gEx('editor_".$filaConf[3]."');
														if(editor==null)
															return val;
														var almacen=editor.getStore();
														var pos=obtenerPosFila(almacen,'id',val);
														
														if(pos!=-1)
															return almacen.getAt(pos).get('nombre');
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
									$cadObjConfColum='{"tamMaxArchivo":"1","unidadTamMaximo":"GB","extensionesPermitidas":"*.*"}';
									if($filaConf[21]!="")
										$cadObjConfColum=$filaConf[21];
									$oColum=json_decode($cadObjConfColum);
									if($oColum->extensionesPermitidas=="")
										$oColum->extensionesPermitidas="*.*";
									$oColum->extensionesPermitidas=str_replace(",",";",$oColum->extensionesPermitidas);
									$oColum->extensionesPermitidas=str_replace("|",";",$oColum->extensionesPermitidas);
									
									
									$editorColumn="{xtype:'textoBotonField',ctCls:'clsGridTextoBotonField',tamanoMaxArchivo:'".$oColum->tamMaxArchivo." ".$oColum->unidadTamMaximo."',extensionesPermitidas:'".$oColum->extensionesPermitidas."'}";
									$rendererCtrl="textoBotonRenderer";

								break;
								case 13:	//Color
									$editorColumn="new Ext.form.TextoBotonColor({id:'editor_".$filaConf[3]."'})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return '<span style=\"border-style:solid; border-width:1px; border-color:#000;height:10px;width:10px;background-color:#'+val+'\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;'+val;
													}";
									
								break;
								case 14:	//Area de texto
									$editorColumn="new Ext.form.TextArea({id:'editor_".$filaConf[3]."',height:70,ctCls:'textAreaGrid',cls:'controlSIUGJ'})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return '<div style=\"width:100%;width:".$filaConf[5]."px\">'+cvTextArea(val)+'</div>';
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
									$cadDecimales=".".str_pad("",$nDecimales,"0",STR_PAD_RIGHT);
									if($cadDecimales==".")
										$cadDecimales=".0000";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return removerCerosDerecha(Ext.util.Format.number(val,'0,000".$cadDecimales."')+'');
													}";
								break;
							}
							
							$arrCampos.=",{name:'".$filaConf[3]."', type:'string'}";
							if($objConfOD)
							{
								$pos=existeValorArregloObjetos($objConfOD->arrCampos,$filaConf[0],"idCampo");
								if($pos!=-1)
								{
									if($objConfOD->arrCampos[$pos]->permiteEditar==0)
									{
										if(($tipoCampo!=4)&&($tipoCampo!=10))
											$editorColumn="null";
										else
										{
											$editorColumn.=".disable()"	;

										}
										
									}
								}
							}
							
							$objCabecera="{
																header:'".$filaConf[4].$asterisco."',
																menuDisabled :true,
																width:".$filaConf[5].",
																sortable:true,
																dataIndex:'".$filaConf[3]."',
																hidden:".$oculto.",
																editor:".$editorColumn.$confComp.",
																renderer:".$rendererCtrl.$sumary."
											}";
							
							if($arrCabeceras=="")
								$arrCabeceras=$objCabecera;
							else
								$arrCabeceras.=",".$objCabecera;
							if($depositarPieEn!="")
							{
								$cuerpoFuncionDeposito.="
															if(datos['".$filaConf[3]."']!=undefined)
															{
																establecerValorCtrlFormula('".$diccionario[$depositarPieEn][0]."',datos['".$filaConf[3]."']);
															}
															";
							}
								
						}
						
						$consulta="select ".$camposQuerySelect." from ".$nTabla." t where idReferencia=".$idRegistro." order by id_".$nTabla;
						if($con->existeTabla($nTabla))
							$arrDatosGrid=$con->obtenerFilasArreglo($consulta);
						else
							$arrDatosGrid="[]";
						$arrDatosGrid=str_replace("<br />","\\r\\n",$arrDatosGrid);
						
						if($idRegistro==-1)
						{
							if($objConfOD)
							{
								$totalCampos=sizeof($arrCamposValor);
								
								switch($objConfOD->tipoOrigenDatos)
								{
									case 1:
										if((isset($arrQueries[$objConfOD->idOrigenDatos]))&&($arrQueries[$objConfOD->idOrigenDatos]["ejecutado"]==1))
										{
											$arrDatosGrid="";

											$resOrigen=$arrQueries[$objConfOD->idOrigenDatos]["resultado"];
											if($con->numRows($resOrigen))
												$con->dataSeek($resOrigen,0);
											while($fOrigen=$con->fetchAssoc($resOrigen))	
											{
												
												$obj="['-1',''";
												for($x=2;$x<$totalCampos;$x++)
												{
													$vCampo="";
													$pos=existeValorArregloObjetos($objConfOD->arrCampos,$arrCamposValor[$x],"idCampo");
													
													if($pos!=-1)
													{
														$oTmp=$objConfOD->arrCampos[$pos];
														$vNormalizado=str_replace(".","_",$oTmp->valor);
														if(isset($fOrigen[$vNormalizado]))
														{
															$vCampo=$fOrigen[$vNormalizado];
														}
													}
													$obj.=",'".$vCampo."'";
												}
												$obj.=']';
												
												if($arrDatosGrid=="")
													$arrDatosGrid=$obj;
												else
													$arrDatosGrid.=",".$obj;
											}
											$arrDatosGrid='['.$arrDatosGrid.']';
											
											
										}
										
									break;
									case 2:
										$cadObj='{"param1":""}';
										$obj=json_decode($cadObj);
										$paramAmbiente["idFormulario"]=$idFormulario;
										$paramAmbiente["idProceso"]=$idProceso;
										$paramAmbiente["idRegistro"]=$idRegistro;
										$paramAmbiente["idReferencia"]=$idReferencia;
										$paramAmbiente["idUsuarioResponsable"]=$idUsuarioResp;
										$paramAmbiente["idElementoFormulario"]=$fElemento[0];
										$paramAmbiente["arrQueries"]=$arrQueries;
										//$paramAmbiente["objParametros"]=$objParametros;
										
										$obj->param1=$paramAmbiente;
										$objCache=NULL;
										$resOrigen=resolverExpresionCalculoPHP($objConfOD->idOrigenDatos,$obj,$objCache);
										$arrDatosGrid="";
										
										foreach($resOrigen as $fOrigen)
										{
											$obj="['-1',''";
											for($x=2;$x<$totalCampos;$x++)
											{
												$vCampo="";
												$pos=existeValorArregloObjetos($objConfOD->arrCampos,$arrCamposValor[$x],"idCampo");
												
												if($pos!=-1)
												{
													$oTmp=$objConfOD->arrCampos[$pos];
													$vNormalizado=$oTmp->valor;
													if(isset($fOrigen[$vNormalizado]))
													{
														$vCampo=$fOrigen[$vNormalizado];
													}
												}
												$obj.=",'".$vCampo."'";
											}
											$obj.=']';
											if($arrDatosGrid=="")
												$arrDatosGrid=$obj;
											else
												$arrDatosGrid.=",".$obj;
										}
										$arrDatosGrid='['.$arrDatosGrid.']';
									break;
									
								}
							}
						}
						$arrCampos="[".$arrCampos."]";
						$arrCabeceras="[".$arrCabeceras."]";
						$habilitado="false";	
						
						if($fElemento[8]==1)
							$habilitado="true";
						
						
						
						
						
						
						if($arrCamposGrid=="")
							$arrCamposGrid="grid_".$fElemento[0];
						else
							$arrCamposGrid.=",grid_".$fElemento[0];
							
						
						$funcionesControles.="var funcAux=function (datos)
													{
														".$cuerpoFuncionDeposito."
													};
										
										";
						$objConf=null;				
						$cadObjConf=$filaE[21];				
						if($cadObjConf!="")				
							$objConf=json_decode($cadObjConf);
							
						
						if($objConf)
						{
							if(isset($objConf->ocultarCabecera))
							{
								$ocultarCabecera=$objConf->ocultarCabecera;
							}
						}
						
						$funcionesControles.='var objConf={"ocultarCabecera":"'.$ocultarCabecera.'","etAgregar":"'.$filaE[9].'","etRemover":"'.$filaE[10].'"';
						
						
						$estilo=$fConfiguracionElemento["campoConf12"];
						if($estilo!="")
						{
							$funcionesControles.=',"ctCls":"'.$estilo.'"';
						}
						
						$funcionesControles.='};';
						
						if(($objConf!=null)&&isset($objConf->funcionAgregar))
							$funcionesControles.="objConf.funcionAgregar=".$objConf->funcionAgregar.";";
						$funcionesControles.="arrFuncionesGridDeposito['funcionDepositoPie_".$fElemento[0]."']=funcAux;";
						$funcionesControles.="arrFuncionesValidacionEdit['funcionValidacionGrid_".$fElemento[0]."']=funcAux2;";

						$funcionesControles.="crearCampoGridFormularioEjecucion(".$fElemento[0].",'grid_".$fElemento[0]."','spanGrid_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.",".$visible.",".$arrDatosGrid.",objConf);";
						
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
						
						
						$etiqueta="<span class='".$filaE[13]."' id='_".$fElemento[1]."vch' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$fElemento[0].'">'.convertirEnterToBR($valor)."</span>".$cHRef."</span>
									<input type='hidden' name='".$nombreControl."' value='".$valor."'>";
					break;
					case 32: //Color
						$etiqueta= "<input type='text' spellcheck='false' ".$habilitado." name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' maxlength='6' size='8'  val='".$val."'>";
						//$funcionesJava.="alert(document.getElementById('".$nombreControl."'));new jscolor.color(document.getElementById('".$nombreControl."'), {pickerOnfocus:false});";
					break;
					case 33: //galeria Imagenes
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$arregloGaleria="";
						$consulta="SELECT idArchivoImagen,a.tamano,a.nomArchivoOriginal FROM 9058_imagenesControlGaleria i,908_archivos a 
									WHERE idElementoFormulario=".$fElemento[0]." AND idRegistro=".$idRegistro." and a.idArchivo=i.idArchivoImagen order by idImagenGaleria";

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
							
						$etiqueta="<span name='galeriaDocumento' idCtrl='".$fElemento[0]."' id='_lbl".$fElemento[0]."'><span id='sp_".$fElemento[0]."' ancho='".$filaE[2]."' alto='".$filaE[3]."' arrElementos='".bE("[".$arregloGaleria."]")."'></span><span style='position:relative;top:-40px;left:".($filaE[2]-20)."px;z-index:10;'><a href='javascript:abrirAdmonGaleria(\"".bE($fElemento[0])."\")'><img id='btnAddImg_".$fElemento[0]."' src='../images/add.png'></a></span></span>";
						
						$funcionesJava.="generarGaleriaImagen([".$arregloGaleria."],".$fElemento[0].",".$filaE[2].",".$filaE[3].");";
					break;
				}	
			}
			else
			{
				$claseRespuesta="letraFichaRespuesta";
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
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$etiqueta.$cHRef."</span>";
					break;
					case 3: //pregunta cerrada-Opciones intervalo
						if(strpos(".",$valorCelda)!==false)
							$valorCelda=removerCerosDerecha($valorCelda);
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 4: //pregunta cerrada-Opciones tabla
					
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						if($valorCelda!="")
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
									$valorCelda="";
							}
							
						}
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 5: //Texto Corto
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 6: //Número entero
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$sepMiles=$filaE[3];
						$mascara="#".$sepMiles."###";
						$funcionesJavaInicio.="msk_".$nombreControl."=new Mask('".$mascara."','number');msk_".$nombreControl.".attach(gE('".$nombreControl."'));gE('".$nombreControl."').innerHTML=msk_".$nombreControl.".format('".$valorCelda."');";
						$etiqueta= "<span class='".$claseRespuesta."' id='".$nombreControl."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 7: //Número decimal
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						
						$filaE=$con->obtenerPrimeraFila($consulta);
						$sepDecimales=$filaE[4];
						$sepMiles=$filaE[3];
						$nDecimales=$filaE[7];
						//$cadNDecimales=generarCadenaRepetible("0",$nDecimales);
						//$mascara="#,###".$sepDecimales.$cadNDecimales;
						
						$valorCelda="$ ".number_format($valorCelda,$nDecimales,$sepDecimales,$sepMiles);
						//$funcionesJavaInicio.="msk_".$nombreControl."=new Mask('".$mascara."','number');msk_".$nombreControl.".attach(gE('".$nombreControl."'));gE('".$nombreControl."').innerHTML=msk_".$nombreControl.".format('".$valorCelda."');";
						$etiqueta= "<span class='".$claseRespuesta."' id='".$nombreControl."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 8: //Fecha
						if($valorCelda!="")
						{
							$arrValor=explode("-",$valorCelda);
							$valorCelda=$arrValor[2]."/".$arrValor[1]."/".$arrValor[0];
						}
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 9://Texto Largo 
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta= "<div class='letraFichaRespuesta' style='width:".$filaE[2]."px !important;height:".$filaE[3]."px !important;overflow: auto;'>".$HRef.$valorCelda.$cHRef."</div>";
					break;
					case 10: //Texto Enriquecido
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta= "<div style='width:".$filaE[2]."px;height:".$filaE[3]."px;overflow: auto;'>".$HRef.$valorCelda.$cHRef."</div>";
					break;
					case 11: //Correo Electrónico
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 12: //Archivo
						$descargarArchivo="";
						if(($valorCelda!='')&&($valorCelda!='-1'))
						{
							$val='';
							$descargarArchivo="<a href='../paginasFunciones/obtenerArchivos.php?id=".bE($valorCelda)."'><img src='../images/download.png' alt='".$et["lblDescargarArc"]."' title='".$et["lblDescargarArc"]."'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						else
							$valorCelda="-1";
						$etiqueta=$descargarArchivo;
					break;
					case 14:
						$queryOpt="select contenido from 902_opcionesFormulario where valor='".$valorCelda."' and idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
						$etiqueta=	$con->obtenerValor($queryOpt);	
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$etiqueta.$cHRef."</span>";
					break;
					case 15:
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.removerCerosDerecha($valorCelda).$cHRef."</span>";
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
									$valorCelda="";
							}
							
							
						}
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 17:
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$fConfCampo=$con->obtenerPrimeraFila($consulta);
						$numColumnas=$fConfCampo[9];
						$anchoCelda=$fConfCampo[8];
						$etiqueta="<span id='span".$nombreControl."'><table >";
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
								
								$etiqueta.='<td width="'.$anchoCelda.'"><span class="'.$claseRespuesta.'">'.$fRes[1].'</span></td><td width="20"></td>';
								$nCol++;
							}
							if($nCol==$numColumnas)
							{
								$etiqueta.='</tr>';
								$dibujaFila=1;
								$nCol=0;
							}
						}
						$etiqueta.="</table></span><input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'> <input type='hidden' id='".$nombreControl."' val='min' name='".$nombreControl."' tipo='checkBox'  minSel='".$fConfCampo[10]."'  value='".$arrNomTabla[0]."_".$nControlSinSuf."' controlF='".$primerElemento."'>";
					break;
					case 18:
						$etiqueta="<span id='span".$nombreControl."'><table >";
						$nCol=0;
						$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($queryOpt);
						$arrRadios="";
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[8];
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
		
									$etiqueta.='<td width="'.$anchoCelda.'"><span class="'.$claseRespuesta.'">'.removerCerosDerecha($x).'</span></td><td width="20"></td>';
									$nCol++;
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
		
									$etiqueta.='<td width="'.$anchoCelda.'"><span class="'.$claseRespuesta.'">'.removerCerosDerecha($x).'</span></td><td width="20"></td>';
									$nCol++;
								}
								if($nCol==$numColumnas)
								{
									$etiqueta.='</tr>';
									$dibujaFila=1;
									$nCol=0;
								}
							}
						}
						$etiqueta.="</table></span>";
					break;
					case 19:
						$etiqueta="<span id='span".$nombreControl."'><table >";
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						
						
						//$queryOpt="select ".$filaE[4].",".$filaE[3]." from ".$filaE[2]." order by ".$filaE[3];
						$tablaOD=$filaE[2];
						$campoId=$filaE[4];
						$obtenerOpciones=true;
						$arrElemento=NULL;
						if(strpos($tablaOD,"[")===false)
							$queryOpt="select ".$filaE[4].",".$filaE[3]." from ".$filaE[2]." order by ".$filaE[3];
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
								$obtenerOpciones=false;
						}
						$numColumnas=$filaE[9];
						$anchoCelda=$filaE[8];
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
									
									$etiqueta.='<td width="'.$anchoCelda.'"><span class="'.$claseRespuesta.'">'.$fRes[1].'</span></td><td width="10"></td><td width="20"></td>';
									$nCol++;
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
										
										$etiqueta.='<td width="'.$anchoCelda.'"><span class="'.$claseRespuesta.'">'.$e[1].'</span></td><td width="10"></td><td width="20"></td>';
										$nCol++;
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
						$etiqueta.="</table></span>";
					break;
					case 21: //Hora
						if($valorCelda!="")
							$valorCelda=date("h:i A",strtotime($valorCelda));
						$etiqueta= "<span class='".$claseRespuesta."'>".$HRef.$valorCelda.$cHRef."</span>";
					break;
					case 22:
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$etiqueta="<span class='letraFichaRespuesta' id='".$nombreControl."'>".$valorCelda."</span>";
						$truncar='false';
						if($filaE[5]=="2")
							$truncar='true';
						$funcionesJava.="var fValor=formatearNumero('".$valorCelda."','".$filaE[2]."','".$filaE[4]."','".$filaE[3]."',".$truncar.");
										reemplazarEtiqueta('".$nombreControl."',fValor);";
						
						
					break;
					case 23: //Imagen
						$nombreControl=str_replace("_","",$nombreControl);
						$etiqueta= "<span  id='_img".$fElemento[0]."' enlace='".$filaE[5]."'>".$HRef."<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>".$cHRef."</span>";
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
						$etiqueta= "<span class='".$claseRespuesta."' id='".$nombreControl."'>".$HRef.$valorCelda.$cHRef."</span>";
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
						while($filaConf=$con->fetchRow($resConf))
						{
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
									$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:false})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return Ext.util.Format.number(val,'0,000');
													}";
								break;
								case 2: //Decimal
									$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true})";
									$rendererCtrl="function (val,meta,registro,fila,columna)
													{
														return Ext.util.Format.number(val,'0,000.0000');
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
									$editorColumn="crearComboExt('editor_".$filaConf[3]."',".$arrOpciones.")";
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
							}
							
							if($filaConf[7]=="1")
								$asterisco=' <font color="red">*</font>';
							$oculto='false';
							if($filaConf[14]=="0")
							{
								$oculto='true';
								$asterisco="";
							}
							$arrCampos.=",{name:'".$filaConf[3]."'}";
							$objCabecera="{
																header:'".$filaConf[4].$asterisco."',
																width:".$filaConf[5].",
																sortable:true,
																dataIndex:'".$filaConf[3]."',
																hidden:".$oculto.",
																editor:".$editorColumn.",
																renderer:".$rendererCtrl."
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
						
						
						$consulta="select * from ".$nTabla." where idReferencia=".$idRegistro;;
						$arrDatosGrid=$con->obtenerFilasArreglo($consulta);
						$funcionesJava.="crearCampoGridFormularioEjecucion(".$fElemento[0].",'grid_".$fElemento[0]."','spanGrid_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.",".$visible.",".$arrDatosGrid.");";
						
					break;
					
				}	
				
			}
			$ayuda="";
			if($msgAyuda!="")
			{
				$ayuda='&nbsp;&nbsp;<span data-ot="'.htmlentities($msgAyuda).'" data-ot-border-width="2" data-ot-stem-length="18" data-ot-stem-base="20" data-ot-tip-joint="top" data-ot-border-color="#317CC5" data-ot-style="glass" ><img id="imgAyuda_'.$fElemento[0].'" src="../images/question.png" height="16" width="16"></span>';
			}
			
			
			
			$tabla=	 "	<table>
    						<tr>
								<td valign='top' width='0'>".$asteriscoRojo."</td>
                    			<td id='tdContenedor_".$nombreControl."'>".$etiqueta."</td>
								<td>".$ayuda."</td>
								
                    		</tr>
    					</table>";
			if($fElemento[2]=='-2')
			{
				$fElemento[4]=660;
				$fElemento[5]=70;
			}
			
			$div="<div id='div_".$fElemento[0]."' style='".$visible.";top:".$fElemento[5]."px; left:".$fElemento[4]."px; position:absolute;' orden='".$fElemento[6]."' controlInterno='".$nombreControl."_".$fElemento[2]."'>".$tabla."</div>";			
			echo $div;
			if($fElemento[2]!='-2')
			{
				if($calibrarCtrl=="")
					$calibrarCtrl="['div_".$fElemento[0]."']";
				else
					$calibrarCtrl.=",['div_".$fElemento[0]."']";
				if(($ctrlEnfocar=="")&&($fElemento[2]!=-2)&&($fElemento[2]!=22))
					$ctrlEnfocar="div_".$fElemento[0];
			}
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
		if($fRes)
		{
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
		else
			return -1;
	}
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
	$guardarConfSession=true;
	$evitarMarcos=false;
	if((isset($_POST["eliminarEspacios"]))||(isset($_GET["eliminarEspacios"])))
		$evitarMarcos=true;
		
	
?>
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
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
	
	.x-checkboxcombo-list
	{
		z-index:90000;
	}
	
	
	.x-item-disabled *
	{
		color:#000 !important;
		
	}
	
	.x-item-disabled 
	{
		opacity:1 !important;
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
	
	.x-checkboxcombo-list 
	{
		z-index:1150101 !important;
	}
	
	
	.fancybox-overlay 
	{
		position: absolute;
		top: 0;
		left: 0;
		overflow: hidden;
		display: none;
		z-index: 1150110;
		background: url(fancybox_overlay.png);
	}
	
	
	
</style>



<script>
	var matrizControles=new Array();
</script>
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

<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GridSummary.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/GridSummary.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../Scripts/textAreaCounter.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>
<script src="../Scripts/ckeditor/ckeditor.js" ></script>

<script type="text/javascript" src="../Scripts/masks.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/ux/checkColumn.js"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link type="text/css" rel="stylesheet" href="../Scripts/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />
<script type="text/javascript" src="../Scripts/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/i18n/es.js"></script>

<link rel="stylesheet" href="../Scripts/ux/textoBotonField/ext.ux.textoBotonField.css"   type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/textoBotonField/ext.ux.textoBotonField.js"></script>
<link rel="stylesheet" href="../Scripts/css-dock-menu/style.css"   type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/css-dock-menu/js/interface.js"></script>
<script type="text/javascript" src="../Scripts/jscolor/jscolor.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/textoBotonColor/textoBotonColor.css" />
<script type="text/javascript" src="../Scripts/ux/textoBotonColor/textoBotonColor.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/cleanSlider/resources/cleanSlider.css"/>
<script type="text/javascript" src="../Scripts/cleanSlider/resources/jquery.cleanSlider.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos/dataView.css" media="screen" />
<script src="../Scripts/cImagen.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/opentip/opentip.css" media="screen" />

<script type="text/javascript" src="../Scripts/opentip/opentip-jquery-excanvas.min.js"></script>
<script type="text/javascript" src="../modeloPerfiles/Scripts/galeriaImagenes.js.php"></script>

<link rel="stylesheet" type="text/css" href="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js"></script>






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
<?php 
$idFormulario="-1";

if(isset($objParametros->idFormulario))
	$idFormulario=$objParametros->idFormulario;




$idReferencia="-1";
if(isset($objParametros->idReferencia))
	$idReferencia=$objParametros->idReferencia;

$idProcesoP="";
if(isset($objParametros->idProcesoP))
	$idProcesoP=$objParametros->idProcesoP;

$idUsuario=-1;
if(isset($_SESSION["idUsr"]))
	$idUsuario=$_SESSION["idUsr"];
$codigoInstitucionUsuario="";
if(isset($_SESSION["codigoInstitucion"]))
	$codigoInstitucionUsuario=$_SESSION["codigoInstitucion"];
$codigoUnidadUsuario="";
if(isset($_SESSION["codigoUnidad"]))	
	$codigoUnidadUsuario=$_SESSION["codigoUnidad"];
if(isset($objParametros->idUsuario))
{
	$idUsuario=$objParametros->idUsuario;
	$consulta="Select a.Institucion,a.codigoUnidad from 801_adscripcion a where a.idUsuario=".$idUsuario; //and Status=1
	$filaUsr=$con->obtenerPrimeraFila($consulta);
	$codigoInstitucionUsuario=$filaUsr[0];
	$codigoUnidadUsuario=$filaUsr[1];
}

if(isset($objParametros->idUsuarioRegistro))
{
	$idUsuario=$objParametros->idUsuarioRegistro;
	$consulta="Select a.Institucion,a.codigoUnidad from 801_adscripcion a where a.idUsuario=".$idUsuario; //and Status=1
	$filaUsr=$con->obtenerPrimeraFila($consulta);
	$codigoInstitucionUsuario=$filaUsr[0];
	$codigoUnidadUsuario=$filaUsr[1];
}


if(($idFormulario=="-1")&&($configuracion==""))
{
	header('location:../principal/inicio.php');
	
}
		
$calibrarCtrl="";
$cc=0;

$arrConfiguraciones="var arrParamConfiguraciones=new Array();";
$dependencias;
$ctrlEnfocar="";

if(isset($objParametros->pagRegresar))
	$pagRegresar=bD($objParametros->pagRegresar);
$consulta="select titulo from 900_formularios where idFormulario=".$idFormulario;
$tituloModulo=$con->obtenerValor($consulta);
$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;

?>

<script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>


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
						
							$hInicio=obtenerHoraMicrosegundos();
						
							$alineacion="left";
							if(isset($objParametros->alineacion))
								$alineacion=$objParametros->alineacion;
							$numEtapaPadre=0;

					  	$idFormulario="-1";
						$idRegistro="-1";
						$paramPOST="";
						$arrCamposGrid="";
						$arrEnlacesControles=array();
						$scriptComplementario="";
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
						
						if(isset($objParametros->paramPOST))
						{
							$paramPOST=$objParametros->paramPOST;
						}
						$funcEjecutarNuevo="";
						if(isset($objParametros->funcEjecutarNuevo))
							$funcEjecutarNuevo=$objParametros->funcEjecutarNuevo;
						$funcEjecutarModif="";
						if(isset($objParametros->funcEjecutarModif))
							$funcEjecutarNuevo=$objParametros->funcEjecutarModif;
						$funcPHPEjecutarNuevo="";
						if(isset($objParametros->funcPHPEjecutarNuevo))
							$funcPHPEjecutarNuevo=$objParametros->funcPHPEjecutarNuevo;
						$funcPHPEjecutarModif="";
						if(isset($objParametros->funcPHPEjecutarModif))
							$funcPHPEjecutarModif=$objParametros->funcPHPEjecutarModif;
							
							
						$idPerfil=-1;
						if(isset($objParametros->idPerfil))	
							$idPerfil=$objParametros->idPerfil;
						
						$pCancelar=true;
						if(isset($objParametros->pC))
									$pCancelar=($objParametros->pC==1)?true:false;	
							
						$ocultarBotonesCtrl=0;
						if(isset($objParametros->ocultarBotonesCtrl))
							$ocultarBotonesCtrl	=$objParametros->ocultarBotonesCtrl;
							
							
						$arrValoresReemplazo[0][0]="@formulario";
						$arrValoresReemplazo[0][1]=$idFormulario;
						$arrValoresReemplazo[1][0]="@registro";
						$arrValoresReemplazo[1][1]=$idRegistro;
									
									
						$ocultarBotonesAccion=false;
						if(isset($objParametros->ocultarBotonesAccion))			
						{
							$ocultarBotonesAccion=true;
						}
												
						$consulta="select idEtapa,idProceso,funcionNuevoRegistro,funcionModificaRegistro,configuracionFormulario from 900_formularios where idFormulario=".$idFormulario;
						$fila=$con->obtenerPrimeraFila($consulta);
						$idEtapa=$fila[0];
						$idProceso=$fila[1];
						$nuevo=false;
						$modificar=false;
						$mostrarSinPermisos=false;
						$configuracionFormulario=$fila[4];
						
						
						$ignorarValidacionPermisos="0";
						$funcNuevoRegistro=$fila[2];
						$funcModifRegistro=$fila[3];
						if($funcNuevoRegistro!="")
						{
							if($funcPHPEjecutarNuevo!="")
								$funcPHPEjecutarNuevo= bE(bD($funcPHPEjecutarNuevo)."|".$funcNuevoRegistro."(".$idFormulario.",idRegPadre)");
							else
								$funcPHPEjecutarNuevo= bE($funcNuevoRegistro."(".$idFormulario.",idRegPadre)");
								
						}
						
						if($funcModifRegistro!="")
						{
							if($funcPHPEjecutarModif!="")	
								$funcPHPEjecutarModif= bE(bD($funcPHPEjecutarModif)."|".$funcModifRegistro."(".$idFormulario.",".$idRegistro.")");
							else
								$funcPHPEjecutarModif= bE($funcModifRegistro."(".$idFormulario.",".$idRegistro.")");
						}
						
						
						if(isset($objParametros->ignoraPermisos))
							$ignorarValidacionPermisos=$objParametros->ignoraPermisos;

						if($ignorarValidacionPermisos=="0")
						{
						
							$consulta="select tp.ignoraPermisos from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
							$ignoraPermisos=$con->obtenerValor($consulta);
							if($ignoraPermisos=="0")
							{
								$consulta="select permisos from 4002_rolesVSEtapas where etapa=".$idEtapa." and proceso=".$idProceso." and idRol in(".$_SESSION["idRol"].")";
								$res=$con->obtenerFilas($consulta);
								while($fila=$con->fetchRow($res))
								{
									$permisos=$fila[0];
									if(!(strpos($permisos,"A")===false))
										$nuevo=true;
									if(!(strpos($permisos,"M")===false))
										$modificar=true;
								}
												
								if($idRegistro=="-1")
								{
									if(!$nuevo)
									{
										$mostrarSinPermisos=true;
										$mostrarMenuIzq=false;
									}
								}
								else
								{
									if(!$modificar)
									{
										$mostrarSinPermisos=true;
										$mostrarMenuIzq=false;
									}
								}
							}
						}
						else
							$mostrarSinPermisos=false;
						$dependencias=false;
						$mostrarRegresar=false;
						$respetarEspacioRegresar=true;
						$funcionesControles="";
						$funcionesJava="";
						$funcionesJavaInicio="";
						$funcionesDisparadores="limpiarValorControl=false;";
						$idEstado='0';
						$consulta="select nombreTabla,estadoInicial,anchoGrid,altoGrid,reglaFolio from 900_formularios where idFormulario=".$idFormulario;
						$fila=$con->obtenerPrimeraFila($consulta);
						$nombreTabla=$fila[0];
						if($fila[1]!="")
							$idEstado=$fila[1];
						
						if($idEstado==0)
							$idEstado=1;	
							
						$evitarCodificacion=0;
						
						$anchoGrid=$fila[2];
						$altoGrid=$fila[3];
						$reglaFolio=$fila[4];
						if($reglaFolio==2)
							$codigo=obtenerFolioFormulario($idFormulario);
						else
							$codigo="[No asignado aún]";
						$arrColumnasDatos=array();
						$validarExisteTabla=0;
						$idProceso=obtenerIdProcesoFormulario($idFormulario);
		

		
						$tipoProceso=obtenerTipoProceso($idProceso);
						if($tipoProceso==1000)
							$evitarCodificacion=$fila[1];
						if($tipoProceso!=1000)
						{
							if($con->existeTabla($nombreTabla))
							{
								$existeT=1;
								$validarExisteTabla=$existeT;
								
								$consulta="select * from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
								$res=$con->obtenerFilas($consulta);
								$numColumnas=$con->numFields($res);
								$filaDatos=$con->fetchRow($res);
								
								for($x=0;$x<$numColumnas;$x++)
								{
									$arrColumnasDatos[$con->fieldName($res,$x)]=isset($filaDatos[$x])?$filaDatos[$x]:"";		
								}
								if($arrColumnasDatos["idReferencia"]!="")
									$idReferencia=$arrColumnasDatos["idReferencia"];
							}
							else
								$existeT=0;	
						}
						else
						{
							$existeT=0;	
							$validarExisteTabla=1;
						}
						?>
                   
	                   <td align="<?php echo $alineacion?>">
                        <script type="text/javascript" src="../modeloPerfiles/Scripts/registroFormularioV2.js.php?iF=<?php echo bE($idFormulario)?>&iR=<?php echo bE($idRegistroG)?>&iRef=<?php echo bE($idReferencia)?>"></script>
						<script type="text/javascript" src="../modeloPerfiles/Scripts/funcionesFormulario.js.php"></script>
						<link rel="stylesheet" type="text/css" href="../principalPortal/css/estilosFormulariosDinamicos.css"/>
                        <link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
                        <link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
                       
                       <?php
					   		if(isset($objParametros->formularioNormal))
							{
								if($tipoProceso!=1000)
								{

									
									echo formatearTituloPagina($tituloModulo,true,$idRegistro,"left",false);
								}
								else
									echo formatearTituloPagina($tituloModulo,true,0,"left",false);
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
							
							if($configuracionFormulario!="")
							{
								$objConf=json_decode($configuracionFormulario);
								if(isset($objConf->paginasCSS))
								{
									$arrPaginas=explode(",",$objConf->paginasCSS);
									if(sizeof($arrPagina)>0)
									{
										foreach($arrPaginas as $p)
										{
											echo '<link rel="stylesheet" type="text/css" href="'.$p.'" media="screen" />';
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
								echo '<script type="text/javascript" src="'.$fScript[0].'?iPP='.bE(isset($objParametros->idProcesoP)?$objParametros->idProcesoP:-1).'&iF='.bE($idFormulario).'&m=1&iR='.bE($idRegistroG).'&iRef='.$idReferencia.'&pComp='.$pComp.'"></script>';
							}
							
					   ?>
                     	
                      	<table>
                        <tr>
                    <?php
						
						$mostrarSinPermisos=false;
						if($mostrarSinPermisos)
						{
					?>
                    	
                                    <td align="left">
                                        <fieldset class="frameHijo"><legend><b>SIN PRIVILEGIOS</b></legend>
                                        <table width="100%">
                                            <tr>
                                                <td>
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
							$diccionario=array();
							$numEtapaPadre=obtenerEtapaProcesoActual($idRegistro,$idReferencia,$idFormulario);
							$controlesQuery=array();
							
							$idUsuarioResp=obtenerResponsableProcesoActual($idRegistro,$idReferencia,$idFormulario);
							
							if($idUsuarioResp=="-1")
							{
								$idUsuarioResp=$idUsuario;
							}
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
							
							
							$consulta="select titulo,frmRepetible,mostrarMarco from 900_formularios where idFormulario=".$idFormulario;
							$filaForm=$con->obtenerPrimeraFila($consulta);
							$titulo=$filaForm[0];
							$repetible=$filaForm[1];
							$mMarco=$filaForm[2];
							if(isset($objParametros->ocultarMarco))
								$mMarco=0;
							$consulta="select max(posY) from 901_elementosFormulario where idFormulario=".$idFormulario;
							$altura=$con->obtenerValor($consulta);
							$altura+=10;
							$claseFrame="frameHijo gridRejillaSinFondo";
							if($mMarco==0)
							{
								$titulo="";
								$claseFrame="gridRejillaSinFondo";
							}
							$arrQueriesScript="	var arrQueries=new Array();
												var objAux;
												";
												
									
							foreach($arrQueries as $idQuery=>$resto)
							{
								/*if($_SESSION["idUsr"]==1)
									if($idQuery==361)
									varDump($resto);*/
								
								if($idQuery!=-1000)
								{
									$arrQueriesScript.="objAux=new Array();";	
									$arrQueriesScript.="objAux[0]=".$idQuery.";";	
									$arrQueriesScript.="objAux[1]='".bE($resto["query"])."';";	
									$arrQueriesScript.="objAux[2]='".bE($resto["arrParamControl"])."';";	
									$arrQueriesScript.="arrQueries.push(objAux);";
									if($resto["arrParamControl"]!="")	
									{
										$cadControles="";
										$arrControles=explode(",",$resto["arrParamControl"]);
										
										foreach($arrControles as $control)
										{
											$agregarControl=true;
											if(!isset($arrEnlacesControles[$control]))	
											{
												$arrEnlacesControles[$control]=array();
												array_push($arrEnlacesControles[$control],$idQuery);
												
											}
											else
											{
												if(!existeValor($arrEnlacesControles[$control],$idQuery))
												{
													array_push($arrEnlacesControles[$control],$idQuery);
												}
												else
													$agregarControl=false;
											}
												
											if($agregarControl)	
												if($cadControles=="")	
													$cadControles="'".$control."'";
												else
													$cadControles.=",'".$control."'";
												
										}
										

									}
								}
							}
							


							$paginaEnvioDatos="../paginasFunciones/guardarDatos.php";
							$arrParametrosEnvio=array();
							if(isset($objParametros->paginaEnvioDatos))
								$paginaEnvioDatos=$objParametros->paginaEnvioDatos;
							
							if($tipoProceso==1000)
							{
								$arrPagina=explode("?",$paginaEnvioDatos);
								$paginaEnvioDatos=$arrPagina[0];
								if(sizeof($arrPagina)>1)
								{
									$arrParam=explode("&",$arrPagina[1]);
									foreach($arrParam as $param)
									{
										$posEqual=0;
										for($x=0;$x<strlen($param);$x++)
										{
											if($param[$x]=="=")
											{
												$posEqual=$x;
												break;
											}
											
										}
										$objParam[0]=substr($param,0,$posEqual);
										$objParam[1]=substr($param,($posEqual+1),(strlen($param)-($posEqual+1)));
										
										
										array_push($arrParametrosEnvio,$objParam);
									}
									
									
								}
								
									
							}
							
							
						?>
	                            <td  align="left"  id='tdContenedor' valign="top" >
                                
                                <table  id='tblGrid' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px" class="tdContenedorFormulario">
                                <tr>
                                	<td height="<?php echo $altoGrid?>px"  width="<?php echo $anchoGrid?>px">
                                <input type="hidden" name="idProceso" id="idProceso" value="<?php echo $idProceso ?>" />
                                <input type="hidden" name="idFormulario" id="idFormulario" value="<?php echo $idFormulario?>" />
                                
                                
                                <fieldset class="<?php  echo $claseFrame?>" id='frameTitulo'  style="height:<?php echo $altoGrid ?>px; width:<?php echo $anchoGrid ?>px" ><legend ><b><?php echo $titulo ?></b></legend>
                                
                                </fieldset>
                                <form method="post" action="<?php echo $paginaEnvioDatos?>" id="frmEnvio" enctype="multipart/form-data" onsubmit="return false">
								<?php
                                    crearElementosFormulario();
                               ?>
                               	<input type="hidden" id="cadObj" value="<?php echo bE($cadObj)?>" />
                                <input type="hidden" name="tabla" id="tabla" value="<?php echo $nombreTabla ?>" />
                                <input type="hidden" name="id" id="idRegistroG" value="<?php echo $idRegistroG ?>" />
                                <input type="hidden" name="campoId" id="campoId" value="id_<?php echo $nombreTabla ?>" />
                                <input type="hidden" name="arrCamposGrid" id="arrCamposGrid" value="<?php echo $arrCamposGrid ?>" />
                                <input type="hidden" name="arrImagenesGaleria" id="arrImagenesGaleria" value="" />
                                <input type="hidden" name="objCamposGrid" id="objCamposGrid" value="" />
                                <input type="hidden"  id="esRegistroFormulario" value="1" />
                                <?php
									$paginaRedireccion="";
									if(isset($objParametros->paginaRedireccion))
										$paginaRedireccion=$objParametros->paginaRedireccion;
									
									if($paginaRedireccion=="")
									{
										if($dependencias==false)
										{
											$pagRedireccion=$pConfRegresar;
										}
										else
										{
											$pagRedireccion="../modeloPerfiles/registroFormulario.php";
										}
									}
									else
									{
										$pagRedireccion=$paginaRedireccion;
										
									}
									$cadParamPOST="";
									if($paramPOST!="")
									{
										$arrParamPOST=explode("|",$paramPOST);
										$nParam=sizeof($arrParamPOST);
										
										for($x=0;$x<$nParam;$x++)
										{
											$vParamPOST=explode("=",$arrParamPOST[$x]);
											$obj='{"nombreP":"'.$vParamPOST[0].'","valorP":"'.$vParamPOST[1].'"}';
											if($cadParamPOST=="")
												$cadParamPOST=$obj;
											else
												$cadParamPOST.=",".$obj;
										}
									}
									
									if(isset($objParametros->eJs))
									{
										{
									?>
											<input type="hidden" name="eJs" value='<?php echo $objParametros->eJs ?>'/>
									<?php
										}
										
									}
									
									if(isset($objParametros->cPagina))
									{
										$cadParamPOST='{"nombreP":"cPagina","valorP":"'.$objParametros->cPagina.'"}';
										
									}
								
									if($cadParamPOST!="")
									{
								?>
                                		<input type="hidden" name="paramPost" value='[<?php echo $cadParamPOST?>]'/>
                                <?php
									}
									if(isset($objParametros->idReferenciaEval))
									{
								?>
										<input type="hidden" name="idReferenciaEval" value='<?php echo $objParametros->idReferenciaEval ?>'/>
                                <?php
									}
									if(isset($objParametros->actor))
									{
								?>
										<input type="hidden" name="actorProceso" value='<?php echo $objParametros->actor ?>'/>
                                <?php
									}
                                ?>
                                <input type="hidden" name="idPerfil" value="<?php echo $idPerfil?>" />
                                <input type="hidden" name="pagRedireccion" value="<?php echo $pagRedireccion?>"/>
                                <input type="hidden" name="post" value="configuracion" />
                                <input type="hidden" name="valorPost" id="valorPost" value="<?php echo $nConfRegresar ?>" />
                                <input type="hidden" name="idFormularioDinamico" value="<?php echo $idFormulario?>" />
                                <input type="hidden" id="ocultarBotonesCtrl" value="<?php echo $ocultarBotonesCtrl?>" />
                                <?php
								
                               if($idRegistroG=='-1')
                               {
								   
								   if(($idProcesoP!="")&&($idProcesoP!=-1))
								   		echo "<input type='hidden' name='_idProcesoPadreint' id='_idProcesoPadreint' value='".$idProcesoP."' />";
								    echo "<input type='hidden' name='_idReferenciaint' id='_idReferenciaint' value='".$idReferencia."' />";
                                    echo "<input type='hidden' name='_idEstadoint' id='_idEstadoint' value='".$idEstado."'>";
                                    echo "<input type='hidden' name='_fechaCreaciondta' id='_fechaCreaciondta' value=''>";
                                    echo "<input type='hidden' name='_responsableint' id='_responsableint' value='".$idUsuario."'>";
                                    echo "<input type='hidden' name='_codigoUnidadvch' id='_codigoUnidadvch' value='".$codigoUnidadUsuario."'>";
                                    echo '<input type="hidden" name="_codigoInstitucionvch" id="_codigoInstitucionvch" value="'.$codigoInstitucionUsuario.'" />';
									
									if($reglaFolio==2)
									{
										echo "<input type='hidden' name='_codigovch' value='".$codigo."'>";	
									}
									else
									{
										if($funcPHPEjecutarNuevo=="")
											$funcPHPEjecutarNuevo=bE("asignarFolioRegistro(".$idFormulario.",idRegPadre)");
										else
											$funcPHPEjecutarNuevo= bE("asignarFolioRegistro(".$idFormulario.",idRegPadre)|".bD($funcPHPEjecutarNuevo));
										
									}
									if($funcPHPEjecutarNuevo!="")
										echo "<input type='hidden' name='funcPHPEjecutarNuevo' id='funcPHPEjecutarNuevo' value='".$funcPHPEjecutarNuevo."'>";
									
									if((strpos($paginaRedireccion,"registroFormulario.php")!==false)||(strpos($paginaRedireccion,"verFichaFormulario.php")!==false))									
										echo "<input type='hidden' name='reemplazarIDSesion' value='".$nConfiguracion."'>";	

									if($funcEjecutarNuevo!="")
										echo "<input type='hidden' name='funcEjecutarNuevo' value='".$funcEjecutarNuevo."'>";	
                               }
                               else
                               {
                                    echo "<input type='hidden' name='_fechaModifdta' id='_fechaModifdta' value=''>";
                                    echo "<input type='hidden' name='_respModifint' id='_responsableint' value='".$_SESSION["idUsr"]."'>";
									if($funcEjecutarModif!="")
										echo "<input type='hidden' name='funcEjecutarModif' value='".$funcEjecutarModif."'>";	

									//if($funcPHPEjecutarModif!="")
										echo "<input type='hidden' name='funcPHPEjecutarModif' id='funcPHPEjecutarModif' value='".$funcPHPEjecutarModif."'>";
                               }
                                
                                 $query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 901_elementosFormulario where tipoElemento=20 and idFormulario=".$idFormulario;
                                 $res=$con->obtenerFilas($query);
                                 while($fila=$con->fetchRow($res))
                                 {
                                      $nombreControl=generarNombre($fila[1],$fila[2]);	
                                      $consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fila[0];
                                      $filaE=$con->obtenerPrimeraFila($consulta);
                                      if(($filaE[3]==1)||($idRegistro!='-1'))
                                      {
                                          $valor=obtenerValorSesion($filaE[2]);
                                          echo "<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valor."'>";
                                      }
                                 }


									$cad="var objMatrizCtrl;";
									foreach($arrEnlacesControles as $control=>$idQueries)
									{
										$cad.="objMatrizCtrl=new Array();";
										$cad.="objMatrizCtrl[0]='".$control."';";
										$cad.="objMatrizCtrl[1]=new Array();";
										$cad.="objMatrizCtrl[2]='".$diccionario[$control][0]."';";
										$cad.="objMatrizCtrl[3]='".$diccionario[$control][1]."';";
										$ct=0;
										foreach($idQueries as $q)
										{
											$cad.="objMatrizCtrl[1][".$ct."]=".$q.";";
											$ct++;
											
										}
										$cad.="matrizControles.push(objMatrizCtrl);";
									}
									$cad.="var queriesControles=new Array();";

									foreach($controlesQuery as $iQueri =>$arrControles)
									{
										$cad.="objMatrizCtrl=new Array();";
										$cad.="objMatrizCtrl[0]='".$iQueri."';";
										$cad.="objMatrizCtrl[1]=new Array();";
										$ct=0;
										foreach($arrControles as $c)
										{
											$cad.="objMatrizCtrl[1][".$ct."]='".$c."';";
											$ct++;
											
										}
										$cad.="queriesControles.push(objMatrizCtrl);";	
									}
									
									$cadDiccionarioCtrl="var diccionarioCtrl=new Array();";
									$ct=0;
									
									if(sizeof($diccionario)>0)
									{
										
										foreach($diccionario as $nControl=>$ctrl)
										{
											$cadDiccionarioCtrl.="diccionarioCtrl[".$ct."]=['".$nControl."','".$ctrl[0]."','".$ctrl[1]."','".$ctrl[2]."'];";
											$ct++;
										}	
									}
								
								
									if(($tipoProceso==1000)	&&(sizeof($arrParametrosEnvio)))
									{
										foreach($arrParametrosEnvio as $registro)
										{
											echo "<input type='hidden' name='".$registro[0]."' value='".$registro[1]."'><input type='hidden' name='mostrarRegresar' value='1'><input type='hidden' name='confReferencia' value='".$nConfiguracion."' />";	
										}
									}
                               ?>
                               
                               
                               </form>
                               
                               
                               	</td>
                                </tr>
                                </table>
                            </td>
                            <td  >
                            	<input type="hidden" id="evitarCodificacion" value="<?php echo $evitarCodificacion ?>" />
                                <input type='hidden'  id='ctrlDecodificado' value='0' />
                            	<input type='hidden'  id='idReferencia' value='<?php  echo $idReferencia ?>' />
                                <input type="hidden" name="hExisteTabla" id="hExisteTabla" value="<?php echo $validarExisteTabla ?>" />
                                <input type="hidden" name="hCtrlCalibrar" value="<?php echo bE("[".$calibrarCtrl."]")?>" id="hCtrlCalibrar" />
                                
                                <script>
									var arrTextRich=new Array();
									var arrFuncionesAfterEdit=new Object();
									var arrFuncionesGridDeposito=new Object();
									var arrFuncionesValidacionEdit=new Object();
                               <?php
								   	echo $arrConfiguraciones;
                                	
									echo "var ctrlEnfocar='".$ctrlEnfocar."';";
									$accionCancelar=$pagRegresar;
									if(isset($objParametros->accionCancelar))
										$accionCancelar=$objParametros->accionCancelar;
									echo $arrQueriesScript;
									
									echo $cad;

									echo $cadDiccionarioCtrl;
									
									
                                ?>
									
									function ejecutarFuncionesInicio()
									{

								<?php
										echo $funcionesControles;
										echo $funcionesJava;
										echo $funcionesJavaInicio;
										echo $scriptComplementario;
										echo $funcionesDisparadores;
										
								?>
										limpiarValorControl=true;	
										
										
									}
									
									function confirmarCierre()
									{
										function resp(btn)
										{
											if(btn=='yes')
											{
												
												<?php 
													if((strpos($accionCancelar,"javascript")!==false)||(strpos($accionCancelar,"window")!==false))
														echo $accionCancelar;
												?>
											}
										}
										msgConfirm('Est&aacute; seguro de querer cancelar la captura del registro?',resp);
									}
									
									
									
                               </script>
                                
                            </td>
                            	
                        <?php
						}
						
						$hFin=obtenerHoraMicrosegundos();
						
						
						?>
                        </tr>
                   	</table>
                   
                   	 
                   <div id="sticky" >
                      <table width="100%">
                      <tr>
                          <td align="center">
                              <table>
                                  <tr>
                                      
                                       <?php if($pCancelar)
									  {
										?>
                                      <td width="20">
                                            </td>
                                      <td><span id="contenedor2"></span></td>
                                      <td width="20">
                                            </td>
                                     
                                      <td><span id="contenedor3"></span></td>
                                      <?php
									  }
									  ?>
                                      <td><span id="contenedor1"></span></td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      </table>
                      
                    </div>
                        
                   	
                   
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
