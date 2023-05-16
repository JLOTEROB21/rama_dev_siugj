<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include_once("funcionesFormularios.php");

function crearElementosFormulario()
{
		global $funcionesJava;
		global $con;
		global $et;
		global $idFormulario;
		global $nTabla;
		$nombreTabla=$nTabla;
		global $calibrarCtrl;
		global $cc;
		global $numElementos;
		global $arrElementosFocus;
		global $nElementosFocus;
		global $arrQueries;
		global $tipoProceso;
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,visible,tagXML from 901_elementosFormulario where tipoElemento in (1,13,30) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"];
		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		$estiloDiv="";
		while($filas=mysql_fetch_row($res))
		{
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$filas[0];
			$fConfiguracionElemento=$con->obtenerPrimeraFilaAsoc($consulta);
			switch($filas[2])
			{
				case "1":
					$estiloDiv='z-index:10;';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$etiqueta="<div class='".$filaE[13]."' id='_lbl".$filas[0]."' enlace='".$filaE[5]."' style='width:".$filaE[2]."px; height:".$filaE[3]."px; ' >".$HRef.'<span id="sp_'.$filas[0].'">'.$filas[1]."</span>".$cHRef."</div>";
				break;
				case 13:
					$estiloDiv='z-index:0;';
					$query="select campoConf1,campoConf2 from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$confCampo=$con->obtenerPrimeraFila($query);
					$etiqueta="<fieldset class='frameHijoV3' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px;'  ><legend> ".$filas[1]."</legend></fieldset>";
				break;
				case 30:
					$estiloDiv='z-index:10;';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$valor=$filaE[4];
					$etiqueta="<div funcRenderer='".$filaE[19]."' class='".$filaE[13]."' id='_".$filas[1]."vch' idAlmacen='".$filaE[2]."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">['.$valor."]</span>".$cHRef."</div>";
				
				break;
			}
			
			$eliminable="1";
			if($filas[6]=="0")
				$eliminable="0";

			
			$btnEliminar="";
			$tabla=	 "	<table class='tablaControl'>
    						<tr>
								<td ></td>
                    			<td id='td_".$filas[0]."'>".$etiqueta;
			$columnas="";
			$ancho=105;
			mysql_data_seek($res5,0);
			while($fila5=mysql_fetch_row($res5))
			{		
			
				$queryAux10="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$filas[0]." and idIdioma=".$fila5[0];
				$valorEt=$con->obtenerValor($queryAux10);
				$tabla.="<input type='hidden' id='td_".$filas[0]."_".$fila5[0]."' value='".$valorEt."'>";
			}
								
			$tabla.=	"</td><td valign='top'>".$btnEliminar."	</td>
                    		</tr>
    					</table>";
			
			if($filas[2]!=30)		
				$div="<div tagXML='".$filas[8]."' eliminable='".$eliminable."' id='div_".$filas[0]."' visible='".$filas[7]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute;".$estiloDiv."' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='_lbl".$filas[0]."_".$filas[2]."'>".$tabla."</div>";			
			else
				$div="<div tagXML='".$filas[8]."' eliminable='".$eliminable."' id='div_".$filas[0]."' visible='".$filas[7]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute;".$estiloDiv."' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='_".$filas[1]."vch_".$filas[2]."'>".$tabla."</div>";							
			echo $div;
			if($calibrarCtrl=="")
				$calibrarCtrl="'div_".$filas[0]."'";
			else
			$calibrarCtrl.=",'div_".$filas[0]."'";
			
		}
		$compCtrl="";
		if($tipoProceso==1000)
			$compCtrl=",-1";
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,orden,visible,habilitado,etiquetaExportacion,tagXML from 901_elementosFormulario where tipoElemento not in 
				(1,20,13,30,-2,-1,0".$compCtrl.") and idFormulario=".$idFormulario." order by orden";
		$res=$con->obtenerFilas($query);
		
		while($fElemento=mysql_fetch_row($res))
		{
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$fElemento[0];
			$fConfiguracionElemento=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$numElementos++;
			$ignorarLimites="";
			if($fElemento["6"]=="1")
				$mostrarEliminar=true;
			else
				$mostrarEliminar=false;
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
//			$asteriscoRojo="";
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);	
			$queryAyuda="select mensajeAyuda from 914_mensajesAyuda where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$fElemento[0];
			$msgAyuda=$con->obtenerValor($queryAyuda);
			$habilitado="";
			if($fElemento[9]=="0")
				$habilitado="disabled='disabled'";
			
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
                  	$consulta="select idFormulario,nombreFormulario from 900_formularios where idFrmEntidad=".$idFormulario;
					$resFrm=$con->obtenerFilas($consulta);
					if(mysql_num_rows($resFrm)>0)
					{
						while($filaFrm=mysql_fetch_row($resFrm))
						{
							$etiqueta.= "<tr height='23'>
											<td  width='30'>&nbsp;<img src='../images/icon_code.gif'></td>
											<td class='letraFichaRespuesta' align='left' >".$filaFrm[1]."</td>
										</tr>";
						}
					}
					$etiqueta.="</table>";	
					$ignorarLimites='ignorarLimites="actualizar"';
					$mostrarEliminar=false;
					$numElementos--;
				break;
				case -1://button
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input type='button' id='btn_-1' value='".$et["lblCancelar"]."' class='".$filaE[13]."'>";
					$mostrarEliminar=false;
				break;
				case 0://button
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($tipoProceso==1000)
					{
						$et["lblGuardar"]="Aceptar";
						$filaE[13]="btnAceptar";
					}
					$etiqueta="<input type='button' id='btn_0' value='".$et["lblGuardar"]."' class='".$filaE[13]."'>";
					$mostrarEliminar=false;
				break;
				case 2: //pregunta cerrada-Opciones Manuales
					$btnAgregarElemento="";
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$anchoC=$filaE[11];
					$estiloAncho="";
					if($anchoC!="")
						$estiloAncho=' style="width: '.$anchoC.'px" ';
					$orden="";
					$vDefault=$filaE[17];	
					if($vDefault=="")
						$vDefault="-1";
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
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					if($filaE[14]=="1")
						$btnAgregarElemento='<img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento">';
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;
					$etiqueta="	
								<table>
									<tr>
										<td>
											<input type='hidden' value='".$filaE[2]."' id='ordenOpt".$nombreControl."'>
											<select ".$estiloAncho." ancho='".$anchoC."' funcRenderer='".$filaE[19]."' vDefault='".$vDefault."' class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado." ><option value='-1'>Elija una opción</option>";
													$etiqueta.=	$con->generarOpcionesSelectNoImp($queryOpt,$vDefault);	
					$etiqueta.="			</select>
										</td>
										<td>
											&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
										</td>
									</tr>
								</table>";
				break;
				case 3: //pregunta cerrada-Opciones intervalo
					$btnAgregarElemento="";
					
					//$btnAgregarElemento='<a href="javascript:agregarElemento(\''.bE($fElemento[0]).'\')"><img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento"></a>';
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];		
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$anchoC=$filaE[11];
					$estiloAncho="";
					if($anchoC!="")
						$estiloAncho=' style="width: '.$anchoC.'px" ';
					$vDefault=$filaE[17];	
					if($vDefault=="")
						$vDefault="-1";
					$etiqueta="	
								<table>
									<tr>
										<td>
											<select ".$estiloAncho." ancho='".$anchoC."' funcRenderer='".$filaE[19]."' vDefault='".$vDefault."' class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado."><option value='-1'>Elija una opción</option>";
												$etiqueta.=$con->generarNumeracionSelectNoImp($filaE[2],$filaE[3],$vDefault,$filaE[4]);
					$etiqueta.="			</select>
										</td>
										<td>
											&nbsp;<span id='spAgregar_".$fElemento[0]."'></span>
										</td>
									</tr>
								</table>";
					
					
				break;
				case 4: //pregunta cerrada-Opciones tabla
					$btnAgregarElemento="";
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$vDefault=$filaE[17];	
					if($vDefault=="")
						$vDefault="-1";
					$tablaOD=$filaE[2];
					$campoProy="concat(".$filaE[3].")";
					$campoId=$filaE[4];
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
						$multiSelect="multiple";
					$estiloAncho="";
					if($anchoC!="")
						$estiloAncho=' style="width: '.$anchoC.'px" ';
					if(($altoControl!="")&&($altoControl!=0))
							$estiloAncho=' style="height: '.$altoControl.'px" ';
					if($filaE[14]=="1")
						$btnAgregarElemento='<img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento">';
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					$obtenerOpciones=true;
					$arrElemento="";
					$cadAlmacen="";
					if(($autocompletar=="0")||($autocompletar==''))
					{
						
						if($filaE[5]=='1')
						{
							$controlDestino=$fElemento[1];
							$valorCampo='-1';
							if($filaE[12]!="1")
							{
								//$funcion="actualizarCombo(this,'".$campoFiltro."','".$condicionFiltro."','".$controlDestino."');";
								$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');asignarEventoChange(comboD); ";
							}
							if($condWhere=="")
								$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' order by ".$campoProy;
							else
								$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." order by ".$campoProy;
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
								$cadAlmacen= 'idAlmacen="'.$tablaOD.'"';
								$arrCamposProy=split('@@',$filaE[3]);
								if($arrQueries[$tablaOD]["ejecutado"]==1)
								{
									$resQuery=$arrQueries[$tablaOD]["resultado"];
									$conAux=$arrQueries[$tablaOD]["conector"];
									
									$conAux->inicializarRecurso($resQuery);	
										
									$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"2","imprimir":"0","campoID":"'.$campoId.'"}';
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
								
						}
						
						if($filaE[17]==2)
						{
							$consulta="SELECT nombreFormulario FROM 900_formularios WHERE idFormulario=".$filaE[18];
							$filaE[18]=$con->obtenerValor($consulta);
						}
						$etiqueta="	
								<table>
									<tr>
										<td>
												<select ".$multiSelect." ".$estiloAncho." ancho='".$anchoC."' funcRenderer='".$filaE[19]."' vDefault='".$vDefault."' permiteAgregar='".$filaE[14]."'  tipoPagina='".$filaE[17]."' valorPagina='".$filaE[18]."' class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado." ".$cadAlmacen." ><option value='-1'>Elija una opción</option>";
											if($obtenerOpciones)
												$etiqueta.=	$con->generarOpcionesSelectNoImp($query,$vDefault);	
											else
												$etiqueta.= $arrElemento;
						$etiqueta.="			</select>
										</td>
										<td>
											&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
										</td>
									</tr>
								</table>";
						
					}
					else
					{
						if($habilitado!="")
							$habilitado="true";
						else
							$habilitado="false";
							
						if(strpos($tablaOD,"[")!==false)
							$cadAlmacen= ' idAlmacen="'.str_replace("]","",str_replace("[","",$tablaOD)).'"';	

						if($autocompletar==1)
						{
							
							
							
							$etiqueta="	
									<table>
										<tr>
											<td>
													<input type='text' name='t_".$nombreControl."' id='t_".$nombreControl."' value=''>
													<input permiteAgregar='".$filaE[14]."'  tipoPagina='".$filaE[17]."' valorPagina='".$filaE[18]."' type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."' auto='true' ancho='".$anchoC."' extId='ext_".$nombreControl."' ".$cadAlmacen.">
											</td>
											<td>
												&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
											</td>
										</tr>
									</table>";
							$funcionesJava.="	function antesCargaExt_".$nombreControl."(dSet)
												{
													var aValor=Ext.getCmp('ext_".$nombreControl."').getValue();
													dSet.baseParams.criterio=aValor;
													dSet.baseParams.idGrupoControl=".$fElemento[0].";
													gE('".$nombreControl."').value='';
												};
												crearComboExtAutocompletar(
																			{
																				idCombo:'ext_".$nombreControl."',
																				txtDestino:'t_".$nombreControl."',
																				anchoCombo:".(($anchoC=="")?100:$anchoC).",
																				campoHDestino:'".$nombreControl."',
																				funcAntesCarga:antesCargaExt_".$nombreControl.",
																				desHabilitado:".$habilitado."
																			}
																		);";
						}
						else
						{
							$etiqueta="	
									<table>
										<tr>
											<td>
													<span id='t_".$nombreControl."'>
													<input permiteAgregar='".$filaE[14]."'  tipoPagina='".$filaE[17]."' valorPagina='".$filaE[18]."' type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."' auto='true' ancho='".$anchoC."' extId='ext_".$nombreControl."' ".$cadAlmacen.">
											</td>
											<td>
												&nbsp;<span id='spAgregar_".$fElemento[0]."'>".$btnAgregarElemento."</span>
											</td>
										</tr>
									</table>";
							$funcionesJava.="crearComboExt('ext_".$nombreControl."',[],0,0,".(($anchoC=="")?100:$anchoC).",{renderTo:'t_".$nombreControl."'});";
							if($habilitado=="true")
							{
								$funcionesJava.="gEx('ext_".$nombreControl."').disable();";
							}
						}
					}	
				break;
				case 5: //Texto Corto
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$maxPalabras=$filaE[4];
					if($maxPalabras=="")
						$maxPalabras=0;
					$etiqueta= "<input funcRenderer='".$filaE[19]."' objAlmacenDatos='".bE($filaE[5])."' type='text' name='".$nombreControl."' id='".$nombreControl."' value='' maxWord='".$maxPalabras."' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."' ".$habilitado."  >";
				break;
				case 6: //Número entero
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($val=='')
						$val='num';
					else
						$val.='|num';
					
					$etiqueta= "<input objAlmacenDatos='".bE($filaE[5])."' type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[2]."' class='".$filaE[13]."' ".$habilitado." onkeypress='return soloNumero(event,false,false)' val='".$val."' >
								<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>
					";
							
				break;
				case 7: //Número decimal
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($val=='')
						$val='flo';
					else
						$val.='|flo';
					$etiqueta= "<input objAlmacenDatos='".bE($filaE[5])."' type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[2]."' class='".$filaE[13]."' ".$habilitado." onkeypress='return soloNumero(event,true,false,this)' val='".$val."' >
								<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
					  			<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>
								<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[7]."'>
								";
							
				break;
				case 8: //Fecha
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$fechaMin=bE($filaE[2]);
					$fechaMax=bE($filaE[3]);
					$diasSel=bE($filaE[4]);
					$etiqueta= "	<div id='sp".$nombreControl."'></div>
									<input objAlmacenDatos='".bE($filaE[5])."' type='hidden' name='".$nombreControl."' fechaMin='".$fechaMin."' fechaMax='".$fechaMax."' diasSel='".$diasSel."' id='".$nombreControl."' value='' val='".$val."'  extId='f_sp".$nombreControl."'>";
					$compHabilitado="";
					if($habilitado!="")
						$compHabilitado="Ext.getCmp('f_sp".$nombreControl."').disable();";
						
						
					$objConf='{';
					$estilo=$fConfiguracionElemento["campoConf12"];
					if($estilo!="")
					{
						$objConf.='"ctCls":"'.$estilo.'"';
					}
					
					if($fConfiguracionElemento["campoConf10"]!="")
					{
						if($objConf=='{')
							$objConf.='"width":'.$fConfiguracionElemento["campoConf10"];
						else
							$objConf.=',"width":'.$fConfiguracionElemento["campoConf10"];
					}
					
					$objConf.='}';	
		
					$funcionesJava.="crearCampoFecha('sp".$nombreControl."','".$nombreControl."',null,null,null,".$objConf.");".$compHabilitado;
				break;
				case 9://Texto Largo 
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$maxPalabras=$filaE[4];
					if($maxPalabras=="")
						$maxPalabras=0;
					$maxCaracteres=$filaE[5];
					if($maxCaracteres=="")
						$maxCaracteres=0;	
					$etiqueta="<textarea funcRenderer='".$filaE[19]."' objAlmacenDatos='".bE($filaE[6])."' maxWord='".$maxPalabras."' maxlength='".$maxCaracteres."' name='".$nombreControl."' id='".$nombreControl."' style='height:".$filaE[3]."px !important; width:".$filaE[2]."px !important' class='".$filaE[13]."' val='".$val."' ".$habilitado." ></textarea>";
				break;
				case 10: //Texto Enriquecido
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<span name='txtEnriquecido_".$fElemento[0]."' id='txtEnriquecido_".$fElemento[0]."' val='".$val."'></span>";
					$compHabilitado="";
					if($habilitado!="")
						$compHabilitado="if(Ext.getCmp('".$nombreControl."')){Ext.getCmp('".$nombreControl."').disable();}";
					$funcionesJava.="crearTextoEnriquecido('".$nombreControl."','txtEnriquecido_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",'','".$filaE[4]."',".$fElemento[9].");".$compHabilitado;
				break;
				case 11: //Correo Electrónico
					if($val=='')
						$val='mail';
					else
						$val.='|mail';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input objAlmacenDatos='".bE($filaE[5])."' type='text' name='".$nombreControl."' id='".$nombreControl."' value='' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."' ".$habilitado." >";
				break;
				case 12: //Archivo
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input type='file' class='".$fConfiguracionElemento["campoConf12"]."' name='".$nombreControl."' id='".$nombreControl."' value='".$et["lblSelArchivo"]."'  val='".$val."' >";
				break;
				case 14:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$filaE=$fConfCampo;
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$elemSel=$fConfCampo[10];
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
					if($elemSel=='')
						$elemSel='100584';
					$etiqueta="<input type='hidden' value='".$fConfCampo[2]."' id='ordenOpt".$nombreControl."'><span id='span".$nombreControl."'><table >";
					$nCol=0;
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$fRes[0])
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'"  >
											<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' disabled="disabled" >
											</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
							else
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'" >
											<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' disabled="disabled"  checked="checked">
											</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
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
					}
					$etiqueta.="</table></span><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' funcRenderer='".$filaE[19]."' id='".$nombreControl."' name='".$nombreControl."' class='".$filaE[13]."' val='".$val."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 15:
					$etiqueta="<span id='span".$nombreControl."'><table>";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[10];
					if($elemSel=='')
						$elemSel='100584';
					if($filaE[2]<$filaE[3])	
					{	
						for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								if($elemSel!=$x)
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input  type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.' ></td>
												<td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked"></td>
												<td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								
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
						}
					}
					else
					{
						for($x=$filaE[2];$x>=$filaE[3];$x-=$filaE[4])
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								if($elemSel!=$x)
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input  type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.' >
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked">
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								
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
						}
						
	
					}
						$etiqueta.="</table></span><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' funcRenderer='".$filaE[19]."' id='".$nombreControl."' class='".$filaE[13]."' name='".$nombreControl."' val='".$val."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 16:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."'>";
					$nCol=0;
					$tablaOD=$filaE[2];
					$campoProy=$filaE[3];
					$campoId=$filaE[4];
					$campoFiltro=$filaE[8];
					$condicionFiltro=$filaE[7];
					$controlFiltro="_".$filaE[6]."vch";
					$controlDestino=$fElemento[1];
					$obtenerOpciones=true;
					$cadAlmacen="";
					$arrElemento=NULL;
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($filaE[5]=='1')
					{
						if($filaE[12]!='1')
						{
							//$funcion="actualizarListado(this,'".$campoFiltro."','".$condicionFiltro."','tbl".$nombreControl."');";
							$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');asignarEventoChangeListado(comboD,16); ";
						}
					}
					
					if(($filaE[5]=='1')&&($filaE[12]!='1'))
					{
						$queryOpt="select '-1' as valor,'".$et["lblSeleccione"]."' as contenido";
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
							$cadAlmacen= 'idAlmacen="'.$tablaOD.'"';
							$arrCamposProy=split('@@',$filaE[3]);
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
					}
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[10];
					if($elemSel=='')
						$elemSel='100584';
					if($obtenerOpciones)
					{
						$resOpt=$con->obtenerFilas($queryOpt);
						
						
						while($fRes=mysql_fetch_row($resOpt))
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								if($elemSel!=$fRes[0])
									$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'" >
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' >
												</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'" >
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'  checked="checked">
												</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
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
						}
					}
					else
					{
						if($arrElemento!=NULL)	
						{
							foreach($arrElemento as $e)
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
								if($elemSel!=$e[0])
									$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'" >
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$e[0].'" name="opt'.$nombreControl.'" value="'.$e[0].'" '.$habilitado.' >
												</td><td width="5"></td><td>'.$e[1].'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'" >
												<table><tr><td><input type="radio" id="opt'.$nombreControl.'_'.$e[0].'" name="opt'.$nombreControl.'" value="'.$e[0].'" '.$habilitado.'  checked="checked">
												</td><td width="5"></td><td>'.$e[1].'</td></tr></table></td><td width="20"></td>';
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
							}
						}
						else
						{
							$etiqueta.='<td class="'.$filaE[13].'" width="150" name="td_'.$nombreControl.'" >Sin opciones disponibles</td>';
						}
					}
					
					$etiqueta.="</table></span><input type='hidden' value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input class='".$filaE[13]."' funcRenderer='".$filaE[19]."' type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='".$val."' ".$cadAlmacen." > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 17:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$elemSel=$fConfCampo[10];
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
					if($elemSel=='')
						$elemSel='100584';
					$etiqueta="<input type='hidden' value='".$fConfCampo[2]."' id='ordenOpt".$nombreControl."'><span id='span".$nombreControl."'><table >";
					$nCol=0;
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." ".$orden;
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." ".$orden;
						
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$fRes[0])
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'" >
											<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' disabled="disabled" >
											</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
							else
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'" >
											<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' disabled="disabled" checked="checked">
											</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
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
					}
					$minObl=$fConfCampo[10];
					if($minObl=="-1")
						$minObl="0";
					
					$etiqueta.="</table></span><input type='hidden' funcRenderer='".$filaE[19]."' class='".$filaE[13]."' id='".$nombreControl."' name='".$nombreControl."' value=''><input type='hidden' id='minSel".$nombreControl."' value='".$minObl."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 18:
					$etiqueta="<span id='span".$nombreControl."'><table>";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[7];
					if($elemSel=='')
						$elemSel='100584';
					if($filaE[2]<$filaE[3])
					{
						for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								if($elemSel!=$x)
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.' >
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked">
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								
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
						}
					}
					else
					{
						for($x=$filaE[2];$x>=$filaE[3];$x-=$filaE[4])
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								if($elemSel!=$x)
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.' >
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								else
									$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'" name="td_'.$nombreControl.'">
												<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked">
												</td><td width="5"></td><td>'.$x.'</td></tr></table></td><td width="20"></td>';
								
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
						}

					}
					$minObl=$filaE[10];
					if($minObl=="-1")
						$minObl="0";
					$etiqueta.="</table></span><input type='hidden' funcRenderer='".$filaE[19]."' class='".$filaE[13]."' id='".$nombreControl."' name='".$nombreControl."' value=''><input type='hidden' id='minSel".$nombreControl."' value='".$minObl."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 19:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$tablaOD=$filaE[2];
					$campoProy=$filaE[3];
					$campoId=$filaE[4];
					$campoFiltro=$filaE[8];
					$condicionFiltro=$filaE[7];
					$controlFiltro="_".$filaE[6]."vch";
					$controlDestino=$fElemento[1];
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' >";
					$nCol=0;
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					$obtenerOpciones=true;
					$arrElemento=NULL;
					$cadAlmacen="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($filaE[5]=='1')
					{
						$valorCampo='-1';
						if($filaE[12]!='1')
						{
							//$funcion="actualizarListado(this,'".$campoFiltro."','".$condicionFiltro."','tbl".$nombreControl."');";
							$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');asignarEventoChangeListado(comboD,19); ";
							$queryOpt="select '-1' as valor,'".$et["lblSeleccione"]."' as contenido";
						}
						else
						{
							if($condWhere=='')
								$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' order by ".$campoProy;
							else
								$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." order by ".$campoProy;
						}
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
							$arrCamposProy=split('@@',$filaE[3]);
							$cadAlmacen='idAlmacen="'.$tablaOD.'"';
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
					}
					
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					if($obtenerOpciones)
					{
						$resOpt=$con->obtenerFilas($queryOpt);
						while($fRes=mysql_fetch_row($resOpt))
						{
							if($nCol==0)
								$etiqueta.='<tr height="23">';
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'" >
											<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'  >
											</td><td width="5"></td><td>'.$fRes[1].'</td></tr></table></td><td width="20"></td>';
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
						}
					}
					else
					{
						if($arrElemento!=NULL)	
						{
							foreach($arrElemento as $e)
							{
								if($nCol==0)
									$etiqueta.='<tr height="23">';
								$etiqueta.='<td width="'.$anchoCelda.'" class="'.$filaE[13].'"  name="td_'.$nombreControl.'"  >
											<table><tr><td><input type="checkbox" id="opt'.$nombreControl.'_'.$e[0].'" name="'.$nombreControl.'" value="'.$e[0].'" '.$habilitado.'  >
											</td><td width="5"></td><td>'.$e[1].'</td></tr></table></td><td width="20"></td>';
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
							}
						}
						else
						{
							$etiqueta.='<td class="'.$filaE[13].'" width="150" name="td_'.$nombreControl.'" >Sin opciones disponibles</td>';
						}
					}
					$minObl=$filaE[10];
					if($minObl=="-1")
						$minObl="0";
					$etiqueta.="</table></span><input funcRenderer='".$filaE[19]."' class='".$filaE[13]."' type='hidden' id='".$nombreControl."' name='".$nombreControl."' ".$cadAlmacen." value=''><input type='hidden' id='minSel".$nombreControl."' value='".$minObl."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$anchoCelda."' id='ancho".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='nColumnas".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 21: //Hora
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$fMax=$filaE[2];
					$fMin=$filaE[3];
					$intervalo=$filaE[4];
					$etiqueta= "	<div id='sp".$nombreControl."'></div>
									<input objAlmacenDatos='".bE($filaE[5])."' type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."' hMin='".$fMin."' hMax='".$fMax."' intervalo='".$intervalo."'  extId='f_sp".$nombreControl."'>";
					

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
						
					$objConf='{';
					$estilo=$fConfiguracionElemento["campoConf12"];
					if($estilo!="")
					{
						$objConf.='"ctCls":"'.$estilo.'"';
					}
					
					if($fConfiguracionElemento["campoConf10"]!="")
					{
						if($objConf=='{')
							$objConf.='"width":'.$fConfiguracionElemento["campoConf10"];
						else
							$objConf.=',"width":'.$fConfiguracionElemento["campoConf10"];
					}
					
					$objConf.='}';		
						
					$funcionesJava.="crearCampoHora('sp".$nombreControl."','".$nombreControl."',".$fMax.",".$fMin.",".$intervalo.",".$objConf.");".$compHabilitado;
				break;
				case 22: //Etiqueta operacion
					$consulta="select * from 929_operacionesCampoExpresion where idElemFormulario=".$fElemento[0];
					$resOperaciones=$con->obtenerFilas($consulta);
					$cadena="";
					$obj="";
					$arrExp="";
					$funcionesEvento="";
					$asignacionEvento="";
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					while($filaOperacion=mysql_fetch_row($resOperaciones))
					{
						$obj='["'.$filaOperacion[3].'","'.$filaOperacion[2].'","'.$filaOperacion[4].'"]';
						if($arrExp=="")
							$arrExp=$obj;
						else
							$arrExp.=",".$obj;
						/*if($filaOperacion[4]==2)
						{
							$funcionesEvento.="funcionCalcular= function (evento)
															{
																
																evaluarExpresion('".$nombreControl."');
															};";
							$asignacionEvento.="asignarEvento('".$filaOperacion[3]."','change',funcionCalcular);";
						}*/
					}
					
					
					//1861757
					
					$etiqueta="	<label name='lbl_".$nombreControl."' id='lbl_".$nombreControl."' class='".$filaE[13]."'>0.00</label>
							 	<input type='hidden' name='exp_".$nombreControl."' id='exp_".$nombreControl."' value='[".$arrExp."]'>
								<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value=''>
								<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[2]."'>
								<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
								<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
								<input type='hidden' name='tratoDec_".$nombreControl."' id='tratoDec_".$nombreControl."' value='".$filaE[5]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>
								
					";
					//$funcionesJava.="evaluarExpresion('".$nombreControl."');";
					//$funcionesJava.=$funcionesEvento.$asignacionEvento;

				break;
				case 23: //Imagen
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";
							
				break;
				case 24: //Moneda
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<input objAlmacenDatos='".bE($filaE[5])."' type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[7]."' class='".$filaE[13]."' val='".$val."' ".$habilitado."  >
								<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[2]."'>
					  			<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
					  			<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>";
				break;
				case 25: //Fecha-hora SL
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<input confCampo='".bE('{"formato":"'.$filaE[3].'","ancho":"'.$filaE[2].'","origenFecha":"'.$filaE[4].'"}')."' funcRenderer='".$filaE[19]."' type='text' name='".$nombreControl."' id='".$nombreControl."'  size='".$filaE[2]."' class='".$filaE[13]."' value='".$filaE[3]."'>";
				break;
				case 29:
					$ocultarCabecera=0;
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($filaE[7]=="")
						$filaE[7]=1;
					if($filaE[9]=="")
						$filaE[9]="Agregar";
					if($filaE[10]=="")
						$filaE[10]="Remover";
						
					if($filaE[13]=="")
						$filaE[13]=1;	
					
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
					$objConf='{"ocultarCabecera":"'.$ocultarCabecera.'","etAgregar":"'.$filaE[9].'","etRemover":"'.$filaE[10].'"';
					
					$estilo=$fConfiguracionElemento["campoConf12"];
					if($estilo!="")
					{
						$objConf.=',"ctCls":"'.$estilo.'"';
					}
					
					$objConf.='}';
					
					
					$etiqueta="<span origenDatos='".bE($filaE[11])."' etAgregar='".$filaE[9]."' etRemover='".$filaE[10]."' id='contenedorSpanGrid_".$fElemento[0]."' permiteAgregar='".$filaE[7]."' permiteModificar='".$filaE[5]."' permiteEliminar='".$filaE[6]."' val='".$val."'><span id='spanGrid_".$fElemento[0]."'></span></span>";
					$consulta="SELECT * FROM 9039_configuracionesColumnasCampoGrid WHERE idElemento=".$fElemento[0]." order by orden";
					$resConf=$con->obtenerFilas($consulta);
					$arrCampos="{name: 'idRegistro'}";
					$arrCabeceras="";
					$mPermisos="";
					if($filaE[5]=="1")
						$mPermisos="M";
					if($filaE[6]=="1")
						$mPermisos.="E";
					if($filaE[7]=="1")
						$mPermisos.="A";
					while($filaConf=mysql_fetch_row($resConf))
					{
						$asterisco="";
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
															hidden:".$oculto."
										}";
						if($arrCabeceras=="")
							$arrCabeceras=$objCabecera;
						else
							$arrCabeceras.=",".$objCabecera;
							
					}
					$arrCampos="[".$arrCampos."]";
					$arrCabeceras="[".$arrCabeceras."]";
					$habilitado="false";					
					if($fElemento[9]==1)
						$habilitado="true";
					
					$funcionesJava.="crearCampoGridFormulario('grid_".$fElemento[0]."','spanGrid_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.",true,".$objConf.");";
					
				break;
				case 31:
						$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
						$filaE=$con->obtenerPrimeraFila($consulta);
						$HRef="";
						$cHRef="";
						if($filaE[5]!="")
						{
							$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
							$cHRef="</a>";	
						}
						$valor=$filaE[4];
						
						$claseRespuesta=$filaE[13];
						$etiqueta="<span class='".$claseRespuesta."' parametro='".$valor."' id='".$nombreControl."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">['.$valor."]</span>".$cHRef."</span>";
					break;
				case 33: //Imagen
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<img src='../images/imgNoDisponible.jpg' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";
							
				break;
			}				
			/*if($mostrarEliminar)
				$btnEliminar='<div style="z-index:10000" >&nbsp;<a href="javascript:eliminarElemento(\''.$fElemento[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a></div>';
			else*/
			$btnEliminar="";
			$eliminable="1";
			if($filas[6]=="0")
				$eliminable="0";
			$ayuda="";
			if($msgAyuda!="")
			{
				$ayuda='&nbsp;&nbsp;<span data-ot="'.htmlentities($msgAyuda).'" data-ot-border-width="2" data-ot-stem-length="18" data-ot-stem-base="20" data-ot-tip-joint="top" data-ot-border-color="#317CC5" data-ot-style="glass" ><img id="imgAyuda_'.$fElemento[0].'" src="../images/question.png" height="16" width="16"></span>';
			}
			$tabla=	 "	<table class='tablaControl'>
    						<tr >
								<td valign='top' id='td_obl_".$fElemento[0]."' width='0' >".$asteriscoRojo."</td>
                    			<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
								<td valign='top'>".$btnEliminar."</td>
								<td id='tdAyuda_".$fElemento[0]."'><span id='spAyuda_".$fElemento[0]."'>".$ayuda."</span></td>".
                    		"</tr>
    					</table>";
						
						
			$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$fElemento["0"];
			$objElemento=utf8_encode($con->obtenerFilasJSON($consulta));
			

						
			$div="<div objConfElemento='".bE($objElemento)."' tagXML='".$fElemento[11]."' etiquetaExportacion='".$fElemento[10]."' eliminable='".$eliminable."'  id='div_".$fElemento[0]."' visible='".$fElemento[8]."' habilitado='".$fElemento[9]."' style='top:".$fElemento[5]."px; left:".$fElemento[4]."px; position:absolute;' class='frameSel' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='".$nombreControl."_".$fElemento[2]."' ".$ignorarLimites."  orden='".$fElemento[7]."'>".$tabla."</div>";			
			echo $div;	
			
			if($calibrarCtrl=="")
				$calibrarCtrl="'div_".$fElemento[0]."'";
			else
				$calibrarCtrl.=",'div_".$fElemento[0]."'";
			
			if(($fElemento[2]!=-2)&&($fElemento[2]!=22))
			{
				$arrElementosFocus.="arrElementosFocus[".$nElementosFocus."]='div_".$fElemento[0]."';";
				$nElementosFocus++;
			}
		}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
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

