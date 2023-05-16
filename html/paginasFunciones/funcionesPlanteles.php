<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include("funcionesClonacionReportesThot.php");
	include_once("diccionarioTerminos.php");
	include_once("funcionesNeotrai.php");
	include_once("funcionesActores.php");
	include_once("funcionesValidacionGrupos.php");
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	
	switch($funcion)
	{
		case 1:
			crearInstanciaPlanEstudios();
		break;
		case 2:
			removerInstanciaPlanEstudio();
		break;
		case 3:
			obtenerEstructuraCurricular();
		break;
		case 4:
			modificarClaveMateria();
		break;
		case 5:
			obtenerGruposPlanEstudio();
		break;
		case 6:
			obtenerListadoAlumnosGrupo();
		break;
		case 7:
			crearGrupoMateria();
		break;
		case 8:
			removerGrupoMateria();
		break;
		case 9:
			obtenerAreasFisicas();
		break;
		case 10:
			agregarAreaFisica();
		break;
		case 11:	
			removerArea();
		break;
		case 12:
			obtenerListadoAlumnosAsistenciaGrupo();
		break;
		case 13:
			obtenerMaterialDidacticoProfesor();
		break;
		case 14:
			removerMaterialDidactico();
		break;
		case 15:
			modificarMaterialDidactico();
		break;
		case 16:
			guardarCategoriaMaterialDidactico();
		break;
		case 17:
			removeCategoriarMaterialDidactico();
		break;
		case 18:
			obtenerMaterialDidacticoSesion();
		break;
		case 19:
			guardarConfiguracionSesion();
		break;
		case 20:
			obtenerMaterialDidacticoCurso();
		break;
		case 21:
			cambiarAlumnosGrupos();
		break;
		case 22:
			obtenerGruposMaestros();
		break;
		case 23:
			guardarGrupoMaestro();
		break;
		case 24:
			removerGrupoMaestro();
		break;
		case 25:
			obtenerEvaluacionGrupo();
		break;
		case 26:
			asentarCalificacionAlumno();
		break;
		case 27:
			cerrarRegistroCalificaciones();
		break;
		case 28:
			obtenerNombreGrupo();
		break;
		case 29:
			obtenerTransaccionesPendientes();
		break;
		case 30:
			resultadoTransaccion();
		break;
		case 31:
			obtenerHistorialTransacciones();
		break;
		case 32:
			obtenerCompatibilidadAlumnosGrupos();
		break;
		case 33:
			obtenerEstructuraCurricularPeriodo();
		break;
		case 34:
			obtenerGradosDisponiblesEstructuraCurricularPeriodo();
		break;
		case 35:
			guardarGradoAperturaPeriodo();
		break;
		case 36:
			obtenerSituacionAcualPlanEstudio();
		break;
		case 37:
			someterEvaluacionInstancia();
		break;
		case 38:
			obtenerEstructuraCurricularEvaluacion();
		break;
		case 39:
			dictaminarSituacionPlanEstudio();
		break;
		case 40:
			obtenerComentariosDictamen();
		break;
		case 41:
			obtenerEstructuraCurricularGrupos();
		break;
		case 42:
			obtenerDatosSolicitud();
		break;
		case 43:
			dictaminarSolicitudAmes();
		break;
		case 44:
			obtenerHistorialAMES();
		break;
		
		case 45:
			registrarCambioHorario();
		break;
		case 46:
			registrarSolicitudModificacionHorario();
		break;
		case 47:
			obtenerComentariosEvaluacionPlanEstudio();
		break;
		case 48:
			guardarComentarioValidacionPlanEstudio();
		break;
		case 49:
			removerComentarioValidacionPlanEstudio();
		break;
		case 50:
			obteneGruposMaestro();
		break;
		case 51:
			cambiarSituacionComentarioValidacionPlanEstudio();
		break;
		case 52:
			obtenerSituacionDictamenesPlanEstudio();
		break;
		case 53:
			obtenerMateriasGradoDisponibles();
		break;
		case 54:
			guardarReemplazoMateria();
		break;
		case 55:
			cancerarIntercambioMateria();
		break;
		case 56:
			removerGradoEstructuraCurricular();
		break;
		case 57:
			obtenerSiPuedeGenerarContrato();
		break;
		case 58:
			obtenerTiposPeriodicidadPlantel();
		break;
		case 59:
			obtenerFechasPeriodoPlantel();
		break;
		case 60:
			obtenerInstanciasPlanEstudio();
		break;
		case 61:
			obtenerEstructuraCurricularCostoMateria();
		break;
		case 62:
			enviarBajaValidacion();
		break;
		case 63:
			obtenerActualizacionBiometricos();
		break;
		case 64:
			removerProfesorReemplazo();
		break;
		case 65:
			cancelarBajaProfesor();
		break;
		case 66:
			registrarCambioFechaCurso();
		break;
		case 67:
			obtenerCalendarioPeriodos();
		break;
		case 68:
			registrarFechasBloques();
		break;
		case 69:
			reprocesarEventosPlantelModulo();
		break;
		case 70:
			obtenerPlanesEstudioNivel();
		break;
		case 71:
			obtenerModalidadCarrera();
		break;
		case 72:
			obtenerPlantelCarrera();
		break;
		case 73:
			obtenerPeriodosProgramaEducativoPlantel();
		break;
		case 74:
			obtenerPlanesEstudioProgramaEducativoPeriodo();
		break;
		case 75:
			obtenerConceptosIngresoInstanciasPlan();
		break;
		case 76:
			obtenerProgramasEducativoPlantel();
		break;
		case 77:
			obtenerGradosInstanciaPlanEstudio();
		break;
		case 78:
			obtenerMateriasInstanciaPlan();
		break;
		case 79:
			obtenerPlanesEstudioProgramaEducativo();
		break;
		case 80:
			registrarPerfilEquivalencia();
		break;
		case 81:
			registrarEscuela();
		break;
		case 82:
			obtenerPlanesEstudioEscuela();
		break;
		case 83:
			obtenerMateriasPlanEstudio();
		break;
		case 84:
			guardarMateriasPlanEstudio();
		break;
		case 85:
			removerPlanEstudios();
		break;
		case 86:
			obtenerPlanesEstudioEscuelaExterna();
		break;
		case 87:
			obtenerMateriasPlanEstudioExterno();
		break;
		case 88:
			guardarEvaluacionRevalidacion();
		break;
		case 89:
			obtenerMateriasRevalidacionSolicitud();
		break;
		case 90:
			finalizarEvaluacionEquivalencia();
		break;
		case 91:
			obtenerNombreMateriasRequisitosIncumplidos();
		break;
		case 92:
			obtenerFechasProgramasEducativosConvocatoria();
		break;
		case 93:
			obtenerPeriodosRegistroInscripcion();
		break;
		case 94:
			registrarPeriodoRegistroInscripcion();
		break;
		case 95:
			obtenerProgramasAcademicosRegistroInscripcion();
		break;
		case 96:
			registrarProgramasEducativosRegistroInscripcion();
		break;
		case 97:
			obtenerProgramasEducativosInscripcion();
		break;
		case 98:
			obtenerPlanesEstudiosInscripcion();
		break;
		case 99:
			registrarPlanesEstudioInscripcion();
		break;
		case 100:
			obtenerFechasInstanciasPlanEstudioInscripcion();
		break;
		case 101:
			guardarFechasInscripcionRegistroInscripcion();
		break;
		case 102:
			activarDesactivarGrado();
		break;
		case 103:
			removerPlanEstudiosRegistroInscripcion();
		break;
		case 104:
			obtenerTurnosProgramasEducativosModalidad();
		break;
		case 105:
			obtenerFechasProgramaEducativoPortal();
		break;
		case 106:
			obtenerFechasProgramaEducativoPortalNuevoIngreso();
		break;
		case 107:
			designarPlanEstudioReceptorNuevoIngreso();
		break;
		case 108:
			obtenerSolicitudesInscripcion();
		break;
		case 109:
			registrarRespuestaADictamenRevalidacion();
		break;
		case 110:
			obtenerPlanesEstudioProgramaEducativoPeriodoFechas();
		break;
		case 111:
			guardarFechasExamen();
		break;
		case 112:
			guardarSelecionPlanPagosUsuario();
		break;
		case 113:
			obtenerTramitesDisponiblesAlumno();
		break;
		case 114:
			obtenerTipoBecaAspira();
		break;
		case 115:
			obtenerPlanesEstudioPlantel();
		break;
		case 116:
			obtenerPeriodoInscripcionVentanilla();
		break;
		case 117:
			obtenerPlanEstudioInscripcionVentanilla();
		break;
		case 118:
			obtenerRegistrosInscripcion();
		break;
		case 119:
			cancelarRegistroInscripcion();
		break;
		case 120:
			guardarGrupoCompartido();
		break;
		case 121:
			registrarSolicitudMovimientoAME();
		break;
		case 122:
			obtenerSolicitudesAMES();
		break;
		case 123:
			obtenerDetallesSolicitudAMES();
		break;
		case 124:
			obtenerHorarioMateriaPeriodo();
		break;
		case 125:
			obtenerAsignacionesDisponiblesBaja();
		break;
		case 126:
			modificarSituacionAME();
		break;
		case 127:
			removerMovimientoSolicitud();
		break;
		case 128:
			obtenerSolicitudesAMESEsperaAutorizacion();
		break;
		case 129:
			dictaminarSolicitudAmesV2();
		break;
		case 130:
			obtenerGruposBloques();
		break;
		case 131:
			obtenerFechasExamenesGrupo();
		break;
		case 132:
			registrarFechasExamenGrupo();
		break;
		case 133:
			registrarFechasExamenGrupo();
		break;
		case 134:
			obtenerCriteriosEvaluacionPerfilMateria();
		break;
		case 135:
			registrarCriteriosEvaluacionPerfilMateria();
		break;
		case 136:
			guardarPorcentajeCriterioPerfil();
		break;
		case 137:
			modificarPonderacionCriterioEvaluacionPerfil();
		break;
		case 138:
			removerCriterioEvaluacionPerfil();
		break;
		case 139:
			obtenerTipoExamenesPerfilEvaluacionMateriaGrupo();
		break;
		case 140:
			guardarConfiguracionTipoExamenEvaluacionMateriaGrupo();
		break;
		case 141:
			obtenerSolicitudesAMESV2();
		break;
		case 142:
			obtenerPeriodosPlantel();
		break;
		case 143:
			guardarCostoServiciosEstandar();
		break;
		case 144:
			guardarConfiguracionAvanzadaCriterio();
		break;
		case 145:
			obtenerProfesoresCambioHorario();
		break;
		case 146:
			obtenerFechaTerminoGrupoAsignacion();
		break;
		case 147:
			obtenerRegistrosReInscripcion();
		break;
		case 148:
			buscarAlumnoPlantel();
		break;
		case 149:
			buscarInstanciasAlumnoReinscripcion();
		break;
		case 150:
			cancelarRegistroReInscripcion();
		break;
		case 151:
			obtenerPeriodosPlanEstudio();
		break;
		case 152:
			obtenerGradosPeriodosPlanEstudio();
		break;
		case 153:
			obtenerProgramasEducativos();
		break;
		case 154:
			obtenerInstanciaPlanProgramaEductativo();
		break;
		case 155:
			obtenerMateriasPlanEstudioGrado();
		break;
		case 156:
			registrarAsociacionProfesorGrupo();
		break;
		case 157:
			registrarReemplazoProfesorGrupo();
		break;
		case 158:
			obtenerGruposDiponiblesCiclo();
		break;
		case 159:
			obtenerListadoAlumnosGruposCiclo();
		break;
		case 160:
			registrarInscripcionAlumnoGrupo();
		break;
		case 161:
			reactivarAlumno();
		break;		
		case 162:
			registrarBajaAlumnoInscripcion();
		break;
		case 163:
			obtenerListadoAlumnosGruposCicloCalificacion();
		break;
		case 164:
			obtenerMateriasGrupoPadre();
		break;
		case 165:
			registrarCalificacionAlumnoListado();
		break;
		case 166:
			obtenerListadoAlumnosGruposCicloCalificacionRecuperacion();
		break;
		case 167:
			registrarCalificacionAlumnoListadoRecuperacion();
		break;
		case 168:
			obtenerHorasMateriaPlanEstudios();
		break;
		case 169:
			registrarHorasMateriaPlanEstudios();
		break;
		case 170:
			registrarBajaConfiguracionBajaHorasMateria();
		break;
		case 171:
			deshabilitarInstanciaPlanEstudio();
		break;
		case 172:
			obtenerPeriodoCicloPlanEstudio();
		break;
		case 173:
			obtenerEstructurasAcademicasAutorizar();
		break;
		case 174:
			registrarSolicitudAutorizacionestructura();
		break;
		case 175:
			obtenerSolicitudesAutorizacionEstructura();
		break;
		case 176:
			obtenerGradosEstructuraSolicitudesAutorizacion();
		break;
		case 177:
			registrarDictamenGradosSolicitud();
		break;
		case 178:
			actualizarDatosDictamenSolicitud();
		break;
		case 179:
			finalizarDictamenSolicitudAutorizacionEstructura();
		break;
		case 180:
			obtenerComentariosGradosEstructura();
		break;
		case 181:
			modificarEstadoVistoSolicitudAutorizacionEstructura();
		break;
		case 182:
			verificarClaveMateria();
		break;
		case 183:
			obtenerUsuariosAccesoPlanEstudio();
		break;
		case 184:
			removerUsuarioAccesoPlanEstudio();
		break;
		case 185:
			agregarUsuarioAccesoPlanEstudio();
		break;
		case 186:
			obtenerPlanesEstudiosInscripcionV2();
		break;
		case 187:
			obtenerCiclosPeriodoInscripcion();
		break;
		case 188:
			obtenerConfiguracionExamenesPerfil();
		break;
		case 189:
			obtenerTipoExamenDisponible();
		break;
		case 190:
			agregarTipoExamenPerfil();
		break;
		case 191:
			modificarOrdenAplicacionExamenPerfil();
		break;
		case 192:
			modificarConfiguracionAplicacionExamenPerfil();
		break;
		case 193:
			modificarPerfilEvaluacionMateriaInstancia();
		break;
		case 194:
			obtenerPerfilesExamenGrupo();
		break;
		case 195:
			clonarPerfilEvaluacionGrupo();
		break;
		case 196:
			cerrarConfiguracionCriterio();
		break;
			
	}
	
	function crearInstanciaPlanEstudios()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="select * from 4500_planEstudio where idPlanEstudio=".$obj->idPlanEstudio;
		$filaPlan=$con->obtenerPrimeraFila($query);
		$fechaRvoe="NULL";
		if($filaPlan[5]!="")
			$fechaRvoe=$filaPlan[5];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 4513_instanciaPlanEstudio(sede,idPlanEstudio,cveRvoe,fechaRvoe,idModalidad,idTurno,fechaCreacion,responsableCreacion,nombrePlanEstudios,situacion,idEsquemaGrupo,idPeriodicidad,
					tipoEsquemaParcialesGrupo,numParcialesGrupo,tipoEsquemaAsignacionFechasGrupo,numMaxBloquesFechas) 
					VALUES('".$obj->sede."',".$obj->idPlanEstudio.",'".$filaPlan[4]."',".$fechaRvoe.",".$obj->idModalidad.",".$obj->idTurno.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".cv($obj->nombrePlan)."',1,2,".$obj->idPeriodicidad.",
					".$obj->esquemaParcialesGrupo.",".$obj->numParcialesGrupo.",".$obj->esquemaFechasGrupo.",".$obj->numMaxBloques.")";
		$x++;
		$consulta[$x]="set @idInstancia=(select last_insert_id())";
		$x++;
		$consulta[$x]="INSERT INTO 4512_aliasClavesMateria(idInstanciaPlanEstudio,idMateria,sede,cveMateria,noHorasSemana) select @idInstancia,idMateria,'".$obj->sede."' as sede,cveMateria,horasSemana from 4502_Materias where idPlanEstudio=".$obj->idPlanEstudio;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consulta="select @idInstancia";
			$idInstancia=$con->obtenerValor($consulta);
			echo "1|".$idInstancia;
		}
		
	}
	
	function removerInstanciaPlanEstudio()
	{
		global $con;
		global $dic;
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$x=0;
		$consulta="SELECT COUNT(*) FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$nGrupos=$con->obtenerValor($consulta);
		if($nGrupos>0)
		{
			echo "<br>".$dic["planEstudio"]["s"]["el"]." ".strtolower($dic["planEstudio"]["s"]["et"])." tiene registrados ".strtolower($dic["grupo"]["p"]["et"]).", primero debe eliminar éstos";
			return;
		}
		
		$query[$x]="begin";
		$x++;
		$query[$x]="delete FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$x++;
		$query[$x]="DELETE FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerEstructuraCurricular()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$tUnidad=$dic["grado"]["s"]["et"];

		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,descripcion,codigoUnidad,maxOPC,minOPC,g.idGrado FROM 4505_estructuraCurricular e, 4501_Grado g 
		WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";

		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$obj='{expanded:true,clave:"",codigoUnidad:"'.$fila[3].'",id:"'.$fila[0].'",descripcion:"",idUnidad:"'.$fila[6].'",nUnidad:"'.cv($fila[1]).'",text:"<span style=\'color:#030\'><b>'.$fila[1].'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",naturaleza:"",idNaturaleza:"",noCreditos:"N/A",totalHoras:"",horasTSemana:"",horasPSemana:"",horasISemana:"",maxOPC:"'.$fila[4].'",minOPC:"'.$fila[5].'"';
			$hijos=obtenerMateriasHijos($idPlanEstudio,$fila[3],$idInstanciaPlanEstudio);			

			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijos($idPlanEstudio,$codigoPadre,$idInstanciaPlanEstudio)
	{
		global $con;
		global $dic;
		$tUnidad="";
		$arrTemas="";
		$consulta="select * from (SELECT idEstructuraCurricular,
							tipoUnidad,
							n.abreviatura,
							e.naturalezaMateria,
							codigoUnidad,
							(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad limit 0,1),(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad limit 0,1))) as nombreUnidad,
							maxOPC,
							minOPC ,
							e.idUnidad,
							if(tipoUnidad=1,(SELECT cveMateria FROM 4512_aliasClavesMateria WHERE idMateria=e.idUnidad AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." limit 0,1),'') as clave,
						if(tipoUnidad=1,
						(select idCategoriaMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
						(select idCategoria FROM 4508_unidadesContenedora WHERE idUnidadContenedora=e.idUnidad)
						) as idCategoria  FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."') as tmp order by idCategoria,clave";
		$resMateria=$con->obtenerFilas($consulta);
		$tUnidadAgrupadora=0;
		while($fila=mysql_fetch_row($resMateria))
		{
			$noCreditos="";
			$totalHoras="";
			$horasTSemana="";
			$horasPSemana="";
			$horasISemana="";
			$horasSemanales="";
			$icono="s.gif";
			$descripcion="";
			$color="";
			if($fila[1]==1)
			{
				$tUnidad=$dic["materia"]["s"]["et"];
				$consulta="SELECT numeroCredito,horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,horasSemana,idCategoriaMateria FROM 4502_Materias WHERE idMateria=".$fila[8];
				$filaMat=$con->obtenerPrimeraFila($consulta);
				$noCreditos=$filaMat[0];
				$totalHoras=$filaMat[1];
				$horasTSemana=$filaMat[2];
				$horasPSemana=$filaMat[3];
				$horasISemana=$filaMat[4];
				$horasSemanales=$filaMat[5];
				$icono="text_lowercase.png";
				$color="003";
				
				$idCategoria=$filaMat[6];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				$tUnidad="Unidad Contenedora";
				$consulta="select descripcion,tipoUnidad,idCategoria from 4508_unidadesContenedora where idUnidadContenedora=".$fila[8];
				$fUnidad=$con->obtenerPrimeraFila($consulta);
				$descripcion=$fUnidad[0];
				if($fUnidad[1]==1)
					$tUnidad="Unidad Agrupadora";
				$tUnidadAgrupadora=$fUnidad[1];
				$color="000";
				$icono="Icono_3d.gif";
				
				$idCategoria=$fUnidad[2];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			$obj='{tUnidadAgrupadora:"'.$tUnidadAgrupadora.'",clave:"'.$fila[9].'",codigoUnidad:"'.$fila[4].'",id:"'.$fila[0].'",idUnidad:"'.$fila[10].
					'",nUnidad:"'.cv($fila[5]).'",descripcion:"'.cv($descripcion).'",text:"'.$comp.' <span style=\'color:#'.$color.'\'><b>'.cv($fila[5]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"'.$fila[1].'",naturaleza:"'.$fila[2].
					'",idNaturaleza:"'.$fila[3].'",noCreditos:"'.$noCreditos.'",totalHoras:"'.$totalHoras.'",horasTSemana:"'.$horasTSemana.'",horasPSemana:"'.$horasPSemana.'",horasISemana:"'.$horasISemana.
					'","horasSemanales":"'.$horasSemanales.'",maxOPC:"'.$fila[6].'",minOPC:"'.$fila[7].'"';
			$hijos=obtenerMateriasHijos($idPlanEstudio,$fila[4],$idInstanciaPlanEstudio);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return "[".$arrTemas."]";
	}
	
	function modificarClaveMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$nMateria=$_POST["valor"];
		$consulta="update 4512_aliasClavesMateria SET cveMateria='".$nMateria."' WHERE idMateria=".$idMateria." AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		eC($consulta);
		
	}
	
	function obtenerGruposPlanEstudio()
	{
		global $con;
		global $arrDiasSemana;
		
		$idCiclo=0;
		if(isset($_POST["idCiclo"]))
			$idCiclo=$_POST["idCiclo"];
		
		$idPeriodo=0;
		if(isset($_POST["idPeriodo"]))
			$idPeriodo=$_POST["idPeriodo"];
		
		$idInstanciaPlanEstudio=0;
		if(isset($_POST["idInstancia"]))
			$idInstanciaPlanEstudio=$_POST["idInstancia"];
		
		$idMateria=0;
		if(isset($_POST["idMateria"]))
			$idMateria=$_POST["idMateria"];
		
		$fechaActual=date("Y-m-d");
		
		$idRegistroIntercambio=-1;
		if(isset($_POST["idRegistroIntercambio"]))
			$idRegistroIntercambio=$_POST["idRegistroIntercambio"];
		
		$compFiltro="idRegistroReemplazo is null";
		
		$moduloCompartir=false;
		if(isset($_POST["mComparte"]))
			$moduloCompartir=true;
		if($idRegistroIntercambio!=-1)
			$compFiltro="idRegistroReemplazo=".$idRegistroIntercambio;
			
			
		$lGrupos="";
		if(isset($_POST["lGrupos"]))
			$lGrupos=$_POST["lGrupos"];
			
		$consulta="";	
		if($lGrupos=="")	
		{
			$consulta="SELECT idGrupos,nombreGrupo,fechaInicio,fechaFin,situacion,cupoMinimo,cupoMaximo, (IF((SELECT COUNT(*) FROM 4539_gruposCompartidos WHERE idGrupo=g.idGrupos)=0,0,1)) AS compartido,
						noBloqueAsociado,idGrupoPadre,'' as materia  FROM 4520_grupos g WHERE idMateria=".$idMateria." AND idCiclo=".$idCiclo." and g.idPeriodo=".$idPeriodo.
						" AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio."  and g.situacion in (0,1,4) and ".$compFiltro."
						union
						SELECT idGrupos,nombreGrupo,fechaInicio,fechaFin,situacion,cupoMinimo,cupoMaximo,'2' as compartido,noBloqueAsociado,idGrupoPadre,'' as materia FROM 4520_grupos g,4539_gruposCompartidos gc 
						WHERE g.idGrupos=gc.idGrupo and gc.idInstanciaComparte=".$idInstanciaPlanEstudio." 
						and gc.idMateriaEquivalente=".$idMateria." and g.idCiclo=".$idCiclo." and g.idPeriodo=".$idPeriodo;
		}
		else
		{
			$consulta="SELECT idGrupos,nombreGrupo,fechaInicio,fechaFin,g.situacion,cupoMinimo,cupoMaximo, (IF((SELECT COUNT(*) FROM 4539_gruposCompartidos WHERE idGrupo=g.idGrupos)=0,0,1)) AS compartido,
						noBloqueAsociado,idGrupoPadre,m.nombreMateria as materia  FROM 4520_grupos g,4502_Materias m WHERE idGrupos in (".$lGrupos.") and m.idMateria=g.idMateria";
						
		
		}
		$res=$con->obtenerFilas($consulta);
		$arrValores="";
		$nRegistros=$con->filasAfectadas;
		$excluir=false;
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			$excluir=false;
			if($moduloCompartir)
			{
				$consulta="select count(*) from 4539_gruposCompartidos where idGrupo=".$fila[0]." or idGrupoReemplaza=".$fila[0];
				$nComparte=$con->obtenerValor($consulta);
				if($nComparte>0)
					$excluir=true;
			}
			$duracionHora=obtenenerDuracionHoraGrupo($fila[0]);
			
			
			//Reemplazo
			$nSemanas=0;
			$arrDatosMateria=obtenerDatosMateriaHorasGrupo($fila[0]);

			$tHoras=$arrDatosMateria["horaMateriaTotal"];
			$hSemanas=$arrDatosMateria["horasSemana"];
			if($hSemanas!="")
				$nSemanas=ceil($tHoras/$hSemanas);
			else
				$hSemanas=0;
			
			
			//--->	
			//if(!$excluir)
			
			{
				$nSemanasAux=$nSemanas;
				$hSemanasAux=$hSemanas;
				
				$hSemanasAux.=" (".($hSemanasAux*$duracionHora)." min.)";
				
				$tHorasAux=$tHoras;
				$totalHorasSemanasAux=$hSemanas*$duracionHora;
				$observaciones="";
				
				
				$profesorAsignado="";
				$consulta="SELECT * FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$fila[0]." AND fechaAsignacion<=fechaBaja  ORDER BY fechaAsignacion";
				$resProf=$con->obtenerFilas($consulta);
				while($filaProf=mysql_fetch_row($resProf))
				{
					$idProfesor=$filaProf[2];
					$consulta="SELECT idProfesor FROM 4541_asignacionesNoCumplePerfil WHERE idProfesor=".$idProfesor." AND idGrupo=".$fila[0];
					$noCumple=$con->obtenerValor($consulta);
					if($noCumple!="")
					{
						$profesorAsignado.="<img width='13' height='13' src='../images/exclamation.png' title='El profesor asignado, no cumple con el perfil requerido por la materia' alt='El profesor asignado, no cumple con el perfil requerido por la materia'> ";
					}
					$profesorAsignado.="<b>".obtenerNombreUsuario($idProfesor)."</b>";
					$consulta="SELECT descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idElementoPerfilAutor=".$filaProf[3];
					$nAsignacion=$con->obtenerValor($consulta);
					$profesorAsignado.="<br>(".$nAsignacion." del ".date("d/m/Y",strtotime($filaProf[9]))." al ".date("d/m/Y",strtotime($filaProf[10])).")";
					
					$profesorAsignado.="<br><br>";
				}
				

				$horario="";
				$idGrupo=$fila[0];
				$consulta="SELECT COUNT(idUsuario) FROM 4517_alumnosVsMateriaGrupo WHERE idGrupo=".$fila[0];
				$nAlumnos=$con->obtenerValor($consulta);
				
				$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fila[0];
				$fechaInicioH=$con->obtenerValor($consulta);
				
							
				$consulta="SELECT dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$fila[0]." and fechaInicio<=fechaFin order by fechaInicio,horaInicio";
				$resHorario=$con->obtenerFilas($consulta);
				$horario="<table><tr><td width='120'><span class='corpo8_bold'>D&iacute;a</td><td width='280' ><span class='corpo8_bold'>Horario</span></td><td width='300' ><span class='corpo8_bold'>Aula</span></td></tr><tr height='1'><td colspan='3' style='background-color:#900'></td></tr>";
				
				
				while($filaH=mysql_fetch_row($resHorario))
				{
					$aula="";
					if($filaH[3]!="")
					{
						$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaH[3];
						$aula=$con->obtenerValor($consulta);
					}
					else
					{
						$observaciones.="<img src='../images/exclamation.png'>&nbsp;Algunas sesiones de clase no cuentan con un aula asignada<br>";
					}
					$horario.="<tr><td ><span class='letraExt'>".utf8_encode($arrDiasSemana[$filaH[0]])."</td><td class='letraExt' >".date('H:i',strtotime($filaH[1]))." - ".date('H:i',strtotime($filaH[2]))." (Del ".date("d/m/Y",strtotime($filaH[4])).
							" al ".date("d/m/Y",strtotime($filaH[5])).")</td><td ><span class='letraExt'>".$aula."</td></tr>";
				
				}
				
				
				$arrHorarios=array();
				$consulta="SELECT horaInicio,horaFin,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$fila[0]." and horarioCompleto=1";
				$resHorario=$con->obtenerFilas($consulta);
				$minutos=0;
				while($fHorario=mysql_fetch_row($resHorario))
				{
					$llave=$fHorario[2]."_".$fHorario[3];
					
					if(!isset($arrHorarios[$llave]))	
					{
						$arrHorarios[$llave]=0;
					}
					$arrHorarios[$llave]+=obtenerDiferenciaHoraMinutos($fHorario[0],$fHorario[1]);
				}
				
				
				foreach($arrHorarios as $llave=>$minutos)
				{
					$arrFechaPeriodo=explode("_",$llave);
					if($minutos<$totalHorasSemanasAux)
					{
						$observaciones.="<img src='../images/bullet_green.png'> S&oacute;lo se han asignado ".($minutos/$duracionHora).
										" hrs. (".($minutos)." min.) del requerido por la materia por semana (".($totalHorasSemanasAux/$duracionHora).
										" hrs. (".$totalHorasSemanasAux." min.)). Periodo del ".date("d/m/Y",strtotime($arrFechaPeriodo[0]))." al ".date("d/m/Y",strtotime($arrFechaPeriodo[1]))."<br>";
					}	
				}
				
				
				
				$horario.="</table><br>";
				
				switch($fila[7])
				{
					case 1:
						$observaciones.="<img src='../images/bullet_green.png'><b>Actualmente este grupo se comparte con los siguientes planes de estudio:</b><br><br><table width='600'>";
						$consulta="SELECT i.nombrePlanEstudios,m.nombreMateria FROM 4539_gruposCompartidos gc,4502_Materias m,4513_instanciaPlanEstudio i 
								WHERE idGrupo=".$fila[0]." AND m.idMateria=gc.idMateriaEquivalente AND i.idInstanciaPlanEstudio=gc.idInstanciaComparte order by nombrePlanEstudios";
						$resPlan=$con->obtenerFilas($consulta);
						while($filaPlan=mysql_fetch_row($resPlan))
						{
							$observaciones.="<tr><td>".$filaPlan[0]." (Materia: ".$filaPlan[1].")</td></tr>";
						}
						$observaciones.="</table>";
								
					break;
					case 2:
						$observaciones.="<img src='../images/bullet_green.png'><b>Este grupo es compartido por el siguiente plan de estudio:</b><br><br><table width='600'>";
						$consulta="SELECT i.nombrePlanEstudios,m.nombreMateria FROM 4520_grupos gc,4502_Materias m,4513_instanciaPlanEstudio i 
								WHERE gc.idGrupos=".$fila[0]." AND m.idMateria=gc.idMateria AND i.idInstanciaPlanEstudio=gc.idInstanciaPlanEstudio";
						$filaPlan=$con->obtenerPrimeraFila($consulta);
						$observaciones.="<tr><td width='35'></td><td>".$filaPlan[0]." (Materia: ".$filaPlan[1].")</td></tr></table>";
						$observaciones.="<br><b>Actualmente este grupo se comparte con los siguientes planes de estudio:</b><br><br><table width='600'>";
						$consulta="SELECT i.nombrePlanEstudios,m.nombreMateria FROM 4539_gruposCompartidos gc,4502_Materias m,4513_instanciaPlanEstudio i 
								WHERE idGrupo=".$fila[0]." AND m.idMateria=gc.idMateriaEquivalente AND i.idInstanciaPlanEstudio=gc.idInstanciaComparte order by nombrePlanEstudios";
						$resPlan=$con->obtenerFilas($consulta);
						while($filaPlan=mysql_fetch_row($resPlan))
						{
							$observaciones.="<tr><td>".$filaPlan[0]." (Materia: ".$filaPlan[1].")</td></tr>";
						}
						$observaciones.="</table>";
					break;
				}
				
				
				$obj='{"materia":"'.cv($fila[10]).'","noBloqueAsociado":"'.$fila[8].'","compartido":"'.$fila[7].'","observaciones":"'.$observaciones.'","noSemanas":"'.$nSemanasAux.'","horasSemanas":"'.$hSemanasAux.
					'","nAlumnos":"'.$nAlumnos.'","idGrupo":"'.$fila[0].'","nombreGrupo":"'.cv($fila[1].$comp).'","fechaInicio":"'.$fila[2].'","fechaFin":"'.$fila[3].'","situacion":"'.$fila[4].
					'","cupoMinimo":"'.$fila[5].'","cupoMaximo":"'.$fila[6].'","profesorAsignado":"'.$profesorAsignado.'","horario":"'.$horario.'","idGrupoPadre":"'.$fila[9].'"}';
				if($arrValores=="")
					$arrValores=$obj;
				else
					$arrValores.=",".$obj;
				
			}
		}
		if($excluir)
			$excluir=1;
		else
			$excluir=0;
		echo '{"excluir":"'.$excluir.'","numReg":"'.$nRegistros.'","registros":['.$arrValores.']}';
	}
	
	function obtenerListadoAlumnosGrupo()
	{
		global $con;
		global $dic;
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="SELECT idInstanciaPlanEstudio,idMateria,idPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$idInstancia=$fGrupo[0];
		$idMateria=$fGrupo[1];
		$idPlanEstudio=$fGrupo[2];
		if($idInstancia=="")
			$idInstancia=-1;
	
		$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio,i.tipoEsquemaParcialesGrupo,i.numParcialesGrupo,i.tipoEsquemaAsignacionFechasGrupo,i.numMaxBloquesFechas 
				FROM 4513_instanciaPlanEstudio i where idInstanciaPlanEstudio=".$idInstancia;
		$fila=$con->obtenerPrimeraFila($consulta);
		$idReferenciaExamenes=obtenerPerfilExamenesAplica($fila[1],$idInstancia);
		
		$arrRegistros="";
		$numReg=0;
		
		$columnas="";
		$arrCampos="";
		$arrTipoExamen=array();
		
	
		$consulta="SELECT e.idTipoExamen,e.tipoExamen FROM 4622_catalogoTipoExamen e,4625_tiposExamenPerfilEvaluacion t WHERE idPerfil=".$idReferenciaExamenes." AND  e.idTipoExamen=t.idTipoExamen ORDER BY prioridad";
						
		$resExamenes=$con->obtenerFilas($consulta);	
		while($fExamen=mysql_fetch_row($resExamenes))
		{
			$consulta="SELECT idPerfil,calificacionMinimaAprobatoria FROM 4592_configuracionPerfilEvaluacion WHERE  idInstanciaPlanEstudio=".$idInstancia." AND idMateria=".$idMateria." and
				idGrupo in (".$idGrupo.",-1) AND tipoExamen=".$fExamen[0]." AND noExamen=1 order by idGrupo desc";
	
			$fPerfil=$con->obtenerPrimeraFila($consulta);
			
			$calificacionMinima=$fPerfil[1];
			//$fPerfilExamen=obtenerPerfilExamenGrupo($idGrupo,$fExamen[4]);
			$idPerfil=-1;
			$calificacion=0;
			if(!$fPerfil)
			{
				$calificacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fExamen[0],13);//Calificacion
				$idPerfil=obtenerPerfilCriterioEvaluacionGrupo($idGrupo,$fExamen[0]);//Perfil evaluacion
				
				
			}
			else
			{
				$idPerfil=$fPerfil[0];
				$calificacion=$fPerfil[1];
				
			}
			
			
			$compTotal='';
			$idFuncionInterpretacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fExamen[0],8);//FUncion interpretacion
			
			if($idFuncionInterpretacion!=0)
			{
				$consulta="SELECT nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idFuncion=".$idFuncionInterpretacion;
				$tmp=$con->obtenerValor($consulta);
				$compTotal='renderer:function(val)
									{
										var color=\'030\';
										var valPonderado=parseFloat(val)/10;
										if(valPonderado<parseFloat(\''.$calificacionMinima.'\'))
											color=\'F00\';
										var res='.$tmp.'(val);
										return \'<span style=color:#\'+color+\'><b>\'+res+\'</b></span>\';
									},
							';
			}
			else
			{
				$compTotal='renderer:function(val)
									{
										var color=\'030\';
										var valPonderado=parseFloat(val)/10;
										if(valPonderado<parseFloat(\''.$calificacionMinima.'\'))
											color=\'F00\';
										
										return \'<span style=color:#\'+color+\'><b>\'+Ext.util.Format.number(val,"0.00")+\'</b></span>\';
									},
							';
			}
			
			
			$oColumna="{
							header:'".$fExamen[1]."',
							width:110,
							sortable:true,
							css:'text-align:right !important;',".$compTotal."
							dataIndex:'examen_".$fExamen[0]."_1'
						}";	
			$columnas.=",".$oColumna;	
			$arrCampos.=",{name:'examen_".$fExamen[0]."_1'}";		
			$oTipo[0]=$fExamen[0];
			$oTipo[1]=1;
			array_push($arrTipoExamen,$oTipo);		
		}
		
		
		
		
		$arrColumnas="[		new  Ext.grid.RowNumberer(),
						  	{
								header:'Alumno',
								width:270,
								sortable:true,
								dataIndex:'alumno',
								renderer:function(val,meta,registro)
										{
											if(registro.get('situacion')!='1')
												return '<font color=\"#990000\">'+val+'</font>';
											 return val;
										}
							}
							
							".$columnas.",
							{
								header:'Situaci&oacute;n',
								width:70,
								sortable:true,
								align:'center',
							  	css:'text-align:right !important;',
								dataIndex:'situacion',
								renderer:function(val)
										{
											return formatearValorRenderer(arrSituacion,val);
										}
							}
						]";
		
		
		$consulta="SELECT a.idUsuario AS idAlumno,upper(CONCAT(i.Paterno,' ',i.Materno,' ',i.Nom)) AS alumno,a.situacion
				FROM 4517_alumnosVsMateriaGrupo a, 802_identifica i,4520_grupos g
				WHERE   i.idUsuario=a.idUsuario AND a.idGrupo=".$idGrupo." AND a.idGrupo=g.idGrupos order by Paterno,Materno,Nom";

		$res=$con->obtenerFilas($consulta);
		$arrAlumnos="";
		$nAlumnos=0;
		while($fila=mysql_fetch_row($res))
		{
			$arrCal="";
			
			
			if(sizeof($arrTipoExamen)>0)
			{
				
				foreach($arrTipoExamen as $o)
				{
					$calificacion="";
					$consulta="SELECT valor FROM 4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE idGrupo=".$idGrupo." AND idAlumno=".$fila[0]." AND tipoEvaluacion=".$o[0]." AND noEvaluacion=".$o[1]; 
					$calificacion=$con->obtenerValor($consulta);
					$arrCal.=',"examen_'.$o[0].'_'.$o[1].'":"'.$calificacion.'"';
				}
			}
			
			$obj='{"idAlumno":"'.$fila[0].'","alumno":"'.$fila[1].'","situacion":"'.$fila[2].'"'.$arrCal.'}';
			if($arrAlumnos=="")
				$arrAlumnos=$obj;	
			else
				$arrAlumnos.=",".$obj;	
			$nAlumnos++;
		}
		$arrAlumnos="[".$arrAlumnos."]";
		$campos="	{name: 'idAlumno'},
					{name: 'alumno'},
					{name: 'situacion'},
					{name: 'noAsistio'}".$arrCampos;
					
		
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nAlumnos.'","registros":'.($arrAlumnos).',"campos":'.$arrColumnas.'}';
	}

	function crearGrupoMateria()
	{
		global $con;
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$arrIncidencias=array();
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$fechaInicio="NULL";
		if($obj->fechaInicio!="")
			$fechaInicio="'".$obj->fechaInicio."'";
		$consulta="select idGrupos from  4520_grupos where  idMateria=".$obj->idMateria." and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idCiclo=".
				$obj->idCiclo." and idPeriodo=".$obj->idPeriodo." and nombreGrupo='".cv($obj->nombreGrupo)."' and idGrupos<>".$obj->idGrupo;
		$filaGpo=$con->obtenerPrimeraFila($consulta);
		if($filaGpo)
		{
			echo "<br>El nombre del grupo ingresado ya ha sido registrado anteriormente";
			return;
		}
		
		$fechaFin="NULL";
		
		$permiteExcederBloque=false;
		if(isset($obj->permiteExcederBloque)&&$obj->permiteExcederBloque)
			$permiteExcederBloque=$obj->permiteExcederBloque;
		
		
		$consulta="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo." AND  idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio;
		$fFechasPeriodoGrado=$con->obtenerPrimeraFila($consulta);
	
		if(!$fFechasPeriodoGrado)
		{
			echo "<br>NO se han definido las fechas de inicio y fin del periodo";
			return;
		}
		
		
		if($obj->idMateria<0)
		{
			$fechaFin="'".$obj->fechaFin."'";

		}
		else
		{
			$consulta="SELECT i.idPlanEstudio,idEsquemaGrupo,i.nombrePlanEstudios,p.descripcion,i.idInstanciaPlanEstudio,i.sede,tipoEsquemaAsignacionFechasGrupo,numMaxBloquesFechas 
				FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and p.idPlanEstudio=i.idPlanEstudio";
			$filaInstancia=$con->obtenerPrimeraFila($consulta);
			$tEsquemaFecha=$filaInstancia[6];
			if(($obj->idGrupo==-1)||(!cumpleTotalHorasSemanaCurso($obj->idGrupo)))
			{
				if($obj->idGrupo!=-1)
					$fechaFin=obtenerFechaFinCursoGrupo($obj->fechaInicio,$obj->idGrupo,true);
				else
					$fechaFin=obtenerFechaFinCursoMateria($obj->fechaInicio,$obj->idMateria,$obj->idInstanciaPlanEstudio,$obj->idCiclo,$obj->idPeriodo,$obj->noBloque,true);
				
				$fechaFin=str_replace("'","",$fechaFin);				

			}
			else
			{
				$noBloque=0;
				if(($tEsquemaFecha==2)&&(!$permiteExcederBloque))
					$noBloque=$obj->noBloque;	

				$fechaFin=obtenerFechaFinCursoHorario($obj->idGrupo,str_replace("'","",$fechaInicio),null,0,$noBloque);
				
			}
			
			$fechaFin="'".$fechaFin."'";
		}

		if($fechaFin=="'1969-12-30'")
			$fechaFin=$fechaInicio;
		$idGrupoPadre="NULL";
		if(isset($obj->idGrupoPadre))
			$idGrupoPadre=$obj->idGrupoPadre;
		
	
		
		$consulta="SELECT sede,idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio;	
		$fila=$con->obtenerPrimeraFila($consulta);
		if($obj->idGrupo=="-1")
		{
			
			$fechaInicio=removerComillasLimite($fechaInicio);	
			$fechaFin=removerComillasLimite($fechaFin);	
			$query[$x]="INSERT INTO 4520_grupos(idPlanEstudio,Plantel,idMateria,nombreGrupo,cupoMinimo,cupoMaximo,fechaInicio,fechaFin,situacion,idCiclo,idInstanciaPlanEstudio,idGradoCiclo,noBloqueAsociado,idPeriodo,idGrupoPadre) 
						VALUES(".$fila[1].",'".$fila[0]."',".$obj->idMateria.",'".cv($obj->nombreGrupo)."',".$obj->cupoMinimo.",".$obj->cupoMaximo.",'".$fechaInicio."','".$fechaFin."',".$obj->situacion.",".$obj->idCiclo.",".
						$obj->idInstanciaPlanEstudio.",".$obj->idGrupoCiclo.",".$obj->noBloque.",".$obj->idPeriodo.",".$idGrupoPadre.")";
			$x++;
		}
		else
		{
			if(isset($obj->validar)&&($obj->validar!=0))
			{
				$idCiclo=$obj->idGrupoCiclo;
				$idPeriodo=$obj->idPeriodo;
				$idInstancia=$obj->idInstanciaPlanEstudio;
				$idProfesor=obtenerProfesorTitular($obj->idGrupo);
				$consulta="SELECT idHorarioGrupo FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo." ORDER BY dia";
				$idRegistroIgnorar=$con->obtenerListaValores($consulta);
				$consulta="SELECT * FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo." and horarioCompleto=1 ORDER BY dia";
				
				$resGpo=$con->obtenerFilas($consulta);
				while($fGpo=mysql_fetch_row($resGpo))
				{
					$idAula=$fGpo[5];
					$idGrupo=$obj->idGrupo;
					$dia=$fGpo[2];
					$horaInicial=$fGpo[3];
					$horaFinal=$fGpo[4];
					$fechaInicio=$obj->fechaInicio;
					$fechaFin=str_replace("'","",$fechaFin);
					$resultado=validarColisionHoraMismoGrupoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$idRegistroIgnorar);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarTotalHorasAsignadasGrupoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$idRegistroIgnorar);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					if($idProfesor!=-1)
					{
						$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
						$objResp=json_decode($resultado);
						if($objResp->noError!=0)
						{
							array_push($arrIncidencias,$objResp);
						}
						
						$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,$idRegistroIgnorar);
						$objResp=json_decode($resultado);
						if($objResp->noError!=0)
						{
							array_push($arrIncidencias,$objResp);
						}
					}
					
					$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
	
					$resultado=validarHorarioAulaV2($idAula,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,$idRegistroIgnorar);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
				}
				$fechaFin="'".str_replace("'","",$fechaFin)."'";

				if(sizeof($arrIncidencias)>0)
				{
					$arrAux=array();
					foreach($arrIncidencias as $i)
					{
						if(!isset($arrAux[$i->noError]))
							$arrAux[$i->noError]=array();
						array_push($arrAux[$i->noError],$i);
						
					}
					ksort($arrAux);
					
					$arrIncidenciasFinal=array();
					foreach($arrAux as $arr)
					{
						foreach($arr as $i)
							array_push($arrIncidenciasFinal,$i);
					}
					
					echo "1|".generarResolucionArregloErrores($arrIncidenciasFinal);
					return;
				}
			}
			
			$idGrupoPadre="NULL";
			if(isset($obj->idGrupoPadre))
				$idGrupoPadre=$obj->idGrupoPadre;
			

			$fechaInicio=removerComillasLimite($fechaInicio);	
			$fechaFin=removerComillasLimite($fechaFin);	
			
			$query[$x]="update 4520_grupos set idGrupoPadre=".$idGrupoPadre.",idGradoCiclo=".$obj->idGrupoCiclo.",noBloqueAsociado=".$obj->noBloque.",nombreGrupo='".cv($obj->nombreGrupo)."',cupoMinimo=".$obj->cupoMinimo.",cupoMaximo=".
						$obj->cupoMaximo.",fechaInicio='".$fechaInicio."',fechaFin='".$fechaFin."',situacion=".$obj->situacion." where idGrupos=".$obj->idGrupo;

			$x++;
			$query[$x]="update 4519_asignacionProfesorGrupo set fechaAsignacion='".$fechaInicio."',fechaBaja='".$fechaFin."' where fechaAsignacion<=fechaBaja and idGrupo=".$obj->idGrupo;
			$x++;
			$query[$x]="update 4522_horarioGrupo set fechaInicio='".$fechaInicio."',fechaFin='".$fechaFin."'  WHERE idGrupo=".$obj->idGrupo." and fechaInicio<=fechaFin";
			$x++;
			
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			if($obj->idGrupo!=-1)
			{
				
				if(ajustarFechaFinalCurso($obj->idGrupo,!$permiteExcederBloque))
					echo '1|{"permiteContinuar":"1","arrErrores":[]}';
			}
			else
				echo '1|{"permiteContinuar":"1","arrErrores":[]}';
		}

	}
	
	function removerGrupoMateria()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT COUNT(idUsuario) FROM 4517_alumnosVsMateriaGrupo WHERE idGrupo=".$idGrupo;
		$nAlumnos=$con->obtenerValor($consulta);
		if($nAlumnos>0)
		{
			echo "El grupo cuenta con alumnos inscritos";
			return;
		}
		$consulta="delete from 4520_grupos where idGrupos=".$idGrupo;
		eC($consulta);
	}
	
	function obtenerAreasFisicas()
	{
		global $con;
		$arrUnidades="";
		$consulta="select codigoUnidad,unidad from 817_organigrama where codigoUnidad='".$_SESSION["codigoInstitucion"]."'";
		$fila=$con->obtenerPrimeraFila($consulta);
		$objUnidad='{id:"'.$fila[0].'",text:"'.$fila[1].'",claveArea:"",capacidad:"",apartable:"",ancho:"",largo:""';
		$hijos='';
		$hijos=obtenerUnidadesInventarioHijas($fila[0]);																								  
		if($hijos=='')
			$objUnidad.=',leaf:true,icon:"../images/users.png"}';
		else
			$objUnidad.=',children:['.$hijos.'],icon:"../images/user.png"}';
		if($arrUnidades=="")
			$arrUnidades=$objUnidad;
		else
			$arrUnidades.=",".$objUnidad;	
		echo "[".$arrUnidades."]";
	}
	
	function obtenerUnidadesInventarioHijas($codigoPadre)
	{
		global $con;
		$arrUnidades="";
		$consulta="select * from 9309_ubicacionesFisicas where codigoPadre='".$codigoPadre."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$apartable="No";
			if($fila[9]==1)
				$apartable="Sí";
			$asignable="No";
			if($fila[11]==1)
				$asignable="Sí";
			$objUnidad='{asignableCurso:"'.$asignable.'",id:"'.$fila[6].'",text:"'.$fila[1].'",descripcion:"'.cv($fila[2]).'",claveArea:"'.$fila[8].'",capacidad:"'.$fila[3].'",reservable:"'.$fila[9].'",apartable:"'.$apartable.'",ancho:"'.$fila[4].'",largo:"'.$fila[5].'",uiProvider:"col"';
			$hijos='';
			$hijos=obtenerUnidadesInventarioHijas($fila[6]);																								  
			if($hijos=='')
				$objUnidad.=',leaf:true,icon:"../images/users.png"}';
			else
				$objUnidad.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrUnidades=="")
				$arrUnidades=$objUnidad;
			else
				$arrUnidades.=",".$objUnidad;	
		}
		return $arrUnidades;
	}
	
	function agregarAreaFisica()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->capacidad=="")
			$obj->capacidad="NULL";
		if($obj->ancho=="")
			$obj->ancho="NULL";
		if($obj->largo=="")
			$obj->largo="NULL";
		if($obj->idArea=="-1")
		{
			$consulta="SELECT MAX(codigoControl) FROM 9309_ubicacionesFisicas WHERE codigoPadre='".$obj->codigoPadre."'";
			$nodo=$con->obtenerValor($consulta);
			$codigoUnidad="";
			if($nodo=="")
			{
				$codigoUnidad="0001";
			}
			else
			{
				$codigoUnidad=substr($nodo,strlen($nodo)-4);
				$codigoUnidad++;
				$codigoUnidad=str_pad($codigoUnidad,4,"0",STR_PAD_LEFT);
			}
			$nCodigo=$obj->codigoPadre.$codigoUnidad;
			
			$consulta="INSERT INTO 9309_ubicacionesFisicas(claveArea,nombreArea,descripcion,capacidad,anchoMetros,largoMetros,codigoControl,codigoPadre,reservable,codigoInstitucion,asignableCurso)
					VALUES('".cv($obj->clave)."','".cv($obj->area)."','".cv($obj->descripcion)."',".$obj->capacidad.",".$obj->ancho.",".$obj->largo.",'".$nCodigo."','".
					$obj->codigoPadre."',".$obj->reservable.",'".$_SESSION["codigoInstitucion"]."',".$obj->asignableCurso.")";
		}
		else
		{
			$consulta="update 9309_ubicacionesFisicas set claveArea='".cv($obj->clave)."',nombreArea='".cv($obj->area)."',descripcion='".cv($obj->descripcion)."',capacidad=".$obj->capacidad.",
					anchoMetros=".$obj->ancho.",largoMetros=".$obj->largo.",reservable=".$obj->reservable.",asignableCurso=".$obj->asignableCurso." where codigoControl='".$obj->idArea."'";

		}
		eC($consulta);
	}
	
	function removerArea()
	{
		global $con;
		$codigoControl=$_POST["codigoControl"];
		$consulta="delete from 9309_ubicacionesFisicas WHERE (codigoControl='".$codigoControl."' OR codigoControl LIKE '".$codigoControl."%')";	
		eC($consulta);
	}
	
	function obtenerListadoAlumnosAsistenciaGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$consulta="SELECT CONCAT(i.Paterno,' ',i.Materno,' ',i.Nom) AS alumno,situacion,i.idUsuario FROM 4517_alumnosVsMateriaGrupo a, 802_identifica i WHERE i.idUsuario=a.idUsuario AND a.idGrupo=".$idGrupo;
		$arrAlumnos="";
		$resAlumnos=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($resAlumnos))
		{
			$asistencia="false";
			$idAsistencia=-1;
			$idFormulario=-1;
			$idRegistro=-1;
			$consulta="SELECT tipo,idAsistencia,idFormulario,idRegistroJustificacion FROM 4531_listaAsistencia where idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND idAlumno=".$fila[2];
			$filaA=$con->obtenerPrimeraFila($consulta);
			if($filaA)
			{
				if(($filaA[0]=='1')||($filaA[0]=='2'))
					$asistencia="true";
				$idAsistencia=$filaA[1];
				$idFormulario=$filaA[2];
				$idRegistro=$filaA[3];
			}
			$obj='{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","idAlumno":"'.$fila[2].'","alumno":"'.$fila[0].'","situacion":"'.$fila[1].'","asistencia":'.$asistencia.',"tipo":"'.$filaA[0].'","idAsistencia":"'.$idAsistencia.'"}';	
			if($arrAlumnos=="")
				$arrAlumnos=$obj;
			else
				$arrAlumnos.=",".$obj;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.($arrAlumnos).']}';
	}
	
	function obtenerMaterialDidacticoProfesor()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$idUsuario=$_POST["idUsuario"];
		$consulta="SELECT idMaterialDidactico,titulo,fechaSubida,tipo,descripcion,tamano,idCategoria,nomArchivo FROM 4532_materialDidactico WHERE idUsuario=".$idUsuario." and ".$cadCondWhere." order by fechaSubida,titulo limit ".$start.",".$limit;
		$arrReg=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct idMaterialDidactico FROM 4532_materialDidactico WHERE idUsuario=".$idUsuario." order by fechaSubida,titulo" ;
		$con->obtenerFilas($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function removerMaterialDidactico()
	{
		global $con;
		global $baseDir;
		$idMaterial=$_POST["idMaterial"];
		$consulta="SELECT COUNT(*) FROM 4535_sesionsVSMaterialDidactico WHERE idMaterial=".$idMaterial;
		$nMaterial=$con->obtenerValor($consulta);
		if($nMaterial>0)
		{
			echo "El material ya se encuentra referido por al menos una sesi&oacute;n de trabajo, para cuidar la integridad de la informaci&oacute;n el material did&aacute;ctico no puede ser eliminado";
			return;
		}
		$consulta="delete from 4532_materialDidactico where idMaterialDidactico=".$idMaterial;
		if($con->ejecutarConsulta($consulta))
		{
			if(file_exists($baseDir."/materialDidactico/mDidactico_".$idMaterial))
				unlink($baseDir."/materialDidactico/mDidactico_".$idMaterial);
			echo "1|";
		}
		
	}
	
	function modificarMaterialDidactico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE 4532_materialDidactico SET titulo='".cv($obj->titulo)."',descripcion='".cv($obj->descripcion)."',idCategoria=".$obj->idCategoria." WHERE idMaterialDidactico=".$obj->idMaterial;
		eC($consulta);
	}
	
	function guardarCategoriaMaterialDidactico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idCategoria==-1)
			$consulta="INSERT INTO 4533_categoriasMaterialDidactico(nombreCategoria,idUsuario) VALUES('".cv($obj->categoria)."',".$_SESSION["idUsr"].")";
		else
			$consulta="update 4533_categoriasMaterialDidactico set nombreCategoria='".cv($obj->categoria)."' where idCategoria=".$obj->idCategoria;
		if($con->ejecutarConsulta($consulta))	
		{
			if($obj->idCategoria==-1)
				$obj->idCategoria=$con->obtenerUltimoID();
			echo "1|".$obj->idCategoria;
		}
	}
	
	function removeCategoriarMaterialDidactico()
	{
		global $con;
		global $baseDir;
		$idCategoria=$_POST["idCategoria"];
		$consulta="SELECT COUNT(*) FROM 4532_materialDidactico WHERE idCategoria=".$idCategoria;
		$nRegistros=$con->obtenerValor($consulta);
		if($nRegistros>0)
		{
			echo "La categor&iacute;a ya se encuentra referida por al menos una sesi&oacute;n un material did&aacute;ctico,  para cuidar la integridad de la informaci&oacute;n la categor&iacute;a no puede ser eliminada";
			return;
		}
		$consulta="delete from 4533_categoriasMaterialDidactico where idCategoria=".$idCategoria;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		
	}
	
	function obtenerMaterialDidacticoSesion()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$consulta="SELECT idMaterial FROM 4535_sesionsVSMaterialDidactico WHERE idGrupo=".$idGrupo." AND noSesion=".$noSesion;
		$listMaterial=$con->obtenerListaValores($consulta);
		if($listMaterial=="")
			$listMaterial=-1;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		 
		$consulta="SELECT idGaleriaDocumentos as idMaterialDidactico,tituloDocumento as titulo,fechaUltimoCambio as fechaSubida,'' as tipo,descripcion,tamano,idCategoria,nombreDocumento as  nomArchivo 
					FROM 9048_galeriaDocumentos WHERE idGaleriaDocumentos in (".$listMaterial.") and ".$cadCondWhere." order by fechaUltimoCambio,tituloDocumento limit ".$start.",".$limit;
		$arrReg=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct idGaleriaDocumentos FROM 9048_galeriaDocumentos WHERE idGaleriaDocumentos in (".$listMaterial.") order by fechaUltimoCambio,tituloDocumento" ;
		$con->obtenerFilas($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function guardarConfiguracionSesion()
	{
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$listTemas=$obj->listTemas;
		
		$listMaterial=$obj->listMaterial;
		global $con;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 4530_sesiones SET tipoSesion=".$obj->tipoSesion.",comentarios='".cv($obj->comentarios)."' WHERE idGrupo=".$obj->idGrupo." AND noSesion=".$obj->noSesion;
		$x++;
		$consulta[$x]="DELETE FROM 4535_sesionsVSMaterialDidactico WHERE  idGrupo=".$obj->idGrupo." AND noSesion=".$obj->noSesion;
		$x++;
		$consulta[$x]="DELETE FROM 4536_temasVSSesion WHERE  idGrupo=".$obj->idGrupo." AND noSesion=".$obj->noSesion;
		$x++;
		if($listMaterial!="")
		{
			$arrMateriales=explode(",",$listMaterial);
			foreach($arrMateriales as $material)
			{
				$consulta[$x]="INSERT INTO 4535_sesionsVSMaterialDidactico(idGrupo,noSesion,idMaterial,fechaPublicacion) VALUES(".$obj->idGrupo.",".$obj->noSesion.",".$material.",'".date("Y-m-d")."')";
				$x++;
			}
		}
		if($listTemas!="")
		{
			$arrTemas=explode(",",$listTemas);
			foreach($arrTemas as $tema)
			{
				$consulta[$x]="INSERT INTO 4536_temasVSSesion(idGrupo,noSesion,idTema) VALUES(".$obj->idGrupo.",".$obj->noSesion.",".$tema.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerMaterialDidacticoCurso()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$comp="";
		if($noSesion!="-1")
			$comp=" and noSesion=".$noSesion;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$consulta="SELECT distinct idGaleriaDocumentos as idMaterialDidactico,tituloDocumento as titulo,fechaUltimoCambio as fechaPublicacion,'' as tipo,descripcion,tamano,idCategoria,nombreDocumento as  nomArchivo FROM 9048_galeriaDocumentos m,4535_sesionsVSMaterialDidactico s WHERE 
				  m.idGaleriaDocumentos=s.idMaterial and s.idGrupo=".$idGrupo.$comp." and ".$cadCondWhere." order by fechaUltimoCambio,tituloDocumento limit ".$start.",".$limit;
		$arrReg=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct idGaleriaDocumentos as idMaterialDidactico,tituloDocumento as titulo,fechaUltimoCambio as fechaPublicacion,'' as tipo,descripcion,tamano,idCategoria,nombreDocumento as nomArchivo FROM 9048_galeriaDocumentos m,4535_sesionsVSMaterialDidactico s WHERE  
					m.idGaleriaDocumentos=s.idMaterial and s.idGrupo=".$idGrupo." order by fechaUltimoCambio,tituloDocumento" ;
		$con->obtenerFilas($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function cambiarAlumnosGrupos()
	{
		global $con;
		$idGrupoO=$_POST["idGrupoO"];
		$idGrupoD=$_POST["idGrupoD"];
		$listAlumnos=$_POST["listAlumnos"];
		$consulta="UPDATE 4517_alumnosVsMateriaGrupo SET idGrupo=".$idGrupoD." WHERE idUsuario IN  (".$listAlumnos.") AND idGrupo=".$idGrupoO;
		eC($consulta);
	}
	
	function obtenerGruposMaestros()
	{
		global $con;
		$idCiclo=$_POST["ciclo"];
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT idGrupoPadre,nombreGrupo,situacion,cupoMinimo,cupoMaximo FROM 4540_gruposMaestros WHERE idInstanciaPlanEstudio=".$idInstancia." AND idCiclo=".$idCiclo;
		$arrReg=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function guardarGrupoMaestro()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		if($obj->idGrupo=="-1")
		{
			$consulta="select idGrupoPadre from 4540_gruposMaestros where idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio.
					" and idCiclo=".$obj->idCiclo." and idPeriodo=".$obj->idPeriodo." and codigoGrado='".$obj->codigoUnidad."' and nombreGrupo='".cv(trim($obj->nombreGrupo))."'";
			//echo $consulta;
			$idGrupo=$con->obtenerValor($consulta);
			if($idGrupo!="")
			{
				echo "<br>El nombre del grupo ingresado ya ha sido registrado anteriormente";
				return;
			}
			$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE  grado='".$obj->codigoUnidad."' AND idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo." AND idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio;
			$idGradoCiclo=$con->obtenerValor($consulta);
			$consulta="insert into 4540_gruposMaestros(nombreGrupo,situacion,idInstanciaPlanEstudio,cupoMinimo,cupoMaximo,idCiclo,idPeriodo,codigoGrado,idGradoCiclo,aulaDefault) 
						VALUES('".cv(trim($obj->nombreGrupo))."',".$obj->situacion.",".$obj->idInstanciaPlanEstudio.",".$obj->cupoMinimo.",".$obj->cupoMaximo.
						",".$obj->idCiclo.",".$obj->idPeriodo.",'".$obj->codigoUnidad."',".$idGradoCiclo.",".$obj->aulaDefecto.")";
			
		}
		else
		{
			$consulta="select idGrupoPadre from 4540_gruposMaestros where idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio.
					" and idCiclo=".$obj->idCiclo." and idPeriodo=".$obj->idPeriodo." and codigoGrado='".$obj->codigoUnidad."' and nombreGrupo='".cv(trim($obj->nombreGrupo))."' and idGrupoPadre<>".$obj->idGrupo;
			//echo $consulta;
			$idGrupo=$con->obtenerValor($consulta);
			if($idGrupo!="")
			{
				echo "<br>El nombre del grupo ingresado ya ha sido registrado anteriormente";
				return;
			}
			$consulta="update 4540_gruposMaestros set aulaDefault=".$obj->aulaDefecto.", nombreGrupo='".cv(trim($obj->nombreGrupo))."',situacion=".$obj->situacion.",cupoMinimo=".$obj->cupoMinimo.",cupoMaximo=".$obj->cupoMaximo." where idGrupoPadre=".$obj->idGrupo;
		}

		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idGrupo==-1)
			{
				if((!isset($obj->crearGrupo))||($obj->crearGrupo==1))
				{
					$obj->idGrupo=$con->obtenerUltimoID();
					if(crearGruposAsociados($obj->idInstanciaPlanEstudio,$obj->idGrupo,$obj->codigoUnidad))
					{
						
						echo "1|";
					}
				}
				else
					echo "1|";
			}
			else
			{
				if(actualizarGruposMateriaObligatoria($obj->idGrupo))
					echo "1|";
			}
			
		}
		
	}
	
	function removerGrupoMaestro()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="SELECT idGrupos FROM 4520_grupos WHERE idGrupoPadre=".$idGrupo;
		$listGrupos=$con->obtenerListaValores($consulta);

		if($listGrupos=="")
			$listGrupos=-1;
		
		if($listGrupos!=-1)
		{	
			$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE idGrupo IN(".$listGrupos.")";
			$listGruposComp=$con->obtenerListaValores($consulta);
			if($listGruposComp!="")
			{
				$consulta="SELECT  m.nombreMateria,g.nombreGrupo FROM 4520_grupos g,4502_Materias m  WHERE g.idGrupos IN(".$listGrupos.") AND m.idMateria=g.idMateria";
				$arrRegistros=$con->obtenerFilasArreglo($consulta);
				echo '2|'.$arrRegistros;
				return;
			}
		}
		if($listGrupos!=-1)
		{	
			$consulta="SELECT idGrupoReemplaza FROM 4539_gruposCompartidos WHERE idGrupoReemplaza IN(".$listGrupos.")";
			$listGruposComp=$con->obtenerListaValores($consulta);
			if($listGruposComp!="")
			{
				$consulta="SELECT  m.nombreMateria,g.nombreGrupo FROM 4520_grupos g,4502_Materias m  WHERE g.idGrupos IN(".$listGrupos.") AND m.idMateria=g.idMateria";
				$arrRegistros=$con->obtenerFilasArreglo($consulta);
				echo '3|'.$arrRegistros;
				return;
			}
		}

		$consulta="SELECT distinct idGrupo FROM 4522_horarioGrupo WHERE idGrupo IN(".$listGrupos.")";	

		$nHorario=$con->obtenerListaValores($consulta);
		if($nHorario!="")
		{
			$consulta="SELECT  m.nombreMateria,g.nombreGrupo FROM 4520_grupos g,4502_Materias m  WHERE g.idGrupos IN(".$nHorario.") AND m.idMateria=g.idMateria";
			$arrRegistros=$con->obtenerFilasArreglo($consulta);
			echo '4|'.$arrRegistros;
			return;
			
		}
	
		$consulta="delete from 4540_gruposMaestros where idGrupoPadre=".$idGrupo;
		
		if($con->ejecutarConsulta($consulta))
			if(eliminarGruposMateriaObligatoria($idGrupo))
				echo "1|";
		
	}
	
	function obtenerEvaluacionGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$nBloque=$_POST["nBloque"];
		$consulta="SELECT i.idUsuario,CONCAT(i.Paterno,' ',i.Materno,' ',i.Nom) AS alumno FROM 4517_alumnosVsMateriaGrupo a,
					802_identifica i WHERE idGrupo=".$idGrupo." AND  situacion=1 AND i.idUsuario=a.idUsuario";
		$res=$con->obtenerFilas($consulta);
		$arrCal="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idMateria FROM 4520_grupos WHERE idGrupos=".$idGrupo;
			$idMateria=$con->obtenerValor($consulta);
			$consulta="SELECT c.idCriterioEvaluacionExtra,c.idEvaluacion,c.tipoCriterio,p.valor FROM 4156_criteriosEvaluacionExtra c,4152_ponderacionCriterios p 
						WHERE c.idMateria=".$idMateria." AND c.idEvaluacion=p.idEvaluacion AND p.bloque=".$nBloque." AND c.idMateria=p.idMateria";
			$resCriterio=$con->obtenerFilas($consulta);
			$arrCampos="";
			while($filaCriterio=mysql_fetch_row($resCriterio))
			{
				$consulta="SELECT calificacion,valorReal FROM 4162_calCriterioBloque WHERE idUsuario=".$fila[0]." AND idGrupo=".$idGrupo." AND noParcial=".$nBloque;
				$fCriterio=$con->obtenerPrimeraFila($consulta);
				$arrCampos.=',"criterio_'.$filaCriterio[0].'":"'.$fCriterio[0].'","valorCriterio_'.$filaCriterio[0].'":"'.$fCriterio[1].'"';
			}
			if($nBloque==0)
			{
				$consulta="select avg(calificacion) from 4164_calFinales where idAlumno=".$fila[0]." and idGrupo=".$idGrupo;
				$cal=$con->ObtenerValor($consulta);
				if($cal=="")
					$cal=0;
				$arrCampos.=',"criterio_0":"'.$cal.'","valorCriterio_0":"0"';
			}
			$consulta="SELECT calificacion FROM 4163_calBloqueMateria WHERE idUsuario=".$fila[0]." AND bloque=".$nBloque." AND idGrupo=".$idGrupo;
			$fCriterio=$con->obtenerPrimeraFila($consulta);
			$arrCampos.=',"calificacion":"'.$fCriterio[0].'"';
			$obj='{"idAlumno":"'.$fila[0].'","nombreAlumno":"'.$fila[1].'"'.$arrCampos.'}';
			if($arrCal=="")
				$arrCal=$obj;
			else
				$arrCal.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrCal.']}';
	}
	
	function asentarCalificacionAlumno()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 4162_calCriterioBloque WHERE idGrupo=".$obj->idGrupo." and noParcial=".$obj->noParcial;
		$x++;
		$consulta[$x]="DELETE FROM 4163_calBloqueMateria WHERE idGrupo=".$obj->noParcial." and bloque=".$obj->noParcial;
		$x++;
		$consulta[$x]="DELETE FROM 4164_calFinales WHERE idGrupo=".$obj->idGrupo;
		$x++;
		foreach($obj->registros as $r)
		{
			foreach($r->criterios as $c)
			{
				$consulta[$x]="INSERT INTO 4162_calCriterioBloque(idCriterio,calificacion,valorReal,ponderacion,idUsuario,idGrupo,noParcial)
								VALUES(".$c->criterio.",".$c->valorObtenido.",".$c->calObtenida.",".$c->ponderacion.",".$r->idAlumno.",".$obj->idGrupo.",".$obj->noParcial.")";
				$x++;
			}
			$consulta[$x]="INSERT INTO 4163_calBloqueMateria(calificacion,idUsuario,bloque,idGrupo) 
							VALUES(".$r->calificacionFinal.",".$r->idAlumno.",".$obj->noParcial.",".$obj->idGrupo.")";
			$x++;
			if($obj->noParcial==0)
			{
				$consulta[$x]="INSERT INTO 4164_calFinales(idAlumno,calificacion,idGrupo) VALUES(".$r->idAlumno.",".$r->calificacionFinal.",".$obj->idGrupo.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function cerrarRegistroCalificaciones()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$noParcial=$_POST["noParcial"];
		$consulta="INSERT INTO 4165_bloquesCerrados(idGrupo,noParcial,fechaBloqueo,responsable)
					VALUES(".$idGrupo.",".$noParcial.",'".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		eC($consulta);			
	}
	
	function obtenerNombreGrupo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		echo "1|".generarNombreGrupo($obj->idCiclo,$obj->idMateria,$obj->idInstanciaPlanEstudio);
/*		$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idCiclo=".." AND idMateria=".." AND idInstanciaPlanEstudio=".;
		$res=$con->obtenerFilas($consulta);
		$maxNum=0;
		while($fila=mysql_fetch_row($res))
		{
			if(strpos($fila[0],"-")!==false)
			{
				$arrDatos=explode('-',$fila[0]);
				if(is_numeric($arrDatos[1]))
				{
					if($arrDatos[1]>$maxNum)
						$maxNum=$arrDatos[1];
				}
			}
		}
		$maxNum++;
		$consulta="SELECT cveMateria FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." AND idMateria=".$obj->idMateria;
		$clave=$con->obtenerValor($consulta);
		$nombreGrupo=$clave."-".$maxNum;
		echo "1|".$nombreGrupo;
*/	
	}
	
	function obtenerTransaccionesPendientes()
	{
		global $con;
		global $dic;
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$consulta="SELECT * FROM 4545_transaccionesPlanesEstudio WHERE (idInstanciaPlan=".$idInstanciaPlanEstudio." or idInstanciaPlan2=".$idInstanciaPlanEstudio.") AND situacion=1 order by fechaTransaccion desc";
		$resTransaccion=$con->obtenerFilas($consulta);
		$ct=0;
		$cadObj="";
		while($fila=mysql_fetch_row($resTransaccion))
		{
			switch($fila[1])
			{
				case 1:
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica WHERE idUsuario=".$fila[9];
					$nResponsable=$con->obtenerValor($consulta);
					$descripcion="";
					$pEjecutar="";
					if($fila[2]==$idInstanciaPlanEstudio)
					{
						$pEjecutar=1;
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[3];		
						$grupoOrigen=$con->obtenerValor($consulta);
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[4];		
						$grupoDestino=$con->obtenerValor($consulta);
						$consulta="SELECT i.nombrePlanEstudios,p.descripcion FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.idInstanciaPlanEstudio=".$fila[12];
						$planDestino=$con->obtenerValor($consulta);
						$descripcion=$dic["planEstudio"]["s"]["el"]." ".strtolower($dic["planEstudio"]["s"]["et"]).":".$planDestino."  ha solicitado que ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoOrigen.
										" se unifique con ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoDestino." de su ".strtolower($dic["planEstudio"]["s"]["et"]);
					}
					else
					{
						$pEjecutar=0;
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[3];		
						$grupoOrigen=$con->obtenerValor($consulta);
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[4];		
						$grupoDestino=$con->obtenerValor($consulta);
						$consulta="SELECT i.nombrePlanEstudios,p.descripcion FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.idInstanciaPlanEstudio=".$fila[2];
						$planDestino=$con->obtenerValor($consulta);
						$descripcion="Su ".strtolower($dic["planEstudio"]["s"]["et"])." ha solicitado que ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoOrigen.
									" se unifique con ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoDestino." perteneciente ".strtolower($dic["planEstudio"]["s"]["el"]." ".$dic["planEstudio"]["s"]["et"]).": ".
										$planDestino;
					}
					$obj='{"idTransaccion":"'.$fila[0].'","transaccion":"'.$descripcion.'","responsableTransaccion":"'.$nResponsable.'","fechaTransaccion":"'.$fila[8].'","pEjecutar":"'.$pEjecutar.'"}';

				break;
			}
			if($cadObj=='')
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$cadObj.']}';
	}
	
	function resultadoTransaccion()
	{
		global $con;
		$listTransacciones=$_POST["listTransacciones"];
		$accion=$_POST["accion"];
		$comentarios=$_POST["comentarios"];
		if($accion==2)
		{
			$arrTransacciones=explode(",",$listTransacciones);
			
			foreach($arrTransacciones as $t)
			{
				
				if(!ejecutarTransaccion($t))
				{
					return;
				}
				
			}
		}
		$consulta="update 4545_transaccionesPlanesEstudio set comentarios='".cv($comentarios)."',situacion=".$accion.",fechaEjecucion='".date("Y-m-d")."',respEjecucion=".$_SESSION["idUsr"]." where idTransaccionesGrupo in (".$listTransacciones.")";
		eC($consulta);
	}
	
	
	function ejecutarTransaccion($idTransaccion)
	{
		global $con;
		$consulta="select * from 4545_transaccionesPlanesEstudio where idTransaccionesGrupo=".$idTransaccion;
		$fTransaccion=$con->obtenerPrimeraFila($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		switch($fTransaccion[1])
		{
			case 1:
				$idGrupoOrigen=$fTransaccion[3];
				$idGrupoDestino=$fTransaccion[4];
				$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoOrigen;
				$fGrupoOrigen=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoDestino;
				$fGrupoDestino=$con->obtenerPrimeraFila($consulta);
				$query[$x]="update 4517_alumnosVsMateriaGrupo SET idGrupo=".$idGrupoDestino." WHERE idGrupo=".$idGrupoOrigen;
				$x++;
				$query[$x]="update 4520_grupos SET situacion=2 where idGrupos=".$idGrupoOrigen;
				$x++;
				$query[$x]="insert into 4539_gruposCompartidos(idGrupo,idInstanciaComparte,idMateriaEquivalente) VALUES(".$idGrupoDestino.",".$fGrupoOrigen[11].",".$fGrupoOrigen[3].")";
				$x++;
			break;
		}
		$query[$x]="commit";
		$x++;
		return $con->ejecutarBloque($query);
	}
	
	function obtenerHistorialTransacciones()
	{
		global $con;
		global $dic;
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$consulta="SELECT * FROM 4545_transaccionesPlanesEstudio WHERE (idInstanciaPlan=".$idInstanciaPlanEstudio." or idInstanciaPlan2=".$idInstanciaPlanEstudio.") AND situacion <>1 order by fechaTransaccion desc";
		$resTransaccion=$con->obtenerFilas($consulta);
		$ct=0;
		$cadObj="";
		while($fila=mysql_fetch_row($resTransaccion))
		{
			switch($fila[1])
			{
				case 1:
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica WHERE idUsuario=".$fila[9];
					$nResponsable=$con->obtenerValor($consulta);
					$descripcion="";
					$pEjecutar="";
					if($fila[2]==$idInstanciaPlanEstudio)
					{
						$pEjecutar=1;
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[3];		
						$grupoOrigen=$con->obtenerValor($consulta);
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[4];		
						$grupoDestino=$con->obtenerValor($consulta);
						$consulta="SELECT i.nombrePlanEstudios,p.descripcion FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.idInstanciaPlanEstudio=".$fila[12];
						$planDestino=$con->obtenerValor($consulta);
						$descripcion=$dic["planEstudio"]["s"]["el"]." ".strtolower($dic["planEstudio"]["s"]["et"]).":".$planDestino."  ha solicitado que ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoOrigen.
										" se unifique con ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoDestino." de su ".strtolower($dic["planEstudio"]["s"]["et"]);
					}
					else
					{
						$pEjecutar=0;
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[3];		
						$grupoOrigen=$con->obtenerValor($consulta);
						$consulta="SELECT nombreGrupo FROM 4520_grupos WHERE idGrupos=".$fila[4];		
						$grupoDestino=$con->obtenerValor($consulta);
						$consulta="SELECT i.nombrePlanEstudios,p.descripcion FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.idInstanciaPlanEstudio=".$fila[2];
						$planDestino=$con->obtenerValor($consulta);
						$descripcion="Su ".strtolower($dic["planEstudio"]["s"]["et"])." ha solicitado que ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoOrigen.
									" se unifique con ".strtolower($dic["grupo"]["s"]["el"])." ".strtolower($dic["grupo"]["s"]["et"])." ".$grupoDestino." perteneciente ".strtolower($dic["planEstudio"]["s"]["el"]." ".$dic["planEstudio"]["s"]["et"]).": ".
										$planDestino;
					}
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica WHERE idUsuario=".$fila[11];
					$nRespEjec=$con->obtenerValor($consulta);
					$resolucion="";
					if($fila[7]==0)
						$resolucion="Solicitud rechazada";
					else
						$resolucion="Solicitud aceptada";
					$obj='{"idTransaccion":"'.$fila[0].'","transaccion":"'.$descripcion.'","responsableTransaccion":"'.$nResponsable.'","fechaTransaccion":"'.$fila[8].'","resolucion":"'.$resolucion.
						'","fechaResolucion":"'.$fila[10].'","responsableResolucion":"'.$nRespEjec.'","comentarios":"'.cv($fila[13]).'"}';

				break;
			}
			if($cadObj=='')
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$cadObj.']}';
	}
	
	function obtenerCompatibilidadAlumnosGrupos()
	{
		global $con;
		$idGrupoOrigen=$_POST["idGrupoOrigen"];
		$idGrupoDestino=$_POST["idGrupoDestino"];
		
		$consulta="SELECT fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$idGrupoDestino;
		$fGrupoDestino=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT i.idUsuario,(CONCAT(Paterno,' ',Materno,' ',Nom)) AS nombre FROM 4517_alumnosVsMateriaGrupo a,802_identifica i WHERE a.idGrupo=".$idGrupoOrigen." AND situacion=1 AND i.idUsuario=a.idUsuario";
		$resAlumnos=$con->obtenerFilas($consulta);
		$arrAlumnos="";
		$ct=0;
		while($fila=mysql_fetch_row($resAlumnos))
		{
			$disponibilidad="1";
			$complementario=validarHorarioAlumnosExtendido($fila[0],$idGrupoDestino);
			if($complementario!="")
				$disponibilidad="0";
			$obj='{"idAlumno":"'.$fila[0].'","alumno":"'.$fila[1].'","disponibilidad":"'.$disponibilidad.'","complementario":"'.$complementario.'"}';
			if($arrAlumnos=="")
				$arrAlumnos=$obj;
			else
				$arrAlumnos.=",".$obj;			
			$ct++;	
		}
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrAlumnos.']}';
		
		
	}
	
	function obtenerEstructuraCurricularPeriodo()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$tUnidad=$dic["grado"]["s"]["et"];
		
		$consulta="SELECT sede FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$plantel=$con->obtenerValor($consulta);
		
		$consulta="SELECT situacion FROM 4547_situacionInstanciaPlan WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." 
					AND plantel='".$plantel."' AND situacion=1  ORDER BY idSituacionPlanEstudio DESC";

		$situacionPlantel=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPlanEstudio,idEsquemaGrupo FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$fInstancia=$con->obtenerPrimeraFila($consulta);
		$idPlanEstudio=$fInstancia[0];
		$idEsquemaGrupo=$fInstancia[1];
		
		
		
		$consulta="SELECT COUNT(*) FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$nReg=$con->obtenerValor($consulta);
		
		
		
		
		if(($nReg==0)&&($con->existeTabla("4500_aperturaGradosPeriodo")))
		{
			$consulta="SELECT COUNT(*) FROM 4500_gradosInstanciaPlanModificados WHERE idInstancia=".$idInstanciaPlanEstudio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$x=0;
				$query[$x]="begin";
				$x++;
				$consulta="SELECT idGrado FROM 4500_aperturaGradosPeriodo WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND idPeriodo=".$idPeriodo." AND valor=1";
				$rGrado=$con->obtenerFilas($consulta);
				while($fGrado=mysql_fetch_row($rGrado))
				{
					$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND idUnidad=".$fGrado[0]." AND tipoUnidad=3";
					$codUnidad=$con->obtenerValor($consulta);
					$query[$x]="INSERT INTO 4546_estructuraPeriodo(idCiclo,idPeriodo,idInstanciaPlanEstudio,grado,situacion,idGrado)
								VALUES(".$idCiclo.",".$idPeriodo.",".$idInstanciaPlanEstudio.",'".$codUnidad."',1,".$fGrado[0].")";
					$x++;
				}
				$query[$x]="commit";
				$x++;
				$con->ejecutarBloque($query);
			}
		}
		
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,codigoUnidad,g.idGrado,ordenGrado FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 
				AND tipoUnidad=3 ORDER BY  ordenGrado";

		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." and grado='".$fila[2]."' and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;
			
			$idEstructura=$con->obtenerValor($consulta);
			if($idEstructura!="")
			{
				$hijos=obtenerMateriasHijosPeriodo($idPlanEstudio,$fila[2],$idInstanciaPlanEstudio,$idCiclo,$idPeriodo);
				
				$compMateria="";
				if($hijos=="[]")
					$compMateria=',leaf:true';	
				else
					$compMateria=',leaf:false,children:'.$hijos.'';	
				$hijosGrado=obtenerGruposGrado($idInstanciaPlanEstudio,$fila[2],$idCiclo,$idPeriodo);
				if($hijosGrado=="[]")
					$compGrado=',leaf:true';	
				else
					$compGrado=',leaf:false,children:'.$hijosGrado.'';	
				$hijos='{"expanded":true,"tUnidad":"10","icon":"../images/s.gif","clave":"","text":"<span style=\'color:#900\'><b>MATERIAS</b></span>"'.$compMateria.'}';
				if($idEsquemaGrupo!=1)
					$hijos.=',{"expanded":true,"codigoUnidad":"'.$fila[2].'","tUnidad":"20","icon":"../images/s.gif","clave":"","text":"<span style=\'color:#900\'><b>GRUPOS</b></span>"'.$compGrado.'}';																							  
					
				$sL=0;
				$icono="";
				
				if($situacionPlantel==1)
				{
					$sL=1;
					$icono="(<img src='../images/lock.png' title='Autorizado/Cerrado' alt='Autorizado/Cerrado' height='14' width='14'> Autorizado/Cerrado)";
				}
				else
				{
					$consulta="SELECT dictamen,s.situacion FROM 4615_gradosSolicitudAutorizacionEstructura g,4614_cabeceraSolicitudAutorizacionEstructura s 
								WHERE g.idGradoEstructura=".$idEstructura." AND s.idRegistro=g.idSolicitud ORDER BY g.idRegistro DESC";					
					$fSituacion=$con->obtenerPrimeraFila($consulta);
					
					
					if(!$fSituacion)	
					{
						$icono="(<img src='../images/pencil.png' title='En dise&ntilde;o' alt='En dise&ntilde;o' height='14' width='14'> En dise&ntilde;o)";
					}
					else
					{
						
						if($fSituacion[1]==1)
						{
							$sL=1;
							$icono="(<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n' height='14' width='14'> En espera de autorizaci&oacute;n)";
						}
						else
						{
							switch($fSituacion[0])
							{
								case 1:
									$sL=1;
									$icono="(<img src='../images/lock.png' title='Autorizado/Cerrado' alt='Autorizado/Cerrado' height='14' width='14'> Autorizado/Cerrado)";
								break;
								case 2:
									$icono="(<img src='../images/pencil.png' title='En dise&ntilde;o' alt='En dise&ntilde;o' height='14' width='14'> En dise&ntilde;o)";
								break;
							}
						}
					}
				}
				$obj='{"expanded":true,"sL":"'.$sL.'","idGradoCiclo":"'.$idEstructura.'",ordenGrado:"'.$fila[4].'",clave:"",codigoUnidad:"'.$fila[2].'",id:"'.$fila[0].'",descripcion:"",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[1]).
						'",text:"<span style=\'color:#030\'><b>'.cv($fila[1]).'</b> '.$icono.'</span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",uiProvider:"col",icon:"../images/table_row_insert.png",
						"children":['.$hijos.']}';	
					
				if($arrTemas=="")
					$arrTemas=$obj;
				else
					$arrTemas.=",".$obj;
			}
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijosPeriodo($idPlanEstudio,$codigoPadre,$idInstanciaPlanEstudio,$idCiclo,$idPeriodo)
	{
		global $con;
		global $dic;
		
		
		
		
		$tUnidad="";
		$arrTemas="";
		$consulta="select * from (SELECT idEstructuraCurricular,codigoUnidad,
				(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad limit 0,1),(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad limit 0,1))) 
				as nombreUnidad,
				e.idUnidad,e.tipoUnidad,
				if(tipoUnidad=1,
					(select idCategoriaMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
					(select idCategoria FROM 4508_unidadesContenedora WHERE idUnidadContenedora=e.idUnidad)
				) as idCategoria,
				if(tipoUnidad=1,(select cveMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),'') as clave 
				 FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."' ) as tmp   order by idCategoria,clave";

		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			
			
			$nGrupos="";
			$nGruposProf="";
			$icono="s.gif";
			$color="";
			$comp="";
			if($fila[4]==1)
			{
				$icono="text_lowercase.png";
				$color="003";
				
				$consulta="SELECT numeroCredito,horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,horasSemana,idCategoriaMateria FROM 4502_Materias WHERE idMateria=".$fila[3];

				$filaMat=$con->obtenerPrimeraFila($consulta);
				
				$idCategoria=$filaMat[6];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;

				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
				
			}
			else
			{
				
				$color="000";
				$icono="Icono_3d.gif";
				
				$consulta="select descripcion,tipoUnidad,idCategoria from 4508_unidadesContenedora where idUnidadContenedora=".$fila[3];


				$fUnidad=$con->obtenerPrimeraFila($consulta);
				$idCategoria=$fUnidad[2];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;

				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
				
			}
			$tUnidadContenedora=0;
			if($fila[4]==1)
			{
				$nGrupos=0;
				$nGruposProf=0;
				$consulta="SELECT idGrupos FROM 4520_grupos WHERE idMateria=".$fila[3]." AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
				$resGpo=$con->obtenerFilas($consulta);
				while($fGpo=mysql_fetch_row($resGpo))
				{
					$nGrupos++;
					$consulta="SELECT count(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$fGpo[0]." AND situacion=1 AND participacionPrincipal=1";
					$nReg=$con->obtenerValor($consulta);
					if($nReg>0)
						$nGruposProf++;
				}
			}
			else
			{
				if($fila[4]==2)
				{
					$query="SELECT nombreUnidad,tipoUnidad FROM 4508_unidadesContenedora WHERE idUnidadContenedora=".$fila[3];

					$fContenedor=$con->obtenerPrimeraFila($query);
					$tUnidadContenedora=$fContenedor[1];
					
					if($fContenedor[1]==1)
					{
						$nGrupos=0;
						$nGruposProf=0;
						$consulta="SELECT idGrupos FROM 4520_grupos WHERE idMateria=-".$fila[3]." AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;

						$resGpo=$con->obtenerFilas($consulta);
						while($fGpo=mysql_fetch_row($resGpo))
						{
							$nGrupos++;
							$consulta="SELECT count(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$fGpo[0]." AND situacion=1 AND participacionPrincipal=1";
							$nReg=$con->obtenerValor($consulta);
							if($nReg>0)
								$nGruposProf++;
						}
					}
				}
			}
			
			
			$obj='{tUnidadContenedora:"'.$tUnidadContenedora.'",nGrupos:"'.cv($nGrupos).'",nGruposProf:"'.$nGruposProf.'",codigoUnidad:"'.$fila[1].'",id:"'.$fila[0].'",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[2]).'",descripcion:"",text:"'.$comp.' <span style=\'color:#'.$color.'\'><b>'.$fila[2].'</b></span>",tUnidad:"'.$fila[4].'",uiProvider:"col"';
			$consulta="SELECT * FROM 4552_intercambiosMateria WHERE idInstanciaPlan=".$idInstanciaPlanEstudio." and idElementoOrigen=".$fila[0]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
			$fCambio=$con->obtenerPrimeraFila($consulta);
			if(!$fCambio)
			{
				$hijos=obtenerMateriasHijosPeriodo($idPlanEstudio,$fila[1],$idInstanciaPlanEstudio,$idCiclo,$idPeriodo);																								  
				
				if($hijos=='[]')
					$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
				else
					$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
				if($arrTemas=="")
					$arrTemas=$obj;
				else
					$arrTemas.=",".$obj;
			}
			else
			{
				$codGrado=substr($fila[1],0,3);
				$consulta="SELECT leyendaGrado FROM 4501_Grado g,4505_estructuraCurricular e WHERE g.idGrado=e.idUnidad AND e.codigoUnidad='".$codGrado."' AND e.idPlanEstudio=".$idPlanEstudio;
				$grado=$con->obtenerValor($consulta);
				$lblMateria=$fila[2];//." (".$grado.")";
				$consulta="SELECT idEstructuraCurricular,codigoUnidad,
					(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad limit 0,1),(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad limit 0,1))) as nombreUnidad,
					e.idUnidad,e.tipoUnidad FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
					WHERE n.idNaturalezaMateria=e.naturalezaMateria and idEstructuraCurricular=".$fCambio[2];
				$fila=$con->obtenerPrimeraFila($consulta);
				$color="FF0000";
				if($fila[4]==1)
				{
					$nGrupos=0;
					$nGruposProf=0;
					$consulta="SELECT idGrupos FROM 4520_grupos WHERE idMateria=".$fila[3]." AND idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
					$resGpo=$con->obtenerFilas($consulta);
					while($fGpo=mysql_fetch_row($resGpo))
					{
						$nGrupos++;
						$consulta="SELECT count(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$fGpo[0]." AND situacion=1 AND participacionPrincipal=1";
						$nReg=$con->obtenerValor($consulta);
						if($nReg>0)
							$nGruposProf++;
					}
				}
				$comp="(<b>".$dic["materia"]["s"]["este"]." ".strtolower($dic["materia"]["s"]["et"])." reemplaza a ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": <span style='color:#FF0000'><b>".$lblMateria."</b></span>para este ciclo y periodo</b>)";
				$obj='{nGrupos:"'.cv($nGrupos).'",nGruposProf:"'.$nGruposProf.'",idRegCambio:"'.$fCambio[0].'",codigoUnidad:"'.$fila[1].'",id:"c_'.$fila[0].'",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[2]).'",descripcion:"",text:"'.$comp.'  <span style=\'color:#'.$color.'\'><b>'.$fila[2].'</b></span>'.$comp.'",tUnidad:"'.$fila[4].'",uiProvider:"col"';
				$hijos=obtenerMateriasHijosPeriodo($idPlanEstudio,$fila[1],$idInstanciaPlanEstudio,$idCiclo,$idPeriodo);																								  
				if($hijos=='[]')
					$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
				else
					$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
				if($arrTemas=="")
					$arrTemas=$obj;
				else
					$arrTemas.=",".$obj;
			}
			
		}
		return "[".$arrTemas."]";
	}
	
	function obtenerGradosDisponiblesEstructuraCurricularPeriodo()
	{
		global $con;
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		
		$listUnidad=$con->obtenerListaValores($consulta);
		if($listUnidad=="")
			$listUnidad="-1";
		$consulta="select idGrado,leyendaGrado,descripcion,ordenGrado from 4501_Grado where idPlanEstudio=".$idPlanEstudio." and idGrado not in (".$listUnidad.") order by ordenGrado";
		$arrGrados=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrGrados).'}';
		
	}
	
	function guardarGradoAperturaPeriodo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$lista=$obj->lista;
		$arrLista=explode(",",$lista);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($arrLista as $idGrado)
		{
			$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$obj->idPlanEstudio." AND idUnidad=".$idGrado." AND tipoUnidad=3";
			$codUnidad=$con->obtenerValor($consulta);
			$query[$x]="INSERT INTO 4546_estructuraPeriodo(idCiclo,idPeriodo,idInstanciaPlanEstudio,grado,situacion,idGrado)
						VALUES(".$obj->idCiclo.",".$obj->idPeriodo.",".$obj->idInstancia.",'".$codUnidad."',1,".$idGrado.")";
			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerSituacionAcualPlanEstudio()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$plantel=$_POST["plantel"];
		$idInstancia=$_POST["idInstancia"];
		$situacion=obtenerSituacionPlanPeriodo($idInstancia,$idCiclo,$idPeriodo);
		$consulta="SELECT COUNT(*) FROM 4551_comentariosValidacionPlan WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia;
		$nComentarios=$con->obtenerValor($consulta);
		$consulta="SELECT tipoEsquemaAsignacionFechasGrupo,numMaxBloquesFechas FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
		$fInstancia=$con->obtenerPrimeraFila($consulta);
		
		$mostrarBotonConfFecha=0;
		if($fInstancia[0]==2)
		{
			$consulta="SELECT COUNT(*) FROM 4571_fechasBloquePeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstancia=".$idInstancia;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)	
				$mostrarBotonConfFecha=1;
		}
		$consulta="SELECT fechaInicial, fechaFinal FROM 4544_fechasPeriodo WHERE idPeriodo=".$idPeriodo." AND idCiclo=".$idCiclo." AND idInstanciaPlanEstudio=".$idInstancia;
		$fPeriodo=$con->obtenerPrimeraFila($consulta);
		echo "1|".$situacion."|".$nComentarios."|".$mostrarBotonConfFecha."|".$fPeriodo[0]."|".$fPeriodo[1];
	}
	
	function someterEvaluacionInstancia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 4547_situacionInstanciaPlan SET STATUS=0 WHERE idCiclo=".$obj->idCiclo." and idPeriodo=".$obj->idPeriodo." 
						and plantel='".$obj->plantel."'";
		$x++;
		$consulta[$x]="INSERT INTO 4547_situacionInstanciaPlan(idCiclo,idPeriodo,plantel,situacion,fechaSometimiento,idResponsableSometimiento,status)
					values(".$obj->idCiclo.",".$obj->idPeriodo.",'".$obj->plantel."',1,'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",1)";
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;	
		eB($consulta);		
	}
	
	function obtenerEstructuraCurricularEvaluacion()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		
		
		$tUnidad=$dic["grado"]["s"]["et"];

		$consulta="SELECT idPlanEstudio,sede FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$fPlantel=$con->obtenerPrimeraFila($consulta);
		$idPlanEstudio=$fPlantel[0];
		$plantel=$fPlantel[1];
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,codigoUnidad,g.idGrado FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE grado='".$fila[2]."' and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;

			$idEstructura=$con->obtenerValor($consulta);
			if($idEstructura!="")
			{
				$obj='{clave:"",codigoUnidad:"'.$fila[2].'",id:"'.$fila[0].'",descripcion:"",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[1]).'",text:"<span style=\'color:#030\'><b>'.$fila[1].'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",uiProvider:"col"';
				$hijos=obtenerMateriasHijosEvaluacion($idPlanEstudio,$fila[2],$idInstanciaPlanEstudio,$idCiclo,$idPeriodo,$plantel);																								  
				if($hijos=='[]')
					$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
				else
					$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
				if($arrTemas=="")
					$arrTemas=$obj;
				else
					$arrTemas.=",".$obj;
			}
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijosEvaluacion($idPlanEstudio,$codigoPadre,$idInstanciaPlanEstudio,$idCiclo,$idPeriodo,$plantel)
	{
		global $con;
		global $arrDiasSemana;
		global $dic;
		$tUnidad="";
		$arrTemas="";
		$consulta="SELECT idEstructuraCurricular,codigoUnidad,
				(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad limit 0,1),
				(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad limit 0,1))) as nombreUnidad,
				e.idUnidad,e.tipoUnidad FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."'  order by nombreUnidad";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			
			$icono="s.gif";
			$color="";
			if($fila[4]==1)
			{
				$icono="text_lowercase.png";
				$color="003";
			}
			else
			{
				
				$color="000";
				$icono="Icono_3d.gif";
			}
			
			$idMateria=$fila[3];
			$consulta="SELECT horasSemana,horaMateriaTotal FROM 4502_Materias WHERE idMateria=".$idMateria;

			$filaMat=$con->obtenerPrimeraFila($consulta);
			$tHoras=$filaMat[1];
			$consulta="SELECT noHorasSemana FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND idMateria=".$idMateria;
			$hSemanas=$con->obtenerValor($consulta);
			if($hSemanas=="")
			{
				$hSemanas=$filaMat[0];		
			}
			if($hSemanas!=0)
				$nSemanas=ceil($tHoras/$hSemanas);
			else
				$nSemanas=0;
			
			
			$consulta="select IntHrMedida,IntHrMax from _315_tablaDinamica where codigoInstitucion='".$plantel."'";

			$filaHora=$con->obtenerPrimeraFila($consulta);
			$duracionHora=$filaHora[0];
			$horasSemanas=$filaHora[1];
			$consulta="SELECT dracionHora FROM _472_tablaDinamica WHERE idReferencia=".$idInstanciaPlanEstudio;
			$duracionHora=$con->obtenerValor($consulta);
			if($duracionHora=="")
				$duracionHora=60;
			
			$totalHorasSemanas=$hSemanas*$duracionHora;
			$ctInciencias=0;
			
			
			$consulta="SELECT idGrupos FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." AND 
						idMateria=".$idMateria." AND idCiclo=".$idCiclo." AND situacion=1";
			$comp=" Con circunstancias";
			$resGrupos=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				while($filaGpo=mysql_fetch_row($resGrupos))						
				{
					$nSemanasAux=$nSemanas;
					$hSemanasAux=$hSemanas;
					$tHorasAux=$tHoras;
					$totalHorasSemanasAux=$totalHorasSemanas;
					$observaciones="";
					
					$consulta="SELECT u.Nombre,u.idUsuario FROM 4519_asignacionProfesorGrupo a,800_usuarios u where u.idUsuario=a.idUsuario AND a.idGrupo=".$filaGpo[0]." AND participacionPrincipal=1 AND situacion=1";
	
					$filaProfAsig=$con->obtenerPrimeraFila($consulta);
					$profesorAsignado=$filaProfAsig[0];
					$idProfesor=$filaProfAsig[1];
					
					if($idProfesor!="")
					{
						$consulta="SELECT idProfesor FROM 4541_asignacionesNoCumplePerfil WHERE idProfesor=".$idProfesor." AND idGrupo=".$filaGpo[0];
						$noCumple=$con->obtenerValor($consulta);
						if($noCumple!="")
						{
							//$observaciones.="<img src='../images/exclamation.png'> El profesor asignado, no cumple con el perfil requerido por la materia<br>";
							$ctInciencias++;
						}
					}
					else
						$ctInciencias++;
					
					
					$consulta="SELECT  a.idUsuario,t.fechaBaja,t.fechaRegreso FROM 4519_asignacionProfesorGrupo a,_447_tablaDinamica t 
														WHERE situacion=1 AND idParticipacion=45 AND t.id__447_tablaDinamica=a.idRegistroAccion AND a.idGrupo=".$filaGpo[0];
	
					$filaSup=$con->obtenerPrimeraFila($consulta);
					if($filaSup)
					{
						$fechaActual=strtotime(date("Y-m-d"));
						$fechaInicial=strtotime($filaSup[1]);
						$fechaFinal=strtotime($filaSup[2]);
						//if(($fechaInicial<=$fechaActual)&&($fechaFinal>=$fechaActual))
						{
							if($filaSup[0]!="0")
								$observaciones.="<table><tr><td><img src='../images/user_gray.png'>&nbsp;&nbsp;</td><td>El profesor <b>".obtenerNombreUsuario($filaSup[0])."</b> es suplente de esta materia en el periodo comprendido del ".date("d/m/Y",$fechaInicial)." al ".date("d/m/Y",$fechaFinal)."</td></tr></table><br>";	
							else
								$observaciones.="<table><tr><td><img src='../images/user_gray.png'>&nbsp;&nbsp;</td><td>La materia se encuentra en espera de asignación de un profesor suplente en el periodo comprendido del ".date("d/m/Y",$fechaInicial)." al ".date("d/m/Y",$fechaFinal)."</td></tr></table><br>";	
						}
						$ctInciencias++;
					}
					
					$horario="";
					$consulta="SELECT COUNT(idUsuario) FROM 4517_alumnosVsMateriaGrupo WHERE idGrupo=".$filaGpo[0];
					$nAlumnos=$con->obtenerValor($consulta);
					$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$filaGpo[0]." order by dia,horaInicio,horaFin";
					$resHorario=$con->obtenerFilas($consulta);
					$horario="<table><tr><td width='120'><span class='corpo8_bold'>D&iacute;a</td><td width='160' ><span class='corpo8_bold'>Horario</span></td><td width='300' ><span class='corpo8_bold'>Aula</span></td></tr><tr height='1'><td colspan='3' style='background-color:#900'></td></tr>";
					$consultaExiste="SELECT idSolicitudConvMat FROM 4233_solicitudConvMateria WHERE idGrupo=".$filaGpo[0];
					
					$existe=$con->obtenerValor($consultaExiste);
					$comp="";
					if($existe!="")
					{
						$comp="&nbsp;<img src='../images/exclamation.png' title='Este grupo ha sido marcado para buscar a el profesor titular a trav&eacute;s de una convocatoria' alt='Este grupo ha sido marcado para buscar a el profesor titular a trav&eacute;s de una convocatoria'>";
					}
					while($filaH=mysql_fetch_row($resHorario))
					{
						$aula="";
						if($filaH[3]!="")
						{
							$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaH[3];
							$aula=$con->obtenerValor($consulta);
						}
						else
							$ctInciencias++;
						$horario.="<tr><td ><span class='letraExt'>".utf8_encode($arrDiasSemana[$filaH[0]])."</td><td class='letraExt' >".date('H:i',strtotime($filaH[1]))." - ".date('H:i',strtotime($filaH[2]))."</td><td ><span class='letraExt'>".$aula."</td></tr>";
					
					}
					$consulta="SELECT horaInicio,horaFin FROM 4522_horarioGrupo WHERE idGrupo=".$filaGpo[0];
					$resHorario=$con->obtenerFilas($consulta);
					$minutos=0;
					while($fHorario=mysql_fetch_row($resHorario))
					{
					  $hInicio=strtotime($fHorario[0]);
					  $hFin=strtotime($fHorario[1]);
					  $resta=strtotime("00:00:00")+$hFin-$hInicio;
					  $minutos+=(date("H",$resta)*60)+date("i",$resta);
					}
					if($minutos<$totalHorasSemanasAux)
					{
						$ctInciencias++;
						$observaciones.="<img src='../images/bullet_green.png'> S&oacute;lo se han asignado ".($minutos/60)." hrs. del requerido por la materia por semana (".($totalHorasSemanasAux/$duracionHora)." hrs.)<br>";
					}
					$horario.="</table><br>";
				}
			}
			else
			{
				$ctInciencias=1;
				$comp=" Sin grupos";
			}
			$situacion='<img src=\'../images/icon_big_tick.gif\' width=\'13\' height=\'13\'> Sin problemas';
			if($ctInciencias>0)
				$situacion='<img src=\'../images/cross.png\' width=\'13\' height=\'13\'>'.$comp;
			$obj='{"situacion":"'.$situacion.'",codigoUnidad:"'.$fila[1].'",id:"'.$fila[0].'",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[2]).'",descripcion:"",text:"<span style=\'color:#'.$color.'\'><b>'.$fila[2].'</b></span>",tUnidad:"'.$fila[4].'",uiProvider:"col"';
			
			$hijos=obtenerMateriasHijosEvaluacion($idPlanEstudio,$fila[1],$idInstanciaPlanEstudio,$idCiclo,$idPeriodo,$plantel);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return "[".$arrTemas."]";
	}
	
	function dictaminarSituacionPlanEstudio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT * FROM 4547_situacionInstanciaPlan WHERE idSituacionPlanEstudio=".$obj->idSituacionPlanEstudio;
		$fSituacion=$con->obtenerPrimeraFila($consulta);
		$consulta="UPDATE 4547_situacionInstanciaPlan SET STATUS=0 WHERE idCiclo=".$fSituacion[1]." and idPeriodo=".$fSituacion[2]." and plantel=".$fSituacion[3];
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="INSERT INTO 4547_situacionInstanciaPlan(idCiclo,idPeriodo,plantel,situacion,fechaSometimiento,idResponsableSometimiento,comentarios,fechaDictamen)
					VALUES(".$fSituacion[1].",".$fSituacion[2].",'".$fSituacion[3]."',".$obj->resultado.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",'".
					cv($obj->comentarios)."','".date("Y-m-d H:i")."')";
			eC($consulta);
		}
	}
	
	function obtenerComentariosDictamen()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		$consulta="SELECT situacion,fechaSometimiento,comentarios,CONCAT(Paterno,' ',Materno,' ',Nom) AS responsable,idSituacionPlanEstudio 
				FROM 4547_situacionInstanciaPlan s,802_identifica i WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND 
				plantel=".$idInstanciaPlan." AND i.idUsuario=s.idResponsableSometimiento 
				AND comentarios IS NOT NULL ORDER BY idSituacionPlanEstudio";
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($con->obtenerFilasJson($consulta)).'}';
	}
	
	function obtenerEstructuraCurricularGrupos()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$tUnidad=$dic["grado"]["s"]["et"];
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,codigoUnidad,g.idGrado FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE grado='".$fila[2]."' and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo." and idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
			$idEstructura=$con->obtenerValor($consulta);
			if($idEstructura!="")
			{
				$obj='{clave:"",codigoUnidad:"'.$fila[2].'",id:"'.$fila[0].'",descripcion:"",idUnidad:"'.$fila[3].'",nUnidad:"'.cv($fila[1]).'",text:"<span style=\'color:#030\'><b>'.cv($fila[1]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",uiProvider:"col"';
				$hijos=obtenerGruposGrado($idInstanciaPlanEstudio,$fila[2],$idCiclo,$idPeriodo);																								  
				if($hijos=='[]')
					$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
				else
					$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
				if($arrTemas=="")
					$arrTemas=$obj;
				else
					$arrTemas.=",".$obj;
			}
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerGruposGrado($idInstanciaPlan,$grado,$idCiclo,$idPeriodo)
	{
		global $con;
		$consulta="select * from 4540_gruposMaestros where idInstanciaPlanEstudio=".$idInstanciaPlan." and codigoGrado='".$grado."' 
					and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"nombreGrupo":"'.cv($fila[1]).'","cupoMinimo":"'.$fila[4].'","cupoMaximo":"'.$fila[5].'","situacion":"'.$fila[2].'",clave:"",codigoUnidad:"'.$grado.'",id:"grado'.$fila[0].'",descripcion:"",idUnidad:"'.$fila[0].'",nUnidad:"'.cv($fila[1]).
					'",text:"<span style=\'color:#003\'><b>'.cv($fila[1]).'</b></span>",tipoUnidad:"",tUnidad:"30",uiProvider:"col"
					,leaf:true,icon:"../images/users.png","aulaDefault":"'.$fila[12].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		return "[".$arrObj."]";
	}
	
	function obtenerDatosSolicitud()
	{
		global $con;
		global $dic;
		$idSolicitud=$_POST["idSolicitud"];
		$consulta="select * from 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$idSolicitud;
		$fSolicitud=$con->obtenerPrimeraFila($consulta);
		$descripcion="";
		$cadObj=$fSolicitud[5];
		switch($fSolicitud[4])
		{
			case 1:
				$obj=json_decode($cadObj);
				$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorAsigna;
				$nProfesor=$con->obtenerValor($consulta);
				$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
				$fMateria=$con->obtenerPrimeraFila($consulta);
				$descripcion="Asignación del profesor ".$nProfesor." al grupo ".$fMateria[1]." de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": ".$fMateria[0];
			break;
			case 2:
				$obj=json_decode($cadObj);
				$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuplencia;
				$nProfesor=$con->obtenerValor($consulta);
				$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
				$fMateria=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT fechaBaja,m.motivo FROM _447_tablaDinamica t,_448_motivoBajaGrid m WHERE id__447_tablaDinamica=".$obj->idRegistro." 
							and m.id__448_motivoBajaGrid=t.motivoBaja";
				$fRegistro=$con->obtenerPrimeraFila($consulta);
				$fechaInicioBaja=date("d/m/Y",strtotime($fRegistro[0]));
				$motivo=$fRegistro[1];
				$descripcion="Baja del profesor ".$nProfesor." del grupo ".$fMateria[1]." de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": ".$fMateria[0]." a partir del día: ".$fechaInicioBaja." por el siguiente motivo: ".$motivo;
				if(isset($obj->idProfesorSuple)&&($obj->idProfesorSuple!=-1))
				{
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuple;
					$nProfesor=$con->obtenerValor($consulta);
					$descripcion.="<br><br>El <font color='red'><b>nuevo profesor</b></font> titular del grupo ser&aacute; <b>".$nProfesor."</b> a partir del día: ".date("d/m/Y",strtotime($obj->fechaReemplaza));
				}
				
			break;
			case 3:
				$obj=json_decode($cadObj);
				$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuplencia;
				$nProfesor=$con->obtenerValor($consulta);
				$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuple;
				$nProfesorSuple=$con->obtenerValor($consulta);
				
				$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
				$fMateria=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT fechaBaja,m.motivo,fechaRegreso FROM _447_tablaDinamica t,_448_motivoBajaGrid m WHERE id__447_tablaDinamica=".$obj->idRegistro." 
							and m.id__448_motivoBajaGrid=t.motivoBaja";
				$fRegistro=$con->obtenerPrimeraFila($consulta);
				$fechaInicioBaja=date("d/m/Y",strtotime($fRegistro[0]));
				$fechaFinSuplencia=date("d/m/Y",strtotime($fRegistro[2]));
				$descripcion="Suplencia del profesor ".$nProfesor." del grupo ".$fMateria[1]." de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": ".$fMateria[0]." por el profesor: ".$nProfesorSuple." a partir del día: ".$fechaInicioBaja." hasta el día: ".$fechaFinSuplencia;
				
			break;
			case 4:
			break;
		}
		echo '1|{"descripcion":"'.$descripcion.'","observaciones":[]}';
	}
	
	function dictaminarSolicitudAmes()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="select * from 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$obj->idSolicitud;
		$fSolicitud=$con->obtenerPrimeraFila($query);
		$query="select idMateria,idCiclo,Plantel,idPeriodo,idInstanciaPlanEstudio,fechaFin,fechaInicio from 4520_grupos where idGrupos=".$fSolicitud[9];
		$fGrupo=$con->obtenerPrimeraFila($query);
		$listGrupos="";
		$idGrupo=$fSolicitud[9];
		if($fGrupo[0]<0)
		{
			$query="select idGrupos FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;
			$listGrupos=$con->obtenerListaValores($query);
		}
		$cadObj=$fSolicitud[5];
		$objSol=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$datos=json_decode($fSolicitud[5]);
		
		if($obj->resultado==2)
		{
			switch($fSolicitud[4])	
			{
				case 1:   //Alta de profesor
					$fechaAsignacion="NULL";
					
					if(isset($datos->fechaReemplaza))
						$fechaAsignacion="'".$datos->fechaReemplaza."'";
					
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1,esperaContrato=1, fechaAsignacion=".$fechaAsignacion." WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idUsuario=".$objSol->idProfesorAsigna;
					$x++;
					
					$query="select fechaInicio from 4520_grupos where idGrupos=".$fSolicitud[9];
					$fInicio=strtotime($con->obtenerValor($query));
					ajustarSesiones($fSolicitud[9],$fInicio,NULL,$consulta,$x,false);
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1,esperaContrato=1,fechaAsignacion=".$fechaAsignacion." WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorAsigna;
						$x++;
						$arrGpos=explode(",",$listGrupos);
						foreach($arrGpos as $g)
						{
							ajustarSesiones($g,$fInicio,NULL,$consulta,$x,false);
						}
					}
					
					
				break;
				case 2:  //baja
					$query="SELECT idRegistroAccion FROM 4519_asignacionProfesorGrupo WHERE idAsignacionProfesorGrupo=".$fSolicitud[13];
					$idReferencia=$con->obtenerValor($query);
					$query="SELECT fechaBaja FROM _447_tablaDinamica WHERE id__447_tablaDinamica=".$idReferencia;
					$fechaBaja=$con->obtenerValor($query);
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".$fechaBaja."' WHERE situacion=61 AND idGrupo=".$fSolicitud[9]." AND idUsuario=".$objSol->idProfesorSuplencia;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".$fechaBaja."' WHERE situacion=61 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorSuplencia;
						$x++;
					}
					if(isset($datos->idProfesorSuple)&&($datos->idProfesorSuple!=-1))
					{
						$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja)
										VALUES(".$fSolicitud[9].",".$datos->idProfesorSuple.",37,1,1,1,'".$datos->fechaReemplaza."','".$fGrupo[5]."')";
						$x++;
						
						if($listGrupos!="")
						{
							$arrGrupos=explode(",",$listGrupos);
							foreach($arrGrupos as $iGrupo)
							{
								$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja)
										VALUES(".$iGrupo.",".$datos->idProfesorSuple.",37,1,1,1,'".$datos->fechaReemplaza."','".$fGrupo[5]."')";
								$x++;
								
							}
							
						}
					}
				break;
				case 3:    //Suplencia
					$idRegistro=$datos->idRegistro;
					$query="SELECT fechaBaja,fechaRegreso FROM _447_tablaDinamica WHERE id__447_tablaDinamica=".$idRegistro;
					$fila=$con->obtenerPrimeraFila($query);
					
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1,fechaAsignacion='".$fila[0]."',fechaBaja='".$fila[1]."' WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idParticipacion=45 
								and idUsuario=".$objSol->idProfesorSuple;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1,fechaAsignacion='".$fila[0]."',fechaBaja='".$fila[1]."' WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idParticipacion=45 
									and idUsuario=".$objSol->idProfesorSuple;
						$x++;
					}
				break;
				case 4:    //cambio de horario
					$arrDiasSesion=array();
					$query="SELECT idHorarioGrupo from 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." AND '".$objSol->fechaAplicacion."'>=fechaInicio AND '".$objSol->fechaAplicacion."'<=fechaFin";
					$listHorario=$con->obtenerListaValores($query);	
					if($listHorario=="")
						$listHorario=-1;				
					$query="SELECT fechaFin from 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." AND '".$objSol->fechaAplicacion."'>=fechaInicio AND '".$objSol->fechaAplicacion."'<=fechaFin";
					$fechaFin=$con->obtenerValor($query);					
					if($fechaFin=="")
					{
						$query="SELECT fechaFin FROM 4520_grupos WHERE idGrupos=".$fSolicitud[9];
						$fechaFin=$con->obtenerValor($query);					
					}
					foreach($objSol->horarioCambio as $h)
					{
						$hInicioAux=explode(" ",$h->horaInicio);
						$hFinAux=explode(" ",$h->horaFin);
						$hInicio=strtotime($hInicioAux[0]);
						$hFin=strtotime($hFinAux[0]);
						$consulta[$x]="INSERT INTO 4522_horarioGrupo(idGrupo,dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin) VALUES(".$fSolicitud[9].",".$h->dia.",'".
						date("H:i",$hInicio)."','".date("H:i",$hFin)."',".$h->idAula.",'".$objSol->fechaAplicacion."','".$fechaFin."')";
						$x++;
						if(!isset($arrDiasSesion[$h->dia]))
							$arrDiasSesion[$h->dia]=date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
						else
							$arrDiasSesion[$h->dia].=", ".date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
					}
					$consulta[$x]="update 4522_horarioGrupo set fechaFin='".date("Y-m-d",strtotime("-1 days",strtotime($objSol->fechaAplicacion)))."' where idHorarioGrupo in (".$listHorario.")";
					$x++;
				break;
				case 5:  //finalizacion de suplencia
					$query="SELECT dteFechaBaja,idAsignacion FROM _449_tablaDinamica WHERE id__449_tablaDinamica=".$datos->idRegistro;
					$fAsignacion=$con->obtenerPrimeraFila($query);
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".$fAsignacion[0]."' 
									WHERE idAsignacionProfesorGrupo= ".$fAsignacion[1];
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".$fechaBaja."' WHERE situacion=60 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorSuplencia;
						$x++;
					}
				break;
				case 6: //Cambio de fecha
					$consulta[$x]="DELETE FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
					$x++;
					$consulta[$x]="UPDATE 4520_grupos SET fechaInicio='".$objSol->fechaInicio."',fechaFin='".$objSol->fechaTermino."' WHERE idGrupos=".$idGrupo;
					$x++;
					foreach($objSol->arrHorario as $o)
					{
						$hInicio=$o->hInicio;
						$dAux=explode(" ",$hInicio);
						$hInicio=$dAux[0];
						$hFin=$o->hFin;
						$dAux=explode(" ",$hFin);
						$hFin=$dAux[0];
						$consulta[$x]="INSERT INTO 4522_horarioGrupo(idGrupo,dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin) VALUES(".$idGrupo.",".$o->dia.",'".$hInicio."','".$hFin."',".$o->idAula.",'".$objSol->fechaInicio."','".$objSol->fechaTermino."')";
						$x++;
					}
					$query="select idAsignacionProfesorGrupo FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." and fechaBaja='".$fGrupo[5]."' and fechaAsignacion<fechaBaja";
					$idAsignacion=$con->obtenerValor($query);
					if($idAsignacion=="")
					{
						$query="select idAsignacionProfesorGrupo FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." and fechaAsignacion='".$fGrupo[6]."' and fechaAsignacion<fechaBaja";
						$idAsignacion=$con->obtenerValor($query);
					}
					if($idAsignacion!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET fechaAsignacion='".$objSol->fechaInicio."',fechaBaja='".$objSol->fechaTermino."' WHERE idAsignacionProfesorGrupo=".$idAsignacion;
						$x++;
					}
				break;				
			}
		}
		else
		{
			switch($fSolicitud[4])	
			{
				case 1:
					/*$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=4 WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idUsuario=".$objSol->idProfesorAsigna;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=4 WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorAsigna;
						$x++;
					}*/
					$consulta[$x]="delete from 4519_asignacionProfesorGrupo  WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idUsuario=".$objSol->idProfesorAsigna;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="delete from 4519_asignacionProfesorGrupo WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorAsigna;
						$x++;
					}
				break;
				case 2:
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1 WHERE situacion=61 AND idGrupo=".$fSolicitud[9]." AND idUsuario=".$objSol->idProfesorSuplencia;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1 WHERE situacion=61 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorSuplencia;
						$x++;
					}
				break;
				case 3:
					/*$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0 WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idParticipacion=45 
								and idUsuario=".$objSol->idProfesorSuple;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0 WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idParticipacion=45 
								and idUsuario=".$objSol->idProfesorSuple;
						$x++;
					}*/
					$consulta[$x]="delete from  4519_asignacionProfesorGrupo  WHERE situacion=5 AND idGrupo=".$fSolicitud[9]." AND idParticipacion=45 
								and idUsuario=".$objSol->idProfesorSuple;
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="delete from  4519_asignacionProfesorGrupo  WHERE situacion=5 AND idGrupo in (".$listGrupos.") AND idParticipacion=45 
								and idUsuario=".$objSol->idProfesorSuple;
						$x++;
					}
				break;
				case 4:
				break;
				case 5:
					$query="SELECT dteFechaBaja,idAsignacion FROM _449_tablaDinamica WHERE id__449_tablaDinamica=".$datos->idRegistro;
					$fAsignacion=$con->obtenerPrimeraFila($query);
					$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1 
									WHERE idAsignacionProfesorGrupo= ".$fAsignacion[1];
					$x++;
					if($listGrupos!="")
					{
						$consulta[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1 WHERE situacion=6 AND idGrupo in (".$listGrupos.") AND idUsuario=".$objSol->idProfesorSuplencia;
						$x++;
					}
				break;
				case 6:
				break;
				
			}
		}
		$consulta[$x]="UPDATE 4548_solicitudesMovimientoGrupo SET situacion=0,fechaRespuesta='".date("Y-m-d H:i")."',responsableRespuesta=".$_SESSION["idUsr"].",idRespuesta=".$obj->resultado.",comentarios='".cv($obj->comentarios)."' WHERE 
					idSolicitudMovimiento=".$obj->idSolicitud;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			if($obj->resultado==2)
			{
				switch($fSolicitud[4])
				{
					case 4:
						/*$query="SELECT COUNT(idSesion) FROM 4530_sesiones WHERE idGrupo=".$fSolicitud[9];
						$nSesion=$con->obtenerValor($query);
						if($nSesion>0)
						{
							$fechaAplicacion=strtotime($objSol->fechaAplicacion);
							$fechaActual=strtotime(date("Y-m-d"));
							if($fechaAplicacion<$fechaActual)
								  $fechaAplicacion=$fechaActual;
							$consulta=array();
							$x=0;
							ajustarSesiones($fSolicitud[9],$fechaAplicacion,NULL,$consulta,$x,true);
							  
						}*/
					case 6:
						/*$fechaAplicacion=strtotime($objSol->fechaInicio);
						$consulta=array();
						$x=0;*/
						ajustarFechaFinalCurso($fSolicitud[9]);
						/*//ajustarSesiones($fSolicitud[9],$fechaAplicacion,NULL,$consulta,$x,true);*/
					break;
				}
			}
			echo "1|";
		}
	}
	
	function obtenerHistorialAMES()
	{
		global $con;
		global $dic;
		global $arrDiasSemana;
		$consulta="";
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			$consulta="SELECT * FROM 4548_solicitudesMovimientoGrupo WHERE idGrupo=".$idGrupo." and situacion<>5";
		}
		else
			$consulta="SELECT * FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$_POST["idSolicitudMovimiento"];

		$resAMES=$con->obtenerFilas($consulta);
		$arrSolicitudes="";
		$ct=0;
		while($fSolicitud=mysql_fetch_row($resAMES))
		{
			$datos=json_decode($fSolicitud[5]);
			

			$descripcion="";
			$cadObj=$fSolicitud[5];
			switch($fSolicitud[4])
			{
				case 1: //Alta d eprofesor
					$obj=json_decode($cadObj);
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorAsigna;
					$nProfesor=$con->obtenerValor($consulta);
					$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$descripcion="Asignación del profesor ".$nProfesor." al grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": <b>".$fMateria[0]."</b>";
					if(isset($datos->fechaReemplaza))
					{
						$descripcion.=" a partir del día: ".date("d/m/Y",strtotime($datos->fechaReemplaza));
					}
					
					
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
					$tabla="";
					$fechaInicioH=$con->obtenerValor($consulta);
					if($fechaInicioH!="")
					{
						$fechaActual=strtotime(date("Y-m-d"));
						$fechaInicioH=strtotime($fechaInicioH);
						$consulta="";
						if($fechaInicioH>$fechaActual)
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
						else
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." and '".date("Y-m-d",$fechaActual)."'>=fechaInicio and '".date("Y-m-d",$fechaActual)."'<=fechaFin";
						$resH=$con->obtenerFilas($consulta);
						$listHorarioAct="<table>";
						
						while($filaHorario=mysql_fetch_row($resH))
						{
							
							$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaHorario[3];
							$nAula=$con->obtenerValor($consulta);
							$listHorarioAct.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$filaHorario[0]])." ".date("H:i",strtotime($filaHorario[1]))."-".date("H:i",strtotime($filaHorario[2]))." (Aula: ".$nAula.")<br></td></tr>";
						}
						$listHorarioAct.="</table>";
						$tabla='<table>
									<tr>
										<td align=\'center\' width=\'600\'>
											<span class=\'letraFichaRespuesta\'>
										Horario actual
											</span>
										</td>
										
									</tr>
									<tr>
										<td align=\'left\'>
										'.$listHorarioAct.'
										</td>
										
									</tr>
								</table>';
					}
					$descripcion.="<br><br>".$tabla;
				break;
				case 2://Baja de profesor
					$obj=json_decode($cadObj);
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuplencia;
					$nProfesor=$con->obtenerValor($consulta);
					$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$consulta="SELECT fechaBaja,m.motivo FROM _447_tablaDinamica t,_448_motivoBajaGrid m WHERE id__447_tablaDinamica=".$obj->idRegistro." 
								and m.id__448_motivoBajaGrid=t.motivoBaja";
					$fRegistro=$con->obtenerPrimeraFila($consulta);
					$fechaInicioBaja=date("d/m/Y",strtotime($fRegistro[0]));
					$motivo=$fRegistro[1];
					$descripcion="Baja del profesor ".$nProfesor." del grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": <b>".$fMateria[0]."</b> a partir del día: ".$fechaInicioBaja." por el siguiente motivo: ".$motivo;
					if(isset($datos->idProfesorSuple)&&($datos->idProfesorSuple!=-1))
					{
						$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$datos->idProfesorSuple;
						$nProfesor=$con->obtenerValor($consulta);
						$descripcion.="<br><br>El <font color='red'><b>nuevo profesor</b></font> titular del grupo ser&aacute; <b>".$nProfesor."</b> a partir del día: ".date("d/m/Y",strtotime($datos->fechaReemplaza));
					}
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
					$tabla="";
					$fechaInicioH=$con->obtenerValor($consulta);
					if($fechaInicioH!="")
					{
						$fechaActual=strtotime(date("Y-m-d"));
						$fechaInicioH=strtotime($fechaInicioH);
						$consulta="";
						if($fechaInicioH>$fechaActual)
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
						else
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." and '".date("Y-m-d",$fechaActual)."'>=fechaInicio and '".date("Y-m-d",$fechaActual)."'<=fechaFin";
						$resH=$con->obtenerFilas($consulta);
						$listHorarioAct="<table>";
						
						while($filaHorario=mysql_fetch_row($resH))
						{
							
							$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaHorario[3];
							$nAula=$con->obtenerValor($consulta);
							$listHorarioAct.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$filaHorario[0]])." ".date("H:i",strtotime($filaHorario[1]))."-".date("H:i",strtotime($filaHorario[2]))." (Aula: ".$nAula.")<br></td></tr>";
						}
						$listHorarioAct.="</table>";
						$tabla='<table>
									<tr>
										<td align=\'center\' width=\'600\'>
											<span class=\'letraFichaRespuesta\'>
										Horario actual
											</span>
										</td>
										
									</tr>
									<tr>
										<td align=\'left\'>
										'.$listHorarioAct.'
										</td>
										
									</tr>
								</table>';
					}
					$descripcion.="<br><br>".$tabla;
				break;
				case 3://Suplencia del profesor
					$obj=json_decode($cadObj);
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuplencia;
					$nProfesor=$con->obtenerValor($consulta);
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$obj->idProfesorSuple;
					$nProfesorSuple=$con->obtenerValor($consulta);
					
					$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$consulta="SELECT fechaBaja,m.motivo,fechaRegreso FROM _447_tablaDinamica t,_448_motivoBajaGrid m WHERE id__447_tablaDinamica=".$obj->idRegistro." 
								and m.id__448_motivoBajaGrid=t.motivoBaja";
					$fRegistro=$con->obtenerPrimeraFila($consulta);
					$fechaInicioBaja=date("d/m/Y",strtotime($fRegistro[0]));
					$fechaFinSuplencia=date("d/m/Y",strtotime($fRegistro[2]));
					$descripcion="Suplencia del profesor ".$nProfesor." del grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": <b>".$fMateria[0]."</b> por el profesor: ".$nProfesorSuple." a partir del día: ".$fechaInicioBaja." hasta el día: ".$fechaFinSuplencia;
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
					$tabla="";
					$fechaInicioH=$con->obtenerValor($consulta);
					if($fechaInicioH!="")
					{
						$fechaActual=strtotime(date("Y-m-d"));
						$fechaInicioH=strtotime($fechaInicioH);
						$consulta="";
						if($fechaInicioH>$fechaActual)
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
						else
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." and '".date("Y-m-d",$fechaActual)."'>=fechaInicio and '".date("Y-m-d",$fechaActual)."'<=fechaFin";
						$resH=$con->obtenerFilas($consulta);
						$listHorarioAct="<table>";
						
						while($filaHorario=mysql_fetch_row($resH))
						{
							
							$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaHorario[3];
							$nAula=$con->obtenerValor($consulta);
							$listHorarioAct.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$filaHorario[0]])." ".date("H:i",strtotime($filaHorario[1]))."-".date("H:i",strtotime($filaHorario[2]))." (Aula: ".$nAula.")<br></td></tr>";
						}
						$listHorarioAct.="</table>";
						$tabla='<table>
									<tr>
										<td align=\'center\' width=\'600\'>
											<span class=\'letraFichaRespuesta\'>
										Horario actual
											</span>
										</td>
										
									</tr>
									<tr>
										<td align=\'left\'>
										'.$listHorarioAct.'
										</td>
										
									</tr>
								</table>';
					}
					$descripcion.="<br><br>".$tabla;
				break;
				case 4://Cambio de horario
					$obj=json_decode($cadObj);
					$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$listHorarioAct="<table>";
					
					foreach($obj->horarioAnt as $d)
					{
						$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$d->idAula;
						$nAula=$con->obtenerValor($consulta);
						$listHorarioAct.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$d->dia])." ".$d->horaInicio."-".$d->horaFin."<br>(Aula: ".$nAula.")<br></td></tr>";
					}
					$listHorarioAct.="</table>";
					$listHorarioMod="<Table>";
					foreach($obj->horarioCambio as $d)
					{
						$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$d->idAula;
						$nAula=$con->obtenerValor($consulta);
						$listHorarioMod.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$d->dia])." ".$d->horaInicio."-".$d->horaFin."<br>(Aula: ".$nAula.")<br></td></tr>";
					}
					$listHorarioMod.="</Table>";
					$tabla='<table>
								<tr>
									<td align=\'center\' width=\'350\'>
										<span class=\'letraFichaRespuesta\'>
									Horario actual
										</span>
									</td>
									<td align=\'center\' width=\'350\'>
										<span class=\'letraFichaRespuesta\'>
									Propuesta de horario
										</span>
									</td>
								</tr>
								<tr>
									<td align=\'left\'>
									'.$listHorarioAct.'
									</td>
									<td align=\'left\'>
									'.$listHorarioMod.'
									</td>
								</tr>
							</table><br>
							<span class=\'letraFichaRespuesta\'><b>Motivo:</b></span> '.$obj->motivo.'<br>';
					$descripcion="Solicitud de cambio de horario del grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).
								": <b>".$fMateria[0]."</b> a partir del día: <b>".date("d/m/Y",strtotime($obj->fechaAplicacion))."</b> de la siguiente manera: <bR><br>".$tabla;
				break;
				case 5: //Finalizacion de suplencia
					$consulta="SELECT dteFechaBaja,idAsignacion FROM _449_tablaDinamica WHERE id__449_tablaDinamica=".$datos->idRegistro;
					$fDatos=$con->obtenerPrimeraFila($consulta);
					$consulta="SELECT idUsuario,fechaAsignacion,fechaBaja,idGrupo FROM 4519_asignacionProfesorGrupo WHERE idAsignacionProfesorGrupo=".$fDatos[1];
					$fAsignacion=$con->obtenerPrimeraFila($consulta);
					$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$fAsignacion[0];
					$nProfesor=$con->obtenerValor($consulta);
					$consulta="SELECT m.nombreMateria,nombreGrupo FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fAsignacion[3];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$descripcion="Finalización de suplencia (del ".date("d/m/Y",strtotime($fAsignacion[1]))." al ".date("d/m/Y",strtotime($fAsignacion[2])).
									") del profesor ".$nProfesor." del grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"].
									" ".$dic["materia"]["s"]["et"]).": <b>".$fMateria[0]."</b>  a partir del día: ".date("d/m/Y",strtotime($fDatos[0]));
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
					$tabla="";
					$fechaInicioH=$con->obtenerValor($consulta);
					if($fechaInicioH!="")
					{
						$fechaActual=strtotime(date("Y-m-d"));
						$fechaInicioH=strtotime($fechaInicioH);
						$consulta="";
						if($fechaInicioH>$fechaActual)
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9];
						else
							$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$fSolicitud[9]." and '".date("Y-m-d",$fechaActual)."'>=fechaInicio and '".date("Y-m-d",$fechaActual)."'<=fechaFin";
						$resH=$con->obtenerFilas($consulta);
						$listHorarioAct="<table>";
						
						while($filaHorario=mysql_fetch_row($resH))
						{
							
							$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$filaHorario[3];
							$nAula=$con->obtenerValor($consulta);
							$listHorarioAct.='<tr><td><img src=\'../images/bullet_green.png\'></td><td>'.utf8_encode($arrDiasSemana[$filaHorario[0]])." ".date("H:i",strtotime($filaHorario[1]))."-".date("H:i",strtotime($filaHorario[2]))." (Aula: ".$nAula.")<br></td></tr>";
						}
						$listHorarioAct.="</table>";
						$tabla='<table>
									<tr>
										<td align=\'center\' width=\'600\'>
											<span class=\'letraFichaRespuesta\'>
										Horario actual
											</span>
										</td>
										
									</tr>
									<tr>
										<td align=\'left\'>
										'.$listHorarioAct.'
										</td>
										
									</tr>
								</table>';
					}
					$descripcion.="<br><br>".$tabla;
				break;
				case 6:  //Cambio de fecha
					$obj=json_decode($cadObj);
					$tabla="";
					$consulta="SELECT m.nombreMateria,nombreGrupo,fechaInicio,fechaFin FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fSolicitud[9];
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$descripcion="Cambio de fecha de inicio de curso del grupo <b>".$fMateria[1]."</b> de ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"]).": <b>".$fMateria[0]."</b></td></tr>";
					$listHorarioAct="Del ".date("d/m/Y",strtotime($fMateria[2]))." al ".date("d/m/Y",strtotime($fMateria[3]));
					$fechaTermino=$obj->fechaTermino;
					$listHorarioMod="Del ".date("d/m/Y",strtotime($obj->fechaInicio))." al ".date("d/m/Y",strtotime($fechaTermino));
					$listHAct="";
					$listHMod="";
					$listHMod="<Table>";
					foreach($obj->arrHorario as $h)
					{
						$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$h->idAula;
						$nAula=$con->obtenerValor($consulta);
						$listHMod.="<tr><td><img src='../images/bullet_green.png'></td><td>".utf8_encode($arrDiasSemana[$h->dia])." ".$h->hInicio."-".$h->hFin."<br>(Aula: ".$nAula.")<br>";
					}
					$listHMod.="</Table>";
					$fechaActual=date("Y-m-d");
					$idGrupo=$fSolicitud[9];
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
					$fechaInicioH=$con->obtenerValor($consulta);
					$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
					if($fechaInicioH!="")
					{
						$fechaInicioH=strtotime($fechaInicioH);
						if($fechaInicioH<=strtotime(date("Y-m-d")))
						{
							$consulta="SELECT max(fechaFin) FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
							
							$fecha=$con->obtenerValor($consulta);
							$fechaH=strtotime($fecha);
							if($fechaH<strtotime(date("Y-m-d")))
								$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and fechaFin='".date("Y-m-d",$fechaH)."' and fechaInicio<=fechaFin";
							else
								$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and '".$fechaActual."'>=fechaInicio and '".$fechaActual."'<=fechaFin";
						}
						else
						{
							$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and fechaInicio='".date("Y-m-d",$fechaInicioH)."' and fechaInicio<=fechaFin";
						}
					}
					$res=$con->obtenerFilas($consulta);
					$listHAct="<Table>";
					while($fHorario=mysql_fetch_row($res))
					{
						$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fHorario[4];
						$nAula=$con->obtenerValor($consulta);
						$listHAct.="<tr><td><img src='../images/bullet_green.png'></td><td>".utf8_encode($arrDiasSemana[$fHorario[1]])." ".date("H:i A",strtotime($fHorario[2]))."-".date("H:i A",strtotime($fHorario[3]))."<br>(Aula: ".$nAula.")<br>";
					}
					$listHAct.="</Table>";
					$tabla='<table>
								<tr>
									<td align=\'center\' width=\'350\'>
										<span class=\'letraFichaRespuesta\'>
									Fecha actual del curso
										</span>
									</td>
									<td align=\'center\' width=\'350\'>
										<span class=\'letraFichaRespuesta\'>
									Propuesta de fecha de curso
										</span>
									</td>
								</tr>
								<tr>
									<td align=\'center\'>
									'.$listHorarioAct.'
									</td>
									<td align=\'center\'>
									'.$listHorarioMod.'
									</td>
								</tr>
								<tr>
									<td align=\'center\'>
									<br>
									<span class=\'letraFichaRespuesta\'>
									Horario
									</span>
									</td>
									<td align=\'center\'>
									<br>
									<span class=\'letraFichaRespuesta\'>
									Horario
									</span>
									</td>
								</tr>
								<tr>
									<td align=\'center\'>
									'.$listHAct.'
									</td>
									<td align=\'center\'>
									'.$listHMod.'
									</td>
								</tr>
							</table><br>
							<span class=\'letraFichaRespuesta\'><b>Motivo:</b></span> '.$obj->motivo.'<br>';
					
					
					
					$descripcion.="<br><br>".$tabla;
				break;
				
				
			}
			$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$fSolicitud[2];
			$respSolicitud=$con->obtenerValor($consulta);
			if($fSolicitud[8]=="")
				$fSolicitud[8]=-1;
			$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica i where idUsuario=".$fSolicitud[8];
			$respRespuesta=$con->obtenerValor($consulta);
			if($fSolicitud[6]==-1)
				$fSolicitud[11]=-1;
			$obj='{"folio":"'.$fSolicitud[12].'","descSolicitud":"'.cv($descripcion).'","idSolicitudMovimiento":"'.$fSolicitud[0].'","responsableSolicitud":"'.$respSolicitud.'","fechaSolicitud":"'.$fSolicitud[1].'",
				"fechaRespuesta":"'.$fSolicitud[7].'","responsableRespuesta":"'.$respRespuesta.'","dictamen":"'.$fSolicitud[11].'","comentarios":"'.cv($fSolicitud[10]).'"}';
			if($arrSolicitudes=="")
				$arrSolicitudes=$obj;
			else
				$arrSolicitudes.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrSolicitudes.']}';
	}
	
	function registrarCambioHorario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$idGrupo=$obj->idGrupo;
		$consulta="SELECT idCambioHorario FROM 4550_solicitudesCambioHorario WHERE situacion=1 AND idGrupo=".$idGrupo;
		$idCambioHorario=$con->obtenerValor($consulta);
		if($idCambioHorario=="")
		{
			$consulta="insert into 4550_solicitudesCambioHorario(fechaSolicitud,idResponsableSolicitud,situacion,idGrupo) 
						values('".date("Y-m-d")."',".$_SESSION["idUsr"].",1,".$idGrupo.")";
			if($con->ejecutarConsulta($consulta))	
			{
				$idCambioHorario=$con->obtenerUltimoID();
			}
		}
		if($obj->idHorario=="-1")
		{
			$consulta="INSERT INTO 4551_horarioSolicitud(idBloqueHorario,dia,horaInicio,horaFinal,idSolicitud)
						VALUES(".$obj->idBloqueHorario.",".$obj->dia.",'".$obj->horaInicial."','".$obj->horaFinal."',".$idCambioHorario.")";
						
		}
		else
		{
			$consulta="update 4551_horarioSolicitud set dia=".$obj->dia.",horaInicio='".$obj->horaInicial."',horaFinal='".$obj->horaFinal."' where idCambioHorario=".$obj->idHorario;

		
		}
		eC($consulta);
	}
	
	function registrarSolicitudModificacionHorario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		

		$consulta="SELECT idInstanciaPlanEstudio,fechaInicio,fechaFin,idCiclo,idMateria FROM 4520_grupos WHERE idGrupos=".$obj->idGrupo;
		$filaGrupo=$con->obtenerPrimeraFila($consulta);
		$idInstanciaPlan=$filaGrupo[0];
		$consulta="SELECT idHorarioGrupo FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo;
		$listHorario=$con->obtenerListaValores($consulta);
		if($listHorario=="")
			$listHorario=-1;
		$objDatosHorarioAnt="";
		$permiteContinuar=true;
		$cadObj="";
		$cadCasos="";
		$fechaAplicacion=$obj->fechaAplicacion;
		if($obj->validar==1)
		{
			foreach($obj->horario as $h)
			{
				$resultado=validarCambioHorario($h,$obj->idGrupo,$filaGrupo[4],$listHorario,$filaGrupo[3],$fechaAplicacion);
				
				
				$arrRes=explode("|",$resultado);
				if($arrRes[0]==2)
				{
					$objRes=json_decode($arrRes[1]);
					if($objRes->permiteContinuar==0)
					{
						
						$permiteContinuar=false;
					}
					foreach($objRes->arrCasos as $c)
					{
						$objAux=json_encode($c);
						if($cadCasos=="")
							$cadCasos=$objAux;
						else
							$cadCasos.=",".$objAux;
						
					}
					
				}
			}
		}
		$pC=0;
		
		if($permiteContinuar)
			$pC=1;
		$cadObjRes='{"permiteContinuar":"'.$pC.'","arrCasos":['.$cadCasos.']}';
		if($cadCasos!="")
		{
			echo "2|".$cadObjRes;
			return;
		}
		$folioAME=generarFolioAME($obj->idGrupo);
		
		$fechaActual=date("Y-m-d");
		$consulta="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo." and fechaInicio<='".$fechaActual."' and fechaFin>='".$fechaActual."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$objA='{"dia":"'.$fila[0].'","horaInicio":"'.date("H:i A",strtotime("1984-05-10 ".$fila[1])).'","horaFin":"'.date("H:i A",strtotime("1984-05-10 ".$fila[2])).'","idAula":"'.$fila[3].'"}';
			if($objDatosHorarioAnt=="")
				$objDatosHorarioAnt=$objA;
			else
				$objDatosHorarioAnt.=",".$objA;
			
		}
		$objDatosHorarioCambio="";
		foreach($obj->horario as $h)
		{
			$dHora=explode(" ",$h->hInicio);
			$h->hInicio=$dHora[0];
			$dHora=explode(" ",$h->hFin);
			$h->hFin=$dHora[0];
			$objA='{"dia":"'.$h->dia.'","horaInicio":"'.date("H:i A",strtotime("1984-05-10 ".$h->hInicio)).'","horaFin":"'.date("H:i A",strtotime("1984-05-10 ".$h->hFin)).'","idAula":"'.$h->idAula.'"}';
			if($objDatosHorarioCambio=="")
				$objDatosHorarioCambio=$objA;
			else
				$objDatosHorarioCambio.=",".$objA;
		}
		
		$cadObjFinal='{"fechaAplicacion":"'.$obj->fechaAplicacion.'","motivo":"'.cv(str_replace('"',"'",$obj->motivoCambio)).'","horarioAnt":['.$objDatosHorarioAnt.'],"horarioCambio":['.$objDatosHorarioCambio.']}';
		
		$consulta="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,responsableSolicitud,idInstanciaPlan,tipoSolicitud,datosSolicitud,
					situacion,idGrupo,folio) VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idInstanciaPlan.",4,'".$cadObjFinal."',1,".$obj->idGrupo.",'".$folioAME."')";

		eC($consulta);
		
	}
	
	function obtenerComentariosEvaluacionPlanEstudio()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$plantel="";
		$comp="";
		if($idInstancia!=-1)
			$comp=" and idInstanciaPlanEstudio=".$idInstancia;
		if(isset($_POST["plantel"]))	
			$plantel=$_POST["plantel"];
		
		if($plantel!="")
		{
			$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$plantel."' AND situacion=1";
			$listInstancias=$con->obtenerListaValores($consulta);
			
			$comp.=" and idInstanciaPlanEstudio in (".$listInstancias.")";
		}
		$consulta="SELECT  idComentariosValidacionPlan AS idComentarioSeccion,comentario,fechaComentario,situacion,
					(SELECT CONCAT(nombrePlanEstudios,', Modalidad:',m.nombre,', Turno:',t.turno) AS planEstudios FROM 4513_instanciaPlanEstudio i,
				4514_tipoModalidad m,4516_turnos t WHERE idInstanciaPlanEstudio=c.idInstanciaPlanEstudio AND m.idModalidad=i.idModalidad AND t.idTurno=i.idTurno) as planEstudio FROM 4551_comentariosValidacionPlan c WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." ".$comp." ORDER BY fechaComentario desc";
		$arrReg=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function guardarComentarioValidacionPlanEstudio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idComentario==-1)
		{
			$consulta="INSERT INTO 4551_comentariosValidacionPlan(comentario,fechaComentario,idResponsableComentario,idCiclo,idPeriodo,idInstanciaPlanEstudio)
					VALUES('".cv($obj->comentario)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->idCiclo.",".$obj->idPeriodo.",".$obj->idInstancia.")";
		}
		else
		{
			$consulta="update 4551_comentariosValidacionPlan set comentario='".cv($obj->comentario)."',fechaComentario='".date("Y-m-d H:i")."' where idComentariosValidacionPlan=".$obj->idComentario;
		}
		eC($consulta);
	}
	
	
	function removerComentarioValidacionPlanEstudio()
	{
		global $con;
		$idComentario=$_POST["idComentario"];
		$consulta="delete from  4551_comentariosValidacionPlan where idComentariosValidacionPlan=".$idComentario;
		eC($consulta);
	}
	
	function cambiarSituacionComentarioValidacionPlanEstudio()
	{
		global $con;
		$idComentario=$_POST["idComentario"];
		$situacion=$_POST["situacion"];
		$consulta="update 4551_comentariosValidacionPlan set situacion=".$situacion." where idComentariosValidacionPlan=".$idComentario;
		eC($consulta);
	}
	
	function obteneGruposMaestro()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT idGrupoPadre,nombreGrupo FROM 4540_gruposMaestros WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." 
					AND idInstanciaPlanEstudio=".$idInstancia." ORDER BY nombreGrupo";
		$arr=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arr;
		
	}
	
	function obtenerSituacionDictamenesPlanEstudio()
	{
		global $con;
		$consulta="SELECT idCiclo,nombreCiclo FROM 4526_ciclosEscolares ORDER BY nombreCiclo DESC";
		$resCiclo=$con->obtenerFilas($consulta);
		$arrObjetos="";
		$ct=0;
		$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$_SESSION["codigoInstitucion"]."'";
		$listInstancias=$con->obtenerListaValores($consulta);
		
		while($filaCiclo=mysql_fetch_row($resCiclo))
		{
			$consulta="SELECT id__464_gridPeriodos,nombrePeriodo FROM _464_gridPeriodos";
			$resPeriodo=$con->obtenerFilas($consulta);
			while($fPeriodo=mysql_fetch_row($resPeriodo))
			{
				$consulta="SELECT situacion,fechaDictamen,comentarios FROM 4547_situacionInstanciaPlan WHERE idCiclo=".$filaCiclo[0]." AND idPeriodo=".$fPeriodo[0]." AND plantel='".$_SESSION["codigoInstitucion"]."' AND STATUS=1";
				$fSituacion=$con->obtenerPrimeraFila($consulta);
				$situacion=$fSituacion[0];
				$fechaDictamen=$fSituacion[1];
				$comentarios=$fSituacion[2];
				$consulta="SELECT COUNT(*) FROM 4551_comentariosValidacionPlan WHERE idCiclo=".$filaCiclo[0]." AND idPeriodo=".$fPeriodo[0]." AND idInstanciaPlanEstudio IN (".$listInstancias.")";
				$nComentarios=$con->obtenerValor($consulta);
				if($situacion=="")
					$situacion=0;
				$obj='{"comentarios":"'.cv($comentarios).'","fechaDictamen":"'.$fechaDictamen.'","idCiclo":"'.$filaCiclo[0].'","idPeriodo":"'.$fPeriodo[0].'","ciclo":"'.$filaCiclo[1].'","periodo":"'.$fPeriodo[1].'","situacion":"'.$situacion.'","noComentarios":"'.$nComentarios.'"}';
				if($arrObjetos=="")
					$arrObjetos=$obj;
				else
					$arrObjetos.=",".$obj;
				$ct++;
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObjetos.']}';
		
	}
	
	function obtenerMateriasGradoDisponibles()
	{
		global $con;
		$idGrado=$_POST["idGrado"];
		$idCiclo=$_POST["idCiclo"];	
		$idPeriodo=$_POST["idPeriodo"];	
		$idMateriaReemplazo=$_POST["idMateriaReemplazo"];
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idUnidad=".$idGrado." AND tipoUnidad=3";
		$codigoPadre=$con->obtenerValor($consulta);
		$consulta="SELECT idUnidad,tipoUnidad,idEstructuraCurricular FROM 4505_estructuraCurricular WHERE codigoPadre='".$codigoPadre."' AND idPlanEstudio=".$idPlanEstudio;
		$resMat=$con->obtenerFilas($consulta);
		$arrObj="";
		$ct=0;
		while($filaMat=mysql_fetch_row($resMat))
		{
			$consulta="";
			if($filaMat[1]==1)
				$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$filaMat[0];
			else
				$consulta="SELECT nombreUnidad FROM 4508_unidadesContenedora WHERE idUnidadContenedora=".$filaMat[0];
			
			$nombreMateria=$con->obtenerValor($consulta);
			if(($filaMat[1]==2)||(cumpleRequisitos($filaMat[0],$idMateriaReemplazo,$idGrado,$idPlanEstudio,$idCiclo,$idPeriodo,$idInstanciaPlan)))
			{	
				$obj='{"idMateria":"'.$filaMat[2].'","nombreMateria":"'.$nombreMateria.'","tUnidad":"'.$filaMat[1].'"}';
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
				$ct++;
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObj.']}';
		
	}
	
	function guardarReemplazoMateria()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idCiclo=$obj->idCiclo;
		$idPeriodo=$obj->idPeriodo;
		$idInstancia=$obj->idInstanciaPlan;
		$motivoCambio=$obj->motivoCambio;
		$idElementCambio=$obj->idElementoCambio;
		$idMateriaO=$obj->idMateriaOrigen;
		$tipoUnidad=$obj->tipoUnidad;
		
		$iEOrigen="";
		$iECambio="";

		
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="SELECT codigoUnidad,idUnidad FROM 4505_estructuraCurricular WHERE idEstructuraCurricular=".$idElementCambio;
		$fDestino=$con->obtenerPrimeraFila($consulta);
		$idMateriaD=$fDestino[1];
		$cUnidad=$fDestino[0];
		$uGrado1=substr($cUnidad,0,3);
		$consulta="SELECT g.ordenGrado FROM 4505_estructuraCurricular e,4501_Grado g WHERE codigoUnidad='".$uGrado1."' AND e.idPlanEstudio=".$idPlanEstudio." and g.idGrado=e.idUnidad";
		$oGrado1=$con->obtenerValor($consulta);
		
		$consulta="SELECT codigoUnidad,idEstructuraCurricular FROM 4505_estructuraCurricular e WHERE idUnidad=".$idMateriaO." AND tipoUnidad=".$tipoUnidad." and e.idPlanEstudio=".$idPlanEstudio;

		$fOrigen=$con->obtenerPrimeraFila($consulta);
		$cUnidad=$fOrigen[0];
		$uGrado2=substr($cUnidad,0,3);
		$consulta="SELECT g.ordenGrado FROM 4505_estructuraCurricular e,4501_Grado g WHERE codigoUnidad='".$uGrado2."' AND e.idPlanEstudio=".$idPlanEstudio." and g.idGrado=e.idUnidad";
		$oGrado2=$con->obtenerValor($consulta);
		if($oGrado1>$oGrado2)
		{
			$iEOrigen=$idElementCambio;
			$iECambio=$fOrigen[1];
		}
		else
		{
			$iEOrigen=$fOrigen[1];
			$iECambio=$idElementCambio;
		}

		$query="INSERT INTO 4552_intercambiosMateria(idElementoOrigen,idElementoCambio,idInstanciaPlan,idCiclo,idPeriodo,motivoCambio,responsableCambio,fechaCambio)
					VALUES(".$iEOrigen.",".$iECambio.",".$idInstancia.",".$idCiclo.",".$idPeriodo.",'".cv($obj->motivoCambio)."',".$_SESSION["idUsr"].",'".date("Y-m-d H:i")."')";
		
		if($con->ejecutarConsulta($query))
		{
			$idRegistro=$con->obtenerUltimoId();

			$consulta="select * from 4540_gruposMaestros where idInstanciaPlanEstudio=".$idInstancia." and codigoGrado='".$uGrado2."' 
					and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;

			$resGruposM=$con->obtenerFilas($consulta);
			while($fPadre=mysql_fetch_row($resGruposM))
			{
				crearGrupoMateriaUnica($idInstancia,$idMateriaD,$fPadre[0],$idMateriaO,$idRegistro,0);
			}
			echo "1|";
		}
		
	}
	
	function cancerarIntercambioMateria()
	{
		global $con;
		global $dic;
		$idRegistro=$_POST["idRegistro"];
		$query="select idGrupos from 4520_grupos WHERE idRegistroReemplazo=".$idRegistro;
		$listGrupos=$con->obtenerListaValores($query);
		if($listGrupos=="")
			$listGrupos=-1;
		$query="SELECT COUNT(*) FROM 4522_horarioGrupo WHERE idGrupo IN(".$listGrupos.")";
		$nHorario=$con->obtenerValor($query);
		if($nHorario>0)
		{
			echo "<br>Ya existen ".strtolower($dic["grupo"]["p"]["et"])." asociados a ".strtolower($dic["materia"]["s"]["este"]." ".$dic["materia"]["s"]["et"])." que cuentan con horario asignado";
			return;
		}
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4552_intercambiosMateria WHERE idMateriaIntercambio=".$idRegistro;
		$x++;
		$consulta[$x]="delete from 4520_grupos WHERE idRegistroReemplazo=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function removerGradoEstructuraCurricular()
	{
		global $con;
		
		$idInstanciaPlanEstudio=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$grado=$_POST["grado"];
		$consulta="DELETE FROM 4546_estructuraPeriodo WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." and grado='".$grado."' and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;
		if($con->ejecutarConsulta($consulta))
		{
			if($con->existeTabla("4500_gradosInstanciaPlanModificados"))
			{
				$consulta="INSERT INTO 4500_gradosInstanciaPlanModificados(idInstancia,idCiclo,idPeriodo) VALUES(".$idInstanciaPlanEstudio.",".$idCiclo.",".$idPeriodo.")";
				eC($consulta);				
			}
			else
				echo "1|";
		}
	}
	
	function obtenerSiPuedeGenerarContrato()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];

		$consulta="SELECT situacion FROM 4547_situacionInstanciaPlan WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND plantel='".$_SESSION["codigoInstitucion"]."' and status=1";

		$situacion=$con->obtenerValor($consulta);
		$situacion=3;
		echo "1|".$situacion;
	}
	
	function obtenerTiposPeriodicidadPlantel()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$consulta="SELECT DISTINCT idPeriodicidad FROM 4513_instanciaPlanEstudio WHERE sede='".$plantel."'";
		$listPeriodicidad=$con->obtenerListaValores($consulta);
		if($listPeriodicidad=="")
			$listPeriodicidad=-1;
		$arrP="";
		$consulta="SELECT id__464_tablaDinamica,txtDescripcion FROM _464_tablaDinamica where id__464_tablaDinamica in (".$listPeriodicidad.") ORDER BY txtDescripcion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT id__464_gridPeriodos,nombrePeriodo,periodoDefaultActivo  FROM _464_gridPeriodos WHERE idReferencia=".$fila[0];
			$arrPeriodos=$con->obtenerFilasArreglo($consulta);
			$o="['".$fila[0]."','".cv($fila[1])."',".$arrPeriodos."]";
			if($arrP=="")
				$arrP=$o;
			else
				$arrP.=",".$o;
		}
		
		
		
		echo "1|[".$arrP."]";
	}
	
	function obtenerFechasPeriodoPlantel()
	{
		global $con;
		global $dic;
		$plantel=$_POST["plantel"];
		if($plantel=="")
			$plantel=-1;
		$idTipoPeriodo=$_POST["idTipoPeriodicidad"];
		if($idTipoPeriodo=="")	
			$idTipoPeriodo=-1;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		if($idPeriodo=='')
			$idPeriodo=-1;
			
		$idModalidad=$_POST["idModalidad"];
		$condModalidad="";
		if($idModalidad!="0")
		{
			$condModalidad=" and tm.idModalidad in (".$idModalidad.")";
		}
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		$condProgEducativo="";
		if($idProgramaEducativo!="0")
		{
			$condProgEducativo=" and p.idProgramaEducativo in (".$idProgramaEducativo.")";
		}	
		$cadArbol="";
		$numReg=0;
		$arrModalidad=array();
		$arrProgEducativo=array();
		$consulta="SELECT id__464_gridPeriodos,nombrePeriodo FROM _464_gridPeriodos WHERE idReferencia=".$idTipoPeriodo." and id__464_gridPeriodos=".$idPeriodo;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$llavePeriodo='1_'.$fila[0];
			$fechaIPeriodo="";
			$fechaFPeriodo="";
			$consulta="SELECT DISTINCT tm.idModalidad,tm.nombre FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad tm WHERE sede='".$plantel."' and idPeriodicidad=".$idTipoPeriodo." and tm.idModalidad=i.idModalidad ".$condModalidad." order by nombre";
			$resMod=$con->obtenerFilas($consulta);
			$hijos="";
			while($filaMod=mysql_fetch_row($resMod))
			{
				$llaveModalidad="2_".$fila[0]."_".$filaMod[0];
				$fechaIModalidad="";
				$fechaFModalidad="";
				$planSinFecha=false;
				$planes="";
				$consulta="SELECT idInstanciaPlanEstudio,nombrePlanEstudios,p.descripcion,i.cveRvoe FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE sede='".$plantel."' AND idModalidad=".$filaMod[0]." and 
							idPeriodicidad=".$idTipoPeriodo." and p.idPlanEstudio=i.idPlanEstudio ".$condProgEducativo."  ORDER BY nombrePlanEstudios";

				$resInstancias=$con->obtenerFilas($consulta);
				while($filaIns=mysql_fetch_row($resInstancias))
				{
					if(!isset($arrModalidad[$filaMod[0]]))
						$arrModalidad[$filaMod[0]]=$filaMod[1];
					
					$idProgramaEducativo=obtenerIdProgramaEducativoInstancia($filaIns[0]);
					$consulta="SELECT nombreProgramaEducativo FROM 4500_programasEducativos WHERE idProgramaEducativo=".$idProgramaEducativo;

					if(!isset($arrProgEducativo[$idProgramaEducativo]))
					{
						$fProgramaEducativo=$con->obtenerValor($consulta);
						$arrProgEducativo[$idProgramaEducativo]=$fProgramaEducativo;
					}
					$llaveInstancia="3_".$fila[0]."_".$filaMod[0]."_".$filaIns[0];
					
					$consulta="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$fila[0]." 
								AND idInstanciaPlanEstudio=".$filaIns[0];
					$fFechas=$con->obtenerPrimeraFila($consulta);
					
					$fechaInicio=$fFechas[0];
					if($fechaInicio!="")
					{
						$fechaInicio=date("d/m/Y",strtotime($fechaInicio));
						if($fechaIModalidad=="")
						{
							$fechaIModalidad=strtotime($fFechas[0]);
							$fechaFModalidad=strtotime($fFechas[1]);
							
						}
						else
						{
							if($fechaIModalidad>strtotime($fFechas[0]))
							{
								$fechaIModalidad=strtotime($fFechas[0]);
							}
							if($fechaFModalidad<strtotime($fFechas[1]))
							{
								$fechaFModalidad=strtotime($fFechas[1]);
							}
						}
					}
					else
						$planSinFecha=true;
						
					$fechaFin=$fFechas[1];
					if($fechaFin!="")
						$fechaFin=date("d/m/Y",strtotime($fechaFin));	
				
				
						
					$idReferenciaExamenes=obtenerPerfilExamenesAplica("",$filaIns[0]);
					$arrExamenes="";
					$consulta="SELECT idPeriodicidad,tipoEsquemaAsignacionFechasGrupo,numMaxBloquesFechas FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$filaIns[0];
	
					$fInstancia=$con->obtenerPrimeraFila($consulta);

					$tipoEsquemaAsignacionFechasGrupo=$fInstancia[1];
					$numMaxBloquesFechas=$fInstancia[2];
					
					
										
					if($tipoEsquemaAsignacionFechasGrupo==1)
					{
						
						$fechaMin=$fechaInicio;
						$fechaMax=$fechaFin;
						
						/*$consulta="SELECT id__720_tablaDinamica,e.examen,g.noExamen,g.etiquetaExamen,g.fechaAsignacion,g.tipoExamen FROM _398_gridTiposExamen g,_721_tablaDinamica t,_720_tablaDinamica e WHERE g.idReferencia=".$idReferenciaExamenes." 
									AND t.id__721_tablaDinamica=g.tipoExamen AND e.id__720_tablaDinamica=t.examen   ORDER BY t.prioridadAplicaExamen";
						*/
						
						$consulta="SELECT e.idTipoExamen,e.tipoExamen FROM 4622_catalogoTipoExamen e,4625_tiposExamenPerfilEvaluacion t WHERE idPerfil=".$idReferenciaExamenes." AND  e.idTipoExamen=t.idTipoExamen ORDER BY prioridad";
						
						$resExamenes=$con->obtenerFilas($consulta);		
						while($fExamen=mysql_fetch_row($resExamenes))	
						{
						
							
							$consulta="SELECT  DATE_FORMAT(fechaInicio,'%d/%m/%Y'), DATE_FORMAT(fechaFin,'%d/%m/%Y') FROM 4580_fechasExamenes WHERE idCiclo=".$idCiclo.
									" AND idPeriodo=".$fila[0]." AND idInstancia=".$filaIns[0]." and idExamen=".$fExamen[0]."  AND numBloque=0";
							$fFechaExamen=$con->obtenerPrimeraFila($consulta);
							
							$esquemaAsignacionFecha=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fExamen[0],4);
							
							if($esquemaAsignacionFecha==1)
								$esquemaAsignacionFecha=2;
							else
								$esquemaAsignacionFecha=1;
							
							if($esquemaAsignacionFecha==1)
							{
								
								$fechaMin=date("d/m/Y",strtotime("+1 days",strtotime(cambiaraFechaMysql($fechaMax))));
								
								$fechaMax=date("d/m/Y",strtotime("+2 days",strtotime(cambiaraFechaMysql($fechaMax))));
								
							}
							$oExamen="{esquemaFechas:'".$esquemaAsignacionFecha."',descripcion:'',unidad:'".cv($fExamen[1])."',id:'4_".$fila[0]."_".$filaIns[0]."_0_".$fExamen[0]."_1',fechaInicio:'".$fFechaExamen[0]."',fechaFin:'".$fFechaExamen[1].
									"',_is_leaf:true,_parent:'".$llaveInstancia."','fechaMin':'".$fechaMin."','fechaMax':'".$fechaMax."'}";
							$arrExamenes.=",".$oExamen;
						}
					}
					else
					{
						$oExamen="";
						for($nBloque=1;$nBloque<=$numMaxBloquesFechas;$nBloque++)
						{
							$fechaMin=$fechaInicio;
							$fechaMax=$fechaFin;
							$llaveBloque="5_".$fila[0]."_".$filaIns[0]."_".$nBloque;
							$oExamenAux="";
							
							$consulta="SELECT e.idTipoExamen,e.tipoExamen FROM 4622_catalogoTipoExamen e,4625_tiposExamenPerfilEvaluacion t WHERE idPerfil=".$idReferenciaExamenes." AND  e.idTipoExamen=t.idTipoExamen ORDER BY prioridad";
							$resExamenes=$con->obtenerFilas($consulta);		
							while($fExamen=mysql_fetch_row($resExamenes))	
							{
								
								$esquemaAsignacionFecha=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fExamen[0],4);
							
								if($esquemaAsignacionFecha==1)
									$esquemaAsignacionFecha=2;
								else
									$esquemaAsignacionFecha=1;
								
								
								if($esquemaAsignacionFecha==1)
								{
									$fechaMin=date("d/m/Y",strtotime("+1 days",strtotime(cambiaraFechaMysql($fechaMax))));
									$fechaMax=date("d/m/Y",strtotime("+2 days",strtotime(cambiaraFechaMysql($fechaMax))));
								}
								$consulta="SELECT DATE_FORMAT(fechaInicio,'%d/%m/%Y'), DATE_FORMAT(fechaFin,'%d/%m/%Y') FROM 4580_fechasExamenes WHERE idCiclo=".$idCiclo." AND idPeriodo=".$fila[0]." AND idInstancia=".$filaIns[0]." and idExamen=".$fExamen[0]." and numBloque=".$nBloque;
								$fFechaExamen=$con->obtenerPrimeraFila($consulta);
								$llaveExamen="4_".$fila[0]."_".$filaIns[0]."_".$nBloque."_".$fExamen[0]."_1";
								$oExamenAux.=",{esquemaFechas:'".$esquemaAsignacionFecha."',descripcion:'',unidad:'".cv($fExamen[1])."',id:'".$llaveExamen."',fechaInicio:'".$fFechaExamen[0]."',fechaFin:'".$fFechaExamen[1]."',_is_leaf:true,
											_parent:'".$llaveBloque."','fechaMin':'".$fechaMin."','fechaMax':'".$fechaMax."'}";
								
							}

							
							$consulta="SELECT fechaInicio,fechaFin FROM 4571_fechasBloquePeriodo WHERE idInstancia=".$filaIns[0]." 
										AND idCiclo=".$idCiclo." AND idPeriodo=".$fila[0]." AND noBloque=".$nBloque."";
										
							$fechaBloque=$con->obtenerPrimeraFila($consulta);
							$fechaInicioBloque="";
							$fechaFinBloque="";
							if($fechaBloque)
							{
								$fechaInicioBloque=date("d/m/Y", strtotime($fechaBloque[0]));
								if($fechaBloque[1]=="")
								{
									if(($nBloque+1)<=$numMaxBloquesFechas)
									{
										$consulta="SELECT fechaInicio FROM 4571_fechasBloquePeriodo WHERE idInstancia=".$filaIns[0]." 
										AND idCiclo=".$idCiclo." AND idPeriodo=".$fila[0]." AND noBloque=".($nBloque+1)."";

										$fechaFinBloque=$con->obtenerValor($consulta);

										if($fechaFinBloque!="")
										{
											$fechaFinBloque=date("d/m/Y",strtotime("-1 days",strtotime($fechaFinBloque)));
										}
										
									}
									else
									{
										$consulta="SELECT fechaFinal FROM 4544_fechasPeriodo WHERE idInstanciaPlanEstudio=".$filaIns[0]." 
													AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
										
										$fechaFinBloque=$con->obtenerValor($consulta);
										if($fechaFinBloque!="")
										{
											$fechaFinBloque=date("d/m/Y",strtotime($fechaFinBloque));
										}
										
									}
								}
								else
									$fechaFinBloque=date("d/m/Y", strtotime($fechaBloque[1]));
							}
							
							if($oExamenAux!="")
								$oExamen.=",{descripcion:'',unidad:'<b>Bloque ".$nBloque."</b>',id:'".$llaveBloque."',fechaInicio:'".$fechaInicioBloque."',fechaFin:'".$fechaFinBloque."',_is_leaf:false,_parent:'".$llaveInstancia."'}".$oExamenAux;
							else
								$oExamen.=",{descripcion:'',unidad:'<b>Bloque ".$nBloque."</b>',id:'".$llaveBloque."',fechaInicio:'".$fechaInicioBloque."',fechaFin:'".$fechaFinBloque."',_is_leaf:true,_parent:'".$llaveInstancia."'}".$oExamenAux;
							
						}	
						if($oExamen!="")
							$arrExamenes.=$oExamen;
						
						
					}
					
					$hoja="false";
					if($arrExamenes=="")
						$hoja="true";
					$obj="{descripcion:'".cv($filaIns[2])."',unidad:'<span class=\"corpo8_bold\" style=\"color:#253778 !important\">[".$filaIns[3]."]</span> (".$filaIns[0].") ".$filaIns[1].
							"',id:'".$llaveInstancia."',fechaInicio:'".$fechaInicio."',fechaFin:'".$fechaFin."',_is_leaf:".$hoja.",_parent:'".$llaveModalidad."'}".$arrExamenes;
					
					$planes.=",".$obj;
				}
				$aviso="";
				$fIModalidad="";
				if($fechaIModalidad!="")
				{
					$fIModalidad=date("d/m/Y",$fechaIModalidad);
					if($fechaIPeriodo=="")
					{
						$fechaIPeriodo=$fechaIModalidad;
						$fechaFPeriodo=$fechaFModalidad;
					}
					else
					{
						if($fechaIPeriodo>$fechaIModalidad)
						{
							$fechaIPeriodo=$fechaIModalidad;
						}
						if($fechaFPeriodo<$fechaFModalidad)
						{
							$fechaFPeriodo=$fechaFModalidad;
						}
					}
				}
				$fFModalidad="";
				if($fechaFModalidad!="")
				{
					$fFModalidad=date("d/m/Y",$fechaFModalidad);
				}
				$hojaInstancia="false";
				if($planes=="")
					$hojaInstancia="true";
				if($planSinFecha)
					$aviso='<img src="../images/exclamation.png" alt="Existen '.strtolower($dic["planEstudio"]["p"]["et"]).' que no cuentan con fechas de inicio y fin" title="Existen '.strtolower($dic["planEstudio"]["p"]["et"]).' que no cuentan con fechas de inicio y fin"> ';
				$obj="{fechaInicio:'".$fIModalidad."',fechaFin:'".$fFModalidad."',unidad:'".$aviso."<b>Modalidad</b>: <span class=\"letraRojaSubrayada8\" style=\"color:#B0281A !important\">".$filaMod[1]."</span>',id:'".$llaveModalidad."',_is_leaf:".$hojaInstancia.",_parent:'".$llavePeriodo."'}".$planes;
				$hijos.=",".$obj;
			}
			$fIPeriodo="";
			$fFPeriodo="";
			
			if($fechaIPeriodo!="")
			{
				$fIPeriodo=date("d/m/Y",$fechaIPeriodo);
				$fFPeriodo=date("d/m/Y",$fechaFPeriodo);
			}
			//
			$obj='{fechaInicio:"'.$fIPeriodo.'",fechaFin:"'.$fFPeriodo.'",unidad:"'.$fila[1].'",id:"'.$llavePeriodo.'",_is_leaf:false,_parent:null}'.$hijos;
			if($cadArbol=="")
				$cadArbol=$obj;
			else
				$cadArbol.=",".$obj;
		}
		$cadModalidad="['0','Todas las modalidades']";
		if(sizeof($arrModalidad)>0)
		{
			foreach($arrModalidad as $idModalidad=>$modalidad)
			{
				if($cadModalidad=="")
					$cadModalidad="['".$idModalidad."','".cv($modalidad)."']"	;
				else
					$cadModalidad.=",['".$idModalidad."','".cv($modalidad)."']"	;
			}
		}
		$cadProgramaEducativo="['0','Todos los programa educativos']";
		
		if(sizeof($arrProgEducativo)>0)
		{
			foreach($arrProgEducativo as $idProgramaEducativo=>$programa)
			{
				
					$cadProgramaEducativo.=",['".$idProgramaEducativo."','".cv($programa)."']"	;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadArbol.'],"arrModalidad":['.$cadModalidad.'],"arrProgramaEducativo":['.$cadProgramaEducativo.']}';	
	}
	
	function obtenerInstanciasPlanEstudio()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$consulta="SELECT idInstanciaPlanEstudio,CONCAT(nombrePlanEstudios,'(Modalidad: ',m.nombre,', Turno: ',t.turno,')'),p.descripcion,trim(i.cveRvoe) FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,
				4516_turnos t,4500_planEstudio p WHERE sede='".$plantel."' AND i.situacion=1 AND i.idModalidad=m.idModalidad AND i.idTurno=t.idTurno and p.idPlanEstudio=i.idPlanEstudio ORDER BY nombrePlanEstudios";
		$arrPlanes=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPlanes;
	}
	
	
	function obtenerEstructuraCurricularCostoMateria()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		$consulta="select idPlanEstudio from 4513_instanciaPlanEstudio where idInstanciaPlanEstudio=".$idInstanciaPlan;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$tUnidad=$dic["grado"]["s"]["et"];
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,descripcion,codigoUnidad,maxOPC,minOPC FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$obj='{qtip:"'.cv($fila[1]).'",clave:"",codigoUnidad:"'.$fila[3].'",id:"'.$fila[0].'",descripcion:"",nUnidad:"'.cv($fila[1]).'",text:"<span style=\'color:#030\'><b>'.cv($fila[1]).'</b></span>",tUnidad:"3"';
			$hijos=obtenerMateriasHijosCostoMateria($idPlanEstudio,$fila[3]);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijosCostoMateria($idPlanEstudio,$codigoPadre)
	{
		global $con;
		global $dic;
		$tUnidad="";
		$arrTemas="";
		$consulta="SELECT idEstructuraCurricular,tipoUnidad,n.abreviatura,e.naturalezaMateria,codigoUnidad,
				(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad))) as nombreUnidad,maxOPC,minOPC ,e.idUnidad,
				if(tipoUnidad=1,(select cveMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),'') as clave FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."'  order by nombreUnidad";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$noCreditos="";
			$totalHoras="";
			$horasTSemana="";
			$horasPSemana="";
			$horasISemana="";
			$icono="s.gif";
			$descripcion="";
			$color="";
			$tipoUnidadC="";
			if($fila[1]==1)
			{
				$tUnidad=$dic["materia"]["s"]["et"];
				$consulta="SELECT numeroCredito,horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes FROM 4502_Materias WHERE idMateria=".$fila[8];
				$filaMat=$con->obtenerPrimeraFila($consulta);
				$noCreditos=$filaMat[0];
				$totalHoras=$filaMat[1];
				$horasTSemana=$filaMat[2];
				$horasPSemana=$filaMat[3];
				$horasISemana=$filaMat[4];
				$icono="text_lowercase.png";
				$color="003";
			}
			else
			{
				
				$tUnidad="Unidad contenedora";
				$consulta="select descripcion,tipoUnidad from 4508_unidadesContenedora where idUnidadContenedora=".$fila[8];
				$fUnidad=$con->obtenerPrimeraFila($consulta);
				$descripcion=$fUnidad[0];
				$tipoUnidadC=$fUnidad[1];
				if($tipoUnidadC==1)
					$tUnidad="Unidad Agrupadora";
				$color="000";
				$icono="Icono_3d.gif";
			}
			$obj='{tipoUnidadC:"'.$tipoUnidadC.'",qtip:"'.cv($fila[5]).'",clave:"'.cv($fila[9]).'",codigoUnidad:"'.$fila[4].'",id:"'.$fila[0].'",nUnidad:"'.cv($fila[5]).'",descripcion:"'.cv($descripcion).'",text:"<span style=\'color:#'.$color.'\'><b>'.cv($fila[5]).'</b></span>",tUnidad:"'.$fila[1].'"';
			$hijos=obtenerMateriasHijosCostoMateria($idPlanEstudio,$fila[4]);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return "[".$arrTemas."]";
	}
	
	function enviarBajaValidacion()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 4548_solicitudesMovimientoGrupo SET situacion=1 WHERE situacion=5 AND idAsignacion=".$idAsignacion;
		$x++;
		$consulta[$x]="update 4519_asignacionProfesorGrupo SET situacion=61 WHERE  idAsignacionProfesorGrupo=".$idAsignacion;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerActualizacionBiometricos()
	{
		global $con;
		$consulta="SELECT idTerminal,nombreTerminal,ip,o.codigoUnidad,o.unidad,
					(SELECT fechaSincronizacion FROM 9105_sincronizacionTerminales WHERE plantel=o.codigoUnidad 
					AND noTerminal=g.idTerminal ORDER BY idRegistroTerminal DESC LIMIT 0,1) AS ultimaActualizacion
					FROM _494_gridBiometricos g,_494_tablaDinamica t,817_organigrama o 
					WHERE g.idReferencia=t.id__494_tablaDinamica AND o.codigoUnidad=t.cmbPlanteles AND g.activo=1 ORDER BY unidad";
		$arrObj=$con->obtenerFilasJSON($consulta);					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function removerProfesorReemplazo()
	{
		global $con;
		$iS=$_POST["iS"];
		$consulta="SELECT  datosSolicitud FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$iS;
		$datosSolicitud=$con->obtenerValor($consulta);
		$obj=json_decode($datosSolicitud);
		$arrDel[0]="idProfesorSuple";
		$arrDel[1]="fechaReemplaza";
		$datosSolicitud=convertirCadenaJson($obj,$arrDel);
		$consulta="update 4548_solicitudesMovimientoGrupo set datosSolicitud='".$datosSolicitud."' WHERE idSolicitudMovimiento=".$iS;
		eC($consulta);
	}
	
	function cancelarBajaProfesor()
	{
		global $con;
		$iS=$_POST["iS"];
		$consulta="SELECT idAsignacion FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$iS;
		$idAsignacion=$con->obtenerValor($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=1 WHERE idAsignacionProfesorGrupo=".$idAsignacion;
		$x++;
		$query[$x]="UPDATE 4548_solicitudesMovimientoGrupo SET situacion=-1,responsableRespuesta=".$_SESSION["idUsr"].",fechaRespuesta='".date("Y-m-d H:i")."' WHERE idSolicitudMovimiento=".$iS;
		$x++;
		$query[$x]="commit";
		$x++;

		eB($query);
	}
	
	function registrarCambioFechaCurso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$objAux=json_decode('{"arrFechas":'.bD($obj->arrHorario).'}');
		$consulta="SELECT idInstanciaPlanEstudio,idPeriodo FROM 4520_grupos WHERE idGrupos=".$obj->idGrupo;
		$fAux=$con->obtenerPrimeraFila($consulta);
		$idInstancia=$fAux[0];
		$idPeriodo=$fAux[1];
		
		$consulta="SELECT fechaFinal FROM 4544_fechasPeriodo WHERE idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia;
		$fechaTermino=$con->obtenerValor($consulta);
		$consulta="SELECT dracionHora FROM _472_tablaDinamica WHERE idReferencia=".$idInstancia;
		$duracionHora=$con->obtenerValor($consulta);
		if($duracionHora=="")
			$duracionHora=60;
		
		$permiteContinuar=true;
		$arrFechas=array();
		foreach($objAux->arrFechas as $f)
		{
			$arrHIni=explode(" ",$f->hInicio);
			$hInicio=strtotime($arrHIni[0]);
			$arrHFin=explode(" ",$f->hFin);
			$hFin=strtotime($arrHFin[0]);
			
			if(!isset($arrDiasSesion[$f->dia]))
			{
				$arrDiasSesion[$f->dia]=array();
				
			}
			$objTmp=array();
			$objTmp[0]=date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
			$objTmp[1]=strtotime($obj->fechaInicio);
			$objTmp[2]=strtotime($fechaTermino);
			$objTmp[3]=(($hFin-$hInicio)/60)/$duracionHora;
			array_push($arrDiasSesion[$f->dia],$objTmp);
		}
		
		$fechaFin=obtenerFechaFinCursoHorario($obj->idGrupo,$obj->fechaInicio,$arrDiasSesion);
		
		$cadCasos="";
		$consulta="select * from  4520_grupos WHERE idGrupos=".$obj->idGrupo;
		$fGrupos=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idHorarioGrupo FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo;
		$listHorario=$con->obtenerListaValores($consulta);
		$cadTmp='{"esCambioFechaInicio":"1","fechaInicio":"'.$obj->fechaInicio.'","fechaFin":"'.$fechaFin.'"}';
		$objComp=json_decode($cadTmp);
		if($listHorario=="")
			$listHorario=-1;
		if($obj->validar==1)
		{
			foreach($objAux->arrFechas as $h)
			{
				$resultado=validarCambioHorario($h,$obj->idGrupo,$fGrupos[3],$listHorario,$fGrupos[10],$obj->fechaInicio,$objComp);
				$arrRes=explode("|",$resultado);
				if($arrRes[0]==2)
				{
					$objRes=json_decode($arrRes[1]);
					$permiteContinuar=true;
					foreach($objRes->arrCasos as $c)
					{
						$objAux=json_encode($c);
						if($cadCasos=="")
							$cadCasos=$objAux;
						else
							$cadCasos.=",".$objAux;
						
					}
					
				}
			}
		}
		$pC=0;
		
		if($permiteContinuar)
			$pC=1;
		$cadObjRes='{"permiteContinuar":"'.$pC.'","arrCasos":['.$cadCasos.']}';
		if($cadCasos!="")
		{
			echo "2|".$cadObjRes;
			return;
		}
		
		
		
		$folioAME=generarFolioAME($obj->idGrupo);
		
		$cadHorario="";
		$consulta="SELECT * FROM 4522_horarioGrupo WHERE idGrupo=".$obj->idGrupo;
		$resH=$con->obtenerFilas($consulta);
		while($filaH=mysql_fetch_row($resH))
		{
			$objHorario='{"dia":"'.$filaH[2].'","hInicio":"'.$filaH[3].'","hFin":"'.$filaH[4].'","idAula":"'.$filaH[5].'"}';
			if($cadHorario=="")
				$cadHorario=$objHorario;
			else
				$cadHorario.=",".$objHorario;
			
		}
		$cadHorario="[".$cadHorario."]";
		$datosSolicitud='{"fechaOriginal":"'.$fGrupos[7].'","fechaTerminoOriginal":"'.$fGrupos[7].'","arrHorarioOriginal":'.$cadHorario.',"fechaInicio":"'.$obj->fechaInicio.'","fechaTermino":"'.$fechaFin.'","motivo":"'.cv(str_replace('"',"'",$obj->motivo)).'","arrHorario":'.bD($obj->arrHorario).'}';
		$consulta="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,responsableSolicitud,idInstanciaPlan,tipoSolicitud,datosSolicitud,situacion,idGrupo,folio)
					VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idInstancia.",6,'".cv($datosSolicitud)."',1,".$obj->idGrupo.",'".$folioAME."')";
		eC($consulta);
	}
	
	function obtenerCalendarioPeriodos()
	{
		global $con;
		$sL=$_POST["sL"];
		$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$consulta="SELECT idPlanEstudio,tipoEsquemaAsignacionFechasGrupo,numMaxBloquesFechas FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
		$fInstancia=$con->obtenerPrimeraFila($consulta);
		$idPlanEstudio=$fInstancia[0];
		$tipoEsquemaAsignacionFechasGrupo=$fInstancia[1];
		$numMaxBloquesFechas=$fInstancia[2];
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,codigoUnidad,g.idGrado,ordenGrado FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 
				AND tipoUnidad=3 ORDER BY  ordenGrado";

		$resMateria=$con->obtenerFilas($consulta);
		$arrGrados="";
		$nReg=0;
		while($fila=mysql_fetch_row($resMateria))
		{
			$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." and grado='".$fila[2]."' and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;
			$idEstructura=$con->obtenerValor($consulta);
			if($idEstructura!="")
			{
				$nReg++;
				$comp="";
				for($nBloque=1;$nBloque<=$numMaxBloquesFechas;$nBloque++)
				{
					$fechaIni="<span style='color:#FF0000'>N/E</span>";
					$consulta="SELECT fechaInicio FROM 4571_fechasBloquePeriodo WHERE idInstancia=".$idInstanciaPlanEstudio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idGrado=".$idEstructura." AND noBloque=".$nBloque;
					//echo $consulta."<br>";
					$fechaInicio=$con->obtenerValor($consulta);
					if($fechaInicio!="")
					{
						$fechaIni=date("d/m/Y",strtotime($fechaInicio));
						if($sL==1)
							$fechaIni="<img src='../images/lock.png' width='13' height='13' title='La fecha de inicio no es modificable' alt='La fecha de inicio no es modificable' > ".$fechaIni;
					}
					$comp.=',"bloque_'.$nBloque.'":"'.$fechaIni.'"';
				}
				$ctrl="<input type='checkbox' name='chk_grados' id='chk_".$idEstructura."' onclick='chkGradosChange(this)'> ";
				
				$obj='{"id":"'.$idEstructura.'","unidad":"'.$ctrl.cv($fila[1]).'"'.$comp.',leaf:true}';
				if($arrGrados=="")
					$arrGrados=$obj;
				else
					$arrGrados.=",".$obj;
				
			}
		}
		echo '['.$arrGrados.']';
	}
	
	function registrarFechasBloques()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$sL=$obj->sL;
		$arrGrados=explode(",",$obj->listaGrados);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrGrupos=array();
		foreach($arrGrados as $g)
		{
			foreach($obj->arrBloques as $b)
			{
				$fechaInicio="";
				if(($b->valor=="")||($b->valor=="null"))
					$fechaInicio="NULL";
				else
					$fechaInicio="'".$b->valor."'";
				$query="SELECT idFechaBloque,fechaInicio FROM 4571_fechasBloquePeriodo WHERE idInstancia=".$obj->idInstancia." 
						AND idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo." AND 
						idGrado=".$g." AND noBloque=".$b->bloque;
				$fBloque=$con->obtenerPrimeraFila($query);
				$idFechaBloque=$fBloque[0];
				if(!$fBloque)
				{
					$consulta[$x]="INSERT INTO 4571_fechasBloquePeriodo(noBloque,idGrado,idCiclo,idPeriodo,fechaInicio,idInstancia) VALUES(".$b->bloque.",".$g.",".$obj->idCiclo.",".$obj->idPeriodo.",".$fechaInicio.",".$obj->idInstancia.")";
					$x++;
				}
				else
				{
					if(($sL==0)||($fBloque[1]==""))
					{
						$consulta[$x]="update 4571_fechasBloquePeriodo set fechaInicio=".$fechaInicio." where idFechaBloque=".$idFechaBloque;
						$x++;
						
						$query="SELECT idGrupos FROM 4520_grupos WHERE idGradoCiclo=".$g." AND noBloqueAsociado=".$b->bloque." AND idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo." AND idInstanciaPlanEstudio=".$obj->idInstancia;
						$listGrupos=$con->obtenerListaValores($query);
						if($listGrupos!="")
						{
							if($fechaInicio=="NULL")
							{
								echo "<br>El <b>bloque ".$b->bloque."</b> ya cuenta con grupos asignados, por lo cual la fecha de inicio debe especificarse";
								return;
							}
							$arrGruposAux=explode(",",$listGrupos);
							foreach($arrGruposAux as $gpo)
							{
								array_push($arrGrupos,$gpo);
							}
							$consulta[$x]="update 4520_grupos set fechaInicio=".$fechaInicio." where idGrupos in (".$listGrupos.")";
							$x++;
						}
					}
				}
			}
		}
		//varDump($consulta);

		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if(sizeof($arrGrupos)>0)
			{
				foreach($arrGrupos as $idGrupo)
				{
					if(!ajustarFechaFinalCurso($idGrupo))
					{
						return;
					}
				}
			}
			echo "1|";
		}
	}
	
	function reprocesarEventosPlantelModulo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 9137_reprocesamientosEvento(fechaReprocesamiento,idResponsable,motivoReprocesamiento,fechaInicio,fechaFin,plantel,ignoraPlantel)
					VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",'".cv($obj->motivo)."','".$obj->fInicio."','".$obj->fFin."','".$obj->plantel."',".$obj->ignoraPlantel.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$validarEventosPlantel=true;
			if($obj->ignoraPlantel==1)
				$validarEventosPlantel=false;
			if(reprocesarEventosPlantelPeriodo($obj->plantel,$obj->fInicio,$obj->fFin,$validarEventosPlantel))
			{
				echo "1|";
			}
		}
		
		
	}
	
	function obtenerPlanesEstudioNivel()
	{
		global $con;
		$idNivel=$_POST["idNivel"];
		$consulta="SELECT DISTINCT nombre,upper(nombre) FROM  4500_planEstudio WHERE nivelPlanEstudio=".$idNivel." ORDER BY nombre";
		echo "1|".$con->obtenerFilasArreglo($consulta);
		
	}
	
	function obtenerModalidadCarrera()
	{
		global $con;
		$carrera=$_POST["carrera"];
		$idNivel=$_POST["idNivel"];
		$consulta="SELECT distinct m.idModalidad,upper(m.nombre) FROM  4500_planEstudio p,4513_instanciaPlanEstudio i,4514_tipoModalidad m 
					WHERE i.idPlanEstudio=p.idPlanEstudio AND  nivelPlanEstudio=".$idNivel." AND p.nombre='".$carrera."' AND m.idModalidad=i.idModalidad";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerPlantelCarrera()
	{
		global $con;
		$carrera=$_POST["carrera"];
		$idNivel=$_POST["idNivel"];
		$idModalidad=$_POST["idModalidad"];
		$consulta="SELECT distinct o.codigoUnidad,upper(o.unidad) FROM  4500_planEstudio p,4513_instanciaPlanEstudio i,4514_tipoModalidad m ,817_organigrama o
					WHERE i.idPlanEstudio=p.idPlanEstudio AND  nivelPlanEstudio=".$idNivel." AND p.nombre='".$carrera."' AND m.idModalidad=i.idModalidad
					and m.idModalidad=".$idModalidad." and i.sede=o.codigoUnidad order by unidad";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerPeriodosProgramaEducativoPlantel()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$idPrograma=$_POST["idPrograma"];
		$consulta="SELECT DISTINCT i.idPeriodicidad FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idPrograma." and i.situacion=1";
		$listPeriodos=$con->obtenerListaValores($consulta);
		if($listPeriodos=="")
			$listPeriodos=-1;
		$arrInstancias="";	
		$consulta="SELECT DISTINCT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idPrograma." and i.situacion=1 order by nombrePlanEstudios" ;	
		$resInstancia=$con->obtenerFilas($consulta);
		while($fInstancia=mysql_fetch_row($resInstancia))
		{
			$o="['".$fInstancia[0]."','".cv(obtenerNombreInstanciaPlan($fInstancia[0]))."']";
			if($arrInstancias=="")
				$arrInstancias=$o;
			else
				$arrInstancias.=",".$o;
		}
		$consulta="SELECT id__464_gridPeriodos,concat(txtDescripcion,': ',nombrePeriodo) FROM _464_gridPeriodos g,_464_tablaDinamica t WHERE 
					g.idReferencia=t.id__464_tablaDinamica and t.id__464_tablaDinamica IN (".$listPeriodos.") order by txtDescripcion,nombrePeriodo";	
		echo '1|'.$con->obtenerFilasArreglo($consulta)."|[".$arrInstancias."]";					
			
	}
	
	function obtenerPlanesEstudioProgramaEducativoPeriodo()
	{
		global $con;
		$idServicioNivel=$_POST["idServicioNivel"];
		$plantel=$_POST["plantel"];
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		if($idPeriodo==-1)
		{
			echo "[]";
				return;
		}
		
		$consulta="SELECT idReferencia FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$idPeriodo;
		$idPeriodicidad=$con->obtenerValor($consulta);
		
		$consulta="SELECT cveConcepto,nombreConcepto,idConcepto,consideraFechaVencimiento,perfilCosteo FROM 561_conceptosIngreso WHERE nivelCosteo=".$idServicioNivel." ORDER BY nombreConcepto";
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		switch($idServicioNivel)
		{
			case 1://plantel
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
					$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
					$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND 
							 idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
					$costo=$con->obtenerValor($consulta);
					if($costo=="")
						$costo=0;
					$costo=number_format($costo,2);
					$llave=$plantel."_".$idProgramaEducativo."_".$idPlanEstudio."_-1_".$fila[2];
					$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					
				}
			break;
			case 2://Programa Educativo
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
					$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
					$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
							 idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
					$costo=$con->obtenerValor($consulta);
					if($costo=="")
						$costo=0;
					$costo=number_format($costo,2);
					$llave=$plantel."_".$idProgramaEducativo."_".$idPlanEstudio."_-1_".$fila[2];
					$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					
				}
			break;
			case 3://Plan de estudios
				$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' 
							and i.idPeriodicidad=".$idPeriodicidad." AND p.idProgramaEducativo=".$idProgramaEducativo." and i.situacion=1";
				$resPlan=$con->obtenerFilas($consulta);
				$nRegistros=0;
				while($filaPlan=mysql_fetch_row($resPlan))
				{
					if(sizeof($res)>0)
						mysql_data_seek($res,0);
					$arrConceptos="";
					$nPlanEstudios=cv(obtenerNombreInstanciaPlan($filaPlan[0]));
					while($fila=mysql_fetch_row($res))
					{
						$idPlanEstudio=$filaPlan[0];
						$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
						$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
						$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
										idInstanciaPlanEstudio=".$idPlanEstudio." and idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
						$costo=$con->obtenerValor($consulta);
						if($costo=="")
							$costo=0;
						$costo=number_format($costo,2);
						$llave=$plantel."_".$idProgramaEducativo."_".$idPlanEstudio."_-1_".$fila[2];
						$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
						if($arrConceptos=="")
							$arrConceptos=$obj;
						else
							$arrConceptos.=",".$obj;
						
					}
					if($arrConceptos!="")
					{
						$obj='{"esConcepto":"0","icon":"../images/s.gif","id":"4_'.$filaPlan[0].'","text":"<span title=\''.$nPlanEstudios.'\' alt=\''.$nPlanEstudios.'\' style=\'color: #900\'><b>'.$nPlanEstudios.'</b></span>","costo":"",leaf:false,children:['.$arrConceptos.']}';
						if($arrRegistros=="")
							$arrRegistros=$obj;
						else
						$arrRegistros.=",".$obj;
					}
				}
			
				
			break;
			case 4://Grado
				$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel.
						"' and i.idPeriodicidad=".$idPeriodicidad." AND p.idProgramaEducativo=".$idProgramaEducativo;
				$resPlan=$con->obtenerFilas($consulta);
				$nRegistros=0;
				while($filaPlan=mysql_fetch_row($resPlan))
				{
					$nPlanEstudios=cv(obtenerNombreInstanciaPlan($filaPlan[0]));
					$idPlanEstudio=$filaPlan[1];
					$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$filaPlan[0];

					$listGrado=$con->obtenerListaValores($consulta);
					if($listGrado=="")
						$listGrado=-1;
					$arrGrados="";
					$hojaPlan="true";
					$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado) FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 and g.idGrado in (".$listGrado.") ORDER BY  ordenGrado";
					$resMateria=$con->obtenerFilas($consulta);
					while($filaGrado=mysql_fetch_row($resMateria))
					{
						if(sizeof($res)>0)
							mysql_data_seek($res,0);
						$arrConceptos="";
						while($fila=mysql_fetch_row($res))
						{
							$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
							$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
							$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
									idInstanciaPlanEstudio=".$filaPlan[0]." AND grado=".$filaGrado[0]." and idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
							$costo=$con->obtenerValor($consulta);
							if($costo=="")
								$costo=0;
							$costo=number_format($costo,2);
							$llave=$plantel."_".$idProgramaEducativo."_".$filaPlan[0]."_".$filaGrado[0]."_".$fila[2];
							$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","icon":"../images/s.gif","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
							if($arrConceptos=="")
								$arrConceptos=$obj;
							else
								$arrConceptos.=",".$obj;
							
						}
						if($arrConceptos=="")
							continue;
						$g='{"esConcepto":"0","icon":"../images/s.gif","id":"3_'.$filaGrado[0].'","text":"<span title=\''.$filaGrado[1].'\' alt=\''.$filaGrado[1].'\'><b>'.$filaGrado[1].'</b></span>","costo":"",leaf:false,children:['.$arrConceptos.']}';
						if($arrGrados=="")
							$arrGrados=$g;
						else
						$arrGrados.=",".$g;
							$hojaPlan="false";
					}
					if($arrGrados=="")
						continue;
					$obj='{"esConcepto":"0","icon":"../images/s.gif","id":"4_'.$filaPlan[0].'","text":"<span title=\''.$nPlanEstudios.'\' alt=\''.$nPlanEstudios.'\' style=\'color: #900\'><b>'.$nPlanEstudios.'</b></span>","costo":"",leaf:'.$hojaPlan.',children:['.$arrGrados.']}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
				}
			break;			
			case 5://Instancia Plan
				$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio and idInstanciaPlanEstudio=".$idPlanEstudio;
				$resPlan=$con->obtenerFilas($consulta);
				$nRegistros=0;
				while($filaPlan=mysql_fetch_row($resPlan))
				{
					if(sizeof($res)>0)
						mysql_data_seek($res,0);
					$arrConceptos="";
					$nPlanEstudios=cv(obtenerNombreInstanciaPlan($filaPlan[0]));
					while($fila=mysql_fetch_row($res))
					{
						$idPlanEstudio=$filaPlan[0];
						$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
						$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
						$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
										idInstanciaPlanEstudio=".$idPlanEstudio." and idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
						$costo=$con->obtenerValor($consulta);
						if($costo=="")
							$costo=0;
						$costo=number_format($costo,2);
						$llave=$plantel."_".$idProgramaEducativo."_".$idPlanEstudio."_-1_".$fila[2];
						$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
						if($arrConceptos=="")
							$arrConceptos=$obj;
						else
							$arrConceptos.=",".$obj;
						
					}
					if($arrConceptos!="")
					{
						$obj='{"esConcepto":"0","icon":"../images/s.gif","id":"4_'.$filaPlan[0].'","text":"<span title=\''.$nPlanEstudios.'\' alt=\''.$nPlanEstudios.'\' style=\'color: #900\'><b>'.$nPlanEstudios.'</b></span>","costo":"",leaf:false,children:['.$arrConceptos.']}';
						if($arrRegistros=="")
							$arrRegistros=$obj;
						else
						$arrRegistros.=",".$obj;
					}
				}
			
				
			break;
			case 6://Grado Intancia
				$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio and idInstanciaPlanEstudio=".$idPlanEstudio;
				$resPlan=$con->obtenerFilas($consulta);
				$nRegistros=0;
				while($filaPlan=mysql_fetch_row($resPlan))
				{
					$nPlanEstudios=cv(obtenerNombreInstanciaPlan($filaPlan[0]));
					$idPlanEstudio=$filaPlan[1];
					$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$filaPlan[0];

					$listGrado=$con->obtenerListaValores($consulta);
					if($listGrado=="")
						$listGrado=-1;
					$arrGrados="";
					$hojaPlan="true";
					$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado) FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$filaPlan[1].
								" and nivel=1 AND tipoUnidad=3 and g.idGrado in (".$listGrado.") ORDER BY  ordenGrado";
					$resMateria=$con->obtenerFilas($consulta);
					while($filaGrado=mysql_fetch_row($resMateria))
					{
						if(sizeof($res)>0)
							mysql_data_seek($res,0);
						$arrConceptos="";
						while($fila=mysql_fetch_row($res))
						{
							$consulta="SELECT idOperacion FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto=".$fila[2]." ORDER BY ordenAplicacion";
							$llaveCompatibilidad=$con->obtenerListaValores($consulta,"_");
							$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
									idInstanciaPlanEstudio=".$filaPlan[0]." AND grado=".$filaGrado[0]." and idConcepto=".$fila[2]." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
							$costo=$con->obtenerValor($consulta);
							if($costo=="")
								$costo=0;
							$costo=number_format($costo,2);
							$llave=$plantel."_".$idProgramaEducativo."_".$filaPlan[0]."_".$filaGrado[0]."_".$fila[2];
							$obj='{"esConcepto":"1","llaveCompatibilidad":"'.$llaveCompatibilidad.'","icon":"../images/s.gif","checked":false,"id":"'.$llave.'","text":"['.$fila[0].'] '.$fila[1].'","costo":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>$ '.$costo.'</a>","costoBase":"<a id=\'lblCosto_'.$llave.'\' onclick=lanzarInterfaceCosteo(\''.bE($llave).'\')>@costo</a>",leaf:true,"consideraFechaVencimiento":"'.$fila[3].'","perfilCosteo":"'.$fila[4].'"}';
							if($arrConceptos=="")
								$arrConceptos=$obj;
							else
								$arrConceptos.=",".$obj;
							
						}
						if($arrConceptos=="")
							continue;
						$g='{"esConcepto":"0","icon":"../images/s.gif","id":"3_'.$filaGrado[0].'","text":"<span title=\''.$filaGrado[1].'\' alt=\''.$filaGrado[1].'\'><b>'.$filaGrado[1].'</b></span>","costo":"",leaf:false,children:['.$arrConceptos.']}';
						if($arrGrados=="")
							$arrGrados=$g;
						else
						$arrGrados.=",".$g;
							$hojaPlan="false";
					}
					if($arrGrados=="")
						continue;
					$obj='{"esConcepto":"0","icon":"../images/s.gif","id":"4_'.$filaPlan[0].'","text":"<span title=\''.$nPlanEstudios.'\' alt=\''.$nPlanEstudios.'\' style=\'color: #900\'><b>'.$nPlanEstudios.'</b></span>","costo":"",leaf:'.$hojaPlan.',children:['.$arrGrados.']}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
				}
			break;
			
		}
		echo '['.$arrRegistros.']';
		
		
		
		
	}	
	
	function obtenerConceptosIngresoInstanciasPlan()
	{
		global $con;
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		$plantel=$_POST["plantel"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		$tipo=$_POST["tipo"];
		$comp="";
		switch($tipo)
		{
			case 8:
				$comp="AND idInstanciaPlanEstudio=".$idInstanciaPlan;
			break;
			case 12:
				$comp="AND idProgramaEducativo=".$idProgramaEducativo;
			break;
			case 16:
				$comp="";
			break;
		}
		
		$consulta="SELECT i.idConcepto as idConceptoIngreso,nombreConcepto as descripcion,
					(select valor from 6011_costoConcepto where idConcepto=i.idConcepto AND plantel='".$plantel."'  AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." ".$comp.") as costo 
					FROM 561_conceptosIngreso i,564_conceptosVSCategorias c WHERE c.idConcepto=i.idConcepto AND c.idCategoria=".$tipo." ORDER BY nombreConcepto";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function obtenerProgramasEducativoPlantel()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$consulta="SELECT idProgramaEducativo,nombreProgramaEducativo FROM 4500_programasEducativos where idProgramaEducativo 
			in (SELECT DISTINCT p.idProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."')";
		$arrProgramasEducativo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrProgramasEducativo;
	}
	
	function obtenerGradosInstanciaPlanEstudio()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio and idInstanciaPlanEstudio=".$idInstancia;
		$idPlanEstudio=$con->obtenerValor($consulta);	
		$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado) FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
		$arrGrados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrGrados;		
	}
	
	
	function obtenerMateriasInstanciaPlan()
	{
		global $con;
		$idInstanciaPlan=-1;
		if(isset($_POST["idInstanciaPlanEstudio"]))
			$idInstanciaPlan=$_POST["idInstanciaPlanEstudio"];
		$idPlanEstudio=-1;
		if(isset($_POST["idPlanEstudio"]))
			$idPlanEstudio=$_POST["idPlanEstudio"];
		$nPlanEstudio="";
		if($idInstanciaPlan!=-1)
		{
			$nPlanEstudio=obtenerNombreInstanciaPlan($idInstanciaPlan);
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
			$idPlanEstudio=$con->obtenerValor($consulta);
		}
		else
		{
			$consulta="SELECT CONCAT('[',TRIM(cveRvoe),'] ',nombre,' (',descripcion,')') FROM 4500_planEstudio WHERE idPlanEstudio=".$idPlanEstudio;
			$nPlanEstudio=$con->obtenerValor($consulta);
		}
		$consulta="SELECT idMateria,upper(nombreMateria) FROM 4502_Materias m,4505_estructuraCurricular e WHERE e.idPlanEstudio=".$idPlanEstudio." AND e.idPlanEstudio=m.idPlanEstudio AND 
					e.tipoUnidad=1 AND m.idMateria=e.idUnidad ORDER BY nombreMateria";

		$res=$con->obtenerFilas($consulta);
		$cadMaterias="";
		while($fMaterias=mysql_fetch_row($res))
		{
			$o='{icon:"../images/text_lowercase.png",allowDrop:false,allowDrag:true,draggable:true,clave:"",id:"'.$fMaterias[0].'",idUnidad:"'.$fMaterias[0].'",nUnidad:"'.cv($fMaterias[1]).'",text:"<span style=\'color:#030\'><b>'.cv($fMaterias[1]).'</b></span>",tUnidad:"0","leaf":true}';
			if($cadMaterias=="")
				$cadMaterias=$o;
			else
				$cadMaterias.=",".$o;
		}

		
		$obj='{icon:"../images/Icono_3d.gif",allowDrop:false,allowDrag:false,draggable:false,clave:"",id:"i_'.$idInstanciaPlan.'",idUnidad:"0",nUnidad:"'.cv($nPlanEstudio).'",text:"<span style=\'color:#030\'><b>'.cv($nPlanEstudio).'</b></span>",tUnidad:"1","leaf":false,children:['.$cadMaterias.']}';		
		echo '[',$obj,']';								
		
	}
	
	function obtenerPlanesEstudioProgramaEducativo()
	{
		global $con;
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		
		$consulta="SELECT idPlanEstudio,upper(CONCAT('[',trim(cveRvoe),'] ',nombre)),upper(descripcion) FROM 4500_planEstudio WHERE idPlanEstudio!=".$idPlanEstudio." and idProgramaEducativo=".$idProgramaEducativo." AND idPlanEstudio 
					NOT IN (SELECT idPlanEstudioEquivalencia FROM 4500_equivalenciasPlanEstudio WHERE tipoPlanEstudioEquivalencia=0 AND idPlanEstudioBase=".$idPlanEstudio.")";

		$arrRes=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRes;
	}
	
	function registrarPerfilEquivalencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$nConf=$obj->nConf;
		$x=0;
		if($obj->idEquivalenciaPlanEstudio==-1)
		{
			$consulta[$x]="INSERT INTO 4500_equivalenciasPlanEstudio(idPlanEstudioBase,tipoPlanEstudioEquivalencia,idPlanEstudioEquivalencia,fechaCreacion,idResponsableCreacion)
							VALUES(".$obj->idPlanBase.",".$obj->tipoEquivalencia.",".$obj->idPlanEquivalente.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="set @idRegistro:=".$obj->idEquivalenciaPlanEstudio;
			$x++;
			$consulta[$x]="delete from 4500_relacionEquivalenciaMaterias where idEquivalenciaPlanEstudio=".$obj->idEquivalenciaPlanEstudio;
			$x++;
		}
		if(sizeof($obj->arrMaterias)>0)
		{
			foreach($obj->arrMaterias as $m)
			{
				$consulta[$x]="INSERT INTO 4500_relacionEquivalenciaMaterias(idEquivalenciaPlanEstudio,idMateriaBase,idMateriaEquivalente,modificable,materiaClon) VALUES(@idRegistro,".$m->idMateriaBase.",".$m->idMateriaEquivalente.",0,".$m->materiaClon.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$idRegistro=$obj->idEquivalenciaPlanEstudio;
			if($idRegistro==-1)
			{
				$query="select @idRegistro";
				$idRegistro=$con->obtenerValor($query);
				cambiarValorObjParametros($nConf,"idEquivalenciaPlanEstudio",$idRegistro);	
				//cambiarValorObjParametros($nConf,"idPlanBase","-1");	
				//cambiarValorObjParametros($nConf,"idPlanEquivalencia","-1");	
				
			}
			echo "1|".$idRegistro;
		}
	}
	
	function registrarEscuela()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idEscuela==-1)
		{
			$consulta="INSERT INTO 6017_escuelaOrigenInscripcion(nombreEscuela,idPais,codigoEstado,codigoMunicipio,cveEscuela,descripcion,fechaCreacion,respCreacion)
						VALUES('".cv($obj->escuela)."',".$obj->pais.",'".cv($obj->estado)."','".cv($obj->municipio)."','".cv($obj->cveEscuela)."','".cv($obj->descripcion)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
		}
		else
		{
			$consulta="update 6017_escuelaOrigenInscripcion set nombreEscuela='".cv($obj->escuela)."',idPais=".$obj->pais.",codigoEstado='".cv($obj->estado)."',codigoMunicipio='".cv($obj->municipio)."',cveEscuela='".cv($obj->cveEscuela)."',
						descripcion='".cv($obj->descripcion)."' where idEscuelaOrigen=".$obj->idEscuela;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idEscuela==-1)
				$obj->idEscuela=$con->obtenerUltimoID();
			echo "1|".$obj->idEscuela."|".$obj->escuela;
		}
		
	}
	
	function obtenerPlanesEstudioEscuela()
	{
		global $con;
		$idEscuela=$_POST["idEscuela"];
		$consulta="SELECT idPlanEstudioEscuelas,upper(rvoe) as rvoe,upper(nombrePlanEstudios) as nombrePlanEstudios,descripcion,idSistema as idModalidad FROM 6018_planesEstudioEscuelaOrigen where idEscuelaOrigen=".$idEscuela." ORDER BY nombrePlanEstudios";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerMateriasPlanEstudio()
	{
		global $con;
		$idPlan=$_POST["idPlan"];
		$consulta="SELECT idMateriaPlanEstudioEscuelaOrigen as idMateria,cveMateria,nombreMateria,bloqueado FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idPlanEstudios=".$idPlan;
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}

	function guardarMateriasPlanEstudio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		$posTmp=-1;
		if($obj->idPlan==-1)
		{
			$query[$x]="INSERT INTO 6018_planesEstudioEscuelaOrigen(nombrePlanEstudios,rvoe,descripcion,idEscuelaOrigen,idSistema)  VALUES('".cv($obj->nombre)."','".cv($obj->rvoe)."','".cv($obj->descripcion)."',".$obj->idEscuelaOrigen.",".$obj->sistema.")";
			$x++;
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="set @idRegistro:=".$obj->idPlan;
			$x++;
			$posTmp=$x;
			$x++;
		}
		
		$listMaterias="-1";
		if(sizeof($obj->materias)>0)
		{
			$bloqueado=1;
			if(isset($obj->altaRevalidacion))
				$bloqueado=0;
			foreach($obj->materias as $m)
			{
				if($m->idMateria==-1)
				{
					$query[$x]="INSERT INTO 6019_materiasPlanEstudioEscuelaOrigen(nombreMateria,cveMateria,idPlanEstudios,bloqueado) VALUES('".cv($m->nombre)."','".cv($m->cveMateria)."',@idRegistro,".$bloqueado.")";
					$x++;
				}
				else
				{
					$query[$x]="update 6019_materiasPlanEstudioEscuelaOrigen set nombreMateria='".cv($m->nombre)."',cveMateria='".cv($m->cveMateria)."' where idMateriaPlanEstudioEscuelaOrigen=".$m->idMateria;
					$x++;
					$listMaterias.=",".$m->idMateria;
				}
			}
		}
		if($posTmp!=-1)
			$query[$posTmp]="delete from 6019_materiasPlanEstudioEscuelaOrigen where idPlanEstudios=@idRegistro and idMateriaPlanEstudioEscuelaOrigen not in (".$listMaterias.")";
			
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$idRegistro=$con->obtenerValor($consulta);
			echo "1|".$idRegistro;
		}
		
	}
	
	function removerPlanEstudios()
	{
		global $con;
		$idPlan=$_POST["idPlan"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 6018_planesEstudioEscuelaOrigen WHERE idPlanEstudioEscuelas=".$idPlan;
		$x++;
		$query[$x]="DELETE FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idPlanEstudios=".$idPlan;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
		
	}
	
	function obtenerPlanesEstudioEscuelaExterna()
	{
		global $con;
		$idEscuela=$_POST["idEscuela"];
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$listPlanes="";
		$consulta="SELECT idPlanEstudioEquivalencia FROM 4500_equivalenciasPlanEstudio WHERE tipoPlanEstudioEquivalencia=1 AND idPlanEstudioBase=".$idPlanEstudio;
		$listPlanes=$con->obtenerListaValores($consulta);
		if($listPlanes=="")
			$listPlanes=-1;
		
		$consulta="SELECT idPlanEstudioEscuelas,concat('[',upper(rvoe),'] ' ,upper(nombrePlanEstudios)) as nombrePlanEstudios,descripcion FROM 
				6018_planesEstudioEscuelaOrigen where idEscuelaOrigen=".$idEscuela." and idPlanEstudioEscuelas not in (".$listPlanes.") ORDER BY nombrePlanEstudios";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerMateriasPlanEstudioExterno()
	{
		global $con;
		
		$idPlanEstudio=-1;
		if(isset($_POST["idPlanEstudio"]))
			$idPlanEstudio=$_POST["idPlanEstudio"];
		$nPlanEstudio="";
		$consulta="SELECT CONCAT('[',TRIM(rvoe),'] ',nombrePlanEstudios,' (',descripcion,')') FROM 6018_planesEstudioEscuelaOrigen WHERE idPlanEstudioEscuelas=".$idPlanEstudio;
		$nPlanEstudio=$con->obtenerValor($consulta);
	
		$consulta="SELECT idMateriaPlanEstudioEscuelaOrigen,upper(nombreMateria) FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idPlanEstudios=".$idPlanEstudio." ORDER BY nombreMateria";
		$res=$con->obtenerFilas($consulta);
		$cadMaterias="";
		while($fMaterias=mysql_fetch_row($res))
		{
			$o='{icon:"../images/text_lowercase.png",allowDrop:false,allowDrag:true,draggable:true,clave:"",id:"'.$fMaterias[0].'",idUnidad:"'.$fMaterias[0].'",nUnidad:"'.cv($fMaterias[1]).'",text:"<span style=\'color:#030\'><b>'.cv($fMaterias[1]).'</b></span>",tUnidad:"0","leaf":true}';
			if($cadMaterias=="")
				$cadMaterias=$o;
			else
				$cadMaterias.=",".$o;
		}

		
		$obj='{icon:"../images/Icono_3d.gif",allowDrop:false,allowDrag:false,draggable:false,clave:"",id:"i_'.$idPlanEstudio.'",idUnidad:"0",nUnidad:"'.cv($nPlanEstudio).'",text:"<span style=\'color:#030\'><b>'.cv($nPlanEstudio).'</b></span>",tUnidad:"1","leaf":false,children:['.$cadMaterias.']}';		
		echo '[',$obj,']';			
	}
	
	function guardarEvaluacionRevalidacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$query="SELECT instanciaPlanEstudioDestino FROM _685_tablaDinamica WHERE id__685_tablaDinamica=".$obj->idRegistro;
		$idInstancia=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$idSolicitud=$con->obtenerValor($query);
		if($idSolicitud=="")
		{
			$consulta[$x]="INSERT INTO 4574_solicitudesRevalidacion(idFormulario,idReferencia) VALUES(".$obj->idFormulario.",".$obj->idRegistro.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		}
		else
		{
			$consulta[$x]="set @idRegistro:=".$idSolicitud;
			$x++;
			$consulta[$x]="delete from 4575_calificacionesSolicitudesRevalidacion WHERE idSolicitudRevaliacion=@idRegistro";
		}
		$x++;
		if(sizeof($obj->materias)>0)
		{
			foreach($obj->materias as $m)
			{
				$situacion=2;
				if(esCalificacionAprobatoria($m->idMateriaD,$m->calificacion,$idInstancia)==1)
					$situacion=1;
				$consulta[$x]="INSERT INTO 4575_calificacionesSolicitudesRevalidacion(idSolicitudRevaliacion,idMateriaOrigen,idMateriaDestino,calificacion,situacion) 
								VALUES(@idRegistro,".$m->idMateriaO.",".$m->idMateriaD.",".$m->calificacion.",".$situacion.")";
				$x++;
			}
		}
		
		$query="SELECT * FROM _685_tablaDinamica WHERE id__685_tablaDinamica=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($query);
		$idEscuelaOrigen=$fRegistro[11];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[15];
		}
		else
		{
			$tipoPlan=0;
			$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[16];
			$idPlanEstudioOrigen=$con->obtenerValor($query);
		}
		$idPlanEstudioDestino=$fRegistro[18];
		$query="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudio WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
					tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;
		$idEquivalenciaPlanEstudio=$con->obtenerValor($query);
		if($idEquivalenciaPlanEstudio=="")
		{
			
			$consulta[$x]="INSERT INTO 4500_equivalenciasPlanEstudio(idPlanEstudioBase,tipoPlanEstudioEquivalencia,idPlanEstudioEquivalencia,fechaCreacion,idResponsableCreacion)
						VALUES(".$idPlanEstudioDestino.",".$tipoPlan.",".$idPlanEstudioOrigen.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idEquivalencia:=(select last_insert_id())";
			$x++;
		}
		else
		{
				
			$consulta[$x]="set @idEquivalencia:=".$idEquivalenciaPlanEstudio;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
		//Revisar Marca
			$consulta=array();
			$x=0;
			$consulta[$x]="begin";
			$x++;
			if(sizeof($obj->materias)>0)
			{
				foreach($obj->materias as $m)
				{
					$query="select count(*) from 4500_relacionEquivalenciaMaterias WHERE idEquivalenciaPlanEstudio=@idEquivalencia AND idMateriaBase=".$m->idMateriaD." AND idMateriaEquivalente=".$m->idMateriaO;
					
					$nReg=$con->obtenerValor($query);
					
					if($nReg==0)
					{
						$materiaClon=0;
						if(isset($m->materiaClon))
							$materiaClon=$$m->materiaClon;	
						$consulta[$x]="INSERT INTO 4500_relacionEquivalenciaMaterias(idEquivalenciaPlanEstudio,idMateriaBase,idMateriaEquivalente,modificable,materiaClon) 
									VALUES (@idEquivalencia,".$m->idMateriaD.",".$m->idMateriaO.",1,".$materiaClon.")";
									
						$x++;
					}
				}
			}
			$consulta[$x]="commit";
			$x++;

			if($con->ejecutarBloque($consulta))
			{
				$query="select @idRegistro";
				$idSolicitud=$con->obtenerValor($query);
				if(evaluarMateriasSolicitudEquivalencia($idSolicitud))
				{
					echo "1|";
				}
			}
		}
		
	}
	
	function obtenerMateriasRevalidacionSolicitud()
	{
		global $con;
		$arrMaterias="";
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT * FROM _685_tablaDinamica WHERE id__685_tablaDinamica=".$idRegistro;
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$idEscuelaOrigen=$fRegistro[11];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[15];
		}
		else
		{
			$tipoPlan=0;
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[16];
			$idPlanEstudioOrigen=$con->obtenerValor($consulta);
		}
		
		
		
		
		
		$consulta="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$idSolicitud=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[18];
		$idPlanEstudioDestino=$con->obtenerValor($consulta);
		
		$consulta="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudio WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
					tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;
		$idEquivalenciaPlanEstudio=$con->obtenerValor($consulta);
		if($idEscuelaOrigen==1)
		{
			$consulta="SELECT idMateria,upper(nombreMateria) FROM 4502_Materias m,4505_estructuraCurricular e WHERE e.idPlanEstudio=".$idPlanEstudioOrigen." AND e.idPlanEstudio=m.idPlanEstudio AND 
						e.tipoUnidad=1 AND m.idMateria=e.idUnidad ORDER BY nombreMateria";
		}
		else
		{
			$consulta="SELECT idMateriaPlanEstudioEscuelaOrigen,upper(nombreMateria) FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idPlanEstudios=".$idPlanEstudioOrigen." ORDER BY nombreMateria";
		}

		$res=$con->obtenerFilas($consulta);
		$nRegistros=0;
		while($fMateria=mysql_fetch_row($res))
		{
			$idMateriaD="";
			$nomMateriaD="";
			$calificacion=0;
			$modificable=1;
			$materiaClon=0;
			$materiaClon=0;
			if(($idPlanEstudioOrigen==$idPlanEstudioDestino)&&($idEscuelaOrigen==1))
			{
				$idMateriaD=$fMateria[0];
				$nomMateriaD=cv($fMateria[1]);
				$idRevalidacion=-1;
				if($idSolicitud!="")
				{
					$consulta="SELECT calificacion,situacion,idRevalidacion FROM 4575_calificacionesSolicitudesRevalidacion WHERE  idSolicitudRevaliacion=".$idSolicitud." AND idMateriaOrigen=".$fMateria[0]." and idMateriaDestino=".$idMateriaD;
					$fResultado=$con->obtenerPrimeraFila($consulta);
					$calificacion=$fResultado[0];
					$situacion=$fResultado[1];
					$idRevalidacion=$fResultado[2];
					if($calificacion=="")
						$calificacion=0;
					if($situacion=="")
						$situacion=0;	
				}
				$obj='{"idRevalidacion":"'.$idRevalidacion.'","situacion":"'.$situacion.'","idMateriasPlanOrigen":"'.$fMateria[0].'","materiasPlanOrigen":"'.cv($fMateria[1]).'","idMateriasPlanDestino":"'.$idMateriaD.'","materiasPlanDestino":"'.cv($nomMateriaD).
							'","calificacion":"'.$calificacion.'","nodoAsignado":"'.$idMateriaD.'","modificable":"'.$modificable.'","materiaClon":"'.$materiaClon.'"}';
						
				if($arrMaterias=="")
					$arrMaterias=$obj;
				else	
					$arrMaterias.=",".$obj;
				$nRegistros++;
			}
			else
			{
					
				if($idEquivalenciaPlanEstudio!="")
				{
					$consulta="SELECT m.idMateria,UPPER(m.nombreMateria), r.modificable,materiaClon FROM 4500_relacionEquivalenciaMaterias r,4502_Materias m WHERE idEquivalenciaPlanEstudio=".$idEquivalenciaPlanEstudio." 
								and  idMateriaEquivalente=".$fMateria[0]." AND m.idMateria=r.idMateriaBase";
								
						
					$resMat=$con->obtenerFilas($consulta);
					if($con->filasAfectadas>0)
					{
						while($fMat=mysql_fetch_row($resMat))
						{
							$idMateriaD=$fMat[0];
							$nomMateriaD=$fMat[1];
							$modificable=$fMat[2];
							$materiaClon=$fMat[3];
							$situacion="0";
							$idRevalidacion=-1;
							if($idSolicitud!="")
							{
								$consulta="SELECT calificacion,situacion,idRevalidacion FROM 4575_calificacionesSolicitudesRevalidacion WHERE  idSolicitudRevaliacion=".$idSolicitud." AND idMateriaOrigen=".$fMateria[0]." and idMateriaDestino=".$idMateriaD;
								$fResultado=$con->obtenerPrimeraFila($consulta);
								$calificacion=$fResultado[0];
								$situacion=$fResultado[1];
								$idRevalidacion=$fResultado[2];
								if($calificacion=="")
									$calificacion=0;
								if($situacion=="")
									$situacion=0;	
							}
							
							
							$obj='{"idRevalidacion":"'.$idRevalidacion.'","situacion":"'.$situacion.'","idMateriasPlanOrigen":"'.$fMateria[0].'","materiasPlanOrigen":"'.cv($fMateria[1]).'","idMateriasPlanDestino":"'.$idMateriaD.'","materiasPlanDestino":"'.cv($nomMateriaD).
								'","calificacion":"'.$calificacion.'","nodoAsignado":"'.$idMateriaD.'","modificable":"'.$modificable.'","materiaClon":"'.$materiaClon.'"}';
							
							if($arrMaterias=="")
								$arrMaterias=$obj;
							else	
								$arrMaterias.=",".$obj;
							$nRegistros++;
						}
					
					}
					else
					{
						$obj='{"idRevalidacion":"-1","situacion":"0","idMateriasPlanOrigen":"'.$fMateria[0].'","materiasPlanOrigen":"'.cv($fMateria[1]).'","idMateriasPlanDestino":"'.$idMateriaD.'","materiasPlanDestino":"'.cv($nomMateriaD).
							'","calificacion":"'.$calificacion.'","nodoAsignado":"'.$idMateriaD.'","modificable":"'.$modificable.'","materiaClon":"'.$materiaClon.'"}';
						
						if($arrMaterias=="")
							$arrMaterias=$obj;
						else	
							$arrMaterias.=",".$obj;
						$nRegistros++;	
					}
				}
				else
				{
					$obj='{"idRevalidacion":"-1","situacion":"0","idMateriasPlanOrigen":"'.$fMateria[0].'","materiasPlanOrigen":"'.cv($fMateria[1]).'","idMateriasPlanDestino":"'.$idMateriaD.'","materiasPlanDestino":"'.cv($nomMateriaD).
							'","calificacion":"'.$calificacion.'","nodoAsignado":"'.$idMateriaD.'","modificable":"'.$modificable.'","materiaClon":"'.$materiaClon.'"}';
						
					if($arrMaterias=="")
						$arrMaterias=$obj;
					else	
						$arrMaterias.=",".$obj;
					$nRegistros++;
				}
				
			}
			
		}
		
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrMaterias.']}';
		
	}
	
	function finalizarEvaluacionEquivalencia()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$comentarios=$_POST["comentarios"];
		$gradoInscribe=$_POST["gradoInscribe"];
		
		
		
		$idEtapa=3;
		if(isset($_POST["idEstado"]))
			$idEstado=$_POST["idEstado"];
		
		$consulta="UPDATE 4574_solicitudesRevalidacion SET gradoInscribe=".$gradoInscribe.",fechaDictamen='".date("Y-m-d H:i:s")."',responsableDictamen=".$_SESSION["idUsr"].",comentarios='".cv($comentarios)."' WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		
		if($con->ejecutarConsulta($consulta))
		{
			cambiarEtapaFormulario($idFormulario,$idRegistro,$idEstado,$comentarios);
			echo "1|";
		}
	}
	
	function obtenerNombreMateriasRequisitosIncumplidos()
	{
		global $con;
		$idRevaliacion=$_POST["idRevaliacion"];
		$consulta="SELECT datosComplementarios FROM 4575_calificacionesSolicitudesRevalidacion WHERE idRevalidacion=".$idRevaliacion;
		$listMaterias=$con->obtenerListaValores($consulta);
		if($listMaterias=="")
			$listMaterias=-1;
		$consulta="SELECT idMateria,nombreMateria FROM  4502_Materias WHERE idMateria IN 
					(".$listMaterias.")";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function obtenerFechasProgramasEducativosConvocatoria()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT fechaInicio,fechaTermino,codigoInstitucion,cmbCicloInscripcion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fFechas=$con->obtenerPrimeraFila($consulta);
		
		
		
		$arrRegistros="";
		

		$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p 
					WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idProgramaEducativo." and i.idPeriodicidad=".$idPeriodicidad;
		$res=$con->obtenerFilas($consulta);
		$nRegistros=0;
		while($fila=mysql_fetch_row($res))
		{
			$nPlanEstudios=cv(obtenerNombreInstanciaPlan($fila[0]));
			$idPlanEstudio=$fila[1];
			$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado) FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
			$resMateria=$con->obtenerFilas($consulta);
			while($filaGrado=mysql_fetch_row($resMateria))
			{
				
				
				
				
				$obj='{"editable":"1","tipoElemento":"1","idElemento":"'.$filaGrado[0].'","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.'","descripcion":"'.cv($filaGrado[1]).'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				
				$nRegistros++;
			}
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function obtenerPeriodosRegistroInscripcion()
	{
		global $con;
		$tipoPeriodo=$_POST["tipoPeriodo"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		
		$consulta="SELECT id__464_gridPeriodos AS idPeriodo, UPPER(nombrePeriodo) AS nombrePeriodo FROM _464_gridPeriodos WHERE idReferencia=".$tipoPeriodo." 
					AND id__464_gridPeriodos NOT IN (SELECT idPeriodo FROM 4576_periodosRegistroInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia.") ORDER BY nombrePeriodo";
					
		echo fJSON($consulta);
		
	}
	
	function registrarPeriodoRegistroInscripcion()
	{
		global $con;
		$listPeriodos=$_POST["listPeriodos"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		$arrPeriodos=explode(",",$listPeriodos);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPeriodos as $p)
		{
			$consulta[$x]="INSERT INTO 4576_periodosRegistroInscripcion(idFormulario,idReferencia,idPeriodo)
							VALUES(".$idFormulario.",".$idReferencia.",".$p.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="SELECT g.id__464_gridPeriodos,UPPER(CONCAT(txtDescripcion,': ',g.nombrePeriodo)) AS periodo FROM 4576_periodosRegistroInscripcion p,_464_tablaDinamica t,_464_gridPeriodos g 
					WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia." AND g.id__464_gridPeriodos=p.idPeriodo AND g.idReferencia=t.id__464_tablaDinamica ORDER BY txtDescripcion,g.nombrePeriodo";
			echo "1|".$con->obtenerFilasArreglo($query);								
		}
	}
	
	function obtenerProgramasAcademicosRegistroInscripcion()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$idPeriodo=$_POST["idPeriodo"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		
		$consulta="SELECT distinct p.idProgramaEducativo,p.nombreProgramaEducativo AS nombrePrograma,t.txtNivelEstudio AS gradoAcademico FROM 
				4500_programasEducativos p,_401_tablaDinamica t,4513_instanciaPlanEstudio i,4500_planEstudio pl 
				WHERE t.id__401_tablaDinamica=p.nivelProgramaEducativo AND pl.idPlanEstudio=i.idPlanEstudio AND p.idProgramaEducativo=pl.idProgramaEducativo
				AND i.sede='".$plantel."' AND p.idProgramaEducativo NOT IN (SELECT idProgramaEducativo FROM 4577_programasEducativosRegistroInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idPeriodo=".$idPeriodo.")
				ORDER BY txtNivelEstudio,p.nombreProgramaEducativo";
		echo fJSON($consulta);
		
	}
	
	function registrarProgramasEducativosRegistroInscripcion()
	{
		global $con;
		$lista=$_POST["lista"];
		$idFormulario=$_POST["idFormulario"];
		$idPeriodo=$_POST["idPeriodo"];
		$idReferencia=$_POST["idRegistro"];
		$arreglo=explode(",",$lista);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arreglo as $p)
		{
			$consulta[$x]="INSERT INTO 4577_programasEducativosRegistroInscripcion(idFormulario,idReferencia,idProgramaEducativo,idPeriodo)
						VALUES(".$idFormulario.",".$idReferencia.",".$p.",".$idPeriodo.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerProgramasEducativosInscripcion()
	{
		global $con;
		$idPeriodo=$_POST["idPeriodo"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT p.idProgramaEducativo,pr.nombreProgramaEducativo FROM 4577_programasEducativosRegistroInscripcion p,4500_programasEducativos pr 
				WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idPeriodo=".$idPeriodo." AND pr.idProgramaEducativo=p.idProgramaEducativo order by nombreProgramaEducativo";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerPlanesEstudiosInscripcion()
	{
		global $con;
		$idPeriodo=$_POST["idPeriodo"];
		$idPrograma=$_POST["idPrograma"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$plantel=$_POST["plantel"];
		$query="SELECT cmbCicloInscripcion FROM _692_tablaDinamica WHERE id__692_tablaDinamica=".$idReferencia;
		$idCiclo=$con->obtenerValor($query);
		$consulta="SELECT idInstanciaPlanEstudio,p.descripcion FROM 4513_instanciaPlanEstudio i,4500_planEstudio p 
				WHERE sede='".$plantel."' AND idInstanciaPlanEstudio NOT IN (SELECT idInstanciaPlanEstudio FROM 4578_instanciasPlanEstudiosRegistroInscripcion 
				WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idPeriodo=".$idPeriodo.") and p.idProgramaEducativo=".$idPrograma."  AND p.idPlanEstudio=i.idPlanEstudio";
		$arrRegistros="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$fila[0];
			$iGrado=$con->obtenerValor($consulta);
			if($iGrado!="")
			{
				$obj='{"idInstanciaPlan":"'.$fila[0].'","nombrePlanEstudios":"'.cv(obtenerNombreInstanciaPlan($fila[0])).'","descripcion":"'.cv($fila[1]).'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
			}
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	}		
	
	function registrarPlanesEstudioInscripcion()
	{
		global $con;
		$lista=$_POST["lista"];
		$idFormulario=$_POST["idFormulario"];
		$iPeriodo=0;
		if(isset($_POST["idPeriodo"]))
			$iPeriodo=$_POST["idPeriodo"];
		
		$idReferencia=$_POST["idRegistro"];
		$arreglo=explode(",",$lista);	
		
		$query="SELECT idPeriodo FROM 3014_pluginPeriodos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
		$lPeriodos=$con->obtenerListaValores($query);
		if($lPeriodos=="")
			$lPeriodos=-1;
		
		$query="SELECT cmbCicloInscripcion FROM _692_tablaDinamica WHERE id__692_tablaDinamica=".$idReferencia;
		
		
		
		$idCiclo=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arreglo as $p)
		{
			
			if($iPeriodo==0)
			{
				$query="SELECT g.id__464_gridPeriodos FROM 4513_instanciaPlanEstudio i,_464_tablaDinamica t,_464_gridPeriodos g 
							WHERE idInstanciaPlanEstudio=".$p." AND t.id__464_tablaDinamica=i.idPeriodicidad AND g.idReferencia=t.id__464_tablaDinamica
							AND g.id__464_gridPeriodos IN(".$lPeriodos.")";
				$idPeriodo=$con->obtenerValor($query);
			}
			else
				$idPeriodo=$iPeriodo;
			
			
			$query="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$p;

			$listGrado=$con->obtenerListaValores($query);
			if($listGrado=="")
				continue;
			
			$consulta[$x]="INSERT INTO 4578_instanciasPlanEstudiosRegistroInscripcion(idFormulario,idReferencia,idInstanciaPlanEstudio,idPeriodo) 
						 VALUES(".$idFormulario.",".$idReferencia.",".$p.",".$idPeriodo.")";

			$x++;
			$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$p;
			$idPlanEstudio=$con->obtenerValor($query);
			
			$query="SELECT idUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=3 AND idUnidad IN (".$listGrado.")";
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
			{
				$consulta[$x]="INSERT INTO 4579_gradosRegistroInscripcion(idGrado,idInstanciaPlan,idPeriodo,situacion,idFormulario,idReferencia)
								 VALUES(".$fila[0].",".$p.",".$idPeriodo.",1,".$idFormulario.",".$idReferencia.")";
				$x++;
			}
		}

		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerFechasInstanciasPlanEstudioInscripcion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];	
		
		$idPeriodo=0;
		if(isset($_POST["idPeriodo"]))
			$idPeriodo=$_POST["idPeriodo"];
			
		
		$idPrograma=$_POST["idPrograma"];
		if(isset($_POST["idPrograma"]))
			$idPrograma=$_POST["idPrograma"];
			
			
		$sL=$_POST["sL"];
		$arrRegistros='';
		
		$consulta="SELECT DISTINCT t.idModalidad,t.nombre FROM 4578_instanciasPlanEstudiosRegistroInscripcion r,4513_instanciaPlanEstudio i,4514_tipoModalidad t, 4500_planEstudio pe
					WHERE i.idInstanciaPlanEstudio=r.idInstanciaPlanEstudio and t.idModalidad=i.idModalidad AND pe.idPlanEstudio=i.idPlanEstudio and idFormulario=".$idFormulario." 
					AND idReferencia=".$idReferencia;
					
		if($idPeriodo!=0)			
			$consulta.=" AND idPeriodo=".$idPeriodo." and pe.idProgramaEducativo=".$idPrograma;
			
		$consulta.=	" ORDER BY t.nombre";
		
		$resModalidades=$con->obtenerFilas($consulta);
		while($filaMod=mysql_fetch_row($resModalidades))
		{
			$hijos="";
			
			$consulta="SELECT DISTINCT t.idTurno,t.turno FROM 4578_instanciasPlanEstudiosRegistroInscripcion r,4513_instanciaPlanEstudio i,4516_turnos t, 4500_planEstudio pe
					WHERE i.idInstanciaPlanEstudio=r.idInstanciaPlanEstudio and t.idTurno=i.idTurno AND pe.idPlanEstudio=i.idPlanEstudio and idFormulario=".$idFormulario." 
					AND idReferencia=".$idReferencia;
					
			if($idPeriodo!=0)			
				$consulta.=" AND idPeriodo=".$idPeriodo." and pe.idProgramaEducativo=".$idPrograma;
					
			$consulta.=" ORDER BY t.turno";
			
			$resTurno=$con->obtenerFilas($consulta);
			while($filaTurno=mysql_fetch_row($resTurno))
			{
				$planes="";
				
				
				$consulta="SELECT i.idInstanciaPlanEstudio,idInstanciasInscripcion,p.nombrePlanEstudios,i.inscribeNuevosIngresos  FROM 4578_instanciasPlanEstudiosRegistroInscripcion i,
						4513_instanciaPlanEstudio p,4500_planEstudio pe WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." 
						 AND i.idInstanciaPlanEstudio=p.idInstanciaPlanEstudio
					and pe.idPlanEstudio=p.idPlanEstudio and  p.idModalidad=".$filaMod[0]." and p.idTurno=".$filaTurno[0];
				
				if($idPeriodo!=0)			
					$consulta.=" AND idPeriodo=".$idPeriodo." and pe.idProgramaEducativo=".$idPrograma;
				
				
				$consulta.=" ORDER BY p.nombrePlanEstudios";
				
				$res=$con->obtenerFilas($consulta);
				$inscribeNuevoIngreso="";
				while($fila=mysql_fetch_row($res))
				{
					$icono="../images/s.gif";
					$etiqueta="";
					$color="#000";
					if($fila[3]=="1")
					{
						$color="#900";
						$inscribeNuevoIngreso=$fila[0];
						$icono="../images/resultset_next.png";
						$etiqueta="Este Plan de Estudios ha sido designado como receptor de Nuevos Ingresos";
					}
					$et=$fila[2];
					$et2=$et;
					if($sL==0)
						$et='<img title=\''.$etiqueta.'\' alt==\''.$etiqueta.'\' src=\''.$icono.'\'>&nbsp;<input type=\'checkbox\' id=\''.$fila[0].'\' idRegistro=\''.$fila[1].'\' name=\'chkRaiz\' onclick=\'planClick(this,evt)\'> <span title="'.$et2.'" alt="'.$et2.'" style="color:'.$color.'">'.$et.'</span>';
					else
						$et='<img title=\''.$etiqueta.'\' alt==\''.$etiqueta.'\' src=\''.$icono.'\'>&nbsp;<span title="'.$et2.'" alt="'.$et2.'" style="color:'.$color.'">'.$et.'</span>';
					$hijosGrados=obtenerFechasGradoInstanciasRegistroInscripcion($idFormulario,$idReferencia,$idPeriodo,$fila[0],$sL,$filaMod[0],$filaTurno[0]);
					
					$o='{"expanded":true,"icon":"../images/s.gif","tipo":"1","id":"i_'.$filaMod[0].'_'.$filaTurno[0].'_'.$fila[0].'","text":"'.cv($et).'","nombrePlan":"'.cv($fila[2]).'","fechaInicioInscripcion":"","fechaTerminoInscripcion":"","fechaInicioResincripcion":"","fechaTerminoRenscripcion":"","situacion":"","leaf":false,"children":'.$hijosGrados.'}';
					if($planes=="")
						$planes=$o;
					else
						$planes.=",".$o;
				}
				
				if($idPeriodo!=0)
				{
					$icono="../images/user_remove.png";
					$etiqueta="Alumnos de nuevo ingreso no podr&aacute;n inscribirse a este Plan de Estudios en esta modalidad y turno, ya que no se ha definido un Plan de Estudios para este fin, para solucionarlo de click AQU&Iacute; y presione el bot&oacute;n Designar Plan de Estudios Receptor de Nuevos Ingresos";
					if($inscribeNuevoIngreso!="")
					{
						$consulta="SELECT nombrePlanEstudios FROM 4513_instanciaPlanEstudio WHERE  idInstanciaPlanEstudio=".$inscribeNuevoIngreso;
						$nPlanEstudio=$con->obtenerValor($consulta);
						$etiqueta="Para esta modalidad y turno, los alumnos de nuevo ingreso ser&aacute;n inscritos al Plan de Estudios: ".$nPlanEstudio.", para designar otro plan de estudio como receptos de Nuevos Ingresos de click AQU&Iacute; y presione el bot&oacute;n Designar Plan de Estudios Receptor de Nuevos Ingresos";
						$icono="../images/user_edit.png";
					}
				}
				if($planes!="")
				{
					$o='{"inscribeNuevoIngreso":"'.$inscribeNuevoIngreso.'","expanded":true,"icon":"../images/s.gif","tipo":"-1","id":"t_'.$filaMod[0].'_'.$filaTurno[0].'","text":"<img title=\''.$etiqueta.'\' alt==\''.$etiqueta.'\' src=\''.$icono.'\'>&nbsp;<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important;\'>Turno:</span> <b>'.cv($filaTurno[1]).'</b>","fechaInicioInscripcion":"","fechaTerminoInscripcion":"","fechaInicioResincripcion":"","fechaTerminoRenscripcion":"","situacion":"","leaf":false,"children":['.$planes.']}';
					if($hijos=="")
						$hijos=$o;
					else
						$hijos.=",".$o;
				}
			}
			

			$o='{"expanded":true,"icon":"../images/s.gif","tipo":"0","id":"m_'.$filaMod[0].'","text":"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important;\'>Modalidad:</span> <b>'.cv($filaMod[1]).'</b>","fechaInicioInscripcion":"","fechaTerminoInscripcion":"","fechaInicioResincripcion":"","fechaTerminoRenscripcion":"","situacion":"","leaf":false,"children":['.$hijos.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		
		echo '['.$arrRegistros.']';

		
		
	}
	
	function obtenerFechasGradoInstanciasRegistroInscripcion($idFormulario,$idReferencia,$idPeriodo,$idInstancia,$sL,$modalidad,$turno)
	{
		global $con;
		
		$arrRegistros="";
		$consulta="SELECT idGradoRegistroInscripcion,g.idGrado,gr.leyendaGrado,fechaInicioInscripcion,fechaFinInscripcion,fechaInicioReInscripcion,fechaFinReInscripcion,g.situacion 
					FROM 4579_gradosRegistroInscripcion g,4501_Grado gr WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idInstanciaPlan=".$idInstancia."
					AND gr.idGrado=g.idGrado ";
		if($idPeriodo!=0)
			$consulta.=" AND idPeriodo=".$idPeriodo;			
		$consulta.=" ORDER BY gr.ordenGrado";
		
		
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$fechaInicioInscripcion=$fila[3];
			if($fechaInicioInscripcion!="")
				$fechaInicioInscripcion=date("d/m/Y",strtotime($fechaInicioInscripcion));
			$fechaTerminoInscripcion=$fila[4];
			if($fechaTerminoInscripcion!="")
				$fechaTerminoInscripcion=date("d/m/Y",strtotime($fechaTerminoInscripcion));
			$fechaInicioResincripcion=$fila[5];
			if($fechaInicioResincripcion!="")
				$fechaInicioResincripcion=date("d/m/Y",strtotime($fechaInicioResincripcion));
			$fechaTerminoRenscripcion=$fila[6];
			if($fechaTerminoRenscripcion!="")
				$fechaTerminoRenscripcion=date("d/m/Y",strtotime($fechaTerminoRenscripcion));
			$situacion=$fila[7];
			if($situacion==0)
				$situacion="<img src='../images/cross.png'> Inactivo";
			else
				$situacion="<img src='../images/icon_big_tick.gif'> Activo";
			if($sL==0)
			{		
				$o='{ "tipo":"2","id":"g_'.$modalidad.'_'.$turno.'_'.$fila[0].'","text":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\'checkbox\' id=\''.$fila[0].'\' name=\'chk_'.$idInstancia.'\' onclick=\'gradoSel(this,evt)\'> '.cv($fila[2]).'","fechaInicioInscripcion":"'.$fechaInicioInscripcion.
					'","fechaTerminoInscripcion":"'.$fechaTerminoInscripcion.'","fechaInicioResincripcion":"'.$fechaInicioResincripcion.'","fechaTerminoRenscripcion":"'.$fechaTerminoRenscripcion.'","situacion":"'.$situacion.'","leaf":true}';
			}
			else
			{
				$o='{ "tipo":"2","id":"g_'.$modalidad.'_'.$turno.'_'.$fila[0].'","text":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.cv($fila[2]).'","fechaInicioInscripcion":"'.$fechaInicioInscripcion.
					'","fechaTerminoInscripcion":"'.$fechaTerminoInscripcion.'","fechaInicioResincripcion":"'.$fechaInicioResincripcion.'","fechaTerminoRenscripcion":"'.$fechaTerminoRenscripcion.'","situacion":"'.$situacion.'","leaf":true}';
			}
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		return '['.$arrRegistros.']';
	}
	
	function guardarFechasInscripcionRegistroInscripcion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$arrGrados=explode(",",$obj->arrGrados);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if(sizeof($arrGrados)>0)
		{
			foreach($arrGrados as $g)
			{
				$consulta[$x]="UPDATE 4579_gradosRegistroInscripcion SET fechaInicioInscripcion='".$obj->fechaInicioIns."',fechaFinInscripcion='".$obj->fechaFinIns."',fechaInicioReInscripcion='".$obj->fechaInicioReIns.
								"',fechaFinReInscripcion='".$obj->fechaFinReIns."'   WHERE idGradoRegistroInscripcion=".$g;
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function activarDesactivarGrado()
	{
		global $con;
		$lista=$_POST["lista"];
		$arrGrados=explode(",",$lista);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if(sizeof($arrGrados)>0)
		{
			foreach($arrGrados as $g)
			{
				$query="select situacion from 4579_gradosRegistroInscripcion WHERE idGradoRegistroInscripcion=".$g;
				$situacion=$con->obtenerValor($query);
				if($situacion==0)
					$situacion=1;
				else
					$situacion=0;
				$consulta[$x]="UPDATE 4579_gradosRegistroInscripcion SET situacion=".$situacion." WHERE idGradoRegistroInscripcion=".$g;
				$x++;
				
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerPlanEstudiosRegistroInscripcion()
	{
		global $con;
		$listaPlanEstudio=$_POST["listaPlanEstudio"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT * FROM 4578_instanciasPlanEstudiosRegistroInscripcion WHERE idInstanciasInscripcion in (".$listaPlanEstudio.")";
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$consulta[$x]="DELETE FROM 4579_gradosRegistroInscripcion WHERE idFormulario=".$fila[1]." AND idReferencia=".$fila[2]." AND idInstanciaPlan=".$fila[3]." AND idPeriodo=".$fila[4];
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 4578_instanciasPlanEstudiosRegistroInscripcion WHERE idInstanciasInscripcion in (".$listaPlanEstudio.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function obtenerTurnosProgramasEducativosModalidad()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$plantel=$_POST["plantel"];
		$modalidad=$_POST["modalidad"];
		
		$consulta="SELECT i.idTurno FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE 
				p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idPrograma." and i.idModalidad=".$modalidad;
		$lista=$con->obtenerListaValores($consulta);
		if($lista=="")
			$lista=-1;
		$consulta="SELECT idTurno,turno FROM 4516_turnos WHERE idTurno IN (".$lista.") ORDER BY turno";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arreglo;
		
		
	}
	
	function obtenerFechasProgramaEducativoPortal()
	{
		global $con;
		$idModalidad=$_POST["idModalidad"];	
		$idTurno=$_POST["idTurno"];	
		$idPrograma=$_POST["idPrograma"];	
		$plantel=$_POST["plantel"];	
		$consulta="SELECT i.idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND  
					i.sede='".$plantel."' AND i.idModalidad=".$idModalidad." AND i.idTurno=".$idTurno." AND p.idProgramaEducativo=".$idPrograma;

		$listReferencias="";

		$listInstancias=$con->obtenerListaValores($consulta);
		if($listInstancias=="")
			$listInstancias=-1;
		$fechaActual=date("Y-m-d");
		$consulta="SELECT id__692_tablaDinamica,cmbCicloInscripcion FROM _692_tablaDinamica WHERE codigoInstitucion='".$plantel."' AND '".$fechaActual."'>=fechaInicio AND '".$fechaActual."'<=fechaTermino";
		$res=$con->obtenerFilas($consulta);
		$arrCiclos=array();
		while($fila=mysql_fetch_row($res))
		{
			if(!isset($arrCiclos[$fila[1]]))
				$arrCiclos[$fila[1]]=array();
			$consulta="SELECT DISTINCT idPeriodo,idInstanciaPlanEstudio FROM 4578_instanciasPlanEstudiosRegistroInscripcion WHERE 
					idFormulario=692 AND idReferencia=".$fila[0]." AND idInstanciaPlanEstudio IN (".$listInstancias.")";
			$resPeriodo=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				if($listReferencias=="")
					$listReferencias=$fila[0];
				else
					$listReferencias.=",".$fila[0];
			}
			while($fPeriodo=mysql_fetch_row($resPeriodo))
			{
				if(!isset($arrCiclos[$fila[1]][$fPeriodo[0]]))
					$arrCiclos[$fila[1]][$fPeriodo[0]]=array();
				if(!existeValor($arrCiclos[$fila[1]][$fPeriodo[0]],$fPeriodo[1]))
					array_push($arrCiclos[$fila[1]][$fPeriodo[0]],$fPeriodo[1]);
				
			}
		}
		$cadFinal='';
		$obj='';
		if(sizeof($arrCiclos)>0)		
		{
			foreach($arrCiclos as $ciclo=>$resto)
			{
				$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$ciclo;
				$nombreCiclo=$con->obtenerValor($consulta);
				if(sizeof($resto)>0)
				{
					foreach($resto as $periodo=>$restoPlan)
					{
						if(sizeof($restoPlan)>0)
						{
							$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$periodo;
							$nombrePeriodo=$con->obtenerValor($consulta);
							$arrInstancias="";
							foreach($restoPlan as $idInstancia)
							{
								$consulta="SELECT nombrePlanEstudios FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
								$nomPlan=$con->obtenerValor($consulta);
								
								$arrGrados="";
								$consulta="SELECT DISTINCT gr.idGrado,gr.leyendaGrado FROM 4579_gradosRegistroInscripcion g,4501_Grado gr where gr.idGrado=g.idGrado and
											 idFormulario=692 AND idReferencia IN (".$listReferencias.") AND  idInstanciaPlan=".$idInstancia."  
											AND idPeriodo=".$periodo." AND g.situacion=1 order by gr.ordenGrado";
								$resGrado=$con->obtenerFilas($consulta);
								while($filaGrado=mysql_fetch_row($resGrado))
								{
									$consulta="SELECT DISTINCT min(fechaInicioInscripcion) FROM 4579_gradosRegistroInscripcion g where
											 idFormulario=692 AND idReferencia IN (".$listReferencias.") AND  idInstanciaPlan=".$idInstancia."  and idGrado=".$filaGrado[0]."
											AND idPeriodo=".$periodo." AND g.situacion=1";
									$fechaInicioInscripcion=$con->obtenerValor($consulta);
									$fechaFinInscripcion="";
									if($fechaInicioInscripcion!="")
									{
										$fechaInicioInscripcion=date("d/m/Y",strtotime($fechaInicioInscripcion));
										$consulta="SELECT DISTINCT max(fechaFinInscripcion) FROM 4579_gradosRegistroInscripcion g where
											 idFormulario=692 AND idReferencia IN (".$listReferencias.") AND  idInstanciaPlan=".$idInstancia."  and idGrado=".$filaGrado[0]."
											AND idPeriodo=".$periodo." AND g.situacion=1";
										$fechaFinInscripcion=$con->obtenerValor($consulta);
										$fechaFinInscripcion=date("d/m/Y",strtotime($fechaFinInscripcion));
										
									}
									
									
									$consulta="SELECT DISTINCT min(fechaInicioReInscripcion) FROM 4579_gradosRegistroInscripcion g where
											 idFormulario=692 AND idReferencia IN (".$listReferencias.") AND  idInstanciaPlan=".$idInstancia."  and idGrado=".$filaGrado[0]."
											AND idPeriodo=".$periodo." AND g.situacion=1";
									
									$fechaInicioReInscripcion=$con->obtenerValor($consulta);
									$fechaFinReInscripcion="";
									if($fechaInicioReInscripcion!="")
									{
										$fechaInicioReInscripcion=date("d/m/Y",strtotime($fechaInicioReInscripcion));
										$consulta="SELECT DISTINCT max(fechaFinReInscripcion) FROM 4579_gradosRegistroInscripcion g where
											 idFormulario=692 AND idReferencia IN (".$listReferencias.") AND  idInstanciaPlan=".$idInstancia."  and idGrado=".$filaGrado[0]."
											AND idPeriodo=".$periodo." AND g.situacion=1 ";
										$fechaFinReInscripcion=$con->obtenerValor($consulta);
										$fechaFinReInscripcion=date("d/m/Y",strtotime($fechaFinReInscripcion));
									}
									if(($fechaFinInscripcion!="")||($fechaInicioReInscripcion!=""))
									{
										$oGrado='{"icon":"../images/s.gif","text":"'.cv($filaGrado[1]).'","fechasInscripcion":"<b>Del</b> '.$fechaInicioInscripcion.' <b>al</b> '.$fechaFinInscripcion.'","fechasReInscripcion":"<b>Del</b> '.
												$fechaInicioReInscripcion.' <b>al</b> '.$fechaFinReInscripcion.'",leaf:true}';	
										if($arrGrados=="")
											$arrGrados=$oGrado;
										else
											$arrGrados.=",".$oGrado;
									}
								}
								
								
								$objPlan='{"icon":"../images/s.gif","text":"<span class=\'corpo8_bold\'>Plan de Estudios:</span> '.cv($nomPlan).'","fechasInscripcion":"","fechasReInscripcion":"",leaf:false,children:['.$arrGrados.']}';	
								if($arrInstancias=="")
									$arrInstancias=$objPlan;
								else
									$arrInstancias.=",".$objPlan;
								
							}
							$obj='{"icon":"../images/s.gif","text":"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important\'>Ciclo:</span> '.cv($nombreCiclo).', <span class=\'letraRojaSubrayada8\' style=\'color:#900 !important\'>Periodo: </span>'.cv($nombrePeriodo).'","fechasInscripcion":"","fechasReInscripcion":"",leaf:false,children:['.$arrInstancias.']}';
							
							if($cadFinal=="")
								$cadFinal=$obj;
							else
								$cadFinal.=",".$obj;
						}
					}
				}
				
				
				
				
			}
		}
		
		echo "[".$cadFinal."]";
	}
	
	function obtenerFechasProgramaEducativoPortalNuevoIngreso()
	{
		global $con;

		$idPrograma=$_POST["idPrograma"];	
		$plantel=$_POST["plantel"];	
		$cadFinal='';
		$obj='';
		$consulta="SELECT i.idModalidad FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idPrograma;
		$listModalidades=$con->obtenerListaValores($consulta);
		if($listModalidades=="")
			$listModalidades=-1;
		$consulta="SELECT idModalidad,nombre FROM 4514_tipoModalidad WHERE idModalidad IN (".$listModalidades.") ORDER BY nombre";
		$resModalidad=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resModalidad))
		{
			
			$consulta="SELECT i.idTurno FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE 
				p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idPrograma." and i.idModalidad=".$fila[0];
			$lista=$con->obtenerListaValores($consulta);
			if($lista=="")
				$lista=-1;
			$consulta="SELECT idTurno,turno FROM 4516_turnos WHERE idTurno IN (".$lista.") ORDER BY turno";
			$resTurnos=$con->obtenerFilas($consulta);
			$arrTurnos="";
			while($filaTurno=mysql_fetch_row($resTurnos))
			{
				$fechaInscricion="<img src='../images/cross.png' width='13' height='13'>&nbsp;&nbsp;No publicadas a&uacute;n";
				
				
				$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND sede='".$plantel."' AND idModalidad=".$fila[0]." AND idTurno=".$filaTurno[0]." AND p.idProgramaEducativo=".$idPrograma;
				$listInstancias=$con->obtenerListaValores($consulta);
				if($listInstancias=="")
					$listInstancias=-1;
				$fechaActual=date("Y-m-d");
				$listReferencias="";
				$consulta="SELECT id__692_tablaDinamica,cmbCicloInscripcion FROM _692_tablaDinamica t WHERE codigoInstitucion='".$plantel."' and idEstado=2 AND '".$fechaActual."'>=fechaInicio AND '".$fechaActual."'<=fechaTermino";
				$resConv=$con->obtenerFilas($consulta);
				$arrCiclos=array();
				$nElementos=0;
				$referenciasPlanes=array();
				while($filaConv=mysql_fetch_row($resConv))
				{
					if(!isset($arrCiclos[$filaConv[1]]))
						$arrCiclos[$filaConv[1]]=array();
					$consulta="SELECT DISTINCT idPeriodo,idInstanciaPlanEstudio FROM 4578_instanciasPlanEstudiosRegistroInscripcion WHERE 
					idFormulario=692 AND idReferencia=".$filaConv[0]." AND idInstanciaPlanEstudio IN (".$listInstancias.") and inscribeNuevosIngresos=1";
					$resPeriodo=$con->obtenerFilas($consulta);
					if($con->filasAfectadas>0)
					{
						if($listReferencias=="")
							$listReferencias=$filaConv[0];
						else
							$listReferencias.=",".$filaConv[0];
					}
					while($fPeriodo=mysql_fetch_row($resPeriodo))
					{
						if(!isset($arrCiclos[$filaConv[1]][$fPeriodo[0]]))
							$arrCiclos[$filaConv[1]][$fPeriodo[0]]=array();
						if(sizeof($arrCiclos[$filaConv[1]][$fPeriodo[0]])==0)
						{
							array_push($arrCiclos[$filaConv[1]][$fPeriodo[0]],$fPeriodo[1]);
							$referenciasPlanes[$filaConv[1]."_".$fPeriodo[0]."_".$fPeriodo[1]]=$filaConv[0];
							$nElementos++;
						}
						
					}
				}
				
				
				$arrPlanesFinal=array();
				
				if(sizeof($arrCiclos)>0)
				{
					foreach($arrCiclos as $ciclo=>$resto)
					{
						$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$ciclo;
						$nombreCiclo=$con->obtenerValor($consulta);
						if(sizeof($resto)>0)
						{
							foreach($resto as $idPeriodo=>$planes)
							{
								$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$idPeriodo;
								$nombrePeriodo=$con->obtenerValor($consulta);
								if(sizeof($planes)>0)
								{
									foreach($planes as $idInstanciaPlan)
									{
										$consulta="SELECT nombrePlanEstudios FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
										$nomPlan=$con->obtenerValor($consulta);
										$duracionPeriodo="";
										$consulta="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idCiclo=".$ciclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstanciaPlan;
										$fFechas=$con->obtenerPrimeraFila($consulta);
										if(($fFechas)&&($fFechas[0]!="")&&($fFechas[1]!=""))
											$duracionPeriodo="(<b>Del</b> ".date("d/m/Y",strtotime($fFechas[0]))." <b>al</b> ".date("d/m/Y",strtotime($fFechas[1])).")";
										$llave="<img src='../images/resultset_next.png'><b>Ciclo:</b> ".$nombreCiclo.", <b>Periodo:</b> ".$nombrePeriodo;
										$arrPlanesFinal[$llave]["periodo"]=$duracionPeriodo;
										$arrPlanesFinal[$llave]["idInstancia"]=$idInstanciaPlan;
										$arrPlanesFinal[$llave]["idCiclo"]=$ciclo;
										$arrPlanesFinal[$llave]["idPeriodo"]=$idPeriodo;
										$arrPlanesFinal[$llave]["leyenda"]="Ciclo: ".$nombreCiclo.", Periodo: ".$nombrePeriodo." ".str_replace("</b>","",str_replace("<b>","",$duracionPeriodo));
										
									}
								}
							}
						}
					}
				}
				
				$comp='leaf:true';
				ksort($arrPlanesFinal);
				if(sizeof($arrPlanesFinal)>0)
				{
					$arrPeriodos="";
					foreach($arrPlanesFinal as $plan=>$resto)
					{
						$opcion="";
						$fechaInscricion2="<img src='../images/cross.png' width='13' height='13'>&nbsp;&nbsp;No publicadas a&uacute;n";
						$idReferencia=$referenciasPlanes[$resto["idCiclo"]."_".$resto["idPeriodo"]."_".$resto["idInstancia"]];
						$consulta="SELECT fechaInicioInscripcion,fechaFinInscripcion FROM 4579_gradosRegistroInscripcion i,4501_Grado g
									WHERE g.idGrado=i.idGrado AND idFormulario=692 AND idReferencia=".$idReferencia." AND idInstanciaPlan=".$resto["idInstancia"].
									" AND idPeriodo=".$resto["idPeriodo"]." ORDER BY ordenGrado LIMIT 0,1";
						
						$filaFecha=$con->obtenerPrimeraFila($consulta);
						if(($filaFecha)&&($filaFecha[0]!="")&&($filaFecha[1]!=""))
						{
							$fechaInscricion2='<b>Del</b> '.date("d/m/Y",strtotime($filaFecha[0])).' <b>al</b> '.date("d/m/Y",strtotime($filaFecha[1]));
							$fActual=strtotime(date("Y-m-d"));
							if(($fActual>=strtotime($filaFecha[0]))&&($fActual<=strtotime($filaFecha[1])))
							{
								$idBtn=$resto["idCiclo"]."_".$resto["idPeriodo"]."_".$resto["idInstancia"];
								$opcion="&nbsp;<input class='btnSolicitud' type='button' id='".$idBtn."' value='Solicitar inscripci&oacute;n' onclick='solicitarInscripcion(this)'>";
							}
							
						}
						$o='{"icon":"../images/s.gif","text":"<span title=\''.cv($resto["leyenda"]).'\' alt=\''.cv($resto["leyenda"]).'\'>'.cv($plan." ".$resto["periodo"]).'</span>","idInstancia":"'.$resto["idInstancia"].
						'","idCiclo":"'.$resto["idCiclo"].'","idPeriodo":"'.$resto["idPeriodo"].'","fechasInscripcion":"'.$fechaInscricion2.'","fechasReInscripcion":"","opcion":"'.$opcion.'",leaf:true}';
						if($arrPeriodos=="")
							$arrPeriodos=$o;
						else
							$arrPeriodos.=",".$o;
					}
					$comp='leaf:false,children:['.$arrPeriodos.']';
					$fechaInscricion="";
				}
				
				
				
				$obj='{"icon":"../images/s.gif","text":"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important; font-size:13px !important\'>Turno:</span> <span class=\'letraRojaSubrayada8\' style=\'color:#003 !important; font-size:13px !important\'>'.
						cv($filaTurno[1]).'</span>","fechasInscripcion":"'.$fechaInscricion.'","fechasReInscripcion":"","opcion":"",'.$comp.'}';
				if($arrTurnos=="")
					$arrTurnos=$obj;
				else
					$arrTurnos.=",".$obj;
			}
			
			$obj='{"icon":"../images/s.gif","text":"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important; font-size:13px !important\'>Modalidad:</span> <span class=\'letraRojaSubrayada8\' style=\'color:#003 !important; font-size:13px !important\'>'.
					cv($fila[1]).'</span>","fechasInscripcion":"","fechasReInscripcion":"",leaf:false,children:['.$arrTurnos.'],"opcion":""}';
			if($cadFinal=="")
				$cadFinal=$obj;
			else
				$cadFinal.=",".$obj;
		}
		
		echo "[".$cadFinal."]";
	}
	
	function designarPlanEstudioReceptorNuevoIngreso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 4578_instanciasPlanEstudiosRegistroInscripcion SET inscribeNuevosIngresos=0 WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idInstanciaPlanEstudio IN (".$obj->restoInstancias.") AND idPeriodo=".$obj->idPeriodo;
		$x++;
		$consulta[$x]="UPDATE 4578_instanciasPlanEstudiosRegistroInscripcion SET inscribeNuevosIngresos=1 WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idInstanciaPlanEstudio =".$obj->idInstanciaPlan." AND idPeriodo=".$obj->idPeriodo;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);		
	}
	
	function obtenerSolicitudesInscripcion()
	{
		global $con;
		
		$arrRegistros="";
		$consulta="SELECT t.id__678_tablaDinamica,t.fechaCreacion,idEstado,datosInscripcion FROM 4573_solicitudesInscripcion s,_678_tablaDinamica t WHERE 
                   t.idReferencia=s.idSolicitudInscripcion AND s.idUsuario=".$_SESSION["idUsr"];
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		while($filas=mysql_fetch_row($res))
		{
			$datosInscripcion=$filas[3];
			$oDatos=json_decode($datosInscripcion);
			
			$consulta="SELECT nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos pr WHERE 
                   		pr.idProgramaEducativo=p.idProgramaEducativo AND p.idPlanEstudio=i.idPlanEstudio AND i.idInstanciaPlanEstudio=".$oDatos->idInstanciaPlan;
			$planEstudio=$con->obtenerValor($consulta);
			$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$oDatos->idCiclo;
			$ciclo=$con->obtenerValor($consulta);
			$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$oDatos->idPeriodo;
			$periodo=$con->obtenerValor($consulta);
			$actor=obtenerActorProcesoIdRol(102,'79_0',$filas[2]);
			$obj='{"idSolicitud":"'.$filas[0].'","fechaSolicitud":"'.$filas[1].'","situacion":"'.$filas[2].'","planEstudio":"'.$planEstudio.'","ciclo":"'.$ciclo.'","periodo":"'.$periodo.'","actor":"'.$actor.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
		
	}


function registrarRespuestaADictamenRevalidacion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$respuesta=$_POST["respuesta"];
	$comentarios=$_POST["comentarios"];
	$consulta="SELECT id__685_tablaDinamica FROM _685_tablaDinamica WHERE idReferencia=".$idRegistro;
	$idRevalidacion=$con->obtenerValor($consulta);
	if($idRevalidacion=="")
		$idRevalidacion=-1;
	if($respuesta==0)
	{
		cambiarEtapaFormulario(678,$idRegistro,7,$comentarios);
		cambiarEtapaFormulario(685,$idRevalidacion,7,$comentarios);
	}
	else
	{
		cambiarEtapaFormulario(678,$idRegistro,2,$comentarios);
		cambiarEtapaFormulario(685,$idRevalidacion,4,$comentarios);
	}
	echo "1|";
	
}

function obtenerPlanesEstudioProgramaEducativoPeriodoFechas()
{
	global $con;
	$idPeriodo=$_POST["idPeriodo"];
	$plantel=$_POST["plantel"];
	$idProgramaEducativo=$_POST["idProgramaEducativo"];
	$idCiclo=$_POST["idCiclo"];
	$idInstancia=$_POST["idInstancia"];
	
	$arrRegistros="";
	$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio,i.tipoEsquemaParcialesGrupo,i.numParcialesGrupo,i.tipoEsquemaAsignacionFechasGrupo,i.numMaxBloquesFechas 
			FROM 4513_instanciaPlanEstudio i where idInstanciaPlanEstudio=".$idInstancia;
	
	$idReferenciaExamenes=obtenerPerfilExamenesAplica("",$idInstancia);
	$consulta="SELECT id__720_tablaDinamica,e.examen FROM _398_gridTiposExamen g,_721_tablaDinamica t,_720_tablaDinamica e WHERE g.idReferencia=".$idReferenciaExamenes." 
				AND t.id__721_tablaDinamica=g.tipoExamen AND e.id__720_tablaDinamica=t.examen ORDER BY t.prioridadAplicaExamen";

	$resExamenes=$con->obtenerFilas($consulta);	
	$arrColumnas="{header:'',width:300,sortable:true,dataIndex:'descripcion',renderer:formatearDescripcion}";
	$arrCampos="{name:'idElemento'},{name:'tipoElemento'},{name:'descripcion'}";
	
	$maxBloques=5;
	for($ct=1;$ct<=$maxBloques;$ct++)
	{
		$oColumna="{align:'center',header:'Parcial ".$ct."',width:120,sortable:true,dataIndex:'parcial_".$ct."',editor:{xtype:'datefield'},renderer:formatearFechaExamen}";
		if($arrColumnas=="")				
			$arrColumnas=$oColumna;
		else
			$arrColumnas.=",".$oColumna;
		$oCampos="{name:'parcial_".$ct."',type:'date', dateFormat:'Y-m-d'}";
		if($arrCampos=="")
			$arrCampos=$oCampos;
		else
			$arrCampos.=",".$oCampos;
	}
	
	while($fExamen=mysql_fetch_row($resExamenes))
	{
		$oColumna="{align:'center',header:'".$fExamen[1]."',width:130,sortable:true,dataIndex:'examen_".$fExamen[0]."',editor:{xtype:'datefield'},renderer:formatearFechaExamen}";
		if($arrColumnas=="")				
			$arrColumnas=$oColumna;
		else
			$arrColumnas.=",".$oColumna;
		$oCampos="{name:'examen_".$fExamen[0]."',type:'date', dateFormat:'Y-m-d'}";
		if($arrCampos=="")
			$arrCampos=$oCampos;
		else
			$arrCampos.=",".$oCampos;
		
	}
	
	$nRegistros=0;
	
	$nPlanEstudios=cv(obtenerNombreInstanciaPlan($idInstancia));
	$idPlanEstudio="";//$fila[1];
	$fila[2]=2;
	$fila[3]=3;
	$fila[4]=2;
	$fila[5]=3;
	$fila[0]=0;
	if($fila[2]==2)
	{	
		
		$numParciales=$fila[3];
		if($fila[4]==2)
		{
			$maxBloques=$fila[5];
			for($ct=1;$ct<=$maxBloques;$ct++)
			{
				$obj='{"editable":"1","numBloque":"'.$ct.'","tipoElemento":"0","complementario":"","idElemento":"'.$ct.'","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.'","descripcion":"'.cv("Bloque ".$ct).'","fechaInicio":"","fechaFin":""}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nRegistros++;
				/*for($x=1;$x<=$numParciales;$x++)
				{
					$consulta="SELECT fechaInicio,fechaFin FROM 4580_fechasExamenes WHERE idInstancia=".$fila[0]." AND idExamen=1 AND complementario='".$x."' AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and numBloque=".$ct;
  
					$fFechas=$con->obtenerPrimeraFila($consulta);
					$obj='{"editable":"1","numBloque":"'.$ct.'","tipoElemento":"1","complementario":"'.$x.'","idElemento":"1","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.
						'","descripcion":"'.cv("Parcial ".$x).'","fechaInicio":"'.$fFechas[0].'","fechaFin":"'.$fFechas[1].'"}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					$nRegistros++;
				}
				
				$consulta="SELECT id__720_tablaDinamica,examen FROM  _720_tablaDinamica WHERE id__720_tablaDinamica>1 ORDER BY codigo";
				$resAux=$con->obtenerFilas($consulta);
				while($filaAux=mysql_fetch_row($resAux))
				{
					$consulta="SELECT fechaInicio,fechaFin FROM 4580_fechasExamenes WHERE idInstancia=".$fila[0]." AND idExamen=".$filaAux[0]." AND complementario='' AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and numBloque=".$ct;
					$fFechas=$con->obtenerPrimeraFila($consulta);
					$obj='{"editable":"1","numBloque":"'.$ct.'","tipoElemento":"1","complementario":"","idElemento":"'.$filaAux[0].'","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.
					'","descripcion":"'.cv($filaAux[1]).'","fechaInicio":"'.$fFechas[0].'","fechaFin":"'.$fFechas[1].'"}';
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					$nRegistros++;
				}*/
			
			}
		}
		else
		{
			/*for($x=1;$x<=$numParciales;$x++)
			{
				$consulta="SELECT fechaInicio,fechaFin FROM 4580_fechasExamenes WHERE idInstancia=".$fila[0]." AND idExamen=1 AND complementario='".$x."' AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and numBloque=1";
				
				$fFechas=$con->obtenerPrimeraFila($consulta);
				$obj='{"editable":"1","numBloque":"1","tipoElemento":"1","complementario":"'.$x.'","idElemento":"1","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.'",
					"descripcion":"'.cv("Parcial ".$x).'","fechaInicio":"'.$fFechas[0].'","fechaFin":"'.$fFechas[1].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nRegistros++;
			}
			
			$consulta="SELECT id__720_tablaDinamica,examen FROM  _720_tablaDinamica WHERE id__720_tablaDinamica>1 ORDER BY codigo";
			$resAux=$con->obtenerFilas($consulta);
			while($filaAux=mysql_fetch_row($resAux))
			{
				$consulta="SELECT fechaInicio,fechaFin FROM 4580_fechasExamenes WHERE idInstancia=".$fila[0]." AND idExamen=".$filaAux[0]." AND complementario='' AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and numBloque=1";
				$fFechas=$con->obtenerPrimeraFila($consulta);
				$obj='{"editable":"1","numBloque":"1","tipoElemento":"1","complementario":"","idElemento":"'.$filaAux[0].'","idInstanciaPlan":"'.$fila[0].'","planEstudios":"'.$nPlanEstudios.
					'","descripcion":"'.cv($filaAux[1]).'","fechaInicio":"'.$fFechas[0].'","fechaFin":"'.$fFechas[1].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nRegistros++;
			}
			*/
		}
	}
	echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$arrCampos.']},"numReg":"'.$nRegistros.'","registros":['.($arrRegistros).'],"campos":['.$arrColumnas.']}';

}	

function guardarFechasExamen()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	foreach($obj->arrValores as $o)
	{
		$query="SELECT idFechasExamen FROM 4580_fechasExamenes WHERE idInstancia=".$o->idInstanciaPlanEstudio." AND idExamen=".$o->idElemento." AND complementario='".$o->complementario.
		"' AND idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo." and numBloque=".$o->numBloque;
		$idFechasExamen=$con->obtenerValor($query);
		if($idFechasExamen=="")
		{
			$consulta[$x]="INSERT INTO 4580_fechasExamenes(idExamen,complementario,idInstancia,idCiclo,idPeriodo,fechaInicio,fechaFin,numBloque)
						VALUES(".$o->idElemento.",'".$o->complementario."',".$o->idInstanciaPlanEstudio.",".$obj->idCiclo.",".$obj->idPeriodo.",'".$o->fechaInicio."','".$o->fechaFin."',".$o->numBloque.")";
			$x++;
		}
		else
		{
			$consulta[$x]="UPDATE 4580_fechasExamenes SET fechaInicio='".$o->fechaInicio."',fechaFin='".$o->fechaFin."' WHERE idFechasExamen=".$idFechasExamen;
			$x++;
		}
	}
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
}

function guardarSelecionPlanPagosUsuario()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idUsuario="-1";
	$consulta="";
	$consulta="select idPlanPagoAlumno FROM 4581_planPagoAlumnoInscripcion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
	$idReferencia=$con->obtenerValor($consulta);
	$x=0;
	$query[$x]="begin";
	$x++;
	if($idReferencia=="")
	{
		$query[$x]="INSERT INTO 4581_planPagoAlumnoInscripcion(idFormulario,idReferencia,idPlanPago)
				VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->idPlanPago.")";
		$x++;
	}
	else
	{
		$query[$x]="update 4581_planPagoAlumnoInscripcion set idPlanPago=".$obj->idPlanPago." where idPlanPagoAlumno=".$idReferencia;
		$x++;
	}
	
	$query[$x]="commit";
	$x++;
	eB($query);
}

function obtenerTramitesDisponiblesAlumno()
{
	global $con;
	$idUsuario=$_POST["idUsuario"];
	$arrTramites["0"]="Inscripción";
	$arrTramites["1"]="Administrativo";

	$arrObj='';
	foreach($arrTramites as $id=>$t)
	{
		$objUnidad='{id:"'.$id.'",text:"<b>'.$t.'</b>","situacion":"","leaf":true}';
		if($arrObj=='')
			$arrObj=$objUnidad;
		else
			$arrObj.=",".$objUnidad;
	}
	
	echo '['.$arrObj.']';
	
	
}

function obtenerTipoBecaAspira()
{
	global $con;
	$consulta="SELECT id__699_tablaDinamica as idTipoBeca,planBeca,'' as nombreBeca FROM _699_tablaDinamica ORDER BY planBeca";
	$arrBecas=$con->obtenerFilasJSON($consulta);
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrBecas).'}';
}

function obtenerTiposExamen()
{
	global $con;
	$arreglo="";
	$consulta="SELECT id__720_tablaDinamica as idTipoExamen,examen as nombreExamen, FROM _720_tablaDinamica WHERE id__720_tablaDinamica>1";
	$arreglo=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arreglo).'}';
}

function obtenerPlanesEstudioPlantel()
{
	global $con;
	$plantel=$_POST["plantel"];
	$consulta="SELECT idPlanEstudio,CONCAT('[',IF(cvePlanEstudio IS NULL,'',cvePlanEstudio),'] ',nombre) AS nombrePlan,descripcion FROM 4500_planEstudio 
				WHERE idPlanEstudio IN (SELECT idPlanEstudio FROM 4504_sedesPermitidas where sede='".$plantel."') AND situacion=1 ORDER BY nombre";
	$arrPlanes=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrPlanes;
}

function obtenerPeriodoInscripcionVentanilla()
{
	global $con;
	$idReferencia=$_POST["idReferencia"];

	$arrRegistros="";
	$consulta="SELECT DISTINCT idPeriodo,nombrePeriodo FROM 4578_instanciasPlanEstudiosRegistroInscripcion i,_464_gridPeriodos g WHERE g.id__464_gridPeriodos=i.idPeriodo AND 
				i.idReferencia in (".$idReferencia.") AND idFormulario=692 AND inscribeNuevosIngresos=1 ORDER BY nombrePeriodo";
	$arrRegistros=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrRegistros;
}

function obtenerPlanEstudioInscripcionVentanilla()
{
	global $con;
	$idReferencia=$_POST["idReferencia"];
	$idPeriodo=$_POST["idPeriodo"];
	$arrRegistros="";
	$arrInstancias=array();
	$consulta="SELECT DISTINCT idInstanciaPlanEstudio,idInstanciasInscripcion FROM 4578_instanciasPlanEstudiosRegistroInscripcion i WHERE 
				i.idReferencia in (".$idReferencia.") AND idFormulario=692 AND inscribeNuevosIngresos=1 and 
				idPeriodo=".$idPeriodo;
	$res=$con->obtenerFilas($consulta);
	while($f=mysql_fetch_row($res))
	{
		$nInstancia=obtenerNombreInstanciaPlan($f[0]);
		$arrInstancias[$nInstancia][0]=$f[1];
		$arrInstancias[$nInstancia][1]=$f[0];
	}
	
	ksort($arrInstancias);
	
	foreach($arrInstancias as $i=>$id)
	{
		$o="['".$id[0]."','".$i."','".$id[1]."']";
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	echo "1|[".$arrRegistros."]";
}

function obtenerRegistrosInscripcion()
{
	global $con;
	$cadCondWhere=" 1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
	$idCiclo=$_POST["idCiclo"];
	$idPeriodo=$_POST["idPeriodo"];
	$plantel=$_POST["plantel"];
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$consulta="SELECT idSolicitudInscripcion FROM 4573_solicitudesInscripcion WHERE idCiclo=".$idCiclo;
	if($idPeriodo!=0)
		$consulta.=" AND idPeriodo=".$idPeriodo;
	$listRef=$con->obtenerListaValores($consulta);
	if($listRef=="")
		$listRef=-1;
	$consulta="SELECT  id__678_tablaDinamica,codigo,fechaCreacion,txtNombre,paterno,materno,'0' as solicitaRevalidacion,
			(SELECT CONCAT(nombrePlanEstudios,' Modalidad: ',m.nombre,' Turno: ',t.turno) FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t,4573_solicitudesInscripcion s  WHERE i.idInstanciaPlanEstudio=s.idInstancia
             and s.idSolicitudInscripcion=tb.idReferencia      AND m.idModalidad=i.idModalidad AND t.idTurno=i.idTurno) as planEstudiosInscribe,
			idEstado FROM _678_tablaDinamica tb WHERE codigoInstitucion='".$plantel."' AND idReferencia IN(".$listRef.") and ".$cadCondWhere." order by id__678_tablaDinamica limit ".$start.",".$limit;
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	$consulta="SELECT  id__678_tablaDinamica,codigo,fechaCreacion,txtNombre,paterno,materno,'0' as solicitaRevalidacion,
			(SELECT CONCAT(nombrePlanEstudios,' Modalidad: ',m.nombre,' Turno: ',t.turno) FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t,4573_solicitudesInscripcion s  WHERE i.idInstanciaPlanEstudio=s.idInstancia
             and s.idSolicitudInscripcion=tb.idReferencia      AND m.idModalidad=i.idModalidad AND t.idTurno=i.idTurno) as planEstudiosInscribe,
			idEstado FROM _678_tablaDinamica tb WHERE codigoInstitucion='".$plantel."' AND idReferencia IN(".$listRef.") and ".$cadCondWhere;
	$con->obtenerFilas($consulta);			
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}

function cancelarRegistroInscripcion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$motivo=$_POST["motivo"];
	if(cambiarEtapaFormulario(678,$idRegistro,9,$motivo))
		echo "1|";
}

function guardarGrupoCompartido()
{
	global $con;
	global $arrDiasSemana;
	$arrIncidencias=array();
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idGrupoOrigen=$obj->idGrupoOrigen;
	$idGrupoDestino=$obj->idGrupoDestino;
	$idPlanEstudioResp=$obj->idPlanEstudioResp;
	$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoOrigen;
	$fGrupoOrigen=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoDestino;
	$fGrupoDestino=$con->obtenerPrimeraFila($consulta);
	$idInstancia2=$idPlanEstudioResp;
	if($fGrupoOrigen[11]!=$fGrupoDestino[11])
	{
		if($fGrupoDestino[11]!=$idPlanEstudioResp)
		{
			$idInstancia2=$fGrupoDestino[11];
			$idGrupoOrigen=$obj->idGrupoDestino;
			$fAux=$fGrupoOrigen;
			$fGrupoOrigen=$fGrupoDestino;
			$idGrupoDestino=$obj->idGrupoOrigen;
			$fGrupoDestino=$fAux;
		}
		else
			$idInstancia2=$fGrupoOrigen[11];
	}
	
	if($obj->validar!=0)
	{
	
		$consulta="SELECT dia,horaInicio,horaFin,idGrupo,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupoDestino." ORDER BY dia,horaInicio";

		$resHorario=$con->obtenerFilas($consulta);
		$arrHorario=array();
		while($fHorario=mysql_fetch_row($resHorario))
		{
			if(!isset($arrHorario[$fHorario[0]]))
				$arrHorario[$fHorario[0]]=array();
			$objHorario[0]=$fHorario[1];
			$objHorario[1]=$fHorario[2];
			$objHorario[2]=$fHorario[3];
			$objHorario[3]=($fHorario[4]);//Fecha Inicio
			$objHorario[4]=($fHorario[5]);//Fecha Fin
			array_push($arrHorario[$fHorario[0]],$objHorario);
		}

		foreach($arrHorario as $dia=>$resto)
		{
			foreach($resto as $horario)
			{
				$horaInicial=$horario[0];
				$horaFinal=$horario[1];
				$fechaInicio=$horario[3];
				$fechaFin=$horario[4];
				$resultado=validarChoqueGruposHermanosV2($idGrupoOrigen,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupoOrigen,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarColisionRecesoV2($idGrupoOrigen,$dia,$horaInicial,$horaFinal);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
			}
		}

		if(sizeof($arrIncidencias)>0)
		{
			$arrAux=array();
			foreach($arrIncidencias as $i)
			{
				if(!isset($arrAux[$i->noError]))
					$arrAux[$i->noError]=array();
				array_push($arrAux[$i->noError],$i);
				
			}
			ksort($arrAux);
			
			$arrIncidenciasFinal=array();
			foreach($arrAux as $arr)
			{
				foreach($arr as $i)
					array_push($arrIncidenciasFinal,$i);
			}
			
			echo "1|".generarResolucionArregloErrores($arrIncidenciasFinal);
			return;
		}
	}
	

	$x=0;
	$query[$x]="begin";
	$x++;
	$ejecutarTransaccion=false;
	$consulta="SELECT idUsuario FROM 4500_usuariosResponsablesPlanEstudio WHERE plantel='".$fGrupoOrigen[2]."' AND idPlanEstudio=".$fGrupoOrigen[1]." and idUsuario=".$_SESSION["idUsr"];
	$fRespO=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT idUsuario FROM 4500_usuariosResponsablesPlanEstudio WHERE plantel='".$fGrupoDestino[2]."' AND idPlanEstudio=".$fGrupoDestino[1]." and idUsuario=".$_SESSION["idUsr"];
	$fRespD=$con->obtenerPrimeraFila($consulta);
	//if($fRespO&&$fRespD)
		$ejecutarTransaccion=true;
	
	if($ejecutarTransaccion)
	{
		$query[$x]="update 4517_alumnosVsMateriaGrupo SET idGrupo=".$idGrupoDestino.",idGrupoOrigen=".$idGrupoOrigen." WHERE idGrupo=".$idGrupoOrigen;
		$x++;
		$query[$x]="update 4520_grupos SET situacion=2 where idGrupos=".$idGrupoOrigen;
		$x++;
		$query[$x]="insert into 4539_gruposCompartidos(idGrupo,idInstanciaComparte,idMateriaEquivalente,idGrupoReemplaza) 
					VALUES(".$idGrupoDestino.",".$fGrupoOrigen[11].",".$fGrupoOrigen[3].",".$idGrupoOrigen.")";
		$x++;
	}
	else
	{
		$query[$x]="INSERT INTO 4545_transaccionesPlanesEstudio(tipoTransaccion,idInstanciaPlan,idInstanciaPlan2,complementario1,complementario2,situacion,fechaTransaccion,respRegTransaccion)
				values(1,".$idPlanEstudioResp.",".$idInstancia2.",'".$idGrupoOrigen."','".$idGrupoDestino."',1,'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].")";
		$x++;
				
	}
	$query[$x]="commit";
	$x++;
	if($con->ejecutarBloque($query))
	{
		echo '1|{"permiteContinuar":"1","arrErrores":[]}';
	}
}

function registrarSolicitudMovimientoAME()
{
	global $con;
	$x=0;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$complementario1="";
	$idAsignacion="NULL";
	$datosSolicitud="";
	
	$folio="";
	$consulta[$x]="begin";
	$x++;
	if($obj->idSolicitudAME==-1)
	{
		$folio=generarFolioAME($obj->idGrupo);
		$consulta[$x]="INSERT INTO 4549_cabeceraSolicitudAME(folioSolicitud,idGrupo,situacion,fechaRegistro,idResponsable,plantel)
						VALUES('".$folio."',NULL,1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->plantel."')";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
	}
	else
	{
		$query="SELECT folioSolicitud FROM 4549_cabeceraSolicitudAME WHERE idSolicitudAME=".$obj->idSolicitudAME;
		$folio=$con->obtenerValor($query);
		$consulta[$x]="set @idRegistro:=".$obj->idSolicitudAME;
		$x++;
	}
	
	$query="SELECT idCiclo,idPeriodo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$obj->idGrupo;
	$fGrupo=$con->obtenerPrimeraFila($query);
	$idCiclo=$fGrupo[0];
	$idPeriodo=$fGrupo[1];
	$idInstancia=$fGrupo[2];
	$arrIncidencias=array();
	$listGruposInvolucrados="";
	switch($obj->tipoMovimiento)
	{
		case "1":  //Alta de titular
		case "3":	//Alta de suplencia
			$datosSolicitud="";
			if(($obj->validar==1)&&($obj->idProfesor!=2))
			{
				$resultado=validarPerfilProfesorGrupoV2($obj->idProfesor,$obj->idGrupo);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				$horaMatProf=obtenerFechasHorarioGrupoV2($obj->idGrupo,$obj->idSolicitudAME,true,true,$obj->fechaInicio,$obj->fechaFin);
				foreach($horaMatProf as $filaMat)
				{
					$dia=$filaMat[2];
					$horaInicial=$filaMat[3];
					$horaFinal=$filaMat[4];
					$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$obj->idProfesor,$idPeriodo,$idInstancia);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarDisponibilidadHorarioProfesorV2($obj->idProfesor,$horaInicial,$horaFinal,$dia,$obj->fechaInicio,$obj->fechaFin,-1,-1,$obj->idSolicitudAME);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
				}	
			}
			$datosSolicitud='{"fechaAplicacion":"'.$obj->fechaInicio.'","fechaTermino":"'.$obj->fechaFin.'","motivo":"'.cv(str_replace('"','\"',$obj->motivo)).
							'","idProfesor":"'.$obj->idProfesor.'"}';
				
		break;
		case "2":	//Baja de titular
		case "5":	//Finalizacion suplencia
			$datosSolicitud='{"fechaBaja":"'.$obj->fechaBaja.'"}';
			$idAsignacion=$obj->idAsignacion;
			$complementario1=$obj->idMotivo;
		break;
		case "4"://Cambio de horario de grupo
		case "6"://Cambio de fecha de grupo
			$datosSolicitud="";
			$cadHorarioAnt="";
			$cadHorario="";
			$compCambioHorario="";

			if($obj->validar==1)
			{
				
				$cadHorarioAnt="";
				$cadHorario="";
				foreach($obj->arrHorario as $h)
				{
					$o='{"dia":"'.$h->dia.'","horaInicial":"'.$h->horaInicial.'","horaFinal":"'.$h->horaFinal.'","idAula":"'.$h->idAula.'"}';
					if($cadHorario=="")
						$cadHorario=$o;
					else
						$cadHorario.=",".$o;
				}
				$duracionHora=obtenenerDuracionHoraGrupo($obj->idGrupo);
				$fechaFinOriginal=$obj->fechaFin;
				if($obj->recalcularFechaTermino==1)
				{
					$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($obj->idGrupo,$obj->idSolicitudAME,false,false);
					
					foreach($obj->arrHorario as $h)
					{
						$objFecha=array();
						$objFecha[0]="0";
						$objFecha[1]=$obj->idGrupo;
						$objFecha[2]=$h->dia;
						$objFecha[3]=$h->horaInicial;
						$objFecha[4]=$h->horaFinal;
						$objFecha[5]=$h->idAula;
						$objFecha[6]=$obj->fechaInicio;
						$objFecha[7]=$obj->fechaFin;
						if(strtotime($obj->fechaInicio)>strtotime($obj->fechaFin))
							$objFecha[7]=$objFecha[6];
						array_push($arrHorarioGrupo,$objFecha);
					}
					$arrHorarioGrupo=ordenarFechasArreglo($arrHorarioGrupo);

					$arrHorarioGrupo=normalizarFechasBloque($arrHorarioGrupo);

					$totalHoraImpartidas=0;
					$fechaBase=$obj->fechaInicio;
					if($obj->tipoMovimiento==4)
					{
						$fechaBase=$arrHorarioGrupo[0][6];
						
						$totalHoraImpartidas=0;
						$query="SELECT horario FROM 4530_sesiones WHERE idGrupo=".$obj->idGrupo." AND fechaSesion<'".$fechaBase."' AND tipoSesion<>15";

						$resHorario=$con->obtenerFilas($query);
						while($fHorario=mysql_fetch_row($resHorario))
						{
							$aHorario=explode("-",$fHorario[0]);
							$hInicial=(trim($aHorario[0]));
							$hFinal=(trim($aHorario[1]));
							$totalHoraImpartidas+=obtenerDiferenciaHoraMinutos($hInicial,$hFinal);
						}
						$totalHoraImpartidas/=$duracionHora;

					}
					$arrDiasSesion=array();
					$maxFechaFin="";
					foreach($arrHorarioGrupo as $h)
					{
						if($maxFechaFin=="")
							$maxFechaFin=$h[7];
						else
						{
							if(strtotime($maxFechaFin)<strtotime($h[7]))
							{
								$maxFechaFin=$h[7];
							}
						}
					}
					
					foreach($arrHorarioGrupo as $h)
					{
						$hInicio=strtotime($h[3]);
						$hFin=strtotime($h[4]);
						if(!isset($arrDiasSesion[$h[2]]))
						{
							$arrDiasSesion[$h[2]]=array();
						}
						$objFecha=array();
						$objFecha[0]=date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
						$objFecha[1]=strtotime($h[6]);
						$objFecha[2]=strtotime($h[7]);
						$objFecha[3]=obtenerDiferenciaHoraMinutos($h[3],$h[4])/$duracionHora;
						$objFecha[4]=$h[6];
						$objFecha[5]=$h[7];
						if($h[7]==$maxFechaFin)
						{
							
							$objFecha[2]=strtotime("+2 years",strtotime($h[7]));
							
							$objFecha[5]=date("Y-m-d",$objFecha[2]);
							
						}
						if($h[2]!=10)
							array_push($arrDiasSesion[$h[2]],$objFecha);
					}
					$noBloqueGrupo=0;
					if(($obj->noBloque!="")&&($obj->validarFechaFinBloque==1))
						$noBloqueGrupo=$obj->noBloque;
					
					$compCambioHorario='"fechaTerminoOriginal":"'.$obj->fechaFin.'",';
					$obj->fechaFin=obtenerFechaFinCursoHorario($obj->idGrupo,$fechaBase,$arrDiasSesion,$totalHoraImpartidas,$noBloqueGrupo);

				}
				else
				{

					$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($obj->idGrupo,$obj->idSolicitudAME,false,false);
					if(sizeof($obj->arrHorario)>0)
					{
						foreach($obj->arrHorario as $h)
						{
							$objFecha=array();
							$objFecha[0]="0";
							$objFecha[1]=$obj->idGrupo;
							$objFecha[2]=$h->dia;
							$objFecha[3]=$h->horaInicial;
							$objFecha[4]=$h->horaFinal;
							$objFecha[5]=$h->idAula;
							$objFecha[6]=$obj->fechaInicio;
							$objFecha[7]=$obj->fechaFin;
							array_push($arrHorarioGrupo,$objFecha);
						}
						$arrHorarioGrupo=ordenarFechasArreglo($arrHorarioGrupo);
						$arrHorarioGrupo=normalizarFechasBloque($arrHorarioGrupo);
						$totalHoraImpartidas=0;
						$fechaBase=$obj->fechaInicio;
						if($obj->tipoMovimiento==4)
						{
							$fechaBase=$arrHorarioGrupo[0][6];
							
							$totalHoraImpartidas=0;
							$query="SELECT horario FROM 4530_sesiones WHERE idGrupo=".$obj->idGrupo." AND fechaSesion<'".$fechaBase."' AND tipoSesion<>15";
	
							$resHorario=$con->obtenerFilas($query);
							while($fHorario=mysql_fetch_row($resHorario))
							{
								$aHorario=explode("-",$fHorario[0]);
								$hInicial=(trim($aHorario[0]));
								$hFinal=(trim($aHorario[1]));
								$totalHoraImpartidas+=obtenerDiferenciaHoraMinutos($hInicial,$hFinal);
							}
							$totalHoraImpartidas/=$duracionHora;
	
						}
						$arrDiasSesion=array();
						$maxFechaFin="";
						foreach($arrHorarioGrupo as $h)
						{
							if($maxFechaFin=="")
								$maxFechaFin=$h[7];
							else
							{
								if(strtotime($maxFechaFin)<strtotime($h[7]))
								{
									$maxFechaFin=$h[7];
								}
							}
						}
						foreach($arrHorarioGrupo as $h)
						{
							$hInicio=strtotime($h[3]);
							$hFin=strtotime($h[4]);
							if(!isset($arrDiasSesion[$h[2]]))
							{
								$arrDiasSesion[$h[2]]=array();
							}
							$objFecha=array();
							$objFecha[0]=date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
							$objFecha[1]=strtotime($h[6]);
							$objFecha[2]=strtotime($h[7]);
							$objFecha[3]=obtenerDiferenciaHoraMinutos($h[3],$h[4])/$duracionHora;
							$objFecha[4]=$h[6];
							$objFecha[5]=$h[7];
								
							$objFecha[2]=strtotime("+2 years",strtotime($h[7]));
							
							$objFecha[5]=date("Y-m-d",$objFecha[2]);
								
							
							if($h[2]!=10)
								array_push($arrDiasSesion[$h[2]],$objFecha);
						}
						
						
						$noBloqueGrupo=0;
						if(($obj->noBloque!="")&&($obj->validarFechaFinBloque==1))
							$noBloqueGrupo=$obj->noBloque;
						$fechaFinal=obtenerFechaFinCursoHorario($obj->idGrupo,$fechaBase,$arrDiasSesion,$totalHoraImpartidas,$noBloqueGrupo);
						
						if($obj->fechaFin!=$fechaFinal)
						{
							$obj->ajustarProfesorTitular=0;
							$obj->ultimoProfesorTitular=0;	
						}
						else
						{
							$fTemp=obtenerFechasDuracionGrupo($obj->idGrupo,$obj->idSolicitudAME);
							$compCambioHorario.='"fechaTerminoOriginal":"'.$fTemp[1].'","cursoFinaliza":"1",';
							$obj->recalcularFechaTermino=1;	
							$obj->fechaFin=$fechaFinal;
						}
					}
					else
						$obj->ajustarProfesorTitular=0;
				}
				

				$arrHorarioAnt=obtenerFechasHorarioGrupoV2($obj->idGrupo,$obj->idSolicitudAME);
				
				if(sizeof($arrHorarioAnt)>0)
				{
					foreach($arrHorarioAnt as $h)
					{
						$o='{"dia":"'.$h[2].'","horaInicial":"'.$h[3].'","horaFinal":"'.$h[4].'","idAula":"'.$h[5].'","fechaInicial":"'.$h[6].'","fechaFinal":"'.$h[7].'"}';
						if($cadHorarioAnt=="")
							$cadHorarioAnt=$o;
						else
							$cadHorarioAnt.=",".$o;
					}
				}
				$idGrupo=$obj->idGrupo;
				$arrProfesores=array();
				if($obj->tipoMovimiento==6)
					$arrProfesores=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitudAME,true,false,$obj->fechaInicio,$obj->fechaFin,0,true);
				else
					$arrProfesores=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitudAME,true,true,$obj->fechaInicio,$obj->fechaFin,0,true);

				if(isset($obj->ajustarProfesorTitular))
				{
					if(($obj->ajustarProfesorTitular==1)&&($obj->ultimoProfesorTitular!=0))
					{
						
						if($obj->ultimoProfesorTitular>0)
						{
							$fechaBaja=obtenerFechaBajaProfesorAME($obj->ultimoProfesorTitular,$obj->idSolicitudAME);
							if(!$fechaBaja)
							{
								$encProfesor=false;
								
								for($nPos=0;$nPos<sizeof($arrProfesores);$nPos++)
								{
									if($arrProfesores[$nPos][0]==$obj->ultimoProfesorTitular)
									{
										$compCambioHorario.='"fechaProfesorOriginal":"'.$arrProfesores[$nPos][7].'",';
										$arrProfesores[$nPos][7]=$obj->fechaFin;
										$encProfesor=true;
										break;	
									}
								}
								if(!$encProfesor)
								{
									$query="SELECT fechaBaja FROM 4519_asignacionProfesorGrupo WHERE idAsignacionProfesorGrupo=".$obj->ultimoProfesorTitular;	
									$fBajaTemp=$con->obtenerValor($query);
									if($fBajaTemp!="")
										$compCambioHorario.='"fechaProfesorOriginal":"'.$fBajaTemp.'",';
								}
							}
							else
							{
								
								$obj->ajustarProfesorTitular=0;
								$obj->ultimoProfesorTitular=0;
							}
						}
						else
						{
							for($nPos=0;$nPos<sizeof($arrProfesores);$nPos++)
							{
								if($arrProfesores[$nPos][9]==($obj->ultimoProfesorTitular*-1))
								{
									$compCambioHorario.='"fechaProfesorOriginal":"'.$arrProfesores[$nPos][7].'",';
									$arrProfesores[$nPos][7]=$obj->fechaFin;
									break;	
								}
							}
						}

						$compCambioHorario.='"ultimoProfesorTitular":"'.$obj->ultimoProfesorTitular.'","ajustarProfesorTitular":"'.$obj->ajustarProfesorTitular.'",';
					}
				}
				
				
				foreach($obj->arrHorario as $h)
				{
					$dia=$h->dia;
					$horaInicial=$h->horaInicial;
					$horaFinal=$h->horaFinal;
					$idAula=$h->idAula;
					
					
					if(sizeof($arrProfesores)>0)
					{
						foreach($arrProfesores as $p )
						{
							if($p[5]==2)
								continue;
							$idProfesor=$p[5];
							$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}
							if(colisionaTiempo($p[6],$p[7],$obj->fechaInicio,$obj->fechaFin,true))
							{
								$periodoInicio=$obj->fechaInicio;
								if(strtotime($p[6])>strtotime($periodoInicio))
									$periodoInicio=$p[6];
								
								
								$periodoFin=$obj->fechaFin;
								if(strtotime($p[7])<strtotime($periodoFin))
									$periodoFin=$p[7];
								
								
								$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$periodoInicio,$periodoFin,-1,$idGrupo,$obj->idSolicitudAME);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
							}
						}
					}
					
					$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal,$obj->fechaInicio,$obj->fechaFin,$obj->idSolicitudAME);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
	
					$resultado=validarHorarioAulaV2($idAula,$horaInicial,$horaFinal,$dia,$obj->fechaInicio,$obj->fechaFin,-1,$idGrupo,$obj->idSolicitudAME);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$horaInicial,$horaFinal,$obj->fechaInicio,$obj->fechaFin,-1,$obj->idSolicitudAME);
					
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarColisionRecesoV2($idGrupo,$dia,$horaInicial,$horaFinal);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
				}
			}

			if(isset($obj->datosSolicitud)&&($obj->datosSolicitud!=""))
				$datosSolicitud=bD($obj->datosSolicitud);
			else
			{
				$datosSolicitud='{'.$compCambioHorario.'"recalcularFechaTermino":"'.$obj->recalcularFechaTermino.'","validarFechaFinBloque":"'.$obj->validarFechaFinBloque.'","bloque":"'.$obj->noBloque.
						'","fechaAplicacion":"'.$obj->fechaInicio.'","fechaTermino":"'.$obj->fechaFin.'","motivo":"'.cv(str_replace('"','\"',$obj->motivo)).
						'","horarioAnt":['.$cadHorarioAnt.'],"horarioCambio":['.$cadHorario.']}';
			}
		break;
		case 7:	//Intercambio de curso
			if($obj->validar==1)
			{
				foreach($obj->arrCambios as $oCambio)
				{
					
					for($nGrupo=1;$nGrupo<=2;$nGrupo++)
					{
						$idGrupo=0;
						$idDestino=0;
						$idProfesor=0;
						if($nGrupo==1)
						{
							$idGrupo=$oCambio->origen;
							$idProfesor=$oCambio->idProfesorOrigen;
							$idDestino=$oCambio->destino;

						}
						else
						{
							$idGrupo=$oCambio->destino;
							$idProfesor=$oCambio->idProfesorDestino;
							$idDestino=$oCambio->origen;
						}
						$query="SELECT fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$idGrupo;
						$fOrigen=$con->obtenerPrimeraFila($query);
						$query="SELECT fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$idDestino;
						$fDestino=$con->obtenerPrimeraFila($query);
						$fechaInicio=$fDestino[0];
						$fechaFin=$fDestino[1];
						$query="SELECT dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idDestino;
						$resHorario=$con->obtenerFilas($query);
						$aHorario=array();
						while($filaHorario=mysql_fetch_row($resHorario))
						{
							$oHorario[0]=$filaHorario[0];
							$oHorario[1]=$filaHorario[1];
							$oHorario[2]=$filaHorario[2];
							$oHorario[3]=$filaHorario[3];
							array_push($aHorario,$oHorario);
						}
						$arrProfesores=array();
						if($idProfesor!=0)
						{
							array_push($arrProfesores,$idProfesor);
						}
						/*$consulta="SELECT idUsuario FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." AND participacionPrincipal=1 AND fechaAsignacion<fechaBaja order by fechaAsignacion";
						$iUsr=$con->obtenerValor($consulta);
						if($iUsr!="")*/
							
						foreach($aHorario as $h)
						{
							$dia=$h[0];
							$horaInicial=$h[1];
							$horaFinal=$h[2];
							$idAula=$h[3];
							
							
							if(sizeof($arrProfesores)>0)
							{
								foreach($arrProfesores as $p )
								{
									$idProfesor=$p;
									$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
									$objResp=json_decode($resultado);
									if($objResp->noError!=0)
									{
										array_push($arrIncidencias,$objResp);
									}
									
									
									
									
									
									$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,-1,$idGrupo,$obj->idSolicitudAME,$idDestino);
									$objResp=json_decode($resultado);
									if($objResp->noError!=0)
									{
										array_push($arrIncidencias,$objResp);
									}
									
								}
							}
							
							$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$obj->idSolicitudAME,-1,$idDestino);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}
			
							/*$resultado=validarHorarioAulaV2($idAula,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,-1,$idGrupo);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}*/
							
							$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$idDestino,$obj->idSolicitudAME);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}
							
							$resultado=validarColisionRecesoV2($idGrupo,$dia,$horaInicial,$horaFinal);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}
							
							$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal);
							$objResp=json_decode($resultado);
							if($objResp->noError!=0)
							{
								array_push($arrIncidencias,$objResp);
							}
						}	
							//--

					}
				}
			}
			if(isset($obj->datosSolicitud)&&($obj->datosSolicitud!=""))
				$datosSolicitud=bD($obj->datosSolicitud);
			else
			{
				$arrCambios="";
				
				foreach($obj->arrCambios as $oCambio)
				{
					
					for($nGrupo=1;$nGrupo<=2;$nGrupo++)
					{
						$idGrupo=0;
						$idDestino=0;
						$idProfesor=0;
						$idProfesorO=0;
						if($nGrupo==1)
						{
							$idGrupo=$oCambio->origen;
							$idProfesor=$oCambio->idProfesorOrigen;
							$idDestino=$oCambio->destino;
							$idProfesorO=$oCambio->idProfesorOrigenAsignado;

						}
						else
						{
							
							$idGrupo=$oCambio->destino;
							$idProfesor=$oCambio->idProfesorDestino;
							$idProfesorO=$oCambio->idProfesorDestinoAsignado;
							$idDestino=$oCambio->origen;
							
						}
						if($listGruposInvolucrados=="")
							$listGruposInvolucrados=$idGrupo;
						else
							$listGruposInvolucrados.=",".$idGrupo;
						$query="SELECT fechaInicio,fechaFin,noBloqueAsociado FROM 4520_grupos WHERE idGrupos=".$idGrupo;
						$fOrigen=$con->obtenerPrimeraFila($query);
						$query="SELECT fechaInicio,fechaFin,noBloqueAsociado FROM 4520_grupos WHERE idGrupos=".$idDestino;
						$fDestino=$con->obtenerPrimeraFila($query);
						$arrHorarioO="";
						$query="SELECT dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." ORDER BY fechaInicio,dia,horaInicio";
						$res=$con->obtenerFilas($query);
						while($filaH=mysql_fetch_row($res))
						{
							$h='{"dia":"'.$filaH[0].'","hInicio":"'.$filaH[1].'","hFin":"'.$filaH[2].'","idAula":"'.$filaH[3].'","fInicio":"'.$filaH[4].'","fFIn":"'.$filaH[5].'"}';
							if($arrHorarioO=="")
								$arrHorarioO=$h;
							else
								$arrHorarioO.=",".$h;
						}
						$arrHorarioC="";
						$query="SELECT dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$idDestino." ORDER BY fechaInicio,dia,horaInicio";
						$res=$con->obtenerFilas($query);
						while($filaH=mysql_fetch_row($res))
						{
							$h='{"dia":"'.$filaH[0].'","hInicio":"'.$filaH[1].'","hFin":"'.$filaH[2].'","idAula":"'.$filaH[3].'","fInicio":"'.$filaH[4].'","fFIn":"'.$filaH[5].'"}';
							if($arrHorarioC=="")
								$arrHorarioC=$h;
							else
								$arrHorarioC.=",".$h;
						}
						$obCambio='{"idGrupo":"'.$idGrupo.'","idGrupoCambio":"'.$idDestino.'","fechaInicioO":"'.$fOrigen[0].'","fechaFinO":"'.$fOrigen[1].'","noBloqueO":"'.$fOrigen[2].'","fechaInicioC":"'.$fDestino[0].'","fechaFinC":"'.$fDestino[1].'","noBloqueC":"'.$fDestino[2].'",'.
								'"idProfesorO":"'.$idProfesorO.'","idProfesorC":"'.$idProfesor.'","arrHorarioO":['.$arrHorarioO.'],"arrHorarioC":['.$arrHorarioC.']}';
						if($arrCambios=="")
							$arrCambios=$obCambio;
						else
							$arrCambios.=",".$obCambio;
					}
				}
				
				$datosSolicitud='{"idGruposInvolucrados":"'.$listGruposInvolucrados.'","motivo":"'.cv(str_replace('"','\"',$obj->motivo)).'","arrCambios":['.$arrCambios.']}';
			}
		break;
	}
	
	if(sizeof($arrIncidencias)>0)
	{
		echo "1|".generarResolucionArregloErrores($arrIncidencias,2)."|".bE($datosSolicitud);
		return;
	}

	$idComprobante=$obj->idDocumento;
	if($idComprobante!=-1)
		$idComprobante=registrarDocumentoServidor($obj->idDocumento,$obj->nombreDocumento);
		
	$consulta[$x]="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,tipoSolicitud,datosSolicitud,idAsignacion,idSolicitudAME,comentarios,idComprobante,complementario1,situacion)
					VALUES('".date("Y-m-d H:i:s")."',".$obj->tipoMovimiento.",'".$datosSolicitud."',".$idAsignacion.",@idRegistro,'".cv($obj->comentarios)."',".$idComprobante.",'".$complementario1."',1)";
	$x++;		
		
	$consulta[$x]="set @idRegistroMovimiento:=(select last_insert_id())";
	$x++;
	$oDatos=json_decode($datosSolicitud);
	
	if(isset($oDatos->idGruposInvolucrados))				
	{
		
		$arrGrupos=explode(",",$oDatos->idGruposInvolucrados);
		foreach($arrGrupos as $g)
		{
			$consulta[$x]="INSERT INTO 4548_gruposSolicitudesMovimiento(idSolicitud,idGrupo) VALUES(@idRegistroMovimiento,".$g.")";
			$x++;
		}
	}
	else
	{
		$consulta[$x]="INSERT INTO 4548_gruposSolicitudesMovimiento(idSolicitud,idGrupo) VALUES(@idRegistroMovimiento,".$obj->idGrupo.")";
		$x++;
	}
	if(($obj->tipoMovimiento==2)||($obj->tipoMovimiento==5))
	{
		if(sizeof($obj->arrBajas)>0)
		{
			foreach($obj->arrBajas as $b)	
			{
				$datosSolicitudAux='{"fechaBaja":"'.$b->fechaBaja.'"}';
				$consulta[$x]="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,tipoSolicitud,datosSolicitud,idAsignacion,idSolicitudAME,comentarios,idComprobante,complementario1,situacion)
							VALUES('".date("Y-m-d H:i:s")."',".$b->tipoMovimiento.",'".$datosSolicitudAux."',".$b->idAsignacion.",@idRegistro,'".cv($b->comentarios)."',".$idComprobante.",'".$complementario1."',1)";
				$x++;	
				$consulta[$x]="set @idRegistroMovimientoAux:=(select last_insert_id())";
				$x++;
				$consulta[$x]="INSERT INTO 4548_gruposSolicitudesMovimiento(idSolicitud,idGrupo) VALUES(@idRegistroMovimientoAux,".$b->idGrupo.")";
				$x++;
			}
		}
	}
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		$query="select @idRegistro";
		$idRegistro=$con->obtenerValor($query);
		if($obj->idSolicitudAME==-1)
		{

			if(isset($obj->configuracion)&&($obj->configuracion!=-1))
			{
				cambiarValorObjParametros($obj->configuracion,"idSolicitud",$idRegistro);
			}
		}
		
		echo '1|{"permiteContinuar":"1","arrErrores":[],"idRegistro":"'.$idRegistro.'","folio":"'.$folio.'"}';
	}
	
}


function obtenerSolicitudesAMES()
{
	global $con;
	$numReg=0;
	$cadObj="";
	$idGrupo=$_POST["idGrupo"];
	$situacion=$_POST["situacion"];
	$consulta="
				SELECT distinct c.idSolicitudAME,idResponsable,fechaRegistro,c.fechaDictamen,idResponsableDictamen,c.resultadoDictamen,c.comentariosDictamen,
				folioSolicitud,fechaEnvioAutorizacion,c.situacion,c.comentarios,g.idGrupo FROM 4549_cabeceraSolicitudAME c,4548_gruposSolicitudesMovimiento g,
				4548_solicitudesMovimientoGrupo s WHERE g.idGrupo=".$idGrupo." 
				and c.idSolicitudAME=s.idSolicitudAME and s.idSolicitudMovimiento=g.idSolicitud and c.situacion in (".$situacion.")
				ORDER BY folioSolicitud";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$responsable="";
		if($fila[1]!="")
		{
			$responsable=obtenerNombreUsuarioPaterno($fila[1]);
		}
		$responsableDictamen="";
		if($fila[4]!="")
		{
			$responsableDictamen=obtenerNombreUsuario($fila[4]);
		}
		$descSolicitud="";
		$compAux="";
		/*if($fila[11]!=$idGrupo)
		{
			$compAux=" where idMovimientoAME=7";
		}*/
		/*$consulta="SELECT idMovimientoAME,nombreMovimiento FROM 4587_tiposMovimientoAME ".$compAux." ORDER BY prioridadResumen asc";
		$resMov=$con->obtenerFilas($consulta);
		while($fMov=mysql_fetch_row($resMov))
		{*/
			
		$consulta="SELECT s.* FROM  4548_solicitudesMovimientoGrupo s,4548_gruposSolicitudesMovimiento g WHERE idSolicitudAME=".$fila[0]." and s.idSolicitudMovimiento=g.idSolicitud and g.idGrupo=".$idGrupo."   ORDER BY idSolicitudMovimiento";
		$resSol=$con->obtenerFilas($consulta);
		while($fSol=mysql_fetch_row($resSol))
		{
			switch($fSol[2])
			{
				case 1:
				case 3:
					$descSolicitud.=formatearSolicitudAltaSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
				break;
				case 2:
				case 5:
					$descSolicitud.=formatearSolicitudBajaFinalizacionSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					
				break;
				case 4:
				case 6:
					$descSolicitud.=formatearSolicitudCambioHorarioFecha($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
				break;
				case 7:
					$descSolicitud.=formatearSolicitudIntercambioCurso($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					
				break;
			}
		}
		//}
		$consulta="SELECT nombreGrupo,m.nombreMateria,g.fechaInicio,g.fechaFin FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		
		$obj='{"grupoBase":"['.$fGrupo[0].'] '.$fGrupo[1].'","fInicioGrupo":"'.$fGrupo[2].'","fFinGrupo":"'.$fGrupo[3].'","idGrupoMovimiento":"'.$fila[11].'","idSolicitudMovimiento":"'.$fila[0].'","responsableSolicitud":"'.$responsable.'","fechaSolicitud":"'.$fila[2].'","fechaRespuesta":"'.$fila[3].
				'","responsableRespuesta":"'.$responsableDictamen.'","dictamen":"'.$fila[5].'","comentariosDictamen":"'.cv($fila[6]).'","descSolicitud":"'.$descSolicitud.'","folio":"'.
				$fila[7].'","fechaEnvioAutorizacion":"'.$fila[8].'","situacion":"'.$fila[9].'","comentariosAdicionales":"'.cv($fila[10]).'"}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$cadObj.']}';
}

function obtenerDetallesSolicitudAMES()
{
	global $con;
	$numReg=0;
	$cadObj="";
	$lblGrupos="";
	$idSolicitud=$_POST["idSolicitud"];
	$complementario="";
	$consulta="SELECT * FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudAME=".$idSolicitud." order by idSolicitudMovimiento";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT CONCAT('(',nombreGrupo,') ',m.nombreMateria) FROM 4520_grupos g,4502_Materias m WHERE idGrupos IN (SELECT idGrupo FROM 4548_gruposSolicitudesMovimiento WHERE idSolicitud=".$fila[0].")
				AND m.idMateria=g.idMateria";
		$lblGrupos=$con->obtenerListaValores($consulta);		
		$obj=json_decode($fila[3]);
		switch($fila[2])
		{
			case 1:
			case 3:
				$complementario=formatearSolicitudAltaSuplencia($fila);
			break;
			case 2:
			case 5:
				$complementario=formatearSolicitudBajaFinalizacionSuplencia($fila);
				
			break;
			case 4:
			case 6:
				$complementario=formatearSolicitudCambioHorarioFecha($fila);
			break;
			case 7:
				$complementario=formatearSolicitudIntercambioCurso($fila);
			break;
		}
		
		$obj='{"grupo":"'.$lblGrupos.'","idMovimiento":"'.$fila[0].'","tipoMovimiento":"'.$fila[2].'","comentariosAdicionales":"'.$fila[6].'","complementario":"'.$complementario.'","idComprobante":"'.$fila[9].'","datosSolicitud":"'.bE($fila[3]).'"}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$cadObj.']}';
}

function obtenerHorarioMateriaPeriodo()
{
	global $con;

	$idGrupo=$_POST["idGrupo"];
	$idSolicitud=$_POST["idSolicitud"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$arrHorario=obtenerFechasHorarioGrupoV2($idGrupo,$idSolicitud,true,true,$fechaInicio,$fechaFin);

	$fechaActual=date("Y-m-d");
	$arrFechas[0]="2011-06-05";
	$arrFechas[1]="2011-06-06";
	$arrFechas[2]="2011-06-07";
	$arrFechas[3]="2011-06-08";
	$arrFechas[4]="2011-06-09";
	$arrFechas[5]="2011-06-10";
	$arrFechas[6]="2011-06-11";

	$listHorarioGrupo="";
	
	$arrEvento="";
	$ct=0;
	foreach($arrHorario as $fila)
	{
		if($fila[2]==10)
			continue;
		$todoDia='false';	
		$fechaIni=$arrFechas[$fila[2]];	
		$tEvento=0;
		if($fila[0]!=0)
			$tEvento=1;
		else
			$tEvento=8;
		$comp="";
		
		$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fila[5];
		$nAula=$con->obtenerValor($consulta);
		if($nAula=="")
			$nAula="No especificado";

		if($fila[5]==-1)
			$comp="<img src='../images/exclamation.png' title='Esta sesi&oacute;n de clases no tiene asignada una aula' alt='Esta sesi&oacute;n de clases no tiene asignada una aula'>&nbsp;";
		$obj='	{
					  "id": "'.$ct.'",
					  "cid": "'.$tEvento.'",
					  "title": "Asignado '.$comp.' <br>Lugar: '.$nAula.'",
					  "start": "'.$fechaIni.' '.$fila[3].'",
					  "end": "'.$fechaIni.' '.$fila[4].'",
					  "ad": '.$todoDia.',
					  "rO":0,
					  "notes":"'.$fila[5].'"
				  }';
		if($arrEvento=="")
			$arrEvento=$obj;
		else
			$arrEvento.=",".$obj;	
		$ct++;
	}
	
	echo '{"evts":['.$arrEvento.']}';
}

function obtenerAsignacionesDisponiblesBaja()
{
	global $con;
	$idSolicitud=$_POST["idSolicitud"];
	$idGrupo=$_POST["idGrupo"];
	$tipoMovimiento=$_POST["tipoMovimiento"];
	$tMovimiento=0;
	switch($tipoMovimiento)
	{
		case 2:
			$tMovimiento=1;
			$consulta="SELECT count(*) FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE 
				 c.idSolicitudAME= s.idSolicitudAME and c.idGrupo=".$idGrupo." AND s.situacion in(1,2) and s.tipoSolicitud=1 and c.idSolicitudAME=".$idSolicitud." ORDER BY idSolicitudMovimiento"; 
								
			$nRegistros=$con->obtenerValor($consulta);
			if($nRegistros>0)
			{
				echo "<br><br>-- Existe un movimiento de baja activo (En situaci&oacute;n de diseño &oacute; en espera de autorizaci&oacute;n)<br>-- Existe un movimiento de alta dentro de la actual solicitud";
				return;
			}
			else
			{
				$consulta="SELECT count(*) FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE 
				 c.idSolicitudAME= s.idSolicitudAME and c.idGrupo=".$idGrupo." AND s.situacion in(1,2) and s.tipoSolicitud=2 and c.idSolicitudAME<>".$idSolicitud." ORDER BY idSolicitudMovimiento"; 
		
				$nRegistros=$con->obtenerValor($consulta);
				if($nRegistros>0)
				{
					echo "<br><br>-- Existe un movimiento de baja activo (En situaci&oacute;n de diseño &oacute; en espera de autorizaci&oacute;n)<br>-- Existe un movimiento de alta dentro de la actual solicitud";
					return;
				}
			}
		break;
		case 5:
			$tMovimiento=3;
			$consulta="SELECT count(*) FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE 
				 c.idSolicitudAME= s.idSolicitudAME and    c.idGrupo=".$idGrupo." AND s.situacion in(1,2) and s.tipoSolicitud=3 and c.idSolicitudAME=".$idSolicitud." ORDER BY idSolicitudMovimiento"; 
								
			$nRegistros=$con->obtenerValor($consulta);
			if($nRegistros>0)
			{
				echo "<br><br>-- Existe un movimiento de finalización de suplencia activo (En situaci&oacute;n de diseño &oacute; en espera de autorizaci&oacute;n)<br>-- Existe un movimiento de asignación de suplencia dentro de la actual solicitud";
				return;
			}
			else
			{
				$consulta="SELECT count(*) FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE 
				 c.idSolicitudAME= s.idSolicitudAME and    c.idGrupo=".$idGrupo." AND s.situacion in(1,2) and s.tipoSolicitud=5 and c.idSolicitudAME<>".$idSolicitud." ORDER BY idSolicitudMovimiento"; 
								
				$nRegistros=$con->obtenerValor($consulta);
				if($nRegistros>0)
				{
					echo "<br><br>-- Existe un movimiento de finalización de suplencia activo (En situaci&oacute;n de diseño &oacute; en espera de autorizaci&oacute;n)<br>-- Existe un movimiento de asignación de suplencia dentro de la actual solicitud";
					return;
				}
			}
			
		break;
	}
	$obj="";
	$arrAsignaciones=obtenerFechasAsignacionGrupoV2($idGrupo,$idSolicitud,true,true,"","",$tMovimiento);
	if(sizeof($arrAsignaciones)>0)
	{
		$fValor=$arrAsignaciones[sizeof($arrAsignaciones)-1];
		$obj="['".$fValor[0]."','".cv(obtenerNombreUsuarioPaterno($fValor[5]))." (Del ".cambiarFormatoFecha($fValor[6])." al ".cambiarFormatoFecha($fValor[7]).")','".$fValor[6].",".$fValor[7]."']";
	}
	echo "1|[".$obj."]";
}

function modificarSituacionAME()
{
	global $con;
	$arrIncidencias=array();
	$situacionCambio=0;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	switch($obj->accion)
	{
		case 1:
			$consulta[$x]="UPDATE 4549_cabeceraSolicitudAME SET situacion=5,comentarios='".cv($obj->comentarios)."',fechaEnvioAutorizacion='".date("Y-m-d H:i:s")."' WHERE idSolicitudAME=".$obj->idSolicitud;
			$x++;
			$consulta[$x]="UPDATE 4548_solicitudesMovimientoGrupo SET situacion=5 WHERE idSolicitudAME=".$obj->idSolicitud;
			$x++;
			$situacionCambio=5;
		break;
		case 2:
			if($obj->validar==1)
			{
				/*$query="SELECT idGrupo FROM 4549_cabeceraSolicitudAME WHERE idSolicitudAME=".$obj->idSolicitud;
				$idGrupo=$con->obtenerValor($query);*/
				$query="SELECT DISTINCT idGrupo FROM 4548_gruposSolicitudesMovimiento g,4548_solicitudesMovimientoGrupo s WHERE idSolicitud=s.idSolicitudMovimiento AND idSolicitudAME=".$obj->idSolicitud." ";
				$resAuxGpo=$con->obtenerFilas($query);
				while($fAuxGpo=mysql_fetch_row($resAuxGpo))
				{
					$idGrupo=$fAuxGpo[0];
				
					$query="SELECT idCiclo,idPeriodo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
					$fGrupo=$con->obtenerPrimeraFila($query);
					$idCiclo=$fGrupo[0];
					$idPeriodo=$fGrupo[1];
					$idInstancia=$fGrupo[2];
					
					$resultado=validarHorarioNulo($idGrupo,$obj->idSolicitud);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarHorarioIncompletoDuracionCurso($idGrupo,$obj->idSolicitud);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$duracionHora=obtenenerDuracionHoraGrupo($idGrupo);
					
					
					$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($idGrupo,$obj->idSolicitud,true,false);
					if(sizeof($arrHorarioGrupo)==0)
					{
						$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($idGrupo,$obj->idSolicitud,true,true);
					}

					$idGrupoIntercambio=-1;
					$query="SELECT datosSolicitud FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE c.idSolicitudAME=".$obj->idSolicitud."  and c.idSolicitudAME= s.idSolicitudAME and   tipoSolicitud =7 
							AND c.idGrupo=".$idGrupo." AND s.situacion in(1,2) ORDER BY idSolicitudMovimiento"; 
					$fIntercambio=$con->obtenerPrimeraFila($query);
					if($fIntercambio)
					{
						$objDatosTmp=json_decode($fIntercambio[0]);
						foreach($objDatosTmp->arrCambios as $oGrupo)
						{
							if($oGrupo->idGrupo==$idGrupo)
							{	
								$idGrupoIntercambio=$oGrupo->idGrupoCambio;
							}
						}
					}
					
					

					if(sizeof($arrHorarioGrupo)>0)
					{
						foreach($arrHorarioGrupo as $h)
						{
							$dia=$h[2];
							$horaInicial=$h[3];
							$horaFinal=$h[4];
							$idAula=$h[5];
							$fechaInicio=$h[6];
							$fechaFin=$h[7];
							
							if((existeAsignacionSolicitudAME($idGrupo,$obj->idSolicitud))||(existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud)))
							{
								$arrProfesores=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitud,true,true,$fechaInicio,$fechaFin,0,true);
								
								$aTemp=array();
								if(sizeof($arrProfesores)>0)
								{
									foreach($arrProfesores as $p)
									{
										
										if($p[8]!=45)
											array_push($aTemp,$p);	
									}
									$arrProfesores=$aTemp;
									
								}
								
								
								$arrProfesores=normalizarFechasAsignacionProfesores($arrProfesores,$idGrupo,$obj->idSolicitud);
								
								$arrSuplentes=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitud,true,true,$fechaInicio,$fechaFin,3);
								
								if(!existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud))
								{
									$arrProfesores=obtenerUsuarioAsignacionAME($idGrupo,$obj->idSolicitud);
									
									$arrSuplentes=array();
								}
								
								
								if(sizeof($arrProfesores)>0)
								{
									foreach($arrProfesores as $p )
									{
										if($p[5]==2)
											continue;
										if(colisionaTiempo($p[6],$p[7],$fechaInicio,$fechaFin,true))
										{
											
											
											$idProfesor=$p[5];
											if($p[0]==0)
											{
												$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia,$idGrupo);
												$objResp=json_decode($resultado);
												if($objResp->noError!=0)
												{
													
													array_push($arrIncidencias,$objResp);
												}
											}
											
											$periodoInicio=$fechaInicio;
											if(strtotime($p[6])>strtotime($periodoInicio))
												$periodoInicio=$p[6];
											
											
											$periodoFin=$fechaFin;
											if(strtotime($p[7])<strtotime($periodoFin))
												$periodoFin=$p[7];
	
											$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$periodoInicio,$periodoFin,-1,$idGrupo,$obj->idSolicitud);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												
												array_push($arrIncidencias,$objResp);
											}
										}
									}
								}

								if(sizeof($arrSuplentes)>0)
								{
									foreach($arrSuplentes as $p )
									{
										if($p[5]==2)
											continue;
										if(colisionaTiempo($p[6],$p[7],$fechaInicio,$fechaFin,true))
										{
											$idProfesor=$p[5];
											if($p[0]==0)
											{
												$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
												$objResp=json_decode($resultado);
												if($objResp->noError!=0)
												{
													
													array_push($arrIncidencias,$objResp);
												}
											}
											
											$periodoInicio=$fechaInicio;
											if(strtotime($p[6])>strtotime($periodoInicio))
												$periodoInicio=$p[6];
											
											
											$periodoFin=$fechaFin;
											if(strtotime($p[7])<strtotime($periodoFin))
												$periodoFin=$p[7];
											
											$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$periodoInicio,$periodoFin,-1,$idGrupo,$obj->idSolicitud);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												array_push($arrIncidencias,$objResp);
											}
										}
									}
								}
								
							}
							
							if((existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud))&&($h[0]==0))
							{
								$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
				
								$resultado=validarHorarioAulaV2($idAula,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,-1,$idGrupo,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
								$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$idGrupoIntercambio,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
								$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
							}
						}
					}
					
					
				}
			}

			if(sizeof($arrIncidencias)>0)
			{
				echo "1|".generarResolucionArregloErrores($arrIncidencias,3)."|";
				return;
			}

			$consulta[$x]="UPDATE 4549_cabeceraSolicitudAME SET situacion=2,comentarios='".cv($obj->comentarios)."',fechaEnvioAutorizacion='".date("Y-m-d H:i:s")."' WHERE idSolicitudAME=".$obj->idSolicitud;
			$x++;
			$consulta[$x]="UPDATE 4548_solicitudesMovimientoGrupo SET situacion=2 WHERE idSolicitudAME=".$obj->idSolicitud;
			$x++;
			$situacionCambio=2;
			
		break;
		
	}
	$consulta[$x]="commit";
	$x++;

	if(($con->ejecutarBloque($consulta))&&(generarReporteAME($obj->idSolicitud)))
	{
		registrarCambioSituacionCabeceraAME($obj->idSolicitud,$situacionCambio);
		echo '1|{"permiteContinuar":"1","arrErrores":[]}';
	}
		
}

function removerMovimientoSolicitud()
{
	global $con;
	$idMovimiento=$_POST["idMovimiento"];
	$consulta="SELECT idComprobante FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$idMovimiento;
	$idDocumento=$con->obtenerValor($consulta);
	if($idDocumento=="")
		$idDocumento=-1;
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="DELETE FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudMovimiento=".$idMovimiento;
	$x++;
	$query[$x]="DELETE FROM 4548_gruposSolicitudesMovimiento WHERE idSolicitud=".$idMovimiento;
	$x++;
	$query[$x]="commit";
	$x++;
	if($con->ejecutarBloque($query))
	{
		if($idDocumento!=-1)
		{
			removerDocumentoServidor($idDocumento);
		}
		echo "1|";
	}
}

function obtenerSolicitudesAMESEsperaAutorizacion()
{
	global $con;
	$numReg=0;
	$cadObj="";
	$situacion=$_POST["situacion"];
	$consulta="SELECT idSolicitudAME,idResponsable,fechaRegistro,fechaDictamen,idResponsableDictamen,resultadoDictamen,comentariosDictamen,
				folioSolicitud,fechaEnvioAutorizacion,s.situacion,comentarios,Plantel,idInstanciaPlanEstudio,idGrupos,g.nombreGrupo FROM 4549_cabeceraSolicitudAME s,4520_grupos g 
				WHERE  g.idGrupos=s.idGrupo and s.situacion in (".$situacion.") ORDER BY folioSolicitud";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$responsable="";
		if($fila[1]!="")
		{
			$responsable=obtenerNombreUsuarioPaterno($fila[1]);
		}
		$responsableDictamen="";
		if($fila[4]!="")
		{
			$responsableDictamen=obtenerNombreUsuarioPaterno($fila[4]);
		}
		$descSolicitud="";
		$consulta="SELECT idMovimientoAME,nombreMovimiento FROM 4587_tiposMovimientoAME ORDER BY prioridadResumen asc";
		$resMov=$con->obtenerFilas($consulta);
		while($fMov=mysql_fetch_row($resMov))
		{
			$consulta="SELECT * FROM  4548_solicitudesMovimientoGrupo WHERE idSolicitudAME=".$fila[0]." AND tipoSolicitud=".$fMov[0]."  ORDER BY idSolicitudMovimiento";
			$resSol=$con->obtenerFilas($consulta);
			while($fSol=mysql_fetch_row($resSol))
			{
				switch($fSol[2])
				{
					case 1:
					case 3:
						$descSolicitud.=formatearSolicitudAltaSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					break;
					case 2:
					case 5:
						$descSolicitud.=formatearSolicitudBajaFinalizacionSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
						
					break;
					case 4:
					case 6:
						$descSolicitud.=formatearSolicitudCambioHorarioFecha($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					break;
					case 7:
						$descSolicitud.=formatearSolicitudIntercambioCurso($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
						
					break;
				}
			}
		}
		$consulta="SELECT nombreGrupo,m.nombreMateria,g.fechaInicio,g.fechaFin FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fila[13];
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$obj='{"fInicioGrupo":"'.$fGrupo[2].'","fFinGrupo":"'.$fGrupo[3].'","fechaRespuesta":"'.$fila[3].'","responsableRespuesta":"'.$responsableDictamen.'","idSolicitudMovimiento":"'.$fila[0].'","responsableSolicitud":"'.$responsable.'","plantel":"'.$fila[11].'","planEstudios":"'.obtenerNombreInstanciaPlan($fila[12]).
				'","grupo":"('.$fGrupo[0].') '.$fGrupo[1].'","comentariosDictamen":"'.cv($fila[6]).'","descSolicitud":"'.$descSolicitud.'","folio":"'.
				$fila[7].'","fechaEnvioAutorizacion":"'.$fila[8].'","situacion":"'.$fila[9].'","comentariosAdicionales":"'.cv($fila[10]).'"}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$cadObj.']}';
}

function dictaminarSolicitudAmesV2()
{
	global $con;
	$arrIncidencias=array();
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$situacion=4;
	switch($obj->dictamen)
	{
		case 1:
			$situacion=3;
			if($obj->validar==1)
			{
				$query="SELECT idGrupo FROM 4549_cabeceraSolicitudAME WHERE idSolicitudAME=".$obj->idSolicitud;
				$idGrupo=$con->obtenerValor($query);
				
				$query="SELECT DISTINCT idGrupo FROM 4548_gruposSolicitudesMovimiento g,4548_solicitudesMovimientoGrupo s WHERE idSolicitud=s.idSolicitudMovimiento AND idSolicitudAME=".$obj->idSolicitud." ";
				$resAuxGpo=$con->obtenerFilas($query);
				while($fAuxGpo=mysql_fetch_row($resAuxGpo))
				{
					$idGrupo=$fAuxGpo[0];
				
					$query="SELECT idCiclo,idPeriodo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
					$fGrupo=$con->obtenerPrimeraFila($query);
					$idCiclo=$fGrupo[0];
					$idPeriodo=$fGrupo[1];
					$idInstancia=$fGrupo[2];
					
					
					$resultado=validarHorarioNulo($idGrupo,$obj->idSolicitud);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarHorarioIncompletoDuracionCurso($idGrupo,$obj->idSolicitud);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$duracionHora=obtenenerDuracionHoraGrupo($idGrupo);
					$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($idGrupo,$obj->idSolicitud,true,true);
	
					$idGrupoIntercambio=-1;
					$query="SELECT datosSolicitud FROM 4548_solicitudesMovimientoGrupo s,4549_cabeceraSolicitudAME c WHERE c.idSolicitudAME=".$obj->idSolicitud."  and c.idSolicitudAME= s.idSolicitudAME and   tipoSolicitud =7 
							AND c.idGrupo=".$idGrupo." AND s.situacion in(1,2) ORDER BY idSolicitudMovimiento"; 
					$fIntercambio=$con->obtenerPrimeraFila($query);
					if($fIntercambio)
					{
						$objDatosTmp=json_decode($fIntercambio[0]);
						foreach($objDatosTmp->arrCambios as $oGrupo)
						{
							if($oGrupo->idGrupo==$idGrupo)
							{	
								$idGrupoIntercambio=$oGrupo->idGrupoCambio;
							}
						}
					}
					if(sizeof($arrHorarioGrupo)>0)
					{
						foreach($arrHorarioGrupo as $h)
						{
							$dia=$h[2];
							$horaInicial=$h[3];
							$horaFinal=$h[4];
							$idAula=$h[5];
							$fechaInicio=$h[6];
							$fechaFin=$h[7];
							if((existeAsignacionSolicitudAME($idGrupo,$obj->idSolicitud))||(existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud)))
							{
								
								$arrProfesores=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitud,true,true,$fechaInicio,$fechaFin,0,true);
								$aTemp=array();
								if(sizeof($arrProfesores)>0)
								{
									foreach($arrProfesores as $p)
									{
										
										if($p[8]!=45)
											array_push($aTemp,$p);	
									}
									$arrProfesores=$aTemp;
									
								}
								
								$arrProfesores=normalizarFechasAsignacionProfesores($arrProfesores,$idGrupo,$obj->idSolicitud);

								$arrSuplentes=obtenerFechasAsignacionGrupoV2($idGrupo,$obj->idSolicitud,true,true,$fechaInicio,$fechaFin,3);
								if(!existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud))
								{
									$arrProfesores=obtenerUsuarioAsignacionAME($idGrupo,$obj->idSolicitud);
									$arrSuplentes=array();
								}
								
								if(sizeof($arrProfesores)>0)
								{
									foreach($arrProfesores as $p )
									{
										if($p[5]==2)
											continue;
										if(colisionaTiempo($p[6],$p[7],$fechaInicio,$fechaInicio,true))
										{
											$idProfesor=$p[5];
											if($p[0]==0)
											{
												$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
												$objResp=json_decode($resultado);
												if($objResp->noError!=0)
												{
													array_push($arrIncidencias,$objResp);
												}
											}
											
											$periodoInicio=$fechaInicio;
											if(strtotime($p[6])>strtotime($periodoInicio))
												$periodoInicio=$p[6];											
											
											$periodoFin=$fechaFin;
											if(strtotime($p[7])<strtotime($periodoFin))
												$periodoFin=$p[7];
											
											$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$periodoInicio,$periodoFin,-1,$idGrupo,$obj->idSolicitud);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												array_push($arrIncidencias,$objResp);
											}
										}
									}
								}
								if(sizeof($arrSuplentes)>0)
								{
									foreach($arrSuplentes as $p )
									{
										if($p[5]==2)
											continue;
										if(colisionaTiempo($p[6],$p[7],$fechaInicio,$fechaFin,true))
										{
											$idProfesor=$p[5];
											if($p[0]==0)
											{
												$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
												$objResp=json_decode($resultado);
												if($objResp->noError!=0)
												{
													array_push($arrIncidencias,$objResp);
												}
											}
											$periodoInicio=$fechaInicio;
											if(strtotime($p[6])>strtotime($periodoInicio))
												$periodoInicio=$p[6];
											
											
											$periodoFin=$fechaFin;
											if(strtotime($p[7])<strtotime($periodoFin))
												$periodoFin=$p[7];
												
											$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$periodoInicio,$periodoFin,-1,$idGrupo,$obj->idSolicitud);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												array_push($arrIncidencias,$objResp);
											}
										}
									}
								}
								
							}
							if((existeCambioFechaHorarioSolicitudAME($idGrupo,$obj->idSolicitud))&&($h[0]==0))
							{
								$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
				
								$resultado=validarHorarioAulaV2($idAula,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,-1,$idGrupo,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
								$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin,$idGrupoIntercambio,$obj->idSolicitud);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
								
								$resultado=validarColisionRecesoV2($idGrupo,$dia,$horaInicial,$horaFinal);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
								
								$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupo,$dia,$horaInicial,$horaFinal);
								$objResp=json_decode($resultado);
								if($objResp->noError!=0)
								{
									array_push($arrIncidencias,$objResp);
								}
							}
							
							
						}
					}
					
					/*$query="SELECT datosSolicitud FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudAME=".$obj->idSolicitud." AND tipoSolicitud=7";
					$cadTemp=$con->obtenerValor($query);
					if($cadTemp!="")
					{
						$objTemp=json_decode($cadTemp);
						
						foreach($objTemp->arrCambios as $oGrupo)
						{
							if($oGrupo->idGrupo!=$idGrupo)
							{
								$idGrupoAux=$oGrupo->idGrupo;
								$idProfesor=$oGrupo->idProfesorC;
								$fechaInicio=$oGrupo->fechaInicioC;
								$fechaFin=$oGrupo->fechaFinC;
								
								$aHorario=array();
								foreach($oGrupo->arrHorarioC as $filaHorario)
								{
									$oHorario[0]=$filaHorario->dia;
									$oHorario[1]=$filaHorario->hInicio;
									$oHorario[2]=$filaHorario->hFin;
									$oHorario[3]=$filaHorario->idAula;
									array_push($aHorario,$oHorario);
								}
								$arrProfesores=array();
								if($idProfesor!=0)
								{
									array_push($arrProfesores,$idProfesor);
								}
									
								foreach($aHorario as $h)
								{
									$dia=$h[0];
									$horaInicial=$h[1];
									$horaFinal=$h[2];
									$idAula=$h[3];
									
									if(sizeof($arrProfesores)>0)
									{
										foreach($arrProfesores as $p )
										{
											$idProfesor=$p;
											$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												array_push($arrIncidencias,$objResp);
											}
											
											$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$horaInicial,$horaFinal,$dia,$fechaInicio,$fechaFin,-1,$idGrupoAux);
											$objResp=json_decode($resultado);
											if($objResp->noError!=0)
											{
												array_push($arrIncidencias,$objResp);
											}
											
										}
									}
									
									$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupoAux,$dia,$horaInicial,$horaFinal,$fechaInicio,$fechaFin);
									$objResp=json_decode($resultado);
									if($objResp->noError!=0)
									{
										array_push($arrIncidencias,$objResp);
									}
									$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupoAux,$dia,$horaInicial,$horaFinal);
									$objResp=json_decode($resultado);
									if($objResp->noError!=0)
									{
										array_push($arrIncidencias,$objResp);
									}
								}	
							}
						}
					}*/
				}
			}
			
			if(sizeof($arrIncidencias)>0)
			{
				echo "1|".generarResolucionArregloErrores($arrIncidencias,4)."|";
				return;
			}
			
			$query="SELECT idSolicitudMovimiento,tipoSolicitud FROM 4548_solicitudesMovimientoGrupo WHERE idSolicitudAME=".$obj->idSolicitud." AND situacion=2 ORDER BY idSolicitudMovimiento";
			$resSolicitud=$con->obtenerFilas($query);
			while($filaSol=mysql_fetch_row($resSolicitud))
			{
				switch($filaSol[1])
				{
					case 1:
					case 3:
						if(!autorizarAltaSuplencia($filaSol[0]))
						{
							$query="INSERT INTO 4612_bitacoraErroresAME(idSolicitudMovimiento,fechaError) VALUES(".$filaSol[0].",'".date("Y-m-d H:i:s")."')";
							$con->ejecutarConsulta($query);
							return;
						}
						
					break;
					case 2:
					case 5:
						if(!autorizarBajaFinalizacion($filaSol[0]))
						{
							$query="INSERT INTO 4612_bitacoraErroresAME(idSolicitudMovimiento,fechaError) VALUES(".$filaSol[0].",'".date("Y-m-d H:i:s")."')";
							$con->ejecutarConsulta($query);
							return;
						}
						
					break;
					case 4:
					case 6:
						if(!autorizarCambioFechaHorario($filaSol[0]))
						{
							$query="INSERT INTO 4612_bitacoraErroresAME(idSolicitudMovimiento,fechaError) VALUES(".$filaSol[0].",'".date("Y-m-d H:i:s")."')";
							$con->ejecutarConsulta($query);
							return;
						}
						
					break;
					case 7:
						if(!autorizarIntercambioCurso($filaSol[0]))
						{
							$query="INSERT INTO 4612_bitacoraErroresAME(idSolicitudMovimiento,fechaError) VALUES(".$filaSol[0].",'".date("Y-m-d H:i:s")."')";
							$con->ejecutarConsulta($query);
							return;
						}
					break;
				}
			}
			
			
		break;
		case 2:
			$situacion=4;
			$consulta[$x]="UPDATE 4548_solicitudesMovimientoGrupo SET situacion=".$situacion." WHERE idSolicitudAME=".$obj->idSolicitud;
			$x++;
		break;
	}


	$consulta[$x]="UPDATE 4549_cabeceraSolicitudAME SET situacion=".$situacion.",comentariosDictamen='".cv($obj->comentarios)."',fechaDictamen='".date("Y-m-d H:i:s").
				"',idResponsableDictamen=".$_SESSION["idUsr"].",resultadoDictamen=".$obj->dictamen." WHERE idSolicitudAME=".$obj->idSolicitud;
	$x++;
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		registrarCambioSituacionCabeceraAME($obj->idSolicitud,$situacion);
		if($obj->dictamen==1)
		{
			actualizarFechaVoBoAME($obj->idSolicitud,date("d/m/Y"));	
		}
		echo '1|{"permiteContinuar":"1","arrErrores":[]}';
	}
		
}

function obtenerGruposBloques()
{
	global $con;
	global $arrDiasSemana;
	$arrNumGrupos=array();
	$arrGrupos=array();
	$idGrupo=$_POST["idGrupo"];
	$idSolicitud=$_POST["idSolicitud"];
	$consulta="SELECT idGradoCiclo,fechaInicio,fechaFin,idGrupoPadre FROM 4520_grupos WHERE idGrupos=".$idGrupo;
	$filaGrupo=$con->obtenerPrimeraFila($consulta);
	$idGradoCiclo=$filaGrupo[0];
	$idGrupoPadre=$filaGrupo[3];
	$consulta="select * from (SELECT idGrupos,noBloqueAsociado,(select horaInicio from 4522_horarioGrupo WHERE idGrupo=g.idGrupos order by dia,horaInicio limit 0,1) as horario 
				FROM 4520_grupos g WHERE idGrupoPadre=".$idGrupoPadre.")
				as tmp ORDER BY noBloqueAsociado,horario";
	$resGrupos=$con->obtenerFilas($consulta);	
	while($fila=mysql_fetch_row($resGrupos))
	{
		if($fila[1]=="")
			$fila[1]=0;
		
		
		$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE idGrupoReemplaza=".$fila[0];
		$idGrupoAux=$con->obtenerValor($consulta);
		if($idGrupoAux!="")
		{
			$fila[0]=$idGrupoAux;
			if($fila[1]==0)
			{
				$consulta="select noBloqueAsociado from 4520_grupos where idGrupos=".$idGrupoAux;
				$fila[1]=$con->obtenerValor($consulta);
				if($fila[1]=="")
					$fila[1]=0;
			}
			
		}
		if(!isset($arrGrupos[$fila[1]]))
		{
			$arrGrupos[$fila[1]]=array();
			$arrNumGrupos[$fila[1]]=0;
		}	
			
			
		array_push($arrGrupos[$fila[1]],$fila[0]);	
		$arrNumGrupos[$fila[1]]++;
	}
	
	$numGrupos=0;
	
	foreach($arrNumGrupos as $nGrupo)
	{
		if($nGrupo>$numGrupos)
			$numGrupos=$nGrupo;
	}
	$numReg=0;
	$cadFinal='';
	for($x=0;$x<$numGrupos;$x++)
	{
		$nBloque=1;
		$cadFila='';
		foreach($arrGrupos as $nBloque=>$resto)
		{
			$idGrupoTmp=0;
			if(isset($arrGrupos[$nBloque][$x]))
				$idGrupoTmp=$arrGrupos[$nBloque][$x];
			$lblGrupo=$idGrupoTmp;
			$horario="";
			$fGrupo=array();
			if($idGrupoTmp!=0)
			{
				$consulta="SELECT nombreGrupo,m.nombreMateria FROM 4520_grupos g,4502_Materias m WHERE idGrupos=".$idGrupoTmp." AND m.idMateria=g.idMateria";
				$fGrupo=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT * FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupoTmp." ORDER BY dia,horaInicio";
				$resHorario=$con->obtenerFilas($consulta);
				while($fHorario=mysql_fetch_row($resHorario))
				{
					$h=utf8_encode(substr($arrDiasSemana[$fHorario[2]],0,3)).". de ".date("H:i",strtotime($fHorario[3]))." hrs. a ".date("H:i",strtotime($fHorario[4]))." hrs.";
					if($horario=="")
					{
						$horario=$h;
					}
					else
					{
						$horario.=", ".$h;
					}
				}
				if($horario=="")
					$horario="Sin horario asignado";
			}
			else
			{
				$fGrupo[0]="Sin asignación";
				$fGrupo[1]="Vacante";
			}
			$iUsr="0";
			$nombreProfesor="";	
			
			$tieneAME="0";
			if($idGrupo!=$idGrupoTmp)
			{
				$consulta="SELECT idUsuario FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupoTmp." AND participacionPrincipal=1 AND fechaAsignacion<fechaBaja order by fechaAsignacion";
				$iUsr=$con->obtenerValor($consulta);
				if($iUsr=="")
					$iUsr=0;
				else
				{
					$nombreProfesor=cv(obtenerNombreUsuarioPaterno($iUsr));
				}
				$consulta="SELECT idSolicitud  FROM 4548_gruposSolicitudesMovimiento g,4548_solicitudesMovimientoGrupo c WHERE g.idGrupo=".$idGrupoTmp."
							AND c.idSolicitudMovimiento=g.idSolicitud AND c.situacion IN(1,2)";
				$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
					$tieneAME=1;
			}
			else
			{
				
				$arrAsignaciones=obtenerFechasAsignacionGrupoV2($idGrupo,$idSolicitud,true,true,$filaGrupo[1],$filaGrupo[2],1);
				$nAsignaciones=sizeof($arrAsignaciones);
				if($nAsignaciones>0)
				{
					$iUsr=$arrAsignaciones[($nAsignaciones-1)][5];
					$nombreProfesor=cv(obtenerNombreUsuarioPaterno($iUsr));
				}
				
			}
			
			
			$consulta="SELECT count(*) FROM 4539_gruposCompartidos WHERE idGrupo=".$idGrupoTmp;
			$nCompartidos=$con->obtenerValor($consulta);
			if($nCompartidos>0)
			{
				
				$consulta="SELECT idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
				$idInstanciaPlanEstudio=$con->obtenerValor($consulta);
				$consulta="SELECT idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupoTmp;
				$idInstanciaPlanEstudioCompartida=$con->obtenerValor($consulta);
				if($idInstanciaPlanEstudio==$idInstanciaPlanEstudioCompartida)
				{
					if($tieneAME!=1)
						$tieneAME=-1;
				}
				else
					$tieneAME=2;
				
				
			}
			if($nombreProfesor=="")
			{
				$nombreProfesor="Sin profesor asignado";
			}
			
			if(($horario=="")&&($tieneAME!=1))
			{
				
				$tieneAME=4;
			}
			
			if(($idGrupoTmp==0)&&($tieneAME!=1))
			{
				$tieneAME=3;
			}
			$lblGrupo.="@@(".$fGrupo[0].")<br><br>".cv($fGrupo[1])."@@".$horario."@@".$iUsr."@@".$iUsr."@@".$nombreProfesor."@@".$tieneAME; 
			
			$obj='"bloque'.$nBloque.'":"'.$lblGrupo.'","bloqueOriginal'.$nBloque.'":"'.$lblGrupo.'"';
			if($cadFila=="")
				$cadFila=$obj;
			else
				$cadFila.=",".$obj;
			$nBloque++;
		}
		$cadFila='{'.$cadFila.'}';
		if($cadFinal=="")
			$cadFinal=$cadFila;
		else
			$cadFinal.=",".$cadFila;
		$numReg++;
		
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$cadFinal.']}';
}

function obtenerFechasExamenesGrupo()
{
	global $con;
	$fechaActual=strtotime(date("Y-m-d"));
	$vCalificaciones=0;
	if(isset($_POST["vCalificaciones"]))
		$vCalificaciones=$_POST["vCalificaciones"];
		
	$idGrupo=$_POST["idGrupo"];
	$consulta="SELECT idInstanciaPlanEstudio,idCiclo,idPeriodo FROM 4520_grupos WHERE idGrupos=".$idGrupo;
	$fGrupo=$con->obtenerPrimeraFila($consulta);
	$idInstancia=$fGrupo[0];
	
	if($idInstancia=="")
		$idInstancia=-1;

	$consulta="SELECT DISTINCT idInstanciaPlanEstudio,i.idPlanEstudio,i.tipoEsquemaParcialesGrupo,i.numParcialesGrupo,
			i.tipoEsquemaAsignacionFechasGrupo,i.numMaxBloquesFechas,idPerfilEvaluacion 
			FROM 4513_instanciaPlanEstudio i where idInstanciaPlanEstudio=".$idInstancia;
	$fila=$con->obtenerPrimeraFila($consulta);
	$idReferenciaExamenes=obtenerPerfilExamenesAplica($fila[1],$idInstancia);

	$arrRegistros="";

	$numReg=0;
	
	
	
	
	
	

	$consulta="SELECT e.idTipoExamen,e.tipoExamen FROM 4625_tiposExamenPerfilEvaluacion t,4622_catalogoTipoExamen e WHERE idPerfil=".$idReferenciaExamenes." AND e.idTipoExamen=t.idTipoExamen ORDER BY prioridad";
	$resExamenes=$con->obtenerFilas($consulta);	
	while($fExamen=mysql_fetch_row($resExamenes))
	{
		
		
		$idPerfilEval=obtenerPerfilCriterioEvaluacionGrupo($idGrupo,$fExamen[0]);
		
		$asociadoSesion=obtenerValorConfiguracionEvaluacion($fila[6],$fExamen[0],4);
		
		$consulta="SELECT * FROM 4580_calendarioExamenesGrupo WHERE idGrupo=".$idGrupo." AND tipoExamen=".$fExamen[0]." AND noExamen=1";
		$fFechas=$con->obtenerPrimeraFila($consulta);

		$fechaAplicacion="";
		$fechaInicioInc="";
		$fechaFinInc="";
		$fechaReporteResultados="";
		$situacionEvaluacion=-2;
		$fechaMinima=date("Y-m-d");
		$fechaMaxima=date("Y-m-d",strtotime("-1 days",strtotime(date("Y-m-d"))));
		if($fFechas)
		{
			if($fechaActual>=strtotime($fFechas[4]))
			{
				$consulta="SELECT situacion FROM  4593_situacionEvaluacionCurso WHERE idGrupo=".$idGrupo." AND tipoExamen=".$fExamen[0];
				$situacionEvaluacion=$con->obtenerValor($consulta);
				if($situacionEvaluacion=="")
					$situacionEvaluacion=0;
			}
			else
				$situacionEvaluacion=-1;
			$fechaAplicacion=$fFechas[4]."|".$fFechas[6];
			$fechaInicioInc=$fFechas[7]."|".$fFechas[8];
			$fechaFinInc=$fFechas[9]."|".$fFechas[10];
			$fechaReporteResultados=$fFechas[5];
		}

		$consulta="SELECT noBloqueAsociado FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$noBloque=$con->obtenerValor($consulta);
		if($noBloque=="")
			$noBloque=0;	
		
		$consulta="SELECT fechaInicio,fechaFin FROM 4580_fechasExamenes WHERE idCiclo=".$fGrupo[1]." AND idPeriodo=".$fGrupo[2]." AND idExamen=".$fExamen[0]."  AND numBloque=".$noBloque."
				 AND idInstancia=".$idInstancia;	

		$fechasExam=$con->obtenerPrimeraFila($consulta);
		if($fechasExam)
		{
			$fechaMinima=$fechasExam[0];
			$fechaMaxima=$fechasExam[1];
		}
		
		$intervaloReporteResultados=obtenerValorConfiguracionEvaluacion($fila[6],$fExamen[0],5);

		$consulta="SELECT perfilLiberado,idGrupo FROM 4591_perfilesEvaluacionMateria WHERE idPerfil=".$idPerfilEval;
		$fPerfil=$con->obtenerPrimeraFila($consulta);
		if(!$fPerfil)
		{
			$fPerfil[0]="0";
		}

		$oRegistro='{"perfilCriteriosLiberados":"'.$fPerfil[0].'","situacionEvaluacion":"'.$situacionEvaluacion.'","idTipoExamen":"'.$fExamen[0].'","noExamen":"1","descripcion":"'.
				cv($fExamen[1]).'","intervaloReporteResultados":"'.$intervaloReporteResultados.'","fechaReporteResultados":"'.$fechaReporteResultados.'","fechaAplicacion":"'.$fechaAplicacion.
				'","asociadoSesion":"'.$asociadoSesion.'","fechaInicioIncidencia":"'.$fechaInicioInc.'","fechaFinIncidencia":"'.$fechaFinInc.'","fechaMinima":"'.$fechaMinima.'","fechaMaxima":"'.$fechaMaxima.'"}';
		if($arrRegistros=="")				
			$arrRegistros=$oRegistro;
		else
			$arrRegistros.=",".$oRegistro;
		$numReg++;
		
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
}

function registrarFechasExamenGrupo()
{
	global $con;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="delete from 4580_calendarioExamenesGrupo where idGrupo=".$obj->idGrupo;
	$x++;
	$consulta[$x]="update 4530_sesiones set tipoSesion=9,tipoExamen=NULL,noExamen=NULL where idGrupo=".$obj->idGrupo." and tipoSesion=11";
	$x++;
	
	foreach($obj->arrRegistros as $r)
	{
		$dAplicacion=explode("|",$r->fechaAplicacion);
		$noSesionAplicacion="NULL";
		if($dAplicacion[1]!="")
			$noSesionAplicacion=$dAplicacion[1];
		
		
		$fechaInicioIncidencia="NULL";
		$noSesionInicioIncidencia="NULL";
		if($r->fechaInicioIncidencia!="")
		{
			$dInicio=explode("|",$r->fechaInicioIncidencia);
			$fechaInicioIncidencia="'".$dInicio[0]."'";
			if($dInicio[1]!="")
				$noSesionInicioIncidencia=$dInicio[1];
			
		}
		$fechaFinIncidencia="NULL";
		$noSesionFinIncidencia="NULL";
		if($r->fechaFinIncidencia!="")
		{
			
			$dFin=explode("|",$r->fechaFinIncidencia);
			$fechaFinIncidencia="'".$dFin[0]."'";
			if($dFin[1]!="")
				$noSesionFinIncidencia=$dFin[1];
		}
		$consulta[$x]="INSERT INTO 4580_calendarioExamenesGrupo(idGrupo,tipoExamen,noExamen,fechaAplicacion,fechaReporteCalificacion,noSesionAplicacion,fechaInicioIncidencia,noSesionInicioIncidencia,fechaFinIncidencia,noSesionFinIncidencia)
					VALUES(".$obj->idGrupo.",".$r->idTipoExamen.",".$r->noExamen.",'".$dAplicacion[0]."','".$r->fechaReporteResultados."',".$noSesionAplicacion.",".$fechaInicioIncidencia.",".$noSesionInicioIncidencia.",".$fechaFinIncidencia.",".$noSesionFinIncidencia.")";
		$x++;
		$consulta[$x]="update 4530_sesiones set tipoSesion=11,tipoExamen=".$r->idTipoExamen.",noExamen=".$r->noExamen." where idGrupo=".$obj->idGrupo." and noSesion=".$noSesionAplicacion;
		$x++;
	}
	$consulta[$x]="commit";
	$x++;
	eB($consulta);	
}
	
function obtenerCriteriosEvaluacionPerfilMateria()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$permiteAjuste=$_POST["permiteAjuste"];
	$nivel=1;
	$longitud=7;
	$cadObj="";
	$tipoPonderacion="";
	
	$consulta="SELECT tipoPonderacion,idGrupo FROM 4591_perfilesEvaluacionMateria WHERE idPerfil=".$idPerfil;
	$fPerfil=$con->obtenerPrimeraFila($consulta);
	$tipoPonderacion=$fPerfil[0];
	$idGrupo=$fPerfil[1];
	
	$codigoPadre=str_pad($idPerfil,$longitud,"0",STR_PAD_LEFT);
	$consulta="SELECT c.codigoUnidad,e.titulo,c.tipoPonderacion,c.idFuncionInicializacion,
			(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=c.idFuncionInicializacion) as nombreConsulta,
			c.idFuncionScriptGuardar,obligatorio FROM 4564_criteriosEvaluacionPerfilMateria c,4010_evaluaciones e 
			WHERE  codigoPadre='".$codigoPadre."' and  e.idEvaluacion=c.idCriterio order by titulo";

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$comp="";
		$valor="";
		$valor2="";
		if($tipoPonderacion==1)
		{
			$consulta="SELECT porcentaje,porcentajeMaximo,porcentajeMinimo FROM 4565_porcentajeCriterioEvaluacionPerfil WHERE idPerfil=".$idPerfil." 
					and idCriterioEvaluacionMateria='".$fila[0]."' AND bloque=0";
			

			
			$fPorcentaje=$con->obtenerPrimeraFila($consulta);		
			$valor=removerCerosDerecha($fPorcentaje[0]);
			if($valor=="")
				$valor=0;
			$valor2=removerCerosDerecha($fPorcentaje[1]);
			if($valor2=="")
				$valor2=0;
				
			$valor3=removerCerosDerecha($fPorcentaje[2]);
			if($valor3=="")
				$valor3=0;	
				
			if(($permiteAjuste==0)&&($idGrupo==0))
				$valor2="";	
				
			if($idGrupo!=0)
			{
				if(($valor2==0)&&($valor3==0))
				{
					$valor2=100;
				}
			}
				
		}
		else
		{
			$valor="Balanceada";
			$valor2="Balanceada";
		}
		$o='"bloque_0":"'.$valor.'","bloque_0_max":"'.$valor2.'","bloque_0_min":"'.$valor3.'"';
		$comp.=",".$o;
		
		$arrHijos="";
		$arrHijos=obtenerCriteriosHijosPerfil($fila[0],$idPerfil,($nivel+1),$fila[2],$permiteAjuste);
		if($arrHijos=="[]")
			$comp.=',"leaf":true';
		else
			$comp.=',"leaf":false,"children":'.$arrHijos;
		$obj='{"obligatorio":"'.$fila[6].'","idFuncionInicializacion":"'.$fila[3].'","nombreConsultaInicializacion":"'.cv($fila[4]).'","idFuncionScriptGuardar":"'.$fila[5].
			'","tipoPonderacionPadre":"'.$tipoPonderacion.'","tipoPonderacion":"'.$fila[2].'","nivel":"'.$nivel.
			'","icon":"../images/bullet_green.png","id":"'.$fila[0].'","criterioEval":"'.cv($fila[1]).'"'.$comp.'}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;
	}
	echo "[".$cadObj."]";
}	
		
function obtenerCriteriosHijosPerfil($codigoPadre,$idPerfil,$nivel,$tipoPonderacionPadre,$permiteAjuste)
{
	global $con;
	
	$consulta="SELECT tipoPonderacion,idGrupo FROM 4591_perfilesEvaluacionMateria WHERE idPerfil=".$idPerfil;
	$fPerfil=$con->obtenerPrimeraFila($consulta);
	
	$idGrupo=$fPerfil[1];
	
	$cadObj="";
	$consulta="SELECT c.codigoUnidad,e.titulo,c.tipoPonderacion,obligatorio FROM 4564_criteriosEvaluacionPerfilMateria c,4010_evaluaciones e WHERE codigoPadre='".$codigoPadre."'  AND e.idEvaluacion=c.idCriterio order by titulo";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$comp="";
		$valor="";
		$valor2="";
		if($tipoPonderacionPadre==1)
		{
				$consulta="SELECT porcentaje,porcentajeMaximo,porcentajeMinimo FROM 4565_porcentajeCriterioEvaluacionPerfil WHERE idPerfil=".$idPerfil." and idCriterioEvaluacionMateria='".$fila[0]."' AND bloque=0";
				
				
				
				$fPorcentaje=$con->obtenerPrimeraFila($consulta);		
				$valor=removerCerosDerecha($fPorcentaje[0]);
				if($valor=="")
					$valor=0;
				$valor2=removerCerosDerecha($fPorcentaje[1]);
				if($valor2=="")
					$valor2=0;
				if(($idGrupo==0)&&($permiteAjuste==0))
					$valor2="";	
				
				
				$valor3=removerCerosDerecha($fPorcentaje[2]);
				if($valor3=="")
					$valor3=0;	
				
					
				if($idGrupo!=0)
				{
					if(($valor2==0)&&($valor3==0))
					{
						$valor2=100;
					}
				}	
					
		}
		else
		{
			$valor="Balanceada";
			$valor2="Balanceada";
		}
		$o='"bloque_0":"'.$valor.'","bloque_0_max":"'.$valor2.'","bloque_0_min":"'.$valor3.'"';
		$comp.=",".$o;
		
		$arrHijos="";
		$arrHijos=obtenerCriteriosHijosPerfil($fila[0],$idPerfil,($nivel+1),$fila[2],$permiteAjuste);
		if($arrHijos=="[]")
			$comp.=',"leaf":true';
		else
			$comp.=',"leaf":false,"children":'.$arrHijos;
		$obj='{"obligatorio":"'.$fila[3].'","tipoPonderacionPadre":"'.$tipoPonderacionPadre.'","tipoPonderacion":"'.$fila[2].'","nivel":"'.$nivel.'","icon":"../images/bullet_green.png","id":"'.$fila[0].'","criterioEval":"'.cv($fila[1]).'"'.$comp.'}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;
	}
	return "[".$cadObj."]";
}	

function registrarCriteriosEvaluacionPerfilMateria()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	$obligatorio=1;
	if(isset($obj->obligatorio))
	{
		$obligatorio=$obj->obligatorio;
	}
	
	$longitud=7;
	$codigoPadre=str_pad($obj->codigoPadre,$longitud,"0",STR_PAD_LEFT);
	$consulta="select max(codigoUnidad) from 4564_criteriosEvaluacionPerfilMateria where codigoPadre='".$codigoPadre."' and idPerfil=".$obj->idPerfil;
	$maxNivel=$con->obtenerValor($consulta);

	if($maxNivel=="")
	{
		$maxNivel=0;
		
		
	}
	else
		$maxNivel=substr($maxNivel,strlen($codigoPadre));
	
	$maxNivel++;
	$arrCriterios=explode(",",$obj->criterios);

	$x=0;
	$query[$x]="begin";
	$x++;
	foreach($arrCriterios as $c)
	{
		$codigoUnidad=$codigoPadre.str_pad($maxNivel,$longitud,"0",STR_PAD_LEFT);
		$consulta="select count(*) from 4564_criteriosEvaluacionPerfilMateria where codigoPadre='".$codigoPadre."' and idPerfil=".$obj->idPerfil." and idCriterio=".$c;
		$nCriterio=$con->obtenerValor($consulta);

		if($nCriterio==0)
		{
			$query[$x]="INSERT INTO 4564_criteriosEvaluacionPerfilMateria(idPerfil,codigoUnidad,codigoPadre,idCriterio,obligatorio) 
						VALUES(".$obj->idPerfil.",'".$codigoUnidad."','".$codigoPadre."',".$c.",".$obligatorio.")";
			$x++;
			$maxNivel++;
		}
	}

	$query[$x]="commit";
	$x++;
	eB($query);
}

function guardarPorcentajeCriterioPerfil()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT tipoPonderacion,idGrupo FROM 4591_perfilesEvaluacionMateria WHERE idPerfil=".$obj->idPerfil;
	$fPerfil=$con->obtenerPrimeraFila($consulta);
	
	$idGrupo=$fPerfil[1];
	
	$consulta="select count(*) from 4565_porcentajeCriterioEvaluacionPerfil where idCriterioEvaluacionMateria='".$obj->idCriterioEvaluacionMateria."' and idPerfil=".$obj->idPerfil." and bloque=".$obj->bloque;
	$nCriterio=$con->obtenerValor($consulta);
	
	$campo="porcentaje";
	if($obj->tipoValor=="0")
		$campo="porcentajeMaximo";
			
	if($obj->tipoValor=="2")			
	{
		$consulta="update 4564_criteriosEvaluacionPerfilMateria set obligatorio=".$obj->porcentaje." where codigoUnidad='".$obj->idCriterioEvaluacionMateria."' and idPerfil=".$obj->idPerfil;
	}
	else
	{
			
		if($nCriterio==0)
		{
			if($idGrupo==0)
			{
				$consulta="INSERT INTO 4565_porcentajeCriterioEvaluacionPerfil(idCriterioEvaluacionMateria,bloque,porcentaje,idPerfil,porcentajeMaximo,porcentajeMinimo) VALUES('".
							$obj->idCriterioEvaluacionMateria."',".$obj->bloque.",".$obj->porcentaje.",".$obj->idPerfil.",".$obj->porcentaje.",".$obj->porcentaje.")";
			}
			else
			{
				$consulta="INSERT INTO 4565_porcentajeCriterioEvaluacionPerfil(idCriterioEvaluacionMateria,bloque,porcentaje,idPerfil,porcentajeMaximo,porcentajeMinimo) VALUES('".
							$obj->idCriterioEvaluacionMateria."',".$obj->bloque.",".$obj->porcentaje.",".$obj->idPerfil.",100,0)";
			}
		}
		else
		{
			switch($obj->tipoValor)
			{
				case 0:
					$consulta="update 4565_porcentajeCriterioEvaluacionPerfil set porcentajeMaximo=".$obj->porcentaje." where idCriterioEvaluacionMateria='".
							$obj->idCriterioEvaluacionMateria."' and idPerfil=".$obj->idPerfil." and bloque=".$obj->bloque;
				break;
				case 1:
					$consulta="update 4565_porcentajeCriterioEvaluacionPerfil set porcentaje=".$obj->porcentaje.", porcentajeMinimo=".$obj->porcentaje." 
							where idCriterioEvaluacionMateria='".$obj->idCriterioEvaluacionMateria."' and idPerfil=".$obj->idPerfil." and bloque=".$obj->bloque;
				break;
				
				case 3:
					$consulta="update 4565_porcentajeCriterioEvaluacionPerfil set porcentaje=".$obj->porcentaje."
							where idCriterioEvaluacionMateria='".$obj->idCriterioEvaluacionMateria."' and idPerfil=".$obj->idPerfil." and bloque=".$obj->bloque;
				break;
			}
			
				
		}
	}
	eC($consulta);
}

function modificarPonderacionCriterioEvaluacionPerfil()
{
	global $con;
	$tipoPonderacion=$_POST["tPonderacion"];
	$idCriterio=$_POST["idCriterio"];
	$idPerfil=$_POST["idPerfil"];
	$consulta="UPDATE 4564_criteriosEvaluacionPerfilMateria SET tipoPonderacion=".$tipoPonderacion." WHERE idPerfil=".$idPerfil." AND codigoUnidad='".$idCriterio."'";
	if($con->ejecutarConsulta($consulta))
	{
		if($tipoPonderacion==2)
		{
			
			removerPorcentajesCriterioEvaluacionPerfil($idCriterio,$idPerfil);
		}
		echo "1|";
	}
}

function removerCriterioEvaluacionPerfil()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$idCriterio=$_POST["idCriterio"];
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="DELETE FROM 4564_criteriosEvaluacionPerfilMateria WHERE idPerfil=".$idPerfil." and codigoUnidad LIKE '".$idCriterio."%'";
	$x++;
	$consulta[$x]="DELETE FROM 4565_porcentajeCriterioEvaluacionPerfil WHERE idPerfil=".$idPerfil." and idCriterioEvaluacionMateria LIKE '".$idCriterio."%'";
	$x++;
	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
}

function obtenerTipoExamenesPerfilEvaluacionMateriaGrupo()
{
	global $con;
	$idPlanEstudio=$_POST["idPlanEstudio"];
	$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
	$idMateria=$_POST["idMateria"];
	$idGrupo=$_POST["idGrupo"];
	$arrRegistros="";
	$idReferenciaExamenes=obtenerPerfilExamenesAplica($idPlanEstudio,$idInstanciaPlanEstudio);
	
	if($idReferenciaExamenes=="")
		$idReferenciaExamenes=-1;
	$consulta="SELECT e.idTipoExamen,e.tipoExamen FROM 4625_tiposExamenPerfilEvaluacion t,4622_catalogoTipoExamen e WHERE idPerfil=".$idReferenciaExamenes." AND e.idTipoExamen=t.idTipoExamen ORDER BY prioridad";

	

	$resExamenes=$con->obtenerFilas($consulta);
	$numReg=0;	
	while($filaExamen=mysql_fetch_row($resExamenes))
	{
		$consulta="select idPerfil,calificacionMinimaAprobatoria,idPerfilEvaluacionMateria from 4592_configuracionPerfilEvaluacion where idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." and idMateria=".$idMateria.
					" and idGrupo=".$idGrupo." and tipoExamen=".$filaExamen[0];
				
		$fPerfil=$con->obtenerPrimeraFila($consulta);
		$idPerfil="";
		$idPerfilEvaluacionMateria="";
		if(!$fPerfil)
		{
			$calificacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$filaExamen[0],13);//Calificacion
			$idPerfil=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$filaExamen[0],12);//Perfil evaluacion
			$idPerfilEvaluacionMateria="-1";
			
		}
		else
		{
			$idPerfil=$fPerfil[0];
			$calificacion=$fPerfil[1];
			$idPerfilEvaluacionMateria=$fPerfil[2];
		}
		
		
		
		
		$consulta="SELECT idFuncion ,c.nombreConsulta FROM 4606_funcionesConfiguracionPerfilEvaluacion f,991_consultasSql c WHERE c.idConsulta=f.idFuncion AND idPerfilEvaluacionMateria=".$idPerfilEvaluacionMateria." 
					AND tipoFuncion=1 order by idFuncionPerfilConfiguracion";
		$funcionesDisparadoras=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idFuncion ,c.nombreConsulta FROM 4606_funcionesConfiguracionPerfilEvaluacion f,991_consultasSql c WHERE c.idConsulta=f.idFuncion AND idPerfilEvaluacionMateria=".$idPerfilEvaluacionMateria." 
					AND tipoFuncion=2 order by idFuncionPerfilConfiguracion";
		$funcionesSolicitud=$con->obtenerFilasArreglo($consulta);
		
		
		$o='{"tipoExamen":"'.$filaExamen[0].'","noExamen":"1","etiquetaExamen":"'.cv($filaExamen[1]).'","idPerfil":"'.$idPerfil.'","calificacionMinima":"'.$calificacion.
			'","funcionesDisparadoras":'.$funcionesDisparadoras.',"funcionesSolicitud":'.$funcionesSolicitud.'}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function guardarConfiguracionTipoExamenEvaluacionMateriaGrupo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="delete from 4592_configuracionPerfilEvaluacion where idPlanEstudio=".$obj->idPlanEstudio." and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idMateria=".$obj->idMateria." and idGrupo=".$obj->idGrupo;
	$x++;
	
	
	$query="SELECT idPerfilEvaluacionMateria FROM 4592_configuracionPerfilEvaluacion where idPlanEstudio=".$obj->idPlanEstudio." and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idMateria=".$obj->idMateria." and idGrupo=".$obj->idGrupo;
	$listPerfilesEval=$con->obtenerListaValores($query);
	if($listPerfilesEval=="")
		$listPerfilesEval=-1;
	$consulta[$x]="DELETE FROM 4606_funcionesConfiguracionPerfilEvaluacion WHERE idPerfilEvaluacionMateria IN(".$listPerfilesEval.")";
	$x++;
	
	foreach($obj->arrConfiguracion as $r)
	{
		$consulta[$x]="INSERT INTO 4592_configuracionPerfilEvaluacion(idPlanEstudio,idInstanciaPlanEstudio,idMateria,idGrupo,tipoExamen,noExamen,idPerfil,calificacionMinimaAprobatoria)
						VALUES(".$obj->idPlanEstudio.",".$obj->idInstanciaPlanEstudio.",".$obj->idMateria.",".$obj->idGrupo.",".$r->tipoExamen.",".$r->noExamen.",".$r->idPerfil.",".$r->calificacionMinima.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		if(sizeof($r->funcionesDisparadoras)>0)
		{
			foreach($r->funcionesDisparadoras as $f)
			{
				$consulta[$x]="INSERT INTO 4606_funcionesConfiguracionPerfilEvaluacion(idFuncion,tipoFuncion,idPerfilEvaluacionMateria) VALUES(".$f->idFuncion.",1,@idRegistro)";
				$x++;
			}
			
		}
		if(sizeof($r->funcionesSolicitud)>0)
		{
			foreach($r->funcionesSolicitud as $f)
			{
				$consulta[$x]="INSERT INTO 4606_funcionesConfiguracionPerfilEvaluacion(idFuncion,tipoFuncion,idPerfilEvaluacionMateria) VALUES(".$f->idFuncion.",2,@idRegistro)";
				$x++;
			}
		}
	}
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
}

function obtenerSolicitudesAMESV2()
{
	global $con;
	$numReg=0;
	$cadObj="";
	$situacion=$_POST["situacion"];
	$comp="";
	
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$sort=$_POST["sort"];
	$dir=$_POST["dir"];
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	if(isset($_POST["plantel"]))
	{
		$comp=" and plantel='".$_POST["plantel"]."'";	

	}
	
	
	$cadCondWhere=str_replace("fechaEnvioAutorizacion","Date(fechaEnvioAutorizacion)",$cadCondWhere);
	$cadCondWhere=str_replace("fechaDictamen","Date(fechaDictamen)",$cadCondWhere);
	$consulta="SELECT idSolicitudAME,idResponsable,fechaRegistro,fechaDictamen,idResponsableDictamen,resultadoDictamen,comentariosDictamen,
				folioSolicitud,fechaEnvioAutorizacion,s.situacion,comentarios FROM 4549_cabeceraSolicitudAME s
				WHERE  s.situacion in (".$situacion.") ".$comp." and ".$cadCondWhere;

	
	$con->obtenerFilas($consulta);
	$numReg=$con->filasAfectadas;			
				
	$consulta="SELECT idSolicitudAME,idResponsable,fechaRegistro,fechaDictamen,idResponsableDictamen,resultadoDictamen,comentariosDictamen,
				folioSolicitud,fechaEnvioAutorizacion,s.situacion,comentarios,formatoPieFinal FROM 4549_cabeceraSolicitudAME s
				WHERE  s.situacion in (".$situacion.")  ".$comp." and ".$cadCondWhere." ORDER BY ".$sort." ".$dir." limit ".$start.",".$limit;
	$res=$con->obtenerFilas($consulta);
	
	while($fila=mysql_fetch_row($res))
	{

		$consulta="SELECT DISTINCT o.unidad FROM 4520_grupos g,4548_solicitudesMovimientoGrupo s,4548_gruposSolicitudesMovimiento m,817_organigrama o 
					WHERE g.idGrupos=m.idGrupo AND s.idSolicitudMovimiento=m.idSolicitud AND s.idSolicitudAME=".$fila[0]." AND o.codigoUnidad=g.plantel";

		$plantel=$con->obtenerListaValores($consulta);
		$responsable="";
		if($fila[1]!="")
		{
			$responsable=obtenerNombreUsuarioPaterno($fila[1]);
		}

		$responsableDictamen="";
		if($fila[4]!="")
		{
			$responsableDictamen=obtenerNombreUsuarioPaterno($fila[4]);
		}
		
		$descSolicitud="";
		$consulta="SELECT * FROM  4548_solicitudesMovimientoGrupo WHERE idSolicitudAME=".$fila[0]."   ORDER BY idSolicitudMovimiento";

		$resSol=$con->obtenerFilas($consulta);
		while($fSol=mysql_fetch_row($resSol))
		{
			
			switch($fSol[2])
			{
				case 1:
				case 3:
					$descSolicitud.=formatearSolicitudAltaSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
				break;
				case 2:
				case 5:
					$descSolicitud.=formatearSolicitudBajaFinalizacionSuplencia($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					
				break;
				case 4:
				case 6:
					$descSolicitud.=formatearSolicitudCambioHorarioFecha($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
				break;
				case 7:
					$descSolicitud.=formatearSolicitudIntercambioCurso($fSol)."<br><table width='100%'><tr height='1'><td style='background-color:#000'></td></tr></table><br>";
					
				break;
			}
		}
		
		
		$obj='{"plantel":"'.$plantel.'","fechaDictamen":"'.$fila[3].'","responsableRespuesta":"'.$responsableDictamen.'","idSolicitudMovimiento":"'.$fila[0].'","responsableSolicitud":"'.$responsable.'",'.
				'"comentariosDictamen":"'.cv($fila[6]).'","descSolicitud":"'.$descSolicitud.'","folioSolicitud":"'.
				$fila[7].'","fechaEnvioAutorizacion":"'.$fila[8].'","situacion":"'.$fila[9].'","comentariosAdicionales":"'.cv($fila[10]).'","formatoPieFinal":"'.$fila[11].'"}';
		if($cadObj=="")
			$cadObj=$obj;
		else
			$cadObj.=",".$obj;

	}
	echo '{"numReg":"'.$numReg.'","registros":['.$cadObj.']}';
}

function obtenerPeriodosPlantel()
{
	global $con;
	$plantel=$_POST["plantel"];
	$consulta="SELECT DISTINCT i.idPeriodicidad FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' and i.situacion=1";
	$listPeriodos=$con->obtenerListaValores($consulta);
	if($listPeriodos=="")
		$listPeriodos=-1;
	$consulta="SELECT id__464_gridPeriodos,concat(txtDescripcion,': ',nombrePeriodo) FROM _464_gridPeriodos g,_464_tablaDinamica t WHERE 
					g.idReferencia=t.id__464_tablaDinamica and t.id__464_tablaDinamica IN (".$listPeriodos.") order by txtDescripcion,nombrePeriodo";			
	$arrPeriodos=$con->obtenerFilasArreglo($consulta);$consulta="SELECT DISTINCT i.idPeriodicidad FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."' and i.situacion=1";
	$listPeriodos=$con->obtenerListaValores($consulta);
	if($listPeriodos=="")
		$listPeriodos=-1;
	$consulta="SELECT id__464_gridPeriodos,concat(txtDescripcion,': ',nombrePeriodo) FROM _464_gridPeriodos g,_464_tablaDinamica t WHERE 
					g.idReferencia=t.id__464_tablaDinamica and t.id__464_tablaDinamica IN (".$listPeriodos.") order by txtDescripcion,nombrePeriodo";			
	$arrPeriodos=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrPeriodos;
}

function guardarCostoServiciosEstandar()
{
	global $con;
	$x=0;
	$query[$x]="begin";
	$x++;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	$idCiclo=$obj->idCiclo;
	$idPeriodo=$obj->idPeriodo;
	$arrServicios=explode(",",$obj->arrServicios);
	$fechaVencimiento="NULL";
	if($obj->fechaVencimiento!="")
		$fechaVencimiento="'".$obj->fechaVencimiento."'";
	foreach($arrServicios as $s)	
	{
		$aServicios=explode("_",$s);
		$plantel=$aServicios[0];
		$idProgramaEducativo=$aServicios[1];
		$idPlanEstudio=$aServicios[2];
		$idGrado=$aServicios[3];
		$idServicio=$aServicios[4];
		
		$consulta="SELECT idCostoConcepto FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
				idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idServicio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
		$idCostoConcepto=$con->obtenerValor($consulta);
		if($idCostoConcepto=="")
		{
			$query[$x]="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,grado,idProgramaEducativo,fechaVencimiento,idPerfilCosteo)
						VALUES(".$idServicio.",'".$obj->costoServicio."','".$plantel."',".$idPlanEstudio.",".$idCiclo.",".$idPeriodo.",".$idGrado.",".$idProgramaEducativo.",".$fechaVencimiento.",".$obj->idPerfilCosteo.")";
			$x++;
		}
		else
		{
			$query[$x]="update 6011_costoConcepto set valor='".$obj->costoServicio."',fechaVencimiento=".$fechaVencimiento." where  idCostoConcepto=".$idCostoConcepto;
						
			$x++;
		}
		
	
	}
	$query[$x]="commit";
	$x++;
	eB($query);
	
}

function guardarConfiguracionAvanzadaCriterio()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	if(($obj->idFuncionInicializacion=="")||($obj->idFuncionInicializacion=="-1"))
		$obj->idFuncionInicializacion="NULL";
	if(($obj->idFuncionScriptGuardar=="")||($obj->idFuncionScriptGuardar=="-1"))
	{
		$obj->idFuncionScriptGuardar="NULL";
	}		
	$consulta="UPDATE 4564_criteriosEvaluacionPerfilMateria SET idFuncionInicializacion=".$obj->idFuncionInicializacion.",idFuncionScriptGuardar=".$obj->idFuncionScriptGuardar." WHERE codigoUnidad='".$obj->codigoUnidad."'";
	eC($consulta);
}

function obtenerProfesoresCambioHorario()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$arrProfesores=obtenerFechasAsignacionGrupoV2($obj->idGrupo,$obj->idSolicitudAME,true,true,$obj->fechaInicio,$obj->fechaFin,0,true);
	$uProfesor=null;
	if(sizeof($arrProfesores)>0)
	{
		foreach($arrProfesores as $p)	
		{
			if($p[8]==37)
			{
				$uProfesor=$p;	
			}
		}
	}

	if($uProfesor)
	{
		$idAsignacion=$uProfesor[0];
		if($idAsignacion[0]==0)
			$idAsignacion="-".$uProfesor[9];
		echo '1|{"idAsignacion":"'.$idAsignacion.'","idUsuario":"'.$uProfesor[5].'","nombreProfesor":"'.cv(obtenerNombreUsuarioPaterno($uProfesor[5])).'","fechaInicio":"'.date("d/m/Y",strtotime($uProfesor[6])).'","fechaFin":"'.date("d/m/Y",strtotime($uProfesor[7])).'"}';
	}
	else
	{
		echo '1|0';
	}

}

function obtenerFechaTerminoGrupoAsignacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="select fechaInicio,noBloqueAsociado from 4520_grupos where idGrupos=".$obj->idGrupo;
	$fGrupo=$con->obtenerPrimeraFila($consulta);
	$noBloqueGrupo=$fGrupo[1];
	$fechaInicio=$fGrupo[0];
	$arrProfesores=obtenerFechasAsignacionGrupoV2($obj->idGrupo,$obj->idSolicitudAME,true,true,$fechaInicio,$obj->fechaFin,0,true);
	
	$uProfesor=NULL;
	if(sizeof($arrProfesores)>0)
	{
		$uProfesor=$arrProfesores[sizeof($arrProfesores)-1];
		
		if(strtotime($obj->fechaFin)<=strtotime($uProfesor[7]))
		{
			echo "1|0";	
		}
		else
		{
			$fechaInicioSesion=date("Y-m-d",strtotime("+1 days",strtotime($uProfesor[7])));
			$arrSesiones=array();
			$totalHoraPerdidas=0;
			if(strtotime($fechaInicioSesion)<strtotime($obj->fechaFin))
			{
				$arrSesiones=obtenerSesionesPeriodo($obj->idGrupo,$obj->idSolicitudAME,$fechaInicioSesion,$obj->fechaFin);
				foreach($arrSesiones as $arrDias)
				{
					foreach($arrDias as $fHorario)
					{
						
						$hInicial=$fHorario[3];
						$hFinal=$fHorario[4];
						$totalHoraPerdidas+=obtenerDiferenciaHoraMinutos($hInicial,$hFinal);
					}
				}
				$duracionHora=obtenenerDuracionHoraGrupo($obj->idGrupo);
				$totalHoraPerdidas/=$duracionHora;
			}
			
			$arrHorarioGrupo=obtenerFechasHorarioGrupoV2($obj->idGrupo,$obj->idSolicitudAME,true,true);
	
			$arrHorarioGrupo=ordenarFechasArreglo($arrHorarioGrupo);
			$arrHorarioGrupo=normalizarFechasBloque($arrHorarioGrupo);
			$totalHoraImpartidas=0;
			
			
			$arrSesiones=obtenerSesionesPeriodo($obj->idGrupo,$obj->idSolicitudAME,$fechaInicio,$obj->fechaFin);
				
			$fechaBase=date("Y-m-d",strtotime("+1 days",strtotime($obj->fechaFin)));
			
			$totalHoraImpartidas=0;
			
			foreach($arrSesiones as $arrDias)
			{
				foreach($arrDias as $fHorario)
				{
					
					$hInicial=$fHorario[3];
					$hFinal=$fHorario[4];
					$totalHoraImpartidas+=obtenerDiferenciaHoraMinutos($hInicial,$hFinal);
				}
			}
	
			$duracionHora=obtenenerDuracionHoraGrupo($obj->idGrupo);
			
			$totalHoraImpartidas/=$duracionHora;
			$totalHoraImpartidas-=$totalHoraPerdidas;
			
			
			$arrDiasSesion=array();
			$maxFechaFin="";
			foreach($arrHorarioGrupo as $h)
			{
				if($maxFechaFin=="")
					$maxFechaFin=$h[7];
				else
				{
					if(strtotime($maxFechaFin)<strtotime($h[7]))
					{
						$maxFechaFin=$h[7];
					}
				}
			}
			foreach($arrHorarioGrupo as $h)
			{
				$hInicio=strtotime($h[3]);
				$hFin=strtotime($h[4]);
				if(!isset($arrDiasSesion[$h[2]]))
				{
					$arrDiasSesion[$h[2]]=array();
				}
				$objFecha=array();
				$objFecha[0]=date("H:i:s",$hInicio)." - ".date("H:i:s",$hFin);
				$objFecha[1]=strtotime($h[6]);
				$objFecha[2]=strtotime($h[7]);
				$objFecha[3]=obtenerDiferenciaHoraMinutos($h[3],$h[4])/$duracionHora;
				$objFecha[4]=$h[6];
				$objFecha[5]=$h[7];
				if($h[7]==$maxFechaFin)
				{
					
					$objFecha[2]=strtotime("+2 years",strtotime($h[7]));
					
					$objFecha[5]=date("Y-m-d",$objFecha[2]);
					
				}
				if($h[2]!=10)
					array_push($arrDiasSesion[$h[2]],$objFecha);
			}
			
			
			
				
			$compCambioHorario='"fechaTerminoOriginal":"'.$obj->fechaFin.'",';
			$arrCambiosHorario=obtenerCambioHorarioSolicitudAME($obj->idGrupo,$obj->idSolicitudAME);
			if(sizeof($arrCambiosHorario)>0)
			{
				foreach($arrCambiosHorario as $o)
				{
					if(isset($o->bloque))
						$noBloqueGrupo=$o->bloque;	
				}
			}
			
			if($noBloqueGrupo=="")
				$noBloqueGrupo=0;
			$fechaFin=obtenerFechaFinCursoHorario($obj->idGrupo,$fechaBase,$arrDiasSesion,$totalHoraImpartidas,$noBloqueGrupo);
			echo "1|".$fechaFin;
		}
		
		
	}
	else
	{
		echo "1|0";	
	}

}

function obtenerRegistrosReInscripcion()
{
	global $con;
	$cadCondWhere=" 1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
	$idCiclo=$_POST["idCiclo"];
	$idPeriodo=$_POST["idPeriodo"];
	$plantel=$_POST["plantel"];
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	
	$compPeriodo="";
	if($idPeriodo!=0)	
		$compPeriodo=" and tb.idPeriodo=".$idPeriodo;
		
	$consulta="SELECT  id__910_tablaDinamica,codigo,fechaCreacion, i.Nom,i.Paterno,i.Materno,
			(SELECT CONCAT(nombrePlanEstudios,' Modalidad: ',m.nombre,' Turno: ',t.turno) FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t  WHERE i.idInstanciaPlanEstudio=tb.idInstanciaPlan
             AND m.idModalidad=i.idModalidad AND t.idTurno=i.idTurno) as planEstudiosInscribe,
			idEstado FROM _910_tablaDinamica tb,802_identifica i WHERE codigoInstitucion='".$plantel."' and i.idUsuario=tb.idUsuarioRegistro and tb.idCiclo=".$idCiclo." ".$compPeriodo."  and ".$cadCondWhere." limit ".$start.",".$limit;
			
			
			
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	$consulta="SELECT  id__910_tablaDinamica,codigo,fechaCreacion, i.Nom,i.Paterno,i.Materno,
			(SELECT CONCAT(nombrePlanEstudios,' Modalidad: ',m.nombre,' Turno: ',t.turno) FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t  WHERE i.idInstanciaPlanEstudio=tb.idInstanciaPlan
             AND m.idModalidad=i.idModalidad AND t.idTurno=i.idTurno) as planEstudiosInscribe,
			idEstado FROM _910_tablaDinamica tb,802_identifica i WHERE codigoInstitucion='".$plantel."' and i.idUsuario=tb.idUsuarioRegistro and tb.idCiclo=".$idCiclo." ".$compPeriodo." and tb.idPeriodo=".$idPeriodo." and ".$cadCondWhere;
	$con->obtenerFilas($consulta);			
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}


function buscarAlumnoPlantel()
{
	global $con;
	$valorBusqueda=$_POST["valorBusqueda"];
	$plantel=$_POST["plantel"];
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idUsuario,nombre FROM (
				SELECT i.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom) AS nombre FROM 802_identifica i,4537_situacionActualAlumno r,4513_instanciaPlanEstudio p
				 WHERE r.situacionAlumno=1  AND p.idInstanciaPlanEstudio=r.idInstanciaPlanEstudio AND p.sede='".$plantel."' AND  i.idUsuario=r.idAlumno 
				) AS tm WHERE  nombre LIKE '%".$valorBusqueda."%'";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$descripcion="";
		$consulta="SELECT DISTINCT i.idInstanciaPlanEstudio  FROM 4537_situacionActualAlumno s,4513_instanciaPlanEstudio i WHERE idAlumno=".$fila[0]." AND situacionAlumno=1 and i.idInstanciaPlanEstudio=s.idInstanciaPlanEstudio and i.sede='".$plantel."'";
		$resInst=$con->obtenerFilas($consulta);
		while($fInst=mysql_fetch_row($resInst))
		{
			if($descripcion=="")
				$descripcion=cv(obtenerNombreInstanciaPlan($fInst[0]));
			else
				$descripcion.="<br>".cv(obtenerNombreInstanciaPlan($fInst[0]));
		}
		$obj='{"idUsuario":"'.$fila[0].'","nombre":"'.cv($fila[1]).'","descripcion":"'.$descripcion.'"}';
		if($arrRegistros=="")
			$arrRegistros=$obj;
		else
			$arrRegistros.=",".$obj;
		$numReg++;
		
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function buscarInstanciasAlumnoReinscripcion()
{
	global $con;
	$idUsuario=$_POST["idUsuario"];	
	$fechaActual=date("Y-m-d");
	$plantel=$_POST["plantel"];
	$consulta="SELECT id__692_tablaDinamica from _692_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND idEstado=2 AND  '".$fechaActual."'>=fechaInicio AND '".$fechaActual."'<=fechaTermino";
	$listConvocatorias=$con->obtenerListaValores($consulta);
	if($listConvocatorias=="")
	{
		$listConvocatorias=-1;	
	}
	
	$arrInscripciones="";
	$consulta="SELECT DISTINCT i.idInstanciaPlanEstudio,i.idPlanEstudio  FROM 4537_situacionActualAlumno s,4513_instanciaPlanEstudio i WHERE idAlumno=".$idUsuario." AND situacionAlumno=1 and i.idInstanciaPlanEstudio=s.idInstanciaPlanEstudio and i.sede='".$plantel."'";
	$resInst=$con->obtenerFilas($consulta);
	while($fInst=mysql_fetch_row($resInst))
	{
		$consulta="SELECT idAlumnoTabla,idCiclo,idPeriodo,idGrado FROM   4529_alumnos WHERE idUsuario=".$idUsuario." AND idInstanciaPlanEstudio=".$fInst[0]." and estado=2 ORDER BY idAlumnoTabla desc LIMIT 0,1";

		$fAlumno=$con->obtenerPrimeraFila($consulta);
		if($fAlumno)
		{
			$consulta="SELECT COUNT(*) FROM 4529_alumnos WHERE idUsuario=".$idUsuario." AND idInstanciaPlanEstudio=".$fInst[0]." AND estado IN (1,3) AND idAlumnoTabla>".$fAlumno[0];
			
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				
				$consulta="SELECT idPeriodo,idReferencia FROM 4578_instanciasPlanEstudiosRegistroInscripcion WHERE idFormulario=692 AND idReferencia in (".$listConvocatorias.") AND idInstanciaPlanEstudio=".$fInst[0];
				$rConv=$con->obtenerFilas($consulta);
				while($fConv=mysql_fetch_row($rConv))
				{
					$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$fConv[0];
					$periodo=$con->obtenerValor($consulta);
					$consulta="SELECT cmbCicloInscripcion,c.nombreCiclo FROM _692_tablaDinamica t,4526_ciclosEscolares c WHERE id__692_tablaDinamica=".$fConv[1]." and c.idCiclo=t.cmbCicloInscripcion";
					$fDatosConv=$con->obtenerPrimeraFila($consulta);
					$o="['".$fInst[0]."_".$fDatosConv[0]."_".$fConv[0]."','(Ciclo: ".$fDatosConv[1].", Periodo: ".$periodo.") ".cv(obtenerNombreInstanciaPlan($fInst[0]))."','".$fInst[1]."']";
					if($arrInscripciones=="")
						$arrInscripciones=$o;
					else
						$arrInscripciones.=",".$o;
				}
			}
		}
		
	}
	if($arrInscripciones=="")
		$arrInscripciones="['','No existen planes de estudios disponibles para reinscribir al alumno']";
	echo "1|[".$arrInscripciones."]";
}

function cancelarRegistroReInscripcion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$motivo=$_POST["motivo"];
	if(cambiarEtapaFormulario(910,$idRegistro,9,$motivo))
		echo "1|";
}


function obtenerPeriodosPlanEstudio()
{
	global $con;
	$idInstancia=$_POST["idInstancia"];	
	$consulta="SELECT id__464_gridPeriodos,nombrePeriodo FROM _464_gridPeriodos g,4513_instanciaPlanEstudio i WHERE 
				idReferencia= i.idPeriodicidad and i.idInstanciaPlanEstudio=".$idInstancia;
	$arrRegistros=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrRegistros;
}

function obtenerGradosPeriodosPlanEstudio()
{
	global $con;
	$idInstancia=$_POST["idInstancia"];	
	$idCiclo=$_POST["idCiclo"];	
	$idPeriodo=$_POST["idPeriodo"];	
	$consulta="SELECT g.idGrado,g.leyendaGrado FROM 4546_estructuraPeriodo e,4501_Grado g WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia." AND g.idGrado=e.idGrado ORDER BY ordenGrado";
	$arrGrados=$con->obtenerFilasArreglo($consulta);
	
	
	echo "1|".$arrGrados;
}

function obtenerProgramasEducativos()
{
	global $con;
	$idNivel=$_POST["idNivel"];
	$consulta="SELECT idProgramaEducativo,nombreProgramaEducativo FROM 4500_programasEducativos WHERE nivelProgramaEducativo=".$idNivel." AND situacion=1 ORDER BY nombreProgramaEducativo";
	$arrProgramasEducativos=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrProgramasEducativos;
	
	
	
}


function obtenerInstanciaPlanProgramaEductativo()
{
	global $con;
	$idProgramaEducativo=$_POST["idProgramaEducativo"];
	$consulta="SELECT idInstanciaPlanEstudio,CONCAT('[',IF(cvePlanEstudio IS NULL,'',cvePlanEstudio),'] ',nombrePlanEstudios) FROM 4513_instanciaPlanEstudio 
				where idPlanEstudio in (SELECT idPlanEstudio FROM 4500_planEstudio WHERE idProgramaEducativo=".$idProgramaEducativo.") ORDER BY nombrePlanEstudios";
	$arPlanesEstudios=$con->obtenerFilasArreglo($consulta);
	
	
	echo "1|".$arPlanesEstudios;
	
	
	
}
	
	
function obtenerMateriasPlanEstudioGrado()
{
	global $con;
	$idInstancia=$_POST["idInstancia"];
	$idCiclo=$_POST["idCiclo"];
	$idPeriodo=$_POST["idPeriodo"];
	$idGrado=$_POST["idGrado"];
	
	$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
	$idPlanEstudio=$con->obtenerValor($consulta);
	$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND idUnidad=".$idGrado." AND tipoUnidad=3";
	$codigoUnidad=$con->obtenerValor($consulta);
	$consulta="SELECT idUnidad FROM 4505_estructuraCurricular WHERE codigoPadre LIKE '".$codigoUnidad."%' AND idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=1";
	
	$listaMaterias=$con->obtenerListaValores($consulta);
	if($listaMaterias=="")
		$listaMaterias=-1;
	
	$registros="";
	$numReg=0;
	$arrMaterias=array();	
	$consulta="SELECT idMateria,nombreMateria,cveMateria FROM 4502_Materias WHERE idMateria IN (".$listaMaterias.") ORDER BY nombreMateria";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$consulta="SELECT idGrupos,m.nombreGrupo FROM 4520_grupos g,4540_gruposMaestros m WHERE 
				g.idMateria=".$fila[0]." AND g.idInstanciaPlanEstudio=".$idInstancia." AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." 
				AND m.idGrupoPadre=g.idGrupoPadre order by m.nombreGrupo";
		$rGrupos=$con->obtenerFilas($consulta);
		while($fGrupo=mysql_fetch_row($rGrupos))
		{
			$consulta="SELECT Nombre FROM 800_usuarios u,4519_asignacionProfesorGrupo a WHERE a.idGrupo=".$fGrupo[0]." AND a.situacion=1 AND u.idUsuario=a.idUsuario";
			$profesor=$con->obtenerValor($consulta);
			$o='{"idGrupo":"'.$fGrupo[0].'","grupo":"'.cv($fGrupo[1]).'","idMateria":"'.$fila[0].'","cveMateria":"'.cv($fila[2]).'","materia":"'.cv($fila[1]).'","profesorAsignado":"'.cv($profesor).'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	
}	

function registrarAsociacionProfesorGrupo()
{
	global $con;	
	$lGrupos=$_POST["lGrupos"];
	$idProfesor=$_POST["idProfesor"];
	
	$arrGrupos=explode(",",$lGrupos);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	foreach($arrGrupos as $g)
	{
		$query[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".date("Y-m-d")."' WHERE idGrupo=".$g;
		$x++;
		$query[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja)
					VALUES(".$g.",".$idProfesor.",37,0,1,1,'".date("Y-m-d")."',NULL)";
		$x++;
	}
	$query[$x]="commit";
	$x++;
	eB($query);
}

function registrarReemplazoProfesorGrupo()
{
	global $con;	
	$lGrupos=$_POST["lGrupos"];
	$idProfesor=$_POST["idProfesor"];
	$motivo=$_POST["motivo"];
	$arrGrupos=$lGrupos;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="set @idAsignacion:=(if((select idAsignacionProfesorGrupo from 4519_asignacionProfesorGrupo where idGrupo=".$lGrupos." and situacion=1) is null,
			-1,(select idAsignacionProfesorGrupo from 4519_asignacionProfesorGrupo where idGrupo=".$lGrupos." and situacion=1)))";
	$x++;
	$query[$x]="UPDATE 4519_asignacionProfesorGrupo SET situacion=0,fechaBaja='".date("Y-m-d")."' WHERE idAsignacionProfesorGrupo=@idAsignacion";
	$x++;
	
	
	$query[$x]="INSERT INTO 4519_bajasProfesorGrupo(idAsignacion,fechaBaja,idResponsable,motivo)
				 VALUES(@idAsignacion,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($motivo)."')";
	$x++;
	
	if($idProfesor!=-1)
	{
		$query[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja)
					VALUES(".$lGrupos.",".$idProfesor.",37,0,1,1,'".date("Y-m-d")."',NULL)";
		$x++;
	}
	$query[$x]="commit";
	$x++;
	eB($query);
}

function obtenerGruposDiponiblesCiclo()
{
	global $con;
	$idInstancia=$_POST["idInstancia"];
	$idCiclo=$_POST["idCiclo"];
	$idPeriodo=$_POST["idPeriodo"];
	$idGrado=$_POST["idGrado"];
	
	$tipoGrupos="1,2";
	if(isset($_POST["tipoGrupo"]))
		$tipoGrupos=$_POST["tipoGrupo"];
	
	
	$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE idGrado=".$idGrado." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia;
	$idGradoCiclo=$con->obtenerValor($consulta);
	if($idGradoCiclo=="")
		$idGradoCiclo=-1;
	
	$registros="";
	$numReg=0;	
	$consulta="SELECT idGrupoPadre,nombreGrupo,tipoGrupo FROM 4540_gruposMaestros WHERE idGradoCiclo=".$idGradoCiclo." and tipoGrupo in (".$tipoGrupos.") ORDER BY nombreGrupo";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		switch($fila[2])	
		{
			case 1:
				$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."']";
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
					
			break;
			case 2:
				$consulta="SELECT idGrupos,g.idMateria,m.nombreMateria FROM 4520_grupos g,4502_Materias m WHERE g.idGrupoPadre=".$fila[0]." AND g.situacion=1 AND m.idMateria=g.idMateria ORDER BY m.nombreMateria";
				$rMat=$con->obtenerFilas($consulta);
				while($fMat=mysql_fetch_row($rMat))
				{
					$o="['".$fMat[0]."','".cv($fMat[2])." (".cv($fila[1]).")"."','".$fila[2]."']";
					if($registros=="")
						$registros=$o;
					else
						$registros.=",".$o;
				}
	
			break;	
		}
	}
	
	echo "1|[".$registros."]";
	
		
}

function obtenerListadoAlumnosGruposCiclo()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$tipoGrupo=$_POST["tipoGrupo"];
	
	
	$consulta="";
	
	switch($tipoGrupo)
	{
		case 1:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.estado,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo FROM 4529_alumnos a,802_identifica i WHERE idGrupo= ".$idGrupo." and i.idUsuario=a.idUsuario order by i.Paterno,i.Materno,i.Nom";
		break;
		case 2:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.situacion,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo  FROM 4517_alumnosVsMateriaGrupo a,802_identifica i 
						WHERE idGrupo=".$idGrupo." and i.idUsuario=a.idUsuario order by i.Paterno,i.Materno,i.Nom";
		break;
	}
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT id__1047_tablaDinamica FROM _1047_tablaDinamica WHERE idUsuario=".$fila[0];
		$idRegistroFicha=$con->obtenerValor($consulta);
		if($idRegistroFicha=="")
			$idRegistroFicha=-1;
			
		$datosBaja="";
		if($fila[4]==0)	
		{
			$consulta="SELECT fechaOperacion,comentarios FROM 4529_bitacoraSituacionAlumno WHERE idAlumno=".$fila[0]." AND situacioncambio=0 ORDER BY idRegistro DESC LIMIT 0,1";
			$fBaja=$con->obtenerprimeraFila($consulta);	
			
			if($fBaja)
			{
				$datosBaja=	"Baja registrada el d&iacute;a: ".date("d/m/Y",strtotime($fBaja[0])).", Motivo: ".$fBaja[1];
			}
		}
			
		$o='{"grupo":"'.$fila[5].'","datosBaja":"'.cv($datosBaja).'","idRegistroFicha":"'.$idRegistroFicha.'","idAlumno":"'.$fila[0].'","apPaterno":"'.cv($fila[1]).'","apMaterno":"'.cv($fila[2]).'","nombre":"'.cv($fila[3]).'","situacion":"'.$fila[4].'"}';
		if($registros=="")	
			$registros=$o;
		else
			$registros.=",".$o;
		$numReg++;
	}
		
	echo '{"numReg":"","registros":['.$registros.']}';	
		
	
	
}


function registrarInscripcionAlumnoGrupo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	if($obj->tipoGrupo==1)
	{
		$consulta="SELECT * FROM 4529_alumnos WHERE idUsuario=".$obj->idUsuario." AND idCiclo=".$obj->idCiclo." AND idPeriodo=".$obj->idPeriodo;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		if($fRegistro)
		{
			$consulta="SELECT grado FROM 4501_Grado WHERE idGrado=".$fRegistro[4];
			$grado=$con->obtenerValor($consulta);
			
			echo "El alumno ya se encuentra inscrito en el Grado: <b>".$grado."</b>, Grupo: <b>".$grupo."</b>  durante este ciclo";	
		}
		
	}
	
	
	
}


function reactivarAlumno()
{
	global $con;
	$idAlumno=$_POST["idAlumno"];
	
	$x=0;
	$query[$x]="begin"	;
	$x++;
	$query[$x]="UPDATE 4529_alumnos SET estado=1 WHERE idUsuario=".$idAlumno;
	$x++;
	$query[$x]="UPDATE 4517_alumnosVsMateriaGrupo SET situacion=1 WHERE idUsuario=".$idAlumno." AND situacion=0";
	$x++;
	$query[$x]="INSERT INTO 4529_bitacoraSituacionAlumno(idAlumno,fechaOperacion,idResponsableOperacion,comentarios,situacionCambio)
				VALUES(".$idAlumno.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'',1)";
	$x++;
	$query[$x]="commit"	;
	$x++;
	eB($query);
}


function registrarBajaAlumnoInscripcion()
{
	global $con;
	$idAlumno=$_POST["idAlumno"];
	$motivo=$_POST["motivo"];
	
	$x=0;
	$query[$x]="begin"	;
	$x++;
	$query[$x]="UPDATE 4529_alumnos SET estado=0 WHERE idUsuario=".$idAlumno;
	$x++;
	$query[$x]="UPDATE 4517_alumnosVsMateriaGrupo SET situacion=0 WHERE idUsuario=".$idAlumno." AND situacion=1";
	$x++;
	$query[$x]="INSERT INTO 4529_bitacoraSituacionAlumno(idAlumno,fechaOperacion,idResponsableOperacion,comentarios,situacionCambio)
				VALUES(".$idAlumno.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($motivo)."',0)";
	$x++;
	$query[$x]="commit"	;
	$x++;
	eB($query);
}

function obtenerListadoAlumnosGruposCicloCalificacion()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$tipoGrupo=$_POST["tipoGrupo"];
	$bimestre=$_POST["bimestre"];
	
		
	$consulta="";
	$registros="";
	switch($tipoGrupo)
	{
		case 1:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.estado,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g 
					WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo FROM 4529_alumnos a,802_identifica i WHERE idGrupo= ".abs($idGrupo)." and i.idUsuario=a.idUsuario and a.estado=1 order by grupo,i.Paterno,i.Materno,i.Nom";
		break;
		case 2:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.situacion,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo  
						FROM 4517_alumnosVsMateriaGrupo a,802_identifica i 	WHERE idGrupo=".abs($idGrupo)." and i.idUsuario=a.idUsuario and a.situacion=1 order by grupo,i.Paterno,i.Materno,i.Nom";
		break;
	}
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT noFaltas,calificacion,observaciones,matematicas,analiza,sintetiza,utiliza,lectura,escritura FROM 3010_calificacionesListado WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bimestre=".$bimestre;
		
		$fCalificacion=$con->obtenerPrimeraFila($consulta);
		
		$o='{"grupo":"'.$fila[5].'","idAlumno":"'.$fila[0].'","nombreAlumno":"'.cv($fila[1]." ".$fila[2]." ".$fila[3]).'","calificacion":"'.$fCalificacion[1].'","noFaltas":"'.
			$fCalificacion[0].'","observaciones":"'.cv(str_replace("<br />","\r\n",$fCalificacion[2])).'","matematicas":"'.cv(str_replace("<br />","\r\n",$fCalificacion[3])).
			'","analiza":"'.$fCalificacion[4].'","sintetiza":"'.$fCalificacion[5].'","utiliza":"'.$fCalificacion[6].'","lectura":"'.cv(str_replace("<br />","\r\n",$fCalificacion[7])).
			'","escritura":"'.cv(str_replace("<br />","\r\n",$fCalificacion[8])).'"}';
		if($registros=="")	
			$registros=$o;
		else
			$registros.=",".$o;
		$numReg++;
	}
		
	echo '{"numReg":"","registros":['.$registros.']}';	
		
	
	
}


function obtenerMateriasGrupoPadre()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$consulta="SELECT idGrupos,nombreMateria,m.idMateria FROM 4520_grupos g,4502_Materias m WHERE idGrupoPadre=".$idGrupo." AND m.idMateria=g.idMateria ORDER BY nombreMateria";
	$arrMaterias=$con->obtenerFilasArreglo($consulta);	
	echo "1|".$arrMaterias;
}

function registrarCalificacionAlumnoListado()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$bimestre=$_POST["bimestre"];
	$idAlumno=$_POST["idAlumno"];
	$valor=$_POST["valor"];
	$campo=$_POST["campo"];
	$consulta="SELECT idCiclo,idMateria FROM 4520_grupos WHERE idGrupos=".abs($idGrupo);
	$fGpo=$con->obtenerPrimeraFila($consulta);
	$consulta="select *  FROM 3010_calificacionesListado WHERE idAlumno=".$idAlumno." AND idGrupo=".$idGrupo." AND bimestre=".$bimestre;

	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if($fRegistro)
	{
		$consulta="UPDATE 3010_calificacionesListado SET ".$campo."='".cv($valor)."' WHERE idRegistro=".$fRegistro[0];
	}
	else
	{
		$consulta="INSERT INTO 3010_calificacionesListado(idGrupo,idAlumno,bimestre,idCiclo,idMateria,".$campo.") VALUES(".$idGrupo.",".$idAlumno.",".$bimestre.",".$fGpo[0].",".$fGpo[1].",'".cv($valor)."')";
	}
	
	eC($consulta);
	
	
}


function obtenerListadoAlumnosGruposCicloCalificacionRecuperacion()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$tipoGrupo=$_POST["tipoGrupo"];
	$bimestre=$_POST["bimestre"];
	
		
	$consulta="";
	
	switch($tipoGrupo)
	{
		case 1:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.estado,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g 
					WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo FROM 4529_alumnos a,802_identifica i WHERE idGrupo= ".abs($idGrupo)." and i.idUsuario=a.idUsuario and a.estado=1 order by grupo,i.Paterno,i.Materno,i.Nom";
		break;
		case 2:
			$consulta="SELECT i.idUsuario,i.Paterno,i.Materno,i.Nom,a.situacion,(SELECT g.nombreGrupo FROM 4529_alumnos a,4540_gruposMaestros g WHERE idUsuario=i.idUsuario AND g.idGrupoPadre=a.idGrupo) as grupo  
						FROM 4517_alumnosVsMateriaGrupo a,802_identifica i 	WHERE idGrupo=".abs($idGrupo)." and i.idUsuario=a.idUsuario and a.situacion=1 order by grupo,i.Paterno,i.Materno,i.Nom";
		break;
	}
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT calificacion FROM 3010_calificacionesListado WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bimestre=".$bimestre;
		
		$fCalificacion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT calificacion FROM 3010_calificacionesListadoRecuperacion WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bimestre=".$bimestre;
		
		$fCalificacionRecuperacion=$con->obtenerPrimeraFila($consulta);
		
		
		$o='{"grupo":"'.$fila[5].'","idAlumno":"'.$fila[0].'","nombreAlumno":"'.cv($fila[1]." ".$fila[2]." ".$fila[3]).'","calificacionOrdinal":"'.$fCalificacion[0].'","calificacionRecuperacion":"'.$fCalificacionRecuperacion[0].'"}';
		if($registros=="")	
			$registros=$o;
		else
			$registros.=",".$o;
		$numReg++;
	}
		
	echo '{"numReg":"","registros":['.$registros.']}';	
		
	
	
}

function registrarCalificacionAlumnoListadoRecuperacion()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$bimestre=$_POST["bimestre"];
	$idAlumno=$_POST["idAlumno"];
	$valor=$_POST["valor"];
	$campo=$_POST["campo"];
	$consulta="SELECT idCiclo,idMateria FROM 4520_grupos WHERE idGrupos=".$idGrupo;
	$fGpo=$con->obtenerPrimeraFila($consulta);
	$consulta="select *  FROM 3010_calificacionesListadoRecuperacion WHERE idAlumno=".$idAlumno." AND idGrupo=".$idGrupo." AND bimestre=".$bimestre;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if($fRegistro)
	{
		$consulta="UPDATE 3010_calificacionesListadoRecuperacion SET calificacion='".cv($valor)."' WHERE idRegistro=".$fRegistro[0];
	}
	else
	{
		$consulta="INSERT INTO 3010_calificacionesListadoRecuperacion(idGrupo,idAlumno,bimestre,calificacion,idCiclo,idMateria) VALUES(".$idGrupo.",".$idAlumno.",".$bimestre.",'".cv($valor)."',".$fGpo[0].",".$fGpo[1].")";
	}
	
	eC($consulta);
	
	
}

function obtenerHorasMateriaPlanEstudios()
{
	global $con;
	$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
	$idMateria=$_POST["idMateria"];

	$arrRegistros="";
	
	$consulta="SELECT horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,horasSemana FROM 4502_Materias  WHERE idMateria=".$idMateria;
	$fMateria=$con->obtenerPrimeraFila($consulta);
	
	$o='{"id":"0","tipo":"0","totalHorasTeoricas":"'.$fMateria[1].'","totalHorasPracticas":"'.$fMateria[2].'","totalHorasIndependientes":"'.$fMateria[3].
		'","totalHorasMateria":"'.$fMateria[0].'","totalHorasPorSemana":"'.$fMateria[4].'","ambito":"1.- Global (Configuraci&oacute;n de Plan de Estudio)","periodo":"N/A"}';
	if($arrRegistros=="")
		$arrRegistros=$o;
	else
		$arrRegistros.=",".$o;
	
	$consulta="select * from 4502_configuracionesAvanzadasMateria where idMateria=".$idMateria." and idInstanciaPlanEstudio=".$idInstanciaPlanEstudio." and situacion=1";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o='{"id":"'.$fila[0].'","tipo":"1","totalHorasTeoricas":"'.$fila[6].'","totalHorasPracticas":"'.$fila[7].'","totalHorasIndependientes":"'.$fila[8].
		'","totalHorasMateria":"'.$fila[10].'","totalHorasPorSemana":"'.$fila[3].
		'","ambito":"2.- Configuraci&oacute;n de Instancia de Plan de Estudio","periodo":"'.$fila[4].'","ciclo":"'.$fila[5].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	echo '{"numReg":"0","registros":['.$arrRegistros.']}';
}

function registrarHorasMateriaPlanEstudios()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="";
	if($obj->id==-1)
	{
		$consulta="INSERT INTO 4502_configuracionesAvanzadasMateria(idMateria,idInstanciaPlanEstudio,noHorasSemana,
					idPeriodo,idCiclo,totalHorasTeoricas,totalHorasPracticas,totalHorasIndepencientes,totalHorasMateria,situacion)
					VALUES(".$obj->idMateria.",".$obj->idInstanciaPlanEstudio.",".$obj->tHSemana.",".$obj->periodo.",".$obj->ciclo.
					",".$obj->tHTeoricas.",".$obj->tHPracticas.",".$obj->tHIndependientes.",".$obj->tHMateria.",1)";
	}
	else
	{
		$consulta="update 4502_configuracionesAvanzadasMateria set noHorasSemana=".$obj->tHSemana.",
					idPeriodo=".$obj->periodo.",idCiclo=".$obj->ciclo.",totalHorasTeoricas=".$obj->tHTeoricas.",totalHorasPracticas=".$obj->tHPracticas.",totalHorasIndepencientes=".$obj->tHIndependientes.
					",totalHorasMateria=".$obj->tHMateria." where idRegistro=".$obj->id;
	}
	eC($consulta);
	
}

function registrarBajaConfiguracionBajaHorasMateria()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	
	
	$consulta="UPDATE 4502_configuracionesAvanzadasMateria SET situacion=0,fechaCambioSituacion='".date("Y-m-d H:i:s")."',idResponsableCambioSituacion=".$_SESSION["idUsr"]." WHERE
			idRegistro=".$idRegistro;
			
	eC($consulta);			
	
	
}


function deshabilitarInstanciaPlanEstudio()
{
	global $con;
	$idInstanciaPlanEstudio=$_POST["idInstanciaPlanEstudio"];
	$consulta="UPDATE 4513_instanciaPlanEstudio SET situacion=2 WHERE idInstanciaPlanEstudio=".$idInstanciaPlanEstudio;
	eC($consulta);
	
}

function obtenerPeriodoCicloPlanEstudio()
{
	global $con;
	$idCiclo=$_POST["idCiclo"];
	$plantel=$_POST["plantel"];
	
	$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$plantel."' AND situacion=1";
	$listaInstancias=$con->obtenerListaValores($consulta);
	if($listaInstancias=="")
		$listaInstancias=-1;
	
	$consulta="SELECT DISTINCT idPeriodo FROM 4546_estructuraPeriodo WHERE idInstanciaPlanEstudio IN (".$listaInstancias.") AND idCiclo=".$idCiclo;
	$listaPeriodos=$con->obtenerListaValores($consulta);
	if($listaPeriodos=="")	
		$listaPeriodos=-1;
	$consulta="SELECT id__464_gridPeriodos,CONCAT(nombrePeriodo,'( Periodicidad: ',tp.txtDescripcion,')') FROM _464_gridPeriodos p,_464_tablaDinamica tp WHERE id__464_gridPeriodos IN (".$listaPeriodos.")
				AND  p.idReferencia=tp.id__464_tablaDinamica ORDER BY tp.txtDescripcion,nombrePeriodo";
				
	$arrPeriodos=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrPeriodos."";
	
}


function obtenerEstructurasAcademicasAutorizar()
{
	global $con;
	$idCiclo=$_POST["idCiclo"];
	$idPeriodo=$_POST["idPeriodo"];
	$plantel=$_POST["plantel"];
	$vistaSolicitud=0;
	if(isset($_POST["vistaSolicitud"]))
		$vistaSolicitud=1;
	
	
	if($idPeriodo=="")
	{
		echo "[]";
		return;
	}
	$arrRegistros="";
	$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$plantel."' AND situacion=1 order by nombrePlanEstudios";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrHijos=obtenerPeriodosActivosPlanEstudio($fila[0],$idCiclo,$idPeriodo,$vistaSolicitud);
		if($arrHijos!="[]")
		{
			$id="0_".$fila[0];
			
			$input='<input type=\'checkbox\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\' name=\'chkInput\'> ';
			if($vistaSolicitud==0)
				$input="";
			$o='{"TG":"","TGSP":"","TGSH":"","icono":"","expanded":true,"id":"'.$id.'","text":"<span title=\"'.cv(obtenerNombreInstanciaPlan($fila[0])).'\" alt=\"'.cv(obtenerNombreInstanciaPlan($fila[0])).
				'\">'.$input.'<b>'.
				cv(obtenerNombreInstanciaPlan($fila[0])).'</b></span>",leaf:false, children:'.$arrHijos.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	echo '['.$arrRegistros.']';
}

function obtenerPeriodosActivosPlanEstudio($idInstancia,$idCiclo,$idPeriodo,$vistaSolicitud)
{
	global $con;
	$consulta="SELECT DISTINCT idPeriodo FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo IN (".$idPeriodo.") AND idInstanciaPlanEstudio=".$idInstancia;
	$listaPeriodos=$con->obtenerListaValores($consulta);
	if($listaPeriodos=="")
		$listaPeriodos=-1;
	
	$arrRegistros="";
	$consulta="SELECT id__464_gridPeriodos,CONCAT(nombrePeriodo,' (Periodicidad: ',tp.txtDescripcion,')') FROM _464_gridPeriodos p,_464_tablaDinamica tp 
				WHERE id__464_gridPeriodos IN (".$listaPeriodos.") AND  p.idReferencia=tp.id__464_tablaDinamica ORDER BY tp.txtDescripcion,nombrePeriodo";
				
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$arrHijos=obtenerGradosPeriodosActivosPlanEstudio($idInstancia,$idCiclo,$fila[0],$vistaSolicitud);
		if($arrHijos!="[]")
		{
			$id="1_".$fila[0]."_".$idInstancia;
			
			$input='<input type=\'checkbox\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\' name=\'chkInput\'> ';
			if($vistaSolicitud==0)
				$input="";
			
			$o='{"TG":"","TGSP":"","TGSH":"","icono":"","expanded":true,"id":"'.$id.'","text":"<span title=\"'.cv($fila[1]).'\" alt=\"'.cv($fila[1]).'\" style=\"color:#900\">'.$input.
				cv($fila[1]).'</span>",leaf:false,children:'.$arrHijos.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
				
				
	return '['.$arrRegistros.']';
	
	
}

function obtenerGradosPeriodosActivosPlanEstudio($idInstancia,$idCiclo,$idPeriodo,$vistaSolicitud)
{
	global $con;
	$arrRegistros="";
	
	$consulta="SELECT sede FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
	$plantel=$con->obtenerValor($consulta);

	
	$consulta="SELECT situacion FROM 4547_situacionInstanciaPlan WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." 
					AND plantel='".$plantel."' AND situacion=1  ORDER BY idSituacionPlanEstudio DESC";

	$situacionPlantel=$con->obtenerValor($consulta);
	if($situacionPlantel=="")
		$situacionPlantel=0;
	
	
	$consulta="SELECT e.idGrado,g.leyendaGrado,e.idEstructuraPeriodo,g.ordenGrado FROM 4546_estructuraPeriodo e, 4501_Grado g 
				WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo.
				" AND idInstanciaPlanEstudio=".$idInstancia." and g.idGrado=e.idGrado order by g.ordenGrado";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$id='2_'.$fila[2].'_'.$idInstancia.'_'.$idPeriodo;
		$icono="";
		
		
		
		
		$consulta="SELECT dictamen,idSolicitud FROM 4615_gradosSolicitudAutorizacionEstructura g  WHERE idGradoEstructura=".$fila[2]." ORDER BY idRegistro DESC";
		$fDictamen=$con->obtenerPrimeraFila($consulta);
		$dictamen=$fDictamen[0];
		if(($dictamen!="")||($situacionPlantel==1))
		{
			if($situacionPlantel==1)
			{
				$dictamen=1;
			}
			else
			{
				$consulta="SELECT situacion FROM 4614_cabeceraSolicitudAutorizacionEstructura WHERE idRegistro=".$fDictamen[1];
				$sDictamen=$con->obtenerValor($consulta);
				if($sDictamen==1)
				{
					$dictamen=0;
				}
			}
			switch($dictamen)
			{
				case 0:
					$icono="<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n'>";
				break;
				case 1:
					$icono="<img src='../images/accept_green.png' title='Autorizado' alt='Autorizado'>";
				break;
				case 2:
					$icono="<img src='../images/cancel_round.png' title='Rechazado' alt='Rechazado'>";
				break;
			}
			if($situacionPlantel==0)
			{
				$consulta="SELECT COUNT(g.comentariosDictamen) FROM 4615_gradosSolicitudAutorizacionEstructura g,4614_cabeceraSolicitudAutorizacionEstructura s 
						WHERE g.idGradoEstructura=".$fila[2]." and g.dictamen<>0 AND TRIM(g.comentariosDictamen)!='' and s.idRegistro=g.idSolicitud and s.situacion=2";
				$nRegistroComentarios=$con->obtenerValor($consulta);
				if($nRegistroComentarios>0)
				{
					$icono.="&nbsp;<span onClick='javascript:mostrarComentariosGrado(\\\"".bE($fila[2])."\\\",\\\"".bE($fila[1])."\\\")'><img src='../images/icon_comment.gif' title='Este grado presenta ".($nRegistroComentarios==1?'1 comentario':$nRegistroComentarios." comentarios")."' alt='Este grado presenta ".($nRegistroComentarios==1?'1 comentarios':$nRegistroComentarios." comentarios")."'></span>";
				}
			}
			if($vistaSolicitud==1)
			{
				if(($dictamen==0)||($dictamen==1))
				{
					continue;
				}
			}
		}
		
		$input='<input type=\'checkbox\'  gradoOrdinal=\''.$fila[3].'\' name=\'chkInput\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\'> ';
		if($vistaSolicitud==0)
			$input="";
		
		$TG=0;
		$TGSP=0;
		$TGSH=0;
		
		$listaProfesoresSG="";
		$listaGruposSH="";
		
		$consulta="SELECT idGrupos FROM 4520_grupos WHERE idGradoCiclo=".$fila[2]." AND situacion=1";
		$listaGrupos=$con->obtenerListaValores($consulta);
		
		if($listaGrupos!="")
		{
			$TG='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaGrupos).'\",\"'.bE("Grupos aperturados").'\")\'>'.$con->filasAfectadas.'</span>';
			
			
			$arrGrupos=explode(",",$listaGrupos);
			foreach($arrGrupos as $g)
			{
				$consulta="SELECT COUNT(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo =".$g." AND fechaAsignacion<=fechaBaja";
				$nProfesor=$con->obtenerValor($consulta); 
				if($nProfesor==0)
				{
					$TGSP++;
					if($listaProfesoresSG=="")
						$listaProfesoresSG=$g;
					else
						$listaProfesoresSG.=",".$g;
				}
				
				
				$arrDatosMateria=obtenerDatosMateriaHorasGrupo($g);
				$hSemanas=$arrDatosMateria["horasSemana"];
				$hAsignadas=obtenerHorasAsignadasGrupo($g);
				if($hAsignadas<$hSemanas)
				{
					$TGSH++;
					if($listaGruposSH=="")
						$listaGruposSH=$g;
					else
						$listaGruposSH.=",".$g;
				}
				
				
			}
			
			if($TGSP>0)
				$TGSP='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaProfesoresSG).'\",\"'.bE("Grupos aperturados sin profesor asignado").'\")\'>'.$TGSP.'</span>';
			if($TGSH>0)
				$TGSH='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaGruposSH).'\",\"'.bE("Grupos aperturados sin horario completo asignado").'\")\'>'.$TGSH.'</span>';
		}
		
		$o='{"TG":"'.$TG.'","TGSP":"'.$TGSP.'","TGSH":"'.$TGSH.'","icono":"'.$icono.'","id":"'.$id.'","text":"<span title=\"'.cv($fila[1]).'\" alt=\"'.cv($fila[1]).'\">'.$input.
			cv($fila[1]).'</span>",leaf:true}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
	}
				
				
	return '['.$arrRegistros.']';
	
	
}


function registrarSolicitudAutorizacionestructura()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	$consulta[$x]="INSERT INTO 4614_cabeceraSolicitudAutorizacionEstructura(idCiclo,comentarios,fechaEnvio,plantel,idResponsableEnvio,situacion)
				VALUES(".$obj->idCiclo.",'".cv($obj->comentarios)."','".date("Y-m-d H:i:s")."','".$obj->plantel."',".$_SESSION["idUsr"].",1)";

	$x++;
	$consulta[$x]="set @idRegistro:=(select last_insert_id())";
	$x++;
	$arrGrados=explode(",",$obj->arrGrados);
	foreach($arrGrados as $g)
	{
		$consulta[$x]="INSERT INTO 4615_gradosSolicitudAutorizacionEstructura(idSolicitud,idGradoEstructura,dictamen) VALUES(@idRegistro,".$g.",0)";
		$x++;
	}
	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
	
	
}


function obtenerSolicitudesAutorizacionEstructura()
{
	global $con;
	$idCiclo=$_POST["idCiclo"];
	$plantel=$_POST["plantel"];
	$situacion=$_POST["situacion"];
	
	$vistaSolicitud=0;
	if(isset($_POST["vS"]))
		$vistaSolicitud=1;
	
	
	if(($vistaSolicitud==1)&&($situacion==1))
		$situacion.=" or vistoResponsable=0";
	
	$condAux="";
	if($plantel!=0)
		$condAux=" and plantel='".$plantel."'";
	$cadRegistros="";
	$numReg=0;
	$consulta="SELECT idRegistro,fechaEnvio,plantel,idResponsableEnvio,situacion,resultadoDictamen,fechaDictamen,idResponsableDictamen,comentariosDictamen,vistoResponsable 
				FROM 4614_cabeceraSolicitudAutorizacionEstructura where  idCiclo=".$idCiclo." and (situacion=".$situacion.")".$condAux." ORDER BY fechaEnvio";

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrRegistros=array();
		
		$consulta="SELECT e.idEstructuraPeriodo,idInstanciaPlanEstudio,gr.leyendaGrado,CONCAT(gp.nombrePeriodo,' (Periodicidad: ',tP.txtDescripcion,')'),e.idPeriodo,gr.ordenGrado,g.dictamen, g.comentariosDictamen,e.comentario
					FROM 4615_gradosSolicitudAutorizacionEstructura g,4546_estructuraPeriodo e,4501_Grado gr,_464_tablaDinamica tP, _464_gridPeriodos gp
					WHERE g.idSolicitud=".$fila[0]." AND g.idGradoEstructura=e.idEstructuraPeriodo AND gr.idGrado=e.idGrado 
					AND gp.id__464_gridPeriodos=e.idPeriodo AND tP.id__464_tablaDinamica=gp.idReferencia
					ORDER BY idInstanciaPlanEstudio,gp.nombrePeriodo,tP.txtDescripcion,gr.ordenGrado";
		$resSolicitud=$con->obtenerFilas($consulta);
		while($filaSolicitud=mysql_fetch_row($resSolicitud))
		{
			$llave=obtenerNombreInstanciaPlan($filaSolicitud[1])."@_@".$filaSolicitud[1];
			if(!isset($arrRegistros[$llave]))
				$arrRegistros[$llave]=array();
			
			$llave2="1@_@".$filaSolicitud[4]."@_@".$filaSolicitud[3];
			if(!isset($arrRegistros[$llave][$llave2]))
				$arrRegistros[$llave][$llave2]=array();
			
			$oG["periodo"]=$filaSolicitud[3];
			$oG["idGrado"]=$filaSolicitud[0];
			$oG["grado"]=$filaSolicitud[2];
			$oG["gradoOrdinal"]=$filaSolicitud[5];
			$oG["dictamen"]=$filaSolicitud[6];
			$oG["comentarios"]=str_replace("<br />","\\r",cv($filaSolicitud[7]));
			array_push($arrRegistros[$llave][$llave2],$oG);
				
		}
		ksort($arrRegistros);
		
		$tblDatosSolicitud="<table>";
		foreach($arrRegistros as $llave=>$resto)
		{
			$arrDatos=explode("@_@",$llave);
			$tblDatosSolicitud.="<tr><td><span style='color:#900'><b>".cv($arrDatos[0])."</b></span></td></tr>";	
			$tblDatosSolicitud.="<tr><td><table>";
			foreach($resto as $periodos)
			{
				foreach($periodos as $g)
				{
					$consulta="SELECT dictamen FROM 4615_gradosSolicitudAutorizacionEstructura WHERE idSolicitud=".$fila[0]." AND idGradoEstructura=".$g["idGrado"];
					$fDictamen=$con->obtenerPrimeraFila($consulta);
					$iconoDictamen="";
					$iconoComentarios="";
					
					if(($fila[4]==1)&&($vistaSolicitud==1))
					{
						$fDictamen[0]=0;
					}
					
					switch($fDictamen[0])
					{
						case 0:
							$iconoDictamen="<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n'>";
						break;
						case 1:
							$iconoDictamen="<img src='../images/accept_green.png' title='Autorizado' alt='Autorizado'>";
						break;
						case 2:
							$iconoDictamen="<img src='../images/cancel_round.png' title='Rechazado' alt='Rechazado'>";
						break;
					}
					
					$iconoComentarios="";
					
					$consulta="SELECT COUNT(g.comentariosDictamen) FROM 4615_gradosSolicitudAutorizacionEstructura g,4614_cabeceraSolicitudAutorizacionEstructura s 
							WHERE idGradoEstructura=".$g["idGrado"]." and g.dictamen<>0 AND TRIM(g.comentariosDictamen)!='' and s.idRegistro=g.idSolicitud and s.situacion=2";
					
					$nRegistroComentarios=$con->obtenerValor($consulta);
					if($nRegistroComentarios>0)
					{
						$iconoComentarios="&nbsp;<a href='javascript:mostrarComentariosGrado(\\\"".bE($g["idGrado"])."\\\",\\\"".bE($g["grado"])."\\\")'><img src='../images/icon_comment.gif' title='Este grado presenta ".($nRegistroComentarios==1?'1 comentario':$nRegistroComentarios." comentarios")."' alt='Este grado presenta ".($nRegistroComentarios==1?'1 comentarios':$nRegistroComentarios." comentarios")."'></a>";
					}
					
					
					$tblDatosSolicitud.="<tr><td width='30'></td><td width='40'>".$iconoDictamen.$iconoComentarios."</td><td>".$g["grado"]."</td><td width='20'></td><td><b>Periodo:</b>".$g["periodo"]."</td></tr>";
				}
			}
			
			if($fila[4]==2)
			{
				
				if(trim($fila[8])=="")
					$fila[8]="(Sin comentarios)";
				$tblDatosSolicitud.="<tr><td></td><td colspan='3'><br><b>Comentarios finales del evaluador:</b></td></tr><tr><td></td><td colspan='3' style='text-align:justify'><br>".cv($fila[8])."</td></tr>";
			}
			
			$tblDatosSolicitud.="</table></td></tr>";
			
		}
		$tblDatosSolicitud.="</table>";		
		
		$o='{"visualizado":"'.$fila[9].'","tblDatosSolicitud":"'.$tblDatosSolicitud.'","idSolicitud":"'.str_pad($fila[0],7,"0",STR_PAD_LEFT).'","fechaSolicitud":"'.$fila[1].
			'","plantel":"'.$fila[2].'","solicitadoPor":"'.obtenerNombreUsuario($fila[3]).'","situacionSolicitud":"'.$fila[4].
			'","fechaDictamen":"'.$fila[6].'","dictaminadoPor":"'.(($fila[7]!="")?obtenerNombreUsuario($fila[7]):"").'","resultadoDictamen":"'.
			$fila[5].'","comentariosDictamen":"'.cv($fila[8]).'"}';		


		if($cadRegistros=="")
			$cadRegistros=$o;
		else
			$cadRegistros.=",".$o;
		$numReg++;
		
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
}

function obtenerGradosEstructuraSolicitudesAutorizacion()
{
	global $con;
	$idSolicitud=$_POST["idSolicitud"];
	
	$arrRegistros=array();
	
	$consulta="SELECT e.idEstructuraPeriodo,idInstanciaPlanEstudio,gr.leyendaGrado,CONCAT(gp.nombrePeriodo,' (Periodicidad: ',tP.txtDescripcion,')'),e.idPeriodo,gr.ordenGrado,g.dictamen, g.comentariosDictamen
				FROM 4615_gradosSolicitudAutorizacionEstructura g,4546_estructuraPeriodo e,4501_Grado gr,_464_tablaDinamica tP, _464_gridPeriodos gp
				WHERE g.idSolicitud=".$idSolicitud." AND g.idGradoEstructura=e.idEstructuraPeriodo AND gr.idGrado=e.grado 
				AND gp.id__464_gridPeriodos=e.idPeriodo AND tP.id__464_tablaDinamica=gp.idReferencia
				ORDER BY idInstanciaPlanEstudio,gp.nombrePeriodo,tP.txtDescripcion,gr.ordenGrado";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$llave=obtenerNombreInstanciaPlan($fila[1])."@_@".$fila[1];
		if(!isset($arrRegistros[$llave]))
			$arrRegistros[$llave]=array();
		
		
		$llave2="1@_@".$fila[4]."@_@".$fila[3];
		if(!isset($arrRegistros[$llave][$llave2]))
			$arrRegistros[$llave][$llave2]=array();
		
		
		$o["periodo"]=$fila[3];
		$o["idGrado"]=$fila[0];
		$o["grado"]=$fila[2];
		$o["gradoOrdinal"]=$fila[5];
		$o["dictamen"]=$fila[6];
		$o["comentarios"]=str_replace("<br />","\\r",cv($fila[7]));
		
		array_push($arrRegistros[$llave][$llave2],$o);
			
			
			
	}
	ksort($arrRegistros);
	
	
	$cRegistros="";
	
	foreach($arrRegistros as $instanciaPlan=>$resto)
	{
		$arrHijos="";
		$arrDatosInstancia=explode("@_@",$instanciaPlan);
		foreach($resto as $periodo=>$resto2)
		{
			$arrHijosGrados="";
			$arDatosPeriodo=explode("@_@",$periodo);
			foreach($resto2 as $grado)
			{
				$icono="";
				switch($grado["dictamen"])
				{
					case 0:
						$icono="<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n'>";
					break;
					case 1:
						$icono="<img src='../images/accept_green.png' title='Autorizado' alt='Autorizado'>";
					break;
					case 2:
						$icono="<img src='../images/cancel_round.png' title='Rechazado' alt='Rechazado'>";
					break;
				}
				
				
				$TG=0;
				$TGSP=0;
				$TGSH=0;
				
				$listaProfesoresSG="";
				$listaGruposSH="";
				
				$consulta="SELECT idGrupos FROM 4520_grupos WHERE idGradoCiclo=".$grado["idGrado"]." AND situacion=1";
				$listaGrupos=$con->obtenerListaValores($consulta);
				
				if($listaGrupos!="")
				{
					$TG='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaGrupos).'\",\"'.bE("Grupos aperturados").'\")\'>'.$con->filasAfectadas.'</span>';
					
					
					$arrGrupos=explode(",",$listaGrupos);
					foreach($arrGrupos as $g)
					{
						$consulta="SELECT COUNT(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo =".$g." AND fechaAsignacion<=fechaBaja";
						$nProfesor=$con->obtenerValor($consulta); 
						if($nProfesor==0)
						{
							$TGSP++;
							if($listaProfesoresSG=="")
								$listaProfesoresSG=$g;
							else
								$listaProfesoresSG.=",".$g;
						}
						
						
						$arrDatosMateria=obtenerDatosMateriaHorasGrupo($g);
						$hSemanas=$arrDatosMateria["horasSemana"];
						$hAsignadas=obtenerHorasAsignadasGrupo($g);
						if($hAsignadas<$hSemanas)
						{
							$TGSH++;
							if($listaGruposSH=="")
								$listaGruposSH=$g;
							else
								$listaGruposSH.=",".$g;
						}
						
						
					}
					
					if($TGSP>0)
						$TGSP='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaProfesoresSG).'\",\"'.bE("Grupos aperturados sin profesor asignado").'\")\'>'.$TGSP.'</span>';
					if($TGSH>0)
						$TGSH='<span onClick=\'javascript:mostrarVentanaGrupo(\"'.bE($listaGruposSH).'\",\"'.bE("Grupos aperturados sin horario completo asignado").'\")\'>'.$TGSH.'</span>';
				}
				
				
				$consulta="SELECT COUNT(g.comentariosDictamen) FROM 4615_gradosSolicitudAutorizacionEstructura g,4614_cabeceraSolicitudAutorizacionEstructura s 
						WHERE idGradoEstructura=".$grado["idGrado"]." and g.dictamen<>0 AND TRIM(g.comentariosDictamen)!='' and s.idRegistro=g.idSolicitud and s.situacion=2";
				$nRegistroComentarios=$con->obtenerValor($consulta);
				if($nRegistroComentarios>0)
				{
					$icono.="&nbsp;<span onClick='javascript:mostrarComentariosGrado(\\\"".bE($grado["idGrado"])."\\\",\\\"".bE($grado["grado"])."\\\")'><img src='../images/icon_comment.gif' title='Este grado presenta ".($nRegistroComentarios==1?'1 comentario':$nRegistroComentarios." comentarios")."' alt='Este grado presenta ".($nRegistroComentarios==1?'1 comentarios':$nRegistroComentarios." comentarios")."'></span>";
				}
				
				$id='2_'.$grado["idGrado"].'_'.$arrDatosInstancia[1].'_'.$arrDatosInstancia[1];
				$o='{"TG":"'.$TG.'","TGSP":"'.$TGSP.'","TGSH":"'.$TGSH.'","comentarios":"'.($grado["comentarios"]).'","icono":"'.$icono.'","id":"'.$id.'","text":"<span title=\"'.cv($grado["grado"]).'\" alt=\"'.cv($grado["grado"]).'\"><input type=\'checkbox\' dictamen=\''.$grado["dictamen"].'\'  gradoOrdinal=\''.$grado["gradoOrdinal"].'\' name=\'chkInput\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\'> '.
					cv($grado["grado"]).'</span>",leaf:true}';
				if($arrHijosGrados=="")
					$arrHijosGrados=$o;
				else
					$arrHijosGrados.=",".$o;
			}

			$id="1_".$arDatosPeriodo[1]."_".$arrDatosInstancia[1];
			$oPeriodo='{"TG":"","TGSP":"","TGSH":"","comentarios":"","icono":"","expanded":true,"id":"'.$id.'","text":"<span title=\"'.cv($arDatosPeriodo[2]).'\" alt=\"'.cv($arDatosPeriodo[2]).'\" style=\"color:#900\"><input type=\'checkbox\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\' name=\'chkInput\'> '.
						cv($arDatosPeriodo[2]).'</span>",leaf:false,children:['.$arrHijosGrados.']}';
			if($arrHijos=="")
				$arrHijos=$oPeriodo;
			else
				$arrHijos.=",".$oPeriodo;
			
		}
		
		$oReg='';
		
		$id="0_".$arrDatosInstancia[1];
		$oReg='{"TG":"","TGSP":"","TGSH":"","comentarios":"","icono":"","expanded":true,"id":"'.$id.'","text":"<span title=\"'.cv($arrDatosInstancia[0]).'\" alt=\"'.cv($arrDatosInstancia[0]).
				'\"><input type=\'checkbox\' id=\'chk_'.$id.'\' onclick=\'checkBoxClick(this,event)\' name=\'chkInput\'> <b>'.
				$arrDatosInstancia[0].'</b></span>",leaf:false, children:['.$arrHijos.']}';
		
		if($cRegistros=="")
			$cRegistros=$oReg;
		else
			$cRegistros.=",".$oReg;
		
		
		
	}
	echo '['.$cRegistros.']';
}

function registrarDictamenGradosSolicitud()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	$arrGrados=explode(",",$obj->grados);
	foreach($arrGrados as $g)
	{
		$consulta[$x]="UPDATE 4615_gradosSolicitudAutorizacionEstructura SET dictamen=".$obj->marca.",comentariosDictamen='".cv($obj->comentarios).
					"' WHERE idSolicitud=".$obj->idSolicitud." and idGradoEstructura=".$g;
		$x++;
		
	}
	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
	
}

function actualizarDatosDictamenSolicitud()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	$consulta="UPDATE 4615_gradosSolicitudAutorizacionEstructura SET comentariosDictamen='".cv($obj->comentarios)."' WHERE idSolicitud=".$obj->idSolicitud." AND idGradoEstructura=".$obj->idGrado;
	eC($consulta);
}

function finalizarDictamenSolicitudAutorizacionEstructura()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$resultadoDictamen=0;
	$totalAutorizados=0;
	$totalRechazados=0;
	$consulta="SELECT dictamen FROM 4615_gradosSolicitudAutorizacionEstructura WHERE idSolicitud=".$obj->idSolicitud;
	$res=$con->obtenerFilas($consulta);
	while($fDictamen=mysql_fetch_row($res))
	{
		
		switch($fDictamen[0])
		{
			case 1:
				$totalAutorizados++;
			break;
			case 2:
				$totalRechazados++;
			break;
		}
		
		if($totalRechazados==0)
		{
			$resultadoDictamen=1;
		}
		else
		{
			if($totalAutorizados==0)
				$resultadoDictamen=3;
			else
				$resultadoDictamen=2;
		}
	}
	
	$consulta="UPDATE 4614_cabeceraSolicitudAutorizacionEstructura SET situacion=2,resultadoDictamen=".$resultadoDictamen.",fechaDictamen='".date("Y-m-d H:i:s").
			"',comentariosDictamen='".cv($obj->comentarios)."',idResponsableDictamen=".$_SESSION["idUsr"]." WHERE idRegistro=".$obj->idSolicitud;
	eC($consulta);	
	
}

function obtenerComentariosGradosEstructura()
{
	global $con;
	
	
	$arrRegistros="";
	$numReg=0;
	$idGrado=$_POST["idGrado"];
	
	$consulta="SELECT e.dictamen,e.comentariosDictamen,s.idRegistro,s.fechaDictamen,s.idResponsableDictamen FROM 4615_gradosSolicitudAutorizacionEstructura e,4614_cabeceraSolicitudAutorizacionEstructura s 
				WHERE e.idGradoEstructura=".$idGrado." AND TRIM(e.comentariosDictamen)!='' AND s.idRegistro=e.idSolicitud and dictamen<>0 and s.situacion=2 ORDER BY s.fechaDictamen DESC";
				
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))			
	{
		$icono="";
		switch($fila[0])
		{
			case 0:
				$icono="<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n'> En espera de autorizaci&oacute;n";
			break;
			case 1:
				$icono="<img src='../images/accept_green.png' title='Autorizado' alt='Autorizado'> Autorizado";
			break;
			case 2:
				$icono="<img src='../images/cancel_round.png' title='Rechazado' alt='Rechazado'> Rechazado";
			break;
		}
		
		$o='{"idSolicitud":"'.str_pad($fila[2],7,"0",STR_PAD_LEFT).'","fechaComentario":"'.$fila[3].'","comentadoPor":"'.
			cv(obtenerNombreUsuario($fila[4])).'","dictamen":"'.$icono.'","comentario":"'.cv($fila[1]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
	
}

function modificarEstadoVistoSolicitudAutorizacionEstructura()
{
	global $con;
	$idSolicitud=$_POST["idSolicitud"];
	$valor=$_POST["valor"];
	$consulta="UPDATE 4614_cabeceraSolicitudAutorizacionEstructura SET vistoResponsable=".$valor." WHERE idRegistro=".$idSolicitud;
	eC($consulta);

}

function verificarClaveMateria()
{
	global $con;
	$cveMateria=$_POST["cveMateria"];
	$idMateria=$_POST["iMateria"];
	$idPlanEstudio=$_POST["iPlanEstudio"];
	$consulta="SELECT COUNT(*) FROM 4502_Materias WHERE idPlanEstudio=".$idPlanEstudio." AND idMateria<>".$idMateria." AND cveMateria='".$cveMateria."'";
	$nReg=$con->obtenerValor($consulta);	
	echo "1|".$nReg;
}

function obtenerUsuariosAccesoPlanEstudio()
{
	global $con;
	$idPlanEstudio=$_POST["idPlanEstudio"];
	$consulta="SELECT a.idUsuario,u.Nombre as nombreUsuario FROM 4500_accesoUsuarioPlanes a,800_usuarios u WHERE idPlanEstudio=".$idPlanEstudio." AND u.idUsuario=a.idUsuario ORDER BY u.Nombre";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}

function removerUsuarioAccesoPlanEstudio()
{
	global $con;
	$idPlanEstudio=$_POST["idPlanEstudio"];
	$idUsuario=$_POST["idUsuario"];
	$consulta="DELETE FROM 4500_accesoUsuarioPlanes WHERE idPlanEstudio=".$idPlanEstudio." AND idUsuario=".$idUsuario;
	eC($consulta);
}

function agregarUsuarioAccesoPlanEstudio()
{
	global $con;
	$idPlanEstudio=$_POST["idPlanEstudio"];
	$idUsuario=$_POST["idUsuario"];
	$consulta="insert into 4500_accesoUsuarioPlanes(idPlanEstudio,idUsuario) values(".$idPlanEstudio.",".$idUsuario.")";
	eC($consulta);
}

function obtenerPlanesEstudiosInscripcionV2()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idReferencia=$_POST["idReferencia"];


	$plantel="";
	if(isset($_POST["plantel"]))
		$plantel=$_POST["plantel"];
	
	
	$query="SELECT cmbCicloInscripcion FROM _692_tablaDinamica WHERE id__692_tablaDinamica=".$idReferencia;
	$idCiclo=$con->obtenerValor($query);
	
	
	$consulta="SELECT idPeriodo FROM 3014_pluginPeriodos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
	$idPeriodos=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT idInstanciaPlanEstudio,p.descripcion,pe.nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos pe 
			WHERE pe.idProgramaEducativo=p.idProgramaEducativo and idInstanciaPlanEstudio NOT IN (SELECT idInstanciaPlanEstudio FROM 4578_instanciasPlanEstudiosRegistroInscripcion  
			WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia.")  AND p.idPlanEstudio=i.idPlanEstudio and i.situacion=1";
			
	if($plantel!="")		
		$consulta.=" and sede='".$plantel."'";
		
	$consulta.=" order by i.nombrePlanEstudios";
			
	$arrRegistros="";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo in(".$idPeriodos.") AND idInstanciaPlanEstudio=".$fila[0];
		$iGrado=$con->obtenerValor($consulta);
		if($iGrado!="")
		{
			$obj='{"idInstanciaPlan":"'.$fila[0].'","nombrePlanEstudios":"'.cv(obtenerNombreInstanciaPlan($fila[0])).'","descripcion":"'.cv($fila[1]).'","programaEducativo":"'.cv($fila[2]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
		}
	}
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
}		

function obtenerCiclosPeriodoInscripcion()
{
	global $con;
	$fechaActual=date("Y-m-d");
	$idInstanciaPlan=$_POST["idInstanciaPlan"];	
	$consulta="SELECT distinct c.idCiclo, g.idPeriodo,p.nombrePeriodo as periodo,c.nombreCiclo as ciclo 
				FROM 4579_gradosRegistroInscripcion g,_692_tablaDinamica t,	4501_Grado gr, 4526_ciclosEscolares c,_464_gridPeriodos p
				WHERE idInstanciaPlan=".$idInstanciaPlan." 	AND '".$fechaActual."'>=fechaInicioInscripcion AND '".$fechaActual."'<=fechaFinInscripcion
				and gr.idGrado=g.idGrado and id__692_tablaDinamica=g.idReferencia and gr.ordenGrado=1 and c.idCiclo=t.cmbCicloInscripcion
				and p.id__464_gridPeriodos=g.idPeriodo order by c.nombreCiclo,p.nombrePeriodo";
	
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}


function obtenerConfiguracionExamenesPerfil()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$consulta="SELECT e.idTipoExamen,e.tipoExamen,te.prioridad FROM 4625_tiposExamenPerfilEvaluacion te,4622_catalogoTipoExamen e WHERE idPerfil=".$idPerfil."
				AND e.idTipoExamen=te.idTipoExamen ORDER BY te.prioridad";

	$arrExamenes="";
	$res=$con->obtenerFilas($consulta);
	
	
	while($fila=mysql_fetch_row($res))
	{
		$hijos=obtenerConfiguracionesExamen($idPerfil,$fila[0]);
		
		$o='{"icon":"../images/s.gif","orden":"'.$fila[2].'","tipoNodo":"1","id":"1_'.$fila[0].'","text":"<b>Tipo examen:</b> <span style=\'color:#030\'><b>'.cv($fila[1]).'</b></span>","configuracion":"<a onclick=\'javascript:modificarPrioridadExamen(\"'.bE($fila[0]).'\")\'><img width=\'14\' height=\'14\' src=\'../images/pencil.png\'></a>&nbsp;&nbsp;&nbsp;<b>Orden de aplicaci&oacute;n:</b> '.$fila[2].'","leaf":false,children:'.$hijos.'}';
		
		if($arrExamenes=="")
			$arrExamenes=$o;
		else
			$arrExamenes.=",".$o;
	}
	
	echo '['.$arrExamenes.']';
}


function obtenerConfiguracionesExamen($idPerfil,$tipoExamen)
{
	global $con;
	
	
	$consulta="select idRegistro,leyendaRegla,(SELECT valor FROM 4626_configuracionesPerfilEvaluacion WHERE 
				idPerfil=".$idPerfil." AND tipoExamen=".$tipoExamen." AND idConfiguracion=c.idRegistro) as valor , tipoValor,confComplementaria
				from 4624_configuracionesDefaultPerfilReglasEvaluacion c order by prioridad ";
	
	$arrExamenes="";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="";
		$lblEtiqueta="";
		
		switch($fila[3])
		{
			case "1":
				$lblEtiqueta=number_format($fila[2],0);
			break;
			case "2":
				$lblEtiqueta=number_format($fila[2],2);
			break;
			case "3":
				$oValor=json_decode($fila[4]);
				$arrPHP=$oValor->arrPHP;

				foreach($arrPHP as $o)
				{
					if($o->id==$fila[2])
					{
						$lblEtiqueta=$o->valor;
						break;
					}
				}
			break;
			case "4":
				if($fila[2]==0)
				{
						$lblEtiqueta="Ninguno";
				}
				else
				{
					$oValor=json_decode($fila[4]);
					$consulta="select ".$oValor->campoEtiqueta." from ".$oValor->tabla." where ".$oValor->campoID."='".cv($fila[2])."'";
	
					$lblEtiqueta=$con->obtenerValor($consulta);
				}
			break;
		}
		
		$idNodo='2_'.$tipoExamen.'_'.$fila[0].'_'.$fila[3];
		
		$o='{"tipoNodo":"2","id":"'.$idNodo.'","text":"<i><span style=\'color:#444\'>'.cv($fila[1]).'</span></i>","configuracion":"<a onclick=\'javascript:modificarValorConfiguracion(\"'.bE('2_'.$tipoExamen.'_'.$fila[0].'_'.$fila[3]).'\")\'><img width=\'14\' height=\'14\' src=\'../images/pencil.png\'></a>&nbsp;&nbsp;&nbsp; <span id=\'lbl_'.$idNodo.'\'>'.
			$lblEtiqueta.'</span>","idValor":"'.cv($fila[2]).'","leaf":true}';
		
		if($arrExamenes=="")
			$arrExamenes=$o;
		else
			$arrExamenes.=",".$o;
	}
	return '['.$arrExamenes.']';
	
}

function obtenerTipoExamenDisponible()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$consulta="SELECT idTipoExamen FROM 4625_tiposExamenPerfilEvaluacion WHERE idPerfil=".$idPerfil;
	$lPerfiles=$con->obtenerListaValores($consulta);
	if($lPerfiles=="")
		$lPerfiles=-1;
	
	
	$consulta="SELECT idTipoExamen,CONCAT('[',IF(cveTipoExamen IS NULL,'',cveTipoExamen),'] ',tipoExamen) AS tipoExamen FROM 4622_catalogoTipoExamen
				where idTipoExamen NOT IN(".$lPerfiles.") ORDER BY tipoExamen";
	
	
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
	
}

function agregarTipoExamenPerfil()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$lTipoExamen=$_POST["lTipoExamen"];
	$arrTipoExamen=explode(",",$lTipoExamen);
	
	
	
	$consulta="select count(*) from 4625_tiposExamenPerfilEvaluacion where idPerfil=".$idPerfil;
	$prioridad=$con->obtenerValor($consulta);
	$prioridad++;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	
	foreach($arrTipoExamen as $t)
	{
		$query[$x]="INSERT INTO 4625_tiposExamenPerfilEvaluacion(idPerfil,idTipoExamen,prioridad) VALUES(".$idPerfil.",".$t.",".$prioridad.")";
		$x++;
		$query[$x]="INSERT INTO 4626_configuracionesPerfilEvaluacion(idPerfil,tipoExamen,idConfiguracion,valor)
					SELECT '".$idPerfil."' AS idPerfil,'".$t."' AS tipoExamen,idRegistro,valorDefault FROM 4624_configuracionesDefaultPerfilReglasEvaluacion";
		$x++;
	}
	
	$query[$x]="commit";
	$x++;
	eB($query);
}

function modificarOrdenAplicacionExamenPerfil()
{
	global $con;
	
	$tE=$_POST["tE"];
	$iP=$_POST["iP"];
	$orden=$_POST["o"];
	
	$consulta="SELECT prioridad FROM 4625_tiposExamenPerfilEvaluacion WHERE idPerfil=".$iP." AND idTipoExamen=".$tE;
	$ordenOriginal=$con->obtenerValor($consulta);
	
	
	
	if($orden!=$ordenOriginal)
	{
		if($orden>$ordenOriginal)
		{
			$consulta="UPDATE 4625_tiposExamenPerfilEvaluacion SET prioridad=prioridad-1 WHERE idPerfil=".$iP." and prioridad>".$ordenOriginal." and prioridad<=".$orden;
		}
		else
		{
			$consulta="UPDATE 4625_tiposExamenPerfilEvaluacion SET prioridad=prioridad+1 WHERE idPerfil=".$iP." and prioridad>=".$orden." and prioridad<".$ordenOriginal;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="UPDATE 4625_tiposExamenPerfilEvaluacion SET prioridad=".$orden." WHERE idPerfil=".$iP." and idTipoExamen=".$tE;
			eC($consulta);
		}
	}
	else
		echo "1|";
}


function modificarConfiguracionAplicacionExamenPerfil()
{
	global $con;
	
	$tE=$_POST["tE"];
	$iP=$_POST["iP"];
	$iC=$_POST["iC"];
	$v=$_POST["valor"];
	
	
	$consulta="SELECT idRegistro FROM 4626_configuracionesPerfilEvaluacion WHERE idPerfil=".$iP." AND tipoExamen=".$tE." AND idConfiguracion=".$iC;
	$idRegistro=$con->obtenerValor($consulta);
	
	
	if($idRegistro!="")
	{
		$consulta="UPDATE 4626_configuracionesPerfilEvaluacion SET valor='".cv($v)."' WHERE idPerfil=".$iP." AND tipoExamen=".$tE." AND idConfiguracion=".$iC;
	}
	else
	{
		$consulta="INSERT INTO 4626_configuracionesPerfilEvaluacion(idPerfil,tipoExamen,idConfiguracion,valor) VALUES(".$iP.",".$tE.",".$iC.",'".cv($v)."')";
	}
	
	eC($consulta);
}


function modificarPerfilEvaluacionMateriaInstancia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="UPDATE 4512_aliasClavesMateria SET perfilEvaluacion=".$obj->perfil." WHERE idInstanciaPlanEstudio=".
			$obj->idInstancia." AND idMateria=".$obj->idMateria;
	eC($consulta);
	
	
}

function obtenerPerfilesExamenGrupo()
{
	global $con;
	$idGrupo=$_POST["idGrupo"];
	$noExamen=$_POST["noExamen"];
	
	$consulta="SELECT idMateria,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
	
	
	$fGrupo=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT perfilEvaluacion FROM 4512_aliasClavesMateria WHERE idMateria=".$fGrupo[0]." AND idInstanciaPlanEstudio=".$fGrupo[1];
	$idPerfil=$con->obtenerValor($consulta);
	
	if($idPerfil=="0")
	{
		$consulta="SELECT idPerfilEvaluacion FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fGrupo[1];
		$idPerfil=$con->obtenerValor($consulta);
		if($idPerfil=="")
			$idPerfil=-1;
	}
	
	$consulta="SELECT noExamen,IF(cveTipoExamen IS NULL,CONCAT('[] ',c.tipoExamen),CONCAT('[',cveTipoExamen,'] ',c.tipoExamen)) AS examen,p.idPerfil 
				FROM 4591_perfilesEvaluacionMateria p,4622_catalogoTipoExamen c,4625_tiposExamenPerfilEvaluacion t WHERE idGrupo=".$idGrupo." AND c.idTipoExamen=p.noExamen
				AND t.idTipoExamen=c.idTipoExamen AND t.idPerfil=".$idPerfil." and noExamen<>".$noExamen." ORDER BY prioridad";
	
	
				
	$arrFilas=utf8_encode($con->obtenerFilasJSON($consulta));			
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrFilas.'}';
	
}

function clonarPerfilEvaluacionGrupo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$consulta="SELECT idPerfil FROM 4591_perfilesEvaluacionMateria WHERE idGrupo=".$obj->idGrupo." AND noExamen=".$obj->noExamen;
	
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil=-1;
		
	if(destruirPerfilCriterioEvaluacion($idPerfil))
	{
		$idPerfil=clonarPerfilCriterioEvaluacion($obj->idPerfilBase,$obj->idGrupo,$obj->noExamen);
		
		$consulta="update 4591_perfilesEvaluacionMateria set idGrupo=".$obj->idGrupo." WHERE idPerfil=".$idPerfil;
		if($con->ejecutarCOnsulta($consulta))
		{
			echo "1|".$idPerfil;
		}
		
	}
	
	
}

function cerrarConfiguracionCriterio()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$arrErrores="[]";
	
	$arrErroresAux=validarConfiguracionCriterioEvaluacion($idPerfil);
	if(sizeof($arrErroresAux)>0)
	{
		$arrErrores="";
		foreach($arrErroresAux as $e)
		{
			if($arrErrores=="")
				$arrErrores="['".cv($e)."']";
			else		
				$arrErrores.=",['".cv($e)."']";
		}
		$arrErrores="[".$arrErrores."]";
		echo "1|".$arrErrores;
	}
	else
	{
	
	
		$consulta="UPDATE 4591_perfilesEvaluacionMateria SET perfilLiberado=1 WHERE idPerfil=".$idPerfil;
		if($con->ejecutarConsulta($consulta))
			echo "1|[]";
	}
		
}

?>