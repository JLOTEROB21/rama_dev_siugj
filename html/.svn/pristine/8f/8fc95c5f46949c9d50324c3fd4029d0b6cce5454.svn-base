
<?php session_start();
	include("conexionBD.php");
	include_once("cPresupuesto.php");
	include_once("cAlmacen.php");
	include_once("cContabilidad.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	switch($funcion)
	{
		case 1:
			agregarObjetoDegasto();
		break;
		case 2:
			buscarProductos();
		break;
		case 3:
			eliminarProductosObjGasto();
		break;
		case 4:
			obtenerInformacionProducto();
		break;
		case 5:
			obtenerHistoricoProducto();
		break;
		case 6:
			buscarProveedores();
		break;
		case 7:
			cargarProductoPantalla();
		break;
		case 8:
			obtenerListadoProductos();
		break;
		case 9:
			obtenerListadoSolicitudes();
		break;
		case 10:
			obtenerRequisicionesHistoricas();
		break;
		case 11:
			clonarRequisicion();
		break;
		case 12:
			cambiarEtapaRegistros();
		break;
		case 13:
			obtenerHistorialRequisicion();
		break;
		case 14:
			bloquearDesbloquearRequisicion();
		break;
		case 15:
			guardarResultadoEvaluacion();
		break;
		case 16:
			obtenerBitacoraSolicitud();
		break;
		case 17:
			obtenerResponsablesPAT();
		break;
		case 18:
			removerAsignacion();
		break;
		case 19:
			buscarEmpleado();
		break;
		case 20:
			agregarResponsableDeptoPAT();
		break;
		case 21:
			guardarEstructura();
		break;
		case 22:
			eliminarEstructora();
		break;
		case 23:
			obtenerListadoSolicitudesPresupuesto();
		break;
		case 24:
			generarPresupuestoAutorizado();
		break;
		case 25:
			removerDefinicionEstruturaProg();
		break;
		case 26:
			crearNuevaDefinicionEstructura();
		break;
		case 27:
			obtenerCicloDisponibles();
		break;
		case 28:
			modificarSituacionEstructura();
		break;
		case 29:
			obtenerProgramasPlaneacionDisp();
		break;
		case 30:
			guardarProgramasPlaneacion();
		break;
		case 31:
			removerProgramaPlaneacion();
		break;
		case 32:
			obtenerPresupuesto1000();
		break;
		case 33:
			guardarRequerimientoMes();
		break;
		case 34:
			someterEvaluacionPartida1000();
		break;
		case 35:
			cerrarEstructuraProgramatica();
		break;
		case 36:
			cerrarEstructuraProgramaticaExtendida();
		break;
		case 37:
			modificarPMP();
		break;
		case 38:
			removerIndicador();
		break;
		case 39:
			cerrarPlaneacionOperativa();
		break;
		case 40:
			cerrarRegistroNecesidadesEnvioJefe();
		break;
		case 41:
			cerrarRegistroNecesidadesEnvioAdquisiciones();
		break;
		case 42:
			guardarConceptoDeteccionNecesidades();
		break;
		case 43:
			obtenerConceptosDeteccionNecesidades();
		break;
		case 44:
			obtenerDatosConceptoDeteccionNecesidades();
		break;
		case 45:
			obtenerProgramasAutorizados();
		break;
		case 46:
			obtenerPartidasProceso();
		break;
		case 47:
			guardarResponsablesProgramas();
		break;
		case 48:
			obtenerResponsablesProgramas();
		break;
		case 49:
			obtenerListadoSolicitudesGridValidacion();
		break;
		case 50:
			cambiarEtapaProducto();
		break;
		case 51:
			cerrarRegistroNecesidades3000EnvioAdquisiciones();
		break;
		case 52:
			obtenerListadoSolicitudesGridAdquisiciones();
		break;
		case 53:
			obtenerListadoSolicitudesGridPresupuestos();
		break;
		case 54:
			obtenerListadoSolicitudesGridComite();
		break;
		case 55:
			obtenerListadoSolicitudesGridObjetoGasto();
		break;
		case 56:
			obtenerDistribucionProducto();
		break;
		case 57:
			modificarDistribucionProducto();
		break;
		case 58:
			obtenerCategoriasPartida();
		break;
		case 100:
			obtenerRecursosHumanosServicio();
		break;
		case 101:
			eliminarDepartamentoServicio();
		break;
		case 102:
			guardarDepartamentoServicio();
		break;
		case 103:
			obtenerPuestosDepartamento();
		break;
		case 104:
			guardarRecursoServicio();
		break;
		case 105:
			eliminarRecursoServicio();
		break;
		case 106:
			eliminarServicio();
		break;
		case  107:
			guardarCostoServicio();
		break;
		case  108:
			obtenerCandidatosSolicitud();
		break;
		case  109:
			marcarCandidatosSolicitud();
		break;
		case  110:
			obtenerCandidatosSeleccionados();
		break;
		case  111:
			modificarVacanteSeleccionados();
		break;
		case  112:
			enviarContrato();
		break;
		case  113:
			verElegidos();
		break;
		case 114:
			guardarPartidaComite();
		break;
		case 115:
			obtenerPartidasComiteDisponible();
		break;
		case 116:
			obtenerDatosContrato();
		break;
		case 117:
			obtenerAreasProrrateo();
		break;
		case 118:
			obtenerBasesProrrateo();
		break;
		case 119:
			guardarProrrateoContrato();
		break;
		case 120:
			obtenerActivoFijoDepreciado();
		break;
		case 121:
			guardarProyeccionServicio();
		break;
		case 122:
			obtenerConcentradoRopaje();
		break;
		case 123:
			obtenerDepartamentosRopaje();
		break;
		case 124:
			reporteAnualCapacitacion();
		break;
		case 125:
			enviarComprasConcentradoRopaje();
		break;
		case 126:
			obtenerParticipantesCurso();
		break;
		case 127:
			obtenerConceptosPartidas();
		break;
		case 128:
			obtenerDeptosPartidasConcepto();
		break;
		case 129:
			obtenerProrrateoDeteccionNecesidades();
		break;
		case 130:
			registrarNuevoProducto();
		break;
		case 131:
			obtenerNuevosProductos();
		break;
		case 132:
			obtenerSolicitudProducto();
		break;
		case 133:
			obtenerObjetosGasto();
		break;
		case 134:
			clasificarNuevoProducto();
		break;
		case 135:
			rechazarNuevoProducto();
		break;
		case 136:
			buscarProductoActivo();
		break;
		case 137:
			reemplazarProducto();
		break;
		case 138:
			agregarObjetoDegastoCompra();
		break;
		case 139:
			obtenerProyeccionServicios();

		break;
			
		case 140:
			obtenerDefinicionEstructuraProgramatica();
		break;
		case 141:
			guardarPerfilEstructuraCiclo();
		break;	
		case 142:
			removerClavePresupuestaria();
		break;
		case 143:
			registrarClaveProgramatica();
		break;
		case 144:
			guardarProgramaClaveProgramatica();
		break;
		case 145:
			removerProgramaClaveProgramatica();
		break;
		case 146:
			bloquearEstructuraProgramatica();
		break;
		case 147:
			obtenerProgramasEstructuraProgramaticaCiclo();
		break;
		case 148:
			obtenerDepartamentosProgramaCiclo();
		break;
		case 149:
			bloquearDefinicionDepartamentoPartidaCiclo();
		break;
		case 150:
			buscarProductoCompra();
		break;			
		case 151:
			buscarProgramaProductoDisponible();
		break;
		case 152:
			obtenerPersupuestoProgramaProductoDisponible();
		break;
		case 153:
			registrarSolicitudCompra();
		break;
		case 154:
			obtenerSolicitudesCompra();
		break;
		case 155:
			obtenerSolicitudesCompraPendientes();
		break;
		case 156:
			buscarProductores();
		break;
		case 157:
			registrarCompraProducto();
		break;
		
	}
	
	function agregarObjetoDegasto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$idRegistroObjeto=$obj->idRegistroObjeto;
		$query="begin";
		$idProveedor=$obj->idProveedorSugerido;
		if($idProveedor=="")
			$idProveedor="NULL";
		if($con->ejecutarConsulta($query))
		{
			if($obj->idRegistroObjeto!="-1")
			{
				$query="select idPrograma,ruta,tipoPresupuesto from  9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$obj->idRegistroObjeto;
				$filaDatos=$con->obtenerPrimeraFila($query);
				$obj->idPrograma=$filaDatos[0];
				$obj->ruta=$filaDatos[1];
				
			}
			if($obj->idMarca=="")
				$obj->idMarca="NULL";
			$query="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$obj->idProducto;
			$clave=$con->obtenerValor($query);
			$query="SELECT SUM(montoTotal) FROM 9110_objetosGastoVSCiclo o WHERE idCiclo=".$obj->idCiclo." AND codDepto='".$obj->codDepto."' AND idPrograma=".$obj->idPrograma." AND ruta='".$obj->ruta."' AND clave='".$clave."' and tipoPresupuesto=".$obj->tipoPresupuesto." and numEtapa not in (6,7,8)";
			$montoSolicitado=$con->obtenerValor($query);
			$query="SELECT techoPresupuestal FROM 523_techosPresupuestales WHERE ciclo=".$obj->idCiclo." AND programaInstitucional=".$obj->idPrograma." AND ruta='".$obj->ruta."' AND departamento='".$obj->codDepto."' AND  fuenteFinanciamiento=".$obj->tipoPresupuesto." and
					(objetoGasto='".$clave."' or objetoGasto like '".$clave."%')";
					
			$montoTecho=$con->obtenerValor($query);
			$suficiencia=$montoTecho-$montoSolicitado;
			if($idRegistroObjeto!="-1")
			{
				$query="select montoTotal from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$idRegistroObjeto;
				$montoAnterior=$con->obtenerValor($query);
				$suficiencia+=$montoAnterior;	
				if($obj->costoTotal>$suficiencia)
				{
					$query="select nombreObjetoGasto from 507_objetosGasto where codigoControl='".$clave."'";
					$nObjetoGasto=$con->obtenerValor($query);
					echo "<br>El monto solicitado (<b>$ ".number_format($obj->costoTotal,2)."</b>) excede el monto disponible de techo presupuestal (<b>$ ".number_format($suficiencia,2)."</b>) para el objeto de gasto '".$nObjetoGasto."'";
					return;
				}
				$query="select numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastociclo=".$idRegistroObjeto;
				$numEtapa=$con->obtenerValor($query);
				$incUnidad=0;
				if($numEtapa>1)
				{
				
					$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios,idMarcaSugerida)
									SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios,
									idMarcaSugerida
									from 9110_objetosGastoVSCiclo where 
									idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;
					$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
									WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;	
					$incUnidad=1;
				}
						
				$consulta[$x]="DELETE FROM 9111_cantidaObjVSMes WHERE idCodigoGastociclo=".$idRegistroObjeto;
				$x++;
				
				$consulta[$x]=	"UPDATE 9110_objetosGastoVSCiclo SET idMarcaSugerida=".$obj->idMarca.",tipoContrato=".$obj->tipoContrato.",porcentajeMinimo=".$obj->porcentajeMinimo.", version=version+".$incUnidad.",cantidad=".$obj->cantidad.",justificacion='".cv($obj->justificacion)."',idProveedorSugerido=".$idProveedor.",observaciones='".cv($obj->observaciones).
								"',responsableModif=".$_SESSION["idUsr"].",fechaUltimaModif='".date('Y-m-d')."',costoUnitario=".$obj->costoUnitario.",montoTotal=".$obj->costoTotal.",tipoPresupuesto=".$obj->tipoPresupuesto." WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
				$x++;
			}
			else
			{
				if($obj->costoTotal>$suficiencia)
				{
					$query="select nombreObjetoGasto from 507_objetosGasto where codigoControl='".$clave."'";
					$nObjetoGasto=$con->obtenerValor($query);
					echo "<br>El monto solicitado (<b>$ ".number_format($obj->costoTotal,2)."</b>) excede el monto disponible de techo presupuestal (<b>$ ".number_format($suficiencia,2)."</b>) para el objeto de gasto '".$nObjetoGasto."'";
					return;
				}
				$query="	INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,
							montoTotal,tipoPresupuesto,ruta,tipoContrato,porcentajeMinimo,idMarcaSugerida)
								VALUES('".$clave."',".$obj->idCiclo.",'".$obj->codDepto."','".$obj->codInstitucion."',".$obj->idProducto.",".$obj->cantidad.",'".cv($obj->justificacion)."',".
								$idProveedor.",'".cv($obj->observaciones)."',".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->costoUnitario.",".$obj->costoTotal.",".$obj->tipoPresupuesto.",'".$obj->ruta."',".
								$obj->tipoContrato.",".$obj->porcentajeMinimo.",".$obj->idMarca.")";

				if(!$con->ejecutarConsulta($query))
				{
					echo "|";
					return;	
				}
				$idRegistroObjeto=$con->obtenerUltimoID();
				$consulta[$x]="insert into 9110_bitacoraObjetosGastoVSCiclo(idCodigoGastoVSCiclo,etapaOrigen,etapaCambio,idResponsable,fechaCambio,comentarios) values
							(".$idRegistroObjeto.",0,1,".$_SESSION["idUsr"].",'".date('Y-m-d')."','')";
				$x++;		
			}
			$arrMeses=explode(",",$obj->distribucion);
			for($ct=0;$ct<sizeof($arrMeses);$ct++)
			{
				$consulta[$x]="insert into 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) values(".$idRegistroObjeto.",".$ct.",".$arrMeses[$ct].",".($arrMeses[$ct]*$obj->costoUnitario).")";
				$x++;	
			}
			
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
		}
		else
			echo "|";
	}
	
	function buscarProductos()
	{
		global $con;
		$ruta=$_POST["ruta"];
		$criterio=$_POST["criterio"];
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$ciclo=bD($_POST["ciclo"]);
		$codDepto=bD($_POST["codDepto"]);
		$programa=bD($_POST["programa"]);
		$capitulos=bD($_POST["capitulos"]);
		$arrCapitulos=explode(",",$capitulos);
		$query="SELECT factor FROM 523_factorInflacion WHERE ciclo=".$ciclo." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$factorInflacion=$con->obtenerValor($query);
		if($factorInflacion=="")
			$factorInflacion=0;
		else
			$factorInflacion=$factorInflacion/100;
		
			
		$cadCapitulos="";
		global $tipoCosto;
		global $nPromedio;
		global $tipoOG;
		foreach($arrCapitulos as $c)
		{
			$particula="(o.codigoControlPadre = '".$c."' or o.codigoControlPadre like '".$c."%' or o.codigoControl='".$c."')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ruta='".$ruta."' and idPrograma=".$programa." AND codigoUnidad='".$codDepto."' AND ciclo=".$ciclo;
		
		$listPartidas=$con->obtenerListaValores($consulta);
		if($listPartidas=="")
		{
			$consulta="SELECT codigoControl FROM 507_objetosGasto WHERE clave IN (".$listPartidas.")";
			$listPartidas=$con->obtenerListaValores($consulta,"'");
			if($listPartidas=="")
				$listPartidas="'-1'";
		}
			
		if($cadCapitulos!="")
		{
			$cadCapitulos="(".$cadCapitulos.")";		
			$cadCapitulos.=" and (objetoGasto in (".$listPartidas.") or objetoGasto in (".$capitulos."))";	
		}
		else
			$cadCapitulos.=" (objetoGasto in (".$listPartidas.") or objetoGasto in (".$capitulos."))";	
		if($tipoCosto==1)
			$costo="(if((SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,1) is null,p.costoUnitarioInicial,(SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,1) )) as costo";	
		else
			$costo="(if((SELECT avg(costoUnitario) FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,".$nPromedio.") is null,p.costoUnitarioInicial,(SELECT avg(costoUnitario) FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,".$nPromedio."))) as costo";	
		
		
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idCiclo=".$ciclo." AND codDepto=".$codDepto." AND idPrograma=".$programa;
		$listProductos=$con->obtenerListaValores($consulta);
		if($listProductos=="")
			$listProductos="-1";
			
		$consulta="SELECT objetoGasto FROM 9130_departamentoObjGastoNoCompra WHERE idPrograma=".$programa." AND ruta='".$ruta."' AND departamento='".$codDepto."' AND ciclo=".$ciclo;
		$listNoCompra=$con->obtenerListaValores($consulta,"'");			
		if($listNoCompra=="")
				$listNoCompra="-1";
		$consulta="select idProducto,nombreProducto,descripcion,".$costo.",permiteContratoAbierto as contratoAbierto from 9101_CatalogoProducto p,507_objetosGasto o  where status_art in (1,2) and p.objetoGasto=o.codigoControl 
					and  ".$cadCapitulos."  and  nombreProducto like '".$criterio."%' and idProducto not in (".$listProductos.")  and objetoGasto not in (".$listNoCompra.")order by nombreProducto limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		
		while($fila=$con->fetchRow($res))
		{
			$costo=$fila[3];
			$montoInflacion=$costo*$factorInflacion;
			$costo+=$montoInflacion;
			$obj='{"idProducto":"'.$fila[0].'","nombreProducto":"'.cv($fila[1]).'","descripcion":"'.cv($fila[2]).'","costoUnitario":"'.number_format($costo,2).'","permiteContratoAbierto":"'.$fila[4].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
			
		}
		$consulta="select idProducto,nombreProducto from 9101_CatalogoProducto p, 507_objetosGasto o  where 
				o.clave=p.objetoGasto and ".$cadCapitulos."  and status_art=1 and nombreProducto like '".$criterio."%' and idProducto not in (".$listProductos.")";
		$con->obtenerFilas($consulta);
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function eliminarProductosObjGasto()
	{
		global $con;
		$idCodigoGastoCiclo=$_POST["idCodigoGastoCiclo"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$consulta="select idCodigoGastociclo,numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastociclo in(".$idCodigoGastoCiclo.")";
			
			$res=$con->obtenerFilas($consulta);
			
			while($fila=$con->fetchRow($res))
			{
				$idObjeto=$fila[0];
				$numEtapa=$fila[1];
				$incUnidad=0;
				if($numEtapa>1)
				{
				
					$query[$ct]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios)
									SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios from 9110_objetosGastoVSCiclo where 
									idCodigoGastoCiclo=".$idObjeto;
					$ct++;
					$query[$ct]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
									WHERE idCodigoGastoCiclo=".$idObjeto;
												
					$ct++;	
					$incUnidad=1;
				}
			}
			
			$query[$ct]="DELETE FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo in(".$idCodigoGastoCiclo.")";
			
			$ct++;
			$query[$ct]="DELETE FROM 9110_objetosGastoVSCiclo WHERE idCabecera in(".$idCodigoGastoCiclo.")";
			
			$ct++;
			$query[$ct]="DELETE FROM 9110_objetosGastoVSCiclo WHERE idCodigoGastoCiclo in (".$idCodigoGastoCiclo.")";
			$ct++;
			$query[$ct]="commit";
			eB($query);
		}
		else
			echo "|";
	}
	
	function obtenerInformacionProducto()
	{
		global $con;
		$id=$_POST["id"];
		$consulta="SELECT * FROM 9110_objetosGastoVSCiclo WHERE idCodigoGastoCiclo=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[5];
		$nombre=$con->obtenerValor($conNombre);
		$nombreP="";
		if($fila[8]!="")
		{
			$conNombreProov="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$fila[8];
			$nombreP=$con->obtenerValor($conNombreProov);
		}
		$conMeses="SELECT cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$id." ORDER BY mes";
		$resMeses=$con->obtenerFilas($conMeses);
		$cadenaHijo="";
		while($filaMes=$con->fetchRow($resMeses))
		{
			if($cadenaHijo=="")
				$cadenaHijo="'".$filaMes[0]."'";
			else
				$cadenaHijo.=",'".$filaMes[0]."'";
		}
		if($cadenaHijo=="")
			$cadenaHijo="['0','0','0','0','0','0','0','0','0','0','0','0']";
		else
			$cadenaHijo="[".$cadenaHijo."]";
		echo "1|".$fila[5]."|".$nombre."|".$fila[6]."|".$fila[7]."|[".uEJ($cadenaHijo)."]|".$fila[0]."|".$fila[8]."|".$fila[9]."|".$nombreP."|".$fila[15]."|".$fila[16]."|".$fila[19]."|".$fila[26]."|".$fila[27]."|".$fila[28];
	}
	
	function obtenerHistoricoProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$idCiclo=$_POST["idCiclo"];
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		if($codDepartamento=="")
			$codDepartamento="0001";
		$arreglo="";	
		
		$consulta="SELECT idCodigoGastoCiclo,idProducto,cantidad,idCiclo FROM 9110_objetosGastoVSCiclo WHERE idProducto=".$idProducto." AND idCiclo<>".$idCiclo." AND idPrograma=".$idPrograma." AND codDepto='".$codDepartamento."'";	

		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		if($nFilas>0)
		{
			$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
			$nombre=$con->obtenerValor($conNombre);
			
			while($filaM=$con->fetchRow($res))
			{
				$conMeses="SELECT mes,cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$filaM[0]." ORDER BY mes";
				//echo $conMeses;
				$rMeses=$con->obtenerFilas($conMeses);
				$cadenaHijo="";
				while($fMes=$con->fetchRow($rMeses))
				{
					$objH="'".$fMes[1]."'";
					$cadenaHijo.=",".$objH;
				
				}
				//echo $cadenaHijo;
				$obj="['".$filaM[0]."','".$filaM[1]."','".$filaM[3]."','".$filaM[2]."'".$cadenaHijo."]";
				//echo $obj;
				if($arreglo=="")
					$arreglo=$obj;
				else
					$arreglo.=",".$obj;
			}
			$arreglo="[".$arreglo."]";
			//echo $arreglo;
			echo "1|".uEJ($arreglo)."|".$nombre;
		}
		else
		{
			echo "2|";
		}
		
	}
	
	function obtenerAbreviaturaMes($num)
	{
		$abreviatura="";
		switch($num)
		{
			case 0:
				$abreviatura="Ene";
			break;
			case 1:
				$abreviatura="Feb";
			break;
			case 2:
				$abreviatura="Mar";
			break;
			case 3:
				$abreviatura="Abr";
			break;
			case 4:
				$abreviatura="May";
			break;
			case 5:
				$abreviatura="Jun";
			break;
			case 6:
				$abreviatura="Jul";
			break;
			case 7:
				$abreviatura="Ago";
			break;
			case 8:
				$abreviatura="Sep";
			break;
			case 9:
				$abreviatura="Oct";
			break;
			case 10:
				$abreviatura="Nov";
			break;
			case 11:
				$abreviatura="Dic";
			break;
		}
		return $abreviatura;
	}
	
	function buscarProveedores()
	{
		global $con;
		$criterio2=$_POST["criterio"];
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		
		$consulta="SELECT id__405_tablaDinamica,txtRazonSocial2 FROM _405_tablaDinamica WHERE txtRazonSocial2 like '".$criterio2."%'   order by txtRazonSocial2 limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=$con->fetchRow($res))
		{
			$conDatos="SELECT CONCAT(txtDireccion,' ',txtcolonia,' ','-',txtDelegacion,' ',p.nombre)AS direccion,
			txtTelefono1,txtTelefono2,txtFax,txtCorreo,txtRFC  FROM _405_tablaDinamica d, 238_paises p
			WHERE id__405_tablaDinamica=".$fila[0]." AND d.cmbPais=p.idPais";
			$filaD=$con->obtenerPrimeraFila($conDatos);
			
			
			$obj='{"idProovedor":"'.$fila[0].'","nombreProovedor":"'.cv($fila[1]).'","RFC":"'.cv($filaD[5]).'","direccion":"'.cv($filaD[0]).'","tel1":"'.cv($filaD[1]).'","tel2":"'.cv($filaD[2]).'","fax":"'.cv($filaD[3]).'","correo":"'.cv($filaD[5]).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","proovedores":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function obtenerListadoProductos()
	{
		global $con;
		global $SO;
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					case 'list':
						if($arrFiltro[$x]["field"]=='nombreObjetoGasto')
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.clave in (".$listaClaves.")";
						}
						else
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.codigoControlPadre in (".$listaClaves.")";
						}
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		
		
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		
		$ciclo=bD($_POST["ciclo"]);
		$codDepto=bD($_POST["codDepto"]);
		$programa=bD($_POST["programa"]);
		$capitulos=bD($_POST["capitulos"]);
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $tipoOG;
		foreach($arrCapitulos as $c)
		{
			
			$particula="(o.codigoControlPadre = '".$c."' or o.codigoControlPadre like '".$c."%')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE idPrograma=".$programa." AND codigoUnidad='".$codDepto."' AND ciclo=".$ciclo;
		$listPartidas=$con->obtenerListaValores($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
			
		$cadCapitulos." and objetoGasto in (".$listPartidas.")";	
		$consulta="SELECT concat('[',clave,'] ',nombreObjetoGasto),codigoControl FROM 507_objetosGasto o WHERE CONCAT(clave,'') LIKE '%00'";
		$res=$con->obtenerFilas($consulta);
		$arrSubPartida=array();
		while($fila=$con->fetchRow($res))
			$arrSubPartida[$fila[1]]["clave"]=$fila[0];
		
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idCiclo=".$ciclo." AND codDepto=".$codDepto." AND idPrograma=".$programa;
		$listProductos=$con->obtenerListaValores($consulta);
		if($listProductos=="")
			$listProductos="-1";
		
		$consulta="SELECT cp.idProducto,o.codigoControlPadre,CONCAT('[',cp.0bjetoGasto,'] ',o.nombreObjetoGasto) AS 'nombreObjetoGasto',cp.nombreProducto,cp.descripcion 
						FROM 9101_CatalogoProducto cp,507_objetosGasto o  
						WHERE o.clave=cp.0bjetoGasto AND ".$cadCapitulos." ".$condWhere." and cp.idProducto not in (".$listProductos.") and cp.status_art=1 order by nombreProducto limit ".$inicio." ,".$cantidad;		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=$con->fetchRow($res))
		{
			$obj='{"idProducto":"'.$fila[0].'","subPartida":"'.cv($arrSubPartida[$fila[1]]["clave"]).'","nombreObjetoGasto":"'.cv($fila[2]).'","nombreProducto":"'.cv($fila[3]).'","descripcion":"'.cv($fila[4]).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$consulta="SELECT cp.idProducto,o.codigoControlPadre,CONCAT('[',cp.0bjetoGasto,'] ',o.nombreObjetoGasto) AS 'nombreObjetoGasto',cp.nombreProducto,cp.descripcion 
						FROM 9101_CatalogoProducto cp,507_objetosGasto o  
						WHERE o.clave=cp.0bjetoGasto AND ".$cadCapitulos." and cp.status_art=1 and cp.idProducto not in (".$listProductos.") ".$condWhere; 
		$con->obtenerFilas($consulta);
		if($SO==2)
			$obj='{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrDatos).']}';
		echo $obj;
	
	}
	
	function obtenerListadoSolicitudes()
	{
		global $con;
		global $SO;
		$inicio=0;
		$cantidad=10000;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=bD($_POST["ciclo"]);
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		$capitulos=bD($_POST["capitulos"]);
		$idProceso=$_POST["idProceso"];
		$actor=$_POST["actor"];
		$etapa=$_POST["numEtapa"];
		$cEtapa=$_POST["cEtapa"];
		$ruta=$_POST["ruta"];
		$idActorProcesoEtapa=$_POST["idActorProcesoEtapa"];
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $tipoOG;
		$consulta="select numEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
		$resEtapas=$con->obtenerFilas($consulta);
		$arrPermisosEtapa=array();
		$arrEtapasOpciones="";
		while($filaEtapa=$con->fetchRow($resEtapas))
		{
			$permisos="";
			if(strpos($actor,"_")!==false)
				$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=1 and numEtapa=".$filaEtapa[0];
			else
				$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=2 and numEtapa=".$filaEtapa[0];
			$idAProcesoEtapa=$con->obtenerValor($consulta);	   
			if($idAProcesoEtapa=="")
				$idAProcesoEtapa="-1";
			$consulta="SELECT idGrupoAccion,complementario,idAccionesProcesoEtapaVSAcciones FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$idAProcesoEtapa;
			$arrAcciones=$con->obtenerFilasArregloPHP($consulta);
			$permisos="";
			if(existeValorMatriz($arrAcciones,"13")!=-1)
			{
				$permisos="['A','']";
			}
			if(existeValorMatriz($arrAcciones,"2")!=-1)
			{
				if($permisos=="")
					$permisos="['M','']";
				else
					$permisos.=",['M','']";
			}
			if(existeValorMatriz($arrAcciones,"7")!=-1)
			{
				if($permisos=="")
					$permisos.="['E','']";
				else
					$permisos.=",['E','']";
			}
			if(existeValorMatriz($arrAcciones,"6")!=-1)
			{
				if($permisos=="")
					$permisos="['B','']";	
				else
					$permisos.=",['B','']";	
			}
			$pos=existeValorMatriz($arrAcciones,"11");
			if($pos!=-1)
			{
				if($permisos=="")
					$permisos="['D','']";	
				else
					$permisos.=",['D','']";	
				$idAccionProceso=$arrAcciones[$pos][2];
				
				$consulta="SELECT valor,contenido,etapa FROM 9114_opcionesEvaluacion WHERE idAccion=".$idAccionProceso." AND idIdioma=".$_SESSION["leng"];
				$arrOpciones=$con->obtenerFilasArreglo($consulta);
				
				$obj="['".$filaEtapa[0]."',".$arrOpciones."]";
				if($arrEtapasOpciones=="")
					$arrEtapasOpciones=$obj;
				else
					$arrEtapasOpciones.=",".$obj;
			}
			$pos=existeValorMatriz($arrAcciones,"1");
			if($pos!=-1)
			{
				$etapaSomete=$arrAcciones[$pos][1];
				if($permisos=="")
					$permisos="['S','".$arrAcciones[$pos][1]."']";
				else
					$permisos.=",['S','".$arrAcciones[$pos][1]."']";
			}	   
			
			if(existeValorMatriz($arrAcciones,"14")!=-1)
			{
				if($permisos=="")
					$permisos="['G','']";	
				else
					$permisos.=",['G','']";	
			}
			$arrPermisosEtapa[removerCerosDerecha($filaEtapa[0])]="[".$permisos."]";
		}
		
		if(strpos($actor,"_")!==false)
		{
			foreach($arrCapitulos as $c)
			{
				
				
				$particula="(o.codigoControlPadre like '".$c."%' or o.codigoControlPadre='".$c."' or o.codigoControl='".$c."' )";
				if($cadCapitulos=="")
					$cadCapitulos=$particula;	
				else
					$cadCapitulos.=" or ".$particula;	
			}
		}
		else
		{
			$consulta="SELECT idComite FROM 235_proyectosVSComites WHERE idProyectoVSComite=".$actor;
			$idComite=$con->obtenerValor($consulta);
			$consulta="SELECT idProyectoVSComiteVSEtapa FROM 234_proyectosVSComitesVSEtapas WHERE idProyecto=".$idProceso." AND idComite=".$idComite." AND numEtapa=".$etapa;
			$idProyectoCE=$con->obtenerValor($consulta);
			$consulta="SELECT p.partida FROM 9044_proyectoComitePartida p WHERE  idProyectoComite=".$idProyectoCE;
			$resPartidas=$con->obtenerFilas($consulta);
			while($filaPartidas=$con->fetchRow($resPartidas))
			{
				$particula="(o.codigoControlPadre = '".$filaPartidas[0]."' or o.codigoControlPadre like '".$filaPartidas[0]."%')";
				if($cadCapitulos=="")
					$cadCapitulos=$particula;	
				else
					$cadCapitulos.=" or ".$particula;
			}
		}
		
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					case 'list':
						if($arrFiltro[$x]["field"]=='nombreObj')
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.clave in (".$listaClaves.")";
						}
						
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		$condFiltro="";
		
		$condFiltro=" AND ((codDepto = '".$codDepartamento."' or codDepto like '".$codDepartamento."%') and idPrograma='".$idPrograma."' and ruta='".$ruta."')";
		if(strpos($actor,"_")!==false)
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND tipoActor=1 AND idProceso=".$idProceso." AND numEtapa=1";
		else
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND tipoActor=2 AND idProceso=".$idProceso." AND numEtapa=1";
		$filaActor=$con->obtenerPrimeraFila($consulta);
		
		$condAuxiliar="";
		$consulta="SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					(SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=c.numEtapa) as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,p.status_art,c.idProducto,idProveedorSugerido,idMarcaSugerida
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			   ".$cadCapitulos." and p.idProducto=c.idProducto ".$condWhere.$condAuxiliar." order by nombreProducto limit ".$inicio.",".$cantidad;
		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro."  AND  ".$cadCapitulos." ".$condWhere;

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			$proveedorSugerido=$fila[21];
			if($proveedorSugerido!="")
			{
				$consulta="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$proveedorSugerido;
				$proveedorSugerido=$con->obtenerValor($consulta);
			}
			$marcaSugerida=$fila[22];
			if($marcaSugerida!="")
			{
				$consulta="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$marcaSugerida;
				$marcaSugerida=$con->obtenerValor($consulta);
			}
			if($fila[20]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			$motivoRechazo="";
			if(($fila[19]=="3")||($fila[18]==6)||($fila[18]==7)||($fila[18]==8))
			{
				$consulta="SELECT motivoRechazo FROM 9101_productosRechazados WHERE idProducto=".$fila[20];
				$motivoRechazo=$con->obtenerValor($consulta);
				$fila[6]=0;
				$fila[11]=0;
				
			}
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"'.$arrPermisosEtapa[removerCerosDerecha($fila[18])].'","numEtapa":"'.$fila[18].'",
					"statusArt":"'.$fila[19].'","motivoRechazo":"'.$motivoRechazo.'","proveedorSugerido":"'.$proveedorSugerido.'","marcaSugerida":"'.$marcaSugerida.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function cargarProductoPantalla()
	{
		global $con;
		$idCodigoGastoCiclo=$_POST["idCodigoG"];
		$consulta="SELECT * FROM 9110_objetosGastoVSCiclo WHERE idCodigoGastoCiclo=".$idCodigoGastoCiclo;
		
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[5];
			$nombre=$con->obtenerValor($conNombre);
			$nombreP="";
			if($fila[8]!="")
			{
				$conNombreProov="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$fila[8];
				$nombreP=$con->obtenerValor($conNombreProov);
			}
			$conMeses="SELECT cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$idCodigoGastoCiclo." ORDER BY mes";
			$resMeses=$con->obtenerFilas($conMeses);
			$cadenaHijo="";
			while($filaMes=$con->fetchRow($resMeses))
			{
				if($cadenaHijo=="")
					$cadenaHijo="'".$filaMes[0]."'";
				else
					$cadenaHijo.=",'".$filaMes[0]."'";
			}
			if($cadenaHijo=="")
				$cadenaHijo="['0','0','0','0','0','0','0','0','0','0','0','0']";
			else
				$cadenaHijo="[".$cadenaHijo."]";
			echo "1|".$fila[5]."|".$fila[6]."|".$fila[8]."|[".$cadenaHijo."]|".uEJ($nombre)."|".uEJ($nombreP);
		}
	}
	
	function obtenerRequisicionesHistoricas()
	{
		global $con;
		$cicloActual=bD($_POST["ciclo"]);
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		$consulta="select distinct idCiclo from 9110_objetosGastoVSCiclo where idCiclo<>".$cicloActual." and codDepto='".$codDepartamento."' and idPrograma=".$idPrograma." order by idCiclo desc";
		$resCiclos=$con->obtenerFilas($consulta);	
		$arrCiclos="";
		while($filaCiclo=$con->fetchRow($resCiclos))
		{
			$consulta="select sum(montoTotal) from 9110_objetosGastoVSCiclo where codDepto='".$codDepartamento."' and idPrograma=".$idPrograma." and idCiclo=".$filaCiclo[0];
			$montoTotal=$con->obtenerValor($consulta);
			$obj="['".$filaCiclo[0]."','".$montoTotal."']";
			if($arrCiclos=="")
				$arrCiclos=$obj;
			else
				$arrCiclos.=",".$obj;
		}
		echo "1|[".$arrCiclos."]";
	}
	
	function clonarRequisicion()
	{
		$cicloDestino=$_POST["cicloDestino"];
		$cicloOrigen=$_POST["cicloOrigen"];
		$codigoDepto=$_POST["codigoDepto"];
		$idPrograma=$_POST["idPrograma"];
		$capitulos=bD($_POST["capitulos"]);
		$ruta=$_POST["ruta"];
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $con;
		global $tipoCosto;
		global $nPromedio;
		global $tipoOG;
		
		foreach($arrCapitulos as $c)
		{
			
			
			$particula="(o.codigoControlPadre = '".$c."' or o.codigoControlPadre like '".$c."%')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE idPrograma=".$idPrograma." AND codigoUnidad='".$codigoDepto."' AND ciclo=".$cicloDestino;
		$listPartidas=$con->obtenerListaValores($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
		else
		{
			$consulta="SELECT codigoControl FROM 507_objetosGasto WHERE clave IN (".$listPartidas.")";
			$listPartidas=$con->obtenerListaValores($consulta,"'");
			if($listPartidas=="")
				$listPartidas="'-1'";
		}
		
			
		$cadCapitulos." and objetoGasto in (".$listPartidas.")";	
		$query="delete FROM 9110_objetosGastoVSCiclo  WHERE idCiclo=".$cicloDestino." AND codDepto='".$codigoDepto."' and idPrograma=".$idPrograma;
		
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;	
		}
		
		$query="SELECT * FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o WHERE c.clave=o.codigoControl and 
				idCiclo=".$cicloOrigen." AND codDepto='".$codigoDepto."' and idPrograma=".$idPrograma." and ".$cadCapitulos;
		$resProductos=$con->obtenerFilas($query);
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			
			while($fila=$con->fetchRow($resProductos))
			{
				$idProveedor=$fila[8];
				if($idProveedor=="")
					$idProveedor="NULL";
				$query="SELECT objetoGasto,status_art FROM 9101_CatalogoProducto WHERE idProducto=".$fila[5];
				$filaArt=$con->obtenerPrimeraFila($query);
				$clave=$filaArt[0];
				$status=$filaArt[1];
				if($status==1)
				{
					if($tipoCosto==1)
						$costo="SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=".$fila[5]." ORDER BY fechaPedido DESC LIMIT 0,1";	
					else
						$costo="SELECT avg(costoUnitario) FROM 9103_PedidoDetalle WHERE idProducto=".$fila[5]." ORDER BY fechaPedido DESC LIMIT 0,".$nPromedio;	
					
					$costo=$con->obtenerValor($costo);
					if($costo=="")
						$costo=0;
					$query="	INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,
								idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,numEtapa,modificable,tipoPresupuesto,version,ruta)
										VALUES('".$clave."',".$cicloDestino.",'".$codigoDepto."','".$fila[4]."',".$fila[5].",".$fila[6].",'',".
										$idProveedor.",'',".$idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$costo.",".($costo*$fila[6]).",1,1,".$fila[19].",1,'".$ruta."')";
					if(!$con->ejecutarConsulta($query))
					{
						$query="rollback";
						$con->ejecutarConsulta($query);
						echo "|";
						return;
					}
					$idRegistro=$con->obtenerUltimoID();
					
					$query="SELECT mes,cantidad,monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
					
					$resMes=$con->obtenerFilas($query);
					while($filaMes=$con->fetchRow($resMes))
					{
						$query="insert into 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) values(".$idRegistro.",".$filaMes[0].",".$filaMes[1].",".$filaMes[2].")";
						if(!$con->ejecutarConsulta($query))
						{
							$query="rollback";
							$con->ejecutarConsulta($query);
							echo "|";
							return;
						}	
					}
				}
			}
			$query="commit";
			eC($query);
		}
		else
		{
			echo "|";	
		}
	}
	
	function cambiarEtapaRegistros()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$etapaAnt=0;
		foreach($obj->arrRegistros as $registro)
		{
			$consulta[$x]="update 9110_objetosGastoVSCiclo SET numEtapa=".$registro->etapaSomete." WHERE idCodigoGastoCiclo=".$registro->idRegistro;
			$x++;
			$consulta[$x]="insert into 9110_bitacoraObjetosGastoVSCiclo(idCodigoGastoVSCiclo,etapaOrigen,etapaCambio,idResponsable,fechaCambio,comentarios) values
							(".$registro->idRegistro.",".$etapaAnt.",".$registro->etapaSomete.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','')";
			$x++;		
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerHistorialRequisicion()
	{
		global $con;
		$idRegistroObjeto=$_POST["idRegistroObjeto"];
		$consulta="SELECT idCodigoGastoCicloHistorico,VERSION,cantidad,costoUnitario,montoTotal,
					(SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=h.tipoPresupuesto) AS tipoPresupuesto,
					comentarios,(SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=h.idProveedorSugerido) AS idProveedorSugerido,
					u.Nombre,DATE_FORMAT(fechaModif,'%d/%m/%Y') AS fechaModif,p.nombreProducto,h.idProducto FROM
					9110_objetosGastoVSCicloHistorico h,800_usuarios u,9101_CatalogoProducto p WHERE p.idProducto=h.idProducto and u.idUsuario=h.responsableModif AND idCodigoGastoCiclo=".$idRegistroObjeto.
					" ORDER BY VERSION desc";	
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=$con->fetchRow($res))
		{
			
			if($fila[11]!=-1)
				$conCantidades="SELECT mes,cantidad FROM 9111_cantidaObjVSMesHistorico WHERE idCodigoGastoCicloHistorico=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMesHistorico WHERE idCodigoGastoCicloHistorico=".$fila[0]." order by mes";

			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			$obj='{"idCodigo":"'.$fila[0].'","cantidad":"'.cv($fila[2]).'","cadenaMeses":"'.cv($cadenaAux).'","costoUnitario":"'.cv($fila[3]).
					'","costoTotal":"'.($fila[4]).'","comentarios":"'.cv($fila[6]).'","responsableCambio":"'.$fila[8].'","fechaCambio":"'.$fila[9].
					'","proveedorSugerido":"'.$fila[7].'","tipoPresupuesto":"'.$fila[5].'","version":"'.$fila[1].'","producto":"'.str_replace('"','',$fila[10]).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		echo '{"registros":['.$arrDatos.']}';
	}
	
	
	function bloquearDesbloquearRequisicion()
	{
		global $con;	
		$arrCambios=$_POST["arrCambios"];
		$arrObj=json_decode($arrCambios);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrObj->arrCambios as $obj)
		{
			$consulta[$x]="update 9110_objetosGastoVSCiclo set modificable=".$obj->valor." where idCodigoGastoCiclo=".$obj->idRegistro;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarResultadoEvaluacion()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrRegistros as $registro)
		{
			$query="select numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$registro->idRegistro;
			$etapaAnt=$con->obtenerValor($query);
			if($etapaAnt=="")
				$etapaAnt=0;
			$consulta[$x]="update 9110_objetosGastoVSCiclo SET numEtapa=".$registro->etapaSomete." WHERE idCodigoGastoCiclo=".$registro->idRegistro;
			$x++;		
			$consulta[$x]="insert into 9110_bitacoraObjetosGastoVSCiclo(idCodigoGastoVSCiclo,etapaOrigen,etapaCambio,idResponsable,fechaCambio,comentarios) values
							(".$registro->idRegistro.",".$etapaAnt.",".$registro->etapaSomete.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($registro->comentarios)."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerBitacoraSolicitud()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="select (if(etapaOrigen=0,'Sin antecedentes',(select nombreEtapa from 4037_etapas where numEtapa=b.etapaOrigen and idProceso=".$idProceso."))) as eOrigen,etapaOrigen,
					(select nombreEtapa from 4037_etapas where numEtapa=b.etapaCambio and idProceso=".$idProceso.") as eCambio,etapaCambio,
					(select Nombre from 800_usuarios where idUsuario=b.idResponsable) as responsable,date_format(fechaCambio,'%d/%m/%Y') as fechaCambio,
					comentarios from 9110_bitacoraObjetosGastoVSCiclo b where idCodigoGastoVSCiclo=".$idRegistro." order by idBitacoraVSCiclo desc";
		$res=$con->obtenerFilas($consulta);
		$arrElem="";
		$obj="";
		while($fila=$con->fetchRow($res))
		{
			$obj="['".removerCerosDerecha($fila[1]).".- ".$fila[0]."','".removerCerosDerecha($fila[3]).".- ".$fila[2]."','".$fila[4]."','".$fila[5]."','".$fila[6]."']";
			if($arrElem=="")
				$arrElem=$obj;
			else
				$arrElem.=",".$obj;
		}
		echo "1|[".$arrElem."]";
	}
	
	function obtenerResponsablesPAT()
	{
		global $con;
		global $tipoServidor;
		$idProceso=$_POST["idProceso"];
		$tipoAsignacion=$_POST["tipoAsignacion"];
		$ciclo=$_POST["ciclo"];
		$comp="";
		switch($tipoAsignacion)
		{
			case 0:
			break;	
			case 1:
				$comp=" and codigoUnidad='".$_SESSION["codigoUnidad"]."'";
			break;
			case 2:
				$comp=" and (codigoUnidad='".$_SESSION["codigoUnidad"]."%' or codigoUnidad='".$_SESSION["codigoUnidad"]."')";
			break;
		}
		$arrRutas=obtenerCodigosRutas($ciclo);

		$consulta="select idResponsablePAT as idAsignacion,concat('[',o.codigoDepto,'] ',o.unidad) as departamento,r.codigoDepto as codDepto,
					concat(ruta,'.',idPrograma),(SELECT concat(cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma=r.idPrograma) as programa,
					idResponsable,(select Nombre from 800_usuarios where idUsuario=r.idResponsable) as responsable,ruta from 9116_responsablesPAT r, 817_organigrama o
					where o.codigoUnidad=r.codigoDepto and idProceso=".$idProceso.$comp." order by departamento";	
		$res=($con->obtenerFilas($consulta));
		$arrRegistros="";
		while($fila=$con->fetchRow($res))
		{

			if(isset($arrRutas[$fila[7]]))
			{
				$obj='{"idAsignacion":"'.$fila[0].'","departamento":"'.$fila[1].'","codDepto":"'.$fila[2].'","idPrograma":"'.$fila[3].'","programa":"['.$arrRutas[$fila[7]]." ".$fila[4].'","idResponsable":"'.$fila[5].'","responsable":"'.$fila[6].'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
			}
				
		}
		if($tipoServidor==2)
			echo '{"registros":['.($arrRegistros).']}';
		else
			echo '{"registros":['.($arrRegistros).']}';
	}
	
	function removerAsignacion()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];
		$consulta="delete from 9116_responsablesPAT where idResponsablePAT=".$idAsignacion;
		eC($consulta);
	}
	
	function buscarEmpleado()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$ambitoAsignacion=$_POST["ambitoAsignacion"];
		
		$comp="";
		$depto=$_SESSION["codigoUnidad"];
		switch($ambitoAsignacion)
		{
			case 0:
				
			break;
			case 1:
				$comp=" and a.codigoUnidad='".$depto."'";
			break;
			case 2:
				$comp=" and (a.codigoUnidad = '".$depto."' or a.codigoUnidad like '".$depto."%')";
			break;
		}
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select i.idUsuario,concat('[',i.idUsuario,'] <b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad 
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp."  and  Paterno like '".$criterio."%'   order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,concat('[',i.idUsuario,'] ',Paterno) as Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp." and  Materno like '".$criterio."%' order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,concat('[',i.idUsuario,'] ',Paterno) as Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad 
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp." and Nom like '".$criterio."%' order by Nom,Paterno,Materno asc)";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=$con->fetchRow($res))
		{
			$situaciones="";
			$departamento=$fila[7];
			$codigoDepto=$fila[6];

			
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'",
			"Status":"'.$situaciones.'","departamento":"'.$departamento.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}

	function agregarResponsableDeptoPAT()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$arrRuta=explode(".",$obj->programa);
		$consulta="INSERT INTO 9116_responsablesPAT(codigoDepto,idPrograma,idProceso,idResponsable,rolActor,ruta)
					VALUES('".$obj->depto."','".$arrRuta[1]."',".$obj->idProceso.",".$obj->idUsuario.",'".str_replace("|","_",$obj->rolAsigna)."','".$arrRuta[0]."')";
		eC($consulta);						
	}
	
	function guardarEstructura()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		if($obj->idRegistro=="-1")
		{
			$consulta="INSERT INTO 9117_estructuraPAT(grupoFuncional,funcion,subFuncion,programaGasto,actividadInstitucional,partidaPresupuestal,ciclo,codigoInstitucion,ruta)
						VALUES('".$obj->grupoFuncional."','".$obj->funcion."','".$obj->subfuncion."','".$obj->programaGasto."','".$obj->actividadInstitucional."','".$obj->partidaPresupuestal."'
						,".$obj->ciclo.",'".$obj->institucion."','".$obj->grupoFuncional."_".$obj->funcion."_".$obj->subfuncion."_".$obj->programaGasto."_".$obj->actividadInstitucional."_".$obj->partidaPresupuestal."')";
		}
		else
		{
			$consulta="update 9117_estructuraPAT set grupoFuncional='".$obj->grupoFuncional."',funcion='".$obj->funcion."',subFuncion='".$obj->subfuncion."',programaGasto='".$obj->programaGasto."',
					actividadInstitucional='".$obj->actividadInstitucional."',partidaPresupuestal='".$obj->partidaPresupuestal."',
					ruta='".$obj->grupoFuncional."_".$obj->funcion."_".$obj->subfuncion."_".$obj->programaGasto."_".$obj->actividadInstitucional."_".$obj->partidaPresupuestal."' where idEstructura=".$obj->idRegistro;

		}
		
		if($con->ejecutarConsulta($consulta))
		{
			
			$arrPMP=array();
			$arrPMP[0]="Sin clasificar";
			
			$consulta="SELECT id__872_tablaDinamica,txtTipoIndicador FROM _872_tablaDinamica ORDER BY txtTipoIndicador";
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchRow($res))
			{
				
				$arrPMP[$fila[0]]=$fila[1];
			}
			
			$query="SELECT idEstructura,grupoFuncional,funcion,subFuncion,programaGasto,actividadInstitucional,partidaPresupuestal,ruta FROM 9117_estructuraPAT where ciclo=".$obj->ciclo." and codigoInstitucion='".$obj->institucion."'
				order by  idEstructura";
			$arrRegistros="";
			$resRegistros=$con->obtenerFilas($query);
			while($fila=$con->fetchRow($resRegistros))
			{
				$query="SELECT idProgramaInstitucional FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."' and ciclo=".$obj->ciclo." AND institucion='".$obj->institucion."'";
				$listProg=$con->obtenerListaValores($query);
				if($listProg=="")
					$listProg="-1";
				$query="SELECT idPrograma,concat('[',cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma IN(".$listProg.") order by cvePrograma";
				$tblProg='<table><tr height="21"><td></td><td width="600" ><span class="letraRojaSubrayada8">Programas Institucional (PI)</span></td><td><span class="letraRojaSubrayada8">PMP</span></td></tr>';
				
				$resProg=$con->obtenerFilas($query);
				while($filaProg=$con->fetchRow($resProg))
				{
					$consulta="SELECT tipoIndicadorPMP FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."'  and idProgramaInstitucional=".$filaProg[0]." AND ciclo=".$obj->ciclo." AND institucion='".$obj->institucion."'";
					$tIndicador=$con->obtenerValor($consulta);
					$PMP=$arrPMP[$tIndicador];
					$btnDelete='<a href="javascript:removerPrograma(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img src="../images/delete.png" alt="Remover programa" title="Remover programa"></a>';
					$btnModifPMP='<a href="javascript:modificarPMP(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img width="13" height="13" src="../images/pencil.png" alt="Modificar PMP" title="Modificar PMP"></a>';
					$tblProg.='<tr height="21"><td width="55">'.$btnDelete.'&nbsp;<img src="../images/bullet_green.png">&nbsp;&nbsp;</td><td >'.$filaProg[1].'</td><td><span id="'.$fila[6]."_".$filaProg[0].'">'.$PMP.'</span> '.$btnModifPMP.'</td></tr>'	;
				}
				$tblProg.='</table>';
				$objAux="['".$fila[0]."','".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."','".$fila[6]."','".$tblProg."','".$fila[7]."']";
				if($arrRegistros=="")
					$arrRegistros=$objAux;
				else
					$arrRegistros.=",".$objAux;
				
			}
			$arrRegistros="[".$arrRegistros."]";	
			echo "1|".$arrRegistros;
		}
		
	}
	
	function eliminarEstructora()
	{
		global $con;
		$listRegistros=$_POST["listRegistros"];
		$consulta="delete from 9117_estructuraPAT where idEstructura in (".$listRegistros.")";
		eC($consulta);
	}
	
	function obtenerRecursosHumanosServicio()
	{
		global $con;
		$idServicio=$_POST["idServicio"];
		global $SO;
		
		$consulta="SELECT *FROM 9134_recursosVSservicio WHERE idServicio=".$idServicio;
		$res=$con->obtenerFilas($consulta);
		$nfilas=$con->filasAfectadas;
		
		$conNser="SELECT nombreServicio FROM 9132_servicios WHERE idServicio=".$idServicio;
		$nSer=$con->obtenerValor($conNser);
		
		$arrDatos="";
		while($filaM=$con->fetchRow($res))
		{
			$conPuesto="SELECT puesto FROM 819_puestosOrganigrama WHERE idPuesto=".$filaM[2];
			$puesto=$con->obtenerValor($conPuesto);
			
			$conUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$filaM[3]."'";
			$nombreU=$con->obtenerValor($conUnidad);
			
			$obj='{"idRecursoVSServicio":"'.$filaM[0].'","nombreP":"['.$nombreU.']'.$puesto.'","costoHora":"'.$filaM[4].'","minutos":"'.$filaM[5].'","unidades":"'.$filaM[6].'","costoTotal":"'.$filaM[7].'","nServicio":"'.$nSer.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nfilas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nfilas.'","registros":['.($arrDatos).']}';
		echo $obj;
	
	}
	
	function eliminarDepartamentoServicio()
	{
		global $con;
		$idServicio=$_POST["idServicio"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="DELETE FROM 9134_recursosVSservicio WHERE codigoUnidad='".$arreglo[$x]."' AND idServicio=".$idServicio;
				$ct++;
				$query[$ct]="DELETE FROM 9133_departamentoVSServicio WHERE codigoUnidad='".$arreglo[$x]."' AND idServicio=".$idServicio;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "1";
		}
	}
	
	function guardarDepartamentoServicio()
	{
		global $con;
		$idServicio=$_POST["idServicio"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
		  	{
			  $query[$ct]="INSERT INTO 9133_departamentoVSServicio(codigoUnidad,idServicio) VALUES(".$arreglo[$x].",'".$idServicio."')";
			  $ct++;
		  	}
		
		  	$query[$ct]="commit";
		  	if($con->ejecutarBloque($query))
			  	echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerPuestosDepartamento()
	{
		global $con;
		$cadena=$_POST["cadena"];
		
		$consulta="SELECT DISTINCT(u.idPuesto),puesto,codUnidad,unidad FROM  653_unidadesOrgVSPuestos u, 819_puestosOrganigrama p, 817_organigrama o 
					WHERE codUnidad IN (".$cadena.") AND u.idPuesto=p.idPuesto AND codUnidad=o.codigoUnidad ORDER BY puesto";
		$res=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($res);
		
	}
	
	function guardarRecursoServicio()
	{
		global $con;
		$codUnidad=$_POST["codigoUnidad"];
		$idPuesto=$_POST["idPuesto"];
		$unidades=$_POST["unidades"];
		$minutos=$_POST["minutos"];
		$idServicio=$_POST["idServicio"];
		
		$conNser="SELECT nombreServicio FROM 9132_servicios WHERE idServicio=".$idServicio;
		$nSer=$con->obtenerValor($conNser);
				
		
		$consulta="SELECT sueldoMinimo,sueldoMaximo,horasPuesto FROM 819_puestosOrganigrama WHERE idPuesto=".$idPuesto;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila[0]!=0 && $fila[1]!=0)
		{
			
			$promedio=($fila[0]+$fila[1])/2;
			
			$promSemana=$promedio/4;
			$costoHora=$promSemana/$fila[2];
			//$costoHora=number_format($costoHora,2,'.',',');
			
			$horas=$minutos/60;
			$totalUnit=$costoHora*$horas;
			
			$costoTotal=$totalUnit*$unidades;
			
			$costoTotalF=number_format($costoTotal,2,'.',',');
			
			//echo $costoTotalF ;
			
			$query="INSERT INTO 9134_recursosVSservicio (idServicio,idPuesto,codigoUnidad,costoHora,minutos,unidades,costoTotal)
					VALUES('".$idServicio."','".$idPuesto."','".$codUnidad."','".$totalUnit."','".$minutos."','".$unidades."','".$costoTotalF."')";
			
			if($con->ejecutarconsulta($query))
			{
				$conPuesto="SELECT puesto FROM 819_puestosOrganigrama WHERE idPuesto=".$idPuesto;
				$puesto=$con->obtenerValor($conPuesto);
				
				$conUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$codUnidad."'";
				$nombreU=$con->obtenerValor($conUnidad);
				
				$nombrePuesto="[".$nombreU."] ".$puesto;
				
				$idRecursoVSServicio=$con->obtenerUltimoID();
				echo "1|".$idRecursoVSServicio."|".$nombrePuesto."|".$totalUnit."|".$minutos."|".$unidades."|".$costoTotalF."|".$nSer;
			}
			else
			{
				echo "|";
			}
		}
	
	}
	
	function eliminarRecursoServicio()
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
			  $query[$ct]="DELETE FROM 9134_recursosVSservicio WHERE idRecursoVSServicio=".$arreglo[$x];
			  $ct++;
		  	}
		
		  	$query[$ct]="commit";
		  	if($con->ejecutarBloque($query))
			  	echo "1|";
			else
				echo "|";
		}
	}
	
	function eliminarServicio()
	{
		global $con;
		$idServicio=base64_decode($_POST["idServicio"]);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$query[$ct]="DELETE FROM 9134_recursosVSservicio WHERE idServicio=".$idServicio;
			$ct++;
			$query[$ct]="DELETE FROM 9132_servicios WHERE idServicio=".$idServicio;
			$ct++;
			$query[$ct]="DELETE FROM 9133_departamentoVSServicio WHERE idServicio=".$idServicio;
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerListadoSolicitudesPresupuesto() //Pendiente objeto gasto
	{
		global $con;
		global $con;
		global $SO;
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$idCiclo=bD($_POST["ciclo"]);
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		$capitulos=bD($_POST["capitulos"]);
		$idProceso=$_POST["idProceso"];
		$actor=$_POST["actor"];
		$etapa=$_POST["numEtapa"];
		$idActorProcesoEtapa=$_POST["idActorProcesoEtapa"];
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $tipoOG;
		$consulta="select numEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
		$resEtapas=$con->obtenerFilas($consulta);
		$arrPermisosEtapa=array();
		$arrEtapasOpciones="";
		$permisos="MEGB";
		/*while($filaEtapa=$con->fetchRow($resEtapas))
		{
			$permisos="ME";
			/*$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=1 and numEtapa=".$filaEtapa[0];
			$idAProcesoEtapa=$con->obtenerValor($consulta);	   
			if($idAProcesoEtapa=="")
				$idAProcesoEtapa="-1";
			$consulta="SELECT idGrupoAccion,complementario,idAccionesProcesoEtapaVSAcciones FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$idAProcesoEtapa;
			$arrAcciones=$con->obtenerFilasArregloPHP($consulta);
			$permisos="";
			if(existeValorMatriz($arrAcciones,"13")!=-1)
			{
				$permisos="['A','']";
			}
			if(existeValorMatriz($arrAcciones,"2")!=-1)
			{
				if($permisos=="")
					$permisos="['M','']";
				else
					$permisos.=",['M','']";
			}
			if(existeValorMatriz($arrAcciones,"7")!=-1)
			{
				if($permisos=="")
					$permisos.="['E','']";
				else
					$permisos.=",['E','']";
			}
			if(existeValorMatriz($arrAcciones,"6")!=-1)
			{
				if($permisos=="")
					$permisos="['B','']";	
				else
					$permisos.=",['B','']";	
			}
			$pos=existeValorMatriz($arrAcciones,"11");
			if($pos!=-1)
			{
				if($permisos=="")
					$permisos="['D','']";	
				else
					$permisos.=",['D','']";	
				$idAccionProceso=$arrAcciones[$pos][2];
				
				$consulta="SELECT valor,contenido,etapa FROM 9114_opcionesEvaluacion WHERE idAccion=".$idAccionProceso." AND idIdioma=".$_SESSION["leng"];
				$arrOpciones=$con->obtenerFilasArreglo($consulta);
				
				$obj="['".$filaEtapa[0]."',".$arrOpciones."]";
				if($arrEtapasOpciones=="")
					$arrEtapasOpciones=$obj;
				else
					$arrEtapasOpciones.=",".$obj;
			}*/
			/*$pos=existeValorMatriz($arrAcciones,"1");
			if($pos!=-1)
			{
				$etapaSomete=$arrAcciones[$pos][1];
				if($permisos=="")
					$permisos="['S','".$arrAcciones[$pos][1]."']";
				else
					$permisos.=",['S','".$arrAcciones[$pos][1]."']";
			}	   
			
			if(existeValorMatriz($arrAcciones,"14")!=-1)
			{
				if($permisos=="")
					$permisos="['G','']";	
				else
					$permisos.=",['G','']";	
			}
			$arrPermisosEtapa[removerCerosDerecha($filaEtapa[0])]="[".$permisos."]";
		}*/
		
		foreach($arrCapitulos as $c)
		{
			$cFin=substr($c,0,1);
			if($tipoOG==1)
				$cFin=str_pad($cFin,strlen($c),"9",STR_PAD_RIGHT);
			else
			{
				$cFin=str_pad($cFin,strlen($c)+1,"9",STR_PAD_RIGHT);
				$c.="0";
			}
			$particula="(c.clave>=".$c." and c.clave<=".$cFin.")";	
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					case 'list':
						if($arrFiltro[$x]["field"]=='nombreObj')
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.clave in (".$listaClaves.")";
						}
						
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		$condFiltro="";
		$consulta="SELECT idGrupoAccion,complementario FROM 947_actoresProcesosEtapasVSAcciones WHERE idGrupoAccion=11 and  idActorProcesoEtapa=".$idActorProcesoEtapa;
		/*$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$complementario=$fila[1];
			switch($complementario)
			{
				case 1:
					$condFiltro="";
				break;	
				case 2:
					$condFiltro=" and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
				break;	
				case 3:
					$condFiltro=" and idResponsable=".$_SESSION["idUsr"];
				break;	
				case 4:
					$condFiltro=" AND codDepto='".$codDepartamento."'";
				break;	
				case 5:
					$condFiltro=" AND codDepto like '".$codDepartamento."%'";
				break;	
				case 6:
					$condFiltro=" and idPrograma=".$idPrograma;
				break;	
				case 7:
					$condFiltro=" AND codDepto='".$codDepartamento."' and idPrograma=".$idPrograma;
				break;
			}
		}
		else
		{
			$consulta="SELECT idAccion,complementario FROM 949_actoresVSAccionesProceso WHERE idAccion=9 and  actor='".$actor."' and idProceso=".$idProceso;
			$fila=$con->obtenerPrimeraFila($consulta);
			if($fila)
			{
				$complementario=$fila[1];
				switch($complementario)
				{
					case 1:
						$condFiltro="";
					break;	
					case 2:
						$condFiltro=" and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
					break;	
					case 3:
						$condFiltro=" and idResponsable=".$_SESSION["idUsr"];
					break;	
					case 4:
						$condFiltro=" AND codDepto='".$codDepartamento."'";
					break;	
					case 5:
						$condFiltro=" AND codDepto like '".$codDepartamento."%'";
					break;	
					case 6:
						$condFiltro=" and idPrograma=".$idPrograma;
					break;	
					case 7:
						$condFiltro=" AND codDepto='".$codDepartamento."' and idPrograma=".$idPrograma;
					break;
				}
			}
		}*/
		
		$consulta="SELECT idCodigoGastoCiclo,c.clave,CONCAT('[',c.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, org.unidad,montoTotal,c.modificable,
					(SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=c.numEtapa) as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND c.clave=o.clave AND p.idProducto=c.idProducto ".$condWhere." order by nombreProducto limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(idCodigoGastoCiclo)
			   FROM 9110_objetosGastoVSCiclo c
			   WHERE idCiclo=".$idCiclo.$condFiltro."  AND 
			   ".$cadCapitulos." ".$condWhere;
		   
		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"'.$permisos.'","numEtapa":"'.$fila[18].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$sqlQuery=bE("SELECT idCodigoGastoCiclo  FROM 9110_objetosGastoVSCiclo c  WHERE idCiclo=".$idCiclo.$condFiltro."  AND ".$cadCapitulos." ".$condWhere);
		if($SO==2)
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function guardarCostoServicio()
	{
		global $con;
		$idServicio=$_POST["idServicio"];
		$costoTotal=$_POST["costoT"];
		
		$query="UPDATE 9132_servicios SET  costo='".$costoTotal."' WHERE idServicio=".$idServicio;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	
	function obtenerCandidatosSolicitud()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		
		$consulta="SELECT c.idUsuario,Nombre FROM 802_identifica i, 4231_candidatosSolicitud  c WHERE i.idUsuario=c.idUsuario AND idSolicitud=".$idSolicitud." AND estado=0";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arreglo);
	}
	
	function marcarCandidatosSolicitud()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$idSolicitud=$_POST["idSolicitud"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
		  	{
			  $query[$ct]="UPDATE 4231_candidatosSolicitud SET estado=1 WHERE idSolicitud=".$idSolicitud." AND idUsuario=".$arreglo[$x];
			  $ct++;
		  	}
		
		  	$query[$ct]="commit";
		  	if($con->ejecutarBloque($query))
			  	echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerCandidatosSeleccionados()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idSolicitud=$_POST["idSolicitud"];
		
		$consulta="SELECT c.idUsuario,Nombre FROM 802_identifica i, 4231_candidatosSolicitud  c WHERE i.idUsuario=c.idUsuario AND idFormulario=".$idFormulario." and  idSolicitud=".$idSolicitud." AND estado=1";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arreglo);
	}
	
	function obtenerPartidasComiteDisponible()
	{
		global $con;
		global $tipoOG;
		global $SO;
		
		$idProceso=$_POST["idProceso"];
		$arrComite=explode("_",$_POST["idComite"]);
		$idComite=$arrComite[1];
		
		$consulta="SELECT capitulo FROM 9044_capitulosProcesoPresupuesto WHERE idProcesoPresupuesto=".$idProceso;
		$resCap=$con->obtenerFilas($consulta);	
		$cadCapitulos="";
		while($filaCap=$con->fetchRow($resCap))
		{
			$cControl=$filaCap[0];
			$particula="(o.codigoControlPadre like '".$cControl."%')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}	
		if($cadCapitulos!="")
			$cadCapitulos="  (".$cadCapitulos.")";
		$consulta="select partida from 9044_proyectoComitePartida where idProyectoComite=".$idComite;
		$listPartidas=$con->obtenerListaValores($consulta,"'");
		if($listPartidas=="")
			$listPartidas="-1";
		$consulta="SELECT codigoControl,clave as partida,nombreObjetoGasto as descripcion FROM 507_objetosGasto o WHERE ".$cadCapitulos." and clave not in (".$listPartidas.") and nivel=2";
		$arrPartidas=$con->obtenerFilasJson($consulta);
		
		if($SO==1)
			echo '{"registros":'.($arrPartidas).'}';
		else
			echo '{"registros":'.utf8_encode($arrPartidas).'}';
		
	}
		
	function guardarPartidaComite()
	{
		global $con;
		$arrComite=explode("_",$_POST["iC"]);	
		$listPartida=$_POST["listPartida"];
		$idComite=$arrComite[1];
		$arrPartidas=explode(",",$listPartida);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPartidas as $p)
		{
			$consulta[$x]="insert into 9044_proyectoComitePartida(idProyectoComite,partida) values(".$idComite.",'".$p."')";
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function modificarVacanteSeleccionados()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$idUsuario=$_POST["idUsuario"];
		$fecha=date('Y-m-d');
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$query[$ct]="UPDATE 667_puestosVacantes SET STATUS=0,fechaCambio='".$fecha."' WHERE idRegistroPerfil=".$idSolicitud;
			$ct++;
			$query[$ct]="UPDATE 4231_candidatosSolicitud SET estado=3 WHERE idSolicitud=".$idSolicitud." AND idUsuario=".$idUsuario;
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function enviarContrato()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$idSolicitud=$_POST["idSolicitud"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
		  	{
			  $query[$ct]="UPDATE 4231_candidatosSolicitud SET estado=2 WHERE idSolicitud=".$idSolicitud." AND idUsuario=".$arreglo[$x];
			  $ct++;
		  	}
		
		  	$query[$ct]="commit";
		  	if($con->ejecutarBloque($query))
			  	echo "1|";
			else
				echo "|";
		}
	
	}
	
	function verElegidos()
	{
		global $con;
		$idSolicitud=$_POST["idSolicitud"];
		$consulta="SELECT c.idUsuario,Nombre FROM 802_identifica i, 4231_candidatosSolicitud  c WHERE i.idUsuario=c.idUsuario AND idSolicitud=".$idSolicitud." AND estado=2";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arreglo);
	}

	function generarPresupuestoAutorizado()
	{
		global $con;	
		$ciclo=$_POST["ciclo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrConceptos=array();
		$arrProductosAutorizados=array();
		$tMovimiento=6;
		$rPresupuesto=new cPresupuesto();
		$rContabilidad=new cContabilidad();

		$folio="";
		$query="SELECT idAlmacen,nombreAlmacen FROM 9030_almacenes";
		$resAl=$con->obtenerFilas($query);
		$arrAlmacenes=array();
		while($filaAl=$con->fetchRow($resAl))
		{
			$arrAlmacenes[$filaAl[0]]=$filaAl[1];
		}
		$folio=$rPresupuesto->obtenerFolioSiguiente($tMovimiento);
		$arrObjAsientos=array();
		$arrAsientosContables=array();

		  $query="SELECT concat(idProducto,'_',tipoPresupuesto),cantidad,costoUnitario,idCodigoGastoCiclo,clave,idCabecera,idPrograma,
		  		codDepto,clave,tipoPresupuesto,idProducto,ruta FROM 9110_objetosGastoVSCiclo WHERE idCiclo=".$ciclo." and codInstitucion='".$_SESSION["codigoInstitucion"]."' 
				and numEtapa=5 and cantidad>0 and cabecera=0";

		  $resProductos=$con->obtenerFilas($query);
		  $idLibro=$rContabilidad->generarLibroDelDia();
		  $ctAux=0;
		  while($fProducto=$con->fetchRow($resProductos))
		  {
			  $ctAux++;
			  $c=$fProducto[3];
			  $idProducto=$fProducto[0];
			  $cantidad=$fProducto[1];
			  $costoUnitario=$fProducto[2];
			  $tProducto=1;
  			  $idAlmacen="";
			  $nAlmacen="";
			  if(($fProducto[5]!="")&&($fProducto[5]!=0))
			  {
				$tProducto=2;
				
				$idProducto=$fProducto[5]*-1;
			  }
			  else
			  {
				  $query="select idAlmacen from 9101_CatalogoProducto WHERE idProducto=".$fProducto[10];

				  $idAlmacen=$con->obtenerValor($query);
				  if($idAlmacen!="")
				  {
				  	 $nAlmacen=$arrAlmacenes[$idAlmacen];
				  }
				  else
				  {
				  	$idAlmacen=-1;
					$nAlmacen="Sin almacén";
				  }
				  	//echo $fProducto[10];
				 
			  }
			  
			  $totalOperacion=$costoUnitario*$cantidad;
				
				
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fProducto[6];
			$arrDimensiones["departamento"]=$fProducto[7];
			$arrDimensiones["partida"]=$fProducto[8];
			$arrDimensiones["tipoPresupuesto"]=$fProducto[9];
			if($idAlmacen!="")
				$arrDimensiones["idAlmacen"]=$idAlmacen;
			$arrDimensiones["ciclo"]=$ciclo;
			$arrDimensiones["ruta"]=$fProducto[11];

			
			
			
				
			$cadObj='{
						"tipoMovimiento":"'.$tMovimiento.'",
						"folio":"'.$folio.'",
						"montoOperacion":"'.$totalOperacion.'",
						"dimensiones":""
					}';
				
				$o=json_decode($cadObj);
				$o->dimensiones=$arrDimensiones;
				
				
				array_push($arrAsientosContables,$o);
			  
			  
			  if(!isset($arrProductosAutorizados[$idProducto]))
			  {
				  
				  $arrProductosAutorizados[$idProducto]["total"]=$cantidad;
				  $arrProductosAutorizados[$idProducto]["costoUnitario"]=$costoUnitario;
				  $arrProductosAutorizados[$idProducto]["objetoGasto"]=$fProducto[4];
				  $arrProductosAutorizados[$idProducto]["tipoProducto"]=$tProducto;
				  $arrProductosAutorizados[$idProducto]["desgloce"]=array();
				  for($nCt=0;$nCt<12;$nCt++)
				  {
					  $arrProductosAutorizados[$idProducto]["desgloce"][$nCt]=0;
				  }
			  }
			  else
				  $arrProductosAutorizados[$idProducto]["total"]+=$cantidad;
				  
			  $consulta[$x]="insert into 525_productosAutorizados select * from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$c;	
			  $x++;
			  $consulta[$x]="insert into 526_distribucionAutorizada select * from 9111_cantidaObjVSMes where idCodigoGastoCiclo=".$c;	
			  $x++;
			  $query="select * from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$c;	
			  $fila=$con->obtenerPrimeraFila($query);
			  $monto="";
			  $coordenada=$fila[10]."_".$fila[3]."_".$fila[1]."_".$fila[19]."_".str_replace("_",".",$fila[21]); 
			  if(!isset($arrConceptos[$coordenada]))
			  {
				  $arrConceptos[$coordenada]["monto"]=$fila[16];	
				  $arrConceptos[$coordenada]["institucion"]=$fila[4];
				  $query="SELECT mes,cantidad,monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$c;
				  $resDist=$con->obtenerFilas($query);
				  $arrDist=array();
				  while($fDist=$con->fetchRow($resDist))
				  {
					 if($fila[25]=="")
						  $monto=$fDist[1]*$fila[15];
					  else
					  	$monto=$fDist[2];
					  $arrDist[$fDist[0]]=$monto;
					  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]=array();
					  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["cantidad"]=$fDist[1];
					  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["monto"]=$monto;
				  }
				  $arrConceptos[$coordenada]["distibucion"]=$arrDist;
			  }
			  else
			  {
				  $arrConceptos[$coordenada]["monto"]+=$fila[16];	
				  $query="SELECT mes,cantidad,monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$c;
				  $resDist=$con->obtenerFilas($query);
				  $arrDist=array();
				  while($fDist=$con->fetchRow($resDist))
				  {
   				   		if($fila[25]=="")
						  $monto=$fDist[1]*$fila[15];
					  else
					  	$monto=$fDist[2];
					  $arrConceptos[$coordenada]["distibucion"][$fDist[0]]+=$monto;
					  if(isset($arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["cantidad"]))
					  {
						  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["cantidad"]+=$fDist[1];
						  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["monto"]+=$monto;
					  }
					  else
					  {
						  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]=array();
						  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["cantidad"]=$fDist[1];
						  $arrProductosAutorizados[$idProducto]["desgloce"][$fDist[0]]["monto"]=$monto;
					  }
				  }
			  }
		  }
		  //varDump($arrProductosAutorizados);
		  
		$tPresupuestal="1";
		$tMovimiento=7;
		$rContabilidad->asentarArregloMovimientos($arrAsientosContables,$consulta,$x);
		
		if(sizeof($arrConceptos)>0)
		{
			
			foreach($arrConceptos as $concepto=>$resto)
			{
				$datosConcepto=explode("_",$concepto);
				$cControl=$datosConcepto[2];
				$codCapitulo=substr($cControl,0,3);
				$ruta=$datosConcepto[4];
				$ruta=str_replace(".","_",$ruta);
				$capitulo=$codCapitulo;
				$consulta[$x]="INSERT INTO 523_presupuestoAutorizado(ciclo,programa,depto,capitulo,partida,montoTotal,montoAjustado,tipoPresupuesto,institucion,ruta)
								VALUES(".$ciclo.",".$datosConcepto[0].",'".$datosConcepto[1]."','".$capitulo."','".$datosConcepto[2]."',".$resto["monto"].",".$resto["monto"].",".$datosConcepto[3].",'".$resto["institucion"]."','".$ruta."')";
				$x++;
				$consulta[$x]="set @idRegistro=(select LAST_INSERT_ID())";
				$x++;
				$totalOperacion=0;
				foreach($resto["distibucion"] as $nDist=>$d)
				{
					$consulta[$x]="INSERT INTO 523_distribucionPresupuestoAutorizado(idPresupuestoAutorizado,nDistribucion,monto,montoAjustado)
									VALUES(@idRegistro,".$nDist.",".$d.",".$d.")";
					$x++;
					
					$cadObj='{
								"tipoMovimiento":"'.$tMovimiento.'",
								"folio":"'.$folio.'",
								"montoOperacion":"'.$d.'",
								"dimensiones":""
							}';
					
					$arrDimensiones=array();
					$arrDimensiones["mes"]=$nDist;
					$arrDimensiones["idPrograma"]=$datosConcepto[0];
					$arrDimensiones["ruta"]=$ruta;
					$arrDimensiones["ciclo"]=$ciclo;
					$arrDimensiones["departamento"]=$datosConcepto[1];
					$arrDimensiones["capitulo"]=$capitulo;
					$arrDimensiones["partida"]=$datosConcepto[2];
					$arrDimensiones["tipoPresupuesto"]=$datosConcepto[3];
					$totalOperacion+=$d;
					$obj=json_decode($cadObj);
					$obj->dimensiones=$arrDimensiones;
					array_push($arrObjAsientos,$obj);
					
				}
				
			}
			$rContabilidad->asentarArregloMovimientos($arrObjAsientos,$consulta,$x);
			
		}
		if(sizeof($arrProductosAutorizados)>0)
		{
			foreach($arrProductosAutorizados as $idProducto=>$resto)
			{
				$arrProducto=explode("_",$idProducto);
				$objetoGasto=$resto["objetoGasto"];
				$tipoProducto=$resto["tipoProducto"];
				$idCategoriaProducto="";
				if($tipoProducto==2)
				{
					$idProducto*=-1;
					$idCategoriaProducto=0;	
				}
				else
				{
					$query="select idCategoria from 9101_CatalogoProducto where idProducto=".$arrProducto[0];
					$idCategoriaProducto=$con->obtenerValor($query);
					if($idCategoriaProducto=="")
						$idCategoriaProducto=0;
				}
				
				
				$consulta[$x]="insert into 527_concentradoProducto(idProducto,cantidad,costoUnitario,total,estado,ciclo,codigoInstitucion,objetoGasto,tipoReferencia,tipoProducto,fuenteFinanciamiento,idCategoriaProducto)
								VALUES(".$arrProducto[0].",".$resto["total"].",".$resto["costoUnitario"].",".($resto["costoUnitario"]*$resto["total"]).",0,".$ciclo.",'".$_SESSION["codigoInstitucion"]."','".$objetoGasto.
								"',0,".$tipoProducto.",".$arrProducto[1].",".$idCategoriaProducto.")";	


				$x++;
				$consulta[$x]="set @idRegistro=(select LAST_INSERT_ID())";
				$x++;

				foreach($resto["desgloce"] as $d=>$obj)
				{
					if(isset($obj["cantidad"]))
					{
						$consulta[$x]="INSERT INTO 528_distribucionConcentrado(idCompraVSProducto,mes,cantidad,monto) values(@idRegistro,".$d.",".$obj["cantidad"].",".$obj["monto"].")";	
						$x++;	
						
					}
					else
					{
						$consulta[$x]="INSERT INTO 528_distribucionConcentrado(idCompraVSProducto,mes,cantidad,monto) values(@idRegistro,".$d.",0,0)";	
						$x++;
					}
					
				}
			}
			
		}
		$consulta[$x]=" UPDATE 527_concentradoProducto c SET solicitudesComprende=(IF(tipoProducto=1,(SELECT GROUP_CONCAT(idCodigoGastoCiclo) FROM 525_productosAutorizados WHERE idProducto=c.idProducto AND idCiclo=c.ciclo and tipoPresupuesto=c.fuenteFinanciamiento),
					 (SELECT GROUP_CONCAT(idCodigoGastoCiclo) FROM 525_productosAutorizados WHERE idCabecera=c.idProducto AND idCiclo=c.ciclo and tipoPresupuesto=c.fuenteFinanciamiento))) where ciclo=".$ciclo;
		$x++;
		$consulta[$x]="INSERT INTO 2000_cierresCicloProcesos(ciclo,codigoInstitucion,fechaCierre,idResponsableCierre,tipoCierre) values(".$ciclo.",'".$_SESSION["codigoInstitucion"]."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",10)";
		$x++;
		$consulta[$x]="commit";
		$x++;
		/*foreach($consulta as $c)
		{
			echo $c.";";
		}*/
		eB($consulta);
	}
	
	function removerDefinicionEstruturaProg()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$institucion=$_POST["institucion"];
		$x=0;
		$consulta[$x]="begin";		
		$x++;
		$consulta[$x]="delete from 9117_definicionEstructuraProgramatica where ciclo='".$ciclo."' and codigoInstitucion='".$institucion."'";		
		$x++;
		$consulta[$x]="delete from 9117_estructuraPAT where ciclo='".$ciclo."' and codigoInstitucion='".$institucion."'";	
		$x++;
		$consulta[$x]="commit";		
		$x++;
		eB($consulta);
		
	}
	
	function crearNuevaDefinicionEstructura()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$institucion=$_POST["institucion"];
		$consulta="insert into 9117_definicionEstructuraProgramatica(ciclo,codigoInstitucion) values(".$ciclo.",'".$institucion."')";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT ciclo,situacion FROM 9117_definicionEstructuraProgramatica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' ORDER BY ciclo";
			$arrDefinicion=$con->obtenerFilasArreglo($consulta);	
			echo "1|".$arrDefinicion;
		}
	
	}
	
	function obtenerCicloDisponibles()
	{
		global $con;
		$institucion=$_POST["institucion"];
		$consulta="SELECT ciclo FROM 9117_definicionEstructuraProgramatica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' ORDER BY ciclo";
		$listCiclo=$con->obtenerListaValores($consulta);
		if($listCiclo=="")
			$listCiclo="-1";
		$consulta="select ciclo,ciclo FROM 550_cicloFiscal WHERE codigoInstitucion='".$institucion."' AND ciclo NOT IN (".$listCiclo.")";	
		$arrCiclos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCiclos;
		
	}
	
	function modificarSituacionEstructura()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$institucion=$_POST["institucion"];
		$valor=$_POST["valor"];
		$consulta="update 9117_definicionEstructuraProgramatica set situacion=".$valor." where ciclo=".$ciclo." and codigoInstitucion='".$institucion."'";
		eC($consulta);
			
	}
	
	function obtenerProgramasPlaneacionDisp()
	{
		
		global $con;
		$ciclo=$_POST["ciclo"];

		//$consulta="SELECT idProgramaInstitucional FROM 9117_estructurasVSPrograma WHERE ciclo=".$ciclo." AND institucion='".$institucion."'";
		//$listProg=$con->obtenerListaValores($consulta);
		//if($listProg=="")
		$listProg="-1";
		if(isset($_POST["excluir"]))
		{
			$consulta="SELECT situacion,idPerfilEstructura,idDefinicion FROM 9117_definicionEstructuraProgramatica WHERE ciclo=".$ciclo;
			$fDefinicion=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT idProgramaInstitucional FROM 9117_estructurasVSPrograma e,9117_detalleEstructuraProgramatica d WHERE idPartidaPresupuestal=d.idDetalle AND idDefinicion=".$fDefinicion[2];

			$listProg=$con->obtenerListaValores($consulta);
			if($listProg=="")
				$listProg=-1;
		}
		$consulta="SELECT idPrograma ,concat('[',cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma NOT IN(".$listProg.") and estado=1";
		if(isset($_POST["institucion"]))
			$consulta.=" and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
			
			
		$consulta.=" order by cvePrograma";	

		$arrProgramas=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrProgramas;

	}	
	
	function guardarProgramasPlaneacion()
	{
		global $con;
		$tipoIndicador=$_POST["tipoIndicador"];
		$situacion=$_POST["situacion"];	
		$listaProgramas=$_POST["listaProgramas"];
		$ciclo=$_POST["ciclo"];
		$institucion=$_POST["institucion"];
		$partida=$_POST["partida"];
		$ruta=$_POST["ruta"];
		$arrProgramas=explode(",",$listaProgramas);
		
		
		$arrPMP=array();
		$arrPMP[0]="Sin clasificar";
		$arrIndicadores="[['0','Sin clasificar']";
		$query="SELECT id__872_tablaDinamica,txtTipoIndicador FROM _872_tablaDinamica ORDER BY txtTipoIndicador";
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			
			$arrPMP[$fila[0]]=$fila[1];
		}
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrProgramas as $programa)
		{
			$consulta[$x]="insert into 9117_estructurasVSPrograma(idPartidaPresupuestal,idProgramaInstitucional,ciclo,institucion,tipoIndicadorPMP,ruta) values('".$partida."',".$programa.",".$ciclo.",'".$institucion."',".$tipoIndicador.",'".$ruta."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			$query="SELECT idEstructura,grupoFuncional,funcion,subFuncion,programaGasto,actividadInstitucional,partidaPresupuestal,ruta FROM 9117_estructuraPAT where ciclo=".$ciclo." and codigoInstitucion='".$institucion."'
				order by  idEstructura";
			$arrRegistros="";
			$resRegistros=$con->obtenerFilas($query);
			while($fila=$con->fetchRow($resRegistros))
			{
				$query="SELECT idProgramaInstitucional FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."' and ciclo=".$ciclo." AND institucion='".$institucion."'";
				$listProg=$con->obtenerListaValores($query);
				if($listProg=="")
					$listProg="-1";
				$query="SELECT idPrograma,concat('[',cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma IN(".$listProg.") order by cvePrograma";
				$tblProg='<table><tr height="21"><td></td><td width="600" ><span class="letraRojaSubrayada8">Programas Institucional (PI)</span></td><td><span class="letraRojaSubrayada8">PMP</span></td></tr>';
				
				$resProg=$con->obtenerFilas($query);
				while($filaProg=$con->fetchRow($resProg))
				{
					$consulta="SELECT tipoIndicadorPMP FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."'  and idProgramaInstitucional=".$filaProg[0]." AND ciclo=".$ciclo." AND institucion='".$_SESSION["codigoInstitucion"]."'";
					$tIndicador=$con->obtenerValor($consulta);
					$PMP=$arrPMP[$tIndicador];
					$btnDelete='<a href="javascript:removerPrograma(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img src="../images/delete.png" alt="Remover programa" title="Remover programa"></a>';
					$btnModifPMP='<a href="javascript:modificarPMP(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img width="13" height="13" src="../images/pencil.png" alt="Modificar PMP" title="Modificar PMP"></a>';
					$tblProg.='<tr height="21"><td width="55">'.$btnDelete.'&nbsp;<img src="../images/bullet_green.png">&nbsp;&nbsp;</td><td >'.$filaProg[1].'</td><td><span id="'.$fila[7]."_".$filaProg[0].'">'.$PMP.'</span> '.$btnModifPMP.'</td></tr>'	;
				}
				$tblProg.='</table>';
				$obj="['".$fila[0]."','".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."','".$fila[6]."','".$tblProg."','".$fila[7]."']";
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				
			}
			$arrRegistros="[".$arrRegistros."]";	
			echo "1|".$arrRegistros;	
		}
		
	}
	
	function removerProgramaPlaneacion()
	{
		global $con;
		$ciclo=$_POST["ciclo"]	;
		$institucion=$_POST["institucion"];
		$idPrograma=$_POST["idPrograma"];
		$idPartida=$_POST["idPartida"];
		$consulta="delete from 9117_estructurasVSPrograma where ruta='".$idPartida."' and idProgramaInstitucional=".$idPrograma." and ciclo=".$ciclo." and institucion='".$institucion."'";

		$arrPMP=array();
		$arrPMP[0]="Sin clasificar";
		$arrIndicadores="[['0','Sin clasificar']";
		$query="SELECT id__872_tablaDinamica,txtTipoIndicador FROM _872_tablaDinamica ORDER BY txtTipoIndicador";
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			
			$arrPMP[$fila[0]]=$fila[1];
		}

		if($con->ejecutarConsulta($consulta))
		{
			$query="SELECT idEstructura,grupoFuncional,funcion,subFuncion,programaGasto,actividadInstitucional,partidaPresupuestal,ruta FROM 9117_estructuraPAT where ciclo=".$ciclo." and codigoInstitucion='".$institucion."'
				order by idEstructura";
			$arrRegistros="";
			$resRegistros=$con->obtenerFilas($query);
			while($fila=$con->fetchRow($resRegistros))
			{
				$query="SELECT idProgramaInstitucional FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."' AND ciclo=".$ciclo." AND institucion='".$institucion."'";
				$listProg=$con->obtenerListaValores($query);
				if($listProg=="")
					$listProg="-1";
				$query="SELECT idPrograma,concat('[',cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma IN(".$listProg.") order by cvePrograma";
				$tblProg='<table><tr height="21"><td></td><td width="600"><span class="letraRojaSubrayada8">Programas Institucional (PI)</span></td><td><span class="letraRojaSubrayada8">PMP</span></td></tr>';
				
				$resProg=$con->obtenerFilas($query);
				while($filaProg=$con->fetchRow($resProg))
				{
					$consulta="SELECT tipoIndicadorPMP FROM 9117_estructurasVSPrograma WHERE ruta='".$fila[7]."'  and idProgramaInstitucional=".$filaProg[0]." AND ciclo=".$ciclo." AND institucion='".$_SESSION["codigoInstitucion"]."'";
					$tIndicador=$con->obtenerValor($consulta);
					$PMP=$arrPMP[$tIndicador];
					$btnDelete='<a href="javascript:removerPrograma(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img src="../images/delete.png" alt="Remover programa" title="Remover programa"></a>';
					$btnModifPMP='<a href="javascript:modificarPMP(\\\''.bE($filaProg[0]).'\\\',\\\''.bE($fila[7]).'\\\')"><img width="13" height="13" src="../images/pencil.png" alt="Modificar PMP" title="Modificar PMP"></a>';
					$tblProg.='<tr height="21"><td width="55">'.$btnDelete.'&nbsp;<img src="../images/bullet_green.png">&nbsp;&nbsp;</td><td >'.$filaProg[1].'</td><td><span id="'.$fila[7]."_".$filaProg[0].'">'.$PMP.'</span> '.$btnModifPMP.'</td></tr>'	;
				}
				$tblProg.='</table>';
				$obj="['".$fila[0]."','".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."','".$fila[6]."','".$tblProg."','".$fila[7]."']";
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				
			}
			$arrRegistros="[".$arrRegistros."]";	
			echo "1|".$arrRegistros;
		}
	}
	
	function obtenerPresupuesto1000()
	{
		global $con;
		$ciclo=	bD($_POST["ciclo"]);
		$programas=bD($_POST["programas"]);
		$idProceso=$_POST["idProceso"];
		$query="SELECT partidas FROM 9044_capitulosProcesoPresupuesto WHERE idProcesoPresupuesto=".$idProceso." AND (capitulo=1000 or capitulo=3000)";
		$partidas=$con->obtenerValor($query);
		$query="select clave from 507_objetosGasto where codigoControl in (".$partidas.")";
		$listClaves=$con->obtenerListaValores($query);
		$arrProgramas=explode(",",$programas);
		$arrPartidas=explode(",",$partidas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($programas!="0")
		{
			foreach($arrProgramas as $p)
			{
				if(sizeof($arrPartidas)>0)
				{
					foreach($arrPartidas as $pa)
					{
						$query="select clave from 507_objetosGasto where codigoControl=".$pa."";
						$clave=$con->obtenerValor($query);
						$query="SELECT * FROM 9110_objetosGastoVSCiclo WHERE idProducto=-1 and idCiclo=".$ciclo." AND idPrograma=".$p." AND clave=".$clave;	
						$fila=$con->obtenerPrimeraFila($query);
						if(!$fila)
						{
							$query="insert into 9110_objetosGastoVSCiclo(idProducto,idCiclo,clave,codInstitucion,codDepto,idPrograma,idResponsable,fechaSolicitud,montoTotal,numEtapa,modificable,tipoPresupuesto,version,costoUnitario,cantidad)
										values(-1,".$ciclo.",".$clave.",'".$_SESSION["codigoInstitucion"]."','".$_SESSION["codigoInstitucion"]."',".$p.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',0,1,1,1,1,1,0)";
							
							if(!$con->ejecutarConsulta($query))
								return;
							$idObjetoGasto=$con->obtenerUltimoID();
							for($mes=0;$mes<12;$mes++)
							{
								$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad) VALUES(".$idObjetoGasto.",".$mes.",0)";
								$x++;
							}
						}
					}
				}
			}
			
			$consulta[$x]="commit";
			$x++;
			$con->ejecutarBloque($consulta);
			$query="select idCodigoGastoCiclo,clave,idCiclo,(SELECT nombreObjetoGasto FROM 507_objetosGasto WHERE clave=o.clave) as nombreProducto,montoTotal,(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=o.idPrograma),
			(select Nombre from 800_usuarios where idusuario=o.idResponsable),(SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=o.tipoPresupuesto),numEtapa from 9110_objetosGastoVSCiclo o where idPrograma in (".$programas.")
			and idCiclo=".$ciclo." and idProducto=-1 and clave in (".$listClaves.")";
			
		}
		else
		{
			$query="select idCodigoGastoCiclo,clave,idCiclo,(SELECT nombreObjetoGasto FROM 507_objetosGasto WHERE clave=o.clave) as nombreProducto,montoTotal,(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=o.idPrograma),
			(select Nombre from 800_usuarios where idusuario=o.idResponsable),(SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=o.tipoPresupuesto),numEtapa from 9110_objetosGastoVSCiclo o where
			idCiclo=".$ciclo." and idProducto=-1 and numEtapa in(2,3) and clave in (".$listClaves.")";
			
		}
		$sql=bE($query);
		$res=$con->obtenerFilas($query);
		$arrObjetos="";
		while($fila=$con->fetchRow($res))
		{
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.$fila[1].'","idCiclo":"'.$fila[2].'","nombreProducto":"'.$fila[3].'","montoTotal":"'.$fila[4].'","programa":"'.$fila[5].'","responsableSolicitud":"'.$fila[6].
			'","tipoPresupuesto":"'.$fila[7].'","numEtapa":"'.$fila[8].'"';
			$query="SELECT mes,cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes asc";
			$resMes=$con->obtenerFilas($query);
			while($filaMes=$con->fetchRow($resMes))
			{
				$obj.=',"mes'.$filaMes[0].'":"'.$filaMes[1].'"';
			}
			$obj.='}';

			if($arrObjetos=="")
				$arrObjetos=$obj;
			else
				$arrObjetos.=",".$obj;
				
		}
		
		echo '{"sql":"'.$sql.'","registros":['.$arrObjetos.']}';
		
	}
	
	function guardarRequerimientoMes()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$mes=$_POST["mes"];
		$valor=$_POST["valor"];
		$x=0;
		$query="begin";
		if(!$con->ejecutarConsulta($query))
			return;
		$query="UPDATE 9111_cantidaObjVSMes SET cantidad=".$valor." WHERE mes=".$mes." AND idCodigoGastoCiclo=".$idRegistro;
		if(!$con->ejecutarConsulta($query))
			return;
		$query="select sum(cantidad) from 9111_cantidaObjVSMes where idCodigoGastoCiclo=".$idRegistro;
		$mTotal=$con->obtenerValor($query);
		$consulta[$x]="UPDATE 9110_objetosGastoVSCiclo set montoTotal=".$mTotal." , cantidad=1 where idCodigoGastoCiclo=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".$mTotal;
		}
	}
	
	function someterEvaluacionPartida1000()
	{
		global $con;
		$registros=$_POST["registros"];
		$consulta="UPDATE 9110_objetosGastoVSCiclo SET numEtapa =2 WHERE idCodigoGastoCiclo IN (".$registros.")";
		eC($consulta);
	}
	
	function obtenerDatosContrato()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT DISTINCT(idContrato) FROM 562_prorrateoContratos";
		$listContratos=$con->obtenerListaValores($consulta);
		if($listContratos=="")
			$listContratos="-1";
		$consulta="SELECT UPPER(t.noContrato),t.montoContrato,txtRazonSocial2,t.id__751_tablaDinamica FROM _751_tablaDinamica t,_405_tablaDinamica p WHERE p.id__405_tablaDinamica=t.cmbProveedor AND  t.noContrato LIKE '%".$criterio."%'
				and id__751_tablaDinamica not in (".$listContratos.")"	;

		$resContratos=$con->obtenerFilas($consulta);
		$arrObjetos="";
		while($filaContrato=$con->fetchRow($resContratos))
		{
			$obj='{"idContrato":"'.$filaContrato[3].'","contrato":"'.str_replace(strtoupper($criterio),"<b>".strtoupper($criterio)."</b>",$filaContrato[0]).'","monto":"$ '.number_format($filaContrato[1]).'","proveedor":"'.cv($filaContrato[2]).'"}';
			if($arrObjetos=="")
				$arrObjetos=$obj;
			else
				$arrObjetos.=",".$obj;
		}
		$arrObjetos="[".$arrObjetos."]";
		echo '{"num":"","contratos":'.$arrObjetos.'}';
	}
	
	function obtenerAreasProrrateo()
	{
		global $con;
		$cadDeptos=$_POST["cadDeptos"];
		if($cadDeptos=="")
			$cadDeptos="-1";
		$consulta="SELECT codigoUnidad,unidad,codigoDepto FROM 817_organigrama WHERE codigoUnidad not in (".$cadDeptos.") and instColaboradora=0 AND institucion=0 AND (unidadPadre='0001' OR unidadPadre LIKE '0001%') ORDER BY TRIM(codigodepto)";

		$arrAreas=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrAreas;
	}

	function obtenerBasesProrrateo()
	{
		global $con;
		$bases=$_POST["base"];
		$cadDeptos=$_POST["cadDeptos"];
		$arrBases=explode(",",$bases);
		$arrDeptos=explode(",",$cadDeptos);

		$objRes='';
		$objDepto="";
		$aDeptos="";
		foreach($arrDeptos as $depto)
		{
			$objDepto=$depto;
			foreach($arrBases as $base)
			{
				$cadObj='{"codigoUnidad":"'.str_replace("'","",$depto).'"}';
				$obj=json_decode($cadObj);
				$Nul=NULL;
				$resBase=resolverExpresionCalculoPHP($base,$obj,$Nul);

				$objDepto.=",'".$resBase."'";
			}	
			if($aDeptos=="")
				$aDeptos="[".$objDepto."]";
			else
				$aDeptos.=",[".$objDepto."]";
			
		}
		$aDeptos="[".$aDeptos."]";
		echo "1|".$aDeptos;
		
	}	
	
	function guardarProrrateoContrato()
	{
		global $con;
		$idContrato=$_POST["idContrato"];
		$cadObj=$_POST["cadObj"];
		$cadDeptos=$_POST["cadDeptos"];
		$query="select idContrato from 562_prorrateoContratos where idContrato=".$idContrato;
		$idContratoRes=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 563_deptosVSProrrateo WHERE idProrrateo=".$idContrato;
		$x++;
		if($idContratoRes=="")
			$consulta[$x]="INSERT INTO 562_prorrateoContratos(idContrato,estructura) VALUES(".$idContrato.",'".cv($cadObj)."')";
		else
			$consulta[$x]="update 562_prorrateoContratos set estructura='".cv($cadObj)."' where idContrato=".$idContrato;
		$x++;
		$arrDeptos=explode(",",$cadDeptos);
		$nDeptos=sizeof($arrDeptos);
		for($y=0;$y<$nDeptos;$y++)
		{
			$consulta[$x]="insert into 563_deptosVSProrrateo (idProrrateo,codigoUnidad) values(".$idContrato.",'".$arrDeptos[$y]."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerActivoFijoDepreciado()
	{
		global $con;
		$inicio=$_POST["start"];
		$limite=$_POST["limit"];
		$arrArticulos="";
		$filtroUsuario1="";
		$filtroUsuario2="";
		/*if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						switch($arrFiltro[$x]["field"])
						{
							case "numInventario":
								$filtroUsuario1.=" and i.numInventario like '".$arrFiltro[$x]["data"]["value"]."%'";
								$filtroUsuario2.=" and codigo, like '".$arrFiltro[$x]["data"]["value"]."%'";
							break;
							case "descripcion":
								$filtroUsuario1.=" and descripcion like '".$arrFiltro[$x]["data"]["value"]."%'";
								$filtroUsuario2.=" and cp.nombreProducto like '".$arrFiltro[$x]["data"]["value"]."%'";
							break;
							case "anioAdquisicion":
								$filtroUsuario1.=" and DATE_FORMAT(fechaAdquisicion,'Y') like '".$arrFiltro[$x]["data"]["value"]."%'";
								$filtroUsuario2.=" and DATE_FORMAT(fechaCompra,'Y')  like '".$arrFiltro[$x]["data"]["value"]."%'";
							break;
								
						}
					
						
				
						
					break;
				}
			}
		}*/
	$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					
				}
			}
		}

		$consulta="select count(*) from 9307_inventario";
		
		$nArticulo=$con->obtenerValor($consulta);
		$consulta="select numInventario,descripcion,anioAdquisicion,valorCompra,claveCABMS from 9307_inventarioComp where descripcion<>'' ".$filtroUsuario." limit ".$inicio.",".$limite;
		
		$resArticulos=$con->obtenerFilas($consulta);
		
		$idFormula=555;
		$factor=0.5;
		$nActual=date("Y");
		while($fila=$con->fetchRow($resArticulos))
		{
			$clave=str_pad(substr($fila[4],0,3),10,'0',STR_PAD_RIGHT);
			$consulta="select txtDescripcion,txtVida from _802_tablaDinamica where txtClave='".$clave."'";
			
			$fCabms=$con->obtenerPrimeraFila($consulta);
			$tVida=$fCabms[1];
			if($tVida=="")
				$tVida=5;
			$nInventario=$fila[0];

			//$cadObj='{"noInventario":"'.$nInventario.'","param2":"'.$tVida.'","param3":"'.$nActual.'"}';
			
			/*$obj=json_decode($cadObj);
			
			$nNull=null;
			$factor=resolverExpresionCalculoPHP($idFormula,$obj,$nNull);*/
			
			$factor=($nActual-$fila[2])/$tVida;
			if($factor>1)
				$factor=1;
			if(($factor=="''")||($factor==""))
				$factor=0;
			$depreciacionAcum=$fila[3]*$factor;
			$obj='{"CABMS":"'.$fCabms[0].'","numInventario":"'.$fila[0].'","descripcion":"'.cv($fila[1]).'","anioAdquisicion":"'.$fila[2].'","valorCompra":"'.$fila[3].'","factorDepreciacion":"'.$factor.'","valorDepreciacion":"'.$depreciacionAcum.'","valorLibro":"'.($fila[3]-$depreciacionAcum).'"}'	;
			if($arrArticulos=="")
				$arrArticulos=$obj;
			else
				$arrArticulos.=",".$obj;
		}
		
		echo '{"num":"'.$nArticulo.'","registros":['.$arrArticulos.']}';	
	}
	
	function guardarProyeccionServicio()
	{
		global $con;
		$cadObj=$_POST["obj"];	
		$obj=json_decode($cadObj);
		
		$desgloce=explode(",",$obj->desgloce);
		
		$obj->desgloce=$desgloce;
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 564_proyeccionCostoServicio(ciclo,idServicio,idNivel,totalServicios,costoServicio,porcentajeNivel,
					montoTotal,enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre)
					VALUES(".$obj->ciclo.",".$obj->idServicio.",".$obj->idNivel.",".$obj->totalServicios.",".$obj->costoServicio.",".$obj->porcentajeNivel.",
					".$obj->montoTotal.",".$obj->desgloce[0].",".$obj->desgloce[1].",".$obj->desgloce[2].",".$obj->desgloce[3].",".$obj->desgloce[4].",
					".$obj->desgloce[5].",".$obj->desgloce[6].",".$obj->desgloce[7].",".$obj->desgloce[8].",".$obj->desgloce[9].",".$obj->desgloce[10].",".$obj->desgloce[11].")";	
		}
		else
		{
			$consulta="update 564_proyeccionCostoServicio set ciclo=".$obj->ciclo.",idServicio=".$obj->idServicio.",idNivel=".$obj->idNivel.",totalServicios=".$obj->totalServicios.",
					costoServicio=".$obj->costoServicio.",porcentajeNivel=".$obj->porcentajeNivel.",montoTotal=".$obj->montoTotal.",enero=".$obj->desgloce[0].",febrero=".$obj->desgloce[1].",
					marzo=".$obj->desgloce[2].",abril=".$obj->desgloce[3].",mayo=".$obj->desgloce[4].",junio=".$obj->desgloce[5].",julio=".$obj->desgloce[6].",
					agosto=".$obj->desgloce[7].",septiembre=".$obj->desgloce[8].",octubre=".$obj->desgloce[9].",noviembre=".$obj->desgloce[10].",diciembre=".$obj->desgloce[11]." where idServicioProy=".$obj->idRegistro;
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
	
	function obtenerConcentradoRopaje()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		$arrPrendas=Array();
		
		$conDeptos="SELECT 	codigoUnidad FROM 817_organigrama WHERE codigoInstitucion=".$_SESSION["codigoInstitucion"]." AND institucion=0";
		$lista=$con->obtenerListaValores($conDeptos);
		if($lista=="")
			$lista="-1";
		
		$consulta="SELECT idPrenda,(SELECT txtTipoPrenda FROM _757_tablaDinamica WHERE id__757_tablaDinamica=td.idPrenda) AS prenda,tipoTalla,
					color,(SELECT txtColor FROM _758_tablaDinamica WHERE id__758_tablaDinamica=td.color) AS nColor,
					cantidad ,tamano,genero,(SELECT costoEstimado FROM _757_tablaDinamica WHERE id__757_tablaDinamica=td.idPrenda)
					FROM 533_ropajeUsuario td  WHERE ciclo=".$idCiclo." AND  codigoUnidad IN (".$lista.")  AND codigoUnidad IN 
					(SELECT codigoDepartamento FROM 534_departamentosCierreRopaje WHERE ciclo=".$idCiclo.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if($fila[2]==1)
				$conEtiquetaTam="select talla FROM _767_dtgZapato where id__767_dtgZapato=".$fila[6];
			else
				$conEtiquetaTam="select DescTalla FROM _766_dtgTallas WHERE id__766_dtgTallas=".$fila[6];
			
			$etiqueta=$con->obtenerValor($conEtiquetaTam);
			
			if($fila[7]==1)
			{
				$sexo="Dama";
			}
			else
			{
				if($fila[7]==0)
					$sexo="Caballero";
				else
					$sexo="Unisex";
			}
			
			if(!isset($arrPrendas[$fila[0]][$fila[3]][$etiqueta]))
				$arrPrendas[$fila[0]][$fila[3]][$etiqueta]=$fila[5];
			else
				$arrPrendas[$fila[0]][$fila[3]][$etiqueta]+=$fila[5];
		}
		
		$conta=1;
		$arrFinal="";
		
		foreach($arrPrendas as $prenda=>$resto)
		{
			foreach($resto as $obj=>$a)
			{
				foreach($a as $tamano=>$nElementos)
				{
					
					$cantidad=$nElementos;
					//echo $arrPrendas[$prenda][$obj];
					
					$nombrePrenda="SELECT '1' AS idProducto,txtTipoPrenda,costoEstimado FROM _757_tablaDinamica WHERE  id__757_tablaDinamica=".$prenda;
					$fPren=$con->obtenerPrimeraFila($nombrePrenda);
					$idProducto=$fPren[0];
					$nPren=$fPren[1];
					$costo=$fPren[2];
					
					$nombreColor="SELECT txtColor FROM _758_tablaDinamica WHERE id__758_tablaDinamica=".$obj;
					$nColor=$con->obtenerValor($nombreColor);
					
					//$conPrecio="SELECT costoEstimado FROM _757_tablaDinamica WHERE id__757_tablaDinamica=".$prenda;
//					$costo=$con->obtenerValor($conPrecio);
					if($costo=="")
						$costo=0;
					
					$total=$cantidad*$costo;	
					
					$aux='{"idPrenda":"'.$prenda.'","nomPren":"'.$nPren.'","idColor":"'.$obj.'","nColor":"'.$nColor.'","talla":"'.$tamano.'","cantidad":"'.$cantidad.'","costo":"'.$costo.'","idProducto":"'.$idProducto.'","total":"'.$total.'"}';
					if($arrFinal=="")
						$arrFinal=$aux;
					else
						$arrFinal.=",".$aux;
					
					$conta++;	
				}
			}
		}
		
		echo '{"numReg":"'.$conta.'","registros":['.$arrFinal.']}';	
	}
	
	function obtenerDepartamentosRopaje()
	{
		global $con;
		
		$bandera=$_POST["bandera"];
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
		if($bandera==1)//registrados
		{
			$consulta="SELECT  codigoDepto,unidad
			 		   FROM 817_organigrama
					   WHERE codigoUnidad IN (SELECT codigoDepartamento FROM 534_departamentosCierreRopaje) AND
					   codigoUnidad IN (SELECT codigoUnidad FROM 817_organigrama WHERE  codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND institucion=0) ".$condWhere." order by codigoDepto";
		}
		else
		{
			$consulta="SELECT  codigoDepto,unidad 
			 		   FROM 817_organigrama
					   WHERE codigoUnidad NOT IN (SELECT codigoDepartamento FROM 534_departamentosCierreRopaje) AND
					   codigoUnidad  IN (SELECT codigoUnidad FROM 817_organigrama WHERE  codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND institucion=0) ".$condWhere." order by codigoDepto";
		}
		
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrUnidades="";
		while($fila=$con->fetchRow($res))
		{
			
			$obj='{"codigoDepto":"'.$fila[0].'","unidad":"'.$fila[1].'"}';	
			if($arrUnidades=="")
				$arrUnidades=$obj;
			else
				$arrUnidades.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrUnidades.']}';
		echo $obj;
	}
	
	function reporteAnualCapacitacion()
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
		
				
		$consulta="SELECT id__352_tablaDinamica,anio,codigoUnidad,nombreCurso,intNumPersonal FROM 352_vistacursossolicitados where id__352_tablaDinamica>0 ".$condWhere." ORDER BY anio";
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrCursos="";
		$totalCurso=0;
		while($fila=$con->fetchRow($res))
		{
			
			$conImporte="SELECT id__674_tablaDinamica,cmbTipoFina FROM _674_tablaDinamica WHERE idReferencia=".$fila[0];
			$tipoFin=$con->obtenerPrimeraFila($conImporte);
			switch($tipoFin[1])
			{
				case 1:
					$costoTotal="SELECT total FROM _674_dtgRHInterno WHERE idReferencia=".$tipoFin[0];
					$total1=$con->obtenerValor($costoTotal);
					
					$total2=0;
					$costoTotal2="SELECT idcostototal FROM _674_GrdGastosvarios WHERE idReferencia=".$tipoFin[0];
					$resTotal2=$con->obtenerFilas($costoTotal2);
					while($fTotal=$con->fetchRow($resTotal2))
					{
						$total2=$total2+$fTotal[0];
					}
					
					$totalCurso=$total1+$total2;
				break;
				case 2:
					$costoTotal="SELECT Costototal FROM _674_RHintitucion WHERE idReferencia=".$tipoFin[0];
					$total1=$con->obtenerValor($costoTotal);
					
					$total2=0;
					$costoTotal2="SELECT idcostototal FROM _674_GrdGastosvarios WHERE idReferencia=".$tipoFin[0];
					$resTotal2=$con->obtenerFilas($costoTotal2);
					while($fTotal=$con->fetchRow($resTotal2))
					{
						$total2=$total2+$fTotal[0];
					}
					
					$totalCurso=$total1+$total2;
				break;
				case 3:
					$total2=0;
					$costoTotal2="SELECT totalProm FROM _674_Proveedor1 WHERE idReferencia=".$tipoFin[0];
					$totalCurso=$con->obtenerValor($costoTotal2);
					if($totalCurso=="")
						$totalCurso=0;
				break;
				default:
					$totalCurso=0;
				break;
			}
			
			$conRefPart="SELECT id__847_tablaDinamica FROM _847_tablaDinamica WHERE idReferencia=".$fila[0];
			$idRefPart=$con->obtenerValor($conRefPart);
			if($idRefPart=="")
				$idRefPart="-1";
			
			$conListaPart="SELECT idempleados FROM _847_Empleado WHERE idReferencia=".$idRefPart;
			$listaP=$con->obtenerListaValores($conListaPart);
			if($listaP=="")
				$listaP="-1";
			
			$nomUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[2]."'";
			$nomU=$con->obtenerValor($nomUnidad);
			
			$obj='{"idCurso":"'.$fila[0].'","anio":"'.$fila[1].'","codigoU":"'.$fila[2].'","nombreU":"'.$nomU.'","nombreCurso":"'.$fila[3].'","numPer":"'.$fila[4].'","tipoFin":"'.$tipoFin[1].'","costo":"'.$totalCurso.'","cadUsr":"'.$listaP.'"}';	
			if($arrCursos=="")
				$arrCursos=$obj;
			else
				$arrCursos.=",".$obj;
				
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrCursos.']}';
		echo $obj;
	}
	
	function enviarComprasConcentradoRopaje()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		$cadena=$_POST["cadena"];
		$arreglo=explode("|",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				//tipo de producto 1 por ser ropaje
				$registro=explode("_",$arreglo[$x]);
				$query[$ct]="INSERT INTO 527_concentradoProducto (idProducto,cantidad,costoUnitario,total,estado,ciclo,referencia,tipoReferencia,tipoProducto,complementario,complementario2)
				VALUES (".$registro[0].",".$registro[1].",".$registro[2].",".$registro[3].",1,".$idCiclo.",-1,0,1,'".$registro[4]."','".$registro[5]."')";
				$ct++;
			}
			
			$conExiste="SELECT idConcentradoRopajeCiclo FROM 4250_concentradoRopajeCiclo WHERE ciclo=".$idCiclo;
			$existe=$con->obtenerValor($conExiste);
			if($existe=="")
				$query[$ct]="INSERT INTO 4250_concentradoRopajeCiclo (ciclo,registrado) VALUES(".$idCiclo.",1)";
			else
				$query[$ct]="UPDATE 4250_concentradoRopajeCiclo SET registrado=1 WHERE idConcentradoRopajeCiclo=".$existe;
			
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
	    }
	}
	
	function obtenerParticipantesCurso()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
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
		$consulta="SELECT a.idUsuario,Nombre,a.codigoUnidad,unidad FROM 801_adscripcion a,802_identifica i,817_organigrama o  
				   WHERE a.idUsuario IN (".$cadena.") AND i.idUsuario=a.idUsuario AND  a.codigoUnidad=o.codigoUnidad ".$condWhere." order by Nombre";
		
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrParticipantes="";
		while($fila=$con->fetchRow($res))
		{
			
			$obj='{"idUsuario":"'.$fila[0].'","Nombre":"'.$fila[1].'","codigoUnidad":"'.$fila[2].'","unidad":"'.$fila[3].'"}';	
			if($arrParticipantes=="")
				$arrParticipantes=$obj;
			else
				$arrParticipantes.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrParticipantes.']}';
		echo $obj;
	}
	
	function cerrarEstructuraProgramatica()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		
		$consulta="update 9117_definicionEstructuraProgramatica SET situacion=1 WHERE ciclo=".$ciclo." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";	
		eC($consulta);
	}
	
	function cerrarEstructuraProgramaticaExtendida()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		
		$consulta="insert into  9131_relacionDeptoPrograma(ciclo,codigoInstitucion) values(".$ciclo.",'".$_SESSION["codigoInstitucion"]."')";	
		eC($consulta);
	}
	
	function modificarPMP()
	{
		global $con;
		$ciclo=$_POST["ciclo"]	;
		$institucion=$_POST["institucion"];
		$idPrograma=$_POST["idPrograma"];
		$ruta=$_POST["ruta"];
		$tIndicador=$_POST["tIndicador"];
		$consulta="update 9117_estructurasVSPrograma SET tipoIndicadorPMP=".$tIndicador." WHERE ruta='".$ruta."' AND idProgramaInstitucional='".$idPrograma."' AND ciclo=".$ciclo." AND institucion='".$institucion."'";
		eC($consulta);
		
		
		
	}
	
	function removerIndicador()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from _883_tablaDinamica where id__883_tablaDinamica=".$idRegistro;
		$x++;
		$consulta[$x]="delete from _883_Actividades where idReferencia=".$idRegistro;
		$x++;
		$consulta[$x]="delete from _883_Proginstitucionales where idReferencia=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function cerrarPlaneacionOperativa()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="insert into 2000_cierresCicloProcesos(codigoInstitucion,ciclo,idResponsableCierre,fechaCierre,tipoCierre)
					VALUES('".$_SESSION["codigoInstitucion"]."',".$ciclo.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',1)";
		eC($consulta);				
	}
	
	function cerrarRegistroNecesidadesEnvioJefe()
	{
		global $con;
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$codigoDepto=$_POST["codigoDepto"];
		$idProceso=$_POST["idProceso"];
		$ciclo=$_POST["ciclo"];
		$capitulos=bD($_POST["capitulos"]);
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		foreach($arrCapitulos as $c)
		{
			
			$particula="(o.codigoControlPadre = '".$c."' or o.codigoControlPadre like '".$c."%' or o.codigoControl='".$c."')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
			
		
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ruta='".$ruta."' and idPrograma=".$idPrograma." AND codigoUnidad='".$codigoDepto."' AND ciclo=".$ciclo;
		$listPartidas=$con->obtenerListaValores($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
		$cadCapitulos." and objetoGasto in (".$listPartidas.")";
		$consulta="select codigoControl from 507_objetosGasto o WHERE ".$cadCapitulos;	
		$listObjetosGasto=$con->obtenerListaValores($consulta,"'");
		if($listObjetosGasto=="")
			$listObjetosGasto="-1";
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="insert into 2000_cierresCicloProcesos(codigoInstitucion,ciclo,idResponsableCierre,fechaCierre,tipoCierre,complementario1,complementario2,
					complementario3,complementario4) values('".$_SESSION["codigoInstitucion"]."',".$ciclo.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',3,'".$ruta."',
					'".$idPrograma."','".$codigoDepto."','".$idProceso."')";
		$x++;
		$query[$x]="UPDATE 9110_objetosGastoVSCiclo SET numEtapa=2 WHERE codDepto='".$codigoDepto."' and ruta='".$ruta."' AND idCiclo=".$ciclo." AND idPrograma=".$idPrograma." AND clave in (".$listObjetosGasto.") and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function cerrarRegistroNecesidadesEnvioAdquisiciones()
	{
		global $con;
		$codigoDepto=$_POST["codigoDepto"];
		$idProceso=$_POST["idProceso"];
		$consulta="insert into 2000_cierresCicloProcesos(codigoInstitucion,ciclo,idResponsableCierre,fechaCierre,tipoCierre,
					complementario3,complementario4) values('".$_SESSION["codigoInstitucion"]."',".$ciclo.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',4,
					'".$codigoDepto."','".$idProceso."')";
		eC($consulta);
		
	}
	
	function obtenerConceptosPartidas()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$partida=$_POST["partida"];
		$idPrograma=$_POST["idPrograma"];
		$ruta=$_POST["ruta"];
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT listaPartidas FROM 9116_responsablesPAT WHERE ruta='".$ruta."' AND idPrograma=".$idPrograma." AND idResponsable=".$_SESSION["idUsr"];
		$listPartidas=$con->obtenerValor($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
		$consulta="SELECT DISTINCT c.clave FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o WHERE o.codigoControl=c.clave AND o.codigoControlPadre='".$partida."' AND c.idCiclo=".$ciclo." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$listaObj=$con->obtenerListaValores($consulta);
		if($listaObj=="")
			$listaObj="''";
		$consulta="SELECT codigoControl,CONCAT('[',clave,'] ',nombreObjetoGasto),(SELECT tipoInterfaceSolicitud FROM 9044_capitulosProcesoPresupuesto WHERE partidas=o.codigoControl AND idProcesoPresupuesto=".$idProceso.") FROM 507_objetosGasto o WHERE codigoControlPadre='".$partida."' AND nivel=3 and  codigoControl not in (".$listaObj.") and codigoControl in (".$listPartidas.")";
		$arrConceptos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrConceptos;
	}
	
	function obtenerDeptosPartidasConcepto()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$objetoGasto=$_POST["objetoGasto"];
		$idPrograma=$_POST["idPrograma"];
		$ruta=$_POST["ruta"];
		$arrConceptos="";
		$consulta="SELECT partidas,concat('[',o.codigoDepto,'] ',o.unidad),o.codigoUnidad FROM 9130_departamentoVSPrograma p,817_organigrama o WHERE o.codigoUnidad=p.codigoUnidad and ciclo=".$ciclo." AND ruta='".$ruta."' AND idPrograma=".$idPrograma." order by unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arregloAux=explode(",",$fila[0]);
			if(existeValor($arregloAux,"'".$objetoGasto."'"))
			{
				$obj="['".$fila[2]."','".$fila[1]."','0','0']";
				if($arrConceptos=="")
					$arrConceptos=$obj;
				else
					$arrConceptos.=",".$obj;
					
			}
		}
		echo "1|[".$arrConceptos."]";
	}
	
	function guardarConceptoDeteccionNecesidades()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$fechaInicioServicio="'".$obj->objEntregables->fechaInicio."'";
		if($fechaInicioServicio=="'NULL'")
			$fechaInicioServicio="NULL";
		$fechaFinServicio="'".$obj->objEntregables->fechaFin."'";			
		if($fechaFinServicio=="'NULL'")
			$fechaFinServicio="NULL";
		
		if($obj->idRegistroObjeto=="-1")
		{
			$consulta[$x]="INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,idPrograma,idResponsable,
							fechaSolicitud,montoTotal,numEtapa,modificable,tipoPresupuesto,VERSION,ruta,cabecera,complementario,tipoContrato,porcentajeMinimo,cantidad,costoUnitario)
							VALUES('".$obj->objetoGasto."',".$obj->idCiclo.",'','".$obj->codInstitucion."',-1,".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->montoTotal.",1,1,".
							$obj->tipoPresupuesto.",1,'".$obj->ruta."',1,'".cv($obj->especificaciones->descripcion)."',".$obj->tipoContrato.",".$obj->porcentajeMinimo.",1,".$obj->montoTotal.")";
			$x++;
			$consulta[$x]="set @idRegistro=(select LAST_INSERT_ID())";
			$x++;
			$consulta[$x]="INSERT INTO 9110_especificacionesConcepto(descripcion,objetivo,participacionPersonalExterno,numPersonalExterno,fechaInicio,fechaFin,periodicidadPago,idConceptoSolicitado)
						VALUES('".cv($obj->especificaciones->descripcion)."','".cv($obj->especificaciones->objetivo)."',".$obj->especificaciones->partPersonalExterno.",".
						$obj->especificaciones->numPersonalExterno.",".$fechaInicioServicio.",".$fechaFinServicio.",".$obj->objEntregables->periodicidadPago.",@idRegistro)";

			$x++;
		}
		else
		{
			$consulta[$x]="update 9110_objetosGastoVSCiclo set tipoContrato=".$obj->tipoContrato.",porcentajeMinimo=".$obj->porcentajeMinimo.",clave='".$obj->objetoGasto."',idCiclo=".$obj->idCiclo.",costoUnitario=".$obj->montoTotal.",montoTotal=".$obj->montoTotal.",tipoPresupuesto=".$obj->tipoPresupuesto.",complementario='".cv($obj->especificaciones->descripcion)."'
							where idCodigoGastoCiclo=".$obj->idRegistroObjeto;
			$x++;
			
			
			
			$consulta[$x]="set @idRegistro=".$obj->idRegistroObjeto;
			$x++;
			$consulta[$x]="update 9110_especificacionesConcepto set descripcion='".cv($obj->especificaciones->descripcion)."',objetivo='".cv($obj->especificaciones->objetivo)."',participacionPersonalExterno=".$obj->especificaciones->partPersonalExterno.",
							numPersonalExterno=".$obj->especificaciones->numPersonalExterno.",fechaInicio=".$fechaInicioServicio.",fechaFin=".$fechaFinServicio.",periodicidadPago=".$obj->objEntregables->periodicidadPago." 
							where idConceptoSolicitado=@idRegistro";
			$x++;
			$consulta[$x]="delete from  9111_cantidaObjVSMes where idCodigoGastoCiclo=@idRegistro";
			$x++;
			$consulta[$x]="delete from  9110_usuariosParticipacionConcepto where idConceptoSolicitado=@idRegistro";
			$x++;
			$consulta[$x]="delete from  9110_entregablesConcepto where idConceptoSolicitado=@idRegistro";
			$x++;
			$consulta[$x]="delete from  9111_cantidaObjVSMes where idCodigoGastoCiclo in (select idCodigoGastoCiclo from 9110_objetosGastoVSCiclo where idCabecera=@idRegistro)";
			$x++;
			$consulta[$x]="delete from 9110_objetosGastoVSCiclo where idCabecera=@idRegistro";
			$x++;
			
			
		}
		
		$arrDistibucion=explode(",",$obj->distribucion);
		for($ct=0;$ct<sizeof($arrDistibucion);$ct++)
		{
			$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) VALUES(@idRegistro,".$ct.",1,".$arrDistibucion[$ct].")";
			$x++;
		}
		
		foreach($obj->prorrateo as $p)
		{
			$consulta[$x]="INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,idPrograma,idResponsable,
							fechaSolicitud,montoTotal,numEtapa,modificable,tipoPresupuesto,VERSION,ruta,cabecera,complementario,complementario2,idCabecera,cantidad,costoUnitario)
							VALUES('".$obj->objetoGasto."',".$obj->idCiclo.",'".$p->depto."','".$obj->codInstitucion."',-1,".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$p->monto.",1,1,".
							$obj->tipoPresupuesto.",1,'".$obj->ruta."',0,'".cv($obj->especificaciones->descripcion)."','".$p->porcentaje."',@idRegistro,1,".$p->monto.")";
			$x++;
			$consulta[$x]="set @idRegistroDepto=(select LAST_INSERT_ID())";
			$x++;
			for($ct=0;$ct<sizeof($arrDistibucion);$ct++)
			{
				$proporcion=$arrDistibucion[$ct]/$obj->montoTotal;
				$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) VALUES(@idRegistroDepto,".$ct.",1,".($p->monto*$proporcion).")";
				$x++;
			}
		}
		if(sizeof($obj->especificaciones->participantes )>0)
		{
			foreach($obj->especificaciones->participantes as $participante)
			{
				$consulta[$x]="INSERT INTO 9110_usuariosParticipacionConcepto(idUsuario,idParticipacion,idConceptoSolicitado) VALUES(".$participante->idUsuario.",".$participante->idParticipacion.",@idRegistro)";
				$x++;
			}
		}
		
		if(sizeof($obj->objEntregables->arrEntregables )>0)
		{
			foreach($obj->objEntregables->arrEntregables as $entregable)
			{
				$consulta[$x]="INSERT INTO 9110_entregablesConcepto(entregable,fechaEntrega,idConceptoSolicitado) VALUES('".cv($entregable->entregable)."','".$entregable->fechaEntrega."',@idRegistro)";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDatosConceptoDeteccionNecesidades()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="select * from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$idRegistro;
		$fila=$con->obtenerPrimeraFila($consulta);
		$consulta="select * from 9110_especificacionesConcepto WHERE idConceptoSolicitado=".$idRegistro;
		$filaCon=$con->obtenerPrimeraFila($consulta);
		$consulta="select entregable,fechaEntrega FROM 9110_entregablesConcepto WHERE idConceptoSolicitado=".$idRegistro;
		$arrEntregables=$con->obtenerFilasArreglo($consulta);

		$consulta="select c.codDepto,concat('[',o.codigoDepto,'] ',o.unidad),complementario2,montoTotal from 9110_objetosGastoVSCiclo c,817_organigrama o where o.codigoUnidad=c.codDepto and idCabecera=".$idRegistro." order by o.unidad";
		$arrProrrateo=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$idRegistro." ORDER BY mes";
		$arrMeses=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT u.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom) AS nombre,u.idParticipacion FROM 802_identifica i,9110_usuariosParticipacionConcepto u  
					WHERE u.idUsuario=i.idUsuario AND u.idConceptoSolicitado=".$idRegistro." ORDER BY Paterno,Materno,Nom";
		$arrParticipantes=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=".$fila[19];
		$fuenteFinanciamiento=$con->obtenerValor($consulta);
		$consulta="select codigoControlPadre from 507_objetosGasto WHERE codigoControl='".$fila[1]."'";
		$concepto=$con->obtenerValor($consulta);
		$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where codigoControlPadre='".$concepto."'";
		$listPartidas=$con->obtenerFilasArreglo($consulta);
		$objConcepto='{"listPartidas":'.$listPartidas.',"concepto":"'.$concepto.'","partida":"'.$fila[1].'","montoTotal":"'.$fila[16].'","tipoPresupuesto":"'.$fila[19].'","lblTipoPresupuesto":"'.$fuenteFinanciamiento.'","distribucionConcepto":['.$arrMeses.'],
						"prorrateo":'.$arrProrrateo.',"descripcion":"'.$fila[23].'","objetivo":"'.$filaCon[2].'","participantes":'.$arrParticipantes.',"incluyePersonal":"'.$filaCon[3].'","numPersonal":"'.$filaCon[4].'",
						"fechaInicio":"'.$filaCon[5].'","fechaTermino":"'.$filaCon[6].'","periodicidadPago":"'.$filaCon[7].'","entregables":'.$arrEntregables.',"tipoContrato":"'.$fila[26].'","porcentajeMinimo":"'.$fila[27].'"}';
		echo "1|".$objConcepto;	
		
	}
	
	function obtenerProrrateoDeteccionNecesidades()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$arrRegistros="";
		$consulta="SELECT idCodigoGastoCiclo,o.codigoUnidad,concat('[',o.codigoDepto,']',o.unidad) as depto,complementario2,montoTotal FROM 9110_objetosGastoVSCiclo d,817_organigrama o WHERE o.codigoUnidad=d.codDepto AND idCabecera=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$conCantidades="SELECT mes,monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="80" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">$ '.number_format($fMeses[1],2).'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			$obj="['".$fila[1]."','".$fila[2]."','".$fila[3]."','".$fila[4]."','".cv($cadenaAux)."']";
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
						
		}
		echo "1|[".$arrRegistros."]";
		
	}
	
	function obtenerConceptosDeteccionNecesidades()
	{
		global $con;
		global $SO;
		$capitulos=bD($_POST["capitulos"]);
		$ciclo=bD($_POST["ciclo"]);
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					case 'list':
						if($arrFiltro[$x]["field"]=='nombreObjetoGasto')
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.clave in (".$listaClaves.")";
						}
						else
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.codigoControlPadre in (".$listaClaves.")";
						}
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		foreach($arrCapitulos as $c)
		{
			$c=str_replace("'","",$c);
			$particula="(o.codigoControlPadre = '".$c."' or o.codigoControlPadre like '".$c."%')";
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		
		$consulta="SELECT idCodigoGastoCiclo,o.codigoControl as clave,CONCAT('[',o.clave,'] ',nombreObjetoGasto) AS nombreObj,idCiclo,complementario as nombreProducto,
					montoTotal,	(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o
			   WHERE idCiclo=".$ciclo." AND  o.codigoControl=c.clave AND cabecera=1 and ".$cadCapitulos."  order by complementario";
		$resFilas=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=$con->fetchRow($resFilas))
		{
			$conCantidades="SELECT mes,cantidad,monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="75" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">$ '.number_format($fMeses[2],2).'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'",
				"cadenaMeses":"'.cv($cadenaAux).'","costoTotal":"'.($fila[5]).'","programa":"'.$fila[6].'","responsableSolicitud":"'.$fila[7].'","tipoPresupuesto":"'.$fila[8].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
			
		}

		if($SO==2)
			$obj='{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrDatos).']}';
		echo $obj;			
		
	}
	
	function obtenerProgramasAutorizados()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$arrRutas=obtenerCodigosRutas($ciclo);
		$arrProgramas="";
		$etRuta="";
		$consulta="SELECT concat(ruta,'.',p.idPrograma) as programa,p.cvePrograma,p.tituloPrograma,ruta FROM 9117_estructurasVSPrograma e,517_programas p 
					WHERE p.idPrograma=e.idProgramaInstitucional and ciclo=".$ciclo." AND institucion='".$_SESSION["codigoInstitucion"]."' order by tituloPrograma";
		$resProgramas=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($resProgramas))
		{

			$obj="['".$fila[0]."','[".$arrRutas[$fila[3]]." ".$fila[1]."] ".$fila[2]."']";
			if($etRuta=="")
				$etRuta=$obj;
			else
				$etRuta.=",".$obj;
		}
		echo "1|[".$etRuta."]";
	}
	
	function obtenerPartidasProceso()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT codigoControl,clave,nombreObjetoGasto FROM 507_objetosGasto WHERE codigoControl IN (
				SELECT partidas FROM 9044_capitulosProcesoPresupuesto WHERE idProcesoPresupuesto=".$idProceso.") order by clave";
		$arrObjetosGasto=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrObjetosGasto;
	}
	
	function guardarResponsablesProgramas()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrPrograma=explode(".",$obj->programa);
		$consulta[$x]="INSERT INTO 9116_responsablesPAT(idPrograma,idProceso,idResponsable,ruta,listaPartidas) VALUES('".$arrPrograma[1]."',".$obj->idProceso.",".$obj->idUsuario.",'".$arrPrograma[0]."','".cv($obj->listaPartidas)."')";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerResponsablesProgramas()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$arrRutas=obtenerCodigosRutas($ciclo);
		$consulta="SELECT idResponsablePAT,r.idPrograma,p.nombre,r.idResponsable,r.ruta,listaPartidas,u.Nombre,pr.cvePrograma,pr.tituloPrograma FROM 9116_responsablesPAT r,4001_procesos p,800_usuarios u,517_programas pr,9117_estructurasVSPrograma ep 
					WHERE pr.idPrograma=ep.idProgramaInstitucional and r.ruta=ep.ruta and ep.ciclo=".$ciclo." and pr.idPrograma=r.idPrograma and u.idUsuario=r.idResponsable and p.idProceso=r.idProceso and codigoDepto IS null";
		$res=$con->obtenerFilas($consulta);
		$arrResponsables="";
		$ct=0;
		while($fila=$con->fetchRow($res))
		{
			$nPrograma="[".$arrRutas[$fila[4]]." ".$fila[7]."] ".$fila[8];
			$tblPartidas="<table><tr><td width='380'><span class='corpo8_bold'>Partidas sobre las cuales puede solicitar presupuesto</span></td><tr>";
			if($fila[5]=="")
				$fila[5]="-1";
			$consulta="SELECT CONCAT('[',clave,'] ',nombreObjetoGasto) FROM 507_objetosGasto WHERE codigoControl IN (".$fila[5].")";
			$resObj=$con->obtenerFilas($consulta);
			while($f=$con->fetchRow($resObj))
			{
				$tblPartidas.='<tr><td><span class=\'letraExt\'>'.$f[0].'</span></td></tr>';
			}
			$tblPartidas.="</table>";
			$obj='{"idAsignacion":"'.$fila[0].'","idResponsable":"'.$fila[3].'","responsable":"'.$fila[6].'","programa":"'.$nPrograma.'","proceso":"Proceso: '.$fila[2].'","partidas":"'.$tblPartidas.'"}';
			if($arrResponsables=="")
				$arrResponsables=$obj;
			else
				$arrResponsables.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrResponsables.']}';
		
	}
	
	function obtenerListadoSolicitudesGridValidacion()
	{
		global $con;
		global $SO;
		$inicio=0;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		$cantidad=5000;
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=bD($_POST["ciclo"]);
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		$capitulos=bD($_POST["capitulos"]);
		$idProceso=$_POST["idProceso"];
		$actor=$_POST["actor"];
		$etapa=$_POST["numEtapa"];
		$cEtapa=$_POST["cEtapa"];
		$ruta=$_POST["ruta"];
		$idActorProcesoEtapa=$_POST["idActorProcesoEtapa"];
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $tipoOG;
		$consulta="select numEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
		$resEtapas=$con->obtenerFilas($consulta);
		$arrPermisosEtapa=array();
		$arrEtapasOpciones="";
		while($filaEtapa=$con->fetchRow($resEtapas))
		{
			$permisos="";
			if(strpos($actor,"_")!==false)
				$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=1 and numEtapa=".$filaEtapa[0];
			else
				$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=2 and numEtapa=".$filaEtapa[0];
			$idAProcesoEtapa=$con->obtenerValor($consulta);	   
			if($idAProcesoEtapa=="")
				$idAProcesoEtapa="-1";
			$consulta="SELECT idGrupoAccion,complementario,idAccionesProcesoEtapaVSAcciones FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$idAProcesoEtapa;
			$arrAcciones=$con->obtenerFilasArregloPHP($consulta);
			$permisos="";
			if(existeValorMatriz($arrAcciones,"13")!=-1)
			{
				$permisos="['A','']";
			}
			if(existeValorMatriz($arrAcciones,"2")!=-1)
			{
				if($permisos=="")
					$permisos="['M','']";
				else
					$permisos.=",['M','']";
			}
			if(existeValorMatriz($arrAcciones,"7")!=-1)
			{
				if($permisos=="")
					$permisos.="['E','']";
				else
					$permisos.=",['E','']";
			}
			if(existeValorMatriz($arrAcciones,"6")!=-1)
			{
				if($permisos=="")
					$permisos="['B','']";	
				else
					$permisos.=",['B','']";	
			}
			$pos=existeValorMatriz($arrAcciones,"11");
			if($pos!=-1)
			{
				if($permisos=="")
					$permisos="['D','']";	
				else
					$permisos.=",['D','']";	
				$idAccionProceso=$arrAcciones[$pos][2];
				
				$consulta="SELECT valor,contenido,etapa FROM 9114_opcionesEvaluacion WHERE idAccion=".$idAccionProceso." AND idIdioma=".$_SESSION["leng"];
				$arrOpciones=$con->obtenerFilasArreglo($consulta);
				
				$obj="['".$filaEtapa[0]."',".$arrOpciones."]";
				if($arrEtapasOpciones=="")
					$arrEtapasOpciones=$obj;
				else
					$arrEtapasOpciones.=",".$obj;
			}
			$pos=existeValorMatriz($arrAcciones,"1");
			if($pos!=-1)
			{
				$etapaSomete=$arrAcciones[$pos][1];
				if($permisos=="")
					$permisos="['S','".$arrAcciones[$pos][1]."']";
				else
					$permisos.=",['S','".$arrAcciones[$pos][1]."']";
			}	   
			
			if(existeValorMatriz($arrAcciones,"14")!=-1)
			{
				if($permisos=="")
					$permisos="['G','']";	
				else
					$permisos.=",['G','']";	
			}
			$arrPermisosEtapa[removerCerosDerecha($filaEtapa[0])]="[".$permisos."]";
		}
		
		if(strpos($actor,"_")!==false)
		{
			foreach($arrCapitulos as $c)
			{
				
				
				$particula="(o.codigoControlPadre like '".$c."%' or o.codigoControlPadre='".$c."' or codigoControl='".$c."' )";
				if($cadCapitulos=="")
					$cadCapitulos=$particula;	
				else
					$cadCapitulos.=" or ".$particula;	
			}
		}
		else
		{
			$consulta="SELECT idComite FROM 235_proyectosVSComites WHERE idProyectoVSComite=".$actor;
			$idComite=$con->obtenerValor($consulta);
			$consulta="SELECT idProyectoVSComiteVSEtapa FROM 234_proyectosVSComitesVSEtapas WHERE idProyecto=".$idProceso." AND idComite=".$idComite." AND numEtapa=".$etapa;
			$idProyectoCE=$con->obtenerValor($consulta);
			$consulta="SELECT p.partida FROM 9044_proyectoComitePartida p WHERE  idProyectoComite=".$idProyectoCE;
			$resPartidas=$con->obtenerFilas($consulta);
			while($filaPartidas=$con->fetchRow($resPartidas))
			{
				$particula="(o.codigoControlPadre = '".$filaPartidas[0]."' or o.codigoControlPadre like '".$filaPartidas[0]."%' or codigoControl='".$c."')";
				if($cadCapitulos=="")
					$cadCapitulos=$particula;	
				else
					$cadCapitulos.=" or ".$particula;
			}
		}
		
		if($cadCapitulos!="")
			$cadCapitulos="(".$cadCapitulos.")";
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
					case 'list':
						if($arrFiltro[$x]["field"]=='nombreObj')
						{
							$listaClaves=$arrFiltro[$x]["data"]["value"];
							$filtroUsuario.=" and o.clave in (".$listaClaves.")";
						}
						
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		$condFiltro="";
		/*$consulta="SELECT idGrupoAccion,complementario FROM 947_actoresProcesosEtapasVSAcciones WHERE idGrupoAccion=11 and  idActorProcesoEtapa=".$idActorProcesoEtapa;

		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$complementario=$fila[1];
			switch($complementario)
			{
				case 1:
					$condFiltro="";
				break;	
				case 2:
					$condFiltro=" and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
				break;	
				case 3:
					$condFiltro=" and idResponsable=".$_SESSION["idUsr"];
				break;	
				case 4:
					$condFiltro=" AND codDepto='".$codDepartamento."'";
				break;	
				case 5:
					$condFiltro=" AND (codDepto like '".$codDepartamento."%' or codDepto = '".$codDepartamento."%')";
				break;	
				case 6:
					$condFiltro=" and idPrograma=".$idPrograma." and ruta='".$ruta."'";
				break;	
				case 7:
					$condFiltro=" AND codDepto='".$codDepartamento."' and idPrograma=".$idPrograma;
				break;
			}
		}
		else
		{
			$consulta="SELECT idAccion,complementario FROM 949_actoresVSAccionesProceso WHERE idAccion=9 and  actor='".$actor."' and idProceso=".$idProceso;
			$fila=$con->obtenerPrimeraFila($consulta);
			if($fila)
			{
				$complementario=$fila[1];
				switch($complementario)
				{
					case 1:
						$condFiltro="";
					break;	
					case 2:
						$condFiltro=" and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
					break;	
					case 3:
						$condFiltro=" and idResponsable=".$_SESSION["idUsr"];
					break;	
					case 4:
						$condFiltro=" AND codDepto='".$codDepartamento."'";
					break;	
					case 5:
						$condFiltro=" AND (codDepto = '".$codDepartamento."' or codDepto like '".$codDepartamento."%')";
					break;	
					case 6:
						$condFiltro=" and idPrograma=".$idPrograma." and ruta='".$ruta."'";
					break;	
					case 7:
						$condFiltro=" AND codDepto='".$codDepartamento."' and idPrograma=".$idPrograma;
					break;
				}
			}
		}*/
		$condFiltro=" AND (codDepto = '".$codDepartamento."')";
		
		$condFiltro.=" and numEtapa=".$etapa;
		/*if(!$filaActor)
			
		
		if($cEtapa==1)
		{
			$condAuxiliar=" and c.numEtapa=".$etapa;
		}*/
		$condAuxiliar="";
		$consulta="SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					(SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=c.numEtapa) as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto,idProveedorSugerido,idMarcaSugerida
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			   ".$cadCapitulos." and p.idProducto=c.idProducto ".$condWhere.$condAuxiliar." order by nombreProducto limit ".$inicio.",".$cantidad;
		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro."  AND  ".$cadCapitulos." ".$condWhere;

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			$proveedorSugerido=$fila[20];
			if($proveedorSugerido!="")
			{
				$consulta="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$proveedorSugerido;
				$proveedorSugerido=$con->obtenerValor($consulta);
			}
			$marcaSugerida=$fila[21];
			if($marcaSugerida!="")
			{
				$consulta="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$marcaSugerida;
				$marcaSugerida=$con->obtenerValor($consulta);
			}
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"'.$arrPermisosEtapa[removerCerosDerecha($fila[18])].'",
					"numEtapa":"'.$fila[18].'","proveedorSugerido":"'.$proveedorSugerido.'","marcaSugerida":"'.$marcaSugerida.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"['.$arrEtapasOpciones.']","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function cambiarEtapaProducto()
	{
		global $con;
		$listSolicitudes=$_POST["listSolicitudes"];
		$numEtapa=$_POST["numEtapa"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($numEtapa==4)
		{
			$arrSol=explode(",",$listSolicitudes);
			foreach($arrSol as $s)
			{
				$query="select clave from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$s;	
				$clave=$con->obtenerValor($query);
				$clave=substr($clave,0,6);
				$query="SELECT idProyectoComite FROM 9044_proyectoComitePartida p WHERE p.partida='".$clave."'";
				$fila=$con->obtenerPrimeraFila($query);
				if($fila)
				{
					$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=".$numEtapa." where idCodigoGastoCiclo = ".$s."";
					$x++;
					$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=".$numEtapa." where idCabecera = ".$s."";
					$x++;
				}
			}
		}
		else
		{
			if($numEtapa==5)
			{
				
				/*$arrSol=explode(",",$listSolicitudes);
				$tMovimiento=13;
				$folio=$rPresupuesto->obtenerFolioSiguiente($tMovimiento);
				foreach($arrSol as $s)
				{
					$totalOperacion=0;
					$query="SELECT * FROM 9110_objetosGastoVSCiclo WHERE idCodigoGastoCiclo=".$s;
					$fSolicitud=$con->obtenerPrimeraFila($query);
					$query="SELECT * FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$s;
					$resSol=$con->obtenerFilas($query);
					while($filaDist=$con->fetchRow($resSol))
					{
						$query="SELECT a.cveAlmacen,a.nombreAlmacen FROM 9101_CatalogoProducto c,9030_almacenes a WHERE idProducto=".$fSolicitud[5]." AND c.idAlmacen=a.idAlmacen";
						$fAlmacen=$con->obtenerPrimeraFila($query);
						$idAlmacen=$fAlmacen[0];
						$nAlmacen=$fAlmacen[1];
						$cadObj='{
										"fechaMovimiento":"'.date("Y-m-d").'",
										"folio":"'.$folio.'",
										"idResponsableMovimiento":"'.$_SESSION["idUsr"].'",
										"montoMovimiento":"'.$filaDist[4].'",
										"tipoMovimiento":"'.$tMovimiento.'",
										"mes":"'.$filaDist[2].'",
										"idRegistro":"'.$s.'",
										"idPrograma":"'.$fSolicitud[10].'",
										"ruta":"'.$fSolicitud[21].'",
										"idCiclo":"'.$fSolicitud[2].'",
										"departamento":"'.$fSolicitud[3].'",
										"capitulo":"'.substr($fSolicitud[1],0,3).'",
										"partida":"'.$fSolicitud[1].'",
										"horaMovimiento":"'.date("H:i").'",
										"tipoPresupuesto":"'.$fSolicitud[19].'"
									}';
							$totalOperacion+=$filaDist[4];
							$objAsiento=json_decode($cadObj);
							array_push($arrAsientos,$objAsiento);
							
					}
					$cadObj='{
								"tipoMovimiento":"'.$tMovimiento.'",
								"folio":"'.$folio.'",
								"montoOperacion":"'.$totalOperacion.'",
								"idPrograma":"'.$fSolicitud[10].'",
								"codDepto":"'.$fSolicitud[3].'", 
								"codPartida":"'.$fSolicitud[1].'", 
								"idLibro":"'.$rContabilidad->generarLibroDelDia().'",
								"tipoPresupuesto":"'.$fSolicitud[19].'"@resto
								
							}';
					if($idAlmacen!="")
						$cadObj=str_replace("@resto",',"datosComplementarios":{"noAlmacen":"'.$idAlmacen.'","nombreAlmacen":"'.$nAlmacen.'"}',$cadObj);
					else
						$cadObj=str_replace("@resto","",$cadObj);
					
					$objAsiento=json_decode($cadObj);
					array_push($arrAsientosContables,$objAsiento);
				}*/
			}
			
			$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=".$numEtapa." where idCodigoGastoCiclo in (".$listSolicitudes.")";
			$x++;
			$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=".$numEtapa." where idCabecera in (".$listSolicitudes.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
		
	function cerrarRegistroNecesidades3000EnvioAdquisiciones()
	{
		global $con;
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$idProceso=$_POST["idProceso"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT listaPartidas FROM 9116_responsablesPAT WHERE idPrograma=".$idPrograma." AND ruta='".$ruta."' AND idProceso=".$idProceso." AND idResponsable=".$_SESSION["idUsr"];
		$listPartidas=$con->obtenerValor($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="insert into 2000_cierresCicloProcesos(codigoInstitucion,ciclo,idResponsableCierre,fechaCierre,tipoCierre,complementario1,complementario2,
					complementario3,complementario4) values('".$_SESSION["codigoInstitucion"]."',".$ciclo.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',3,'".$ruta."',
					'".$idPrograma."','','".$idProceso."')";
		$x++;
		$query[$x]="UPDATE 9110_objetosGastoVSCiclo SET numEtapa=3 WHERE ruta='".$ruta."' AND idCiclo=".$ciclo." AND idPrograma=".$idPrograma." AND clave in (".$listPartidas.") and codInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerListadoSolicitudesGridAdquisiciones()
	{
		global $con;
		global $SO;
		$inicio=0;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		$cantidad=500000;
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=($_POST["ciclo"]);
		
		$capitulo=($_POST["capitulo"]);
		
		$condWhere="";
		$condAuxiliar="";
		$consulta="select codigoControl FROM 507_objetosGasto WHERE codigoControlPadre LIKE '".$capitulo."%' AND nivel=3";
		$listPartidas=$con->obtenerListaValores($consulta,"'");
		if($listPartidas=="")
			$listPartidas="-1";
		$condFiltro=" and (c.clave in(".$listPartidas.") or codigoControl in (".$capitulo.")) and numEtapa=3";
		
		$condAuxiliar="";
		$consulta="(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto,idProveedorSugerido,idMarcaSugerida,p.status_art
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    p.idProducto=c.idProducto ".$condWhere.$condAuxiliar." and c.idProducto<>-1)
				union
				(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					c.complementario as nombreProducto,
					justificacion,'0' as cantidad,c.observaciones,'0' as costo,'' as descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto,idProveedorSugerido,idMarcaSugerida,'1' as status
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    c.idProducto=-1 ".$condWhere.$condAuxiliar." and cabecera=1)
				
				 order by nombreProducto limit ".$inicio.",".$cantidad;

		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro;

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			$proveedorSugerido=$fila[20];
			if($proveedorSugerido!="")
			{
				$consulta="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$proveedorSugerido;
				$proveedorSugerido=$con->obtenerValor($consulta);
			}
			$marcaSugerida=$fila[21];
			if($marcaSugerida!="")
			{
				$consulta="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$marcaSugerida;
				$marcaSugerida=$con->obtenerValor($consulta);
			}
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"","numEtapa":"'.$fila[18].'","proveedorSugerido":"'.$proveedorSugerido.
					'","marcaSugerida":"'.$marcaSugerida.'","statusProducto":"'.$fila[22].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function obtenerListadoSolicitudesGridPresupuestos()
	{
		global $con;
		global $SO;
		$inicio=0;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		$cantidad=15000;
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=($_POST["ciclo"]);
		
		$capitulo=($_POST["capitulo"]);
		
		$condWhere="";
		$condAuxiliar="";
		$consulta="select codigoControl FROM 507_objetosGasto WHERE (codigoControlPadre LIKE '".$capitulo."%' AND nivel=3) or (codigoControl='".$capitulo."')";
		$listPartidas=$con->obtenerListaValores($consulta,"'");
		if($listPartidas=="")
			$listPartidas="-1";
		$condFiltro=" and c.clave in(".$listPartidas.") and numEtapa=5";
		
		$condAuxiliar="";
		$consulta="(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto,idProveedorSugerido,idMarcaSugerida
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    p.idProducto=c.idProducto ".$condWhere.$condAuxiliar." and c.idProducto<>-1)
				union
				(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					c.complementario as nombreProducto,
					justificacion,'0' as cantidad,c.observaciones,'0' as costo,'' as descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto,idProveedorSugerido,idMarcaSugerida
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    c.idProducto=-1 ".$condWhere.$condAuxiliar.")
				
				 order by nombreProducto limit ".$inicio.",".$cantidad;
		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro;

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			$proveedorSugerido=$fila[20];
			if($proveedorSugerido!="")
			{
				$consulta="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$proveedorSugerido;
				$proveedorSugerido=$con->obtenerValor($consulta);
			}
			$marcaSugerida=$fila[21];
			if($marcaSugerida!="")
			{
				$consulta="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$marcaSugerida;
				$marcaSugerida=$con->obtenerValor($consulta);
			}
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"","numEtapa":"'.$fila[18].'","proveedorSugerido":"'.$proveedorSugerido.'","marcaSugerida":"'.$marcaSugerida.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function registrarNuevoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$capitulo=$_POST["capitulo"];
		$obj=json_decode($cadObj);
		$consulta="INSERT INTO 9101_CatalogoProducto(nombreProducto,descripcion,objetoGasto,status_art,costoUnitarioInicial,codigoInstitucion) VALUES('".cv($obj->nombreProducto)."','".cv($obj->descripcion)."','".$obj->objetoGasto."',2,".$obj->costoUnitario.",'".$_SESSION["codigoInstitucion"]."')";
		if($con->ejecutarConsulta($consulta))
		{
			$idProducto=$con->obtenerUltimoID();
			$consulta="update 9101_CatalogoProducto set clave_Art='".$idProducto."' where idProducto=".$idProducto;
			$con->ejecutarConsulta($consulta);
			echo "1|".$idProducto;
		}
	}
	
	function obtenerNuevosProductos()
	{
		global $con;
		$consulta="select idProducto,nombreProducto,descripcion,costoUnitarioInicial as costoEstimado,objetoGasto as codigoCapitulo,(select nombreObjetoGasto from 507_objetosGasto o where o.codigoControl=c.objetoGasto ) as capitulo 
					from 9101_CatalogoProducto c where c.status_art=2 and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$arrProductos=$con->obtenerFilasJson($consulta);					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function obtenerSolicitudProducto()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$consulta="SELECT ruta,(SELECT CONCAT(cvePrograma,'] ',tituloPrograma) FROM 517_programas WHERE idPrograma=o.idPrograma),(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=o.codDepto) AS departamento,cantidad,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=o.idResponsable) AS solicitadoPor,idCiclo,ruta,o.idPrograma,o.codDepto,o.clave FROM 9110_objetosGastoVSCiclo o WHERE idProducto=".$idProducto;
		$res=$con->obtenerFilas($consulta);
		$arrObj="";
		$ct=0;
		while($fila=$con->fetchRow($res))
		{
			$capitulo=substr($fila[9],0,3);
			$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ruta='".$fila[0]."' and idPrograma=".$fila[7]." AND codigoUnidad='".$fila[8]."' AND ciclo=".$fila[5];
			$listPartidas=$con->obtenerListaValores($consulta);
			if($listPartidas=="")
				$listPartidas="-1";
			$consulta="SELECT CONCAT('[',clave,'] ',nombreObjetoGasto) FROM 507_objetosGasto WHERE codigoControl IN (".$listPartidas.") and codigoControl like '".$capitulo."%'";
			$resObj=$con->obtenerFilas($consulta);	
			$tblPartidas="<table><tr><td width='25'></td><TD width='250' class='letraRojaSubrayada8' align='left'>Partidas permitidas para este departamento:</td></tr><tr height='1'><td style='background-color:#900'></td></tr>";
			while($filaObj=$con->fetchRow($resObj))
			{
				$tblPartidas.="<tr><td></td><td><span class='letraExt'>".$filaObj[0]."</span></td></TR>";
			}
			$tblPartidas.="</table>";
			$rutas=obtenerCodigosRutas($fila[5]);
			$obj='{"programa":"['.$rutas[$fila[0]]." ".$fila[1].'","departamento":"'.$fila[2].'","cantidad":"'.$fila[3].'","solicitadoPor":"'.$fila[4].'","partidas":"'.$tblPartidas.'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObj.']}';
	}
	
	function obtenerObjetosGasto()
	{
		global $con;
		$capitulo=$_POST["capitulo"];
		$consulta="select codigoControl,concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where nivel=3 order by clave";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arreglo;
		
	}
	
	function clasificarNuevoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9101_CatalogoProducto SET idCategoria=".$obj->idCategoria.",nombreProducto='".cv($obj->nombreProducto)."',descripcion='".cv($obj->descripcion)."',objetoGasto='".cv($obj->objetoGasto)."',costoUnitarioInicial=".cv($obj->costoUnitario).",
				contenedor=".cv($obj->contenedor).",uni_medida='".cv($obj->unidadMedida)."',presentacion=".cv($obj->presentacion).",status_art=1 WHERE idProducto=".$obj->idProducto;
		$x++;
		
		$query="select * from 9110_objetosGastoVSCiclo where idProducto=".$obj->idProducto;
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			$query="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ruta='".$fila[21]."' and idPrograma=".$fila[10]." AND codigoUnidad='".$fila[3]."' AND ciclo=".$fila[2];
			$listPartidas=$con->obtenerListaValores($query);
			$arrPartidas=explode(",",str_replace("'","",$listPartidas));
			$query="SELECT objetoGasto FROM 9130_departamentoObjGastoNoCompra WHERE ruta='".$fila[21]."' AND idPrograma=".$fila[10]." AND departamento='".$fila[3]."' AND ciclo=".$fila[2];
			$listPartidasNo=$con->obtenerListaValores($query);
			$arrPartidasNo=explode(",",str_replace("'","",$listPartidasNo));
			if((!existeValor($arrPartidas,$obj->objetoGasto))||(existeValor($arrPartidasNo,$obj->objetoGasto)))
			{
				$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=7 where idCodigoGastoCiclo=".$fila[0];
				$x++;
			}
			
		}
						
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function rechazarNuevoProducto()
	{
		global $con;
		$motivo=$_POST["motivo"];
		$idProducto=$_POST["idProducto"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9101_CatalogoProducto set status_art=3 where idProducto=".$idProducto;
		$x++;
		$consulta[$x]="insert into  9101_productosRechazados(idProducto,motivoRechazo) VALUES(".$idProducto.",'".cv($motivo)."')";
		$x++;
		$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=7 where idProducto=".$idProducto;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function buscarProductoActivo()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="select idProducto,nombreProducto,descripcion from 9101_CatalogoProducto where nombreProducto like  '".$criterio."%' and status_art=1 order by nombreProducto";
		$arrProductos=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProductos).'}';
	}
	
	function reemplazarProducto()
	{
		global $con;
		$idProducto=$_POST["idProductoOrigen"];
		$idProductoReemplazo=$_POST["idProductoReemplazo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select idCodigoGastoCiclo from 9110_objetosGastoVSCiclo where idProducto=".$idProducto;
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			$idRegistroObjeto=$fila[0];
			$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios)
										SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios from 9110_objetosGastoVSCiclo where 
										idCodigoGastoCiclo=".$idRegistroObjeto;
			$x++;
			$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
							WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
			$x++;
		}
		$query="select objetoGasto from 9101_CatalogoProducto where idProducto=".$idProducto;
		$objetoGastoDestino=$con->obtenerValor($query);
		$query="select * from 9110_objetosGastoVSCiclo where idProducto=".$idProducto;
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchRow($res))
		{
			$query="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ruta='".$fila[21]."' and idPrograma=".$fila[10]." AND codigoUnidad='".$fila[3]."' AND ciclo=".$fila[2];
			$listPartidas=$con->obtenerListaValores($query);
			$arrPartidas=explode(",",str_replace("'","",$listPartidas));
			$query="SELECT objetoGasto FROM 9130_departamentoObjGastoNoCompra WHERE ruta='".$fila[21]."' AND idPrograma=".$fila[10]." AND departamento='".$fila[3]."' AND ciclo=".$fila[2];
			$listPartidasNo=$con->obtenerListaValores($query);
			$arrPartidasNo=explode(",",str_replace("'","",$listPartidasNo));
			if((!existeValor($arrPartidas,$objetoGastoDestino))||(existeValor($arrPartidasNo,$objetoGastoDestino)))
			{
				$consulta[$x]="update 9110_objetosGastoVSCiclo set numEtapa=7 where idCodigoGastoCiclo=".$fila[0];
				$x++;
			}
			
		}
		$consulta[$x]="update 9110_objetosGastoVSCiclo set idProducto=".$idProductoReemplazo.", version=version+1 where idProducto=".$idProducto;
		$x++;
		$consulta[$x]="update 9101_CatalogoProducto set status_art=0 where idProducto=".$idProducto;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	
	function obtenerListadoSolicitudesGridComite()
	{
		global $con;
		global $SO;
		$inicio=0;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		$cantidad=15000;
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=($_POST["ciclo"]);
		
		$capitulo=($_POST["capitulo"]);
		$idComite=$_POST["idComite"];
		$consulta="SELECT partida FROM 9044_proyectoComitePartida WHERE partida LIKE '".$capitulo."%' AND idProyectoComite IN (SELECT idProyectoVSComiteVSEtapa FROM 234_proyectosVSComitesVSEtapas WHERE idComite=".$idComite.")";
		$lisObjetosGasto=$con->obtenerListaValores($consulta,"'");
		if($lisObjetosGasto=="")
			$lisObjetosGasto="-1";
		$condWhere="";
		$condAuxiliar="";
		$consulta="select codigoControl FROM 507_objetosGasto WHERE codigoControlPadre in  (".$lisObjetosGasto.") AND nivel=3";
		$listPartidas=$con->obtenerListaValores($consulta,"'");
		if($listPartidas=="")
			$listPartidas="-1";
		$condFiltro=" and (c.clave in(".$listPartidas.") or codigoControl in (".$capitulo.")) and numEtapa=4";
		
		$condAuxiliar="";
		$consulta="(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    p.idProducto=c.idProducto ".$condWhere.$condAuxiliar." and c.idProducto<>-1)
				union
				(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					c.complementario as nombreProducto,
					justificacion,'0' as cantidad,c.observaciones,'0' as costo,'' as descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    c.idProducto=-1 ".$condWhere.$condAuxiliar." and cabecera=1)
				
				 order by nombreProducto limit ".$inicio.",".$cantidad;

		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro;

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"","numEtapa":"'.$fila[18].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function obtenerListadoSolicitudesGridObjetoGasto()
	{
		global $con;
		global $SO;
		$inicio=0;
		if(isset($_POST["start"]))
			$inicio=$_POST["start"];
		$cantidad=15000;
		if(isset($_POST["limit"]))
			$cantidad=$_POST["limit"];
		$idCiclo=($_POST["ciclo"]);
		$idPrograma=$_POST["idPrograma"];
		$ruta=$_POST["ruta"];
		
		$objetoGasto=($_POST["objetoGasto"]);
		
		$listPartidas="'".$objetoGasto."'";
		$condFiltro=" and c.clave in(".$listPartidas.")  and numEtapa=5";
		
		$condAuxiliar="";
		$consulta="(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    p.idProducto=c.idProducto and c.idProducto<>-1 and c.idPrograma=".$idPrograma." and ruta='".$ruta."')
				union
				(SELECT idCodigoGastoCiclo,o.clave,CONCAT('[',o.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,
					c.complementario as nombreProducto,
					justificacion,cantidad,c.observaciones,costoUnitario as costo,'' as descripcion, concat('[',org.codigoDepto,'] ',org.unidad) as unidad,montoTotal,c.modificable,
					'' as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa,c.idProducto
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND o.codigoControl=c.clave AND 
			    c.idProducto=-1 and cabecera=0 and c.idPrograma=".$idPrograma." and ruta='".$ruta."')
				
				 order by nombreProducto limit ".$inicio.",".$cantidad;

		$sqlQuery=bE($consulta);
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(*) FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p  where p.idProducto=c.idProducto and o.clave=c.clave and
			   idCiclo=".$idCiclo.$condFiltro. " and c.idPrograma=".$idPrograma." and ruta='".$ruta."'";

		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=$con->fetchRow($res))
		{
			if($fila[19]!=-1)
				$conCantidades="SELECT mes,format(cantidad,0) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			else
				$conCantidades="SELECT mes,format(monto,2) FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=$con->fetchRow($filas))
				{
					
					$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($fMeses[0]).'</span></td>';
					$fDatos.='<td align="center">'.$fMeses[1].'</td>';
				}
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj='{"idCodigoGastoCiclo":"'.$fila[0].'","clave":"'.cv($fila[1]).'","nombreObj":"'.cv($fila[2]).'","idCiclo":"'.cv($fila[3]).'","nombreProducto":"'.cv($fila[4]).'","justificacion":"'.
					cv(str_replace("#R","",$fila[5])).'","cantidad":"'.cv($fila[6]).'","cadenaMeses":"'.cv($cadenaAux).'","observaciones":"'.cv(str_replace("#R","",$fila[7])).'","costoUnitario":"'.cv($fila[8]).
					'","costoTotal":"'.($fila[11]).'","descripcion":"'.cv($fila[9]).'","depto":"'.cv($fila[10]).'","modificable":"'.$fila[12].'","etapa":"'.$fila[13].
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"","numEtapa":"'.$fila[18].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"arrEtapasOpciones":"[]","sqlQuery":"'.$sqlQuery.'","numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	
	function obtenerDistribucionProducto()
	{
		global $con;
		$iS=$_POST["iS"];
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$iS;
		$idProducto=$con->obtenerValor($consulta);
		if($idProducto!=-1)
			$conCantidades="SELECT cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$iS." order by mes";
		else
			$conCantidades="SELECT monto FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$iS." order by mes";
		$arrFilas=$con->obtenerFilasArreglo($conCantidades);
		echo "1|[".$arrFilas."]";
	}
	
	function modificarDistribucionProducto()
	{
		global $con;
		$x=0;
		$idRegistroObjeto=$_POST["iS"];
		$distribucion=$_POST["distribucion"];
		
		$query="select costoUnitario,idCabecera from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$idRegistroObjeto;
		$fila=$con->obtenerPrimerafila($query);
		
		$costoUnitario=$fila[0];
		
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios)
										SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios from 9110_objetosGastoVSCiclo where 
										idCodigoGastoCiclo=".$idRegistroObjeto;
		$x++;
		$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
						  WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
		$x++;
		$consulta[$x]="DELETE FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
		$x++;
		$arrCantidad=explode(",",$distribucion);
		$ct=0;
		$total=0;
		foreach($arrCantidad as $c)
		{
			$total+=$c;
			if($fila[1]=="")
			{
				$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) VALUES(".$idRegistroObjeto.",".$ct.",".$c.",".($c*$costoUnitario).")";
			}
			else
			{
				$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) VALUES(".$idRegistroObjeto.",".$ct.",1,".$c.")";
			}
			$x++;
			$ct++;
		}
		if($fila[1]=="")
		{
			$consulta[$x]="update 9110_objetosGastoVSCiclo set cantidad=".$total.",montoTotal=".($total*$costoUnitario)." where idCodigoGastoCiclo=".$idRegistroObjeto;
			$x++;
		}
		else
		{
			
			$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios)
										SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios from 9110_objetosGastoVSCiclo where 
										idCodigoGastoCiclo=".$fila[1];
			$x++;
			$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
							  WHERE idCodigoGastoCiclo=".$fila[1];
			$x++;
			$consulta[$x]="update 9110_objetosGastoVSCiclo set costoUnitario=".$total.",cantidad=1,version=version+1,montoTotal=".($total)." where idCodigoGastoCiclo=".$idRegistroObjeto;
			$x++;
			$query="select idCodigoGastoCiclo from 9110_objetosGastoVSCiclo where idCabecera=".$fila[1];
			$listProd=$con->obtenerListaValores($query);
			//$arrProductos=explode(",",$listProd);
			
			$consulta[$x]="set @montoTotal:=(select SUM(montoTotal) from 9110_objetosGastoVSCiclo where idCabecera=".$fila[1].")";
			
			$x++;
			$consulta[$x]="update 9110_objetosGastoVSCiclo set costoUnitario=@montoTotal,cantidad=1,
							montoTotal=@montoTotal where  idCodigoGastoCiclo=".$fila[1];

			$x++;	
			
			if($listProd=="")
				$listProd=-1;
			for($mes=0;$mes<12;$mes++)	
			{
				$consulta[$x]="set @montoTotal:=(select sum(monto) from 9111_cantidaObjVSMes where idCodigoGastoCiclo in (".$listProd.") and mes=".$mes.")";
				$x++;
				$consulta[$x]="update 9111_cantidaObjVSMes m set monto=@montoTotal where mes=".$mes." and idCodigoGastoCiclo=".$fila[1];
				$x++;
			}
										  
		}

		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerCategoriasPartida()
	{
		global $con;
		$codigoPartida=$_POST["partida"];
		$consulta="SELECT idCategoriaProducto,descripcion FROM 9100_categoriaProducto WHERE partida='".$codigoPartida."' or partida is null";
		$arrCategorias=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCategorias;
		
	}
	
	
	function agregarObjetoDegastoCompra()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$idRegistroObjeto=$obj->idRegistroObjeto;
		$query="begin";
		$idProveedor=$obj->idProveedorSugerido;
		if($idProveedor=="")
			$idProveedor="NULL";
		if($con->ejecutarConsulta($query))
		{
			if($obj->idRegistroObjeto!="-1")
			{
				$query="select idPrograma,ruta,tipoPresupuesto from  9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$obj->idRegistroObjeto;
				$filaDatos=$con->obtenerPrimeraFila($query);
				$obj->idPrograma=$filaDatos[0];
				$obj->ruta=$filaDatos[1];
				
			}
			if($obj->idMarca=="")
				$obj->idMarca="NULL";
			$query="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$obj->idProducto;
			$clave=$con->obtenerValor($query);
			$query="SELECT SUM(montoTotal) FROM 9110_objetosGastoVSCiclo o WHERE idCiclo=".$obj->idCiclo." AND codDepto='".$obj->codDepto."' AND idPrograma=".$obj->idPrograma." AND ruta='".$obj->ruta."' AND clave='".$clave."' and tipoPresupuesto=".$obj->tipoPresupuesto." and numEtapa not in (6,7,8)";
			$montoSolicitado=$con->obtenerValor($query);
			$query="SELECT techoPresupuestal FROM 523_techosPresupuestales WHERE ciclo=".$obj->idCiclo." AND programaInstitucional=".$obj->idPrograma." AND ruta='".$obj->ruta."' AND departamento='".$obj->codDepto."' AND  fuenteFinanciamiento=".$obj->tipoPresupuesto." and
					(objetoGasto='".$clave."' or objetoGasto like '".$clave."%')";
					
			$montoTecho=$con->obtenerValor($query);
			$suficiencia=$montoTecho-$montoSolicitado;
			if($idRegistroObjeto!="-1")
			{
				$query="select montoTotal from 9110_objetosGastoVSCiclo where idCodigoGastoCiclo=".$idRegistroObjeto;
				$montoAnterior=$con->obtenerValor($query);
				$suficiencia+=$montoAnterior;	
				if($obj->costoTotal>$suficiencia)
				{
					$query="select nombreObjetoGasto from 507_objetosGasto where codigoControl='".$clave."'";
					$nObjetoGasto=$con->obtenerValor($query);
					echo "<br>El monto solicitado (<b>$ ".number_format($obj->costoTotal,2)."</b>) excede el monto disponible de techo presupuestal (<b>$ ".number_format($suficiencia,2)."</b>) para el objeto de gasto '".$nObjetoGasto."'";
					return;
				}
				$query="select numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastociclo=".$idRegistroObjeto;
				$numEtapa=$con->obtenerValor($query);
				$incUnidad=0;
				if($numEtapa>1)
				{
				
					$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios,idMarcaSugerida)
									SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios,
									idMarcaSugerida
									from 9110_objetosGastoVSCiclo where 
									idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;
					$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
									WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;	
					$incUnidad=1;
				}
						
				$consulta[$x]="DELETE FROM 9111_cantidaObjVSMes WHERE idCodigoGastociclo=".$idRegistroObjeto;
				$x++;
				
				$consulta[$x]=	"UPDATE 9110_objetosGastoVSCiclo SET idMarcaSugerida=".$obj->idMarca.",tipoContrato=".$obj->tipoContrato.",porcentajeMinimo=".$obj->porcentajeMinimo.", version=version+".$incUnidad.",cantidad=".$obj->cantidad.",justificacion='".cv($obj->justificacion)."',idProveedorSugerido=".$idProveedor.",observaciones='".cv($obj->observaciones).
								"',responsableModif=".$_SESSION["idUsr"].",fechaUltimaModif='".date('Y-m-d')."',costoUnitario=".$obj->costoUnitario.",montoTotal=".$obj->costoTotal.",tipoPresupuesto=".$obj->tipoPresupuesto." WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
				$x++;
			}
			else
			{
				if($obj->costoTotal>$suficiencia)
				{
					$query="select nombreObjetoGasto from 507_objetosGasto where codigoControl='".$clave."'";
					$nObjetoGasto=$con->obtenerValor($query);
					echo "<br>El monto solicitado (<b>$ ".number_format($obj->costoTotal,2)."</b>) excede el monto disponible de techo presupuestal (<b>$ ".number_format($suficiencia,2)."</b>) para el objeto de gasto '".$nObjetoGasto."'";
					return;
				}
				$query="	INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,
							montoTotal,tipoPresupuesto,ruta,tipoContrato,porcentajeMinimo,idMarcaSugerida,numEtapa)
								VALUES('".$clave."',".$obj->idCiclo.",'".$obj->codDepto."','".$obj->codInstitucion."',".$obj->idProducto.",".$obj->cantidad.",'".cv($obj->justificacion)."',".
								$idProveedor.",'".cv($obj->observaciones)."',".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->costoUnitario.",".$obj->costoTotal.",".$obj->tipoPresupuesto.",'".$obj->ruta."',".
								$obj->tipoContrato.",".$obj->porcentajeMinimo.",".$obj->idMarca.",5)";

				if(!$con->ejecutarConsulta($query))
				{
					echo "|";
					return;	
				}
				$idRegistroObjeto=$con->obtenerUltimoID();
				$consulta[$x]="insert into 9110_bitacoraObjetosGastoVSCiclo(idCodigoGastoVSCiclo,etapaOrigen,etapaCambio,idResponsable,fechaCambio,comentarios) values
							(".$idRegistroObjeto.",0,1,".$_SESSION["idUsr"].",'".date('Y-m-d')."','')";
				$x++;		
			}
			$arrMeses=explode(",",$obj->distribucion);
			$consulta[$x]="INSERT INTO 525_productosAutorizados(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,
							montoTotal,tipoPresupuesto,ruta,tipoContrato,porcentajeMinimo,idMarcaSugerida,numEtapa)
								VALUES('".$clave."',".$obj->idCiclo.",'".$obj->codDepto."','".$obj->codInstitucion."',".$obj->idProducto.",".$obj->cantidad.",'".cv($obj->justificacion)."',".
								$idProveedor.",'".cv($obj->observaciones)."',".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->costoUnitario.",".$obj->costoTotal.",".$obj->tipoPresupuesto.",'".$obj->ruta."',".
								$obj->tipoContrato.",".$obj->porcentajeMinimo.",".$obj->idMarca.",5)";
			$x++;	
			$query="SELECT idCategoria,objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$obj->idProducto;
			$fProducto=$con->obtenerPrimeraFila($query);
			$consulta[$x]="INSERT INTO 527_concentradoProducto(idProducto,cantidad,costoUnitario,total,idTipoCompra,estado,ciclo,tipoProducto,codigoInstitucion,objetoGasto,solicitudesComprende,fuenteFinanciamiento,idCategoriaProducto)
							VALUES(".$obj->idProducto.",".$obj->cantidad.",".$obj->costoUnitario.",".$obj->costoTotal.",NULL,0,2012,1,'0001','".$fProducto[1]."',".$idRegistroObjeto.",1,".$fProducto[0].")";
			$x++;
			$consulta[$x]="set @idDistribucion:=(select last_insert_id())";
			$x++;
			for($ct=0;$ct<sizeof($arrMeses);$ct++)
			{
				$consulta[$x]="insert into 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad,monto) values(".$idRegistroObjeto.",".$ct.",".$arrMeses[$ct].",".($arrMeses[$ct]*$obj->costoUnitario).")";
				$x++;	
				$consulta[$x]="insert into 526_distribucionAutorizada(idCodigoGastoCiclo,mes,cantidad,monto) values(".$idRegistroObjeto.",".$ct.",".$arrMeses[$ct].",".($arrMeses[$ct]*$obj->costoUnitario).")";
				$x++;
				$consulta[$x]="insert into 528_distribucionConcentrado(idCompraVSProducto,mes,cantidad,monto) values(@idDistribucion,".$ct.",".$arrMeses[$ct].",".($arrMeses[$ct]*$obj->costoUnitario).")";
				$x++;
				
				
			}
										
			
			
			
			
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
		}
		else
			echo "|";
	}
	
	function obtenerProyeccionServicios()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT id__580_tablaDinamica AS `iS`,txtClave,txtEstudio,(SELECT costoTotal FROM _578_tablaDinamica WHERE cmbServicios=t.id__580_tablaDinamica AND cmbCiclo=".$ciclo.") as CostoTotal,
					(SELECT SUM(montoTotal) FROM 564_proyeccionCostoServicio where idServicio=t.id__580_tablaDinamica AND ciclo=".$ciclo.") AS montoProyectado,
					(SELECT SUM(totalServicios) FROM 564_proyeccionCostoServicio where idServicio=t.id__580_tablaDinamica AND ciclo=".$ciclo.") AS serviciosProyectados
					 FROM _580_tablaDinamica t";
		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
		
	function obtenerDefinicionEstructuraProgramatica()
	{
		global $con;
		$idSituacion=0;
		$lblSituacion="No configurado";
		$idPerfil=0;
		$lblPerfil="No configurado";
		$idCiclo=$_POST["idCiclo"];
		$campos="{name:'idRegistro'}";
		$columnas="new  Ext.grid.RowNumberer()";
		$fuenteClave="";
		$propertyNames="";
		$editores="";
		$arrRenderer="";
		$arrQuery=array();
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT situacion,idPerfilEstructura,idDefinicion FROM 9117_definicionEstructuraProgramatica WHERE ciclo=".$idCiclo;
		$fDefinicion=$con->obtenerPrimeraFila($consulta);
		if($fDefinicion)
		{
			$idPerfil=$fDefinicion[1];
			$idSituacion=$fDefinicion[0];
			$consulta="SELECT nombrePerfil,configuracion FROM 9117_perfilesEstructuraProgramatica WHERE idPerfilEstructura=".$idPerfil;
			$fPerfil=$con->obtenerPrimeraFila($consulta);
			$lblPerfil=$fPerfil[0];
			$configuracion=$fPerfil[1];
			if($configuracion!="")
			{
				$objConf=json_decode($configuracion);
				if(sizeof($objConf->arrConfiguracion)>0)
				{
					
					foreach($objConf->arrConfiguracion as $o)
					{
						
						$cObj="{name:'orden_".$o->orden."'},{name:'progAsociados'}";
						if($campos=="")
							$campos=$cObj;
						else
							$campos.=",".$cObj;
						$titulo=$o->titulo;
						if($o->abreviatura!="")
							$titulo.="<br>(".$o->abreviatura.")";
						$oCol="{align:'center',css:'text-align:left !important;',header:'".$titulo."',width:280,sortable:true,dataIndex:'orden_".$o->orden."',renderer:mostrarValorDescripcion}";
						if($columnas=="")
							$columnas=$oCol;
						else
							$columnas.=",".$oCol;
						
						$oFuente="orden_".$o->orden.":''";
						
						if($fuenteClave=="")
							$fuenteClave=$oFuente;
						else	
							$fuenteClave.=",".$oFuente;
						
						$oPropiedad="orden_".$o->orden.":'".$o->titulo."'";
						
						if($propertyNames=="")
							$propertyNames=$oPropiedad;
						else
							$propertyNames.=",".$oPropiedad;
						
						$oRenderer="orden_".$o->orden.":renderizarValor";
						if($arrRenderer=="")
							$arrRenderer=$oRenderer;
						else
							$arrRenderer.=",".$oRenderer;
						$consulta="select ".$o->campoId.",concat('[',".$o->campoCodigo.",'] ', ".$o->campoEtiqueta.") as etiqueta from ".$o->tablaOrigen." order by ".$o->campoEtiqueta;
						$query="(select concat('[',".$o->campoCodigo.",'] ', ".$o->campoEtiqueta.")  from ".$o->tablaOrigen." where ".$o->campoId."=@orden_".$o->orden.") as orden_".$o->orden;
						$arrQuery[$o->orden]=$query;
						$arrDatos=$con->obtenerFilasArreglo($consulta);
						$oEditor="orden_".$o->orden.":new Ext.grid.GridEditor(crearComboEditor(".$o->orden.",".$arrDatos."))";
						if($editores=="")
							$editores=$oEditor;
						else
							$editores.=",".$oEditor;
						
					}
					
					
					$consulta="SELECT definicion,idDetalle FROM 9117_detalleEstructuraProgramatica WHERE idDefinicion=".$fDefinicion[2];
					$resDef=$con->obtenerFilas($consulta);
					while($fAux=$con->fetchRow($resDef))
					{
						$cadConsulta="select ".$fAux[1]." as idRegistro,'@progAsociados' as progAsociados";
						$arrElementos=explode("_",$fAux[0]);
						foreach($objConf->arrConfiguracion as $o)
						{
							
							$cadConsulta.=",".str_replace("@orden_1",$arrElementos[($o->orden-1)],$arrQuery[$o->orden]);
						}
						$oReg=utf8_encode($con->obtenerFilasJSON($cadConsulta));
						$oReg=substr($oReg,1);
						$oReg=substr($oReg,0,strlen($oReg)-1);
						
						
						$tblProg='<br><table><tr height=\"21\"><td></td><td width=\"600\" ><span class=\"letraRojaSubrayada8\">Programas Institucional (PI)</span></td></tr>';
						
						$query="SELECT idEstructuraVSPrograma,concat('[',p.cvePrograma,'] ',p.tituloPrograma) FROM 9117_estructurasVSPrograma e,9117_detalleEstructuraProgramatica d, 517_programas p 
								WHERE p.idPrograma=e.idProgramaInstitucional and  idPartidaPresupuestal=d.idDetalle AND idDefinicion=".$fDefinicion[2]." order by p.cvePrograma,p.tituloPrograma";

						$resProg=$con->obtenerFilas($query);
						while($filaProg=$con->fetchRow($resProg))
						{
							
							$btnDelete='<a href=\"javascript:removerPrograma(\\\''.bE($filaProg[0]).'\\\')\"><img src=\'../images/delete.png\' alt=\'Remover programa\' title=\'Remover programa\'></a>';
							if($idSituacion==2)
								$btnDelete="";
							$tblProg.='<tr height=\'21\'><td width=\'85\'>'.$btnDelete.'&nbsp;<img src=\'../images/bullet_green.png\'>&nbsp;&nbsp;</td><td >'.$filaProg[1].'</td></tr>'	;
						}
						$tblProg.='</table>';	
						
						$oReg=str_replace("@progAsociados",$tblProg,$oReg);
						
						if($arrRegistros=="")
							$arrRegistros=$oReg;
						else
							$arrRegistros.=",".$oReg;
							
							
						
							
						$numReg++;
							
					}
					
					
				}
			}
			
			switch($idSituacion)
			{
				case 1:
					$lblSituacion="En diseño";
				break;
				case 2:
					$lblSituacion="Bloqueado";
				break;
			}
		}
		echo '{"arrRenderer":{'.$arrRenderer.'},"editores":{'.$editores.'},"propertyNames":{'.$propertyNames.'},"fuenteClave":{'.$fuenteClave.'},"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"campos":['.$columnas.'],"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"idSituacion":"'.$idSituacion.'","lblSituacion":"'.$lblSituacion.'","idPerfil":"'.$idPerfil.'","lblPerfil":"'.$lblPerfil.'"}';
	}
	
	function guardarPerfilEstructuraCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPerfil=$_POST["idPerfil"];
		$consulta="SELECT idDefinicion FROM 9117_definicionEstructuraProgramatica WHERE ciclo= ".$idCiclo;
		$idDefinicion=$con->obtenerValor($consulta);
		if($idDefinicion=="")
			$consulta="INSERT INTO 9117_definicionEstructuraProgramatica(ciclo,situacion,idPerfilEstructura) VALUES(".$idCiclo.",1,".$idPerfil.")";
		else
			$consulta="UPDATE 9117_definicionEstructuraProgramatica SET idPerfilEstructura=".$idPerfil." WHERE idDefinicion=".$idDefinicion;
		eC($consulta);
	}
	
	function removerClavePresupuestaria()
	{
		global $con;
		$idClave=$_POST["idClave"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9117_detalleEstructuraProgramatica WHERE idDefinicion=".$idClave;
		$x++;
		$consulta[$x]="DELETE FROM 9117_estructurasVSPrograma WHERE idPartidaPresupuestal=".$idClave;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarClaveProgramatica()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$clave=$_POST["clave"];

		$consulta="SELECT idDefinicion FROM 9117_definicionEstructuraProgramatica WHERE ciclo=".$idCiclo;
		$idDefinicion=$con->obtenerValor($consulta);
		if($idDefinicion=="")
			$idDefinicion=-1;
		$consulta="select count(*) from 9117_detalleEstructuraProgramatica where idDefinicion=".$idDefinicion." and definicion='".$clave."'";
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)
		{
			echo "<br>La clave presupuestaria ya ha sido registrada anteriormente";
			return;
		}
		$consulta="INSERT INTO 9117_detalleEstructuraProgramatica(idDefinicion,definicion) VALUES(".$idDefinicion.",'".$clave."')";
		eC($consulta);
	}
	
	function guardarProgramaClaveProgramatica()
	{
		global $con;

		$ruta=$_POST["ruta"];
		$listaProgramas=$_POST["listaProgramas"];
		$arrProgramas=explode(",",$listaProgramas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrProgramas as $iPrograma)
		{
			$consulta[$x]="INSERT INTO 9117_estructurasVSPrograma(idPartidaPresupuestal,idProgramaInstitucional) VALUES(".$ruta.",".$iPrograma.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerProgramaClaveProgramatica()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$consulta="DELETE FROM 9117_estructurasVSPrograma WHERE idEstructuraVSPrograma=".$idPrograma;
		eC($consulta);
	}
	
	
	function bloquearEstructuraProgramatica()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$consulta="UPDATE 9117_definicionEstructuraProgramatica SET situacion=2 WHERE ciclo=".$idCiclo;
		eC($consulta);
	}
	
	function obtenerProgramasEstructuraProgramaticaCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$cadRegistros=obtenerProgramasInstitucionalesVigentes($idCiclo,2);

		$lblSituacion="";
		$idSituacion=0;
		$consulta="select idRelacionDeptoPrograma from 9131_relacionDeptoPrograma WHERE ciclo=".$idCiclo;
		$idRelacion=$con->obtenerValor($consulta);
		if($idRelacion=="")
		{
			$lblSituacion="En diseño";	
		}
		else
		{
			$lblSituacion= "Bloqueado";
			$idSituacion=2;	
		}
		echo '1|{"arrProgramas":'.$cadRegistros.',"lblSituacion":"'.$lblSituacion.'","idSituacion":"'.$idSituacion.'"}';
		
	}
	
	function obtenerDepartamentosProgramaCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$consulta="SELECT idDepartamentoVSPrograma,o.codigoDepto AS cveDepto,o.unidad,o.codigoUnidad AS codUnidad,
					partidas FROM 817_organigrama o,9130_departamentoVSPrograma d 
					WHERE o.codigoUnidad=d.codigoUnidad AND idPrograma=".$idPrograma." ORDER BY o.unidad";
		$arrReg=utf8_encode($con->obtenerfilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrReg.'}';
	}
	
	function bloquearDefinicionDepartamentoPartidaCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$consulta="INSERT INTO 9131_relacionDeptoPrograma(ciclo,codigoInstitucion) VALUES(".$idCiclo.",'".$_SESSION["codigoInstitucion"]."')";
		eC($consulta);
	}
	
	function buscarProductoCompra()
	{
		global $con;
		$arrDatos="";
		$factorInflacion=0.1;
		$idCiclo=$_POST["idCiclo"];
		$departamento=$_POST["departamento"];
		$criterio=$_POST["criterio"];
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$numReg=0;
		$listPartidas="";
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ciclo=".$idCiclo." AND codigoUnidad='".$departamento."'";
		//echo $consulta."<br>";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if($listPartidas=="")
				$listPartidas=$fila[0];
			else
				$listPartidas.=",".$fila[0];
		}
		if($listPartidas=="")
			$listPartidas=-1;
		$consulta="SELECT idProducto,nombreProducto,descripcion,costoEstimado,objetoGasto FROM 6901_catalogoProductos WHERE nombreProducto LIKE '%".$criterio."%' AND objetoGasto IN(".$listPartidas.") ORDER BY nombreProducto limit ".$inicio.",".$cantidad;
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			
			$costo=$fila[3];
			$montoInflacion=$costo*$factorInflacion;
			$costo+=$montoInflacion;
			$obj='{"objetoGasto":"'.$fila[4].'","idProducto":"'.$fila[0].'","nombreProducto":"'.cv($fila[1]).'","descripcion":"'.cv($fila[2]).'","costoUnitario":"'.number_format($costo,2).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrDatos.']}';
	}
	
	function buscarProgramaProductoDisponible()
	{
		global $con;
		$cadProgramas="";
		$idCiclo=$_POST["idCiclo"];
		$departamento=$_POST["departamento"];
		$objetoGasto=$_POST["objetoGasto"];
		$arrProgramas=obtenerProgramasInstitucionalesVigentes($idCiclo,1);
		$consulta="SELECT idPrograma FROM 9130_departamentoVSPrograma WHERE ciclo=".$idCiclo." AND codigoUnidad='".$departamento."' AND partidas LIKE \"%'".$objetoGasto."'%\"";
		$arrProd=array();
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			if(isset($arrProgramas[$fila[0]]))
				$arrProd[$arrProgramas[$fila[0]]]=$fila[0];
		}

		ksort($arrProd);
		if(sizeof($arrProd)>0)
		{
			foreach($arrProd as $p=>$id)
			{
				$obj="['".$id."','".$p."']";
				if($cadProgramas=="")
					$cadProgramas=$obj;
				else
					$cadProgramas.=",".$obj;
			}
		}
		echo "1|[".$cadProgramas."]";
	}
	
	function obtenerPersupuestoProgramaProductoDisponible()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$departamento=$_POST["departamento"];
		$objetoGasto=$_POST["partida"];
		$idPrograma=$_POST["idPrograma"];
		
		$consulta="SELECT DISTINCT idTipoPresupuesto,tituloTipoP FROM 523_presupuestoAutorizado p,508_tiposPresupuesto t 
					WHERE ciclo=".$idCiclo." AND programa=".$idPrograma." AND depto=".$departamento." AND partida=".$objetoGasto." AND t.idTipoPresupuesto=p.tipoPresupuesto ORDER BY tituloTipoP";
			
		$arrPresupuesto=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPresupuesto;
	}
	
	function registrarSolicitudCompra()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrMovimientos=array();
		$tipoMovimiento=27;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idCiclo=-1;
		foreach($obj->registros as $r)
		{
			$idCiclo=$r->ciclo;
			$mes=date("m",strtotime($r->fechaMaximaCompra));
			$mes--;
			$query="SELECT objetoGasto FROM 6901_catalogoProductos WHERE idProducto=".$r->idProducto;
			$partida=$con->obtenerValor($query);
			$consulta[$x]="INSERT INTO 6926_solicitudesCompra(responsableSolicitud,fechaRegistro,situacion)
						VALUES(".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',1)";
			$x++;
			$consulta[$x]="set @idSolicitud:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,numEtapa,tipoPresupuesto,idMarcaSugerida,idSolicitudCompra)
							VALUES('".$partida."',".$r->ciclo.",'".$r->departamento."','".$_SESSION["codigoInstitucion"]."',".$r->idProducto.",".$r->cantidad.",".$r->idPrograma.",".$obj->idSolicitante.",'".date("Y-m-d")."',".$r->costoUnitario.",".$r->total.
							",1,".$r->idPresupuesto.",".$r->marcaSugeria.",@idSolicitud)";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad) VALUES(@idRegistro,".$mes.",".$r->cantidad.")";
			$x++;
			$consulta[$x]="INSERT INTO 525_productosAutorizados(idCodigoGastoCiclo,clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,numEtapa,tipoPresupuesto,idMarcaSugerida,idSolicitudCompra,fechaMaximaCompra)
							VALUES(@idRegistro,'".$partida."',".$r->ciclo.",'".$r->departamento."','".$_SESSION["codigoInstitucion"]."',".$r->idProducto.",".$r->cantidad.",".$r->idPrograma.",".$obj->idSolicitante.",'".date("Y-m-d")."',".$r->costoUnitario.",".$r->total.
							",1,".$r->idPresupuesto.",".$r->marcaSugeria.",@idSolicitud,'".$r->fechaMaximaCompra."')";
			$x++;
			$consulta[$x]="INSERT INTO 526_distribucionAutorizada(idCodigoGastoCiclo,mes,cantidad) VALUES(@idRegistro,".$mes.",".$r->cantidad.")";
			$x++;
			$consulta[$x]="INSERT INTO 527_concentradoProducto(idProducto,cantidad,costoUnitario,total,estado,ciclo,tipoProducto,codigoInstitucion,objetoGasto,solicitudesComprende,fuenteFinanciamiento) 
						VALUES(".$r->idProducto.",".$r->cantidad.",".$r->costoUnitario.",".$r->total.",1,".$r->ciclo.",0,'".$_SESSION["codigoInstitucion"]."','".$partida."',@idRegistro,".$r->idPresupuesto.")";
			$x++;
			$consulta[$x]="set @idConcentrado:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 528_distribucionConcentrado(idCompraVSProducto,mes,cantidad,monto) VALUES(@idConcentrado,".$mes.",".$r->cantidad.",0)";
			$x++;	
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$r->idPrograma;
			$arrDimensiones["codigoUnidad"]=$r->departamento;
			$arrDimensiones["idPartida"]=$partida;
			$arrDimensiones["idTipoPresupuesto"]=$r->idPresupuesto;
			$arrDimensiones["idMes"]=$mes;
			$arrDimensiones["idProducto"]=$r->idProducto;
			$cadObj='{"tipoMovimiento":"'.$tipoMovimiento.'","montoOperacion":"'.$r->total.'","dimensiones":null}';
			$obj=json_decode($cadObj);
			$obj->dimensiones=$arrDimensiones;
			array_push($arrMovimientos,$obj);
			
									
		
		}
		$c=new cContabilidad($idCiclo);
		$vNull=null;
		$vNull2=null;
		if($c->asentarArregloMovimientos($arrMovimientos,$vNull,$vNull2,true))
		{
		
			$consulta[$x]="commit";
			$x++;
			eB($consulta);	
		}
			
	}
	
	function obtenerSolicitudesCompra()
	{
		global $con;
		$cadObj="";

		$arrSolicitudes=array();
		$idCiclo=$_POST["idCiclo"];
		$departamento=$_POST["departamento"];
		$arrProgramas=obtenerProgramasInstitucionalesVigentes($idCiclo,1);
		$consulta="SELECT s.idSolicitud,s.fechaRegistro AS fechaSolicitud,s.idSolicitud AS folioSolicitud,pr.nombreProducto,p.cantidad,p.montoTotal AS montoEstimado,
					p.fechaMaximaCompra,p.idPrograma,(SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=p.tipoPresupuesto) as tipoPresupuesto,idMarcaSugerida,pr.idAlmacen,pr.idProducto
					FROM 6926_solicitudesCompra s,525_productosAutorizados p,6901_catalogoProductos pr WHERE p.idSolicitudCompra=s.idSolicitud
					AND pr.idProducto=p.idProducto AND idCiclo=".$idCiclo." AND codDepto='".$departamento."' ORDER BY pr.nombreProducto";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fila[7];
			$arrDimensiones["codigoUnidad"]=$departamento;
			$idAlmacen=$fila[10];
			$a=new cAlmacen($idAlmacen);
			$consulta="SELECT idTiempoMovimiento FROM 6902_tiempoMovimientosAlmacen WHERE idAlmacen=".$idAlmacen." AND referencienciaExistencia=1";
			$idTiempoExistencia=$con->obtenerValor($consulta);
			if($idTiempoExistencia=="")
				$idTiempoExistencia=-1;
				
			$existencia=$a->obtenerCantidadTiempoMovimiento($fila[11],$idTiempoExistencia,$arrDimensiones);	
				
			$marca="Cualquiera";
			if($fila[9]!="")
			{
				$consulta="SELECT nombreMarca FROM 6910_catalogoMarcas WHERE idMarca=".$fila[9];
				$marca=$con->obtenerValor($consulta);
			}
			$obj='{"idSolicitud":"'.$fila[0].'","fechaSolicitud":"'.$fila[1].'","folioSolicitud":"'.$fila[0].'","producto":"'.cv($fila[3]).'","cantidad":"'.$fila[4].'","montoEstimado":"'.$fila[5].'",
				"marcaSugerida":"'.$marca.'","fechaMaximaCompra":"'.$fila[6].'","programa":"'.cv($arrProgramas[$fila[7]]).'","tipoPresupuesto":"'.$fila[8].'","montoCompra":"","fechaCompra":"","fechaEntrega":"","existenciaAlmacen":"'.number_format($existencia,2).'","situacion":"En espera de compra"}';
			if(!isset($arrSolicitudes[$arrProgramas[$fila[7]]]))
			{
				$arrSolicitudes[$arrProgramas[$fila[7]]]=array();
			}
			array_push($arrSolicitudes[$arrProgramas[$fila[7]]],$obj);
		}
		ksort($arrSolicitudes);
		
		$nReg=0;
		if(sizeof($arrSolicitudes)>0)
		{
			foreach($arrSolicitudes as $arrPrograma)
			{
				foreach($arrPrograma as $s)
				{
					if($cadObj=="")
						$cadObj=$s;
					else
						$cadObj.=",".$s;
					$nReg++;
				}
			}
		}

		echo '{"numReg":"'.$nReg.'","registros":['.$cadObj.']}';
	}
	
	function obtenerSolicitudesCompraPendientes()
	{
		global $con;
		$cadObj="";

		$arrSolicitudes=array();
		$idCiclo=$_POST["idCiclo"];
		$nReg=0;
		$arrProgramas=obtenerProgramasInstitucionalesVigentes($idCiclo,1);
		$consulta="SELECT s.idSolicitud,s.fechaRegistro AS fechaSolicitud,s.idSolicitud AS folioSolicitud,pr.nombreProducto,p.cantidad,p.montoTotal AS montoEstimado,
					p.fechaMaximaCompra,p.idPrograma,(SELECT tituloTipoP FROM 508_tiposPresupuesto WHERE idTipoPresupuesto=p.tipoPresupuesto) as tipoPresupuesto,idMarcaSugerida,pr.idAlmacen,pr.idProducto,
					(select unidad from 817_organigrama where codigoUnidad=p.codDepto limit 0,1) as departamento,(select Nombre from 800_usuarios where idUsuario=p.idResponsable) as solicitante,p.codDepto,pr.gravaIVA,pr.idProducto,p.idCodigoGastoCiclo
					FROM 6926_solicitudesCompra s,525_productosAutorizados p,6901_catalogoProductos pr WHERE p.idSolicitudCompra=s.idSolicitud
					AND pr.idProducto=p.idProducto AND idCiclo=".$idCiclo."  and p.situacionCompra=1 ORDER BY pr.nombreProducto";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fila[7];
			$arrDimensiones["codigoUnidad"]=$fila[14];
			$idAlmacen=$fila[10];
			$a=new cAlmacen($idAlmacen);
			$consulta="SELECT idTiempoMovimiento FROM 6902_tiempoMovimientosAlmacen WHERE idAlmacen=".$idAlmacen." AND referencienciaExistencia=1";
			$idTiempoExistencia=$con->obtenerValor($consulta);
			if($idTiempoExistencia=="")
				$idTiempoExistencia=-1;
				
			$existencia=$a->obtenerCantidadTiempoMovimiento($fila[11],$idTiempoExistencia,$arrDimensiones);	
				
			$marca="Cualquiera";
			if($fila[9]!="")
			{
				$consulta="SELECT nombreMarca FROM 6910_catalogoMarcas WHERE idMarca=".$fila[9];
				$marca=$con->obtenerValor($consulta);
			}
			$s='{"idProducto":"'.$fila[16].'","gravaIva":"'.$fila[15].'","departamentoSolicitante":"'.cv($fila[12]).'","usuarioSolicitante":"'.cv($fila[13]).'","idSolicitud":"'.$fila[17].'","fechaSolicitud":"'.$fila[1].'","folioSolicitud":"'.$fila[0].'","producto":"'.cv($fila[3]).'","cantidad":"'.$fila[4].'","montoEstimado":"'.$fila[5].'",
				"marcaSugerida":"'.$marca.'","fechaMaximaCompra":"'.$fila[6].'","programa":"'.cv($arrProgramas[$fila[7]]).'","tipoPresupuesto":"'.$fila[8].'","montoCompra":"","fechaCompra":"","fechaEntrega":"","existenciaAlmacen":"'.number_format($existencia,2).'","situacion":"En espera de compra"}';
			
			
			if($cadObj=="")
				$cadObj=$s;
			else
				$cadObj.=",".$s;
			$nReg++;
			
		}
		//ksort($arrSolicitudes);
		echo '{"numReg":"'.$nReg.'","registros":['.$cadObj.']}';
	}
	
	function buscarProductores()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT * from (select idProveedor,CONCAT('[',rfc1,'-',rfc2,'-',rfc3,'] ',nombreProveedor) AS nombreProveedor FROM  6912_proveedores) as tmp where nombreProveedor like '%".$criterio."%'  ORDER BY nombreProveedor";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function registrarCompraProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$arrMovimientos=array();
		$tipoMovimiento=21;
		$idAlmacen=4;
		$idCiclo=$obj->idCiclo;
		$listConcentrado="";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->registros as $r)
		{
			$arrSolicitud=explode(",",$r->idSolicitud);
			foreach($arrSolicitud as $idSol)
			{
				$query="SELECT idCompraVSProducto FROM 527_concentradoProducto WHERE solicitudesComprende=".$idSol;
				$idSolicitud=$con->obtenerValor($query);
				$consulta[$x]="UPDATE 527_concentradoProducto SET costoUnitarioCompra=".$r->costoUnitario." WHERE idCompraVSProducto=".$idSolicitud;
				$x++;
				if($listConcentrado=="")
					$listConcentrado=$idSolicitud;
				else
					$listConcentrado.=",".$idSolicitud;
			}
		}
		
		
		
		$consulta[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,status_pedido,fechaRecepcion,idAlmacen,ciclo,idConcentradoProducto,numEntrega,condicionPago)
					VALUES(".$obj->idProveedor.",'".date("Y-m-d")."',1,'".$obj->fechaEntrega."',".$idAlmacen.",".$obj->idCiclo.",".$listConcentrado.",1,".$obj->idCondicionPago.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$consulta[$x]="update 9102_PedidoCabecera set folioPedido=@idRegistro where idPedido=@idRegistro";
		$x++;
		foreach($obj->registros as $r)
		{
			$query="SELECT * FROM 525_productosAutorizados WHERE idCodigoGastoCiclo=".$r->idSolicitud;
			$fProducto=$con->obtenerPrimeraFila($query);
			$consulta[$x]="UPDATE 525_productosAutorizados SET situacionCompra=0 WHERE idCodigoGastoCiclo=".$r->idSolicitud;
			$x++;
			$consulta[$x]="INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,cantidad,costoUnitario,iva,statusPedido,idContenedor,idUnidadMedida,idPresentacion,fechaPedido,partida,subtotal,total)
						VALUES(@idRegistro,".$r->idProducto.",".$r->idMarca.",".$r->cantidad.",".$r->costoUnitario.",".$r->iva.",1,1,1,1,'".date("Y-m-d")."','".$fProducto[1]."',".$r->subtotal.",".$r->total.")";
			$x++;
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fProducto[10];
			$arrDimensiones["codigoUnidad"]=$fProducto[3];
			$arrDimensiones["idPartida"]=$fProducto[1];
			$arrDimensiones["idTipoPresupuesto"]=$fProducto[19];
			$arrDimensiones["idProducto"]=$r->idProducto;
			$query="SELECT mes,cantidad,idObjGastoCantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fProducto[0]." AND cantidad>0";
			$resMonto=$con->obtenerFilas($query);
			while($fila=$con->fetchRow($resMonto))
			{
				$cantidad=$fila[1];
				$montoMes=($cantidad*$r->total)/$r->cantidad;
				$arrDimensiones["idMes"]=$fila[0];
				$consulta[$x]	="UPDATE 526_distribucionAutorizada SET montoCompra=".$montoMes." WHERE idObjGastoCantidad=".$fila[2];
				$x++;
				$cadObj='{"tipoMovimiento":"'.$tipoMovimiento.'","montoOperacion":"'.$montoMes.'","dimensiones":null}';
				$obj=json_decode($cadObj);
				$obj->dimensiones=$arrDimensiones;
				array_push($arrMovimientos,$obj);
			}
		}
		$c=new cContabilidad($idCiclo);
		$vNull=null;
		$vNull2=null;
		if($c->asentarArregloMovimientos($arrMovimientos,$vNull,$vNull2,true))
		{
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
		}
	}
?>