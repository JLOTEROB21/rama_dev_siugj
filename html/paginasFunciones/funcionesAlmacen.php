<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cAlmacen.php");
	include_once("cTesoreria.php");
	
	if(isset($_SESSION["leng"]))
	{
		$z=0;
		$consultaS;
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				guardarNombreSeccionInfoProducto();
			break;
			case 2:
				eliminarSeccionInfoProducto();
			break;
			case 3:
				obtenerPedidosRecibidosAlmacen();
			break;
			case 4:
				obtenerPedidosPendientesAlmacen();
			break;
			case 5:
				obtenerPedidosCanceladosAlmacen();
			break;
			case 6:
				obtenerProductosPedidos();
			break;
			case 7:
				guardarTemporalPedido();
			break;
			case 8:
				guardarObservacionesProducto();
			break;
			case 9:
				obtenerObservacionesProducto();
			break;
			case 10:
				registrarPedido();
			break;
			case 11:
				obtenerPedidosValidacion();
			break;
			case 12:
				cancelarPedidoV1();
			break;
			case 13:
				borrarRegistroPedido();
			break;
			case 14:
				obtenerCategoriasAlmacen();
			break;
			case 15:
				obtenerFolioPedido();
			break;
			case 16:
				guardarNuevoPedido();
			break;
			case 17:
				obtenerSanciones();
			break;
			case 18:
				obtenerDatosSancion();
			break;
			case 19:
				operacionesSancion();
			break;
			case 20:
				eliminarSancion();
			break;
			case 21:
				obtenerConceptosLibres();
			break;
			case 22:
				eliminarCategoria();
			break;
			case 23:
				guardarCategoria();
			break;
			case 24:
				guardarAlmacen();
			break;
			case 25:
				obtenerCatAlmacen();
			break;
			case 26:
				obtenerCatNoAlmacen();
			break;
			case 27:
				ligarCategoriaAlmacen();
			break;
			case 28:
				obtenerInventarioAlmacen();
			break;
			case 29:
				agendarFechaEntrega();
			break;
			case 30:
				obtenerExistenciaAlmacenProducto();
			break;
			case 31:
				obtenerSeccionesAlmacen();
			break;
			case 32:
				eliminarSeccionesAlmacen();
			break;
			case 33:
				obtenerPartidas();
			break;
			case 34:
				obtenerComprometidoEntregas();
			break;
			case 35:
				obtenerDeptosEntregaProducto();
			break;
			case 36:
				guardarEntregaAlmacen();
			break;
			case 37:
				validarFechaTiempoEstimado();
			break;
			case 38:
				guardarConfPartidas();
			break;
			case 39:
				obtenerConfiguracionProducto();
			break;
			case 40:
				obtenerRegistrosForDin();
			break;
			case 41:
				obtenerRegistroForDinVolumen();
			break;
			case 42:
				obtenerSolicitudesAlmacen();
			break;
			case 43:
				detallesPedidoDetalle();
			break;
			case 44:
				obtenerProgramaDeptoCiclo();
			break;
			case 45:
				obtenerExistenciaProductoAlmacen();
			break;
			case 46:
				obtenerDatosPedido();
			break;
			case 47:
				obtenerHistorialProv();
			break;
			case 48:
				obtenerPedidosPendiestesPorFecha();
			break;
			case 49:
				obtenerFacturaPedido();
			break;
			case 50:
				obtenerInformacionEntregaProgramada();
			break;
			case 51:
				obtenerInventario();
			break;
			case 52:
				guardarCodigoInventario();
			break;
			case 53:
				obtenerElementosAsociados();
			break;
			case 54:
				guardarElementosAsociado();
			break;
			case 55:
				obtenerCodigoGenerico();
			break;
			case 56:
				verificarCodigoInventario();
			break;
			case 57:
				asociarElementoInventariado();
			break;
			case 58:
				quitarElementoAsociado();
			break;
			case 59:
				obtenerCuentasAsociadasInventario();
			break;
			case 60:
				agregarCuentaInventario();
			break;
			case 61:
				obtenerCuentasDisponiblesInventario();
			break;
			case 62:
				eliminarCuentasInventario();
			break;
			case 63:
				obtenerInventarioTabla();
			break;
			case 64:
				inventarioAmortizacion();
			break;
			case 65:
				guardarConfcuenta();
			break;
			case 66:
				borrarConfcuenta();
			break;
			case 67:
				obtenerUsuariosDepto();
			break;
			case 68:
				guardarResponsableInv();
			break;
			case 69:
				validarNoPiezasDetallePedido();
			break;
			case 70:
				obtenerEntregasPendientesAlmacen();
			break;
			case 71:
				verificarEntregaInventariable();
			break;
			case 72:
				modificarEstadoEntrega();
			break;
			case 73:
				buscarUsuarios();
			break;
			case 74:
				obtenerNoInventario();
			break;
			case 75:
				guardarEntregadoListaEntrega();
			break;
			case 76:
				obtenerEntregasRealizadas();
			break;
			case 77:
				obtenerDatosFactura();
			break;
			case 78:
				obtenerEntregasAgendadasPorProducto();
			break;
			case 79:
				obtenerExistenciasAlmacen();
			break;
			case 80:
				removerCategoriaAlmacen();
			break;
			case 81:
				obtenerDatosProveedor();
			break;
			case 82:
				obtenerHistorialInv();
			break;
			case 83:
				obtenerProductosAlmacen();
			break;
			case 84:
				removerProducto();
			break;
			case 85:
				obtenerProductosPendientesEntrega();
			break;
			case 86:
				obtenerDetallePedido();
			break;
			case 87:
				obtenerProductosRecibidos();
			break;
			case 88:
				obtenerProductosEstado();
			break;
			case 89:
				obtenerSolicitudesEntrega();
			break;
			case 90:
				cambiarStatusPedido();
			break;
			case 91:
				registrarEntradaPedido();
			break;
			case 92:
				reagendarPedido();
			break;
			case 93:
				reestructurarPedido();
			break;
			case 94:
				obtenerSituacionProductosDepto();
			break;
			case 95:
				obtenerProveedores();
			break;
			case 96:
				obtenerPedidosProveedores();
			break;
			case 97:
				eliminarProveedor();
			break;
			case 98:
				obtenerProveedoresValidacion();
			break;
			case 99:
				cambiarStatusProveedor();
			break;
			case 100:
				registrarSolicitudEntrega();
			break;
			case 101:
				obtenerSolicitudesSolicitudes();
			break;
			case 102:
				cambiarStatusSolicitudPedido();
			break;
			case 103:
				agendarEntregaSolicitud();
			break;
			case 104:
				obtenerSolicitudesAgendadasEntrega();
			break;
			case 105:
				cambiarEntregaProducto();
			break;
			case 106:
				registrarEntregaProducto();
			break;
			case 107:
				obtenerHistorialTraslado();
			break;
			case 108:
				obteneSolicitudesPedidos();
			break;
			case 109:
				obtenerSolicitudesPedidosCumplir();
			break;
			case 110:
				solicitarProductoAlmacen();
			break;
			case 111:
				asignarResponsableInventario();
			break;
			case 112:
				obtenerInventarioPorConcepto();
			break;
			case 113:
				obtenerProductoEsperaInventario();
			break;
			case 114:
				asignarFolioInventario();
			break;
			case 115:
				obtenerCategoriasObjetoGasto();
			break;
			case 116:
				guardarCategoriaObjetoGasto();
			break;
			case 117:
				removerCategoriaObjetoGasto();
			break;
			case 118:
				obtenerCategoriasDisponiblesOG();
			break;
			case 119:
				asociarCategoriaAlmacen();
			break;
			case 120:
				obtenerCategoriasObjetoGastoAlmacen();
			break;
			case 121:
				guardarProgramacionReceta();
			break;
			case 122:
				obtenerProgramacionReceta();
			break;
			case 123:
				eliminarPlaneacionReceta();
			break;
			case 124:
				obtenerSemanasPlaneadas();
			break;
			case 125:
				eliminarPlenacionSemanal();
			break;
			case 126:
				registrarPlaneacionSemanal();
			break;
			case 127:
				obtenerSemanasDisponiblesPlaneacionSemanal();
			break;
			case 128:
				obtenerPlaneacionRecetasSemana();
			break;
			case 129:
				obtenerInsumosRequeridos();
			break;
			case 130:
				registrarBajaProductoAlmacenProduccion();
			break;
			case 131:
				registrarProductosProducidos();
			break;
			case 132:
				registrarProductosCancelados();
			break;
			case 133:
				registrarSalidaProductoProducidos();
			break;
			case 134:
				guardarConfiguracionAsientoMovimientoAlmacen();
			break;
			case 135:
				obtenerDatosConceptos();
			break;
			case 136:
				removerConfiguracionContableMovimiento();
			break;
			case 137:
				obtenerProductosPendientesEntregaCiclo();
			break;
			case 138:
				obtenerDetallePedidoCiclo();
			break;
			case 139:
				obtenerProductosRecibidosCiclo();
			break;
			case 140:
				obtenerProductosEstadoCiclo();
			break;
			case 141:
				registrarEntradaPedidoCiclo();
			break;
			case 142:
				obtenerSituacionProductosDeptoCiclo();
			break;
			case 143:
				obtenerDistribucionesSolicitadasCiclo();
			break;
			case 144:
				registrarAlmacen();
			break;
			case 145:
				obtenerCategoriasAlmacenV2();
			break;
			case 146:
				obtenerProductosDisponiblesV2();
			break;
			case 147:
				obtenerCostoProducto();
			break;
			case 148:
				actualizarCostoProducto();
			break;
			case 149:
				removerCostoProducto();
			break;
			case 150:
				registrarCostoProducto();
			break;
			case 151:
				obtenerPedidosAlmacen();
			break;
			case 152:
				registrarPedidosAlmacen();
			break;
			case 153;
				verificarNoExistenciaNoFactura();
			break;
			case 154:	
				guardarComprobacionRecepcionPedido();
			break;
			case 155:
				obtenerProductosTienda();
			break;
			case 156:
				obtenerCategoriasAlmacenes();
			break;
			case 157:
				agregarProductoCarrito();
			break;
			case 158:
				obtenerCategoriasModeloAlmacen();
			break;
			case 159:
				removerCategorias();
			break;
			case 160:
				obtenerDimensionesDisponibles();
			break;
			case 161:
				obtenerDimensionesCategoria();
			break;
			case 162:
				obtenerDimensionesCosteoProducto();
			break;
			case 163:
				obtenerDimensionesDisponiblesAtributo();
			break;
			case 164:
				guardarAtributosProducto();
			break;
			case 165:
				obtenerDimensionesConfiguradasProducto();
			break;
			case 166:
				removerAtributosProducto();
			break;
			case 167:
				guardarCodigoProducto();
			break;
			case 168:
				guardarPrecioProducto();
			break;
			case 169:
				obtenerHistorialPrecioProducto();
			break;
			case 170:
				obtenerImagenesGaleriaProductos();
			break;
			case 171:
				removerImagenProducto();
			break;
			case 172;
				guardarImagenProducto();
			break;
			case 173:
				obtenerDimensionesClavesProducto();
			break;
			case 174:
				obtenerDatosProductoVenta();
			break;
			case 175:
				buscarProductoDescripcion();
			break;
			case 176:
				registrarDevolucionesProveedor();
			break;
			case 177:
				obtenerDevolucionesProveedor();
			break;
			case 178:			
				obtenerDatosSolicitudPedido();
			break;
			case 179:
				obtenerBajaProductos();
			break;
			case 180:
				obtenerExistenciaProducto();
			break;
			case 181:
				obtenerDatosPedidoDevolucion();
			break;
			case 182:
				obtenerPedidosProveedorRecibidos();
			break;
			case 183:
			
				registrarBajaProductoAlmacen();
			break;
			case 184:
				obtenerDescuentosProducto();
			break;
			case 185:
				guardarDescuentoProducto();
			break;
			case 186:
				removerDescuentoProducto();
			break;
			case 187:
				registrarAltaProductoAlmacen();
			break;
			case 188:
				obtenerAltaProductos();
			break;
			case 189:
				buscarProductoAlmacen();
			break;
			case 190:
				buscarDatosProductoClave();
			break;
			case 191:
				finalizarDescuento();
			break;
			case 200:
				obtenerUnidadesMedidaEquivalente();
			break;
			case 201:
				obtenerUnidadesMedidaDisponibles();
			break;
			case 202:
				agregarUnidadMedidaEquivalencia();
			break;
			case 203:
				removerUnidadMedidaEquivalencia();
			break;
			case 204:
				buscarProveedorAlmacen();
			break;
			case 205:
				registrarCompraAlmacen();
			break;
			case 206:
				obtenerComprasAlmacen();
			break;
			case 207:
				registrarPedidosAlmacenV2();
			break;
			case 208:
				registrarCancelacionPedidosAlmacenV2();
			break;
			case 209:
				registrarCancelacionCompraAlmacenV2();
			break;
			case 210:
				obtenerTransferenciasProductos();
			break;
			case 211:
				registrarTransferenciasProductos();
			break;
			case 212:
				validarExistenciaTransferenciasProductos();
			break;
			case 213:
				registrarCancelacionTransferencia();
			break;
			case 214:
				obtenerDatosSolicitudTransferencia();
			break;
			
		}
	}
	
	
	function guardarNombreSeccionInfoProducto()
	{
		global $con;
		global $SO;
		$idCategoria=$_POST["idCategoria"];
		$idSeccion=$_POST["idSeccion"];
		$nSeccion=$_POST["nSeccion"];
		$descripcion=$_POST["descripcion"];
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($idSeccion=="-1")
			{
				$query="insert into 9032_seccionesCategoriaProducto(nombreSeccion,descripcion,idCategoriaProducto) values('".cv($nSeccion)."','".cv($descripcion)."',".$idCategoria.")";
				if(!$con->ejecutarConsulta($query))			
				{
					echo "|";
					return;
				}
				$idSeccion=$con->obtenerUltimoID();	
				$descripcion="";
				if($SO==1)
				{
					$nFormulario=utf8_decode("Ficha de categoría: ".$nSeccion);
					$descripcion=utf8_decode("Formulario de registro de datos complementarios de producto, para aquellos productos que pertenezcan a la categoría de: ".cv($nSeccion));
				}
				else
				{
					$nFormulario=("Ficha de categoría: ").$nSeccion;
					$descripcion="Formulario de registro de datos complementarios de producto, para aquellos productos que pertenezcan a la categoría de: ".cv($nSeccion);
				}
					
				$objFormulario='{
									"nombreFormulario":"'.$nFormulario.'",
									"descripcion":"'.$descripcion.'",
									"titulo":"'.$nFormulario.'",
									"idProceso":"0",
									"idEtapa":"1",
									"idFrmEntidad":"-1",
									"frmRepetible":"0",
									"formularioBase":"1",
									"estadoInicial":"1",
									"eliminable":"0",
									"tipoFormulario":"30",
									"mostrarTableroControl":"0",
									"complemetario":"'.$idSeccion.'"
								}';
				
				$idFormulario=crearFormulario($objFormulario);
				if($idFormulario=="-1")
				{
					echo "|";
					return;
				}
				$consulta[$x]="update 9032_seccionesCategoriaProducto set idFormulario=".$idFormulario." where idSeccionInfoCategoria=".$idSeccion;
			}
			else
				$consulta[$x]="update 9032_seccionesCategoriaProducto set nombreSeccion='".cv($nSeccion)."',descripcion='".cv($descripcion)."' where idSeccionInfoCategoria=".$idSeccion;
			$x++;
			$consulta[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($consulta))
			{
				$query="SELECT * FROM 9032_seccionesCategoriaProducto WHERE idCategoriaProducto=".$idCategoria;
				$arrDatos=$con->obtenerFilasArreglo($query);
				echo "1|".uEJ($arrDatos);
			}
		}
		else
			echo "|";
	}
	
	function eliminarSeccionInfoProducto()
	{
		global $con;
		$idSeccion=$_POST["idSeccion"];
		$consulta="select idFormulario from 9032_seccionesCategoriaProducto where idSeccionInfoCategoria=".$idSeccion;
		$idFormulario=$con->obtenerValor($consulta);	
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 9032_seccionesCategoriaProducto where idSeccionInfoCategoria=".$idSeccion;
		$x++;
		$query[$x]="delete from 900_formularios where idFormulario=".$idFormulario;
		$x++;
		$query[$x]="commit";
		eB($query);
	}
	
	function obtenerPedidosRecibidosAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idPedido,folioPedido,idProveedor_ult,txtRazonSocial2,date_format(fechaRecepcion,'%d/%m/%Y') as fechaRecepcion,date_format(fechaRecibido,'%d/%m/%Y') as fechaRecibido
				   FROM 9102_PedidoCabecera p, _405_tablaDinamica pr
				   WHERE idProveedor_ult=id__405_tablaDinamica AND idAlmacen=".$idAlmacen." AND status_pedido=0 ".$condWhere." ORDER BY  fechaRecepcion ASC";
		$res=$con->obtenerFilas($consulta);	
		$nreg=$con->filasAfectadas;
		
		$arrPedidos="";
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","idProv":"'.$fila[2].'","txtRazonSocial2":"'.$fila[3].'","fechaRecepcion":"'.$fila[4].'","fechaRecibido":"'.$fila[5].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function obtenerPedidosPendientesAlmacen()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$idAlmacen=$_POST["idAlmacen"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idPedido,folioPedido,idProveedor_ult,txtRazonSocial2,date_format(fechaRecepcion,'%d/%m/%Y') as fechaRecepcion,date_format(fechaAgenda,'%d/%m/%Y' )as fechaAgenda,date_format(fechaSolicitada,'%d/%m/%Y' )as fechaSolicitada,idFactura
				   FROM 9102_PedidoCabecera p, _405_tablaDinamica pr
				   WHERE idProveedor_ult=id__405_tablaDinamica AND idAlmacen=".$idAlmacen." AND fechaRecepcion<>'0000-00-00' and fechaRecepcion is not null and status_pedido=1 ".$condWhere." 
				   
				   ORDER BY  folioPedido ASC limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);	
		
		$consulta="SELECT count(*)
				   FROM 9102_PedidoCabecera p, _405_tablaDinamica pr
				   WHERE idProveedor_ult=id__405_tablaDinamica AND idAlmacen=".$idAlmacen." AND fechaRecepcion<>'0000-00-00' and fechaRecepcion is not null and status_pedido=1 ".$condWhere."";
		
		$nreg=$con->obtenerValor($consulta);
		
		$arrPedidos="";
		while($fila=mysql_fetch_row($res))
		{
			
			if($fila[7]=="")
				$fila[7]="-1";
			
			
			$obj='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","idProv":"'.$fila[2].'","txtRazonSocial2":"'.$fila[3].'","fechaRecepcion":"'.$fila[4].'","fechaAgenda":"'.$fila[5].'","fechaSolicitada":"'.$fila[6].'","idFacturaPedido":"'.$fila[7].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function obtenerPedidosCanceladosAlmacen()
	{
				global $con;
		$idAlmacen=$_POST["idAlmacen"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idPedido,folioPedido,idProveedor_ult,txtRazonSocial2,fechaRecepcion 
				   FROM 9102_PedidoCabecera p, _405_tablaDinamica pr
				   WHERE idProveedor_ult=id__405_tablaDinamica AND idAlmacen=".$idAlmacen." AND status_pedido=2 ".$condWhere." ORDER BY  fechaRecepcion ASC";
		$res=$con->obtenerFilas($consulta);	
		$nreg=$con->filasAfectadas;
		
		$arrPedidos="";
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","idProv":"'.$fila[2].'","txtRazonSocial2":"'.$fila[3].'","fechaRecepcion":"'.$fila[4].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function obtenerProductosPedidos()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT  d.idProducto,nombreProducto,clave_Art,descripcion,cantidad,idPedidoDetalle,idMarca,modelo,costoUnitario,iva,idPedidoDetalle FROM 9103_PedidoDetalle d,9101_CatalogoProducto p WHERE idPedido=".$idPedido." AND p.idProducto=d.idProducto ".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrPedidos="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[0];
			$objP=$con->obtenerValor($consulta);
			if($objP=="")
				$objP="-1";

			$consulta="SELECT *FROM 9306_confPartidaAlmacen WHERE clave='".$objP."'";
			$filaConf=$con->obtenerPrimeraFila($consulta);
			if(!$filaConf)
			{
				$filaConf[2]="-1";
				$filaConf[3]="-1";
				$filaConf[4]="-1";
			}
			
			$conMarca="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fila[6];
			$marca=$con->obtenerValor($conMarca);
			
			$total=0;
			$totalPieza=0;
			if(($fila[8]!="") || ($fila[8]!="")) //costoU 
			{
				//echo "costoUnitario".$fila[8];
				$importeIva=0;
				if(($fila[9]!="") || ($fila[9]!=0)) //iva
				{
					//echo $fila[9];
					$importeIva=$fila[8]*(".".$fila[9]);
					//echo $importeIva=$fila[8]*(".".$fila[9]);
				}
				//echo "importeIva".$importeIva;
				$totalPieza=$fila[8]+$importeIva;
				if(($fila[4]!="") || ($fila[4]!=0))
				{
					$total=$totalPieza*$fila[4];
				}
			}
			
			$arregloDist='';
			$cabeceraT='<table>';
			$cuerpo='';
			$existeCabecera=0;
			$cuerpoT='';
			
			$distribucion="SELECT unidad,tituloPrograma,cantidad,p.idPrograma,o.codigoUnidad FROM 817_organigrama o,517_programas p,9301_distribucionProducto d 
							WHERE  p.idPrograma=d.idPrograma AND o.codigoUnidad=d.codigoUnidad AND idPedidoDetalle=".$fila[5];
			$resD=$con->obtenerFilas($distribucion);				
			$numDist=$con->filasAfectadas;
			if($numDist>0)
			{
				$cuerpoT='<tr><td width=\"300\" class=\"letraRojaSubrayada8\">Departamento</td><td width=\"450\" class=\"letraRojaSubrayada8\">Programa</td><td width=\"80\" class=\"letraRojaSubrayada8\">Cantidad</td><td width=\"80\" class=\"letraRojaSubrayada8\">Existencia</td></tr>';
			}
			
			while($filaD=mysql_fetch_row($resD))
			{
					$existenciaD=obtenerExistenciaProgramaDepto($fila[0],$filaD[3],$filaD[4],$idAlmacen);
					$cuerpo.='<tr><td width=\"300\">'.$filaD[0].'</td><td width=\"450\">'.$filaD[1].'</td><td width=\"80\">'.$filaD[2].'</td><td width=\"80\">'.$existenciaD.'</td></tr>';
			}
			
			$finalT='</table>';
			
			$arregloDist=$cabeceraT.$cuerpoT.$cuerpo.$finalT;
			
			
			$conEstado="SELECT estado FROM 9300_temporalPedido WHERE idPedido=".$idPedido." AND idProducto=".$fila[0];
			$estado=$con->obtenerValor($conEstado);
			if($estado=="")
				$estado=0;
			
			$obj='{"idProducto":"'.$fila[0].'","nombreProducto":"'.$fila[1].'","clave_Art":"'.$fila[2].'","descripcion":"'.$fila[3].'","cantidad":"'.$fila[4].'","estado":"'.$estado.'","distribucion":"'.$arregloDist.'","marca":"'.cv($marca).'","modelo":"'.cv($fila[7]).'","costoU":"'.$fila[8].'","iva":"'.$fila[9].'","costoNetoUnidad":"'.$totalPieza.'","total":"'.$total.'","idPedidoDetalle":"'.$fila[10].'","idFormulario":"'.$filaConf[2].'","idTipoR":"'.$filaConf[3].'","inventariable":"'.$filaConf[4].'","folio":"'.$folio.'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function guardarTemporalPedido()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$idProducto=$_POST["idProducto"];
		$estado=$_POST["estado"];
		
		$consulta="begin";
		
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			$existe="SELECT idPedidoVSRegistro FROM 9300_temporalPedido WHERE idPedido=".$idPedido." AND idProducto=".$idProducto;
			$id=$con->obtenerValor($existe);
			
			if($id=="")
			{
				$query[$ct]="INSERT INTO 9300_temporalPedido (idPedido,idProducto,estado) VALUES (".$idPedido.",".$idProducto.",".$estado.")";
				$ct++;
			}
			else
			{
				$query[$ct]="UPDATE 9300_temporalPedido SET estado=".$estado." WHERE idPedidoVSRegistro=".$id;
				$ct++;
				$query[$ct]="UPDATE 9300_temporalPedido SET observaciones='' WHERE idPedidoVSRegistro=".$id;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "|";
		}
	}
	
	function guardarObservacionesProducto()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$idProducto=$_POST["idProducto"];
		$observaciones=$_POST["observaciones"];
		
		$existe="SELECT idPedidoVSRegistro FROM 9300_temporalPedido WHERE idPedido=".$idPedido." AND idProducto=".$idProducto;
		$id=$con->obtenerValor($existe);
		
		if($id=="")
		{
			$query="INSERT INTO 9300_temporalPedido (idPedido,idProducto,estado) VALUES (".$idPedido.",".$idProducto.",2)";
		}
		else
		{
			$query="UPDATE 9300_temporalPedido SET observaciones='".cv($observaciones)."',estado=2 WHERE idPedidoVSRegistro=".$id;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	
	}
	
	function obtenerObservacionesProducto ()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$idPedido=$_POST["idPedido"];
		
		$consulta="SELECT observaciones FROM 9300_temporalPedido WHERE idPedido=".$idPedido." AND idProducto=".$idProducto;
		$observaciones=$con->obtenerValor($consulta);
		
		if($observaciones=="")
			echo "1|";
		else
			echo "2|".$observaciones;
	}
	
	function registrarPedido()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$fecha=cambiaraFechaMysql($_POST["fecha"]);
		$tipo=$_POST["tipoR"];
		$idAlmacen=$_POST["idAlmacen"];
		
		if($tipo==0)
		{
			$consulta="begin";
			
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				$observaciones=$_POST["observacionesF"];
				$noFactura=$_POST["noFactura"];
				$conNumeroMov="SELECT noMovimiento FROM 903_variablesSistema for update";
				$ultimoNumero=$con->obtenerValor($conNumeroMov);
				$nuevoNumero=$ultimoNumero+1;
				
				$query[$ct]="UPDATE 903_variablesSistema SET noMovimiento=".$nuevoNumero;
				$ct++;
				$query[$ct]="commit";
				if($con->ejecutarBloque($query))
				{
					$consulta2="begin";
					if($con->ejecutarConsulta($consulta2))
					{
						$x=0;
						
						$query[$x]="UPDATE 9102_PedidoCabecera SET fechaRecibido='".$fecha."',status_pedido=".$tipo.",noMovimiento=".$nuevoNumero.",observaciones='".cv($observaciones)."',noFactura='".cv($noFactura)."' WHERE idPedido=".$idPedido;
						$x++;
						
						$consultaD="SELECT idPedidoDetalle,idProducto FROM 9103_PedidoDetalle WHERE idPedido=".$idPedido;
						$res=$con->obtenerFilas($consultaD);
						while($fila=mysql_fetch_row($res))
						{
							$distribucion=obtenerConfiguracionProducto($fila[1]);
							if(($distribucion!="")&&($distribucion!="0"))
							{

								$cadenaRes=explode("|",$distribucion);
								$inventariable=0;
								if(isset($cadenaRes[3]))
									$inventariable=$cadenaRes[3];
								$tipoR=0;
								if(isset($cadenaRes[2]))
									$tipoR=$cadenaRes[2];
								$idFormulario=0;
								if(isset($cadenaRes[1]))
									$idFormulario=$cadenaRes[1];
								
								$conExistencia="SELECT codigoUnidad,idPrograma,partida,cantidad FROM 9301_distribucionProducto WHERE idPedidoDetalle=".$fila[0];
								$resE=$con->obtenerFilas($conExistencia);
								while($filaE=mysql_fetch_row($resE))
								{
									$query[$x]="INSERT INTO 9302_existenciaAlmacen (idAlmacen,idPedido,idProducto,codigoUnidad,idPrograma,partida,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,noMovimiento,idPedidoDetalle)
												VALUES(".$idAlmacen.",".$idPedido.",".$fila[1].",'".$filaE[0]."',".$filaE[1].",".$filaE[2].",".$filaE[3].",'".$fecha."',1,".$_SESSION["idUsr"].",1,".$nuevoNumero.",".$fila[0].")";
									$x++;	
								}
								
								if(($inventariable==1) && ($tipoR==1))
								{
									$conIdsFormulario="SELECT id__".$idFormulario."_tablaDinamica FROM _".$idFormulario."_tablaDinamica WHERE idReferencia=".$fila[0];
									$resIds=$con->obtenerFilas($conIdsFormulario);
									
									//for($y=0;$y<$filaE[3];$y++)
	//									{
									while($filaR=mysql_fetch_row($resIds))
									{
										$conInsetar="INSERT INTO 9307_inventario (idDetallePedido,idProducto,codigo,idFormulario,idTablaDinamica,idAlmacen,fechaRecepcion,tipoAsociacion)
													VALUES(".$fila[0].",".$fila[1].",'-1',".$idFormulario.",".$filaR[0].",".$idAlmacen.",'".$fecha."',1)";
										//echo $conInsetar;
										if($con->ejecutarConsulta($conInsetar))
										{
											$idInventario=$con->obtenerUltimoID();
											
											$query[$x]="INSERT INTO 9308_historialTraslados (idInventario,tipoOrigen,origen,tipoDestino,destino,idResponsable,fechaMovimiento)
														VALUES(".$idInventario.",0,".$idAlmacen.",0,".$idAlmacen.",-1,'".$fecha."')";
											$x++;	
										}
									}
								}
							}
						}
						$query[$x]="commit";
						if($con->ejecutarBloque($query))
							echo "1|";
						else
							echo "|";
					}
				}
			}
		}
		else
		{
			//$conNoMov="SELECT noMovimiento FROM 9102_PedidoCabecera WHERE idPedido=".$idPedido;
//			$noMov=$con->obtenerValor($conNoMov);
//			if($noMov=="")
//			{
//				echo "1|";
//			}
//			else
//			{
//				$conNumeroN="begin";
//				if($con->ejecutarConsulta($conNumeroN))
//				{
//					$ct=0;
//					$conNumeroMov="SELECT noMovimiento FROM 903_variablesSistema for update";
//					$ultimoNumero=$con->obtenerValor($conNumeroMov);
//					$nuevoNumero=$ultimoNumero+1;
//					
//					$query1[$ct]="UPDATE 903_variablesSistema SET noMovimiento=".$nuevoNumero;
//					$ct++;
//					$query1[$ct]="commit";
//					
//					if($con->ejecutarBloque($query1))
//					{
//						$consulta="begin";
//						if($con->ejecutarConsulta($consulta))
//						{
//							  $z=0;
//							  $conExistencias="SELECT *FROM 9302_existenciaAlmacen WHERE noMovimiento=".$noMov;
//							  $res=$con->obtenerFilas($conExistencias);
//							  
//							  while($filaC=mysql_fetch_row($res))
//							  {
//								  $query[$z]="INSERT INTO 9302_existenciaAlmacen (idAlmacen,idPedido,idProducto,codigoUnidad,idPrograma,partida,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,noMovimiento,idPedidoDetalle)
//											  VALUES(".$filaC[1].",".$filaC[2].",".$filaC[3].",'".$filaC[4]."',".$filaC[5].",".$filaC[6].",".$filaC[7].",'".$fecha."',-1,".$_SESSION["idUsr"].",1,".$nuevoNumero.",".$filaC[15].")";
//								  //echo $query[$x];
//								  $z++;	
//							  }
//							  $query[$z]="UPDATE 9102_PedidoCabecera SET fechaRecibido='".$fecha."',status_pedido=".$tipo." WHERE idPedido=".$idPedido;
//							  $z++;
//							  $query[$z]="commit";
//							  
//							  if($con->ejecutarBloque($query))
//								  echo "1|";
//							  else
//								  echo "|";
//						}
//						else
//						{
//							echo "|";
//						}
//					}
//					else
//					{
//						echo "|";
//					}
//				}
//			}
			
			$query="UPDATE 9102_PedidoCabecera SET fechaRecibido='".$fecha."',status_pedido=".$tipo." WHERE idPedido=".$idPedido;
			if($con->ejecutarConsulta($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerPedidosValidacion()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idPedido,folioPedido,txtRazonSocial2,fechaRecepcion,idProveedor_ult,fechaRecibido,idAlmacen 
				   FROM 9102_PedidoCabecera p, _405_tablaDinamica pr
				   WHERE idProveedor_ult=id__405_tablaDinamica AND status_pedido=3 ".$condWhere." ORDER BY  fechaRecepcion ASC";
		$res=$con->obtenerFilas($consulta);	
		$nreg=$con->filasAfectadas;
	
		$arrPedidos="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","txtRazonSocial2":"'.$fila[2].'","fechaRecepcion":"'.$fila[3].'","idProveedor_ult":"'.$fila[4].'","fechaRecibido":"'.$fila[5].'","idAlmacen":"'.$fila[6].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function cancelarPedidoV1()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$fecha=cambiaraFechaMysql($_POST["fecha"]);
		$motivo=$_POST["motivo"];
		
		$query="UPDATE 9102_PedidoCabecera SET fechaRecibido='".$fecha."',status_pedido=2,observaciones='".$motivo."' WHERE idPedido=".$idPedido;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
			
	}
	
	function borrarRegistroPedido()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$fecha=date("Y-m-d");
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$conNumeroMov="SELECT noMovimiento FROM 903_variablesSistema for update";
			$ultimoNumero=$con->obtenerValor($conNumeroMov);
			$nuevoNumero=$ultimoNumero+1;
			
			$query[$ct]="UPDATE 903_variablesSistema SET noMovimiento=".$nuevoNumero;
			$ct++;
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
			{
				$conNumero="SELECT noMovimiento FROM 9102_PedidoCabecera WHERE idPedido=".$idPedido;
				$numero=$con->obtenerValor($conNumero);
				if($numero=="")
					$numero=0;
					
				$consulta2="begin";
				if($con->ejecutarConsulta($consulta2))
				{
					$ct=0;
					
					$query[$ct]="UPDATE 9102_PedidoCabecera SET noMovimiento=".$nuevoNumero.",status_pedido=1 WHERE idPedido=".$idPedido;
					$ct++;
					
					$conElementos="SELECT *FROM 9302_existenciaAlmacen WHERE noMovimiento=".$numero;
					$res=$con->obtenerFilas($conElementos);
					
					while($fila=mysql_fetch_row($res))
					{
						$query[$ct]="INSERT INTO 9302_existenciaAlmacen (idAlmacen,idPedido,idProducto,codigoUnidad,idPrograma,partida,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,noMovimiento,idPedidoDetalle)
													VALUES(".$fila[1].",".$fila[2].",'".$fila[3]."',".$fila[4].",".$fila[5].",".$fila[6].",".$fila[7].",'".$fecha."',-1,".$_SESSION["idUsr"].",1,".$nuevoNumero.",".$fila[15].")";
						$ct++;	
					}
			
					$query[$ct]="DELETE FROM 9300_temporalPedido WHERE idPedido=".$idPedido;
					$ct++;
					$query[$ct]="commit";
					if($con->ejecutarBloque($query))
						echo "1|";
					else
						echo "|";
				}
			}
		}
	}
	
	function obtenerCategoriasAlmacen()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idCategoria,nombre,descripcion FROM 9030_categoriasAlmacen ".$condWhere." order by nombre";
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrCategorias="";
		while($fila=mysql_fetch_row($res))
		{
			$arregloConc='';
			$cabeceraT='<table>';
			$cuerpo='';
			$existeCabecera=0;
			$cuerpoT='';
			$conConceptos="SELECT claveConcepto FROM 9351_categoriaVSConcepto WHERE idCategoria=".$fila[0];
			$resC=$con->obtenerFilas($conConceptos);
			$numDist=$con->filasAfectadas;
			if($numDist>0)
			{
				$cuerpoT='<tr><td width=\"50\" class=\"letraRojaSubrayada8\">Clave</td><td width=\"450\" class=\"letraRojaSubrayada8\">Concepto</td></tr>';
			}
			
			while($filaC=mysql_fetch_row($resC))
			{
				$conN="SELECT clave,nombreObjetoGasto FROM 507_objetosGasto WHERE codigoControl='".$filaC[0]."' order by clave";
				$datos=$con->obtenerPrimeraFila($conN);
				$cuerpo.='<tr><td width=\"50\">'.$datos[0].'</td><td width=\"450\">'.$datos[1].'</td></tr>';
			
			}
			
			$finalT='</table>';
			
			$arregloConc=$cabeceraT.$cuerpoT.$cuerpo.$finalT;
			
			$trDes='<table><tr><td width=\"400\">'.cv($fila[2]).'</td></tr></table>';
			
			
			$obj='{"idCategoria":"'.$fila[0].'","nombre":"'.$fila[1].'","descripcion":"'.$trDes.'","conceptos":"'.$arregloConc.'"}';	
			if($arrCategorias=="")
				$arrCategorias=$obj;
			else
				$arrCategorias.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrCategorias.']}';
		echo $obj;
	
	}
	
	function obtenerFolioPedido()
	{
		global $con;
		
		$consulta="obtener ultimo folio";
		
		echo "1|2000001";
	}
	
	function guardarNuevoPedido()
	{
		global $con;
		
		$idPedidoAnt=$_POST["idPedido"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idProveedor=$_POST["idProveedor"];
		$nuevoFolio=$_POST["nuevoFolio"];
		$fecha=$_POST["fecha"];
		$fecha=cambiaraFechaMysql($fecha);
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			$consulta2="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,status_pedido,folioPedido,fechaRecepcion,idAlmacen,idPadre)
						 VALUES(".$idProveedor.",'".date("Y-m-d")."',1,".$nuevoFolio.",'".$fecha."',".$idAlmacen.",".$idPedidoAnt.")";
			if($con->ejecutarConsulta($consulta2))			 
			{
				$idNuevoPedido=$con->obtenerUltimoID();
				
				for($x=0;$x<$tamano;$x++)
				{
					$consulta3="SELECT idMarca,cantidad,costoUnitario,iva,partida,idPedidoDetalle FROM 9103_PedidoDetalle WHERE idPedido=".$idPedidoAnt." AND idProducto=".$arreglo[$x];
					$fila=$con->obtenerPrimeraFila($consulta3);
					if($fila)
					{
						$query[$ct]="INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,cantidad,costoUnitario,iva,partida) 
									 VALUES(".$idNuevoPedido.",".$arreglo[$x].",".$fila[0].",".$fila[1].",".$fila[2].",".$fila[3].",".$fila[4].")";
						$ct++;
						if($con->ejecutarConsulta($query[$ct]))
						{
							$ultimoId=$con->obtenerUltimoID();
							
							$conDistrib="SELECT codigoUnidad,idPrograma,partida,cantidad FROM 9301_distribucionProducto WHERE idPedidoDetalle=".$fila[5];
							$filaD=$con->obtenerPrimeraFila($conDistrib);
							if($filaD)
							{
								$query[$ct]="INSERT INTO 9301_distribucionProducto (codigoUnidad,idPrograma,partida,cantidad) 
											 VALUES(".$filaD[0].",".$filaD[1].",".$fila[2].",".$filaD[3].")";
								$ct++;			 
							}
						}
					}
				}
				$query[$ct]="commit";
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "|";
			}
						 
		}
	}
	
	function obtenerSanciones()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idSancion,nombre,s.descripcion,nombreConsulta,idConsulta FROM 991_consultasSql c,9311_sanciones s WHERE idConsulta=idCalculo ".$condWhere." order by nombre";
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrSanciones="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idSancion":"'.$fila[0].'","nombre":"'.$fila[1].'","descripcion":"'.$fila[2].'","nombreConsulta":"'.$fila[3].'","idConsulta":"'.$fila[3].'"}';	
			if($arrSanciones=="")
				$arrSanciones=$obj;
			else
				$arrSanciones.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrSanciones.']}';
		echo $obj;
	}
	
	function obtenerDatosSancion()
	{
		global $con;
		
		$id=$_POST["id"];
		
		$consulta="SELECT idSancion,nombre,s.descripcion,nombreConsulta,idConsulta FROM 991_consultasSql c,9311_sanciones s WHERE idCalculo=idConsulta AND idSancion=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			echo "2|".$fila[1]."|".$fila[2]."|".$fila[4];
		}
		else
		{
			echo "1|";
		}
		
	}
	
	function operacionesSancion()
	{
		global $con;
		
		$id=$_POST["id"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$idCalculo=$_POST["idCalculo"];
		if($id=="-1")
		{
			$query="INSERT INTO 9311_sanciones(nombre,descripcion,idCalculo) VALUES ('".$nombre."','".$descripcion."',".$idCalculo.")";
		}
		else
		{
			$query="UPDATE 9311_sanciones SET nombre='".$nombre."',descripcion='".$descripcion."',idCalculo=".$idCalculo." WHERE idSancion=".$id;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarSancion()
	{
		global $con;
		
		$query="DELETE FROM 9311_sanciones  WHERE idSancion=".$id;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerConceptosLibres()
	{
		global $con;
		
		$conExisten="SELECT claveConcepto FROM 9351_categoriaVSConcepto";
		$cadena=$con->obtenerListaValores($conExisten,"'");
		
		if($cadena=="")
		{
			$cadena="-1";
		}
		
		$consulta="SELECT codigoControl,clave,nombreObjetoGasto FROM 507_objetosGasto WHERE nivel=3 and codigoControl not in(".$cadena.")";
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arreConceptos="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"objGasto":"'.$fila[0].'","clave":"'.$fila[1].'","nombreObjetoGasto":"'.$fila[2].'"}';	
			if($arreConceptos=="")
				$arreConceptos=$obj;
			else
				$arreConceptos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arreConceptos.']}';
		echo $obj;
	
	}
	
	function eliminarCategoria()
	{
		global $con;
		
		$id=$_POST["id"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$query[$ct]="DELETE FROM 9351_categoriaVSConcepto WHERE idCategoria=".$id;
			$ct++;
			$query[$ct]="DELETE FROM 9030_categoriasAlmacen WHERE idCategoria=".$id;
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function guardarCategoria()
	{
		global $con;
		
		$id=$_POST["id"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$responsablealmacen=$_POST["responsablealmacen"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$ct=0;
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			if($id=="-1")
			{
				
				$query[$ct]="INSERT INTO 9030_categoriasAlmacen (nombre, descripcion, idResp, fechaCreacion) VALUES ('".$nombre."', '".descripcion."', '".$_SESSION["idUsr"]."','".date('Y-m-d')."')";
				if($con->ejecutarConsulta($query[$ct]))
				{
					$ct++;
					$idCat=$con->obtenerUltimoID();
					for($x=0;$x<$tamano;$x++)
					{
						$query[$ct]="INSERT INTO 9351_categoriaVSConcepto(idCategoria,claveConcepto) VALUES(".$idCat.",".$arreglo[$x].")";
						$ct++;
					}
				}
			}
			else
			{
				$query[$ct]="UPDATE 9030_categoriasAlmacen SET nombre='".$nombre."',descripcion='".$descripcion."',idRespModif=".$_SESSION["idUsr"].",fechaModificacion='".date('Y-m-d')."' WHERE idCategoria=".$id;
				$ct++;
				$query[$ct]="DELETE FROM 9351_categoriaVSConcepto WHERE idCategoria=".$id;
				$ct++;
				
				for($x=0;$x<$tamano;$x++)
				{
					$query[$ct]="INSERT INTO 9351_categoriaVSConcepto(idCategoria,claveConcepto) VALUES(".$id.",".$arreglo[$x].")";
					$ct++;
				}
			}
			
			if(!$con->ejecutarBloque($query))			
				echo "1|";
			else
				echo "|";
		}
	}
	
	function guardarAlmacen()
	{
		global $con;
		
		$id=$_POST["id"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		if($id=="-1")
		{
			$query="INSERT INTO 9030_almacenes (nombreAlmacen,descripcion,idResp,fechaCreacion) VALUES('".$nombre."','".$descripcion."',".$_SESSION["idUsr"].",'".date('Y-m-d')."')";
		}
		else
		{
			$query="UPDATE 9030_almacenes SET nombreAlmacen='".$nombre."',descripcion='".$descripcion."',idRespModif=".$_SESSION["idUsr"].",fechaModificacion='".date('Y-m-d')."' WHERE idAlmacen=".$id;
		}
		
		if($con->ejecutarConsulta($query))
		{
			if($id=="-1")
				$id=$con->obtenerUltimoID();
			echo "1|".$id;
		}
		else
			echo "|";
	}
	
	function obtenerCatAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="SELECT idAlmacenVSCategoria,c.nombre, CONCAT('[',clave,'] ',o.nombreObjetoGasto) AS objetoGasto,descripcion FROM 9030_almacenVSCategoria a,9030_categoriasObjetoGasto c,507_objetosGasto o
					WHERE o.codigoControl=c.objetoGasto AND c.idCategoria=a.idCategoria AND a.idAlmacen=".$idAlmacen;
		$numReg=$con->filasAfectadas;
		$arrCatAlm=$con->obtenerFilasJson($consulta);
		$obj='{"numReg":"'.$numReg.'","registros":'.utf8_encode($arrCatAlm).'}';
		echo $obj;
	}
	
	function obtenerCatNoAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="SELECT idCategoria,nombre FROM 9030_categoriasAlmacen WHERE idCategoria NOT IN (SELECT idCategoria FROM 9303_almacenVSCategoria) order by nombre";
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		$arrCatAlm="";
		
		while($fila=mysql_fetch_row($res)){
		$obj='{"idCategoria":"'.$fila[0].'","nombre":"'.$fila[1].'"}';	
			if($arrCatAlm=="")
				$arrCatAlm=$obj;
			else
				$arrCatAlm.=",".$obj;
			}
			
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrCatAlm.']}';
		echo $obj;
	}
	
	function ligarCategoriaAlmacen()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="INSERT INTO 9303_almacenVSCategoria (idAlmacen,idCategoria) VALUES(".$idAlmacen.",".$arreglo[$x].")";
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerInventarioAlmacen()
	{
		global $con;
		$arrProductos="";
		$consultaUnion="";
		$idAlmacen=$_POST["idAlmacen"];
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		$consulta="SELECT idCategoria FROM 9303_almacenVSCategoria WHERE idAlmacen=".$idAlmacen;
		$cadena=$con->obtenerListaValores($consulta);
		if($cadena=="")
		{
			$numReg=0;
			$arrProductos="";
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			echo $obj;
		}
		else
		{
			$conConceptos="SELECT claveConcepto,codigoControl FROM 9351_categoriaVSConcepto c,507_objetosGasto o WHERE claveConcepto=clave AND  idCategoria IN (".$cadena.") ORDER BY claveConcepto";
			$res=$con->obtenerFilas($conConceptos);
			$nCat=$con->filasAfectadas;
			if($nCat>0)
			{
				$ct=0;
				if($nCat==1)
				{
					$filaC=$con->obtenerPrimeraFila($conConceptos);
					$conConcentrado="SELECT clave,idProducto,clave_Art,nombreProducto,descripcion FROM 9101_CatalogoProducto p,507_objetosGasto o WHERE  codigoControlPadre='".$filaC[1]."' AND codigoControl=objetoGasto ".$condWhere." ORDER BY clave,nombreProducto limit ".$inicio.",".$cantidad;
					
					$conSinLimit="SELECT clave,idProducto,clave_Art,nombreProducto,descripcion FROM 9101_CatalogoProducto p,507_objetosGasto o WHERE  codigoControlPadre='".$filaC[1]."' AND codigoControl=objetoGasto ".$condWhere." ORDER BY clave,nombreProducto";
				}
				else
				{
				  while($filaU=mysql_fetch_row($res))
				  {
					  $union="(SELECT clave,idProducto,clave_Art,nombreProducto,descripcion FROM 9101_CatalogoProducto p,507_objetosGasto o WHERE  codigoControlPadre='".$filaU[1]."' AND codigoControl=objetoGasto ".$condWhere.")"; 
					  if($consultaUnion=="")
					  	$consultaUnion=$union;
					  else
					  	$consultaUnion.="UNION ".$union;
				  }
				  $conConcentrado=$consultaUnion." ORDER BY clave,nombreProducto limit ".$inicio.",".$cantidad;
				  $conSinLimit=$consultaUnion;
				}
				$respuesta=$con->obtenerFilas($conConcentrado);
				$resNFilas=$con->obtenerFilas($conSinLimit);
				$nreg=$con->filasAfectadas;
				
					while($filaP=mysql_fetch_row($respuesta))
					{
						$existencia=obtenerExistenciaAlmacenProductoE($filaP[1],$idAlmacen);
						
						$obj='{"clave":"'.cv($filaP[0]).'","idProducto":"'.$filaP[1].'","clave_Art":"'.cv($filaP[2]).'","nombreProducto":"'.cv($filaP[3]).'","existencia":"'.$existencia.'","descripcion":"'.cv($filaP[4]).'"}';	
						if($arrProductos=="")
							$arrProductos=$obj;
						else
							$arrProductos.=",".$obj;
						$ct++;
					}
				$obj='{"numReg":"'.$nreg.'","registros":['.$arrProductos.']}';
				
				echo $obj;
			}
		}
	}
	
	function obtenerExistenciaAlmacenProductoE($idProducto,$idAlmacen)
	{
		global  $con;
		
		$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=".$idProducto." AND idAlmacen=".$idAlmacen;
		$existencia=$con->obtenerValor($consulta);
		if($existencia=="")
			$existencia=0;
			
		return $existencia;	
	}
	
	function obtenerTablaReparto($idProducto,$idAlmacen)
	{
		global $con;
		
		$arregloConc='';
		$cabeceraT='<table>';
		$cuerpoT='';
		$cuerpo='';
		$consulta="SELECT idPrograma,codigoUnidad,idPrograma,(SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=e.idProducto AND idAlmacen=".$idAlmacen." AND 
				   codigoUnidad=e.codigoUnidad AND idPrograma=e.idPrograma )AS cantidad FROM 9302_existenciaAlmacen e WHERE idProducto=".$idProducto;
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		if($nFilas>0)
		{
			$existeCabecera=0;
			$cuerpoT='<tr><td align="center" width="300" class="letraRojaSubrayada8">Departamento</td><td align="center"  width="300" class="letraRojaSubrayada8">Programa</td><td width="50" align="center">Cantidad</td></tr>';
		}
		$cadenaTabla="";
		
		while($fila=mysql_fetch_row($res))
		{
			if($fila[0]>0)
			{
				$consulta="SELECT codigoDepto,unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[1]."'";
				$depto=$con->obtenerPrimeraFila($consulta);
		
				$conP="SELECT tituloPrograma FROM 517_programas WHERE idPrograma=".$fila[0];
				$prog=$con->obtenerValor($conP);
				
				$cuerpo.='<tr><td width="300">['.$depto[0].']&nbsp;&nbsp;'.$depto[1].'</td><td width="300">'.$prog.'</td><td width="50">&nbsp;&nbsp;'.$fila[3].'</td></tr>';
			}
		}
		$finalT='</table>';
		$arregloConc=$cabeceraT.$cuerpoT.$cuerpo.$finalT;
		return $arregloConc;
	}
	
	function agendarFechaEntrega()
	{
	
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$fechaAgendada=$_POST["fechaAgendada"];
		$horaInicio=$_POST["horaInicio"];
		$horaI=date('H:i:s',strtotime($horaInicio));
		$tiempoE=$_POST["tiempoE"];
		$horaFin=strtotime('+ '.$tiempoE.' minutes',strtotime($horaI));
		$horaF=date('H:i:s',$horaFin);
		$query="UPDATE 9102_PedidoCabecera SET fechaAgenda='".$fechaAgendada."',horaInicio='".$horaI."',horaFin='".$horaF."' WHERE idPedido=".$idPedido;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	
	function obtenerSeccionesAlmacen()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		
		if(isset($_POST["idAlmacen"]))
			$idAlmacen=$_POST["idAlmacen"];
		
		$cadTemas=generarArbolSecciones($idAlmacen,"",-1);
		echo $cadTemas;
	}
	
	function generarArbolSecciones($id,$numeracion,$idPadre)
	{
	   global $con;
	   $cadena="";
	   $consulta="select idSeccion,nombreSeccion,descripcion from 9031_seccionesAlmacen where idAlmacen=".$id." and idPadre=".$idPadre;
	   $res2=$con->obtenerFilas($consulta);
		 
		 $clase="filaBlanca10";
		 $ct=1;
		 while($fila=mysql_fetch_row($res2))
		 {
			
			  $hijos=generarArbolSecciones($id,$numeracion.$ct.".",$fila[0]);
			  
			  if ($hijos=="[]")
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[1]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[2]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[2]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  leaf: true,
								  draggable:false,
								  listeners:	{
														  
											  }
								  
						}
							   ";
			  }
			  else
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[1]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[2]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[2]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  draggable:false,
								  listeners:	{
														  
											  },
								  children:
											  ".$hijos."
								 }
							   ";
			  }
			  if($cadena!="")
				  $cadena.=",".$obj;
			  else
				  $cadena=$obj;
			  $ct++;				
		 }
		return "[".$cadena."]";
	}
	
	function eliminarSeccionesAlmacen()
	{
		global $con;
		global $z;
		global $consultaS;
		
		$idAlmacen=$_POST["idAlmacen"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				seccion($arreglo[$x]);
				borrar($arreglo[$x]);
				$consultaS[$z]="DELETE FROM 9031_seccionesAlmacen WHERE idSeccion=".$arreglo[$x];
				$z++;
			}
			$consultaS[$z]="commit";
			if($con->ejecutarBloque($consultaS))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function borrar($id)
	{	
		global $con;
		global $z;
		global $consultaS;
		$consultaS[$z]="delete from 9031_seccionesAlmacen where idPadre=".$id;
		$z++;
	
	}
	
	function seccion($id)
	{
		global $con;
		$query="select idSeccion from 9031_seccionesAlmacen where idPadre=".$id;
		$resE=$con->obtenerFilas($query);
		while($fA=mysql_fetch_row($resE))
		{
			seccion($fA[0]);
			borrar($fA[0]);
		}
	}	
	
	function obtenerPartidas()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$arrPartidas="";
		$consulta="SELECT  codigoControl FROM 507_objetosGasto WHERE clave LIKE '%00' AND clave NOT LIKE '%000'";
		$lista=$con->obtenerListaValores($consulta);
		
		if($lista=="")
		{
			$numReg=0;
			$arrPartidas="";
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			echo $obj;
		}
		else
		{
			$conPartidas="SELECT clave,nombreObjetoGasto FROM 507_objetosGasto WHERE codigoControlPadre IN(".$lista.")".$condWhere." order by clave";
			$res=$con->obtenerFilas($conPartidas);
			$numReg=$con->filasAfectadas;
			while($fila=mysql_fetch_row($res))
			  {
			  	$consulta="SELECT *FROM 9306_confPartidaAlmacen WHERE clave='".$fila[0]."'";
				$filaC=$con->obtenerPrimeraFila($consulta);
				if(!$filaC)
				{
					$filaC[0]="";
					$filaC[1]="";
					$filaC[2]="-1";
					$filaC[3]="";
					$filaC[4]="";
					$tipoR="Sin Configuraci&oacute;n";
					$tipoI="Sin Configuraci&oacute;n";
				}
				else
				{
				  if($filaC[2]=="")
				  {
					  $filaC[2]="-1";
				  }
				  
				  $fila[3]="Sin Configuraci&oacute;n";
				  if($filaC[3]!="")
				  {
					  if($fila[3]==0)
						  $tipoR="Volumen";
					  else
						  $tipoR="Pieza";
				  }
				  
				  $fila[4]="Sin Configuraci&oacute;n";
				  if($filaC[4]!="")
				  {
					  if($fila[4]==0)
						  $tipoI="Si";
					  else
						  $tipoI="No";
				  }
				}
				
				$nombreForm="SELECT nombreFormulario FROM 900_formularios WHERE idFormulario=".$filaC[2];
				$nombre=$con->obtenerValor($nombreForm);
				if($nombre=="")
				{
					$nombre="Sin Configuraci&oacute;n";
				}
			  
				$obj='{"clave":"'.$fila[0].'","nombreObjetoGasto":"'.$fila[1].'","idFormato":"'.$filaC[2].'","tipoRegistro":"'.$filaC[3].'","inventariable":"'.$filaC[4].'","nombreF":"'.cv($nombre).'","tipoR":"'.$tipoR.'","tipoInv":"'.$tipoI.'"}';	
				if($arrPartidas=="")
					$arrPartidas=$obj;
				else
					$arrPartidas.=",".$obj;
			}
			
		$objArre='{"numReg":"'.$numReg.'","registros":['.$arrPartidas.']}';
		echo $objArre;
			
		}
	}
	
	/////Hugo //////////////
	function obtenerCategoria(){
		global $con;
		
		$consulta="SELECT idCategoria, nombre, fechaCreacion, responsable, clave, fechaModificacion, responsableModificacion FROM 9350_categoriasVsArea";
		$res=$con->obtenerFilas($consulta);
		$numReg = $con->filasAfectadas;
		$arrCategorias = "";
		while($fila=mysql_fetch_row($res)){
		$obj='{"idCategoria":"'.$fila[0].'","nombre":"'.$fila[1].'","fechaCreacion":"'.$fila[2].'","responsable":"'.$fila[3].'","clave":"'.$fila[4].'","fechaModificacion":"'.$fila[5].'","responsableModificacion":"'.$fila[6].'"}';	
			if($arrCategorias=="")
				$arrCategorias=$obj;
			else
				$arrCategorias.=",".$obj;
			}
			
		$objArre='{"numReg":"'.$numReg.'","registros":['.$arrCategorias.']}';
		echo $objArre;
	}
	
	/////////termina Hugo/////////
	
	function obtenerComprometidoEntregas()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$idCiclo=$_POST["idCiclo"];
		$mes=$_POST["mes"];
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$catAlmacen="SELECT idCategoria FROM 9303_almacenVSCategoria WHERE idAlmacen=".$idAlmacen;
		//echo $catAlmacen;
		$cadenaCat=$con->obtenerListaValores($catAlmacen);
		$arrProductos="";
		
		if($cadenaCat=="")
		{
			$numReg=0;
			$arrPartidas="";
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			echo $obj;
		}
		else
		{
			$union="";
			$conConcep="SELECT codigoControl 
						FROM 9351_categoriaVSConcepto c,507_objetosGasto o WHERE  clave=claveConcepto AND idCategoria in(".$cadenaCat.")";
			$listConcepto=$con->obtenerListaValores($conConcep);
			if($listConcepto=="")
				$listConcepto="-1";
			$union="SELECT DISTINCT(a.idProducto),nombreProducto,p.descripcion FROM 9101_CatalogoProducto p,507_objetosGasto o ,525_productosAutorizados a,526_distribucionAutorizada d
						   WHERE p.idProducto=a.idProducto AND a.clave=o.codigoControl  AND p.objetoGasto=o.codigoControl AND codigoControlPadre in (".$listConcepto.") AND idCiclo=".$idCiclo." 
						   AND a.idCodigoGastoCiclo=d.idCodigoGastoCiclo AND mes=".$mes.$condWhere." limit ".$start.",".$limit;
			
			$res=$con->obtenerFilas($union);
			$union="SELECT count(*) FROM 9101_CatalogoProducto p,507_objetosGasto o ,525_productosAutorizados a,526_distribucionAutorizada d
						   WHERE p.idProducto=a.idProducto AND a.clave=o.codigoControl  AND p.objetoGasto=o.codigoControl AND codigoControlPadre in (".$listConcepto.") AND idCiclo=".$idCiclo." 
						   AND a.idCodigoGastoCiclo=d.idCodigoGastoCiclo AND mes=".$mes.$condWhere;
			
			$numReg=$con->obtenerValor($union);
			
			while($filaP=mysql_fetch_row($res))
			{
				$conCadena="SELECT idCodigoGastoCiclo FROM 525_productosAutorizados WHERE idProducto=".$filaP[0]." AND idCiclo=".$idCiclo;
				$cadena=$con->obtenerListaValores($conCadena);
				if($cadena=="")
					$cadena="-1";
					
				$conComprometido="SELECT SUM(cantidad) FROM 526_distribucionAutorizada WHERE mes=".$mes." AND  idCodigoGastoCiclo IN (".$cadena.")";
				$comprometido=$con->obtenerValor($conComprometido);
				if($comprometido=="")
					$comprometido=0;
					
				$estado="";
				$conSituacion1="SELECT idEntrega  FROM 9305_fechasEntregasAlmacen WHERE idProducto=".$filaP[0]." AND mes=".$mes." AND idCiclo=".$idCiclo;
				$resS=$con->obtenerFilas($conSituacion1);
				$nEntregas=$con->filasAfectadas;
				if($nEntregas==0)
					$estado="No Entregado";
				
				$conSituacion2="SELECT SUM(cantidad) FROM 9305_fechasEntregasAlmacen WHERE idProducto=".$filaP[0]." AND (estado=0 OR estado=2) AND mes=".$mes." AND idCiclo=".$idCiclo;
				$valorEstado=$con->obtenerValor($conSituacion2);
				if($valorEstado!="")
					$estado="En Proc. Entrega";
				
				$conSituacion3="SELECT SUM(cantidad) FROM 9305_fechasEntregasAlmacen WHERE idProducto=".$filaP[0]." AND estado=1 AND mes=".$mes." AND idCiclo=".$idCiclo;
				$valorEstado1=$con->obtenerValor($conSituacion3);
				if($valorEstado1!="")
				{
					if($comprometido==valorEstado1)
						$estado="En Proc. Entrega";
				}
				
				$existencia=obtenerExistenciaAlmacenProductoE($filaP[0],$idAlmacen);
				//if($comprometido!="0")
				{
					$obj='{"idProducto":"'.$filaP[0].'","nombreProducto":"'.cv($filaP[1]).'","descripcion":"'.cv($filaP[2]).'","cantidad":"'.$comprometido.'","existencia":"'.$existencia.'","situacion":"'.$estado.'"}';	
					if($arrProductos=="")
						$arrProductos=$obj;
					else
						$arrProductos.=",".$obj;
				}
			}
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			
			echo $obj;
					
			}
	}
	
	function obtenerDeptosEntregaProducto()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
		$idProducto=$_POST["idProducto"];
		$mes=$_POST["mes"];
		$idCiclo=$_POST["idCiclo"];
		$arrDeptos="";
		
		$consulta="SELECT a.idPrograma,tituloPrograma,codDepto,unidad,d.cantidad FROM 525_productosAutorizados a ,817_organigrama org,526_distribucionAutorizada d,517_programas pr
				   WHERE a.idProducto=".$idProducto." AND a.codDepto=org.codigoUnidad AND idCiclo=".$idCiclo." AND a.idCodigoGastoCiclo=d.idCodigoGastoCiclo AND a.idPrograma=pr.idPrograma AND mes=".$mes." order by unidad";	
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		while($filaP=mysql_fetch_row($res))
		{
			$existenciaDepto=obtenerExistenciaDepto($filaP[0],$filaP[2],$idProducto,$idAlmacen);
			
			$conEntregas="SELECT fecha,estado,cantidad FROM 9305_fechasEntregasAlmacen WHERE  idProducto=".$idProducto." AND idAlmacen=".$idAlmacen;
			$resE=$con->obtenerFilas($conEntregas);
			$diferencia=0;
			$sumaE=0;
			$totalE=0;
			$totalP=0;
			$totalA=0;
			$sinA=0;
			while($filaE=mysql_fetch_row($resE))
			{
				$datos=explode("-",$filaE[0]);
				$mesE=$datos[1];
				$cicloE=$datos[0];
				if(($mesE==$mes) && ($cicloE==$idCiclo))
				{
					if(($filaE[1]==1) || ($filaE[1]==2))
					{
						$sumaE=$sumaE+$filaE[2];
					}
					
					if($filaE[1]==1)
					{
						$totalE=$totalE+$filaE[2];
					}
					
					if($filaE[1]==2)
					{
						$totalP=$totalP+$filaP[2];
					}
					
					if($filaE[1]==0)
					{
						$totalA=$totalA+$filaP[2];
					}
				}
			}
			
			$diferencia=$filaP[4]-$sumaE;
			if($existenciaDepto!=0)
			{
				$existenciaDepto=$existenciaDepto-$totalA;
			}
			
			
			$obj='{"idPrograma":"'.$filaP[0].'","tituloPrograma":"'.$filaP[1].'","codigoUnidad":"'.$filaP[2].'","cantidadSolicitada":"'.$filaP[4].'","entregados":"'.$sumaE.'","diferencia":"'.$diferencia.'","unidad":"'.$filaP[3].'","totalE":"'.$totalE.'","totalP":"'.$totalP.'","totalA":"'.$totalA.'","existencia":"'.$existenciaDepto.'"}';	
			if($arrDeptos=="")
				$arrDeptos=$obj;
			else
				$arrDeptos.=",".$obj;
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrDeptos.']}';
		
		echo $obj;
	}
	
	function guardarEntregaAlmacen()
	{
		global $con;
		
		
		$idAlmacen=$_POST["idAlmacen"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idProducto=$_POST["idProducto"];
		$mes=$_POST["mes"];
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$fila=explode("_",$arreglo[$x]);
				$horaFin="00:00:00";
				$horaInicio=$fila[4];
				$tiempoE=$fila[5];
				if($horaInicio!=0)
				{
					$horaInicio=date('H:i:s',strtotime($horaInicio));
					$horaI=strtotime($fila[3].$horaInicio);
					$horaFin=strtotime('+ '.$tiempoE.' minutes',$horaI);
					$horaFin=date('H:i:s',$horaFin);
				}
				else
				{
					$horaInicio=date('H:i:s',strtotime($horaInicio));
				}
				
				$query[$ct]="INSERT INTO 9305_fechasEntregasAlmacen (idAlmacen,idProducto,codigoUnidad,idPrograma,cantidad,fecha,horaInicio,horaFin,estado,mes,idCiclo)
							VALUES(".$idAlmacen.",".$idProducto.",'".$fila[0]."',".$fila[1].",".$fila[2].",'".$fila[3]."','".$horaInicio."','".$horaFin."',0,".$mes.",".$idCiclo.")";
				$ct++;			
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function validarFechaTiempoEstimado()
	{
		global $con;
		
		$fecha=$_POST["fecha"];
		$horaInicio=$_POST["horaInicio"];
		$tiempo=$_POST["tiempo"];
		
		$horaInicio=date('H:i:s',strtotime($horaInicio));
		$fechaTiempo=strtotime($fecha.$horaInicio);
		$fechaFin=strtotime('+ '.$tiempo.' minutes',$fechaTiempo);
		$fechaFin=date('Y-m-d',$fechaFin);
		
		if($fecha==$fechaFin)
			echo "1|" ;
		else
			echo "2|";
	}
	
	function obtenerExistenciaDepto($idPrograma,$codigoUnidad,$idProducto,$idAlmacen)
	{
		global $con;
		
		$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=".$idProducto." AND idPrograma=".$idPrograma." AND codigoUnidad='".$codigoUnidad."' AND idAlmacen=".$idAlmacen;
		$existencia=$con->obtenerValor($consulta);
		
		if($existencia=="")
		{
			$existencia=0;
		}
		
		return $existencia;
	}
	
	function guardarConfPartidas()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$tipoF=$_POST["tipoF"];
		$tipoR=$_POST["tipoR"];
		$tipoI=$_POST["tipoI"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$x=0;
			
			$arreglo=explode(",",$cadena);
			$tamano=sizeof($arreglo);
			for($y=0;$y<$tamano;$y++)
			{
				$conExiste="SELECT idPartidaVSFormularioD FROM 9306_confPartidaAlmacen WHERE clave='".$arreglo[$y]."'";
				$id=$con->obtenerValor($conExiste);
				if($id=="")
				{
					$query[$x]="INSERT INTO 9306_confPartidaAlmacen(clave,idFormulario,tipoRegistro,inventariable) VALUES('".$arreglo[$y]."',".$tipoF.",".$tipoR.",".$tipoI.")";
				}
				else
				{
					$query[$x]="UPDATE 9306_confPartidaAlmacen SET clave='".$arreglo[$y]."',idFormulario=".$tipoF.",tipoRegistro=".$tipoR.",inventariable=".$tipoI." WHERE idPartidaVSFormularioD=".$id;
				}
				$x++;
			}
			$query[$x]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerConfiguracionProducto($idProducto)
	{
		global $con;
		$bandera=1;//indica que el parametro idProducto viajo de forma local
		if(isset($_POST["idProducto"]))
		{
			$idProducto=$_POST["idProducto"];
			$bandera=2;//el parametro idProducto viajo por post
		}
		$conObjGasto="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
		$objGasto=$con->obtenerValor($conObjGasto);
		if($objGasto=="")
		{
			if($bandera==1)
				return "0|";
			else	
				echo "2|";
		}
		else
		{
			$consulta="SELECT *FROM 9306_confPartidaAlmacen WHERE clave=".$objGasto;
			$fila=$con->obtenerPrimeraFila($consulta);
			if(!$fila)
			{
				if($bandera==1)
					return "0|";
				else	
						echo "2|";
			}
			else
			{
				if($bandera==1)
					return "1|".$fila[2]."|".$fila[3]."|".$fila[4];
				else	
				echo "1|".$fila[2]."|".$fila[3]."|".$fila[4];
			}
		}
	}
	
	function obtenerRegistrosForDin()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idPedidoDetalle=$_POST["idPedidoDetalle"];
		$nombreP=bD($_POST["nombreProducto"]);
		$marca=bD($_POST["marca"]);
		$modelo=bD($_POST["modelo"]);
		$tipoRegistro=$_POST["tipoRegistro"];
		$inventariable=$_POST["inventariable"];
		$cantidad=$_POST["cantidad"];
		
		$arrProductos="";
		$consulta="SELECT nombreTabla FROM 900_formularios  WHERE idFormulario=".$idFormulario;
		$nTabla=$con->obtenerValor($consulta);
		if($nTabla=="")
		{
			$numReg=0;
			$arrPartidas="";
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			echo $obj;
		}
		else
		{
			$arrAux="";
			$consulta="SELECT id_".$nTabla." FROM  ".$nTabla." WHERE idReferencia=".$idPedidoDetalle;
			$res=$con->obtenerFilas($consulta);
			$numReg=$con->filasAfectadas;
			if($numReg!=$cantidad)
			{
				$tamano=$cantidad-$numReg;
				
				for($x=0;$x<$tamano;$x++)
				{
					$objAux='{"idFormulario":"'.$idFormulario.'","idPedidoDetalle":"'.$idPedidoDetalle.'","nombreProducto":"'.cv($nombreP).'","marca":"'.$marca.'","modelo":"'.$modelo.'","tipoRegistro":"'.$tipoRegistro.'","inventariable":"'.$inventariable.'","idRegistro":"-1"}';
					if($arrAux=="")
					    $arrAux=$objAux;
					else
					    $arrAux.=",".$objAux;
				}
			}
			
			while($fila=mysql_fetch_row($res))
			{
				$obj='{"idFormulario":"'.$idFormulario.'","idPedidoDetalle":"'.$idPedidoDetalle.'","nombreProducto":"'.cv($nombreP).'","marca":"'.$marca.'","modelo":"'.$modelo.'","tipoRegistro":"'.$tipoRegistro.'","inventariable":"'.$inventariable.'","idRegistro":"'.$fila[0].'"}';	
				if($arrProductos=="")
					$arrProductos=$obj;
				else
					$arrProductos.=",".$obj;
			}
			$obj='{"numReg":"'.$cantidad.'","registros":['.$arrProductos.$arrAux.']}';
			echo $obj;
		}
	}
	
	function obtenerRegistroForDinVolumen()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idPedidoDetalle=$_POST["idPedidoDetalle"];
		
		$consulta="SELECT nombreTabla FROM 900_formularios  WHERE idFormulario=".$idFormulario;
		$nTabla=$con->obtenerValor($consulta);
		if($nTabla=="")
		{
			echo "|";
		}
		else
		{
			$consulta="SELECT id_".$nTabla." FROM  ".$nTabla." WHERE idReferencia=".$idPedidoDetalle;
			$fila=$con->obtenerValor($consulta);
			if($fila=="")
				echo "1|";
			else	
				echo "1|".$fila;
		}
	}
	
	function obtenerSolicitudesAlmacen()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
		$idCiclo=$_POST["idCiclo"];
		
		global $con;
		$arrProductos="";
		$consultaUnion="";
		
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		$consulta="SELECT idCategoria FROM 9303_almacenVSCategoria WHERE idAlmacen=".$idAlmacen;
		$cadena=$con->obtenerListaValores($consulta);
		if($cadena=="")
		{
			$numReg=0;
			$arrProductos="";
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrProductos.']}';
			echo $obj;
		}
		else
		{
			$conConceptos="SELECT claveConcepto,codigoControl FROM 9351_categoriaVSConcepto c,507_objetosGasto o WHERE claveConcepto=clave AND  idCategoria IN (".$cadena.") ORDER BY claveConcepto";
			$res=$con->obtenerFilas($conConceptos);
			$nCat=$con->filasAfectadas;
			if($nCat>0)
			{
				$ct=0;
				if($nCat==1)
				{
					$filaC=$con->obtenerPrimeraFila($conConceptos);
					$conConcentrado="SELECT clave,p.idProducto,clave_Art,nombreProducto,descripcion,DATE_FORMAT(fechaCreacion,'%d/%m/%Y') AS fecha,codigoUnidad,txtcantidad,idEstado FROM 9101_CatalogoProducto p,507_objetosGasto o ,_604_tablaDinamica d WHERE  codigoControlPadre='".$filaC[1]."' AND clave=objetoGasto AND d.cmbProducto=p.idProducto AND ciclo=".$idCiclo." ".$condWhere." ORDER BY clave,nombreProducto limit ".$inicio.",".$cantidad;
					
					$conSinLimit="SELECT clave,p.idProducto,clave_Art,nombreProducto,descripcion,DATE_FORMAT(fechaCreacion,'%d/%m/%Y') AS fecha,codigoUnidad,txtcantidad,idEstado FROM 9101_CatalogoProducto p,507_objetosGasto o ,_604_tablaDinamica d WHERE  codigoControlPadre='".$filaC[1]."' AND clave=objetoGasto AND d.cmbProducto=p.idProducto AND ciclo=".$idCiclo." ".$condWhere." ORDER BY clave,nombreProducto";
				}
				else
				{
				  while($filaU=mysql_fetch_row($res))
				  {
					  $union="(SELECT clave,p.idProducto,clave_Art,nombreProducto,descripcion,DATE_FORMAT(fechaCreacion,'%d/%m/%Y') AS fecha,codigoUnidad,txtcantidad,idEstado FROM 9101_CatalogoProducto p,507_objetosGasto o ,_604_tablaDinamica d WHERE  codigoControlPadre='".$filaU[1]."' AND clave=objetoGasto AND d.cmbProducto=p.idProducto AND ciclo=".$idCiclo." ".$condWhere.")"; 
					  if($consultaUnion=="")
					  	$consultaUnion=$union;
					  else
					  	$consultaUnion.="UNION ".$union;
				  }
				  $conConcentrado=$consultaUnion." ORDER BY fecha ASC limit ".$inicio.",".$cantidad;
				  $conSinLimit=$consultaUnion;
				}
				$respuesta=$con->obtenerFilas($conConcentrado);
				$resNFilas=$con->obtenerFilas($conSinLimit);
				$nreg=$con->filasAfectadas;
				
					while($filaP=mysql_fetch_row($respuesta))
					{
						
						$conUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$filaP[6]."'";
						$unidad=$con->obtenerValor($conUnidad);


						$obj='{"clave":"'.cv($filaP[0]).'","idProducto":"'.$filaP[1].'","clave_Art":"'.cv($filaP[2]).'","nombreProducto":"'.cv($filaP[3]).'","descripcion":"'.cv($filaP[4]).'","fechaE":"'.$filaP[5].'","unidad":"'.$unidad.'","codigoUnidad":"'.$filaP[6].'","cantidad":"'.$filaP[7].'","estado":"'.$filaP[8].'","idCiclo":"'.$idCiclo.'"}';	
						if($arrProductos=="")
							$arrProductos=$obj;
						else
							$arrProductos.=",".$obj;
						$ct++;
					}
				$obj='{"numReg":"'.$nreg.'","registros":['.$arrProductos.']}';
				
				echo $obj;
			}
		}
	}
	
	function detallesPedidoDetalle()
	{
		global $con;
		
		$idPedido=$_POST["idPedido"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT  d.idProducto,nombreProducto,clave_Art,descripcion,cantidad,idPedidoDetalle,idMarca,modelo,costoUnitario,iva,idPedidoDetalle FROM 9103_PedidoDetalle d,9101_CatalogoProducto p WHERE idPedido=".$idPedido." AND p.idProducto=d.idProducto ".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrPedidos="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			$conMarca="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$fila[6];
			$marca=$con->obtenerValor($conMarca);
			
			$total=0;
			$totalPieza=0;
			if(($fila[8]!="") || ($fila[8]!="")) //costoU 
			{
				$importeIva=0;
				if(($fila[9]!="") || ($fila[9]!=0)) //iva
				{
					$importeIva=$fila[8]*$fila[9];
				}
				$totalPieza=$fila[8]+$importeIva;
				if(($fila[4]!="") || ($fila[4]!=0))
				{
					$total=$totalPieza*$fila[4];
				}
			}
			
			$arregloDist='';
			$cabeceraT='<table>';
			$cuerpo='';
			$existeCabecera=0;
			$cuerpoT='';
			
			$distribucion="SELECT unidad,tituloPrograma,cantidad FROM 817_organigrama o,517_programas p,9301_distribucionProducto d 
							WHERE  p.idPrograma=d.idPrograma AND o.codigoUnidad=d.codigoUnidad AND idPedidoDetalle=".$fila[5];
			$resD=$con->obtenerFilas($distribucion);				
			$numDist=$con->filasAfectadas;
			if($numDist>0)
			{
				$cuerpoT='<tr><td width=\"300\" class=\"letraRojaSubrayada8\">Departamento</td><td width=\"450\" class=\"letraRojaSubrayada8\">Programa</td><td width=\"80\" class=\"letraRojaSubrayada8\">Cantidad</td></tr>';
			}
			
			while($filaD=mysql_fetch_row($resD))
			{
					$cuerpo.='<tr><td width=\"300\">'.$filaD[0].'</td><td width=\"450\">'.$filaD[1].'</td><td width=\"80\">'.$filaD[2].'</td></tr>';
			}
			
			$finalT='</table>';
			
			$arregloDist=$cabeceraT.$cuerpoT.$cuerpo.$finalT;
			
			$conEstado="SELECT estado FROM 9300_temporalPedido WHERE idPedido=".$idPedido." AND idProducto=".$fila[0];
			$estado=$con->obtenerValor($conEstado);
			if($estado=="")
				$estado=0;
			
			$obj='{"idProducto":"'.$fila[0].'","nombreProducto":"'.$fila[1].'","clave_Art":"'.$fila[2].'","descripcion":"'.$fila[3].'","cantidad":"'.$fila[4].'","estado":"'.$estado.'","distribucion":"'.$arregloDist.'","marca":"'.cv($marca).'","modelo":"'.cv($fila[7]).'","costoU":"'.$fila[8].'","iva":"'.$fila[9].'","costoNetoUnidad":"'.$totalPieza.'","total":"'.$total.'","idPedidoDetalle":"'.$fila[10].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	
	}
	
	function obtenerExistenciaProgramaDepto($idProducto,$idPrograma,$idDepartamento,$idAlmacen)
	{
		global $con;
		$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idPrograma=".$idPrograma." AND codigoUnidad='".$idDepartamento."' AND idAlmacen=".$idAlmacen;
		$existencia=$con->obtenerValor($consulta);
		if($existencia=="")
		{
			$existencia=0;
		} 
		return $existencia;
	}
	
	function obtenerProgramaDeptoCiclo()
	{
		global $con;	
		
		$idCiclo=$_POST["idCiclo"];
		$codigoUnidad=$_POST["codigoUnidad"];
		$idProducto=$_POST["idProducto"];
		$mes=$_POST["mes"];
		$idAlmacen=$_POST["idAlmacen"];
		$arrCantP="";
		
		$conUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$codigoUnidad."'";
		$nombreDepto=$con->obtenerValor(conUnidad);
		
		$consulta="SELECT d.idPrograma,tituloPrograma FROM 9130_departamentoVSPrograma d, 517_programas p WHERE codigoUnidad='".$codigoUnidad."' AND ciclo=".$idCiclo." AND p.idPrograma=d.idPrograma";
		echo $consulta;
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
	    {
			$consulta="SELECT idCodigoGastoCiclo FROM 525_productosAutorizados WHERE codDepto='".$codigoUnidad."' AND idPrograma=".$fila[0]." AND idProducto=".$idProducto." AND idCiclo=".$idCiclo;
			$res=$con->ontenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
	    	{
				$consulta="SELECT cantidad FROM 526_distribucionAutorizada WHERE idObjGastoCantidad=".$fila[0]." AND mes=".$mes;
				$cantidadC=$con->obtenerValor($consulta);
				if($cantidad!="")
				{
					$valorResta=0;
					$existencia=obtenerExistenciaProgramaDepto($idProducto,$fila[0],$codigoUnidad,$idAlmacen);
					if($disponible>0)
					{
						$consulta="SELECT SUM(cantidad) FROM 9305_fechasEntregasAlmacen WHERE idAlmacen=".$idAlamacen." AND idPrograma=".$fila[0]." AND codigoUnidad='".$codigoUnidad."' AND mes=".$mes." AND idCiclo=".$idCiclo." AND (estado=0 OR estado=2 )";
						$valorSum=$con->obtenerValor($consulta);
					}
					$disponible=$existencia-$valorSum;
					
					$obj='{"idPrograma":"'.$filaP[0].'","nombrePrograma":"'.$fila[1].'","disponible":"'.$disponible.'","cantidadA":""}';	
					if($arrCantP=="")
						$arrCantP=$obj;
					else
						$arrCantP.=",".$obj;
				}
			}
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrCantP.']}';
		
		echo $obj;
	}
	
	function obtenerExistenciaProductoAlmacen($idProducto,$idAlmacen)
	{
		global $con;
		$bandera=0;
		if(isset($_POST["idProducto"]))
		{
			$idProducto=$_POST["idProducto"];
			$bandera=1;
		}
		if(isset($_POST["idAlmacen"]))
			$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=".$idProducto." AND idAlmacen=".$idAlmacen;
		$existencia=$con->obtenerValor($consulta);
		if($existencia=="")
		{
			$existencia=0;
		}
		
		if($bandera==1)
			echo"1|".$existencia;
		else
			return $existencia;
	}
	
	function obtenerDatosPedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$bandera=$_POST["bandera"];
		
		if($bandera==1)
		{
		   $consulta="SELECT folioPedido,txtRazonSocial2 FROM _405_tablaDinamica pr,9102_PedidoCabecera p WHERE idProveedor_ult=id__405_tablaDinamica AND idPedido=".$idPedido;
		   $etiqueta="Proveedor:";
		}
		else
		{
			if($bandera==2)
			{
				 $consulta="SELECT folioPedido,nombreAlmacen FROM 9030_almacenes a,9102_PedidoCabecera p 
				 WHERE a.idAlmacen=p.idAlmacen AND idPedido=".$idPedido;
				 $etiqueta="Entregar en:";
			}
		}
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		echo "1|".$etiqueta."|".$fila[0]."|".$fila[1];
	}
	
	function obtenerHistorialProv()
	{
		global $con;
		
		$idProv=$_POST["idProv"];
		$idAlmacen=$_POST["idAlmacen"];
		$arrCantP="";
		
		$consulta="SELECT folioPedido,noFactura,fechaRecepcion,fechaRecibido,observaciones,status_pedido,observaciones FROM 9102_PedidoCabecera WHERE idProveedor_ult=".$idProv." AND idAlmacen=".$idAlmacen." AND status_pedido=0 order by fechaRecibido ASC" ;
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
	    {
			$tipoE="";
			if(strtotime($fila[2])==strtotime($fila[3]))
			{
				$tipoE="En Tiempo";
			}
			
			if(strtotime($fila[2])<strtotime($fila[3]))
			{
				$tipoE="Anticipado";
			}
			
			$obj='{"folioPedido":"'.$fila[0].'","noFactura":"'.$fila[1].'","fechaRecepcion":"'.$fila[2].'","fechaRecibido":"'.$fila[3].'","estado":"'.$tipoE.'","observaciones":"'.cv($fila[6]).'"}';	
			if($arrCantP=="")
				$arrCantP=$obj;
			else
				$arrCantP.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrCantP.']}';
		
		echo $obj;
	}
	
	function obtenerPedidosPendiestesPorFecha()
	{
		global $con;
		
		$fecha=cambiaraFechaMysql($_POST["fecha"]);
		$idAlmacen=$_POST["idAlmacen"];
		$arrCantP="";
		
		$consulta="SELECT idPedido,folioPedido,noFactura,txtRazonSocial2,horaInicio,idProveedor_ult FROM 9102_PedidoCabecera p,_405_tablaDinamica pr WHERE fechaAgenda='".$fecha."'  AND idAlmacen=".$idAlmacen." AND status_pedido=1 AND idProveedor_ult=id__405_tablaDinamica ORDER BY horaInicio" ;
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
	    {
			$tipoE="";
			if(strtotime($fila[2])==strtotime($fila[3]))
			{
				$tipoE="En Tiempo";
			}
			
			if(strtotime($fila[2])<strtotime($fila[3]))
			{
				$tipoE="Anticipado";
			}
			
			$obj='{"idPedido":"'.$fila[0].'",folioPedido":"'.$fila[1].'","noFactura":"'.$fila[2].'","txtRazonSocial2":"'.cv($fila[3]).'","horaInicio":"'.$fila[4].'","idProvedor":"'.$fila[5].'"}';	
			if($arrCantP=="")
				$arrCantP=$obj;
			else
				$arrCantP.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrCantP.']}';
		
		echo $obj;
	}
	
	function obtenerFacturaPedido()
	{
		global $con;
		
		$idProv=$_POST["idProv"];
		$idPedido=$_POST["idPedido"];
		
		$encontrada=1;
		$consulta="SELECT idFacturaPedido FROM 9304_facturaVSPedido WHERE idPedido=".$idPedido." AND idProveedor=".$idProv;
		$idFactura=$con->obtenerValor($consulta);
		
		if($idFactura=="")
		{
			$idFactura="-1";
			$encontrada=0;
		}
		
		$consultaNoF="SELECT folioFactura FROM 9304_facturaVSPedido WHERE idFacturaPedido=".$idFactura;
		$noFactura=$con->obtenerValor($consultaNoF);
		
		echo "1|".$encontrada."|".$idFactura."|".$noFactura;
	}
	
	function obtenerInformacionEntregaProgramada()
	{
		global $con;
		$idEntrega=$_POST["idEntrega"];
		
		$consulta="SELECT idProducto,codigounidad,idPrograma,cantidad FROM 9305_fechasEntregasAlmacen WHERE idEntrega=".$idEntrega;
		$fila=$con->obtenerPrimeraFila($consulta);
		if(!$fila)
		{
			$fila[0]="-1";
			$fila[1]="-1";
			$fila[2]="-1";
			$fila[3]="-1";
		}
		
		$producto="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[0];
		$nombreP=$con->obtenerValor($producto);
		
		$depto="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[1]."'";
		$nombreD=$con->obtenerValor($depto);
		
		$programa="SELECT tituloPrograma FROM 517_programas WHERE idPrograma=".$fila[2];
		$nProg=$con->obtenerValor($programa);
		
		echo "1|".$nombreP."|".$nombreD."|".$nProg."|".$fila[3];
	}
	
	function obtenerInventario()
	{
		global $con;
		$tipoI=$_POST["tipoI"];
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		if($tipoI==1)//inventario foliado
		{
			$consulta="SELECT idInventario,i.idProducto,idDetallePedido,idFormulario,idTablaDinamica,nombreProducto,descripcion,date_format(fechaRecepcion,'%d/%m/%Y'),idFormulario,codigo 
					   FROM  9307_inventario i, 9101_CatalogoProducto p WHERE i.idProducto=p.idProducto AND codigo<>'-1' and idPadre=-1 ".$condWhere." order by nombreProducto";
		}
		else//inventario sin folio
		{
			$consulta="SELECT idInventario,i.idProducto,idDetallePedido,idFormulario,idTablaDinamica,nombreProducto,descripcion,date_format(fechaRecepcion,'%d/%m/%Y'),idFormulario,codigo 
					   FROM  9307_inventario i, 9101_CatalogoProducto p WHERE i.idProducto=p.idProducto AND codigo='-1' and idPadre=-1 ".$condWhere." order by nombreProducto";
		}
		
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		$arrInv="";
		
		while($fila=mysql_fetch_row($res))
	    {
			
			$noFactura="";
			$conPedido="SELECT idPedido FROM 9103_PedidoDetalle WHERE idPedidoDetalle=".$fila[2];
			$idPedido=$con->obtenerValor($conPedido);
			if($idPedido!="")
			{
				$conFactura="SELECT noFactura FROM 9102_PedidoCabecera WHERE idPedido=".$idPedido;
				$noFactura=$con->obtenerValor($conFactura);
			}
			
			$conUbicacion="SELECT MAX(fechaMovimiento),idResponsable,tipoDestino,destino FROM 9308_historialTraslados WHERE idInventario=".$fila[0]." and estado=1";
			$filaU=$con->obtenerPrimerafila($conUbicacion);
			$nombreResponsable=obtenerNombreUsuario($filaU[1]);
			if($filaU[2]=="1")
			{
				$conDestino="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$filaU[3]."'";
				$nombreDestino=$con->obtenerValor($conDestino);
			}
			else
			{
				$conDestino="SELECT nombreAlmacen FROM 9030_almacenes WHERE idalmacen='".$filaU[3]."'";
				$nombreDestino=$con->obtenerValor($conDestino);
			}
			
			$ubicacion='<table><tr><td width=\"100\" align=\"left\">Responsable:</td><td width=\"300\" align=\"left\">'.$nombreResponsable.'</td></tr><tr><td width=\"100\" align=\"left\">Ubicaci&oacute;n:</td><td width=\"300\" align=\"left\">'.$nombreDestino.'</td></tr></table>';
			
			$obj='{"idTablaFormulario":"'.$fila[4].'","idProducto":"'.$fila[1].'","nombreProducto":"'.$fila[5].'","descripcion":"'.cv($fila[6]).'","fechaRecepcion":"'.$fila[7].'","ubicacion":"'.$ubicacion.'","idInventario":"'.$fila[0].'","idFormulario":"'.$fila[8].'","idDetallePedido":"'.$fila[2].'","codigo":"'.$fila[9].'","noFactura":"'.$noFactura.'"}';	
			if($arrInv=="")
				$arrInv=$obj;
			else
				$arrInv.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrInv.']}';
		
		echo $obj;
	}
	
	function guardarCodigoInventario()
	{
		global $con;
		
		$idInventario=$_POST["idInventario"];
		$codigo=$_POST["codigo"];
		
		$query="UPDATE 9307_inventario SET codigo='".$codigo."' WHERE idInventario=".$idInventario;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerElementosAsociados()
	{
		global $con;
		$idInventario=$_POST["idInventario"];
		
		$consulta="(SELECT idInventario,i.idProducto,nombreProducto,descripcion,codigo,tipoAsociacion FROM 9307_inventario i,9101_CatalogoProducto p WHERE i.idProducto=p.idProducto AND idPadre=".$idInventario.")
					UNION 
					(SELECT idInventario,idProducto,(nombreElemento) AS nombreProducto,(descripcionA) AS descripcion,codigo,tipoAsociacion FROM 9307_inventario WHERE idPadre=".$idInventario.") ORDER BY nombreProducto";
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		$arrInv="";
		
		while($fila=mysql_fetch_row($res))
	    {
			
			$obj='{"idInventario":"'.$fila[0].'","idProducto":"'.$fila[1].'","nombreProducto":"'.$fila[2].'","descripcion":"'.cv($fila[3]).'","codigo":"'.$fila[4].'","tipoAsociacion":"'.$fila[5].'"}';	
			if($arrInv=="")
				$arrInv=$obj;
			else
				$arrInv.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrInv.']}';
		
		echo $obj;
	}
	
	function guardarElementosAsociado()
	{
		global $con;
		
		$nombreE=$_POST["nombreE"];
		$descripcion=$_POST["descripcionE"];
		$idInventario=$_POST["idInventario"];
		
		$query="INSERT INTO 9307_inventario (idDetallePedido,idProducto,idFormulario,idTablaDinamica,idAlmacen,nombreElemento,descripcionA,idPadre,tipoAsociacion) VALUES(-1,-1,-1,-1,-1,'".$nombreE."','".$descripcion."',".$idInventario.",2)";
		if($con->ejecutarconsulta($query))
		{
			$idInv=$con->obtenerUltimoID();
			$codigo=str_pad($idInv,10, "0", STR_PAD_LEFT);
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				$query2[$ct]="UPDATE 9307_inventario SET idPadre=".$idInventario." WHERE idInventario=".$idInv;
				$ct++;
				$query2[$ct]="INSERT INTO 9309_historialAsociacion (idInventario,idPadre,fechaMovimiento,idResponsable,estado) 
							  VALUES(".$idInv.",".$idInventario.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",1)";
				$ct++;
				$query2[$ct]="commit";
				if($con->ejecutarBloque($query2))
					echo "1|";
				else
					echo "|";
			}
		}
	}
	
	function obtenerCodigoGenerico()
	{
		global $con;
		
		$idInventario=
		$id=$_POST["campoId"];
		
		$codigo=str_pad($id,10, "0", STR_PAD_LEFT);
		
		echo "1|".$codigo;
	}
	
	function verificarCodigoInventario()
	{
		global $con;
		
		$codigo=$_POST["codigo"];
		
		$query="SELECT idInventario FROM 9307_inventario WHERE codigo='".$codigo."' and idPadre=-1";
		$existe=$con->obtenerValor($query);
		if($existe!="")
			echo "1|".$existe;
		else
			echo "2|";
	}
	
	function asociarElementoInventariado()
	{
		global $con;
		
		$idInventario=$_POST["idInventario"];
		$idAsociado=$_POST["idAsociado"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct++;
			$query[$ct]="UPDATE 9307_inventario SET idPadre=".$idInventario." WHERE idInventario=".$idAsociado;
			$ct++;
			$query[$ct]="INSERT INTO 9309_historialAsociacion (idInventario,idPadre,fechaMovimiento,idResponsable,estado) 
					     VALUES(".$idAsociado.",".$idInventario.",".date('Y-m-d').",".$_SESSION["idUsr"].",1)";
			$ct++;
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function quitarElementoAsociado()
	{
		global $con;
		
		$idInventario=$_POST["idInventario"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="UPDATE 9307_inventario SET idPadre=-1 WHERE idInventario=".$arreglo[$x];
				$ct++;
				$query[$ct]="UPDATE 9309_historialAsociacion SET estado=0,fechaModificacion='".date('Y-m-d')."',responsableModif=".$_SESSION["idUsr"]." WHERE idInventario=".$arreglo[$x];
				$ct++;
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerCuentasAsociadasInventario()
	{
		global $con;
		
		$idInventario=$_POST["idInventario"];
		$codigo=base64_decode($_POST["codigo"]);
		
		$consulta="SELECT idInventarioVSCuentas,cuenta,tituloCta,porcentaje,tipoAfectacion FROM 9310_inventarioVSCuenta i,510_cuentas c WHERE idInventario=".$idInventario." AND codigo='".$codigo."' AND codigoCompletoCta=cuenta";
		$res=$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		$arrCuentas="";
		
		while($fila=mysql_fetch_row($res))
	    {
			
			$obj='{"idInventarioVSCuentas":"'.$fila[0].'","cuenta":"'.$fila[1].'","tituloCta":"'.$fila[2].'","porcentaje":"'.$fila[3].'","tipoAfectacion":"'.$fila[4].'"}';	
			if($arrCuentas=="")
				$arrCuentas=$obj;
			else
				$arrCuentas.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrCuentas.']}';
		
		echo $obj;		
	
	}
	
	function agregarCuentaInventario()
	{
		global $con;
		$idInventario=$_POST["idInventario"];
		$codigo=$_POST["codigo"];
		$cuenta=$_POST["cuenta"];
		$porcentaje=$_POST["porcentaje"];
		$afectacion=$_POST["afectacion"];
		
		$query="INSERT INTO 9310_inventarioVSCuenta(idInventario,codigo,cuenta,porcentaje,tipoAfectacion) 
			    VALUES(".$idInventario.",'".$codigo."','".$cuenta."',".$porcentaje.",".$afectacion.")";
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerCuentasDisponiblesInventario()
	{
		global $con;
		
		$idInventario=$_POST["idInventario"];
		$codigo=$_POST["codigo"];
		
		$conCadena="SELECT cuenta FROM 9310_inventarioVSCuenta WHERE  idInventario=".$idInventario." AND codigo='".$codigo."'";
		$cadena=$con->obtenerListaValores($conCadena);
		if($cadena=="")
		{
			$cadena="-1";
		}
		
		$consulta="SELECT codigoCompletoCta,concat('[',codigoCompletoCta,']  ',tituloCta) FROM 510_cuentas WHERE codigoCompletoCta NOT IN (".$cadena.") order by codigoCompletoCta";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arreglo);
	}
	
	function eliminarCuentasInventario()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="DELETE FROM 9310_inventarioVSCuenta WHERE idInventarioVSCuentas=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerInventarioTabla()
	{
		global $con;
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="select idInventario,noInv,claveCABMS,nombreProducto,noFactura,precioCompra,idProveedor,
		DATE_FORMAT(fechaCompra,'%d/%m/%Y') AS fechaCompra,DATE_FORMAT(fechaCompra,'%Y') AS anioInversion,
		codigoU,idResponsable,idDetallePedido,idFormulario, idTablaDinamica,idAlmacen 
		from 9307_inventario where ".$condWhere." limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$consulta="select count(*)	from 9307_inventario ";
		
		$numReg=$con->obtenerValor($consulta);
		$arrInv="";
		while($fila=mysql_fetch_row($res))
	    {
			$idProveedor=$fila[6];
			$cod_unidad=$fila[9];
			$idUsuario=$fila[10];
			$consulta2="select txtRazonSocial2 from _405_tablaDinamica where id__405_tablaDinamica='".$idProveedor."'";
			$razonSocial=$con->obtenerValor($consulta2);
			$obj='{"idInventario":"'.$fila[0].'","noInv":"'.$fila[1].'","claveCABMS":"'.$fila[2].'","nombreProducto":"'.cv($fila[3]).'",
			"noFactura":"'.$fila[4].'","precioCompra":"'.$fila[5].'","txtRazonSocial2":"'.$razonSocial.'","idProveedor":"'.$fila[6].'",
			"fechaCompra":"'.$fila[7].'","anioInversion":"'.$fila[8].'",
			"idDetallePedido":"'.$fila[11].'","idFormulario":"'.$fila[12].'",
			"idTablaDinamica":"'.$fila[13].'","idAlmacen":"'.$fila[14].'"}';	
			if($arrInv=="")
				$arrInv=$obj;
			else
				$arrInv.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrInv.']}';
		echo $obj;
	}
	
	function inventarioAmortizacion()
	{
		global $con;
		
		$conCiclo="SELECT ciclo FROM 550_cicloFiscal WHERE STATUS=1 AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$ciclo=$con->obtenerValor($conCiclo);
		
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
	  	$consulta="SELECT idInventario,i.idProducto,idDetallePedido,idFormulario,idTablaDinamica,nombreProducto,descripcion,date_format(fechaRecepcion,'%d/%m/%Y'),idFormulario,codigo,observaciones 
				 FROM  9307_inventario i, 9101_CatalogoProducto p WHERE i.idProducto=p.idProducto AND codigo<>'-1' and idPadre=-1 ".$condWhere." order by nombreProducto limit ".$inicio.",".$cantidad."";
		$res=$con->obtenerFilas($consulta);
		$consultaSinLimit="SELECT idInventario,i.idProducto,idDetallePedido,idFormulario,idTablaDinamica,nombreProducto,descripcion,date_format(fechaRecepcion,'%d/%m/%Y'),idFormulario,codigo,observaciones 
				 FROM  9307_inventario i, 9101_CatalogoProducto p WHERE i.idProducto=p.idProducto AND codigo<>'-1' and idPadre=-1 ".$condWhere." order by nombreProducto";
		$res2=$con->obtenerFilas($consultaSinLimit);
		$numReg=$con->filasAfectadas;
		$arrInv="";
		while($fila=mysql_fetch_row($res))
	    {
			
			$fecha=$fila[7];
			$arregloFecha=explode("/",$fecha);
			$añoEntrada=$arregloFecha[2];
			$numAños=$ciclo-$añoEntrada;
			
			$nombreProducto="";
			$descripcion="";
			$noFactura="";
			$valorI=0;
			if($fila[1]=="-1")
			{
				$conDatos="SELECT descCorta,descLarga,factura,valorInversion FROM 9120_inventario WHERE idInventario=".$fila[10];
				$filaD=$con->obtenerPrimeraFila($conDatos);
				if($filaD[0]!="")
				{
					$nombreProducto=$filaD[0];
					$descripcion=$filaD[1];
					$noFactura=$filaD[2];
					$valorI=$filaD[3];
				}
			}
			else
			{
				$conValor="SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idPedidoDetalle=".$fila[2];
				$valorI=$con->obtenerValor($conValor);
				if($valorI!="")
				{
					$valorI=number_format($valorI,4,'.',',');
				}
				
				
				$nombreProducto=$fila[5];
				$descripcion=$fila[6];
				$conPedido="SELECT idPedido FROM 9103_PedidoDetalle WHERE idPedidoDetalle=".$fila[2];
				$idPedido=$con->obtenerValor($conPedido);
				if($idPedido!="")
				{
					
					$conFactura="SELECT noFactura FROM 9102_PedidoCabecera WHERE idPedido=".$idPedido;
					$noFactura=$con->obtenerValor($conFactura);
				}
			}
			
			$valorDepre=0;
			$conCuenta="SELECT cuenta FROM 9310_inventarioVSCuenta WHERE idInventario=".$fila[0];
			$cuenta=$con->obtenerValor($conCuenta);
			if($cuenta!="")
			{
				$confCuenta="SELECT valorDesecho,vidaUtil FROM 9311_cuentaVsAmortizacion WHERE cuenta='".$cuenta."'";
				$filaC=$con->obtenerPrimeraFila($confCuenta);
				if($filaC[0]!="")
				{
					if($numAños>=$filaC[1])
					{
						$valorDepreA=($valorI-(($valorI)*(".".$filaC[0])))/$filaC[1];
						$valorDepre=$valorI-($valorDepreA*$filaC[1]);
					}
					else
					{
						$valorDepreA=($valorI-(($valorI)*(".".$filaC[0])))/$numAños;
						$valorDepre=$valorI-($valorDepreA*$numAños);
					}
				}
			}
			
			
			$conUbicacion="SELECT MAX(fechaMovimiento),idResponsable,tipoDestino,destino FROM 9308_historialTraslados WHERE idInventario=".$fila[0]." and estado=1";
			$filaU=$con->obtenerPrimerafila($conUbicacion);
			if($filaU[0]!="")
			{
				$nombreResponsable=obtenerNombreUsuario($filaU[1]);
				if($filaU[2]=="1")
				{
					$conDestino="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$filaU[3]."'";
					$nombreDestino=$con->obtenerValor($conDestino);
				}
				else
				{
					$conDestino="SELECT nombreAlmacen FROM 9030_almacenes WHERE idalmacen='".$filaU[3]."'";
					$nombreDestino=$con->obtenerValor($conDestino);
				}
			}
			else
			{
				$nombreResponsable="";
				$nombreDestino="";
			}
			
			$ubicacion='<table><tr><td width=\"100\" align=\"left\">Responsable:</td><td width=\"300\" align=\"left\">'.$nombreResponsable.'</td></tr><tr><td width=\"100\" align=\"left\">Ubicaci&oacute;n:</td><td width=\"300\" align=\"left\">'.$nombreDestino.'</td></tr></table>';
			
			$obj='{"idProducto":"'.$fila[1].'","nombreProducto":"'.$nombreProducto.'","descripcion":"'.cv($descripcion).'","fechaRecepcion":"'.$fila[7].'","ubicacion":"'.$ubicacion.'","idInventario":"'.$fila[0].'","codigo":"'.$fila[9].'","noFactura":"'.$noFactura.'","valor":"'.$valorI.'","valorDepre":"'.$valorDepre.'"}';	
			if($arrInv=="")
				$arrInv=$obj;
			else
				$arrInv.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrInv.']}';
		
		echo $obj;
	}
	
	function guardarConfcuenta()
	{
		global $con;
		
		$id=$_POST["id"];
		$cuenta=$_POST["cuenta"];
		$vidaU=$_POST["vidaU"];
		$valorD=$_POST["valorD"];
		
		if($id=="-1")
		{
			$query="INSERT INTO 9311_cuentaVsAmortizacion(cuenta,valorDesecho,vidaUtil) VALUES('".$cuenta."',".$valorD.",".$vidaU.")";
		}
		else
		{
			$query="UPDATE 9311_cuentaVsAmortizacion SET valorDesecho=".$valorD.",vidaUtil=".$vidaU." WHERE idCuentaVSAmortizacion=".$id;		
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function borrarConfcuenta()
	{
		global $con;
		
		$id=$_POST["id"];
		
		$query="DELETE FROM 9311_cuentaVsAmortizacion WHERE idCuentaVSAmortizacion=".$id;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerUsuariosDepto()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$cadena=$_POST["cadena"];
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a  where Paterno like '".$criterio."%' and codigoUnidad in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null  order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Materno like '".$criterio."%' and codigoUnidad in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Nom like '".$criterio."%' and codigoUnidad in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null order by Nom,Paterno,Materno asc)";
			break;
		}
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$noFilas=$con->filasAfectadas;
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				$sitaciones="";
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'","codigoUnidad":"'.$fila[6].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$noFilas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function guardarResponsableInv()
	{
		global $con;
		$idInventario=$_POST["idInventario"];
		$codigo=$_POST["codigo"];
		$unidad=$_POST["codU"];
		$idUsuario=$_POST["idUsr"];
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			$existe="SELECT idHistorialInventario,tipoDestino,destino,idResponsable FROM 9308_historialTraslados WHERE idInventario=".$idInventario;
			$filaE=$con->obtenerPrimeraFila($existe);
			if($filaE[0]=="")
			{
				$query[$ct]="INSERT INTO 9308_historialTraslados (idInventario,tipoOrigen,origen,tipoDestino,destino,idResponsable,fechaMovimiento,estado)
				VALUES(".$idInventario.",0,-1,1,'".$unidad."',".$idUsuario.",'".date('Y-m-d')."',1)";
				$ct++;
				$query[$ct]="UPDATE 9307_inventario SET idResponsable=".$idUsuario." WHERE idInventario=".$idInventario;
				$ct++;
			}
			else
			{
				$query[$ct]="UPDATE 9308_historialTraslados SET estado=0 WHERE idInventario=".$idInventario;
				$ct++;
				if($filaE[1]=="")
					$filaE[1]="0";
				if($filaE[2]=="")
					$filaE[2]="0001";
					
				$query[$ct]="INSERT INTO 9308_historialTraslados (idInventario,tipoOrigen,origen,tipoDestino,destino,idResponsable,fechaMovimiento,estado)
				VALUES(".$idInventario.",'".$filaE[1]."','".$filaE[2]."',1,'".$unidad."',".$idUsuario.",'".date('Y-m-d')."',1)";
				$ct++;
				$query[$ct]="UPDATE 9307_inventario SET idResponsable=".$idUsuario." WHERE idInventario=".$idInventario;
				$ct++;
			}
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|".obtenerNombreUsuario($idUsuario);
			else
				echo "|";
		}
	}
	
	function validarNoPiezasDetallePedido()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idPedidoDetalle=$_POST["idPedidoDetalle"];
		$cantidad=$_POST["cantidad"];
		
		$consulta="select id__".$idFormulario."_tablaDinamica from _".$idFormulario."_tablaDinamica where idReferencia=".$idPedidoDetalle;
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		if($nFilas==0)
		{
			$completo=0;
		}
		else	
		{
			if($nFilas==$cantidad)
				$completo=1;
			else
				$completo=0;
		}
		
		echo "1|".$completo;
	}
	
	function obtenerEntregasPendientesAlmacen()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="SELECT idEntrega,idProducto,codigoUnidad,idPrograma,cantidad,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,DATE_FORMAT(horaInicio,'%H:%i') as horaInicio,DATE_FORMAT(horaFin,'%H:%i') as horaFin,estado FROM 9305_fechasEntregasAlmacen WHERE idAlmacen=".$idAlmacen." and (estado=0 or estado=2) ORDER BY fecha DESC";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$arrEntregas="";
		while($fila=mysql_fetch_row($res))
		{
			$consultaN="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[1];
			$nombreP=$con->obtenerValor($consultaN);
			
			$consultaU="SELECT unidad FROM 817_organigrama  WHERE codigoUnidad=".$fila[2];
			$nombreU=$con->obtenerValor($consultaU);
			
			$consultaP="SELECT tituloPrograma FROM 517_programas WHERE idPrograma=".$fila[3];
			$nombrePrg=$con->obtenerValor($consultaP);
			
			$obj='{"idEntrega":"'.$fila[0].'","idProducto":"'.$fila[1].'","nombreP":"'.$nombreP.'","codUnidad":"'.$fila[2].'","nomD":"'.$nombreU.'","idPrograma":"'.$fila[3].'","nombrePrg":"'.$nombrePrg.'","fecha":"'.$fila[5].'","horaIni":"'.$fila[6].'","horaFin":"'.$fila[7].'","estado":"'.$fila[8].'","cantidad":"'.$fila[4].'"}';
			if($arrEntregas=="")
				$arrEntregas=$obj;
			else
				$arrEntregas.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","registros":['.uDJ($arrEntregas).']}';
		echo $obj;
	}
	
	function verificarEntregaInventariable()
	{
		global $con;
		
		$idEntrega=$_POST["idEntrega"];
		
		$consulta="SELECT idProducto FROM 9305_fechasEntregasAlmacen WHERE idEntrega=".$idEntrega;
		$idProducto=$con->obtenerValor($consulta);
		if($idProducto=="")
		{
			echo "1|0";
		}
		else
		{
			$conObj="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto ;
			$objP=$con->obtenerValor($conObj);
			if($objP=="")
			{
				echo "1|0";
			}
			else
			{
				$confObj="SELECT *FROM 9306_confPartidaAlmacen WHERE clave='".$objP."'";
				$fila=$con->obtenerPrimeraFila($confObj);
				if($fila)
				{
					if($fila[4]==1)
					{
						echo "1|1|".$fila[2]."|".$fila[3];
					}
					else
					{
						echo "1|0";
					}
				}
				else
				{
					echo "1|0";
				}
			}
		}
	}
	
	function modificarEstadoEntrega()
	{
		global $con;
		
		$idEntrega=$_POST["idEntrega"];
		$estado=$_POST["estado"];
		
		$query="UPDATE 9305_fechasEntregasAlmacen SET estado=".$estado." WHERE idEntrega=".$idEntrega;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function buscarUsuarios()
	{
		global $con;
		
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica i,801_adscripcion a where i.idUsuario=a.idUsuario and Institucion=".$_SESSION["codigoInstitucion"]." and Paterno like '".$criterio."%'   order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta="select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status from 802_identifica  where i.idUsuario=a.idUsuario and Institucion=".$_SESSION["codigoInstitucion"]." and Materno like '".$criterio."%' order by Materno,Paterno,Nom asc";
			break;
			case "3": //Nombre
				$consulta="select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica  where i.idUsuario=a.idUsuario and Institucion=".$_SESSION["codigoInstitucion"]." and Nom like '".$criterio."%' order by Nom,Paterno,Materno asc";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				$sitaciones="";
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function obtenerNoInventario()
	{
		global $con;
		
		$noInventario=$_POST["noInventario"];
		$idUsuario=$_POST["idUsuario"];
		
		$consulta="SELECT idInventario FROM 9307_inventario WHERE codigo='".$noInventario."'";
		$noInv=$con->obtenerValor($consulta);
		if($noInv=="")
			$existe=0;
		else
			$existe=$noInv;
			
		$conUnidad="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$idUsuario;
		$unidad=$con->obtenerValor($conUnidad);
		if($unidad=="")
			$unidad="-1";
		
		$conNombreU="SELECT unidad FROM 817_organigrama WHERE codigoUnidad=".$unidad;
		$nombreU=$con->obtenerValor($conNombreU);
		if($nombreU=="")
			$nombreU="-1";
			
		$conAsociado="SELECT idResponsable FROM 9309_historialAsociacion WHERE idInventario=".$noInv." AND estado=1";
		$asociado=$con->obtenerValor($conAsociado);
		if($asociado=="")
		{
			$tieneA=0;
			$asociado="-1";
		}
		else
		{
			$tieneA=1;
		}
		
		$nombreAs=obtenerNombreUsuario($asociado);
		$nombreUsr=obtenerNombreUsuario($idUsuario);
		
		echo "1|".$existe."|".$unidad."|".$nombreU."|".$nombreUsr."|".$tieneA."|".$nombreAs."|".$asociado;
	}
	
	function guardarEntregadoListaEntrega()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idEntrega=$_POST["idEntrega"];
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			$query[$ct]="UPDATE 9305_fechasEntregasAlmacen SET estado=1 WHERE idEntrega=".$idEntrega;
			$ct++;
			
			for($x=0;$x<$tamano;$x++)
			{
				$elemento=$arreglo[$x];
				$datos=explode("_",$elemento);
				
				$conPadre="SELECT idPadre FROM 9307_inventario WHERE idInventario=".$datos[0];
				$idPadre=$con->obtenerValor($conPadre);
				
				$conExiste="SELECT idHistorialAsociacion FROM 9309_historialAsociacion WHERE idInventario=".$datos[0]." and estado=1";
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 9309_historialAsociacion (idInventario,idPadre,fechaMovimiento,idResponsable,estado) 
								VALUES (".$datos[0].",".$idPadre.",'".date('Y-m-d')."',".$datos[2].",1)";
					$ct++;
				}
				else
				{
					$conResp="SELECT idResponsable FROM 9309_historialAsociacion WHERE idHistorialAsociacion=".$existe;
					$idRespAnt=$con->obtenerValor($conResp);
					if($idRespAnt!=$datos[2])
					{
						$query[$ct]="UPDATE 9309_historialAsociacion SET estado=0,fechaModificacion='".date('Y-m-d')."',responsableModif=".$_SESSION["idUsr"]." WHERE idHistorialAsociacion=".$existe;
						$ct++;
						
						$query[$ct]="INSERT INTO 9309_historialAsociacion (idInventario,idPadre,fechaMovimiento,idResponsable,estado) 
								     VALUES (".$datos[0].",".$idPadre.",'".date('Y-m-d')."',".$datos[2].",1)";
						$ct++;			 
					}
					
				}
				
				if($datos[4]!="")
				{
					$query[$ct]="INSERT INTO 9308_historialTraslados (idInventario,tipoOrigen,origen,tipoDestino,destino,idResponsable,fechaMovimiento,idOrdenTranslado)
								 VALUES(".$datos[0].",0,".$idalmacen.",1,".$datos[3].",".$datos[2].",'".date('Y-m-d')."',".$datos[4].")";
					$ct++;			 
				}
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerEntregasRealizadas()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="SELECT idEntrega,idProducto,codigoUnidad,idPrograma,cantidad,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,DATE_FORMAT(horaInicio,'%H:%i') as horaInicio,DATE_FORMAT(horaFin,'%H:%i') as horaFin,estado FROM 9305_fechasEntregasAlmacen WHERE idAlmacen=".$idAlmacen." and estado=1 ORDER BY fecha DESC";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$arrEntregas="";
		while($fila=mysql_fetch_row($res))
		{
			$consultaN="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[1];
			$nombreP=$con->obtenerValor($consultaN);
			
			$consultaU="SELECT unidad FROM 817_organigrama  WHERE codigoUnidad=".$fila[2];
			$nombreU=$con->obtenerValor($consultaU);
			
			$consultaP="SELECT tituloPrograma FROM 517_programas WHERE idPrograma=".$fila[3];
			$nombrePrg=$con->obtenerValor($consultaP);
			
			$obj='{"idEntrega":"'.$fila[0].'","idProducto":"'.$fila[1].'","nombreP":"'.$nombreP.'","codUnidad":"'.$fila[2].'","nomD":"'.$nombreU.'","idPrograma":"'.$fila[3].'","nombrePrg":"'.$nombrePrg.'","fecha":"'.$fila[5].'","horaIni":"'.$fila[6].'","horaFin":"'.$fila[7].'","estado":"'.$fila[8].'","cantidad":"'.$fila[4].'"}';
			if($arrEntregas=="")
				$arrEntregas=$obj;
			else
				$arrEntregas.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","registros":['.uDJ($arrEntregas).']}';
		echo $obj;
	}
	
	function obtenerDatosFactura()
	{
		global $con;
		
		$idTabla=$_POST["idFacturaPedido"];
		
		$consulta="SELECT cadena,folioFactura,idFacturaPedido FROM 9304_facturaVSPedido WHERE idFacturaPedido=".$idTabla;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$cadena=$fila[0];
			$folioFactura=$fila[1];
			$facturaE=$fila[2];
		}
		else
		{
			$cadena="-1";
			$folioFactura="-1";
			$facturaE="-1";
		}
		
		echo "1|".$cadena."|".$folioFactura."|".$facturaE;
	}
	
	function obtenerEntregasAgendadasPorProducto()
	{
		global $con;
		
		$idProducto=$_POST["idProducto"];
		$idCiclo=$_POST["idCiclo"];
		$mes=$_POST["mes"];
		$idAlmacen=$_POST["idAlmacen"];
		
		$consulta="SELECT idEntrega,idPrograma,codigoUnidad,idProducto,cantidad,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,DATE_FORMAT(horaInicio,'%H:%i') AS horaInicio,DATE_FORMAT(horaFin,'%H:%i') AS horaFin,estado
					FROM 9305_fechasEntregasAlmacen WHERE idAlmacen=".$idAlmacen." AND idCiclo=".$idCiclo." AND idProducto=".$idProducto." AND mes=".$mes." order by fecha ASC";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$arrEntregasProg="";
		while($fila=mysql_fetch_row($res))
		{
			$consultaN="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[1];
			$nombreP=$con->obtenerValor($consultaN);
			
			$consultaU="SELECT unidad FROM 817_organigrama  WHERE codigoUnidad=".$fila[2];
			$nombreU=$con->obtenerValor($consultaU);
			
			$consultaP="SELECT tituloPrograma FROM 517_programas WHERE idPrograma=".$fila[3];
			$nombrePrg=$con->obtenerValor($consultaP);
			
			$obj='{"idEntrega":"'.$fila[0].'","idProducto":"'.$fila[3].'","nombreP":"'.$nombreP.'","codUnidad":"'.$fila[2].'","nomD":"'.$nombreU.'","idPrograma":"'.$fila[2].'","nombrePrg":"'.$nombrePrg.'","fecha":"'.$fila[5].'","horaIni":"'.$fila[6].'","horaFin":"'.$fila[7].'","estado":"'.$fila[8].'","cantidad":"'.$fila[4].'"}';
			if($arrEntregasProg=="")
				$arrEntregasProg=$obj;
			else
				$arrEntregasProg.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","registros":['.uDJ($arrEntregasProg).']}';
		echo $obj;
	}
	
	function obtenerExistenciasAlmacen()
	{
		global $con;
		
		$idAlmacen=$_POST["idAlmacen"];
	}
	
	function removerCategoriaAlmacen()
	{
		global $con;
		$consulta="select idCategoria from 9030_almacenVSCategoria where idAlmacenVSCategoria=".$id;
		$idCategoria=$con->obtenerValor($consulta);
		$id=$_POST["idTabla"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 9030_almacenVSCategoria WHERE idAlmacenVSCategoria=".$id;
		$x++;
		$query[$x]="UPDATE 9101_CatalogoProducto SET idAlmacen='-1' WHERE idCategoria=".$idCategoria;
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosProveedor()
	{
		global $con;
		
		$idProv=$_POST["idProv"];
		
		$consulta="SELECT txtRFC,txtDireccion,txtColonia,txtDelegacion,cmbPais,txtTelefono1,txtTelefono2,txtFax,txtContacto,txtCorreo,txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$idProv;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila[4]=="")
			$idPais="-1";
		else
			$idPais=$fila[4];
			
		$conPais="SELECT nombre FROM 238_paises WHERE idPais=".$idPais;
		$pais=$con->obtenerValor($conPais);
		
		echo "1|".$fila[0]."|".$fila[1]."|".$fila[2]."|".$fila[3]."|".$pais."|".$fila[5]."|".$fila[6]."|".$fila[7]."|".$fila[8]."|".$fila[9]."|".$fila[10];
	}
	
	function obtenerHistorialInv()
	{
		global $con;
		
		$idInv=$_POST["idInv"];
		
		$consulta="SELECT tipoDestino,destino,DATE_FORMAT(fechaMovimiento,'%d/%m/%Y') AS fechaMovimiento,DATE_FORMAT(fechaCambio,'%d/%m/%Y') AS fechaCambio,idResponsable,estado FROM 9308_historialTraslados WHERE idInventario=".$idInv." ORDER BY fechaMovimiento";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$arrHist="";
		while($fila=mysql_fetch_row($res))
		{
			$nombreUsr=obtenerNombreUsuario($fila[4]);
			if($fila[0]=="1")
			{
				$conDestino="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[1]."'";
				$nombreDestino=$con->obtenerValor($conDestino);
			}
			else
			{
				$conDestino="SELECT nombreAlmacen FROM 9030_almacenes WHERE idAlmacen='".$fila[1]."'";
				$nombreDestino=$con->obtenerValor($conDestino);
			}
			
			if($fila[5]==1)
				$estado="Activo";
			else
				$estado="No Activo";
			
			$obj='{"idUsuario":"'.$fila[4].'","nombreUsuario":"'.$nombreUsr.'","depto":"'.$nombreDestino.'","fechaAsignacion":"'.$fila[2].'","fechaCambio":"'.$fila[3].'","estado":"'.$estado.'"}';
			if($arrHist=="")
				$arrHist=$obj;
			else
				$arrHist.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","registros":['.uDJ($arrHist).']}';
		echo $obj;
	}
	
	function obtenerProductosAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$consulta="SELECT idCategoria FROM 9030_almacenVSCategoria WHERE idAlmacen =".$idAlmacen;
		
		$arrValores="";
		if(strpos($condWhere,"existencia")===false)
		{
			$consulta="SELECT idProducto,clave_Art,nombreProducto,c.descripcion,(SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen 
						WHERE idProducto=c.idProducto) AS existencia,
						nombreObjetoGasto,costoUnitarioInicial,status_art,cat.nombre,o.clave,cat.cveCategoria  FROM 9101_CatalogoProducto c,507_objetosGasto o, 9030_categoriasObjetoGasto cat
						 WHERE o.codigoControl=c.objetoGasto AND c.idAlmacen=".$idAlmacen." and ".$condWhere." and cat.idCategoria=c.idCategoria ORDER BY nombreProducto LIMIT ".$start.",".$limit;
			$consulta2="SELECT idProducto FROM 9101_CatalogoProducto c,507_objetosGasto o , 9030_categoriasObjetoGasto cat
					 WHERE o.codigoControl=c.objetoGasto AND c.idAlmacen=".$idAlmacen." and ".$condWhere." and cat.idCategoria=c.idCategoria";
		}
		else
		{
			$consulta="select * from (SELECT idProducto,clave_Art,nombreProducto,c.descripcion,(SELECT SUM(cantidad*operacion) as existencia FROM 
						9302_existenciaAlmacen WHERE idProducto=c.idProducto) AS existencia,nombreObjetoGasto,costoUnitarioInicial,status_art,cat.nombre,o.clave,cat.cveCategoria 
							FROM 9101_CatalogoProducto c,507_objetosGasto o , 9030_categoriasObjetoGasto cat
						 WHERE o.codigoControl=c.objetoGasto AND c.idAlmacen=".$idAlmacen." and  cat.idCategoria=c.idCategoria) as tmp where ".$condWhere."  ORDER BY nombreProducto LIMIT ".$start.",".$limit;
			$consulta2="select * from (SELECT idProducto,clave_Art,nombreProducto,c.descripcion,(SELECT SUM(cantidad*operacion) as existencia FROM 
						9302_existenciaAlmacen WHERE idProducto=c.idProducto) AS existencia,nombreObjetoGasto,costoUnitarioInicial,status_art,cat.nombre,o.clave,cat.cveCategoria 
							FROM 9101_CatalogoProducto c,507_objetosGasto o , 9030_categoriasObjetoGasto cat
						 WHERE o.codigoControl=c.objetoGasto AND c.idAlmacen=".$idAlmacen." and  cat.idCategoria=c.idCategoria) as tmp where ".$condWhere."  ORDER BY nombreProducto LIMIT ".$start.",".$limit;
			
		}
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			if($fila[4]=="")
				$fila[4]=0;
			$consulta="SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=".$fila[0]." ORDER BY fechaPedido DESC LIMIT 0,1";
			$ultimoPrecio=$con->obtenerValor($consulta);
			if($ultimoPrecio=="")
				$ultimoPrecio=$fila[6];
			if($ultimoPrecio=="")
				$ultimoPrecio=0;
			$obj='{"cveCategoria":"'.$fila[10].'","cveObjetoGasto":"'.$fila[9].'","nombre":"'.$fila[8].'","status_art":"'.$fila[7].'","idProducto":"'.$fila[0].'","clave_Art":"'.$fila[1].'","nombreProducto":"'.cv($fila[2]).'","descripcion":"'.cv($fila[3]).'","existencia":"'.$fila[4].'","nombreObjetoGasto":"'.$fila[5].'","ultimoPrecio":"'.$ultimoPrecio.'"}';
			if($arrValores=="")
				$arrValores=$obj;
			else
				$arrValores.=",".$obj;

		}
		
		$nProductos=$con->obtenerFilas($consulta);
		echo  '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrValores.']}';
		
		
	}
	
	function removerProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idProducto=".$idProducto;
		$con->obtenerFilas($consulta);
		if($con->filasAfectadas>0)
		{
			echo "Se encuentran registros que hacen referencia a este producto, se recomienda marcarlo como inactivo";
		}
		else
		{
			$consulta="delete from 9101_CatalogoProducto where idProducto=".$idProducto;
			eC($consulta);
		}
		
	}
	
	function obtenerProductosPendientesEntrega()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$consulta="SELECT distinct t.txtRazonSocial2,p.idPedido,folioPedido,fechaRecepcion,DATEDIFF(fechaRecepcion,curdate()) as diferencia FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
				9103_PedidoDetalle d,9101_CatalogoProducto c WHERE   p.status_pedido=1 AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto and p.idAlmacen=".$idAlmacen." and ".$condWhere." limit ".$start.",".$limit;
		$arrProductos=$con->obtenerFilasJson($consulta);
		$consulta="SELECT count(*) FROM 9102_PedidoCabecera p,9101_CatalogoProducto c WHERE   p.status_pedido=1 and c.idProducto=p.idProducto and p.idAlmacen=".$idAlmacen;
		$nFilas=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nFilas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function obtenerDetallePedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$consulta="SELECT p.idProducto,pro.nombreProducto,
					(select descripcion from _406_tablaDinamica where id__406_tablaDinamica=p.idMarca) AS marca,
					modelo,cantidad,costoUnitario,iva,(select descripcion from _404_tablaDinamica where id__404_tablaDinamica=p.idContenedor) AS contenedor,
					(select descripcion from _403_tablaDinamica where id__403_tablaDinamica=p.idUnidadMedida) AS unidadMedida,
					(select descripcion from _407_tablaDinamica where id__407_tablaDinamica=p.idPresentacion) AS presentacion
					FROM 9103_PedidoDetalle p,9101_CatalogoProducto pro WHERE 
					p.idPedido=".$idPedido." aND pro.idProducto=p.idProducto";
		$arrRegistros=$con->obtenerFilasJson($consulta);					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerProductosRecibidos()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$consulta="SELECT distinct t.txtRazonSocial2,p.idPedido,folioPedido,fechaRecibido,e.fecha_entrada,e.num_Factura,u.Nombre 
					FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
					9103_PedidoDetalle d,9101_CatalogoProducto c,9104_EntradaAlmacen e,800_usuarios u WHERE   
					p.status_pedido=0 AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
				and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and u.idUsuario=e.idUsuarioRecibio and ".$condWhere." limit ".$start.",".$limit;

		$arrProductos=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct t.txtRazonSocial2,p.idPedido,folioPedido,fechaRecibido,e.fecha_entrada,e.num_Factura,u.Nombre FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
				9103_PedidoDetalle d,9101_CatalogoProducto c,9104_EntradaAlmacen e,800_usuarios u WHERE   p.status_pedido=0 AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
				and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and u.idUsuario=e.idUsuarioRecibio and ".$condWhere;
		$nFilas=$con->obtenerFilas($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function obtenerProductosEstado()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idEstado=$_POST["idEstado"];
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$arrProductos="";
		if($idAlmacen!=-1)
		{
			$consulta="SELECT distinct t.txtRazonSocial2,p.idPedido,folioPedido,fechaRecibido,e.fecha,e.motivo,u.Nombre FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
					9103_PedidoDetalle d,9101_CatalogoProducto c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   
					p.status_pedido=".$idEstado." AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable 
					and ".$condWhere." limit ".$start.",".$limit;
	
			$arrProductos=$con->obtenerFilasJson($consulta);
			$consulta="SELECT count(*) FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
					9103_PedidoDetalle d,9101_CatalogoProducto c,9101_pedidosBajoCircunstancias e,
					800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido  
					and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere;

		}
		else
		{
			$consulta="SELECT distinct t.txtRazonSocial2,p.idPedido,folioPedido,fechaRecibido,e.fecha,e.motivo,u.Nombre FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
					9103_PedidoDetalle d,9101_CatalogoProducto c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and e.idPedido=p.idPedido and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere." limit ".$start.",".$limit;
	
			$arrProductos=$con->obtenerFilasJson($consulta);
			$consulta="SELECT count(*) FROM 9102_PedidoCabecera p,_405_tablaDinamica t,
					9103_PedidoDetalle d,9101_CatalogoProducto c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.id__405_tablaDinamica=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and e.idPedido=p.idPedido  and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere;
		}
		$nFilas=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nFilas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function obtenerSolicitudesEntrega()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}

		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$arrRutas=obtenerCodigosRutas();			
		$consulta="select idSolicitudEntrega,unidad,tituloPrograma,ruta,p.nombreProducto,cantidad,u.Nombre,fechaSolicitud,fechaLimitePrefenteEntrega,c.comentario ,cvePrograma,s.idProducto,s.idPrograma,o.codigoUnidad
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr,9107_comentariosSolicitud c 
					where idEstado=1 and p.idAlmacen=".$idAlmacen." and o.codigoUnidad=s.departamento and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and c.idSolicitud=s.idSolicitudEntrega
					and c.numEtapa=s.idEstado and ".$condWhere." limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);	
		$arrObj="";				
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=".$fila[11]." AND idPrograma=".$fila[12]." AND ruta='".$fila[3]."' AND codigoUnidad='".$fila[13]."'";
			$existencia=$con->obtenerValor($consulta);
			$obj='{"existenciaAlmacen":"'.$existencia.'","idSolicitudEntrega":"'.$fila[0].'","unidad":"'.$fila[1].'","tituloPrograma":"'.$fila[2].'","ruta":"'.$arrRutas[$fila[3]].'","nombreProducto":"'.$fila[4].'","cantidad":"'.$fila[5].'","Nombre":"'.$fila[6].'","fechaSolicitud":"'.$fila[7].'",
				"fechaLimitePrefenteEntrega":"'.$fila[8].'","comentarioSolicitud":"'.$fila[9].'","cvePrograma":"'.$fila[10].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		$consulta="select count(*)
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr 
					where idEstado=1 and p.idAlmacen=".$idAlmacen." and o.codigoUnidad=s.departamento and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and ".$condWhere;
		$nRegistro=$con->obtenerValor($consulta);			
		echo '{"numReg":"'.$nRegistro.'","registros":['.$arrObj.']}';
					
	}
	
	
	function cambiarStatusPedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$motivo=$_POST["motivo"];
		$status=$_POST["status"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9102_PedidoCabecera set status_pedido=".$status." where idPedido=".$idPedido;
		$x++;
		$consulta[$x]="INSERT INTO 9101_pedidosBajoCircunstancias(idPedido,motivo,idResponsable,fecha,idEtapa) VALUES(".$idPedido.",'".cv($motivo)."',".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$status.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarEntradaPedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="set @noMovimiento=(SELECT noMovimiento FROM 903_variablesSistema for update)";
		$x++;
		$consulta[$x]="update 903_variablesSistema set noMovimiento=noMovimiento+1";
		$x++;
		$consulta[$x]="update 9102_PedidoCabecera set status_pedido=0,noMovimiento=@noMovimiento where idPedido=".$idPedido;
		$x++;
		$query="select * from 9103_PedidoDetalle WHERE idPedido=".$idPedido;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$idProducto=$fila[2];
			$cantidadRecibida=$fila[5];
			$idContenedor=$fila[11];
			if($idContenedor=="")
				$idContenedor="NULL";
			$idUnidadMedida=$fila[12];
			if($idUnidadMedida=="")
				$idUnidadMedida="NULL";
			$idPresentacion=$fila[13];
			if($idPresentacion=="")
				$idPresentacion="NULL";
			$consulta[$x]="INSERT INTO 9104_EntradaAlmacen(idPedido,idProducto,cant_Recibida,fecha_entrada,idUsuarioRecibio,status_Pedido,num_Factura,idContenedorRec,idUnidadMedidaRec,idPresentacionRec,noMovimiento)
							VALUES(".$idPedido.",".$idProducto.",".$cantidadRecibida.",'".date("Y-m-d").
							"',".$_SESSION["idUsr"].",0,".cv($obj->numFactura).",".$idContenedor.",".$idUnidadMedida.",".$idPresentacion.",@noMovimiento)";
			$x++;	
			$consulta[$x]="INSERT INTO 9302_existenciaAlmacen(idPedido,idProducto,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,noMovimiento)
							VALUES(".$idPedido.",".$idProducto.",".$cantidadRecibida.",'".date("Y-m-d")."',1,".$_SESSION["idUsr"].",1,@noMovimiento)";	
			$x++;					
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function reagendarPedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$fechaReagenda=$_POST["fechaReagenda"];
		$status="1";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9102_PedidoCabecera set status_pedido=".$status.", fechaRecepcion='".$fechaReagenda."' where idPedido=".$idPedido;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function reestructurarPedido()
	{
		global $con;
		$porcIva=16;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select * from 9102_PedidoCabecera where idPedido=".$obj->idPedido;
		$filaCabecera=$con->obtenerPrimeraFila($query);
		$query="select * from 9103_PedidoDetalle where idPedido=".$obj->idPedido;
		$filaDetalle=$con->obtenerPrimeraFila($query);
		
		foreach($obj->arrEntregables as $e)
		{
			$idConcentrado=$filaCabecera[21];
			if($idConcentrado=="")
				$idConcentrado="NULL";
			$consulta[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,mes,idConcentradoProducto,idProducto,idPadre)
								 VALUES(".$filaCabecera[1].",'".date("Y-m-d")."','".$e->fechaEntrega."',1,'',".date("m",strtotime($e->fechaEntrega)).",".$idConcentrado.",".$filaCabecera[19].",".$obj->idPedido.")";

			$x++;
			$consulta[$x]="set @idPedido=(select last_insert_id())";
			$x++;
			$iva=0;
			if($filaDetalle[7]!=0)
			{
				$iva=($obj->costoUnitario*$e->entregable)*($porcIva/100);
			}
			$idContenedor=$filaDetalle[10];
			if($idContenedor=="")
				$idContenedor="NULL";
			$idUnidadMedida=$filaDetalle[11];
			if($idUnidadMedida=="")
				$idUnidadMedida="NULL";
			$idPresentacion=$filaDetalle[12];
			if($idPresentacion=="")
				$idPresentacion="NULL";
			$consulta[$x]=" INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,modelo,cantidad,costoUnitario,iva,statusPedido,idContenedor,idUnidadMedida,idPresentacion,fechaPedido,partida) 
							VALUES(@idPedido,'".$filaDetalle[2]."',".$filaDetalle[3].",'".$filaDetalle[4]."',".$e->cantidad.",".$filaDetalle[6].",".$iva.",1,".$idContenedor.",".$idUnidadMedida.",".
							$idPresentacion.",'".$e->fechaEntrega."','".$filaDetalle[14]."')";
			$x++;
			$consulta[$x]="update 9102_PedidoCabecera set folioPedido=idPedido where idPedido=@idPedido";
			$x++;
		}
		
		$consulta[$x]="update 9102_PedidoCabecera set status_pedido=2 where idPedido=".$obj->idPedido;
		$x++;
		$consulta[$x]="INSERT INTO 9101_pedidosBajoCircunstancias(idPedido,motivo,idResponsable,fecha,idEtapa) VALUES(".$obj->idPedido.",
						(select concat('Pedido reestructurado, se dividio en los pedidos: ',(SELECT GROUP_CONCAT(folioPedido) FROM 9102_PedidoCabecera WHERE idPadre=".$obj->idPedido.")) as motivo),".$_SESSION["idUsr"].",'".date("Y-m-d")."',2)";

		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerSituacionProductosDepto()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$arrRutas=obtenerCodigosRutas($ciclo);
		$consulta="SELECT idCodigoGastoCiclo,p.idProducto,nombreProducto,descripcion,cantidad,idPrograma,ruta,c.objetoGasto FROM  525_productosAutorizados p,9101_CatalogoProducto c WHERE  idCiclo=".$ciclo." 
					AND codDepto='".$_SESSION["codigoUnidad"]."' AND p.idProducto<>-1 AND c.idProducto=p.idProducto";
		$resProductos=$con->obtenerFilas($consulta);
		$arrProd="";					
		while($fila=mysql_fetch_row($resProductos))
		{
			
			$consulta="SELECT al.nombreAlmacen FROM 9351_categoriaVSConcepto c,9303_almacenVSCategoria a,9030_almacenes al WHERE al.idAlmacen=a.idAlmacen and  c.idCategoria=a.idCategoria AND c.claveConcepto='".$fila[7]."'";
			$responsable=$con->obtenervalor($consulta);
			
			$consulta="select sum(d.cantidad) from 526_distribucionAutorizada d,525_productosAutorizados p where p.idCodigoGastoCiclo=d.idCodigoGastoCiclo and d.idCodigoGastoCiclo=".$fila[0]." and idCiclo=".date("Y")." and mes<=".date("m");
			$cantidadPlaneada=$con->obtenerValor($consulta);
			if($cantidadPlaneada=="")
				$cantidadPlaneada=0;
			$consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacen WHERE idProducto=".$fila[1]." and idProducto=".$fila[1]." AND idPrograma=".$fila[5]." AND ruta='".$fila[6]."' AND codigoUnidad='".$_SESSION["codigoUnidad"]."'";
			$existenciaAlmacen=$con->obtenerValor($consulta);
			if($existenciaAlmacen=="")
				$existenciaAlmacen=0;
			$consulta="SELECT SUM(cantidad) FROM 9107_solicitudesEntrega WHERE ciclo=".$ciclo." AND departamento='".$_SESSION["codigoUnidad"]."' AND  idPrograma=".$fila[5]." and ruta='".$fila[6]."' AND idProducto=".$fila[1]." AND idEstado=4";
			$cantidadEjercida=$con->obtenerValor($consulta);
			if($cantidadEjercida=="")
				$cantidadEjercida="0";
			$consulta="SELECT SUM(cantidad) FROM 9107_solicitudesEntrega WHERE ciclo=".$ciclo." AND departamento='".$_SESSION["codigoUnidad"]."' AND  idPrograma=".$fila[5]." and ruta='".$fila[6]."' AND idProducto=".$fila[1]." AND idEstado=2";
			$cantidadProgramada=$con->obtenerValor($consulta);
			if($cantidadProgramada=="")
				$cantidadProgramada="0";				
			$consulta="select cvePrograma,tituloPrograma from 517_programas where idPrograma=".$fila[5];
			$filaProg=$con->obtenerPrimeraFila($consulta);
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","idProducto":"'.$fila[1].'","nombreProducto":"'.cv($fila[2]).'","descripcion":"'.cv($fila[3]).'","idPrograma":"'.cv($fila[5]).
				'","ruta":"'.$fila[6].'","programa":"['.$arrRutas[$fila[6]].' '.$filaProg[0].'] '.$filaProg[1].'",
					"cantidadAutorizada":"'.$fila[4].'","cantidadPlaneada":"'.$cantidadPlaneada.'","cantidadEjercida":"'.$cantidadEjercida.'","cantidadProgramada":"'.$cantidadProgramada.'","existenciaAlmacen":"'.$existenciaAlmacen.'","almacenResponsable":"'.$responsable.'"}';
			if($arrProd=="")
				$arrProd=$obj;
			else
				$arrProd.=",".$obj;
		}
		$consulta="SELECT count(*) FROM  525_productosAutorizados p,9101_CatalogoProducto c WHERE  idCiclo=".$ciclo." 
					AND codDepto='".$_SESSION["codigoUnidad"]."' AND p.idProducto<>-1 AND c.idProducto=p.idProducto";
		$nRegistros=$con->obtenerValor($consulta);					
		echo '{"numReg":"'.$nRegistros.'",registros:['.$arrProd.']}';
	}
	
	function obtenerProveedores()
	{
		global $con;
		$tipoProveedor=$_POST["tipoProveedor"];  //1 activo;0 inactivo
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$comp="";
		if($tipoProveedor=="0")
		{
			$comp="not";
			
		}
		$consulta="";
		if($idAlmacen!=-1)
		{
			
			if($tipoProveedor==0)
			{
				$consulta="SELECT DISTINCT(idProveedor_ult) FROM 9102_PedidoCabecera p,9103_PedidoDetalle d 
				WHERE status_pedido=0 and d.idPedido=p.idPedido AND p.idAlmacen=".$idAlmacen;
				$listaProveedores=$con->obtenerListaValores($consulta);
				if($listaProveedores=="")
					$listaProveedores="-1";
				$condWhere.=" and id__405_tablaDinamica in (".$listaProveedores.")";
			}
			else
				$consulta="SELECT DISTINCT id__405_tablaDinamica FROM _405_tablaDinamica";
			//$consulta="SELECT DISTINCT(idProveedor_ult) FROM 9102_PedidoCabecera p,9103_PedidoDetalle d 
			//WHERE status_pedido=1 and d.idPedido=p.idPedido AND p.idAlmacen=".$idAlmacen;
			
			
			
		}
		else
		{
			$consulta="SELECT DISTINCT(idProveedor_ult) FROM 9102_PedidoCabecera p,9103_PedidoDetalle d WHERE status_pedido=1 and d.idPedido=p.idPedido";
		}
		$listProveedoresActivos=$con->obtenerListaValores($consulta);
		if($listProveedoresActivos=="")
			$listProveedoresActivos=-1;
		$consulta="SELECT id__405_tablaDinamica as idProveedor,txtRFC,txtRazonSocial2,txtTelefono1,txtTelefono2,txtFax,txtCorreo FROM _405_tablaDinamica where 
				id__405_tablaDinamica ".$comp." in(".$listProveedoresActivos.") and idEstado=2 and ".$condWhere." order by txtRazonSocial2 limit ".$start.",".$limit;
		
		$arrProveedores=utf8_encode($con->obtenerFilasJson($consulta));
		$consulta="SELECT count(*) FROM _405_tablaDinamica where id__405_tablaDinamica ".$comp." in(".$listProveedoresActivos.") and idEstado=2  and ".$condWhere;
		
		$nReg=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nReg.'","registros":'.$arrProveedores.'}';
	}
	
	function obtenerPedidosProveedores()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];  //1 activo;0 inactivo
		$idAlmacen=$_POST["idAlmacen"];
		$condWhere=" 1=1 ";
		$statusPedido="1";
		if(isset($_POST["situacion"]))
			$statusPedido=$_POST["situacion"];
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$consulta="";
		if($idAlmacen!=-1)
		{
			
			$consulta="SELECT p.fechaRecepcion,p.folioPedido,c.nombreProducto,d.modelo,d.cantidad,m.descripcion as marca FROM 9102_PedidoCabecera p,9103_PedidoDetalle d,9101_CatalogoProducto c, _406_tablaDinamica m WHERE 
						c.idProducto=d.idProducto and 	status_pedido=".$statusPedido." and d.idPedido=p.idPedido 
						AND p.idAlmacen=".$idAlmacen." and idProveedor_ult=".$idProveedor." and m.id__406_tablaDinamica=d.idMarca and ".$condWhere;
		}
		else
		{
			$consulta="SELECT p.fechaRecepcion,p.folioPedido,c.nombreProducto,d.modelo,d.cantidad,m.descripcion as marca,d.statusPedido as situacion FROM 9102_PedidoCabecera p,9103_PedidoDetalle d,9101_CatalogoProducto c, _406_tablaDinamica m WHERE 
						c.idProducto=d.idProducto and 	status_pedido=".$statusPedido." and d.idPedido=p.idPedido AND idProveedor_ult=".$idProveedor." and m.id__406_tablaDinamica=d.idMarca and ".$condWhere;
		}
		$arrRegistros=utf8_encode($con->obtenerFilasJson($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
		
	}
	
	function eliminarProveedor()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];
		$consulta="select count(*) from 9102_PedidoCabecera where idProveedor_ult=".$idProveedor;
		$nProductos=$con->obtenerValor($consulta);
		if($nProductos>0)
		{
			echo "<br>El proveedor ya se encuentra vinculado con al menos un pedido, para cuidar la integridad de la informci&oacute;n &eacute;ste no puede ser eliminado";
			return;
		}
		$consulta="delete from _405_tablaDinamica where id__405_tablaDinamica=".$idProveedor;
		eC($consulta);
	}
	
	function obtenerProveedoresValidacion()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$situacion=$_POST["situacion"];
		$consulta="SELECT id__405_tablaDinamica as idProveedor,txtRFC,txtRazonSocial2,txtTelefono1,txtTelefono2,txtFax,txtCorreo FROM _405_tablaDinamica where idEstado=".$situacion." order by txtRazonSocial2 limit ".$start.",".$limit;
		$arrProveedores=utf8_encode($con->obtenerFilasJson($consulta));
		$consulta="SELECT count(*) FROM _405_tablaDinamica where idEstado=".$situacion."  and ".$condWhere;
		$nReg=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nReg.'","registros":'.$arrProveedores.'}';
	}
	
	function cambiarStatusProveedor()
	{
		global $con;
		$idEstado=$_POST["idEstado"];
		$idProveedor=$_POST["idProveedor"];
		$consulta="update _405_tablaDinamica set idEstado=".$idEstado." where id__405_tablaDinamica=".$idProveedor;
		eC($consulta);
		
	}
	
	function registrarSolicitudEntrega()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="select * from 525_productosAutorizados WHERE idCodigoGastoCiclo=".$obj->idProductoConcentrado;
		$fila=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO `9107_solicitudesEntrega`(departamento,idPrograma,ruta,idProducto,cantidad,idResponsableSolicitud,fechaSolicitud,idEstado,fechaLimitePrefenteEntrega,ciclo) values
						('".$fila[3]."','".$fila[10]."','".$fila[21]."','".$fila[5]."',".$obj->cantidad.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',1,'".$obj->fechaEntrega."',".$obj->ciclo.")";
		$x++;
		$consulta[$x]="INSERT INTO 9107_comentariosSolicitud(idSolicitud,numEtapa,comentario,fecha,idResponsable) VALUES((select last_insert_id()),1,'".cv($obj->comentario)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	
	function obtenerSolicitudesSolicitudes()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}

		$ciclo=$_POST["ciclo"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$arrRutas=obtenerCodigosRutas();			
		$consulta="select idSolicitudEntrega,unidad,tituloPrograma,ruta,p.nombreProducto,cantidad,u.Nombre,fechaSolicitud,fechaLimitePrefenteEntrega,c.comentario ,cvePrograma,s.idProducto,s.idPrograma,o.codigoUnidad,s.idEstado,
					s.fechaAgendaEntrega,c.fecha,responsableRecepcion
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr,9107_comentariosSolicitud c 
					where o.codigoUnidad=s.departamento and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and c.idSolicitud=s.idSolicitudEntrega
					and c.numEtapa=s.idEstado and s.departamento='".$_SESSION["codigoUnidad"]."' and s.ciclo=".$ciclo." and".$condWhere." limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);	
		$arrObj="";				
		while($fila=mysql_fetch_row($res))
		{
			$respRecepcion="";
			if($fila[17]!="")
			{
				$consulta="select Nombre from 800_usuarios where idUsuario=".$fila[17];
				$respRecepcion=$con->obtenerValor($consulta);
			}
			$obj='{"fechaUltimaOperacion":"'.$fila[16].'","respRecepcion":"'.$respRecepcion.'","fechaAgendaEntrega":"'.$fila[15].'","idEstado":"'.$fila[14].'","idSolicitudEntrega":"'.$fila[0].'","unidad":"'.$fila[1].'","tituloPrograma":"'.$fila[2].'","ruta":"'.$arrRutas[$fila[3]].'","nombreProducto":"'.$fila[4].'","cantidad":"'.$fila[5].'","Nombre":"'.$fila[6].'","fechaSolicitud":"'.$fila[7].'",
				"fechaLimitePrefenteEntrega":"'.$fila[8].'","comentarioSolicitud":"'.$fila[9].'","cvePrograma":"'.$fila[10].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		$consulta="select count(*)
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr ,9107_comentariosSolicitud c
					where  o.codigoUnidad=s.departamento and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and c.idSolicitud=s.idSolicitudEntrega
					and c.numEtapa=s.idEstado and s.departamento='".$_SESSION["codigoUnidad"]."' and s.ciclo=".$ciclo." and".$condWhere;
		$nRegistro=$con->obtenerValor($consulta);			
		echo '{"numReg":"'.$nRegistro.'","registros":['.$arrObj.']}';
					
	}
	
	function cambiarStatusSolicitudPedido()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$situacion=$_POST["situacion"];
		$comentarios=$_POST["comentarios"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9107_solicitudesEntrega set idEstado=".$situacion." where idSolicitudEntrega=".$idSolicitud;
		$x++;
		$consulta[$x]="INSERT INTO 9107_comentariosSolicitud(idSolicitud,numEtapa,comentario,fecha,idResponsable) VALUES(".$idSolicitud.",".$situacion.",'".cv($comentarios)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		$x++;
		if($situacion==5)
		{
			$query="SELECT * FROM 9107_solicitudesEntrega WHERE idSolicitudEntrega=".$idSolicitud;
			$filaSol=$con->obtenerPrimeraFila($query);
			if($filaSol[8]==2)
			{
				$query="select objetoGasto from 9101_CatalogoProducto WHERE idProducto=".$filaSol[4];
				$partida=$con->obtenerValor($query);
				$consulta[$x]="INSERT INTO 9302_existenciaAlmacen(idProducto,codigoUnidad,idPrograma,partida,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,ruta) 
							values(".$filaSol[4].",'".$filaSol[1]."',".$filaSol[2].",'".$partida."',".$filaSol[5].",'".date("Y-m-d")."',1,".$_SESSION["idUsr"].",3,'".$filaSol[3]."')";
				$x++;
				
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function agendarEntregaSolicitud()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$comentarios=$_POST["comentarios"];
		$fechaEntrega=$_POST["fechaEntrega"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9107_solicitudesEntrega set idEstado=2,fechaAgendaEntrega='".$fechaEntrega."' where idSolicitudEntrega=".$idSolicitud;
		$x++;
		$consulta[$x]="INSERT INTO 9107_comentariosSolicitud(idSolicitud,numEtapa,comentario,fecha,idResponsable) VALUES(".$idSolicitud.",2,'".cv($comentarios)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		$x++;
		
		$query="SELECT * FROM 9107_solicitudesEntrega WHERE idSolicitudEntrega=".$idSolicitud;
		$filaSol=$con->obtenerPrimeraFila($query);
		
		$query="select objetoGasto from 9101_CatalogoProducto WHERE idProducto=".$filaSol[4];
		$partida=$con->obtenerValor($query);
		$consulta[$x]="INSERT INTO 9302_existenciaAlmacen(idProducto,codigoUnidad,idPrograma,partida,cantidad,fechaMovimiento,operacion,responsable,tipoMovimiento,ruta) 
					values(".$filaSol[4].",'".$filaSol[1]."',".$filaSol[2].",'".$partida."',".$filaSol[5].",'".date("Y-m-d")."',-1,".$_SESSION["idUsr"].",2,'".$filaSol[3]."')";
		$x++;
			
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
		
	}
	
	function obtenerSolicitudesAgendadasEntrega()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}

		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$arrRutas=obtenerCodigosRutas();			
		$consulta="select idSolicitudEntrega,unidad,tituloPrograma,ruta,p.nombreProducto,cantidad,u.Nombre,fechaSolicitud,fechaLimitePrefenteEntrega,c.comentario ,cvePrograma,s.idProducto,s.idPrograma,o.codigoUnidad,s.fechaAgendaEntrega
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr,9107_comentariosSolicitud c 
					where idEstado in (2,6) and p.idAlmacen=".$idAlmacen." and o.codigoUnidad=s.departamento and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and c.idSolicitud=s.idSolicitudEntrega
					and c.numEtapa=s.idEstado and ".$condWhere." limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);	
		$arrObj="";				
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"fechaAgendaEntrega":"'.$fila[14].'","idSolicitudEntrega":"'.$fila[0].'","unidad":"'.$fila[1].'","tituloPrograma":"'.$fila[2].'","ruta":"'.$arrRutas[$fila[3]].'","nombreProducto":"'.$fila[4].'","cantidad":"'.$fila[5].'","Nombre":"'.$fila[6].'","fechaSolicitud":"'.$fila[7].'",
				"fechaLimitePrefenteEntrega":"'.$fila[8].'","comentarioSolicitud":"'.$fila[9].'","cvePrograma":"'.$fila[10].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		$consulta="select count(*)
					from 9107_solicitudesEntrega s,817_organigrama o,9101_CatalogoProducto p,800_usuarios u ,517_programas pr 
					where idEstado=1 and p.idAlmacen=".$idAlmacen." and o.codigoUnidad=s.departamento 
					and p.idProducto=s.idProducto and u.idUsuario=s.idResponsableSolicitud and pr.idPrograma=s.idPrograma and ".$condWhere;
		$nRegistro=$con->obtenerValor($consulta);			
		echo '{"numReg":"'.$nRegistro.'","registros":['.$arrObj.']}';
					
	}
	
	
	function cambiarEntregaProducto()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$comentarios=$_POST["comentarios"];
		$fechaEntrega=$_POST["fechaEntrega"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9107_solicitudesEntrega set idEstado=6,fechaAgendaEntrega='".$fechaEntrega."' where idSolicitudEntrega=".$idSolicitud;
		$x++;
		$consulta[$x]="INSERT INTO 9107_comentariosSolicitud(idSolicitud,numEtapa,comentario,fecha,idResponsable) VALUES(".$idSolicitud.",6,'".cv($comentarios)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarEntregaProducto()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$comentarios=$_POST["comentarios"];
		$fechaEntrega=$_POST["fechaEntrega"];
		$respRecepcion=$_POST["responsable"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9107_solicitudesEntrega set idEstado=4,fechaEntregado='".$fechaEntrega."',responsableRecepcion=".$respRecepcion." where idSolicitudEntrega=".$idSolicitud;
		$x++;
		$consulta[$x]="INSERT INTO 9107_comentariosSolicitud(idSolicitud,numEtapa,comentario,fecha,idResponsable) VALUES(".$idSolicitud.",4,'".cv($comentarios)."','".$fechaEntrega."',".$_SESSION["idUsr"].")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerHistorialTraslado()
	{
		global $con;
		$idInventario=$_POST["idInventario"];	
		$consulta="SELECT idHistorialInventario as idMovimiento,idResponsable,u.Nombre as titularAsignacion,fechaMovimiento AS fechaAsignacion,nombreArea as ubicacion, ubicacion as codigoUbicacion, comentarios,o.codigoUnidad,o.unidad as departamento 
					FROM 9308_historialTraslados h,800_usuarios u,9309_ubicacionesFisicas f,801_adscripcion a,817_organigrama o WHERE f.codigoControl=h.ubicacion
					AND h.idResponsable=u.idUsuario AND h.idInventario=".$idInventario." and a.idUsuario=u.idUsuario and o.codigoUnidad=a.codigoUnidad order by fechaMovimiento desc";
		$arrRegistros=$con->obtenerFilasJson($consulta);			
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
							
	}
	
	function obteneSolicitudesPedidos()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$condWhere." and fechaCreacion>='".$_POST["fechaInicio"]."' and fechaCreacion<='".$_POST["fechaFin"]."'";
		$consulta="SELECT DATE_FORMAT(s.fechaCreacion,'%Y-%m-%d') as 'fechaCreacion',txtFolioPedido,p.txtNombreProducto,d.cantidad,unidad,u.Nombre,
					(IF((SELECT SUM(cantidad*tipoOperacion) FROM 9302_existenciasAlmacenProduccion WHERE idProducto=p.id__605_tablaDinamica and idFormulario=605)IS NULL,0,(SELECT SUM(cantidad*tipoOperacion) FROM 9302_existenciasAlmacenProduccion WHERE idProducto=p.id__605_tablaDinamica and idFormulario=605))) AS existenciaAlmacen,s.id__894_tablaDinamica as idSolicitudEntrega,
					p.id__605_tablaDinamica as idProducto					 
		 FROM _894_tablaDinamica s,_894_dtgProducto d,_605_tablaDinamica p,817_organigrama o,800_usuarios u WHERE 
					d.idReferencia=s.id__894_tablaDinamica AND d.producto=p.id__605_tablaDinamica AND s.idEstado=1 AND s.codigoUnidad=o.codigoUnidad and u.idUsuario=s.responsable and ".$condWhere;
		$arrSolicitudes=$con->obtenerFilasJson($consulta);	
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrSolicitudes).'}';
	}
	
	function obtenerSolicitudesPedidosCumplir()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$productosRequeridos=array();
		$consulta="SELECT d.producto,cantidad FROM _894_tablaDinamica s,_894_dtgProducto d WHERE d.idReferencia=s.id__894_tablaDinamica AND s.idEstado=1 and ".$condWhere;
		 $res=$con->obtenerFilas($consulta);
		 while($fila=mysql_fetch_row($res))
		 {
			 if(!isset($productosRequeridos[$fila[0]]))
				 $productosRequeridos[$fila[0]]	=$fila[1];
			else
				$productosRequeridos[$fila[0]]+=$fila[1];
		 }
		 
		 $arrProductosNoExistencia=array();
		 foreach($productosRequeridos as $p=>$cantidad)
		 {
			 $consulta="SELECT SUM(cantidad*operacion) FROM 9302_existenciaAlmacenProduccion WHERE idProducto=".$p." AND complementario1=1";
			 $existencia=$con->obtenerValor($consulta);
			 $diferencia=$cantidad-$existencia;
			 if($diferencia>0)
			 {
				 $arrProductosNoExistencia[$p]=$diferencia;
			 }
			 
		 }
		 $arrProductoFinal=array();
		 
		 
		 foreach($arrProductosNoExistencia as $p=>$cantidad)
		 {
			$consulta="SELECT producto,cantidadRequerida FROM _605_tablaDinamica p,_605_costoProducto d WHERE d.idReferencia=p.id__605_tablaDinamica AND p.id__605_tablaDinamica=".$p;
			$res=$con->obtenerFilas($consulta);	 
			while($fila=mysql_fetch_row($res))
			{
				if(isset($arrProductoFinal[$fila[0]]))
					$arrProductoFinal[$fila[0]]+=$fila[1]*$cantidad;
				else
					$arrProductoFinal[$fila[0]]=$fila[1]*$cantidad;
			}
		 }
		 $arrSolicitudes="";	
		 $ct=0;
		foreach($arrProductoFinal as $p=>$cantidad) 
		{
			$consulta="select medicamento from 1000_productosMedicamentos where idProducto=".$p;
			$nProducto=$con->obtenerValor($consulta);
			$obj='{"idProducto":"'.$p.'","producto":"'.cv($nProducto).'","cantidad":"'.ceil($cantidad).'"}';
			if($arrSolicitudes=="")
				$arrSolicitudes=$obj;
			else
				$arrSolicitudes.=",".$obj;
			$ct++;
				
		}
		echo '{"numReg":"'.$ct.'","registros":['.utf8_encode($arrSolicitudes).']}';					
	}
	
	function solicitarProductoAlmacen()
	{
		global $con;
		$valIva=0.16;
		
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$idProveedor=1367;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->productos as $p)
		{

			$query="select * from 9101_CatalogoProducto WHERE idProducto=".$p->idProducto;
			$fila=$con->obtenerPrimeraFila($query);
			$idAlmacen=$fila[6];
			$consulta[$x]="insert into 9102_PedidoCabecera(fechaPedido,status_pedido,idAlmacen,fechaRecepcion,mes,idProveedor_ult) 
						values('".date("Y-m-d")."',1,".$idAlmacen.",'".$obj->fechaEntrega."',".date("m",strtotime($obj->fechaEntrega)).",".$idProveedor.")";
			$x++;
			$costoUnitario=$fila[18];
			$query="SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=".$p->idProducto." ORDER BY fechaPedido DESC LIMIT 0,1";
			$cUnitario=$con->obtenerValor($query);
			if($cUnitario!="")
				$costoUnitario=$cUnitario;
			
			$query="SELECT gravable FROM 507_objetosGasto WHERE codigoControl='".$fila[7]."'";
			$gravable=$con->obtenerValor($query);
			$iva=$valIva;
			if($gravable==0)
				$iva=0;
				
			$consulta[$x]="set @idPedido:=(select last_insert_id())";
			$x++;
			$consulta[$x]="update 9102_PedidoCabecera set folioPedido=@idPedido where idPedido=@idPedido";
			$x++;
			$consulta[$x]="INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,modelo,cantidad,costoUnitario,iva,statusPedido,fechaPedido,situacion)
						VALUES(@idPedido,".$p->idProducto.",0,0,".ceil($p->cantidad).",".$costoUnitario.",".(($costoUnitario*ceil($p->cantidad))*$iva).",1,'".date("Y-m-d")."',0)";
			$x++;					
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function asignarResponsableInventario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="update 9308_historialTraslados set situacion=0 where idInventario=".$obj->idInventario; 
		$x++;
		$consulta[$x]="INSERT INTO 9308_historialTraslados(idInventario,idResponsable,fechaMovimiento,comentarios,ubicacion,situacion) 
						VALUES(".$obj->idInventario.",".$obj->responsable.",'".$obj->fechaAsignacion."','".cv($obj->comentarios)."','".$obj->ubicacion."',1)";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerInventarioPorConcepto()
	{
		global $con;
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$condWhere=" 1=1 ";
		$accion=$_POST["accion"];
		$valor=$_POST["valor"];
		switch($accion)
		{
			case 1:
				$consulta="SELECT idInventario FROM 9308_historialTraslados where idResponsable=".$valor." AND situacion=1";
				$listProductos=$con->obtenerListaValores($consulta);
				if($listProductos=="")
					$listProductos="-1";
				
			break;
			case 2:
				$consulta="SELECT idInventario FROM 9308_historialTraslados where ubicacion='".$valor."' AND situacion=1";
				$listProductos=$con->obtenerListaValores($consulta);
				if($listProductos=="")
					$listProductos="-1";
			break;
			case 3:
				$consulta="SELECT idInventario FROM 9308_historialTraslados t,801_adscripcion a where a.idUsuario=t.idResponsable and  a.codigoUnidad='".$valor."' AND t.situacion=1";
				$listProductos=$con->obtenerListaValores($consulta);
				if($listProductos=="")
					$listProductos="-1";
			break;
		}
		
		$consulta="select idInventario,noInv,claveCABMS,nombreProducto,noFactura,precioCompra,idProveedor,
		DATE_FORMAT(fechaCompra,'%d/%m/%Y') AS fechaCompra,DATE_FORMAT(fechaCompra,'%Y') AS anioInversion,
		codigoU,idResponsable,idDetallePedido,idFormulario, idTablaDinamica,idAlmacen 
		from 9307_inventario where idInventario in(".$listProductos.")  limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$consulta="select count(*)	from 9307_inventario where idInventario in(".$listProductos.")";
		
		$numReg=$con->obtenerValor($consulta);
		$arrInv="";
		while($fila=mysql_fetch_row($res))
	    {
			$idProveedor=$fila[6];
			$cod_unidad=$fila[9];
			$idUsuario=$fila[10];
			$consulta2="select txtRazonSocial2 from _405_tablaDinamica where id__405_tablaDinamica='".$idProveedor."'";
			$razonSocial=$con->obtenerValor($consulta2);
			$obj='{"idInventario":"'.$fila[0].'","noInv":"'.$fila[1].'","claveCABMS":"'.$fila[2].'","nombreProducto":"'.cv($fila[3]).'",
			"noFactura":"'.$fila[4].'","precioCompra":"'.$fila[5].'","txtRazonSocial2":"'.$razonSocial.'","idProveedor":"'.$fila[6].'",
			"fechaCompra":"'.$fila[7].'","anioInversion":"'.$fila[8].'",
			"idDetallePedido":"'.$fila[11].'","idFormulario":"'.$fila[12].'",
			"idTablaDinamica":"'.$fila[13].'","idAlmacen":"'.$fila[14].'"}';	
			if($arrInv=="")
				$arrInv=$obj;
			else
				$arrInv.=",".$obj;
			
		}
		$obj='{"numReg":"'.$numReg.'","registros":['.$arrInv.']}';
		echo $obj;
	}
	
	function obtenerProductoEsperaInventario()
	{
		global $con;
		$consulta="	SELECT idPedidoDetalle,p.noFactura,c.nombreProducto,m.descripcion AS 'marca',d.modelo,costoUnitario,iva FROM 9103_PedidoDetalle d,9102_PedidoCabecera p,9101_CatalogoProducto c, _406_tablaDinamica m 
							WHERE p.idPedido=d.idPedido AND c.idProducto=d.idProducto AND d.situacion=1 AND m.id__406_tablaDinamica=d.idMarca";
		$arrInv=$con->obtenerFilasJson($consulta);		
		$obj='{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrInv).'}';
		echo $obj;
	}
	
	function asignarFolioInventario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		if($obj->responsable=="")
			$obj->responsable="NULL";
		$consulta[$x]="begin";
		$x++;
		$query="SELECT idPedidoDetalle,p.noFactura,c.nombreProducto,m.descripcion AS 'marca',costoUnitario,iva,idProveedor_ult,p.fechaPedido FROM 9103_PedidoDetalle d,9102_PedidoCabecera p,9101_CatalogoProducto c, _406_tablaDinamica m 
							WHERE p.idPedido=d.idPedido AND c.idProducto=d.idProducto AND d.situacion=1 AND m.id__406_tablaDinamica=d.idMarca AND idPedidoDetalle=".$obj->idPedidoDetalle;
		$fila=$con->obtenerPrimeraFila($query);							
		
		$consulta[$x]="INSERT INTO 9307_inventario(noInv,fechaCompra,estadoDepreciacion,precioCompra,nombreProducto,noFactura,idProveedor,anioInversion,idResponsable)
						VALUES(".$obj->noInventario.",'".$fila[7]."',1,".($fila[4]+$fila[5]).",'".cv($fila[2])."','".$fila[1]."',".$fila[6].",'".date("Y",strtotime($fila[7]))."',".$_SESSION["idUsr"].")";
		
		$x++;
		$consulta[$x]="INSERT INTO 9308_historialTraslados(idInventario,idResponsable,fechaMovimiento,comentarios,ubicacion,situacion) 
						VALUES((select last_insert_id()),".$obj->responsable.",'".date("Y-m-d")."','".cv($obj->comentarios)."','".$obj->ubicacion."',1)";
		$x++;
		$consulta[$x]="update 9103_PedidoDetalle set situacion=0 where idPedidoDetalle=".$obj->idPedidoDetalle;
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerCategoriasObjetoGasto()
	{
		global $con;
		$objetoGasto=$_POST["objetoGasto"];
		$consulta="SELECT idCategoria,cveCategoria,nombre as nombreCategoria,descripcion FROM 9030_categoriasObjetoGasto WHERE objetoGasto='".$objetoGasto."'
					ORDER BY nombre";
		$arrReg=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function guardarCategoriaObjetoGasto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idCategoria==-1)
			$consulta="INSERT INTO 9030_categoriasObjetoGasto(cveCategoria,nombre,descripcion,idResp,fechaCreacion,objetoGasto)
						VALUES('".cv($obj->cveCategoria)."','".cv($obj->nombreCategoria)."','".cv($obj->descripcion)."',".$_SESSION["idUsr"].",'".date("Y-m-d")."',
						'".$obj->objetoGasto."')";
		else
			$consulta="update 9030_categoriasObjetoGasto set cveCategoria='".cv($obj->cveCategoria)."',nombre='".cv($obj->nombreCategoria)."',
						descripcion='".cv($obj->descripcion)."',idRespModif=".$_SESSION["idUsr"].",fechaModificacion='".date("Y-m-d")."' where idCategoria=".$obj->idCategoria;
		eC($consulta);						
						
	}
	
	function removerCategoriaObjetoGasto()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];

		$res=esEliminable("9101_CatalogoProducto","idProducto",$idCategoria);
		if($res=="")
		{
			eliminarElementoTabla("9030_categoriasObjetoGasto","idCategoria",$idCategoria);
		}
		else
			return $res;
	}
	
	function obtenerCategoriasDisponiblesOG()
	{
		global $con;
		$objetoGasto=$_POST["objetoGasto"];
		$consulta="SELECT idCategoria,concat('[',cveCategoria,'] ',nombre) as nombreCategoria,descripcion FROM 9030_categoriasObjetoGasto WHERE objetoGasto='".$objetoGasto."'
					and idCategoria not in (SELECT idCategoria FROM 9030_almacenVSCategoria) ORDER BY nombre";
		$arrReg=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrReg;
	}
	
	function asociarCategoriaAlmacen()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT a.cveAlmacen FROM 9030_almacenes a WHERE a.idAlmacen=".$obj->idAlmacen;
		$cveAlmacen=$con->obtenerValor($consulta);
		if($cveAlmacen=="")
			$cveAlmacen="-1";
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO 9030_almacenVSCategoria(idAlmacen,idCategoria) VALUES(".$obj->idAlmacen.",".$obj->idCategoria.")";
		$x++;
		$query[$x]="UPDATE 9101_CatalogoProducto SET idAlmacen='".$cveAlmacen."' WHERE idCategoria=".$obj->idCategoria;
		$x++;
		
		$query[$x]="commit";
		$x++;
		eC($consulta);
	}
	
	function obtenerCategoriasObjetoGastoAlmacen()
	{
		global $con;
		$objetoGasto=$_POST["objetoGasto"];
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="SELECT al.idCategoria,CONCAT('[',cveCategoria,'] ',nombre) FROM 9030_almacenVSCategoria al,9030_categoriasObjetoGasto c 
					WHERE c.idCategoria=al.idCategoria AND al.idAlmacen=".$idAlmacen." AND c.objetoGasto='".$objetoGasto."' order by nombre";
		$arrReg=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrReg;	
	}
	
	function guardarProgramacionReceta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idPlaneacion==-1)
		{
			$consulta="INSERT INTO 9140_planeacionProduccion(idReceta,lunes,martes,miercoles,jueves,viernes,sabado,domingo,
						cantidadTotal,costoUnitario,montoTotal,horarioMenu,ciclo,semana,tipoProduccion) values(".$obj->idReceta.",".$obj->lunes.",".$obj->martes.",".$obj->miercoles.",".
						$obj->jueves.",".$obj->viernes.",".$obj->sabado.",".$obj->domingo.",".$obj->cantidadTotal.",".$obj->costoUnitario.",".$obj->montoTotal.",".
						$obj->horarioMenu.",".$obj->ciclo.",".$obj->semana.",".$obj->tipoProduccion.")";
		}
		else
		{
			$consulta="update 9140_planeacionProduccion set idReceta=".$obj->idReceta.",lunes=".$obj->lunes.",martes=".$obj->martes.",miercoles=".$obj->miercoles.
						",jueves=".$obj->jueves.",viernes=".$obj->viernes.",sabado=".$obj->sabado.",domingo=".$obj->domingo.",cantidadTotal=".$obj->cantidadTotal.",
						costoUnitario=".$obj->costoUnitario.",montoTotal=".$obj->montoTotal.",horarioMenu=".$obj->horarioMenu." where idPlaneacion=".$obj->idPlaneacion;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idPlaneacion==-1)
				$obj->idPlaneacion=$con->obtenerUltimoId();
				
		}
		echo "1|".$obj->idPlaneacion;
	}
	
	function obtenerProgramacionReceta()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$semana=$_POST["semana"];
		$tipoProduccion=$_POST["tipoProduccion"];

		$consulta="SELECT * FROM 9140_planeacionProduccion WHERE ciclo=".$ciclo." AND semana=".$semana." and tipoProduccion=".$tipoProduccion;
		$arrObj=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrObj.'}';
		
	}
	
	function eliminarPlaneacionReceta()
	{
		global $con;
		$idPlaneacion=$_POST["idPlaneacion"];
		$consulta="DELETE FROM 9140_planeacionProduccion WHERE idPlaneacion=".$idPlaneacion;
		eC($consulta);
	}
	
	function obtenerSemanasPlaneadas()
	{
		global $con;
		$tipoProduccion=$_POST["tipoProduccion"];
		$ciclo=$_POST["ciclo"];
		$consulta="	SELECT  s.idSemana,descripcion as lblSemana,(SELECT SUM(montoTotal) FROM 9140_planeacionProduccion WHERE semana=s.idSemana AND ciclo=".$ciclo." 
					AND tipoProduccion=".$tipoProduccion.")	 as montoTotal FROM 9141_semanasProduccion p,9355_semanaReceta s 
					WHERE s.idSemana=p.idSemana AND tipoProduccion=".$tipoProduccion." AND ciclo=".$ciclo." ORDER BY numSemana";
		$arrSemanas=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrSemanas.'}';
	
	}
	
	function eliminarPlenacionSemanal()
	{
		global $con;
		$idSemana=$_POST["idSemana"];
		$ciclo=$_POST["ciclo"];
		$tipoProduccion=$_POST["tipoProduccion"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9141_semanasProduccion where idSemana=".$idSemana." and ciclo=".$ciclo." and tipoProduccion=".$tipoProduccion;
		$x++;
		$consulta[$x]="delete from 9140_planeacionProduccion where semana=".$idSemana." and ciclo=".$ciclo." and tipoProduccion=".$tipoProduccion;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarPlaneacionSemanal()
	{
		global $con;
		$idSemana=$_POST["idSemana"];
		$ciclo=$_POST["ciclo"];
		$tipoProduccion=$_POST["tipoProduccion"];
		$consulta="insert into 9141_semanasProduccion(idSemana,ciclo,tipoProduccion) values(".$idSemana.",".$ciclo.",".$tipoProduccion.")";
		eC($consulta);
	}
	
	function obtenerSemanasDisponiblesPlaneacionSemanal()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$tipoProduccion=$_POST["tipoProduccion"];
		$consulta="SELECT idSemana,descripcion FROM 9355_semanaReceta WHERE idSemana NOT IN (SELECT idSemana FROM 9141_semanasProduccion
				WHERE ciclo=".$ciclo." AND tipoProduccion=".$tipoProduccion.") ORDER BY numSemana";
		$arrOpciones=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrOpciones;
	}
	
	function obtenerPlaneacionRecetasSemana()
	{
		global $con;
		$idSemana=$_POST["idSemana"];
		$ciclo=$_POST["ciclo"];
		$tipoProduccion=$_POST["tipoProduccion"];
		$consulta="SELECT * FROM 9355_semanaReceta WHERE anio=".$ciclo." AND idSemana=".$idSemana;
		$fila=$con->obtenerPrimeraFila($consulta);
		$fechaInicio=$fila[4];
		$arrDias=array();
		$arrDias[0]["dia"]="lunes";
		$arrDias[0]["diaEt"]="Lunes";
		$arrDias[1]["dia"]="martes";
		$arrDias[1]["diaEt"]="Martes";
		$arrDias[2]["dia"]="miercoles";
		$arrDias[2]["diaEt"]="Miércoles";
		$arrDias[3]["dia"]="jueves";
		$arrDias[3]["diaEt"]="Jueves";
		$arrDias[4]["dia"]="viernes";
		$arrDias[4]["diaEt"]="Viernes";
		$arrDias[5]["dia"]="sabado";
		$arrDias[5]["diaEt"]="Sábado";
		$arrDias[6]["dia"]="domingo";
		$arrDias[6]["diaEt"]="Domingo";
		
		$arrDias[0]["fecha"]=date("d/m/Y",strtotime($fechaInicio));
		for($x=1;$x<7;$x++)
		{
			
			$arrDias[$x]["fecha"]=date("d/m/Y",strtotime("+".$x." days",strtotime($fechaInicio)));
		}
		$arrProduccion=array();
		foreach($arrDias as $id=>$dia)
		{
			$consulta="SELECT idReceta,".$dia["dia"]." FROM 9140_planeacionProduccion WHERE  ciclo=".$ciclo." AND semana=".$idSemana." and tipoProduccion in (".$tipoProduccion.")";
			$res=$con->obtenerFilas($consulta);
			while($fSemana=mysql_fetch_row($res))
			{
				if(!isset($arrProduccion[$dia."_".$fSemana[0]]))
				{
					$arrProduccion[$id."_".$fSemana[0]]=array();
					$arrProduccion[$id."_".$fSemana[0]]["cantidad"]=0;
				}
				$arrProduccion[$id."_".$fSemana[0]]["cantidad"]+=$fSemana[1];
			}
		}
		$arrRecetas="";
		$ct=0;
		$idFormulario="";
		foreach($arrProduccion as $datos=>$resto)
		{

			if($resto["cantidad"]>0)
			{
				$arrDatos=explode("_",$datos);
				if(($tipoProduccion!=3)&&($tipoProduccion!=4))
				{
					$consulta="SELECT idracion FROM _609_tablaDinamica where id__609_tablaDinamica=".$arrDatos[1];
					$idFormulario=609;
				}
				else
				{
					if($tipoProduccion==3)
					{
						$consulta="SELECT txtNombreProducto,costoTotalProducto FROM _605_tablaDinamica where id__605_tablaDinamica=".$arrDatos[1];
						$idFormulario=605;
					}

				}
				$lblReceta=$con->obtenerValor($consulta);
				$situacion="0";
				$comentarios="";
				$fechaMysql=cambiaraFechaMysql($arrDias[$arrDatos[0]]["fecha"]);
				$consulta="SELECT * FROM 9142_situacionesProduccion WHERE 
							fechaPlaneacion='".$fechaMysql."' 
							AND idProducto=".$arrDatos[1]." AND idFormulario=".$idFormulario;
				
				$fila=$con->obtenerPrimeraFila($consulta);
				if(!$fila)
				{
					if(strtotime($fechaMysql)<strtotime(date("Y-m-d")))
						$situacion=2;	
				}
				else
				{
					$situacion=	$fila[4];
					$comentarios=$fila[5];
				}
				
				$objReceta='{"comentarios":"'.$comentarios.'","situacion":"'.$situacion.'","fechaMenu":"'.$arrDias[$arrDatos[0]]["diaEt"]." ".$arrDias[$arrDatos[0]]["fecha"].'","idReceta":"'.$arrDatos[1].'","receta":"'.$lblReceta.'","cantidad":"'.$resto["cantidad"].'"}';
				if($arrRecetas=='')
					$arrRecetas=$objReceta;
				else
					$arrRecetas.=",".$objReceta;
				$ct++;
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrRecetas.']}';
	}
	
	function obtenerInsumosRequeridos()
	{
		global $con;
		$tipoProduccion=$_POST["tipoProduccion"];
		$arrInsumos=json_decode($_POST["arrInsumos"]);
		$arrProductos=array();
		$consulta="";
		foreach($arrInsumos as $receta)
		{
			if(($tipoProduccion!=3)&&($tipoProduccion!=4))
			{
				$consulta="SELECT idVivire,idcantidadre FROM _609_proyeccioncostoproduccion p,_609_tablaDinamica t 
							WHERE p.idReferencia=t.id__609_tablaDinamica AND t.id__609_tablaDinamica=".$receta->idReceta;
			}
			else
			{
				switch($tipoProduccion)
				{
					case 3:
						$consulta="SELECT producto,cantidadRequerida FROM _605_costoProducto p,_605_tablaDinamica t 
							WHERE p.idReferencia=t.id__605_tablaDinamica AND t.id__605_tablaDinamica=".$receta->idReceta;
					break;
				}
			}
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				if(!isset($arrProductos[$fila[0]]))
					$arrProductos[$fila[0]]=0;
				$arrProductos[$fila[0]]+=($fila[1]*$receta->cantidad);
			}
		}
		$arrInsumosReq="";
		$ct=0;
		foreach($arrProductos as $idProducto=>$p)
		{
			$consulta="SELECT nombreProducto,idAlmacen FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
			$filaProd=$con->obtenerPrimeraFila($consulta);
			$nProducto=$filaProd[0];
			$idAlmacen=$filaProd[1];
			$objInsumo='{"idProducto":"'.$idProducto.'","nombreProducto":"'.cv($nProducto).'","cantidad":"'.$p.'","existencia":"'.obtenerExistenciaAlmacenProductoE($idProducto,$idAlmacen).'"}';
			if($arrInsumosReq=="")
				$arrInsumosReq=$objInsumo;
			else
				$arrInsumosReq.=",".$objInsumo;
			$ct++;
		}
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrInsumosReq.']}';
	}
	
	function registrarBajaProductoAlmacenProduccion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="INSERT INTO 9302_existenciasAlmacenProduccion(idProducto,idFormulario,cantidad,tipoOperacion,complementario,complementario2,fechaOperacion,
				idResponsableOperacion,comentarios) VALUES(".$obj->idProducto.",".$obj->idFormulario.",".$obj->cantidad.",-1,'-1','".$obj->idMotivo."','".date("Y-m-d").
				"',".$_SESSION["idUsr"].",'".cv($obj->comentarios)."')";
		eC($consulta);				
	}
	
	function registrarProductosProducidos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idFormulario=$obj->idFormulario;
		foreach($obj->arrRecetas as $receta)
		{
			$arrFecha=explode(" ",$receta->fecha);
			$fechaPlan=cambiaraFechaMysql($arrFecha[1]);
			$consulta[$x]="INSERT INTO 9142_situacionesProduccion(idProducto,idFormulario,fechaPlaneacion,situacion) VALUES(".$receta->idReceta.",".$idFormulario.",'".$fechaPlan."',1)";
			$x++;
			$consulta[$x]="INSERT INTO 9302_existenciasAlmacenProduccion(idProducto,idFormulario,cantidad,tipoOperacion,idResponsableOperacion,fechaOperacion)
							values(".$receta->idReceta.",".$idFormulario.",".$receta->cantidad.",1,".$_SESSION["idUsr"].",'".date("Y-m-d")."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarProductosCancelados()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idFormulario=$obj->idFormulario;
		foreach($obj->arrRecetas as $receta)
		{
			$arrFecha=explode(" ",$receta->fecha);
			$fechaPlan=cambiaraFechaMysql($arrFecha[1]);
			$consulta[$x]="INSERT INTO 9142_situacionesProduccion(idProducto,idFormulario,fechaPlaneacion,situacion,comentarios) VALUES(".$receta->idReceta.",".$idFormulario.",'".$fechaPlan."',3,'".cv($obj->motivo)."')";
			$x++;
			
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarSalidaProductoProducidos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idFormulario=$obj->idFormulario;
		$consulta[$x]="INSERT INTO 9302_existenciasAlmacenProduccion(idProducto,idFormulario,cantidad,tipoOperacion,idResponsableOperacion,fechaOperacion,complementario,complementario2)
						values(".$obj->idProducto.",".$idFormulario.",".$obj->cantidad.",-1,".$_SESSION["idUsr"].",'".date("Y-m-d")."','0',".$obj->idSolicitud.")";
		$x++;
		$consulta[$x]="UPDATE _894_tablaDinamica SET idEstado=2 WHERE id__894_tablaDinamica=".$obj->idSolicitud;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarConfiguracionAsientoMovimientoAlmacen()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idAfectacion==-1)
		{
			$consulta="INSERT INTO 6905_afectacionMovimientoAlmacen(idPerfilMovimiento,tiempoMovimiento,tipoAfectacion,idFuncionAplicacion)
						VALUES(".$obj->idPerfilMovimiento.",'".$obj->tiempoAfectacion."',".$obj->tipoAfectacion.",".$obj->idFuncionAplicacion.")";
		}
		else
		{
			$consulta="update 6905_afectacionMovimientoAlmacen set tiempoMovimiento='".$obj->tiempoAfectacion."',tipoAfectacion=".
			$obj->tipoAfectacion.",idFuncionAplicacion=".$obj->idFuncionAplicacion." where idAfectacion=".$obj->idAfectacion;
		}
		eC($consulta);
	}
	
	function obtenerDatosConceptos()
	{
		global $con;
		$idPerfilMovimiento=$_POST["idPerfilMovimiento"];
		$tGrid=$_POST["tGrid"];
		switch($tGrid)
		{
			
			case 2:
				$consulta="SELECT idAfectacion as idRegistro,nombreTiempo AS tiempoMovimiento,tipoAfectacion,idFuncionAplicacion,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=t.idFuncionAplicacion)AS funcionEjecucion,p.idTiempoMovimiento 
						FROM 6905_afectacionMovimientoAlmacen t,6902_tiempoMovimientosAlmacen p WHERE 
						idPerfilMovimiento=".$idPerfilMovimiento." AND  p.idTiempoMovimiento=t.tiempoMovimiento";
			break;
			
		}
		$arrConsulta=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrConsulta).'}';
	}
	
	function removerConfiguracionContableMovimiento()
	{
		global $con;
		$idAfectacion=$_POST["idAfectacion"];
		$consulta="DELETE FROM 6905_afectacionMovimientoAlmacen WHERE idAfectacion=".$idAfectacion;
		eC($consulta);
	}
	
	function obtenerProductosPendientesEntregaCiclo()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$consulta="SELECT distinct concat(t.rfc1,'-',t.rfc2,'-',t.rfc3) as rfc,numEntrega,t.nombreProveedor,p.idPedido,folioPedido,fechaRecepcion,DATEDIFF(fechaRecepcion,curdate()) as diferencia,condicionPago,comentarios FROM 9102_PedidoCabecera p,6912_proveedores t,
				9103_PedidoDetalle d,6901_catalogoProductos c WHERE   p.status_pedido=1 AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto and p.idAlmacen=".$idAlmacen." and ".$condWhere." limit ".$start.",".$limit;

		$arrProductos=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct t.nombreProveedor,p.idPedido,folioPedido,fechaRecepcion,DATEDIFF(fechaRecepcion,curdate()) as diferencia FROM 9102_PedidoCabecera p,6912_proveedores t,
				9103_PedidoDetalle d,6901_catalogoProductos c WHERE   p.status_pedido=1 AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto and p.idAlmacen=".$idAlmacen." and ".$condWhere;
		$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"numReg":"'.$nFilas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	
	function obtenerDetallePedidoCiclo()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$consulta="SELECT p.idProducto,pro.nombreProducto,pro.cveProducto,subtotal,total,
					(select nombreMarca from 6910_catalogoMarcas where idMarca=p.idMarca) AS marca,
					modelo,cantidad,costoUnitario,iva,(select nombreContenedor from 6907_catalogoContenedores where idContenedor=p.idContenedor) AS contenedor,
					(select nombreUnidadMedida from 6908_catalogoUnidadesMedida where idUnidadMedida=p.idUnidadMedida) AS unidadMedida,
					(select nombrePresentacion from 6909_catalogoPresentaciones where idPresentacion=p.idPresentacion) AS presentacion
					FROM 9103_PedidoDetalle p,6901_catalogoProductos pro WHERE 
					p.idPedido=".$idPedido." aND pro.idProducto=p.idProducto";
		$arrRegistros=$con->obtenerFilasJson($consulta);					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerProductosRecibidosCiclo()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$consulta="SELECT distinct concat(t.rfc1,'-',t.rfc2,'-',t.rfc3) as rfc,numEntrega,t.nombreProveedor,p.idPedido,folioPedido,fechaRecibido,e.fecha_entrada,e.num_Factura,u.Nombre,condicionPago,comentarios 
					FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9104_EntradaAlmacen e,800_usuarios u WHERE   
					p.status_pedido=0 AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
				and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and u.idUsuario=e.idUsuarioRecibio and ".$condWhere." limit ".$start.",".$limit;

		$arrProductos=$con->obtenerFilasJson($consulta);
		$consulta="SELECT distinct t.nombreProveedor,p.idPedido,folioPedido,fechaRecibido,e.fecha_entrada,e.num_Factura,u.Nombre 
					FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9104_EntradaAlmacen e,800_usuarios u WHERE   
					p.status_pedido=0 AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
				and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and u.idUsuario=e.idUsuarioRecibio and ".$condWhere;
		$nFilas=$con->obtenerFilas($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function obtenerProductosEstadoCiclo()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idEstado=$_POST["idEstado"];
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$arrProductos="";
		if($idAlmacen!=-1)
		{
			$consulta="SELECT distinct concat(t.rfc1,'-',t.rfc2,'-',t.rfc3) as rfc,numEntrega,t.nombreProveedor,p.idPedido,folioPedido,fechaRecibido,e.fecha,e.motivo,u.Nombre,condicionPago,comentarios  FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   
					p.status_pedido=".$idEstado." AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable 
					and ".$condWhere." limit ".$start.",".$limit;

			$arrProductos=$con->obtenerFilasJson($consulta);
			$consulta="SELECT count(*) FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9101_pedidosBajoCircunstancias e,
					800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and p.idAlmacen=".$idAlmacen." and e.idPedido=p.idPedido  
					and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere;

		}
		else
		{
			$consulta="SELECT distinct concat(t.rfc1,'-',t.rfc2,'-',t.rfc3) as rfc,numEntrega,t.nombreProveedor,p.idPedido,folioPedido,fechaRecibido,e.fecha,e.motivo,u.Nombre,condicionPago,comentarios FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and e.idPedido=p.idPedido and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere." limit ".$start.",".$limit;
	
			$arrProductos=$con->obtenerFilasJson($consulta);
			$consulta="SELECT count(*) FROM 9102_PedidoCabecera p,6912_proveedores t,
					9103_PedidoDetalle d,6901_catalogoProductos c,9101_pedidosBajoCircunstancias e,800_usuarios u WHERE   p.status_pedido=".$idEstado." AND t.idProveedor=p.idProveedor_ult AND d.idPedido=p.idPedido and c.idProducto=d.idProducto 
					and e.idPedido=p.idPedido  and e.idEtapa=p.status_pedido and u.idUsuario=e.idResponsable and ".$condWhere;
		}
		$nFilas=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nFilas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function registrarEntradaPedidoCiclo()
	{
		global $con;
		$tipoMovimiento=22;
		$tipoMovimientoAlmacen=23;
		$idPedido=$_POST["idPedido"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="SELECT idProveedor_ult,(SELECT SUM(subtotal) FROM 9103_PedidoDetalle WHERE idPedido=p.idPedido) AS subtotal,
				(SELECT SUM(iva) FROM 9103_PedidoDetalle WHERE idPedido=p.idPedido) AS iva,idConcentradoProducto,idAlmacen FROM 9102_PedidoCabecera p WHERE p.idPedido=".$idPedido;
		$fPedido=$con->obtenerPrimeraFila($query);
		$idProveedor=$fPedido[0];
		$iva=$fPedido[2];
		$subtotal=$fPedido[1];
		$montoFatura=$iva+$subtotal;
		$idConcentradoProducto=$fPedido[3];
		$idAlmacen=$fPedido[4];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9102_PedidoCabecera set status_pedido=0,noFactura='".cv($obj->numFactura)."' where idPedido=".$idPedido;
		$x++;
		$consulta[$x]="INSERT INTO 6922_comprobantesPresupuestales(idCategoriaComprobante,idProveedor,tipoComprobante,folioComprobante,fechaCreacion,situacion,montoComprobacion,iva,fechaComprobante,fechaRecepcion,subtotal)
						VALUES(1,".$idProveedor.",".$obj->tipoFactura.",".cv($obj->numFactura).",'".date("Y-m-d H:i:s")."',1,".$montoFatura.",".$iva.",'".$obj->fechaFactura."','".$obj->fechaRecepcion."',".$subtotal.")";
		$x++;
		$query="select * from 9103_PedidoDetalle WHERE idPedido=".$idPedido;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$idProducto=$fila[2];
			$cantidadRecibida=$fila[5];
			$idContenedor=$fila[11];
			if($idContenedor=="")
				$idContenedor="NULL";
			$idUnidadMedida=$fila[12];
			if($idUnidadMedida=="")
				$idUnidadMedida="NULL";
			$idPresentacion=$fila[13];
			if($idPresentacion=="")
				$idPresentacion="NULL";
			$consulta[$x]="INSERT INTO 9104_EntradaAlmacen(idPedido,idProducto,cant_Recibida,fecha_entrada,idUsuarioRecibio,status_Pedido,num_Factura,idContenedorRec,idUnidadMedidaRec,idPresentacionRec)
							VALUES(".$idPedido.",".$idProducto.",".$cantidadRecibida.",'".date("Y-m-d").
							"',".$_SESSION["idUsr"].",0,".cv($obj->numFactura).",".$idContenedor.",".$idUnidadMedida.",".$idPresentacion.")";
			$x++;	
								
		}
		$arrMovimientos=array();
		$arrMovimientosAlmacen=array();
		$query="SELECT solicitudesComprende,objetoGasto,fuenteFinanciamiento,ciclo FROM 527_concentradoProducto WHERE idCompraVSProducto=".$idConcentradoProducto;
		$fConcentrado=$con->obtenerPrimeraFila($query);
		$idCiclo=$fConcentrado[3];
		$idSolicitudes=$fConcentrado[0];
		$partida=$fConcentrado[1];
		$arrSolicitudes=explode(",",$idSolicitudes);
		foreach($arrSolicitudes as $idSolicitud)
		{
			$query="SELECT * FROM 525_productosAutorizados WHERE idCodigoGastoCiclo=".$idSolicitud;
			$filaProducto=$con->obtenerPrimeraFila($query);
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$filaProducto[10];
			$arrDimensiones["codigoUnidad"]=$filaProducto[3];
			$arrDimensiones["idPartida"]=$partida;
			$arrDimensiones["idPedido"]=$idPedido;
			$arrDimensiones["idTipoPresupuesto"]=$fConcentrado[2];
			$arrDimensiones["idProducto"]=$filaProducto[5];
			$query="SELECT mes,montoCompra,cantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$idSolicitud." AND montoCompra>0";
			$resMonto=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($resMonto))
			{
				$arrDimensiones["idMes"]=$fila[0];
				$cadObj='{"tipoMovimiento":"'.$tipoMovimiento.'","montoOperacion":"'.$fila[1].'","dimensiones":null}';
				$obj=json_decode($cadObj);
				$obj->dimensiones=$arrDimensiones;
				array_push($arrMovimientos,$obj);
				$cadObj='{"tipoMovimiento":"'.$tipoMovimientoAlmacen.'","idProducto":"'.$filaProducto[5].'","cantidadOperacion":"'.$fila[2].'","codigoUnidad":"'.$filaProducto[3].'","dimensiones":null}';
				$obj=json_decode($cadObj);
				$obj->dimensiones=$arrDimensiones;
				array_push($arrMovimientosAlmacen,$obj);
				
			}
		}
		$a=new cAlmacen($idAlmacen);
		$c=new cContabilidad($idCiclo);
		if($c->asentarArregloMovimientos($arrMovimientos,$consulta,$x,true))
		{
			if($a->asentarArregloMovimientos($arrMovimientosAlmacen,$consulta,$x,true))
			{
				$consulta[$x]="commit";
				$x++;
				eB($consulta);	
			}
		}
	}
	
	function obtenerSituacionProductosDeptoCiclo()
	{
		global $con;
		
		//$ciclo=$_POST["ciclo"];
		$ciclo=1;
		$arrProgramas=obtenerProgramasInstitucionalesVigentes($ciclo,1);
		$consulta="SELECT idCodigoGastoCiclo,p.idProducto,nombreProducto,descripcion,cantidad,idPrograma,'' as ruta,c.objetoGasto,idAlmacen FROM  525_productosAutorizados p,6901_catalogoProductos c WHERE  idCiclo=".$ciclo." 
					AND codDepto='".$_SESSION["codigoUnidad"]."' AND p.idProducto<>-1 AND c.idProducto=p.idProducto";
		$resProductos=$con->obtenerFilas($consulta);
		$arrProd="";					
		while($fila=mysql_fetch_row($resProductos))
		{
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fila[5];
			$arrDimensiones["codigoUnidad"]=$_SESSION["codigoUnidad"];
			
			$a=new cAlmacen($fila[8]);
			$consulta="SELECT idTiempoMovimiento FROM 6902_tiempoMovimientosAlmacen WHERE idAlmacen=".$fila[8]." AND referencienciaExistencia=1";
			$idTiempoExistencia=$con->obtenerValor($consulta);
			if($idTiempoExistencia=="")
				$idTiempoExistencia=-1;
			
			$consulta="SELECT nombreAlmacen FROM 6900_almacenes WHERE idAlmacen='".$fila[8]."'";
			$responsable=$con->obtenervalor($consulta);
			
			$consulta="select sum(d.cantidad) from 526_distribucionAutorizada d,525_productosAutorizados p where p.idCodigoGastoCiclo=d.idCodigoGastoCiclo and d.idCodigoGastoCiclo=".$fila[0]." and idCiclo=".$ciclo." and mes<=".(date("m")-1);
			$cantidadPlaneada=$con->obtenerValor($consulta);
			if($cantidadPlaneada=="")
				$cantidadPlaneada=0;
			
			$existenciaAlmacen=$a->obtenerCantidadTiempoMovimiento($fila[1],$idTiempoExistencia,$arrDimensiones);
			$consulta="SELECT SUM(cantidad) FROM 9107_solicitudesEntrega s,9107_detallesSolicitudEntrega d WHERE ciclo=".$ciclo." AND departamento='".$_SESSION["codigoUnidad"]."' AND  idPrograma=".$fila[5]."  AND idProducto=".$fila[1]." AND idEstado=4
			and d.idSolicitudEntrega=s.idSolicitudEntrega";
			$cantidadEjercida=$con->obtenerValor($consulta);
			if($cantidadEjercida=="")
				$cantidadEjercida="0";
			$consulta="SELECT SUM(cantidad) FROM 9107_solicitudesEntrega s,9107_detallesSolicitudEntrega d WHERE ciclo=".$ciclo." AND departamento='".$_SESSION["codigoUnidad"]."' AND  idPrograma=".$fila[5]."  AND idProducto=".$fila[1]." AND idEstado=2
			and d.idSolicitudEntrega=s.idSolicitudEntrega";
			$cantidadProgramada=$con->obtenerValor($consulta);
			if($cantidadProgramada=="")
				$cantidadProgramada="0";				
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","idProducto":"'.$fila[1].'","nombreProducto":"'.cv($fila[2]).'","descripcion":"'.cv($fila[3]).'","idPrograma":"'.cv($fila[5]).
				'","idAlmacen":"'.$fila[8].'","programa":"'.$arrProgramas[$fila[5]].'",
					"cantidadAutorizada":"'.$fila[4].'","cantidadPlaneada":"'.$cantidadPlaneada.'","cantidadEjercida":"'.$cantidadEjercida.'","cantidadProgramada":"'.$cantidadProgramada.'","existenciaAlmacen":"'.$existenciaAlmacen.'","almacenResponsable":"'.$responsable.'"}';
			if($arrProd=="")
				$arrProd=$obj;
			else
				$arrProd.=",".$obj;
		}
		$consulta="SELECT count(*) FROM  525_productosAutorizados p,6901_catalogoProductos c WHERE  idCiclo=".$ciclo." 
					AND codDepto='".$_SESSION["codigoUnidad"]."' AND p.idProducto<>-1 AND c.idProducto=p.idProducto";
		$nRegistros=$con->obtenerValor($consulta);					
		echo '{"numReg":"'.$nRegistros.'",registros:['.$arrProd.']}';
	}
	
	function obtenerDistribucionesSolicitadasCiclo()
	{
		global $con;
		$idCodigoGastoCiclo=$_POST["idCodigoGastoCiclo"];
		$consulta="SELECT c.idMes,c.mes,cantidad FROM 526_distribucionAutorizada a,1000_catalogoMeses c 
					WHERE c.idMes=(a.mes+1) AND idCodigoGastoCiclo=".$idCodigoGastoCiclo." ORDER BY a.mes";
		$arrSolicitudes=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrSolicitudes).'}';
	}
	
	function registrarAlmacen()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idAlmacen==-1)
		{
			$consulta[$x]="INSERT INTO 6900_almacenes(nombreAlmacen,descripcion,cveAlmacen,fechaCreacion,responsableCreacion,referencia)
						VALUES('".cv($obj->nombreAlmacen)."','".cv($obj->descripcion)."','".cv($obj->cveAlmacen)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->referenciaFiltros."')";
			$x++;
		}
		else
		{
			$consulta[$x]="update 6900_almacenes set nombreAlmacen='".cv($obj->nombreAlmacen)."',descripcion='".cv($obj->descripcion)."',cveAlmacen='".cv($obj->cveAlmacen)."' where idAlmacen=".$obj->idAlmacen;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idAlmacen==-1)
			{
				$query="select last_insert_id()";
				$obj->idAlmacen=$con->obtenerValor($query);
				
			}
			echo "1|".$obj->idAlmacen;
		}
	}
	
	function obtenerCategoriasAlmacenV2()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="SELECT idCategoriaProducto as idCategoria,nombreCategoria,descripcion FROM 6906_categoriasProducto WHERE idAlmacen=".$idAlmacen." ORDER BY nombreCategoria";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerProductosDisponiblesV2()
	{
		global $con;
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$idAlmacen=$_POST["idAlmacen"];
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		$consulta="SELECT idProducto,cveProducto,nombreProducto FROM 6901_catalogoProductos WHERE idAlmacen=".$idAlmacen." and ".$condWhere." ORDER BY ".$sort." ".$dir. " limit ".$start.",".$limit;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$consulta="SELECT idProducto,cveProducto,nombreProducto FROM 6901_catalogoProductos WHERE idAlmacen=".$idAlmacen." and ".$condWhere." ORDER BY ".$sort." ".$dir;
		$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerCostoProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$consulta="SELECT idCostoProducto,costoTotal,fechaInicioVigencia,fechaFinVigencia FROM 6932_costosProducto WHERE idProducto=".$idProducto." ORDER BY fechaInicioVigencia DESC";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function actualizarCostoProducto()
	{
		global $con;
		$idCostoProducto=$_POST["idCostoProducto"];
		$costoTotal=$_POST["costoTotal"];
		$consulta="UPDATE 6932_costosProducto SET costoTotal='".$costoTotal."',fechaModificacion='".date("Y-m-d H:i:s")."',responsableModificacion=".$_SESSION["idUsr"]." WHERE idCostoProducto=".$idCostoProducto;
		eC($consulta);
	}
	
	function removerCostoProducto()
	{
		global $con;
		$idCostoProducto=$_POST["idCostoProducto"];
		$consulta="SELECT idProducto FROM 6932_costosProducto WHERE idCostoProducto=".$idCostoProducto;
		$idProducto=$con->obtenerValor($consulta);

		$consulta="DELETE FROM 6932_costosProducto WHERE idCostoProducto=".$idCostoProducto;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idCostoProducto FROM 6932_costosProducto WHERE idProducto=".$idProducto." ORDER BY fechaInicioVigencia DESC";
			$idCostoProducto=$con->obtenerValor($consulta);
			if($idCostoProducto=="")
				$idCostoProducto=-1;
			$consulta="UPDATE 6932_costosProducto SET fechaFinVigencia=NULL WHERE idCostoProducto=".$idCostoProducto;
			eC($consulta);		
		}
		
	}
	
	function registrarCostoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT idCostoProducto FROM 6932_costosProducto WHERE idProducto=".$obj->idProducto." ORDER BY fechaInicioVigencia DESC";
		$idCostoProducto=$con->obtenerValor($consulta);
		
		$consulta="INSERT INTO 6932_costosProducto(costoTotal,fechaInicioVigencia,idProducto,fechaCreacion,responsableCreacion)
				VALUES(".$obj->costo.",'".$obj->fechaVigencia."',".$obj->idProducto.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")"	;
		if($con->ejecutarConsulta($consulta))
		{
			$fechaFinal=date("Y-m-d",strtotime("-1 days",strtotime($obj->fechaVigencia)));
			$consulta="UPDATE 6932_costosProducto SET fechaFinVigencia='".$fechaFinal."',fechaModificacion='".date("Y-m-d H:i:s")."',responsableModificacion=".$_SESSION["idUsr"]." WHERE idCostoProducto=".$idCostoProducto;
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="DELETE FROM 6932_costosProducto WHERE idProducto=".$obj->idProducto." AND fechaFinVigencia<fechaInicioVigencia AND fechaFinVigencia IS NOT NULL";
				eC($consulta);
			}
		}
	}
	
	function obtenerPedidosAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$situacion=$_POST["situacion"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$start=$_POST["start"];
		$limit=$_POST["limit"];

		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		
		$consultaAux="SELECT  idPedido,fechaCreacion,fechaPedido,fechaEstimadaEntrega,fechaRealEntrega,p.situacion,total,comentariosAdicionales,
					comentariosRecepcion,(SELECT idComprobante FROM 101_comprobantesPresupuestales WHERE idFactura=p.factura) as factura,
				CONCAT(e.rfc1,'-',e.rfc2,'-',e.rfc3) AS rfc,
				(IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial)) AS proveedor,p.idProveedor,p.formaPago,p.montoAbonado
				FROM 6930_pedidos p,6927_empresas e WHERE e.idEmpresa=p.idProveedor and idAlmacen in (".$idAlmacen.") and p.situacion in (".$situacion.")";
				
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir." limit ".$start.",".$limit;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir;
		$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function registrarPedidosAlmacen()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);		
		
		$llavePedido=rand(0,1000)."_".date("Y_m_d_H_i_s");
		$c=new cAlmacen($obj->idAlmacen);

		$objAsiento='{
						"tipoMovimiento":"23",
						"cantidadOperacion":"",
						"idProducto":"",
						"tipoReferencia":"2",
						"datoReferencia1":"'.$llavePedido.'",
						"dimensiones":null
					}';
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$diasPago="NULL";
		if($obj->diasPago!="")
			$diasPago=$obj->diasPago;
		
		$fechaLimite="NULL";
		if($obj->fechaLimite!="")
			$fechaLimite="'".$obj->fechaLimite."'";
		$consulta[$x]="INSERT INTO 6930_pedidos(fechaCreacion,responsableCreacion,fechaPedido,subtotalPedido,ivaPedido,total,situacion,idProveedor,
					comentariosAdicionales,fechaEstimadaEntrega,idAlmacen,montoAbonado,diasPago,fechaLimitePago,formaPago)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->fechaPedido."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",1,".$obj->idProveedor.
					",'".cv($obj->comentarios)."','".$obj->fechaEntrega."',".$obj->idAlmacen.",".$obj->montoAbonado.",".$diasPago.",".$fechaLimite.",".$obj->formaPago.")";
		$x++;
		$consulta[$x]="set @idPedido:=(select last_insert_id())";
		$x++;
		$arrMovimientos=array();
		foreach($obj->arrProductos as $p)
		{
			$consulta[$x]="INSERT INTO 6931_productosPedido(idPedido,idProducto,cantidad,precioUnitario,total,llave,tasaIVA,subtotal,iva,idUnidadMedida)
						VALUES(@idPedido,".$p->idProducto.",".$p->cantidad.",".$p->costoUnitario.",".$p->total.",'".$p->llave."',".$p->tasaIVA.",".$p->subtotal.",".$p->iva.",".$p->idUnidadMedida.")";
			$x++;
			
			$oProducto=json_decode($objAsiento);
			$oProducto->cantidadOperacion=$p->cantidad;
			$oProducto->idProducto=$p->idProducto;
			$oProducto->dimensiones=convertirLlaveDimensiones($p->llave);
			array_push($arrMovimientos,$oProducto);
		}
		
		$c->asentarArregloMovimientos($arrMovimientos,$consulta,$x,true);
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idPedido WHERE datoReferencia1='".$llavePedido."' AND idAlmacen=".$obj->idAlmacen;
		$x++;
		if($obj->formaPago==2)
		{
			$fechaVencimiento=$obj->fechaLimite;
			$consulta[$x]="INSERT INTO 6942_adeudos(tipoAdeudo,idReferencia,fechaCreacion,subtotal,iva,total,tipoCliente,idCliente,situacion,fechaVencimiento)
						VALUES(4,@idPedido,'".date("Y-m-d H:i:s")."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",0,0,1,'".$fechaVencimiento."')";
			$x++;
			$consulta[$x]="set @idAdeudo:=(select last_insert_id())";
			$x++;
			
			if($obj->montoAbonado>0)
			{
				
				
				$query="select sum(montoAbono) from 6936_controlPagos where idAdeudo=@idAdeudo";
				$montoAbonado=$con->obtenerValor($query);	
				
				$saldo=$obj->total-$montoAbonado;
		
				
				$saldoVirtual=$saldo-$obj->montoAbonado;
				$porcIva=$obj->iva/$obj->total;
				$subtotal=0;
				$iva=0;
				if($saldoVirtual<=0)
				{
					$query="select sum(iva) from 6936_controlPagos where idAdeudo=@idAdeudo";
					$totalIVA=$con->obtenerValor($query);
					$diferenciaIVA=$obj->iva-$totalIVA;
					$iva=$diferenciaIVA;
					$subtotal=$montoAbonado-$iva;
					$consulta[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=@idAdeudo";
					$x++;
				}
				else
				{
		
					$iva=str_replace(",","",number_format($obj->montoAbonado*$porcIva,2));	
		
					$subtotal=$obj->montoAbonado-$iva;
				}
				$folioAbono=generarNombreArchivoTemporal(1,"");
				$consulta[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,horaAbono,idResponsableCobro,idCaja,folioAbono)
								VALUES(".$obj->montoAbonado.",'".date("Y-m-d")."',@idAdeudo,1,'".date("H:i:s")."',".$_SESSION["idUsr"].",0,'".$folioAbono."')";
				$x++;
			}	
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idPedido";
			
			$idPedido=$con->obtenerValor($query);	
			echo "1|".$idPedido;
		}
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
	
	function guardarComprobacionRecepcionPedido()
	{
		global $con;
		global $baseDir;
		$permitirValidacionResponsable=true;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$cT=new cTesoreria();
		
		$query="SELECT idAlmacen,formaPago,diasPago,montoAbonado,subtotalPedido,ivaPedido,total FROM 6930_pedidos WHERE idPedido=".$obj->idPedido;
		$fPedido=$con->obtenerPrimeraFila($query);
		$idAlmacen=$fPedido[0];
		
		
		$xAux=0;
		$consultaAux[$xAux]="begin";
		$xAux++;
		$consultaAux[$xAux]="delete  FROM 6931_productosPedidoRespaldo WHERE idPedido=".$obj->idPedido;
		$xAux++;
		
		$consultaAux[$xAux]="INSERT INTO 6931_productosPedidoRespaldo(idProductoPedido,idPedido,idProducto,cantidad,precioUnitario,subtotal,iva,total,llave,tasaIVA,idUnidadMedida)
						SELECT idProductoPedido,idPedido,idProducto,cantidad,precioUnitario,subtotal,iva,total,llave,tasaIVA,idUnidadMedida FROM 6931_productosPedido WHERE idPedido=".$obj->idPedido;
		
		$xAux++;
		
		$consultaAux[$xAux]="delete FROM 6931_productosPedido WHERE idPedido=".$obj->idPedido;
		
		$xAux++;
		
		$subtotalPedido=0;
		$ivaPedido=0;
		$total=0;
		
		
		$cA=new cAlmacen($idAlmacen);	
		
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';		
		
		
		foreach($obj->arrProductos as $p)
		{
			$subtotalPedido+=$p->subtotal;
			$ivaPedido+=$p->iva;
			$total+=$p->total;
			$consultaAux[$xAux]="INSERT INTO 6931_productosPedido(idPedido,idProducto,cantidad,precioUnitario,total,llave,tasaIVA,subtotal,iva,idUnidadMedida)
						VALUES(".$obj->idPedido.",".$p->idProducto.",".$p->cantidad.",".$p->costoUnitario.",".$p->total.",'".$p->llave."',".$p->tasaIVA.",".$p->subtotal.",".$p->iva.",".$p->idUnidadMedida.")";
			$xAux++;
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=2;
			$oM->cantidadOperacion=$p->cantidad;
			$oM->unidadMedida=$p->idUnidadMedida;
			$oM->idProducto=$p->idProducto;
			$oM->llaveProducto=$p->llave;
			$oM->tipoReferencia=4;
			$oM->datoReferencia1=$obj->idPedido;
			
			array_push($arrMovimientos,$oM);
			
			
		}
		
		$cA->asentarArregloMovimientos($arrMovimientos,$consultaAux,$xAux);
		
		$consultaAux[$xAux]="UPDATE 6930_pedidos SET subtotalPedido=".$subtotalPedido.",ivaPedido=".$ivaPedido.",total=".$total.",situacion=3,fechaRealEntrega='".$obj->fechaRecepcionPedido."',
							comentariosRecepcion='".cv($obj->comentariosAdicionales)."' where idPedido=".$obj->idPedido;
		$xAux++;
		
		$consultaAux[$xAux]="commit";
		$xAux++;
		
		if($con->ejecutarBloque($consultaAux))
		{
		
			
			
			
			if($fPedido[1]==3)
			{
				$fechaVencimiento=date("Y-m-d",strtotime("+".$fPedido[2]." days",strtotime(date("Y-m-d"))));
							
				$cAdeudo='	{
								"tipoAdeudo":"4",
								"idReferencia":"'.$obj->idPedido.'",
								"subtotal":"'.$subtotalPedido.'",
								"iva":"'.$ivaPedido.'",
								"total":"'.$total.'",
								"tipoCliente":"4",
								"idCliente":"'.$idAlmacen.'",
								"fechaVencimiento":"'.$fechaVencimiento.'"
								
							}';
				$oAdeudo=json_decode($cAdeudo);
				
				$idAdeudo=$cT->registrarAdeudo($oAdeudo);				
				
				if($fPedido[3]>0)
				{
					
					$cAbono='	{
									"montoAbono":"'.$fPedido[3].'",
									"idAdeudo":"'.$idAdeudo.'",
									"formaPago":"1",
									"datosComp":"",
									"idCaja":"0",
									"tipoOperacion":"-1",
									"comentarios":"",
									"idComprobante":""
								}
							';
						
					$oAbono=json_decode($cAbono);
					$idAdeudo=$cT->registrarAbonoAdeudo($oAbono);
				}	
			}
			
			echo "1|";
			
		}
	}
	
	function obtenerCategoriasAlmacenes()
	{
		global $con;
		$arrAlmacenes=array();
		$listAlmacenes="";
		$consulta="SELECT idCategoriaProducto,nombreCategoria,idAlmacen FROM 6906_categoriasProducto ORDER BY nombreCategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"icon":"../images/s.gif",checked:false,"id":"'.$fila[0].'","text":"'.cv($fila[1]).'","leaf":true,"tipo":"1"}';
			if(!isset($arrAlmacenes[$fila[2]]))
			{
				$arrAlmacenes[$fila[2]]=$o;
				if($listAlmacenes=="")
					$listAlmacenes=$fila[2];
				else
					$listAlmacenes.=",".$fila[2];
				
					
			}
			else
				$arrAlmacenes[$fila[2]].=",".$o;
				
		}
		
		$arrRegistros="";
		$consulta="SELECT idAlmacen,nombreAlmacen FROM 6900_almacenes WHERE idAlmacen IN (".$listAlmacenes.") ORDER BY nombreAlmacen";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"icon":"../images/s.gif","id":"a'.$fila[0].'","text":"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important\'>'.cv($fila[1]).'</span>","leaf":false,"tipo":"0","children":['.$arrAlmacenes[$fila[0]].']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo "[".$arrRegistros."]";
			
	}
	
	function obtenerProductosTienda()
	{
		global $con;
		global $baseDir;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$categorias=$_POST["categorias"];
		
		$arrProductos="";
		$numReg=0;
		if($categorias=="")
			$consulta="SELECT  idProducto,nombreProducto,cveProducto FROM 6901_catalogoProductos ORDER BY nombreProducto";
		else
			$consulta="SELECT  c.idProducto,nombreProducto,cveProducto FROM 6901_catalogoProductos p,6907_productosVSCategorias c WHERE 
						p.idProducto=c.idProducto and idCategoria IN (".$categorias.") ORDER BY nombreProducto";
		
		$con->obtenerFilas($consulta);	
		$numReg=$con->filasAfectadas;
		$consulta.=" limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);	
		
		while($fila=mysql_fetch_row($res))
		{
			$archivoImagen="";
			if(file_exists($baseDir."/modeloAlmacenes/imagenesProducto/img_".$fila[0]))
				$archivoImagen="../modeloAlmacenes/imagenesProducto/img_".$fila[0];
			else
				$archivoImagen="../images/imgNoDisponible.jpg";
			$consulta="SELECT costoTotal FROM 6932_costosProducto WHERE idProducto=".$fila[0]." AND '".date("Y-m-d")."'>=fechaInicioVigencia ORDER BY fechaInicioVigencia LIMIT 0,1";
			$costo=$con->obtenerValor($consulta);
			$p='{"idProducto":"'.$fila[0].'","nombreProducto":"['.$fila[2].'] '.$fila[1].'","costo":"'.$costo.'","imagen":"'.$archivoImagen.'"}';
			if($arrProductos=="")
				$arrProductos=$p;
			else
				$arrProductos.=",".$p;

		}
		echo '{"numReg":"'.$numReg.'","registros":['.($arrProductos).']}';
	}
	
	function obtenerCategoriasModeloAlmacen()
	{
		global $con;
		$idAlmacen=0;
		if(isset($_POST["idAlmacen"]))
			$idAlmacen=$_POST["idAlmacen"];
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT idCategoriaProducto,nombreCategoria,idPadre,descripcion,nivel FROM 6906_categoriasProducto WHERE idAlmacen in(".$idAlmacen.") and nivel=1 ORDER BY nombreCategoria";
		if($idAlmacen==0)
		{
			$consulta="SELECT idCategoriaProducto,nombreCategoria,idPadre,descripcion,nivel FROM 6906_categoriasProducto WHERE  nivel=1 ORDER BY nombreCategoria";
		}

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$llave=$fila[0];
			if($fila[2]=="")
				$fila[2]="null";
			$esHoja="true";
			
			$arrHijos=obtenerCategoriasHijas($fila[0],$llave);
			if($arrHijos!="")
				$esHoja="false";
			$o='{"llave":"'.$llave.'","idCategoria":"'.$fila[0].'","nombreCategoria":"'.cv($fila[1]).'","descripcion":"'.cv($fila[3]).'","_parent":'.$fila[2].',"_is_leaf":'.$esHoja.',"nivel":"'.$fila[4].'"}'.$arrHijos;
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerCategoriasHijas($idPadre,$llave)
	{
		global $con;
		$idAlmacen=0;
		if(isset($_POST["idAlmacen"]))
			$idAlmacen=$_POST["idAlmacen"];
		$arrRegistros="";
		
		$consulta="SELECT idCategoriaProducto,nombreCategoria,idPadre,descripcion,nivel FROM 6906_categoriasProducto WHERE idPadre=".$idPadre." ORDER BY nombreCategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$llaveNodo=$llave.".".$fila[0];
			if($fila[2]=="")
				$fila[2]="null";
			$esHoja="true";
			
			$arrHijos=obtenerCategoriasHijas($fila[0],$llaveNodo);
			if($arrHijos!="")
				$esHoja="false";
			$o='{"llave":"'.$llaveNodo.'","idCategoria":"'.$fila[0].'","nombreCategoria":"'.cv($fila[1]).'","descripcion":"'.cv($fila[3]).'","_parent":'.$fila[2].',"_is_leaf":'.$esHoja.',"nivel":"'.$fila[4].'"}'.$arrHijos;
			
			$arrRegistros.=",".$o;

		}
		return $arrRegistros;
	}
	
	function removerCategorias()
	{
		global $con;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idCategoria=$_POST["idCategoria"];
		removerCategoriaHijas($idCategoria,$consulta,$x);
		$consulta[$x]="delete from 6906_categoriasProducto where  idCategoriaProducto=".$idCategoria;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerCategoriaHijas($idCategoria,&$consulta,&$x)
	{
		global $con;
		$query="SELECT idCategoriaProducto FROM 6906_categoriasProducto WHERE idPadre=".$idCategoria;
		$res=$con->obtenerFilas($query);	
		while($fila=mysql_fetch_row($res))
		{
			removerCategoriaHijas($fila[0],$consulta,$x);
			$consulta[$x]="delete from 6906_categoriasProducto where  idCategoriaProducto=".$fila[0];
			$x++;
		}
	}
	
	function obtenerDimensionesDisponibles()
	{
		global $con;
		$listDimensiones=-1;
		$idCategoria=$_POST["idCategoria"];
		$consulta="SELECT idDimension FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$listDimensiones=$con->obtenerListaValores($consulta);
		if($listDimensiones=="")
			$listDimensiones=-1;
		$consulta="SELECT idDimension,nombreDimension,descripcion FROM 563_dimensiones WHERE situacion=1 and idDimension not in (".$listDimensiones.") ORDER BY nombreDimension";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function obtenerDimensionesCategoria()
	{
		global $con;

		$idCategoria=$_POST["idCategoria"];
		$consulta="SELECT d.idDimension,nombreDimension as dimension,orden,c.etiqueta,c.galeriaImagen  as permiteGaleria FROM 563_dimensiones d,6908_dimensionesCategoriasProducto c WHERE d.idDimension=c.idDimension and c.idCategoria=".$idCategoria." ORDER BY orden";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerDimensionesCosteoProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$numReg=0;
		$arrRegistros="";
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;
		$idCategoria="";
		$arrDimensiones=array();
		for($ct=$tamCategoria;$ct>=0;$ct--)
		{
			$idCategoria=$arrCategoria[$ct];
			$consulta="SELECT idDimension FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." and idDimension=".$idDimension." ORDER BY orden";
			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				break;	
			}
		}
		
		$consulta="SELECT etiqueta,orden,galeriaImagen FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;
		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		$permiteGaleria=$fCategoria[2];
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;
		$fDimension=$con->obtenerPrimeraFila($consulta);
		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		$consulta="SELECT categoriaIVA FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$idCategoriaIVA=$con->obtenerValor($consulta);
		if($idCategoriaIVA=="")
			$idCategoriaIVA=-1;
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesCosteoProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
			
			$cadPrecio="";
			$consulta="SELECT  z.idZona,z.zona FROM  6939_zonasCategoriaIVA zc,6937_zonas z WHERE z.idZona=zc.idZona AND zc.idCategoria=".$idCategoriaIVA;
			$resZona=$con->obtenerFilas($consulta);
			while($filaZona=mysql_fetch_row($resZona))
			{
				$consulta="SELECT porcentajeIVA FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$idCategoriaIVA." AND idZona=".$filaZona[0]." and fechaInicio<='".date("Y-m-d")."' ORDER BY fechaInicio DESC";
				$porcentajeIVA=$con->obtenerValor($consulta);
				if($porcentajeIVA=="")
					$porcentajeIVA=0;
					
				$consulta="SELECT precio,fechaInicio,tipoPrecio FROM 6911_costosProductos WHERE idProducto=".$idProducto." AND llave='".$fila[4]."' and idZona=".$filaZona[0]." order by fechaInicio desc";
				$fProducto=$con->obtenerPrimeraFila($consulta);
				$precio="";
				if($fProducto)
				{
					if($fProducto[2]==0)
						$precio=$fProducto[0]*(1+($porcentajeIVA/100));	
						
					else
						$precio=$fProducto[0];
				}
				$cadPrecio.=',"precio_'.$filaZona[0].'":"'.$precio.'","fechaInicio_'.$filaZona[0].'":"'.$fProducto[1].'"';
			}
			
			$lblEtDimension='<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]);
			if($etiqueta=="")
				$lblEtDimension=cv($arrDimension[$fila[3]]);
			
			$o='{"permiteGaleria":"'.$permiteGaleria.'"'.$cadPrecio.',"idDimension":"'.$idDimension.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"'.$lblEtDimension.'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}	
		
	function obtenerDimensionesCosteoProductoHijos($idProducto,$idPadre,$idCategoria)
	{
		global $con;
		$arrRegistros="";
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;

		$arrDimensiones=array();
		
		
		$consulta="SELECT etiqueta,orden,galeriaImagen FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;

		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		$permiteGaleria=$fCategoria[2];
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;
		$fDimension=$con->obtenerPrimeraFila($consulta);
		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		
		$consulta="SELECT categoriaIVA FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$idCategoriaIVA=$con->obtenerValor($consulta);
		if($idCategoriaIVA=="")
			$idCategoriaIVA=-1;
		
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesCosteoProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
			
			if(isset($arrDimension[$fila[3]]))
			{
				$consulta="SELECT  z.idZona,z.zona FROM  6939_zonasCategoriaIVA zc,6937_zonas z WHERE z.idZona=zc.idZona AND zc.idCategoria=".$idCategoriaIVA;
				$resZona=$con->obtenerFilas($consulta);
				while($filaZona=mysql_fetch_row($resZona))
				{
					$consulta="SELECT porcentajeIVA FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$idCategoriaIVA." AND idZona=".$filaZona[0]." and fechaInicio<='".date("Y-m-d")."' ORDER BY fechaInicio DESC";
					$porcentajeIVA=$con->obtenerValor($consulta);
					if($porcentajeIVA=="")
						$porcentajeIVA=0;
						
					$consulta="SELECT precio,fechaInicio FROM 6911_costosProductos WHERE idProducto=".$idProducto." AND llave='".$fila[4]."' and idZona=".$filaZona[0]." order by fechaInicio desc";
					$fProducto=$con->obtenerPrimeraFila($consulta);
					$precio="";
					if($fProducto)
					{
						$precio=$fProducto[0]+($fProducto[0]*($porcentajeIVA/100));	
					}
					$cadPrecio.=',"precio_'.$filaZona[0].'":"'.$precio.'","fechaInicio_'.$filaZona[0].'":"'.$fProducto[1].'"';
				}
				
				
				
			
				$o='{"permiteGaleria":"'.$permiteGaleria.'"'.$cadPrecio.',"idDimension":"'.$idDimension.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]).'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		}
		return "".$arrRegistros."";
	}
		
	function obtenerDimensionesDisponiblesAtributo()
	{
		global $con;	
		$idProducto=$_POST["idProducto"];
		$nivel=$_POST["nivel"];
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);

		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;
		$idCategoria="";
		$arrDimensiones=array();
		for($ct=$tamCategoria;$ct>=0;$ct--)
		{
			$idCategoria=$arrCategoria[$ct];
			$consulta="SELECT idDimension FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." ORDER BY orden";
			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				while($fDimension=mysql_fetch_row($res))
				{
					array_push($arrDimensiones,$fDimension[0]);
				}
				break;	
			}
		}
		$arrRegistros="";
		$numReg=0;
		$etiqueta="";
		if((sizeof($arrDimensiones)>0)&&((sizeof($arrDimensiones)-1)>=$nivel))
		{
			$dimension=$arrDimensiones[$nivel];
			$consulta="SELECT etiqueta FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$dimension;

			$etiqueta=$con->obtenerValor($consulta);
			
			$arrValIng=array();
			/*$consulta="SELECT valor FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idDimension=".$dimension;
			$resValores=$con->obtenerFilas($consulta);
			while($fValor=mysql_fetch_row($resValores))
			{
				$arrValIng[$fValor[0]]=1;
			}*/
			
			
			$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$dimension;
			$fDimension=$con->obtenerPrimeraFila($consulta);
			if($fDimension)
			{
				if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
				{
					$oNull=NULL;
					$cadObj='{"param1":"-1"}';
					$objParam1=json_decode($cadObj);
					$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
					if(sizeof($resRegistros)>0)
					{
						foreach($resRegistros as $r)
						{
							if(!isset($arrValIng[$r["id"]]))
							{
								$o='{"idDimension":"'.$dimension.'","idAtributo":"'.$r["id"].'","valorAtributo":"<b>'.$etiqueta.': </b>'.cv($r["etiqueta"]).'","descripcion":"'.cv($r["descripcion"]).'"}';
								if($arrRegistros=="")
									$arrRegistros=$o;
								else
									$arrRegistros.=",".$o;
								$numReg++;
							}
						}
					}
				}
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"etiqueta":"'.$etiqueta.'"}';
	}
	
	function guardarAtributosProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrDimensiones as $o)
		{
			$llavePadre="";
			if($o->padre=="")
				$o->padre="NULL";
			else
			{
				$query="SELECT llave FROM 6909_atributosProductos WHERE idAtributo=".$o->padre;
				$llavePadre=$con->obtenerValor($query);
			}
			if($llavePadre=="")
				$llavePadre=$o->idDimension.":".$o->id;
			else
				$llavePadre.=".".$o->idDimension.":".$o->id;
				
			$query="SELECT COUNT(*) FROM 6909_atributosProductos WHERE idProducto=".$obj->idProducto." AND idDimension=".$o->idDimension." AND valor='".$o->id."'";	
			$nReg=$con->obtenerValor($query);
			if($nReg==0)
			{	
				$consulta[$x]="INSERT INTO 6909_atributosProductos(idProducto,idDimension,valor,llave,idPadre)
							VALUES(".$obj->idProducto.",".$o->idDimension.",'".$o->id."','".$llavePadre."',".$o->padre.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
	}
	
	function obtenerDimensionesConfiguradasProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$numReg=0;
		$arrRegistros="";
		
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;
		$idCategoria="";
		$arrDimensiones=array();
		for($ct=$tamCategoria;$ct>=0;$ct--)
		{
			$idCategoria=$arrCategoria[$ct];
			$consulta="SELECT idDimension FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." and idDimension=".$idDimension." ORDER BY orden";
			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				break;	
			}
		}
		
		$consulta="SELECT etiqueta,orden FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;
		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;
		$fDimension=$con->obtenerPrimeraFila($consulta);
		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesConfiguradasProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
				
			$o='{"idDimension":"'.$idDimension.'","nivel":"'.$orden.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]).'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';		
	}
	
	function obtenerDimensionesConfiguradasProductoHijos($idProducto,$idPadre,$idCategoria)
	{
		global $con;
		$arrRegistros="";
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode("_",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;

		$arrDimensiones=array();
		
		
		$consulta="SELECT etiqueta,orden FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;

		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;
		$fDimension=$con->obtenerPrimeraFila($consulta);
		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesConfiguradasProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
			
			if(isset($arrDimension[$fila[3]]))
			{
				$o='{"idDimension":"'.$idDimension.'","nivel":"'.$orden.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]).'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		}
		return "".$arrRegistros."";
	}
	
	function removerAtributosProducto()
	{
		global $con;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idAtributo=$_POST["idAtributo"];
		removerAtributosProductoHijos($idAtributo,$consulta,$x);
		$consulta[$x]="DELETE FROM 6909_atributosProductos WHERE idAtributo=".$idAtributo;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerAtributosProductoHijos($idAtributo,&$consulta,&$x)
	{
		global $con;
		$query="SELECT idAtributo FROM 6909_atributosProductos WHERE idPadre=".$idAtributo;
		$res=$con->obtenerFilas($query);	
		while($fila=mysql_fetch_row($res))
		{
			removerAtributosProductoHijos($fila[0],$consulta,$x);
			$consulta[$x]="DELETE FROM 6909_atributosProductos WHERE idAtributo=".$fila[0];
			$x++;
		}
	}
	
	function guardarCodigoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 6910_clavesProductos WHERE idProducto=".$obj->idProducto." AND tipoClave=".$obj->tipoCodigo." and llaveProducto='".$obj->llave."'";
		$x++;
		$consulta[$x]="INSERT INTO 6910_clavesProductos(idProducto,tipoClave,clave,llaveProducto) VALUES(".$obj->idProducto.",".$obj->tipoCodigo.",'".$obj->valor."','".$obj->llave."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarPrecioProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->aRegistros as $r)
		{
			$consulta[$x]="delete from 6911_costosProductos where idProducto=".$r->idProducto." and llave='".$r->llave."' and idZona=".$r->idZona." and fechaInicio>='".$r->fechaInicio."'";
			$x++;
			$consulta[$x]="INSERT INTO 6911_costosProductos(idProducto,llave,precio,fechaInicio,idZona,tipoPrecio)
						VALUES(".$r->idProducto.",'".$r->llave."',".$r->precio.",'".$r->fechaInicio."',".$r->idZona.",".$r->tipoPrecio.")";
			$x++;
			
			
			$query="SELECT idCostoProducto FROM 6932_descripcionProducto WHERE idProducto=".$r->idProducto." AND llave='".$r->llave."'";
			$idCostoProducto=$con->obtenerValor($query);
			if($idCostoProducto=="")
			{
				$detalleProducto=obtenerDatosProducto($r->idProducto,$r->llave,-1,0,0);
				$descripcion=$detalleProducto["nombreProducto"];

				$consulta[$x]="INSERT INTO 6932_descripcionProducto(idProducto,llave,descripcionProducto)
								VALUES(".$r->idProducto.",'".$r->llave."','".$descripcion."')";
				$x++;
			}
			
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerHistorialPrecioProducto()
	{
		global $con;	
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$idZona=$_POST["idZona"];
		$consulta="SELECT precio,fechaInicio FROM 6911_costosProductos WHERE idProducto=".$idProducto." AND llave='".$llave."' and idZona=".$idZona." order by fechaInicio desc";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';		
	}
	
	function obtenerImagenesGaleriaProductos()
	{
		global $con;	
		$numReg=0;
		$arrRegistros="";
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$consulta="SELECT idProductoImagen,idImagen FROM 6912_imagenesProductos WHERE idProducto=".$idProducto." AND llave='".$llave."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT tamano FROM 908_archivos WHERE idArchivo=".$fila[1];
			$tamano=$con->obtenerValor($consulta);
			$o='{"idProductoImagen":"'.$fila[0].'","idImagen":"'.$fila[1].'","tamano":"'.$tamano.'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			$numReg++;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';		
	}
	
	function removerImagenProducto()
	{
		global $con;
		$idImagen=$_POST["idImagen"];
		$consulta="SELECT idImagen FROM 6912_imagenesProductos WHERE idProductoImagen=".$idImagen;
		$idProductoImagen=$con->obtenerValor($consulta);
		$consulta="DELETE FROM 6912_imagenesProductos WHERE idProductoImagen=".$idImagen;
		if($con->ejecutarConsulta($consulta))
		{
			removerDocumentoServidor($idProductoImagen);
			echo "1|";
		}
	}
	
	function guardarImagenProducto()
	{
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$idComprobante=$_POST["idComprobante"];
		$nombreArchivo=$_POST["nombreArchivo"];
		$idImagen=$idComprobante=registrarDocumentoServidor($idComprobante,$nombreArchivo);
		$consulta="INSERT INTO 6912_imagenesProductos(idProducto,llave,idImagen) VALUES(".$idProducto.",'".$llave."',".$idImagen.")";	
		eC($consulta);
	}
		
	function obtenerDimensionesClavesProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$numReg=0;
		$arrRegistros="";
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;
		$idCategoria="";
		$arrDimensiones=array();
		for($ct=$tamCategoria;$ct>=0;$ct--)
		{
			$idCategoria=$arrCategoria[$ct];
			$consulta="SELECT idDimension FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." and idDimension=".$idDimension." ORDER BY orden";

			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				break;	
			}
		}
		
		$consulta="SELECT etiqueta,orden,galeriaImagen FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;

		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		$permiteGaleria=$fCategoria[2];
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;

		$fDimension=$con->obtenerPrimeraFila($consulta);

		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
			
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre IS NULL";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesClaveProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
			$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$idProducto." AND tipoClave=1 AND llaveProducto='".$fila[4]."'";
			$codigoBarras=$con->obtenerValor($consulta);	
			$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$idProducto." AND tipoClave=2 AND llaveProducto='".$fila[4]."'";
			$codigoAlternativo=$con->obtenerValor($consulta);	
			
			
			$lblEtDimension='<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]);
			if($etiqueta=="")
				$lblEtDimension=cv($arrDimension[$fila[3]]);
			
			$o='{"permiteGaleria":"'.$permiteGaleria.'","codigoBarras":"'.$codigoBarras.'","codigoAlternativo":"'.$codigoAlternativo.'","idDimension":"'.$idDimension.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"'.$lblEtDimension.'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}	
		
	function obtenerDimensionesClaveProductoHijos($idProducto,$idPadre,$idCategoria)
	{
		global $con;
		$arrRegistros="";
		$arrDimension=array();
		$consulta="SELECT idDimension FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$idDimension=$con->obtenerValor($consulta);
		if($idDimension=="")
			$idDimension=-1;
		
		$consulta="SELECT categoria FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$llaveCategoria=$con->obtenerValor($consulta);
		$arrCategoria=explode(".",$llaveCategoria);
		$tamCategoria=sizeof($arrCategoria)-1;

		$arrDimensiones=array();
		
		
		$consulta="SELECT etiqueta,orden,galeriaImagen FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria." AND idDimension=".$idDimension;

		$fCategoria=$con->obtenerPrimeraFila($consulta);
		$etiqueta=$fCategoria[0];
		$orden=$fCategoria[1];
		$permiteGaleria=$fCategoria[2];
		
		$consulta="SELECT max(orden) FROM 6908_dimensionesCategoriasProducto WHERE idCategoria=".$idCategoria;
		$maxOrden=$con->obtenerValor($consulta);
		
		$ultimaDimension="0";
		if($orden>=$maxOrden)
			$ultimaDimension=1;
		
		
		$consulta="SELECT nombreEstructura,nombreDimension,idFuncionOrigenDatos FROM 563_dimensiones WHERE idDimension=".$idDimension;
		$fDimension=$con->obtenerPrimeraFila($consulta);
		if($fDimension)
		{
			if(($fDimension[2]!="")&&($fDimension[2]!="-1"))
			{
				$oNull=NULL;
				$cadObj='{"param1":"-1"}';
				$objParam1=json_decode($cadObj);
				$resRegistros=resolverExpresionCalculoPHP($fDimension[2],$objParam1,$oNull);	
				if(sizeof($resRegistros)>0)
				{
					foreach($resRegistros as $r)
					{
						$arrDimension[$r["id"]]=$r["etiqueta"];
					}
				}
			}
		}		
		
		$consulta="SELECT * FROM 6909_atributosProductos WHERE idProducto=".$idProducto." AND idPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$padre=$fila[5];
			if($padre=="")
				$padre="null";
			$hoja="true";
			$hijos=obtenerDimensionesClaveProductoHijos($idProducto,$fila[0],$idCategoria);
			if($hijos!="")
			{
				$hoja="false";
				$hijos=",".$hijos;
			}
			
			if(isset($arrDimension[$fila[3]]))
			{
				$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$idProducto." AND tipoClave=1 AND llaveProducto='".$fila[4]."'";
				$codigoBarras=$con->obtenerValor($consulta);	
				$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$idProducto." AND tipoClave=2 AND llaveProducto='".$fila[4]."'";
				$codigoAlternativo=$con->obtenerValor($consulta);
				
			
				$o='{"permiteGaleria":"'.$permiteGaleria.'","codigoBarras":"'.$codigoBarras.'","codigoAlternativo":"'.$codigoAlternativo.'","idDimension":"'.$idDimension.'","ultimaDimension":"'.$ultimaDimension.'","id":"'.$fila[0].'","dimension":"<b>'.$etiqueta.':</b> '.cv($arrDimension[$fila[3]]).'","llave":"'.$fila[4].'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}'.$hijos	;
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
		}
		return "".$arrRegistros."";
	}
	
	function obtenerDatosProductoVenta()
	{
		
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$arrRegistros="";
		foreach($obj->arrProductos as $p)
		{
			
			
			$regProducto=array();
			$regProducto["dimensiones"]=array();
			$archivoImagen="";
			$datosProducto=obtenerDatosProducto($p->idProducto,$p->llave,$obj->idCaja,$obj->tipoCliente,$obj->idCliente);
			$regProducto["idProducto"]=$p->idProducto;
			$regProducto["llaveProducto"]=$p->llave;
			$regProducto["tipoMovimiento"]="";
			$regProducto["costoUnitario"]=$datosProducto["costoUnitario"];
			$regProducto["costoUnitarioNeto"]=$datosProducto["costoUnitario"];
			$regProducto["costoUnitarioConDescuento"]=$datosProducto["costoUnitario"];
			
			
			$descuento= buscarDescuentoProducto($obj->tipoCliente,$obj->idCliente,$p->idProducto,$p->llave);
			
			if($datosProducto["tipoPrecio"]==1)
			{
				$regProducto["costoUnitarioNeto"]=str_replace(",","",number_format($regProducto["costoUnitarioNeto"]/(1+($datosProducto["porcentajeIVA"]/100)),2));
			}
			
			
			$regProducto["descuento"]=0;
			if(($descuento["pDescuento"]!="")&&($descuento["pDescuento"]!=0))
			{
				$costoNeto=$regProducto["costoUnitarioNeto"];
				$regProducto["descuento"]=str_replace(",","",number_format($costoNeto*($descuento["pDescuento"]/100),2));
				$regProducto["costoUnitarioConDescuento"]=str_replace(",","",number_format($regProducto["costoUnitario"],2))-str_replace(",","",number_format($regProducto["costoUnitario"]*($descuento["pDescuento"]/100),2));
				
				
				
			}
			
			if(isset($descuento["mDescuento"])&&($descuento["mDescuento"]!="")&&($descuento["mDescuento"]!=0))
			{
				$regProducto["descuento"]=$descuento["mDescuento"];
				$regProducto["costoUnitarioConDescuento"]=str_replace(",","",number_format($regProducto["costoUnitario"],2))-str_replace(",","",number_format($regProducto["costoUnitario"],2));
				
			}

		
			
			
		
			
			
			$o='{"idProducto":"'.$p->idProducto.'","precioUnitario":"'.$regProducto["costoUnitarioNeto"].'","descuento":"'.$regProducto["descuento"].'","costoUnitarioConDescuento":"'.$regProducto["costoUnitarioConDescuento"].'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '1|{"registros":['.$arrRegistros.']}';
	}
		
	function buscarProductoDescripcion()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$valor=$_POST["valor"]	;
		$fechaActual=date("Y-m-d");
		$idZona=$_POST["idZona"];
		$categorias=$_POST["categorias"];
		$tipoCliente=1;
		if(isset($_POST["tipoCliente"]))
			$tipoCliente=$_POST["tipoCliente"];
		$idCliente=-1;
		if(isset($_POST["idCliente"]))
			$idCliente=$_POST["idCliente"];
		
		
		$buscarPrecio=0;
		if(isset($_POST["buscarPrecio"]))
			$buscarPrecio=$_POST["buscarPrecio"];
		
		$comp="";
		if($categorias!="")
		{
			
			$consulta="SELECT idProducto FROM 6901_catalogoProductos WHERE categoria IN (".$categorias.") and situacion=1";	
			$listProductos=$con->obtenerListaValores($consulta);
			if($listProductos=="")
				$listProductos=-1;
			$comp=" c.idProducto in (".$listProductos.") and ";
		}
		
		switch($criterio)
		{
			
			case 1:
				$consulta="select d.idProducto,d.llave,d.descripcionProducto as nombreProducto,
						(SELECT precio FROM 6911_costosProductos WHERE idProducto=d.idProducto AND llave=d.llave AND idZona=".$idZona." AND 	fechaInicio<='".$fechaActual."' ORDER BY fechaInicio DESC LIMIT 0,1) as precioUnitario,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=1 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoBarras,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=2 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoAlterno, 
						
						(
				
						IF(
						(SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)IS NULL,0,(
								SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)
								)				
						) 
						
						as tasaIVA
						from 6932_descripcionProducto d,6901_catalogoProductos c where ".$comp." descripcionProducto like '".$valor."%' and c.idProducto=d.idProducto and c.situacion=1";
				
			break;
			case 2:
				$consulta="select d.idProducto,d.llave,d.descripcionProducto as nombreProducto, 
				(SELECT precio FROM 6911_costosProductos WHERE idProducto=d.idProducto AND llave=d.llave AND idZona=".$idZona." AND 	fechaInicio<='".$fechaActual."' ORDER BY fechaInicio DESC LIMIT 0,1) as precioUnitario,
				(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=1 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoBarras,
				(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=2 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoAlterno,
				(
				
						IF(
						(SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)IS NULL,0,(
								SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)
								)				
						)  as tasaIVA
				from 6932_descripcionProducto d,6901_catalogoProductos c where ".$comp."  descripcionProducto like '%".$valor."%' and c.idProducto=d.idProducto and c.situacion=1";

			break;	
			case 3://Barras
			
				$consulta="SELECT c.idProducto,c.llaveProducto FROM 6910_clavesProductos c,6901_catalogoProductos p WHERE  tipoClave=1 and clave='".$valor."' and c.idProducto=p.idProducto and p.situacion=1";
				$fProducto=$con->obtenerPrimeraFila($consulta);
				if(!$fProducto)
				{
					$fProducto[0]=-1;
					$fProducto[1]=-1;	
				}
				$consulta="select idProducto,llave,descripcionProducto as nombreProducto, 
						(SELECT precio FROM 6911_costosProductos WHERE idProducto=d.idProducto AND llave=d.llave AND idZona=".$idZona." AND 	fechaInicio<='".$fechaActual."' ORDER BY fechaInicio DESC LIMIT 0,1) as precioUnitario,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=1 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoBarras,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=2 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoAlterno,
						(
				
						IF(
						(SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)IS NULL,0,(
								SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)
								)				
						)  as tasaIVA
						from 6932_descripcionProducto d where idProducto=".$fProducto[0]." and llave='".$fProducto[1]."'";
			break;
			case 4://Alterno
			
				$consulta="SELECT c.idProducto,c.llaveProducto FROM 6910_clavesProductos c,6901_catalogoProductos p WHERE  tipoClave=2 and clave='".$valor."' and c.idProducto=p.idProducto and p.situacion=1";
				$fProducto=$con->obtenerPrimeraFila($consulta);
				if(!$fProducto)
				{
					$fProducto[0]=-1;
					$fProducto[1]=-1;	
				}
				$consulta="select idProducto,llave,descripcionProducto as nombreProducto, 
						(SELECT precio FROM 6911_costosProductos WHERE idProducto=d.idProducto AND llave=d.llave AND idZona=".$idZona." AND 	fechaInicio<='".$fechaActual."' ORDER BY fechaInicio DESC LIMIT 0,1) as precioUnitario,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=1 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoBarras,
						(SELECT clave FROM 6910_clavesProductos WHERE tipoClave=2 and llaveProducto=d.llave and idProducto=d.idProducto ) as codigoAlterno,
						(
				
						IF(
						(SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)IS NULL,0,(
								SELECT p.porcentajeIVA  FROM 6901_catalogoProductos c,6940_porcentajeIVACategoria p WHERE c.idProducto=d.idProducto AND p.idCategoria=c.categoriaIVA AND 
								p.idZona=".$idZona." AND p.fechaInicio<='".$fechaActual."' ORDER BY p.fechaInicio DESC LIMIT 0,1)
								)				
						)  as tasaIVA
						from 6932_descripcionProducto d where idProducto=".$fProducto[0]." and llave='".$fProducto[1]."'";
			break;
		}
		
		$arrRegistros="";
		$numReg=0;
		if($buscarPrecio==0)
		{
			//$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
			//$numReg=$con->filasAfectadas;
			
			
			
			$rProducto=$con->obtenerFilas($consulta);	
			while($fProducto=mysql_fetch_row($rProducto))
			{
				$datosProducto=obtenerDatosProducto($fProducto[0],$fProducto[1],0,$tipoCliente,$idCliente);
				$precioUnitario=$fProducto[3];
			
				$o='{"unidadMedida":"'.$datosProducto["unidadMedida"].'","arrUnidadesMedida":'.$datosProducto["arrUnidadesMedida"].',"codigoAlterno":"'.$fProducto[5].
					'","codigoBarras":"'.$fProducto[4].'","idProducto":"'.$fProducto[0].'","llave":"'.$fProducto[1].
					'","nombreProducto":"'.cv($fProducto[2]).'","precioUnitario":"'.$precioUnitario.'","tasaIVA":"'.$fProducto[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
			$arrRegistros="[".$arrRegistros."]";
			
			
			
		}
		else
		{
			$rProducto=$con->obtenerFilas($consulta);	
			while($fProducto=mysql_fetch_row($rProducto))
			{
				$datosProducto=obtenerDatosProducto($fProducto[0],$fProducto[1],0,$tipoCliente,$idCliente);
				$precioUnitario=$datosProducto["costoUnitario"]*(($datosProducto["porcentajeIVA"]/100)+1);
				$descuento=buscarDescuentoProducto($tipoCliente,$idCliente,$fProducto[0],$fProducto[1]);
				if(($descuento["pDescuento"]!="")&&($descuento["pDescuento"]!=0))
				{
					$precioUnitario-=$descuento["pDescuento"];
				
				}
				$o='{"unidadMedida":"'.$datosProducto["unidadMedida"].'","arrUnidadesMedida":'.$datosProducto["arrUnidadesMedida"].',"codigoAlterno":"'.$fProducto[5].'","codigoBarras":"'.$fProducto[4].'","idProducto":"'.$fProducto[0].'","llave":"'.$fProducto[1].
					'","nombreProducto":"'.cv($fProducto[2]).'","precioUnitario":"'.$precioUnitario.'","tasaIVA":"'.$fProducto[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
			$arrRegistros="[".$arrRegistros."]";
			
		}
		echo '{"numReg":"'.$numReg.'","registros":'.$arrRegistros.'}';	
		
	}
	
	function registrarDevolucionesProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$arrDevoluciones=array();	
		$c=NULL;
		$consulta="SELECT idProveedor,total FROM 6930_pedidos WHERE idPedido=".$obj->idPedido;
		$fVenta=$con->obtenerPrimeraFila($consulta);
		$idProveedor=$fVenta[0];
		
		$query[$x]="INSERT INTO 6951_devolucionesProveedor(fechaRegistro,responsableRegistro,idProveedor,subtotal,iva,total,idMotivoDevolucion,comentarios,idPedido)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idProveedor.",".$obj->subtotal.",".$obj->iva.",".$obj->total.",".$obj->idMotivoDevolucion.",'".
					cv($obj->comentarios)."',".$obj->idPedido.")";
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		
		$consulta="SELECT idAdeudo FROM 6942_adeudos WHERE tipoAdeudo=2 AND idReferencia=".$obj->idPedido;
		$idAdeudo=$con->obtenerValor($consulta);

		if($idAdeudo!="")
		{
			$folioAbono=generarNombreArchivoTemporal(1,"");
			$query[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,datosComp,horaAbono,idResponsableCobro,idCaja,subtotal,iva,comentarios,folioAbono)
						VALUES(".$obj->total.",'".date("Y-m-d")."',".$idAdeudo.",6,concat('{\"idDevolucion\":\"',@idRegistro,'\"}'),'".date("H:i:s")."','".$_SESSION["idUsr"]."',0,".$obj->subtotal.",".$obj->iva.",'','".$folioAbono."')";
			
			$x++;
			
			$consulta="select sum(montoAbono) from 6936_controlPagos where idAdeudo=".$idAdeudo;
			$montoAbonado=$con->obtenerValor($consulta);	
			
			$saldo=$fVenta[1]-$montoAbonado;
	
			
			$saldoVirtual=$saldo-$obj->total;
			
			
			
			if($saldoVirtual<=0)
			{
				$query[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=".$idAdeudo;
				$x++;
			}
			
			
			
			$query[$x]="set @idRegistroPago:=(select last_insert_id())";
			$x++;
			
		}
		
		
		$objAsiento='{
						  "tipoMovimiento":"36",
						  "cantidadOperacion":"",
						  "idProducto":"",
						  "tipoReferencia":"5",
						  "datoReferencia1":"-1",
						  "datoReferencia2":"",
						  "complementario":"",
						  "dimensiones":null
					  }';
		
		foreach($obj->arrProductos as $p)
		{
			$query[$x]="INSERT INTO 6952_productosDevolucionProveedor(idProducto,llave,cantidad,subtotal,iva,total,idDevolucion)
						VALUES(".$p->idProducto.",'".$p->llave."',".$p->cantidad.",".$p->subtotal.",".$p->iva.",".$p->total.",@idRegistro)";
			$x++;
			$consulta="SELECT idAlmacen from 6901_catalogoProductos WHERE idProducto=".$p->idProducto;
			$idAlmacen=$con->obtenerValor($consulta);
			$c=new cAlmacen($idAlmacen);
			$oProducto=json_decode($objAsiento);
			
			$oProducto->cantidadOperacion=$p->cantidad;
			
			
			$oProducto->idProducto=$p->idProducto;
			$oProducto->dimensiones=convertirLlaveDimensiones($p->llave);
			array_push($arrDevoluciones,$oProducto);
		}
		
		$c->asentarArregloMovimientos($arrDevoluciones,$query,$x,true);
		
		
		
		
		
		
		$query[$x]="commit";
		
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$idDevolucion=$con->obtenerValor($consulta);
			echo "1|".$idDevolucion;	
		}
		
	}
	
	function obtenerDevolucionesProveedor()
	{
		global $con;
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		
		$registros="";
		$consulta="select * from (SELECT idDevolucionProveedor as idDevolucion,a.total AS montoTotal ,
					fechaRegistro,a.idProveedor,	CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',IF(apMaterno IS NULL,'',apMaterno),' ',razonSocial) AS proveedor,p.idPedido,p.total,idMotivoDevolucion

					FROM 6951_devolucionesProveedor  a,6927_empresas e,6930_pedidos p WHERE 
					  e.idEmpresa=a.idProveedor and p.idPedido=a.idPedido) as tmp where 1=1 and  ".$condWhere;	
			  
		$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		
		$consulta.=" limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))			  
		{
			$consulta="SELECT idProducto,llave,cantidad,subtotal,iva,total FROM 6952_productosDevolucionProveedor WHERE idDevolucion=".$fila[0];
			$resProductos=$con->obtenerFilas($consulta);
			$tblDescripcion="<table><tr><td width=230>Producto</td><td width=110>Cantidad</td><td width=110>Subtotal</td><td width=110>IVA</td><td width=110>Total</td></tr>";
			while($fProducto=mysql_fetch_row($resProductos))
			{
				$datosProducto=obtenerDatosProducto($fProducto[0],$fProducto[1],0,0,0);

				$tblDescripcion.="<tr height='21'><td>".cv($datosProducto["nombreProducto"])."</td><td>".number_format($fProducto[2],2)."</td><td>$ ".number_format($fProducto[3],2).
								"</td><td>".number_format($fProducto[4],2)."</td><td>$ ".number_format($fProducto[5],2)."</td></tr>";
			}
		
		
			$tblDescripcion.="</table>";	
			
			$tblDescripcion.="<tr></tr>";

			$obj='{"idDevolucion":"'.$fila[0].'","montoTotal":"'.$fila[1].'","fechaRegistro":"'.$fila[2].'","idProveedor":"'.$fila[3].
					'","rfc":"'.cv($fila[4]).'","proveedor":"'.cv($fila[5]).'","descripcion":"'.$tblDescripcion.'","idPedido":"'.$fila[6].'","total":"'.$fila[7].'","montoFinal":"'.($fila[7]-$fila[1]).'","idMotivoDevolucion":"'.$fila[8].'"}';
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;

		}
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';		
	}
		
	function obtenerDatosSolicitudPedido()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$consulta="SELECT idProducto,llave,(SELECT descripcionProducto FROM 6932_descripcionProducto WHERE idProducto=p.idProducto AND llave=p.llave) AS producto,precioUnitario AS costoUnitario,
				IF(subtotal IS NULL,0,subtotal) AS subtotal,IF(iva IS NULL,0,iva) AS iva,cantidad,total,tasaIVA,idUnidadMedida as unidadMedida
				 FROM 6931_productosPedido p WHERE idPedido=".$idPedido;
		$arrProductos=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT comentariosAdicionales FROM 6930_pedidos WHERE idPedido=".$idPedido;
		$comentarios=$con->obtenerValor($consulta);
		echo '1|{"arrProductos":'.$arrProductos.',"comentarios":"'.cv($comentarios).'"}';
		
	}
	
	function obtenerBajaProductos()
	{
		global $con;
		$condWhere="1=1";
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$consulta="SELECT idBaja,fechaBaja,u.Nombre,
					d.descripcionProducto,
					cantidadBaja,idMotivoBaja,comentariosAdicionales,unidadMedida FROM 6962_bajasProductoAlmacen p,800_usuarios u,6932_descripcionProducto d WHERE u.idUsuario=p.idUsuarioResponsable
					AND idAlmacen IN (".$idAlmacen.") AND d.idProducto=p.idProducto AND d.llave=p.llave and ".$condWhere." limit ".$start.",".$limit;
			
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		$consulta="SELECT idBaja,fechaBaja,u.Nombre,
					d.descripcionProducto,
					cantidadBaja,idMotivoBaja,comentariosAdicionales,unidadMedida FROM 6962_bajasProductoAlmacen p,800_usuarios u,6932_descripcionProducto d WHERE u.idUsuario=p.idUsuarioResponsable
					AND idAlmacen IN (".$idAlmacen.") AND d.idProducto=p.idProducto AND d.llave=p.llave";
					
		$con->obtenerFilas($consulta);	
		$numReg=$con->filasAfectadas;
		
		
					
		
		
		echo '{"numReg":"'.$numReg.'","registros":'.$registros.'}';		

	}
	
	function obtenerExistenciaProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$idAlmacen=$_POST["idAlmacen"];
		$arrDimensiones=convertirLlaveDimensiones($llave);
		$tExistencia=obtenerTiempoExistencia($idAlmacen);
		$a=new cAlmacen($idAlmacen);
		$arrExistencia=$a->obtenerCantidadTiempoMovimientoV2($idProducto,$tExistencia,$arrDimensiones);
		$existencia="";
		
		if(sizeof($arrExistencia)==0)
		{
			$consulta="SELECT idUnidadMedida FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
			$unidadBase=$con->obtenerValor($consulta);
			$consulta="SELECT IF(abreviatura='' OR abreviatura IS NULL,u.unidadMedida,CONCAT('(',u.abreviatura,') ',u.unidadMedida)) AS unidadMedida 
						FROM 6923_unidadesMedida u WHERE u.idUnidadMedida=".$unidadBase;
			$unidad=$con->obtenerValor($consulta);
			$existencia="0 ".$unidad;
		}
		else
		{
			foreach($arrExistencia as $e)
			{
				
				if($existencia=="")
				{
					$existencia=removerCerosDerecha(number_format($e["cantidadEquivalencia"],6))." ".$e["lblUnidadMedida"];
				}
				else
					$existencia.=", ".removerCerosDerecha(number_format($e["cantidadEquivalencia"],6))." ".$e["lblUnidadMedida"];
			}
		}
		
		echo "1|".$existencia;
		
		
		
	}
	
	function obtenerDatosPedidoDevolucion()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		
		$consulta="	select CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,	CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',IF(apMaterno IS NULL,'',apMaterno),' ',razonSocial) AS proveedo,p.idAlmacen,
		p.total from 6927_empresas e, 6930_pedidos p where e.idEmpresa=p.idProveedor and p.idPedido=".$idPedido;
		$fPedido=$con->obtenerPrimeraFila($consulta);
		if($fPedido)
		{
			$idAlmacen=$fPedido[2];
			
			$a=new cAlmacen($idAlmacen);
			
					 
			$consulta="select idDevolucionProveedor  from 6951_devolucionesProveedor where idPedido=".$idPedido;		 
			$listDevoluciones=$con->obtenerListaValores($consulta);
			if($listDevoluciones=="")
				$listDevoluciones=-1;
			$arrProductos="";
			$consulta="SELECT idProducto,llave,(SELECT descripcionProducto FROM 6932_descripcionProducto WHERE idProducto=p.idProducto AND llave=p.llave) AS producto,precioUnitario AS costoUnitario,IF(subtotal IS NULL,0,subtotal) AS subtotal,IF(iva IS NULL,0,iva) AS iva,cantidad,total
					 FROM 6931_productosPedido p WHERE idPedido=".$idPedido;
			
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
			
				$arrDimensiones=convertirLlaveDimensiones($fila[1]);
				$tExistencia=obtenerTiempoExistencia($idAlmacen);
				$existencia=$a->obtenerCantidadTiempoMovimiento($fila[0],$tExistencia,$arrDimensiones);
				
				$consulta="select sum(cantidad) from 6952_productosDevolucionProveedor where idProducto=".$fila[0]." and llave='".$fila[1]."' and idDevolucion in (".$listDevoluciones.")";
				$nDevueltos=$con->obtenerValor($consulta);
				if($nDevueltos=="")
					$nDevueltos=0;
				
			
				$disponibles=$fila[6]-$nDevueltos;
				if($existencia<$disponibles)
					$disponibles=$existencia;
		
				$o="['".cv($fila[0])."','".cv($fila[1])."','".cv($fila[2])."','".cv($fila[3])."','".cv($fila[4])."','".cv($fila[5])."','".cv($fila[6])."','".cv($fila[7])."','".$disponibles."','0']";
				if($arrProductos=="")
					$arrProductos=$o;
				else
					$arrProductos.=",".$o;
			}
			
			//$con->obtenerFilasArreglo($consulta);
			
			
			
			echo '1|{"totalPedido":"'.$fPedido[3].'","arrProductos":['.$arrProductos.'],"proveedor":"'.cv($fPedido[0]).' '.cv($fPedido[1]).'"}';
		}
		else
			echo "1|0";
	}	
	
	function obtenerPedidosProveedorRecibidos()
	{
		global $con;
		$idProveedor=$_POST["iProveedor"];
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		$consulta="SELECT idPedido,idPedido AS folioPedido,fechaPedido,fechaRealEntrega,total FROM 6930_pedidos 
					WHERE idProveedor=".$idProveedor." and situacion=3 and ".$condWhere." ORDER BY fechaPedido DESC";
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idProducto,llave,cantidad,subtotal,iva,total FROM 6931_productosPedido WHERE idPedido=".$fila[0];
			$resProductos=$con->obtenerFilas($consulta);
			$tblDescripcion="<table><tr><td width=230>Producto</td><td width=110>Cantidad</td><td width=110>Subtotal</td><td width=110>IVA</td><td width=110>Total</td></tr>";
			while($fProducto=mysql_fetch_row($resProductos))
			{
				
				$consulta="SELECT descripcionProducto FROM 6932_descripcionProducto WHERE idProducto=".$fProducto[0]." AND llave='".$fProducto[1]."'";
				$descripcion=$con->obtenerValor($consulta);
				$tblDescripcion.="<tr height='21'><td>".cv($descripcion)."</td><td>".number_format($fProducto[2],2)."</td><td>$ ".number_format($fProducto[3],2).
								"</td><td>".number_format($fProducto[4],2)."</td><td>$ ".number_format($fProducto[5],2)."</td></tr>";
			}
		
		
			$tblDescripcion.="</table>";	
			$o='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","fechaPedido":"'.$fila[2].'","fechaRealEntrega":"'.$fila[3].'","total":"'.$fila[4].
				'","detallePedido":"'.$tblDescripcion.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarBajaProductoAlmacen()
	{
		global $con;
		$cadObj=$_POST ["cadObj"];
		$obj=json_decode($cadObj);

	

		$llaveOperacion=rand(0,1000)."_".date("Y_m_d_H_i_s");

		$cA=new cAlmacen($obj->idAlmacen);	
		
		//$query="SELECT idTiempoMovimiento FROM 6902_tiempoMovimientosAlmacen WHERE referencienciaExistencia=1";
		$tPresupuestal=21; //Reemplazar
		$eExistencia=$cA->existeSuficienciaTiempoMovimientoV2($obj->idProducto,$obj->cantidad,$obj->unidadMedida,$tPresupuestal,convertirLlaveDimensiones($obj->llave));
		if(!$eExistencia)
		{
			echo "2|";
			return;
		}
			
		
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';	

		$x=0;
		$consulta[$x]="begin";
		$x++;

		$consulta[$x]="INSERT INTO 6962_bajasProductoAlmacen(idUsuarioResponsable,fechaBaja,idProducto,llave,cantidadBaja,unidadMedida,idMotivoBaja,comentariosAdicionales,idAlmacen)
				VALUES(".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',".$obj->idProducto.",'".$obj->llave."',".$obj->cantidad.",".$obj->unidadMedida.",".$obj->motivoBaja.",'".
				cv($obj->comentarios)."',".$obj->idAlmacen.")";
		$x++;
		
		$consulta[$x]="set @idBaja:=(select last_insert_id())";
		$x++;
		
		$oM=json_decode($cM);
		$oM->tipoMovimiento=6;
		$oM->cantidadOperacion=$obj->cantidad;
		$oM->unidadMedida=$obj->unidadMedida;
		$oM->idProducto=$obj->idProducto;
		$oM->llaveProducto=$obj->llave;
		$oM->tipoReferencia=5;
		$oM->datoReferencia1=$llaveOperacion;
		
		array_push($arrMovimientos,$oM);
		
		$cA->asentarArregloMovimientos($arrMovimientos,$consulta,$x);
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idBaja WHERE datoReferencia1='".$llaveOperacion."' AND idAlmacen=".$obj->idAlmacen;
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;
		
		
		eB($consulta);
		
	}
	
	function guardarDescuentoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->aRegistros as $r)
		{
			$consulta[$x]="INSERT INTO 6954_descuentosProducto(porcentajeDescuento,idProducto,llave,descripcionDescuento,fechaInicio,fechaTermino,
							responsableRegistro,fechaRegistro,situacion,tipoDescuento)
							VALUES(".$r->descuento.",".$r->idProducto.",'".$r->llave."','".cv($r->descripcion)."','".$r->fechaInicio."','".$r->fechaTermino.
							"',".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',1,".$r->tipoDescuento.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDescuentosProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$tipoDescuento=$_POST["tipoDescuento"];
		
		$consulta="SELECT idDescuentoProducto AS idDescuento,porcentajeDescuento,descripcionDescuento,fechaInicio,fechaTermino,fechaRegistro,situacion,motivoCancelacion 
					FROM 6954_descuentosProducto WHERE idProducto=".$idProducto." AND llave='".$llave."' and tipoDescuento=".$tipoDescuento." ORDER BY fechaInicio DESC";	
					
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));			
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';					
	}
	
	function removerDescuentoProducto()
	{
		global $con;
		$idDescuento=$_POST["idDescuento"]	;
		$consulta="DELETE FROM 6954_descuentosProducto WHERE idDescuentoProducto=".$idDescuento;
		eC($consulta);
		
	}
	
	function finalizarDescuento()
	{
		global $con;
		$idDescuento=$_POST["idDescuento"]	;
		$motivoCancelacion=$_POST["motivoCancelacion"];
		$fechaTermino=$_POST["fechaTermino"];
		$situacion=1;
		$consulta="select fechaInicio from 6954_descuentosProducto WHERE idDescuentoProducto=".$idDescuento;
		$fechaInicio=$con->obtenerValor($consulta);
		if(($fechaTermino==$fechaInicio)||($fechaTermino==date("Y-m-d")))
		{
			$situacion=0;
		}
		$consulta="update 6954_descuentosProducto set situacion=".$situacion.",fechaTermino='".$fechaTermino."',motivoCancelacion='".cv($motivoCancelacion)."',fechaCambio='".date("Y-m-d H:i:s")."',idResponsableCambio=".$_SESSION["idUsr"]."  WHERE idDescuentoProducto=".$idDescuento;
		eC($consulta);
			
	}
		
	function registrarAltaProductoAlmacen()
	{
		global $con;
		$cadObj=$_POST ["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="INSERT INTO 6955_productosAltas(fechaAlta,idResponsableAlta,idProducto,llave,cantidadAlta,idMotivoAlta,comentariosAdicionales,idAlmacen)
				VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idProducto.",'".$obj->llave."',".$obj->cantidad.",".$obj->motivoAlta.",'".cv($obj->comentarios)."',".$obj->idAlmacen.")";
		if($con->ejecutarConsulta($consulta))		
		{
			$idBaja=$con->obtenerUltimoID();
			$objAsiento='{
							  "tipoMovimiento":"37",
							  "cantidadOperacion":"",
							  "idProducto":"",
							  "tipoReferencia":"7",
							  "datoReferencia1":"-1",
							  "datoReferencia2":"",
							  "complementario":"",
							  "dimensiones":null
						  }';
			
			$arrDevoluciones=array();
			$c=new cAlmacen($obj->idAlmacen);
			$oProducto=json_decode($objAsiento);
			
			$oProducto->cantidadOperacion=$obj->cantidad;
			$oProducto->idProducto=$obj->idProducto;
			
			$oProducto->dimensiones=convertirLlaveDimensiones($obj->llave);
			$oProducto->datoReferencia1=$idBaja;
			array_push($arrDevoluciones,$oProducto);
		
			$c->asentarArregloMovimientos($arrDevoluciones);
			echo "1|";
		}
	}
	
	function obtenerAltaProductos()
	{
		global $con;
		$condWhere="1=1";
		$idAlmacen=$_POST["idAlmacen"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$consulta="SELECT idAltaProducto,fechaAlta,u.Nombre,
					d.descripcionProducto,
					cantidadAlta,idMotivoAlta,comentariosAdicionales FROM 6955_productosAltas p,800_usuarios u,6932_descripcionProducto d WHERE u.idUsuario=p.idResponsableAlta
					AND idAlmacen IN (".$idAlmacen.") AND d.idProducto=p.idProducto AND d.llave=p.llave and ".$condWhere." limit ".$start.",".$limit;
			
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		$consulta="SELECT idAltaProducto,fechaAlta,u.Nombre,
					d.descripcionProducto,
					cantidadAlta,idMotivoAlta,comentariosAdicionales FROM 6955_productosAltas p,800_usuarios u,6932_descripcionProducto d WHERE u.idUsuario=p.idResponsableAlta
					AND idAlmacen IN (".$idAlmacen.") AND d.idProducto=p.idProducto AND d.llave=p.llave";
					
		$con->obtenerFilas($consulta);	
		$numReg=$con->filasAfectadas;
		
		
					
		
		
		echo '{"numReg":"'.$numReg.'","registros":'.$registros.'}';		

	}
		
	function buscarProductoAlmacen()
	{
		global $con;	
		$valorBusqueda=$_POST["valorBusqueda"];
		$tipoBusqueda=$_POST["tipoBusqueda"];
		$idAlmacen=0;
		if(isset($_POST["idAlmacen"]))
			$idAlmacen=$_POST["idAlmacen"];
		
		$arrCategorias="";
		if(isset($_POST["arrCategorias"]))	
			$arrCategorias=$_POST["arrCategorias"];
		
		
		$idZona=0;
		
		if(isset($_POST["idZona"]))
			$idZona=$_POST["idZona"];
		
		
		$tipoCliente=1;
		if(isset($_POST["tipoCliente"]))
			$tipoCliente=$_POST["tipoCliente"];
		$idCliente=-1;
		if(isset($_POST["idCliente"]))
			$idCliente=$_POST["idCliente"];
		
		
		$buscarPrecio=0;
		if(isset($_POST["buscarPrecio"]))
			$buscarPrecio=$_POST["buscarPrecio"];
		
		
		$numReg=0;
		$consulta="";
		switch($tipoBusqueda)
		{
			case 1:
				$consulta="SELECT p.idProducto,llaveProducto,clave,categoriaIVA from 6910_clavesProductos c,6901_catalogoProductos p WHERE tipoClave=2 AND clave='".$valorBusqueda."' and p.idProducto=c.idProducto and p.situacion=1";
			break;
			case 2:
				$consulta=" SELECT p.idProducto,llave,descripcionProducto,categoriaIVA FROM 6932_descripcionProducto d,6901_catalogoProductos p WHERE descripcionProducto LIKE '%".$valorBusqueda."%' and p.idProducto=d.idProducto and p.situacion=1";
			break;
		}
		if($idAlmacen!=0)
		{
			$consulta.=" and idAlmacen=".$idAlmacen;	
		}
		
		if($arrCategorias!="")
		{
			$consulta.=" and categoria in(".$arrCategorias.")";
		}
	

		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		
		$arrProductos=array();
		while($fila=mysql_fetch_row($res))
		{
			$oProducto=array();
			
			$oProducto["idProducto"]=$fila[0];
			$oProducto["llave"]=$fila[1];
			$consulta="SELECT porcentajeIVA FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$fila[3]." AND idZona=".$idZona." AND fechaInicio<='".date("Y-m-d")."' ORDER BY fechaInicio DESC";

			$oProducto["tasaIVA"]=$con->obtenerValor($consulta);
			
			if(trim($oProducto["tasaIVA"])=="")
				$oProducto["tasaIVA"]=0;
				

			$llaveProd=$fila[0]."_".$fila[1];
			
			if($tipoBusqueda==1)
			{
				$oProducto["codigoAlterno"]=$fila[2];
				
				$consulta="SELECT descripcionProducto FROM 6932_descripcionProducto WHERE idProducto=".$fila[0]." and llave='".$fila[1]."'";
				
				
				$oProducto["descripcion"]=$con->obtenerValor($consulta);
				
			}
			else
			{
				$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$fila[0]." and llaveProducto='".$fila[1]."' and tipoClave=2";
				
				
				$oProducto["codigoAlterno"]=$con->obtenerValor($consulta);
				$oProducto["descripcion"]=$fila[2];
				
			}
			$arrProductos[$llaveProd]=$oProducto;
		}
		
		ksort($arrProductos);
		
		foreach($arrProductos as $llaveProducto=>$p)
		{
			$datosProducto=obtenerDatosProducto($p["idProducto"],$p["llave"],0,$tipoCliente,$idCliente);
			$precioUnitario=$datosProducto["costoUnitario"]*(($datosProducto["porcentajeIVA"]/100)+1);
			$descuento=buscarDescuentoProducto($tipoCliente,$idCliente,$p["idProducto"],$p["llave"]);
			if(($descuento["pDescuento"]!="")&&($descuento["pDescuento"]!=0))
			{
				$precioUnitario-=$descuento["pDescuento"];
			}
				
			
			$o='{"idUnidadMedida":"'.$datosProducto["unidadMedida"].'","arrUnidadesMedida":'.$datosProducto["arrUnidadesMedida"].',"llaveProducto":"'.$llaveProducto.'","tasaIVA":"'.$p["tasaIVA"].'","idProducto":"'.$p["idProducto"].'","llave":"'.$p["llave"].'","codigoAlterno":"'.cv($p["codigoAlterno"]).'","descripcion":"'.cv($p["descripcion"]).'","precioUnitario":"'.$precioUnitario.'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function buscarDatosProductoClave()
	{
		global $con;
		$arrProductos=array();
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		
		
		
		$consulta="SELECT distinct idProducto,llave FROM 6911_costosProductos WHERE idProducto=".$idProducto." and llave='".$llave."'";
  
		$res=$con->obtenerFilas($consulta);
		while($fDatos=mysql_fetch_row($res))
		{
			$regProducto=array();
			$regProducto["dimensiones"]=array();
			$archivoImagen="";
			$datosProducto=obtenerDatosProducto($fDatos[0],$fDatos[1],-1,1,-1);

			$regProducto["cveProducto"]="";
			$regProducto["codigoAlterno"]="";
			
			$consulta="SELECT clave FROM 6910_clavesProductos WHERE idProducto=".$idProducto." AND llaveProducto='".$llave."' AND tipoClave=2";

			$regProducto["codigoAlterno"]=$con->obtenerValor($consulta);
			
			$regProducto["idProducto"]=$fDatos[0];
			$regProducto["cantidad"]=1;
			$regProducto["tipoConcepto"]=1;
			$regProducto["llaveProducto"]=$fDatos[1];
			$regProducto["tipoMovimiento"]="";
			
			$regProducto["concepto"]=$datosProducto["nombreProducto"];
			$regProducto["descripcion"]=$datosProducto["descripcion"];
			$regProducto["costoUnitario"]=$datosProducto["costoUnitario"];
			$regProducto["porcentajeIVA"]=$datosProducto["porcentajeIVA"];
			$regProducto["unidadMedida"]=$datosProducto["unidadMedida"];
			$regProducto["descuento"]=0;
			$descuento=buscarDescuentoProductoAlmacen(1,-1,$regProducto["idProducto"],$fDatos[1]);
			if(($descuento["pDescuento"]!="")&&($descuento["pDescuento"]!=0))
			{
				$regProducto["descuento"]=$regProducto["costoUnitario"]*($descuento["pDescuento"]/100);
				
			}
			
  
			
			
			$regProducto["imagen"]="[]";
			if(sizeof($datosProducto["imagenes"])>0)
			{
				$aImagen="";
				foreach($datosProducto["imagenes"] as $i)	
				{
					$dI='{"imagen":"'.$i.'"}';
					if($aImagen=="")
						$aImagen=$dI;
					else
						$aImagen.=",".$dI;
				}
				$regProducto["imagen"]="".$aImagen."";
			}
			$regProducto["detalle"]="";
			
			array_push($arrProductos,$regProducto);
			
		}
		
		$arrObj="";
		$metaData="";
		if(($arrProductos)&&(sizeof($arrProductos)>0))
		{
			foreach($arrProductos as $fProducto)
			{
				if(isset($fProducto["metaData"]))
				{
					$metaData=$fProducto["metaData"];
				}
				else
				{
					
					$dimensiones="";
					if($fProducto["dimensiones"]!="")
						$dimensiones=bE(serialize($fProducto["dimensiones"]));
					$padre="null";
					if(isset($fProducto["padre"])&&($fProducto["padre"]!="")&&($fProducto["padre"]!="-1"))
					{
						$padre=$fProducto["padre"];
					}
					$hoja="true";
					
					if(isset($fProducto["hoja"])&&($fProducto["hoja"]!="")&&($fProducto["hoja"]!="-1"))
					{
						$hoja=$fProducto["hoja"];
					}
					
					if(!isset($fProducto["subtotal"]))
						$fProducto["subtotal"]="";
						
					if(!isset($fProducto["iva"]))
						$fProducto["iva"]="";
					
					if(!isset($fProducto["total"]))
						$fProducto["total"]="";
					
					$idRegistro=-1;
					if(isset($fProducto["idRegistro"]))
					{
						$idRegistro=$fProducto["idRegistro"];
					}
					$sL=0;
					if(isset($fProducto["sL"]))
						$sL=$fProducto["sL"];
					$numDevueltos=0;
					if(isset($fProducto["numDevueltos"]))
						$numDevueltos=$fProducto["numDevueltos"];
					if($fProducto["imagen"]=="[]")	
						$fProducto["imagen"]="";
						
					$descuento=0;
					if(isset($fProducto["descuento"]))	
						$descuento=$fProducto["descuento"];
					$oProducto='{"codigoAlterno":"'.$fProducto["codigoAlterno"].'","unidadMedida":"'.$fProducto["unidadMedida"].'","descuento":"'.$descuento.'","numDevueltos":"'.$numDevueltos.'","sL":"'.$sL.'","idRegistro":"'.$idRegistro.'","llave":"'.$fProducto["llaveProducto"].'","porcentajeIVA":"'.$fProducto["porcentajeIVA"].'","descripcion":"'.cv($fProducto["descripcion"]).'","cveProducto":"'.cv($fProducto["cveProducto"]).'","concepto":"'.cv($fProducto["concepto"]).'","costoUnitario":"'.$fProducto["costoUnitario"].'","cantidad":"'.$fProducto["cantidad"].'","subtotal":"'.$fProducto["subtotal"].'","iva":"'.$fProducto["iva"].
							'","total":"'.$fProducto["total"].'","imagen":['.$fProducto["imagen"].'],"tipoConcepto":"'.$fProducto["tipoConcepto"].'","idProducto":"'.$fProducto["idProducto"].'","detalle":['.($fProducto["detalle"]).'],"tipoMovimiento":"'.
							$fProducto["tipoMovimiento"].'","dimensiones":"'.$dimensiones.'","_parent":'.$padre.',"_is_leaf":'.$hoja.'}';
				
					
					if($arrObj=="")
					{
						$arrObj=$oProducto;	
					}
					else
						$arrObj.=",".$oProducto;	
				}
			}
		}
		echo '1|['.$arrObj.']|'.$metaData;	
	}
	
	function obtenerUnidadesMedidaEquivalente()
	{
		global $con;
		$idUnidadMedida=$_POST["idUnidadMedida"];
		
		
		$o="";
		$arrRegistros="";
		$consulta="SELECT u.idUnidadMedida,IF(abreviatura='' OR abreviatura IS NULL,unidadMedida,CONCAT('(',abreviatura,') ',unidadMedida)) AS unidadMedida,e.cantidad FROM 6923_unidadesMedida u,6923_equivalenciasUnidadesMedida e
					WHERE u.idUnidadMedida=e.idUnidadEquivalencia AND e.idUnidadMedida=".$idUnidadMedida;

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$nodoHoja="true";
			$arrHijos=obtenerUnidadesMedidaHijos($fila[0],$fila[2]);
			if($arrHijos!="[]")
				$nodoHoja="false";
				
			
			$o='{"icon":"../images/s.gif","id":"'.$fila[0].'","text":"'.cv($fila[1]).'","cantidad":"'.removerCerosDerecha(number_format($fila[2],5)).'",leaf:'.$nodoHoja.',children:'.$arrHijos.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
		
	}
	
	function obtenerUnidadesMedidaHijos($idUnidadMedida,$cantidadEquivalencia)
	{
		global $con;
		$o="";
		$arrRegistros="";
		$consulta="SELECT u.idUnidadMedida,IF(abreviatura='' OR abreviatura IS NULL,unidadMedida,CONCAT('(',abreviatura,') ',unidadMedida)) AS unidadMedida,e.cantidad FROM 6923_unidadesMedida u,6923_equivalenciasUnidadesMedida e
					WHERE u.idUnidadMedida=e.idUnidadEquivalencia AND e.idUnidadMedida=".$idUnidadMedida;

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$equivalencia=$fila[2]*$cantidadEquivalencia;
			$nodoHoja="true";
			$arrHijos=obtenerUnidadesMedidaHijos($fila[0],$equivalencia);
			if($arrHijos!="[]")
				$nodoHoja="false";
				
			
			$o='{"icon":"../images/s.gif","id":"'.$fila[0].'","text":"'.cv($fila[1]).'","cantidad":"'.removerCerosDerecha(number_format($equivalencia,5)).'",leaf:'.$nodoHoja.',children:'.$arrHijos.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		return '['.$arrRegistros.']';
	}
	
	function obtenerUnidadesMedidaDisponibles()
	{
		global $con;
		$idUnidadMedida=$_POST["iU"];
		
		$consulta="SELECT u.idUnidadMedida,IF(abreviatura='' OR abreviatura IS NULL,unidadMedida,CONCAT('(',abreviatura,') ',unidadMedida)) AS unidadMedida FROM 6923_unidadesMedida u
					WHERE u.idUnidadMedida NOT IN (SELECT idUnidadEquivalencia FROM 6923_equivalenciasUnidadesMedida WHERE idUnidadMedida=".$idUnidadMedida.") and u.idUnidadMedida<>".$idUnidadMedida." 
					order by u.unidadMedida";
		
		$arrUnidades=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="SELECT u.idUnidadMedida,IF(abreviatura='' OR abreviatura IS NULL,unidadMedida,CONCAT('(',abreviatura,') ',unidadMedida)) AS unidadMedida FROM 6923_unidadesMedida u
					WHERE  idUnidadMedida<>".$idUnidadMedida." order by u.unidadMedida";
		
		$arrUnidadesTotales=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrUnidades."|".$arrUnidadesTotales;
		
		
	}
		
	function agregarUnidadMedidaEquivalencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		$consulta="SELECT idEquivalencia FROM 6923_equivalenciasUnidadesMedida WHERE idUnidadMedida=".$obj->idUnidadMedida." AND idUnidadEquivalencia= ".$obj->idUnidadEquivalencia;
		$idEquivalencia=$con->obtenerValor($consulta);
		
		if($idEquivalencia=="")
		{
			$consulta="INSERT INTO 6923_equivalenciasUnidadesMedida(idUnidadMedida,idUnidadEquivalencia,cantidad) VALUES(".$obj->idUnidadMedida.",".$obj->idUnidadEquivalencia.",".$obj->cantidad.")";
		}
		else
		{
			$consulta="update 6923_equivalenciasUnidadesMedida set idUnidadEquivalencia=".$obj->idUnidadEquivalencia.",cantidad=".$obj->cantidad." where idEquivalencia=".$idEquivalencia;	
		}
		
		eC($consulta);
		
	}
	
	function removerUnidadMedidaEquivalencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		
		
		$consulta="delete from 6923_equivalenciasUnidadesMedida where idUnidadMedida=".$obj->idUnidadMedida." AND idUnidadEquivalencia= ".$obj->idUnidadEquivalencia;
		
		
		eC($consulta);
		
	}
	
	function buscarProveedorAlmacen()
	{
		global $con;	
		$nombre=$_POST["query"];
		$referencia=$_POST["ref"];
		$consulta="select * from (SELECT e.idEmpresa AS idProveedor,CONCAT('[',rfc1,'-',rfc2,'-',rfc3,'] ',
					CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',IF(apMaterno IS NULL,'',apMaterno),' ',razonSocial)) AS nombreProveedor 
					FROM 6927_empresas e,6927_categoriaEmpresa c where c.idEmpresa=e.idEmpresa and c.idCategoria=2 and referencia='".$referencia."') 
					as tmp where nombreProveedor like '%".$nombre."%' order by nombreProveedor";
					
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"num":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
		
	}
	
	function registrarCompraAlmacen()
	{
		global $con;
		
		$cT=new cTesoreria();
		
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);		
		
		$cA=new cAlmacen($obj->idAlmacen);
		
		$llavePedido=rand(0,1000)."_".date("Y_m_d_H_i_s");
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$diasPago="NULL";
		if($obj->diasPago!="")
			$diasPago=$obj->diasPago;
		
		$fechaLimite="NULL";
		if($obj->fechaLimite!="")
			$fechaLimite="'".$obj->fechaLimite."'";
		$consulta[$x]="INSERT INTO 6960_compras(fechaCreacion,responsableCreacion,fechaCompra,subtotalCompra,iva,total,situacion,idProveedor,
					comentariosAdicionales,idAlmacen,montoAbonado,diasPago,fechaLimitePago,formaPago)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->fechaCompra."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",1,".$obj->idProveedor.
					",'".cv($obj->comentarios)."',".$obj->idAlmacen.",".$obj->montoAbonado.",".$diasPago.",".$fechaLimite.",".$obj->formaPago.")";
		$x++;
		$consulta[$x]="set @idCompra:=(select last_insert_id())";
		$x++;
		
		
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';
		

		foreach($obj->arrProductos as $p)
		{
			$consulta[$x]="INSERT INTO 6961_productosCompras(idCompra,idProducto,cantidad,precioUnitario,total,llave,tasaIVA,subtotal,iva,idUnidadMedida)
						VALUES(@idCompra,".$p->idProducto.",".$p->cantidad.",".$p->costoUnitario.",".$p->total.",'".$p->llave."',".$p->tasaIVA.",".$p->subtotal.",".$p->iva.",".$p->idUnidadMedida.")";
			$x++;
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=4;
			$oM->cantidadOperacion=$p->cantidad;
			$oM->unidadMedida=$p->idUnidadMedida;
			$oM->idProducto=$p->idProducto;
			$oM->llaveProducto=$p->llave;
			$oM->tipoReferencia=5;
			$oM->datoReferencia1=$llavePedido;
			
			array_push($arrMovimientos,$oM);
			
		}
		
		$cA->asentarArregloMovimientos($arrMovimientos,$consulta,$x);
		
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idCompra WHERE datoReferencia1='".$llavePedido."' AND idAlmacen=".$obj->idAlmacen;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idCompra";
			
			$idCompra=$con->obtenerValor($query);	
			
			if($obj->formaPago==2)
			{
				$fechaVencimiento=$obj->fechaLimite;
							
				$cAdeudo='{
							"tipoAdeudo":"5",
							"idReferencia":"'.$idCompra.'",
							"subtotal":"'.$obj->subtotal.'",
							"iva":"'.$obj->iva.'",
							"total":"'.$obj->total.'",
							"tipoCliente":"4",
							"idCliente":"'.$obj->idAlmacen.'",
							"fechaVencimiento":"'.$fechaVencimiento.'"
							
						}';
				$oAdeudo=json_decode($cAdeudo);
				
				$idAdeudo=$cT->registrarAdeudo($oAdeudo);
				
				if($obj->montoAbonado>0)
				{
					$cAbono='	{
									"montoAbono":"'.$obj->montoAbonado.'",
									"idAdeudo":"'.$idAdeudo.'",
									"formaPago":"1",
									"datosComp":"",
									"idCaja":"0",
									"tipoOperacion":"-1",
									"comentarios":"",
									"idComprobante":""
								}
							';
						
					$oAbono=json_decode($cAbono);
					$idAdeudo=$cT->registrarAbonoAdeudo($oAbono);
					
					
				}	
			}
			
			echo "1|".$idCompra;
		}
		
	}
	
	function obtenerComprasAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$situacion=$_POST["situacion"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$start=$_POST["start"];
		$limit=$_POST["limit"];

		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		
		$consultaAux="SELECT  idCompra,fechaCreacion,fechaCompra,c.situacion,total,comentariosAdicionales,
					(SELECT idComprobante FROM 101_comprobantesPresupuestales WHERE idFactura=c.factura) as factura,
				CONCAT(e.rfc1,'-',e.rfc2,'-',e.rfc3) AS rfc,
				(IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial)) AS proveedor,c.idProveedor,c.formaPago,
				if(formaPago=1,total,(SELECT SUM(c.montoAbono) FROM 6942_adeudos a,6936_controlPagos c WHERE tipoAdeudo=5 AND 
				idReferencia=c.idCompra AND c.idAdeudo=a.idAdeudo))as montoAbonado
				FROM 6960_compras c,6927_empresas e WHERE e.idEmpresa=c.idProveedor and idAlmacen in (".$idAlmacen.") and c.situacion in (".$situacion.")";
				
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir." limit ".$start.",".$limit;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir;
		$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function registrarPedidosAlmacenV2()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$cT=new cTesoreria();
		
		$obj=json_decode($cadObj);		
		$cA=new cAlmacen($obj->idAlmacen);
		$llavePedido=rand(0,1000)."_".date("Y_m_d_H_i_s");
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$diasPago="NULL";
		if($obj->diasPago!="")
			$diasPago=$obj->diasPago;
		
		$fechaLimite="NULL";
		if($obj->fechaLimite!="")
			$fechaLimite="'".$obj->fechaLimite."'";
		$consulta[$x]="INSERT INTO 6930_pedidos(fechaCreacion,responsableCreacion,fechaPedido,subtotalPedido,ivaPedido,total,situacion,idProveedor,
					comentariosAdicionales,fechaEstimadaEntrega,idAlmacen,montoAbonado,diasPago,fechaLimitePago,formaPago)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$obj->fechaPedido."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",1,".$obj->idProveedor.
					",'".cv($obj->comentarios)."','".$obj->fechaEntrega."',".$obj->idAlmacen.",".$obj->montoAbonado.",".$diasPago.",".$fechaLimite.",".$obj->formaPago.")";
		$x++;
		$consulta[$x]="set @idPedido:=(select last_insert_id())";
		$x++;
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';
		
		foreach($obj->arrProductos as $p)
		{
			$consulta[$x]="INSERT INTO 6931_productosPedido(idPedido,idProducto,cantidad,precioUnitario,total,llave,tasaIVA,subtotal,iva,idUnidadMedida)
						VALUES(@idPedido,".$p->idProducto.",".$p->cantidad.",".$p->costoUnitario.",".$p->total.",'".$p->llave."',".$p->tasaIVA.",".$p->subtotal.",".$p->iva.",".$p->idUnidadMedida.")";
			$x++;
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=1;
			$oM->cantidadOperacion=$p->cantidad;
			$oM->unidadMedida=$p->idUnidadMedida;
			$oM->idProducto=$p->idProducto;
			$oM->llaveProducto=$p->llave;
			$oM->tipoReferencia=4;
			$oM->datoReferencia1=$llavePedido;
			
			array_push($arrMovimientos,$oM);
		}
		
		$cA->asentarArregloMovimientos($arrMovimientos,$consulta,$x);
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idPedido WHERE datoReferencia1='".$llavePedido."' AND idAlmacen=".$obj->idAlmacen;
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idPedido";
			
			$idPedido=$con->obtenerValor($query);	
		
		
			if($obj->formaPago==2)
			{
				$fechaVencimiento=$obj->fechaLimite;
				
				
				$cAdeudo='	{
								"tipoAdeudo":"4",
								"idReferencia":"'.$idPedido.'",
								"subtotal":"'.$obj->subtotal.'",
								"iva":"'.$obj->iva.'",
								"total":"'.$obj->total.'",
								"tipoCliente":"4",
								"idCliente":"'.$obj->idAlmacen.'",
								"fechaVencimiento":"'.$fechaVencimiento.'"
								
							}';
				$oAdeudo=json_decode($cAdeudo);
				
				$idAdeudo=$cT->registrarAdeudo($oAdeudo);
				
				
				
				if($obj->montoAbonado>0)
				{
					
					$cAbono='	{
									"montoAbono":"'.$obj->montoAbonado.'",
									"idAdeudo":"'.$idAdeudo.'",
									"formaPago":"1",
									"datosComp":"",
									"idCaja":"0",
									"tipoOperacion":"-1",
									"comentarios":"",
									"idComprobante":""
								}
							';
						
					$oAbono=json_decode($cAbono);
					$idAdeudo=$cT->registrarAbonoAdeudo($oAbono);
				}	
			}
			
			echo "1|".$idPedido;
		}
		
		
	}
	
	function registrarCancelacionPedidosAlmacenV2()
	{
		global $con;
		$idPedido=$_POST["idPedido"];
		$comentariosAdicionales=$_POST["cA"];
		$cT=new cTesoreria();		
		
		$query="SELECT idAlmacen,formaPago FROM 6930_pedidos WHERE idPedido=".$idPedido;
		$fPedido=$con->obtenerPrimeraFila($query);
		$formaPago=$fPedido[1];
		$idAlmacen=$fPedido[0];
		
		
		$oCancelacion=json_decode('{"comentariosAdicionales":""}');
		$oCancelacion->comentariosAdicionales="'".$comentariosAdicionales."'";
		$idCancelacion=$cT->registrarCancelacionOperacion($oCancelacion);

		
		$consulta=array();
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="UPDATE 6930_pedidos SET situacion=2,idCancelacion=".$idCancelacion." WHERE idPedido=".$idPedido;
		$x++;
		
		
		$cA=new cAlmacen($idAlmacen);	
		
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';		
		
		$query="SELECT * FROM 6931_productosPedido WHERE idPedido=".$idPedido;
		$res=$con->obtenerFilas($query);		
		
		while($fila=mysql_fetch_row($res))
		{
			
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=3;
			$oM->cantidadOperacion=$fila[3];
			$oM->unidadMedida=$fila[10];
			$oM->idProducto=$fila[2];
			$oM->llaveProducto=$fila[8];
			$oM->tipoReferencia=4;
			$oM->datoReferencia1=$idPedido;
			
			array_push($arrMovimientos,$oM);
		}		
		$cA->asentarArregloMovimientos($arrMovimientos,$consulta,$x);
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			if($formaPago==2)
			{
				
				$oA=json_decode(	'{
										"tipoAdeudo":"4",
										"idReferencia":"'.$idPedido.'"
									}'
								);
				
				
				$cT->cancelarAdeudo($oA);
				
			}
			echo "1|";
		}		
		
	}
	
	function registrarCancelacionCompraAlmacenV2()
	{
		global $con;
		$idCompra=$_POST["idCompra"];
		$comentariosAdicionales=$_POST["cA"];
		$cT=new cTesoreria();		
		
		$query="SELECT idAlmacen,formaPago FROM 6960_compras WHERE idCompra=".$idCompra;
		$fPedido=$con->obtenerPrimeraFila($query);
		$formaPago=$fPedido[1];
		$idAlmacen=$fPedido[0];
		
		
		$oCancelacion=json_decode('{"comentariosAdicionales":""}');
		$oCancelacion->comentariosAdicionales="'".$comentariosAdicionales."'";
		$idCancelacion=$cT->registrarCancelacionOperacion($oCancelacion);

		
		$consulta=array();
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="UPDATE 6960_compras SET situacion=2,idCancelacion=".$idCancelacion." WHERE idCompra=".$idCompra;
		$x++;
		
		
		$cA=new cAlmacen($idAlmacen);	
		
		$arrMovimientos=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';		
		
		$query="SELECT * FROM 6961_productosCompras WHERE idCompra=".$idCompra;
		$res=$con->obtenerFilas($query);		
		
		while($fila=mysql_fetch_row($res))
		{
			
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=5;
			$oM->cantidadOperacion=$fila[3];
			$oM->unidadMedida=$fila[10];
			$oM->idProducto=$fila[2];
			$oM->llaveProducto=$fila[8];
			$oM->tipoReferencia=5;
			$oM->datoReferencia1=$idCompra;
			
			array_push($arrMovimientos,$oM);
		}		
		$cA->asentarArregloMovimientos($arrMovimientos,$consulta,$x);
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			if($formaPago==2)
			{
				
				$oA=json_decode(	'{
										"tipoAdeudo":"5",
										"idReferencia":"'.$idCompra.'"
									}'
								);
				
				
				$cT->cancelarAdeudo($oA);
				
			}
			echo "1|";
		}		
		
	}
	
	function obtenerTransferenciasProductos()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$situacion=$_POST["situacion"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$start=$_POST["start"];
		$limit=$_POST["limit"];

		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		
		
		$consultaAux="SELECT idRegistro,fechaRegistro,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=idResponsableRegistro) AS responsableRegistro,idAlmacenOrigen,idAlmacenDestino,comentariosAdicionales,situacionTransferencia
 					FROM 6963_transferenciasProducto where idAlmacenOrigen in (".$idAlmacen.") and situacionTransferencia in (".$situacion.")";
				
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir." limit ".$start.",".$limit;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$consulta="select * from (".$consultaAux.") as tmp where ".$condWhere." order by ".$sort." ".$dir;
		$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function registrarTransferenciasProductos()
	{
		global $con;
	
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);		
		
		$cAO=new cAlmacen($obj->idAlmacenOrigen);
		$cAD=new cAlmacen($obj->idAlmacenDestino);
		
		
		$llaveOperacion=rand(0,1000)."_".date("Y_m_d_H_i_s");
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
			
		
		$consulta[$x]="INSERT INTO 6963_transferenciasProducto(fechaRegistro,idResponsableRegistro,idAlmacenOrigen,idAlmacenDestino,comentariosAdicionales,situacionTransferencia,fechaTransferencia)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idAlmacenOrigen.",".$obj->idAlmacenDestino.",'".cv($obj->comentarios)."',1,'".$obj->fechaTransferencia."')";
		$x++;
		$consulta[$x]="set @idTransferencia:=(select last_insert_id())";
		$x++;
		
		
		$arrMovimientosO=array();
		$arrMovimientosD=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';
		

		foreach($obj->arrProductos as $p)
		{
			$consulta[$x]="INSERT INTO 6964_productosTransferencia(idTransferencia,idProducto,llave,cantidad,unidadMedida)
						VALUES(@idTransferencia,".$p->idProducto.",'".$p->llave."',".$p->cantidad.",".$p->idUnidadMedida.")";
			$x++;
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=7;
			$oM->cantidadOperacion=$p->cantidad;
			$oM->unidadMedida=$p->idUnidadMedida;
			$oM->idProducto=$p->idProducto;
			$oM->llaveProducto=$p->llave;
			$oM->tipoReferencia=7;
			$oM->datoReferencia1=$llaveOperacion;
			
			array_push($arrMovimientosO,$oM);
			
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=8;
			$oM->cantidadOperacion=$p->cantidad;
			$oM->unidadMedida=$p->idUnidadMedida;
			$oM->idProducto=$p->idProducto;
			$oM->llaveProducto=$p->llave;
			$oM->tipoReferencia=7;
			$oM->datoReferencia1=$llaveOperacion;
			
			array_push($arrMovimientosD,$oM);
			
		}
		
		$cAO->asentarArregloMovimientos($arrMovimientosO,$consulta,$x);
		$cAD->asentarArregloMovimientos($arrMovimientosD,$consulta,$x);
		
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idTransferencia WHERE datoReferencia1='".$llaveOperacion."' AND idAlmacen=".$obj->idAlmacenOrigen;
		$x++;
		$consulta[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idTransferencia WHERE datoReferencia1='".$llaveOperacion."' AND idAlmacen=".$obj->idAlmacenDestino;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}
		
	}
	
	function validarExistenciaTransferenciasProductos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];		
		$obj=json_decode($cadObj);	
		
		$arrErrores="";
		$cA=new cAlmacen($obj->idAlmacenOrigen);	
		$tPresupuestal=21; //Reemplazar	
		foreach($obj->arrProductos as $p)
		{
			
			$eExistencia=$cA->existeSuficienciaTiempoMovimientoV2($p->idProducto,$p->cantidad,$p->idUnidadMedida,$tPresupuestal,convertirLlaveDimensiones($p->llave));	
			if(!$eExistencia)
			{
				$e='{"idProducto":"'.$p->idProducto.'","llave":"'.$p->llave.'"}';
				if($arrErrores=="")
					$arrErrores=$e;
				else
					$arrErrores.=",".$e;
			}
		}
		echo "1|[".$arrErrores."]";

		
	}	
	
	function registrarCancelacionTransferencia()
	{
		global $con;
		$idTransferencia=$_POST["idTransferencia"];
		$comentariosAdicionales=$_POST["cA"];
		$cT=new cTesoreria();		
		
		$query="SELECT idAlmacenOrigen,idAlmacenDestino FROM 6963_transferenciasProducto WHERE idRegistro=".$idTransferencia;
		$fPedido=$con->obtenerPrimeraFila($query);
		$idAlmacenOrigen=$fPedido[0];
		$idAlmacenDestino=$fPedido[1];
		
		
		$oCancelacion=json_decode('{"comentariosAdicionales":""}');
		$oCancelacion->comentariosAdicionales="'".$comentariosAdicionales."'";
		$idCancelacion=$cT->registrarCancelacionOperacion($oCancelacion);

		
		$consulta=array();
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="UPDATE 6963_transferenciasProducto SET situacionTransferencia=2,idCancelacion=".$idCancelacion." WHERE idRegistro=".$idTransferencia;
		$x++;
		
		
		$cAO=new cAlmacen($idAlmacenOrigen);	
		$cAD=new cAlmacen($idAlmacenDestino);	
		
		$arrMovimientosO=array();
		$arrMovimientosD=array();
		
		$cM=	'{
					"tipoMovimiento":"",
					"cantidadOperacion":"",
					"unidadMedida":"",
					"idProducto":"",
					"llaveProducto":"",
					"tipoReferencia":"", 	
					"datoReferencia1":"",	
					"datoReferencia2":"", 	
					"arrMovimientos":[] , 	
					"complementario":"", 	
					"codigoUnidad":""
					
				}';		
		
		$query="SELECT * FROM 6964_productosTransferencia WHERE idTransferencia=".$idTransferencia;
		$res=$con->obtenerFilas($query);		
		
		while($fila=mysql_fetch_row($res))
		{
			
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=9;
			$oM->cantidadOperacion=$fila[4];
			$oM->unidadMedida=$fila[5];
			$oM->idProducto=$fila[2];
			$oM->llaveProducto=$fila[3];
			$oM->tipoReferencia=7;
			$oM->datoReferencia1=$idTransferencia;
			
			array_push($arrMovimientosO,$oM);
			
			
			$oM=json_decode($cM);
			$oM->tipoMovimiento=10;
			$oM->cantidadOperacion=$fila[4];
			$oM->unidadMedida=$fila[5];
			$oM->idProducto=$fila[2];
			$oM->llaveProducto=$fila[3];
			$oM->tipoReferencia=7;
			$oM->datoReferencia1=$idTransferencia;
			
			array_push($arrMovimientosD,$oM);
		}		
		$cAO->asentarArregloMovimientos($arrMovimientosO,$consulta,$x);
		$cAD->asentarArregloMovimientos($arrMovimientosD,$consulta,$x);
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			
			echo "1|";
		}		
		
	}
	
	function obtenerDatosSolicitudTransferencia()
	{
		global $con;
		$idTransferencia=$_POST["idTransferencia"];
		$consulta="SELECT idProducto,llave,(SELECT descripcionProducto FROM 6932_descripcionProducto WHERE idProducto=p.idProducto AND llave=p.llave) AS producto,cantidad,unidadMedida
				 FROM 6964_productosTransferencia p WHERE idTransferencia=".$idTransferencia;
		$arrProductos=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT comentariosAdicionales FROM 6963_transferenciasProducto WHERE idRegistro=".$idTransferencia;
		$comentarios=$con->obtenerValor($consulta);
		echo '1|{"arrProductos":'.$arrProductos.',"comentarios":"'.cv($comentarios).'"}';
		
	}
?>