<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

function crearElementosFormulario()
{
		global $funcionesJava;
		global $con;
		global $et;
		global $idFormulario;
		global $existeT;
		global $arrColumnasDatos;
		global $nombreTabla;
		global $idRegistro;
		global $dependencias;
		
		$query="select idRolElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 901_elementosFormulario where (tipoElemento=1 or tipoElemento=13) and idFormulario=".$idFormulario." and idIdioma=".$_SESSION["leng"];
		
		$res=$con->obtenerFilas($query);
		while($filas=mysql_fetch_row($res))
		{
			if($filas[2]==1)
				$etiqueta="<span class='letraFichaRespuesta' id='_lbl".$filas[0]."'>".$filas[1]."</span>";
			else
			{
				$query="select campoConf1,campoConf2 from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
				$confCampo=$con->obtenerPrimeraFila($query);
				
				$etiqueta="<fieldset class='frameHijo' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px; '  ><legend> ".$filas[1]."</legend></fieldset>";
			}
			
			
			$tabla=	 "	<table>
    						<tr>
                    			<td>".$etiqueta."</td>
                    		</tr>
    					</table>";
			$div="<div id='div_".$filas[0]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute; background-color:#FFF;' >".$tabla."</div>";			
			echo $div;			
		}
		
		$query="select idRolElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 901_elementosFormulario where (tipoElemento<>1 and tipoElemento<>13 and tipoElemento<>20) and idFormulario=".$idFormulario;
		
		$res=$con->obtenerFilas($query);
		while($fElemento=mysql_fetch_row($res))
		{
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
				
			if(($existeT==1)&&($fElemento[2]>1)&&($fElemento[2]<>13)&&(!(($fElemento[2]>=17)&&($fElemento[2]<=19))))
				$valorCelda=$arrColumnasDatos[$fElemento[1]];	
			else
				$valorCelda="";
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);
			$queryAyuda="select mensajeAyuda from 914_mensajesAyuda where idIdioma=".$_SESSION["leng"]." and idRolElemento=".$fElemento[0];
			$msgAyuda=$con->obtenerValor($queryAyuda);
			switch($fElemento[2])					
			{
				case -2:
					$etiqueta="	<table class='tablaMenu' width='200'>";
                  	$consulta="select idFormulario,titulo,frmRepetible from 900_formularios where idFrmEntidad=".$idFormulario;
					$resFrm=$con->obtenerFilas($consulta);
					$idRef="-1";
					
					if(mysql_num_rows($resFrm)>0)
						$dependencias=true;

					if((mysql_num_rows($resFrm)>0)&&($idRegistro!="-1"))
					{
						
						while($filaFrm=mysql_fetch_row($resFrm))
						{
							if($filaFrm[2]==0)
							{
								$consulta="select nombreTabla from 900_formularios where idFormulario=".$filaFrm[0];
								$nomTablaD=$con->obtenerValor($consulta);
								$consulta="select id_".$nomTablaD." from ".$nomTablaD." where idReferencia=".$idRegistro;
								$idRef=$idRegistro;
								$idRegistro=$con->obtenerValor($consulta);
								if($idRegistro=='')
									$idRegistro='-1';
								
								
							}
							$etiqueta.= "<tr height='23'>
											<td width='30'>&nbsp;<a href='javaScript:enviarAsociado(".$filaFrm[0].",".$idRegistro.",".$filaFrm[2].",".$idRef.")'><img src='../images/icon_code.gif'></a></td>
											<td class='letraFichaRespuesta' align='left' ><a href='javaScript:enviarAsociado(".$filaFrm[0].",".$idRegistro.",".$filaFrm[2].",".$idRef.")'>".$filaFrm[1]."</a></td>
		   								</tr>";
							
						}
					}
					
								   
					$etiqueta.="</table>";	
					$ignorarLimites='ignorarLimites="actualizar"';
					$mostrarEliminar=false;
				break;
				case -1:
					$etiqueta="<input type='button' value='".$et["lblCancelar"]."' class='btnCancelar' onclick=\"cancelar()\">";
				break;
				case 0://button
					$etiqueta="<input type='button' value='".$et["lblGuardar"]."' class='btnGuardar' onclick=\"validarFrm('frmEnvio')\">";
				break;
				case 2: //pregunta cerrada-Opciones Manuales
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$etiqueta="	<select val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ><option value='-1'>".$et["lblSelOpcion"]."</option>";
										$etiqueta.=	$con->generarOpcionesSelectNoImp($queryOpt,$valorCelda);	
					$etiqueta.="</select>";
				break;
				case 3: //pregunta cerrada-Opciones intervalo
					$etiqueta= "	<select val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ><option value='-1'>".$et["lblSelOpcion"]."</option>";
										$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];		
										$filaE=$con->obtenerPrimeraFila($queryOpt);
										$etiqueta.=$con->generarNumeracionSelectNoImp($filaE[2],$filaE[3],$valorCelda,$filaE[4]);
					$etiqueta.=	"	</select>";
				break;
				case 4: //pregunta cerrada-Opciones tabla

					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$tablaOD=$filaE[2];
					$campoProy=$filaE[3];
					$campoId=$filaE[4];
					$campoFiltro=$filaE[8];
					$condicionFiltro=$filaE[7];
					$controlFiltro="_".$filaE[6]."vch";
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";

					if($filaE[5]=='1')
					{
						
						$controlDestino=$fElemento[1];
						if(($con->existeTabla($nombreTabla))&&($filaE[12]!='1'))
						{
							$consulta="select ".$filaE[6]." from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
							$valorCampo=$con->obtenerValor($consulta);
							
						
						}
						else
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
					
					
					$etiqueta= "	<select val='".$val."' name='".$nombreControl."' id='".$nombreControl."' ><option value='-1'>".$et["lblSelOpcion"]."</option>";
										$etiqueta.=	$con->generarOpcionesSelectNoImp($query,$valorCelda);	
					$etiqueta.=	"	</select>";
				break;
				case 5: //Texto Corto
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='x-form-text' val='".$val."'  >";
				break;
				case 6: //Número entero
					if($val=='')
						$val='num';
					else
						$val.='|num';
					
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' size='10' class='x-form-text' onkeypress='return soloNumero(event,false,false)' val='".$val."' >";
							
				break;
				case 7: //Número decimal
					if($val=='')
						$val='flo';
					else
						$val.='|flo';
					$etiqueta= "<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' size='10' class='x-form-text' onkeypress='return soloNumero(event,true,false,this)' val='".$val."' >";
							
				break;
				case 8: //Fecha
					if($valorCelda!="")
					{
						$arrValor=explode("-",$valorCelda);
						$valorCelda=$arrValor[2]."/".$arrValor[1]."/".$arrValor[0];
					}
						
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "	<span id='sp".$nombreControl."'></span>
									<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' val='".$val."'  extId='f_sp".$nombreControl."'>";
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
					$funcionesJava.="crearCampoFecha('sp".$nombreControl."','".$nombreControl."',".$fMax.",".$fMin.");";
				break;
				case 9://Texto Largo 
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<textarea name='".$nombreControl."' id='".$nombreControl."' cols='".$filaE[2]."' rows='".$filaE[3]."' class='x-form-field' val='".$val."' >".$valorCelda."</textarea>";
				break;
				case 10: //Texto Enriquecido
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<textarea name='".$nombreControl."' id='".$nombreControl."' class='txtEnriquecido_".$fElemento[0]."' val='".$val."' >".$valorCelda."</textarea>";
					$funcionesJava.="crearTextoEnriquecido('txtEnriquecido_".$fElemento[0]."',".$filaE[2].",".$filaE[3].");";
				break;
				case 11: //Correo Electrónico
					if($val=='')
						$val='mail';
					else
						$val.='|mail';
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<input type='text' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' maxlength='".$filaE[3]."' size='".$filaE[2]."' class='x-form-text' val='".$val."' >";
				break;
				case 12: //Archivo
					$nombreControlFile=$fElemento[1];
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$descargarArchivo="";
					if(($valorCelda!='')&&($valorCelda!='-1'))
					{
						$val='';
						$descargarArchivo="<a href='../paginasFunciones/obtenerArchivos.php?id=".$valorCelda."'><img src='../images/download.png' alt='".$et["lblDescargarArc"]."' title='".$et["lblDescargarArc"]."'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					else
						$valorCelda="-1";
				
					$controlFile="<input type=\"file\"  name='".$nombreControlFile."' id='".$nombreControlFile."' val='".$val."' />";
					$etiqueta=$descargarArchivo.$controlFile."<input type='hidden' name='".$nombreControl."' id='".$nombreControl."' value='".$valorCelda."' >";
				break;
				case 14:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' style=\"background-color:#FFF !important\">";
					$nCol=0;
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$nCt=1;
					if($valorCelda=='')
					{
						$valorCelda=$fConfCampo[10];
						
						if($valorCelda=='100584')
							$valorCelda='-1';
					}
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';

						if($valorCelda==$fRes[0])
						{
						
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'" >
							<input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$fRes[0].'"  onclick="selOpcion(this)" checked="checked" >&nbsp;'.$fRes[1].'</td>';
						}
						else
						{
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'" >
							<input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$fRes[0].'"  onclick="selOpcion(this)" >&nbsp;'.$fRes[1].'</td>';
						}
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
						$nCt++;
					}
					$etiqueta.="</table></span><input type='hidden' name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1' >";
				break;
				case 15:
					$etiqueta="<span id='span".$nombreControl."'><table id='tbl".$nombreControl."' style=\"background-color:#FFF !important\">";
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
							$valorCelda='-1';
					}
					for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';

						if($valorCelda==$x)
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"><input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)" checked="checked">&nbsp;'.$x.'</td>';
						else
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"><input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$x.'" onclick="selOpcion(this)">&nbsp;'.$x.'</td>';
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
						$nCt++;
					}
					$etiqueta.="</table></span><input type='hidden' name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1'  >";
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
					
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
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
						if($condWhere=="")
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." order by ".$campoProy;	
						else
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$condWhere." order by ".$campoProy;	
					}
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$nCt=1;
					if($valorCelda=='')
					{
						$valorCelda=$filaE[10];
						if($valorCelda=='100584')
							$valorCelda='-1';
					}
					while($fRes=mysql_fetch_row($resOpt))
					{
						if($nCol==0)
							$etiqueta.='<tr height="23">';
						if($valorCelda==$fRes[0])
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"><input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" onclick="selOpcion(this)" checked="checked">&nbsp;'.$fRes[1].'</td>';
						else
							$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"><input type="radio" id="opt'.$nombreControl.'_'.$nCt.'" name="opt'.$nombreControl.'" value="'.$fRes[0].'" onclick="selOpcion(this)">&nbsp;'.$fRes[1].'</td>';						
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
						$nCt++;
					}
					$etiqueta.="</table></span><input type='hidden' value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'> <input type='hidden' name='".$nombreControl."' id='".$nombreControl."' val='".$val."' value='".$valorCelda."' controlF='opt".$nombreControl."_1'  >";
				break;
				case 17:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					$fConfCampo=$con->obtenerPrimeraFila($consulta);
					$numColumnas=$fConfCampo[9];
					$anchoCelda=$fConfCampo[11];
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
						$condWhere.=$filaFiltro[0]." ";
					if($condWhere=='')
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and idIdioma=".$_SESSION["leng"]." order by contenido";
					else
						$queryOpt="select valor,contenido from 902_opcionesFormulario where idRolElemento=".$fElemento[0]." and ".$condWhere." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$resOpt=$con->obtenerFilas($queryOpt);
					$arrRadios="";
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$queryTabla="select idOpcion from ".$arrNomTabla[0]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					$ctNumSel=0;
					$resTabla=$con->obtenerFilas($queryTabla);
					$primerElemento="";
					while($fRes=mysql_fetch_row($resOpt))
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
							
						$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"  ><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt_'.$nombreControl.'[]" value="'.$fRes[0].'" '.$checado.' onclick="selCheck(this)" >&nbsp;'.$fRes[1].'</td>';
							
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
					}
					
					
					$etiqueta.="</table></span><input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'> <input type='hidden' id='".$nombreControl."' val='min' name='".$nombreControl."' tipo='checkBox'  minSel='".$fConfCampo[10]."'  value='".$arrNomTabla[0]."_".$nControlSinSuf."' controlF='".$primerElemento."'>";
				break;
				case 18:
					$etiqueta="<span id='span".$nombreControl."'><table style=\"background-color:#FFF !important\">";
					$nCol=0;
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$fElemento[0];
					
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrRadios="";
					$numColumnas=$filaE[9];
					$anchoCelda=$filaE[11];
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$queryTabla="select idOpcion from ".$arrNomTabla[0]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					$resTabla=$con->obtenerFilas($queryTabla);
					$ctNumSel=0;
					$primerElemento="";
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
							
						$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"><input type="checkbox" id="opt'.$nombreControl.'_'.$x.'" name="opt_'.$nombreControl.'[]" value="'.$x.'" '.$checado.' onclick="selCheck(this)"  >&nbsp;'.$x.'</td>';
							
							
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
					}
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$etiqueta.="</table></span><input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='min' value='".$arrNomTabla[0]."_".$nControlSinSuf."' tipo='checkBox'  minSel='".$fConfCampo[10]."' controlF='".$primerElemento."'>  ";
				break;
				case 19:
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
					$consulta="select tokenMysql from 913_consultasFiltroElemento where idRolElemento=".$fElemento[0];
					$resFiltro=$con->obtenerFilas($consulta);
					$condWhere="";
					while($filaFiltro=mysql_fetch_row($resFiltro))
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
							$funcionesJava.="var comboD=gE('".$controlFiltro."');comboD.setAttribute('cFiltro','".$campoFiltro."');comboD.setAttribute('condicion','".$condicionFiltro."');comboD.setAttribute('cDestino','".$controlDestino."');asignarEventoChangeListado(comboD,19); ";
						}
						
						if($condWhere=='')
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' order by ".$campoProy;
						else
							$queryOpt="select ".$campoId.",".$campoProy." from ".$tablaOD." where ".$campoFiltro.$condicionFiltro."'".$valorCampo."' and ".$condWhere." order by ".$campoProy;
						
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
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$queryTabla="select idOpcion from ".$arrNomTabla[0]."_".$nControlSinSuf." where idPadre=".$idRegistro;
					$ctNumSel=0;
					$resTabla=$con->obtenerFilas($queryTabla);
					$primerElemento="";
					while($fRes=mysql_fetch_row($resOpt))
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
								
						$etiqueta.='<td class="letraFicha" width="'.$anchoCelda.'"  ><input type="checkbox" id="opt'.$nombreControl.'_'.$fRes[0].'" name="opt_'.$nombreControl.'[]" value="'.$fRes[0].'" '.$checado.' onclick="selCheck(this)" >&nbsp;'.$fRes[1].'</td>';
							
						$nCol++;
						if($nCol==$numColumnas)
						{
							$etiqueta.='</tr>';
							$nCol=0;
						}
					}
					$arrNomTabla=explode('_',$nombreTabla);
					$nControlSinSuf= substr( $nombreControl,1,sizeof($nombreControl)-4);
					$etiqueta.="</table></span><input type='hidden' value='".$anchoCelda."' name='ancho".$nombreControl."' id='ancho".$nombreControl."'><input type='hidden' value='".$numColumnas."' name='nColumnas".$nombreControl."' id='nColumnas".$nombreControl."'> <input type='hidden' value='".$ctNumSel."' id='numSel".$nombreControl."'><input type='hidden' id='".$nombreControl."' name='".$nombreControl."' val='min' value='".$arrNomTabla[0]."_".$nControlSinSuf."' tipo='checkBox'  minSel='".$filaE[10]."' controlF='".$primerElemento."'>";
				break;
			}	
			
			$ayuda="";
			if($msgAyuda!="")
				$ayuda='&nbsp;&nbsp;<img id="imgAyuda_'.$fElemento[0].'" src="../images/formularios/sInterrogacion.jpg" height="16" width="16" alt="'.$msgAyuda.'" title="'.$msgAyuda.'">';
			$tabla=	 "	<table>
    						<tr>
								<td valign='top' width='10'>".$asteriscoRojo."</td>
                    			<td>".$etiqueta."</td>
								<td>".$ayuda."</td>
								
                    		</tr>
    					</table>";
			$div="<div id='div_".$fElemento[0]."' style='top:".$fElemento[5]."px; left:".$fElemento[4]."px; position:absolute; '>".$tabla."</div>";			
			echo $div;			
		}
}

