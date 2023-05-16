<?php session_start();
	include("conexionBD.php"); 
	include_once("funcionesEnvioMensajes.php"); 
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			obtenerPlanesInstitucionales();
		break;
		case 2:
			crearPlanInstitucional();
		break;
		case 3:
			removerPlanInstitucional();
		break;
		case 4:
			obtenerArbolPlanInstitucional();
		break;
		case 5:
			registrarObjetivoEstrategico();
		break;
		case 6:
			registrarProgramaEstrategico();
		break;
		case 7:
			registrarObjetivoEspecifico();
		break;
		case 8:	
			registrarLineaAccion();
		break;
		case 9:
			removerElemento();
		break;
		case 10:
			obtenerFinesPlanInstitucional();
		break;
		case 11:
			registrarFinesPlanInstitucional();
		break;
		case 12:
			removerFinPlanInstitucional();
		break;
		case 13:
			obtenerEstructurasProgramaticas();
		break;
		case 14:
			obtenerPlanesInstitucionalesCiclo();
		break;
		case 15:
			registrarEtructuraProgramatica();
		break;
		case 16:
			removerEstructuraProgramatica();
		break;
		case 17:
			obtenerFinalidades();
		break;
		case 18:
			registrarFinalidad();
		break;
		case 19:
			removerElementoEstrutura();
		break;
		case 20:
			obtenerFunciones();
		break;
		case 21:
			registrarFuncion();
		break;
		case 22:
			obtenerActividadesInstitucionales();
		break;
		case 23:
			registrarSubFuncion();
		break;
		case 24:
			obtenerGruposActividadesInstitucionales();
		break;
		case 25:
			registrarGrupoActividadInstitucional();
		break;
		case 26:
			removerGrupoActividadInstitucional();
		break;
		case 27:	
			registrarActividadInstitucional();
		break;
		case 28:	
			removerActividadInstitucional();
		break;
		case 29:
			registrarModalidadPrograma();
		break;
		case 30:
			obtenerProgramasPresupuestarios();
		break;
		case 31:
			registrarTipoPrograma();
		break;
		case 32:
			registrarProgramaPresupuestario();
		break;
		case 33:
			registrarSubProgramaPresupuestario();
		break;
		case 34:
			obtenerEstructuraProgramatica();
		break;
		case 35:
			removerElementoEstructuraProgramatica();
		break;
		case 36:
			removerSubProgramaPresupuestario();
		break;
		case 37:
			obtenerInfoSubprograma();
		break;
		case 38:
			obtenerProgramasObjetivosEstrategicos();
		break;
		case 39:
			registrarProblemaCentral();
		break;
		case 40:
			registrarEfecto();
		break;
		case 41:
			registrarCausa();
		break;
		case 42:
			removerElementoArbolProblemas();
		break;
		case 43:
			registrarObjetivoCentral();
		break;
		case 44:
			registrarFin();
		break;
		case 45:
			registrarMedio();
		break;
		case 46:
			removerElementoArbolObjetivos();
		break;
		case 47:
			obtenerActividadesMedios();
		break;
		case 48:
			obtenerCentrosGestoresConvocatoria();
		break;
		case 49:
			obtenerObjetivosProgramaEstrategico();
		break;
		case 50:
			obtenerPartidaPresupuestaria();
		break;
		case 51:
			obtenerInformacionArbolProblemas();
		break;
		case 52:
			obtenerInformacionArbolObjetivos();
		break;
		case 53:
			funcionesPlaneacionEstrategica();
		break;
		case 54:
			obtenerInformesResultadosIndicadores();
		break;
		case 55:
			obtenerIndicadoresAdministracionArea();
		break;
		case 56:
			asignarFuncionCalculoIndicador();
		break;
		case 57:
			importarIndicador();
		break;
		case 58:
			obtenerIndicadoresAreaInforme();
		break;
	}
	
	function obtenerPlanesInstitucionales()
	{
		global $con;
		$consulta="SELECT idPlanInstitucional,nombrePlan,propositoPlan,periodoInicioPlan,periodoTerminoPlan FROM 3200_planesInstitucionales  ORDER BY idPlanInstitucional";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function crearPlanInstitucional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="";
		if($obj->idPlanInstitucional==-1)
		{
			$consulta="INSERT INTO 3200_planesInstitucionales(nombrePlan,periodoInicioPlan,periodoTerminoPlan,propositoPlan,responsableCreacion,fechaCreacion)
					VALUES('".cv($obj->nombrePlan)."','".cv($obj->fechaInicio)."','".cv($obj->fechaTermino)."','".cv($obj->proposito)."',".
					$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."')";
		}
		else
		{
			$consulta="update 3200_planesInstitucionales set nombrePlan='".cv($obj->nombrePlan)."',periodoInicioPlan='".cv($obj->fechaInicio).
					"',periodoTerminoPlan='".cv($obj->fechaTermino)."',propositoPlan='".cv($obj->proposito)."',responsableUltimaModificacion=".
					$_SESSION["idUsr"].",fechaUltimaModificacion='".date("Y-m-d H:i:s")."' where idPlanInstitucional=".$obj->idPlanInstitucional;

		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idPlanInstitucional==-1)
			{
				$idPlanInstitucional=$con->obtenerUltimoID();
				echo "1|".$idPlanInstitucional;
			}
			else
				echo "1|".$obj->idPlanInstitucional;
		}
	}
	
	function removerPlanInstitucional()
	{
		global $con;
		$idPlanInstitucional=$_POST["idPlanInstitucional"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3200_planesInstitucionales WHERE idPlanInstitucional=".$idPlanInstitucional;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);		
	}
	
	
	function obtenerArbolPlanInstitucional()
	{
		global $con;
		$idPlan=$_POST["idPlan"];
		$idObjetivoEstrategico=$_POST["idObjetivoEstrategico"];
		$idProgramaEstrategico=$_POST["idProgramaEstrategico"];
		
		$consulta="SELECT propositoPlan FROM 3200_planesInstitucionales WHERE idPlanInstitucional=".$idPlan;
		$proposito=$con->obtenerValor($consulta);
		
		$arrObjetivosEstrategicos="";
		$consulta="SELECT idRegistro,noObjetivo,descripcionObjetivo FROM 3201_objetivosEstrategicos WHERE 
				idPlanInstitucional=".$idPlan;
		if($idObjetivoEstrategico!=0)
		{
			$consulta.=" and idRegistro=".$idObjetivoEstrategico;	
		}
		$consulta.="  ORDER BY CAST(noObjetivo AS SIGNED),noObjetivo";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrProgramasEstrategicos="";
			$consulta="SELECT idRegistro,noProgramaEstrategico,descripcionProgramaEstrategico FROM 3202_programasEstrategicos 
						WHERE idObjetivoEstrategico=".$fila[0];
			if($idProgramaEstrategico!=0)
			{
				$consulta.=" and idRegistro=".$idProgramaEstrategico;
			}
			$consulta.=" ORDER BY CAST(noProgramaEstrategico AS SIGNED),noProgramaEstrategico";
			$resPrograma=$con->obtenerFilas($consulta);
			while($filaProgramaEstrategico=mysql_fetch_row($resPrograma))
			{
				$arrObjetivosEspecificos="";
				$consulta="SELECT idRegistro,noObjetivoEspecifico,descripcionObjetivoEspecifico FROM 3203_objetivosEspecificos 
						WHERE idProgramaEstrategico=".$filaProgramaEstrategico[0]." ORDER BY CAST(noObjetivoEspecifico AS SIGNED),noObjetivoEspecifico";
				$resObjetivoEspecifico=$con->obtenerFilas($consulta);
				while($filaObjetivoEspecifico=mysql_fetch_row($resObjetivoEspecifico))
				{
					$arrLineasAccion="";
					$consulta="SELECT idRegistro,noLineaAccion,descripcionLineaAccion FROM 3204_lineasAccion 
							WHERE idObjetivoEspecifico=".$filaObjetivoEspecifico[0]." ORDER BY CAST(noLineaAccion AS SIGNED),noLineaAccion";
					$resLineaAccion=$con->obtenerFilas($consulta);
					while($filaLineaAccion=mysql_fetch_row($resLineaAccion))
					{
						$consulta="SELECT areaResponsable FROM 3204_areasResponsables WHERE idLineaAccion=".$filaLineaAccion[0];
						$arrAreas=$con->obtenerListaValores($consulta,"'");
						$oLineaAccion='{"icon":"../images/s.gif","id":"5_'.$filaLineaAccion[0].
							'","tipoNodo":"5","text":"<span style=\'color:#A12D0A;\'>L&iacute;nea de Acci&oacute;n '.$filaLineaAccion[1].
							'.-</span>","detalle":"'.cv($filaLineaAccion[2]).
							'",children:[],"leaf":true,expanded:true,"noLinea":"'.cv($filaLineaAccion[1]).'","descripcionLinea":"'.cv($filaLineaAccion[2]).
							'","idRegistro":"'.$filaLineaAccion[0].'","arrAreas":['.$arrAreas.']}';
					
						if($arrLineasAccion=="")
							$arrLineasAccion=$oLineaAccion;
						else
							$arrLineasAccion.=",".$oLineaAccion;
					}
					
					
					$oObjetivoEspecifico='{"icon":"../images/s.gif","id":"4_'.$filaObjetivoEspecifico[0].
						'","tipoNodo":"4","text":"<span style=\'color:#025816;\'>Objetivo Espec&iacute;fico '.$filaObjetivoEspecifico[1].
						'.-</span>","detalle":"'.cv($filaObjetivoEspecifico[2]).
						'",children:['.$arrLineasAccion.'],"leaf":'.($arrLineasAccion==""?"true":"false").
						',expanded:true,"noObjetivo":"'.cv($filaObjetivoEspecifico[1]).'","descripcionObjetivo":"'.cv($filaObjetivoEspecifico[2]).
						'","idRegistro":"'.$filaObjetivoEspecifico[0].'"}';
				
					if($arrObjetivosEspecificos=="")
						$arrObjetivosEspecificos=$oObjetivoEspecifico;
					else
						$arrObjetivosEspecificos.=",".$oObjetivoEspecifico;
					
				}
				
				$oProgramaEstrategico='{"icon":"../images/s.gif","id":"3_'.$filaProgramaEstrategico[0].'","tipoNodo":"3","text":"<span style=\'color:#0C087C;\'>Programa Estrat&eacute;gico '.$filaProgramaEstrategico[1].'.-</span>","detalle":"'.cv($filaProgramaEstrategico[2]).
						'",children:['.$arrObjetivosEspecificos.'],"leaf":'.($arrObjetivosEspecificos==""?"true":"false").
						',expanded:true,"noPrograma":"'.cv($filaProgramaEstrategico[1]).'","descripcionPrograma":"'.cv($filaProgramaEstrategico[2]).
						'","idRegistro":"'.$filaProgramaEstrategico[0].'"}';
				
				if($arrProgramasEstrategicos=="")
					$arrProgramasEstrategicos=$oProgramaEstrategico;
				else
					$arrProgramasEstrategicos.=",".$oProgramaEstrategico;
			}
			
			
			$oEstrategico='{"icon":"../images/s.gif","id":"2_'.$fila[0].'","tipoNodo":"2","text":"<span style=\'color:#000;\'><b>Objetivo Estrat&eacute;gico '.$fila[1].'.-</b></span>","detalle":"'.cv($fila[2]).
						'",children:['.$arrProgramasEstrategicos.'],"leaf":'.($arrProgramasEstrategicos==""?"true":"false").
						',expanded:true,"noObjetivo":"'.cv($fila[1]).'","descripcionObjetivo":"'.cv($fila[2]).'","idRegistro":"'.$fila[0].'"}';
			if($arrObjetivosEstrategicos=="")
				$arrObjetivosEstrategicos=$oEstrategico;
			else
				$arrObjetivosEstrategicos.=",".$oEstrategico;

		}
		
		echo '[{"icon":"../images/s.gif","id":"'.$idPlan.'",expanded:true,"tipoNodo":"1","text":"<span style=\'color:#900;\'><b>Pr&oacute;posito del plan</b></span>","detalle":"'.cv($proposito).
				'",children:['.$arrObjetivosEstrategicos.'],"leaf":'.($arrObjetivosEstrategicos==""?"true":"false").'}]';
		
		
	}
	
	function registrarObjetivoEstrategico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idObjetivo==-1)
		{
			$consulta="INSERT INTO 3201_objetivosEstrategicos(idPlanInstitucional,noObjetivo,descripcionObjetivo) VALUES(".$obj->idPlan.
						",'".cv($obj->noObjetivo)."','".cv($obj->descripcionObjetivo)."')";
		}
		else
		{
			$consulta="update 3201_objetivosEstrategicos set noObjetivo='".cv($obj->noObjetivo)."',descripcionObjetivo='".cv($obj->descripcionObjetivo)."'
						where idRegistro=".$obj->idObjetivo;
		}
		
		eC($consulta);
		
	}
	
	function registrarProgramaEstrategico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idPrograma==-1)
		{
			$consulta="INSERT INTO 3202_programasEstrategicos(idPlanInstitucional,idObjetivoEstrategico,noProgramaEstrategico,descripcionProgramaEstrategico) 
						VALUES(".$obj->idPlan.",".$obj->idObjetivoEstrategico.",'".cv($obj->noPrograma)."','".cv($obj->descripcionPrograma)."')";
		}
		else
		{
			$consulta="update 3202_programasEstrategicos set noProgramaEstrategico='".cv($obj->noPrograma)."',descripcionProgramaEstrategico='".cv($obj->descripcionPrograma)."'
						where idRegistro=".$obj->idPrograma;
		}
		
		eC($consulta);
		
	}
	
	function registrarObjetivoEspecifico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idObjetivo==-1)
		{
			$consulta="INSERT INTO 3203_objetivosEspecificos(idPlanInstitucional,idProgramaEstrategico,noObjetivoEspecifico,descripcionObjetivoEspecifico) 
						VALUES(".$obj->idPlan.",".$obj->idProgramaEstrategico.",'".cv($obj->noObjetivo)."','".cv($obj->descripcionObjetivo)."')";
		}
		else
		{
			$consulta="update 3203_objetivosEspecificos set noObjetivoEspecifico='".cv($obj->noObjetivo)."',descripcionObjetivoEspecifico='".
					cv($obj->descripcionObjetivo)."' where idRegistro=".$obj->idObjetivo;
		}
		
		eC($consulta);
		
	}
	
	function registrarLineaAccion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($obj->idLinea==-1)
		{
			$consulta[$x]="INSERT INTO 3204_lineasAccion(idPlanInstitucional,idObjetivoEspecifico,noLineaAccion,descripcionLineaAccion) 
						VALUES(".$obj->idPlan.",".$obj->idObjetivoEspecifico.",'".cv($obj->noLinea)."','".cv($obj->descripcionLinea)."')";
			$x++;
			
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 3204_lineasAccion set noLineaAccion='".cv($obj->noLinea)."',descripcionLineaAccion='".
					cv($obj->descripcionLinea)."' where idRegistro=".$obj->idLinea;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idLinea;
			$x++;
		}
		$consulta[$x]="DELETE FROM 3204_areasResponsables WHERE idLineaAccion=@idRegistro";
		$x++;
		$arrAreas=explode(",",$obj->arrAreas);
		
		foreach($arrAreas as $a)
		{
			$consulta[$x]="INSERT INTO 3204_areasResponsables(idLineaAccion,areaResponsable) VALUES(@idRegistro,'".$a."')";
			$x++;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		
			
		eB($consulta);
		
	}
	
	function removerElemento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		switch($obj->tipoElemento)
		{
			case 2:
				removerObjetivoEstrategico($obj->idElemento);
			break;
			case 3:
				removerProgramaEstrategico($obj->idElemento);
			break;
			case 4:
				removerObjetivoEspecifico($obj->idElemento);
			break;
			case 5:
				removerLineaAccion($obj->idElemento);
			break;
		}
		
		echo "1|";
		
	}
	
	function removerLineaAccion($idElemento)
	{
		global $con;
		$consulta="DELETE FROM 3204_lineasAccion WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function removerObjetivoEspecifico($idElemento)
	{
		global $con;
		$consulta="SELECT idRegistro FROM 3204_lineasAccion WHERE idObjetivoEspecifico=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerLineaAccion($fila[0]);
		}
		$consulta="DELETE FROM 3203_objetivosEspecificos WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
		
	}
	
	function removerProgramaEstrategico($idElemento)
	{
		global $con;
		$consulta="SELECT idRegistro FROM 3203_objetivosEspecificos WHERE idProgramaEstrategico=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerObjetivoEspecifico($fila[0]);
		}
		$consulta="DELETE FROM 3202_programasEstrategicos WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
		
	}
	
	function removerObjetivoEstrategico($idElemento)
	{
		global $con;
		$consulta="SELECT idRegistro FROM 3202_programasEstrategicos WHERE idObjetivoEstrategico=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerProgramaEstrategico($fila[0]);
		}
		$consulta="DELETE FROM 3201_objetivosEstrategicos WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
		
	}
	
	function obtenerFinesPlanInstitucional()
	{
		global $con;
		$idPlan=$_POST["idPlan"];
		$consulta="SELECT idRegistro,descripcionFin,nivelFin FROM 3205_finesPlanInstitucional WHERE idPlanInstitucional=".$idPlan." order by nivelFin desc";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarFinesPlanInstitucional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		
		
		$consulta="";
		if($obj->idFin==-1)
		{
			$consulta="INSERT INTO 3205_finesPlanInstitucional(idPlanInstitucional,nivelFin,descripcionFin) VALUES(".$obj->idPlan.",".$obj->nivelPlan.",'".cv($obj->finPlan)."')";
		}
		else
		{
			$consulta="update 3205_finesPlanInstitucional set nivelFin=".$obj->nivelPlan.",descripcionFin='".cv($obj->finPlan)."' where idRegistro=".$obj->idFin;
		}
		
		eC($consulta);
	}
	
	
	function removerFinPlanInstitucional()
	{
		global $con;
		$idFin=$_POST["idFin"];
		$consulta="DELETE FROM 3205_finesPlanInstitucional WHERE idRegistro=".$idFin;
		eC($consulta);
	}
	
	function obtenerEstructurasProgramaticas()
	{
		global $con;
		$consulta="SELECT idRegistro,nombreEstructura,cicloFiscal,planInstitucional,descripcion FROM 3206_estructurasProgramaticas";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';	
	}
	
	function obtenerPlanesInstitucionalesCiclo()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idPlanInstitucional,nombrePlan FROM 3200_planesInstitucionales WHERE (periodoInicioPlan>='".$ciclo."-01-01' 
					AND periodoInicioPlan<='".$ciclo."-12-31') OR (periodoTerminoPlan>='".$ciclo."-01-01'  AND periodoTerminoPlan<='".
					$ciclo."-12-31') ORDER BY nombrePlan";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function registrarEtructuraProgramatica()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idEstructura==-1)
		{
			$consulta="INSERT INTO 3206_estructurasProgramaticas(nombreEstructura,descripcion,cicloFiscal,planInstitucional,idTabuladorObjetoGasto)
					VALUES('".cv($obj->nombreEstructura)."','".cv($obj->descripcion)."',".$obj->cicloFiscal.",".$obj->planInstitucional.
					",".$obj->clasificadorObjetoGasto.")";
		}
		else
		{
			$consulta="update 3206_estructurasProgramaticas set nombreEstructura='".cv($obj->nombreEstructura)."',descripcion='".cv($obj->descripcion).
					"',cicloFiscal=".$obj->cicloFiscal.",planInstitucional=".$obj->planInstitucional.
					", idTabuladorObjetoGasto=".$obj->clasificadorObjetoGasto." where idRegistro=".$obj->idEstructura;

		}

		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idEstructura==-1)
			{
				$idEstructura=$con->obtenerUltimoID();
				echo "1|".$idEstructura;
			}
			else
				echo "1|".$obj->idEstructura;
		}
	}
	
	function removerEstructuraProgramatica()
	{
		global $con;
		$idEstructura=$_POST["idEstructura"];
		$consulta="DELETE FROM 3206_estructurasProgramaticas WHERE idRegistro=".$idEstructura;
		eC($consulta);
	}
	
	function obtenerFinalidades()
	{
		global $con;
		$idNodo=-1;
		if(isset($_POST["nodoSel"]))
			$idNodo=$_POST["nodoSel"];

		$vistaCheck=0;
		if(isset($_POST["vistaCheck"]))
			$vistaCheck=$_POST["vistaCheck"];
		$arrRegistros="";
		$idEstructura=$_POST["idEstructura"];
		$consulta="SELECT idRegistro,cveFinalidad,finalidad,descripcion FROM 3207_finalidades WHERE idEstructura=".$idEstructura." ORDER BY cveFinalidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrFunciones="";
			
			$consulta="SELECT idRegistro,cveFuncion,funcion,descripcion FROM 3208_funciones WHERE idFinalidad=".$fila[0]." ORDER BY cveFuncion";
			$resFunciones=$con->obtenerFilas($consulta);
			while($filaFuncion=mysql_fetch_row($resFunciones))
			{
				$arrSubFunciones="";
				$consulta="SELECT idRegistro,cveSubFuncion,subFuncion,descripcion FROM 3209_subFunciones WHERE idFuncion=".$filaFuncion[0]." ORDER BY cveSubFuncion";
				$resSubFunciones=$con->obtenerFilas($consulta);
				while($filaSubFuncion=mysql_fetch_row($resSubFunciones))
				{
					$checado="false";
					if($idNodo==("3_".$filaSubFuncion[0]))
						$checado="true";
						

						
					$o='{"tipoNodo":"3","id":"3_'.$filaSubFuncion[0].'","text":"<span style=\'color:#0C087C\'><b>SF</b></span>","lblClave":"'.cv($fila[1]).'.'.cv($filaFuncion[1]).'.'.
						cv($filaSubFuncion[1]).'","cveElemento":"'.cv($filaSubFuncion[1]).'","detalle":"'.cv($filaSubFuncion[2]).
						'","leaf":true,expanded:true,children:[],"descripcion":"'.cv($filaSubFuncion[3]).
					'","idRegistro":"'.$filaSubFuncion[0].'"'.($vistaCheck==1?(",checked:".$checado):"").'}';
				
					if($arrSubFunciones=="")
						$arrSubFunciones=$o;
					else	
						$arrSubFunciones.=",".$o;
				}
				$o='{"icon":"../images/s.gif","tipoNodo":"2","id":"2_'.$filaFuncion[0].'","text":"<span style=\'color:#000\'><b>F</b></span>","lblClave":"'.cv($fila[1]).'.'.cv($filaFuncion[1]).'","cveElemento":"'.cv($filaFuncion[1]).'","detalle":"'.cv($filaFuncion[2]).'","leaf":'.
					($arrSubFunciones==""?"true":"false").',expanded:'.($vistaCheck==1?"false":"true").',children:['.$arrSubFunciones.'],"descripcion":"'.cv($filaFuncion[3]).
					'","idRegistro":"'.$filaFuncion[0].'"}';
				
				if($arrFunciones=="")
					$arrFunciones=$o;
				else	
					$arrFunciones.=",".$o;
			}
			
			$o='{"icon":"../images/s.gif","tipoNodo":"1","id":"1_'.$fila[0].'","text":"<span style=\'color:#900\'><b>FI</b></span>","lblClave":"'.cv($fila[1]).'","cveElemento":"'.cv($fila[1]).'","detalle":"'.cv($fila[2]).'","leaf":'.
					($arrFunciones==""?"true":"false").',expanded:true,children:['.$arrFunciones.'],"descripcion":"'.cv($fila[3]).'","idRegistro":"'.$fila[0].'"}';
				
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
		
	}
	
	function registrarFinalidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3207_finalidades(cveFinalidad,finalidad,idEstructura,descripcion) 
						VALUES('".cv($obj->cveFinalidad)."','".cv($obj->finalidad)."',".$obj->idEstructura.",'".cv($obj->descripcion)."')";
		}
		else
		{
			$consulta="update 3207_finalidades set cveFinalidad='".cv($obj->cveFinalidad)."',finalidad='".
						cv($obj->finalidad)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);
	}
	
	function removerElementoEstrutura()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		switch($obj->tipoElemento)
		{
			case 1:
				removerFinalidad($obj->idElemento);
			break;
			case 2:
				removerFuncion($obj->idElemento);
			break;
			case 3:
				removerSubFuncion($obj->idElemento);
			break;
		}
		
		echo "1|";
	}
	
	function registrarFuncion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3208_funciones(cveFuncion,funcion,idEstructura,idFinalidad,descripcion )
						VALUES('".cv($obj->cveFuncion)."','".cv($obj->funcion)."',".$obj->idEstructura.
						",".$obj->idFinalidad.",'".cv($obj->descripcion)."')";
		}
		else
		{
			$consulta="update 3208_funciones set cveFuncion='".cv($obj->cveFuncion)."',funcion='".
						cv($obj->funcion)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);
	}
	
	function registrarSubFuncion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3209_subFunciones(cveSubFuncion,subFuncion,idEstructura,idFuncion,descripcion )
						VALUES('".cv($obj->cveSubFuncion)."','".cv($obj->subFuncion)."',".$obj->idEstructura.
						",".$obj->idFuncion.",'".cv($obj->descripcion)."')";
		}
		else
		{
			$consulta="update 3209_subFunciones set cveSubFuncion='".cv($obj->cveSubFuncion)."',subFuncion='".
						cv($obj->subFuncion)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);
	}
	
	function removerSubFuncion($idElemento)
	{
		global $con;
		$consulta="DELETE FROM 3209_subFunciones WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function removerFuncion($idElemento)
	{
		global $con;
		$consulta="SELECT idRegistro FROM 3209_subFunciones WHERE idFuncion=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerSubFuncion($fila[0]);
		}	
		$consulta="DELETE FROM 3208_funciones WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function removerFinalidad($idElemento)
	{
		global $con;
		$consulta="SELECT idRegistro FROM 3208_funciones WHERE idFinalidad=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerFuncion($fila[0]);
		}	
		$consulta="DELETE FROM 3207_finalidades WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	
	function obtenerGruposActividadesInstitucionales()
	{
		global $con;
		$idEstructura=$_POST["idEstructura"];
		$consulta="SELECT idRegistro,cveGrupoActividad,grupoActividad,objetivoActividad 
				FROM 3210_grupoActividades WHERE  idEstructura=".$idEstructura." ORDER BY cveGrupoActividad";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarGrupoActividadInstitucional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idGrupo==-1)
		{
			$consulta="INSERT INTO 3210_grupoActividades(cveGrupoActividad,grupoActividad,objetivoActividad,idEstructura) 
					VALUES('".cv($obj->claveGrupo)."','".cv($obj->nombreGrupo)."','".cv($obj->objetivoGrupo)."',".cv($obj->idEstructura).")";
		}
		else
		{
			$consulta="update 3210_grupoActividades set cveGrupoActividad='".cv($obj->claveGrupo)."',grupoActividad='".cv($obj->nombreGrupo).
					"',objetivoActividad='".cv($obj->objetivoGrupo)."' where idRegistro=".$obj->idGrupo; 

		}
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idRegistro,CONCAT('(',cveGrupoActividad,') ',grupoActividad) AS denominacion
				FROM 3210_grupoActividades WHERE  idEstructura=".$obj->idEstructura." ORDER BY cveGrupoActividad";
			$arrRegistros=$con->obtenerFilasArreglo($consulta);		
			echo "1|".$arrRegistros;		
		}

	}
	
	function removerGrupoActividadInstitucional()
	{
		global $con;
		$iGA=$_POST["iGA"];
		$idEstructura=$_POST["idEstructura"];
		$consulta="DELETE FROM 3210_grupoActividades WHERE idRegistro=".$iGA;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idRegistro,CONCAT('(',cveGrupoActividad,') ',grupoActividad) AS denominacion
				FROM 3210_grupoActividades WHERE  idEstructura=".$idEstructura." ORDER BY cveGrupoActividad";
			$arrRegistros=$con->obtenerFilasArreglo($consulta);		
			echo "1|".$arrRegistros;		
		}
	}
	
	function registrarActividadInstitucional()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="select count(*) from 3211_actividadesInstitucionales where idEstructura=".$obj->idEstructura." and claveActividad='".
				$obj->claveActividad."' and idRegistro<>".$obj->idActividad;
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)
		{
			echo "<br>La clave de la actividad ya ha sido registrada previamente";
			return;
		}
		if($obj->idActividad==-1)
		{
			$consulta="INSERT INTO 3211_actividadesInstitucionales(idEstructura,idSubFuncion,grupoActividad,claveActividad,actividadInstitucional,objetivoActividadInstitucional)
					VALUES(".$obj->idEstructura.",".$obj->subFuncion.",".$obj->grupoActividad.",'".cv($obj->claveActividad).
					"','".cv($obj->actividadInstitucional)."','".cv($obj->objetivoActividadInstitucional)."')";
		}
		else
		{
			$consulta="update 3211_actividadesInstitucionales set idSubFuncion=".$obj->subFuncion.",grupoActividad=".$obj->grupoActividad.
						",claveActividad='".cv($obj->claveActividad)."',actividadInstitucional='".cv($obj->actividadInstitucional).
						"',objetivoActividadInstitucional='".cv($obj->objetivoActividadInstitucional)."' where idRegistro=".$obj->idActividad; 

		}
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idRegistro,CONCAT('(',claveActividad,') ',actividadInstitucional) AS denominacion
				FROM 3211_actividadesInstitucionales WHERE  idEstructura=".$obj->idEstructura." ORDER BY claveActividad";
			$arrRegistros=$con->obtenerFilasArreglo($consulta);		
			echo "1|".$arrRegistros;		
		}
	}
	
	function removerActividadInstitucional()
	{
		global $con;
		$idActividad=$_POST["idActividad"];
		$idEstructura=$_POST["idEstructura"];
		$consulta="DELETE FROM 3211_actividadesInstitucionales WHERE idRegistro=".$idActividad;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idRegistro,CONCAT('(',claveActividad,') ',actividadInstitucional) AS denominacion
				FROM 3211_actividadesInstitucionales WHERE  idEstructura=".$obj->idEstructura." ORDER BY claveActividad";
			$arrRegistros=$con->obtenerFilasArreglo($consulta);		
			echo "1|".$arrRegistros;		
		}
	}
	
	function obtenerActividadesInstitucionales()
	{
		global $con;
		$idEstructura=$_POST["idEstructura"];
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT idRegistro,idSubFuncion,grupoActividad,claveActividad,actividadInstitucional,objetivoActividadInstitucional 
					FROM 3211_actividadesInstitucionales WHERE idEstructura=".$idEstructura." ORDER BY claveActividad";
					
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT cveSubFuncion,subFuncion,idFuncion FROM 3209_subFunciones WHERE idRegistro=".$fila[1];
			$fSubFuncion=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT cveFuncion,funcion,idFinalidad FROM 3208_funciones WHERE idRegistro=".$fSubFuncion[2];
			$fFuncion=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT cveFinalidad,finalidad FROM 3207_finalidades WHERE idRegistro=".$fFuncion[2];
			$fFinalidad=$con->obtenerPrimeraFila($consulta);
			
			$o='{"idRegistro":"'.$fila[0].'","finalidad":"'.$fFinalidad[0].'","funcion":"'.$fFuncion[0].'","subfuncion":"'.$fSubFuncion[0].
				'","actividadInstitucional":"'.cv($fila[4]).'","cveActividad":"'.cv($fila[3]).'","objetivoActividadInstitucional":"'.
				cv($fila[5]).'","grupoActividad":"'.$fila[2].'","idSubFuncion":"'.$fila[1].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}	
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarModalidadPrograma()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3212_modalidesProgramasPresupuestarios(cveModalidad,modalidad,idEstructura,descripcion) 
						VALUES('".cv($obj->cveModalidad)."','".cv($obj->modalidad)."',".$obj->idEstructura.",'".cv($obj->descripcion)."')";
		}
		else
		{
			$consulta="update 3212_modalidesProgramasPresupuestarios set cveModalidad='".cv($obj->cveModalidad)."',modalidad='".
						cv($obj->modalidad)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);
	}
	
	function obtenerProgramasPresupuestarios()
	{
		global $con;
		/*$idNodo=-1;
		if(isset($_POST["nodoSel"]))
			$idNodo=$_POST["nodoSel"];

		$vistaCheck=0;
		if(isset($_POST["vistaCheck"]))
			$vistaCheck=$_POST["vistaCheck"];*/
		$arrRegistros="";
		$idEstructura=$_POST["idEstructura"];
		$consulta="SELECT idRegistro,cveModalidad,modalidad,descripcion FROM 3212_modalidesProgramasPresupuestarios WHERE idEstructura=".$idEstructura." ORDER BY cveModalidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrFunciones="";
			
			$consulta="SELECT idRegistro,cveTipoPrograma,tipoPrograma,descripcion FROM 3213_tiposProgramasPresupuestarios WHERE idModalidad=".$fila[0]." ORDER BY cveTipoPrograma";
			$res2=$con->obtenerFilas($consulta);
			while($fila2=mysql_fetch_row($res2))
			{
				$arrSubFunciones="";
				$consulta="SELECT idRegistro,cveProgramaPresupuestario,programaPresupuestario,objetivoProgramaPresupuestario,idActividadInstitucional 
							FROM 3214_programasPresupuestarios WHERE idTipoPrograma=".$fila2[0]." ORDER BY cveProgramaPresupuestario";
				$res3=$con->obtenerFilas($consulta);
				while($fila3=mysql_fetch_row($res3))
				{
					$o='{"tipoNodo":"3","id":"3_'.$fila3[0].'","text":"<span style=\'color:#0C087C\'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PP</b></span>","lblClave":"'.
						cv($fila3[1]).'","cveElemento":"'.cv($fila3[1]).'","detalle":"'.cv($fila3[2]).'","leaf":true,expanded:true,children:[],
						"descripcion":"'.cv($fila3[3]).'","idRegistro":"'.$fila3[0].'","idActividadInstitucional":"'.$fila3[4].'"}';
				
					if($arrSubFunciones=="")
						$arrSubFunciones=$o;
					else	
						$arrSubFunciones.=",".$o;
				}
				$o='{"icon":"../images/s.gif","tipoNodo":"2","id":"2_'.$fila2[0].'","text":"<span style=\'color:#000\'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T</b></span>","lblClave":"'.cv($fila2[1]).'","cveElemento":"'.cv($fila2[1]).'","detalle":"'.cv($fila2[2]).'","leaf":'.
					($arrSubFunciones==""?"true":"false").',expanded:true,children:['.$arrSubFunciones.'],"descripcion":"'.cv($fila2[3]).
					'","idRegistro":"'.$fila2[0].'"}';
				
				if($arrFunciones=="")
					$arrFunciones=$o;
				else	
					$arrFunciones.=",".$o;
			}
			
			$o='{"icon":"../images/s.gif","tipoNodo":"1","id":"1_'.$fila[0].'","text":"<span style=\'color:#900\'><b>M</b></span>","lblClave":"'.cv($fila[1]).'","cveElemento":"'.cv($fila[1]).'","detalle":"'.cv($fila[2]).'","leaf":'.
					($arrFunciones==""?"true":"false").',expanded:true,children:['.$arrFunciones.'],"descripcion":"'.cv($fila[3]).'","idRegistro":"'.$fila[0].'"}';
				
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
		
	}
	
	
	function registrarTipoPrograma()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3213_tiposProgramasPresupuestarios(cveTipoPrograma,tipoPrograma,idEstructura,descripcion,idModalidad) 
						VALUES('".cv($obj->cveTipo)."','".cv($obj->tipo)."',".$obj->idEstructura.",'".
						cv($obj->descripcion)."',".$obj->idModalidad.")";
		}
		else
		{
			$consulta="update 3213_tiposProgramasPresupuestarios set cveTipoPrograma='".cv($obj->cveTipo)."',tipoPrograma='".
						cv($obj->tipo)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);
	}
	
	function registrarProgramaPresupuestario()
	{
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idProgramaPresupuestario==-1)
		{
			$consulta="INSERT INTO 3214_programasPresupuestarios(cveProgramaPresupuestario,programaPresupuestario,idTipoPrograma,
						idEstructura,objetivoProgramaPresupuestario,idActividadInstitucional) VALUES('".cv($obj->clavePrograma).
						"','".cv($obj->programaPresupuestario)."',".$obj->idTipoPrograma.",".$obj->idEstructura.",'".
						cv($obj->objetivoProgramaPresupuestario)."',".$obj->idActividadInstitucional.")";
		}
		else
		{
			$consulta="update 3214_programasPresupuestarios set cveProgramaPresupuestario='".cv($obj->clavePrograma)."',programaPresupuestario='".
						$obj->programaPresupuestario."',objetivoProgramaPresupuestario='".cv($obj->objetivoProgramaPresupuestario).
						"',idActividadInstitucional=".$obj->idActividadInstitucional." where idRegistro=".$obj->idProgramaPresupuestario;
		}
		
		eC($consulta);
	}
	
	function obtenerEstructuraProgramatica()
	{
		global $con;
		$fFinalidad="";
		$fFuncion="";
		$fSubFuncion="";
		$fActividadInst="";
		$fPrograma="";
		$fSubPrograma="";
		
		if(isset($_POST["filter"]))
		{
			$filter=$_POST["filter"];
			$nFiltros=sizeof($filter);
			
			for($x=0;$x<$nFiltros;$x++)
			{
				switch($filter[$x]["field"])
				{
					case "finalidad":
						$fFinalidad=" and cveFinalidad like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "funcion":
						$fFuncion=" and cveFuncion like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "subfuncion":
						$fSubFuncion=" and cveSubFuncion like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "actividadInstitucional":
						$fActividadInst=" and claveActividad like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "programaPresupuestario":
						$fPrograma=" and cveProgramaPresupuestario like '%".$filter[$x]["data"]["value"]."%'";
					break;
					case "subProgramaPresupuestario":
						$fSubPrograma=" and cveSubPrograma like '%".$filter[$x]["data"]["value"]."%'";
					break;
					
				}
			}
			
		}
		
		$numReg=0;
		$arrRegistros="";
		$idEstructura=$_POST["idEstructura"];			
		
		$listaIA="";
		$arrProgramasPresupuestarios=array();
		$consulta="SELECT idRegistro,cveProgramaPresupuestario,programaPresupuestario,idActividadInstitucional FROM 3214_programasPresupuestarios 
				WHERE idEstructura=".$idEstructura." ".$fPrograma." ORDER BY cveProgramaPresupuestario";
		$res5=$con->obtenerFilas($consulta);
		while($fila5=mysql_fetch_row($res5))
		{
			if(!isset($arrProgramasPresupuestarios[$fila5[3]]))
			{
				if($listaIA=="")
					$listaIA=$fila5[3];
				else
					$listaIA.=",".$fila5[3];
				$arrProgramasPresupuestarios[$fila5[3]]=array();
			}
			
			$oElemento["idRegistro"]=$fila5[0];
			$oElemento["cveRegistro"]=$fila5[1];
			$oElemento["denominacion"]=$fila5[2];
			$oElemento["arrHijos"]=array();
			$consulta="SELECT idRegistro,cveSubPrograma,subProgramaPresupuestario FROM 3215_subProgramasPresupuestarios 
					WHERE idProgramaPresupuestario=".$fila5[0]." ".$fSubPrograma." ORDER BY cveSubPrograma";

			$res6=$con->obtenerFilas($consulta);
			while($fila6=mysql_fetch_row($res6))
			{
				$oElemento2=array();
				$oElemento2["idRegistro"]=$fila6[0];
				$oElemento2["cveRegistro"]=$fila6[1];
				$oElemento2["denominacion"]=$fila6[2];
				
				array_push($oElemento["arrHijos"],$oElemento2);
			}
			

			array_push($arrProgramasPresupuestarios[$fila5[3]],$oElemento);
			
		}
		
		$listaSF="";
		$arrActividadesInstitucionales=array();
		$consulta="SELECT idRegistro,claveActividad,actividadInstitucional,idSubFuncion FROM 3211_actividadesInstitucionales 
				WHERE idRegistro IN(".$listaIA.") ".$fActividadInst." order by claveActividad";
		

		
		$res1=$con->obtenerFilas($consulta);
		while($fila1=mysql_fetch_row($res1))
		{
			if(!isset($arrActividadesInstitucionales[$fila1[3]]))
			{
				if($listaSF=="")
					$listaSF=$fila1[3];
				else
					$listaSF.=",".$fila1[3];
				$arrActividadesInstitucionales[$fila1[3]]=array();
			}
			$oElemento=array();
			$oElemento["idRegistro"]=$fila1[0];
			$oElemento["cveRegistro"]=$fila1[1];
			$oElemento["denominacion"]=$fila1[2];
			$oElemento["arrHijos"]=$arrProgramasPresupuestarios[$fila1[0]];
			array_push($arrActividadesInstitucionales[$fila1[3]],$oElemento);
		}
		
		$listaF="";
		$arrSubFunciones=array();
		$consulta="SELECT idRegistro,cveSubFuncion,subFuncion,idFuncion FROM 3209_subFunciones WHERE idRegistro IN(".$listaSF.")
			 ".$fSubFuncion." order by cveSubFuncion";
		$res1=$con->obtenerFilas($consulta);
		while($fila1=mysql_fetch_row($res1))
		{
			if(!isset($arrSubFunciones[$fila1[3]]))
			{
				if($listaF=="")
					$listaF=$fila1[3];
				else
					$listaF.=",".$fila1[3];
				$arrSubFunciones[$fila1[3]]=array();
			}
			$oElemento=array();
			$oElemento["idRegistro"]=$fila1[0];
			$oElemento["cveRegistro"]=$fila1[1];
			$oElemento["denominacion"]=$fila1[2];
			$oElemento["arrHijos"]=$arrActividadesInstitucionales[$fila1[0]];
			array_push($arrSubFunciones[$fila1[3]],$oElemento);
		}
		
		$listaFI="";
		$arrFunciones=array();
		$consulta="SELECT idRegistro,cveFuncion,funcion,idFinalidad FROM 3208_funciones WHERE idRegistro IN(".$listaF.
					")  ".$fFuncion." order by cveFuncion";
		$res1=$con->obtenerFilas($consulta);
		while($fila1=mysql_fetch_row($res1))
		{
			if(!isset($arrFunciones[$fila1[3]]))
			{
				if($listaFI=="")
					$listaFI=$fila1[3];
				else
					$listaFI.=",".$fila1[3];
				$arrFunciones[$fila1[3]]=array();
			}
			$oElemento=array();
			$oElemento["idRegistro"]=$fila1[0];
			$oElemento["cveRegistro"]=$fila1[1];
			$oElemento["denominacion"]=$fila1[2];
			$oElemento["arrHijos"]=$arrSubFunciones[$fila1[0]];
			array_push($arrFunciones[$fila1[3]],$oElemento);
		}
		

		$arrFinalidades=array();
		$consulta="select idRegistro,cveFinalidad,finalidad,".$idEstructura." FROM 3207_finalidades WHERE idRegistro IN(".$listaFI.
				")  ".$fFinalidad." order by cveFinalidad";
		$res1=$con->obtenerFilas($consulta);
		while($fila1=mysql_fetch_row($res1))
		{
			if(!isset($arrFinalidades[$fila1[3]]))
			{
				
				$arrFinalidades[$fila1[3]]=array();
			}
			$oElemento=array();
			$oElemento["idRegistro"]=$fila1[0];
			$oElemento["cveRegistro"]=$fila1[1];
			$oElemento["denominacion"]=$fila1[2];
			$oElemento["arrHijos"]=$arrFunciones[$fila1[0]];
			array_push($arrFinalidades[$fila1[3]],$oElemento);
		}
		$nivel=1;
		foreach($arrFinalidades as $idEstructura=>$resto)
		{
			$arrRegistros=aplanarEstructura($numReg,$resto,$nivel,"");
		}
		
		$consulta="SELECT idRegistro,CONCAT('[',cveProgramaPresupuestario,'] ',programaPresupuestario) AS leyenda 
				FROM 3214_programasPresupuestarios WHERE idEstructura=".$idEstructura." ORDER BY cveProgramaPresupuestario";
		$arrProgramasPresupuestarios=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT idRegistro,CONCAT('[',cveGrupoActividad,'] ',grupoActividad) AS leyenda 
				FROM 3210_grupoActividades WHERE idEstructura=".$idEstructura." ORDER BY cveGrupoActividad";
		$arrGrupoActividades=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT idRegistro,CONCAT('[',claveActividad,'] ',actividadInstitucional) AS leyenda 
				FROM 3211_actividadesInstitucionales WHERE idEstructura=".$idEstructura." ORDER BY claveActividad";
		$arrActividades=$con->obtenerFilasArreglo($consulta);
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"arrGrupoActividades":'.$arrGrupoActividades.
				',"arrProgramasPresupuestarios":'.$arrProgramasPresupuestarios.',"arrActividades":'.$arrActividades.'}';	
	}
	
	function aplanarEstructura(&$numReg,$arrObjRegistros,$nivel,$cabecera)
	{

		$arrNivel=array();
		$arrNivel[1]="finalidad";
		$arrNivel[2]="funcion";
		$arrNivel[3]="subfuncion";
		$arrNivel[4]="actividadInstitucional";
		$arrNivel[5]="programaPresupuestario";
		$arrNivel[6]="subProgramaPresupuestario";
		$oRegistro="";
		$arrRegistros="";
		$cadCabecera="";
		foreach($arrObjRegistros as $nodo)
		{


			$oRegistro='"idRegistroID":"'.$nodo["idRegistro"].'","tipoRegistro":"'.$nivel.'","idRegistro":"'.$nivel."_".$nodo["idRegistro"].'","'.
					$arrNivel[$nivel].'":"'.cv($nodo["cveRegistro"]).'","denominacion":"'.cv($nodo["denominacion"]).'"';
			for($pos=($nivel+1);$pos<=sizeof($arrNivel);$pos++)
			{
				$oRegistro.=',"'.$arrNivel[$pos].'":""';
			}
					
			$nodoFila=$cabecera;
			if($cabecera!="")
			{
				$nodoFila.=",".$oRegistro;	
				$cadCabecera=$cabecera.',"'.$arrNivel[$nivel].'":"'.cv($nodo["cveRegistro"]).'"';
			}
			else
			{
				$nodoFila=$oRegistro;	
				$cadCabecera='"'.$arrNivel[$nivel].'":"'.cv($nodo["cveRegistro"]).'"';
			}
			
			$nodoFila='{'.$nodoFila.'}'	;
			
			
			if(isset($nodo["arrHijos"])&&(sizeof($nodo["arrHijos"])>0))
			{
				$arrHijos=aplanarEstructura($numReg,$nodo["arrHijos"],$nivel+1,$cadCabecera);
				$nodoFila.=",".$arrHijos;
			}
			
			if($arrRegistros=="")
				$arrRegistros=$nodoFila;
			else
				$arrRegistros.=",".$nodoFila;
			$numReg++;			
		}
		
		return $arrRegistros;
		
		
	}
	
	
	function removerElementoEstructuraProgramatica()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		switch($obj->tipoElemento)
		{
			case 1:
				removerModalidad($obj->idElemento);
			break;
			case 2:
				removerTipo($obj->idElemento);
			break;
			case 3:
				removerProgramaPresupuestario($obj->idElemento);
			break;
		}
		
		echo "1|";
	}
	
	function removerProgramaPresupuestario($idElemento)
	{
		global $con;
		$consulta="DELETE FROM 3214_programasPresupuestarios WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function removerTipo($idElemento)
	{
		global $con;
		
		$consulta="SELECT idRegistro FROM 3214_programasPresupuestarios WHERE idTipoPrograma=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerProgramaPresupuestario($fila[0]);
		}
		
		$consulta="DELETE FROM 3213_tiposProgramasPresupuestarios WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function removerModalidad($idElemento)
	{
		global $con;
		
		$consulta="SELECT idRegistro FROM 3213_tiposProgramasPresupuestarios WHERE idModalidad=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			removerTipo($fila[0]);
		}
		
		$consulta="DELETE FROM 3212_modalidesProgramasPresupuestarios WHERE idRegistro=".$idElemento;
		return $con->ejecutarConsulta($consulta);
	}
	
	function registrarSubProgramaPresupuestario()
	{
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idSubProgramaPresupuestario==-1)
		{
			$consulta="INSERT INTO 3215_subProgramasPresupuestarios(cveSubPrograma,subProgramaPresupuestario,
						idEstructura,objetivoSubProgramaPresupuestario,idProgramaPresupuestario) VALUES('".cv($obj->clavePrograma).
						"','".cv($obj->programaPresupuestario)."',".$obj->idEstructura.",'".
						cv($obj->objetivoProgramaPresupuestario)."',".$obj->idProgramaPresupuestario.")";
		}
		else
		{
			$consulta="update 3215_subProgramasPresupuestarios set cveSubPrograma='".cv($obj->clavePrograma)."',subProgramaPresupuestario='".
						$obj->programaPresupuestario."',objetivoSubProgramaPresupuestario='".cv($obj->objetivoProgramaPresupuestario).
						"',idProgramaPresupuestario=".$obj->idProgramaPresupuestario." where idRegistro=".$obj->idSubProgramaPresupuestario;
		}
		
		eC($consulta);
	}
	
	
	function removerSubProgramaPresupuestario()
	{
		global $con;
		$idSubPrograma=$_POST["iP"];		
		$consulta="DELETE FROM 3215_subProgramasPresupuestarios WHERE idRegistro=".$idSubPrograma;
		eC($consulta);
		
	}
	
	function obtenerInfoSubprograma()
	{
		global $con;
		$idSubPrograma=$_POST["idSubPrograma"];
		$consulta="SELECT cveSubPrograma,subProgramaPresupuestario,objetivoSubProgramaPresupuestario,idProgramaPresupuestario 
				FROM 3215_subProgramasPresupuestarios WHERE idRegistro=".$idSubPrograma;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '1|'.$arrRegistros;

		
	}
	
	function obtenerProgramasObjetivosEstrategicos()
	{
		global $con;
		$idPlan=$_POST["idPlan"];
		$arrRegistros="";
		$consulta="
					select 0,'Todos los objetivos estratégicos'
					union
					(SELECT idRegistro,CONCAT(noObjetivo,'.- ',descripcionObjetivo) FROM 3201_objetivosEstrategicos WHERE idPlanInstitucional=".$idPlan.
				" ORDER BY noObjetivo)";	
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="
					select 0,'Todos los programas estratégicos'
					union
					(SELECT idRegistro,CONCAT(noProgramaEstrategico,'.- ',descripcionProgramaEstrategico) 
					FROM 3202_programasEstrategicos WHERE idObjetivoEstrategico=".$fila[0]." ORDER BY noProgramaEstrategico)";
			$arrProgramas=$con->obtenerFilasArreglo($consulta);
			$oR="['".$fila[0]."','".cv($fila[1])."',".$arrProgramas."]";
			if($arrRegistros=="")
				$arrRegistros=$oR;
			else
				$arrRegistros.=",".$oR;
		}
		
		$arrRegistros="[".$arrRegistros."]";
		echo "1|".$arrRegistros;
	}
	
	function registrarProblemaCentral()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3216_arbolPProblemaCentral(idFormulario,idReferencia,problemaCentral) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->problemaCentral)."')";
		}
		else
		{
			$consulta="update 3216_arbolPProblemaCentral set problemaCentral='".cv($obj->problemaCentral)."' where idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
	}
	
	function registrarEfecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3217_arbolPEfectos(idFormulario,idReferencia,efecto) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->efecto)."')";
		}
		else
		{
			$consulta="update 3217_arbolPEfectos set efecto='".cv($obj->efecto)."' where idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
	}
	
	function registrarCausa()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3218_arbolPCausas(idFormulario,idReferencia,causa) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->causa)."')";
		}
		else
		{
			$consulta="update 3218_arbolPCausas set causa='".cv($obj->causa)."' where idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
	}
	
	function removerElementoArbolProblemas()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		switch($obj->tipo)
		{
			case 'C':
				$consulta='DELETE FROM 3218_arbolPCausas WHERE idRegistro='.$obj->idRegistro;
			break;
			case 'E':
				$consulta='DELETE FROM 3217_arbolPEfectos WHERE idRegistro='.$obj->idRegistro;
			break;
			case 'P':
				$consulta='DELETE FROM 3216_arbolPProblemaCentral WHERE idRegistro='.$obj->idRegistro;
			break;
			
		}
		eC($consulta);
	}
	
	function registrarObjetivoCentral()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 3219_arbolOObjetivoCentral(idFormulario,idReferencia,objetivoCentral) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->objetivoCentral)."')";
		}
		else
		{
			$consulta="update 3219_arbolOObjetivoCentral set objetivoCentral='".cv($obj->objetivoCentral)."' where idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
	}
	
	function registrarFin()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		$noFin="";
		
		if($obj->idRegistro==-1)
		{
			$consulta="select max(noOrden) from 3220_arbolOFines where idFormulario=".$obj->iFormulario." and idReferencia=".$obj->iRegistro;
			$noOrden=$con->obtenerValor($consulta);
			if($noOrden=="")
			{
				$noOrden=1;
			}
			else
				$noOrden++;
				
			$consulta="INSERT INTO 3220_arbolOFines(idFormulario,idReferencia,fin,noOrden) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->fin)."',".$noOrden.")";
		}
		else
		{
			$consulta="update 3220_arbolOFines set fin='".cv($obj->fin)."' where idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
	}
	
	function registrarMedio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
			$query="select max(noOrden) from 3220_arbolOFines where idFormulario=".$obj->iFormulario." and idReferencia=".$obj->iRegistro;
			$noOrden=$con->obtenerValor($query);
			if($noOrden=="")
			{
				$noOrden=1;
			}
			else
				$noOrden++;
				
			$consulta[$x]="INSERT INTO 3221_arbolOMedios(idFormulario,idReferencia,medio,noOrden) 
						VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".cv($obj->medio)."',".$noOrden.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;	
		}
		else
		{
			$consulta[$x]="update 3221_arbolOMedios set medio='".cv($obj->medio)."' where idRegistro=".$obj->idRegistro;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		$listaActividades="";
		foreach($obj->arrActividades as $a)
		{
			if($a->idActividad!=-1)
			{
				if($listaActividades=="")
					$listaActividades=$a->idActividad;
				else
					$listaActividades.=",".$a->idActividad;
			}
		}
		
		if($listaActividades=="")
			$listaActividades=-1;
		$consulta[$x]="delete from 3222_actividadesMedios where idMedio=@idRegistro and idRegistro not in(".$listaActividades.")";
		$x++;
		
		foreach($obj->arrActividades as $a)
		{
			if($a->idActividad==-1)
			{
				$consulta[$x]="INSERT INTO 3222_actividadesMedios(idMedio,actividad) VALUES(@idRegistro,'".cv($a->actividad)."')";
				$x++;
				
			}
			else
			{
				$consulta[$x]="update 3222_actividadesMedios set actividad='".cv($a->actividad)."' where idRegistro=@idRegistro";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerElementoArbolObjetivos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		switch($obj->tipo)
		{
			case 'F':
				ajustarContadorObjetos($obj->tipo,$obj->idRegistro);
				$consulta='DELETE FROM 3220_arbolOFines WHERE idRegistro='.$obj->idRegistro;
			break;
			case 'M':
				ajustarContadorObjetos($obj->tipo,$obj->idRegistro);
				$consulta='DELETE FROM 3221_arbolOMedios WHERE idRegistro='.$obj->idRegistro;
			break;
			case 'O':
				$consulta='DELETE FROM 3219_arbolOObjetivoCentral WHERE idRegistro='.$obj->idRegistro;
			break;
			
		}
		if($con->ejecutarConsulta($consulta))
		{
			
			echo "1|";
		}
	}
	
	function ajustarContadorObjetos($tipo,$idRegistro)
	{
		global $con;
		if($tipo=="O")
			return true;
			
		switch($tipo)
		{
			case 'F':
				$tabla='3220_arbolOFines';
			break;
			case 'M':
				$consulta='3221_arbolOMedios';
			break;
		}
		
		$nContador=1;
		$consulta="SELECT idFormulario,idReferencia FROM ".$tabla." WHERE idRegistro=".$idRegistro;

		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idRegistro FROM ".$tabla." WHERE idFormulario=".$fRegistro[0]." and idReferencia=".$fRegistro[1].
				" and idRegistro<>".$idRegistro." order by noOrden";
				

		$res=$con->obtenerFilas($consulta);
		while($f=mysql_fetch_row($res))
		{
			$consulta="update ".$tabla." set noOrden=".$nContador." where idRegistro=".$f[0];
			$con->ejecutarConsulta($consulta);
			$nContador++;
		}
		
	}
	
	function obtenerActividadesMedios()
	{
		global $con;
		$idMedio=$_POST["idMedio"];
		$consulta="SELECT idRegistro as idActividad,actividad FROM 3222_actividadesMedios WHERE idMedio=".$idMedio;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
		
	}
	
	function obtenerCentrosGestoresConvocatoria()
	{
		global $con;
		$idConvocatoria=$_POST["idConvocatoria"];
		
		$consulta="SELECT id__539_tablaDinamica AS idRegistro,c.codigoInstitucion AS centroGestor,idEstado FROM _539_tablaDinamica c,817_organigrama o
				 WHERE idProcesoPadre=223 AND idReferencia=".$idConvocatoria." AND o.codigoUnidad=c.codigoInstitucion ORDER BY o.unidad";		                                                
		$arrCentrosGestores=utf8_encode($con->obtenerFilasJSON($consulta));				 
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrCentrosGestores.'}';

	}
	
	function obtenerObjetivosProgramaEstrategico()
	{
		global $con;

		$idPrograma=$_POST["idPrograma"];
		
		$consulta="SELECT idRegistro as idObjetivo,CONCAT(noObjetivoEspecifico,'.- ',descripcionObjetivoEspecifico) as nombreObjetivo 
				FROM 3203_objetivosEspecificos o WHERE idProgramaEstrategico=".$idPrograma."
				order by noObjetivoEspecifico";		                                                
		$arrObjetivos=utf8_encode($con->obtenerFilasJSON($consulta));				 
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrObjetivos.'}';
	}
	
	function obtenerPartidaPresupuestaria()
	{
		global $con;
		$idClasificadorObjetoGasto=$_POST["idClasificadorObjetoGasto"];
		$noPartida=$_POST["valor"];
		$consulta="";
		$ultimoDigito=substr($noPartida,-1);
		if($ultimoDigito==0)
		{
			$consulta="SELECT nombrePartidaGenerica FROM 3503_clasificadoresObjetosGastoPartidasGenericas 
						WHERE idClasificadorObjetoGasto=".$idClasificadorObjetoGasto."
						AND noPartidaGenerica='".$noPartida."'";
		}
		else
		{
			$consulta="SELECT nombrePartidaEspecifica FROM 3504_clasificadoresObjetosGastoPartidasEspecificas 
						WHERE idClasificadorObjetoGasto=".$idClasificadorObjetoGasto."
						AND noPartidaEspecifica='".$noPartida."'";
		}
		$nombrePartida=$con->obtenerValor($consulta);
		
		if($nombrePartida=="")
		{
			echo "1|0";
			return;
		}
		
		$capitulo=str_pad(substr($noPartida,0,1),4,"0",STR_PAD_RIGHT);
		
		$consulta="SELECT idRegistro FROM 3501_clasificadoresObjetosGastoCapitulos WHERE 
				idClasificadorObjetoGasto=".$idClasificadorObjetoGasto." AND noCapitulo='".$capitulo."'";
		
		$idCapitulo=$con->obtenerValor($consulta);
		echo "1|1|".$nombrePartida."|".$idCapitulo;
		
	}
	
	function obtenerInformacionArbolProblemas()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];	
		
		$consulta="SELECT idRegistro,causa FROM 3218_arbolPCausas WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro."";
		$arrCausas=$con->obtenerFilasArreglo($consulta);	

			
		$consulta="SELECT idRegistro,efecto FROM 3217_arbolPEfectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$arrEfectos=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT id__546_tablaDinamica,problemaPrincipal FROM _546_tablaDinamica WHERE  idReferencia=".$idRegistro;
		$arrProblema=$con->obtenerFilasArreglo($consulta);
		
		echo '1|{"arrCausas":'.$arrCausas.',"arrEfectos":'.$arrEfectos.',"arrProblema":'.$arrProblema.'}';
	}
	
	function obtenerInformacionArbolObjetivos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];	
		
		$nMedios=0;
		$arrMedios="";
		$consulta="SELECT idRegistro,medio FROM 3221_arbolOMedios WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro."";
		$rMedios=$con->obtenerFilas($consulta);
		while($fMedio=mysql_fetch_row($rMedios))
		{
			$consulta="SELECT idRegistro,actividad FROM 3222_actividadesMedios WHERE idMedio=".$fMedio[0];
			$arrActividades=$con->obtenerFilasArreglo($consulta);
			$oMedio="['".$fMedio[0]."','".cv($fMedio[1])."',".$arrActividades."]";
			if($arrMedios=="")
				$arrMedios=$oMedio;
			else
				$arrMedios.=",".$oMedio;
			$nMedios++;
		}
		
		$arrMedios="[".$arrMedios."]";
		
		
			
		$consulta="SELECT idRegistro,fin FROM 3220_arbolOFines WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$arrFines=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT idRegistro,objetivoCentral FROM 3219_arbolOObjetivoCentral WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$arrObjetivo=$con->obtenerFilasArreglo($consulta);
		
		echo '1|{"arrMedios":'.$arrMedios.',"arrFines":'.$arrFines.',"arrObjetivo":'.$arrObjetivo.'}';
	}
	
	function funcionesPlaneacionEstrategica()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idRegistro FROM _572_registroCumplimientoIndicadores WHERE idReferencia=".$obj->idRegistro.
					" and idIndicador=".$obj->idIndicador." and mesValor=".$obj->mesValor." AND tipoValor=".$obj->tipoValor;
		$idRegistro=$con->obtenerValor($consulta);	
		
		if($idRegistro=="")
		{
			$consulta="INSERT INTO _572_registroCumplimientoIndicadores(idReferencia,idIndicador,mesValor,tipoValor,valor,calculado)
					VALUES(".$obj->idRegistro.",".$obj->idIndicador.",".$obj->mesValor.",".$obj->tipoValor.",".$obj->valor.",".$obj->calculado.")";
		}
		else
		{
			$consulta="UPDATE _572_registroCumplimientoIndicadores SET valor=".$obj->valor." WHERE idRegistro=".$idRegistro;
		}
		
		eC($consulta);
	}
	
	function obtenerInformesResultadosIndicadores()
	{
		global $con;
		
		
		$idConvocatoria=$_POST["idConvocatoria"];
		$periodicidad=$_POST["periodicidad"];
		$noPeriodo=$_POST["noPeriodo"];
		
		$consulta="SELECT id__539_tablaDinamica FROM _539_tablaDinamica WHERE idProcesoPadre=223 AND idReferencia=".$idConvocatoria;
		$listaMarcosTeoricos=$con->obtenerListaValores($consulta);
		
		if($listaMarcosTeoricos=="")
			$listaMarcosTeoricos=-1;
		
		$arrRegistros="";
		$consulta="SELECT fr.*  FROM _572_tablaDinamica fr,539_calendarioReportesIndicadores c
				WHERE c.idReferencia IN(".$listaMarcosTeoricos.") AND c.idRegistro=fr.idRegistroCalendario 
				AND c.periodicidad=".$periodicidad." and fr.periodoReporte= ".$noPeriodo;
		
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_assoc($res))
		{
			$diasRegistro="";
			$fechaTermino="";
			
			$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=572 AND idRegistro=".$fila["id__572_tablaDinamica"].
					" and etapaActual=2 order by fechaCambio desc";
			$fechaTermino=$con->obtenerValor($consulta);
			if($fechaTermino!="")
				$diasRegistro=obtenerDiferenciaDias($fechaTermino,$fila["fechaCreacion"]);
			$o='{"departamento":"'.$fila["codigoInstitucion"].'","responsable":"'.cv(obtenerNombreUsuario($fila["idUsuarioDestinatario"])).
				'","fechaInicio":"'.$fila["fechaCreacion"].'","fechaTermino":"'.$fechaTermino.'","diasRegistro":"'.$diasRegistro.'","idEstado":"'.
				$fila["idEstado"].'","idRegistro":"'.$fila["id__572_tablaDinamica"].'"}';														
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;	
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function obtenerIndicadoresAdministracionArea()
	{
		global $con;
		$cveArea=$_POST["cveArea"];
		
		$arrRegistros="";
		$consulta="SELECT id__550_tablaDinamica,nombreIndicador,objetivo AS objetivoIndicador,funcionCalculo,frecuenciaMedicion
				  FROM _550_tablaDinamica i,_539_tablaDinamica fb WHERE idIndicadorBase=-1
				AND i.idReferencia=fb.id__539_tablaDinamica and fb.codigoInstitucion='".$cveArea."'";
		
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$lblFuncionCalculo="";
			if($fila[3]!=-1)
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[3];
				$lblFuncionCalculo=$con->obtenerValor($consulta);
			}
			
			$consulta="SELECT DISTINCT ejercicioFiscal FROM _539_tablaDinamica fb,_550_tablaDinamica i WHERE i.idReferencia=fb.id__539_tablaDinamica
					AND (i.id__550_tablaDinamica=".$fila[0]." OR i.idIndicadorBase=".$fila[0].") ORDER BY ejercicioFiscal";
			$ciclosUso=$con->obtenerListaValores($consulta);
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","objetivoIndicador":"'.$fila[2].
				'","ciclosUso":"'.$ciclosUso.'","funcionCalculo":"'.$fila[3].'","lblFuncionCalculo":"'.cv($lblFuncionCalculo).'","frecuenciaMedicion":"'.$fila[4].'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function asignarFuncionCalculoIndicador()
	{
		global $con;
		$idIndicador=$_POST["idIndicador"];
		$idFuncion=$_POST["idFuncion"];
		$consulta="UPDATE _550_tablaDinamica SET funcionCalculo=".$idFuncion." WHERE id__550_tablaDinamica=".$idIndicador." OR idIndicadorBase=".$idIndicador;
		eC($consulta);
		
		
	}
	
	function importarIndicador()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT id__550_tablaDinamica,codigoInstitucion,nombreIndicador,nivelMIR,objetivo,tipoIndicador,dimension,
				metodoCalculo,unidadMedida,frecuenciaMedicion,valorMeta,comportamiento,idProcesoPadre,idIndicadorBase,
				funcionCalculo FROM _550_tablaDinamica WHERE id__550_tablaDinamica IN(".$obj->listaIndicadores.")";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$consulta="SELECT COUNT(*) FROM _550_tablaDinamica WHERE idProcesoPadre=".$fila["idProcesoPadre"]." AND idReferencia=".$obj->idRegistro.
					" AND (id__550_tablaDinamica=".$fila["id__550_tablaDinamica"]." OR idIndicadorBase=".$fila["id__550_tablaDinamica"].")";
			$nRegistros=$con->obtenerValor($consulta);
			
			
			/*if($nRegistros>0)
				continue;*/
			
			$arrValores=array();
			$arrDocumentos=array();		
			$arrValores["codigoInstitucion"]=$fila["codigoInstitucion"];
			$arrValores["nombreIndicador"]=$fila["nombreIndicador"];
			$arrValores["nivelMIR"]=$fila["nivelMIR"];
			$arrValores["objetivo"]=$fila["objetivo"];
			$arrValores["tipoIndicador"]=$fila["tipoIndicador"];
			$arrValores["dimension"]=$fila["dimension"];
			$arrValores["metodoCalculo"]=$fila["metodoCalculo"];
			$arrValores["unidadMedida"]=$fila["unidadMedida"];
			$arrValores["frecuenciaMedicion"]=$fila["frecuenciaMedicion"];
			$arrValores["valorMeta"]=$fila["valorMeta"];
			$arrValores["comportamiento"]=$fila["comportamiento"];
			$arrValores["idProcesoPadre"]=$fila["idProcesoPadre"];
			$arrValores["idIndicadorBase"]=$fila["id__550_tablaDinamica"];
			$arrValores["funcionCalculo"]=$fila["funcionCalculo"];
			$idIndicador=crearInstanciaRegistroFormulario(550,$obj->idRegistro,1,$arrValores,$arrDocumentos,-1,960);
			
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="INSERT INTO _550_gSupuestos(idReferencia,supuestoIndicador)
						SELECT '".$idIndicador."',supuestoIndicador FROM _550_gSupuestos WHERE idReferencia=".$fila["id__550_tablaDinamica"];
			$x++;
			$query[$x]="INSERT INTO _550_gMedioVerificacion(idReferencia,medioVerificacion)
						SELECT '".$idIndicador."',medioVerificacion FROM _550_gMedioVerificacion WHERE idReferencia=".$fila["id__550_tablaDinamica"];
			$x++;
			$query[$x]="INSERT INTO _550_gCaracteristicasVariables(idReferencia,nombreVariable,descripcion,mediosVerificacion,unidadMedida)
						SELECT '".$idIndicador."',nombreVariable,descripcion,mediosVerificacion,unidadMedida FROM _550_gCaracteristicasVariables 
						WHERE idReferencia=".$fila["id__550_tablaDinamica"];
			$x++;
			
			$query[$x]="INSERT INTO _571_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion,
						observacionesLineaBase,nombreResponsable,observacionesMetas)
						SELECT  '".$idIndicador."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,codigoInstitucion,observacionesLineaBase,nombreResponsable,observacionesMetas 
						FROM _571_tablaDinamica WHERE idReferencia=".$fila["id__550_tablaDinamica"];
			$x++;
			
			$query[$x]="set @iRegistroMedicion=(select last_insert_id())";
			$x++;
			$consulta="SELECT id__571_tablaDinamica FROM _571_tablaDinamica WHERE idReferencia=".$fila["id__550_tablaDinamica"];
			$iRegistroMedicion=$con->obtenerValor($consulta);
			
			$query[$x]="INSERT INTO _571_gridSemaforizacion(idReferencia,vAbsoluto,vPorcentaje,aAbsoluto,aPorcentaje,rAbsoluto,rPorcentaje)
					SELECT @iRegistroMedicion,vAbsoluto,vPorcentaje,aAbsoluto,aPorcentaje,rAbsoluto,rAbsoluto 
					FROM _571_gridSemaforizacion WHERE idReferencia=".$iRegistroMedicion;
			$x++;
		
						
			

			
			
			$query[$x]="commit";
			$x++;
			
			$con->ejecutarBloque($query);
			
			
		}
		
		
		echo "1|";
		
		
	}
	
	
	function obtenerIndicadoresAreaInforme()
	{
		global $con;
		$cveArea=$_POST["cveArea"];
		
		$arrRegistros="";
		$consulta="SELECT id__550_tablaDinamica,nombreIndicador,frecuenciaMedicion
				  FROM _550_tablaDinamica i,_539_tablaDinamica fb WHERE idIndicadorBase=-1
				AND i.idReferencia=fb.id__539_tablaDinamica and fb.codigoInstitucion='".$cveArea."'";
		
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT DISTINCT ejercicioFiscal,ejercicioFiscal FROM _539_tablaDinamica fb,_550_tablaDinamica i WHERE i.idReferencia=fb.id__539_tablaDinamica
					AND (i.id__550_tablaDinamica=".$fila[0]." OR i.idIndicadorBase=".$fila[0].") ORDER BY ejercicioFiscal";
			
			$arrCiclos=$con->obtenerFilasArreglo($consulta);
			
			$arrCiclos="[['2017','2017'],['2018','2018'],['2019','2019']]";
			
			$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."',".$arrCiclos."]";
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			
		}
		echo '1|['.$arrRegistros.']';
	}
?>