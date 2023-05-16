<?php session_start();
	include("conexionBD.php"); 
	
	$parametros="";
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			guardarIncidencia();
			
		break;
	}
	
	function guardarIncidencia()
	{
		global $con;
		$cadObj=$_POST["obj"];	
		$obj=json_decode($cadObj);
		
		$arrCeldas=explode(",",$obj->arrCeldas);
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrCeldas as $celda)
		{
			$datosCelda=explode("_",$celda);
			$consulta[$x]="insert into 9106_Justificaciones(fecha_Inicial,fecha_Final,idUsuario,tipo,comentarios,estado) VALUES('".$datosCelda[2]."','".$datosCelda[2]."',".$datosCelda[1].",".$obj->tipoIncidencia.",'',1)";
			$x++;
		}		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$fila="";
			//$fila=generarFilaUsuario($obj->idUsuario,$obj->idPeriodo,$obj->ciclo,$obj->categoria,$obj->servicio,$obj->turno);
			echo "1|".$fila;	
		}
	}
	
	
	function generarFilaUsuario($idUsuario,$idPeriodo,$ciclo,$idCategoria,$idServicio,$idTurno)
	{
		global $con;
		$ancho=275;
		$anchoCelda=40;
		$altoCelda=35;
		$consulta="select idConfiguracion from 9315_configuracionRolEnfermeria where ciclo=".$ciclo." and idServicio=".$idServicio." and idPeriodo=".$idPeriodo;
		$idConfiguracion=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 9315_periodosRoles WHERE noPeriodo=".$idPeriodo;
		$filaPeriodo=$con->obtenerPrimeraFila($consulta);
		$periodo=$filaPeriodo[1];
		$listMeses=$filaPeriodo[2];
		$arrMeses=explode(",",$listMeses);
		$mesInicio=$arrMeses[0];
		if($mesInicio<10)
			$mesInicio="0".$mesInicio;
		$mesFinal=$arrMeses[sizeof($arrMeses)-1];
		if($mesFinal<10)
			$mesFinal="0".$mesFinal;
		$fInicio=$ciclo."-".$mesInicio."-01";
		$mes = mktime( 0, 0, 0, $mesFinal, 1, $ciclo ); 
		$fFin=$ciclo."-".$mesFinal."-".date("t",$mes);
		
		$fI=strtotime($fInicio);
		$fF=strtotime($fFin);
		$dI=date("w",$fI);
		$dF=date("w",$fF);
		if($dI==0)
			$dI=7;
		$nDias=$dI-1;
		if($dF==0)
			$dF=7;
		$nDiasFin=7-$dF;
		$fechaInicio=strtotime("-".$nDias." days",$fI);
		$fechaFin=strtotime("+".$nDiasFin." days",$fF);
		$consulta="SELECT cmbCaegoria,radTipo,txtSigla,Descripcion,txtCodigo,cmbPermiteAsignar,(select txtCodigo from _800_tablaDinamica where id__800_tablaDinamica=cmbcolorletra) as colorLetra 
					FROM _799_tablaDinamica f,_800_tablaDinamica c WHERE f.cmbColores=c.id__800_tablaDinamica AND cmbCaegoria<>-1";
		$resFunciones=$con->obtenerFilas($consulta);
		$consulta="select i.idUsuario,concat(Paterno,' ',Materno,' ',Nom) as empleado FROM 9315_empleadoRolEnfermeria e,802_identifica i WHERE i.idUsuario=e.idUsuario and 
				idTurno=".$idTurno." AND idCategoria=".$idCategoria." AND idConfiguracion=".$idConfiguracion." and i.idUsuario=".$idUsuario." order by Paterno,Materno,Nom";
	
		$resEmpleados=$con->obtenerFilas($consulta);
		$cadTabla="";
		while($fila=mysql_fetch_row($resEmpleados))
		{
			$cadTabla.="<tr height='".$altoCelda."' id='".$fila[0]."_".$idTurno."'>
							<td style='border:solid; border-width:1px; border-color:#000' align='left'><span class='letraExt' >[".$fila[0]."] <a href='javascript:verUsrNuevaPagina(\"".bE($fila[0])."\")'>".$fila[1]."</a></span></td>";
			$fechaDia=$fechaInicio;
			while($fechaDia<=$fechaFin)
			{
				$check="";
				$nEstilo="";
				$etiqueta="";
				$alt="";
				if(mysql_num_rows($resFunciones)>0)
					mysql_data_seek($resFunciones,0);
				while($filaFunc=mysql_fetch_row($resFunciones))
				{
					$colorLetra=str_replace("#","",$filaFunc[6]);
					if($colorLetra=="")
						$colorLetra="000";
					$cadObj='{"idUsuario":"'.$fila[0].'","fechaVerificar":"'.date('Y-m-d',$fechaDia).'"}';
					$obj=json_decode($cadObj);
					$ref=NULL;
					$resultado=resolverExpresionCalculoPHP($filaFunc[0],$obj,$ref);
					if($resultado==1)
					{
						$etiqueta=$filaFunc[2];
						$alt=$filaFunc[3];
						$filaFunc[4]=str_replace("#","",$filaFunc[4]);
						switch($filaFunc[1])
						{
							case "1":
								$nEstilo="style='color:#".$colorLetra.";background-color:#".$filaFunc[4].";border:solid; border-width:1px; border-color:#000;padding:0px 0px 0px 0px'";
							break;
							case "2";
								$nEstilo="style='color:#".$colorLetra.";border:solid; border-width:1px; border-color:#".$filaFunc[4].";padding:0px 0px 0px 0px'";
							break;
							case "3";
								$nEstilo="style='color:#".$colorLetra.";border:solid; border-width:1px; border-color:#000;padding:0px 0px 0px 0px'";
							break;
						}
						if($filaFunc[5]!=0)
						{
							$check='<input type="checkbox" @name id="chk_'.$fila[0]."_".date("Y-m-d",$fechaDia).'_'.$idTurno.'" @reemplazo @checado onclick="asignaCheck(this)">';
						}
						break;	
									
					}
				}
							
				if($nEstilo=="")
				{
					$estilo="style=\"border:solid; border-width:1px; border-color:#000;padding:0px 0px 0px 0px\"";
					$check='<input type="checkbox" @name  id="chk_'.$fila[0]."_".date("Y-m-d",$fechaDia).'_'.$idTurno.'" @reemplazo @checado onclick="asignaCheck(this)">';
				}
				else
					$estilo=$nEstilo;
							
						
				$cadTabla.="<td  width='40' align='center' ".$estilo." id='".$fila[0]."_".date("Y-m-d",$fechaDia)."_".$idTurno."' onclick='clickCelda(this)'>
							<span alt=".$alt.">".$etiqueta;
				if($check!="")
				{
					$query="select idUsuario from 9315_asignacionesFechas where idTurno=".$idTurno." and idServicio=".$idServicio." and fechaAsignacion='".date("Y-m-d",$fechaDia)."' and idUsuario=".$fila[0];
					$filaAsigna=$con->obtenerPrimeraFila($query);
					if($filaAsigna)
						$check=str_replace("@checado","checked='checked'",$check);
					else
						$check=str_replace("@checado",'',$check);
						
					if($fechaDia<=strtotime(date("Y-m-d")))
					{
						$check=str_replace("@name","",$check);
						$check=str_replace("@reemplazo","disabled='disabled'",$check);
					}
					else
					{
						$check=str_replace("@name","name='checkAsigna'",$check);
						$check=str_replace("@reemplazo","",$check);
					}
					$cadTabla.="<br>".$check;
				}			
							
				
				$cadTabla.="
							</span>
						</td>";
	
				$fechaDia=strtotime("+ 1 days ",$fechaDia);
			}
			
			$cadTabla.="</tr>";
		}
		return $cadTabla;
	}
?>