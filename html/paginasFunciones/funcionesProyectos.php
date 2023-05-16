<?php session_start();
	include("funcionesFormularios.php");
	include_once("funcionesActores.php");
	$parametros="";
	$x=0;
	$consulta;
	$lPorcionCodFun=5; //cambiar funciones organigrama
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
		case "1":
			guardarElementosDTD();
		break;
		case "2":
			obtenerModulos();
		break;
		case "3":
			guardarLineasAccion();
		break;
		case "4":
			removerLineaAccion();
		break;
		case "5":
			guardarLineasInv();
		break;
		case "6":
			removerLineaInv();
		break;
		case "7":
			obtenerRolesFunciones();
		break;
		case "8":
			guardarRol();
		break;
		case "9":
			eliminarRolFuncion();
		break;
		case "10":
			obtenerFuncionesDisponibles();
		break;
		case "11":
			guardarFuncionesRol();
		break;
		case 12:
			obtenerComitesParticipantesDisponibles();
		break;
		case "13":
			actualizarPosicionElementoDTD();
		break;
		case 14:
			eliminarElementoDTD();
		break;
		case 15:
			obtenerElementosDTD();
		break;
		case 16:
			guardarDatosComites();
		break;
		case 17:
			eliminarDatosComites();
		break;
		case 18:
			obtenerComitesElementosDTD();
		break;
		case 19:
			obtenerElementosDTDDisponiblesComite();
		break;
		case 20:
			guardarElementosDTDComite();
		break;
		case 21:
			cambiarFuncionComiteElemento();
		break;
		case 22:
			obtenerElementosDTDProyectos();
		break;
		case 23:
			obtenerAutor();
		break;
		case 24:
			guardarAutor();
		break;
		case 25:
			eliminarAutor();
		break;
		case 26:
			modificarOrdenAutor();
		break;
		case 27:
			obtenerInstituciones();
		break;
		case 28:
			obtenerDepartamentos();
		break;
		case 29:
			guardarNuevoUsuario();
		break;
		case 30:
			obtenerEtapasDisponiblesComite();
		break;
		case 31:
			guardarEtapasComite();
		break;
		case 32:
			obtenerComitesDisponiblesSeleccion();
		break;
		case 33:
			agregarComitesParticipantes();
		break;
		case 34:
			eliminarComitesParticipantes();
		break;
		case 35:
			actualizarFuncionesComites();
		break;
		case 36:
			cambiarCondicionElemento();
		break;
		case 37:
			generarTablaModulos();
		break;
		case 38:
			eliminarArchivoAutor();
		break;
		case 39:
			someterRevision();
		break;
		case 40:
			cambiarSituacionProceso();
		break;
		case 41:
			asignarEtapaProceso();
		break;
		case 42:
			obtenerRolesActoresProceso();
		break;
		case 43:
			agregarRolActorProceso();
		break;
		case 44:
			eliminarRolActorProceso();
		break;
		case 45:
			obtenerActoresProcesoDisponible();
		break;
		case 46:
			guardarActoresProceso();
		break;
		case 47:
			obtenerAccionesActorDisponibles();
		break;
		case 48:
			guardarAccionesActor();
		break;
		case 49:
			removerActorEtapa();
		break;
		case 50:
			removerAccionEtapa();
		break;
		case 51:
			obtenerEtapasSometimientoDisponibles();
		break;
		case 52:
			guardarEtapaSometimiento();
		break;
		case 53:
			guardarOpcionesDictamenFinal();
		break;
		case 54:
			obtenerOpcionesDictamenRegistradas();
		break;
		case 55:
			obtenerActoresProcesoDisponibleInicio();
		break;
		case 56:
			guardarActoresProcesoInicio();
		break;
		case 57:
			removerActoresProcesoInicio();
		break;
		case 58:
			obtenerAccionesInicioActorDisponibles();
		break;
		case 59:
			guardarAccionesInicioActor();
		break;
		case 60:
			removerAccionInicio();
		break;
		case 61:
			modificarVerRegistro();
		break;
		case 62:
			removerCondicionesDictamen();
		break;
		case 63:
			obtenerActoresDictamenDisponible();
		break;
		case 64:
			guardarActoresDictamen();
		break;
		case 65:
			removerActorDictamen();
		break;
		case 66:
			eliminarPerfilModuloAutores();
		break;
		case 67:
			obtenerElementosEtapa();
		break;
		case 68:
			guardarConfiguracionModuloAutores();
		break;
		case 69:
			guardarOpcionesDictamenParcial();
		break;
		case 70:
			guardarOpcionesDictamenRevisor();
		break;
		case 71:
			obtenerOpcionesRegistradasDictamenParcial();
		break;
		case 72:
			obtenerOpcionesRegistradasDictamenRevisores();
		break;
		case 73:
			obtenerActividadesProgramadas();
		break;
		case 74:
			guardarActividad();
		break;
		case 75:
			eliminarActividad();
		break;
		case 76:
			modificarActividad();
		break;
		case 77:
			cambiarParticipacionAutor();
		break;
		case 78:
			bloquearElemento();
		break;
		case 79:
			quitarBloquearElemento();
		break;
		case 80:
			obtenerRevisores();
		break;
		case 81:
			guardarRevisor();
		break;
		case 82:
			eliminarRevisor();
		break;
		case 83:
			guardarNuevoRevisor();
		break;
		case 84:
			cambiarEstadoProcesoDictamen();
		break;
		case 85:
			obtenerObjetosProceso();
		break;
		case 86:
			obtenerLineasAccionProceso();
		break;
		case 87:
			guardarActividadProgTrabajo();
		break;
		case 88:
			eliminarActividadProgramaTrabajo();
		break;
		case 89:
			removerCita();
		break;
		case 90:
			guardarSesionTrabajo();
		break;
		case 91:
			removerSesionTrabajo();
		break;
		case 92:
			obtenerProcesos();
		break;
		case 93:
			obtenerActividadesProgramadasObjeto();
		break;
		case 94:
			obtenerDatosActividad();
		break;
		case 95:
			eliminarArchivoReporte();
		break;
		case 96:
			guardarRolModulo();
		break;
		case 97:
			removerPermiso();
		break;
		case 98:
			obtenerPermisosModuloFicha();
		break;
		case 99:
			guardarPermisosModuloFicha();
		break;
		case 100:
			guardarConfiguracionUsuario();
		break;
		case 101:
			obtenerProyectosAdemdum();
		break;
		case 102:
			guardarAdemdum();
		break;
		case 103:
			eliminarAdemdum();
		break;
		case 104:
			obtenerActividadesOrigen();
		break;
		case 105:
			guardarActividadOrigen();
		break;
		case 106:
			asignarAutorResponsable();
		break;
		case 107:
			guardarConfiguracionFicha();
		break;
		case 108:
			obtenerAccionesControl();
		break;
		case 109:
			obtenerOpcionesControl();
		break;
		case 110:
			guardarOpcionesEvento();
		break;
		case 111:
			obtenerControlesAccion();
		break;
		case 112:
			guardarAccionesControl();
		break;
		case 113:
			modificarAccionesControl();
		break;
		case 114:
			eliminarElementoAccionControl();
		break;
		case 115:
			marcarLineaInvestigacionPrincipal();
		break;
		case 116:
			removerDiaLaboral();
		break;
		case 117:
			actualizarHora();
		break;
		case 118:
			obtenerCamposLitaDisponibles();
		break;
		case 119:
			guardarCamposLita();
		break;
		case 120:
			guardarCuentasEscenario();
		break;
		case 121:
			actualizarPorcentajeCuenta();
		break;
		case 122:
			removerRolModulo();
		break;
		case 123:
			obtenerProcesosClonar();
		break;
		case 124:
			obtenerFormulariosClonar();
		break;
		case 125:
			clonarFormularios();
		break;
		case 126:
			guardarConfiguracionProcesoPOA();
		break;
		case 127:	
			guardarCuentaLitaPOA();
		break;
		case 128:
			modificarPorcentajeCta();
		break;
		case 129:
			modificarTipoAfectacionCta();
		break;
		case 130:
			removerCuentaLita();
		break;
		case 131:
			obtenerProgramas();
		break;
		case 132:
			guardarParametrosReporte();
		break;
		case 133:
			removerConfiguracion();
		break;
		case 134:
			guardarConfiguracionPerfilGrafUsr();
		break;
		case 135:
			obtenerActoresRegistroDisponible();
		break;
		case 136:
			guardarConfFolio();
		break;
		case 137:
			obtenerConfFolios();
		break;
		case 138:
			removerFolio();
		break;
		case 139;
			activarFolio();
		break;
		case 140:
			cambiarReglaFolio();
		break;
		case 141:
			obtenerEtapasProceso();
		break;
		case 142:
			asignarResponsableActividad();
		break;
		case 143:
			guardarReglaReporteProgramaTrabajo();
		break;
		case 144:
			guardarConfReportes();
		break;
		case 145:
			removerRolReporte();
		break;
		case 146:
			obtenerListadoExpresiones();
		break;
		case 147:
			validarQuery();
		break;
		case 148:
			guardarExpresion();
		break;
		case 149:
			eliminarConcepto();
		break;
		case 150:
			generarFechasCiclo();
		break;
		case 151:
			actualizarFechasNomina();
		break;
		case 152:
			guardarCuentaPercepcionDeduccion();
		break;
		case 153:
			removerCuentaPercepcionDeduccion();
		break;
		case 154:
			modificarCampoPercepcionDeduccion();
		break;
		case 155:
			removerPercepcionDeduccion();
		break;
		case 156:
			actualizarCampoIdentifica();
		break;
		case 157:
			asignarBeneficiario();
		break;
		case 158:
			modificarTipoPresupuestoAfectacion();
		break;
		case 159:
			agregarCategoria();
		break;
		case 160:
			removerCategoria();
		break;
		case 161:
			eliminarCategoriaProceso();
		break;
		case 162:
			obtenerAccionesAsocTipoProceso();
		break;
		case 163:
			obtenerAccionesDisponiblesAsocTipoProceso();
		break;
		case 164:
			asociarAccionesTipoProceso();
		break;
		case 165:
			removerAccionesTipoProceso();
		break;
		case 166:
			modificarNombreAccionTipoProceso();
		break;
		case 167:
			obtenerParticipantesElementosDTD();
		break;
		case 168:
			obtenerElementosDTDDisponiblesParticipante();
		break;
		case 169:
			eliminarDatosParticipante();
		break;
		case 170:
			cambiarFuncionParticipanteElemento();
		break;
		case 171:
			obtenerAccionesParticipantesDisponibles();
		break;
		case 172:
			guardarAccionesParticipante();
		break;	
		case 173:
			modificarPasoEtapaParticipante();
		break;
		case 174:
			obtenerDictamenesAsociados();
		break;
		case 175:
			obtenerProcesosDisponiblesInclusion();
		break;
		case 176:
			vicularProcesoDTD();
		break;
		case 177:
			guardarConfRepetibleProceso();
		break;
		case 178:
			obtenerTipoProcesoDisponibles();
		break;
		case 179:
			guardarTipoProcesoPermiso();
		break;
		case 180:
			removerTipoProceso();
		break;
		case 181:
			obtenerConfiguracionModuloProceso();
		break;
		case 182:
			guardarConfiguracionModuloProceso();
		break;
		case 183:
			guardarRegistroPOA();
		break;
		case 184:
			eliminarRegistroPOA();
		break;
		case 185:
			modificarConfRolComite();
		break;
		case 186:
			obtenerConfRolComite();
		break;
		case 187:
			cambiarAsociacionAutomaticaActor();
		break;
		case 188:
			obtenerComitesDisponibles();
		break;
		case 189:
			guardarAsignacionComites();
		break;
		case 190:
			removerComites();
		break;
		case 191:
			enviarAEtapa();
		break;
		case 192:
			existeMail();
		break;
		case 193:
			guardarDatosProcesoRegistro();
		break;
		case 194:
			crearNuevoUsuario();
		break;
		case 195:
			obtenerParametrosAutomaticosProceso();
		break;
		case 196:
			obtenerCamposFormulario();
		break;
		case 197:
			guardarFechaProyecto();
		break;
		case 198:
			obtenerParametrosFuncion();
		break;
		case 199:
			generarConsultaAlmacenProceso();
		break;
		case 200:
			obtenerElementosConvocatoria();
		break;
		case 201:
			guardarConfiguracionConv();
		break;
		case 202:
			obtenerElementosProceso();
		break;
		case 203:
			guardarElementosProceso();
		break;
		case 204:
			eliminarElemento();
		break;
		case 205:
			obtenerCamposConf();
		break;
		case 206:
			guardarConfiguracionElemento();
		break;
		case 207:
			guardarValorConfConvocatoria();
		break;
		case 208:
			obtenerValoresElementosPerfil();
		break;
		case 209:
			guardarPeriodoConvocatoria();
		break;
		case 210:
			guardarValorElementoConvocatoria();
		break;
		case 211:
			guardarNivelesInvestigadorConv();
		break;
		case 212:
			guardarPrefijoProceso();
		break;
		case 213:
			guardarCC();
		break;
		case 214:
			eliminarCCProyecto();
		break;
		case 215:
			obtenerMiembrosComite();
		break;
		case 216:
			asignarPresentador();
		break;
		case 217:
			guardarDatosCampoGrid();
		break;
		case 218:
			eliminarRegistroCampoGrid();
		break;
		case 219:
			obtenerProcesoPorTipo();
		break;
		case 220:
			guardarProcesoVinculadoConvocatoria();
		break;
		case 221:
			eliminarProcesoVinculadoConvocatoria();
		break;
		case 222:
			actualizarDatosConvocatoria();
		break;
		case 223:
			actualizarProcesoPresupuesto();
		break;
		case 224:
			obtenerCapitulosDisponibles();
		break;
		case 225:
			agregarCapitulosProceso();
		break;
		case 226:
			removerCapitulosProceso();
		break;
		case 227:
			removerRolProcesoPresupesto();
		break;
		case 228:
			agregarRolPresupuesto();
		break;
		case 229:
			guardarConfiguracionProcesoCompra();
		break;
		case 230:
			obtenerOpcionesEvaluacionSolicitud();
		break;
		case 231:
			cambiarAmbitoAsignacion();
		break;
		case 232:
			validarFormulario();
		break;
		case 233:
			guardarConfiguracionModuloDTD();
		break;
		case 234:
			guardarProcesoDefaultValor();
		break;
		case 235:
			guardarNoticacionCambio();
		break;
		case 236:
			obtenerPartidasProcesoDisponible();
		break;
		case 237:
			guardarPartidasProceso();
		break;
		case 238:
			removerPartida();
		break;
		case 239:
			ejecutarFuncionNuevoRegistroProceso();
		break;
		case 240:
			obtenerComentariosRegistro();
		break;
		case 241:
			guardarPaginaAgregacion();
		break;
		case 242:
			obtenerComentariosSeccion();
		break;
		case 243:
			guardarComentariosSeccion();
		break;
		case 244:
			eliminarComentariosSeccion();
		break;
		case 245:
			obtenerEstadisticasRegistro();
		break;
		case 246:
			removerUnidadAmbito();
		break;
		case 247:
			agregarUnidadAmbito();
		break;
		case 248:
			buscarUnidadOrganigrama();
		break;
		
		case 300:
			crearCuentaBancoProyecto();
		break;
		case 301:
			actualizarCuenta();
		break;
		case 302:
			obtenerBancos();
		break;
		case 303:
			obtenerPersonas();
			
		break;
		case 304:
			obtenerEmpresas();
		break;
		case 305:
			removerCuenta();
		break;
		case 310:
			guardarFechasConvocatoria();
		break;
		case 311:
			registrarAccionUsuarioRegistro();
		break;
		case 312:
			obtenerElementosConvocatoriaEstructura();
		break;
		case 313:
			guardarOrdenElementoConvocatoria();
		break;
		case 314:
			guardarPuntajeCriterio();
		break;
		case 315:
			agregarMovimientoProceso();
		break;
		case 316:
			obtenerMovimientosProcesoDisponible();
		break;
		case 317:
			asignarEtapaMovimientoProceso();
		break;
		case 318:
			obtenerMovimientosProcesoEtapaDisponible();
		break;
		case 319:
			guardarModificacionParametro();
		break;
		case 320:
			inscribirAlumnoCurso();
		break;
		case 321:
			guardarConfiguracionModuloPresupuesto();
		break;
		case 322:
			obtenerConfiguracionModuloPresupuesto();
		break;
		case 323:
			obtenerConfiguracionModulo();
		break;
		case 324:
			guardaVinculacionProcesoReporte();
		break;
		case 325:
			obtenerDatosFormulario();
		break;
		case 326:
			guardarNombreFuncionGeneradoraFolio();
		break;
		case 327:
			guardarTipoFuncionGeneradoraFolio();
		break;
		case 328:
			guardarTemporizadorProceso();
		break;
		case 329:
			obtenerTemporadoresProceso();
		break;
		case 330:
			guardarOpcionesEvaluacion();
		break;
		case 331:
			removerTemporizadorProceso();
		break;
		case 332:
			obtenerConfiguracionSeccion();
		break;
		case 333:
			guardarConfiguracionSeccion();
		break;
		case 334:
			removerConfiguracionSeccion();
		break;
		case 335:
			guardarOpcionesControlProceso();
		break;
		case 336:
			obtenerFuncionesSistema();
		break;
		case 337:
			obtenerNuevoActorProcesoRegistro();
		break;
		case 338:
			obtenerReferenciaPago();
		break;
		case 339:
			obtenerIdRegistroFormulario();
		break;
		case 340:
			obtenerCamposFormularioPorTipo();
		break;
		case 341:
			actualizarEtapaElementoDTD();
		break;
		case 342:
			actualizarOrdenElementoDTD();
		break;
		case 343:
			removerEtapaSeccion();
		break;
		case 344:
			obtenerEtapasDisponiblesSeccion();
		break;
		case 345:
			registrarEtapaSeccion();
		break;
		case 346:
			modificarSituacionPerfil();
		break;
		
		case 347:
			obtenerSeccionesVistaDTD();
		break;
		
		case 348:
			actualizarTabActivo();
		break;
		case 349:
			registrarFirmaCertificacionProceso();
		break;
		case 350:
			cambiarEtapaFormularioDictamenFinal();
		break;
		case 351:
			removerDocumentoProceso();
		break;
		case 352:
			obtenerInfoIngresoProceso();
		break;
		case 353:
			obtenerCamposProcesoArranque();
		break;
		case 354:
			registrarParametrosProcesoArranque();
		break;		
		case 355:
			obtenerProcesosArranqueEscenario();
		break;
		case 356:
			removerProcesosArranqueEscenario();
		break;
		case 357:
			obtenerProcesosAsociadosEtapaCambio();
		break;
		case 358:
			registrarConfiguracionCambioEtapaProceso();
		break;
		case 359:
			registrarConfiguracionFuncionAplicacionCambioEtapaProceso();
		break;
		case 360:
			registrarInvocacionScript();
		break;
		case 361:
			obtenerActualEtapaCambioProceso();
		break;
		case 362:
			obtenerCamposProcesoHash();
		break;
		case 363:
			registrarCamposHash();
		break;
		case 364:
			obtenerEtapasProcesoDiseno();
		break;
		case 365:
			obtenerFormulariosProcesoDiseno();
		break;
		case 366:
			actualizarEdicionForzadaElementoDTD();
		break;
		case 367:
			actualizarTextoElementoDTD();
		break;
		
		
	}
	
	function obtenerModulos()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$tipoActor=-1;
		if(isset($_POST["tipoActor"]))
			$tipoActor=$_POST["tipoActor"];
		
		$actor=-1;
		if(isset($_POST["actor"]))
			$actor=$_POST["actor"];
		

		$consulta="select titulo from 203_elementosDTD e,900_formularios f where f.idFormulario=e.idFormulario and e.idProceso=".$idProceso." and tipoElemento in(1) and e.idPerfil is null order by titulo";
		
		if($tipoActor!=-1)
		{
			$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProceso." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
			$idPerfil=$con->obtenerValor($consulta);
			
			$consulta="select titulo from 203_elementosDTD e,900_formularios f where f.idFormulario=e.idFormulario and e.idProceso=".$idProceso." and tipoElemento in(1) and e.idPerfil=".$idPerfil." order by titulo";
		}
		

		$modulosIng=$con->obtenerListaValores($consulta);
		if($modulosIng=="")
			$modulosIng="-1";
		
		$modulos="";
		$formularios="";
		$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		
		$consulta="select m.idGrupoModulo,m.modulo,m.paginaConfiguracionModulo from 200_modulosPredefinidosProcesos m order by m.modulo";		
		$filas=$con->obtenerFilas($consulta);
		while($f=$con->fetchRow($filas))
		{
			$nodoModulo='	{	
								"text":"'.$f[1].'",
								"id":"'.$f[0].'",
								"cls":"cssNodoArbolNivel2",
								"tipo":"1",
								"icon":"../images/s.gif",
								"leaf":true,
								"allowDrop":false,
								"idModulo":"'.$f[0].'",
								"checked":false
							}';
			if($modulos=="")
				$modulos=$nodoModulo;
			else	
				$modulos.=",".$nodoModulo;
		}
		
		$consulta="select idFormulario from 900_formularios where formularioBase=1 and idProceso=".$idProceso;
		$frmBase=$con->obtenerValor($consulta);
		
		$formularios=obtenerFormularios($frmBase,$idProceso,-1,$tipoActor,$actor);
		
		echo uEJ('[{"modulos":['.$modulos.'],"formularios":'.$formularios.'}]');
		
	}
	
	function obtenerFormularios($frmEntidad,$idProceso,$frmIgnorar="-1",$tipoActor=1,$actor="")
	{
		global $con;
		$consulta="select idFormulario from 203_elementosDTD e where e.idProceso=".$idProceso." and tipoElemento=0 and e.idPerfil is null";
		if($tipoActor!=-1)
		{
			$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProceso." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
			$idPerfil=$con->obtenerValor($consulta);
			$consulta="select idFormulario from 203_elementosDTD e where e.idProceso=".$idProceso." and tipoElemento=0 and e.idPerfil=".$idPerfil;
			
		}
		$frmIgnorar=$con->obtenerListaValores($consulta);
		if($frmIgnorar=="")
			$frmIgnorar="-1";
		
		
		$consulta="select idFormulario,nombreFormulario from 900_formularios where idFrmEntidad=".$frmEntidad." and idProceso=".$idProceso." and idFormulario not in(".$frmIgnorar.
				") and tipoFormulario not in(10,12,13,14,15,20)";

		$arrFormularios="";
		$filas=$con->ObtenerFilas($consulta);
		
		while($f=$con->fetchRow($filas))
		{
			
			$hijos=obtenerFormularios($f[0],$idProceso,-1,$tipoActor,$actor);
			if($hijos=='[]')
			{
				$nodoHoja='"leaf":true,';
			}
			else
			{
				$nodoHoja='"leaf":false,children:'.$hijos.",";
			}
			
			$nodoFormulario='	{
									"text":"'.$f[1].'",
									"id":"'.$f[0].'",
									"icon":"../images/s.gif",
									"allowDrop":false,
									"cls":"cssNodoArbolNivel2",
									"tipo":"0",
									"idModulo":"",'.$nodoHoja.
									'"checked":false
								}
							';		
			if($arrFormularios=="")
				$arrFormularios=$nodoFormulario;
			else
				$arrFormularios.=",".$nodoFormulario;
		}
		
		return "[".$arrFormularios."]";
	}
	
	function guardarElementosDTD()
	{
		global $con;
		$elementosDTD=$_POST["elementosDTD"];
		$obj=json_decode($elementosDTD);
		$idProceso=$obj->idProceso;
		$elementos=$obj->elementos;
		
		$tipoActor=-1;
		if(isset($obj->tipoActor))
			$tipoActor=$obj->tipoActor;
		
		$actor=-1;
		if(isset($obj->actor))
			$actor=$obj->actor;
		$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProceso." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
		$idPerfil=$con->obtenerValor($consulta);
		if($idPerfil=="")
			$idPerfil=-1;
		
		$x=0;
		
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso."  and formularioBase=1";
		$idFormularioBase=$con->obtenerValor($consulta);
		
		$query[$x]="begin";
		$x++;
		$queryAux="select max(orden) from 203_elementosDTD where idProceso=".$idProceso;
		if($idPerfil!=-1)
			$queryAux.=" and idPerfil=".$idPerfil;
		$orden=$con->obtenerValor($queryAux);
		$orden++;
		foreach($elementos as $elemento)
		{
			if($elemento->tipo=="1")//modulo
			{
				$queryAux="select modulo,tablaAsociada from 200_modulosPredefinidosProcesos where idGrupoModulo=".$elemento->idModulo;
				$fModulo=$con->obtenerPrimeraFila($queryAux);
				$nombreFuncion=$fModulo[0];
				$tablaAsoc=$fModulo[1];
				$queryAux="insert into 900_formularios(nombreFormulario,titulo,asociadoProceso,idProceso,idEtapa,tipoFormulario,idFrmEntidad,nombreTabla) 
						values('".$nombreFuncion."','".$elemento->idModulo."',1,".$idProceso.",1,10,".$idFormularioBase.",'".$tablaAsoc."')";
				
				if($con->ejecutarConsulta($queryAux))
				{
					$idFormulario=$con->obtenerUltimoID();
				}
				if($tipoActor==-1)
				{
					$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,idPerfil) values(".$idProceso.",".$idFormulario.",".$elemento->tipo.",".$orden.",-1)";
					$x++;
				}
				else
				{
					
					$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,noEtapa,idPerfil) values(".$idProceso.",".$idFormulario.",".$elemento->tipo.",".$orden.",1,".$idPerfil.")";
					$x++;
				}
				if($elemento->idModulo==6)
				{
					$tProceso=obtenerTipoProceso($idProceso);
					$consulta="select idModuloVSProceso from 201_modulosPredefinidosVSProcesos where idGrupoModulo=6 and tipoProceso=".$tProceso;
					if($con->obtenerValor($consulta)=="")
					{
						$query[$x]="insert into 201_modulosPredefinidosVSProcesos(idGrupoModulo,tipoProceso) values(6,".$tProceso.")";
						$x++;	
					}
				}
			}
			else  //Formulario
			{
				if($tipoActor==-1)
				{
					$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,noEtapa,idPerfil) values(".$idProceso.",".$elemento->idFormulario.",".$elemento->tipo.",".$orden.",1,-1)";
					$x++;
				}
				else
				{
					$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProceso." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
					$idPerfil=$con->obtenerValor($consulta);
					$consulta="select idEtapa from 900_formularios where idFormulario=".$elemento->idFormulario;
					$noEtapa=$con->obtenerValor($consulta);
					
					$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,noEtapa,idPerfil) values(".$idProceso.",".$elemento->idFormulario.",".$elemento->tipo.",".$orden.",".$noEtapa.",".$idPerfil.")";
					$x++;
				}
			}
			$orden++;
		}
		$query[$x]="commit";

		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarLineasAccion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$lineas=$_POST["lineas"];
		$arrLineas=explode(",",$lineas);
		$idLineaInv=$_POST["idLineaInv"];
		$nLineas=sizeof($arrLineas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($y=0;$y<$nLineas;$y++)
		{
			$query="select * from 241_proyectosVSLineasAccion where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." 
					and idLineaInvestigacion=".$idLineaInv." and idLineaAccion=".$arrLineas[$y];
			$fLineaAccion=$con->obtenerPrimeraFila($query);
			if(!$fLineaAccion)
			{
				$consulta[$x]="insert into 241_proyectosVSLineasAccion(idLineaAccion,idFormulario,idReferencia,idLineaInvestigacion) values(".$arrLineas[$y].",".$idFormulario.",".$idRegistro.",".$idLineaInv.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerLineaAccion()
	{
		global $con;
		$idLinea=$_POST["idLinea"];
		$consulta="delete from 241_proyectosVSLineasAccion where id_241_proyectosVSLineasAccion=".$idLinea;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarLineasInv()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$lineas=$_POST["lineas"];
		$arrLineas=explode(",",$lineas);
		$nLineas=sizeof($arrLineas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="select id_240_proyectosVSLineasInvestigacion from 240_proyectosVSLineasInvestigacion li where 
				li.idFormulario=".$idFormulario." and li.idReferencia=".$idRegistro. " and lineaPrincipal=1";
		$lineaP=$con->obtenerValor($query);
		if($lineaP=="")
			$lineaP=1;
		else
			$lineaP=0;
		
		for($y=0;$y<$nLineas;$y++)
		{
			$consulta[$x]="insert into 240_proyectosVSLineasInvestigacion(idLineaInvestigacion,idFormulario,idReferencia,lineaPrincipal) values(".$arrLineas[$y].",".$idFormulario.",".$idRegistro.",".$lineaP.")";
			$x++;
			$lineaP=0;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerLineaInv()
	{
		global $con;
		$idLinea=$_POST["idLinea"];
		
		$query="select * from 240_proyectosVSLineasInvestigacion where id_240_proyectosVSLineasInvestigacion=".$idLinea;
		$fila=$con->obtenerPrimeraFila($query);
		$idFormulario=$fila[2];
		$idRegistro=$fila[3];
		$lineaPrincipal=$fila[4];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 240_proyectosVSLineasInvestigacion where id_240_proyectosVSLineasInvestigacion=".$idLinea;
		$x++;
		if($lineaPrincipal==1)
		{
			$query="select if(min(id_240_proyectosVSLineasInvestigacion) is null,-1,min(id_240_proyectosVSLineasInvestigacion)) as principal 
					from 240_proyectosVSLineasInvestigacion where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
			$idLineaInvestigacion=$con->obtenerValor($query);
			if($idLineaInvestigacion!="-1")
			{
				$consulta[$x]="update 240_proyectosVSLineasInvestigacion set lineaPrincipal=1 where id_240_proyectosVSLineasInvestigacion=".$idLineaInvestigacion;
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerRolesFunciones()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$query="select * from 2007_rolesVSComites where idComite=".$idComite;
		$res=$con->obtenerFilas($query);
		$arrRolesF="";
		while($fila=$con->fetchRow($res))
		{
			$arrRoles=explode("_",$fila[1]);			
			$query="select nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and idRol=".$arrRoles[0];
			$nombreRol=$con->obtenerValor($query);
			if($arrRoles[1]!='0')
			{
				$query="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRoles[1];
				$extension=$con->obtenerValor($query);
				$nombreRol.=" (".$extension.")";
			}
			
			$funcionesRol=obtenerFuncionesRol($fila[0]);
			if($funcionesRol=="")
				$confHoja='"leaf":true,';
			else
				$confHoja='"leaf":false,children:['.$funcionesRol.'],';
			
			$obj='			{	
								"text":"'.$nombreRol.'",
								"id":"'.$fila[1].'",
								"idRolComite":"'.$fila[0].'",
								"icon":"../images/user.png",
								"tipo":"1",'.$confHoja.
								'"allowDrop":false
							}';
			if($arrRolesF=="")
				$arrRolesF=$obj;
			else	
				$arrRolesF.=",".$obj;
		}
		echo "[".uEJ($arrRolesF)."]";
		
	}
	
	function obtenerFuncionesRol($idRolVSComite)
	{
		global $con;
		$query="select r.idRolComiteFunciones,f.descripcion from 2009_rolesComitesFunciones r,2008_funcionesComite f 
				where f.idFuncionComite=r.idFuncionComite and idRolVSComite=".$idRolVSComite;
		
		$res=$con->obtenerFilas($query);
		$funcionesRol="";
		$ct=1;
		while($fila=$con->fetchRow($res))
		{
			$obj='	{	
								"text":"'.$ct.".- ".$fila[1].'",
								"id":"'.$fila[0].'",
								"icon":"../images/page_process.png",
								"tipo":"2",
								"leaf":true,
								"allowDrop":false
							}';
			if($funcionesRol=="")
				$funcionesRol=$obj;
			else	
				$funcionesRol.=",".$obj;
			$ct++;
		}
		return $funcionesRol;
	}
	
	function guardarRol()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$rol=$_POST["rol"];
		$evaluado=$_POST["evaluado"];
		$tiempoPermanencia=$_POST["tiempoPermanencia"];
		$consulta="insert into 2007_rolesVSComites(rol,idComite,evaluado,tiempoPermanencia) values('".$rol."',".$idComite.",".$evaluado.",'".$tiempoPermanencia."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarRolFuncion()
	{
		global $con;
		$id=$_POST["id"];
		$tipo=$_POST["tipo"];
		$idComite=$_POST["idComite"];
		$consulta[0]="begin";
		if($tipo=="1")
		{
			$query="select idRolVSComite from 2007_rolesVSComites where rol='".$id."' and idComite=".$idComite;
			$idRolVSComite=$con->obtenerValor($query);
			$consulta[1]="delete from 2007_rolesVSComites where rol='".$id."' and idComite=".$idComite;
			$consulta[2]="delete from 2009_rolesComitesFunciones where idRolVSComite=".$idRolVSComite;
			$consulta[3]="delete from 942_funcionesRoles where proceso='comites' and idReferencia=".$idRolVSComite;
			$consulta[4]="commit";
		}
		else
		{
			$query="select * from 2009_rolesComitesFunciones where idRolComiteFunciones=".$id;
			$fila=$con->obtenerPrimeraFila($query);
			$x=0;
			$consulta[$x]="delete from 942_funcionesRoles where proceso='comites' and idReferencia=".$fila[1]." and complementario=".$fila[2];
			$x++;	
			
			
			$consulta[$x]="delete from 2009_rolesComitesFunciones where idRolComiteFunciones=".$id;
			$x++;
			$consulta[$x]="commit";
			$x++;
		}
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerFuncionesDisponibles()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$rol=$_POST["rol"];
		$consulta="select idRolVSComite from 2007_rolesVSComites where rol='".$rol."' and idComite=".$idComite;
		$idRolVSComite=$con->obtenerValor($consulta);
		$consulta="	select idFuncionComite,descripcion from 2008_funcionesComite where 
					idFuncionComite not in(select idFuncionComite from 2009_rolesComitesFunciones where idRolVSComite=".$idRolVSComite.")";
		$arrValores=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrValores);
	}
	
	function guardarFuncionesRol()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$rol=$_POST["rol"];
		$funciones=$_POST["funciones"];
		$arrFunciones=explode(",",$funciones);
		$consulta="select idRolVSComite from 2007_rolesVSComites where rol='".$rol."' and idComite=".$idComite;
		$idRolVSComite=$con->obtenerValor($consulta);
		$nFunciones=sizeof($arrFunciones);
		$x=0;
		$query[$x]="begin";
		$x++;
		for($y=0;$y<$nFunciones;$y++)
		{
			$query[$x]="insert into 2009_rolesComitesFunciones(idRolVSComite,idFuncionComite) values(".$idRolVSComite.",".$arrFunciones[$y].")";
			$x++;
			if($arrFunciones[$y]=="5")
			{
				$query[$x]="insert into 942_funcionesRoles(rol,permisos,proceso,idReferencia,complementario) values('".$rol."','M_R_P','comites',".$idRolVSComite.",5)";
				$x++;
			}
			if($arrFunciones[$y]=="6")
			{
				$query[$x]="insert into 942_funcionesRoles(rol,permisos,proceso,idReferencia,complementario) values('".$rol."','C_F_P','comites',".$idRolVSComite.",6)";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerComitesParticipantesDisponibles()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$numEtapa=$_POST["numEtapa"];
		if(!isset($_POST["participantes"]))
		{
			$consulta="select c.idComite,c.nombreComite from 2006_comites c ,235_proyectosVSComites pc
					where c.idComite=pc.idComite and pc.idProyecto=".$idProyecto." and c.idComite not in(select idComite from 234_proyectosVSComitesVSEtapas  where  idProyecto=".$idProyecto." and numEtapa=".$numEtapa.")";
		}
		else
		{
			$consulta="select idFormulario from 900_formularios where idProceso=".$idProyecto." and titulo='3'";	
			$idFrm=$con->obtenerValor($consulta);
			if($idFrm!="")
			{
			
				$consulta="select complementario from 203_elementosDTD where idFormulario=".$idFrm;
				$complementario=$con->obtenerValor($consulta);
				$arrConf=explode(",",$complementario);
				$consulta="SELECT idElementoPerfilAutor,descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idPerfilAutor=".$arrConf[0]." and
							idElementoPerfilAutor not in (select idParticipante from 995_proyectosVSParticipantesVSEtapas where idProyecto=".$idProyecto." and numEtapa=".$numEtapa.")";
			}
			else
				$arrComites='[]';
		}
		$arrComites=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrComites);
	}
	
	function actualizarPosicionElementoDTD()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$posicion=$_POST["posicion"];
		
		$consulta="select orden,idProceso from 203_elementosDTD where idElementoDTD=".$idElemento;
		$fila=$con->obtenerPrimeraFila($consulta);
		$posAnterior=$fila[0];
		$idProceso=$fila[1];
		
		$query[0]="begin";
		if($posAnterior>$posicion)
			$query[1]="update 203_elementosDTD set orden=orden+1 where orden<".$posAnterior." and orden>=".$posicion." and idProceso=".$idProceso;
		else
			$query[1]="update 203_elementosDTD set orden=orden-1 where orden<=".$posicion." and orden>".$posAnterior." and idProceso=".$idProceso;
		$query[2]="update 203_elementosDTD set orden=".$posicion." where idElementoDTD=".$idElemento;
		$query[3]="commit";
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarElementoDTD()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$consulta="select orden,idProceso,tipoElemento,idFormulario from 203_elementosDTD where idElementoDTD=".$idElemento;
		$fila=$con->obtenerPrimeraFila($consulta);
		$posAnterior=$fila[0];
		$idProceso=$fila[1];
		$tipo=$fila[2];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 203_elementosDTD where idElementoDTD=".$idElemento;
		$x++;
		$query[$x]="update 203_elementosDTD set orden=orden-1 where orden>".$posAnterior." and idProceso=".$idProceso;
		$x++;
		
		$query[$x]="delete from 900_formularios where idFormulario=".$fila[3];
		$x++;
		
		$query[$x]="commit";
		$x++;		
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
		
		
	}
	
	function obtenerElementosDTD()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idComite,nombreComite,descripcion from 2006_comites ";
		$arrComites=$con->obtenerFilasArreglo($consulta);
		
		$consulta="select nombreFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$nombreFormulario=$con->obtenerValor($consulta);
		
		$consulta="select * from 203_elementosDTD where idProceso=".$idProceso." order by orden";
		
		$filas=$con->obtenerFilas($consulta);
		$nodosElementos="";
		while($f=$con->fetchRow($filas))
		{
			$consulta="select * from 900_formularios where idFormulario=".$f[1];
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			
			if($f[2]=="1")
			{
				$nodo='{
							id:"'.$f[0].'",
							text:"'.uEJ($filaFrm[1]).'",
							tituloO:"'.uEJ($filaFrm[1]).'",
							funciones:"",
							draggable:true,
							tipo:"1",
							leaf:true,
							idModulo:'.$filaFrm[6].',
							allowDrop:false,
							"draggable" :false,
							"checked":false
						}';
			}
			else
			{
				$nodo='{
							id:"'.$f[0].'",
							text:"'.uEJ($filaFrm["1"]).'",
							tituloO:"'.uEJ($filaFrm[1]).'",
							funciones:"",
							draggable:true,
							tipo:"0",
							leaf:true,
							allowDrop:false,
							"draggable" :false,
							"checked":false
						}';
			}
			if($nodosElementos=="")
				$nodosElementos=$nodo;
			else
				$nodosElementos.=",".$nodo;
		}
		
		echo "1|[".uEJ($nodosElementos)."]";
	}
	
	function guardarDatosComites()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$comites=$_POST["comites"];
		$numEtapa=$_POST["numEtapa"];
		$arrComites=explode(",",$comites);
		$nComites=sizeof($arrComites);
		$x=0;
		$query[$x]="begin";		
		$x++;
		for($y=0;$y<$nComites;$y++)
		{
			if(!isset($_POST["participantes"]))
				$query[$x]="insert into 234_proyectosVSComitesVSEtapas(idProyecto,idComite,numEtapa) values(".$idProyecto.",".$arrComites[$y].",".$numEtapa.")";		
			else
				$query[$x]="insert into 995_proyectosVSParticipantesVSEtapas(idProyecto,idParticipante,numEtapa) values(".$idProyecto.",".$arrComites[$y].",".$numEtapa.")";		
			$x++;
		}
		$query[$x]="commit";		
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarDatosComites()
	{
		global $con;
		$id=$_POST["id"];
		$tipo=$_POST["tipo"];
		$tProceso=$_POST["tProceso"];
		if($tipo=="1")
		{
			$arrId=explode("_",$id);
			$id=$arrId[1];
		}
		$x=0;
		$query[$x]="begin";		
		$x++;
		
		if($tProceso==9)
		{
			if($tipo=="1")
			{
				$query[$x]="delete from 234_proyectosVSComitesVSEtapas where idProyectoVSComiteVSEtapa=".$id;		
				$x++;
				$query[$x]="delete from 9044_proyectoComitePartida where idComitePartida=".$id;		
				$x++;
			}
			else
			{
				$query[$x]="delete from 9044_proyectoComitePartida where idComitePartida=".$id;		
				$x++;
			}
		}
		else
		{
			if($tipo=="1")
			{
				$query[$x]="delete from 234_proyectosVSComitesVSEtapas where idProyectoVSComiteVSEtapa=".$id;		
				$x++;
				$query[$x]="delete from 245_proyectosComitesElementosDTD where idProyectoComite=".$id;		
				$x++;
				$query[$x]="delete from 9044_proyectoComitePartida where idProyectoComite=".$id;		
				$x++;
			}
			else
			{
				$query[$x]="delete from 245_proyectosComitesElementosDTD where idProyectoComiteElementosDTD=".$id;		
				$x++;
				$query[$x]="delete from 9044_proyectoComitePartida where idProyectoComite=".$id;		
				echo $query[$x];
				$x++;
			}
		}
		
		
		$query[$x]="commit";		
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerComitesElementosDTD()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT idTipoProceso FROM 4001_procesos WHERE idProceso=".$idProyecto;
		$tProceso=$con->obtenerValor($consulta);

		$query="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProyecto." and numEtapa>1 order by numEtapa";
		$resEtapa=$con->obtenerFilas($query);
		$arrEtapasComites="";
		while($fEtapa=$con->fetchRow($resEtapa))
		{
			$query="select * from 234_proyectosVSComitesVSEtapas where idProyecto=".$idProyecto." and numEtapa=".$fEtapa[0];
			$res=$con->obtenerFilas($query);
			$arrComites="";
			$eDTDHijos="[]";
			while($fila=$con->fetchRow($res))
			{
				$query="select nombreComite from 2006_comites where idComite=".$fila[2];
				$nomComite=$con->obtenerValor($query);
				$eDTDHijos=obtenerElementosDTDHijos($fila[0],$tProceso);
				
				if($eDTDHijos=="[]")
					$hijos='"leaf":true,';
				else
					$hijos='"leaf":false,"children":'.$eDTDHijos.',';
					$titulo="<span class='copyright'>".$nomComite."</span>";
				
				$objComite='	{	
									"text":"<font color=\'#990000\'><b>Comit&eacute;:</b></font> '.$titulo.'",
									"tituloO":"'.$nomComite.'",
									"id":"c_'.$fila[0].'",
									"icon":"../images/users.png",
									"cls":"x-btn-text-icon",
									"tipo":"1",
									"funciones":'.$fila[3].','.$hijos.'
									"allowDrop":false,
									"draggable" :false
	
								}';
				
				if($arrComites=="")
					$arrComites=$objComite;
				else
					$arrComites.=','.$objComite;
			}
			$hijosEtapaComite="leaf:true";
			if($arrComites=="")
				$hijosEtapaComite="leaf:true";
			else
				$hijosEtapaComite="leaf:false,children:[".$arrComites."]";
			
			$objEtapaComite='	{	
								"text":"<font color=\'#000066\'><b>Etapa:</b></font> '.removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1].'",
								"id":"e_'.$fEtapa[0].'",
								"numEtapa":"'.$fEtapa[0].'",
								"cls":"x-btn-text-icon",
								"icon":"../images/s.gif",
								"tipo":"2",
								"allowDrop":false,
								"draggable" :false,
								'.$hijosEtapaComite.'

							}';
			
			if($arrEtapasComites=="")
				$arrEtapasComites=$objEtapaComite;
			else
				$arrEtapasComites.=','.$objEtapaComite;
		}
		
		echo "[".uEJ($arrEtapasComites)."]";
		return;
		
	}
	
	function obtenerElementosDTDHijos($idProyectoComite,$tProceso)
	{
		global $con;
		switch($tProceso)
		{
			case "9":
				$query="SELECT o.clave,o.nombreObjetoGasto,'\"\"' as permisos, p.idComitePartida FROM 9044_proyectoComitePartida p,507_objetosGasto o WHERE o.codigoControl=p.partida AND idProyectoComite=".$idProyectoComite." order by p.partida";
			break;
			default:
				$query="select e.idProyectoComiteElementosDTD,f.nombreFormulario,e.funciones,eD.tipoElemento from 245_proyectosComitesElementosDTD e,203_elementosDTD eD,900_formularios f 
						where  eD.idElementoDTD=e.idElemento and f.idFormulario=eD.idFormulario and e.idProyectoComite=".$idProyectoComite;
			break;
		}
		$arrObj="";
		$compAnt="";
		$res=$con->obtenerFilas($query);
		$idNodo;
		while($fila=$con->fetchRow($res))
		{
			switch($tProceso)
			{
				case "9":
					$titulo="[".$fila[0]."] ".$fila[1];
					$idNodo=$fila[3];
				break;
				default:
					if($fila[2]=="0")
						$titulo=$fila[1]." (<font color='darkred'><b>S&oacute;lo Lectura</b></font>)";
					else
						$titulo=$fila[1]." <b>Funci&oacute;n:</b> <font color='blue'><b>Ver y dictaminar</b></font>";
					$compAnt="";
					if($fila[3]==2)
						$compAnt="<font color='#990000'><b>Proceso:</b></font>&nbsp;";
					$idNodo=$fila[0];
				break;
			}
			
			$objDTD='
						{	
							"text":"'.$compAnt.$titulo.'",
							"tituloO":"'.$compAnt.$fila[1].'",
							"id":"'.$idNodo.'",
							"icon":"../images/s.gif",
							"tipo":"0",
							"leaf":true,
							"funciones":'.$fila[2].',
							"allowDrop":false,
							"draggable" :false

						}
				';
			
			
			if($arrObj=="")
				$arrObj=$objDTD;
				
			else
				$arrObj.=",".$objDTD;
		}
		return "[".$arrObj."]";
	}
	
	function obtenerElementosDTDDisponiblesComite()
	{
		global $con;
		$idProceso=$_POST["idProyecto"];
		$cadProyecto=$_POST["idProyectoComite"];
		$arrProyecto=explode("_",$cadProyecto);
		$idProyectoComite=$arrProyecto[1];
		
		$consulta="select * from 203_elementosDTD where idProceso=".$idProceso." and idFormulario 
					not in(select ed.idFormulario from 245_proyectosComitesElementosDTD pc,203_elementosDTD ed  
					where ed.idElementoDTD=pc.idElemento and pc.idProyectoComite=".$idProyectoComite.") order by orden";
		
		$filas=$con->obtenerFilas($consulta);
		$nodosElementos="";
		while($f=$con->fetchRow($filas))
		{
			$consulta="select * from 900_formularios where idFormulario=".$f[1];
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			switch($f[2])
			{
				case 0:
					$nodo='{
							id:"'.$f[0].'",
							text:"'.uEJ($filaFrm["1"]).'",
							tituloO:"'.uEJ($filaFrm[1]).'",
							funciones:"",
							draggable:true,
							tipo:"0",
							leaf:true,
							allowDrop:false,
							"draggable" :false,
							"checked":false
						}';
				break;	
				case 1:
					$nodo='{
							id:"'.$f[0].'",
							text:"'.uEJ($filaFrm[1]).'",
							tituloO:"'.uEJ($filaFrm[1]).'",
							funciones:"",
							draggable:true,
							tipo:"1",
							leaf:true,
							idModulo:'.$filaFrm[6].',
							allowDrop:false,
							"draggable" :false,
							"checked":false
						}';
				break;	
				case 2:
					$nodo='{
							id:"'.$f[0].'",
							text:"<font color=\'#990000\'><b>Proceso:</b></font>&nbsp;'.uEJ($filaFrm["1"]).'",
							tituloO:"'.uEJ($filaFrm[1]).'",
							funciones:"",
							draggable:true,
							tipo:"0",
							leaf:true,
							allowDrop:false,
							"draggable" :false,
							"checked":false
						}';
				break;	
			}
			
			if($nodosElementos=="")
				$nodosElementos=$nodo;
			else
				$nodosElementos.=",".$nodo;
		}
		echo "[".uEJ2($nodosElementos)."]";
	}
	
	function guardarElementosDTDComite()
	{
		global $con;
		$cadProyecto=$_POST["idProyectoComite"];
		$arrProyecto=explode("_",$cadProyecto);
		$idProyectoComite=$arrProyecto[1];
		$listadoE=$_POST["listadoE"];
		$arrElementos=explode(",",$listadoE);
		$nElementos=sizeof($arrElementos);
		$x=0;
		$query[$x]="begin";		
		$x++;	
		for($y=0;$y<$nElementos;$y++)
		{
			if(!isset($_POST['participante']))
				$query[$x]="insert into 245_proyectosComitesElementosDTD(idProyectoComite,idElemento,funciones) values(".$idProyectoComite.",".$arrElementos[$y].",0)";		
			else
				$query[$x]="insert into 996_proyectosParticipantesElementosDTD(idProyectoParticipante,idElemento,funciones) values(".$idProyectoComite.",".$arrElementos[$y].",0)";		
			$x++;	
		}
		$query[$x]="commit";		
		$x++;	
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarFuncionComiteElemento()
	{
		global $con;
		$tipoCambio=$_POST["tipo"]; //0 Funcion sobre comite;1 Funcion sobre elemento
		$valorFuncion=$_POST["valorFuncion"];
		$id=$_POST["id"];
		if($tipoCambio=="1")
		{
			$arrId=explode("_",$id);
			$id=$arrId[1];
		}
		
		
		if($tipoCambio=="1")
			$consulta="update 239_proyectosVSComites set agregaFrmD=".$valorFuncion." where idProyectoComite=".$id;
		else
			$consulta="update 245_proyectosComitesElementosDTD set funciones=".$valorFuncion." where idProyectoComiteElementosDTD=".$id;
		
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerElementosDTDProyectos()
	{
		global $con;
		
		$idProceso=$_POST["idProyecto"];
		
		$tipoActor=-1;
		if(isset($_POST["tipoActor"]))
			$tipoActor=$_POST["tipoActor"];
		
		$actor=-1;
		if(isset($_POST["actor"]))
			$actor=$_POST["actor"];
		
		
		$consulta="SELECT idFormulario,nombreFormulario FROM 900_formularios WHERE idProceso=".$idProceso." AND formularioBase=1";
		$fFrm=$con->obtenerPrimeraFila($consulta);
		
		

		$nodosElementos='{"id":"0","text":"'.cv($fFrm[1]).'","orden":"","tituloO":"","tipo":"0","obligatorio":"1","idFormulario":"'.$fFrm[0].
							'","noEtapa":"","idFuncionVisualizacion":"","idFuncionEdicion":"","lblFuncionVisualizacion":"","lblFuncionEdicion":""}';


		$consulta="select * from 203_elementosDTD where idProceso=".$idProceso." and (idPerfil=-1 or idPerfil is null) order by orden";
		$idPerfil=-1;
		if($tipoActor!=-1)
		{
			$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProceso." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
			$idPerfil=$con->obtenerValor($consulta);
			if($idPerfil=="")
			{
				$consulta="INSERT INTO 206_perfilesEscenarios(idProceso,tipoActor,actor) VALUES(".$idProceso.",".$tipoActor.",'".$actor."')";	
				$con->ejecutarConsulta($consulta);
				$idPerfil=$con->obtenerUltimoID();
			}
			if($idPerfil=="")
				$idPerfil=-1;
			
			$consulta="select * from 203_elementosDTD where idProceso=".$idProceso." and idPerfil=".$idPerfil."  order by orden ";
		}

		$filas=$con->obtenerFilas($consulta);

		$numReg=0;
		while($f=$con->fetchRow($filas))
		{
			
			$lblFuncionEdicion="";
			$lblFuncionVisualizacion="";
			$noEtapa=$f[10];
			
			$consulta="select * from 900_formularios where idFormulario=".$f[1];
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			$obligatorio='<font color="green">No</font>';
			if($f[5]=="1")
				$obligatorio='<font color="red">S&iacute;</font>';
			if(($f[8]!="")&&($f[8]!="0"))
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$f[8];
				$lblFuncionVisualizacion=$con->obtenerValor($consulta);
			}
			if($f[7]=="1")
			{
				$consulta="SELECT funcionExclusion FROM 203_funcionesExclusion WHERE idFormulario=".$f[1];
				$lblFuncionVisualizacion="<span style=\"color:#F00\">*</span> ".$con->obtenerValor($consulta);
			}
			if(($f[9]!="")&&($f[9]!="0"))
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$f[9];
				$lblFuncionEdicion=$con->obtenerValor($consulta);
			}
			
			
			if($noEtapa=="")
				$noEtapa=$filaFrm[13];

			switch($f[2])
			{
				case "0":
				
					$nodo='{"id":"'.$f[0].'","text":"'.uEJ($filaFrm["1"]).'","orden":"'.$f[4].'","tituloO":"'.uEJ($filaFrm[1]).
						'","tipo":"0","obligatorio":"'.$f[5].'","idFormulario":"'.$f[1].'","noEtapa":"'.$noEtapa.
						'","idFuncionVisualizacion":"'.$f[8].'","idFuncionEdicion":"'.$f[9].'","lblFuncionVisualizacion":"'.$lblFuncionVisualizacion.
						'","lblFuncionEdicion":"'.$lblFuncionEdicion.'","edicionForzada":"'.$f[14].'","requiereConfiguracion":"0"}';
				
				
					
				break;
				case "1":
					$objComplementario="";
					$complementario="";
					$compAutores="";
					$btnComp="";
					
					$consulta="SELECT paginaConfiguracionModulo,tablaConfiguracionAsociada FROM 200_modulosPredefinidosProcesos WHERE idGrupoModulo=".$filaFrm[6];
					$fModulo=$con->obtenerPrimeraFila($consulta);
					$configuracion=$fModulo[0];
					
					if(($configuracion!="")&&($fModulo[1]!=""))
					{
						$consulta="select count(*) from ".$fModulo[1]." where idProceso=".$idProceso." and idPerfil=".$idPerfil;
						$nConfiguraciones=$con->obtenerValor($consulta);
						if($nConfiguraciones==0)
							$btnComp="&nbsp;&nbsp;<img src=\"../images/warning.png\" title=\"Este m&oacute;dulo requiere ser configurado para su uso, para hacerlo seleccione el elemento y de click en la opci&oacute;n de Modificar configuraci&oacute;n del m&oacute;dulos  \">";
					}
					
					$nodo='{"id":"'.$f[0].'","text":"'.uEJ($filaFrm[1]).'","orden":"'.$f[4].'","tituloO":"'.uEJ($filaFrm[1]).
						'","tipo":"1","obligatorio":"'.$f[5].'","idFormulario":"'.$f[1].'","noEtapa":"'.$noEtapa.
						'","idFuncionVisualizacion":"'.$f[8].'","idFuncionEdicion":"'.$f[9].'","lblFuncionVisualizacion":"'.$lblFuncionVisualizacion.
						'","lblFuncionEdicion":"'.$lblFuncionEdicion.'","conf":"'.$configuracion.'","idModulo":"'.($filaFrm[6].",".$compAutores).
						'","edicionForzada":"'.$f[14].'","complementario":"'.$complementario.'","requiereConfiguracion":"'.($btnComp!=""?"1":"0").'"}';
					
				break;
				case "2":
					$complementario=$f[6];
					$btnComp="";
					if($complementario=="")
						$btnComp="&nbsp;&nbsp;<img src='../images/warning.png' title=\"Este m&oacute;dulo requiere ser configurado para su uso, para hacerlo seleccione el elemento y de click en la opci&oacute;n de Modificar configuraci&oacute;n del m&oacute;dulos  \">";
					
					
					$nodo='{"id":"'.$f[0].'","text":"Proceso: '.uEJ($filaFrm[1]).'","orden":"'.$f[4].
							'","tituloO":"Proceso: '.(uEJ($filaFrm[1])).'","tipo":"1","obligatorio":"'.$f[5].'","idFormulario":"'.$f[1].'","noEtapa":"'.$noEtapa.
						'","idFuncionVisualizacion":"'.$f[8].'","idFuncionEdicion":"'.$f[9].'","lblFuncionVisualizacion":"'.$lblFuncionVisualizacion.
						'","edicionForzada":"'.$f[14].'","lblFuncionEdicion":"'.$lblFuncionEdicion.'","complementario":"'.$complementario.
						'","requiereConfiguracion":"'.($btnComp!=""?"1":"0").'"}';
					
					
				break;
			}
			
			if($nodosElementos=="")
				$nodosElementos=$nodo;
			else
				$nodosElementos.=",".$nodo;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$nodosElementos.']}';
		
		
		
	}
	
	function obtenerAutor()
	{
		global $con;
		$cadObjJson=$_POST["datosAutor"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$objJson=json_decode($cadObjJson);
		$condWhere="";
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$consulta="SELECT idElementoDTD FROM 203_elementosDTD WHERE tipoElemento=1 AND idProceso=".$idProceso;
		$idElementoDTD=$con->obtenerValor($consulta);
		$consulta="SELECT configuracion FROM 205_infoComplementariaModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;
		$configuracion=$con->obtenerValor($consulta);
		
		
		$permitirAgregarUsr=false;
		
		if($configuracion!="")
		{
			$configuracion=json_decode($configuracion);
			if($configuracion->mas1Participacion==1)
				$permitirAgregarUsr=true;
			else
				$permitirAgregarUsr=false;
			
		}
			
		if($objJson->apPaterno!="")
		{
			$condWhere=" Paterno like '".uEJ($objJson->apPaterno)."%'";
		}
		if($objJson->apMaterno!="")
		{
			if($condWhere!="")
			
				$condWhere.=" and ";	
			$condWhere.=" Materno like '".uEJ($objJson->apMaterno)."%'";
		}
		if($objJson->nombres!="")
		{
			if($condWhere!="")
				$condWhere.=" and ";	
			$condWhere.=" Nom like '".uEJ($objJson->nombres)."%'";
		}
		if(!$permitirAgregarUsr)
		{
			$consulta="select idUsuario,Nom,Paterno,Materno from 802_identifica where ".$condWhere." and idUsuario not 
					in(select idUsuario from 246_autoresVSProyecto where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." ) and Status<>0";
		}
		else
			$consulta="select idUsuario,Nom,Paterno,Materno from 802_identifica where Status<>0 and ".$condWhere;
		
		$res=$con->obtenerFilas($consulta);
		$numElementos=$con->filasAfectadas;
		$arrAutores="";
		while($filas=$con->fetchRow($res))
		{
			$obj='{"idAutor":"'.$filas[0].'","apPat":"'.cv($filas[2]).'","apMat":"'.cv($filas[3]).'","nombres":"'.cv($filas[1]).'","fichaOrg":"'.cv(obtenerAfiliacion($filas[0])).'"}';
			if($arrAutores=="")
				$arrAutores=$obj;
			else
				$arrAutores.=",".$obj;
		}
		echo '{"numAutores":"'.$numElementos.'","autores":['.uEJ($arrAutores).']}';
	}
	
	function guardarAutor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAutor=$_POST["idAutor"];
		$orden=$_POST["orden"];
		$claveParticipacion=$_POST["participa"];
		$consulta="insert into 246_autoresVSProyecto(idUsuario,idFormulario,idReferencia,orden,claveParticipacion) values(".$idAutor.",".$idFormulario.",".$idRegistro.",".$orden.",'".$claveParticipacion."')";
		if($con->ejecutarConsulta($consulta))	
		{
			$idAutor=$con->obtenerUltimoID();
			$idProceso=obtenerIdProcesoFormulario($idFormulario);
			$consulta="SELECT idElementoDTD FROM 203_elementosDTD WHERE tipoElemento=1 AND idProceso=".$idProceso;
			$idElementoDTD=$con->obtenerValor($consulta);
			$consulta="SELECT configuracion FROM 205_infoComplementariaModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;
			$configuracion=$con->obtenerValor($consulta);
			if($configuracion!="")
			{
				$configuracion=json_decode($configuracion);
				if($configuracion->funcionAgregar!="")
				{
					eval($configuracion->funcionAgregar."(".$idFormulario.",".$idRegistro.",".$idAutor.");");
				}
				
				
			}
			echo "1|".$idAutor;
		}
		else
			echo "|";
	}
	
	function eliminarAutor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAutor=$_POST["idAutor"];
		$orden=$_POST["orden"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 246_autoresVSProyecto where id_246_autoresVSProyecto=".$idAutor;
		$x++;
		$consulta[$x]="update 246_autoresVSProyecto set orden=orden-1 where orden>".$orden." and idReferencia=".$idRegistro." and idFormulario=".$idFormulario;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))	
		{
			$idProceso=obtenerIdProcesoFormulario($idFormulario);
			$consulta="SELECT idElementoDTD FROM 203_elementosDTD WHERE tipoElemento=1 AND idProceso=".$idProceso;
			$idElementoDTD=$con->obtenerValor($consulta);
			$consulta="SELECT configuracion FROM 205_infoComplementariaModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;
			$configuracion=$con->obtenerValor($consulta);
			if($configuracion!="")
			{
				$configuracion=json_decode($configuracion);
				if($configuracion->funcionRemover!="")
				{
					eval($configuracion->funcionRemover."(".$idFormulario.",".$idRegistro.",".$idAutor.");");
				}
				
				
			}	
			echo "1|";
		}
		else
			echo "|";
		
	}
	
	function modificarOrdenAutor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAutor=$_POST["idAutor"];
		$nValor=$_POST["nValor"];
		$vValor=$_POST["vValor"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($nValor>$vValor)
			$consulta[$x]="update 246_autoresVSProyecto set orden=orden-1 where orden>".$vValor." and orden<=".$nValor."  and idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		else
			$consulta[$x]="update 246_autoresVSProyecto set orden=orden+1 where orden>=".$nValor." and orden<".$vValor."  and idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$x++;
		$consulta[$x]="update 246_autoresVSProyecto set orden=".$nValor." where idUsuario=".$idAutor." and idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerInstituciones()
	{
		global $con;
		$nomInst=$_POST["nomInst"];
		$consulta="select o.idOrganigrama,o.unidad,cp,ciudad,estado,p.nombre,o.codigoUnidad,i.idPais from 247_instituciones i,
		238_paises p,817_organigrama o  where o.STATUS=1 and o.idOrganigrama=i.idOrganigrama and p.idPais=i.idPais and o.unidad like '".$nomInst."%'";
		
		$res=$con->obtenerFilas($consulta);
		$arrInstituciones="";
		$numInst=$con->filasAfectadas;
		while($fila=$con->fetchRow($res))
		{
			$desc="";
			$institucion=$fila[1];
			$cp=$fila[2];
			$ciudad=$fila[3];
			$estado=$fila[4];
			$pais=$fila[5];
			
			if($fila[7]==146)
			{
				$consulta="select localidad from 822_localidades where cveLocalidad='".$ciudad."'";
				$ciudad=$con->obtenerValor($consulta);
				$consulta="select estado from 820_estados where cveEstado='".$estado."'";
				$estado=$con->obtenerValor($consulta);
			}
			
			
			
			if($cp!="")
				$cp=" C.P. ".$cp.".";
			$desc=$ciudad;
			
			if($estado!="")
			{
				if($desc=="")
					$desc=$estado.", ".$pais.".".$cp;
				else
					$desc.=",".$estado.", ".$pais.".".$cp;
			}
			

			
			$obj='	{
						"idInst":"'.$fila[0].'",
						"nomInst":"'.$institucion.'",
						"desc":"'.$desc.'",
						"codigoUnidad":"'.$fila[6].'"
					}';
			if($arrInstituciones=="")
				$arrInstituciones=$obj;
			else
				$arrInstituciones.=",".$obj;
		}
		
		echo '{"inst":['.uEJ($arrInstituciones).'],"numInst":"'.$numInst.'"}';
	}
	
	function obtenerDepartamentos()
	{
		global $con;
		
		$consulta="select codigoFuncionalRaiz from 903_variablesSistema";
		$codFun=$con->obtenerValor($consulta);
		$tamCodigo=strlen($codFun);
		$codUnidad=$_POST["codUnidad"];
		global $lPorcionCodFun;
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoBusqueda=$codUnidad.$cadComodines;
		$codigoBusqueda=str_pad($codigoBusqueda,$tamCodigo,'0',STR_PAD_RIGHT);
		$codigoPadre=str_pad($codUnidad,$tamCodigo,'0',STR_PAD_RIGHT);
		
		$consulta="select codigoUnidad,unidad from  817_organigrama where codigoFuncional like '".$codigoBusqueda."' and codigoFuncional<>'".$codigoPadre."' order by unidad";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos);
		
	}
	
	function guardarDatosDepartamento()
	{
		global $con;
		$idPadre=$_POST["idPadre"];
		$departamento=$_POST["departamento"];
		$consulta="insert into 248_departamentosInstitucion (departamento,idPadre,fechaCreacion,responsable) values('".cv($departamento)."',".$idPadre.",'".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		if($con->ejecutarConsulta($consulta))
		{
			$idDepto=$con->obtenerUltimoId();
			echo "1|".$idDepto;
		}
		else
			echo "|";
	}
	
	function guardarNuevoUsuario($objParam=null)
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["datosAutor"];
		$objJson=json_decode($cadObjJson);
		
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$idFormulario=$objJson->idFormulario;
		$idRegistro=$objJson->idRegistro;
		$codInstitucion=$objJson->codInstitucion;
		$codDepto=$objJson->codDepto;
		$telefonos=$objJson->telefonos;
		$idIdioma="1";
		$password=generarPassword();
		$mailUsr=$mail;
		$status="5";
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.")";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$query="select ed.complementario,idElementoDTD from 203_elementosDTD ed,900_formularios f where f.idFormulario=ed.idFormulario and f.titulo=3 and ed.idProceso=".$idProceso;
		$filaAux=$con->obtenerPrimeraFila($query);
		$conf=$filaAux[0];
		$idElementoDTD=$filaAux[1];
		
		
		
		
		$query="select count(idUsuario) from 246_autoresVSProyecto where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$orden=$con->obtenerValor($query);
		$orden++;
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		
		$query="SELECT codigoRol FROM 204_rolesModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;
		$resRoles=$con->obtenerFilas($query);
		if($con->filasAfectadas==0)
		{
			$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",13,0,'13_0')";
			$x++;
		}
		else
		{
			while($filaRol=$con->fetchRow($resRoles))
			{
				if($filaRol[0]!="")
				{
					$dRol=explode("_",$filaRol[0]);
					$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",".$dRol[0].",".$dRol[1].",'".$filaRol[0]."')";
					$x++;
				}
			}	
		}
		
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 246_autoresVSProyecto (idUsuario,idFormulario,idReferencia,orden,claveParticipacion) 
						values(".$idUsuario.",".$idFormulario.",".$idRegistro.",".$orden.",".$objJson->idParticipacion.")";
		$x++;
		if($telefonos!="")
		{
			$arrTelefonos=explode(",",$telefonos);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode("_",$arrTelefonos[$y]);
				$tipo=$datosTel[0];
				$codArea=$datosTel[1];
				$lada=$datosTel[2];
				$tel=$datosTel[3];
				$ext=$datosTel[4];
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo.",".$idUsuario.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))		
		{
			if(isset($objJson->enviarMail)&&($objJson->enviarMail==1))
			{
				$link=$urlSitio."/principal/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario);
				$arrParametros='[
									["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
									["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
									["$nombre","'.$nombre.'"]
								]';
				$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idAccion":"2"}';
				if(enviarCircular($objEnvio))
					echo "1|".$idUsuario;
				else
					echo "|";
			}
			else
				echo "1|".$idUsuario;
		}
		else
			echo "|";
	}
	
	function obtenerEtapasDisponiblesComite()
	{
		global $con;
		$idProyectoComite=$_POST["idProyectoComite"];
		$arrProyecto=explode("_",$idProyectoComite);
		$idProyectoComite=$arrProyecto[1];
		$idProceso=$_POST["idProceso"];
		$consulta="select idComite from 239_proyectosVSComites where idProyectoComite=".$idProyectoComite;
		$idComite=$con->obtenerValor($consulta);
		$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa not in (select numEtapa from 234_proyectosVSComitesVSEtapas where idProyecto=".$idProceso." and idComite=".$idComite.")";
		$arrEtapas=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrEtapas);
	}
	
	function guardarEtapasComite()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadComite=$_POST["idComite"];
		$arrComite=explode("_",$cadComite);
		$idProyectoComite=$arrComite[1];
		$query="select idComite from 239_proyectosVSComites where idProyectoComite=".$idProyectoComite;
		$idComite=$con->obtenerValor($query);
		$numEtapas=$_POST["numEtapas"];
		$arrEtapas=explode(",",$numEtapas);
		$nEtapas=sizeof($arrEtapas);
		$x=0;

		$consulta[$x]="begin";
		$x++;

		for($y=0;$y<$nEtapas;$y++)
		{
			$consulta[$x]="insert into 234_proyectosVSComitesVSEtapas(idProyecto,idComite,numEtapa) values(".$idProceso.",".$idComite.",".$arrEtapas[$y].")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerComitesDisponiblesSeleccion()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="select idComite,nombreComite from 2006_comites where idComite not in(select idComite from 235_proyectosVSComites where idProyecto=".$idProyecto.")";
		$arrComites=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrComites);
	}
	
	function agregarComitesParticipantes()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$comites=$_POST["comites"];
		$arrComites=explode(',',$comites);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$nComites=sizeof($arrComites);
		for($y=0;$y<$nComites;$y++)
		{
			$consulta[$x]="insert into 235_proyectosVSComites (idProyecto,idComite) values (".$idProyecto.",".$arrComites[$y].")";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consulta="select pc.idProyectoVSComite,c.idComite,c.nombreComite,pc.agregarFrm from 235_proyectosVSComites pc,2006_comites c where c.idComite=pc.idComite and idProyecto=".$idProyecto;
			$arrComites=$con->obtenerFilasArreglo($consulta);
			echo "1|".uEJ($arrComites);
		}
		else
			echo "|";
	}
	
	function eliminarComitesParticipantes()
	{
		global $con;
		$comites=$_POST["comites"];
		$arrComites=explode(',',$comites);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$nComites=sizeof($arrComites);
		for($y=0;$y<$nComites;$y++)
		{
			$consulta[$x]="delete from  235_proyectosVSComites where idProyectoVSComite=".$arrComites[$y];
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}
		else
			echo "|";

	}
	
	function actualizarFuncionesComites()
	{
		global $con;
		$idProyectoVSComite=$_POST["idProyectoVSComite"];
		$valor=$_POST["valor"];
		$consulta="update 235_proyectosVSComites set agregarFrm=".$valor." where idProyectoVSComite=".$idProyectoVSComite;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarCondicionElemento()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$obligatorio=$_POST["obligatorio"];
		$consulta="update 203_elementosDTD set obligatorio=".$obligatorio." where idElementoDTD=".$idElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function generarTablaModulos()
	{
		global $con;
		global $accion;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select nombreFormulario,nombreTabla,idProceso from 900_formularios  where idFormulario=".$idFormulario;
		$idActor=base64_decode($_POST["actor"]);
		$filaFrm=$con->obtenerPrimeraFila($consulta);
		$nFormulario=$filaFrm[0];
		$nTabla=$filaFrm[1];
		$idProceso=$filaFrm[2];
		$enlace="javascript:enviarFichaProyecto(".$idFormulario.",\"".base64_encode("ver")."\")";
		
		$consulta="select idEstado from ".$nTabla." where id_".$nTabla."=".$idRegistro;
		$etapaReg=$con->obtenerValor($consulta);
		
		$consulta="select aa.idGrupoAccion,aa.complementario from 944_actoresProcesoEtapa ap,947_actoresProcesosEtapasVSAcciones aa where 
					aa.idActorProcesoEtapa=ap.idActorProcesoEtapa and ap.numEtapa=".$etapaReg." and ap.idProceso=".$idProceso." and ap.idActorProcesoEtapa=".$idActor;
		
		$resAcciones=$con->obtenerFilas($consulta);
		$arrAcciones=array();
		while($filaAcciones=$con->fetchRow($resAcciones))
		{
			$arrAcciones[$filaAcciones[0]]="".$filaAcciones[1];
		}
		
		$someteRevision=false;
		$modificaElementos=false;
		$asignaRevisores=false;
		$realizaDictamenF=false;
		$realizaDictamenP=false;
		$marcarElementos=false;
		
		if(isset($arrAcciones["1"])) //
			$someteRevision=true;
		if(isset($arrAcciones["2"])) ///
			$modificaElementos=true;
		if(isset($arrAcciones["3"]))
			$asignaRevisores=true;
		if(isset($arrAcciones["4"]))
			$realizaDictamenP=true;
		if(isset($arrAcciones["5"]))
			$realizaDictamenF=true;
		if(isset($arrAcciones["6"]))
			$marcarElementos=true;
		
		
		$consulta="select estado from 963_estadosElementoDTD where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$estado=$con->obtenerValor($consulta);
		
		if($estado=="1")
		{
			$btnBloqueado="&nbsp;<img src='../images/lock.png' alt='Elemento bloqueado, no puede ser editado' title='Elemento bloqueado, no puede ser editado'>";
			$elemBloqueado=true;
		}
		else
		{
			$elemBloqueado=false;
			$btnBloqueado="";
		}
		$btnBloqueoElem="";
		if($marcarElementos)
		{
			if($elemBloqueado)
				$btnBloqueoElem="&nbsp;<a href='javascript:quitarBloqueo(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_delete.png' title='Quitar bloqueo de edici&oacute;n' alt='Quitar bloqueo de edici&oacute;n'></a>";
			else
				$btnBloqueoElem="&nbsp;<a href='javascript:bloquearElemento(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_add.png' title='Bloquear elemento para evitar edici&oacute;n' alt='Bloquear elemento para evitar edici&oacuten'></a>";
		}
		
		$btnModificar="";
		if($modificaElementos&&!$elemBloqueado)
		{
			$accionM=base64_encode("modificar");
			$btnModificar="<a href='javascript:enviarFichaProyecto(".$idFormulario.",\"".$accionM."\")'><img src='../images/pencil.png' title ='Modificar' alt='Modificar'></a>";
		}
		
		$imgFicha="../images/001_06.gif";
		$tblRegistro="";
		$ocultarMenuDTD="";
		if($accion=="agregar")
		{
			$ocultarMenuDTD=' style="display:none"';
			$tblRegistro="	<table style='display:' id='tblRegistro'>
							<tr>
								<td><img src='../images/update_nw.gif' alt=''></td><td width='10'></td><td class='letraFicha' id='td_1'>".$nFormulario."</td>
							</tr>
						";
		}
		
		echo $tblRegistro;
	?>
		

		<table <?php echo $ocultarMenuDTD?> id="tblDTD">
		<tr>
		<td b ><img src='<?php echo $imgFicha ?>' alt=''></td><td width='10'></td><td class='letraFicha' id="td_1"><a href='<?php echo $enlace ?>'><?php echo $nFormulario?></a>&nbsp;<?php echo $btnModificar.$btnBloqueado.$btnBloqueoElem?></td>
		</tr>
		
	<?php
		
		echo uEJ(generarTableroModulosUsuario($idFormulario,$idRegistro,$idActor));
	?>
		</table>
		<br /><br />
	<?php
	}
	
	function eliminarArchivoAutor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idArchivo=base64_decode($_POST["idArchivo"]);
		$consulta="delete from 210_archivosProyectos where id_210_archivosProyectos=".$idArchivo;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function someterRevision()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$comentario=$_POST["comentario"];
		$idPerfil=-1;
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
			
		$idActorProcesoEtapa=base64_decode($_POST["actor"]);
		$idAccionesProcesoEtapaVSAcciones=$_POST["idAccionesProcesoEtapaVSAcciones"];
		
		$consulta="select idProceso,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$fila=$con->obtenerPrimeraFila($consulta);
		$idProceso=$fila[0];
		$nomTabla=$fila[1];
		
		$idFrmAutores=incluyeModulo($idProceso,3);
		if($idFrmAutores!="-1")
		{
			$consulta="select idUsuario from 246_autoresVSProyecto where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and responsable=1";
			$idResponsable=$con->obtenerValor($consulta);
			if($idResponsable=="")
			{
				$consulta= "select complementario from 203_elementosDTD where idFormulario=".$idFrmAutores;
				
				if($idPerfil!=-1)
					$consulta.=" and idPerfil=".$idPerfil;
				else
					$consulta.=" and idPerfil is null";
				
				$complementario=$con->obtenerValor($consulta);
				$arrDatos=explode(',',$complementario);
				$responsable="Responsable";
				$inv="Investigador";
				if(isset($arrDatos[3]))
					$inv=$arrDatos[3];
				if(isset($arrDatos[5]))
					$responsable=$arrDatos[5];
					
					
				$consulta="select nombreFormulario from 900_formularios where idFormulario=".$idFrmAutores;
				$nModulo=$con->obtenerValor($consulta);
				echo "El registro no cuenta con un ".$inv." ".$responsable." del seguimiento, para corregir el problema seleccione uno desde el m&oacute;dulo <b>".$nModulo."</b>";
				return;
			}
		}
		

		if($idActorProcesoEtapa>0)
		{
			if($con->existeCampo("objComplementario","947_actoresProcesosEtapasVSAcciones"))
				$consulta="select complementario,objComplementario,complementario2 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccionesProcesoEtapaVSAcciones;
			else
				$consulta="select complementario,'' as objComplementario,complementario2 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccionesProcesoEtapaVSAcciones;
		}
		/*else
		{
			if($con->existeCampo("objComplementario","997_accionesParticipanteVSProcesoVSEtapa"))
				$consulta="select complementario,objComplementario, from 997_accionesParticipanteVSProcesoVSEtapa where idProyectoParticipante=".($idActorProcesoEtapa*-1)." and idGrupoAccion=1";
			else
				$consulta="select complementario,'' as objComplementario from 997_accionesParticipanteVSProcesoVSEtapa where idProyectoParticipante=".($idActorProcesoEtapa*-1)." and idGrupoAccion=1";
		}*/


		$fAccion=$con->obtenerPrimeraFila($consulta);
		
		$numEtapa=$fAccion[0];
		$objComplementario=$fAccion[1];
		$objComplementario2=$fAccion[2];
		if($objComplementario!="")
		{
			$oComplementario=json_decode($objComplementario);
			
			if(isset($oComplementario->funcionValidacion))
			{
				$res="";
				eval('$res='.$oComplementario->funcionValidacion.'('.$idFormulario.','.$idRegistro.');');
				if($res!="")
				{
					if($res!="[]")
					{	
						echo $res;
						return;
					}
				}
			}
			
			
		}
		
		
		if($objComplementario2!="")
		{
			$oComplementario2=json_decode($objComplementario2);
			
			if(isset($oComplementario2->funcionValidacionSistema)&&($oComplementario2->funcionValidacionSistema!=-1))
			{
				
				
				$cacheCalculo=null;
				$cadObj='{"numEtapaCambio":"'.$numEtapa.'","idFormulario":"'.$idFormulario.'","idReferencia":"'.$idRegistro.
						'","actor":"'.$idActorProcesoEtapa.'","iFormulario":"'.$idFormulario.'","iRegistro":"'.$idRegistro.'"}';
				$obj=json_decode($cadObj);
				$resultado=resolverExpresionCalculoPHP($oComplementario2->funcionValidacionSistema,$obj,$cacheCalculo);
				
				if(sizeof($resultado)>0)
				{
					
					$arrErores="";
					
					foreach($resultado as $error)
					{
						$oError="['".cv($error["seccion"])."','".cv($error["mensajeError"])."']";
						if($arrErores=="")
							$arrErores=$oError;
						else
							$arrErores.=",".$oError;
					}
					echo "[".$arrErores."]";
					return;
				}
				
				
			}
		}
		


		if(cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa,$comentario,$idPerfil,"NULL","NULL",$idActorProcesoEtapa))
		{
					
			$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$idActorProcesoEtapa;
			$rol=$con->obtenerValor($consulta);
			if($rol=="")
			{
				$rol=0;
			}
			
			$consulta="SELECT idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$numEtapa=$con->obtenerValor($consulta);
			
			$nActor=obtenerActorProcesoIdRol($idProceso,$rol,$numEtapa);//obtenerNuevoActorProceso($idActorProcesoEtapa,$idFormulario,$idRegistro,$numEtapa,0,$idPerfil);
			$numEtapa=removerCerosDerecha($numEtapa);
			$objAperturaProcesoArranque="";
			
		//	varDump($_SESSION);
		//	varDump("aperturaProceso_".$idFormulario."_".$idRegistro."_".$numEtapa);
		//	return;
			if(isset($_SESSION["aperturaProceso_".$idFormulario."_".$idRegistro."_".$numEtapa]))
			{
				$objAperturaProcesoArranque=$_SESSION["aperturaProceso_".$idFormulario."_".$idRegistro."_".$numEtapa];
			}
			
			echo "1|".$nActor."|".$objAperturaProcesoArranque;
		}
		else
			echo "|";
	}
	
	function cambiarSituacionProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$situacion=$_POST["situacion"];
		$consulta="update 4001_procesos set situacion=".$situacion." where idProceso=".$idProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function asignarEtapaProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$consulta="update 4001_procesos set etapaRevision=".$numEtapa." where idProceso=".$idProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerRolesActoresProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select rol from 943_rolesActoresProceso rA,8001_roles r where idProceso=".$idProceso." and r.idRol=rA.rol order by r.nombreGrupo";
		$res=$con->obtenerFilas($consulta);
		$hijos='"leaf":true,';
		$arrObjRoles="";
		while($fila=$con->fetchRow($res))
		{
			$rol=$fila[0];
			
			$nomRol=obtenerTituloRol($rol);	
			$objRol='	{	
									  "text":"'.$nomRol.'",
									  "id":"'.$fila[0].'",
									  "iconCls":"cssNodoParticipanteImagen",
									  "icon":"../images/s.gif",
									  "cls":"cssNodoArbolNivel2",
									  "tipo":"1",
									  '.$hijos.'
									  "allowDrop":false,
									  "draggable" :false
	  
								  }';
				  
				  if($arrObjRoles=="")
					  $arrObjRoles=$objRol;
				  else
					  $arrObjRoles.=','.$objRol;
			
			
		}
		
		echo "[".uEJ($arrObjRoles)."]";
		
		
	}
	
	function agregarRolActorProceso()
	{
		global $con;
		$rol=$_POST["rol"];
		$idProceso=$_POST["idProceso"];
		$consulta="insert into 943_rolesActoresProceso (idProceso,rol) values(".$idProceso.",'".$rol."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarRolActorProceso()
	{
		global $con;
		$rol=$_POST["rol"];
		$idProceso=$_POST["idProceso"];
		$consulta="delete from 943_rolesActoresProceso where idProceso=".$idProceso." and rol='".$rol."'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerActoresProcesoDisponible()
	{
		global $con;
		$numEtapa=$_POST["numEtapa"];
		$idProceso=$_POST["idProceso"];
		$consulta="select rol from 943_rolesActoresProceso where idProceso=".$idProceso." and rol not in(select actor from 944_actoresProcesoEtapa where tipoActor=1 and numEtapa='".$numEtapa."' and idProceso=".$idProceso." and idPerfil is null)";
		$res=$con->obtenerFilas($consulta);
		$arrActores="";
		while($fila=$con->fetchRow($res))
		{
			$rol=$fila[0];
			$nomRol=obtenerTituloRol($rol);
			$obj="['".$rol."','".$nomRol."','1']";
			if($arrActores=="")
				$arrActores	=$obj;
			else
				$arrActores.=",".$obj;
		}
		$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		if($tipoProceso=="9")
		{
			$consulta="	select pc.idProyectoVSComite,c.nombreComite from 235_proyectosVSComites pc,2006_comites c where 
					c.idComite=pc.idComite and idProyecto=".$idProceso;
		}
		else
		{
			$consulta="	select p.idProyectoVSComiteVSEtapa,c.nombreComite from 234_proyectosVSComitesVSEtapas p,2006_comites c where 
						c.idComite=p.idComite and idProyecto=".$idProceso." and numEtapa=".$numEtapa."
						and p.idProyectoVSComiteVSEtapa not in(select actor from 944_actoresProcesoEtapa where tipoActor=2 and numEtapa=".$numEtapa."
						and idProceso=".$idProceso.")";
		}

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
				
				$obj="['".$fila[0]."','".$fila[1]."','2']";
				if($arrActores=="")
					$arrActores	=$obj;
				else
					$arrActores.=",".$obj;
			
		}
		echo "1|[".uEJ($arrActores)."]";
	}
	
	function guardarActoresProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$cadActores=$_POST["cadActores"];
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$x=0;
		$arrActores=explode(",",$cadActores);
		$nActores=sizeof($arrActores);
		$consulta[$x]="begin";
		$x++;
		for($ct=0;$ct<$nActores;$ct++)
		{
			$arrAct=explode("|",$arrActores[$ct]);
			
			$query="select count(*) from 944_actoresProcesoEtapa where actor='".$arrAct[0]."' and tipoActor=".$arrAct[1]." and numEtapa=".$numEtapa." and idProceso=".$idProceso." and idPerfil=".$idPerfil;
			$nReg=$con->obtenerValor($query);
			if($nReg==0)
			{
				$consulta[$x]="insert into 944_actoresProcesoEtapa(actor,tipoActor,numEtapa,idProceso,idPerfil) values('".$arrAct[0]."',".$arrAct[1].",".$numEtapa.",".$idProceso.",".$idPerfil.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerAccionesActorDisponibles()
	{
		global $con;
		$idActor=$_POST["actor"];
		$idProceso=$_POST["idProceso"];
		
		
		$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso= $con->obtenerValor($consulta);
		$consulta="select aa.idGrupoAccion,aa.accion from 945_accionesActor aa 
					where aa.tipoAccion in (2,3)  and aa.idIdioma=".$_SESSION["leng"]." and 
					 aa.idGrupoAccion not in 
					(select idGrupoAccion from 947_actoresProcesosEtapasVSAcciones where idActorProcesoEtapa=".$idActor." and idGrupoAccion not in (1,5))
					order by accion";
		$arrAcciones=$con->obtenerFilasArreglo($consulta);	
		
		echo "1|".uEJ($arrAcciones);
		
	}
	
	function guardarAccionesActor()
	{
		global $con;
		$cadAcciones=$_POST["cadAcciones"];
		$actor=$_POST["actor"];
		$arrAcciones=explode(",",$cadAcciones);
		$nAcciones=sizeof($arrAcciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($ct=0;$ct<$nAcciones;$ct++)
		{
			$query="insert into 947_actoresProcesosEtapasVSAcciones(idGrupoAccion,idActorProcesoEtapa) values(".$arrAcciones[$ct].",".$actor.")";
			if($con->ejecutarConsulta($query))
			{
				$idRegistroDictamen=$con->obtenerUltimoID();
				if($arrAcciones[$ct]=="5")
				{
					if(!crearFormularioDictamenFinal($actor,$idRegistroDictamen))
					{
						echo "|";
						return;
					}
				}
				if($arrAcciones[$ct]=="4")
				{
					if(!crearFormularioDictamenParcial($actor))
					{
						echo "|";
						return;
					}
				}
				if($arrAcciones[$ct]=="3")
				{
					if(!crearFormularioDictamenRevisor($actor))
					{
						echo "|";
						return;
					}
				}
			}
			else
				echo "|";
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function crearFormularioDictamenFinal($actorEtapa,$idRegistroDictamen)
	{
		global $con;
		global $tipoServidor;
		$query="select * from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$actorEtapa;
		$fila=$con->obtenerPrimeraFila($query);
		$idProceso=$fila[4];
		$actor=$fila[1];
		$tipo=$fila[2];
		$numEtapa=$fila[3];
		
		if($tipo=="1")
		{
			$rol=$actor;
			
			$nActor=obtenerTituloRol($rol);
		}
		else
		{
			$consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c	where c.idComite=e.idComite and e.idProyectoVSComiteVSEtapa=".$actor;
			$nActor=($con->obtenerValor($consulta));
		}
		
		$consulta="select nombreEtapa from 4037_etapas where numEtapa=".$numEtapa." and idProceso=".$idProceso;
		if($tipoServidor==1)
		{
			$nEtapa=utf8_decode($con->obtenerValor($consulta));
			$nActor=utf8_decode($nActor);
		}
		else
			$nEtapa=uEJ($con->obtenerValor($consulta));
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFrmEntidad=$con->obtenerValor($consulta);
		if($idFrmEntidad=="")
			$idFrmEntidad="-1";
		$objFormulario='
						{
							"nombreFormulario":"Formato de dictamen final (Actor: '.uEJ($nActor).', Etapa: '.$nEtapa.')",
							"descripcion":"",
							"titulo":"Formato de dictamen final",
							"idProceso":"'.$idProceso.'",
							"idEtapa":"1",
							"idFrmEntidad":"'.$idFrmEntidad.'",
							"frmRepetible":"0",
							"formularioBase":"0",
							"estadoInicial":"1",
							"eliminable":"0",
							"tipoFormulario":"14",
							"mostrarTableroControl":"0",
							"arrControles":[
												{
													"pregunta":	[
																 	{
																		"etiqueta":"Dict�men:",
																		"idIdioma":"1"
																	}
																],
													"obligatorio":"0",
													"tipoElemento":"1",
													"posX":"20",
													"posY":"53",
													"eliminable":"0"
													
													
												},
												
												{
													"obligatorio":"1",
													"tipoElemento":"2",
													"posX":"119",
													"posY":"51",
													"opciones":[],
													"nomCampo":"dictamenFinal",
													"eliminable":"0",
													"pregunta":""
													
												}
											],
							"confListadoFormulario":{
														"campoOrden":"dictamenFinal",
														"orden":"ASC",
														"regPag":"25",
														"campos":	[
																	 	{
																			"campo":"dictamenFinal",
																			"anchoCol":"150",
																			"titulo":	[
																						 	{
																								"idIdioma":"1",
																								"etiqueta":"Dict�men final:"
																							}
																						 ],
																			"accion":"0",
																			"idAlineacion":"3"
																		}
																  	]
													}
						}
	
					';
		$idFormulario=crearFormulario($objFormulario);	
		if($idFormulario!="-1")
		{	
			$consulta="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='dictamenFinal'";
			$idElementoDictamen=$con->obtenerValor($consulta);
			$consulta="insert into 948_actoresVSFormulariosDictamen(idActor,idFormulario,idElementoDictamen) values(".$actorEtapa.",".$idFormulario.",".$idElementoDictamen.")";
			if($con->ejecutarConsulta($consulta))
			{
				$idActorVSFormularioDictamen=$con->obtenerUltimoID();
				$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario='".$idActorVSFormularioDictamen."' where idAccionesProcesoEtapaVSAcciones=".$idRegistroDictamen;
				
				$accion=$con->ejecutarConsulta($consulta);
				
				return	$accion;			
			}
		}
		else
			return false;
	}
	
	function crearFormularioDictamenParcial($actorEtapa)
	{
		global $con;
		$query="select * from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$actorEtapa;
		$fila=$con->obtenerPrimeraFila($query);
		$idProceso=$fila[4];
		$actor=$fila[1];
		$tipo=$fila[2];
		$numEtapa=$fila[3];
		global $tipoServidor;
		if($tipo=="1")
		{
			$rol=$actor;
			$arrRol=explode("_",$rol);
			$nomRol="";
			$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
			$rol1=$con->obtenerValor($consulta);
			if($rol1!="")
			{
				$rol2="";
				if($arrRol[1]!="0")
				{
					$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
					$rol2=" (".$con->obtenerValor($consulta).")";
				}
				
				$nomRol=$rol1.$rol2;
			}
			$nActor=$nomRol;
		}
		else
		{
			$consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c	where c.idComite=e.idComite and e.idProyectoVSComiteVSEtapa=".$actor;
			$nActor=($con->obtenerValor($consulta));
		}
		
		$consulta="select nombreEtapa from 4037_etapas where numEtapa=".$numEtapa." and idProceso=".$idProceso;
		if($tipoServidor==1)
		{
			$nEtapa=utf8_decode($con->obtenerValor($consulta));
			$nActor=utf8_decode($nActor);
		}
		else
			$nEtapa=uEJ($con->obtenerValor($consulta));
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFrmEntidad=$con->obtenerValor($consulta);
		
		$objFormulario='
						{
							"nombreFormulario":"Formato de dict�men Parcial (Actor: '.uEJ($nActor).', Etapa: '.$nEtapa.')",
							"descripcion":"",
							"titulo":"Formato de dict�men Parcial",
							"idProceso":"'.$idProceso.'",
							"idEtapa":"1",
							"idFrmEntidad":"'.$idFrmEntidad.'",
							"frmRepetible":"0",
							"formularioBase":"0",
							"estadoInicial":"1",
							"eliminable":"0",
							"tipoFormulario":"13",
							"mostrarTableroControl":"0",
							"arrControles":[
												{
													"pregunta":	[
																 	{
																		"etiqueta":"Dict�men:",
																		"idIdioma":"1"
																	}
																],
													"obligatorio":"0",
													"tipoElemento":"1",
													"posX":"20",
													"posY":"53",
													"eliminable":"0"
													
													
												},
												
												{
													"obligatorio":"1",
													"tipoElemento":"2",
													"posX":"119",
													"posY":"51",
													"opciones":[],
													"nomCampo":"dictamenParcial",
													"eliminable":"0",
													"pregunta":""
													
												}
											],
							"confListadoFormulario":{
														"campoOrden":"dictamenParcial",
														"orden":"ASC",
														"regPag":"25",
														"campos":	[
																	 	{
																			"campo":"dictamenParcial",
																			"anchoCol":"150",
																			"titulo":	[
																						 	{
																								"idIdioma":"1",
																								"etiqueta":"Dict�men parcial:"
																							}
																						 ],
																			"accion":"0",
																			"idAlineacion":"3"
																		}
																  	]
													}
						}
	
					';
		
		$idFormulario=crearFormulario($objFormulario);	
		if($idFormulario!="-1")
		{	
			$consulta="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='dictamenParcial'";
			$idElementoDictamen=$con->obtenerValor($consulta);
			$consulta="insert into 948_actoresVSFormulariosDictamen(idActor,idFormulario,idElementoDictamen) values(".$actorEtapa.",".$idFormulario.",".$idElementoDictamen.")";
			
			if($con->ejecutarConsulta($consulta))
			{
				
				$idActorVSFormularioDictamen=$con->obtenerUltimoID();
				$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario='".$idActorVSFormularioDictamen."' where idGrupoAccion=4 and idActorProcesoEtapa=".$actorEtapa;
				
				$accion=$con->ejecutarConsulta($consulta);
				
				return	$accion;			
			}
		}
		else
			return false;
	}
	
	function crearFormularioDictamenRevisor($actorEtapa)
	{
		global $con;
		global $tipoServidor;
		$query="select * from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$actorEtapa;
		$fila=$con->obtenerPrimeraFila($query);
		$idProceso=$fila[4];
		$actor=$fila[1];
		$tipo=$fila[2];
		$numEtapa=$fila[3];
		
		if($tipo=="1")
		{
			$rol=$actor;
			$arrRol=explode("_",$rol);
			$nomRol="";
			$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
			$rol1=$con->obtenerValor($consulta);
			if($rol1!="")
			{
				$rol2="";
				if($arrRol[1]!="0")
				{
					$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
					$rol2=" (".$con->obtenerValor($consulta).")";
				}
				
				$nomRol=$rol1.$rol2;
			}
			$nActor=$nomRol;
		}
		else
		{
			$consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c	where c.idComite=e.idComite and e.idProyectoVSComiteVSEtapa=".$actor;
			$nActor=($con->obtenerValor($consulta));
		}
		
		$consulta="select nombreEtapa from 4037_etapas where numEtapa=".$numEtapa." and idProceso=".$idProceso;
		if($tipoServidor==1)
		{
			$nEtapa=utf8_decode($con->obtenerValor($consulta));
			$nActor=utf8_decode($nActor);
		}
		else
			$nEtapa=uEJ($con->obtenerValor($consulta));
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFrmEntidad=$con->obtenerValor($consulta);
		
		$objFormulario='
						{
							"nombreFormulario":"Formato de dict�men Revisores (Actor: '.uEJ($nActor).', Etapa: '.$nEtapa.')",
							"descripcion":"",
							"titulo":"Formato de dict�men (Revisores)",
							"idProceso":"'.$idProceso.'",
							"idEtapa":"1",
							"idFrmEntidad":"'.$idFrmEntidad.'",
							"frmRepetible":"0",
							"formularioBase":"0",
							"estadoInicial":"1",
							"eliminable":"0",
							"tipoFormulario":"15",
							"mostrarTableroControl":"0",
							"arrControles":[
												{
													"pregunta":	[
																 	{
																		"etiqueta":"Dict�men:",
																		"idIdioma":"1"
																	}
																],
													"obligatorio":"0",
													"tipoElemento":"1",
													"posX":"20",
													"posY":"53",
													"eliminable":"0"
													
													
												},
												
												{
													"obligatorio":"1",
													"tipoElemento":"2",
													"posX":"119",
													"posY":"51",
													"opciones":[],
													"nomCampo":"dictamenRevisor",
													"eliminable":"0",
													"pregunta":""
													
												}
											],
							"confListadoFormulario":{
														"campoOrden":"dictamenRevisor",
														"orden":"ASC",
														"regPag":"25",
														"campos":	[
																	 	{
																			"campo":"dictamenRevisor",
																			"anchoCol":"150",
																			"titulo":	[
																						 	{
																								"idIdioma":"1",
																								"etiqueta":"Dict�men:"
																							}
																						 ],
																			"accion":"0",
																			"idAlineacion":"3"
																		}
																  	]
													}
						}
	
					';
		
		$idFormulario=crearFormulario($objFormulario);	
		if($idFormulario!="-1")
		{	
			$consulta="select idGrupoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and nombreCampo='dictamenRevisor'";
			$idElementoDictamen=$con->obtenerValor($consulta);
			$consulta="insert into 948_actoresVSFormulariosDictamen(idActor,idFormulario,idElementoDictamen) values(".$actorEtapa.",".$idFormulario.",".$idElementoDictamen.")";
			
			if($con->ejecutarConsulta($consulta))
			{
				
				$idActorVSFormularioDictamen=$con->obtenerUltimoID();
				$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario='".$idActorVSFormularioDictamen."' where idGrupoAccion=3 and idActorProcesoEtapa=".$actorEtapa;
				
				$accion=$con->ejecutarConsulta($consulta);
				
				return	$accion;			
			}
		}
		else
			return false;
	}
	
	function removerActorEtapa()
	{
		global $con;
		$idActorProcesoEtapa=$_POST["idActorProcesoEtapa"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$idActorProcesoEtapa;
		$x++;
		$consulta[$x]="delete from 947_actoresProcesosEtapasVSAcciones where idActorProcesoEtapa=".$idActorProcesoEtapa;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerAccionEtapa()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$query="select * from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$fila=$con->obtenerPrimeraFila($query);
		switch($fila[1])
		{
			case "5":
				$idActorProcesoEtapa=$fila[2];
				
				
				$query="select ad.idFormulario,ad.idActorVSFormularioDictamen from 948_actoresVSFormulariosDictamen ad,
						947_actoresProcesosEtapasVSAcciones pa,
						900_formularios f where f.idFormulario=ad.idFormulario and  ad.idActor=pa.idActorProcesoEtapa and f.tipoFormulario=14 
						and idAccionesProcesoEtapaVSAcciones=".$idAccion." AND ad.idActorVSFormularioDictamen=pa.complementario";
				
				$fila948=$con->obtenerPrimeraFila($query);
				$idFormulario=$fila948[0];
				$idActorVSFormularioDictamen=$fila948[1];
				if(!eliminarFormulario($idFormulario))
				{
					echo "|";
					return;
				}
				else
				{
					
					$query="delete from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$idActorVSFormularioDictamen;
					
					if(!$con->ejecutarConsulta($query))
					{
						echo "|";
						return;
					}	
				}
			break;
			case "4":
				$idActorProcesoEtapa=$fila[2];
				$query="select a.idFormulario,a.idActorVSFormularioDictamen from 948_actoresVSFormulariosDictamen a,900_formularios f where f.idFormulario=a.idFormulario and f.tipoFormulario=13 and a.idActor=".$idActorProcesoEtapa;
				
				$fila948=$con->obtenerPrimeraFila($query);
				$idFormulario=$fila948[0];
				$idActorVSFormularioDictamen=$fila948[1];
				if(!eliminarFormulario($idFormulario))
				{
					echo "|";
					return;
				}
				else
				{
					
					$query="delete from 948_actoresVSFormulariosDictamen where idActor=".$idActorVSFormularioDictamen;
					if(!$con->ejecutarConsulta($query))
					{
						echo "|";
						return;
					}	
				}
				
			break;
			case "3":
				$idActorProcesoEtapa=$fila[2];
				$query="select a.idFormulario,a.idActorVSFormularioDictamen from 948_actoresVSFormulariosDictamen a,900_formularios f where f.idFormulario=a.idFormulario and f.tipoFormulario=15 and a.idActor=".$idActorProcesoEtapa;
				
				$fila948=$con->obtenerPrimeraFila($query);
				$idFormulario=$fila948[0];
				$idActorVSFormularioDictamen=$fila948[1];
				if(!eliminarFormulario($idFormulario))
				{
					echo "|";
					return;
				}
				else
				{
					
					$query="delete from 948_actoresVSFormulariosDictamen where idActor=".$idActorVSFormularioDictamen;
					if(!$con->ejecutarConsulta($query))
					{
						echo "|";
						return;
					}	
				}
			break;
		}
		$x=0;
		$consulta[$x]="delete from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerEtapasSometimientoDisponibles()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso."  order by numEtapa";//and numEtapa<>".$numEtapa."
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		while($fila=$con->fetchRow($res))
		{
			if($arrObj=="")
				$arrObj="['".$fila[0]."','".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
			else
				$arrObj.=",['".$fila[0]."','".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		}
		
		echo "1|".uEJ("[".$arrObj."]");
	}
	
	function guardarEtapaSometimiento()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$numEtapa=$_POST["numEtapa"];
		$obj=$_POST["objComp"];
		$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario=".$numEtapa.",complementario2='".cv($obj)."' where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarFormulario($idFormulario)
	{
		global $con;
		$query="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$nTabla=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 900_formularios where idFormulario=".$idFormulario;
		$x++;
		$consulta[$x]="delete from 245_proyectosComitesElementosDTD where idElemento in(select idElementoDTD from 203_elementosDTD where idFormulario=".$idFormulario.")";
		$x++;
		$consulta[$x]="delete from 203_elementosDTD where idFormulario=".$idFormulario;
		$x++;
		$consulta[$x]="delete from 948_actoresVSFormulariosDictamen where idFormulario=".$idFormulario;
		$x++;
		if($con->existeTabla($nTabla))
		{
			$consulta[$x]="drop table ".$nTabla;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		return $con->ejecutarBloque($consulta);
	}
	
	function guardarOpcionesDictamenFinal()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$objOpciones=$_POST["objOpciones"];
		$oOpciones=json_decode($objOpciones);
		$opciones=$oOpciones->opciones;
		$objConfDictamen=$_POST["objConfDictamen"];

		$query="select idElementoDictamen,ad.idFormulario,complementario2 from 948_actoresVSFormulariosDictamen ad,947_actoresProcesosEtapasVSAcciones pa,
				900_formularios f where f.idFormulario=ad.idFormulario and  ad.idActor=pa.idActorProcesoEtapa and f.tipoFormulario=14 
				and idAccionesProcesoEtapaVSAcciones=".$idAccion." AND ad.idActorVSFormularioDictamen=pa.complementario";

		$filaA=$con->obtenerPrimeraFila($query);
		$cadObj=$filaA[2];
		
		$idElementoDictamen=$filaA[0];
		$idFormulario=$filaA[1];
		$nOpciones=sizeof($opciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="delete from 902_opcionesFormulario where idGrupoElemento=".$idElementoDictamen;
		$x++;
		$consulta[$x]="delete from 911_disparadores where idGrupoElemento=".$idElementoDictamen;
		$x++;
		
		for($ct=0;$ct<$nOpciones;$ct++)
		{
			$opcion=$opciones[$ct];
			$vOpcion=$opcion->vOpcion;
			$pasaEtapa=$opcion->etapa;
			$columnas=$opcion->columnas;
			$nColumnas=sizeof($columnas);
			for($ct2=0;$ct2<$nColumnas;$ct2++)
			{
				$columna=$columnas[$ct2];
				$idIdioma=$columna->idLeng;
				$texto=$columna->texto;
				$consulta[$x]="insert into 902_opcionesFormulario(contenido,valor,idIdioma,idGrupoElemento) values('".cv($texto)."','".cv($vOpcion)."',".$idIdioma.",".$idElementoDictamen.")";

				$x++;
				
				$consulta[$x]="insert into 911_disparadores(idGrupoElemento,idFormulario,idEtapa,idValor,icono) values(".
				$idElementoDictamen.",'".$idFormulario."',".$pasaEtapa.",'".cv($vOpcion)."','".$opcion->icono."')";
				$x++;
				
			}
		}
		
		
		
		
		$consulta[$x]="UPDATE 947_actoresProcesosEtapasVSAcciones SET complementario3='".cv($objConfDictamen)."' WHERE idAccionesProcesoEtapaVSAcciones=".$idAccion;
		
		$x++;
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarOpcionesDictamenParcial()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$objOpciones=$_POST["objOpciones"];
		$objOp=json_decode($objOpciones);
		$opciones=$objOp->opciones;
		
		$query="SELECT complementario2 FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$objOp->idActor." AND idGrupoAccion=4";
		$cadObj=$con->obtenerValor($query);
		
		$query="select idElementoDictamen,ad.idFormulario from 948_actoresVSFormulariosDictamen ad,947_actoresProcesosEtapasVSAcciones pa,900_formularios f where f.idFormulario=ad.idFormulario and  ad.idActor=pa.idActorProcesoEtapa and f.tipoFormulario=13 and idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$filaA=$con->obtenerPrimeraFila($query);
		$idElementoDictamen=$filaA[0];
		$idFormulario=$filaA[1];
		$nOpciones=sizeof($opciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="delete from 902_opcionesFormulario where idGrupoElemento=".$idElementoDictamen;
		$x++;
		$consulta[$x]="delete from 954_accionesDictamenParcial where idGrupoElemento=".$idElementoDictamen;
		$x++;
		
		for($ct=0;$ct<$nOpciones;$ct++)
		{
			$opcion=$opciones[$ct];
			$vOpcion=$opcion->vOpcion;
			$accion=$opcion->accion;
			$columnas=$opcion->columnas;
			$resRespuesta=$opcion->reqRespuesta;
			$nColumnas=sizeof($columnas);
			for($ct2=0;$ct2<$nColumnas;$ct2++)
			{
				$columna=$columnas[$ct2];
				$idIdioma=$columna->idLeng;
				$texto=$columna->texto;
				
				$consulta[$x]="insert into 902_opcionesFormulario(contenido,valor,idIdioma,idGrupoElemento,requiereRespuesta) values('".cv($texto)."','".cv($vOpcion)."',".$idIdioma.",".$idElementoDictamen.",".$resRespuesta.")";
				$x++;
				
				$consulta[$x]="insert into 954_accionesDictamenParcial(idGrupoElemento,idFormulario,idAccion,idValor) values(".$idElementoDictamen.",'".$idFormulario."',".$accion.",'".cv($vOpcion)."')";
				$x++;
				
			}
		}
		
		if($cadObj!='')
		{
			$cadObj=setAtributoCadJson($cadObj,"etiqueta",$objOp->etiqueta);
		}
		else
		{
			$cadObj='{"etiqueta":"'.$objOp->etiqueta.'"}';
		}
		$consulta[$x]="UPDATE 947_actoresProcesosEtapasVSAcciones SET complementario3='".$cadObj."' WHERE idActorProcesoEtapa=".$objOp->idActor." AND idGrupoAccion=4";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
			
			
		
	}
	
	function guardarOpcionesDictamenRevisor()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$objOpciones=$_POST["objOpciones"];
		$objOp=json_decode($objOpciones);
		$opciones=$objOp->opciones;
		$query="select idElementoDictamen,ad.idFormulario from 948_actoresVSFormulariosDictamen ad,947_actoresProcesosEtapasVSAcciones pa,900_formularios f where f.idFormulario=ad.idFormulario and  ad.idActor=pa.idActorProcesoEtapa and f.tipoFormulario=15 and idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$filaA=$con->obtenerPrimeraFila($query);
		$idElementoDictamen=$filaA[0];
		$idFormulario=$filaA[1];
		$nOpciones=sizeof($opciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="delete from 902_opcionesFormulario where idGrupoElemento=".$idElementoDictamen;
		$x++;
		
		
		for($ct=0;$ct<$nOpciones;$ct++)
		{
			$opcion=$opciones[$ct];
			$vOpcion=$opcion->vOpcion;
			
			$columnas=$opcion->columnas;
			$nColumnas=sizeof($columnas);
			for($ct2=0;$ct2<$nColumnas;$ct2++)
			{
				$columna=$columnas[$ct2];
				$idIdioma=$columna->idLeng;
				$texto=$columna->texto;
				$consulta[$x]="insert into 902_opcionesFormulario(contenido,valor,idIdioma,idGrupoElemento) values('".cv($texto)."','".cv($vOpcion)."',".$idIdioma.",".$idElementoDictamen.")";
				
				$x++;
				
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
			
			
		
	}
	
	function obtenerOpcionesDictamenRegistradas()
	{
		global $con;
		$accionFinalizar=1;

		$idAccion=$_POST["idAccion"];
		$lblEtiqueta="";
		$mostrarFormularioAsociado=1;
		$consulta="SELECT accion FROM 945_accionesActor WHERE idGrupoAccion=5";
		$lblEtiqueta=$con->obtenerValor($consulta);
		$consulta="SELECT complementario3 FROM 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$filaPA=$con->obtenerPrimeraFila($consulta);		
		$objDictamen=$filaPA[0];
		if($objDictamen!='')
		{
			$oDictamen=json_decode($objDictamen);
			if(isset($oDictamen->funcionVisualizacion))
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$oDictamen->funcionVisualizacion;
				$lblFuncionVisualizacion=$con->obtenerValor($consulta);
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$oDictamen->funcionValidacion;
				$lblFuncionValidacion=$con->obtenerValor($consulta);
				
				$objDictamen=setAtributoCadJson($objDictamen,"lblFuncionVisualizacion",$lblFuncionVisualizacion);
				$objDictamen=setAtributoCadJson($objDictamen,"lblFuncionValidacion",$lblFuncionValidacion);
				
				
			}
		}
		else
		{
			$objDictamen='{"etiqueta":"'.cv($lblEtiqueta).'"}';
		}
		
		$idElemento=$_POST["idElemento"];
		$consulta="select valor,Contenido,d.idEtapa,`of`.idIdioma,d.icono from 902_opcionesFormulario `of`,911_disparadores d
					where d.idValor=`of`.valor and d.idGrupoElemento=`of`.idGrupoElemento and `of`.idGrupoElemento=".$idElemento." 
					order by valor,idIdioma";
		$resOpciones=$con->obtenerFilas($consulta);
		$valorAnt="";
		$obj="";
		$arrObj="";
		while($fila=$con->fetchRow($resOpciones))
		{
			$contenido=$fila[1];
			
			if($valorAnt!=$fila[0])
			{
				
				if($valorAnt!="")
				{
					if($arrObj=="")
						$arrObj=$obj.$etapaCierre;
					else
						$arrObj.=",".$obj.$etapaCierre;
				}
				$obj="['".$fila[0]."','".$fila[4]."','".cv($contenido)."'";
								
				$etapaCierre=",'".$fila[2]."']";
				$valorAnt=$fila[0];
			}
			else
			{
				$obj.=",'".$contenido."'";
			}
		}
		
		if($obj!="")
			if($arrObj=="")
				$arrObj=$obj.$etapaCierre;
			else
				$arrObj.=",".$obj.$etapaCierre;
		echo "1|[".uEJ($arrObj)."]|".$objDictamen;
		
	}
	
	function obtenerActoresProcesoDisponibleInicio()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$todosActores=-1;
		if(isset($_POST["todosActores"]))
			$todosActores=$_POST["todosActores"];
		$arrActores="";
		if($todosActores==-1)
		{
			$consulta="select rol from 943_rolesActoresProceso where idProceso=".$idProceso." and rol not in 
						(select actor from 950_actorVSProcesoInicio where idProceso=".$idProceso." and idPerfil is null)";
			$res=$con->obtenerFilas($consulta);
			
			$nomRol="";
			while($fila=$con->fetchRow($res))
			{
				$rol=$fila[0];
				$arrRol=explode("_",$rol);
				$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
				$rol1=$con->obtenerValor($consulta);
				if($rol1!="")
				{
					$rol2="";
					if($arrRol[1]!="0")
					{
						$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
						$rol2=" (".$con->obtenerValor($consulta).")";
					}
					
					$nomRol=$rol1.$rol2;
					
					$obj="['".$rol."','".$nomRol."','1']";
					if($arrActores=="")
						$arrActores	=$obj;
					else
						$arrActores.=",".$obj;
				}
			}	
		}
		else
		{
			$consulta="(SELECT distinct c.idComite as id,c.nombreComite as nombre,'2' as tipo FROM 234_proyectosVSComitesVSEtapas p, 2006_comites c WHERE c.idComite=p.idComite AND idProyecto=".$idProceso.") union
						(SELECT rol as id,rol as nombre,'1' AS tipo FROM 943_rolesActoresProceso WHERE idProceso=".$idProceso.")";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$rol=$fila[0];
				$nomRol=$fila[1];
				$tipo=$fila[2];
				if($fila[2]==1)
				{
					$nomRol=obtenerTituloRol($nomRol);
				}
				$obj="['".$rol."','".$nomRol."','".$tipo."']";
				if($arrActores=="")
						$arrActores	=$obj;
					else
						$arrActores.=",".$obj;
			}
			
		}
		echo "1|".uEJ("[".$arrActores."]");
	}
	
	function guardarActoresProcesoInicio()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadActores=$_POST["cadActores"];
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$arrActores=explode(",",$cadActores);
		$nActores=sizeof($arrActores);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($ct=0;$ct<$nActores;$ct++)
		{
			
			$query="select count(*) from 950_actorVSProcesoInicio where actor='".$arrActores[$ct]."' and idProceso=".$idProceso." and idPerfil=".$idPerfil;
			$nReg=$con->obtenerValor($query);
			if($nReg==0)
			{
			
				$consulta[$x]="insert into 950_actorVSProcesoInicio(actor,idProceso,idPerfil) values('".$arrActores[$ct]."',".$idProceso.",".$idPerfil.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerActoresProcesoInicio()
	{
		global $con;
		$idActor=$_POST["idActor"];
		
		$consulta="select * from 950_actorVSProcesoInicio where idActorProcesoInicio=".$idActor;
		
		$filaProceso=$con->obtenerPrimeraFila($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 949_actoresVSAccionesProceso where actor='".$filaProceso[1]."' and idProceso=".$filaProceso[2];
		
		$x++;
		
		$query[$x]="delete from 950_actorVSProcesoInicio where idActorProcesoInicio=".$idActor;
		$x++;
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerAccionesInicioActorDisponibles()
	{
		global $con;
		$idActor=$_POST["actor"];
		$idProceso=$_POST["idProceso"];
		$idPerfil=-1;
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		
		
		$consulta="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
		$tipoProceso= $con->obtenerValor($consulta);
		
		$consulta="select aa.idGrupoAccion,aa.accion from 945_accionesActor aa 
					where aa.tipoAccion in (1,3) and aa.idIdioma=".$_SESSION["leng"]." and aa.idGrupoAccion not in 
					(select idAccion from 949_actoresVSAccionesProceso where idProceso=".$idProceso." and actor='".$idActor."'";
		if($idPerfil==-1)			
			$consulta.=" and idPerfil is null";			
		else
			$consulta.=" and idPerfil=".$idPerfil;			
		$consulta.=	") order by accion";

		$arrAcciones=$con->obtenerFilasArreglo($consulta);	
		
		echo "1|".uEJ($arrAcciones);
	}
	
	function guardarAccionesInicioActor()
	{
		global $con;
		$actor=$_POST["actor"];
		$cadAcciones=$_POST["cadAcciones"];
		$arrAcciones=explode(",",$cadAcciones);
		$idProceso=$_POST["idProceso"];
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$nAcciones=sizeof($arrAcciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($ct=0;$ct<$nAcciones;$ct++)
		{
			$complementario="";
			switch($arrAcciones[$ct])
			{
				case 9:	
					$complementario="2";
				break;	
				case 15:
					$complementario="0_0_";
				break;
			}
			$consulta[$x]="insert into 949_actoresVSAccionesProceso(actor,idAccion,idProceso,complementario,idPerfil) values('".$actor."',".$arrAcciones[$ct].",".$idProceso.",'".$complementario."',".$idPerfil.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerAccionInicio()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$consulta="delete from 949_actoresVSAccionesProceso where idActorVSAccionesProceso=".$idAccion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
		
	}
	
	function modificarVerRegistro()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$verRegistro=$_POST["verRegistro"];
		$tAccion=$_POST["tAccion"];
		if($tAccion=="1")
			$consulta="update 949_actoresVSAccionesProceso set complementario=".$verRegistro." where idActorVSAccionesProceso=".$idAccion;
		else
			$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario=".$verRegistro." where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		if($con->ejecutarConsulta($consulta))		
			echo "1|";
		else
			echo "|";
	}
	
	function removerCondicionesDictamen()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario2='' where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerActoresDictamenDisponible()
	{
		global $con;
		$numEtapa=$_POST["numEtapa"];
		$idProceso=$_POST["idProceso"];
		$idActor=$_POST["idActor"];
		
		$consulta="select complementario2 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idActor;
		$comp=$con->obtenerValor($consulta);		
		if($comp=="")
			$comp="-1";
		$consulta="select pe.actor,pe.tipoActor,ac.idAccionesProcesoEtapaVSAcciones from 944_actoresProcesoEtapa pe,947_actoresProcesosEtapasVSAcciones ac 
					where ac.idActorProcesoEtapa=pe.idActorProcesoEtapa and pe.numEtapa=".$numEtapa." and pe.idProceso=".$idProceso." and 
					ac.idAccionesProcesoEtapaVSAcciones<>".$idActor." and ac.idGrupoAccion in(4,5) and ac.idAccionesProcesoEtapaVSAcciones not in (".$comp.")";	

		$res=$con->obtenerFilas($consulta);
		$arrActores="";
		while($filaAc=$con->fetchRow($res))
		{
			$actor=$filaAc[0];
			switch($filaAc[1])
			{
				case "1":
					$arrRol=explode("_",$actor);
					$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
					$rol1=$con->obtenerValor($consulta);
					if($rol1!="")
					{
						$rol2="";
						if($arrRol[1]!="0")
						{
							$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
							$rol2=" (".$con->obtenerValor($consulta).")";
						}
						
						$actor=$rol1.$rol2;
					}
					else
						continue 2;
					
					
				break;
				case "2":
					$consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c where c.idComite=e.idComite 
								and  e.idProyectoVSComiteVSEtapa=".$actor;	
					$actor=$con->obtenerValor($consulta);
				
				break;
			}
		
			$obj="['".$filaAc[2]."','".$actor."','".$filaAc[1]."']";
			if($arrActores=="")
				$arrActores=$obj;
			else
				$arrActores.=",".$obj;
				
		}
		echo "1|[".uEJ($arrActores)."]";
		
	}
	
	function guardarActoresDictamen()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$actores=$_POST["actores"];
		$consulta="select complementario2 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		$comple=$con->obtenerValor($consulta);
		
		if($comple=='')
			$comple=$actores;
		else
			$comple.=','.$actores;
		
		$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario2='".$comple."' where idAccionesProcesoEtapaVSAcciones=".$idAccion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerActorDictamen()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$idAccionR=$_POST["idAccionR"];
		$consulta="select complementario2 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccionR;
		$complementario=$con->obtenerValor($consulta);
		$arrDependencias=explode(",",$complementario);
		$nArrDep=sizeof($arrDependencias);
		$nuevasDep="";
		for($x=0;$x<$nArrDep;$x++)
		{
			if($arrDependencias[$x]!=$idAccion)
			{
				if($nuevasDep=="")
					$nuevasDep=$arrDependencias[$x];
				else
					$nuevasDep.=",".$arrDependencias[$x];
			}
		}
		
		$consulta="update 947_actoresProcesosEtapasVSAcciones set complementario2='".$nuevasDep."' where idAccionesProcesoEtapaVSAcciones=".$idAccionR;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
		
	}
	
	function eliminarPerfilModuloAutores()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 952_perfilesParticipacionAutores where idPerfilParticipacionAutor=".$idPerfil;
		$x++;
		$consulta[$x]="delete from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idPerfil;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";

	}
	
	function obtenerElementosEtapa()
	{
		global $con;
		$idEsquema=$_POST["idEsquema"];
		$consulta="select idElementoPerfilAutor,descParticipacion,clave from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idEsquema;
		$arrElementos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElementos)."";
	}
	
	function guardarConfiguracionModuloAutores()
	{
		global $con;
		$principal=$_POST["principal"];
		$idPerfil=$_POST["idPerfil"];
		$externo=$_POST["externo"];
		$singular=$_POST["singular"];
		$plural=$_POST["plural"];
		$idElemento=$_POST["idElemento"];
		$tituloResp=$_POST["tituloResp"];
		$tituloModulo=$_POST["tituloModulo"];
		$idModulo=$_POST["idModulo"];
		$mostrarOrden=$_POST["mostrarOrden"];
		$mostrarResp=$_POST["mostrarResp"];
		$mostrarAfil=$_POST["mostrarAfil"];
		$listRoles=$_POST["listRoles"];
		$evaluarParticipante=$_POST["evaluarParticipante"];
		$idProceso=$_POST["idProceso"];
		$configuracion=$_POST["objConf"];
		
		
		$query="select idFormulario from 203_elementosDTD where idElementoDTD=".$idModulo;
		$idFormulario=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 204_rolesModuloParticipantes where idElementoDTD=".$idElemento;
		$x++;
		
		$arrRoles=explode(",",$listRoles);
		foreach($arrRoles as $rol);
		{
			$consulta[$x]="insert into 204_rolesModuloParticipantes(codigoRol,idElementoDTD) values('".$rol."','".$idElemento."')";
			$x++;
		}
		$query="select * from 205_infoComplementariaModuloParticipantes where idElementoDTD=".$idElemento;
		$idFormularioEval="-1";
		$filaEval=$con->obtenerPrimeraFila($query);
		if(!$filaEval)
		{
			
			if($evaluarParticipante=="1")
			{
				$idFormularioEval=crearFormularioEvaluacionParticipante($idProceso);
			}
			$consulta[$x]="insert into 205_infoComplementariaModuloParticipantes(idElementoDTD,evaluaParticipantes,idFormularioEvaluacion,configuracion) values('".$idElemento."','".$evaluarParticipante."','".$idFormularioEval."','".$configuracion."')";
			$x++;
		}
		else
		{
			$idFormularioEval=$filaEval[3];
			$consulta[$x]="update 205_infoComplementariaModuloParticipantes set evaluaParticipantes=".$evaluarParticipante.",configuracion='".$configuracion."' where idElementoDTD=".$idElemento;
			$x++;	
		}
		$consulta[$x]="update 203_elementosDTD set complementario='".$idPerfil.",".cv($principal).",".cv($externo).",".cv($singular).",".cv($plural).",".cv($tituloResp).",".$mostrarOrden.",".$mostrarResp.",".$mostrarAfil."' where idElementoDTD=".$idElemento;
		$x++;
		$consulta[$x]="update 900_formularios set nombreFormulario='".cv($tituloModulo)."' where idFormulario=".$idFormulario;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
			echo "1|".$idFormularioEval;	
		else
			echo "|";
	}
	
	function crearFormularioEvaluacionParticipante($idProceso)
	{
		global $con;
		
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFrmEntidad=$con->obtenerValor($consulta);
		
		$objFormulario='
						{
							"nombreFormulario":"Formato de evaluacion de participantes ",
							"descripcion":"",
							"titulo":"Formato de dict�men Parcial",
							"idProceso":"'.$idProceso.'",
							"idEtapa":"1",
							"idFrmEntidad":"'.$idFrmEntidad.'",
							"frmRepetible":"0",
							"formularioBase":"0",
							"estadoInicial":"1",
							"eliminable":"0",
							"tipoFormulario":"13",
							"mostrarTableroControl":"0",
							"arrControles":[
												{
													"pregunta":	[
																 	{
																		"etiqueta":"Configure formato de evaluaci&oacute;n de participante:",
																		"idIdioma":"1"
																	}
																],
													"obligatorio":"0",
													"tipoElemento":"1",
													"posX":"20",
													"posY":"53",
													"eliminable":"0"
													
													
												}
											]
						}
	
					';
		
		$idFormulario=crearFormulario($objFormulario);	
		if($idFormulario!="-1")
		{	
			return $idFormulario;
		}
		else
			return false;
	}
	
	function obtenerOpcionesRegistradasDictamenParcial()
	{
		global $con;
		$idActor=$_POST["idActor"];
		$lblEtiqueta="";
		$consulta="SELECT accion FROM 945_accionesActor WHERE idGrupoAccion=4";
		$lblEtiqueta=$con->obtenerValor($consulta);
		$consulta="SELECT complementario3 FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$idActor." AND idGrupoAccion=4";
		$filaPA=$con->obtenerPrimeraFila($consulta);
		if($filaPA[0]!="")
		{
			$obj=json_decode($filaPA[0]);
			if(isset($obj->etiqueta))
			{
				$lblEtiqueta=$obj->etiqueta;
				
			}
		}
		$idElemento=$_POST["idGrupoElemento"];
		$consulta="(select valor,Contenido,d.idAccion,`of`.requiereRespuesta from 902_opcionesFormulario `of`,954_accionesDictamenParcial d
				  where   d.idValor=`of`.valor and  d.idGrupoElemento=`of`.idGrupoElemento and `of`.idGrupoElemento=".$idElemento." and 
				  `of`.idIdioma=".$_SESSION["leng"].")  order by valor";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos)."|".$lblEtiqueta;
		
		
	}
	
	function obtenerOpcionesRegistradasDictamenRevisores()
	{
		global $con;
		$idElemento=$_POST["idGrupoElemento"];
		$consulta="(select valor,Contenido from 902_opcionesFormulario `of`
				  where   `of`.idGrupoElemento=".$idElemento." and 
				  `of`.idIdioma=".$_SESSION["leng"].")  order by valor";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos);
	}
	
	function obtenerActividadesProgramadas()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
		$idProceso=$con->obtenerValor($consulta);
		$nodos=obtenerActividadesHijasProyecto("-1",$idProceso,$idReferencia);
	 	echo uEJ($nodos);
	}
	
	function obtenerActividadesHijasProyecto($idPadre,$idProceso,$idReferencia)
	{
		global $con;
		$consulta="select idActividadPrograma,fechaInicio,fechaFin,actividad,descripcion from 965_actividadesUsuario where idProcesoAsociado=".$idProceso." and idReferencia=".$idReferencia." and idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$nodosHijos=obtenerActividadesHijas($fila[0]);
			if($nodosHijos=="[]")
				$hijos="leaf:true,";
			else
				$hijos="leaf:false,children:".$nodosHijos.",";
			$obj='	{	
										"text":" '.cvJs($fila[3]).'",
										"id":"'.$fila[0].'",
										"icon":"../images/calendar.png",
										"fInicio":"'.date('d/m/Y',strtotime($fila[1])).'",
										"fFin":"'.date('d/m/Y',strtotime($fila[2])).'",
										"descripcion":"'.cvJs($fila[4]).'",
										"qtip":"'.cvJs($fila[4]).'",
										"cls":"x-btn-text-icon",
										'.$hijos.'
										"allowDrop":false,
										"uiProvider":"col",
										"draggable" :false
										
		
					}';
			if($arrNodos=="")
				$arrNodos=$obj;
			else
				$arrNodos.=",".$obj;
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerActividadesHijas($idPadre)
	{
		global $con;
		$consulta="select idActividadPrograma,fechaInicio,fechaFin,actividad,descripcion from 965_actividadesUsuario where idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$nodosHijos=obtenerActividadesHijas($fila[0]);
			if($nodosHijos=="[]")
				$hijos="leaf:true,";
			else
				$hijos="leaf:false,children:".$nodosHijos.",";
			$obj='	{	
										"text":" '.cvJs($fila[3]).'",
										"id":"'.$fila[0].'",
										"icon":"../images/calendar.png",
										"fInicio":"'.date('d/m/Y',strtotime($fila[1])).'",
										"fFin":"'.date('d/m/Y',strtotime($fila[2])).'",
										"descripcion":"'.cvJs($fila[4]).'",
										"qtip":"'.cvJs($fila[4]).'",
										"cls":"x-btn-text-icon",
										'.$hijos.'
										"allowDrop":false,
										"uiProvider":"col",
										"draggable" :false
										
		
					}';
			if($arrNodos=="")
				$arrNodos=$obj;
			else
				$arrNodos.=",".$obj;
		}
		return "[".$arrNodos."]";
	}
	
	function guardarActividad()
	{
		global $con;
		$obj=$_POST["obj"];
		$objJson=json_decode($obj);
		$consulta="select idProceso from 900_formularios where idFormulario=".$objJson->idFormulario;
		$idProceso=$con->obtenerValor($consulta);
		$raizUsuario=0;
		if($objJson->idPadre=='-1')
			$raizUsuario=1;
		
		$consulta="insert into 965_actividadesUsuario(tipoActividadProgramada,actividad,fechaInicio,fechaFin,prioridad,idUsuario,descripcion,idProcesoAsociado,idReferencia,idPadre,idFormulario,raizUsuario) values
					(2,'".cv($objJson->actividad)."','".$objJson->fechaInicio."','".$objJson->fechaFin."',1,-1,'".cv($objJson->descripcion)."',".$idProceso.",".$objJson->idReferencia.",".$objJson->idPadre.",".$objJson->idFormulario.",".$raizUsuario.")";
		if($con->ejecutarConsulta($consulta))					
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarActividad()
	{
		global $con;
		$idActividad=$_POST["idActividad"];
		$consulta="begin";
		
		if($con->ejecutarConsulta($consulta))					
		{
			if(eliminaActividadRec($idActividad))
			{
				$consulta="commit";
				if($con->ejecutarConsulta($consulta))					
					echo "1|";
				else
					echo "|";
				
			}
			else
				echo "|";
			
		}
		else
			echo "|";
	}
	
	function eliminaActividadRec($idActividad)
	{
		global $con;
		$consulta="select * from 965_actividadesUsuario where idPadre=".$idActividad;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if(!eliminaActividadRec($fila[0]))
				return false;
		}
		$x=0;
		$query[$x]="delete from 965_actividadesUsuario where idActividadPrograma=".$idActividad;
		$x++;
		$query[$x]="delete from 969_actividadesLineasAccion where idActividad=".$idActividad;
		$x++;
		$query[$x]="delete from 970_actividadesVSProductos where idActividad=".$idActividad;
		$x++;
		$query[$x]="delete from 971_actividadesVSMetas where idActividad=".$idActividad;
		$x++;
		$query[$x]="delete from 972_actividadesVSElementosCV where idActividad=".$idActividad;
		$x++;
		$query[$x]="delete from 973_reporteActividades where idActividad=".$idActividad;
		$x++;
		return $con->ejecutarBloque($query);
	}
	
	function modificarActividad()
	{
		global $con;
		$obj=$_POST["obj"];
		
		$objJson=json_decode($obj);
		
		$consulta="update 965_actividadesUsuario set fechaInicio='".$objJson->fechaInicio."',fechaFin='".$objJson->fechaFin."',actividad='".cv($objJson->actividad)."',
					descripcion='".$objJson->descripcion."' where idActividadPrograma=".$objJson->idActividad;
					
		if($con->ejecutarConsulta($consulta))					
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarParticipacionAutor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idUsuario=$_POST["idUsuario"];
		$participacion=$_POST["participacion"];
		
		$consulta="update 246_autoresVSProyecto set claveParticipacion='".cv($participacion)."' where id_246_autoresVSProyecto=".$idUsuario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function bloquearElemento()
	{
		global $con;
		$idFormulario=base64_decode($_POST["idFormulario"]);
		$idReferencia=base64_decode($_POST["idReferencia"]);
		
		$consulta="insert into 963_estadosElementoDTD(idFormulario,idReferencia,estado) values(".$idFormulario.",".$idReferencia.",1)";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
							 
	}
	function quitarBloquearElemento()
	{
		global $con;
		$idFormulario=base64_decode($_POST["idFormulario"]);
		$idReferencia=base64_decode($_POST["idReferencia"]);
		
		$consulta="delete from 963_estadosElementoDTD where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
							 
	}
	
	function obtenerRevisores()
	{
		global $con;
		$cadObjJson=$_POST["datosAutor"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idActorProcesoEtapa=base64_decode($_POST["actor"]);
		$objJson=json_decode($cadObjJson);
		$condWhere="";
		if($objJson->apPaterno!="")
		{
			$condWhere=" Paterno like '".uEJ($objJson->apPaterno)."%'";
		}
		if($objJson->apMaterno!="")
		{
			if($condWhere!="")
				$condWhere.=" and ";	
			$condWhere.=" Materno like '".uEJ($objJson->apMaterno)."%'";
		}
		if($objJson->nombres!="")
		{
			if($condWhere!="")
				$condWhere.=" and ";	
			$condWhere.=" Nom like '".uEJ($objJson->nombres)."%'";
		}
		
		$consulta="select idUsuario,Nom,Paterno,Materno from 802_identifica where ".$condWhere." and idUsuario not 
					in(select idUsuarioRevisor from 955_revisoresProceso where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idActorProcesoEtapa=".$idActorProcesoEtapa." and estado in (1,2))";
		$res=$con->obtenerFilas($consulta);
		$numElementos=$con->filasAfectadas;
		$arrAutores="";
		while($filas=$con->fetchRow($res))
		{
			$obj='{"idAutor":"'.$filas[0].'","apPat":"'.cv($filas[2]).'","apMat":"'.cv($filas[3]).'","nombres":"'.cv($filas[1]).'","fichaOrg":""}';
			if($arrAutores=="")
				$arrAutores=$obj;
			else
				$arrAutores.=",".$obj;
		}
		echo '{"numAutores":"'.$numElementos.'","autores":['.uEJ($arrAutores).']}';
	}
	
	function guardarRevisor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAutor=$_POST["idAutor"];
		$estado=$_POST["estado"];
		$versionRegistro=$_POST["versionRegistro"];
		$idActor=base64_decode($_POST["idActor"]);
		$idFormularioEval=$_POST["idFormularioEval"];
		$x=0;
		$query="select idProceso from 900_formularios where idFormulario=".$idFormulario;
		$idProceso=$con->obtenerValor($query);
		
		if(!isset($_POST["mRevisores"]))
		{		
			$query="insert into 955_revisoresProceso(idUsuarioRevisor,idFormulario,idReferencia,idActorProcesoEtapa,fechaAsignacion,estado,idProceso,versionRegistro,idFormularioDictamen) 
					values(".$idAutor.",".$idFormulario.",".$idRegistro.",".$idActor.",'".date('Y-m-d')."',".$estado.",".$idProceso.",".$versionRegistro.",".$idFormularioEval.")";
			if($con->ejecutarConsulta($query))
			{
				$idAutorRevisor=$con->obtenerUltimoID();
				$query="select idUsuariosVsRoles from 807_usuariosVSRoles where idUsuario=".$idAutor." and codigoRol='10_0'";
				
				$idUR=$con->obtenerValor($query);
				if($idUR=="")
				{
					$consulta="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idAutor.",10,0,'10_0')";
					if(!$con->ejecutarConsulta($consulta))	
					{
						return;
					}
				}
			}
			else
			{
				return;
				
			}
		}
		else
		{
			$arrRevisor=explode(",",$idAutor);
			foreach($arrRevisor as $idAutor)
			{
			
				$query="insert into 955_revisoresProceso(idUsuarioRevisor,idFormulario,idReferencia,idActorProcesoEtapa,fechaAsignacion,estado,idProceso,versionRegistro,idFormularioDictamen) 
						values(".$idAutor.",".$idFormulario.",".$idRegistro.",".$idActor.",'".date('Y-m-d')."',".$estado.",".$idProceso.",".$versionRegistro.",".$idFormularioEval.")";
				if($con->ejecutarConsulta($query))
				{

					$query="select idUsuariosVsRoles from 807_usuariosVSRoles where idUsuario=".$idAutor." and codigoRol='10_0'";
					
					$idUR=$con->obtenerValor($query);
					if($idUR=="")
					{
						$consulta="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idAutor.",10,0,'10_0')";
						if(!$con->ejecutarConsulta($consulta))	
							return;
						
					}
					
					
				}
				else
					return;
			}
			
			
						
		}
		
		
		$consulta="select a.idRevisorProceso,concat(i.Paterno,' ',i.Materno,', ',i.Nom) as nombre,'' as afiliacion,estado,idFormDictamen,date_format(fechaAsignacion,'%d/%m/%Y') as fechaAsignacion,
			if(fechaDictamen is null,'',date_format(fechaDictamen,'%d/%m/%Y')) as fechaDictamen,(select nombreFormulario from 900_formularios where idFormulario=a.idFormularioDictamen) as formatoEval 
			from 955_revisoresProceso a,802_identifica i where i.idUsuario=a.idUsuarioRevisor and a.idFormulario=".$idFormulario." and a.idReferencia=".$idRegistro."
			and a.estado in (0,1,2) and idActorProcesoEtapa=".$idActor." and a.versionRegistro=".$versionRegistro." order by nombre";
		$arrRevisores=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRevisores;

	}
	
	function eliminarRevisor()
	{
		global $con;
		$idAutor=$_POST["idAutor"];
		$x=0;
		$consulta[$x]="delete from 955_revisoresProceso where idRevisorProceso=".$idAutor;
		$x++;
		$query="select idUsuarioRevisor from 955_revisoresProceso where idRevisorProceso=".$idAutor;
		$idUsuario=$con->obtenerValor($query);
		$query="select idRevisorProceso from 955_revisoresProceso where idUsuarioRevisor=".$idUsuario." and idRevisorProceso <>".$idAutor;
		$res=$con->obtenerFilas($query);
		if($con->filasAfectadas==0)
		{
			$consulta[$x]="delete from 807_usuariosVSRoles where idUsuario=".$idUsuario." and codigoRol='10_0'";
			$x++;	
		}
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarNuevoRevisor($objParam=null)
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["datosAutor"];
				
		$objJson=json_decode($cadObjJson);
		$idActorProcesoEtapa=bD($_POST["actor"]);
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		if($objParam==null)
		{
			$idFormulario=bD($objJson->idFormulario);
			$idRegistro=bD($objJson->idRegistro);
		}
		else
		{
			$idFormulario=$objJson->idFormulario;
			$idRegistro=$objJson->idRegistro;	
		}
		$codInstitucion=$objJson->codInstitucion;
		$codDepto=$objJson->codDepto;
		$telefonos=$objJson->telefonos;
		$idIdioma="1";
		$password=generarPassword();
		$mailUsr=$mail;
		$status="5";
		$versionRegistro=$objJson->versionRegistro;
		
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.")";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		$estadoD=0;
		
		$query="select max(a.estado) from 955_revisoresProceso a where  a.idFormulario=".$idFormulario." and a.idReferencia=".$idRegistro."
						and a.estado in (0,1,2) and idActorProcesoEtapa=".$idActorProcesoEtapa." and a.versionRegistro=".$versionRegistro;
		$estadoD=$con->obtenerValor($query);
		if($estadoD=="")
			$estadoD=0;
		
		$query="select count(idUsuario) from 246_autoresVSProyecto where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$orden=$con->obtenerValor($query);
		$orden++;
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",10,0,'10_0')";
		$x++;
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$consulta[$x]="insert into 955_revisoresProceso (idUsuarioRevisor,idFormulario,idReferencia,idActorProcesoEtapa,fechaAsignacion,estado,versionRegistro,idProceso) 
						values(".$idUsuario.",".$idFormulario.",".$idRegistro.",".$idActorProcesoEtapa.",'".date('Y-m-d')."',".$estadoD.",".$versionRegistro.",".$idProceso.")";

		$x++;
		if($telefonos!="")
		{
			$arrTelefonos=explode(",",$telefonos);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode("_",$arrTelefonos[$y]);
				$tipo=$datosTel[0];
				$codArea=$datosTel[1];
				$lada=$datosTel[2];
				$tel=$datosTel[3];
				$ext=$datosTel[4];
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo."".$idUsuario.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))		
		{
			$link=$urlSitio."/principal/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario);
			$arrParametros='[
								["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
								["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
								["$nombre","'.$nombre.'"]
							]';
			$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idAccion":"2"}';
			if(enviarCircular($objEnvio))
				echo "1|";
			else
				echo "|";
		}
		else
			echo "|";
	}
	
	function cambiarEstadoProcesoDictamen()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idActor=base64_decode($_POST["idActor"]);
		$estado=$_POST["estado"];
		$id=$_POST["id"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 948_actoresVSFormulariosDictamen set estado=1 where idActorVSFormularioDictamen=".$id;
		$x++;
		$consulta[$x]="update 955_revisoresProceso set estado=1 where idFormulario=".$idFormulario." and idReferencia=".$idReferencia." and idActorProcesoEtapa=".$idActor;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerObjetosProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select nombreTabla from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$nTabla=$con->obtenerValor($consulta);
		if($nTabla=="")
			echo "1|[]";
		else
		{
			$consulta="select * from ".$nTabla;
			$resReg=$con->obtenerFilas($consulta);
			$idRegistro=$con->fieldName($resReg,0);
			$campo=$con->fieldName($resReg,9);
			
			$consulta="select ".$idRegistro.",".$campo." from ".$nTabla." order by ".$campo;
			
			$res=$con->obtenerFilas($consulta);
			$arrObjetos="";
			while($fila=$con->fetchRow($res))
			{
				
				$obj="['".$fila[0]."','".$fila[1]."']";
				if($arrObjetos=="")
					$arrObjetos=$obj;
				else
					$arrObjetos.=",".$obj;
			}
		}
		
		echo "1|[".uEJ($arrObjetos)."]";
		
		
		
	}
	
	function obtenerLineasAccionProceso()
	{
		global $con;
		$idProceso="-1";
		$idRegistro="-1";
		if(isset($_POST["idProceso"]))
			$idProceso=$_POST["idProceso"];
		if(isset($_POST["idRegistro"]))
			$idRegistro=$_POST["idRegistro"];
		
		if($idProceso!="-1")
		{
			$consulta="select nombreTabla,idFrmEntidad from 203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and e.idProceso=".$idProceso." and f.titulo=1";
			$fila=$con->obtenerPrimeraFila($consulta);
			if($fila)
			{
				$nTabla=$fila[0];
				$frmEntidad=$fila[1];
				$consulta="select * from (select id_241_proyectosVSLineasAccion,txtLineaAccion,(select txtLineaInv from 243_lineasInvestigacion where id_243_lineasInvestigacion= la.idLineaInvestigacion) as lineaInvestigacion from 244_lineasAccion l,
							241_proyectosVSLineasAccion la 	where l.id_244_lineasAccion=la.idLineaAccion and la.idFormulario=".$frmEntidad." and la.idReferencia=".$idRegistro.") as tmp order by lineaInvestigacion,txtLineaAccion" ;
				$arrLineas=$con->obtenerFilasArreglo($consulta);	
				echo "1|".uEJ($arrLineas);
			}
			else
				echo "1|[]";
		}
		else
		{
			$consulta="select id_244_lineasAccion,txtLineaAccion from 244_lineasAccion order by txtLineaAccion";
			$arrLineas=$con->obtenerFilasArreglo($consulta);	
			echo "1|".uEJ($arrLineas);
			
		}
			
	}
	
	function confirmarRaiz($idActividad,$idUsuario)
	{
		global $con;
		if($idActividad=="-1")
			return true;
		$consulta="select raizUsuario,idUsuario,idPadre from 965_actividadesUsuario where idActividadPrograma=".$idActividad;
		
		$filaRaiz=$con->obtenerPrimeraFila($consulta);
		if($con->filasAfectadas==0)
			return true;
		$idRaiz=$filaRaiz[0];
		$idUsuarioAct=$filaRaiz[1];
		$idPadre=$filaRaiz[2];
		
		if($idUsuarioAct==$idUsuario)
			return false;
		return 	confirmarRaiz($idPadre,$idUsuario);
		
	}
	
	function guardarActividadProgTrabajo()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$productos=$obj->productos;	
		$metas=$obj->metas;
		$elementosCV=$obj->elementosCV;
		$x=0;
		$query="begin";
		$raizUsuario=$obj->raizUsuario;
		
		if(($raizUsuario=='1')&&($obj->tipoActividad=='2'))
		{	
		
			if(!confirmarRaiz($obj->idPadre,base64_decode($obj->idUsuario)))
				$raizUsuario=0;
		}
		
		if($con->ejecutarConsulta($query))
		{
			$idFormulario="-1";	
			if($obj->idProceso!="-1")
			{
				$queryTemp="select idFormulario from 900_formularios where idProceso=".$obj->idProceso." and formularioBase=1";
				$idFormulario=$con->obtenerValor($queryTemp);
			}
			
			$reporte=$obj->reporte;
			$reportaAvances='0';
			switch($reporte)
			{
				case 1:
					$reporteFinal='0';
				case 2:
				
					$diasReporte=0;
					$fechaInicioReporte='';
					if($reporte==2)
						$reporteFinal='1';
					
				break;
				case 3:
					$reportaAvances='0';
				case 4:
					if($reporte==4)
						$reportaAvances='1';
					$diasReporte=$obj->diasReporte;
					$fechaInicioReporte=$obj->fechaInicioReporte;
					$reporteFinal=$obj->reporteFinal;
				break;
				default:
					$reporteFinal=0;
			}
			
			$query="insert into 965_actividadesUsuario(tipoActividadProgramada,actividad,idTipoReporte,
					fechaInicio,fechaFin,prioridad,idUsuario,idProcesoAsociado,idReferencia,idPadre,horasTotal,idFormulario,
					raizUsuario,reporteFinal,reportaAvance) 
					values (".$obj->tipoActividad.",'".cv($obj->actividad)."',".$obj->reporte.",'".$obj->fechaInicio."','".
					$obj->fechaFin."',".$obj->tActividad.",".base64_decode($obj->idUsuario).",".$obj->idProceso.",".$obj->idReferencia.",".
					$obj->idPadre.",".$obj->duracion.",".$idFormulario.",".$raizUsuario.",".$reporteFinal.",".$reportaAvances.")";
			
			if(!$con->ejecutarConsulta($query))
			{
				echo "|";
				return;
			}
			
			$idActividad=$con->obtenerUltimoID();
			if(isset($obj->ajustarFechaFinPadre)&&($obj->ajustarFechaFinPadre==1))
			{
				ajustarPadreNuevaFechaFinal($obj->idPadre,$obj->fechaFin,$consulta,$x);
				
			}
			$nReporte=1;
			$fFin=strtotime($obj->fechaFin);
			if(($reporte==3)||($reporte==4))
			{
				$fInicio=strtotime(cambiaraFechaMysql($fechaInicioReporte));
				
				
				while($fInicio<=$fFin)
				{
					$consulta[$x]="insert into 973_reporteActividades(idActividad,fechaReporte,idResponsable,noReporte,reportaAvance,tipoReporte)
								   values(".$idActividad.",'".date('Y-m-d',$fInicio)."',".base64_decode($obj->idUsuario).",".$nReporte.",".$reportaAvances.",0)";
					$x++;
					$nReporte++;
					$fInicio=strtotime("+".$diasReporte." days",$fInicio);
				}
				if($reporteFinal=='1')
				{
					$consulta[$x]="insert into 973_reporteActividades(idActividad,fechaReporte,idResponsable,noReporte,reportaAvance,tipoReporte)
								   values(".$idActividad.",'".date('Y-m-d',$fFin)."',".base64_decode($obj->idUsuario).",".$nReporte.",0,1)";
					
					$x++;
				}
			
			}
			if($reporte==2)
			{
				$consulta[$x]="insert into 973_reporteActividades(idActividad,fechaReporte,idResponsable,noReporte,reportaAvance,tipoReporte)
								   values(".$idActividad.",'".date('Y-m-d',$fFin)."',".base64_decode($obj->idUsuario).",".$nReporte.",0,1)";
					
				$x++;
			}
			
			$lineasA=$obj->lAccion;
			if($lineasA!="")
			{
				$arrLineas=explode(",",$lineasA);	
				$nLineas=sizeof($arrLineas);
				for($ct=0;$ct<$nLineas;$ct++)
				{
					if(!isset($obj->oPrograma))
					{
						$query="select * from 241_proyectosVSLineasAccion where id_241_proyectosVSLineasAccion=".$arrLineas[$ct];
						$filaLinea=$con->obtenerPrimeraFila($query);
						$consulta[$x]="insert into 969_actividadesLineasAccion(idActividad,idLineaAccion,idLineaInvestigacion) values(".$idActividad.",".$filaLinea[1].",".$filaLinea[4].")";
						$x++;

					}
					else
					{
						if($obj->idPadre!=-1)
						{
							$query="select * from 969_actividadesLineasAccion where idAtividadLineasAccion=".$arrLineas[$ct];
							$filaLinea=$con->obtenerPrimeraFila($query);
							$idLineaAccion=$filaLinea[2];
							$idLineaInv=$filaLinea[3];
						}
						else
						{
							$infoLinea=explode("|",$arrLineas[$ct]);
							$idLineaAccion=$infoLinea[0];
							$idLineaInv=$infoLinea[1];
						}
						$consulta[$x]="insert into 969_actividadesLineasAccion(idActividad,idLineaAccion,idLineaInvestigacion) values(".$idActividad.",".$idLineaAccion.",".$idLineaInv.")";
						$x++;

					}
					
					
				}
			}
			
			foreach($productos as $prod)
			{
				$consulta[$x]="insert into 970_actividadesVSProductos(idActividad,producto) values(".$idActividad.",'".cv($prod->producto)."')";
				$x++;
			}
			
			foreach($metas as $meta)
			{
				$consulta[$x]="insert into 971_actividadesVSMetas(idActividad,meta) values(".$idActividad.",'".cv($meta->meta)."')";
				$x++;
			}
			
			$arrElementosCV=array();
			if($elementosCV!='')
				$arrElementosCV=explode(',',$elementosCV);
			
			foreach($arrElementosCV as $elementoCV)
			{
				$consulta[$x]="insert into 972_actividadesVSElementosCV(idActividad,idElementoCV) values(".$idActividad.",".$elementoCV.")";
				$x++;
			}
			
			$consulta[$x]="commit";
			if($con->ejecutarBloque($consulta))
				echo "1|";
			else
				echo "|";
			
		}
		else
			echo "|";
	}
	
	function ajustarPadreNuevaFechaFinal($idPadre,$fechaFin,&$consulta,&$x)
	{
		global $con;
		$query="select idPadre,fechaFin from 965_actividadesUsuario where idActividadPrograma=".$idPadre;
		$filaAct=$con->obtenerPrimeraFila($query);
		if(strtotime($filaAct[1])<strtotime($fechaFin))
		{
			$consulta[$x]="update 965_actividadesUsuario set fechaFin='".$fechaFin."' where idActividadPrograma=".$idPadre;
			$x++;
			if($filaAct[0]!="-1")
				ajustarPadreNuevaFechaFinal($filaAct[0],$fechaFin,$consulta,$x);		
		}
		
	}
	
	
	function eliminarActividadProgramaTrabajo()
	{
		global $con;
		$idActividad=$_POST["idActividad"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 965_actividadesUsuario where idActividadPrograma=".$idActividad;
		$x++;
		$consulta[$x]="delete from 969_actividadesLineasAccion where idActividad=".$idActividad;
		$x++;
		$consulta[$x]="delete from 970_actividadesVSProductos where idActividad=".$idActividad;
		$x++;
		$consulta[$x]="delete from 971_actividadesVSMetas where idActividad=".$idActividad;
		$x++;
		$consulta[$x]="delete from 972_actividadesVSElementosCV where idActividad=".$idActividad;
		$x++;
		$consulta[$x]="delete from 973_reporteActividades where idActividad=".$idActividad;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerCita()
	{
		global $con;
		$idCita=$_POST["idCita"];
		
		$consulta="delete from citaxnumero where id_cita=".$idCita;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarSesionTrabajo()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="select actividad from 965_actividadesUsuario where idActividadPrograma=".$obj->idActividad;
		$actividad=$con->obtenerValor($consulta);
		
		
		$hInicio=date('H:i',strtotime(cambiaraFechaMysql($obj->fecha)." ".$obj->hInicio.":00"));
		
		$tHoraFinal=strtotime("+".$obj->duracion." hours",strtotime(cambiaraFechaMysql($obj->fecha)." ".$obj->hInicio.":00"));
		$hFinal=date('H:i',$tHoraFinal);
		
		
		
		$consulta="select inicio,final from 4089_calendario where idUsuario=".$obj->idUsuario." and fecha='".cambiaraFechaMysql($obj->fecha)."'";
		$resEventos=$con->obtenerFilas($consulta);
		while($filaE=$con->fetchRow($resEventos))
		{
			if(colisionaTiempo($hInicio,$hFinal,$filaE[0],$filaE[1]))
			{
				echo "<br>Usted ya tiene otra actividad planeada dentro del intervalo de horas indicado, se recomienda revisar su agenda de eventos";
				return;
			}
		}
		
		if($obj->fecha!=date("d/m/Y",$tHoraFinal))
		{
			echo "<br>El n&uacute;mero de horas ingresado excede las horas disponibles en el d&iacute;a, el cual es de: <b>".date("g",restaHoras($obj->hInicio,"23:59"))."</b> hrs.";
			return;
		}
		
		$consulta="insert into 4089_calendario(inicio,final,idUsuario,lugar,tipo,fecha,titulo) values('".$obj->hInicio.":00','".$hFinal.":00',".$obj->idUsuario.",
					'".$obj->idActividad."',2,'".cambiaraFechaMysql($obj->fecha)."','".utf8_encode('Sesi�n')." de trabajo de la actividad: ".$actividad."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerSesionTrabajo()
	{
		global $con;
		$idSesion=base64_decode($_POST["idSesion"]);
		$consulta="delete from 4089_calendario where idFecha=".$idSesion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerProcesos()
	{
		global $con;
		$idTipoProceso=$_POST["idTipoProceso"];
		$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$idTipoProceso." and idProceso in (select ed.idProceso from 203_elementosDTD ed,900_formularios f where f.idFormulario=ed.idFormulario and f.tipoFormulario=10 and
					f.titulo=6) order by nombre";
		$arrObjetos=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arrObjetos)."";
	}
	
	function obtenerActividadesProgramadasObjeto()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFormulario=$con->obtenerValor($consulta);
		$nodos=obtenerActividadesHijasObjeto("-1",$idFormulario,$idReferencia);
	 	echo uEJ($nodos);
		
	}
	
	function obtenerActividadesHijasObjeto($idPadre,$idFormulario,$idReferencia)
	{
		global $con;
		$consulta="select idActividadPrograma,fechaInicio,fechaFin,actividad,descripcion from 965_actividadesUsuario where idFormulario=".$idFormulario." and idReferencia=".$idReferencia." and idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$nodosHijos=obtenerNodosHijosActividadesObjeto($fila[0]);
			if($nodosHijos=="[]")
				$hijos="leaf:true,";
			else
				$hijos="leaf:false,children:".$nodosHijos.",";
			$obj='	{	
										"text":" '.$fila[3].' <span class=\'copyrigthVerde\'>(Del '.date('d/m/Y',strtotime($fila[1])).' al '.date('d/m/Y',strtotime($fila[2])).')</span>",
										"id":"'.$fila[0].'",
										"checked":false,
										"icon":"../images/calendar.png",
										"fInicio":"'.date('d/m/Y',strtotime($fila[1])).'",
										"fFin":"'.date('d/m/Y',strtotime($fila[2])).'",
										"descripcion":"'.cvJs($fila[4]).'",
										"qtip":"'.cvJs($fila[4]).'",
										"cls":"x-btn-text-icon",
										'.$hijos.'
										"allowDrop":false,
										"draggable" :false
					}';
			if($arrNodos=="")
				$arrNodos=$obj;
			else
				$arrNodos.=",".$obj;
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerNodosHijosActividadesObjeto($idPadre)
	{
		global $con;
		$consulta="select idActividadPrograma,fechaInicio,fechaFin,actividad,descripcion from 965_actividadesUsuario where idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$nodosHijos=obtenerNodosHijosActividadesObjeto($fila[0]);
			if($nodosHijos=="[]")
				$hijos="leaf:true,";
			else
				$hijos="leaf:false,children:".$nodosHijos.",";
			$obj='	{	
										"text":" '.$fila[3].' <span class=\'copyrigthVerde\'>(Del '.date('d/m/Y',strtotime($fila[1])).' al '.date('d/m/Y',strtotime($fila[2])).')</span>",
										"id":"'.$fila[0].'",
										"checked":false,
										"icon":"../images/calendar.png",
										"fInicio":"'.date('d/m/Y',strtotime($fila[1])).'",
										"fFin":"'.date('d/m/Y',strtotime($fila[2])).'",
										"descripcion":"'.cvJs($fila[4]).'",
										"qtip":"'.cvJs($fila[4]).'",
										"cls":"x-btn-text-icon",
										'.$hijos.'
										"allowDrop":false,
										"draggable" :false
					}';
			if($arrNodos=="")
				$arrNodos=$obj;
			else
				$arrNodos.=",".$obj;
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerDatosActividad()
	{
		global $con;
		$idActividad=$_POST["idActividad"];
		$consulta="select tipoActividadProgramada,idProcesoAsociado,idReferencia,fechaInicio,fechaFin from 965_actividadesUsuario where idActividadPrograma=".$idActividad;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select idAtividadLineasAccion,l.txtLineaAccion,(select txtLineaInv from 243_lineasInvestigacion where id_243_lineasInvestigacion=al.idLineaInvestigacion) as lAccion from 969_actividadesLineasAccion al,244_lineasAccion l 
						where al.idLineaAccion=l.id_244_lineasAccion and al.idActividad=".$idActividad;
		$arrLineas=$con->obtenerFilasArreglo($consulta);	
		
		$obj='[{"tipoAct":"'.$fila[0].'","idProceso":"'.$fila[1].'","idObjeto":"'.$fila[2].'","fechaMinI":"'.date('d/m/Y',strtotime($fila[3])).'","lineasAcccion":'.$arrLineas.',"fechaMax":"'.date('d/m/Y',strtotime($fila[4])).'"}]';
		echo "1|".$obj;
	}
	
	function eliminarArchivoReporte()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idArchivo=base64_decode($_POST["idArchivo"]);
		$consulta="delete from 974_archivosReportes where id_974_archivosReportes=".$idArchivo;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarRolModulo()
	{
		global $con;
		$rol=$_POST["rol"];
		$idModulo=$_POST["idModulo"];
		$consulta="insert into 978_rolesVSModulos(rol,idModulo) values('".$rol."',".$idModulo.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerPermiso()
	{
		global $con;
		$idPermiso=base64_decode($_POST["idPermiso"]);
		$consulta="delete from 977_rolesVSPermisosModulo where idRolesVSPermisosModulo=".$idPermiso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
			
	}
	
	function obtenerPermisosModuloFicha()
	{
		global $con;
		$rol=$_POST["rol"];
		$consulta= "select idPermisosModulo,permiso from 976_permisosModulos where idModulo=1 and idPermisosModulo not in ".
					"(select idPermiso from 977_rolesVSPermisosModulo where idModulo=1 and rol='".$rol."') and estado=1 order by permiso ";
		$arrPermisos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrPermisos);
	}
	
	function guardarPermisosModuloFicha()
	{
		global $con;
		$rol=$_POST["rol"];
		$lPermisos=$_POST["lPermisos"];
		$arrPermisos=explode(",",$lPermisos);
		$nPermisos=sizeof($arrPermisos);
		$pos=0;
		$consulta[$pos]="begin";
		$pos++;
		
		for($x=0;$x<$nPermisos;$x++)
		{
			$consulta[$pos]="insert into 977_rolesVSPermisosModulo(rol,idModulo,idPermiso) values('".$rol."',1,".$arrPermisos[$x].")";
			$pos++;
		}
		$consulta[$pos]="commit";
		$pos++;
		if($con->ejecutarBloque($consulta))	
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionUsuario()
	{
		global $con;
		$dias=$_POST["dias"];
		$hFin=$_POST["hFin"];
		$hInicio=$_POST["hInicio"];
		$idUsuario=$_POST["idUsuario"];
		$arrDias=explode(",",$dias);
		$nDias=sizeof($arrDias);
		$arrDiasLetra[0][0]="1";
		$arrDiasLetra[0][1]="Lunes";
		$arrDiasLetra[1][0]="2";
		$arrDiasLetra[1][1]="Martes";
		$arrDiasLetra[2][0]="3";
		$arrDiasLetra[2][1]="Mi�rcoles";
		$arrDiasLetra[3][0]="4";
		$arrDiasLetra[3][1]="Jueves";
		$arrDiasLetra[4][0]="5";
		$arrDiasLetra[4][1]="Viernes";
		$arrDiasLetra[5][0]="6";
		$arrDiasLetra[5][1]="S�bado";
		$arrDiasLetra[6][0]="0";
		$arrDiasLetra[6][1]="Domingo";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$horaI=strtotime($hInicio);
		for($z=0;$z<$nDias;$z++)
		{
			$hI=strtotime($hInicio);	
			$hF=strtotime($hFin);	
			$difHora=restaHoras($hInicio,$hFin);
			$horasLab=date("H",$difHora);
			$minLab=date("i",$difHora);
			$consulta[$x]="insert into 979_horariosLaborUsuario(idUsuario,numDia,horaInicio,horaFin,horasLaborales,minutosLaborales) values
							(".$idUsuario.",".$arrDias[$z].",'".$hInicio."','".$hFin."',".$horasLab.",".$minLab.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consultaAux="select * from 979_horariosLaborUsuario where idUsuario=".$idUsuario;
			
			$horasTotal=0;
			$minutosTotal=0;
			$arrDiasConf="";
			$res=$con->obtenerFilas($consultaAux);
			while($fila=$con->fetchRow($res))
			{
				$pDia=existeValorMatriz($arrDiasLetra,$fila[2]);
				$nDia=$arrDiasLetra[$pDia][1];
				$objDias="['".$fila[0]."','".$nDia."','".date("g:i A",strtotime($fila[3]))."','".date("g:i A",strtotime($fila[4]))."']";
				if($arrDiasConf=="")
					$arrDiasConf=$objDias;
				else
					$arrDiasConf.=",".$objDias;
				
			}
			$arrDiasConf="[".$arrDiasConf."]";
			echo "1|".$arrDiasConf;
		}
		else
			echo "|";

	}
	
	function obtenerProyectosAdemdum()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idProceso=$_POST["idProceso"];
		$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
		$idProcesoProy=$con->obtenerValor($consulta);
		$consulta="select nombreTabla,idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$filaP=$con->obtenerPrimeraFila($consulta);
		
		$nTabla=$filaP[0];
		$idFormularioP=$filaP[1];
		
		$consulta="select idReferenciaAd from 981_ademdums where idFormularioAd=".$idFormularioP." and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$listaRef=$con->obtenerListaValores($consulta);	
		if($listaRef=="")
			$listaRef="-1";
		
		if($idProceso=$idProcesoProy)
			$listaRef.=",".$idReferencia;
		$consulta="select * from ".$nTabla." where 1=2";
		$resProy=$con->obtenerFilas($consulta);
		$campoT=$con->fieldName($resProy,9);
		
		$consulta="select id_".$nTabla.",".$campoT." from ".$nTabla." where id_".$nTabla." not in(".$listaRef.") order by ".$campoT;
		$resProy=$con->obtenerFilas($consulta);
		$arrAdemdums="";
		while($filaProy=$con->fetchRow($resProy))
		{
			$nProy=$filaProy[1];
			if($arrAdemdums=='')
				$arrAdemdums="['".$filaProy[0]."','".$nProy."']";
			else
				$arrAdemdums.=",['".$filaProy[0]."','".$nProy."']";	
		}
		echo "1|[".uEJ($arrAdemdums)."]";
		
	}
	
	function guardarAdemdum()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idProceso=$_POST["idProceso"];
		$idReferenciaAd=$_POST["idReferenciaAd"];
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
		$idFormularioAd=$con->obtenerValor($consulta);
		$consulta="insert into 981_ademdums(idFormulario,idReferencia,idFormularioAd,idReferenciaAd) values(".$idFormulario.",".$idReferencia.",".$idFormularioAd.",".$idReferenciaAd.")";
		if($con->ejecutarConsulta($consulta))		
		{
			$idAdemdum=$con->obtenerUltimoID();
			echo "1|".$idAdemdum;
		}
		else
			echo "|";
	}
	
	function eliminarAdemdum()
	{
		global $con;
		$listaAd=$_POST["listaAd"];
		$consulta="delete from 981_ademdums where id_981_ademdums in (".$listaAd.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerActividadesOrigen()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idProceso=$_POST["idProceso"];
		$anio=$_POST["anio"];
		$consulta="select a.idActividadPrograma,a.actividad from 965_actividadesUsuario a,972_actividadesVSElementosCV e where e.idActividad=a.idActividadPrograma 
				  and a.fechaInicio<'".date('Y-m-d')."' and a.fechaInicio>='".$anio."-01-01' and a.fechaInicio<='".$anio."-12-31' and 
				  a.idUsuario=".$idUsuario." and e.idElementoCV=".$idProceso;
		$arrActividades=$con->obtenerFilasArreglo($consulta);
		if($arrActividades!="[]")
			$arrActividades="[['-1','Ninguna'],".substr($arrActividades,1);
		else
			$arrActividades="[['-1','Ninguna']]";
		echo "1|".uEJ($arrActividades);
	}
	
	function guardarActividadOrigen()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idActividad=$_POST["idActividad"];
		$anio=$_POST["anio"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 982_actividadesOrigen where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$x++;
		if($idActividad!="-1")
		{
			$consulta[$x]="insert into 982_actividadesOrigen(idFormulario,idReferencia,idActividad,anioActividad) 
							values(".$idFormulario.",".$idReferencia.",".$idActividad.",".$anio.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function asignarAutorResponsable()
	{
		global $con;
		$idAutor=$_POST["idAutor"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 246_autoresVSProyecto set responsable=0 where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$x++;
		$consulta[$x]="update 246_autoresVSProyecto set responsable=1 where id_246_autoresVSProyecto=".$idAutor;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionFicha()
	{
		global $con;
		$conf=$_POST["conf"];
		$idConf=$_POST["idConf"];
		$consulta="update 909_configuracionTablaFormularios set complementario='".$conf."' where idConfGrid=".$idConf;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerAccionesControl()
	{
		
		global $con;
		$idConexion=$_POST["idConexion"];
		$idControl=$_POST["idControl"];
		$consulta="select tipoElemento from 901_elementosFormulario where idGrupoElemento=".$idControl;
		$tipoElemento=$con->obtenerValor($consulta);
		$arrOpciones=array();
		switch($tipoElemento)
		{
			case "2":
			case "14":
			case "17":
				$consulta="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idControl." and idIdioma=".$_SESSION["leng"]." and valor in
							(select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl.")";
				$arrOpciones=$con->obtenerFilasArregloPHP($consulta);	
			break;
			case "3":
			case "15":
			case "18":
				$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
				$fila=$con->obtenerPrimeraFila($consulta);
				$inicio=$fila[2];
				$fin=$fila[3];
				$intervalo=$fila[4];
				$consulta="select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl;
				$arrValores=$con->obtenerFilasArregloPHP($consulta);
				
				for($x=$inicio;$x<$fin;$x+=$intervalo)
				{
					if(existeValor($arrValores,$x))
					{
						$obj=array();
						$obj[0]=$x;
						$obj[1]=$x;
						array_push($arrOpciones,$obj);
					}
				}
					
			break;
			case "4":
			case "16":
			case "19":
				$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
				$fila=$con->obtenerPrimeraFila($consulta);		
				$nTabla=$fila[2];
				$campo=$fila[3];
				$columnaID=$fila[4];
				if(strpos($nTabla,"[")===false)
				{
					$consulta="select ".$columnaID.",".$campo." from ".$nTabla." where ".$columnaID." in (select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl.")";
					$arrOpciones=$con->obtenerFilasArregloPHP($consulta);	
				}
				else
				{
					$nTabla=str_replace("]","",str_replace("[","",$nTabla));
					$query=bD($_POST["qy"]);
					$arrQuery= explode(" order ",$query);
					$query=$arrQuery[0];
					if($query!="")
					{
						$consulta="select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl;
						$listValores=$con->obtenerListaValores($consulta,"'");

						if(strpos($query," where ")===false)
							$query.=" where ".$columnaID."  in (".$listValores.")";
						else
							$query.=" and ".$columnaID."  in (".$listValores.")";
						if(isset($arrQuery[1]))
							$query.=' order '.$arrQuery[1];
						$conAux=$con;
						if($idConexion!=0)
							$conAux=generarInstanciaConector($idConexion);

						$resQuery=$conAux->obtenerFilas($query);
						$arrCamposProy=explode("@@",$campo);
						$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"3","imprimir":"0","campoID":"'.$columnaID.'"}';
						$obj=json_decode($cadObj);
						$obj->resQuery=$resQuery;
						$obj->idAlmacen=$nTabla;
						$obj->arrCamposProy=$arrCamposProy;
						$obj->conector=$con;

						$arrOpciones=generarFormatoOpcionesQuery($obj);
						
					}
				}
				
				
			break;
		}
		$consulta="select valorOpcion from 984_controlesVSValoresOpcion where valorOpcion=-100 and idElemFormulario=".$idControl;
		$valOpcion=$con->obtenerValor($consulta);
		if($valOpcion!="")
		{
			
			$opt[0]="-100";
			$opt[1]='Valor Default';
			array_push($arrOpciones,$opt);
		}
		$nOpciones=sizeof($arrOpciones);
		$arrNodos="";
		for($x=0;$x<$nOpciones;$x++)
		{
			$hijos=obtenerNodosHijosAccionesControl($idControl,$arrOpciones[$x][0]);
			
			$complementario="";
			if($hijos=="[]")
				$complementario="leaf:true,";
			else
				$complementario="leaf:false,children:".$hijos.",";
			
			$nodo="{
						id:'".$arrOpciones[$x][0]."',
						text:'".uEJ($arrOpciones[$x][1])."',
						draggable:false,".
						$complementario.
						"tipo:0,
						tipoControl:'',
						accion:'',
						uiProvider:\"col\",
						icon:'../images/bullet_green.png',
						allowDrop:false
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		echo "[".$arrNodos."]";
	}
	
	function obtenerNodosHijosAccionesControl($idElemFormulario,$valor)
	{
		global $con;
		$consulta="select idGrupoElemento,nombreCampo,
					(case tipoElemento 
					 	when -2 then 'Listado fichas asociadas'
					 	when 1 then 'Etiqueta' 
						when 2 then 'Combo (Selecci&oacute;n)' 
						when 3 then 'Combo (Selecci&oacute;n)'
						when 4 then 'Combo (Selecci&oacute;n)'
						when 5 then 'Texto corto'
						when 6 then 'N&uacute;mero entero'
						when 7 then 'N&uacute;mero decimal'
						when 8 then 'Grupo Fecha'
						when 9 then 'Texto Largo'
						when 10 then 'Texto Enriquecido'
						when 11	then 'Correo electr&oacute;nico'
						when 12	then 'Correo electr&oacute;nico'
						when 13	then 'Marco (Frame)'
						when 14	then 'Radios de selecci&oacute;n'
						when 15	then 'Radios de selecci&oacute;n'
						when 16	then 'Radios de selecci&oacute;n'
						when 17	then 'Checkbox de selecci&oacute;n'
						when 18	then 'Checkbox de selecci&oacute;n'
						when 19	then 'Checkbox de selecci&oacute;n'
						when 21	then 'Valor hora'
						when 22	then 'N&uacute;mero decimal'
						when 23	then 'Im&aacute;gen'
					 end
					) as tElemento 
					from  901_elementosFormulario where idGrupoElemento in (select idElemCtrlFormulario from 985_controlesAccionVSAcciones where idElemFormulario=".$idElemFormulario." and valor='".$valor."')";
		
		
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($filas=$con->fetchRow($res))
		{
			$consulta="select accion,idControlAccion from 985_controlesAccionVSAcciones where idElemFormulario=".$idElemFormulario." and valor='".$valor."' and idElemCtrlFormulario=".$filas[0];
			$filaAccion=$con->obtenerPrimeraFila($consulta);
			$cadAccion=$filaAccion[0];
			
			$accion="";
			if(strpos($cadAccion,"O")!==false)
				$accion="Ocultar";
			if(strpos($cadAccion,"M")!==false)
				$accion="Mostrar";
				
			if(strpos($cadAccion,"H")!==false)
			{
				if($accion=="")
					$accion="Habilitar";
				else
					$accion.=", Habilitar";
			}
			if(strpos($cadAccion,"D")!==false)
			{
				if($accion=="")
					$accion="Deshabilitar";
				else
					$accion.=", Deshabilitar";
			}
			$nodo="{
						id:'".$valor."_".$filas[0]."',
						idControl:'".$filaAccion[1]."',
						text:'".uEJ($filas[1])."',
						draggable:false,
						leaf:true,
						tipo:1,
						accion:'".$accion."',
						codAccion:'".$cadAccion."',
						tipoControl:'".$filas[2]."',
						icon:'../images/s.gif',
						uiProvider:\"col\",
						allowDrop:false
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerOpcionesControl()
	{
		global $con;
		$idConexion=$_POST["idConexion"];
		$idControl=$_POST["idControl"];
		$consulta="select tipoElemento from 901_elementosFormulario where idGrupoElemento=".$idControl;
		$tipoElemento=$con->obtenerValor($consulta);
		$arrOpciones="";
		switch($tipoElemento)
		{
			case "2":
			case "14":
			case "17":
				$consulta="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idControl." and idIdioma=".$_SESSION["leng"]." and valor not in
							(select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl.")";
				$arrOpciones=$con->obtenerFilasArreglo($consulta);	
			break;
			case "3":
			case "15":
			case "18":
				$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
				$fila=$con->obtenerPrimeraFila($consulta);
				$inicio=$fila[2];
				$fin=$fila[3];
				$intervalo=$fila[4];
				$consulta="select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl;
				$arrValores=$con->obtenerFilasArregloPHP($consulta);
				if($inicio<$fin)
				{
					for($x=$inicio;$x<=$fin;$x+=$intervalo)
					{
						if(!existeValor($arrValores,$x))
						{
							$obj="['".$x."','".$x."']";
							if($arrOpciones=="")
								$arrOpciones.=$obj;
							else
								$arrOpciones.=",".$obj;
						}
					}
				}
				else
				{
					for($x=$inicio;$x>=$fin;$x-=$intervalo)
					{
						if(!existeValor($arrValores,$x))
						{
							$obj="['".$x."','".$x."']";
							if($arrOpciones=="")
								$arrOpciones.=$obj;
							else
								$arrOpciones.=",".$obj;
						}
					}
				}
				$arrOpciones="[".$arrOpciones."]";				
			break;
			case "4":
			case "16":
			case "19":
				$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;

				$fila=$con->obtenerPrimeraFila($consulta);		
				$nTabla=$fila[2];
				$campo=$fila[3];
				$columnaID=$fila[4];
				if(strpos($nTabla,"[")===false)
				{
					$consulta="select ".$columnaID.",".$campo." from ".$nTabla." where ".$columnaID." not in (select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl.")";
					$arrOpciones=$con->obtenerFilasArreglo($consulta);	
				}
				else
				{
					$nTabla=str_replace("]","",str_replace("[","",$nTabla));
					$query=bD($_POST["qy"]);
					$arrQuery= explode(" order ",$query);
					$query=$arrQuery[0];
					
					$consulta="select valorOpcion from 984_controlesVSValoresOpcion where idElemFormulario=".$idControl;
					$listValores=$con->obtenerListaValores($consulta,"'");
					if($listValores=="")
						$listValores=-1;
					if(strpos($query," where ")===false)
						$query.=" where ".$columnaID." not in (".$listValores.")";
					else
						$query.=" and ".$columnaID." not in (".$listValores.")";
					if(isset($arrQuery[1]))
					{
						$query.=" order ".$arrQuery[1];
					}
					$conAux=$con;
					if($idConexion!=0)
						$conAux=generarInstanciaConector($idConexion);
					$resQuery=$conAux->obtenerFilas($query);
					$arrCamposProy=explode("@@",$campo);
					$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"1","imprimir":"0","campoID":"'.$columnaID.'"}';
					$obj=json_decode($cadObj);
					$obj->resQuery=$resQuery;
					$obj->idAlmacen=$nTabla;
					$obj->arrCamposProy=$arrCamposProy;
					$obj->conector=$con;
					$arrOpciones="[".generarFormatoOpcionesQuery($obj)."]";
				}
				
				
			break;
		}
		$consulta="select valorOpcion from 984_controlesVSValoresOpcion where valorOpcion=-100 and idElemFormulario=".$idControl;
		$valOpcion=$con->obtenerValor($consulta);
		if($valOpcion=="")
		{
			$subArr=substr($arrOpciones,0,strlen($arrOpciones)-1);
			if($subArr!="[")
				$arrOpciones=$subArr.=",['-100','Valor Default']]";
			else
				$arrOpciones=$subArr.="['-100','Valor Default']]";
		}
		echo "1|".uEJ($arrOpciones);
	}
	
	function guardarOpcionesEvento()
	{
		global $con;
		$listaOpciones=$_POST["lOpciones"];
		$idControl=$_POST["idControl"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrValores=explode(",",bD($listaOpciones));
		
		$nArrValores=sizeof($arrValores);
		for($p=0;$p<$nArrValores;$p++)
		{
			$consulta[$x]="insert into 984_controlesVSValoresOpcion(idElemFormulario,valorOpcion) values(".$idControl.",'".$arrValores[$p]."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerControlesAccion()
	{
		global $con;
		$idControl=$_POST["idControl"];
		$valorOpt=$_POST["valorOpt"];
		$idFormulario=$_POST["idFormulario"];
		
		$consulta="select idGrupoElemento,nombreCampo,
					(case tipoElemento 
					 	when -2 then 'Listado fichas asociadas'
					 	when 1 then 'Etiqueta' 
						when 2 then 'Combo (Selecci&oacute;n)' 
						when 3 then 'Combo (Selecci&oacute;n)'
						when 4 then 'Combo (Selecci&oacute;n)'
						when 5 then 'Texto corto'
						when 6 then 'N&uacute;mero entero'
						when 7 then 'N&uacute;mero decimal'
						when 8 then 'Grupo Fecha'
						when 9 then 'Texto Largo'
						when 10 then 'Texto Enriquecido'
						when 11	then 'Correo electr&oacute;nico'
						when 12	then 'Correo electr&oacute;nico'
						when 13	then 'Marco (Frame)'
						when 14	then 'Radios de selecci&oacute;n'
						when 15	then 'Radios de selecci&oacute;n'
						when 16	then 'Radios de selecci&oacute;n'
						when 17	then 'Checkbox de selecci&oacute;n'
						when 18	then 'Checkbox de selecci&oacute;n'
						when 19	then 'Checkbox de selecci&oacute;n'
						when 21	then 'Valor hora'
						when 22	then 'N&uacute;mero decimal'
						when 23	then 'Im&aacute;gen'
					 end
					) as tElemento 
					from  901_elementosFormulario where idFormulario=".$idFormulario." and
					tipoElemento not in(-1,0,20,-2) and idGrupoElemento<>".$idControl." and idGrupoElemento not in
					(select idElemCtrlFormulario from 985_controlesAccionVSAcciones where idElemFormulario=".$idControl." and valor='".$valorOpt."')";
		$arrElementos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElementos);
	}
	
	function guardarAccionesControl()
	{
		global $con;
		$lControles=$_POST["lControles"];
		$listaAccion=$_POST["listaAccion"];
		$idControl=$_POST["idControl"];
		$valorOpt=bD($_POST["valorOpt"]);
		
		$arrControles=explode(",",($lControles));
		$nControles=sizeof($arrControles);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($p=0;$p<$nControles;$p++)
		{
			$consulta[$x]="insert into 985_controlesAccionVSAcciones(idElemFormulario,valor,idElemCtrlFormulario,accion) values(".$idControl.",'".$valorOpt."',".$arrControles[$p].",'".$listaAccion."')";
			
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarAccionesControl()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$listaAccion=$_POST["listaAccion"];
		$consulta="update 985_controlesAccionVSAcciones set accion='".$listaAccion."' where idControlAccion=".$idAccion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarElementoAccionControl()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idElemento=$_POST["idElemento"];
		$idControl=$_POST["idControl"];
		$x=0;
		if($tipo=="1")
		{
			$consulta[$x]="delete from 985_controlesAccionVSAcciones where idControlAccion=".$idElemento;
			$x++;
		}
		else
		{
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="delete from 984_controlesVSValoresOpcion where valorOpcion='".$idElemento."' and idElemFormulario=".$idControl;
			$x++;
			$consulta[$x]="delete from 985_controlesAccionVSAcciones where valor='".$idElemento."' and idElemFormulario=".$idControl;
			$x++;
			$consulta[$x]="commit";
			$x++;
			
		}
		if($con->ejecutarBloque($consulta))
				echo "1|";
			else
				echo "|";
	}
	
	function obtenerElementosConvocatoria()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select ep.idElementoConvocatoria,p.nombre,ep.idElemento,ep.idConfiguracion,p.idProceso from 9001_elementosProceso ep,4001_procesos p where p.idProceso=ep.idElemento and ep.idProceso=".$idProceso." order by p.nombre";
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$arrHijos="[]";
			$idConfElemento=$fila[3];
			$compTxt='';
			$nNodosOrden="";
			if($idConfElemento!="")
			{
				$arrHijos=obtenerControlesConvocatoria($fila[3],$nNodosOrden);
			}
			else
			{
				$compTxt="&nbsp;&nbsp;<img src=\"../images/warning.png\" title=\"Sin configurar\" alt=\"Sin configurar\" >";
				$idConfElemento="0";
			}
			if($arrHijos!="[]")
				$comp="leaf:false,children:".$arrHijos;
			else
				$comp="leaf:true";	
			if($nNodosOrden=="")	
				$nNodosOrden=0;
			$nodo="{
						id:'".$fila[0]."',
						text:'".uEJ($fila[1]).$compTxt."',
						icon:'../images/bullet_green.png',
						idConf:'".$idConfElemento."',
						draggable:false,".$comp.",
						allowDrop:false,
						idProcesoRef:".$fila[4].",
						tipo:'0',
						nNodosOrden:'".$nNodosOrden."'
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		echo "[".$arrNodos."]";
	}
	
	function obtenerControlesConvocatoria($idConf,&$nodosOrden)
	{
		global $con;
		$consulta="select * from 9002_confElementoConvocatoria where idConfElemento=".$idConf;
		$filaConf=$con->obtenerPrimeraFila($consulta);
		$idCtrlTipo=$filaConf[3];
		$idCtrlEstado=$filaConf[5];
		$idCtrlAnio=$filaConf[4];
		$conPerfilParticipacion=$filaConf[6];
		$idNivel=$filaConf["8"];
		$arrConf=array();
		$nNodosOrden=0;
		if($idCtrlTipo!='-1')
		{
			$valorArray=array();
			array_push($valorArray,$idCtrlTipo);
			array_push($valorArray,"Campo Clasificaci&oacute;n 1");
			array_push($valorArray,"1");
			array_push($arrConf,$valorArray);
		}
		if($idCtrlEstado!='-1')
		{
			$valorArray=array();
			array_push($valorArray,$idCtrlEstado);
			array_push($valorArray,"Campo Clasificaci&oacute;n 2");
			array_push($valorArray,"2");
			array_push($arrConf,$valorArray);
		}
		if($idCtrlAnio!='-1')
		{
			$valorArray=array();
			array_push($valorArray,$idCtrlAnio);
			array_push($valorArray,"Campo A&ntilde;o");
			array_push($valorArray,"5");
			array_push($arrConf,$valorArray);
		}
		
		$nConf=sizeof($arrConf);
		$arrNodos="";
		for($x=0;$x<$nConf;$x++)
		{
			$consulta="select nombreCampo
						from  901_elementosFormulario where idGrupoElemento=".$arrConf[$x][0]." and idIdioma=".$_SESSION["leng"];
			$nCampo=$con->obtenerValor($consulta);
			$comp="";
			$nOrden="";
			if($arrConf[$x][2]!=5)
			{
				
				$consulta="SELECT orden FROM 9003_configuracionOrdenElemento WHERE idConf=".$idConf." AND tElemento=".$arrConf[$x][2];
				$nOrden=$con->obtenerValor($consulta);
				$comp="<span class=\'copyrightSinPadding\'>Orden: ".$nOrden."</span>";
				$nNodosOrden++;
			}
			$nodo="{
						id:'".$arrConf[$x][0]."',
						text:'".$nCampo." (<b>".$arrConf[$x][1]."</b>) ".$comp."',
						draggable:false,
						leaf:true,
						icon:'../images/s.gif',
						allowDrop:false,
						tipo:'1',idConf:'".$idConf."',orden:'".$nOrden."',
						tValor:'".$arrConf[$x][2]."'
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		if($conPerfilParticipacion!='0')
		{
			if($conPerfilParticipacion==0)
				$perfil="No considerar participaci&oacute;n";
			else
				$perfil="Considerar participaci&oacute;n";
			$nOrden="";
			$consulta="SELECT orden FROM 9003_configuracionOrdenElemento WHERE idConf=".$idConf." AND tElemento=3";
			$nOrden=$con->obtenerValor($consulta);
			$nNodosOrden++;
			$nodo="{
						id:'".$idConf."_0',
						text:'".$perfil." <span class=\'copyrightSinPadding\'>Orden: ".$nOrden."</span>',
						draggable:false,
						leaf:true,
						icon:'../images/s.gif',
						allowDrop:false,
						tipo:'1',idConf:'".$idConf."',orden:'".$nOrden."',
						tValor:'3'
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		
		if($idNivel!='0')
		{
			$nOrden="";
			$consulta="SELECT orden FROM 9003_configuracionOrdenElemento WHERE idConf=".$idConf." AND tElemento=4";
			$nOrden=$con->obtenerValor($consulta);
			$nNodosOrden++;
			$perfil="Considerar nivel del investigador";
			$nodo="{
						id:'".$idConf."_1',
						text:'".$perfil." <span class=\'copyrightSinPadding\'>Orden: ".$nOrden."</span>',
						draggable:false,
						leaf:true,
						icon:'../images/s.gif',
						allowDrop:false,
						tipo:'1',idConf:'".$idConf."',orden:'".$nOrden."',
						tValor:'4'
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		$nodosOrden=$nNodosOrden;
		return "[".$arrNodos."]";
		
		
	}
	
	function guardarConfiguracionConv()
	{
		global $con;
		$datos=$_POST["datos"];
		$objDatos=json_decode($datos);
		$idProceso=$_POST["idProceso"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 4001_procesos set situacion=".$objDatos->situacion." where idProceso=".$idProceso;
		$x++;
		$consulta[$x]="delete from 9000_procesoConvocatorias where idProceso=".$idProceso;
		$x++;
		$consulta[$x]="insert into 9000_procesoConvocatorias(tipoProceso,invCalificado,invNoCalificado,mandoMedioCalificado,mandoMedioNoCalificado,
						otroCalificado,otroNoCalificado,idProceso,consideraNivelInv) 
						values (".$objDatos->tipoProceso.",".$objDatos->chkPIC.",".$objDatos->chkPINC.",".$objDatos->chkMMC.",".$objDatos->chkMMNC.",
								".$objDatos->chkOPC.",".$objDatos->chkOPNC.",".$idProceso.",".$objDatos->chkConsideraNivel.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerElementosProceso()
	{
		global $con;
		$idTipoProceso=$_POST["idTipoProceso"];
		$idProceso=$_POST["idProceso"];
		$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$idTipoProceso." and idProceso not in (select idElemento from 9001_elementosProceso where idProceso=".$idProceso.") order by nombre";
		$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrProcesos;
	}
	
	function guardarElementosProceso()
	{
		global $con;
		$cadElementos=$_POST['cadElementos'];
		$idProceso=$_POST['idProceso'];
		$arrElementos=explode(",",$cadElementos);
		$nElementos=sizeof($arrElementos);
		$pos=0;
		$consulta[$pos]="begin";
		$pos++;
		for($x=0;$x<$nElementos;$x++)
		{
			$consulta[$pos]="insert into 9001_elementosProceso(idProceso,idElemento) values(".$idProceso.",".$arrElementos[$x].")";
			$pos++;
		}
		$consulta[$pos]="commit";
		$pos++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarElemento()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$consulta="delete from 9001_elementosProceso where idElementoConvocatoria=".$idElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
			
	}
	
	function obtenerCamposConf()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$consulta="select * from 9001_elementosProceso where idElementoConvocatoria=".$idElemento;
		$fila=$con->obtenerPrimeraFila($consulta);
		$idProceso=$fila[2];
		$idFormulario=obtenerFormularioBase($idProceso);
		$consulta="select idGrupoElemento,concat(nombreCampo,' (',
					(case tipoElemento 
					 	
					 	when 1 then 'Etiqueta' 
						when 2 then 'Combo' 
						when 3 then 'Combo'
						when 4 then 'Combo'
						when 5 then 'Texto corto'
						when 6 then 'No. entero'
						when 7 then 'No. decimal'
						when 8 then 'Grupo Fecha'
						when 9 then 'Texto Largo'
						when 10 then 'Texto Enriquecido'
						when 13	then 'Marco (Frame)'
						when 14	then 'Radio'
						when 15	then 'Radio'
						when 16	then 'Radio'
						when 17	then 'Checkbox'
						when 18	then 'Checkbox'
						when 19	then 'Checkbox'
						when 21	then 'Valor hora'
						when 22	then 'No. decimal'
						when 24 then 'Moneda'
						
					 end
					) ,')') 
					from  901_elementosFormulario where idFormulario=".$idFormulario." and
					tipoElemento  in(2,3,4,14,15,16,17,18,19,24,5,6,7,8,9)";
		
		$arrTipoEstado=$con->obtenerFilasArreglo($consulta);
		if($arrTipoEstado!="[]")
			$arrTipoEstado="[['-1','No considerar'],".substr($arrTipoEstado,1);
		else
			$arrTipoEstado="[['-1','No considerar']]";
		$consulta="select idGrupoElemento,concat(nombreCampo,' (',
					(case tipoElemento 
					 	when -2 then 'Listado fichas asociadas'
					 	when 1 then 'Etiqueta' 
						when 2 then 'Combo' 
						when 3 then 'Combo'
						when 4 then 'Combo'
						when 5 then 'Texto corto'
						when 6 then 'No. entero'
						when 7 then 'No. decimal'
						when 8 then 'Grupo Fecha'
						when 9 then 'Texto Largo'
						when 10 then 'Texto Enriquecido'
						when 13	then 'Marco (Frame)'
						when 14	then 'Radio'
						when 15	then 'Radio'
						when 16	then 'Radio'
						when 17	then 'Checkbox'
						when 18	then 'Checkbox'
						when 19	then 'Checkbox'
						when 21	then 'Valor hora'
						when 22	then 'No. decimal'
						when 24 then 'Moneda'
						
					 end
					),')')
					from  901_elementosFormulario where idFormulario=".$idFormulario." and
					tipoElemento  in(2,3,4,14,15,16,17,18,19,5,6,7,8,9)";
		
		$idFrmAutores=incluyeModulo($idProceso,3);
		
		if($idFrmAutores=="-1")
		{
			$idPerfil=0;
			$modAut=0;
		}
		else
		{
			$query="select complementario from 203_elementosDTD where idFormulario=".$idFrmAutores;
			$valPerfil=$con->obtenerValor($query);
			$arrComp=explode(",",$valPerfil);
			$idPerfil=$arrComp[0];
			$modAut=1;
		}
		$arrAnio=$con->obtenerFilasArreglo($consulta);
		if($arrAnio!="[]")
			$arrAnio="[['-1','No considerar'],".substr($arrAnio,1);
		else
			$arrAnio="[['-1','No considerar']]";
		if($fila[3]=="")
			$comp="|".$modAut."|-1|-1|-1|0|".$idPerfil;
		else
		{
			$consulta="select * from 9002_confElementoConvocatoria where idConfElemento=".$fila[3];
			$filaConf=$con->obtenerPrimeraFila($consulta);
			$comp="|".$modAut."|".$filaConf[3]."|".$filaConf[5]."|".$filaConf[4]."|".$filaConf[6]."|".$filaConf[7]."|".$filaConf[8];
		}
		echo "1|".uEJ($arrTipoEstado)."|".uEJ($arrAnio).$comp;
	}
	
	function guardarConfiguracionElemento()
	{
		global $con;
		$datos=$_POST["obj"];
		$objDatos=json_decode($datos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($objDatos->idConf==0)
		{
			$query="insert into 9002_confElementoConvocatoria(idProcesoRef,idProceso,idCtrlTipo,idCtrlAnio,idCtrlEstado,conPerfilParticipacion,idPerfil,nivelInvestigador)
							values(".$objDatos->idProcesoRef.",".$objDatos->idProceso.",".$objDatos->tipo.",".$objDatos->anio.",".$objDatos->estado.",".$objDatos->participacion.",".$objDatos->idPerfil.",".$objDatos->nivelInvestigador.")";
			if(!$con->ejecutarConsulta($query))
			{
				echo "|";
				return;
			}
			$idConf=$con->obtenerUltimoID();
			$consulta[$x]="update 9001_elementosProceso set idConfiguracion=".$idConf." where idElementoConvocatoria=".$objDatos->idElementoConvocatoria;
			$x++;
		}
		else
		{
			$consulta[$x]="update 9002_confElementoConvocatoria set idCtrlTipo=".$objDatos->tipo.",idCtrlAnio=".$objDatos->anio.",idCtrlEstado=".$objDatos->estado.",
							conPerfilParticipacion=".$objDatos->participacion.",idPerfil=".$objDatos->idPerfil.",nivelInvestigador=".$objDatos->nivelInvestigador." where idConfElemento=".$objDatos->idConf;
			$x++;
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarValorConfConvocatoria()
	{
		global $con;
		
		$obj=$_POST["obj"];
		$objDatos=json_decode($obj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$padre=$objDatos->padre;
		foreach($objDatos->elementos as $e)
		{
			$consulta[$x]="insert into 9003_elementosConfConvocatoria(padre,idElemento,tipoElemento,complementario) values('".$padre."','".$e->idElemento."',".$e->tipo.",'".$e->compl."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerValoresElementosPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		
		
		$consulta="select idElementoPerfilAutor,descParticipacion from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idPerfil;
		$arrAutor=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrAutor;
	}
	
	function marcarLineaInvestigacionPrincipal()
	{
		global $con;
		$idLinea=$_POST["idLinea"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 240_proyectosVSLineasInvestigacion set lineaPrincipal=0 where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$x++;
		$consulta[$x]="update 240_proyectosVSLineasInvestigacion set lineaPrincipal=1 where id_240_proyectosVSLineasInvestigacion=".$idLinea;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerDiaLaboral()
	{
		global $con;
		$idDias=$_POST["idDias"];
		$consulta="delete from 979_horariosLaborUsuario where idHorarioLaboralUsuario in (".$idDias.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
		echo "|";
		
	}
	
	function actualizarHora()
	{
		global $con;
		$idDia=$_POST["idDia"];
		$campoMod=$_POST["campoMod"];
		$hora=$_POST["hora"];
		
		
		
		if($campoMod=="1")
		{
			$query="select  horaFin from 979_horariosLaborUsuario where idHorarioLaboralUsuario=".$idDia;
			$hFin=$con->obtenerValor($query);
			$hI=($hora);	
			$hF=($hFin);	
			$difHora=restaHoras($hI,$hF);
			$horasLab=date("H",$difHora);
			$minLab=date("i",$difHora);
			$consulta="update 979_horariosLaborUsuario set horaInicio='".$hora."',horasLaborales=".$horasLab.",minutosLaborales=".$minLab." where idHorarioLaboralUsuario=".$idDia;
			
		}
		else
		{
			$query="select  horaInicio from 979_horariosLaborUsuario where idHorarioLaboralUsuario=".$idDia;
			$hInicio=$con->obtenerValor($query);
			$hI=($hInicio);	
			$hF=($hora);	
			$difHora=restaHoras($hI,$hF);
			$horasLab=date("H",$difHora);
			$minLab=date("i",$difHora);
			$consulta="update 979_horariosLaborUsuario set horaFin='".$hora."',horasLaborales=".$horasLab.",minutosLaborales=".$minLab."  where idHorarioLaboralUsuario=".$idDia;
		}
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarPeriodoConvocatoria()
	{
		global $con;
		$fechaI=$_POST["fechaI"];
		$fechaF=$_POST["fechaF"];
		$idProceso=$_POST["idProceso"];
		$consulta="update 9000_procesoConvocatorias set fechaInicio='".$fechaI."',fechaFin='".$fechaF."' where idProceso=".$idProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
		
	}
	
	function guardarValorElementoConvocatoria()
	{
		global $con;
		$idValor=$_POST["idValor"];
		$valor=$_POST["valor"];
		$consulta="select idValorElementoC from 9006_valorElementosConvocatoria where idElemento='".$idValor."'";
		$idValorElementoC=$con->obtenerValor($consulta);
		if($idValorElementoC=="")
			$consulta="insert into 9006_valorElementosConvocatoria(idElemento,valor) values('".cv($idValor)."','".cv($valor)."')";
		else
			$consulta="update 9006_valorElementosConvocatoria set valor='".cv($valor)."' where idElemento='".cv($idValor)."'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarNivelesInvestigadorConv()
	{
		global $con;
		$situacion=$_POST["situacion"];
		$niveles=$_POST["niveles"];
		$padre=$_POST["padre"];
		
		$arrSituacion=explode(',',$situacion);
		$nSituacion=sizeof($arrSituacion);
		$arrNiveles=explode(",",$niveles);
		$nNiveles=sizeof($arrNiveles);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($y=0;$y<$nNiveles;$y++)
		{
			for($z=0;$z<$nSituacion;$z++)
			{
				$idElemento=$padre."_inv_".$arrNiveles[$y]."_".$arrSituacion[$z];
				$query="select idValorElementoC from 9006_valorElementosConvocatoria where idElemento='".$idElemento."'";
				$iE=$con->obtenerValor($query);
				if($iE=="")
				{
					$comp=$arrNiveles[$y]."_".$arrSituacion[$z];
					$consulta[$x]="insert into 9006_valorElementosConvocatoria(idElemento,valor,complementario) values('".$idElemento."','0','".$comp."')";
					$x++;
				}
			}
		}
		
				
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";

		
	}
	
	function guardarPrefijoProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$valor=$_POST["valor"];
		$accion=$_POST["accion"];
		switch($accion)
		{
			case "1":
				$campo="prefijo";
			break;
			case "2":
				$campo="separador";
			break;
		}
		$consulta="update 4001_procesos set ".$campo."='".$valor."' where idProceso=".$idProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarCC()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$centros=$_POST["centros"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrCentros=explode(",",$centros);
		$nCentros=sizeof($arrCentros);
		
		for($y=0;$y<$nCentros;$y++)
		{
			$consulta[$x]="insert into 986_vinculacionCC(idFormulario,idReferencia,centroCosto) values(".$idFormulario.",".$idRegistro.",'".$arrCentros[$y]."')";
			$x++;
		
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarCCProyecto()
	{
		global $con;
		$idCentro=$_POST["idCentro"];
		$consulta="delete from 986_vinculacionCC where id_986_vinculacionCC=".$idCentro;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	
	function obtenerCamposLitaDisponibles()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProceso." and idEtapa<=".$numEtapa;
		$listaFrm=$con->obtenerListaValores($consulta);
		if($listaFrm=="")
			$listaFrm="-1";
		$consulta="select ef.idGrupoElemento,ef.nombreCampo,f.nombreFormulario from 901_elementosFormulario ef,900_formularios f where 
					f.idFormulario=ef.idFormulario and ef.idFormulario in (".$listaFrm.") and ef.tipoElemento in (6,7,22,24) and ef.idGrupoElemento
					not in(select idControl from 518_camposEtapa where idProceso=".$idProceso." and numEtapa=".$numEtapa.") ";
		$arrCampos=$con->obtenerFilasArreglo($consulta);		
		echo "1|".uEJ($arrCampos);
	}
	
	function guardarCamposLita()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$cadCampos=$_POST["cadCampos"];
		$arrCampos=explode(",",$cadCampos);
		$nCampos=sizeof($arrCampos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($y=0;$y<$nCampos;$y++)
		{
			$consulta[$x]="insert into 518_camposEtapa(idControl,numEtapa,idProceso) values(".$arrCampos[$y].",".$numEtapa.",".$idProceso.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarCuentasEscenario()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$cadCuentas=$_POST["cadCuentas"];
		$idCampo=$_POST["idCampo"];
		$arrCuentas=explode(",",$cadCuentas);
		$nCuentas=sizeof($arrCuentas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($tipo==1)
		{
			for($pos=0;$pos<$nCuentas;$pos++)
			{
				$arrDatosCta=explode("|",$arrCuentas[$pos]);
				$consulta[$x]="insert into 519_camposCuentaAfectacion(idCampoEtapa,codCuentaAfectacion,codCuentaAfectacionSimple,porcentaje) 
								values(".$idCampo.",'".$arrDatosCta[0]."','".$arrDatosCta[1]."',0)" ;
				$x++;
			}
		}
		else
		{
			for($pos=0;$pos<$nCuentas;$pos++)
			{
				$arrDatosCta=explode("|",$arrCuentas[$pos]);
				$consulta[$x]="insert into 520_CamposCuentaContrapartida(idCampoCuentaAfectacion,codCuentaContrapartida,codCuentaContrapartidaSimple,porcentaje) 
								values(".$idCampo.",'".$arrDatosCta[0]."','".$arrDatosCta[1]."',0)" ;
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";

	}
	
	function actualizarPorcentajeCuenta()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$id=$_POST["id"];
		$valor=$_POST["valor"];
		if($tipo==1)
			$consulta="update 519_camposCuentaAfectacion set porcentaje=".$valor." where idCampoCuentaAfectacion=".$id;
		else	
			$consulta="update 520_CamposCuentaContrapartida set porcentaje=".$valor." where idCampoCuentaContrapartida=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerRolModulo()
	{
		global $con;
		$rol=base64_decode($_POST["r"]);
		$idModulo=base64_decode($_POST["iM"]);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 978_rolesVSModulos where rol='".$rol."' and idModulo=".$idModulo;
		$x++;
		$consulta[$x]="delete from 977_rolesVSPermisosModulo where rol='".$rol."' and idModulo=".$idModulo;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerProcesosClonar()
	{
		global $con;
		$tP=$_POST["tP"];
		$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$tP." order by nombre";
		$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrProcesos;
	}
	
	function obtenerFormulariosClonar()
	{
		global $con;
		$proc=$_POST["proc"];
		$consulta="select idFormulario,nombreFormulario,descripcion from 900_formularios where idProceso=".$proc." and tipoFormulario=0 order by nombreFormulario";
		$arrFrm=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrFrm;
	}
	
	function clonarFormularios()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idProceso=$obj->idProceso;
		$idFormularios=$obj->idFormularios;
		$arrFormulario=explode(",",$idFormulario);
		$nFormularios=sizeof($arrFormulario);
		for($pos=0;$pos<$nFormularios;$pos++)
		{
			
		}
	}
	
	function crearCuentaBancoProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="insert into 711_cuentasBanco(idFormulario,idReferencia,depositoM6,retiroM6,depositoM5,retiroM5,depositoM4,retiroM4,depositoM3,retiroM3,depositoM2,retiroM2,depositoM1,retiroM1) 
										values(".$idFormulario.",".$idReferencia.",0,0,0,0,0,0,0,0,0,0,0,0)";
		if($con->ejecutarConsulta($consulta))
			echo "1|".$con->obtenerUltimoID();
		else	
			echo "|";
	}
	
	function actualizarCuenta()
	{
		global $con;
		$columna=$_POST["columna"];
		$idCuenta=$_POST["idCuenta"];
		$valor=$_POST["valor"];
		$nCol="";
		switch($columna)
		{
			case "1":
				$nCol="cuenta";
			break;
			case "2":
				$nCol="idBanco";
			break;
			case "3":
				$nCol="idPersonaFisica";
			break;
			case "4":
				$nCol="idEmpresa";
			break;
			case "5":
				$nCol="depositoM6";
				if($valor=="")
					$valor="0";
			break;
			case "6":
				$nCol="retiroM6";
				if($valor=="")
					$valor="0";
			break;
			case "7":
				$nCol="depositoM5";
				if($valor=="")
					$valor="0";
			break;
			case "8":
				$nCol="retiroM5";
				if($valor=="")
					$valor="0";
			break;
			case "9":
				$nCol="depositoM4";
				if($valor=="")
					$valor="0";
			break;
			case "10":
				$nCol="retiroM2";
				if($valor=="")
					$valor="0";
			break;
			case "11":
				$nCol="depositoM3";
				if($valor=="")
					$valor="0";
			break;
			case 12:
				$nCol="retiroM3";
				if($valor=="")
					$valor="0";
			break;
			case 13:
				$nCol="depositoM2";
				if($valor=="")
					$valor="0";
			break;
			case 14:
				$nCol="retiroM2";
				if($valor=="")
					$valor="0";
			break;
			case 15:
				$nCol="depositoM1";
				if($valor=="")
					$valor="0";
			break;
			case 16:
				$nCol="retiroM1";
				if($valor=="")
					$valor="0";
			break;
			case 17:
				$nCol="antiguedad";
			break;
		}
		$consulta="update 711_cuentasBanco set ".$nCol."='".$valor."' where id_711_cuentasBanco=".$idCuenta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
		
	function obtenerBancos()
	{
		global $con;
		$condWhere="";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select idBanco, nombreBan , descripcion  from 600_bancos where 
					 ".$condWhere." order by nombreBan";
		
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrObj).'}';
	}
	
	function obtenerPersonas()
	{
		global $con;
		$condWhere="";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select idCliente, nombre   from 700_vclientes where 
					 ".$condWhere." order by nombre";
		
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrObj).'}';
	}
	
	function obtenerEmpresas()
	{
		global $con;
		$condWhere="";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select idEmpresa, empresa   from 700_empresas where 
					 ".$condWhere." order by empresa";
		
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrObj).'}';
	}
	
	function removerCuenta()
	{
		global $con;
		$idCuenta=$_POST["idCuenta"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 713_saldosCuentasBanco where id_713_saldoCuentasBanco=".$idCuenta;
		$x++;
		$consulta[$x]="delete from 714_depositosCuentasBanco where idCuentaRef=".$idCuenta;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionProcesoPOA()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		if($obj->idEsquema!=0)
			$esquema=$obj->idEsquema;
		else
			$esquema="esquemaPlaneacion";
		$consulta="select * from 4001_configuracionProcesoPOA where idProceso=".$obj->idProceso;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$consulta="update 4001_configuracionProcesoPOA set topePresupuestal='".$obj->idTope."',margenCrecimiento='".$obj->margenCre."',esquemaPlaneacion=".$esquema.",tipoPresupuesto=".$obj->tipoPresupuesto." where idProceso=".$obj->idProceso;
		}
		else
		{
			$consulta="insert into  4001_configuracionProcesoPOA (topePresupuestal,margenCrecimiento,esquemaPlaneacion,idProceso,tipoPresupuesto) values
						('".$obj->idTope."','".$obj->margenCre."',".$esquema.",".$obj->idProceso.",".$obj->tipoPresupuesto.")";
		}
		
		if($con->ejecutarConsulta($consulta))					
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionProcesoCompra()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		if($obj->idEsquema!=0)
			$esquema=$obj->idEsquema;
		else
			$esquema="esquemaPlaneacion";
		$consulta="select * from 4001_configuracionProcesoPOA where idProceso=".$obj->idProceso;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$consulta="update 4001_configuracionProcesoPOA set esquemaPlaneacion=".$esquema.",tipoPresupuesto=".$obj->tipoPresupuesto." where idProceso=".$obj->idProceso;
		}
		else
		{
			$consulta="insert into  4001_configuracionProcesoPOA (esquemaPlaneacion,idProceso,tipoPresupuesto) values
						(".$esquema.",".$obj->idProceso.",".$obj->tipoPresupuesto.")";
		}
		
		if($con->ejecutarConsulta($consulta))					
			echo "1|";
		else
			echo "|";
	}
	
	function guardarCuentaLitaPOA()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$cadCuentas=$_POST["cadCuentas"];
		$tAfectacion=$_POST["tAfectacion"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrCuentas=explode(",",$cadCuentas);
		foreach($arrCuentas as $cuenta)
		{
			$datosCta=explode("|",$cuenta);
			$consulta[$x]="insert into 522_afectacionCuentasPOA(idProceso,numEtapa,cuenta,idCuenta,tipoAfectacion) values(".$idProceso.",".$numEtapa.",'".$datosCta[1]."',".$datosCta[0].",".$tAfectacion.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarPorcentajeCta()
	{
		global $con;
		$idCta=$_POST["id"];
		$ponderacion=$_POST["valor"];
		$consulta="update 522_afectacionCuentasPOA set porcAfectacion=".$ponderacion." where idAfectacionCuenta=".$idCta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarTipoAfectacionCta()
	{
		global $con;
		$idCta=$_POST["id"];
		$ponderacion=$_POST["valor"];
		$consulta="update 522_afectacionCuentasPOA set tipoAfectacion=".$ponderacion." where idAfectacionCuenta=".$idCta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerCuentaLita()
	{
		global $con;
		$idCta=$_POST["id"];
		$consulta="delete from 522_afectacionCuentasPOA where idAfectacionCuenta=".$idCta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}

	function obtenerProgramas()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="select idPrograma,nombrePrograma from 4004_programa where ciclo=".$ciclo." order by nombrePrograma";
		echo "1|".uEJ($con->obtenerFilasArreglo($consulta));
	}
	
	function guardarParametrosReporte()
	{
		global $con;
		$procesos=$_POST["procesos"];
		$programas=$_POST["programas"];
		$roles=$_POST["roles"];
		$nConf=$_POST["nConf"];
		$descripcion=$_POST["descripcion"];
		
		$query="insert into 987_configuracionReporte(nombreConf,descripcion,idUsuario) values('".cv($nConf)."','".cv($descripcion)."',".$_SESSION["idUsr"].")";
		if($con->ejecutarConsulta($query))
		{
			$idConfiguracion=$con->obtenerUltimoID();
			$x=0;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($procesos)."',1)";
			$x++;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($programas)."',2)";
			$x++;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($roles)."',3)";
			$x++;
			if($con->ejecutarBloque($consulta))
				echo "1|";
			else
				echo "|";
		}
		else
			echo "|";
			
	}
	
	function removerConfiguracion()
	{
		global $con;
		$x=0;
		$idConf=base64_decode($_POST["idConf"]);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 987_configuracionReporte where idConfiguracion=".$idConf;
		$x++;
		$consulta[$x]="delete from 988_parametrosConfReporte where idConfiguracion=".$idConf;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionPerfilGrafUsr()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 989_configuracionGrafPerfilUsuario";
		$x++;
		$consulta[$x]="insert into 989_configuracionGrafPerfilUsuario(distribucionTC,distribucionTCD,lineasInvP,lineasInvS) values
						('".$obj->distribucionTC."','".$obj->distribucionTCD."','".$obj->lineasInvP."','".$obj->lineasInvS."')";
		$x++;
		$consulta[$x]="commit";
		$x++; 
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerActoresRegistroDisponible()
	{
		global $con;
		$roles=base64_decode($_POST["roles"]);
		$idProceso=base64_decode($_POST["idProceso"]);
		$consulta="select idActorVSAccionesProceso,actor from 949_actoresVSAccionesProceso where idProceso=".$idProceso." and idAccion=8 and actor in(".$roles.")";
		$resActores=$con->obtenerFilas($consulta);
		$arrActores="";
		while($filaActor=$con->fetchRow($resActores))
		{
			$obj="['".$filaActor[0]."','".obtenerTituloRol($filaActor[1])."']";
			if($arrActores=="")
				$arrActores.=$obj;
			else
				$arrActores.=",".$obj;
		}
		echo "1|[".uEJ($arrActores)."]";
		
	}
	
	function guardarConfFolio()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		if($obj->idFolio=="-1")
		{
			$consulta="select idFolio from 4001_foliosRegistros where idFormulario=".$obj->idFormulario;
			$con->obtenerFilas($consulta);
			
			if($con->filasAfectadas>0)
				$activo="0";
			else
				$activo="1";
			
			$consulta="insert into 4001_foliosRegistros(prefijo,separador,longitud,incremento,inicio,numActual,idFormulario,activo) values
					('".$obj->prefijo."','".$obj->separador."',".$obj->longitud.",".$obj->incremento.",".$obj->inicio.",".$obj->nActual.
					 ",".$obj->idFormulario.",".$activo.")";	
			if($con->ejecutarConsulta($consulta))
			{
				$idFolio=$con->obtenerUltimoID();
				echo "1|".$idFolio;
			}
			else
				echo "|";
		}
		else
		{
			$consulta="update 4001_foliosRegistros set prefijo='".$obj->prefijo."',separador='".$obj->separador."',longitud=".$obj->longitud.",
						incremento=".$obj->incremento.",inicio=".$obj->inicio.",numActual=".$obj->nActual.",idFormulario=".$obj->idFormulario." where idFolio=".$obj->idFolio;
			if($con->ejecutarConsulta($consulta))
				echo "1|".$obj->idFolio;
			else
				echo "|";
		}
					   
	}
	
	function obtenerConfFolios()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$consulta="select idFolio,prefijo,separador,longitud,incremento,inicio,numActual,if(activo=0,'false','true') as estado from 4001_foliosRegistros where idFormulario=".$idFormulario;
		$arrFolios=$con->obtenerFilasArreglo($consulta);		
		$consulta="select reglaFolio,tipoGeneradorFolio,funcionGeneradoraFolio from 900_formularios where idFormulario=".$idFormulario;
		$filaFolio=$con->obtenerPrimeraFila($consulta);
		$reglaFolio=$filaFolio[0];
		$tipoGenerador=$filaFolio[1];
		$funcionGeneradoraFolio=$filaFolio[2];
		
		echo "1|".uEJ(str_replace("'false'","false",str_replace("'true'","true",$arrFolios)))."|".$reglaFolio."|".$tipoGenerador."|".$funcionGeneradoraFolio;
	}
	
	function removerFolio()
	{
		global $con;
		$idFolio=$_POST["idFolio"];
		$consulta="delete from 4001_foliosRegistros where idFolio=".$idFolio;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function activarFolio()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idFolio=$_POST["idFolio"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 4001_foliosRegistros set activo=0 where idFormulario=".$idFormulario;
		$x++;
		$consulta[$x]="update 4001_foliosRegistros set activo=1 where idFolio=".$idFolio;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarReglaFolio()
	{
		global $con;
		$idFormulario=$_POST['idFormulario'];
		$idRegla=$_POST["idRegla"];
		$consulta="update 900_formularios set reglaFolio=".$idRegla." where idFormulario=".$idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
			
	}
	
	function obtenerEtapasProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa" ;
		$arrEtapas=$con->obtenerFilasArreglo($consulta);
		$registros="";
		if(isset($_POST["gE"]))
		{
			$idFormulario=obtenerFormularioBase($idProceso);
			$nTabla=obtenerNombreTabla($idFormulario);
			$consulta="select * from ".$nTabla;
			$resFilas=$con->obtenerFilas($consulta);
			$arrReg=array();
			$posCodigo=$con->existeCampo("codigo",$nTabla);
			$cCodigo=false;
			if($posCodigo!="")
				$cCodigo=true;
			while($fila=$con->fetchRow($resFilas))
			{
				$arrReg[$fila[0]]=obtenerTituloRegistro($fila,$idFormulario,$cCodigo);
				
			}
			natcasesort($arrReg);
			foreach($arrReg as $key=>$reg)
			{
				$obj="['".$key."','".$reg."']";
				if($registros=="")
					$registros=$obj;
				else
					$registros.=",".$obj;
			}
			
		}
		
		echo "1|".uEJ($arrEtapas)."|".uEJ("[".$registros."]");
	}
	
	function asignarResponsableActividad()
	{
		global $con;
		$idResponsable=$_POST["idResponsable"];
		$idActividad=base64_decode($_POST["idActividad"]);
		$consulta="update 965_actividadesUsuario set idUsuario=".$idResponsable." where idActividadPrograma=".$idActividad;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else	
			echo "|";
	}
	
	function guardarReglaReporteProgramaTrabajo()
	{
		global $con;
		$idResponsable=$_SESSION["idUsr"];
		$roles=$_POST["roles"];
		$lineasInv=$_POST["lineasInv"];
		$actividades=$_POST["actividades"];
		$nConf=$_POST["nConf"];
		$descripcion=$_POST["descripcion"];
		$query="insert into 987_configuracionReporte(nombreConf,descripcion,idUsuario,tipoReporte) values('".cv($nConf)."','".cv($descripcion)."',".$_SESSION["idUsr"].",2)";
		if($con->ejecutarConsulta($query))
		{
			$idConfiguracion=$con->obtenerUltimoID();
			$x=0;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($roles)."',1)";
			$x++;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($actividades)."',2)";
			$x++;
			$consulta[$x]="insert into 988_parametrosConfReporte(idConfiguracion,valor,tipoParametros) values(".$idConfiguracion.",'".cv($lineasInv)."',3)";
			$x++;
			if($con->ejecutarBloque($consulta))
				echo "1|";
			else
				echo "|";
		}
		else
			echo "|";
		
			
	}
	
	function guardarConfReportes()
	{
		global $con;
		$tReporte=$_POST["tReporte"];
		$rol=$_POST["rol"];
		$comp="";
		switch($tReporte)
		{
			case 3:
				$arrRol=explode("|",$rol);
				$rol=$arrRol[0];
				$comp=$arrRol[1];
			break;
		}
		$consulta="insert into 990_permisosReportes(tipoReporte,rol,comp1) values(".$tReporte.",'".$rol."','".$comp."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerRolReporte()
	{
		global $con;
		$tReporte=$_POST["tReporte"];
		$rol=$_POST["rol"];
		$consulta="delete from 990_permisosReportes where tipoReporte=".$tReporte." and rol in(".$rol.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerListadoExpresiones()
	{
		global $con;
		$inicio=$_POST["start"];
		$limite=$_POST["limit"];
		$idCategoria=$_POST["idCategoria"];
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$filtroUsuario=generarCadenaConsultasFiltro($_POST["filter"]);
			$filtroUsuario=" and ".$filtroUsuario;
		}

		$consulta="select c.idConsulta,c.nombreConsulta,t.nombreCategoria,c.descripcion,c.valorRetorno from 991_consultasSql c,991_categoriasConcepto t where c.situacion=1 and t.idCategoriaConcepto=c.idTipoConcepto ".$filtroUsuario." and idTipoConcepto in (".$idCategoria.") order by nombreConsulta";
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		$consulta="select c.idConsulta,c.nombreConsulta,t.nombreCategoria,c.descripcion,c.valorRetorno from 991_consultasSql c,991_categoriasConcepto t where c.situacion=1 and t.idCategoriaConcepto=c.idTipoConcepto ".$filtroUsuario." and idTipoConcepto in (".$idCategoria.")  order by nombreConsulta limit ".$inicio.",".$limite;

		$res=$con->obtenerFilas($consulta);
		$arrExpr="";
		while($fila=$con->fetchRow($res))
		{
			$consulta="select parametro,idParametro from 993_parametrosConsulta where idConsulta=".$fila[0];
			$arrAux="";
			$arrParam=$con->obtenerFilasArregloAsocPHP($consulta);
			if(sizeof($arrParam)>0)
			{
				
				foreach($arrParam as $p=>$idParametro)
				{
					$valor="";
					$tipoValor='';
					$aux="['".$p."','".$valor."','".$tipoValor."']";
					if($arrAux=="")
						$arrAux=$aux;
					else
						$arrAux.=",".$aux;
					
				}
			}
			$obj='{"idConsulta":"'.$fila[0].'","nombreConsulta":"'.$fila[1].'","nombreCategoria":"'.$fila[2].'","descripcion":"'.$fila[3].'","valorRetorno":"'.$fila[4].'","parametros":['.$arrAux.']}';
			if($arrExpr=="")
				$arrExpr=$obj;
			else
				$arrExpr.=",".$obj;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.uEJ($arrExpr).']}';
			
	}
	
	function validarQuery()
	{
		global $con;
		$cadObj=$_POST["obj"];
		echo "1|";
		return;
		$obj=json_decode($cadObj);
		$tabla=$_POST["tb"];
		
			if(!isset($_POST["tipo"]))
			{
				$condWhere="";
				foreach($obj->tokenSql as $token)
				{
					$cond=$token->tokenMysql;
					if($token->tipoToken<0)
					{
						$cond=evaluarExpresion($token->tokenMysql,$token->tipoToken);
					}
					else
					{
						$cond=$token->tokenMysql;
					}
					$condWhere.=" ".$cond." ";
				}
				$consulta="select * from ".$tabla." where ".$condWhere;
				echo $consulta;
				$fila=$con->obtenerPrimeraFila($consulta);
			}
			else
			{
				/*$cadObj='	{
							  "idUsuario":"1",
							  "fechaContratacion":"2010-01-01",
							  "sueldoBase":"10000"
						  	}';
			  $obj=json_decode($cadObj);
			  ejecutarExpresion($idConsulta,$obj);*/
			  
			}
			echo "1|";
		
	}
	
	function guardarExpresion()
	{
		global $con;
		$nConf="-1";
		if(isset($_POST["nConf"]))
			$nConf=$_POST["nConf"];
		
		$cadObj=$_POST["obj"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$codigo=$_POST["codigo"];
		$tipoConcepto=$_POST["idTipoConcepto"];
		$idAmbito=$_POST["idAmbito"];
		if($idAmbito=="")
			$idAmbito="0";
		if($tipoConcepto=="0")
			$idAmbito="0";
			
		$arrValoresDevueltos='{"arrValoresDevueltos":[]}';
		if(isset($_POST["arrValoresDevueltos"]))
		{
			$arrValoresDevueltos=$_POST["arrValoresDevueltos"];
		}
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$oValores=json_decode($arrValoresDevueltos);
		
		$obj=json_decode($cadObj);
		
		$tabla=$obj->tabla;
		$campoProy=$obj->campoProy;
		
		$idConsulta=$obj->idConsulta;

		$operacion="";
		if(isset($obj->operacion))
			$operacion=$obj->operacion;
		

		if($obj->tConsulta==10)
		{
			$operacion=$obj->idPerfil;
		}
		
		if($codigo!="")
		{
			$query="select idConsulta from 991_consultasSql where idConsulta<>".$idConsulta." and codigo='".$codigo."' and idTipoConcepto=".$tipoConcepto;	
			$filaConsulta=$con->obtenerPrimeraFila($query);
			if($filaConsulta)
			{
				echo "<br>El c&oacute;digo ingresado ya ha sido registrado previamente";
				return;
			}
		}
		$arrEstructuras="[]";
		if(isset($obj->arrEstructuras))
			$arrEstructuras=bD($obj->arrEstructuras);
		
		if($obj->idConsulta=="-1")
		{
			$consulta[$x]="insert into 991_consultasSql(nombreConsulta,descripcion,tipoConsulta,comp1,comp2,
							valorRetorno,comp3,codigo,idTipoConcepto,ambitoAplicacion,arrEstructuras,formatoGuardado) 
							values('".cv($nombre)."','".cv($descripcion)."',".$obj->tConsulta.",'".$obj->tabla."','".$obj->campoProy.
							"','".$obj->valorRetorno."','".$operacion."','".$codigo."',".$tipoConcepto.",".$idAmbito.",'".cv($arrEstructuras).
							"',".(isset($obj->formatoGuardado)?$obj->formatoGuardado:1).")";
			$x++;
				
			$consulta[$x]="set @iRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			
			$consulta[$x]="update 991_consultasSql set arrEstructuras='".cv($arrEstructuras)."',nombreConsulta='".cv($nombre).
					"',descripcion='".cv($descripcion)."',valorRetorno='".$obj->valorRetorno."',codigo='".$codigo.
					"',idTipoConcepto=".$tipoConcepto.",ambitoAplicacion=".$idAmbito.",formatoGuardado=".
					(isset($obj->formatoGuardado)?$obj->formatoGuardado:1)." where idConsulta=".$obj->idConsulta;
			$x++;
			
			$consulta[$x]="set @iRegistro:=".$obj->idConsulta;
			$x++;
			
			
			$query="select idToken from 992_tokensConsulta where idConsulta=@iRegistro";
			$listParametros=$con->obtenerListaValores($query);
			if($listParametros=="")
				$listParametros="-1";
			$consulta[$x]="delete from 994_valoresTokens where idToken in (".$listParametros.")";
			$x++;
			
			
			$consulta[$x]="delete from 992_tokensConsulta where idConsulta=@iRegistro";
			$x++;
			
		}
		
			
			
		$consulta[$x]="DELETE FROM 994_valoresDevueltoFuncion WHERE idConsulta=@iRegistro";
		$x++;
		
		foreach($oValores->arrValoresDevueltos as $o)
		{
			
			$consulta[$x]="INSERT INTO 994_valoresDevueltoFuncion(idConsulta,nombreValor,descripcion) 
							VALUES(@iRegistro,'".cv($o->nombreValor)."','".cv($o->descripcion)."')";
			$x++;
		}
			
			
		foreach($obj->tokenSql as $token)
		{
			$comp1="";
			if(isset($token->comp1))
				$comp1=$token->comp1;
			
			
			if($obj->formatoGuardado==2)
			{
				$token->tokenMysql=str_replace(" ","+",$token->tokenMysql);
			}
			
			$consulta[$x]="insert into 992_tokensConsulta(tokenMysql,tokenUsr,tipoToken,idConsulta,valorDevuelto,comp1) values('".
						cv($token->tokenMysql,false)."','".cv($token->tokenUsuario)."','".$token->tipoToken.
						"',@iRegistro,'".$token->valorDevuelto."','".$comp1."')";
			$x++;
			
			$consulta[$x]="set @lastToken:=(select last_insert_id())";
			$x++;
			
			
			if(isset($token->valParametros))
			{
				if($token->valParametros!="")
				{
					$arrParam=explode("|",$token->valParametros);
					$arrParametrosAux="";
					foreach($arrParam as $param)
					{
						$datosParam=explode(",",$param);
						$nParam=$datosParam[0];
						$vParam=$datosParam[1];
						$tParam=$datosParam[2];
						if($token->tipoToken!=25)
						{
							$query="select idParametro from 993_parametrosConsulta where idConsulta=".($token->tipoToken*-1)." and parametro='".$nParam."'";
							$idParametros=$con->obtenerValor($query);
							if($idParametros=="")
								$idParametros=-1;
							$consulta[$x]="insert into 994_valoresTokens(idToken,valor,tipoValor,idParametro) values(@lastToken,'".cv($vParam)."',
											'".$tParam."',".$idParametros.")";
							$x++;
						}
						else
						{
							$objParam='{"parametro":"'.$nParam.'","tipoValor":"'.$tParam.'","valorSistema":"'.$vParam.'"}';
							if($arrParametrosAux=="")
								$arrParametrosAux=$objParam;
							else
								$arrParametrosAux.=",".$objParam;
						}
					}
					
					if($token->tipoToken==25)
					{
						$arrToken=explode("|",$token->tokenMysql);
						$cadObjToken='{"tipoOrigen":"'.$arrToken[0].'","idOrigen":"'.$arrToken[1].'","parametros":['.$arrParametrosAux.']}';
						$consulta[$x]="update 992_tokensConsulta set tokenMysql='".cv($cadObjToken)."' where idToken=@lastToken";
						$x++;	
					}
				}
			}
			
		}
			
		$cadParametrosDel="'-1'";
		if((isset($obj->parametros))&&($obj->parametros!=""))
		{
			$arrParametros=explode(",",$obj->parametros);
			
			foreach($arrParametros as $param)
			{
				$cadParametrosDel.=",'".$param."'";
				$query="select idParametro from 993_parametrosConsulta where idConsulta=".$obj->idConsulta." and parametro='".cv($param)."'";
				
				$idParam=$con->obtenerValor($query);
				if($idParam=="")
				{
					$consulta[$x]="insert into 993_parametrosConsulta(parametro,idConsulta) values('".cv($param)."',@iRegistro)";
					$x++;
				}
			}
		}
			
		$consulta[$x]="delete from 993_parametrosConsulta where idConsulta=@iRegistro and parametro not in (".$cadParametrosDel.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			if($nConf!="-1")
			{
				cambiarValorObjParametros($nConf,'idConsulta',$idConsulta);
			}
			echo "1|".$idConsulta;
		}
		else
			echo "|";
		
		
	}
	
	
	function eliminarConcepto()
	{
		global $con;
		$idConsulta=($_POST["idConsulta"]);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 991_consultasSql where idConsulta=".$idConsulta;
		$x++;
		$consulta[$x]="delete from 992_tokensConsulta where idConsulta=".$idConsulta;
		$x++;
		$consulta[$x]="delete from 993_parametrosConsulta where idConsulta=".$idConsulta;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function generarFechasCiclo()
	{
		global $con;
		$ciclo=bD($_POST["ciclo"]);	
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 655_fechasNomina(ciclo,situacion) values(".$ciclo.",1)";
		$x++;
		$nCod="0";
		for($y=1;$y<=24;$y++)
		{
			if($y>9)
				$nCod="";
			$consulta[$x]="insert into 656_calendarioNomina(noQuincena,ciclo,etiqueta,situacion,mes) values('".$nCod.$y."',".$ciclo.",'N&oacute;mina quincena ".$y."',1,".round($y/2).")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarFechasNomina()
	{
		global $con;
		$idFechaNom=$_POST["idFechaNom"];
		$columna=$_POST["columna"];
		$valor=$_POST["valor"];
		$campo="";
		switch($columna)
		{
			case 2:
				$campo="fechaLimiteOperacion";
			break;
			case 3:
				$campo="fechaLimiteAprobacion";
			break;
			case 4:
				$campo="fechaInicioIncidencia";
			break;
			case 5:
				$campo="fechaFinIncidencia";
			break;
			case 6:
				$campo="fechaPago";
			break;
		}
		
		$consulta="update 656_calendarioNomina set ".$campo."='".$valor."' where idFechaNomina=".$idFechaNom;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarCuentaPercepcionDeduccion()
	{
		global $con;
		$cadCuentas=$_POST["cadCuentas"];
		$idConcepto=bD($_POST["idConcepto"]);
		$tAfectacion=$_POST["tAfectacion"];
		$tipo=$_POST["tipo"];
		$arrCuentas=explode(",",$cadCuentas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrCuentas as $cuenta)
		{
			$datosCta=explode("|",$cuenta);
			$query="select  codigoCta FROM 510_cuentas WHERE idCuenta=".$datosCta[0];
			$codCuenta=$con->obtenerValor($query);
			$consulta[$x]="insert into 661_afectacionesCuentasDeducPercepciones(idDeduccionPercepcion,tipo,codCuentaAfectacion,codCuentaAfectacionSimple,
							porcentaje,tipoAfectacion,idEstructura) values
							(".$idConcepto.",".$tipo.",'".$codCuenta."','',0,".$tAfectacion.",".$datosCta[0].")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "";
	}
	
	function removerCuentaPercepcionDeduccion()
	{
		global $con;
		$id=bD($_POST["id"]);
		$consulta="delete from 661_afectacionesCuentasDeducPercepciones where idAfectacionCuentas=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarCampoPercepcionDeduccion()
	{
		global $con;
		$id=bD($_POST["id"]);
		$valor=$_POST["valor"];
		$tipo=$_POST["tipo"];
		$nCampo="";
		switch($tipo)
		{
			case 1:
				$nCampo="tipoAfectacion";
			break;
			case 2:
				$nCampo="porcentaje";
			break;
		}
		$consulta="update 661_afectacionesCuentasDeducPercepciones set ".$nCampo."=".$valor." where idAfectacionCuentas=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerPercepcionDeduccion()
	{
		global $con;
		$idConcepto=bD($_POST["idConcepto"]);
		$tipo=$_POST["tipo"];
		$query="select orden,idUsuarioAplica from 662_calculosNomina where idCalculo=".$idConcepto;
		$filaCal=$con->obtenerPrimeraFila($query);
		$orden=$filaCal[0];
		$idUsuario=$filaCal[1];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 662_calculosNomina where idCalculo=".$idConcepto;
		$x++;
		if($idUsuario=="")
			$consulta[$x]="update 662_calculosNomina set orden=orden-1 where idUsuarioAplica is null and orden>".$orden;
		else
			$consulta[$x]="update 662_calculosNomina set orden=orden-1 where idUsuarioAplica =".$idUsuario." and orden>".$orden;
		$x++;
		$consulta[$x]="delete from 660_afectacionesDeducPercepciones where idDeduccionPercepcion=".$idConcepto;
		$x++;
		$consulta[$x]="delete from 661_afectacionesCuentasDeducPercepciones where idDeduccionPercepcion=".$idConcepto." and tipo=".$tipo;
		$x++;
		$consulta[$x]="DELETE FROM 669_filtroAplicacionCalculosNomina WHERE idCalculo=".$idConcepto;
		$x++;
		$consulta[$x]="DELETE FROM 668_clasificacionCalculosNomina WHERE idCalculo=".$idConcepto;
		$x++;
		$consulta[$x]="DELETE FROM 663_valoresCalculos WHERE idCalculo=".$idConcepto;
		$x++;
		$consulta[$x]="DELETE FROM 666_acumuladoresCalculo WHERE idCalculo=".$idConcepto;
		$x++;
		
		
		

		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";

	}
	
	function actualizarCampoIdentifica()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$valor=$_POST["valor"];
		$accion=$_POST["accion"];
		$consulta="";
		$comp="";
		switch($accion)
		{
			case 1:
				$campo="registraEntrada";
			break;
			case 2:
				$campo="codigoRegAsistencia";
			break;
			case 3:
				$tolerancia=$_POST["tolerancia"];
				if($tolerancia=="")
					$tolerancia="NULL";
				$campo="esquemaTolerancia";
				$comp=",toleraciaRetardo=".$tolerancia;
			break;
			case 4:
				$campo="idCuentaDeposito";
			break;
			case 5:
				$campo="rolGuardia";
			break;
			case 6:
				$campo="consideraTiempoDemanda";
			break;
		}
		$consulta="update 801_adscripcion set ".$campo."='".$valor."' ".$comp." where idUsuario=".$idUsuario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";

	}
	
	function asignarBeneficiario()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idBeneficiario=$_POST["idBeneficiario"];
		$idAfectacionCuentas=bD($_POST["idAfectacion"]);
		$consulta="update 661_afectacionesCuentasDeducPercepciones set idBeneficiario=".$idBeneficiario." ,tipoBeneficiario=".$tipo." where idAfectacionCuentas=".$idAfectacionCuentas;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarTipoPresupuestoAfectacion()
	{
		global $con;
		$idCuenta=$_POST["idCuenta"];
		$tipoPresupuesto=$_POST["tipoPresupuesto"];	
		$consulta="update 661_afectacionesCuentasDeducPercepciones set idTipoPresupuesto=".$tipoPresupuesto." where idAfectacionCuentas=".$idCuenta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function agregarCategoria()
	{
		global $con;
		$numCategoria=$_POST["numCategoria"];
		$nCategoria=$_POST["nCategoria"];
		$idCategoria=$_POST["idCategoria"];
		$idProceso=$_POST["idProceso"];
		$descripcion=$_POST["descripcion"];
		$configuracion=$_POST["idConf"];
		if($idCategoria=="-1")
			$consulta="insert into 4037_categoriasEtapa(numCategoria,nomCategoria,idProceso,descripcion) 
						value(".$numCategoria.",'".cv($nCategoria)."',".$idProceso.",'".cv($descripcion)."')";
		else
			$consulta="update 4037_categoriasEtapa set numCategoria=".$numCategoria.",nomCategoria='".cv($nCategoria)."',
						descripcion='".cv($descripcion)."'	 where idCategoria=".$idCategoria;
		if($con->ejecutarConsulta($consulta))	
		{
			cambiarValorObjParametros($configuracion,"tabActivo",1);	
			echo "1|";
		}
		else
			echo "|";
	}
	
	function removerCategoria()
	{
		global $con;
		$idCategoria=bD($_POST["iC"]);
		$consulta="delete from 4037_categoriasEtapa where idCategoria=".$idCategoria;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";

	}
	
	function eliminarCategoriaProceso()
	{
		global $con;
		$idCategoria=bD($_POST["iC"]);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 921_tiposProceso where idTipoProceso=".$idCategoria;
		$x++;
		$consulta[$x]="delete from 936_vistasProcesos where tipoProceso=".$idCategoria;
		$x++;
		$consulta[$x]="delete from 946_accionesActoresVSTipoProceso where tipoProceso=".$idCategoria;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerAccionesAsocTipoProceso()
	{
		global $con;
		$tA=$_POST["tA"];
		$tProceso=$_POST["tProceso"];
		$consulta="SELECT aa.idGrupoAccion,aa.accion,ap.nombreAccion,(if((SELECT COUNT(pe.idGrupoAccion) FROM 944_actoresProcesoEtapa ap, 4001_procesos p,
				947_actoresProcesosEtapasVSAcciones pe WHERE pe.idActorProcesoEtapa=ap.idActorProcesoEtapa AND p.idProceso=ap.idProceso AND 
				pe.idGrupoAccion=aa.idGrupoAccion AND p.idTipoProceso=".$tProceso.")=0,'1','0')) as removible FROM 945_accionesActor aa,
				946_accionesActoresVSTipoProceso ap WHERE aa.tipoAccion=".$tA." AND  ap.idGrupoAccion=aa.idGrupoAccion AND tipoProceso=".$tProceso." order by aa.accion";
		
		$arrAcciones=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrAcciones);
	}
	
	function obtenerAccionesDisponiblesAsocTipoProceso()
	{
		global $con;
		$tA=$_POST["tA"];
		$tProceso=$_POST["tProceso"];
		$consulta="SELECT aa.idGrupoAccion,aa.accion FROM 945_accionesActor aa WHERE 
					aa.tipoAccion=".$tA." AND  aa.idGrupoAccion not in 
					(select idGrupoAccion from 946_accionesActoresVSTipoProceso where tipoProceso=".$tProceso.") order by aa.accion";
		$arrAcciones=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrAcciones);
	}
	
	function asociarAccionesTipoProceso()
	{
		global $con;
		$lista=$_POST["lista"];
		$idTipoProceso=$_POST["idTipoProceso"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$arrLista=explode(",",$lista);
		foreach($arrLista as $accion)
		{
			$query="select accion from 945_accionesActor where idGrupoAccion=".$accion;
			$nAccion=$con->obtenerValor($query);
			$consulta[$x]="insert into 946_accionesActoresVSTipoProceso(idGrupoAccion,tipoProceso,nombreAccion) values(".$accion.",".$idTipoProceso.",'".cv($nAccion)."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerAccionesTipoProceso()
	{
		global $con;
		$lista=$_POST["lista"];
		$idTipoProceso=$_POST["idTipoProceso"];
		$consulta="delete from 946_accionesActoresVSTipoProceso where idGrupoAccion in (".$lista.") and tipoProceso=".$idTipoProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarNombreAccionTipoProceso()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$tProceso=$_POST["tProceso"];	
		$valor=$_POST["valor"];
		$consulta="update 946_accionesActoresVSTipoProceso set nombreAccion='".cv($valor)."' where idGrupoAccion=".$idAccion." and tipoProceso=".$tProceso;
		eC($consulta);
		
	}
	
	function obtenerParticipantesElementosDTD()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$query="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProyecto." order by numEtapa";
		$resEtapa=$con->obtenerFilas($query);
		$arrEtapasPart="";
		while($fEtapa=$con->fetchRow($resEtapa))
		{
			$query="select * from 995_proyectosVSParticipantesVSEtapas where idProyecto=".$idProyecto." and numEtapa=".$fEtapa[0];
			$res=$con->obtenerFilas($query);
			$arrPart="";
			$eDTDHijos="[]";
			while($fila=$con->fetchRow($res))
			{
				$query="select descParticipacion from 953_elementosPerfilesParticipacionAutor where idElementoPerfilAutor=".$fila[2];
				$nomParticipante=$con->obtenerValor($query);
				$eDTDHijos=obtenerElementosDTDHijosParticipantes($fila[0]);
				if($eDTDHijos=="[]")
					$hijos='"leaf":true,';
				else
					$hijos='"leaf":false,"children":'.$eDTDHijos.',';
					$titulo="<span class='copyright'>".$nomParticipante."</span>";
				
				$objParticipante='	{	
										"text":"<font color=\'#990000\'><b>Participante:</b></font> '.$titulo.'",
										"tituloO":"'.$nomParticipante.'",
										"id":"part_'.$fila[0].'",
										"icon":"../images/users.png",
										"cls":"x-btn-text-icon",
										"tipo":"1",
										"funciones":'.$fila[3].','.$hijos.'
										"allowDrop":false,
										"draggable" :false
		
									}';
				
				if($arrPart=="")
					$arrPart=$objParticipante;
				else
					$arrPart.=','.$objParticipante;
			}
			$hijosEtapaPart="leaf:true";
			if($arrPart=="")
				$hijosEtapaPart="leaf:true";
			else
				$hijosEtapaPart="leaf:false,children:[".$arrPart."]";
			
			$objEtapaPart='	{	
								"text":"<font color=\'#000066\'><b>Etapa:</b></font> '.removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1].'",
								"id":"ePart_'.$fEtapa[0].'",
								"numEtapa":"'.$fEtapa[0].'",
								"cls":"x-btn-text-icon",
								"icon":"../images/s.gif",
								"tipo":"2",
								"allowDrop":false,
								"draggable" :false,
								'.$hijosEtapaPart.'

							}';
			
			if($arrEtapasPart=="")
				$arrEtapasPart=$objEtapaPart;
			else
				$arrEtapasPart.=','.$objEtapaPart;
		}
		
		echo "[".uEJ($arrEtapasPart)."]";
	}
	
	function obtenerElementosDTDHijosParticipantes($idProyectoParticipantes)
	{
		global $con;
		$query="(select e.idProyectoParticipanteElementosDTD,f.nombreFormulario,e.funciones,eD.tipoElemento from 996_proyectosParticipantesElementosDTD e,203_elementosDTD eD,
			900_formularios f where  eD.idElementoDTD=e.idElemento and f.idFormulario=eD.idFormulario and e.idProyectoParticipante=".$idProyectoParticipantes.")
			union
			(select e.idProyectoParticipanteElementosDTD,f.nombreFormulario,e.funciones,'0' as tipoElemento
			from 996_proyectosParticipantesElementosDTD e,900_formularios f where  f.idFormulario=(e.idElemento*-1) 
			and e.idProyectoParticipante=".$idProyectoParticipantes.") order by nombreFormulario";
		$arrObj="";
		
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			if($fila[2]=="0")
				$titulo=$fila[1]." <b>Funci&oacute;n:</b> <font color='darkred'><b>S&oacute;lo Ver</b></font>";
			else
				$titulo=$fila[1]." <b>Funci&oacute;n:</b> <font color='blue'><b>Ver y modificar</b></font>";
			$compAnt="";
			if($fila[3]=="2")
				$compAnt="<font color='#990000'><b>Proceso:</b></font>&nbsp;";
			$objDTD='
						{	
								"text":"'.$compAnt.$titulo.'",
								"tituloO":"'.$compAnt.$fila[1].'",
								"id":"'.$fila[0].'",
								"icon":"../images/s.gif",
								"tipo":"0",
								"leaf":true,
								"funciones":'.$fila[2].',
								"allowDrop":false,
								"draggable" :false

							}
					';
			
			if($arrObj=="")
				$arrObj=$objDTD;
				
			else
				$arrObj.=",".$objDTD;
		}
		$comp="";
		if($arrObj=="")
			$comp='"leaf":true,';
		else
			$comp='"leaf":false,children:['.$arrObj.'],';
		
		$objElemento='		{	
								"text":"<b><i>Elementos DTD:</i></b>",
								"id":"eTD_'.$idProyectoParticipantes.'",
								"icon":"../images/s.gif",
								"tipo":"3",'.$comp.'
								"allowDrop":false,
								"draggable" :false

							}';
		
		$comp2="";
		$arrObj2="";
		
		$consulta="select ap.idGrupoAccion,pp.idProyecto,ap.idAccionParticipanteProcesoEtapa,ap.complementario,pp.numEtapa,ap.complementario2 from 997_accionesParticipanteVSProcesoVSEtapa ap,
					995_proyectosVSParticipantesVSEtapas pp where pp.idProyectoVSParticipanteVSEtapa=ap.idProyectoParticipante and
					ap.idProyectoParticipante=".$idProyectoParticipantes;
		$resAcciones=$con->obtenerFilas($consulta);
		while($filaAccion=$con->fetchRow($resAcciones))
		{
			$idTipoProyecto=obtenerTipoProceso($filaAccion[1]);
			$consulta="select nombreAccion from 946_accionesActoresVSTipoProceso where idGrupoAccion=".$filaAccion[0]." and tipoProceso=".$idTipoProyecto;
			$nAccion=$con->obtenerValor($consulta);
			$msgConfirmacion=utf8_encode("Est� seguro de querer someter este registro a revisi�n?");
			if($filaAccion[5]!="")
			{
				$obj=json_decode($filaAccion[5]);
				$nAccion=$obj->etiqueta;
				$msgConfirmacion=$obj->msgConf;
			}
			$comp="";
			$atModif="";
			if($filaAccion[0]=="1")
			{
				$atModif='"modifEtapa":"1","etapaActual":"'.$filaAccion[3].'","numEtapa":"'.$filaAccion[4].'",';
				if($filaAccion[3]=='')
					$comp="&nbsp;&nbsp;<img src='../images/exclamation.png' alt='A&uacute;n no ha configurado la etapa al cual pasar&aacute; el registro al ser sometido a revisi&oacute;n, para hacerlo seleccione el elemento y d&eacute; click sobre el boton Modificar etapa de envio que se encuentra en la parte superiro del panel' title='A&uacute;n no ha configurado la etapa al cual pasar&aacute; el registro al ser sometido a revisi&oacute;n, para hacerlo seleccione el elemento y d&eacute; click sobre el boton Modificar etapa de envio que se encuentra en la parte superiro del panel'>";
				else
				{
					$consulta="select nombreEtapa from 4037_etapas where idProceso=".$filaAccion[1]." and numEtapa=".$filaAccion[3];
					$nEtapa=$con->obtenerValor($consulta);
					$comp="&nbsp;(<font color='#000055'><b>Envia a etapa: </b></font><font color='green'><b>".removerCerosDerecha($filaAccion[3]).".- ".$nEtapa."</b></a>)";
				}
			}	
			$objDTD='
						{	
								"text":"'.$nAccion.$comp.'",
								"nAccion":"'.$nAccion.'",
								"id":"accion_'.$filaAccion[2].'",
								"msgConf":"'.bE($msgConfirmacion).'",
								"icon":"../images/s.gif",
								"tipo":"5",'.$atModif.'
								"leaf":true,
								"allowDrop":false,
								"draggable" :false
						}
				';
			
			if($arrObj2=="")
				$arrObj2=$objDTD;
			else
				$arrObj2.=",".$objDTD;
			
		}
		
		if($arrObj2=="")
			$comp2='"leaf":true,';
		else
			$comp2='"leaf":false,children:['.$arrObj2.'],';
		
		$objElemento.='		,{	
								"text":"<b><i>Acciones participante:</i></b>",
								"id":"eAccion_'.$idProyectoParticipantes.'",
								"icon":"../images/s.gif",
								"tipo":"4",'.$comp2.'
								"allowDrop":false,
								"draggable" :false

							}';
		
		
		return "[".$objElemento."]";
	}
	
	
	function obtenerElementosDTDDisponiblesParticipante()
	{
		global $con;
		$idProceso=$_POST["idProyecto"];
		$cadProyecto=$_POST["idProyectoParticipante"];
		$arrProyecto=explode("_",$cadProyecto);
		$idProyectoParticipante=$arrProyecto[1];
		
		$idFormularioBase=obtenerFormularioBase($idProceso);
		$consulta="SELECT idElemento FROM 996_proyectosParticipantesElementosDTD WHERE idElemento=-".$idFormularioBase;
		$idElemento=$con->obtenerValor($consulta);
		if($idElemento=="")
		{
			$consulta="(select idElementoDTD,idFormulario,tipoElemento from 203_elementosDTD where idProceso=".$idProceso." and idFormulario 
						not in(select ed.idFormulario from 996_proyectosParticipantesElementosDTD pc,203_elementosDTD ed  
						where ed.idElementoDTD=pc.idElemento and pc.idProyectoParticipante=".$idProyectoParticipante.")) 
						union
						(select idFormulario*-1,idFormulario,'0' as tipoElemento from 900_formularios where idFormulario=".$idFormularioBase.")
						";
		}
		else
		{
			$consulta="select idElementoDTD,idFormulario,tipoElemento from 203_elementosDTD where idProceso=".$idProceso." and idFormulario 
						not in(select ed.idFormulario from 996_proyectosParticipantesElementosDTD pc,203_elementosDTD ed  
						where ed.idElementoDTD=pc.idElemento and pc.idProyectoParticipante=".$idProyectoParticipante.")	";
		}
		$filas=$con->obtenerFilas($consulta);
		$nodosElementos="";
		while($f=$con->fetchRow($filas))
		{
			$consulta="select * from 900_formularios where idFormulario=".$f[1];
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			switch($f[2])
			{
				case 0:
					$nodo='{
								id:"'.$f[0].'",
								text:"'.uEJ($filaFrm["1"]).'",
								tituloO:"'.uEJ($filaFrm[1]).'",
								funciones:"",
								draggable:true,
								tipo:"0",
								leaf:true,
								allowDrop:false,
								"draggable" :false,
								"checked":false
						}';
				break;
				case 1:
					$nodo='{
								id:"'.$f[0].'",
								text:"'.uEJ($filaFrm[1]).'",
								tituloO:"'.uEJ($filaFrm[1]).'",
								funciones:"",
								draggable:true,
								tipo:"1",
								leaf:true,
								idModulo:'.$filaFrm[6].',
								allowDrop:false,
								"draggable" :false,
								"checked":false
							}';
				break;
				case 2:
					$nodo='{
								id:"'.$f[0].'",
								text:"<font color=\'#990000\'><b>Proceso:</b></font>&nbsp;'.uEJ($filaFrm["1"]).'",
								tituloO:"'.uEJ($filaFrm[1]).'",
								funciones:"",
								draggable:true,
								tipo:"0",
								leaf:true,
								allowDrop:false,
								"draggable" :false,
								"checked":false
							}';
				break;	
			}
			
			if($nodosElementos=="")
				$nodosElementos=$nodo;
			else
				$nodosElementos.=",".$nodo;
		}
		
		echo "[".uEJ2($nodosElementos)."]";
	}
	
	function eliminarDatosParticipante()
	{
		global $con;
		$id=$_POST["id"];
		$tipo=$_POST["tipo"];
		if(($tipo=="1")||($tipo=="4"))
		{
			$arrId=explode("_",$id);
			$id=$arrId[1];
		}
		$x=0;
		$query[$x]="begin";		
		$x++;
		switch($tipo)
		{
			case 0:
				$query[$x]="delete from 996_proyectosParticipantesElementosDTD where idProyectoParticipanteElementosDTD=".$id;		
				$x++;
			break;
			case 1:
				$query[$x]="delete from 995_proyectosVSParticipantesVSEtapas where idProyectoVSParticipanteVSEtapa=".$id;		
				$x++;
				$query[$x]="delete from 996_proyectosParticipantesElementosDTD where idProyectoParticipante=".$id;		
				$x++;
				$query[$x]="delete from 997_accionesParticipanteVSProcesoVSEtapa where idProyectoParticipante=".$id;		
				$x++;
			break;	
			case 4:
				$query[$x]="delete from 997_accionesParticipanteVSProcesoVSEtapa where idAccionParticipanteProcesoEtapa=".$id;		
				$x++;
			break;
		}
		$query[$x]="commit";		
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarFuncionParticipanteElemento()
	{
		global $con;
		$valorFuncion=$_POST["valorFuncion"];
		$id=$_POST["id"];
		$consulta="update 996_proyectosParticipantesElementosDTD set funciones=".$valorFuncion." where idProyectoParticipanteElementosDTD=".$id;
		
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerAccionesParticipantesDisponibles()
	{
		global $con;
		$idParticipante=$_POST["idParticipante"];
		$idProceso=$_POST["idProceso"];
		$tProceso=obtenerTipoProceso($idProceso);
		$consulta="SELECT idGrupoAccion,nombreAccion FROM 946_accionesActoresVSTipoProceso where idGrupoAccion in (1,6,7) and idGrupoAccion NOT IN 
					(select ap.idGrupoAccion from 997_accionesParticipanteVSProcesoVSEtapa ap where ap.idProyectoParticipante=".$idParticipante.") AND
					tipoProceso=".$tProceso." order by nombreAccion";
		$arrAcciones=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrAcciones);
	}
	
	function guardarAccionesParticipante()
	{
		global $con;	
		$acciones=$_POST["acciones"];
		$idParticipante=$_POST["idParticipante"];
		$arrAcciones=explode(",",$acciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrAcciones as $accion)
		{
			$consulta[$x]="insert into 997_accionesParticipanteVSProcesoVSEtapa(idGrupoAccion,idProyectoParticipante) values(".$accion.",".$idParticipante.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function modificarPasoEtapaParticipante()
	{
		global $con;
		$idParticipante=$_POST["idParticipante"];
		$numEtapa=$_POST["numEtapa"];
		$obj=$_POST["obj"];
		$consulta="update 997_accionesParticipanteVSProcesoVSEtapa set complementario='".$numEtapa."',complementario2='".cv($obj)."' where idAccionParticipanteProcesoEtapa=".$idParticipante;
		eC($consulta);
	}
	
	function obtenerDictamenesAsociados()
	{
		global $con;
		global  $lblComiteS;
		$idProceso=$_POST["idProceso"];
		$idFormulario=obtenerFormularioBase($idProceso);
		$actor=$_POST["actor"];
		$etapaReg=$_POST["etapa"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT COUNT(etapaActual)-1 AS versionRegistro FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$etapaReg." AND idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
		$nVersion=$con->obtenerValor($consulta);
		
		$consulta="SELECT ae.idGrupoAccion,ae.idActorProcesoEtapa,idAccionesProcesoEtapaVSAcciones 
					FROM 947_actoresProcesosEtapasVSAcciones ae,944_actoresProcesoEtapa pe WHERE 
					pe.idActorProcesoEtapa=ae.idActorProcesoEtapa AND ae.idGrupoAccion IN (4,5) AND pe.numEtapa=".$etapaReg."
					and 
					(
						pe.asocAutomatico=1 or
						(
							pe.asocAutomatico=0 and 
							(select idActorEvaluador from 998_actoresEvaluadoresAsignados where idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and idActorProcesoEtapa=ae.idActorProcesoEtapa) is not null
						)
					
					)
					AND pe.idProceso=".$idProceso." AND ae.idActorProcesoEtapa<>".$actor;
		$resDictamenes=$con->obtenerFilas($consulta);
		$arrDictamenes="";
		while($filaDictamen=$con->fetchRow($resDictamenes))					
		{
			$consulta="select actor,tipoActor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$filaDictamen[1];
			$filaAt=$con->obtenerPrimeraFila($consulta);
			$nActor="";
			if($filaAt[1]=="1")
				$nActor="<b>Rol:</b> ".obtenerTituloRol($filaAt[0]);
			else
			{
				$consulta="select c.nombreComite from 234_proyectosVSComitesVSEtapas pc,2006_comites c where c.idComite=pc.idComite and pc.idProyectoVSComiteVSEtapa=".$filaAt[0];
				$nComite=$con->obtenerValor($consulta);
				$nActor="<b>".$lblComiteS.":</b> ".$nComite;
			}
			
			$tDictamen="";
			if($filaDictamen[0]==4)
				$tDictamen="P";
			else
				$tDictamen="F";
			$consulta="SELECT * FROM 964_registroDictamenes WHERE versionRegistro=".$nVersion." and idActor=".$filaDictamen[1]." AND idReferencia=".$idRegistro." AND tipoDictamen='".$tDictamen."'";
			$filaD=$con->obtenerPrimeraFila($consulta);
			
			$situacion="<font color=\"#990000\"><b>En espera de dict&aacute;men</b></font>";
			$fechaDictamen="";
			$idReferencia="";
			$idFormulario="";
			
			if($filaD)
			{
				$situacion="<font color=\"#003300\"><b>Dictaminado</b></font>";
				$fechaDictamen=date("d/m/Y",strtotime($filaD[5]));
				$idReferencia=$filaD[2];
				$idFormulario=$filaD[1];
			}
			
			$obj="['".$filaDictamen[2]."','".$nActor."','".$situacion."','".$fechaDictamen."','".$idReferencia."','".$idFormulario."']";
			if($arrDictamenes=="")
				$arrDictamenes=$obj;
			else
				$arrDictamenes.=",".$obj;	
			
		}
		echo "1|[".uEJ($arrDictamenes)."]";
		
			
	}
	
	function obtenerProcesosDisponiblesInclusion()
	{
		global $con;
		$idTipoProceso=$_POST["idTipoProceso"];
		$idProceso=$_POST["idProceso"];
		$comp="";
		$consulta="select titulo from 900_formularios where idProceso=".$idProceso." and tipoFormulario=20";
		$lista=$con->obtenerListaValores($consulta);
		if($lista!="")
			$comp=",".$lista;
		$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$idTipoProceso." and idProceso not in (".$idProceso.$comp.
					") and situacion=1 order by nombre";
		$arrObjetos=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arrObjetos)."";
	}
	
	function vicularProcesoDTD()
	{
		global $con;
		global $tipoServidor;
		$idProcesoV=$_POST["idProcesoV"];	
		$idProcesoP=$_POST["idProcesoP"];
		$nEtapa=$_POST["nEtapa"];
		
		$tipoActor=-1;
		if(isset($_POST["tipoActor"]))
			$tipoActor=$_POST["tipoActor"];
		
		$actor=-1;
		if(isset($_POST["actor"]))
			$actor=$_POST["actor"];
		

		$idPerfil=-1;
		if($tipoActor!=-1)
		{
			$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE idProceso=".$idProcesoP." AND tipoActor=".$tipoActor." AND actor='".$actor."'";
			$idPerfil=$con->obtenerValor($consulta);
			if($idPerfil=="")
				$idPerfil=-1;
		}
		
		$x=0;
		
		$consulta="select nombre from 4001_procesos where idProceso=".$idProcesoV;
		$nombreFuncion=$con->obtenerValor($consulta);
		if($tipoServidor=="1")
			$nombreFuncion=($nombreFuncion);
		$consulta="select nombreTabla from 900_formularios where idProceso=".$idProcesoV." and formularioBase=1";
		$tablaAsoc=$con->obtenerValor($consulta);
		$consulta="select idFormulario from 900_formularios where idProceso=".$idProcesoP." and formularioBase=1";
		$idFormularioBase=$con->obtenerValor($consulta);
		
		$query[$x]="begin";
		$x++;
		$queryAux="select max(orden) from 203_elementosDTD where idProceso=".$idProcesoP;
		$orden=$con->obtenerValor($queryAux);
		$orden++;
		$queryAux="insert into 900_formularios(nombreFormulario,titulo,asociadoProceso,idProceso,idEtapa,tipoFormulario,idFrmEntidad,nombreTabla) 
						values('".$nombreFuncion."','".$idProcesoV."',1,".$idProcesoP.",".$nEtapa.",20,".$idFormularioBase.",'".$tablaAsoc."')";
				
		if($con->ejecutarConsulta($queryAux))
			$idFormulario=$con->obtenerUltimoID();
		if($idPerfil==-1)
		{
			$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,idPerfil) values(".$idProcesoP.",".$idFormulario.",2,".$orden.",".$idPerfil.")";
			$x++;
		}
		else
		{
			$query[$x]="insert into 203_elementosDTD(idProceso,idFormulario,tipoElemento,orden,noEtapa,idPerfil) values(".$idProcesoP.",".$idFormulario.",2,".$orden.",".$nEtapa.",".$idPerfil.")";
			$x++;
		}
		if($con->existeCampo("idProcesoPadre",$tablaAsoc)=="")
		{
			$query[$x]="alter table ".$tablaAsoc." add column idProcesoPadre int(11) default -1";
			$x++;
		}
		$query[$x]="commit";
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarConfRepetibleProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$valor=$_POST["valor"]	;
		$consulta="update 4001_procesos set repetible=".$valor." where idProceso=".$idProceso;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerTipoProcesoDisponibles()
	{
		global $con;
		$idPermiso=bD($_POST["idPermiso"]);
		$consulta="select complementario from 977_rolesVSPermisosModulo where idRolesVSPermisosModulo=".$idPermiso;
		$listTipoProc=$con->obtenerValor($consulta);
		if($listTipoProc=="")
			$listTipoProc="-1";

		$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso where idTipoProceso not in (".$listTipoProc.") and  procesoNormal=1 order by tipoProceso";
		$arrTipos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrTipos);
	}
	
	function guardarTipoProcesoPermiso()
	{
		global $con;
		$cadTipoProc=$_POST["cadTipoProc"];
		$idPermiso=bD($_POST["idPermiso"]);
		$consulta="select complementario from 977_rolesVSPermisosModulo where idRolesVSPermisosModulo=".$idPermiso;
		$listTipoProc=$con->obtenerValor($consulta);
		if($listTipoProc=="")
			$listTipoProc=$cadTipoProc;
		else
			$listTipoProc.=",".$cadTipoProc;
		$consulta="update 977_rolesVSPermisosModulo set complementario='".$listTipoProc."' where idRolesVSPermisosModulo=".$idPermiso;
		if(eC($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function removerTipoProceso()
	{
		global $con;
		$idPermiso=bD($_POST["idPermiso"]);
		$idTipoProceso=bD($_POST["idTipoProceso"]);
		$consulta="select complementario from 977_rolesVSPermisosModulo where idRolesVSPermisosModulo=".$idPermiso;
		$listTipoProc=$con->obtenerValor($consulta);
		$arrTipos=explode(",",$listTipoProc);
		$cadTipoProc="";
		foreach($arrTipos as $tipo)
		{
			if($tipo!=$idTipoProceso)
			{
				if($cadTipoProc=="")
					$cadTipoProc.=$tipo;
				else
					$cadTipoProc.=",".$tipo;
			}
		}
		$consulta="update 977_rolesVSPermisosModulo set complementario='".$cadTipoProc."'  where idRolesVSPermisosModulo=".$idPermiso;
		eC($consulta);
	}
	
	function obtenerConfiguracionModuloProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idElementoDTD=$_POST["idElemento"];
		$idProcesoV=$_POST["idProcesoV"];
		$consulta="select complementario from 203_elementosDTD where idElementoDTD=".$idElementoDTD;
		$complementario=$con->obtenerValor($consulta);
		$obj="";
		$actor="";
		$asocRegistro="";
		$mostrarRegistros="";
		$idCampoFormulario="";
		$buscarRolesUsuario=0;
		if($complementario!="")
		{
			$arrComp=explode(",",$complementario);
			$actor=$arrComp[0];
			$asocRegistro=$arrComp[1];
			$mostrarRegistros=$arrComp[2];
			if(isset($arrComp[3]))
				$idCampoFormulario=$arrComp[3];
			if(isset($arrComp[4]))	
				$buscarRolesUsuario=$arrComp[4];
		}
		$opcionesAsoc="['-10','Valor de campo de formulario base'],['0','Responsable de registro del proceso padre']";
		$idFrmAutores=incluyeModulo($idProceso,3);
		
		if(($idFrmAutores!="")&&($idFrmAutores!="-1"))
		{
			$consulta="select complementario from 203_elementosDTD where idFormulario=".$idFrmAutores;
			$compAut=$con->obtenerValor($consulta);
			$arrAutores=explode(",",$compAut);
			$idPerfil=$arrAutores[0];
			$consulta="SELECT idElementoPerfilAutor,descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idPerfilAutor=".$idPerfil." order by descParticipacion";
			$resParticipantes=$con->obtenerFilas($consulta);
			while($filaParticipantes=$con->fetchRow($resParticipantes))
			{
				$obj="['".$filaParticipantes[0]."','Participante: ".$filaParticipantes[1]."']";
				$opcionesAsoc.=','.$obj;
			}
		}
		$consulta="select actor from 950_actorVSProcesoInicio where idProceso=".$idProcesoV;
		$resActor=$con->obtenerFilas($consulta);
		$opcionesActores="";
		while($filaActor=$con->fetchRow($resActor))
		{
			$obj="['".$filaActor[0]."','".obtenerTituloRol($filaActor[0])."']";
			if($opcionesActores=="")
				$opcionesActores=$obj;
			else
				$opcionesActores.=",".$obj;
		}
		$obj='	{
					"actor":"'.$actor.'",
					"asocRegistro":"'.$asocRegistro.'",
					"mostrarRegistro":"'.$mostrarRegistros.'",
					"opcionesAsoc":['.$opcionesAsoc.'],
					"idCampoFrm":"'.$idCampoFormulario.'",
					"buscarRolesUsuario":"'.$buscarRolesUsuario.'",
					"opcionesActores":['.$opcionesActores.']
				}';
		echo "1|[".uEJ($obj)."]";
	}
	
	function guardarConfiguracionModuloProceso()
	{
		global $con;
		$idElementoDTD=$_POST["idElemento"];
		$valor=$_POST["valor"];
		$consulta="update 203_elementosDTD set complementario='".$valor."' where idElementoDTD=".$idElementoDTD;
		eC($consulta);
	}
	
	function guardarRegistroPOA()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idRegistro=$obj->idRegistroPOA;
		if($idRegistro=="")
			$consulta="insert into 9014_registroPOA(idFormulario,idReferencia,objGasto,periodoAplicacion,total,capitulo,tipoPresupuesto,programa) 
						values(".$obj->idFormulario.",".$obj->idRegistro.",'".$obj->objGasto."','".$obj->periodoAplicacion."',".$obj->costoTotal.",'".$obj->capitulo."',
						".$obj->presupuesto.",'".$obj->programa."')";
		else
			$consulta="update 9014_registroPOA set objGasto='".$obj->objGasto."',periodoAplicacion='".$obj->periodoAplicacion."',total=".$obj->costoTotal.",
						tipoPresupuesto=".$obj->presupuesto.",programa='".$obj->programa."' where idRegistroPOA=".$idRegistro;

		if($con->ejecutarConsulta($consulta))
		{
		
			if($idRegistro=="")
				$idRegistro=$con->obtenerUltimoID();
			echo "1|".$idRegistro;	
		}
	}
	
	function eliminarRegistroPOA()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="delete from 9014_registroPOA where idRegistroPOA in(".$idRegistro.")";
		eC($consulta);
	}
	
	function modificarConfRolComite()
	{
		global $con;	
		$evaluado=$_POST["evaluado"];
		$tiempoPermanencia=$_POST["tiempoPermanencia"];
		$idRolVSComite=$_POST["idRolVSComite"];
		$consulta="update 2007_rolesVSComites set evaluado=".$evaluado." and tiempoPermanencia='".$tiempoPermanencia."' where idRolVSComite=".$idRolVSComite;
		eC($consulta);
	}
	
	function obtenerConfRolComite()
	{
		global $con;
		$idRolVSComite=$_POST["idRolComite"];
		$consulta="select evaluado,tiempoPermanencia from 2007_rolesVSComites where idRolVSComite=".$idRolVSComite;
		$filaComite=$con->obtenerPrimeraFila($consulta);
		$arrTiempo=explode("_",$filaComite[1]);
		echo "1|".$filaComite[0]."|".$arrTiempo[0]."|".$arrTiempo[1];	
	}
	
	function cambiarAsociacionAutomaticaActor()
	{
		global $con;
		$valor=$_POST["valor"];
		$idActorAccion=$_POST["idActor"];
		$consulta="update 944_actoresProcesoEtapa set asocAutomatico=".$valor." where idActorProcesoEtapa=".$idActorAccion;	
		eC($consulta);
	}
	
	function obtenerComitesDisponibles()
	{
		global $con;
		$nEtapa=$_POST["etapa"]	;
		$idProceso=bD($_POST["idProceso"]);
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idActorProcesoEtapa from 998_actoresEvaluadoresAsignados where idFormulario=".$idFormulario." and idRegistro=".$idRegistro;
		$listaEvaluadores=$con->obtenerListaValores($consulta);
		if($listaEvaluadores=="")
			$listaEvaluadores="-1";
		$consulta="select idActorProcesoEtapa,nombreComite from 944_actoresProcesoEtapa aE,234_proyectosVSComitesVSEtapas pc,2006_comites c 
					where c.idComite=pc.idComite and pc.idProyectoVSComiteVSEtapa=aE.actor and aE.tipoActor=2 and aE.asocAutomatico=0 and  
					aE.numEtapa=".$nEtapa." and aE.idProceso=".$idProceso." and idActorProcesoEtapa not in (".$listaEvaluadores.")";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos);
		
	}
	
	function guardarAsignacionComites()
	{
		global $con;	
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$cadComites=$_POST["cadComites"];
		$arrComites=explode(",",$cadComites);
		$x=0;	
		$consulta[$x]="begin";
		$x++;
		foreach($arrComites as $comite)
		{
			$consulta[$x]="insert into 998_actoresEvaluadoresAsignados  (idActorProcesoEtapa,idFormulario,idRegistro) values(".$comite.",".$idFormulario.",".$idRegistro.")";
			$x++;	
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select aE.idActorEvaluador,nombreComite from 998_actoresEvaluadoresAsignados aE,944_actoresProcesoEtapa ap,234_proyectosVSComitesVSEtapas pc,2006_comites c  
					where c.idComite=pc.idComite and pc.idProyectoVSComiteVSEtapa=ap.actor and ap.idActorProcesoEtapa=aE.idActorProcesoEtapa and aE.idFormulario=".$idFormulario." and aE.idRegistro=".$idRegistro." order by nombreComite";
			$arrComites=$con->obtenerFilasArreglo($query);
			echo "1|".uEJ($arrComites);
		}
		else
			echo "|";
	}
	
	function removerComites()
	{
		global $con;
		$cadComites=$_POST["cadComites"];
		$consulta="delete from 998_actoresEvaluadoresAsignados where idActorEvaluador in (".$cadComites.")";
		eC($consulta);
	}
	
	function enviarAEtapa()
	{
		global $con;
		$numEtapa=$_POST["nEtapa"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		if(cambiarEtapaFormulario($idFormulario,$idRegistro,$numEtapa))
			echo "1|";
		else
			echo "|";
	}
	
	function crearNuevoUsuario($objParam=null)
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["datosAutor"];
		
		$objJson=json_decode($cadObjJson);
		
		varDUmp($objJson);
		return;
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$prefijo="";
		if(isset($objJson->prefijo))
			$prefijo=$objJson->prefijo;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$codInstitucion="";
		if(isset($objJson->codInstitucion))
			$codInstitucion=$objJson->codInstitucion;
		$codDepto="";
		if(isset($objJson->codDepto))
			$codDepto=$objJson->codDepto;
			
		if(isset($objJson->objDatosOfertaEducativa))	
		{
			$query="SELECT sede FROM 4513_instanciaPlanEstudio where idInstanciaPlanEstudio=".$objJson->objDatosOfertaEducativa->idInstancia;
			$codInstitucion=$con->obtenerValor($query);
		}
		$idIdioma="1";
		$password=generarPassword();
		$sexo=0;
		if(isset($objJson->sexo))
			$sexo=$objJson->sexo;
		$mailUsr=$mail;
		$status="5";
		$telefonos="";
		
		if(isset($objJson->telefonos))
		{
			$telefonos=$objJson->telefonos;
		}
		
		$idProceso=$objJson->idProceso;
		$query="SELECT * FROM 9018_configuracionProcesoRegistro WHERE idProceso=".$idProceso;
		$filaConf=$con->obtenerPrimeraFila($query);
		$solAfiliacion=$filaConf[2];
		$solAceptacion=$filaConf[3];
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma,cuentaActiva,cambiarDatosUsr) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.",0,2)";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$query="SELECT rol FROM 9019_rolesRegistro WHERE idProceso=".$idProceso;
		$resRoles=$con->obtenerFilas($query);
		while($filaRol=$con->fetchRow($resRoles))
		{
			$arrDatos=explode("_",$filaRol[0]);
			$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",".$arrDatos[0].",".$arrDatos[1].",'".$filaRol[0]."')";
			$x++;
		}
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario,Prefijo,Genero,fechaNacimiento) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.",'".$prefijo."',".
					  $sexo.",".(isset($objJson->fechaNacimiento)?"'".$objJson->fechaNacimiento."'":"NULL").")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		if(isset($objJson->direccion))
		{
			$oDireccion=$objJson->direccion;
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo,Calle,Numero,Colonia,CP,Estado,Municipio,NumeroInt) values(".$idUsuario.
							",0,'".cv($oDireccion->calle)."','".cv($oDireccion->noExt)."','".cv($oDireccion->colonia)."',".$oDireccion->cp.",'".cv($oDireccion->estado).
							"','".cv($oDireccion->municipio)."','".cv($oDireccion->noInt)."')";
			$x++;
		}
		else
		{
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
			$x++;
		}
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		if(!isset($objJson->objDatosOfertaEducativa))
		{
			if($telefonos!="")
			{
				$arrTelefonos=explode(",",$telefonos);
				$ct=sizeof($arrTelefonos);
				for($y=0;$y<$ct;$y++)
				{
					$datosTel=explode("_",$arrTelefonos[$y]);
					$tipo=$datosTel[0];
					$codArea=$datosTel[1];
					$lada=$datosTel[2];
					$tel=$datosTel[3];
					$ext=$datosTel[4];
					$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
									values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo.",".$idUsuario.")";
					$x++;
				}
			}
		}
		else
		{
			if($objJson->telCasa!="")
			{
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
									values('','','".$objJson->telCasa."','',0,0,".$idUsuario.")";
				$x++;
			}
			
			if($objJson->telMovil!="")
			{
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
									values('','','".$objJson->telMovil."','',0,1,".$idUsuario.")";
				$x++;
			}
			
			$cadInscripcion='{"idInstanciaPlan":"'.$objJson->objDatosOfertaEducativa->idInstancia.'","idCiclo":"'.$objJson->objDatosOfertaEducativa->idCiclo.
							'","idPeriodo":"'.$objJson->objDatosOfertaEducativa->idPeriodo.'"}';
			$consulta[$x]="INSERT INTO 4573_solicitudesInscripcion(fechaCreacion,idUsuario,datosInscripcion,idCiclo,idPeriodo,idInstancia)
							VALUE('".date("Y-m-d H:i:s")."',".$idUsuario.",'".$cadInscripcion."',".$objJson->objDatosOfertaEducativa->idCiclo.",".$objJson->objDatosOfertaEducativa->idPeriodo.",".
							$objJson->objDatosOfertaEducativa->idInstancia.")";
			$x++;
			$consulta[$x]="set @idRegistroSolicitud:=(select last_insert_id())";
			$x++;
			$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$objJson->objDatosOfertaEducativa->idInstancia;
			$idPlanEstudios=$con->obtenerValor($query);
			$folio=obtenerMatriculaInternaInscripcion($codInstitucion,$idPlanEstudios,$objJson->objDatosOfertaEducativa->idCiclo);
			
			$consulta[$x]="INSERT INTO _678_tablaDinamica(codigo,idReferencia,fechaCreacion,responsable,codigoInstitucion,txtNombre,paterno,materno,datFechaNacimiento,cmbGenero,txtCorreoE,xtTelefonoCasa,txtTelCel,idInstanciaPlan,idCiclo,idPeriodo)
						VALUES('".$folio."',@idRegistroSolicitud,'".date("Y-m-d H:i:s")."',".$idUsuario.",'".$codInstitucion."','".$nombre."','".$apPaterno."','".$apMaterno."','".$objJson->fechaNacimiento."',".$sexo.",'".$mail."','".
						$objJson->telCasa."','".$objJson->telMovil."',".$objJson->objDatosOfertaEducativa->idInstancia.",".$objJson->objDatosOfertaEducativa->idCiclo.",".$objJson->objDatosOfertaEducativa->idPeriodo.")";
			$x++;						
		}
		$consulta[$x]="commit";
		$x++;
		

		if($con->ejecutarBloque($consulta))		
		{
			$query="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr 
					from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$idUsuario;
			$fila=$con->obtenerPrimeraFila($query);
			
			
			
			$query="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
			$resRoles=$con->obtenerFilas($query);
			$listaGrupo="";
			while($fRoles=$con->fetchRow($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			
			$link="<a href='".$urlSitio."/registroUsuario/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario)."'>".$urlSitio."/registroUsuario/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario)."</a>";
			$arrParametros='[
								["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
								["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
								["$nombre","'.$nombre.'"],["$prefijo","'.$prefijo.'"]
							]';
			$query="SELECT idGrupoMensaje,remitente FROM 9020_mensajesAccionProceso WHERE idProceso=".$idProceso." AND numEtapa=1";
			$fMensaje=$con->obtenerPrimeraFila($query);			
			$idCircular=$fMensaje[0];				
			if($idCircular!="")
			{
				$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idCircular":"'.$idCircular.'"}';
				if(enviarMailProceso($objEnvio,$fMensaje[1]))
					echo "1|";
				else
					echo "|";
			}
			else
				echo "1|";
		}
		else
			echo "|";
	}
	
	function existeMail()
	{
		global $con;
		$mail=$_POST["mail"];
		$tIdentificacion=$_POST["tIdentificacion"];
		$noIdentificacion=$_POST["noIdentificacion"];
		
		//$consulta="SELECT COUNT(*) FROM _47_tablaDinamica WHERE tipoIdentificacion=".$tIdentificacion." AND folioIdentificacion='".cv($noIdentificacion)."'";
		$consulta="SELECT COUNT(*) FROM 802_identifica WHERE tipoIdentificacion=".$tIdentificacion." AND noIdentificacion='".cv($noIdentificacion)."'";
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
			echo "3|";
		$consulta="select idMail from 805_mails where Mail='".$mail."'";
		$filaMail=$con->obtenerPrimeraFila($consulta);
		if($filaMail)
			echo "2|";
		else
			echo "1|";
	}
	
	function guardarDatosProcesoRegistro()
	{
		global $con;	
		$obj=json_decode($_POST["obj"]);
		$accion=1;
		$txtTitulo=$obj->txtTitulo;
		$sAfiliacion=$obj->sAfiliacion;
		$sNormas=$obj->sNormas;
		$normas=($obj->normas);
		$listRoles=$obj->listRoles;
		$idProceso=$obj->idProceso;
		$query="select * from 9018_configuracionProcesoRegistro where idProceso=".$idProceso;
		$filaProceso=$con->obtenerPrimeraFila($query);
		if($filaProceso)
			$accion=0;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($accion==1)
		{
			$consulta[$x]="insert into 9018_configuracionProcesoRegistro(titulo,solDatosAfiliacion,solAceptacionNormal,normasSitio,idProceso)
							values('".cv($txtTitulo)."',".$sAfiliacion.",".$sNormas.",'".cv($normas)."',".$idProceso.")";	
		}
		else
		{
			$consulta[$x]="update 9018_configuracionProcesoRegistro set titulo='".cv($txtTitulo)."',solDatosAfiliacion=".$sAfiliacion.",
							solAceptacionNormal=".$sNormas.",normasSitio='".cv($normas)."' where idProceso=".$idProceso;
		}
		$x++;
		$consulta[$x]="delete from 9019_rolesRegistro where idProceso=".$idProceso;
		$x++;
		if($listRoles!="")
		{
			$arrRoles=explode(",",$listRoles);
			foreach($arrRoles as $rol)
			{
				$consulta[$x]="insert into 9019_rolesRegistro(idProceso,rol) values(".$idProceso.",'".$rol."')";
				$x++;	
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerParametrosAutomaticosProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$tProceso=obtenerTipoProceso($idProceso);
		$consulta="select valor,parametro from 9021_parametrosMensajesProceso p,9022_parametrosMensajeTipoProceso pm 
					where p.idParametro=pm.idParametro and pm.idTipoProceso=".$tProceso." and p.tipoParametro=2 ";
		$arrParam=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrParam);
	}
	
	function obtenerCamposFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$consulta="SELECT idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND tipoElemento IN (2,3,4,14,15,16)";
		$arrCampo=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrCampo);
	}
	
	
	
	function obtenerParametrosFuncion()
	{
		global $con;
		$idFuncion=$_POST["idFuncion"];
		$idInvocacion=$_POST["idInvocacion"];
		$arrParam="";
		$consulta="SELECT parametro FROM 9034_parametrosFuncionesSistema WHERE idFuncion=".$idFuncion." ORDER BY idParametro";
		$resParam=$con->obtenerFilas($consulta);
		if($idInvocacion=="-1")
		{
			while($fila=$con->fetchRow($resParam))
			{
				$obj="['".$fila[0]."','','','','0']";
				if($arrParam=="")
					$arrParam=$obj;
				else
					$arrParam.=",".$obj;
			}
		}
		echo "1|[".$arrParam."]";
			
	}
	
	function generarConsultaAlmacenProceso()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
			
	}
	
	function guardarFechaProyecto()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="select idFechaProyecto from 9038_fechasControlProyectos where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia;
		$idFechaProyecto=$con->obtenerValor($consulta);
		
		if($idFechaProyecto=="")
			$consulta="insert into 9038_fechasControlProyectos(idFormulario,idReferencia,fechaInicio,fechaFin) values(".$obj->idFormulario.",".$obj->idReferencia.",'".$obj->fechaInicio."','".$obj->fechaFin."')";
		else
		{
			//SELECT fechaInicio,fechaFin FROM 965_actividadesUsuario WHERE idReferencia= AND idFormulario=
			$consulta="update 9038_fechasControlProyectos set fechaInicio='".$obj->fechaInicio."',fechaFin='".$obj->fechaFin."' where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";	
		}
		
		
			
	}
	
	function obtenerMiembrosComite()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$etapaReg=$_POST["etapaReg"];
		$idActor=$_POST["idActor"];
		$consulta="SELECT COUNT(etapaActual)-1 AS versionRegistro FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$etapaReg." AND idFormulario=".$idFormulario." AND idRegistro=".$idReferencia;
		$nVersion=$con->obtenerValor($consulta);
		if($nVersion=="-1")
			$nVersion=0;
		
		$consulta="select a.idUsuarioRevisor from 955_revisoresProceso a where  a.idFormulario=".$idFormulario." and a.idReferencia=".$idReferencia."
			and a.estado in (0,1,2) and idActorProcesoEtapa=".$idActor." and a.versionRegistro=".$nVersion;
		$listaUsuario=$con->obtenerListaValores($consulta);
		if($listaUsuario=="")
			$listaUsuario="'-1'";
		
		$consulta="SELECT rol FROM 2007_rolesVSComites WHERE idComite=".$idComite;
		$listaRol=$con->obtenerListaValores($consulta,"'");
		if($listaRol=="")
			$listaRol="'-1'";
		$consulta="SELECT distinct(i.Nombre),u.idUsuario FROM 802_identifica i,807_usuariosVSRoles u WHERE u.idUsuario=i.idUsuario AND 
					u.codigoRol IN (".$listaRol.") and u.idUsuario not in (".$listaUsuario.") order by i.Nombre";
					
		$resMiembro=$con->obtenerFilas($consulta);
		$arrMiembros="";
		while($fila=$con->fetchRow($resMiembro))
		{
			$roles="";
			
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[1]." and codigoRol in (".$listaRol.")";
			$resRol=$con->obtenerFilas($consulta);
			while($fRol=$con->fetchRow($resRol))
			{
				if($roles=="")	
					$roles=obtenerTituloRol($fRol[0]);
				else
					$roles.=",".obtenerTituloRol($fRol[0]);
			}
			
			$obj="['".$fila[1]."','".$fila[0]."','".$roles."']";
			if($arrMiembros=="")
				$arrMiembros=$obj;
			else
				$arrMiembros.=",".$obj;
		}
		echo "1|[".uEJ($arrMiembros)."]";
	}
	
	function asignarPresentador()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAutor=$_POST["idAutor"];
		$versionRegistro=$_POST["versionRegistro"];
		$idActor=base64_decode($_POST["idActor"]);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="update 955_revisoresProceso set presentador=0 where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." 
					and idActorProcesoEtapa=".$idActor." and versionRegistro= ".$versionRegistro;
		$x++;
		if($idAutor!="-1")
		{
			$query[$x]="update 955_revisoresProceso set presentador=1 where idUsuarioRevisor=".$idAutor." and idFormulario=".$idFormulario." and idReferencia=".$idRegistro." 
					and idActorProcesoEtapa=".$idActor." and versionRegistro= ".$versionRegistro;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function guardarDatosCampoGrid()
	{
		global $con;
		$obj=json_decode($_POST["cadObj"]);
		$idElemento=$obj->idElemento;
		$idRegistro=$obj->idRegistro;
		$idReferencia=$obj->idReferencia;
		$listCampos="";
		$listValores="";
		$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
		$filaConf=$con->obtenerPrimeraFila($consulta);
		$nTabla=$filaConf[4];
		
		$reflectionClase = new ReflectionObject($obj);
		
		if(($idRegistro=="-1")||($idRegistro==""))
		{
			$listCampos="idReferencia";
			$listValores=$idReferencia;
			foreach ($reflectionClase->getProperties() as $property => $value) 
			{
				$nombre=$value->getName();
				$valor="'".$value->getValue($obj)."'";
				if($valor=="''")
					$valor="NULL";
				if(($nombre!="idElemento")&&($nombre!="idRegistro")&&($nombre!="idReferencia"))
				{
					$listCampos.=",".$nombre;
					$listValores.=",".$valor;
					
				}
				
			}
			
			
			$consulta="insert into ".$nTabla."(".$listCampos.") values(".$listValores.")";
		}
		else
		{
			
			foreach ($reflectionClase->getProperties() as $property => $value) 
			{
				$nombre=$value->getName();
				$valor="'".$value->getValue($obj)."'";
				if($valor=="''")
					$valor="NULL";
				if(($nombre!="idElemento")&&($nombre!="idRegistro")&&($nombre!="idReferencia"))
				{
					if($listValores=="")
						$listValores=$nombre."=".$valor;
					else
						$listValores.=",".$nombre."=".$valor;
				}
			}
			
			$campoID=obtenerCampoIDTabla($nTabla);
			$consulta="update ".$nTabla." set ".$listValores." where ".$campoID."=".$idRegistro;

		}
		//echo $consulta;
		if($con->ejecutarConsulta($consulta))		
		{
			if($idRegistro=="-1")
				$idRegistro=$con->obtenerUltimoID();
				
			echo "1|".$idRegistro;
		}
		else
			echo "|";
	}

	
	function eliminarRegistroCampoGrid()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
		$filaConf=$con->obtenerPrimeraFila($consulta);
		$nTabla=$filaConf[4];
		$campoID=obtenerCampoIDTabla($nTabla);
		$consulta="delete from ".$nTabla." where ".$campoID."=".$idRegistro;
		eC($consulta);
	}

	
	function guardarFechasConvocatoria()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$fIniP=$_POST["fIniP"];
		$fFinP=$_POST["fFinP"];
		$fIniR=$_POST["fIniR"];
		if($fIniR!="NULL")
			$fIniR="'".$fIniR."'";
		$fFinR=$_POST["fFinR"];
		if($fFinR!="NULL")
			$fFinR="'".$fFinR."'";		
		$fIniE=$_POST["fIniE"];
		if($fIniE!="NULL")
			$fIniE="'".$fIniE."'";		
		$fFinE=$_POST["fFinE"];
		if($fFinE!="NULL")
			$fFinE="'".$fFinE."'";
		$ciclo=$_POST["ciclo"];		
		
		
		$conExiste="SELECT idConvocatoriaFecha FROM 9042_formularioVSFechasConvocatoria WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$id=$con->obtenerValor($conExiste);
		
		if($id=="")
		{
			$query="INSERT INTO 9042_formularioVSFechasConvocatoria(idFormulario,idReferencia,fechaIniPublicacion,fechaFinPublicacion,fechaIniRegistro,fechaFinRegistro,fechaIniEvaluacion,fechaFinEvaluacion,cicloAplica)
					VALUES('".$idFormulario."','".$idRegistro."','".$fIniP."','".$fFinP."',".$fIniR.",".$fFinR.",".$fIniE.",".$fFinE.",".$ciclo.")";
		}
		else
		{
			$query="UPDATE 9042_formularioVSFechasConvocatoria SET cicloAplica=".$ciclo.",fechaIniPublicacion='".$fIniP."',fechaFinPublicacion='".$fFinP."',fechaIniRegistro=".$fIniR.",fechaFinRegistro=".$fFinR.",fechaIniEvaluacion=".$fIniE.",fechaFinEvaluacion=".$fFinE." WHERE idConvocatoriaFecha=".$id;
		}
		
		//echo $query;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerProcesoPorTipo()
	{
		global $con;
		$idTipoProceso=$_POST["idTipoProceso"];
		$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$idTipoProceso." order by nombre";
		$arrObjetos=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arrObjetos)."";
	}
	
	function guardarProcesoVinculadoConvocatoria()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idRegProceso=$obj->idRegProceso;
		if((!isset($obj->tipoRegistro)||($obj->tipoRegistro!=1)))
		{
			if($idRegProceso=="-1")
				$consulta="insert into 9043_procesosVinculadosConvocatoria(idFormulario,idReferencia,idProceso) values(".$obj->idFormulario.",".$obj->idReferencia.",".$obj->idProceso.")";
			else
				$consulta="update 9043_procesosVinculadosConvocatoria set idProceso=".$obj->idProceso." where idProcesoVinculado=".$obj->idRegProceso;
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="select idProcesoVinculado,p.idTipoProceso,p.idProceso,p.nombre from 9043_procesosVinculadosConvocatoria c,4001_procesos p where p.idProceso=c.idProceso and idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia;
				$arrProcesos=$con->obtenerFilasArreglo($consulta);
				echo "1|".$arrProcesos;	
			}
		}
		else
		{
			if($idRegProceso=="-1")
				$consulta="INSERT INTO 9043_procesoConvocatoriaVsProcesosVinculados(idProcesoConvocatoria,idProcesoAsociado) VALUES(".$obj->idProcesoConvocatoria.",".$obj->idProceso.");";
			else
				$consulta="update 9043_procesoConvocatoriaVsProcesosVinculados set idProcesoAsociado=".$obj->idProceso." where idProcesoConvVSProceso=".$obj->idRegProceso;

			if($con->ejecutarConsulta($consulta))
			{
				$consulta="select idProcesoConvVSProceso,p.idTipoProceso,p.idProceso,p.nombre from 9043_procesoConvocatoriaVsProcesosVinculados c,4001_procesos p where p.idProceso=c.idProcesoAsociado and idProcesoConvocatoria=".$obj->idProcesoConvocatoria;
				$arrProcesos=$con->obtenerFilasArreglo($consulta);
				echo "1|".$arrProcesos;	
			}
		}
	}
	
	function eliminarProcesoVinculadoConvocatoria()
	{
		global $con;
		$idRegProceso=$_POST["idRegProceso"];
		$consulta="delete from 9043_procesosVinculadosConvocatoria where idProcesoVinculado in (".$idRegProceso.")";
		eC($consulta);
	}
	
	function actualizarDatosConvocatoria()
	{
		global $con;
		$valor=$_POST["valor"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9044_datosConvocatoria where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$x++;
		$consulta[$x]="insert into 9044_datosConvocatoria(idFormulario,idReferencia,vincularProcesoRegistroEnLinea) values(".$idFormulario.",".$idReferencia.",".$valor.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function actualizarProcesoPresupuesto()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$tipoReq=$_POST["tipoReq"];
		$consulta="update 9043_confProcesoPresupuesto set requisicionPor=".$tipoReq." where idProceso=".$idProceso;
		eC($consulta);
	}	
	
	function obtenerCapitulosDisponibles()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT capitulo FROM 9044_capitulosProcesoPresupuesto WHERE idProcesoPresupuesto=".$idProceso;
		$listProcesos=$con->obtenerListaValores($consulta,"'");
		if($listProcesos=="")
			$listProcesos="-1";
		$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where codigoControl not in (".$listProcesos.") and nivel=1";

		$arrCapitulos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCapitulos;
		
	}
	
	function agregarCapitulosProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadCapitulos=$_POST["cadCapitulos"];
		$arrCapitulos=explode(",",$cadCapitulos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrCapitulos as $c)
		{
			$consulta[$x]="insert into 9044_capitulosProcesoPresupuesto(idProcesoPresupuesto,capitulo) values(".$idProceso.",'".$c."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerCapitulosProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadCapitulos=$_POST["cadCapitulos"];
		$consulta="delete from 9044_capitulosProcesoPresupuesto where idProcesoPresupuesto=".$idProceso." and capitulo in (".$cadCapitulos.")";
		eC($consulta);
	}
	
	function removerRolProcesoPresupesto()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$rol=$_POST["rol"];
		$tActor=$_POST["tActor"];
		$tipoEliminacion=$_POST["tipoEliminacion"];
		$consulta="delete from 9045_actoresProcesoPresupuesto where actor='".$rol."' and tipoActor=".$tActor." and etapa=".$tipoEliminacion." and idProceso=".$idProceso;
		eC($consulta);
	}
	
	function agregarRolPresupuesto()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$rol=$_POST["rol"];
		$tActor=$_POST["tActor"];
		$etapa=$_POST["etapa"];
		$consulta="insert into 9045_actoresProcesoPresupuesto(actor,tipoActor,etapa,idProceso) values('".$rol."',".$tActor.",".$etapa.",".$idProceso.")";
		eC($consulta);
	}
	
	function guardarOpcionesEvaluacion()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$objOpciones=$_POST["objOpciones"];
		$oOpciones=json_decode($objOpciones);
		$opciones=$oOpciones->opciones;
		$nOpciones=sizeof($opciones);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9114_opcionesEvaluacion where idAccion=".$idAccion;
		$x++;
		for($ct=0;$ct<$nOpciones;$ct++)
		{
			$opcion=$opciones[$ct];
			$vOpcion=$opcion->vOpcion;
			$pasaEtapa=$opcion->etapa;
			$columnas=$opcion->columnas;
			$nColumnas=sizeof($columnas);
			for($ct2=0;$ct2<$nColumnas;$ct2++)
			{
				$columna=$columnas[$ct2];
				$idIdioma=$columna->idLeng;
				$texto=$columna->texto;
				$consulta[$x]="insert into 9114_opcionesEvaluacion(contenido,valor,idIdioma,etapa,idAccion) values('".cv($texto)."','".cv($vOpcion)."',".$idIdioma.",".$pasaEtapa.",".$idAccion.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerOpcionesEvaluacionSolicitud()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$consulta="select valor, contenido,etapa from 9114_opcionesEvaluacion where idIdioma=".$_SESSION["leng"]." and idAccion=".$idAccion." order by valor";	
		echo "1|".uEJ($con->obtenerFilasArreglo($consulta));
	}
	
	function cambiarAmbitoAsignacion()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$tipoOpcion=$_POST["tipoOpcion"];
		$valor=$_POST["valor"];
		$consulta="select complementario from 949_actoresVSAccionesProceso where idActorVSAccionesProceso=".$idAccion;
		$comp=$con->obtenerValor($consulta);
		$arrComp=explode("_",$comp);
		$arrComp[$tipoOpcion]=$valor;
		$consulta="update 949_actoresVSAccionesProceso set complementario='".$arrComp[0]."_".$arrComp[1]."_".$arrComp[2]."' where idActorVSAccionesProceso=".$idAccion;
		eC($consulta);
		
	}
	
	function validarFormulario()
	{
		global $con;
		$cadObj=$_POST["obj"];	
		$obj=json_decode($cadObj);
		$consulta="SELECT funcionValidacion,tipoFuncion,camposEnvio FROM 900_funcionesValidacion WHERE idFuncionValidacion=".$obj->idFuncion;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		$res="";
		if($fila)
		{
			switch($fila[1])
			{
				case 0:
					$arrCampos=explode(",",$fila[2]);
					$param="";
					if(sizeof($arrCampos)>0)
					{
						foreach($arrCampos as $campo)
						{
							if($param=="")
								$param='$obj->'.$campo;	
							else
								$param.=',$obj->'.$campo;	
						}
					}
					eval ('$res='.$fila[0]."(".$param.");");

					if($res=="[]")
						$res="1|";
				break;
			}
		}
		else
		{
			$res="La funci&oacute;n de validaci&oacute;n  no ha sido definida o ha sido borrada del sistema, favor de contactar con el adminitrador del sitio";
			
		}
		echo  $res;
	}
	
	function registrarAccionUsuarioRegistro()
	{
		global $con;
		$idUsuario=bD($_POST["idUsuario"]);
		$idFormulario=bD($_POST["idFormulario"]);
		$idRegistro=bD($_POST["idRegistro"]);
		$accion=$_POST["accion"];
		$complementario=$_POST["complementario"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		switch($accion)
		{
			case "-1": //Soy soy autor
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',1,'')";
				$x++;								
			break;	
			case "1":  //cancelar solicutud de No soy autor
				$consulta[$x]="update 9202_accionesSolicitudUsuario set estado=0 where idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and idUsuario=".$idUsuario." and accion=-1 and estado=1";
				$x++;		
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',0,'')";
				$x++;														
			break;
			case "2": //Enviar comentario admon
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',1,'')";
				$x++;		
			break;
			case "3": //Inscribir producto convocatoria
				$consulta[$x]="INSERT INTO 9201_productosUsuarioConvocatoria(idUsuario,idFormulario,idRegistro,fechaInscripcion,idConvocatoria)
								VALUES(".$idUsuario.",".$idFormulario.",".$idRegistro.",'".date("Y-m-d")."',".$complementario.")";
				$x++;
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',0,'')";
				$x++;	
			break;
			case "4": //DesInscribir producto convocatoria
				$consulta[$x]="delete from  9201_productosUsuarioConvocatoria where idUsuario=".$idUsuario." and idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and idConvocatoria=".$complementario;
				$x++;
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',0,'')";
				$x++;	
			break;
			case "5":
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',1,'')";
				$x++;	
			break;
			case "6":
				$consulta[$x]="update 9202_accionesSolicitudUsuario set estado=0 where idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and idUsuario=".$idUsuario." and accion=5 and estado=1";
				$x++;		
				$consulta[$x]="INSERT INTO 9202_accionesSolicitudUsuario(accion,idFormulario,idRegistro,idUsuario,fechaSolicitud,complementario,estado,comentario)
								VALUES(".$accion.",".$idFormulario.",'".$idRegistro."',".$idUsuario.",'".date('Y-m-d')."','".$complementario."',0,'')";
				$x++;	
			break;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
	}
	
	function obtenerElementosConvocatoriaEstructura()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select ep.idElementoConvocatoria,p.nombre,ep.idElemento,ep.idConfiguracion,p.idProceso from 9001_elementosProceso ep,4001_procesos p where p.idProceso=ep.idElemento and ep.idProceso=".$idProceso." order by p.nombre";
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		//$sP=0;
		while($fila=$con->fetchRow($res))
		{
			$arrHijos="[]";
			$idConfElemento=$fila[3];
			if($idConfElemento=="")
				continue;
			$consulta="SELECT * FROM 9002_confElementoConvocatoria WHERE idConfElemento=".$idConfElemento;
			$filaConf=$con->obtenerPrimeraFila($consulta);
			if($filaConf)
				$arrHijos=obtenerHijoNivel($idConfElemento,1,$fila[4],$filaConf,$fila[4],$idProceso);
			$puntos="";
			$textAux="";
			$oculto='false';
			$maximo="";
			$lblMaximo="";
			if($arrHijos!="[]")
			{
				$comp="leaf:false,children:".$arrHijos;
			}
			else
			{
				$comp="leaf:true";		
				$consulta="SELECT puntos,numProductosMaximo FROM 9004_ponderacionesConvocatoria WHERE idProceso=".$idProceso." AND ruta='".$fila[0]."'";
				$fPuntos=$con->obtenerPrimeraFila($consulta);
				if($fPuntos)
				{
					$puntos=$fPuntos[0];
					$maximo=$fPuntos[1];
				}
				else
				{
					$puntos=0;
					$maximo=0;
				}
				$puntos=$con->obtenerValor($consulta);
				if($puntos=="")
					$puntos="0";
				$lblMaximo=$maximo;
				if($maximo==0)
					$lblMaximo="Abierto";
				/*if(($puntos==0)&&($sP==1))
					$oculto='true';*/
				$textAux="(<span class=\"copyrigthSinPadding\">Puntos:  <span id=\"sp".$fila[0]."\">".$puntos.", M&aacute;x. productos: ".$lblMaximo."</span></span>)";
			}
			$nodo="{
						id:'".$fila[0]."',
						text:'".uEJ($fila[1])." ".$textAux."',
						icon:'../images/bullet_green.png',
						idConf:'".$idConfElemento."',
						draggable:false,".$comp.",
						allowDrop:false,
						idProcesoRef:".$fila[4].",
						tipo:'0',
						puntos:'".$puntos."',
						maximo:'".$maximo."'
					}";
			if($arrNodos=="")
				$arrNodos=$nodo;
			else
				$arrNodos.=",".$nodo;
		}
		echo "[".$arrNodos."]";
	}
	
	function obtenerHijoNivel($idConf,$orden,$ruta,$fConf,$idProcesoInv,$idProcesoConv)
	{
		global $con;
		$consulta="SELECT tElemento FROM 9003_configuracionOrdenElemento WHERE idConf=".$idConf." AND orden=".$orden;
		$tElemento=$con->obtenerValor($consulta);
		$arrNodos=array();
		$listNodos="";	
		
		if($tElemento!="")
		{
			switch($tElemento)
			{
				case "1":
					if($fConf[3]!="-1")
						$arrNodos=obtenerOpcionesElemento($fConf[3]);
					
				break;
				case "2":
					if($fConf[5]!="-1")
						$arrNodos=obtenerOpcionesElemento($fConf[5]);
				break;
				case "3":
					$idProceso=$idProcesoInv;
					$idFrmAutores=incluyeModulo($idProceso,3);
					
					if($idFrmAutores!="-1")
					{
						$consulta="SELECT complementario FROM 203_elementosDTD WHERE idFormulario=".$idFrmAutores;
						$complementario=$con->obtenerValor($consulta);
						$arrComp=explode(",",$complementario);
						$idPerfil=$arrComp[0];
						$consulta="SELECT idElementoPerfilAutor,descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idPerfilAutor=".$idPerfil." order by descParticipacion";
						$arrNodos=$con->obtenerFilasArregloPHP($consulta);
					}
				break;
				case "4":
					$consulta="SELECT idNivelInsvestigador,nivel FROM 9007_nivelInvestigador ORDER BY nivel";
					$arrNodos=$con->obtenerFilasArregloPHP($consulta);
				break;	
			}
			
			foreach($arrNodos as $nodo)
			{
				$arrHijos=obtenerHijoNivel($idConf,($orden+1),$ruta."_".$nodo[0],$fConf,$idProcesoInv,$idProcesoConv);
				$puntos="";
				$textAux="";
				$maximo="";
				$lblMaximo="";
				if($arrHijos!="[]")
					$comp="leaf:false,children:".$arrHijos;
				else
				{
					$comp="leaf:true";		
					$consulta="SELECT puntos,numProductosMaximo FROM 9004_ponderacionesConvocatoria WHERE idProceso=".$idProcesoConv." AND ruta='".$ruta."_".$nodo[0]."'";
					$fPuntos=$con->obtenerPrimeraFila($consulta);
					if($fPuntos)
					{
						$puntos=$fPuntos[0];
						$maximo=$fPuntos[1];
					}
					else
					{
						$puntos=0;
						$maximo=0;
					}
					$puntos=$con->obtenerValor($consulta);
					if($puntos=="")
						$puntos="0";
					$lblMaximo=$maximo;
					if($maximo==0)
						$lblMaximo="Abierto";
					/*if(($puntos==0)&&($sP==1))
						$oculto='true';*/
					$textAux="(<span class=\"copyrigthSinPadding\">Puntos:  <span id=\"sp".$ruta."_".$nodo[0]."\">".$puntos.", M&aacute;x. productos: ".$lblMaximo."</span></span>)";
				}
				$nodo="{
							id:'".$ruta."_".$nodo[0]."',
							text:'".uEJ($nodo[1])." ".$textAux."',
							icon:'../images/bullet_green.png',
							draggable:false,
							allowDrop:false,".$comp.",
							idProcesoRef:".$fConf[0].",
							puntos:'".$puntos."',
							maximo:'".$maximo."'
						}";
				if($listNodos=="")
					$listNodos=$nodo;
				else
					$listNodos.=",".$nodo;
			}
		}
		return "[".$listNodos."]";
			
	}
	
	function guardarOrdenElementoConvocatoria()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);	
		$query="SELECT idConfOrdenElemento FROM 9003_configuracionOrdenElemento WHERE idConf=".$obj->idConf." AND tElemento=".$obj->tValor;
		$fila=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9004_ponderacionesConvocatoria where idProceso=".$obj->idProceso;
		$x++;
		if($fila)
			$consulta[$x]="update 9003_configuracionOrdenElemento set orden=".$obj->orden." where idConfOrdenElemento=".$fila[0];
		else
			$consulta[$x]="insert into 9003_configuracionOrdenElemento(idConf,tElemento,orden) value(".$obj->idConf.",".$obj->tValor.",".$obj->orden.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarPuntajeCriterio()
	{
		global $con;
		$ruta=$_POST["ruta"];
		$proceso=$_POST["proceso"];
		$valor=$_POST["valor"];
		$maximo=$_POST["maximo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9004_ponderacionesConvocatoria where ruta='".$ruta."' and idProceso=".$proceso;	
		$x++;
		$consulta[$x]="insert into 9004_ponderacionesConvocatoria(idProceso,ruta,puntos,numProductosMaximo) values(".$proceso.",'".$ruta."',".$valor.",".$maximo.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarConfiguracionModuloDTD()
	{
		global $con;	
		$idModulo=$_POST["idModulo"];
		$idProceso=$_POST["idProceso"];
		$configuracion=$_POST["conf"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 203_configuracionModuloDTD WHERE idModulo=".$idModulo." AND idProceso=".$idProceso;
		$x++;
		$consulta[$x]="insert into 203_configuracionModuloDTD(idModulo,idProceso,configuracion) values(".$idModulo.",".$idProceso.",'".cv($configuracion)."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}	
	
	function guardarProcesoDefaultValor()
	{
		global $con;
		$idProceso=$_POST["idProceso"]	;
		$cadObj=$_POST["obj"];
		$consulta="update 4001_procesos SET valoresDefault='".$cadObj."' WHERE idProceso=".$idProceso;
		eC($consulta);
	}
	
	function guardarNoticacionCambio()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="insert into 100_reporteCambios(idProyecto,fechaConfirmacion) VALUES(".$idProyecto.",'".date('Y-m-d')."')";
		eC($consulta);
	}
	
	function obtenerPartidasProcesoDisponible()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$capitulo=$_POST["capitulo"];
		$consulta="SELECT partidas FROM 9044_capitulosProcesoPresupuesto WHERE idProcesoPresupuesto=".$idProceso." AND capitulo=".$capitulo;
		$listPartidas=$con->obtenerValor($consulta);
		if($listPartidas=="")
			$listPartidas="-1";	
		
		$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where clave not in (".$listPartidas.") and codigoControlPadre like '".$capitulo."%' and nivel=3";
		$arrPartidasDisp=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPartidasDisp;
	}
	
	function guardarPartidasProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$capitulo=$_POST["capitulo"];
		$listPartidas=$_POST["listPartidas"];
		$interfaceSolicitud=$_POST["interface"];
		
		$arrPartidas=explode(",",$listPartidas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPartidas  as $p)
		{
			$consulta[$x]="INSERT INTO 9044_capitulosProcesoPresupuesto(idProcesoPresupuesto,capitulo,partidas,tipoInterfaceSolicitud) VALUES(".$idProceso.",'".$capitulo."','".$p."',".$interfaceSolicitud.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta,false))
		{
			$consulta1="select distinct o.codigoControl,concat('[',o.clave,'] ',o.nombreObjetoGasto) from 507_objetosGasto o,9044_capitulosProcesoPresupuesto c where o.codigoControl=c.capitulo and c.idProcesoPresupuesto=".$idProceso;
			$arrCapitulos="";
			$resCapitulos=$con->obtenerFilas($consulta1);
			while($fCapitulo=$con->fetchRow($resCapitulos))
			{
				$tabla="";
				$consulta="SELECT partidas,tipoInterfaceSolicitud FROM 9044_capitulosProcesoPresupuesto WHERE capitulo='".$fCapitulo[0]."' AND idProcesoPresupuesto=".$idProceso." AND tipoInterfaceSolicitud IS NOT null";
				$resPartidas=$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					$tabla='<table>';
					while($fPartida=$con->fetchRow($resPartidas))
					{
						$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where codigoControl ='".$fPartida[0]."'";
						$nObjetoGasto=$con->obtenerPrimeraFila($consulta);
						$consulta="select tipoInterfaceDeteccion FROM 1000_interfacesDeteccionNecesidades WHERE idTipoInterfaceDeteccion=".$fPartida[1];
						$nInterface=$con->obtenerValor($consulta);
						$tabla.='<tr><td width="20"><a href="javascript:removerPartida(\\\''.bE($fPartida[0]).'\\\',\\\''.bE($nObjetoGasto[0]).'\\\')"><img src="../images/delete.png" title="Remover partida" alt="Remover partida"></a></td><td><span class="copyrigthSinPaddingNegro">'.$nObjetoGasto[1].'</span></td><td width=10></td><td width=250 align="left"><span class="letraExt"><b>Tipo de Interface: </b> '.$nInterface.'</span> </td></tr>';
						
					}
					$tabla.='<table>';
				}
				$obj="['".$fCapitulo[0]."','".$fCapitulo[1]."','".$tabla."']";
				if($arrCapitulos=="")
					$arrCapitulos=$obj;
				else
					$arrCapitulos.=",".$obj;
			}
			$arrCapitulos="[".$arrCapitulos."]";	
			echo "1|".$arrCapitulos;
		}
	}
	
	function removerPartida()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$capitulo=$_POST["capitulo"];
		$partida=$_POST["partida"];
		
		$consulta="DELETE FROM 9044_capitulosProcesoPresupuesto WHERE partidas='".$partida."' AND idProcesoPresupuesto=".$idProceso;

		if($con->ejecutarConsulta($consulta))
		{
			$consulta1="select distinct o.codigoControl,concat('[',o.clave,'] ',o.nombreObjetoGasto) from 507_objetosGasto o,9044_capitulosProcesoPresupuesto c where o.codigoControl=c.capitulo and c.idProcesoPresupuesto=".$idProceso;
			$arrCapitulos="";
			$resCapitulos=$con->obtenerFilas($consulta1);
			while($fCapitulo=$con->fetchRow($resCapitulos))
			{
				$tabla="";
				$consulta="SELECT partidas,tipoInterfaceSolicitud FROM 9044_capitulosProcesoPresupuesto WHERE capitulo='".$fCapitulo[0]."' AND idProcesoPresupuesto=".$idProceso." AND tipoInterfaceSolicitud IS NOT null";
				$resPartidas=$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					$tabla='<table>';
					while($fPartida=$con->fetchRow($resPartidas))
					{
						$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where codigoControl ='".$fPartida[0]."'";
						$nObjetoGasto=$con->obtenerPrimeraFila($consulta);
						$consulta="select tipoInterfaceDeteccion FROM 1000_interfacesDeteccionNecesidades WHERE idTipoInterfaceDeteccion=".$fPartida[1];
						$nInterface=$con->obtenerValor($consulta);
						$tabla.='<tr><td width="20"><a href="javascript:removerPartida(\\\''.bE($fPartida[0]).'\\\',\\\''.bE($nObjetoGasto[0]).'\\\')"><img src="../images/delete.png" title="Remover partida" alt="Remover partida"></a></td><td><span class="copyrigthSinPaddingNegro">'.$nObjetoGasto[1].'</span></td><td width=10></td><td width=250 align="left"><span class="letraExt"><b>Tipo de Interface: </b> '.$nInterface.'</span> </td></tr>';
						
					}
					$tabla.='<table>';
				}
				$obj="['".$fCapitulo[0]."','".$fCapitulo[1]."','".$tabla."']";
				if($arrCapitulos=="")
					$arrCapitulos=$obj;
				else
					$arrCapitulos.=",".$obj;
			}
			$arrCapitulos="[".$arrCapitulos."]";
			echo "1|".$arrCapitulos;
			
		}
		
	}
	
	function agregarMovimientoProceso()
	{
		global $con;	
		$idProceso=$_POST["idProceso"];
		$idMovimiento=$_POST["idMovimiento"];
		$cadObj='';
		$consulta="INSERT INTO 901_configuracionMovimientosProceso(idMovimiento,idProceso,configuracion) values(".$idMovimiento.",".$idProceso.",'".$cadObj."')";
		eC($consulta);
	}	
	
	function obtenerMovimientosProcesoDisponible()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		
		$consulta="select idMovimiento from 901_configuracionMovimientosProceso where idProceso=".$idProceso;
		$listado=$con->obtenerListaValores($consulta);
		if($listado=="")
			$listado="-1";
		$consulta="SELECT id__649_tablaDinamica,txtNomMovimiento FROM _649_tablaDinamica where id__649_tablaDinamica not in (".$listado.") ORDER BY txtNomMovimiento";
		$arrTipoMovimiento=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrTipoMovimiento;
	}
	
	function asignarEtapaMovimientoProceso()
	{
		global $con;
		$idMovimiento=$_POST["idMovimiento"];
		$valor=$_POST["valor"];
		$numEtapa=$_POST["numEtapa"];
		$idProceso=$_POST["idProceso"];
		$consulta="update 901_movimientosProceso SET configuracion='".$valor."' WHERE idMovimiento=".$idMovimiento." AND numEtapa=".$numEtapa." AND idProceso=".$idProceso;

		eC($consulta);
	}
	
	function obtenerMovimientosProcesoEtapaDisponible()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$numEtapa=$_POST["numEtapa"];
		$consulta="select idMovimiento from 901_movimientosProceso where idProceso=".$idProceso." and numEtapa=".$numEtapa;
		$listado=$con->obtenerListaValores($consulta);
		if($listado=="")
			$listado="-1";
		$consulta="select idMovimiento FROM 901_configuracionMovimientosProceso WHERE idProceso=".$idProceso;
		$listadoIn=$con->obtenerListaValores($consulta);
		if($listadoIn=="")
			$listadoIn="-1";
				
		$consulta="SELECT id__649_tablaDinamica,txtNomMovimiento FROM _649_tablaDinamica where id__649_tablaDinamica not in (".$listado.") and id__649_tablaDinamica in (".$listadoIn.") ORDER BY txtNomMovimiento";
		$arrTipoMovimiento=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrTipoMovimiento;
	}
	
	function guardarModificacionParametro()
	{
		global $con	;
		$idMovimiento=$_POST["idMovimiento"];
		$objConf=$_POST["objConf"];
		$tipoValor=$_POST["tipoValor"];
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT configuracion FROM 901_configuracionMovimientosProceso WHERE idProceso=".$idProceso." AND idMovimiento=".$idMovimiento;
		$configuracion=$con->obtenerValor($consulta);
		if($configuracion=="")
		{
			switch($tipoValor)
			{
				case "1":
					$configuracion='{"ciclo":"'.$objConf.'","programa":"","departamento":"","partida":"","monto":"","tipoPresupuesto":"","tipoPago":"","mes":""}';
				break;
				case "2":
					$configuracion='{"ciclo":"","programa":"'.$objConf.'","departamento":"","partida":"","monto":"","tipoPresupuesto":"","tipoPago":"","mes":""}';
				break;
				case "3":
					$configuracion='{"ciclo":"","programa":"","departamento":"'.$objConf.'","partida":"","monto":"","tipoPresupuesto":"","tipoPago":"","mes":""}';
				break;
				case "4":
					$configuracion='{"ciclo":"","programa":"","departamento":"","partida":"'.$objConf.'","monto":"","tipoPresupuesto":"","tipoPago":"","mes":""}';
				break;
				case "5":
					$configuracion='{"ciclo":"","programa":"","departamento":"","partida":"","monto":"'.$objConf.'","tipoPresupuesto":"","tipoPago":"","mes":""}';
				break;
				case "6":
					$configuracion='{"ciclo":"","programa":"","departamento":"","partida":"","monto":"","tipoPresupuesto":"'.$objConf.'","tipoPago":"","mes":""}';
				break;
				case "7":
					$configuracion='{"ciclo":"","programa":"","departamento":"","partida":"","monto":"","tipoPresupuesto":"","tipoPago":"'.$objConf.'","mes":""}';
				break;
				case "8":
					$configuracion='{"ciclo":"","programa":"","departamento":"","partida":"","monto":"","tipoPresupuesto":"","tipoPago":"","mes":"'.$objConf.'"}';
				break;
			}
		}
		else
		{
			$conf=json_decode($configuracion);
			switch($tipoValor)
			{
				case "1":
					$configuracion='{"ciclo":"'.$objConf.'","programa":"'.$conf->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$obj->tipoPresupuesto.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "2":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$objConf.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$obj->tipoPresupuesto.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "3":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$objConf.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$obj->tipoPresupuesto.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "4":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$objConf.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$obj->tipoPresupuesto.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "5":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$objConf.'","tipoPresupuesto":"'.$obj->tipoPresupuesto.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "6":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$objConf.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$obj->mes.'"}';
				break;
				case "7":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$objConf.'","tipoPago":"'.
									$objConf.'","mes":"'.$obj->mes.'"}';
				break;
				case "8":
					case "7":
					$configuracion='{"ciclo":"'.$obj->ciclo.'","programa":"'.$obj->programa.'","departamento":"'.$obj->departamento.
									'","partida":"'.$obj->partida.'","monto":"'.$obj->monto.'","tipoPresupuesto":"'.$objConf.'","tipoPago":"'.
									$obj->tipoPago.'","mes":"'.$objConf.'"}';
				break;
			}	
		}
		$consulta="update 901_configuracionMovimientosProceso set configuracion='".$configuracion."' WHERE idProceso=".$idProceso." AND idMovimiento=".$idMovimiento;
		eB($consulta);
	}
	
	function inscribirAlumnoCurso()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idAlumno=$_POST["idAlumno"];
		$consulta="SELECT idPrograma FROM 4013_materia WHERE idMateria=".$idMateria;
		$idPrograma=$con->obtenerValor($consulta);
		$consulta="INSERT INTO 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma)
					VALUES(".$idAlumno.",1,".$idGrupo.",".$idMateria.",".$idPrograma.")";
		eC($consulta);
	}
	
	function ejecutarFuncionNuevoRegistroProceso()
	{
		global $con;
		$actor=bD($_POST["actor"]);
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$consulta="select complementario from 4001_procesos where idProceso=".$idProceso;	
		$comp=$con->obtenerValor($consulta);
		$obj=json_decode($comp);
		if($obj->tipoFuncion==1)
		{
			eval($obj->funcionNuevoRegistro.'('.$idProceso.','.$idFormulario.','.$actor.','.$idReferencia.');');
		}
	}
	
	function guardarConfiguracionModuloPresupuesto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$capitulo="";
		if($obj->objetoGasto!="")
			$capitulo=substr($obj->objetoGasto,0,3);
		if($obj->idRubro=="-1")
		{
			$consulta="insert into `100_conceptosGridPresupuesto`(nombreConcepto,nombreCortoConcepto,idProceso,situacion,codigoObjetoGasto,funcionConstruccion,capitulo) 
						VALUES('".cv($obj->concepto)."','".cv($obj->conceptoCorto)."',".$obj->idProceso.",'".$obj->situacion."','".$obj->objetoGasto."','".$obj->funcionConstruccion."','".$capitulo."')";
		}
		else
		{
			$consulta="update `100_conceptosGridPresupuesto` set nombreConcepto='".cv($obj->concepto)."',nombreCortoConcepto='".cv($obj->conceptoCorto)."',situacion='".$obj->situacion."',codigoObjetoGasto='".
					$obj->objetoGasto."',funcionConstruccion='".$obj->funcionConstruccion."',capitulo='".$capitulo."'  where idConceptoGrid=".$obj->idRubro;
						
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idRubro=="-1")
				$obj->idRubro=$con->obtenerUltimoID();
			echo "1|".$obj->idRubro;
				
		}
	}
	
	function obtenerConfiguracionModuloPresupuesto()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idConceptoGrid,nombreConcepto,nombreCortoConcepto,funcionConstruccion,codigoObjetoGasto,
					(SELECT distinct concat('[',clave,'] ',nombreObjetoGasto) as conceto FROM 507_objetosGasto WHERE codigoControl=c.codigoObjetoGasto ),
					situacion,(select if((select count(*) from 100_gridPresupuesto where idRubro=c.idConceptoGrid)=0,1,0)) as eliminable from 100_conceptosGridPresupuesto c order by nombreConcepto";
		$arrConceptos=$con->obtenerFilasArreglo($consulta);	
		$cadObj='{"arrConceptos":'.$arrConceptos.'}';
		echo "1|".$cadObj;
	}
	
	function obtenerConfiguracionModulo()
	{
		global $con;
		$idModulo=$_POST["idModulo"];
		$idProceso=$_POST["idProceso"];
		
		$consulta="select configuracion from 203_configuracionModuloDTD where idModulo=".$idModulo." and idProceso=".$idProceso;
		$configuracion=$con->obtenerValor($consulta);
		echo "1|[".$configuracion."]";
	}

	function guardaVinculacionProcesoReporte()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idReporte=$_POST["idReporte"];
		$consulta="update 4001_procesos set complementario='".$idReporte."' where idProceso=".$idProceso;
		eC($consulta);
	}
		
	function obtenerDatosFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$campos=bD($_POST["campos"]);
		$consulta="select ".$campos." from _".$idFormulario."_tablaDinamica t where t.id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fila=$con->obtenerPrimeraFila($consulta);
		$arrValores="";
		foreach($fila as $valor)
		{
			if($arrValores=="")
				$arrValores=$valor;
			else
				$arrValores.="|".$valor;
		}
		echo "1|".$arrValores;
	}
	
	function obtenerComentariosRegistro()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
				idFormularioDictamen AS idFormulario,idRegistroDictamen AS idRegistro FROM 2002_comentariosRegistro WHERE 
				idFormulario=".$idFormulario."  AND idRegistro=".$idRegistro." and comentario<>''";
		$arrObj=$con->obtenerFilasJson($consulta);	
		
		$consulta="update 2002_comentariosRegistro set visualizado=1 WHERE idFormulario=".$idFormulario."  AND idRegistro=".$idRegistro;
		$con->ejecutarConsulta($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function guardarPaginaAgregacion()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$tipoPagina=$_POST["tipoPagina"];
		$valorPagina=$_POST["valorPagina"];
		$consulta="update 904_configuracionElemFormulario set campoConf16='".$tipoPagina."',campoConf17='".$valorPagina."' where idElemFormulario=".$idElemento;
		eC($consulta);
	}
	
	function guardarNombreFuncionGeneradoraFolio()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$funcion=$_POST["nombreFuncion"];
		$consulta="update 900_formularios SET funcionGeneradoraFolio='".cv($funcion)."' WHERE idFormulario=".$idFormulario;
		eC($consulta);
		
	}
	
	function guardarTipoFuncionGeneradoraFolio()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$tipoFolio=$_POST["tipoFolio"];
		$consulta="update 900_formularios SET tipoGeneradorFolio='".cv($tipoFolio)."' WHERE idFormulario=".$idFormulario;
		eC($consulta);
		
	}
	
	function obtenerComentariosSeccion()
	{
		global $con;
		
		$idReferencia=$_POST["idRegistro"];
		$idFormularioBase=$_POST["idFormularioBase"];
		$idUsuario=$_POST["idUsuario"];
		
		$comp="";
		if($idUsuario!=-1)
			$comp=" and idResponsableComentario=".$idUsuario;
		
		if(isset($_POST["actor"]))
			$comp.=" and idActor='".$_POST["actor"]."'";
		
		if(isset($_POST["version"]))
			$comp.=" and version='".$_POST["version"]."'";
		
		if(isset($_POST["idFormulario"]))
			$comp.=" and idFormulario=".$_POST["idFormulario"];	
			
			
		$consulta="select fechaComentario,comentario,idComentarioSeccion,(SELECT nombreFormulario FROM 900_formularios WHERE idFormulario=c.idFormulario) as seccion FROM 9050_comentariosSeccion c WHERE idFormularioBase=".$idFormularioBase.
					" and idReferencia=".$idReferencia.$comp."   ORDER BY fechaComentario";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function guardarComentariosSeccion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idProceso=obtenerIdProcesoFormulario($obj->idFormularioBase);
		$consulta="select idEstado from _".$obj->idFormularioBase."_tablaDinamica where id__".$obj->idFormularioBase."_tablaDinamica=".$obj->idReferencia;
		$nEtapa=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(etapaActual)-1 AS versionRegistro FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$obj->idFormularioBase." AND idFormulario=".$obj->idFormularioBase." AND idRegistro=".$obj->idReferencia;
		$version=$con->obtenerValor($consulta);
		if($version=="")
			$version=0;
		
		if($obj->idComentarioSeccion==-1)
			$consulta="INSERT INTO 9050_comentariosSeccion(idFormulario,comentario,idResponsableComentario,idActor,fechaComentario,VERSION,idFormularioBase,idReferencia)
						VALUES(".$obj->idFormulario.",'".cv($obj->comentario)."',".$obj->idResponsable.",'".$obj->actor."','".date("Y-m-d H:i")."',".$version.",".$obj->idFormularioBase.",".$obj->idReferencia.")";
		else
			$consulta="update 9050_comentariosSeccion set comentario='".cv($obj->comentario)."' where idComentarioSeccion=".$obj->idComentarioSeccion;

		eC($consulta);
		
	}
	
	function eliminarComentariosSeccion()
	{
		global $con;
		$idComentarioSeccion=$_POST["idComentarioSeccion"];
		$consulta="delete from 9050_comentariosSeccion where idComentarioSeccion=".$idComentarioSeccion;
		eC($consulta);
		
	}
	
	function obtenerEstadisticasRegistro()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="select idEstado from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$idEstado=$con->obtenerValor($consulta);
		
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$arrNodos="";
		
		
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." order by numEtapa";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$consulta="SELECT COUNT(*) FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." 
						AND etapaActual=".$fila[0];
			$nPasos=$con->obtenerValor($consulta);
			if($nPasos>0)
			{
				//$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE numEtapa=".$fila[0]." and idProceso=".$idProceso;
				//$filaAux=$con->obtenerPrimeraFila($consulta);
				$tAp="";
				$tC="";
				$situacion="";
				if($fila[0]==$idEstado)
				{
					$tAp='<font color=\'red\'>';
					$tC='</font>';
					$situacion=$tAp."Registro en etapa actual".$tC;
				}
				$hijos=obtenerNumEntregasEtapa($idProceso,$idFormulario,$idRegistro,$fila[0],$idEstado);
				$lblDescripcion=removerCerosDerecha($fila[0]).".- ".$fila[1];
				$obj='	{
							"descripcion":"'.$tAp.'<b>Etapa: </b> '.$lblDescripcion.$tC.'",
							"fechaAsignacion":"",
							"situacion":"'.$situacion.'",
							"fechaDictamen":"",
							"iconCls":"task-folder",
							"dictamen":"",
							"leaf":false,
							"children":'.$hijos.',
							"orden":"'.$fila[0].'"
						}';
				
				if($arrNodos=="")
					$arrNodos=$obj;
				else
					$arrNodos.=",".$obj;
			}
		}
		echo '['.$arrNodos.']';
	}
	
	function obtenerNumEntregasEtapa($idProceso,$idFormulario,$idRegistro,$numEtapa,$idEtapaActual)
	{
		global $con;
		global $arrPosicionOrd;
		$arrNodos="";
		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND etapaActual=".$numEtapa;
		$res=$con->obtenerFilas($consulta);
		$ct=0;
		while($fila=$con->fetchRow($res))
		{
			$hijos=obtenerActoresEtapa($idProceso,$idFormulario,$idRegistro,$numEtapa,$idEtapaActual,$ct);
			$comp='"leaf":true,';
			if($hijos!="[]")
				$comp='"leaf":false,"children":'.$hijos.",";
				
			$obj='	{
						"descripcion":"<b>'.utf8_encode($arrPosicionOrd[($ct+1)]).' asignaci&oacute;n</b>",
						"fechaAsignacion":"'.date("d/m/Y",strtotime($fila[2])).'",
						"situacion":"",
						"fechaDictamen":"",
						"iconCls":"task",
						"dictamen":"",
						'.$comp.'
						"orden":"'.$ct.'"
					}';	
			if($arrNodos=="")
				$arrNodos=$obj;
			else
				$arrNodos.=",".$obj;
			$ct++;
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerActoresEtapa($idProceso,$idFormulario,$idRegistro,$numEtapa,$idEtapaActual,$nVersion)
	{
		global $con;
		$consulta="SELECT e.* FROM 947_actoresProcesosEtapasVSAcciones a,944_actoresProcesoEtapa e WHERE 
					idGrupoAccion IN (4,5) AND e.idActorProcesoEtapa=a.idActorProcesoEtapa AND idProceso=".$idProceso." ORDER BY numEtapa";

		$arrEtapa=array();
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if(!isset($arrEtapa[$fila[3]]))
				$arrEtapa[$fila[3]]=array();
			$objRegistro[0]=$fila[0];
			$objRegistro[1]=$fila[1];
			$objRegistro[2]=$fila[2];
			$objRegistro[3]=$fila[5];
			array_push($arrEtapa[$fila[3]],$objRegistro);
		}
		$arrNodos="";

		if(isset($arrEtapa[$numEtapa]))
		{
		
			foreach($arrEtapa[$numEtapa] as $objAux)
			{
				
				$publicar=false;
				if($objAux[3]==1)
					$publicar=true;
				else
				{
					$consulta="SELECT idActorEvaluador FROM 998_actoresEvaluadoresAsignados WHERE idActorProcesoEtapa=".$objAux[0]." AND idFormulario=".$idFormulario.
								" and idRegistro=".$idRegistro;
					$idEvaluador=$con->obtenerValor($consulta);
					if($idEvaluador!="")
						$publicar=true;
				}
				if($publicar)
				{
					$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$numEtapa." AND idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." LIMIT ".$nVersion.",1";
					$fechaAsig=$con->obtenerValor($consulta);
					if($fechaAsig!="")
						$fechaAsig=date("d/m/Y",strtotime($fechaAsig));
					$lblActor=obtenerNombreActor($objAux[0]);
					$consulta="SELECT idGrupoAccion,complementario FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$objAux[0]." AND idGrupoAccion IN (4,5)";
					$filaAux=$con->obtenerPrimeraFila($consulta);
					$idGrupoAccion=$filaAux[0];
					$consulta="SELECT idFormulario FROM 948_actoresVSFormulariosDictamen WHERE idActorVSFormularioDictamen=".$filaAux[1];
					$idFormularioDic=$con->obtenerValor($consulta);
					switch($idGrupoAccion)
					{
						case 4:
							$lblActor="<span style='color:#063'>Dict&aacute;men Parcial</span> ".$lblActor;
						break;
						case 5:
							$lblActor="<span style='color:#900'>Dict&aacute;men Final</span> ".$lblActor;
						break;
					}
					
					$consulta="select * from _".$idFormularioDic."_tablaDinamica where idReferencia=".$idRegistro." limit ".$nVersion.",1";
					$res=$con->obtenerFilas($consulta);
					$filaDic=$con->fetchAssoc($res);
					$situacion="<span style='color:#900'>No dictaminado</span>";
					$fechaDictamen="";
					$dictamen="";
					if($filaDic)
					{
						$fechaDictamen=date("d/m/Y",strtotime($filaDic["fechaCreacion"]));
						$situacion="<span style='color:#063'>Dictaminado</span>";

					}
					
					$consulta="SELECT idGrupoAccion FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$objAux[0]." AND idGrupoAccion =3";
					$idAsignaRev=$con->obtenerValor($consulta);
					$hijos="[]";
					if($idAsignaRev!="")
						$hijos=obtenerRevisoresActor($idProceso,$idFormulario,$idRegistro,$objAux[0],$nVersion);
					$comp='"leaf":true,';
					if($hijos!="[]")
						$comp='"leaf":false,"children":'.$hijos.",";
					
					$obj='	{
								"descripcion":"'.$lblActor.'",
								"fechaAsignacion":"'.$fechaAsig.'",
								"situacion":"'.$situacion.'",
								"fechaDictamen":"'.$fechaDictamen.'",
								"iconCls":"task",
								"dictamen":"'.$dictamen.'",
								'.$comp.'
								"orden":"'.$numEtapa.'"
							}';	
	
					if($arrNodos=="")
						$arrNodos=$obj;
					else
						$arrNodos.=",".$obj;
				}
			}
		}
		return "[".$arrNodos."]";
	}
	
	function obtenerRevisoresActor($idProceso,$idFormulario,$idRegistro,$idActor,$nVersion)
	{
		global $con;
		$consulta="SELECT idUsuarioRevisor,idFormDictamen,estado,fechaAsignacion,fechaDictamen,idFormularioDictamen from 955_revisoresProceso 
					WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idActorProcesoEtapa=".$idActor." and versionRegistro=".$nVersion;
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=$con->fetchRow($res))
		{
			$situacion="";
			switch($fila[2])
			{
				case 0:
					$situacion="<span style='color:#006'>En espera de inicio de dict&aacute;men</span>";
				break;
				case 1:
					$situacion="<span style='color:#F00'>En espera de dict&aacute;men</span>";
				break;
				case 2:
					$situacion="<span style='color:#063'>Dictaminado</span>";
				break;
				case 3:
					$situacion="<span style='color:#900'>Cancelado</span>";
				break;
			}
			$fechaDictamen="";
			if($fila[4]!="")
				$fechaDictamen=date("d/m/Y",strtotime($fila[4]));
			$obj='	{
							"descripcion":"Revisor '.obtenerNombreUsuario($fila[0]).'",
							"fechaAsignacion":"'.date("d/m/Y",strtotime($fila[3])).'",
							"situacion":"'.$situacion.'",
							"fechaDictamen":"'.$fechaDictamen.'",
							"iconCls":"task-folder",
							"dictamen":"",
							"leaf":true,
							"orden":"'.$fila[0].'"
						}';
				
				if($arrNodos=="")
					$arrNodos=$obj;
				else
					$arrNodos.=",".$obj;
		}
		return "[".$arrNodos."]";
	}
	
	function removerUnidadAmbito()
	{
		global $con;
		$idUnidad=$_POST["iU"];
		$consulta="DELETE FROM 947_ampliacionesAmbitoRegistros WHERE idAmpliaUniversoRegistro=".$idUnidad;
		eC($consulta);
	}
	
	function agregarUnidadAmbito()
	{
		global $con;
		$codigoUnidad=$_POST["codigoUnidad"];
		$ambito=$_POST["ambito"];
		$idAccion=$_POST["idAccion"];
		$consulta="insert into 947_ampliacionesAmbitoRegistros(codigoUnidad,ambito,idAccionesProcesoEtapaVSAcciones) VALUES('".$codigoUnidad."',".$ambito.",".$idAccion.")";
		if($con->ejecutarConsulta($consulta))	
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function buscarUnidadOrganigrama()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="select codigoUnidad,unidad from 817_organigrama where unidad like '%".$criterio."%'";
		$res=$con->obtenerFilas($consulta);
		$arrUnidades="";
		$ct=0;
		while($fila=$con->fetchRow($res))
		{
			$codigoInstitucion=obtenerInstitucionDepto($fila[0]);
			$consulta="select unidad from 817_organigrama where codigoUnidad ='".$codigoInstitucion."'";
			$institucion=$con->obtenerValor($consulta);
			$obj='{"codigoUnidad":"'.$fila[0].'","unidad":"'.cv($fila[1]).'","institucion":"'.$institucion.'"}';
			if($arrUnidades=="")
				$arrUnidades=$obj;
			else
				$arrUnidades.=",".$obj;
			$ct++;	
		}
		echo '{"num":"'.$ct.'","objetos":['.$arrUnidades.']}';
	}
	
	function guardarTemporizadorProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idFuncionPeriodico==0)
			$obj->nDiasPeriodico=0;
		$consulta="INSERT INTO 9056_temporizadoresProceso(idProceso,nEtapa,idFuncionTemporizador,noUnidades,idFuncionEjecucionDiaria,noUnidadesDiaria) 
					VALUES(".$obj->idProceso.",".$obj->nEtapa.",".$obj->idFuncion.",".$obj->nDias.",".$obj->idFuncionPeriodico.",".$obj->nDiasPeriodico.")";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function obtenerTemporadoresProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$nEtapa=$_POST["nEtapa"];
		$consulta="SELECT idTemporizador,noUnidades,idFuncionTemporizador,noUnidadesDiaria,idFuncionEjecucionDiaria
					 FROM 9056_temporizadoresProceso WHERE idProceso=".$idProceso." AND nEtapa=".$nEtapa;
		$registros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($registros).'}';
	}
	
	function removerTemporizadorProceso()
	{
		global $con;
		$listTemporizadores=$_POST["listTemporizadores"];
		$consulta="delete from 9056_temporizadoresProceso where idTemporizador in (".$listTemporizadores.")";
		eC($consulta);
	}
	
	function obtenerConfiguracionSeccion()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idPerfil=" is null";
		if(isset($_POST["tipoActor"]))
		{
			$tipoActor=$_POST["tipoActor"];
			$idActor=$_POST["idActor"];
			$idPerfil="=".obtenerIdPerfilEscenario($idProceso,$tipoActor,$idActor);
		}
		
		$arrReg="";
		$numReg=0;
		$consulta="SELECT * FROM 9057_configuracionSeccionesProceso WHERE idProceso=".$idProceso." and idPerfil ".$idPerfil." ORDER BY idSeccion";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if($fila[8]=="")
				$fila[8]=-1;
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." and numEtapa in (".$fila[8].") order by numEtapa";
			
			$resEt=$con->obtenerFilas($consulta);
			$descripcion='<table><tr><td></td><td><span class="corpo8_bold">Aplicable a etapa </span> <a href="javascript:agregarEtapaSeccion(\''.bE($fila[0]).'\')"><img src="../images/add.png" width="13" height="13" alt="Agregar etapa" title="Agregar etapa"></a></td></tr>';
			if($fila[8]!=-1)
			{
				while($filaEt=$con->fetchRow($resEt))
				{
					$descripcion.='<tr height="21"><td><a href="javascript:removerEtapa(\''.bE(removerCerosDerecha($filaEt[0])).'\',\''.bE($fila[0]).'\')"><img src="../images/delete.png" width="13" height="13" alt="Remover etapa" title="Remover etapa"></a></td><td>'.removerCerosDerecha($filaEt[0]).'.- '.cv($filaEt[1]).'</td></tr>';
				}
			}
			else
				$descripcion.='<tr height="21"><td></td><td>Cualquier etapa</td></tr>';
			$descripcion.="</table>";
			$o='{"idSeccion":"'.$fila[0].'","tituloSeccion":"'.$fila[1].'","paginaJavaScript":"'.$fila[2].'","funcionScript":"'.$fila[3].'","funcionInicializacion":"'.$fila[4].'","paginaIncludePhp":"'.$fila[5].
				'","funcionRenderer":"'.$fila[6].'","descripcion":"'.cv($descripcion).'"}';
			if($arrReg=="")
				$arrReg=$o;
			else	
				$arrReg.=",".$o;
			$numReg++;
		}
		
		$consulta="SELECT situacion FROM 206_perfilesEscenarios WHERE idPerfil".$idPerfil;
		$situacion=$con->obtenerValor($consulta);
		if($situacion=="")
			$situacion=0;
		echo '{"numReg":"'.$numReg.'","registros":['.($arrReg).'],"situacion":"'.$situacion.'"}';

	}
	
	function guardarConfiguracionSeccion()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		if($obj->idSeccion==-1)
		{
			$idPerfil="NULL";
			if(isset($obj->tipoActor))
			{
				$tipoActor=$obj->tipoActor;
				$idActor=$obj->idActor;
				$idPerfil="".obtenerIdPerfilEscenario($obj->idProceso,$tipoActor,$idActor);
				
			}
			$consulta="INSERT INTO 9057_configuracionSeccionesProceso(tituloSeccion,paginaJavaScript,funcionScript,funcionInicializacion,paginaIncludePhp,funcionRenderer,idProceso,idPerfil)
						VALUES('".cv($obj->tituloSeccion)."','".cv($obj->paginaJavaScript)."','".cv($obj->funcionScript)."','".
						cv($obj->funcionInicializacion)."','".cv($obj->paginaIncludePhp)."','".cv($obj->funcionRenderer)."',".cv($obj->idProceso).",".$idPerfil.")";
		}
		else
		{
			$consulta="update 9057_configuracionSeccionesProceso set tituloSeccion='".cv($obj->tituloSeccion)."',paginaJavaScript='".cv($obj->paginaJavaScript)."',
						funcionScript='".cv($obj->funcionScript)."',funcionInicializacion='".cv($obj->funcionInicializacion)."',
						paginaIncludePhp='".cv($obj->paginaIncludePhp)."',funcionRenderer='".cv($obj->funcionRenderer)."' where idSeccion=".$obj->idSeccion;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idSeccion==-1)
				$obj->idSeccion=$con->obtenerUltimoID();
			echo "1|".$obj->idSeccion;
		}
	}
	
	function removerConfiguracionSeccion()
	{
		global $con;	
		$listConfiguraciones=$_POST["listConfiguraciones"];
		$consulta="delete from 9057_configuracionSeccionesProceso where idSeccion in (".$listConfiguraciones.")";
		eC($consulta);
	}
	
	function guardarOpcionesControlProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE 203_elementosDTD SET idFuncionVisualizacion=".$obj->idFuncionVisualizacion.",
				idFuncionEdicion=".$obj->idFuncionEdicion." WHERE idElementoDTD=".$obj->idElemento;
		eC($consulta);
	}
	
	
	function obtenerFuncionesSistema()
	{
		global $con;
		$campoOrden=$_POST["sort"];
		$direccion=$_POST["dir"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$idCategoria=$_POST["idCategoria"];
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$filtroUsuario=generarCadenaConsultasFiltro($_POST["filter"]);
			$filtroUsuario=" and ".$filtroUsuario;
		}
		
		$consulta="SELECT idFuncion,nombreFuncion,descripcion,nombreFuncionPHP,archivoInclude ,tipoFuncion,(if((SELECT COUNT(*) FROM 9034_parametrosFuncionesSistema 
					WHERE idFuncion=f.idFuncion)=0,0,1)) as requiereParametro,idCategoria,
					(SELECT GROUP_CONCAT(parametro) FROM 9034_parametrosFuncionesSistema WHERE idFuncion=f.idFuncion) as parametros 
					FROM 9033_funcionesSistema f where idCategoria in (".$idCategoria.") ".$filtroUsuario." order by ".$campoOrden." ".$direccion." limit ".$start.",".$limit ;

		$registros=$con->obtenerFilasJSON($consulta);
		$consulta="SELECT idFuncion,nombreFuncion,descripcion,nombreFuncionPHP,archivoInclude ,tipoFuncion,(if((SELECT COUNT(*) FROM 9034_parametrosFuncionesSistema 
					WHERE idFuncion=f.idFuncion)=0,0,1)) as requiereParametro,idCategoria FROM 9033_funcionesSistema f where  idCategoria in (".$idCategoria.") ".$filtroUsuario." order by ".$campoOrden." ".$direccion;
		$con->obtenerFilasJSON($consulta);
		$nReg=$con->filasAfectadas;
		echo '{"numReg":"'.$nReg.'","registros":'.utf8_encode($registros).'}';
		
	}
	
	function obtenerNuevoActorProcesoRegistro()
	{
		global $con;
		$actor=$_POST["actor"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$nRegistro=$_POST["nRegistro"];
		$idPerfil=-1;
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$nActor=obtenerNuevoActorProceso($actor,$idFormulario,$idRegistro,"",$nRegistro,$idPerfil);
		echo "1|".$nActor; 
		
		
	}
	
	function obtenerReferenciaPago()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idConcepto=$_POST["idConcepto"];
		$idUsuario="";
		if(isset($_POST["idUsuario"]))
			$idUsuario=$_POST["idUsuario"];
		$referencia=obtenerReferenciaPagoFormulario($idFormulario,$idRegistro,$idConcepto,$idUsuario);
		echo "1|".$referencia;
	}

	function obtenerIdRegistroFormulario()
	{
		global $con;
		$idRegistro="";
		$idFormulario=$_POST["idFormulario"];
		$tipoCriterio=$_POST["tipoCriterio"];
		
		switch($tipoCriterio)
		{
			case 1://Codigo Unidad
				$codigoUnidad=$_POST["codUnidad"];
				$consulta="SELECT id__".$idFormulario."_tablaDinamica FROM _".$idFormulario."_tablaDinamica WHERE codigoInstitucion='".$codigoUnidad."'";
				$idRegistro=$con->obtenerValor($consulta);
			break;
		}
		
		if($idRegistro=="")
			$idRegistro=-1;
		echo "1|".$idRegistro;
		
		
	}

	function obtenerCamposFormularioPorTipo()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$tipoControl=$_POST["tipoControl"];
		$consulta="SELECT idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND tipoElemento IN(".$tipoControl.") ORDER BY nombreCampo";
		$arrReg=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrReg;
	}
	
	
	function actualizarEtapaElementoDTD()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="UPDATE 203_elementosDTD SET noEtapa=".$obj->noEtapa." WHERE idElementoDTD=".$obj->idElemento;
		eC($consulta);
		
		
		
	}
	
	function actualizarOrdenElementoDTD()
	{
		global $con;	
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$tipoActor=-1;
		if(isset($obj->tipoActor))
			$tipoActor=$obj->tipoActor;
		
		$actor=-1;
		if(isset($obj->actor))
			$actor=$obj->actor;
		

		$consulta="SELECT orden,idPerfil FROM 203_elementosDTD WHERE idElementoDTD=".$obj->idElemento;
		$fElementos=$con->obtenerPrimeraFilaAsoc($consulta);
		$orden=$fElementos["orden"];
		if($orden!=$obj->orden)
		{
			if($fElementos["idPerfil"]!="")
			{
				$idPerfil="=".$fElementos["idPerfil"];
			}
			else
			{
				$idPerfil="is NULL";
			}
			
			
			if($obj->orden<$orden)
			{
				$query[$x]="update 203_elementosDTD set orden=orden+1 where idProceso=".$obj->idProceso." and idPerfil ".$idPerfil.
						" and  orden>=".$obj->orden." and orden<=".$orden." and idElementoDTD<>".$obj->idElemento;
				$x++;
			}
			else
			{
				$query[$x]="update 203_elementosDTD set orden=orden-1 where idProceso=".$obj->idProceso." and idPerfil ".$idPerfil." and  orden>=".$orden.
						" and orden<=".$obj->orden." and idElementoDTD<>".$obj->idElemento;
				$x++;
			}
			
			$query[$x]="UPDATE 203_elementosDTD SET orden=".$obj->orden." WHERE idElementoDTD=".$obj->idElemento;
			$x++;
			
			$query[$x]="commit";
			$x++;
			eB($query);
		}
		else
		{
			echo "1|";	
		}
		
		
	}
	
	function removerEtapaSeccion()
	{
		global $con;
		$etapa=$_POST["e"];	
		$iS=$_POST["iS"];	
		$consulta="SELECT numEtapa FROM 9057_configuracionSeccionesProceso WHERE idSeccion=".$iS;
		$numEtapa=$con->obtenerValor($consulta);
		$arrEtapas=explode(",",$numEtapa);
		$cEtapas="";
		foreach($arrEtapas as $e)
		{
			if((trim($e)*1)!=($etapa*1))
			{
				if($cEtapas=="")
					$cEtapas=removerCerosDerecha(trim($e));
				else
					$cEtapas.=",".removerCerosDerecha(trim($e));
			}
		}
		$consulta="update 9057_configuracionSeccionesProceso set numEtapa='".$cEtapas."' WHERE idSeccion=".$iS;
		eC($consulta);
	}
	
	function obtenerEtapasDisponiblesSeccion()
	{
		global $con;
		$idSeccion=$_POST["idSeccion"];
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT numEtapa FROM 9057_configuracionSeccionesProceso WHERE idSeccion=".$idSeccion;
		$numEtapa=$con->obtenerValor($consulta);
		if($numEtapa=="")
			$numEtapa=-1;
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." and numEtapa not in (".$numEtapa.") ORDER BY numEtapa";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));	
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function registrarEtapaSeccion()
	{
		global $con;
		$listEtapas=$_POST["listEtapas"];
		$idSeccion=$_POST["iS"];
		$consulta="SELECT numEtapa FROM 9057_configuracionSeccionesProceso WHERE idSeccion=".$idSeccion;
		$numEtapa=$con->obtenerValor($consulta);
		if($numEtapa!="")
			$numEtapa=",".$listEtapas;
		else
			$numEtapa=$listEtapas;
		$consulta="UPDATE 9057_configuracionSeccionesProceso SET numEtapa='".$numEtapa."' WHERE idSeccion=".$idSeccion;
		eC($consulta);
	}
	
	function modificarSituacionPerfil()
	{
		global $con;	
		$idProceso=$_POST["idProceso"];
		$tipoActor=$_POST["tipoActor"];
		$idActor=$_POST["idActor"];
		$activo=$_POST["activo"];
		$idPerfil=obtenerIdPerfilEscenario($idProceso,$tipoActor,$idActor);
		$consulta="UPDATE 206_perfilesEscenarios SET situacion=".$activo." WHERE idPerfil=".$idPerfil;
		eC($consulta);
		
		
		
	}
	
	function obtenerSeccionesVistaDTD()
	{
		global $con;	
		$modalidad=0;
		$idProceso=$_POST["iP"];
		$idFormulario=$_POST["iF"];
		$idRegistro=$_POST["iR"];
		$idActor=$_POST["iA"];	
		$participante=$_POST["idP"];
		
		$arrSeccionesBtn=obtenerSeccionesElementosFormulario($modalidad,$idProceso,$idFormulario,$idRegistro,$idActor,$participante);
		echo $arrSeccionesBtn;
		
		
	}
	
	function actualizarTabActivo()
	{
		global $con;
		$iTab=$_POST["iT"];
		$configuracion=$_POST["c"];
		
		cambiarValorObjParametros($configuracion,"tabActivo",$iTab);
		
		echo "1|";
		
	}
	
	function registrarFirmaCertificacionProceso()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$accionFirma=$obj->accionFirma;
		$idFormulario=$obj->idFormulario;
		$idRegistro=$obj->idRegistro;
		$comentario=$obj->comentario;
		$etapa=$obj->etapa;
		$actor=$obj->actor;
		$cadenaFirma=$obj->cadenaFirma;
		$idPerfil=obtenerIdPerfilActivoProcesoActor($actor,$idFormulario);
		$continuarProceso=true;
		
		$documentoFinal=0;
		if(isset($obj->documentoFinal))
			$documentoFinal=$obj->documentoFinal;
		
		
		$consulta="SELECT idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$idEstadoAnterior=$con->obtenerValor($consulta);
		if($idEstadoAnterior=="")
			$idEstadoAnterior=0;
		
		if(isset($obj->idRegistroFormato)&&($obj->idRegistroFormato!=-1))
		{
			/*$consulta="INSERT INTO 3000_bitacoraFormatos(idRegistroFormato,idEstadoAnterior,fechaCambio,idEstadoActual,
						responsableCambio,comentariosAdicionales,resultadoEvaluacion)
						VALUES(".$obj->idRegistroFormato.",".$idEstadoAnterior.",'".date("Y-m-d H:i:s").
						"',".$etapa.",".$_SESSION["idUsr"].",'".cv($comentario).
						"',".$accionFirma.")";
			$con->ejecutarConsulta($consulta);*/
		}

		
		if($accionFirma==1)
		{
			$consulta="INSERT INTO 9073_firmasCertificacionesProcesos(idFormulario,idRegistro,idActor,cadenaFirma,fechaFirma,responsableFirma,comentarios)
				VALUES(".$idFormulario.",".$idRegistro.",".$actor.",'".$cadenaFirma."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($comentario)."')";
			$continuarProceso=$con->ejecutarConsulta($consulta);
		}
		else
		{
			if($accionFirma==5)
			{

				$continuarProceso=generarDocumentoPDFFormato($obj->idRegistroFormato,false,($documentoFinal==0?2:1),-1,"");
			}
		}

		if($continuarProceso)
		{
			if($etapa!=0)
			{
				
				if(cambiarEtapaFormulario($idFormulario,$idRegistro,$etapa,$comentario,$idPerfil,"NULL","NULL",$actor))
				{

					if(isset($obj->funcionEjecucion)&&($obj->funcionEjecucion!=""))
					{
						@eval("@".bD($obj->funcionEjecucion).";");
					}
					
					$idProceso=obtenerIdProcesoFormulario($idFormulario);
					$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
					$rol=$con->obtenerValor($consulta);
					if($rol=="")
					{
						$rol=0;
					}
					$nActor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);//obtenerNuevoActorProceso($idActorProcesoEtapa,$idFormulario,$idRegistro,$numEtapa,0,$idPerfil);
					echo "1|".$nActor;

				}
			}
			else
				echo "1|".$actor;
		}
	}
	
	
	function cambiarEtapaFormularioDictamenFinal()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$comentario=$_POST["comentario"];
		$idPerfil=-1;
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		
		$idFormularioDictamen=-1;
		if(isset($_POST["idFormularioDictamen"]))
		{
			$idFormularioDictamen=$_POST["idFormularioDictamen"];
		}
		
		$valorResultado="";
		if(isset($_POST["valorResultado"]))
		{
			$valorResultado=$_POST["valorResultado"];
		}
		
		$idAccionesProcesoEtapaVSAcciones=	$_POST["idAccionesProcesoEtapaVSAcciones"];
			
		$idActorProcesoEtapa=base64_decode($_POST["actor"]);

		$etapaCambio=$_POST["etapaCambio"];
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		
		
		$consulta="select complementario,objComplementario,complementario3 from 947_actoresProcesosEtapasVSAcciones where idAccionesProcesoEtapaVSAcciones=".$idAccionesProcesoEtapaVSAcciones;
		


		$fAccion=$con->obtenerPrimeraFila($consulta);
		
		$numEtapa=$fAccion[0];
		$objComplementario=$fAccion[1];
		if($objComplementario!="")
		{
			$oComplementario=json_decode($objComplementario);
			
			if(isset($oComplementario->funcionValidacion))
			{
				$res="";
				eval('$res='.$oComplementario->funcionValidacion.'('.$idFormulario.','.$idRegistro.');');
				if($res!="")
				{
					if($res!="[]")
					{	
						echo $res;
						return;
					}
				}
			}
		}
		
		$objComplementario2=$fAccion[2];
		if($objComplementario2!="")
		{
			$oComplementario2=json_decode($objComplementario2);
			
			if(isset($oComplementario2->funcionValidacion)&&($oComplementario2->funcionValidacion!=-1))
			{
				
				
				$cacheCalculo=null;
				$cadObj='{"numEtapaCambio":"'.$etapaCambio.'","idFormulario":"'.$idFormulario.'","idReferencia":"'.$idRegistro.'","actor":"'.$idActorProcesoEtapa.'"}';
				$obj=json_decode($cadObj);
				$resultado=resolverExpresionCalculoPHP($oComplementario2->funcionValidacion,$obj,$cacheCalculo);

				if(sizeof($resultado)>0)
				{
					
					$arrErores="";
					
					foreach($resultado as $error)
					{
						$oError="['".cv($error["seccion"])."','".cv($error["mensajeError"])."']";
						if($arrErores=="")
							$arrErores=$oError;
						else
							$arrErores.=",".$oError;
					}
					echo "[".$arrErores."]";
					return;
				}
				
				
			}
		}

		if($idFormularioDictamen!=-1)
		{
			$consulta="SELECT configuracionFormulario,funcionNuevoRegistro FROM 900_formularios WHERE idFormulario=".$idFormularioDictamen;
			$fDatosFormulario=$con->obtenerPrimeraFila($consulta);
			$configuracionFormulario=$fDatosFormulario[0];
			
			if($configuracionFormulario!="")
			{
				$oConf=json_decode($configuracionFormulario);
				
				$campoDictamen="";
				$campoComentario="";
				
				if(isset($oConf->campoDictamen) && ($oConf->campoDictamen!=""))
				{
					$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$oConf->campoDictamen;
					$campoDictamen=$con->obtenerValor($consulta);
				}
				
				if(isset($oConf->campoComentario) && ($oConf->campoComentario!=""))
				{
					$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$oConf->campoComentario;
					$campoComentario=$con->obtenerValor($consulta);
				}
				
				$consulta="INSERT INTO _".$idFormularioDictamen."_tablaDinamica(idReferencia,fechaCreacion,responsable".
						($campoDictamen!=""?(",".$campoDictamen):"").($campoComentario!=""?(",".$campoComentario):"").") 
						VALUES(".$idRegistro.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].
						($campoDictamen!=""?(",'".cv($valorResultado)."'"):"").($campoComentario!=""?(",'".cv($comentario)."'"):"").")";
				$con->ejecutarConsulta($consulta);
				
				$idRegistroDictamen=$con->obtenerUltimoID();
				
				if($fDatosFormulario[1]!="")
				{
					eval($fDatosFormulario[1]."(".$idFormularioDictamen.",".$idRegistroDictamen.");");
				}
			}
				
			
		}
		
		if(cambiarEtapaFormulario($idFormulario,$idRegistro,$etapaCambio,$comentario,$idPerfil,"NULL","NULL",$idActorProcesoEtapa))
		{
			
			
			$consulta="select idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$etapaActual=removerCerosDerecha($con->obtenerValor($consulta));
			if($etapaActual!=removerCerosDerecha($etapaCambio))
			{
				$etapaCambio=$etapaActual;
			}
			
			
			
			
			$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$idActorProcesoEtapa;
			$rol=$con->obtenerValor($consulta);
			if($rol=="")
			{
				$rol=0;
			}
			$nActor=obtenerActorProcesoIdRol($idProceso,$rol,$etapaCambio);//obtenerNuevoActorProceso($idActorProcesoEtapa,$idFormulario,$idRegistro,$numEtapa,0,$idPerfil);
			
			
			$objAperturaProcesoArranque="";
			if(isset($_SESSION["aperturaProceso_".$idFormulario."_".$idRegistro."_".removerCerosDerecha($etapaCambio)]))
			{
				$objAperturaProcesoArranque=$_SESSION["aperturaProceso_".$idFormulario."_".$idRegistro."_".removerCerosDerecha($etapaCambio)];
			}
			
			echo "1|".$nActor."|".$objAperturaProcesoArranque;
		}
		else
			echo "|";
	}
	
	function removerDocumentoProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$obj->idFormulario.
				" AND idRegistro=".$obj->idRegistro." AND idDocumento=".$obj->idDocumento;
		$x++;
		
		$query[$x]="UPDATE 7007_contenidosCarpetaAdministrativa SET tipoContenido=-1 WHERE tipoContenido=1 
				AND idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro.
				" AND idRegistroContenidoReferencia=".$obj->idDocumento;
		$x++;
		
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	function obtenerInfoIngresoProceso()
	{
		
		global $con;
		$rol=$_POST["rol"];
		$idFormulario=-1;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		
		$idProceso=-1;
		if(isset($_POST["idProceso"]))
			$idProceso=$_POST["idProceso"];
			
		$idRegistro=-1;
		if(isset($_POST["idRegistro"]))
			$idRegistro=$_POST["idRegistro"];
		
		if($idProceso!=-1)
		{
			$idFormulario=obtenerFormularioBase($idProceso);
		}
		else
		{
			$idProceso=obtenerIdProcesoFormulario($idFormulario);
		}
		
		
		
		$a="";
		$act="";
				
				
		$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		if(!$fRegistro)
		{
			$idRegistro=-1;
			$a=bE("agregar");
			
		}
		else
		{
			$idRegistro=$fRegistro[0];
			$a=bE("auto");
	
			
		}
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro?$fRegistro[1]:0);
		$act=bE($actor);
			
		echo "1|".$idRegistro."|".$a."|".$act."|".$idFormulario;
		
	
	}
	///////////////////Nuevo
	function obtenerCamposProcesoArranque()
	{
		global $con;
		$idProcesoDestino=bD($_POST["idProcesoDestino"]);
		$idProcesOrigen=bD($_POST["idProcesOrigen"]);
		$numEtapa=bD($_POST["numEtapa"]);
		$idRegistro=bD($_POST["idRegistro"]);
		$numReg=0;
		$arrTipoDatos=array();
		$consulta="SELECT tipoDatoServidor,nombreTipoDato FROM 9063_tiposValoresDato ORDER BY tipoDatoServidor";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrTipoDatos[$fila["tipoDatoServidor"]]=$fila["nombreTipoDato"];
		}
		
		$idFormularioBase=obtenerFormularioBase($idProcesoDestino);
		
		/*$consulta="SELECT idRegistroArrancador FROM 9080_arrancadoresProceso WHERE idProcesoOrigen=".$idProcesOrigen." AND idProcesoDestino=".$idProcesoDestino." AND numEtapaProcesoOrigen=".$numEtapa;
		$idRegistroArrancador=$con->obtenerValor($consulta);
		if($idRegistroArrancador=="")*/
			$idRegistroArrancador=$idRegistro;

		$arrRegistros="";
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		$consulta="SELECT COLUMN_NAME,DATA_TYPE,(select count(*) FROM 9017_camposControlFormulario where campoMysql=c.COLUMN_NAME) esCampoDefault  
					FROM information_schema.COLUMNS c WHERE TABLE_SCHEMA='".$con->bdActual."' AND  TABLE_NAME='".$nombreTabla."' AND COLUMN_NAME not in('id_".$nombreTabla."','idReferenciaArrancador') ";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT * FROM 9081_parametrosInicialesArrancadoresProceso WHERE idRegistroArrancador=".$idRegistroArrancador." and campoTablaDestino='".$fila["COLUMN_NAME"]."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$valorAux=-1;
			$tipoLlenado="0";
			$etiquetaValor="";
			$valor="";
			if($fRegistro)
			{
				$tipoLlenado=$fRegistro["tipoLlenado"];
				$valorAux=$fRegistro["valor"];
				if($valorAux=="")
					$valorAux=-1;
				
				switch($tipoLlenado)
				{
					case 1:					
					case 2:	
						$consulta="SELECT descripcionValor FROM 8003_valoresSesion WHERE idValorSesion=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
					break;
					case 3:
						$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
						
					break;
					case 4:
						if($valorAux!=-1)
						{
							$objValor=json_decode($valorAux);
							$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$objValor->idAlmacen;
							$etiquetaValor=$con->obtenerValor($consulta)." (Campo: ".$objValor->campoUsr.")";
							
						}
					break;
					case 5:
						switch($valorAux)
						{
							case "idUsuarioDestinatario":
								$etiquetaValor="ID usuario destinatario";
							break;
							case "nombreUsuarioDestinatario":
								$etiquetaValor="Nombre usuario destinatario";
							break;
							case "idUsuarioRemitente":
								$etiquetaValor="ID usuario remitente";
							break;
							case "nombreUsuarioRemitente":
								$etiquetaValor="Nombre usuario remitente";
							break;
							case "idFormulario":
								$etiquetaValor="ID formulario";
							break;
							case "idRegistro":
								$etiquetaValor="ID registro";
							break;
							case "idReferencia":
								$etiquetaValor="ID registro referencia";
							break;
							case "idProceso":
								$etiquetaValor="ID proceso";
							break;
						}
					break;
					case 6:
						if($valorAux<0)
						{
							$consulta="SELECT campoUsr FROM 9017_camposControlFormulario WHERE tipoElemento=".$valorAux;
							
							$etiquetaValor=$con->obtenerValor($consulta);
						}
						else
						{
							$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$valorAux;
							$etiquetaValor=$con->obtenerValor($consulta);
						}
					break;
					case 7:
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
					break;
					case 8:
						if($valorAux!=-1)
							$etiquetaValor=$valorAux;
					break;
				}
				
				
			}
			
			$o='{"nombreCampo":"'.$fila["COLUMN_NAME"].'","esCampoDefault":"'.($fila["esCampoDefault"]>0?"1":"0").'","tipoDato":"'.(isset($arrTipoDatos[$fila["DATA_TYPE"]])?$arrTipoDatos[$fila["DATA_TYPE"]]:"Otro").
				'","tipoLlenado":"'.$tipoLlenado.'","etiquetaValor":"'.cv($etiquetaValor).'","valor":"'.$valorAux.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function registrarParametrosProcesoArranque()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
				
		/*$consulta="SELECT idRegistroArrancador FROM 9080_arrancadoresProceso WHERE idProcesoOrigen=".$obj->idProcesoOrigen." AND idProcesoDestino=".$obj->idProcesoDestino." AND numEtapaProcesoOrigen=".$obj->numEtapaOrigen;
		$idRegistroArrancador=$con->obtenerValor($consulta);
		if($idRegistroArrancador=="")*/
		$idRegistroArrancador=$obj->idRegistro;
		
	
		if($idRegistroArrancador==-1)
		{
			$query[$x]="INSERT INTO 9080_arrancadoresProceso(idProcesoOrigen,idProcesoDestino,numEtapaProcesoOrigen,numEtapaCambioProcesoDestino,funcionAplicacion,mostrarVentanaProceso) 
					VALUES(".$obj->idProcesoOrigen.",".$obj->idProcesoDestino.",".$obj->numEtapaOrigen.",".$obj->numEtapaDestino.",".$obj->funcionAplicacion.",".$obj->aperturarVentanaProceso.")";
			$x++;
			
			$query[$x]="set @idRegistroArrancador:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$query[$x]="set @idRegistroArrancador:=".$idRegistroArrancador;
			$x++;
			$query[$x]="UPDATE 9080_arrancadoresProceso SET idProcesoDestino=".$obj->idProcesoDestino.", numEtapaCambioProcesoDestino=".$obj->numEtapaDestino.
						",funcionAplicacion=".$obj->funcionAplicacion.",mostrarVentanaProceso='".$obj->aperturarVentanaProceso."' where idRegistroArrancador=@idRegistroArrancador";
			$x++;
		}
		$query[$x]="DELETE FROM 9081_parametrosInicialesArrancadoresProceso WHERE idRegistroArrancador=@idRegistroArrancador";
		$x++;
		
		$idFormularioBase=obtenerFormularioBase($obj->idProcesoDestino);
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		
		
		if(!$con->existeCampo("idProcesoPadre",$nombreTabla))
		{
			$query[$x]="ALTER TABLE ".$nombreTabla." ADD COLUMN idProcesoPadre INT(11)";
			$x++;
		}
		
		if(!$con->existeCampo("idReferenciaArrancador",$nombreTabla))
		{
			$query[$x]="ALTER TABLE ".$nombreTabla." ADD COLUMN idReferenciaArrancador INT(11)";
			$x++;
		}
		
		foreach($obj->registros  as $r)
		{
			$query[$x]="INSERT INTO 9081_parametrosInicialesArrancadoresProceso(idRegistroArrancador,campoTablaDestino,tipoLlenado,valor) 
					VALUES(@idRegistroArrancador,'".$r->campoDestino."','".$r->tipoLlenado."','".$r->valor."')";
			$x++;
		}
		
		
		
		$query[$x]="commit";
		$x++;
		eB($query);
	
	}
	
	function obtenerProcesosArranqueEscenario()
	{
		global $con;
		$arrRegistros="";
		
		$numReg=0;
		$idProcesoOrigen=bD($_POST["iP"]);
		$numEtapaProcesoOrigen=bD($_POST["nE"]);
		$consulta="SELECT * FROM 9080_arrancadoresProceso WHERE idProcesoOrigen=".$idProcesoOrigen." and numEtapaProcesoOrigen=".$numEtapaProcesoOrigen;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{

			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$fila["idProcesoDestino"];
			$nombreProceso=$con->obtenerValor($consulta);
			
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fila["idProcesoDestino"]." AND numEtapa=".$fila["numEtapaCambioProcesoDestino"];
			$fEtapa=$con->obtenerPrimeraFilaAsoc($consulta);
			$lblEtapaIngreso=removerCerosDerecha($fEtapa["numEtapa"]).".- ".$fEtapa["nombreEtapa"];
			
			$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".($fila["funcionAplicacion"]==""?-1:$fila["funcionAplicacion"]);
			$lblFuncionAplicacion=$con->obtenerValor($consulta);

			
			$o='{"idRegistro":"'.$fila["idRegistroArrancador"].'","nombreProceso":"'.cv($nombreProceso).'","idProcesoDestino":"'.$fila["idProcesoDestino"].
				'","etapaIngreso":"'.$fila["numEtapaCambioProcesoDestino"].'","lblEtapaIngreso":"'.cv($lblEtapaIngreso).
				'","funcionAplicacion":"'.$fila["funcionAplicacion"].'","lblFuncionAplicacion":"'.cv($lblFuncionAplicacion).'","mostrarVentanaProceso":"'.$fila["mostrarVentanaProceso"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function removerProcesosArranqueEscenario()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		$consulta="SELECT * FROM 9080_arrancadoresProceso WHERE idRegistroArrancador=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="DELETE FROM 9080_arrancadoresProceso WHERE idRegistroArrancador=".$idRegistro;
		$x++;
		$query[$x]="DELETE FROM 9081_parametrosInicialesArrancadoresProceso WHERE idRegistroArrancador=".$idRegistro;
		$x++;
		
		$query[$x]="DELETE FROM 9082_etapaCambioProcesosAsociados WHERE idProcesoOrigen=".$fRegistro["idProcesoOrigen"]." AND idProcesoDestino=".$fRegistro["idProcesoDestino"]." AND numEtapaProcesoOrigen=".$fRegistro["numEtapaProcesoOrigen"];
		$x++;
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	
	function obtenerProcesosAsociadosEtapaCambio()
	{
		global $con;
		$iP=bD($_POST["iP"]);
		$nE=bD($_POST["nE"]);
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM 9080_arrancadoresProceso WHERE idProcesoOrigen=".$iP." and numEtapaProcesoOrigen=".$nE;
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$fila["idProcesoDestino"];
			$nombreProceso=$con->obtenerValor($consulta);
			$relacionProceso=1;
			
			$consulta="SELECT * FROM 9082_etapaCambioProcesosAsociados WHERE idProcesoOrigen=".$iP." AND idProcesoDestino=".$fila["idProcesoDestino"]." AND numEtapaProcesoOrigen=".$nE;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$lblFuncionAplicacion="";
			$funcionAplicacion="";
			$etapaCambio="0";
			$idRegistroProcesoAsociado=-1;
			if($fRegistro)
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".($fRegistro["funcionAplicacion"]==""?-1:$fRegistro["funcionAplicacion"]);
				$lblFuncionAplicacion=$con->obtenerValor($consulta);
				$etapaCambio=$fRegistro["numEtapaCambioProcesoDestino"];
				$idRegistroProcesoAsociado=$fRegistro["idRegistroProcesoAsociado"];
			}
			
			$arrEtapas=obtenerEtapasProcesoArregloJavaScript($fila["idProcesoDestino"]);
			
			$arrEtapas=str_replace("[[","[['0','Ninguno'],[",$arrEtapas);
			
			$o='{"idRegistro":"'.$idRegistroProcesoAsociado.'","nombreProceso":"'.cv($nombreProceso).'","etapaCambio":"'.$etapaCambio.
				'","funcionAplicacion":"'.($funcionAplicacion).'","lblFuncionAplicacion":"'.cv($lblFuncionAplicacion).'","relacionProceso":"'.
				$relacionProceso.'","idProcesoDestino":"'.$fila["idProcesoDestino"].'","etapasProceso":'.$arrEtapas.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		
		$consulta="SELECT distinct idProcesoOrigen,idProcesoDestino FROM 9080_arrancadoresProceso WHERE idProcesoDestino=".$iP;

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$fila["idProcesoOrigen"];
			$nombreProceso=$con->obtenerValor($consulta);
			$relacionProceso=2;
			
			$consulta="SELECT * FROM 9082_etapaCambioProcesosAsociados WHERE idProcesoOrigen=".$iP." AND idProcesoDestino=".$fila["idProcesoOrigen"]." AND numEtapaProcesoOrigen=".$nE;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$lblFuncionAplicacion="";
			$funcionAplicacion="";
			$etapaCambio="0";
			$idRegistroProcesoAsociado=-1;
			if($fRegistro)
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".($fRegistro["funcionAplicacion"]==""?-1:$fRegistro["funcionAplicacion"]);
				$lblFuncionAplicacion=$con->obtenerValor($consulta);
				$etapaCambio=$fRegistro["numEtapaCambioProcesoDestino"];
				$idRegistroProcesoAsociado=$fRegistro["idRegistroProcesoAsociado"];
			}
			
			$arrEtapas=obtenerEtapasProcesoArregloJavaScript($fila["idProcesoOrigen"]);
			
			$arrEtapas=str_replace("[[","[['0','Ninguno'],[",$arrEtapas);
			
			$o='{"idRegistro":"'.$idRegistroProcesoAsociado.'","nombreProceso":"'.cv($nombreProceso).'","etapaCambio":"'.$etapaCambio.
				'","funcionAplicacion":"'.($funcionAplicacion).'","lblFuncionAplicacion":"'.cv($lblFuncionAplicacion).'","relacionProceso":"'.
				$relacionProceso.'","idProcesoDestino":"'.$fila["idProcesoOrigen"].'","etapasProceso":'.$arrEtapas.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	}
	
	function registrarConfiguracionCambioEtapaProceso()
	{
		global $con;
		
		$idProceso=bD($_POST["iP"]);
		$numEtapa=bD($_POST["nE"]);
		$idProcesoDestino=bD($_POST["iPD"]);
		$valor=bD($_POST["v"]);
		$tipoRelacion=bD($_POST["tR"]);
		$valor=$valor==""?"NULL":$valor;
		
		$consulta="SELECT idRegistroProcesoAsociado FROM 9082_etapaCambioProcesosAsociados WHERE idProcesoOrigen=".$idProceso." AND idProcesoDestino=".
					$idProcesoDestino." AND numEtapaProcesoOrigen=".$numEtapa;
					
		$idRegistroProcesoAsociado=$con->obtenerValor($consulta);
		
		if($idRegistroProcesoAsociado=="")
		{
			$consulta="INSERT INTO 9082_etapaCambioProcesosAsociados(idProcesoOrigen,idProcesoDestino,numEtapaProcesoOrigen,numEtapaCambioProcesoDestino,funcionAplicacion,tipoRelacion)
					VALUES(".$idProceso.",".$idProcesoDestino.",".$numEtapa.",".$valor.",NULL,".$tipoRelacion.")";
		
		}
		else
		{
			if($valor!=0)
				$consulta="update 9082_etapaCambioProcesosAsociados set numEtapaCambioProcesoDestino=".$valor." where idRegistroProcesoAsociado=".$idRegistroProcesoAsociado;
			else
				$consulta="update 9082_etapaCambioProcesosAsociados set numEtapaCambioProcesoDestino=".$valor.",funcionAplicacion=NULL where idRegistroProcesoAsociado=".$idRegistroProcesoAsociado;
			
		}
	
	
		eC($consulta);
						
	
	}
	
	
	function registrarConfiguracionFuncionAplicacionCambioEtapaProceso()
	{
		global $con;
		
		$idRegistro=bD($_POST["iR"]);
		$idFuncionAplicacion=bD($_POST["iF"]);
	
		$consulta="UPDATE 9082_etapaCambioProcesosAsociados SET funcionAplicacion=".($idFuncionAplicacion==""?"NULL":$idFuncionAplicacion).
				" WHERE idRegistroProcesoAsociado=".$idRegistro;

		eC($consulta);
						
	
	}
	
	function registrarInvocacionScript()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idRegistro FROM 9083_ejecucionScriptCambioEtapa WHERE idProceso=".$obj->idProceso." AND numEtapa=".$obj->numEtapa;
		$idRegistro=$con->obtenerValor($consulta);
		
		
		if($idRegistro=="")
		{
			if($obj->urlScript!="")
			{
				$consulta="INSERT INTO 9083_ejecucionScriptCambioEtapa(urlScript,imprimirScript,funcionAplicacion,idProceso,numEtapa) VALUES('".cv($obj->urlScript)."',".$obj->imprimir.",".$obj->funcionAplicacion.
						",".$obj->idProceso.",".$obj->numEtapa.")";
			}
		}
		else
		{
			if($obj->urlScript!="")
			{
				$consulta="update 9083_ejecucionScriptCambioEtapa set urlScript='".cv($obj->urlScript)."',imprimirScript=".$obj->imprimir.",funcionAplicacion='".($obj->funcionAplicacion==""?-1:$obj->funcionAplicacion)."' where idRegistro=".$idRegistro;
			}
			else
			{
				$consulta="delete from 9083_ejecucionScriptCambioEtapa  where idRegistro=".$idRegistro;
			}
		}
	
		eC($consulta);
	}
	
	function obtenerActualEtapaCambioProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$nTabla=obtenerNombreTabla(bD($obj->idFormulario));
		$consulta="SELECT * FROM ".$nTabla." WHERE id_".$nTabla."=".bD($obj->idRegistro);
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$numEtapa=$fRegistro["idEstado"];
		$idProceso=obtenerIdProcesoFormulario(bD($obj->idFormulario));
		$rol=obtenerRolActorProceso(bD($obj->actor));
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$numEtapa);
		if($actor=="")
			$actor=0;
		echo "1|".$actor;
	}
	
	
	function obtenerCamposProcesoHash()
	{
		global $con;
		$idProceso=($_POST["idProceso"]);
		$numReg=0;
		$arrTipoDatos=array();
		$consulta="SELECT tipoDatoServidor,nombreTipoDato FROM 9063_tiposValoresDato ORDER BY tipoDatoServidor";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrTipoDatos[$fila["tipoDatoServidor"]]=$fila["nombreTipoDato"];
		}
		
		$idFormularioBase=obtenerFormularioBase($idProceso);
		
		$arrRegistros="";
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		$consulta="SELECT COLUMN_NAME,DATA_TYPE,(select count(*) FROM 9017_camposControlFormulario where campoMysql=c.COLUMN_NAME) esCampoDefault  
					FROM information_schema.COLUMNS c WHERE TABLE_SCHEMA='".$con->bdActual."' AND  TABLE_NAME='".$nombreTabla."' AND COLUMN_NAME not in('id_".$nombreTabla."','idReferenciaArrancador') ";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$consulta="SELECT * FROM 00016_camposHashProceso WHERE idProceso=".$idProceso." and campoTablaDestino='".$fila["COLUMN_NAME"]."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			
			
			$o='{"nombreCampo":"'.$fila["COLUMN_NAME"].'","esCampoDefault":"'.($fila["esCampoDefault"]>0?"1":"0").'","tipoDato":"'.(isset($arrTipoDatos[$fila["DATA_TYPE"]])?$arrTipoDatos[$fila["DATA_TYPE"]]:"Otro").
				'","campoHash":'.($fRegistro?"true":"false").'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function registrarCamposHash()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00016_camposHashProceso WHERE idProceso=".$obj->idProceso;
		$x++;
		foreach($obj->arrRegistros as $r)
		{
			$consulta[$x]="INSERT INTO 00016_camposHashProceso(idProceso,campoTablaDestino) values(".$obj->idProceso.",'".cv($r->campo)."')";
			$x++;
		}
		$consulta[$x]="UPDATE 4001_procesos SET hashDiferenciaTiempo=".$obj->minutosDiferencia." WHERE idProceso=".$obj->idProceso;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerEtapasProcesoDiseno()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		
		$consulta="SELECT idEtapa,numEtapa,nombreEtapa,if(marcaFinProceso='1','S&iacute;','No') as marcaFinProceso FROM 4037_etapas WHERE idProceso=".$idProceso;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));		
		echo '{"registros":'.$arrRegistros.',"numReg":"'.$con->filasAfectadas.'"}';
	}
	
	function obtenerFormulariosProcesoDiseno()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		
		$consulta="select idFormulario,nombreFormulario,titulo,f.descripcion,fechaCreacion,f.eliminable,e.nombreEtapa from 900_formularios f,4037_etapas e 
				where e.idProceso=f.idProceso and e.numEtapa=f.idEtapa and f.idProceso=".$idProceso." and f.tipoFormulario not in(10,20) order by tipoFormulario,nombreFormulario";
				
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));		
		echo '{"registros":'.$arrRegistros.',"numReg":"'.$con->filasAfectadas.'"}';		
				
		
	}
	
	function actualizarEdicionForzadaElementoDTD()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$edicionForzada=$_POST["edicionForzada"];
		$consulta="update 203_elementosDTD set funcionEdicionForzada=".$edicionForzada." where idElementoDTD=".$idElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarTextoElementoDTD()
	{
		global $con;
		$cadObj=$_POST["cadObj"];		
		$obj=json_decode($cadObj);
		
		$consulta="update 900_formularios set nombreFormulario='".cv($obj->etiqueta)."' where idFormulario=".$obj->idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	
	
?>