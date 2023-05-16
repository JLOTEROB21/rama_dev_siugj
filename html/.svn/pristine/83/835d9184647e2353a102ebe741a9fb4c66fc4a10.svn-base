<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include("funcionesClonacionReportesThot.php");
	include("funcionesActores.php");
	include_once("funcionesPortal.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerGruposProfesor();
			break;
			case 2:
				obtenerSesionesGrupos();
			break;
			case 3:
				obtenerValoresDatosRegistroFormulario();
			break;
			case 4:
				obtenerFechaPermitidaSuplencia();
			break;
			case 5:
				obtenerAlumnosGruposCambioEvaluacion();
			break;
			case 6:
				guardarCalificacionAlumnoBloqueCambioEvaluacion();
			break;
			case 7:
				modificarValorLimiteMaximoCambioEvaluacion();
			break;
			case 8:
				obtenerSituacionCurso();
			break;
			case 9:
				obtenerSituacionInscripcion();
			break;
			case 10:
				obtenerDocumentosInscripcion();
			break;
			case 11:
				registrarSituacionDocumentoInscripcion();
			break;
			case 12:
				finalizarEvaluacionDocumentos();
			break;
			case 13:
				obtenerAdeudosBaja();
			break;
			case 14:
				obtenerDocumentosEntrega();
			break;
			case 15:
				registrarInscripcionCurso();	
			break;
			case 16:
				obtenerDatosAlumno();
			break;
			case 17:
				obtenerSituacionTramites();
			break;
			case 18:
				obtenerVacantesPorEmpresa();
			break;
			case 19:
				obtenerVacantesPorCategoria();
			break;
			case 20:
				obtenerFormatoBoletin();
			break;
			case 21:
				removerArticuloBoletin();
			break;
			case 22:
				obtenerArticulosDisponibles();
			break;
			case 23:
				registrarArticulosBoletin();
			break;
			case 24:
				obtenerPublicacionesBoletin();
			break;
			case 25:
				obtenerDatosDictamenSocioEconomico();
			break;
			case 26:
				obtenerCondicionesBeca();
			break;
			case 27:
				generarCFDINominaPrimaria();
			break;
			case 28:
				reGenerarCFDINominaPrimaria();
			break;
			case 29:
				registrarBolsaTrabajoUsuario();
			break;
			case 30:
				registrarBoletinUsuario();
			break;
			case 31:
				registrarEnvioEtapaReinscripcion();
			break;
			case 32:
				bloquearEmpleadoNominaPrimaria();
			break;
			case 33:
				verificarSituacionJustificacionFalta();
			break;
			case 34:
				obtenerConvocatoriasHorarioDisponible();
			break;
			case 35:
				registrarParticipacionConvocatoriaDiponibilidadHorario();
			break;
			case 36:
				obtenerPeriodosConvocatoriaDH();
			break;
			case 37:
				obtenerListadoHorarioDisponibilidad();
			break;
			case 38:
				modificarHorarioDisponibilidad();
			break;
			case 39:
				obtenerConvocatoriasDisponibilidadActivas();
			break;
			case 40:
				liberarDiponibilidadHorario();
			break;
			case 41:
				marcarNODisponibilidadHorario();
			break;
			case 42:
				removerMarcaNODisponibilidadHorario();
			break;
			case 43:
				clonarDisponibilidadHorarioPeriodo();
			break;
			case 44:
				obtenerMateriasPeriodosConvocatoriaDH();
			break;
			case 45:
				registrarMateriasInteresProfesor();
			break;
			case 46:
				removerMateriasInteresProfesor();
			break;
			case 47:
				obtenerconvocatoriosDisponibilidadHorarioDisponibles();
			break;
			case 48:
				obtenerPeriodosDisponibilidadHorarioDisponibles();
			break;
			case 49:
				registrarConvocatoriaDisponibilidad();
			break;
			case 50:
				aperturarConvocatoriaDisponibilidad();
			break;
			case 51:
				obtenerConfiguracionAperturaGradosPeriodo();
			break;
			case 52:
				registrarConfiguracionGradoPeriodo();
			break;
			case 53:
				obtenerMateriasDisponiblesInteres();
			break;
			case 54:
				registrarMateriasInteresConvocatoria();
			break;
			case 55:
				removerMateriasInteresConvocatoria();
			break;
			case 56:
				obtenerMateriasInteresConvocatoria();
			break;
			case 57:
				registrarAceptacionCondiciones();
			break;
			case 58:
				obtenerListadoDisponibilidadHorario();
			break;
			case 59:
				obtenerSesionesVirtuales();
			break;
			case 60:
				registrarSesionesVirtuales();
			break;
			case 61:
				registrarSituacionDocumentoInscripcionV2();
			break;
		}
	}
	
	function obtenerGruposProfesor()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$plantel=$_SESSION["codigoInstitucion"];
		$fecha=$_POST["fecha"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idGrupos,nombreGrupo FROM 4520_grupos g,4519_asignacionProfesorGrupo a WHERE g.idGrupos=a.idGrupo AND a.idUsuario=".$idUsuario." AND g.Plantel='".$plantel."' AND '".$fecha."'>=a.fechaAsignacion AND '".$fecha."'<=fechaBaja";
		$arrGrupos=$con->obtenerFilasArreglo($consulta);
		$idGrupoSel=-1;
		if($idRegistro!=-1)
		{
			$consulta="SELECT cmbGrupos FROM _498_tablaDinamica WHERE id__498_tablaDinamica=".$idRegistro;
			$idGrupoSel=$con->obtenerValor($consulta);
		}
		
		echo "1|".$arrGrupos."|".$idGrupoSel;
		
	}
	
	function obtenerSesionesGrupos()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$fecha=$_POST["fecha"];
		$idGrupoSel=-1;
		$idRegistro=$_POST["idRegistro"];
		if($idRegistro!=-1)
		{
			$consulta="SELECT cmbFechaSesion FROM _498_tablaDinamica WHERE id__498_tablaDinamica=".$idRegistro;
			$idGrupoSel=$con->obtenerValor($consulta);
		}
		$consulta="SELECT idSesion,horario FROM 4530_sesiones WHERE idGrupo=".$idGrupo." AND fechaSesion='".$fecha."'";
		$arrGrupos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrGrupos."|".$idGrupoSel;
		
	}
	
	function obtenerValoresDatosRegistroFormulario()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$campos=bD($_POST["campos"]);
		$consulta="select ".$campos." FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$arrCampos=explode(",",$campos);
		$cadObj='';
		foreach($arrCampos as $c)
		{
			$valor="";
			if(isset($fRegistro[$c]))
				$valor=cv($fRegistro[$c]);
			if($cadObj=="")
				$cadObj='"'.$c.'":"'.$valor.'"';
			else
				$cadObj.=',"'.$c.'":"'.$valor.'"';
		}
		$cadObj='{'.$cadObj.'}';
		echo "1|".$cadObj;
		
	}
	
	function obtenerFechaPermitidaSuplencia()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$consulta="select max(fechaBaja) from 4519_asignacionProfesorGrupo where idGrupo=".$idGrupo." and idParticipacion=45";
		$fBaja=$con->obtenerValor($consulta);
		if($fBaja!="")
		{
			$fBaja=date("Y-m-d",strtotime("+1 days",strtotime($fBaja)));
		}
		echo "1|".$fBaja;
		
	}	
	
	function obtenerAlumnosGruposCambioEvaluacion()
	{
		global $con;
		$bloque=0;
		$idGrupo=$_POST["idGrupo"];
		$tipoEvaluacion=$_POST["tipoEvaluacion"];
		$noEvaluacion=$_POST["noEvaluacion"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$criterios=bD($_POST["criterio"]);
		$fConfiguracion=obtenerPerfilExamenGrupo($idGrupo,$tipoEvaluacion);
		$objCriterio=json_decode($criterios);

		$cadCriterios="";
		$tamCriterios=sizeof($objCriterio->criterios)-3;
		
		$arrConfiguracionCriterio=array();
		for($x=2;$x<$tamCriterios;$x++)
		{
			$criterios=$objCriterio->criterios[$x]->name;
			$arrDatos=explode("_",$criterios);
			if($arrDatos[0]=="porcentaje")
			{
				if($cadCriterios=="")
					$cadCriterios="'".$arrDatos[1]."'";
				else
					$cadCriterios.=",'".$arrDatos[1]."'";
				$consulta="SELECT idTipoEvaluacion,funcionEvaluacion,funcionSistemaValMax,formaValorMaximoCriterio,valorMaximo,idEscalaCalificacion,idEvaluacion FROM 4010_evaluaciones e,
						4564_criteriosEvaluacionPerfilMateria c WHERE e.idEvaluacion= c.idCriterio AND c.codigoUnidad='".$arrDatos[1]."'";
				$arrConfiguracionCriterio[$arrDatos[1]]=$con->obtenerPrimeraFila($consulta);
				
			}
		}
		
		if($cadCriterios=="")
			$cadCriterios=-1;
			
		//$consulta="SELECT situacion FROM 4593_situacionEvaluacionCurso WHERE idGrupo=".$idGrupo." AND tipoExamen=".$tipoEvaluacion." AND noExamen=".$noEvaluacion;	
		//$situacionEvaluacion=$con->obtenerValor($consulta);
		$situacionEvaluacion=1;
		$listUsuario="";
		$cache=NULL;
		if($fConfiguracion[18]!="")
		{
			$cTmp='{"idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
			$objTmp=json_decode($cTmp);
			
			$arrUsrFinal=array();
			$arrUsr=resolverExpresionCalculoPHP($fConfiguracion[18],$objTmp,$cache);
			
			if(sizeof($arrUsr)>0)
			{
				foreach($arrUsr as $u)
				{
					if($listUsuario=="")
						$listUsuario=$u["idUsuario"];
					else
						$listUsuario.=','.$u["idUsuario"];
				}
			}
		}
		if($listUsuario=="")
			$listUsuario=-1;
		$consulta="SELECT i.idUsuario,upper(CONCAT(Paterno,' ',Materno,' ',Nom)) AS nombre,a.idGrupo,a.idGrupoOrigen FROM 802_identifica i,4517_alumnosVsMateriaGrupo a
				WHERE  i.idUsuario in (".$listUsuario.") and a.idUsuario=i.idUsuario AND a.idGrupo=".$idGrupo." and situacion=1 ORDER BY Paterno,Materno,Nom";
		$res=$con->obtenerFilas($consulta);

		$cadRegistros="";
		$nReg=0;
		$posRegistro=0;
		while($fila=mysql_fetch_row($res))
		{
			$posRegistro++;
			$nReg++;
			$dAlumno="";
			$recalcular=false;
			$idGrupoOrigen=$fila[2];
			if($fila[3]!="")
			{
				$idGrupoOrigen=$fila[3];
			}
			$dAlumno=obtenerOrigenGrupoAlumno($idGrupoOrigen);
			$obj='{"registraCalificacion":"@registraCalificacion","comentarios":"@comentarios","idUsuario":"'.$fila[0].'","alumno":"'.cv($fila[1]).'","dAlumno":"'.$dAlumno.'","idGrupoOrigen":"'.$idGrupoOrigen.'"';	
			$arrCalificaciones=array();
			$consulta="SELECT * FROM 4594_calificacionesCriteriosAlumnoCambioEvaluacion WHERE idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND idCriterio in (".$cadCriterios.") 
						AND tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion." and bloque=0";
			$resCal=$con->obtenerFilas($consulta);
			while($fCal=mysql_fetch_row($resCal))
			{
				$arrCalificaciones["c_".$fCal[3]]=$fCal[13];
				$arrCalificaciones["porcentaje_".$fCal[3]]=$fCal[14];
				$arrCalificaciones["tConsidera_".$fCal[3]]=$fCal[16];
				$arrCalificaciones["cO_".$fCal[3]]=$fCal[5];
				$arrCalificaciones["porcentajeO_".$fCal[3]]=$fCal[6];
				$arrCalificaciones["tConsideraO_".$fCal[3]]=$fCal[8];
			}
			
			for($x=4;$x<$tamCriterios;$x++)
			{
				$valor=0;
				
				$arrDatos=explode("_",$objCriterio->criterios[$x]->name);
				$confCriterio=$arrConfiguracionCriterio[$arrDatos[1]];
				switch($arrDatos[0])
				{
					case "porcentaje":
						if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
					break;
					case "c":
						if($situacionEvaluacion!=2)
						{
							switch($confCriterio[0])
							{
								case "1": //Manual
									if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
										$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
								break;
								case "2": //Automatico
									$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
									$objTmp=json_decode($cadObj);
									
									$valor=resolverExpresionCalculoPHP($confCriterio[1],$objTmp,$cache);
									if(!is_numeric($valor))
										$valor=0;
									$valorAux=0;
									if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
									{
										$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
									}
									
									if($valor!=$valorAux)
									{
										
										$recalcular=true;
										recalcularCalificacionesGrupoCambioEvaluacion($idGrupo,$arrDatos[1],$bloque,$tipoEvaluacion,$noEvaluacion,$idFormulario,$idRegistro,$fila[0]);
									}
								break;
							}
						}
						else
						{
							$valor=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							}
						}
					break;
					case "tConsidera":
						if($situacionEvaluacion!=2)
						{
							$consulta="SELECT valMaxCambio FROM 4596_valoresMaximosCriterioCambioEvaluacion WHERE idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and 
										idGrupo=".$idGrupo." AND noBloque=0 AND idCriterio='".$arrDatos[1]."' and tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;

							$fCriterio=$con->obtenerPrimeraFila($consulta);
							if(!$fCriterio)
							{
								switch($confCriterio[3])
								{
									case "1": //Valor máximo de escala de evaluación
										$consulta="SELECT max(valorMaximo) FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$confCriterio[5];
										$valor=$con->obtenerValor($consulta);
									break;
									case "2": //Valor constante
										$valor=$confCriterio[4];
									break;
									case "3"://Automático (Mediante función de sistema)
										
										$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
										$objTmp=json_decode($cadObj);
										$valor=resolverExpresionCalculoPHP($confCriterio[2],$objTmp,$cache);
									break;
								}
							}
							else
								$valor=$fCriterio[0];
							
							
							
							if(!is_numeric($valor))
								$valor=0;
							$valorAux=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
								
							}	
							if($valor!=$valorAux)
							{

								$recalcular=true;
								recalcularCalificacionesGrupoCambioEvaluacion($idGrupo,$arrDatos[1],$bloque,$tipoEvaluacion,$noEvaluacion,$idFormulario,$idRegistro,$fila[0]);
							}
						}
						else
						{
							$valor=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							}
						}
					break;
				}

				if($valor=="")
					$valor=0;

				$obj.=',"'.$objCriterio->criterios[$x]->name.'":"'.removerCerosDerecha($valor).'"';
			}
			$consulta="SELECT valorCambio FROM 4595_calificacionesEvaluacionAlumnoCambioEvaluacion WHERE idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bloque=0 and tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;
			$valor=$con->obtenerValor($consulta);
			if($valor=="")
				$valor=0;
			
			$totalEval=removerCerosDerecha($valor);	

			$obj.=',"total":"@total"}';
			if(!$recalcular)
			{
				
				$registraCalificacion=1;
				$comentarios="";
				
				
				if(($fConfiguracion[20]!="")&&($fConfiguracion[20]!="-1"))
				{
					
					$cTmp='{"idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'","objUsr":null}';
					$objTmp=json_decode($cTmp);
					$objTmp->objUsr=json_decode($obj);
					$oResp=resolverExpresionCalculoPHP($fConfiguracion[20],$objTmp,$cache);	
					
					if(gettype($oResp)=="array")
					{
						$registraCalificacion=$oResp["registraCalificacion"];
						if(isset($oResp["comentarios"]))
							$comentarios=$oResp["comentarios"];
						if(isset($oResp["totalEvaluacion"]))
						{
							$totalEval=$oResp["totalEvaluacion"];
							
							if($totalEval<0)
							{
								$consulta="update 4569_calificacionesEvaluacionAlumnoPerfilMateria  set valor=".$totalEval." WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bloque=0 and tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;
								$con->ejecutarConsulta($consulta);
							}	
							/*if($totalEval<0)
								$registraCalificacion=0;*/
						}
						
							
					}
					else
					{
						$registraCalificacion=removerComillasLimite($oResp);
						
					}
					
				}
				
				
				
				$obj=str_replace("@registraCalificacion",$registraCalificacion,$obj);
				$obj=str_replace("@comentarios",$comentarios,$obj);
				$obj=str_replace("@total",$totalEval,$obj);		
				
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
			}
			else
			{
				
				
				$posRegistro--;
				$nReg--;
				mysql_data_seek($res,$posRegistro);
				
			}
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$cadRegistros.']}';
	}
	
	function guardarCalificacionAlumnoBloqueCambioEvaluacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="SELECT idPlanEstudio,idInstanciaPlanEstudio,idMateria FROM 4520_grupos WHERE idGrupos=".$obj->idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($query);
		$query="SELECT calificacionMinimaAprobatoria FROM 4592_configuracionPerfilEvaluacion WHERE idPlanEstudio=".$fGrupo[0]." AND idMateria=".$fGrupo[2]." AND idInstanciaPlanEstudio IN (".$fGrupo[1].",-1) AND idGrupo IN (".$obj->idGrupo.",-1)
				AND tipoExamen=".$obj->tipoEvaluacion." AND noExamen=".$obj->noEvaluacion." order by idGrupo desc,idInstanciaPlanEstudio desc";
		

		$calMinima=$con->obtenerValor($query);
		$aprobado=0;
		if($calMinima<=($obj->totalBloque/10))
			$aprobado=1;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		foreach($obj->criterios as $c)
		{
			$query="SELECT idCalificacion FROM 4594_calificacionesCriteriosAlumnoCambioEvaluacion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." AND idAlumno=".$obj->idAlumno." AND idCriterio=".$c->criterio;
			$idRegistro=$con->obtenerValor($query);
			if($idRegistro=="")
			{
				$consulta[$x]="INSERT 4594_calificacionesCriteriosAlumnoCambioEvaluacion (idAlumno,idGrupo,idCriterio,bloque,valor,porcentajeObtenido,porcentajeValor,totalConsiderar,tipoEvaluacion,noEvaluacion,
								idFormulario,idReferencia,valorCambio,porcentajeObtenidoCambio,porcentajeValorCambio,totalConsiderarCambio)
								VALUES(".$obj->idAlumno.",".$obj->idGrupo.",'".$c->criterio."',".$obj->bloque.",0,0,".$c->porcentajeValor.",".$c->totalConsiderar.",".$obj->tipoEvaluacion.",".$obj->noEvaluacion.",
								".$obj->idFormulario.",".$obj->idRegistro.",".$c->valor.",".$c->porcentajeObtenido.",".$c->porcentajeValor.",".$c->totalConsiderar.")";
				$x++;
			}
			else
			{
				$consulta[$x]="update 4594_calificacionesCriteriosAlumnoCambioEvaluacion set valorCambio=".$c->valor.",porcentajeObtenidoCambio=".$c->porcentajeObtenido.",porcentajeValorCambio=".$c->porcentajeValor.",totalConsiderarCambio=".$c->totalConsiderar."
								where idCalificacion=".$idRegistro;
				$x++;
			}
		}
		
		$query="SELECT idInstanciaPlan,idMateria FROM 4517_alumnosVsMateriaGrupo WHERE idUsuario=".$obj->idAlumno." and idGrupo=".$obj->idGrupo;
		$fInscripcion=$con->obtenerPrimeraFila($query);
				
		
		$query="SELECT idCalificacionBloque FROM 4595_calificacionesEvaluacionAlumnoCambioEvaluacion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." AND idAlumno=".$obj->idAlumno;
		$idRegistro=$con->obtenerValor($query);
		if($idRegistro=="")
		{
			$consulta[$x]="INSERT INTO 4595_calificacionesEvaluacionAlumnoCambioEvaluacion(idAlumno,idGrupo,bloque,valor,tipoEvaluacion,noEvaluacion,aprobado,idFormulario,idReferencia,valorCambio,aprobadoCambio,idMateria) 
						VALUES(".$obj->idAlumno.",".$obj->idGrupo.",".$obj->bloque.",0,".$obj->tipoEvaluacion.",".$obj->noEvaluacion.",0,".$obj->idFormulario.",".$obj->idRegistro.",".$obj->totalBloque.",".$aprobado.",".$fInscripcion[1].")";
			$x++;
		}
		else
		{
			$consulta[$x]="update 4595_calificacionesEvaluacionAlumnoCambioEvaluacion set valorCambio=".$obj->totalBloque.",aprobadoCambio=".$aprobado." where idCalificacionBloque=".$idRegistro;

			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
		
	}
	
	function modificarValorLimiteMaximoCambioEvaluacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="SELECT  idCriterioValMaximo FROM 4596_valoresMaximosCriterioCambioEvaluacion WHERE idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idRegistro." and idCriterio='".$obj->idCriterio."' and idAlumno IS NULL";
		$idCriterio=$con->obtenerValor($consulta);
		if($idCriterio=="")
			$consulta="INSERT INTO 4596_valoresMaximosCriterioCambioEvaluacion(idCriterio,idGrupo,noBloque,valMax,tipoEvaluacion,noEvaluacion,idFormulario,idReferencia,valMaxCambio)
					VALUES('".$obj->idCriterio."',".$obj->idGrupo.",".$obj->noBloque.",0,".$obj->tipoEvaluacion.",".$obj->noEvaluacion.",".$obj->idFormulario.",".$obj->idRegistro.",".$obj->valMax.")";
		else
			$consulta="update 4596_valoresMaximosCriterioCambioEvaluacion set valMaxCambio=".$obj->valMax." where idCriterioValMaximo=".$idCriterio;
		if($con->ejecutarConsulta($consulta))
		{
			if(recalcularCalificacionesGrupoCambioEvaluacion($obj->idGrupo,$obj->idCriterio,$obj->noBloque,$obj->tipoEvaluacion,$obj->noEvaluacion,$obj->idFormulario,$obj->idRegistro))
			{
				echo "1|";
			}
		}
	}
	
	function obtenerSituacionCurso()
	{
		global $con;
		$consulta="SELECT id__721_tablaDinamica FROM _721_tablaDinamica WHERE cmbCalificacionfinal=1";
		$listEvaluacionesFinales=$con->obtenerListaValores($consulta);
		$idUsuarioRegistro=$_POST["idUsuarioRegistro"];
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		
		$consulta="SELECT idCiclo,idPeriodo FROM 4529_alumnos WHERE idUsuario=".$idUsuarioRegistro." AND idInstanciaPlanEstudio=".$idInstanciaPlan.
					" ORDER BY idAlumnoTabla desc";
		$fCiclo=$con->obtenerPrimeraFila($consulta);
		$arrRegistros="";
		$nReg=0;
		$aRegistros=array();
		$consulta="SELECT g.idGrupos,m.nombreMateria,m.idMateria FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a,4502_Materias m WHERE 
					a.idUsuario=".$idUsuarioRegistro." AND (a.idGrupoOrigen IS NULL OR a.idGrupoOrigen=-1) AND  a.condicionado=0 and
					a.idCiclo=".$fCiclo[0]." AND a.idPeriodo=".$fCiclo[1]." AND g.idInstanciaPlanEstudio=".$idInstanciaPlan." AND a.idGrupo=g.idGrupos 
					AND m.idMateria=g.idMateria ORDER BY nombreMateria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$idFuncionRenderer=0;
			$calificacion=0;
			$consulta="SELECT valor,tipoEvaluacion,noEvaluacion,aprobado FROM  4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE 
						idAlumno=".$idUsuarioRegistro." and idGrupo=".$fila[0]." and tipoEvaluacion in (".$listEvaluacionesFinales.")";
			$fCalificacion=$con->obtenerPrimeraFila($consulta);
			if($fCalificacion)
			{
				$calificacion=$fCalificacion[0];
				if($calificacion=="")
					$calificacion=0;
				$lblOportunidad="";
				$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
				$idPlanEstudio=$con->obtenerValor($consulta);
				$idPerfil=obtenerPerfilExamenesAplica($idPlanEstudio,$idInstanciaPlan,true);
				if($idPerfil=="")
					$idPerfil=-1;
				$consulta="SELECT etiquetaExamen FROM _398_gridTiposExamen WHERE idReferencia=".$idPerfil." AND tipoExamen=".$fCalificacion[1]." 
							AND noExamen=".$fCalificacion[2];
				$lblOportunidad=$con->obtenerValor($consulta);
				
				$consulta="SELECT cmbFuncionRenderer FROM _721_tablaDinamica WHERE id__721_tablaDinamica=".$fCalificacion[1];
				$idFuncionRenderer=$con->obtenerValor($consulta);
			}
			else
			{
				
				$lblOportunidad="";
				$fCalificacion[3]=0;
				
			}
			$obj='{"idMateria":"'.$fila[2].'","materia":"'.cv($fila[1]).'","calificacion":"'.$idFuncionRenderer."_".$calificacion.'","oportunidad":"'.$lblOportunidad.'","situacion":"'.$fCalificacion[3].'","categoria":"0"}';
			$aRegistros[$fila[1]."_".$fila[2]]=$obj;
			
		}
		
		
		$consulta="SELECT a.idGrupo,m.nombreMateria,m.idMateria FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a,4502_Materias m WHERE a.idUsuario=".
					$idUsuarioRegistro." AND   a.condicionado=0 and a.idGrupoOrigen=g.idGrupos AND
					a.idCiclo=".$fCiclo[0]." AND a.idPeriodo=".$fCiclo[1]." AND g.idInstanciaPlanEstudio=".$idInstanciaPlan." AND m.idMateria=g.idMateria 
					ORDER BY nombreMateria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$idFuncionRenderer=0;
			$calificacion=0;
			$consulta="SELECT valor,tipoEvaluacion,noEvaluacion,aprobado FROM  4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE 
						idAlumno=".$idUsuarioRegistro." and idGrupo=".$fila[0]." and tipoEvaluacion in (".$listEvaluacionesFinales.")";
			//
			$fCalificacion=$con->obtenerPrimeraFila($consulta);
			if($fCalificacion)
			{
				$calificacion=$fCalificacion[0];
				if($calificacion=="")
					$calificacion=0;
				$lblOportunidad="";
				$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
				$idPlanEstudio=$con->obtenerValor($consulta);
				$idPerfil=obtenerPerfilExamenesAplica($idPlanEstudio,$idInstanciaPlan,true);
				if($idPerfil=="")
					$idPerfil=-1;
				$consulta="SELECT etiquetaExamen FROM _398_gridTiposExamen WHERE idReferencia=".$idPerfil." AND tipoExamen=".$fCalificacion[1]." 
							AND noExamen=".$fCalificacion[2];
				$lblOportunidad=$con->obtenerValor($consulta);
				
				$consulta="SELECT cmbFuncionRenderer FROM _721_tablaDinamica WHERE id__721_tablaDinamica=".$fCalificacion[1];
				$idFuncionRenderer=$con->obtenerValor($consulta);
			}
			else
			{
				
				$lblOportunidad="";
				$fCalificacion[3]=0;
				
			}
			$obj='{"idMateria":"'.$fila[2].'","materia":"'.cv($fila[1]).'","calificacion":"'.$idFuncionRenderer."_".$calificacion.'","oportunidad":"'.$lblOportunidad.'","situacion":"'.$fCalificacion[3].'","categoria":"0"}';
			$aRegistros[$fila[1]."_".$fila[2]]=$obj;
		}
		ksort($aRegistros);
		foreach($aRegistros as $obj)
		{
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
		}
		
		
		
		
		$consulta="SELECT g.idGrupos,m.nombreMateria,m.idMateria FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a,4502_Materias m 
					WHERE a.idUsuario=".$idUsuarioRegistro." AND (a.idGrupoOrigen IS NULL OR a.idGrupoOrigen=-1) AND  a.condicionado=1 and
					a.idCicloCondicionado=".$fCiclo[0]." AND a.idPeriodoCondicionado=".$fCiclo[1]." AND 
					a.idInstanciaPlanEstudioCondicionado=".$idInstanciaPlan." AND a.idGrupo=g.idGrupos AND m.idMateria=g.idMateria ORDER BY nombreMateria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$idFuncionRenderer=0;
			$calificacion=0;
			$consulta="SELECT valor,tipoEvaluacion,noEvaluacion,aprobado FROM  4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE idAlumno=".$idUsuarioRegistro.
						" and idGrupo=".$fila[0]." and tipoEvaluacion in (".$listEvaluacionesFinales.")";
			
			$fCalificacion=$con->obtenerPrimeraFila($consulta);
			if($fCalificacion)
			{
				$calificacion=$fCalificacion[0];
				if($calificacion=="")
					$calificacion=0;
				$lblOportunidad="";
				$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
				$idPlanEstudio=$con->obtenerValor($consulta);
				$idPerfil=obtenerPerfilExamenesAplica($idPlanEstudio,$idInstanciaPlan,true);
				if($idPerfil=="")
					$idPerfil=-1;
				$consulta="SELECT etiquetaExamen FROM _398_gridTiposExamen WHERE idReferencia=".$idPerfil." AND tipoExamen=".$fCalificacion[1]." 
							AND noExamen=".$fCalificacion[2];
				$lblOportunidad=$con->obtenerValor($consulta);
				
				$consulta="SELECT cmbFuncionRenderer FROM _721_tablaDinamica WHERE id__721_tablaDinamica=".$fCalificacion[1];
				$idFuncionRenderer=$con->obtenerValor($consulta);
			}
			else
			{
				
				$lblOportunidad="";
				$fCalificacion[3]=0;
				
			}
			$obj='{"idMateria":"'.$fila[2].'","materia":"'.cv($fila[1]).'","calificacion":"'.$idFuncionRenderer."_".$calificacion.'","oportunidad":"'.$lblOportunidad.'","situacion":"'.$fCalificacion[3].'","categoria":"1"}';
			$aRegistros[$fila[1]."_".$fila[2]]=$obj;
		}
		
		$consulta="SELECT m.nombreMateria,m.idMateria FROM 4517_alumnosVsMateriaGrupo a,4502_Materias m WHERE a.idUsuario=".$idUsuarioRegistro." and a.situacion=10 
					AND a.idInstanciaPlanEstudioCondicionado=".$idInstanciaPlan." AND  m.idMateria=a.idMateria ORDER BY nombreMateria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$calificacion='N/E';
			$lblOportunidad="N/A";
			$idFuncionRenderer=0;
			
			
			$obj='{"idMateria":"'.$fila[1].'","materia":"'.cv($fila[0]).'","calificacion":"'.$idFuncionRenderer."_".$calificacion.'","oportunidad":"'.$lblOportunidad.'","situacion":"0","categoria":"2"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
			
	}
	
	function obtenerSituacionInscripcion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$fConf=obtenerConfiguracionPlanEstudio(472,"",$obj->idInstanciaPlan,true);

		$cadValidacionInscripcion="";
		$cadObjParam='{"idInstanciaPlan":"","idUsuario":"","idCiclo":"","idPeriodo":"","arrMaterias":null,"fConfiguracion":null}';
		$objParam=json_decode($cadObjParam);
		$cache=NULL;
		$objParam->idInstanciaPlan=$obj->idInstanciaPlan;
		$objParam->idUsuario=$obj->idUsuario;
		$objParam->idCiclo=$obj->idCiclo;
		$objParam->idPeriodo=$obj->idPeriodo;
		$objParam->arrMaterias=$obj->arrMaterias;
		$objParam->fConfiguracion=$fConf;
		
		$cadObjParam='{"param1":null}';
		$objParam1=json_decode($cadObjParam);
		$objParam1->param1=$objParam;


		if($fConf["perfilValidacionReinscripcion"]=="")
			$fConf["perfilValidacionReinscripcion"]=-1;
		$consulta="SELECT idFuncionValidacion,etiqueta,id__917_gridValidacionInscripcion FROM _917_gridValidacionInscripcion WHERE idReferencia=".$fConf["perfilValidacionReinscripcion"];

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$resultado=resolverExpresionCalculoPHP($fila[0],$objParam1,$cache);

			
			$valor=0;
			$etiquetaComplementaria="";
			if(gettype($resultado)!="array")
			{
				$valor=removerComillasLimite($resultado);
			}
			else
			{
				$valor=$resultado["valor"];
				$etiquetaComplementaria=$resultado["complementario"];
			}
			
			if($valor==1)
			{
				$cObj='{"id":"'.$fila[2].'","etiqueta":"'.cv($fila[1]).'","etiquetaComplementaria":"'.cv($etiquetaComplementaria).'"}';
				if($cadValidacionInscripcion=="")
					$cadValidacionInscripcion=$cObj;
				else
					$cadValidacionInscripcion.=",".$cObj;
			}
			
		}
		
		$cadSituaciones="";
		$consulta="SELECT idFuncionValidadora,etiqueta,id__917_gridSituaciones FROM _917_gridSituaciones WHERE idReferencia=".$fConf["perfilValidacionReinscripcion"];
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$resultado=resolverExpresionCalculoPHP($fila[0],$objParam1,$cache);
			$valor=0;
			$etiquetaComplementaria="";
			if(gettype($resultado)!="array")
			{
				$valor=removerComillasLimite($resultado);
			}
			else
			{
				$valor=$resultado["valor"];
				$etiquetaComplementaria=$resultado["complementario"];
			}

			if($valor==1)
			{
				$cObj='{"id":"'.$fila[2].'","etiqueta":"'.cv($fila[1]).'","etiquetaComplementaria":"'.cv($etiquetaComplementaria).'"}';
				if($cadSituaciones=="")
					$cadSituaciones=$cObj;
				else
					$cadSituaciones.=",".$cObj;
			}
		}
		
		
		echo '1|{"arrValidacionInscripcion":['.$cadValidacionInscripcion.'],"arrSituaciones":['.$cadSituaciones.']}';
		
	}
	
	function obtenerDocumentosInscripcion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$nReg=0;
		$cadRegistros="";
		$idInstancia=-1;
		$idUsuario=-1;
		switch($idFormulario)
		{
			case 678:
				$consulta="SELECT idReferencia FROM _678_tablaDinamica WHERE id__678_tablaDinamica=".$idRegistro;
				$fSolicitud=$con->obtenerPrimeraFila($consulta);
				$idReferencia=$fSolicitud[0];
				$consulta="SELECT * FROM 4573_solicitudesInscripcion WHERE idSolicitudInscripcion=".$idReferencia;
				$fRegistro=$con->obtenerPrimeraFila($consulta);
				
				$idUsuario=$fRegistro[2];
				$idInstancia=$fRegistro[6];
			break;
			case 910:
				$consulta="SELECT idInstanciaPlan,idUsuarioRegistro FROM _910_tablaDinamica WHERE id__910_tablaDinamica=".$idRegistro;
				$fIncripcion=$con->obtenerPrimeraFila($consulta);
				$idInstancia=$fIncripcion[0];
				$idUsuario=$fIncripcion[1];
			break;
		}
		
		$filaConf=obtenerConfiguracionPlanEstudio(392,"",$idInstancia);
		$consulta="";
		$consulta="SELECT COUNT(*) FROM 4599_dictamenEvaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$nRegDocumento=$con->obtenerValor($consulta);
		if($nRegDocumento==0)
		{
			$consulta="SELECT documentos,d.txtDocumento,requerido,funcionAplicacion FROM _392_docVSplanesEstudio t,_391_tablaDinamica d 
						WHERE t.idReferencia=".$filaConf[0]." AND d.id__391_tablaDinamica=t.documentos ORDER BY txtDocumento";
		}
		else
		{
			$consulta="SELECT t.idDocumento,d.txtDocumento,'1' as requerido,'' as funcionAplicacion FROM 4598_evaluacionDocumentosInscripcion t,_391_tablaDinamica d 
						WHERE t.idFormulario=".$idFormulario." AND t.idReferencia=".$idRegistro." and  d.id__391_tablaDinamica=t.idDocumento ORDER BY txtDocumento";
		}

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$mostrarDocumento=false;
			$documentoRequerido=true;
			if($fila[2]==0)
			{
				$consulta="SELECT COUNT(*) FROM 825_documentosUsr WHERE idUsuario=".$idUsuario." AND idDocumento=".$fila[0];
				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
					$documentoRequerido=false;
			}
			
			if($documentoRequerido)
			{
				if($fila[3]=="")
				{
					$mostrarDocumento=true;
				}
				else
				{
					$arrParam["idFormulario"]=$idFormulario;
					$arrParam["idRegistro"]=$idRegistro;
					$arrParam["idUsuario"]=$idUsuario;
					$arrParam["idInstancia"]=$idInstancia;
					$arrParam["idDocumento"]=$fila[0];
					$cache=NULL;
					$cadObjParam='{"param1":null}';
					$objParam1=json_decode($cadObjParam);
					$objParam1->param1=$arrParam;
					$resultado=resolverExpresionCalculoPHP($fila[3],$objParam1,$cache);
					$resultado=removerComillasLimite($resultado);
					$mostrarDocumento=($resultado==1);
					
				}
			}
			
			if(($nRegDocumento>0)||($mostrarDocumento))
			{
			
				$consulta="SELECT * FROM 4598_evaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idDocumento=".$fila[0];
				$fDocumento=$con->obtenerPrimeraFila($consulta);
				$documentoDigital="";
				if($fDocumento[5]!="")
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDocumento[5];
					$documentoDigital=$con->obtenerValor($consulta);
					$documentoDigital.="|".$fDocumento[5];
				}
				$obj='{"idDocumento":"'.$fila[0].'","documento":"'.cv($fila[1]).'","situacion":"'.$fDocumento[4].'","fechaCondicionamiento":"'.$fDocumento[6].'","observaciones":"'.cv($fDocumento[7]).'","documentoDigital":"'.$documentoDigital.'"}';
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
				$numReg++;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
	}
	
	function registrarSituacionDocumentoInscripcion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->fechaLimiteEntrega=="")
			$obj->fechaLimiteEntrega="NULL";
		else
			$obj->fechaLimiteEntrega="'".$obj->fechaLimiteEntrega."'";
		if($obj->documento==-1)
			$$obj->documento="";
		
		$idDocumento="NULL";
		
		if($obj->documento!="")
		{
			if(strpos($obj->documento,"_")===false)
			{
				$arrDocumento=explode("|",$obj->documento);
				$idDocumento=$arrDocumento[1];
			}
			else
			{
				$arrDocumento=explode("|",$obj->documento);
				$idDocumento=registrarDocumentoServidor($arrDocumento[1],$arrDocumento[0]);
				$obj->documento=$idDocumento;
			}
		}
			
		$consulta="SELECT idEvaluacionDocumento FROM 4598_evaluacionDocumentosInscripcion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." AND idDocumento=".$obj->idDocumento;	
		$idEvaluacionDocumento=$con->obtenerValor($consulta);
		if($idEvaluacionDocumento=="")
		{
			$consulta="INSERT INTO 4598_evaluacionDocumentosInscripcion(idFormulario,idReferencia,idDocumento,situacionDocumento,documentoDigital,fechaLimiteEntregaDocumento,observaciones)
						VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->idDocumento.",".$obj->situacion.",".$idDocumento.",".$obj->fechaLimiteEntrega.",'".cv($obj->observaciones)."')";
		
		}
		else
		{
			$consulta="UPDATE 4598_evaluacionDocumentosInscripcion SET situacionDocumento=".$obj->situacion.",documentoDigital=".$idDocumento.",fechaLimiteEntregaDocumento=".$obj->fechaLimiteEntrega.",observaciones='".cv($obj->observaciones)."' WHERE  idEvaluacionDocumento=".$idEvaluacionDocumento;
		}
		if($con->ejecutarConsulta($consulta))
		{
				echo "1|".$obj->documento;
		}
	}
	
	function finalizarEvaluacionDocumentos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="INSERT INTO 4599_dictamenEvaluacionDocumentosInscripcion(idFormulario,idReferencia,dictamenEvaluacion)
				VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->dictamen.")";
		eC($consulta);
		
	}
	
	function obtenerAdeudosBaja()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT cmbTipoBaja,cmbAlumnos FROM _715_tablaDinamica WHERE id__715_tablaDinamica=".$idRegistro;
		$fBaja=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idConcepto FROM 564_conceptosVSCategorias WHERE idCategoria=19";
		$listConceptos=$con->obtenerListaValores($consulta);
		if($listConceptos=="")
			$listConceptos=-1;
			
		$arrAdeudos="";
		$nReg=0;
			
		$consulta="SELECT idOpcion FROM _715_chkInstanciaPlan WHERE idPadre=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idMovimiento,idReferencia,fechaVencimiento,pagado,idConcepto FROM 6011_movimientosPago m,6012_detalleAsientoPago d WHERE 
					idUsuario=".$fBaja[1]." AND idConcepto IN(".$listConceptos.") AND pagado=0 and situacion=1 AND d.idAsientoPago=m.idMovimiento AND d.idDimension=7 AND d.valorCampo=".$fila[0];
			$resPagos=$con->obtenerFilas($consulta);
			while($filaPago=mysql_fetch_row($resPagos))
			{
				if(($filaPago[2]=="")||(strtotime(date("Y-m-d"))>=strtotime($filaPago[2])))
				{
					$consulta="SELECT CONCAT('[',cveConcepto,'] ',nombreConcepto) FROM 561_conceptosIngreso WHERE idConcepto=".$filaPago[4];
					$nombreConcepto=$con->obtenerValor($consulta);
					$nomPlanEstudio=obtenerNombreInstanciaPlan($fila[0]);
					
					
					$consulta="SELECT monto FROM 6012_asientosPago WHERE idReferenciaMovimiento=".$filaPago[0]." and fechaInicio<='".date("Y-m-d")."' ORDER BY fechaInicio desc";
					$montoAdeudo=$con->obtenerValor($consulta);
					$o='{"idReferencia":"'.$filaPago[1].'","nombreConcepto":"'.$nombreConcepto.'","montoAdeudo":"'.$montoAdeudo.'","fechaVencimiento":"'.$filaPago[2].'","planEstudio":"'.$nomPlanEstudio.'"}';
					if($arrAdeudos=="")
						$arrAdeudos=$o;
					else
						$arrAdeudos.=",".$o;
					$nReg++;
				}
			}
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrAdeudos.']}';
	}
	
	function obtenerDocumentosEntrega()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$nReg=0;
		$cadRegistros="";
		$idInstancia=-1;
		$idUsuario=-1;
		$consulta="SELECT cmbAlumnos FROM _715_tablaDinamica WHERE id__715_tablaDinamica=".$idRegistro;
		$idUsuario=$con->obtenerValor($consulta);
		$consulta="SELECT idOpcion FROM _715_chkInstanciaPlan WHERE idPadre=".$idRegistro;
		$resInstancias=$con->obtenerFilas($consulta);
		while($filaInst=mysql_fetch_row($resInstancias))
		{
			$idInstancia=$filaInst[0];
			$filaConf=obtenerConfiguracionPlanEstudio(392,"",$idInstancia);
			$consulta="";
			$consulta="SELECT COUNT(*) FROM 4599_dictamenEvaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$consulta="SELECT documentos,d.txtDocumento,requerido,funcionAplicacion FROM _392_docVSplanesEstudio t,_391_tablaDinamica d 
							WHERE t.idReferencia=".$filaConf[0]." AND d.id__391_tablaDinamica=t.documentos ORDER BY txtDocumento";
			}
			else
			{
				$consulta="SELECT t.idDocumento,d.txtDocumento,'1' as requerido,'' as funcionAplicacion FROM 4598_evaluacionDocumentosInscripcion t,_391_tablaDinamica d 
							WHERE t.idFormulario=".$idFormulario." AND t.idReferencia=".$idRegistro." and  d.id__391_tablaDinamica=t.idDocumento ORDER BY txtDocumento";
			}
			
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$situacionDocumento=4;
				$consulta="SELECT * FROM 4598_evaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idDocumento=".$fila[0];
				$fDocumento=$con->obtenerPrimeraFila($consulta);
				if($fDocumento)
				{
					$situacionDocumento=$fDocumento[4];
				}
				else
				{
					$consulta="SELECT situacion FROM 825_documentosUsr WHERE idUsuario=".$idUsuario." AND idDocumento=".$fila[0];
					$situacionDocumento=$con->obtenerValor($consulta);
					if($situacionDocumento=="")
						$situacionDocumento=4;
				}
				$documentoDigital="";
				$consulta="SELECT valorDocumento FROM 825_documentosUsr WHERE idUsuario=".$idUsuario." AND idDocumento=".$fila[0];
				$idDocumentoArch=$con->obtenerValor($consulta);
				if($idDocumentoArch!="")
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumentoArch;
					$documentoDigital=$con->obtenerValor($consulta);
					$documentoDigital.="|".$idDocumentoArch;
				}
				if($situacionDocumento==1)
					$situacionDocumento="";
				$obj='{"idDocumento":"'.$fila[0].'","documento":"'.cv($fila[1]).'","situacion":"'.$situacionDocumento.'","observaciones":"'.cv($fDocumento[7]).'","documentoDigital":"'.$documentoDigital.'"}';
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
				$nReg++;
				
			}
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$cadRegistros.']}';
	}
	
	function registrarInscripcionCurso()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idGrupo=$_POST["idGrupo"];
		$validar=$_POST["validar"];
		if($validar==1)
		{
			$arrIncidencias=array();
			$consulta="SELECT instanciaPlanEstudio,cmbAlumno,idCiclo,idPeriodo FROM _932_tablaDinamica WHERE id__932_tablaDinamica=".$idRegistro;
			$fBase=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT * FROM 4522_horarioGrupo where idGrupo=".$idGrupo." AND fechaInicio<fechaFin";
			$resHorario=$con->obtenerFilas($consulta);
			while($fHorario=mysql_fetch_row($resHorario))
			{
				$dia=$fHorario[2];
				$horaI=$fHorario[3];
				$horaF=$fHorario[4];
				$fechaInicio=$fHorario[6];
				$fechaFin=$fHorario[7];
				$idAlumno=$fBase[1];
				$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaI,$horaF,$fechaInicio,$fechaFin,-1,$idAlumno);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
			}
			if(sizeof($arrIncidencias)>0)
			{
				echo "1|".generarResolucionArregloErrores($arrIncidencias);
				return;
			}
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 4600_solicitudesInscripcionCurso where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;

		$x++;
		$query[$x]="INSERT INTO 4600_solicitudesInscripcionCurso(idFormulario,idReferencia,idGrupoInscribe)
					VALUES(".$idFormulario.",".$idRegistro.",".$idGrupo.")";
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			echo '1|{"permiteContinuar":"1","arrErrores":[]}';
		}
	}
	
	function obtenerDatosAlumno()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT * FROM 4529_alumnos WHERE  idUsuario=".$idUsuario." AND idInstanciaPlanEstudio=".$idInstancia."  ORDER BY idAlumnoTabla ASC LIMIT 0,1";
		$fAlumno1=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$fAlumno1[1];
		$ciclo=$con->obtenerValor($consulta);
		$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$fAlumno1[2];
		$periodo=$con->obtenerValor($consulta);

		$lblAnioIngreso=$ciclo." (<b>Periodo:</b> ".$periodo.")";


		
		$consulta="SELECT * FROM 4529_alumnos WHERE  idUsuario=".$idUsuario."  AND idInstanciaPlanEstudio=".$idInstancia." ORDER BY idAlumnoTabla DESC LIMIT 0,1";
		$fAlumno2=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$fAlumno2[1];
		$ciclo=$con->obtenerValor($consulta);
		$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$fAlumno2[2];
		$periodo=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 4537_situacionActualAlumno WHERE  idAlumno= ".$idUsuario." AND idInstanciaPlanEstudio=".$idInstancia;
		$fAlumno3=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT leyendaGrado FROM 4501_Grado WHERE idGrado=".$fAlumno2[4];
		$gradoActual=$con->obtenerValor($consulta);
		$gradoActual.=" (<b>Ciclo:</b> ".$ciclo.", <b>Periodo:</b> ".$periodo.")";
		$consulta="SELECT tipoSituacion FROM 4601_situacionAlumno WHERE idSituacionAlumno=".$fAlumno3[4];
		$situacionActual=$con->obtenerValor($consulta);
		
		$cadObj='{"anioIngreso":"'.cv($lblAnioIngreso).'","gradoActual":"'.cv($gradoActual).'","situacionActual":"'.$situacionActual.'","idCiclo":"'.$fAlumno2[1].'","idPeriodo":"'.$fAlumno2[2].'"}';
		echo "1|".$cadObj;

 
		
	}
	
	function obtenerSituacionTramites()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idInstancia=$_POST["idInstancia"];
		$vistaProcesos=1;
		if(isset($_POST["vistaProcesos"]))
			$vistaProcesos=$_POST["vistaProcesos"];
		$rol="7_0";
		$arrRegistros="";
		$consulta="SELECT procesos,leyendaOperacion,rendererDescriptivo,id__951_tablaDinamica FROM _951_tablaDinamica WHERE idReferencia=".$vistaProcesos;
		$resProcesos=$con->obtenerFilas($consulta);
		$numReg=0;
		
		while($fila=mysql_fetch_row($resProcesos))
		{
			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$fila[0];
			$nombreProceso=$con->obtenerValor($consulta);
			$leyenda=$fila[0];
			$idFormularioBase=obtenerFormularioBase($fila[0]);
			$condWhere="";
			$consulta="SELECT campoReferencia FROM _951_gridCampoReferencia g WHERE g.idReferencia=".$fila[3];
			$resCampos=$con->obtenerFilas($consulta);
			while($filaCampo=mysql_fetch_row($resCampos))
			{
				if($condWhere=="")
					$condWhere=$filaCampo[0]."=".$idUsuario;
				else
					$condWhere.=" or ".$filaCampo[0]."=".$idUsuario;
			}
			$condWhere="(".$condWhere.")";
			$arrEtapas=array();
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE  idProceso=".$fila[0]." ORDER BY numEtapa";
			$resEt=$con->obtenerFilas($consulta);
			while($fEt=mysql_fetch_row($resEt))
			{
				$arrEtapas[($fEt[0])]=$fEt[1];
			}
			$consulta="SELECT id__".$idFormularioBase."_tablaDinamica,codigo,idEstado,fechaCreacion FROM _".$idFormularioBase."_tablaDinamica WHERE ".$condWhere;

			$resRegistros=$con->obtenerFilas($consulta);
			while($fRegistro=mysql_fetch_row($resRegistros))
			{
				
				$leyendaAux=$leyenda;
				if($fila[2]!="")
				{
					$cadObj='{"idFormulario":"'.$idFormularioBase.'","idRegistro":"'.$fRegistro[0].'"}';
						$objRef=NULL;			
					$obj=json_decode($cadObj);
					
					$leyendaAux=removerComillasLimite(resolverExpresionCalculoPHP($fila[2],$obj,$objRef));
				}
				$actor=obtenerActorProcesoIdRol($fila[0],$rol,$fRegistro[2]);
				if($actor=="")
					$actor=0;
				$consulta="SELECT fechaCambio,idUsuarioCambio,comentarios FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormularioBase." AND idRegistro=".$fRegistro[0];
				
				$fCambio=$con->obtenerPrimeraFila($consulta);
				if(!$fCambio)
				{
					$fCambio[0]="";
					$fCambio[1]=-1;
					$fCambio[2]="";
				}
				
				$obj='{"idRegistro":"'.$fRegistro[0].'","actor":"'.$actor.'","folio":"'.$fRegistro[1].'","idFormulario":"'.$idFormularioBase.
						'","nombreTramite":"'.cv($leyendaAux).'","categoriaTramite":"'.cv($nombreProceso).'","fechaRegistro":"'.$fRegistro[3].'","situacion":"'.removerCerosDerecha($fRegistro[2]).".- ".cv($arrEtapas[($fRegistro[2])]).
						'","fechaUltimoCambio":"'.$fCambio[0].'","comentariosUltimoCambio":"'.cv($fCambio[2]).'","responsableUltimoCambio":"'.cv(obtenerNombreUsuarioPaterno($fCambio[1])).'"}';
				$numReg++;
			
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
			
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
			
	}
	
	function obtenerVacantesPorEmpresa()
	{
		global $con;
		$cad='';
		$tVacantes=0;
		$consulta="";
		if(esUsuarioLog())
		{
			$consulta="SELECT distinct idPadre FROM _952_ambitoPublicacion WHERE idOpcion=2";	
		}
		else
		{
			$consulta="SELECT distinct idPadre FROM _952_ambitoPublicacion WHERE idOpcion=1";
		}
		
		$listaAmbito=$con->obtenerListaValores($consulta);
		if($listaAmbito=="")
			$listaAmbito=-1;
		$consulta="SELECT DISTINCT t.codigoInstitucion,o.unidad FROM _952_tablaDinamica t,817_organigrama o WHERE idEstado=2 and id__952_tablaDinamica in (".$listaAmbito.") AND o.codigoUnidad=t.codigoInstitucion ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select count(*) from _952_tablaDinamica where codigoInstitucion='".$fila[0]."' and idEstado=2";
			$nReg=$con->obtenerValor($consulta);
			$o='{"icon":"../images/user_gray.png","id":"'.$fila[0].'","text":"'.cv($fila[1]).' ('.$nReg.')","tipo":"2",leaf:true}';
			if($cad=='')
				$cad=$o;
			else
				$cad.=",".$o;
			$tVacantes++;
		}
		if($tVacantes>0)
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por plantel ('.$tVacantes.')</b>","children":['.$cad.'],"leaf":false}';
		else
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por plantel ('.$tVacantes.')</b>","leaf":true}';
		echo '['.$objFinal.']';
		
	}
	
	function obtenerVacantesPorCategoria()
	{
		global $con;
		$cad='';
		$tVacantes=0;
		$consulta="";
		if(esUsuarioLog())
		{
			$consulta="SELECT distinct idPadre FROM _952_ambitoPublicacion WHERE idOpcion=2";	
		}
		else
		{
			$consulta="SELECT distinct  idPadre FROM _952_ambitoPublicacion WHERE idOpcion=1";
		}
		
		$listaAmbito=$con->obtenerListaValores($consulta);
		if($listaAmbito=="")
			$listaAmbito=-1;
		$consulta="SELECT DISTINCT c.id__953_tablaDinamica,c.nombreCategoria FROM _952_tablaDinamica t,_953_tablaDinamica c WHERE c.id__953_tablaDinamica=t.categoria and t.idEstado=2 and id__952_tablaDinamica in (".$listaAmbito.") ORDER BY c.nombreCategoria";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select count(*) from _952_tablaDinamica where categoria=".$fila[0]." and idEstado=2 and id__952_tablaDinamica in (".$listaAmbito.")";
			$nReg=$con->obtenerValor($consulta);
			$o='{"icon":"../images/user_gray.png","id":"'.$fila[0].'","text":"'.cv($fila[1]).' ('.$nReg.')","tipo":"3",leaf:true}';
			if($cad=='')
				$cad=$o;
			else
				$cad.=",".$o;
			$tVacantes++;
		}
		if($tVacantes>0)
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por categoría ('.$tVacantes.')</b>","children":['.$cad.'],"leaf":false}';
		else
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por categoría ('.$tVacantes.')</b>","leaf":true}';
		echo '['.$objFinal.']';
	}
	
	function obtenerFormatoBoletin()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$tblResumen=generarFichaResumenArticulo($idRegistro);
		$tblArticulo=generarFichaArticulo($idRegistro);
		
		$tblCompleto='<table width="740">
						<tr>
							<td>'.$tblResumen.'
							</td>
						</tr>
						<tr height="20">
							<td></td>
						</tr>
						<tr height="1">
							<td style="background-color:#CCC">
							</td>
						</tr>
						<tr height="20">
							<td></td>
						</tr>
						<tr>
							<td>'.$tblArticulo.'
							</td>
						</tr>
					</table>';
		echo "1|".bE($tblCompleto);
		
		
	}
	
	function removerArticuloBoletin()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="DELETE FROM 3005_articulosBoletin WHERE idArticuloBoletin=".$idRegistro;
		eC($consulta);
			
	}
	
	function obtenerArticulosDisponibles()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT id__957_tablaDinamica as idArticulo,tituloArticulo  FROM _957_tablaDinamica WHERE idEstado=2 AND id__957_tablaDinamica 
					NOT IN (SELECT idArticulo FROM 3005_articulosBoletin WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia.") ORDER BY tituloArticulo";
		$arrRegistro=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistro).'}';
	}
	
	function registrarArticulosBoletin()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrArticulo=explode(",",$obj->listArticulo);
		foreach($arrArticulo as $iA)
		{
			$consulta[$x]="INSERT INTO 3005_articulosBoletin(idFormulario,idReferencia,idArticulo,idSeccion)
							VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$iA.",".$obj->idSeccion.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerPublicacionesBoletin()
	{
		global $con;
		$arrPublicaciones=array();
		
		$listaBoletines=-1;
		$consulta="";
		if(isset($_SESSION["idUsr"])&&($_SESSION["idUsr"]!="-1"))
		{
			$consulta="SELECT idPadre FROM _960_ambitoAplicacion WHERE idOpcion in(2)";
		}
		else
		{
			$consulta="SELECT idPadre FROM _960_ambitoAplicacion WHERE idOpcion=1";
		}
		
		$listaBoletines=$con->obtenerListaValores($consulta);
		if($listaBoletines=="")
			$listaBoletines=-1;
		
		$consulta="SELECT v.volumenTxt,anoVolumen,tituloPublicacion,fechaInicio,numeroBoletin,id__960_tablaDinamica FROM _960_tablaDinamica b
					,_959_tablaDinamica v WHERE id__960_tablaDinamica in (".$listaBoletines.") and b.idEstado=2 AND v.id__959_tablaDinamica=b.volumen ORDER BY anoVolumen,volumenTxt,numeroBoletin";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(!isset($arrPublicaciones[$fila[1]]))
				$arrPublicaciones[$fila[1]]=array();
			$obj["volumen"]=$fila[0];
			$obj["anoVolumen"]=$fila[1];
			$obj["tituloPublicacion"]=$fila[2];
			$obj["fechaInicio"]=$fila[3];
			$obj["numeroBoletin"]=$fila[4];
			$obj["idBoletin"]=$fila[5];
			array_push($arrPublicaciones[$fila[1]],$obj);
		}
		$cadPublicaciones="";
		if(sizeof($arrPublicaciones))
		{
			foreach($arrPublicaciones as $anio=>$resto)
			{
				$arrHijos="";
				foreach($resto as $publicacion)
				{
					$lblText="(".date("Y-m-d",strtotime($publicacion["fechaInicio"])).') Volumen '.$publicacion["volumen"].', Número '.$publicacion["numeroBoletin"].' <b>'.cv($publicacion["tituloPublicacion"])."</b>";
					$lblText2="(".date("Y-m-d",strtotime($publicacion["fechaInicio"])).') Volumen '.$publicacion["volumen"].', Número '.$publicacion["numeroBoletin"].' '.cv($publicacion["tituloPublicacion"])."";
					$oP='{"tipo":"2","link":"'.generarLinkBoletin($publicacion["idBoletin"]).'","icon":"../images/icon_documents.gif","id":"'.$publicacion["idBoletin"].'","text":"<span title=\''.$lblText2.'\' alt=\''.$lblText2.'\'>'.$lblText.'</span>","leaf":true}';
					if($arrHijos=="")
						$arrHijos=$oP;
					else
						$arrHijos.=",".$oP;
				}
				$oPublicacion='{"icon":"../images/bullet_green.png","id":"a'.$anio.'","text":"<b>Año:</b> '.$anio.'","tipo":"1","leaf":false,children:['.$arrHijos.']}';
				if($cadPublicaciones=="")
					$cadPublicaciones=$oPublicacion;
				else
					$cadPublicaciones.=",".$oPublicacion;
			}
		}
		echo '['.$cadPublicaciones.']';
	}
	
	function obtenerDatosDictamenSocioEconomico()
	{
		global $con;

		$idRegistro=$_POST["idRegistro"];
		$dictamen="Sin estudio socio-económico";
		$comentarios="N/A";
		$porcentajeSugerido="N/A";
		
		$consulta="SELECT dictamenFinal,comentarios,porcentajeSugerido FROM _966_tablaDinamica WHERE idReferencia=".$idRegistro;
		$fDictamen=$con->obtenerPrimeraFila($consulta);
		if($fDictamen)
		{
			$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=8124 AND valor=".$fDictamen[0];
			$dictamen=$con->obtenerValor($consulta);
			$comentarios=$fDictamen[1];
			$porcentajeSugerido=removerCerosDerecha($fDictamen[2])." %";
		}
		echo '1|{"dictamen":"'.cv($dictamen).'","comentarios":"'.cv($comentarios).'","porcentaje":"'.cv($porcentajeSugerido).'"}';
		
	}
	
	function obtenerCondicionesBeca()
	{
		global $con;
		
		$arCondiciones="";
		$numReg=0;
		$idUsuario=$_POST["idUsuario"];
		$idInstancia=$_POST["idInstancia"];
		$tipoBeca=$_POST["tipoBeca"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		if($idRegistro!=-1)
		{
			$consulta="SELECT radTipoBeca FROM _946_tablaDinamica WHERE id__946_tablaDinamica=".$idRegistro;
			$tipoBeca=$con->obtenerValor($consulta);
		}
		$cadObjParam='{"idInstanciaPlan":"","idUsuario":"","tipoBeca":""}';
		$objParam=json_decode($cadObjParam);
		$cache=NULL;
		$objParam->idInstanciaPlan=$idInstancia;
		$objParam->idUsuario=$idUsuario;
		$objParam->tipoBeca=$tipoBeca;
		$cadObjParam='{"param1":null}';
		$objParam1=json_decode($cadObjParam);
		$objParam1->param1=$objParam;
		$consulta="SELECT id__962_gridCondicionesBeca,etiqueta,funcionValidadora FROM _962_gridCondicionesBeca WHERE idReferencia=".$tipoBeca." AND requeridoNuevaSolicitud=1 ORDER BY etiqueta";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$valor=1;
			$etiquetaComplementaria="";
			if($fila[2]!="")
			{
				$resultado=resolverExpresionCalculoPHP($fila[2],$objParam1,$cache);
	
				
				$valor=0;
				$etiquetaComplementaria="";
				if(gettype($resultado)!="array")
				{
					$valor=removerComillasLimite($resultado);
				}
				else
				{
					$valor=$resultado["valor"];
					$etiquetaComplementaria=$resultado["complementario"];
				}
			}
			$obj='{"idCondicion":"'.$fila[0].'","condicion":"'.$fila[1].'","resultado":"'.$valor.'","comentarios":"'.$etiquetaComplementaria.'"}';
			if($arCondiciones=="")
				$arCondiciones=$obj;
			else
				$arCondiciones.=",".$obj;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arCondiciones.']}';
	}
	
	function generarCFDINominaPrimaria()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		if(generarCFDINomina($idRegistro))	
		{
			echo "1|";	
		}
	}
	
	function reGenerarCFDINominaPrimaria()
	{
		global $con;
		$listaComprobantes=$_POST["listaComprobantes"];
		$arrEmpleados=explode(",",$listaComprobantes);
		foreach($arrEmpleados as $e)
		{
			$oNomina=generarXMLNominaPrimaria($e);	
			$consulta="SELECT idComprobante FROM _1012_gridNomina WHERE id__1012_gridNomina=".$e;
			$idComprobante=$con->obtenerValor($consulta);
			$c=new cNominaCFDI();
			$c->setObjNomina($oNomina);
			$XML=$c->generarXML();
			//$idFactura=$c->registrarXML(3,$e);
			$c->actualizarXMLComprobante($idComprobante);
			$c->generarSelloDigital($idComprobante);
		
			
			$XML=$c->cargarComprobanteXML($idComprobante);

			$resultado=$c->validarXMLNomina($XML);
			if($resultado["errores"])
			{
				$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idComprobante;
				$con->ejecutarConsulta($consulta);
			}
			else
			{
				$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=1,comentarios='' WHERE idFolio=".$idComprobante;
				$con->ejecutarConsulta($consulta);
			}
			
		}
		echo "1|";
	}
	
	function registrarBolsaTrabajoUsuario()
	{
		global $con;	
		$consulta="SELECT id__956_tablaDinamica FROM _956_tablaDinamica WHERE tipoUsuario=1 AND idUsuario=".$_SESSION["idUsr"];
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$consulta="INSERT INTO _956_tablaDinamica(notificacionActiva,tipoUsuario,idUsuario) VALUES(1,1,".$_SESSION["idUsr"].")";
		else
			$consulta="update _956_tablaDinamica set notificacionActiva=1 where id__956_tablaDinamica=".$idRegistro;
		eC($consulta);
		
	}
	
	function registrarBoletinUsuario()
	{
		global $con;	
		$consulta="SELECT id__1032_tablaDinamica FROM _1032_tablaDinamica WHERE tipoUsuario=1 AND idUsuario=".$_SESSION["idUsr"];
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$consulta="INSERT INTO _1032_tablaDinamica(notificacionActiva,tipoUsuario,idUsuario) VALUES(1,1,".$_SESSION["idUsr"].")";
		else
			$consulta="update _1032_tablaDinamica set notificacionActiva=1 where id__1032_tablaDinamica=".$idRegistro;
		eC($consulta);
		
	}
	
	function registrarEnvioEtapaReinscripcion()
	{
		global $con;
		$idEtapa=$_POST["idEtapa"];
		$idRegistro=$_POST["idRegistro"];	
		cambiarEtapaFormulario(910,$idRegistro,$idEtapa);
		echo "1|";
	}
	
	function bloquearEmpleadoNominaPrimaria()
	{
		global $con;
		$listaUsuarios="";
		$consulta="SELECT DISTINCT numEmpleado FROM _1012_gridNomina g,703_relacionFoliosCFDI r WHERE r.idFolio=g.idComprobante  AND r.situacion=2";
		$listaUsuarios=$con->obtenerListaValores($consulta);
		if($listaUsuarios=="")
			$listaUsuarios=-1;
		$consulta="UPDATE 802_identifica SET bloqueadoNomina=1 WHERE idUsuario IN(".$listaUsuarios.")";
		
		eC($consulta);
	}
	
	function verificarSituacionJustificacionFalta()
	{
		global $con;	
		$idFalta=$_POST["idFalta"];
		$consulta="SELECT pagado,(SELECT folioNomina FROM 672_nominasEjecutadas WHERE idNomina=c.idNomina)  FROM 4559_controlDeFalta c WHERE idFalta =".$idFalta;
		$fControl=$con->obtenerPrimeraFila($consulta);
		
		echo "1|".$fControl[0]."|".$fControl[1];
		
	}
	
	function obtenerConvocatoriasHorarioDisponible()
	{
		global $con;
		$lConvocatoria=$_POST["lConvocatoria"];
		$consulta="
					SELECT id__1025_tablaDinamica AS idConvocatoria,c.descripcion,nombreCiclo AS cicloEscolar,periodoDel AS fechaInicial,periodoAl AS fechaFinal,
					(
					
					SELECT GROUP_CONCAT(CONCAT(g.nombrePeriodo,' (',pe.txtDescripcion,')')) FROM _1025_periodoEscolar p,_464_gridPeriodos g,_464_tablaDinamica pe  
					WHERE idPadre=c.id__1025_tablaDinamica AND g.id__464_gridPeriodos=p.idOpcion AND pe.id__464_tablaDinamica=g.idReferencia ORDER BY pe.txtDescripcion,g.nombrePeriodo
					
					) AS periodosConsiderados  
					FROM _1025_tablaDinamica c,4526_ciclosEscolares ce
					WHERE c.id__1025_tablaDinamica IN (".$lConvocatoria.") AND  ce.idCiclo=c.cicloEscolar ORDER BY nombreCiclo,fechaInicial";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
					
	}
	
	function registrarParticipacionConvocatoriaDiponibilidadHorario()
	{
		global $con;	
		$iC=$_POST["c"];
		$idUsuario=$_POST["iU"];
		$cA=1;
		if(isset($_POST["cA"]))
			$cA=$_POST["cA"];
		$consulta="INSERT INTO _1026_tablaDinamica(fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,idUsuario,idConvocatoria,condicionesAceptadas)
					VALUES('".date("Y-m-d H:i:s")."',".$idUsuario.",1,'".$_SESSION["codigoUnidad"]."','".$_SESSION["codigoInstitucion"]."',".$_SESSION["idUsr"].",".$iC.",".$cA.")";
		
		if($con->ejecutarConsulta($consulta))
		{
			$idRegistro=$con->obtenerUltimoID();
			
			$consulta="UPDATE _1026_tablaDinamica SET codigo=".$idRegistro." WHERE id__1026_tablaDinamica=".$idRegistro;
			$con->ejecutarConsulta($consulta);
			echo "1|".$idRegistro	;
		}
		
	}
	
	
	function obtenerPeriodosConvocatoriaDH()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idConvocatoria,idUsuario FROM _1026_tablaDinamica WHERE id__1026_tablaDinamica=".$idRegistro;
		$fDatosConvocatoria=$con->obtenerPrimeraFila($consulta);
		$idConvocatoria=$fDatosConvocatoria[0];
		if($idConvocatoria=="")
			$idConvocatoria=-1;
		
		
		$consulta="SELECT cicloEscolar FROM _1025_tablaDinamica WHERE id__1025_tablaDinamica=".$idConvocatoria;
		$ciclo=$con->obtenerValor($consulta);
		
		
		$registros="";
		$numReg=0;
		$consulta="SELECT g.id__464_gridPeriodos,CONCAT(g.nombrePeriodo,' (',pe.txtDescripcion,')') FROM _1025_periodoEscolar p,
					_464_gridPeriodos g,_464_tablaDinamica pe WHERE 
					idPadre=".$idConvocatoria." AND g.id__464_gridPeriodos=p.idOpcion AND pe.id__464_tablaDinamica=g.idReferencia ORDER BY pe.txtDescripcion,g.nombrePeriodo";
					
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT COUNT(*) FROM 4065_disponibilidadHorario WHERE ciclo=".$ciclo." AND idPeriodo=".$fila[0]." AND idUsuario=".$fDatosConvocatoria[1]." AND  idReferencia<>".$idRegistro;//idFormulario=1026 AND
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$consulta="SELECT COUNT(*) FROM 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$idRegistro." AND idPeriodo=".$fila[0]." and idDiaSemana=0 and horaInicio='00:00:00' and horaFin='00:00:00'";
				$nDatos=$con->obtenerValor($consulta);
				if($nDatos==0)
				{
					$consulta="SELECT COUNT(*) FROM 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$idRegistro." AND idPeriodo=".$fila[0];
					$nDatos=$con->obtenerValor($consulta);
				}
				else
					$nDatos=-1;
				$o='{"idPeriodo":"'.$fila[0].'","situacion":"'.$nDatos.'","periodo":"'.cv($fila[1]).'"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
				$numReg++;
			}
		}
			
			
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';	
			
	}
	
	
	function obtenerListadoHorarioDisponibilidad()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idPeriodo=$_POST["idPeriodo"];
		
		$rO=$_POST["rO"];

		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		
		$listEventos="-1";
		$consulta="SELECT idHorarioDisponible,idDiaSemana,horaInicio,horaFin from 4065_disponibilidadHorario where idFormulario=".$idFormulario." and idReferencia= ".$idReferencia." and idPeriodo=".$idPeriodo;
		
		$res=$con->obtenerFilas($consulta);
		$arrEvento="";
		while($fila=mysql_fetch_row($res))
		{
			$btnEliminar="";
			if($rO=="0")
				$btnEliminar="<a href=\'javascript:removerBloque(\\\"".bE($fila[0])."\\\")\'><img src=\'../images/delete.png\' title=\'Remover bloque\' alt=\'Remover bloque\'/></a>";
			$todoDia='false';	
			$fechaIni=$arrFechas[$fila[1]];	
			$tEvento=0;
			if(strpos($fila[0],"_")!==false)
				$tEvento=1;
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "1",
						  "title": "Disponible '.$btnEliminar.'",
						  "start": "'.$fechaIni.' '.$fila[2].'",
						  "end": "'.$fechaIni.' '.$fila[3].'",
						  "ad": '.$todoDia.',
						  "rO":'.$rO.'
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;	
		}

		echo '{"evts":['.$arrEvento.']}';
	}
	
	function modificarHorarioDisponibilidad()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idPeriodo=$obj->idPeriodo;
		$idFormulario=$obj->idFormulario;
		$idReferencia=$obj->idReferencia;
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		
		$idDiaSemana=date("N",$fechaInicio);
		if($idDiaSemana==7)
			$idDiaSemana=0;
		$consulta="select horaInicio,horaFin from 4065_disponibilidadHorario where idReferencia=".$idReferencia." and idFormulario=".$idFormulario." and idPeriodo=".$idPeriodo.
					" and idDiaSemana=".$idDiaSemana." and idHorarioDisponible<>".$obj->idRegistro;
		$resHorario=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resHorario))
		{
			if(colisionaTiempo(date("H:i",$fechaInicio),date("H:i",$fechaFin),$fila[0],$fila[1]))
			{
				echo "<br><b>El intervalo de tiempo deseado colisiona con otro intervalo de tiempo ingresado anteriormente</b>";
				return;
			}	
		}
		$consulta="update 4065_disponibilidadHorario set idDiaSemana=".$idDiaSemana.",horaInicio='".date("H:i",$fechaInicio)."',horaFin='".date("H:i",$fechaFin)."' where idHorarioDisponible=".$obj->idRegistro;
		eC($consulta);
	}
	
	function obtenerConvocatoriasDisponibilidadActivas()
	{
		
		global $con;
		$idUsuario=$_POST["iU"];
		$listaConv="";
		$numReg=0;
		
		$consulta="SELECT idConvocatoria FROM _1026_tablaDinamica WHERE idUsuario=".$idUsuario;
		$listConvocatoria=$con->obtenerListaValores($consulta);
		if($listConvocatoria=="")
			$listConvocatoria=-1;
		$fechaActual=date("Y-m-d");
		$consulta="SELECT id__1025_tablaDinamica,cicloEscolar FROM _1025_tablaDinamica WHERE idEstado=2 AND '".$fechaActual."'>=periodoDel AND '".$fechaActual."'<=periodoAl and id__1025_tablaDinamica not in (".$listConvocatoria.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$ciclo=$fila[1];
			$consulta="SELECT idOpcion FROM _1025_periodoEscolar WHERE idPadre=".$fila[0];
			$rPeriodo=$con->obtenerFilas($consulta);
			$nPeriodos=$con->filasAfectadas;
			while($fPerido=mysql_fetch_row($rPeriodo))
			{
				$idPeriodo=$fPerido[0];
				$consulta="SELECT id__1025_tablaDinamica FROM _1025_tablaDinamica c,_1025_periodoEscolar p WHERE c.cicloEscolar=".$ciclo." AND p.idOpcion=".$idPeriodo." AND p.idPadre=c.id__1025_tablaDinamica";
				$lConvocatoriasSimilares=$con->obtenerListaValores($consulta);
				if($lConvocatoriasSimilares=="")
					$lConvocatoriasSimilares=-1;
				
				$consulta="SELECT COUNT(*) FROM _1026_tablaDinamica WHERE idConvocatoria in (".$lConvocatoriasSimilares.") AND idUsuario=".$idUsuario;
				$nRegConv=$con->obtenerValor($consulta);
				if($nRegConv>0)
					$nPeriodos--;
				else
				{
					if($ciclo<=10)	
					{
						$consulta="SELECT COUNT(*) FROM 4065_disponibilidadHorario WHERE ciclo=".$ciclo." AND idPeriodo=".$idPeriodo." AND idUsuario=".$idUsuario;
						$nRegConv=$con->obtenerValor($consulta);
						if($nRegConv>0)
							$nPeriodos--;
					}
				}
				
			}
			
			if($nPeriodos>0)
			{
				if($listaConv=="")
					$listaConv=$fila[0];
				else
					$listaConv.=",".$fila[0];
				$numReg++;	
			}
		}
		
		echo "1|".$numReg."|".$listaConv;
	}
	
	function liberarDiponibilidadHorario()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		if(cambiarEtapaFormulario(1026,$idRegistro,2))
			echo "1|";
			
	}
	
	function marcarNODisponibilidadHorario()
	{
		
		global $con;
		
		$iP=$_POST["iP"];
		$iR=$_POST["iR"];
		$ciclo=$_POST["c"];
		$idUsuario=$_POST["iU"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="DELETE FROM 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$iR." AND idPeriodo=".$iP;
		$x++;
		$consulta[$x]="INSERT INTO 4065_disponibilidadHorario(ciclo,idUsuario,idDiaSemana,horaInicio,horaFin,tipo,idFormulario,idReferencia,idPeriodo)
					VALUES(".$ciclo.",".$idUsuario.",0,'00:00:00','00:00:00',1,1026,".$iR.",".$iP.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
			
	}
	
	function removerMarcaNODisponibilidadHorario()
	{
		global $con;
		
		$iP=$_POST["iP"];
		$iR=$_POST["iR"];
		
		$consulta="DELETE FROM 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$iR." AND idPeriodo=".$iP." AND idDiaSemana=0 AND horaInicio='00:00:00' AND horaFin='00:00:00'";
		eC($consulta);
		
	}
	
	function clonarDisponibilidadHorarioPeriodo()
	{
		global $con;
		$idOrigen=$_POST["idOrigen"];
		$idDestino=$_POST["idDestino"];
		$iR=$_POST["iR"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="DELETE FROM 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$iR." AND idPeriodo=".$idDestino;
		$x++;
		$consulta[$x]="INSERT INTO 4065_disponibilidadHorario(ciclo,idUsuario,idDiaSemana,horaInicio,horaFin,tipo,idFormulario,idReferencia,idPeriodo)
						select ciclo,idUsuario,idDiaSemana,horaInicio,horaFin,tipo,idFormulario,idReferencia,'".$idDestino."' as idPeriodo 
						from 4065_disponibilidadHorario WHERE idFormulario=1026 AND idReferencia=".$iR." AND idPeriodo=".$idOrigen;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function obtenerMateriasPeriodosConvocatoriaDH()
	{
		global $con;
		$criterioMaterias=0;//0 Materias periodo global, 1 materias ofertadas, 2 materias periodo individual
		$idRegistro=$_POST["idRegistro"];
		$idUsuario=$_POST["idUsuario"];
		$accion=$_POST["accion"];
		
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$consulta="SELECT idConvocatoria,idUsuario FROM _1026_tablaDinamica WHERE id__1026_tablaDinamica=".$idRegistro;
		$fDatosConvocatoria=$con->obtenerPrimeraFila($consulta);
		$idConvocatoria=$fDatosConvocatoria[0];
		if($idConvocatoria=="")
			$idConvocatoria=-1;
		
		
		$consulta="SELECT cicloEscolar FROM _1025_tablaDinamica WHERE id__1025_tablaDinamica=".$idConvocatoria;
		$ciclo=$con->obtenerValor($consulta);
		$arrPlanesEstudio=array();
		
		$registros="";
		$numReg=0;
		if($accion==1)
		{
			$qComplementario="";
			
			$consulta="select idMateria FROM _1026_materiasInteresProfesor WHERE idUsuario=".$idUsuario." AND idConvocatoria=".$idConvocatoria;
			$listMateria=$con->obtenerListaValores($consulta);
			if($listMateria=="")
				$listMateria=-1;
				
			$consulta="SELECT DISTINCT nombreMateria FROM 4502_Materias where  ".$cadCondWhere." and idMateria not in (".$listMateria.")";
			if($criterioMaterias!=0)
			{
				$consultaAux="SELECT pe.idOpcion FROM _1025_periodoEscolar pe WHERE pe.idPadre=".$idConvocatoria;
				$listaPeriodos=$con->obtenerListaValores($consultaAux);
				if($listaPeriodos=="")
					$listaPeriodos=-1;
				
				$arrMateriasOfertadas=array();	
				$consultaAux="SELECT distinct i.idPlanEstudio,e.idGrado FROM 4546_estructuraPeriodo e,4513_instanciaPlanEstudio i WHERE e.idCiclo=".$ciclo." AND e.idPeriodo IN (".$listaPeriodos.")
							and i.idInstanciaPlanEstudio=e.idInstanciaPlanEstudio";	
				
				$resPlanes=$con->obtenerFilas($consultaAux);
				while($fPlanes=mysql_fetch_row($resPlanes))
				{
					$consultaAux="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$fPlanes[0]." AND codigoPadre IS NULL AND idUnidad=".$fPlanes[1]." AND tipoUnidad=3";
					$rUnidades=$con->obtenerFilas($consultaAux);
					while($fUnidades=mysql_fetch_row($rUnidades))
					{
						$consultaAux="SELECT idUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$fPlanes[0]." AND codigoPadre LIKE '".$fUnidades[0]."%' AND tipoUnidad=1";
						$resMat=$con->obtenerFilas($consultaAux);
						while($fMat=mysql_fetch_row($resMat))
						{
							$arrMateriasOfertadas[$fMat[0]]=0;
						}
					}
				}
				
				foreach($arrMateriasOfertadas as $iMat=>$resto)	
				{
					if($qComplementario=="")
						$qComplementario=$iMat;
					else
						$qComplementario.=",".$iMat;
				}
				if($qComplementario=="")
					$qComplementario=-1;
				$qComplementario=" and idMateria in (".$qComplementario.")";
			}
			
			$consulta.=$qComplementario." order by nombreMateria";

			$resMaterias=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($resMaterias))
			{
				$idMateria="";
				
				$lblPlanEstudio="";
				$consulta="SELECT idMateria,idPlanEstudio FROM 4502_Materias WHERE nombreMateria='".$fila[0]."'";
				$rMaterias=$con->obtenerFilas($consulta);
				while($fMateria=mysql_fetch_row($rMaterias))
				{
					$oM="['".$fMateria[0]."','".$fMateria[1]."']";
					if($idMateria=="")
						$idMateria=$oM;
					else
						$idMateria.=",".$oM;
						
					if(isset($arrPlanesEstudio[$fMateria[1]]))	
						$plan=$arrPlanesEstudio[$fMateria[1]];
					else
					{
						$consulta="SELECT nombre FROM 4500_planEstudio WHERE idPlanEstudio=".$fMateria[1];	
						$plan=$con->obtenerValor($consulta);
					}
					
						
					if($lblPlanEstudio=="")	
						$lblPlanEstudio=$plan;
					else
						$lblPlanEstudio.=",".$plan;
						
						
				}
				
				$o='{"criterioMaterias":"'.$criterioMaterias.'","idMateria":"['.$idMateria.']","lblPlanEstudio":"'.cv($lblPlanEstudio).'","nombreMateria":"'.cv($fila[0]).'","idPeriodo":"0","lblPeriodo":"Periodo &uacute;nico"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
				$numReg++;
				
			}
			
			
			
		}
		else
		{
			
			$arrMateriasInteres=array();
			$consulta="SELECT idMateria,idPlanEstudio FROM _1026_materiasInteresProfesor WHERE idConvocatoria=".$idConvocatoria." AND idUsuario=".$idUsuario;

			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				if(isset($arrPlanesEstudio[$fila[1]]))	
					$plan=$arrPlanesEstudio[$fila[1]];
				else
				{
					$consulta="SELECT nombre FROM 4500_planEstudio WHERE idPlanEstudio=".$fila[1];	
					$plan=$con->obtenerValor($consulta);
				}
				
				$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$fila[0];
				$nMateria=$con->obtenerValor($consulta);
				
				if(!isset($arrMateriasInteres[$nMateria]))
				{
					$arrMateriasInteres[$nMateria]=array();
					$arrMateriasInteres[$nMateria]["idMateria"]="";
					$arrMateriasInteres[$nMateria]["planEstudio"]="";
					
				}
				
				$iMateria="['".$fila[0]."','".$fila[1]."']";
				if($arrMateriasInteres[$nMateria]["idMateria"]=="")
				{
					$arrMateriasInteres[$nMateria]["idMateria"]=$iMateria;
				}
				else
				{
					$arrMateriasInteres[$nMateria]["idMateria"].=",".$iMateria;
				}
				
				if($arrMateriasInteres[$nMateria]["planEstudio"]=="")
					$arrMateriasInteres[$nMateria]["planEstudio"]=$plan;
				else
					$arrMateriasInteres[$nMateria]["planEstudio"].=",".$plan;
				
				
			}
			
			ksort($arrMateriasInteres);
			
			
			foreach($arrMateriasInteres as $m=>$resto)
			{
				$o='{"criterioMaterias":"0","idMateria":"['.$resto["idMateria"].']","lblPlanEstudio":"'.cv($resto["planEstudio"]).'","nombreMateria":"'.cv($m).'","idPeriodo":"0","lblPeriodo":"Periodo &uacute;nico"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
				$numReg++;
			}
			
			

		}
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';	
			
	}
	
	function registrarMateriasInteresProfesor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		$query="SELECT idConvocatoria,idUsuario FROM _1026_tablaDinamica WHERE id__1026_tablaDinamica=".$obj->idConvocatoria;
		$fDatosConvocatoria=$con->obtenerPrimeraFila($query);
		$idConvocatoria=$fDatosConvocatoria[0];
		if($idConvocatoria=="")
			$idConvocatoria=-1;
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrMaterias as $m)
		{
			$consulta[$x]="INSERT INTO _1026_materiasInteresProfesor(idConvocatoria,idUsuario,idPlanEstudio,idMateria,criterioMaterias) 
						VALUES(".$idConvocatoria.",".$obj->idUsuario.",".$m->iPlan.",".$m->iMateria.",".$m->criterio.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
		
		
	}
	
	function removerMateriasInteresProfesor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		$query="SELECT idConvocatoria,idUsuario FROM _1026_tablaDinamica WHERE id__1026_tablaDinamica=".$obj->idConvocatoria;
		$fDatosConvocatoria=$con->obtenerPrimeraFila($query);
		$idConvocatoria=$fDatosConvocatoria[0];
		if($idConvocatoria=="")
			$idConvocatoria=-1;
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrMaterias as $m)
		{
			$consulta[$x]="DELETE FROM _1026_materiasInteresProfesor WHERE idMateria=".$m->iMateria." AND idUsuario=".$obj->idUsuario." AND idConvocatoria=".$idConvocatoria;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
		
		
	}
	
	function obtenerconvocatoriosDisponibilidadHorarioDisponibles()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idCiclo=$_POST["idCiclo"];
		$consulta="SELECT cp.id__1026_tablaDinamica AS idRegistro,cv.codigo,c.nombreciclo,cv.descripcion,cp.idEstado AS situacion,
										(
										SELECT GROUP_CONCAT(distinct CONCAT(g.nombrePeriodo,' (',pe.txtDescripcion,')')) FROM 4065_disponibilidadHorario d,_464_gridPeriodos g,_464_tablaDinamica pe  
										WHERE d.idReferencia=cp.id__1026_tablaDinamica and g.id__464_gridPeriodos=d.idPeriodo and d.idFormulario=1026 AND pe.id__464_tablaDinamica=g.idReferencia
										 ORDER BY pe.txtDescripcion,g.nombrePeriodo
										)AS periodosConsiderados,
										cv.periodoDel,cv.periodoAl 
										FROM _1025_tablaDinamica cv ,4526_ciclosEscolares c,_1026_tablaDinamica cp WHERE c.idCiclo=cv.cicloescolar 
										AND cv.id__1025_tablaDinamica=cp.idConvocatoria AND cp.idUsuario=".$idUsuario;
		if($idCiclo!=0)									
		{
			$consulta.=" and c.idCiclo=".$idCiclo;
		}
		
		$consulta.=" order by c.idCiclo, cp.id__1026_tablaDinamica";
		
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
												
	}
	
	function obtenerPeriodosDisponibilidadHorarioDisponibles()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idCiclo=$_POST["idCiclo"];
		
		$nReg=0;
		$arrRegistros="";
		$o="";
		$consulta=	"SELECT g.id__464_gridPeriodos,g.nombrePeriodo,pe.txtDescripcion FROM _464_gridPeriodos g,_464_tablaDinamica pe WHERE 
					 pe.id__464_tablaDinamica=g.idReferencia ORDER BY pe.txtDescripcion,g.nombrePeriodo";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comentarios="";
			$consulta="SELECT idReferencia FROM 4065_disponibilidadHorario WHERE ciclo=".$idCiclo." AND idPeriodo=".$fila[0]." AND idUsuario=".$idUsuario;

			$idRegistro=$con->obtenerValor($consulta);
			if($idRegistro!="")
			{
				$consulta="SELECT idConvocatoria FROM _1026_tablaDinamica WHERE id__1026_tablaDinamica=".$idRegistro;

				$idConvocatoria=$con->obtenerValor($consulta);
				if($idConvocatoria!="")
				{
					$consulta="SELECT codigo FROM _1025_tablaDinamica WHERE id__1025_tablaDinamica=".$idConvocatoria;
					$folio=$con->obtenerValor($consulta);
				}
				else
				{
					$consulta="SELECT codigo FROM _390_tablaDinamica WHERE id__390_tablaDinamica=".$idRegistro;
					$folio=$con->obtenerValor($consulta);	
					$folio.=" (Versi&oacute;n 1 de convocatoria)";
				}
				$comentarios="El periodo ya ha sido registrado por el profesor en la convocatoria con folio: <b>".$folio."</b>";
			}
			$o='{"tipoPeriodicidad":"'.cv($fila[2]).'","idPeriodo":"'.$fila[0].'","periodo":"'.cv($fila[1]).'","situacion":"'.(($idRegistro=="")?'1':'0').'","comentarios":"'.cv($comentarios).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nReg++;
			
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarConvocatoriaDisponibilidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO _1025_tablaDinamica(fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,cicloEscolar,descripcion,periodoDel,periodoAl) 
						VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",0,'".$_SESSION["codigoInstitucion"]."','".$_SESSION["codigoInstitucion"]."',".$obj->idCiclo.
						",'Apetura de convocatoria individual para el profesor: ".cv(obtenerNombreUsuario($obj->idUsuario))."','".date("Y-m-d")."','".date("Y-m-d")."')";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$arrPeriodos=explode(",",$obj->periodos);
		foreach($arrPeriodos as $p)
		{
			$consulta[$x]="INSERT INTO _1025_periodoEscolar(idPadre,idOpcion) VALUES(@idRegistro,".$p.")";
			$x++;
		}
		
		$query="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$obj->idUsuario;
		$institucion=$con->obtenerValor($query);
		
		$consulta[$x]="INSERT INTO _1026_tablaDinamica(fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,idUsuario,idConvocatoria) 
					values('".date("Y-m-d H:i:s")."',".$obj->idUsuario.",".$obj->idEstado.",'".$institucion."','".$institucion."',".$obj->idUsuario.",@idRegistro)";
		$x++;
		$consulta[$x]="set @idRegistroUsuario:=(select last_insert_id())";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idRegistro=$con->obtenerValor($query);
			
			$query="select @idRegistroUsuario";
			$idRegistroUsuario=$con->obtenerValor($query);

			asignarFolioRegistro(1025,$idRegistro);
			asignarFolioRegistro(1026,$idRegistroUsuario);
			echo "1|".$idRegistroUsuario;
		}
	}
	
	function aperturarConvocatoriaDisponibilidad()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="UPDATE _1026_tablaDinamica SET idEstado=1 WHERE id__1026_tablaDinamica=".$idRegistro;
		eC($consulta);
		
	}
	
	function obtenerConfiguracionAperturaGradosPeriodo()
	{
		global $con;
		$nReg=0;
		$arrRegistros="";
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT g.idGrado,g.leyendaGrado FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4501_Grado g WHERE idInstanciaPlanEstudio=".$idInstancia." AND p.idPlanEstudio=i.idPlanEstudio
					AND g.idPlanEstudio=p.idPlanEstudio ORDER BY g.ordenGrado";
					
		$rGrado=$con->obtenerFilas($consulta);
		while($fGrado=mysql_fetch_row($rGrado))			
		{
			$o='{"idGrado":"'.$fGrado[0].'","grado":"'.cv($fGrado[1]).'"';
			$consulta="SELECT g.id__464_gridPeriodos,g.nombrePeriodo FROM 4513_instanciaPlanEstudio i,_464_gridPeriodos g WHERE i.idInstanciaPlanEstudio=".$idInstancia." AND g.idReferencia=i.idPeriodicidad ORDER BY prioridad";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$valor='';
				$consulta="SELECT valor FROM 4500_aperturaGradosPeriodo WHERE idInstanciaPlanEstudio=".$idInstancia." AND idGrado=".$fGrado[0]." AND idPeriodo=".$fila[0];
				$valor=$con->obtenerValor($consulta);
				
				if(($valor=="")||($valor==0))
					$valor='false';
				else
					$valor='true';
					
				$o.=',"p_'.$fila[0].'":'.$valor;
			}
			$o.='}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nReg++;
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarConfiguracionGradoPeriodo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT idRegistro FROM 4500_aperturaGradosPeriodo WHERE idInstanciaPlanEstudio=".$obj->idInstancia." AND idPeriodo=".$obj->idPeriodo." AND idGrado=".$obj->idGrado;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		if($idRegistro==-1)
		{
			$consulta="INSERT INTO 4500_aperturaGradosPeriodo(idPeriodo,idGrado,idInstanciaPlanEstudio,valor) VALUES(".$obj->idPeriodo.",".$obj->idGrado.",".$obj->idInstancia.",".$obj->valor.")";
		}
		else
		{
			$consulta="update 4500_aperturaGradosPeriodo set valor=".$obj->valor." where idRegistro=".$idRegistro;
		}
		
		eC($consulta);
	}
	
	function obtenerMateriasDisponiblesInteres()
	{
		global $con;
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		if($idInstanciaPlan=="")
			$idInstanciaPlan=-1;
		$iC=$_POST["iC"];
		$p=$_POST["p"];
		$c=$_POST["c"];
		$iU=$_POST["iU"];
		
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$arrRegistros="";
		
		
		
		$arrGrados=obtenerGradosAperturaCiclo($c,$p,$idInstanciaPlan);

		
		foreach($arrGrados as $g=>$leyenda)
		{
			
			$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND (codigoPadre='' or codigoPadre is null) AND  idUnidad=".$g." AND tipoUnidad=3";
			$codigoUnidad=$con->obtenerValor($consulta);
			if($codigoUnidad=="")
				$codigoUnidad=-1;
			
			
			$arrMaterias="";
			$consulta="SELECT idUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND codigoPadre LIKE '".$codigoUnidad."%' and tipoUnidad=1";

			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$consulta="SELECT COUNT(*) FROM _1026_materiasInteresProfesor WHERE instanciaPlanesEstudio=".$idInstanciaPlan." AND idMateria=".$fila[0]." AND idConvocatoria=".$iC." and idUsuario=".$iU;


				$nMat=$con->obtenerValor($consulta);
				if($nMat==0)
				{
					$consulta="SELECT concat('[',cveMateria,'] ',nombreMateria) FROM  4502_Materias WHERE idMateria=".$fila[0]." order by cveMateria";
					$materia=$con->obtenerValor($consulta);
					
					$chk='{"icon":"../images/s.gif","checked":false,"id":"'.$fila[0].'","text":"'.cv($materia).'",leaf:true}';
					if($arrMaterias=="")
						$arrMaterias=$chk;
					else
						$arrMaterias.=",".$chk;
				}
			}
				
			$o='{"expanded":true,"icon":"../images/s.gif","id":"g_'.$g.'","text":"<b>'.cv($leyenda).'</b>",leaf:'.($arrMaterias==""?"true":"false").',children:['.$arrMaterias.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;

		}
		
		echo "[".$arrRegistros."]";
		
	}
	
	function registrarMateriasInteresConvocatoria()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$arrMaterias=explode(",",$obj->arrMaterias);
		
		$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$obj->idInstancia;
		$idPlanEstudio=$con->obtenerValor($query);
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		foreach($arrMaterias as $m)
		{
			$consulta[$x]="INSERT INTO  _1026_materiasInteresProfesor(idConvocatoria,idUsuario,idPlanEstudio,idMateria,instanciaPlanesEstudio,criterioMaterias) 
							VALUES(".$obj->idConvocatoria.",".$obj->idUsuario.",".$idPlanEstudio.",".$m.",".$obj->idInstancia.",0)";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerMateriasInteresConvocatoria()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$arrMaterias=$obj->arrMaterias;
		
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		foreach($arrMaterias as $m)
		{
			$consulta[$x]="delete from  _1026_materiasInteresProfesor where idConvocatoria=".$obj->idConvocatoria." and idUsuario=".$obj->idUsuario.
							" and idMateria=".$m->idMateria." and instanciaPlanesEstudio=".$m->idInstancia; 

			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function obtenerMateriasInteresConvocatoria()
	{
		global $con;
		$iC=$_POST["iC"];
		$iU=$_POST["iU"];
		$sL=$_POST["sL"];
		$arrMaterias=array();
		$consulta="SELECT * FROM _1026_materiasInteresProfesor WHERE idConvocatoria=".$iC." AND idUsuario=".$iU;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT concat('[',cveMateria,'] ',nombreMateria) FROM  4502_Materias WHERE idMateria=".$fila[4]." order by cveMateria";
			$materia=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fila[6];
			$idPlanEstudio=$con->obtenerValor($consulta);
			
				
			$consulta="SELECT i.idInstanciaPlanEstudio,i.nombrePlanEstudios,n.txtNivelEstudio,pe.nombreProgramaEducativo,p.nivelPlanEstudio,p.idProgramaEducativo
					FROM 4513_instanciaPlanEstudio i,4500_planEstudio p, _401_tablaDinamica n,4500_programasEducativos pe
					WHERE p.idPlanEstudio=i.idPlanEstudio AND  i.situacion=1 AND n.id__401_tablaDinamica=p.nivelPlanEstudio 
					AND pe.idProgramaEducativo=p.idProgramaEducativo and i.idInstanciaPlanEstudio=".$fila[6];		
		
			$fInstancia=$con->obtenerPrimeraFila($consulta);
			$llaveNivel=$fInstancia[2]."_".$fInstancia[4];
			if(!isset($arrMaterias[$llaveNivel]))
				$arrMaterias[$llaveNivel]=array();
			$llavePrograma=$fInstancia[3]."_".$fInstancia[5];
			if(!isset($arrMaterias[$llaveNivel][$llavePrograma]))
				$arrMaterias[$llaveNivel][$llavePrograma]=array();
			$llaveInstancia=$fInstancia[1]."_".$fInstancia[0];
			if(!isset($arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia]))
				$arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia]=array();				
			$idGrado=obtenerGradoMateria($fila[4],$idPlanEstudio);
			
			
			$consulta="SELECT idGrado,leyendaGrado,ordenGrado FROM 4501_Grado WHERE idGrado=".$idGrado;

			$fGrado=$con->obtenerPrimeraFila($consulta);
			
			$llaveGrado=$fGrado[2]."_".$fGrado[1]."_".$fGrado[0];
			$o["idMateria"]=$fila[4];
			$o["lblMateria"]=$materia;
			if(!isset($arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia][$llaveGrado]))
				$arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia][$llaveGrado]=array();
			array_push($arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia][$llaveGrado],$o);
			ksort($arrMaterias[$llaveNivel][$llavePrograma][$llaveInstancia][$llaveGrado]);
			
			
			
			
		}
		
		$arrRegistros="";
		foreach($arrMaterias as $nivelEducativo=>$arrFacultades)
		{
			$aNivelEducativo=explode("_",$nivelEducativo);
			
			
			$arrCadFacultades="";
			foreach($arrFacultades as $facultad=>$arrPlanesEstudio)
			{
				$aFacultad=explode("_",$facultad);
				$arrCadPlanes="";
				foreach($arrPlanesEstudio as $planEstudio=>$arrGrados)
				{
					$aPlan=explode("_",$planEstudio);
					
					$arrCadGrados="";
					
					
					foreach($arrGrados as $grado=>$arrMaterias)
					{
						$aGrado=explode("_",$grado);
						$arrCadMaterias="";
						
						foreach($arrMaterias as $objMateria)
						{
							$oMateria='{'.(($sL==1)?"":"checked:false,").'"idInstancia":"'.$aPlan[1].'", "expanded":true,"icon":"../images/s.gif","id":"'.$objMateria["idMateria"].'","text":"'.cv($objMateria["lblMateria"]).'",leaf:true}';
							if($arrCadMaterias=="")
								$arrCadMaterias=$oMateria;
							else
								$arrCadMaterias.=",".$oMateria;
						}
						
						
						$oGrado='{"expanded":true,"icon":"../images/s.gif","id":"4_'.$aGrado[2].'","text":"<b>Grado:  <span style=\'color:#900\'>'.cv($aGrado[1]).'</span></b>",leaf:false,children:['.$arrCadMaterias.']}';
						if($arrCadGrados=="")
							$arrCadGrados=$oGrado;
						else
							$arrCadGrados.=",".$oGrado;
					}
					
					
					$oPlan='{"expanded":true,"icon":"../images/s.gif","id":"3_'.$aPlan[1].'","text":"<b>Plan de estudios: </b>'.cv($aPlan[0]).'",leaf:false,children:['.$arrCadGrados.']}';
					if($arrCadPlanes=="")
						$arrCadPlanes=$oPlan;
					else
						$arrCadPlanes.=",".$oPlan;
				}
				
				
				
				$oFacultad='{"expanded":true,"icon":"../images/s.gif","id":"2_'.$aFacultad[1].'","text":"<b>Facultad / &aacute;rea acad&eacute;mica: </b>'.cv($aFacultad[0]).'",leaf:false,children:['.$arrCadPlanes.']}';
				if($arrCadFacultades=="")
					$arrCadFacultades=$oFacultad;
				else
					$arrCadFacultades.=",".$oFacultad;
				
			}
			
			
			$oNivel='{"expanded":true,"icon":"../images/s.gif","id":"1_'.$aNivelEducativo[1].'","text":"<b>Nivel educativo: </b>'.cv($aNivelEducativo[0]).'",leaf:false,children:['.$arrCadFacultades.']}';
			if($arrRegistros=="")
				$arrRegistros=$oNivel;
			else
				$arrRegistros.=",".$oNivel;
			
			
			
		}
		
		
		echo "[".$arrRegistros."]";
	}
	
	function registrarAceptacionCondiciones()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$contenido=$_POST["contenido"];
		
		$query="SELECT idRegistro FROM _1025_contenidosCondiciones WHERE contenido='".str_replace(" ","+",$contenido)."'";
		$idRegistroContenido=$con->obtenerValor($query);
		
			
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($idRegistroContenido=="")
		{
			$consulta[$x]="INSERT INTO _1025_contenidosCondiciones(contenido) VALUES('".str_replace(" ","+",$contenido)."')";
			$x++;
			$consulta[$x]="set @idTextoCondiciones:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$consulta[$x]="set @idTextoCondiciones:=".$idRegistroContenido;
			$x++;
		}
		$consulta[$x]="UPDATE _1026_tablaDinamica SET condicionesAceptadas=1,idTextoCondiciones=@idTextoCondiciones WHERE id__1026_tablaDinamica=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
	}
	
	function obtenerListadoDisponibilidadHorario()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		
		$idPeriodo=$_POST["idPeriodo"];
		$adscripcion="";
		if(isset($_POST["adscripcion"]))
			$adscripcion=$_POST["adscripcion"];
		
		$cadCondWhere=" 1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);	
		$consulta="";
		
		
		$consulta="SELECT distinct r.id__1026_tablaDinamica AS idRegistro,u.idUsuario,u.nombre,r.idEstado,c.cicloEscolar, 
					CONCAT(txtDescripcion,': ',nombrePeriodo) as periodo
					FROM _1026_tablaDinamica r,_1025_tablaDinamica c,800_usuarios u,4065_disponibilidadHorario d, 
					_464_gridPeriodos g,_464_tablaDinamica t
					WHERE r.idConvocatoria=c.id__1025_tablaDinamica AND u.idUsuario=r.idUsuario and d.idFormulario=1026 
					and d.idReferencia=r.id__1026_tablaDinamica and g.idReferencia=t.id__464_tablaDinamica and 
					g.id__464_gridPeriodos=	d.idPeriodo and
					".$cadCondWhere;
		if($adscripcion!="")
		{
			$consulta="SELECT distinct r.id__1026_tablaDinamica AS idRegistro,u.idUsuario,u.nombre,r.idEstado,c.cicloEscolar, 
					CONCAT(txtDescripcion,': ',nombrePeriodo) as periodo
					FROM _1026_tablaDinamica r,_1025_tablaDinamica c,800_usuarios u,4065_disponibilidadHorario d, 
					_464_gridPeriodos g,_464_tablaDinamica t,801_adscripcion ads
					WHERE r.idConvocatoria=c.id__1025_tablaDinamica AND u.idUsuario=r.idUsuario and d.idFormulario=1026 
					and d.idReferencia=r.id__1026_tablaDinamica and g.idReferencia=t.id__464_tablaDinamica and 
					g.id__464_gridPeriodos=	d.idPeriodo and ads.idusuario=u.idUsuario and ads.Institucion='".$adscripcion."' and 
					".$cadCondWhere;
		}
												
		if($idCiclo!=0)			
		{
			$consulta.=" and c.cicloEscolar=".$idCiclo;
		}
					
		if($idPeriodo!=0)			
		{
			$consulta.=" and g.id__464_gridPeriodos=".$idPeriodo;
		}
		
		
		$consulta.=" ORDER BY u.nombre";
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
					
	}
	
	
	function obtenerSesionesVirtuales()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$sL=$_POST["sL"];
		$fechaActual=date("Y-m-d");
		
		$consulta="SELECT grupo FROM _1032_tablaDinamica WHERE id__1032_tablaDinamica=".$idReferencia;
		$grupo=$con->obtenerValor($consulta);
		
		
		$duracionHora=obtenenerDuracionHoraGrupo($grupo);
		if($duracionHora=="")
			$duracionHora=60;
		
		
		$nReg=0;
		$arrRegistros="";
		
		if($sL==0)
		{
			$consulta="SELECT *  FROM 4530_sesiones WHERE idGrupo=".$grupo." and fechaSesion<='".$fechaActual.
					"' ORDER BY fechaSesion,horario";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$sesionSel="false";
				$fSesion=strtotime($fila[2]);
				$aHorario=explode(" - ",$fila[3]);
	//			$hInicial=strtotime($aHorario[0]);
	//			$hFin=strtotime($aHorario[1]);
				
				$diferencia=obtenerDiferenciaHoraMinutos($aHorario[0],$aHorario[1]);	
				$nHoras=$diferencia/$duracionHora;
				
				
				
				if(((date("w",$fSesion)>=1)&&(date("w",$fSesion)<=5))&&($nHoras==1))
				{
					
					$consulta="SELECT COUNT(*) FROM 3009_sesionesVirtuales WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and fecha='".$fila[2]."' and horaInicial='".$aHorario[0]."'";
					$tReg=$con->obtenerValor($consulta);
					$sesionSel=($tReg==0)?"false":"true";
					
					$permiteSeleccionar="true";
					
					
					$comentariosAdicionales="";
					$consulta="SELECT idReferencia FROM 3009_sesionesVirtuales 	WHERE idGrupo=".$grupo." AND fecha='".$fila[2]."' AND horaInicial='".$aHorario[0].
								"' AND idFormulario<>".$idFormulario." AND idReferencia<>".$idReferencia;
					
					$refAsociado=$con->obtenerValor($consulta);
					if($refAsociado!="")
					{
						$consulta="SELECT codigo,idEstado FROM _1032_tablaDinamica WHERE id__1032_tablaDinamica=".$idReferencia;
						$fRegFolio=$con->obtenerPrimeraFila($consulta);
						
						
						if(($fRegFolio)&&($fRegFolio[1]==2))
						{
							$permiteSeleccionar="false";
							$comentariosAdicionales="La sesi&oacute;n ya ha sido considerada en la solicitud: <b>".$fRegFolio[0]."</b> la cual ya fu&eacute; aplicada";
							
						}
						
					}

					if($comentariosAdicionales=="")
					{
						$consulta="SELECT  idFalta,pagado,idNomina,estadoFalta FROM 4559_controlDeFalta WHERE idGrupo=".$grupo." AND fechaFalta='".$fila[2]."' AND horaInicial='".$aHorario[0]."' ";

						$fFalta=$con->obtenerPrimeraFila($consulta);
						if(($fFalta[2]!="") && ($fFalta[2]!="0"))
						{
							$consulta="SELECT etapa,folioNomina FROM 672_nominasEjecutadas WHERE idNomina=".$fFalta[2];
							
							$fNomina=$con->obtenerPrimeraFila($consulta);
							$etapaNomina=$fNomina[0];
							if(($etapaNomina!=1)&&($etapaNomina!=200))
							{
								$permiteSeleccionar="false";
								$comentariosAdicionales="<img src='../images/exclamation.png' width='14' height='14'> La sesi&oacute;n  ha sido considerada como falta en la nomina: <b>".$fNomina[1]."</b> la cual NO puede ser modificada";
							}
							
						}
						
					}
					$nReg++;
					$o='{"idSesion":"'.$fila[0].'","noSesion":"'.$fila[1].'","fechaSesion":"'.$fila[2].'","horario":"'.$fila[3].'","sesionSel":'.$sesionSel.',"comentariosAdicionales":"'.cv($comentariosAdicionales).'","permiteSeleccionar":'.$permiteSeleccionar.'}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			}
		}
		else
		{
			
			$consulta="SELECT idRegistro,noSesion,fecha,CONCAT(horaInicial,' - ',horaFinal) AS horario FROM 3009_sesionesVirtuales WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$nReg++;
				$o='{"idSesion":"'.$fila[0].'","noSesion":"'.$fila[1].'","fechaSesion":"'.$fila[2].'","horario":"'.$fila[3].'","sesionSel":true,"comentariosAdicionales":"","permiteSeleccionar":false}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarSesionesVirtuales()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT grupo FROM _1032_tablaDinamica WHERE id__1032_tablaDinamica=".$obj->idReferencia;
		$grupo=$con->obtenerValor($consulta);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="DELETE FROM 3009_sesionesVirtuales WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$x++;
		
		foreach($obj->arrSesiones as $o)
		{
			$query[$x]="INSERT INTO 3009_sesionesVirtuales(idGrupo,noSesion,fecha,horaInicial,horaFinal,idFormulario,idReferencia) VALUES(".$grupo.",".$o->noSesion.
						",'".$o->fecha."','".$o->horaInicial."','".$o->horaFinal."',".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		eB($query);
			
	}
	
	function registrarSituacionDocumentoInscripcionV2()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$arrDocumentos="";
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrDocumentos as $d)
		{
			
			if($d->fechaLimiteEntrega=="")
				$d->fechaLimiteEntrega="NULL";
			else
				$d->fechaLimiteEntrega="'".$d->fechaLimiteEntrega."'";
			if($d->documento==-1)
				$d->documento="";
			
			
			
			$idDocumento="NULL";
			
			if($d->documento!="")
			{
				if(strpos($d->documento,"_a_a__")===false)
				{
					
					$arrDocumento=explode("|",$d->documento);
					$idDocumento=$arrDocumento[1];
				}
				else
				{
					$arrDocumento=explode("|",$d->documento);

					$idDocumento=registrarDocumentoServidor($arrDocumento[1],$arrDocumento[0]);
					$d->documento=$idDocumento;
				}
			}
				
			$consulta="SELECT idEvaluacionDocumento FROM 4598_evaluacionDocumentosInscripcion WHERE idFormulario=".$d->idFormulario." AND idReferencia=".$d->idRegistro." AND idDocumento=".$d->idDocumento;	
			$idEvaluacionDocumento=$con->obtenerValor($consulta);
			if($idEvaluacionDocumento=="")
			{
				$query[$x]="INSERT INTO 4598_evaluacionDocumentosInscripcion(idFormulario,idReferencia,idDocumento,situacionDocumento,documentoDigital,fechaLimiteEntregaDocumento,observaciones)
							VALUES(".$d->idFormulario.",".$d->idRegistro.",".$d->idDocumento.",".$d->situacion.",".$idDocumento.",".$d->fechaLimiteEntrega.",'".cv($d->observaciones)."')";
				$x++;
			
			}
			else
			{
				$query[$x]="UPDATE 4598_evaluacionDocumentosInscripcion SET situacionDocumento=".$d->situacion.",documentoDigital=".$idDocumento.",fechaLimiteEntregaDocumento=".$d->fechaLimiteEntrega.
						",observaciones='".cv($d->observaciones)."' WHERE  idEvaluacionDocumento=".$idEvaluacionDocumento;
				$x++;
			}
			
			
			$oDoc='{"tipoDocumento":"'.$d->idDocumento.'","nombreDocumento":"'.$arrDocumento[0].'","idDocumento":"'.$idDocumento.'"}';
			if($arrDocumentos=="")
				$arrDocumentos=$oDoc;
			else
				$arrDocumentos.=",".$oDoc;
			
		}
		
		$query[$x]="commit";
		$x++;
		
		

		if($con->ejecutarBloque($query))
		{
			echo '1|{"arrDocumentos":['.$arrDocumentos.']}';
		}
		
	}
	
?>