function existeRegistro($valor,$res)
{
	if(mysql_num_rows($res)==0)
		return false;
	mysql_data_seek($res,0);
	while($fila=mysql_fetch_row($res))
	{
		if($valor==$fila[0])
			return true;
	}
	return false;
}

function generarNombre($nomCampo,$tipo)
{
	$nombreCampo="_".$nomCampo;
	$sufijo="";
	switch($tipo)
	{
		case 2: //pregunta cerrada-Opciones Manuales
			$sufijo="vch";
		break;					
		case 3: //pregunta cerrada-Opciones intervalo
			$sufijo="vch";
		break;
		case 4: //pregunta cerrada-Opciones tabla
			$sufijo="vch";
		break;
		case 5: //Texto Corto
			$sufijo="vch";
		break;
		case 6: //Número entero
			$sufijo="int";
		break;
		case 7: //Número decimal
			$sufijo="flo";
		break;
		case 8: //Fecha
			$sufijo="dte";
		break;
		case 9://Texto Largo 
			$sufijo="mem";
		break;
		case 10: //Texto Enriquecido
			$sufijo="men";
		break;
		case 11: //Correo Electrónico
			$sufijo="vch";
		break;
		case 12: //Archivo
			$sufijo="fil";
		break;
		case 14:
			$sufijo="vch";
		break;
		case 15:
			$sufijo="vch";
		break;
		case 16:
			$sufijo="vch";
		break;
		case 17:
			$sufijo="arr";
		break;
		case 18:
			$sufijo="arr";
		break;
		case 19:
			$sufijo="arr";
		break;
		case 20:
			$sufijo="vch";
		break;
	}
	$nombreCampoFinal=$nombreCampo.$sufijo;
	return $nombreCampoFinal;
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
<title>Consejo Nacional para las Personas con Discapacidad</title>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="Scripts/registroFormulario.js.php"></script>
<?php
	$dependencias=false;
	$mostrarRegresar=false;
	$respetarEspacioRegresar=true;
	$idFormulario="-1";
	if($objParametros!=null)
	{
		if(isset($objParametros->idFormulario))
			$idFormulario=$objParametros->idFormulario;
	}
	$funcionesJava="";
	$idEstado='0';
	$consulta="select nombreTabla,estadoInicial,anchoGrid,altoGrid from 900_formularios where idFormulario=".$idFormulario;
	$fila=$con->obtenerPrimeraFila($consulta);
	$nombreTabla=$fila[0];
	if($fila[1]!="")
		$idEstado=$fila[1];
	$anchoGrid=$fila[2];
	$altoGrid=$fila[3];
	$idRegistro="-1";
	$idRegistroG="-1";
	if(isset($objParametros->idRegistro))
	{
		$idRegistro=$objParametros->idRegistro;			
		$idRegistroG=$objParametros->idRegistro;			
	}
	$arrColumnasDatos;
	if($con->existeTabla($nombreTabla))
	{
		$existeT=1;
		$consulta="select * from ".$nombreTabla." where id_".$nombreTabla."=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		$numColumnas=mysql_num_fields($res);
		$filaDatos=mysql_fetch_row($res);
		
		for($x=0;$x<$numColumnas;$x++)
		{
			$arrColumnasDatos[mysql_field_name($res,$x)]=$filaDatos[$x];			
		}
	}
	else
		$existeT=0;

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
                   <tr>
                   		<?php 

							$consulta="select titulo from 900_formularios where idFormulario=".$idFormulario;
							$titulo=$con->obtenerValor($consulta);
							$consulta="select max(posY) from 901_elementosFormulario where idFormulario=".$idFormulario;
							$altura=$con->obtenerValor($consulta);
							$altura+=10;
						?>
                        <td height="<?php echo $altoGrid?>px" width="<?php echo $anchoGrid?>px" id='tdContenedor' valign="top" align="center"  >
                        	<fieldset class="frameHijo" style="height:<?php echo $altoGrid ?>px; width:<?php echo $anchoGrid ?>px" ><legend ><b><?php echo $titulo ?></b></legend>
                        	<form method="post" action="../paginasFunciones/guardarDatos.php" id="frmEnvio" enctype="multipart/form-data">
                        	<?php
															
						   		crearElementosFormulario();
															
						   ?>
                           	<input type="hidden" name="tabla" value="<?php echo $nombreTabla ?>" />
                           	<input type="hidden" name="id" value="<?php echo $idRegistroG ?>" />
                           	<input type="hidden" name="campoId" value="id_<?php echo $nombreTabla ?>" />
                            
                            <?php
								if($nomPaginaRegresar=="")
									$pagRedireccion="../formularios/tblFormularios.php";
								else
								{
									if($dependencias==false)
										$pagRedireccion=$nomPaginaRegresar;
									else
									{
										$pagRedireccion="../formularios/registroFormulario.php";
										echo "<input type='hidden' name='reemplazarIDSesion' value='".$numConf."'>";	
										
									}
								}
							?>
                            
							<input type="hidden" name="pagRedireccion" value="<?php echo $pagRedireccion?>"/>
                           	<input type="hidden" name="post" value="confPagina" />
                           	<input type="hidden" name="valorPost" id="valorPost" value="<?php echo $conAnt ?>" />
                           <?php
						   if($idRegistroG=='-1')
						   {
							    echo "<input type='hidden' name='_idEstadoint' id='_idEstadoint' value='".$idEstado."'>";
							   	echo "<input type='hidden' name='_fechaCreaciondta' id='_fechaCreaciondta' value=''>";
							   	echo "<input type='hidden' name='_responsableint' id='_responsableint' value='".$_SESSION["idUsr"]."'>";
								echo "<input type='hidden' name='_responsableint' id='_responsableint' value='".$_SESSION["idUsr"]."'>";
								echo "<input type='hidden' name='_codigoUnidadvch' id='_codigoUnidadvch' value='".$_SESSION["codigoUnidad"]."'>";
								echo '<input type="hidden" name="_codigoInstitucionvch" id="_codigoInstitucionvch" value="'.$_SESSION["codigoInstitucion"].'" />';
						   }
						   else
						   {
								echo "<input type='hidden' name='_fechaModifdta' id='_fechaModifdta' value=''>";
							   	echo "<input type='hidden' name='_respModifint' id='_responsableint' value='".$_SESSION["idUsr"]."'>";
						   }
						   
						   	if(isset($_POST["idReferencia"]))
							{
								echo '<input type="hidden" name="_idReferenciaint" id="_idReferenciaint" value="'.$_POST["idReferencia"].'" />';
								
							}
							
							 $query="select idRolElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 901_elementosFormulario where tipoElemento=20 and idFormulario=".$idFormulario;
							  $res=$con->obtenerFilas($query);
							  
							  while($fila=mysql_fetch_row($res))
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
						   ?>
                           </form>
                           </fieldset>
                        </td>
                        <td >
                        	<input type="hidden" name="hExisteTabla" id="hExisteTabla" value="<?php echo $existeT ?>" />
							<form action="../formularios/tblFormularios.php" method="post"  id='frmCancelar'>
                            	<input type="hidden" name="idFormulario" id="idFormulario"  value="<?php echo $idFormulario ?>" />
                                <?php
                                if(isset($_POST["idReferencia"]))
                                    echo '<input type="hidden" name="idReferencia" id="idReferencia" value="'.$_POST["idReferencia"].'" />';
                            ?>
                            </form>
                       		<form method="post" action="../formularios/tblFormularios.php" id="frmAsociado">
                            	<input type="hidden" id="idFormulario2" name="idFormulario" value="" />
                                <input type="hidden" id="idReferencia2" name="idReferencia" value="" />
                            </form>
                        </td>
                   </tr>
                   <script>
				   		function inializarJavaScript()
						{
				   <?php
                   	echo $funcionesJava;
					?>
						}
                   </script>
                   
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