<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estilosFormulariosDinamicos.css"/>

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
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script src="../Scripts/ckeditor/ckeditor.js" ></script>

<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/EditableItem.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/RangeMenu.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/ListMenu.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/GridFilters.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/Filter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/StringFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/DateFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/ListFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/NumericFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/BooleanFilter.js"></script>
<script type="text/javascript" src="../thotFormularios/Scripts/funcionesFormulario.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/colorField/ext.ux.ColorField.css" />
<script type="text/javascript" src="../Scripts/ux/colorField/ext.ux.ColorField.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/columnNodeUI.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/column-tree.css" />
<script type="text/javascript" src="../Scripts/ux/columnNodeUI.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
<script type="text/javascript" src="../thotFormularios/Scripts/thotGrid.js.php"></script>
<script type="text/javascript" src="../thotFormularios/Scripts/thotGuardarControles.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/opentip/opentip.css" media="screen" />
<script type="text/javascript" src="../Scripts/opentip/opentip-jquery-excanvas.min.js"></script>

<?php
	$guardarConfSession=true;
	$mostrarRegresar=false;
	$respetarEspacioRegresar=true;
	$mostrarUsuario=false;
	
?>
<style>
	#sticky 
	{
		position: fixed;
		top: 5px;
		width: 97%;
		background-color: #F5F5F5;
		z-index:10000;
		text-align:center;
		
	}
