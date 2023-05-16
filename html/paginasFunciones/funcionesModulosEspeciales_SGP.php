<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/funcionesDocumentos.php");
	include_once("sgjp/funcionesAgenda.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("funcionesActores.php");
	include_once("sgjp/funcionesInterconexionSGJ.php");
	include_once("latisErrorHandler.php");
	include_once("cConectoresGestorContenido/administradorConexionesGestorDocumental.php");
	

	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			registrarDocumentoSGP();
		break;
		case 2:
			firmarDocumentoSGP();
		break;
		case 3:
			generarDocumentoPDFSGP();
		break;
		case 4:
			obtenerUnidadesGestionEdificio();
		break;
		case 5:
			obtenerSalasUnidadesGestion();
		break;
		case 6:
			obtenerEventosSalas();
		break;
		case 7:
			obtenerParticipantesSolicitud();
		break;
		case 8:
			removerParticipanteSolicitud();
		break;
		case 9:
			obtenerDelitosSolicitud();
		break;
		case 10:
			removerDelitoSolicitud();
		break;
		case 11:
			obtenerDatosEventoAudienciaControl();
		break;
		case 12:
			registrarModificacionEdificioUnidadGestion();
		break;
		case 13:
			obtenerJuecesDisponiblesUnidadGestionEvento();
		break;
		case 14:
			registrarModificacionJuez();
		break;
		case 15:		
			registrarModificacionFechaSala();
		break;
		case 16:		
			obtenerEventosModificacionFechaSala();
		break;
		case 17:		
			obtenerSujetosProcesalesCarpetaAdministrativa();
		break;
		case 18:
			obtenerProcesosCarpetaAdministrativa();
		break;
		case 19:
			obtenerDocumentosCarpetaAdministrativa();
		break;
		case 20:
			obtenerAccionesTableroControlDisponibles();
		break;
		case 21:
			obtenerHistorialAudiencias();
		break;
		case 22:
			obtenerHistorialAccionesAudiencia();
		break;
		case 23:
			registrarDocumentoAdjuntoReferenciaProceso();
		break;
		case 24:	
			registrarDocumentoAdjuntoCarpetaAdministrativa();
		break;
		case 25:
			obtenerEventosAudienciaAuxiliarSala();
		break;
		case 26:
			registrarDocumentoEventoAudiencia();
		break;
		case 27:
			obtenerFigurasJuridicasNotificacion();
		break;
		case 28:
			asignarNotificadorSolicitud();
		break;
		case 29:
			obtenerAuxiliaresSalaDisponibles();
		break;
		case 30:
			asignarAuxiliarSalaEvento();
		break;
		case 31:
			obtenerEntidadesCitacion();
		break;
		case 32:
			verificarCedulaProfesional();
		break;
		case 33:
			obtenerElementoApoyoBilioteca();
		break;
		case 34:
			obtenerConfiguracionProcesoTablero();
		break;
		case 35:
			obtenerActorProcesoDocumentos();
		break;
		case 36:
			obtenerDatosSolicitudAudienciaIntermedia();
		break;
		case 37:
			obtenerOtrasAudienciasPosteriorEvento();
		break;
		case 38:
			registrarDocumentoPromociones();
		break;
		case 39:
			obtenerEventosJuezAgenda();
		break;
		case 40:
			obtenerRegistroAplicacionAccionAudiencia();
		break;
		case 41:
			obtenerResolutivosAccionesEventoAudiencia();
		break;
		case 42:
			obteneDatosParticipanteAudiencia();
		break;
		case 43:
			obtenerProcesoOrigen();
		break;
		case 44:
			obtenerFolioRegistroSolicitud();
		break;
		case 45:
			obtenerProcesosAsociadosFormulario();
		break;
		case 46:
			marcarNotificacionesTableroControl();
		break;
		case 47:
			buscarCarpetaAdministrativa();
		break;
		case 48:
			obtenerEventosAudienciaSGJP();
		break;
		case 49:
			obtenerEventosAudienciaJuez();
		break;
		case 50:
			obtenerCarpetasAdministrativasUnidadGestion();
		break;
		case 51:
			obtenerRegistroIncompetencia();
		break;
		case 52:
			obtenerRegistroProgramacionAudiencia();
		break;
		case 53:
			obtenerEventosAudienciaSGJPCarpetaJudicial();
		break;
		case 54:
			obtenerRegistroProgramacionAudienciaCarpeta();
		break;
		case 55:
			obtenerArbolCarpetaJudicial();
		break;
		case 56:
			removerDocumentoCarpetaAdministrativa();
		break;
		case 57:
			actualizarTipoDocumento();
		break;
		case 58:
			obtenerRegistroProceso();
		break;
		case 59:
			obtenerRegistroModificacionAudiencia();
		break;
		case 60:
			generarReporteAudiencias();
		break;
		case 61:
			obtenerEventosAudienciaSGJPReporte();
		break;
		case 62:
			obtenerCarpetasAdministrativasReporte();
		break;
		case 63:
			obtenerResolutivosAudiencia();
		break;
		case 64:
			guardarInformeAudiencia();
		break;
		case 65:
			finalizarInformeEventoAudiencia();
		break;
		case 66:
			registrarMedidaCautelar();
		break;
		case 67:
			obtenerMedidasCautelaresActividad();
		break;
		case 68:
			removerMedidaCautelar();
		break;
		case 69:
			actualizarTipoAudienciaEvento();
		break;
		case 70:
			obtenerRegistroRemisionUGA();
		break;
		case 71:
			guardarModificacionHoraDesarrolloAudiencia();
		break;
		case 72:
			obtenerRegistroTribunalEnjuiciamiento();
		break;
		case 73:
			obtenerRegistroEjecucion();
		break;
		case 74:
			obtenerMedidasProteccionActividad();
		break;
		case 75:
			obtenerMedidasSuspensionCondicionalActividad();
		break;
		case 76:
			registrarMedidaProteccion();
		break;
		case 77:
			registrarMedidaSuspension();
		break;
		case 78:
			removerMedidaProteccion();
		break;
		case 79:
			removerCondicionSuspension();
		break;
		case 80:
			obtenerResultadoBusquedaCarpetaJudicial();
		break;
		case 81:
			obtenerURLVideoMAJO();
		break;
		case 82:
			actualizarDuracionMAJO();
		break;
		case 83:
			enviarEventoMAJO();
		break;
		case 84:
			obtenerProcoloAudiencia();
		break;
		case 85:
			registrarProtocoloAudiencia();
			
		break;
		case 86:
			finalizarRegistroProtocoloAudiencia();
			
		break;
		case 87:
			obtenerRegistroFichaIdentificacion();
		break;
		case 88:
			obtenerDatosFichaIdentificacion();
		break;
		case 89:
			obtenerMunicipiosEstado();
		break;
		case 90:
			obtenerJuecesJuicioAmparo();
		break;
		case 91:
			obtenerJuecesJuicioAmparoSL();
		break;
		case 92:
			obtenerAcuerdoAudiencia();
		break;
		case 93:
			obtenerJuecesConocenCausa();
		break;
		case 94:
			obtenerDocumentosJueces();
		break;
		case 95:
			guardarConocimientoJuezAmparo();
		break;
		case 96:
			generarDocumentosInforme();
		break;
		case 97:
			obtenerActorProcesoDocumentoAmparo();
		break;
		case 98:
			registrarRequerimientosEspecialesSolicitudAudiencia();
		break;
		case 99:
			liberarProgramacionEventoAudiencia();
		break;
		case 100:
			registrarDatosAcuerdoReparatorio();
		break;
		case 101:
			removerDatosAcuerdoReparatorio();
		break;
		case 102:
			obtenerAcuerdosReparatoriosAudiencia();
		break;
		case 103:
			obtenerAcuerdosReparatoriosImputado();
		break;
		case 104:
			obtenerTotalAcuerdosReparatoriosImputado();
		break;
		case 105:
			obtenerDelitosImputadoComputoPena();
		break;
		case 106:
			registrarSentenciaImputadoComputoPena();
		break;
		case 107:
			obtenerBeneficiosPenitenciarios();
		break;
		case 108:
			obtenerActorConfirmacionAudiencia();
		break;
		case 109:
			generarReporteAudienciasV2();
		break;
		case 110:
			determinarRequiereCentroReclusion();
		break;
		case 111:
			obtenerEvaluacionActuacionJudicial();
		break;
		case 112:
			obtenerRegistroEjecucionV2();
		break;
		case 113:
			registrarSentenciaEjecucion();
		break;
		case 114:
			obtenerSentenciaEjecucion();
		break;
		case 115:
			removerSentenciaEjecucion();
		break;
		case 116:
			obtenerDatosContactoParticipante();
		break;
		case 117:
			actualizarDatosContactoParticipante();
		break;
		case 118:
			obtenerFigurasJuridicasCarpetaAdministrativa();
		break;
		case 119:
			obtenerMedioNotificacionActaCircunstanciada();
		break;
		case 120:
			registrarDatosDiligencia();
		break;
		case 121:
			obtenerDiligenciasActa();
		break;
		case 122:
			removerDiligenciaActa();
		break;
		case 123:
			guardarDatosActaMinima();
		break;
		case 124:
			obtenerActasCircunstanciadas();
		break;
		case 125:
			removerActaCircunstanciada();
		break;
		case 126:
			generarDocumentoEditorTexto();
		break;
		case 127:
			obtenerMediosNotificacionFundamento();
		break;
		case 128:
			registrarFundamentoLegalMedioNotificacion();
		break;
		case 129:
			removerFundamentoLegalMedioNotificacion();
		break;
		case 130:
			finalizarActaCircunstanciada();
		break;
		case 131:
			obtenerDocumentoPDFEditorFormato();
		break;
		case 132:
			generarIncidenciasAudiencia();
		break;
		case 133:
			obtenerDelitosEjecucion();
		break;
		case 134:
			agregarDelitoSentencia();
		break;
		case 135:
			removerDelitoSentencia();
		break;
		case 136:
			obtenerPenasSetenciaCarpetaEjecucion();
		break;
		case 137:
			obtenerPenasPrescripcion();
		break;
		case 138:
			obtenerInformacionPenaPrescripcion();
		break;
		case 139:
			registrarPrescripcion();
		break;
		case 140:
			cancelarPrescripcion();
		break;
		case 141:
			obtenerPrescripciones();
		break;
		case 142:
			obtenerPlantillasModeloV2();
		break;
		case 143:
			obtenerPlantillaDocumentoV2();
		break;
		case 144:
			registrarInformacionDocumentoV2();
		break;
		case 145:
			obtenerDocumentosGeneradosCarpeta();
		break;
		case 146:
			removerDocumentoGeneradoCarpeta();
		break;
		case 147:
			marcarDocumentoFirmadoGeneradoCarpeta();
		break;
		case 148:
			obtenerEstructuraOrganizacionalUGA();
		break;
		case 149:
			obtenerClasificacionTipoDelitoCarpeta();
		break;
		case 150:
			turnarDocumento();
		break;
		case 151:
			obtenerHistorialDocumento();
		break;
		case 152:
			marcarTareaDocumentoRealizada();
		break;
		case 153:
			obtenerDocumentoFinalPDFEditorFormato();
		break;
		case 154:
			aperturarCapturaResolutivos();
		break;
		case 155:
			obtenerHistorialCambiosCarpeta();
		break;
		case 156:
			registrarCambioStatusCarpeta();
		break;
		case 157:
			formatearExposicionDiligencia();
		break;
		case 158:
			obtenerDatosPrescripcion();
		break;
		case 159:
			cambiarStatusAlertaNotificacion();
		break;
		case 160:
			registarAlertaNotificacion();
		break;
		case 161:
			obtenerDatosGeneralesEntregaDiscos();
		break;
		case 162:
			obtenerBitacoraEntregaDiscos();
		break;
		case 163:
			obtenerSituacionCopiasDiscoCarpeta();
		break;
		case 164:
			obtenerAudienciasCarpetaJudicial();
		break;
		case 165:
			obtenerCarpetasEjecucionActualizacion();
		break;
		case 166:
			obtenerSentenciadosCarpetas();
		break;
		case 167:
			finalizarActualizacionCarpetaEjecucion();
		break;
		case 168:
			removerImputadoCarpetaEjecucion();
		break;
		case 169:
			esHorarioAtencionTramite();
		break;
		case 170:
			registrarModificacionDocumentoWord();
		break;
		case 171:
			registrarAltaEmpleadoOrganigrama();
		break;
		case 172:
			registrarBajaEmpleadoOrganigrama();
		break;
		case 173:
			obtenerConcentradoPenasEjecucion();
		break;
		case 174:
			obtenerAudienciasProgramadasCarpetaJudicial();
		break;
		case 175:
			obtenerCarpetasEjecucionListaCarpetas();
		break;
		case 176:
			obtenerPuestosEstructuraOrganizacionUGJ();
		break;
		case 177:
			agregarPuestoEstructuraUGJ();
		break;
		case 178:
			removerPuestoEstructuraUGJ();
		break;
		case 179:
			obtenerDocumentosPermitidosModuloGeneracionDocumentos();
		break;
		case 180:
			agregarDocumentosPermitidosModuloGeneracionDocumentos();
		break;
		case 181:
			removerDocumentosPermitidosModuloGeneracionDocumentos();
		break;
		case 182:
			obtenerFormatosDocumentosPermitidosModuloGeneracionDocumentos();
		break;
		case 183:
			registrarSituacionPena();
		break;
		case 184:
			obtenerHistorialPena();
		break;
		case 185:
			registrarAcogeSuspencionCondicionalPena();
		break;
		case 186:
			registrarAcogeSustitutivo();
		break;
		case 187:
			registrarCancelacionAcogimientoSustitutivo();
		break;
		case 188:
			obtenerPlantillasModeloSeleccion();
		break;

		case 189:
			obtenerEventosFechaSala();
		break;
		case 190:
			registrarCategoriaDcumentoAdjunto();
		break;		
		case 191:
			obtenerFechaAudienciaDiasHabiles();
		break;
		case 192:
			obtenerUltimoJuezAudienciaCarpeta();
		break;
		case 193:
			validarDisponibilidadJuezAudiencia();
		break;

		case 194:
			obtenerDocumentosFirmadoPromocionAmparo();
		break;
		case 195:
			registrarNotificacionPromocionAmparo();
		break;
		case 196:
			obtenerNotificacionesPromocionAmparo();
		break;
		case 197:
			eliminarNotificacionesPromocionAmparo();
		break;
		case 198:
			enviarNotificacionConsejo();
		break;
		case 199:
			obtenerRegistroEjecucionPP();
		break;
		case 200:
			obtenerListadoActasMinimas();
		break;

		case 201:
			registrarEventoControl();
		break;
		case 202:
			obtenerJuezAsignacion();
		break;
		case 203:
			obtenerJuezTramiteFecha();
		break;
		case 204:
			obtenerJuecesDisponiblesUnidadGestionEventoCambio();
		break;
		case 205:
			obtenerInformeIndicador();
		break;
		case 206:
			obtenerAsignacionesAudienciaJuez();
		break;
		case 207:
			registrarValorParametro();
		break;
		case 208:	
			buscarParticipanteAudiencia();	
		break;
		case 209:
			guardarRelacionFiguraExistente();
		break;
		case 210:
			obtenerDatosIdentificacion();
		break;
		case 211:
			obtenerCuentasAccesoUsuariosCarpeta();
		break;
		case 212:
			crearCuentaAcesoUsuariosCarpeta();
		break;
		case 213:
			cambiarSituacionUsuariosCarpeta();
		break;
		case 214:
			obtenerHistorialCuentasAcceso();
		break;

		case 218:
			obtenerCarpetasAdministrativasUnidadGestionCautelares();
		break;
		case 215:
			actualizarSituacionParticipante();
		break;
		case 216:
			registrarNuevasRelacionesParticipantes();
		break;
		case 217:
			obtenerHistorialParte();
		break;
		case 219:
			obtenerDocumentoFinalPDFEditorFormatoActor();
		break;
		case 220:
			idDocumentoIdRegistroFormato();
		break;
		case 221:
			obtenerMedidasCautelaresImputado();
		break;
		case 222:
			obtenerEventosAudienciaSGJPEvaluacion();
		break;
		case 223:
			registrarParticipanteActividad();
		break;
		case 224:
			obtenerHistorialJuezAudiencia();
		break;
		case 225:
			obtenerReporteNotificacionesCJF();
		break;
		case 226:
			buscarExhortoRegistrado();
		break;
		case 227:
			buscarExhortoRegistradosGrid();
		break;
		case 228:
			buscarEdificioFiscalia();
		break;
		case 229:
			buscarPosibleUnidadDestino();
		break;
		case 230:
			registrarCambioSituacionAcuerdoReparatorio();
		break;
		case 231:
			obtenerBitacoraCambiosAcuerdo();
		break;
		case 232:
			obtenerResolutivosAudienciaDisponibles();
		break;
		case 233:
			guardarResolutivoAudiencia();
		break;
		case 234:
			removerResolutivoAudiencia();
		break;
		case 235:
			obtenerMensajesEnviados();
		break;
		case 236:
			registrarMensajesEnviados();
		break;
		case 237:
			registrarRespuestaMensajesEnviados();
		break;
		case 238:
			obtenerMensajesEnviadosDestinatario();
		break;

		case 250:
			obtenerSolicitudesUGAS();
		break;
		case 251:
			obtenerTareasAsociadasProceso();
		break;
		case 252:
			marcarSolicitudInicialAtendida();
		break;
		case 253:
			obtenerCarpetasSeguimientoMediatico();
		break;
		case 254:
			obtenerRegistrosProceso();
		break;
		case 255:
			obtenerAcuerdosReparatoriosCarpetaJudicial();
		break;
		case 256:
			actualizarSeguimientoMail();
		break;
		case 300:
			buscarAntecedenteSalaPenal();
		break;
		case 301:
			buscarAntecedenteSalaPenalInicioProceso();
		break;
		case 302:
			obtenerRecursosAudiencia();
		break;
		case 303:
			obtenerEventosRecursosAdicionalesAudiencia();
		break;
		case 304:
			obtenerRecursosAdicionalesAudiencia();
		break;
		case 305:
			obtenerAudienciasCabinas();
		break;
		case 306:
			enviarEventoCabina();
		break;
		case 307:
			removerRecursoAdicional();
		break;
		case 308:
			registrarRecursoAdicional();
		break;
		case 310:
			obtenerRegistroProgramacionAudienciaCarpetaPenalTradicional();
		break;
		case 311:
			enviarNotificacionEventoMailPenal();
		break;
		case 312:
			obtenerPartesProcesalesAutorizacionVideoGrabacion();
		break;
		case 313:
			removerDocumentoAutorizacion();
		break;
		case 314:
			actualizarNoAplicaVideograbacion();
		break;
		case 315:
			activarAudienciasVirtuales();
		break;
		case 316:
			obtenerParticipantesAudienciaVirtual();
		break;
		case 317:
			actualizarCamposAudienciaVirtual();
		break;
		case 318:
			cambiarSituacionProgramacionAudienciaVirtualCarpeta();
		break;
		case 319:
			obtenerHistorialProgramacionAudienciaVirtual();
		break;
		case 320:
			asociarCuentaAccesoCarpeta();
		break;
		case 321:
			obtenerParticipantesConfAudienciaVirtual();
		break;
		case 322:	
			obtenerSolicitudesMedidasProteccionUGAS();
		break;
		case 323:
			obtenerEventosAudienciaSGJPLAMVLVCDMX();
		break;
		case 400:	
			registrarDocumentoScanCarpetaJudicial();
		break;
		case 401:
			eliminarDocumentosScanSession();
		break;
		case 402:
			registrarCuadernilloExpediente();
		break;
		case 403:
			modificarCuadernilloExpediente();
		break;
		case 404:
			removerCuadernilloExpediente();
		break;
		case 405:
			obtenerHistorialExpediente();
		break;
		case 406:
			realizarMovimientoElemento();
		break;
		case 407:
			marcarAlertaNotificacionEsperaAtencion();
		break;
		case 408:
			obtenerRegistroGeneracionOficio();
		break;
		

	}



function registrarDocumentoSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode(bD($cadObj));
	$obj->cuerpoFormato=bE(removerCaracteresNoImprimiblesPlantilla(bD($obj->cuerpoFormato)));
	$idPerfilEvaluacion="-1";
	$x=0;
	$consulta[$x]="begin";
	$x++;
	if($obj->idRegistroFormato==-1)
	{
		
		$query="SELECT perfilValidacion FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$obj->tipoFormato;
		$idPerfilEvaluacion=$con->obtenerValor($query);
		if($idPerfilEvaluacion=="")
			$idPerfilEvaluacion=-1;
		
		$consulta[$x]="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,cuerpoFormato,
						idFormulario,idRegistro,idReferencia,firmado,cadenaFirma,formatoPDF,idFormularioProceso,idPerfilEvaluacion,configuracionDocumento)
				VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoFormato.",'".$obj->cuerpoFormato."',".
				$obj->idFormulario.",".$obj->idRegistro.",".$obj->idReferencia.
				",0,'','',".$obj->idFormularioProceso.",".$idPerfilEvaluacion.",'".(isset($obj->objConfiguracion)?$obj->objConfiguracion:"")."')";
		$x++;		
		$consulta[$x]="set @idRegistroFormato:=(select last_insert_id())";
		$x++;
		
		
	}
	else
	{
		$consulta[$x]="set @idRegistroFormato:=".$obj->idRegistroFormato;
		$x++;
		$query="SELECT * FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$fFormato=$con->obtenerPrimeraFila($query);	
		
		
		
		if(($fFormato[4]!=$obj->cuerpoFormato)||(isset($obj->objConfiguracion) && ($fFormato[19]!=$obj->objConfiguracion)))
		{
			$consulta[$x]="INSERT INTO 3001_respaldoFormatoRegistrados(idRegistroFormato,fechaRegistro,idResponsableRegistro,cuerpoFormato,configuracionDocumento) 
						    SELECT idRegistroFormato,fechaRegistro,idResponsableRegistro,cuerpoFormato,configuracionDocumento FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$x++;
			$consulta[$x]="UPDATE 3000_formatosRegistrados SET fechaRegistro='".date("Y-m-d H:i:s")."',idResponsableRegistro='".$_SESSION["idUsr"].
						"',cuerpoFormato='".$obj->cuerpoFormato."',configuracionDocumento='".(isset($obj->objConfiguracion)?$obj->objConfiguracion:"")."' WHERE idRegistroFormato=".$obj->idRegistroFormato;
			$x++;
		}
		
	}
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		if($obj->idRegistroFormato==-1)
		{
			$query="select @idRegistroFormato";
			$obj->idRegistroFormato=$con->obtenerValor($query);
			if($idPerfilEvaluacion!=-1)		
			{
				$consulta="SELECT noEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND etapaInicial=1";
				$etapaCambio=$con->obtenerValor($consulta);
				
				
				$rolActual=obtenerRolActualDocumento($obj,$idPerfilEvaluacion,$etapaCambio,-1);
				cambiarSituacionDocumento($obj->idRegistroFormato,$rolActual,$etapaCambio,"",$rolActual,0,0);
			}
			
			
		}
		echo "1|".$obj->idRegistroFormato;
	}
	
	
}

function firmarDocumentoSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$idDocumento="NULL";
	$documentoBloqueado=0;
	
	
	$consulta="SELECT idFormulario,idRegistro,idDocumentoAdjunto FROM 3000_formatosRegistrados 
			WHERE idRegistroFormato=".$obj->idRegistroFormato;
	$fFormato=$con->obtenerPrimeraFila($consulta);
	
	if(isset($obj->idArchivo))
	{
		
		$consulta="SELECT tipoFormato FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroFormato;
		$tipoFormato=$con->obtenerValor($consulta);
		
		$consulta="SELECT categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoFormato;
		$fDatosDocumento=$con->obtenerPrimeraFila($consulta);
		
		$idRegistro=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->cadena,$fDatosDocumento[0]);
		if($idRegistro==-1)
		{
			return;
		}	
		$idDocumento=$idRegistro;
		$obj->cadena="";
		$documentoBloqueado=1;
		
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
		if($carpetaAdministrativa!="")
			registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idRegistro,$fFormato[0],$fFormato[1]);
		
		registrarDocumentoResultadoProceso($fFormato[0],$fFormato[1],$idRegistro);
			
	}
	else
	{
		if($fFormato[2]!="")
		{
			$idDocumento=$fFormato[2];
			$documentoBloqueado=1;
			$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($fFormato[0],$fFormato[1]);
			if($carpetaAdministrativa!="")
				registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,$fFormato[0],$fFormato[1]);			
			registrarDocumentoResultadoProceso($fFormato[0],$fFormato[1],$idDocumento);
		}
	}
	

	$consulta="UPDATE 3000_formatosRegistrados SET fechaFirma='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumento.",cadenaFirma='".$obj->cadena."',firmado=1,responsableFirma=".$_SESSION["idUsr"].",documentoBloqueado=".$documentoBloqueado." 
				WHERE idRegistroFormato=".$obj->idRegistroFormato;
				
	if($con->ejecutarConsulta($consulta))
	{
		
		if(isset($obj->idArchivo)||($fFormato[2]!=""))
		{
			if(isset($obj->etapaEnvioFirma))
			{
				cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
			}
			echo "1|";
		}
		else
		{
			if(generarDocumentoPDFFormato($obj->idRegistroFormato,true,1))
			{
				if(isset($obj->etapaEnvioFirma))
				{
					cambiarSituacionDocumento($obj->idRegistroFormato,$obj->rolDestinatarioEnvioFirma,$obj->etapaEnvioFirma,$obj->comentariosAdicionales,$obj->rolActual,0,$obj->usuarioDestino);
				}
				echo "1|1";
			}
		}
	}
}

function generarDocumentoPDFSGP()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	if(generarDocumentoPDFFormato($obj->idRegistroFormato,false,0,(isset($obj->conversorPDF)?$obj->conversorPDF:-1),(isset($obj->documentoAdexos)?$obj->documentoAdexos:"")))
	{
		echo "1|1";
	}
}

function obtenerUnidadesGestionEdificio()
{
	global $con;
	$idEdifico=$_POST["idEdificio"];
	$consulta="SELECT id__17_tablaDinamica,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) FROM _17_tablaDinamica WHERE idReferencia=".$idEdifico." ORDER BY claveUnidad";
	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrUnidadesGestion;
	
}

function obtenerSalasUnidadesGestion()
{
	global $con;
	$fechaAudiencia=$_POST["fechaAudiencia"];
	$idUnidadGestion=$_POST["idUnidadGestion"];
	$tipoAudiencia=-1;
	if(isset($_POST["tipoAudiencia"]))
		$tipoAudiencia=$_POST["tipoAudiencia"];
	$idEdificio=$_POST["idEdificio"];
	
	$carpetaAdministrativa="";
	if(isset($_POST["carpetaAdministrativa"]))
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	
	$arrSalas=obtenerSalasAudiencia($idUnidadGestion,$idEdificio,$tipoAudiencia,$carpetaAdministrativa,$fechaAudiencia);
	
	
	
	echo "1|".$arrSalas;
	
}

function obtenerEventosSalas()
{
	global $con;
	$idSala=$_POST["idSala"];
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) FROM 7000_eventosAudiencia a
				WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."'";

	$arrEventos="";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$e='{"editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
		
	echo '['.$arrEventos.']';
	
}

function obtenerParticipantesSolicitud()
{
	
	global $con;
	$idActividad=$_POST["idActividad"];
	$figuraJuridica=$_POST["figuraJuridica"];
	$consulta="SELECT id__47_tablaDinamica AS idRegistro,figuraJuridica AS tipoFigura,tipoPersona,nombre,apellidoPaterno AS apPaterno,apellidoMaterno AS apMaterno,edad,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (Víctima)') SEPARATOR '<br>') 
				FROM _47_chkVictimas c,_47_tablaDinamica p WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica ORDER BY nombre,apellidoPaterno,apellidoMaterno) as asesorados,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (Imputado)') SEPARATOR '<br>') 
				FROM _47_chkImputados c,_47_tablaDinamica p WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica ORDER BY nombre,apellidoPaterno,apellidoMaterno) as defendidos,
				(SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno),' (',f.nombreTipo,')') SEPARATOR ', ') 
				FROM _47_chkImputadosVictimas c,_47_tablaDinamica p,_5_tablaDinamica f,7005_relacionFigurasJuridicasSolicitud rf 
				WHERE idPadre=t.id__47_tablaDinamica AND c.idOpcion=p.id__47_tablaDinamica and rf.idParticipante=p.id__47_tablaDinamica and rf.idFiguraJuridica=f.id__5_tablaDinamica and rf.idFiguraJuridica in (2,4)
				ORDER BY nombre,apellidoPaterno,apellidoMaterno) as representados,
				requiereDefensoria,imputadoDetenido as detenido,
				if(imputadoDetenido=1,if(lugarReclusorio=1,'Galeras','Reclusorio'),'') as lugarDetencion,
				(SELECT nombre FROM _2_tablaDinamica WHERE id__2_tablaDinamica=t.reclusorioDetencion) as reclusorio,cedulaProfesional,
				(if(".$figuraJuridica."=5,'1','0')) as tipoDefensor				
				 FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r WHERE t.id__47_tablaDinamica=r.idParticipante AND 
				 r.idFiguraJuridica=".$figuraJuridica." and t.id__47_tablaDinamica=r.idParticipante and 
				r.idActividad=".$idActividad." order by nombre,apellidoPaterno,apellidoMaterno";

	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	
}

function removerParticipanteSolicitud()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$figuraJuridica=$_POST["figuraJuridica"];
	$idActividad=-1;
	if(isset($_POST["idActividad"]))
	{
		$idActividad=$_POST["idActividad"];
	}
	$consulta="select idCuentaAcceso from 7005_relacionFigurasJuridicasSolicitud WHERE  idParticipante=".$idRegistro." AND idFiguraJuridica=".$figuraJuridica;
	if($idActividad!=-1)
		$consulta.=" and idActividad=".$idActividad;
		
	$idCuentaAcceso=$con->obtenerValor($consulta);
	if($idCuentaAcceso=="")
		$idCuentaAcceso=-1;
	
	$consulta="DELETE FROM 7005_relacionFigurasJuridicasSolicitud WHERE  idParticipante=".$idRegistro." AND idFiguraJuridica=".$figuraJuridica;
	if($idActividad!=-1)
		$consulta.=" and idActividad=".$idActividad;
		
	$con->ejecutarConsulta($consulta);
	$consulta="select count(*) from 7005_relacionFigurasJuridicasSolicitud WHERE  idParticipante=".$idRegistro;
	$nReg=$con->obtenerValor($consulta);
	if($nReg==0)
	{
		$consulta="delete FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idRegistro;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="DELETE FROM 800_usuarios WHERE idUsuario=".$idCuentaAcceso." and tipoCreacion=2";
			eC($consulta);
		}
	}
	else
		echo "1|";
	
	
	
}

function obtenerDelitosSolicitud()
{
	
	global $con;
	$idActividad=$_POST["idActividad"];
	$consulta="SELECT id__61_tablaDinamica AS idRegistro,tituloDelito,capituloDelito,denominacionDelito,modalidadDelito,calificativo,gradoRealizacion 
			FROM _61_tablaDinamica WHERE idActividad=".$idActividad;
	//$arrRegistros=$con->obtenerFilasJSON($consulta);
	$arrRegistros="";
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		$consulta="SELECT d.idReferencia AS capitulo,c.idReferencia AS titulo FROM _35_denominacionDelito AS d,_35_tablaDinamica c 
					WHERE id__35_denominacionDelito=".$fila[3]." AND c.id__35_tablaDinamica=d.idReferencia";
		$filaDelito=$con->obtenerPrimeraFila($consulta);
		
		
		
		$lblImputable="";
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(p.nombre,' ',p.apellidoPaterno,' ',p.apellidoMaterno))  FROM _61_chkDelitosImputado d,
					_47_tablaDinamica p WHERE idPadre=".$fila[0]." AND p.id__47_tablaDinamica=d.idOpcion";
		$lblImputable=$con->obtenerListaValores($consulta);
		
		
		$o='{"idRegistro":"'.$fila[0].'","tipoDelito":"'.$filaDelito[1].'","capitulo":"'.$filaDelito[0].'","denominacion":"'.$fila[3].
			'","modalidadDelito":"'.$fila[4].'","calificativo":"'.$fila[5].'","gradoRealizacion":"'.$fila[6].'","imputableA":"'.$lblImputable.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function removerDelitoSolicitud()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$consulta="delete FROM _61_tablaDinamica WHERE id__61_tablaDinamica=".$idRegistro;
	eC($consulta);
	
}

function obtenerDatosEventoAudienciaControl()
{
	global $con;
	$idEvento=$_POST["iE"];
	$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
	
	if($fDatosEvento["idEdificio"]=="")
		$fDatosEvento["idEdificio"]=-1;
	
	$consulta="SELECT CONCAT('[',cveInmueble,'] ',nombreInmueble) FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$fDatosEvento["idEdificio"];
	$nombreInmueble=$con->obtenerValor($consulta);
		
	if($fDatosEvento["idCentroGestion"]=="")
		$fDatosEvento["idCentroGestion"]=-1;	
	
	if($con->existeCampo("claveFolioCarpetas","_17_tablaDinamica"))
		$consulta="SELECT CONCAT('[',if(claveFolioCarpetas is null,'',claveFolioCarpetas),'] ',nombreUnidad) FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
	else
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];

	
	$nombreUnidadGestion=$con->obtenerValor($consulta);
	
	if($fDatosEvento["idSala"]=="")
		$fDatosEvento["idSala"]=-1;
	$consulta="SELECT if(claveSala is not null and claveSala<>'',concat('[',claveSala,'] ',''),nombreSala) FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fDatosEvento["idSala"];
	$nombreSala=$con->obtenerValor($consulta);
	$arrJueces="";
	$consulta="SELECT idRegistroEventoJuez,idJuez,tipoJuez,titulo,noJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$resJueces=$con->obtenerFilas($consulta);
	while($fJueces=$con->fetchRow($resJueces))
	{
		//$consulta="SELECT CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica t,800_usuarios u WHERE usuarioJuez=u.idUsuario AND u.idUsuario=".$fJueces[1];//." AND idReferencia=".$fDatosEvento["idCentroGestion"];

		//$nombreJuez=$con->obtenerValor($consulta);
		$nombreJuez="[".$fJueces[4]."] ".obtenerNombreUsuario($fJueces[1]);
		
		$oJueces='{"idRegistroEventoJuez":"'.$fJueces[0].'","idJuez":"'.$fJueces[1].'","tipoJuez":"'.$fJueces[2].'","titulo":"'.cv($fJueces[3]).'","nombreJuez":"'.cv($nombreJuez).'"}';
		if($arrJueces=="")
			$arrJueces=$oJueces;
		else
			$arrJueces.=",".$oJueces;
	}
	
	$consulta="SELECT CONCAT('[',if(claveAudiencia is null,'',claveAudiencia),'] ',tipoAudiencia) FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fDatosEvento["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	if($fDatosEvento["otroTipoAudiencia"]!="")
		$tipoAudiencia.=": ".$fDatosEvento["otroTipoAudiencia"];
		
	$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
			WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;

	$fContenidos=$con->obtenerPrimeraFila($consulta);
	if(!$fContenidos)
	{
		$fContenidos[0]=obtenerCarpetaAdministrativaProceso($fDatosEvento["idFormulario"],$fDatosEvento["idRegistroSolicitud"]);
		$fContenidos[1]=-1;
	}
	$carpetaJudicial=$fContenidos[0];
	
	$consulta="SELECT carpetaAdministrativa,tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaJudicial."'";
	if($fContenidos[1]!="-1")
	{
		$consulta.=" and idCarpeta=".$fContenidos[1];
	}
	
	$fDatosCarpetaJudicial=$con->obtenerPrimeraFila($consulta);
	
	
	$consulta="SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=".$fDatosEvento["situacion"];
	
	$lblSituacion=$con->obtenerValor($consulta);
	
	$iFormularioSituacion=-1;
	$iRegistroSituacion=-1;
	
	switch($fDatosEvento["situacion"])
	{
		case "2"://Finalizada
			$iFormularioSituacion=321;
			$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
			$iRegistroSituacion=$con->obtenerValor($consulta);
			if($iRegistroSituacion=="")
				$iRegistroSituacion=-1;
		break;
		case "6"://Resuelta por acuerdo
			$iFormularioSituacion=322;

			$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
			$iRegistroSituacion=$con->obtenerValor($consulta);
			if($iRegistroSituacion=="")
				$iRegistroSituacion=-1;
		break;
		case "3"://Cancelado
			$iFormularioSituacion=323;
			$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fDatosEvento["idRegistroEvento"];
			$iRegistroSituacion=$con->obtenerValor($consulta);
			if($iRegistroSituacion=="")
				$iRegistroSituacion=-1;	
		break;
	}
	
	
	$requiereResguardo=0;
	$requiereMesaEvidencia=0;
	$requiereTelePresencia=0;
	$requiereTestigoProtegido=0;
	$idAuxiliar=-1;
	$idEtapaSolicitud=0;
	switch($fDatosEvento["idFormulario"])
	{
		case 46:
		case 185:
		
			$consulta="select * from _".$fDatosEvento["idFormulario"]."_tablaDinamica WHERE id__".$fDatosEvento["idFormulario"]."_tablaDinamica=".$fDatosEvento["idRegistroSolicitud"];
			$fDatosSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$idEtapaSolicitud=$fDatosSolicitud["idEstado"];
			$requiereResguardo=(!isset($fDatosSolicitud["requiereResguardo"]) || ($fDatosSolicitud["requiereResguardo"]!=1))?0:1;
			$requiereMesaEvidencia=(!isset($fDatosSolicitud["requiereMesaEvidencia"]) || ($fDatosSolicitud["requiereMesaEvidencia"]!=1))?0:1;
			$requiereTelePresencia=(!isset($fDatosSolicitud["requiereTelePresencia"]) || ($fDatosSolicitud["requiereTelePresencia"]!=1))?0:1;
			$requiereTestigoProtegido=(!isset($fDatosSolicitud["requiereTestigoProtegido"]) || ($fDatosSolicitud["requiereTestigoProtegido"]!=1))?0:1;
		
		
			$consulta="SELECT idAuxiliarSala FROM  3007_auxiliarSalaEvento WHERE idFormulario=".$fDatosEvento["idFormulario"].
						" AND idReferencia=".$fDatosEvento["idRegistroSolicitud"];
			$idAuxiliar=$con->obtenerValor($consulta);
			if($idAuxiliar=="")
				$idAuxiliar=-1;
		
		break;
	}
	
	$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$idAuxiliar;
	$nombre=$con->obtenerValor($consulta);
	
	
	$arrRecursosAdicionalesRequeridos="";
	
	if($con->existeTabla("7001_recursosAdicionalesAudiencia"))
	{
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fDatosEvento["idRegistroEvento"]." AND situacionRecurso IN
					(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
			
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fila["tipoRecurso"];
			$tipoRecurso=$con->obtenerValor($consulta);
			$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fila["idRecurso"];
			$nombreRecurso=$con->obtenerValor($consulta);
			$oRecurso='{"tipoRecurso":"'.cv($tipoRecurso).'","nombreRecurso":"'.cv($nombreRecurso).'"}';
			if($arrRecursosAdicionalesRequeridos=="")
				$arrRecursosAdicionalesRequeridos=$oRecurso;
			else
				$arrRecursosAdicionalesRequeridos.=",".$oRecurso;
		}
	}
	$objRequerimiento='{"requiereResguardo":"'.$requiereResguardo.'","requiereMesaEvidencia":"'.$requiereMesaEvidencia.
						'","requiereTelePresencia":"'.$requiereTelePresencia.'","requiereTestigoProtegido":"'.$requiereTestigoProtegido.'"}';
	
	$cadObj='{"idCarpeta":"'.($fContenidos[1]==""?-1:$fContenidos[1]).'","carpetaJudicial":"'.$carpetaJudicial.'","tipoCarpeta":"'.$fDatosCarpetaJudicial[1].'","idTipoAudiencia":"'.$fDatosEvento["tipoAudiencia"].'","tipoAudiencia":"'.$tipoAudiencia.'","fechaEvento":"'.$fDatosEvento["fechaEvento"].'","horaInicio":"'.
			$fDatosEvento["horaInicioEvento"].'","horaFin":"'.$fDatosEvento["horaFinEvento"].
			'","horaInicioReal":"'.$fDatosEvento["horaInicioReal"].'","horaFinReal":"'.$fDatosEvento["horaTerminoReal"].'","urlMultimedia":"'.$fDatosEvento["urlMultimedia"].
			'","idEdificio":"'.$fDatosEvento["idEdificio"].'","edificio":"'.cv($nombreInmueble).'","idUnidadGestion":"'.$fDatosEvento["idCentroGestion"].
			'","unidadGestion":"'.cv($nombreUnidadGestion).'","idSala":"'.$fDatosEvento["idSala"].'","sala":"'.cv($nombreSala).'","jueces":['.$arrJueces.
			'],"situacion":"'.$fDatosEvento["situacion"].'","lblSituacion":"'.cv($lblSituacion).'","idEvento":"'.$idEvento.'",
			"iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'","requerimientosEspeciales":'.
			$objRequerimiento.',"idAuxiliarSala":"'.$idAuxiliar.'","lblNombreAuxiliarSala":"'.cv($nombre).'","idEtapaSolicitud":"'.
			$idEtapaSolicitud.'","arrRecursosAdicionalesRequeridos":['.$arrRecursosAdicionalesRequeridos.']}';
	
	echo "1|".$cadObj;
	
}

function registrarModificacionEdificioUnidadGestion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="SELECT idEdificio,idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEdificio=$con->obtenerPrimeraFila($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 3004_bitacoraCambiosEdificioUnidadGestion(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idEdificioOriginal,idUnidadGestionOriginal,idEdificioCambio,idUnidadGestionCambio,idMotivoCambio,comentariosAdicionales)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$fEdificio[0].",".$fEdificio[1].",".$obj->idEdificio.",".$obj->idUnidadGestion.",".$obj->motivoCambio.",'".cv($obj->comentariosAdicionales)."')";
	$x++;
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET idEdificio=".$obj->idEdificio.",idCentroGestion=".$obj->idUnidadGestion." where idRegistroEvento=".$obj->idEvento;
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	
	eB($query);
	
}

function obtenerJuecesDisponiblesUnidadGestionEvento()
{
	global $con;
	global $tipoMateria;
	$idEvento=bD($_POST["iE"]);
	$idUnidadGestion=bD($_POST["iUG"]);
	$mostrarTodosJueces=false;
	if(isset($_POST["mostrarTodosJueces"]))
	{
		$mostrarTodosJueces=$_POST["mostrarTodosJueces"]==1;
	}
	
	$datosEvento=obtenerDatosEventoAudiencia($idEvento);

	$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$listaJueces=$con->obtenerListaValores($consulta);
	if($listaJueces=="")
		$listaJueces=-1;
	
	$tipoJuez="";
	$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$datosEvento->carpetaAdministrativa."'";
	$tCarpeta=$con->obtenerValor($consulta);
	switch($tCarpeta)
	{
		case 6:
			$tipoJuez=3;
		break;
		case 5:
			$tipoJuez=2;
		break;
		default:
			$tipoJuez=1;
		break;
	}
	//$consulta="SELECT tipoJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	//$tipoJuez=$con->obtenerValor($consulta);
	if($tipoJuez=="")
		$tipoJuez=1;
	
	if($tipoMateria=="SCC")
		$tipoJuez=5;
	
	$arrJueces="";
	$consulta="SELECT usuarioJuez,CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica t,
			800_usuarios u,_26_tipoJuez tj WHERE idReferencia=".$idUnidadGestion." AND u.idUsuario=t.usuarioJuez  
			and tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=".$tipoJuez." and 
			u.idUsuario not in(".$listaJueces.") ORDER BY clave";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
			$comp="";
			$conDisponibilidad=existeDisponibilidadJuez($fila[0],$datosEvento->fechaEvento,$datosEvento->horaInicio,$datosEvento->horaFin,-1,"",true);
			if(!$conDisponibilidad)
			{
				if(!$mostrarTodosJueces)
					continue;
				else
				{
					$comp="Sin disponibilidad";
				}
			}
			
		
			if(esJuezTramite($fila[0],$datosEvento->fechaEvento))
			{
				if($comp=="")
					$comp="Juez de tr&aacute;mite";
				else
					$comp.=" / Juez de tr&aacute;mite";
			}
		
			if($comp!="")
				$comp=" (".$comp.")";
			$oJuez="['".$fila[0]."','".cv($fila[1].$comp)."']";
			if($arrJueces=="")
				$arrJueces=$oJuez;
			else
				$arrJueces.=",".$oJuez;
		
	}
	
	echo "1|[".$arrJueces."]";
}

function registrarModificacionJuez()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="SELECT idEdificio,idCentroGestion,situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEdificio=$con->obtenerPrimeraFila($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idRegistroJuez,idJuezOriginal,idJuezCambio,idMotivoCambio,comentariosAdicionales)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idRegistroJuez.",".$obj->idJuezOriginal.",".$obj->idJuezCambio.",".$obj->motivoCambio.
				",'".cv($obj->comentariosAdicionales)."')";
	$x++;
	
	$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$obj->idJuezCambio;
	$noJuez=$con->obtenerValor($consulta);
	
	$query[$x]="UPDATE 7001_eventoAudienciaJuez SET idJuez=".$obj->idJuezCambio.",noJuez='".$noJuez."' WHERE idRegistroEventoJuez=".$obj->idRegistroJuez;
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	if($con->ejecutarBloque($query))
	{
		if($fEdificio[2]!=0)
		{
			@enviarNotificacionMAJO($obj->idEvento);
		}
		echo "1|";
	}
	
	
}

function registrarModificacionFechaSala()
{
	global $con;
	global $tipoMateria;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idJuez,tipoJuez,idRegistroEventoJuez,serieRonda FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento;
	$fDatosJuez=$con->obtenerPrimeraFila($consulta);
	$idJuez=$fDatosJuez[0];
	if($idJuez=="")
	{
		if($tipoMateria!="P")
		{
			$consulta="SELECT idCentroGestion,tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
			$fEvento=$con->obtenerPrimeraFila($consulta);
			$idCentroGestion=$fEvento[0];

			$consulta="SELECT tipoJuez,titulo FROM _4_gridJuecesRequeridos WHERE idReferencia=".$fEvento[1];

			$fTipojuez=$con->obtenerPrimeraFila($consulta);
			if(!$fTipojuez)
			{
				$fTipojuez[0]=1;
				$fTipojuez[1]="Juez";
			}
			$consulta="SELECT usuarioJuez,clave FROM _26_tablaDinamica j,_26_tipoJuez tJ 
					WHERE tJ.idPadre=j.id__26_tablaDinamica and j.idReferencia=".$idCentroGestion." and
					tJ.idOpcion=".$fTipojuez[0];

			$fJuezJuzgado=$con->obtenerPrimeraFila($consulta);
			$idJuez=$fJuezJuzgado[0];
			if($idJuez=="")
				$idJuez=-1;
			
			$consulta="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,normalizado,ministerioLey)
					VALUES(".$obj->idEvento.",".$idJuez.",".$fTipojuez[0].",'".$fTipojuez[1]."','".$fJuezJuzgado[1]."',0,0)";
			$con->ejecutarConsulta($consulta);
				
			
		}
	}
	$tipoJuez=$fDatosJuez[1];
	$idRegistroEventoJuez=$fDatosJuez[2];
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idSala,idCentroGestion,idEdificio,idFormulario,idRegistroSolicitud,
			tipoAudiencia,situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
	$fEvento=$con->obtenerPrimeraFila($consulta);

	if(!existeDisponibilidadJuez($idJuez,$obj->fechaEvento,$obj->horaInicio,$obj->horaFin,$obj->idEvento)||($idJuez==-1))
	{

		if(($obj->asignacionJuez==0)&&($idJuez!=-1))
		{
			echo '<br>No existe disponibilidad del juez<br>';
			return;
		}
		else
		{

			$oDatosAudiencia=array();
			$oDatosAudiencia["idRegistroEvento"]=$obj->idEvento;
			$oDatosAudiencia["idEdificio"]=$fEvento[5];
			$oDatosAudiencia["listaEdificiosIgnorar"]=-1;
			$oDatosAudiencia["idUnidadGestion"]=$fEvento[4];
			$oDatosAudiencia["listaUnidadesGestionIgnorar"]=-1;
			$oDatosAudiencia["idSala"]=$fEvento[3];
			$oDatosAudiencia["listaSalasIgnorar"]=-1;
			$oDatosAudiencia["fecha"]=$obj->fechaEvento;
			$oDatosAudiencia["horaInicio"]=$obj->horaInicio;
			$oDatosAudiencia["horaFin"]=$obj->horaFin;			
			
			$oDatosParametros=array();
			$oDatosParametros["idFormulario"]=$fEvento[6];
			$oDatosParametros["idRegistro"]=$fEvento[7];
			$oDatosParametros["idReferencia"]=-1;
			$oDatosParametros["tipoAudiencia"]=$fEvento[8];
			$oDatosParametros["oDatosAudiencia"]=$oDatosAudiencia;
			$oDatosParametros["notificarMAJO"]=false;
			$oDatosParametros["nivelAsignacion"]=4; //1 Hasta UGJ; 2 Total
			$oDatosParametros["juecesRequeridos"]=array();
			
			
			$consulta="SELECT * FROM _27_tablaDinamica";
			$fConfiguracion=$con->obtenerPrimeraFilaAsoc($consulta);	
			$oDatosParametros["fechaSolicitud"]=$obj->fechaEvento;
			$oDatosParametros["fechaBaseSolicitud"]=date("Y-m-d H:i:s");		
			$oDatosParametros["idRegistroConfiguracionAgenda"]=$fConfiguracion["id__27_tablaDinamica"];
			$oDatosParametros["criterioBalanceoEdificio"]=$fConfiguracion["tipoBalanceoEdificio"];
			$oDatosParametros["criterioBalanceoUnidadGestion"]=$fConfiguracion["criterioBalanceoUnidadGestion"];
			$oDatosParametros["criterioBalanceoSala"]=$fConfiguracion["tipoBalanceoAsignacionSala"];
			$oDatosParametros["criterioBalanceoJuez"]=$fConfiguracion["tipoBalanceoAsignacionJuez"];	
			$oDatosParametros["horasMaximaAsignablesJuez"]=$fConfiguracion["horasMaximaAsignablesJuez"];	
			
			$consulta="SELECT promedioDuracion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEvento[8];
			$duracionAudiencia=$con->obtenerValor($consulta);
				
			$oDatosParametros["duracionAudiencia"]=$duracionAudiencia;			
			
			$oDatosParametros["fechaMaximaAudiencia"]=NULL;
			$oDatosParametros["fechaMinimaAudiencia"]="";
			$oDatosParametros["considerarDiaHabil"]=true;
			$oDatosParametros["funcionDiaHabil"]="";
			$oDatosParametros["esSolicitudUgente"]=true;	
				
			
			$oDatosParametros["metodoBalanceoEventosJuez"]=1;
			$oDatosParametros["validaIncidenciaJuez"]=true;
			$oDatosParametros["validaJuezTramite"]=true;
			$oDatosParametros["idJuezSugerido"]=-1;
			$oDatosParametros["tipoRonda"]=$fDatosJuez[3];
			
			if($oDatosParametros["tipoRonda"]=="")
				$oDatosParametros["tipoRonda"]="SI";
			$fechaInicialPeriodo=date("Y-06-16",strtotime($oDatosAudiencia["fecha"]));
			$fechaFinalPeriodo=date("Y-m-d");
			
			$oJuez=array();
			if($tipoMateria=="P")
			{
				$oJuez=asignarJuezAudienciaV3($oDatosAudiencia,$oDatosParametros,$tipoJuez,$idJuez,$obj->fechaEvento);
				
			}
			else
			{
				$oJuez["idJuez"]=asignarJuezAudienciaJuzgado($oDatosAudiencia,$oDatosParametros,$tipoJuez,-1,"","");
				$oJuez["noRonda"]=0;
				
			}
			
			$idJuezCambio=$oJuez["idJuez"];
			$query[$x]="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,idRegistroJuez,idJuezOriginal,idJuezCambio,idMotivoCambio,comentariosAdicionales)
						values(".$obj->idEvento.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idRegistroEventoJuez.",".$idJuez.",".$idJuezCambio.",2,'EL juez no contaba con disponibilidad de horario')";
			$x++;
			
			$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$idJuezCambio;
			$noJuez=$con->obtenerValor($consulta);
			$query[$x]="update 7001_eventoAudienciaJuez set idJuez=".$idJuezCambio.",noJuez='".$noJuez."',noRonda=".($oJuez["noRonda"]==""?"NULL":$oJuez["noRonda"])."
						where idRegistroEvento=".$obj->idEvento;
			$x++;
			
			
			
			
		}
	}

	if($obj->idSala!=-100)
	{
		if(!existeDisponibilidadSala($obj->idEvento,$obj->idSala,$obj->fechaEvento,$obj->horaInicio,$obj->horaFin))
		{
			echo "3|";
			//echo '<br>La sala seleccionada ya no se encuentra disponible<br>';
			return;
		}
	}

	$fechaInicial=$fEvento[1];
	$fechaFinal=$fEvento[2];
	$fInicialActual=$obj->horaInicio;
	$fFinalActual=$obj->horaFin;
	$recursosAdicionales=array();
	$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$obj->idEvento." AND  
				situacionRecurso IN(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
	$res=$con->obtenerFilas($consulta);
	while($filaRec=$con->fetchAssoc($res))
	{
		if(($filaRec["horaInicio"]==$fechaInicial)&&($filaRec["horaFin"]==$fechaFinal))
		{	
			$filaRec["horaInicio"]=$fInicialActual;
			$filaRec["horaFin"]=$fFinalActual;
			
        	
        }
		else
		{
			$diferenciaRecurso=obtenerDiferenciaMinutos($filaRec["horaInicio"],$filaRec["horaFin"]);
			$diferenciaHoraInicialRecurso=obtenerDiferenciaMinutos($fechaInicial,$filaRec["horaInicio"]);	
            $fInicialRecurso=date("Y-m-d H:i:s",strtotime("+".$diferenciaHoraInicialRecurso." minutes",strtotime($fInicialActual)));
			
			$fFinalRecurso=date("Y-m-d H:i:s",strtotime("+".$diferenciaRecurso." minutes",strtotime($fInicialRecurso)));			

            
            if(strtotime($fFinalRecurso)>strtotime($fFinalActual))
            {
            	$fFinalRecurso=$fFinalActual;
            }
            $filaRec["horaInicio"]=$fInicialRecurso;
			$filaRec["horaFin"]=$fFinalRecurso;
			
            
		}
		
		$o='{"tipoRecurso":"'.$filaRec["tipoRecurso"].'","idRecurso":"'.$filaRec["idRecurso"].'","horaInicio":"'.$filaRec["horaInicio"].
				'","horaTermino":"'.$filaRec["horaFin"].'","idRegistroRecurso":"'.$filaRec["idRegistro"].'","comentariosAdicionales":"'.
				cv($filaRec["comentariosAdicionales"]).'"}';
		array_push($recursosAdicionales,json_decode($o));
	}

	$lblRecursosSinDisponibilidad="";
	foreach($recursosAdicionales as $r)
	{
		if(!existeDisponibilidadRecurso($obj->idEvento,$obj->fechaEvento,$r->tipoRecurso,$r->idRecurso,$r->horaInicio,$r->horaTermino,$r->idRegistroRecurso))
		{
			$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$r->tipoRecurso;
			$tipoRecurso=$con->obtenerValor($consulta);
			$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$r->idRecurso;
			$nombreRecurso=$con->obtenerValor($consulta);
			
			
			if($lblRecursosSinDisponibilidad=="")
				$lblRecursosSinDisponibilidad='('.$tipoRecurso.') '.$nombreRecurso;
			else
				$lblRecursosSinDisponibilidad.='<br>('.$tipoRecurso.') '.$nombreRecurso;
			
		}
		
		 
	}
	
	if($lblRecursosSinDisponibilidad!="")
	{
		echo '0|<br>NO existe disponibilidad de los siguientes recursos: '.$lblRecursosSinDisponibilidad;
		return;
	}

	
	$query[$x]="INSERT INTO 3006_bitacoraCambiosSalaFecha(idEventoAudiencia,fechaOperacion,idResponsableOperacion,fechaOriginal,horaInicioOriginal,horaTerminoOriginal,
				idSalaOriginal,fechaCambio,horaInicioCambio,horaTerminoCambio,idSalaCambio,idMotivoCambio,comentariosAdicionales,asignacionJuez)
				VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$fEvento[0]."','".$fEvento[1]."','".$fEvento[2]."',".($fEvento["3"]==""?-1:$fEvento["3"]).
				",'".$obj->fechaEvento."','".$obj->horaInicio."','".$obj->horaFin."','".$obj->idSala."','".$obj->idMotivoCambio."','".
				cv($obj->comentariosAdicionales)."',".$obj->asignacionJuez.")";
	$x++;
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET  fechaEvento='".$obj->fechaEvento."',horaInicioEvento='".$obj->horaInicio.
			"',horaFinEvento='".$obj->horaFin."',idSala=".$obj->idSala.", idEdificio=".$obj->idEdificio.",horaInicioReal=NULL,horaTerminoReal=NULL  where idRegistroEvento=".$obj->idEvento;
	$x++;
	
	
	foreach($recursosAdicionales as $r)
	{
		$existeCambio=false;
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistro=".$r->idRegistroRecurso;
		$fRecurso=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRecurso["idRecurso"]!=$r->idRecurso)
		{
			$existeCambio=true;
		}
		
		if(($fRecurso["horaInicio"]!=$r->horaInicio)||($fRecurso["horaFin"]!=$r->horaTermino))
		{
			$existeCambio=true;
		}
		
		if($fRecurso["comentariosAdicionales"]!=$r->comentariosAdicionales)
		{
			$existeCambio=true;
		}
		
		if($existeCambio)
		{
			$query[$x]="update 7001_recursosAdicionalesAudiencia set idRecurso=".$r->idRecurso.",horaInicio='".$r->horaInicio."',horaFin='".$r->horaTermino.
					"',comentariosAdicionales='".cv($r->comentariosAdicionales)."' where idRegistro=".$r->idRegistroRecurso;
			$x++;
			$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,
						situacionAnterior,idRecursoAnterior,horaInicioAnterior,horaFinAnterior,comentariosAdicionalesAnterior)
						VALUES(".$r->idRegistroRecurso.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'',".$fRecurso["situacionRecurso"].
						",".$fRecurso["idRecurso"].",'".$fRecurso["horaInicio"]."','".$fRecurso["horaFin"]."','".cv($fRecurso["comentariosAdicionales"])."')";
			$x++;	
		}
	}
	
	$query[$x]="commit";
	$x++;


	if($con->ejecutarBloque($query))
	{
		@notificarEventoAudienciaSIAJOPCabina($obj->idEvento);
		if($fEvento[9]!=0)
		{
			
			if($fEvento[5]!=$obj->idEdificio)
			{
				@notificarCancelacionEventoMAJO($obj->idEvento);
			}
			
			@enviarNotificacionMAJO($obj->idEvento);
		}
		
		echo "1|";
	}
	

	
}

function obtenerEventosModificacionFechaSala()
{
	global $con;
	global $tipoMateria;
	$idSala=$_POST["idSala"];
	$idEvento=$_POST["iEvento"];
	$idUnidadGestion=-1;
	if(isset($_POST["iU"]))
		$idUnidadGestion=$_POST["iU"];
		
	$asignacionJuez=0;
	if(isset($_POST["asignacionJuez"]))
		$asignacionJuez=$_POST["asignacionJuez"];
		
	$idJueces=-1;
	if(isset($_POST["idJueces"]))
		$idJueces=$_POST["idJueces"];	
	
	$visualizarAgendaRecursos=0;
	if(isset($_POST["visualizarAgendaRecursos"]))
		$visualizarAgendaRecursos=$_POST["visualizarAgendaRecursos"];
	
	$lRecursos=-1;
	if(isset($_POST["lRecursos"]))
		$lRecursos=$_POST["lRecursos"];
		
	$fechaLimiteAtencion="";
	$arrEventos="";
	
	$listaEventosIgnorar=$idEvento;
	
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),
				idCentroGestion,fechaEvento,idRegistroEvento,idSala,fechaLimiteAtencion FROM 7000_eventosAudiencia a WHERE 
				idRegistroEvento=".$idEvento;
	
	$fila=$con->obtenerPrimeraFila($consulta);
	
	if($fila)
	{
		$fechaLimiteAtencion=$fila[7];
		//$e='{"id":"e_'.$fila[5].'","editable":true,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
		//$arrEventos=$e;
	}
	
	
	$start=$_POST["start"];
	$end=$_POST["end"];
	$arrFilasEventos=array();
	
	
	
	$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),idRegistroEvento FROM 7000_eventosAudiencia a
				WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
				a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
				and idRegistroEvento<>".$idEvento;

	if($idSala==152)
		$consulta.=" and 1=2";
	if($idSala==156)
	{
		$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia),idRegistroEvento FROM 7000_eventosAudiencia a
				WHERE idSala in(156,3021) AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
				a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
				and idRegistroEvento<>".$idEvento;
	}

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		array_push($arrFilasEventos,$fila);
	}
	
	$arrEventosSalaSedes=obtenerAudienciasProgramadasSede($idSala,$start,$end,$idEvento);
	foreach($arrEventosSalaSedes as $fila)
		array_push($arrFilasEventos,$fila);

	foreach($arrFilasEventos as $fila)
	{
		//$listaEventosIgnorar.=",".$fila[3];
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
		$cAdministrativa=$con->obtenerValor($consulta);
		
		
		$e='{"id":"e_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).' ['.$fila[3].']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
	
	
	if(($asignacionJuez==0)&&($idJueces==-1))
	{
		$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento." and idJuez<>0";
		$rJuez=$con->obtenerFilas($consulta);
		while($fJuez=$con->fetchRow($rJuez))
		{
	
			$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),'Evento de Juez',a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
						WHERE e.idJuez=".$fJuez[0]." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
						fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
						and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
			
			

			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{

				$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
				
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
			$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica,hInicio,hFin,tipoIntervalo FROM _20_tablaDinamica 
					WHERE usuarioJuez=".$fJuez[0]." and fechaInicial<='".$start."' and fechaFinal>='".$start.
					"' and idEstado=1 ";

			$iJuez=$con->obtenerFilas($consulta);
			while($fIncidencia=$con->fetchRow($iJuez))
			{
				
				if($fIncidencia[5]==1)
					$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
				else
					$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T".$fIncidencia[3]).'","end":"'.($start."T".$fIncidencia[4]).'","color":"#3D00CA"}';	
				
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
		}
	}
	
	
	if($idJueces!=-1)
	{
		$arrJueces=explode(",",$idJueces);
		
		foreach($arrJueces as $j)
		{
			if($j==0)
				continue;
			$nombreUsuario=obtenerNombreUsuario($j);
			$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),'Evento :".$nombreUsuario."',a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
						WHERE e.idJuez=".$j." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
						fechaEvento<='".$end."' and a.idRegistroEvento not in(".$listaEventosIgnorar.")
						and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
			
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{

				$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
				
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
			$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica,hInicio,hFin,tipoIntervalo  FROM _20_tablaDinamica 
					WHERE usuarioJuez=".$j." and fechaInicial<='".$start."' and fechaFinal>='".$start."' and idEstado=1";
			$iJuez=$con->obtenerFilas($consulta);
			while($fIncidencia=$con->fetchRow($iJuez))
			{
				
				if($fIncidencia[5]==1)
					$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"'.$nombreUsuario.' se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
				else
					$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"'.$nombreUsuario.' se reporta como No disponible","start":"'.($start."T".$fIncidencia[3]).'","end":"'.($start."T".$fIncidencia[4]).'","color":"#3D00CA"}';	

				
				
				
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
		}
	}
	
	
	
	
	if($idUnidadGestion==-1)
	{
		if($idEvento!=-1)
		{
			$consulta="SELECT idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
			$idUnidadGestion=$con->obtenerValor($consulta);
			if($idUnidadGestion=="")
				$idUnidadGestion=-1;
		}
		
	}
	
	
	$consulta="SELECT idPadre FROM _25_chkUnidadesAplica WHERE idOpcion=".$idUnidadGestion;	

	$listaIncidencias=$con->obtenerListaValores($consulta);
	if($listaIncidencias=="")
		$listaIncidencias=-1;
	
	$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
				AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=1
				union
				SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
				AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=0 and id__25_tablaDinamica in(".
				$listaIncidencias.")";

	$iSala=$con->obtenerFilas($consulta);
	while($fIncidencia=$con->fetchRow($iSala))
	{
		
		$horaInicial="00:00:00";
		$horaFinal="23:59:59";
		if($fIncidencia[1]=="")
			$fIncidencia[1]=$horaInicial;
		
		if($fIncidencia[3]=="")
			$fIncidencia[3]=$horaFinal;
			
		
		
		if($fIncidencia[5]==2)
		{
			
			if($fIncidencia[0]==$start)
			{
				$horaInicial=$fIncidencia[1];
			}
			
			
			if($fIncidencia[2]==$start)
			{
				$horaFinal=$fIncidencia[3];
			}
			
		}
		else
		{
			$horaInicial=$fIncidencia[1];
			$horaFinal=$fIncidencia[3];
		}
		$e='{"id":"iS_'.$fIncidencia[4].'","editable":false,"title":"La sala ha sido marcada como No disponible","start":"'.
			($start."T".str_pad($horaInicial,5,"0",STR_PAD_LEFT)).'","end":"'.($start."T".str_pad($horaFinal,5,"0",STR_PAD_LEFT)).'","color":"#B55381"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}

	if($fechaLimiteAtencion!="")
	{
		$fechaLimiteAtencion=strtotime($fechaLimiteAtencion);
		if(strtotime(date("Y-m-d",$fechaLimiteAtencion))<=strtotime($start))
		{
			$horaInicial="00:00:00";		
			if(strtotime(date("Y-m-d",$fechaLimiteAtencion))==strtotime($start))
			{
				$horaInicial=date("H:i:s",$fechaLimiteAtencion);
			}
			
			$horaFinal="23:59:59";			
			$e='{"id":"limiteAtencion","editable":false,"title":"Fuera del límite máximo de atención","start":"'.($start."T".str_pad($horaInicial,5,"0",STR_PAD_LEFT)).'","end":"'.($start."T".str_pad($horaFinal,5,"0",STR_PAD_LEFT)).'","color":"#000"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
	}
	
	if($visualizarAgendaRecursos==1)
	{
		$arrRecursos=array();
		$qAux=generarConsultaIntervalos($start." 00:00:00",$end." 23:59:59","if(r.horaInicioReal is null,r.horaInicio,r.horaInicioReal)",
			"if(r.horaFinReal is null,r.horaFin,r.horaFinReal)",false,true);
		
		
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$idEvento." AND situacionRecurso IN
				(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$f=array();
			$f["tipoRecurso"]=$fila["tipoRecurso"];
			$f["idRecurso"]=$fila["idRecurso"];
			$f["idRegistro"]=$fila["idRegistro"];
			array_push($arrRecursos,$f);
		}
		
		if($lRecursos!=-1)
		{
			$aRecursos=explode(",",$lRecursos);
			
			foreach($aRecursos as $r)
			{
				$oRecurso=explode("_",$r);
				$f=array();
				$f["tipoRecurso"]=$oRecurso[0];
				$f["idRecurso"]=$oRecurso[1];
				$f["idRegistro"]=-1;
				array_push($arrRecursos,$f);
			}
		}
		
		foreach($arrRecursos as $fila)
		{
			$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fila["tipoRecurso"];
			$tipoRecurso=$con->obtenerValor($consulta);
			$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fila["idRecurso"];
			$nombreRecurso=$con->obtenerValor($consulta);
			
			$consulta="SELECT IF(r.horaInicioReal IS NULL,r.horaInicio,  r.horaInicioReal) AS horaInicio, IF(r.horaFinReal IS NULL,r.horaFin,  r.horaFinReal) AS horaFin,
						r.idRegistroEvento,(SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND 
						idRegistroContenidoReferencia=r.idRegistroEvento) as carpetaAdministrativa ,r.idRegistro 
						FROM 7001_recursosAdicionalesAudiencia r WHERE r.tipoRecurso=".$fila["tipoRecurso"]." AND r.idRecurso=".$fila["idRecurso"]."
						 AND  r.idRegistro<>".$fila["idRegistro"]." AND r.situacionRecurso IN 	(SELECT idSituacion FROM 7011_situacionEventosAudiencia 
						 WHERE considerarDiponibilidad=1) and ".$qAux;
			//echo $consulta;
			$resRecurso=$con->obtenerFilas($consulta);
			while($fRecurso=$con->fetchAssoc($resRecurso))
			{
				$hIni=strtotime($fRecurso["horaInicio"]);
				$hFin=strtotime($fRecurso["horaFin"]);
				$hInicio=date("Y-m-d",$hIni)."T".date("H:i:s",$hIni);	
				$hFin=date("Y-m-d",$hFin)."T".date("H:i:s",$hFin);	
				$e='{"id":"rec_'.$fRecurso["idRegistro"].'","editable":false,"title":"('.$tipoRecurso.') '.cv($nombreRecurso).' [ '.$fRecurso["carpetaAdministrativa"].' - '.$fRecurso["idRegistroEvento"].']","start":"'.$hInicio.'","end":"'.$hFin.'","color":"#E16A02"}';	
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
		}
		
	}
	echo '['.$arrEventos.']';
	
}

function obtenerSujetosProcesalesCarpetaAdministrativa()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	$sujetosProcesales="";
	if(isset($_POST["sP"]))
		$sujetosProcesales=bD($_POST["sP"]);
	
	$soloVista=0;
	if(isset($_POST["sV"]))
		$soloVista=bD($_POST["sV"]);	
	
	
	$consulta="SELECT idFormulario,idRegistro,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$idActividad=$fCarpeta[2];
	if(($fCarpeta[2]=="")||($fCarpeta[2]==-1))
	{
		$consulta="SELECT idActividad FROM _".$fCarpeta[0]."_tablaDinamica WHERE id__".$fCarpeta[0]."_tablaDinamica=".$fCarpeta[1];
		$idActividad=$con->obtenerValor($consulta);
	}
	
	$arrFiguras="";
	$consulta="SELECT id__5_tablaDinamica,etiquetaPlural FROM _5_tablaDinamica ".(($sujetosProcesales!="")?" where id__5_tablaDinamica in(".$sujetosProcesales.")":"")." ORDER BY codigo";
	
	$rFiguras=$con->obtenerFilas($consulta);
	while($fFiguras=$con->fetchRow($rFiguras))
	{
		/*$consulta="SELECT idPadre FROM _47_chParticipacionJuridica p,_47_tablaDinamica s WHERE s.idActividad=".$idActividad." 
					AND  p.idPadre=s.id__47_tablaDinamica and p.idOpcion=".$fFiguras[0];
		$lPersonas=$con->obtenerListaValores($consulta);
		if($lPersonas=="")
			$lPersonas=-1;*/
			
		$arrPersonas="";
		$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica p,
					7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica and r.idActividad=".$idActividad."	
					and r.idFiguraJuridica=".$fFiguras[0]." order by nombre,apellidoPaterno,apellidoMaterno";
		
		$rPersona=$con->obtenerFilas($consulta);
		while($fPersona=$con->fetchRow($rPersona))
		{
			
			$comp='"leaf":true';
			
			switch($fFiguras[0])
			{
				case 3:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkVictimas v WHERE 
								v.idPadre=".$fPersona[0]."  AND v.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=$con->fetchRow($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pA_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					
					$comp='"expanded":true';
					
					if($arrHijos!="")
						$comp.=',"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA0","text":"<b>Asesor de:</b>","leaf":false,children:['.$arrHijos.']}]';		
					else
						$comp.=',"leaf":true';
				break;
				case 5:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputados i WHERE 
								i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=$con->fetchRow($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pD_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					
					$comp='"expanded":true';
					if($arrHijos!="")
						$comp.=',"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA1","text":"<b>Defensor de:</b>","leaf":false,children:['.$arrHijos.']}]';		
					else
						$comp.=',"leaf":true';
				break;
				case 6:
					$arrHijos="";
					$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d,_47_chkImputadosVictimas i WHERE 
								i.idPadre=".$fPersona[0]."  AND i.idOpcion=d.id__47_tablaDinamica  order by nombre,apellidoPaterno,apellidoMaterno";
								
					$rDependientes=$con->obtenerFilas($consulta);			
					while($fDependientes=$con->fetchRow($rDependientes))
					{
						$icono="user.png";
						if($fDependientes[1]!=1)
						{
							$icono="chart_organisation.png";
						}
						
						$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pR_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
						if($arrHijos=="")
							$arrHijos=$oP;
						else
							$arrHijos.=",".$oP;
					}
								
					

					$comp='"expanded":true';
					if($arrHijos!="")
						$comp.='"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pA2","text":"<b>Representante de:</b>","leaf":false,children:['.$arrHijos.']}]';		
					else
						$comp.=',"leaf":true';
				
				break;
			}
			
			$icono="user.png";
			if($fPersona[1]!=1)
			{
				$icono="chart_organisation.png";
			}
			$id='p_'.$fPersona[0]."_".$fFiguras[0];
			
			$consulta="SELECT COUNT(*) FROM _228_tablaDinamica WHERE idUsuario=".$fPersona[0]." AND idEvento=".$idEvento." AND presentoAudiencia=1";
			$nReg=$con->obtenerValor($consulta);
			
			
			$iconAsistencia="<img width='13' height='13' src='../images/cross.png' title='NO se presento a audiencia' alt='NO se presento a audiencia' >";
			if($nReg!=0)
			{
				$iconAsistencia="<img width='13' height='13' src='../images/icon_big_tick.gif' title='Asisti&oacute; a audiencia' alt='Asisti&oacute; a audiencia' >";
			}
			
			
			if($soloVista==1)
				$iconAsistencia="";
			
			$oP='{'.($soloVista==0?'"checked":false,':'').'"tipo":"1","icon":"../images/'.$icono.'","id":"'.$id.'","text":"'.$iconAsistencia." ".cv($fPersona[4]." ".$fPersona[2]." ".$fPersona[3]).'",'.$comp.'}';
			if($arrPersonas=="")
				$arrPersonas=$oP;
			else
				$arrPersonas.=",".$oP;
		}
		
		if($fFiguras[0]==5)
		{
			$consulta="SELECT DISTINCT notificador,d.idReferencia FROM _82_tablaDinamica d,_80_tablaDinamica s WHERE d.idReferencia=s.id__80_tablaDinamica AND s.idEstado=3 AND s.carpetaAdministrativa='".$carpetaAdministrativa."'";
			$res=$con->obtenerFilas($consulta);
			while($fDefensor=$con->fetchRow($res))
			{
				
				$consulta="SELECT DISTINCT imputado FROM _82_tablaDinamica WHERE idReferencia=".$fDefensor[1]." AND notificador=".$fDefensor[0];
				$listaImputados=$con->obtenerListaValores($consulta);
				if($listaImputados=="")
					$listaImputados=-1;
				$arrHijos="";
				$consulta="SELECT id__47_tablaDinamica,tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica d  WHERE 
							id__47_tablaDinamica in(".$listaImputados.")  order by nombre,apellidoPaterno,apellidoMaterno";
							
				$rDependientes=$con->obtenerFilas($consulta);			
				while($fDependientes=$con->fetchRow($rDependientes))
				{
					$icono="user.png";
					if($fDependientes[1]!=1)
					{
						$icono="chart_organisation.png";
					}
					
					$oP='{"tipo":"1","icon":"../images/'.$icono.'","id":"pD_'.$fDependientes[0].'","text":"'.cv($fDependientes[4]." ".$fDependientes[3]." ".$fDependientes[2]).'",leaf:true}';
					if($arrHijos=="")
						$arrHijos=$oP;
					else
						$arrHijos.=",".$oP;
				}
							
				
				$comp='"expanded":true,"leaf":false,"children":[{"icon":"../images/group.png","expanded":true,"tipo":"0","id":"pDO'.$fDefensor[0].'","text":"<b>Defensor de:</b>","leaf":false,children:['.$arrHijos.']}]';
				
				
				$icono="user.png";
			
				$id='pDO_'.$fDefensor[0]."_".$fFiguras[0];
				
				$consulta="SELECT nombre,apPaterno,apMaterno FROM _154_tablaDinamica WHERE id__154_tablaDinamica=".$fDefensor[0];
				$fPersona=$con->obtenerPrimeraFila($consulta);
				
				
				
				
				
				$iconAsistencia="<img width='13' height='13' src='../images/cross.png' title='NO se presento a audiencia' alt='NO se presento a audiencia' >";
				
				if($soloVista==1)
					$iconAsistencia="";
				
				$oP='{'.($soloVista==0?'"checked":false,':'').'"tipo":"1","icon":"../images/'.$icono.'","id":"'.$id.'","text":"'.$iconAsistencia." (Público) ".cv($fPersona[0]." ".$fPersona[1]." ".$fPersona[2]).'",'.$comp.'}';
				if($arrPersonas=="")
					$arrPersonas=$oP;
				else
					$arrPersonas.=",".$oP;
				
			}
			
			
			
			
					
		}
		
		
		
		
		if($arrPersonas!="")
		{
			$o='{"tipo":"0","expanded":true,"icon":"../images/bullet_green.png","id":"f_'.$fFiguras[0].'","text":"<span style=\'color:#900; font-weight:bold\'>'.cv($fFiguras[1]).'</span>","leaf":false,children:['.$arrPersonas.']}';
			if($arrFiguras=="")
				$arrFiguras=$o;
			else
				$arrFiguras.=",".$o;
		}
	}
	
	
	//$consulta="SELECT tipoPersona,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE idActividad=";
	
	echo '['.$arrFiguras.']';
	
	
	
}

function obtenerProcesosCarpetaAdministrativa()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	
	$arrRegistros="";
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		$arrProcesos="";
		$consulta="SELECT idFormulario,idRegistro,fechaRegistro FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0]." and tipoContenido=2 order by fechaRegistro";
		$rProceso=$con->obtenerFilas($consulta);
		while($fProceso=$con->fetchRow($rProceso))
		{
			$consulta="SELECT p.nombre,f.idProceso FROM 900_formularios f,4001_procesos p WHERE f.idFormulario=".$fProceso[0]." and p.idProceso=f.idProceso";
			$fFormulario=$con->obtenerPrimeraFila($consulta);

			$consulta="SELECT fechaCreacion,idEstado FROM _".$fProceso[0]."_tablaDinamica WHERE id__".$fProceso[0]."_tablaDinamica=".$fProceso[1];
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fFormulario[1]." AND numEtapa=".$fRegistro[1];
			$fEtapa=$con->obtenerPrimeraFila($consulta);
			
			$situacion=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
			
			
			$o='{"tipo":"1","icon":"../images/cog.png","id":"p_'.$fProceso[0].'_'.$fProceso[1].'","idFormulario":"'.$fProceso[0].'","idRegistro":"'.$fProceso[1].'","text":"'.cv($fFormulario[0]).
				'","fechaCreacion":"'.date("d/m/Y H:i",strtotime($fRegistro[0])).'","situacion":"'.cv($situacion).'",leaf:true}';
			
			if($arrProcesos=="")
				$arrProcesos=$o;
			else
				$arrProcesos.=",".$o;
			
		}
		
		
		if($arrProcesos!="")
		{
			$o='{"tipo":"0","fechaCreacion":"","situacion":"","expanded":true,"icon":"../images/bullet_green.png","id":"e_'.$fila[0].'","text":"<span style=\'color:#900\'><b>'.cv($fila[1]).'</b></span>","leaf":false,"children":['.$arrProcesos.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	
	echo '['.$arrRegistros.']';
	
}

function obtenerDocumentosCarpetaAdministrativa()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	$idCarpetaAdministrativa=-1;
	if(isset($_POST["idCarpetaAdministrativa"]))
		$idCarpetaAdministrativa=$_POST["idCarpetaAdministrativa"];
	
	$compCarpeta=" and idCarpetaAdministrativa in(-1)";
	if($idCarpetaAdministrativa!=-1)
	{
		$compCarpeta=" and idCarpetaAdministrativa in(".$idCarpetaAdministrativa.")";
	}

	$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);

	$cadCondWhere=str_replace("fechaCreacion"," cast(fechaCreacion as date)",$cadCondWhere);	
	$tDocumentos=-1;
	if(isset($_POST["tDocumentos"]))
		$tDocumentos=$_POST["tDocumentos"];
	$numReg=0;
	$arrRegistros="";
		
	$consulta="SELECT count(*) FROM 
					7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
					"' and tipoContenido in(1,4) ".$compCarpeta." order by fechaRegistro";	

	$numDocumentos=$con->obtenerValor($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales
				union 
				select 0,'Sin etapa',0 as orden 
				 ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		$consulta="SELECT idFormulario,idRegistro,fechaRegistro,idRegistroContenidoReferencia,ordenDocumento,noPaginas,paginaInicio,paginaFin,idContenido,eliminadoRepositorio FROM 
					7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and etapaProcesal=".$fila[0].
					" and tipoContenido in(1,4) ".$compCarpeta." order by fechaRegistro";

		$rDocumentos=$con->obtenerFilas($consulta);
		while($fDocumentos=$con->fetchRow($rDocumentos))
		{

			if($fDocumentos[3]=="")
				continue;
			$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fDocumentos[3].($tDocumentos!=-1?" and categoriaDocumentos in(".$tDocumentos.
					") ":"")." and eliminado=0 and ".$cadCondWhere;
			$consulta.=" and categoriaDocumentos not in(53)";

			$fDatosDocumento=$con->obtenerPrimeraFila($consulta);

			if($fDatosDocumento)
			{
				$arrNombreOriginal=explode(".",$fDatosDocumento[6]);
				$nomArchivoOriginal="";
				for($x=0;$x<sizeof($arrNombreOriginal);$x++)
				{
					if($x==(sizeof($arrNombreOriginal)-1))
					{
						$nomArchivoOriginal.=".".$arrNombreOriginal[$x];
					}
					else
						if($nomArchivoOriginal=="")
							$nomArchivoOriginal=$arrNombreOriginal[$x];
						else
							$nomArchivoOriginal.="_".$arrNombreOriginal[$x];
				}
				
				$etapaProcesal=$fila[0];
				if(($fDatosDocumento[16]!="")&&($fDatosDocumento[2]==""))
				{
					$nomArchivoOriginal="En espera de digitalizaci&oacute;n";
					$etapaProcesal=-1000;
				}
				
				$subidorPor="";
				if($fDatosDocumento[3]==2390)
					$subidorPor="PGJ";
				else
					$subidorPor="Unidad de Gesti&oacute;n";
				$ocr="0";
				if(isset($fDatosDocumento[21]))
					$ocr=$fDatosDocumento[21];
					
				$o='{"fechaRegistro":"'.date("Y-m-d",strtotime($fDocumentos[2])).'","idDocumento":"'.$fDatosDocumento[0].'","etapaProcesal":"'.$etapaProcesal.'","nomArchivoOriginal":"'.cv($nomArchivoOriginal).'","tamano":"'.$fDatosDocumento[8].
					'","fechaCreacion":"'.$fDatosDocumento[2].'","descripcion":"'.cv($fDatosDocumento[11]).'","categoriaDocumentos":"'.$fDatosDocumento[12].
					'","idFormulario":"'.$fDocumentos[0].'","idRegistro":"'.$fDocumentos[1].'","subidorPor":"'.$subidorPor.'","ocr":"'.$ocr.'","ordenDocumento":"'.$fDocumentos[4].'","noPaginas":"'.$fDocumentos[5].
					'","paginaInicio":"'.$fDocumentos[6].'","paginaFin":"'.$fDocumentos[7].'","idRegistroContenido":"'.$fDocumentos[8].'","eliminadoRepositorio":"'.$fDocumentos[9].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			
				$numReg++;	
			}
		}		
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function obtenerAccionesTableroControlDisponibles()
{
	global $con;
	
	$idEvento=bD($_POST["iE"]);
	$carpetaAdministrativa=bD($_POST["cA"]);
	$idPerfil=bD($_POST["iP"]);
	$numReg=0;
	$consulta="SELECT id__99_gridAccionesDisponibles,lblEtiquetaAccion,tipoModulo,proceso,moduloJs,archivoJS 
				FROM _99_gridAccionesDisponibles WHERE idReferencia=".$idPerfil." ORDER BY lblEtiquetaAccion";	


	
	$arrAcciones="";
	
	$res=$con->obtenerFilas($consulta);				
	while($fila=$con->fetchRow($res))
	{
		$ejecutarFuncion="";
		$objConf="";
		
		
		if($fila[2]==1) //Modulo predefinido
		{
			$ejecutarFuncion=$fila[4];
			$objConf='{"idEvento":"'.$idEvento.'","carpetaAdministrativa":"'.$carpetaAdministrativa.'"}';
		}
		else
		{
			$rol='54_0';
			$idPerfil=obtenerIdPerfilEscenario($fila[3],1,$rol,true);
			$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$fila[3].
							" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
				
			$idActorAgregar=$con->obtenerValor($consulta);
			
			$idFormulario=obtenerFormularioBase($fila[3]);
			$ejecutarFuncion="abrirVentanaFancy";
			$objConf='{"url":"../modeloPerfiles/vistaDTDv3.php","params":[[\'idEvento\',\''.$idEvento.
						'\'],[\'idReferencia\',\''.$idEvento.'\'],[\'carpetaAdministrativa\',\''.$carpetaAdministrativa.
						'\'],[\'idFormulario\',\''.$idFormulario.'\'],[\'idRegistro\',\'-1\'],[\'dComp\',\''.bE("agregar").
						'\'],[\'actor\',\''.$idActorAgregar.'\']],"ancho":"100%","alto":"100%","modal":"true"}';
		}
		
		$datosConfiguracion='{"ejecutarFuncion":"'.$ejecutarFuncion.'","objConf":'.$objConf.'}';
		$o='{"idAccion":"'.$fila[0].'","etiqueta":"'.cv($fila[1]).'","tipoModulo":"'.$fila[2].'","datosConfiguracion":"'.bE($datosConfiguracion).'"}';
		if($arrAcciones=="")
			$arrAcciones=$o;
		else
			$arrAcciones.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrAcciones.']}';
}

function obtenerHistorialAudiencias()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
	$idEvento=-1;
	if(isset($_POST["iE"]))
		$idEvento=bD($_POST["iE"]);
	
	
	$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$eventoReferencia=$con->obtenerValor($consulta);
	
	
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa 
					WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoContenido=3 
					and etapaProcesal=".$fila[0];
		$listaEventos=$con->obtenerListaValores($consulta);
		if($listaEventos=="")
			$listaEventos=-1;
			
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,horaInicioReal,horaTerminoReal,tipoAudiencia 
					FROM 7000_eventosAudiencia WHERE idRegistroEvento in (".$listaEventos.") and idRegistroEvento<>".$idEvento;
					
		if($eventoReferencia!="")			
			$consulta.=" AND horaInicioEvento<='".$eventoReferencia."'";
		$consulta.=" ORDER BY horaInicioEvento"	;
		
		$resEventos=$con->obtenerFilas($consulta);
		while($fEvento=$con->fetchRow($resEventos))
		{
			$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEvento[7];
			$tipoAudiencia=$con->obtenerValor($consulta);
			
			
			$lblHorario="";	
			$fechaHoraInicio=strtotime($fEvento[2]);
			$fechaHoraFin=strtotime($fEvento[3]);
			$comp='';
			if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
			{
				$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
			}
			
			$lblHorario='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
			
			
			$lblHorarioReal="";
			if($fEvento[5]!="")
			{
				$fechaHoraInicio=strtotime($fEvento[5]);
				$fechaHoraFin=strtotime($fEvento[6]);
				$comp='';
				if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
				{
					$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
				}
				
				$lblHorarioReal='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
				
			}
			
			
			$o='{"idEvento":"'.$fEvento[0].'","fechaEvento":"'.$fEvento[1].'","situacion":"'.$fEvento[4].'","tipoAudiencia":"'.cv($tipoAudiencia).
				'","horarioProgramado":"'.$lblHorario.'","horarioReal":"'.$lblHorarioReal.'","etapaProcesal":"'.$fila[0].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;	
		}
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerHistorialAccionesAudiencia()
{
	global $con;
	$idEvento=bD($_POST["iE"]);
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT idRegistro,iFormulario,iRegistro FROM 7012_historialAccionesEvento WHERE idRegistroEvento=".$idEvento." ORDER BY fechaAccion ASC";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT p.nombre,f.idProceso FROM 900_formularios f,4001_procesos p WHERE f.idFormulario=".$fila[1]." and p.idProceso=f.idProceso";
		$fFormulario=$con->obtenerPrimeraFila($consulta);

		$consulta="SELECT fechaCreacion,idEstado FROM _".$fila[1]."_tablaDinamica WHERE id__".$fila[1]."_tablaDinamica=".$fila[2];
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fFormulario[1]." AND numEtapa=".$fRegistro[1];
		$fEtapa=$con->obtenerPrimeraFila($consulta);
		
		$situacion=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
		
		$actor=obtenerActorProcesoIdRol($fFormulario[1],'54_0',$fRegistro[1]);
		if($actor=="")
			$actor=0;
		
		$o='{"idRegistro":"'.$fila[0].'","iFormulario":"'.$fila[1].'","iRegistro":"'.$fila[2].'","etiqueta":"'.cv($fFormulario[0]).
			'","situacion":"'.cv($situacion).'","actor":"'.$actor.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarDocumentoAdjuntoReferenciaProceso() //Modificado
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);

	if($idDocumento!=-1)
	{
		if(registrarDocumentoReferenciaProceso($obj->idFormulario,$obj->idRegistro,$idDocumento,$obj->asociarDocumentoExpediente==1))
		{

			echo "1|";
		}
	}
	echo "";
	
	
}

function registrarDocumentoAdjuntoCarpetaAdministrativa()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$obj->tipoDocumento,$obj->descripcion);
	if($idDocumento!=-1)
	{
		if(registrarDocumentoCarpetaAdministrativa($obj->carpetaAdministrativa,$idDocumento))
			echo "1|";
	}
	echo "";
	
	
}


function obtenerEventosAudienciaAuxiliarSala()
{
	global $con;
	$fechaEvento=$_POST["fE"];
	$carpeta=$_POST["cA"];
	$situacion=$_POST["s"];
	
	$arrRegistros="";
	$numReg=0;
	
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$centroGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion from 
	7000_eventosAudiencia e WHERE fechaEvento='".$fechaEvento."' AND situacion=".$situacion." and idCentroGestion=".$centroGestion;
	
	if($carpeta!="")
	{
		$consultaAux="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpeta."' AND tipoContenido=3";	
		$listaEventos=$con->obtenerListaValores($consultaAux);
		if($listaEventos=="")
			$listaEventos=-1;
		
		$consulta.=" and 	idRegistroEvento in (".$listaEventos.")";
	}
	

	
	$res=$con->obtenerFilas($consulta);
	while($filaRegistros=$con->fetchRow($res))
	{
		
		$fechaEvento=convertirFechaLetra($filaRegistros[1],true);
		
		$lblHorario="";
		
		$fechaHoraInicio=strtotime($filaRegistros[2]);
		$fechaHoraFin=strtotime($filaRegistros[3]);
		$comp='';
		if(date("Y-m-d",$fechaHoraInicio)!=date("Y-m-d",$fechaHoraFin))
		{
			$comp=' del '.convertirFechaLetra(date("Y-m-d",$fechaHoraInicio),true);
		}
		
		$lblHorario='De las '.date("h:i",$fechaHoraInicio).' hrs.'.$comp.' a las '.date("h:i",$fechaHoraFin).' hrs. del '.convertirFechaLetra(date("Y-m-d",$fechaHoraFin),true);
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE idRegistroContenidoReferencia=".$filaRegistros[0]." AND tipoContenido=3";
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		
		$o='{"idEventoAudiencia":"'.$filaRegistros[0].'","fechaEvento":"'.$filaRegistros[1].'","carpetaAdministrativa":"'.$carpetaAdministrativa.'","horarioEvento":"'.cv(utf8_encode($lblHorario)).'","situacion":"'.$filaRegistros[4].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
			
		$numReg++	;
			
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}
function registrarDocumentoEventoAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idRegistro=-1;
	if($obj->registroUnico==1)
	{
		$consulta="SELECT id__101_tablaDinamica FROM _101_tablaDinamica WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);	
		if($idRegistro=="")
			$idRegistro=-1;
	}
	
	if($idRegistro==-1)
	{
		$consulta="INSERT INTO _101_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,idEvento,carpetaAdministrativa,idFormatoImpresion) 
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"]."',".$obj->idEvento.",'".$obj->carpetaAdministrativa."',".$obj->idDocumento.")";
		if($con->ejecutarConsulta($consulta))
		{
			$idRegistro=$con->obtenerUltimoID();
			registrarProcesoEventoAudiencia(101,$idRegistro,$obj->idEvento);
			cambiarEtapaFormulario(101,$idRegistro,1,"",-1,"NULL","NULL",304);
			asignarFolioRegistro(101,$idRegistro);
			
			
		}
	}
	
	echo "1|".$idRegistro;
	
}

function obtenerFigurasJuridicasNotificacion()
{
	
	global $con;
	$numReg=0;
	$idRegistro=$_POST["idRegistro"];
	$iFormularioSolicitud=$_POST["iFormularioSolicitud"];
	$idRegistroSolicitud=$_POST["idRegistroSolicitud"];
	$arrRegistros="";
	$consulta="SELECT id__72_tablaDinamica,fechaCreacion,responsable,carpetaAdministrativa,idPersonaNotificar,idFiguraJuridica,
				tipoFigura,tipoDocumento,idEstado,codigo
				FROM _72_tablaDinamica WHERE iFormulario=".$iFormularioSolicitud." AND iRegistro=".$idRegistroSolicitud;
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT nombreElemento FROM 1018_catalogoVarios WHERE claveElemento=".$fila[6]." AND tipoElemento=15";
		$tipoFigura=$con->obtenerValor($consulta);
		
		$tipoDocumento="";
		if($fila[7]!=0)
		{
			$consulta="SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fila[7];
			$tipoDocumento=$con->obtenerValor($consulta);
		}
		else
		{
			$tipoDocumento="Documento adjunto de la solicitud";
		}
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=96 AND numEtapa=".$fila[8];
		$fEstado=$con->obtenerPrimeraFila($consulta);
		$situacion=removerCerosDerecha($fEstado[0]).".- ".$fEstado[1];
		
		$personaNotificar="";
		if($fila[6]==1)
		{
			$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila[4];
			$personaNotificar=$con->obtenerValor($consulta);
		}
		else
		{
			$consulta="SELECT nombreInstancia FROM _149_tablaDinamica  WHERE id__149_tablaDinamica=".$fila[4];
			$personaNotificar=$con->obtenerValor($consulta);
		}
		
		$actor=obtenerActorProcesoIdRol(96,'38_0',$fila[8]);
		if($actor=="")
			$actor=0;
		
		$o='{"folioRegistro":"'.$fila[9].'","idRegistro":"'.$fila[0].'","fechaAsignacion":"'.$fila[1].'","notificadorAsignado":"'.obtenerNombreUsuario($fila[2]).
			'","personaNotificar":"'.cv($personaNotificar).'","idFiguraJuridica":"'.$fila[5].'","tipoFigura":"'.cv($tipoFigura).
			'","tipoDocumento":"'.cv($tipoDocumento).'","situacionRegistro":"'.cv($situacion).'","actor":"'.$actor.'"}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function asignarNotificadorSolicitud()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT carpetaAdministrativa FROM _".$obj->iFormulario."_tablaDinamica WHERE id__".$obj->iFormulario."_tablaDinamica=".$obj->iRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$arrValores["responsable"]=$obj->idNotificador;
	$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
	$arrValores["idPersonaNotificar"]=$obj->destinatario;
	$arrValores["iFormulario"]=$obj->iFormulario;
	$arrValores["iRegistro"]=$obj->iRegistro;
	$arrValores["idFiguraJuridica"]=$obj->figuraJuridica;
	$arrValores["idEvento"]=$obj->idEvento==""?-1:$obj->idEvento;
	$arrValores["tipoFigura"]=$obj->tipoFigura;
	$arrValores["tipoDocumento"]=$obj->documento;


	$actor="385";
	$arrDocumentosReferencia=array();
	$idEtapa=1;
	if($obj->documento==0)
	{
		$idEtapa=1.1;
		$actor=739;
		/*
		$consulta="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$obj->iFormulario.
				" AND idRegistro=".$obj->iRegistro." ";

		$res=$con->obtenerFilas($consulta);		
		while($fila=$con->fetchRow($res))
		{
			array_push($arrDocumentosReferencia,$fila[0]);
		}*/
	
		//$actor=522;
		//$idEtapa=7;
	}
	

	$idRegistro=crearInstanciaRegistroFormulario(72,-1,$idEtapa,$arrValores,$arrDocumentosReferencia,-1,314);
	if($idRegistro!=-1)
	{
		$arFormasNotificacion=explode(",",$obj->arrMediosNotificacion);		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		foreach($arFormasNotificacion as $medioNotificacion)
		{
			$query[$x]="INSERT INTO _72_chdMedioNotificacion(idPadre,idOpcion) values(".$idRegistro.",".$medioNotificacion.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			echo "1|".$idRegistro."|".$actor;
		}
	}
}

function obtenerAuxiliaresSalaDisponibles()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fEvento=$con->obtenerPrimeraFilaAsoc($consulta);			
	$arrRegistros="";
	$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fEvento["idCentroGestion"];
	$centroGestion=$con->obtenerValor($consulta);
	$consulta="SELECT u.idUsuario,u.Nombre FROM 807_usuariosVSRoles r,800_usuarios u,801_adscripcion a WHERE r.idRol=16 AND u.idUsuario=r.idUsuario
				AND a.idUsuario=u.idUsuario AND a.codigoUnidad='".$centroGestion."'";
	$resAuxiliar=$con->obtenerFilas($consulta);				
	while($filaAuxiliar=$con->fetchRow($resAuxiliar))
	{
		if(existeDisponibilidadAuxiliar($filaAuxiliar[0],$fEvento["horaInicioEvento"],$fEvento["horaFinEvento"],$idEvento))
		{
			$o="['".$filaAuxiliar[0]."','".cv($filaAuxiliar[1])."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	
	echo "1|[".$arrRegistros."]";

}

function asignarAuxiliarSalaEvento()
{
	global $con;
	$iE=$_POST["iE"];
	$iA=$_POST["iA"];
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$consulta="SELECT idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$iE;
	$fEvento=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT idRegistroAuxiliar FROM 3007_auxiliarSalaEvento WHERE idFormulario=".$fEvento[0]." AND idReferencia=".$fEvento[1];
	$idRegistroAuxiliar=$con->obtenerValor($consulta);
	if($idRegistroAuxiliar=="")
	{
		$query[$x]="INSERT INTO 3007_auxiliarSalaEvento(idFormulario,idReferencia,idAuxiliarSala)
					VALUES(".$fEvento[0].",".$fEvento[1].",".$iA.")";
		$x++;
	}
	else
	{
		$query[$x]="UPDATE 3007_auxiliarSalaEvento SET idAuxiliarSala=".$iA." WHERE idRegistroAuxiliar=".$idRegistroAuxiliar;
		$x++; 
	}
	
	$query[$x]="UPDATE 7000_eventosAudiencia SET idAuxiliarSala=".$iA." WHERE idRegistroEvento=".$iE;
	$x++;
	$query[$x]="commit";
	$x++;
	
	eB($query);
}


function obtenerEntidadesCitacion()
{
	global $con;
	$carpetaAdministrativa=$_POST["cA"];
	$tipoFigura=$_POST["tF"];
	$idRegistro=$_POST["iR"];
	
	$consulta="SELECT tipoSolicitud FROM _67_tablaDinamica WHERE id__67_tablaDinamica=".$idRegistro;
	$tipoSolicitud=$con->obtenerValor($consulta);
	
	$arrPersonas="";
	$numReg=0;
	
	switch($tipoFigura)
	{
		case "1": //Figura juridica
			$datosCarpeta=obtenerDatosSujetosProcesalesDelitosCarpetaAdministrativa($carpetaAdministrativa);
			
			$consulta="SELECT distinct idReferencia FROM _5_gridCitacionNotificacion WHERE aplicableA=".$tipoSolicitud;
			$resFiguras=$con->obtenerFilas($consulta);
			while($fFigura=$con->fetchRow($resFiguras))
			{
				$consulta="SELECT  nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica =".$fFigura[0];
				$lblTipoFigura=$con->obtenerValor($consulta);
				$nombreTipo="";
				switch($fFigura[0])
				{
					case "1":
						$nombreTipo="Denunciantes";
					break;
					case "2":
						$nombreTipo="Víctimas";
					break;
					case "3":
						$nombreTipo="Asesores";
					break;
					case "4":
						$nombreTipo="Imputados";
					break;
					case "5":
						$nombreTipo="Defensores";
					break;
					case "6":
						$nombreTipo="Representantes";
					break;
					case "7":
						$nombreTipo="Testigos";
					break;
				}
				
				
				if(isset($datosCarpeta[$nombreTipo]))
				{
					foreach($datosCarpeta[$nombreTipo] as $d)
					{
						$arrFormatos="";
						$arrMediosNotificacion="";
						
						$consulta="SELECT t.id__10_tablaDinamica,concat('[',t.cveFormato,'] ',t.nombreFormato) FROM _5_gridCitacionNotificacion g,_10_tablaDinamica t 
								WHERE g.formatoNotificacion=t.id__10_tablaDinamica AND g.aplicableA=".$tipoSolicitud." AND g.idReferencia=".$fFigura[0];
						
						
						$arrFormatos=$con->obtenerFilasArreglo($consulta);	
						
						$consulta="SELECT idOpcion FROM _64_tablaDinamica c,_64_tipoMedioNotificacion m WHERE m.idPadre=c.id__64_tablaDinamica AND
								c.idReferencia=".$d["idRegistro"];
						
						$listaCheck=$con->obtenerListaValores($consulta);
						
						if($listaCheck=="")
						{
							$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica";
							$listaCheck=$con->obtenerListaValores($consulta);
						}
						
						
						
						
						$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica where id__63_tablaDinamica in (".$listaCheck.")";
						$arrMediosNotificacion=$con->obtenerFilasArreglo($consulta);
						
						
						$o="['".$d["idRegistro"]."','".($d["nombre"]." ".$d["apellidoPaterno"]." ".$d["apellidoMaterno"])." (".cv($lblTipoFigura).")','".$d["tipoPersona"]."',".$arrFormatos.",".$arrMediosNotificacion.",'".$fFigura[0]."']";
						
						if($arrPersonas=="")
							$arrPersonas=$o;
						else
							$arrPersonas.=",".$o;
							
						$numReg++;
					}
					
				
				}
			
			}
			
			
			
		
		
		break;
		case "2":  //Institucion
			$consulta="SELECT id__149_tablaDinamica,nombreInstancia FROM _149_tablaDinamica";
			$resFiguras=$con->obtenerFilas($consulta);
			while($fFigura=$con->fetchRow($resFiguras))
			{
				$arrFormatos="";
				$arrMediosNotificacion="";
				
				$consulta="SELECT t.id__10_tablaDinamica,concat('[',t.cveFormato,'] ',t.nombreFormato) FROM _149_gridConfiguracionCitacionesNotificaciones g,_10_tablaDinamica t 
						WHERE g.formatoNotificacion=t.id__10_tablaDinamica AND g.aplicableA=".$tipoSolicitud." AND g.idReferencia=".$fFigura[0];
				
				
				$arrFormatos=$con->obtenerFilasArreglo($consulta);	
				
				$consulta="SELECT idOpcion FROM _149_cheMediosNotificacion m  WHERE m.idPadre=".$fFigura[0];
				
				$listaCheck=$con->obtenerListaValores($consulta);
				
				if($listaCheck=="")
				{
					$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica";
					$listaCheck=$con->obtenerListaValores($consulta);
				}
				
				$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica where id__63_tablaDinamica in (".$listaCheck.")";
				$arrMediosNotificacion=$con->obtenerFilasArreglo($consulta);
				
				$o="['".$fFigura[0]."','".($fFigura[1])."','1',".$arrFormatos.",".$arrMediosNotificacion.",'0']";
				if($arrPersonas=="")
					$arrPersonas=$o;
				else
					$arrPersonas.=",".$o;
					
				$numReg++;
			}
			
		break;
		
	}
	
	
	echo "1|[".$arrPersonas."]";
	
	
	
}

function verificarCedulaProfesional()
{
	global $con;
	$noCedula=$_POST["noCedula"];
//	$resultado=utf8_encode(consultarPaginaCedulaProfesional($noCedula));
	$resultado=1;	
	echo "1|".$resultado;
}


function consultarPaginaCedulaProfesional($noCedula)
{
	$params["json"]='{"maxResult":"1000","idCedula":"'.$noCedula.'","nombre":"","paterno":"","materno":"",
					"h_genero":"","genero":"","annioInit":"","annioEnd":"","insedo":"","inscons":"",
					"institucion":"TODAS"}';
	$postData=http_build_query	(
									$params
								);
								
	$opciones=array();
	$opciones["http"]["method"]="POST";
	$opciones["http"]["header"]="Content-type: application/x-www-form-urlencoded";
	$opciones["http"]["content"]=$postData;
	$context  = stream_context_create($opciones);
	
	$result = file_get_contents('http://www.cedulaprofesional.sep.gob.mx/cedula/buscaCedulaJson.action', false, $context);
	return $result;							
}

function obtenerElementoApoyoBilioteca()
{
	global $con;
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
	$consulta="SELECT id__170_tablaDinamica AS idRegistro,tituloRecursos,tiposRecurso as tipoRecurso,
	if(descripcion<>'',descripcion,'(Sin descripción)') as descripcion,origenRecurso,url,documentoAdjunto,
	formaVisualizacion FROM _170_tablaDinamica WHERE situacionRecurso=1 and tiposRecurso>1 and ".$cadCondWhere;
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}

function obtenerConfiguracionProcesoTablero()
{
	global $con;
	$cadProceso=$_POST["cadProceso"];
	$oProceso=json_decode($cadProceso);
	
	$idFormulario=obtenerFormularioBase($oProceso->proceso);
	$idRegistro=-1;
	$rol="54_0";
	$dComp="agregar";
	$actor="";
	if($oProceso->repetible==0)
	{
		$consulta="";
		$nombreTabla="_".$idFormulario."_tablaDinamica";
		if($oProceso->multiplesSujetos==1)
		{
			$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM ".$nombreTabla." 
						WHERE idEvento=".$oProceso->idEvento;
		}
		else
		{
			$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM ".$nombreTabla." 
						WHERE  idEvento=".$oProceso->idEvento;
						
			if($con->existeCampo("idUsuario",$nombreTabla))			
			{
				$consulta.=" and idUsuario=".$oProceso->idUsuario;
			}
						
			if($con->existeCampo("figuraJuridica",$nombreTabla))			
			{
				$consulta.=" AND figuraJuridica=".$oProceso->figuraJuridica;
			}
			

						
			
		}
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$etapa=1;
		if($fRegistro)
		{
			$etapa=$fRegistro[1];
			$idRegistro=$fRegistro[0];
			$dComp="auto";
			$actor=obtenerActorProcesoIdRol($oProceso->proceso,$rol,$etapa);
			if($actor=="")
				$actor=0;
		}
		else
		{
			$idPerfil=obtenerIdPerfilEscenario($oProceso->proceso,1,$rol,true);	
			$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$oProceso->proceso.
						" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
			
			$actor=$con->obtenerValor($consulta);
		}
		
		
		
	}
	else
	{
		$idPerfil=obtenerIdPerfilEscenario($oProceso->proceso,1,$rol,true);	
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$oProceso->proceso.
						" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
			
		$actor=$con->obtenerValor($consulta);
	}
	if($actor=="")
		$actor=0;
	echo '1|{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","dComp":"'.$dComp.'","actor":"'.$actor.'"}';
	
}

function obtenerActorProcesoDocumentos()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="";
	$idProceso=obtenerIdProcesoFormulario($obj->idFormulario);
	
	$idRol=$obj->idRol;
	if(strpos($idRol,"_")===false)
	{
		$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$obj->idRol;
		$idRol=$con->obtenerValor($consulta);
		if($idRol=="")
			$idRol=0;
	}
	
	$numEtapa="0";
	if(isset($obj->idEtapa))
		$numEtapa=$obj->idEtapa;
	else
	{
		if(isset($obj->idRegistro))
		{
			$consulta="SELECT idEstado FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;

			$numEtapa=$con->obtenerValor($consulta);
		}
	}
	
	$idActor=obtenerActorProcesoIdRol($idProceso,$idRol,$numEtapa);

	if($idActor=="")
		$idActor=0;
	
	echo "1|".$idActor;	
	
}

function obtenerDatosSolicitudAudienciaIntermedia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idProceso=obtenerIdProcesoFormulario(185);
	$objResp="";
	$rol="54_0";
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia=".$obj->idEventoReferencia;
	$fDatodAudiencia=$con->obtenerPrimeraFila($consulta);
	if(!$fDatodAudiencia)
	{
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
							" and idAccion=8 and actor ='".$rol."' and idPerfil=-1";
				
		$actor=$con->obtenerValor($consulta);
		if($actor=="")
			$actor=0;
		$objResp='{"arrEspecificaciones":"","idRegistro":"-1","dComp":"agregar","actor":"'.$actor.'"}';
	}
	else
	{
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fDatodAudiencia[1]);
		if($actor=="")
			$actor=0;
		$objResp='{"arrEspecificaciones":"","idRegistro":"'.$fDatodAudiencia[0].'","dComp":"auto","actor":"'.$actor.'"}';
	}
	
	echo "1|".$objResp;
	
}

function obtenerOtrasAudienciasPosteriorEvento()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$arrRegistros="";
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE 
				carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoContenido=3";
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
	
	$numReg=0;
	$consulta="SELECT fechaEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fechaEvento=$con->obtenerValor($consulta);
	$consulta="SELECT idRegistroEvento,situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento IN (".$listaEventos.
				") AND fechaEvento>='".$fechaEvento."'";//."' AND idRegistroEvento<>".$idEvento;
	
		
	$resEventos=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($resEventos))
	{
		$datos=obtenerDatosEventoAudiencia($fila[0]);
		$consulta="SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=".$fila[1];
		$situacion=$con->obtenerValor($consulta);
		$o='{"idEvento":"'.$fila[0].'","fechaAudiencia":"'.$datos->fechaEvento.'","horaInicial":"'.$datos->horaInicio.
			'","horaTermino":"'.$datos->horaFin.'","tipoAudiencia":"'.$datos->tipoAudiencia.'","situacion":"'.$situacion.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarDocumentoPromociones()
{
	
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT id__123_tablaDinamica FROM _123_tablaDinamica WHERE iFormulario=".$obj->iFormulario.
				" AND iRegistro=".$obj->iRegistro." AND tipoDocumento=".$obj->tipoDocumento;
				
	$idRegistro=$con->obtenerValor($consulta);				
	
	$idEstado="1.1";
	switch($obj->iFormulario)
	{
		case "96":
			$consulta="SELECT imputado,figurasJuridicas,carpetaAdministrativa FROM _96_tablaDinamica WHERE id__96_tablaDinamica=".$obj->iRegistro;
		break;
		case "197":
			$idEstado="1.2";
			$consulta="SELECT idUsuario,4,carpetaAdministrativa FROM _197_tablaDinamica WHERE id__197_tablaDinamica=".$obj->iRegistro;
		break;
		
	}
	$fFiguras=$con->obtenerPrimeraFila($consulta);
	
	if($idRegistro=="")
	{
		$arrValores=array();
		$arrDocumentosReferencia=NULL;
		$arrValores["idPersona"]=$fFiguras[0];
		$arrValores["tipoFigura"]=$fFiguras[1];
		$arrValores["tipoDocumento"]=$obj->tipoDocumento;
		$arrValores["iFormulario"]=$obj->iFormulario;
		$arrValores["iRegistro"]=$obj->iRegistro;
		$arrValores["carpetaAdministrativa"]=$fFiguras[2];
		
		$idRegistro=crearInstanciaRegistroFormulario(123,-1,$idEstado,$arrValores,$arrDocumentosReferencia,-1,426);	
		
	}
	
	
	$consulta="SELECT idEstado FROM _123_tablaDinamica WHERE id__123_tablaDinamica= ".$idRegistro;
				
	$idEstado=$con->obtenerValor($consulta);	
	
	$idProceso=obtenerIdProcesoFormulario(123);
	$rol="36_0";
	if($obj->iFormulario==197)
	{
		$rol="65_0";
	}
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$idEstado);
	
	$oObj='{"idRegistro":"'.$idRegistro.'","actor":"'.$actor.'"}';
	
	
	echo "1|".$oObj;
				
	
}

function obtenerEventosJuezAgenda()
{
	global $con;
	$idJuez=$_POST["idJuez"];
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT idRegistroEvento FROM 7001_eventoAudienciaJuez WHERE idJuez=".$idJuez;
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
	$consulta="SELECT horaInicioEvento,horaFinEvento,(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) FROM 7000_eventosAudiencia a
				WHERE  fechaEvento>='".$start."' AND fechaEvento<='".$end."' and idRegistroEvento in (".$listaEventos.")";

	$arrEventos="";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$e='{"editable":false,"title":"'.cv($fila[2]).'","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#900"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
		
	echo '['.$arrEventos.']';
	
}

function obtenerRegistroAplicacionAccionAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$idProceso=obtenerIdProcesoFormulario(233);
	$objResp="";
	$rol="54_0";
	$consulta="SELECT id__233_tablaDinamica,idEstado FROM _233_tablaDinamica WHERE idEvento=".$obj->idEventoReferencia." and idAccion=".$obj->idAccion;
	$fDatodAudiencia=$con->obtenerPrimeraFila($consulta);
	if(!$fDatodAudiencia)
	{
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
							" and idAccion=8 and actor ='".$rol."' and idPerfil=-1";
				
		$actor=$con->obtenerValor($consulta);
		if($actor=="")
			$actor=0;
		$objResp='{"idRegistro":"-1","dComp":"agregar","actor":"'.$actor.'"}';
	}
	else
	{
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fDatodAudiencia[1]);
		if($actor=="")
			$actor=0;
		$objResp='{"idRegistro":"'.$fDatodAudiencia[0].'","dComp":"auto","actor":"'.$actor.'"}';
	}
	
	echo "1|".$objResp;
}

function obtenerResolutivosAccionesEventoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$arrRegistros="";
	$numReg=0;
	$rol="54_0";
	$consulta="SELECT idFormulario,idRegistro,tituloContenido FROM 7016_contenidosEventoAudiencia WHERE idRegistroEvento=".$idEvento." ORDER BY idContenido";
	$rResolutivo=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($rResolutivo))
	{
		$idProceso=obtenerIdProcesoFormulario($fila[0]);
		$consulta="SELECT idEstado FROM _".$fila[0]."_tablaDinamica WHERE id__".$fila[0]."_tablaDinamica=".$fila[1];
		$numEtapa=$con->obtenerValor($consulta);
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$numEtapa);
		if($actor=="")
			$actor=0;
		$o='{"idFormulario":"'.$fila[0].'","idRegistro":"'.$fila[1].'","tituloContenido":"'.cv($fila[2]).'","actor":"'.$actor.'"}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function obteneDatosParticipanteAudiencia()
{
	global $con;
	$idFigura=$_POST["idFigura"];
	$idParticipante=$_POST["idParticipante"];
	$idEvento=$_POST["idEvento"];
	
	
	$consulta="SELECT id__228_tablaDinamica FROM _228_tablaDinamica WHERE idUsuario=".$idParticipante.
				" AND idEvento=".$idEvento." AND presentoAudiencia=1";
	$idRegistro=$con->obtenerValor($consulta);
	if($idRegistro=="")
		$idRegistro=-1;
	$o='{"idFormulario":"228","idRegistro":"'.$idRegistro.'","descripcion":"Asistió a audiencia","cumple":"'.($idRegistro==-1?0:1).'"}';	
	$arrDatos=$o;
	
	$consulta="SELECT id__72_tablaDinamica,idEstado FROM _72_tablaDinamica WHERE idPersonaNotificar=".$idParticipante.
				" AND idEvento=".$idEvento;
				
	
	$fNotificacion=$con->obtenerPrimeraFila($consulta);
	
	if(!$fNotificacion)
		$idRegistro=-1;
	else
		$idRegistro=$fNotificacion[0];
	
	$cumple=0;	
	if($idRegistro==-1)	
	{
		$cumple=0;
		$situacionNotificacion="Orden de notificación NO realizada";
	}
	else
	{
		if(($fNotificacion[1]>=4)&&($fNotificacion[1]!=7))
			$cumple=1;
		
		$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=96 AND numEtapa=".$fNotificacion[1];
		$situacionNotificacion=$con->obtenerValor($consulta);
	}
		
	$o='{"idFormulario":"72","idRegistro":"'.$fNotificacion[0].'","descripcion":"Notificación ('.cv($situacionNotificacion).')","cumple":"'.$cumple.'"}';	
	$arrDatos.=",".$o;	
	
	echo '{"numReg":"0","registros":['.$arrDatos.']}';
	
}

function obtenerProcesoOrigen()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT * FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$objReg='{"iFormulario":"'.$fRegistro["iFormulario"].'","iRegistro":"'.$fRegistro["iRegistro"].'"}';
	
	echo "1|".$objReg;
	
	
}

function obtenerFolioRegistroSolicitud()
{
	global $con;
	$idFormulario=$_POST["iF"];
	$idRegistro=$_POST["iR"];
	
	$consulta="select codigo from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$folio=$con->obtenerValor($consulta);
	echo "1|".$folio;
	
}

function obtenerProcesosAsociadosFormulario()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$actor=$_POST["actor"];
	
	$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
	$rol=$con->obtenerValor($consulta);
	$arrRegistros="";
	$nReg=0;
	
	$consulta="SELECT iFormulario,iRegistro,descripcion FROM 3008_procesosAsociadosFormulario WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$idProceso=obtenerIdProcesoFormulario($fila[0]);
		
		$consulta="SELECT idEstado FROM _".$fila[0]."_tablaDinamica WHERE id__".$fila[0]."_tablaDinamica=".$fila[1];
		
		$idEstado=$con->obtenerValor($consulta);
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$idEstado;
		$fConsulta=$con->obtenerPrimeraFila($consulta);
		$situacion=removerCerosDerecha($fConsulta[0]).".- ".cv($fConsulta[1]);
		
		$descripcion=$fila[2];
		if($descripcion!="")
		{
			$consulta="SELECT nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
			$descripcion=$con->obtenerValor($consulta);
		}
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$idEstado);
		if($actor=="")
			$actor=0;
			
		$o='{"iFormulario":"'.$fila[0].'","iRegistro":"'.$fila[1].'","situacion":"'.$situacion.'","descripcion":"'.cv($descripcion).'","actor":"'.$actor.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$nReg++;
			
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';	
}

function marcarNotificacionesTableroControl()
{
	global $con;
	$listaNotificaciones=$_POST["l"];
	$status=$_POST["s"];
	$iT=$_POST["iT"];
	
	/*$consulta="update 9060_tableroControl_".$iT." set idEstado=".$status." where idRegistro in (".$listaNotificaciones.")";
	eC($consulta);*/
	if($status==2)
	{
		$arrTareas=explode(",",$listaNotificaciones);
		foreach($arrTareas as $t)
		{
			if($t!="")
				marcarTareaAtendida($t,$iT);
		}
		echo "1|";
	}
	else
	{
		$consulta="update 9060_tableroControl_".$iT." set idEstado=".$status." where idRegistro in (".$listaNotificaciones.")";
		eC($consulta);
	}
	
}

function buscarCarpetaAdministrativa()
{
	global $con;
	$criterio=$_POST["criterio"];
	
	$codigoUnidad=$_SESSION["codigoInstitucion"];
	if(isset($_POST["uG"]))
		$codigoUnidad=$_POST["uG"];
	$tipoCarpeta=0;
	if(isset($_POST["tC"]))
		$tipoCarpeta=$_POST["tC"];
		
	$ciclo=0;
	if(isset($_POST["ciclo"]))
		$ciclo=$_POST["ciclo"];	
		
	$numReg=0;
	$arrCarpetas="";
	$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$codigoUnidad."'
			and carpetaAdministrativa like '%".$criterio."%'";
	if($codigoUnidad=="")		
	{
		$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa like '%".$criterio."%'";
	}
			
			
	if($tipoCarpeta!=0)
	{
		$consulta.=" and tipoCarpetaAdministrativa in(".$tipoCarpeta.")";
		
	}
	
	if($ciclo!=0)
	{
		$consulta.=" and fechaCreacion>='".$ciclo."-01-01' and fechaCreacion<='".$ciclo."-12-31'";		
	}
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$o='{"carpetaAdministrativa":"'.$fila[0].'","idCarpeta":"'.$fila[1].'"}';
		if($arrCarpetas=="")
			$arrCarpetas=$o;
		else
			$arrCarpetas.=",".$o;
		$numReg++;
	}

	echo '{"numReg":"'.$numReg.'","registros":['.$arrCarpetas.']}';
	
	
	
	
}

function obtenerEventosAudienciaSGJP()
{
	global $con;
	global $tipoMateria;
	$considerarConRecursos="";
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "situacion":
					$c=" and situacion in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$c=" and idSala in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "edificio":
					$c=" and idEdificio=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "tipoAudiencia":
					$c=" and tipoAudiencia=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "conRecursosAdicionales":
				
						$considerarConRecursos=$filter[$x]["data"]["value"];
				
				break;
			}
		}
		
	}
	
	$uG=$_POST["uG"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	
	$consulta="";
	$audienciasVirtuales=0;
	if(isset($_POST["audienciasVirtuales"]))
	{
		$audienciasVirtuales=$_POST["audienciasVirtuales"];
	}
	
	if($audienciasVirtuales==0)
	{
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
				horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
				FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null
				".$condiciones." ";		
	}
	else
	{
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,e.situacion,
				idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
				horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
				FROM 7000_eventosAudiencia e,_15_tablaDinamica s where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
				and horaInicioEvento is not null and horaFinEvento is not null and s.id__15_tablaDinamica=e.idSala and s.perfilSala=3
				".$condiciones." ";	
	}
	
	if($uG!="0")		
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad in('".$uG."')";
		$iUnidad=$con->obtenerListaValores(str_replace("''","'",$query));
		$consulta.=" and idCentroGestion in(".$iUnidad.")";
	}
	else
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
		$iUnidad=$con->obtenerListaValores($query);
		$consulta.=" and idCentroGestion in(".$iUnidad.")";
	}

	if(isset($_POST["iEdificio"]))
	{
		$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
	}
	
	//$consulta.=" limit 25,5";
	
	
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT('(',if(noJuez is null,'',noJuez),') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		if($tipoMateria=="SCC")
		{
			$query="SELECT GROUP_CONCAT(CONCAT('(',if(noJuez is null,'',noJuez),') ',u.nombre) SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		}
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta="";
		$tipoAudiencia=$fila[8];
		$tAudiencia="";
		$carpetaInvestigacion="";
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$carpeta=$fDatos[0];
			$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";

			$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fCarpetaInvestigacion[0];
			if($idActividad=="")
			{
				$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
			}

			$carpetaInvestigacion=$fCarpetaInvestigacion[1];
		}
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila[4])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "9"://Cancelado
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		$canal=0;
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
		
		
		$imputado=$con->obtenerListaValores($consulta);
		
		$tImputados=$con->filasAfectadas;
		
		

		
		
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in (SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A')";
		
		
		$victima=$con->obtenerListaValores($consulta);
		
		
		
		
		$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
		$perfilSala=$con->obtenerValor($consulta);
		
		$arrEstadoConsideraReunon[1]=1;
		$arrEstadoConsideraReunon[2]=1;
		$arrEstadoConsideraReunon[4]=1;
		$arrEstadoConsideraReunon[5]=1;
		
		
		$urlVideoConferencia="";
		if(isset($arrEstadoConsideraReunon[$fila[4]]))
		{
			$consulta="SELECT valorComplementario3 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento=".$fila[0]." AND tipoAccion=10 AND notificado=1";
			
			
			$urlVideoConferencia=$con->obtenerValor($consulta);
		}
		
		
		
		$o='{"urlCanal":"","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
			"notificacionMAJO":"","mensajeMAJO":"","delitos":"","edificio":"'.$fila[14].'","carpetaInvestigacion":"","imputado":"'.
			cv($imputado).'","victima":"'.cv($victima).'","notificacionCabina":"","recursosAdicionales":"","mensajeCabina":"'.
			'","conRecursosAdicionales":"0","urlVideoConferencia":"'.$urlVideoConferencia.'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerEventosAudienciaJuez()
{
	global $con;
	global $tipoMateria;
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$condiciones=" and idSala=".$filter[$x]["data"]["value"];
				break;
				case "tipoAudiencia":
					$condiciones=" and tipoAudiencia=".$filter[$x]["data"]["value"];
				break;
			}
		}
		
	}
	
	$iJuez=$_POST["iJuez"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud 
			FROM 7000_eventosAudiencia where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null
			".$condiciones;
			
			
	if($iJuez!=0)		
	{
		$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud 
			FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null and j.idRegistroEvento=e.idRegistroEvento and j.idJuez=".$iJuez." 
			and situacion >0
			".$condiciones;
	}

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		
		if($tipoMateria=="SCC")
		{
			$query="SELECT GROUP_CONCAT(u.nombre) FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		}
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta="";
		$tipoAudiencia="";
		$tAudiencia="";
		
		$carpetaInvestigacion="";
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$carpeta=$fDatos[0];
			$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";
			$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fCarpetaInvestigacion[0];
			if($idActividad=="")
			{
				$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
			}
			$carpetaInvestigacion=$fCarpetaInvestigacion[1];
		}
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D')";
		$imputado=$con->obtenerListaValores($consulta);
		
		$tImputados=$con->filasAfectadas;
		
		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$idActividad."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";
		$lblDelitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A')";
		$victima=$con->obtenerListaValores($consulta);
		
		
		
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila[4])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "9"://Cancelado
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		$arrEstadoConsideraReunon[1]=1;
		$arrEstadoConsideraReunon[2]=1;
		$arrEstadoConsideraReunon[4]=1;
		$arrEstadoConsideraReunon[5]=1;
		
		
		$urlVideoConferencia="";
		if(isset($arrEstadoConsideraReunon[$fila[4]]))
		{
			$consulta="SELECT valorComplementario3 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento=".$fila[0]." AND tipoAccion=10 AND notificado=1";
			
			
			$urlVideoConferencia=$con->obtenerValor($consulta);
		}
		
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$fila[8].'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","edificio":"'.$fila[5].
			'","delitos":"'.$lblDelitos.'","carpetaInvestigacion":"'.$carpeta.'","imputado":"'.cv($imputado).
			'","victima":"'.cv($victima).'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.
			$iRegistroSituacion.'","urlVideoConferencia":"'.$urlVideoConferencia.'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerCarpetasAdministrativasUnidadGestion()
{
	global $con;
	$uG=$_POST["uG"];
	$anio=$_POST["anio"];
	$tC=$_POST["tC"];
	$limit=$_POST["limit"];
	$start=$_POST["start"];
	
	$consulta="SELECT campoUsr,campoMysql FROM 9017_camposControlFormulario";
	$arrCampos=$con->obtenerFilasArregloAsocPHP($consulta);
	
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					$condiciones=" and carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
				break;
				case "etapaProcesal":
					$condiciones=" and etapaProcesalActual in(".$filter[$x]["data"]["value"].")";
				break;			
				case "carpetaBase":
					$condiciones=" and carpetaAdministrativaBase like '%".$filter[$x]["data"]["value"]."%'";
				break;	
				default:
					$f=$filter[$x];
					$campo=$f["field"];
					
					if(isset($arrCampos[$campo]))
						$campo=$arrCampos[$campo];
					
					$condicion=" like ";
					if(isset($f["data"]["comparison"]))
					{
						switch($f["data"]["comparison"])
						{
							case "gt":
								$condicion=">";
							break;
							case "lt":
								$condicion="<";
							break;
							case "eq":
								$condicion="=";
							break;
						}
					}
					
					$valor="";
					switch($f["data"]["type"])
					{
						case "numeric":
							$valor=$f["data"]["value"];
						break;
						case "date":
							$fecha=$f["data"]["value"];
							$arrFecha=explode('/',$fecha);
							$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
						break;
						case "list":
							$condicion=" in ";
							$arrValores=explode(',',$f["data"]["value"]);
							$nCt=sizeof($arrValores);
							for($xAux=0;$xAux<$nCt;$xAux++)
							{
								if($valor=='')
									$valor=$arrValores[$xAux];
								else
									$valor.=",".$arrValores[$xAux];
							}
							
							
							$valor="(".$valor.")";
						break;
						default:
							$valor="'".$f["data"]["value"]."%'";
						break;
					}
					
					$condiciones.=" and ".$campo.$condicion.$valor;
				break;
				
			}
		}
		
	}
	
	
	
	$arrRegistro="";
	$numReg=0;
	$consulta="SELECT count(*) from 7006_carpetasAdministrativas  c
				WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
				and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones;
	$numReg=$con->obtenerValor($consulta);			
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,tipoCarpetaAdministrativa,carpetaAdministrativaBase,
				fechaCreacion,idActividad, carpetaInvestigacion,idCarpeta,idJuezTitular,unidadGestion
				
				 FROM 7006_carpetasAdministrativas  c
				WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
				and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones." ORDER BY carpetaAdministrativa limit ".$start.",".$limit;

	$res=$con->obtenerFilas($consulta);

	while($fila=$con->fetchRow($res))
	{
		$juezResponsable=obtenerNombreUsuario($fila[9]==""?-1:$fila[9]);
		$carpetaInicial="";
		$carpetaOralidad="";
		$carpetaEjecucion="";	
		$lblAcciones="";	
		switch($fila[3])
		{
			case 1:
				
					$carpetaInicial=$fila[0];
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativaBase='".$carpetaInicial."' AND tipoCarpetaAdministrativa=5";
					$carpetaOralidad=$con->obtenerListaValores($consulta,"'");
					$carpetaAux="'".$carpetaInicial."'";
	
					if($carpetaOralidad!="")
					{
						$carpetaAux.=",".$carpetaOralidad;
						
					}
					
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
								WHERE carpetaAdministrativaBase in(".$carpetaAux.") AND 
								tipoCarpetaAdministrativa=6";
					$carpetaEjecucion=$con->obtenerListaValores($consulta);
					$carpetaOralidad=str_replace("'","",$carpetaOralidad);
				
			break;
			case 5:
				$carpetaInicial=$fila[4];
				$carpetaOralidad=$fila[0];
				
				$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
						WHERE carpetaAdministrativaBase='".$carpetaOralidad."' 
						AND tipoCarpetaAdministrativa=6";
				$carpetaEjecucion=$con->obtenerListaValores($consulta,"'");
				$carpetaEjecucion=str_replace("'","",$carpetaEjecucion);
			break;
			case 6:
				$carpetaEjecucion=$fila[0];				
				$carpetaInicial="";
				$carpetaOralidad="";
				
				$consulta="SELECT tipoCarpetaAdministrativa,carpetaAdministrativaBase FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$fila[4]."'";
				$fCarpeta=$con->obtenerPrimeraFila($consulta);	
				switch($fCarpeta[0])	
				{
					case 1:
						$carpetaInicial=$fila[4];
					break;
					case 5:
						$carpetaOralidad=$fila[4];
						$carpetaInicial=$fCarpeta[1];
					break;
				}
				$consulta="SELECT id__385_tablaDinamica FROM _385_tablaDinamica WHERE idEstado in(3,5) AND carpetaEjecucion='".$fila[0]."'";
				$idRegistro=$con->obtenerValor($consulta);
				
				if($idRegistro!="")
				{
					$lblAcciones="<a href='javascript:abrirDatosEnvioEjecucion(\\\"".bE($idRegistro)."\\\")'><img src='../images/page_white_magnify.png'></a>";
				}
				
				
			break;
		}
		$folioCarpetaInvestigacion=$fila[7];
		$cInicial="";
		
		$imputados="";
		if($fila[6]=="")	
			$fila[6]=-1;
			
		if(($fila[3]==3)&&($fila[4]!=""))
		{
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila[4]."'";
			$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
	  
			$fila[6]=$fCarpetaBase["idActividad"];
	  
			$folioCarpetaInvestigacion=$fCarpetaBase["carpetaInvestigacion"];
				
		}
			
			
		$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) ,r.situacionProcesal,detalleSituacion
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica and r.situacion<>2
				order by nombre,apellidoPaterno,apellidoMaterno";

		$rImputados=$con->obtenerFilas($consulta);
		while($fImputado=$con->fetchRow($rImputados))
		{
			$i=$fImputado[0];
			$consulta="SELECT situacion FROM 7014_situacionImputado WHERE idRegistro=".$fImputado[1];

			$situacion=$con->obtenerValor($consulta);
			$i.=" (Situaci&oacute;n: ".$situacion;
			if($fImputado[2]!="")
			{
				$consulta="SELECT detalleSituacionImputado FROM 7014_detalleSituacionImputado WHERE idRegistro=".$fImputado[2];
				$detalle=$con->obtenerValor($consulta);
				$i.=" - ".$detalle;
			}
			$i.=")";
			if($imputados=="")
				$imputados=$i;
			else
				$imputados.="<br>".$i;
			
		}
		
		
		
		if(($fila[3]==9)&&($fila[4]!=""))
		{
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila[4]."'";
			$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
	
			$fila[6]=$fCarpetaBase["idActividad"];
	
			$folioCarpetaInvestigacion=$fCarpetaBase["carpetaInvestigacion"];
		}
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$victimas=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT GROUP_CONCAT(dl.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito dl WHERE d.idActividad=".$fila[6]." AND
					dl.id__35_denominacionDelito=d.denominacionDelito";
		
		$delitos=$con->obtenerValor($consulta);

		/*$consulta="SELECT u.Nombre FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e,7001_eventoAudienciaJuez j,800_usuarios u WHERE
				c.carpetaAdministrativa='".$fila[0]."' AND c.tipoContenido=3 AND e.idRegistroEvento=c.idRegistroContenidoReferencia
				AND e.situacion IN(1,2,4,5) AND j.idRegistroEvento=e.idRegistroEvento AND u.idUsuario=j.idJuez ORDER BY e.fechaEvento DESC";*/
		
		$ultimoJuez="";
		if($fila[3]==6)
		{
			$consulta="SELECT u.Nombre FROM _385_tablaDinamica s, 7000_eventosAudiencia e,7001_eventoAudienciaJuez j,800_usuarios u 
					WHERE carpetaEjecucion='".$fila[0]."' AND j.idRegistroEvento=e.idRegistroEvento AND e.idRegistroEvento=s.fechaAudiencia
					AND u.idUsuario=j.idJuez";
			$ultimoJuez=$con->obtenerValor($consulta);
		}
		
		$cierreInvestigacion="";
		$fechaAcusacion="";
		$consulta="SELECT fechaReferencia FROM 3013_registroResolutivosAudiencia r,7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
					WHERE e.idRegistroEvento=r.idEvento AND tipoResolutivo=71 AND c.tipoContenido=3 AND c.idRegistroContenidoReferencia=e.idRegistroEvento
					AND c.carpetaAdministrativa='".$fila[0]."' AND fechaReferencia<>''  ORDER BY r.idRegistro LIMIT 0,1";
		$cierreInvestigacion=$con->obtenerValor($consulta);
		if($cierreInvestigacion!="")
		{
			$fechaAcusacion=obtenerHorasAjusteDiasNoHabiles($cierreInvestigacion,date("Y-m-d",strtotime("+15 days",strtotime($cierreInvestigacion))));

		}
		
		$consulta="SELECT group_concat(carpetaAdministrativa) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$fila[0]."' AND tipoCarpetaAdministrativa=9";
		$carpetaLeyNacional=$con->obtenerListaValores($consulta);
		
		$consulta="SELECT group_concat(carpetaAdministrativa) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$fila[0]."' AND tipoCarpetaAdministrativa=".$fila[3];
		$carpetaIncompetencia=$con->obtenerListaValores($consulta);
		
		
		
		
		$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","etapaProcesal":"'.$fila[2].
			'","carpetaInicial":"'.$carpetaInicial.'","carpetaOralidad":"'.$carpetaOralidad.'","carpetaEjecucion":"'.
			$carpetaEjecucion.'","fechaCreacion":"'.$fila[5].'","carpetaBase":"'.$fila[4].'","accionesCarpeta":"'.$lblAcciones.
			'","carpetaInvestigacion":"'.cv($folioCarpetaInvestigacion).'","ultimoJuez":"'.cv($ultimoJuez).
			'","cierreInvestigacion":"'.$cierreInvestigacion.'","fechaAcusacion":"'.$fechaAcusacion.'","imputados":"'.cv($imputados).
			'","delitos":"'.cv($delitos).'","tipoCarpeta":"'.$fila[3].'","victimas":"'.cv($victimas).
			'","idCarpetaAdministrativa":"'.$fila[8].'","juezResponsable":"'.cv($juezResponsable).'","unidadGestion":"'.$fila[10].
			'","carpetaLeyNacional":"'.$carpetaLeyNacional.'","carpetaIncompetencia":"'.$carpetaIncompetencia.'"}';
		if($arrRegistro=="")
			$arrRegistro=$o;
		else
			$arrRegistro.=",".$o;
		
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
}

function obtenerRegistroIncompetencia()
{
	global $con;
	$cA=$_POST["cA"];
	$idFormulario=$_POST["idFormulario"];
	$iR=-1;
	$a="";
	$act="";
	
	$rolesDEGJ["90_0"]=1;
	$rolesDEGJ["159_0"]=1;
	
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	$rol="168_0";
	
	foreach($rolesDEGJ as $r=>$resto)
	{
		if(existeRol("'".$r."'"))
		{
			$rol="90_0";
			break;
		}
	}
	
	
			
			
	$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM _".$idFormulario."_tablaDinamica WHERE carpetaAdministrativa='".$cA.
			"' and idEstado in (1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");

		
	}
	
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro?$fRegistro[1]:0);
	$act=bE($actor);
		
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerRegistroProgramacionAudiencia()
{
	global $con;
	$iE=$_POST["iE"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(266);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(185);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerEventosAudienciaSGJPCarpetaJudicial()
{
	global $con;
	global $tipoMateria;
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$condiciones=" and idSala=".$filter[$x]["data"]["value"];
				break;
				case "edificio":
					$condiciones=" and idEdificio=".$filter[$x]["data"]["value"];
				break;	
				case "tipoAudiencia":
					$condiciones=" and tipoAudiencia=".$filter[$x]["data"]["value"];
				break;
			}
		}
		
	}
	
	$numReg=0;
	$cJ=$_POST["cJ"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$idCarpetaAdministrativa=-1;
	if(isset($_POST["idCarpetaAdministrativa"]))
		$idCarpetaAdministrativa=$_POST["idCarpetaAdministrativa"];
	
	
	$mostrarDerivadas=0;
	if(isset($_POST["mostrarDerivadas"]))
		$mostrarDerivadas=$_POST["mostrarDerivadas"];
	
	$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$cJ."' AND tipoContenido=3";
	
	
	
	if($idCarpetaAdministrativa!=-1)
	{
		$consulta.=" and idCarpetaAdministrativa=".$idCarpetaAdministrativa;
	}
	
	if($mostrarDerivadas==1)
	{
		$listaCarpetasDerivadas=obtenerCarpetasVinculadas($cJ,-1);
		$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.
			") AND tipoContenido=3";
	}

	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia,idEdificio ,otroTipoAudiencia,idEventoMeet
			FROM 7000_eventosAudiencia where idRegistroEvento in(".$listaEventos.") and
			horaInicioEvento is not null and horaFinEvento is not null
			".$condiciones." order by horaInicioEvento";			
			
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT('(',noJuez,') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		
		
		$jueces=str_replace("[]","",$con->obtenerValor($query));
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta=$cJ;
		$tipoAudiencia=$fila[8];

		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila[4])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "3"://Cancelado
			case "9"://Aplazada
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		/*$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb not in(1000,99) ORDER BY fecha DESC	";
		$fRegistroNotificacionMajo=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb=1000 ORDER BY fecha DESC	";
		$fRegistroNotificacionCabina=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb=99 ORDER BY fecha DESC	";
		$fRegistroNotificacionMail=$con->obtenerPrimeraFila($consulta);*/
		$idActividad=-1;
		$carpetaInvestigacion="";
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$carpeta=$fDatos[0];
			$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";
			$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fCarpetaInvestigacion[0];
			if($idActividad=="")
			{
				$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
			}
			$carpetaInvestigacion=$fCarpetaInvestigacion[1];
			
		}
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
		$imputado=$con->obtenerListaValores($consulta);
		
		$tImputados=$con->filasAfectadas;
		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$idActividad."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";
		$lblDelitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 3005_bitacoraCambiosJuez WHERE idEventoAudiencia=".$fila[0];
		$nReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT situacion FROM 3014_registroResutadoAudiencia WHERE idEvento=".$fila[0];
		$situacionInforme=$con->obtenerValor($consulta);
		
		$recursosAdicionales="";
		if($con->existeTabla("7001_recursosAdicionalesAudiencia"))
		{
			$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fila[0];
			$resRecursos=$con->obtenerFilas($consulta);
			while($fRecurso=$con->fetchAssoc($resRecursos))
			{
				
				$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRecurso["idRecurso"];
				$recurso=$con->obtenerValor($consulta);
	
				if($recursosAdicionales=="")
					$recursosAdicionales=$recurso;
				else
					$recursosAdicionales.="<br>".$recurso;
			}
		}
		
		$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
		$perfilSala=$con->obtenerValor($consulta);
		
		$urlVideoConferencia="";
		
		$fRegistroNotificacionMajo[0]=1;
		$fRegistroNotificacionMajo[1]="";
		$fRegistroNotificacionCabina[0]=1;
		$fRegistroNotificacionCabina[1]="";
		$fRegistroNotificacionMail[0]=1;
		$fRegistroNotificacionMail[1]="";
		
		$arrEstadoConsideraReunon[1]=1;
		$arrEstadoConsideraReunon[2]=1;
		$arrEstadoConsideraReunon[4]=1;
		$arrEstadoConsideraReunon[5]=1;
		
		
		
		if(isset($arrEstadoConsideraReunon[$fila[4]]))
		{
			$consulta="SELECT valorComplementario3 FROM 7000_notificacionesEventosOperadoresServicios WHERE idRegistroEvento=".$fila[0]." AND tipoAccion=10 AND notificado=1";
			
			
			$urlVideoConferencia=$con->obtenerValor($consulta);
		}
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","horaInicialReal":"'.$fila[11].'","horaFinalReal":"'.$fila[12].
			'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.
			'","notificacionMAJO":"'.$fRegistroNotificacionMajo[0].'","mensajeMAJO":"'.cv($fRegistroNotificacionMajo[1]).
			'","notificacionCabina":"'.$fRegistroNotificacionCabina[0].'","mensajeCabina":"'.cv($fRegistroNotificacionCabina[1]).
			'","delitos":"'.cv($lblDelitos).'","tImputados":"'.$tImputados.'","edificio":"'.$fila[14].
			'","carpetaInvestigacion":"'.$carpetaInvestigacion.'","imputado":"'.cv($imputado).'","tCambioJuez":"'.$nReg.
			'","situacionResolutivos":"'.$situacionInforme.'","otroTipoAudiencia":"'.cv($fila[15]).
			'","recursosAdicionales":"'.cv($recursosAdicionales).'","notificacionMail":"'.$fRegistroNotificacionMail[0].
			'","mensajeMail":"'.cv($fRegistroNotificacionMail[1]).'","audienciaVirtual":"'.((($perfilSala==3)||($perfilSala==4))?1:0).
			'","urlVideoConferencia":"'.$urlVideoConferencia.'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerRegistroProgramacionAudienciaCarpeta()
{
	global $con;
	global $servidorPruebas;
	global $tipoMateria;
	$iE=$_POST["iE"];
	$cA=$_POST["cA"];
	$idCarpeta=$_POST["idCarpeta"];
	$iR=-1;
	$a="";
	$act="";
	
	$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
	if($idCarpeta!=-1)
	{
		$consulta.=" and idCarpeta=".$idCarpeta;
	}
	$tCarpeta=$con->obtenerValor($consulta);
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."' and carpetaAdministrativa='".$cA.
			"' and idEstado=1";
			
	if($idCarpeta!=-1)
	{
		$consulta.=" and idCarpetaAdministrativa=".$idCarpeta;
	}		
			
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		
		
		if($tipoMateria=="P")
		{
			$act=bE(266);//SUbdirector de Causa y Sala
			
			if($tCarpeta==6)
			{
				$act=bE(367);//SUbdirector de salas
			}
		}
		else
		{
			if($tipoMateria=="F")
			{
				$act=bE(266);//SUbdirector de Causa y Sala
				//$act=bE(177);//Controlador tablero evento de audiencia
			}
			else
			{
				if($tipoMateria=="C")
				{
					
					$act=bE(266);//SUbdirector de Causa y Sala
				}
				else
				{
					if($tipoMateria=="SCC")
					{
						
						$act=bE(508);//SUbdirector de Causa y Sala
					}
				}
			}
		}
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(185);
		if($tipoMateria=="P")
		{
			$rol='69_0';//SUbdirector de Causa y Sala
			if($tCarpeta==6)
			{
				$rol='81_0';//SUbdirector de salas
			}
			
		}
		else
		{
			if($tipoMateria=="F")
			{
				$rol='69_0';  //SUbdirector de Causa y Sala
				//$rol='54_0'; //Controlador tablero evento de audiencia
			}
			else
			{
				if($tipoMateria=="SCC")
				{
					$rol='81_0';  //SUbdirector de Causa y Sala
				}
				else
				{
					$rol='69_0';  //SUbdirector de Causa y Sala
				}
			}
		}
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro[1]);
		$act=bE($actor);
		
		
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}



function obtenerArbolCarpetaJudicial()
{
	global $con;
	$carpetaAdministrativa=bD($_POST["cA"]);
	$mostrarDerivadas=0;
	if(isset($_POST["mD"]))
		$mostrarDerivadas=$_POST["mD"];
	$iCarpeta=$_POST["iCarpeta"];
	$arrCarpetas=array();
	obtenerCarpetasPadreIdCarpeta($carpetaAdministrativa,$arrCarpetas,$iCarpeta);
	$listaCarpetasAsociadas="'".$carpetaAdministrativa."'";
		
	$oPadre="";
	foreach($arrCarpetas as $p)	
	{
		$listaCarpetasAsociadas.=",'".$p["carpetaAdministrativa"]."'";
		if($oPadre=="")
			$oPadre='{expanded:true,"icon":"../images/s.gif","id":"'.$p["carpetaAdministrativa"].'_'.$p["idCarpeta"].'","iCarpeta":"'.$p["idCarpeta"].'","text":"'.$p["carpetaAdministrativa"].'",children:[@hijos],leaf:false}';
		else
		{
			$oHijo='{expanded:true,"icon":"../images/s.gif","id":"'.$p["carpetaAdministrativa"].'_'.$p["idCarpeta"].'","iCarpeta":"'.$p["idCarpeta"].'","text":"'.$p["carpetaAdministrativa"].'",children:[@hijos],leaf:false}';
			$oPadre=str_replace("@hijos",$oHijo,$oPadre);
		}
	}
	$arrHijos="[]";		//obtenerCarpetasHijas($carpetaAdministrativa)
	if($mostrarDerivadas==1)
	{
		$arrHijos="[".obtenerCarpetasHijas($carpetaAdministrativa)."]";
	}
	
	
	$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	if($iCarpeta!=-1)
	{
		$consulta.=" AND idCarpeta=".$iCarpeta;
	}
	$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$obj='{"cls":"expedientePrincipal",tipoCarpeta:"0","idPerfilAcceso":"'.$fCarpetaBase["idPerfilAcceso"].'",expanded:true,"icon":"../images/s.gif","id":"'.$carpetaAdministrativa.'_'.$iCarpeta.'","iCarpeta":"'.$iCarpeta.'","text":"'.$carpetaAdministrativa.'",children:'.$arrHijos.',leaf:'.(($arrHijos=="[]")?"true":"false").'}';
	
	if($oPadre!="")
		$oPadre=str_replace("@hijos",$obj,$oPadre);	
	else
		$oPadre=$obj;
	
	$arrRelacionados="";
	$consulta="SELECT * FROM 7008_tiposRelacionesCarpetas";
	$res=$con->obtenerFilas($consulta);
	while($f=$con->fetchRow($res))
	{
		$arrRelacionados="";
		$consulta="SELECT * FROM 7006_carpetasAdministrativasRelacionadas WHERE carpetaAdministrativaBase='".$carpetaAdministrativa."'";
		if($iCarpeta!=-1)
		{
			$consulta.=" and idCarpeta=".$iCarpeta;
		}
		$consulta.=" and tipoRelacion=".$f[0]." ORDER BY carpetaAdministrativaBase";


		$rRelacion=$con->obtenerFilas($consulta);
		while($fRelacion=$con->fetchRow($rRelacion))
		{
			
			$consulta="SELECT carpetaAdministrativaBase,idPerfilAcceso FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$fRelacion[5];
			$fCarpetaRelacionada=$con->obtenerPrimeraFilaAsoc($consulta);
			$carpetaAdministrativaBase=$fCarpetaRelacionada["carpetaAdministrativaBase"];
			if($carpetaAdministrativaBase!="")
			{
				continue;
			}
			$listaCarpetasAsociadas.=",'".$fRelacion[4]."'";
			
			$arrHijosRelacionadas=obtenerCarpetasHijasCuadernillos($fRelacion[4],$fRelacion[5],0);
			
			$objRelacionado='{"cls":"expedienteDerivado","idPerfilAcceso":"'.$fCarpetaRelacionada["idPerfilAcceso"].'",expanded:true,"icon":"../images/s.gif","id":"'.$fRelacion[4].'_'.$fRelacion[5].'","iCarpeta":"'.$fRelacion[5].
							'","text":"'.$fRelacion[4].'",children:'.$arrHijosRelacionadas.',leaf:'.($arrHijosRelacionadas=="[]"?"true":"false").
							',tipoCarpeta:"11","tipoRelacion":"'.$f[0].'","sL":"0"}';
			if($arrRelacionados=="")
				$arrRelacionados=$objRelacionado;
			else
				$arrRelacionados.=",".$objRelacionado;
		}
		if($arrRelacionados!="")
		{
			$oPadre.=',{"cls":"expedienteAgrupador",expanded:true,disabled:false,"icon":"../images/s.gif","id":"['.cv($f[1]).']","text":"<b>'.cv($f[1]).'</b>",children:['.$arrRelacionados.'],leaf:false,tipoCarpeta:"10"}';
		}
		
		
		
	}
	
	echo '['.$oPadre.']'	;
		
}

function obtenerCarpetasHijasCuadernillos($carpetaAdministrativa,$idCarpeta,$sL)
{
	global $con;
	$arrRelacionados="";
	
	
	$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$carpetaAdministrativa.
				"' and idCarpetaAdministrativaBase=".$idCarpeta." order by carpetaAdministrativa";
	

	$rRelacion=$con->obtenerFilas($consulta);
	while($fRelacion=$con->fetchAssoc($rRelacion))
	{
		
		$arrHijosRelacionadas=obtenerCarpetasHijasCuadernillos($fRelacion["carpetaAdministrativa"],$fRelacion["idCarpeta"],$sL);
		
		$objRelacionado='{"cls":"expedienteDerivado","idPerfilAcceso":"'.$fRelacion["idPerfilAcceso"].'",expanded:true,"icon":"../images/s.gif","id":"'.$fRelacion["carpetaAdministrativa"].'_'.$fRelacion["idCarpeta"].
						'","iCarpeta":"'.$fRelacion["idCarpeta"].'","text":"'.$fRelacion["carpetaAdministrativa"].
						'",children:'.$arrHijosRelacionadas.',leaf:'.($arrHijosRelacionadas=="[]"?"true":"false").
						',tipoCarpeta:"11","tipoRelacion":"6","sL":"'.$sL.'"}';
		if($arrRelacionados=="")
			$arrRelacionados=$objRelacionado;
		else
			$arrRelacionados.=",".$objRelacionado;
	}
	
	return "[".$arrRelacionados."]";
	
}

function removerDocumentoCarpetaAdministrativa()
{
	global $con;
	
	$cA=$_POST["cA"];
	$idDocumento=$_POST["iD"];
	$iC=$_POST["iC"];
	$motivo=$_POST["motivo"];
	
	$consulta="UPDATE 7007_contenidosCarpetaAdministrativa SET tipoContenido=tipoContenido*-1,complementario1='".date("Y-m-d H:i:s").
			"',complementario2='".$_SESSION["idUsr"]."',complementario3='".cv($motivo)."' 
			WHERE carpetaAdministrativa='".$cA."' and idCarpetaAdministrativa=".$iC." AND tipoContenido=1 AND idRegistroContenidoReferencia=".$idDocumento;
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumento;
		$nombreOriginal=$con->obtenerValor($consulta);
		registrarMovimientoCarpetaAdministrativa($cA,$iC,"Se remueve documento \"".$nombreOriginal."\" en carpeta \"".$cA."\".<br><br><b>Motivo:</b> ".$motivo,5);
		echo "1|";
			
	}
}

function actualizarTipoDocumento()
{
	global $con;
	
	$tD=$_POST["tD"];
	$iD=$_POST["iD"];
	$consulta="UPDATE 908_archivos SET categoriaDocumentos=".$tD." WHERE idArchivo IN(".$iD.")";
	eC($consulta);
}

function obtenerRegistroProceso()
{
	global $con;
	
	$iFormulario=$_POST["iFormulario"];
	$iEvento=$_POST["iE"];
	$idEstadoIgn=-1;
	if(isset($_POST["idEstadoIgn"]))
		$idEstadoIgn=$_POST["idEstadoIgn"];
		
	$rol="69_0";
	
	$idRegistro=-1;
	$idProceso=obtenerIdProcesoFormulario($iFormulario);
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento;
	if($idEstadoIgn!=-1)
		$consulta.=" and idEstado not in(".$idEstadoIgn.")";
	

	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$etapa=1;
	$dComp="agregar";
	if($fRegistro)
	{

		$etapa=$fRegistro[1];
		$idRegistro=$fRegistro[0];
		$dComp="auto";
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);
		if($actor=="")
			$actor=0;
	}
	else
	{

		$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$rol,true);	
		$consulta="select idActorVSAccionesProceso from 949_actoresVSAccionesProceso where idProceso=".$idProceso.
					" and idAccion=8 and actor ='".$rol."' and idPerfil=".$idPerfil;
		
		$actor=$con->obtenerValor($consulta);
	}
	
	
	echo "1|".$idRegistro."|".bE($dComp)."|".bE($actor);
	
	
}

function obtenerRegistroModificacionAudiencia()
{
	global $con;
	
	$iFormulario=$_POST["iFormulario"];
	$iEvento=$_POST["iE"];
	
	$rol="69_0";
	
	$idRegistro=-1;
	$idProceso=obtenerIdProcesoFormulario($iFormulario);
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento." and idEstado in(1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	if(!$fRegistro)
	{
		$arrValores=array();
		$objDatosAudienciaOriginal="";
		$arrValores["objDatosAudienciaOriginal"]=$objDatosAudienciaOriginal;
		$arrValores["objDatosAudienciaCambio"]=$objDatosAudienciaOriginal;
		$arrDocumentosReferencia=array();
		crearInstanciaRegistroFormulario(324,-1,1,$arrValores,$arrDocumentosReferencia,-1,314);
	}
	
	
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE idEvento=".$iEvento." and idEstado in(1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	$etapa=$fRegistro[1];
	$idRegistro=$fRegistro[0];
	$dComp="auto";
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$etapa);
	if($actor=="")
		$actor=0;
	
	
	echo "1|".$idRegistro."|".bE($dComp)."|".bE($actor);
	
	
}

/*function generarReporteAudiencias()
{
	global $con;
	
	$arrUnidad="";
	$periodoInicial=$_POST["fechaInicio"];
	$periodoFinal=$_POST["fechaFin"];	
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='001'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=15 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"15","unidadGestion":"UGJ 1","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;		
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='002'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"16","unidadGestion":"UGJ 2","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='003'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"17","unidadGestion":"UGJ 3","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='004'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"25","unidadGestion":"UGJ 4","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//005
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa not like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa not like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=$con->fetchRow($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"32","unidadGestion":"UGJ 5","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	
	
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='006'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"33","unidadGestion":"UGJ 6","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='007'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"34","unidadGestion":"UGJ 7","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='008'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"35","unidadGestion":"UGJ 8","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='009'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$o1='{"idUnidadGestion":"36","unidadGestion":"UGJ 9","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa  like 'TE/%'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa  like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=$con->fetchRow($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$audienciasContinuacion=0;
	$listaAudienciasContinuacion="";
	
	$o1='{"idUnidadGestion":"032","unidadGestion":"Tribunal de enjuiciamiento","carpetasJudiciales":"'.$nCarpetas.'",
			"listaCarpetas":"'.$listaCarpetas.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$audienciasContinuacion.'","listaAudienciasContinuacion":"'.$listaAudienciasContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$audienciasContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	echo '{"numReg":"","registros":['.$arrUnidad.']}';
	
	
}
*/
function generarReporteAudiencias()
{
	global $con;
	
	$arrUnidad="";
	$periodoInicial=$_POST["fechaInicio"];
	$periodoFinal=$_POST["fechaFin"];	
	
	//UGA 1
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='001'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' 
				AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) AND idCentroGestion=15 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=15 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"15","unidadGestion":"UGJ 1","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;		
		
	//UGA 2
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;

	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='002'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) AND idCentroGestion=16 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 AND idCentroGestion=16 and tipoAudiencia<>25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=16 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=16 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"16","unidadGestion":"UGJ 2","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 3	
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='003'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=17 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=17 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"17","unidadGestion":"UGJ 3","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 4
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='004'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=25 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"25","unidadGestion":"UGJ 4","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 005
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa not like 'TE/%' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa not like 'TE/%' and carpetaAdministrativa  like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa not like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=$con->fetchRow($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=32 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")===false)
		{
			$nEventosContinuacion++;
			if($listaEventosContinuacion=="")
				$listaEventosContinuacion=$fila[0];
			else
				$listaEventosContinuacion.=",".$fila[0];
		}
		
		
	}
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	

	
	
	$o1='{"idUnidadGestion":"32","unidadGestion":"UGJ 5","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	//UGA 6
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa  like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='006'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=33 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=33 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"33","unidadGestion":"UGJ 6","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
	
	//UGA 7
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='007'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=34 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=34 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"34","unidadGestion":"UGJ 7","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
	
	//UGA 8
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa  like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='008'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=35 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=35 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	$o1='{"idUnidadGestion":"35","unidadGestion":"UGJ 8","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
	
	//UGA 9
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='009'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;	
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$listaEventos=$con->obtenerListaValores($consulta);
	
	$listaTotalAudiencias=$listaEventos;
	
	$nEventos=$con->filasAfectadas;	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nEventosPromociones++;
		if($listaEventosPromociones=="")
			$listaEventosPromociones=$fila[0];
		else
			$listaEventosPromociones.=",".$fila[0];
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=36 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		$nEventosVarios++;
		if($listaEventosVarios=="")
			$listaEventosVarios=$fila[0];
		else
			$listaEventosVarios.=",".$fila[0];
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=36 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$listaEventosContinuacion=$con->obtenerListaValores($consulta);
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}

	
	$nEventosContinuacion=$con->filasAfectadas;
	
	
	$o1='{"idUnidadGestion":"36","unidadGestion":"UGJ 9","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;	
		
	//Tribunal
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa  like 'TE/%' and carpetaAdministrativa not like '%-EX'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' 
			AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59'
			and carpetaAdministrativa  like 'TE/%' and carpetaAdministrativa like '%-EX'";
	$listaCarpetasEx=$con->obtenerListaValores($consulta,"'");
	$nCarpetasEx=$con->filasAfectadas;
	
	$consulta="SELECT id__96_tablaDinamica FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and p.carpetaAdministrativa  like 'TE/%'";
	$listaPromociones=$con->obtenerListaValores($consulta);
	$nPromociones=$con->filasAfectadas;		
	
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario IN(11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$listaEventos="";
	$nEventos=0;	
	
	
	$rEventos=$con->obtenerFilas($consulta);
	while($fEventos=$con->fetchRow($rEventos))
	{
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventos++;
			if($listaEventos=="")
				$listaEventos=$fEventos[0];
			else
				$listaEventos.=",".$fEventos[0];
		}
		
		
	}
	
	
	
	$listaTotalAudiencias=$listaEventos;
	
	
	
	$listaEventosPromociones="";
	$nEventosPromociones=0;
	
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario=185 and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosPromociones++;
			if($listaEventosPromociones=="")
				$listaEventosPromociones=$fila[0];
			else
				$listaEventosPromociones.=",".$fila[0];
		}
		
		
		
	}
	
	if($listaEventosPromociones!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosPromociones;
		else
			$listaTotalAudiencias.=",".$listaEventosPromociones;
	}
	
	
	$nEventosVarios=0;
	$listaEventosVarios="";
	$consulta="SELECT idRegistroEvento,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND idFormulario not in (11,46) and tipoAudiencia<>25 AND idCentroGestion=32 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[2];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosVarios++;
			if($listaEventosVarios=="")
				$listaEventosVarios=$fila[0];
			else
				$listaEventosVarios.=",".$fila[0];
		}
		
		
	}
		
	if($listaEventosVarios!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosVarios;
		else
			$listaTotalAudiencias.=",".$listaEventosVarios;
	}
	
	$nEventosContinuacion=0;
	$listaEventosContinuacion="";
	$consulta="SELECT idRegistroEvento,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND  idCentroGestion=32 and tipoAudiencia=25 and situacion in (1,2,4,5)";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario==96)
		{
			continue;
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fila[0];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
		{
			$nEventosContinuacion++;
			if($listaEventosContinuacion=="")
				$listaEventosContinuacion=$fila[0];
			else
				$listaEventosContinuacion.=",".$fila[0];
		}
		
		
	}
	
	if($listaEventosContinuacion!="")
	{
		if($listaTotalAudiencias=="")
			$listaTotalAudiencias=$listaEventosContinuacion;
		else
			$listaTotalAudiencias.=",".$listaEventosContinuacion;
	}
	
	$o1='{"idUnidadGestion":"032","unidadGestion":"Tribunal de enjuiciamiento","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasEx.'",
			"listaCarpetas":"'.$listaCarpetas.'","listaCarpetasEx":"'.$listaCarpetasEx.'","promociones":"'.$nPromociones.
			'","listaPromociones":"'.$listaPromociones.'",
			"audienciasSolicitudInicial":"'.$nEventos.'","listaAudienciasIniciales":"'.$listaEventos.'",
			"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"'.$listaEventosPromociones.'",
			"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"'.$listaEventosVarios.'",
			"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"'.$listaEventosContinuacion.'",
			"totalAudiencias":"'.($nEventos+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).
			'","listaTotalAudiencias":"'.$listaTotalAudiencias.'"}';
			
	if($arrUnidad=="")
		$arrUnidad=$o1;
	else
		$arrUnidad.=",".$o1;
		
	echo '{"numReg":"","registros":['.$arrUnidad.']}';
	
	
}



function obtenerEventosAudienciaSGJPReporte()
{
	global $con;
	
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "situacion":
					$c=" and situacion in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$c=" and idSala=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "tipoAudiencia":
					$c=" and tipoAudiencia=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
			}
		}
		
	}
	
	$listaAudiencias=$_POST["listaAudiencias"];
	
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia  
			FROM 7000_eventosAudiencia where idRegistroEvento in (".$listaAudiencias.")
			".$condiciones;
			
			
	

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT(u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta="";
		$tipoAudiencia="";
		$tAudiencia="";
		switch($fila[9])
		{
			case 11:
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue 2;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
			case 46:
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia,idActividad FROM _46_tablaDinamica WHERE id__46_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				if(!$fDatos)
					continue 2;
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
				if($tipoAudiencia=="")
					$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				$idActividad=$fDatos[2];
				
			break;
			case 185:
				$idActividad=-1;
				$consulta="SELECT carpetaAdministrativa,tipoAudiencia FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fila[8];
					if($tipoAudiencia=="")
					$tipoAudiencia=$fDatos[1];
				if($tipoAudiencia=="")
					$tipoAudiencia=-1;
				
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
				
			break;
			case 6:
				continue 2;
			break;
			case 5:
			case 7:
				$consulta="SELECT carpetaAdministrativa,idTipoAudiencia FROM otrasSolicitudes WHERE tipo=".$fila[9]." and idSolicitud=".$fila[10];
				$fDatos=$con->obtenerPrimeraFila($consulta);
				$carpeta=$fDatos[0];
				$tipoAudiencia=$fDatos[1];
				$consulta="SELECT idActividad FROM _46_tablaDinamica WHERE carpetaAdministrativa='".$carpeta."'";
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
			break;
		}
		
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idFiguraJuridica=4";
		$tImputados=$con->obtenerValor($consulta);
		
		$o='{"idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
}

function obtenerCarpetasAdministrativasReporte()
{
	global $con;
	$listaCarpetas=$_POST["listaCarpetas"];

	
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				
			}
		}
		
	}
	
	
	$arrRegistro="";
	$numReg=0;
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,fechaCreacion FROM 7006_carpetasAdministrativas 
				WHERE carpetaAdministrativa in(".$listaCarpetas.") ORDER BY carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","fechaCreacion":"'.$fila[3].'"}';
		if($arrRegistro=="")
			$arrRegistro=$o;
		else
			$arrRegistro.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
}

function obtenerResolutivosAudiencia()
{
	global $con;
	$idEventoAudiencia=$_POST["iE"];
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT distinct id__327_tablaDinamica,descripcionResolutivo,tipoResultado,prioridad FROM _327_tablaDinamica r
			WHERE id__327_tablaDinamica IN(SELECT tipoResolutivo FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEventoAudiencia.")
			ORDER BY prioridad,descripcionResolutivo";
	

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT idRegistro,valor,comentariosAdicionales FROM 3013_registroResolutivosAudiencia WHERE tipoResolutivo=".
				$fila[0]." AND idEvento=".$idEventoAudiencia;
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT cveOpcion,comentariosAdicinales FROM 3013_opcionesResolutivosAudiencia WHERE idResolutivo=".$fRegistro[0];
		$listaOpciones=$con->obtenerFilasArreglo($consulta);
		$rOpciones=$con->obtenerFilas($consulta);
		$consulta="SELECT cveElemento,descripcion FROM _327_gOpcionesSeleccion WHERE idReferencia=".$fila[0]." ORDER BY descripcion";
		$arrOpciones=$con->obtenerFilasArreglo($consulta);
		
		$titulo="";
		$tblOpciones="";
		switch($fila[2])
		{
			case 8:
				while($filaOpcion=$con->fetchRow($rOpciones))
				{
					$titulo="Imputado";
					$tblOpciones.="<tr height='21'><td>".cv(obtenerNombreImplicado($filaOpcion[0]))."</td><td>".cv($filaOpcion[1])."</td></tr>";	
				}
			break;
			case 9:
			case 10:
				while($filaOpcion=$con->fetchRow($rOpciones))
				{
					$titulo="Opcion";
					$consulta="SELECT descripcion FROM _327_gOpcionesSeleccion WHERE idReferencia=".$fila[0].
								" AND cveElemento=".$filaOpcion[0];
					$lblOpcion=$con->obtenerValor($consulta);
					$tblOpciones.="<tr height='21'><td>".cv($lblOpcion)."</td><td>".cv($filaOpcion[1])."</td></tr>";	
				}
			break;
		}
		
		if($tblOpciones!="")
		{
			$tblOpciones="<table><tr height='21'><td align='left' width='300'><b>".$titulo."</b></td><td width='450' align='left'><b>Comentarios adicionales</b></td></tr>".$tblOpciones."</table>";

		}
		
		$o='{"aplicado":true,"idResolutivo":"'.$fila[0].'","resolutivo":"'.cv($fila[1]).'","tipoValor":"'.
			$fila[2].'","prioridad":"'.$fila[3].'","valor":"'.cv($fRegistro[1]).'","comentariosAdicionales":"'.
			cv($fRegistro[2]).'","opciones":'.$arrOpciones.',"opcionesSeleccionadas":'.$listaOpciones.',"tblOpciones":"'.$tblOpciones.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
		
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}


function guardarInformeAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="delete from 3013_registroResolutivosAudiencia where idEvento=".$obj->idEvento;
	$x++;
	foreach($obj->registros as $r)
	{
		$fechaReferencia="NULL";
		
		if($r->idResolutivo==71)
		{
			$oFecha=json_decode($r->valor);
			$fechaReferencia="'".$oFecha->fechaFinal."'";
			
		}
		$query[$x]="INSERT INTO 3013_registroResolutivosAudiencia(tipoResolutivo,valor,idEvento,comentariosAdicionales,fechaReferencia)  
					VALUES(".$r->idResolutivo.",'".cv($r->valor)."','".$obj->idEvento."','".cv($r->comentariosAdicionales)."',".$fechaReferencia.")";
		$x++;
	}
	
	if(isset($obj->arrPenas))
	{
		foreach($obj->arrPenas as $p)
		{
			$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET seAcogeSustitutivo=".($p->seAcoge==""?"NULL":$p->seAcoge).
					",idSustitutivoAcoge=".($p->sustitutivoAcoge==""?"NULL":$p->sustitutivoAcoge).",
					fechaInicio=".($p->fechaInicio==""?"NULL":"'".$p->fechaInicio."'").
				",fechaTermino=".($p->fechaCompurga==""?"NULL":"'".$p->fechaCompurga."'").
				",seAcogeSuspensionCondicional=".($p->seAcogeSuspensionCondicional==""?"NULL":$p->seAcogeSuspensionCondicional).
				",comentariosAdicionales='".cv($p->comentariosAdicionales)."' WHERE idRegistro=".$p->idPena;
			$x++;
		}
	}
	$query[$x]="commit";
	$x++;
	
	
	if($con->ejecutarBloque($query))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		echo "1|";
	}
	
	
}

function finalizarInformeEventoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT COUNT(*) FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEvento;
	$nResolutivos=$con->obtenerValor($consulta);	
	
	$consulta="SELECT COUNT(*) FROM 3014_registroMedidasCautelares WHERE idEventoAudiencia=".$idEvento;
	$nMedidas=$con->obtenerValor($consulta);	
	
	if(($nResolutivos+$nMedidas)==0)
	{
		echo "<br>Almenos debe registrar alg&uacute;n resolutivo / medida cautelar";
		return;
	}
	
	$consulta="UPDATE 3014_registroResutadoAudiencia SET situacion=1,fechaRegistro='".date("Y-m-d H:i:s")."',responsable=".$_SESSION["idUsr"]." WHERE idEvento=".$idEvento;
	if($con->ejecutarConsulta($consulta))
	{
		@notificarSeguimientoAcuerdoReparatorio($idEvento);
	}
	echo "1|";
}

function registrarMedidaCautelar()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	$valorComp1="";
	$valorComp2="";
	$valorComp3="";
	switch($obj->datosMedida->idMedida)
	{
		case 1:
			$valorComp1=$obj->datosMedida->autoridad;
		break;	
		case 2:
			$valorComp1=$obj->datosMedida->montoGarantia;	
			$valorComp2=$obj->datosMedida->noPagos;	
		break;	
		default:
		break;
	}
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasCautelares(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,valorComp1,valorComp2,valorComp3,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"','".cv($valorComp1)."','".cv($valorComp2)."','".cv($valorComp3)."',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasCautelares set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."',valorComp1='".cv($valorComp1)."',
				valorComp2='".cv($valorComp2)."',valorComp3='".cv($valorComp3)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}

function obtenerMedidasCautelaresActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales,
				valorComp1,valorComp2,valorComp3,
				(SELECT COUNT(*) FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=4 AND idRegistroReferencia=r.idRegistro) as 
				historialSituacionMedida,situacion as situacionActual,idEventoAudiencia FROM 3014_registroMedidasCautelares r 
				WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}

function removerMedidaCautelar()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasCautelares WHERE idRegistro=".$idMedida;
	eC($consulta);
}

function actualizarTipoAudienciaEvento()
{
	global $con;
	
	$idEvento=$_POST["iE"];
	$tipoAudiencia=$_POST["tA"];
	
	$consulta="SELECT idFormulario,idRegistroSolicitud,situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if($fRegistro[1]=="")
		$fRegistro[1]=-1;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE 7000_eventosAudiencia SET tipoAudiencia=".$tipoAudiencia." WHERE idRegistroEvento=".$idEvento;
	$x++;
	switch($fRegistro[0])
	{
		case 46:
			$query[$x]="UPDATE _46_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__46_tablaDinamica=".$fRegistro[1];
			$x++;
		break;
		case 185:
			$query[$x]="UPDATE _185_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__185_tablaDinamica=".$fRegistro[1];
			$x++;
			
			$consulta="SELECT iFormulario,iRegistro FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fRegistro[1];
			$fPromocion=$con->obtenerPrimeraFila($consulta);
			if($fPromocion[1]=="")
				$fPromocion[1]=-1;
			
			if($fPromocion[0]==96)
			{
				$query[$x]="UPDATE _96_tablaDinamica SET tipoAudiencia=".$tipoAudiencia." WHERE id__96_tablaDinamica=".$fPromocion[1];
				$x++;
				
			}
			
			
		break;
	}
	
	
	$query[$x]="commit";
	$x++;	
	if($con->ejecutarBloque($query))
	{
		switch($fRegistro[2])
		{
			case 1:
			case 2:
			case 4:
			case 5:
				@enviarNotificacionMAJO($idEvento);
			break;
		}
		echo "1|";
	}
}

function obtenerRegistroRemisionUGA()
{
	global $con;
	$iFormulario=329;
	$cA=$_POST["cA"];
	if(isset($_POST["iFormulario"]))
	{
		$iFormulario=$_POST["iFormulario"];
	}
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE carpetaAdministrativa='".$cA."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(295);
		if($iFormulario==382)
		{
			$act=bE(325);
		}
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario($iFormulario);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function guardarModificacionHoraDesarrolloAudiencia()
{
	global $con;
	$idEvento=$_POST["iE"];
	$hInicio=$_POST["hInicio"];
	$hFin=$_POST["hFin"];
	
	
	$consulta="SELECT horaInicioReal,horaTerminoReal,respHorarioReal FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fDatosAudiencia=$con->obtenerPrimeraFila($consulta);
	
	
	if($fDatosAudiencia[0]=="")
	{
		$consulta="UPDATE 7000_eventosAudiencia SET situacion=2,horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"]." WHERE idRegistroEvento=".$idEvento;
	}
	else
	{
		if($fDatosAudiencia[2]=="0")
		{
			$consulta="UPDATE 7000_eventosAudiencia SET situacion=2,horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"].",horaInicioRealMAJO=horaInicioReal,horaTerminoRealMAJO=horaTerminoReal 
					WHERE idRegistroEvento=".$idEvento;
		}
		else
		{
			$consulta="UPDATE 7000_eventosAudiencia SET situacion=2,horaInicioReal='".$hInicio."',horaTerminoReal='".$hFin.
					"',respHorarioReal=".$_SESSION["idUsr"]." WHERE idRegistroEvento=".$idEvento;
		}
	}
	
	
	if($con->ejecutarConsulta($consulta))
	{
		if($con->existeTabla("7001_recursosAdicionalesAudiencia"))
		{
			if(registrarTerminacionRecursosEventos($idEvento,$hInicio,$hFin))
				echo "1|";
		}
		else
		{
			echo "1|";
		}
	}
	
	
	
}

function obtenerRegistroTribunalEnjuiciamiento()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	
	$rolesDEGJ["90_0"]=1;
	$rolesDEGJ["159_0"]=1;
	
	$idProceso=obtenerIdProcesoFormulario(320);
	$rol="69_0";
	
	foreach($rolesDEGJ as $r=>$resto)
	{
		if(existeRol("'".$r."'"))
		{
			$rol="90_0";
			break;
		}
	}
			
	$consulta="SELECT id__320_tablaDinamica,idEstado FROM _320_tablaDinamica WHERE carpetaAdministrativa='".$cA."' and idEstado in (1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");

		
	}
	
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro?$fRegistro[1]:0);
	$act=bE($actor);
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerRegistroEjecucion()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__316_tablaDinamica,idEstado FROM _316_tablaDinamica WHERE carpetaAdministrativa='".$cA."' and idEstado<>3";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(297);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(316);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerMedidasProteccionActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales,
				(SELECT COUNT(*) FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=5 AND idRegistroReferencia=r.idRegistro) as 
				historialSituacionMedidaProteccion,situacion as situacionActual,idEventoAudiencia
				 FROM 3014_registroMedidasProteccion r WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}


function obtenerMedidasSuspensionCondicionalActividad()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro AS idRegistroMedida,idEventoAudiencia,idImputado,tipoMedida as idMedida,comentariosAdicionales,
			(SELECT COUNT(*) FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=6 AND idRegistroReferencia=r.idRegistro) as 
				historialSituacionSuspencion,situacion as situacionActual,idEventoAudiencia
				 FROM 3014_registroMedidasSuspencionCondicional r WHERE idActividad in(".$idActividad.")";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
}

function registrarMedidaProteccion()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasProteccion(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasProteccion set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}

function registrarMedidaSuspension()
{
	global $con;
	$obj=json_decode($_POST["cadObj"]);
	
	
	
	if($obj->datosMedida->idRegistroMedida==-1)
	{
		$consulta="INSERT INTO 3014_registroMedidasSuspencionCondicional(idEventoAudiencia,idImputado,tipoMedida,comentariosAdicionales,situacion,idActividad)
					values(".$obj->idEvento.",".$obj->idImputado.",".$obj->datosMedida->idMedida.",'".cv($obj->datosMedida->comentariosAdicionales).
					"',1,".$obj->idActividad.")";
	}
	else
	{
		$consulta="update 3014_registroMedidasSuspencionCondicional set idImputado=".$obj->idImputado.",tipoMedida=".$obj->datosMedida->idMedida.
				",comentariosAdicionales='".cv($obj->datosMedida->comentariosAdicionales)."' where idRegistro=".$obj->datosMedida->idRegistroMedida;
	}
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|";
	}
	
	
}


function removerMedidaProteccion()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasProteccion WHERE idRegistro=".$idMedida;
	eC($consulta);
}


function removerCondicionSuspension()
{
	global $con;
	$idMedida=$_POST["idMedida"];
	$consulta="DELETE FROM 3014_registroMedidasSuspencionCondicional WHERE idRegistro=".$idMedida;
	eC($consulta);
}


function obtenerResultadoBusquedaCarpetaJudicial()
{
	global $con;
	$consulta="";
	$unidadGestionBusqueda=$_POST["unidadGestion"];
	$tipoCriterio=$_POST["tipoCriterio"];
	$valor=$_POST["valor"];
	$porcentaje=$_POST["porcentaje"];
	
	$arrValoresBusqueda=explode(" ",trim($valor));
	for($x=0;$x<sizeof($arrValoresBusqueda);$x++)
	{
		$arrValoresBusqueda[$x]=normalizaToken($arrValoresBusqueda[$x]);
	}
	$resultado=buscarCoincidenciasCriterio($tipoCriterio,$valor,60);
	$res=$resultado[0];
	$arrRegistros="";
	$numReg=0;
	
	while($fila=$con->fetchRow($res))
	{
		$datosImputado="<table>";
		$consulta="SELECT nombre,apellidoPaterno,apellidoMaterno,t.nombreTipo FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica t WHERE 
				r.idParticipante=p.id__47_tablaDinamica AND r.idActividad=".$fila[16]." AND t.id__5_tablaDinamica=r.idFiguraJuridica 
				ORDER BY t.nombreTipo,nombre,apellidoPaterno,apellidoMaterno";
		
		$resImputados=$con->obtenerFilas($consulta);
		while($fImputados=$con->fetchRow($resImputados))
		{
			$nombreImputado=$fImputados[0].' '.$fImputados[1].' '.$fImputados[2];
			$nombreImputado=formatearNombreBusqueda($nombreImputado,$arrValoresBusqueda);
			$datosImputado.='<tr><td>'.cv($nombreImputado).' ('.$fImputados[3].')</td></tr>';
		}
				
		$datosImputado.="</table>";
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila[15]."'";
		$unidadGestion=$con->obtenerValor($consulta);
		
		if($unidadGestionBusqueda!="")
		{
			if($unidadGestion!=$unidadGestionBusqueda)
			{
				continue;
			}
		}
		
		$o='{"iRegistro":"'.$fila[0].'","iFormulario":"46","carpetaInvestigacion":"'.$fila[10].'","fechaRecepcion":"'.$fila[2].'","carpetaJudicial":"'.$fila[15].
			'","unidadGestion":"'.$unidadGestion.'","datosImputado":"'.$datosImputado.'","idEstado":"'.$fila[6].
			'","porcentaje":"'.(isset($resultado[1][$fila[16]])?$resultado[1][$fila[16]]:0).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function obtenerURLVideoMAJO()
{
	global $con;
	$consulta="SELECT URLVideo,AudienciaId FROM 7000_audienciasMAJO WHERE duracionVideo IS NULL LIMIT 0,1";
	$fDatos=$con->obtenerPrimeraFila($consulta);
	$url=$fDatos[0];
	
	echo "1|".$url."|".$fDatos[1];
	
}

function actualizarDuracionMAJO()
{
	global $con;
	$duracion=$_POST["duracion"];
	$idEvento=$_POST["idEvento"];
	
	$consulta="update 7000_audienciasMAJO set duracionVideo=".$duracion." where AudienciaId=".$idEvento;
	eC($consulta);
}

function enviarEventoMAJO()
{
	global $con;

	$iE=$_POST["iE"];
	enviarNotificacionMAJO($iE);
	echo "1|";
}

function obtenerProcoloAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$tipoAudiencia=$con->obtenerValor($consulta);
	$consulta="SELECT perfilProtocolo FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tipoAudiencia;
	$perfilProtocolo=$con->obtenerValor($consulta);
	
	$consulta="SELECT  cA.idActividad FROM 7007_contenidosCarpetaAdministrativa c,7006_carpetasAdministrativas cA 
			WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento." AND cA.carpetaAdministrativa=c.carpetaAdministrativa";
	$idActividad=$con->obtenerValor($consulta);
	if($idActividad=="")
		$idActividad=-1;


	$consulta="SELECT situacion FROM 3016_registroStatusProtocoloAudiencia WHERE idEvento=".$idEvento;
	$situacionInforme=$con->obtenerValor($consulta);
	if($situacionInforme=="")
		$situacionInforme=0;

	$numReg=0;
	$arrRegistros="";
	if($situacionInforme==0)
	{
		$consulta="SELECT g.protocolo,p.nombreProtocolo,figuraJuridica,prioridad FROM _352_gridProtocoloFiguras g,_348_tablaDinamica p WHERE 
					g.idReferencia=".$perfilProtocolo." and p.id__348_tablaDinamica=g.protocolo ORDER BY prioridad";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$fila[2];
			$lblFigura=$con->obtenerValor($consulta);
			
			$lblResponsable=$fila[3].".-".$lblFigura;
			$llave=$fila[0]."_".$fila[2];
			
			$consulta="SELECT p.id__47_tablaDinamica,CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) AS nombre FROM
					7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad." and r.idFiguraJuridica=".$fila[2]." and 
					p.id__47_tablaDinamica=r.idParticipante";
			$rParticipantes=$con->obtenerFilas($consulta);
			
			if($con->filasAfectadas==0)
			{
				
				$llaveAux=$llave."_-1";
				$consulta="SELECT * FROM 3015_registroProtocoloAudiencia WHERE idEvento=".$idEvento." AND llave='".$llaveAux."'";
				$fRegistro=$con->obtenerPrimeraFila($consulta);
				$horaRealizacion="";
				$segundosRealizacion="";
				if($fRegistro[3]!="")
				{
					$horaRealizacion=date("H:i",strtotime($fRegistro[3]));
					$segundosRealizacion=date("s",strtotime($fRegistro[3]));
					
				}
				$o='{"llave":"'.$llaveAux.'","protocolo":"'.cv($fila[0]).'","responsable":"'.cv($lblResponsable).'",
					"realizado":'.($fRegistro?"true":"false").',"horaRealizacion":"'.$horaRealizacion.'","segundosRealizacion":"'.$segundosRealizacion.'","comentariosAdicionales":"'.cv($fRegistro[4]).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
			else
			{
				while($fParticipante=$con->fetchRow($rParticipantes))
				{
					$llaveAux=$llave."_".$fParticipante[0];
					
					
					$consulta="SELECT * FROM 3015_registroProtocoloAudiencia WHERE idEvento=".$idEvento." AND llave='".$llaveAux."'";
					$fRegistro=$con->obtenerPrimeraFila($consulta);
					
					
					$horaRealizacion="";
					$segundosRealizacion="";
					if($fRegistro[3]!="")
					{
						$horaRealizacion=date("H:i",strtotime($fRegistro[3]));
						$segundosRealizacion=date("s",strtotime($fRegistro[3]));
						
					}
					
					
					$lblResponsableAux=$lblResponsable." (".$fParticipante[1].")";
					$o='{"llave":"'.$llaveAux.'","protocolo":"'.cv($fila[1]).'","responsable":"'.cv($lblResponsable).
					'","realizado":'.($fRegistro?"true":"false").',"horaRealizacion":"'.$horaRealizacion.'","segundosRealizacion":"'.$segundosRealizacion.'","comentariosAdicionales":"'.cv($fRegistro[4]).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numReg++;
				}
			}
		}
	}
	else
	{
		$nPaso=1;
		$consulta="SELECT * FROM 3015_registroProtocoloAudiencia WHERE idEvento=".$idEvento." ORDER BY idRegistro";
		$res=$con->obtenerFilas($consulta);	
		while($fila=$con->fetchRow($res))
		{
			$arrDatosLlave=explode("_",$fila[5]);
			$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$arrDatosLlave[1];
			$lblFigura=$con->obtenerValor($consulta);
			
			$lblResponsable=$nPaso.".-".$lblFigura;
			$llave=$fila[5];
			
			$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) AS nombre FROM
					_47_tablaDinamica p WHERE 
					p.id__47_tablaDinamica=".$arrDatosLlave[2];
			$lblParticipante=$con->obtenerValor($consulta);
			if($lblParticipante!="")
			{
				$lblResponsable=$lblResponsable." (".$lblParticipante.")";
			}
			$llaveAux=$llave;
			$consulta="SELECT * FROM 3015_registroProtocoloAudiencia WHERE idEvento=".$idEvento." AND llave='".$llaveAux."'";
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			
			
			$horaRealizacion="";
			$segundosRealizacion="";
			if($fRegistro[3]!="")
			{
				$horaRealizacion=date("H:i",strtotime($fRegistro[3]));
				$segundosRealizacion=date("s",strtotime($fRegistro[3]));
				
			}
			
			$o='{"llave":"'.$llaveAux.'","protocolo":"'.cv($fila[0]).'","responsable":"'.cv($lblResponsable).'",
				"realizado":'.($fRegistro?"true":"false").',"horaRealizacion":"'.$horaRealizacion.'","segundosRealizacion":"'.$segundosRealizacion.'","comentariosAdicionales":"'.cv($fRegistro[4]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
	}
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarProtocoloAudiencia()
{
	global $con;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	$consulta[$x]="DELETE FROM 3015_registroProtocoloAudiencia WHERE idEvento=".$obj->idEvento;
	$x++;
	$consulta[$x]="DELETE FROM 3016_registroStatusProtocoloAudiencia WHERE idEvento=".$obj->idEvento;
	$x++;
	
	foreach($obj->registros as $r)
	{
		$horaRealizacion=$r->horaRealizacion==""?"NULL":"'".$r->horaRealizacion."'";
		$consulta[$x]="INSERT INTO 3015_registroProtocoloAudiencia(llave,idEvento,idProtocolo,horaRealizacion,comentariosAdicionales) 
						VALUES('".$r->llave."',".$obj->idEvento.",".$r->protocolo.",".$horaRealizacion.",'".cv($r->comentariosAdicionales)."')";
		$x++;
	}
	
	$consulta[$x]="INSERT INTO 3016_registroStatusProtocoloAudiencia(fechaRegistro,responsable,situacion,idEvento)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
	$x++;
	$consulta[$x]="commit";
	$x++;
	
	eB($consulta);
}

function finalizarRegistroProtocoloAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="UPDATE 3016_registroStatusProtocoloAudiencia SET situacion=1,fechaCierre='".date("Y-m-d H:i:s").
				"',responsableCierre=".$_SESSION["idUsr"]." WHERE idEvento=".$idEvento;
	eC($consulta);
	
}

function obtenerRegistroFichaIdentificacion()
{
	global $con;
	$iU=$_POST["iU"];
	$iE=$_POST["iE"];
	
	$consulta="SELECT id__225_tablaDinamica FROM _225_tablaDinamica WHERE idUsuario=".$iU." AND idEvento=".$iE;
	$idRegistro=$con->obtenerValor($consulta);
	$dComp="";
	$actor="";
	if($idRegistro=="")
	{
		$idRegistro=-1;
		$dComp=bE("agregar");
		$actor=bE("116");
	}
	else
	{
		$dComp=bE("auto");
		$actor=bE("509");
	}
	
	echo "1|".$idRegistro."|".$dComp."|".$actor;
	
	
	
}

function obtenerDatosFichaIdentificacion()
{
	global $con;
	$iE=$_POST["iE"];
	$iU=$_POST["iU"];
	
	$cadObj="";
	$consulta="SELECT * FROM _225_tablaDinamica WHERE idUsuario=".$iU." and idEvento<>".$iE." order by fechaCreacion desc";
	$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
	if($fDatosEvento)
	{		
		$arrTelefonos="";
		$consulta="SELECT tipoTelefono,lada,telefono,extension FROM _225_gridTelefonos WHERE idReferencia=".$fDatosEvento["id__225_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$o='{"tipoTelefono":"'.$fila[0].'","lada":"'.$fila[1].'","telefono":"'.$fila[2].'","extension":"'.$fila[3].'"}';
			if($arrTelefonos=="")
				$arrTelefonos=$o;
			else
				$arrTelefonos.=",".$o;
			
		}
		
		$arrMail="";
		$consulta="SELECT email FROM _225_correoElectronico WHERE idReferencia=".$fDatosEvento["id__225_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$o='{"email":"'.$fila[0].'"}';
			if($arrMail=="")
				$arrMail=$o;
			else
				$arrMail.=",".$o;
			
		}
		
		$arrRedes="";
		$consulta="SELECT redSocial,idRedSocial FROM _225_redesSociales WHERE idReferencia=".$fDatosEvento["id__225_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$o='{"redSocial":"'.$fila[0].'","idRedSocial":"'.$fila[1].'"}';
			if($arrRedes=="")
				$arrRedes=$o;
			else
				$arrRedes.=",".$o;
			
		}		
		
		
		$cadObj='{"tipoParticipante":"'.$fDatosEvento["figuraJuridica"].'","tipoPersona":"'.$fDatosEvento["tipoPersona"].'","nombre":"'.cv($fDatosEvento["nombre"]).
				'","apPaterno":"'.cv($fDatosEvento["apPaterno"]).'","apMaterno":"'.cv($fDatosEvento["apMaterno"]).'","nacionalidadMexicana":"'.$fDatosEvento["esMexicano"].
				'","especifiqueNacionalidad":"'.cv($fDatosEvento["otraNacionalidad"]).'",
				"rfc":"'.$fDatosEvento["rfc"].'","curp":"'.$fDatosEvento["curp"].'","genero":"'.$fDatosEvento["genero"].
				'","fechaNacimiento":"'.$fDatosEvento["fechaNacimiento"].'","edad":"'.$fDatosEvento["edad"].'","nacionalidad":"'.$fDatosEvento["nacionalidad"].'",
				"domicilioPersonal":{"calle":"'.cv($fDatosEvento["calle"]).
				'","noExt":"'.cv($fDatosEvento["noExt"]).'","noInt":"'.cv($fDatosEvento["noInt"]).'","colonia":"'.cv($fDatosEvento["colonia"]).'","cp":"'.$fDatosEvento["cp"].
				'","estado":"'.$fDatosEvento["estado"].'","municipio":"'.$fDatosEvento["municipio"].'","localidad":"'.cv($fDatosEvento["localidad"]).
				'","entreCalle":"'.cv($fDatosEvento["entreCalle"]).'","yCalle":"'.cv($fDatosEvento["yCalle"]).'","otrasReferencias":"'.cv($fDatosEvento["otrasReferencias"]).'"},
				"mismoDomicilioNotificaciones":"'.$fDatosEvento["siNo"].'",
				"domicilioNotificaciones":{"calle":"'.cv($fDatosEvento["calleNotificacion"]).'","noExt":"'.cv($fDatosEvento["noExtNotificacion"]).
				'","noInt":"'.cv($fDatosEvento["noIntNotificacion"]).'","colonia":"'.cv($fDatosEvento["coloniaNotificacion"]).'","cp":"'.$fDatosEvento["cpNotificacion"].
				'","estado":"'.$fDatosEvento["estadoNotificacion"].'","municipio":"'.$fDatosEvento["municipioNotificacion"].'","localidad":"'.
				cv($fDatosEvento["localidadNotificacion"]).'","entreCalle":"'.cv($fDatosEvento["entreCalleNotificacion"]).'","yCalle":"'.cv($fDatosEvento["yCalleNotificacion"]).
				'","otrasReferencias":"'.cv($fDatosEvento["otrasReferenciasNotificacion"]).'"},
				"telefonos":['.$arrTelefonos.'],"mail":['.$arrMail.'],"redesSociales":['.$arrRedes.']}';
	}
	else
	{
		$consulta="SELECT * FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$iU;

		$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="select * from _48_tablaDinamica WHERE idReferencia=".$fDatosEvento["id__47_tablaDinamica"];		
		$fDireccion=$con->obtenerPrimeraFilaAsoc($consulta);		
		
		$arrRedes="";
		$arrMail="";
		$arrTelefonos="";
		if($fDireccion)
		{
			$consulta="SELECT correo FROM _48_correosElectronico WHERE idReferencia=".$fDireccion["id__48_tablaDinamica"];
			
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$o='{"email":"'.$fila[0].'"}';
				if($arrMail=="")
					$arrMail=$o;
				else
					$arrMail.=",".$o;
				
			}
			
			
			$consulta="SELECT redSocial,idRedSocial FROM _48_gridRedSocial WHERE idReferencia=".$fDireccion["id__48_tablaDinamica"];
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$o='{"redSocial":"'.$fila[0].'","idRedSocial":"'.$fila[1].'"}';
				if($arrRedes=="")
					$arrRedes=$o;
				else
					$arrRedes.=",".$o;
				
			}	
			
			
			$consulta="SELECT tipoTelefono,lada,numero,extension FROM _48_telefonos WHERE idReferencia=".$fDireccion["id__48_tablaDinamica"];
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$o='{"tipoTelefono":"'.$fila[0].'","lada":"'.$fila[1].'","telefono":"'.$fila[2].'","extension":"'.$fila[3].'"}';
				if($arrTelefonos=="")
					$arrTelefonos=$o;
				else
					$arrTelefonos.=",".$o;
				
			}
		}
		
		$cadObj='{"tipoParticipante":"'.$fDatosEvento["figuraJuridica"].'","tipoPersona":"'.$fDatosEvento["tipoPersona"].'","nombre":"'.cv($fDatosEvento["nombre"]).
				'","apPaterno":"'.cv($fDatosEvento["apellidoPaterno"]).'","apMaterno":"'.cv($fDatosEvento["apellidoMaterno"]).'","nacionalidadMexicana":"'.
				$fDatosEvento["esMexicano"].'","especifiqueNacionalidad":"'.cv($fDatosEvento["otraNacionalidad"]).'",
				"rfc":"'.$fDatosEvento["rfcEmpresa"].'","curp":"'.$fDatosEvento["curp"].'","genero":"'.$fDatosEvento["genero"].
				'","fechaNacimiento":"'.$fDatosEvento["fechaNacimiento"].'","edad":"'.$fDatosEvento["edad"].'","nacionalidad":"'.$fDatosEvento["nacionalidad"].'",
				"domicilioPersonal":{"calle":"'.cv($fDireccion["calle"]).
				'","noExt":"'.cv($fDireccion["noExt"]).'","noInt":"'.cv($fDireccion["noInterior"]).'","colonia":"'.cv($fDireccion["colonia"]).
				'","cp":"'.$fDireccion["codigoPostal"].'","estado":"'.$fDireccion["entidadFederativa"].'","municipio":"'.$fDireccion["municipio"].
				'","localidad":"'.cv($fDireccion["localidad"]).'","entreCalle":"'.cv($fDireccion["entreCalle"]).'","yCalle":"'.cv($fDireccion["yCalle"]).
				'","otrasReferencias":"'.cv($fDireccion["otrasReferencias"]).'"},
				"mismoDomicilioNotificaciones":"1",
				"domicilioNotificaciones":{"calle":"'.cv($fDireccion["calle"]).'","noExt":"'.cv($fDireccion["noExt"]).'","noInt":"'.cv($fDireccion["noInterior"]).
				'","colonia":"'.cv($fDireccion["colonia"]).'","cp":"'.$fDireccion["codigoPostal"].'","estado":"'.$fDireccion["entidadFederativa"].'",
				"municipio":"'.$fDireccion["municipio"].'","localidad":"'.cv($fDireccion["localidad"]).'","entreCalle":"'.cv($fDireccion["entreCalle"]).'","yCalle":"'.cv($fDireccion["yCalle"]).
				'","otrasReferencias":"'.cv($fDireccion["otrasReferencias"]).'"},"telefonos":['.$arrTelefonos.'],"mail":['.$arrMail.'],"redesSociales":['.$arrRedes.']}';

		
	}
	
	echo "1|".$cadObj;
	
}

function obtenerMunicipiosEstado()
{
	global $con;
	$cveEstado=$_POST["cveEstado"];
	$consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cveEstado."' order by municipio";
	$arrMunicipios=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrMunicipios;
	
}

function obtenerJuecesJuicioAmparo()
{
	global $con;
	$uG=$_POST["uG"];
	$cJ=$_POST["cJ"];
	$idRegistro=$_POST["iR"];
	
	$consulta="";
	if($cJ=="")
	{
		$consulta="SELECT usuarioJuez FROM _26_tablaDinamica ju,_17_tablaDinamica ug WHERE ug.claveUnidad='".$uG."' 
					AND ju.idReferencia=ug.id__17_tablaDinamica";
	}
	else
	{
		$listaCarpetas=obtenerCarpetasVinculadas($cJ);
			
		$consulta="SELECT distinct e.idJuez FROM 7007_contenidosCarpetaAdministrativa c,7001_eventoAudienciaJuez e WHERE tipoContenido=3 AND 
					carpetaAdministrativa IN(".$listaCarpetas.") AND e.idRegistroEvento=c.idRegistroContenidoReferencia";
		
	}
	$listaJueces=$con->obtenerListaValores($consulta);
	if($listaJueces=="")
		$listaJueces=-1;
	$arrJuez="";
	$consulta="SELECT u.idUsuario,j.clave,u.Nombre,(SELECT count(*) FROM _346_juecesSolicitadosAmparo WHERE iFormulario=346 
			AND iRegistro=".$idRegistro." and idJuez=u.idUsuario) as seleccionado FROM _26_tablaDinamica j,800_usuarios u 
			WHERE u.idUsuario=j.usuarioJuez AND j.usuarioJuez IN(".$listaJueces.") ORDER BY j.clave";
	$rJuez=$con->obtenerFilas($consulta);
	while($fJuez=$con->fetchRow($rJuez))
	{
		$oJuez="['".$fJuez[0]."','".$fJuez[1].".- ".cv($fJuez[2])."','".$fJuez[3]."']";
		if($arrJuez=="")
			$arrJuez=$oJuez;
		else
			$arrJuez.=",".$oJuez;
	}
	
	echo "1|[".$arrJuez."]";
	
}

function obtenerJuecesJuicioAmparoSL()
{
	global $con;
	$iF=$_POST["iF"];
	$iR=$_POST["iR"];
	
	
	$arrJuez="";
	$consulta="SELECT idJuez,noJuez,u.Nombre FROM _346_juecesSolicitadosAmparo j,800_usuarios u WHERE 
			iFormulario=".$iF." AND iRegistro=".$iR." and u.idUsuario=j.idJuez order by j.noJuez";
	$rJuez=$con->obtenerFilas($consulta);
	while($fJuez=$con->fetchRow($rJuez))
	{
		$oJuez="['".$fJuez[0]."','".$fJuez[1].".- ".cv($fJuez[2])."']";
		if($arrJuez=="")
			$arrJuez=$oJuez;
		else
			$arrJuez.=",".$oJuez;
	}
	
	echo "1|[".$arrJuez."]";
	
}

function obtenerAcuerdoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT a.idArchivo as idDocumento,nomArchivoOriginal as nombreDocumento,tamano 
				FROM 3014_documentosAcuerdoRepatatorio d,908_archivos a WHERE idEvento=".$idEvento." AND a.idArchivo=d.idDocumento";
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}

function obtenerJuecesConocenCausa()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	//2222021029
	$nReg=0;
	$arrJuez="";
	
	$consulta="SELECT nombre,apPaterno,apMaterno,quejoso FROM _346_tablaDinamica WHERE id__346_tablaDinamica=".$idRegistro;
	$fQuejoso=$con->obtenerPrimeraFila($consulta);
	if($fQuejoso[0]=="")
	{
		$consulta="SELECT nombre,apellidoPaterno,apellidoMaterno FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fQuejoso[3];
		$fQuejoso=$con->obtenerPrimeraFila($consulta);
		
	}
	
	$quejoso=$fQuejoso[0]." ".$fQuejoso[1]." ".$fQuejoso[2];
	
	$figuraJuridica=4;
	$resultado=buscarCoincidenciasCriterio(1,$quejoso,65,$figuraJuridica);
	
	$listaActividades="";
	foreach($resultado[1] as $idActividad=>$resto)
	{
		if($listaActividades=="")
			$listaActividades=$idActividad;
		else
			$listaActividades.=",".$idActividad;
	}
	
	
	if($listaActividades=="")
		$listaActividades=-1;
	
	
	//$con->numRows($resultado[0])
	
	$consulta="SELECT idJuez,noJuez,u.Nombre,j.tieneConocimiento,j.carpetaConocimiento,j.idImputadoConocimiento 
			FROM _346_juecesSolicitadosAmparo j,800_usuarios u WHERE 
			iFormulario=".$idFormulario." AND iRegistro=".$idRegistro." and u.idUsuario=j.idJuez order by j.noJuez";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrCarpetas="";
		$consulta="SELECT distinct c.carpetaAdministrativa,c.carpetaAdministrativa,ca.idActividad  FROM 7000_eventosAudiencia e,
				7001_eventoAudienciaJuez j,7007_contenidosCarpetaAdministrativa c,7006_carpetasAdministrativas ca
					WHERE j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$fila[0]." AND c.tipoContenido=3 AND 
					c.idRegistroContenidoReferencia=e.idRegistroEvento and c.carpetaAdministrativa<>''
					and ca.carpetaAdministrativa=c.carpetaAdministrativa order by carpetaAdministrativa";
		$rCarpetas=$con->obtenerFilas($consulta);
		while($fCarpeta=$con->fetchRow($rCarpetas))
		{
			$consulta="SELECT DISTINCT t.id__47_tablaDinamica, concat(nombre,' ',apellidoPaterno,' ',apellidoMaterno) as nombre
						FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r WHERE  r.idActividad=".$fCarpeta[2]." 
						and r.idActividad=t.idActividad and r.idParticipante=t.id__47_tablaDinamica and r.idFiguraJuridica in (".$figuraJuridica.")";
			$aImputados=$con->obtenerFilasArreglo($consulta);
			$oCarpeta="['".$fCarpeta[0]."','".$fCarpeta[0]."',".$aImputados."]";	
			if($arrCarpetas=="")
				$arrCarpetas=$oCarpeta;
			else
				$arrCarpetas.=",".$oCarpeta;
		}
		
		$arrCarpetas="[".$arrCarpetas."]";
		
		
		$arrCarpetasConocimiento="";
		
		$consulta="SELECT distinct c.carpetaAdministrativa,ca.idActividad  FROM 7000_eventosAudiencia e,
				7001_eventoAudienciaJuez j,7007_contenidosCarpetaAdministrativa c,7006_carpetasAdministrativas ca 
					WHERE j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$fila[0]." AND c.tipoContenido=3 AND 
					c.idRegistroContenidoReferencia=e.idRegistroEvento and c.carpetaAdministrativa<>'' and 
					ca.carpetaAdministrativa=c.carpetaAdministrativa and ca.idActividad in (".$listaActividades.")
					  order by carpetaAdministrativa";
		
		$rCarpetas=$con->obtenerFilas($consulta);
		while($fCarpeta=$con->fetchRow($rCarpetas))
		{
			$consulta="SELECT DISTINCT t.id__47_tablaDinamica, concat(nombre,' ',apellidoPaterno,' ',apellidoMaterno) as nombre
						FROM _47_tablaDinamica t,7005_relacionFigurasJuridicasSolicitud r WHERE match(apellidoPaterno, apellidoMaterno,nombre)
						against ('".$quejoso."') and r.idActividad=".$fCarpeta[1]." and r.idActividad=t.idActividad and r.idParticipante=t.id__47_tablaDinamica
						and r.idFiguraJuridica in (".$figuraJuridica.")";
			$aImputados=$con->obtenerFilasArreglo($consulta);
			$oCarpeta="['".$fCarpeta[0]."',".$aImputados."]";	
			if($arrCarpetasConocimiento=="")
				$arrCarpetasConocimiento=$oCarpeta;
			else
				$arrCarpetasConocimiento.=",".$oCarpeta;
		}
		
		$arrCarpetasConocimiento="[".$arrCarpetasConocimiento."]";
		
		$o='{"idJuez":"'.$fila[0].'","nombreJuez":"'.cv($fila[1].".- ".$fila[2]).'","coincidenciaBusqueda":'.$arrCarpetasConocimiento.',
			"tieneConocimiento":'.(($fila[3]==1)?"true":"false").',"carpetaConocimiento":"'.$fila[4].'",
			"imputadoAsociado":"'.$fila[5].'","arrCarpetas":'.$arrCarpetas.'}';
		if($arrJuez=="")
			$arrJuez=$o;
		else
			$arrJuez.=",".$o;
		
		$nReg++;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrJuez.']}';
	
}

function obtenerDocumentosJueces()
{
	global $con;
	$arrJueces="";
	$nReg=0;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$consulta="SELECT * FROM _363_tablaDinamica WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro;
	$resJueces=$con->obtenerFilas($consulta);
	while($fJueces=$con->fetchAssoc($resJueces))
	{
		
		$consulta="SELECT noJuez FROM _346_juecesSolicitadosAmparo WHERE iRegistro=".$idRegistro." AND idJuez=".$fJueces["idJuez"];
		$noJuez=$con->obtenerValor($consulta);
		
		$nombreJuez=$noJuez.".- ".obtenerNombreUsuario($fJueces["idJuez"]);
		$oJuez='{"idRegistro":"'.$fJueces["id__363_tablaDinamica"].'","iRegistro":"'.$fJueces["iRegistro"].'","idJuez":"'.$fJueces["idJuez"].'","nombreJuez":"'.cv($nombreJuez).'","idDocumento":"'.$fJueces["tipoDocumento"].'","situacion":"'.$fJueces["idEstado"].'"}';
		
		if($arrJueces=="")
			$arrJueces=$oJuez;
		else
			$arrJueces.=",".$oJuez;
		
		$nReg++;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrJueces.']}';
	
}

function guardarConocimientoJuezAmparo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="UPDATE _346_juecesSolicitadosAmparo SET tieneConocimiento=0,carpetaConocimiento=NULL,
					idImputadoConocimiento=NULL
					WHERE iFormulario=".$obj->idFormulario." AND iRegistro=".$obj->idRegistro;
	$x++;
	
	foreach($obj->jueces as $j)
	{
		$query[$x]="UPDATE _346_juecesSolicitadosAmparo SET tieneConocimiento=1,carpetaConocimiento='".$j->carpetaConocimiento."',
					idImputadoConocimiento='".$j->idImputadoConocimiento."'
					WHERE iFormulario=".$obj->idFormulario." AND iRegistro=".$obj->idRegistro."  AND idJuez=".$j->idJuez;
		$x++;
	}
	
	
	$query[$x]="commit";
	$x++;
	eB($query);
}


function generarDocumentosInforme()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];

	if(generarDocumentosSolicitudesAmparo($idFormulario,$idRegistro))
	{
		echo "1|";
	}
}

function obtenerActorProcesoDocumentoAmparo()
{
	global $con;
	$actorBase=$_POST["a"];
	$iRegistro=$_POST["iR"];
	
	
	$consulta="SELECT actor,tipoActor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actorBase;
	$fDatosActor=$con->obtenerPrimeraFila($consulta);
	
	$consulta="SELECT idEstado FROM _363_tablaDinamica WHERE id__363_tablaDinamica=".$iRegistro;
	
	$numEtapa=$con->obtenerValor($consulta);
	
	$idActor=obtenerActorProcesoIdRol("165",$fDatosActor[0],$numEtapa);
	
	echo "1|".$idActor;
	
	
	
}

function registrarRequerimientosEspecialesSolicitudAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$campo="";

	switch($obj->tipoRequerimiento)
	{
		case 1://Requiere área de resguardo
			$campo="requiereResguardo";
		break;
		case 2://Requiere Tele presencia
			$campo="requiereTelePresencia";
		break;
		case 3://Requiere mesa de evidencia
			$campo="requiereMesaEvidencia";
		break;
		case 4://Requiere modalidad de testigo protegido
			$campo="requiereTestigoProtegido";
		break;
	}
	
	$consulta="UPDATE _".$obj->idFormulario."_tablaDinamica SET ".$campo."=".$obj->valor." WHERE id__".
			$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
	eC($consulta);
}

function liberarProgramacionEventoAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	cambiarEtapaFormulario($obj->idFormulario,$obj->idRegistro,3.1,"",-1,"NULL","NULL",276);
}

function registrarDatosAcuerdoReparatorio()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$obj->idEvento;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;	
	
	
	if($obj->idRegistro=="-1")		
	{
		$query[$x]="INSERT INTO 3014_registroAcuerdosReparatorios(resumenAcuerdo,tipoCumplimiento,acuerdoAprobado,fechaExtincionAccionPenal,
																idEvento,comentariosAdicionales,situcionActual,fechaRegistro,responsableRegistro)							
					VALUES('".cv($obj->resumen)."',".$obj->tipoCumplimiento.",".$obj->apruebaAcuerdo.",".(($obj->fechaExtincion=="")?"NULL":"'".
					$obj->fechaExtincion."'").",".$obj->idEvento.",'".cv($obj->comentariosAdicionales)."',1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].
					")";
		$x++;
		
		$query[$x]="set @idAcuerdo:=(select last_insert_id())";
		$x++;
	}
	else
	{
		if(!isset($obj->acuerdoUpdate))
		{
			$query[$x]="update 3014_registroAcuerdosReparatorios set resumenAcuerdo='".cv($obj->resumen)."',tipoCumplimiento=".$obj->tipoCumplimiento.
					",acuerdoAprobado=".$obj->apruebaAcuerdo.",fechaExtincionAccionPenal=".(($obj->fechaExtincion=="")?"NULL":"'".$obj->fechaExtincion."'").
					",idEvento=".$obj->idEvento.",comentariosAdicionales='".cv($obj->comentariosAdicionales)."' where idRegistro=".$obj->idRegistro;							
	
			$x++;
		}
		else
		{
			$query[$x]="INSERT  INTO 3014_modificacionesAcuerdoReparatorio(idAcuerdo,fechaExtinsion,comentariosAdicionales,fechaCambio,idResponsableCambio)
						SELECT ".$obj->idRegistro." AS idAcuerdo,fechaExtincionAccionPenal,comentariosAdicionales,'".date("Y-m-d H:i:s").
						"' AS fechaCambio,".$_SESSION["idUsr"]." FROM 3014_registroAcuerdosReparatorios WHERE idRegistro=".$obj->idRegistro;							
	
			$x++;
			$query[$x]="update 3014_registroAcuerdosReparatorios set fechaExtincionAccionPenal=".(($obj->fechaExtincion=="")?"NULL":"'".$obj->fechaExtincion."'").
					",comentariosAdicionales='".cv($obj->comentariosAdicionales)."' where idRegistro=".$obj->idRegistro;							
	
			$x++;
		}
		$query[$x]="set @idAcuerdo:=".$obj->idRegistro;
		$x++;
	}
	
	if(!isset($obj->acuerdoUpdate))
	{
		$query[$x]="DELETE FROM 3014_documentosAcuerdoRepatatorio WHERE idAcuerdo=".$obj->idRegistro;
		$x++;
	}
	foreach($obj->documentosAcuerdo as $d)
	{
		if(strpos($d->idDocumento,"_")!==false)
		{
			$d->idDocumento=registrarDocumentoServidorRepositorio($d->idDocumento,$d->nombreDocumento,2,"");
		}
		
		$query[$x]="INSERT INTO 3014_documentosAcuerdoRepatatorio(idEvento,idDocumento,idAcuerdo) 
				VALUES(".$obj->idEvento.",".$d->idDocumento.",@idAcuerdo)";
		$x++;
		
		
		registrarDocumentoCarpetaAdministrativa($cAdministrativa,$d->idDocumento,-1,-1);
		
	}
	
	if(!isset($obj->acuerdoUpdate))
	{
		$query[$x]="DELETE FROM 3014_imputadosAcuerdoReparatorio WHERE idAcuerdo=".$obj->idRegistro;
		$x++;
		$arrImputados=explode(",",$obj->imputado);
		foreach($arrImputados as $i)
		{
			$query[$x]="INSERT INTO 3014_imputadosAcuerdoReparatorio(idEvento,idAcuerdo,idImputado) VALUES(".$obj->idEvento.",@idAcuerdo,".$i.")";
			$x++;
		}
	}
	$query[$x]="commit";
	$x++;	

	eB($query);
	
}

function removerDatosAcuerdoReparatorio()
{
	global $con;
	$idAcuerdo=$_POST["idAcuerdo"];
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="DELETE FROM 3014_registroAcuerdosReparatorios WHERE idRegistro=".$idAcuerdo;
	$x++;
	
	$query[$x]="DELETE FROM 3014_documentosAcuerdoRepatatorio WHERE idAcuerdo=".$idAcuerdo;
	$x++;
	
	$query[$x]="DELETE FROM 3014_imputadosAcuerdoReparatorio WHERE idAcuerdo=".$idAcuerdo;
	$x++;
	
	$query[$x]="commit";
	$x++;	
	
	eB($query);
	
	
}



function obtenerAcuerdosReparatoriosAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$sL=$_POST["sL"];
	
	
	$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fechaInicioEvento=$con->obtenerValor($consulta);
	
	$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$carpetaAdministrativa=$fDatosCarpeta["carpetaAdministrativa"];
	$iCarpeta=$fDatosCarpeta["idCarpetaAdministrativa"];
	$arrCarpetas=array();

	obtenerCarpetasPadreIdCarpeta($carpetaAdministrativa,$arrCarpetas,$iCarpeta);
	$listaCarpetas="'".$carpetaAdministrativa."'";
	
	foreach($arrCarpetas as $o)
	{
		$listaCarpetas.=",'".$o["carpetaAdministrativa"]."'";
	}

	
	$consulta="SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND carpetaAdministrativa IN(".$listaCarpetas.")";


	$listaEventos=$con->obtenerListaValores($consulta);
	
	if($listaEventos=="")
		$listaEventos=-1;
		
	$consulta="SELECT (SELECT GROUP_CONCAT(idImputado) FROM 3014_imputadosAcuerdoReparatorio WHERE idAcuerdo=r.idRegistro),
			resumenAcuerdo,tipoCumplimiento,acuerdoAprobado,fechaExtincionAccionPenal,comentariosAdicionales,idRegistro,r.situcionActual,
			r.fechaRegistro,idEvento
			 
			FROM 3014_registroAcuerdosReparatorios r WHERE idEvento in(".$listaEventos.") and situcionActual<>10";
	
	$arrRegistros="";
	
	$res=$con->obtenerFilas($consulta);
	$numReg=0;
	while($fila=$con->fetchRow($res))
	{
		$arrComentarios=array();
		$arrComentarios[$fila[8]!=""?$fila[8]:$fechaInicioEvento]=$fila[5]==""?"(Sin comentarios)":$fila[5];
		$consulta="SELECT comentariosAdicionales,fechaCambio FROM 3014_modificacionesAcuerdoReparatorio WHERE idAcuerdo=".$fila[6]." order by idRegistro";
		$rComentarios=$con->obtenerFilas($consulta);
		while($fComentarios=$con->fetchRow($rComentarios))
		{
			$arrComentarios[$fComentarios[1]]=$fComentarios[0]==""?"(Sin comentarios)":$fComentarios[0];
		}
		$comentariosAdicionales="";
		if(sizeof($arrComentarios)==1)
		{
			foreach($arrComentarios as $fecha=>$resto)
				$comentariosAdicionales="(".date("d/m/Y H:i",strtotime($fecha))." hrs.): ".$resto;
				
		}
		else
		{
			$ultimafecha="";
			$primerComentario="";
			$posicion=0;
			foreach($arrComentarios as $fecha=>$resto)
			{
				
				if($posicion==0)
				{
					$ultimafecha=$fecha;
					$primerComentario=$resto;
				}
				else
				{
					$comentario="(".date("d/m/Y H:i",strtotime($ultimafecha))." hrs.): ".$resto;
					//echo $comentario."<br><br>";
					$ultimafecha=$fecha;
					if($comentariosAdicionales=="")
					{
						$comentariosAdicionales=$comentario;
						
					}
					else
						$comentariosAdicionales.="<br><br>".$comentario;
				}
				$posicion++;
			}
			
			$comentario="(".date("d/m/Y H:i",strtotime($ultimafecha))." hrs.): ".$primerComentario;
					//echo $comentario."<br><br>";
			if($comentariosAdicionales=="")
			{
				$comentariosAdicionales=$comentario;
				
			}
			else
				$comentariosAdicionales.="<br><br>".$comentario;
		}
		
		
		$consulta="SELECT a.idArchivo as idDocumento,a.nomArchivoOriginal as nombreDocumento,a.tamano as tamano ,
					(SELECT Nombre FROM 800_usuarios WHERE idUsuario=a.responsable) as responsable,fechaCreacion
					FROM 3014_documentosAcuerdoRepatatorio d,908_archivos a 
					WHERE idAcuerdo=".$fila[6]." and a.idArchivo=d.idDocumento and 
					(a.eliminado is null or a.eliminado=0)";
				
		$arrDocumentos=$con->obtenerFilasJSON($consulta);		
		$tblDocumentos="(Sin documentos asociados)";
		if($con->filasAfectadas>0)
		{
			$tblDocumentos="<table><tr><td width='35'><span style='font-weight:bold'></span></td><td width='300'><span style='font-weight:bold' >Nombre del documento</span></td><td width='120'><span style='font-weight:bold'>Registrado el</span></td><td width='260'><span style='font-weight:bold'>Registrado por</span></td></tr>";
			$rDocumentos=$con->obtenerFilas($consulta);
			while($fDocumento=$con->fetchRow($rDocumentos))
			{
				if($sL==0)
				{
					$tblDocumentos.="<tr height='21' id='fDocumento_".$fDocumento[0]."'><td><a href='javascript:removerDocumento(\\\"".bE($fDocumento[0]).
									"\\\")'><img src='../images/delete.png' title='Remover documento' alt='Remover documento'></a></td><td>".
									"<a href='javascript:visualizarDocumento(\\\"".bE($fDocumento[0])."\\\",\\\"".bE($fDocumento[1])."\\\")'>".$fDocumento[1]."</a></td><td>".date("d/m/Y H:i",strtotime($fDocumento[4]))."</td><td>".$fDocumento[3]."</td></tr>";		
				}
				else
				{
					$tblDocumentos.="<tr height='21' id='fDocumento_".$fDocumento[0]."'><td></td><td>".
									"<a href='javascript:visualizarDocumento(\\\"".bE($fDocumento[0])."\\\",\\\"".bE($fDocumento[1])."\\\")'>".$fDocumento[1]."</a></td><td>".date("d/m/Y H:i",strtotime($fDocumento[4]))."</td><td>".$fDocumento[3]."</td></tr>";		
				}
			}
			$tblDocumentos.='</table>';
		}
		$consulta="SELECT COUNT(*) FROM 3014_modificacionesAcuerdoReparatorio WHERE idAcuerdo=".$fila[6];
		$historialModificacionAcuerdo=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=2 AND idRegistroReferencia=".$fila[6];
		$historialSituacionAcuerdo=$con->obtenerValor($consulta);
		
		$modificable=($historialModificacionAcuerdo+$historialSituacionAcuerdo)>1?0:1;
		if($fila[9]!=$idEvento)
		{
			$modificable=0;
		}
		$o='{"idImputado":"'.$fila[0].'","resumenAcuerdo":"'.cv($fila[1]).'","tipoCumplimiento":"'.$fila[2].'","acuerdoAprobado":"'.$fila[3].
			'","fechaExtincionAccionPenal":"'.$fila[4].'","arrDocumentos":'.$arrDocumentos.',"comentariosAdicionales":"'.cv($comentariosAdicionales).
			'","idRegistro":"'.$fila[6].'","situacionActual":"'.$fila[7].'","modificable":"'.$modificable.'","historialModificacionAcuerdo":"'.
			$historialModificacionAcuerdo.'","historialSituacionAcuerdo":"'.$historialSituacionAcuerdo.'","tblDocumentos":"'.$tblDocumentos.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
			
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerAcuerdosReparatoriosImputado()
{
	global $con;
	global $con;
	$consulta="";
	
	
	$valor=$_POST["valor"];
	
	
	$arrValoresBusqueda=explode(" ",trim($valor));
	for($x=0;$x<sizeof($arrValoresBusqueda);$x++)
	{
		$arrValoresBusqueda[$x]=normalizaToken($arrValoresBusqueda[$x]);
	}
	$resultado=buscarCoincidenciasCriterio(3,$valor,60,4);
	
	
	
	$arrRes=$resultado[1];
	
	$listaImputados="";
	foreach($arrRes as $i=>$resto)
	{
		if($listaImputados=="")
			$listaImputados=$i;
		else
			$listaImputados.=",".$i;
			
	}
	
	if($listaImputados=="")
		$listaImputados=-1;
	
	$consulta="SELECT distinct idAcuerdo FROM 3014_imputadosAcuerdoReparatorio WHERE idImputado IN(".$listaImputados.")";
	$arrRegistros="";
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT * FROM 3014_registroAcuerdosReparatorios WHERE idRegistro=".$fila[0];
		$fAcuerdo=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$fAcuerdo[5];
		$fechaInicioEvento=$con->obtenerValor($consulta);
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fAcuerdo[5];
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idArchivo,nomArchivoOriginal,tamano FROM 3014_documentosAcuerdoRepatatorio d, 
				908_archivos a WHERE a.idArchivo=d.idDocumento AND  idAcuerdo=".$fila[0]." and a.eliminado=0";
		$documentos=$con->obtenerFilasArreglo($consulta);
		
		$imputado="";
		$consulta="SELECT CONCAT(if(nombre is null,'',nombre),' ',if(apellidoPaterno is null,'',apellidoPaterno),' ',if(apellidoMaterno is null,'',apellidoMaterno)) FROM 3014_imputadosAcuerdoReparatorio i,_47_tablaDinamica imp WHERE i.idAcuerdo=".$fila[0]." AND i.idImputado IN(".$listaImputados.")
					AND i.idImputado=imp.id__47_tablaDinamica";
		$rImputados=$con->obtenerFilas($consulta);
		while($fImputado=$con->fetchRow($rImputados))
		{
			if($imputado=="")
			{
				$imputado=$fImputado[0];
			}
			else
			{
				$imputado.="<br>".$fImputado[0];
			}
		}		
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$delitos="";
		$consulta="SELECT de.denominacionDelito FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE idActividad=".$idActividad." AND de.id__35_denominacionDelito=d.denominacionDelito";
		$rRegistro=$con->obtenerFilas($consulta);
		while($fRegistro=$con->fetchRow($rRegistro))
		{
			if($delitos=="")
			{
				$delitos=$fRegistro[0];
			}
			else
			{
				$delitos.="<br>".$fRegistro[0];
			}
		}	
		
		$victimas="";
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica v,7005_relacionFigurasJuridicasSolicitud r 
					WHERE r.idParticipante=v.id__47_tablaDinamica and r.idActividad=".$idActividad." and r.idFiguraJuridica=2";
		$rVictimas=$con->obtenerFilas($consulta);
		while($fVictima=$con->fetchRow($rVictimas))
		{
			if($victimas=="")
			{
				$victimas=$fVictima[0];
			}
			else
			{
				$victimas.="<br>".$fVictima[0];
			}
		}	
		
		$consulta="SELECT COUNT(*) FROM 3014_modificacionesAcuerdoReparatorio WHERE idAcuerdo=".$fAcuerdo[0];
		$historialModificacionAcuerdo=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=2 AND idRegistroReferencia=".$fAcuerdo[0];
		$historialSituacionAcuerdo=$con->obtenerValor($consulta);
		
		
		$arrComentarios=array();
		$arrComentarios[$fAcuerdo[8]!=""?$fAcuerdo[8]:$fechaInicioEvento]=$fAcuerdo[6]==""?"(Sin comentarios)":$fAcuerdo[6];
		$consulta="SELECT comentariosAdicionales,fechaCambio FROM 3014_modificacionesAcuerdoReparatorio WHERE idAcuerdo=".$fAcuerdo[0].
					" order by idRegistro";
		$rComentarios=$con->obtenerFilas($consulta);
		while($fComentarios=$con->fetchRow($rComentarios))
		{
			$arrComentarios[$fComentarios[1]]=$fComentarios[0]==""?"(Sin comentarios)":$fComentarios[0];
		}
		$comentariosAdicionales="";
		if(sizeof($arrComentarios)==1)
		{
			foreach($arrComentarios as $fecha=>$resto)
				$comentariosAdicionales="(".date("d/m/Y H:i",strtotime($fecha))." hrs.): ".$resto;
				
		}
		else
		{
			$ultimafecha="";
			$primerComentario="";
			$posicion=0;
			foreach($arrComentarios as $fecha=>$resto)
			{
				
				if($posicion==0)
				{
					$ultimafecha=$fecha;
					$primerComentario=$resto;
				}
				else
				{
					$comentario="(".date("d/m/Y H:i",strtotime($ultimafecha))." hrs.): ".$resto;
					//echo $comentario."<br><br>";
					$ultimafecha=$fecha;
					if($comentariosAdicionales=="")
					{
						$comentariosAdicionales=$comentario;
						
					}
					else
						$comentariosAdicionales.="<br><br>".$comentario;
				}
				$posicion++;
			}
			
			$comentario="(".date("d/m/Y H:i",strtotime($ultimafecha))." hrs.): ".$primerComentario;
					//echo $comentario."<br><br>";
			if($comentariosAdicionales=="")
			{
				$comentariosAdicionales=$comentario;
				
			}
			else
				$comentariosAdicionales.="<br><br>".$comentario;
		}
		
		
		$o='{"idAcuerdo":"'.$fAcuerdo[0].'","tipoCumplimiento":"'.$fAcuerdo[2].'","resumenAcuerdo":"'.cv($fAcuerdo[1]).'","fechaExtinsion":"'.$fAcuerdo[4].'","acuerdoAprobado":"'.$fAcuerdo[3].
			'","carpetaAdministrativa":"'.$carpetaAdministrativa.'","documentos":'.$documentos.',"comentariosAdicionales":"'.cv($comentariosAdicionales).'","imputado":"'.cv($imputado).'","delito":"'.cv($delitos).
			'","victimas":"'.cv($victimas).'","situacionActual":"'.$fAcuerdo[7].'","historialModificacionAcuerdo":"'.
			$historialModificacionAcuerdo.'","historialSituacionAcuerdo":"'.$historialSituacionAcuerdo.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerTotalAcuerdosReparatoriosImputado()
{
	global $con;
	global $con;
	$consulta="";
	
	
	/*$valor=$_POST["valor"];
	
	
	$arrValoresBusqueda=explode(" ",trim($valor));
	for($x=0;$x<sizeof($arrValoresBusqueda);$x++)
	{
		$arrValoresBusqueda[$x]=normalizaToken($arrValoresBusqueda[$x]);
	}
	$resultado=buscarCoincidenciasCriterio(3,$valor,60,4);
	
	
	
	$arrRes=$resultado[1];
	
	$listaImputados="";
	foreach($arrRes as $i=>$resto)
	{
		if($listaImputados=="")
			$listaImputados=$i;
		else
			$listaImputados.=",".$i;
			
	}
	
	if($listaImputados=="")
		$listaImputados=-1;*/
	
	
	
	
	$arrRegistros="";
	$numReg=0;
	
	$consulta="SELECT * FROM 3014_registroAcuerdosReparatorios";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT idImputado FROM 3014_imputadosAcuerdoReparatorio WHERE idAcuerdo=".$fila["idRegistro"];
		$listaImputados=$con->obtenerListaValores($consulta);
		if($listaImputados=="")
			$listaImputados=-1;
		//018002277700
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila["idEvento"];
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idArchivo,nomArchivoOriginal,tamano FROM 3014_documentosAcuerdoRepatatorio d, 908_archivos a WHERE a.idArchivo=d.idDocumento AND  idAcuerdo=".$fila["idRegistro"];
		$documentos=$con->obtenerFilasArreglo($consulta);
		
		$imputado="";
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM 3014_imputadosAcuerdoReparatorio i,_47_tablaDinamica imp WHERE i.idAcuerdo=".$fila["idRegistro"].
				" AND i.idImputado IN(".$listaImputados.") 	AND i.idImputado=imp.id__47_tablaDinamica";
		$rImputados=$con->obtenerFilas($consulta);
		while($fImputado=$con->fetchRow($rImputados))
		{
			if($imputado=="")
			{
				$imputado=$fImputado[0];
			}
			else
			{
				$imputado.="<br>".$fImputado[0];
			}
		}		
		
		$consulta="SELECT idActividad,(SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad=unidadGestion) as unidad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$fDatoCarpeta=$con->obtenerPrimeraFila($consulta);
		$idActividad=$fDatoCarpeta[0];
		$unidadGestion=$fDatoCarpeta[1];
		
		$delitos="";
		$consulta="SELECT de.denominacionDelito FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE idActividad=".$idActividad." AND de.id__35_denominacionDelito=d.denominacionDelito";
		$rRegistro=$con->obtenerFilas($consulta);
		while($fRegistro=$con->fetchRow($rRegistro))
		{
			if($delitos=="")
			{
				$delitos=$fRegistro[0];
			}
			else
			{
				$delitos.="<br>".$fRegistro[0];
			}
		}	
		
		$victimas="";
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica v,7005_relacionFigurasJuridicasSolicitud r 
					WHERE r.idParticipante=v.id__47_tablaDinamica and r.idActividad=".$idActividad." and r.idFiguraJuridica=2";
		$rVictimas=$con->obtenerFilas($consulta);
		while($fVictima=$con->fetchRow($rVictimas))
		{
			if($victimas=="")
			{
				$victimas=$fVictima[0];
			}
			else
			{
				$victimas.="<br>".$fVictima[0];
			}
		}	
		
		$o='{"idAcuerdo":"'.$fila["idRegistro"].'","tipoCumplimiento":"'.$fila["tipoCumplimiento"].'","resumenAcuerdo":"'.cv($fila["resumenAcuerdo"]).'","fechaExtinsion":"'.$fila["fechaExtincionAccionPenal"].
			'","acuerdoAprobado":"'.$fila["acuerdoAprobado"].'","carpetaAdministrativa":"'.$carpetaAdministrativa.'","documentos":'.$documentos.',"comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).
			'","imputado":"'.cv($imputado).'","delito":"'.cv($delitos).'","victimas":"'.cv($victimas).'","unidadGestion":"'.$unidadGestion.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerDelitosImputadoComputoPena()
{
	global $con;
	$idImputado=$_POST["idImputado"];
	$idActividad=$_POST["idActividad"];
	$carpetaJudicial=$_POST["carpetaJudicial"];
	
	$consulta="select idRegistro from 3014_registroCompurgaSentencia where idImputado=".$idImputado." 
				and carpetaJudicial='".$carpetaJudicial."' and idActividad=".$idActividad;
	$idRegistro=$con->obtenerValor($consulta);
	
	if($idRegistro=="")
		$idRegistro=-1;
	
	
	$consulta="SELECT denominacionDelito FROM _61_tablaDinamica d,_61_chkDelitosImputado i WHERE idActividad=".$idActividad."
				AND i.idPadre=d.id__61_tablaDinamica AND i.idOpcion=".$idImputado;
	$res=$con->obtenerFilas($consulta);
	if($con->filasAfectadas==0)
	{
		$consulta="SELECT denominacionDelito FROM _61_tablaDinamica d WHERE idActividad=".$idActividad;
		$res=$con->obtenerFilas($consulta);
	}
	
	$nReg=$con->filasAfectadas;
	$arrRegistros="";
	while($fila=$con->fetchRow($res))
	{
		$o='';
		$consulta="SELECT * FROM 3014_registroCompurgaSentenciaComputoPena WHERE idRegistroCompurgaSentencia=".$idRegistro." AND delito=".$fila[0];
		$fComputo=$con->obtenerPrimeraFila($consulta);
		if(!$fComputo)
			$o='{"idComputo":"-1","anos":"0","meses":"0","dias":"0","delito":"'.$fila[0].'"}';
		else
			$o='{"idComputo":"'.$fComputo[0].'","anos":"'.$fComputo[2].'","meses":"'.$fComputo[3].'","dias":"'.$fComputo[4].'","delito":"'.$fila[0].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	
}

function registrarSentenciaImputadoComputoPena()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="select idRegistro from 3014_registroCompurgaSentencia where idImputado=".$obj->idImputado." 
			and carpetaJudicial='".$obj->carpetaJudicial."' and idActividad=".$obj->idActividad;
	$idRegistro=$con->obtenerValor($consulta);
	
	if($idRegistro=="")
		$idRegistro=-1;
	$x=0;
	$query[$x]="begin";
	$x++;
	
	if($idRegistro==-1)
	{
		$query[$x]="INSERT INTO 3014_registroCompurgaSentencia(fechaCreacion,idResponsableCreacion,idImputado,carpetaJudicial,idActividad,aniosSentencia,
					mesesSentencia,diasSentencia,idEventoAudiencia,fechaEjecutoria,fechaCompurga)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idImputado.",'".$obj->carpetaJudicial."',".$obj->idActividad.
					",".$obj->anioSentencia.",".$obj->mesSentencia.",".$obj->diaSentencia.",".$obj->idEventoAudiencia.",'".$obj->fechaEjecutoria."','".
					$obj->fechaCompurga."')";
		$x++;
		$query[$x]="set @idRegistro=(select last_insert_id())";
		$x++;
	}
	else
	{
		$query[$x]="update 3014_registroCompurgaSentencia set fechaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"].
					",aniosSentencia=".$obj->anioSentencia.",mesesSentencia=".$obj->mesSentencia.",diasSentencia=".$obj->diaSentencia.
					",fechaEjecutoria='".$obj->fechaEjecutoria."',fechaCompurga='".$obj->fechaCompurga."' where idRegistro=".$idRegistro;
					
		$x++;
		$query[$x]="set @idRegistro=".$idRegistro;
		$x++;
	}
	
	
	$query[$x]="delete from 3014_registroCompurgaSentenciaComputoPrision where idRegistroCompurgaSentencia=@idRegistro";
	$x++;
	
	foreach($obj->arrComputoPrision as $o)
	{
		$query[$x]="INSERT INTO 3014_registroCompurgaSentenciaComputoPrision(idRegistroCompurgaSentencia,anios,
					meses,dias,centroReclusion) VALUES(@idRegistro,".$o->anos.",".$o->meses.",".$o->dias.",".$o->reclusorio.")";
		$x++;
	}
	
	$query[$x]="delete from 3014_registroCompurgaSentenciaComputoPena where idRegistroCompurgaSentencia=@idRegistro";
	$x++;
	foreach($obj->arrComputoSentencia as $o)
	{
		$query[$x]="INSERT INTO 3014_registroCompurgaSentenciaComputoPena(idRegistroCompurgaSentencia,anios,
					meses,dias,delito) VALUES(@idRegistro,".$o->anos.",".$o->meses.",".$o->dias.",".$o->delito.")";
		$x++;
	} 
	
	$query[$x]="commit";
	$x++;
	eB($query);
	
	
}

function obtenerBeneficiosPenitenciarios()
{
	global $con;
	$arrRegistros="";
	$consulta="SELECT id__380_tablaDinamica,categoria FROM _380_tablaDinamica";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$o='{"tipo":"'.$fila[1].'","idBeneficio":"'.$fila[0].'","aplicarBeneficio":false,"detalles":""}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
}

function obtenerActorConfirmacionAudiencia()
{
	global $con;
	$iF=$_POST["iF"];
	$iR=$_POST["iR"];
	$r=$_POST["r"];
	
	$consulta="SELECT idEstado FROM _".$iF."_tablaDinamica WHERE id__".$iF."_tablaDinamica=".$iR;
	$idEstado=$con->obtenerValor($consulta);
	
	$idProceso=obtenerIdProcesoFormulario($iF);
	
	$actor=obtenerActorProcesoIdRol($idProceso,$r,$idEstado);
	if($actor=="")
		$actor=0;
	
	echo "1|".$actor;
	
}

function generarReporteAudienciasV2()
{
	ini_set("memory_limit","3000M");
	set_time_limit(999000);
	global $con;
	
	$arrUnidad="";
	$periodoInicial=$_POST["fechaInicio"];
	$periodoFinal=$_POST["fechaFin"];	

	$arrTiposCarpeta[1]="Unidades de Gesti&oacute;n Judicial";
	$arrTiposCarpeta[5]="Tribunal de Enjuciamiento";
	$arrTiposCarpeta[6]="Unidades de Ejecuci&oacute;n";
	
	foreach($arrTiposCarpeta as $tCarpeta=>$etiqueta)
	{
		$consulta="SELECT id__17_tablaDinamica,nombreUnidad,claveUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra c 
				WHERE c.idPadre=u.id__17_tablaDinamica and  c.idOpcion=".$tCarpeta." ORDER BY prioridad";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$consulta="SELECT count(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$fila[2]."' 
				AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and 
				tipoCarpetaAdministrativa=".$tCarpeta;
		
			$nCarpetas=$con->obtenerValor($consulta);
			
			$nCarpetasExhorto=0;	
			$nPromocionesExhortos=0;		
			if(($tCarpeta==1)||($tCarpeta==6))
			{
				$consulta="SELECT count(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$fila[2]."' 
					AND fechaCreacion>='".$periodoInicial."' AND fechaCreacion<='".$periodoFinal." 23:59:59' and 
					tipoCarpetaAdministrativa=2";
			
				$nCarpetasExhorto=$con->obtenerValor($consulta);
				
				
				$consulta="SELECT count(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE 
				p.fechaCreacion>='".$periodoInicial."' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' 
				and p.carpetaAdministrativa=c.carpetaAdministrativa AND p.idEstado>1 AND c.unidadGestion='".$fila[2].
				"' and tipoCarpetaAdministrativa=2";
				$nPromocionesExhortos=$con->obtenerValor($consulta);	
			}
				
			$nPromociones=0;
			$consulta="SELECT count(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE 
				p.fechaCreacion>='".$periodoInicial."' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' 
				and p.carpetaAdministrativa=c.carpetaAdministrativa AND p.idEstado>1 AND c.unidadGestion='".$fila[2].
				"' and tipoCarpetaAdministrativa=".$tCarpeta;
			
			$nPromociones=$con->obtenerValor($consulta);
			$nSolicitudesIniciales=0;
			$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia  e,7007_contenidosCarpetaAdministrativa con, 7006_carpetasAdministrativas c 
						WHERE e.fechaEvento>='".$periodoInicial."' AND e.fechaEvento<='".$periodoFinal.
					" 23:59:59' AND e.idCentroGestion=".$fila[0]."  AND e.idFormulario IN(11,46,5) AND e.tipoAudiencia<>25 AND e.situacion IN (1,2,4,5)
					and con.tipoContenido=3 and con.idRegistroContenidoReferencia=e.idRegistroEvento
				and c.carpetaAdministrativa=con.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tCarpeta;
			$nSolicitudesIniciales=$con->obtenerValor($consulta);
					
			$nEventosVarios=0;
			$nEventosPromociones=0;	
			$consulta="SELECT DISTINCT idRegistroEvento,
					(SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=idRegistroSolicitud) as iFormulario 
					FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
						7006_carpetasAdministrativas c  WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' 
				AND e.idCentroGestion=".$fila[0]." and e.idFormulario=185 and tipoAudiencia<>25 and e.situacion in (1,2,4,5)
				and con.tipoContenido=3 and con.idRegistroContenidoReferencia=e.idRegistroEvento
				and c.carpetaAdministrativa=con.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tCarpeta;
	 
			$resAux=$con->obtenerFilas($consulta);
			while($filaAux=$con->fetchRow($resAux))
			{
				$iFormulario=$filaAux[1];
				if($iFormulario!=96)
					$nEventosVarios++;
				else
					$nEventosPromociones++;
				
			}
			
			$nEventosContinuacion=0;
	
			$consulta="SELECT count(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia  e, 7007_contenidosCarpetaAdministrativa con,
						7006_carpetasAdministrativas c WHERE e.fechaEvento>='".$periodoInicial."' AND e.fechaEvento<='".$periodoFinal."' 
						AND  e.idCentroGestion=".$fila[0]." and tipoAudiencia=25 and e.situacion in (1,2,4,5)
						and con.tipoContenido=3 and con.idRegistroContenidoReferencia=e.idRegistroEvento
						and c.carpetaAdministrativa=con.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tCarpeta;
						

			$nEventosContinuacion=$con->obtenerValor($consulta);
			
			$o1='{"idCategoria":"'.$tCarpeta.'","categoria":"'.$etiqueta.'","idUnidadGestion":"'.$fila[2].'","unidadGestion":"'.$fila[1].
				'","carpetasJudiciales":"'.$nCarpetas.'","carpetasExhortos":"'.$nCarpetasExhorto.'","promocionesExhortos":"'.$nPromocionesExhortos.'",
				"listaCarpetas":"-1","listaCarpetasEx":"-1","promociones":"'.$nPromociones.'","listaPromociones":"",
				"audienciasSolicitudInicial":"'.$nSolicitudesIniciales.'","listaAudienciasIniciales":"",
				"audienciasPromocion":"'.$nEventosPromociones.'","listaAudienciasPromocion":"",
				"audienciasVarias":"'.$nEventosVarios.'","listaAudienciasVarias":"-1",
				"audienciasContinuacion":"'.$nEventosContinuacion.'","listaAudienciasContinuacion":"",
				"totalAudiencias":"'.($nSolicitudesIniciales+$nEventosPromociones+$nEventosVarios+$nEventosContinuacion).'","listaTotalAudiencias":"-1"}';
				
			if($arrUnidad=="")
				$arrUnidad=$o1;
			else
				$arrUnidad.=",".$o1;
		}
	
	}
	
		
	echo '{"numReg":"","registros":['.$arrUnidad.']}';
	
	
}

function determinarRequiereCentroReclusion()
{
	global $con;
	$cAdministrativa=$_POST["cAdministrativa"];
	
	$consulta="SELECT u.consideraCentroReclusion FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u 
			WHERE u.claveUnidad=c.unidadGestion AND c.carpetaAdministrativa='".$cAdministrativa."'";
	$cCentroReclusion=$con->obtenerValor($consulta);
	echo "1|".$cCentroReclusion;
	
	
	
}

function obtenerEvaluacionActuacionJudicial()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$consulta="SELECT tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT idProceso,etiqueta FROM _4_gridProcesos WHERE idReferencia=".$tipoAudiencia." ORDER BY etiqueta";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		$idFormulario=obtenerFormularioBase($fila[0]);		
		
		$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM _".$idFormulario."_tablaDinamica where idEvento=".$idEvento;

		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$actor="";
		$accion="";
		
		if($fRegistro)
		{
			$actor=obtenerActorProcesoIdRol($fila[0],'119_0',$fRegistro[1]);
			$accion="auto";
		}
		else
		{
			$consulta="SELECT idActorVSAccionesProceso FROM 949_actoresVSAccionesProceso WHERE idProceso=".$fila[0]." AND actor='119_0' AND idAccion=8";
			$actor=$con->obtenerValor($consulta);
			if($actor=="")
				$actor=0;
			$accion="agregar";
		}
		
		
			
		
		$o='{"actor":"'.bE($actor).'","accion":"'.bE($accion).'","idReferencia":"'.(!$fRegistro?-1:$fRegistro[0]).'","situacion":"'.$fRegistro[1].'","evaluacion":"'.cv($fila[1]).'","idFormulario":"'.$idFormulario.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
	
}

function obtenerRegistroEjecucionV2()
{
	global $con;
	$tipoCarpeta=$_POST["tipoCarpeta"];
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$iFormulario=385;
	
	
	$rolesDEGJ["90_0"]=1;
	$rolesDEGJ["159_0"]=1;
	
	$idProceso=obtenerIdProcesoFormulario($iFormulario);
	$rol="69_0";
	
	foreach($rolesDEGJ as $r=>$resto)
	{
		if(existeRol("'".$r."'"))
		{
			$rol="90_0";
			break;
		}
	}
			
	$consulta="SELECT id__".$iFormulario."_tablaDinamica,idEstado FROM _".$iFormulario."_tablaDinamica WHERE carpetaAdministrativa='".$cA."' and idEstado in (1,2)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");

		
	}
	
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro?$fRegistro[1]:0);
	$act=bE($actor);
	
	echo "1|".$iR."|".$a."|".$act."|".$iFormulario;
	
}

function registrarSentenciaEjecucion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="";
	
	$objDetalle='';
	$sustitutivo="NULL";
	$objDetalleSustitutivo='';
	$acogeSustitutivo="NULL";
	$detallesAdicionalesSustitutivo="";
	
	if(isset($obj->objDetalle->monto))
	{
		$objDetalle='{"monto":"'.$obj->objDetalle->monto.'"}';
	}
	else
	{
		if(isset($obj->objDetalle->anios))
			$objDetalle='{"anios":"'.$obj->objDetalle->anios.'","meses":"'.$obj->objDetalle->meses.'","dias":"'.$obj->objDetalle->dias.'"}';
		else
		{
			if(isset($obj->objDetalle->tiposObjetos))
			{
				$objDetalle='{"tiposObjetos":"'.$obj->objDetalle->tiposObjetos.'"}';
			}
		}
	}
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	
	if($obj->idRegistro==-1)
	{
		
		$consulta[$x]="insert into 7024_registroPenasSentenciaEjecucion(idActividad,idPena,objDetalle,centroDetencion,detallesAdicionales,
					permiteSustitutivos,tipoPena,detallePena) 
					values(".$obj->idActividad.",".$obj->idPena.",'".$objDetalle."','".$obj->centroDetencion."','".cv($obj->detallesAdicionales).
					"',".$obj->permiteSustitutivo.",".$obj->tipoPena.",".$obj->detallePena.")";
		
		
		if(isset($obj->fechaInicio))
		{
			$consulta[$x]="insert into 7024_registroPenasSentenciaEjecucion(idActividad,idPena,objDetalle,centroDetencion,detallesAdicionales,
					permiteSustitutivos,tipoPena,detallePena,fechaInicio,fechaTermino,abonoPrisionPunitiva) 
					values(".$obj->idActividad.",".$obj->idPena.",'".$objDetalle."','".$obj->centroDetencion."','".cv($obj->detallesAdicionales).
					"',".$obj->permiteSustitutivo.",".$obj->tipoPena.",".$obj->detallePena.",'".$obj->fechaInicio."','".$obj->fechaTermino."','".
					$obj->abonoPrisionPunitiva."')";
		}
		$x++;
		$consulta[$x]="set @idPena:=(select last_insert_id())";
		$x++;
	}
	else
	{
		$consulta[$x]="update 7024_registroPenasSentenciaEjecucion set idPena=".$obj->idPena.",objDetalle='".$objDetalle."',centroDetencion='".$obj->centroDetencion.
					"',detallesAdicionales='".cv($obj->detallesAdicionales)."',permiteSustitutivos=".$obj->permiteSustitutivo.
					" ,tipoPena=".$obj->tipoPena.",detallePena=".$obj->detallePena." where idRegistro=".$obj->idRegistro;
		
		if(isset($obj->fechaInicio))
		{
			$consulta[$x]="update 7024_registroPenasSentenciaEjecucion set idPena=".$obj->idPena.",objDetalle='".$objDetalle."',centroDetencion='".$obj->centroDetencion.
					"',detallesAdicionales='".cv($obj->detallesAdicionales)."',permiteSustitutivos=".$obj->permiteSustitutivo.
					" ,tipoPena=".$obj->tipoPena.",detallePena=".$obj->detallePena.",fechaInicio='".$obj->fechaInicio.
					"',fechaTermino='".$obj->fechaTermino."',abonoPrisionPunitiva='".$obj->abonoPrisionPunitiva."' where idRegistro=".$obj->idRegistro;
		}
		$x++;
		$consulta[$x]="set @idPena:=".$obj->idRegistro;
		$x++;
					
	}
	
	$consulta[$x]="DELETE FROM  7026_registroSustitutivoPena WHERE idPena=@idPena";
	$x++;
	
	if($obj->permiteSustitutivo==1)
	{
		foreach($obj->datosSustitutivos as $d)
		{
			$consulta[$x]="INSERT INTO 7026_registroSustitutivoPena(idPena,idSustitutivo,acogeSustitutivo,
							detallesAdicionales,montoSustitutivo,periodoSustitutivo) VALUES(@idPena,".$d->idSustitutivo.",
							".$d->acogeSustitutivo.",'".cv($d->detallesAdicionales)."',".($d->montoSustitutivo==''?"NULL":$d->montoSustitutivo).
							",'".$d->periodoSustitutivo."')";
			$x++;
		}
	}
	
	$consulta[$x]="DELETE FROM  7032_delitosPena WHERE idPena=@idPena";
	$x++;
	
	if($obj->arrDelitos!="")
	{
		$arrDelitos=explode(",",$obj->arrDelitos);
		foreach($arrDelitos as $d)
		{
			$consulta[$x]="INSERT INTO 7032_delitosPena(idPena,idDelito) VALUES(@idPena,".$d.")";
			$x++;
		}
	}
	
	$consulta[$x]="DELETE FROM 7033_computoPrisionCumplida WHERE idPena=@idPena";
	$x++;	
	
	foreach($obj->arrAbonoPrisionPreventiva as $c)
	{
		
		$consulta[$x]="INSERT INTO 7033_computoPrisionCumplida(idPena,anios,meses,dias,lugarDetencion,especifique)
					VALUES(@idPena,".$c->anos.",".$c->meses.",".$c->dias.",'".$c->lugarDetencion."','".cv($c->especifique)."')";
		$x++;
	}
	
	$consulta[$x]="commit";
	$x++;
	
	
	
	
	eB($consulta);
}

function obtenerSentenciaEjecucion()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	$arrRegistros="";
	$nReg=0;
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idActividad=".$idActividad;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT idSustitutivo,acogeSustitutivo,detallesAdicionales,montoSustitutivo,
					periodoSustitutivo FROM 7026_registroSustitutivoPena WHERE idPena=".$fila["idRegistro"];
		$arrSustitutivos=utf8_encode($con->obtenerFilasJson($consulta));
		
		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito SEPARATOR '<br>') FROM 7032_delitosPena d,_35_denominacionDelito de 
					WHERE d.idPena=".$fila["idRegistro"]." AND de.id__35_denominacionDelito=d.idDelito ORDER BY denominacionDelito";
		$delitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT idRegistro AS idComputo,anios AS anos,meses,dias,lugarDetencion,especifique 
					FROM 7033_computoPrisionCumplida WHERE idPena=".$fila["idRegistro"];
		$arrComputoPrisionPreventiva=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$o='{"idRegistro":"'.$fila["idRegistro"].'","idPena":"'.$fila["idPena"].'","idActividad":"'.$fila["idActividad"].
			'","objDetalle":"'.cv($fila["objDetalle"]).'","centroDetencion":"'.$fila["centroDetencion"].'","detallesAdicionales":"'.cv($fila["detallesAdicionales"]).
			'","permiteSustitutivos":"'.$fila["permiteSustitutivos"].'","datosSustitutivos":'.$arrSustitutivos.',"delitos":"'.
			cv($delitos).'","arrComputoPrisionPreventiva":'.$arrComputoPrisionPreventiva.',"tipoPena":"'.$fila["tipoPena"].
			'","detallePena":"'.$fila["detallePena"].'","fechaInicio":"'.$fila["fechaInicio"].'","fechaFin":"'.$fila["fechaTermino"].
			'","abonoPrisionPunitiva":"'.$fila["abonoPrisionPunitiva"].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
		$nReg++;
	}
	
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	
}

function removerSentenciaEjecucion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="DELETE  FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$idRegistro;
	$x++;
	$consulta[$x]="DELETE FROM 7032_delitosPena WHERE idPena=".$idRegistro;
	$x++;	
	$consulta[$x]="DELETE FROM 7026_registroSustitutivoPena WHERE idPena=".$idRegistro;
	$x++;		
	$consulta[$x]="DELETE FROM 7033_computoPrisionCumplida WHERE idPena=".$idRegistro;

	$x++;	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
	
}

function obtenerDatosContactoParticipante()
{
	global $con;
	$idParticipante=$_POST["idParticipante"];
	
	$obj=obtenerUltimoDomicilioFiguraJuridica($idParticipante);

	

	echo "1|".$obj;
}

function actualizarDatosContactoParticipante()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idParticipante=".$obj->idParticipante;
	$idCuentaAcceso=$con->obtenerValor($consulta);
	$consulta="SELECT idRegistro FROM 7025_datosContactoParticipante WHERE idParticipante=".$obj->idParticipante;
	$idRegistro=$con->obtenerValor($consulta);
	
	if($idRegistro=="")
		$idRegistro=-1;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	
	if($idRegistro==-1)
	{
		$query[$x]="INSERT INTO 7025_datosContactoParticipante(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias)
					VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->idParticipante.",'".date("Y-m-d H:i:s")."','".cv($obj->calle).
					"','".cv($obj->noExt)."','".cv($obj->noInt)."','".cv($obj->colonia)."','".cv($obj->cp)."','".cv($obj->estado).
					"','".cv($obj->municipio)."','".cv($obj->localidad)."','".cv($obj->entreCalle)."','".cv($obj->yCalle)."','".cv($obj->referencias)."')";
		$x++;
		
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
	}
	else
	{
		$query[$x]=" INSERT INTO 7025_datosContactoParticipanteRespaldos(idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,responsableModificacion,
					 fechaModificacion)				
					SELECT idFormulario,idReferencia,idParticipante,fechaCreacion,calle,noExt,noInterior,
					 colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,yCalle,otrasReferencias,
					 ".$_SESSION["idUsr"]." as responsableModificacion,'".date("Y-m-d H:i:s")."' fechaModificacion FROM
					 7025_datosContactoParticipante WHERE idParticipante=".$obj->idParticipante;
		$x++;
		$query[$x]="set @iRegistroRespaldo:=(select last_insert_id())";
		$x++;
		
		$query[$x]="INSERT INTO 7025_correosElectronicoRespaldos(idReferencia,correo)
					SELECT  @iRegistroRespaldo,correo FROM 7025_correosElectronico WHERE idReferencia=".$idRegistro;
		$x++;
		$query[$x]="INSERT INTO 7025_telefonosRespaldos( idReferencia,tipoTelefono,lada,numero,extension,idPais)
					SELECT  @iRegistroRespaldo,tipoTelefono,lada,numero,extension,idPais FROM 7025_telefonos WHERE idReferencia=".$idRegistro;
		$x++;						
						 
		$query[$x]="update 7025_datosContactoParticipante set fechaCreacion='".date("Y-m-d H:i:s")."',calle='".cv($obj->calle)."',
					noExt='".cv($obj->noExt)."',noInterior='".cv($obj->noInt)."',colonia='".cv($obj->colonia)."',codigoPostal='".cv($obj->cp)."',
					entidadFederativa='".cv($obj->estado)."',municipio='".cv($obj->municipio)."',localidad='".cv($obj->localidad)."',
					entreCalle='".cv($obj->entreCalle)."',yCalle='".cv($obj->yCalle)."',otrasReferencias='".cv($obj->referencias)."'
					where idRegistro=".$idRegistro;
					
		$x++;
		
		$query[$x]="set @idRegistro:=".$idRegistro;
		$x++;
	}
	
	$query[$x]="delete from 7025_correosElectronico where idReferencia=@idRegistro";
	$x++;
	foreach($obj->mail as $m)
	{
		$query[$x]="INSERT INTO 7025_correosElectronico(idReferencia,correo) VALUES(@idRegistro,'".cv($m->mail)."')";
		$x++;
	}
	$query[$x]="delete from 7025_telefonos where idReferencia=@idRegistro";
	$x++;
	foreach($obj->arrTelefonos as $t)
	{
		$query[$x]="INSERT INTO 7025_telefonos(idReferencia,tipoTelefono,lada,numero,extension,idPais) VALUES(@idRegistro,'".$t->tipoTelefono.
					"','".$t->lada."','".$t->numero."',".($t->extension==""?"NULL":$t->extension).",".$t->idPais.")";
		$x++;
	}
	$query[$x]="commit";
	$x++;
	
	if($con->ejecutarBloque($query))
	{
		if($idCuentaAcceso!="")
		{
			/*$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
	
			$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
			
			$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
			
			$parametros=array();
			$parametros["idParticipante"]=$idCuentaAcceso;
			$parametros["cadObj"]=bE($cadObj);
			
			
			$response = $client->call("actualizarDireccionParticipante", $parametros);
			
			$oJuzgado=json_decode($response);
			if($oJuzgado->resultado==1)
			{
				echo "1|";
			}
			else
			{
				echo "0|".$oJuzgado->mensaje;
			}*/
			echo "1|";
			
		}
		else
			echo "1|";
	}
	
	
}

function obtenerFigurasJuridicasCarpetaAdministrativa()
{
	global $con;
	$cA=-1;
	if(isset($_POST["cA"]))
		$cA=$_POST["cA"];
	$fJ=$_POST["fJ"];
	$idActividad=-1;
	if(isset($_POST["iA"]))
		$idActividad=$_POST["iA"];
	else
	{
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
		$idActividad=$con->obtenerValor($consulta);
		if($idActividad=="")
			$idActividad=-1;
	}
	
	$situacion=-1;
	if(isset($_POST["situacion"]))
		$situacion=$_POST["situacion"];
	
	$consulta="SELECT p.id__47_tablaDinamica,CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) AS nombre FROM 
				7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad in(".$idActividad.") AND r.idFiguraJuridica=".$fJ;
				
	if($situacion!=-1)
		$consulta.=" and r.situacion in(".$situacion.")";
	$consulta.=" AND p.id__47_tablaDinamica=r.idParticipante ORDER BY nombre,apellidoPaterno,apellidoMaterno";
	
	$arrParticipantes=$con->obtenerFilasArreglo($consulta);	
	echo "1|".$arrParticipantes;		
	
}

function obtenerMedioNotificacionActaCircunstanciada()
{
	global $con;
	$tD=$_POST["tD"];
	$pp=$_POST["pp"];
	
	$arrRegistros="";
	$consulta="SELECT idPadre FROM _415_chkTiposNotificacionAplica WHERE idOpcion=".$tD;
	$lMedio1=$con->obtenerListaValores($consulta);
	if($lMedio1=="")
		$lMedio1=-1;
	$consulta="SELECT idPadre FROM _415_chkPartesProcesales WHERE idOpcion=".$pp." and idPadre in(".$lMedio1.")";
	$lMedio2=$con->obtenerListaValores($consulta);
	if($lMedio2=="")
		$lMedio2=-1;
	$consulta="SELECT id__415_tablaDinamica,medioNotificacion FROM _415_tablaDinamica WHERE id__415_tablaDinamica IN(".$lMedio2.") order by prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrDetalles="";
		
		$consulta="SELECT idDetalle,descripcion,idSubdetalle FROM _415_gEspecificaciones WHERE idReferencia=".$fila[0]." order by prioridad";
		$rDetalles=$con->obtenerFilas($consulta);
		while($fDetalles=$con->fetchRow($rDetalles))
		{
			$arrDetalles2="[]";
			
			if($fDetalles[2]!="")
			{
				$consulta="SELECT idDetalle,descripcion FROM _415_gEspecificaciones WHERE idReferencia=".$fDetalles[2]." order by prioridad";
				$arrDetalles2=$con->obtenerFilasArreglo($consulta);
			}
			
			$oE="['".$fDetalles[0]."','".cv($fDetalles[1])."',".$arrDetalles2."]";
			if($arrDetalles=="")
				$arrDetalles=$oE;
			else
				$arrDetalles.=",".$oE;
		}
		
		$o="['".$fila[0]."','".cv($fila[1])."',[".$arrDetalles."]]";
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo "1|[".$arrRegistros."]";
}

function registrarDatosDiligencia()
{
	global $con;
	$objDiligencia=$_POST["objDiligencia"];
	$oDiligencia=json_decode($objDiligencia);
	
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	if($oDiligencia->idDiligencia==-1)
	{
		$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden+1 WHERE idActaCircunstanciada=".$oDiligencia->idActa.
					" AND orden>=".$oDiligencia->orden;
		$x++;
		$query[$x]="INSERT INTO 7029_diligenciaActaNotificacion(idActaCircunstanciada,fechaCreacion,idResponsable,fechaDiligencia,tipoDiligencia,
					otroTipoDiligencia,idParteProcesal,idDetalleParteProcesal,idNombreParteProcesal,nombreParte,idResponsableDiligencia,lblOtroResponsable,
					exposicionDiligencia,orden) values ('".$oDiligencia->idActa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$oDiligencia->fechaDiligencia.
					"',".$oDiligencia->tipoDiligencia.",'".cv($oDiligencia->otroTipoDiligencia)."',".$oDiligencia->parteProcesal.",".
					($oDiligencia->detalleParteProcesal==""?"NULL":$oDiligencia->detalleParteProcesal).",".($oDiligencia->idParteProcesal==""?"NULL":$oDiligencia->idParteProcesal).
					",'".cv($oDiligencia->nombreParteProcesal)."',".$oDiligencia->idResponsableDiligencia.",'".cv($oDiligencia->nombreResponsableDiligencia).
					"','".cv(bD($oDiligencia->exposicionDiligencia))."',".$oDiligencia->orden.")";
		$x++;
		
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
	}
	else
	{
		$consulta="select orden from 7029_diligenciaActaNotificacion  where idRegistro=".$oDiligencia->idDiligencia;
		$ordenOriginal=$con->obtenerValor($consulta);
		
		
		if($ordenOriginal!=$oDiligencia->orden)
		{
			if($ordenOriginal>$oDiligencia->orden)
			{
				$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden+1 WHERE idActaCircunstanciada=".$oDiligencia->idActa.
					" and orden>=".$oDiligencia->orden." AND orden<=".$ordenOriginal;
				$x++;
			}
			else
			{
				$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden-1 WHERE idActaCircunstanciada=".$oDiligencia->idActa.
					" and orden>=".$ordenOriginal." AND orden<=".$oDiligencia->orden;
				$x++;
			}
		}
		
		$query[$x]="update 7029_diligenciaActaNotificacion set fechaUltimaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"].
					",fechaDiligencia='".$oDiligencia->fechaDiligencia."',tipoDiligencia=".$oDiligencia->tipoDiligencia.",
					otroTipoDiligencia='".cv($oDiligencia->otroTipoDiligencia)."',idParteProcesal=".$oDiligencia->parteProcesal.
					",idDetalleParteProcesal=".($oDiligencia->detalleParteProcesal==""?"NULL":$oDiligencia->detalleParteProcesal).
					",idNombreParteProcesal=".($oDiligencia->idParteProcesal==""?"NULL":$oDiligencia->idParteProcesal).
					",nombreParte='".cv($oDiligencia->nombreParteProcesal)."',idResponsableDiligencia=".$oDiligencia->idResponsableDiligencia.
					",lblOtroResponsable='".cv($oDiligencia->nombreResponsableDiligencia)."',orden=".$oDiligencia->orden.
					",exposicionDiligencia='".cv(bD($oDiligencia->exposicionDiligencia)).
					"' where idRegistro=".$oDiligencia->idDiligencia;
		$x++;
		$query[$x]="set @idRegistro:=".$oDiligencia->idDiligencia;
		$x++;
	}
	
	$query[$x]="DELETE FROM 7030_medioNotificacionDiligencia WHERE idDiligencia=@idRegistro";
	$x++;
	
	foreach($oDiligencia->arrMedioNotificacion as $m)
	{
		$query[$x]="INSERT INTO 7030_medioNotificacionDiligencia(idDiligencia,idMedio,detalle1,detalle2,detalle3,resultadoNotificacion,dejoCitatorio)
					values(@idRegistro,".$m->idMedio.",".($m->detalle1==""?"NULL":$m->detalle1).",".($m->detalle2==""?"NULL":$m->detalle2).
					",'".cv($m->detalle3)."',".$m->resultado.",".($m->citatorio==""?"NULL":$m->citatorio).")";
		$x++;
	}
	
	$query[$x]="commit";
	$x++;
	
	eB($query);
}

function obtenerDiligenciasActa()
{
	global $con;
	$idActa=$_POST["idActa"];
	
	
	$arrRegistros="";
	$o="";
	$numReg=0;
	$consulta="SELECT * FROM 7029_diligenciaActaNotificacion WHERE idActaCircunstanciada=".$idActa." ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	
	while($fila=$con->fetchAssoc($res))
	{
		$lblNombreParteProcesal="";
		if($fila["idNombreParteProcesal"]!="")
		{
			$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila["idNombreParteProcesal"];
			$lblNombreParteProcesal=$con->obtenerValor($consulta);
		}
		
		
		$consulta="SELECT idMedio,detalle1,detalle2,detalle3,resultadoNotificacion AS  resultado,dejoCitatorio AS citatorio  
					FROM 7030_medioNotificacionDiligencia WHERE idDiligencia=".$fila["idRegistro"]." ORDER BY idRegistro";
		$arrMedios=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$o='{"idDiligencia":"'.$fila["idRegistro"].'","fechaCreacion":"'.$fila["fechaCreacion"].'","fechaDiligencia":"'.$fila["fechaDiligencia"].
			'","tipoDiligencia":"'.$fila["tipoDiligencia"].'","otroTipoDiligencia":"'.cv($fila["otroTipoDiligencia"]).'",
			"idParteProcesal":"'.$fila["idParteProcesal"].'","idDetalleParteProcesal":"'.$fila["idDetalleParteProcesal"].
			'","idNombreParteProcesal":"'.$fila["idNombreParteProcesal"].'","nombreParte":"'.cv($fila["nombreParte"]).
			'","exposicionDiligencia":"'.cv($fila["exposicionDiligencia"]).'","lblNombreParteProcesal":"'.cv($lblNombreParteProcesal).'",
			"idResponsableDiligencia":"'.$fila["idResponsableDiligencia"].'","lblOtroResponsable":"'.cv($fila["lblOtroResponsable"]).
			'","arrMediosNotificacion":'.$arrMedios.',"orden":"'.$fila["orden"].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}'	;
}

function removerDiligenciaActa()
{
	global $con;
	$iD=$_POST["iD"];
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$consulta="select orden,idActaCircunstanciada from 7029_diligenciaActaNotificacion  where idRegistro=".$iD;
	$fActa=$con->obtenerPrimeraFila($consulta);
	$ordenOriginal=$fActa[0];
	
	$query[$x]="UPDATE 7029_diligenciaActaNotificacion SET orden=orden-1 WHERE idActaCircunstanciada=".$fActa[1].
					" and orden>=".$ordenOriginal;
	$x++;
	
	$query[$x]="DELETE FROM 7029_diligenciaActaNotificacion WHERE idRegistro=".$iD;
	$x++;
	$query[$x]="DELETE FROM 7030_medioNotificacionDiligencia WHERE idDiligencia=".$iD;
	$x++;
	$query[$x]="DELETE FROM 7030_documentosAdjuntosDiligencia WHERE idDiligencia=".$iD;
	$x++;
	$query[$x]="commit";
	$x++;
	eB($query);
}

function guardarDatosActaMinima()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="";
	if($obj->idActa==-1)
	{
		$consulta="INSERT INTO 7028_actaNotificacion(fechaCreacion,idResponsableRegistro,fechaActa,tipoActa,nombreDeterminacion,fechaDeterminacion,idEventoAudiencia,comentariosAdicionales,carpetaAdministrativa)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->fechaActa."',".$obj->tipoActa.",'".cv($obj->nombreDeterminacion).
					"',".($obj->fechaDeterminacion==""?"NULL":"'".$obj->fechaDeterminacion."'").",".($obj->idEventoAudiencia==""?"NULL":"'".$obj->idEventoAudiencia.
					"'").",'".cv($obj->comentariosAdicionales)."','".$obj->carpetaAdministrativa."')";
	}
	else
	{
		$consulta="update 7028_actaNotificacion set fechaUltimaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"].
					",fechaActa='".$obj->fechaActa."',tipoActa=".$obj->tipoActa.",nombreDeterminacion='".cv($obj->nombreDeterminacion).
					"',fechaDeterminacion=".($obj->fechaDeterminacion==""?"NULL":"'".$obj->fechaDeterminacion."'").
					",idEventoAudiencia=".($obj->idEventoAudiencia==""?"NULL":"'".$obj->idEventoAudiencia."'").",
					comentariosAdicionales='".cv($obj->comentariosAdicionales)."' where idRegistro=".$obj->idActa;
					
	}
	
	if($con->ejecutarConsulta($consulta))
	{
		if($obj->idActa==-1)
			$obj->idActa=$con->obtenerUltimoID();
		
		echo "1|".$obj->idActa;
	}
	
	
	
	
	
	
}


function obtenerActasCircunstanciadas()
{
	global $con;
	$cA=$_POST["cA"];
	
	$consulta="SELECT idRegistro AS idActaNotificacion, fechaActa, fechaCreacion, tipoActa, 
				nombreDeterminacion,fechaDeterminacion AS fechaDeterminacionAudiencia,idEventoAudiencia,
				
				if(tipoActa=1,concat(nombreDeterminacion, ' [Fecha de la determinación: ',date_format(fechaDeterminacion,'%d/%m/%Y'),']'),
				(SELECT CONCAT('Audiencia del ',DATE_FORMAT(horaInicioEvento,'%d/%m/%Y a las %H:%i'),' [',t.tipoAudiencia,']') FROM 
				7000_eventosAudiencia e,_4_tablaDinamica t WHERE t.id__4_tablaDinamica=e.tipoAudiencia AND e.idRegistroEvento=a.idEventoAudiencia)) as tituloActa,				
				comentariosAdicionales,situacion,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=a.idResponsableRegistro) AS responsableActa,
				(SELECT COUNT(*) FROM 7029_diligenciaActaNotificacion WHERE idActaCircunstanciada=a.idRegistro) AS noDiligencias
				FROM 7028_actaNotificacion a WHERE carpetaAdministrativa='".$cA."' and situacion>0 ORDER BY fechaActa";
	
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));	
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}'	;		
	
	
	
	
}

function removerActaCircunstanciada()
{
	global $con;
	$iA=$_POST["iA"];
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE 7028_actaNotificacion SET situacion=0,fechaUltimaModificacion='".date("Y-m-d H:i:s").
			"',idResponsableModificacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$iA;
	$x++;
	

	$query[$x]="commit";
	$x++;
	eB($query);
}

function generarDocumentoEditorTexto()
{
	global $con;
	
	$tipoDocumento=$_POST["tipoDocumento"];
	$cadObj=$_POST["cadObj"];
	
	$objParametros=json_decode($cadObj);
	
	
	$carpetaAdministrativa="";
	
	$idDocumentoAdjunto=-1;
	$reprocesar=false;
	$idRegistroFormato=-1;
	$tipoFormato=$tipoDocumento;
	$cuerpoDocumento="";
	$sL=0;
	$idPerfilEvaluacion=-1;
	$etapaActual=0;

	$consulta="";
	if(isset($objParametros->idRegistroFormato)&&($objParametros->idRegistroFormato!=-1))
	{
		$consulta="SELECT tipoFormato,idFormulario,idRegistro,idReferencia,cuerpoFormato,idRegistroFormato,
				documentoBloqueado,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto FROM 3000_formatosRegistrados 
				WHERE idRegistroFormato=".$objParametros->idRegistroFormato;
	}
	else
	{
		if($objParametros->idFormulario==0)
		{
			$consulta="select * from 3000_formatosRegistrados where 1=2";
		}
		else
		{
			$consulta="SELECT tipoFormato,idFormulario,idRegistro,idReferencia,cuerpoFormato,idRegistroFormato,
						documentoBloqueado,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto FROM 3000_formatosRegistrados 
						WHERE idFormulario=".$objParametros->idFormulario." and idReferencia=".$objParametros->idRegistro.
						" and idFormularioProceso=-1 and tipoFormato=".$tipoDocumento;
		}
	}

	if(isset($objParametros->reprocesar)&&($objParametros->reprocesar==1))
	{
		$reprocesar=true;
	}
	
	$idRegistroFormato=isset($objParametros->idRegistroFormato)?$objParametros->idRegistroFormato:-1;	
	
	$fFormato=$con->obtenerPrimeraFila($consulta);

	if((!$fFormato)||($reprocesar))
	{
		$consulta="SELECT * FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoDocumento;
		$fRegistro=$con->obtenerPrimeraFila($consulta);	

		$funcionLlenado=($fRegistro[14]=="")?"-1":$fRegistro[14];
		$cuerpoDocumento=$fRegistro[12];

		if($funcionLlenado!="-1")
		{
			$cache=NULL;

			$arrValoresReemplazo=resolverExpresionCalculoPHP($funcionLlenado,$objParametros,$cache);

			if(gettype($arrValoresReemplazo)=="array")
			{
				foreach($arrValoresReemplazo as $llave=>$valor)
				{
					$cuerpoDocumento=str_replace("[".$llave."]",$valor,$cuerpoDocumento);
				}
			}
		}
		$cuerpoDocumento=str_replace('<img src="../images/marcador.png" width="12" />',"",$cuerpoDocumento);
		$cuerpoDocumento=bE($cuerpoDocumento);
		$idPerfilEvaluacion=$fRegistro[17];
		if($idPerfilEvaluacion=="")
			$idPerfilEvaluacion=-1;		

		$consulta="SELECT noEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND etapaInicial=1";
		$etapaActual=$con->obtenerValor($consulta);
		if($etapaActual=="")
			$etapaActual=0;

		if($fFormato && $reprocesar)
		{
			$idRegistroFormato=$fFormato[5];
			$tipoFormato=$fFormato[0];
			$sL=$fFormato[6];
			$etapaActual=$fFormato[7]==""?0:$fFormato[7];
			$idPerfilEvaluacion=$fFormato[8];
		}
	}
	else
	{
		$idRegistroFormato=$fFormato[5];
		$tipoFormato=$fFormato[0];
		$cuerpoDocumento=$fFormato[4];
		$sL=$fFormato[6];
		$etapaActual=$fFormato[7];
		$idPerfilEvaluacion=$fFormato[8];
		$idDocumentoAdjunto=$fFormato[9]==""?-1:$fFormato[9];
	}

	$actor=obtenerRolActualDocumento($objParametros,$idPerfilEvaluacion,$etapaActual,$idRegistroFormato);

	if(($actor=="0_0")&& isset($objParametros->rolDefault))
		$actor=$objParametros->rolDefault;

	$permisos=obtenerPermisosActor($actor,$idRegistroFormato,$tipoDocumento,isset($objParametros->idFormulario)?$objParametros->idFormulario:-1,isset($objParametros->idRegistro)?$objParametros->idRegistro:-1);
	echo '1|{"idDocumentoAdjunto":"'.$idDocumentoAdjunto.'","cuerpoDocumento":"'.$cuerpoDocumento.'","idRegistroFormato":"'.$idRegistroFormato.
			'","sL":"'.$sL.'","permisos":'.$permisos.'}';
}

function obtenerMediosNotificacionFundamento()
{
	global $con;
	$arrRegistros="";
	$consulta="SELECT id__415_tablaDinamica,medioNotificacion FROM _415_tablaDinamica ORDER BY medioNotificacion";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrRegistros2Fundamento=obtenerFundamentoLegalMedioNotificacion($fila[0]);
		
		$arrRegistros2="";
		
		if($arrRegistros2Fundamento!="")
		{
			$arrRegistros2='{"icon":"../images/s.gif","id":"'.$fila[0].'_fundamento","text":"<i>Fundamento legal</i>","tipoNodo":"0","leaf":false,"children":['.$arrRegistros2Fundamento.'],"expanded":false}';
		}
		
		$consulta="SELECT idDetalle,descripcion,prefijo,idSubdetalle FROM _415_gEspecificaciones WHERE idReferencia=".$fila[0]." ORDER BY descripcion";
		$r2=$con->obtenerFilas($consulta);
		while($fila2=$con->fetchRow($r2))
		{
			$arrRegistros3Fundamento=obtenerFundamentoLegalMedioNotificacion($fila[0].'_'.$fila2[0]);
		
			$arrRegistros3="";
			
			
			if($arrRegistros3Fundamento!="")
			{
				$arrRegistros3='{"icon":"../images/s.gif","id":"'.$fila[0].'_'.$fila2[0].'_fundamento","text":"<i>Fundamento legal</i>","tipoNodo":"0","leaf":false,"children":['.$arrRegistros3Fundamento.'],"expanded":false}';
			}
			
			if($fila2[3]!="")
			{
				$consulta="SELECT idDetalle,descripcion,prefijo,idSubdetalle FROM _415_gEspecificaciones 
							WHERE idReferencia=".$fila2[3]." ORDER BY descripcion";

				$r3=$con->obtenerFilas($consulta);
				while($fila3=$con->fetchRow($r3))
				{
					$arrRegistros4Fundamento=obtenerFundamentoLegalMedioNotificacion($fila[0].'_'.$fila2[0].'_'.$fila3[0]);					
					$arrRegistros4="";
					
					if($arrRegistros4Fundamento!="")
					{
						$arrRegistros4='{"icon":"../images/s.gif","id":"'.$fila[0].'_'.$fila2[0].'_'.$fila3[0].'_fundamento","text":"<i>Fundamento legal</i>","tipoNodo":"0","leaf":false,"children":['.$arrRegistros4Fundamento.'],"expanded":false}';
					}
					
					$o3='{"icon":"../images/s.gif","id":"'.$fila[0].'_'.$fila2[0].'_'.$fila3[0].'","text":"'.cv($fila3[1]).'","tipoNodo":"1","leaf":'.
						($arrRegistros4==""?"true":"false").',"children":['.$arrRegistros4.'],"expanded":true}';
					if($arrRegistros3=="")
						$arrRegistros3=$o3;
					else
						$arrRegistros3.=",".$o3;
				}
			
			}
			$o2='{"icon":"../images/s.gif","id":"'.$fila[0].'_'.$fila2[0].'","text":"'.cv($fila2[1]).'","tipoNodo":"1","leaf":'.($arrRegistros3==""?"true":"false").
				',"children":['.$arrRegistros3.'],"expanded":true}';
			if($arrRegistros2=="")
				$arrRegistros2=$o2;
			else
				$arrRegistros2.=",".$o2;
		}
		
		
		$o='{"icon":"../images/s.gif","id":"'.$fila[0].'","text":"'.cv($fila[1]).'","tipoNodo":"1","leaf":'.
			($arrRegistros2==""?"true":"false").',"children":['.$arrRegistros2.'],"expanded":true}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
	}
	
	
	echo '['.$arrRegistros.']';
}

function obtenerFundamentoLegalMedioNotificacion($llavePadre)
{

	global $con;
	$arrRegistros="";
	$consulta="select * from 7031_fundamentoLegalMedioNotificacion where llaveMedioNotificacion='".$llavePadre."' and situacion=1 
				order by idLey,idFuncionAplicacion,articulo,fraccion,inciso";
	$res=$con->obtenerFilas($consulta);
	
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT nombreLey FROM _422_tablaDinamica WHERE id__422_tablaDinamica=".$fila["idLey"];
		$lblLey=$con->obtenerValor($consulta);
		
		$lblFuncionAplicacion="";
		if($fila["idFuncionAplicacion"]!="")
		{
			$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila["idFuncionAplicacion"];
			$lblFuncionAplicacion=$con->obtenerValor($consulta);
		}
		$o='{"icon":"../images/s.gif","id":"'.$llavePadre.'_'.$fila["idRegistro"].'","text":"","ley":"'.cv($lblLey).'","articulo":"'.cv($fila["articulo"]).
			'","fraccion":"'.cv($fila["fraccion"]).'","inciso":"'.cv($fila["inciso"]).'","funcionAplicacion":"'.$lblFuncionAplicacion.
			'","complementario":"'.cv($fila["complementario"]).'","tipoNodo":"2","leaf":true,"children":[],"expanded":true,
			"idFuncionAplicacion":"'.$fila["idFuncionAplicacion"].'","idLey":"'.$fila["idLey"].'","idRegistro":"'.$fila["idRegistro"].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	return "".$arrRegistros."";
}


function registrarFundamentoLegalMedioNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="";
	if($obj->idFundamento==-1)
	{
		$consulta="INSERT INTO 7031_fundamentoLegalMedioNotificacion(llaveMedioNotificacion,idLey,articulo,fraccion,inciso,
					idFuncionAplicacion,situacion,complementario,fechaRegistro,idResponsable) VALUES('".$obj->idMedio."',".$obj->idLey.",'".cv($obj->articulo).
					"','".cv($obj->fraccion)."','".cv($obj->inciso)."',".($obj->funcionAplicacion==""?"NULL":$obj->funcionAplicacion).
					",1,'".cv($obj->complementario)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
	}
	else
	{
		$consulta="update 7031_fundamentoLegalMedioNotificacion set idLey=".$obj->idLey.",articulo='".cv($obj->articulo).
					"',fraccion='".cv($obj->fraccion)."',inciso='".cv($obj->inciso)."',	
					idFuncionAplicacion=".($obj->funcionAplicacion==""?"NULL":$obj->funcionAplicacion).",
					complementario='".cv($obj->complementario)."',fechaModificacion='".date("Y-m-d H:i:s").
					"',idResponsableModificacion=".$_SESSION["idUsr"]." where idRegistro=".$obj->idFundamento;
	}
	eC($consulta);
	
}

function removerFundamentoLegalMedioNotificacion()
{
	global $con;
	$iF=$_POST["iF"];
	$consulta="UPDATE 7031_fundamentoLegalMedioNotificacion SET situacion=0,fechaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$iF;
	eC($consulta);
}


function finalizarActaCircunstanciada()
{
	global $con;
	$idActa=$_POST["iA"];
	$consulta="UPDATE 7028_actaNotificacion SET situacion=2 WHERE idRegistro=".$idActa;
	eC($consulta);
}

function obtenerDocumentoPDFEditorFormato()
{
	global $con;
	$iFormulario=$_POST["iF"];
	$iRegistro=$_POST["iR"];
	
	
	$consulta="SELECT idDocumento FROM 3000_formatosRegistrados WHERE idFormulario=".$iFormulario." AND idRegistro=".$iRegistro;
	if(isset($_POST["tD"]))
		$consulta.=" AND tipoFormato=".$_POST["tD"];

	$iDocumento=$con->obtenerValor($consulta);
	if($iDocumento=="")
		$iDocumento=-1;
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$iDocumento;
	$nombreArchivo=$con->obtenerValor($consulta);
	echo "1|".$iDocumento."|".$nombreArchivo;
	
}

function generarIncidenciasAudiencia()
{
	global $con;
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	
	$arrConceptos[1]="Audiencias programadas";
	$arrConceptos[2]="Audiencias confirmadas";
	$arrConceptos[3]="Audiencias canceladas por Unidad de Gestión";
	$arrConceptos[4]="Audiencias canceladas por resolución mediante acuerdo";
	
	$arrConceptos[5]="Audiencias que iniciaron de manera puntual";
	$arrConceptos[6]="Audiencias que iniciaron con retraso máximo de 5 min.";
	$arrConceptos[7]="Audiencias que iniciaron con retraso entre 5 y 10 min.";
	$arrConceptos[8]="Audiencias que iniciaron con retraso mayor a 10 min.";
	$arrConceptos[9]="Audiencias cuyo inicio no se puede estimar (Sin resolutivos)";
	
	$arrConceptos[10]="Audiencias con almenos un receso";
	$arrConceptos[11]="Audiencias que se difirieron por falta de comparecencia de la víctima";
	$arrConceptos[12]="Audiencias que se difirieron por falta de comparecencia del imputado";
	$arrConceptos[13]="Audiencias que se difirieron por falta de comparecencia del Ministerio Publico";
	$arrConceptos[14]="Audiencias que se difirieron por falta de comparecencia del Representante Legal de la victima";
	$arrConceptos[15]="Audiencias que se difirieron por solicitud de la defensa";
	$arrConceptos[16]="Total de audiencias que se difirieron";	
	$arrConceptos[17]="Audiencias pospuestas en búsqueda de una solución alterna";
	
	

	
	$arrEventosUGAS=array();
	$arrRegistros="";
	$numReg=0;
	
	$tipoCarpeta=1;
	foreach($arrConceptos as $idConcepto=>$lblConcepto)
	{
		$total=0;
		$o='{"idConcepto":"'.$idConcepto.'","concepto":"'.cv($lblConcepto).'"';
		$consulta="SELECT id__17_tablaDinamica,nombreUnidad,claveUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1  ORDER BY prioridad";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$valor=0;			
			switch($idConcepto)
			{
				case 1:
					$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c 
								WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND idCentroGestion=".$fila[0]." 
								AND e.situacion IN(1,2,3,4,5,6) and co.tipoContenido=3 and co.idRegistroContenidoReferencia=e.idRegistroEvento
								and c.carpetaAdministrativa=co.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tipoCarpeta;
					$valor=$con->obtenerValor($consulta);
				break;
				case 2:
					$consulta="SELECT e.idRegistroEvento FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c 
								WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND idCentroGestion=".$fila[0]." 
								AND e.situacion IN(1,2,4,5) and co.tipoContenido=3 and co.idRegistroContenidoReferencia=e.idRegistroEvento
								and c.carpetaAdministrativa=co.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tipoCarpeta;
					$lAudienciasConfirmadas=$con->obtenerListaValores($consulta);
					if($lAudienciasConfirmadas=="")
						$lAudienciasConfirmadas=-1;
					$arrEventosUGAS[$fila[2]."_".$tipoCarpeta]=$lAudienciasConfirmadas;

					$valor=$con->filasAfectadas;
				break;
				case 3:
					$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c 
								WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND idCentroGestion=".$fila[0]." 
								AND e.situacion IN(3) and co.tipoContenido=3 and co.idRegistroContenidoReferencia=e.idRegistroEvento
								and c.carpetaAdministrativa=co.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tipoCarpeta;
					$valor=$con->obtenerValor($consulta);
				break;
				case 4:
					$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c 
								WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND idCentroGestion=".$fila[0]." 
								AND e.situacion IN(6) and co.tipoContenido=3 and co.idRegistroContenidoReferencia=e.idRegistroEvento
								and c.carpetaAdministrativa=co.carpetaAdministrativa and c.tipoCarpetaAdministrativa=".$tipoCarpeta;
					$valor=$con->obtenerValor($consulta);
				break;
				case 5:
					$consulta="SELECT COUNT(*) FROM (
								SELECT (IF(horaInicioRealMAJO IS NOT NULL,TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioRealMAJO ),
								TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioReal ))) AS diferenciaInicio
								FROM 7000_eventosAudiencia WHERE idRegistroEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].") 
								AND (horaInicioReal IS NOT NULL OR 
								horaInicioRealMAJO IS NOT NULL)) AS tmp WHERE diferenciaInicio<=0";
					$valor=$con->obtenerValor($consulta);	
				break;
				case 6:
					$consulta="SELECT COUNT(*) FROM (
								SELECT (IF(horaInicioRealMAJO IS NOT NULL,TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioRealMAJO ),
								TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioReal ))) AS diferenciaInicio
								FROM 7000_eventosAudiencia WHERE idRegistroEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].") 
								AND (horaInicioReal IS NOT NULL OR 
								horaInicioRealMAJO IS NOT NULL)) AS tmp WHERE diferenciaInicio>0 and diferenciaInicio<=5";
					$valor=$con->obtenerValor($consulta);	
				break;
				case 7:
					$consulta="SELECT COUNT(*) FROM (
								SELECT (IF(horaInicioRealMAJO IS NOT NULL,TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioRealMAJO ),
								TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioReal ))) AS diferenciaInicio
								FROM 7000_eventosAudiencia WHERE idRegistroEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].") 
								AND (horaInicioReal IS NOT NULL OR 
								horaInicioRealMAJO IS NOT NULL)) AS tmp WHERE diferenciaInicio>5 and diferenciaInicio<=10";
					$valor=$con->obtenerValor($consulta);	
				break;
				case 8:
					$consulta="SELECT COUNT(*) FROM (
								SELECT (IF(horaInicioRealMAJO IS NOT NULL,TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioRealMAJO ),
								TIMESTAMPDIFF(MINUTE, horaInicioEvento,horaInicioReal ))) AS diferenciaInicio
								FROM 7000_eventosAudiencia WHERE idRegistroEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].") 
								AND (horaInicioReal IS NOT NULL OR 
								horaInicioRealMAJO IS NOT NULL)) AS tmp WHERE diferenciaInicio>10";
					$valor=$con->obtenerValor($consulta);	
				break;
				case 9:					
					$consulta="SELECT DISTINCT idEvento FROM 3013_registroResolutivosAudiencia 
								WHERE idEvento IN (".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$listaEventosResolutivos=$con->obtenerListaValores($consulta);
					if($listaEventosResolutivos=="")
						$listaEventosResolutivos=-1;
					$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia WHERE idRegistroEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].
							") AND idRegistroEvento NOT IN(".$listaEventosResolutivos.")";
					$valor=$con->obtenerValor($consulta);		
					
					
				break;
				case 10:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE tipoResolutivo IN(43,74) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 11:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(64) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 12:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(76) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 13:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(62) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 14:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(68) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 15:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(77,52) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 16:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(64,76,62,68,77,52) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
				case 17:
					$consulta="SELECT count(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE 
					tipoResolutivo IN(34,41) AND idEvento IN(".$arrEventosUGAS[$fila[2]."_".$tipoCarpeta].")";
					$valor=$con->obtenerValor($consulta);					
				break;
			}
			
			
			$o.=',"ugj_'.$fila[0].'_'.$tipoCarpeta.'":"'.$valor.'"';
			$total+=$valor;
		}
		$o.=',"total":"'.$total.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
	
	
}

function obtenerDelitosEjecucion()
{
	global $con;
	$idPena=$_POST["iP"];
	$idReferencia=$_POST["idReferencia"];
	$idActividadEjec=$_POST["iA"];
	$esActualizacionCarpeta=$_POST["esActualizacion"]==1;
	

	
	$arrRegistros="";
	$consulta="SELECT carpetaAdministrativa FROM _385_tablaDinamica WHERE id__385_tablaDinamica=".$idReferencia;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	
	$consulta="select idActividad from 7006_carpetasAdministrativas where carpetaAdministrativa='".$cAdministrativa."'";
	$idActividad=$con->obtenerValor($consulta);
	if($idActividad=="")
		$idActividad=-1;
	$nReg=0;
	$consulta="SELECT distinct id__35_denominacionDelito,d.denominacionDelito,dc.idActividad FROM 	_61_tablaDinamica dc,_35_denominacionDelito d 
				WHERE  d.id__35_denominacionDelito=dc.denominacionDelito and dc.idActividad in(".$idActividad.",".$idActividadEjec.")";
	
	if($esActualizacionCarpeta)
	{
		$consulta="SELECT distinct id__35_denominacionDelito,d.denominacionDelito,dc.idActividad FROM 	_61_tablaDinamica dc,_35_denominacionDelito d 
				WHERE  d.id__35_denominacionDelito=dc.denominacionDelito and dc.idActividad in(".$idActividadEjec.")";
	}
	

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$incluido="false";
		
		$consulta="select count(*) from 7032_delitosPena where idPena=".$idPena." and idDelito=".$fila[0];
		$tDelitos=$con->obtenerValor($consulta);
		
		$incluido=$tDelitos==0?"false":"true";
		
		
		$o='{"idDelito":"'.$fila[0].'","lblDelito":"'.$fila[1].'","incluido":'.$incluido.',"eliminable":"'.($fila[2]==$idActividadEjec?1:0).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$nReg++;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	
}

function agregarDelitoSentencia()
{
	global $con;
	$idActividad=$_POST["iA"];
	$idDelito=$_POST["iD"];
	
	$consulta="INSERT INTO _61_tablaDinamica(fechaCreacion,responsable,denominacionDelito,idActividad) VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].
			",".$idDelito.",".$idActividad.")";
	eC($consulta);
}

function removerDelitoSentencia()
{
	global $con;
	$idActividad=$_POST["iA"];
	$idDelito=$_POST["iD"];
	
	$consulta="delete from _61_tablaDinamica where denominacionDelito=".$idDelito." and idActividad=".$idActividad;
	eC($consulta);
}

function obtenerPenasSetenciaCarpetaEjecucion()
{
	global $con;
	$carpetaAdministrativa=$_POST["cA"];
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$idActividad=$con->obtenerValor($consulta);
	if($idActividad=="")
		$idActividad=-1;
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idActividadEjecucion=".$idActividad;
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _405_tablaDinamica s,_47_tablaDinamica a 
				WHERE s. idActividad=".$fila["idActividad"]." AND a.id__47_tablaDinamica=s.sentenciado";
		
		$sentenciado=$con->obtenerValor($consulta);
		
		$arrSustitutivo="";
		$lblSustitutivo="";
		$acoge=0;
		$sustitutivoAcoge="";
		$seAcogeSuspensionCondicional="";
		$permiteSuspensionCondicional="";
		
		$consulta="SELECT concedeSuspension,acogeSuspension,id__405_tablaDinamica FROM _405_tablaDinamica WHERE idActividad=".$fila["idActividad"];
		$fDatosSentenciado=$con->obtenerPrimeraFilaAsoc($consulta);
		$permiteSuspensionCondicional=$fDatosSentenciado["concedeSuspension"];
		if($permiteSuspensionCondicional==1)
		{
			if($fila["seAcogeSuspensionCondicional"]=="")
				$seAcogeSuspensionCondicional=$fDatosSentenciado["acogeSuspension"];
			else
				$seAcogeSuspensionCondicional=$fila["seAcogeSuspensionCondicional"];
		}
		
		if($fila["seAcogeSustitutivo"]!="")
		{
			$acoge=$fila["seAcogeSustitutivo"];
			$sustitutivoAcoge=$fila["idSustitutivoAcoge"];
		}
		
		$arrLblSustitutivo="";
		$consulta="SELECT * FROM 7026_registroSustitutivoPena WHERE idPena=".$fila["idRegistro"];
		$rSustitutivo=$con->obtenerFilas($consulta);
		while($fSustitutivo=$con->fetchAssoc($rSustitutivo))
		{
			$consulta="SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fSustitutivo["idSustitutivo"];	
			$lSustitutivo="- ".$con->obtenerValor($consulta);
			
			if($fSustitutivo["montoSustitutivo"]!="")
			{
				$lSustitutivo.=", Monto: $ ".number_format($fSustitutivo["montoSustitutivo"],2);
			}
			
			$pSustitutivo="[]";
			if($fSustitutivo["periodoSustitutivo"]!="")
			{
				$aPeriodo=explode("|",$fSustitutivo["periodoSustitutivo"]);
				$lSustitutivo.=", Periodo: ".$aPeriodo[0]." años, ".$aPeriodo[1]." meses, ".$aPeriodo[2]." dias ";
				$pSustitutivo="['".$aPeriodo[0]."','".$aPeriodo[1]."','".$aPeriodo[2]."']";
			}
			
			$oSustitutivo="['".$fSustitutivo["idRegistro"]."','".cv($lSustitutivo)."',".$pSustitutivo."]";
			if($arrSustitutivo=="")
				$arrSustitutivo=$oSustitutivo;
			else
				$arrSustitutivo.=",".$oSustitutivo;
			
			if($fila["seAcogeSustitutivo"]=="")
			{
				if($fSustitutivo["acogeSustitutivo"]==1)
				{
					$acoge=1;
					$sustitutivoAcoge=$fSustitutivo["idRegistro"];
				}
			}
			if($arrLblSustitutivo=="")
				$arrLblSustitutivo=$lSustitutivo;
			else
				$arrLblSustitutivo.="<br>".$lSustitutivo;
			
		}
		
		$consulta="SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fila["idPena"];	
		$descripcion='<b>'.$con->obtenerValor($consulta)."</b>";
		
		
		$objDetalle=$fila["objDetalle"];
		$periodoPena="[]";
		$lblDetallePena="";
		if($objDetalle!="")
		{
			$oDetalle=json_decode($objDetalle);
			
			if(isset($oDetalle->monto))
			{
				$lblDetallePena="Monto: $ ".number_format($oDetalle->monto);
			}
			else
			{
				$arrPena=array();
				$arrPena[0]=$oDetalle->anios;
				$arrPena[1]=$oDetalle->meses;
				$arrPena[2]=$oDetalle->dias;
				
				$totalAbono=array();
				$totalAbono[0]=0;
				$totalAbono[1]=0;
				$totalAbono[2]=0;
				
				$consulta="SELECT * FROM 7033_computoPrisionCumplida WHERE idPena=".$fila["idRegistro"];
				$rComputo=$con->obtenerFilas($consulta);
				while($fComputo=$con->fetchAssoc($rComputo))
				{
					$tComputo=array();
					$tComputo[0]=$fComputo["anios"];
					$tComputo[1]=$fComputo["meses"];
					$tComputo[2]=$fComputo["dias"];
					$totalAbono=sumarComputo($totalAbono,$tComputo);
				}
				
				$penaCompurgar=restarComputo($arrPena,$totalAbono);
				
				$lblDetallePena=", Periodo a compurgar: ".convertirLeyendaComputo($penaCompurgar);
				$periodoPena="['".$penaCompurgar[0]."','".$penaCompurgar[1]."','".$penaCompurgar[2]."']";
			}
			
		}
		
		$descripcion.=$lblDetallePena;
		
		$consulta="SELECT GROUP_CONCAT(denominacionDelito SEPARATOR '<br>- ') FROM 7032_delitosPena d,_35_denominacionDelito de 
					WHERE idPena=".$fila["idRegistro"]." AND de.id__35_denominacionDelito=d.idDelito ORDER BY denominacionDelito";
		$lDelitos="<br>- ".$con->obtenerValor($consulta);
		$descripcion.="<br><b>Delitos:</b> ".$lDelitos;
		
		$pSuspensionCondicional=$permiteSuspensionCondicional;
		if($pSuspensionCondicional==1)
		{
			$consulta="SELECT COUNT(*) FROM _405_gPenaSuspensionCondicional WHERE 
					idReferencia=".$fDatosSentenciado["id__405_tablaDinamica"]." and idPena=".$fila["idRegistro"];		
			
			$nSuspension=$con->obtenerValor($consulta);
			
			if($nSuspension==0)
			{
				$pSuspensionCondicional=0;
			}
		}
		
		$o='{"idPena":"'.$fila["idRegistro"].'","sentenciado":"'.cv($sentenciado).'","descripcion":"'.cv($descripcion).'","sustitutivos":"'.
			$arrLblSustitutivo.'","seAcoge":"'.$acoge.'","sustitutivoAcoge":"'.$sustitutivoAcoge.
			'","arrSustitutivo":['.$arrSustitutivo.'],"fechaInicio":"'.$fila["fechaInicio"].'","fechaCompurga":"'.
			$fila["fechaTermino"].'","periodoPena":'.$periodoPena.',"seAcogeSuspensionCondicional":"'.$seAcogeSuspensionCondicional.'",
			"comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).'","permiteSuspensionCondicional":"'.$pSuspensionCondicional.'"}';
		
		if(($periodoPena=="[]")&&($arrSustitutivo=="")&&$pSuspensionCondicional==0)
			continue;
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerPenasPrescripcion()
{
	global $con;
	$arrRegistros="";
	$sentenciado=$_POST["s"];
	$carpetaAdministrativa=$_POST["cA"];
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$idActividadEjecucion=$con->obtenerValor($consulta);
	if($idActividadEjecucion=="")
		$idActividadEjecucion=-1;
	
	$consulta="SELECT idActividad FROM _405_tablaDinamica WHERE idActividadEjecucion=".$idActividadEjecucion." AND sentenciado=".$sentenciado;
	$idActividad=$con->obtenerValor($consulta);
	if($idActividad=="")
		$idActividad=-1;	
	
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idActividad=".$idActividad;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _405_tablaDinamica s,_47_tablaDinamica a 
				WHERE s. idActividad=".$fila["idActividad"]." AND a.id__47_tablaDinamica=s.sentenciado";
		
		$sentenciado=$con->obtenerValor($consulta);
		
		$arrSustitutivo="";
		$lblSustitutivo="";
		$acoge=0;
		$sustitutivoAcoge="";
		$seAcogeSuspensionCondicional="";
		$permiteSuspensionCondicional="";
		
		$consulta="SELECT concedeSuspension,acogeSuspension,id__405_tablaDinamica FROM _405_tablaDinamica WHERE idActividad=".$fila["idActividad"];
		$fDatosSentenciado=$con->obtenerPrimeraFilaAsoc($consulta);
		$permiteSuspensionCondicional=$fDatosSentenciado["concedeSuspension"];
		if($permiteSuspensionCondicional==1)
		{
			if($fila["seAcogeSuspensionCondicional"]=="")
				$seAcogeSuspensionCondicional=$fDatosSentenciado["acogeSuspension"];
			else
				$seAcogeSuspensionCondicional=$fila["seAcogeSuspensionCondicional"];
		}
		
		if($fila["seAcogeSustitutivo"]!="")
		{
			$acoge=$fila["seAcogeSustitutivo"];
			$sustitutivoAcoge=$fila["idSustitutivoAcoge"];
		}
		
		$arrLblSustitutivo="";
		$consulta="SELECT * FROM 7026_registroSustitutivoPena WHERE idPena=".$fila["idRegistro"];
		$rSustitutivo=$con->obtenerFilas($consulta);
		while($fSustitutivo=$con->fetchAssoc($rSustitutivo))
		{
			$consulta="SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fSustitutivo["idSustitutivo"];	
			$lSustitutivo="- ".$con->obtenerValor($consulta);
			
			if($fSustitutivo["montoSustitutivo"]!="")
			{
				$lSustitutivo.=", Monto: $ ".number_format($fSustitutivo["montoSustitutivo"],2);
			}
			
			$pSustitutivo="[]";
			if($fSustitutivo["periodoSustitutivo"]!="")
			{
				$aPeriodo=explode("|",$fSustitutivo["periodoSustitutivo"]);
				$lSustitutivo.=", Periodo: ".$aPeriodo[0]." años, ".$aPeriodo[1]." meses, ".$aPeriodo[2]." dias ";
				$pSustitutivo="['".$aPeriodo[0]."','".$aPeriodo[1]."','".$aPeriodo[2]."']";
			}
			
			$oSustitutivo="['".$fSustitutivo["idRegistro"]."','".cv($lSustitutivo)."',".$pSustitutivo."]";
			if($arrSustitutivo=="")
				$arrSustitutivo=$oSustitutivo;
			else
				$arrSustitutivo.=",".$oSustitutivo;
			
			if($fila["seAcogeSustitutivo"]=="")
			{
				if($fSustitutivo["acogeSustitutivo"]==1)
				{
					$acoge=1;
					$sustitutivoAcoge=$fSustitutivo["idRegistro"];
				}
			}
			if($arrLblSustitutivo=="")
				$arrLblSustitutivo=$lSustitutivo;
			else
				$arrLblSustitutivo.="<br>".$lSustitutivo;
			
		}
		
		$consulta="SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fila["idPena"];	
		$descripcion=''.$con->obtenerValor($consulta)."";
		
		
		$objDetalle=$fila["objDetalle"];
		$periodoPena="[]";
		$lblDetallePena="";
		if($objDetalle!="")
		{
			$oDetalle=json_decode($objDetalle);
			
			if(isset($oDetalle->monto))
			{
				$lblDetallePena=" Monto: $ ".number_format($oDetalle->monto);
			}
			else
			{
				$arrPena=array();
				$arrPena[0]=$oDetalle->anios;
				$arrPena[1]=$oDetalle->meses;
				$arrPena[2]=$oDetalle->dias;
				
				/*$totalAbono=array();
				$totalAbono[0]=0;
				$totalAbono[1]=0;
				$totalAbono[2]=0;
				
				$consulta="SELECT * FROM 7033_computoPrisionCumplida WHERE idPena=".$fila["idRegistro"];
				$rComputo=$con->obtenerFilas($consulta);
				while($fComputo=$con->fetchAssoc($rComputo))
				{
					$tComputo=array();
					$tComputo[0]=$fComputo["anios"];
					$tComputo[1]=$fComputo["meses"];
					$tComputo[2]=$fComputo["dias"];
					$totalAbono=sumarComputo($totalAbono,$tComputo);
				}*/
				
				$penaCompurgar=$arrPena;
				
				$lblDetallePena=", Periodo a compurgar: ".convertirLeyendaComputo($penaCompurgar);
				$periodoPena="['".$penaCompurgar[0]."','".$penaCompurgar[1]."','".$penaCompurgar[2]."']";
			}
			
		}
		
		$descripcion.=$lblDetallePena;
		
		$consulta="SELECT GROUP_CONCAT(denominacionDelito SEPARATOR '<br>- ') FROM 7032_delitosPena d,_35_denominacionDelito de 
					WHERE idPena=".$fila["idRegistro"]." AND de.id__35_denominacionDelito=d.idDelito ORDER BY denominacionDelito";
		$lDelitos="- ".$con->obtenerValor($consulta);
		
		$descripcion.=", Delitos: ".$lDelitos;
		
		$o="['".$fila["idRegistro"]."','".cv($descripcion)."']";
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		
	}
	echo "1|[".$arrRegistros."]";
	
}

function obtenerInformacionPenaPrescripcion()
{
	global  $con;
	$idPena=$_POST["iP"];
	
	$fechaEjecutoria="";
	$periodoPena="";
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$idPena;
	$fPena=$con->obtenerPrimeraFilaAsoc($consulta);
	
	if($fPena["objDetalle"]!="")
	{
		$oDetalle=json_decode($fPena["objDetalle"]);
		if(isset($oDetalle->anios))
		{
			$periodoPena=$oDetalle->anios."_".$oDetalle->meses."_".$oDetalle->dias;
		}
	}
	
	$consulta="SELECT idReferencia FROM _405_tablaDinamica WHERE idActividad=".$fPena["idActividad"];
	$idReferencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT fechaEjecutoria FROM _385_tablaDinamica WHERE id__385_tablaDinamica=".$idReferencia;
	$fechaEjecutoria=$con->obtenerValor($consulta);
	
	$consulta="SELECT privativaLibertad,tipoEntrada,categoria,aniosPrescripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fPena["idPena"];
	$fDatosPena=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$esPrivativaLibertad=$fDatosPena["privativaLibertad"];
	
	if($esPrivativaLibertad==1)
	{
		$fechaEjecutoria=$fPena["fechaInicio"];
		
	}
	
	$arrSumaComputo=array();
	$arrSumaComputo[0]=0;
	$arrSumaComputo[1]=0;
	$arrSumaComputo[2]=0;
	$consulta="SELECT * FROM 7033_computoPrisionCumplida WHERE idPena=".$fPena["idRegistro"];
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$arrValores=array();
		$arrValores[0]=$fila["anios"];
		$arrValores[1]=$fila["meses"];
		$arrValores[2]=$fila["dias"];
		$arrSumaComputo=sumarComputo($arrSumaComputo,$arrValores);
	}
	
	$abonoPrisionPreventiva=$arrSumaComputo[0]."_".$arrSumaComputo[1]."_".$arrSumaComputo[2];
	
	
	
	
	$cadObj='{"esPrivativaLibertad":"'.$esPrivativaLibertad.'","fechaInicio":"'.($esPrivativaLibertad==1?"":$fechaEjecutoria).
			'","abonoPrisionPreventiva":"'.$abonoPrisionPreventiva.'","fechaTermino":"'.$fPena["fechaTermino"].
		'","fechaInicioPena":"'.$fPena["fechaInicio"].'","tipoEntrada":"'.$fDatosPena["tipoEntrada"].
		'","categoria":"'.$fDatosPena["categoria"].'","periodoPena":"'.$periodoPena.'","aniosPrescripcion":"'.
		$fDatosPena["aniosPrescripcion"].'"}';
	
	echo "1|".$cadObj;
		
	
}

function registrarPrescripcion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="";
	$idPrescripcion=-1;
	if($obj->idFormulario!=-1)
	{
		$consulta="SELECT idRegistro FROM 7034_prescripciones WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$idPrescripcion=$con->obtenerValor($consulta);
		if($idPrescripcion=="")
			$idPrescripcion=-1;
	}
	if($idPrescripcion==-1)
	{
		$consulta="INSERT INTO 7034_prescripciones(fechaCreacion,sentenciado,idPena,fechaSustraccion,abonoPrisionPreventiva,
					abonoPrisionPunitiva,fechaPrescripcion,sentenciadoEnCDMX,comentariosAdicionales,situacion,idResponsableRegistro,
					carpetaAdministrativa,abonoCumplimientoSentencia,comentariosPrisionPunitiva,idFormulario,idReferencia,fechaUltimoActoAutoridad)
					VALUES('".date("Y-m-d H:i:s")."',".$obj->sentenciado.",".$obj->idPena.",'".$obj->fechaBase."','".$obj->abonoPrisionPreventiva.
					"','".$obj->abonoPrisionPunitiva."','".$obj->fechaPrescripcion."',".$obj->sentenciadoEnCDMX.",'".
					cv($obj->comentariosAdicionales)."',1,".$_SESSION["idUsr"].",'".$obj->carpetaAdministrativa."','".
					$obj->abonoCumplimientoSentencia."','".cv($obj->comentariosPrisionPunitiva)."',".$obj->idFormulario.",".
					$obj->idRegistro.",'".$obj->fechaUltimoActo."')";
	}
	else
	{
		$consulta="update 7034_prescripciones set idPena=".$obj->idPena.",fechaSustraccion='".$obj->fechaBase."',abonoPrisionPreventiva='".$obj->abonoPrisionPreventiva."',
					abonoPrisionPunitiva='".$obj->abonoPrisionPunitiva."',fechaPrescripcion='".$obj->fechaPrescripcion."',sentenciadoEnCDMX=".$obj->sentenciadoEnCDMX.
					",abonoCumplimientoSentencia='".$obj->abonoCumplimientoSentencia."',comentariosPrisionPunitiva='".cv($obj->comentariosPrisionPunitiva).
					"',fechaUltimoActoAutoridad='".$obj->fechaUltimoActo."' where idRegistro=".$idPrescripcion;

					
	}
	
	if($con->ejecutarConsulta($consulta))
	{
		if($idPrescripcion==-1)
		{
			$consulta="select last_insert_id()";
			$idPrescripcion=$con->obtenerValor($consulta);
			
			$consulta="SELECT unidadGestion  FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->carpetaAdministrativa."'";
			$codigoUnidad=$con->obtenerValor($consulta);
			
			registrarProcesoLibroGobierno(-11,$idPrescripcion,11,date("Y-m-d H:i:s"),$codigoUnidad);
		}
		
		
		$consulta="DELETE FROM 7036_alertasNotificaciones WHERE tipoAlerta=2 AND valorReferencia1=".$idPrescripcion;
		$con->ejecutarConsulta($consulta);

		$arrValoresAlerta=array();
		$arrValoresAlerta["carpetaAdministrativa"]=$obj->carpetaAdministrativa;
		$arrValoresAlerta["descripcion"]="Fecha de prescripción alcanzada";
		$arrValoresAlerta["valorReferencia1"]=$idPrescripcion;
		$arrValoresAlerta["valorReferencia2"]="";
		$arrValoresAlerta["tipoAlerta"]=2;
		$arrValoresAlerta["fechaAlerta"]=$obj->fechaPrescripcion;
		
		registrarAlertaNotificacionSistema($arrValoresAlerta);
		echo "1|";
	}
}

function cancelarPrescripcion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="UPDATE 7034_prescripciones SET fechaCancelacion='".date("Y-m-d H:i:s")."',idResponsableCancelacion=".$_SESSION["idUsr"].
				",motivoCancelacion='".cv($obj->motivoCancelacion)."',situacion=2 WHERE idRegistro=".$obj->idPrescripcion;

	if($con->ejecutarConsulta($consulta))
	{
		$consulta="select idRegistro FROM 7036_alertasNotificaciones WHERE tipoAlerta=2 AND valorReferencia1=".$obj->idPrescripcion;
		$idNotificacion=$con->obtenerValor($consulta);
		$arrValoresAlerta=array();
		$arrValoresAlerta["idRegistro"]=$idNotificacion;
		$arrValoresAlerta["motivoCancelacion"]="Prescripción cancelada";
		
		cancelarAlertaNotificacionSistema($arrValoresAlerta);
		echo "1|";
	}
}

function obtenerPrescripciones()
{
	global $con;
	$arrRegistros="";
	$carpetaAdministrativa=$_POST["cA"];
	$consulta="SELECT * FROM 7034_prescripciones WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY fechaCreacion desc";
	$res=$con->obtenerFilas($consulta);
	$numReg=0;
	while($fila=$con->fetchAssoc($res))
	{	
		$consulta="SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) FROM _47_tablaDinamica a 
				WHERE a.id__47_tablaDinamica=".$fila["sentenciado"];
		
		$sentenciado=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$fila["idPena"];
		$filaPena=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT pena,tipoEntrada,privativaLibertad FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$filaPena["idPena"];	
		
		$fConfPena=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$descripcion='<b>'.$fConfPena["pena"].'</b>';
		$esPrivativaLibertad=$fConfPena["privativaLibertad"];
		$tipoEntrada=$fConfPena["tipoEntrada"];
		$objDetalle=$filaPena["objDetalle"];
		$periodoCompurga="";
		$periodoPena="[]";
		$lblDetallePena="";
		if($objDetalle!="")
		{
			$oDetalle=json_decode($objDetalle);
			
			if(isset($oDetalle->monto))
			{
				$lblDetallePena=", Monto: $ ".number_format($oDetalle->monto);
			}
			else
			{
				$arrPena=array();
				$arrPena[0]=$oDetalle->anios;
				$arrPena[1]=$oDetalle->meses;
				$arrPena[2]=$oDetalle->dias;
				
				$periodoCompurga=$arrPena[0]."_".$arrPena[1]."_".$arrPena[2];
				
				$lblDetallePena=", Periodo a compurgar: ".convertirLeyendaComputo($arrPena);
				
			}
			
		}
		
		$descripcion.=$lblDetallePena;
		
		$o='{"idPrescripcion":"'.$fila["idRegistro"].'","sentenciado":"'.cv($sentenciado).'","fechaPrescripcion":"'.$fila["fechaPrescripcion"].
			'","fechaRegistro":"'.$fila["fechaCreacion"].'","situacion":"'.$fila["situacion"].'","responsableRegistro":"'.
			obtenerNombreUsuario($fila["idResponsableRegistro"]).'","canceladoPor":"'.
			cv(obtenerNombreUsuario($fila["idResponsableCancelacion"]==""?-1:$fila["idResponsableCancelacion"])).'","fechaCancelacion":"'.
			$fila["fechaCancelacion"].'","motivoCancelacion":"'.cv($fila["motivoCancelacion"]).'","pena":"'.cv($descripcion).'","fechaSustraccion":"'.$fila["fechaSustraccion"].'",
			"abonoPrisionPreventiva":"'.$fila["abonoPrisionPreventiva"].'","abonoPrisionPunitiva":"'.$fila["abonoPrisionPunitiva"].
			'","sentenciadoEnCDMX":"'.$fila["sentenciadoEnCDMX"].'","comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).'",
			"esPrivativaLibertad":"'.$esPrivativaLibertad.'","tipoEntrada":"'.$tipoEntrada.'","fechaInicioPena":"'.$filaPena["fechaInicio"].
			'","abonoCumplimientoSentencia":"'.$fila["abonoCumplimientoSentencia"].'","comentariosPrisionPunitiva":"'.
			cv($fila["comentariosPrisionPunitiva"]).'","periodoCompurga":"'.$periodoCompurga.'","idFormulario":"'.$fila["idFormulario"].
			'","idReferencia":"'.$fila["idReferencia"].'","fechaUltimoActoAutoridad":"'.$fila["fechaUltimoActoAutoridad"].'"}';
		if($arrRegistros=="")
			
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerPlantillasModeloV2()
{
	global $con;
	$carpetaAdministrativa="";
	$idCarpeta="";
	
	$idFormulario=-1;
	$idRegistro=-1;
	$actor=-1;
	if(isset($_POST["idFormulario"]))
		$idFormulario=$_POST["idFormulario"];
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	
	if(isset($_POST["actor"]))
		$actor=$_POST["actor"];
	
	if(isset($_POST["carpetaAdministrativa"]))
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		
	if(isset($_POST["idCarpeta"]))
		$idCarpeta=$_POST["idCarpeta"];
	
	$idPerfil=-1;
	$idProceso=-1;
	
	$tipoUnidad=-1;
	$listaDocumentos=-1;
	$versionPlantilla=2;
	if($idRegistro!=-1)
	{
		$versionPlantilla=4;
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT tipoDelito FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u,_17_gridDelitosAtiende d WHERE u.claveUnidad=c.unidadGestion
					AND carpetaAdministrativa='".$carpetaAdministrativa."' AND d.idReferencia=u.id__17_tablaDinamica";
		$tipoUnidad=$con->obtenerListaValores($consulta,"'");
		if($tipoUnidad=="")
			$tipoUnidad="-1";
	}
	else
	{
		if($carpetaAdministrativa!="")
		{
			

			$versionPlantilla=4;	
			$consulta="SELECT tipoDelito FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u,_17_gridDelitosAtiende d WHERE u.claveUnidad=c.unidadGestion
					AND carpetaAdministrativa='".$carpetaAdministrativa."' AND d.idReferencia=u.id__17_tablaDinamica";
			if(($idCarpeta!="")&&($idCarpeta!="-1"))
				$consulta.=" and idCarpeta=".$idCarpeta;	
				
			$tipoUnidad=$con->obtenerListaValores($consulta,"'");
			if($tipoUnidad=="")
				$tipoUnidad="-1";	
				
		}
	}
	
	
	
	
	
	
	
	if($idProceso!=-1)
	{
		if($actor!=-1)
		{
			$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
			$rol=$con->obtenerValor($consulta);
			$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$rol,true);
			
			$consulta="SELECT idFormato FROM  3019_generacionDocumentosPermitidos WHERE idProceso=".$idProceso." AND idPerfil=".$idPerfil;
			$listaDocumentos=$con->obtenerListaValores($consulta);
			if($listaDocumentos=="")
				$listaDocumentos=-1;
		}
		
	}

	$arrRegistros="";
	$consulta=" SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos where idCategoria not in(0) ORDER BY nombreCategoria";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrHijos="";		
	
		
		$consulta="SELECT id__10_tablaDinamica,nombreFormato,descripcion,perfilValidacion,funcionJSParametros FROM _10_tablaDinamica f,_10_chkVersionPlantilla v 
					WHERE f.categoriaDocumento=".$fila[0]." AND v.idPadre=f.id__10_tablaDinamica AND v.idOpcion IN(".$versionPlantilla.") ".
					($listaDocumentos!=-1?" and id__10_tablaDinamica in(".$listaDocumentos.")":"")."
					ORDER BY nombreFormato ";

		
		if($tipoUnidad!=-1)
		{
			$consulta="SELECT id__10_tablaDinamica,nombreFormato,descripcion,perfilValidacion,funcionJSParametros FROM _10_tablaDinamica f,_10_chkVersionPlantilla v,
					_10_tiposUGJ tU WHERE f.categoriaDocumento=".$fila[0]." AND v.idPadre=f.id__10_tablaDinamica AND v.idOpcion IN(".$versionPlantilla.") 
					and tU.idPadre=f.id__10_tablaDinamica and tU.idOpcion in(".$tipoUnidad.") ".($listaDocumentos!=-1?" and id__10_tablaDinamica in(".$listaDocumentos.")":"")." ORDER BY nombreFormato ";
		}
        

		
		$rDocumentos=$con->obtenerFilas($consulta);
		while($fDocumentos=$con->fetchAssoc($rDocumentos))
		{
			$oDoc='{"cls":"cssNodoArbolNivel2","tipoNodo":"2","icon":"../images/s.gif","id":"'.$fDocumentos["id__10_tablaDinamica"].'","text":"'.cv($fDocumentos["nombreFormato"]).
					'","perfilValidacion":"'.($fDocumentos["perfilValidacion"]==""?-1:$fDocumentos["perfilValidacion"]).'","descripcion":"'.
					cv($fDocumentos["descripcion"]).'","leaf":true,"children":[],"funcionJSParametros":"'.$fDocumentos["funcionJSParametros"].'"}';
			if($arrHijos=="")
				$arrHijos=$oDoc;
			else
				$arrHijos.=",".$oDoc;
		}
		
		if($arrHijos=="")
			continue;
		
		$o='{"cls":"cssNodoArbolNivel1","tipoNodo":"1","icon":"../images/s.gif","id":"c_'.$fila[0].'","text":"'.$fila[1].'","descripcion":"",leaf:'.($arrHijos==""?"true":"false").',children:['.$arrHijos.']}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '['.$arrRegistros.']';
}

function obtenerPlantillaDocumentoV2()
{
	global $con;
	$idDocumento=$_POST["iD"];
	$consulta="SELECT txtPlantillaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$idDocumento;
	$cuerpoDocumento=bE($con->obtenerValor($consulta));
	echo '1|{"cuerpoDocumento":"'.$cuerpoDocumento.'"}';
	
}

function registrarInformacionDocumentoV2()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$idPerfilEvaluacion=-1;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$categoriaDocumento=-1;
	if(isset($obj->categoriaDocumento))
		$categoriaDocumento=$obj->categoriaDocumento;
		
	$datosParametros="";
	if(isset($obj->datosParametros))
		$datosParametros=bE($obj->datosParametros);	
	
	$configuracionDocumento="";
	if(isset($obj->configuracionDocumento))
		$configuracionDocumento=$obj->configuracionDocumento;	

	
		
	if($obj->idGeneracionDocumento==-1)
	{
		$idFormularioProceso=-1;
		if(isset($obj->idFormularioProceso))
			$idFormularioProceso=$obj->idFormularioProceso;
		
		
		$consulta[$x]="INSERT INTO 7035_informacionDocumentos(fechaCreacion,idResponsableCreacion,tipoDocumento,tituloDocumento,
				fechaLimiteCumplimiento,modificaSituacionCarpeta,situacionCarpeta,descripcionActuacion,carpetaAdministrativa,
				situacionDocumento,perfilValidacion,idFormulario,idReferencia,idFormularioProceso,datosParametros)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoDocumento.",'".cv($obj->tituloDocumento).
					"',".($obj->fechaLimite==""?"NULL":"'".$obj->fechaLimite."'").",".$obj->modificaSituacionCarpeta.",
				".($obj->situacion==""?"NULL":$obj->situacion).",'".cv($obj->descripcionActuacion)."','".$obj->carpetaAdministrativa.
				"',1,".$obj->perfilValidacion.",".$obj->idFormulario.",".$obj->idRegistro.",".$idFormularioProceso.",'".($datosParametros)."')";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		if(isset($obj->nombreArchivoTemp)&&(isset($obj->nombreArchivoTemp)!=""))
		{
			$query="SELECT perfilValidacion,categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$obj->tipoDocumento;
			$fPerfilDatos=$con->obtenerPrimeraFila($query);
			$idPerfilEvaluacion=$fPerfilDatos[0];
			if($idPerfilEvaluacion=="")
				$idPerfilEvaluacion=-1;
			
			$idDocumento=registrarDocumentoServidorRepositorio($obj->nombreArchivoTemp,$obj->nombreArchivo,($categoriaDocumento==-1?$fPerfilDatos[1]:$categoriaDocumento),"");
	
			$consulta[$x]="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,cuerpoFormato,
							idFormulario,idRegistro,idReferencia,firmado,cadenaFirma,formatoPDF,idFormularioProceso,
							idPerfilEvaluacion,idDocumentoAdjunto,configuracionDocumento)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoDocumento.",'',-2,@idRegistro,@idRegistro,
					0,'','',".$idFormularioProceso.",".$idPerfilEvaluacion.",".$idDocumento.",'".$configuracionDocumento."')";
			$x++;		
			$consulta[$x]="set @idRegistroFormato:=(select last_insert_id())";
			$x++;
			
		}
		
	}
	else
	{
		$consulta[$x]="update 7035_informacionDocumentos set fechaModificacion='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"].
				",tituloDocumento='".cv($obj->tituloDocumento)."',fechaLimiteCumplimiento=".($obj->fechaLimite==""?"NULL":"'".$obj->fechaLimite."'").
				",modificaSituacionCarpeta=".$obj->modificaSituacionCarpeta.",situacionCarpeta=".($obj->situacion==""?"NULL":$obj->situacion).
				",descripcionActuacion='".cv($obj->descripcionActuacion)."',carpetaAdministrativa='".$obj->carpetaAdministrativa.
				"',datosParametros='".$datosParametros."' where idRegistro=".$obj->idGeneracionDocumento;
		$x++;
		
		
		
		
		if(isset($obj->nombreArchivoTemp)&&(isset($obj->nombreArchivoTemp)!=""))
		{
			$query="SELECT perfilValidacion,categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$obj->tipoDocumento;
			$fPerfilDatos=$con->obtenerPrimeraFila($query);
			$idPerfilEvaluacion=$fPerfilDatos[0];
			if($idPerfilEvaluacion=="")
				$idPerfilEvaluacion=-1;
			
			$idDocumento=registrarDocumentoServidorRepositorio($obj->nombreArchivoTemp,$obj->nombreArchivo,($categoriaDocumento==-1?$fPerfilDatos[1]:$categoriaDocumento),"");

			$consulta[$x]="update 3000_formatosRegistrados set configuracionDocumento='".$configuracionDocumento.
							"',tipoFormato=".$obj->tipoDocumento.",cuerpoFormato='',
							idPerfilEvaluacion=".$idPerfilEvaluacion.",idDocumentoAdjunto=".$idDocumento." where  
							idFormulario=-2 and idRegistro=".$obj->idGeneracionDocumento;
			$x++;		
			
			
		}
		
	}
	
	$consulta[$x]="delete from 7035_alertaDocumentos where idRegistroDocumento=@idRegistro";
	$x++;
	foreach($obj->arrAlertas as $a)
	{
		$consulta[$x]="INSERT INTO 7035_alertaDocumentos(idRegistroDocumento,fechaAlerta,descripcionAlerta) 
					VALUES(@idRegistro,'".$a->fechaAlerta."','".cv($a->textoAlerta)."')";
		$x++;
	}
	
	$consulta[$x]="commit";
	$x++;
	
	$idRegistroFormato=-1;

	
	if($con->ejecutarBloque($consulta))
	{
		
		if($obj->idGeneracionDocumento==-1)
		{
			$query="select @idRegistro";
			$obj->idGeneracionDocumento=$con->obtenerValor($query);
			
			if(isset($obj->nombreArchivoTemp)&&(isset($obj->nombreArchivoTemp)!=""))
			{
				$query="select @idRegistroFormato";
				$idRegistroFormato=$con->obtenerValor($query);
				
				if($idPerfilEvaluacion!=-1)		
				{
					$consulta="SELECT noEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND etapaInicial=1";
					$etapaCambio=$con->obtenerValor($consulta);				
					
					$rolActual=obtenerRolActualDocumento($obj,$idPerfilEvaluacion,$etapaCambio,-1);
					cambiarSituacionDocumento($idRegistroFormato,$rolActual,$etapaCambio,"",$rolActual,0,0);
				}
			}
		}
		
		
		foreach($obj->arrAlertas as $a)
		{
			$arrValoresAlerta=array();
			$arrValoresAlerta["carpetaAdministrativa"]=$obj->carpetaAdministrativa;
			$arrValoresAlerta["descripcion"]=$a->textoAlerta;
			$arrValoresAlerta["valorReferencia1"]=$obj->idGeneracionDocumento;
			$arrValoresAlerta["valorReferencia2"]="";
			$arrValoresAlerta["tipoAlerta"]=1;
			$arrValoresAlerta["fechaAlerta"]=$a->fechaAlerta;
			registrarAlertaNotificacionSistema($arrValoresAlerta);
		}
		
		echo "1|".$obj->idGeneracionDocumento."|".$idRegistroFormato;
	}
	
}

function obtenerDocumentosGeneradosCarpeta()
{
	global $con;
	$noEtapa="";
	$carpetaAdministrativa=isset($_POST["cA"])?$_POST["cA"]:"";
	$idFormulario=$_POST["idFormulario"];
	$idReferencia=$_POST["idReferencia"];
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT * FROM _1289_tablaDinamica WHERE iFormulario=".$idFormulario." and iRegistro=".$idReferencia." and idEstado<>0 ";
	if($carpetaAdministrativa!="")
		$consulta.=" and carpetaAdministrativa='".$carpetaAdministrativa."'";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=1289 AND idReferencia=".$fila["id__1289_tablaDinamica"];
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		
		$consulta="SELECT concat(numEtapa,'.- ',nombreEtapa) FROM 4037_etapas WHERE idProceso=429 AND numEtapa=".$fila["idEstado"];
		$lblEtapaActual=$con->obtenerValor($consulta);
			
		$consulta="SELECT * FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$idRegistro;
		$fFormatoRegistrado=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fila["tipoDocumento"];
		$lblNombreFormato=$con->obtenerValor($consulta);
		$oReg='{"idDocumento":"'.$fila["id__1289_tablaDinamica"].'","tipoDocumento":"'.cv($lblNombreFormato).'","fechaCreacion":"'.$fila["fechaCreacion"].
				'","responsableCreacion":"'.obtenerNombreUsuario($fila["responsable"]).'","situacion":"'.cv($lblEtapaActual).
				'","idDocumentoServidor":"'.$fFormatoRegistrado["idDocumento"].'","documentoBloqueado":"'.($fFormatoRegistrado?$fFormatoRegistrado["documentoBloqueado"]:0).'"}';
		if($arrRegistros=="")
			$arrRegistros=$oReg;
		else
			$arrRegistros.=",".$oReg;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function removerDocumentoGeneradoCarpeta()
{
	global $con;
	$idDocumento=$_POST["iD"];
	
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	$consulta[$x]="UPDATE _1289_tablaDinamica SET idEstado=0 WHERE id__1289_tablaDinamica=".$idDocumento;
	$x++;
	
	$consulta[$x]="UPDATE 7035_informacionDocumentos SET situacionDocumento=0,fechaModificacion='".date("Y-m-d H:i:s").
			"',idResponsableModificacion=".$_SESSION["idUsr"]." WHERE idFormulario=1289 and idReferencia=".$idDocumento;
	$x++;
	$consulta[$x]="commit";
	$x++;
	
	
	
	eB($consulta);
}

function marcarDocumentoFirmadoGeneradoCarpeta()
{
	global $con;
	$idDocumento=$_POST["iD"];
	$consulta="UPDATE 7035_informacionDocumentos SET situacionDocumento=100 WHERE idRegistro=".$idDocumento;
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="SELECT modificaSituacionCarpeta,situacionCarpeta,carpetaAdministrativa FROM 7035_informacionDocumentos WHERE idRegistro=".$idDocumento;
		$fInformacion=$con->obtenerPrimeraFila($consulta);
		if($fInformacion[0]==1)
		{
			registrarCambioSituacionCarpeta($fInformacion[2],$fInformacion[1],-2,$idDocumento,-1);
		}
		echo "1|";
	}
}

function obtenerEstructuraOrganizacionalUGA()
{
	global $con;
	$iUG=$_POST["iUG"];
	$consulta="SELECT idPadre FROM _420_unidadGestion WHERE idOpcion=".$iUG;
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil=-1;

	$arrHijos="";
	$consulta="SELECT claveNivel,puestoOrganozacional,usuarioAsignado FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND tipoNivel=1";
	$fila=$con->obtenerPrimeraFila($consulta);
	$nombrePuesto="NO DEFINIDO";
	$empleado='<span style="color:#F00 !important; font-weight:bold">VACANTE</span>';
	$datosContacto="(Sin datos de contacto)";
	if($fila)
	{
		$consulta="SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=".$fila[1];
		$nombrePuesto=$con->obtenerValor($consulta);
		if($fila[2]!="")
			$empleado='<span style="color:#030 !important; font-weight:bold">'.obtenerNombreUsuario($fila[2]).'</span>';
			
		$arrHijos=obtenerNodosHijosEstructuraUGA($idPerfil,$fila[0]);
		
	}
	
	$tbTabla='<table><tr><td><span id="puesto_'.$fila[0].'">'.$empleado.'<span></td></tr><tr><td><span style="color:#000; font-size:11px; font-weight:bold">'.cv($nombrePuesto).'</span></td></tr><tr><td><span id="contacto_'.$fila[0].'" style="color:#777; font-size:10px">'.cv($datosContacto).'</span></td></tr></table>';
	$tblNodo='<table style="min-height:50px"><tr><td vaign="top"><img src="../images/No_foto.png" width="50" height="50"></td><td vaign="top">'.$tbTabla.'</td></tr></table>';
	$o='{"link":{href:\'javascript:nodoClick(\\\''.$idPerfil."_".$fila[0].'_'.($fila[2]==''?-1:$fila[2]).'_'.($fila[2]==''?'':bE(obtenerNombreUsuario($fila[2])))."_".bE($nombrePuesto).'\\\')\'}, "HTMLid":"'.$idPerfil."_".$fila[0].'","innerHTML":"'.cv($tblNodo).'","stackChildren":true,collapsable :true,"children":['.$arrHijos.']}';
	
	echo "1|".$o;
}

function obtenerNodosHijosEstructuraUGA($idPerfil,$iPuesto)
{
	global $con;
	
	$arrRegistros="";
	$consulta="SELECT claveNivel,(SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=pE.puestoOrganozacional) AS puestoOrganozacional,usuarioAsignado 
			FROM _421_tablaDinamica pE WHERE idReferencia=".$idPerfil." AND claveNivel LIKE '".$iPuesto."____' AND situacion=1 ORDER BY claveNivel";
	$res=$con->obtenerFilas($consulta);		
	while($fila=$con->fetchRow($res))
	{
		$arrHijos=obtenerNodosHijosEstructuraUGA($idPerfil,$fila[0]);
		
		$nombrePuesto="NO DEFINIDO";
		if($fila[1]!="")
			$nombrePuesto=$fila[1];
		$empleado='<span style="color:#F00 !important; font-weight:bold">VACANTE</span>';
		if($fila[2]!="")
			$empleado='<span style="color:#030 !important; font-weight:bold">'.obtenerNombreUsuario($fila[2]).'</span>';
		$datosContacto="(Sin datos de contacto)";
		
		$tbTabla='<table><tr><td><span id="puesto_'.$fila[0].'">'.$empleado.'</span></td></tr><tr><td><span style="color:#000; font-size:11px; font-weight:bold">'.cv($nombrePuesto).'</span></td></tr><tr><td><span id="contacto_'.$fila[0].'" style="color:#777; font-size:10px">'.cv($datosContacto).'</span></td></tr></table>';
		$tblNodo='<table style="min-height:50px"><tr><td vaign="top"><img src="../images/No_foto.png" width="50" height="50"></td><td vaign="top">'.$tbTabla.'</td></tr></table>';
		$o='{"link":{href:\'javascript:nodoClick(\\\''.$idPerfil."_".$fila[0].'_'.($fila[2]==''?-1:$fila[2]).'_'.($fila[2]==''?'':bE(obtenerNombreUsuario($fila[2])))."_".bE($nombrePuesto).'\\\')\'},"HTMLid":"'.$idPerfil."_".$fila[0].'","innerHTML":"'.cv($tblNodo).'","stackChildren":true,collapsable :true'.($arrHijos==""?"":",children:[".$arrHijos."]").'}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	return $arrRegistros;
	
	
}

function obtenerClasificacionTipoDelitoCarpeta()
{
	global $con;
	
	$carpetaAdministrativa=$_POST["cA"];
	
	$consulta="SELECT tipoDelito FROM _17_gridDelitosAtiende d,_17_tablaDinamica u,7006_carpetasAdministrativas c 
				WHERE d.idReferencia=u.id__17_tablaDinamica AND u.claveUnidad=c.unidadGestion AND 
				c.carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoDelito=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoMateria,c.idFormulario,c.idRegistro FROM _17_tablaDinamica u,7006_carpetasAdministrativas c WHERE 
					 u.claveUnidad=c.unidadGestion AND c.carpetaAdministrativa='".$carpetaAdministrativa."'";
	$filaDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	$tipoMateria=$filaDatosCarpeta[0];
	$tipoMateriaV2=$tipoMateria;
	if($tipoMateria==2)
		$tipoMateria=1;
	
	$fiscaliaAsociada=-1;
	if($filaDatosCarpeta[1]==46)
	{
		$consulta="SELECT claveFiscalia FROM _100_tablaDinamica WHERE  idReferencia=".$filaDatosCarpeta[2];
		$fiscaliaAsociada=$con->obtenerValor($consulta);
		if($fiscaliaAsociada=="")
			$fiscaliaAsociada=-1;
	}
	$objDelito='{"tipoDelito":"'.$tipoDelito.'","tipoMateria":"'.$tipoMateriaV2.'","fiscaliaAsociada":"'.$fiscaliaAsociada.'"}';
	
	echo "1|".$tipoDelito."|".$tipoMateria."|".$fiscaliaAsociada."|".$objDelito;
	
}

function turnarDocumento()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$resultadoEvaluacion=0;
	if(isset($obj->resultadoEvaluacion))
		$resultadoEvaluacion=$obj->resultadoEvaluacion;
	if(cambiarSituacionDocumento($obj->idDocumento,$obj->actor,$obj->etapaCambio,$obj->comentarios,$obj->rolActual,$resultadoEvaluacion,$obj->usuarioDestino))
		echo "1|";
}

function obtenerHistorialDocumento()
{
	global $con;
	$iD=$_POST["iD"];
	$arrRegistros="";
	$nReg=0;
	$consulta="SELECT  idPerfilEvaluacion FROM 3000_formatosRegistrados f WHERE f.idRegistroFormato=".$iD;
	$idPerfilEvaluacion=$con->obtenerValor($consulta);
	
	$consulta="SELECT * FROM 3000_bitacoraFormatos WHERE idRegistroFormato=".$iD." ORDER BY fechaCambio DESC";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT tituloEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND noEtapa=".$fila["idEstadoActual"];
		$etapaCambio=$con->obtenerValor($consulta);
		
		$consulta="SELECT tituloEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND noEtapa=".$fila["idEstadoAnterior"];
		$etapaOriginal=$con->obtenerValor($consulta);
		if($fila["idEstadoAnterior"]==0)
			$etapaOriginal="(Sin antecedente)";
		
		$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaOperacion":"'.$fila["fechaCambio"].'","etapaOriginal":"'.cv($etapaOriginal).
				'","etapaCambio":"'.cv($etapaCambio).'","responsable":"'.cv(obtenerNombreUsuario($fila["responsableCambio"])).
			' ('.obtenerTituloRol($fila["rolActual"]).')","comentarios":"'.cv($fila["comentariosAdicionales"]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
}

function marcarTareaDocumentoRealizada()
{
	global $con;
	$idActividad=$_POST["iA"];
	$idTablero=$_POST["iT"];
	marcarTareaAtendida($idActividad,$idTablero);
	echo "1|";
}

function obtenerDocumentoFinalPDFEditorFormato()
{
	global $con;
	$iDocumento=$_POST["iD"];
	
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$iDocumento;
	$nombreArchivo=$con->obtenerValor($consulta);
	echo "1|".$iDocumento."|".$nombreArchivo;
	
}

function aperturarCapturaResolutivos()
{
	global $con;
	$idEvento=$_POST["iE"];
	$consulta="UPDATE 3014_registroResutadoAudiencia SET situacion=0 WHERE idEvento=".$idEvento;
	eC($consulta);
}

function obtenerHistorialCambiosCarpeta()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	
	$consulta="SELECT idRegistro,fechaCambio,situacionAnterior AS idEstadoAnterior,detalleSituacionAnterior,situacionActual AS idEstadoActual,
				detalleSituacion,(SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) 
				FROM _47_tablaDinamica WHERE id__47_tablaDinamica=b.idParticipante) as nombreImputado,
				comentariosAdicionales,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=b.responsableCambio) AS responsableCambio
				 FROM 7005_bitacoraCambiosFigurasJuridicas b WHERE idActividad=".$idActividad." AND  situacionActual>5
				 ORDER BY fechaCambio DESC";
	
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
}

function registrarCambioStatusCarpeta()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$arrImputados=explode(",",$obj->imputado);
	
	foreach($arrImputados as $i)
	{
		registrarCambioSituacionImputado($obj->carpetaAdministrativa,$obj->idCarpeta,$i,$obj->statusImputado,$obj->detalleStatus,$obj->motivoCambio);
	}
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		determinarSituacionCarpeta($obj->carpetaAdministrativa,$obj->idCarpeta);
		echo "1|";
	}
	
	
}

function formatearExposicionDiligencia()
{
	global $con;
	global $arrMesLetra;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
		
	
	$consulta="SELECT carpetaAdministrativa FROM 7028_actaNotificacion WHERE idRegistro=".$obj->idActa;
	$cAdministrativa=$con->obtenerValor($consulta);
		
	$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$tCarpeta=$con->obtenerValor($consulta);
	
	$fDiligencia=strtotime($obj->fechaDiligencia);
	$fDeterminacion=strtotime($obj->fecha);
	$arrValores=array();
	
	$arrValores["diaDiligencia"]=date("d",$fDiligencia);
	$arrValores["mesDiligencia"]=$arrMesLetra[(date("m",$fDiligencia)*1)-1];
	$arrValores["anioDiligencia"]=date("Y",$fDiligencia);
	$arrValores["diaDeterminacion"]=date("d",$fDeterminacion);
	$arrValores["mesDeterminacion"]=$arrMesLetra[(date("m",$fDeterminacion)*1)-1];
	$arrValores["anioDeterminacion"]=date("Y",$fDeterminacion);
	
	$arrValores["fechaDiligencia"]=$arrValores["diaDiligencia"]." de ".$arrValores["mesDiligencia"]." de ".$arrValores["anioDiligencia"];
	$arrValores["fechaDeterminacion"]=$arrValores["diaDeterminacion"]." de ".$arrValores["mesDeterminacion"]." de ".$arrValores["anioDeterminacion"];
	
	$consulta="SELECT medioNotificacion FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$obj->idMedio;
	$medio1=$con->obtenerValor($consulta);
	$consulta="SELECT descripcion FROM _415_gEspecificaciones WHERE idReferencia=".$obj->idMedio." AND idDetalle=".($obj->detalle1==""?-1:$obj->detalle1);
	$medio2=$con->obtenerValor($consulta);
	$consulta="SELECT descripcion FROM _415_gEspecificaciones WHERE idDetalle=".($obj->detalle2==""?-1:$obj->detalle2);
	$medio3=$con->obtenerValor($consulta);
	$arrValores["medio1"]=$medio1;
	$arrValores["medio2"]=$medio2;
	$arrValores["medio3"]=$medio3;
	$arrValores["medioOtro"]=$obj->detalle3;
	
	if($arrValores["medioOtro"]!="")
	{
		if($arrValores["medio3"]=="OTRO")
			$arrValores["medio3"]=$arrValores["medioOtro"];
		if($arrValores["medio2"]=="OTRO")
			$arrValores["medio2"]=$arrValores["medioOtro"];
	}

	$arrValores["nombreDestinatario"]=$obj->nombreParte;
	$arrValores["seNotifico"]=$obj->resultado;
	$arrValores["citatorio"]=$obj->citatorio!=1?0:1;
	
	
	
	$textoFinal="";
	$consulta="SELECT * FROM _436_tablaDinamica WHERE tipoNotificacion=".$obj->tipoDiligencia." AND medioNotificacion=".$obj->idMedio.
				" AND detalleMedioNotificacion=".($obj->detalle1==""?-1:$obj->detalle1)." AND detalleMedio2=".($obj->detalle2==""?-1:$obj->detalle2).
				" AND parteProcesal=".$obj->parteProcesal." AND detalleParteProcesal=".($obj->detalleParteProcesal==""?-1:$obj->detalleParteProcesal);

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$aplica=true;
		
		if(($fila["funcionAPlicacion"]!="")&&($fila["funcionAPlicacion"]!="-1"))
		{
			$cache=NULL;
			$objParametros=$obj;
			$resultadoFuncion=removerComillasLimite(resolverExpresionCalculoPHP($fila["funcionAPlicacion"],$objParametros,$cache));
			$aplica=$resultadoFuncion==1;
			
		}
		
		if($aplica)
		{
			$txtDiligencia=$fila["txtDiligencia"];
			foreach($arrValores as $llave=>$valor)
			{
				$txtDiligencia=str_replace("[".$llave."]",$valor,$txtDiligencia);
			}
			if($tCarpeta!=6)
				$txtDiligencia=str_replace("Unidad de Gestión Judicial Especializada en Ejecución de Sanciones Penales","Unidad de Gestión Judicial",$txtDiligencia);
			

			if($textoFinal=="")
				$textoFinal=$txtDiligencia;
			else
				$textoFinal.="<br><br>".$txtDiligencia;
		}
	}
	
	echo '1|{"exposicionDiligencia":"'.bE($textoFinal).'"}';
	
}

function obtenerDatosPrescripcion()
{
	global $con;
	$iP=$_POST["iP"];
	$consulta="SELECT * FROM 7034_prescripciones WHERE idRegistro=".$iP;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$pena=formatearPena($fRegistro["idPena"]);
	$o='{"sentenciado":"'.cv(obtenerNombreImplicado($fRegistro["sentenciado"])).'","pena":"'.cv($pena).'","fechaSustraccion":"'.$fRegistro["fechaSustraccion"].
		'","abonoPrisionPreventiva":"'.$fRegistro["abonoPrisionPreventiva"].'","abonoPrisionPunitiva":"'.$fRegistro["abonoPrisionPunitiva"].
		'","fechaPrescripcion":"'.$fRegistro["fechaPrescripcion"].'","sentenciadoEnCDMX":"'.$fRegistro["sentenciadoEnCDMX"].
		'","comentariosAdicionales":"'.cv($fRegistro["comentariosAdicionales"]).'","carpetaAdministrativa":"'.$fRegistro["carpetaAdministrativa"].
		'","abonoCumplimientoSentencia":"'.$fRegistro["abonoCumplimientoSentencia"].'","comentariosPrisionPunitiva":"'.$fRegistro["comentariosPrisionPunitiva"].'"}';
	
	echo "1|".$o;
}

function cambiarStatusAlertaNotificacion()
{
	global $con;
	$iA=$_POST["iA"];
	$s=$_POST["s"];
	$c=$_POST["c"];
	$arrValores=array();
	$arrValores["idRegistro"]=$iA;
	$arrValores["comentariosAdicionales"]=$c;
	$arrValores["motivoCancelacion"]=$c;
	if($s==3)
		marcarAlertaNotificacionSistema($arrValores);
	else
		cancelarAlertaNotificacionSistema($arrValores);
	echo "1|";
}


function registarAlertaNotificacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$arrValores=array();
	
	$arrValores["carpetaAdministrativa"]=$obj->carpetaAdministrativa;
	$arrValores["descripcion"]=$obj->comentarios;
	$arrValores["valorReferencia1"]=-1;
	$arrValores["valorReferencia2"]="";
	$arrValores["tipoAlerta"]=$obj->categoriaAlerta;
	$arrValores["diasRecordatorios"]=$obj->diasRecordatorios;
	
	if(isset($obj->tAlerta))
		$arrValores["tipoAlerta"]=$obj->tAlerta;
	
	if(isset($obj->valorReferencia1)&& ($obj->valorReferencia1!=""))
		$arrValores["valorReferencia1"]=$obj->valorReferencia1;
	
	
	if(isset($obj->valorReferencia2)&& ($obj->valorReferencia2!=""))
		$arrValores["valorReferencia2"]=$obj->valorReferencia2;
	
	$arrValores["idTitularAlerta"]=$obj->tipoAlerta==1?"NULL":$_SESSION["idUsr"];
	$arrValores["fechaAlerta"]=$obj->fechaAlerta;
	
	registrarAlertaNotificacionSistema($arrValores);
	
	echo "1|";
}

function obtenerDatosGeneralesEntregaDiscos()
{
	global $con;
	$arrRegistros="";
	$unidadGestion=$_POST["unidadGestion"];
	$ciclo=$_POST["ciclo"];
	$tipoCarpeta=$_POST["tipoCarpeta"];
	$numReg=0;
	$consulta="SELECT carpetaAdministrativa,
	(SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa=c.carpetaAdministrativa and idEstado>1) as totalSolicitados,
	(SELECT sum(e.totalEntregadas) FROM _449_tablaDinamica e,_442_tablaDinamica s WHERE e.idReferencia=s.id__442_tablaDinamica and 
	s.carpetaAdministrativa=c.carpetaAdministrativa and e.idEstado=2 and tipoOperacion=1) as totalEntregados,
	(SELECT sum(e.totalEntregadas) FROM _449_tablaDinamica e,_442_tablaDinamica s WHERE e.idReferencia=s.id__442_tablaDinamica and 
	s.carpetaAdministrativa=c.carpetaAdministrativa and e.idEstado=2 and tipoOperacion=2) as totalCancelados
	 FROM 7006_carpetasAdministrativas c  WHERE unidadGestion='".$unidadGestion."' and c.fechaCreacion>='".$ciclo."-01-01' and 
	 c.fechaCreacion<='".$ciclo."-12-31 23:59:59' and c.tipoCarpetaAdministrativa=".$tipoCarpeta." ORDER BY carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		$o='{"carpetaAdministrativa":"'.$fila[0].'","totalDVDSolicitados":"'.($fila[1]==""?0:$fila[1]).'","totalEntregados":"'.($fila[2]==""?0:$fila[2]).
			'","totalCancelados":"'.($fila[3]==""?0:$fila[3]).'","totalPorEntregar":"'.($fila[1]-$fila[2]-$fila[3]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerBitacoraEntregaDiscos()
{
	global $con;
	$cA=$_POST["cA"];
	$s=$_POST["s"];	
	
	$numReg=0;
	$arrRegistros="";
	switch($s)
	{
		case 1:
			$consulta="SELECT * FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' and idEstado>1";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$numEventos=1;
				$listaAudienciasDVD="";
				$consulta="SELECT fechaEvento,tipoAudiencia FROM _441_chkAudiencias a,7000_eventosAudiencia e WHERE idPadre=".$fila["idReferencia"]." and e.idRegistroEvento=a.idOpcion";
				$rAudiencias=$con->obtenerFilas($consulta);
				$totalEventos=$con->filasAfectadas;
				while($fEventoDVD=$con->fetchRow($rAudiencias))
				{
					$lblAudiencia=convertirFechaLetra($fEventoDVD[0]);
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEventoDVD[1];
					$tAudiencia=$con->obtenerValor($consulta);
					$lblAudiencia.=" correspondiente a la audiencia de ".$tAudiencia;
					
					if($listaAudienciasDVD=="")
						$listaAudienciasDVD=$lblAudiencia;
					else
					{
						if($numEventos==$totalEventos)
							$listaAudienciasDVD.=" y ".$lblAudiencia;
						else
							$listaAudienciasDVD.=", ".$lblAudiencia;
					}
					$numEventos++;
				}
				
				
				$consulta="SELECT * FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$fila["idReferencia"];
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$observaciones=$fRegistroBase["especificacionesGenerales"];
				
				if($fila["comentariosAdicionales"]!="")
					if($observaciones=="")
						$observaciones=$fila["comentariosAdicionales"];
					else
						$observaciones.="<br>".$fila["comentariosAdicionales"];
				
				if(trim($observaciones)=="")
					$observaciones="(Sin observaciones)";
					
				$solicitante="";
				if($fila["parteSolicitante"]==1)	
				{
					if($fila["tipoFigura"]==0)
					{
						$solicitante=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
					}
					else
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fila["tipoFigura"];
						$tipoFiguraJuridica=$con->obtenerValor($consulta);
						$solicitante=obtenerNombreImplicado($fila["participanteSolicitante"])." (".$tipoFiguraJuridica.")";
					}
				}
				else
				{
					switch($fila["tipoInstitucion"])
					{
						case 1:
						case 2:
						case 3:
							$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fila["tribunalJuzgado"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 4:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["salaPenal"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 6:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadGestion"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 5:
							$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fila["juez"];
							$solicitante=$con->obtenerValor($consulta);
							$solicitante.=" (Juez)";
						break;
						case 0:
							$solicitante=$fSolicitud["otraDependencia"];
						break;
					}
				}
					
				$lblAudienciasContenidas="<br>Contiene ".($numEventos-1==1?" la audiencia de: ":"las audiencias de: ").$listaAudienciasDVD;
				$detalle=number_format($fila["totalCopias"],0)." ".($fila["totalCopias"]>1?"copias":"copia")." (Certificadas: ".$fila["totalCopiasCertificadas"].
							", Simples: ".$fila["totalCopiasSimples"]."). ".$lblAudienciasContenidas.".<br>Fu&eacute; solicitado por ".obtenerNombreUsuario($fila["responsable"]).
							" para ".$solicitante." con las observaciones siguientes: <br><i><span style=\"font-size:11px !important\">".
							$observaciones."</span></i><br>";
				
				$o='{"totalDiscos":"'.$fila["totalCopias"].'","detalle":"<span class=\"TSJDF_Control\" style=\"font-size:12px !important;color:#000!important\">'.cv($detalle).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
					
					
					
					
					
			}
		break;
		case 2:
			$consulta="SELECT e.*,s.id__442_tablaDinamica as idRegistro
					FROM _449_tablaDinamica e,_442_tablaDinamica s
					WHERE e.idReferencia=s.id__442_tablaDinamica AND s.carpetaAdministrativa='".$cA."' AND e.idEstado=2 AND tipoOperacion=1 order by e.dteFechaEntrega asc";
			$resEntrega=$con->obtenerFilas($consulta);	
			while($fEntregado=$con->fetchAssoc($resEntrega))
			{
				$consulta="SELECT * FROM _442_tablaDinamica WHERE id__442_tablaDinamica='".$fEntregado["idRegistro"]."'";
				$fila=$con->obtenerPrimeraFilaAsoc($consulta);
						
				
				$numEventos=1;
				$listaAudienciasDVD="";
				$consulta="SELECT fechaEvento,tipoAudiencia FROM _441_chkAudiencias a,7000_eventosAudiencia e WHERE idPadre=".$fila["idReferencia"]." and e.idRegistroEvento=a.idOpcion";
				$rAudiencias=$con->obtenerFilas($consulta);
				$totalEventos=$con->filasAfectadas;
				while($fEventoDVD=$con->fetchRow($rAudiencias))
				{
					$lblAudiencia=convertirFechaLetra($fEventoDVD[0]);
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEventoDVD[1];
					$tAudiencia=$con->obtenerValor($consulta);
					$lblAudiencia.=" correspondiente a la audiencia de ".$tAudiencia;
					
					if($listaAudienciasDVD=="")
						$listaAudienciasDVD=$lblAudiencia;
					else
					{
						if($numEventos==$totalEventos)
							$listaAudienciasDVD.=" y ".$lblAudiencia;
						else
							$listaAudienciasDVD.=", ".$lblAudiencia;
					}
					$numEventos++;
				}
				
				
				$consulta="SELECT * FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$fila["idReferencia"];
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$observaciones=$fRegistroBase["especificacionesGenerales"];
				
				if($fila["comentariosAdicionales"]!="")
					if($observaciones=="")
						$observaciones=$fila["comentariosAdicionales"];
					else
						$observaciones.="<br>".$fila["comentariosAdicionales"];
				
				if(trim($observaciones)=="")
					$observaciones="(Sin observaciones)";
					
				$solicitante="";
				if($fila["parteSolicitante"]==1)	
				{
					if($fila["tipoFigura"]==0)
					{
						$solicitante=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
					}
					else
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fila["tipoFigura"];
						$tipoFiguraJuridica=$con->obtenerValor($consulta);
						$solicitante=obtenerNombreImplicado($fila["participanteSolicitante"])." (".$tipoFiguraJuridica.")";
					}
				}
				else
				{
					switch($fila["tipoInstitucion"])
					{
						case 1:
						case 2:
						case 3:
							$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fila["tribunalJuzgado"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 4:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["salaPenal"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 6:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadGestion"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 5:
							$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fila["juez"];
							$solicitante=$con->obtenerValor($consulta);
							$solicitante.=" (Juez)";
						break;
						case 0:
							$solicitante=$fSolicitud["otraDependencia"];
						break;
					}
				}
				
				$receptor="";
				if(($fila["parteSolicitante"]==2)&&($fila["tipoInstitucion"]!=5))
				{
					$receptor=$fEntregado["nombre"]." ".$fEntregado["apPaterno"]." ".$fEntregado["apMaterno"]." (".$fEntregado["puestoParticipacion"].")";
				}
				else
				{
					if($fEntregado["copiasEntregadasSolicitante"]=="1")
					{
						$receptor=$solicitante;
					}
					else
					{
						$receptor=$fEntregado["nombre"]." ".$fEntregado["apPaterno"]." ".$fEntregado["apMaterno"]." (".$fEntregado["puestoParticipacion"].
								"), justificaci&oacute;n de la entrega: ".$fEntregado["justificacionEntrega"];
					}
				}
				$leyendaEntrega="<b>Datos de la entrega:</b><br>Entregado el ".convertirFechaLetra($fEntregado["dteFechaEntrega"])." a ".$receptor.
				".<br>Comentarios adicionales:<br><i><span style=\"font-size:11px !important\">".
				(trim($fEntregado["comentariosAdicionales"])==""?"(Sin comentarios)":trim($fEntregado["comentariosAdicionales"]))."</span></i><br>";
					
				$lblAudienciasContenidas="<br>Contiene ".($numEventos-1==1?" la audiencia de: ":"las audiencias de: ").$listaAudienciasDVD;
				$detalle=number_format($fEntregado["totalEntregadas"],0)." ".($fEntregado["totalEntregadas"]>1?"copias":"copia")." (Certificadas: ".number_format($fEntregado["copiasCertificadasEntregadas"],0).
							", Simples: ".number_format($fEntregado["copiasSimplesEntregadas"],0)."). ".$lblAudienciasContenidas.".<br>Fu&eacute; solicitado por ".obtenerNombreUsuario($fila["responsable"]).
							" para ".$solicitante." con las observaciones siguientes: <br><i><span style=\"font-size:11px !important\">".
							$observaciones."</span></i><br>".$leyendaEntrega;
				
				$o='{"totalDiscos":"'.$fEntregado["totalEntregadas"].'","detalle":"<span class=\"TSJDF_Control\" style=\"font-size:12px !important;color:#000!important\">'.cv($detalle).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		break;
		case 3:
			$consulta="SELECT e.*,s.id__442_tablaDinamica as idRegistro
					FROM _449_tablaDinamica e,_442_tablaDinamica s
					WHERE e.idReferencia=s.id__442_tablaDinamica AND s.carpetaAdministrativa='".$cA."' AND e.idEstado=2 AND tipoOperacion=2 order by e.dteFechaEntrega asc";
			$resEntrega=$con->obtenerFilas($consulta);	
			while($fEntregado=$con->fetchAssoc($resEntrega))
			{
				$consulta="SELECT * FROM _442_tablaDinamica WHERE id__442_tablaDinamica='".$fEntregado["idRegistro"]."'";
				$fila=$con->obtenerPrimeraFilaAsoc($consulta);
						
				
				$numEventos=1;
				$listaAudienciasDVD="";
				$consulta="SELECT fechaEvento,tipoAudiencia FROM _441_chkAudiencias a,7000_eventosAudiencia e WHERE idPadre=".$fila["idReferencia"]." and e.idRegistroEvento=a.idOpcion";
				$rAudiencias=$con->obtenerFilas($consulta);
				$totalEventos=$con->filasAfectadas;
				while($fEventoDVD=$con->fetchRow($rAudiencias))
				{
					$lblAudiencia=convertirFechaLetra($fEventoDVD[0]);
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEventoDVD[1];
					$tAudiencia=$con->obtenerValor($consulta);
					$lblAudiencia.=" correspondiente a la audiencia de ".$tAudiencia;
					
					if($listaAudienciasDVD=="")
						$listaAudienciasDVD=$lblAudiencia;
					else
					{
						if($numEventos==$totalEventos)
							$listaAudienciasDVD.=" y ".$lblAudiencia;
						else
							$listaAudienciasDVD.=", ".$lblAudiencia;
					}
					$numEventos++;
				}
				
				
				$consulta="SELECT * FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$fila["idReferencia"];
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$observaciones=$fRegistroBase["especificacionesGenerales"];
				
				if($fila["comentariosAdicionales"]!="")
					if($observaciones=="")
						$observaciones=$fila["comentariosAdicionales"];
					else
						$observaciones.="<br>".$fila["comentariosAdicionales"];
				
				if(trim($observaciones)=="")
					$observaciones="(Sin observaciones)";
					
				$solicitante="";
				if($fila["parteSolicitante"]==1)	
				{
					if($fila["tipoFigura"]==0)
					{
						$solicitante=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
					}
					else
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fila["tipoFigura"];
						$tipoFiguraJuridica=$con->obtenerValor($consulta);
						$solicitante=obtenerNombreImplicado($fila["participanteSolicitante"])." (".$tipoFiguraJuridica.")";
					}
				}
				else
				{
					switch($fila["tipoInstitucion"])
					{
						case 1:
						case 2:
						case 3:
							$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fila["tribunalJuzgado"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 4:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["salaPenal"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 6:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadGestion"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 5:
							$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fila["juez"];
							$solicitante=$con->obtenerValor($consulta);
							$solicitante.=" (Juez)";
						break;
						case 0:
							$solicitante=$fSolicitud["otraDependencia"];
						break;
					}
				}
				
				
				$leyendaEntrega="<br>Comentarios:<br><i><span style=\"font-size:11px !important\">".
				(trim($fEntregado["comentariosAdicionales"])==""?"(Sin comentarios)":trim($fEntregado["comentariosAdicionales"]))."</span></i><br>";
					
				$lblAudienciasContenidas="<br>Contiene ".($numEventos-1==1?" la audiencia de: ":"las audiencias de: ").$listaAudienciasDVD;
				$detalle=number_format($fEntregado["totalEntregadas"],0)." ".($fEntregado["totalEntregadas"]>1?"copias":"copia")." (Certificadas: ".number_format($fEntregado["copiasCertificadasEntregadas"],0).
							", Simples: ".number_format($fEntregado["copiasSimplesEntregadas"],0)."). ".$lblAudienciasContenidas.".<br>Fu&eacute; solicitado por ".obtenerNombreUsuario($fila["responsable"]).
							" para ".$solicitante." con las observaciones siguientes: <br><i><span style=\"font-size:11px !important\">".
							$observaciones."</span></i><br>".$leyendaEntrega;
				
				$o='{"totalDiscos":"'.$fEntregado["totalEntregadas"].'","detalle":"<span class=\"TSJDF_Control\" style=\"font-size:12px !important;color:#000!important\">'.cv($detalle).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		break;
		case 4:
			$consulta="SELECT s.* FROM _442_tablaDinamica s WHERE carpetaAdministrativa='".$cA."' and idEstado=2";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$numEventos=1;
				$listaAudienciasDVD="";
				$consulta="SELECT fechaEvento,tipoAudiencia FROM _441_chkAudiencias a,7000_eventosAudiencia e WHERE idPadre=".$fila["idReferencia"]." and e.idRegistroEvento=a.idOpcion";
				$rAudiencias=$con->obtenerFilas($consulta);
				$totalEventos=$con->filasAfectadas;
				while($fEventoDVD=$con->fetchRow($rAudiencias))
				{
					$lblAudiencia=convertirFechaLetra($fEventoDVD[0]);
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEventoDVD[1];
					$tAudiencia=$con->obtenerValor($consulta);
					$lblAudiencia.=" correspondiente a la audiencia de ".$tAudiencia;
					
					if($listaAudienciasDVD=="")
						$listaAudienciasDVD=$lblAudiencia;
					else
					{
						if($numEventos==$totalEventos)
							$listaAudienciasDVD.=" y ".$lblAudiencia;
						else
							$listaAudienciasDVD.=", ".$lblAudiencia;
					}
					$numEventos++;
				}
				
				
				$consulta="SELECT * FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$fila["idReferencia"];
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$observaciones=$fRegistroBase["especificacionesGenerales"];
				
				if($fila["comentariosAdicionales"]!="")
					if($observaciones=="")
						$observaciones=$fila["comentariosAdicionales"];
					else
						$observaciones.="<br>".$fila["comentariosAdicionales"];
				
				if(trim($observaciones)=="")
					$observaciones="(Sin observaciones)";
					
				$solicitante="";
				if($fila["parteSolicitante"]==1)	
				{
					if($fila["tipoFigura"]==0)
					{
						$solicitante=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
					}
					else
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fila["tipoFigura"];
						$tipoFiguraJuridica=$con->obtenerValor($consulta);
						$solicitante=obtenerNombreImplicado($fila["participanteSolicitante"])." (".$tipoFiguraJuridica.")";
					}
				}
				else
				{
					switch($fila["tipoInstitucion"])
					{
						case 1:
						case 2:
						case 3:
							$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fila["tribunalJuzgado"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 4:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["salaPenal"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 6:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadGestion"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 5:
							$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fila["juez"];
							$solicitante=$con->obtenerValor($consulta);
							$solicitante.=" (Juez)";
						break;
						case 0:
							$solicitante=$fSolicitud["otraDependencia"];
						break;
					}
				}
				
				$consulta="SELECT SUM(copiasCertificadasEntregadas) FROM _449_tablaDinamica WHERE idReferencia=".$fila["id__442_tablaDinamica"]." and idEstado=2";
				$totalCopiasCertificadas=$con->obtenerValor($consulta);
				
				$consulta="SELECT SUM(copiasSimplesEntregadas) FROM _449_tablaDinamica WHERE idReferencia=".$fila["id__442_tablaDinamica"]." and idEstado=2";
				$totalCopiasSimples=$con->obtenerValor($consulta);
				
				$restoCopiasSimples=$fila["totalCopiasSimples"]-$totalCopiasSimples;
				$restoCopiasCertificadas=$fila["totalCopiasCertificadas"]-$totalCopiasCertificadas;
				$total=$restoCopiasSimples+$restoCopiasCertificadas;
					
				$lblAudienciasContenidas="<br>Contiene ".($numEventos-1==1?" la audiencia de: ":"las audiencias de: ").$listaAudienciasDVD;
				$detalle=number_format($total,0)." ".($total>1?"copias":"copia")." (Certificadas: ".$restoCopiasCertificadas.
							", Simples: ".$restoCopiasSimples."). ".$lblAudienciasContenidas.".<br>Fu&eacute; solicitado por ".obtenerNombreUsuario($fila["responsable"]).
							" para ".$solicitante." con las observaciones siguientes: <br><i><span style=\"font-size:11px !important\">".
							$observaciones."</span></i><br>";
				
				$o='{"totalDiscos":"'.$total.'","detalle":"<span class=\"TSJDF_Control\" style=\"font-size:12px !important;color:#000!important\">'.cv($detalle).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
					
					
					
					
					
			}
		break;
		case 5:
			$iR=$_POST["iR"];	
			$consulta="SELECT * FROM _442_tablaDinamica WHERE idReferencia=".$iR;
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$numEventos=1;
				$listaAudienciasDVD="";
				$consulta="SELECT fechaEvento,tipoAudiencia FROM _441_chkAudiencias a,7000_eventosAudiencia e WHERE idPadre=".$fila["idReferencia"]." and e.idRegistroEvento=a.idOpcion";
				$rAudiencias=$con->obtenerFilas($consulta);
				$totalEventos=$con->filasAfectadas;
				while($fEventoDVD=$con->fetchRow($rAudiencias))
				{
					$lblAudiencia=convertirFechaLetra($fEventoDVD[0]);
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fEventoDVD[1];
					$tAudiencia=$con->obtenerValor($consulta);
					$lblAudiencia.=" correspondiente a la audiencia de ".$tAudiencia;
					
					if($listaAudienciasDVD=="")
						$listaAudienciasDVD=$lblAudiencia;
					else
					{
						if($numEventos==$totalEventos)
							$listaAudienciasDVD.=" y ".$lblAudiencia;
						else
							$listaAudienciasDVD.=", ".$lblAudiencia;
					}
					$numEventos++;
				}
				
				
				$consulta="SELECT * FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$fila["idReferencia"];
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$observaciones=$fRegistroBase["especificacionesGenerales"];
				
				if($fila["comentariosAdicionales"]!="")
					if($observaciones=="")
						$observaciones=$fila["comentariosAdicionales"];
					else
						$observaciones.="<br>".$fila["comentariosAdicionales"];
				
				if(trim($observaciones)=="")
					$observaciones="(Sin observaciones)";
					
				$solicitante="";
				if($fila["parteSolicitante"]==1)	
				{
					if($fila["tipoFigura"]==0)
					{
						$solicitante=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
					}
					else
					{
						$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fila["tipoFigura"];
						$tipoFiguraJuridica=$con->obtenerValor($consulta);
						$solicitante=obtenerNombreImplicado($fila["participanteSolicitante"])." (".$tipoFiguraJuridica.")";
					}
				}
				else
				{
					switch($fila["tipoInstitucion"])
					{
						case 1:
						case 2:
						case 3:
							$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fila["tribunalJuzgado"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 4:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["salaPenal"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 6:
							$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadGestion"];
							$solicitante=$con->obtenerValor($consulta);
						break;
						case 5:
							$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fila["juez"];
							$solicitante=$con->obtenerValor($consulta);
							$solicitante.=" (Juez)";
						break;
						case 0:
							$solicitante=$fSolicitud["otraDependencia"];
						break;
					}
				}
					
				$lblAudienciasContenidas="<br>Contiene ".($numEventos-1==1?" la audiencia de: ":"las audiencias de: ").$listaAudienciasDVD;
				$detalle=number_format($fila["totalCopias"],0)." ".($fila["totalCopias"]>1?"copias":"copia")." (Certificadas: ".$fila["totalCopiasCertificadas"].
							", Simples: ".$fila["totalCopiasSimples"]."). ".$lblAudienciasContenidas.".<br>Fu&eacute; solicitado por ".obtenerNombreUsuario($fila["responsable"]).
							" para ".$solicitante." con las observaciones siguientes: <br><i><span style=\"font-size:11px !important\">".
							$observaciones."</span></i><br>";
				
				$o='{"totalDiscos":"'.$fila["totalCopias"].'","detalle":"<span class=\"TSJDF_Control\" style=\"font-size:12px !important;color:#000!important\">'.cv($detalle).'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
					
					
					
					
					
			}
		break;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';	
}

function obtenerSituacionCopiasDiscoCarpeta()
{
	global $con;
	
	$cA=$_POST["cA"];
	$arrRegistros="";
	
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=4";
	$sentenciado=$con->obtenerValor($consulta);
	if($sentenciado=="")
		$sentenciado=0;	
	
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=2";
	$victima=$con->obtenerValor($consulta);
	if($victima=="")
		$victima=0;
	
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=10";
	$mininisterioPublico=$con->obtenerValor($consulta);
	if($mininisterioPublico=="")
		$mininisterioPublico=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=3";
	$asesorJuridico=$con->obtenerValor($consulta);
	if($asesorJuridico=="")
		$asesorJuridico=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=5";
	$defensa=$con->obtenerValor($consulta);
	if($defensa=="")
		$defensa=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=0";
	$otros=$con->obtenerValor($consulta);
	if($otros=="")
		$otros=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=2";
	$instituciones=$con->obtenerValor($consulta);
	if($instituciones=="")
		$instituciones=0;
		
	$oR='{"situacionDiscos":"1","sentenciado":"'.$sentenciado.'","victima":"'.$victima.'","mininisterioPublico":"'.$mininisterioPublico.
		'","asesorJuridico":"'.$asesorJuridico.'","defensa":"'.$defensa.'","otros":"'.$otros.'","instituciones":"'.$instituciones.'"}';
	$arrRegistros=$oR;
	
	/*$consulta="SELECT sum(totalEntregadas) FROM _442_tablaDinamica s,_449_tablaDinamica e WHERE s.carpetaAdministrativa='".$cA."' AND e.idEstado=2 
			AND parteSolicitante=1 AND tipoFigura=4 and tipoOperacion=1 and e.idReferencia=s.id__442_tablaDinamica";
	$sentenciado=$con->obtenerValor($consulta);
	if($sentenciado=="")
		$sentenciado=0;	
	
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=2";
	$victima=$con->obtenerValor($consulta);
	if($victima=="")
		$victima=0;
	
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=10";
	$mininisterioPublico=$con->obtenerValor($consulta);
	if($mininisterioPublico=="")
		$mininisterioPublico=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=3";
	$asesorJuridico=$con->obtenerValor($consulta);
	if($asesorJuridico=="")
		$asesorJuridico=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=5";
	$defensa=$con->obtenerValor($consulta);
	if($defensa=="")
		$defensa=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=1 AND tipoFigura=0";
	$otros=$con->obtenerValor($consulta);
	if($otros=="")
		$otros=0;
		
	$consulta="SELECT sum(totalCopias) FROM _442_tablaDinamica WHERE carpetaAdministrativa='".$cA."' AND idEstado>1 AND parteSolicitante=2";
	$instituciones=$con->obtenerValor($consulta);
	if($instituciones=="")
		$instituciones=0;
		
	$oR='{"situacionDiscos":"1","sentenciado":"'.$sentenciado.'","victima":"'.$victima.'","mininisterioPublico":"'.$mininisterioPublico.
		'","asesorJuridico":"'.$asesorJuridico.'","defensa":"'.$defensa.'","otros":"'.$otros.'","instituciones":"'.$instituciones.'"}';
	$arrRegistros.=",".$oR;*/
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
	
	
	
}

function obtenerAudienciasCarpetaJudicial()
{
	global $con;
	$cA=$_POST["cA"];
	$fI=$_POST["fI"];
	$fF=$_POST["fF"];
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT e.* FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co WHERE 
			co.carpetaAdministrativa='".$cA."' and e.fechaEvento>='".$fI."' and e.fechaEvento<='".$fF."' AND tipoContenido=3 
			AND idRegistroContenidoReferencia=e.idRegistroEvento ORDER BY horaInicioEvento";
			
			
	$res=$con->obtenerFilas($consulta);		
	while($fila=$con->fetchAssoc($res))
	{
		$leyendaAudiencia="";
		
		$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fila["tipoAudiencia"];
		$tipoAudiencia="<span style=\"color:#900\"><b>".$con->obtenerValor($consulta)."</b></span>";
		
		$consulta="SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila["idSala"];
		$lblSala=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$fila["idEdificio"];
		$edificio=$con->obtenerValor($consulta);
		
		$consulta="SELECT group_concat(CONCAT('[',noJuez,'] ',u.Nombre, ' (',j.titulo,')')) AS juez FROM 7001_eventoAudienciaJuez j,
				800_usuarios u WHERE u.idUsuario=j.idJuez AND j.idRegistroEvento=".$fila["idRegistroEvento"];
		$lblJuez=$con->obtenerListaValores($consulta);
		
		$leyendaAudiencia=$tipoAudiencia."<br><span style=\"font-size:11px\">Hora de inicio: ".date("H:i ",strtotime($fila["horaInicioEvento"]))." hrs. ".$lblSala.
						" , Edificio: ".$edificio."<br>Juez: ".$lblJuez."</span><br><br>";
						
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila["situacion"])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila["idRegistroEvento"];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}					
		
		$consulta="SELECT situacion FROM 3014_registroResutadoAudiencia WHERE idEvento=".$fila["idRegistroEvento"];			
		$situacionResolutivos=	$con->obtenerValor($consulta);	
		if($situacionResolutivos=="")
			$situacionResolutivos=2	;	
		
		
		$consulta="SELECT situacionActual FROM 7039_situacionRegistrosVarios WHERE tipoRegistro=3 AND idReferencia=".$fila["idRegistroEvento"];			
		$situacionListaAudiencia=$con->obtenerValor($consulta);	
		if($situacionListaAudiencia=="")
			$situacionListaAudiencia=2	;
			
					
		$o='{"idEventoAudiencia":"'.$fila["idRegistroEvento"].'","fechaAudiencia":"'.$fila["fechaEvento"].'","fechaInicioAudiencia":"'.
			$fila["horaInicioEvento"].'","leyendaAudiencia":"'.cv($leyendaAudiencia).'","situacionAudiencia":"'.$fila["situacion"].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.
			'","situacionResolutivos":"'.$situacionResolutivos.'","situacionPaseLista":"'.$situacionListaAudiencia.
			'","totalActasMinimas":"","totalTranscripciones":""}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	
}


function obtenerCarpetasEjecucionActualizacion()
{
	global $con;
	$situacion=$_POST["situacion"];
	$ciclo=$_POST["ciclo"];
	$uG=$_POST["uG"];
	
	$consulta="SELECT id__385_tablaDinamica AS idRegistro,c.idActividad,carpetaEjecucion,idEstado,
			(SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=c.idActividad AND idFiguraJuridica=4) AS totalImputados,
			c.situacion as situacionCarpeta 
			FROM _385_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$ciclo."-01-01' and c.fechaCreacion<='".$ciclo."-12-31 23:59:59'
			and c.carpetaAdministrativa=s.carpetaEjecucion AND unidadGestion='".$uG."' and s.idEstado in (".$situacion.")
			ORDER BY carpetaEjecucion";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	$numReg=$con->filasAfectadas;
	
	echo '{"numReg":"'.$numReg.'","registros":'.$arrRegistros.'}';		
			
}

function obtenerSentenciadosCarpetas()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	$consulta="SELECT idRelacion AS idRegistroParticipante,
				CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS  nombreImputado, 
				(SELECT group_concat(id__405_tablaDinamica) FROM _405_tablaDinamica WHERE idActividadEjecucion=r.idActividad AND sentenciado=p.id__47_tablaDinamica) AS idRegistroPena,
				r.idParticipante as idSentenciado
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad." AND idFiguraJuridica=4 
				AND p.id__47_tablaDinamica=r.idParticipante";

	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	$numReg=$con->filasAfectadas;
	
	echo '{"numReg":"'.$numReg.'","registros":'.$arrRegistros.'}';	
}

function finalizarActualizacionCarpetaEjecucion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$consulta="UPDATE _385_tablaDinamica SET idEstado=100 WHERE id__385_tablaDinamica=".$idRegistro;
	eC($consulta);
	
}

function removerImputadoCarpetaEjecucion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	
	$query="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFila($query);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="UPDATE _405_tablaDinamica SET sentenciado=(sentenciado*-1),idReferencia=(idReferencia*-1) WHERE sentenciado=".$fRegistro[2]." AND idActividadEjecucion=".$fRegistro[1];
	$x++;
	$consulta[$x]="DELETE FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$idRegistro;
	$x++;
	$consulta[$x]="commit";
	$x++;
	
	eB($consulta);
	
}

function esHorarioAtencionTramite()
{
	
	global $con;
	echo "1|";
	return;

	$fechaActual=strtotime(date("Y-m-d H:i:s"));
	$horaInicio=strtotime(date("Y-m-d ",$fechaActual)." 09:00");
	$horaFin="";
	$esHorarioAtencion=false;
	$dia=date("w",$fechaActual);
	if(($dia>=1)||($dia<=5))
	{
		if($dia==5)
		{
			$horaFin=strtotime(date("Y-m-d ",$fechaActual)." 14:00");
		}
		else
		{
			$horaFin=strtotime(date("Y-m-d ",$fechaActual)." 15:00");
		}
		
		
		if(($fechaActual>=$horaInicio)&&($fechaActual<$horaFin))
		{
			$esHorarioAtencion=true;
		}
	}
	
	if(!$esHorarioAtencion)
	{
		echo "1|<b>Fuera de horario de atenci&oacute;n (Hora actual: ".date("H:i:s",$fechaActual).")</b><br><br>El horario de atenci&oacute;n de este tr&aacute;mite es ".
			"de Lunes a Jueves de 09:00 a 15:00 hrs, Viernes de 09:00 a 14:00 hrs";
	}
	else
	{
		echo "1|";
	}
}


function registrarModificacionDocumentoWord()
{
	global $con;
	global $baseDir;
	global $tipoServidor;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$configuracionDocumento="";
	if(isset($obj->configuracionDocumento))
	{
		$configuracionDocumento=$obj->configuracionDocumento;
	}
	$consulta="SELECT idDocumentoAdjunto FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$obj->idRegistroDocumento;
	$idDocumentoAdjunto=$con->obtenerValor($consulta);
	
	$consulta="UPDATE 3000_formatosRegistrados SET cuerpoFormato='',configuracionDocumento='".$configuracionDocumento."' WHERE idRegistroFormato=".$obj->idRegistroDocumento;
	$con->ejecutarConsulta($consulta);
	
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumentoAdjunto;
	$nomArchivoOriginal=$con->obtenerValor($consulta);
	
	$consulta="INSERT INTO 3001_respaldoFormatoRegistrados(idRegistroFormato,fechaRegistro,idResponsableRegistro,cuerpoFormato,comentariosAdicionales) 
				VALUES(".$obj->idRegistroDocumento.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($nomArchivoOriginal)."','".cv($obj->comentariosAdicionales)."')";
	$con->ejecutarConsulta($consulta);
	$idDocumentoRespaldo=$con->obtenerUltimoID();
	$pathDocumento=$baseDir."/repositorioDocumentos/documento_".$idDocumentoAdjunto;
	$pathDocumentoWord=$baseDir."/repositorioPDFWord/documento_".$idDocumentoAdjunto;
	$pathDocumentoRespaldo=$baseDir."/repositorioDocumentosRespaldo/documento_".$idDocumentoRespaldo;
	$pathNewDocument=$baseDir."/archivosTemporales/".$obj->idArchivo;
	
	if($tipoServidor==2)
	{
		$pathDocumento=str_replace("/","\\",$pathDocumento);
		$pathDocumentoWord=str_replace("/","\\",$pathDocumentoWord);
		$pathDocumentoRespaldo=str_replace("/","\\",$pathDocumentoRespaldo);
		$pathNewDocument=str_replace("/","\\",$pathNewDocument);
		
	}
	

	if(escribirContenidoArchivo($pathDocumentoRespaldo,bD(obtenerCuerpoDocumentoB64($idDocumentoAdjunto))))
	{
		if(file_exists($pathDocumento))
			unlink($pathDocumento);
		if(file_exists($pathDocumentoWord))
			unlink($pathDocumentoWord);
		if(copy($pathNewDocument,$pathDocumento))
		{
			if(file_exists($pathNewDocument))
				unlink($pathNewDocument);
			
			$tamano=filesize($pathDocumento);
			$sha512=strtoupper(hash_file ( "sha512" , $pathDocumento,false ));
			$consulta="UPDATE 908_archivos SET tamano=".$tamano.",sha512='".$sha512."' WHERE idArchivo=".$idDocumentoAdjunto;
			eC($consulta);
		}
		
	}
	
}

function registrarAltaEmpleadoOrganigrama()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="UPDATE _421_tablaDinamica SET usuarioAsignado=".$obj->empleado.",fechaInicioFunciones='".$obj->fechaInicio.
			"',comentariosAdicionales='".cv($obj->comentariosAdicionales)."' WHERE idReferencia=".$obj->idPerfil.
			" AND claveNivel='".$obj->puesto."'";
	
	//echo $consulta;
	eC($consulta);
	
	
	
}

function registrarBajaEmpleadoOrganigrama()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$consulta="select * from _421_tablaDinamica WHERE idReferencia=".$obj->idPerfil." AND claveNivel='".$obj->puesto."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	if($fRegistro)
	{
		$consulta="INSERT INTO _421_historialAsignacionPuestos(idPerfil,puesto,usuarioAsignado,fechaInicial,fechaFinal,comentariosAdicionalesAlta,comentariosAdicionalesBaja)
				values(".$obj->idPerfil." ,'".$obj->puesto."',".($fRegistro["usuarioAsignado"]==""?-1:$fRegistro["usuarioAsignado"]).
				",".($fRegistro["fechaInicioFunciones"]==""?"NULL":"'".$fRegistro["fechaInicioFunciones"]."'").",'".$obj->fechaInicio.
				"','".cv($fRegistro["comentariosAdicionales"])."','".cv($obj->comentariosAdicionales)."')";
		$con->ejecutarConsulta($consulta);
	}
	$consulta="UPDATE _421_tablaDinamica SET usuarioAsignado=NULL,fechaInicioFunciones=NULL,comentariosAdicionales='' 
			WHERE idReferencia=".$obj->idPerfil." AND claveNivel='".$obj->puesto."'";
	eC($consulta);
	
	
	
}

function obtenerConcentradoPenasEjecucion()
{
	global $con;
	$uG=$_SESSION["codigoInstitucion"];
	
	$filtroCA="";
	$filtroFechaI="";
	$filtroFechaF="";
	
	if(isset($_POST["uG"]))
		$uG=$_POST["uG"];
	
	/*if(isset($_POST["cA"]))
	{
		$filtroCA=" c.carpetaAdministrativa like '".$_POST["cA"]."%' and ";
	}*/
	
	if(isset($_POST["i1"])&&($_POST["i1"]!=""))
	{
		$filtroFechaI=" and fechaInicio>='".$_POST["i1"]."'";
	}
	
	if(isset($_POST["i2"])&&($_POST["i2"]!="")&&($_POST["i1"]!=$_POST["i2"]))
	{
		$filtroFechaI.=" and fechaInicio<='".$_POST["i2"]."'";
	}
	
	if(isset($_POST["t1"])&&($_POST["t1"]!=""))
	{
		$filtroFechaI=" and fechaTermino>='".$_POST["t1"]."'";
	}
	
	if(isset($_POST["t2"])&&($_POST["t2"]!="")&&($_POST["t1"]!=$_POST["t2"]))
	{
		$filtroFechaI.=" and fechaTermino<='".$_POST["t2"]."'";
	}
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);

	$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);
	$cadCondWhere=str_replace("carpetaAdministrativa","c.carpetaAdministrativa",$cadCondWhere);
	
	$s=$_POST["s"];
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	
	$arrRegistros="";
	$numReg=0;
	
	$aTipoObjetos=array();
	
	$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle WHERE idReferencia=10";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$aTipoObjetos[$fila[0]]=$fila[1];
	}
	
	
	$objFinal="";
	$nPenas=0;
	
	$consulta="SELECT p.idRegistro,IF(tipoPena=1,'Pena',IF(tipoPena=2,'Medida de seguridad',IF(tipoPena=3,'Consecuencia accesoria','No Identificado'))) AS tipoPena,
				IF(detallePena=-1,(SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),CONCAT((SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),' (',(SELECT subdetalle FROM _406_gridSubDetalle WHERE id__406_gridSubDetalle=p.detallePena),')')) AS detallePena,
				objDetalle,(select nombre from _2_tablaDinamica where clave=p.centroDetencion) as centroDetencion,detallesAdicionales,permiteSustitutivos,seAcogeSustitutivo,
				idSustitutivoAcoge,fechaInicio,fechaTermino,seAcogeSuspensionCondicional,p.comentariosAdicionales,p.situacion,
				abonoPrisionPunitiva,idPena,permiteSustitutivos,fechaPrescripcion,
				sc.carpetaEjecucion,i.idActividad,(UPPER(CONCAT(IF(imp.nombre IS NULL,'',imp.nombre),' ',IF(imp.apellidoPaterno IS NULL,
				'',imp.apellidoPaterno),' ',IF(imp.apellidoMaterno IS NULL,'',imp.apellidoMaterno)))) AS sentenciado,i.concedeSuspension,i.montoGarantia,
				i.id__405_tablaDinamica,i.acogeSuspension
				FROM 7024_registroPenasSentenciaEjecucion p,_405_tablaDinamica i,_385_tablaDinamica sc,7006_carpetasAdministrativas c,_47_tablaDinamica imp 
				WHERE ".$cadCondWhere." and c.unidadGestion='".$uG."' AND c.tipoCarpetaAdministrativa=6 AND sc.carpetaEjecucion=c.carpetaAdministrativa AND
				i.idReferencia=sc.id__385_tablaDinamica AND imp.id__47_tablaDinamica=i.sentenciado and p.idActividad=i.idActividad and 
				p.situacion in(".$s.") ".$filtroFechaI.$filtroFechaF;
	$con->obtenerFilas($consulta);
	
	$total=$con->filasAfectadas;
	$consulta="SELECT p.idRegistro,IF(tipoPena=1,'Pena',IF(tipoPena=2,'Medida de seguridad',IF(tipoPena=3,'Consecuencia accesoria','No Identificado'))) AS tipoPena,
				IF(detallePena=-1,(SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),CONCAT((SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),' (',(SELECT subdetalle FROM _406_gridSubDetalle WHERE id__406_gridSubDetalle=p.detallePena),')')) AS detallePena,
				objDetalle,(select nombre from _2_tablaDinamica where clave=p.centroDetencion) as centroDetencion,detallesAdicionales,permiteSustitutivos,seAcogeSustitutivo,
				idSustitutivoAcoge,fechaInicio,fechaTermino,seAcogeSuspensionCondicional,p.comentariosAdicionales,p.situacion,
				abonoPrisionPunitiva,idPena,permiteSustitutivos,fechaPrescripcion,
				sc.carpetaEjecucion,i.idActividad,(UPPER(CONCAT(IF(imp.nombre IS NULL,'',imp.nombre),' ',IF(imp.apellidoPaterno IS NULL,
				'',imp.apellidoPaterno),' ',IF(imp.apellidoMaterno IS NULL,'',imp.apellidoMaterno)))) AS sentenciado,i.concedeSuspension,i.montoGarantia,
				i.id__405_tablaDinamica,i.acogeSuspension
				FROM 7024_registroPenasSentenciaEjecucion p,_405_tablaDinamica i,_385_tablaDinamica sc,7006_carpetasAdministrativas c,_47_tablaDinamica imp 
				WHERE ".$cadCondWhere." and c.unidadGestion='".$uG."' AND c.tipoCarpetaAdministrativa=6 AND sc.carpetaEjecucion=c.carpetaAdministrativa AND
				i.idReferencia=sc.id__385_tablaDinamica AND imp.id__47_tablaDinamica=i.sentenciado and p.idActividad=i.idActividad and 
				p.situacion in(".$s.") ".$filtroFechaI.$filtroFechaF." order by c.carpetaAdministrativa limit ".$start.",".$limit;



	$rPena=$con->obtenerFilas($consulta);
	while($fPena=$con->fetchAssoc($rPena))
	{
		$objFinal='{"carpetaAdministrativa":"'.$fPena["carpetaEjecucion"].'","imputado":"'.cv($fila["sentenciado"]).'"';
		$compPena="";
		$sentencia="";
		if($fPena["objDetalle"]!="")
		{
			$oDetalle=json_decode($fPena["objDetalle"]);
			if(isset($oDetalle->monto))
			{
				$compPena="<br>Monto: $ ".number_format($oDetalle->monto,2);
			}
			if(isset($oDetalle->tiposObjetos))
			{
				$arrObjetos=explode(",",$oDetalle->tiposObjetos);
				$compPena="<br>Tipo de objetos: ";
				$lObjetos="";
				foreach($arrObjetos as $o)
				{
					if($lObjetos=="")
						$lObjetos=$aTipoObjetos[$o];
					else
						$lObjetos.=",".$aTipoObjetos[$o];
				}
				$compPena.=$lObjetos;
			}

			if(isset($oDetalle->anios))
			{
				$arrPena=array();
				$arrPena[0]=$oDetalle->anios;
				$arrPena[1]=$oDetalle->meses;
				$arrPena[2]=$oDetalle->dias;
				$sentencia=$oDetalle->anios."_".$oDetalle->meses."_".$oDetalle->dias;
				$compPena="<br>Periodo a compurgar: ".convertirLeyendaComputo($arrPena);
			}
		}

		$permiteSuspensionCondicional=0;
		if($fPena["concedeSuspension"]==1)
		{
			$consulta="SELECT COUNT(*) FROM _405_gPenaSuspensionCondicional WHERE idReferencia=".$fPena["id__405_tablaDinamica"].
						" AND idPena=".$fPena["idRegistro"];
			$nRegistro=$con->obtenerValor($consulta);
			$permiteSuspensionCondicional=$nRegistro>0?"1":"0";


		}

		$consulta="SELECT COUNT(*) FROM  7024_bitacoraCambiosPena WHERE idPena=".$fPena["idRegistro"];
		$nHistorial=$con->obtenerValor($consulta);


		$tipoIngreso="";
		$consulta="SELECT tipoEntrada FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fPena["idPena"];
		$tipoIngreso=$con->obtenerValor($consulta);
		$abonoPrisionPreventiva="";
		$abonoPrisionPunitiva=$fPena["abonoPrisionPunitiva"];

		$totalAbono=array();
		$totalAbono[0]=0;
		$totalAbono[1]=0;
		$totalAbono[2]=0;

		$consulta="SELECT * FROM 7033_computoPrisionCumplida WHERE idPena=".$fPena["idRegistro"];
		$rComputo=$con->obtenerFilas($consulta);
		while($fComputo=$con->fetchAssoc($rComputo))
		{
			$tComputo=array();
			$tComputo[0]=$fComputo["anios"];
			$tComputo[1]=$fComputo["meses"];
			$tComputo[2]=$fComputo["dias"];
			$totalAbono=sumarComputo($totalAbono,$tComputo);
		}
		$abonoPrisionPreventiva=$totalAbono[0]."_".$totalAbono[1]."_".$totalAbono[2];

		$arrSustitutivos="[]";
		if($fPena["permiteSustitutivos"]==1)
		{
			$consulta="SELECT idSustitutivo,acogeSustitutivo,detallesAdicionales,montoSustitutivo,
					periodoSustitutivo,fechaInicio,fechaTermino FROM 7026_registroSustitutivoPena WHERE idPena=".$fPena["idRegistro"];
			$arrSustitutivos=utf8_encode($con->obtenerFilasJson($consulta));
		}

		$objFinal='{"idPena":"'.$fPena["idRegistro"].'","carpetaAdministrativa":"'.$fPena["carpetaEjecucion"].'","imputado":"'.cv($fPena["sentenciado"]).
					'","fechaInicio":"'.$fPena["fechaInicio"].'","fechaFin":"'.$fPena["fechaTermino"].'","tipoPena":"'.cv($fPena["tipoPena"]).
					'","detallePena":"'.cv($fPena["detallePena"].$compPena).'","detallesAdicionales":"'.cv($fPena["detallesAdicionales"]).
					'","situacionPena":"'.$fPena["situacion"].'","concedeSuspension":"'.$fPena["concedeSuspension"].'","montoGarantia":"'.
					$fPena["montoGarantia"].'","permiteSuspensionCondicional":"'.$permiteSuspensionCondicional.'","acogeSuspension":"'.$fPena["acogeSuspension"].
					'","nHistorial":"'.$nHistorial.'","tipoIngreso":"'.$tipoIngreso.'","sentencia":"'.$sentencia.
					'","fechaPrescripcion":"'.$fPena["fechaPrescripcion"].'","abonoPrisionPreventiva":"'.$abonoPrisionPreventiva.
					'","abonoPrisionPunitiva":"'.$abonoPrisionPunitiva.'","arrSustitutivos":'.$arrSustitutivos.'}';
		$nPenas++;
		$numReg++;

		if($arrRegistros=="")
			$arrRegistros=$objFinal;
		else
			$arrRegistros.=",".$objFinal;
	}
		
		
		
	
	
	echo '{"numReg":"'.$total.'","registros":['.$arrRegistros.']}';
}

function obtenerAudienciasProgramadasCarpetaJudicial()
{
	global $con;
	$cAdministrativa=$_POST["cA"];
	
	$consulta="SELECT e.idRegistroEvento,horaInicioEvento,a.tipoAudiencia,
			(SELECT ej.idJuez FROM 7001_eventoAudienciaJuez eJ WHERE eJ.idRegistroEvento=e.idRegistroEvento LIMIT 0,1) AS juez 
			FROM 7007_contenidosCarpetaAdministrativa con,7000_eventosAudiencia e,_4_tablaDinamica a
			WHERE con.carpetaAdministrativa='".$cAdministrativa."' AND e.idRegistroEvento=con.idRegistroContenidoReferencia AND con.tipoContenido=3
			AND a.id__4_tablaDinamica=e.tipoAudiencia ORDER BY horaInicioEvento";
	$arrRegistros=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT ju.usuarioJuez, CONCAT('[',ju.clave,'] ',u.Nombre),ju.clave FROM _17_tablaDinamica ug,_26_tablaDinamica ju,800_usuarios u,
			7006_carpetasAdministrativas c WHERE ug.claveUnidad=c.unidadGestion and  c.carpetaAdministrativa='".$cAdministrativa."' AND ug.id__17_tablaDinamica=ju.idReferencia AND u.idUsuario=ju.usuarioJuez 
			ORDER BY ju.clave,u.Nombre";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
	
	echo "1|".$arrRegistros."|".$arrJueces;			
	
}

function obtenerCarpetasEjecucionListaCarpetas()
{
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	global $con;
	
	$consulta="SELECT count(*) FROM 7006_carpetasAdministrativas c WHERE tipoCarpetaAdministrativa=6 and ".$cadCondWhere;
	$nFilas=$con->obtenerValor($consulta);
	
	$consulta="SELECT carpetaAdministrativa,unidadGestion,situacion, 
				(
				SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=c.idActividad AND r.idFiguraJuridica=4
				AND i.id__47_tablaDinamica=r.idParticipante
				) AS imputados,
				(
				SELECT GROUP_CONCAT(i.denominacionDelito) FROM _61_tablaDinamica r,_35_denominacionDelito i WHERE r.idActividad=c.idActividad AND 
				i.id__35_denominacionDelito=r.denominacionDelito
				
				) AS delitos,
				carpetaInvestigacion,carpetaAdministrativaBase
				
				FROM 7006_carpetasAdministrativas c WHERE tipoCarpetaAdministrativa=6 and ".$cadCondWhere." limit ".$start.",".$limit;


	$arrRegistros="";
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
			
		$o='{"carpetaAdministrativa":"'.$fila[0].'","unidadGestion":"'.$fila[1].'","situacion":"'.$fila[2].
			'","carpetaInvestigacion":"'.$fila[5].'","imputados":"'.cv($fila[3]).'","delitos":"'.cv($fila[4]).
			'","carpetaAdministrativaBase":"'.$fila[6].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	echo '{"numReg":"'.$nFilas.'","registros":['.$arrRegistros.']}';	
}


function obtenerPuestosEstructuraOrganizacionUGJ()
{
	global $con;

	$iUG=$_POST["unidadGestion"];
	
	$consulta="SELECT idPadre FROM _420_unidadGestion WHERE idOpcion=".$iUG;
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil=-1;
	
	$arrPuestos="";
	$arrHijos="";
	$consulta="SELECT claveNivel,puestoOrganozacional,usuarioAsignado FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND tipoNivel=1";
	$fila=$con->obtenerPrimeraFila($consulta);
	$nombrePuesto="NO DEFINIDO";
	$empleado='<span style="color:#F00 !important; font-weight:bold" id="sp_'.$fila[0].'">VACANTE</span>';
	$datosContacto="(Sin datos de contacto)";
	if($fila)
	{
		$consulta="SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=".$fila[1];
		$nombrePuesto=$con->obtenerValor($consulta);
		if($fila[2]!="")
			$empleado='<span style="color:#030 !important; font-weight:bold" id="sp_'.$fila[0].'">'.obtenerNombreUsuario($fila[2]).'</span>';
			
		$arrHijos=obtenerNodosHijosEstructuraUGAV2($idPerfil,$fila[0]);
		$arrPuestos='{"icon":"../images/s.gif","expanded":true,"idPerfil":"'.$idPerfil.'","claveNivel":"'.$fila[0].'","idEmpleado":"'.$fila[2].'","puesto":"'.cv($nombrePuesto).'","nombreEmpleado":"'.cv($empleado).'","children":'.$arrHijos.',"leaf":'.($arrHijos=="[]"?"true":"false").'}';
		
	}
	echo '['.$arrPuestos.']';
	
}

function obtenerNodosHijosEstructuraUGAV2($idPerfil,$iPuesto)
{
	global $con;
	
	$arrRegistros="";
	$consulta="SELECT claveNivel,(SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=pE.puestoOrganozacional) AS puestoOrganozacional,usuarioAsignado 
			FROM _421_tablaDinamica pE WHERE idReferencia=".$idPerfil." AND claveNivel LIKE '".$iPuesto."____' AND situacion=1 ORDER BY claveNivel";
	$res=$con->obtenerFilas($consulta);		
	while($fila=$con->fetchRow($res))
	{
		$arrHijos=obtenerNodosHijosEstructuraUGAV2($idPerfil,$fila[0]);
		
		$nombrePuesto="NO DEFINIDO";
		if($fila[1]!="")
			$nombrePuesto=$fila[1];
		$empleado='<span style="color:#F00 !important; font-weight:bold" id="sp_'.$fila[0].'">VACANTE</span>';
		if($fila[2]!="")
			$empleado='<span style="color:#030 !important; font-weight:bold" id="sp_'.$fila[0].'">'.obtenerNombreUsuario($fila[2]).'</span>';
		$datosContacto="(Sin datos de contacto)";
		
		$o='{"icon":"../images/s.gif","idPerfil":"'.$idPerfil.'","claveNivel":"'.$fila[0].'","expanded":true,"idEmpleado":"'.$fila[2].'","puesto":"'.cv($nombrePuesto).'","nombreEmpleado":"'.cv($empleado).'","children":'.$arrHijos.',"leaf":'.($arrHijos=="[]"?"true":"false").'}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	return "[".$arrRegistros."]";
	
	
}


function agregarPuestoEstructuraUGJ()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	if($obj->idPerfil==-1)
	{
		
		$query="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$obj->iUGJ;
		$nombreUGA=$con->obtenerValor($query);
		
		$consulta[$x]="INSERT INTO _420_tablaDinamica(fechaCreacion,responsable,idEstado,nombrePerfil)VALUES('".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].",1,'".cv($nombreUGA)."')";
		$x++;
		$consulta[$x]="select @idPerfil:=(select last_insert_id())";
		$x++;
		$consulta[$x]="INSERT INTO _420_unidadGestion(idPadre,idOpcion) VALUES(@idPerfil,".$obj->iUGJ.")";
		$x++;
		
	}
	else
	{
		$consulta[$x]="select @idPerfil:=".$obj->idPerfil;
		$x++;
	}
	$claveNivel="";
	$tipoNivel="";
	
	if($obj->puestoSuperior=="")
	{
		$claveNivel="0001";
		$tipoNivel=1;
	}
	else
	{
		$tipoNivel=2;
		$query="SELECT claveNivel FROM _421_tablaDinamica WHERE idReferencia=".$obj->idPerfil." AND claveNivel LIKE '".$obj->puestoSuperior."____' order by claveNivel desc";
	
		
		$claveNivel=$con->obtenerValor($query);
		
		if($claveNivel=="")
			$claveNivel=$obj->puestoSuperior."0001";
		else
		{
			$claveNivel=substr($claveNivel,-4);
			$claveNivel++;
			$claveNivel=str_pad($claveNivel,4,"0",STR_PAD_LEFT);
			$claveNivel=$obj->puestoSuperior.$claveNivel;
		}
		
	}

	$consulta[$x]="INSERT INTO _421_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,tipoNivel,claveNivel,situacion,puestoOrganozacional,usuarioAsignado)
					values(@idPerfil,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,".$tipoNivel.",'".$claveNivel."',1,".$obj->puestoAgrega.",NULL)";
	$x++;
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		$query="select @idPerfil";
		$idPerfil=$con->obtenerValor($query);
		echo "1|".$idPerfil;
	}
	
}

function removerPuestoEstructuraUGJ()
{
	global $con;
	$cadObj=$_POST["cadObj"];	
	$obj=json_decode($cadObj);	
	$query="delete FROM _421_tablaDinamica WHERE idReferencia=".$obj->idPerfil." AND (claveNivel='".$obj->puestoRemover.
			"' or claveNivel LIKE '".$obj->puestoRemover."%')";
		
	eC($query);
	
}

function obtenerDocumentosPermitidosModuloGeneracionDocumentos()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$idProceso=$_POST["idProceso"];
	$idFormularioProceso=$_POST["idFormularioProceso"];
	$consulta="SELECT idFormato as idDocumento FROM 3019_generacionDocumentosPermitidos WHERE idProceso=".$idProceso.
			" AND idPerfil=".$idPerfil." and idFormularioProceso=".$idFormularioProceso;
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
}

function agregarDocumentosPermitidosModuloGeneracionDocumentos()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$idProceso=$_POST["idProceso"];
	$idFormato=$_POST["idFormato"];
	$idFormularioProceso=$_POST["idFormularioProceso"];
	$consulta="INSERT INTO 3019_generacionDocumentosPermitidos(idFormato,idProceso,idPerfil,idFormularioProceso) 
				VALUES(".$idFormato.",".$idProceso.",".$idPerfil.",".$idFormularioProceso.")";
	eC($consulta);
	
	
	
}

function removerDocumentosPermitidosModuloGeneracionDocumentos()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$idProceso=$_POST["idProceso"];
	$idFormato=$_POST["idFormato"];
	$idFormularioProceso=$_POST["idFormularioProceso"];
	$consulta="delete from 3019_generacionDocumentosPermitidos where idFormato=".$idFormato." and idProceso=".$idProceso.
				" and idPerfil=".$idPerfil." and idFormularioProceso=".$idFormularioProceso;
	eC($consulta);
	
	
	
}


function obtenerFormatosDocumentosPermitidosModuloGeneracionDocumentos()
{
	global $con;
	$criterio=$_POST["criterio"];
	$consulta="select * from (SELECT id__10_tablaDinamica as idFormato,CONCAT('(',cveFormato,') ',nombreFormato) as formato FROM _10_tablaDinamica) as tmp
				where formato like '%".$criterio."%'";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
	
}

function registrarSituacionPena()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$idPena=$obj->idPena;
	$situacionCambio=$obj->situacionPena;
	$comentarios=$obj->comentariosAdicionales;
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	switch($situacionCambio)
	{
		case 1:
			
			$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$idPena;
			$fPena=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$abonoPrisionPunitiva="";
			if(isset($obj->abonoPrisionPunitiva))
			{
				$abonoPrisionPunitiva=$obj->abonoPrisionPunitiva;
				$cadObj=setAtributoCadJson($cadObj,"abonoPrisionPunitivaOriginal",$fPena["abonoPrisionPunitiva"]);
			}
			$fechaPrescripcion=(isset($obj->fechaPrescripcion)&&($obj->fechaPrescripcion!=""))?"'".$fechaPrescripcion."'":"NULL";
			$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET fechaInicio=".(isset($obj->fechaInicio)?"'".$obj->fechaInicio."'":"NULL").
					",fechaTermino='".$obj->fechaCumplimiento."',fechaPrescripcion=".$fechaPrescripcion.",situacion=".$situacionCambio.",abonoPrisionPunitiva='".$abonoPrisionPunitiva.
					"' WHERE idRegistro=".$idPena;
			$x++;
			$cadObj=setAtributoCadJson($cadObj,"fechaInicioOriginal",$fPena["fechaInicio"]);
			$cadObj=setAtributoCadJson($cadObj,"fechaTerminoOriginal",$fPena["fechaTermino"]);
		break;
		case 2:
		case 3:
			$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET situacion=".$situacionCambio." WHERE idRegistro=".$idPena;
			$x++;
		break;
	}
	
	
	$query[$x]="commit";
	$x++;
	
	
	$datosComplementarios=$cadObj;
	if(registrarBitacoraCambioPenas($idPena,$situacionCambio,$comentarios,$datosComplementarios) && ($con->ejecutarBloque($query)))
	{
		
			echo "1|";
	}
}
	
function obtenerHistorialPena()
{
	global $con;
	$numReg=0;
	$arrRegistros="";
	$idPena=$_POST["idPena"];
	$consulta="SELECT * FROM 7024_bitacoraCambiosPena WHERE idPena=".$idPena." order by fechaCambio desc";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$detalles="";
		if($fila["datosComplementarios"]!="")
		{
			$oComp=json_decode($fila["datosComplementarios"]);
			switch($oComp->situacionPena)
			{
				case 1:

					if(isset($oComp->condicionesCumplimiento))
					{
						$detalles="<b>Condiciones de cumplimiento:</b> ".$oComp->condicionesCumplimiento."<br><br>";
						$detalles.="<b>Fecha en que debe cumplirse:</b> ".date("d/m/Y",strtotime($oComp->fechaCumplimiento))."<br><br>";
						if($oComp->fechaPrescripcion!="")
						{
							$detalles.="<b>Fecha en que prescribe:</b> ".date("d/m/Y",strtotime($oComp->fechaPrescripcion))."<br><br>";
						}

						if($oComp->fechaInicioOriginal!="")
						{
							$detalles.="<b>Fecha de inicio original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioOriginal))."<br><br>";
						}

						if($oComp->fechaTerminoOriginal!="")
						{
							if($oComp->fechaInicioOriginal!="")
								$detalles.="<b>Fecha de t&eacute;rmino original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoOriginal))."<br><br>";
							else
								$detalles.="<b>Fecha en que debe cumplirse original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoOriginal))."<br><br>";
						}
						if($oComp->fechaPrescripcionOriginal!="")
						{
							$detalles.="<b>Fecha de prescripci&oacute;n original:</b> ".date("d/m/Y",strtotime($oComp->fechaPrescripcionOriginal))."<br><br>";
						}
					}
					else
					{
						if($oComp->fechaInicioOriginal!="")

							$detalles.="<b>Fecha de inicio original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioOriginal))."<br><br>";
						else
							$detalles.="<b>Fecha de inicio original:</b> (Sin fecha)<br><br>";

						$arrSentencia=explode("_",$oComp->sentencia);
						$abonoPrisionPreventiva=explode("_",$oComp->abonoPrisionPreventiva);
						$abonoPrisionPunitiva=explode("_",$oComp->abonoPrisionPunitiva);
						$arrPorCumplir=restarComputo($arrSentencia,$abonoPrisionPreventiva);
						$arrPorCumplir=restarComputo($arrPorCumplir,$abonoPrisionPunitiva);
						$detalles.="<b>Sentencia:</b> ".convertirLeyendaComputo($arrSentencia)."<br><br>";
						$detalles.="<b>Abono prisi&eacuten preventiva:</b> ".convertirLeyendaComputo($abonoPrisionPreventiva)."<br><br>";
						$detalles.="<b>Abono prisi&eacuten punitiva:</b> ".convertirLeyendaComputo($abonoPrisionPunitiva)."<br><br>";
						$detalles.="<b>Por cumplir:</b> ".convertirLeyendaComputo($arrPorCumplir)."<br><br>";

						if($oComp->fechaTerminoOriginal!="")
						{

							$detalles.="<b>Fecha de t&eacute;rmino original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoOriginal))."<br><br>";
						}
						else
							$detalles.="<b>Fecha de t&eacute;rmino original:</b> (Sin fecha)<br><br>";
					}
				break;
				case 2:
					$detalles="<b>Medio en que se declara extinta:</b> ".($oComp->medioDeclaracion==1?"En audiencia":"Por escrito")."<br><br>";
					if($oComp->medioDeclaracion==1)
					{
						$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$oComp->audienciaDeclaracion;
						$fechaAudiencia=$con->obtenerValor($consulta);
						$detalles.="<b>Fecha de la audiencia:</b> ".date("d/m/Y H:i",strtotime($fechaAudiencia))."<br><br>";
					}
					else
						$detalles.="<b>Fecha en que se declara extinta:</b> ".date("d/m/Y",strtotime($oComp->fechaDeclaracion))."<br><br>";

					$detalles.="<b>Juez que declara la extinsi&oacute;n:</b> ".obtenerNombreUsuario($oComp->juezDeclaracion)."<br><br>";


				break;
				case 3:
					$detalles="<b>Medio en que se declara prescrita:</b> ".($oComp->medioDeclaracion==1?"En audiencia":"Por escrito")."<br><br>";
					if($oComp->medioDeclaracion==1)
					{
						$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$oComp->audienciaDeclaracion;
						$fechaAudiencia=$con->obtenerValor($consulta);
						$detalles.="<b>Fecha de la audiencia:</b> ".date("d/m/Y H:i",strtotime($fechaAudiencia))."<br><br>";
					}
					else
						$detalles.="<b>Fecha en que se declara prescrita:</b> ".date("d/m/Y",strtotime($oComp->fechaDeclaracion))."<br><br>";

					$detalles.="<b>Juez que declara la prescripci&oacute;n:</b> ".obtenerNombreUsuario($oComp->juezDeclaracion)."<br><br>";
				break;
				case 6:
						$consulta="SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$oComp->idSustitutivo;
						$sustitutivo=$con->obtenerValor($consulta);
						$detalles.="<b>Sustitutivo acogido:</b> ".$sustitutivo."<br><br>";
						if(isset($oComp->montoSustitutivoOriginal))	
						{
							if(($oComp->montoSustitutivoOriginal!=$oComp->montoSustitutivo)&&($oComp->montoSustitutivoOriginal!=""))
							{
								$detalles.="<b>Monto:</b>$ ".number_format($oComp->montoSustitutivo,2)."<br><br>";
								$detalles.="<b>Monto original:</b>$ ".number_format($oComp->montoSustitutivoOriginal,2)."<br><br>";
							}
							else
							{
								$detalles.="<b>Monto:</b>$ ".number_format($oComp->montoSustitutivo,2)."<br><br>";
							}
						}
						
						if($oComp->fechaInicioOriginal!="")
							$detalles.="<b>Fecha de inicio de pena original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioOriginal))."<br><br>";
						else
							$detalles.="<b>Fecha de inicio de pena original:</b> (Sin fecha)<br><br>";
						
						if($oComp->fechaTerminoOriginal!="")
						{
							$detalles.="<b>Fecha de t&eacute;rmino de pena original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoOriginal))."<br><br>";
						}
						else
							$detalles.="<b>Fecha de t&eacute;rmino de pena original:</b> (Sin fecha)<br><br>";
					
						if(isset($oComp->periodoSustitutivo))	
						{
							if(($oComp->periodoSustitutivo!=$oComp->periodoSustitutivoOriginal)&&($oComp->periodoSustitutivoOriginal!=""))
							{
								$detalles.="<b>Periodo a cumplir:</b> ".convertirLeyendaComputo(explode("|",$oComp->periodoSustitutivo))."<br><br>";
								$detalles.="<b>Periodo a cumplir original:</b> ".convertirLeyendaComputo(explode("|",$oComp->periodoSustitutivoOriginal))."<br><br>";
							}
							else
							{
								$detalles.="<b>Periodo a cumplir:</b> ".convertirLeyendaComputo(explode("|",$oComp->periodoSustitutivo))."<br><br>";
							}
						}
						
						
						
						if($oComp->fechaInicioSustitutivoOriginal!="")
						{
							
							if(($oComp->fechaInicio==$oComp->fechaInicioSustitutivoOriginal)&&($oComp->fechaTermino==$oComp->fechaTerminoSustitutivoOriginal))
							{
								if($oComp->fechaTermino=="")
								{
									$detalles.="<b>Fecha de cumplimiento:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
								}
								else
								{
									$detalles.="<b>Fecha de inicio de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
									$detalles.="<b>Fecha de t&eacute;rmino de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaTermino))."<br><br>";
								}
							}
							else
							{
								if($oComp->fechaTermino=="")
								{
									$detalles.="<b>Fecha de cumplimiento original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioSustitutivoOriginal))."<br><br>";
									$detalles.="<b>Fecha de cumplimiento:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
								}
								else
								{
									$detalles.="<b>Fecha de inicio de sustitutivo original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioSustitutivoOriginal))."<br><br>";
									$detalles.="<b>Fecha de t&eacute;rmino de sustitutivo original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoSustitutivoOriginal))."<br><br>";
									$detalles.="<b>Fecha de inicio de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
									$detalles.="<b>Fecha de t&eacute;rmino de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaTermino))."<br><br>";
								}	
							}
							
						}
						else
						{
							if($oComp->fechaInicio!="")
							{
								if($oComp->fechaTermino=="")
								{
									$detalles.="<b>Fecha de cumplimiento:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
								}
								else
								{
									$detalles.="<b>Fecha de inicio de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
									$detalles.="<b>Fecha de t&eacute;rmino de sustitutivo:</b> ".date("d/m/Y",strtotime($oComp->fechaTermino))."<br><br>";
								}
							}
						}
					
						$detalles.="<b>Detalles adicionales:</b><br>".($oComp->detallesAdicionales==""?"(Sin comentarios)":cv($oComp->detallesAdicionales))."<br><br>";	
				break;
				case 7:
						if($oComp->fechaInicioOriginal!="")
						{
							
							
							if($oComp->fechaTerminoOriginal=="")
							{
								$detalles.="<b>Fecha de cumplimiento original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioOriginal))."<br><br>";
								$detalles.="<b>Fecha de cumplimiento:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
							}
							else
							{
								$detalles.="<b>Fecha de inicio original:</b> ".date("d/m/Y",strtotime($oComp->fechaInicioOriginal))."<br><br>";
								$detalles.="<b>Fecha de t&eacute;rmino original:</b> ".date("d/m/Y",strtotime($oComp->fechaTerminoOriginal))."<br><br>";
								$detalles.="<b>Fecha de inicio:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
								$detalles.="<b>Fecha de t&eacute;rmino:</b> ".date("d/m/Y",strtotime($oComp->fechaTermino))."<br><br>";
							}	
							
							
						}
						else
						{
							if($oComp->fechaInicio!="")
							{
								if($oComp->fechaTermino=="")
								{
									$detalles.="<b>Fecha de cumplimiento:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
								}
								else
								{
									$detalles.="<b>Fecha de inicio:</b> ".date("d/m/Y",strtotime($oComp->fechaInicio))."<br><br>";
									$detalles.="<b>Fecha de t&eacute;rmino:</b> ".date("d/m/Y",strtotime($oComp->fechaTermino))."<br><br>";
								}
							}
						}
						
						$detalles.="<b>Motivo de la cancelaci&oacute;n:</b><br>".($oComp->motivoCancelacion==""?"(Sin comentarios)":cv($oComp->motivoCancelacion))."<br><br>";	
				break;
			}
		}
		$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaOperacion":"'.$fila["fechaCambio"].'","etapaOriginal":"'.$fila["etapaActual"].
				'","etapaCambio":"'.$fila["etapaCambio"].'","responsable":"'.obtenerNombreUsuario($fila["idUsuarioResponsable"]).'","comentarios":"'.
			cv($fila["comentariosAdicionales"]).'","detalles":"'.cv($detalles).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
}


function registrarAcogeSuspencionCondicionalPena()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	
	$consulta="SELECT * FROM  7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$obj->idPena;
	$fPena=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$idActividad=$fPena["idActividad"];
	$consulta="SELECT distinct rp.idRegistro FROM 7024_registroPenasSentenciaEjecucion rp,_405_gPenaSuspensionCondicional ps 
			WHERE rp.idActividad=".$idActividad." and ps.idPena=rp.idRegistro";
	$resPenas=$con->obtenerFilas($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE _405_tablaDinamica SET acogeSuspension=".$obj->seAcoge." WHERE idActividad=".$idActividad;
	$x++;
	while($fPena=$con->fetchRow($resPenas))
	{
		$situacionCambio=$obj->seAcoge==1?4:5;
		registrarBitacoraCambioPenas($fPena[0],$situacionCambio,$obj->comentariosAdicionales,"");
	}
	$query[$x]="commit";
	$x++;
	eB($query);
	
	
	
}

function registrarAcogeSustitutivo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT periodoSustitutivo,montoSustitutivo,fechaInicio,fechaTermino FROM 7026_registroSustitutivoPena WHERE idPena=".$obj->idPena." AND idSustitutivo=".$obj->idSustitutivo;
	$fDatosSustitutivos=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$obj->idPena;
	$fPena=$con->obtenerPrimeraFilaAsoc($consulta);
	
	if(isset($obj->periodoSustitutivo)&&($obj->periodoSustitutivo!=""))
	{
		$cadObj=setAtributoCadJson($cadObj,"periodoSustitutivoOriginal",$fDatosSustitutivos["periodoSustitutivo"]);
	}
	
	
	if(isset($obj->montoSustitutivo)&&($obj->montoSustitutivo!=""))
	{
		$cadObj=setAtributoCadJson($cadObj,"montoSustitutivoOriginal",$fDatosSustitutivos["montoSustitutivo"]);
	}

	
	$cadObj=setAtributoCadJson($cadObj,"situacionPena",6);
	$cadObj=setAtributoCadJson($cadObj,"fechaInicioOriginal",$fPena["fechaInicio"]);
	$cadObj=setAtributoCadJson($cadObj,"fechaTerminoOriginal",$fPena["fechaTermino"]);
	
	$cadObj=setAtributoCadJson($cadObj,"fechaInicioSustitutivoOriginal",$fDatosSustitutivos["fechaInicio"]);
	$cadObj=setAtributoCadJson($cadObj,"fechaTerminoSustitutivoOriginal",$fDatosSustitutivos["fechaTermino"]);
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE 7026_registroSustitutivoPena SET acogeSustitutivo=0 WHERE idPena=".$obj->idPena;
	$x++;
	$query[$x]="UPDATE 7026_registroSustitutivoPena SET acogeSustitutivo=1,detallesAdicionales='".cv($obj->detallesAdicionales).
				"',montoSustitutivo=".($obj->montoSustitutivo==""?"NULL":$obj->montoSustitutivo).",
				periodoSustitutivo=".($obj->periodoSustitutivo==""?"NULL":"'".$obj->periodoSustitutivo."'").
				", fechaInicio=".($obj->fechaInicio==""?"NULL":"'".$obj->fechaInicio."'").
				",fechaTermino=".($obj->fechaTermino==""?"NULL":"'".$obj->fechaTermino."'").
				" WHERE idPena=".$obj->idPena." AND idSustitutivo=".$obj->idSustitutivo;
	$x++;
	$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET seAcogeSustitutivo=1,idSustitutivoAcoge=".$obj->idSustitutivo.",
				fechaInicio=".($obj->fechaInicio==""?"NULL":"'".$obj->fechaInicio."'").",fechaTermino=".($obj->fechaTermino==""?"NULL":"'".$obj->fechaTermino."'")."
				WHERE idRegistro=".$obj->idPena;
	$x++;
	$query[$x]="commit";
	$x++;
	if(registrarBitacoraCambioPenas($obj->idPena,6,"",$cadObj) && $con->ejecutarBloque($query))
	{
		
		echo "1|";
	}
}

function registrarCancelacionAcogimientoSustitutivo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT * FROM 7024_registroPenasSentenciaEjecucion WHERE idRegistro=".$obj->idPena;
	$fPena=$con->obtenerPrimeraFilaAsoc($consulta);
	$cadObj=setAtributoCadJson($cadObj,"situacionPena",7);
	$cadObj=setAtributoCadJson($cadObj,"fechaInicioOriginal",$fPena["fechaInicio"]);
	$cadObj=setAtributoCadJson($cadObj,"fechaTerminoOriginal",$fPena["fechaTermino"]);
		
	
	
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="UPDATE 7026_registroSustitutivoPena SET acogeSustitutivo=0 WHERE idPena=".$obj->idPena;
	$x++;
	
	$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET seAcogeSustitutivo=0,idSustitutivoAcoge=NULL,
				fechaInicio=".($obj->fechaInicio==""?"NULL":"'".$obj->fechaInicio."'").",fechaTermino=".($obj->fechaTermino==""?"NULL":"'".$obj->fechaTermino."'").",
				fechaPrescripcion=".((!isset($obj->fechaPrescripcion)||($obj->fechaPrescripcion==""))?"NULL":"'".$obj->fechaPrescripcion."'")." WHERE idRegistro=".$obj->idPena;
	
	$x++;
	$query[$x]="commit";
	$x++;
	if(registrarBitacoraCambioPenas($obj->idPena,7,"",$cadObj) && $con->ejecutarBloque($query))
	{
		
		echo "1|";
	}
}

function obtenerPlantillasModeloSeleccion()
{
	global $con;
	
	$idFormulario=-1;
	$idRegistro=-1;
	$actor=-1;
	if(isset($_POST["idFormulario"]))
		$idFormulario=$_POST["idFormulario"];
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	
	if(isset($_POST["actor"]))
		$actor=$_POST["actor"];
	
	$idPerfil=$_POST["idPerfil"];
	
	$idFormularioProceso=$_POST["idFormularioProceso"];
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	
	$tipoUnidad=-1;
	$listaDocumentos=-1;
	if($idRegistro!=-1)
	{
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT tipoDelito FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u,_17_gridDelitosAtiende d WHERE u.claveUnidad=c.unidadGestion
					AND carpetaAdministrativa='".$carpetaAdministrativa."' AND d.idReferencia=u.id__17_tablaDinamica";
		$tipoUnidad=$con->obtenerListaValores($consulta,"'");
		if($tipoUnidad=="")
			$tipoUnidad="0";
	}
	
	$consulta="SELECT idFormato as idDocumento FROM 3019_generacionDocumentosPermitidos WHERE idProceso=".$idProceso.
			" AND idPerfil=".$idPerfil." and idFormularioProceso=".$idFormularioProceso;

	$listaDocumentos=$con->obtenerListaValores($consulta);
	
	if($listaDocumentos=="")
		$listaDocumentos=-1;

	

	$arrRegistros="";
	$consulta=" SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos where idCategoria not in(0) ORDER BY nombreCategoria";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrHijos="";
		
		$consulta="SELECT id__10_tablaDinamica,nombreFormato,descripcion,perfilValidacion FROM _10_tablaDinamica f,_10_chkVersionPlantilla v 
					WHERE f.categoriaDocumento=".$fila[0]." AND v.idPadre=f.id__10_tablaDinamica AND v.idOpcion IN(2) ".
					($listaDocumentos!=-1?" and id__10_tablaDinamica in(".$listaDocumentos.")":"")."
					ORDER BY nombreFormato ";
		
		if($tipoUnidad!=-1)
		{
			$consulta="SELECT id__10_tablaDinamica,nombreFormato,descripcion,perfilValidacion FROM _10_tablaDinamica f,_10_chkVersionPlantilla v,
					_10_tiposUGJ tU WHERE f.categoriaDocumento=".$fila[0]." AND v.idPadre=f.id__10_tablaDinamica AND v.idOpcion IN(2) 
					and tU.idPadre=f.id__10_tablaDinamica and tU.idOpcion in(".$tipoUnidad.") ".($listaDocumentos!=-1?" and id__10_tablaDinamica in(".
					$listaDocumentos.")":"")." ORDER BY nombreFormato ";
		
			
		
		}
		
		
		
		
		$rDocumentos=$con->obtenerFilas($consulta);
		while($fDocumentos=$con->fetchAssoc($rDocumentos))
		{
			$oDoc='{"tipoNodo":"2","icon":"../images/s.gif","id":"'.$fDocumentos["id__10_tablaDinamica"].'","text":"'.cv($fDocumentos["nombreFormato"]).
					'","perfilValidacion":"'.($fDocumentos["perfilValidacion"]==""?-1:$fDocumentos["perfilValidacion"]).'","descripcion":"'.cv($fDocumentos["descripcion"]).'","leaf":true,"children":[]}';
			if($arrHijos=="")
				$arrHijos=$oDoc;
			else
				$arrHijos.=",".$oDoc;
		}
		
		if($arrHijos=="")
			continue;
		
		
		
		$o='{"tipoNodo":"1","icon":"../images/s.gif","id":"c_'.$fila[0].'","text":"<b>'.$fila[1].'</b>","descripcion":"",leaf:'.($arrHijos==""?"true":"false").',children:['.$arrHijos.']}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '['.$arrRegistros.']';
}



function obtenerEventosFechaSala()
{
	global $con;
	global $tipoMateria;
	$idSala=$_POST["idSala"];
	$asignacionJuez=$_POST["asignacionJuez"];
	
	$arrEventos="";
	
	
	$start=$_POST["start"];
	$end=$_POST["end"];
	
	$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) as tipoAudiencia,idRegistroEvento FROM 7000_eventosAudiencia a
				WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
				a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";


	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
		$cAdministrativa=$con->obtenerValor($consulta);
		
		
		$e='{"id":"e_'.$fila[3].'","editable":false,"title":"('.$fila[3].') '.cv($fila[2]).' ['.$cAdministrativa.']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
	
	
	if($asignacionJuez!=0)
	{
		
	
			$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) as tipoAudiencia,a.idRegistroEvento FROM 7000_eventosAudiencia a,7001_eventoAudienciaJuez e
						WHERE e.idJuez=".$asignacionJuez." and  e.idRegistroEvento=a.idRegistroEvento AND fechaEvento>='".$start."' AND 
						fechaEvento<='".$end."' and a.situacion in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
			$cAdministrativa=$con->obtenerValor($consulta);
		
				$e='{"id":"eJ_'.$fila[3].'","editable":false,"title":"('.$fila[3].') '.cv($fila[2]).' ['.$cAdministrativa.']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#E56A4B"}';	
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
			$consulta="SELECT fechaInicial,fechaFinal,id__20_tablaDinamica FROM _20_tablaDinamica 
					WHERE usuarioJuez=".$asignacionJuez." and fechaInicial<='".$start."' and fechaFinal>='".$start."' and idEstado=1";
			$iJuez=$con->obtenerFilas($consulta);
			while($fIncidencia=$con->fetchRow($iJuez))
			{
				
				$e='{"id":"iJ_'.$fIncidencia[2].'","editable":false,"title":"El juez se reporta como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#3D00CA"}';	
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
			}
			
		
	}
	
	
	if(($tipoMateria=="C")&&($idSala==70))//Eliminar Sala
	{
		if(date("w",strtotime($start))==4)
		{
			
			
			
			$e='{"id":"iS_-1","editable":false,"title":"La sala ha sido marcada como No disponible","start":"'.($start."T00:00:00").'","end":"'.($start."T23:59:59").'","color":"#B55381"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
			
		}
	}
	/*
	$consulta="SELECT idCentroGestion FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE e.idRegistroEvento=j.idRegistroEvento and
			idRegistroEventoJuez=".$idEvento;
	$idUnidadGestion=$con->obtenerValor($consulta);
	if($idUnidadGestion=="")*/
		$idUnidadGestion=-1;
		
	$consulta="SELECT idPadre FROM _25_chkUnidadesAplica WHERE idOpcion=".$idUnidadGestion;	
	$listaIncidencias=$con->obtenerValor($consulta);
	if($listaIncidencias=="")
		$listaIncidencias=-1;
		
	$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s 
				WHERE s.idReferencia=t.id__25_tablaDinamica AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start.
				"' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=1
				union
				SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s 
				WHERE s.idReferencia=t.id__25_tablaDinamica AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start.
				"' AND s.nombreSala=".$idSala." and idEstado=2 and aplicaTodasUnidades=0  and id__25_tablaDinamica in(".$listaIncidencias.")";
	
	
	
	$iSala=$con->obtenerFilas($consulta);
	while($fIncidencia=$con->fetchRow($iSala))
	{
		$horaInicial="00:00:00";
		$horaFinal="23:59:59";
		if($fIncidencia[1]=="")
			$fIncidencia[1]=$horaInicial;
		
		if($fIncidencia[3]=="")
			$fIncidencia[3]=$horaFinal;
			
		
		
		if($fIncidencia[5]==2)
		{
			
			if($fIncidencia[0]==$start)
			{
				$horaInicial=$fIncidencia[1];
			}
			
			
			if($fIncidencia[2]==$start)
			{
				$horaFinal=$fIncidencia[3];
			}
			
		}
		else
		{
			$horaInicial=$fIncidencia[1];
			$horaFinal=$fIncidencia[3];
		}
		
		$e='{"id":"iS_'.$fila[4].'","editable":false,"title":"La sala ha sido marcada como No disponible","start":"'.($start."T".$horaInicial).'","end":"'.($start."T".$horaFinal).'","color":"#B55381"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}

	
	echo '['.$arrEventos.']';
	
}

function registrarCategoriaDcumentoAdjunto()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idRegistro FROM 3019_categoriaDocumentosAdjuntos WHERE idProceso=".$obj->idProceso.
			" AND idPerfil=".$obj->idPerfil." AND idFormularioProceso=".$obj->idFormularioProceso;
			
	$idRegistro=$con->obtenerValor($consulta);
	
	if($idRegistro=="")
	{
		$consulta="INSERT INTO 3019_categoriaDocumentosAdjuntos(idCategoriaDocumento,idProceso,idPerfil,idFormularioProceso) 
					VALUES(".$obj->idCategoria.",".$obj->idProceso.",".$obj->idPerfil.",".$obj->idFormularioProceso.")";
	}
	else
	{
		$consulta="UPDATE 3019_categoriaDocumentosAdjuntos SET idCategoriaDocumento=".$obj->idCategoria." WHERE idRegistro=".$idRegistro;
	}
	
	eC($consulta);
	
}

function obtenerFechaAudienciaDiasHabiles()
{
	global	$con;
	$fechaBase=$_POST["fB"];
	$diasBase=0;
	$dias=$_POST["d"];
	$meses=$_POST["m"];
	$tDias=$_POST["tD"]; //1=Habiles; 2=Naturales
	if($meses>0)
	{
		$fechaBase=date("Y-m-d",strtotime("+ ".$meses." months",strtotime($fechaBase)));
	}
	$totalDias=0;
	if($tDias==1)
	{
		$nDias=0;
		while($nDias<$dias)
		{
			$fechaBase=date("Y-m-d",strtotime("+1 days",strtotime($fechaBase)));
			if(esDiaHabilInstitucion($fechaBase))
			{
				$nDias++;
			}
		}
		
	}
	else
	{
		$fechaBase=date("Y-m-d",strtotime("+ ".$dias." days",strtotime($fechaBase)));	
		

	}
	echo "1|".obtenerSiguienteDiaHabil($fechaBase);
	
	
	
	
}


function  obtenerUltimoJuezAudienciaCarpeta()
{
	global $con;
	global $tipoMateria;
	$fechaAudiencia=$_POST["fechaAudiencia"];
	
	$cJudicial=$_POST["cJudicial"];
	
	$tipoJuez="";
	$consulta="SELECT tipoCarpetaAdministrativa,idJuezTitular,unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cJudicial."'";
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$tCarpeta=$fCarpeta[0];
	$idJuezTitular=$fCarpeta[1];
	$cveUGJ=$fCarpeta[2];
	
	$tMateria="1";
	if($tipoMateria=="P")
	{
		$consulta="SELECT tipoMateria FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta[2]."'";
		$tMateria=$con->obtenerValor($consulta);
	}
	if(($tCarpeta!=6)||($tMateria==2))
	{
		$consulta="SELECT u.idUsuario,u.Nombre FROM 7007_contenidosCarpetaAdministrativa con,
					7000_eventosAudiencia e,7001_eventoAudienciaJuez ej,800_usuarios u WHERE con.carpetaAdministrativa='".$cJudicial."' AND
					con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND 
					ej.idRegistroEvento=e.idRegistroEvento AND e.situacion IN (1,2,4,5) and u.idUsuario=ej.idJuez";
		$arrJueces=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT ej.idJuez FROM 7007_contenidosCarpetaAdministrativa con,
					7000_eventosAudiencia e,7001_eventoAudienciaJuez ej WHERE con.carpetaAdministrativa='".$cJudicial."' AND
					con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND 
					ej.idRegistroEvento=e.idRegistroEvento AND e.situacion IN (1,2,4,5) AND e.fechaEvento<='".$fechaAudiencia."'
					ORDER BY fechaEvento DESC";
		$idJuez=$con->obtenerValor($consulta);
	
	}
	else
	{
		$oJuezTitular="['".$idJuezTitular."','".cv(obtenerNombreUsuario($idJuezTitular))."']";
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveUGJ."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		
		$juezBinomio=obtenerJuezBinomio($idUnidadGestion,$idJuezTitular);
		$oJuezBinomio="['".$juezBinomio."','".cv(obtenerNombreUsuario($juezBinomio))."']";
		
		$arrJueces="[".$oJuezTitular.",".$oJuezBinomio."]";
		
		$idJuez=obtenerJuezAtencionCarpetaUnica($cJudicial,$fechaAudiencia);
		if($idJuez==-1)
		{
			$consulta="SELECT u.idUsuario,u.Nombre FROM 7007_contenidosCarpetaAdministrativa con,
					7000_eventosAudiencia e,7001_eventoAudienciaJuez ej,800_usuarios u WHERE con.carpetaAdministrativa='".$cJudicial."' AND
					con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND 
						ej.idRegistroEvento=e.idRegistroEvento AND e.situacion IN (1,2,4,5) and u.idUsuario=ej.idJuez";
			$arrJueces=$con->obtenerFilasArreglo($consulta);
			
			$consulta="SELECT ej.idJuez FROM 7007_contenidosCarpetaAdministrativa con,
						7000_eventosAudiencia e,7001_eventoAudienciaJuez ej WHERE con.carpetaAdministrativa='".$cJudicial."' AND
						con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND 
						ej.idRegistroEvento=e.idRegistroEvento AND e.situacion IN (1,2,4,5) AND e.fechaEvento<='".$fechaAudiencia."'
						ORDER BY fechaEvento DESC";
			$idJuez=$con->obtenerValor($consulta);
		}
	}
	
	if($idJuez=="")
		$idJuez=-1;
	
	echo "1|".$arrJueces."|".$idJuez;
	
}

function validarDisponibilidadJuezAudiencia()
{
	global $con;
	$fecha=$_POST["fecha"];
	$idJuez=$_POST["idJuez"];
	$resultado=0;
	
	$esJuezDisponible=esJuezDisponibleIncidencia($idJuez,$fecha);
	if(!$esJuezDisponible)
		$resultado=2;
	else
	{
		$esJuezTramite=esJuezTramite($idJuez,$fecha);	
		if($esJuezTramite)
			$resultado=1;
	}
	echo "1|".$resultado;
}


function obtenerDocumentosFirmadoPromocionAmparo()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$idNotificacion=$_POST["idNotificacion"];
	$documentosAdjuntos="";
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT i.idRegistro,i.tituloDocumento FROM 3000_formatosRegistrados f,7035_informacionDocumentos i 
				WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idRegistro." AND
				 f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND situacionActual=50";
	
	$consulta="SELECT idDocumento,concat(a.nomArchivoOriginal,'_',f.idDocumento) FROM 3000_formatosRegistrados f,908_archivos a 
			WHERE situacionActual=50 and a.idArchivo=f.idDocumento order by nomArchivoOriginal";				 
				 
	$res=$con->obtenerFilas($consulta);		
	while($fila=$con->fetchRow($res))
	{
		$o='{"idDocumento":"'.$fila[0].'","nombreDocumento":"'.cv($fila[1]).'"}';
		$numReg++;
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	$consulta="SELECT * FROM 7041_notificacionesCJF WHERE idRegistro=".$idNotificacion;
	$fila=$con->obtenerPrimeraFila($consulta);
	$obj=json_decode('{"arrDocumentos":['.$fila[9].']}');
		
	foreach($obj->arrDocumentos as $d)
	{
		$doc='{"idDocumento":"'.$d->idDocumento.'"}';
		if($documentosAdjuntos=="")
			$documentosAdjuntos=$doc;
		else
			$documentosAdjuntos.=",".$doc;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"documentosAdjuntos":['.$documentosAdjuntos.']}';
	
}

function registrarNotificacionPromocionAmparo()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$documentosAsociados="";
	foreach($obj->arrDocumentos as $d)
	{
		$doc='{"idDocumento":"'.$d->idDocumento.'"}';
		if($documentosAsociados=="")
			$documentosAsociados=$doc;
		else
			$documentosAsociados.=",".$doc;
	}
	if($obj->idNotificacion=="-1")
	{
		foreach($obj->arrJuecesNotifica as $j)
		{
			$consulta[$x]="INSERT INTO 7041_notificacionesCJF(fechaCreacion,situacion,comentariosAdicionales,idFormulario,
							idReferencia,documentosAsociados,responsableCreacion,juezNotifica)
						 VALUES('".date("Y-m-d H:i:s")."',1,'".cv($obj->comentariosAdicionales)."',".$obj->idFormulario.",".$obj->idReferencia.
						 ",'".cv($documentosAsociados)."',".$_SESSION["idUsr"].",".$j->idJuez.")";
			$x++;
		}
	}
	else
	{
		$consulta[$x]="update 7041_notificacionesCJF set comentariosAdicionales='".cv($obj->comentariosAdicionales).
					"',documentosAsociados='".cv($documentosAsociados)."' where idRegistro=".$obj->idNotificacion;
		$x++;

	}
	
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
}

function obtenerNotificacionesPromocionAmparo()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idReferencia"];

	$lblDocumentosAdjuntos="";
	
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT * from 7041_notificacionesCJF where idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;

	$res=$con->obtenerFilas($consulta);		
	while($fila=$con->fetchRow($res))
	{
		$obj=json_decode('{"arrDocumentos":['.$fila[9].']}');
		$arrDocumentosAsociados="";
		
		foreach($obj->arrDocumentos as $d)
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$d->idDocumento;
			$tituloDocumento=$con->obtenerValor($consulta);
			$lblDocumentosAdjuntos.="<a href='javascript:mostrarDocumentoListado(\\\"".bE($tituloDocumento)."\\\",\\\"".bE($d->idDocumento)."\\\")'>".$tituloDocumento."</a><br>";
			$oDoc='{"idDocumento":"'.$d->idDocumento.'","nombreDocumento":"'.cv($tituloDocumento).'"}';
			
			if($arrDocumentosAsociados=="")
				$arrDocumentosAsociados=$oDoc;
			else
				$arrDocumentosAsociados.=",".$oDoc;
		}
		
		$consulta="SELECT id__26_tablaDinamica,j.clave,cTJ.tipoJuez FROM _26_tablaDinamica j,
				  _18_tablaDinamica cTJ,_26_tipoJuez tj WHERE tj.idPadre=id__26_tablaDinamica AND 
				  cTJ.id__18_tablaDinamica=tj.idOpcion and j.id__26_tablaDinamica=".$fila["13"].
				  " ORDER BY cTJ.tipoJuez,j.clave";
		$fJuez=$con->obtenerPrimeraFila($consulta);
		$etiquetaJuez="Juez ".cv($fJuez[1])." (".cv($fJuez[2]).")";
		$o='{"idNotificacion":"'.$fila[0].'","fechaCreacion":"'.$fila[1].'","fechaEnvioCJF":"'.($fila[2]==""?"":date("Y-m-d H:i:s",strtotime($fila[2]))).
			'","situacion":"'.$fila[3].'","comentariosAdicionales":"'.cv($fila[4]).'","lblDocumentosAdjuntos":"'.$lblDocumentosAdjuntos.
			'","responsableCreacion":"'.obtenerNombreUsuario($fila[5]).'","responsableEnvio":"'.($fila[6]==""?$fila[6]:obtenerNombreUsuario($fila[6])).
			'","folioRecepcion":"'.$fila[10].'","mensajeCJF":"'.cv($fila[12]).'","juezNotifica":"'.$fila["13"].
			'","etiquetaJuez":"'.cv($etiquetaJuez).'","arrDocumentosAsociados":['.$arrDocumentosAsociados.']}';
		$numReg++;
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function eliminarNotificacionesPromocionAmparo()
{
	global $con;
	$idNotificacion=$_POST["idNotificacion"];
	$consulta="DELETE FROM 7041_notificacionesCJF WHERE idRegistro=".$idNotificacion;
	eC($consulta);
}

function enviarNotificacionConsejo()
{
	global $con;
	$idNotificacon=$_POST["idNotificacion"];
	if(enviarNotificacionCJF($idNotificacon))
		echo "1|";
}

function obtenerRegistroEjecucionPP()
{
	global $con;
	$cA=$_POST["cA"];
	$iR=-1;
	$a="";
	$act="";
	$consulta="SELECT id__491_tablaDinamica,idEstado FROM _491_tablaDinamica WHERE carpetaAdministrativa='".$cA."' and idEstado in(1,2,4)";
	$fRegistro=$con->obtenerPrimeraFila($consulta);

	if(!$fRegistro)
	{
		$iR=-1;
		$a=bE("agregar");
		$act=bE(417);
	}
	else
	{
		$iR=$fRegistro[0];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(491);
		$actor=obtenerActorProcesoIdRol($idProceso,'69_0',$fRegistro[1]);
		$act=bE($actor);
	}
	
	$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
	$uG=$con->obtenerValor($consulta);
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
	$idUnidad=$con->obtenerValor($consulta);
	echo "1|".$iR."|".$a."|".$act."|".$idUnidad;
	
}


function obtenerListadoActasMinimas()
{
	global $con;
	$uG=$_POST["uG"];
	$anio=$_POST["anio"];
	$tC=$_POST["tC"];
	
	$fechaActual=date("Y-m-d");
	
	$cadCondWhere="1=1";
	if(isset($_POST["filter"]))
		$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	
	$arrRegistros="";
	$nReg=0;
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$uG."' 
				AND fechaCreacion>='".$anio."-01-01 00:00:01' AND fechaCreacion<='".$anio."-12-31 23:59:59' 
				AND tipoCarpetaAdministrativa=".$tC." and ".$cadCondWhere." ORDER BY carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT e.idRegistroEvento FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e 
					WHERE carpetaAdministrativa='".$fila[0]."' AND tipoContenido=3 AND 
					e.idRegistroEvento=c.idRegistroContenidoReferencia AND e.fechaEvento<='".$fechaActual."' AND situacion IN
					(1,2,4,5)";
		
		$lEventos=$con->obtenerListaValores($consulta);
		if($lEventos=="")
			$lEventos=-1;
		
		$nAudiencias=$con->filasAfectadas;
		
		$consulta="SELECT COUNT(*) FROM _472_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.")";
		$nActasMinimasRegistradas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _472_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.") and idEstado=6";
		$nActasFirmadas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _472_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.")";
		$nActasMinimasRegistradas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.")";
		$nTranscripcionesRegistradas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.") and idEstado=12";
		$nTranscripcionesFirmadas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.") and idEstado=14";
		$nAudienciasSinTranscripcion=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.") and idEstado=13";
		$nTranscripcionesSinResolucion=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEventoAudiencia IN(".$lEventos.") and idEstado in(6,7,10,11)";
		$nTranscripcionesJuez=$con->obtenerValor($consulta);
		
		$nTranscripcionesPendientesEntregaJuez=$nTranscripcionesRegistradas-$nTranscripcionesFirmadas-$nAudienciasSinTranscripcion-$nTranscripcionesSinResolucion-$nTranscripcionesJuez;
		$o='{"carpetaAdministrativa":"'.$fila[0].'","tAudiencias":"'.$nAudiencias.'","tActasRegistrada":"'.$nActasMinimasRegistradas.'",
			"tActasFirmadas":"'.$nActasFirmadas.'","tActasPorFirmar":"'.($nActasMinimasRegistradas-$nActasFirmadas).
			'","tActasSinRegistro":"'.($nAudiencias-$nActasMinimasRegistradas).'","tTranscripcionesRegistrada":"'.$nTranscripcionesRegistradas.'",
			"tTranscripcionesFirmadas":"'.$nTranscripcionesFirmadas.'","tTranscripcionesPendienteEntregaJuez":"'.$nTranscripcionesPendientesEntregaJuez.
			'","tTranscripcionesPendientePorJuez":"'.$nTranscripcionesJuez.'","tTranscripcionesSinRegistro":"'.($nAudiencias-$nTranscripcionesRegistradas).
			'","tAudienciasSinTranscripcion":"'.$nAudienciasSinTranscripcion.'","tTranscripcionesSinResolucion":"'.$nTranscripcionesSinResolucion.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$nReg++;
	}
	
	echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	
}


function obtenerInformeIndicador()
{
	global $con;
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idUnidadGestion=$_POST["idUnidadGestion"];
	$tipoDelito=$_POST["tipoDelito"];
	$arrUnidades=explode(",",$idUnidadGestion);
	$listaUnidades="";
	foreach($arrUnidades as $iUnidad)
	{
		if($listaUnidades=="")
			$listaUnidades="'".$iUnidad."'";
		else
			$listaUnidades.=",'".$iUnidad."'";
	}
	
	$consulta="";
	$arrRegistros="";
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia NOT IN (91,102,114) and c.carpetaAdministrativa=s.carpetaAdministrativa
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia NOT IN (91,102,114) and c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=s.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	
	$valor=$con->obtenerValor($consulta);	
	$arrRegistros='{"indicador":"Solicitudes recibidas","valor":"'.$valor.'","categoria":"1"}';
	
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);	
	$arrRegistros.=',{"indicador":"Audiencias programadas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
				
		
	}
	
	$valorCelebradas=$con->obtenerValor($consulta);
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				3013_registroResolutivosAudiencia r WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) 
				AND con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion IN(".$listaUnidades.") 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				and r.idEvento=e.idRegistroEvento and r.tipoResolutivo IN(76,62,68,77)";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				_61_tablaDinamica d, 3013_registroResolutivosAudiencia r
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 

				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento and r.idEvento=e.idRegistroEvento 
				and r.tipoResolutivo IN(76,62,68,77)";
				
		
	}
	
	$valorDiferidas=$con->obtenerValor($consulta);
	$valorCelebradas-=$valorDiferidas;
	
	$arrRegistros.=',{"indicador":"Audiencias celebradas","valor":"'.$valorCelebradas.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);	
	
	$arrRegistros.=',{"indicador":"Audiencias canceladas","valor":"'.$valor.'","categoria":"1"}';
	
	$arrRegistros.=',{"indicador":"Audiencias diferidas","valor":"'.$valorDiferidas.'","categoria":"1"}';
	
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__96_tablaDinamica) FROM _96_tablaDinamica s,7006_carpetasAdministrativas c
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 and c.carpetaAdministrativa=s.carpetaAdministrativa
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__96_tablaDinamica) FROM _96_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 and c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	
	$valor=$con->obtenerValor($consulta);	
	
	
	$arrRegistros.=',{"indicador":"Promociones recibidas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				 AND c.unidadGestion IN (".$listaUnidades.") and c.tipoCarpetaAdministrativa=1";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	$valor=$con->obtenerValor($consulta);	
	$arrRegistros.=',{"indicador":"Carpetas generadas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia  IN (91,102,114) and c.carpetaAdministrativa=s.carpetaRemitida
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia  IN (91,102,114) and c.carpetaAdministrativa=s.carpetaRemitida
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=s.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	$valor=$con->obtenerValor($consulta);	
	
	$arrRegistros.=',{"indicador":"Incompetencias realizadas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia  IN (91,102,114) and c.carpetaAdministrativa=s.carpetaAdministrativa
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__46_tablaDinamica) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' and s.idEstado>1.4 
				AND tipoAudiencia  IN (91,102,114) and c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=s.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Incompetencias recibidas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE fechaCreacion>='".$fechaInicio."' AND fechaCreacion<='".$fechaFin.
					" 23:59:59' AND unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa=2";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c,_92_tablaDinamica e WHERE c.fechaCreacion>='".$fechaInicio.
					"' AND c.fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa=2
					and c.carpetaAdministrativa=e.carpetaExhorto and e.delito in(".$tipoDelito.")";
					
		
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Exhortos recibidos","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM _370_tablaDinamica r,_92_tablaDinamica e,7006_carpetasAdministrativas c
				WHERE r.fechaAtencion>='".$fechaInicio."' AND fechaAtencion<='".$fechaFin."' AND r.idReferencia=e.id__92_tablaDinamica
				AND c.carpetaAdministrativa=e.carpetaExhorto AND c.unidadGestion IN(".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM _370_tablaDinamica r,_92_tablaDinamica e,7006_carpetasAdministrativas c
				WHERE r.fechaAtencion>='".$fechaInicio."' AND fechaAtencion<='".$fechaFin."' AND r.idReferencia=e.id__92_tablaDinamica
				AND c.carpetaAdministrativa=e.carpetaExhorto AND c.unidadGestion IN(".$listaUnidades.")  and e.delito in(".$tipoDelito.")";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Exhortos atendidos","valor":"'.$valor.'","categoria":"1"}';
	$arrRegistros.=',{"indicador":"Exhortos realizados","valor":"0","categoria":"1"}';
	
	$arrRegistros.=',{"indicador":"Notificaciones realizadas","valor":"0","categoria":"1"}';
	$arrRegistros.=',{"indicador":"Notificaciones no realizadas","valor":"0","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestion IN(".$listaUnidades.")
				AND tipoCarpetaAdministrativa=4";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d WHERE c.fechaCreacion>='".$fechaInicio.
				"' AND c.fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestion IN(".$listaUnidades.")
				AND tipoCarpetaAdministrativa=4 and d.idActividad=c.idActividad";
	}
	$valor=$con->obtenerValor($consulta);
	$arrRegistros.=',{"indicador":"Apelaciones recibidas","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestion IN(".$listaUnidades.")
				AND tipoCarpetaAdministrativa=3";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d WHERE c.fechaCreacion>='".$fechaInicio.
				"' AND c.fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestion IN(".$listaUnidades.")
				AND tipoCarpetaAdministrativa=3 and d.idActividad=c.idActividad";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Amparos recibidos","valor":"'.$valor.'","categoria":"1"}';
	if($tipoDelito=="0")
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa=1";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=5
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	else
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa=1 and d.idActividad=c.idActividad";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=5
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Carpetas remitidas para juicio oral","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa in(1,5)";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=6
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	else
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa in(1,5) and d.idActividad=c.idActividad";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=6
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Carpetas remitidas a ejecuci&oacute;n","valor":"'.$valor.'","categoria":"1"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				 AND c.unidadGestion IN (".$listaUnidades.") and c.tipoCarpetaAdministrativa=1 and situacion=1";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				and situacion=1";
	}
	$valor=$con->obtenerValor($consulta);	
	
	$arrRegistros.=',{"indicador":"Carpetas abiertas","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				 AND c.unidadGestion IN (".$listaUnidades.") and c.tipoCarpetaAdministrativa=1 and situacion not in(1,22)";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				and situacion not in(1,22)";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Carpetas cerradas","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				 AND c.unidadGestion IN (".$listaUnidades.") and c.tipoCarpetaAdministrativa=1 and situacion =22";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				and situacion =22";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Carpetas canceladas","valor":"'.$valor.'","categoria":"2"}';
	
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT r.idParticipante) FROM 7006_carpetasAdministrativas c,7005_relacionFigurasJuridicasSolicitud r 
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				 AND c.unidadGestion IN (".$listaUnidades.") and c.tipoCarpetaAdministrativa=1 and
				 r.idActividad=c.idActividad AND r.idFiguraJuridica=4";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT r.idParticipante) FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d, 7005_relacionFigurasJuridicasSolicitud r
				WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				and r.idActividad=c.idActividad AND r.idFiguraJuridica=4";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"N&uacute;mero de imputados","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				3013_registroResolutivosAudiencia r WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) 
				AND con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion IN(".$listaUnidades.") 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				and r.idEvento=e.idRegistroEvento and r.tipoResolutivo=50 and valor=1";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				_61_tablaDinamica d, 3013_registroResolutivosAudiencia r
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento and r.idEvento=e.idRegistroEvento 
				and r.tipoResolutivo=50 and valor=1";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Vinculados a proceso","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				3013_registroResolutivosAudiencia r WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) 
				AND con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion IN(".$listaUnidades.") 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				and r.idEvento=e.idRegistroEvento and r.tipoResolutivo=50 and valor=0";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				_61_tablaDinamica d, 3013_registroResolutivosAudiencia r
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento and r.idEvento=e.idRegistroEvento 
				and r.tipoResolutivo=50 and valor=0";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"No vinculados","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__434_tablaDinamica) FROM _434_tablaDinamica s,7006_carpetasAdministrativas c
				WHERE s.fechaOrden>='".$fechaInicio."' AND s.fechaOrden<='".$fechaFin."' and c.carpetaAdministrativa=s.carpetaAdministrativa
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__434_tablaDinamica) FROM _434_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d
				WHERE s.fechaOrden>='".$fechaInicio."' AND s.fechaOrden<='".$fechaFin."' and  c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	
	$valor=$con->obtenerValor($consulta);	
	
	
	$arrRegistros.=',{"indicador":"Ordenes de aprehensi&oacute;n emitidas","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(DISTINCT id__434_tablaDinamica) FROM _434_tablaDinamica s,7006_carpetasAdministrativas c,_447_tablaDinamica oc
				WHERE oc.idReferencia=s.id__434_tablaDinamica and oc.fechaCumplimiento>='".$fechaInicio."' AND oc.fechaCumplimiento<='".$fechaFin."' 
				and oc.statusOrden=1 and c.carpetaAdministrativa=s.carpetaAdministrativa
				 AND c.unidadGestion IN (".$listaUnidades.")";
	}
	else
	{
		$consulta="SELECT COUNT(DISTINCT id__434_tablaDinamica) FROM _434_tablaDinamica s,7006_carpetasAdministrativas c,_61_tablaDinamica d,
				_447_tablaDinamica oc WHERE oc.idReferencia=s.id__434_tablaDinamica and oc.fechaCumplimiento>='".$fechaInicio.
				"' AND oc.fechaCumplimiento<='".$fechaFin."' and  c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion IN (".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")";
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Ordenes de aprehensi&oacute;n cumplimentadas","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa in(1)";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=6
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	else
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas c,_61_tablaDinamica d WHERE 
				unidadGestion IN(".$listaUnidades.") AND tipoCarpetaAdministrativa in(1) and d.idActividad=c.idActividad";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND tipoCarpetaAdministrativa=6
				and carpetaAdministrativaBase in(".$listaCarpetas.")";
	}
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Procedimientos abreviados","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				3014_registroAcuerdosReparatorios r WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and  
				con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion IN(".$listaUnidades.") 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				and r.idEvento=e.idRegistroEvento";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				_61_tablaDinamica d, 3014_registroAcuerdosReparatorios r
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento and r.idEvento=e.idRegistroEvento";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Acuerdos reparatorios","valor":"'.$valor.'","categoria":"2"}';
	
	if($tipoDelito=="0")
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				3014_registroMedidasCautelares r WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) 
				AND con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion IN(".$listaUnidades.") 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				and r.idEventoAudiencia=e.idRegistroEvento and r.tipoMedida=14";
	}
	else
	{
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
				_61_tablaDinamica d, 3014_registroMedidasCautelares r
				WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.situacion not in(3,6) AND con.carpetaAdministrativa=c.carpetaAdministrativa 
				AND c.unidadGestion IN(".$listaUnidades.") AND d.idActividad=c.idActividad AND d.denominacionDelito IN(".$tipoDelito.")
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento  
				and r.idEventoAudiencia=e.idRegistroEvento and r.tipoMedida=14";
				
		
	}
	
	$valor=$con->obtenerValor($consulta);
	
	$arrRegistros.=',{"indicador":"Imputados con prisi&oacute;n preventiva oficiosa","valor":"'.$valor.'","categoria":"2"}';
	
	//$arrRegistros.=',{"indicador":"Imputados sin prisi&oacute;n preventiva oficiosa","valor":"0","categoria":"2"}';
	
	echo '{"numReg":"","registros":['.$arrRegistros.']}';
	
}


function registrarEventoControl()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	
	
	
	$horaInicio=$obj->fecha." ".$obj->horaInicio;
	$horaFin=$obj->fecha." ".$obj->horaFin;
	if(!existeDisponibilidadSala($obj->idEvento,$obj->sala,$obj->fecha,$horaInicio,$horaFin))
	{
		echo "0|<br>La sala seleccionada ya no se encuentra disponible<br>";
		return;
	}

	$x=0;
	$query[$x]="begin";
	$x++;	
	$idJuezAnterior="";
	if($obj->idEvento!="-1")
	{
		$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$obj->idEvento;
		$idJuezAnterior=$con->obtenerValor($consulta);
			
		$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento,idCentroGestion,idSala,idEdificio,tipoAudiencia,tipoTribunal
					  FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$obj->idEvento;
		$fEvento=$con->obtenerPrimeraFila($consulta);
		if($fEvento[0]!="")
		{
			$query[$x]="INSERT INTO 3006_bitacoraCambiosSalaFecha(idEventoAudiencia,fechaOperacion,idResponsableOperacion,fechaOriginal,horaInicioOriginal,horaTerminoOriginal,
					idSalaOriginal,fechaCambio,horaInicioCambio,horaTerminoCambio,idSalaCambio,idMotivoCambio,comentariosAdicionales,asignacionJuez)
					VALUES('".$obj->idEvento."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$fEvento[0]."','".$fEvento[1].
					"','".$fEvento[2]."',".($fEvento["4"]==""?-1:$fEvento["4"]).
					",'".$obj->fecha."','".$horaInicio."','".$horaFin."','".$obj->sala."','0','',NULL)";
			$x++;
		}
		$query[$x]="update 7000_eventosAudiencia set 
				fechaEvento='".$obj->fecha."',horaInicioEvento='".$horaInicio."',
				horaFinEvento='".$horaFin."',fechaAsignacion='".date("Y-m-d H:i:s").
				"',idEdificio=".$obj->edificio.",idSala=".$obj->sala.",fechaLimiteAtencion=NULL,
				fechaSolicitud='".date("Y-m-d H:i:s")."',tipoAudiencia=".$obj->tipoAudiencia.
				",situacion=1 where idRegistroEvento=".$obj->idEvento;
		$x++;
		$query[$x]="set @idRegistro:=".$obj->idEvento;
		$x++;
		
	}
	else
	{
		$etapa=obtenerEtapaProcesalCarpetaAdministrativa($obj->carpetaAdministrativa);
		$query[$x]="insert into 7000_eventosAudiencia(fechaEvento,horaInicioEvento,horaFinEvento,situacion,fechaAsignacion,idEdificio,idCentroGestion,
					idSala,idFormulario,idRegistroSolicitud,idReferencia,idEtapaProcesal,tipoAudiencia,fechaLimiteAtencion,fechaSolicitud,tipoTribunal)
					values('".$obj->fecha."','".$horaInicio."','".$horaFin."',1,'".date("Y-m-d H:i:s").
					"',".$obj->edificio.",".$obj->unidadGestion.",".$obj->sala.",".$obj->idFormulario.",".$obj->idRegistroSolicitud.",-1,".$etapa.",".
					$obj->tipoAudiencia.",NULL,'".date("Y-m-d H:i:s")."',1)";
		$x++;	
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;	
	}
	
	$query[$x]="DELETE FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=@idRegistro";
	$x++;	
	$noRondaMaxima=0;
	$serieRondaMaxima=0;	


	$lJuecesAsignados="";
	foreach($obj->jueces as $j)
	{
		if(!existeDisponibilidadJuez($j->idUsuario,$obj->fecha,$horaInicio,$horaFin,$obj->idEvento,"",true))
		{
			echo '0|<br>Ya no existe disponibilidad del Juez: '.obtenerNombreUsuario($j->idUsuario).'<br>';
			return;
		}
		
		if($lJuecesAsignados=="")
			$lJuecesAsignados=$j->idUsuario;
		else
			$lJuecesAsignados.=",".$j->idUsuario;
		
		$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$j->idUsuario;
		$noJuez=$con->obtenerValor($consulta);
		$query[$x]="INSERT INTO 7001_eventoAudienciaJuez(idRegistroEvento,idJuez,tipoJuez,titulo,noJuez,ministerioLey,serieRonda,noRonda,idUGARonda) 
		VALUES(@idRegistro,".$j->idUsuario.",".$j->tipoJuez.",'".cv($j->participacion)."','".$noJuez."',".
		$j->ministerioLey.",'".$j->serieRonda."',".($j->noRonda==""?"NULL":$j->noRonda).",".$obj->unidadGestion.")";
		$x++;	
		
		if($noRondaMaxima<$j->noRonda)
		{
			$noRondaMaxima=$j->noRonda;
		}	
		$serieRondaMaxima=$j->serieRonda;
		 
	}
	
	if(isset($obj->recursosAdicionales ))
	{
		foreach($obj->recursosAdicionales as $r)
		{
			if(!existeDisponibilidadRecurso($obj->idEvento,$obj->fecha,$r->tipoRecurso,$r->idRecurso,$r->horaInicio,$r->horaTermino,$r->idRegistroRecurso))
			{
				$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$r->tipoRecurso;
				$tipoRecurso=$con->obtenerValor($consulta);
				$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$r->idRecurso;
				$nombreRecurso=$con->obtenerValor($consulta);
				echo '0|<br>NO existe disponibilidad del Recurso: <br><br>('.$tipoRecurso.') '.$nombreRecurso.'<br>';
				return;
			}
			if($r->idRegistroRecurso==-1)
			{
				$query[$x]="INSERT INTO 7001_recursosAdicionalesAudiencia(idRegistroEvento,tipoRecurso,idRecurso,horaInicio,horaFin,situacionRecurso,comentariosAdicionales)
							 VALUES(@idRegistro,".$r->tipoRecurso.",".$r->idRecurso.",'".$r->horaInicio."','".$r->horaTermino."',1,'".cv($r->comentariosAdicionales)."')";
				$x++;	
				$query[$x]="set @idRecursoRegistro:=(select last_insert_id())";
				$x++;
				$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,situacionAnterior)
							VALUES(@idRecursoRegistro,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'',0)";
				$x++;
			}
			else
			{
				$existeCambio=false;
				$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistro=".$r->idRegistroRecurso;
				$fRecurso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fRecurso["idRecurso"]!=$r->idRecurso)
				{
					$existeCambio=true;
				}
				
				if(($fRecurso["horaInicio"]!=$r->horaInicio)||($fRecurso["horaFin"]!=$r->horaTermino))
				{
					$existeCambio=true;
				}
				
				if($fRecurso["comentariosAdicionales"]!=$r->comentariosAdicionales)
				{
					$existeCambio=true;
				}
				
				if($existeCambio)
				{
					$query[$x]="update 7001_recursosAdicionalesAudiencia set idRecurso=".$r->idRecurso.",horaInicio='".$r->horaInicio."',horaFin='".$r->horaTermino.
							"',comentariosAdicionales='".cv($r->comentariosAdicionales)."' where idRegistro=".$r->idRegistroRecurso;
					$x++;
					$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,
								situacionAnterior,idRecursoAnterior,horaInicioAnterior,horaFinAnterior,comentariosAdicionalesAnterior)
								VALUES(".$r->idRegistroRecurso.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'',".$fRecurso["situacionRecurso"].
								",".$fRecurso["idRecurso"].",'".$fRecurso["horaInicio"]."','".$fRecurso["horaFin"]."','".cv($fRecurso["comentariosAdicionales"])."')";
					$x++;	
				}
			}
			 
		}
	}
	
	if(isset($obj->recursosRemovidos))
	{
		foreach($obj->recursosRemovidos as $r)
		{
			
			
			$query[$x]="update 7001_recursosAdicionalesAudiencia set situacionRecurso=3 where idRegistro=".$r->idRegistro;
			$x++;	
			$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,situacionAnterior)
						VALUES(".$r->idRegistro.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($r->motivo)."',1)";
			$x++;
			
			 
		}
	}
	if(strpos($serieRondaMaxima,"_D")===false)
	{
		if($serieRondaMaxima!="G")
		{
			$consulta="SELECT noRonda FROM 7004_seriesRondaAsignacion WHERE idUGARonda=".$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'";
			$nRondaActual=$con->obtenerValor($consulta);
			
			if($nRondaActual<$noRondaMaxima)
			{
				$query[$x]="UPDATE 7004_seriesRondaAsignacion SET noRonda='".$noRondaMaxima."' WHERE idUGARonda=".
							$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'";
				$x++;
			}
		}
		else
		{
			$idPeriodoGuardia=obtenerIdPeriodoGuardia($obj->unidadGestion);	
			$consulta="SELECT noRonda FROM 7004_seriesRondaAsignacionGuardia WHERE idUGARonda=".$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."'
						and idPeriodoGuardia=".$idPeriodoGuardia;
						
			$nRondaActual=$con->obtenerValor($consulta);
			
			if($nRondaActual<$noRondaMaxima)
			{
				$query[$x]="UPDATE 7004_seriesRondaAsignacionGuardia SET noRonda='".$noRondaMaxima."' WHERE idUGARonda=".
							$obj->unidadGestion." AND serieRonda='".$serieRondaMaxima."' and idPeriodoGuardia=".$idPeriodoGuardia;
				$x++;
			}
		}
	}
	$query[$x]="commit";
	$x++;

	if($con->ejecutarBloque($query))
	{
		
		$consulta="select @idRegistro";
		$idEventoAgenda=$con->obtenerValor($consulta);
		foreach($obj->jueces as $j)
		{		
			
			if($idJuezAnterior!=$j->idUsuario)
			{
				if($idJuezAnterior!="")
				{
					$consulta="UPDATE 7001_asignacionesJuezAudiencia SET situacion=6 WHERE idJuez=".$idJuezAnterior.
								" AND idEventoAudiencia= ".$idEventoAgenda;
					$con->ejecutarConsulta($consulta);
				}
				
				if($j->pagoAdeudo==1)
				{
					$consulta="SELECT idAsignacion FROM 7001_asignacionesJuezAudiencia 
								WHERE idJuez=".$j->idUsuario." AND tipoRonda='".$j->serieRonda."' 
								AND situacion=4 AND idUnidadGestion=".$obj->unidadGestion;
					$idAsignacion=$con->obtenerValor($consulta);
					if($idAsignacion!="")
					{
						$consulta="UPDATE 7001_asignacionesJuezAudiencia SET idEventoAudienciaPago=idEventoAudiencia , idEventoAudiencia=".$idEventoAgenda.
								",situacion=1, rondaPagada='".$j->noRonda."' WHERE idAsignacion=".$idAsignacion;
						
						$con->ejecutarConsulta($consulta);
					}
				}
				else
				{
					$arrParametros["idFormulario"]=$obj->idFormulario;
					$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
					$arrParametros["fechaEvento"]=$obj->fecha;
					$arrParametros["idJuez"]=$j->idUsuario;
					$arrParametros["tipoRonda"]=str_replace("'","",$j->serieRonda);
					$arrParametros["noRonda"]=$j->noRonda;
					$arrParametros["situacion"]=1;
					$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
					$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
					registrarAsignacionJuez($arrParametros);
				}
			}
				
			foreach($j->arrJuecesBloquear as $jBloqueo)
			{
				$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia WHERE idJuez=".$jBloqueo->idJuez.
						" AND tipoRonda='".$jBloqueo->serieRonda."' AND noRonda='".$jBloqueo->noRonda.
						"' AND idUnidadGestion=".$obj->unidadGestion;
				$nRegistros=$con->obtenerValor($consulta);
				if($nRegistros==0)
				{
					$arrParametros["idFormulario"]=$obj->idFormulario;
					$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
					$arrParametros["fechaEvento"]=$obj->fecha;
					$arrParametros["idJuez"]=$jBloqueo->idJuez;
					$arrParametros["tipoRonda"]=$jBloqueo->serieRonda;
					$arrParametros["noRonda"]=$jBloqueo->noRonda;
					$arrParametros["situacion"]=$jBloqueo->tipoBloqueo;
					$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
					$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
					$arrParametros["comentariosAdicionales"]=isset($jBloqueo->comentariosAdicionales)?$jBloqueo->comentariosAdicionales:"";
					registrarAsignacionJuez($arrParametros);
				}
			}
		}
			
		if($obj->arrJuezOriginal!="")
		{
			$oJuezOriginal=json_decode(bD($obj->arrJuezOriginal));
			
			
			$consulta="SELECT idAsignacion FROM 7001_asignacionesJuezAudiencia 
								WHERE idJuez=".$oJuezOriginal->idJuez." AND idEventoAudiencia=".$idEventoAgenda;
					
			$idAsignacion=$con->obtenerValor($consulta);
			if($idAsignacion=="")
			{
				
				$arrParametros["idFormulario"]=$obj->idFormulario;
				$arrParametros["idRegistro"]=$obj->idRegistroSolicitud;
				$arrParametros["fechaEvento"]=$obj->fecha;
				$arrParametros["idJuez"]=$oJuezOriginal->idJuez;
				$arrParametros["tipoRonda"]=$oJuezOriginal->serieRonda;
				$arrParametros["noRonda"]=$oJuezOriginal->noRonda;
				$arrParametros["situacion"]=6;
				$arrParametros["idUnidadGestion"]=$obj->unidadGestion;
				$arrParametros["idEventoAudiencia"]=$idEventoAgenda;
				$arrParametros["comentariosAdicionales"]=urldecode($oJuezOriginal->comentariosAdicionales);
				registrarAsignacionJuez($arrParametros);
			}
			else
			{
				
				$consulta="UPDATE 7001_asignacionesJuezAudiencia SET situacion=6 WHERE idAsignacion=".$idAsignacion;
				$con->ejecutarConsulta($consulta);
			}
			foreach($obj->jueces as $j)
			{
				$consulta="INSERT INTO 3005_bitacoraCambiosJuez(idEventoAudiencia,fechaOperacion,idResponsableOperacion,
						idJuezOriginal,idJuezCambio,comentariosAdicionales,idRegistroJuez)
					VALUES(".$idEventoAgenda.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$oJuezOriginal->idJuez.",".$j->idUsuario.",'".
					cv(urldecode($oJuezOriginal->comentariosAdicionales))."',".($idAsignacion==""?-1:$idAsignacion).")";
				$con->ejecutarConsulta($consulta);
			}

		}
		
		
		

		registrarAudienciaCarpetaAdministrativa($obj->idFormulario,$obj->idRegistroSolicitud,$idEventoAgenda);
		$consulta="SELECT idEstado FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistroSolicitud;
		$idEstado=$con->obtenerValor($consulta);
		switch($obj->idFormulario)
		{
			case 46:
				//if($idEstado==3)
				{
					desHabilitaraTareaAsignacionEventoJuez(46,$obj->idRegistroSolicitud,$lJuecesAsignados);
					cambiarEtapaFormulario(46,$obj->idRegistroSolicitud,5,"",-1,"NULL","NULL",276);
				}
			break;
			case 185:
				//if(($idEstado==1)||($idEstado==1.1))
				{

					desHabilitaraTareaAsignacionEventoJuez(185,$obj->idRegistroSolicitud,$lJuecesAsignados);
					cambiarEtapaFormulario(185,$obj->idRegistroSolicitud,5,"",-1,"NULL","NULL",648);
				}
				
			break;
		}

		
		if($obj->esLatisMeeting==1)
			@registrarReunionVirtualLatisMeeting($idEventoAgenda,$obj->audienciaVirtualLatisMeeting);

		@enviarNotificacionMAJO($idEventoAgenda);
		//@registrarAudienciaToca(-1,-1,$idEventoAgenda,$obj->toca,$obj->tribunal);
		echo "1|".$idEventoAgenda;
		
	}
	else
		echo "0|";
	
	
}

function obtenerJuezAsignacion()
{
	global $con;
	global $arrAudienciasIntermedias;
	$limitePagoRonda=1;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$fechaAudiencia=$obj->fechaAudiencia;
	$horaInicioGuardia="13:30";
	$maximoHoras=12;	
	$consulta="SELECT  horaMinimasAudiencia,agendaDiaNoHabil,horasMaximaAgendaAudiencia,tipoAtencion,promedioDuracion FROM 
					_4_tablaDinamica WHERE id__4_tablaDinamica=".$obj->tipoAudiencia;
	$fDatosTipoAudiencia=$con->obtenerPrimeraFila($consulta);
	
	$consulta="SELECT tipoJuez,titulo FROM _4_gridJuecesRequeridos WHERE idReferencia=".$obj->tipoAudiencia;
	$fJuez=$con->obtenerPrimeraFila($consulta);
	$tipoJuez=$fJuez[0];
	$esSolicitudUgente=$fDatosTipoAudiencia[3]==2; 
	$considerarDiaHabil=$fDatosTipoAudiencia[1]==0;	
	
	$oDatosParametros["fechaBaseSolicitud"]=date("Y-m-d H:i:s");
	$oDatosParametros["tipoRonda"]=$esSolicitudUgente?"AU":"AN";
	$oDatosParametros["idFormulario"]=$obj->idFormulario;
	$oDatosParametros["idRegistro"]=$obj->idRegistroSolicitud;
	$oDatosParametros["idJuezSugerido"]=-1;
	$oDatosParametros["idUnidadGestion"]=$obj->idUnidadGestion;
	$oDatosParametros["validaJuezTramite"]=1;
	$oDatosParametros["validaIncidenciaJuez"]=1;
	$oAsignacion["tipoRonda"]=$oDatosParametros["tipoRonda"];
	$oAsignacion["noRonda"]="";
	$oAsignacion["idJuez"]="";
	$arrJuecesExcusa=array();
	
	if($obj->arrJuecesExcusa!="")
	{
		$aJuecesExcusa=json_decode(bD($obj->arrJuecesExcusa));
		foreach($aJuecesExcusa as $eJ)
		{
			$arrJuecesExcusa[$eJ->idJuez]=$eJ->motivoExcusa;
		}
	}
	
	$tipoCarpeta=0;
	$carpetaAdministrativa="";
	
	if($obj->idFormulario==185)
	{
		$consulta="SELECT * FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$obj->idRegistroSolicitud;
		$fDatosSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fDatosSolicitud["carpetaAdministrativa"];
		//$oDatosParametros["idJuezSugerido"]=(($fDatosSolicitud["juezAsignar"]!=0)&&($fDatosSolicitud["juezAsignar"]!="")&&($fDatosSolicitud["juezAsignar"]!=1))?$fDatosSolicitud["juezAsignar"]:-1;
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fDatosSolicitud["carpetaAdministrativa"]."'";
		$tipoCarpeta=$con->obtenerValor($consulta);
		if(isset($arrAudienciasIntermedias[$obj->tipoAudiencia]))
		{
			$oAsignacion["tipoRonda"]="I";
		}
		else
		{
			
			if($fDatosSolicitud["idEventoReferencia"]!="")
			{
				$fDatosSolicitudAuxiliar=$fDatosSolicitud;
				$encontrado=false;
				while(!$encontrado)
				{
					
					$consulta="SELECT tipoAudiencia,idRegistroEvento,idFormulario,idRegistroSolicitud FROM 
								7000_eventosAudiencia WHERE idRegistroEvento=".$fDatosSolicitudAuxiliar["idEventoReferencia"];
					$fDatosEventoBusqueda=$con->obtenerPrimeraFila($consulta);
					$tAudiencia=$fDatosEventoBusqueda[0];
					if(isset($arrAudienciasIntermedias[$tAudiencia]))
					{
						$oAsignacion["tipoRonda"]="IC";
						$encontrado=true;
					}
					else
					{
						if((($tAudiencia==25)||($tAudiencia==203))&&($fDatosEventoBusqueda[2]==185))
						{
							$consulta="SELECT * FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fDatosEventoBusqueda[3];
							$fDatosSolicitudAuxiliar=$con->obtenerPrimeraFilaAsoc($consulta);
							if($fDatosSolicitud["idEventoReferencia"]=="")
							{
								$encontrado=true;
							}
						}
						else
						{
							$encontrado=true;
						}
					}
				}
			}
		}
		
		
		
	
	}
	
	
		
	$arrJueces=array();
	$esAudienciaInicial=false;
	$fechaAudienciaVacacion=$fechaAudiencia;	
	
	$tipoHorario=determinarTipoHorarioGeneral($oDatosParametros["fechaBaseSolicitud"]);
	if($tipoCarpeta==6)
	{

		$oDatosParametros["idJuezSugerido"]=obtenerJuezAtencionCarpetaUnica($carpetaAdministrativa,$obj->fechaAudiencia);
		if($oDatosParametros["idJuezSugerido"]!=-1)
			$tipoHorario=1;
	}
	$juecesGuardia=$tipoHorario==2;
	
	if($juecesGuardia)
	{

		$fechaBaseDate=date("Y-m-d");
		$consulta="SELECT COUNT(*) FROM _290_tablaDinamica WHERE unidadGestion=".$obj->idUnidadGestion." and '".$fechaBaseDate.
				"'>=fechaInicial AND '".$fechaBaseDate."'<=fechaFinal";

		$nRegGuardia=$con->obtenerValor($consulta);	
		if($nRegGuardia==0)
		{
			$juecesGuardia=false;
		}
		else
		{
	
			$consulta="SELECT COUNT(*) FROM _290_tablaDinamica WHERE unidadGestion=".$obj->idUnidadGestion." and '".$obj->fechaAudiencia.
					"'>=fechaInicial AND '".$obj->fechaAudiencia."'<=fechaFinal";
	
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$fechaLimiteAudiencia=date("Y-m-d",strtotime("-1 days",strtotime($obj->fechaAudiencia)));
				$consulta="SELECT COUNT(*) FROM _290_tablaDinamica WHERE unidadGestion=".$obj->idUnidadGestion." and '".$fechaLimiteAudiencia.
						"'>=fechaInicial AND '".$fechaLimiteAudiencia."'<=fechaFinal";
	
				$nReg=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$juecesGuardia=false;
				}
			}
			
		}
		
	}

	$seleccionAleatoria=true;
	$situacionCarpeta=0;
	$cAdministrativaBase=obtenerCarpetaAdministrativaProceso($oDatosParametros["idFormulario"],$oDatosParametros["idRegistro"]);

	if($cAdministrativaBase!="")
	{
		$consulta="SELECT etapaProcesalActual FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativaBase."'"	;
		$situacionCarpeta=$con->obtenerValor($consulta);	
	}
	
	if(($oDatosParametros["idJuezSugerido"]!="")&&($oDatosParametros["idJuezSugerido"]!="-1"))
	{
		$oAsignacion["noRonda"]=0;
		$oAsignacion["tipoRonda"].="_D";
		$oAsignacion["idJuez"]= $oDatosParametros["idJuezSugerido"];
		
		echo '1|{"tipoJuez":"'.$tipoJuez.'","participacion":"'.cv($fJuez[1]).'","serieRonda":"'.$oAsignacion["tipoRonda"].
			'","noRonda":"'.$oAsignacion["noRonda"].'","pagoAdeudo":"0","idJuez":"'.$oAsignacion["idJuez"].
			'","nombreJuez":"'.cv(obtenerNombreUsuario($oAsignacion["idJuez"])).'","arrJuecesBloquear":""}';
		return;
		
	}
	else
	{
		$consulta="SELECT usuarioJuez FROM _26_tablaDinamica j,_26_tipoJuez tj WHERE j.idReferencia=".$oDatosParametros["idUnidadGestion"]."
						and tj.idPadre=j.id__26_tablaDinamica and tj.idOpcion=".$tipoJuez." order by j.clave";
		
		$listaJuecesUnidadGestion=$con->obtenerListaValores($consulta);
		if($listaJuecesUnidadGestion=="")
			$listaJuecesUnidadGestion="-1";

		if($listaJuecesUnidadGestion=="-1")
		{
			
			$oAsignacion["tipoRonda"].="_D";
			echo '1|{"tipoJuez":"'.$tipoJuez.'","participacion":"'.cv($fJuez[1]).'","serieRonda":"'.$oAsignacion["tipoRonda"].'",
			"noRonda":"0","pagoAdeudo":"0","idJuez":"-1","nombreJuez":"","arrJuecesBloquear":""}';
			return;
		}
				
		
		if($juecesGuardia)
		{
				
			$oAsignacion["tipoRonda"]="G";
			$ciclos=0;
			$arrJuecesBloquear="";
			
			$idPeriodoGuardia=obtenerIdPeriodoGuardia($oDatosParametros["idUnidadGestion"]);	
			
			$nRonda=obtenerNoRondaAsignacionGuardia($oDatosParametros["idUnidadGestion"],$oAsignacion["tipoRonda"],$idPeriodoGuardia);
			while($ciclos<20)
			{
				$consulta="SELECT j.usuarioJuez FROM _13_tablaDinamica t,_26_tablaDinamica j WHERE '".$oDatosParametros["fechaBaseSolicitud"]."'>=fechaInicio AND '".
							$oDatosParametros["fechaBaseSolicitud"]."'<=fechaFinalizacion and j.usuarioJuez in(".$listaJuecesUnidadGestion.
							") and t.idEstado=1 and j.usuarioJuez=t.usuarioJuez and j.idReferencia=".$oDatosParametros["idUnidadGestion"].
							" order by j.clave";

				$listaJuecesGuardia=$con->obtenerListaValores($consulta);
		
				
				$oDatosParametros["validaIncidenciaJuez"]=false;
				$oDatosParametros["validaJuezTramite"]=false;
				if($obj->idFormulario==185)
				{
					//$oDatosParametros["validaJuezTramite"]=true;
						//			$oDatosParametros["validaIncidenciaJuez"]=true;

				}
				if($listaJuecesGuardia!="")
					$listaJuecesUnidadGestion=$listaJuecesGuardia;
				else
					$oDatosParametros["validaIncidenciaJuez"]=true;
					
					
				$aJueces=explode(",",$listaJuecesUnidadGestion);

				foreach($aJueces as $idJuez)
				{
					if(($idJuez=="")||($idJuez==-1))
						continue;
					$asignacionesRonda= obtenerAsignacionesRonda($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);
					/*$nAdeudos=obtenerAsignacionesPendientes($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);
					$nPagadas=obtenerAsignacionesPagadasRonda($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);*/
					$arrJueces[$idJuez]["nAsignaciones"]=$asignacionesRonda;
					$arrJueces[$idJuez]["nAdeudos"]=0;
					$arrJueces[$idJuez]["nPagadas"]=0;
					if($oDatosParametros["validaJuezTramite"])	
						$arrJueces[$idJuez]["esJuezTramite"]=esJuezTramite($idJuez,$fechaAudiencia)?1:0;
					else
						$arrJueces[$idJuez]["esJuezTramite"]=0;
					if($oDatosParametros["validaIncidenciaJuez"])	
						$arrJueces[$idJuez]["esJuezIncidencia"]=esJuezDisponibleIncidencia($idJuez,$fechaAudiencia)?0:1;
					else
						$arrJueces[$idJuez]["esJuezIncidencia"]=0;
						
					
					$arrJueces[$idJuez]["horasDia"]=0;
					
					
					$arrJueces[$idJuez]["esJuezExcusa"]=isset($arrJuecesExcusa[$idJuez])?1:0;
					
				}
				
				//varDUmp($arrJueces);
				
				foreach($arrJueces as $idJuez=>$resto)
				{
					if(($resto["nAsignaciones"]==0)&&($resto["esJuezExcusa"]==0)&&($resto["esJuezIncidencia"]==0))
					{
						$consulta="SELECT clave FROM _26_tablaDinamica WHERE idReferencia=".$oDatosParametros["idUnidadGestion"]." AND usuarioJuez=".$idJuez;
						$clave=$con->obtenerValor($consulta);
						echo '1|{"tipoJuez":"'.$tipoJuez.'","participacion":"'.cv($fJuez[1]).'","serieRonda":"'.$oAsignacion["tipoRonda"].
						'","noRonda":"'.$nRonda.'","pagoAdeudo":"0","idJuez":"'.$idJuez.
						'","nombreJuez":"'.cv("[".$clave."] ".obtenerNombreUsuario($idJuez)).'","arrJuecesBloquear":"'.bE($arrJuecesBloquear).'"}';
						return;
					}
					else
					{
						if($resto["esJuezIncidencia"]==1)
						{
							$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"3","serieRonda":"'.$oAsignacion["tipoRonda"].
									'","noRonda":"'.$nRonda.'"}';
						}
						else
							if($resto["nAsignaciones"]==0)
							{
								$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"5","serieRonda":"'.$oAsignacion["tipoRonda"].
											'","noRonda":"'.$nRonda.'","comentariosAdicionales":"'.cv($arrJuecesExcusa[$idJuez]).'"}';
								if($arrJuecesBloquear=="")
									$arrJuecesBloquear=$oBloqueo;
								else
									$arrJuecesBloquear.=",".$oBloqueo;
							}
					}
					
				}
				$nRonda++;
				$ciclos++;
				
				
			}
			
		}
		else
		{
			
			$ciclos=0;
			$arrJuecesBloquear="";
			$nRonda=obtenerNoRondaAsignacion($oDatosParametros["idUnidadGestion"],$oAsignacion["tipoRonda"]);
			while($ciclos<20)
			{
				
				$aJueces=explode(",",$listaJuecesUnidadGestion);

				foreach($aJueces as $idJuez)
				{
					if(($idJuez=="")||($idJuez==-1))
						continue;
					$asignacionesRonda= obtenerAsignacionesRonda($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);
					$nAdeudos=obtenerAsignacionesPendientes($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);
					$nPagadas=obtenerAsignacionesPagadasRonda($idJuez,$oAsignacion["tipoRonda"],$oDatosParametros["idUnidadGestion"],$nRonda);
					$arrJueces[$idJuez]["nAsignaciones"]=$asignacionesRonda;
					$arrJueces[$idJuez]["nAdeudos"]=$nAdeudos;
					$arrJueces[$idJuez]["nPagadas"]=$nPagadas;
					if($oDatosParametros["validaJuezTramite"])	
						$arrJueces[$idJuez]["esJuezTramite"]=esJuezTramite($idJuez,$fechaAudiencia)?1:0;
					else
						$arrJueces[$idJuez]["esJuezTramite"]=0;
					if($oDatosParametros["validaIncidenciaJuez"])	
						$arrJueces[$idJuez]["esJuezIncidencia"]=esJuezDisponibleIncidencia($idJuez,$fechaAudiencia)?0:1;
					else
						$arrJueces[$idJuez]["esJuezIncidencia"]=0;
						
					
					$arrJueces[$idJuez]["horasDia"]=obtenerHorasAudienciaJuez($fechaAudiencia,$idJuez,true);
					$arrJueces[$idJuez]["esJuezExcusa"]=isset($arrJuecesExcusa[$idJuez])?1:0;
				}
				
				foreach($arrJueces as $idJuez=>$resto)
				{
					if(
						($resto["nAdeudos"]>0)&&($resto["nPagadas"]<$limitePagoRonda)
						&&(($resto["esJuezTramite"]+$resto["esJuezIncidencia"])==0)
						&&($resto["horasDia"]<$maximoHoras)
						)
					{
						$consulta="SELECT clave FROM _26_tablaDinamica WHERE idReferencia=".$oDatosParametros["idUnidadGestion"]." AND usuarioJuez=".$idJuez;
						$clave=$con->obtenerValor($consulta);
						
						echo '1|{"tipoJuez":"'.$tipoJuez.'","participacion":"'.cv($fJuez[1]).'","serieRonda":"'.$oAsignacion["tipoRonda"].
								'","noRonda":"'.$nRonda.'","pagoAdeudo":"1","idJuez":"'.$idJuez.
								'","nombreJuez":"'.cv("[".$clave."] ".obtenerNombreUsuario($idJuez)).'","arrJuecesBloquear":"'.bE($arrJuecesBloquear).'"}';
						return;
					}
				}
			
				
				foreach($arrJueces as $idJuez=>$resto)
				{
					if($resto["nAsignaciones"]==0)
					{
						if(($resto["esJuezTramite"]+$resto["esJuezIncidencia"]+$resto["esJuezExcusa"])==0)
						{
							if($resto["horasDia"]<$maximoHoras)
							{
								$consulta="SELECT clave FROM _26_tablaDinamica WHERE idReferencia=".$oDatosParametros["idUnidadGestion"]." AND usuarioJuez=".$idJuez;
								$clave=$con->obtenerValor($consulta);
								echo '1|{"tipoJuez":"'.$tipoJuez.'","participacion":"'.cv($fJuez[1]).'","serieRonda":"'.$oAsignacion["tipoRonda"].
								'","noRonda":"'.$nRonda.'","pagoAdeudo":"0","idJuez":"'.$idJuez.
								'","nombreJuez":"'.cv("[".$clave."] ".obtenerNombreUsuario($idJuez)).'","arrJuecesBloquear":"'.bE($arrJuecesBloquear).'"}';
								return;
							}
							else
							{
								$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"4","serieRonda":"'.$oAsignacion["tipoRonda"].
										'","noRonda":"'.$nRonda.'"}';
								if($arrJuecesBloquear=="")
									$arrJuecesBloquear=$oBloqueo;
								else
									$arrJuecesBloquear.=",".$oBloqueo;
							}
							
						}
						else
						{
							$oBloqueo="";
							if($resto["esJuezTramite"]==1)
							{
								$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"2","serieRonda":"'.$oAsignacion["tipoRonda"].
										'","noRonda":"'.$nRonda.'"}';
							}
							else
							{
								if($resto["esJuezIncidencia"]==1)
								{
									$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"3","serieRonda":"'.$oAsignacion["tipoRonda"].
											'","noRonda":"'.$nRonda.'"}';
								}
								else
								{
									$oBloqueo='{"idJuez":"'.$idJuez.'","tipoBloqueo":"5","serieRonda":"'.$oAsignacion["tipoRonda"].
											'","noRonda":"'.$nRonda.'","comentariosAdicionales":"'.cv($arrJuecesExcusa[$idJuez]).'"}';
								}
							}
							if($arrJuecesBloquear=="")
								$arrJuecesBloquear=$oBloqueo;
							else
								$arrJuecesBloquear.=",".$oBloqueo;
								
								
						}	
					}
					
				}

				$nRonda++;
				$ciclos++;
				
				
			}
			
			
		}
	}
}

function obtenerJuezTramiteFecha()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$fechaAudiencia=$obj->fechaAudiencia;
	
	$consulta="SELECT tipoJuez,titulo FROM _4_gridJuecesRequeridos WHERE idReferencia=".$obj->tipoAudiencia;
	$fJuez=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT usuarioJuez FROM _26_tablaDinamica j WHERE j.idReferencia=".$obj->idUnidadGestion."
					order by j.clave";
	$listaJuecesUnidadGestion=$con->obtenerListaValores($consulta);
	if($listaJuecesUnidadGestion=="")
		$listaJuecesUnidadGestion=-1;
	$consulta="SELECT nombreJueces FROM _292_tablaDinamica WHERE idEstado=1 and nombreJueces in (".$listaJuecesUnidadGestion.") AND '".$fechaAudiencia.
			"'>=fechaInicial AND '".$fechaAudiencia."'<=fechaFinal";
	$idJuez=$con->obtenerValor($consulta);
	if($idJuez=="")
		$idJuez=-1;
	
	$consulta="SELECT clave FROM _26_tablaDinamica WHERE idReferencia=".$obj->idUnidadGestion." AND usuarioJuez=".$idJuez;
	$clave=$con->obtenerValor($consulta);
		
	echo '1|{"tipoJuez":"'.$fJuez[0].'","participacion":"'.cv($fJuez[1]).'","serieRonda":"AD","noRonda":"0","pagoAdeudo":"0","idJuez":"'.
		$idJuez.'","nombreJuez":"'.cv("[".$clave."] ".obtenerNombreUsuario($idJuez)).'","arrJuecesBloquear":""}';
	
	
}

function obtenerJuecesDisponiblesUnidadGestionEventoCambio()
{
	global $con;
	global $tipoMateria;
	$idEvento=bD($_POST["iE"]);
	$idUnidadGestion=bD($_POST["iUG"]);
	$fechaEvento=bD($_POST["fE"]);
	$mostrarTodosJueces=false;
	$carpetaAdministrativa=($_POST["cA"]);
	if(isset($_POST["mostrarTodosJueces"]))
	{
		$mostrarTodosJueces=$_POST["mostrarTodosJueces"]==1;
	}
	
	

	$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	$listaJueces=$con->obtenerListaValores($consulta);
	if($listaJueces=="")
		$listaJueces=-1;
	
	$tipoJuez="";
	if($tipoMateria!="SCC")
	{
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".($carpetaAdministrativa)."'";
		
		$tCarpeta=$con->obtenerValor($consulta);
		switch($tCarpeta)
		{
			case 6:
			case 9:
				$tipoJuez=3;
			break;
			case 5:
				$tipoJuez=2;
			break;
			default:
				$tipoJuez=1;
			break;
		}
	}
	else
	{
		$tipoJuez=5;
	}
	//$consulta="SELECT tipoJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idEvento;
	//$tipoJuez=$con->obtenerValor($consulta);
	if($tipoJuez=="")
		$tipoJuez=1;
	
	$arrJueces="";
	$consulta="SELECT usuarioJuez,CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica t,
			800_usuarios u,_26_tipoJuez tj WHERE idReferencia=".$idUnidadGestion." AND u.idUsuario=t.usuarioJuez  
			and tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=".$tipoJuez." and 
			u.idUsuario not in(".$listaJueces.") ORDER BY clave";

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
			$comp="";	
			
			if(!esJuezDisponibleIncidencia($fila[0],$fechaEvento))
			{
				
				$comp="Juez con incidencia";
				
			}
			
			if(esJuezTramite($fila[0],$fechaEvento))
			{
				if($comp=="")
					$comp="Juez de tr&aacute;mite";
				else
					$comp.=" / Juez de tr&aacute;mite";
			}
		
			if($comp!="")
				$comp=" (".$comp.")";
			$oJuez="['".$fila[0]."','".cv($fila[1].$comp)."']";
			if($arrJueces=="")
				$arrJueces=$oJuez;
			else
				$arrJueces.=",".$oJuez;
		
	}
	
	echo "1|[".$arrJueces."]";
}


function registrarValorParametro()
{
	global $con;
	$idPerfil=$_POST["idPerfil"];
	$idProceso=$_POST["idProceso"];
	$idFormularioProceso=$_POST["idFormularioProceso"];
	$parametro=$_POST["parametro"];
	$valor=$_POST["valor"];
	$campo="";
	switch($parametro)
	{
		case 1:
			$campo="permiteSeleccionPlantilla";
		break;
		case 2:
			$campo="permiteEdicionTextoEnriquecido";
		break;
		case 3:
			$campo="idCategoriaDocumento";
		break;
		case 4:
			$campo="permiteSubirWord";
		break;
		case 5:
			$campo="idFormatoDefault";
		break;
		case 6:
			$campo="funcionAsignacion";
		break;
		case 7:
			$campo="publicaEnBoletin";
		break;
		case 8:
			$campo="permiteConfiguracionBoletin";
		break;
		case 9:
			$campo="permiteGuradarSinCambios";
		break;
	}
			
	
	$consulta="SELECT idRegistro FROM 3019_categoriaDocumentosAdjuntos WHERE idProceso=".$idProceso." AND idPerfil=".$idPerfil." AND idFormularioProceso=".$idFormularioProceso;
	$idRegistro=$con->obtenerValor($consulta);
	
	if($idRegistro=="")
	{
		$consulta="INSERT INTO 3019_categoriaDocumentosAdjuntos(idProceso,idPerfil,idFormularioProceso,".$campo.") 
					VALUES(".$idProceso.",".$idPerfil.",".$idFormularioProceso.",".$valor.")";
	}
	else
	{
		$consulta="UPDATE 3019_categoriaDocumentosAdjuntos SET ".$campo."=".$valor." WHERE idRegistro=".$idRegistro;
	}
	
	eC($consulta);
	
	
	
}


function obtenerAsignacionesAudienciaJuez()
{
	global $con;
	$uG=$_POST["uG"];
	$ciclo=$_POST["ciclo"];
	$periodoInicio=$ciclo."-01-01";
	$periodoFin=$ciclo."-12-31";
	
	$consulta="SELECT id__4_tablaDinamica FROM _4_tablaDinamica WHERE tipoAtencion=2";
	$lAudienciasUrgentes=$con->obtenerListaValores($consulta);
		
	$arrRegistros="";
	$numReg=0;
	$consulta=' SELECT usuarioJuez,CONCAT("[",clave,"] ",u.Nombre," (",ltj.tipoJuez,")") AS juez 
				 FROM _26_tablaDinamica j,800_usuarios u,_26_tipoJuez tj,_18_tablaDinamica ltj 
				 WHERE j.idReferencia='.$uG.' AND u.idUsuario=j.usuarioJuez AND tj.idPadre=j.id__26_tablaDinamica 
				 AND ltj.id__18_tablaDinamica=tj.idOpcion ORDER BY tj.idOpcion,clave';
	$res=$con->obtenerFilas($consulta);
	
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_0=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU_D' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_1=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND (tipoRonda='AU' or tipoRonda='AU_D') AND idUnidadGestion=".$uG." AND a.situacion=7 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_2=$con->obtenerValor($consulta);		
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU' AND idUnidadGestion=".$uG." AND a.situacion=6 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_3=$con->obtenerValor($consulta);	
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU' AND idUnidadGestion=".$uG." AND a.situacion=2 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_4=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU' AND idUnidadGestion=".$uG." AND a.situacion=3 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_5=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AU' AND idUnidadGestion=".$uG." AND a.situacion=4 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AU_6=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez a WHERE e.fechaEvento>='".$periodoInicio.
					"' AND e.fechaEvento<='".$periodoFin."' AND e.tipoAudiencia IN(".$lAudienciasUrgentes.
					") AND a.idRegistroEvento=e.idRegistroEvento AND a.idJuez=".$fila[0]." AND a.noRonda IS NULL";
		$AU_7=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_0=$con->obtenerValor($consulta);
		

		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN_D' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_1=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND (tipoRonda='AN' or tipoRonda='AN_D') AND idUnidadGestion=".$uG." AND a.situacion=7 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_2=$con->obtenerValor($consulta);		
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN' AND idUnidadGestion=".$uG." AND a.situacion=6 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_3=$con->obtenerValor($consulta);	
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN' AND idUnidadGestion=".$uG." AND a.situacion=2 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_4=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN' AND idUnidadGestion=".$uG." AND a.situacion=3 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_5=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='AN' AND idUnidadGestion=".$uG." AND a.situacion=4 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AN_6=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez a WHERE e.fechaEvento>='".$periodoInicio.
					"' AND e.fechaEvento<='".$periodoFin."' AND e.tipoAudiencia not IN(15,".$lAudienciasUrgentes.
					") AND a.idRegistroEvento=e.idRegistroEvento AND a.idJuez=".$fila[0]." AND a.noRonda IS NULL";
		$AN_7=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_0=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I_D' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_1=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND (tipoRonda='I' or tipoRonda='I_D') AND idUnidadGestion=".$uG." AND a.situacion=7 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_2=$con->obtenerValor($consulta);		
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I' AND idUnidadGestion=".$uG." AND a.situacion=6 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_3=$con->obtenerValor($consulta);	
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I' AND idUnidadGestion=".$uG." AND a.situacion=2 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_4=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I' AND idUnidadGestion=".$uG." AND a.situacion=3 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_5=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='I' AND idUnidadGestion=".$uG." AND a.situacion=4 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_6=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez a WHERE e.fechaEvento>='".$periodoInicio.
					"' AND e.fechaEvento<='".$periodoFin."' AND e.tipoAudiencia =15 AND a.idRegistroEvento=e.idRegistroEvento AND a.idJuez=".$fila[0]." AND a.noRonda IS NULL";
		$AI_7=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda in('IC','IC_D') AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$AI_8=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='G' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$G_0=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='G_D' AND idUnidadGestion=".$uG." AND a.situacion=1 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$G_1=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND (tipoRonda='G' or tipoRonda='G_D') AND idUnidadGestion=".$uG." AND a.situacion=7 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$G_2=$con->obtenerValor($consulta);		
		
		$consulta="SELECT COUNT(*) FROM 7001_asignacionesJuezAudiencia a WHERE idJuez=".$fila[0].
					" AND tipoRonda='G' AND idUnidadGestion=".$uG." AND a.situacion=6 and
					a.fechaEvento>='".$periodoInicio."' and a.fechaEvento<='".$periodoFin."'";
		$G_3=$con->obtenerValor($consulta);
		
		$total=	$AU_0+$AU_1+$AU_2+$AU_3+$AU_4+$AU_5+$AU_6+$AU_7+$AN_0+$AN_1+$AN_2+$AN_3+$AN_4+
				$AN_5+$AN_6+$AN_7+$AI_0+$AI_1+$AI_2+$AI_3+$AI_4+$AI_5+$AI_6+$AI_7+$AI_8+$G_0+
				$G_1+$G_2+$G_3;
		$oReg='{"idJuez":"'.$fila[0].'","juez":"'.cv($fila[1]).'","total":"'.$total.'",'.
				'"AU_0":"'.$AU_0.'","AU_1":"'.$AU_1.'","AU_2":"'.$AU_2.'","AU_3":"'.$AU_3.'","AU_4":"'.$AU_4.
				'","AU_5":"'.$AU_5.'","AU_6":"'.$AU_6.'","AU_7":"'.$AU_7.'",'.
				'"AN_0":"'.$AN_0.'","AN_1":"'.$AN_1.'","AN_2":"'.$AN_2.'","AN_3":"'.$AN_3.
				'","AN_4":"'.$AN_4.'","AN_5":"'.$AN_5.'","AN_6":"'.$AN_6.'","AN_7":"'.$AN_7.'",'.
				'"AI_0":"'.$AI_0.'","AI_1":"'.$AI_1.'","AI_2":"'.$AI_2.'","AI_3":"'.$AI_3.
				'","AI_4":"'.$AI_4.'","AI_5":"'.$AI_5.'","AI_6":"'.$AI_6.'","AI_7":"'.$AI_7.'","AI_8":"'.$AI_8.'",'.
				'"G_0":"'.$G_0.'","G_1":"'.$G_1.'","G_2":"'.$G_2.'","G_3":"'.$G_3.'"'.				
				'}';
		
		if($arrRegistros=="")
			$arrRegistros=$oReg;
		else
			$arrRegistros.=",".$oReg;
		$numReg++;
		
		
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function buscarParticipanteAudiencia()
{
	global $con;
	$tipoBusqueda=$_POST["tipoBusqueda"];
	$valor=$_POST["valor"];
	$campoBusqueda="";
	switch($tipoBusqueda)
	{
		case 1:
			$campoBusqueda="cedulaProfesional";
		break;
		case 2:
			$campoBusqueda="curp";
		break;
		case 3:
			$campoBusqueda="rfcEmpresa";
		break;
	}
	$consulta=" SELECT id__47_tablaDinamica,apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE ".$campoBusqueda."='".$valor."'";
	$fBusqueda=$con->obtenerPrimeraFila($consulta);
	if($fBusqueda)
	{
		$nombre=$fBusqueda[3]." ".$fBusqueda[1]." ".$fBusqueda[2];
		echo "1|".$fBusqueda[0]."|".$nombre;
		return;
	}
	
	echo "1|0";
	
}

function guardarRelacionFiguraExistente()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	
	$idActividad=$obj->idActividad;
	
	if($idActividad==-1)
	{
		$idActividad=generarIDActividad(-47);
		$consulta="UPDATE 7006_carpetasAdministrativas SET idActividad=".$idActividad." WHERE idCarpeta=".$obj->idCarpeta;
		$con->ejecutarConsulta($consulta);
		
		
	}
	
	$consulta="select count(*) from 7005_relacionFigurasJuridicasSolicitud where idActividad=".$idActividad.
			" and idParticipante=".$obj->idParticipante." and idFiguraJuridica=".$obj->idFiguraJuridica;
	$nReg=$con->obtenerValor($consulta);
	$x=0;
	$query[$x]="begin";
	$x++;
	if($nReg==0)
	{
		$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion)
					VALUES(".$idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",1)";
		$x++;
	}
	if($obj->relacion!="")
	{
		$arrRelacion=explode(",",$obj->relacion);
		foreach($arrRelacion as $r)
		{
			$consulta="select count(*) from 7005_relacionParticipantes where idActividad=".$idActividad.
			" and idParticipante=".$obj->idParticipante." and idFiguraJuridica=".$obj->idFiguraJuridica.
			" and idActorRelacionado=".$r;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
					VALUES(".$idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",".$r.",1)";
				$x++;
			}
		}
	}
	$query[$x]="commit";
	$x++;
	eB($query);
	
}

function obtenerDatosIdentificacion()
{
	global $con;
	
	$idParticipante=$_POST["idParticipante"];

	
	/*$consulta="SELECT id__47_tablaDinamica as idParticipante,tipoPersona,nacionalidad,otraNacionalidad,rfcEmpresa,curp,cedulaProfesional,
			nombre,apellidoPaterno,apellidoMaterno,genero,fechaNacimiento,edad,estadoCivil,grupoEtnico,discapacidad,aceptaNotificacionMail,
			tipoIdentificacion,otraIdentificacion,tipoDefensor as detalleTipo, '@alias' as alias,'@datosContacto' as datosContacto 
			FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idParticipante;*/
	
	$consulta="SELECT id__47_tablaDinamica as idParticipante,tipoPersona,nacionalidad,otraNacionalidad,apellidoPaterno,apellidoMaterno,fechaNacimiento,estadoCivil,
			tipoIdentificacion,folioIdentificacion,nombre,genero,esMexicano,grupoEtnico,discapacidad,tarjetaProfesional,fechaIdentificacion,tipoEntidad,
			aceptaNotificacionMail,desconoceNIT,desconoceIdentificacion,desconoceDomicilio,busquedaWS
			FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idParticipante;
	
	$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$objDatosParticipante='';
	foreach($fBusqueda as $clave=>$valor)
	{
		$o='"'.$clave.'":"'.cv($valor).'"';
		if($objDatosParticipante=="")
			$objDatosParticipante=$o;
		else
			$objDatosParticipante.=",".$o;
	}
	$objDatosParticipante='{'.$objDatosParticipante.'}';
	
	$objDatosContacto=obtenerUltimoDomicilioFiguraJuridica($idParticipante);
	
	
	$oFinalParticipante='{"validaCedulaProfesional":"0","situacionCedula":"1","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objDatosContacto.'}';
	
	
	
	
	echo "1|".$oFinalParticipante."";
	
	
}

function obtenerCuentasAccesoUsuariosCarpeta()
{
	global $con;
	$idActividad=$_POST["idActividad"];
	$consulta="SELECT id__47_tablaDinamica AS idUsuario,idRelacion,
			CONCAT(IF(nombre IS NULL,' ',nombre),' ',IF(apellidoPaterno IS NULL,' ',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,' ',apellidoMaterno)) AS nombre,
			idFiguraJuridica AS figuraJuridica,
			(SELECT situacionActual FROM 7005_bitacoraCuentasAcceso WHERE idActividad=r.idActividad AND idParticipante=r.idParticipante 
			AND idFiguraJuridica=r.idFiguraJuridica order by fechaCreacion desc limit 0,1) AS situacionCuenta FROM 
			7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad.
			" AND p.id__47_tablaDinamica=r.idParticipante";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));		
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}

function crearCuentaAcesoUsuariosCarpeta()
{
	global $con;
	global $tipoMateria;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$query="SELECT nombre,apellidoPaterno,apellidoMaterno,tipoDefensor FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$obj->idParticipante;
	$fParticipante=$con->obtenerPrimeraFila($query);
	
	$query="SELECT unidadGestion,fechaCreacion,carpetaAdministrativa,idCarpeta,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->carpeta."'";
	
	if($obj->idCarpeta!=-1)
		$query." and idCarpeta=".$obj->idCarpeta;
	$fCarpeta=$con->obtenerPrimeraFila($query);
	
	$query="SELECT g.tipoDelito FROM _17_tablaDinamica u,_17_gridDelitosAtiende g WHERE claveUnidad='".$fCarpeta[0]."'
			AND g.idReferencia=u.id__17_tablaDinamica";
	$tDelitos=$con->obtenerListaValores($query);
	$anioExpediente="";
	if($tipoMateria=="P")
	{

		$anioExpediente=date("Y",strtotime($fCarpeta[1]));
		$tDelitos="PO";
	}
	else
	{
		$arrExpediente=explode("/".$fCarpeta[2]);
		$anioExpediente[1];
	}
	
	
	
	$tblMail="7025_correosElectronico";
	$query="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
				yCalle,otrasReferencias,idRegistro  FROM 7025_datosContactoParticipante 
				WHERE idParticipante=".$obj->idParticipante." order by fechaCreacion desc";
	$fila=$con->obtenerPrimeraFilaAsoc($query);
	if(!$fila)
	{
		$tblMail="_48_correosElectronico";
		$tblTelefono="_48_telefonos";
		$query="SELECT calle,noExt,noInterior,colonia,codigoPostal,entidadFederativa,municipio,localidad,entreCalle,
					yCalle,otrasReferencias,id__48_tablaDinamica as idRegistro FROM _48_tablaDinamica WHERE idReferencia=".$obj->idParticipante;	
		
		$fila=$con->obtenerPrimeraFilaAsoc($query);
	}
	
	$arrCorreos="";
	if($fila)
	{
		$query="SELECT correo FROM ".$tblMail." WHERE idReferencia=".$fila["idRegistro"];
		$res=$con->obtenerFilas($query);
		while($f=$con->fetchRow($res))
		{
			if($arrCorreos=="")
				$arrCorreos=$f[0];
			else
				$arrCorreos.=",".$f[0];
		}
	}
	
	if($arrCorreos=="")
	{
		echo "<br>Debe registrar almenos una direcci&oacute;n de correo electr&oacute;nico para la creaci&oacute;n de la cuenta";
		return;
	}
	
	$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$obj->idFiguraJuridica;
	$lblFiguraExpediente=$con->obtenerValor($consulta);
	
	$idActividad=$fCarpeta[4];
	$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
								IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
								WHERE r.idActividad=".$idActividad." and idFiguraJuridica =2 AND r.idParticipante=p.id__47_tablaDinamica order 
								by nombre,apellidoPaterno,apellidoMaterno";
	$victimas=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
				IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." and idFiguraJuridica =4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
	$imputados=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT d.denominacionDelito FROM _61_tablaDinamica sd,_35_denominacionDelito d WHERE 
				idActividad=".$idActividad." AND d.id__35_denominacionDelito=sd.denominacionDelito";
	$delito=$con->obtenerListaValores($consulta);
	
	$detalleExpediente='{"imputado":"'.cv($imputados).'","victima":"'.cv($victimas).'","delito":"'.cv($delito).'"}';
	$lblDetalleFigura="";
	if($fParticipante[3]!="")
	{
		$consulta="SELECT etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$obj->idFiguraJuridica." AND idDetalle=".$fParticipante[3];
		$lblDetalleFigura=$con->obtenerValor($consulta);
	}
	
	
	$cadObjWS='{"idParticipante":"'.$obj->idParticipante.'","email":"'.$arrCorreos.'","apPaterno":"'.cv(($fParticipante[1])).'","apMaterno":"'.
			cv(($fParticipante[2])).'","nombre":"'.cv(($fParticipante[0])).'","idCarpeta":"'.$fCarpeta[3].
			'","carpeta":"'.$obj->carpeta.'","cveMateria":"'.$tDelitos.'","unidadGestion":"'.$fCarpeta[0].
			'","anioExpediente":"'.$anioExpediente.'","idFiguraJuridica":"'.$obj->idFiguraJuridica.
			'","lblFiguraExpediente":"'.$lblFiguraExpediente.'","detalleExpediente":"'.bE($detalleExpediente).
			'","idDetalleFigura":"'.$fParticipante[3].'","lblDetalleFigura":"'.$lblDetalleFigura.'","roles":"158","validarUsuarioMail":"'.$obj->validarUsuarioMail.'"}';
	
	
	$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
	
	$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
	
	$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
	
	$parametros=array();
	$parametros["cadObj"]=$cadObjWS;
	
	
	$response = $client->call("registrarCuentaAcceso", $parametros);
	$oJuzgado=json_decode(utf8_encode($response));
	
	
	switch($oJuzgado->resultado)
	{
		case 1:
			$consulta=array();
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$idUsuario=rand(1000,9999);
			$consulta[$x]="INSERT INTO 7005_bitacoraCuentasAcceso(idActividad,idParticipante,idFiguraJuridica,
						fechaCreacion,responsable,situacionAnterior,situacionActual,aplicado) 
						VALUES(".$obj->idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",'".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].",NULL,1,1)";
			$x++;
			$consulta[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET idCuentaAcceso=".$oJuzgado->idUsuarioSistema.
							" WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
							" AND idFiguraJuridica=".$obj->idFiguraJuridica;
			$x++;
			$consulta[$x]="commit";
			$x++;
			if($con->ejecutarBloque($consulta))
			{
				echo "1|1";
			}
		break;
		case 2:
			$arrUsuariosCoinciden="";
			
			foreach($oJuzgado->arrUsuarioSistema as $o)
			{
				$oAux="['".$o->idUsuario."','".cv($o->nombre)."','".$o->mails."']";
				if($arrUsuariosCoinciden=="")
					$arrUsuariosCoinciden=$oAux;
				else
					$arrUsuariosCoinciden.=",".$oAux;
			}
			
			echo "1|2|[".$arrUsuariosCoinciden."]";
		break;
		default:
			echo "<br>".($oJuzgado->mensaje);
		break;
	}
	
		
}


function cambiarSituacionUsuariosCarpeta()
{
	global $con;
	global $tipoMateria;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);

	$query="SELECT unidadGestion,fechaCreacion,carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas 
			WHERE carpetaAdministrativa='".$obj->carpetaAdministrativa."'";
	if($obj->idCarpeta!=-1)
		$query." and idCarpeta=".$obj->idCarpeta;
	
	$fCarpeta=$con->obtenerPrimeraFila($query);
	
	$query="SELECT g.tipoDelito FROM _17_tablaDinamica u,_17_gridDelitosAtiende g WHERE claveUnidad='".$fCarpeta[0]."'
			AND g.idReferencia=u.id__17_tablaDinamica";
	$tDelitos=$con->obtenerListaValores($query);
	if($tipoMateria=="P")
	{
		$tDelitos="PO";
	}
	$query="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$obj->idActividad.
			" AND idParticipante=".$obj->idParticipante." AND idFiguraJuridica=".$obj->idFiguraJuridica;
		
	$idUsuario=$con->obtenerValor($query);
	
	$cadObjWS='{"idUsuario":"'.$idUsuario.'","idCarpeta":"'.$fCarpeta[3].
			'","cveMateria":"'.$tDelitos.'","unidadGestion":"'.$fCarpeta[0].
			'","idFiguraJuridica":"'.$obj->idFiguraJuridica.'","situacion":"'.
			($obj->situacionCuenta==2?0:1).'"}';
	


	$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
	
	$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");

	$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
	$parametros=array();
	$parametros["cadObj"]=$cadObjWS;
	
	$response = $client->call("modificarCuentaAccesoCarpeta", $parametros);
	

	$oJuzgado=json_decode($response);
	
	if($oJuzgado->resultado==1)
	{
	
		$query="SELECT situacionActual FROM 7005_bitacoraCuentasAcceso WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante."
				AND idFiguraJuridica=".$obj->idFiguraJuridica." order by fechaCreacion desc limit 0,1";
		$situacionAnterior=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 7005_bitacoraCuentasAcceso(idActividad,idParticipante,idFiguraJuridica,fechaCreacion,responsable,situacionAnterior,situacionActual,
					aplicado,comentariosAdicionales) 
					VALUES(".$obj->idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",'".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].",".$situacionAnterior.",".$obj->situacionCuenta.",1,'".cv($obj->comentariosAdicionales)."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	else
		echo "<br>".($oJuzgado->mensaje);		
}

function obtenerHistorialCuentasAcceso()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idRegistro,fechaCreacion AS fechaOperacion,situacionAnterior AS etapaOriginal,situacionActual AS etapaCambio,
				(select Nombre from 800_usuarios where idusuario=b.responsable) as responsable,comentariosAdicionales 
				FROM 7005_bitacoraCuentasAcceso b WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
				" AND idFiguraJuridica=".$obj->idFiguraJuridica." ORDER BY fechaCreacion DESC";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));		
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}


function obtenerCarpetasAdministrativasUnidadGestionCautelares()
{
	global $con;
	$uG=$_POST["uG"];
	$anio=$_POST["anio"];
	$tC=$_POST["tC"];
	$limit=$_POST["limit"];
	$start=$_POST["start"];
	
	$consulta="SELECT campoUsr,campoMysql FROM 9017_camposControlFormulario";
	$arrCampos=$con->obtenerFilasArregloAsocPHP($consulta);
	
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					$condiciones=" and carpetaAdministrativa like '%".$filter[$x]["data"]["value"]."%'";
				break;
				case "etapaProcesal":
					$condiciones=" and etapaProcesalActual in(".$filter[$x]["data"]["value"].")";
				break;			
				
				default:
					$f=$filter[$x];
					$campo=$f["field"];
					
					if(isset($arrCampos[$campo]))
						$campo=$arrCampos[$campo];
					
					$condicion=" like ";
					if(isset($f["data"]["comparison"]))
					{
						switch($f["data"]["comparison"])
						{
							case "gt":
								$condicion=">";
							break;
							case "lt":
								$condicion="<";
							break;
							case "eq":
								$condicion="=";
							break;
						}
					}
					
					$valor="";
					switch($f["data"]["type"])
					{
						case "numeric":
							$valor=$f["data"]["value"];
						break;
						case "date":
							$fecha=$f["data"]["value"];
							$arrFecha=explode('/',$fecha);
							$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
						break;
						case "list":
							$condicion=" in ";
							$arrValores=explode(',',$f["data"]["value"]);
							$nCt=sizeof($arrValores);
							for($xAux=0;$xAux<$nCt;$xAux++)
							{
								if($valor=='')
									$valor=$arrValores[$xAux];
								else
									$valor.=",".$arrValores[$xAux];
							}
							
							
							$valor="(".$valor.")";
						break;
						default:
							$valor="'".$f["data"]["value"]."%'";
						break;
					}
					
					$condiciones.=" and ".$campo.$condicion.$valor;
				break;
				
			}
		}
		
	}
	
	
	
	$arrRegistro="";
	$numReg=0;
	$consulta="SELECT count(*) from 7006_carpetasAdministrativas  c
				WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
				and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones;
	$numReg=$con->obtenerValor($consulta);			
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,tipoCarpetaAdministrativa,carpetaAdministrativaBase,
				fechaCreacion,idActividad, carpetaInvestigacion,idCarpeta
				
				 FROM 7006_carpetasAdministrativas  c
				WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$anio."-01-01 00:00:01' 
				and fechaCreacion<='".$anio."-12-31 23:59:59' ".$condiciones." ORDER BY carpetaAdministrativa limit ".$start.",".($limit+1);

	$res=$con->obtenerFilas($consulta);

	while($fila=$con->fetchRow($res))
	{

		$carpetaInicial="";
		$carpetaOralidad="";
		$carpetaEjecucion="";	
		$lblAcciones="";	
		switch($fila[3])
		{
			case 1:
				
					$carpetaInicial=$fila[0];
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativaBase='".$carpetaInicial."' AND tipoCarpetaAdministrativa=5";
					$carpetaOralidad=$con->obtenerListaValores($consulta,"'");
					$carpetaAux="'".$carpetaInicial."'";
	
					if($carpetaOralidad!="")
					{
						$carpetaAux.=",".$carpetaOralidad;
						
					}
					
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
								WHERE carpetaAdministrativaBase in(".$carpetaAux.") AND 
								tipoCarpetaAdministrativa=6";
					$carpetaEjecucion=$con->obtenerListaValores($consulta);
					$carpetaOralidad=str_replace("'","",$carpetaOralidad);
				
			break;
			case 5:
				$carpetaInicial=$fila[4];
				$carpetaOralidad=$fila[0];
				
				$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
						WHERE carpetaAdministrativaBase='".$carpetaOralidad."' 
						AND tipoCarpetaAdministrativa=6";
				$carpetaEjecucion=$con->obtenerListaValores($consulta,"'");
				$carpetaEjecucion=str_replace("'","",$carpetaEjecucion);
			break;
			case 6:
				$carpetaEjecucion=$fila[0];				
				$carpetaInicial="";
				$carpetaOralidad="";
				
				$consulta="SELECT tipoCarpetaAdministrativa,carpetaAdministrativaBase FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$fila[4]."'";
				$fCarpeta=$con->obtenerPrimeraFila($consulta);	
				switch($fCarpeta[0])	
				{
					case 1:
						$carpetaInicial=$fila[4];
					break;
					case 5:
						$carpetaOralidad=$fila[4];
						$carpetaInicial=$fCarpeta[1];
					break;
				}
				$consulta="SELECT id__385_tablaDinamica FROM _385_tablaDinamica WHERE idEstado in(3,5) AND carpetaEjecucion='".$fila[0]."'";
				$idRegistro=$con->obtenerValor($consulta);
				
				if($idRegistro!="")
				{
					$lblAcciones="<a href='javascript:abrirDatosEnvioEjecucion(\\\"".bE($idRegistro)."\\\")'><img src='../images/page_white_magnify.png'></a>";
				}
				
				
			break;
		}
		$folioCarpetaInvestigacion=$fila[7];
		$cInicial="";
		
		
		if($fila[6]=="")	
			$fila[6]=-1;
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$imputados=$con->obtenerValor($consulta);
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$victimas=$con->obtenerValor($consulta);
		
		$consulta="SELECT GROUP_CONCAT(dl.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito dl WHERE d.idActividad=".$fila[6]." AND
					dl.id__35_denominacionDelito=d.denominacionDelito";
		
		$delitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT e.fechaEvento FROM 3013_registroResolutivosAudiencia  r,7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
				WHERE c.carpetaAdministrativa='".$fila[0]."' AND tipoContenido=3 AND idRegistroContenidoReferencia=r.idEvento 
				AND r.tipoResolutivo=50 AND e.idRegistroEvento=r.idEvento LIMIT 0,1";
		$fechaVinculacion=$con->obtenerValor($consulta);
		$arrCarpetasDerivadas=str_replace("'","",obtenerCarpetasDerivadas($fila[0],"1,5,6"))	;
		
		$fechaAcusacion="";
		$consulta="SELECT fechaReferencia FROM 3013_registroResolutivosAudiencia r,7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
					WHERE e.idRegistroEvento=r.idEvento AND tipoResolutivo=71 AND c.tipoContenido=3 AND c.idRegistroContenidoReferencia=e.idRegistroEvento
					AND c.carpetaAdministrativa='".$fila[0]."' AND fechaReferencia<>''  ORDER BY r.idRegistro LIMIT 0,1";
		$cierreInvestigacion=$con->obtenerValor($consulta);
		if($cierreInvestigacion!="")
		{
			$fechaAcusacion=obtenerHorasAjusteDiasNoHabiles($cierreInvestigacion,date("Y-m-d",strtotime("+15 days",strtotime($cierreInvestigacion))));

		}
		
		
		$o='{"carpetaAdministrativa":"'.$fila[0].'","situacion":"'.$fila[1].'","etapaProcesal":"'.$fila[2].
			'","fechaCreacion":"'.$fila[5].'","carpetaBase":"'.$fila[4].'","carpetaInvestigacion":"'.cv($folioCarpetaInvestigacion).
			'","imputados":"'.cv($imputados).'","victimas":"'.cv($victimas).'","delitos":"'.cv($delitos).
			'","carpetasDerivadas":"'.$arrCarpetasDerivadas.'","fechaVinculacion":"'.$fechaVinculacion.
			'","carpetaOralidad":"'.$carpetaOralidad.'","carpetaEjecucion":"'.$carpetaEjecucion.
			'","fechaAcusacion":"'.$fechaAcusacion.'","cierreInvestigacion":"'.$cierreInvestigacion.'","idCarpeta":"'.$fila[8].'"}';
		if($arrRegistro=="")
			$arrRegistro=$o;
		else
			$arrRegistro.=",".$o;

	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistro.']}';
}



function actualizarSituacionParticipante()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT situacionActual FROM 7005_bitacoraCambiosFigurasJuridicas 
			WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante." AND idFiguraJuridica=".$obj->idFiguraJuridica.
			" AND idActorRelacionado=".$obj->idActorRelacionado;
	$situacionActual=$con->obtenerValor($consulta);
	if($situacionActual=="")
	{
		$situacionActual=$obj->situacion==1?0:1;
	}
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
				situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
				(".$obj->idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",".$obj->idActorRelacionado.",".$situacionActual.",".
				$obj->situacion.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($obj->comentariosAdicionales)."')";
	$x++;
	if($obj->tipoAccion==1)
	{
		$query[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET situacion=".$obj->situacion.
					" WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
					" AND idFiguraJuridica=".$obj->idFiguraJuridica;
		$x++;
	}
	else
	{
		$query[$x]="UPDATE 7005_relacionParticipantes SET situacion=".$obj->situacion.
					" WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
					" AND idFiguraJuridica=".$obj->idFiguraJuridica." AND idActorRelacionado=".$obj->idActorRelacionado;
		$x++;
	}
	$query[$x]="commit";
	$x++;
	
	eB($query);
	
}

function registrarNuevasRelacionesParticipantes()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$arrRelaciones=explode(",",$obj->listaRelaciones);
	$x=0;
	$query[$x]="begin";
	$x++;
	
	foreach($arrRelaciones as $r)
	{
		$consulta="SELECT COUNT(*) FROM 7005_relacionParticipantes WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
				" AND idFiguraJuridica=".$obj->idFiguraJuridica." AND idActorRelacionado=".$r;
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
					situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
					(".$obj->idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",".$r.",NULL,1,'".
					date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($obj->comentariosAdicionales)."')";
			$x++;
			$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
					VALUES(".$obj->idActividad.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",".$r.",1)";
			$x++;
		}
	}
	
	$query[$x]="commit";
	$x++;
	
	eB($query);
}

function obtenerHistorialParte()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idRegistro,fechaCambio AS fechaOperacion,situacionAnterior AS etapaOriginal,detalleSituacionAnterior,situacionActual AS etapaCambio,
				detalleSituacion,(select Nombre from 800_usuarios where idUsuario=b.responsableCambio) as responsable,comentariosAdicionales,
				iFormulario,iReferencia 
				FROM 7005_bitacoraCambiosFigurasJuridicas b WHERE idActividad=".$obj->idActividad." AND idParticipante=".$obj->idParticipante.
				" AND idFiguraJuridica=".$obj->idFiguraJuridica." and idActorRelacionado=".$obj->idActorRelacionado." ORDER BY fechaCambio DESC";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));		
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}


function obtenerDocumentoFinalPDFEditorFormatoActor()
{
	global $con;
	$iDocumento=$_POST["iD"];
	$iF=$_POST["iF"];
	$iR=$_POST["iR"];
	$r=$_POST["r"];
	
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$iDocumento;
	$nombreArchivo=$con->obtenerValor($consulta);
	if($iF>0)
	{
		$consulta="SELECT idEstado FROM _".$iF."_tablaDinamica WHERE id__".$iF."_tablaDinamica=".$iR;
		$numEtapa=$con->obtenerValor($consulta);
		
		$idProceso=obtenerIdProcesoFormulario($iF);
		
		$actor=obtenerActorProcesoIdRol($idProceso,$r,$numEtapa);
		if($actor=="")
			$actor=0;
	}
	else
	{
		$actor=0;
	}
	
	
	echo "1|".$iDocumento."|".$nombreArchivo."|".$actor;
	
}

function idDocumentoIdRegistroFormato()
{
	global $con;
	$iR=$_POST["iRF"];
	
	$consulta="SELECT idDocumento FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$iR;
	$idDocumento=$con->obtenerValor($consulta);
	echo "1|".$idDocumento;
	
	
}

function obtenerMedidasCautelaresImputado()
{
	global $con;
	$c=$_POST["c"];
	$iC=$_POST["iC"];
	$i=$_POST["i"];
	
	$arrCarpetasAntecesoras=obtenerCarpetasAntecesoras($c);
	$listaCarpetasAntecesoras="";
	foreach($arrCarpetasAntecesoras as $c)
	{
		if($listaCarpetasAntecesoras=="")
		{
			$listaCarpetasAntecesoras="'".$c."'";
		}
		else
			$listaCarpetasAntecesoras.=",'".$c."'";
	}
	
	
	$arrMedidas="";
	$consulta="SELECT id__110_tablaDinamica,tipoMedidaCautelar FROM _110_tablaDinamica ORDER BY tipoMedidaCautelar";
	$arrMedidasCautelares=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT mc.tipoMedidaCautelar,valorComp1,valorComp2,comentariosAdicionales,m.tipoMedida FROM 7007_contenidosCarpetaAdministrativa c,3014_registroMedidasCautelares m,
				_110_tablaDinamica mc WHERE c.carpetaAdministrativa IN(".$listaCarpetasAntecesoras.") AND c.tipoContenido=3 AND 
				m.idEventoAudiencia=c.idRegistroContenidoReferencia and mc.id__110_tablaDinamica=m.tipoMedida AND idImputado=".$i;
	
	$res=$con->obtenerFilas($consulta);

	while($fila=$con->fetchRow($res))
	{
		$medida=$fila[0];
		
		
		switch($fila[4])
		{
			case '1':
				$consulta="SELECT nombreAutoridad FROM _328_tablaDinamica where id__328_tablaDinamica=".$fila[1];
				$nombreAutoridad=$con->obtenerValor($consulta);
				$medida.='. Presentarse ante autoridad: '+$nombreAutoridad;
			break;
			case '2':
				$medida.='. Monto de la garant&iacute;a: $'.number_format($fila[1],2).' ('.$fila[2].' '.(($fila[2]=='1')?'Pago':'Pagos').')';
			break;
			
		}
		if(trim($fila[3])!="")
			$medida.='. '.$fila[3];
		$m="['".$medida."']";
		if($arrMedidas=='')
			$arrMedidas=$m;
		else
			$arrMedidas.=",".$m;
	}
	
	echo "1|[".$arrMedidas."]";
}


function obtenerEventosAudienciaSGJPEvaluacion()
{
	global $con;
	
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "situacion":
					$c=" and situacion in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$c=" and idSala in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "edificio":
					$c=" and idEdificio=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "tipoAudiencia":
					$c=" and tipoAudiencia in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
			}
		}
		
	}
	
	$uG=$_POST["uG"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
			FROM 7000_eventosAudiencia e where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null and e.tipoAudiencia in(
			SELECT DISTINCT idReferencia FROM _4_gridProcesos)
			".$condiciones." ";		
	
	if($uG!=0)		
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
		$iUnidad=$con->obtenerValor($query);
		$consulta.=" and idCentroGestion=".$iUnidad;
	}
	else
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
		$iUnidad=$con->obtenerListaValores($query);
		$consulta.=" and idCentroGestion in(".$iUnidad.")";
	}
	
	
	

	if(isset($_POST["iEdificio"]))
	{
		$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
	}
	
	//$consulta.=" limit 25,5";

	
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT('(',noJuez,') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
	
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		
		$carpeta="";
		$tipoAudiencia=$fila[8];
		$tAudiencia="";
		$carpetaInvestigacion="";
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$carpeta=$fDatos[0];
			$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";

			$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fCarpetaInvestigacion[0];
			if($idActividad=="")
			{
				$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
			}

			$carpetaInvestigacion=$fCarpetaInvestigacion[1];
		}
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila[4])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".($fila[7]==""?-1:$fila[7]);
		$canal=$con->obtenerValor($consulta);
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
		
		
		$imputado=$con->obtenerListaValores($consulta);
		
		$tImputados=$con->filasAfectadas;
		
		$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion WHERE idEvento=".$fila[0]." and servicioWeb not in(1000,99) ORDER BY fecha DESC	";
		$fRegistroNotificacionMajo=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$idActividad."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";

		$lblDelitos=$con->obtenerValor($consulta);
		
		$o='{"urlCanal":"'.$canal.'","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
			"notificacionMAJO":"'.$fRegistroNotificacionMajo[0].'","mensajeMAJO":"'.cv($fRegistroNotificacionMajo[1]).
			'","delitos":"'.cv($lblDelitos).'","edificio":"'.$fila[14].'","carpetaInvestigacion":"'.$carpetaInvestigacion.'","imputado":"'.cv($imputado).'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function registrarParticipanteActividad()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);	
	
	
	$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$obj->idActividad.
			" AND idParticipante=".$obj->idParticipante." AND idFiguraJuridica=".$obj->tipoFigura;
	$nReg=$con->obtenerValor($consulta);
	
	
	if($nReg==0)
	{
		$consulta="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion)
					VALUES(".$obj->idActividad.",".$obj->idParticipante.",".$obj->tipoFigura.",1)"	;
		eC($consulta);
	}
	else
	{
		echo "1|";
	}
	
}

function obtenerHistorialJuezAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$consulta="SELECT idRegistro,fechaOperacion,
			(SELECT Nombre FROM 800_usuarios WHERE idUsuario=idJuezOriginal) AS juezOriginal,
			(SELECT Nombre FROM 800_usuarios WHERE idUsuario=idJuezCambio) AS juezCambio,
			(SELECT Nombre FROM 800_usuarios WHERE idUsuario=idResponsableOperacion) AS responsable,
			comentariosAdicionales FROM 3005_bitacoraCambiosJuez WHERE idEventoAudiencia=".$idEvento." ORDER BY fechaOperacion DESC";
		
	
	$arrRegistros=$con->obtenerFilasJSON($consulta);
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
}

function obtenerReporteNotificacionesCJF()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	
	$consulta="SELECT idReferencia FROM _460_tablaDinamica WHERE id__460_tablaDinamica=".$idRegistro;
	$idAmparo=$con->obtenerValor($consulta);
	
	$consulta="SELECT id__26_tablaDinamica,j.clave,cTJ.tipoJuez FROM _346_juecesAmparo je,_26_tablaDinamica j,_18_tablaDinamica cTJ,_26_tipoJuez tj 
			WHERE j.id__26_tablaDinamica=je.idOpcion AND je.idPadre=".$idAmparo."
			AND tj.idPadre=id__26_tablaDinamica AND cTJ.id__18_tablaDinamica=tj.idOpcion ORDER BY cTJ.tipoJuez,j.clave";
			
	$numReg=0;
	$arrRegistros="";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$status=0;
		$consulta="SELECT COUNT(*) FROM 7041_notificacionesCJF WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
				" AND juezNotifica=".$fila[0]." AND situacion=2";
				
		$nStatus=$con->obtenerValor($consulta);
		if($nStatus>0)
		{
			$status=2;
		}
		else
		{
			$consulta="SELECT COUNT(*) FROM 7041_notificacionesCJF WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
				" AND juezNotifica=".$fila[0]." AND situacion=1";
				
			$nStatus=$con->obtenerValor($consulta);
			if($nStatus>0)
			{
				$status=1;
			}
			else
			{
				$consulta="SELECT COUNT(*) FROM 7041_notificacionesCJF WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
					" AND juezNotifica=".$fila[0]." AND situacion=3";
					
				$nStatus=$con->obtenerValor($consulta);
				if($nStatus>0)
				{
					$status=3;
				}
			}
		}
				
		$o='{"idJuez":"'.$fila[0].'","etiquetaJuez":"Juez '.$fila[1].' ('.$fila[2].')","statusNotificacion":"'.$status.'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function buscarExhortoRegistrado()
{
	global $con;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT COUNT(*) FROM _524_tablaDinamica WHERE estadoEntidadExhortante='".$obj->entidadFederativa.
			"' AND numeroCausaOrigen='".cv($obj->numExpediente)."' AND noOficio='".cv($obj->numOficio)."'";
	
	$nCoincidencias=$con->obtenerValor($consulta);
	
	echo "1|".$nCoincidencias;
}


function buscarExhortoRegistradosGrid()
{
	global $con;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode(urldecode($cadObj));

	$numReg=0;
	$arrRegistros="";
	
	$consulta="SELECT * FROM _524_tablaDinamica WHERE estadoEntidadExhortante='".$obj->entidadFederativa.
			"' AND numeroCausaOrigen='".cv($obj->numExpediente)."' AND noOficio='".cv($obj->numOficio)."'";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		$arrFiguras="";
		$consulta="SELECT id__47_tablaDinamica,fJ.nombreTipo,GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),
				' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p,
				 _5_tablaDinamica fJ WHERE r.idActividad=".$fila[12]." and r.idParticipante=p.id__47_tablaDinamica 
				 and fJ.id__5_tablaDinamica=r.idFiguraJuridica order 	by fJ.nombreTipo, nombre,apellidoPaterno,apellidoMaterno";
		$resFigura=$con->obtenerFilas($consulta);
		while($filaFigura=$con->fetchRow($resFigura))
		{
			$oFigura="['".$filaFigura[0]."','".cv($filaFigura[2])." (".cv($filaFigura[1]).")']";
			if($arrFiguras=="")
				$arrFiguras=$oFigura;
			else
				$arrFiguras.=",".$oFigura;
		}
		
		$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 9074_documentosRegistrosProceso d,908_archivos a 
				WHERE idFormulario=524 AND idRegistro=".$fila[0]." AND a.idArchivo=d.idDocumento ORDER BY nomArchivoOriginal";
		$arrDocumentos=$con->obtenerFilasArreglo($consulta);
		
		$o='{"idRegistro":"'.$fila[0].'","carpertaExhorto":"'.$fila[10].'","fechaRecepcion":"'.($fila[13]." ".$fila[14]).
			'","entidadFederativa":"'.$fila[15].'","juzgadoExhortante":"'.cv($fila[16]).'","noExpediente":"'.cv($fila[18]).
			'","noOficio":"'.cv($fila[19]).'","figuraJuridica":['.$arrFiguras.'],"documentos":'.$arrDocumentos.'}';
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}


function buscarEdificioFiscalia()
{
	global $con;
	$cveEdificio="-1";
	$fiscalia=$_POST["fiscalia"];
	$lugarInternamiento=$_POST["lugarInternamiento"];
	$idEdificio=-1;
	
	if($lugarInternamiento=="")
	{
	
		$consulta="SELECT idReferencia FROM _361_tablaDinamica WHERE fiscalias=".$fiscalia." and sistema=1";
		$idUnidad=$con->obtenerValor($consulta);
		if($idUnidad!="")
		{
			$consulta="SELECT idReferencia FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idUnidad;	
			$idEdificio=$con->obtenerValor($consulta);
			$consulta="SELECT cveInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idEdificio;
			$cveEdificio=$con->obtenerValor($consulta);
		}
	}
	else
	{
		$consulta="SELECT reclusorio FROM _615_tablaDinamica WHERE centroDetencion='".$lugarInternamiento."'";
		$idEdificio=$con->obtenerValor($consulta);
		$consulta="SELECT cveInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=".$idEdificio;
		$cveEdificio=$con->obtenerValor($consulta);
	}
	echo "1|".$idEdificio."|".$cveEdificio;
}

function buscarPosibleUnidadDestino()
{
	global $con;
	$tipoUnidad=$_POST["tipoUnidad"];
	$idEdificio=$_POST["idEdificio"];
	$arrTiposUnidades=explode(",",$tipoUnidad);
	$tUnidad="";
	foreach($arrTiposUnidades as $u)
	{
		if($tUnidad=="")
			$tUnidad="'".$u."'";
		else
			$tUnidad.=",'".$u."'";
	}
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica u,_17_gridDelitosAtiende g
			  WHERE g.idReferencia=u.id__17_tablaDinamica AND u.idReferencia=".$idEdificio." AND g.tipoDelito in(".$tUnidad.") ORDER BY u.prioridad";

	$arrUgas=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrUgas;
	
	
	
	
	
	
}


function obtenerSolicitudesUGAS()
{
	global $con;
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$unidadGestion=$_POST["unidadGestion"];
	$tipoAtencion=$_POST["tipoAtencion"];
	$situacionSolicitud=$_POST["situacionSolicitud"];
	$numReg=0;
	$arrRegistros="";
	$compInicial=" and s.idEstado not in(2.7,2.5,1.4)";
	$compPromocion=" and s.idEstado not in(2,1.4)";
	if($situacionSolicitud==2)
	{
		$compInicial=" and s.idEstado in(2.7,2.5,1.4)";
		$compPromocion=" and s.idEstado in(2,1.4)";
	}
	$consulta="";
	if($unidadGestion==0)
	{
		$consulta=" 
					select * from (
					SELECT '46' AS iFormulario,id__46_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion
					FROM _46_tablaDinamica s,_4_tablaDinamica a WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compInicial."
					AND a.tipoAtencion=".$tipoAtencion." 
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion FROM _96_tablaDinamica s,_4_tablaDinamica a WHERE  s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59'  AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compPromocion."
					AND s.tipoPromociones=2 AND a.tipoAtencion=".$tipoAtencion." ) as tmp
					
					ORDER BY fechaRegistro DESC";
		
		if($tipoAtencion==1)
		{
			$consulta=" 
					select * from (
					SELECT '46' AS iFormulario,id__46_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo, '' as asuntoPromocion
					FROM _46_tablaDinamica s,_4_tablaDinamica a WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compInicial."
					AND a.tipoAtencion=".$tipoAtencion." 
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion FROM _96_tablaDinamica s,_4_tablaDinamica a WHERE  s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59'  AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compPromocion."
					AND s.tipoPromociones=2 AND a.tipoAtencion=".$tipoAtencion." 
					
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					'-1' as  tipoSolicitud,s.idEstado AS etapaActual,'' as 'tAudiencia','' as fechaFenecimiento,-1 as horasMaximaAgendaAudiencia,
					s.codigo,s.asuntoPromocion FROM _96_tablaDinamica s WHERE s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59' AND s.tipoPromociones=1 and s.idEstado>=1.4 ".$compPromocion."
	
	 
					
					) as tmp
					
					ORDER BY fechaRegistro DESC ";
		}
	}
	else
	{
		$consulta=" 
					select * from (
					SELECT '46' AS iFormulario,id__46_tablaDinamica AS iRegistro,s.carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion
					FROM _46_tablaDinamica s,_4_tablaDinamica a,7006_carpetasAdministrativas c WHERE 
					s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compInicial."
					AND a.tipoAtencion=".$tipoAtencion." and c.carpetaAdministrativa=s.carpetaAdministrativa
					and c.unidadGestion='".$unidadGestion."'
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,s.carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion FROM _96_tablaDinamica s,_4_tablaDinamica a,
					7006_carpetasAdministrativas c WHERE  s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59'  AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compPromocion."
					AND s.tipoPromociones=2 AND a.tipoAtencion=".$tipoAtencion." and c.carpetaAdministrativa=s.carpetaAdministrativa
					and c.unidadGestion='".$unidadGestion."') as tmp
					
					ORDER BY fechaRegistro DESC";
		
		if($tipoAtencion==1)
		{
			$consulta=" 
					select * from (
					SELECT '46' AS iFormulario,id__46_tablaDinamica AS iRegistro,s.carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo, '' as asuntoPromocion
					FROM _46_tablaDinamica s,_4_tablaDinamica a,7006_carpetasAdministrativas c  WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compInicial."
					AND a.tipoAtencion=".$tipoAtencion." and c.carpetaAdministrativa=s.carpetaAdministrativa
					and c.unidadGestion='".$unidadGestion."'
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,s.carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion FROM _96_tablaDinamica s,_4_tablaDinamica a,7006_carpetasAdministrativas c 
					 WHERE  s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59'  AND a.id__4_tablaDinamica=s.tipoAudiencia and s.idEstado>=1.4 ".$compPromocion."
					AND s.tipoPromociones=2 AND a.tipoAtencion=".$tipoAtencion." and c.carpetaAdministrativa=s.carpetaAdministrativa
					and c.unidadGestion='".$unidadGestion."' 
					
					union
					SELECT '96' AS iFormulario,id__96_tablaDinamica AS iRegistro,s.carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					'-1' as  tipoSolicitud,s.idEstado AS etapaActual,'' as 'tAudiencia','' as fechaFenecimiento,-1 as horasMaximaAgendaAudiencia,
					s.codigo,s.asuntoPromocion FROM _96_tablaDinamica s,7006_carpetasAdministrativas c  WHERE s.fechaCreacion>='".$fechaInicio.
					"' AND s.fechaCreacion<='".$fechaFin." 23:59:59' AND s.tipoPromociones=1 and s.idEstado>=1.4 ".$compPromocion." and c.carpetaAdministrativa=s.carpetaAdministrativa
					and c.unidadGestion='".$unidadGestion."'
	
	 
					
					) as tmp
					
					ORDER BY fechaRegistro DESC ";
		}

	}
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"]."'";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE numeroCarpetaAdministrativa='".$fila["carpetaAdministrativa"].
				"' AND iFormulario=".$fila["iFormulario"]." AND iRegistro=".$fila["iRegistro"]." 
				and idUsuarioDestinatario<>1";
		$totalTareasEmitidas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE numeroCarpetaAdministrativa='".$fila["carpetaAdministrativa"].
				"' AND iFormulario=".$fila["iFormulario"]." AND iRegistro=".$fila["iRegistro"]." 
				and fechaVisualizacion is not null and idUsuarioDestinatario<>1";
		$totalTareasVisualizada=$con->obtenerValor($consulta);
		
		$o='{"iRegistro":"'.$fila["iRegistro"].'","iFormulario":"'.$fila["iFormulario"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].
			'","fechaRegistro":"'.$fila["fechaRegistro"].'","fechaFenecimiento":"'.$fila["fechaFenecimiento"].'","unidadGestion":"'.$unidadGestion.'",
			"tipoSolicitud":"'.$fila["tAudiencia"].'","etapaActual":"'.$fila["etapaActual"].
			'","totalTareasEmitidas":"'.$totalTareasEmitidas.'","totalTareasVisualizadas":"'.$totalTareasVisualizada.
			'","horasMaximaAtencion":"'.$fila["horasMaximaAgendaAudiencia"].'","folioRegistro":"'.(($fila["iFormulario"]==46?"(I) ":"(P) ").
			$fila["codigo"]).'","asuntoPromocion":"'.cv($fila["asuntoPromocion"]).'"}';
			
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
}

function obtenerTareasAsociadasProceso()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];
	$idRegistro=$_POST["idRegistro"];
	$tTarea=$_POST["tTarea"];
	$consulta="SELECT idRegistro,fechaAsignacion,tipoNotificacion,usuarioDestinatario,fechaVisualizacion FROM 9060_tableroControl_4 WHERE
				iFormulario=".$idFormulario." AND iRegistro=".$idRegistro." and idUsuarioDestinatario<>1";
	if($tTarea==1)
	{
		$consulta.=" and fechaVisualizacion is not null";
	}
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
	
	
}

function marcarSolicitudInicialAtendida()
{
	global $con;
	
	$cadObj=$_POST["cadObj"];
	$obj=json_decode(urldecode($cadObj));
	
	if(cambiarEtapaFormulario($obj->idFormulario,$obj->idRegistro,7,$obj->motivoCambio,-1,"NULL","NULL",0))
	{
		$x=0;
		$consulta=array();
		$consulta[$x]="begin";
		$x++;
		$query="SELECT idTableroControl FROM 9060_tablerosControl";
		$rTableros=$con->obtenerFilas($query);
		while($fTablero=$con->fetchRow($rTableros))
		{
			$tablaTablero="9060_tableroControl_".$fTablero[0];
			if($con->existeTabla($tablaTablero))
			{
				$consulta[$x]="UPDATE ".$tablaTablero." SET idEstado=0 WHERE iFormulario=".$obj->idFormulario." AND iReferencia=".$obj->idRegistro;
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	
}


function obtenerCarpetasSeguimientoMediatico()
{
	global $con;
	$numReg=0;
	$arrFilas="";
	$consulta="SELECT c.idCarpeta,c.carpetaAdministrativa,c.carpetaInvestigacion,c.idActividad,aM.seguirPorMail,
				aM.id__586_tablaDinamica FROM _586_tablaDinamica aM,7006_carpetasAdministrativas c WHERE aM.idEstado=2 and 
				c.idCarpeta=aM.idCarpetaAdministrativa order by c.fechaCreacion ";
	$resCarpetas=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($resCarpetas))
	{
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
			FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[3]." and
			i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
	
	
		$imputado=$con->obtenerListaValores($consulta);
		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$fila[3]."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";

		$lblDelitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila[3]." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
		$victima=$con->obtenerListaValores($consulta);
		
		$listaCarpetasDerivadas=obtenerCarpetasVinculadas($fila[1],-1);
		
		
		$consulta="SELECT COUNT(*) FROM _96_tablaDinamica WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND idEstado>1.4";
		$totalPromociones=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _451_tablaDinamica WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND idEstado>1";
		$totalApelaciones=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _460_tablaDinamica WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND idEstado>=2";
		$totalPromocionesAmparos=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _346_tablaDinamica WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND idEstado>1";
		$totalAmparos=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con WHERE 
				con.carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				AND e.situacion IN(1,2,4,5)";		
		$totalAudiencias=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM _434_tablaDinamica WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND idEstado>1";
		$totalOrdenesAprehension=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,3014_registroAcuerdosReparatorios aR WHERE 
				con.carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				AND aR.idEvento=e.idRegistroEvento";		
		$totalAcuerdosReparatorios=$con->obtenerValor($consulta);
		
		$notificacionesMail="";
		$consulta="SELECT CONCAT(email,' (',nombre,')') AS mail FROM _586_gNotificacionCorreo WHERE idReferencia=".$fila[5];
		$rNotificaciones=$con->obtenerFilas($consulta);
		while($fNotificaciones=$con->fetchRow($rNotificaciones))
		{
			if($notificacionesMail=="")
				$notificacionesMail=$fNotificaciones[0];
			else
				$notificacionesMail.="<br>".$fNotificaciones[0];
		}
		
		$consulta="SELECT COUNT(*) FROM _586_comentariosAsuntoMediatico WHERE carpetaAdministrativa='".$fila[1]."'";
		$numComentarios=$con->obtenerValor($consulta);
		
		$o='{
				"idCarpeta":"'.$fila[0].'",
				"carpetaAdministrativa":"'.$fila[1].'",
				"carpetaInvestigacion":"'.$fila[2].'",
				"imputados":"'.cv($imputado).'",
				"victimas":"'.cv($victima).'",
				"delitos":"'.cv($lblDelitos).'",
				"totalAudiencias":"'.$totalAudiencias.'",	                                                
				"totalPromociones":"'.$totalPromociones.'",
				"totalApelaciones":"'.$totalApelaciones.'",
				"totalAmparos":"'.$totalAmparos.'",
				"totalOrdenesAprehension":"'.$totalOrdenesAprehension.'",
				"totalAcuerdosReparatorios":"'.$totalAcuerdosReparatorios.'",
				"seguirPorMail":"'.$fila[4].'",
				"idRegistro":"'.$fila[5].'",
				"notificacionesMail":"'.cv($notificacionesMail).'",
				"numComentarios":"'.$numComentarios.'",
				"totalPromocionesAmparos":"'.$totalPromocionesAmparos.'"
			}';
		if($arrFilas=="")
			$arrFilas=$o;
		else
			$arrFilas.=",".$o;
		$numReg++;	
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrFilas.']}';
}


function obtenerRegistrosProceso()
{
	global $con;
	$iF=$_POST["iF"];
	$cA=$_POST["cA"];
	$arrRegistros="";
	$numReg=0;
	
	$listaCarpetasDerivadas=obtenerCarpetasVinculadas($cA,-1);
	
	switch($iF)
    {
    	case '96':
        	$consulta="SELECT id__96_tablaDinamica,codigo,fechaCreacion,idEstado,asuntoPromocion,tipoAudiencia,idEstado,
						(SELECT nombreTipoPromocion FROM _97_tablaDinamica WHERE id__97_tablaDinamica=p.tipoPromociones),carpetaAdministrativa 
						FROM _96_tablaDinamica p WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") and idEstado>1.4 ORDER BY fechaCreacion";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$lblDetalles=$fila[7].": ";
				$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=103 AND numEtapa=".$fila[3];
				$situacionActual=removerCerosDerecha($fila[3]).".- ".$con->obtenerValor($consulta);
				if(($fila[5]!="")&&($fila[5]!=-1))
				{
					$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fila[5];
					$lblDetalles.=$con->obtenerValor($consulta);
				}
				else
				{
					if($fila[4]!="")
					{
						$lblDetalles.=$fila[4];
					}
					else
						$lblDetalles.="(Sin detalles)";
					
				}
				
				$o='{"iFormulario":"96","iRegistro":"'.$fila[0].'","folioRegistro":"'.$fila[1].'","fechaCreacion":"'.$fila[2].
				'","detalles":"'.cv($lblDetalles).'","situacionActual":"'.$situacionActual.'","carpetaAdministrativa":"'.$fila[8].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
        break;
        case '451':
        	$consulta="SELECT id__451_tablaDinamica,codigo,fechaCreacion,idEstado,resolucionImpugnada,nombreResolucion,idEstado,carpetaAdministrativa
						
						FROM _451_tablaDinamica p WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") and idEstado>1 ORDER BY fechaCreacion";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$lblDetalles=($fila[4]==1?"Resoluci&oacute;n emitida en audiencia":"Resoluci&oacute;n emitida por escrito").": ".$fila[5];
				$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=200 AND numEtapa=".$fila[3];
				$situacionActual=removerCerosDerecha($fila[3]).".- ".$con->obtenerValor($consulta);
				
				
				$o='{"iFormulario":"451","iRegistro":"'.$fila[0].'","folioRegistro":"'.$fila[1].'","fechaCreacion":"'.$fila[2].
				'","detalles":"'.cv($lblDetalles).'","situacionActual":"'.$situacionActual.'","carpetaAdministrativa":"'.$fila[7].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
        break; 
        case '346':
			$consulta="SELECT id__346_tablaDinamica,codigo,fechaCreacion,idEstado,noJuicioAmparo,organoJurisdiccionalRequiriente,idEstado,carpetaAdministrativa
						
						FROM _346_tablaDinamica p WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") and idEstado>1 ORDER BY fechaCreacion";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				
				$consulta="SELECT organoJuridiccional FROM _468_tablaDinamica WHERE id__468_tablaDinamica=".$fila[5];
				$organo=$con->obtenerValor($consulta);
				$lblDetalles="Juicio de amparo n&uacute;mero: ".$fila[4].", ".$organo;
				$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=164 AND numEtapa=".$fila[3];
				$situacionActual=removerCerosDerecha($fila[3]).".- ".$con->obtenerValor($consulta);
				
				
				$o='{"iFormulario":"346","iRegistro":"'.$fila[0].'","folioRegistro":"'.$fila[1].'","fechaCreacion":"'.$fila[2].
				'","detalles":"'.cv($lblDetalles).'","situacionActual":"'.$situacionActual.'","carpetaAdministrativa":"'.$fila[7].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
        	
        break; 
        case '434':
        	$consulta="SELECT id__434_tablaDinamica,codigo,fechaCreacion,idEstado,(SELECT tipoOrden FROM _433_tablaDinamica WHERE id__433_tablaDinamica= p.tipoOrdenes),
					imputado,idEstado,	motivo,carpetaAdministrativa					
						FROM _434_tablaDinamica p WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") and idEstado>1 ORDER BY fechaCreacion";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				
				$nombreImputado=obtenerNombreImplicado($fila[5]);
				$lblDetalles=$fila[4].", Imputado: ".$nombreImputado.". Motivo:" .$fila[7];
				$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=196 AND numEtapa=".$fila[3];
				$situacionActual=removerCerosDerecha($fila[3]).".- ".$con->obtenerValor($consulta);
				
				
				$o='{"iFormulario":"434","iRegistro":"'.$fila[0].'","folioRegistro":"'.$fila[1].'","fechaCreacion":"'.$fila[2].
				'","detalles":"'.cv($lblDetalles).'","situacionActual":"'.$situacionActual.'","carpetaAdministrativa":"'.$fila[8].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
        break; 
		case '460':
			$consulta="SELECT id__460_tablaDinamica,codigo,fechaCreacion,idEstado,carpetaAdministrativa,tipoPromocion,idEstado,carpetaAdministrativa
						
						FROM _460_tablaDinamica p WHERE carpetaAdministrativa in(".$listaCarpetasDerivadas.") and idEstado>=2 ORDER BY fechaCreacion";
	
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				$consulta="SELECT tipoPromocion FROM _461_tablaDinamica WHERE id__461_tablaDinamica=".$fila[5];
				$tipoPromocion=$con->obtenerValor($consulta);
				
				$lblDetalles="Promoci&oacute;n de Juicio de amparo: ".$fila[4].": ".$tipoPromocion;
				$consulta="SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=204 AND numEtapa=".$fila[3];
				$situacionActual=removerCerosDerecha($fila[3]).".- ".$con->obtenerValor($consulta);
				
				
				$o='{"iFormulario":"460","iRegistro":"'.$fila[0].'","folioRegistro":"'.$fila[1].'","fechaCreacion":"'.$fila[2].
				'","detalles":"'.cv($lblDetalles).'","situacionActual":"'.$situacionActual.'","carpetaAdministrativa":"'.$fila[7].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
        	
        break; 
    }
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}


function obtenerAcuerdosReparatoriosCarpetaJudicial()
{
	global $con;
	$carpetaAdministrativa=$_POST["cA"];
	$listaCarpetasDerivadas=obtenerCarpetasVinculadas($carpetaAdministrativa,-1);
	
		
	
	$consulta="SELECT aR.resumenAcuerdo,aR.tipoCumplimiento,aR.acuerdoAprobado,aR.fechaExtincionAccionPenal,aR.comentariosAdicionales,aR.idRegistro,
					e.fechaEvento,e.idRegistroEvento,con.carpetaAdministrativa  
				FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,3014_registroAcuerdosReparatorios aR WHERE 
				con.carpetaAdministrativa in(".$listaCarpetasDerivadas.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
				AND aR.idEvento=e.idRegistroEvento";
			
	$arrRegistros="";
	
	$res=$con->obtenerFilas($consulta);
	$numReg=0;
	while($fila=$con->fetchRow($res))
	{
		$consulta="SELECT group_concat(concat(if(p.nombre is null,'',p.nombre),' ',if(p.apellidoPaterno is null,'',p.apellidoPaterno),' ',if(p.apellidoMaterno is null,'',p.apellidoMaterno)))
				 FROM 3014_imputadosAcuerdoReparatorio i,_47_tablaDinamica p WHERE idAcuerdo=".$fila[5]." and p.id__47_tablaDinamica=i.idImputado order by p.nombre,p.apellidoPaterno,p.apellidoMaterno";
		$imputados=$con->obtenerValor($consulta);
		
		$consulta="SELECT a.idArchivo as idDocumento,a.nomArchivoOriginal as nombreDocumento,a.tamano as tamano FROM 3014_documentosAcuerdoRepatatorio d,908_archivos a 
				WHERE idAcuerdo=".$fila[5]." and a.idArchivo=d.idDocumento";
				
		$arrDocumentos=$con->obtenerFilasJSON($consulta);		
		
		$o='{"carpetaAdministrativa":"'.$fila[8].'","imputados":"'.cv($imputados).'","resumenAcuerdo":"'.cv($fila[0]).'","tipoCumplimiento":"'.$fila[1].'","acuerdoAprobado":"'.$fila[2].
			'","fechaExtincionAccionPenal":"'.$fila[3].'","arrDocumentos":'.$arrDocumentos.',"comentariosAdicionales":"'.cv($fila[4]).
			'","idRegistro":"'.$fila[5].'","fechaEvento":"'.$fila[6].'","idEventoAudiencia":"'.$fila[7].'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
			
		$numReg++;
	}
	
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function actualizarSeguimientoMail()
{
	global $con;
	$iS=$_POST["iS"];
	$valor=$_POST["valor"];
	$consulta="UPDATE _586_tablaDinamica SET seguirPorMail=".$valor." where id__586_tablaDinamica=".$iS;
	eC($consulta);
}

function registrarCambioSituacionAcuerdoReparatorio()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	if(registrarCambioSituacionObjeto(2,$obj->idAcuerdo,$obj->situacionActual,$obj->comentariosAdicionales))
	{
		echo "1|";
	}
	
}

function obtenerBitacoraCambiosAcuerdo()
{
	global $con;
	$idAcuerdo=$_POST["idAcuerdo"];
	
	
	$consulta="SELECT idRegistro,fechaCambio AS fechaOperacion,fechaExtinsion AS fechaExtinsionAnterior,
			(SELECT Nombre FROM 800_usuarios WHERE idUsuario=b.idResponsableCambio) AS responsable, comentariosAdicionales
				FROM 3014_modificacionesAcuerdoReparatorio b WHERE idAcuerdo=".$idAcuerdo." order by fechaCambio desc";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
}

function obtenerResolutivosAudienciaDisponibles()
{
	global $con;
	$criterio=$_POST["criterio"];
	$idEvento=$_POST["idEvento"];
	
	$consulta="SELECT tipoAudiencia FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT idReferencia FROM _327_gridTiposAudiencia WHERE tipoAudiencia=".$tipoAudiencia;
	$tipoResolutivo=$con->obtenerListaValores($consulta);
	if($tipoResolutivo=="")
		$tipoResolutivo=-1;
	$consulta="SELECT DISTINCT idReferencia FROM _327_gridTiposAudiencia where tipoAudiencia<>".$tipoAudiencia;
	$lAudiencias=$con->obtenerListaValores($consulta);
	if($lAudiencias=="")
		$lAudiencias=-1;
	
	$consulta="SELECT tipoResolutivo FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEvento;
	$lAuxiliar=$con->obtenerListaValores($consulta);
	if($lAuxiliar!="")
	{
		if($lAudiencias=="")
			$lAudiencias=$lAuxiliar;
		else
			$lAudiencias.=",".$lAuxiliar;
	}
	$consulta="SELECT id__327_tablaDinamica FROM _327_tablaDinamica WHERE id__327_tablaDinamica NOT IN(".$lAudiencias.")";
	$listaResolutivos=$con->obtenerListaValores($consulta);
	if($listaResolutivos!="")
	{
		if($tipoResolutivo=="")
			$tipoResolutivo=$listaResolutivos;
		else
			$tipoResolutivo.=",".$listaResolutivos;
	}
	
	$consulta="SELECT d.tipoDelito FROM 7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c,
			_17_tablaDinamica u,_17_gridDelitosAtiende d
			WHERE c.carpetaAdministrativa=con.carpetaAdministrativa AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=".$idEvento."
			AND u.claveUnidad=c.unidadGestion AND d.idReferencia=u.id__17_tablaDinamica";
	$tiposDelito=$con->obtenerListaValores($consulta,"'");
	if($tiposDelito=="")
		$tiposDelito=-1;
		
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT * from(select distinct id__327_tablaDinamica as idResolutivo,concat('(',codigo,') ',descripcionResolutivo) as resolutivo,
			tipoResultado,prioridad FROM _327_tablaDinamica r,_327_tiposUGJ u
			WHERE id__327_tablaDinamica IN(".$tipoResolutivo.") and u.idPadre=r.id__327_tablaDinamica and u.idOpcion in (".$tiposDelito.")) as  tmp
			 WHERE resolutivo LIKE '%".$criterio."%' 	ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fRegistro=$con->fetchRow($res))	
	{
		$consulta="SELECT cveElemento,descripcion FROM _327_gOpcionesSeleccion WHERE idReferencia=".$fRegistro[0]." ORDER BY descripcion";
		$arrOpciones=$con->obtenerFilasArreglo($consulta);
		$o='{"idResolutivo":"'.$fRegistro[0].'","resolutivo":"'.cv($fRegistro[1]).'","tipoResultado":"'.$fRegistro[2].'","opciones":'.$arrOpciones.'}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}


	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function guardarResolutivoAudiencia()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT idRegistro FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$obj->idEvento." AND tipoResolutivo=".$obj->resolutivo->idResolutivo;
	$idRegistroResolutivo=$con->obtenerValor($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$fechaReferencia="NULL";		
	if($obj->resolutivo->idResolutivo==71)
	{
		$oFecha=json_decode($obj->resolutivo->valor);
		$fechaReferencia="'".$oFecha->fechaFinal."'";
		
	}
	if($idRegistroResolutivo=="")
	{
		
		$query[$x]="INSERT INTO 3013_registroResolutivosAudiencia(tipoResolutivo,valor,idEvento,comentariosAdicionales,fechaReferencia)  
					VALUES(".$obj->resolutivo->idResolutivo.",'".cv($obj->resolutivo->valor)."','".$obj->idEvento."','".
					cv($obj->resolutivo->comentariosAdicionales)."',".$fechaReferencia.")";
		$x++;
		$query[$x]="set @idRegistroResolutivo:=(select last_insert_id())";
		$x++;
	}
	else
	{
		$query[$x]="set @idRegistroResolutivo:=".$idRegistroResolutivo;
		$x++;
		$query[$x]="update 3013_registroResolutivosAudiencia set valor='".cv($obj->resolutivo->valor).
					"',comentariosAdicionales='".cv($obj->resolutivo->comentariosAdicionales).
					"',fechaReferencia=".$fechaReferencia." WHERE idRegistro=".$idRegistroResolutivo;

		$x++;
		$query[$x]="DELETE FROM 3013_opcionesResolutivosAudiencia WHERE idResolutivo=@idRegistroResolutivo";
		$x++;
	}
	
	foreach($obj->resolutivo->opciones as $opt)
	{
		$query[$x]="INSERT INTO 3013_opcionesResolutivosAudiencia(idResolutivo,cveOpcion,comentariosAdicinales)
					VALUES(@idRegistroResolutivo,'".cv($opt->idRegistro)."','".cv($opt->descripcion)."')";
		$x++;
	}
	
	if(isset($obj->arrPenas))
	{
		foreach($obj->arrPenas as $p)
		{
			$query[$x]="UPDATE 7024_registroPenasSentenciaEjecucion SET seAcogeSustitutivo=".($p->seAcoge==""?"NULL":$p->seAcoge).
					",idSustitutivoAcoge=".($p->sustitutivoAcoge==""?"NULL":$p->sustitutivoAcoge).",
					fechaInicio=".($p->fechaInicio==""?"NULL":"'".$p->fechaInicio."'").
				",fechaTermino=".($p->fechaCompurga==""?"NULL":"'".$p->fechaCompurga."'").
				",seAcogeSuspensionCondicional=".($p->seAcogeSuspensionCondicional==""?"NULL":$p->seAcogeSuspensionCondicional).
				",comentariosAdicionales='".cv($p->comentariosAdicionales)."' WHERE idRegistro=".$p->idPena;
			$x++;
		}
	}
	$query[$x]="commit";
	$x++;
	
	
	if($con->ejecutarBloque($query))
	{
		$consulta="select idRegistro from 3014_registroResutadoAudiencia WHERE idEvento=".$obj->idEvento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3014_registroResutadoAudiencia(fechaRegistro,responsable,situacion,idEvento) 
					VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$obj->idEvento.")";
			$con->ejecutarConsulta($consulta);
		}
		echo "1|";
	}
	
	
}


function removerResolutivoAudiencia()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	$idResolutivo=$_POST["iR"];
	
	$consulta="SELECT idRegistro FROM 3013_registroResolutivosAudiencia WHERE idEvento=".$idEvento.
			" AND tipoResolutivo=".$idResolutivo;
	$idRegistroResolutivo=$con->obtenerValor($consulta);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="DELETE FROM 3013_registroResolutivosAudiencia WHERE idRegistro=".$idRegistroResolutivo;
	$x++;
	$query[$x]="DELETE FROM 3013_opcionesResolutivosAudiencia WHERE idResolutivo=".$idRegistroResolutivo;
	$x++;
	$query[$x]="commit";
	$x++;
	
	eB($query);
	
}

function obtenerMensajesEnviados()
{
	global $con;
	$idFormulario=$_POST["idFormulario"];	
	$idRegistro=$_POST["idRegistro"];
	
	$consulta="
				SELECT id__578_tablaDinamica AS idMensaje,fechaCreacion AS fechaEnvio,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=t.idUsuarioEnvio) AS enviadoPor,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=t.idUsuarioDestinatario) AS nombreUsuarioEnvio,
				comentarios,comentarioRespuesta,idEstado AS situacion,
				(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=578 AND idRegistro=t.id__578_tablaDinamica
				AND etapaActual=2  ORDER BY fechaCambio DESC LIMIT 0,1) AS fechaRespuesta 
				FROM _578_tablaDinamica t WHERE idProcesoPadre=".obtenerIdProcesoFormulario($idFormulario).
				" AND idReferencia=".$idRegistro." ORDER BY fechaCreacion DESC ";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';

}

function registrarMensajesEnviados()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($obj->idFormulario,$obj->idRegistro);
	$arrDocumentosReferencia=array();
	$arrValores=array();
	$arrValores["idUsuarioEnvio"]=$_SESSION["idUsr"];
	$arrValores["comentarios"]=$obj->mensaje;
	$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
	$arrValores["idProcesoPadre"]=obtenerIdProcesoFormulario($obj->idFormulario);
	$arrValores["idUsuarioDestinatario"]=$obj->destinatario;
	$arrValores["rolUsuarioDestinatario"]="56_0";
	$arrValores["responsableRespuesta"]=-1;
	
	$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$obj->actorEnvio;
	$rolUsuarioEnvio=$con->obtenerValor($consulta);
	$arrValores["rolUsuarioEnvio"]=$rolUsuarioEnvio;
	

	$consulta="SELECT idDocumento FROM 9074_documentosRegistrosProceso  WHERE idFormulario=".$obj->idFormulario.
			" AND idRegistro=".$obj->idRegistro;
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		array_push($arrDocumentosReferencia,$fila[0]);
	}
	
	$idRegistro=crearInstanciaRegistroFormulario(578,$obj->idRegistro,1,$arrValores,$arrDocumentosReferencia,-1,1023);
	if($idRegistro!=-1)
	{
		
		cambiarEtapaFormulario(578,$idRegistro,2,"",-1,"NULL","NULL",1023);
		echo "1|";
	}
	
}

function registrarRespuestaMensajesEnviados()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="SELECT * FROM _578_tablaDinamica WHERE id__578_tablaDinamica=".$obj->idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="UPDATE _578_tablaDinamica SET responsableRespuesta=".$_SESSION["idUsr"].
				",comentarioRespuesta='".cv($obj->mensaje)."' WHERE id__578_tablaDinamica=".$obj->idRegistro;
	if($con->ejecutarConsulta($consulta)&&(cambiarEtapaFormulario(578,$obj->idRegistro,3,$obj->mensaje,-1,"NULL","NULL",1024)))
	{
		$arrValores=array();
		$nombreTablaBase="9060_tableroControl_4";		
		
		$arrRemitente=SYS_obtenerDatosRemitenteEnvio(578,$obj->idRegistro);
		$idUsuarioDestinatario=$arrRemitente["idUsuario"];
		
		
		$rolDestinatario=$fRegistro["rolUsuarioEnvio"];
		
		
		$arrValores["fechaAsignacion"]=date("Y-m-d H:i:s");
		
		if($con->existeCampo("fechaRegistroSistema",$nombreTablaBase))
			$arrValores["fechaRegistroSistema"]=$arrValores["fechaAsignacion"];
		
		$consulta="SELECT tituloNotificacion FROM 9067_notificacionesProceso WHERE idNotificacion=219";
		$tNotificacion=$con->obtenerValor($consulta);
		
		$arrValores["tipoNotificacion"]=$tNotificacion;
		$arrValores["usuarioRemitente"]=obtenerNombreUsuario($_SESSION["idUsr"])." (".obtenerTituloRol("56_0").")";
		$arrValores["idUsuarioRemitente"]=$_SESSION["idUsr"];

		$nombreUsuario=obtenerNombreUsuario($idUsuarioDestinatario)." (".obtenerTituloRol($rolDestinatario).")";
		$arrValores["usuarioDestinatario"]=str_replace(" (Suplantado)","",$nombreUsuario);
		$arrValores["idUsuarioDestinatario"]=$idUsuarioDestinatario;
		
		$arrValores["idEstado"]="1";
		$arrValores["contenidoMensaje"]="";
		$arrValores["objConfiguracion"]='{"actorAccesoProceso":"'.$rolDestinatario.'","funcionApertura":"mostrarVentanaAperturaProcesoNotificacion"}';
		$arrValores["permiteAbrirProceso"]="1";
		$arrValores["idNotificacion"]=219;
		
		
		$cAdministrativa=$con->obtenerValor($consulta);
		
		$arrValores["numeroCarpetaAdministrativa"]=$fRegistro["carpetaAdministrativa"];
		$arrValores["iFormulario"]=obtenerFormularioBase($fRegistro["idProcesoPadre"]);
		$arrValores["iRegistro"]=$fRegistro["idReferencia"];
		$arrValores["iReferencia"]=-1;
		$consulta="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$idUsuarioDestinatario;
		$codigoUnidad=$con->obtenerValor($consulta);
		
		$arrValores["codigoUnidad"]=$codigoUnidad;
		
		
		
		$consulta="";
		$camposInsert="";
		$camposValues="";
		foreach($arrValores as $campo=>$valor)
		{
			if($camposInsert=="")
				$camposInsert=$campo;
			else
				$camposInsert.=",".$campo;
	
			if($camposValues=="")
				$camposValues=($valor==""?"NULL":"'".cv($valor)."'");
			else
				$camposValues.=",".($valor==""?"NULL":"'".cv($valor)."'");
		}
	
		$consulta="insert into 9060_tableroControl_4(".$camposInsert.") values(".$camposValues.")";
		
		eC($consulta);
	}
}

function obtenerMensajesEnviadosDestinatario()
{
	global $con;

	$idRegistro=$_POST["idRegistro"];
	$idUsuarioDestinatario=$_POST["idUsuario"];
	$consulta="SELECT idProcesoPadre,idReferencia FROM _578_tablaDinamica WHERE id__578_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	$consulta="
				SELECT id__578_tablaDinamica AS idMensaje,fechaCreacion AS fechaEnvio,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=t.idUsuarioEnvio) AS enviadoPor,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=t.idUsuarioDestinatario) AS nombreUsuarioEnvio,
				comentarios,comentarioRespuesta,idEstado AS situacion,
				(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=578 AND idRegistro=t.id__578_tablaDinamica
				AND etapaActual=2 ORDER BY fechaCambio DESC  LIMIT 0,1) AS fechaRespuesta 
				FROM _578_tablaDinamica t WHERE idProcesoPadre=".$fRegistro[0].
				" AND idReferencia=".$fRegistro[1]." and idUsuarioDestinatario=".$idUsuarioDestinatario." ORDER BY fechaCreacion DESC ";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';

}


function buscarAntecedenteSalaPenal()
{
	global $con;
	$valor=$_POST["valor"];
	$numRegistros=0;
	$arrRegistros="";
	$consulta="SELECT * FROM _451_tablaDinamica WHERE carpetaAdministrativa LIKE '%".$valor."%' and idEstado>=2";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$carpetaAdministrativa=$fila["carpetaAdministrativa"];
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila["carpetaApelacion"]."'";
		$fRegistroApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila["noToca"]."'";
		$fRegistroToca=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fRegistro["idActividad"]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$victimas=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fRegistro["idActividad"]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$imputados=$con->obtenerValor($consulta);
		
		$o='{"iRegistro":"'.$fila["id__451_tablaDinamica"].'","iFormulario":"451","carpetaInvestigacion":"'.$fRegistro["carpetaInvestigacion"].'",
			"fechaRecepcion":"'.$fRegistroToca["fechaCreacion"].'","carpetaJudicial":"'.$fila["carpetaAdministrativa"].'","carpetaApelacion":"'.
			$fila["carpetaApelacion"].'","unidadGestion":"'.$fRegistro["unidadGestion"].'","imputado":"'.cv($imputados).'","victima":"'.cv($victimas).'",
			"salaPenal":"'.$fRegistroToca["unidadGestion"].'","noToca":"'.$fila["noToca"].'","resolucionImpugnada":"'.cv($fila["nombreResolucion"]).'"}';
	
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	
		$numRegistros++;
	}
	
	
	echo '{"numReg":"'.$numRegistros.'","registros":['.$arrRegistros.']}';
}


function buscarAntecedenteSalaPenalInicioProceso()
{
	global $con;
	$cJudicial=$_POST["cJudicial"];
	$numRegistros=0;
	$arrRegistros="";
	$consulta="SELECT * FROM _451_tablaDinamica WHERE carpetaAdministrativa = '".$cJudicial."' and idEstado>=2";
	$filaAntecedente=$con->obtenerPrimeraFilaAsoc($consulta);
	if($filaAntecedente)
	{
		echo "1|1|".$filaAntecedente["salaPenal"]."|".$filaAntecedente["noToca"];
		return;
	}
	echo "1|0|";
}


function obtenerRegistroProgramacionAudienciaCarpetaPenalTradicional()
{
	global $con;
	global $servidorPruebas;
	global $tipoMateria;
	$iE=$_POST["iE"];
	$cA=$_POST["cA"];
	$idCarpeta=$_POST["idCarpeta"];
	$iR=-1;
	$a="";
	$act="";
	
	$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
	if($idCarpeta!=-1)
	{
		$consulta.=" and idCarpeta=".$idCarpeta;
	}
	
	$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	$tCarpeta=$fDatosCarpeta[0];
	
	$consulta="SELECT cJ.usuarioJuez FROM _17_tablaDinamica j,_26_tablaDinamica cJ WHERE cJ.idReferencia=j.id__17_tablaDinamica AND j.claveUnidad='".$fDatosCarpeta[1]."'";
	$juezAsignar=$con->obtenerValor($consulta);
	if($juezAsignar=="")
		$juezAsignar=-1;
	
	$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE idEventoReferencia='".$iE."' and carpetaAdministrativa='".$cA.
			"' and idEstado=1";
			
	if($idCarpeta!=-1)
	{
		$consulta.=" and idCarpetaAdministrativa=".$idCarpeta;
	}		
	$consulta.=" order by id__185_tablaDinamica desc";	
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$tAudiencia=3015;
		$consulta="SELECT promedioDuracion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tAudiencia;
		$duracionAudiencia=$con->obtenerValor($consulta);
		$consulta="INSERT INTO _185_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion,codigoUnidad,carpetaAdministrativa,tipoAudiencia,
				idCarpetaAdministrativa,iFormulario,iRegistro,fechaEstimadaAudiencia,parametrosFechaMinima,mesesAudiencia,diasAudiencia,fechaBaseAudiencia,duracionRequerida,
				oDatosSolicitud,idEventoReferencia,juezAsignar) VALUES(-1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$fDatosCarpeta[1]."','".$fDatosCarpeta[1]."','".$cA."',".$tAudiencia.
				",".$idCarpeta.",-1,-1,'".date("Y-m-d")."',1,0,0,'".date("Y-m-d")."','".$duracionAudiencia."','N/E',-1,".$juezAsignar.")";
		if($con->ejecutarConsulta($consulta))
		{
			$idRegistroAudiencia=$con->obtenerUltimoID();
			
			//cambiarEtapaFormulario(185,$idRegistroAudiencia,3,"",-1,"NULL","NULL",648);
			
			$consulta="SELECT id__185_tablaDinamica,idEstado FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$idRegistroAudiencia;
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			
			
			
		}
		
		
		
	}



	
	$iR=$fRegistro[0];
	$a=bE("auto");
	$idProceso=obtenerIdProcesoFormulario(185);
	if($tipoMateria=="P")
	{
		$rol='69_0';//SUbdirector de Causa y Sala
		if($tCarpeta==6)
		{
			$rol='81_0';//SUbdirector de salas
		}
		
	}
	else
	{
		
		$rol='69_0';  //SUbdirector de Causa y Sala
		
	}
	
	$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro[1]);
	$act=bE($actor);
	
	echo "1|".$iR."|".$a."|".$act;
	
}

function obtenerRecursosAudiencia()
{
	global $con;
	$tR=$_POST["tR"];
	$consulta="SELECT id__628_tablaDinamica,nombreRecurso FROM _628_tablaDinamica WHERE tipoRecurso=".$tR." AND idEstado=1 ORDER BY tipoRecurso";
	$arrTipoRecurso=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrTipoRecurso;
}


function obtenerEventosRecursosAdicionalesAudiencia()
{
	global $con;
	global $tipoMateria;
	$tipoRecurso=$_POST["tipoRecurso"];
	$idRecurso=$_POST["idRecurso"];
	$fechaBase=$_POST["fechaBase"];
	$idRegistroRecurso=$_POST["idRegistroRecurso"];	
	$idEvento=$_POST["idEvento"];
	$idUnidadGestion=$_POST["idUnidadGestion"];
	$fechaLimiteAtencion="";
	$arrEventos="";
	
	
	$start=$_POST["start"];
	$end=$_POST["end"];
	$arrFilasEventos=array();
	
	
	
	$consulta="select if(r.horaInicioReal is null,r.horaInicio,r.horaInicioReal),if(r.horaFinReal is null,r.horaFin,r.horaFinReal),
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia),
				idCentroGestion,fechaEvento,e.idRegistroEvento,idSala,fechaLimiteAtencion,r.idRegistro from 
				7001_recursosAdicionalesAudiencia r,7000_eventosAudiencia e 
				where r.tipoRecurso=".$tipoRecurso." and r.idRecurso=".$idRecurso." and e.idRegistroEvento=r.idRegistroEvento and 
				r.idRegistro<>".$idRegistroRecurso." and r.situacionRecurso IN
				(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{
		array_push($arrFilasEventos,$fila);
	}
	
	

	foreach($arrFilasEventos as $fila)
	{
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[5];
		$cAdministrativa=$con->obtenerValor($consulta);
		
		
		$e='{"id":"e_'.$fila[8].'","editable":false,"title":"'.cv($fila[2]).' ['.$cAdministrativa." - ".$fila[5].']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
	
	
	if($idUnidadGestion==-1)
	{
		if($idEvento!=-1)
		{
			$consulta="SELECT idCentroGestion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
			$idUnidadGestion=$con->obtenerValor($consulta);
			if($idUnidadGestion=="")
				$idUnidadGestion=-1;
		}
		
	}
	
	
	$consulta="SELECT idPadre FROM _25_chkUnidadesAplica WHERE idOpcion=".$idUnidadGestion;	

	$listaIncidencias=$con->obtenerListaValores($consulta);
	if($listaIncidencias=="")
		$listaIncidencias=-1;
	
	$consulta="SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
				AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=-".$idRecurso." and idEstado=2 and aplicaTodasUnidades=1
				union
				SELECT fechaInicial,horaInicial,fechaFinal,horaFinal,id__25_tablaDinamica,t.tipoPeriodo FROM _25_tablaDinamica t,_25_Salas s WHERE s.idReferencia=t.id__25_tablaDinamica
				AND t.fechaInicial<='".$start."' AND t.fechaFinal>='".$start."' AND s.nombreSala=-".$idRecurso." and idEstado=2 and aplicaTodasUnidades=0 and id__25_tablaDinamica in(".
				$listaIncidencias.")";

	$iSala=$con->obtenerFilas($consulta);
	while($fIncidencia=$con->fetchRow($iSala))
	{
		
		$horaInicial="00:00:00";
		$horaFinal="23:59:59";
		if($fIncidencia[1]=="")
			$fIncidencia[1]=$horaInicial;
		
		if($fIncidencia[3]=="")
			$fIncidencia[3]=$horaFinal;
			
		
		
		if($fIncidencia[5]==2)
		{
			
			if($fIncidencia[0]==$start)
			{
				$horaInicial=$fIncidencia[1];
			}
			
			
			if($fIncidencia[2]==$start)
			{
				$horaFinal=$fIncidencia[3];
			}
			
		}
		else
		{
			$horaInicial=$fIncidencia[1];
			$horaFinal=$fIncidencia[3];
		}
		$e='{"id":"iS_'.$fIncidencia[4].'","editable":false,"title":"El recurso ha sido marcado como No disponible","start":"'.
			($start."T".str_pad($horaInicial,5,"0",STR_PAD_LEFT)).'","end":"'.($start."T".str_pad($horaFinal,5,"0",STR_PAD_LEFT)).'","color":"#B55381"}';	
		if($arrEventos=="")
			$arrEventos=$e;
		else
			$arrEventos.=",".$e;
	}
	
	
	echo '['.$arrEventos.']';
	
}


function obtenerRecursosAdicionalesAudiencia()
{
	global $con;
	$idEventoAudiencia=$_POST["idEventoAudiencia"];
	
	$consulta="SELECT idRegistro,tipoRecurso,idRecurso,comentariosAdicionales,IF(horaInicioReal IS NULL,horaInicio,horaInicioReal) AS horaInicio,
			IF(horaFinReal IS NULL,horaFin,horaFinReal) AS horaTermino FROM 7001_recursosAdicionalesAudiencia r WHERE idRegistroEvento=".$idEventoAudiencia." and 
			situacionRecurso in(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";
	
	$registros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
}

function obtenerAudienciasCabinas()
{
	global $con;
	$fechaInicial=$_POST["fInicio"];
	$fechaFinal=$_POST["fFin"];
	
	$arrRegistros="";
	$numReg=0;
	$unidadGestion=$_POST["unidadGestion"];
	
	$consulta="SELECT r.idRegistro,r.idRecurso,r.horaInicio,
			(SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa con WHERE
			con.tipoContenido=3 AND con.idRegistroContenidoReferencia=r.idRegistroEvento) AS carpetaAdministrativa,
			(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia)AS tipoAudiencia,
			(SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=r.idRecurso) as lblRecurso from
			7001_recursosAdicionalesAudiencia r,_628_tablaDinamica c,7000_eventosAudiencia e WHERE r.horaInicio>='".$fechaInicial.
			" 00:00:00' AND r.horaInicio<='".$fechaFinal." 23:59:59' AND situacionRecurso 
			IN(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) AND r.tipoRecurso=1
			AND c.id__628_tablaDinamica=r.idRecurso AND e.idRegistroEvento=r.idRegistroEvento ";
	
	if($unidadGestion!=0)
	{
		$consulta.=" AND c.adscripcionRecurso='".$unidadGestion."'";
	}
	$consulta.=" order by idRecurso,horaInicio";

	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"]."'";
		$fInfoCarpeta=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
				IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 
				7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fInfoCarpeta[0]." and idFiguraJuridica =4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$imputado=$con->obtenerListaValores($consulta);
		$imputado=str_replace(",","<br />",$imputado);
		
		
		$o='{"idRegistro":"'.$fila["idRegistro"].'","idRecurso":"'.$fila["idRecurso"].'","horaInicio":"'.$fila["horaInicio"].
				'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","carpetaInvestigacion":"'.cv($fInfoCarpeta[1]).
				'","imputado":"'.cv($imputado).'","tipoAudiencia":"'.cv($fila["tipoAudiencia"]).'","lblRecurso":"'.cv($fila["lblRecurso"]).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';

}

function enviarEventoCabina()
{
	global $con;
	
	$iE=$_POST["iE"];
	notificarEventoAudienciaSIAJOPCabina($iE);
	echo "1|";
}


function removerRecursoAdicional()
{
	global $con;
	$idEvento=$_POST["iE"];
	$idRegistro=$_POST["iR"];
	$motivo=$_POST["mC"];
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="update 7001_recursosAdicionalesAudiencia set situacionRecurso=3 where idRegistro=".$idRegistro;
	$x++;	
	$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,situacionAnterior)
					VALUES(".$idRegistro.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($motivo)."',1)";
	$x++;
	$query[$x]="commit";
	$x++;	
	if($con->ejecutarBloque($query))
	{
		notificarEventoAudienciaSIAJOPCabina($idEvento);
		echo "1|";
	}
}


function registrarRecursoAdicional()
{
	global $con;
	$query=array();
	$x=0;
	$cadObj=$_POST["cadObj"];
	$r=json_decode($cadObj);

	
	if(!existeDisponibilidadRecurso($r->idRegistroEvento,date("Y-m-d",strtotime($r->horaInicio)),$r->tipoRecurso,$r->idRecurso,$r->horaInicio,$r->horaTermino,$r->idRegistroRecurso))
	{
		$consulta="SELECT tipoRecurso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$r->tipoRecurso;
		$tipoRecurso=$con->obtenerValor($consulta);
		$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$r->idRecurso;
		$nombreRecurso=$con->obtenerValor($consulta);
		echo '0|<br>NO existe disponibilidad del Recurso: ('.$tipoRecurso.') '.$nombreRecurso.'<br>';
		return;
	}
	if($r->idRegistroRecurso==-1)
	{
		$query[$x]="INSERT INTO 7001_recursosAdicionalesAudiencia(idRegistroEvento,tipoRecurso,idRecurso,horaInicio,horaFin,situacionRecurso,comentariosAdicionales)
					 VALUES(".$r->idRegistroEvento.",".$r->tipoRecurso.",".$r->idRecurso.",'".$r->horaInicio."','".$r->horaTermino."',1,'".cv($r->comentariosAdicionales)."')";
		$x++;	
		$query[$x]="set @idRecursoRegistro:=(select last_insert_id())";
		$x++;
		$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,situacionAnterior)
					VALUES(@idRecursoRegistro,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'',0)";
		$x++;
	}
	else
	{
		$existeCambio=false;
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistro=".$r->idRegistroRecurso;
		$fRecurso=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRecurso["idRecurso"]!=$r->idRecurso)
		{
			$existeCambio=true;
		}
		
		if(($fRecurso["horaInicio"]!=$r->horaInicio)||($fRecurso["horaFin"]!=$r->horaTermino))
		{
			$existeCambio=true;
		}
		
		if($fRecurso["comentariosAdicionales"]!=$r->comentariosAdicionales)
		{
			$existeCambio=true;
		}
		
		if($existeCambio)
		{
			$query[$x]="update 7001_recursosAdicionalesAudiencia set idRecurso=".$r->idRecurso.",horaInicio='".$r->horaInicio."',horaFin='".$r->horaTermino.
					"',comentariosAdicionales='".cv($r->comentariosAdicionales)."' where idRegistro=".$r->idRegistroRecurso;
			$x++;
			$query[$x]="INSERT INTO 7001_bitacoraCambiosRecursosAdicionales(idRegistroRecurso,fechaCambio,idUsuarioResponsable,comentariosAdicionales,
						situacionAnterior,idRecursoAnterior,horaInicioAnterior,horaFinAnterior,comentariosAdicionalesAnterior)
						VALUES(".$r->idRegistroRecurso.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($r->motivoCambio)."',".$fRecurso["situacionRecurso"].
						",".$fRecurso["idRecurso"].",'".$fRecurso["horaInicio"]."','".$fRecurso["horaFin"]."','".cv($fRecurso["comentariosAdicionales"])."')";
			$x++;	
		}
	}
		 
	$query[$x]="commit";
	$x++;	
	if($con->ejecutarBloque($query))
	{
		notificarEventoAudienciaSIAJOPCabina($r->idRegistroEvento);
		echo "1|";
	}
}

function enviarNotificacionEventoMailPenal()
{
	global $con;
	
	$iE=$_POST["iE"];
	
	$consulta="SELECT situacion FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$iE;
	$situacionActual=$con->obtenerValor($consulta);
	switch($situacionActual)
	{
		case 1:
			enviarNotificacionMailConfirmacion($iE);
		break;
		case 3:
			enviarNotificacionMailCancelacion($iE);
		break;
	}
	echo "1|";
}


function obtenerPartesProcesalesAutorizacionVideoGrabacion()
{
	global $con;
	$idCarpeta=$_POST["idCarpeta"];
	$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$idActividad=$con->obtenerValor($consulta);
	$consulta="SELECT id__47_tablaDinamica AS idUsuario,idRelacion,
			CONCAT(IF(nombre IS NULL,' ',nombre),' ',IF(apellidoPaterno IS NULL,' ',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,' ',apellidoMaterno)) AS nombre,
			idFiguraJuridica AS figuraJuridica,r.situacion,r.idCuentaAcceso
			 FROM 
			7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad.
			" AND p.id__47_tablaDinamica=r.idParticipante";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT * FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
				"' AND idParticipante=".$fila["idUsuario"]." AND tipoValor=1";
				
		$fIdentificacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($fIdentificacion["idDocumento"]==""?-1:$fIdentificacion["idDocumento"]);	
		$nombreDoc=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT * FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
				"' AND idParticipante=".$fila["idUsuario"]." AND tipoValor=2";
				
		$fAutorizacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($fAutorizacion["idDocumento"]==""?-1:$fAutorizacion["idDocumento"]);	
		$nombreAutorizacion=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 7006_participantesNoAplicaAudienciaVirtual WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND idParticipante=".$fila["idUsuario"];
		$fNoAplica=$con->obtenerPrimeraFilaAsoc($consulta);
		
			
		$o='{"idParticipante":"'.$fila["idUsuario"].'","nombreParticipante":"'.cv($fila["nombre"]).'","figuraJuridica":"'.$fila["figuraJuridica"].
			'","tipoIdentificacion":"'.$fIdentificacion["tipoIdentificacion"].'","nombreDocumentoIdentificacion":"'.cv($nombreDoc).
			'","identificacion":"'.$fIdentificacion["idDocumento"].'","nombreDocumentoAutorizacion":"'.cv($nombreAutorizacion).
			'","documentoAutorizacion":"'.$fAutorizacion["idDocumento"].'","situacionActual":"'.$fila["situacion"].'","cuentaGenerada":"'.
			$fila["idCuentaAcceso"].'","noAplica":'.(!$fNoAplica?"false":"true").',"motivoNoAplica":"'.(!$fNoAplica?"":cv($fNoAplica["motivoNoAplica"])).'"}';
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}


function removerDocumentoAutorizacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="DELETE FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$obj->carpetaAdministrativa."'
			AND idParticipante=".$obj->idParticipante." AND tipoValor=".$obj->tipo." AND idDocumento=".$obj->idDocumento;
	eC($consulta);
}

function actualizarNoAplicaVideograbacion()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$consulta="SELECT idRegistro FROM 7006_participantesNoAplicaAudienciaVirtual WHERE carpetaAdministrativa='".$obj->carpetaAdministrativa.
					"' AND idParticipante=".$obj->idParticipante;
	$idRegistro=$con->obtenerValor($consulta);

	if(($obj->campo=='noAplica')&&($obj->valor==0))
	{
		$consulta="DELETE FROM 7006_participantesNoAplicaAudienciaVirtual WHERE idRegistro=".($idRegistro==""?-1:$idRegistro);
	}
	else
	{
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 7006_participantesNoAplicaAudienciaVirtual(carpetaAdministrativa,idParticipante) VALUES('".
						$obj->carpetaAdministrativa."',".$obj->idParticipante.")";
	
		}
		else
		{
			$consulta="UPDATE 7006_participantesNoAplicaAudienciaVirtual SET motivoNoAplica='".cv($obj->valor)."' where idRegistro=".$idRegistro;	

		}
	}
	eC($consulta);
	
}

function activarAudienciasVirtuales()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$consulta="UPDATE 7006_carpetasAdministrativas SET permiteAudienciaVirtual=".$obj->valor." WHERE carpetaAdministrativa='".$obj->carpetaAdministrativa."'";
	eC($consulta);
}

function obtenerParticipantesAudienciaVirtual()
{
	global $con;
	$idEvento=$_POST["idEvento"];
	
	$carpetaAdministrativa="";
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$idEvento;
	$fDatos=$con->obtenerPrimeraFila($consulta);
	if($fDatos)
	{
		$carpetaAdministrativa=$fDatos[0];
		$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
		$idActividad=$fCarpetaInvestigacion[0];
		if($idActividad=="")
		{
			$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
		}

		
	}
	
	$arrRegistros="";
	$numReg=0;
	$consulta="SELECT id__47_tablaDinamica AS idUsuario,idRelacion,
			upper(CONCAT(IF(nombre IS NULL,' ',nombre),' ',IF(apellidoPaterno IS NULL,' ',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,' ',apellidoMaterno))) AS nombre,
			idFiguraJuridica AS figuraJuridica,r.situacion,r.idCuentaAcceso
			 FROM 
			7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad.
			" AND p.id__47_tablaDinamica=r.idParticipante";

	$resParticipante=$con->obtenerFilas($consulta);
	while($filaParticipante=$con->fetchAssoc($resParticipante))
	{
		$consulta="SELECT * FROM 7006_participantesNoAplicaAudienciaVirtual WHERE carpetaAdministrativa='".$carpetaAdministrativa.
					"' AND idParticipante=".$filaParticipante["idUsuario"];

		$fNoAplica=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if((!$fNoAplica)&&($filaParticipante["situacion"]==1))
		{
			$numReg++;
			$consulta="SELECT * FROM 7006_usuariosVSAudienciasCodigoGenerado WHERE idUsuario=".$filaParticipante["idUsuario"].
						" AND carpetaAdministrativa='".$carpetaAdministrativa."' AND idEvento=".$idEvento;

			$fDatosCodigo=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT * FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa.
				"' AND idParticipante=".$filaParticipante["idUsuario"]." AND tipoValor=1";
				
			$fIdentificacion=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($fIdentificacion["idDocumento"]==""?-1:$fIdentificacion["idDocumento"]);	
			$nombreAutorizacion=$con->obtenerValor($consulta);
			
			$o='{"idParticipante":"'.$filaParticipante["idUsuario"].'","nombreParticipante":"'.cv($filaParticipante["nombre"]).
				'","figuraJuridica":"'.$filaParticipante["figuraJuridica"].'","codigoAcceso":"'.$fDatosCodigo["codigoGenerado"].
				'","fechaCreacionCodigo":"'.$fDatosCodigo["fechaGeneracion"].'","identificacion":"'.$fIdentificacion["idDocumento"].'","nombreIdentificacion":"'.
				cv($nombreAutorizacion).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function actualizarCamposAudienciaVirtual()
{
	global $con;
	
	$campo=$_POST["campo"];
	$valor=$_POST["valor"];
	$idEvento=$_POST["idEvento"];
	$consulta="";
	switch($campo)
	{
		case "urlAudiencia":
			$consulta="SELECT idRegistro FROM 7000_eventosAudienciaComplemetaria WHERE idRegistroEvento=".$idEvento;
			$idRegistro=$con->obtenerValor($consulta);
			if($idRegistro=="")
			{
				$consulta="INSERT INTO 7000_eventosAudienciaComplemetaria(idRegistroEvento,urlAudiencia) VALUES(".$idEvento.",'".$valor."')";
			}
			else
			{
				$consulta="UPDATE 7000_eventosAudienciaComplemetaria SET urlAudiencia='".$valor."' WHERE idRegistroEvento=".$idRegistro;	
			}
		break;
		case "urlMultimedia":
			$consulta="UPDATE 7000_eventosAudiencia SET urlMultimedia='".$valor."' WHERE idRegistroEvento=".$idEvento;
		break;
	}
	
	eC($consulta);
}

function cambiarSituacionProgramacionAudienciaVirtualCarpeta()
{
	global $con;
	$motivo=$_POST["motivo"];
	$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	$situacion=$_POST["situacion"];
	$consulta="SELECT situacionActual FROM 7006_bitacoraCambiosCarpetasAdministrativasAudienciaVirtual WHERE carpetaAdministrativa='".
				$carpetaAdministrativa."' ORDER BY fechaCambio DESC";
	$situacionAnterior=$con->obtenerValor($consulta);
	if($situacionAnterior=="")
		$situacionAnterior=0;
	$consulta="UPDATE 7006_carpetasAdministrativas SET permiteAudienciaVirtual=".$situacion." WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	if($con->ejecutarConsulta($consulta))
	{
		$consulta="INSERT INTO 7006_bitacoraCambiosCarpetasAdministrativasAudienciaVirtual(carpetaAdministrativa,situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales)
					VALUES('".$carpetaAdministrativa."',".$situacionAnterior.",".$situacion.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($motivo)."')";
		eC($consulta);
	}
}

function obtenerHistorialProgramacionAudienciaVirtual()
{
	global $con;
	$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	
	$numReg=0;
	$arrRegistros="";
	$consulta="SELECT * FROM 7006_bitacoraCambiosCarpetasAdministrativasAudienciaVirtual WHERE carpetaAdministrativa='".$carpetaAdministrativa.
			"' ORDER BY fechaCambio DESC";

	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaOperacion":"'.$fila["fechaCambio"].'","situacionOriginal":"'.($fila["situacionAnterior"]==1?"Permite programaci&oacute;n de audiencias virtuales":"NO Permite programaci&oacute;n de audiencias virtuales").
			'","situacionCambio":"'.($fila["situacionActual"]==1?"Permite programaci&oacute;n de audiencias virtuales":"NO Permite programaci&oacute;n de audiencias virtuales").'","responsable":"'.obtenerNombreUsuario($fila["responsableCambio"]).'","comentarios":"'.
			cv($fila["comentariosAdicionales"]).'"}';
		if($arrRegistros=="")
		{
			$arrRegistros=$o;
		}
		else
		{
			$arrRegistros.=",".$o;
		}
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
														
														
													
}


function asociarCuentaAccesoCarpeta()
{
	global $con;
	global $tipoMateria;
	$idUsuario=$_POST["idUsuario"];
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$query="SELECT nombre,apellidoPaterno,apellidoMaterno,tipoDefensor FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$obj->idParticipante;
	$fParticipante=$con->obtenerPrimeraFila($query);
	
	$query="SELECT unidadGestion,fechaCreacion,carpetaAdministrativa,idCarpeta,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->carpeta."'";
	
	if($obj->idCarpeta!=-1)
		$query." and idCarpeta=".$obj->idCarpeta;
	$fCarpeta=$con->obtenerPrimeraFila($query);
	
	$query="SELECT g.tipoDelito FROM _17_tablaDinamica u,_17_gridDelitosAtiende g WHERE claveUnidad='".$fCarpeta[0]."'
			AND g.idReferencia=u.id__17_tablaDinamica";
	$tDelitos=$con->obtenerListaValores($query);
	$anioExpediente="";
	if($tipoMateria=="P")
	{

		$anioExpediente=date("Y",strtotime($fCarpeta[1]));
		$tDelitos="PO";
	}
	else
	{
		$arrExpediente=explode("/".$fCarpeta[2]);
		$anioExpediente[1];
	}
	
	
	$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$obj->idFiguraJuridica;
	$lblFiguraExpediente=$con->obtenerValor($consulta);
	
	$idActividad=$fCarpeta[4];
	$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
								IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
								WHERE r.idActividad=".$idActividad." and idFiguraJuridica =2 AND r.idParticipante=p.id__47_tablaDinamica order 
								by nombre,apellidoPaterno,apellidoMaterno";
	$victimas=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
				IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." and idFiguraJuridica =4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
	$imputados=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT d.denominacionDelito FROM _61_tablaDinamica sd,_35_denominacionDelito d WHERE 
				idActividad=".$idActividad." AND d.id__35_denominacionDelito=sd.denominacionDelito";
	$delito=$con->obtenerListaValores($consulta);
	
	$detalleExpediente='{"imputado":"'.cv($imputados).'","victima":"'.cv($victimas).'","delito":"'.cv($delito).'"}';
	$lblDetalleFigura="";
	if($fParticipante[3]!="")
	{
		$consulta="SELECT etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$obj->idFiguraJuridica." AND idDetalle=".$fParticipante[3];
		$lblDetalleFigura=$con->obtenerValor($consulta);
	}
	
	
	$cadObjWS='{"idUsuario":"'.$idUsuario.'","unidadGestion":"'.$fCarpeta[0].'","cveMateria":"'.$tDelitos.'","idCarpeta":"'.$fCarpeta[3].'","carpeta":"'.$obj->carpeta.
			'","anioExpediente":"'.$anioExpediente.'","idParticipante":"'.$obj->idParticipante.'","idFiguraJuridica":"'.$obj->idFiguraJuridica.
			'","lblFiguraExpediente":"'.$lblFiguraExpediente.'","detalleExpediente":"'.bE($detalleExpediente).
			'","idDetalleFigura":"'.$fParticipante[3].'","lblDetalleFigura":"'.$lblDetalleFigura.'","roles":"158"}';
	
	
	$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
	
	$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
	
	$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
	
	$parametros=array();
	$parametros["cadObj"]=$cadObjWS;
	
	$response = $client->call("asociarCuentaAccesoCarpeta", $parametros);


	$oJuzgado=json_decode(utf8_encode($response));
	
	
	switch($oJuzgado->resultado)
	{
		case 1:
			$consulta="update 7005_relacionFigurasJuridicasSolicitud set idCuentaAcceso=".$idUsuario." WHERE idActividad=".$idActividad.
						" AND idParticipante=".$obj->idParticipante;
			if($con->ejecutarConsulta($consulta))
				echo "1|1";
		break;
		
	}
	
}

function obtenerParticipantesConfAudienciaVirtual()
{
	global $con;
	$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	$idEvento=$_POST["idEvento"];
	
	
	$consulta="SELECT idActividad,carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
	$idActividad=$fCarpetaInvestigacion[0];
	
	$consulta="SELECT idReunionVirtual FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$idReunionVirtual=$con->obtenerValor($consulta);
	
	$arrRegistros="";
	$numReg=0;
	
	$totalParticipantes=0;
	$consulta="SELECT id__47_tablaDinamica AS idUsuario,idRelacion,
			upper(CONCAT(IF(nombre IS NULL,' ',nombre),' ',IF(apellidoPaterno IS NULL,' ',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,' ',apellidoMaterno))) AS nombre,
			idFiguraJuridica AS figuraJuridica,r.situacion,r.idCuentaAcceso
			 FROM 
			7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad.
			" AND p.id__47_tablaDinamica=r.idParticipante";

	$resParticipante=$con->obtenerFilas($consulta);
	while($filaParticipante=$con->fetchAssoc($resParticipante))
	{
		$consulta="SELECT * FROM 7006_participantesNoAplicaAudienciaVirtual WHERE carpetaAdministrativa='".$carpetaAdministrativa.
					"' AND idParticipante=".$filaParticipante["idUsuario"];

		$fNoAplica=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if((!$fNoAplica)&&($filaParticipante["situacion"]==1))
		{
			$perfilParticipante="1";
			$idParticipanteReunion=-1;
			$tieneMail=0;
			if($idEvento!=-1)
			{

				
				
				if($idReunionVirtual!=0)
				{
					$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".
								$idReunionVirtual." AND idAuxiliar=".$filaParticipante["idUsuario"];

					$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
					$idParticipanteReunion=$fParticipante["idRegistro"];
					$perfilParticipante=$fParticipante["perfilParticipacion"];
					$tieneMail=$fParticipante["eMail"]!=""?1:0;
					if($perfilParticipante=="")
						$perfilParticipante=1;	
				}
				
			}
			
			
			$o='{"idParticipante":"'.$filaParticipante["idUsuario"].'","perfilParticipante":"'.$perfilParticipante.'","nombreParticipante":"'.$filaParticipante["nombre"].
				'","idParticipanteReunion":"'.$idParticipanteReunion.'","tieneMail":"'.$tieneMail.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
	}
	
	$idParticipanteReunion=-1;
	$perfilParticipante=1;
	$tieneMail=0;
	if($idReunionVirtual!=0)
	{
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".
					$idReunionVirtual." AND idAuxiliar=-10";
		$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
		$idParticipanteReunion=$fParticipante["idRegistro"];
		$perfilParticipante=$fParticipante["perfilParticipacion"];
		$tieneMail=$fParticipante["eMail"]!=""?1:0;
		if($perfilParticipante=="")
			$perfilParticipante=1;	
	}
	
	$o='{"idParticipante":"-10","perfilParticipante":"'.$perfilParticipante.'","nombreParticipante":"Juez","idParticipanteReunion":"'.
		$idParticipanteReunion.'","tieneMail":"'.$tieneMail.'"}';
	if($arrRegistros=="")
		$arrRegistros=$o;
	else
		$arrRegistros.=",".$o;
	
	$idParticipanteReunion=-1;
	$perfilParticipante=1;
	$tieneMail=0;
	if($idReunionVirtual!=0)
	{
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".
					$idReunionVirtual." AND idAuxiliar=-20";
		$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
		$idParticipanteReunion=$fParticipante["idRegistro"];
		$perfilParticipante=$fParticipante["perfilParticipacion"];
		$tieneMail=$fParticipante["eMail"]!=""?1:0;
		if($perfilParticipante=="")
			$perfilParticipante=1;	
	}
		
		
		
		
	$o='{"idParticipante":"-20","perfilParticipante":"'.$perfilParticipante.'","nombreParticipante":"Auxiliar de Sala","idParticipanteReunion":"'.
		$idParticipanteReunion.'","tieneMail":"'.$tieneMail.'"}';
	if($arrRegistros=="")
		$arrRegistros=$o;
	else
		$arrRegistros.=",".$o;
	
	$numReg++;
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}


function obtenerSolicitudesMedidasProteccionUGAS()
{
	global $con;
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$unidadGestion=$_POST["unidadGestion"];

	$situacionSolicitud=$_POST["situacionSolicitud"];
	$numReg=0;
	$arrRegistros="";
	
	
	$compInicial="";
	if($situacionSolicitud==1)	
		$compInicial=" and s.idEstado in(6)";
	else
		if($situacionSolicitud==2)
			$compInicial=" and s.idEstado not in(6)";

	$consulta="";
	if($unidadGestion==0)
	{
		$consulta=" SELECT '622' AS iFormulario,id__622_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion,s.respNotificada,s.adscripcionRegistrante
					FROM _622_tablaDinamica s,_4_tablaDinamica a WHERE s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=252 and s.idEstado>=1.4 ".$compInicial."	
					ORDER BY s.fechaCreacion DESC";
		
		
	}
	else
	{
		
		$consulta=" SELECT '622' AS iFormulario,id__622_tablaDinamica AS iRegistro,carpetaAdministrativa,s.fechaCreacion AS fechaRegistro,
					a.tipoAudiencia AS  tipoSolicitud,s.idEstado AS etapaActual,a.id__4_tablaDinamica as tAudiencia,
					ADDTIME(s.fechaCreacion,concat(a.horasMaximaAgendaAudiencia,':00:00')) as fechaFenecimiento,
					a.horasMaximaAgendaAudiencia,s.codigo,'' as asuntoPromocion,s.respNotificada,s.adscripcionRegistrante
					FROM _622_tablaDinamica s,_4_tablaDinamica a, 7006_carpetasAdministrativas c WHERE 
					s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin." 23:59:59' 
					AND a.id__4_tablaDinamica=252 and s.idEstado>=1.4 ".$compInicial."  and c.carpetaAdministrativa=s.carpetaAdministrativa 
					and c.unidadGestion='".$unidadGestion."'		
					
					
					ORDER BY s.fechaCreacion DESC";
		

	}
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		
		$consulta="SELECT unidadGestion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"]."'";
		$fCarpeta=$con->obtenerPrimeraFila($consulta);
		$unidadGestion=$fCarpeta[0];
		$idActividad=$fCarpeta[1];
		$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE numeroCarpetaAdministrativa='".$fila["carpetaAdministrativa"].
				"' AND iFormulario=".$fila["iFormulario"]." AND iRegistro=".$fila["iRegistro"]." 
				and idUsuarioDestinatario<>1";
		$totalTareasEmitidas=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 9060_tableroControl_4 WHERE numeroCarpetaAdministrativa='".$fila["carpetaAdministrativa"].
				"' AND iFormulario=".$fila["iFormulario"]." AND iRegistro=".$fila["iRegistro"]." 
				and fechaVisualizacion is not null and idUsuarioDestinatario<>1";
		$totalTareasVisualizada=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con
					WHERE con.carpetaAdministrativa='".$fila["carpetaAdministrativa"]."' AND con.tipoContenido=3 AND 
					con.idRegistroContenidoReferencia=e.idRegistroEvento AND e.situacion IN (1,2,4,5)";
		$totalAudienciasGeneradas=	$con->obtenerValor($consulta);		
		
		
		$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$fila["iFormulario"].
				" AND idReferencia=".$fila["iRegistro"];
	
		$iRegistro=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".($iRegistro==""?-1:$iRegistro);		
		$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
		$generoAcuerdo=$fDatosDocumento["documentoBloqueado"];
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
		$victima=$con->obtenerListaValores($consulta);
		
		$o='{"iRegistro":"'.$fila["iRegistro"].'","iFormulario":"'.$fila["iFormulario"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].
			'","fechaRegistro":"'.$fila["fechaRegistro"].'","fechaFenecimiento":"'.$fila["fechaFenecimiento"].'","unidadGestion":"'.$unidadGestion.'",
			"tipoSolicitud":"'.$fila["tAudiencia"].'","etapaActual":"'.$fila["etapaActual"].
			'","totalTareasEmitidas":"'.$totalTareasEmitidas.'","totalTareasVisualizadas":"'.$totalTareasVisualizada.
			'","horasMaximaAtencion":"'.$fila["horasMaximaAgendaAudiencia"].'","folioRegistro":"'.$fila["codigo"].'","asuntoPromocion":"'.
			cv($fila["asuntoPromocion"]).'","totalAudienciasGeneradas":"'.$totalAudienciasGeneradas.'","generoAcuerdo":"'.$generoAcuerdo.
			'","acuerdoNotificado":"'.($fila["respNotificada"]==1?1:0).'","victima":"'.cv($victima).'","centroRegistro":"'.cv($fila["adscripcionRegistrante"]).'"}';
			
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
}


function obtenerEventosAudienciaSGJPLAMVLVCDMX()
{
	global $con;
	
	$considerarConRecursos="";
	$carpetaAdministrativa="";
	$juez="";
	$condiciones="";
	if(isset($_POST["filter"]))
	{
		$filter=$_POST["filter"];
		$nFiltros=sizeof($filter);
		
		for($x=0;$x<$nFiltros;$x++)
		{
			switch($filter[$x]["field"])
			{
				case "juez":
					$juez=$filter[$x]["data"]["value"];
				break;
				case "situacion":
					$c=" and e.situacion in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "carpetaAdministrativa":
					$carpetaAdministrativa=$filter[$x]["data"]["value"];
					//$condiciones=" and carpetaAdministrativa like '".$filter[$x]["data"]["value"]."%'";
				break;
				case "fechaEvento":
				
					$arrFecha=explode('/',$filter[$x]["data"]["value"]);
					$valor="'".$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0]."'";
					$operador="";
					switch($filter[$x]["data"]["comparison"])
					{
						case "gt":
							$operador=">";
						break;
						case "lt":
							$operador="<";
						break;
						case "eq":
							$operador="=";
						break;
					}
					$c=" and fechaEvento ".$operador." ".$valor;

					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
					
				break;
				case "sala":
					$c=" and idSala in(".$filter[$x]["data"]["value"].")";
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "edificio":
					$c=" and idEdificio=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "tipoAudiencia":
					$c=" and tipoAudiencia=".$filter[$x]["data"]["value"];
					if($condiciones=="")
						$condiciones=$c;
					else
						$condiciones.=" ".$c;
				break;
				case "conRecursosAdicionales":
				
						$considerarConRecursos=$filter[$x]["data"]["value"];
				
				break;
			}
		}
		
	}
	
	$uG=$_POST["uG"];
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$idActividad=-1;
	$arrRegistros="";//carpetaAdministrativa
	
	
	
	$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,e.situacion,
			idEdificio,idCentroGestion,idSala,tipoAudiencia,e.idFormulario,e.idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia ,idEdificio 
			FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
			where fechaEvento>='".$fechaInicio."' and fechaEvento<='".$fechaFin."' 
			and horaInicioEvento is not null and horaFinEvento is not null and con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento
			and c.carpetaAdministrativa=con.carpetaAdministrativa and c.idFormulario=622
			".$condiciones." ";		
	
	
	
	if($uG!="0")		
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad in('".$uG."')";
		$iUnidad=$con->obtenerListaValores(str_replace("''","'",$query));
		$consulta.=" and idCentroGestion in(".$iUnidad.")";
	}
	else
	{
		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
		$iUnidad=$con->obtenerListaValores($query);
		$consulta.=" and idCentroGestion in(".$iUnidad.")";
	}

	if(isset($_POST["iEdificio"]))
	{
		$consulta.=" and idEdificio in(".$_POST["iEdificio"].")";
	}
	
	//$consulta.=" limit 25,5";
	
	
	$numReg=0;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchRow($res))
	{

		$query="SELECT GROUP_CONCAT(CONCAT('(',if(noJuez is null,'',noJuez),') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
					7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
	
		$jueces=$con->obtenerValor($query);
		
		if($juez!="")
		{
			if(stripos($jueces,$juez)===false)
			{
				continue;
			}
		}
		$correoCentroRegistro="";
		$centroRegistro="";
		$carpeta="";
		$tipoAudiencia=$fila[8];
		$tAudiencia="";
		$carpetaInvestigacion="";
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0];
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$carpeta=$fDatos[0];
			$consulta="SELECT idActividad,carpetaInvestigacion,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";

			$fCarpetaInvestigacion=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fCarpetaInvestigacion[0];
			if($idActividad=="")
			{
				$idActividad=obtenerIDActividadCarpetaJudicial($carpeta);
			}

			$carpetaInvestigacion=$fCarpetaInvestigacion[1];
			
			
			if($fCarpetaInvestigacion[2]==622)
			{
				$consulta="SELECT adscripcionRegistrante,emailRegistrante FROM _622_tablaDinamica WHERE id__622_tablaDinamica=".$fCarpetaInvestigacion[3];
				$fDatosSolicitud=	$con->obtenerPrimeraFila($consulta);
				$centroRegistro=$fDatosSolicitud[0];
				$correoCentroRegistro=$fDatosSolicitud[1];
			}
		}
		
		if($carpetaAdministrativa!="")
		{
			if(strpos($carpeta,$carpetaAdministrativa)!==0)
			{
				continue;
			}
		}
		
		$iFormularioSituacion=-1;
		$iRegistroSituacion=-1;
		
		switch($fila[4])
		{
			case "2"://Finalizada
				$iFormularioSituacion=321;
				$consulta="SELECT id__321_tablaDinamica FROM _321_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "6"://Resuelta por acuerdo
				$iFormularioSituacion=322;

				$consulta="SELECT id__322_tablaDinamica FROM _322_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;
			break;
			case "3"://Cancelado
				$iFormularioSituacion=323;
				$consulta="SELECT id__323_tablaDinamica FROM _323_tablaDinamica WHERE idEvento=".$fila[0];
				$iRegistroSituacion=$con->obtenerValor($consulta);
				if($iRegistroSituacion=="")
					$iRegistroSituacion=-1;	
			break;
		}
		
		
		$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".($fila[7]==""?-1:$fila[7]);

		$canal=$con->obtenerValor($consulta);
		if((!existeRol("'1_0'"))&&(!existeRol("'177_0'"))&&(!existeRol("'176_0'"))&&(!existeRol("'112_0'"))&&(!existeRol("'90_0'")))
		{
				
			$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
			$idUnidadGestion=$con->obtenerValor($consulta);
			if($idUnidadGestion=="")
				$idUnidadGestion=-1;
			$consulta="SELECT COUNT(*) FROM _55_tablaDinamica WHERE idReferencia=".$idUnidadGestion." AND salasVinculadas=".($fila[7]==""?-1:$fila[7]);
			
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
				$canal="";
		}
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
		
		
		$imputado=$con->obtenerListaValores($consulta);
		
		$tImputados=$con->filasAfectadas;
		
		$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb not in(1000,99) ORDER BY fecha DESC	";
		$fRegistroNotificacionMajo=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT resultado,comentario FROM 3009_bitacoraVideoGrabacion  WHERE idEvento=".$fila[0]." and servicioWeb=1000 ORDER BY fecha DESC	";
		$fRegistroNotificacionCabina=$con->obtenerPrimeraFila($consulta);

		
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$idActividad."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";

		$lblDelitos=$con->obtenerValor($consulta);
		
		$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$idActividad." and
				i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
		
		
		$victima=$con->obtenerListaValores($consulta);
		
		$recursosAdicionales="";
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fila[0];
		$resRecursos=$con->obtenerFilas($consulta);
		while($fRecurso=$con->fetchAssoc($resRecursos))
		{
			
			$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRecurso["idRecurso"];
			$recurso=$con->obtenerValor($consulta);

			if($recursosAdicionales=="")
				$recursosAdicionales=$recurso;
			else
				$recursosAdicionales.="<br>".$recurso;
		}
		
		
		if($considerarConRecursos!="")
		{
			if($considerarConRecursos==1)
			{
				if($recursosAdicionales=="")
					continue;
			}
			else
			{
				if($recursosAdicionales!="")
					continue;
			}
		}
		
		
		$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila[7];
		$perfilSala=$con->obtenerValor($consulta);
		
		$participantesConfirmados=0;
		if($perfilSala==3)
		{
			$urlAudiencia="";
			
			
			$consulta="SELECT urlAudiencia FROM 7000_eventosAudienciaComplemetaria WHERE idRegistroEvento=".$fila[0];
			$urlAudiencia=$con->obtenerValor($consulta);
			$totalParticipantes=0;
			$totalConfirmados=0;

			$consulta="SELECT id__47_tablaDinamica AS idUsuario,idRelacion,
					CONCAT(IF(nombre IS NULL,' ',nombre),' ',IF(apellidoPaterno IS NULL,' ',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,' ',apellidoMaterno)) AS nombre,
					idFiguraJuridica AS figuraJuridica,r.situacion,r.idCuentaAcceso
					 FROM 
					7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad.
					" AND p.id__47_tablaDinamica=r.idParticipante";

			$resParticipante=$con->obtenerFilas($consulta);
			while($filaParticipante=$con->fetchAssoc($resParticipante))
			{
				$consulta="SELECT * FROM 7006_participantesNoAplicaAudienciaVirtual WHERE carpetaAdministrativa='".$carpeta.
							"' AND idParticipante=".$filaParticipante["idUsuario"];

				$fNoAplica=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				if((!$fNoAplica)&&($filaParticipante["situacion"]==1))
				{
					$totalParticipantes++;
				
					$consulta="SELECT COUNT(*) FROM 7006_usuariosVSAudienciasCodigoGenerado WHERE idUsuario=".$filaParticipante["idUsuario"].
								" AND carpetaAdministrativa='".$carpeta."' AND idEvento=".$fila[0];

					$nConfirmaciones=$con->obtenerValor($consulta);
					if($nConfirmaciones>0)
						$totalConfirmados++;
				}
			}
			
			$participantesConfirmados=$totalConfirmados."/".$totalParticipantes;
			
		}
		
		
		$o='{"urlCanal":"'.$canal.'","idEvento":"'.$fila[0].'","carpetaAdministrativa":"'.$carpeta.'","fechaEvento":"'.$fila[1].
			'","horaInicial":"'.$fila[2].'","horaFinal":"'.$fila[3].'",
			"tipoAudiencia":"'.$tipoAudiencia.'","sala":"'.$fila[7].'","unidadGestion":"'.$fila[6].
			'","situacion":"'.$fila[4].'","juez":"'.$jueces.'","tImputados":"'.$tImputados.'","horaInicialReal":"'.$fila[11].
			'","horaFinalReal":"'.$fila[12].'","urlMultimedia":"'.$fila[13].'","iFormulario":"'.$fila[9].'","iRegistro":"'.$fila[10].
			'","iFormularioSituacion":"'.$iFormularioSituacion.'","iRegistroSituacion":"'.$iRegistroSituacion.'",
			"notificacionMAJO":"'.$fRegistroNotificacionMajo[0].'","mensajeMAJO":"'.cv($fRegistroNotificacionMajo[1]).
			'","delitos":"'.cv($lblDelitos).'","edificio":"'.$fila[14].'","carpetaInvestigacion":"'.$carpetaInvestigacion.
			'","imputado":"'.cv($imputado).'","victima":"'.cv($victima).'","notificacionCabina":"'.
			$fRegistroNotificacionCabina[0].'","recursosAdicionales":"'.cv($recursosAdicionales).
			'","mensajeCabina":"'.cv($fRegistroNotificacionCabina[1]).'","conRecursosAdicionales":"'.($recursosAdicionales==""?0:1).
			'","audienciaVirtual":"'.((($perfilSala==3)||($perfilSala==4))?1:0).'","participantesConfirmados":"'.$participantesConfirmados.
			'","urlAudiencia":"","centroRegistro":"'.cv($centroRegistro).'","correoCentroRegistro":"'.cv($correoCentroRegistro).'"}';
		
		
		if($arrRegistros=="")
			$arrRegistros=$o;
		else	
			$arrRegistros.=",".$o;
		
		$numReg++;
	}
	
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}


function registrarDocumentoScanCarpetaJudicial()
{
	$carpetaAdministrativa=$_POST["cA"];
	$idCarpetaAdministrativa=$_POST["iC"];
	$nombreArchivo=$_POST["n"];
	$idDocumento=$_POST["iD"];
	
	if(isset($_SESSION[$nombreArchivo]))
	{
		foreach($_SESSION[$nombreArchivo] as $fileName=>$pathFila)
		{
			if(file_exists($pathFila))
				unlink($pathFila);
			
		}
		unset($_SESSION[$nombreArchivo]);
	}
	
	$idDocumento=registrarDocumentoServidorRepositorio($idDocumento,$nombreArchivo,2,"");

	if($idDocumento!=-1)
	{
		if(registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,-1,-1,$idCarpetaAdministrativa))
			echo "1|";
	}
}

function eliminarDocumentosScanSession()
{
	global $baseDir;
	$nombreArchivo=$_POST["s"];
	
	if(isset($_SESSION[$nombreArchivo]))
	{
		foreach($_SESSION[$nombreArchivo] as $fileName=>$pathFila)
		{
			if(file_exists($pathFila))
				unlink($pathFila);
			
		}
		unset($_SESSION[$nombreArchivo]);
		$rutaDestinoArchivoFinal=$baseDir."/archivosTemporales/".$nombreArchivo;
		if(file_exists($rutaDestinoArchivoFinal))
			unlink($rutaDestinoArchivoFinal);
	}
	
	echo "1|";
	
}


function registrarCuadernilloExpediente()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	if($obj->tipoCarpeta==11)
	{
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
					idRegistro,unidadGestion,etapaProcesalActual,situacion,idActividad,tipoCarpetaAdministrativa,
					carpetaAdministrativaBase,idCarpetaAdministrativaBase,idPerfilAcceso)
					VALUES('".cv($obj->carpetaRelacionada)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",-1,-1,'".
					$_SESSION["codigoInstitucion"]."',1,1,-1,0,'".$obj->carpetaAdministrativa."',".$obj->idCarpetaAdministrativa.
					",".$obj->idPerfilAcceso.")";
		$x++;				
		
	}
	else
	{
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,idRegistro,
					unidadGestion,etapaProcesalActual,situacion,idActividad,tipoCarpetaAdministrativa,idPerfilAcceso)
					VALUES('".cv($obj->carpetaRelacionada)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",-1,-1,'".$_SESSION["codigoInstitucion"].
					"',1,1,-1,0,".$obj->idPerfilAcceso.")";
		$x++;				
		$consulta[$x]="set @idCarpetaJudicial:=(select last_insert_id())";
		$x++;
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativasRelacionadas(carpetaAdministrativaBase,idCarpetaBase,tipoRelacion,carpetaAdministrativa,idCarpeta) 
				VALUES('".$obj->carpetaAdministrativa."',".$obj->idCarpetaAdministrativa.",6,'".cv($obj->carpetaRelacionada)."',@idCarpetaJudicial)";
	
		$x++;
	}
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		registrarMovimientoCarpetaAdministrativa($obj->carpetaAdministrativa,$obj->idCarpetaAdministrativa,"Se crea carpeta de \"".$obj->carpetaRelacionada."\" dentro de \"".$obj->carpetaAdministrativa."\"",1);
		echo "1|";
	}		
	
}

function modificarCuadernilloExpediente()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	

	$query="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$obj->idCarpetaAdministrativa;
	$carpetaAdministrativa=$con->obtenerValor($query);

	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET carpetaAdministrativa='".cv($obj->nombreCarpeta)."',idPerfilAcceso=".$obj->idPerfilAcceso.
				" WHERE idCarpeta=".$obj->idCarpetaAdministrativa;
	$x++;				
	$consulta[$x]="UPDATE 7006_carpetasAdministrativasRelacionadas SET carpetaAdministrativa='".cv($obj->nombreCarpeta)."' WHERE idCarpeta=".$obj->idCarpetaAdministrativa;
	$x++;
	
	$consulta[$x]="UPDATE 7006_carpetasAdministrativas SET carpetaAdministrativaBase='".cv($obj->nombreCarpeta)."' WHERE idCarpetaAdministrativaBase=".$obj->idCarpetaAdministrativa;
	$x++;
	
	if($obj->modificarPerfilContenido==1)
	{
		$consulta[$x]="UPDATE 7007_contenidosCarpetaAdministrativa SET carpetaAdministrativa='".cv($obj->nombreCarpeta)."',idPerfilAcceso=".$obj->idPerfilAcceso.
					" WHERE idCarpetaAdministrativa=".$obj->idCarpetaAdministrativa;
		$x++;
	}
	else
	{
		$consulta[$x]="UPDATE 7007_contenidosCarpetaAdministrativa SET carpetaAdministrativa='".cv($obj->nombreCarpeta).
					"' WHERE idCarpetaAdministrativa=".$obj->idCarpetaAdministrativa;
		$x++;
	}
	
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
	{
		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$obj->idCarpetaAdministrativa,"Se renombra carpeta de \"".$carpetaAdministrativa."\" a \"".$obj->nombreCarpeta."\"",2);
		echo "1|";
	}
}


function removerCuadernilloExpediente()
{
	global $con;
	$iC=$_POST["iC"];

	
	$idCarpetaAdministrativa=$iC;
	
	$query="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idCarpetaAdministrativa;
	$carpetaAdministrativa=$con->obtenerValor($query);
	
	$query="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa WHERE idCarpetaAdministrativa=".$idCarpetaAdministrativa." and tipoContenido<>3";
	$numReg=$con->obtenerValor($query);


	if($numReg>0)
	{
		echo "S&oacute;lo es posible remover cuadernillos que NO contengan documentos";
		return;
	}
	registrarMovimientoCarpetaAdministrativa($carpetaAdministrativa,$idCarpetaAdministrativa,"Se remueve carpeta \"".$carpetaAdministrativa."\"",3);
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	$consulta[$x]="DELETE FROM 7006_carpetasAdministrativasRelacionadas WHERE idCarpeta=".$idCarpetaAdministrativa;
	$x++;				

	$consulta[$x]="DELETE FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idCarpetaAdministrativa;
	$x++;
	
	$consulta[$x]="commit";
	$x++;
	
	
	if($con->ejecutarBloque($consulta))
	{
		
		echo "1|";
	}
}

function obtenerHistorialExpediente()
{
	global $con;
	$carpetaAdminsitrativa=$_POST["carpetaAdminsitrativa"];
	$idCarpeta=$_POST["idCarpeta"];
	
	$consulta="SELECT carpetaAdmnistrativa,idRegistro,
			(SELECT nombre from 800_usuarios WHERE idUsuario=m.idResponsable) AS responsable,
			fechaOperacion,movimiento AS comentarios FROM 7006_movimientosCarpetasAdministrativas m 
			WHERE carpetaAdministrativaRaiz='".cv($carpetaAdminsitrativa)."' 
			AND idCarpetaAdministrativaRaiz=".$idCarpeta;
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
	
}

function realizarMovimientoElemento()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$carpetaAdministrativaBse="";
	$idCarpetaAdministrativaBase="";
	$elementoDestino=explode("_",$obj->elementoDestino);
	$idElementoDestino=$elementoDestino[count($elementoDestino)-1];
	
	$leyenda="";
	$consulta="SELECT idCarpeta,carpetaAdministrativa,tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idElementoDestino;
	
	if($idElementoDestino==-1)
	{
		$consulta="SELECT idCarpeta,carpetaAdministrativa,tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$elementoDestino[0]."'";
	}
	$fCarpetaDestino=$con->obtenerPrimeraFilaAsoc($consulta);

	
	if($obj->tipoElemento=='n')
	{
		$elementoOperacion=explode("_",$obj->elementoOperacion);
		$idElementoOrigen=$elementoOperacion[count($elementoOperacion)-1];
		
		$consulta="SELECT idCarpeta,carpetaAdministrativa,tipoCarpetaAdministrativa,idCarpetaAdministrativaBase,carpetaAdministrativaBase 
				FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idElementoOrigen;
		$fCarpetaOrigen=$con->obtenerPrimeraFilaAsoc($consulta);

		$arrDatosCarpeta=obtenerCarpetaRaiz($fCarpetaOrigen["carpetaAdministrativa"],$fCarpetaOrigen["idCarpeta"]);
		$carpetaAdministrativaBase=$arrDatosCarpeta["carpetaAdministrativa"];
		$idCarpetaAdministrativaBase=$arrDatosCarpeta["idCarpeta"];

		if($fCarpetaOrigen["idCarpetaAdministrativaBase"]==$fCarpetaDestino["idCarpeta"])
		{
			echo "1|";
			return;
		}
		
		$consulta="UPDATE 7006_carpetasAdministrativas SET carpetaAdministrativaBase='".$fCarpetaDestino["carpetaAdministrativa"].
				"',idCarpetaAdministrativaBase=".$fCarpetaDestino["idCarpeta"]." WHERE idCarpeta=".$idElementoOrigen;		
		$leyenda="Se mueve carpeta \"".$fCarpetaOrigen["carpetaAdministrativa"]."\" de carpeta \"".$fCarpetaOrigen["carpetaAdministrativaBase"].
				"\" a carpeta \"'".$fCarpetaDestino["carpetaAdministrativa"]."\"";
	
		
	}
	else
	{
		$consulta="SELECT carpetaAdministrativaRaiz,idCarpetaAdministrativaRaiz,idRegistroContenidoReferencia,carpetaAdministrativa 
					FROM 7007_contenidosCarpetaAdministrativa WHERE idContenido=".$obj->elementoOperacion;
		$fCarpetaRaiz=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativaBase=$fCarpetaRaiz["carpetaAdministrativaRaiz"];			
		$idCarpetaAdministrativaBase=$fCarpetaRaiz["idCarpetaAdministrativaRaiz"];	
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fCarpetaRaiz["idRegistroContenidoReferencia"];
		$nomArchivoOriginal=$con->obtenerValor($consulta);
				
		if($obj->copia==0)
		{
			$consulta="UPDATE 7007_contenidosCarpetaAdministrativa SET 
					carpetaAdministrativa='".$fCarpetaDestino["carpetaAdministrativa"].
					"',idCarpetaAdministrativa=".$idElementoDestino.
					" WHERE idContenido=".$obj->elementoOperacion;
					
					
					
			$leyenda="Se mueve documento \"".$nomArchivoOriginal."\" de carpeta \"".$fCarpetaRaiz["carpetaAdministrativa"]."\" a carpeta \"'".$fCarpetaDestino["carpetaAdministrativa"]."\"";
		
		
		}
		else
		{
			$consulta="INSERT INTO 7007_contenidosCarpetaAdministrativa(carpetaAdministrativa,fechaRegistro,responsableRegistro,tipoContenido,
				descripcionContenido,urlContenido,idFormulario,idRegistro,idRegistroContenidoReferencia,complementario1,complementario2,complementario3,
				etapaProcesal,idCarpetaAdministrativa,ordenDocumento,noPaginas,paginaInicio,paginaFin,observaciones,origen,extension,
				carpetaAdministrativaRaiz,idCarpetaAdministrativaRaiz,copia)
				SELECT  '".$fCarpetaDestino["carpetaAdministrativa"]."' as carpetaAdministrativa,fechaRegistro,responsableRegistro,tipoContenido,
				descripcionContenido,urlContenido,idFormulario,idRegistro,idRegistroContenidoReferencia,complementario1,complementario2,complementario3,
				etapaProcesal,'".$idElementoDestino."' as idCarpetaAdministrativa,ordenDocumento,noPaginas,paginaInicio,paginaFin,observaciones,origen,extension,
				carpetaAdministrativaRaiz,idCarpetaAdministrativaRaiz,'1' as copia FROM 7007_contenidosCarpetaAdministrativa WHERE idContenido=".$obj->elementoOperacion;
			
			$leyenda="Se crea copia del documento \"".$nomArchivoOriginal."\" de carpeta \"".$fCarpetaRaiz["carpetaAdministrativa"]."\" en carpeta \"'".$fCarpetaDestino["carpetaAdministrativa"]."\"";
		}
		
		
	}
	if($con->ejecutarConsulta($consulta))
	{

		registrarMovimientoCarpetaAdministrativa($carpetaAdministrativaBase,$idCarpetaAdministrativaBase,$leyenda.".<br><br>Motivo: ".$obj->motivoCambio,6);
		echo "1|";
	}
}


function marcarAlertaNotificacionEsperaAtencion()
{
	$idRegistro=$_POST["iR"];
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="update 7036_alertasNotificaciones set situacion=1,fechaCancelacion=NULL,responsableCancelacion=NULL,
					motivoCancelacion='' WHERE idRegistro=".$idRegistro;
	$x++;
	$consulta[$x]="commit";
	$x++;
	
	eB($consulta);
	
}

function obtenerRegistroGeneracionOficio()
{
	global $con;
	$iR=isset($_POST["iR"])?$_POST["iR"]:-1;
	
	$iFormulario=$_POST["iFormulario"];
	$iRegistro=$_POST["iRegistro"];
	
	$cA=$_POST["cA"];
	$iP=$_POST["iP"];

	$a="";
	$act="";
	$consulta="SELECT id__1289_tablaDinamica,idEstado FROM _1289_tablaDinamica WHERE id__1289_tablaDinamica=".$iR;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistro)
	{
		$arrValores=array();
		$arrDocumentosReferencia=NULL;
		$arrValores["carpetaAdministrativa"]=$cA;
		$arrValores["tipoDocumento"]=$iP;
		$arrValores["iFormulario"]=$iFormulario;
		$arrValores["iRegistro"]=$iRegistro;
		$idRegistro=crearInstanciaRegistroFormulario(1289,-1,1.1,$arrValores,$arrDocumentosReferencia,-1,0);	
	
		$fRegistro[0]=$idRegistro;
		$fRegistro[1]=1.1;
	}
	
	
	
	$iR=$fRegistro[0];
	$a=bE("auto");
	$idProceso=obtenerIdProcesoFormulario(1289);
	$actor=obtenerActorProcesoIdRol($idProceso,'-100_0',$fRegistro[1]);
	$act=bE($actor);
	
	
	echo "1|".$iR."|".$a."|".$act;
	
}



?> 