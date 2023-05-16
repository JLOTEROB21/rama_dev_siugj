<?php session_start();
	include_once("funcionesFormularios.php"); 
	include_once("funcionesActores.php"); 
	include_once("configurarIdioma.php");
	include_once("conectoresAccesoDatos/administradorConexiones.php");
	include_once("cMacroProcesoAdmon.php");
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
				guardarElemento();
			break;
			case 2:
				eliminarElemento();
			break;
			case 3:
				generarTablaFormulario();
			break;
			case 4:
				obtenerCamposGrid();
			break;
			case 5:
				obtenerCamposGridDisponibles();
			break;
			case 6:
				guardarConfiguracionCampo();
			break;
			case 7:
				eliminarCampoConfiguracion();
			break;
			case 8:
				obtenerConfiguracionCampo();
			break;
			case 9:
				actualizarPosicionElemento();
			break;
			case 10:
				eliminarRegistro();
			break;
			case 11:
				contruirTabla();
			break;
			case 12:
				obtenerTablasBD();
			break;
			case 13:
				obtenerCamposTabla();
			break;
			case 14:
				obtenerFormularios();
			break;
			case 15:
				obtenerCamposSelectFormulario();
			break;
			case 16:
				obtenerOpcionesComboDependiente();
			break;
			case 17:
				obtenerEtapasProceso();
			break;
			case 18:
				actualizarControl();
			break;
			case 19:
				obtenerDatosComboSelect();
			break;
			case 20:
				guardarDisparadorEvento();
			break;
			case 21:
				eliminarReporte();
			break;
			case 22:
				obtenerEtapas();
			break;
			case 23:
				actualizarAnchoGrid();
			break;
			case 24:
				actualizarAltoGrid();
			break;
			case 25:
				obtenerCamposVista();
			break;
			case 26:
				obtenerOpciones();
			break;
			case 27:
				validarQuery();
			break;
			case 28:
				guardarMensajeAyuda();
			break;
			case 29:
				eliminarAyuda();
			break;
			case 30:
				obtenerAyudaControl();
			break;
			case 31:
				eliminarConfiguracion();
			break;
			case 32:
				guardarFiltroGrid();
			break;
			case 33:
				obtenerUsuarios();
			break;
			case 34:
				asociarUsuariosGrid();
			break;
			case 35:
				removerAsociacionUsr();
			break;
			case 36:
				obtenerRolesConfGrid();
			break;
			case 37:
				obtenerTokensFiltro();
			break;
			case 38:
				eliminarFiltro();
			break;
			case 39:
				eliminarRegistrosRelFormulario();
			break;
			case 40:
				obtenerCamposFormulario();
			break;
			case 41:
				guardarEstilo();
			break;
			case 42:
				obtenerCamposFormularioAsociado();
			break;
			case 43:
				agregarCamposFormularioAsociadoVista();
			break;
			case 44:
				eliminarFormulario();
			break;
			case 45:
				obtenerProyectos();
			break;
			case 46:
				obtenerTablasBDFitro();
			break;
			case 47:
				modificarMostrarGrid();
			break;
			case 48:
				guardarCampoDescriptivo();
			break;
			case 49:
				eliminarPerfilExportacion();
			break;
			case 50:
				obtenerDTDExportacion();
			break;
			case 51:
				actualizarXMLTag();
			break;
			case 52:
				removerElementoDTD();
			break;
			case 53:
				agregarElementoLibre();
			break;
			case 54:
				modificarPosicionElementoDTD();
			break;
			case 55:	
				eliminarIndicador();
			break;
			case 56:
				crearCampoGridFormulario();
			break;
			case 57:
				obtenerConfiguracionColumnas();
			break;
			case 58:
				agregarColumnaCampoGrid();
			break;
			case 59:
				removerColumnaCampoGrid();
			break;
			case 60:
				guardarListadoEnlaces();
			break;
			case 61:
				obtenerListadoEnlaces();
			break;
			case 62:
				eliminarEnlace();
			break;
			case 63:
				obtenerConfEnlace();
			break;
			case 64:
				obtenerListadoReportes();
			break;
			case 65:
				modificarConfiguracionFecha();
			break;
			case 66:
				cargarOpcionesElemento();
			break;
			case 67:
				guardarOpcionesElementoManual();
			break;
			case 68:
				cargarDatosIntervalo();
			break;	
			case 69:
				guardarModificacionIntervalo();
			break;
			case 70:
				obtenerConfiguracionElemento();
			break;
			case 71:
				guardarModificacionComboAlmacen();
			break;
			case 72:
				resolverQueriesControl();
			break;
			case 73:
				obtenerMacroProcesosDisponibles();
			break;
			case 74:
				guardarProcesoMacro();
			break;
			case 75:
				removerProcesoMacro();
			break;
			case 76:
				guardarConfiguracionGridODatos();
			break;
			case 1000:
				guardarElementoVista();
			break;
			case 2000:
				eliminarElementoVista();
			break;
			case 9000:
				actualizarPosicionElementoVista();
			break;
			case 18000:
				actualizarControlVista();
			break;
			case 23000:
			
				actualizarAnchoGridVista();
			break;
			case 24000:
				actualizarAltoGridVista();
			break;
			case 200:
				obtenerCategoriasCalculos();
			break;
			case 201:
				obtenerCalculosCategorias();
			break;
			case 202:
				tienePatrametrosCalculo();
			break;
			case 203:
				guardarMensajeEnvio();
			break;
			case 204:
				obtenerCamposFormularioTipo();
			break;
			case 205:
				guardarConfiguracionAlmacenDatoControl();
			break;
			case 206:
				removerConfiguracionAlmacenDatoControl();
			break;
			case 207:
				modificarEtiquetaGridListado();
			break;
			case 208:
				registrarFiltroGlobal();
			break;
			case 209:
			
				obtenerFiltrosGlobales();
				
			break;
			case 210:
				removerFiltroGlobal();
			break;
			case 211:
				crearIndiceFormulario();
			break;
			case 212;
				obtenerIndicesFormulario();
			break;
			case 213:
				removerIndiceFormulario();
			break;
			case 214:
				obtenerCamposTableroControl();
			break;
			case 215:
				obtenerCamposTableroDisponibles();
			break;
			case 216:
				guardarConfiguracionCampoTableroControl();
			break;
			case 217:
				obtenerConfiguracionCampoTableroControl();
			break;
			case 218:
				eliminarCampoConfiguracionTableroControl();
			break;
			case 219:
				obtenerCamposTableroControlAdministracion();
			break;
			case 220:
				modificarCampoTableroControl();
			break;
			case 221:
				eliminarCampoTableroControl();
			break;
			case 222:	
				actualizarNumeroRegistroPaginas();
			break;
			case 223:
				obtenerCamposOrdenTableroControl();
			break;
			case 224:
				modificarCamposOrdenTableroControl();
			break;
			case 225:
				removerCamposOrdenTableroControl();
			break;
			case 226:
				crearIndiceTableroControl();
			break;
			case 227:
				obtenerIndicesTableroControl();
			break;
			case 228:
				removerIndiceTableroControl();
			break;
			case 229:
				registrarFiltroGlobalTableroControl();
			break;
			case 230:
				obtenerFiltrosGlobalesTableroControl();
			break;
			case 231:
				removerFiltroGlobalTableroControl();
			break;
			case 232:
				obtenerNotificacionesProceso();
			break;
			case 233:
				guardarNotificacion();
			break;
			case 234:
				obtenerAsociacionTableroControlNotificaciones();
			break;
			case 235:
				obtenerConfiguracionNotificacionesProceso();
			break;
			case 236:
				registrarConfiguracionNotificacionesProceso();
			break;
			case 237:
				removerConfiguracionNotificacionesProceso();
			break;
			case 238:
				removerNotificacionTableroControl();
			break;
			case 239:
				obtenerActorFormularioRegistro();
			break;
			case 240:
				registrarVisualizacionNotificacion();
			break;
			case 241:
				obtenerRegistrosHistorial();
			break;
			case 242:
				obtenerDocumentosVinculadosProceso();
			break;
			case 243:
				registrarDelegacionActividades();
			break;
			case 300:
				registrarAtencionNotificacion();
			break;
			
			case 301:
				obtenerHistorialFormatoRegistrado();
			break;
			case 302:	
				obtenerXMLFormulario();
			break;
			case 305:
				arrancarProcesoTareaMacroProceso();
			break;
			case 306:
				reiniciarVistaFormulario();
			break;
			case 307:
				normalizarFormulario();
			break;
			case 308:
				obtenerTareasProceso();
			break;
			
			case 310:
				removerFuncionSeccionProceso();
			break;
			case 311:
				addFuncionSeccionProceso();
			break;
			
			
			
        }
	}
	
	function guardarElemento()
	{
		
			global $mostrarXML;
			$mostrarXML=false;
			$res=crearControl($_POST["datosP"]);
			echo $res;
	}
	
	function guardarElementoVista()
	{
		
			global $mostrarXML;
			$mostrarXML=false;
			$res=crearControlVistaFormulario($_POST["datosP"]);
			echo $res;
	}
	
	
	
	
	function eliminarElemento()
	{
		global $con;
		$x=0;
		$idElemento=$_POST["idGrupoElemento"];
		$query="select f.nombreTabla,e.nombreCampo,e.tipoElemento,f.idFormulario from 900_formularios f,901_elementosFormulario e where f.idFormulario=e.idFormulario and e.idGrupoElemento=".$idElemento;

		$fila=$con->obtenerPrimeraFila($query);
		$idFormulario=$fila[3];
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 901_elementosFormulario where idGrupoElemento=".$idElemento;
		$x++;
		$consulta[$x]="delete from 907_camposGrid where idElementoFormulario=".$idElemento;
		$x++;
		$consulta[$x]="delete from 937_elementosVistaFormulario where idGrupoElemento=".$idElemento;
		$x++;
		$consulta[$x]="delete from 938_configuracionElemVistaFormulario where idElemFormulario=".$idElemento;
		$x++;
		$consulta[$x]="delete from 929_operacionesCampoExpresion where idElemFormulario=".$idElemento;
		$x++;
		$consulta[$x]="delete from 985_controlesAccionVSAcciones where idElemFormulario=".$idElemento;
		$x++;
		$consulta[$x]="delete from 985_controlesAccionVSAcciones where idElemCtrlFormulario=".$idElemento;
		$x++;
		if($fila[2]==23)
		{
			$consulta[$x]="delete from 983_imagenesFormularios where idArchivo in (select campoConf3 from 904_configuracionElemFormulario where idElemFormulario=".$idElemento.")";
			$x++;
		}
		$consulta[$x]="delete from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
		$x++;
		
		
		if((!(($fila[2]>=17)&&($fila[2]<=19)))&&($fila[2]!=1)&&($fila[2]!=13)&&($fila[2]!=23)&&($fila[2]!=29)&&($fila[2]!=30)&&($fila[2]!=33))
		{
			$consulta[$x]="alter table `".$con->bdActual."`.`".$fila[0]."` drop column `".$fila[1]."`";
			$x++;
		}
		
		if(($fila[2]>=17)&&($fila[2]<=19))
		{
			$consulta[$x]="drop table `".$con->bdActual."`.`_".$idFormulario."_".$fila[1]."`";
			$x++;
		}
		if(($fila[2]!=1)&&($fila[2]!=13)&&($fila[2]!=22)&&($fila[2]!=23)&&($fila[2]!=33))
		{
			$query="select orden from 901_elementosFormulario where idGrupoElemento=".$idElemento;
			$orden=$con->obtenerValor($query);
			$consulta[$x]="update 901_elementosFormulario set orden=orden-1 where orden>".$orden." and idFormulario=".$fila[3];
			$x++;
			
		}
		
		if($fila[2]==29)
		{
			$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
			$filaElemento=$con->obtenerPrimeraFila($query);
			$nTabla=$filaElemento[4];
			$consulta[$x]="delete from 9039_configuracionesColumnasCampoGrid where idElemento=".$idElemento;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($fila[2]==29)
			{
				$query="drop table `".$con->bdActual."`.`".$nTabla."`";
				if($con->ejecutarConsulta($query))
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
	
	function eliminarElementoVista()
	{
		global $con;
		$x=0;
		$idElemento=$_POST["idGrupoElemento"];
		$query="select tipoElemento from 937_elementosVistaFormulario where  idGrupoElemento=".$idElemento;
		$tElemento=$con->obtenerValor($query);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 937_elementosVistaFormulario where idGrupoElemento=".$idElemento;
		$x++;
		$consulta[$x]="delete from 938_configuracionElemVistaFormulario where idElemFormulario=".$idElemento;
		$x++;
		if($tElemento==23)
		{
			$query="select campoConf3 from 938_configuracionElemVistaFormulario where idElemFormulario=".$idElemento;	
			$idImagen=$con->obtenerValor($query);
			$consulta[$x]="delete from 983_imagenesFormularios where idArchivo=".$idImagen;
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
	
	function generarTablaFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="select * from 900_formularios where idFormulario=".$idFormulario." for update";
			$fila=$con->obtenerPrimeraFila($consulta);
		}
	}
	
	function obtenerCamposGrid()
	{
		global $con;
		global $et;
		
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="	select cg.idGrupoCampo,ef.nombreCampo as 'etFormulario',cg.titulo,tamanoColumna as 'tamColumna',
					(case alineacionValores when 1 then '".$et["lblIzquierda"]."' when 2 then  '".$et["lblDerecha"]."'  
					when 3 then '".$et["lblCentrado"]."' when 4 then  '".$et["lblJustificado"]."' end) as alineacion,cg.orden,cg.idFuncionRenderer
					from 907_camposGrid cg,901_elementosFormulario ef where ef.idGrupoElemento=cg.idElementoFormulario and
					cg.idIdioma=ef.idIdioma and  ef.idIdioma=".$_SESSION["leng"]." and cg.idConfGrid=".$idConfiguracion;
		
		$arrCampos=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="select idElementoFormulario,titulo,tamanoColumna,(case alineacionValores when 1 then '".$et["lblIzquierda"]."' when 2 then  '".$et["lblDerecha"]."'  
					when 3 then '".$et["lblCentrado"]."' when 4 then  '".$et["lblJustificado"]."' end) as alineacion,idGrupoCampo,cg.orden,cg.idFuncionRenderer from 907_camposGrid cg where idConfGrid=".$idConfiguracion." and idElementoFormulario<0";
		$res=$con->obtenerFilas($consulta);
		
		$restoArr="";
		while($fila=$con->fetchRow($res))
		{
			
			switch($fila[0])
			{
				case "-10":
					$nomCampo='fechaCreacion';
				break;
				case "-11":
					$nomCampo='responsableCreacion';
				break;
				case "-12":
					$nomCampo='fechaModificacion';
				break;
				case "-13":
					$nomCampo='responsableModificacion';
				break;
				case "-14":
					$nomCampo='unidadUsuarioRegistro';
				break;
				case "-15":
					$nomCampo='institucionUsuarioRegistro';
				break;
				case "-16":
					$nomCampo="dtefechaSolicitud";
				break;
				case "-17":
					$nomCampo="tmeHoraInicio";
				break;
				case "-18":
					$nomCampo="tmeHoraFin";
				break;
				case "-19":
					$nomCampo="dteFechaAsignada";
				break;
				case "-20":
					$nomCampo="tmeHoraInicialAsignada";
				break;
				case "-21":
					$nomCampo="tmeHoraFinalAsignada";
				break;
				case "-22":
					$nomCampo="unidadReservada";
				break;
				case "-23":
					$nomCampo="tmeHoraSalida";
				break;
				case "-24":
					$nomCampo="idEstado";
				break;
				case "-25":
					$nomCampo="codigoRegistro";
				break;
				case "-27":
					$nomCampo="fechaSometimiento";
				break;
				case "-28":
					$nomCampo="fechaAgendaComite";
				break;
				case "-100":
					$nomCampo="Generado por funci&oacute;n";
				break;
			}
			
			$funcionRenderer=0;
			
			if($restoArr=="")
				$restoArr.="['".$fila[4]."','".$nomCampo."','".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[5]."','".$fila[6]."']";
			else
				$restoArr.=",['".$fila[4]."','".$nomCampo."','".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[5]."','".$fila[6]."']";
		}
		if($restoArr!="")
		{
			if($arrCampos!="[]")
				$restoArr=','.$restoArr."]";
			else
				$restoArr=$restoArr."]";
			
			
			$arrCampos=substr($arrCampos,0,strlen($arrCampos)-1).$restoArr;
		}
		$arrCamposTotal='';
		
		
		$consulta="SELECT idFormulario FROM 909_configuracionTablaFormularios WHERE idConfGrid=".$idConfiguracion;
		$idFormulario=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreCampo AS idCampo,nombreCampo AS nombreCampoUsr
					FROM 901_elementosFormulario e WHERE idIdioma=1 AND tipoElemento>1 AND tipoElemento NOT IN(13,17,18,19,23,29)
					AND idFormulario=".$idFormulario." 
					UNION
					SELECT campoMysql AS idCampo,etiquetaUsuario AS nombreCampo FROM 9017_camposControlFormulario";
		
		$arrCamposTotal=$con->obtenerFilasArreglo($consulta);
		
		
		
		
		$consulta="select campoOrden,direccionOrden,numRegPag,campoAgrupacion from 909_configuracionTablaFormularios where idConfGrid=".$idConfiguracion;
		$fila=$con->obtenerPrimeraFila($consulta);
		$confTabla='[{"campo":"'.$fila[0].'","direccion":"'.$fila[1].'","numReg":"'.$fila[2].'","campoAgrupacion":"'.$fila[3].'"}]';
		echo "1|".uEJ($arrCampos)."|".$confTabla."|".$arrCamposTotal;
		
	}
	
	function obtenerCamposGridDisponibles()
	{
		global $con;
		
			$idConfiguracion=$_POST["idConfiguracion"];
			$idFormulario=$_POST["idFormulario"];
			$consulta="	select idGrupoElemento,nombreCampo,tipoElemento,
						if((SELECT campoConf18 FROM 904_configuracionElemFormulario WHERE idElemFormulario=e.idGrupoElemento limit 0,1) is null,0,
							(SELECT campoConf18 FROM 904_configuracionElemFormulario WHERE idElemFormulario=e.idGrupoElemento limit 0,1)) as funcionRenderer 
						from 901_elementosFormulario e where idIdioma=".$_SESSION["leng"]." and tipoElemento>1 and tipoElemento not in(13,17,18,19,23,29)
						and idFormulario=".$idFormulario." and idGrupoElemento not in(select idElementoFormulario from 907_camposGrid cg 
						where cg.idIdioma=".$_SESSION["leng"]." and cg.idConfGrid=".$idConfiguracion.")";

			
			$arrCampos=$con->obtenerFilasArreglo($consulta);
			
			
			$consulta="select tipoFormulario,idProceso,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			
			$tipoFormulario=$filaFrm[0];
			$idProceso=$filaFrm[1];
			$nTabla=$filaFrm[2];
			
			$consulta="select idElementoFormulario from 907_camposGrid where idConfGrid=".$idConfiguracion." and idElementoFormulario<0";
			$res=$con->obtenerListaValores($consulta);
			$arrElementos=explode(',',$res);
			if($res=="")
				$res=-1;
			$consulta="SELECT tipoElemento,etiquetaUsuario,tipoElemento,'0' AS renderer FROM 9017_camposControlFormulario WHERE tipoElemento  NOT IN(".$res.")";
			$restoArr=$con->obtenerFilasArreglo($consulta);
			
			$restoArr=substr($restoArr,1);

			
			if($restoArr!="")
			{
				if($arrCampos!="[]")
					$restoArr=','.$restoArr."";
				else
					$restoArr=$restoArr."";
				
				
				$arrCampos=substr($arrCampos,0,strlen($arrCampos)-1).$restoArr;
			}
			echo "1|".uEJ($arrCampos);
		
	}
	
	function guardarConfiguracionCampo()
	{
		global $con;
		$parCampo=$_POST["objCampo"];
		$objCampo=json_decode($parCampo);
		$accion=$objCampo->accion;
		$idCampo=$objCampo->idCampo;
		$etCampo=$objCampo->etCampo;
		$anchoCol=$objCampo->anchoCol;
		$tituloCampo=$objCampo->tituloCampo;
		$idAlineacion=$objCampo->idAlineacion;
		$numTitulos=sizeof($tituloCampo);
		$idConfiguracion=$objCampo->idConfiguracion;
		
		$query="begin";
		$x=0;
		if($con->ejecutarConsulta($query))
		{
			
			
			if($accion==0)
			{
				$consulta[$x]="update 907_camposGrid set orden=orden+1 where idConfGrid=".$idConfiguracion." and orden>=".$objCampo->orden;
				$x++;
				$query="select idGridFormularioSig from 903_variablesSistema for update";
				$idGrupoCampo=$con->obtenerValor($query);
				for($ct=0;$ct<$numTitulos;$ct++)
				{
					$consulta[$x]="	insert into 907_camposGrid(idElementoFormulario,idIdioma,tamanoColumna,titulo,idGrupoCampo,
										alineacionValores,idConfGrid,orden,idFuncionRenderer,visible) values
									(".$idCampo.",".$tituloCampo[$ct]->idIdioma.",".$anchoCol.",'".cv($tituloCampo[$ct]->etiqueta).
									"',".$idGrupoCampo.",".$idAlineacion.",".$idConfiguracion.",".$objCampo->orden.",".
									$objCampo->funcionRenderer.",".$objCampo->visible.")";
					$x++;
				}
				$consulta[$x]="update 903_variablesSistema set idGridFormularioSig=idGridFormularioSig+1";
				$x++;
				
			}
			else
			{
				
				$query="SELECT idGrupoCampo FROM 907_camposGrid WHERE idCamposGrid=".$tituloCampo[0]->idCamposGrid;
				$idGrupoCampo=$con->obtenerValor($query);
				$query="SELECT idConfGrid,orden FROM 907_camposGrid WHERE idGrupoCampo=".$idGrupoCampo;
				$fCampo=$con->obtenerPrimeraFila($query);
				
				$idConfiguracion=$fCampo[0];
				$orden=$fCampo[1];

				if($orden>$objCampo->orden)
				{
					$consulta[$x]="update 907_camposGrid set orden=orden+1 where idConfGrid=".$idConfiguracion." and orden>=".$objCampo->orden." and orden<".$orden;
					$x++;
				}
				else
				{
					$consulta[$x]="update 907_camposGrid set orden=orden-1 where idConfGrid=".$idConfiguracion." and orden>=".$orden." and orden<=".$objCampo->orden;
					$x++;	
				}
				
				
				$idGrupoCampo='-1';
				for($ct=0;$ct<$numTitulos;$ct++)
				{
					$consulta[$x]="update 907_camposGrid set idFuncionRenderer=".$objCampo->funcionRenderer.",orden=".$objCampo->orden.
									",tamanoColumna=".$anchoCol.",titulo='".cv($tituloCampo[$ct]->etiqueta).
									"',alineacionValores=".$idAlineacion.",visible=".$objCampo->visible.
									" where idCamposGrid=".$tituloCampo[$ct]->idCamposGrid;
					$x++;	
				}
				
			}
			$consulta[$x]="commit";
				$x++;
			if($con->ejecutarBloque($consulta))
				echo "1|".$idGrupoCampo;
			else
				echo "|";
		}
		else
			echo "|";
		
	}
	
	function eliminarCampoConfiguracion()
	{
		global $con;
		$idGrupoCampo=$_POST["idGrupoCampo"];
		$query="SELECT idConfGrid,orden,idElementoFormulario FROM 907_camposGrid WHERE idGrupoCampo=".$idGrupoCampo;
		$fCampo=$con->obtenerPrimeraFila($query);
		
		
		$query="SELECT * FROM 909_configuracionTablaFormularios WHERE idConfGrid=".$fCampo[0];
		$fConfiguracion=$con->obtenerPrimeraFilaAsoc($query);
		$campoAgrupacion=$fConfiguracion["campoAgrupacion"];
		
		$query="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$fCampo[2];
		$nCampo=$con->obtenerValor($query);
		
		
		$idConfiguracion=$fCampo[0];
		$orden=$fCampo[1];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="update 907_camposGrid set orden=orden-1 where idConfGrid=".$idConfiguracion." and orden>".$orden;
		$x++;
		$consulta[$x]="delete from 907_camposGrid where idGrupoCampo=".$idGrupoCampo;
		$x++;
		
		$eliminaCampoAgrupacion=false;
		
		if($campoAgrupacion==$nCampo)
		{
			$consulta[$x]="UPDATE 909_configuracionTablaFormularios SET campoAgrupacion=0 WHERE idConfGrid=".$fCampo[0];
			$x++;
			$eliminaCampoAgrupacion=true;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".($eliminaCampoAgrupacion?1:0);	
			return;
		}
		echo "|";
	}
	
	function obtenerConfiguracionCampo()
	{
		global $con;
		$idGrupoCampo=$_POST["idGrupoCampo"];
		$consulta="select i.imagen,i.idIdioma,c.titulo,idCamposGrid as etiqueta from 907_camposGrid c,8002_idiomas i where i.idIdioma=c.idIdioma and idGrupoCampo=".$idGrupoCampo;
		$arrTitulos=$con->obtenerFilasArreglo($consulta);
		$consulta="select tamanoColumna,alineacionValores,visible from 907_camposGrid where idGrupoCampo=".$idGrupoCampo;
		$fila=$con->obtenerPrimeraFila($consulta);
		$tamColumna=$fila[0];
		$idAlineacion=$fila[1];
		$obj='[{"tamColumna":"'.$tamColumna.'","idAlineacion":"'.$idAlineacion.'","visible":"'.$fila[2].'","arrTitulos":'.uEJ($arrTitulos).'}]';
		echo "1|".$obj;		
	}
	
	function actualizarPosicionElemento()
	{
		global $con;
		$param=$_POST["param"];
		$obj=json_decode($param);
		$posX=$obj->posX;
		$posY=$obj->posY;
		$idElemento=$obj->idElemento;
		$consulta="update 901_elementosFormulario set posX=".$posX.",posY=".$posY." where idGrupoElemento=".$idElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarPosicionElementoVista()
	{
		global $con;
		$param=$_POST["param"];
		$obj=json_decode($param);
		$posX=$obj->posX;
		$posY=$obj->posY;
		$idElemento=$obj->idElemento;
		$consulta="update 937_elementosVistaFormulario set posX=".$posX.",posY=".$posY." where idGrupoElemento=".$idElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarRegistro($idReg="",$nTabla="")
	{
		global $con;
		if($idReg!="")
		{
			$tabla=$nTabla;
			$idRegistro=$idReg;
			$nombreCampoId="id_".$tabla;
		}
		else
		{
			$param=$_POST["param"];
			$obj=json_decode($param);
			$tabla=$obj->tabla;
			$nombreCampoId=$obj->nombreCampoId;
			$idRegistro=$obj->idRegistro;
		}
		$consulta="delete from ".$tabla." where ".$nombreCampoId."=".$idRegistro;
		
		$query="select idFormulario,funcionEliminacionRegistro from 900_formularios where nombreTabla='".$tabla."'";
		$fFormulario=$con->obtenerPrimeraFila($query);
		$idFormulario=$fFormulario[0];
		$fEliminacion=$fFormulario[1];
		if($fEliminacion!="")
		{
			$res="";
			eval('$res='.$fEliminacion.'('.$idFormulario.','.$idRegistro.');');
			if($res!="")
			{
				echo "<br>".$res;
				return;
			}
				
		}

		if($con->ejecutarConsulta($consulta))
		{
			eliminarRegistrosModulosAsoc($idFormulario,$idRegistro);
			echo "1|";
			
		}
		else
			echo "|";
	}
	
	function eliminarRegistrosModulosAsoc($idFormulario,$idRegistro,$eliminacionFisica=1)
	{
		global $con;
		$consulta="select nombreTabla,idFormulario from 900_formularios where idFrmEntidad=".$idFormulario;

		$resT=$con->obtenerFilas($consulta);
		$eliminar="";
		while($filaT=$con->fetchRow($resT))
		{
			if($filaT[0]=="")
				continue;
			
			
			
			$consulta="show fields from `".$filaT[0]."` where Field='idFormulario'";

			$fila=$con->obtenerPrimeraFila($consulta);
			$nTabla=$filaT[0];
			if($fila)
			{
				$consulta="SHOW FIELDS FROM `".$filaT[0]."` WHERE `Key`='Pri'";
				$campoLlave=$con->obtenerValor($consulta);
				if($campoLlave!="")
				{
					$consulta="select ".$campoLlave." from ".$nTabla." where idFormulario=".$idFormulario." and idReferencia=".$idRegistro; 
	
					if($eliminacionFisica==1)
						$eliminar="delete from ".$nTabla." where idFormulario=".$idFormulario." and idReferencia=".$idRegistro; 
					else
					{
						if($con->existeCampo("idEstado",$nTabla)!="")
						{
							$eliminar="update ".$nTabla." set idEstado=1984 where idFormulario=".$idFormulario." and idReferencia=".$idRegistro; 
						}
					}
				}
				else
					continue;
			}
			else
			{

				$campoLlaveTabla="id_".$nTabla;
				if($con->existeCampo($campoLlaveTabla,$nTabla)!="")
				{

					$consulta="select ".$campoLlaveTabla." from ".$nTabla." where idReferencia=".$idRegistro;
					if($eliminacionFisica==1) 
						$eliminar="delete from ".$nTabla." where idReferencia=".$idRegistro; 
					else
					{
						if($con->existeCampo("idEstado",$nTabla)!="")
						{
							$eliminar="update ".$nTabla." set idEstado=1984 where idReferencia=".$idRegistro; 
						}
					}
				}
				else
				{
					
					continue;
				}
			}
			$resAux=$con->obtenerFilas($consulta);
			while($fAux=$con->fetchRow($resAux))
			{
				eliminarRegistrosModulosAsoc($filaT[1],$fAux[0],$eliminacionFisica);
			}
			$con->ejecutarConsulta($eliminar);
			
		}
	}
	
	function contruirTabla()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		
		$consulta="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$nombreTabla=$con->obtenerValor($consulta);
		$consulta="select nombreCampo,tipoElemento,idGrupoElemento  from  901_elementosFormulario where tipoElemento>1 and idFormulario=".$idFormulario;
		$resC=$con->obtenerFilas($consulta);
		$confCampo="";
		$arrCampos="";
		while($filasC=$con->fetchRow($resC))
		{
			switch($filasC[1])
			{
				case 14:
				case 2: //pregunta cerrada-Opciones Manuales
					$confCampo="`".$filasC[0]."` varchar(30) character set utf8 collate utf8_spanish2_ci default NULL";
				break;
				case 15:
				case 3: //pregunta cerrada-Opciones intervalo
					$confCampo="`".$filasC[0]."` varchar(150) default NULL";
				break;
				case 16:
				case 4: //pregunta cerrada-Opciones tabla
					$confCampo="`".$filasC[0]."` bigint(20) default NULL";
				break;
				case 5: //Texto Corto
					$consultaConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filasC[2];
					$filaConf=$con->obtenerPrimeraFila($consultaConf);
					$confCampo="`".$filasC[0]."` varchar(".$filaConf[3].") character set utf8 collate utf8_spanish2_ci default NULL";
				break;
				case 6: //Número entero
					$confCampo="`".$filasC[0]."` int(11) default NULL";
				break;
				case 22:
				case 24:
				case 7: //Número decimal
					$confCampo="`".$filasC[0]."` decimal(16,4) NOT NULL";		
				break;
				case 8: //Fecha
					$confCampo="`".$filasC[0]."` date default NULL";
				break;
				case 9://Texto Largo 
					$confCampo="`".$filasC[0]."` longtext collate utf8_spanish2_ci";
				break;
				case 10: //Texto Enriquecido
					$confCampo="`".$filasC[0]."` longtext collate utf8_spanish2_ci";
				break;
				case 11: //Correo Electr&oacute;nico
					$consultaConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filasC[2];
					$filaConf=$con->obtenerPrimeraFila($consultaConf);
					$confCampo="`".$filasC[0]."` varchar(".$filaConf[3].") character set utf8 collate utf8_spanish2_ci default NULL";
				break;
				case 12: //Archivo
					$confCampo="`".$filasC[0]."` bigint(20) default NULL";
				break;
				case 21: //Fecha
					$confCampo="`".$filasC[0]."` time default NULL";
				break;
			}
			$arrCampos.=",".$confCampo;
			
		}
		$arrCampos.=",`idReferencia` bigint(20) default  '-1',`fechaCreacion` date default NULL, `responsable` bigint(20) default NULL,`fechaModif` date default NULL,`respModif` bigint(20) default NULL,`idEstado` decimal(10,2) default  '0'";
		$consultaTabla="create table `".$nombreTabla."`(`id_".$nombreTabla."` bigint(20) NOT NULL auto_increment".$arrCampos.", 
						PRIMARY KEY (`id_".$nombreTabla."`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
		if($con->ejecutarConsulta($consultaTabla))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerTablasBD()
	{
		global $con;
		global $et;
		$consulta="select TABLE_NAME from information_schema.TABLES where TABLE_SCHEMA='".$con->bdActual."'";
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		while($filas=$con->fetchRow($res))
		{
			$nomTabla=$filas[0];
			$arrTable= explode("_",$nomTabla);
			if(sizeof($arrTable)>1)
			{
		
				if((strtolower($arrTable[1])=='tablaDinamica')||(isset($arrTable[2])&&($arrTable[2]=="tablaDinamica")))
				{
						
				  $query="select titulo,nombreFormulario,p.nombre from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso and nombreTabla='".$nomTabla."'";
				  $filaFrm=$con->obtenerPrimeraFila($query);
				  $tipoTabla="Formulario Din&aacute;mico";
				  $nFormulario=$filaFrm[1];
   				  $nProceso=$filaFrm[2];
				  $nomTablaParaUsuario=$filaFrm[0];
				  if($nFormulario=='')
				  	$nFormulario=$nomTabla;
			  
				}
				else
				{
					$tipoTabla="Sistema";
					$nomTablaParaUsuario=$arrTable[1];
					$nFormulario="N/A";
					$nProceso="N/A";
				}
				
				$obj="['".$nomTabla."','".$nomTablaParaUsuario."','".$tipoTabla."','".$nFormulario."','".$nProceso."']";
				
				
				
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
			}
			
			
		}
		
		
		echo "1|[".uEJ($arrObj)."]";
	}
	
	function obtenerCamposTabla()
	{
		global $con;
		$tabla=$_POST["nomTabla"];
		$consulta="select COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and COLUMN_NAME NOT IN ('fechaCreacion',
					'responsable','fechaModif','respModif','idEstado','idReferencia') and TABLE_NAME='".$tabla."'";
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		$arrObjCmb="";
		while($filas=$con->fetchRow($res))
		{
			$obj="['".$filas[0]."','".$filas[1]."']";
			$objCmb="['".$filas[0]."','".$filas[0]."']";
			if($arrObj=="")
			{
				$arrObj=$obj;
				$arrObjCmb=$objCmb;
			}
			else
			{
				$arrObj.=",".$obj;
				$arrObjCmb.=",".$objCmb;
			}
			
		}
		echo "1|[".$arrObj."]|[".$arrObjCmb."]";
	}
	
	function obtenerFormularios()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idFormulario,nombreFormulario,titulo,descripcion,idProceso,formularioBase from 900_formularios where idProceso=".$idProceso." order by idProceso,tipoFormulario,nombreFormulario";
		$arrFormularios=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrFormularios);
	}
		
	function obtenerCamposSelectFormulario()
	{
		global $con;
		global $et;
		$idFormulario=$_POST["idFormulario"];
		$tabla=$_POST["tabla"];
		
		$consulta="select nombreCampo,
					(case tipoElemento when 2 then '".$et["lblOpcionesM"]."' when 3 then  '".$et["lblIntervalorO"]."'  
						when 4 then '".$et["lblTablaO"]."'  end) as tElemento	 from 901_elementosFormulario where tipoElemento in (2,3,4) and idFormulario=".$idFormulario;
		
		$arrFormularios=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="select COLUMN_NAME,COLUMN_NAME from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='".$tabla."' and COLUMN_NAME NOT IN ('fechaCreacion',
					'responsable','fechaModif','respModif','idEstado','codigoUnidad','codigoInstitucion','idReferencia')";
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		while($filas=$con->fetchRow($res))
		{
			$obj="['".$filas[0]."','".$filas[1]."']";
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		
		echo "1|".uEJ($arrFormularios)."|[".$arrObj."]";
	}
	
	function obtenerOpcionesComboDependiente()
	{
		global $con;
		global $et;
		$valorCondicion=$_POST["vCondicion"];
		$condicion=$_POST["condicion"];
		$cDestino=$_POST["cDestino"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia="-1";
		if(isset($_POST["idReferencia"]))
			$idReferencia=$_POST["idReferencia"];
		$condComp="";
		if(isset($_POST["condComp"]))
			$condComp=bD($_POST["condComp"]);
			
		$valDep="";
		if(isset($_POST["valDep"]))
			$valDep=$_POST["valDep"];
		if(($valDep!="")&&($condComp!=""))
		{
			$obj=json_decode($valDep);
			$reflectionClase = new ReflectionObject($obj);
			foreach ($reflectionClase->getProperties() as $property => $value) 
			{
				$nombre=$value->getName();
				$condComp=str_replace("@".$nombre."@",$value->getValue($obj),$condComp);
			
			}
		}
		
		$condComp=str_replace("@_codigoInstitucion_@",$_SESSION["codigoInstitucion"],$condComp);
		$condComp=str_replace("@_idUsr_@",$_SESSION["idUsr"],$condComp);
		$condComp=str_replace("@_codigoUnidad_@",$_SESSION["codigoUnidad"],$condComp);

		$consulta="select c.* from 901_elementosFormulario e,904_configuracionElemFormulario c where c.idElemFormulario=e.idGrupoElemento and e.idFormulario=".$idFormulario." and e.nombreCampo='".$cDestino."'";
		$fila=$con->obtenerPrimeraFila($consulta);
		$campoFiltro=str_replace("@idReferencia",$idReferencia,$fila[8]);
		$consulta="select ".$fila[4].",".$fila[3]." from ".$fila[2]." where ".$campoFiltro.$condicion."'".$valorCondicion."' ".$condComp." order by ".$fila[3];

		$res=$con->obtenerFilas($consulta);
		
		$opciones="['-1','".uEJ($et["lblSelOpcion"])."']";
		while($fila=$con->fetchRow($res))
		{
			if($opciones=="")
				$opciones="['".$fila[0]."','".uEJ($fila[1])."']";
			else
				$opciones.=",['".$fila[0]."','".uEJ($fila[1])."']";
		}
		echo "1|[".$opciones."]";
	}
	
	function obtenerEtapasProceso()
	{
		global $con;
		global $et;
		$idProcesoPadre=$_POST["idProcesoPadre"];
		$consulta="select idEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProcesoPadre." order by numEtapa";
		$res=$con->obtenerFilas($consulta);
		$opciones="['-1','".uEJ($et["lblSelOpcion"])."']";
		$consulta="select formularioBase from 900_formularios where formularioBase=1 and idProceso=".$idProcesoPadre;
		$procesoPrincipal=$con->obtenerValor($consulta);
		if($procesoPrincipal=="")
			$procesoPrincipal="-1";
		while($fila=$con->fetchRow($res))
		{
			if($opciones=="")
				$opciones="['".$fila[0]."','".uEJ($fila[1])."']";
			else
				$opciones.=",['".$fila[0]."','".uEJ($fila[1])."']";
		}
		echo "1|[".$opciones."]|".$procesoPrincipal;
		
	}

	function actualizarControl()
	{
		global $con;
		$accion=$_POST["accion"];
		$idControl=$_POST["idControl"];
		$valor=cv($_POST["valor"]);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select nombreCampo,idFormulario,tipoElemento from 901_elementosFormulario where idGrupoElemento=".$idControl;
		$fValor=$con->obtenerPrimeraFila($query);
		$viejoValor=$fValor[0];
		$idFormulario=$fValor[1];
		$tipoElemento=$fValor[2];
		$datosComp="";
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$tipoProceso=obtenerTipoProceso($idProceso);
		switch($accion)
		{
			case 1: //nombre
				$consulta[$x]="update 901_elementosFormulario set nombreCampo='".$valor."' where idGrupoElemento=".$idControl;
				$x++;
				$consulta[$x]="update 909_configuracionTablaFormularios set campoOrden='".$valor."' where idFormulario=".$idFormulario." and campoOrden='".$viejoValor."'";
				$x++;
				$query="select f.nombreTabla from 900_formularios f,901_elementosFormulario ef where f.idFormulario=ef.idFormulario and ef.idGrupoElemento=".$idControl;
				$nomTabla=$con->obtenerValor($query);
				if($tipoProceso!=1000)
				{
					if($con->existeTabla($nomTabla))
					{
						$query="select * from 901_elementosFormulario where idGrupoElemento=".$idControl;
						$filaConf=$con->obtenerPrimeraFila($query);
						
						switch($filaConf[3])
						{
							case 2: //pregunta cerrada-Opciones Manuales
								$confCampo=" varchar(30) character set utf8 collate utf8_spanish2_ci default NULL";
							break;
							case 3: //pregunta cerrada-Opciones intervalo
								$confCampo=" decimal(16,4) default NULL";
							break;
							case 4: //pregunta cerrada-Opciones tabla
								$confCampo=" varchar(150) default NULL";
							break;
							case 5: //Texto Corto
								$consultaConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
								$filaC=$con->obtenerPrimeraFila($consultaConf);
								$confCampo=" varchar(".$filaC[3].") character set utf8 collate utf8_spanish2_ci default NULL";
							break;
							case 6: //Número entero
								$confCampo=" int(11) default NULL";
							break;
							case 7: //Número decimal
								$confCampo=" decimal(16,4) NOT NULL";		
							break;
							case 8: //Fecha
								$confCampo=" date default NULL";
							break;
							case 9://Texto Largo 
								$confCampo=" longtext collate utf8_spanish2_ci";
							break;
							case 10: //Texto Enriquecido
								$confCampo=" longtext collate utf8_spanish2_ci";
							break;
							case 11: //Correo Electr&oacute;nico
								$consultaConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filasC[2];
								$filaConf=$con->obtenerPrimeraFila($consultaConf);
								$confCampo=" varchar(".$filaConf[3].") character set utf8 collate utf8_spanish2_ci default NULL";
							break;
							case 12: //Archivo
								$confCampo=" int(11) default NULL";
							break;
							case 14:
								$confCampo=" varchar(30) character set utf8 collate utf8_spanish2_ci default NULL";
							break;
							case 15:
								$confCampo=" int(11) default NULL";
							break;
							case 16:
								$confCampo=" int(11) default NULL";
							break;
							case 20:	
								$query="select campoConf1 from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
								$vSesion=$con->obtenerValor($query);
								switch($vSesion)
								{
									case 1:
										$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
									break;
									case 2:
										$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
									break;
									case 3:
										$confCampo=" int(11) default NULL";
									break;
									case 4:
										$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
									break;
									case 5:
										$confCampo=" varchar(60) character set utf8 collate utf8_spanish2_ci default NULL";
									break;
									case 6:
										$confCampo=" date default NULL";
									break;
									case 7:
										$confCampo=" time default NULL";
									break;
								}
								
							break;
							case 21: //Fecha
								$confCampo=" time default NULL";
							break;
							case 22: //Operacion
								$confCampo=" decimal(16,4) default NULL";
							break;
							case 24: //moena
								$confCampo=" decimal(16,4) default NULL";
							break;
							
						}
						if(($filaConf[3]!=23)&&($filaConf[3]!=30)&&($filaConf[3]!=33))
						{
							if(!(($filaConf[3]>=17)&&($filaConf[3]<=19)))
							{
								$consulta[$x]="alter table `".$con->bdActual."`.`".$nomTabla."` change `".$filaConf[7]."` `".$valor."` ".$confCampo;
								$x++;
							}
							else
							{
								$arrNomTabla=explode("_",$nomTabla);
								$query="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$idControl;
								$viejoValor=$con->obtenerValor($query);
								$confCampo="int(11) NOT NULL AUTO_INCREMENT";
								$consulta[$x]=" rename table `".$con->bdActual."`.`".$arrNomTabla[0]."_".$viejoValor."` to `".$con->bdActual."`.`".$arrNomTabla[0]."_".$valor."`" ;
								$x++;
								$consulta[$x]="alter table `".$con->bdActual."`.`".$arrNomTabla[0]."_".$valor."` change `id_".$arrNomTabla[0]."_".$viejoValor."` `id_".$arrNomTabla[0]."_".$valor."` ".$confCampo;
								$x++;
							}
						}
					}
				}
			break;
			case 2: //etiqueta
				$idIdioma=$_POST["idIdioma"];
				$consulta[$x]="update 901_elementosFormulario set nombreCampo='".$valor."' where idIdioma=".$idIdioma." and idGrupoElemento=".$idControl;
				$x++;
				
			break;
			case 3: //obligatorio
				$consulta[$x]="update 901_elementosFormulario set obligatorio=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 4: //ancho
				switch($tipoElemento)
				{
					case 2:
					case 3:
					case 4:
						$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
						$filaE=$con->obtenerPrimeraFila($query);
						//if($filaE[9]==1)
							$consulta[$x]="update 904_configuracionElemFormulario set campoConf10='".$valor."' where idElemFormulario=".$idControl;
						//else
							//$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
					break;
					case 8:
					case 21:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf10='".$valor."' where idElemFormulario=".$idControl;
					break;
					case 24:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf6='".$valor."' where idElemFormulario=".$idControl;
					break;
					default:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				}
				$x++;

			break;
			case 5: //longMax
				switch($tipoElemento)
				{
					case 9:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf4='".$valor."' where idElemFormulario=".$idControl;
						$x++;
					break;
					default:
						$query="select f.nombreTabla from 900_formularios f,901_elementosFormulario ef where f.idFormulario=ef.idFormulario and ef.idGrupoElemento=".$idControl;
						$nomTabla=$con->obtenerValor($query);
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
						$x++;
						$queryAux="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$idControl;
						$nomCampo=$con->obtenerValor($queryAux);
						$confCampo=" varchar(".$valor.") character set utf8 collate utf8_spanish2_ci default NULL";
						if($tipoProceso!=1000)
						{
							$consulta[$x]="alter table `".$con->bdActual."`.`".$nomTabla."` change `".$nomCampo."` `".$nomCampo."` ".$confCampo;
							$x++;
						}
					break;
				}
			break;
			case 6: //alto
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 7: //fechaMin
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;	
				$x++;
			break;
			case 8: //fechaMax
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 9: //tamanoArch
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 10: //tipoArch
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 11: //X
				$consulta[$x]="update 901_elementosFormulario set posX=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 12: //Y
				$consulta[$x]="update 901_elementosFormulario set posY=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 14: //nColumnas
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf8='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 15://ancho
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf10='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 16: //default
				switch($tipoElemento)
				{
					case 2:
					case 3:
					case 4:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf16='".$valor."' where idElemFormulario=".$idControl;
						$x++;
					break;
					default:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf9='".$valor."' where idElemFormulario=".$idControl;
						$x++;
					break;
				}
			break;
			case 17: //minObl
				if($valor=="0")
					$valor="-1";
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf9='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 18://varSesion
				$query="select * from 901_elementosFormulario where idGrupoElemento=".$idControl;
				$filaConf=$con->obtenerPrimeraFila($query);
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				$x++;
				if($tipoProceso!=1000)
				{
					$query="select f.nombreTabla from 900_formularios f,901_elementosFormulario ef where f.idFormulario=ef.idFormulario and ef.idGrupoElemento=".$idControl;
					$nomTabla=$con->obtenerValor($query);
					
					switch($valor)
					{
						case 1:
							$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
						break;
						case 2:
							$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
						break;
						case 3:
							$confCampo=" int(11) default NULL";
						break;
						case 4:
							$confCampo=" varchar(40) character set utf8 collate utf8_spanish2_ci default NULL";
						break;
						case 5:
							$confCampo=" varchar(60) character set utf8 collate utf8_spanish2_ci default NULL";
						break;
						case 6:
							$confCampo=" date default NULL";
						break;
						case 7:
							$confCampo=" time default NULL";
						break;
					}
					$consulta[$x]="alter table `".$con->bdActual."`.`".$nomTabla."` change `".$filaConf[7]."` `".$filaConf[7]."` ".$confCampo;
					$x++;
				}
			break;
			case 19://actualizable
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 21: //hMinima
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 22: //hMáxima
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 23: //Intervalo
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 24: //Num. decimales
				switch($tipoElemento)
				{
					case 7:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf6='".$valor."' where idElemFormulario=".$idControl;
						$x++;
					break;
					default:
						$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
						$x++;
				}
			break;
			case 25: //Separador Miles
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 26: //Separador Decimales
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 27: //Trato Decimales
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf4='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 28: //Orden control
				$query="select idFormulario,orden from 901_elementosFormulario where idGrupoElemento=".$idControl;
				$fila=$con->obtenerPrimeraFila($query);
				if($fila[1]>$valor)
					$consulta[$x]="update 901_elementosFormulario set orden=orden+1 where orden>=".$valor." and orden<".$fila[1]." and idFormulario=".$idFormulario." and tipoElemento not in(1,13,-2)";
				else
					$consulta[$x]="update 901_elementosFormulario set orden=orden-1 where orden>".$fila[1]." and orden<=".$valor." and idFormulario=".$idFormulario." and tipoElemento not in(1,13,-2)";
				$x++;
				$consulta[$x]="update 901_elementosFormulario set orden=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 29: //estilo
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf12='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 30:
				$consulta[$x]="update 901_elementosFormulario set habilitado='".$valor."' where idGrupoElemento=".$idControl;
				
				$x++;
			break;
			case 31:
				$consulta[$x]="update 901_elementosFormulario set visible='".$valor."' where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 32://vincular con lita
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf5='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 33://indicador
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf13='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 34:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf6='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 35:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf4='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 36:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf5='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 37:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf4='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 38:
				$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
				$filaE=$con->obtenerPrimeraFila($queryOpt);
				if($filaE)
					$consulta[$x]="update 904_configuracionElemFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				else
					$consulta[$x]="insert into  904_configuracionElemFormulario (idElemFormulario,campoConf1) values(".$idControl.",'".$valor."')";
				$x++;
			break;
			case 39:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 41:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 42:
				$consulta[$x]="update 901_elementosFormulario set etiquetaExportacion='".$valor."' where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 43:
				$consulta[$x]="update 901_elementosFormulario set tagXML='".$valor."' where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 44:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf18='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 45:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf8='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 46:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf9='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 47:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 48:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 49:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf3='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 50:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf16='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 51:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf14='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 52:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf15='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 53:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf13='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 54:
				$consulta[$x]="update 904_configuracionElemFormulario set campoConf21='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			switch($accion)
			{
				case 38:
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$idControl;
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$orden="";	
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
					$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idControl." and idIdioma=".$_SESSION["leng"]." ".$orden;
					//echo $queryOpt;
					$datosComp=uEJ($con->obtenerFilasArreglo($queryOpt));
				break;
				
			}
			echo "1|".$datosComp;
		}
		else
			echo "|";
		
	}
	
	function actualizarControlVista()
	{
		global $con;
		$accion=$_POST["accion"];
		$idControl=$_POST["idControl"];
		$valor=$_POST["valor"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select nombreCampo,idFormulario from 937_elementosVistaFormulario where idGrupoElemento=".$idControl;
		$fValor=$con->obtenerPrimeraFila($query);
		$viejoValor=$fValor[0];
		$idFormulario=$fValor[1];
		
		switch($accion)
		{
			case 2: //etiqueta
				$idIdioma=$_POST["idIdioma"];
				$consulta[$x]="update 937_elementosVistaFormulario set nombreCampo='".$valor."' where idIdioma=".$idIdioma." and idGrupoElemento=".$idControl;
				$x++;
			break;
			case 4: //ancho
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf1='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 6: //alto
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf2='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 11: //X
				$consulta[$x]="update 937_elementosVistaFormulario set posX=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 12: //Y
				$consulta[$x]="update 937_elementosVistaFormulario set posY=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 29: //estilo
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf12='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 37:
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf4='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 38:
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf13='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 39:
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf14='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
			case 40:
				$consulta[$x]="update 938_configuracionElemVistaFormulario set campoConf15='".$valor."' where idElemFormulario=".$idControl;
				$x++;
			break;
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
	
	
	
	function obtenerDatosComboSelect()
	{
		global $con;
		$idPregunta=$_POST["idGrupoElemento"];
			$idElemento=$_POST["idGrupoElemento"];
			$consulta="select tipoElemento,idFormulario from 901_elementosFormulario where idGrupoElemento=".$idElemento;
			$fResp=$con->obtenerPrimeraFila($consulta);
			
			$tipoElemento=$fResp[0];
			$idFormulario=$fResp[1];
			switch($tipoElemento)
			{
				case 14:
				case 2:
					$queryOpt="select '".$idElemento."' as idGrupoE , valor,contenido,if((select d.idEtapa from 911_disparadores d where d.idGrupoElemento=".$idPregunta." and d.idFormulario=".$idFormulario." and d.idValor=valor) is null,-1,(select d.idEtapa from 911_disparadores d where d.idGrupoElemento=".$idPregunta." and d.idFormulario=".$idFormulario." and d.idValor=valor)) as idEtapa from 902_opcionesFormulario where idGrupoElemento=".$idPregunta." and idIdioma=".$_SESSION["leng"]." order by contenido";
					$arrElemento=$con->obtenerFilasArreglo($queryOpt);
				break;
				case 15:
				case 3:
					$queryOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$idPregunta;		
					$filaE=$con->obtenerPrimeraFila($queryOpt);
					$arrElemento="";
					for($x=$filaE[2];$x<=$filaE[3];$x+=$filaE[4])
					{
						
						$queryAux="select d.idEtapa from 911_disparadores d where d.idGrupoElemento=".$idPregunta." and d.idFormulario=".$idFormulario." and d.idValor=".$x;

						$valorEtapa=$con->obtenerValor($queryAux);
						if($valorEtapa=="")
							$valorEtapa="-1";
						
						if($arrElemento=="")
							$arrElemento="[".$idElemento.",".$x.",".$x.",".$valorEtapa."]";
						else
							$arrElemento.=",[".$idElemento.",".$x.",".$x.",".$valorEtapa."]";
					}
					$arrElemento="[".$arrElemento."]";
				break;
				case 16:
				case 4:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idPregunta;
					$filaE=$con->obtenerPrimeraFila($consulta);
					$queryOpt="select '".$idElemento."' as idGrupoE ,".$filaE["4"].",".$filaE["3"].",if((select d.idEtapa from 911_disparadores d where d.idGrupoElemento=".$idPregunta." and d.idFormulario=".$idFormulario." and d.idValor=".$filaE["4"].") is null,-1,(select d.idEtapa from 911_disparadores d where d.idGrupoElemento=".$idPregunta." and d.idFormulario=".$idFormulario." and d.idValor=".$filaE["4"].")) as idEtapa  from ".$filaE["2"]." order by ".$filaE["3"];	
					$arrElemento=$con->obtenerFilasArreglo($queryOpt);
				break;
			}
			
			echo "1|".uEJ($arrElemento);
		
	}
	
	function guardarDisparadorEvento()
	{
		global $con;
		$param=$_POST["param"];
		$obj=json_decode($param);
		$idGrupoElemento=$obj->idGrupoElemento;
		$idFormulario=$obj->idFormulario;
		$idEtapa=$obj->idEtapa;
		$idValor=$obj->idValor;
		$x=0;
		$query="select idProceso,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$filaFrm=$con->obtenerPrimeraFila($query);
		$idProceso=$filaFrm[0];
		$tablaOrigen=$filaFrm[1];
		$query="select nombreTabla from 900_formularios where formularioBase=1 and idProceso=".$idProceso;
		$nomTabla=$con->obtenerValor($query);

		
		if($idEtapa=='-1')
		{
			$consulta[$x]="delete from 911_disparadores where idGrupoElemento=".$idGrupoElemento." and idFormulario=".$idFormulario."  and idValor=".$idValor;
			$x++;
		}
		else
		{
			$query="select idDisparador from 911_disparadores where idGrupoElemento=".$idGrupoElemento." and idFormulario=".$idFormulario."  and idValor=".$idValor;
			$idDisparador=$con->obtenerValor($query);
			if($idDisparador=="")
			{
				$consulta[$x]="insert into 911_disparadores(idGrupoElemento,idFormulario,idEtapa,idValor) values(".$idGrupoElemento.",".$idFormulario.",".$idEtapa.",".$idValor.")" ;
				$x++;
			}
			else
			{
				$consulta[$x]="update 911_disparadores set idGrupoElemento=".$idGrupoElemento.",idFormulario=".$idFormulario.",idEtapa=".$idEtapa.",idValor=".$idValor." where idDisparador=".$idDisparador;
				$x++;
			}
		}
		
		if($con->ejecutarBloque($consulta))
		{
			$cuerpo="";
			$query="select idGrupoElemento,idValor,idEtapa from 911_disparadores where idFormulario=".$idFormulario;
			$respQuery=$con->obtenerFilas($query);
			$cuerpoN="";
			$cuerpoA="";
			while($fQuery=$con->fetchRow($respQuery))
			{
				$query="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$fQuery[0];
				$nomCampo=$con->obtenerValor($query);
				$consultaCuerpoN="update ".$nomTabla." set idEstado=".$fQuery[2]." where id_".$nomTabla."=New.idReferencia;";
				$consultaCuerpoA="update ".$nomTabla." set idEstado=".$fQuery[2]." where id_".$nomTabla."=Old.idReferencia;";
				$cuerpoN.="if new.`".$nomCampo."`='".$fQuery[1]."' then ".$consultaCuerpoN." end if; ";
				$cuerpoA.="if new.`".$nomCampo."`='".$fQuery[1]."' then ".$consultaCuerpoA." end if; ";
			}
			$x=0;
			if($nomTabla!="")
			{
				$trigger1="trigger_".$tablaOrigen."_1";
				$trigger2="trigger_".$tablaOrigen."_2";
				
				$query="select TRIGGER_NAME from `INFORMATION_SCHEMA`.`TRIGGERS` where TRIGGER_SCHEMA='".$con->bdActual."' and TRIGGER_NAME='".$trigger1."'";
				$existeTrigger=$con->obtenerValor($query);
				if($existeTrigger!="")
				{
					$consulta[$x]="drop trigger /*!50032 if exists */ `".$con->bdActual."`.`".$trigger1."`;";
					$x++;
					$consulta[$x]="drop trigger /*!50032 if exists */ `".$con->bdActual."`.`".$trigger2."`;";
					$x++;
				}
				if($cuerpoN!="")
				{
					
					$queryTrigger1="CREATE 	TRIGGER `".$con->bdActual."`.`".$trigger1."` AFTER INSERT
										ON `".$con->bdActual."`.`".$tablaOrigen."` FOR EACH ROW BEGIN ".$cuerpoN."
										END;";
										
					$consulta[$x]=$queryTrigger1;
					$x++;
					
					
					$queryTrigger2="CREATE 	TRIGGER `".$con->bdActual."`.`".$trigger2."` AFTER UPDATE
										ON `".$con->bdActual."`.`".$tablaOrigen."` FOR EACH ROW BEGIN ".$cuerpoA."
										END;";
					$consulta[$x]=$queryTrigger2;
					$x++;			
				}
				if($con->ejecutarBloque($consulta))
				echo "1";
				else
					echo "|";	

			}
		}
		else
			echo "|";
	}
	
	function eliminarReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$consulta="delete from 912_reportes where idReportes=".$idReporte;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function obtenerEtapas()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by nombreEtapa";
		
			$arrValores=$con->obtenerFilasArreglo($consulta);
			echo "1|".uEJ($arrValores);
			
		
		
		
		
	}
	
	function actualizarAnchoGrid()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$ancho=$_POST["ancho"];
		$consulta="update 900_formularios set anchoGrid=".$ancho." where idFormulario=".$idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarAltoGrid()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$alto=$_POST["alto"];
		$consulta="update 900_formularios set altoGrid=".$alto." where idFormulario=".$idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarAnchoGridVista()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$ancho=$_POST["ancho"];
		$consulta="update 939_configuracionVistaFormularios set anchoGrid=".$ancho." where idFormulario=".$idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function actualizarAltoGridVista()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$alto=$_POST["alto"];
		$consulta="update 939_configuracionVistaFormularios set altoGrid=".$alto." where idFormulario=".$idFormulario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	
	function crearVista($idFormulario)
	{
		return;
	  global $con;
	  $query="select nombreTabla,idFrmEntidad from 900_formularios where idFormulario=".$idFormulario;
	  
	  $fila=$con->obtenerPrimeraFila($query);
	  $tablaFormulario=$fila[0];
	  if($con->existeTabla($tablaFormulario))
	  {
			  //Valores directos de tabla
		  $query="	select e.nombreCampo,e.tipoElemento from 901_elementosFormulario e
					  where tipoElemento not in(-1,0,1,2,4,14,16,13) and e.idFormulario=".$idFormulario." order by e.nombreCampo";
		  
		  $camposAux="id_".$tablaFormulario." as idRegistro,".$con->obtenerListaValores($query);
		
		  //valor de contenidos en otras tablas
		  $query="	select e.nombreCampo,e.idGrupoElemento,e.tipoElemento from 901_elementosFormulario e
					  where (tipoElemento=4 or tipoElemento=16)  and e.idFormulario=".$idFormulario." order by e.nombreCampo";
		  $res=$con->obtenerFilas($query);
		  $camposRefTablas="";
		  while($filas=$con->fetchRow($res))
		  {
			  $queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
			  $filaConf=$con->obtenerPrimeraFila($queryConf);
			  $tablaD=$filaConf[2];
			  $campoP=$filaConf[3];
			  $campoId=$filaConf[4];
			  $consultaRefTablas="(select tc.".$campoP." from ".$tablaD." tc where tc.".$campoId."=".$tablaFormulario.".".$filas[0].")";
			  $camposRefTablas.=",".$consultaRefTablas." as ".$filas[0];
		  }
		  //valor de opciones ingresadas por el usuario manualmente
		  $query="	select e.nombreCampo,e.idGrupoElemento,e.tipoElemento from 901_elementosFormulario e
					  where (tipoElemento=2 or tipoElemento=14)  and e.idFormulario=".$idFormulario." order by e.nombreCampo";
		
		 $res=$con->obtenerFilas($query);
		  $camposRefOpciones="";
		  while($filas=$con->fetchRow($res))
		  {
			  $consultaRefTablas="(select contenido from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[1]." and valor=".$tablaFormulario.".".$filas[0]." )";
			  $camposRefOpciones.=",".$consultaRefTablas." as ".$filas[0];
		  }
	  
	  
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select `TABLE_NAME` from `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA` = '".$con->bdActual."' and TABLE_NAME='vista_".$tablaFormulario."' and `TABLE_TYPE` = 'VIEW'";
		$vista=$con->obtenerValor($query);
		if($vista!="")
		{
			$consulta[$x]="drop view `".$con->bdActual."`.`vista_".$tablaFormulario."`";
			$x++;
		}
		
		$query="create view vista_".$tablaFormulario." as select ".$camposAux.$camposRefTablas.$camposRefOpciones." from ".$tablaFormulario;
		$consulta[$x]=str_replace(',,',',',$query);
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
		}
	  }
	}
	
	function obtenerCamposVista()
	{
		global $con;
		$tabla=$_POST["nomTabla"];
		$mostrarCampos=false;
		if(isset($_POST["mCamposSistema"]))
			$mostrarCampos=true;
		
		$arrVarSistemas="";
		$query="select TABLE_NAME from information_schema.VIEWS where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='vista_".$tabla."'";
		$existe=$con->obtenerValor($query);
		if($existe)
		{
			if(!$mostrarCampos)
			{
				$consulta="select COLUMN_NAME,COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and COLUMN_NAME NOT IN ('fechaCreacion',
							'responsable','fechaModif','respModif','idEstado','codigoUnidad','codigoInstitucion','idReferencia') and TABLE_NAME='vista_".$tabla."'";
			}
			else
			{
				$consulta="select COLUMN_NAME,COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='vista_".$tabla."'";
			}
			$tipoOrigen="1";
		}
		else
		{
			$consulta="select idFormulario from 900_formularios where nombreTabla='".$tabla."'";
			$idFormulario=$con->obtenerValor($consulta);
			if($idFormulario=="")
			{
				if(!$mostrarCampos)
				{
					$consulta="select COLUMN_NAME,COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and COLUMN_NAME NOT IN ('fechaCreacion',
							'responsable','fechaModif','respModif','idEstado','codigoUnidad','codigoInstitucion','idReferencia') and TABLE_NAME='".$tabla."'";
				}
				else
				{
					$consulta="select COLUMN_NAME,COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where TABLE_SCHEMA='".$con->bdActual."' and TABLE_NAME='".$tabla."'";
				}
				$tipoOrigen="2";
			}
			else
			{
				$consulta="	select nombreCampo,nombreCampo,
							( 
								case tipoElemento 
									when 2 then 'optM'
									when 3 then 'int'
									when 4 then 'optT'
									when 5 then 'varchar'
									when 6 then 'int'
									when 7 then 'decimal'
									when 8 then 'date'
									when 9 then 'varchar'
									when 10 then 'varchar'
									when 11 then 'varchar'
									when 14 then 'optM'
									when 15 then 'int'
									when 16 then 'optT'
									when 21 then 'time'
									when 22 then 'decimal'
									when 24 then 'decimal'
								end
							) as tipo,tipoElemento
							from 901_elementosFormulario where idFormulario=".$idFormulario." and tipoElemento not in (-2,-1,0,1,12,13,20,17,18,19)";
				$arrVarSistemas="['fechaCreacion','fechaCreacion','date','-10'],['responsable','responsableCreacion','int','-11'],
								['fechaModif','fechaModificacion','date','-12'],['respModif','responsableModificacion','int','-13'],
								['codigoUnidad','unidadUsuarioRegistro','varchar','-14'],['codigoInstitucion','institucionUsuarioRegistro','varchar','-15'],['idEstado','estado','int','-24'],['codigo','codigo','varchar','-25']";
				$tipoOrigen="3";
			}
		}
		$arrObj=$con->obtenerFilasArreglo($consulta);
		
		if($arrVarSistemas!="")
			$arrObj=substr($arrObj,0,strlen($arrObj)-1).",".$arrVarSistemas."]";
		
		echo "1|".$tipoOrigen."|".$arrObj;//1 Vista;2 tabla de sistema;3 formulariodinamico
	}
	
	function obtenerOpciones()
	{
		global $con;
		$campo=$_POST["campo"];
		$tabla=$_POST["tb"];
		
		if(strpos($campo,".")!==false)
		{
			$datosCampos=explode(".",$campo);
			$campo=$datosCampos[1];
		}
		if((!isset($_POST["tipoTabla"]))||($_POST["tipoTabla"]==1))
		{
		
			$consulta="select idFormulario from 900_formularios where nombreTabla='".$tabla."'";
			$idFormulario=$con->obtenerValor($consulta);
			
			$consulta="select idGrupoElemento,tipoElemento from 901_elementosFormulario where nombreCampo='".$campo."' and idFormulario='".$idFormulario."' and tipoElemento not in (-2,-1,0,1,13)";
			$fila=$con->obtenerPrimeraFila($consulta);
			$idGrupoElemento=$fila[0];
			$tipoElemento=$fila[1];
			switch($tipoElemento) 
			{
				case "2":
				case "14"://Opciones Manuales
					$consulta="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idGrupoElemento." order by contenido";
				break;
				case "4"://Opciones Tabla
				case "16":
					/*$idProceso=obtenerIdProcesoFormulario($idFormulario);
					$cadObj='{"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"-1","p4":"-1","p5":"-1","p6":"-1"}}';
					$paramObj=json_decode($cadObj);
					$arrQueries=resolverQueries($idFormulario,5,$paramObj,false,true);*/
					
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idGrupoElemento;
					$conf=$con->obtenerPrimeraFila($consulta);
					if(strpos($conf[2],"[")===false)
					{
						$consulta="select ".$conf[4].",".$conf[3]." from ".$conf[2]." order by ".$conf[3];
					}
					else
					{
						$consulta="select '','' from 800_usuarios where 1=2";
						//$consultaRefTablas=generarConsultaIdElementoTablaExterna($fila[0],$arrQueries,$idFormulario);
							
					}
				break;
			}
		}
		else
		{
			$consulta="select campoVinculo,campoProyeccion,tablaVinculo,complementario from 9013_relacionesTablaSistema where tablaOrigen='".$tabla."' and campoOrigen='".$campo."'";
			$filaRelacion=$con->obtenerPrimeraFila($consulta);
			$condWhere="";
			if($filaRelacion[3]!="")
				$condWhere=" where ".$filaRelacion[3];
			$consulta="SELECT ".$filaRelacion[0].",".$filaRelacion[1]."  FROM ".$filaRelacion[2].$condWhere." order by ".$filaRelacion[1];
			
		}

		
		$arr=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arr;
	}
	
	function validarQuery()
	{
		global $con;
		$condWhere=$_POST["qry"];
		$conAux=$con;
		$idConexionAlmacen=0;
		if(isset($_POST["idConexionAlmacen"]))
			$idConexionAlmacen=$_POST["idConexionAlmacen"];
			
		$tabla=$_POST["tb"];
		if($idConexionAlmacen!=0)
		{
			$conAux=generarInstanciaConector($idConexionAlmacen);
		}
		if($condWhere!='')
			$condWhere=" where ".$condWhere;
		$consulta="select * from ".$tabla." ".$condWhere." limit 0,1";

		$fila=$conAux->obtenerPrimeraFila($consulta);
		echo "1|";
		
	}
	
	function guardarMensajeAyuda()
	{
		global $con;
		$param=dvJs($_POST["param"]);
		$obj=json_decode($param);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 914_mensajesAyuda where idGrupoElemento=".$obj->idGrupoElemento;
		$x++;
		$arrMsg=$obj->arrMsg;
		$nMsg=sizeof($arrMsg);
		for($ct=0;$ct<$nMsg;$ct++)
		{
			$consulta[$x]="insert into 914_mensajesAyuda(idGrupoElemento,mensajeAyuda,idIdioma) values (".$obj->idGrupoElemento.",'".$arrMsg[$ct]->msgAyuda."',".$arrMsg[$ct]->idIdioma.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarAyuda()
	{
		global $con;
		$idGrupoElemento=$_POST["idGrupoElemento"];
		$consulta="delete from 914_mensajesAyuda where idGrupoElemento=".$idGrupoElemento;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
			
	}
	
	function obtenerAyudaControl()
	{
		global $con;
		$idGrupoElemento=$_POST["idGrupoElemento"];
		$consulta="select idIdioma,mensajeAyuda from  914_mensajesAyuda where idGrupoElemento=".$idGrupoElemento;
		$arrMsg=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrMsg;
	}
	
	function eliminarConfiguracion()
	{
		global $con;
		$idConfiguracion=$_POST["idConf"];
		$consulta="delete from 909_configuracionTablaFormularios where idConfGrid=".$idConfiguracion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarFiltroGrid()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$cadTokens=dvJs($_POST["objTokens"]);
		$roles=$_POST["idRoles"];
		$idFiltro=$_POST["idFiltro"];
		$arrRoles=explode(",",$roles);
		$objTokens=json_decode($cadTokens);
		$arrTokens=$objTokens->arrTokens;
		$ct=sizeof($arrTokens);
		$nPos=0;
		$consulta[$nPos]="begin";
		$nPos++;
		$consulta[$nPos]="delete from 917_consultasFiltroGrid where idFiltro=".$idFiltro;
		$nPos++;
		$consulta[$nPos]="delete from 915_confGridVSRol where idFiltro=".$idFiltro;
		$nPos++;
		if($idFiltro=="-1")
		{
			$query="select idFiltroSig from 903_variablesSistema";
			$idFiltro=$con->obtenerValor($query);
			$consulta[$nPos]="update 903_variablesSistema set idFiltroSig=idFiltroSig+1";
			$nPos++;
		}
		for($x=0;$x<$ct;$x++)
		{
			$consulta[$nPos]="insert into 917_consultasFiltroGrid(tokenUsuario,tokenMysql,idFiltro) values('".cv($arrTokens[$x]->tokenUsuario)."','".cv($arrTokens[$x]->tokenMysql)."',".$idFiltro.")";
			$nPos++;
		}
		$ct=sizeof($arrRoles);
		for($x=0;$x<$ct;$x++)
		{
			$consulta[$nPos]="insert into 915_confGridVSRol(idConfGrid,idRol,idFiltro) values(".$idConfiguracion.",'".$arrRoles[$x]."',".$idFiltro.")";
			$nPos++;
		}
		
		$consulta[$nPos]="commit";
		$nPos++;
		if($con->ejecutarBloque($consulta))
			echo "1|".$idFiltro;
		else
			echo "|".$idFiltro;
		
	}
	
	function obtenerUsuarios()
	{
		global $con;
		global $et;
		$datosUsr=$_POST["datosUsuario"];
		$consulta="select i.Nombre as usuario,i.idUsuario,
					if
					(
						(select unidad from 817_organigrama where codigoUnidad=a.codigoUnidad) is null,
						'".$et["lblNoDep"]."',
						(select unidad from 817_organigrama where codigoUnidad=a.codigoUnidad)
					)as unidad,
					if
					(
						(select unidad from 817_organigrama where codigoUnidad=a.Institucion) is null,
						'".$et["lblNoInst"]."',
						(select unidad from 817_organigrama where codigoUnidad=a.Institucion)
					)as institucion
					 from 802_identifica i,801_adscripcion a  where a.idUsuario=i.idUsuario and i.Nombre like '".$datosUsr."%'";
		$usuarios=$con->obtenerFilasJson($consulta);
		$numUsuarios=$con->filasAfectadas;
		$obj='{"numUsuarios":"'.$numUsuarios.'","usuarios":'.$usuarios.'}';
		echo $obj;
	}
	
	function asociarUsuariosGrid()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="select idFormulario from 909_configuracionTablaFormularios where idConfGrid=".$idConfiguracion;
		$idFormulario=$con->obtenerValor($consulta);
		$consulta="select count(idConfGrid) from 916_confGridVSUsuario where idConfGrid in(select idConfGrid from 
				909_configuracionTablaFormularios where idFormulario=".$idFormulario.") and idUsuario=".$idUsuario;
		
		$numFilas=$con->obtenerValor($consulta);
		if($numFilas==0)
		{
			$consulta="insert into 916_confGridVSUsuario(idConfGrid,idUsuario) values(".$idConfiguracion.",".$idUsuario.")";
			if($con->ejecutarConsulta($consulta))
				echo "1|1";
		}
		else
			echo "1|2";
	}
	
	function removerAsociacionUsr()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="delete from 916_confGridVSUsuario where idConfGrid=".$idConfiguracion." and idUsuario=".$idUsuario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
	}
	
	function obtenerRolesConfGrid()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$idFiltro=$_POST["idFiltro"];
		if(existeRol("'1_0'"))
			$consulta="select idRol as inputValue,nombreGrupo as boxLabel,'chkRoles' as name, 'checkbox' as xtype,(if((select idRol from 915_confGridVSRol where idFiltro=".$idFiltro." and idRol=r.idRol) is null,'false','true')) as checked  from 8001_roles r where r.idRol not in(select idRol from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idFiltro<>".$idFiltro.")  order by  nombreGrupo";
		else
			$consulta="select idRol as inputValue,nombreGrupo as boxLabel,'chkRoles' as name, 'checkbox' as xtype,(if((select idRol from 915_confGridVSRol where idFiltro=".$idFiltro." and idRol=r.idRol) is null,'false','true')) as checked  from 8001_roles r where r.idRol not in(select idRol from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idFiltro<>".$idFiltro.") and  vistosAdmin=1 order by  nombreGrupo";			
		$cadObj=$con->obtenerFilasJson($consulta);
		$cadObj=str_replace('"false"','false',$cadObj);
		$cadObj=str_replace('"true"','true',$cadObj);
		echo "1|".$cadObj;
	}
	
	function obtenerTokensFiltro()
	{
		global $con;
		$idFiltro=$_POST["idFiltro"];
		$consulta="select tokenUsuario,tokenMysql from 917_consultasFiltroGrid where idFiltro=".$idFiltro." order by idConsultaFiltroGrid" ;
		$arrTokens=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrTokens;
	}
	
	function eliminarFiltro()
	{
		global $con;
		$idFiltro=$_POST["idFiltro"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 917_consultasFiltroGrid where idFiltro=".$idFiltro;
		$x++;
		$consulta[$x]="delete from 915_confGridVSRol where idFiltro=".$idFiltro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarRegistrosRelFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$eliminacionFisica=isset($_POST["tE"])?$_POST["tE"]:1;
		
		if(eliminarRegistroFormulario($idFormulario,$idRegistro,$eliminacionFisica))
		{
			echo "1|";
			
		}
		else
			echo "|";
	}
	
	function eliminarRegistroFormulario($idFormulario,$idRegistro,$eliminacionFisica)
	{
		global $con;
		
		
					
		$query="select nombreTabla,funcionEliminacionRegistro from 900_formularios where idFormulario=".$idFormulario;
		
		$fFormulario=$con->obtenerPrimeraFila($query);
		$nomTabla=$fFormulario[0];
		$fEliminacion=$fFormulario[1];
		$consulta="";
		if($eliminacionFisica==1)
			$consulta="delete from ".$nomTabla." where id_".$nomTabla."=".$idRegistro;
		else
			$consulta="update ".$nomTabla." set idEstado=1984 where id_".$nomTabla."=".$idRegistro;	

		if($fEliminacion!="")
		{
			$res="";
			eval('$res='.$fEliminacion[1].'('.$idFormulario.','.$idRegistro.');');
			if(($res!="")&&($res!=1)&&($res!==true))
			{
				echo "<br>".$res;
				return false;
			}
				
		}

		if($con->ejecutarConsulta($consulta))
		{
			eliminarRegistrosModulosAsoc($idFormulario,$idRegistro,$eliminacionFisica);
			return true;
			
		}
			
			
		
	}
	
	function obtenerCamposFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$consulta="select nombreCampo,tipoElemento from 901_elementosFormulario where idFormulario=".$idFormulario." and tipoElemento in(1,2,3,4,6,7,14,15,16,22,24,30) order by nombreCampo";
		$resp=$con->obtenerFilas($consulta);
		$arrOpciones="";
		while($fila=$con->fetchRow($resp))
		{
			if($arrOpciones=="")
				$arrOpciones="['".generarNombre($fila[0],$fila[1])."','".$fila[0]."']";
			else
				$arrOpciones.=",['".generarNombre($fila[0],$fila[1])."','".$fila[0]."']";
		}
		echo "1|[".$arrOpciones."]";
	}
	
	function guardarEstilo()
	{
		global $con;
		$idEstilo=$_POST["idEstilo"];
		$defEstilo=$_POST["defEstilo"];
		$arrElementosEstilo=explode('{',$defEstilo);
		$nombreEst=str_replace('.','',$arrElementosEstilo[0]);
		$cuerpo=str_replace('}','',$arrElementosEstilo[1]);
		$arrElementos=explode(";",$cuerpo);
		$x=0;
		$consulta[$x]="begin";
		$x++;	
		
		if($idEstilo!="-1")
		{
			$consulta[$x]="delete from 933_elementosEstilo where idEstilo=".$idEstilo;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idEstilo;
			$x++;
		}
		else
		{
			$query="select idEstilo from 932_estilos where nombreEstilo='".$nombreEst."' and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'"; 
			$estilo=$con->obtenerValor($query);
			if($estilo!="")
			{
				echo "1|2";
				return;
			}
			$consulta[$x]="insert into 932_estilos(nombreEstilo,responsable,fechaCreacion,codigoInstitucion) values ('".$nombreEst."',".$_SESSION["idUsr"].",'".date('Y-m-d')."','".$_SESSION["codigoInstitucion"]."')";	
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		$ct=sizeof($arrElementos);
		for($y=0;$y<$ct;$y++)
		{
			if(trim($arrElementos[$y])!="")
			{
				$arrDatosPropiedad=explode(":",$arrElementos[$y]);
			
				$consulta[$x]="insert into 933_elementosEstilo(idEstilo,propiedadCss,valor) values (@idRegistro,'".trim($arrDatosPropiedad[0])."','".trim($arrDatosPropiedad[1])."')";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|1";	
		}
	}
	
	function obtenerCamposFormularioAsociado()
	{
		global $con;
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
						when 24	then 'Moneda'
						when 25	then 'Texto corto'
						when 29 then 'Grid de datos'
						when 31 then 'Campo de par&aacute;metro'
						when 33 then 'Galer&iacute;a de imagenes'
					 end
					) as tElemento 
					from  901_elementosFormulario where idFormulario=".$idFormulario." and
					tipoElemento not in(-1,0,20,-2) and idGrupoElemento not in
					(select idGrupoElementoRef from 937_elementosVistaFormulario where idFormulario=".$idFormulario." and idGrupoElementoRef is not null) order by tipoElemento
					";
		$arrElementos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElementos);
	}
	
	function agregarCamposFormularioAsociadoVista()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$campos=$_POST["campos"];
		$arrCampos=explode(",",$campos);
		$nCampos=sizeof($arrCampos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($y=0;$y<$nCampos;$y++)
		{
			$query="select * from 901_elementosFormulario where idGrupoElemento=".$arrCampos[$y];
			$resConf=$con->obtenerFilas($query);
			while($fConf=$con->fetchRow($resConf))
			{
				if(($fConf[3]=="1")||($fConf[3]=="13"))
					$nombreCampo=$fConf[7];
				else
					$nombreCampo="[".$fConf[7]."]";
					
				$idIdioma="NULL";
				if($fConf[1]!="")
					$idIdioma=$fConf[1];
				$consulta[$x]="insert into 937_elementosVistaFormulario(idIdioma,idFormulario,tipoElemento,idGrupoElemento,nombreCampo,posX,posY,orden,idGrupoElementoRef)
								values(".$idIdioma.",".$idFormulario.",".$fConf[3].",".$arrCampos[$y].",'".$nombreCampo."',".$fConf[8].",".$fConf[9].",0,".$arrCampos[$y].")";
										
				$x++;
			}
			$estilo="";
			$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$arrCampos[$y];
			$filaConf=$con->obtenerPrimeraFila($query);
			$estilo=$filaConf[13];
			if(($estilo=="")||($estilo=="Ninguno"))
				$estilo="letraFicha";
			$consulta[$x]="insert into 938_configuracionElemVistaFormulario(idElemFormulario,campoConf1,campoConf2,campoConf3,campoConf12) values(".$arrCampos[$y].",'".cv($filaConf[2])."','".cv($filaConf[3])."','".$filaConf[4]."','".$estilo."')";

			$x++;
		}
		
		$arrEstilos=array();
		$arrEstilos["campoFechaSIUGJ"]="SIUGJ_ControlEtiqueta";
		$arrEstilos["comboWrapSIUGJControl"]="SIUGJ_ControlEtiqueta";
		$arrEstilos["SIUGJ_ControlCombo"]="SIUGJ_ControlEtiqueta";
		$arrEstilos["SIUGJ_Control"]="SIUGJ_ControlEtiqueta";
		$arrEstilos["campoComboWrapSIUGJAutocompletar"]="SIUGJ_ControlEtiqueta";
		
		
		foreach($arrEstilos as $estiloBase=>$estiloNuevo)
		{
			$consulta[$x]="UPDATE 938_configuracionElemVistaFormulario SET campoConf12='".$estiloNuevo."' WHERE idElemFormulario 
							IN(SELECT idGrupoElemento FROM 937_elementosVistaFormulario WHERE idFormulario=".$idFormulario.") AND campoConf12='".$estiloBase."'";
			$x++;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function eliminarFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
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
		
		if($con->existeTabla($nTabla))
		{
			$consulta[$x]="drop table ".$nTabla;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerProyectos()
	{
		global $con;
		$cc="";
		$condWhere="";
		if(isset($_POST["cc"]))
			$cc=$_POST["cc"];
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		if($condWhere=="")
			$condWhere=" 1=1 ";
		$arrProyectos="";
		$nElemento=0;
		if($cc!="")
		{
			$consulta="select idFormulario,idReferencia from 986_vinculacionCC vc,506_centrosCosto cc where vc.centroCosto=cc.codigoCompleto and cc.codigo='".$cc."'";
			$resProyectos=$con->obtenerFilas($consulta);
			while($f=$con->fetchRow($resProyectos))
			{
				$consulta="select f.nombreTabla,p.prefijo,p.separador,idFormulario from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso and f.idFormulario=".$f[0];
				$filaFrm=$con->obtenerPrimeraFila($consulta);
				$prefijo=$filaFrm[1];
				$nombreTabla=$filaFrm[0];
				$separador=$filaFrm[2];
				$consulta="select * from ".$nombreTabla." where id_".$nombreTabla."=".$f[1];
				$fila=$con->obtenerPrimeraFila($consulta);
				if($fila)
				{
					$idProy=$fila[0];
					$nProy=$fila[9];
					$codProy=$prefijo.$separador.str_pad($idProy,5,"0",STR_PAD_LEFT);
					$consulta="select codigoCompleto,codigo from  506_centrosCosto cc,986_vinculacionCC vc where cc.codigoCompleto=vc.centroCosto and 
								vc.idFormulario=".$fila[3]." and vc.idReferencia=".$f[1];
					$fCod=$con->obtenerPrimeraFila($consulta);
					$obj='{"codigoProy":"'.$codProy.'","proyecto":"'.$nProy.'","idFormulario":"'.$fila[3].'","idReferencia":"'.$f[1].'","codCC":"'.$fCod[0].'","cveCC":"'.$fCod[1].'"}';
					if($arrProyectos=="")
						$arrProyectos=$obj;
					else
						$arrProyectos.=",".$obj;
					$nElemento++;
				}
			}
			
		}
		else
		{
			$consulta="select  f.nombreTabla,idFormulario from 900_formularios f, 4001_procesos p where p.idProceso=f.idProceso and  f.formularioBase=1 and p.idTipoProceso=3";
			$filaFrm=$con->obtenerPrimeraFila($consulta);
			
			$nombreTabla=$filaFrm[0];
			
			$consulta="select * from ".$nombreTabla;
			$resP=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($resP))
			{
				$idProy=$fila[0];
				$nProy=$fila[9];
				$prefijo="Proy";
				$codProy=$prefijo."-".str_pad($idProy,5,"0",STR_PAD_LEFT);
				$codProy=$prefijo."-".str_pad($idProy,5,"0",STR_PAD_LEFT);
				
				
				$consulta="select codigoCompleto,codigo from  506_centrosCosto cc,986_vinculacionCC vc where cc.codigoCompleto=vc.centroCosto and 
							vc.idFormulario=".$filaFrm[1]." and vc.idReferencia=".$fila[0];
				$fCod=$con->obtenerPrimeraFila($consulta);
				$obj='{"codigoProy":"'.$codProy.'","proyecto":"'.$nProy.'","idFormulario":"'.$filaFrm[1].'","idReferencia":"'.$fila[0].'","codCC":"'.$fCod[0].'","cveCC":"'.$fCod[1].'"}';
				if($arrProyectos=="")
					$arrProyectos=$obj;
				else
					$arrProyectos.=",".$obj;
				$nElemento++;
			}
		}
		echo '{"numReg":"'.$nElemento.'","registros":['.uEJ($arrProyectos).']}';		
	}
	
	function obtenerTablasBDFitro()
	{
		global $con;
		global $et;
		$conAux=NULL;
		$idConexion=0;
		if(isset($_POST["idConexion"]))
			$idConexion=$_POST["idConexion"];
		$filter=NULL;
		
		if(isset($_POST["filter"]))
		{
			$filter=$_POST["filter"];
		}
		$conAux=$con;	
		if($idConexion!=0)
		{
			
			$conAux=generarInstanciaConector($idConexion);

		}
		
		if($conAux->conexion)
		{
			echo $conAux->obtenerTablasSistemaJSON($filter);
		}
		else
			echo '{"numReg":"0","registros":[]}';
		

		
		
	}
	
	function modificarMostrarGrid()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$valor=$_POST["valor"];
		if(!isset($_POST["vista"]))
			$consulta="update 900_formularios set mostrarMarco=".$valor." where idFormulario=".$idFormulario;
		else
			$consulta="update 939_configuracionVistaFormularios set mostrarMarco=".$valor." where idFormulario=".$idFormulario;
		eC($consulta);
	}
	
	function guardarCampoDescriptivo()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$campo=$_POST["campo"];
		$consulta="update 900_formularios set campoDescriptivo='".$campo."' where idFormulario=".$idFormulario;
		eC($consulta);
	}
	
	function eliminarPerfilExportacion()
	{
		global $con;
		$x=0;
		$idPerfil=bD($_POST["idPerfil"]);
		$consulta[$x]="delete from 9008_perfilesExportacion where idPerfilExportacion=".$idPerfil;
		$x++;
		$consulta[$x]="delete from 9009_elementosPerfilesExportacion where idPerfilExportacion=".$idPerfil;
		$x++;
		eB($consulta);
	}
	
	function obtenerDTDExportacion()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$res=generarDTDExportacion($idPerfil,"-1",0);
		echo $res;
	}
	
	function generarDTDExportacion($idPerfil,$idPadre,$nivel)
	{
		global $con;
		$consulta="SELECT * FROM 9009_elementosPerfilesExportacion  WHERE idPerfilExportacion=".$idPerfil." and idPadre=".$idPadre." order by orden";
		$resElementos=$con->obtenerFilas($consulta);
		$arrArbol="";		
		while($fila=$con->fetchRow($resElementos))
		{
			$hijos=generarDTDExportacion($idPerfil,$fila[0],($nivel+1));
			$comp="";
			$expand="false";
			if($nivel<1)
				$expand="true";
			if($hijos=="[]")
				$comp="leaf:false,children:[]";
			else
				$comp="expanded:".$expand.",leaf:false,children:".$hijos;
			$icono="";
			if($idPadre!="-1")
				$icono="../images/bullet_green.png";
			else	
				$icono="../images/icon_code.gif";
			$compAttr="";
			if($fila[12]!="")
				$compAttr=" (Formato: ".$fila[12].")";
			$obj='	{
						"tipoDato":"'.$fila[13].'",
						"orden":"'.$fila[7].'",
						"allowChildren":true,
						"draggable":true,
						"icon":"'.$icono.'",
						"text":"'.$fila[3].$compAttr.'",
						"id":"'.$fila[0].'",
						"allowDrop":true,
						"editable":true,
						"ambito":"'.$fila[14].'",
						"cls":"../images/icon_code.gif",'.$comp.'
					}';		
			if($arrArbol=="")
				$arrArbol=$obj;
			else
				$arrArbol.=",".$obj;
		}
		return "[".$arrArbol."]";
	}
	
	function actualizarXMLTag()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$valor=$_POST["valor"];
		$consulta="update 9009_elementosPerfilesExportacion set tagXML='".cv($valor)."' where idElementoPerfil=".$idElemento;
		eC($consulta);
		
			
	}
	
	function removerElementoDTD()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			if(eliminarElementoXML($idElemento))
			{
				$consulta="commit";
				eC($consulta);
			}
			else
				echo "|";
		}
		else
			echo "|";
		
	}
	
	function eliminarElementoXML($idPadre)
	{
		global $con;
		$consulta="select idElementoPerfil from 9009_elementosPerfilesExportacion where idPadre=".$idPadre;
		$resElementos=$con->obtenerFilas($consulta);
		while($filaElemento=$con->fetchRow($resElementos))
		{
			if(!eliminarElementoXML($filaElemento[0]))
				return false;
		}
		$consulta="delete from 9009_elementosPerfilesExportacion where idPadre=".$idPadre;
		if($con->ejecutarConsulta($consulta))
			return true;
		
	}
	
	function agregarElementoLibre()
	{
		global $con;
		$idPadre=$_POST["idPadre"];
		$consulta="select idPerfilExportacion,idProceso from 9009_elementosPerfilesExportacion where idElementoPerfil=".$idPadre;
		$filaPadre=$con->obtenerPrimeraFila($consulta);
		$consulta="select count(idPerfilExportacion) from 9009_elementosPerfilesExportacion where idPadre=".$idPadre;
		$nElementos=$con->obtenerValor($consulta);
		$nElementos++;
		$query="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,idFormulario,tipoElemento,orden,idProceso,tipoFormulario)
							values(".$filaPadre[0].",".$idPadre.",'nuevoElemento',-1,0,0,".$nElementos.",".$filaPadre[1].",-1)";
		if($con->ejecutarConsulta($query))
		{
			$idPadre=$con->obtenerUltimoID();
			echo "1|".$idPadre;
		}
		else
			echo "|";
	}
	
	function modificarPosicionElementoDTD()
	{
		global $con;
		$nF=$_POST["nF"];
		$idPadre=$_POST["idPadre"];
		$nSigD=$_POST["nSigD"];
		$x=0;
		$query="select orden,idPadre from 9009_elementosPerfilesExportacion where idElementoPerfil=".$nF;
		$filaNF=$con->obtenerPrimeraFila($query);
		$ordenF=$filaNF[0];
		$idPadreF=$filaNF[1];
		$consulta[$x]="begin";
		$x++;
		$orden="";
		if($nSigD=="-1")
			$orden=0;
		else
		{
			$query="select orden from 9009_elementosPerfilesExportacion where idElementoPerfil=".$nSigD;
			$orden=$con->obtenerValor($query);
			
			
		}
		$consulta[$x]="update 9009_elementosPerfilesExportacion set orden=orden-1 where orden>".$ordenF." and idPadre=".$idPadreF;
		$x++;
		$consulta[$x]="update 9009_elementosPerfilesExportacion set orden=orden+1 where orden>=".$orden." and idPadre=".$idPadre;
		$x++;
		$consulta[$x]="update 9009_elementosPerfilesExportacion set orden=".$orden.",idPadre=".$idPadre." where idElementoPerfil=".$nF;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function eliminarIndicador()
	{
		global $con;
		$idIndicador=$_POST["idIndicador"];
		$consulta="delete from 9013_indicadores where idIndicador=".$idIndicador;
		eC($consulta);
	}
	
	
	function crearCampoGridFormulario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
//		varDUmp($obj);
		$posX=$obj->posX;
		$posY=$obj->posY;
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
		
			$idFormulario=$obj->idFormulario;
			$idProceso=obtenerIdProcesoFormulario($idFormulario);
			$tipoProceso=obtenerTipoProceso($idProceso);
			
			$query="select idElementoFormularioSig from 903_variablesSistema for update";
			$idPregunta=$con->obtenerValor($query);
			$query="select count(idGrupoElemento) from 901_elementosFormulario where idFormulario=".$idFormulario." and tipoElemento not in(1,13,-2,22)";
			$orden=$con->obtenerValor($query);
			$orden++;
			$nuevaTabla=$obj->idFormulario."_".cv($obj->nID);
			$consulta[$x]="insert into 901_elementosFormulario(nombreCampo,idIdioma,idFormulario,tipoElemento,idGrupoElemento,maxValorRespuesta,posX,posY,obligatorio,eliminable,orden) 
							values('".cv($obj->nID)."',1,".$idFormulario.",29,".$idPregunta.",0,".$posX.",".$posY.",0,1,".$orden.")";
			$x++;
			$consulta[$x]="	insert into 904_configuracionElemFormulario(idElemFormulario,campoConf1,campoConf2,campoConf3,campoConf4,campoConf5) 
									values(".$idPregunta.",'560','300','_".$nuevaTabla."','1','1')";
			$x++;	
			
			$arrCampos=$obj->arrCampos;
			$ctOrden=1;
			$listaCampos="";
			foreach($arrCampos as $objCampo)
			{
				$consulta[$x]="	insert into 9039_configuracionesColumnasCampoGrid(idElemento,orden,idColumna,encabezado,ancho,tipoCampo,obligatorio,tablaOriVinculada,tablaUsrVinculada,campoOriVinculado,campoUsrVinculado,
								campoOriLlave,campoUsrLlave,visible,param,pieColumna,formatoColumna,textoPie,campoDepositoPie,objComp) values(".$idPregunta.",".$ctOrden.",'".$objCampo->idCampo."','".cv($objCampo->cabecera)."',".$objCampo->ancho.",".$objCampo->tipoCampo.",".$objCampo->obligatorio.",
								'".$objCampo->tablaOriginalVinculada."','".$objCampo->tablaVinculada."','".$objCampo->campoVinculado."','".$objCampo->campoUsrVinculado."','".
								$objCampo->campoLlave."','".$objCampo->campoUsrLlave."',".$objCampo->visible.",'".bD($objCampo->param)."',".$objCampo->pieColumna.",".$objCampo->formatoColumna.",'".cv($objCampo->textoPie)."','".
								$objCampo->campoDepositoPie."','".bD($objCampo->objComp)."')";
				
				$x++;
				switch($objCampo->tipoCampo)
				{
					case "1":
						$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
					break;	
					case "2":
						$confCampo="`".$objCampo->idCampo."` decimal(10,4) default NULL";
					break;	
					case "3":
						$confCampo="`".$objCampo->idCampo."` text collate utf8_spanish2_ci default NULL";
					break;	
					case "4":
						$confCampo="`".$objCampo->idCampo."` varchar(255) default NULL";
						if($tipoProceso!=1000)
						{
							$consulta[$x]="	INSERT INTO 9013_relacionesTablaSistema(tablaOrigen,campoOrigen,tablaVinculo,campoVinculo,campoProyeccion) VALUES
											('_".$nuevaTabla."','".$objCampo->idCampo."','".$objCampo->tablaOriginalVinculada."','".$objCampo->campoLlave."','".$objCampo->campoVinculado."')";
							$x++;	
						}
					break;	
					case "5":
						$confCampo="`".$objCampo->idCampo."` decimal(16,4) default NULL";
					break;	
					case "6":
						$confCampo="`".$objCampo->idCampo."` date default NULL";
					break;	
					case "7":
						$confCampo="`".$objCampo->idCampo."` time default NULL";
					break;
					case "8":
						$confCampo="`".$objCampo->idCampo."` decimal (16,4) default NULL";
					break;
					case "10":
						$confCampo="`".$objCampo->idCampo."` varchar(255) default NULL";
					break;		
					case "11":
						$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
					break;
					case "12":
						$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
					break;	
					case "14":
						$confCampo="`".$objCampo->idCampo."` text COLLATE utf8_spanish2_ci  default NULL";
					break;	
				}
				
	
				$ctOrden++;
				if($listaCampos=="")
					$listaCampos=$confCampo;
				else
					$listaCampos.=",".$confCampo;
			}
			if($tipoProceso!=1000)
			{
				$consulta[$x]=" create table _".$nuevaTabla."(id__".$nuevaTabla." bigint(20) NOT NULL auto_increment,idReferencia bigint(20) default NULL,".$listaCampos.",
												PRIMARY KEY (id__".$nuevaTabla.")) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
				$x++;
			}
			$consulta[$x]="update 903_variablesSistema set idElementoFormularioSig=idElementoFormularioSig+1";
			$x++;
			$consulta[$x]="commit";
			$x++;
			//varDUmp($consulta);return;
			if($con->ejecutarBloque($consulta))		
			{
				echo "1|".$idPregunta;	
			}
			
			
		}
		else
			echo "|";
			
	}
	
	function obtenerConfiguracionColumnas()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$consulta="select idConfColumnaCampoGrid,idColumna,encabezado,ancho,tipoCampo,obligatorio,tablaUsrVinculada,tablaOriVinculada,campoOriVinculado,campoUsrVinculado,campoUsrLLave,campoOriLlave,visible,orden,param,pieColumna,formatoColumna,
					textoPie,campoDepositoPie,objComp
					from 9039_configuracionesColumnasCampoGrid where idElemento=".$idElemento." order by orden";
		$arrOpciones=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ(str_replace("|","___",$arrOpciones));
	}
	
	function agregarColumnaCampoGrid()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$objCampo=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$confCampo="";
		$query="SELECT idFormulario FROM 901_elementosFormulario WHERE  idGrupoElemento=".$objCampo->idElemento;
		$idFormulario=$con->obtenerValor($query);
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$tipoProceso=obtenerTipoProceso($idProceso);
		switch($objCampo->tipoCampo)
		{
			case "1":
				$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
			break;	
			case "2":
				$confCampo="`".$objCampo->idCampo."` decimal(10,4) default NULL";
			break;	
			case "3":
				$confCampo="`".$objCampo->idCampo."` text collate utf8_spanish2_ci default NULL";
			break;	
			
			case "4":
				$confCampo="`".$objCampo->idCampo."` varchar(100) collate utf8_spanish2_ci default NULL";
				if($tipoProceso!=1000)
				{
					$consulta[$x]="	INSERT INTO 9013_relacionesTablaSistema(tablaOrigen,campoOrigen,tablaVinculo,campoVinculo,campoProyeccion) VALUES
									('".$objCampo->tablaOriginalVinculada."','".$objCampo->idCampo."','".$objCampo->tablaOriginalVinculada."','".$objCampo->campoLlave."','".$objCampo->campoVinculado."')";
					$x++;	
				}
			break;	
			case "5":
				$confCampo="`".$objCampo->idCampo."` decimal(16,4) default NULL";
			break;	
			case "6":
				$confCampo="`".$objCampo->idCampo."` date default NULL";
			break;	
			case "7":
				$confCampo="`".$objCampo->idCampo."` time default NULL";
			break;	
			case "8":
				$confCampo="`".$objCampo->idCampo."` decimal (16,4) default NULL";
			break;	
			case "10":
				$confCampo="`".$objCampo->idCampo."` varchar(100) collate utf8_spanish2_ci default NULL";
			break;
			case "11":
				$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
			break;
			case "12":
				$confCampo="`".$objCampo->idCampo."` int(11) default NULL";
			break;
			case "13":
				$confCampo="`".$objCampo->idCampo."` varchar(10) collate utf8_spanish2_ci default NULL";
			break;
			case "14":
				$confCampo="`".$objCampo->idCampo."` text collate utf8_spanish2_ci default NULL";
			break;
			
		}
		
		$objComp="";
		if(isset($objCampo->objComp))
			$objComp=$objCampo->objComp;
		if($objCampo->idRegistroCampo=="-1")
		{
			$query="select campoConf3 from 904_configuracionElemFormulario where idElemFormulario=".$objCampo->idElemento;
			$nTabla=$con->obtenerValor($query);
			$query="select max(orden) from 9039_configuracionesColumnasCampoGrid where idElemento=".$objCampo->idElemento;
			$ctOrden=$con->obtenerValor($query);
			if($ctOrden=="")
				$ctOrden=1;
			else
				$ctOrden++;
			
			$consulta[$x]="	insert into 9039_configuracionesColumnasCampoGrid(idElemento,orden,idColumna,encabezado,ancho,tipoCampo,obligatorio,tablaOriVinculada,tablaUsrVinculada,campoOriVinculado,campoUsrVinculado,
									campoOriLlave,campoUsrLlave,visible,param,pieColumna,formatoColumna,textoPie,campoDepositoPie,objComp) values(".$objCampo->idElemento.",".$ctOrden.",'".$objCampo->idCampo."','".cv($objCampo->cabecera)."',".$objCampo->ancho.",".$objCampo->tipoCampo.",".$objCampo->obligatorio.",
									'".$objCampo->tablaOriginalVinculada."','".$objCampo->tablaVinculada."','".$objCampo->campoVinculado."','".$objCampo->campoUsrVinculado."','".$objCampo->campoLlave."','".$objCampo->campoUsrLlave."',".
									$objCampo->visible.",'".bD($objCampo->param)."',".$objCampo->pieColumna.",".$objCampo->formatoColumna.",'".cv($objCampo->textoPie)."','".$objCampo->campoDepositoPie."','".bD($objComp)."')";
			$x++;	
			
			if($tipoProceso!=1000)
			{
				$consulta[$x]="alter table ".$nTabla." add column ".$confCampo;
				$x++;
			}
		}
		else
		{
			$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$objCampo->idElemento;
			$filaConfElem=$con->obtenerPrimeraFila($query);
			$query="select * from 9039_configuracionesColumnasCampoGrid where idConfColumnaCampoGrid=".$objCampo->idRegistroCampo;
			$filaCampo=$con->obtenerPrimeraFila($query);
			$consulta[$x]="update 9039_configuracionesColumnasCampoGrid set objComp='".bD($objComp)."',idColumna='".$objCampo->idCampo."',encabezado='".cv($objCampo->cabecera)."',ancho=".$objCampo->ancho.",tipoCampo=".$objCampo->tipoCampo.",obligatorio=".$objCampo->obligatorio.
						",tablaOriVinculada='".$objCampo->tablaOriginalVinculada."',tablaUsrVinculada='".$objCampo->tablaVinculada."',campoOriVinculado='".$objCampo->campoVinculado."',campoUsrVinculado='".$objCampo->campoUsrVinculado."',
						campoOriLlave='".$objCampo->campoLlave."',campoUsrLlave='".$objCampo->campoUsrLlave."',visible=".$objCampo->visible.",
						param='".bD($objCampo->param)."',pieColumna=".$objCampo->pieColumna.",formatoColumna=".$objCampo->formatoColumna.",textoPie='".cv($objCampo->textoPie)."',campoDepositoPie='".$objCampo->campoDepositoPie."'  where idConfColumnaCampoGrid=".$objCampo->idRegistroCampo;
			$x++;
			if($tipoProceso!=1000)
			{
				if($filaCampo[6]!=$objCampo->tipoCampo)
				{		
					if($filaCampo[6]==4)
					{
						
						$consulta[$x]="delete from 9013_relacionesTablaSistema where tablaOrigen='".$filaConfElem[4]."' and campoOrigen='".$filaCampo[12]."'";
						$x++;	
						
					}	
				}
				else
				{
					if(($filaCampo[6]==4)&&(($filaCampo[8]!=$objCampo->tablaOriginalVinculada)||($filaCampo[10]!=$objCampo->campoVinculado)||($filaCampo[12]!=$objCampo->campoLlave)))
					{
						
						$consulta[$x]="delete from 9013_relacionesTablaSistema where tablaOrigen='".$filaConfElem[4]."' and campoOrigen='".$filaCampo[12]."'";
						$x++;	
						$consulta[$x]="	INSERT INTO 9013_relacionesTablaSistema(tablaOrigen,campoOrigen,tablaVinculo,campoVinculo,campoProyeccion) VALUES
												('".$filaConfElem[4]."','".$objCampo->idCampo."','".$objCampo->tablaOriginalVinculada."','".$objCampo->campoLlave."','".$objCampo->campoVinculado."')";
						$x++;
						
					}
				}
			
				if(($filaCampo[6]!=$objCampo->tipoCampo)||($filaCampo[3]!=$objCampo->idCampo))
				{
					$consulta[$x]="ALTER TABLE `".$filaConfElem[4]."` CHANGE `".$filaCampo[3]."` ".$confCampo;
					$x++;
				}
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($objCampo->idRegistroCampo==-1)
				$objCampo->idRegistroCampo=$con->obtenerUltimoID();
			echo "1|".$objCampo->idRegistroCampo;
		}
	}
	
	function removerColumnaCampoGrid()
	{
		global $con	;
		
		$idRegistroCampo=$_POST["idRegistroCampo"];
		$query="select * from 9039_configuracionesColumnasCampoGrid where idConfColumnaCampoGrid=".$idRegistroCampo;

		$filaCampo=$con->obtenerPrimeraFila($query);
		
		$query="select * from 904_configuracionElemFormulario where idElemFormulario=".$filaCampo[1];

		$filaConfElem=$con->obtenerPrimeraFila($query);
		
		$query="SELECT idFormulario FROM 901_elementosFormulario WHERE  idGrupoElemento=".$filaCampo[1];
		$idFormulario=$con->obtenerValor($query);
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$tipoProceso=obtenerTipoProceso($idProceso);
		
		$nTabla=$filaConfElem[4];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9039_configuracionesColumnasCampoGrid where idConfColumnaCampoGrid=".$idRegistroCampo;
		$x++;
		if($tipoProceso!=1000)
		{
			$consulta[$x]="alter table ".$nTabla." drop column `".$filaCampo[3]."`";
			$x++;
		
			if($filaCampo[6]=="4")
			{
				$consulta[$x]="delete from 9013_relacionesTablaSistema where tablaOrigen='".$nTabla."' and campoOrigen='".$filaCampo[12]."'";
				$x++;		
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarListadoEnlaces()
	{
		global $con;
		$tEnlace=$_POST["tEnlace"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$idEnlace=$obj->idEnlace;
		$idFormulario=$obj->idFormulario;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($idEnlace=="-1")
		{
			$consulta[$x]="INSERT INTO 9040_listadoEnlaces(idFormulario,tipoEnlace,titulo,enlace,descripcion,formaApertura,tipoReferencia)
							VALUES(".$obj->idFormulario.",".$tEnlace.",'".cv($obj->titulo)."','".cv($obj->enlace)."','".cv($obj->descripcion)."',".$obj->fApertura.",".$obj->tipoReferencia.")";
			$x++;
			if($con->ejecutarBloque($consulta))
			{
				$idEnlace=$con->obtenerUltimoID();
				$x=0;
				$consulta=array();
			}
			else
			{
				echo "|";
				return;
			}
		}
		else
		{
			$consulta[$x]="update 9040_listadoEnlaces set titulo='".cv($obj->titulo)."',enlace='".cv($obj->enlace)."',descripcion='".cv($obj->descripcion)."',formaApertura=".$obj->fApertura."
							where idEnlace=".$idEnlace;

			$x++;
		}
		$consulta[$x]="delete from 9041_parametrosEnlaces where idEnlace=".$idEnlace;
		$x++;
		$arrParam=$obj->arrParam;
		foreach($arrParam as $param)
		{
			$consulta[$x]="insert into 9041_parametrosEnlaces(idEnlace,parametro,tipoValor,valor) values(".$idEnlace.",'".$param->parametro."',".$param->tipo.",".$param->valor.")";
			$x++;	
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select idEnlace,titulo,enlace,descripcion,tipoReferencia from 9040_listadoEnlaces where idFormulario=".$idFormulario." and tipoEnlace=".$tEnlace." order by titulo";
			$arrEnlaces=$con->obtenerFilasArreglo($query);
			echo "1|".uEJ($arrEnlaces);
			
		}
		
	}
	
	function obtenerListadoEnlaces()
	{
		global $con;
		$tEnlace=$_POST["tEnlace"];
		$idFormulario=$_POST["idFormulario"];
		$query="select idEnlace,titulo,enlace,descripcion,tipoReferencia from 9040_listadoEnlaces where idFormulario=".$idFormulario." and tipoEnlace=".$tEnlace." order by titulo";
		$arrEnlaces=$con->obtenerFilasArreglo($query);
		echo "1|".uEJ($arrEnlaces);
			
	}
	
	function eliminarEnlace()
	{
		global $con;
		$idEnlace=$_POST["idEnlace"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9040_listadoEnlaces where idEnlace in(".$idEnlace.")";
		$x++;
		$consulta[$x]="delete from 9041_parametrosEnlaces where idEnlace in (".$idEnlace.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerConfEnlace()
	{
		global $con;
		$idEnlace=$_POST["idEnlace"];
		$consulta="select * from 9040_listadoEnlaces where idEnlace=".$idEnlace;
		$filaEnlace=$con->obtenerPrimeraFila($consulta);
		$consulta="select idParametro,parametro,tipoValor,valor from 9041_parametrosEnlaces where idEnlace=".$idEnlace." order by parametro";
		$arrParametros=$con->obtenerFilasArreglo($consulta);
		$cadObj='	{
						"txtTitulo":"'.$filaEnlace[1].'",
						"txtEnlace":"'.$filaEnlace[2].'",
						"txtDescripcion":"'.$filaEnlace[3].'",
						"formaApertura":"'.$filaEnlace[4].'",
						"arrParametros":'.$arrParametros.'
					}';
		echo "1|".uEJ($cadObj);		
		
	}
	
	function obtenerListadoReportes()
	{
		global $con;
		global $urlSitio;
		$consulta="SELECT idReporte,nombreReporte,descripcion,date_format(fechaCreacion,'%d/%m/%Y') as fechaCreacion FROM 9010_reportesThot";
		$resReportes=$con->obtenerFilas($consulta);
		$arrReportes="";
		while($filaReporte=$con->fetchRow($resReportes))
		{
			$arrParametros="";
			$consulta="SELECT parametro FROM 9015_parametrosReporte WHERE idReporte=".$filaReporte[0];
			$resParam=$con->obtenerFilas($consulta);
			$arrParametros="";
			while($fParam=$con->fetchRow($resParam))
			{
				$obj="['-1','".$fParam[0]."','','']";
				if($arrParametros=="")
					$arrParametros=$obj;
				else
					$arrParametros.=",".$obj;
			}
			
			
			$urlReporte=$urlSitio."/thotReporter/thotVisor.php?r=".bE($filaReporte[0])."&cPagina=sFrm=true";
			$obj="['".$filaReporte[0]."','".$filaReporte[1]."','".$filaReporte[2]."','".$filaReporte[3]."','".bE("[".$arrParametros."]")."','".bE($urlReporte)."']";
			if($arrReportes=="")
				$arrReportes=$obj;
			else
				$arrReportes.=",".$obj;
				
		}
		
		
		echo "1|[".uEJ($arrReportes)."]";
		
	}
	
	function modificarConfiguracionFecha()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$consulta="update 904_configuracionElemFormulario set campoConf1='".cv(bD($obj->fechaMin))."',campoConf2='".cv(bD($obj->fechaMax))."',campoConf3='".$obj->diasSel."' where idElemFormulario=".$obj->idElemento;
		eC($consulta);
	}
	
	function cargarOpcionesElemento()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idElemento." and idIdioma=".$_SESSION["leng"]." ";
		$arrDatos=$con->obtenerFilasArreglo($queryOpt);
		echo "1|".uEJ($arrDatos);
	}
	
	function guardarOpcionesElementoManual()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 902_opcionesFormulario WHERE idGrupoElemento=".$idElemento;
		$x++;
		foreach($obj->opciones as $opcion)
		{
		
			foreach($opcion->columnas as $columna)
			{
				$consulta[$x]="INSERT INTO 902_opcionesFormulario(contenido,valor,idIdioma,idGrupoElemento) VALUES ('".$columna->texto."','".$opcion->vOpcion."',".$columna->idLeng.",".$idElemento.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$orden="";
			$queryAux="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
			$filaE=$con->obtenerPrimeraFila($queryAux);
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
			$queryOpt="select valor,contenido from 902_opcionesFormulario where idGrupoElemento=".$idElemento." and idIdioma=".$_SESSION["leng"]." ".$orden;
			$arrDatos=$con->obtenerFilasArreglo($queryOpt);
			echo "1|".uEJ($arrDatos);	
		}
	}
	
	function cargarDatosIntervalo()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$queryAux="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
		$filaE=$con->obtenerPrimeraFila($queryAux);
		$cadObj='[{"inicio":"'.$filaE[2].'","fin":"'.$filaE[3].'","intervalo":"'.$filaE[4].'"}]';
		echo "1|".$cadObj;
	}
	
	function guardarModificacionIntervalo()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="update 904_configuracionElemFormulario set campoConf1='".$obj->inicio."',campoConf2='".$obj->fin."',campoConf3='".$obj->intervalo."' where idElemFormulario=".$idElemento;
		if($con->ejecutarConsulta($consulta))	
		{
			$arrDatos=generarIntervaloNumeros($obj->inicio,$obj->fin,$obj->intervalo);
			echo "1|".$arrDatos;	
		}
	}
	
	function obtenerConfiguracionElemento()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$queryAux="select * from 904_configuracionElemFormulario where idElemFormulario=".$idElemento;
		$filaE=$con->obtenerPrimeraFila($queryAux);
		$idAlmacen=str_replace(']',"",str_replace('[',"",$filaE[2]));
		$campos=$filaE[3];
		$columnaId=$filaE[4];
		$columnaTooltip=$filaE[20];
		$autoCompletable=$filaE[9];
		$campoBusqueda=$filaE[10];
		$arrCampos=explode('@@',$campos);
		$listUsuario='';
		$listApp='';

		foreach($arrCampos as $campo)
		{
			if(strpos($campo,"_")===false)
			{
				if($listUsuario=='')
				{
					$listUsuario='"'.$campo.'"';
					$listApp='"'.$campo.'"';
				}
				else
				{
					$listUsuario.=',"'.$campo.'"';
					$listApp.=',"'.$campo.'"';
				}
			}
			else
			{
				$arrCampo=explode("_",$campo);
				if($listUsuario=='')
				{
					
					if(substr($campo,0,1)=='_')
						$listUsuario='"'.ucfirst($arrCampo[2]).'"';
					else
						$listUsuario='"'.ucfirst($arrCampo[1]).'"';
					$listApp='"'.$campo.'"';
				}
				else
				{
					if(substr($campo,0,1)=='_')
						$listUsuario.=',"'.ucfirst($arrCampo[2]).'"';
					else
						$listUsuario.=',"'.ucfirst($arrCampo[1]).'"';
					$listApp.=',"'.$campo.'"';
				}	
			}
		}
		
		$objCampos='{"listUsuario":['.$listUsuario.'],"listApp":['.$listApp.']}';
		
		$obj='[{"idAlmacen":"'.$idAlmacen.'","camposProy":'.$objCampos.',"columnaId":"'.$columnaId.'","columnaTooltip":"'.$columnaTooltip.'","autoCompletable":"'.$autoCompletable.'","campoBusqueda":"'.$campoBusqueda.'"}]';
		echo "1|".$obj;
		
	}
	
	function guardarModificacionComboAlmacen()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="";
		switch($obj->tipoElemento)
		{
			case "4":
				
				$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf19='".$obj->cTooltip."',campoConf2='".cv($obj->columna)."',campoConf3='".cv($obj->cLlave)."',campoConf8='".$obj->autocompletar."',campoConf9='".$obj->cBusqueda."' where idElemFormulario=".$obj->idElemento;
				$x++;
				
				if($obj->autocompletar==2)
				{
					$consulta="SELECT nombreCampo,idFormulario FROM 901_elementosFormulario WHERE idGrupoElemento=".$obj->idElemento;
					$fFormulario=$con->obtenerPrimeraFila($consulta);
					
					$nombreCampo=$fFormulario[0];
					$nombreTabla="_".$fFormulario[1]."_grid".ucfirst($nombreCampo);
					if(!$con->existeTabla($nombreTabla))
					{
						$query[$x]=" create table ".$nombreTabla."(id_".$nombreTabla." bigint(20) NOT NULL auto_increment,idPadre bigint(20) default NULL,
												idOpcion varchar(30) character set utf8 collate utf8_spanish2_ci default NULL,
												PRIMARY KEY (id_".$nombreTabla.")) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
								
						$x++;
					}
				}
				
			break;
			case "16":
				$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf19='".$obj->cTooltip."',campoConf2='".cv($obj->columna)."',campoConf3='".cv($obj->cLlave)."' where idElemFormulario=".$obj->idElemento;
				$x++;
			break;
			case "19":
				$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf19='".$obj->cTooltip."',campoConf2='".cv($obj->columna)."',campoConf3='".cv($obj->cLlave)."' where idElemFormulario=".$obj->idElemento;
				$x++;
			break;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerCategoriasCalculos()
	{
		global $con;
		
		$arreglo="[]";
		
		$consulta="SELECT idCategoriaConcepto,nombreCategoria FROM  991_categoriasConcepto ORDER BY nombreCategoria";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arreglo;
	}
	
	function obtenerCalculosCategorias()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$arreglo="[]";
		$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE tipoConsulta=3 and idTipoConcepto=".$idCategoria." ORDER BY nombreConsulta";
		$resCal=$con->obtenerFilas($consulta);
		$arreglo="";
		while($f=$con->fetchRow($resCal))
		{
			$consulta="SELECT parametro,'' as p1,'' as p2,'' as p3 FROM 993_parametrosConsulta WHERE idConsulta=".$f[0];
			$arrParam=$con->obtenerFilasArreglo($consulta);
			$obj="['".$f[0]."','".$f[1]."','".cv($arrParam)."']";
			if($arreglo=="")
				$arreglo=$obj;
			else
				$arreglo.=",".$obj;
		}
		echo "1|[".$arreglo."]";
	}
	
	function tienePatrametrosCalculo()
	{
		global $con;
		$idCalculo=$_POST["idCalculo"];
		
		$arreglo="";
		$consulta="SELECT idParametro,parametro FROM 993_parametrosConsulta WHERE idConsulta=".$idCalculo;
		$res=$con->obtenerFilas($consulta);
		$nfilas=$con->filasAfectadas;
		if($nfilas>0)
		{
			while($fila=$con->fetchRow($res))
			{
				$conParametros="SELECT parametro,valor,idTipoValor FROM 999_parametrosVSCalculoGrid g,993_parametrosConsulta p
								WHERE g.idParametro=p.idParametro AND idConsulta=".$idCalculo;
				$filaR=$con->obtenerPrimeraFila($conParametros);				
				if($filaR)
				{
					$valor=$filaR[2];
					$idTipoValor=$filaR[3];
				}
				else
				{
					$valor=0;
					$idTipoValor=0;
				}
				
				$obj="['".$fila[1]."','','','']";
				if($arreglo=="")
					$arreglo=$obj;
				else
					$arreglo.=",".$obj;
			}
		
		}
		$arreglo="[".$arreglo."]";
		//$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$nfilas."|".$arreglo;
	}
	
	function resolverQueriesControl()
	{
		global $con;	
		$cadObj=$_POST["aQ"];
		$obj=json_decode($cadObj);
		$arrObj='';

		$fRegistro=NULL;
		$cargaAutomaticaFormulario=$obj->cargaAutomaticaFormulario;
		if($cargaAutomaticaFormulario==1)
		{
			$consulta="select * from _".$obj->idFormulario."_tablaDinamica where id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;	
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		}		
		
		
		foreach($obj->aQueries as $q)
		{
			$consulta=$q;
			$query="SELECT idConexion FROM 9014_almacenesDatos WHERE idDataSet=".$q->idQuery;
			$idConexion=$con->obtenerValor($query);
			$conAux=$con;
			if($idConexion!=0)
				$conAux=generarInstanciaConector($idConexion);
			

			$resQuery=$conAux->obtenerFilas(bD($q->qy));
			
			
			foreach($q->arrControles as $ctrl)
			{
				
				$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$ctrl->idCtrl;
				$filaE=$con->obtenerPrimeraFila($consulta);
				$objConf="";
				$arrElemento='""';
				$valorCampo="";
				switch($ctrl->tipoCtrl)
				{
					case 4:
					case 16:
					case 19:
						if($fRegistro && ($con->existeCampo($ctrl->nomCtrlOriginal,"_".$obj->idFormulario."_tablaDinamica")))
						{
							$valorCampo=$fRegistro[$ctrl->nomCtrlOriginal];
						}
						$arrCamposProy=explode('@@',$filaE[3]);
						$campoId=$filaE[4];
						$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"1","imprimir":"0","campoID":"'.$campoId.'"}';

						
						$objFormato=json_decode($cadObj);
						
						$conAux->inicializarRecurso($resQuery);	
						
						$objFormato->resQuery=$resQuery;
						$objFormato->idAlmacen=$q->idQuery;
						
						$objFormato->arrCamposProy=$arrCamposProy;
						$objFormato->itemSelect="";
						
						$objFormato->conector=$conAux;
						
						$arrElemento="[".generarFormatoOpcionesQuery($objFormato)."]";
					break;
					case 5:
					case 6:
                    case 7:
					case 8:
                    case 9:
                    case 11:
					case 21:
                    case 24:
					
						
						$cadCampos=$filaE[3];
						if(($ctrl->tipoCtrl==5)||($ctrl->tipoCtrl==6)||($ctrl->tipoCtrl==7)||($ctrl->tipoCtrl==11)||($ctrl->tipoCtrl==24)||($ctrl->tipoCtrl==8)||($ctrl->tipoCtrl==21))
						{
							$cadCampos=$filaE[5];
							$objElemento=json_decode($cadCampos);
							$cadCampos=$objElemento->campo;
							
						}
						else
							if($ctrl->tipoCtrl==9)
							{
								$cadCampos=$filaE[6];
								$objElemento=json_decode($cadCampos);
								$cadCampos=$objElemento->campo;
							}
						$arrCamposProy=explode('@@',$cadCampos);
						$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"5","imprimir":"0","campoID":""}';
						$objFormato=json_decode($cadObj);
						$conAux->inicializarRecurso($resQuery);	
						$objFormato->resQuery=$resQuery;
						$objFormato->idAlmacen=$q->idQuery;
						$objFormato->arrCamposProy=$arrCamposProy;
						$objFormato->itemSelect="-1";
						$objFormato->conector=$conAux;
						$arrElemento='"'.generarFormatoOpcionesQuery($objFormato).'"';
					break;
					case 30:
						
						$cadCampos=$filaE[3];
						
						$arrCamposProy=explode('@@',$cadCampos);
						$cadObj='{"conector":null,"resQuery":null,"idAlmacen":"","arrCamposProy":[],"formato":"6","imprimir":"0","campoID":""}';
						$objFormato=json_decode($cadObj);
						$conAux->inicializarRecurso($resQuery);	
						$objFormato->resQuery=$resQuery;
						$objFormato->idAlmacen=$q->idQuery;
						$objFormato->arrCamposProy=$arrCamposProy;
						$objFormato->itemSelect="-1";
						$objFormato->conector=$conAux;
						$arrElemento='"'.generarFormatoOpcionesQuery($objFormato).'"';
					break;
				}
				$objConf='{"valorCampo":"'.cv($valorCampo).'","controlOriginal":"'.$ctrl->nomCtrlOriginal.'","control":"'.$ctrl->nomCtrlFrm.'","tipoCtrl":"'.$ctrl->tipoCtrl.'","valor":'.$arrElemento.'}';
				if($arrObj=="")
					$arrObj=$objConf;
				else
					$arrObj.=",".$objConf;
				
			}
		}
		echo '1|{"resultado":['.$arrObj.']}';
	}
	
	
	function obtenerMacroProcesosDisponibles()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT idMacroProceso,macroProceso FROM 810_macroProcesos WHERE idMacroProceso NOT IN 
					(
						SELECT idMacroProceso FROM 810_macroprocesosVSProcesos WHERE idProceso=".$idProceso."
					)";
		$arrMacro=$con->obtenerFilasArreglo($consulta);					
		echo "1|".$arrMacro;
			
	}
	
	function guardarProcesoMacro()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idMacroProceso=$_POST["idMacroProceso"];
		$leyenda=$_POST["leyenda"];
		$consulta="insert into 810_macroprocesosVSProcesos(idMacroProceso,idProceso,leyenda)
					VALUES(".$idMacroProceso.",".$idProceso.",'".cv($leyenda)."')";
					
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT m.idMacroProceso,macroProceso,leyenda FROM 810_macroprocesosVSProcesos m,810_macroProcesos ma WHERE ma.idMacroProceso=m.idMacroProceso AND idProceso=".$idProceso;
			$arrMacro=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrMacro;
		}
		
	}
	
	function removerProcesoMacro()
	{
		global $con;
		$idProceso=$_POST["idProceso"]	;
		$idMacroProceso=$_POST["idMacroProceso"];
		$consulta="delete from 810_macroprocesosVSProcesos where idMacroProceso=".$idMacroProceso." and idProceso=".$idProceso;
		eC($consulta);
	}
	
	function guardarMensajeEnvio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;


		if($obj->idMensaje==-1)
		{
			$consulta[$x]="INSERT INTO 2011_mensajesEnvio(nombreMensaje,descripcion,fechaCreacion,idUsuarioResp,idCategoria,asunto,arrValoresCuerpo,arrDestinatarios,arrCC,arrCCO,documentosAdjuntos,arrRemitente) 
						VALUES('".cv($obj->titulo)."','".cv($obj->descripcion)."','".date("Y-m-d H:i")."',".
						$_SESSION["idUsr"].",".$obj->categoria.",'".cv($obj->asunto)."','".cv(bD($obj->arrValoresCuerpo))."','".cv(bD($obj->arrDestinatario))."','".cv(bD($obj->arrCC))."','".cv(bD($obj->arrCCO)).
						"','".cv(bD($obj->arrDocumentosAdj))."','".cv(bD($obj->arrRemitente))."' )";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			
			$consulta[$x]="INSERT INTO 2013_cuerposMensajes(cuerpoMensaje,idMensaje) VALUES('".cv(str_replace("\\\"","\"",urldecode(bD($obj->cuerpo))))."',@idRegistro)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 2011_mensajesEnvio set documentosAdjuntos='".cv(bD($obj->arrDocumentosAdj))."',arrValoresCuerpo='".cv(bD($obj->arrValoresCuerpo))."',asunto='".cv($obj->asunto)."',nombreMensaje='".cv($obj->titulo)."',
						descripcion='".cv($obj->descripcion)."',idCategoria=".$obj->categoria.",arrDestinatarios='".cv(bD($obj->arrDestinatario))."',arrCC='".cv(bD($obj->arrCC))."',arrCCO='".cv(bD($obj->arrCCO))."',
						arrRemitente= '".cv(bD($obj->arrRemitente))."' where idMensajeEnvio=".$obj->idMensaje;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idMensaje;
			$x++;
			$consulta[$x]="update 2013_cuerposMensajes set cuerpoMensaje='".cv(str_replace("\\\"","\"",urldecode(bD($obj->cuerpo))))."' where idMensaje=@idRegistro";
			$x++;
		}
		$consulta[$x]="delete from 2012_parametrosMensajeEnvio where idMensaje=@idRegistro";
		$x++;
		if(sizeof($obj->arrParametros)>0)
		{
			foreach($obj->arrParametros as $p)
			{
				$consulta[$x]="INSERT INTO 2012_parametrosMensajeEnvio(idMensaje,parametro,orden) VALUES(@idRegistro,'".$p->nParametro."',".$p->orden.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idMensaje==-1)
			{
				$query="select @idRegistro";
				$obj->idMensaje=$con->obtenerValor($query);
			}
			echo "1|".$obj->idMensaje;
		}
	}
	
	function obtenerCamposFormularioTipo()
	{
		global $con;
		$tipoCampos=$_POST["t"];
		$idFormulario=$_POST["f"];
		$consulta="SELECT idGrupoElemento,nombreCampo,tipoElemento FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND tipoElemento IN (".$tipoCampos.") order by nombreCampo";
		$arrControles=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrControles;
		
	}
	
	function guardarConfiguracionAlmacenDatoControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$idControl=$_POST["idControl"];
		$consulta="SELECT tipoElemento FROM 901_elementosFormulario WHERE idGrupoElemento=".$idControl;
		$tElemento=$con->obtenerValor($consulta);
		switch($tElemento)
		{
			case "5":
			case "6":
			case "7":
			case "8":
			case "11":
			case "21":
			case "24":
				$consulta="UPDATE 904_configuracionElemFormulario SET campoConf4='".cv($cadObj)."' WHERE idElemFormulario=".$idControl;
			break;
			case "9":
			
				$consulta="UPDATE 904_configuracionElemFormulario SET campoConf5='".cv($cadObj)."' WHERE idElemFormulario=".$idControl;
			break;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$tElemento;
		}
		
	}
	
	function removerConfiguracionAlmacenDatoControl()
	{
		global $con;
		$idControl=$_POST["idControl"];
		$consulta="SELECT tipoElemento FROM 901_elementosFormulario WHERE idGrupoElemento=".$idControl;
		$tElemento=$con->obtenerValor($consulta);
		switch($tElemento)
		{
			case "5":
			case "6":
			case "7":
			case "8":
			case "11":
			case "21":
			case "24":
				$consulta="UPDATE 904_configuracionElemFormulario SET campoConf4='' WHERE idElemFormulario=".$idControl;
				
			break;
			case "9":
				$consulta="UPDATE 904_configuracionElemFormulario SET campoConf5='' WHERE idElemFormulario=".$idControl;
			break;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$tElemento;
		}
	}
	
	function guardarConfiguracionGridODatos()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$cadObj=$_POST["cadObj"];
		$consulta="UPDATE 904_configuracionElemFormulario SET campoConf10='".$cadObj."' WHERE idElemFormulario=".$idElemento;
		eC($consulta);
		
	}
	
	function modificarEtiquetaGridListado()
	{
		global $con;
		$c=$_POST["c"];
		$v=$_POST["v"];
		$iC=$_POST["iC"];
		$consulta="UPDATE 909_configuracionTablaFormularios SET ".$c."='".cv($v)."' WHERE idConfGrid=".$iC;

		eC($consulta);
			
	}
	
	function registrarFiltroGlobal()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idFiltro==-1)
		{
			$consulta="INSERT INTO 907_filtrosGlobalesGrid(etiqueta,idCampoAsociado,tipoFiltro,tamano,funcionOrigenOpciones,funcionValorDefault,idConfiguracionGrid) 
					VALUES('".cv($obj->etiqueta)."',".$obj->campo.",".$obj->tipoFiltro.",".$obj->tamano.",".$obj->idFuncionOrigenOpciones.",".$obj->idFuncionOrigenDefault.",".$obj->idConfiguracionGrid.")";
			
		}
		else
		{
			$consulta="update 907_filtrosGlobalesGrid set etiqueta='".cv($obj->etiqueta)."',idCampoAsociado=".$obj->campo.",tipoFiltro=".$obj->tipoFiltro.",tamano=".$obj->tamano.
						",funcionOrigenOpciones=".$obj->idFuncionOrigenOpciones.",funcionValorDefault=".$obj->idFuncionOrigenDefault." where idFiltro=".$obj->idFiltro;	
			
		}
		
		eC($consulta);
	}
	
	function obtenerFiltrosGlobales()
	{
		global $con;	
		$iConf=$_POST["iConf"];
		$consulta="SELECT idFiltro,etiqueta,idCampoAsociado AS campoAsociado,tipoFiltro AS tipo,tamano,
					funcionOrigenOpciones,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=funcionOrigenOpciones) AS lblFuncionOrigen,
					funcionValorDefault,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=funcionValorDefault) AS lblFuncionDefault 
					FROM 907_filtrosGlobalesGrid f WHERE idConfiguracionGrid=".$iConf;

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function removerFiltroGlobal()
	{
		global $con;	
		$iFiltro=$_POST["idFiltro"];
		$consulta="delete from 907_filtrosGlobalesGrid where idFiltro=".$iFiltro;
		eC($consulta);
	}
	
	function crearIndiceFormulario()
	{
		global $con;
		
		$cadCampos="";
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$aCampos=explode(",",$obj->campos);

	
		if($obj->nombreIndice!=$obj->nombre)
		{
			$arrLlaves=array();
			$consulta="SHOW INDEX FROM _".$obj->idFormulario."_tablaDinamica"; 
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				if(!isset($arrLlaves[$fila[2]]))
				{
					$arrLlaves[$fila[2]]=array();
				}
				
				array_push($arrLlaves[$fila[2]],$fila[4]);
			}
			
			
			if(isset($arrLlaves[$obj->nombre]))
			{
				echo "<br><br>El nombre del &iacute;ndice ya ha sido utilizado previamente";
				return;
			}
			
				
		}

		
		foreach($aCampos as $c)
		{
			$consulta="";
			
			if($c!="id__".$obj->idFormulario."_tablaDinamica")
			{
				
				if($c<0)	
				{
					$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$c;
				}
				else
				{
					$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$c;
				}
				$nCampo=$con->obtenerValor($consulta);
			}
			else
				$nCampo=$c;
				
			if($cadCampos=="")
				$cadCampos="`".$nCampo."`";
			else
				$cadCampos.=",`".$nCampo."`";
		}
		
		if($obj->nombreIndice!="")
		{
			$query[$x]=" ALTER TABLE _".$obj->idFormulario."_tablaDinamica drop INDEX `".$obj->nombreIndice."`";
			$x++;
		}
		
		
		$query[$x]=" ALTER TABLE _".$obj->idFormulario."_tablaDinamica ADD INDEX `".$obj->nombre."` (".$cadCampos.")";
		$x++;
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	function obtenerIndicesFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		
		
		$arrCampos=array();
		
		$consulta="SELECT nombreCampo,idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND nombreCampo IS NOT NULL and tipoElemento not in (1,13,30,-1,0,16,17,18,23,29,32,33)
					UNION
					SELECT campoMysql,tipoElemento,etiquetaUsuario FROM 9017_camposControlFormulario";
		
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arrCampos[$fila[0]]["nombreCampo"]=$fila[2];
			$arrCampos[$fila[0]]["idCampo"]=$fila[1];
		}
		
		
		$arrLlaves=array();
		$consulta="SHOW INDEX FROM _".$idFormulario."_tablaDinamica where Key_name<>'PRIMARY'"; 
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if(!isset($arrLlaves[$fila[2]]))
			{
				$arrLlaves[$fila[2]]=array();
			}
			
			array_push($arrLlaves[$fila[2]],$fila[4]);
		}
		
		ksort($arrLlaves);
		
		$numReg=0;
		$registros="";
		$camposAsociadosLbl="";
		$camposAsociadosID="";
		foreach($arrLlaves as $idx=>$campos)
		{
			$camposAsociadosLbl="";
			$camposAsociadosID="";
			foreach($campos as $c)
			{
				$nCampo=$c;
				$idCampo=$c;
				if(isset($arrCampos[$c]))
				{
					$nCampo=$arrCampos[$c]["nombreCampo"];
					$idCampo=$arrCampos[$c]["idCampo"];
				}
				
				if($camposAsociadosLbl=="")
				{
					$camposAsociadosLbl=$nCampo;
					$camposAsociadosID=$idCampo;
					
				}
				else
				{
					$camposAsociadosLbl.=",".$nCampo;
					$camposAsociadosID.=",".$idCampo;
				}
				
			}
			
			$o='{"etiqueta":"'.$idx.'","camposAsociadosLbl":"'.$camposAsociadosLbl.'","camposAsociadosID":"'.$camposAsociadosID.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function removerIndiceFormulario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$indice=$_POST["indice"];
		$query=" ALTER TABLE _".$idFormulario."_tablaDinamica drop INDEX `".$indice."`";
		eC($query);
			
	}
	
	
	function obtenerCamposTableroControl()
	{
		global $con;
		
		$idConfiguracion=$_POST["idConfiguracion"];			
		
		$consulta="SELECT idCampoTablero,nombreCampo,etiquetaCampo,tamanoColumna,alineacionValores,orden,funcionRenderer,visible FROM 9061_camposTableroControl 
					WHERE idTableroControl=".$idConfiguracion."  ORDER BY orden";
		
		$arrCampos=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT registrosPagina FROM 9060_tablerosControl WHERE idTableroControl=".$idConfiguracion;
		$regPaginas=$con->obtenerValor($consulta);
		
		echo "1|".$arrCampos."|".$regPaginas;
		
	}
	
	function obtenerCamposTableroDisponibles()
	{
		global $con;
		
		$idConfiguracion=$_POST["idConfiguracion"];
		
		$consulta="SELECT nombreCampo FROM 9061_camposTableroControl WHERE idTableroControl=".$idConfiguracion;
		$listaCampos=$con->obtenerListaValores($consulta,"'");
		if($listaCampos=="")
			$listaCampos="'contenidoMensaje'";
		else
			$listaCampos.=",'contenidoMensaje'";
		
		$arrCampos="";
		$consulta="SELECT COLUMN_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='9060_tableroControl_".$idConfiguracion."'
					and COLUMN_NAME not in (".$listaCampos.") ORDER BY COLUMN_NAME";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$consulta="SELECT nombreTipoDato  FROM 9063_tiposValoresDato WHERE tipoDatoServidor='".$fila[2]."'";
			$tipo=$con->obtenerValor($consulta);
			if($tipo=="")
				$tipo=$fila[2];
			
			$o="['".$fila[0]."','".$fila[0]."','".$tipo."','0']";
			if($arrCampos=="")
				$arrCampos=$o;
			else
				$arrCampos.=",".$o;
		}
		
		echo "1|[".$arrCampos."]";
		
	}
	
	function guardarConfiguracionCampoTableroControl()
	{
		global $con;
		$parCampo=$_POST["objCampo"];
		$objCampo=json_decode($parCampo);
		$visible=$objCampo->visible;
		$accion=$objCampo->accion;
		$idCampo=$objCampo->idCampo;
		$etCampo=$objCampo->etCampo;
		$anchoCol=$objCampo->anchoCol;
		$tituloCampo=$objCampo->tituloCampo;
		$idAlineacion=$objCampo->idAlineacion;
		$numTitulos=sizeof($tituloCampo);
		$idConfiguracion=$objCampo->idConfiguracion;
		
		$query="begin";
		$x=0;
		if($con->ejecutarConsulta($query))
		{
			
			
			if($accion==0)
			{
				$consulta[$x]="update 9061_camposTableroControl set orden=orden+1 where idTableroControl=".$idConfiguracion." and orden>=".$objCampo->orden;
				$x++;
				
				for($ct=0;$ct<$numTitulos;$ct++)
				{
					$consulta[$x]="	insert into 9061_camposTableroControl(idIdioma,tamanoColumna,etiquetaCampo,alineacionValores,idTableroControl,orden,funcionRenderer,visible,nombreCampo) values
									(".$tituloCampo[$ct]->idIdioma.",".$anchoCol.",'".cv($tituloCampo[$ct]->etiqueta)."',".$idAlineacion.",".$idConfiguracion.",".$objCampo->orden.",".$objCampo->funcionRenderer.",
									".$visible.",'".$idCampo."')";
					$x++;
				}
				
				
			}
			else
			{
				
				
				$query="SELECT idCampoTablero,orden FROM 9061_camposTableroControl WHERE idTableroControl=".$idConfiguracion." AND nombreCampo='".$etCampo."'";
				
				$fCampo=$con->obtenerPrimeraFila($query);

				
				$orden=$fCampo[1];

				if($orden>$objCampo->orden)
				{
					$consulta[$x]="update 9061_camposTableroControl set orden=orden+1 where idTableroControl=".$idConfiguracion." and orden>=".$objCampo->orden." and orden<".$orden;
					$x++;
				}
				else
				{
					$consulta[$x]="update 9061_camposTableroControl set orden=orden-1 where idTableroControl=".$idConfiguracion." and orden>=".$orden." and orden<=".$objCampo->orden;
					$x++;	
				}
				
				
				$idGrupoCampo='-1';
				for($ct=0;$ct<$numTitulos;$ct++)
				{
					$consulta[$x]="update 9061_camposTableroControl set funcionRenderer=".$objCampo->funcionRenderer.",orden=".$objCampo->orden.",tamanoColumna=".$anchoCol.",etiquetaCampo='".cv($tituloCampo[$ct]->etiqueta).
									"',alineacionValores=".$idAlineacion.",visible=".$visible." where idTableroControl=".$idConfiguracion." AND nombreCampo='".$etCampo."'";
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
		else
			echo "|";
		
	}
	
	function obtenerConfiguracionCampoTableroControl()
	{
		global $con;
		$idGrupoCampo=$_POST["campo"];
		$consulta="select i.imagen,i.idIdioma,c.etiquetaCampo,nombreCampo as etiqueta from 9061_camposTableroControl c,8002_idiomas i where i.idIdioma=c.idIdioma and idCampoTablero=".$idGrupoCampo;
		$arrTitulos=$con->obtenerFilasArreglo($consulta);
		$consulta="select tamanoColumna,alineacionValores,visible,funcionRenderer,orden from 9061_camposTableroControl where idCampoTablero=".$idGrupoCampo;
		$fila=$con->obtenerPrimeraFila($consulta);
		$tamColumna=$fila[0];
		$idAlineacion=$fila[1];
		$obj='[{"tamColumna":"'.$tamColumna.'","idAlineacion":"'.$idAlineacion.'","visible":"'.$fila[2].'","funcionRenderer":"'.$fila[3].'","orden":"'.$fila[4].'","arrTitulos":'.uEJ($arrTitulos).'}]';
		echo "1|".$obj;		
	}
	
	function eliminarCampoConfiguracionTableroControl()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$etCampo=$_POST["etCampo"];
		$query="SELECT idCampoTablero,orden FROM 9061_camposTableroControl WHERE idTableroControl=".$idConfiguracion." AND nombreCampo='".$etCampo."'";
		$fCampo=$con->obtenerPrimeraFila($query);
		
		
		$orden=$fCampo[1];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="update 9061_camposTableroControl set orden=orden-1 where idTableroControl=".$idConfiguracion." and orden>".$orden;
		$x++;
		$consulta[$x]="delete from 9061_camposTableroControl where idTableroControl=".$idConfiguracion." and nombreCampo='".$etCampo."'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";	
		}
		echo "|";
	}
	
	function obtenerCamposTableroControlAdministracion()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		
		
		$consulta="SELECT nombreCampo FROM 9070_camposDefaultCreacionTablas WHERE idTipoTablas=1 ORDER BY orden";
		$listaCampos=$con->obtenerListaValores($consulta,"'");
		if($listaCampos=="")
			$listaCampos=-1;
		$arrCampos="";
		$nRegistros=0;
		$consulta="SELECT COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='9060_tableroControl_".$idConfiguracion."'
					and COLUMN_NAME not in (".$listaCampos.") ORDER BY COLUMN_NAME";

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{

			$tipo=$fila[1];
			
			if($tipo<>'datetime')
				$consulta="select count(*) from 9060_tableroControl_".$idConfiguracion." where 	".$fila[0]." is not null and ".$fila[0]."<>''";
			else
				$consulta="select count(*) from 9060_tableroControl_".$idConfiguracion." where 	".$fila[0]." is not null";
			
			$nReg=$con->obtenerValor($consulta);
			
			
			
			
			$o='{"nombreCampoOriginal":"'.$fila[0].'","nombreCampo":"'.$fila[0].'","tipoCampo":"'.$tipo.'","eliminable":"'.(($nReg==0)?1:0).'"}';
			if($arrCampos=="")
				$arrCampos=$o;
			else
				$arrCampos.=",".$o;
			$nRegistros++;
		}
		
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrCampos.']}';
		
	}
	
	
	function modificarCampoTableroControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$nombreTabla="9060_tableroControl_".$obj->idConfiguracion;
		if($obj->nombreCampoOriginal!=$obj->nombreCampo)
		{
			$consulta="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."'
						and COLUMN_NAME ='".$obj->nombreCampo."'";
			
			$nCampo=$con->obtenerValor($consulta);			
			
			if($nCampo!="")
			{
				echo "1|2";
				return;
			}
		}
		
		$tipoColumna=$obj->tipoCampo;
		$consulta="SELECT valorTipoComplementario FROM 9063_tiposValoresDato WHERE tipoDatoServidor='".$tipoColumna."'";
		$tipoComp=$con->obtenerValor($consulta);
		if($tipoComp!="")
			$tipoColumna.=" ".$tipoComp;
				
		$x=0;
		$query[$x]="begin";
		$x++;
		
		if($obj->nombreCampoOriginal=="")
		{
			
			$query[$x]="ALTER TABLE ".$nombreTabla." ADD ".$obj->nombreCampo." ".$tipoColumna;	
			$x++;
		}
		else
		{
			
			$query[$x]="ALTER TABLE ".$nombreTabla." change ".$obj->nombreCampoOriginal." ".$obj->nombreCampo." ".$tipoColumna;	
			$x++;
			$query[$x]="UPDATE 9061_camposTableroControl SET nombreCampo='".$obj->nombreCampo."' WHERE idTableroControl=".$obj->idConfiguracion." AND nombreCampo='".$obj->nombreCampoOriginal."'";
			$x++;
			
			$query[$x]="UPDATE 9066_configuracionOrdenTableroControl SET nombreCampo='".$obj->nombreCampo."' WHERE idTableroControl=".$obj->idConfiguracion." AND nombreCampo='".$obj->nombreCampoOriginal."'";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
			echo "1|1";
		
	}
	
	
	function eliminarCampoTableroControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$nombreTabla="9060_tableroControl_".$obj->idConfiguracion;
				
		$x=0;
		$query[$x]="begin";
		$x++;
			
		$query[$x]="ALTER TABLE ".$nombreTabla." drop column ".$obj->nombreCampo;	
		$x++;
		
		$consulta="SELECT orden FROM 9061_camposTableroControl WHERE idTableroControl=".$obj->idConfiguracion." and nombreCampo='".$obj->nombreCampo."'";
		$orden=$con->obtenerValor($consulta);
		
		if($orden!="")
		{
			$query[$x]="UPDATE 9061_camposTableroControl SET orden=orden-1 WHERE idTableroControl=".$obj->idConfiguracion." orden>".$orden;
			$x++;
			$query[$x]="delete from 9061_camposTableroControl WHERE idTableroControl=".$obj->idConfiguracion." and nombreCampo='".$orden."'";
			$x++;
		}
		
		$query[$x]="DELETE FROM 9066_configuracionOrdenTableroControl WHERE idTableroControl=".$obj->idConfiguracion." AND nombreCampo='".$obj->nombreCampo."'";
		$x++;
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
			echo "1|";
		
	}
	
	function actualizarNumeroRegistroPaginas()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$numReg=$_POST["numReg"];
		
		$consulta="UPDATE 9060_tablerosControl SET registrosPagina=".$numReg." WHERE idTableroControl=".$idConfiguracion;
		eC($consulta);
	}
	
	function obtenerCamposOrdenTableroControl()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		
		$nombreTabla="9060_tableroControl_".$idConfiguracion;
		$consulta="SELECT COLUMN_NAME,COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."' order by COLUMN_NAME";
							
		$arrCamposTableroControl=$con->obtenerFilasArreglo($consulta);		
		
		$consulta="SELECT idRegistro,nombreCampo as campo,orden as direccion FROM 9066_configuracionOrdenTableroControl WHERE idTableroControl=".$idConfiguracion." ORDER BY idRegistro";
		
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","camposTableroControl":'.$arrCamposTableroControl.',"registros":'.$arrRegistros.'}';
		
		
		
	}
	
	
	function modificarCamposOrdenTableroControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
			$consulta="INSERT INTO 9066_configuracionOrdenTableroControl(idTableroControl,nombreCampo,orden) VALUES(".$obj->idConfiguracion.",'".$obj->nombreCampo."','".$obj->orden."')";
		else
			$consulta="update 9066_configuracionOrdenTableroControl set nombreCampo='".$obj->nombreCampo."',orden='".$obj->orden."' where idRegistro=".$obj->idRegistro;
			
		eC($consulta);	
			
	}
	
	
	function removerCamposOrdenTableroControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="DELETE FROM 9066_configuracionOrdenTableroControl WHERE idRegistro=".$obj->idRegistro;
			
		eC($consulta);	
			
	}
	
	function crearIndiceTableroControl()
	{
		global $con;
		
		$cadCampos="";
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$aCampos=explode(",",$obj->campos);
		$nombreTabla="9060_tableroControl_".$obj->idConfiguracion;
	
		if($obj->nombreIndice!=$obj->nombre)
		{
			$arrLlaves=array();
			$consulta="SHOW INDEX FROM ".$nombreTabla; 
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				if(!isset($arrLlaves[$fila[2]]))
				{
					$arrLlaves[$fila[2]]=array();
				}
				
				array_push($arrLlaves[$fila[2]],$fila[4]);
			}
			
			
			if(isset($arrLlaves[$obj->nombre]))
			{
				echo "<br><br>El nombre del &iacute;ndice ya ha sido utilizado previamente";
				return;
			}
			
				
		}

		
		foreach($aCampos as $nCampo)
		{
			if($cadCampos=="")
				$cadCampos="`".$nCampo."`";
			else
				$cadCampos.=",`".$nCampo."`";
		}
		
		if($obj->nombreIndice!="")
		{
			$query[$x]=" ALTER TABLE ".$nombreTabla." drop INDEX `".$obj->nombreIndice."`";
			$x++;
		}
		
		
		$query[$x]=" ALTER TABLE ".$nombreTabla." ADD INDEX `".$obj->nombre."` (".$cadCampos.")";
		$x++;
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	function obtenerIndicesTableroControl()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		
		$nombreTabla="9060_tableroControl_".$idConfiguracion;
		$arrCampos=array();
		
		
		
		$arrLlaves=array();
		$consulta="SHOW INDEX FROM ".$nombreTabla." WHERE Key_name<>'PRIMARY'"; 
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if(!isset($arrLlaves[$fila[2]]))
			{
				$arrLlaves[$fila[2]]=array();
			}
			
			array_push($arrLlaves[$fila[2]],$fila[4]);
		}
		
		ksort($arrLlaves);
		
		$numReg=0;
		$registros="";
		$camposAsociadosLbl="";
		$camposAsociadosID="";
		foreach($arrLlaves as $idx=>$campos)
		{
			$camposAsociadosLbl="";
			$camposAsociadosID="";
			foreach($campos as $c)
			{
				$nCampo=$c;
				$idCampo=$c;
				if(isset($arrCampos[$c]))
				{
					$nCampo=$arrCampos[$c]["nombreCampo"];
					$idCampo=$arrCampos[$c]["idCampo"];
				}
				
				if($camposAsociadosLbl=="")
				{
					$camposAsociadosLbl=$nCampo;
					$camposAsociadosID=$idCampo;
					
				}
				else
				{
					$camposAsociadosLbl.=",".$nCampo;
					$camposAsociadosID.=",".$idCampo;
				}
				
			}
			
			$o='{"etiqueta":"'.$idx.'","camposAsociadosLbl":"'.$camposAsociadosLbl.'","camposAsociadosID":"'.$camposAsociadosID.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function removerIndiceTableroControl()
	{
		global $con;
		$idConfiguracion=$_POST["idConfiguracion"];
		$indice=$_POST["indice"];
		$nombreTabla="9060_tableroControl_".$idConfiguracion;
		$query=" ALTER TABLE ".$nombreTabla." drop INDEX `".$indice."`";
		eC($query);
			
	}
	
	function obtenerFiltrosGlobalesTableroControl()
	{
		global $con;	
		$idConfiguracion=$_POST["iC"];
		$consulta="SELECT idFiltro,etiqueta,campoAsociado,tipoFiltro AS tipo,tamano,
					funcionOrigenOpciones,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=funcionOrigenOpciones) AS lblFuncionOrigen,
					funcionValorDefault,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=funcionValorDefault) AS lblFuncionDefault 
					FROM 9065_filtrosGlobalesTableroControl f WHERE idTableroControl=".$idConfiguracion;

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function removerFiltroGlobalTableroControl()
	{
		global $con;	
		$iFiltro=$_POST["idFiltro"];
		$consulta="delete from 9065_filtrosGlobalesTableroControl where idFiltro=".$iFiltro;
		eC($consulta);
	}
	
	function registrarFiltroGlobalTableroControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idFiltro==-1)
		{
			$consulta="INSERT INTO 9065_filtrosGlobalesTableroControl(etiqueta,campoAsociado,tipoFiltro,tamano,funcionOrigenOpciones,funcionValorDefault,idTableroControl) 
					VALUES('".cv($obj->etiqueta)."','".$obj->campo."',".$obj->tipoFiltro.",".$obj->tamano.",".$obj->idFuncionOrigenOpciones.",".$obj->idFuncionOrigenDefault.",".$obj->idConfiguracion.")";
			
		}
		else
		{
			$consulta="update 9065_filtrosGlobalesTableroControl set etiqueta='".cv($obj->etiqueta)."',campoAsociado='".$obj->campo."',tipoFiltro=".$obj->tipoFiltro.",tamano=".$obj->tamano.
						",funcionOrigenOpciones=".$obj->idFuncionOrigenOpciones.",funcionValorDefault=".$obj->idFuncionOrigenDefault." where idFiltro=".$obj->idFiltro;	
			
		}
		
		eC($consulta);
	}
	
	function obtenerNotificacionesProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idNotificacion,tituloNotificacion,descripcion from 9067_notificacionesProceso where idProceso=".$idProceso;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function guardarNotificacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;


		if($obj->idNotificacion==-1)
		{
			$consulta[$x]="INSERT INTO 9067_notificacionesProceso(idProceso,tituloNotificacion,descripcion,tableroControlAsociado,fechaCreacion,responsableCreacion,
						cuerpoNotificacion,arrValoresCuerpo,repetible,marcarAtendidaAbrir,enviarMail,idMacroProceso,cveNotificacion,funcionRendererNotificacion,
						funcionAperturaPersonalizada,funcionAfterVisualizacion,enviarSMS,enviarWhatApp) 
						VALUES(".$obj->idProceso.",'".cv($obj->titulo)."','".cv($obj->descripcion)."',".$obj->idTableroControl.",'".date("Y-m-d H:i")."',".
						$_SESSION["idUsr"].",'".cv(str_replace("\\\"","\"",urldecode(bD($obj->cuerpo))))."','".cv(bD($obj->arrValoresCuerpo)).
						"',".$obj->notificacionRepetible.",".$obj->marcarAtendidaAbrir.",".$obj->enviarMail.",".$obj->idMacroProceso.",'".cv($obj->cveNotificacion).
						"','".($obj->funcionRendererNotificacion==""?-1:$obj->funcionRendererNotificacion)."','".cv($obj->funcionApertura).
						"','".$obj->funcionAfterVisualizacion."',".$obj->enviarSMS.",".$obj->enviarWhats.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$consulta[$x]="update 9067_notificacionesProceso set repetible=".$obj->notificacionRepetible.",tituloNotificacion='".cv($obj->titulo).
						"',descripcion='".cv($obj->descripcion)."',tableroControlAsociado=".$obj->idTableroControl.
						",fechaUltimaModificacion='".date("Y-m-d H:i")."',responsableUltimaModificacion=".$_SESSION["idUsr"].
						",cuerpoNotificacion='".cv(str_replace("\\\"","\"",urldecode(bD($obj->cuerpo)))).
						"',arrValoresCuerpo='".cv(bD($obj->arrValoresCuerpo))."',marcarAtendidaAbrir=".$obj->marcarAtendidaAbrir.
						",enviarMail=".$obj->enviarMail.",cveNotificacion='".cv($obj->cveNotificacion)."',funcionRendererNotificacion='".
						($obj->funcionRendererNotificacion==""?-1:$obj->funcionRendererNotificacion)."',funcionAperturaPersonalizada='".
						cv($obj->funcionApertura)."',funcionAfterVisualizacion='".$obj->funcionAfterVisualizacion.
						"',enviarSMS=".$obj->enviarSMS.",enviarWhatApp=".$obj->enviarWhats."  where idNotificacion=".$obj->idNotificacion;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idNotificacion;
			$x++;
			
		}
		$consulta[$x]="DELETE FROM 9068_configuracionNotificacionTableroControl WHERE idNotificacion=@idRegistro";
		$x++;
		foreach($obj->arrCamposTableroControl as $o)
		{
			$consulta[$x]="INSERT INTO 9068_configuracionNotificacionTableroControl(idNotificacion,campoTablero,tipoLlenado,valor) 
						VALUES(@idRegistro,'".$o->nombreCampo."',".($o->tipoLlenado==""?"NULL":$o->tipoLlenado).",'".cv($o->valor)."')";
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 9069_valoresReferenciaNotificaciones WHERE idNotificacion=@idRegistro";
		$x++;
		foreach($obj->arrValoresReferencia as $o)
		{
			$consulta[$x]="INSERT INTO 9069_valoresReferenciaNotificaciones(idNotificacion,idValor,descripcion,valor) VALUES(@idRegistro,'".$o->idValor."','".$o->descripcion."','".cv($o->valor)."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idNotificacion==-1)
			{
				$query="select @idRegistro";
				$obj->idNotificacion=$con->obtenerValor($query);
			}
			echo "1|".$obj->idNotificacion;
		}
	}
	
	function obtenerAsociacionTableroControlNotificaciones()
	{
		global $con;
		
		$idNotificacion=$_POST["idNotificacion"];
		$idTablero=$_POST["idTablero"];
		$nombreTabla="9060_tableroControl_".$idTablero;
		
		$consulta="SELECT nombreCampo FROM 9070_camposDefaultCreacionTablas WHERE idTipoTablas=1 and nombreCampo<>'fechaLimiteAtencion'";
		$listaCampos=$con->obtenerListaValores($consulta,"'");
		if($listaCampos=="")
			$listaCampos=-1;
			
			
		$nCampos=0;	
		$consulta="SELECT COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."' AND  
				COLUMN_NAME NOT IN (".$listaCampos.") ORDER BY COLUMN_NAME";//4170

		
		$arrCampos="";
		$rCampos=$con->obtenerFilas($consulta);
		while($fCampos=$con->fetchRow($rCampos))
		{
		
			$consulta="SELECT nombreTipoDato  FROM 9063_tiposValoresDato WHERE tipoDatoServidor='".$fCampos[1]."'";
			$tipo=$con->obtenerValor($consulta);
			if($tipo=="")
				$tipo=$fCampos[2];
			
			$consulta="SELECT valor,tipoLlenado FROM 9068_configuracionNotificacionTableroControl WHERE idNotificacion=".$idNotificacion." and campoTablero='".$fCampos[0]."'";
			$fValor=$con->obtenerPrimeraFila($consulta);
			$valorAux=$fValor[0];
			if($valorAux=="")
				$valorAux=-1;
			$etiquetaValor="";
			
			switch($fValor[1])
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
				
			$o='{"nombreCampo":"'.$fCampos[0].'","tipoDato":"'.$tipo.'","tipoLlenado":"'.$fValor[1].'","valor":"'.cv($fValor[0]).'","etiquetaValor":"'.$etiquetaValor.'"}';	
			if($arrCampos=="")
				$arrCampos=$o;
			else
				$arrCampos.=",".$o;
			
			$nCampos++;	
		}
		
		echo '{"numReg":"'.$nCampos.'","registros":['.$arrCampos.']}';
	}
	
	function obtenerConfiguracionNotificacionesProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$etapa=$_POST["etapa"];
		$idPerfil=$_POST["idPerfil"];
		$arrRegistros="";
		$nReg=0;
		$consulta="SELECT * FROM 9071_configuracionNotificacionProceso where idProceso=".$idProceso." AND etapa=".$etapa." and idPerfil=".$idPerfil;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$etFuncionCondicionadora="";
			if($fila[4]!="")
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[4];
				$etFuncionCondicionadora=$con->obtenerValor($consulta);
			}
			
			$etFuncionDefinicionDestinatario="";
			if($fila[6]!="")
			{
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[6];
				$etFuncionDefinicionDestinatario=$con->obtenerValor($consulta);
			}
			
			$etRolDestinatario="";
			if($fila[5]!="")
			{
				$etRolDestinatario=obtenerTituloRol($fila[5]);
				
			}
			
			$etActorAccesoProceso="";
			if($fila[8]!="")
			{
				if($fila[8]==0)
					$etActorAccesoProceso="(S&oacute;lo lectura)";
				else
					$etActorAccesoProceso=obtenerTituloRol($fila[8]);
				
			}
			
			$funcionAplicacionMarcaAtencion="";
			if($fila[12]!="")
			{
				$objComp=json_decode(bD($fila[12]));
				if($objComp->funcionAplicacion!="")
				{
					$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objComp->funcionAplicacion;
					$funcionAplicacionMarcaAtencion=$con->obtenerValor($consulta);
				}
			}
			
			$o='{"idRegistroNotificacion":"'.$fila[0].'","tipoNotificacion":"'.$fila[3].'","funcionCondicionadora":"'.$fila[4].'","etFuncionCondicionadora":"'.cv($etFuncionCondicionadora).
				'","rolDestinatario":"'.$fila[5].'","etRolDestinatario":"'.cv($etRolDestinatario).'","funcionDefinicionDestinatario":"'.$fila[6].'","etFuncionDefinicionDestinatario":"'.cv($etFuncionDefinicionDestinatario).
				'","permiteAccesoProceso":"'.$fila[7].'","actorAccesoProceso":"'.$fila[8].'","etActorAccesoProceso":"'.cv($etActorAccesoProceso).
				'","statusNotificacion":"'.$fila[9].'","marcarAtendidaCambioEtapa":"'.$fila[11].'","confComplementaria":"'.$fila[12].
				'","funcionAplicacionMarcaAtencion":"'.$funcionAplicacionMarcaAtencion.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nReg++;
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarConfiguracionNotificacionesProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if($obj->funcionAplicacion=="")
			$obj->funcionAplicacion="NULL";
			
			
		if($obj->funcionAsignacionDestinatario=="")
			$obj->funcionAsignacionDestinatario="NULL";	
			
		$consulta="";
		if($obj->idNotificacion==-1)
		{
			$consulta="INSERT INTO 9071_configuracionNotificacionProceso(idProceso,etapa,idPerfil,tipoNotificacion,funcionAplicacion,
						actorDestinatario,funcionAsignacionDestinatario,permiteAccesoProceso,actorAccesoProceso,notificacionActiva,
						confComplementaria,marcarAtendidaCambioEtapa)
						VALUES(".$obj->idProceso.",".$obj->etapa.",".$obj->idPerfil.",".$obj->tipoNotificacion.",".$obj->funcionAplicacion.",'".$obj->actorDestinatario."',".$obj->funcionAsignacionDestinatario.",".$obj->permiteAccesoProceso.
						",'".$obj->actorAccesoProceso."',".$obj->notificacionActiva.",'".$obj->confComplementaria."',".$obj->marcarAtendidaCambioEtapa.")";
		}
		else
		{
			$consulta="update 9071_configuracionNotificacionProceso set tipoNotificacion=".$obj->tipoNotificacion.",funcionAplicacion=".$obj->funcionAplicacion.",actorDestinatario='".$obj->actorDestinatario.
					"',funcionAsignacionDestinatario=".$obj->funcionAsignacionDestinatario.",permiteAccesoProceso=".$obj->permiteAccesoProceso.
					",actorAccesoProceso='".$obj->actorAccesoProceso."',notificacionActiva=".$obj->notificacionActiva.",
					confComplementaria='".$obj->confComplementaria."',marcarAtendidaCambioEtapa='".$obj->marcarAtendidaCambioEtapa."'
					where idRegistroConfiguracion=".$obj->idNotificacion;
		}
		

		eC($consulta);
		
		
	}
	
	function removerConfiguracionNotificacionesProceso()
	{
		global $con;
		$idNotificacion=$_POST["idNotificacion"];
		$consulta="DELETE FROM 9071_configuracionNotificacionProceso WHERE idRegistroConfiguracion=".$idNotificacion;
		eC($consulta);
	}
	
	function removerNotificacionTableroControl()
	{
		global $con;
		$idNotificacion=$_POST["idNotificacion"];
		$consulta="DELETE FROM 9067_notificacionesProceso WHERE idNotificacion=".$idNotificacion;
		eC($consulta);
	}
	
	function obtenerActorFormularioRegistro()
	{
		global $con;
		$idRegistro=bD($_POST["iR"]);
		$idFormulario=bD($_POST["iF"]);
		$actor=bD($_POST["a"]);
		
		$iA=bD($_POST["iA"]);
		$iT=bD($_POST["iT"]);
		
		$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$iA;
		$actorRol=$con->obtenerValor($consulta);
		
		
		
		$consulta="SELECT idNotificacionBase,idUsuarioDestinatario FROM 9060_tableroControl_".$iT." WHERE idRegistro=".$iA;
		
		
		$fTarea=$con->obtenerPrimeraFila($consulta);
		$idNotificacionBase=$fTarea[0];
		
		
		$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles WHERE idUsuario=".$fTarea[1]." AND codigoRol='".$actorRol."'";
		$numRoles=$con->obtenerValor($consulta);
		
		$consulta="SELECT idEstado FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$etapa=$con->obtenerValor($consulta);
		$idProceso=obtenerIdProcesoFormulario($idFormulario);		
		
		$idActor="";
		if(($idNotificacionBase!="")||($numRoles==0))
		{
			$consulta="SELECT codigoRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fTarea[1];
			$res=$con->obtenerFilas($consulta);
			while($fRol=$con->fetchRow($res))
			{
			
				$idActor=obtenerActorProcesoIdRol($idProceso,$fRol[0],$etapa);
				if($idActor!="")
					break;
			
			}
			
			
		}
		
		
		if($idActor=="")
		{
			$idActor=obtenerActorProcesoIdRol($idProceso,$actor,$etapa);
		}
		
		if($idActor=="")
			$idActor=0;
		
		
		echo "1|".$idActor;	
		
		
		
	}
	
	function registrarVisualizacionNotificacion()
	{
		global $con;
		$idNotificacion=bD($_POST["iN"]);
		$idTablero=bD($_POST["iT"]);
		$fechaActual=date("Y-m-d H:i:s");
		$nombreTabla="9060_tableroControl_".$idTablero;
		
		
		$consulta="UPDATE ".$nombreTabla." SET fechaVisualizacion='".$fechaActual."' WHERE idRegistro=".$idNotificacion;
		if($con->ejecutarConsulta($consulta))
			echo "1|".$fechaActual;
		
	}
	
	function obtenerRegistrosHistorial()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$arrRegistros="";
		$nReg=0;
		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." ORDER BY fechaCambio desc";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$etapaOriginal="";
			if($fila[4]!="")
			{
				
				$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$fila[4];
				$fEtapa=$con->obtenerPrimeraFila($consulta);
				
				$etapaOriginal=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
				
			}
			
			$etapaCambio="";
			if($fila[1]!="")
			{
				
				$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$fila[1];
				$fEtapa=$con->obtenerPrimeraFila($consulta);
				
				$etapaCambio=removerCerosDerecha($fEtapa[0]).".- ".$fEtapa[1];
				
			}
			
			$responsable=obtenerNombreUsuario($fila[3]);
			if(($fila[10]!="")&&($fila[10]!=0))
			{
				$rolActor="";
				$consulta="SELECT actor,tipoActor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$fila[10];

				$fActor=$con->obtenerPrimeraFila($consulta);
				if($fActor[1]==1)
					$rolActor=obtenerTituloRol($fActor[0]);
				else
				{
					$consulta="SELECT nombreComite FROM 2006_comites WHERE idComite=".$fActor[0];
					$rolActor='Comite: '.$con->obtenerValor($consulta);
				}
				
				$responsable.=" (".$rolActor.")";
				
			}
			
			
			$o='{"idRegistro":"'.$fila[0].'","fechaOperacion":"'.$fila[2].'","etapaOriginal":"'.cv($etapaOriginal).'","etapaCambio":"'.cv($etapaCambio).'","responsable":"'.cv($responsable).'","comentarios":"'.cv($fila[7]).'"}';
			$nReg++;
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	
	function obtenerDocumentosVinculadosProceso()
	{
		global $con;
		$idFormulario=bD($_POST["iF"]);
		$idRegistro=bD($_POST["iR"]);
		
		$nRegistros=0;
		$arrRegistros="";
		
		$consulta="SELECT d.idDocumento,d.tipoDocumento,nomArchivoOriginal,tamano,fechaCreacion FROM 9074_documentosRegistrosProceso d,908_archivos a WHERE 
					idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and a.idArchivo=d.idDocumento";
		
		$resDocumentos=$con->obtenerFilas($consulta);
		while($fDocumento=$con->fetchAssoc($resDocumentos))
		{
			
			$arrDatosArchivo=explode(".",$fDocumento["nomArchivoOriginal"]);
			$consulta="SELECT * FROM 9049_visoresDocumentos WHERE extension='".$arrDatosArchivo[sizeof($arrDatosArchivo)-1]."'";
			$fConfiguracionVisor=$con->obtenerPrimeraFila($consulta);
			
			if(strlen($arrDatosArchivo[0])>22)		
				$nombreDocumentoCorto=substr($arrDatosArchivo[0],0,16)."...(".$arrDatosArchivo[1].")";
			else
				$nombreDocumentoCorto=$arrDatosArchivo[0]." (".$arrDatosArchivo[1].")";
			
			
			
			$o='{"idDocumento":"'.$fDocumento["idDocumento"].'","nombreDocumento":"'.cv($fDocumento["nomArchivoOriginal"]).
				'","nombreDocumentoCorto":"'.cv($nombreDocumentoCorto).'","tamanoDocumento":"'.bytesToSize($fDocumento["tamano"],0).
				'","fechaDocumento":"'.$fDocumento["fechaCreacion"].'","extension":"'.
				strtolower($arrDatosArchivo[1]).'","tipoDocumento":"'.$fDocumento["tipoDocumento"].'"}';
			
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nRegistros++;
		}
		
		
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function registrarDelegacionActividades()
	{
		global $con;
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$obj=json_decode($_POST["cadObj"]);
		
		$camposInsert="";
		$camposSelect="";
		
		$nombreTablero="9060_tableroControl_".$obj->idTablero;
		$consulta="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual.
					"' AND TABLE_NAME='".$nombreTablero."' ORDER BY ORDINAL_POSITION";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if($fila[0]=="idRegistro")
				continue;
			if($camposInsert=="")
				$camposInsert=$fila[0];
			else
				$camposInsert.=",".$fila[0];
			
			
			switch($fila[0])
			{
				case "idEstado":
					$fila[0]="'1' as idEstado";
					break;
				case "fechaAsignacion":
					$fila[0]="'".date("Y-m-d H:i:s")."' as fechaAsignacion";
					break;
				case "usuarioDestinatario":
					$fila[0]="'".cv($obj->lblEtiqueta)."' as usuarioDestinatario";
					break;
				case "idUsuarioDestinatario":
					$fila[0]="'".$obj->idUsuario."' as idUsuarioDestinatario";
					break;
				case "contenidoMensaje":
					$fila[0]="'' as contenidoMensaje";
					break;
				case "fechaVisualizacion":
					$fila[0]="NULL as fechaVisualizacion";
					break;
				case "idNotificacionBase":
					$fila[0]="@iNotificacion as idNotificacionBase";
					break;
			}
			
			if($camposSelect=="")
				$camposSelect=$fila[0];
			else
				$camposSelect.=",".$fila[0];
			
			
		}
		foreach($obj->actividadesDelegadas as $a)
		{
			$consulta="SELECT COUNT(*) FROM ".$nombreTablero." WHERE idUsuarioDestinatario=".$obj->idUsuario.
						" AND idNotificacionBase=".$a;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$consulta="insert into  ".$nombreTablero."(".$camposInsert.")
							select ".$camposSelect." from ".$nombreTablero." where idRegistro=".$a;
				$consulta=str_replace("@iNotificacion",$a,$consulta);			
				$query[$x]=$consulta;
				$x++;
			}
			
			$query[$x]="UPDATE ".$nombreTablero." SET idEstado=10 WHERE idRegistro=".$a;
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		
		eB($query);
	}
	
	function registrarAtencionNotificacion()
	{
		global $con;
		$idNotificacion=bD($_POST["iN"]);
		$idTablero=bD($_POST["iT"]);
		$fechaActual=date("Y-m-d H:i:s");
		$nombreTabla="9060_tableroControl_".$idTablero;
		
		if(marcarTareaAtendida($idNotificacion,$idTablero))
			echo "1|".$fechaActual;
		
	}
	
	
	function obtenerHistorialFormatoRegistrado()
	{
		global $con;
		$idDocumento=$_POST["idDocumento"];
		
		
		$consulta="SELECT * FROM 3000_formatosRegistrados WHERE idDocumento=".$idDocumento;
		$fFormato=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM 7035_informacionDocumentos WHERE idRegistro=".$fFormato["idRegistro"];
		$fInformacion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$idProceso=obtenerIdProcesoFormulario($fInformacion["idFormulario"]);
		
		$arrEtapas=array();
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." ORDER BY numEtapa";
		$rEtapas=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($rEtapas))
		{
			$arrEtapas[removerCerosDerecha($fila[0])]=removerCerosDerecha($fila[0]).".- ".$fila[1];
		}
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM 3000_bitacoraFormatos WHERE idRegistroFormato=".$fFormato["idRegistroFormato"]." and idEstadoAnterior<>0 ORDER BY fechaCambio";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$etapaOriginal=$arrEtapas[removerCerosDerecha($fila["idEstadoAnterior"])];
			if($numReg==0)
				$etapaOriginal="En Dise&ntilde;o";
			$etapaCambio=$arrEtapas[removerCerosDerecha($fila["idEstadoActual"])];
			$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaOperacion":"'.$fila["fechaCambio"].
				'","etapaOriginal":"'.cv($etapaOriginal).'","etapaCambio":"'.cv($etapaCambio).
				'","responsable":"'.cv(obtenerNombreUsuario($fila["responsableCambio"])).
				'","comentarios":"'.cv($fila["comentariosAdicionales"]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerXMLFormulario()
	{
		global $con;
		$iF=$_POST["iF"];
		
		$nombreTabla="_".$iF."_tablaDinamica";
		$cadXML='<formXML><recordForm>';
		
		$consulta="SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME='".$nombreTabla."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$cadXML.='<'.$fila["COLUMN_NAME"].'>'.(($fila["COLUMN_KEY"]=="PRI")?"*":"").'('.$fila["DATA_TYPE"].')</'.$fila["COLUMN_NAME"].'>';	
		}
		$cadXML.='</recordForm></formXML>';
		
		echo "1|".bE($cadXML);
	}
	
	function arrancarProcesoTareaMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT iFormulario,iRegistro,llaveTarea FROM 9060_tableroControl_4 WHERE idRegistro=".$obj->iTarea;
		$fTarea=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrLLave=explode("_",bD($fTarea["llaveTarea"]));
		$fTarea["iFormulario"]=$arrLLave[0];
		$fTarea["iRegistro"]=$arrLLave[1];
		$fTarea["etapa"]=$arrLLave[2];
		
		
		$nombreTabla=obtenerNombreTabla($fTarea["iFormulario"]);
		$consulta="select * from ".$nombreTabla." where id_".$nombreTabla."=".$fTarea["iRegistro"];
		$filaRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT objConfiguracion FROM 00010_elementosEtapasProcesosMacroprocesos WHERE idRegistro=".$obj->idElementoMacroProceso;
		$cadObjConfiguracion=$con->obtenerValor($consulta);
		$objConfiguracion=json_decode($cadObjConfiguracion);
		
		$procesoArranque=$objConfiguracion->procesoArranque;
		$etapaArranque=$objConfiguracion->etapaArranque;
		
		$idFormularioBaseDestino=obtenerFormularioBase($procesoArranque);
		$nombreTablaBase=obtenerNombreTabla($idFormularioBaseDestino);
		$idProcesoBase=obtenerIdProcesoFormulario($fTarea["iFormulario"]);
		
		if($con->existeCampo("idProcesoPadre",$nombreTablaBase)=="")
		{
			
			$consulta="alter table `".$nombreTablaBase."` add column `idProcesoPadre` bigint(20) default NULL";
			$con->ejecutarConsulta($consulta);					
		}
		
		if($con->existeCampo("idTareaAsociada",$nombreTablaBase)=="")
		{
			
			$consulta="alter table `".$nombreTablaBase."` add column `idTareaAsociada` bigint(20) default NULL";
			$con->ejecutarConsulta($consulta);					
		}
		
		

		$consulta="SELECT id_".$nombreTablaBase." FROM ".$nombreTablaBase." WHERE idTareaAsociada=".$obj->iTarea;
		$idRegistroInstancia=$con->obtenerValor($consulta);
		if($idRegistroInstancia=="")
		{
			$arrValores["idProcesoPadre"]=$idProcesoBase;
			$arrValores["idTareaAsociada"]=$obj->iTarea;
			$consulta="SELECT actorCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$fTarea["iFormulario"]." AND idRegistro=".$fTarea["iRegistro"]." AND etapaActual=".$fTarea["etapa"]." ORDER BY idRegistroEstado DESC";
			$idActorProceso=$con->obtenerValor($consulta);
			if($idActorProceso=="")
				$idActorProceso=0;
			$cadParametros='{"idFormulario":"'.$fTarea["iFormulario"].'","idRegistro":"'.$fTarea["iRegistro"].'","idProceso":"'.$idProcesoBase.
						'","idActorProceso":"'.$idActorProceso.'","campoTablaDestino":"","etapa":"'.$fTarea["etapa"].'"}';
			$objParametros=json_decode($cadParametros);
			$cacheCalculos=NULL;
			foreach($objConfiguracion->valoresArranque as $vA)
			{
				$objParametros->campoTablaDestino=$vA->campoDestino;
				$fArrancador=array();
				$fArrancador["campoTablaDestino"]=$vA->campoDestino;
				$fArrancador["valor"]=$vA->valor;
				$fArrancador["tipoLlenado"]=$vA->tipoLlenado;
			
				
				
				
				$valorCampo="";
				$valor=$fArrancador["valor"];
				switch($fArrancador["tipoLlenado"])
				{
					case 0: //Ninguno
						
						
					break;
					case 7: //Funci\xF3n de sistema
						if($valor!="")
							$valorCampo=removerComillasLimite(resolverExpresionCalculoPHP($valor,$objParametros,$cacheCalculos));
						
					
					
					break;
					case 6: //Valor de formulario base
						if($valor!="")
						{
							if($valor>0)
							{
								$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$valor;
								$campoMysql=$con->obtenerValor($consulta);
							}
							else
							{
								$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$valor;
								$campoMysql=$con->obtenerValor($consulta);
								
								if($valor==-28)
								{
									$campoMysql="id__".$idFormulario."_tablaDinamica";
								}
								
								
								
							}
	  
							$valorCampo=$filaRegistro[$campoMysql];
						}
					break;
					case 1: //Valor de sesi\xF3n
						$consulta="SELECT valorSesion FROM 8003_valoresSesion WHERE idValorSesion=".$valor;
						$valor=$con->obtenerValor($consulta);
						$valorCampo=$_SESSION[$valor];
					break;
					case 8: //Valor manual
						$valorCampo=$valor;			
					break;
					case 2: //'Valor de sistema
						switch($valor)
						{
							case 8:  //Fecha del sistema
								$valorCampo=date("Y-m-d");
							break;
							case 9:	//Hora del sistema
								$valorCampo=date("H:i:s");
							break;
							case 10:	//Hora del sistema
								$valorCampo=date("Y-m-d H:i:s");
							break;
						}
					break;
				}
				
				if($valorCampo!="")
					$arrValores[$fArrancador["campoTablaDestino"]]=$valorCampo;
			}
			$arrDocumentos=NULL;
			$idRegistroInstancia=crearInstanciaRegistroFormulario($idFormularioBaseDestino,$fTarea["iRegistro"],$etapaArranque,$arrValores,$arrDocumentos,-1,0);
		
			$nuevaLlave=bE($idFormularioBaseDestino."_".$idRegistroInstancia."_".removerCerosDerecha($etapaArranque));
			$consulta="UPDATE 9060_tableroControl_4 SET llaveTarea='".$nuevaLlave."' WHERE llaveTarea='".$fTarea["llaveTarea"]."'";
			$con->ejecutarConsulta($consulta);
		}
		
		
		$idActor=obtenerActorProcesoIdRol($procesoArranque,$objConfiguracion->actorAccesoProceso,$etapaArranque);
		if($idActor=="")
			$idActor=0;
		
		$cadObj='{"idFormulario":"'.$idFormularioBaseDestino.'","idRegistro":"'.$idRegistroInstancia.'","idActorIngreso":"'.$idActor.'","accion":"'.bE("auto").'"}';
		
		echo "1|".$cadObj;
	}
	
	function reiniciarVistaFormulario()
	{
		global $con;
		$iF=$_POST["iF"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 938_configuracionElemVistaFormulario WHERE idElemFormulario IN
					(SELECT idGrupoElemento FROM 937_elementosVistaFormulario WHERE idFormulario=".$iF.")";
		$x++;
		$query[$x]="DELETE FROM 937_elementosVistaFormulario WHERE idFormulario=".$iF;
		$x++;
		
		$query[$x]="DELETE FROM 939_configuracionVistaFormularios WHERE idFormulario=".$iF;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function normalizarFormulario()
	{
		global $con;
		$iF=$_POST["iF"];
		$x=0;
		
		$arrEstilos=array();
		$arrEstilos[1]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[1]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[2]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[2]["estiloAjsute"]="SIUGJ_ControlCombo";
		
		$arrEstilos[3]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[3]["estiloAjsute"]="SIUGJ_ControlCombo";
		
		$arrEstilos[4]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[4]["estiloAjsute"]="SIUGJ_ControlCombo";
		
		
		$arrEstilos[14]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[14]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[15]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[15]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[16]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[16]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[17]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[17]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[18]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[18]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[19]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[19]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		$arrEstilos[31]["estiloBase"]="SIUGJ_Control";
		$arrEstilos[31]["estiloAjsute"]="SIUGJ_ControlEtiqueta";
		
		
		$query[$x]="begin";
		$x++;
		
		foreach($arrEstilos as $tipoControl=>$resto)
		{
			$consulta="SELECT idGrupoElemento FROM 901_elementosFormulario WHERE idFormulario=".$iF." and tipoElemento=".$tipoControl;
			$idGrupoElemento=$con->obtenerListaValores($consulta);
			if($idGrupoElemento=="")
				$idGrupoElemento=-1;
			$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf12='".$resto["estiloAjsute"].
						"' WHERE idElemFormulario IN(".$idGrupoElemento.") AND campoConf12='".$resto["estiloBase"]."'";
			$x++;
			if(($tipoControl==2)||($tipoControl==3)||($tipoControl==4))
			{
				$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf10='400' WHERE idElemFormulario IN(".$idGrupoElemento.")";
				$x++;
				$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf12='campoComboWrapSIUGJAutocompletar',campoConf13='listComboSIUGJGrid' WHERE idElemFormulario IN(".$idGrupoElemento.") and campoConf8=1";
				$x++;
			}
		}
		$consulta="SELECT idGrupoElemento FROM 901_elementosFormulario WHERE idFormulario=".$iF." and tipoElemento=9";
		$idGrupoElemento=$con->obtenerListaValores($consulta);
		if($idGrupoElemento=="")
			$idGrupoElemento=-1;
		$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf2='90',campoConf1='870'  WHERE idElemFormulario IN(".$idGrupoElemento.")";
		$x++;
		
		$consulta="SELECT idGrupoElemento FROM 901_elementosFormulario WHERE idFormulario=".$iF." and tipoElemento in(24,5,6,7,11,12)";
		$idGrupoElemento=$con->obtenerListaValores($consulta);
		if($idGrupoElemento=="")
			$idGrupoElemento=-1;
		$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf6='42'  WHERE idElemFormulario IN(".$idGrupoElemento.")";
		$x++;
		
		$consulta="SELECT idGrupoElemento FROM 901_elementosFormulario WHERE idFormulario=".$iF." and tipoElemento in(21)";
		$idGrupoElemento=$con->obtenerListaValores($consulta);
		if($idGrupoElemento=="")
			$idGrupoElemento=-1;
		$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf10='150',campoConf12='comboWrapSIUGJControl'  WHERE idElemFormulario IN(".$idGrupoElemento.")";
		$x++;
		
		$consulta="SELECT idGrupoElemento FROM 901_elementosFormulario WHERE idFormulario=".$iF." and tipoElemento in(8)";
		$idGrupoElemento=$con->obtenerListaValores($consulta);
		if($idGrupoElemento=="")
			$idGrupoElemento=-1;
		$query[$x]="UPDATE 904_configuracionElemFormulario SET campoConf10='150',campoConf12='campoFechaSIUGJ'  WHERE idElemFormulario IN(".$idGrupoElemento.")";
		$x++;
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerTareasProceso()
	{
		global $con;
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		
		
		$consulta="SELECT idRegistro,fechaAsignacion AS fechaRegistro,fechaLimiteAtencion AS fechaMaximaAtencion,
					iFormulario,iRegistro,tipoNotificacion,idEstado,usuarioDestinatario,
					(SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad=t.codigoUnidad) AS despacho  FROM 9060_tableroControl_4 t
					WHERE numeroCarpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY idRegistro";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
	
	
	}
	
	
	function removerFuncionSeccionProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta=array();
		
		$consulta[$x]="begin";
		$x++;
		
		$campo="";
		switch($obj->tipoElemento)
		{
			case 1:
				$campo="idFuncionVisualizacion";
			break;
			case 2:
				$campo="idFuncionEdicion";
				
				$consulta[$x]="UPDATE 203_elementosDTD SET funcionEdicionForzada=0 WHERE idElementoDTD=".$obj->iElemento;
				$x++;
			break;
		}
		$consulta[$x]="UPDATE 203_elementosDTD SET ".$campo."=NULL WHERE idElementoDTD=".$obj->iElemento;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function addFuncionSeccionProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$campo="";
		switch($obj->tipoElemento)
		{
			case 1:
				$campo="idFuncionVisualizacion";
			break;
			case 2:
				$campo="idFuncionEdicion";
			break;
		}
		$consulta="UPDATE 203_elementosDTD SET ".$campo."=".$obj->valor." WHERE idElementoDTD=".$obj->iElemento;
		eC($consulta);
		
	}
	
	
?>