</style>
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
                   <tr >
                   		<?php 
							$idFormulario="-1";

							if(isset($objParametros->idFormulario))
								$idFormulario=$objParametros->idFormulario;
							$funcionesJava="";
							$calibrarCtrl="";
							$cc=0;
							$consulta="select * from 901_elementosFormulario where idFormulario=".$idFormulario;
							$res=$con->obtenerFilas($consulta);
							if(mysql_num_rows($res)==0)
								crearControlesDefaultFormulario($idFormulario);
							$query="select nombreTabla,anchoGrid,altoGrid,mostrarMarco,campoDescriptivo,idProceso  from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($query);
							$nTabla=$fila[0];
							$anchoGrid=$fila[1];
							$altoGrid=$fila[2];
							$mMarco=$fila[3];
							$campoDescriptivo=$fila[4];
							$idProceso=$fila[5];
							$tipoProceso=obtenerTipoProceso($idProceso);
							if($tipoProceso!=1000)
							{
								if(!crearTablaFormulario($nTabla))
									return;
							}
							$numElementos=0;
							$nElementosFocus=0;

							$arrElementosFocus="";
							$consulta="select titulo,idProceso,configuracionFormulario from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($consulta);
							$titulo=$fila[0];
							$tituloC=$fila[0];
							$idProceso=$fila[1];
							$configuracionFormulario=$fila[2];
							$claseFrame="gridRejilla";
							if($mMarco==0)
							{
								$titulo="";
								$claseFrame="gridRejilla";
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
							$cadObj='{"paramAmbiente":{'.$cadParam.'},"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"-1","p4":"0","p5":"0","p6":"-1"}}';
							$paramObj=json_decode($cadObj);

							$arrQueries=resolverQueries($idFormulario,5,$paramObj,true);

							$arrQueriesResueltas="";
							if(sizeof($arrQueries)>0)
							{
								foreach($arrQueries as $idAlmacen=>$qy)
								{
									if($idAlmacen!=-1000)
									{
										if($qy["ejecutado"]==1)
										{
											$obj="['".$idAlmacen."','".bE($qy["query"])."']";
											if($arrQueriesResueltas=="")
												$arrQueriesResueltas=$obj;
											else
												$arrQueriesResueltas.=",".$obj;
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
							
							echo '<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
									<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>';

						?>
                       <td>
                       <script type="text/javascript" src="../thotFormularios/Scripts/configurarFormulario.js.php?iF=<?php echo bE($idFormulario)?>"></script>

                       <table class="tdContenedorFormulario" id='tblGrid' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px" onmouseover="mueveMouseSobreGrid(event,this)" onmouseout="saleMouseSobreGrid(event,this)" onclick="clickGrid(event,this)" >
                            	<tr>
                                	<td class="<?php echo $claseFrame?> " id="tdContenedor" style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px">
                                    <fieldset class="frameHijo"   id='frameTitulo' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px;"  ><legend id='lblLegend' ><b><?php echo $titulo ?></b></legend>
                                    </fieldset>
                                    <?php
								   		crearElementosFormulario();
									?>
                                    </td>
                                </tr>
                            </table>
                       
                       		<div id="sticky" >
                              <table width="100%">
                              <tr>
                                  <td align="right">
                                      <table>
                                          <tr>
                                              <td><span id="contenedor1"></span></td>
                                              <td><span id="contenedor2"></span></td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                              </table>
                              
                            </div>
                       
                       		
                        	
                           
                           
                           <input type="hidden" name="hIdidioma" id="hIdidioma" value="<?php echo $_SESSION["leng"] ?>" />
                            
                           <input type="hidden" id="titulo" value="<?php echo $tituloC ?>" />
                           <input type="hidden" id="idFormulario" value="<?php echo $idFormulario?>" />
                           <input type="hidden" name="idProceso" id="idProceso" value="<?php echo $idProceso ?>" />
                           <input type="hidden" id="hNElementos" value="<?php echo $numElementos++ ?>" />
                           <input type="hidden" id="mostrarMarco" value="<?php echo $mMarco?>" />
                           <input type="hidden" id="hAncho" value="<?php echo $anchoGrid ?>" />
                           <input type="hidden" id="hAlto" value="<?php echo $altoGrid ?>" />
                           <input type="hidden" id="calibrarCtrl" value="[<?php echo $calibrarCtrl?>]" />
                           <input type="hidden" id="queryResueltas" value="[<?php echo $arrQueriesResueltas?>]" />
                        </td>
                        <td >&nbsp;
                        </td>
                        <script>
							function inicializarControles()
							{
							<?php 
							echo $funcionesJava;
							
							echo $arrElementosFocus;
							?>
							}
						</script>
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
