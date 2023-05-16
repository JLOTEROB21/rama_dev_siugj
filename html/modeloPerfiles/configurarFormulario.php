<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include("funcionesFormularios.php");

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
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,visible from 901_elementosFormulario where tipoElemento in (1,13) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"];
		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		while($filas=mysql_fetch_row($res))
		{
			switch($filas[2])
			{
				case "1":
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$etiqueta="<span class='".$filaE[13]."' id='_lbl".$filas[0]."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">'.$filas[1]."</span>".$cHRef."</span>";
				break;
				case "13":
					$query="select campoConf1,campoConf2 from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$confCampo=$con->obtenerPrimeraFila($query);
					
					$etiqueta="<fieldset class='frameHijo' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px; '  ><legend> ".$filas[1]."</legend></fieldset>";
				break;
				case "30":
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$arrDatos=explode("_",$filaE[3]);
					$valor=ucfirst($arrDatos[1]);
					$etiqueta="<span class='".$filaE[13]."' id='_".$filas[1]."vch' idAlmacen='".$filaE[2]."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">['.$valor."]</span>".$cHRef."</span>";
				
				break;
			}
			if($filas[6]=="1")
			{
				$btnEliminar='&nbsp;<a href="javascript:eliminarElemento(\''.$filas[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a>';
			}
			else
				$btnEliminar="";
			$tabla=	 "	<table class='tablaControl'>
    						<tr>
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
				$div="<div id='div_".$filas[0]."' visible='".$filas[7]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute; background-color:#FFF;' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='_lbl".$filas[0]."_".$filas[2]."'>".$tabla."</div>";			
			else
				$div="<div id='div_".$filas[0]."' visible='".$filas[7]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute; background-color:#FFF;' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='_".$filas[1]."vch"."'>".$tabla."</div>";			
			echo $div;
			$calibrarCtrl.="calibrarCtrl[".$cc."]='div_".$filas[0]."';";
			$cc++;
		}
		
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,orden,visible,habilitado from 901_elementosFormulario where tipoElemento not in (-2,1,20,13,30) and idFormulario=".$idFormulario." order by orden";
		$res=$con->obtenerFilas($query);
		
		while($fElemento=mysql_fetch_row($res))
		{
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
					$etiqueta="<input type='button' id='btn_0' value='".$et["lblGuardar"]."' class='".$filaE[13]."'>";
					$mostrarEliminar=false;
				break;
				case 2: //pregunta cerrada-Opciones Manuales
					$btnAgregarElemento="";
					
					
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					
					if($filaE[14]=="1")
						$btnAgregarElemento='<img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento">';
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$etiqueta="	
								<table>
									<tr>
										<td>
											<select class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado." ><option value='-1'>".$et["lblSeleccione"]."</option>";
													$etiqueta.=	$con->generarOpcionesSelectNoImp($queryOpt);	
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
					
					$etiqueta="	
								<table>
									<tr>
										<td>
											<select class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado."><option value='-1'>".$et["lblSeleccione"]."</option>";
												$etiqueta.=$con->generarNumeracionSelectNoImp($filaE[2],$filaE[3],"-1",$filaE[4]);
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
					
					if($filaE[14]=="1")
						$btnAgregarElemento='<img src="../images/add.png" title="Agregar elemento" alt="Agregar elemento">';
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
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
							if($condWhere=="")
								$query="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
							else
								$query="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
						}
					
						$etiqueta="	
								<table>
									<tr>
										<td>
												<select class='".$filaE[13]."' val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ".$habilitado." ><option value='-1'>".$et["lblSeleccione"]."</option>";
											$etiqueta.=	$con->generarOpcionesSelectNoImp($query,"-1");	
											
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
						
						$etiqueta="	
								<table>
									<tr>
										<td>
												<input type='text' name='t_".$nombreControl."' id='t_".$nombreControl."' value=''>
												<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."' auto='true' ancho='".$anchoC."' extId='ext_".$nombreControl."'>
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
																			anchoCombo:".$anchoC.",
																			campoHDestino:'".$nombreControl."',
																			funcAntesCarga:antesCargaExt_".$nombreControl.",
																			desHabilitado:".$habilitado."
																		}
																	);";
					}
				break;
				case 5: //Texto Corto
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."' ".$habilitado."  >";
				break;
				case 6: //Número entero
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					if($val=='')
						$val='num';
					else
						$val.='|num';
					
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[2]."' class='".$filaE[13]."' ".$habilitado." onkeypress='return soloNumero(event,false,false)' val='".$val."' >
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
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[2]."' class='".$filaE[13]."' ".$habilitado." onkeypress='return soloNumero(event,true,false,this)' val='".$val."' >
								<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
					  			<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>
								<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[7]."'>
								";
							
				break;
				case 8: //Fecha
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "	<span id='sp".$nombreControl."'></span>
									<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."'  extId='f_sp".$nombreControl."'>";
					$fMax=$filaE[2];
					$fMin=$filaE[3];
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
					$funcionesJava.="crearCampoFecha('sp".$nombreControl."','".$nombreControl."',".$fMax.",".$fMin.");".$compHabilitado;
				break;
				case 9://Texto Largo 
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<textarea name='".$nombreControl."' id='".$nombreControl."' style='height:".$filaE[3]."px; width:".$filaE[2]."px' class='".$filaE[13]."' val='".$val."' ".$habilitado." ></textarea>";
				break;
				case 10: //Texto Enriquecido
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<span name='txtEnriquecido_".$fElemento[0]."' id='txtEnriquecido_".$fElemento[0]."' val='".$val."'></span>";
					$compHabilitado="";
					if($habilitado!="")
						$compHabilitado="Ext.getCmp('".$nombreControl."').disable();";
					$funcionesJava.="crearTextoEnriquecido('".$nombreControl."','txtEnriquecido_".$fElemento[0]."',".$filaE[2].",".$filaE[3].");".$compHabilitado;
				break;
				case 11: //Correo Electrónico
					if($val=='')
						$val='mail';
					else
						$val.='|mail';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='".$filaE[13]."' val='".$val."' ".$habilitado." >";
				break;
				case 12: //Archivo
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input type='hidden' id='tipoArch".$nombreControl."' value='".$filaE[2]."'><input type='hidden' id='tamArch".$nombreControl."' value='".$filaE[3]."'><input type='text' size='15' ".$habilitado."><input type='button' name='".$nombreControl."' id='".$nombreControl."' value='".$et["lblSelArchivo"]."'  val='".$val."' >";
				break;
				case 14:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$elemSel=$fConfCampo[10];
					if($elemSel=='')
						$elemSel='100584';
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$fRes[0])
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'"  ><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' >&nbsp;'.$fRes[1].'</td>';
							else
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'"  ><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'   checked="checked">&nbsp;'.$fRes[1].'</td>';
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
					$etiqueta.="</table></span><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='".$val."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 15:
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[10];
					if($elemSel=='')
						$elemSel='100584';
					for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$x)
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"><input  type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.' >&nbsp;'.$x.'</td>';
							else
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"><input type="radio" id="opt'.$nombreControl.'_'.$x.'" name="opt'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked">&nbsp;'.$x.'</td>';
							
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
					$etiqueta.="</table></span><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='".$val."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 16:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' style=\"background-color:#FFF !important\">";
					$nCol=0;
					$tablaOD=$filaE[2];
					$campoProy=$filaE[3];
					$campoId=$filaE[4];
					$campoFiltro=$filaE[8];
					$condicionFiltro=$filaE[7];
					$controlFiltro="_".$filaE[6]."vch";
					$controlDestino=$fElemento[1];
					
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
						if($condWhere=='')
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
						else
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
					}
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[10];
					if($elemSel=='')
						$elemSel='100584';
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$fRes[0])
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"  ><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' >&nbsp;'.$fRes[1].'</td>';
							else
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"  ><input type="radio" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'  checked="checked">&nbsp;'.$fRes[1].'</td>';
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
					$etiqueta.="</table></span><input type='hidden' value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'><input type='hidden' value='".$elemSel."' id='default".$nombreControl."'> <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='".$val."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 17:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$elemSel=$fConfCampo[10];
					if($elemSel=='')
						$elemSel='100584';
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
						
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$fRes[0])
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'"  ><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.' >&nbsp;'.$fRes[1].'</td>';
							else
								$etiqueta.='<td class="'.$fConfCampo[13].'" width="'.$anchoCelda.'"  ><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'  checked="checked">&nbsp;'.$fRes[1].'</td>';
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
					$etiqueta.="</table></span><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' value=''><input type='hidden' id='minSel".$nombreControl."' value='".$fConfCampo[10]."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 18:
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$elemSel=$filaE[7];
					if($elemSel=='')
						$elemSel='100584';
					for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							if($elemSel!=$x)
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.' >&nbsp;'.$x.'</td>';
							else
								$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="'.$nombreControl.'" value="'.$x.'" '.$habilitado.'  checked="checked">&nbsp;'.$x.'</td>';
							
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
					$etiqueta.="</table></span><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' value=''><input type='hidden' id='minSel".$nombreControl."' value='".$fConfCampo[10]."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
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
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' style=\"background-color:#FFF !important\">";
					$nCol=0;
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
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
						if($condWhere=='')
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
						else
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
						
					}
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
							$etiqueta.='<td class="'.$filaE[13].'" width="'.$anchoCelda.'"  ><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="'.$nombreControl.'" value="'.$fRes[0].'" '.$habilitado.'  >&nbsp;'.$fRes[1].'</td>';
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
					$etiqueta.="</table></span><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' value=''><input type='hidden' id='minSel".$nombreControl."' value='".$filaE[10]."'>  <input type='hidden' value='".$anchoCelda."' id='anchoCelda".$nombreControl."' ><input type='hidden' value='".$anchoCelda."' id='ancho".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='numCol".$nombreControl."' ><input type='hidden' value='".$numColumnas."' id='nColumnas".$nombreControl."' > <input type='hidden' id='lista".$nombreControl."' value=\"[".$arrRadios."]\">";
				break;
				case 21: //Hora
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$fMax=$filaE[2];
					$fMin=$filaE[3];
					$intervalo=$filaE[4];
					$etiqueta= "	<span id='sp".$nombreControl."'></span>
									<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='' val='".$val."' hMin='".$fMin."' hMax='".$fMax."' intervalo='".$intervalo."'  extId='f_sp".$nombreControl."'>";
					

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
					$funcionesJava.="crearCampoHora('sp".$nombreControl."','".$nombreControl."',".$fMax.",".$fMin.",".$intervalo.");".$compHabilitado;
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
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>
								
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
						$HRef="<a id='link_".$fElemento[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$etiqueta= "<span  id='_img".$fElemento[0]."' enlace='".$filaE[5]."'>".$HRef."<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>".$cHRef."</span>";
							
				break;
				case 24: //Texto Corto
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='' size='".$filaE[7]."' class='".$filaE[13]."' val='".$val."' ".$habilitado."  >
								<input type='hidden' name='numD_".$nombreControl."' id='numD_".$nombreControl."' value='".$filaE[2]."'>
					  			<input type='hidden' name='sepMiles_".$nombreControl."' id='sepMiles_".$nombreControl."' value='".$filaE[3]."'>
					  			<input type='hidden' name='sepDec_".$nombreControl."' id='sepDec_".$nombreControl."' value='".$filaE[4]."'>
								<input type='hidden' name='lita_".$nombreControl."' id='lita_".$nombreControl."' value='".$filaE[6]."'>";
				break;
				case 29:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<span id='contenedorSpanGrid_".$fElemento[0]."' permiteModificar='".$filaE[5]."' permiteEliminar='".$filaE[6]."' val='".$val."'><span id='spanGrid_".$fElemento[0]."'></span></span>";
					$consulta="SELECT * FROM 9039_configuracionesColumnasCampoGrid WHERE idElemento=".$fElemento[0]." order by orden";
					$resConf=$con->obtenerFilas($consulta);
					$arrCampos="{name: 'idRegistro'}";
					$arrCabeceras="";
					$mPermisos="";
					if($filaE[5]=="1")
						$mPermisos="M";
					if($filaE[6]=="1")
						$mPermisos.="E";
					
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
					if($filaE[13]==0)
						$habilitado="true";
					
					$funcionesJava.="crearCampoGridFormulario('grid_".$fElemento[0]."','spanGrid_".$fElemento[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.");";
					
				break;
			}				
			if($mostrarEliminar)
				$btnEliminar='<div style="z-index:10000" >&nbsp;<a href="javascript:eliminarElemento(\''.$fElemento[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a></div>';
			else
				$btnEliminar="";
			$ayuda="";
			if($msgAyuda!="")
			{
				$ayuda='<img id="imgAyuda_'.$fElemento[0].'" src="../images/formularios/sInterrogacion.jpg" height="16" width="16" alt="'.$msgAyuda.'" title="'.$msgAyuda.'">';
			}
			$tabla=	 "	<table class='tablaControl'>
    						<tr >
								<td valign='top' id='td_obl_".$fElemento[0]."' width='10'>".$asteriscoRojo."</td>
                    			<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
								<td valign='top'>".$btnEliminar."</td>
								<td id='tdAyuda_".$fElemento[0]."'><span id='spAyuda_".$fElemento[0]."'>".$ayuda."</span></td>".
                    		"</tr>
    					</table>";
			$div="<div  id='div_".$fElemento[0]."' visible='".$fElemento[8]."' habilitado='".$fElemento[9]."' style='top:".$fElemento[5]."px; left:".$fElemento[4]."px; position:absolute; class='frameSel' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='".$nombreControl."_".$fElemento[2]."' ".$ignorarLimites."  orden='".$fElemento[7]."'>".$tabla."</div>";			
			echo $div;	
			$calibrarCtrl.="calibrarCtrl[".$cc."]='div_".$fElemento[0]."';";
			$cc++;
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
<link rel="stylesheet" type="text/css" href="../Scripts/Ext.ux.FCKEditor/FCKeditor.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<script type="text/javascript" src="../Scripts/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/FCKeditor.js"></script>
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/visorImg.js.php"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/construyeFCKEditor.js"></script>
<script type="text/javascript" src="Scripts/gridFormulario.js.php"></script> 
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
<script type="text/javascript" src="Scripts/funcionesFormulario.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/colorField/ext.ux.ColorField.css" />
<script type="text/javascript" src="../Scripts/ux/colorField/ext.ux.ColorField.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/columnNodeUI.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/column-tree.css" />
<script type="text/javascript" src="../Scripts/ux/columnNodeUI.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>


<?php
	$guardarConfSession=true;
	$mostrarRegresar=false;
	$respetarEspacioRegresar=true;
	$mostrarUsuario=false;
?>
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
								$idFormulario=$_POST["idFormulario"];
							$funcionesJava="";
							$calibrarCtrl="var calibrarCtrl=new Array();";
							$cc=0;
							$consulta="select * from 901_elementosFormulario where idFormulario=".$idFormulario;
							$res=$con->obtenerFilas($consulta);
							if(mysql_num_rows($res)==0)
								crearControlesDefaultFormulario($idFormulario);

							$query="select nombreTabla,anchoGrid,altoGrid,mostrarMarco,campoDescriptivo  from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($query);
							$nTabla=$fila[0];
							$anchoGrid=$fila[1];
							$altoGrid=$fila[2];
							$mMarco=$fila[3];
							$campoDescriptivo=$fila[4];
							if(!crearTablaFormulario($nTabla))
								return;
							
							$numElementos=0;
							$nElementosFocus=0;
							$arrElementosFocus="var arrElementosFocus=new Array();";
							$consulta="select titulo,idProceso from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($consulta);
							$titulo=$fila[0];
							$tituloC=$fila[0];
							$idProceso=$fila[1];
							$claseFrame="frameHijo gridRejilla";
							if($mMarco==0)
							{
								$titulo="";
								$claseFrame="gridRejilla";
							}
							
						?>
                        <script type="text/javascript" src="Scripts/configurarFormulario.js.php?idFormulario=<?php echo $idFormulario ?>"></script>
                       <td  height="<?php echo $altoGrid?>px" id='tdContenedor' valign="top"  width="<?php echo $anchoGrid?>px">
                       
                       <fieldset class="<?php echo $claseFrame?>"  id='frameTitulo' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px;"  ><legend id='lblLegend' ><b><?php echo $titulo ?></b></legend>
                             <div id='divTool' style="top:300px; left:<?php echo (960+($anchoGrid-620)) ?>px; position:absolute;" id="divProp" onmousedown="comienzoMovimiento(event, this.id);" onmouseover="this.style.cursor='move'" ignorarLimites=""   >
                             <!--<div id='divTool' style="top:350px; left:290px; position:absolute;"   >-->
                             	<span style="height:25px; width:120px"><img src="../images/formularios/titulo.png" /></span><br />
                                <input type="button" class="botonAddEtiqueta" alt="<?php echo $et["lblInsEt"] ?>" title="<?php echo $et["lblInsEt"] ?>" onClick="lanzarVentanaConfiguracion(1)" /><br />
                                <input type="button" class="botonAddLink" alt="Agregar hiperenlace" title="Agregar hiperenlace" onClick="mostrarVentanaHiperEnlace()" /><br />
                                <input type="button" class="botonAddCampoOperacion" alt="<?php echo $et["lblInsCampoOp"] ?>" title="<?php echo $et["lblInsCampoOp"] ?>" onClick="mostrarVentanaCampoOperacion()" /><br />
                                <input type="button" class="botonAddFrame" alt="<?php echo $et["lblInsFrame"] ?>" title="<?php echo $et["lblInsFrame"] ?>" onClick="lanzarVentanaConfiguracion(13)" /><br />
                             	<input type="button" class="botonAddTextoCorto" alt="<?php echo $et["lblInsCampoTexto"] ?>" title="<?php echo $et["lblInsCampoTexto"] ?> " onClick="lanzarVentanaConfiguracion(11)"/><br />
                                <input type="button" class="botonAddTextoLargo" alt="<?php echo $et["lblInsTextoL"] ?>" title="<?php echo $et["lblInsTextoL"] ?> " onClick="mostrarVentanaPreguntasUnicas(9)"/><br />
                                <input type="button" class="botonAddTextoEnriquecido" alt="<?php echo $et["lblInsTextoE"] ?>" title="<?php echo $et["lblInsTextoE"] ?> " onClick="mostrarVentanaPreguntasUnicas(10)" /><br />
                                <input type="button" class="botonAddCombo" alt="<?php echo $et["lblInsSelect"] ?>" title="<?php echo $et["lblInsSelect"] ?> " onClick="lanzarVentanaConfiguracion(2)" /><br />
                                <input type="button" class="botonAddOpcion" alt="<?php echo $et["lblInsOpcion"] ?>" title="<?php echo $et["lblInsOpcion"] ?> " onClick="lanzarVentanaConfiguracion(14)" /><br />
                                <input type="button" class="botonAddCheck" alt="<?php echo $et["lblInsCheck"] ?>" title="<?php echo $et["lblInsCheck"] ?> " onClick="lanzarVentanaConfiguracion(15)" /><br />
                                <input type="button" class="botonAddCampoFecha" alt="<?php echo $et["lblInsFecha"] ?>" title="<?php echo $et["lblInsFecha"] ?> " onClick="mostrarVentanaPreguntasUnicas(8)" /><br />
                               	<input type="button" class="botonAddCampoHora" alt="<?php echo $et["lblInsHora"] ?>" title="<?php echo $et["lblInsHora"] ?> " onClick="mostrarVentanaPreguntasUnicas(21)" /><br />
                                <input type="button" class="botonAddArchivo" alt="<?php echo $et["lblInsArchivo"] ?>" title="<?php echo $et["lblInsArchivo"] ?> " onClick="mostrarVentanaPreguntasUnicas(12)" /><br />
                                <input type="button" class="botonAddCampoGrid" alt="Insertar grid de datos" title="Insertar grid de datos" onClick="mostrarVentanaNombreGrid(-1)" /><br />
                                <input type="button" class="botonCrearEstilo" alt="Crear estilo" title="Crear estilo" onClick="mostrarVentanaEstilos()" id="btnEstilos"  /><br />
                                <input type="button" class="botonImagen" alt="Insertar imagen" title="Insertar imagen" onClick="mostrarVentanaImagenes()" id="btnImagen"  /><br />
                                <span id="btnAyuda">
                                <input type="button" class="botonAddAyuda" alt="<?php echo $et["lblAyuda"] ?>" title="<?php echo $et["lblAyuda"] ?>" onClick="mostrarVentanaAyuda()"  /><br />
                                </span>
                                <span id="btnDelAyuda">
                                <input type="button" class="botonDelAyuda" alt="<?php echo $et["lblDelAyuda"] ?>" title="<?php echo $et["lblDelAyuda"] ?>" onClick="eliminarAyuda()" id="btnAyuda" /><br />
                                </span>
                                <span id="btnAccion" style="display:none">
                                	<input type="button" class="botonCtrlAccion" alt="Eventos" title="Acción" onClick="mostrarVentanaAccion()" /><br />
                                </span>
                                
                                <input type="button" class="botonAddDisparador" alt="<?php echo $et["lblDisparadores"] ?>" title="<?php echo $et["lblDisparadores"] ?>" onClick="mostrarVentanaDisparadorCmbRadio()" id="btnDisparador" /><br />
                             </div>
                        	<input type="hidden" name="hIdidioma" id="hIdidioma" value="<?php echo $_SESSION["leng"] ?>" />
                            </fieldset>
                           
                           <?php
						   		crearElementosFormulario();
								
						   ?>
                           <!--<div style="position:absolute; top:300px; left:910px">-->
                           
                           <div style="position:absolute; top:200px;  left:50px" id="divProp" onMouseDown="comienzoMovimiento(event, this.id);" onMouseOver="this.style.cursor='move'" ignorarlimites="" lanzaevento="">
                           		<table >
                                <tr>
                                <td align="left">
	                                <input type="button" value="<?php echo $et["lblFinalizar"]?>" class="btnFinalizar"  onclick="<?php echo $pagRegresar?>"/>
	                               <input type="hidden" name="idFormulario" id="idFormulario" value="<?php echo $idFormulario?>" />
                                    <input type="hidden" name="idProceso" id="idProceso" value="<?php echo $idProceso ?>" />
	                            	 <br />
                                </td>
                                </tr>
                                <tr>
                                	<td>
                                    <fieldset class="frameHijo" style="background-color:#FFF"><legend><b><?php echo $et["lblTamGrid"]?></b></legend>
                                    <table >
                                        <tr height="23">
                                            <td><span class="letraFicha"><?php echo $et["lblAncho"]?>:</span></td>
                                            <td><span id='divAncho'></span><span class="letraFicha"> px</span></td>
                                        </tr>
                                        <tr height="23">
                                            <td><span class="letraFicha"><?php echo $et["lblAlto"]?>:</span></td>
                                            <td><span id='divAlto'></span><span class="letraFicha"> px</span></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" class="letraFicha">
                                            <br />
                                            <input type="checkbox" onClick="mostrarRejila(this)" checked="checked" id='verGrid' />&nbsp;&nbsp;<?php echo $et["lblVerGrid"]?> 
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" class="letraFicha">
                                            <?php
												$mostrarMarco="";
												if($mMarco==1)
													$mostrarMarco="checked='checked'";
												
											?>
                                            <input id='verMarco' type="checkbox" onClick="mostrarMarco(this)" <?php echo $mostrarMarco?> />&nbsp;&nbsp;Mostrar marco
                                            <input type="hidden" id="titulo" value="<?php echo $tituloC ?>" />
                                            </td>
                                            
                                        </tr>
                                        <tr height="20">
                                        	<td colspan="2" >
                                            </td>
                                        </tr>
                                        <?php
											if(esFormularioBase($idFormulario))
											{
										?>
                                                <tr>
                                                    <td colspan="2" class="letraFicha">
                                                    <span style="cursor:help" alt='El campo descriptivo es aquel que permite identificar al registro de manera sencilla, generalmente corresponde con el campo que contiene el título del registro' title="El campo descriptivo es aquel que permite identificar al registro de manera sencilla, generalmente corresponde con el campo que contiene el título del registro">
                                                    Seleccione el campo descriptivo:
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="2">
                                                    <select id='cmbCampoDesc' onChange="campoDescriptivoChange(this)">
                                                    <option value="-1">Seleccione</option>
                                                    <?php
														$query="select nombreCampo,nombreCampo from 901_elementosFormulario where tipoElemento in (5,9) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"]." order by nombreCampo";
														$con->generarOpcionesSelect($query,$campoDescriptivo);
													?>
                                                    </select>
                                                    </td>
                                                </tr>
                                        <?php
											}
										?>
                                    </table>
                                 	</fieldset>
                                    <br />
                                    </td>
                                </tr>
                                <tr>
                                
                                <td >
                                    <div id="tblPropiedades">
                                    </div>
                                </td>
                                </tr>
                                <tr>
                                <td >
                                	<br />
                                    <br />
                                	<!--<div id='tblHidden'>
                                    	<?php
											$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 901_elementosFormulario where tipoElemento=20 and idFormulario=".$idFormulario;
											$res=$con->obtenerFilas($query);
											while($fila=mysql_fetch_row($res))
											{
												$nombreControl=generarNombre($fila[1],$fila[2]);	
												$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fila[0];
												$filaE=$con->obtenerPrimeraFila($consulta);
												$btnEliminar='<div style="z-index:10000" >&nbsp;<a href="javascript:eliminarElemento(\''.$fila[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a></div>';
												
												$etiqueta= "<input type='hidden' value='".$filaE[2]."' id='tipo".$nombreControl."'><input type='hidden' value='".$filaE[3]."' id='actualizable".$nombreControl."'><input type='text' name='".$nombreControl."' id='".$nombreControl."' size='15' value='".$fila[1]."' readOnly>";
												$tabla=	 "	<table class='tablaControl'  >
															<tr >
																<td valign='top' id='td_obl_".$fila[0]."'></td>
																<td id='td_".$fila[0]."' class=''>".$etiqueta."</td><td valign='top'>".$btnEliminar."</td>
															</tr>
														</table>";
												$div="<div id='div_".$fila[0]."'  class=''  controlInterno='".$nombreControl."_".$fila[2]."' movible='false'  onmousedown='comienzoMovimiento(event, this.id);' >".$tabla."</div>";			
												echo $div;
											}
											
										?>
                                    </div>-->
                                </td>
                                </tr>
                                </table>
                           		<input type="hidden" id='hAncho' value="<?php echo $anchoGrid?>" />
                                <input type="hidden" id='hAlto' value="<?php echo $altoGrid?>" />
                                <input type="hidden" id="hNElementos" value="<?php echo $numElementos++ ?>" />
                                <span>
                                </span>
                           </div>
                        </td>
                        <td >&nbsp;
                        </td>
                        <script>
							<?php 
							echo $funcionesJava;
							echo $calibrarCtrl;
							echo $arrElementosFocus;
							?>
							
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
