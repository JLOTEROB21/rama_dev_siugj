<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cfdi/cFactura.php");
	
	
	
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerActividadesCronograma();
		break;
		case 2:
			guardarActividad();
		break;
		case 3:
			removerActividad();			
		break;
		case 4:
			obtenerProyectosOSC();
		break;
		case 5:
			obtenerSubcategoriasProyecto();
		break;
		case 6:
			asignarEvaluadorProyecto();
		break;
		case 7:
			realizarDictamenProyecto();
		break;
		case 8:
			guardarEvaluacionPresupuestal();
		break;
		case 9:
			obtenerComentariosProyecto();
		break;
		case 10:
			obtenerComentarioDictamen();
		break;
		case 11:
			modificarComentarioDictamen();
		break;
		case 12:
			guardarTopeCategoria();
		break;
		case 13:
			marcarProyectos();
		break;
		case 14:
			enviarEmailOSC();
		break;
		case 15:
			guardarDetalleConcepto();
		break;
		case 16:
			obtenerDetalleConcepto();
		break;
		case 17:
			obtenerComprobacionesEtapa();
		break;
		case 18:
			obtenerInformesTecnicos();
		break;
		case 19:
			obtenerDatosInformeTecnico();
		break;
		case 20:
			guardarInformeTecnico();
		break;
		case 21:
			obtenerMunicipios();
		break;
		case 22:
			guardarDatosProveedor();
		break;
		case 23:
			obtenerDatosProveedor();
		break;
		case 24:
			obtenerComprobantesDocumento();
		break;
		case 25:
			obtenerConceptoComprobar();
		break;
		case 26:
			guardarComprobacion();
		break;
		case 27:
			verificarNoExistenciaNoFactura();
		break;
		case 28:
			obtenerInformesTecnicosPeriodo();
		break;
		case 29:
			registrarDictamenInformeTecnico();
		break;
		case 30:
			obtenerComentariosInformeTecnico();
		break;
		case 31:
			obtenerSituacionFinancieraProyectos();
		break;
		case 32:
			obtenerSituacionPresupuestal();
		break;
		case 33:
			obtenerComprobacionesPresupuestal();
		break;
		case 34:
			obtenerDatosComprobantes();
		break;
		case 35:
			guardarEvaluacionComprobacion();
		break;
		case 36:
			obtenerSituacionFinancieraProyecto();
		break;
		case 37:
			obtenerSituacionConceptos();
		break;
		case 38:
			obtenerDatosProyecto();
		break;
		case 39:
			obtenerSituacionConceptoTransferencia();
		break;
		case 40:
			guardarSolicitudesTransferencia();
		break;
		case 41:
			obtenerSolicitudesTransferenciaPresupuesto();
		break;
		case 42:
			obtenerDatosSolicitudTransferencia();
		break;
		case 43:
			guardarEvaluacionSolicitudTransferencia();
		break;
		case 44:
			obtenerProductosComunicativosProyecto();
		break;
		case 45:
			registrarBitacoraSeguimiento();
		break;
		case 46:
			obtenerInformesBitacoraProyecto();
		break;
		case 47:
			obtenerRevisionContenidosProyecto();
		break;
		case 48:
			obtenerComentariosFinalesInforme();
		break;
		case 49:
			registrarDictamenFinalInforme();
		break;
		case 50:
			obtenerComentariosProyectos();
		break;
		case 51:
			obtenerProyectosGraficos();
		break;
		case 52:
			obtenerCategoriasCiclo();
		break;
		case 53:
			obtenerCategoriasRegistroProyectosConfiguracion();
		break;
		case 54:
			obtenerSubCategoriasRegistroProyectosConfiguracion();
		break;
		case 55:
			obtenerTemasSubCategoriasRegistroProyectosConfiguracion();
		break;
		case 56:
			validarRegistroProyecto();
		break;
		case 57:
			obtenerListaProyectosConfiguracion();
		break;
		case 58:
			obtenerMetasProyectos();
		break;
		case 59:
			guardarMetaProyectos();
		break;
		case 60:
			removerMetaProyectos();
		break;
		case 61:
			obtenerIndicadoresActividad();
		break;
		case 62:
			obtenerActividadesCronogramaV2();
		break;
		case 63:
			guardarActividadCronogramaV2();
		break;
		case 64:
			obtenerIndicadoresProyectos();
		break;
		case 65:
			guardarIndicadoresProyectos();
		break;
		case 66:
			obtenerPoblacionesBlancoProyectos();
		break;
		case 67:
			guardarPoblacionProyectos();
		break;
		case 68:
			obtenerSituacionCategoriasV2();
		break;
		case 69:
			obtenerProyectosRegistradoTema();
		break;
		case 70:
			registrarMotivoRechazoRevisor();
		break;
		case 71:
			obtenerEvaluadoresProyectos();
		break;
		case 72:
			cambiarMarcaProyecto();
		break;
		case 73:
			asignarRevisionComite();
		break;
		case 74:
			cerrarCategoria();
		break;
		case 75:
			guardarIgnorarSituacion();
		break;
		case 76:
			registrarComentariosProyecto();
		break;
		case 77:
			obtenerComentariosProyectoV3();
		break;
		case 78:
			obtenerComentariosDescalificacion();
		break;
		case 79:
			generarListadoAleatorio();
		break;
		case 80:
			obtenerSituacionFinancieraProyectos2013();
		break;
		case 81:
			obtenerInformesTecnicosPeriodoCiclosVarios();
		break;
		case 82:
			evaluarRequisitosRegistro();
		break;
		case 83:
			obtenerPoblacionesBlancoProyecto2014();
		break;
		case 84:
			registrarPoblacionesBlancoProyecto2014();
		break;
		case 85:
			removerPoblacionesBlancoProyecto2014();
		break;
		case 86:
			actualizarPoblacionesBlancoProyecto2014();
		break;
		case 87:
			registrarRecursoHumano2014();
		break;
		case 88:
			obtenerIndicadoresProyectos2014();
		break;
		case 89:
			obtenerIndicadoresProyectosDisponibles2014();
		break;
		case 90:
			guardarIndicadoresProyecto2014();
		break;
		case 91:
			removerIndicadoresProyecto2014();
		break;
		case 92:
			actualizarValorIndicadorProyecto();
		break;
		case 93:
			registrarIndicador2014();
		break;
		case 94:
			obtenerDocumentosRegistroOSC();
		break;
		case 95:
			registrarDocumentoOSC();
		break;
		case 96:
			obtenerOSCMonitor();
		break;
		case 97:
			registrarEvaluacionDocumentosOSC();
		break;
		case 98:
			guardarEvaluacionPresupuestal2014();
		break;
		case 99:
			marcarProyectoNORequiereEvaluacionComite2014();
		break;
		case 100:
			removerMarcaProyectoNORequiereEvaluacionComite2014();
		break;
		case 101:
			cerrarEvaluacion2014();
		break;
		case 102:
			prepararEvaluacionComite();
		break;
		case 103:
			registrarDictamenProyectosContinuidad();
		break;
		case 104:
			registrarDictamenProyectosIdentificacionOSC();
		break;
		case 105:
			registrarDictamenProyectosInnovacion();
		break;
		case 106:
			registrarDescalificacionProyecto();
		break;
		case 107:
			obtenerConceptosEvaluacionPresupuestalOSC();
		break;
		case 108:
			registrarModificacionConcepto();
		break;
		case 109:
			registrarJustificacionConcepto();
		break;
		case 110:
			notificarCambiosCENSIDAOSC();
		break;
		case 111:
			guardarEvaluacionPresupuestalFinal2014();
		break;
		case 112:
			registrarAutorizacionProyecto();
		break;
		case 113:
			realizarDictamenAjustePresupuestal();
		break;
		case 114:
			obtenerResultadosFinalesPresupuesto();
		break;
		case 115:
			obtenerProyectosConvenios();
		break;
		case 116:
			registrarVoBoProyecto();
		break;
		case 117:
			marcarFirmaConvenio();
		break;
		case 118:
			registrarObjetivoGeneral();
		break;
		case 119:
			obtenerElementoSeccionObjetivos();
		break;
		case 120:
			registrarObjetivoEspecifico();
		break;
		case 121:
			registrarMeta();
		break;
		case 122:
			removerElementoCronogramaActividades();
		break;
		case 123:
			obtenerDatosConvenio2014();
		break;
		case 124:
			verificarCFDIValido();
		break;
		case 125:
			verificarCFDIAlterado();
		break;
		case 126:
			verificarCFDISAT();
		break;
		case 127:
			verificarCFDIRegistroSistema();
		break;
		case 128:
			obtenerInformesTecnicosPeriodoCiclo2014();
		break;
		case 129:
			registrarEvaluacionProyecto2daConv();
		break;
		case 130:
			guardarComprobacionV2();
		break;
		case 131:
			registrarEvaluacionEtapa1();
		break;
		case 132:
			obtenerInformeFinanciero2014();
		break;
		case 133:
			obtenerProductosComunicativosProyecto2014();
		break;
		case 134:
			registrarComentarioBitacora();
		break;
		case 135:
			obtenerComentariosBitacoraProyecto();
		break;
		case 136:
			registrarEvaluacionEtapa2();
		break;
		case 137:
			marcarProyectoFinanciable();
		break;
		case 138:
			actualizarDetallecomprobante();
		break;
		case 139:
			obtenerPoblacionesBlancoProyectos2014();
		break;
		case 140:
			obtenerEstadosProyectos2014();
		break;
		case 141:
			obtenerPoblacionesBlancoOSC();
		break;
		case 142:
			obtenerEstadosOSC();
		break;
		case 143:
			obtenerRequisitosParticipacion();
		break;
		case 144:
			obtenerLineasAccionProyecto();
		break;
		case 145:
			guardarIntervencionesProyectos();
		break;
		case 146:
			obtenerIntervencionesProyecto();
		break;
		case 147:
			guardarActividadCronogramaIntervencion();
		break;
		case 148:
			obtenerActividadesCronogramaIntervencion();
		break;
		case 149:
			obtenerPoblacionesZonasProyecto();
		break;
		case 150:
			obteneAlcancePoblacionZonaRangoProyecto();
		break;
		case 151;
			registrarAlcancePoblacionZonaRangoProyecto();
		break;
		case 152;
			removerAlcancePoblacionZonaRangoProyecto();
		break;
		case 153:
			obtenerIndicadoresProyectosDisponibles2015();
		break;
		case 154:
			obtenerIndicadoresProyectos2015();
		break;
		case 155:
			registrarIndicador2015();
		break;
		case 156:
			guardarActividadCronograma2015();
		break;
		case 157:
			registrarJustificacionProyecto();
		break;
		case 158:
			obtenerDistribucionProyectosCategorias();
		break;
		case 159:
			obtenerProyectosRegistrados2015();
		break;
		case 160:
			obtenerOSCParticipantes2015();
		break;
		case 161:
			marcarOSCDescalificada();
		break;
		case 162:
			desmarcarOSCDescalificada();
		break;
		case 163:
			registrarEvaluacionProyectosCartas();
		break;
		case 164:
			
			registrarMaximoProyectosRevisor();
		break;
		case 165:
			
			obtenerConceptosPresupuesto();
		break;
		case 166:
			registrarModificacionPresupuesto2015();
		break;
		case 167:
			registrarIncidenciaProyectos2015();
		break;
		case 168:
			obtenerCalificacionesFinales();
		break;
		case 169:
			descalificarProyecto2015();
		break;
		case 170:
			obtenerProyectosFinanciados2015();
		break;
		case 171:
			obtenerProyectosNOFinanciados2015();
		break;
		case 172:
			marcarProyectoFinanciable2015();
		break;
		case 173:
			registrarFinalizacionAjustePresupuestal();
		break;
		case 174:
			obtenerInformeFinanciero20142da();
		break;
		case 175:
			obtenerProyectosFinanciados2015_V2();
		break;
		case 176:
			obtenerProyectosConvenios2015();
		break;
		case 177:
			registrarVoBoProyecto2015();
		break;
		case 178:
			obtenerEntregablesProyectosActividades();
		break;
		case 179:
			obtenerInfoProyecto();
		break;
		case 180:
			obtenerDocumentosProyectos();
		break;
		case 181:
			obtenerDocumentosProyectosSupervisor();
		break;
		case 182:
			registrarEvaluacionDocumento();
		break;
		case 183:
			obtenerDocumentosProyectosSupervisorImagen();
		break;
		case 184:
			obtenerComentariosRegistroDocumentos();
		break;
		case 185:
			obtenerComentariosOSC();
		break;
		case 186:
			obtenerInformeFinanciero2015();
		break;
		case 187:
			obtenerInformesTecnicosPeriodoCiclo2015();
		break;
		case 188:
			obtenerRevisionDocumentosProyectos();
		break;
		case 189:
			guardarCartaValidacionInformeTecnico();
		break;
		case 190:
			obtenerIdRegistroPerfilOSC();
		break;
		case 191:
			obtenerMaterialesComunicativos();
		break;
		case 192:
			obtenerElementoSeccionObjetivos2016();
		break;
		case 193:	
			obtenerSituacionConvocatoria2016();
		break;
		case 194:
			crearRegistroConvocatoria2016();
		break;
		case 195:
			guardarActividadCronograma2016();
			
		break;
		case 196:
			obtenerInformesTecnicos2012_2015();
		break;
		case 197:
			obtenerOSCCompletaronRegistro();
		break;
		case 198:
			obtenerOSCCompletaronPerfil();
		break;
		case 199:
			obtenerProyectosRegistrados();
		break;
		case 200:
			obtenerOSCValidacion();
		break;
		case 201:
			obtenerInfomacionIndesol();
		break;
		case 202:
			registrarEvaluacionDocumentosOSCIndesol();
		break;
		case 203:
			obtenerInformesTecnicos2015INSP();
		break;
		case 204:
			analizarParticipantesOSC();
		break;
		case 205:
			enviarEmailRevisor();
		break;
		case 206:
			registrarComentariosAgustin();
		break;
		case 207:
			registrarDescalificacionProyecto2015();
		break;
		case 208:
			registrarCandidatoProyecto2015();
		break;
		case 209:
			registrarEvaluacionCartaProyecto2015();
		break;
		case 210:
			guardarComentariosEvaluacionPresupuestal();
		break;
		case 211:
			obtenerProyectosConvenios2016();
		break;
	}
	
	
	
	function obtenerActividadesCronograma()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		$mesIni=$_POST["mesIni"];
		$mesFin=$_POST["mesFin"];
		$consulta="SELECT idActividadPrograma,actividad,descripcion FROM 965_actividadesUsuario WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and idPadre=-1";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		$consulta="SELECT * FROM _371_tablaDinamica WHERE idReferencia=".$idReferencia;
		$fRegistro=$con->obtenerPrimeraFila($consulta);	
		$arrObjetivos=array();
		if($fRegistro)
		{
			$arrObjetivos[1]=$fRegistro[11];
			$arrObjetivos[2]=$fRegistro[12];
			$arrObjetivos[3]=$fRegistro[13];
		}

		
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x."";
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$hijos="";
			$cadHijos=obtenerActividadesHijos($fila[0],$mesIni,$mesFin,$arrObjetivos);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			$obj='{"txtObjetivo":"'.cv($arrObjetivos[$fila[2]]).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","objetivoAsoc":"'.$fila[2].'"'.$comp.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		echo "[".$cadActividades."]";
	}

	function obtenerActividadesHijos($idActividad,$mesIni,$mesFin,$arrObjetivos)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion FROM 965_actividadesUsuario WHERE idPadre=".$idActividad;
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		while($fila=mysql_fetch_row($res))
		{
			
			
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x; 
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$cadHijos=obtenerActividadesHijos($fila[0],$mesIni,$mesFin,$arrObjetivos);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			$obj='{"txtObjetivo":"'.cv($arrObjetivos[$fila[2]]).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","objetivoAsoc":"'.$fila[2].'"'.$comp.$hijos.'}';
			
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return $cadActividades;
	}
	
	function guardarActividad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idActividad==-1)
		{
			$consulta[$x]="INSERT INTO 965_actividadesUsuario(actividad,idUsuario,idFormulario,idReferencia,descripcion,idPadre) 
							VALUES ('".cv($obj->actividad)."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idRegistro.",'".$obj->objetivoAsociado."',".$obj->idPadre.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";;
			$x++;
		}
		else
		{
			$consulta[$x]="update 965_actividadesUsuario set actividad='".cv($obj->actividad)."',descripcion='".$obj->objetivoAsociado."' where idActividadPrograma=".$obj->idActividad;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idActividad;
			$x++;
		}
		$consulta[$x]="delete from 968_planeacionActividadesMeses where idActividad=@idregistro";
		$x++;
		foreach($obj->arrMeses as $mes)
		{
			$consulta[$x]="INSERT INTO 968_planeacionActividadesMeses(idActividad,mes,valor)
							VALUES(@idRegistro,".$mes->mes.",'".$mes->valor."')";
			$x++;							
		}
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerActividad()
	{
		global $con;
		$idActividad=$_POST["idActividad"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="select idActividadPrograma from 965_actividadesUsuario where idPadre=".$idActividad;
		$res=$con->obtenerFilas($query);
		while($f=mysql_fetch_row($res))
		{
			removerActividadHija($f[0],$consulta,$x);
		}
		
		$consulta[$x]="delete from 965_actividadesUsuario WHERE idActividadPrograma=".$idActividad;
		$x++;
		$consulta[$x]="delete from 968_planeacionActividadesMeses WHERE idActividad=".$idActividad;
		$x++;
		$consulta[$x]="delete from 968_actividadesIndicador WHERE idActividad=".$idActividad;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	function removerActividadHija($idActividad,&$consulta,&$x)
	{
		global $con;
		$query="select idActividadPrograma from 965_actividadesUsuario where idPadre=".$idActividad;
		$res=$con->obtenerFilas($query);
		while($f=mysql_fetch_row($res))
		{
			removerActividadHija($f[0],$consulta,$x);
		}
		
		$consulta[$x]="delete from 965_actividadesUsuario WHERE idActividadPrograma=".$idActividad;
		$x++;
		$consulta[$x]="delete from 968_planeacionActividadesMeses WHERE idActividad=".$idActividad;
		$x++;
	}
	
	function obtenerProyectosOSC()
	{
		global $con;
		$idConfiguracion=0;
		if(isset($_POST["idConvocatoria"]))
			$idConfiguracion=$_POST["idConvocatoria"];
			
		if(!isset($_POST["revisor"]))
		{
			
			$ciclo=$_POST["ciclo"];
			switch($ciclo)
			{
				case 2012:
					$comp="";
					if(isset($_POST["tProyectos"]))
					{
						switch($_POST["tProyectos"])
						{
							case 1:
								$comp=" and p.idEstado  in (10,12,13) ";
							break;
							case 0:
								$comp=" and p.idEstado not in (10,12) ";
							break;
						}
					}
					
					$consulta="SELECT p.id__370_tablaDinamica AS idProyecto, noCategoria,nombreCategoria AS categoria,noSubcategoria,tituloSubcategoria AS subcategoria,
								p.codigo AS folio,p.tituloProyecto,p.fechaCreacion AS fechaRegistro,(select sum(total) from 100_calculosGridOriginal where idFormulario=370 and idReferencia=p.id__370_tablaDinamica) AS montoSolicitado,u.Nombre AS responsableRegistro,p.idEstado as situacion
								 FROM _369_tablaDinamica t,_369_subcategorias s,_370_tablaDinamica p,800_usuarios u 
								 WHERE s.idReferencia=t.id__369_tablaDinamica AND s.id__369_subcategorias=p.idReferencia AND p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND u.idUsuario=p.responsable ".$comp;
				
				
					//$arrReg=$con->obtenerFilasJson($consulta);					 
					$arrReg="";
					$res=$con->obtenerFilas($consulta);
					$nFilas=0;
					while($fila=mysql_fetch_row($res))
					{
						$consulta="SELECT TRIM(comentarios),c.conceptoPresupuestal FROM 100_rubrosAutorizados r,_385_tablaDinamica c WHERE c.id__385_tablaDinamica=r.idRubro and r.idFormulario=370 AND idRegistro=".$fila[0]." AND TRIM(comentarios) <>''     
									ORDER BY   ordenAparicion";
						$resComentarios=$con->obtenerFilas($consulta);
						$cuerpo="";
						$cadComentarios="<table><tr><td width='200' align='center'><b>Rubro</b></td><td width='400' align='center'><b>Comentarios</b></td></tr><tr height='1' ><td colspan='2' style=' background-color:#900'></td></tr>";
						while($filaC=mysql_fetch_row($resComentarios))
						{
							$cuerpo.="<tr><td valign='top' style='padding:5px 5px 5px 5px'><span><b>".cv($filaC[1])."</b></span></td><td style='text-align:justify;padding:5px 5px 5px 5px' valign='top'><span class='letraExt'>".cv($filaC[0])."</span></td></tr>";
						}
						$consulta="SELECT comentarios FROM 100_dictamenPresupuestalProyectos WHERE idFormulario=370 and idRegistro=".$fila[0];
						$comentarioFinal=str_replace("#R","",$con->obtenerValor($consulta));
		
						if($comentarioFinal<>'')
						{
							$cuerpo.="<tr><td valign='top' style='padding:5px 5px 5px 5px'><span><b>Comentario final</b></span></td><td style='text-align:justify;padding:5px 5px 5px 5px' valign='top'><span class='letraExt'>".cv($comentarioFinal)."</span></td></tr>";
						}
						if($cuerpo<>'')
						{
							$cadComentarios.=$cuerpo."</table>";
		
						}
						else
						{
							$cadComentarios="Sin comentarios, este proyecto no requiere ajustes<br><br>";
						}
						
						if($fila[10]==12)
							$cadComentarios="Los ajustes solicitados por el comité EARP ya fueron realizados<br><br>";
						$montoAutorizado="";
						if(isset($_POST["tProyectos"]))
						{
							if($_POST["tProyectos"]==0)
								$montoAutorizado=0;
						}
						$consulta="SELECT SUM(montoAutorizado) FROM 100_rubrosAutorizados WHERE idFormulario=370 AND idRegistro=".$fila[0];
						$montoAutorizado=$con->obtenerValor($consulta);
						
						$obj='{"idProyecto":"'.$fila[0].'","noCategoria":"'.$fila[1].'","categoria":"'.$fila[2].'","noSubcategoria":"'.$fila[3].'","subcategoria":"'.$fila[4].'","folio":"'.$fila[5].'",
								"tituloProyecto":"'.cv($fila[6]).'","fechaRegistro":"'.$fila[7].'","montoSolicitado":"'.$fila[8].'","responsableRegistro":"'.$fila[9].'","situacion":"'.$fila[10].'","comentariosComite":"'.$cadComentarios.'","montoAutorizado":"'.$montoAutorizado.'"}';
						if($arrReg=="")
							$arrReg=$obj;
						else
							$arrReg.=",".$obj;
						$nFilas++;
					}
					
					echo '{"numReg":"'.$nFilas.'","registros":['.$arrReg.']}';
				break;	
				case 2011:
					$comp="";
					if(isset($_POST["tProyectos"]))
					{
						switch($_POST["tProyectos"])
						{
							case 1:
								$comp=" and p.idEstado  in (12,13,14,15) ";
							break;
							case 0:
								$comp=" and p.idEstado not in (12,13,14,15) ";
							break;
						}
					}
					
					$consulta="SELECT p.id__293_tablaDinamica AS idProyecto, c.codigo,c.categoria AS categoria, c.codigo as noSubcategoria, c.categoria AS subcategoria,
								p.codigo AS folio,p.tituloProyecto,p.fechaCreacion AS fechaRegistro,(select sum(total) from 100_calculosGrid where idFormulario=293 and idReferencia=p.id__293_tablaDinamica) AS montoSolicitado,u.Nombre AS responsableRegistro,
								p.idEstado as situacion	from _293_tablaDinamica p,800_usuarios u,_292_tablaDinamica c
								 WHERE c.id__292_tablaDinamica=p.categorias and  p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND u.idUsuario=p.responsable ".$comp;
				
					
					$arrReg="";
					$res=$con->obtenerFilas($consulta);
					$nFilas=0;
					while($fila=mysql_fetch_row($res))
					{
						$cadComentarios="Sin comentarios";
						$montoAutorizado="";
						if(isset($_POST["tProyectos"]))
						{
							if($_POST["tProyectos"]==0)
								$montoAutorizado=0;
						}
						$consulta="SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=293 AND idReferencia=".$fila[0];
						$montoAutorizado=$con->obtenerValor($consulta);
						
						$obj='{"idProyecto":"'.$fila[0].'","noCategoria":"'.$fila[1].'","categoria":"'.$fila[2].'","noSubcategoria":"'.$fila[3].'","subcategoria":"'.$fila[4].'","folio":"'.$fila[5].'",
								"tituloProyecto":"'.cv($fila[6]).'","fechaRegistro":"'.$fila[7].' 00:00:00","montoSolicitado":"'.$fila[8].'","responsableRegistro":"'.$fila[9].'","situacion":"'.$fila[10].'","comentariosComite":"'.$cadComentarios.'","montoAutorizado":"'.$montoAutorizado.'"}';
						if($arrReg=="")
							$arrReg=$obj;
						else
							$arrReg.=",".$obj;
						$nFilas++;
					}
					
					echo '{"numReg":"'.$nFilas.'","registros":['.$arrReg.']}';
					
				break;
			}
			
			
		
		}
		else
		{
			$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
			$fConfiguracion=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT idFormulario,c.procesoAsociado FROM _412_tablaDinamica c,900_formularios f WHERE c.id__412_tablaDinamica=".$idConfiguracion." AND f.idProceso=c.procesoAsociado AND f.formularioBase=1";
			$fFrm=$con->obtenerPrimeraFila($consulta);
			$idFormularioBase=$fFrm[0];
			$idProceso=$fFrm[1];

			$consulta="SELECT idProyecto FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$idFormularioBase." AND idUsuario=".$_SESSION["idUsr"]." and situacion in(1,2,3)";
			$listProyecto=$con->obtenerListaValores($consulta);
			if($listProyecto=="")
				$listProyecto="-1";

			$consulta="select id__".$idFormularioBase."_tablaDinamica,".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2].",codigo,".$fConfiguracion[3].",fechaCreacion,responsable,idEstado,descalificado from _".$idFormularioBase."_tablaDinamica
				where id__".$idFormularioBase."_tablaDinamica in (".$listProyecto.") order by codigo";

			$numReg=0;
			$cadRegistros="";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				
				$comentariosComite="";
				$montoSolicitado=0;
				$montoAutorizado=0;
				$consulta="SELECT fechaAsignacion FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$idFormularioBase." AND idUsuario=".$_SESSION["idUsr"]." and idProyecto=".$fila[0];
				$fechaAsignacion=$con->obtenerValor($consulta);
				$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[1];
				$fReg=$con->obtenerPrimeraFila($consulta);
				$noCategoria=$fReg[0];
				$categoria=($fReg[1]);
				$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[2];
				$fReg=$con->obtenerPrimeraFila($consulta);
				$noSubcategoria=($fReg[0]);
				$subcategoria=($fReg[1]);
				$consulta="SELECT noPoblacion,tituloTema FROM _418_tablaDinamica WHERE id__418_tablaDinamica=".$fila[3];
				$fReg=$con->obtenerPrimeraFila($consulta);
				$noTema=$fReg[0];
				$tema=($fReg[1]);
				$cadObj='{"idFormulario":"'.$idFormularioBase.'","idRegistro":"'.$fila[0].'"}';
				$objReg=json_decode($cadObj);
				$cache=NULL;					
							
				$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$fila[8];			
				$fEtapa=$con->obtenerPrimeraFila($consulta);					 
				$situacionActual=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
				if(($fConfiguracion[4]!="")&&($fConfiguracion[4]!=-1))
				{
					$montoSolicitado=resolverExpresionCalculoPHP($fConfiguracion[4],$objReg,$cache);
					$montoSolicitado=str_replace("'","",$montoSolicitado);
					if($montoSolicitado=="")
						$montoSolicitado=0;
				}
				
				if(($fConfiguracion[5]!="")&&($fConfiguracion[5]!=-1))
				{
					$montoAutorizado=resolverExpresionCalculoPHP($fConfiguracion[5],$objReg,$cache);
					$montoAutorizado=str_replace("'","",$montoSolicitado);
					if($montoAutorizado=="")
						$montoAutorizado=0;
				}
				
				$consulta="SELECT situacion FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$idFormularioBase." AND idUsuario=".$_SESSION["idUsr"]." and idProyecto=".$fila[0];
				$estadoEvaluacion=$con->obtenerValor($consulta);
				
				if(($estadoEvaluacion==1)&&($fila[9]==1))
					continue;
				
				
				$responsable=obtenerNombreUsuarioPaterno($fila[7]);
				$obj='{"estadoEvaluacion":"'.$estadoEvaluacion.'","situacionActual":"'.$situacionActual.'","idProyecto":"'.$fila[0].'","noCategoria":"'.$noCategoria.'","categoria":"'.cv($categoria).'","noSubcategoria":"'.$noSubcategoria.'","subcategoria":"'.cv($subcategoria).'","noTema":"'.$noTema.'","tema":"'.cv($tema).
					'","folio":"'.$fila[4].'","tituloProyecto":"'.cv($fila[5]).'","fechaAsignacion":"'.$fechaAsignacion.'","montoSolicitado":"'.$montoSolicitado.'","responsableRegistro":"'.$responsable.'","situacion":"'.$fila[8].
					'","comentariosComite":"'.$comentariosComite.'","montoAutorizado":"'.$montoAutorizado.'"}';
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
				$numReg++;
			}				
			
			$arrReg=$con->obtenerFilasJson($consulta);					 
			echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
		}
		
	}
	
	function obtenerSubcategoriasProyecto()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$arrCategorias="";
		$consulta="SELECT id__369_subcategorias,noSubcategoria,tituloSubcategoria,objetivo FROM _369_subcategorias WHERE idReferencia=".$idCategoria." ORDER BY noSubcategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$nombreCategoria=removerCerosDerecha($fila[1]).".- ".$fila[2];
			$obj="['".$fila[0]."','".$nombreCategoria."','".$fila[3]."']";
			if($arrCategorias=="")
				$arrCategorias=$obj;
			else
				$arrCategorias.=",".$obj;
		}
		echo "1|[".$arrCategorias."]";
	}
	
	function asignarEvaluadorProyecto()
	{
		global $con;
		$idRevisor=$_POST["idRevisor"];
		$lProyectos=$_POST["lProyectos"];
		$arrProyectos=explode(",",$lProyectos);
		$cadProblemas="";
		
		$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles WHERE idUsuario=".$idRevisor." AND codigoRol='10_0'";
		$nReg=$con->obtenerValor($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		if($nReg==0)
		{
			$query[$x]="INSERT INTO 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol)VALUES(".$idRevisor.",10,0,'10_0')";
			$x++;
		}
		foreach($arrProyectos as $p)
		{
			$consulta="SELECT codigo,tituloProyecto,s.idReferencia FROM _370_tablaDinamica t,_369_subcategorias s WHERE id__370_tablaDinamica=".$p." and 
					s.id__369_subcategorias=t.idReferencia";
			$fProy=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT COUNT(*) FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=370 AND idProyecto=".$p;

			$nAsig=$con->obtenerValor($consulta);
			if($nAsig>3)
			{
				
				$obj="['".$fProy[0]."','".$fProy[1]."','El proyecto ya cuenta con 4 evaluaciones']";
				if($cadProblemas=="")
					$cadProblemas=$obj;
				else
					$cadProblemas.=",".$obj;
			}
			else
			{
				$consulta="SELECT COUNT(*) FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=370 AND  idUsuario=".$idRevisor." and  idProyecto=".$p;
				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
				{
					$obj="['".$fProy[0]."','".$fProy[1]."','El proyecto ya ha sido evaluado por el revisor']";
					if($cadProblemas=="")
						$cadProblemas=$obj;
					else
						$cadProblemas.=",".$obj;
				}
				else
				{
					$query[$x]="INSERT INTO 1011_asignacionRevisoresProyectos(idUsuario,idCategoria,idProyecto,tipoRevisor,idFormulario,situacion,fechaAsignacion)
								VALUES(".$idRevisor.",".$fProy[2].",".$p.",3,370,1,'".date("Y-m-d H:i")."')";
								
					$x++;
				}
			}
			
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			echo "1|[".$cadProblemas."]";
		}
		
		
	}
	
	function realizarDictamenProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$listaProyectos=$obj->listaProyectos;
		$comentario=$obj->comentario;
		$accion=$obj->accion;
			
		$arrProyectos=explode(",",$listaProyectos);
		foreach($arrProyectos as $idRegistro)
		{		
			$etapa="";
			
			$query="select idEstado from _".$obj->idFormulario."_tablaDinamica where id__".$obj->idFormulario."_tablaDinamica=".$idRegistro;
			
			$idEstado=$con->obtenerValor($query);
			switch($idEstado)
			{
				case 2:
					switch($accion)
					{
						case 0:
							$etapa=4;
						break;
						case 1:
							$etapa=3;
						break;
					}
				
				break;
				case 5:
					switch($accion)
					{
						case 0:
							$etapa=4;
						break;
						case 1:
							$etapa=6;
						break;
					}
				break;
			}
			
			if(cambiarEtapaFormulario($obj->idFormulario,$idRegistro,$etapa,$comentario))
			{
				$query="INSERT INTO 100_dictamenTecnicoProyectos(idFormulario,idRegistro,vComentariosFinales,comentarios,comentariosEvaluacion) 
						VALUES(".$obj->idFormulario.",".$idRegistro.",".$obj->vComentariosFinales.",'".$obj->listComentarios."','".cv($comentario)."')";
				if(!$con->ejecutarConsulta($query))
					return;
			}
		}
		echo "1|";
	}
	
	function guardarEvaluacionPresupuestal()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		$query="select idEstado from _".$obj->idFormulario."_tablaDinamica where id__".$obj->idFormulario."_tablaDinamica=".$obj->idProyecto;
		$idEstado=$con->obtenerValor($query);
		
		
		$consulta[$x]="begin";
		$x++;
		$query="select * from 100_dictamenPresupuestalProyectos where idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;
		$fProyectos=$con->obtenerPrimeraFila($query);
		if($fProyectos)
		{
			$consulta[$x]="update 100_dictamenPresupuestalProyectos set comentarios='".cv($obj->comentarios)."' where 
						idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;

			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 100_dictamenPresupuestalProyectos(idFormulario,idRegistro,comentarios,fechaEvaluacion,responsableEvaluacion)
						VALUES(".$obj->idFormulario.",".$obj->idProyecto.",'".cv($obj->comentarios)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].")";
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 100_rubrosAutorizados WHERE idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idProyecto;
		$x++;
		foreach($obj->arrRubros as $r)
		{
			$consulta[$x]="INSERT INTO 100_rubrosAutorizados(idRubro,idFormulario,idRegistro,montoAutorizado,comentarios)
						VALUES(".$r->idRubro.",".$obj->idFormulario.",".$obj->idProyecto.",".$r->montoAutorizado.",'".cv($r->comentarios)."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}
	}
	
	function obtenerComentariosProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=$_POST["idFormulario"];
		$consulta="SELECT a.idUsuarioVSProyecto as idEvaluacion,r.comentariosFinales as comentario FROM 1011_asignacionRevisoresProyectos a,9053_resultadoCuestionario r
				WHERE idProyecto=".$idProyecto." and idFormulario=".$idFormulario." AND r.idRegistroCuestionario=idReferencia and trim(comentariosFinales)<>''";
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
		
	}
	
	function obtenerComentarioDictamen()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$tDictamen=$_POST["tDictamen"];
		$idFormulario=$_POST["idFormulario"];
		
		$comentario="";
		if($tDictamen==1)
			$consulta="SELECT comentariosEvaluacion FROM 100_dictamenTecnicoProyectos WHERE idFormulario=".$idFormulario." AND idRegistro=".$idProyecto;
		else
			$consulta="SELECT comentarios FROM 100_dictamenPresupuestalProyectos WHERE idFormulario=".$idFormulario." AND idRegistro=".$idProyecto;
		$comentario=$con->obtenerValor($consulta);	
		echo "1|".$comentario;	
	}
	
	function modificarComentarioDictamen()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$tDictamen=$_POST["tDictamen"];
		$idFormulario=$_POST["idFormulario"];
		$comentario=$_POST["comentario"];
		$consulta="";
		if($tDictamen==1)
			$consulta="UPDATE 100_dictamenTecnicoProyectos SET comentariosEvaluacion='".cv($comentario)."' 
					WHERE idFormulario=".$idFormulario." AND idRegistro=".$idProyecto;
		else
			$consulta="UPDATE 100_dictamenPresupuestalProyectos SET comentarios='".cv($comentario)."' 
					WHERE idFormulario=".$idFormulario." AND idRegistro=".$idProyecto;
		eC($consulta);
	}
	
	function guardarTopeCategoria()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$monto=$_POST["monto"];
		$consulta="UPDATE _369_tablaDinamica SET topeCategoria=".$monto." WHERE id__369_tablaDinamica=".$idCategoria;
		eC($consulta);
		
	}
	
	function marcarProyectos()
	{
		global $con;
		$listProyectos=$_POST["cadProyectos"];
		$marca=$_POST["marca"];
		$consulta="update _370_tablaDinamica SET marcaAutorizado=".$marca." WHERE id__370_tablaDinamica IN (".$listProyectos.")";
		eC($consulta);
	}
	
	function enviarEmailOSC()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);

		$cuerpo=$obj->cuerpo;
		$asunto=$obj->asunto;
		$remitente="inap@grupolatis.net";
		$emisor="INAP";
		$arrCC[0][0]=$remitente;
		$arrCC[0][1]=$emisor;
		$arrProyectos=explode(",",$obj->listaProyectos);
		foreach($arrProyectos as $p)
		{
			$consulta="SELECT i.email,t.codigo FROM 247_instituciones i,817_organigrama o,_370_tablaDinamica t WHERE 
						i.idOrganigrama=o.idOrganigrama AND o.codigoUnidad=t.codigoInstitucion AND t.id__370_tablaDinamica=".$p;
			$fila=$con->obtenerPrimeraFila($consulta);
			$mail=$fila[0];
			if($mail!="")
				enviarMail($mail,$asunto,$cuerpo,$remitente,$emisor,NULL,$arrCC);
			else
			{
				echo "<br>No se pudo enviar el email al proyecto ".$fila[1]." debido que no cuenta con una direcci&oacute;n de correo electr&oacute;nico v&aacute;lida";
			}
		}
		echo "1|";
	}
	
	function guardarDetalleConcepto()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$detalle=$_POST["detalle"];
		$consulta="UPDATE 100_calculosGrid SET detalleConcepto='".cv($detalle)."' WHERE idGridVSCalculo=".$idConcepto;
		eC($consulta);
	}
	
	function obtenerDetalleConcepto()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		
		$consulta="select detalleConcepto from 100_calculosGrid WHERE idGridVSCalculo=".$idConcepto;
		$detalle=$con->obtenerValor($consulta);
		echo "1|".cv($detalle);

	}
	
	function obtenerComprobacionesEtapa()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$etapa=$_POST["etapa"];
		$consulta="".$idRegistro;
				
		$consulta="SELECT id__351_tablaDinamica as idComprobacion,c.calculo as concepto,txtImporte as montoComprobado,fechaCreacion as fechaRegistro,
					(SELECT group_concat(comentario SEPARATOR '<br><br>') FROM 2002_comentariosRegistro WHERE idFormulario=351  AND idRegistro=t.id__351_tablaDinamica) as comentario
					FROM _351_tablaDinamica t,100_calculosGrid c WHERE t.idReferencia=".$idRegistro." AND t.idEstado=".$etapa."  AND c.idGridVSCalculo=t.cmbConcepto";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerInformesTecnicos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$arrInformes="";
		$nRegistro=0;
		
		$maxInforme=9;
		$arrInforme=array();
		$nInformeAjuste=0;
		switch($idFormulario)
		{
			case 370:
				
				$maxInforme=9;
				$arrFechasMax=array();
				for($x=1;$x<$maxInforme;$x++)
				{
					
					array_push($arrInforme,$x);
					$arrFechasMax[$x]="2012-12-31";
				}
			break;
			
			case 410:
				$nInformeAjuste=8;
				$maxInforme=4;
				$consulta="SELECT noConvocatoria FROM _410_tablaDinamica WHERE id__410_tablaDinamica=".$idReferencia;
				$nConv=$con->obtenerValor($consulta);
				if($nConv==1)
					$maxInforme++;
					
				
				for($x=1;$x<$maxInforme;$x++)
				{
					array_push($arrInforme,$x);
				}

					
			break;
			case 448:
				$nInformeAjuste=4;
				$maxInforme=5;
				for($x=1;$x<$maxInforme;$x++)
				{
					$consulta="SELECT COUNT(*) FROM _481_periodoEvaluacion WHERE evaluacion=".$x." AND del<='".date("Y-m-d")."'";
					$nReg=$con->obtenerValor($consulta);
					if($nReg==0)
						continue;
					array_push($arrInforme,$x);
				}
			break;	
			case 464:
				$nInformeAjuste=4;
				array_push($arrInforme,1);
				array_push($arrInforme,2);
				array_push($arrInforme,3);
				
				
			break;	
			case 498:
			case 522:
				$nInformeAjuste=4;
				$maxInforme=5;
				$arrFechasMax=array();
				for($x=1;$x<$maxInforme;$x++)
				{
					$consulta="SELECT * FROM _481_periodoEvaluacion WHERE idFormulario=".$idFormulario." and  evaluacion=".$x." AND del<='".date("Y-m-d")."'";
					$fRegistro=$con->obtenerprimeraFila($consulta);
					
					if(!$fRegistro)
						continue;
					array_push($arrInforme,$x);
					$arrFechasMax[$x]=$fRegistro[4];
				}
			break;	
		}
		
		
		
		foreach($arrInforme as $x)
		{
			$consulta="SELECT * FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND noInforme=".$x;
			$fila=$con->obtenerPrimeraFila($consulta);
			$idRegistro=-1;
			$situacion=0;
			$fechaRegistro="";
			if($fila)
			{
				$idRegistro=$fila[0];
				$situacion=$fila[5];
				$fechaRegistro=$fila[3];
			}
			$lblInforme='Informe '.$x;
			
			if($nInformeAjuste==$x)
			{
				$lblInforme="Informe de ajuste";
			}
			

			$obj='{"maxFecha":"'.(isset($arrFechasMax[$x])?$arrFechasMax[$x]:'').'","idReporte":"'.$idRegistro.'","descripcion":"'.$lblInforme.'","mesInforme":"'.$x.'","situacion":"'.$situacion.'","fechaRealizacion":"'.$fechaRegistro.'"}';
			if($arrInformes=="")
				$arrInformes=$obj;
			else
				$arrInformes.=",".$obj;
			$nRegistro++;	
		}
		echo '{"numReg":"'.$nRegistro.'","registros":['.$arrInformes.']}';
		
		
	}
	
	function obtenerDatosInformeTecnico()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idRegistro=$_POST["idRegistro"];
		$mesInforme=$_POST["mesInforme"];

		/*if($idRegistro=="")
			$idRegistro=-1;*/
		$arrIndicadores="";
		$nInformeTecnico=0;
		$consulta="SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND noInforme<".$mesInforme." and situacion=3";
		$listInforme=$con->obtenerListaValores($consulta);
		if($listInforme=="")
			$listInforme=-1;
		switch($idFormulario)
		{
			case 370:	
					$consulta="SELECT COUNT(*) FROM _399_tablaDinamica WHERE folio=".$idReferencia." AND cmbPeriodo=".$mesInforme." AND cmbTipoBitacora=1 and responsable=".$_SESSION["idUsr"];
					$nInformeTecnico=$con->obtenerValor($consulta);
					$consulta="SELECT * FROM _374_tablaDinamica WHERE idReferencia=".$idReferencia;
					$res=$con->obtenerFilas($consulta);
					$fDatos=mysql_fetch_assoc($res);
					$fDatos["hEdadDe"]=removerCerosDerecha($fDatos["hEdadDe"]);
					$fDatos["hEdadHasta"]=removerCerosDerecha($fDatos["hEdadHasta"]);
					$fDatos["mEdadDe"]=removerCerosDerecha($fDatos["mEdadDe"]);
					$fDatos["mEdadHasta"]=removerCerosDerecha($fDatos["mEdadHasta"]);
					$consulta="SELECT idIndicador,texto,categoria,campo FROM 3000_indicadoresInforme ORDER BY categoria";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$txtIndicador=str_replace("@edadHIni",$fDatos["hEdadDe"],$fila[1]);
						$txtIndicador=str_replace("@edadHFin",$fDatos["hEdadHasta"],$txtIndicador);
						$txtIndicador=str_replace("@edadMIni",$fDatos["mEdadDe"],$txtIndicador);
						$txtIndicador=str_replace("@edadMFin",$fDatos["mEdadHasta"],$txtIndicador);
						if(($fDatos[$fila[3]]!="")&&($fDatos[$fila[3]]>0))
						{
							$acumulado=0;
							$cantidadAvance=0;
							$actividad="";
							$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
									idIndicadorActividad=".$fila[0]." AND idCategoria=".$fila[2]." AND tipoRegistro=2";
							$acumulado=$con->obtenerValor($consulta);		
							if($acumulado=="")
								$acumulado=0;
								
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme=".$idRegistro."
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=".$fila[2]." AND tipoRegistro=2";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($fDatos[$fila[3]]>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($txtIndicador)."','".$fDatos[$fila[3]]."','".$acumulado."','".$cantidadAvance."','".$actividad."','".$fila[2]."']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
					
					//Categoria 2
					
					$consulta="SELECT DISTINCT id__261_tablaDinamica,txtReferencia FROM _261_tablaDinamica t,_374_gridPoblacionAlcanzada p,_374_tablaDinamica b
								WHERE t.id__261_tablaDinamica=p.poblacionBlanco AND p.idReferencia=b.id__374_tablaDinamica AND b.idReferencia=".$idReferencia."
								ORDER BY id__261_tablaDinamica";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fila[0]." AND idCategoria=2 AND tipoRegistro=2";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						$consulta="SELECT SUM(cantidad) FROM _374_tablaDinamica t,_374_gridPoblacionAlcanzada g WHERE
									g.idReferencia=t.id__374_tablaDinamica AND t.idReferencia=".$idReferencia." AND g.poblacionBlanco=".$fila[0];
						$meta=$con->obtenerValor($consulta);			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme=".$idRegistro."
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=2 AND tipoRegistro=2";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($fila[1])."','".$meta."','".$acumulado."','".$cantidadAvance."','".$actividad."','2']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
				
					//Categoria 5
					
					$consulta="SELECT DISTINCT id__375_tablaDinamica,nombreIndicador FROM _375_tablaDinamica t,_374_gridIndicadores p,_374_tablaDinamica b
								WHERE t.id__375_tablaDinamica=p.indicador AND p.idReferencia=b.id__374_tablaDinamica AND b.idReferencia=".$idReferencia."
								ORDER BY id__375_tablaDinamica";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						$consulta="SELECT SUM(cantidad) FROM _374_tablaDinamica t,_374_gridIndicadores g WHERE
									g.idReferencia=t.id__374_tablaDinamica AND t.idReferencia=".$idReferencia." AND g.indicador=".$fila[0];
						$meta=$con->obtenerValor($consulta);			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme=".$idRegistro."
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($fila[1])."','".$meta."','".$acumulado."','".$cantidadAvance."','".$actividad."','5']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
					
					//Categoria 6
					
					$consulta="SELECT DISTINCT id__374_gridOtrosIndicadores,indicadorOtro,cantidad FROM _374_gridOtrosIndicadores p,_374_tablaDinamica b
								WHERE  p.idReferencia=b.id__374_tablaDinamica AND b.idReferencia=".$idReferencia."
								ORDER BY id__374_gridOtrosIndicadores";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fila[0]." AND idCategoria=6 AND tipoRegistro=2";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fila[2];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme=".$idRegistro."
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=6 AND tipoRegistro=2";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($fila[1])."','".$meta."','".$acumulado."','".$cantidadAvance."','".$actividad."','6']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
		
			break;
			case 410:
				$consulta="SELECT id__444_gridIndicadores,indicador,cantidad FROM _444_gridIndicadores g,_444_tablaDinamica t WHERE g.idReferencia=t.id__444_tablaDinamica AND t.idReferencia=".$idReferencia;
				$resIndicadores=$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					while($fila=mysql_fetch_row($resIndicadores))
					{
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=7";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fila[2];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in (".$idRegistro.")
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=7";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($fila[1])."','".removerCerosDerecha($meta)."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Indicador global','7']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
					
					$consulta="SELECT id__444_poblacionBlancoDirecta,CONCAT('[',p.txtclave,'] ',p.txtReferencia),edadInicio,edadFin,cantidad 
							FROM _444_poblacionBlancoDirecta g,_261_tablaDinamica p,_444_tablaDinamica t WHERE 
							g.idReferencia=t.id__444_tablaDinamica AND t.idReferencia=".$idReferencia." AND p.id__261_tablaDinamica=g.poblacionBlanco ORDER BY p.txtReferencia";
					$resPoblacion=$con->obtenerFilas($consulta);
					while($fPoblacion=mysql_fetch_row($resPoblacion))
					{
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fPoblacion[0]." AND idCategoria=5 AND tipoRegistro=8";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fPoblacion[4];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in (".$idRegistro.")
											AND idIndicadorActividad=".$fPoblacion[0]." AND idCategoria=5 AND tipoRegistro=8";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fPoblacion[0]."','".cv($fPoblacion[1])."  (Entre ".$fPoblacion[2]." y ".$fPoblacion[3]." años)"."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado).
									"','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco directa','8']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
					
					$consulta="SELECT id__444_gridPoblacionIndirecta,CONCAT('[',p.txtclave,'] ',p.txtReferencia),edadInicio,edadFin 
								FROM _444_gridPoblacionIndirecta g,_261_tablaDinamica p,_444_tablaDinamica t WHERE 
								g.idReferencia=t.id__444_tablaDinamica AND t.idReferencia=".$idReferencia." AND p.id__261_tablaDinamica=g.poblacionBlanco ORDER BY p.txtReferencia";
					$resPoblacion=$con->obtenerFilas($consulta);
					while($fPoblacion=mysql_fetch_row($resPoblacion))
					{
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fPoblacion[0]." AND idCategoria=5 AND tipoRegistro=9";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fPoblacion[4];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
											AND idIndicadorActividad=".$fPoblacion[0]." AND idCategoria=5 AND tipoRegistro=9";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fPoblacion[0]."','".cv($fPoblacion[1])." (Entre ".$fPoblacion[2]." y ".$fPoblacion[3]." años)"."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado).
									"','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco indirecta','9']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
					}
				}
				else
				{
					$consulta="SELECT CONCAT('(',t.txtclave,') ',t.txtReferencia),p.valor,r.txtGrupoEdad,valorMinimo,valorMaximo,p.idRangoEdad,p.idPoblacionBlanco FROM 110_poblacionBancoProyectos p,_261_tablaDinamica t,_411_tablaDinamica r 
										WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia." AND p.tipoPoblacion=1 AND t.id__261_tablaDinamica=p.idPoblacion AND r.id__411_tablaDinamica=p.idRangoEdad
										ORDER BY t.txtclave,t.txtReferencia,p.idRangoEdad";
					$resPoblacion=$con->obtenerFilas($consulta);
					while($fPoblacion=mysql_fetch_row($resPoblacion))
					{
						$lblComp=$fPoblacion[0];
						if($fPoblacion[5]!=3)
						{
							$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
						}
						else
							$lblComp.=" (".$fPoblacion[2].")";
						
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fPoblacion[6]." AND idCategoria=5 AND tipoRegistro=4";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fPoblacion[1];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
											AND idIndicadorActividad=".$fPoblacion[6]." AND idCategoria=5 AND tipoRegistro=4";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fPoblacion[6]."','".cv($lblComp)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco directa','4']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
						
					}
				
					$consulta="SELECT CONCAT('(',t.txtclave,') ',t.txtReferencia),p.valor,r.txtGrupoEdad,valorMinimo,valorMaximo,p.idRangoEdad,p.idPoblacionBlanco FROM 110_poblacionBancoProyectos p,_261_tablaDinamica t,_411_tablaDinamica r 
										WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia." AND p.tipoPoblacion=2 AND t.id__261_tablaDinamica=p.idPoblacion AND r.id__411_tablaDinamica=p.idRangoEdad
										ORDER BY t.txtclave,t.txtReferencia,p.idRangoEdad";
	
					$resPoblacion=$con->obtenerFilas($consulta);
					while($fPoblacion=mysql_fetch_row($resPoblacion))
					{
						$lblComp=$fPoblacion[0];
	
						if($fPoblacion[5]!=3)
						{
							$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
						}
						else
							$lblComp.=" (".$fPoblacion[2].")";
						
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fPoblacion[6]." AND idCategoria=5 AND tipoRegistro=5";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						
						$meta=$fPoblacion[1];			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
											AND idIndicadorActividad=".$fPoblacion[6]." AND idCategoria=5 AND tipoRegistro=5";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							if($meta>$acumulado)	
							{
								$obj="['".$fPoblacion[6]."','".cv($lblComp)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco indirecta','5']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
						
					}
					
					$consulta="SELECT DISTINCT id__375_tablaDinamica,nombreIndicador,t.numerador,t.denominador FROM _375_tablaDinamica t,109_indicadoresProyectos i
									WHERE t.id__375_tablaDinamica=i.idIndicador AND i.idFormulario=".$idFormulario." and i.idReferencia=".$idReferencia."
									ORDER BY id__375_tablaDinamica";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						
						$acumulado=0;
						$cantidadAvance=0;
						$actividad="";
						
						$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
								idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
						$acumulado=$con->obtenerValor($consulta);		
						if($acumulado=="")
							$acumulado=0;
						
						$consulta="SELECT SUM(numerador) FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and idIndicador=".$fila[0];
						$meta=$con->obtenerValor($consulta);			
						if($meta>0)
						{
							if($idRegistro!="-1")
							{
								$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
											AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
								$fRegistro=$con->obtenerPrimeraFila($consulta);
								if($fRegistro)
								{
									$cantidadAvance=$fRegistro[0];
									$actividad=$fRegistro[1];
								}
							}
							
							if($meta>$acumulado)	
							{
								$obj="['".$fila[0]."','".cv($fila[2])."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','".cv($fila[1])."','2']";	
								if($arrIndicadores=="")
									$arrIndicadores=$obj;
								else
									$arrIndicadores.=",".$obj;
							}
						}
						
						if($fila[3]!="")
						{
							$acumulado=0;
							$cantidadAvance=0;
							$actividad="";
							
							$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
									idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=3";
							$acumulado=$con->obtenerValor($consulta);		
							if($acumulado=="")
								$acumulado=0;
							
							$consulta="SELECT SUM(denominador) FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and idIndicador=".$fila[0];
							$meta=$con->obtenerValor($consulta);			
							if($meta>0)
							{
								if($idRegistro!="-1")
								{
									$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
												AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=3";
									$fRegistro=$con->obtenerPrimeraFila($consulta);
									if($fRegistro)
									{
										$cantidadAvance=$fRegistro[0];
										$actividad=$fRegistro[1];
									}
								}
								if($meta>$acumulado)	
								{
									$obj="['".$fila[0]."','".cv($fila[3])."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','".cv($fila[1])."','3']";	
									if($arrIndicadores=="")
										$arrIndicadores=$obj;
									else
										$arrIndicadores.=",".$obj;
								}
							}
						}
					}
				}
			break;
			case 448:
				$consulta="SELECT CONCAT('(',t.txtclave,') ',t.txtReferencia),p.beneficiariosDirectos,r.txtGrupoEdad,valorMinimo,valorMaximo,p.idRangoEdad,p.idPoblacionBlanco FROM 112_poblacionBlancoProyectos2014 p,_261_tablaDinamica t,_411_tablaDinamica r 
									WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.idPoblacionBlanco AND r.id__411_tablaDinamica=p.idRangoEdad
									ORDER BY t.txtclave,t.txtReferencia,p.idRangoEdad";
				$resPoblacion=$con->obtenerFilas($consulta);
				while($fPoblacion=mysql_fetch_row($resPoblacion))
				{
					$lblComp=$fPoblacion[0];
					if($fPoblacion[5]!=3)
					{
						$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
					}
					else
						$lblComp.=" (".$fPoblacion[2].")";
					
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." AND idCategoria=5 AND tipoRegistro=4";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fPoblacion[1];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." AND idCategoria=5 AND tipoRegistro=4";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						if($meta>$acumulado)	
						{
							$obj="['".$fPoblacion[6]."_".$fPoblacion[5]."','".cv($lblComp)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco directa','4']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
					
				}
			
				$consulta="SELECT CONCAT('(',t.txtclave,') ',t.txtReferencia),p.beneficiariosIndirectos,r.txtGrupoEdad,valorMinimo,valorMaximo,p.idRangoEdad,p.idPoblacionBlanco FROM 112_poblacionBlancoProyectos2014 p,_261_tablaDinamica t,_411_tablaDinamica r 
									WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia."  AND t.id__261_tablaDinamica=p.idPoblacionBlanco AND r.id__411_tablaDinamica=p.idRangoEdad
									ORDER BY t.txtclave,t.txtReferencia,p.idRangoEdad";

				$resPoblacion=$con->obtenerFilas($consulta);
				
				while($fPoblacion=mysql_fetch_row($resPoblacion))
				{
					$lblComp=$fPoblacion[0];

					if($fPoblacion[5]!=3)
					{
						$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
					}
					else
						$lblComp.=" (".$fPoblacion[2].")";
					
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." AND idCategoria=5 AND tipoRegistro=5";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fPoblacion[1];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." AND idCategoria=5 AND tipoRegistro=5";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						if($meta>$acumulado)	
						{
							$obj="['".$fPoblacion[6]."_".$fPoblacion[5]."','".cv($lblComp)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco indirecta','5']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
					
				}
				
				$consulta="SELECT DISTINCT t.idIndicador,t.nombreIndicador FROM 1026_catalogoIndicadores2014 t,109_indicadoresProyectos i
								WHERE t.idIndicador=i.idIndicador AND i.idFormulario=".$idFormulario." and i.idReferencia=".$idReferencia."
								ORDER BY t.nombreIndicador";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					$consulta="SELECT SUM(numerador) FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and idIndicador=".$fila[0];
					$meta=$con->obtenerValor($consulta);			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						
						if($meta>$acumulado)	
						{
							$obj="['".$fila[0]."','".cv($fila[1])."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Indicadores del proyecto','2']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
				}
				
				
				
			break;
			case 464:
				$consulta="SELECT meta,cantidad,m.idRegistro FROM 114_metasProyectos2014 m,113_objetivosEspecificos o,112_objetivoGeneral g WHERE 
							m.idObjetivoEspecifico=o.idRegistro AND o.idObjetivoGeneral=g.idObjetivoGeneral AND g.idFormulario=".$idFormulario." AND g.idReferencia=".$idReferencia;
				$resMeta=$con->obtenerFilas($consulta);
				while($fMeta=mysql_fetch_row($resMeta))
				{
					$lblComp=$fMeta[0];
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fMeta[2]." and idCategoria=7 AND tipoRegistro=2";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fMeta[1];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fMeta[2]."  AND idCategoria=7 AND tipoRegistro=2";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						if($meta>$acumulado)	
						{
							$obj="['".$fMeta[2]."','".cv($lblComp)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','7','7']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
					
				}
			break;
			case 498:
			
				$tamanoLinea=55;
				$consulta="SELECT concat('[Hombres].- ',p.lblPoblacion) as lblPoblacion,p.totalHombresD,r.txtGrupoEdad,valorMinimo,valorMaximo,
							p.rangoEdad,p.iPoblacionBlanco,'1' as auxiliar 	FROM _498_gPoblacionBlancoDirecta p,_261_tablaDinamica t,_411_tablaDinamica r 
							WHERE  p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.iPoblacionBlanco AND r.id__411_tablaDinamica=p.rangoEdad
							union		
							SELECT concat('[Mujeres].- ',p.lblPoblacion) as lblPoblacion,p.totalMujeresD,r.txtGrupoEdad,valorMinimo,valorMaximo,
							p.rangoEdad,p.iPoblacionBlanco,'2' as auxiliar 	FROM _498_gPoblacionBlancoDirecta p,_261_tablaDinamica t,_411_tablaDinamica r 
							WHERE  p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.iPoblacionBlanco AND r.id__411_tablaDinamica=p.rangoEdad		
							ORDER BY lblPoblacion,rangoEdad";
				$resPoblacion=$con->obtenerFilas($consulta);
				while($fPoblacion=mysql_fetch_row($resPoblacion))
				{
					$lblComp=$fPoblacion[0];
					if($fPoblacion[5]!=3)
					{
						$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
					}
					else
						$lblComp.=" (".$fPoblacion[2].")";
					
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." and auxiliar2=".$fPoblacion[7]." AND idCategoria=5 AND tipoRegistro=4";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fPoblacion[1];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." and auxiliar2=".$fPoblacion[7]." AND idCategoria=5 AND tipoRegistro=4";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						
						
						
						$lblEnter="";
						$tam=0;
						for($nPos=0;$nPos<strlen($lblComp);$nPos++)
						{
							$lblEnter.=$lblComp[$nPos];
							$tam++;
							if($tam>$tamanoLinea)
							{
								$lblEnter.="<br>";
								$tam=0;
							}
						}
						
						if($meta>$acumulado)	
						{
							$obj="['".$fPoblacion[6]."_".$fPoblacion[5]."_".$fPoblacion[7]."','".cv($lblEnter)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco directa','4']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
					
				}
			
				$consulta="SELECT concat('[Hombres].- ',p.lblPoblacion) as lblPoblacion,p.totalHombresI,r.txtGrupoEdad,valorMinimo,valorMaximo,
							p.rangoEdad,p.iPoblacionBlanco,'1' as auxiliar 	FROM _498_gPoblacionBlancoDirecta p,_261_tablaDinamica t,_411_tablaDinamica r 
							WHERE  p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.iPoblacionBlanco AND r.id__411_tablaDinamica=p.rangoEdad
							union		
							SELECT concat('[Mujeres].- ',p.lblPoblacion) as lblPoblacion,p.totalMujeresI,r.txtGrupoEdad,valorMinimo,valorMaximo,
							p.rangoEdad,p.iPoblacionBlanco,'2' as auxiliar 	FROM _498_gPoblacionBlancoDirecta p,_261_tablaDinamica t,_411_tablaDinamica r 
							WHERE  p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.iPoblacionBlanco AND r.id__411_tablaDinamica=p.rangoEdad		
							ORDER BY lblPoblacion,rangoEdad";

				$resPoblacion=$con->obtenerFilas($consulta);
				
				while($fPoblacion=mysql_fetch_row($resPoblacion))
				{
					$lblComp=$fPoblacion[0];

					if($fPoblacion[5]!=3)
					{
						$lblComp.=" (".$fPoblacion[2]." de ".$fPoblacion[3]." a ".$fPoblacion[4]." años)";
					}
					else
						$lblComp.=" (".$fPoblacion[2].")";
					
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." and auxiliar2=".$fPoblacion[7]." AND idCategoria=5 AND tipoRegistro=5";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fPoblacion[1];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fPoblacion[6]." and auxiliar=".$fPoblacion[5]." and auxiliar2=".$fPoblacion[7]." AND idCategoria=5 AND tipoRegistro=5";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						
						$lblEnter="";
						$tam=0;
						for($nPos=0;$nPos<strlen($lblComp);$nPos++)
						{
							$lblEnter.=$lblComp[$nPos];
							$tam++;
							if($tam>$tamanoLinea)
							{
								$lblEnter.="<br>";
								$tam=0;
							}
						}
						
						
						if($meta>$acumulado)	
						{
							$obj="['".$fPoblacion[6]."_".$fPoblacion[5]."_".$fPoblacion[7]."','".cv($lblEnter)."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Población blanco indirecta','5']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
					
				}
				
				$consulta="SELECT DISTINCT idIndicador,i.nombreIndicador,cantidad FROM 112_objetivoGeneral o,113_objetivosEspecificos e,
							971_objetivosEspecificosVSIndicadores oi,_375_tablaDinamica i WHERE  oi.idFormulario=".$idFormulario.
							" AND oi.idReferencia=".$idReferencia." AND e.idObjetivoGeneral=o.idObjetivoGeneral AND oi.idObjetivo=e.idRegistro AND 
							i.id__375_tablaDinamica=oi.idIndicador ORDER BY i.nombreIndicador";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fila[2];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						
						
						
						
						
						
						if($meta>$acumulado)	
						{
							$obj="['".$fila[0]."','".cv($fila[1])."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Indicadores del proyecto','2']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
				}
				
				
				
			break;
			
			case 522:
			
				
				
				$consulta="SELECT DISTINCT idIndicador,i.nombreIndicador,cantidad FROM 112_objetivoGeneral o,113_objetivosEspecificos e,
							971_objetivosEspecificosVSIndicadores oi,_375_tablaDinamica i WHERE  oi.idFormulario=".$idFormulario.
							" AND oi.idReferencia=".$idReferencia." AND e.idObjetivoGeneral=o.idObjetivoGeneral AND oi.idObjetivo=e.idRegistro AND 
							i.id__375_tablaDinamica=oi.idIndicador ORDER BY i.nombreIndicador";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$acumulado=0;
					$cantidadAvance=0;
					$actividad="";
					
					$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
							idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
					$acumulado=$con->obtenerValor($consulta);		
					if($acumulado=="")
						$acumulado=0;
					
					
					$meta=$fila[2];			
					if($meta>0)
					{
						if($idRegistro!="-1")
						{
							$consulta="SELECT cantidadAvance,idActividadAsociada FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in(".$idRegistro.")
										AND idIndicadorActividad=".$fila[0]." AND idCategoria=5 AND tipoRegistro=2";
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							if($fRegistro)
							{
								$cantidadAvance=$fRegistro[0];
								$actividad=$fRegistro[1];
							}
						}
						
						
						
						
						
						
						if($meta>$acumulado)	
						{
							$obj="['".$fila[0]."','".cv($fila[1])."','".removerCerosDerecha(number_format($meta))."','".removerCerosDerecha($acumulado)."','".removerCerosDerecha($cantidadAvance)."','".$actividad."','Indicadores del proyecto','2']";	
							if($arrIndicadores=="")
								$arrIndicadores=$obj;
							else
								$arrIndicadores.=",".$obj;
						}
					}
				}
				
				
				
			break;
			
			
		}
		//Actividades
		
		$arrActividades="";
		
		$consulta="SELECT idActividadPrograma,actividad,cantidadAvance,evidencia,idRegistro,d.idComprobante,d.idComprobante,d.nombreArchivo FROM 965_actividadesUsuario a,3000_detalleInformeTecnico d  WHERE 
				  d.idRegistroInforme in (".$idRegistro.") and d.idIndicadorActividad=a.idActividadPrograma and tipoRegistro=1 ORDER BY actividad";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$acumulado=0;
			$cantidadAvance=0;
			$actividad="";
			$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
					idIndicadorActividad=".$fila[0]." AND tipoRegistro=1";
			$acumulado=$con->obtenerValor($consulta);		
			if($acumulado=="")
				$acumulado=0;
			
			
			$idRegistroArchivo="";
			if($idRegistro!="-1")
			{
				$consulta="SELECT cantidadAvance,idActividadAsociada,idRegistro FROM 3000_detalleInformeTecnico WHERE idRegistroInforme in (".$idRegistro.")
							AND idIndicadorActividad=".$fila[0]." AND idCategoria=6 AND tipoRegistro=1";
				$fRegistro=$con->obtenerPrimeraFila($consulta);
				if($fRegistro)
				{
					$cantidadAvance=$fRegistro[0];
					$actividad=$fRegistro[1];
					
				}
			}
			$idRegistroArchivo=$fila[4];
			if($fila[5]=="")
				$idRegistroArchivo="";
			$obj="['".$fila[0]."','".cv($fila[1])."','".$acumulado."','".cv($fila[2])."','".cv($fila[3])."','".$idRegistroArchivo."','".$fila[6]."','".$fila[7]."']";	

			if($arrActividades=="")
				$arrActividades=$obj;
			else
				$arrActividades.=",".$obj;	
			
		}
		$arrListaActividades="";
		$consulta="SELECT idActividadPrograma,actividad FROM 965_actividadesUsuario a WHERE 
				  	idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." ORDER BY actividad";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$acumulado=0;
			$cantidadAvance=0;
			$actividad="";
			$consulta="SELECT SUM(cantidadAvance) FROM 3000_detalleInformeTecnico WHERE idRegistroInforme IN(".$listInforme.") AND 
					idIndicadorActividad=".$fila[0]." AND tipoRegistro=1";
			$acumulado=$con->obtenerValor($consulta);	
			if($acumulado=="")
				$acumulado=0;
			$obj="['".$fila[0]."','".cv($fila[1])."','".$acumulado."']";
			if($arrListaActividades=="")	
				$arrListaActividades=$obj;
			else
				$arrListaActividades.=",".$obj;
		}
		$logros="";
		$obstaculos="";
		$idInformeTecnico="";
		$nombreInformeTecnico="";
		$idInformeFinanciero="";
		$nombreInformeFinanciero="";
		$idCartaCumplimiento="";
		$nombreArchivoCartaCumplimiento="";
		if($idRegistro!=-1)
		{
			$consulta="SELECT logrosObtenidos,obtaculos,idResumenTecnico,nombreArchivoResumenTecnico,idResumenFinanciero,nombreArchivoResumenFinanciero,idCartaCumplimiento,nombreArchivoCartaCumplimiento 
						FROM 3000_informesTecnicos WHERE idInforme in(".$idRegistro.")";

			$fReg=$con->obtenerPrimeraFila($consulta);
			$logros=($fReg[0]);
			$obstaculos=($fReg[1]);
			$idInformeTecnico=$fReg[2];
			$nombreInformeTecnico=$fReg[3];
			$idInformeFinanciero=$fReg[4];
			$nombreInformeFinanciero=$fReg[5];
			$idCartaCumplimiento=$fReg[6];
			$nombreArchivoCartaCumplimiento=$fReg[7];
		}
		
		
		$cObjInformes='{"idInformeTecnico":"'.$idInformeTecnico.'","nombreInformeTecnico":"'.$nombreInformeTecnico.
						'","idInformeFinanciero":"'.$idInformeFinanciero.'","nombreInformeFinanciero":"'.$nombreInformeFinanciero.
						'","idCartaCumplimiento":"'.$idCartaCumplimiento.'","nombreArchivoCartaCumplimiento":"'.$nombreArchivoCartaCumplimiento.'"}';
		
		
		$consulta="select count(*) from 3001_evaluacionesInformeTecnico WHERE idInforme in(".$idRegistro.")";
		$nComentarios=$con->obtenerValor($consulta);
		
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=1;
		$arrEvaluaciones[3]=1;
		$arrEvaluaciones[4]=2;
		$arrEvaluaciones[5]=2;

		$arrEvaluaciones[6]=2;
		$arrEvaluaciones[7]=2;	
		$arrEvaluaciones[8]=2;		
		$idEvaluacion=$arrEvaluaciones[$mesInforme];
		$consulta="SELECT resultadoEvaluacion FROM 3002_evaluacionesFinales WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and noEvaluacion=".$idEvaluacion." ORDER BY idEvaluacionFinal desc limit 0,1";
		$resEval=$con->obtenerValor($consulta);
		if($resEval=="")
			$resEval=0;
		
		echo "1|[".$arrActividades."]|[".$arrIndicadores."]|[".$arrListaActividades."]|".bE($logros)."|".bE($obstaculos)."|".$nComentarios."|".$nInformeTecnico."|".$resEval."|".$idEvaluacion."|".$cObjInformes;
	}
	
	function guardarInformeTecnico()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$fechaRegistro=date("Y-m-d H:i");
		
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 3000_informesTecnicos(idFormulario,idReferencia,fechaRegistro,responsableRegistro,
						situacion,noInforme,logrosObtenidos,obtaculos,fechaUltimaModificacion,idResumenTecnico,nombreArchivoResumenTecnico,
						idResumenFinanciero,nombreArchivoResumenFinanciero,idCartaCumplimiento,nombreArchivoCartaCumplimiento) VALUES(".$obj->idFormulario.
						",".$obj->idReferencia.",'".$fechaRegistro."',".$_SESSION["idUsr"].",1,".$obj->mesInforme.",'".cv($obj->logros).
						"','".cv($obj->obstaculos)."','".$fechaRegistro."','".$obj->idArchivo2."','".$obj->nombreArchivo2."','".
						$obj->idArchivo3."','".$obj->nombreArchivo3."','".$obj->idArchivo4."','".$obj->nombreArchivo4."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			
			
			if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo2))
			{
				if(copy($baseDir."/archivosTemporales/".$obj->idArchivo2,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo2))
					unlink($baseDir."/archivosTemporales/".$obj->idArchivo2);
			}
			
			if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo3))
			{
				if(copy($baseDir."/archivosTemporales/".$obj->idArchivo3,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo3))
					unlink($baseDir."/archivosTemporales/".$obj->idArchivo3);
			}
			
			if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo4))
			{
				if(copy($baseDir."/archivosTemporales/".$obj->idArchivo4,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo4))
					unlink($baseDir."/archivosTemporales/".$obj->idArchivo4);
			}
			
			
		}
		else
		{
			$situacion=1;
			$query="SELECT situacion,idCartaCumplimiento FROM 3000_informesTecnicos WHERE idInforme=".$obj->idRegistro;
			$fInforme=$con->obtenerPrimeraFila($query);
			if($fInforme[1]=="")
				$situacion=$fInforme[0];
			
			$consulta[$x]="update 3000_informesTecnicos set situacion=".$situacion.",logrosObtenidos='".cv($obj->logros)."',obtaculos='".cv($obj->obstaculos).
						 "',fechaUltimaModificacion='".date("Y-m-d H:i")."' where idInforme=".$obj->idRegistro;
						
			$x++;
			
			if($obj->idArchivo2!="")
			{
				if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo2))
				{
					if(copy($baseDir."/archivosTemporales/".$obj->idArchivo2,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo2))
						unlink($baseDir."/archivosTemporales/".$obj->idArchivo2);
						
						
						
					$consulta[$x]="update 3000_informesTecnicos set idResumenTecnico='".$obj->idArchivo2."',nombreArchivoResumenTecnico='".$obj->nombreArchivo2."' where idInforme=".$obj->idRegistro;
					$x++;	
						
				}
			}
			
			
			if($obj->idArchivo3!="")
			{
				if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo3))
				{
					if(copy($baseDir."/archivosTemporales/".$obj->idArchivo3,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo3))
						unlink($baseDir."/archivosTemporales/".$obj->idArchivo3);
						
						
					$consulta[$x]="update 3000_informesTecnicos set idResumenFinanciero='".$obj->idArchivo3."',nombreArchivoResumenFinanciero='".$obj->nombreArchivo3."' where idInforme=".$obj->idRegistro;
					$x++;		
				}
			}
			
			if($obj->idArchivo4!="")
			{
				if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo4))
				{
					if(copy($baseDir."/archivosTemporales/".$obj->idArchivo4,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo4))
						unlink($baseDir."/archivosTemporales/".$obj->idArchivo4);
						
						
					$consulta[$x]="update 3000_informesTecnicos set idCartaCumplimiento='".$obj->idArchivo4."',nombreArchivoCartaCumplimiento='".$obj->nombreArchivo4."' where idInforme=".$obj->idRegistro;
					$x++;		
				}
			}
			
			
			
			if(sizeof($obj->arrActividades)>0)
			{
				foreach($obj->arrActividades as $o)
				{
					$query="SELECT idComprobante FROM 3000_detalleInformeTecnico WHERE idRegistroInforme=".$obj->idRegistro." AND idIndicadorActividad=".$o->indicador." AND tipoRegistro=1";
					$idComprobante=$con->obtenerValor($query);
					if($idComprobante!=$o->idArchivo)
					{
						if(($idComprobante!="")&&(file_exists($baseDir."/modulosEspeciales_Censida/documentosInformes/".$idComprobante)))
							unlink($baseDir."/modulosEspeciales_Censida/documentosInformes/".$idComprobante);
					}
				}
			}
			$consulta[$x]="delete from 3000_detalleInformeTecnico where idRegistroInforme=".$obj->idRegistro;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
			
			
			
			
		}
		
		
		
		
		
		if(sizeof($obj->arrActividades)>0)
		{
			foreach($obj->arrActividades as $o)
			{
				
				if($o->idArchivo!="")
				{
					if(file_exists($baseDir."/archivosTemporales/".$o->idArchivo))
					{
						if(copy($baseDir."/archivosTemporales/".$o->idArchivo,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$o->idArchivo))
							unlink($baseDir."/archivosTemporales/".$o->idArchivo);
					}
				}
				$consulta[$x]="INSERT INTO 3000_detalleInformeTecnico(idCategoria,idIndicadorActividad,idRegistroInforme,
								cantidadAvance,idActividadAsociada,evidencia,idComprobante,tipoRegistro,nombreArchivo) 
							VALUES(NULL,".$o->indicador.",@idRegistro,".$o->avance.",NULL,'".cv($o->evidencia)."','".$o->idArchivo."',1,'".cv($o->nomDocumento)."')";
				$x++;
			}
		}
		
		if(sizeof($obj->arrIndicadores)>0)
		{
			foreach($obj->arrIndicadores as $o)
			{
				$auxiliar=-1;
				$auxiliar2=-1;
				if(strpos($o->indicador,"_")!==false)
				{
					$aAuxiliar=explode("_",$o->indicador);
					$auxiliar=$aAuxiliar[1];
					$o->indicador=$aAuxiliar[0];
					if(isset($aAuxiliar[2]))
						$auxiliar2=$aAuxiliar[2];
				}
				$consulta[$x]="INSERT INTO 3000_detalleInformeTecnico(idCategoria,idIndicadorActividad,idRegistroInforme,
								cantidadAvance,idActividadAsociada,evidencia,idComprobante,tipoRegistro,auxiliar,auxiliar2) 
							VALUES(".$o->idCategoria.",".$o->indicador.",@idRegistro,".$o->avance.",".$o->actividad.
							",NULL,NULL,".$o->tipoRegistro.",".$auxiliar.",".$auxiliar2.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function obtenerMunicipios()
	{
		global $con;
		$estado=$_POST["estado"];
		$consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$estado."' ORDER BY municipio";
		$arrMunicipios=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrMunicipios;
	}
	
	function guardarDatosProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="select razonSocial from 595_proveedores where rfc1='".$obj->rfc1."' and rfc2='".$obj->rfc2."' and rfc3='".$obj->rfc3."'";
		
		$nRegistro=$con->obtenerValor($consulta);
		if($nRegistro!="")
		{
			echo "2|";
			return;
		}
		
		$consulta="insert into 595_proveedores(rfc1,rfc2,rfc3,razonSocial,calle,numero,colonia,cp,estado,municipio) 
					VALUES('".$obj->rfc1."','".$obj->rfc2."','".$obj->rfc3."','".cv($obj->razonSocial)."','".cv($obj->calle)."','".
					cv($obj->numero)."','".cv($obj->colonia)."',".$obj->cp.",'".$obj->estado."','".$obj->municipio."')";
		if($con->ejecutarConsulta($consulta))
		{
			$idProveedor=$con->obtenerUltimoID();
			$nRegistro=$obj->razonSocial;
			echo "1|".$idProveedor."|".$nRegistro;
		}
	}
	
	function obtenerDatosProveedor()
	{
		global $con;
		$rfc1=$_POST["rfc1"];
		$rfc2=$_POST["rfc2"];
		$rfc3=$_POST["rfc3"];
		$consulta="select * from 595_proveedores where rfc1='".$rfc1."' and rfc2='".$rfc2."' and rfc3='".$rfc3."'";

		$fDatos=$con->obtenerPrimeraFila($consulta);
		
		if($fDatos)
		{
			$consulta="select estado FROM 820_estados WHERE cveEstado='".$fDatos[9]."'";
			$estado=$con->obtenerValor($consulta);
			$consulta="select municipio FROM 821_municipios WHERE cveMunicipio='".$fDatos[10]."'";
			$municipio=$con->obtenerValor($consulta);
			if($fDatos[8]=="")
				$fDatos[8]="N/E";
			if($fDatos[7]=="")
				$fDatos[7]="N/E";	

			$cadDireccion='Calle '.cv($fDatos[5]).' No. '.$fDatos[6].' Col. '.$fDatos[7].' C.P. '.$fDatos[8].'. '.$municipio.','.$estado;
			$cadObj='{"idProveedor":"'.$fDatos[0].'","razonSocial":"'.cv($fDatos[4]).'","direccion":"'.$cadDireccion.'"}';
			echo "1|".$cadObj;
			return;	
		}
		echo "2|";	
		return;
		
	}
	
	
	function obtenerComprobantesDocumento()
	{
		global $con;
		
		$arrSituacion[0]="En espera de evaluaci&oacute;n (CENSIDA)";
		$arrSituacion[1]="Aceptado";
		$arrSituacion[2]="Rechazado";
		$arrSituacion[3]="En espera de validación ante SAT";
		$arrSituacion[4]="Se solicita más detalles";
		
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idReferencia"];
		
		$situacion="0,1,2,3,4";
		if(isset($_POST["situacion"]))
			$situacion=$_POST["situacion"];
		
		$arrRegistro="";
		$consulta="SELECT idFactura,tipoComprobante,folioComprobante,fechaCreacion,situacion,montoComprobacion,idFactura,p.razonSocial,CONCAT(p.rfc1,'-',p.rfc2,'-',p.rfc3) AS rfc 
				FROM 101_comprobantesPresupuestales c,595_proveedores p WHERE p.idProveedor=c.idProveedor and c.idFormulario=".$idFormulario." 
				AND c.idReferencia=".$idRegistro." and c.situacion in (".$situacion.")";
				
		$validarSituacion=false;		
				
		if(($situacion==2)||($situacion==4))		
		{
			$consulta.=" and c.folioComprobante NOT IN (SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND 
						situacion=1 AND tipoComprobante IN(7,10))";

		}
		else
			$validarSituacion=true;
				
		$res=$con->obtenerFilas($consulta);
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$agregar=true;
			if(($validarSituacion)&&(($fila[1]==7)||($fila[1]==10)))
			{
				if(($fila[4]==2)||($fila[4]==4))
				{
					$consulta="select count(*) from 101_comprobantesPresupuestales where folioComprobante='".$fila[2]."' and situacion=1";
					$nReg=$con->obtenerValor($consulta);
					if($nReg>0)
						$agregar=false;
				}
				
					
			}
			
			if($agregar	)
			{
				$descripcion="";
				$obj='{"descripcion":"'.cv($descripcion).'","idComprobacion":"'.$fila[0].'","tipoComprobante":"'.$fila[1].'","rfc":"'.$fila[8].'","proveedor":"'.cv($fila[7]).'","folio":"'.$fila[2].
						'","fechaRegistro":"'.$fila[3].'","montoComprobacion":"'.$fila[5].'","situacion":"'.$arrSituacion[$fila[4]].'","docComprobatorio":"'.$fila[6].'"}';
				if($arrRegistro=="")
					$arrRegistro=$obj;
				else
					$arrRegistro.=",".$obj;
				$ct++;
				
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrRegistro.']}';
	}
	
	function obtenerConceptoComprobar()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idReferencia"];
		$rubro=$_POST["rubro"];
		$consulta="SELECT idGridVSCalculo,calculo,montoAutorizado as total,idConcepto,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion 
					WHERE idConcepto=c.idGridVSCalculo AND situacion=1) as montoTotal FROM  100_calculosGrid c WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idRubro=".$rubro;
		$res=$con->obtenerFilas($consulta);
		$arrConceptos="";
		while($fila=mysql_fetch_row($res))
		{
			$nConcepto=$fila[1];
			if($fila[3]!="")
			{
				$consulta="SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=".$fila[3];
				$nCategoria=$con->obtenerValor($consulta);
				if($nCategoria!="")
					$nConcepto="[".$nCategoria."] ".$nConcepto;
			}
			if($fila[4]=="")
				$fila[4]=0;
			$diferencia=$fila[2]-$fila[4];
				
			$nConcepto.=" (Por comprobar: $ ".number_format($diferencia,2).")"	;
			if($diferencia>0)
			{
				$obj="['".$fila[0]."','".cv($nConcepto)."','".$fila[2]."_".$fila[4]."']";
				if($arrConceptos=="")
					$arrConceptos=$obj;
				else
					$arrConceptos.=",".$obj;
			}
		}
		
		$consulta="SELECT codigo FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$folio=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(*) FROM 1045_proyectosCerradoComprobacion WHERE proyecto='".$folio."'";
		$ProyCerrado=$con->obtenerValor($consulta);
		if($rubro=="0")
			$arrConceptos="['0','Reintegro']";
		echo "1|[".$arrConceptos."]";
	}
	
	function guardarComprobacion()
	{
		global $con;
		global $baseDir;
		$permitirValidacionResponsable=true;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$query="select idEstado from _410_tablaDinamica where id__410_tablaDinamica=".$obj->idReferencia;
		$idEstado=$con->obtenerValor($query);
		if($idEstado!=11)
		{
			echo "El periodo de comprobaci&oacute;n financiera ha expirado";
			return;	
		}
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if(copy($baseDir."/archivosTemporales/".$obj->idComprobante,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idComprobante))
		{
			unlink($baseDir."/archivosTemporales/".$obj->idComprobante);
		}
		$situacionComprobaciones=0;
		if($obj->idProveedor!=-1)
		{
			$consulta[$x]="set @idProveedor:=".$obj->idProveedor;
			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 595_proveedores(razonSocial,calle) VALUES('".cv($obj->proveedor)."','".cv($obj->direccion)."')";
			$x++;
			$consulta[$x]="set @idProveedor:=(select last_insert_id())";
			$x++;
			
		}
		$estadoComprobante=0;
		$situacion="0";
		$caidaSAT=false;
		$anioAprobacion="NULL";
		if($obj->anioAprobacion!="")
			$anioAprobacion=$obj->anioAprobacion;
			
		switch($obj->tComprobante)
		{
			
			//case 4:
			case 5:
			case 6:
				if($obj->noAprobacion!="")
				{
					$query="SELECT CONCAT(rfc1,rfc2,rfc3) FROM 595_proveedores WHERE idProveedor=".$obj->idProveedor;
					$rfc=$con->obtenerValor($query);
					$salir=false;
					$nChecadas=0;
					
					while(!$salir)
					{
						$res=verificarComprobanteSATSelloDigital($rfc,$obj->tComprobante,$obj->noSerie,$obj->folio,$obj->noAprobacion);
						switch($res)
						{
							case "0":
								$situacion=4;
								$salir=true;
								$estadoComprobante=0;
							break;
							case "1":
								$estadoComprobante=0;
								$situacion=5;
								$salir=true;
							break;
							case "2":
								$nChecadas++;
								sleep(3);
								if($nChecadas>3)
								{
									$salir=true;
									$situacion=0;
									$caidaSAT=true;
									if($permitirValidacionResponsable)
										$estadoComprobante=0;
									else
									{
										$estadoComprobante=3;
										$situacionComprobaciones=3;
									}
								}
							break;
						}
					}
				}
			break;
			case 1:
			case 2:
			case 4:
			case 3:
				$estadoComprobante=0;
			break;
			case 7:
				if($permitirValidacionResponsable)
					$estadoComprobante=0;
			break;
			case 8:
				if($permitirValidacionResponsable)
					$estadoComprobante=0;
			break;
		}
		
		/*$consulta[$x]="INSERT INTO 101_comprobantesPresupuestales(idProveedor,tipoComprobante,folioComprobante,numeroAprobacion,
						idComprobante,nombreArchivo,fechaCreacion,situacion,montoComprobacion,idFormulario,idReferencia,iva,noSerie,validacionSAT,anioAprobacion,fechaComprobante)
						VALUES(@idProveedor,".$obj->tComprobante.",'".$obj->folio."','".$obj->noAprobacion."','".$obj->idComprobante."','".
						cv($obj->nombreArchivo)."','".date("Y-m-d H:i")."',".$estadoComprobante.",".$obj->montoComprobacion.",".$obj->idFormulario.",".$obj->idReferencia.",".($obj->iva).",'".cv($obj->noSerie)."',".$situacion.",".$anioAprobacion.",'".$obj->fechaComprobante."')";
		$x++;	*/
		
		
		$consulta[$x]="INSERT INTO 101_comprobantesPresupuestales(idProveedor,tipoComprobante,folioComprobante,numeroAprobacion,
						idComprobante,nombreArchivo,fechaCreacion,situacion,montoComprobacion,idFormulario,idReferencia,iva,noSerie,validacionSAT,anioAprobacion,fechaComprobante)
						VALUES(@idProveedor,".$obj->tComprobante.",'".$obj->folio."','".$obj->noAprobacion."','".$obj->idComprobante."','".
						cv($obj->nombreArchivo)."','".date("Y-m-d H:i")."',".$estadoComprobante.",".$obj->montoComprobacion.",".$obj->idFormulario.",".$obj->idReferencia.",".($obj->iva).",'".cv($obj->noSerie)."',".$situacion.",".$anioAprobacion.",'".date("Y-m-d")."')";
		$x++;	
							
		$consulta[$x]="set @idFactura:=(select last_insert_id())";
		$x++;
		if($caidaSAT)
		{
			$consulta[$x]="INSERT INTO 105_caidasSAT(idFactura,fechaCaida) VALUES(@idFactura,'".date("Y-m-d H:i")."')";
			$x++;
		}
		foreach($obj->arrConceptos as $o)
		{
			$consulta[$x]="INSERT INTO 102_conceptosComprobacion(idConcepto,descripcion,montoComprobacion,gravaIVA,idFactura,situacion,montoSinIVA)
						VALUES(".$o->idConcepto.",'".cv($o->descripcion)."',".$o->montoComprobacion.",".$o->gravaIVA.",@idFactura,".$situacionComprobaciones.",".$o->montoSinIVA.")";
			$x++;
		}
		
		
		if($obj->tComprobante==4)
		{
			$fechaRegreso="NULL";
			if($obj->objBoletaAvion->tipoViaje!=0)
			{
				$fechaRegreso="'".$obj->objBoletaAvion->fechaRegreso."'";
			}
			$consulta[$x]="INSERT INTO 107_datosBoletoAvion(origen,destino,tipoViaje,fechaSalida,fechaRegreso,idComprobante) VALUES('".cv($obj->objBoletaAvion->origen)."','".cv($obj->objBoletaAvion->destino)."',".$obj->objBoletaAvion->tipoViaje.
							",'".$obj->objBoletaAvion->fechaSalida."',".$fechaRegreso.",@idFactura)";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	
	function verificarNoExistenciaNoFactura()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];
		$noFactura=$_POST["noFactura"];
		$serie=$_POST["noSerie"];
		$consulta="SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idProveedor=".$idProveedor." AND folioComprobante='".$noFactura."' AND noSerie='".$serie."' and situacion<>2";
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)
			echo "1|2";
		else
			echo "1|1";
	}
	
	function obtenerInformesTecnicosPeriodo()
	{
		global $con;
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=1;
		$arrEvaluaciones[3]=1;
		$arrEvaluaciones[4]=2;
		$arrEvaluaciones[5]=2;
		$arrEvaluaciones[6]=2;
		$arrEvaluaciones[7]=2;
		$arrEvaluaciones[8]=2;		
		
		$periodo=$_POST["periodo"];
		$ignorarPermisos=false;
		if(isset($_POST["ignorarPermisos"]))
			$ignorarPermisos=true;
		
		
		$idEvaluacion=$arrEvaluaciones[$periodo];
		
		$consulta="SELECT id__370_tablaDinamica AS idProyecto,codigo AS folio,tituloProyecto AS titulo,o.unidad as organizacion, 
				(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo.") as situacionEvaluacion,
				(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo.") as fechaRealizacion,
				(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo.") as idInforme,
				(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo.") as fechaUltimaModificacion,
				(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo.") as fechaUltimaEvaluacion,
				(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=370 AND idReferencia=t.id__370_tablaDinamica AND noInforme=".$periodo." and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion				
				FROM _370_tablaDinamica t,817_organigrama o 
				WHERE t.marcaAutorizado=1 AND o.codigoUnidad=t.codigoInstitucion ORDER BY o.codigoUnidad,t.codigo";
		$res=$con->obtenerFilas($consulta);
		$arrReg="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$permisos="";
			$consulta="SELECT * FROM _404_configuracionPermisos WHERE idProyecto=".$fila[0];
			$fProy=$con->obtenerPrimeraFila($consulta);
			if(($fProy[3]==$_SESSION["idUsr"])||($_SESSION["idUsr"]==1)||($_SESSION["idUsr"]==1284))
				$permisos.="T";
			if(($fProy[4]==$_SESSION["idUsr"])||($_SESSION["idUsr"]==1)||($_SESSION["idUsr"]==1284))
				$permisos.="F";
			if(($fProy[5]==$_SESSION["idUsr"])||($_SESSION["idUsr"]==1)||($_SESSION["idUsr"]==1284))
				$permisos.="P";
			if(($fProy[6]==$_SESSION["idUsr"])||($_SESSION["idUsr"]==1)||($_SESSION["idUsr"]==1284))
				$permisos.="C";
			if(($fProy[7]==$_SESSION["idUsr"])||($_SESSION["idUsr"]==1)||($_SESSION["idUsr"]==1284))
				$permisos.="L";

			if(!$ignorarPermisos)
			{
				if(($permisos=="")&&($_SESSION["idUsr"]!=913)&&($_SESSION["idUsr"]!=1342)&&($_SESSION["idUsr"]!=1)&&($_SESSION["idUsr"]!=461)&&($_SESSION["idUsr"]!=1293)&&($_SESSION["idUsr"]!=952))
				{
					continue;
				}
			}
			$consulta="SELECT resultadoEvaluacion FROM 3002_evaluacionesFinales WHERE idFormulario=370 AND idReferencia=".$fila[0]." and noEvaluacion=".$idEvaluacion." ORDER BY idEvaluacionFinal desc limit 0,1";

			$resEval=$con->obtenerValor($consulta);

			$obj='{"comentariosEvaluacion":"'.cv(str_replace("#R","",$fila[9])).'","situacionDictamenFinal":"'.$resEval.'","idProyecto":"'.$fila[0].'","folio":"'.$fila[1].'","organizacion":"'.cv($fila[3]).'","fechaRealizacion":"'.$fila[5].'","titulo":"'.cv($fila[2]).'","idInforme":"'.$fila[6].'","situacionEvaluacion":"'.$fila[4].
					'","fechaUltimaModificacion":"'.$fila[7].'","fechaUltimaEvaluacion":"'.$fila[8].'","permisos":"'.$permisos.'"}';
			if($arrReg=="")
				$arrReg=$obj;
			else
				$arrReg.=",".$obj;
			$ct++;
		}
		
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrReg.']}';
		
			
	}
	
	function registrarDictamenInformeTecnico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 3000_informesTecnicos SET situacion=".$obj->resultado.",fechaUltimaEvaluacion='".date("Y-m-d H:i")."' WHERE idInforme=".$obj->idInforme;
		$x++;
		$consulta[$x]="INSERT INTO 3001_evaluacionesRespaldo(datosEvaluacion,idInforme) VALUES('".bE($cadObj)."',".$obj->idInforme.")";
		$x++;
		$consulta[$x]="INSERT INTO 3001_evaluacionesInformeTecnico(idInforme,fechaEvaluacion,idResponsableEval,resultadoEvaluacion,comentarios)
					VALUES(".$obj->idInforme.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->resultado.",'".cv($obj->comentarios)."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			/*if($obj->resultado==3)
			{
				$query="SELECT idReferencia FROM 3000_informesTecnicos WHERE idInforme=".$obj->idInforme;
				$idRegistro=$con->obtenerValor($query);
				$comando="wget http://censida.grupolatis.net/modulosEspeciales_Censida/reportes/reporteFinalProyectoCensida2014.php?idRegistro=".$idRegistro;
				exec($comando);		
			}*/
			echo "1|";
		}
		
			
	}
	
	function obtenerComentariosInformeTecnico()
	{
		global $con;
		$idInforme=$_POST["idInforme"];
		$consulta="SELECT fechaEvaluacion AS fechaComentario,u.Nombre AS responsable,resultadoEvaluacion AS dictamen,comentarios AS comentario FROM 3001_evaluacionesInformeTecnico e,800_usuarios u WHERE idInforme=".$idInforme." 
					AND u.idUsuario=e.idResponsableEval ORDER BY fechaEvaluacion DESC";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function obtenerSituacionFinancieraProyectos()
	{
		global $con;
		$condWhere="1=1";
		$consulta="SELECT * FROM (
								SELECT id__370_tablaDinamica as idRegistro,codigo,tituloProyecto,(SELECT SUM(montoAutorizado) FROM 100_rubrosAutorizados WHERE idFormulario=370 and idRegistro=p.id__370_tablaDinamica ) AS montoAutorizado,
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) as comprobacionPorValidar,
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) 
								
								)as montoPorEvaluar,
								
								'0' as montoPorComprobar,
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
								
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
								
								) as montoReportado,
								'0' as montoComprobado,
								
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) as comprobacionRechazadas,
								
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) 
								
								) as montoRechazado,
								(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND situacion=0) as comprobantesValidar,
								(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
								(select organizacion from _367_tablaDinamica o where o.codigoInstitucion=p.codigoInstitucion) as organizacion
								
								
								
								FROM _370_tablaDinamica p
								WHERE marcaAutorizado=1) AS t where ".$condWhere." ORDER BY codigo";
		
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$montoComprobado=0;
			
			$consulta="SELECT montoAutorizado,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion WHERE idConcepto=c.idGridVSCalculo and situacion=1) FROM 100_calculosGrid c WHERE idFormulario=370 AND idReferencia=".$fila[0];
			$resConceptos=$con->obtenerFilas($consulta);
			while($filaConceptos=mysql_fetch_row($resConceptos))
			{
				if($filaConceptos[1]=="")
					$filaConceptos[1]=0;
				if($filaConceptos[1]>$filaConceptos[0])
					$montoComprobado+=$filaConceptos[0];
				else
					$montoComprobado+=$filaConceptos[1];
			}
			
			$permisos="";
			$consulta="SELECT * FROM _404_configuracionPermisos WHERE idProyecto=".$fila[0];
			$fProy=$con->obtenerPrimeraFila($consulta);
			//if($fProy[3]==$_SESSION["idUsr"])
				//$permisos.="T";
			if($fProy[4]==$_SESSION["idUsr"])
				$permisos.="F";
//			if($fProy[5]==$_SESSION["idUsr"])
	//			$permisos.="P";
			//if($fProy[6]==$_SESSION["idUsr"])
		//		$permisos.="C";
		//	if($fProy[7]==$_SESSION["idUsr"])
		//		$permisos.="L";

			if((($permisos=="")&&($_SESSION["idUsr"]!=913)&&($_SESSION["idUsr"]!=1342)&&($_SESSION["idUsr"]!=1)&&($_SESSION["idUsr"]!=461)&&($_SESSION["idUsr"]!=1293)&&($_SESSION["idUsr"]!=1311))&&(!existeRol("'84_0'"))&&($_SESSION["idUsr"]!=952)&&(!existeRol("'101_0'")))
			{
				continue;
			}
			
			
			$porComprobar=$fila[3]-$montoComprobado;
			if($porComprobar<0.01)
				$porComprobar=0;
				
			$consulta="UPDATE _370_tablaDinamica SET montoAdeudo=".$porComprobar." WHERE id__370_tablaDinamica=".$fila[0];
			$con->ejecutarConsulta($consulta);
			
			
			$obj='{"organizacion":"'.cv($fila[14]).'","idRegistro":"'.$fila[0].'","codigo":"'.$fila[1].'","tituloProyecto":"'.cv($fila[2]).'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[8].'","montoComprobado":"'.$montoComprobado.'","montoPorComprobar":"'.$fila[6].'","comprobacionPorValidar":"'.$fila[4].
					'","comprobacionRechazadas":"'.$fila[10].'","montoRechazado":"'.$fila[11].'","comprobacionesAceptadas":"'.$fila[7].'","montoPorEvaluar":"'.$fila[5].'","comprobantesValidar":"'.$fila[12].'","nSolicitudesTranferencia":"'.$fila[13].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerSituacionPresupuestal()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		
		$consulta="SELECT con.idGridVSCalculo,c.conceptoPresupuestal AS rubro,con.calculo AS concepto,montoAutorizado,
					(if((select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=con.idGridVSCalculo)is null,0,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=con.idGridVSCalculo)))  as montoComprobado,
					con.idConcepto as categoria
					FROM _385_tablaDinamica c,100_calculosGrid con WHERE 
					c.id__385_tablaDinamica=con.idRubro and con.idFormulario=".$idFormulario." AND con.idReferencia=".$idProyecto." and eliminado=0 AND total>0 order by con.calculo";	
							
		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';				
	}
	
	function obtenerComprobacionesPresupuestal()
	{
		global $con;
		$idEstado=$_POST["idEstado"];
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		$consulta="SELECT t.idFactura as idRegistro,c.conceptoPresupuestal AS rubro,con.calculo AS concepto,cc.montoComprobacion AS monto,t.fechaCreacion AS fechaRegistro,con.idConcepto as categoria,t.idFactura 
					FROM 101_comprobantesPresupuestales t,102_conceptosComprobacion cc,	_385_tablaDinamica c,100_calculosGrid con WHERE t.idFactura=cc.idFactura and
						c.id__385_tablaDinamica=con.idRubro AND con.idGridVSCalculo=cc.idConcepto AND cc.situacion=".$idEstado." AND con.idFormulario=".$idFormulario." and con.idReferencia=".$idProyecto." ORDER BY t.fechaCreacion";		

		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';	
	}
	
	function obtenerDatosComprobantes()
	{
		global $con;
		$idComprobante=$_POST["idComprobante"];
		$consulta="SELECT tipoComprobante,folioComprobante,numeroAprobacion,noSerie,CONCAT(p.rfc1,'-',p.rfc2,'-',p.rfc3) AS rfc,p.razonSocial,p.calle,p.colonia,p.cp,
					(SELECT estado FROM 820_estados e WHERE e.cveEstado=p.estado) AS estado,
					(SELECT municipio FROM 821_municipios m WHERE m.cveMunicipio=p.municipio)  AS municipio,numero,idComprobante,validacionSAT,anioAprobacion,comentariosEnvio
					FROM 101_comprobantesPresupuestales c,595_proveedores p WHERE p.idProveedor=c.idProveedor  AND idFactura=".$idComprobante;
			
		$fComprobante=$con->obtenerPrimeraFila($consulta);	
		if($fComprobante[7]=="")	
			$fComprobante[7]="N/E";
		if($fComprobante[8]=="")	
			$fComprobante[8]="N/E";
		$domicilio="Calle ".$fComprobante[6];
		if($fComprobante[0]!=3)
			$domicilio.=" # ".$fComprobante[11]." Col. ".$fComprobante[7]." CP. ".$fComprobante[8]." ".$fComprobante[10].",".$fComprobante[9];
		
		$arrConceptos="";
		
		if($fComprobante[0]!=11)
		{
			$consulta="SELECT COUNT(*) FROM 102_conceptosComprobacion WHERE idFactura=".$idComprobante." AND idConcepto=0";
			$nReg=$con->obtenerValor($consulta);
			if($nReg>0)
			{
				$fComprobante[0]=11;	
			}
		}
		
		if($fComprobante[0]==11)	
		{
			$consulta="SELECT idConceptoComprobado,'Reintegro',0,descripcion,con.montoComprobacion,con.situacion,'Reintegro',con.comentarios 
					FROM 102_conceptosComprobacion con,101_comprobantesPresupuestales f  WHERE f.idFactura=".$idComprobante." 
					and con.idFactura=f.idFactura";
		}
		else
		{
			$consulta="SELECT idConceptoComprobado,c.calculo,c.idConcepto,con.descripcion,montoComprobacion,situacion,t.conceptoPresupuestal,con.comentarios 
					FROM 102_conceptosComprobacion con,100_calculosGrid c,_385_tablaDinamica t
						 WHERE idFactura=".$idComprobante." AND c.idGridVSCalculo=con.idConcepto and t.id__385_tablaDinamica=c.idRubro";
			
		
			
		}

		$resComprobante=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($resComprobante))
		{
			
			$concepto=cv($fila[1]);
			if($fila[2]!=0)
			{
				$consulta="SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=".$fila[2];
				$nAux=$con->obtenerValor($consulta);
				$concepto.="[".$nAux."] ".$concepto;
			}
			

			$fila[3]=str_replace("|","/",$fila[3]);
			
			if(($fComprobante[0]==7)||($fComprobante[0]==10))
			{
				$consulta="SELECT descripcion FROM 102_conceptosCFDI WHERE idConcepto=".$fila[3];
				$fila[3]=$con->obtenerValor($consulta);	
			}
			
			$obj="['".$fila[0]."','".cv($fila[6])."','[".$fila[0]."] ".cv($concepto)."','".cv($fila[3])."','".cv($fila[4])."','".cv($fila[5])."','".cv($fila[7])."']";
			if($arrConceptos=="")
				$arrConceptos=$obj;
			else
				$arrConceptos.=",".$obj;
		}
		
		
		$lblInfoComprobante="<table><tr>";
		
		$lblInfoComprobante.="</tr></table>";	
		
		$folio="N/A";
		if($fComprobante[1]!="")
			$folio=$fComprobante[1];
		$aprobacion="N/A";
		if($fComprobante[2]!="")
			$aprobacion=$fComprobante[2];
			
		$serie="N/A";
		if($fComprobante[3]!="")
			$serie=$fComprobante[3];
		
		$anioAprobacion="N/A";
		if($fComprobante[14]!="")
			$anioAprobacion=$fComprobante[14];
		$datosBoletoAvion='""';
		if($fComprobante[0]==4)
		{
			$datosBoletoAvion='{"origen":"","destino":"","tipoViaje":"","fechaSalida":"","fechaRegreso":""}';
			
			$consulta="SELECT origen,destino,tipoViaje,fechaSalida,fechaRegreso FROM 107_datosBoletoAvion WHERE idComprobante=".$idComprobante;
			$fComprobanteBoleto=$con->obtenerPrimeraFila($consulta);
			if($fComprobanteBoleto)
			{
				$tViaje="Sencillo";
				if($fComprobanteBoleto[2]==1)
					$tViaje="Redondo";
				$fRegreso="";
				if($fComprobanteBoleto[4]!="")
					$fRegreso=date("d/m/Y \a \l\a\s H:i \h\\r\s.",strtotime($fComprobanteBoleto[4]));
				$datosBoletoAvion='{"origen":"'.cv($fComprobanteBoleto[0]).'","destino":"'.cv($fComprobanteBoleto[1]).'","tipoViaje":"'.$tViaje.'","fechaSalida":"'.date("d/m/Y \a \l\a\s  H:i \h\\r\s.",strtotime($fComprobanteBoleto[3])).'","fechaRegreso":"'.$fRegreso.'"}';
			}
		}
		
		$cadObj='{"comentariosEnvio":"'.cv($fComprobante[15]).'","datosBoletoAvion":'.$datosBoletoAvion.',"anioAprobacion":"'.$anioAprobacion.'","validacionSAT":"'.$fComprobante[13].'","tComprobante":"'.$fComprobante[0].'","rfc":"'.$fComprobante[4].'","razonSocial":"'.cv($fComprobante[5]).'","domicilio":"'.
					cv($domicilio).'","datosComprobante":"'.cv($fComprobante[5]).'","conceptos":['.$arrConceptos.'],"lblInfoComprobante":"'.$lblInfoComprobante.'","folio":"'.$folio.'","aprobacion":"'.$aprobacion.'","serie":"'.$serie.'"}';
		echo "1|".$cadObj;
	}
	
	function guardarEvaluacionComprobacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$query="SELECT tipoComprobante FROM 101_comprobantesPresupuestales WHERE idFactura=".$obj->idFactura;
		$tComprobante=$con->obtenerValor($query);
		
		
		
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$nConceptos=0;
		$nConceptosRechazados=0;
		$tblConcepto="<table><tr><td width='250'><b>Concepto</b></td><td width='110'><b>Resultado</b></td><td width='450'><b>Comentarios</b></td></tr>";
		foreach($obj->arrConceptos as $c)
		{
			$consulta[$x]="UPDATE 102_conceptosComprobacion SET situacion=".$c->situacion.",comentarios='".cv($c->comentario)."' WHERE idConceptoComprobado=".$c->idConcepto;
			$x++;
			
			$nConceptos++;
			if($c->situacion==2)
				$nConceptosRechazados++;
				
				
			$query="SELECT c.idConcepto,descripcion,(SELECT descripcion FROM 102_conceptosCFDI WHERE idConcepto=c.descripcion) AS descripcionCFDI,situacion,c.comentarios 
					FROM 102_conceptosComprobacion c,100_calculosGrid g WHERE idConceptoComprobado=".$c->idConcepto." AND g.idGridVSCalculo=c.idConcepto";
			$fConcepto=$con->obtenerPrimeraFila($query);
			
			$situacionConcepto="";
			switch($c->situacion)
			{
				case "1":
					$situacionConcepto="Aceptado";
				break;
				case "2":
					$situacionConcepto="Rechazado";
				break;
				default:
					$situacionConcepto="";
				break;
			}
			
			if(($tComprobante==7)||($tComprobante==10))
				$tblConcepto.='<tr><td>'.$fConcepto[2].'</td><td>'.$situacionConcepto.'</td><td>'.$fConcepto[4].'</td></tr>';
			else
				$tblConcepto.='<tr><td>'.$fConcepto[1].'</td><td>'.$situacionConcepto.'</td><td>'.$fConcepto[4].'</td></tr>';
			
				
			
		}
		$situacionFactura=1;
		switch($obj->validacionSAT)
		{
			case 2:
				$situacionFactura=2;
			break;	
			case 5:
				$situacionFactura=4;
			break;
		}
		
		if($nConceptosRechazados==$nConceptos)	
			$situacionFactura=2;
			
			
		$consulta[$x]="UPDATE 101_comprobantesPresupuestales SET validacionSAT=".$obj->validacionSAT.",situacion=".$situacionFactura.",fechaEvaluacion='".date("Y-m-d H:i")."',idRespEvaluacion=".$_SESSION["idUsr"]." WHERE idFactura=".$obj->idFactura;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			enviarMailComprobanteEvaluado($obj->idFactura,$obj,$tblConcepto,$situacionFactura);			
			
			/*if($situacionFactura==1)
			{
				$query="SELECT idReferencia FROM 101_comprobantesPresupuestales WHERE idFactura=".$obj->idFactura;
				$idRegistro=$con->obtenerValor($query);
				$comando="wget http://censida.grupolatis.net/modulosEspeciales_Censida/reportes/reporteFinalProyectoCensida2014.php?idRegistro=".$idRegistro;
				exec($comando);		
				
			}*/
			echo "1|";
		}
	}
	
	
	function enviarMailComprobanteEvaluado($idComprobante,$obj,$tblConcepto,$situacionFactura)
	{
		global $con;
		
		
		switch($situacionFactura)
		{
			case 1:
				$situacionFactura="Aceptado";
			break;
			case 2:
				$situacionFactura="Rechazado";
			break;
			case 4:
				$situacionFactura="Se solicitan detalles";
			break;
		}
		
		$arrAchivos=array();
		$arrCopias=array();
		$consulta="SELECT * FROM 101_comprobantesPresupuestales WHERE idFactura=".$idComprobante;
		$fDocumento=$con->obtenerPrimeraFila($consulta);		
		$consulta="SELECT codigo FROM _".$fDocumento[11]."_tablaDinamica WHERE id__".$fDocumento[11]."_tablaDinamica=".$fDocumento[12];
		$folioProy=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT razonSocial FROM 595_proveedores WHERE idProveedor=".$fDocumento[1];
		$proveedor=$con->obtenerValor($consulta);
		
		$cuerpoMail="<table width=\"800\"><tr><td width=\'250\' align=\"center\"><img  width=\"180\" height=\"60\" src=\"http://censida.grupolatis.net/images/censida/logoSalud.gif\"></td>
								<td width=\'250\' align=\"center\"><img width=\"75%\" height=\"75%\"  src=\"http://censida.grupolatis.net/images/censida/FIRMA_ELECTRONICAaaa.png\"></td></tr></table>
								<br><br><h1>Centro Nacional para La Prevención y el<br>
								Control Del VIH y el sida</h1><br>
								<br><br>	<span style='font-size:12px'>		
								<b>A quien corresponda:</b><br><br>							
								
								Por este medio se le notifica que el comprobante con folio: <b>".$fDocumento[3]."</b> del proyecto: ".$folioProy." del proveedor ".$proveedor." ha sido revisado y evaluado de la siguiente manera:<br><br>
								<b>Resultado:</b> ".$situacionFactura."<br><br>
								
								".$tblConcepto."
								
								
								<br><br>
								<br><br>
								</span>";	
		
		
		
		
		$consulta="SELECT distinct Mail,m.idUsuario FROM 805_mails m,800_usuarios u WHERE u.idUsuario=m.idUsuario and u.cuentaActiva=1 
					and m.idUsuario IN (
						SELECT idUsuario FROM 801_adscripcion a,_".$fDocumento[11]."_tablaDinamica t 
							WHERE a.Institucion=t.codigoInstitucion AND id__".$fDocumento[11]."_tablaDinamica=".$fDocumento[12]."
						)"; 
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$destinatario=$fila[0];
			@enviarMail($destinatario," CENSIDA - Comprobante evaluado",$cuerpoMail,"soporteSMAP@grupolatis.net","",$arrAchivos,$arrCopias);
		}
		
	}
	
	
	function obtenerSituacionFinancieraProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		
		$totalAutorizado=0;
		$totalComprobado=0;
		
		
		$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$idFormulario." AND f.idReferencia=".$idProyecto." AND c.situacion=0";
			
		$reIntegroPorValidar=$con->obtenerValor($consulta);
		if($reIntegroPorValidar=="")
		{
			$reIntegroPorValidar=0;
		}
		
		$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
					AND f.idFactura=c.idFactura AND f.idFormulario=".$idFormulario." AND f.idReferencia=".$idProyecto." AND c.situacion=1";
		
		$reIntegroAutorizado=$con->obtenerValor($consulta);
		if($reIntegroAutorizado=="")
		{
			$reIntegroAutorizado=0;
		}
		
		$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
					AND f.idFactura=c.idFactura AND f.idFormulario=".$idFormulario." AND f.idReferencia=".$idProyecto." AND c.situacion=2";
		
		$reIntegroRechazados=$con->obtenerValor($consulta);
		if($reIntegroRechazados=="")
		{
			$reIntegroRechazados=0;
		}
		
		$tPresentado=0;
		
		$consulta="SELECT idConcepto,descripcion,rubro,montoAutorizado,
					IF(montoReportado IS NULL,0,montoReportado) AS montoReportado,
					IF ( (IF(montoAutorizadoComprobado IS NULL,0,montoAutorizadoComprobado))>montoAutorizado,montoAutorizado,(IF(montoAutorizadoComprobado IS NULL,0,montoAutorizadoComprobado))) AS montoAutorizadoComprobado,
					IF(montoEnEsperaAutorizacion IS NULL,0,montoEnEsperaAutorizacion) AS montoEnEsperaAutorizacion,
					IF(montoNoAutorizado IS NULL,0,montoNoAutorizado) AS montoNoAutorizado,
					if(montoAutorizadoComprobado is null,montoAutorizado,(if((montoAutorizado-montoAutorizadoComprobado)<0,0,(montoAutorizado-montoAutorizadoComprobado))))as montoPorComprobar
					   from 
					   (select idGridVSCalculo AS idConcepto,
					IF(c.idConcepto=0,concat('(',c.idGridVSCalculo,') ',calculo),(CONCAT('(',c.idGridVSCalculo,') ','[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=c.idConcepto),'] ',calculo))) AS descripcion,
					t.conceptoPresupuestal AS rubro,montoAutorizado,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=c.idGridVSCalculo) AS montoReportado,
					
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=c.idGridVSCalculo) AS montoAutorizadoComprobado,
					
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=0 and idConcepto=c.idGridVSCalculo) AS montoEnEsperaAutorizacion,
					(
					select sum(c.montoComprobacion) from 102_conceptosComprobacion c,101_comprobantesPresupuestales f where c.situacion=2 and idConcepto=c.idGridVSCalculo
					and f.idFactura=c.idFactura AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=c.idFormulario AND idReferencia=c.idReferencia AND 
										situacion=1 AND tipoComprobante IN(7,10))
					) AS montoNoAutorizado
					 
					FROM 100_calculosGrid c, _385_tablaDinamica t
					WHERE c.idFormulario=".$idFormulario." AND c.idReferencia=".$idProyecto." AND t.id__385_tablaDinamica=c.idRubro) as tmp  ORDER BY rubro,descripcion";

		$arrRegistros="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$totalAutorizado+=$fila[3];
			$totalComprobado+=$fila[5];
			
			
			$tPresentado+=($fila[5]+$fila[6]);
			$o='{"idConcepto":"'.$fila[0].'","descripcion":"'.cv($fila[1]).'","rubro":"'.cv($fila[2]).'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[4].
				'","montoAutorizadoComprobado":"'.$fila[5].'","montoEnEsperaAutorizacion":"'.$fila[6].'","montoNoAutorizado":"'.$fila[7].'","montoPorComprobar":"'.$fila[8].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		$numReg=$con->filasAfectadas++;
		
		$consulta="SELECT codigo FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idProyecto;
		$folio=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(*) FROM 1045_proyectosCerradoComprobacion WHERE proyecto='".$folio."'";
		$ProyCerrado=$con->obtenerValor($consulta);
//		if($ProyCerrado==1)
		{
			
			
			
			$totalPorComprobar=$totalAutorizado-$totalComprobado;
			
			$montoAutorizadoComprobado=$reIntegroAutorizado;
			if($montoAutorizadoComprobado>$totalPorComprobar)
				$montoAutorizadoComprobado=$totalPorComprobar;
				
				
			$etiqueta="Reintegro";

			$o='{"idConcepto":"0","descripcion":"'.$etiqueta.'","rubro":"'.$etiqueta.'","montoAutorizado":"0","montoReportado":"'.$reIntegroAutorizado.
			'","montoAutorizadoComprobado":"'.$montoAutorizadoComprobado.'","montoEnEsperaAutorizacion":"'.$reIntegroPorValidar.'","montoNoAutorizado":"'.$reIntegroRechazados.
			'","montoPorComprobar":"-'.$montoAutorizadoComprobado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		
			$tPresentado+=$montoAutorizadoComprobado+$reIntegroPorValidar;
		
			$numReg++;
		}
		
		$montoMinistrado=$totalAutorizado*0.60;

		$pPresentado=($tPresentado/$montoMinistrado)*100;
		if($pPresentado>100)
			$pPresentado=100;
			
		echo '{"montoMinistrado":"'.$montoMinistrado.'","pPresentado":"'.$pPresentado.'","numReg":"'.$con->filasAfectadas.'","registros":['.($arrRegistros).']}';
		
	}
	
	function obtenerSituacionConceptos()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$situacion=$_POST["situacion"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT idConceptoComprobado AS idComprobacion,if((c.tipoComprobante=7 or c.tipoComprobante=10),(SELECT descripcion FROM 102_conceptosCFDI WHERE idConcepto=con.descripcion),descripcion)as descripcion,con.montoComprobacion AS montoComprobar,con.comentarios, c.idFactura,c.fechaCreacion AS fechaRegistro
					FROM 102_conceptosComprobacion con,101_comprobantesPresupuestales c WHERE con.idConcepto=".$idConcepto." 
					AND c.idFactura=con.idFactura and con.situacion=".$situacion." and c.idFormulario=".$idFormulario." and c.idReferencia=".$idReferencia;
		if($situacion==2)		
		{
			$consulta.=" and c.folioComprobante NOT IN (SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND 
						situacion=1 AND tipoComprobante IN(7,10))";

		}
		

		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';		
		
	}
	
	function obtenerDatosProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT tituloProyecto,o.unidad FROM _370_tablaDinamica t, 817_organigrama o WHERE id__370_tablaDinamica=".$idProyecto." AND o.codigoUnidad=t.codigoInstitucion";
		$fDatos=$con->obtenerPrimeraFila($consulta);
		echo "1|".$fDatos[0]."|".$fDatos[1];
	}
	
	function obtenerSolicitudesTransferenciaPresupuesto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		
		$situacion='0,1,2';
		if(isset($_POST["situacion"]))
			$situacion=$_POST["situacion"];
		
		$idFormulario=$_POST["idFormulario"];
		$consulta="select * from 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=".$idFormulario." and idReferencia=".$idProyecto." and situacion in (".$situacion.") order by fechaSolicitud desc";
		$res=$con->obtenerFilas($consulta);
		$arrObj='';
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$responsable="";
			if($fila[9]!="")
			{
				$responsable=obtenerNombreUsuarioPaterno($fila[9]);
			}
			
			
			
			$tblConceptos="";			
			
			$tblConceptos="<table><tr><td width='350' align='center'><span class='corpo8_bold'>Concepto</td><td width='120'  align='center'><span class='corpo8_bold'>Monto transferencia</span></td></tr>";
			
			$tblConceptos.="<tr height='1' style='background-color:#900'><td colspan='2'></td></tr>";
			
			$consulta="SELECT (IF(g.idConcepto=0,g.calculo,(SELECT CONCAT('[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto 
						WHERE id__385_gridCategoriasConcepto=g.idConcepto),'] ',g.calculo)))) AS concepto FROM 
						100_calculosGrid g WHERE g.idGridVSCalculo=".$fila[4];
			$nConcepto=cv($con->obtenerValor($consulta));
			
			$consulta="SELECT (IF(g.idConcepto=0,g.calculo,(SELECT CONCAT('[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=g.idConcepto),'] ',g.calculo)))) AS concepto,montoConcepto FROM 104_conceptosSolicitudesTransferencia c,
						100_calculosGrid g WHERE idSolicitud=".$fila[0]." AND g.idGridVSCalculo=c.idConcepto";
			$resConcepto=$con->obtenerFilas($consulta);
			$total=0;
			while($fConcepto=mysql_fetch_row($resConcepto))
			{
				$tblConceptos.="<tr><td>".cv($fConcepto[0])."</td><td align='right'>$ ".number_format($fConcepto[1],2)."</td></tr>";
				$total+=$fConcepto[1];
			}
			$tblConceptos.="<tr height='8' ><td></td><td ></td></tr><tr height='1' ><td></td><td style='background-color:#900'></td></tr><tr><td align='right'><b>Monto total:</b>&nbsp;&nbsp;</td><td align='right'>$ ".number_format($total,2)."</td></tr>";
			$tblConceptos.="</table>";
			$descripcion="<table width='700'><tr height='21'><td width='150'><span class='corpo8_bold'>Solicitud:</span></td><td width='550'><b>Tranferencia de presupuesto de los siguientes conceptos al concepto: <span class='letraRojaSubrayada8'>'".$nConcepto."'</span></b><br><br>".$tblConceptos."<br><br></td></tr>";
			$descripcion.="<tr height='21'><td ><span class='corpo8_bold'>Motivo de la solicitud:</span></td><td >".cv($fila[6])."</td></tr>";
			switch($fila[5])
			{
				case 0:
				break;
				case 1:
					$descripcion.="<tr height='21'><td ><span class='corpo8_bold'>Comentarios:</span></td><td>".cv($fila[8])."</td></tr>";
				break;
				case 2:
					$descripcion.="<tr height='21'><td ><span class='corpo8_bold'>Motivo del rechazo:</span></td><td>".cv($fila[8])."</td></tr>";
				break;
				
			}
			
			$descripcion.="</table>";
			
			$obj='{"idSolicitud":"'.$fila[0].'","fechaSolicitud":"'.$fila[1].'","descripcion":"'.$descripcion.'","respuestaSolicitud":"'.$fila[5].
				'","responsableRespuesta":"'.$responsable.'","fechaRespuesta":"'.$fila[7].'"}';
			if($arrObj=='')
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
				
			
			
				
				
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObj.']}';
	}
	
	function obtenerSituacionConceptoTransferencia()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idSolicitud=$_POST["idSolicitud"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		$consulta="SELECT idConcepto,descripcion,rubro,montoAutorizado,
					(montoAutorizado-
					(if(montoAutorizadoComprobado is null,0,montoAutorizadoComprobado)+if(montoEnEsperaAutorizacion is null,0,montoEnEsperaAutorizacion)+
					if(montoComprometido is null,0,montoComprometido))) as montoDisponible,
					montoATransferir
					   
					   from (select idGridVSCalculo AS idConcepto,
					
					IF(c.idConcepto=0,calculo,(CONCAT('[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=c.idConcepto),'] ',calculo))) AS descripcion,
					t.conceptoPresupuestal AS rubro,montoAutorizado,
					(
					if(
					(SELECT montoConcepto FROM 104_conceptosSolicitudesTransferencia WHERE idSolicitud=".$idSolicitud." AND idConcepto=c.idGridVSCalculo) is null,0,
					(SELECT montoConcepto FROM 104_conceptosSolicitudesTransferencia WHERE idSolicitud=".$idSolicitud." AND idConcepto=c.idGridVSCalculo))) as montoATransferir,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=c.idGridVSCalculo) AS montoAutorizadoComprobado,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=0 and idConcepto=c.idGridVSCalculo) AS montoEnEsperaAutorizacion,
					(SELECT sum(montoConcepto) FROM 104_conceptosSolicitudesTransferencia c,103_solicitudesTransferenciaPresupuesto s 
					WHERE s.idSolicitudTransferencia=c.idSolicitud AND s.situacion=0 AND c.idConcepto=c.idGridVSCalculo and  
					s.idSolicitudTransferencia<>".$idSolicitud.") as montoComprometido
					FROM 100_calculosGrid c, _385_tablaDinamica t
					WHERE c.idFormulario=".$idFormulario." AND c.idReferencia=".$idProyecto." AND t.id__385_tablaDinamica=c.idRubro) as tmp  ORDER BY rubro,descripcion";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function guardarSolicitudesTransferencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 103_solicitudesTransferenciaPresupuesto(fechaSolicitud,idResponsableSolicitud,montoTransferencia,idConceptoTranferencia,
				situacion,motivoSolicitud,idFormulario,idReferencia) VALUES
				('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->montoTotal.",".$obj->idConceptoTransferencia.",0,'".cv($obj->motivoSolicitud)."',".
				$obj->idFormulario.",".$obj->idReferencia.")";
				
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		foreach($obj->registros as $r)
		{	
			$consulta[$x]="INSERT INTO 104_conceptosSolicitudesTransferencia(idConcepto,montoConcepto,idSolicitud)
						VALUES(".$r->idConcepto.",".$r->monto.",@idRegistro)";
			$x++;						
		}	
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDatosSolicitudTransferencia()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		
		$consulta="SELECT idConcepto,descripcion,rubro,montoAutorizado,
					(montoAutorizado-
					(if(montoAutorizadoComprobado is null,0,montoAutorizadoComprobado)+if(montoEnEsperaAutorizacion is null,0,montoEnEsperaAutorizacion)+
					if(montoComprometido is null,0,montoComprometido))) as montoDisponible,
					montoATransferir
					   
					   from (select idGridVSCalculo AS idConcepto,
					
					IF(c.idConcepto=0,calculo,(CONCAT('[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE id__385_gridCategoriasConcepto=c.idConcepto),'] ',calculo))) AS descripcion,
					t.conceptoPresupuestal AS rubro,montoAutorizado AS montoAutorizado,
					(
					if(
					(SELECT montoConcepto FROM 104_conceptosSolicitudesTransferencia WHERE idSolicitud=".$idSolicitud." AND idConcepto=c.idGridVSCalculo) is null,0,
					(SELECT montoConcepto FROM 104_conceptosSolicitudesTransferencia WHERE idSolicitud=".$idSolicitud." AND idConcepto=c.idGridVSCalculo))) as montoATransferir,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=1 and idConcepto=c.idGridVSCalculo) AS montoAutorizadoComprobado,
					(select sum(montoComprobacion) from 102_conceptosComprobacion where situacion=0 and idConcepto=c.idGridVSCalculo) AS montoEnEsperaAutorizacion,
					(SELECT sum(montoConcepto) FROM 104_conceptosSolicitudesTransferencia c,103_solicitudesTransferenciaPresupuesto s 
					WHERE s.idSolicitudTransferencia=c.idSolicitud AND s.situacion=0 AND c.idConcepto=c.idGridVSCalculo and  
					s.idSolicitudTransferencia<>".$idSolicitud.") as montoComprometido
					FROM 100_calculosGrid c, _385_tablaDinamica t
					WHERE c.idGridVSCalculo in (select idConcepto from 104_conceptosSolicitudesTransferencia where idSolicitud=".$idSolicitud.") AND t.id__385_tablaDinamica=c.idRubro) as tmp  ORDER BY rubro,descripcion";
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		
		$consulta="(SELECT (IF(g.idConcepto=0,g.calculo,(SELECT CONCAT('[',(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto 
						WHERE id__385_gridCategoriasConcepto=g.idConcepto),'] ',g.calculo)))) AS concepto FROM 
						100_calculosGrid g WHERE g.idGridVSCalculo=s.idConceptoTranferencia)";
		
		$consulta="select montoTransferencia,".$consulta.",motivoSolicitud FROM 103_solicitudesTransferenciaPresupuesto s WHERE idSolicitudTransferencia=".$idSolicitud;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		echo "1|".$arrRegistros."|".$fRegistro[0]."|".$fRegistro[1]."|".$fRegistro[2];
		
		
	}
	
	function guardarEvaluacionSolicitudTransferencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 103_solicitudesTransferenciaPresupuesto SET situacion=".$obj->resultado.",fechaRespuesta='".date("Y-m-d H:i").
						"',comentariosRespuesta='".cv($obj->comentarios)."',idRespRespuesta=".$_SESSION["idUsr"]." WHERE 
						idSolicitudTransferencia=".$obj->idSolicitud;
		$x++;						
		if($obj->resultado==1)
		{
			$query="SELECT montoTransferencia,idConceptoTranferencia FROM 103_solicitudesTransferenciaPresupuesto WHERE 
					idSolicitudTransferencia=".$obj->idSolicitud;
			
			$fTransferencia=$con->obtenerPrimeraFila($query);
			$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=montoAutorizado+".$fTransferencia[0]." WHERE idGridVSCalculo=".$fTransferencia[1];
			$x++;
			$query="SELECT idConcepto,montoConcepto FROM 104_conceptosSolicitudesTransferencia WHERE idSolicitud=".$obj->idSolicitud;
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
			{
				$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=montoAutorizado-".$fila[1]." WHERE idGridVSCalculo=".$fila[0];
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}

	function obtenerProductosComunicativosProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		$idFormularioProductos=0;
		switch($idFormulario)
		{
			case 370:
				$idFormularioProductos=395;
			break;
			case 410:
				$idFormularioProductos=439;
				
			break;
			case 448:
				$idFormularioProductos=473;
			break;
		}
		
		
		
		$consulta="SELECT id__".$idFormularioProductos."_tablaDinamica as idProducto,descripcion,dteDocumento as documento,idEstado as situacion,fechaCreacion as fechaRegistro,
		(SELECT comentario FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as comentarios,
		(SELECT fechaHoraDictamen FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as fechaEvaluacion,
		(SELECT u.Nombre FROM 2002_comentariosRegistro c,800_usuarios u WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica and u.idUsuario=c.idUsuarioResponsable ORDER BY idComentario DESC LIMIT 0,1) as respEvaluacion
		
		 FROM _".$idFormularioProductos."_tablaDinamica t WHERE idReferencia=".$idProyecto;
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function obtenerRevisionContenidosProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT id__401_tablaDinamica as idProducto,txtDescripcion as descripcion,dteDocumento as documento,idEstado as situacion,fechaCreacion as fechaRegistro,
		(SELECT comentario FROM 2002_comentariosRegistro WHERE idFormulario=401 AND idRegistro=t.id__401_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as comentarios, 
		(SELECT fechaHoraDictamen FROM 2002_comentariosRegistro WHERE idFormulario=401 AND idRegistro=t.id__401_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as fechaEvaluacion,
		(SELECT u.Nombre FROM 2002_comentariosRegistro c,800_usuarios u WHERE idFormulario=401 AND idRegistro=t.id__401_tablaDinamica and u.idUsuario=c.idUsuarioResponsable ORDER BY idComentario DESC LIMIT 0,1) as respEvaluacion
		FROM _401_tablaDinamica t WHERE idReferencia=".$idProyecto;
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function registrarBitacoraSeguimiento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];

		$obj=json_decode($cadObj);
		$consulta="SELECT tituloProyecto, o.unidad FROM _370_tablaDinamica t,817_organigrama o WHERE o.codigoUnidad=t.codigoInstitucion AND t.id__370_tablaDinamica=".$obj->idProyecto;
		$fProyecto=$con->obtenerPrimeraFila($consulta);
		$organizacion=$fProyecto[1];
		$tituloProyecto=$fProyecto[0];
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO _399_tablaDinamica(fechaCreacion,responsable,idEstado,dteFecha,tituloProyecto,onganizacion,resultadoRevisionTecnica,cmbTipoBitacora,cmbPeriodo,folio)
				 VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",2,'".$obj->fecha."','".cv($tituloProyecto)."','".cv($organizacion)."','".cv($obj->resultado)."',".$obj->tipoBitacora.",".$obj->periodo.",".$obj->idProyecto.")";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);				 
		
	}
	
	function obtenerInformesBitacoraProyecto()
	{
		global $con;
		$numReg=0;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		$periodo=$_POST["periodo"];
		$consulta="";
		$arrRegistros="";
		switch($idFormulario)
		{
			case 370:
				$consulta="SELECT dteFecha as fecha,IF(cmbTipoBitacora=1,resultadoRevisionTecnica,resultadoRevisionFinanciera) AS reporte,cmbTipoBitacora,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.responsable) AS responsable 
					FROM _399_tablaDinamica t WHERE folio=".$idProyecto." AND cmbPeriodo=".$periodo." ORDER BY dteFecha desc";
			
				$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
				$numReg=$con->filasAfectadas;
			break;
			case 410:
				$consulta="SELECT resultadoRevisionFinanciera,resultadoRevisionTecnica,fechaCreacion,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.responsable) AS responsable  
						FROM _446_tablaDinamica t WHERE folioProyecto=".$idProyecto." and idEstado=2 and periodo=".$periodo;
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					if($fila[0]!="")
					{
						$o='{"fecha":"'.date("Y-m-d",strtotime($fila[2])).'","reporte":"'.cv($fila[0]).'","cmbTipoBitacora":"2","responsable":"'.$fila[3].'"}';
						if($arrRegistros=="")
							$arrRegistros=$o;
						else
							$arrRegistros.=",".$o;
						$numReg++;
					}
					if($fila[1]!="")
					{
						$o='{"fecha":"'.date("Y-m-d",strtotime($fila[2])).'","reporte":"'.cv($fila[1]).'","cmbTipoBitacora":"1","responsable":"'.$fila[3].'"}';
						if($arrRegistros=="")
							$arrRegistros=$o;
						else
							$arrRegistros.=",".$o;
						$numReg++;
					}
				}
				$arrRegistros='['.$arrRegistros.']';
			break;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":'.($arrRegistros).'}';
		
	}
	
	function obtenerComentariosFinalesInforme()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=370;
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		$consulta="SELECT fechaEvaluacion AS fechaComentario,u.Nombre AS responsable,resultadoEvaluacion AS dictamen,comentarios AS comentario,noEvaluacion FROM 3002_evaluacionesFinales e,800_usuarios u WHERE idFormulario=".$idFormulario." and idReferencia=".$idProyecto." 
					AND u.idUsuario=e.idResponsable ORDER BY fechaEvaluacion DESC";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function registrarDictamenFinalInforme()
	{
		global $con;
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=2;
		$arrEvaluaciones[3]=3;
		$arrEvaluaciones[4]=4;
		$arrEvaluaciones[5]=5;
		$arrEvaluaciones[6]=6;
		$arrEvaluaciones[7]=7;		
		$idFormulario=370;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idEvaluacion=$arrEvaluaciones[$obj->noPeriodo];
		if(isset($obj->idFormulario))
			$idFormulario=$obj->idFormulario;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 3002_evaluacionesFinales(idFormulario,idReferencia,fechaEvaluacion,idResponsable,resultadoEvaluacion,comentarios,noEvaluacion)
					VALUES(".$idFormulario.",".$obj->idProyecto.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->resultado.",'".cv($obj->comentarios)."',".$idEvaluacion.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function obtenerComentariosProyectos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$arrRegistros="";
		$nReg=0;
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="select codigo from _370_tablaDinamica WHERE id__370_tablaDinamica=".$idRegistro;
		$folio=$con->obtenerValor($consulta);
		$consulta="SELECT distinct comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
				idFormularioDictamen AS idFormulario,idRegistroDictamen AS idRegistro,visualizado,idComentario FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormulario."  AND idRegistro=".$idRegistro;
		$res=$con->obtenerFilas($consulta);		
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"tipoEvaluacion":"0","fechaComentario":"'.$fila[2].'","actorComentario":"'.$fila[3].'","dictamen":"'.$fila[1].'","comentario":"'.cv($fila[0]).'","descripcion":"Proyecto: '.$folio.'","visualizado":"'.$fila[6].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
			if($fila[6]==0)
			{
				$query[$x]="update 2002_comentariosRegistro set visualizado=1 where idComentario=".$fila[7];
				$x++;
			}
			
		}
		
		$consulta="SELECT id__401_tablaDinamica,txtDescripcion FROM _401_tablaDinamica WHERE idReferencia=".$idRegistro;
		$resReg=$con->obtenerFilas($consulta);
		while($fReg=mysql_fetch_row($resReg))
		{
			$consulta="SELECT distinct comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
					idFormularioDictamen AS idFormulario,idRegistroDictamen AS idRegistro,visualizado,idComentario FROM 2002_comentariosRegistro WHERE idFormulario=401  AND idRegistro=".$fReg[0];
			$res=$con->obtenerFilas($consulta);		
			while($fila=mysql_fetch_row($res))
			{
				$obj='{"tipoEvaluacion":"1","fechaComentario":"'.$fila[2].'","actorComentario":"'.$fila[3].'","dictamen":"'.$fila[1].'","comentario":"'.cv($fila[0]).'","descripcion":"'.cv($fReg[1]).'","visualizado":"'.$fila[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nReg++;
				if($fila[6]==0)
				{
					$query[$x]="update 2002_comentariosRegistro set visualizado=1 where idComentario=".$fila[7];
					$x++;
				}
				
			}
		}
		
		$consulta="SELECT id__395_tablaDinamica,descripcion FROM _395_tablaDinamica WHERE idReferencia=".$idRegistro;
		$resReg=$con->obtenerFilas($consulta);
		while($fReg=mysql_fetch_row($resReg))
		{
			$consulta="SELECT distinct comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
					idFormularioDictamen AS idFormulario,idRegistroDictamen AS idRegistro,visualizado,idComentario FROM 2002_comentariosRegistro WHERE idFormulario=395  AND idRegistro=".$fReg[0];
			$res=$con->obtenerFilas($consulta);		
			while($fila=mysql_fetch_row($res))
			{
				$obj='{"tipoEvaluacion":"2","fechaComentario":"'.$fila[2].'","actorComentario":"'.$fila[3].'","dictamen":"'.$fila[1].'","comentario":"'.cv($fila[0]).'","descripcion":"'.cv($fReg[1]).'","visualizado":"'.$fila[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nReg++;
				if($fila[6]==0)
				{
					$query[$x]="update 2002_comentariosRegistro set visualizado=1 where idComentario=".$fila[7];
					$x++;
				}
				
			}
		}
		
		$consulta="SELECT id__395_tablaDinamica,descripcion FROM _395_tablaDinamica WHERE idReferencia=".$idRegistro;
		$resReg=$con->obtenerFilas($consulta);
		while($fReg=mysql_fetch_row($resReg))
		{
			$consulta="SELECT distinct comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
					idFormularioDictamen AS idFormulario,idRegistroDictamen AS idRegistro,visualizado,idComentario FROM 2002_comentariosRegistro WHERE idFormulario=395  AND idRegistro=".$fReg[0];
			$res=$con->obtenerFilas($consulta);		
			while($fila=mysql_fetch_row($res))
			{
				$obj='{"tipoEvaluacion":"2","fechaComentario":"'.$fila[2].'","actorComentario":"'.$fila[3].'","dictamen":"'.$fila[1].'","comentario":"'.cv($fila[0]).'","descripcion":"'.cv($fReg[1]).'","visualizado":"'.$fila[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nReg++;
				if($fila[6]==0)
				{
					$query[$x]="update 2002_comentariosRegistro set visualizado=1 where idComentario=".$fila[7];
					$x++;
				}
				
			}
		}
		
		
		
		$consulta="SELECT i.idInforme,i.noInforme FROM 3001_evaluacionesInformeTecnico e,3000_informesTecnicos i WHERE 
					e.idInforme=i.idInforme AND i.idFormulario=370 AND i.idReferencia=".$idRegistro;
		
		
		$resReg=$con->obtenerFilas($consulta);
		while($fReg=mysql_fetch_row($resReg))
		{
			$consulta="SELECT fechaEvaluacion AS fechaComentario,u.Nombre AS responsable,resultadoEvaluacion AS dictamen,comentarios AS comentario,e.idEvaluacion,visualizado FROM 3001_evaluacionesInformeTecnico e,800_usuarios u WHERE e.idInforme=".$fReg[0]." 
					AND u.idUsuario=e.idResponsableEval ORDER BY fechaEvaluacion DESC";
			$res=$con->obtenerFilas($consulta);		
			while($fila=mysql_fetch_row($res))
			{
				$dictamen="";
				switch($fila[2])
				{
					case "1":
						$dictamen="En espera de validaci&oacute;n";
					break;
					case "3":
						$dictamen="Autorizado / Aceptado";
					break;
					case "4":
						$dictamen="Requiere cambios";
					break;
						
				}
				$obj='{"tipoEvaluacion":"3","fechaComentario":"'.$fila[0].'","actorComentario":"","dictamen":"'.$dictamen.'","comentario":"'.cv($fila[3]).'","descripcion":"Informe t&eacute;cnico '.cv($fReg[1]).'","visualizado":"'.$fila[5].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nReg++;
				if($fila[5]==0)
				{
					$query[$x]="update 3001_evaluacionesInformeTecnico set visualizado=1 where idEvaluacion=".$fila[4];
					$x++;
				}
				
			}
		}
		
		$folio="N/E";
		$consulta="SELECT idFactura,visualizado,tipoComprobante,fechaEvaluacion,razonSocial,folioComprobante,comprobante FROM 101_comprobantesPresupuestales c,595_proveedores p,106_tipoComprobante t 
				WHERE idFormulario=370 AND idReferencia=".$idRegistro." AND c.situacion<>0 and p.idProveedor=c.idProveedor and t.idTipoComprobante=c.tipoComprobante";
		$resReg=$con->obtenerFilas($consulta);
		while($fReg=mysql_fetch_row($resReg))
		{
			if($fReg[5]!="")
				$folio=$fReg[5];
			$consulta="SELECT descripcion,montoComprobacion,situacion,comentarios FROM 102_conceptosComprobacion WHERE idFactura=".$fReg[0]." ORDER BY descripcion";
			$res=$con->obtenerFilas($consulta);	
			$descripcion="<table width='650'><tr><td align='left'>Evaluaci&oacute;n del comprobante con folio: ".cv($folio)." de tipo: ".$fReg[6]." del proveedor ".cv($fReg[4])."</td></tr>";
			$blConceptos="<br><table><tr height='21'><td width='250' align='center'><span class='corpo8_bold'>Concepto</span></td><td width='150' align='center'>".
						"<span class='corpo8_bold'>Monto a comprobar</span></d><td width='150' align='center'><span class='corpo8_bold'>Situaci&oacute;n</span></d><td width='350' align='center'><span class='corpo8_bold'>Comentarios</span></d></tr>".
						"<tr height='1'><td colspan='4' style='background-color:#900'></td></tr>";
						
						
			while($fila=mysql_fetch_row($res))
			{
				$dictamen="";
				switch($fila[2])
				{
					case "1":
						$dictamen="&nbsp;&nbsp;Aceptado";
					break;
					case "2":
						$dictamen="&nbsp;&nbsp;Rechazado";
					break;
						
				}
				
				$blConceptos.="<tr height='21'><td align='left'  valign='top'>".cv($fila[0])."</td><td align='right' valign='top'>$ ".number_format($fila[1],2)."</td><td valign='top' align='center'>".
				$dictamen."</td><td style='text-align:justify' valign='top'>".cv($fila[3])."</td>";
				
				
			}
			$blConceptos.='</table>';
			$descripcion.="<tr><td align='left'>".$blConceptos."</td></tr>";	
			$descripcion.="</table>";	
			$obj='{"tipoEvaluacion":"4","fechaComentario":"'.$fReg[3].'","actorComentario":"","dictamen":"N/A","comentario":"N/A","descripcion":"'.$descripcion.'","visualizado":"'.$fReg[1].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
			if($fReg[1]==0)
			{
				$query[$x]="update 101_comprobantesPresupuestales set visualizado=1 where idFactura=".$fReg[0];
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		$con->ejecutarBloque($query);

		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerProyectosGraficos()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$idProyectos=$_POST["idProyectos"];
		
		$nReg=0;
		$consulta="";
		switch($ciclo)
		{
			case 2011:
				$consulta="SELECT id__293_tablaDinamica,codigo,tituloProyecto,categorias,cmbLugarNacional,codigoInstitucion FROM _293_tablaDinamica WHERE id__293_tablaDinamica IN (".$idProyectos.") ORDER BY codigo";

			break;
			case 2012:
				$consulta="SELECT id__370_tablaDinamica,codigo,tituloProyecto,idReferencia,ambitoAplicacion,codigoInstitucion FROM _370_tablaDinamica WHERE id__370_tablaDinamica IN (".$idProyectos.") ORDER BY codigo";
			break;
			case 2013:
				$consulta="SELECT id__410_tablaDinamica,codigo,tituloProyecto,idReferencia,ambitoAplicacion,codigoInstitucion,idCategoria,idSubcategoria,idTema FROM _410_tablaDinamica WHERE id__410_tablaDinamica IN (".$idProyectos.") ORDER BY codigo";
			break;
			case 2014:
				$consulta="SELECT id__448_tablaDinamica,codigo,tituloProyecto,idReferencia,ambitoAplicacion,codigoInstitucion,idCategoria,idSubcategoria,'-1' as idTema FROM _448_tablaDinamica WHERE id__448_tablaDinamica IN (".$idProyectos.") ORDER BY codigo";
			break;
			case 2015:
				$consulta="SELECT id__498_tablaDinamica,codigo,tituloProyecto,idReferencia,'' ambitoAplicacion,codigoInstitucion,idCategoria,idSubcategoria,'-1' as idTema FROM _498_tablaDinamica WHERE id__498_tablaDinamica IN (".$idProyectos.") ORDER BY codigo";
			break;
				
		}
		$arrObj="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$ambito="";
			$categoria="";
			switch($ciclo)
			{
				case 2011:
					if($fila[4]==1)
						$ambito="Nacional";
					else
					{
						$consulta="SELECT DISTINCT cmbEntidad FROM _301_tablaDinamica WHERE idReferencia=".$fila[0];	
						$resEnt=$con->obtenerFilas($consulta);
						if($con->filasAfectadas>1)
							$ambito="Regional";
						else
							$ambito="Local";
							
					}
					
					$consulta="SELECT upper(categoria) FROM _292_tablaDinamica WHERE id__292_tablaDinamica=".$fila[3];
					$categoria=$con->obtenerValor($consulta);
					
				break;
				case 2012:
					switch($fila[4])
					{
						case 1:
							$ambito="Local";
						break;
						case 2:
							$ambito="Regional";
						break;
						case 3:
							$ambito="Nacional";
						break;
					}
					$consulta="SELECT noCategoria,upper(nombreCategoria) FROM _369_tablaDinamica t,_369_subcategorias s WHERE s.idReferencia=t.id__369_tablaDinamica AND s.id__369_subcategorias=".$fila[3];
					$fCategoria=$con->obtenerPrimeraFila($consulta);
					$categoria=removerCerosDerecha($fCategoria[0])." ".$fCategoria[1];
					
				break;
				case 2013:
					switch($fila[4])
					{
						case 1:
							$ambito="Local";
						break;
						case 2:
							$ambito="Regional";
						break;
						case 3:
							$ambito="Nacional";
						break;
					}
					$consulta="SELECT noTitulo,titulo FROM 0_distribucionTemas WHERE idCategoria=".$fila[6]." AND idSubcategoria=".$fila[7]." AND idTema=".$fila[8];
					$fCategoria=$con->obtenerPrimeraFila($consulta);
					$categoria=$fCategoria[0].".- ".$fCategoria[1];
					
				break;
				case 2014:
					switch($fila[4])
					{
						case 1:
							$ambito="Local";
						break;
						case 2:
							$ambito="Regional";
						break;
						case 3:
							$ambito="Nacional";
						break;
					}
					$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE  id__415_tablaDinamica=".$fila[7];
					$fCategoria=$con->obtenerPrimeraFila($consulta);
					$categoria=$fCategoria[0].".- ".$fCategoria[1];
					
				break;
				
				case 2015:
				
					$ambito=0;
										
					$consulta="SELECT DISTINCT count(estado) FROM _498_gridAmbitoEjecucion WHERE idReferencia=".$fila[0];
					$nEstados=$con->obtenerValor($consulta);
					if($nEstados==32)
						$ambito=3;
					else
						if($nEstados>1)
							$ambito=2;
						else
							$ambito=1;
										
				
					switch($ambito)
					{
						case 1:
							$ambito="Local";
						break;
						case 2:
							$ambito="Regional";
						break;
						case 3:
							$ambito="Nacional";
						break;
					}
					$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE  id__414_tablaDinamica=".$fila[6];
					$fCategoria=$con->obtenerPrimeraFila($consulta);
					$categoria=$fCategoria[0].".- ".$fCategoria[1];
					
				break;
					
			}
			
			$consulta="select unidad from 817_organigrama where codigoUnidad='".$fila[5]."'";
			$osc=$con->obtenerValor($consulta);
			$obj='{"idProyecto":"'.$fila[0].'","folioProyecto":"'.$fila[1].'","categoria":"'.cv($categoria).'","titulo":"'.cv($fila[2]).'","osc":"'.cv($osc).'","ambito":"'.$ambito.'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrObj.']}';
		
	}
	
	function obtenerCategoriasCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$consulta="";
		$arrRegistro="";
		switch($idCiclo)
		{
			case "2011":
				$consulta="SELECT id__292_tablaDinamica,UPPER(categoria) FROM _292_tablaDinamica WHERE id__292_tablaDinamica<9 ORDER BY categoria";
				$arrRegistro=$con->obtenerFilasArreglo($consulta);
			break;
			case "2012":
				$consulta="SELECT id__369_tablaDinamica,noCategoria,nombreCategoria FROM _369_tablaDinamica ORDER BY noCategoria";
				$res=$con->obtenerFilas($consulta);
				while($fCategoria=mysql_fetch_row($res))
				{
					$categoria=removerCerosDerecha($fCategoria[1])." ".$fCategoria[2];
					$obj="['".$fCategoria[0]."','".$categoria."']";
					if($arrRegistro=="")
						$arrRegistro=$obj;
					else
						$arrRegistro.=",".$obj;
				}
				$arrRegistro='['.$arrRegistro.']';
				
			break;
			case "2013":
				$consulta="SELECT llave,CONCAT(noTitulo,' ',titulo) AS categoria FROM 0_distribucionTemas ORDER BY idCategoria,idSubcategoria,idTema ";
				$res=$con->obtenerFilas($consulta);
				while($fCategoria=mysql_fetch_row($res))
				{
					
					$obj="['".$fCategoria[0]."','".cv($fCategoria[1])."']";
					if($arrRegistro=="")
						$arrRegistro=$obj;
					else
						$arrRegistro.=",".$obj;
				}
				$arrRegistro='['.$arrRegistro.']';
			break;
			case "2014":
				
				$consulta="SELECT id__415_tablaDinamica,CONCAT(noSubcategoria,'.- ',tituloSubcategoria) FROM _415_tablaDinamica WHERE idReferencia=2 ORDER BY noSubcategoria";
				$arrRegistro=$con->obtenerFilasArreglo($consulta);

			break;
			case "2015":
				
				$consulta="SELECT id__414_tablaDinamica,CONCAT(noCategoria,'.- ',tituloCategoria) FROM _414_tablaDinamica WHERE idReferencia=4 ORDER BY noCategoria";
				$arrRegistro=$con->obtenerFilasArreglo($consulta);

			break;


		}
		echo "1|".$arrRegistro;
	}
	
	function obtenerCategoriasRegistroProyectosConfiguracion()
	{
		global $con;
		$arrRegistros="";
		$idConfiguracion=$_POST["idConfiguracion"];
		
		$consulta="SELECT permiteMas1RegistroCategoria,procesoAsociado FROM _412_tablaDinamica WHERE id__412_tablaDinamica=".$idConfiguracion;

		$fDatosConv=$con->obtenerPrimeraFila($consulta);
		$permiteMas1RegistroCategoria=$fDatosConv[0];
		$procesoAsociado=$fDatosConv[1];
		$idFormularioBase=obtenerFormularioBase($procesoAsociado);
		
		
		$consulta="SELECT id__414_tablaDinamica,concat(noCategoria,'.- ',tituloCategoria),descripcion FROM _414_tablaDinamica WHERE idReferencia=".$idConfiguracion."  ORDER BY noCategoria";
		$res=$con->obtenerFilas($consulta);
		$cache=NULL;
		$cadObj='{"idUsuario":"'.$_SESSION["idUsr"].'","idCategoria":"","idConvocatoria":"'.$idConfiguracion.'"}';
		$objReg=json_decode($cadObj);
		
		while($fila=mysql_fetch_row($res))
		{
			$objReg->idCategoria=$fila[0];
			$maxPuntaje=0;
			$ranking=0;
			$consulta="SELECT idFuncionRecomendacion,valorRanking FROM _414_gridCondicionesRecomendacion WHERE idReferencia=".$fila[0];
			$resCondicion=$con->obtenerFilas($consulta);
			while($fCondicion=mysql_fetch_row($resCondicion))
			{
				$resEval=resolverExpresionCalculoPHP($fCondicion[0],$objReg,$cache);
				if($resEval=="")
					$resEval=0;
				$ranking+=($resEval*$fCondicion[1]);
				$maxPuntaje+=$fCondicion[1];
			}
			
			if($maxPuntaje==0)
			{
				$maxPuntaje=10;
				$ranking=10;
			}
			
			$consulta="SELECT id__415_tablaDinamica,CONCAT(noSubcategoria,'.- ',tituloSubcategoria ) FROM _415_tablaDinamica WHERE categoria=".$fila[0]." ORDER BY noSubcategoria";
			$arrSubCategorias=$con->obtenerFilasArreglo($consulta);
			
			if($permiteMas1RegistroCategoria==0)
			{
				$consulta="SELECT COUNT(*) FROM _".$idFormularioBase."_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and idCategoria=".$fila[0];

				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
					continue;
			}
			
			
			$o="['".$fila[0]."','".cv($fila[1])."','".cv(str_replace("\r\n","<br>",$fila[2]))."','".$ranking."','".$maxPuntaje."',".$arrSubCategorias."]";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		
		
		echo "1|[".$arrRegistros."]";
	}
	
	function obtenerSubCategoriasRegistroProyectosConfiguracion()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$consulta="SELECT id__415_tablaDinamica,CONCAT(noSubcategoria,'.- ',tituloSubcategoria),descripcionSubcategoria,permiteTema FROM _415_tablaDinamica WHERE categoria=".$idCategoria." ORDER BY id__415_tablaDinamica";
		$arrRegistros="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$montoMinimo="0";
			$montoMaximo="0";
			$poblacion="";
			
			if($fila[3]==0)
			{
				$consulta="SELECT id__416_tablaDinamica,montoMinimo,montoMaximo FROM _416_tablaDinamica WHERE idReferencia=".$fila[0];
				$fConfiguracion=$con->obtenerPrimeraFila($consulta);
				if($fConfiguracion)
				{
					$montoMinimo=$fConfiguracion[1];
					$montoMaximo=$fConfiguracion[2];
					$consulta="SELECT p.id__261_tablaDinamica,CONCAT('(',txtclave,') ',txtReferencia) FROM _416_poblacionBlanco t,_261_tablaDinamica p WHERE t.idReferencia=".$fConfiguracion[0]." AND p.id__261_tablaDinamica=t.poblacionBlanco";
					$respPoblacion=$con->obtenerFilas($consulta);
					$poblacion="<table>";
					while($filaPoblacion=mysql_fetch_row($respPoblacion))
					{
						$poblacion.='<tr><td><img src="../images/bullet_green.png"></td><td>'.$filaPoblacion[1].'</td></tr><br>';
					}
					$poblacion.="</table>";
					
				}
			}
			
			$o="['".$fila[0]."','".cv($fila[1])."','".cv($fila[2])."','$ ".number_format($montoMinimo,2)."','$ ".number_format($montoMaximo,2)."','".$poblacion."','".$fila[3]."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo "1|[".$arrRegistros."]";
	}
	
	function obtenerTemasSubCategoriasRegistroProyectosConfiguracion()
	{
		global $con;
		$idSubCategoria=$_POST["idSubCategoria"];
		$consulta="SELECT id__418_tablaDinamica,CONCAT(noPoblacion,'.- ',tituloTema),descripcion,montoMinimo,montoMaximo FROM _418_tablaDinamica WHERE idReferencia=".$idSubCategoria." ORDER BY id__418_tablaDinamica";
		$arrRegistros="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$montoMinimo=$fila[3];
			$montoMaximo=$fila[4];
			$poblacion="";
			$consulta="SELECT p.id__261_tablaDinamica,CONCAT('(',txtclave,') ',txtReferencia) FROM _418_poblacionBlanco t,_261_tablaDinamica p WHERE t.idReferencia=".$fila[0]." AND p.id__261_tablaDinamica=t.poblacionBlanco";
			$respPoblacion=$con->obtenerFilas($consulta);
			$poblacion="<table>";
			while($filaPoblacion=mysql_fetch_row($respPoblacion))
			{
				$poblacion.='<tr><td><img src="../images/bullet_green.png"></td><td>'.$filaPoblacion[1].'</td></tr><br>';
			}
			$poblacion.="</table>";
				
			
			
			$o="['".$fila[0]."','".cv($fila[1])."','".cv($fila[2])."','$ ".number_format($montoMinimo,2)."','$ ".number_format($montoMaximo,2)."','".$poblacion."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo "1|[".$arrRegistros."]";
	}
	
	function validarRegistroProyecto()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$idCategoria=$_POST["idCategoria"];
		$idSubcategoria=$_POST["idSubcategoria"];
		$idTema=$_POST["idTema"];
		$consulta="SELECT funcionValidadoraNuevo FROM _412_tablaDinamica WHERE id__412_tablaDinamica=".$idConfiguracion;
		$idFuncionvalidacion=$con->obtenerValor($consulta);
		if(($idFuncionvalidacion!="")&&($idFuncionvalidacion!="-1"))
		{
			$cadObj='{"idConfiguracion":"'.$idConfiguracion.'","idCategoria":"'.$idCategoria.'","idSubcategoria":"'.$idSubcategoria.'","idTema":"'.$idTema.'"}';
			$obj=json_decode($cadObj);
			$cache=NULL;
			$res=normalizarValorConsulta(resolverExpresionCalculoPHP($idFuncionvalidacion,$obj,$cache));	
			if($res!="[]")
			{
				echo "1|".$res;
				return ;
			}
		}
		echo "1|1";
	}
	
	function obtenerListaProyectosConfiguracion()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$situacion=$_POST["situacion"];
		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idFormulario,c.procesoAsociado FROM _412_tablaDinamica c,900_formularios f WHERE  f.idProceso=c.procesoAsociado AND f.formularioBase=1 and id__412_tablaDinamica=".$idConfiguracion;
		$fFrm=$con->obtenerPrimeraFila($consulta);
		$idFormularioBase=$fFrm[0];
		$idProceso=$fFrm[1];
		$numReg=0;
		$cadRegistros="";
		
		
		$compUsr="";
		if(existeRol("'94_0'"))
		{
			$compUsr=" and (responsable=".$_SESSION["idUsr"]." OR coordinador in(SELECT id__379_tablaDinamica FROM _379_tablaDinamica WHERE idUsuarioSistema=".$_SESSION["idUsr"]."))";	
		}
		
		$consulta="select id__".$idFormularioBase."_tablaDinamica,".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2].",codigo,".$fConfiguracion[3].",fechaCreacion,responsable,idEstado from _".$idFormularioBase."_tablaDinamica
				where codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and idEstado in (".$situacion.") ".$compUsr." order by codigo";
		

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$montoSolicitado=0;
			$montoAutorizado=0;
			
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[1];
			$fReg=$con->obtenerPrimeraFila($consulta);
			$noCategoria=$fReg[0];
			$categoria=($fReg[1]);
			$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[2];
			$fReg=$con->obtenerPrimeraFila($consulta);
			$noSubcategoria=($fReg[0]);
			$subcategoria=($fReg[1]);
			$consulta="SELECT noPoblacion,tituloTema FROM _418_tablaDinamica WHERE id__418_tablaDinamica=".$fila[3];
			$fReg=$con->obtenerPrimeraFila($consulta);
			$noTema=$fReg[0];
			$tema=($fReg[1]);
			$cadObj='{"idFormulario":"'.$idFormularioBase.'","idRegistro":"'.$fila[0].'"}';
			$objReg=json_decode($cadObj);
			$cache=NULL;					
						
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$fila[8];			
			$fEtapa=$con->obtenerPrimeraFila($consulta);					 
			$situacionActual=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
			if(($fConfiguracion[4]!="")&&($fConfiguracion[4]!=-1))
			{
				$montoSolicitado=resolverExpresionCalculoPHP($fConfiguracion[4],$objReg,$cache);
				$montoSolicitado=str_replace("'","",$montoSolicitado);
				if($montoSolicitado=="")
					$montoSolicitado=0;
			}
			
			if(($fConfiguracion[5]!="")&&($fConfiguracion[5]!=-1))
			{
				$montoAutorizado=resolverExpresionCalculoPHP($fConfiguracion[5],$objReg,$cache);
				$montoAutorizado=str_replace("'","",$montoSolicitado);
				if($montoAutorizado=="")
					$montoAutorizado=0;
			}
			
			$responsable=obtenerNombreUsuarioPaterno($fila[7]);
			$obj='{"situacionActual":"'.$situacionActual.'","idProyecto":"'.$fila[0].'","noCategoria":"'.$noCategoria.'","categoria":"'.cv($categoria).'","noSubcategoria":"'.$noSubcategoria.'","subcategoria":"'.cv($subcategoria).'","noTema":"'.$noTema.'","tema":"'.cv($tema).
				'","folio":"'.$fila[4].'","tituloProyecto":"'.cv($fila[5]).'","fechaRegistro":"'.$fila[6].'","montoSolicitado":"'.$montoSolicitado.'","responsableRegistro":"'.$responsable.'","situacion":"'.$fila[8].
				'","montoAutorizado":"'.$montoAutorizado.'"}';
			if($cadRegistros=="")
				$cadRegistros=$obj;
			else
				$cadRegistros.=",".$obj;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
		
	}
	
	function obtenerMetasProyectos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$cadActividades="";
		$nReg=0;
		for($x=1;$x<=5;$x++)
		{
		
			$cadHijos="";	
			$consulta="SELECT idMeta,meta FROM 108_metasProyectos  WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and noObjetivo=".$x;
			$res=$con->obtenerFilas($consulta);

			while($fila=mysql_fetch_row($res))
			{
				/*$texto="<table width='800'><tr><td width='20'></td><td valign='top' width='25'><img src='../images/bullet_green.png'></td><td>".str_replace("#R","",cv($fila[1]))."</td></tr></table><br>";
				
				$oHijo='{"tipo":"2","objetivoAsoc":"'.$x.'","text":"'.$texto.'","textoOriginal":"'.cv(str_replace("#R","",cv($fila[1]))).'","icon":"../images/s.gif","id":"'.$fila[0].'","leaf":true}';
				if($cadHijos=="")
					$cadHijos=$oHijo;
				else
					$cadHijos.=",".$oHijo;*/
					
				$obj='{"idMeta":"'.$fila[0].'","meta":"'.cv($fila[1]).'","noObjetivo":"'.$x.'"}';	
				if($cadActividades=="")	
					$cadActividades=$obj;
				else
					$cadActividades.=",".$obj;
				$nReg++;
			}
			/*if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			$obj='{"tipo":"1","text":"<span style=\'color:#003;font-size:12px\'><b>Metas asociadas al Objetivo Espec&iacute;fico '.$x.'</b></span>","icon":"../images/s.gif","id":"obj_'.$x.'"'.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;*/
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$cadActividades.']}';
	}
	
	function guardarMetaProyectos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idMeta==-1)
			$consulta="INSERT INTO 108_metasProyectos(idFormulario,idReferencia,meta,noObjetivo) VALUES(".$obj->idFormulario.",".$obj->idRegistro.",'".cv($obj->meta)."',".$obj->objetivoAsociado.")";
		else
			$consulta="update 108_metasProyectos set meta='".cv($obj->meta)."',noObjetivo=".$obj->objetivoAsociado." where idMeta=".$obj->idMeta;
		eC($consulta);
		
	}
	
	function removerMetaProyectos()
	{
		global $con;
		$idMeta=$_POST["idMeta"];
		$consulta="delete FROM 108_metasProyectos WHERE idMeta=".$idMeta;
		eC($consulta);
	}
	
	
	function obtenerIndicadoresActividad()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idActividad=$_POST["idActividad"];
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idConfiguracion=$con->obtenerValor($consulta);

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$cadRegistros="";
		$consulta="SELECT idIndicador,nombreIndicador FROM 1026_catalogoIndicadores2014 WHERE  idIndicador in (SELECT idIndicador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.") ORDER BY nombreIndicador";
		
		$res=$con->obtenerFilas($consulta);
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$afecta="false";
			$consulta="SELECT COUNT(*) FROM 968_actividadesIndicador WHERE  idActividad=".$idActividad." AND idIndicador=".$fila[0];
			$nReg=$con->obtenerValor($consulta);
			if($nReg>0)
				$afecta="true";
			$obj='{"idIndicador":"'.$fila[0].'","txtIndicador":"'.cv($fila[1]).'","afecta":'.$afecta.'}';
			if($cadRegistros=="")
				$cadRegistros=$obj;
			else
				$cadRegistros.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$cadRegistros.']}';
	}
	
	
	function obtenerActividadesCronogramaV2()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		$mesIni=$_POST["mesIni"];
		$mesFin=$_POST["mesFin"];
		$consulta="SELECT idActividadPrograma,actividad,descripcion FROM 965_actividadesUsuario WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and idPadre=-1 order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		

		
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x."";
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$hijos="";
			$cadHijos=obtenerActividadesHijosV2($fila[0],$mesIni,$mesFin);

			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			$consulta="SELECT meta FROM 108_metasProyectos WHERE idMeta=".$fila[2];

			$nombreMeta=$con->obtenerValor($consulta);
			
			$nombreMeta=str_replace("<br />","",$nombreMeta);
			$nombreMeta=str_replace("#R",". ",$nombreMeta);
			$consulta="SELECT COUNT(*) FROM 968_actividadesIndicador WHERE idActividad=".$fila[0];
			$nIndicadores=$con->obtenerValor($consulta);
			if($nIndicadores>0)
				$nIndicadores=1;
			
			$obj='{"afectaIndicadores":"'.$nIndicadores.'","txtObjetivo":"'.cv($nombreMeta).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","metaAsoc":"'.$fila[2].'"'.$comp.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		echo "[".$cadActividades."]";
	}

	function obtenerActividadesHijosV2($idActividad,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion FROM 965_actividadesUsuario WHERE idPadre=".$idActividad. " order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		while($fila=mysql_fetch_row($res))
		{
			
			
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x; 
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$cadHijos=obtenerActividadesHijosV2($fila[0],$mesIni,$mesFin);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			$consulta="SELECT meta FROM 108_metasProyectos WHERE idMeta=".$fila[2];
			$nombreMeta=$con->obtenerValor($consulta);
			$nombreMeta=str_replace("<br />","",$nombreMeta);
			$nombreMeta=str_replace("#R",". ",$nombreMeta);
			$consulta="SELECT COUNT(*) FROM 968_actividadesIndicador WHERE idActividad=".$fila[0];
			$nIndicadores=$con->obtenerValor($consulta);
			if($nIndicadores>0)
				$nIndicadores=1;
			$obj='{"afectaIndicadores":"'.$nIndicadores.'","txtObjetivo":"'.cv($nombreMeta).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","metaAsoc":"'.$fila[2].'"'.$comp.$hijos.'}';
			
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return $cadActividades;
	}
	
	function guardarActividadCronogramaV2()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idMeta=-1;
		if(isset($obj->idMeta))
			$idMeta=$obj->idMeta;
		
		$idIntervencion="NULL";
		$actividadIntervencion="NULL";
		
		
		if(isset($obj->idIntervencion))
			$idIntervencion=$obj->idIntervencion;
			
		if(isset($obj->idActividadIntervencion))
			$actividadIntervencion=$obj->idActividadIntervencion;	
			
		
		if($obj->idActividad==-1)
		{
			$consulta[$x]="INSERT INTO 965_actividadesUsuario(actividad,idUsuario,idFormulario,idReferencia,descripcion,idPadre,idMeta,idIntervencion,actividadIntervencion) 
							VALUES ('".cv($obj->actividad)."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idRegistro.",'".$obj->metaAsociado."',".$obj->idPadre.",".$idMeta.
							",".$idIntervencion.",".$actividadIntervencion.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 965_actividadesUsuario set idIntervencion=".$idIntervencion.",actividadIntervencion=".$actividadIntervencion.",actividad='".cv($obj->actividad)."',descripcion='".$obj->metaAsociado."' where idActividadPrograma=".$obj->idActividad;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idActividad;
			$x++;
		}
		$consulta[$x]="delete from 968_planeacionActividadesMeses where idActividad=@idRegistro";
		$x++;
		foreach($obj->arrMeses as $mes)
		{
			$consulta[$x]="INSERT INTO 968_planeacionActividadesMeses(idActividad,mes,valor)
							VALUES(@idRegistro,".$mes->mes.",'".$mes->valor."')";
			$x++;							
		}
		$consulta[$x]="delete from 968_actividadesIndicador where idActividad=@idRegistro";
		$x++;
		if($obj->afectaIndicadores==1)
		{
			$arrIndicadores=explode(",",$obj->listaIndicadores);
			if(sizeof($arrIndicadores)>0)
			{
				foreach($arrIndicadores as $idIndicador)
				{
					$consulta[$x]="INSERT INTO 968_actividadesIndicador(idActividad,idIndicador)
									VALUES(@idRegistro,'".$idIndicador."')";
					$x++;							
				}
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerIndicadoresProyectos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idConfiguracion=$con->obtenerValor($consulta);

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT i.idIndicador,i.nombreIndicador,numerador,denominador,t.tipoIndicador FROM 0_indicadoresProyectos i,_431_tablaDinamica t WHERE idSubcategoria=".$fDatos[1]." AND idTema=".$fDatos[2]."
		and t.id__431_tablaDinamica=i.tipoIndicador order by t.tipoIndicador,nombreIndicador";
		$res=$con->obtenerFilas($consulta);
		$cadIndicadores="";
		$total=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT numerador,denominador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idIndicador=".$fila[0];
			$fIndicador=$con->obtenerPrimeraFila($consulta);
			if($fIndicador)
			{
				if($fIndicador[0]=="")
					$fIndicador[0]=0;
				if($fIndicador[1]=="")
					$fIndicador[1]=0;
			}
			else
			{
				$fIndicador[0]=0;
				$fIndicador[1]=0;
			}
				
			
			$obj='{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"1","nombreUnidad":"'.cv($fila[2]).'","cantidad":"'.$fIndicador[0].'"}';
			if($fila[3]!="")
			{
				$obj.=',{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"2","nombreUnidad":"'.cv($fila[3]).'","cantidad":"'.$fIndicador[1].'"}';
				$total++;
			}
			
			if($cadIndicadores=="")
				$cadIndicadores=$obj;
			else
				$cadIndicadores.=",".$obj;
			$total++;
		}
		
		echo '{"numReg":"'.$total.'","registros":['.$cadIndicadores.']}';
		
	}
	
	function guardarIndicadoresProyectos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 109_indicadoresProyectos WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$x++;
		foreach($obj->arrIndicadores as $i)
		{
			$consulta[$x]="INSERT INTO 109_indicadoresProyectos(idIndicador,numerador,denominador,idFormulario,idReferencia)
						VALUES(".$i->idIndicador.",".$i->numerador.",".$i->denominador.",".$obj->idFormulario.",".$obj->idReferencia.")";	
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerPoblacionesBlancoProyectos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$tPoblacion=$_POST["tPoblacion"];
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idConfiguracion=$con->obtenerValor($consulta);

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;

		$fDatos=$con->obtenerPrimeraFila($consulta);
		$listRango="";
		$consulta="SELECT DISTINCT idRangoEdad FROM 111_poblacionRangoEdad WHERE idPoblacion IN 
					(SELECT distinct idPoblacion FROM 0_poblacionesBlancoProyectos WHERE  idSubcategoria=".$fDatos[1]." AND idTema=".$fDatos[2].")";
		$listRango=$con->obtenerListaValores($consulta);
		if($listRango=="")
			$listRango=-1;
		$consulta="SELECT idPoblacion,nombrePoblacion FROM 0_poblacionesBlancoProyectos WHERE  idSubcategoria=".$fDatos[1]." AND idTema=".$fDatos[2]."  ORDER BY nombrePoblacion";
		if(($idFormulario==410) &&($idRegistro==218))
		{
			$listRango=5;	
			$consulta="SELECT distinct idPoblacion,nombrePoblacion FROM 0_poblacionesBlancoProyectos WHERE idPoblacion=1   ORDER BY nombrePoblacion";
		}
		
		

		$res=$con->obtenerFilas($consulta);
		$cadRegistros="";
		$nRegistros=0;
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			$consulta="SELECT id__411_tablaDinamica,txtGrupoEdad FROM _411_tablaDinamica where id__411_tablaDinamica in(".$listRango.") ORDER BY id__411_tablaDinamica";
			$resEdad=$con->obtenerFilas($consulta);
			while($filaEdad=mysql_fetch_row($resEdad))
			{
				$consulta="SELECT COUNT(*) FROM 111_poblacionRangoEdad WHERE idPoblacion=".$fila[0]." AND idRangoEdad=".$filaEdad[0];
				$nReg=$con->obtenerValor($consulta);
				if($nReg!=0)
				{
					$consulta="SELECT valor FROM 110_poblacionBancoProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idPoblacion=".$fila[0]." AND idRangoEdad=".$filaEdad[0]." and tipoPoblacion=".$tPoblacion;
					$valorRango=$con->obtenerValor($consulta);
					if($valorRango=="")
						$valorRango=0;
				}
				else
					$valorRango=-1000;
				$comp.=',"rango_'.$filaEdad[0].'":"'.$valorRango.'"';
			}
			$obj='{"idPoblacion":"'.$fila[0].'","nombrePoblacion":"'.cv($fila[1]).'"'.$comp.'}';
			if($cadRegistros=="")
				$cadRegistros=$obj;
			else
				$cadRegistros.=",".$obj;
			$nRegistros++;
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$cadRegistros.']}';
	}
	
	function guardarPoblacionProyectos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 110_poblacionBancoProyectos WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$x++;
		foreach($obj->arrPobDirecto as $p)
		{
			$consulta[$x]="INSERT INTO 110_poblacionBancoProyectos(idFormulario,idReferencia,idPoblacion,idRangoEdad,valor,tipoPoblacion)
						VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$p->idPoblacion.",".$p->idRangoEdad.",".$p->valor.",1)";
			$x++;

		}
		if(sizeof($obj->arrPobIndirecto)>0)
		{
			foreach($obj->arrPobIndirecto as $p)
			{
				$consulta[$x]="INSERT INTO 110_poblacionBancoProyectos(idFormulario,idReferencia,idPoblacion,idRangoEdad,valor,tipoPoblacion)
							VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$p->idPoblacion.",".$p->idRangoEdad.",".$p->valor.",2)";
				$x++;
	
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerSituacionCategoriasV2()
	{
		global $con;
		$consulta="SELECT idCategoria,idSubcategoria,idTema,CONCAT(noTitulo,'.- ',titulo) AS titulo,montoMaximo,totalProyectosFinanciar,
					(SELECT COUNT(*) FROM _410_tablaDinamica WHERE idCategoria=d.idCategoria AND idSubcategoria=d.idSubcategoria AND idTema=d.idTema) AS totalProyectosRegistrado,
					(montoMaximo*totalProyectosFinanciar) as montoTotal 
					FROM 0_distribucionTemas d ORDER BY idCategoria,idSubcategoria,idTema";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
			
	}
	
	function obtenerProyectosRegistradoTema()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$idSubcategora=$_POST["idSubcategoria"];
		$idTema=$_POST["idTema"];
		$consulta="SELECT id__410_tablaDinamica AS idProyecto,t.codigo AS folio,tituloProyecto AS titulo,
				(IF((SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=410 AND idReferencia=t.id__410_tablaDinamica) IS NULL,0,
				(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=410 AND idReferencia=t.id__410_tablaDinamica)) ) AS montoSolicitado,
				t.idEstado AS situacion,o.id__367_tablaDinamica AS idOrganizacion,organizacion FROM
				_410_tablaDinamica t,_367_tablaDinamica o WHERE o.codigoInstitucion=t.codigoInstitucion AND t.idCategoria=".$idCategoria." AND t.idSubcategoria=".$idSubcategora." AND t.idTema=".$idTema." ORDER BY t.codigo";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function registrarMotivoRechazoRevisor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idUsuario=$_POST["idUsuario"];
		$comentario=$_POST["comentario"];
		$consulta="UPDATE 1010_distribucionRevisoresProyectos SET comentarios='".cv($comentario)."' WHERE idRegistro=".$idUsuario." AND idFormulario=".$idFormulario;
		eC($consulta);
	}
	
	function obtenerEvaluadoresProyectos()
	{
		global $con;
		$idProyectos=$_POST["idProyectos"];
		$consulta="SELECT id__410_tablaDinamica AS idProyecto,codigo,concat('[',codigo,'] ',tituloProyecto) as tituloProyecto,perteneceCensida,asisteReunion,a.idUsuario,(select Nombre from 800_usuarios where idUsuario=a.idUsuario) as revisor,
					(SELECT calificacionFinal FROM  9053_resultadoCuestionario r,1011_asignacionRevisoresProyectos ar 
					WHERE ar.idUsuario=a.idUsuario AND ar.idFormulario=r.idReferencia1 AND  ar.idProyecto=r.idReferencia2 AND ar.situacion=2 AND   r.idReferencia1=410 AND r.idReferencia2=t.id__410_tablaDinamica AND r.responsableRegistro=a.idUsuario) AS calificacion ,
					(SELECT idRegistroCuestionario FROM  9053_resultadoCuestionario r,1011_asignacionRevisoresProyectos ar 
					WHERE ar.idUsuario=a.idUsuario AND ar.idFormulario=r.idReferencia1 AND  ar.idProyecto=r.idReferencia2 AND ar.situacion=2 AND   r.idReferencia1=410 AND r.idReferencia2=t.id__410_tablaDinamica AND r.responsableRegistro=a.idUsuario) AS idCuestionario
					FROM _410_tablaDinamica t,1011_asignacionRevisoresProyectos a 
					WHERE a.idFormulario=410 AND a.idProyecto=t.id__410_tablaDinamica AND id__410_tablaDinamica IN(".$idProyectos.") ORDER BY codigo,calificacion";
		$registros=$con->obtenerFilasJSON($consulta);
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$numReg.'","registros":'.utf8_encode($registros).'}';
	}
	
	function cambiarMarcaProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$valor=$_POST["valor"];
		$idMotivo=0;
		if(isset($_POST["idMotivo"]))
			$idMotivo=$_POST["idMotivo"];
		$comentarios=$_POST["comentarios"];
		$consulta="UPDATE _".$idFormulario."_tablaDinamica SET idMotivoDescalificacion=".$idMotivo.",comentariosMarca='".cv($comentarios)."',
				marcaAutorizado='".$valor."',respMarca=".$_SESSION["idUsr"].",fechaMarca='".date("Y-m-d H:i:s")."' 
				WHERE id__".$idFormulario."_tablaDinamica in (".$idRegistro.")";
		eC($consulta);
		
	}
	
	function asignarRevisionComite()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$idUsuario=$_SESSION["idUsr"];
		$consulta="SELECT COUNT(*) FROM 1011_asignacionRevisoresProyectos WHERE 
					idUsuario=".$idUsuario." AND idProyecto=".$idRegistro." AND idFormulario=".$idFormulario;
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$consulta="INSERT INTO 1011_asignacionRevisoresProyectos(idUsuario,idProyecto,tipoRevisor,idFormulario,situacion,fechaAsignacion,perteneceCensida,asisteReunion,esEvaluacionComite)
						VALUES(".$idUsuario.",".$idRegistro.",3,".$idFormulario.",1,'".date("Y-m-d H:i:s")."',1,1,1)";
			eC($consulta);
		}
		else
			echo "1|";
	}
	
	function cerrarCategoria()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$idSubcategoria=$_POST["idSubcategoria"];
		$idTema=$_POST["idTema"];
		$listaProyectos=$_POST["listaProyectos"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 1019_categoriasCerradas(idCategoria,idSubcategoria,idTema) VALUES(".$idCategoria.",".$idSubcategoria.",".$idTema.")";
		$x++;
		$consulta[$x]="UPDATE _410_tablaDinamica SET marcaAutorizado=1,comentariosMarca='',respMarca=".$_SESSION["idUsr"].",fechaMarca='".date("Y-m-d H:i:s")."' WHERE 
						id__410_tablaDinamica IN(".$listaProyectos.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarIgnorarSituacion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$comentarios=$_POST["comentarios"];
		$consulta="INSERT INTO 1021_proyectosIgnoraSituacion(idFormulario,idProyecto,fechaIgnora,idResponsable,motivo)		
					VALUES(".$idFormulario.",".$idRegistro.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($comentarios)."')";
		eC($consulta);
	}
	
	function registrarComentariosProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 1022_comentariosProyectos where idFormulario=".$obj->idFormulario." and idProyecto=".$obj->idProyecto;
		$x++;
		$consulta[$x]="INSERT INTO 1022_comentariosProyectos(fechaComentario,responsable,idFormulario,idProyecto,comentario)
				VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idProyecto.",'".cv($obj->comentarios)."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerComentariosProyectoV3()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select comentario from 1022_comentariosProyectos where idFormulario=".$idFormulario." and idProyecto=".$idRegistro;
		$comentario=$con->obtenerValor($consulta);
		echo "1|".$comentario;
		
	}
	
	function obtenerComentariosDescalificacion()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT comentariosMarca,idMotivoDescalificacion FROM _410_tablaDinamica WHERE id__410_tablaDinamica=".$idProyecto;
		$fDatos=$con->obtenerPrimeraFila($consulta);;
		echo "1|".$fDatos[1]."|".$fDatos[0];
	}
	
	function generarListadoAleatorio()
	{
		global $con;
		$porcentaje=30;
		$cadRevisar='58,59,118,119,120,121,135,136,342,344,357,327,69,153,414,409,322,131,220,51,134,53,193,154,405,84,27,278,74';
		$arRevisar=split(",",$cadRevisar);
		$arrCategoriasPresupuesto=array();
		$consulta=" SELECT llave,d.noTitulo,d.titulo FROM 0_distribucionTemas d order by d.noTitulo";

		$resCategoria=$con->obtenerFilas($consulta);
		while($fCategoria=mysql_fetch_row($resCategoria))
		{
			if(!isset($arrCategoriasPresupuesto[$fCategoria[0]]))
			{
				$arrCategoriasPresupuesto[$fCategoria[0]][0]=$fCategoria[0];
				$arrCategoriasPresupuesto[$fCategoria[0]][1]=$fCategoria[1];
				$arrCategoriasPresupuesto[$fCategoria[0]][2]=$fCategoria[2];
				$arrCategoriasPresupuesto[$fCategoria[0]][3]=array();
				$arrCategoriasPresupuesto[$fCategoria[0]][3][0]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][0]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][1]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][1]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][2]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][2]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][3]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][3]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][4]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][4]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][5]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][5]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][3][6]["valor"]=0;
				$arrCategoriasPresupuesto[$fCategoria[0]][3][6]["proyectos"]="";
				$arrCategoriasPresupuesto[$fCategoria[0]][4]=0;
			}
		}
		$cadCategoriasPresupuesto="";
		$arrPoblacion=array();
		obtenerSituacionCategorias($arrCategoriasPresupuesto,410);
		foreach($arrCategoriasPresupuesto as $c=>$resto)
		{
			$listProy=$resto[3][0]["proyectos"];
			if($listProy!="")
			{
				$arrProy=explode(",",$listProy);
				foreach($arrProy as $idProyecto)
				{
					if(!existeValor($arRevisar,$idProyecto))
					{
						array_push($arrPoblacion,$idProyecto);
					}
				}
			}
		}
		
		$listProyPoblacion=implode(",",$arrPoblacion);
		$numElementos=sizeof($arrPoblacion);
		$numElementos+=sizeof($arRevisar);
		$numElemMuestra=parteEntera($numElementos*($porcentaje/100));
		$consulta="INSERT INTO 1023_proyectosEvalConsistentes(idProyecto,idFormulario)
					SELECT id__410_tablaDinamica,'410' AS idFormulario FROM _410_tablaDinamica WHERE id__410_tablaDinamica IN (".$listProyPoblacion.") LIMIT 0,".$numElemMuestra;
		eC($consulta);	
	}
	
	function obtenerSituacionFinancieraProyectos2013()
	{
		global $con;

		$condWhere="1=1";
		if(existeRol("'44_0'")||existeRol("'84_0'")||existeRol("'85_0'")||existeRol("'86_0'")||existeRol("'44_0'")||existeRol("'1_0'")||existeRol("'118_0'"))
				$condWhere="1=1";
		else
			if(existeRol("'75_0'"))
			{
				$condWhere=" idRegistro in (SELECT f.idProyecto FROM _435_tablaDinamica t,_435_folioProyectos f WHERE usuarios=".$_SESSION["idUsr"]." AND f.idReferencia=t.id__435_tablaDinamica)";
			}
			else
				$condWhere="1=2";
		$consulta="SELECT * FROM (
								SELECT id__410_tablaDinamica as idRegistro,codigo,tituloProyecto,(SELECT SUM(montoAutorizado) FROM 100_rubrosAutorizados WHERE idFormulario=410 and idRegistro=p.id__410_tablaDinamica ) AS montoAutorizado,
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) as comprobacionPorValidar,
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) 
								
								)as montoPorEvaluar,
								
								'0' as montoPorComprobar,
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
								
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
								
								) as montoReportado,
								'0' as montoComprobado,
								
								(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) as comprobacionRechazadas,
								
								if(
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2)is null,0,
								(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) 
								
								) as montoRechazado,
								(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND situacion=0) as comprobantesValidar,
								(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
								(select organizacion from _367_tablaDinamica o where o.codigoInstitucion=p.codigoInstitucion) as organizacion
								FROM _410_tablaDinamica p
								WHERE marcaAutorizado=1) AS t where ".$condWhere." ORDER BY codigo";
		
		$res=$con->obtenerFilas($consulta);
		
		
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$montoComprobado=0;
			
			$consulta="SELECT montoAutorizado,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion WHERE idConcepto=c.idGridVSCalculo and situacion=1) FROM 100_calculosGrid c WHERE idFormulario=410 AND idReferencia=".$fila[0];
			$resConceptos=$con->obtenerFilas($consulta);
			while($filaConceptos=mysql_fetch_row($resConceptos))
			{
				if($filaConceptos[1]=="")
					$filaConceptos[1]=0;
				if($filaConceptos[1]>$filaConceptos[0])
					$montoComprobado+=$filaConceptos[0];
				else
					$montoComprobado+=$filaConceptos[1];
			}
			
			$permisos="";
			
			
			$porComprobar=$fila[3]-$montoComprobado;
			if($porComprobar<0.01)
				$porComprobar=0;
				
			$consulta="UPDATE _410_tablaDinamica SET montoAdeudo=".$porComprobar." WHERE id__410_tablaDinamica=".$fila[0];
			$con->ejecutarConsulta($consulta);
			
			
			$obj='{"organizacion":"'.cv($fila[14]).'","idRegistro":"'.$fila[0].'","codigo":"'.$fila[1].'","tituloProyecto":"'.cv($fila[2]).'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[8].'","montoComprobado":"'.$montoComprobado.'","montoPorComprobar":"'.$fila[6].'","comprobacionPorValidar":"'.$fila[4].
					'","comprobacionRechazadas":"'.$fila[10].'","montoRechazado":"'.$fila[11].'","comprobacionesAceptadas":"'.$fila[7].'","montoPorEvaluar":"'.$fila[5].'","comprobantesValidar":"'.$fila[12].'","nSolicitudesTranferencia":"'.$fila[13].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerInformesTecnicosPeriodoCiclosVarios()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$ignorarPermisos=false;
		if(isset($obj->ignorarPermisos))
			$ignorarPermisos=true;
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=2;
		$arrEvaluaciones[3]=3;
		$arrEvaluaciones[4]=4;
		
		
		$periodo=$_POST["periodo"];
		
		
		$idEvaluacion=$arrEvaluaciones[$periodo];
		
		$consulta="SELECT id__".$idFormulario."_tablaDinamica AS idProyecto,codigo AS folio,tituloProyecto AS titulo,o.unidad as organizacion, 
				(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as situacionEvaluacion,
				(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaRealizacion,
				(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as idInforme,
				(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaModificacion,
				(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaEvaluacion,
				(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." 
					and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion				
				FROM _".$idFormulario."_tablaDinamica t,817_organigrama o 
				WHERE t.marcaAutorizado=1 AND o.codigoUnidad=t.codigoInstitucion ORDER BY o.codigoUnidad,t.codigo";
		$res=$con->obtenerFilas($consulta);
		$arrReg="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$permisos="";
			$consulta="SELECT COUNT(*) FROM _435_tablaDinamica t,_435_folioProyectos g WHERE usuarios=".$_SESSION["idUsr"]." AND g.idReferencia=t.id__435_tablaDinamica AND g.idProyecto=".$fila[0];
			$numReg=$con->obtenerValor($consulta);
			//if($numReg!=0)
			$permisos="TFPCL";
			if(!$ignorarPermisos)
			{
				if(($numReg==0)&&($_SESSION["idUsr"]!=1)&&($_SESSION["idUsr"]!=1342)&&($_SESSION["idUsr"]!=461)&&($_SESSION["idUsr"]!=70)&&($_SESSION["idUsr"]!=1311))
				{
					continue;
				}
			}
			$consulta="SELECT resultadoEvaluacion FROM 3002_evaluacionesFinales WHERE idFormulario=".$idFormulario." AND idReferencia=".$fila[0]." and noEvaluacion=".$idEvaluacion." ORDER BY idEvaluacionFinal desc limit 0,1";
			$resEval=$con->obtenerValor($consulta);
			$obj='{"comentariosEvaluacion":"'.cv(str_replace("#R","",$fila[9])).'","situacionDictamenFinal":"'.$resEval.'","idProyecto":"'.$fila[0].'","folio":"'.$fila[1].'","organizacion":"'.cv($fila[3]).'","fechaRealizacion":"'.$fila[5]
				.'","titulo":"'.cv($fila[2]).'","idInforme":"'.$fila[6].'","situacionEvaluacion":"'.$fila[4].
				'","fechaUltimaModificacion":"'.$fila[7].'","fechaUltimaEvaluacion":"'.$fila[8].'","permisos":"'.$permisos.'"}';
			if($arrReg=="")
				$arrReg=$obj;
			else
				$arrReg.=",".$obj;
			$ct++;
		}
		
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrReg.']}';
		
			
	}
	
	function evaluarRequisitosRegistro()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$idSubcategoria=$_POST["idSubcategoria"];
		$organizacion=$_SESSION["codigoInstitucion"];
		$idConfiguracion=$_POST["idConfiguracion"];
		
		
		$cTmp='{"idConfiguracion":"","idCategoria":"","idSubcategoria":"","organizacion":""}';
		$objTmp=json_decode($cTmp);
		$objTmp->idCategoria=$idCategoria;
		$objTmp->idSubcategoria=$idSubcategoria;
		$objTmp->organizacion=$organizacion;
		$objTmp->idConfiguracion=$idConfiguracion;
		$cache=NULL;
		$consulta="SELECT id__465_gridFunciones,funcion,descripcion FROM _465_gridFunciones g,_465_tablaDinamica t WHERE g.idReferencia=t.id__465_tablaDinamica AND t.idReferencia=".$idConfiguracion;
		$res=$con->obtenerFilas($consulta);
		$registros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);		
			$o='{"idRequisito":"'.$fila[0].'","descripcion":"'.cv($fila[2]).'","comentariosAdicionales":"'.cv($oResp["comentarios"]).'","situacion":"'.$oResp["situacion"].'"}';
			$numReg++;
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			
				
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
	}
	
	function  obtenerPoblacionesBlancoProyecto2014()
	{
		global $con;	
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		
		$consulta="SELECT   idRegistroPoblacion, idPoblacionBlanco,idRangoEdad,beneficiariosDirectos,beneficiariosIndirectos ,
					CONCAT('[',t.txtclave,'] ',t.txtReferencia) AS lblPoblacionBlanco                                         
					FROM 112_poblacionBlancoProyectos2014 p,_261_tablaDinamica t 
					WHERE p.idFormulario=".$idFormulario." AND p.idReferencia=".$idReferencia." AND t.id__261_tablaDinamica=p.idPoblacionBlanco
					ORDER BY t.txtclave,t.txtReferencia,idRangoEdad";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}

	function  registrarPoblacionesBlancoProyecto2014()
	{
		global $con;	
		$consulta="SELECT id__411_tablaDinamica FROM _411_tablaDinamica WHERE activo=1 ORDER BY valorMinimo";
		$listRango=$con->obtenerLIstaValores($consulta);
		$arrRangos=explode(",",$listRango);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrPoblaciones=explode(",",$obj->arrPoblacion);
		if($obj->arrPoblacion!="")
		{
			foreach($arrPoblaciones as $p)
			{
				foreach($arrRangos as $r)
				{
					$query[$x]="INSERT INTO 112_poblacionBlancoProyectos2014(idPoblacionBlanco,idRangoEdad,beneficiariosDirectos,beneficiariosIndirectos,idFormulario,idReferencia)
								VALUES(".$p.",".$r.",0,0,".$obj->idFormulario.",".$obj->idReferencia.")";
					$x++;
				}
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function  removerPoblacionesBlancoProyecto2014()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="DELETE FROM 112_poblacionBlancoProyectos2014 WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idPoblacionBlanco IN (".$obj->arrPoblacion.")";
		eC($consulta);
	}
	
	function actualizarPoblacionesBlancoProyecto2014()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE 112_poblacionBlancoProyectos2014 SET ".$obj->campo."='".$obj->valor."' WHERE idFormulario=".$obj->idFormulario." AND 
					idReferencia=".$obj->idReferencia." AND idPoblacionBlanco=".$obj->idPoblacion." AND idRangoEdad=".$obj->rangoEdad;
		eC($consulta);
	}
	
	function registrarRecursoHumano2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$quincenas=$obj->periodoFinal-$obj->periodoInicial+1;
		$cantidad=$quincenas/2;
		if(isset($obj->cantidad))
			$cantidad=$obj->cantidad;
		
		$total=$obj->sueldoMensual*$cantidad;
		if(isset($obj->total))
			$total=$obj->total;
		
		
		if($obj->idRegistro=='-1')
		{
			
			$query[$x]="INSERT INTO 100_calculosGrid(idFormulario,idReferencia,calculo,costoUnitario,cantidad,total,idRubro,idConcepto,objComplementario)
						VALUES(".$obj->idFormulario.",".$obj->idReferencia.",'".cv($obj->descripcion)."',".$obj->sueldoMensual.",".($cantidad).",".
						$total.",1,".$obj->idConcepto.",'".cv($cadObj)."')";
			$x++;
		}
		else
		{
			$query[$x]="update 100_calculosGrid set calculo='".cv($obj->descripcion)."',costoUnitario=".$obj->sueldoMensual.",cantidad=".$cantidad.
						",total=".($total).",idConcepto=".$obj->idConcepto.",objComplementario='".cv($cadObj)."' where idGridVSCalculo=".
						$obj->idRegistro;
						
			$x++;
		}
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			echo "1|".$con->obtenerUltimoID();	
		}
		
	}
	
	function obtenerIndicadoresProyectos2014()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idConfiguracion=$con->obtenerValor($consulta);

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		
	/*	*/
		
		$consulta="SELECT idIndicador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listIndicadores=$con->obtenerListaValores($consulta);
		if($listIndicadores=="")
			$listIndicadores=-1;
		$consulta="SELECT t.idIndicador,nombreIndicador,nombreIndicador as numerador,'' as denominador,
				(select tipoIndicador from _431_tablaDinamica ti where ti.id__431_tablaDinamica=t.tipoIndicador), descripcion,t.tipoIndicador FROM 1026_catalogoIndicadores2014 t
				where t.idIndicador in (".$listIndicadores.") order by nombreIndicador";
		$res=$con->obtenerFilas($consulta);
		$cadIndicadores="";
		$total=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT numerador,denominador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idIndicador=".$fila[0];
			$fIndicador=$con->obtenerPrimeraFila($consulta);
			if($fIndicador)
			{
				if($fIndicador[0]=="")
					$fIndicador[0]=0;
				if($fIndicador[1]=="")
					$fIndicador[1]=0;
			}
			else
			{
				$fIndicador[0]=0;
				$fIndicador[1]=0;
			}
				
			
			$obj='{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"1","nombreUnidad":"'.cv($fila[2]).'","cantidad":"'.$fIndicador[0].
					'","descripcion":"'.cv($fila[5]).'","tipoIndicador":"'.$fila[6].'"}';
			if($fila[3]!="")
			{
				$obj.=',{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"2","nombreUnidad":"'.cv($fila[3]).'","cantidad":"'.$fIndicador[1].
						'","descripcion":"'.cv($fila[5]).'","tipoIndicador":"'.$fila[6].'"}';
				$total++;
			}
			
			if($cadIndicadores=="")
				$cadIndicadores=$obj;
			else
				$cadIndicadores.=",".$obj;
			$total++;
		}
		
		echo '{"numReg":"'.$total.'","registros":['.$cadIndicadores.']}';
		
	}
	
	function obtenerIndicadoresProyectosDisponibles2014()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idReferencia,idCategoria from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$idConfiguracion=$fRegistro[0];
		$idCategoria=$fRegistro[1];

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT idIndicador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listIndicadoresReg=$con->obtenerListaValores($consulta);
		if($listIndicadoresReg=="")
			$listIndicadoresReg=-1;
			
			
		$listIndicadoresCategoria="";
		$consulta="SELECT gi.indicador ,i.nombreIndicador,'1' as tipoIndicador,i.descripcion from _414_indicadoresCategoria gi,1026_catalogoIndicadores2014 i 
					where gi.idReferencia=".$fDatos[0]." and i.idIndicador=gi.indicador
					and gi.indicador not in (".$listIndicadoresReg.")";
		$res=$con->obtenerFilas($consulta);
		$nReg=0;
		
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","tipoIndicador":"'.$fila[2].'","descripcion":"'.$fila[3].'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$nReg++;
			
			if($listIndicadoresCategoria=="")
				$listIndicadoresCategoria=$fila[0];
			else
				$listIndicadoresCategoria.=",".$fila[0];
			
		}
		if($listIndicadoresCategoria=="")
			$listIndicadoresCategoria=-1;
		
		
		$consulta="SELECT i.idIndicador ,i.nombreIndicador,'3' as tipoIndicador,i.descripcion from 1026_catalogoIndicadores2014 i where idFormularioBase=".$idFormulario." and idReferenciaBase=".$idRegistro."
					AND i.idIndicador NOT IN (".$listIndicadoresReg.")";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","tipoIndicador":"'.$fila[2].'","descripcion":"'.$fila[3].'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$nReg++;
		}
		
		$consulta="SELECT i.idIndicador ,i.nombreIndicador,'2' as tipoIndicador,i.descripcion from 1026_catalogoIndicadores2014 i where  
				i.idIndicador not in (".$listIndicadoresReg.",".$listIndicadoresCategoria.") and idFormularioBase is null";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","tipoIndicador":"'.$fila[2].'","descripcion":"'.$fila[3].'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$nReg++;
			
			if($listIndicadoresCategoria=="")
				$listIndicadoresCategoria=$fila[0];
			else
				$listIndicadoresCategoria.=",".$fila[0];
			
		}
		
		
		echo '{"numReg":"'.$nReg.'","registros":['.$registros.']}';
		
	}
	
	function guardarIndicadoresProyecto2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		$x=0;
		$query[$x]="begin";
		$x++;	
		$arrIndicadores=explode(",",$obj->arrIndicadores);
		foreach($arrIndicadores as $i)	
		{
			$query[$x]="INSERT INTO 109_indicadoresProyectos(idIndicador,numerador,denominador,idFormulario,idReferencia)
						 VALUES(".$i.",0,0,".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;	
		}
		$query[$x]="commit";
		$x++;
		
		eB($query);
	}
	
	function removerIndicadoresProyecto2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		$x=0;
		$query[$x]="begin";
		$x++;	
		$query[$x]="DELETE FROM 109_indicadoresProyectos WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idIndicador IN (".$obj->arrIndicadores.")";
		$x++;
		$query[$x]="commit";
		$x++;
		
		eB($query);
	}
	
	function actualizarValorIndicadorProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$campo="numerador";
		if($obj->tipo==2)
			$campo="denominador";
		$consulta="UPDATE 109_indicadoresProyectos SET ".$campo."='".$obj->valor."' WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia.
					" AND idIndicador=".$obj->idIndicador;
		eC($consulta);
		
	}
	
	function registrarIndicador2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		$x=0;
		$query[$x]="begin";
		$x++;
		if($obj->idIndicador==-1)
		{
			$query[$x]="INSERT INTO 1026_catalogoIndicadores2014(nombreIndicador,tipoIndicador,idFormularioBase,idReferenciaBase,descripcion)
					VALUES ('".cv($obj->indicador)."',13,".$obj->idFormulario.",".$obj->idReferencia.",'".cv($obj->descripcion)."')";
			$x++;		
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$query[$x]="INSERT INTO 109_indicadoresProyectos(idIndicador,numerador,denominador,idFormulario,idReferencia)
						 VALUES(@idRegistro,0,0,".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;
		}
		else
		{
			$query[$x]="update 1026_catalogoIndicadores2014 set nombreIndicador='".cv($obj->indicador)."',descripcion='".cv($obj->descripcion)."' where idIndicador=".$obj->idIndicador;
			$x++;
		}
		
		
		
		$query[$x]="commit";
		$x++;

		eB($query);
		
		
			
	}
	
	function obtenerDocumentosRegistroOSC()
	{
		global $con;	
		$ciclo=$_POST["ciclo"];
		if($ciclo=="")
			$ciclo=date("Y");
		$codigoInstitucion=$_SESSION["codigoInstitucion"];
		if(isset($_POST["osc"]))
			$codigoInstitucion=$_POST["osc"];
		$consulta="SELECT id__367_tablaDinamica,tipoOrganizacion FROM _367_tablaDinamica WHERE codigoInstitucion='".$codigoInstitucion."'";
		
		
		if(isset($_POST["idReferencia"])&&($_POST["idReferencia"]!=-1))
		{
			$idReferencia=$_POST["idReferencia"];
			$consulta="SELECT id__367_tablaDinamica,tipoOrganizacion FROM _367_tablaDinamica WHERE id__367_tablaDinamica='".$idReferencia."'";
		}
		
		$fDatosOrganizacion=$con->obtenerPrimeraFila($consulta);
		$idRegistro=$fDatosOrganizacion[0];
		$tOrganizacion=$fDatosOrganizacion[1];
		$registros="";
		$numReg=0;
		if($idRegistro!="")
		{
			
			$consulta="SELECT id__408_tablaDinamica,tituloDocumento FROM _408_tablaDinamica where tiporequerido=1 ";
			if(($tOrganizacion==1)||($tOrganizacion==4))
				$consulta.=" and aplicaOSC=1";
			else
				$consulta.=" and aplicaIA=1";
			$consulta.=" ORDER BY tituloDocumento";
			$res=$con->obtenerFilas($consulta);
			
			while($fila=mysql_fetch_row($res))
			{
				
				$consulta="SELECT documentoAnexo,fechaRegistro FROM _407_documentosRequeridosOSC d,_407_tablaDinamica t WHERE
						d.idReferencia=t.id__407_tablaDinamica AND t.idReferencia=".$idRegistro." AND d.tituloDocumento=".$fila[0]." 
						and activo=1 order by id__407_documentosRequeridosOSC desc";
	
				$fDocumento=$con->obtenerPrimeraFila($consulta);
				if(($ciclo!="")&&(($fila[0]==2)||($fila[0]==7)||($fila[0]==8)))
				{
					$consulta="SELECT documentoAnexo,fechaRegistro FROM _407_documentosRequeridosOSC d,_407_tablaDinamica t WHERE
						d.idReferencia=t.id__407_tablaDinamica AND t.idReferencia=".$idRegistro." AND d.tituloDocumento=".$fila[0]." 
						and fechaRegistro>='".$ciclo."-01-01' and fechaRegistro<='".$ciclo."-12-31' order by id__407_documentosRequeridosOSC desc";
					$fDocumento=$con->obtenerPrimeraFila($consulta);
				}
				
/*				$consulta="SELECT evaluacion,comentariosAdicionales FROM 1028_situacionDocumentosOSC2014 WHERE 1=2 and organizacion='".$codigoInstitucion."' AND idDocumento=".$fila[0];

				$fEval=$con->obtenerPrimeraFila($consulta);
				
*/				
				$fEval[0]="";
				$fEval[1]="";
				$obj='{"idDocumento":"'.$fila[0].'","documento":"'.$fila[1].'","archivoDocumento":"'.$fDocumento[0].'","fechaActualizacion":"'.$fDocumento[1].'","comentarios":"'.cv($fEval[1]).'","evaluacion":"'.cv($fEval[0]).'"}';
				if($registros=="")
					$registros=$obj;
				else
					$registros.=",".$obj;
				$numReg++;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
	}
	
	
	function registrarDocumentoOSC()
	{
		global $con;
		$cadObj=$_POST["cadObj"]	;
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion='".$obj->codigoInstitucion."'";

		$idRegistro=$con->obtenerValor($consulta);	
		if($idRegistro!="")
		{
			$consulta="SELECT id__407_tablaDinamica FROM _407_tablaDinamica WHERE idReferencia=".$idRegistro;
			$idRegBase=$con->obtenerValor($consulta);
			if($idRegBase=="")
			{
				$query[$x]	="INSERT INTO _407_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion)
								VALUES(".$idRegistro.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",0,'".$obj->codigoInstitucion."','".$obj->codigoInstitucion."')";
				$x++;
				$query[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
			}
			else
			{
				$query[$x]="set @idRegistro:=".$idRegBase;
				$x++;	
			}
			$idArchivo=registrarDocumentoServidor($obj->idArchivo,$obj->nombreArchivo);
			
			$query[$x]="INSERT INTO _407_documentosRequeridosOSC(idReferencia,tituloDocumento,documentoAnexo,fechaRegistro)
						VALUES(@idRegistro,".$obj->idDocumento.",".$idArchivo.",'".date("Y-m-d")."')";
			$x++;
		
		
			$consulta="SELECT evaluacion FROM 1028_situacionDocumentosOSC2014 WHERE organizacion='".$obj->codigoInstitucion."' AND idDocumento=".$obj->idDocumento;
			$evaluacion=$con->obtenerValor($consulta);
			if($evaluacion==2)
			{
				$query[$x]="update 1028_situacionDocumentosOSC2014 set evaluacion=4 where organizacion='".$obj->codigoInstitucion."' AND idDocumento=".$obj->idDocumento;
				$x++;
			}
			
			
		}
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	function obtenerOSCMonitor()
	{
		global $con;	
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$nReg=0;
		
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		$arrRegistros="";
		$consulta="
					select * from (
					SELECT id__367_tablaDinamica,codigo AS folioOSC,organizacion,codigoInstitucion, 
					IF((SELECT autorizados2011+autorizados2012+autorizados2013 FROM 0_historialOSC WHERE codigoInstitucion=t.codigoInstitucion) IS NULL,0,
					(SELECT autorizados2011+autorizados2012+autorizados2013 FROM 0_historialOSC WHERE codigoInstitucion=t.codigoInstitucion))AS proyFinanciado,
					IF((SELECT NOautorizados2011+NOautorizados2012+NOautorizados2013 FROM 0_historialOSC WHERE codigoInstitucion=t.codigoInstitucion) IS NULL,0,
					(SELECT NOautorizados2011+NOautorizados2012+NOautorizados2013 FROM 0_historialOSC WHERE codigoInstitucion=t.codigoInstitucion))AS proyNoFinanciado,
					(SELECT COUNT(*) FROM 0_vistaMontoSolicitado2014 WHERE codigoInstitucion=t.codigoInstitucion AND idEstado=3) AS proyEnRegistro,
					(SELECT COUNT(*) FROM 0_vistaMontoSolicitado2014 WHERE codigoInstitucion=t.codigoInstitucion AND idEstado=2 AND montoSolicitado<=500000) AS proyParticipantesMenor500,
					(SELECT COUNT(*) FROM 0_vistaMontoSolicitado2014 WHERE codigoInstitucion=t.codigoInstitucion AND idEstado=2 AND montoSolicitado>500000) AS proyParticipantesMayor500,
					(
					SELECT 
					IF(
						(autorizados2011+NOautorizados2011)>0,'2011',
							IF((autorizados2012+NOautorizados2012)>0,'2012',
								IF((autorizados2013+NOautorizados2013)>0,'2013','2014')
							)
					) FROM 0_historialOSC h WHERE h.codigoInstitucion=t.codigoInstitucion
					) AS primeraParticipacion,
					(YEAR(CURDATE())-YEAR(fechaConstitucion))- (RIGHT(CURDATE(),5)<RIGHT(fechaConstitucion,5))AS antiguedad,
					fechaConstitucion
					FROM _367_tablaDinamica t
					WHERE codigoInstitucion IN 
					(SELECT DISTINCT codigoInstitucion FROM _448_tablaDinamica WHERE id__448_tablaDinamica>3) ORDER BY organizacion) as tmp where 1=1 and ".$cadCondWhere."
					order by ".$sort." ".$dir;

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarEvaluacionDocumentosOSC()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->registros as $r)
		{
			if($r->evaluacion=="")
				$r->evaluacion=3;
			$consulta="SELECT idSituacionDoc FROM 1028_situacionDocumentosOSC2014 WHERE organizacion='".$obj->organizacion."' AND idDocumento=".$r->idDocumento;
			$idSituacionDoc=$con->obtenerValor($consulta);
			if($idSituacionDoc=="")
			{
				$query[$x]="INSERT INTO 1028_situacionDocumentosOSC2014(organizacion,idDocumento,evaluacion,comentariosAdicionales) VALUES('".$obj->organizacion."',".$r->idDocumento.",".$r->evaluacion.",'".cv($r->comentarios)."')";
				$x++;
			}
			else
			{
				$query[$x]="update 1028_situacionDocumentosOSC2014 set evaluacion=".$r->evaluacion.",comentariosAdicionales='".cv($r->comentarios)."' where idSituacionDoc=".$idSituacionDoc;
				$x++;
			}
		}
		if($obj->marcaAutorizacion=="")
			$obj->marcaAutorizacion=3;
		$consulta="SELECT idSituacionOSC FROM 1029_situacionEvaluacionOSC2014 WHERE codigoInstitucion='".$obj->organizacion."'";
		$idSituacionOSC=$con->obtenerValor($consulta);
		if($idSituacionOSC=="")
		{
			$query[$x]="INSERT INTO 1029_situacionEvaluacionOSC2014(codigoInstitucion,marcaAutorizacion,comentariosAdicionales,idResponsableValidacion,fechaEvaluacion) 
						VALUES('".$obj->organizacion."',".$obj->marcaAutorizacion.",'".cv($obj->comentariosAdicionales)."',".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."')";
			$x++;
		}
		else
		{
			$query[$x]="update 1029_situacionEvaluacionOSC2014 set marcaAutorizacion=".$obj->marcaAutorizacion.",comentariosAdicionales='".cv($obj->comentariosAdicionales)."',
					idResponsableValidacion=".$_SESSION["idUsr"].",fechaEvaluacion='".date("Y-m-d H:i:s")."' where idSituacionOSC=".$idSituacionOSC;
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			if($obj->marcaAutorizacion!=6)
				enviarCorreosDocumentosOSC($obj->organizacion);
			echo "1|";	
		}
		
		
	}
	
	function guardarEvaluacionPresupuestal2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		$query="select idEstado from _".$obj->idFormulario."_tablaDinamica where id__".$obj->idFormulario."_tablaDinamica=".$obj->idProyecto;
		$idEstado=$con->obtenerValor($query);
		
		
		$consulta[$x]="begin";
		$x++;
		$query="select * from 100_dictamenPresupuestalProyectos where idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;
		$fProyectos=$con->obtenerPrimeraFila($query);
		if($fProyectos)
		{
			$consulta[$x]="update 100_dictamenPresupuestalProyectos set marcarPosibleDescalificacion=".$obj->marcaDescalificacion.",motivoDescalificacion='".cv($obj->motivoDescalificacion)."', comentarios='".cv($obj->comentarios)."',identificaOSC=".$obj->identificaOSC.",nombreOSC='".cv($obj->nombreOSC)."' where 
						idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;

			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 100_dictamenPresupuestalProyectos(idFormulario,idRegistro,comentarios,fechaEvaluacion,responsableEvaluacion,identificaOSC,nombreOSC,marcarPosibleDescalificacion,motivoDescalificacion)
						VALUES(".$obj->idFormulario.",".$obj->idProyecto.",'".cv($obj->comentarios)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->identificaOSC.",'".cv($obj->nombreOSC)."',".$obj->marcaDescalificacion.",'".cv($obj->motivoDescalificacion)."')";
			$x++;
		}
		
		
		foreach($obj->arrConceptos as $r)
		{
			$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=".$r->montoAutorizado.",comentarios='".cv($r->comentarios)."' WHERE idGridVSCalculo=".$r->idConcepto;
			$x++;
			$consulta[$x]="UPDATE 100_montosAutorizadosConceptos2014 SET total=".$r->montoAutorizado.",costoUnitario='".($r->costoUnitarioAutorizado)."',cantidad=".$r->cantidadAutorizada.",comentarios='".cv($r->comentarios).
						"',situacion=".$r->situacion." WHERE idConcepto=".$r->idConcepto;
			$x++;
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}	
	}
	
	function marcarProyectoNORequiereEvaluacionComite2014()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$consulta="INSERT INTO 1031_situacionEvaluacionInconsistencias2014(idResponsable,comentarios,situacion,idProyecto) VALUES(".$_SESSION["idUsr"].",'".cv($motivo)."',1,".$idProyecto.")";
		eC($consulta);
			
	}
	
	
	function removerMarcaProyectoNORequiereEvaluacionComite2014()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		
		$consulta="delete from 1031_situacionEvaluacionInconsistencias2014 where idProyecto=".$idProyecto."";
		eC($consulta);
			
	}
	
	function cerrarEvaluacion2014()
	{
		global $con;
		$tipo=$_POST["tipo"];
		
		$consulta="INSERT INTO 1032_cierreEvaluaciones2014(tipoCierre) VALUES(".$tipo.")";
		eC($consulta);
			
	}
	
	function prepararEvaluacionComite()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idProyecto=$_POST["idProyecto"];	
		$consulta="select count(*) from 1011_asignacionRevisoresProyectos where idProyecto=".$idProyecto." and esEvaluacionComite=1";
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$consulta="INSERT INTO 1011_asignacionRevisoresProyectos(idUsuario,idProyecto,tipoRevisor,idFormulario,situacion,fechaAsignacion,esEvaluacionComite)
						VALUES(".$idUsuario.",".$idProyecto.",1,448,1,'".date("Y-m-d H:i:s")."',1)";
			eC($consulta);					
		}
		else
			echo "1|";
	}
	
	function registrarDictamenProyectosContinuidad()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$dictamen=$_POST["dictamen"];
		$consulta="INSERT INTO 1034_situacionEvaluacionContinuidad(idProyecto,recomiendaContinuidad,comentarios)VALUES(".$idProyecto.",".$dictamen.",'".cv($motivo)."')";
		eC($consulta);
			
	}
	
	function registrarDictamenProyectosIdentificacionOSC()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$dictamen=$_POST["dictamen"];
		$consulta="INSERT INTO 1035_situacionEvaluacionIdentificacionOSC(idProyecto,ignorarReporteOSC,comentarios)VALUES(".$idProyecto.",".$dictamen.",'".cv($motivo)."')";
		eC($consulta);
			
	}
	
	function registrarDictamenProyectosInnovacion()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$dictamen=$_POST["dictamen"];
		$consulta="INSERT INTO 1034_situacionEvaluacionInnovacion(idProyecto,recomiendaContinuidad,comentarios)VALUES(".$idProyecto.",".$dictamen.",'".cv($motivo)."')";
		eC($consulta);
			
	}
	
	function registrarDescalificacionProyecto()
	{
		global $con;	
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE _448_tablaDinamica SET marcaAutorizado=0,descalificado=1 , motivoDescalificacion='".cv($motivo)."' WHERE id__448_tablaDinamica=".$idProyecto;
		$x++;
		$consulta[$x]="UPDATE 100_dictamenFinalOSCPresupuesto2014 SET dictamen=2,fechaDictamen='".date("Y-m-d H:i:s")."',idResponsableDictamen=".$_SESSION["idUsr"].
					",comentariosFinales='".cv($motivo)."' WHERE idProyecto=".$idProyecto;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerConceptosEvaluacionPresupuestalOSC()
	{
		global $con;
		$idProyecto=$_POST["iP"];
		$situacion=$_POST["situacion"];
		
		
		
		$arrRegistros="";
		$numReg=0;
		switch($situacion)
		{
			case 1:
				$consulta="SELECT idGridVSCalculo,calculo,m.costoUnitario,m.cantidad,m.total,idRubro,(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE 
							id__385_gridCategoriasConcepto=c.idConcepto) as concepto,m.comentarios,c.detalleConcepto,m.situacion,c.costoUnitario,c.cantidad,c.total  
							FROM 100_calculosGrid c, 100_montosAutorizadosConceptos2014 m 	WHERE idFormulario=448 AND idReferencia=".$idProyecto."
							and m.idConcepto=c.idGridVSCalculo and m.situacion in(4,3)";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$considerar=true;
					if($fila[9]==3)
					{
						if(($fila[2]!=$fila[10])||($fila[3]!=$fila[11])||($fila[4]!=$fila[12]))
							$considerar=false;
						
					}
					if($considerar)
					{
						$costoUnitario=$fila[2];
						$cantidad=$fila[3];
						$total=$fila[4];
						$idRubro=$fila[5];
						$conceptoCancelado=0;
						$justificacion="";
						$comentariosOSC="";
						$dictamenFinal="";
						$comentariosFinales="";
						$consulta="SELECT * FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idConcepto=".$fila[0];
						$fAjuste=$con->obtenerPrimeraFila($consulta);
						
						if($fAjuste)
						{
							if($fAjuste[2]!="")	
								$idRubro=$fAjuste[2];
						
							if($fAjuste[3]!="")	
								$costoUnitario=$fAjuste[3];
								
							if($fAjuste[4]!="")	
								$cantidad=$fAjuste[4];
								
							if($fAjuste[5]!="")	
								$total=$fAjuste[5];
							
							if($fAjuste[6]!="")	
								$conceptoCancelado=$fAjuste[6];
								
							if($fAjuste[7]!="")	
								$comentariosOSC=$fAjuste[7];
								
							if($fAjuste[8]!="")	
								$justificacion=$fAjuste[8];
								
							if($fAjuste[9]!="")	
								$dictamenFinal=$fAjuste[9];	
								
							if($dictamenFinal==2)	
								$total=0;
								
							if($fAjuste[10]!="")	
								$comentariosFinales=$fAjuste[10];	
								
								
							/*$consulta="SELECT comentariosGeneralesOSC FROM 100_dictamenFinalOSCPresupuesto2014 WHERE idProyecto=".$idProyecto;
							$comentariosOSC=$con->obtenerValor($consulta);*/
								
									
						}
						
						$obj='{"dictamenFinal":"'.$dictamenFinal.'","comentariosFinales":"'.cv($comentariosFinales).'","detalleConcepto":"'.cv($fila[8]).'","idGridVSCalculo":"'.$fila[0].'","concepto":"'.cv($fila[6]).'","calculo":"'.cv($fila[1]).'","costoUnitario":"'.$costoUnitario.
								'","cantidad":"'.$cantidad.'","total":"'.$total.'","idRubro":"'.$idRubro.'","comentariosAdicionales":"'.cv($fila[7]).'","situacion":"'.$fila[9].
								'","comentariosOSC":"'.cv($comentariosOSC).'","idRubroOriginal":"'.$fila[5].'","costoUnitarioOriginal":"'.$fila[2].'","cantidadOriginal":"'.$fila[3].'","totalOriginal":"'.$fila[4].
								'","conceptoCancelado":"'.$conceptoCancelado.'","justificacion":"'.cv($justificacion).'"}';	
						if($arrRegistros=="")
							$arrRegistros=$obj;
						else
							$arrRegistros.=",".$obj;
						$numReg++;
					}
				}
			
			
			
			break;
			case 2:
				$consulta="SELECT idGridVSCalculo,calculo,m.costoUnitario,m.cantidad,m.total,idRubro,(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE 
							id__385_gridCategoriasConcepto=c.idConcepto) as concepto,m.comentarios,c.detalleConcepto,m.situacion  FROM 100_calculosGrid c, 100_montosAutorizadosConceptos2014 m 	WHERE idFormulario=448 AND idReferencia=".$idProyecto."
							and m.idConcepto=c.idGridVSCalculo and m.situacion=1";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$obj='{"dictamenFinal":"","comentariosFinales":"","detalleConcepto":"'.cv($fila[8]).'","idGridVSCalculo":"'.$fila[0].'","concepto":"'.cv($fila[6]).'","calculo":"'.cv($fila[1]).'","costoUnitario":"'.$fila[2].
							'","cantidad":"'.$fila[3].'","total":"'.$fila[4].'","idRubro":"'.$fila[5].'","comentariosAdicionales":"'.cv($fila[7]).'","situacion":"'.$fila[9].	
					'","comentariosOSC":"'.cv($comentariosOSC).'","idRubroOriginal":"'.$fila[5].'","costoUnitarioOriginal":"'.$fila[2].'","cantidadOriginal":"'.$fila[3].'","totalOriginal":"'.$fila[4].
								'","conceptoCancelado":"'.$conceptoCancelado.'","justificacion":"'.cv($justificacion).'"}';	
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					$numReg++;
				}
			
			
			
			
			break;
			case 3:
				$consulta="SELECT idGridVSCalculo,calculo,m.costoUnitario,m.cantidad,m.total,idRubro,(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE 
							id__385_gridCategoriasConcepto=c.idConcepto) as concepto,m.comentarios,c.detalleConcepto,m.situacion,c.costoUnitario,c.cantidad,c.total  
							FROM 100_calculosGrid c, 100_montosAutorizadosConceptos2014 m 	WHERE idFormulario=448 AND idReferencia=".$idProyecto."
							and m.idConcepto=c.idGridVSCalculo and m.situacion in(3)";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$considerar=true;
					
					if(($fila[2]==$fila[10])&&($fila[3]==$fila[11])&&($fila[4]==$fila[12]))
						$considerar=false;
						
					
					$costoUnitario=$fila[2];
					$cantidad=$fila[3];
					$total=$fila[4];
					$idRubro=$fila[5];
					$conceptoCancelado=0;
					$justificacion="";
					$comentariosOSC="";
					
					$consulta="SELECT * FROM 100_montosAutorizadosConceptos2014 WHERE idConcepto=".$fila[0];
					$fAjuste=$con->obtenerPrimeraFila($consulta);
					
					if($fAjuste)
					{
						
					
						if($fAjuste[2]!="")	
							$costoUnitario=$fAjuste[2];
							
						if($fAjuste[3]!="")	
							$cantidad=$fAjuste[3];
							
						if($fAjuste[4]!="")	
							$total=$fAjuste[4];
						
						
							
								
					}
					
					
					
					if($considerar)
					{
						$obj='{"dictamenFinal":"","comentariosFinales":"","detalleConcepto":"'.cv($fila[8]).'","idGridVSCalculo":"'.$fila[0].'","concepto":"'.cv($fila[6]).'","calculo":"'.cv($fila[1]).'","costoUnitario":"'.$costoUnitario.
								'","cantidad":"'.$cantidad.'","total":"'.$total.'","idRubro":"'.$fila[5].'","comentariosAdicionales":"'.cv($fila[7]).'","situacion":"'.$fila[9].	
								'","comentariosOSC":"'.cv($comentariosOSC).'","idRubroOriginal":"'.$fila[5].'","costoUnitarioOriginal":"'.$fila[2].'","cantidadOriginal":"'.$fila[3].'","totalOriginal":"'.$fila[4].
								'","conceptoCancelado":"'.$conceptoCancelado.'","justificacion":"'.cv($justificacion).'"}';	
						if($arrRegistros=="")
							$arrRegistros=$obj;
						else
							$arrRegistros.=",".$obj;
						$numReg++;
					}
				}
			break;
			case 4:
				$consulta="SELECT idGridVSCalculo,calculo,m.costoUnitario,m.cantidad,m.total,idRubro,(SELECT categoriaConcepto FROM _385_gridCategoriasConcepto WHERE 
							id__385_gridCategoriasConcepto=c.idConcepto) as concepto,m.comentarios,c.detalleConcepto,m.situacion  FROM 100_calculosGrid c, 100_montosAutorizadosConceptos2014 m 	
							WHERE idFormulario=448 AND idReferencia=".$idProyecto." and m.idConcepto=c.idGridVSCalculo and m.situacion=2";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$costoUnitario=$fila[2];
					$cantidad=$fila[3];
					$total=$fila[4];
					$idRubro=$fila[5];
					$conceptoCancelado=0;
					$justificacion="";
					$comentariosOSC="";
					
					$obj='{"dictamenFinal":"","comentariosFinales":"","detalleConcepto":"'.cv($fila[8]).'","idGridVSCalculo":"'.$fila[0].'","concepto":"'.cv($fila[6]).'","calculo":"'.cv($fila[1]).'","costoUnitario":"'.$fila[2].
							'","cantidad":"'.$fila[3].'","total":"'.$fila[4].'","idRubro":"'.$fila[5].'","comentariosAdicionales":"'.cv($fila[7]).'","situacion":"'.$fila[9].
							'","comentariosOSC":"'.cv($comentariosOSC).'","idRubroOriginal":"'.$fila[5].'","costoUnitarioOriginal":"'.$fila[2].'","cantidadOriginal":"'.$fila[3].'","totalOriginal":"'.$fila[4].
								'","conceptoCancelado":"'.$conceptoCancelado.'","justificacion":"'.cv($justificacion).'"}';		
					if($arrRegistros=="")
						$arrRegistros=$obj;
					else
						$arrRegistros.=",".$obj;
					$numReg++;
				}
			
			break;	
		}
		
		

		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
			
	}
	
	function registrarModificacionConcepto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		$consulta="SELECT idAjuste FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idConcepto=".$obj->idConcepto;
		$idAjuste=$con->obtenerValor($consulta);
		if($idAjuste=="")
		{
			$consulta="select idReferencia from 100_calculosGrid where idGridVSCalculo=".$obj->idConcepto;
			$idReferencia=$con->obtenerValor($consulta);
			$consulta="INSERT INTO 100_ajustesOSCConceptosPresupuesto2014(idConcepto,idRubro,costoUnitario,cantidad,total,conceptoEliminado,comentariosAdicionales,idFormulario,idReferencia)
					VALUES(".$obj->idConcepto.",".$obj->idRubro.",".$obj->costoUnitario.",".$obj->cantidad.",".$obj->total.",".$obj->eliminarConcepto.",'".cv($obj->comentariosOSC)."',448,".$idReferencia.")";
		}
		else
		{
			$consulta="UPDATE 100_ajustesOSCConceptosPresupuesto2014 SET idRubro=".$obj->idRubro.",costoUnitario=".$obj->costoUnitario.",cantidad=".$obj->cantidad.",total=".$obj->total.
					",conceptoEliminado=".$obj->eliminarConcepto.",comentariosAdicionales='".cv($obj->comentariosOSC)."' WHERE idAjuste=".$idAjuste;
		}
		eC($consulta);
	}
	
	function registrarJustificacionConcepto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		$consulta="SELECT idAjuste FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idConcepto=".$obj->idConcepto;
		$idAjuste=$con->obtenerValor($consulta);
		if($idAjuste=="")
		{
			$consulta="select idReferencia from 100_calculosGrid where idGridVSCalculo=".$obj->idConcepto;
			$idReferencia=$con->obtenerValor($consulta);
			$consulta="INSERT INTO 100_ajustesOSCConceptosPresupuesto2014(idConcepto,idRubro,justificacion,idFormulario,idReferencia)
					VALUES(".$obj->idConcepto.",".$obj->idRubro.",'".cv($obj->justificacion)."',448,".$idReferencia.")";
		}
		else
		{
			$consulta="UPDATE 100_ajustesOSCConceptosPresupuesto2014 SET idRubro=".$obj->idRubro.",justificacion='".cv($obj->justificacion)."' WHERE idAjuste=".$idAjuste;
		}

		eC($consulta);
	}
	
	function notificarCambiosCENSIDAOSC()
	{
		global $con;	
		$idProyecto=$_POST["idProyecto"];
		$comentarios=$_POST["comentarios"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT idGridVSCalculo FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$idProyecto;
		$listConceptos=$con->obtenerListaValores($query);
		if($listConceptos=="")
			$listConceptos=-1;
		$query="DELETE FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idConcepto IN (".$listConceptos.") AND  modificadoOSC=0";
		if($con->ejecutarConsulta($query))
		{
			$consulta[$x]="INSERT INTO 100_dictamenFinalOSCPresupuesto2014(idProyecto,fechaRegistro,idResponsableRegistro,comentariosGeneralesOSC) 
						VALUES(".$idProyecto.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($comentarios)."')";
			$x++;
			
			
			/*$query="SELECT * FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$idProyecto;
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
			{
				$query="SELECT * FROM 100_montosAutorizadosConceptos2014 WHERE idConcepto=".$fila[0];
				$fMontoAutorizado=$con->obtenerPrimeraFila($query);
				if($fMontoAutorizado)
				{
					$query="SELECT * FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idConcepto=".$fila[0];
					$fAjuste=$con->obtenerPrimeraFila($query);
					if(!$fAjuste)
					{
						$conceptoEliminado=0;
						
						if($fMontoAutorizado[6]==2)
							$conceptoEliminado=1;
						
						$consulta[$x]="INSERT INTO 100_ajustesOSCConceptosPresupuesto2014(idConcepto,idRubro,costoUnitario,cantidad,total,conceptoEliminado,modificadoOSC,idFormulario,idReferencia)
									VALUES(".$fMontoAutorizado[1].",".$fila[7].",".$fMontoAutorizado[2].",".$fMontoAutorizado[3].",".$fMontoAutorizado[4].",".$conceptoEliminado.",0,".$fila[1].",".$fila[2].")";
						$x++;
					}
					else
					{
						
						if($fMontoAutorizado[6]==4)
						{
							$consulta[$x]="UPDATE 100_ajustesOSCConceptosPresupuesto2014 SET costoUnitario=".$fMontoAutorizado[2].",cantidad=".$fMontoAutorizado[3].",total=".$fMontoAutorizado[4]." WHERE idAjuste=".$fAjuste[0];
							$x++;
						}
						
					}
				}
				else
				{
					$consulta[$x]="INSERT INTO 100_ajustesOSCConceptosPresupuesto2014(idConcepto,idRubro,costoUnitario,cantidad,total,conceptoEliminado,modificadoOSC,idFormulario,idReferencia)
									VALUES(".$fila[0].",".$fila[7].",".$fila[4].",".$fila[5].",".$fila[6].",0,0,".$fila[1].",".$fila[2].")";
					$x++;
				}
			}*/
		
			
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarEvaluacionPresupuestalFinal2014()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		$query="select idEstado from _".$obj->idFormulario."_tablaDinamica where id__".$obj->idFormulario."_tablaDinamica=".$obj->idProyecto;
		$idEstado=$con->obtenerValor($query);
		
		
		$consulta[$x]="begin";
		$x++;
		$query="select * from 100_dictamenPresupuestalProyectos2014Rev3 where idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;
		$fProyectos=$con->obtenerPrimeraFila($query);
		if($fProyectos)
		{
			$consulta[$x]="update 100_dictamenPresupuestalProyectos2014Rev3 set  comentarios='".cv($obj->comentarios)."' where 
						idFormulario=".$obj->idFormulario." and idRegistro=".$obj->idProyecto;

			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 100_dictamenPresupuestalProyectos2014Rev3(idFormulario,idRegistro,comentarios,fechaEvaluacion,responsableEvaluacion)
						VALUES(".$obj->idFormulario.",".$obj->idProyecto.",'".cv($obj->comentarios)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].")";
			$x++;
		}
		
		
		foreach($obj->arrConceptos as $r)
		{
			$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=".$r->montoAutorizado.",comentarios='".cv($r->comentarios)."' WHERE idGridVSCalculo=".$r->idConcepto;
			$x++;
			$consulta[$x]="UPDATE 100_montosAutorizadosConceptos2014 SET total=".$r->montoAutorizado.",costoUnitario='".($r->costoUnitarioAutorizado)."',cantidad=".$r->cantidadAutorizada.",comentarios='".cv($r->comentarios).
						"',situacion=".$r->situacion." WHERE idConcepto=".$r->idConcepto;
			$x++;
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}	
	}
	
	function registrarAutorizacionProyecto()
	{
		global $con;	
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE _448_tablaDinamica SET descalificado=0,marcaAutorizado=1 , comentariosMarca='".cv($motivo)."' WHERE id__448_tablaDinamica=".$idProyecto;
		$x++;
		$consulta[$x]="UPDATE 100_dictamenFinalOSCPresupuesto2014 SET dictamen=1,fechaDictamen='".date("Y-m-d H:i:s")."',idResposableDictamen=".$_SESSION["idUsr"].
					",comentariosFinales='".cv($motivo)."' WHERE idProyecto=".$idProyecto;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function realizarDictamenAjustePresupuestal()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$comentarios=$_POST["comentarios"];
		$idProyecto=$_POST["idProyecto"];
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrConceptos as $c)
		{
			$query[$x]="UPDATE 100_ajustesOSCConceptosPresupuesto2014 SET dictamenFinal=".$c->dictamen.",comentariosFinales='".cv($c->comentarios)."',total=".$c->total.
					" WHERE idConcepto=".$c->idConcepto;
			$x++;
		}
		
		$query[$x]="UPDATE _448_tablaDinamica SET descalificado=0,marcaAutorizado=1 , comentariosMarca='".cv($comentarios)."' WHERE id__448_tablaDinamica=".$idProyecto;
		$x++;
		$query[$x]="UPDATE 100_dictamenFinalOSCPresupuesto2014 SET dictamen=1,fechaDictamen='".date("Y-m-d H:i:s")."',idResponsableDictamen=".$_SESSION["idUsr"].
					",comentariosFinales='".cv($comentarios)."' WHERE idProyecto=".$idProyecto;
		$x++;
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerResultadosFinalesPresupuesto()
	{
		global $con;	
		
		$montoLimite=122000000;
		$montoAcumulado=0;
		$montoTotalAutorizado=0;
		$totalDescalificados=0;
		$totalFinanciados=0;
		$totalNoFinanciados=0;
		$numReg=0;
		$arrRegistros="";
		$consulta="";
		$consulta="SELECT id__448_tablaDinamica,((eval2+eval3+eval4)/3) AS promedio  FROM 2014_resultadosProyectos ORDER BY promedio DESC";
		$res=$con->obtenerFilas($consulta);
		while($filaReg=mysql_fetch_row($res))
		{
			if($filaReg[1]<70)
				break;
				
			$pintado=0;	
				
			$consulta="SELECT * FROM _448_tablaDinamica WHERE id__448_tablaDinamica=".$filaReg[0];
			$fila=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[11];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			
			$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[12];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nSubCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			$descalificado="No";
			if($fila[18]=="1")
				$descalificado="Sí";
				
			
			$promedio=$filaReg[1];	
			
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]."";
			$montoSolicitado=$con->obtenerValor($consulta);
			
			
			
			
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=1";
			$monto1=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=6";
			$monto6=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=7";
			$monto7=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=4";
			$monto4=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]."";
			$montoAutorizado=$con->obtenerValor($consulta);
			
			$diferencia=$montoSolicitado-$montoAutorizado;
			$porcentaje=($diferencia/$montoAutorizado	)*100;
			
			$consulta="SELECT idDictamen,fechaEvaluacion,comentarios FROM 100_dictamenPresupuestalProyectos2014Rev3 WHERE idFormulario=448 and idRegistro =".$fila[0];
			$fDictamen=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT comentarios FROM 100_dictamenPresupuestalProyectos WHERE idFormulario=448 and idRegistro =".$fila[0];
			
			$comentarios=$con->obtenerValor($consulta);

			$consulta="SELECT IF(
									(autorizados2011+NOautorizados2011)>0,'Sí',
									IF((autorizados2012+NOautorizados2012)>0,'Sí',
										IF((autorizados2013+NOautorizados2013)>0,'Sí','No'
									)
								)
								) FROM 0_historialOSC h WHERE h.codigoInstitucion='".$fila[8]."'"	;		
			$pParticipacion=$con->obtenerValor($consulta);
			
			$consulta="SELECT DATE_FORMAT(fechaConstitucion,'%d/%m/%Y') FROM _367_tablaDinamica WHERE codigoInstitucion='".$fila[8]."'";			
			$fechaCreacionOSC=$con->obtenerValor($consulta);
								
			$consulta="select marcarPosibleDescalificacion,motivoDescalificacion,responsableEvaluacion from 100_dictamenPresupuestalProyectos WHERE idFormulario=448 and idRegistro =".$fila[0];
			$fDitamenAnt=$con->obtenerPrimeraFila($consulta);					
			if($fDitamenAnt[0]=="1")		
				$fDitamenAnt[0]="Sí";
			else
				$fDitamenAnt[0]="No";
			
			$evaluador="No evaluado";
			if($fDitamenAnt[2]!="")
			{
				$consulta="select Nombre from 800_usuarios where idUsuario=".$fDitamenAnt[2];
				$evaluador=$con->obtenerValor($consulta);	
			}
			
			
			switch($fila[18])
			{
				case '1':
					$pintado=1;
					$totalDescalificados++;
				break;
				case '2':
					$pintado=2;
					$totalDescalificados++;
				break;
				case '3':
					$pintado=3;
					$totalDescalificados++;
				break;	
				
					
				default:
				
					if(($montoAcumulado+$montoSolicitado)<=$montoLimite)
					{
						$montoTotalAutorizado+=$montoAutorizado;
						$montoAcumulado+=$montoSolicitado;
						$pintado=0;
						$totalFinanciados++;
					}
					else
					{
						$totalNoFinanciados++;
						$pintado=4;
					}
				break;
			}
			
			$obj='{"codigo":"'.$fila[9].'","categoria":"'.$nCategoria.'","promedio":"'.$promedio.'","montoSolicitado":"'.$montoSolicitado.
				'","montoAutorizado":"'.$montoAutorizado.'","diferencia":"'.$diferencia.'","porcentajeDisminucion":"'.$porcentaje.'","montoSolicitado_1":"'.$monto1.'",
				"montoSolicitado_6":"'.$monto6.'","montoSolicitado_7":"'.$monto7.'","montoSolicitado_4":"'.$monto4.'","noSubcategoria":"'.$nSubCategoria.
				'","idRegistroSituacion":"'.$fDictamen[0].'","comentariosFinales":"'.$fDictamen[2].'","comentarios":"'.cv($comentarios).'","id__448_tablaDinamica":"'.$fila[0].'",
				"primeraParticipacion":"'.$pParticipacion.'","fechaCreacionOSC":"'.$fechaCreacionOSC.'","marcarPosibleDescalificacion":"'.$fDitamenAnt[0].
				'","motivoDescalificacion":"'.cv($fDitamenAnt[1]).'","evaluador":"'.cv($evaluador).'","descalificado":"'.$descalificado
				.'","motivoDescalificacionFinal":"'.$fila[19].'","fechaEvaluacion":"'.$fDictamen[1].'","pintado":"'.$pintado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		
		
		echo '{"montoAutorizado":"'.$montoTotalAutorizado.'","montoAcumulado":"'.$montoAcumulado.'","totalDescalificados":"'.$totalDescalificados.'","totalFinanciados":"'.$totalFinanciados.
			'","totalNOFinanciados":"'.$totalNoFinanciados.'","numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function obtenerProyectosConvenios()
	{
		global $con;	
		$osc=$_POST["osc"];
		$montoLimite=122000000;
		$montoAcumulado=0;
		$montoTotalAutorizado=0;
		$totalDescalificados=0;
		$totalFinanciados=0;
		$totalNoFinanciados=0;
		$numReg=0;
		$arrRegistros="";
		$consulta="";
		
		$comp="";
		if($osc!=0)
			$comp=" and t.codigoInstitucion='".$osc."'";
		$consulta="SELECT t.id__448_tablaDinamica,((eval2+eval3+eval4)/3) AS promedio,o.unidad  
				FROM 2014_resultadosProyectos r,_448_tablaDinamica t,817_organigrama o where t.id__448_tablaDinamica=r.id__448_tablaDinamica and t.notificado=1 and o.codigoUnidad=t.codigoInstitucion ".$comp." ORDER BY o.unidad,promedio DESC";
		$res=$con->obtenerFilas($consulta);
		while($filaReg=mysql_fetch_row($res))
		{
			
				
			$pintado=0;	
				
			$consulta="SELECT * FROM _448_tablaDinamica WHERE id__448_tablaDinamica=".$filaReg[0];
			$fila=$con->obtenerPrimeraFila($consulta);
			
			
			
			$nomOSC=$filaReg[2];
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[11];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			
			$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[12];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nSubCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			$descalificado="No";
			if($fila[18]=="1")
				$descalificado="Sí";
				
			
			$promedio=$filaReg[1];	
			
			$consulta="	SELECT SUM(total) FROM 1100_originalCalculoGrid WHERE idFormulario=448 AND idReferencia=".$fila[0]."";
			$montoSolicitado=$con->obtenerValor($consulta);
			
			
			
			
			$consulta="	SELECT SUM(total) FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=1";
			$monto1=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=6";
			$monto6=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=7";
			$monto7=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idFormulario=448 AND idReferencia=".$fila[0]." and idRubro=4";
			$monto4=$con->obtenerValor($consulta);
			$consulta="	SELECT SUM(total) FROM 100_ajustesOSCConceptosPresupuesto2014 WHERE idFormulario=448 AND idReferencia=".$fila[0]."";
			$montoAutorizado=$con->obtenerValor($consulta);
			
			$diferencia=$montoSolicitado-$montoAutorizado;
			$porcentaje=($diferencia/$montoAutorizado	)*100;
			
			$consulta="SELECT idDictamen,fechaEvaluacion,comentarios FROM 100_dictamenPresupuestalProyectos2014Rev3 WHERE idFormulario=448 and idRegistro =".$fila[0];
			$fDictamen=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT comentarios FROM 100_dictamenPresupuestalProyectos WHERE idFormulario=448 and idRegistro =".$fila[0];
			
			$comentarios=$con->obtenerValor($consulta);

			$consulta="SELECT IF(
									(autorizados2011+NOautorizados2011)>0,'Sí',
									IF((autorizados2012+NOautorizados2012)>0,'Sí',
										IF((autorizados2013+NOautorizados2013)>0,'Sí','No'
									)
								)
								) FROM 0_historialOSC h WHERE h.codigoInstitucion='".$fila[8]."'"	;		
			$pParticipacion=$con->obtenerValor($consulta);
			
			$consulta="SELECT DATE_FORMAT(fechaConstitucion,'%d/%m/%Y') FROM _367_tablaDinamica WHERE codigoInstitucion='".$fila[8]."'";			
			$fechaCreacionOSC=$con->obtenerValor($consulta);
								
			$consulta="select marcarPosibleDescalificacion,motivoDescalificacion,responsableEvaluacion from 100_dictamenPresupuestalProyectos WHERE idFormulario=448 and idRegistro =".$fila[0];
			$fDitamenAnt=$con->obtenerPrimeraFila($consulta);					
			if($fDitamenAnt[0]=="1")		
				$fDitamenAnt[0]="Sí";
			else
				$fDitamenAnt[0]="No";
			
			$evaluador="No evaluado";
			if($fDitamenAnt[2]!="")
			{
				$consulta="select Nombre from 800_usuarios where idUsuario=".$fDitamenAnt[2];
				$evaluador=$con->obtenerValor($consulta);	
			}
			
			
			switch($fila[18])
			{
				case '1':
					$pintado=1;
					$totalDescalificados++;
				break;
				case '2':
					$pintado=2;
					$totalDescalificados++;
				break;
				case '3':
					$pintado=3;
					$totalDescalificados++;
				break;	
				
					
				default:
				
					if(($montoAcumulado+$montoSolicitado)<=$montoLimite)
					{
						$montoTotalAutorizado+=$montoAutorizado;
						$montoAcumulado+=$montoSolicitado;
						$pintado=0;
						$totalFinanciados++;
					}
					else
					{
						$totalNoFinanciados++;
						$pintado=4;
					}
				break;
			}
			
			$comentariosVoBo="";
			$consulta="SELECT * FROM 100_dictamenFinalOSCPresupuesto2014 WHERE idProyecto=".$fila[0];
			$fDictamenVoBo=$con->obtenerPrimeraFila($consulta);
			$cambiosNotificados=0;
			if($fDictamenVoBo)
			{
				$cambiosNotificados=1;
				$comentariosVoBo=$fDictamenVoBo[3];
			}
			
			$consulta="SELECT COUNT(*) FROM 100_montosAutorizadosConceptos2014 m,100_calculosGrid c WHERE 
						 c.idGridVSCalculo=m.idConcepto AND c.idFormulario=448 AND idReferencia=".$fila[0]." AND m.situacion=4";
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)			
				$justificaConcepto="No";
			else
				$justificaConcepto="Sí";
				
			$consulta="SELECT fechaSuscripcion,convenio,id__472_tablaDinamica FROM _472_tablaDinamica WHERE idReferencia=".$fila[0];
			$fSuscripcion=$con->obtenerPrimeraFila($consulta);			
				
			$obj='{"idRegistroConvenio":"'.$fSuscripcion[2].'","fechaFirmaConvenio":"'.$fSuscripcion[0].'","idConvenio":"'.$fSuscripcion[1].'","convenioFirmado":"'.$fila[25].'","comentariosVoBo":"'.cv($comentariosVoBo).'","folioConvenio":"'.$fila[24].'","justificaConcepto":"'.$justificaConcepto.'","cambiosNotificados":"'.$cambiosNotificados.'","marcaAutorizado":"'.$fila[16].'","nombreOSC":"'.cv($nomOSC).'","codigo":"'.$fila[9].'","categoria":"'.$nCategoria.'","promedio":"'.$promedio.'","montoSolicitado":"'.$montoSolicitado.
				'","montoAutorizado":"'.$montoAutorizado.'","diferencia":"'.$diferencia.'","porcentajeDisminucion":"'.$porcentaje.'","montoSolicitado_1":"'.$monto1.'",
				"montoSolicitado_6":"'.$monto6.'","montoSolicitado_7":"'.$monto7.'","montoSolicitado_4":"'.$monto4.'","noSubcategoria":"'.$nSubCategoria.
				'","idRegistroSituacion":"'.$fDictamen[0].'","comentariosFinales":"'.$fDictamen[2].'","comentarios":"'.cv($comentarios).'","id__448_tablaDinamica":"'.$fila[0].'",
				"primeraParticipacion":"'.$pParticipacion.'","fechaCreacionOSC":"'.$fechaCreacionOSC.'","marcarPosibleDescalificacion":"'.$fDitamenAnt[0].
				'","motivoDescalificacion":"'.cv($fDitamenAnt[1]).'","evaluador":"'.cv($evaluador).'","descalificado":"'.$descalificado
				.'","motivoDescalificacionFinal":"'.$fila[19].'","fechaEvaluacion":"'.$fDictamen[1].'","pintado":"'.$pintado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		
		
		echo '{"montoAutorizado":"'.$montoTotalAutorizado.'","montoAcumulado":"'.$montoAcumulado.'","totalDescalificados":"'.$totalDescalificados.'","totalFinanciados":"'.$totalFinanciados.
			'","totalNOFinanciados":"'.$totalNoFinanciados.'","numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function registrarVoBoProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		
		
		
		$consulta[$x]="begin";
		$x++;
		if(!isset($obj->ajuste))
		{
			$query="SELECT idDictamen FROM 100_dictamenFinalOSCPresupuesto2014 WHERE idProyecto=".$obj->idProyecto;
			$idDictamen=$con->obtenerValor($query);
			if($idDictamen!="")
			{
				$consulta[$x]="UPDATE 100_dictamenFinalOSCPresupuesto2014 SET dictamen=1,comentariosFinales='".cv($obj->comentarios)."',fechaDictamen='".date("Y-m-d H:i:s")."',idResponsableDictamen=".$_SESSION["idUsr"]." WHERE idProyecto=".$obj->idProyecto;
				$x++;
			}
			else
			{
				$consulta[$x]="INSERT INTO 100_dictamenFinalOSCPresupuesto2014(idProyecto,dictamen,comentariosFinales,fechaDictamen,idResponsableDictamen)
								VALUES(".$obj->idProyecto.",1,'".cv($obj->comentarios)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
				$x++;
			}
			$consulta[$x]="UPDATE _448_tablaDinamica SET marcaAutorizado=1 WHERE id__448_tablaDinamica=".$obj->idProyecto;
			$x++;
		}
		foreach($obj->arrConceptos as $r)
		{
			/*$eliminado=0;
			
			if(($r->situacion==2)||($r->conceptoCancelado==1))
			{
				$eliminado=1;
			}*/
			$consulta[$x]="UPDATE 100_ajustesOSCConceptosPresupuesto2014 SET idRubro=".$r->idRubro.",total=".$r->montoAutorizado.",costoUnitario='".($r->costoUnitarioAutorizado)."',cantidad=".$r->cantidadAutorizada.",comentariosAdicionales='".cv($r->comentariosOSC).
						"',dictamenFinal=".$r->situacion.",comentariosVoBo='".cv($r->comentariosVoBo)."',conceptoEliminado=".$r->conceptoCancelado." WHERE idConcepto=".$r->idConcepto;
			$x++;
		}
		
		
		
		/*$consulta[$x]="UPDATE 100_calculosGrid SET eliminado=".$eliminado.",montoAutorizado=".$r->montoAutorizado.",comentarios='".cv($r->comentarios)."' WHERE idGridVSCalculo=".$r->idConcepto;
		$x++;*/
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}	
	}
	
	function marcarFirmaConvenio()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$marca=$_POST["marca"];
		$consulta="UPDATE _448_tablaDinamica SET convenioFirmado=".$marca." WHERE id__448_tablaDinamica=".$idProyecto;	
		eC($consulta);
	}
	
	function registrarObjetivoGeneral()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="SELECT idObjetivoGeneral FROM 112_objetivoGeneral WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$idObjetivoGeneral=$con->obtenerValor($consulta);
		if($idObjetivoGeneral=="")
		{
			$query[$x]="INSERT INTO 112_objetivoGeneral(idFormulario,idReferencia,objetivoGeneral)
						VALUES(".$obj->idFormulario.",".$obj->idReferencia.",'".cv($obj->objetivoGeneral)."')";
			$x++;
		}
		else
		{
			$query[$x]="update 112_objetivoGeneral set objetivoGeneral='".cv($obj->objetivoGeneral)."' where idObjetivoGeneral=".$idObjetivoGeneral;
						
			$x++;	
		}

		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	
	function registrarObjetivoEspecifico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$query[$x]="begin";
		$x++;
		
		if($obj->idRegistro=="-1")
		{
			$query[$x]="INSERT INTO 113_objetivosEspecificos(idObjetivoGeneral,objetivoEspecifico) VALUES(".$obj->idObjetivoGeneral.",'".cv($obj->txtObjetivoEspecifico)."')";
			$x++;
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="update 113_objetivosEspecificos set objetivoEspecifico='".cv($obj->txtObjetivoEspecifico)."' where idRegistro=".$obj->idRegistro;
			$x++;	
			$query[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
			
		}
		
		$query[$x]="DELETE FROM 971_objetivosEspecificosVSIndicadores WHERE idObjetivo=@idRegistro";
		$x++;
		
		foreach($obj->indicadores as $i)
		{
			$query[$x]="INSERT INTO 971_objetivosEspecificosVSIndicadores(idObjetivo,idIndicador,cantidad,idFormulario,idReferencia) VALUES(@idRegistro,".$i->idIndicador.",".$i->cantidad.",".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;
		}
	
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerElementoSeccionObjetivos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$mesIni=$_POST["mesIni"];
		$mesFin=$_POST["mesFin"];
		$consulta="SELECT objetivoGeneral,idObjetivoGeneral FROM 112_objetivoGeneral WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
		$fila=$con->obtenerPrimeraFila($consulta);
		$objetivo=$fila[0];
		$comp="";
		for($x=$mesIni;$x<=$mesFin;$x++)
		{
			
			$checado="false";
			$comp.=',"mes_'.$x.'":'.$checado;
		}
		
		$hijos=obtenerElementoSeccionObjetivosEspecificos($fila[1],$mesIni,$mesFin);
		$compHoja="";
		if($hijos=="[]")
			$compHoja=",leaf:true";
		else
			$compHoja=",leaf:false,children:".$hijos;
		$obj='{"txtTipoElemento":"Objetivo General","icon":"../images/comment_add.png","id":"obj_'.$fila[1].'","actividad":"'.cv($objetivo).'","tipo":"1"'.$comp.$compHoja.'}';
		echo '['.$obj.']';
	}
	
	function obtenerElementoSeccionObjetivosEspecificos($iO,$mesIni,$mesFin)
	{
		global $con;	
	
		
		$comp="";
		$nReg=1;
		for($x=$mesIni;$x<=$mesFin;$x++)
		{
			
			$checado="false";
			$comp.=',"mes_'.$x.'":'.$checado;
		}
		
		$arrElementos="";
		$consulta="SELECT objetivoEspecifico,idRegistro FROM 113_objetivosEspecificos WHERE idObjetivoGeneral=".$iO." order by idRegistro";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{

			$hijos=obtenerElementoSeccionMeta($fila[1],$mesIni,$mesFin);

			$compHoja="";
			if($hijos=="[]")
				$compHoja=",leaf:true";
			else
				$compHoja=",leaf:false,children:".$hijos;

			$arrIndicadores="";
			$consulta="SELECT idIndicador,i.nombreIndicador,1,i.nombreIndicador,cantidad,i.descripcion,IF(i.tipoIndicador=13,3,i.tipoIndicador) 
					FROM 971_objetivosEspecificosVSIndicadores m,_375_tablaDinamica i WHERE idObjetivo=".$fila[1]." 
					AND i.id__375_tablaDinamica=m.idIndicador ORDER BY i.nombreIndicador";
			$arrIndicadores=$con->obtenerFilasArreglo($consulta);

			$obj='{"arrIndicadores":'.$arrIndicadores.',"txtTipoElemento":"Objetivo Específico '.$nReg.'","icon":"../images/comments_add.png","id":"objE_'.$fila[1].'","actividad":"'.cv($fila[0]).'","tipo":"2"'.$comp.$compHoja.'}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else
				$arrElementos.=",".$obj;
			$nReg++;
			
		}
		return '['.$arrElementos.']';
	}
	
	function obtenerElementoSeccionMeta($iO,$mesIni,$mesFin)
	{
		global $con;	
		
		
		$comp="";
		$nReg=1;
		for($x=$mesIni;$x<=$mesFin;$x++)
		{
			
			$checado="false";
			$comp.=',"mes_'.$x.'":'.$checado;
		}
		$arrElementos="";
		$consulta="SELECT meta,idRegistro,cantidad FROM 114_metasProyectos2014 WHERE idObjetivoEspecifico=".$iO." order by idRegistro";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$hijos=obtenerActividadesCronogramaMetaV2($fila[1],$mesIni,$mesFin);

			$compHoja="";
			if($hijos=="[]")
				$compHoja=",leaf:true";
			else
				$compHoja=",leaf:false,children:".$hijos;
				
			$arrIndicadores="";
			$consulta="SELECT idIndicador,i.nombreIndicador,1,i.nombreIndicador,cantidad,i.descripcion,IF(i.tipoIndicador=13,3,i.tipoIndicador) 
					FROM 971_metasVSIndicadores m,_375_tablaDinamica i WHERE idMeta=".$fila[1]." AND i.id__375_tablaDinamica=m.idIndicador ORDER BY i.nombreIndicador";
			$arrIndicadores=$con->obtenerFilasArreglo($consulta);
				
			$obj='{"cantidad":"'.$fila[2].'","txtTipoElemento":"Meta","icon":"../images/lightbulb_add.png","id":"meta_'.$fila[1].'",arrIndicadores:'.$arrIndicadores.',"actividad":"'.cv($fila[0]).'","tipo":"3"'.$comp.$compHoja.'}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else
				$arrElementos.=",".$obj;
			$nReg++;
			
		}
		return '['.$arrElementos.']';
	}
	
	
	function obtenerActividadesCronogramaMetaV2($idMeta,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion,idIntervencion,actividadIntervencion,otraIntervencion FROM 965_actividadesUsuario WHERE idMeta=".$idMeta." order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";

		
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x."";
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$hijos="";
			$cadHijos=obtenerActividadesMetaHijosV2($fila[0],$mesIni,$mesFin);

			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			
			$descripcion="";
			if($fila[4]!="")
			{
				$descripcion=": ";
				$consulta="SELECT txtActividades FROM _503_tablaDinamica WHERE id__503_tablaDinamica=".$fila[4];
				$descripcion.=cv($con->obtenerValor($consulta));
				
				$consulta="SELECT sublinea FROM _489_gridSublineas WHERE id__489_gridSublineas=".$fila[3];
				$descripcion.=", Intervenci&oacute;n: ".cv($con->obtenerValor($consulta));
			}
			
			$consulta="SELECT idPoblacionVulnerable,idPoblacionBlanco,genero,rangoEdad,totalDirecta,totalIndirecta FROM 968_actividadesPoblacion WHERE idActividad=".$fila[0];
			$arrPoblacionesActividad=$con->obtenerFilasArreglo($consulta);
						
			$obj='{"especifiqueOtra":"'.cv($fila[5]).'","arrPoblacionesActividad":'.$arrPoblacionesActividad.',"idIntervencion":"'.$fila[3].'","actividadIntervencion":"'.cv($fila[4]).'","txtTipoElemento":"Actividad'.cv($descripcion).'","icon":"../images/lightning_add.png","id":"a_'.$fila[0].'","tipo":"4","actividad":"'.cv($fila[1]).'"'.$comp.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return "[".$cadActividades."]";
	}

	function obtenerActividadesMetaHijosV2($idActividad,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion,idIntervencion,actividadIntervencion,otraIntervencion FROM 965_actividadesUsuario WHERE idPadre=".$idActividad. " order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		while($fila=mysql_fetch_row($res))
		{
			
			
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x; 
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$cadHijos=obtenerActividadesMetaHijosV2($fila[0],$mesIni,$mesFin);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			
			$descripcion="";
			if($fila[4]!="")
			{
				$descripcion=": ";
				$consulta="SELECT txtActividades FROM _503_tablaDinamica WHERE id__503_tablaDinamica=".$fila[4];
				$descripcion.=cv($con->obtenerValor($consulta));
				
				$consulta="SELECT sublinea FROM _489_gridSublineas WHERE id__489_gridSublineas=".$fila[3];
				$descripcion.=", Intervenci&oacute;n: ".cv($con->obtenerValor($consulta));
			}
			
			$consulta="SELECT idPoblacionVulnerable,idPoblacionBlanco,genero,rangoEdad,totalDirecta,totalIndirecta FROM 968_actividadesPoblacion WHERE idActividad=".$fila[0];
			$arrPoblacionesActividad=$con->obtenerFilasArreglo($consulta);
			
			$obj='{"especifiqueOtra":"'.cv($fila[5]).'","arrPoblacionesActividad":'.$arrPoblacionesActividad.',"idIntervencion":"'.$fila[3].'","actividadIntervencion":"'.$fila[4].'","txtTipoElemento":"Actividad'.$descripcion.'","icon":"../images/lightning_add.png","id":"a_'.$fila[0].'","tipo":"4","actividad":"'.cv($fila[1]).'"'.$comp.$hijos.'}';
			
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return $cadActividades;
	}
	
	
	function registrarMeta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$query[$x]="begin";
		$x++;
		
		if($obj->idRegistro=="-1")
		{
			$query[$x]="INSERT INTO 114_metasProyectos2014(idObjetivoEspecifico,meta,cantidad) VALUES(".$obj->idObjetivoEspecifico.",'".cv($obj->meta)."',0)";
			$x++;
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="update 114_metasProyectos2014 set meta='".cv($obj->meta)."',cantidad=0 where idRegistro=".$obj->idRegistro;
			$x++;
			$query[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;	
		}
		
		$query[$x]="DELETE FROM 971_metasVSIndicadores WHERE idMeta=@idRegistro";
		$x++;
		
		foreach($obj->indicadores as $i)
		{
			$query[$x]="INSERT INTO 971_metasVSIndicadores(idMeta,idIndicador,cantidad,idFormulario,idReferencia) VALUES(@idRegistro,".$i->idIndicador.",".$i->cantidad.",".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;
		}

		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function removerElementoCronogramaActividades()
	{
		global $con;

		$tipoElemento=$_POST["tipoElemento"];
		$idElemento=$_POST["idElemento"];
		$consulta="";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		switch($tipoElemento)		
		{
			case "1":
				$consulta[$x]="DELETE FROM 112_objetivoGeneral WHERE idObjetivoGeneral=".$idElemento;
				$x++;
			break;
			case "2":
				$consulta[$x]="DELETE FROM 113_objetivosEspecificos WHERE idRegistro=".$idElemento;
				$x++;
			break;
			case "3":
				$consulta[$x]="DELETE FROM 114_metasProyectos2014 WHERE idRegistro=".$idElemento;
				$x++;
			break;
			case "4":
				$idActividad=$idElemento;
				
				
				$query="select idActividadPrograma from 965_actividadesUsuario where idPadre=".$idActividad;
				$res=$con->obtenerFilas($query);
				while($f=mysql_fetch_row($res))
				{
					removerActividadHija($f[0],$consulta,$x);
				}
				
				$consulta[$x]="delete from 965_actividadesUsuario WHERE idActividadPrograma=".$idActividad;
				$x++;
				$consulta[$x]="delete from 968_planeacionActividadesMeses WHERE idActividad=".$idActividad;
				$x++;
				$consulta[$x]="delete from 968_actividadesIndicador WHERE idActividad=".$idActividad;
				$x++;
				
				
			break;
				
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDatosConvenio2014()
	{
		global $con;	
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT fechaSuscripcion,convenio FROM _472_tablaDinamica WHERE id__472_tablaDinamica=".$idRegistro;
		$fConvenio=$con->obtenerPrimeraFila($consulta);
		$obj='{"fechaConvenio":"'.$fConvenio[0].'","idArchivo":"'.$fConvenio[1].'"}';
		echo "1|".$obj;
		
	}
	
	function verificarCFDIValido()
	{
		global $baseDir;
		global $con;
		$c=new cFacturaCFDI();
		$cadObj="";
		$nombreArchivo=bD($_POST["nA"]);
		$archivoXML=$baseDir."/archivosTemporales/".$nombreArchivo;
		
		$cuerpoArchivo=leerContenidoArchivo($archivoXML);
		
		$resultado=2;
		if($c->estructuraXMLCFDIValida($cuerpoArchivo))
		{
			$obj=$c->convertirXMLCadenaToObj($cuerpoArchivo);
			
			
			/*if($_SESSION["idUsr"]==1)
				varDump($obj);*/
			
			$totalImpuestosIVA=0;
			$totalImpuestosISR=0;
			$totalImpuestosIEPS=0;
			$totalRetenciones=0;

			$rfc1="";
			$rfc2="";
			$rfc3="";
			if(strlen($obj["datosEmisor"]["rfc"])==12)
			{
				$rfc1=substr($obj["datosEmisor"]["rfc"],0,3);
				$rfc2=substr($obj["datosEmisor"]["rfc"],3,6);
				$rfc3=substr($obj["datosEmisor"]["rfc"],9,3);
			}
			else
			{
				$rfc1=substr($obj["datosEmisor"]["rfc"],0,4);
				$rfc2=substr($obj["datosEmisor"]["rfc"],4,6);
				$rfc3=substr($obj["datosEmisor"]["rfc"],10,3);
			}
			
			
			$consulta="SELECT * FROM 595_proveedores WHERE rfc1='".$rfc1."' AND rfc2='".$rfc2."' AND rfc3='".$rfc3."'";
			$idProveedor=$con->obtenerValor($consulta);
			if($idProveedor=="")
			{
				$consulta="INSERT INTO 595_proveedores(rfc1,rfc2,rfc3,razonSocial) VALUES('".$rfc1."','".$rfc2."','".$rfc3."','".cv($obj["datosEmisor"]["razonSocial"])."')";
				$con->ejecutarConsulta($consulta);
				$idProveedor=$con->obtenerUltimoID();
			}
			
			
			
			if(isset($obj["impuestos"]))
			{
				if(sizeof($obj["impuestos"]["retenciones"])>0)
				{
					foreach($obj["impuestos"]["retenciones"] as $t)
					{
						$totalRetenciones+=$t["importe"];
					}
				}
				else
				{
					$totalRetenciones=$obj["impuestos"]["totalRetenciones"];
				}
				
				$arrIVA="";
				$arrISR="";
				$arrIEPS="";
				
				if(sizeof($obj["impuestos"]["traslados"])>0)
				{
					foreach($obj["impuestos"]["traslados"] as $t)
					{
						$o="['".$t["importe"]."','".$t["tasa"]."']";
						switch($t["impuesto"])
						{
							case "IVA":
								$totalImpuestosIVA+=$t["importe"];
								if($arrIVA=="")
									$arrIVA=$o;
								else
									$arrIVA.=",".$o;
							break;
							case "ISR":
								$totalImpuestosISR+=$t["importe"];
								if($arrISR=="")
									$arrISR=$o;
								else
									$arrISR.=",".$o;

							break;
							case "IEPS":
								$totalImpuestosIEPS+=$t["importe"];
								if($arrIEPS=="")
									$arrIEPS=$o;
								else
									$arrIEPS.=",".$o;
							break;
							
						}
					}
				}	
						
				
				$arrIVA="[".$arrIVA."]";
				$arrISR="[".$arrISR."]";
				$arrIEPS="[".$arrIEPS."]";
				
			}
			
			
			$fecha=strtotime($obj["fechaComprobante"]);
			if($obj["descuento"]=="")
				$obj["descuento"]=0;
			$arrProductos="";
			$totalCalculado=0;	
			foreach($obj["conceptos"] as $c)	
			{
				$o='{"idConcepto":"'.date("YmdHis")."_".rand(1000,100000)."_".rand(1000,100000).'","descripcion":"'.cv($c["descripcion"]).'","cantidad":"'.cv($c["cantidad"]).'","costoUnitario":"'.
					cv($c["valorUnitario"]).'","importe":"'.cv($c["importe"]).'","total":"'.cv($c["importe"]).'"}';
				if($arrProductos=="")
					$arrProductos=$o;
				else
					$arrProductos.=",".$o;
				$totalCalculado+=$c["importe"];	
			}
			
			
			if(sizeof($obj["conceptos"])>1)
			{
			
				$totalCalculado=$totalCalculado-$obj["descuento"]+$totalImpuestosIVA+$totalImpuestosISR-$totalRetenciones;
				
				
				if((abs($obj["total"]-$totalCalculado)>1)&&($totalImpuestosIEPS>0))
				{
					$o='{"idConcepto":"0","descripcion":"(IEPS) IMPUESTO ESPECIAL SOBRE PRODUCCIÓN Y SERVICIOS","cantidad":"1","costoUnitario":"'.
					$totalImpuestosIEPS.'","importe":"'.$totalImpuestosIEPS.'","total":"'.$totalImpuestosIEPS.'"}';
					if($arrProductos=="")
						$arrProductos=$o;
					else
						$arrProductos.=",".$o;
				}
				
			}
				
			$cadObj='{"arrISR":'.$arrISR.',"arrIEPS":'.$arrIEPS.',"arrIVA":'.$arrIVA.',"idProveedor":"'.$idProveedor.'","totalImpuestosIEPS":"'.$totalImpuestosIEPS.'","totalImpuestosIVA":"'.$totalImpuestosIVA.'","totalImpuestosISR":"'.$totalImpuestosISR.'","totalRetenciones":"'.$totalRetenciones.'","resultado":"0","rfc":"'.$rfc1."-".$rfc2."-".$rfc3.'","razonSocial":"'.
					cv($obj["datosEmisor"]["razonSocial"]).'","fechaComprobante":"'.date("Y-m-d",$fecha).'","folio":"'.$obj["folioUUID"].'","serie":"'.$obj["serie"].
					'","subtotal":"'.$obj["subtotal"].'","descuento":"'.$obj["descuento"].'","total":"'.$obj["total"].'","arrProductos":['.$arrProductos.']}';
			$resultado=1;
		}
		echo "1|".$resultado."|".$cadObj;
	}
	
	function verificarCFDIAlterado()
	{
		global $baseDir;
		
		
		$arrExcepciones["6E2EC0F8-E9FD-D745-BED3-102467C3103D"]=1;
		
			
		
		
		
		$c=new cFacturaCFDI();
		$nombreArchivo=bD($_POST["nA"]);
		$archivoXML=$baseDir."/archivosTemporales/".$nombreArchivo;
		$cuerpoArchivo=leerContenidoArchivo($archivoXML);
		
		foreach($arrExcepciones as $folio=>$resto)
		{
			if(strpos($cuerpoArchivo,'UUID="'.$folio.'"')!==false)
			{
				echo "1|1";
				return;
			}
		}
		
		$resultado=2;
		if($c->selloXMLCFDICorrecto($cuerpoArchivo))
			$resultado=1;
		echo "1|".$resultado;
	}
	
	function verificarCFDISAT()
	{
		global $baseDir;
		$c=new cFacturaCFDI();
		$nombreArchivo=bD($_POST["nA"]);
		$archivoXML=$baseDir."/archivosTemporales/".$nombreArchivo;
		$cuerpoArchivo=leerContenidoArchivo($archivoXML);
		$resultado=$c->validarXMLSATWS($cuerpoArchivo);
		
		echo "1|".$resultado;
	}
	
	function verificarCFDIRegistroSistema()
	{
		global $con;
		$folio=bD($_POST["folio"]);
		$consulta="SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE folioComprobante='".$folio."' and situacion in (0,1)";	
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
			echo "1|1";
		else
			echo "1|2";
	}		
	
	function obtenerInformesTecnicosPeriodoCiclo2014()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$ignorarPermisos=false;
		
		$vSupervisor=0;
		if(isset($_POST["vSupervisor"]))
			$vSupervisor=$_POST["vSupervisor"];
		
		if(isset($obj->ignorarPermisos))
			$ignorarPermisos=true;
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=2;
		$arrEvaluaciones[3]=3;
		$arrEvaluaciones[4]=4;
		
		
		$periodo=$_POST["periodo"];
		
		
		$idEvaluacion=$arrEvaluaciones[$periodo];
		
		$compAux=" and 1=2";
		$compAux2=" and 1=2";
		if((existeRol("'99_0'"))||(existeRol("'1_0'"))||(existeRol("'100_0'")) ||($_SESSION["idUsr"]==70)||(($_SESSION["idUsr"]==461) &&($vSupervisor==1) ))
		{
			$compAux=" ";
			$compAux2=" ";
			
			if($_SESSION["idUsr"]==70)
			{
				$compAux=" and id__448_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2014)";
				$compAux2=" and id__464_tablaDinamica=27";
			}
			
		}
		else
			if((existeRol("'95_0'"))||(existeRol("'101_0'")))
			{
				$compAux=" and  id__".$idFormulario."_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2014)";
				$compAux2=" and idSupervisor=".$_SESSION["idUsr"];
			}
		
		
		if(($vSupervisor==1)||($_SESSION["idUsr"]==461))
		{
			$compAux=" ";
			$compAux2=" ";
		}
		
		$consulta="
				select * from (
								(
									SELECT id__".$idFormulario."_tablaDinamica AS idProyecto,codigo AS folio,tituloProyecto AS titulo,o.unidad as organizacion, 
									(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as situacionEvaluacion,
									(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaRealizacion,
									(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as idInforme,
									(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaModificacion,
									(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaEvaluacion,
									(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." 
										and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion,
									(SELECT COUNT(*) FROM _473_tablaDinamica WHERE idEstado=5 AND idReferencia=t.id__".$idFormulario."_tablaDinamica) as productosValidar,'448'	as idFormulario,
									proyLiberado				
									FROM _".$idFormulario."_tablaDinamica t,817_organigrama o 
									WHERE t.marcaAutorizado=1 AND o.codigoUnidad=t.codigoInstitucion ".$compAux."
								)
								union
								(
									SELECT id__464_tablaDinamica AS idProyecto,codigo AS folio,tituloProyecto AS titulo,o.unidad as organizacion, 
									(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." limit 0,1) as situacionEvaluacion,
									(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaRealizacion,
									(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." limit 0,1) as idInforme,
									(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaModificacion,
									(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaEvaluacion,
									(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=464 AND idReferencia=t.id__464_tablaDinamica AND noInforme=".$periodo." 
										and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion,
									'N/A' as productosValidar,'464'	as idFormulario,
									proyLiberado					
									FROM _464_tablaDinamica t,817_organigrama o 
									WHERE t.marcaAutorizado=1 AND o.codigoUnidad=t.codigoInstitucion ".$compAux2."
								)
								
								
							) as tmp ORDER BY organizacion,folio";
		
		$res=$con->obtenerFilas($consulta);
		$arrReg="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$permisos="TFPCL";
			$consulta="SELECT resultadoEvaluacion FROM 3002_evaluacionesFinales WHERE idFormulario=".$fila[11]." AND idReferencia=".$fila[0]." and noEvaluacion=".$idEvaluacion." ORDER BY idEvaluacionFinal desc limit 0,1";
			$resEval=$con->obtenerValor($consulta);
			if(($resEval=="")&&(($fila[12]==1)||($fila[4]!="")))
			{
				$resEval=3;
			}
			
			if($fila[4]=="3")
				$resEval=3;
			else
				if($fila[4]=="4")
					$resEval=2;
				
			
			
				
			$obj='{"idFormulario":"'.$fila[11].'","productosValidar":"'.$fila[10].'","comentariosEvaluacion":"'.cv(str_replace("#R","",$fila[9])).'","situacionDictamenFinal":"'.$resEval.'","idProyecto":"'.$fila[0].'","folio":"'.$fila[1].'","organizacion":"'.cv($fila[3]).'","fechaRealizacion":"'.$fila[5]
				.'","titulo":"'.cv($fila[2]).'","idInforme":"'.$fila[6].'","situacionEvaluacion":"'.$fila[4].
				'","fechaUltimaModificacion":"'.$fila[7].'","fechaUltimaEvaluacion":"'.$fila[8].'","permisos":"'.$permisos.'"}';
			if($arrReg=="")
				$arrReg=$obj;
			else
				$arrReg.=",".$obj;
			$ct++;
		}
		
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrReg.']}';
		
			
	}
	
	function registrarEvaluacionProyecto2daConv()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idRegistro FROM 1040_evaluacionProyectos2da2014 WHERE idProyecto=".$obj->idRegistro;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 1040_evaluacionProyectos2da2014(idProyecto,idResposable,resultado,comentarios,fechaDictamen)
					VALUES(".$obj->idRegistro.",".$_SESSION["idUsr"].",".$obj->resultado.",'".cv($obj->comentarios)."','".date("Y-m-d H:i:s")."')";
		}
		else
		{
			$consulta="UPDATE 1040_evaluacionProyectos2da2014 SET idResponsable=".$_SESSION["idUsr"].",resultado=".$obj->resultado.",comentarios='".cv($obj->comentarios)."',fechaDictamen='".date("Y-m-d H:i:s")."' WHERE idRegistro=".$idRegistro;
		}
		eC($consulta);
	}
	
	function guardarComprobacionV2()
	{
		global $con;
		global $baseDir;
		$permitirValidacionResponsable=true;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		/*if($obj->idReferencia=="278")
		{
			varDump($obj);
			return;	
		}*/
		
/*		$query="select idEstado from _448_tablaDinamica where id__448_tablaDinamica=".$obj->idReferencia;
		$idEstado=$con->obtenerValor($query);
		if($idEstado!=11)
		{
			echo "El periodo de comprobaci&oacute;n financiera ha expirado";
			return;	
		}
*/		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if(copy($baseDir."/archivosTemporales/".$obj->idComprobante,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idComprobante))
		{
			unlink($baseDir."/archivosTemporales/".$obj->idComprobante);
		}
		$situacionComprobaciones=0;
		
		
		if($obj->idProveedor!=-1)
		{
			$consulta[$x]="set @idProveedor:=".$obj->idProveedor;
			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 595_proveedores(razonSocial,calle) VALUES('".cv($obj->proveedor)."','".cv($obj->direccion)."')";
			$x++;
			$consulta[$x]="set @idProveedor:=(select last_insert_id())";
			$x++;
			
		}
		
		
		$estadoComprobante=0;
		$situacion="0";
		$caidaSAT=false;
		$anioAprobacion="NULL";
		
			
		switch($obj->tComprobante)
		{
			
			//case 4:
			case 5:
			case 6:
				if($obj->noAprobacion!="")
				{
					$query="SELECT CONCAT(rfc1,rfc2,rfc3) FROM 595_proveedores WHERE idProveedor=".$obj->idProveedor;
					$rfc=$con->obtenerValor($query);
					$salir=false;
					$nChecadas=0;
					
					while(!$salir)
					{
						$res=verificarComprobanteSATSelloDigital($rfc,$obj->tComprobante,$obj->noSerie,$obj->folio,$obj->noAprobacion);
						switch($res)
						{
							case "0":
								$situacion=4;
								$salir=true;
								$estadoComprobante=0;
							break;
							case "1":
								$estadoComprobante=0;
								$situacion=5;
								$salir=true;
							break;
							case "2":
								$nChecadas++;
								sleep(3);
								if($nChecadas>3)
								{
									$salir=true;
									$situacion=0;
									$caidaSAT=true;
									if($permitirValidacionResponsable)
										$estadoComprobante=0;
									else
									{
										$estadoComprobante=3;
										$situacionComprobaciones=3;
									}
								}
							break;
						}
					}
				}
			break;
			case 1:
			case 2:
			case 4:
			case 3:
				$estadoComprobante=0;
			break;
			case 7:
			case 10:
				$situacion=0;
				switch($obj->validacionSAT)
				{
					case 0:
						$situacion=4;
					break;
					case 1:
						$situacion=5;
					break;
					case 2:
						$situacion=0;
					break;
				}
				if($permitirValidacionResponsable)
					$estadoComprobante=0;
			break;
			case 8:
				if($permitirValidacionResponsable)
					$estadoComprobante=0;
			break;
		}
		
		
		$consulta[$x]="INSERT INTO 101_comprobantesPresupuestales(idProveedor,tipoComprobante,folioComprobante,numeroAprobacion,
						idComprobante,nombreArchivo,fechaCreacion,situacion,montoComprobacion,idFormulario,idReferencia,iva,noSerie,validacionSAT,anioAprobacion,fechaComprobante,comentariosEnvio)
						VALUES(@idProveedor,".$obj->tComprobante.",'".$obj->folio."','','".$obj->idComprobante."','".
						cv($obj->nombreArchivo)."','".date("Y-m-d H:i")."',".$estadoComprobante.",".$obj->montoComprobacion.",".$obj->idFormulario.",".$obj->idReferencia.",".($obj->iva).",'".
						cv($obj->noSerie)."',".$situacion.",NULL,'".$obj->fechaComprobante."','".cv($obj->comentariosAdicionales)."')";
		$x++;	
							
		$consulta[$x]="set @idFactura:=(select last_insert_id())";
		$x++;
		if($caidaSAT)
		{
			$consulta[$x]="INSERT INTO 105_caidasSAT(idFactura,fechaCaida) VALUES(@idFactura,'".date("Y-m-d H:i")."')";
			$x++;
		}
		
		
		switch($obj->tComprobante)
		{
			case 7:
			case 10:
				foreach($obj->arrConceptos as $o)
				{
					$cantidad=1;
					if(isset($o->cantidad))
						$cantidad=$o->cantidad;
					
					$consulta[$x]="INSERT INTO 102_conceptosCFDI(descripcion,total,montoIVA,montoIHS,idFactura,montoDescuento,cantidad)
									VALUES('".cv($o->descripcion)."',".$o->total.",".$o->montoIVA.",".$o->montoIHS.",@idFactura,".$o->montoDescuento.",".$cantidad.")";
					$x++;
					
					$consulta[$x]="set @idConceptoCFDI:=(select last_insert_id())";
					$x++;
					
					foreach($o->arrConceptos as $c)
					{
						$consulta[$x]="INSERT INTO 102_conceptosComprobacion(idConcepto,descripcion,montoComprobacion,gravaIVA,idFactura,situacion,montoSinIVA)
									VALUES(".$c->idConcepto.",@idConceptoCFDI,".$c->montoComprobacion.",0,@idFactura,".$situacionComprobaciones.",".$c->montoComprobacion.")";
						$x++;
					}
				}
			break;
			default:
			
				foreach($obj->arrConceptos as $o)
				{
					$consulta[$x]="INSERT INTO 102_conceptosComprobacion(idConcepto,descripcion,montoComprobacion,gravaIVA,idFactura,situacion,montoSinIVA)
								VALUES(".$o->idConcepto.",'".cv($o->descripcion)."',".$o->montoComprobacion.",".$o->gravaIVA.",@idFactura,".$situacionComprobaciones.",".$o->montoSinIVA.")";
					$x++;
				}
			break;
				
		}
		
		if($obj->tComprobante==4)
		{
			$fechaRegreso="NULL";
			if($obj->objBoletaAvion->tipoViaje!=0)
			{
				$fechaRegreso="'".$obj->objBoletaAvion->fechaRegreso."'";
			}
			$consulta[$x]="INSERT INTO 107_datosBoletoAvion(origen,destino,tipoViaje,fechaSalida,fechaRegreso,idComprobante) VALUES('".cv($obj->objBoletaAvion->origen)."','".cv($obj->objBoletaAvion->destino)."',".$obj->objBoletaAvion->tipoViaje.
							",'".$obj->objBoletaAvion->fechaSalida."',".$fechaRegreso.",@idFactura)";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);

	}
	
	function registrarEvaluacionEtapa1()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$resultado=0;
		foreach($obj->arrRespuestas as $r)
		{
			$resultado+=$r->ponderacion;
		}
		
		$consulta="SELECT idRegistro FROM 1040_evaluacionProyectos2da2014 WHERE idProyecto=".$obj->idRegistro;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$query[$x]="INSERT INTO 1040_evaluacionProyectos2da2014(idProyecto,idResponsable,resultado,comentarios,fechaDictamen)
						VALUES(".$obj->idRegistro.",".$_SESSION["idUsr"].",".$resultado.",'".cv($obj->comentariosAdicionales)."','".date("Y-m-d H:i:s")."')";
			$x++;
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="set @idRegistro:=".$idRegistro;
			$x++;
			$query[$x]="UPDATE 1040_evaluacionProyectos2da2014 SET idResponsable=".$_SESSION["idUsr"].",resultado=".
						$resultado.",comentarios='".cv($obj->comentariosAdicionales)."', fechaDictamen='".date("Y-m-d H:i:s")."' WHERE idRegistro=@idRegistro";
			$x++;
			$query[$x]="delete from 1041_respuestascuestionarioEvaluacion where idRegistro=".$idRegistro;
			$x++;
		}
		foreach($obj->arrRespuestas as $r)
		{
			$query[$x]="INSERT INTO 1041_respuestascuestionarioEvaluacion(idRegistro,idPregunta,valorRespuesta,tipoRespuesta,comentarios,ponderacion,idProyecto)
						VALUES(@idRegistro,".$r->idPregunta.",".$r->valor.",".$r->tipoRespuesta.",'".cv($r->comentarios)."',".$r->ponderacion.",".$obj->idRegistro.")";
			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerInformeFinanciero2014()
	{
		global $con;	

		$condWhere2="";
		$condWhere="";
		if((existeRol("'1_0'"))||($_SESSION["idUsr"]==70) ||(existeRol("'99_0'"))||(existeRol("'100_0'"))||($_SESSION["idUsr"]==461))
		{
				$condWhere="";
				if($_SESSION["idUsr"]==70)
				{
					$condWhere=" and id__448_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2014)";
					$condWhere2=" and id__464_tablaDinamica=27";
				}
		}
		else
		{
			$condWhere=" and id__448_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2014)";
			$condWhere2=" and idSupervisor=".$_SESSION["idUsr"];
		}
		
		if((existeRol("'101_0'"))||(existeRol("'105_0'")))
		{
			$condWhere="";
			$condWhere2="";
		}

		if(isset($_POST["vSupervisor"])&&($_POST["vSupervisor"]==1))	
			$condWhere="";
	
		$cadCondWhere="";
		if(isset($_POST["filter"]))
			$cadCondWhere=" and ".generarCadenaConsultasFiltro($_POST["filter"]);
		
		$consulta="SELECT * FROM (
									(
										SELECT id__448_tablaDinamica as idRegistro,codigo,tituloProyecto,
										(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica ) AS montoAutorizado,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) as comprobacionPorValidar,
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) 
										
										)as montoPorEvaluar,
										
										'0' as montoPorComprobar,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
										
										) as montoReportado,
										'0' as montoComprobado,
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
										c.idFormulario=448 AND c.idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2
										AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
										
										) AS comprobacionRechazadas,
										
										IF(
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=448 AND c.idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											
											
											)IS NULL,
											0,
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=448 AND c.idReferencia=p.id__448_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
											AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											) 
										
										) AS montoRechazado,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND situacion=0) as comprobantesValidar,
										(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND situacion=2 and
										folioComprobante not in (SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND 
										situacion=1 and tipoComprobante in(7,10))) as comprobantesRechazados,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND situacion=1) as comprobantesAceptados,
										(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS osc,'448' as idFormulario,proyLiberado,
										(
										SELECT group_concat(nombre) FROM 800_usuarios u,1038_supervisionProyectos2014 s WHERE s.idUsuario=u.idUsuario AND s.idProyecto=p.id__448_tablaDinamica and s.ciclo=2014
										) as supervisor,
										(
										SELECT distinct id__531_tablaDinamica FROM _531_tablaDinamica t,_531_gridOficios g WHERE t.iFormulario=448 AND t.idReferencia=p.id__448_tablaDinamica 
										AND g.idReferencia=t.id__531_tablaDinamica
										) as ajustesPresupuestales,
										
										(SELECT declaracionConflicto FROM _461_tablaDinamica WHERE idReferencia=p.id__448_tablaDinamica limit 0,1) as cartaConflicto,
										(SELECT autorizacion FROM _461_tablaDinamica WHERE idReferencia=p.id__448_tablaDinamica limit 0,1) as cartaAutorizacion,
										montoMinistrado
										FROM _448_tablaDinamica p
										WHERE marcaAutorizado=1 ".$condWhere."
									)
									union
									(
										SELECT concat('-',id__464_tablaDinamica) as idRegistro,codigo,tituloProyecto,
										(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica ) AS montoAutorizado,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) as comprobacionPorValidar,
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) 
										
										)as montoPorEvaluar,
										
										'0' as montoPorComprobar,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
										
										) as montoReportado,
										'0' as montoComprobado,
										
											
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
										c.idFormulario=464 AND c.idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2
										AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
										
										) AS comprobacionRechazadas,
										
										IF(
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=464 AND c.idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											
											
											)IS NULL,
											0,
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=464 AND c.idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
											AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											) 
										
										) AS montoRechazado,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=0) as comprobantesValidar,
										(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=2 AND
										folioComprobante NOT IN (SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))) AS comprobantesRechazados,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=1) as comprobantesAceptados,
										(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS osc,'464' as idFormulario,proyLiberado,
										(
										SELECT nombre FROM 800_usuarios u WHERE u.idUsuario=p.idSupervisor 
										) as supervisor,
										(
										SELECT distinct id__531_tablaDinamica FROM _531_tablaDinamica t,_531_gridOficios g WHERE t.iFormulario=464 AND t.idReferencia=p.id__464_tablaDinamica 
										AND g.idReferencia=t.id__531_tablaDinamica
										) as ajustesPresupuestales,
										(SELECT declaracionConflicto FROM _467_tablaDinamica WHERE idReferencia=p.id__464_tablaDinamica limit 0,1) as cartaConflicto,
										(SELECT autorizacion FROM _467_tablaDinamica WHERE idReferencia=p.id__464_tablaDinamica limit 0,1) as cartaAutorizacion,
										montoMinistrado
										FROM _464_tablaDinamica p
										WHERE marcaAutorizado=1 ".$condWhere2."
									)
									
									
									
								) AS t where  1=1 ".$cadCondWhere." ORDER BY codigo";
		

		$res=$con->obtenerFilas($consulta);
		
		
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$montoComprobado=0;
			
			$consulta="SELECT montoAutorizado,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion 
			WHERE idConcepto=c.idGridVSCalculo and situacion=1) FROM 100_calculosGrid c WHERE idFormulario=".$fila[17]." AND idReferencia=".abs($fila[0]);
			$resConceptos=$con->obtenerFilas($consulta);
			while($filaConceptos=mysql_fetch_row($resConceptos))
			{
				if($filaConceptos[1]=="")
					$filaConceptos[1]=0;
				if($filaConceptos[1]>$filaConceptos[0])
					$montoComprobado+=$filaConceptos[0];
				else
					$montoComprobado+=$filaConceptos[1];
			}

			
			$permisos="";
			
			$ministracion1=$fila[3]*0.40;
			$ministracion2=$fila[3]*0.30;
			$ministracion3=$fila[3]-($ministracion1+$ministracion2);
			
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=0";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[5]+=$reIntegroPorValidar;
			}
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=1";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[8]+=$reIntegroPorValidar;
				$montoComprobado+=$reIntegroPorValidar;
				if($montoComprobado>$fila[23])
					$montoComprobado=$fila[23];
				$fila[6]-=$montoComprobado;
				if($fila[6]<0)
					$fila[6]=0;
			}
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=2";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[11]+=$reIntegroPorValidar;
			}
			
			$consulta="SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion WHERE idFactura IN 
						(SELECT idFactura FROM 101_comprobantesPresupuestales WHERE idFormulario=".$fila[17]." and idReferencia=".$fila[0].") 
						AND comprobanteCancelado=2 AND situacion=1";
			
			$montoCancelado=$con->obtenerValor($consulta);
			if($montoCancelado=="")
				$montoCancelado=0;
			
			
			
			$porComprobar=$fila[3]-$montoComprobado;
			if($porComprobar<0.01)
				$porComprobar=0;
				
			$consulta="UPDATE _".$fila[17]."_tablaDinamica SET montoAdeudo=".$porComprobar." WHERE id__".$fila[17]."_tablaDinamica=".abs($fila[0]);
			$con->ejecutarConsulta($consulta);
			
			
			$obj='{"montoMinistrado":"'.$fila[23].'","cartaConflicto":"'.$fila[21].'","cartaAutorizacion":"'.$fila[22].'","ajustesPresupuestales":"'.$fila[20].'","supervisor":"'.cv($fila[19]).'","osc":"'.cv($fila[16]).'","proyLiberado":"'.$fila[18].'","idFormulario":"'.$fila[17].'","osc":"'.$fila[16].'","comprobantesAceptados":"'.$fila[15].
					'","comprobantesRechazados":"'.$fila[14].'","ministracion1":"'.$ministracion1.'","ministracion2":"'.$ministracion2.
					'","ministracion3":"'.$ministracion3.'","idRegistro":"'.$fila[0].'","codigo":"'.$fila[1].'","tituloProyecto":"'.cv($fila[2]).
					'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[8].'","montoComprobado":"'.$montoComprobado.
					'","montoPorComprobar":"'.$fila[6].'","comprobacionPorValidar":"'.$fila[4].
					'","comprobacionRechazadas":"'.$fila[10].'","montoRechazado":"'.$fila[11].'","comprobacionesAceptadas":"'.$fila[7].
					'","montoPorEvaluar":"'.$fila[5].'","comprobantesValidar":"'.$fila[12].'","nSolicitudesTranferencia":"'.$fila[13].'","montoCancelado":"'.$montoCancelado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerProductosComunicativosProyecto2014()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormularioProductos=473;
		$idEstado=-1;
		if(isset($_POST["idEstado"]))
			$idEstado=$_POST["idEstado"];
		
		
		$consulta="SELECT id__".$idFormularioProductos."_tablaDinamica as idProducto,descripcion,productoComunicativo as documento,idEstado as situacion,fechaCreacion as fechaRegistro,
		(SELECT comentario FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as comentarios,
		(SELECT fechaHoraDictamen FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as fechaEvaluacion,
		(SELECT u.Nombre FROM 2002_comentariosRegistro c,800_usuarios u WHERE idFormulario=".$idFormularioProductos." AND idRegistro=t.id__".$idFormularioProductos."_tablaDinamica and u.idUsuario=c.idUsuarioResponsable ORDER BY idComentario DESC LIMIT 0,1) as respEvaluacion
		
		 FROM _".$idFormularioProductos."_tablaDinamica t WHERE idReferencia=".$idProyecto;
		
		if($idEstado==-1)
		 	$consulta.=" and idEstado>1";
		else
		 	$consulta.=" and idEstado=".$idEstado;
			
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function registrarComentarioBitacora()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="INSERT INTO 1042_comentariosBitacoraSeguimientoProyectos(idFormulario,idReferencia,tipoComentario,fecha,comentario,idResponsable,periodo)
				VALUES(".$obj->idFormulario.",".$obj->idProyecto.",".$obj->tipoBitacora.",'".date("Y-m-d H:i:s")."','".cv($obj->resultado)."',".$_SESSION["idUsr"].",".$obj->periodo.")"	;
		eC($consulta);
	}
	
	function obtenerComentariosBitacoraProyecto()
	{
		global $con;
		$numReg=0;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=$_POST["idFormulario"];
		$periodo=$_POST["periodo"];
		$consulta="";
		$arrRegistros="";
		
		$consulta="SELECT fecha,comentario AS reporte,tipoComentario,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.idResponsable) AS responsable 
					FROM 1042_comentariosBitacoraSeguimientoProyectos t WHERE idFormulario=".$idFormulario." and idReferencia=".$idProyecto." AND periodo=".$periodo." ORDER BY fecha desc";
			
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		$numReg=$con->filasAfectadas;
		
		
		echo '{"numReg":"'.$numReg.'","registros":'.($arrRegistros).'}';
		
	}
	
	function registrarEvaluacionEtapa2()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$resultado=50;
		foreach($obj->arrRespuestas as $r)
		{
			$resultado+=$r->ponderacion;
		}

		$consulta="SELECT idRegistro FROM 1043_evaluacionProyectos2da2014Etapa2 WHERE idProyecto=".$obj->idRegistro;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$query[$x]="INSERT INTO 1043_evaluacionProyectos2da2014Etapa2(idProyecto,idResponsable,resultado,comentarios,fechaDictamen)
						VALUES(".$obj->idRegistro.",".$_SESSION["idUsr"].",".$resultado.",'".cv($obj->comentariosAdicionales)."','".date("Y-m-d H:i:s")."')";
			$x++;
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]="set @idRegistro:=".$idRegistro;
			$x++;
			$query[$x]="UPDATE 1043_evaluacionProyectos2da2014Etapa2 SET idResponsable=".$_SESSION["idUsr"].",resultado=".
						$resultado.",comentarios='".cv($obj->comentariosAdicionales)."', fechaDictamen='".date("Y-m-d H:i:s")."' WHERE idRegistro=@idRegistro";
			$x++;
			$query[$x]="delete from 1044_respuestascuestionarioEvaluacionEtapa2 where idRegistro=".$idRegistro;
			$x++;
		}
		foreach($obj->arrRespuestas as $r)
		{
			$query[$x]="INSERT INTO 1044_respuestascuestionarioEvaluacionEtapa2(idRegistro,idPregunta,valorRespuesta,tipoRespuesta,comentarios,ponderacion,idProyecto)
						VALUES(@idRegistro,".$r->idPregunta.",".$r->valor.",".$r->tipoRespuesta.",'".cv($r->comentarios)."',".$r->ponderacion.",".$obj->idRegistro.")";
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	
	function marcarProyectoFinanciable()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];	
		$comentarios=$_POST["comentarios"];
		$consulta="UPDATE _464_tablaDinamica SET marcaAutorizado=1,comentariosMarca='".cv($comentarios)."' WHERE id__464_tablaDinamica=".$idProyecto;
		eC($consulta);
	}
	
	function actualizarDetallecomprobante()
	{
		global $con;
		$idComprobante=$_POST["idComprobante"];
		
		$detalle=$_POST["detalle"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 101_comprobantesPresupuestales SET validacionSAT=5,situacion=0, comentariosEnvio='".cv($detalle)."'  WHERE idFactura=".$idComprobante;
		$x++;
		$consulta[$x]="commit";
		$x++;	
		eB($consulta);
	}
	
	function obtenerPoblacionesBlancoProyectos2014()
	{
		global $con;
		
		$filtro=$_POST["filtro"];
		$estados=$_POST["estados"];
		$proyectosNacionales=$_POST["proyectosNacionales"];
		$comp="and p.idReferencia in (select id__448_tablaDinamica from _448_tablaDinamica t where t.marcaAutorizado=1)";
		
		
		if($filtro==2)
		{
			if($estados!="0")	
			{
				if($proyectosNacionales==1)
					$comp=" and (p.idReferencia in (SELECT DISTINCT g.idReferencia FROM _448_gridAmbitoEjecucion g,_448_tablaDinamica t WHERE t.id__448_tablaDinamica=g.idReferencia and t.marcaAutorizado=1 and estado IN (".$estados."))
							or (p.idReferencia in(select id__448_tablaDinamica from _448_tablaDinamica t where t.marcaAutorizado=1 and ambitoAplicacion=3)))";	
				else
					$comp=" and p.idReferencia in (SELECT DISTINCT g.idReferencia FROM _448_gridAmbitoEjecucion g,_448_tablaDinamica t WHERE t.id__448_tablaDinamica=g.idReferencia and t.marcaAutorizado=1 and estado IN (".$estados."))";	
			}
		}
		
		$consulta="SELECT DISTINCT idPoblacionBlanco,txtclave,txtReferencia FROM 112_poblacionBlancoProyectos2014 p,_261_tablaDinamica t WHERE idFormulario=448 AND (beneficiariosDirectos>0 OR beneficiariosIndirectos>0)
					AND t.id__261_tablaDinamica=p.idPoblacionBlanco ".$comp." ORDER BY txtReferencia";

		$registros="";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"icon":"../images/s.gif","id":"'.$fila[0].'","text":"<span title=\'['.$fila[1].'] '.cv($fila[2]).'\'>['.$fila[1].'] '.$fila[2].'</span>","checked":false,leaf:true}';
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
				
		}
		
		echo '['.$registros.']';
	}
	
	function obtenerEstadosProyectos2014()
	{
		global $con;
		$filtro=$_POST["filtro"];
		$poblacion=$_POST["poblacion"];
		
		$comp="1=1";
		
		
		/*$comp=" cveEstado in 
						(
							SELECT DISTINCT g.estado FROM _448_tablaDinamica t,_448_gridAmbitoEjecucion g WHERE 
							t.marcaAutorizado=1  and g.idReferencia=t.id__448_tablaDinamica
						)";*/
		
		if($filtro==1)
		{
			if($poblacion!="0")	
			{
				$comp="  cveEstado in 
						(
							SELECT DISTINCT g.estado FROM 112_poblacionBlancoProyectos2014 p,_448_tablaDinamica t,_448_gridAmbitoEjecucion g WHERE idFormulario=448 AND p.idReferencia=t.id__448_tablaDinamica 
							AND t.marcaAutorizado=1  AND (beneficiariosDirectos>0 or beneficiariosIndirectos>0)
							AND p.idPoblacionBlanco IN (".$poblacion.") AND g.idReferencia=t.id__448_tablaDinamica
						)";	
			}
		}
		
		
		
		$consulta="SELECT cveEstado,estado FROM 820_estados where ".$comp." ORDER BY estado";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
			
	}
	
	
	function obtenerPoblacionesBlancoOSC()
	{
		global $con;
		
		$filtro=$_POST["filtro"];
		$estados=$_POST["estados"];
		$proyectosNacionales=$_POST["proyectosNacionales"];
		$tProyecto=$_POST["tipoProyectos"];
		$arrPoblacion=array();
		$comp="";
		$listPoblaciones="";
		
		
		if($estados=="0")
		{
			$consulta="SELECT cveEstado FROM 820_estados";
			$estados=$con->obtenerListaValores($consulta,"'");
		}
		
		
		
				
		//2011
		$consulta="SELECT distinct idOpcion FROM _295_problacionSel p,_295_tablaDinamica tp,_293_tablaDinamica t,_301_tablaDinamica es WHERE p.idPadre=tp.id__295_tablaDinamica 
					AND tp.idReferencia=t.id__293_tablaDinamica AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado NOT IN (1,11)
					and es.idReferencia=t.id__293_tablaDinamica and es.cmbEntidad in (".$estados.")";
		$rProblacion=$con->obtenerFilas($consulta);
		while($filaPoblacion=mysql_fetch_row($rProblacion))
		{
			if(!isset($arrPoblacion[$filaPoblacion[0]]))
			{
				$arrPoblacion[$filaPoblacion[0]]=1;
			}
					
		}
		
		
		if($proyectosNacionales==1)
		{
			$consulta="SELECT distinct idOpcion FROM _295_problacionSel p,_295_tablaDinamica tp,_293_tablaDinamica t WHERE p.idPadre=tp.id__295_tablaDinamica 
					AND tp.idReferencia=t.id__293_tablaDinamica AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado NOT IN (1,11) and cmbLugarNacional=1";
			$rProblacion=$con->obtenerFilas($consulta);
			while($filaPoblacion=mysql_fetch_row($rProblacion))
			{
				if(!isset($arrPoblacion[$filaPoblacion[0]]))
				{
					$arrPoblacion[$filaPoblacion[0]]=1;
				}
						
			}
		}
		
		//2012
		$consulta="SELECT p.idOpcion FROM _370_chkPoblacionBlanco p,_370_tablaDinamica t,_370_gridLugarEjecucion es WHERE p.idPadre=t.id__370_tablaDinamica
					AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1 and es.idReferencia=t.id__370_tablaDinamica and es.estado in (".$estados.")";
		$rProblacion=$con->obtenerFilas($consulta);
		while($filaPoblacion=mysql_fetch_row($rProblacion))
		{
			if(!isset($arrPoblacion[$filaPoblacion[0]]))
			{
				$arrPoblacion[$filaPoblacion[0]]=1;
			}
					
		}
			
		if($proyectosNacionales==1)
		{
			$consulta="SELECT p.idOpcion FROM _370_chkPoblacionBlanco p,_370_tablaDinamica t WHERE p.idPadre=t.id__370_tablaDinamica
					AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1  and ambitoAplicacion=3";
			$rProblacion=$con->obtenerFilas($consulta);
			while($filaPoblacion=mysql_fetch_row($rProblacion))
			{
				if(!isset($arrPoblacion[$filaPoblacion[0]]))
				{
					$arrPoblacion[$filaPoblacion[0]]=1;
				}
						
			}
		}	
					
		//2013
		$consulta="SELECT distinct p.idPoblacion FROM 110_poblacionBancoProyectos p,_410_tablaDinamica t,_410_gridAmbitoEjecucion es WHERE p.idFormulario=410 and p.idReferencia=t.id__410_tablaDinamica
					and valor>0 AND  t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1
					and es.idReferencia=t.id__410_tablaDinamica and es.estado in (".$estados.")";
		$rProblacion=$con->obtenerFilas($consulta);
		while($filaPoblacion=mysql_fetch_row($rProblacion))
		{
			if(!isset($arrPoblacion[$filaPoblacion[0]]))
			{
				$arrPoblacion[$filaPoblacion[0]]=1;
			}
				
					
		}
		
		if($proyectosNacionales==1)
		{
			$consulta="SELECT distinct p.idPoblacion FROM 110_poblacionBancoProyectos p,_410_tablaDinamica t WHERE p.idFormulario=410 and p.idReferencia=t.id__410_tablaDinamica
					and valor>0 AND  t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1 and ambitoAplicacion=3	";
			$rProblacion=$con->obtenerFilas($consulta);
			while($filaPoblacion=mysql_fetch_row($rProblacion))
			{
				if(!isset($arrPoblacion[$filaPoblacion[0]]))
				{
					$arrPoblacion[$filaPoblacion[0]]=1;
				}
						
			}
		}
		
		//2014
		$consulta="SELECT distinct p.idPoblacionBlanco FROM 112_poblacionBlancoProyectos2014 p,_448_tablaDinamica t,_448_gridAmbitoEjecucion es WHERE p.idFormulario=448 and p.idReferencia=t.id__448_tablaDinamica
					and (beneficiariosDirectos>0 or beneficiariosIndirectos>0)  AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1
					and es.idReferencia=t.id__448_tablaDinamica and es.estado in (".$estados.")";
		$rProblacion=$con->obtenerFilas($consulta);
		while($filaPoblacion=mysql_fetch_row($rProblacion))
		{
			if(!isset($arrPoblacion[$filaPoblacion[0]]))
			{
				$arrPoblacion[$filaPoblacion[0]]=1;
			}
				
					
		}
		
		if($proyectosNacionales==1)
		{
			$consulta="SELECT distinct p.idPoblacionBlanco FROM 112_poblacionBlancoProyectos2014 p,_448_tablaDinamica t WHERE p.idFormulario=448 and p.idReferencia=t.id__448_tablaDinamica
					and (beneficiariosDirectos>0 or beneficiariosIndirectos>0)  AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado >1	and ambitoAplicacion=3";
			$rProblacion=$con->obtenerFilas($consulta);
			while($filaPoblacion=mysql_fetch_row($rProblacion))
			{
				if(!isset($arrPoblacion[$filaPoblacion[0]]))
				{
					$arrPoblacion[$filaPoblacion[0]]=1;
				}
						
			}
		}
		
		foreach($arrPoblacion as $idPoblacion=>$valor)
		{
			if($listPoblaciones=="")	
				$listPoblaciones=$idPoblacion;
			else
				$listPoblaciones.=",".$idPoblacion;
		}
		
		if($listPoblaciones=="")
			$listPoblaciones=-1;
		
		
		$consulta="SELECT DISTINCT id__261_tablaDinamica,txtclave,txtReferencia FROM _261_tablaDinamica t WHERE t.id__261_tablaDinamica in (".$listPoblaciones.") order by txtReferencia";


		$registros="";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"icon":"../images/s.gif","id":"'.$fila[0].'","text":"<span title=\'['.$fila[1].'] '.cv($fila[2]).'\'>['.$fila[1].'] '.$fila[2].'</span>","checked":false,leaf:true}';
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
				
		}
		
		echo '['.$registros.']';
	}
	
	function obtenerEstadosOSC()
	{
		global $con;
		$filtro=$_POST["filtro"];
		$poblacion=$_POST["poblacion"];
		$tProyecto=$_POST["tipoProyectos"];
		
		$arrEstadoProyectos=array();
		
		$comp="1=1";
		
		
		if($filtro==1)
		{
			if($poblacion!="0")	
			{
				//2011
				$consulta="SELECT DISTINCT cmbEntidad FROM _301_tablaDinamica a,_293_tablaDinamica t,_295_tablaDinamica fp,_295_problacionSel ps WHERE 
						a.idReferencia=t.id__293_tablaDinamica AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado NOT IN (1,11) and ps.idPadre=fp.id__295_tablaDinamica 
						and fp.idReferencia=id__293_tablaDinamica and ps.idOpcion in (".$poblacion.")";
				$rEstado=$con->obtenerFilas($consulta);
				while($fEstado=mysql_fetch_row($rEstado))
				{
					$arrEstadoProyectos[$fEstado[0]]=1;
				}
				
				//2012
				$consulta="SELECT DISTINCT a.estado FROM _370_gridLugarEjecucion a,_370_tablaDinamica t,_370_chkPoblacionBlanco p WHERE 
							a.idReferencia=t.id__370_tablaDinamica AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado>1 and 
							p.idPadre=t.id__370_tablaDinamica and p.idOpcion in (".$poblacion.")";
				$rEstado=$con->obtenerFilas($consulta);
				while($fEstado=mysql_fetch_row($rEstado))
				{
					$arrEstadoProyectos[$fEstado[0]]=1;
				}
				
				//2013
				$consulta="SELECT DISTINCT a.estado FROM _410_gridAmbitoEjecucion a,_410_tablaDinamica t,110_poblacionBancoProyectos p WHERE 
							 a.idReferencia=t.id__410_tablaDinamica AND t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado>1 and p.idFormulario=410 and
							p.idReferencia=t.id__410_tablaDinamica and p.idPoblacion in (".$poblacion.") and valor>0";
				$rEstado=$con->obtenerFilas($consulta);
				while($fEstado=mysql_fetch_row($rEstado))
				{
					$arrEstadoProyectos[$fEstado[0]]=1;
				}
			
				//2014
				$consulta="SELECT DISTINCT a.estado FROM _448_gridAmbitoEjecucion a,_448_tablaDinamica t,112_poblacionBlancoProyectos2014 p WHERE 
							a.idReferencia=t.id__448_tablaDinamica AND  t.marcaAutorizado IN (".$tProyecto.") AND t.idEstado>1 and p.idFormulario=448 and
							p.idReferencia=t.id__448_tablaDinamica and p.idPoblacionBlanco in (".$poblacion.") and (p.beneficiariosDirectos>0 or p.beneficiariosIndirectos>0)";
				$rEstado=$con->obtenerFilas($consulta);
				while($fEstado=mysql_fetch_row($rEstado))
				{
					$arrEstadoProyectos[$fEstado[0]]=1;
				}
				
			
			
				
				foreach($arrEstadoProyectos as $e=>$valor)
				{
					if($listaEstados=="")
						$listaEstados="'".$e."'";
					else
						$listaEstados.=",'".$e."'";
				}
				
				if($listaEstados=="")
					$listaEstados=-1;
					
				$comp="  cveEstado in 
						(
							".$listaEstados."
						)";	
			}
		}
		
		
		
		$consulta="SELECT cveEstado,estado FROM 820_estados where ".$comp." ORDER BY estado";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
			
	}
	
	function obtenerRequisitosParticipacion()
	{
		global $con;	
		$idConvocatoria=$_POST["iC"];
		$arrRegistros="";
		$consulta="SELECT g.id__465_gridFunciones as idRequisito,g.descripcion as requisito,g.descripcionDetalle as descripcion,g.funcion,g.funcionAccion,g.obligatorio 
					FROM 
				_465_tablaDinamica t,_465_gridFunciones g WHERE g.idReferencia=t.id__465_tablaDinamica AND t.idReferencia=".$idConvocatoria." and g.aplicableARegistro=1 ORDER BY id__465_gridFunciones";

	
		$numReg=0;
		$cache=NULL;	
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$cadObj='{"idUsuario":"'.$_SESSION["idUsr"].'","idRequisito":"'.$fila[0].'","idConvocatoria":"'.$idConvocatoria.'"}';
			$objReg=json_decode($cadObj);
			$arrResultado=resolverExpresionCalculoPHP($fila[3],$objReg,$cache);
			$o='{"idRequisito":"'.$fila[0].'","obligatorio":"'.(($fila[5]==1)?"1":"0").'","requisito":"'.(($fila[5]==1)?"<span style='color:#F00'>*</span> ":"").cv($fila[1]).'","situacion":"'.$arrResultado[0].'","descripcion":"'.cv($fila[2]).
				'","comentariosAdicionales":"'.cv($arrResultado[1]).'","funcionClick":"'.$arrResultado[2].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	
	}
	
	function obtenerLineasAccionProyecto()
	{
		global $con;
		
		
		$arrRegistros="";
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$sL=$_POST["sL"];
		
		$consulta="SELECT idSubcategoria FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idReferencia;
		$idSubcategoria=$con->obtenerValor($consulta);
		$consulta="SELECT DISTINCT l.estrategia,e.txtEstrategia,e.txtDescripcion FROM _500_tablaDinamica l,
					_488_tablaDinamica e WHERE l.idReferencia=".$idSubcategoria." AND e.id__488_tablaDinamica=l.estrategia  ORDER BY e.txtEstrategia";
		$resEstrategia=$con->obtenerFilas($consulta);
		while($fEstrategia=mysql_fetch_row($resEstrategia))
		{
			$arrLineasAccion="";
			$consulta="SELECT l.id__500_tablaDinamica,l.lineaAccion,li.txtLinea,li.txtDescripcion FROM _500_tablaDinamica l,
					_489_tablaDinamica li WHERE l.idReferencia=".$idSubcategoria." AND l.estrategia=".$fEstrategia[0]." and li.id__489_tablaDinamica=l.lineaAccion ORDER BY li.txtLinea";
			$resLineas=$con->obtenerFilas($consulta);
			
			while($fLinea=mysql_fetch_row($resLineas))
			{
				
				$arrIntervenciones="";
				$consulta="SELECT i.id__489_gridSublineas,i.sublinea,i.descripcion FROM _500_subLineasAccion s,_489_gridSublineas i 
						WHERE s.idPadre=".$fLinea[0]." AND s.idOpcion=i.id__489_gridSublineas ORDER BY i.sublinea";
				$resIntervenciones=$con->obtenerFilas($consulta);
			
				while($fIntervenciones=mysql_fetch_row($resIntervenciones))
				{		
				
					$consulta="SELECT COUNT(*) FROM 115_definicionIntervenciones WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idEstrategia=".$fEstrategia[0].
							" AND idLineaAccion=".$fLinea[1]." AND idIntervencion=".$fIntervenciones[0];
					$nReg=$con->obtenerValor($consulta);
				
					$comp="";
					
					if(($sL==0)||($nReg>0))
					{
						if($sL==0)
						{
							$comp="<input onclick='checkBoxClick(this,event)' type='checkbox' ".(($nReg>0)?"checked=checked":"")." name='chkIntervenciones' id='chk_".$fEstrategia[0].'_'.$fLinea[1].'_'.$fIntervenciones[0]."'>&nbsp;";
						}
						$o='{"icon":"../images/s.gif","expanded":true,"text":"'.$comp.'<b>Intervenci&oacute;n:</b> <span title=\"'.cv($fIntervenciones[2]).'\" alt=\"'.cv($fIntervenciones[2]).'\">'.cv($fIntervenciones[1]).'</span>","id":"3_'.$fEstrategia[0].'_'.$fLinea[1].'_'.$fIntervenciones[0].'",leaf:true}';
						if($arrIntervenciones=="")
							$arrIntervenciones=$o;
						else
							$arrIntervenciones.=",".$o;
					}
				}
				
				$o='{"icon":"../images/s.gif","expanded":true,"text":"<span style=\'color:#900\'><b>L&iacute;nea de acci&oacute;n:</b></span> <span title=\"'.cv($fLinea[3]).'\" alt=\"'.cv($fLinea[3]).'\">'.cv($fLinea[2]).'</span>","id":"2_'.$fEstrategia[0].'_'.$fLinea[1].'",leaf:false,children:['.$arrIntervenciones.']}';
				if($arrLineasAccion=="")
					$arrLineasAccion=$o;
				else
					$arrLineasAccion.=",".$o;
			}
			
			$o='{"icon":"../images/s.gif","expanded":true,"text":"<b>Estrategia:</b> <span title=\"'.cv($fEstrategia[2]).'\" alt=\"'.cv($fEstrategia[2]).'\">'.cv($fEstrategia[1]).'</span>","id":"1_'.$fEstrategia[0].'",leaf:false,children:['.$arrLineasAccion.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		
		
		echo "[".$arrRegistros."]";
	}
	
	function guardarIntervencionesProyectos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="DELETE FROM 115_definicionIntervenciones WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$x++;
		
		
		foreach($obj->registros as $o)
		{
			$query[$x]="INSERT INTO 115_definicionIntervenciones(idFormulario,idReferencia,idEstrategia,idLineaAccion,idIntervencion) 
						VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$o->idEntrategia.",".$o->idLinea.",".$o->idIntervencion.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
	}
	
	function obtenerIntervencionesProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$arrRegistros="";
		
		$consulta="SELECT idSubcategoria FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idReferencia;
		$idSubcategoria=$con->obtenerValor($consulta);
		
		$consulta="SELECT DISTINCT id__489_gridSublineas,sublinea  FROM 115_definicionIntervenciones d,_489_gridSublineas i WHERE d.idFormulario=".$idFormulario." AND d.idReferencia=".$idReferencia."
					AND i.id__489_gridSublineas=d.idIntervencion ORDER BY i.sublinea";
		
		$consulta="SELECT id__489_gridSublineas,sublinea,afectaPoblacionBlanco FROM _500_tablaDinamica t,_500_subLineasAccion s,_489_gridSublineas i 
					WHERE t.idReferencia=".$idSubcategoria." AND s.idPadre=t.id__500_tablaDinamica AND i.id__489_gridSublineas=s.idOpcion ORDER BY sublinea";
			
					
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))	
		{
			/*$consulta="SELECT a.id__503_tablaDinamica,a.txtActividades FROM _504_tablaDinamica t,_504_gridActividades g,_503_tablaDinamica a WHERE t.idReferencia=".$idSubcategoria.
						" AND t.intervencion=".$fila[0]." AND g.idreferencia=t.id__504_tablaDinamica
						AND a.id__503_tablaDinamica=g.idActividad ORDER BY a.txtActividades";*/
						
			$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo "1|[".$arrRegistros."]";
		
	}
	
	function guardarActividadCronogramaIntervencion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		
		
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 965_actividadesUsuario(actividad,idUsuario,idFormulario,idReferencia,descripcion,idPadre,idMeta) 
							VALUES ('".cv($obj->descripcion)."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idReferencia.",'".$obj->idIntervencion."',".$obj->idPadre.",".$obj->idActividad.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";;
			$x++;
		}
		else
		{
			$consulta[$x]="update 965_actividadesUsuario set actividad='".cv($obj->descripcion)."',descripcion='".$obj->idIntervencion."',idMeta=".$obj->idActividad." where idActividadPrograma=".$obj->idRegistro;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idActividad;
			$x++;
		}
		$consulta[$x]="delete from 968_planeacionActividadesMeses where idActividad=@idRegistro";
		$x++;
		foreach($obj->arrMeses as $mes)
		{
			$consulta[$x]="INSERT INTO 968_planeacionActividadesMeses(idActividad,mes,valor)
							VALUES(@idRegistro,".$mes->mes.",'".$mes->valor."')";
			$x++;							
		}
		
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function obtenerActividadesCronogramaIntervencion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		$mesIni=$_POST["mesIni"];
		$mesFin=$_POST["mesFin"];
		$consulta="SELECT idActividadPrograma,actividad,descripcion,idMeta FROM 965_actividadesUsuario WHERE idFormulario=".$idFormulario." AND 
					idReferencia=".$idReferencia." and idPadre=-1 order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		

		
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x."";
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$hijos="";
			$cadHijos=obtenerActividadesHijosIntervencion($fila[0],$mesIni,$mesFin);

			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			$descripcion="";
			$consulta="SELECT sublinea FROM _489_gridSublineas WHERE id__489_gridSublineas=".$fila[2];
			$descripcion=cv($con->obtenerValor($consulta));
			
			$consulta="SELECT txtActividades FROM _503_tablaDinamica WHERE id__503_tablaDinamica=".$fila[3];
			$descripcion.=" / ".cv($con->obtenerValor($consulta));
			
			
			$obj='{"idIntervencion":"'.$fila[2].'","descripcion":"'.cv($descripcion).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","idActividad":"'.$fila[3].'"'.$comp.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		echo "[".$cadActividades."]";
	}

	function obtenerActividadesHijosIntervencion($idActividad,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion,idMeta FROM 965_actividadesUsuario WHERE idPadre=".$idActividad. " order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		while($fila=mysql_fetch_row($res))
		{
			
			
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x; 
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="false";
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			$cadHijos=obtenerActividadesHijosIntervencion($fila[0],$mesIni,$mesFin);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			$descripcion="";
			$consulta="SELECT sublinea FROM _489_gridSublineas WHERE id__489_gridSublineas=".$fila[2];
			$descripcion=cv($con->obtenerValor($consulta));
			
			$consulta="SELECT txtActividades FROM _503_tablaDinamica WHERE id__503_tablaDinamica=".$fila[3];
			$descripcion.=" / ".cv($con->obtenerValor($consulta));
			
			$obj='{"idIntervencion":"'.$fila[2].'","descripcion":"'.cv($descripcion).'","icon":"../images/s.gif","id":"'.$fila[0].'","actividad":"'.cv($fila[1]).'","idActividad":"'.$fila[3].'"'.$comp.$hijos.'}';
			
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return $cadActividades;
	}
	
	function obtenerPoblacionesZonasProyecto()
	{
		global $con;
		
		
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idRegistro"];
		
		$consulta="SELECT ambitoAplicacion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idReferencia;
		$ambito=$con->obtenerValor($consulta);
		
		
		$arrRegistros="";
		$consulta="SELECT id__".$idFormulario."_gridPoblacionBlanco,idPoblacionDesigualdad,p.id__487_tablaDinamica,p.txtPoblacionBlanco FROM _".$idFormulario."_gridPoblacionBlanco g,_487_tablaDinamica p 
					WHERE g.idReferencia=".$idReferencia." AND p.id__487_tablaDinamica=g.idPoblacionBlanco";
					
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			if($fila[1]!=0)
			{
				$consulta="select txtPoblacionBlanco from _487_tablaDinamica where id__487_tablaDinamica=".$fila[1];
				$comp=$con->obtenerValor($consulta)." / ";
			}
			
			$arrEstados="";
			
			
			
			if($ambito==3)
			{
				$consulta="SELECT distinct e.cveEstado,upper(e.estado) FROM 820_estados e ORDER BY e.estado";
			}
			else
			{
				//$consulta="SELECT distinct g.estado,upper(e.estado) FROM _".$idFormulario."_gridAmbitoEjecucion g,820_estados e WHERE g.idReferencia=".$idReferencia." AND e.cveEstado=g.estado ORDER BY e.estado";
				$consulta="SELECT g.estado,upper(e.estado),g.municipio,g.lblMunicipio FROM _492_gridAmbitoEjecucion g,820_estados e WHERE g.idReferencia=".$idReferencia." AND e.cveEstado=g.estado ORDER BY e.estado,g.lblMunicipio";
				$resEstados=$con->obtenerFilas($consulta);
			}
			$resEstados=$con->obtenerFilas($consulta);
			while($fEstado=mysql_fetch_row($resEstados))
			{
				$compMpios="";
				/*if($ambito!=3)
				{
					$arrMpios="";
					$consulta="SELECT g.municipio,g.lblMunicipio FROM _492_gridAmbitoEjecucion g where g.idReferencia=".$idReferencia." AND g.estado='".$fEstado[0]."' ORDER BY g.lblMunicipio";
					
					$resMpios=$con->obtenerFilas($consulta);
					while($fMpio=mysql_fetch_row($resMpios))
					{
						$o='{"ambito":"'.$ambito.'","icon":"../images/Icono_html.gif",id:"m_'.$fila[0].'_'.$fEstado[0].'_'.$fMpio[0].'","text":"'.cv($fMpio[1]).'","estado":"'.$fEstado[0].
							'","municipio":"'.$fMpio[0].'","idPoblacionBlanco":"'.$fila[2].'","idPoblacionDesigualdad":"'.$fila[1].'","leaf":true}';
						if($arrMpios=="")
							$arrMpios=$o;
						else
							$arrMpios.=",".$o;
					}
					$compMpios=',"children":['.$arrMpios.']';
					
				}*/
				
				/*$o='{"ambito":"'.$ambito.'","icon":"../images/Icono_html.gif",id:"e_'.$fila[0].'_'.$fEstado[0].'","text":"'.cv($fEstado[1]).'","estado":"'.$fEstado[0].
					'","idPoblacionBlanco":"'.$fEstado[2].'",'.(($ambito==3)?'"leaf":true':'"leaf":false').$compMpios.'}';*/
					
				$o='{"ambito":"'.$ambito.'","icon":"../images/Icono_html.gif",id:"e_'.$fila[0].'_'.$fEstado[0].'_'.$fEstado[2].'","text":"'.cv($fEstado[1]." / ".$fEstado[3]).'","estado":"'.$fEstado[0].
					'","municipio":"'.$fEstado[2].'","idPoblacionBlanco":"'.$fila[2].'","idPoblacionDesigualdad":"'.$fila[1].'","leaf":true}';	
					
				if($arrEstados=="")
					$arrEstados=$o;
				else
					$arrEstados.=",".$o;
			}
			
			
			$o='{"icon":"../images/users.png",id:"p_'.$fila[0].'","text":"'.cv($comp).cv($fila[3]).'","idPoblacionDesigualdad":"'.$fila[1].'","idPoblacionBlanco":"'.$fila[2].'",leaf:false,children:['.$arrEstados.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
					
		echo "[".$arrRegistros."]";
		
	}
	
	
	function obteneAlcancePoblacionZonaRangoProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idPoblacionDesigualdad=$_POST["idPoblacionDesigualdad"];
		$idPoblacionBlanco=$_POST["idPoblacionBlanco"];
		$idEstado=$_POST["idEstado"];
		$idMunicipio=$_POST["idMunicipio"];
		
		
		$consulta="SELECT idRegistro,tipoPoblacion,cantidad as total,edadInicial as rangoDe,edadFinal as rangoHasta FROM 116_alcancePoblacionZonaRangoProyecto WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." 
				AND idPoblacionDesigualdad=".$idPoblacionDesigualdad." AND idPoblacionBlanco=".$idPoblacionBlanco." AND estado='".$idEstado."' AND municipio='".$idMunicipio."' order by tipoPoblacion";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function registrarAlcancePoblacionZonaRangoProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 116_alcancePoblacionZonaRangoProyecto(idFormulario,idReferencia,idPoblacionDesigualdad,idPoblacionBlanco,estado,municipio,tipoPoblacion,cantidad,edadInicial,edadFinal)
					VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$obj->idPoblacionDesigualdad.",".$obj->idPoblacionBlanco.",'".$obj->estado.
					"','".$obj->municipio."',".$obj->tipoPoblacion.",".$obj->total.",".$obj->rangoDe.",".$obj->rangoHasta.")";
		}
		else
		{
			$consulta="update 116_alcancePoblacionZonaRangoProyecto set tipoPoblacion=".$obj->tipoPoblacion.",cantidad=".$obj->total.",edadInicial=".$obj->rangoDe.",edadFinal=".$obj->rangoHasta." where idRegistro=".$obj->idRegistro;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idRegistro==-1)
			{
				$obj->idRegistro=$con->obtenerUltimoID();
			}
			echo "1|".$obj->idRegistro;
		}
	}
	
	function removerAlcancePoblacionZonaRangoProyecto()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$consulta="delete from  116_alcancePoblacionZonaRangoProyecto where idRegistro=".$idRegistro;
		eC($consulta);
		
	}
	
	function obtenerIndicadoresProyectosDisponibles2015()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idReferencia,idCategoria from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		$idConfiguracion=$fRegistro[0];
		$idCategoria=$fRegistro[1];

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT idIndicador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listIndicadoresReg=$con->obtenerListaValores($consulta);
//		if($listIndicadoresReg=="")
			$listIndicadoresReg=-1;
			
			
		$listIndicadoresCategoria="";
		$consulta="SELECT gi.indicador ,i.nombreIndicador,'1' as tipoIndicador,descripcion from _414_indicadoresCategoria gi,_375_tablaDinamica i 
					where gi.idReferencia=".$fDatos[0]." and i.id__375_tablaDinamica=gi.indicador
					and gi.indicador not in (".$listIndicadoresReg.")";
		$res=$con->obtenerFilas($consulta);
		$nReg=0;
		
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","tipoIndicador":"'.$fila[2].'","descripcion":"'.$fila[3].'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$nReg++;
			
			if($listIndicadoresCategoria=="")
				$listIndicadoresCategoria=$fila[0];
			else
				$listIndicadoresCategoria.=",".$fila[0];
			
		}
		if($listIndicadoresCategoria=="")
			$listIndicadoresCategoria=-1;
		
		
		$consulta="SELECT i.id__375_tablaDinamica ,i.nombreIndicador,'3' as tipoIndicador,descripcion from _375_tablaDinamica i where idFormularioBase=".$idFormulario." and idReferenciaBase=".$idRegistro."
					AND i.id__375_tablaDinamica NOT IN (".$listIndicadoresReg.")";

		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idIndicador":"'.$fila[0].'","nombreIndicador":"'.cv($fila[1]).'","tipoIndicador":"'.$fila[2].'","descripcion":"'.$fila[3].'"}';	
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$nReg++;
		}
		
		
		
		
		echo '{"numReg":"'.$nReg.'","registros":['.$registros.']}';
		
	}
	
	function obtenerIndicadoresProyectos2015()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idConfiguracion=$con->obtenerValor($consulta);

		$consulta="SELECT campoCategoria,campoSubcategoria,campoTema,campoTituloProyecto,calculoPresupuestoSolicitado,
				calculoPresupuestoAutorizado FROM _428_tablaDinamica WHERE idReferencia=".$idConfiguracion;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		
		$consulta="select ".$fConfiguracion[0].",".$fConfiguracion[1].",".$fConfiguracion[2]." from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		
	/*	*/
		
		$consulta="SELECT idIndicador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listIndicadores=$con->obtenerListaValores($consulta);
		if($listIndicadores=="")
			$listIndicadores=-1;
		$consulta="SELECT t.id__375_tablaDinamica,nombreIndicador,nombreIndicador as numerador,'' as denominador,
				(select tipoIndicador from _431_tablaDinamica ti where ti.id__431_tablaDinamica=t.tipoIndicador), descripcion,t.tipoIndicador FROM _375_tablaDinamica t
				where t.id__375_tablaDinamica in (".$listIndicadores.") order by nombreIndicador";
		$res=$con->obtenerFilas($consulta);
		$cadIndicadores="";
		$total=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT numerador,denominador FROM 109_indicadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idIndicador=".$fila[0];
			$fIndicador=$con->obtenerPrimeraFila($consulta);
			if($fIndicador)
			{
				if($fIndicador[0]=="")
					$fIndicador[0]=0;
				if($fIndicador[1]=="")
					$fIndicador[1]=0;
			}
			else
			{
				$fIndicador[0]=0;
				$fIndicador[1]=0;
			}
				
			
			$obj='{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"1","nombreUnidad":"'.cv($fila[2]).'","cantidad":"'.$fIndicador[0].
					'","descripcion":"'.cv($fila[5]).'","tipoIndicador":"'.$fila[6].'"}';
			if($fila[3]!="")
			{
				$obj.=',{"idIndicador":"'.$fila[0].'","nombreIndicador":"(<b>Tipo:</b> <i>'.cv($fila[4]).'</i>) '.cv($fila[1]).'","tipoUnidad":"2","nombreUnidad":"'.cv($fila[3]).'","cantidad":"'.$fIndicador[1].
						'","descripcion":"'.cv($fila[5]).'","tipoIndicador":"'.$fila[6].'"}';
				$total++;
			}
			
			if($cadIndicadores=="")
				$cadIndicadores=$obj;
			else
				$cadIndicadores.=",".$obj;
			$total++;
		}
		
		echo '{"numReg":"'.$total.'","registros":['.$cadIndicadores.']}';
		
	}
	
	function registrarIndicador2015()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		$x=0;
		$query[$x]="begin";
		$x++;
		if($obj->idIndicador==-1)
		{
			$query[$x]="INSERT INTO _375_tablaDinamica(nombreIndicador,tipoIndicador,idFormularioBase,idReferenciaBase,descripcion)
					VALUES ('".cv($obj->indicador)."',13,".$obj->idFormulario.",".$obj->idReferencia.",'".cv($obj->descripcion)."')";
			$x++;		
			$query[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$query[$x]="INSERT INTO 109_indicadoresProyectos(idIndicador,numerador,denominador,idFormulario,idReferencia)
						 VALUES(@idRegistro,0,0,".$obj->idFormulario.",".$obj->idReferencia.")";
			$x++;
		}
		else
		{
			$query[$x]="update _375_tablaDinamica set nombreIndicador='".cv($obj->indicador)."',descripcion='".cv($obj->descripcion)."' where id__375_tablaDinamica=".$obj->idIndicador;
			$x++;
		}
		
		
		
		$query[$x]="commit";
		$x++;

		if($con->ejecutarBloque($query))
		{
			if($obj->idIndicador==-1)
			{
				$consulta="select last_insert_id()";
				$obj->idIndicador=$con->obtenerValor($consulta);
			}
			
			echo "1|".$obj->idIndicador;
		}
		
		
			
	}
	
	function guardarActividadCronograma2015()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idMeta=-1;
		if(isset($obj->idMeta))
			$idMeta=$obj->idMeta;
		
		$idIntervencion="NULL";
		
		
		
		if(isset($obj->idIntervencion))
			$idIntervencion=$obj->idIntervencion;
			
			
		
		if($obj->idActividad==-1)
		{
			$consulta[$x]="INSERT INTO 965_actividadesUsuario(actividad,idUsuario,idFormulario,idReferencia,descripcion,idPadre,idMeta,idIntervencion,actividadIntervencion,otraIntervencion) 
							VALUES ('".cv($obj->actividad)."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idRegistro.",'',".$obj->idPadre.",".$idMeta.
							",".$idIntervencion.",NULL,'".cv($obj->especifiqueOtra)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 965_actividadesUsuario set otraIntervencion='".cv($obj->especifiqueOtra)."',idIntervencion=".$idIntervencion.",actividad='".cv($obj->actividad)."',descripcion='' where idActividadPrograma=".$obj->idActividad;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idActividad;
			$x++;
		}
		$consulta[$x]="delete from 968_planeacionActividadesMeses where idActividad=@idRegistro";
		$x++;
		foreach($obj->arrMeses as $mes)
		{
			$consulta[$x]="INSERT INTO 968_planeacionActividadesMeses(idActividad,mes,valor)
							VALUES(@idRegistro,".$mes->mes.",'".$mes->valor."')";
			$x++;							
		}
		$consulta[$x]="delete from 968_actividadesPoblacion where idActividad=@idRegistro";
		$x++;
		
		foreach($obj->arrPoblacion as $p)
		{
			$consulta[$x]="INSERT INTO 968_actividadesPoblacion(idActividad,idPoblacionVulnerable,idPoblacionBlanco,genero,rangoEdad,totalDirecta,totalIndirecta,idFormulario,idReferencia)
						VALUES(@idRegistro,".$p->idPoblacionVulnerable.",".$p->idPoblacionBlanco.",".$p->genero.",".$p->rangoEdad.",".$p->totalD.",".$p->totalI.",".$obj->idFormulario.",".$obj->idRegistro.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function registrarJustificacionProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$consulta="";
		$consulta="delete from 100_justificacionPresupuesto where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia;
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->justificacion!='')
			{
				$consulta="INSERT INTO 100_justificacionPresupuesto(idFormulario,idReferencia,justificacion) VALUES(".$obj->idFormulario.",".$obj->idReferencia.",'".cv($obj->justificacion)."')";
				eC($consulta);
			}
			else
				echo "1|";
		}
		

		
		
	}
	
	function obtenerDistribucionProyectosCategorias()
	{
		global $con;
		$situacion=$_POST["situacion"];
		$numReg=0;
		$registros="";
		$consulta="SELECT id__414_tablaDinamica,noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE idReferencia=4 ORDER BY noCategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT id__498_tablaDinamica FROM _498_tablaDinamica WHERE marcaAutorizado=1 and idCategoria=".$fila[0];
			$listProyectos=$con->obtenerListaValores($consulta);
			if($listProyectos=="")
				$listProyectos=-1;
				
			$nProyectos=$con->filasAfectadas;	
			$consulta="select count(*) from _498_tablaDinamica WHERE idEstado IN (2,3) AND marcaDescalificacion=0 and idCategoria=".$fila[0];	
			$totalProyectosParticipantes=$con->obtenerValor($consulta);	
				
			
			$consulta="SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia in(".$listProyectos.")";
			$montoProyecto=$con->obtenerValor($consulta);	
			$o='{"idCategoria":"'.$fila[0].'","categoria":"'.($fila[1].".- ".$fila[2]).
				'","montoSolicitado":"'.$montoProyecto.'","totalProyectos":"'.$nProyectos.
				'","totalProyectosParticipantes":"'.$totalProyectosParticipantes.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
		
	}
	
	
	function obtenerProyectosRegistrados2015()
	{
		global $con;
		$situacion=$_POST["situacion"];
		$listaCategorias=$_POST["listaCategorias"];
		$numReg=0;
		$registros="";
		
		$arrEstados=array();
		
		$consulta="SELECT cveEstado,UPPER(estado) FROM  820_estados ORDER BY estado";
		$resEstado=$con->obtenerFilas($consulta);
		while($fEstado=mysql_fetch_row($resEstado))
		{
			$arrEstados[$fEstado[0]]=0;
		}
		
		$consulta="SELECT * FROM _498_tablaDinamica WHERE marcaAutorizado=1 and idCategoria in(".$listaCategorias.") order by id__498_tablaDinamica";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=".$fila[0];
			$montoProyecto=$con->obtenerValor($consulta);
			
			$consulta="SELECT DISTINCT estado FROM _498_gridAmbitoEjecucion WHERE idReferencia=".$fila[0];
			$lEstados=$con->obtenerListaValores($consulta,"'");
			
			if($lEstados!="")
			{
				$aEstados=explode(",",$lEstados);
				foreach($aEstados as $e)
				{
					$arrEstados[str_replace("'","",$e)]++;
				}
			}
			else
				$lEstados=-1;
			$ambitoLocal=0;
			$ambitoRegional=0;
			if($con->filasAfectadas>1)
			{
				$ambitoRegional=1;
			}
			else
			{
				$ambitoLocal=1;
			}
			
			$consulta="SELECT upper(estado) FROM  820_estados WHERE cveEstado IN (".$lEstados.") order by estado";
			$cadEstados=$con->obtenerListaValores($consulta);
			$situacion="";
			if($fila[6]==1)
				$situacion="1.- En registro";
			else
				$situacion="2.- Registrado";
				
				
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[15];	
			$fCategoria=$con->obtenerPrimeraFila($consulta);	
			$categoria=$fCategoria[0].".- ".$fCategoria[1];
			
			$consulta="SELECT SUM(totalHombresD) FROM _498_gPoblacionBlancoDirecta WHERE idReferencia=".$fila[0];
			$totalHombres=$con->obtenerValor($consulta);
			if($totalHombres=="")
				$totalHombres=0;
				
			$consulta="SELECT SUM(totalMujeresD) FROM _498_gPoblacionBlancoDirecta WHERE idReferencia=".$fila[0];
			$totalMujeres=$con->obtenerValor($consulta);
			if($totalMujeres=="")
				$totalMujeres=0;	
			
			$o='{"totalHombres":"'.$totalHombres.'","totalMujeres":"'.$totalMujeres.'","categoria":"'.cv($categoria).'","situacion":"'.$situacion.'","idProyecto":"'.$fila[0].'","codigo":"'.$fila[9].
				'","montoSolicitado":"'.$montoProyecto.'","ambitoLocal":"'.$ambitoLocal.'","ambitoRegional":"'.$ambitoRegional.'","estados":"'.$cadEstados.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		$arrEstadosCantidad="";
		foreach($arrEstados as $e=>$total)
		{
			$edo="['".$e."','".$total."']";
			if($arrEstadosCantidad=="")
				$arrEstadosCantidad=$edo;
			else
				$arrEstadosCantidad.=",".$edo;
				
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.'],"estados":['.$arrEstadosCantidad.']}';
		
		
	}
	
	function obtenerOSCParticipantes2015()
	{
		
		global $con;
		$situacion=$_POST["situacion"];
		$listaCategorias=$_POST["listaCategorias"];
		$numReg=0;
		$registros="";
		$aOrganizacionesCont=array();
		$arrOrganizaciones=array();
		$consulta="SELECT o.tipoOrganizacion,o.codigoInstitucion FROM _498_tablaDinamica t,_367_tablaDinamica o WHERE t.idEstado IN (".$situacion.") and t.idCategoria in(".$listaCategorias.") and o.codigoInstitucion=t.codigoInstitucion order by id__498_tablaDinamica";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			if(!isset($aOrganizacionesCont[$fila[1]]))
			{
				if(!isset($arrOrganizaciones[$fila[0]]))
					$arrOrganizaciones[$fila[0]]=0;
				
				$arrOrganizaciones[$fila[0]]++;	
				$aOrganizacionesCont[$fila[1]]=1;
			}
		}
		
		$numReg=0;
		$consulta="SELECT id__368_tipoOrganizacionGrid,tipoOrganizacion,tipoAbreviado FROM _368_tipoOrganizacionGrid";
		$resOSC=$con->obtenerFilas($consulta);
		while($filaOSC=mysql_fetch_row($resOSC))
		{
			$o='{"tipoOSC":"'.$filaOSC[0].'","leyendaOSC":"('.$filaOSC[2].') '.$filaOSC[1].'","total":"'.(isset($arrOrganizaciones[$filaOSC[0]])?$arrOrganizaciones[$filaOSC[0]]:0).'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;	
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function marcarOSCDescalificada()
	{
		global $con;
		
		$idRegistroOSC=$_POST["idRegistroOSC"];
		
		$motivo=$_POST["motivo"];
		$consulta="UPDATE _367_tablaDinamica SET descalificada=1, motivoDescalificacion='".cv($motivo)."',respModifDescalificacion=".$_SESSION["idUsr"].",fechaModifDescalificacion='".date("Y-m-d H:i:s")."' WHERE id__367_tablaDinamica=".$idRegistroOSC;
		eC($consulta);
		
	}
	
	function desmarcarOSCDescalificada()
	{
		global $con;
		
		$idRegistroOSC=$_POST["idRegistroOSC"];
		
		
		$consulta="UPDATE _367_tablaDinamica SET descalificada=0,respModifDescalificacion=".$_SESSION["idUsr"].",fechaModifDescalificacion='".date("Y-m-d H:i:s")."' WHERE id__367_tablaDinamica=".$idRegistroOSC;
		eC($consulta);
		
		
	}
	
	function registrarEvaluacionProyectosCartas()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT codigo FROM _498_tablaDinamica WHERE id__498_tablaDinamica=".$obj->idProyecto;
		$folio=$con->obtenerValor($consulta);
		$consulta="update _498_evaluacionCartas set folio='-".$folio."' where folio='".$folio."'";	
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="INSERT INTO _498_evaluacionCartas(folio,requiereCarta,cuentaConCarta,fechaRegistro,responsable,comentariosAdicionales,comentariosFinales) VALUES('".$folio."',".
					$obj->rCarta.",".$obj->cCarta.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($obj->comentarios)."','".cv($obj->comentariosFinales)."')";
			eC($consulta);
		}
	}
	
	function registrarMaximoProyectosRevisor()
	{
		global $con;

		$idFormulario=$_POST["idFormulario"];
		$idUsuario=$_POST["idUsuario"];
		$tProyectos=$_POST["tProyectos"];
		$consulta="UPDATE 1010_distribucionRevisoresProyectos SET numMax='".$tProyectos."' WHERE idRegistro=".$idUsuario;
		
		eC($consulta);
	}
	
	function obtenerConceptosPresupuesto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		
		$arrCategorias=array();
		$consulta="SELECT id__385_gridCategoriasConcepto,categoriaConcepto FROM _385_gridCategoriasConcepto";
		$rConceptos=$con->obtenerFilas($consulta);
		while($fConcepto=mysql_fetch_row($rConceptos))
		{
			$arrCategorias[$fConcepto[0]]=$fConcepto[1];
		}
		
		$arrRubros=array();
		$consulta="SELECT id__385_tablaDinamica,conceptoPresupuestal FROM _385_tablaDinamica";
		$rConceptos=$con->obtenerFilas($consulta);
		while($fConcepto=mysql_fetch_row($rConceptos))
		{
			$arrRubros[$fConcepto[0]]=$fConcepto[1];
		}
		
		$numReg=0;
		$registros="";
		$consulta="SELECT c.* FROM 100_calculosGrid c,_385_tablaDinamica r WHERE c.idFormulario=".$idFormulario." AND c.idReferencia=".$idRegistro." and r.id__385_tablaDinamica=c.idRubro order by ordenAparicion,c.idRubro";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$descripcion=$fila[3];
			if(($fila[10]!="")&&($fila[10]!="0"))
			{
				$descripcion="(".$arrCategorias[$fila[10]].") ".$descripcion;
			}
			
			$consulta="SELECT costoUnitario,cantidad,total,comentarios FROM 1049_presupuestoAutorizado2015 WHERE idConcepto=".$fila[0];
			$fCostoAutorizado=$con->obtenerPrimeraFila($consulta);
			
			$detalle=$fila[11];
			if($fila[7]==1)
			{
				$objComplementario=json_decode($fila[12]); 
                                                                
				$entregables="";
				foreach($objComplementario->entregables as $e)
				{
					$entregables.="-- ".$e->entregable."<br><br>";
				}
				
				
				$consulta="SELECT nombreElemento FROM 1018_catalogoVarios WHERE claveElemento=".$objComplementario->periodoInicial." AND tipoElemento=3";
				$primeraQuincena=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreElemento FROM 1018_catalogoVarios WHERE claveElemento=".$objComplementario->periodoFinal." AND tipoElemento=3";
				$ultimaQuincena=$con->obtenerValor($consulta);
				
				$table='
							
							<table>
								<tr>
									<td width="165" class="letraSitioUbuntuNegro" style="vertical-align:top" >Objetivo de la contratación:</td>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top; text-align:justify"><i>'.$objComplementario->objetivoContratacion.'</i></td>
								</tr>
								<tr height="5">
									<td width="130" colspan="2"></td>
									
								</tr>
								<tr>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top">Periodo contratación:</td>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top; text-align:justify"><i>De la quincena: '.$primeraQuincena.' a la quincena: '.$ultimaQuincena.'</i></td>
								</tr>
								<tr height="5">
									<td width="130" colspan="2"></td>
									
								</tr>
								<tr>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top">Perfil del puesto:</td>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top; text-align:justify"><i>'.$objComplementario->perfilPuesto.'</i></td>
								</tr>
								<tr height="5">
									<td width="130" colspan="2"></td>
									
								</tr>
								<tr>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top">Experiencia requerida:</td>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top; text-align:justify"><i>'.$objComplementario->experienciaSolicitada.'</i></td>
								</tr>
								<tr height="5">
									<td width="130" colspan="2"></td>
									
								</tr>
								<tr>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top">Entregables esperados:</td>
									<td class="letraSitioUbuntuNegro" style="vertical-align:top; text-align:justify"><i>'.$entregables.'</i></td>
								</tr>
								<tr height="5">
									<td width="130" colspan="2"></td>
									
								</tr>
							</table>
							
						';
					$detalle=$table;
			}
			
			if($detalle=="")
				$detalle="Sin detalle";
			
			$o='{"idRubro":"'.$fila[7].'","idConcepto":"'.$fila[0].'","rubro":"'.cv($arrRubros[$fila[7]]).'","descripcion":"'.cv($descripcion).'","costo":"'.$fila[4].
				'","costoAutorizado":"'.$fCostoAutorizado[0].'","cantidad":"'.$fila[5].'","cantidadAutorizada":"'.$fCostoAutorizado[1].'","total":"'.$fila[6].
				'","montoAutorizado":"'.$fCostoAutorizado[2].'","detalle":"'.cv($detalle).'","comentarios":"'.cv($fCostoAutorizado[3]).'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function registrarModificacionPresupuesto2015()
	{
		
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$valor=$_POST["valor"];
		$campo=$_POST["campo"];
		
		
		switch($campo)
		{
			case "costoAutorizado":
				$campo="costoUnitario";
				if($valor=="")
					$valor=0;
			break;
			case "cantidadAutorizada":
				$campo="cantidad";
				if($valor=="")
					$valor=0;
			break;
			case "comentarios":
				$campo="comentarios";
			break;
		}
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 1049_presupuestoAutorizado2015 SET ".$campo."='".$valor."' WHERE idConcepto=".$idConcepto;
		$x++;
		if(($campo=="costoUnitario")||($campo=="cantidad"))
		{
			$query[$x]="UPDATE 1049_presupuestoAutorizado2015 SET total=costoUnitario*cantidad WHERE idConcepto=".$idConcepto;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
		
	}
	
	function registrarIncidenciaProyectos2015()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE _498_tablaDinamica SET comentariosFinales='".cv($obj->comentariosFinales)."',marcaConfirmada=".$obj->confirmaIncidencia.",marcaIncidencia=".$obj->incidencia.",comentarios='".cv($obj->comentarios)."' WHERE id__498_tablaDinamica=".$obj->idRegistro;
		eC($consulta);
	}
	
	function obtenerCalificacionesFinales()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		$consulta="";
		if($criterio==1)
		{
			$consulta="SELECT e.*,(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoAutorizado,
						marcaIncidencia,comentarios,marcaConfirmada,comentariosFinales,marcaDescalificacion2,requiereCarta,comentariosCarta,descalificado,p.motivoDescalificacion,
						if(marcaDescalificacion2=2,1,0) as requiereCluni,
						(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoSolicitado,
						o.organizacion as osc
						FROM 2015_evaluacionesFinales_v2 e,_498_tablaDinamica p,_367_tablaDinamica o where p.id__498_tablaDinamica=e.id__498_tablaDinamica 
						and o.codigoInstitucion=p.codigoInstitucion
						ORDER BY e.final DESC";
		}
		else
		{
			$consulta="
						select * from (
						SELECT 
						e.id__498_tablaDinamica,concat(e.codigo) as codigo,e.cal1,e.cal2,e.cal3,e.cal4,e.cal5,e.calP,e.calPer,e.ev1,e.ev2,e.ev3,e.ev4,e.ev5,
						e.evP,e.evPer,e.promedio,if(descalificado=0,e.final,-1) as final,e.coment1,e.coment2,e.coment3,e.coment4,e.coment5,e.comentP,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoAutorizado,
						marcaIncidencia,comentarios,marcaConfirmada,comentariosFinales,marcaDescalificacion2,requiereCarta,comentariosCarta,descalificado,p.motivoDescalificacion,
						if(marcaDescalificacion2=2,1,0) as requiereCluni,
						(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoSolicitado,
						o.organizacion as osc
						FROM 2015_evaluacionesFinales_Criterio2_v2 e,_498_tablaDinamica p,_367_tablaDinamica o where p.id__498_tablaDinamica=e.id__498_tablaDinamica  
						and o.codigoInstitucion=p.codigoInstitucion
						ORDER BY e.final DESC) as tmp order by final desc";
		}
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function descalificarProyecto2015()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		
		$motivo=$_POST["motivo"];
		
		$consulta="UPDATE _498_tablaDinamica SET descalificado=1,motivoDescalificacion='".cv($motivo)."' WHERE id__498_tablaDinamica=".$idProyecto;
		eC($consulta);
		
	}
	
	function obtenerProyectosFinanciados2015()
	{
		global $con;
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		$consulta="
						select * from (
						SELECT 
						e.id__498_tablaDinamica,concat(e.codigo) as codigo,e.cal1,e.cal2,e.cal3,e.cal4,e.cal5,e.calP,e.calPer,e.ev1,e.ev2,e.ev3,e.ev4,e.ev5,
						e.evP,e.evPer,e.promedio,if(descalificado=0,e.final,-1) as final,e.coment1,e.coment2,e.coment3,e.coment4,e.coment5,e.comentP,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica and idConcepto<>0) as presupuestoAutorizado,
						marcaIncidencia,comentarios,marcaConfirmada,comentariosFinales,marcaDescalificacion2,requiereCarta,comentariosCarta,descalificado,p.motivoDescalificacion,
						if(marcaDescalificacion2=2,1,0) as requiereCluni,
						(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoSolicitado,
						o.organizacion as osc,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoAjustado,
						presupuestoAutorizadoCENSIDA
						FROM 2015_evaluacionesFinales_Criterio2_v2 e,_498_tablaDinamica p,_367_tablaDinamica o where p.id__498_tablaDinamica=e.id__498_tablaDinamica  
						and o.codigoInstitucion=p.codigoInstitucion and p.marcaAutorizado=1 and descalificado=0
						ORDER BY e.final DESC) as tmp order by ".$sort." ".$dir;

		if(isset($_POST["start"]))
		{
			$consulta.=" limit ".$_POST["start"].",".$_POST["limit"];
		}


		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		$consulta="SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia IN
				(SELECT id__498_tablaDinamica FROM _498_tablaDinamica WHERE marcaAutorizado=1 AND descalificado=0)";
		$totalAutorizado=$con->obtenerValor($consulta);
		
		echo '{"totalAutorizado":"'.$totalAutorizado.'","numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerProyectosNOFinanciados2015()
	{
		global $con;
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		$consulta="
						select * from (
						SELECT 
						e.id__498_tablaDinamica,concat(e.codigo) as codigo,e.cal1,e.cal2,e.cal3,e.cal4,e.cal5,e.calP,e.calPer,e.ev1,e.ev2,e.ev3,e.ev4,e.ev5,
						e.evP,e.evPer,e.promedio,if(descalificado=0,e.final,-1) as final,e.coment1,e.coment2,e.coment3,e.coment4,e.coment5,e.comentP,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica and idConcepto<>0) as presupuestoAutorizado,
						marcaIncidencia,comentarios,marcaConfirmada,comentariosFinales,marcaDescalificacion2,requiereCarta,comentariosCarta,descalificado,p.motivoDescalificacion,
						if(marcaDescalificacion2=2,1,0) as requiereCluni,
						(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoSolicitado,
						o.organizacion as osc,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoAjustado
						FROM 2015_evaluacionesFinales_Criterio2_v2 e,_498_tablaDinamica p,_367_tablaDinamica o where p.id__498_tablaDinamica=e.id__498_tablaDinamica  
						and o.codigoInstitucion=p.codigoInstitucion and (p.marcaAutorizado=0 or descalificado=1)
						ORDER BY e.final DESC) as tmp order by ".$sort." ".$dir;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		$consulta="SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia IN
				(SELECT id__498_tablaDinamica FROM _498_tablaDinamica WHERE marcaAutorizado=1 AND descalificado=0)";
		$totalAutorizado=$con->obtenerValor($consulta);
		
		echo '{"totalAutorizado":"'.$totalAutorizado.'","numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function marcarProyectoFinanciable2015()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		
		
		
		$consulta="UPDATE _498_tablaDinamica SET marcaAutorizado=1 WHERE id__498_tablaDinamica=".$idProyecto;
		eC($consulta);
		
	}
	
	function registrarFinalizacionAjustePresupuestal()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$consulta="update  1050_presupuestoLiberado set liberado=1 where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		eC($consulta);
	}

	function obtenerInformeFinanciero20142da()
	{
		global $con;	

		$condWhere2="";
		$condWhere="";
		/*if((existeRol("'1_0'"))||($_SESSION["idUsr"]==70) ||(existeRol("'99_0'")))
				$condWhere="";
		else
		{
			$condWhere=" and id__448_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"].")";
			$condWhere2=" and idSupervisor=".$_SESSION["idUsr"];
		}*/
			

		if(isset($_POST["vSupervisor"])&&($_POST["vSupervisor"]==1))	
			$condWhere="";
	
		$cadCondWhere="";
		if(isset($_POST["filter"]))
			$cadCondWhere=" and ".generarCadenaConsultasFiltro($_POST["filter"]);
		
		$consulta="SELECT * FROM (
									
									
										SELECT concat('-',id__464_tablaDinamica) as idRegistro,codigo,tituloProyecto,
										(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica ) AS montoAutorizado,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) as comprobacionPorValidar,
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0) 
										
										)as montoPorEvaluar,
										
										'0' as montoPorComprobar,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
										
										) as montoReportado,
										'0' as montoComprobado,
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) as comprobacionRechazadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2) 
										
										) as montoRechazado,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=0) as comprobantesValidar,
										(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=2) as comprobantesRechazados,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND situacion=1) as comprobantesAceptados,
										(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS osc,'464' as idFormulario,proyLiberado,idSupervisor
										FROM _464_tablaDinamica p
										WHERE marcaAutorizado=1 ".$condWhere2."
									
									
									
									
								) AS t where  1=1 ".$cadCondWhere." ORDER BY codigo";
		

		$res=$con->obtenerFilas($consulta);
		
		
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			
			
			
			$supervisor=obtenerNombreUsuario($fila[19]);
			$montoComprobado=0;
			
			$consulta="SELECT montoAutorizado,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion 
			WHERE idConcepto=c.idGridVSCalculo and situacion=1) FROM 100_calculosGrid c WHERE idFormulario=".$fila[17]." AND idReferencia=".abs($fila[0]);
			$resConceptos=$con->obtenerFilas($consulta);
			while($filaConceptos=mysql_fetch_row($resConceptos))
			{
				if($filaConceptos[1]=="")
					$filaConceptos[1]=0;
				if($filaConceptos[1]>$filaConceptos[0])
					$montoComprobado+=$filaConceptos[0];
				else
					$montoComprobado+=$filaConceptos[1];
			}

			
			$permisos="";
			
			$ministracion1=$fila[3]*0.40;
			$ministracion2=$fila[3]*0.30;
			$ministracion3=$fila[3]-($ministracion1+$ministracion2);
			
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=0";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[5]+=$reIntegroPorValidar;
			}
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=1";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[8]+=$reIntegroPorValidar;
				$montoComprobado+=$reIntegroPorValidar;
				if($montoComprobado>$fila[3])
					$montoComprobado=$fila[3];
				$fila[6]-=$montoComprobado;
				if($fila[6]<0)
					$fila[6]=0;
			}
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=2";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[11]+=$reIntegroPorValidar;
			}
			
			$consulta="SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion WHERE idFactura IN 
						(SELECT idFactura FROM 101_comprobantesPresupuestales WHERE idFormulario=".$fila[17]." and idReferencia=".$fila[0].") 
						AND comprobanteCancelado=2 AND situacion=1";
			
			$montoCancelado=$con->obtenerValor($consulta);
			if($montoCancelado=="")
				$montoCancelado=0;
			
			$obj='{"supervisor":"'.cv($supervisor).'","osc":"'.cv($fila[16]).'","proyLiberado":"'.$fila[18].'","idFormulario":"'.$fila[17].'","osc":"'.$fila[16].'","comprobantesAceptados":"'.$fila[15].
					'","comprobantesRechazados":"'.$fila[14].'","ministracion1":"'.$ministracion1.'","ministracion2":"'.$ministracion2.
					'","ministracion3":"'.$ministracion3.'","idRegistro":"'.$fila[0].'","codigo":"'.$fila[1].'","tituloProyecto":"'.cv($fila[2]).
					'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[8].'","montoComprobado":"'.$montoComprobado.
					'","montoPorComprobar":"'.$fila[6].'","comprobacionPorValidar":"'.$fila[4].
					'","comprobacionRechazadas":"'.$fila[10].'","montoRechazado":"'.$fila[11].'","comprobacionesAceptadas":"'.$fila[7].
					'","montoPorEvaluar":"'.$fila[5].'","comprobantesValidar":"'.$fila[12].'","nSolicitudesTranferencia":"'.$fila[13].'","montoCancelado":"'.$montoCancelado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}

	function obtenerProyectosFinanciados2015_V2()
	{
		global $con;
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		$consulta="
						select * from (
						SELECT 
						e.id__498_tablaDinamica,concat(e.codigo) as codigo,e.cal1,e.cal2,e.cal3,e.cal4,e.cal5,e.calP,e.calPer,e.ev1,e.ev2,e.ev3,e.ev4,e.ev5,
						e.evP,e.evPer,e.promedio,if(descalificado=0,e.final,-1) as final,e.coment1,e.coment2,e.coment3,e.coment4,e.coment5,e.comentP,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica and idConcepto<>0) as presupuestoAutorizado,
						marcaIncidencia,comentarios,marcaConfirmada,comentariosFinales,marcaDescalificacion2,requiereCarta,comentariosCarta,descalificado,p.motivoDescalificacion,
						if(marcaDescalificacion2=2,1,0) as requiereCluni,
						(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoSolicitado,
						o.organizacion as osc,
						(SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia=e.id__498_tablaDinamica) as presupuestoAjustado,
						if(marcaOriginal=2,'1','0') as presupuestoAutorizadoCENSIDA
						FROM 2015_evaluacionesFinales_Criterio2_v2 e,_498_tablaDinamica p,_367_tablaDinamica o where p.id__498_tablaDinamica=e.id__498_tablaDinamica  
						and o.codigoInstitucion=p.codigoInstitucion and p.marcaAutorizado=1 and descalificado=0 and p.codigo in
						(select osc FROM 1048_evaluacionesPerfil2015 WHERE tipo=2 AND idUsuario=".$_SESSION["idUsr"].")
						ORDER BY e.final DESC) as tmp order by ".$sort." ".$dir;

		

		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		$consulta="SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=498 AND idReferencia IN
				(SELECT id__498_tablaDinamica FROM _498_tablaDinamica WHERE marcaAutorizado=1 AND descalificado=0)";
		$totalAutorizado=$con->obtenerValor($consulta);
		
		echo '{"totalAutorizado":"'.$totalAutorizado.'","numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}


	function obtenerProyectosConvenios2015()
	{
		global $con;	
		$osc=$_POST["osc"];
		$fecha=$_POST["fecha"];
		$montoLimite=122000000;
		$montoAcumulado=0;
		$montoTotalAutorizado=0;
		$totalDescalificados=0;
		$totalFinanciados=0;
		$totalNoFinanciados=0;
		$numReg=0;
		$arrRegistros="";
		$consulta="";
		
		$comp="";
		if($osc!=0)
			$comp=" and t.codigoInstitucion='".$osc."'";
		
		if($fecha!="")
			$comp.=" and a.fecha='".$fecha."'";	
			
			
		$consulta="SELECT t.id__498_tablaDinamica,o.organizacion,a.fecha,a.hora
				FROM _498_tablaDinamica t,_367_tablaDinamica o,1051_agendaCitasOSC a where 
				t.marcaAutorizado=1 and descalificado=0  and (folioConvenio<>'_' or folioConvenio is null)  and
				o.codigoInstitucion=t.codigoInstitucion and a.osc=o.codigoInstitucion ".$comp." 
				ORDER BY o.organizacion";
				
		
		$res=$con->obtenerFilas($consulta);
		while($filaReg=mysql_fetch_row($res))
		{
			
				
			$pintado=0;	
				
			$consulta="SELECT * FROM _498_tablaDinamica WHERE id__498_tablaDinamica=".$filaReg[0];
			$fila=$con->obtenerPrimeraFila($consulta);
			
			
			
			$nomOSC=$filaReg[1];
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[15];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			
			$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[16];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nSubCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			$descalificado="No";
			if($fila[28]=="1")
				$descalificado="Sí";
				
			
			$promedio=0;	
			
			$consulta="	SELECT SUM(total) FROM 1100_originalCalculoGrid2015 WHERE idFormulario=498 AND idReferencia=".$fila[0]."";
			$montoSolicitado=$con->obtenerValor($consulta);
			
			$consulta="	SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=".$fila[0]."";
			$montoAutorizado=$con->obtenerValor($consulta);
			
			$diferencia=$montoSolicitado-$montoAutorizado;
			$porcentaje=($diferencia/$montoAutorizado	)*100;
			

				
			$consulta="SELECT fechaSuscripcion,convenio,id__472_tablaDinamica FROM _472_tablaDinamica WHERE idReferencia=".$fila[0]." and ciclo=2015";
			$fSuscripcion=$con->obtenerPrimeraFila($consulta);			
			
			
			$consulta="SELECT concat(upper(nombre),' ',upper(aPaterno),' ',upper(aMaterno)) FROM _379_tablaDinamica WHERE id__379_tablaDinamica=".$fila[14];
			$nCoordinador=$con->obtenerValor($consulta);
			
			$consulta="SELECT sistesisCurricular FROM _379_tablaDinamica WHERE id__379_tablaDinamica=".$fila[14];
			$curriculum=$con->obtenerValor($consulta);

			if($fila[30]==1)
			{
				$requiereCarta='<span style=\'color:#900\'><b>Condicionada</b></span>';
			}
			else
			{
				$consulta="SELECT cartasAutorizacion FROM _516_tablaDinamica WHERE idReferencia=".$fila[0];
				$idCarta=$con->obtenerValor($consulta);
				
				if($idCarta=="")
				{
					$requiereCarta="N/A";
				}
				else
					$requiereCarta='<a href=\'../paginasFunciones/obtenerArchivos.php?id='.bE($idCarta).'\'><img src=\'../images/download.png\' width=\'14\' height=\'14\' /> Descargar</a>';
					
				
				
			}
			
				
			$obj='{"cartaProtesta":"'.$fila[18].'","curriculumCoordinador":"'.cv($nCoordinador.": ".$curriculum).'","requiereCarta":"'.$requiereCarta.'","fecha":"'.$filaReg[2].'","hora":"'.$filaReg[3].'","idRegistroConvenio":"'.$fSuscripcion[2].'","fechaFirmaConvenio":"'.$fSuscripcion[0].'","idConvenio":"'.$fSuscripcion[1].'","convenioFirmado":"'.$fila[36].
				'","comentariosVoBo":"'.cv($fila[37]).'","folioConvenio":"'.$fila[35].'","marcaAutorizado":"'.$fila[32].'","nombreOSC":"'.cv($nomOSC).'","codigo":"'.$fila[9].
				'","categoria":"'.$nCategoria.'","montoSolicitado":"'.$montoSolicitado.
				'","montoAutorizado":"'.$montoAutorizado.'","noSubcategoria":"'.$nSubCategoria.
				'","id__498_tablaDinamica":"'.$fila[0].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function registrarVoBoProyecto2015()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		
		
		
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE _".$obj->idFormulario."_tablaDinamica SET convenioFirmado=1 WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idProyecto;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}	
	}
	
	function obtenerEntregablesProyectosActividades()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=$_POST["idFormulario"];
		
		$consulta="	 SELECT d.idRegistro as documento,(SELECT actividad FROM 965_actividadesUsuario WHERE idActividadPrograma=d.idIndicadorActividad) as actividad,
					noInforme,evidencia as descripcion FROM 3000_informesTecnicos i,3000_detalleInformeTecnico d 
					 WHERE i.idFormulario=".$idFormulario." AND i.idReferencia=".$idProyecto." AND i.situacion=3 AND d.idRegistroInforme=i.idInforme
					 AND (d.idComprobante IS NOT NULL AND d.idComprobante<>'')";
							 
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
			
	}
	
	function obtenerInfoProyecto()
	{
		global $con;
		$iF=$_POST["iF"];
		$iR=$_POST["iR"];
		
		
		$consulta="SELECT o.organizacion,p.codigo FROM _".$iF."_tablaDinamica p,_367_tablaDinamica o WHERE id__".$iF."_tablaDinamica=".$iR." AND o.codigoInstitucion=p.codigoInstitucion";
		$fOsc=$con->obtenerPrimeraFila($consulta);
		
		$cadObj='{"osc":"'.cv($fOsc[0]).'","folio":"'.cv($fOsc[1]).'"}';
		echo "1|".$cadObj;
	}
	
	function obtenerDocumentosProyectos()
	{
		global $con;
		$iF=$_POST["iF"];
		$iR=$_POST["iR"];
		$tD=$_POST["tD"];

		$consulta=" SELECT id__537_tablaDinamica AS idRegistro,d.codigo AS folio,o.organizacion AS osc,p.codigo AS folioProyecto,d.fechaCreacion AS fechaRegistro,productoComunicativo AS documento,
					d.descripcion AS descripcionDocumento, comentariosAdicionales,d.idEstado as situacion,
					(SELECT COUNT(*) FROM 2002_comentariosRegistro WHERE idFormulario=537 AND idRegistro=d.id__537_tablaDinamica and comentario<>'') as nComentarios,
					(SELECT COUNT(*) FROM 2002_comentariosRegistro WHERE idFormulario=537 AND idRegistro=d.id__537_tablaDinamica and comentario<>'' and visualizado=0) as nComentariosNuevos
					
						FROM _537_tablaDinamica d, _".$iF."_tablaDinamica p, _367_tablaDinamica o WHERE iFormulario=".$iF." 
					AND iReferencia=".$iR." AND tipoDocumento=".$tD." AND p.id__".$iF."_tablaDinamica=iReferencia AND o.codigoInstitucion=p.codigoInstitucion";

		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
		
		
		
	}
	
	
	function obtenerDocumentosProyectosSupervisor()
	{
		global $con;
		$iF=$_POST["iF"];
		$tD=$_POST["tD"];
		$tE=1;
		if(isset($_POST["tE"]))
			$tE=$_POST["tE"];
		
		$idEstado="2,6";
		if($tE==2)
			$idEstado="2,8";

		$consulta='SELECT folioProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario='.$_SESSION["idUsr"].' AND ciclo=2015';
		$lProyectos=$con->obtenerListaValores($consulta,"'");
		if($lProyectos=="")
			$lProyectos=-1;
			
		$consulta="SELECT id__498_tablaDinamica FROM _498_tablaDinamica WHERE codigo IN (".$lProyectos.")";
		$lReferencias=$con->obtenerListaValores($consulta);
		if($lReferencias=="")
			$lReferencias=-1;
			
		
		
		$consultaAux="";
		
		if($tE==1)
		{
			$consultaAux=" and iReferencia in (".$lReferencias.")";
		}
		else
			$consultaAux=" and iReferencia not in (".$lReferencias.")";
		
		
		$consulta=" SELECT id__537_tablaDinamica AS idRegistro,d.codigo AS folio,o.organizacion AS osc,p.codigo AS folioProyecto,d.fechaCreacion AS fechaRegistro,productoComunicativo AS documento,
					d.descripcion AS descripcionDocumento, comentariosAdicionales,d.idEstado as situacion	FROM _537_tablaDinamica d, _".$iF."_tablaDinamica p, _367_tablaDinamica o WHERE iFormulario=".$iF." 
					".$consultaAux." AND tipoDocumento=".$tD." AND p.id__".$iF."_tablaDinamica=iReferencia AND o.codigoInstitucion=p.codigoInstitucion and d.idEstado in (".$idEstado.")";

		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
	}
	
	function registrarEvaluacionDocumento()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="SELECT codigo,descripcion,tipoDocumento,idEstado FROM _537_tablaDinamica WHERE id__537_tablaDinamica=".$obj->idRegistro;
		$fDocumento=$con->obtenerPrimeraFila($consulta);
		$idEstadoDocumento=$fDocumento[3];
		$actorResponsableDictamen=obtenerNombreUsuario($_SESSION["idUsr"]);
		if($obj->tipoEvaluacion==1)
		{
			$actorResponsableDictamen.=" (Supervisor de proyecto)";
			$obj->lblResultado.=" (Evaluación de contenido)";
		}
		else
		{
			$actorResponsableDictamen.=" (Evaluador de imagen)";
			$obj->lblResultado.=" (Evaluación de imagen)";
		}
		
		
		
		$idEstado=0;
		$enviado=0;
		
		if($obj->tipoEvaluacion==1)
		{
			if(($fDocumento[2]<>1)||($_SESSION["idUsr"]==301))
			{
				switch($obj->resultado)
				{
					case '1': //Aceptado
						$idEstado=3;
					break;
					case '2': //Rechazado
						$idEstado=4;
					break;
					case '3': //Se solicitan cambios
						$idEstado=5;
					break;
				}
				
				$enviado=1;
				
			}
			else
			{
				switch($obj->resultado)
				{
					case '1': //Aceptado
						switch($idEstadoDocumento)
						{
							case 2:
								$idEstado=8;	 //Nose envía nada	
							break;
							case 6:
								
								$enviado=1;
								$consulta="SELECT idResultado FROM 1052_comentariosEvaluacion WHERE 
											idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro." 
											AND tipoComentario=2 AND enviado=0";
								$idResultado=$con->obtenerValor($consulta);
								switch($idResultado)								
								{
									case "": //Sin pendientes
									case 1:  //Aceptado
										$idEstado=3;		
									break;
									case 3:  //Con cambio
										$idEstado=9;		
									break;
								}
							break;
						}
					break;
					case '2': //Rechazado
						$idEstado=4;
						$enviado=1;
					break;
					case '3': //Se solicitan cambios
						switch($idEstadoDocumento)
						{
							case 2:
								$idEstado=8;	//Nose envia nada	
							break;
							case 6:
								$enviado=1;
								$consulta="SELECT idResultado FROM 1052_comentariosEvaluacion WHERE 
											idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro." 
											AND tipoComentario=2 AND enviado=0";
								$idResultado=$con->obtenerValor($consulta);
								switch($idResultado)								
								{
									case "": //Sin pendientes
									case 1:  //Aceptado
										$idEstado=7;		
									break;
									case 3:  //Con cambio
										$idEstado=5;		
									break;
								}
								
								
								
							break;
						}
						
					break;
				}
			}
		}
		else
		{
			
			switch($obj->resultado)
			{
				case '1': //Aceptado
					switch($idEstadoDocumento)
					{
						case 2:
							$idEstado=6; //Nose envia nada		
						break;
						case 8:
							$enviado=1;	
							$consulta="SELECT idResultado FROM 1052_comentariosEvaluacion WHERE 
											idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro." 
											AND tipoComentario=1 AND enviado=0";
							$idResultado=$con->obtenerValor($consulta);
							switch($idResultado)								
							{
								case "": //Sin pendientes
								case 1:  //Aceptado
									$idEstado=3;		
								break;
								case 3:  //Con cambio
									$idEstado=7;		
								break;
							}
							
						break;
					}
				break;
				case '2': //Rechazado
						$idEstado=4;
						$enviado=1;
				break;
				case '3': //Se solicitan cambios
					switch($idEstadoDocumento)
					{
						case 2:
							$idEstado=6;		  // Nose envia nada
						break;
						case 8:

							$enviado=1;		
							
							$consulta="SELECT idResultado FROM 1052_comentariosEvaluacion WHERE 
											idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro." 
											AND tipoComentario=1 AND enviado=0";
							$idResultado=$con->obtenerValor($consulta);
							switch($idResultado)								
							{
								case "": //Sin pendientes
								case 1:  //Aceptado
									$idEstado=9;		
								break;
								case 3:  //Con cambio
									$idEstado=5;		
								break;
							}
							
						break;
					}
				break;
			}
		}
		
		
		$consulta="INSERT INTO 1052_comentariosEvaluacion(comentario,dictamen,fechaHoraDictamen,actorResponsableDictamen,idFormulario,idRegistro,
					idUsuarioResponsable,enviado,tipoComentario,idResultado)
					VALUES('".cv($obj->comentariosAdicionales)."','".cv($obj->lblResultado)."','".date("Y-m-d H:i:s")."','".cv($actorResponsableDictamen).
					"',".$obj->idFormulario.",".$obj->idRegistro.",".$_SESSION["idUsr"].",".$enviado.",".$obj->tipoEvaluacion.",".$obj->resultado.")";
		
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="UPDATE _537_tablaDinamica SET idEstado=".$idEstado." WHERE id__537_tablaDinamica=".$obj->idRegistro;
			if($con->ejecutarConsulta($consulta))
			{
				if($enviado==1)
				{
					
					$actorResponsableDictamen="";
					
					$lblResultado=$obj->lblResultado;
					
					
					if($obj->tipoEvaluacion==1)
					{
						$comentariosAdicionales="<b>Comentarios de evaluación de contenido:</b><br><br>";
						$actorResponsableDictamen="Evaluador de contenido (Supervisor de proyecto)";
					}
					else
					{
						$comentariosAdicionales="<b>Comentarios de evaluación de imagen:</b><br><br>";
						$actorResponsableDictamen="Evaluador de imagen";
					}
					$comentariosAdicionales.=(($obj->comentariosAdicionales!="")?$obj->comentariosAdicionales:'Sin comentarios')."<br><br>";
					$consulta="SELECT dictamen,comentario,tipoComentario FROM 1052_comentariosEvaluacion WHERE idFormulario=".$obj->idFormulario.
								" AND idRegistro=".$obj->idRegistro." AND enviado=0";
					$rComentarios=$con->obtenerFilas($consulta);
					while($fComentarios=mysql_fetch_row($rComentarios))
					{
						$lblResultado.=", ".$fComentarios[0];
						if($fComentarios[2]==1)
						{
							$actorResponsableDictamen.=", Evaluador de contenido (Supervisor de proyecto)";
							$comentariosAdicionales.="<b>Comentarios de evaluación de contenido:</b><br>";
						}
						else
						{
							$comentariosAdicionales.="<b>Evaluación de imagen:</b><br>";
							$actorResponsableDictamen.=", Comentarios de evaluación de imagen:";
						}
						$comentariosAdicionales.=(($fComentarios[1]!="")?$fComentarios[1]:'Sin comentarios')."<br><br>";
						
					}
					
					$x=0;
					$query[$x]="begin";
					$x++;
					$query[$x]="UPDATE 1052_comentariosEvaluacion SET enviado=1 WHERE idFormulario=".$obj->idFormulario.
								" AND idRegistro=".$obj->idRegistro." AND enviado=0";
					$x++;
					$query[$x]="INSERT INTO 2002_comentariosRegistro(comentario,dictamen,fechaHoraDictamen,actorResponsableDictamen,idFormulario,idRegistro,
								idUsuarioResponsable,idFormularioDictamen,idRegistroDictamen,version,idActor,visualizado)
								VALUES('".cv($comentariosAdicionales)."','".cv($lblResultado)."','".date("Y-m-d H:i:s")."','".cv($actorResponsableDictamen).
								"',".$obj->idFormulario.",".$obj->idRegistro.",".$_SESSION["idUsr"].",-1,-1,0,0,0)";
					$x++;
					$con->ejecutarBloque($query);
					
					@enviarMailProductoEvaluado($obj->idRegistro,$lblResultado,$comentariosAdicionales);	
					echo "1|";					
					
				}
				else
					echo "1|";
				
			}
		}
		
		
		
	}
	
	
	function enviarMailProductoEvaluado($idDocumento,$resultado,$comentariosAdicionales)
	{
		global $con;
		
		$arrAchivos=array();
		$arrCopias=array();
		$consulta="SELECT codigo,descripcion,iFormulario,iReferencia FROM _537_tablaDinamica WHERE id__537_tablaDinamica=".$idDocumento;
		$fDocumento=$con->obtenerPrimeraFila($consulta);		
		$consulta="SELECT codigo FROM _".$fDocumento[2]."_tablaDinamica WHERE id__".$fDocumento[2]."_tablaDinamica=".$fDocumento[3];
		$folioProy=$con->obtenerValor($consulta);
		
		$cuerpoMail="<table width=\"800\"><tr><td width=\'250\' align=\"center\"><img  width=\"180\" height=\"60\" src=\"http://censida.grupolatis.net/images/censida/logoSalud.gif\"></td>
								<td width=\'250\' align=\"center\"><img width=\"75%\" height=\"75%\"  src=\"http://censida.grupolatis.net/images/censida/FIRMA_ELECTRONICAaaa.png\"></td></tr></table>
								<br><br><h1>Centro Nacional para La Prevención y el<br>
								Control Del VIH y el sida</h1><br>
								<br><br>	<span style='font-size:12px'>		
								<b>A quien corresponda:</b><br><br>							
								
								Por este medio se le notifica que el documento con folio: ".$fDocumento[0].".- ".$fDocumento[1]." del proyecto: ".$folioProy." ha sido revisado y evaluado de la siguiente manera:<br><br>
								<b>Resultado:</b> ".$resultado."<br>
								
								<I>".$comentariosAdicionales."
								</I>
								
								<br><br>
								<br><br>
								</span>";	
		
		
		
		
		$consulta="SELECT distinct Mail,m.idUsuario FROM 805_mails m,800_usuarios u WHERE u.idUsuario=m.idUsuario and u.cuentaActiva=1 
					and m.idUsuario IN (
						SELECT idUsuario FROM 801_adscripcion a,_".$fDocumento[2]."_tablaDinamica t 
							WHERE a.Institucion=t.codigoInstitucion AND id__".$fDocumento[2]."_tablaDinamica=".$fDocumento[3]."
						)"; 
		$res=$con->obtenerFilas($consulta);						
		while($fila=mysql_fetch_row($res))
		{
			$destinatario=$fila[0];
			@enviarMail($destinatario," CENSIDA - Documento evaluado",$cuerpoMail,"soporteSMAP@grupolatis.net","",$arrAchivos,$arrCopias);
		}
		
	}
	
	function obtenerDocumentosProyectosSupervisorImagen()
	{
		global $con;
		$iF=$_POST["iF"];
		$tD=$_POST["tD"];

		$consulta=" SELECT id__537_tablaDinamica AS idRegistro,d.codigo AS folio,o.organizacion AS osc,p.codigo AS folioProyecto,d.fechaCreacion AS fechaRegistro,productoComunicativo AS documento,
					d.descripcion AS descripcionDocumento, comentariosAdicionales,d.idEstado as situacion	FROM _537_tablaDinamica d, _".$iF."_tablaDinamica p, _367_tablaDinamica o WHERE iFormulario=".$iF." 
					AND tipoDocumento=".$tD." AND p.id__".$iF."_tablaDinamica=iReferencia AND 
					o.codigoInstitucion=p.codigoInstitucion and d.idEstado in (2,8)";

		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
	}
	
	function obtenerComentariosRegistroDocumentos()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$tipoEvaluacion=$_POST["tE"];
		
		$consulta="SELECT comentario,dictamen,fechaHoraDictamen AS fechaComentario,actorResponsableDictamen AS actorComentario,
				'-1' AS idFormulario,'-1' AS idRegistro FROM 1052_comentariosEvaluacion WHERE 
				idFormulario=".$idFormulario."  AND idRegistro=".$idRegistro." and comentario<>'' and tipoComentario=".$tipoEvaluacion;
		$arrObj=$con->obtenerFilasJson($consulta);	
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function obtenerComentariosOSC()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$tipoEvaluacion=$_POST["tE"];
		
		$idEstado="1,5,7";
		if($tipoEvaluacion==2)
			$idEstado="1,5,9";
			
			
		$consulta="SELECT comentarios as comentario,'' AS dictamen,fechaCambio AS fechaComentario,'Responsable OSC' AS actorComentario,
				'-1' AS idFormulario,'-1' AS idRegistro FROM 941_bitacoraEtapasFormularios WHERE 
				idFormulario=".$idFormulario."  AND idRegistro=".$idRegistro." and comentarios<>'' and etapaAnterior in(".$idEstado.")";
		$arrObj=$con->obtenerFilasJson($consulta);	
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	
	function obtenerInformeFinanciero2015()
	{
		global $con;	

		$vGlobal=0;
		if(isset($_POST["vGlobal"]))
			$vGlobal=1;

		$condWhere2="";
		$condWhere="";
		if((existeRol("'1_0'"))||(existeRol("'99_0'"))||(existeRol("'100_0'"))||(existeRol("'101_0'")))
		{
				$condWhere="";
				/*if($_SESSION["idUsr"]==70)
				{
					$condWhere=" and id__498_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2015)";
					//$condWhere2=" and id__464_tablaDinamica=27";
				}*/
		}
		else
		{
			$condWhere=" and id__498_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=2015)";
			$condWhere2=" and idSupervisor=".$_SESSION["idUsr"];
		}
			

		if((isset($_POST["vSupervisor"])&&($_POST["vSupervisor"]==1))||($vGlobal==1))
		{
			$condWhere="";
			$condWhere2="";
		}
	
		$cadCondWhere="";
		if(isset($_POST["filter"]))
			$cadCondWhere=" and ".generarCadenaConsultasFiltro($_POST["filter"]);
		
		$consulta="SELECT * FROM (
									(
										SELECT id__498_tablaDinamica as idRegistro,codigo,tituloProyecto,
										(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica ) AS montoAutorizado,
										
										
										
										(
											SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f 
											WHERE c.idFormulario=498 AND c.idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0
											and f.idFactura=co.idFactura and f.folioComprobante not in
											(
												SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND 
												situacion=1 AND tipoComprobante IN(7,10)
											)	
										) as comprobacionPorValidar,
										
										(
												SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f 
												WHERE c.idFormulario=498 AND c.idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0
												and f.idFactura=co.idFactura and f.folioComprobante not in
												(
													SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND 
													situacion=1 AND tipoComprobante IN(7,10)
												)	
											
										)as montoPorEvaluar,
										
										
										
										'0' as montoPorComprobar,
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
										
										) as montoReportado,
										'0' as montoComprobado,
										
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
										c.idFormulario=498 AND c.idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2
										AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
										
										) AS comprobacionRechazadas,
										
										IF(
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=498 AND c.idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											
											
											)IS NULL,
											0,
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=498 AND c.idReferencia=p.id__498_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
											AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											) 
										
										) AS montoRechazado,
										
										
										
										
										
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND situacion=0) as comprobantesValidar,
										(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
										
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND situacion=2 and
										folioComprobante not in (SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND situacion=1 and tipoComprobante in(7,10))) as comprobantesRechazados,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND situacion=1) as comprobantesAceptados,
										(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS osc,'498' as idFormulario,0 as proyLiberado,
										(
										SELECT group_concat(nombre) FROM 800_usuarios u,1038_supervisionProyectos2014 s WHERE s.idUsuario=u.idUsuario AND s.idProyecto=p.id__498_tablaDinamica
										and s.ciclo=2015
										) as supervisor,
										(
										SELECT distinct id__531_tablaDinamica FROM _531_tablaDinamica t,_531_gridOficios g WHERE t.iFormulario=498 AND t.idReferencia=p.id__498_tablaDinamica 
										AND g.idReferencia=t.id__531_tablaDinamica 
										) as ajustesPresupuestales,
										'' as cartaConflicto,
										'' as cartaAutorizacion
										FROM _498_tablaDinamica p
										WHERE marcaAutorizado=1 and descalificado=0 and suspendido=0  ".$condWhere."
									)
									union
									
									(
										SELECT concat('-',id__522_tablaDinamica) as idRegistro,codigo,tituloProyecto,
										(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica ) AS montoAutorizado,
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f  WHERE c.idFormulario=522 AND c.idReferencia=p.id__522_tablaDinamica 
										AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0 AND f.idFactura=co.idFactura
										AND folioComprobante NOT IN
										(
												SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND 
												situacion=1 AND tipoComprobante IN(7,10)
											)	
										
										) as comprobacionPorValidar,
										
										
										(
											SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE c.idFormulario=522 AND c.idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0
											AND c.idGridVSCalculo=co.idConcepto AND co.situacion=0 AND f.idFactura=co.idFactura
											AND folioComprobante NOT IN
											(
												SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND 
												situacion=1 AND tipoComprobante IN(7,10)
											)	
										
										)as montoPorEvaluar,
										
										'0' as montoPorComprobar,
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co  WHERE c.idFormulario=522 
										AND idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) as comprobacionesAceptadas,
										
										if(
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1)is null,0,
										(SELECT SUM(montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co WHERE c.idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=1) 
										
										) as montoReportado,
										'0' as montoComprobado,
										
										
										(SELECT COUNT(*) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
										c.idFormulario=522 AND c.idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2
										AND f.idFactura=co.idFactura AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
										
										) AS comprobacionRechazadas,
										
										IF(
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=522 AND c.idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
												
											 AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											
											
											)IS NULL,
											0,
											(SELECT SUM(co.montoComprobacion) FROM 100_calculosGrid c,102_conceptosComprobacion co,101_comprobantesPresupuestales f WHERE 
											c.idFormulario=522 AND c.idReferencia=p.id__522_tablaDinamica AND c.idGridVSCalculo=co.idConcepto AND co.situacion=2 AND f.idFactura=co.idFactura
											AND folioComprobante NOT IN(SELECT folioComprobante FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND 
										situacion=1 AND tipoComprobante IN(7,10))
											
											) 
										
										) AS montoRechazado,
										
										
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND situacion=0) as comprobantesValidar,
										(SELECT COUNT(*) FROM 103_solicitudesTransferenciaPresupuesto WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND situacion=0) as nSolicitudesTranferencia,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND situacion=2) as comprobantesRechazados,
										(SELECT COUNT(*) FROM 101_comprobantesPresupuestales WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND situacion=1) as comprobantesAceptados,
										(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS osc,'522' as idFormulario,0 as proyLiberado,
										(
											SELECT nombre FROM 800_usuarios u WHERE idUsuario=p.idSupervisor) as supervisor,
										(
										SELECT distinct id__531_tablaDinamica FROM _531_tablaDinamica t,_531_gridOficios g WHERE t.iFormulario=522 AND t.idReferencia=p.id__522_tablaDinamica 
										AND g.idReferencia=t.id__531_tablaDinamica 
										) as ajustesPresupuestales,
										'' as cartaConflicto,
										'' as cartaAutorizacion
										FROM _522_tablaDinamica p
										WHERE marcaAutorizado=1 and descalificado=0 and suspendido=0  ".$condWhere2."
									)
									
									
									
								) AS t where  1=1 ".$cadCondWhere." ORDER BY codigo";
		
		$res=$con->obtenerFilas($consulta);
		
		
		/*
		
		*/
		
		
		
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$montoComprobado=0;
			
			$consulta="SELECT montoAutorizado,(SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion 
			WHERE idConcepto=c.idGridVSCalculo and situacion=1) FROM 100_calculosGrid c WHERE idFormulario=".$fila[17]." AND idReferencia=".abs($fila[0]);
			$resConceptos=$con->obtenerFilas($consulta);
			while($filaConceptos=mysql_fetch_row($resConceptos))
			{
				if($filaConceptos[1]=="")
					$filaConceptos[1]=0;
				if($filaConceptos[1]>$filaConceptos[0])
					$montoComprobado+=$filaConceptos[0];
				else
					$montoComprobado+=$filaConceptos[1];
			}

			
			$permisos="";
			
			$ministracion1=$fila[3]*0.60;
			$ministracion2=$fila[3]-$ministracion1;
			$ministracion3=0;
			
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=0";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[5]+=$reIntegroPorValidar;
			}
			
			
			
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=1";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			$montoReintregrado=$reIntegroPorValidar;
			if($reIntegroPorValidar!="")
			{
				
				$fila[8]+=$reIntegroPorValidar;
				$montoComprobado+=$reIntegroPorValidar;
				if($montoComprobado>$fila[3])
					$montoComprobado=$fila[3];
				$fila[6]-=$montoComprobado;
				if($fila[6]<0)
					$fila[6]=0;
			}
			
			$consulta="SELECT SUM(c.montoComprobacion) FROM 102_conceptosComprobacion c,101_comprobantesPresupuestales f WHERE idConcepto=0
						AND f.idFactura=c.idFactura AND f.idFormulario=".$fila[17]." AND f.idReferencia=".abs($fila[0])." AND c.situacion=2";
			
			$reIntegroPorValidar=$con->obtenerValor($consulta);
			if($reIntegroPorValidar!="")
			{
				$fila[11]+=$reIntegroPorValidar;
			}
			
			$consulta="SELECT SUM(montoComprobacion) FROM 102_conceptosComprobacion WHERE idFactura IN 
						(SELECT idFactura FROM 101_comprobantesPresupuestales WHERE idFormulario=".$fila[17]." and idReferencia=".$fila[0].") 
						AND comprobanteCancelado=2 AND situacion=1";
			
			$montoCancelado=$con->obtenerValor($consulta);
			if($montoCancelado=="")
				$montoCancelado=0;
			
			
			$porcentajeComprobado=(($montoComprobado+$fila[5])/$ministracion1)*100;
			if($porcentajeComprobado>100)
				$porcentajeComprobado=100;
			
			$consulta="SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=".$fila[17]." AND  idReferencia=".abs($fila[0])." AND noInforme=1";
			
			$informeTecnico1=$con->obtenerValor($consulta);
			
			$consulta="SELECT SUM(con.montoComprobacion) FROM 101_comprobantesPresupuestales c,102_conceptosComprobacion con 
						WHERE idFormulario=".$fila[17]." AND idReferencia=".abs($fila[0])." AND tipoComprobante IN( 3,12) AND c.situacion=1 AND con.idFactura=c.idFactura
						AND con.situacion=1";
			
			$totalNoFiscal=$con->obtenerValor($consulta);
			if($totalNoFiscal=="")
			{
				$totalNoFiscal=0;
			}
			$porcentajeNoFiscal=($totalNoFiscal/$fila[3])*100;
			
			
			$consulta="SELECT id__549_tablaDinamica FROM _549_tablaDinamica WHERE iFormulario=".$fila[17]." AND iRegistro=".$fila[0];
			$iCarta=$con->obtenerValor($consulta);


			$porComprobar=$fila[3]-$montoComprobado;
			if($porComprobar<0.01)
				$porComprobar=0;
				
			$consulta="UPDATE _".$fila[17]."_tablaDinamica SET montoAdeudo=".$porComprobar." WHERE id__".$fila[17]."_tablaDinamica=".abs($fila[0]);
			$con->ejecutarConsulta($consulta);

			
			$obj='{"montoReintegro":"'.$montoReintregrado.'","cartaLiberacion":"'.(($iCarta=="")?"-1":$iCarta).'","montoNOFiscal":"'.$totalNoFiscal.'","porcentajeNoFiscal":"'.$porcentajeNoFiscal.'","informeTecnico1":"'.$informeTecnico1.'","porcentajeComprobado":"'.$porcentajeComprobado.'","cartaConflicto":"'.$fila[21].'","cartaAutorizacion":"'.$fila[22].'","ajustesPresupuestales":"'.$fila[20].
					'","supervisor":"'.cv($fila[19]).'","osc":"'.cv($fila[16]).'","proyLiberado":"'.$fila[18].'","idFormulario":"'.$fila[17].'","osc":"'.$fila[16].'","comprobantesAceptados":"'.$fila[15].
					'","comprobantesRechazados":"'.$fila[14].'","ministracion1":"'.$ministracion1.'","ministracion2":"'.$ministracion2.
					'","ministracion3":"'.$ministracion3.'","idRegistro":"'.$fila[0].'","codigo":"'.$fila[1].'","tituloProyecto":"'.cv($fila[2]).
					'","montoAutorizado":"'.$fila[3].'","montoReportado":"'.$fila[8].'","montoComprobado":"'.$montoComprobado.
					'","montoPorComprobar":"'.$fila[6].'","comprobacionPorValidar":"'.$fila[4].
					'","comprobacionRechazadas":"'.$fila[10].'","montoRechazado":"'.$fila[11].'","comprobacionesAceptadas":"'.$fila[7].
					'","montoPorEvaluar":"'.$fila[5].'","comprobantesValidar":"'.$fila[12].'","nSolicitudesTranferencia":"'.$fila[13].'","montoCancelado":"'.$montoCancelado.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	
	
	function obtenerInformesTecnicosPeriodoCiclo2015()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idFormularioSegunda=522;
		
		if(isset($_POST["idFormularioSegunda"]))
			$idFormularioSegunda=$_POST["idFormularioSegunda"];
		
		$ignorarPermisos=false;
		$vGlobal=0;
		if(isset($_POST["vGlobal"]))
			$vGlobal=$_POST["vGlobal"];
		
		$vSupervisor=0;
		if(isset($_POST["vSupervisor"]))
			$vSupervisor=$_POST["vSupervisor"];
			
			
		$vSupervicion=0;
		if(isset($_POST["vSupervicion"]))
			$vSupervicion=$_POST["vSupervicion"];			
		
		
		if($_SESSION["idUsr"]==2109)
		{
			$vSupervicion=1;
		}
		
		if(isset($obj->ignorarPermisos))
			$ignorarPermisos=true;
		
		
		$ciclo=2015;
		if(isset($_POST["ciclo"]))
			$ciclo=$_POST["ciclo"];
		
		$arrEvaluaciones[1]=1;
		$arrEvaluaciones[2]=2;
		$arrEvaluaciones[3]=3;
		$arrEvaluaciones[4]=4;
		
		
		$periodo=$_POST["periodo"];
		
		
		$idEvaluacion=$arrEvaluaciones[$periodo];
		
		$idEtapaDocumento="2,6";
		
		if(existeRol("'114_0'"))
		{
			$idEtapaDocumento="2,6,8";
		}
		
		
		$compAux=" and 1=2";
		$compAux2=" and 1=2";
		
		
		if(existeRol("'1_0'")||($vGlobal==1)||($_SESSION["idUsr"]==70))
		{
			$compAux=" ";
			$compAux2=" ";
		}
		else
		{
			$compAux=" and  id__".$idFormulario."_tablaDinamica in (SELECT idProyecto FROM 1038_supervisionProyectos2014 
						WHERE idUsuario=".$_SESSION["idUsr"]." and ciclo=".$ciclo.")";
			$compAux2=" and idSupervisor=".$_SESSION["idUsr"];
		}
		
		
		if($vSupervicion==1)
		{
			$compAux=" and requiereSupervision=1";
			$compAux2=" and requiereSupervision=1";
		}
		
		if($_SESSION["idUsr"]==1342)
		{
			$compAux=" and requiereSupervision=1";
			$compAux2=" and requiereSupervision=1";
		}
		
		if(existeRol("'120_0'"))
		{
			$compAux=" AND idCategoria=21 ";
			$compAux2=" and 1=2";
		}
		
		$consultaSegundoFormulario="";
		if($idFormularioSegunda!=0)
		{
			$consultaSegundoFormulario="union
										(
											SELECT id__".$idFormularioSegunda."_tablaDinamica AS idProyecto,t.codigo AS folio,tituloProyecto AS titulo,o.organizacion as organizacion, 
											(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as situacionEvaluacion,
											(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaRealizacion,
											(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as idInforme,
											(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaModificacion,
											(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaEvaluacion,
											(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=".$idFormularioSegunda." AND idReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND noInforme=".$periodo." 
												and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion,
												
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=1 AND idEstado>0) as productosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=1 AND idEstado IN(".$idEtapaDocumento.")) as totalProductosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=2 AND idEstado>0) as productosVariosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=2 AND idEstado IN(2)) as totalProductosVariosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=3 AND idEstado>0) as entregablesValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormularioSegunda." AND iReferencia=t.id__".$idFormularioSegunda."_tablaDinamica AND tipoDocumento=3 AND idEstado IN(2)) as totalEntregablesValidar,	
											'".$idFormularioSegunda."' as idFormulario, proyLiberado					
											FROM _".$idFormularioSegunda."_tablaDinamica t,_367_tablaDinamica o 
											WHERE t.marcaAutorizado=1 and suspendido=0 and descalificado=0 AND o.codigoInstitucion=t.codigoInstitucion ".$compAux2."
										)";
		}
		
		$consulta="
						select * from (
										(
											SELECT id__".$idFormulario."_tablaDinamica AS idProyecto,t.codigo AS folio,tituloProyecto AS titulo,o.organizacion as organizacion, 
											(SELECT situacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as situacionEvaluacion,
											(SELECT fechaRegistro FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaRealizacion,
											(SELECT idInforme FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as idInforme,
											(SELECT fechaUltimaModificacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaModificacion,
											(SELECT fechaUltimaEvaluacion FROM 3000_informesTecnicos WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." limit 0,1) as fechaUltimaEvaluacion,
											(SELECT e.comentarios FROM 3000_informesTecnicos i,3001_evaluacionesInformeTecnico e WHERE idFormulario=".$idFormulario." AND idReferencia=t.id__".$idFormulario."_tablaDinamica AND noInforme=".$periodo." 
											and e.idInforme=i.idInforme limit 0,1) as comentariosEvaluacion,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=1 AND idEstado>0) as productosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=1 AND idEstado IN(".$idEtapaDocumento.")) as totalProductosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=2 AND idEstado>0) as productosVariosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=2 AND idEstado IN(2)) as totalProductosVariosValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=3 AND idEstado>0) as entregablesValidar,
											(SELECT COUNT(*) FROM _537_tablaDinamica WHERE iFormulario=".$idFormulario." AND iReferencia=t.id__".$idFormulario."_tablaDinamica AND tipoDocumento=3 AND idEstado IN(2)) as totalEntregablesValidar,
											'".$idFormulario."'	as idFormulario,proyLiberado				
											FROM _".$idFormulario."_tablaDinamica t,_367_tablaDinamica o 
											WHERE t.marcaAutorizado=1 and descalificado=0 and  suspendido=0 AND o.codigoInstitucion=t.codigoInstitucion ".$compAux."
										)
										".$consultaSegundoFormulario."
									) as tmp ORDER BY organizacion,folio";
		
		
		$res=$con->obtenerFilas($consulta);
		$arrReg="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$permisos="TFPCL";
			$consulta="SELECT resultadoEvaluacion FROM 3002_evaluacionesFinales WHERE idFormulario=".$fila[11]." AND idReferencia=".$fila[0]." and noEvaluacion=".$idEvaluacion." ORDER BY idEvaluacionFinal desc limit 0,1";
			$resEval=$con->obtenerValor($consulta);
			if(($resEval=="")&&(($fila[12]==1)||($fila[4]!="")))
			{
				$resEval=3;
			}
				
				
			switch($periodo)
			{
				case 1:
					if(strtotime($fila[5])>strtotime("2015-06-30"))
						$fila[5]="2015-06-30 ".date("H:i:s",strtotime($fila[5]));
				break;
				case 2:
					if(strtotime($fila[5])>strtotime("2015-08-31"))
						$fila[5]="2015-08-31 ".date("H:i:s",strtotime($fila[5]));
				break;
			}
			
			
			/*if(($fila[0]==96)||($fila[0]==97)||($fila[0]==98)||($fila[0]==99))
			{
				$fila[5]="2015-06-30 17:05:00";
				$fila[6]=1221;
				$fila[4]=4;
				$fila[7]="2015-07-27 15:43:00";
				$fila[8]="2015-07-15 16:37:00";
			}
			*/
			$consulta="SELECT idCartaCumplimiento,idCartaValidacion FROM 3000_informesTecnicos WHERE idInforme=".(($fila[6]=="")?"-1":$fila[6]);
			$fCartas=$con->obtenerPrimeraFila($consulta);
			
			$cartaCumplimientoInforme=$fCartas[0];
			if($cartaCumplimientoInforme=="")
				$cartaCumplimientoInforme=0;
			else
				$cartaCumplimientoInforme=1;
			
			$cartaValidacion=$fCartas[1];
			if($cartaValidacion=="")
				$cartaValidacion=0;
			else
				$cartaValidacion=1;
				
				
				
				
			$obj='{"cartaValidacion":"'.$cartaValidacion.'","cartaCumplimientoInforme":"'.$cartaCumplimientoInforme.'","idFormulario":"'.$fila[16].'","productosValidar":"'.$fila[10].'","totalProductosValidar":"'.$fila[11].'","productosVariosValidar":"'.$fila[12].'","totalProductosVariosValidar":"'.$fila[13].
				'","entregablesValidar":"'.$fila[14].'","totalEntregablesValidar":"'.$fila[15].'","comentariosEvaluacion":"'.cv(str_replace("#R","",$fila[9])).'","situacionDictamenFinal":"'.$resEval.'","idProyecto":"'.$fila[0].
					'","folio":"'.$fila[1].'","organizacion":"'.cv($fila[3]).'","fechaRealizacion":"'.$fila[5].'","titulo":"'.cv($fila[2]).'","idInforme":"'.$fila[6].'","situacionEvaluacion":"'.$fila[4].
				'","fechaUltimaModificacion":"'.$fila[7].'","fechaUltimaEvaluacion":"'.$fila[8].'","permisos":"'.$permisos.'"}';
			if($arrReg=="")
				$arrReg=$obj;
			else
				$arrReg.=",".$obj;
			$ct++;
		}
		
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrReg.']}';
		
			
	}
	
	function obtenerRevisionDocumentosProyectos()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$idFormulario=$_POST["idFormulario"];
		$tipoDocumento=$_POST["tipoDocumento"];
		$vSupervicion=0;
		if($_POST["vSupervicion"])
			$vSupervicion=$_POST["vSupervicion"];
		
		
		$consulta="SELECT id__537_tablaDinamica as idProducto,descripcion as descripcion,productoComunicativo as documento,idEstado as situacion,fechaCreacion as fechaRegistro,
		(SELECT comentario FROM 2002_comentariosRegistro WHERE idFormulario=537 AND idRegistro=t.id__537_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as comentarios, 
		(SELECT fechaHoraDictamen FROM 2002_comentariosRegistro WHERE idFormulario=537 AND idRegistro=t.id__537_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) as fechaEvaluacion,
		(SELECT u.Nombre FROM 2002_comentariosRegistro c,800_usuarios u WHERE idFormulario=537 AND idRegistro=t.id__537_tablaDinamica and u.idUsuario=c.idUsuarioResponsable ORDER BY idComentario DESC LIMIT 0,1) as respEvaluacion
		FROM _537_tablaDinamica t WHERE iFormulario=".$idFormulario." and iReferencia=".$idProyecto." and tipoDocumento=".$tipoDocumento;
		if($vSupervicion==1)
			$consulta.=" and t.idEstado=3";
		
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	
	function guardarCartaValidacionInformeTecnico()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if(file_exists($baseDir."/archivosTemporales/".$obj->idArchivo))
		{
			if(copy($baseDir."/archivosTemporales/".$obj->idArchivo,$baseDir."/modulosEspeciales_Censida/documentosInformes/".$obj->idArchivo))
				unlink($baseDir."/archivosTemporales/".$obj->idArchivo);
				
				
				
			$consulta="update 3000_informesTecnicos set idCartaValidacion='".$obj->idArchivo."',nombreCartaValidacion='".$obj->nombreArchivo."' where idInforme=".$obj->idInforme;
			eC($consulta);
				
		}
		
	}
	
	function obtenerIdRegistroPerfilOSC()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT codigoInstitucion FROM _367_tablaDinamica WHERE id__367_tablaDinamica=".$idRegistro;
		$codigoInstitucion=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__485_tablaDinamica FROM _485_tablaDinamica WHERE codigoInstitucion='".$codigoInstitucion."'";
		$idOSC=$con->obtenerValor($consulta);
		
		echo "1|".$idOSC;
		
	}
	
	function obtenerMaterialesComunicativos()
	{
		global $con;
		
		
		$mostrarVacios=false;
		$arNodos="";
		$consulta="SELECT id__548_tablaDinamica,tematica FROM _548_tablaDinamica ORDER BY tematica";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$totalTematica=0;	
			
			$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=10 ORDER BY nombreElemento";
			$rTiposDocumentos=$con->obtenerFilas($consulta);
			$arrTipoDocumento="";
			while($filaDocumentos=mysql_fetch_row($rTiposDocumentos))
			{
				$totalTiposDocumentos=0;	
				$icono="book_open.png";
				switch($filaDocumentos[0])
				{
					case 1:
						$icono="image.png";
					break;
					case 2:
						$icono="money_bookers.png";
					break;
					case 3:
						$icono="vcard.png";
					break;
					case 4:
						$icono="layout.png";
					break;
				}
				
				
				$consulta="SELECT DISTINCT lblTituloDocumento FROM _548_materialComunicativo WHERE idReferencia=".$fila[0]." AND tipoMaterial=".$filaDocumentos[0]." AND lblTituloDocumento NOT LIKE '%(%' ORDER BY lblTituloDocumento";
				$rTitulos=$con->obtenerFilas($consulta);
				$arrTitulos="";
				while($fTitulos=mysql_fetch_row($rTitulos))
				{
					
					$arrFormatos="";
					$consulta="SELECT * FROM _548_materialComunicativo WHERE idReferencia=".$fila[0]." AND tipoMaterial=".$filaDocumentos[0]." AND  (lblTituloDocumento='".$fTitulos[0]."' OR lblTituloDocumento LIKE '%(".$fTitulos[0].")%')";
					$rFormatos=$con->obtenerFilas($consulta);
					while($fFormato=mysql_fetch_row($rFormatos))
					{
						
						$iconoFormato="";
						$formato="";
						switch($fFormato[3])
						{
							case 1:
								$formato="JPG";
								$iconoFormato="../imagenesDocumentos/16/file_extension_jpg.png";
							break;
							case 2:
								$formato="PNG";
								$iconoFormato="../imagenesDocumentos/16/file_extension_png.png";
							break;
							case 3:
								$formato="PDF";
								$iconoFormato="../imagenesDocumentos/16/file_extension_pdf.png";
							break;
						}
						$consulta="SELECT tamano FROM 908_archivos WHERE idArchivo=".$fFormato[4];
						$tamano=$con->obtenerValor($consulta);
						if($tamano=="")
							$tamano=0;
						$objF='{"icon":"'.$iconoFormato.'","id":"4_'.$fila[0]."_".$filaDocumentos[0]."_".$fTitulos[0]."_".$fFormato[0].'","text":"'.cv($formato).'","documento":"'.$fFormato[4].'",tamano:"'.$tamano.'","tipo":"4","leaf":true}';
						if($arrFormatos=="")
							$arrFormatos=$objF;
						else
							$arrFormatos.=",".$objF;
					}
					
					$objT='{"icon":"../images/bullet_green.png","id":"3_'.$fila[0]."_".$filaDocumentos[0]."_".$fTitulos[0].'","text":"'.cv($fTitulos[0]).'","tipo":"3","leaf":false,children:['.$arrFormatos.'],expanded:true}';
					if($arrTitulos=="")
						$arrTitulos=$objT;
					else
						$arrTitulos.=",".$objT;
					
					$totalTematica++;
					$totalTiposDocumentos++;
					
				}
				
				if(($totalTiposDocumentos>0)||($mostrarVacios))
				{
					$objTD='{"icon":"../images/'.$icono.'","id":"2_'.$fila[0]."_".$filaDocumentos[0].'","text":"'.cv($filaDocumentos[1]).' ('.$totalTiposDocumentos.')","tipo":"2","leaf":false,children:['.$arrTitulos.']}';
					if($arrTipoDocumento=="")
						$arrTipoDocumento=$objTD;
					else
						$arrTipoDocumento.=",".$objTD;
				}
			}
			
			
			$comp="";
			if($arrTipoDocumento=="")
				$comp='"leaf":true';
			else
				$comp='"leaf":false, "children":['.$arrTipoDocumento.']';
				
			if(($totalTematica>0)||($mostrarVacios))
			{
				$obj='{"icon":"../images/book_open.png","id":"1_'.$fila[0].'","text":"'.cv($fila[1]).' ('.$totalTematica.')","tipo":"1",'.$comp.'}';
				if($arNodos=="")
					$arNodos=$obj;
				else
					$arNodos.=",".$obj;
			}
		}
		
		
		echo "[".$arNodos."]";
		
	}
	
	
	function obtenerElementoSeccionObjetivos2016()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$mesIni=$_POST["mesIni"];
		$mesFin=$_POST["mesFin"];
		
		$consulta="SELECT objetivoGeneral,objetivoEspecifico1,objetivoEspecifico2,objetivoEspecifico3,objetivoEspecifico4,
					meta11,meta12,meta21,meta22,meta31,meta32,meta41,meta42,cantidad11,cantidad12,cantidad21,cantidad22,
					cantidad31,cantidad32,cantidad41,cantidad42 FROM _554_tablaDinamica WHERE idReferencia=".$idReferencia;
		$fObjetivos=$con->obtenerPrimeraFila($consulta);
		
		
		$objetivo=$fObjetivos[0];
		$comp="";
		for($x=$mesIni;$x<=$mesFin;$x++)
		{
			
			$checado="false";
			$comp.=',"mes_'.$x.'":'.$checado;
		}
		
		
		$arrMetas=array();
		$arrMetas["meta_11"]["meta"]=$fObjetivos[5];
		$arrMetas["meta_11"]["cantidad"]=$fObjetivos[13];
		$arrMetas["meta_12"]["meta"]=$fObjetivos[6];
		$arrMetas["meta_12"]["cantidad"]=$fObjetivos[14];
		
		$arrMetas["meta_21"]["meta"]=$fObjetivos[7];
		$arrMetas["meta_21"]["cantidad"]=$fObjetivos[15];
		$arrMetas["meta_22"]["meta"]=$fObjetivos[8];
		$arrMetas["meta_22"]["cantidad"]=$fObjetivos[16];
		
		$arrMetas["meta_31"]["meta"]=$fObjetivos[9];
		$arrMetas["meta_31"]["cantidad"]=$fObjetivos[17];
		$arrMetas["meta_32"]["meta"]=$fObjetivos[10];
		$arrMetas["meta_32"]["cantidad"]=$fObjetivos[18];
		
		$arrMetas["meta_41"]["meta"]=$fObjetivos[11];
		$arrMetas["meta_41"]["cantidad"]=$fObjetivos[19];
		$arrMetas["meta_42"]["meta"]=$fObjetivos[12];
		$arrMetas["meta_42"]["cantidad"]=$fObjetivos[20];
		
		$comp="";
		$nReg=1;
		for($x=$mesIni;$x<=$mesFin;$x++)
		{
			
			$checado="false";
			$comp.=',"mes_'.$x.'":""';
		}
		$comp.=',"totalMes":""';
		$arrHijos="";
		
		$nReg=1;
		$arrElementos="";
		
		$arrObjetivos=array();
		$arrObjetivos[1]=$fObjetivos[1];
		$arrObjetivos[2]=$fObjetivos[2];
		$arrObjetivos[3]=$fObjetivos[3];
		$arrObjetivos[4]=$fObjetivos[4];
		
		foreach($arrObjetivos as $nObjetivo=>$objetivoEspecifico)
		{
			if($objetivoEspecifico=="")
				continue;
			$hijos="";
			
			for($nMeta=1;$nMeta<=2;$nMeta++)
			{
				if(trim($arrMetas["meta_".$nObjetivo.$nMeta]["meta"])!="")
				{
					
					$compHoja=",leaf:true";
					
					$hijosActividades=obtenerActividadesCronogramaMetaV3($idFormulario,$idReferencia,$nObjetivo.$nMeta,$mesIni,$mesFin);
					if($hijosActividades!="[]")
					{
						$compHoja=",leaf:false,children:".$hijosActividades;
					}
					$obj='{"cantidad":"'.$arrMetas["meta_".$nObjetivo.$nMeta]["cantidad"].'","txtTipoElemento":"Meta '.$nMeta.'","icon":"../images/lightbulb_add.png","id":"meta_'.$nObjetivo.$nMeta.'",arrIndicadores:[],"actividad":"'.cv($arrMetas["meta_".$nObjetivo.$nMeta]["meta"]).'","actividadDetalle":"'.cv($arrMetas["meta_".$nObjetivo.$nMeta]["meta"]).'","tipo":"3"'.$comp.$compHoja.'}';
					if($hijos=="")
						$hijos=$obj;
					else
						$hijos.=",".$obj;
				}
			}
			
			
			$hijos="[".$hijos."]";

			$compHoja="";
			if($hijos=="[]")
				$compHoja=",leaf:true";
			else
				$compHoja=",leaf:false,children:".$hijos;

			
			
			$obj='{"arrIndicadores":[],"txtTipoElemento":"Objetivo Específico '.$nObjetivo.'","icon":"../images/comments_add.png","id":"objE_'.$nObjetivo.'","actividad":"'.cv($objetivoEspecifico).'","actividadDetalle":"'.cv($objetivoEspecifico).'","tipo":"2"'.$comp.$compHoja.'}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else
				$arrElementos.=",".$obj;
			$nReg++;
		
		}
		$arrElementos="[".$arrElementos."]";
		$compHoja="";
		if($arrElementos=="[]")
			$compHoja=",leaf:true";
		else
			$compHoja=",leaf:false,children:".$arrElementos;
		$obj='{"txtTipoElemento":"Objetivo General","icon":"../images/comment_add.png","id":"obj_0","actividad":"'.cv($objetivo).'","actividadDetalle":"'.cv($objetivo).'","tipo":"1"'.$comp.$compHoja.'}';
		echo '['.$obj.']';
	}
	
	function obtenerSituacionConvocatoria2016()
	{
		global $con;
		
		
		$iconoNoIniciado='<img src=\'../images/unpublish_f2.png\'> <span class=\'tituloSeccion\' style=\'font-size:13px\'>(Sin registro)</span>';
		$iconoEdicion='<img src=\'../images/001_45.gif\'> <span class=\'tituloSeccion\' style=\'font-size:13px\'>(En diseño)</span>';
		$iconoFinalizado='<img src=\'../images/publish_f2.png\'> <span class=\'tituloSeccion\' style=\'font-size:13px\'>(En espera de validaci&oacute;n)</span>';
		
		$consulta="SELECT idEstado,id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$datosRegistroOSC=$con->obtenerPrimeraFila($consulta);
		
		
		$clase1="";
		$lblLeyenda1="";
		$idEstadoPadron=$datosRegistroOSC[0];
		$idOSC=$datosRegistroOSC[1];
		if($idOSC=="")
			$idOSC=-1;
		
		
		$icono1=$iconoNoIniciado;
		$clase1="divPasos";
		$lblLeyenda1="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(No registrado)";
		
		switch($idEstadoPadron)
		{
			case 1:
				$icono1=$iconoEdicion;
				$clase1="divPasosEdicion";
				$lblLeyenda1="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(En edici&oacute;n)";
			break;
			case 2:
				$icono1=$iconoFinalizado;
				$clase1="divPasosFinalizado";
				$lblLeyenda1="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(En validaci&oacute;n)";
			break;
		}
		
		$obj='{"paso":"1","icono":"'.$icono1.'","clase":"'.$clase1.'","leyenda":"'.$lblLeyenda1.'"}';
		
		$arrPasos=$obj;
		
		$icono2=$iconoNoIniciado;
		$clase2="divPasos";
		$lblLeyenda2="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(No registrado)";
		
		$consulta="SELECT idEstado,id__557_tablaDinamica FROM _557_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$fPerfil=$con->obtenerPrimeraFila($consulta);
		$idEstadoPerfil=$fPerfil[0];
		
		switch($idEstadoPerfil)
		{
			case 1:
				$icono2=$iconoEdicion;
				$clase2="divPasosEdicion";
				$lblLeyenda2="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(En edici&oacute;n)";
			break;
			case 2:
				$icono2=$iconoFinalizado;
				$clase2="divPasosFinalizado";
				$lblLeyenda2="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(En validaci&oacute;n)";
			break;
		}
		
		
		$obj='{"paso":"2","icono":"'.$icono2.'","clase":"'.$clase2.'","leyenda":"'.$lblLeyenda2.'"}';
		
		$arrPasos.=",".$obj;
		
		$icono3=$iconoNoIniciado;
		$clase3="divPasos";
		$lblLeyenda3="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(0 registrados)";
		
		$consulta="SELECT count(*) FROM _546_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$nProyectos=$con->obtenerValor($consulta);
		if($nProyectos>0)
		{
			
			$consulta="SELECT count(*) FROM _546_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and idEstado=2";
			$nProyectosFinalizados=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT count(*) FROM _546_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
			$nProyectosRegistrados=$con->obtenerValor($consulta);
			
			if($nProyectos==$nProyectosFinalizados)
			{
				$icono3=$iconoFinalizado;
				$clase3="divPasosFinalizado";
			}
			else
			{
				$icono3=$iconoEdicion;
				$clase3="divPasosEdicion";
			}
			
			$lblLeyenda3="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$nProyectosRegistrados." registrados)";
			
		}
		
		$obj='{"paso":"3","icono":"","clase":"'.$clase3.'","leyenda":"'.$lblLeyenda3.'"}';
		
		$arrPasos.=",".$obj;
		
		echo '1|['.$arrPasos.']';
		
	}
	
	function crearRegistroConvocatoria2016()
	{
		global $con;
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idFormulario=$_POST["idFormulario"];
		
		switch($idFormulario)
		{
			case 367:
				$consulta[$x]="INSERT INTO _367_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion) VALUES(-1,'".date("Y-m-d H:i:S")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"]."')";
				$x++;
				$consulta[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
			break;	
			case 557:
				$consulta[$x]="INSERT INTO _557_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion) VALUES(-1,'".date("Y-m-d H:i:S")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"]."')";
				$x++;
				$consulta[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
				
				/*$query="SELECT nombreElemento FROM 1018_catalogoVarios WHERE idElementoCatalogo>=99 AND tipoElemento=5 ORDER BY idElementoCatalogo";
				$rAnio=$con->obtenerFilas($query);
				while($f=mysql_fetch_row($rAnio))
				{
					$consulta[$x]="INSERT INTO _557_gridProyectos(idReferencia,anio) VALUES(@idRegistro,'".$f[0]."')";
					$x++;
				}*/
				
			break;	
			case 546:
			
				$idCategoria=$_POST["idCategoria"];
				$idSubcategoria=$_POST["idSubcategoria"];
				
				$consulta[$x]="INSERT INTO _546_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoInstitucion,idCategoria,idSubcategoria,categoriaProyecto) 
								VALUES(-1,'".date("Y-m-d H:i:S")."',".$_SESSION["idUsr"].",1,'".$_SESSION["codigoInstitucion"]."',".$idCategoria.",".$idSubcategoria.",".$idCategoria.")";
				$x++;
				$consulta[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
			break;	
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{	
			$query="select @idRegistro";

			$registro=$con->obtenerValor($query);

			if($idFormulario==546)
			{
				$codigo=generarFolioProyecto($idFormulario,$registro);
			}
			
			echo "1|".$registro;
		}
		
		
	}
	
	function guardarActividadCronograma2016()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idMeta=-1;
		if(isset($obj->idMeta))
			$idMeta=$obj->idMeta;
		
		$idIntervencion="NULL";
		
		
		
		if(isset($obj->idIntervencion))
			$idIntervencion=$obj->idIntervencion;
			
			
		
		if($obj->idActividad==-1)
		{
			$consulta[$x]="INSERT INTO 965_actividadesUsuario(actividad,idUsuario,idFormulario,idReferencia,descripcion,idPadre,idMetaFinal,actividadIntervencion,unidadMedida,entregables) 
							VALUES ('".cv($obj->actividad)."',".$_SESSION["idUsr"].",".$obj->idFormulario.",".$obj->idRegistro.",'',".$obj->idPadre.",".$idMeta.
							",NULL,'".cv($obj->unidadMedida)."','".cv($obj->entregables)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 965_actividadesUsuario set actividad='".cv($obj->actividad)."',descripcion='',unidadMedida='".cv($obj->unidadMedida)."',entregables='".cv($obj->entregables)."' where idActividadPrograma=".$obj->idActividad;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idActividad;
			$x++;
			$consulta[$x]="delete from 968_planeacionActividadesMeses where idActividad=@idRegistro";
			$x++;
		}
		
		
		foreach($obj->arrMeses as $mes)
		{
			$consulta[$x]="INSERT INTO 968_planeacionActividadesMeses(idActividad,mes,valor)
							VALUES(@idRegistro,".$mes->mes.",'".$mes->valor."')";
			$x++;							
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function obtenerActividadesCronogramaMetaV3($idFormulario,$idRegistro,$idMeta,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion,unidadMedida,entregables 
					FROM 965_actividadesUsuario WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and idMetaFinal=".$idMeta." order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";

		
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			$total=0;
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x."";
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="0";
				$total+=$checado;
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			
			$comp.=',"totalMes":"'.$total.'"';
			$hijos="";
			$cadHijos=obtenerActividadesMetaHijosV3($idFormulario,$idRegistro,$fila[0],$mesIni,$mesFin);

			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			
			$descripcion="";
			
						
			$obj='{"unidadMedida":"'.cv($fila[3]).'","entregables":"'.cv($fila[4]).'","txtTipoElemento":"Actividad'.cv($descripcion).'","actividadDetalle":"'.cv($fila[1]).'<br><b>Unidad de medida:</b> '.cv($fila[3]).'<br><b>Entregables:</b> '.cv($fila[4]).'","icon":"../images/lightning_add.png","id":"a_'.$fila[0].'","tipo":"4","actividad":"'.cv($fila[1]).'"'.$comp.$hijos.'}';
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return "[".$cadActividades."]";
	}

	function obtenerActividadesMetaHijosV3($idFormulario,$idRegistro,$idActividad,$mesIni,$mesFin)
	{
		global $con;
		$consulta="SELECT idActividadPrograma,actividad,descripcion,unidadMedida,entregables  FROM 965_actividadesUsuario 
					WHERE idPadre=".$idActividad. " order by fechaInicio,idActividadPrograma";
		$res=$con->obtenerFilas($consulta);
		$cadActividades="";
		while($fila=mysql_fetch_row($res))
		{
			
			$total=0;
			$comp="";
			for($x=$mesIni;$x<=$mesFin;$x++)
			{
				
				$consulta="SELECT valor FROM 968_planeacionActividadesMeses WHERE idActividad=".$fila[0]." AND mes=".$x; 
				$checado=$con->obtenerValor($consulta);
				if($checado=="")
					$checado="0";
				$total+=$checado;
				$comp.=',"mes_'.$x.'":'.$checado;
			}
			
			$comp.=',"totalMes":"'.$total.'"';
			$cadHijos=obtenerActividadesMetaHijosV3($idFormulario,$idRegistro,$fila[0],$mesIni,$mesFin);
			if($cadHijos!="")
			{
				$hijos=',"leaf":false,"children":['.$cadHijos.']';
			}
			else
				$hijos=',"leaf":true';
			
			
			$descripcion="";
			
			
			$consulta="SELECT idPoblacionVulnerable,idPoblacionBlanco,genero,rangoEdad,totalDirecta,totalIndirecta FROM 968_actividadesPoblacion WHERE idActividad=".$fila[0];
			$arrPoblacionesActividad=$con->obtenerFilasArreglo($consulta);
			
			$obj='{"unidadMedida":"'.cv($fila[3]).'","entregables":"'.cv($fila[4]).'","txtTipoElemento":"Actividad'.$descripcion.'","icon":"../images/lightning_add.png","id":"a_'.$fila[0].'","tipo":"4","actividadDetalle":"'.cv($fila[1]).'<br><b>Unidad de medida:</b> '.cv($fila[3]).'<br><b>Entregables:</b> '.cv($fila[4]).'","actividad":"'.cv($fila[1]).'"'.$comp.$hijos.'}';
			
			if($cadActividades=="")
				$cadActividades=$obj;
			else
				$cadActividades.=",".$obj;
		}
		return $cadActividades;
	}
	
	function obtenerInformesTecnicos2012_2015()
	{
		global $con;
		
		$ciclo=$_POST["ciclo"];
		
		$arrRegistros="";
		$numReg=0;
		switch($ciclo)
		{
			case 2012:
				$consulta="SELECT id__370_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica) AS montoAutorizado,
							'370' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=2) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=3) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=4) AS idInforme4,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=5) AS idInforme5,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=6) AS idInforme6,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=7) AS idInforme7,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=370 AND idReferencia=p.id__370_tablaDinamica AND noInforme=8) AS idInforme8
							FROM _370_tablaDinamica p WHERE marcaAutorizado=1
							ORDER BY codigo";
				$arrRegistros=$con->obtenerFilasJSON($consulta);
				$numReg=$con->filasAfectadas;
			break;
			case 2013:
				$consulta="SELECT id__410_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica) AS montoAutorizado,
							'410' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=410 AND idReferencia=p.id__410_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4

							FROM _410_tablaDinamica p WHERE marcaAutorizado=1
							ORDER BY codigo";
				$arrRegistros=$con->obtenerFilasJSON($consulta);
				$numReg=$con->filasAfectadas;
			break;
			case 2014:
				$consulta=" select * from (
							SELECT id__448_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica) AS montoAutorizado,
							'448' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=448 AND idReferencia=p.id__448_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4,
							proyLiberado

							FROM _448_tablaDinamica p WHERE marcaAutorizado=1
							
							union
							
							SELECT id__464_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica) AS montoAutorizado,
							'464' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=464 AND idReferencia=p.id__464_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4,
							proyLiberado
							FROM _464_tablaDinamica p WHERE marcaAutorizado=1 
							)
							as tmp
							ORDER BY folio";
				$arrRegistros=$con->obtenerFilasJSON($consulta);
				$numReg=$con->filasAfectadas;
			break;
			
			case 2015:
				$consulta=" select * from (
							SELECT id__498_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica) AS montoAutorizado,
							'498' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4,
							(SELECT id__549_tablaDinamica FROM _549_tablaDinamica WHERE iFormulario=498 AND iRegistro=p.id__498_tablaDinamica) as proyLiberado

							FROM _498_tablaDinamica p WHERE marcaAutorizado=1 and suspendido=0
							
							union
							
							SELECT id__522_tablaDinamica AS idProyecto,codigo AS folio,
							(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
							(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
							tituloProyecto AS titulo,
							(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica) AS montoAutorizado,
							'522' AS idFormulario,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
							(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=522 AND idReferencia=p.id__522_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4,
							(SELECT id__549_tablaDinamica FROM _549_tablaDinamica WHERE iFormulario=522 AND iRegistro=p.id__522_tablaDinamica) as proyLiberado
							FROM _522_tablaDinamica p WHERE marcaAutorizado=1 and suspendido=0 and descalificado=0
							)
							as tmp
							ORDER BY folio";
				$arrRegistros=$con->obtenerFilasJSON($consulta);
				$numReg=$con->filasAfectadas;
			break;
			
		}
		
		//$consulta="SELECT id__549_tablaDinamica FROM _549_tablaDinamica WHERE iFormulario=".$fila[17]." AND iRegistro=".$fila[0];
		echo '{"numReg":"'.$numReg.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerOSCCompletaronRegistro()
	{
		global $con;
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		$consulta="select * from (SELECT organizacion AS osc,fechaConstitucion,(SELECT GROUP_CONCAT(distinct CONCAT(aPaterno,' ',aMaterno,' ',nombre)) FROM _379_tablaDinamica WHERE idReferencia=o.id__367_tablaDinamica AND puesto=5) AS representanteLegal,
					(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=367 AND idRegistro=o.id__367_tablaDinamica AND etapaActual=2 ORDER BY fechaCambio DESC LIMIT 0,1)AS fechaEnvioValidacion 
					FROM _367_tablaDinamica o WHERE idEstado=2) as tmp ORDER BY ".$sort." ".$dir;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerOSCCompletaronPerfil()
	{
		global $con;
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		$consulta="select * from (SELECT organizacion AS osc,
					(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=557 AND idRegistro=p.id__557_tablaDinamica AND etapaActual=2 ORDER BY fechaCambio DESC LIMIT 0,1)AS fechaEnvioValidacion 
					FROM _367_tablaDinamica o,_557_tablaDinamica p WHERE o.idEstado=2 and p.idEstado=2 and p.codigoInstitucion=o.codigoInstitucion) as tmp ORDER BY ".$sort." ".$dir;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerProyectosRegistrados()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$cadCondWhere=str_replace("2.00","2.00,3.00",$cadCondWhere);

		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		$cadCondWhere=str_replace("idEstado","p.idEstado",$cadCondWhere);
		$sort=str_replace("idEstado","p.idEstado",$sort);
		
		
		$sort=str_replace("idCategoria","noCategoria",$sort);
		$consulta="SELECT idCategoria,estableceCentroDeteccion AS centroComunitario,folioRegistroProyecto AS folioRegistro,p.fechaCreacion AS fechaRegistro,folioParticipacion AS folioProyecto,
					(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=546 AND idRegistro=p.id__546_tablaDinamica AND etapaActual=2 ORDER BY fechaCambio DESC LIMIT 0,1) AS fechaEnvio,
					tituloProyecto AS nombreProyecto,(SELECT SUM(total) FROM 100_calculosGrid WHERE idFormulario=546 AND idReferencia=p.id__546_tablaDinamica) AS montoSolicitado,c.noCategoria,
					if(p.idEstado=3,2,p.idEstado) as idEstado,(select organizacion from _367_tablaDinamica where codigoInstitucion=p.codigoInstitucion) as osc
					 
					FROM _546_tablaDinamica p,_414_tablaDinamica c WHERE p.idEstado>0 AND ignorar=0 and c.id__414_tablaDinamica=p.idCategoria and ".$cadCondWhere." order by ".$sort." ".$dir;

		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerOSCValidacion()
	{
		global $con;
		
		$arrCiclos=array();
		$arrCiclos["293"]["ciclo"]="2011";
		$arrCiclos["370"]["ciclo"]="2012";
		$arrCiclos["410"]["ciclo"]="2013";
		$arrCiclos["448"]["ciclo"]="2014";
		$arrCiclos["464"]["ciclo"]="2014 2da. Convocatoria";
		$arrCiclos["498"]["ciclo"]="2015";
		$arrCiclos["522"]["ciclo"]="2015 2da. Convocatoria";		
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT organizacion AS osc,fechaConstitucion,CONCAT(rfc1,'-',rfc4,'-',rfc3) AS rfc,CLUNI,id__367_tablaDinamica,codigoInstitucion,datosIndesol
					FROM _367_tablaDinamica o WHERE codigoInstitucion in(select codigoInstitucion from _546_tablaDinamica where idEstado in(2,3)) 
					ORDER BY organizacion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT id__407_tablaDinamica FROM _407_tablaDinamica WHERE idReferencia=".$fila[4];
			$idDocumento=$con->obtenerValor($consulta);
			
			$consulta="SELECT documentoAnexo FROM _407_documentosRequeridosOSC WHERE idReferencia=".$idDocumento." AND tituloDocumento=7  ORDER BY id__407_documentosRequeridosOSC DESC";
			$informeAnual=$con->obtenerValor($consulta);
			$consulta="SELECT documentoAnexo FROM _407_documentosRequeridosOSC WHERE idReferencia=".$idDocumento." AND tituloDocumento=1  ORDER BY id__407_documentosRequeridosOSC DESC";
			$actaConstitutiva=$con->obtenerValor($consulta);
			$consulta="SELECT documentoAnexo FROM _407_documentosRequeridosOSC WHERE idReferencia=".$idDocumento." AND tituloDocumento=6  ORDER BY id__407_documentosRequeridosOSC DESC";
			$cluni=$con->obtenerValor($consulta);
			$consulta="SELECT documentoAnexo FROM _407_documentosRequeridosOSC WHERE idReferencia=".$idDocumento." AND tituloDocumento=9  ORDER BY id__407_documentosRequeridosOSC DESC";
			$cartaProtesta=$con->obtenerValor($consulta);
			$consulta="SELECT documentoAnexo FROM _407_documentosRequeridosOSC WHERE idReferencia=".$idDocumento." AND tituloDocumento=10  ORDER BY id__407_documentosRequeridosOSC DESC";
			$ultimaModificacion=$con->obtenerValor($consulta);			
			
			$arrDocumentos="[['".$actaConstitutiva."','Acta constitutiva'],['".$cluni."','CLUNI'],['".$informeAnual."','Informe anual'],['".$ultimaModificacion."','&Uacute;ltima modificaci&oacute;n del acta']]";
			
			$arrRepresentante="";
			$consulta="SELECT id__379_tablaDinamica,CONCAT(nombre,' ',aPaterno,' ',aMaterno),CURP,credencialElector FROM _379_tablaDinamica WHERE idReferencia=".$fila[4]." AND puesto=5";
			$rRep=$con->obtenerFilas($consulta);
			while($filaResp=mysql_fetch_row($rRep))
			{
				
				$oR='{"idMiembro":"'.$filaResp[0].'","representante":"'.cv($filaResp[1]).'","curp":"'.$filaResp[2].'","credencial":"'.$filaResp[3].'"}';
				if($arrRepresentante=="")
					$arrRepresentante=$oR;
				else
					$arrRepresentante.=",".$oR;
			}
			
			$arrAdeudos="";
			
			$consulta="SELECT COUNT(*) FROM 000_excepcionesAdeudos WHERE codigoInstitucion='".$fila[5]."' AND ciclo=2016";
			$nRegExcepcion=$con->obtenerValor($consulta);
			if($nRegExcepcion==0)
			{
				foreach($arrCiclos as $idFrm=>$resto)
				{
					$consulta="SELECT montoAdeudo,codigo FROM _".$idFrm."_tablaDinamica WHERE codigoInstitucion='".$fila[5]."' AND montoAdeudo>0";
					$resAdeudos=$con->obtenerFilas($consulta);
					while($fAdeudo=mysql_fetch_row($resAdeudos))
					{
						$oA="['".$fAdeudo[0]."','".$fAdeudo[1]."','".$resto["ciclo"]."']";
						if($arrAdeudos=="")
							$arrAdeudos=$oA;
						else
							$arrAdeudos.=",".$oA;
					}
				}
			}
			
			$datosIndesol=$fila[6];
			if($datosIndesol=="")
			{
				if((strpos($fila[3],"&")===false)&&(trim($fila[3])!=""))
					$datosIndesol=obtenerInfomacionIndesol(1,$fila[3]);
				else
					$datosIndesol=-1;
					
				if($datosIndesol==-1)
					if((strpos($fila[2],"&")===false)&&(trim($fila[2])!=""))
						$datosIndesol=obtenerInfomacionIndesol(2,$fila[2]);
					else
						$datosIndesol=-1;
				
				if($datosIndesol!=-1)
				{
					$consulta="update _367_tablaDinamica set datosIndesol='".bE($datosIndesol)."' where id__367_tablaDinamica=".$fila[4];
					
					$con->ejecutarConsulta($consulta);
				}
					
			}
			else
				$datosIndesol=bD($datosIndesol);
			
			$fechaConstitucionIndesol="";
			$arrRepresentanteIndesol="";
			$estadoRepresentacion="0";
			$evaluacionRepresentacion=0;
			$registroIndesol=0;
			$informeAnual=0;
			$rfcIndesol=$fila[2];
			$cluniIndesol=$fila[3];
			$evaluacionCartaBajoProtesta="";
			$evaluacionFechaConstitucion="0";
			$comentariosCartaProtesta="";
			if($datosIndesol!=-1)
			{
				
				
				$oIndesol=json_decode($datosIndesol);	
				$fechaConstitucionIndesol=$oIndesol->fechaConstitucion;
				switch($oIndesol->status)
				{
					case "Activa":
						$registroIndesol=1;
					break;
					case "Inactiva":
						$registroIndesol=2;
					break;
					case "Proceso de Disolución":
						$registroIndesol=3;
					break;
				}
				
				foreach($oIndesol->representantesLegales as $r) 
				{
					
					$oR='{"representante":"'.cv($r->representante).'"}';
					if($arrRepresentanteIndesol=="")
						$arrRepresentanteIndesol=$oR;
					else
						$arrRepresentanteIndesol.=",".$oR;
				}
				
				switch(strtoupper($oIndesol->statusRepresentacion))
				{
					case "VENCIDA":
						$estadoRepresentacion=2;
						$evaluacionRepresentacion=0;
					break;
					case "VIGENTE":
						$estadoRepresentacion=1;
						$evaluacionRepresentacion=1;
					break;
					case "NO VIGENTE":
						$estadoRepresentacion=0;
						$evaluacionRepresentacion=0;
					break;
				}
				
				foreach($oIndesol->informesAnuales as $i)
				{
					$anioBase=(date("Y")-1);
					if(($i->informe==$anioBase." En Tiempo")||($i->informe==$anioBase." Extemporaneo"))
					{
						$informeAnual=1;
						break;
					}
				}
				
				
				$rfcIndesol=$oIndesol->rfc;
				$cluniIndesol=$oIndesol->cluni;
				
			}
			
			if($fechaConstitucionIndesol==$fila[1])
			{
				$evaluacionFechaConstitucion=1;
			}			
			
			$estadoEvaluacion=0;
			$dictamenOSC="";
			$comentariosDictamenOSC="";
			$consulta="SELECT * FROM 000_evaluacionDocumentalOSC WHERE codigoInstitucion='".$fila[5]."' AND cicloEvaluacion=2016";
			$filaEvaluacion=$con->obtenerPrimeraFila($consulta);
			
			if($filaEvaluacion[2]=="")
			{
				$estadoEvaluacion=0;
				$arrAdeudos="[".$arrAdeudos."]";
			}
			else
			{
				$evaluacionFechaConstitucion=$filaEvaluacion[3];
				$evaluacionRepresentacion=$filaEvaluacion[4];
				$estadoRepresentacion=$filaEvaluacion[5];
				$registroIndesol=$filaEvaluacion[6];
				$informeAnual=$filaEvaluacion[7];
				$evaluacionCartaBajoProtesta=$filaEvaluacion[8];
				$comentariosCartaProtesta=$filaEvaluacion[9];
				$arrAdeudos=bD($filaEvaluacion[10]);
				$estadoEvaluacion=$filaEvaluacion[2];	
				$dictamenOSC=$filaEvaluacion[14];
				$comentariosDictamenOSC=$filaEvaluacion[15];
			}
			
			
			$relacionMiembrosOSC="";
			
			$consulta="SELECT (SELECT nombre FROM 000_participantesOSC WHERE idRegistro=r.idParticipanteBase) AS miembroBase,
					(SELECT nombre FROM 000_participantesOSC WHERE idRegistro=r.idParticipante) AS miembroEncontradoOSC,
					(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=r.oscEncotrado) AS oscEncontradoOSC,
					r.coincideCURP,r.correspondenciaNombre,r.gradoSimilitud,
					(SELECT curp FROM 000_participantesOSC WHERE idRegistro=r.idParticipanteBase) AS curp
					 FROM 000_relacionParticipantesOSC r WHERE oscBase='".$fila[5]."'";
			$rMiembros=$con->obtenerFilas($consulta);
			
			while($fMiembros=mysql_fetch_row($rMiembros))
			{

				$oMiembros="['".cv($fMiembros[0])."','".cv($fMiembros[1])."','".cv($fMiembros[2])."','".cv($fMiembros[3])."','".cv($fMiembros[4])."','".cv($fMiembros[5])."','".cv($fMiembros[6])."']";
				if($relacionMiembrosOSC=="")
					$relacionMiembrosOSC=$oMiembros;
				else
					$relacionMiembrosOSC.=",".$oMiembros;
			}
			
			$relacionMiembrosOSC="[".$relacionMiembrosOSC."]";
			
			$o='{"comentariosCartaProtesta":"'.cv($comentariosCartaProtesta).'","estadoEvaluacion":"'.$estadoEvaluacion.'","evaluacionRepresentanteLegal":"'.$evaluacionCartaBajoProtesta.
				'","evaluacionRepresentacion":"'.$evaluacionRepresentacion.'","rfcIndesol":"'.$rfcIndesol.'","cluniIndesol":"'.$cluniIndesol.'","evaluacionCartaBajoProtesta":"'.
				$evaluacionCartaBajoProtesta.'","evaluacionFechaConstitucion":"'.$evaluacionFechaConstitucion.'","codigoInstitucion":"'.$fila[5].'","libreAdeudos":'.$arrAdeudos.
				',"osc":"'.cv($fila[0]).'","fechaConstitucion":"'.$fila[1].'","representanteLegal":['.$arrRepresentante.'],"rfc":"'.$fila[2].'","documentosOSC":'.$arrDocumentos.
				',"fechaConstitucionIndesol":"'.$fechaConstitucionIndesol.'","cluni":"'.$fila[3].'","representanteLegalIndesol":['.$arrRepresentanteIndesol.'],"estadoRepresentacion":"'.
				$estadoRepresentacion.'","registroIndesol":"'.$registroIndesol.'","informeAnual":"'.$informeAnual.'","relacionMiembrosOSC":'.$relacionMiembrosOSC.
				',"dictamenOSC":"'.$dictamenOSC.'","comentariosDictamenOSC":"'.cv($comentariosDictamenOSC).'","cartaBajoProtesta":"'.$cartaProtesta.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		//,(SELECT GROUP_CONCAT(CONCAT(aPaterno,' ',aMaterno,' ',nombre)) FROM _379_tablaDinamica WHERE idReferencia=o.id__367_tablaDinamica AND puesto=5) AS representanteLegal
		echo '{"numReg":"'.$numReg.'","registros":['.($arrRegistros).']}';
		
	}
	
	
	function obtenerInfomacionIndesol($tipoParam="",$claveParam="")
	{
		global $con;
		
		$tipo=$tipoParam;
		$clave=$claveParam;
		if(isset($_POST["tipo"]))
		{
			$tipo=$_POST["tipo"];
			$clave=$_POST["clave"];
		}
		$url='http://166.78.45.36/portal/?';
		switch($tipo)
		{
			case 1:
				$url.='cluni='.$clave;
			break;
			case 2:
				$url.='rfc='.str_replace("-","",$clave);
			break;
		}
		
		$pagina = file_get_contents($url);
		
		$pos=strpos($pagina,'<table class="table table-bordered tabla-resultado-busqueda" id="exportar-excel">');
		
		if($pos===false)
		{
			if(isset($_POST["tipo"]))
				echo "1|-1";
			else
				return -1;
			
		}
		
		
		$posFinal=strpos($pagina,'</table>',$pos);
		
		$diferencia=$posFinal-$pos+8;
		$tabla=substr($pagina,$pos,$diferencia);
		
		
		$tabla=str_replace('<form action=""  method="post" target="_blank" id="FormularioPDF">','',$tabla);
		$tabla=str_replace('<input type="hidden" id="datos_ver" name="datos_ver" value=\'\'/>','',$tabla);
		
		$arrTabla=explode("<tbody>",$tabla);
		$tabla=$arrTabla[1];
		
		$arrTabla=explode("</form>",$tabla);
		$tabla=trim($arrTabla[0]);
		$tabla=str_replace('<!--  llenar -->','',$tabla);
		$tabla=str_replace('<tr>','',$tabla);
		$tabla=str_replace(' </tr>','',$tabla);
		$tabla=str_replace('</td>','',$tabla);
		
		$arrDatos=explode("<td>",$tabla);

		array_splice($arrDatos,0,1);
		
		
		$informes=$arrDatos[22];
		
		$representantes="";
		$arrRepresentantes=explode(",",$arrDatos[7]);
		foreach($arrRepresentantes  as $r)
		{
			if($representantes=="")
				$representantes='{"representante":"'.trim(cv($r)).'"}';
			else
				$representantes.=',{"representante":"'.trim(cv($r)).'"}';
			
		}
		
		$arrInformes="";
		$informes=str_replace('<ul>','',$informes);
		$informes=str_replace('</ul>','',$informes);
		$informes=str_replace('</li>','',$informes);		
		
		$aInformes=explode('<li>',$informes);
		foreach($aInformes as $i)
		{
			$i=trim(strip_tags($i));
			if($i=="")
				continue;
			if($arrInformes=="")
				$arrInformes='{"informe":"'.$i.'"}';
			else
				$arrInformes.=',{"informe":"'.$i.'"}';
		}
		
		
		$actividades=$arrDatos[21];
		$actividades=str_replace('<ul>','',$actividades);
		$actividades=str_replace('</ul>','',$actividades);
		$actividades=str_replace('</li>','',$actividades);		
		
		$arrActividades="";
		$aActividades=explode('<li>',$actividades);
		foreach($aActividades as $a)
		{
			$a=trim(strip_tags($a));
			if($a=="")
				continue;
			if($arrActividades=="")
				$arrActividades='{"actividad":"'.cv($a).'"}';
			else
				$arrActividades.=',{"actividad":"'.cv($a).'"}';
		}
		
		$cadObj='{"emailOSC":"'.cv($arrDatos[11]).'","telefono":"'.cv($arrDatos[12]).'","estadoDomicilio":"'.cv($arrDatos[13]).'","municipioDomicilio":"'.cv($arrDatos[14]).'","coloniaDomicilio":"'.cv($arrDatos[15]).
				'","calleDomicilio":"'.cv($arrDatos[16]).'","noExtDomicilio":"'.cv(str_replace(",","",$arrDatos[17])).'","noIntDomicilio":"'.cv(str_replace(",","",$arrDatos[18])).'","cp":"'.
				cv(str_replace(",","",$arrDatos[19])).'","osc":"'.cv($arrDatos[2]).'","cluni":"'.cv($arrDatos[1]).'","tipoOrganizacion":"'.cv($arrDatos[3]).'","rfc":"'.cv($arrDatos[4]).'","status":"'.
				cv(strip_tags($arrDatos[5])).'","actividades":['.$arrActividades.'],"representantesLegales":['.$representantes.'],"statusRepresentacion":"'.cv($arrDatos[8]).'","fechaConstitucion":"'.
				cv($arrDatos[9]).'","informesAnuales":['.$arrInformes.']}';
		
		
		if(isset($_POST["tipo"]))
			echo "1|".$cadObj;
		else
			return $cadObj;
		
		
	}
	
	function registrarEvaluacionDocumentosOSCIndesol()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="INSERT INTO 000_evaluacionDocumentalOSC(codigoInstitucion,situacion,evalucionFechaConstitucion,evaluacionRepresentante,estadoRepresentacion,registroIndesol,
				informeAnual,evaluacionCartaProtesta,comentariosCartaProtesta,libreAdeudos,fechaEvaluacion,responsableEvaluacion,cicloEvaluacion,dictamenOSC,comentariosDictamen) values
				('".$obj->codigoInstitucion."',1,".$obj->evalucionFechaConstitucion.",".$obj->evaluacionRepresentante.",".$obj->estadoRepresentacion.",".$obj->registroIndesol.
				",".$obj->informeAnual.",".$obj->evaluacionCartaProtesta.",'".cv($obj->comentariosCartaProtesta)."','".$obj->libreAdeudos."','".date("Y-m-d H:i:s")."',".
				$_SESSION["idUsr"].",2016,".$obj->dictamenOSC.",'".cv($obj->comentariosOSC)."')";
		
		eC($consulta);
		
	}
	
	function obtenerInformesTecnicos2015INSP()
	{
		global $con;
		
		
		
		$arrRegistros="";
		$numReg=0;

		$consulta=" select * from (
					SELECT id__498_tablaDinamica AS idProyecto,codigo AS folio,
					(SELECT organizacion FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS organizacion,
					(SELECT id__367_tablaDinamica FROM _367_tablaDinamica WHERE codigoInstitucion=p.codigoInstitucion) AS idOrganizacion,
					tituloProyecto AS titulo,
					(SELECT SUM(montoAutorizado) FROM  100_calculosGrid WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica) AS montoAutorizado,
					'498' AS idFormulario,
					(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=1 limit 0,1) AS idInforme1,
					(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=2 limit 0,1) AS idInforme2,
					(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=3 limit 0,1) AS idInforme3,
					(SELECT CONCAT(idInforme,'_',situacion) FROM 3000_informesTecnicos WHERE idFormulario=498 AND idReferencia=p.id__498_tablaDinamica AND noInforme=4 limit 0,1) AS idInforme4,
					(SELECT id__549_tablaDinamica FROM _549_tablaDinamica WHERE iFormulario=498 AND iRegistro=p.id__498_tablaDinamica) as proyLiberado

					FROM _498_tablaDinamica p WHERE codigo in
					(
						'Proy-2015-0049',
						'Proy-2015-0151',
						'Proy-2015-0234',
						'Proy-2015-0253',
						'Proy-2015-0329',
						'Proy-2015-0017',
						'Proy-2015-0063',
						'Proy-2015-0310',
						'Proy-2015-0034',
						'Proy-2015-0218',
						'Proy-2015-0037',
						'Proy-2015-0103',
						'Proy-2015-0011',
						'Proy-2015-0126',
						'Proy-2015-0180',
						'Proy-2015-0248',
						'Proy-2015-0291',
						'Proy-2015-0326',
						'Proy-2015-0291',
						'Proy-2015-0326',
						'Proy-2015-0080',
						'Proy-2015-0140',
						'Proy-2015-0149',
						'Proy-2015-0155',
						'Proy-2015-0170',
						'Proy-2015-0193',
						'Proy-2015-0209',
						'Proy-2015-0217',
						'Proy-2015-0267',
						'Proy-2015-0269',
						'Proy-2015-0280',
						'Proy-2015-0288',
						'Proy-2015-0315',
						'Proy-2015-0111',
						'Proy-2015-0082',
						'Proy-2015-0178'
					)
					
					
					)
					as tmp
					ORDER BY folio";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$numReg=$con->filasAfectadas;
		
		echo '{"numReg":"'.$numReg.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	
	function analizarParticipantesOSC()
	{
		global $con;
		$gradoSimitud=$_POST["gradoSimitud"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 000_relacionParticipantesOSC";
		$x++;
		
		$consulta="SELECT * FROM 000_participantesOSC WHERE curp<>''";
		$rParticipantes=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($rParticipantes))
		{
			
			$consulta="SELECT * FROM 000_participantesOSC WHERE curp='".$fila[2]."' AND codigoInstitucion<>'".$fila[3]."'";
			$rCoincidencias=$con->obtenerFilas($consulta);
			while($fCoincidencia=mysql_fetch_row($rCoincidencias))
			{
				$query[$x]="INSERT INTO 000_relacionParticipantesOSC(oscBase,idParticipanteBase,oscEncotrado,idParticipante,coincideCURP,correspondenciaNombre,gradoSimilitud) 
							VALUES('".$fila[3]."',".$fila[0].",'".$fCoincidencia[3]."',".$fCoincidencia[0].",1,0,0)";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		$con->ejecutarBloque($query);
		
		$query=array();
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="SELECT * FROM 000_participantesOSC order by idRegistro";
		$rParticipantes=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($rParticipantes))
		{
			$nombreBase=$fila[1];
			$consulta="SELECT * FROM 000_participantesOSC WHERE codigoInstitucion<>'".$fila[3]."' order by idRegistro";
			$rCoincidencias=$con->obtenerFilas($consulta);
			while($fCoincidencia=mysql_fetch_row($rCoincidencias))
			{
				$nombreReferencia=$fCoincidencia[1];
				
				$porcentaje=0;
				if($fila[0]<$fCoincidencia[0])
					similar_text($nombreBase,$nombreReferencia,$porcentaje);
				else
					similar_text($nombreReferencia,$nombreBase,$porcentaje);
				if($porcentaje>=$gradoSimitud)
				{
				
					$consulta="SELECT idRegistro FROM 000_relacionParticipantesOSC WHERE idParticipanteBase=".$fila[0]." AND idParticipante=".$fCoincidencia[0];
				
					$idParticipante=$con->obtenerValor($consulta);
					
					if($idParticipante=="")
					{
						$query[$x]="INSERT INTO 000_relacionParticipantesOSC(oscBase,idParticipanteBase,oscEncotrado,idParticipante,coincideCURP,correspondenciaNombre,gradoSimilitud) 
									VALUES('".$fila[3]."',".$fila[0].",'".$fCoincidencia[3]."',".$fCoincidencia[0].",0,1,".$porcentaje.")";
						$x++;
	
					}
					else
					{
						$query[$x]="update 000_relacionParticipantesOSC set correspondenciaNombre=1,gradoSimilitud=".$porcentaje." where  idRegistro=".$idParticipante;
									
						$x++;
					}
				}
			}
		}	
		
		
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function enviarEmailRevisor()
	{
		global $con;
		$prueba=false;
		$arrAchivos=NULL;
		$arrCC=array();		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$cuerpoMail="
						<table width=\"800\"><tr><td width=\'250\' align=\"center\"><img  width=\"180\" height=\"60\" src=\"http://smap.censida.net/images/censida/logoSalud.gif\"></td>
												<td width=\'250\' align=\"center\"><img width=\"75%\" height=\"75%\"  src=\"http://smap.censida.net/images/censida/FIRMA_ELECTRONICAaaa.png\"></td></tr></table>
												<br><br><h1>Centro Nacional para La Prevención y el<br>
												Control Del VIH/SIDA</h1><br>
												<br><br>".$obj->cuerpoMail."	<br><br>
				
					";
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		foreach($obj->emailEliminar as $m)
		{
			$query[$x]="DELETE FROM 805_mails WHERE idUsuario=".$obj->idUsuario." AND Mail='".cv($m->mail)."'";
			$x++;
		}
		
		$nMail=0;
		foreach($obj->email as $m)
		{
			$nMail++;
			if($m->mailOriginal=="")
			{
				$query[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".cv(trim($m->mailActual))."',1,1,".$obj->idUsuario.")";
				$x++;
			}
			else
			{
				if($m->mailOriginal!=$m->mailActual)
				{
					$query[$x]="update 805_mails set Mail='".cv(trim($m->mailActual))."' where idUsuario=".$obj->idUsuario." AND Mail='".cv($m->mailOriginal)."'";
					$x++;
				}
			}
			
			
			if(!$prueba)
			{
				if($nMail>=2)
				{
					$oM=array();
					$oM[0]=$m->mailActual;
					$oM[1]="";
					array_push($arrCC,$oM);	
				}
			}
			$nMail++;
			
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			if($prueba)
				$obj->email[0]->mailActual="novant1730@hotmail.com";
			enviarMail($obj->email[0]->mailActual,$obj->asunto,$cuerpoMail,"censidasoporte@censida.net","",$arrAchivos,$arrCC);
			echo "1|";
		}
		
		
		
	}
	
	function registrarComentariosAgustin()
	{
		global $con;
		$idRegistroComentario=$_POST["idRegistroComentario"];
		$comentario=$_POST["comentario"];
		$consulta="UPDATE 000_comentariosAgustin SET comentarios='".cv($comentario)."' WHERE idRegistroComentario=".$idRegistroComentario;
		eC($consulta);
		
	}
	
	function registrarDescalificacionProyecto2015()
	{
		global $con;
		$idFormulario=$_POST["iF"];
		$idProyecto=$_POST["iP"];
		$m=$_POST["m"];
		$consulta="UPDATE _".$idFormulario."_tablaDinamica SET descalificado=1,motivoDescalificacion='".cv($m)."',idResposableDescalificacion=".$_SESSION["idUsr"].",fechaDescalificacion='".date("Y-m-d H:i:s").
					"' WHERE id__".$idFormulario."_tablaDinamica=".$idProyecto;
		eC($consulta);
		
	}
	
	function registrarCandidatoProyecto2015()
	{
		global $con;
		$idFormulario=$_POST["iF"];
		$idProyecto=$_POST["iP"];
		$m=$_POST["m"];
		$consulta="UPDATE _".$idFormulario."_tablaDinamica SET candidato=1,idResposableDescalificacion=".$_SESSION["idUsr"].",fechaDescalificacion='".date("Y-m-d H:i:s").
					"' WHERE id__".$idFormulario."_tablaDinamica=".$idProyecto;
		eC($consulta);
		
	}
	
	function registrarEvaluacionCartaProyecto2015()
	{
		global $con;
		$idFormulario=$_POST["iF"];
		$idProyecto=$_POST["iP"];
		$comentario=$_POST["c"];
		$reqCarta=$_POST["rc"];
		$cuentaCarta=$_POST["cc"];
		
		$consulta="select codigo FROM _546_tablaDinamica WHERE id__546_tablaDinamica=".$idProyecto;
		$folio=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM _498_evaluacionCartas WHERE folio='".$folio."'";
		$idRegistro=$con->obtenerValor($consulta);
		
		if($idRegistro=="")
		{
			$consulta="INSERT INTO _498_evaluacionCartas(folio,requiereCarta,cuentaConCarta,fechaRegistro,responsable,comentariosAdicionales) 
						VALUES('".$folio."',".$reqCarta.",".$cuentaCarta.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($comentario)."')";
		}
		else
		{
			$consulta="UPDATE _498_evaluacionCartas SET requiereCarta=".$reqCarta.",cuentaConCarta=".$cuentaCarta.",fechaRegistro='".date("Y-m-d H:i:s")."',responsable=".$_SESSION["idUsr"].
					",comentariosAdicionales='".cv($comentario)."' WHERE idRegistro=".$idRegistro;

		}
		
		eC($consulta);	
		
	}
	
	function guardarComentariosEvaluacionPresupuestal()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$comentarios=$_POST["comentarios"];
		$consulta="UPDATE 1050_presupuestoLiberado SET comentariosFinales='".cv($comentarios)."' WHERE idFormulario='".$idFormulario."' AND idReferencia='".$idReferencia."'";
		eC($consulta);
	}
	
	function obtenerProyectosConvenios2016()
	{
		global $con;	
		$osc=$_POST["osc"];
		$fecha=$_POST["fecha"];
		$montoLimite=122000000;
		$montoAcumulado=0;
		$montoTotalAutorizado=0;
		$totalDescalificados=0;
		$totalFinanciados=0;
		$totalNoFinanciados=0;
		$numReg=0;
		$arrRegistros="";
		$consulta="";
		
		$comp="";
		if($osc!=0)
			$comp=" and t.codigoInstitucion='".$osc."'";
		
		if($fecha!="")
			$comp.=" and a.fecha='".$fecha."'";	
			
			
		$consulta="SELECT t.id__546_tablaDinamica,o.organizacion,a.fecha,a.hora
				FROM _546_tablaDinamica t,_367_tablaDinamica o,1051_agendaCitasOSC a where 
				t.marcaAutorizado=1 and descalificado=0  and (folioConvenio<>'_' or folioConvenio is null)  and
				o.codigoInstitucion=t.codigoInstitucion and a.osc=o.codigoInstitucion and a.activo=1 ".$comp." 
				ORDER BY o.organizacion";
				
		
		$res=$con->obtenerFilas($consulta);
		while($filaReg=mysql_fetch_row($res))
		{
			
				
			$pintado=0;	
				
			$consulta="SELECT * FROM _546_tablaDinamica WHERE id__546_tablaDinamica=".$filaReg[0];
			$fila=$con->obtenerPrimeraFila($consulta);
			
			
			
			$nomOSC=$filaReg[1];
			$consulta="SELECT noCategoria,tituloCategoria FROM _414_tablaDinamica WHERE id__414_tablaDinamica=".$fila[11];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			
			$consulta="SELECT noSubcategoria,tituloSubcategoria FROM _415_tablaDinamica WHERE id__415_tablaDinamica=".$fila[12];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nSubCategoria=$fCategoria[0].".- ".cv($fCategoria[1]);
			$descalificado="No";
			if($fila[24]=="1")
				$descalificado="Sí";
				
			
			$promedio=0;	
			
			$consulta="	SELECT SUM(total) FROM 1100_originalCalculoGrid2015 WHERE idFormulario=546 AND idReferencia=".$fila[0]."";
			$montoSolicitado=$con->obtenerValor($consulta);
			
			$consulta="	SELECT SUM(total) FROM 1049_presupuestoAutorizado2015 WHERE idFormulario=546 AND idReferencia=".$fila[0]."";
			$montoAutorizado=$con->obtenerValor($consulta);
			
			$diferencia=$montoSolicitado-$montoAutorizado;
			$porcentaje=($diferencia/$montoAutorizado	)*100;
			

				
			$consulta="SELECT fechaSuscripcion,convenio,id__472_tablaDinamica FROM _472_tablaDinamica WHERE idReferencia=".$fila[0]." and ciclo=2016";
			$fSuscripcion=$con->obtenerPrimeraFila($consulta);			
			
			
			$consulta="SELECT concat(upper(nombre),' ',upper(aPaterno),' ',upper(aMaterno)) FROM _379_tablaDinamica WHERE id__379_tablaDinamica=".$fila[13];
			$nCoordinador=$con->obtenerValor($consulta);
			
			$consulta="SELECT sistesisCurricular FROM _379_tablaDinamica WHERE id__379_tablaDinamica=".$fila[13];
			$curriculum=$con->obtenerValor($consulta);

			
				
			$obj='{"curriculumCoordinador":"","fecha":"'.$filaReg[2].'","hora":"'.$filaReg[3].'","idRegistroConvenio":"'.$fSuscripcion[2].
			'","fechaFirmaConvenio":"'.$fSuscripcion[0].'","idConvenio":"'.$fSuscripcion[1].'","convenioFirmado":"'.$fila[30].
				'","comentariosVoBo":"'.cv($fila[37]).'","folioConvenio":"'.cv($fila[29]).'","marcaAutorizado":"'.(($fila[6]==3)?1:0).'","nombreOSC":"'.cv($nomOSC).
				'","codigo":"'.$fila[9].'","categoria":"'.$nCategoria.'","montoSolicitado":"'.$montoSolicitado.
				'","montoAutorizado":"'.$montoAutorizado.'","noSubcategoria":"'.$nSubCategoria.
				'","id__546_tablaDinamica":"'.$fila[0].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
?>