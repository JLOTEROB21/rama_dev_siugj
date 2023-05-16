<?php session_start();
	include("conexionBD.php");
	include_once("cPresupuesto.php");
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
			inscribirProveedorAConvocatoria();
		break;
		case 14:
			removerProveedorPartida();
		break;
		case 15:
			cerrarLicitacion();
		break;
		case 17:
			obtenerProductosCompras();
		break;
		case 18:
			obtenerProveedoresParticipantes();
		break;
		case 19:
			removerProveedorParticipante();
		break;
		case 20:
			agregarProveedorParticipante();
		break;
		case 21:
			buscarProveedor();
		break;
		case 22:
			obtenerPropuestaProveedor();
		break;
		case 23:
			guardarPartidasNoParticipaProveedor();
		break;
		case 24:
			guardarPropuestaProveedor();
		break;
		case 25:
			cerrarPropuestaProveedor();
		break;
		case 26:
			obtenerParticipantesPartidas();
		break;
		case 27:
			guardarDictamenPropuesta();
		break;
		case 28:
			cerrarDictamenPartida();
		break;
		case 29:
			obtenerPartidasLicitacion();
		break;
		case 30:
			obtenerGanadorPartidas();
		break;
		case 50:
			obtenerSumatoriaProductosValidos();
		break;
		case 51:
			guaradarConcentradoProductos();
		break;
		case 52:
			obtenerComprasLicitacion();
		break;
		case 53:
			obtenerProductosLicitacion();
		break;
		case 54:
			guardarProductosLicitacion();
		break;
		case 55:
			eliminarProductosLicitacion();
		break;
		case 56:
			obtenerResultadosLicitacion();
		break;
		case 57:
			guardarProveedorElegidoLicitacion();
		break;
		case 58:
			obtenerPartidasDisponibles();
		break;
		case 59:
			registrarPedidos();
		break;
		case 60:
			obtenerProductosEsperaCompra();
		break;
		case 61:
			obtenerDepartamentosSolicitudesProductos();
		break;
		case 62:
			guardarCompraDirecta();
		break;
		case 63:
			obtenerProveedoresEsperaPedido();
		break;
		case 64:
			obtenerProductoEsperaPedido();
		break;
		case 65:
			obtenerListadoNecesidadesProducto();
		break;
		case 66:
			guardarCompraPedido();
		break;
		case 67:
			removerPropuestaProveedor();
		break;
		case 68:
			obtenerDistribucionSolicitud();
		break;
		case 69:
			registrarTipoCompraProducto();
		break;
		case 70:
			obtenerDepartamentosSolicitudesProductosDivididos();
		break;
		case 71:
			registrarContratoAbierto();
		break;
		case 72:
			obtenerProveedoresResolucionPartida();
		break;
		case 73:
			registrarResolucionPartidaProveedor();
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
			if($idRegistroObjeto!="-1")
			{
				$consulta[$x]="DELETE FROM 9113_cantidadSolicitudVSMes WHERE idSolicitud=".$idRegistroObjeto;
				$x++;
				$consulta[$x]=	"UPDATE 9112_solicitudesCompras SET cantidad=".$obj->cantidad.",justificacion='".cv($obj->justificacion)."',idProveedorSugerido=".$idProveedor.",observaciones='".cv($obj->observaciones).
								"',responsableModif=".$_SESSION["idUsr"].",fechaUltimaModif='".date('Y-m-d')."',costoUnitario=".$obj->costoUnitario.",montoTotal=".$obj->costoTotal.",tipoPresupuesto=".$obj->tipoPresupuesto." WHERE idSolicitud=".$idRegistroObjeto;
				$x++;
			}
			else
			{
				$query="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$obj->idProducto;
				$clave=$con->obtenerValor($query);
				$query="	INSERT INTO 9112_solicitudesCompras(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,tipoPresupuesto)
								VALUES(".$clave.",".$obj->idCiclo.",'".$obj->codDepto."','".$obj->codInstitucion."',".$obj->idProducto.",".$obj->cantidad.",'".cv($obj->justificacion)."',".
								$idProveedor.",'".cv($obj->observaciones)."',".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->costoUnitario.",".$obj->costoTotal.",".$obj->tipoPresupuesto.")";
				if(!$con->ejecutarConsulta($query))
				{
					echo "|";
					return;	
				}
				$idRegistroObjeto=$con->obtenerUltimoID();
			}
			$arrMeses=explode(",",$obj->distribucion);
			for($ct=0;$ct<sizeof($arrMeses);$ct++)
			{
				$consulta[$x]="insert into 9113_cantidadSolicitudVSMes(idSolicitud,mes,cantidad) values(".$idRegistroObjeto.",".$ct.",".$arrMeses[$ct].")";
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
		$criterio=$_POST["criterio"];
		$inicio=$_POST["start"];
		$cantidad=$_POST["limit"];
		$codDepto=bD($_POST["codDepto"]);
		$programa=bD($_POST["programa"]);
		$capitulos=bD($_POST["capitulos"]);
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $tipoCosto;
		global $nPromedio;
		global $tipoOG;
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
			$particula="(objetoGasto>=".$c." and objetoGasto<=".$cFin.")";	
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		if($tipoCosto==1)
			$costo="(SELECT costoUnitario FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,1) as costo";	
		else
			$costo="(SELECT avg(costoUnitario) FROM 9103_PedidoDetalle WHERE idProducto=p.idProducto ORDER BY fechaPedido DESC LIMIT 0,".$nPromedio.") as costo";	
		
		
		$consulta="select idProducto,nombreProducto,descripcion,".$costo." from 9101_CatalogoProducto p  where (".$cadCapitulos.") and 
					nombreProducto like '".$criterio."%'  order by nombreProducto limit ".$inicio.",".$cantidad;

		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idProducto":"'.$fila[0].'","nombreProducto":"'.cv($fila[1]).'","descripcion":"'.cv($fila[2]).'","costoUnitario":"'.number_format($fila[3],2).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
			
		}
		$consulta="select idProducto,nombreProducto from 9101_CatalogoProducto  where objetoGasto in(".$capitulos.") and status_art=1 and nombreProducto like '".$criterio."%'";
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
			$query[$ct]="DELETE FROM 9113_cantidadSolicitudVSMes WHERE idSolicitud=".$idCodigoGastoCiclo;
			$ct++;
			$query[$ct]="DELETE FROM 9112_solicitudesCompras WHERE idSolicitud=".$idCodigoGastoCiclo;
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
		$consulta="SELECT * FROM 9112_solicitudesCompras WHERE idSolicitud=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$fila[5];
		$nombre=$con->obtenerValor($conNombre);
		$nombreP="";
		if($fila[8]!="")
		{
			$conNombreProov="SELECT txtRazonSocial2 FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$fila[8];
			$nombreP=$con->obtenerValor($conNombreProov);
		}
		$conMeses="SELECT cantidad FROM 9113_cantidadSolicitudVSMes WHERE idSolicitud=".$id." ORDER BY mes";
		$resMeses=$con->obtenerFilas($conMeses);
		$cadenaHijo="";
		while($filaMes=mysql_fetch_row($resMeses))
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
		echo "1|".$fila[5]."|".$nombre."|".$fila[6]."|".$fila[7]."|[".uEJ($cadenaHijo)."]|".$fila[0]."|".$fila[8]."|".$fila[9]."|".$nombreP."|".$fila[15]."|".$fila[16]."|".$fila[19];
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
		$consulta="SELECT idSolicitud,idProducto,cantidad,idCiclo FROM 9112_solicitudesCompras WHERE idProducto=".$idProducto." AND idCiclo<>".$idCiclo." AND idPrograma=".$idPrograma." AND codDepto='".$codDepartamento."'";	
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		if($nFilas>0)
		{
			$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
			$nombre=$con->obtenerValor($conNombre);
			
			while($filaM=mysql_fetch_row($res))
			{
				$conMeses="SELECT mes,cantidad FROM 9113_cantidadSolicitudVSMes WHERE idCodigoGastoCiclo=".$filaM[0]." ORDER BY mes";
				//echo $conMeses;
				$rMeses=$con->obtenerFilas($conMeses);
				$cadenaHijo="";
				while($fMes=mysql_fetch_row($rMeses))
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
		while($fila=mysql_fetch_row($res))
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
			$cFin=substr($c,0,1);
			if($tipoOG==1)
				$cFin=str_pad($cFin,strlen($c),"9",STR_PAD_RIGHT);
			else
			{
				$cFin=str_pad($cFin,strlen($c)+1,"9",STR_PAD_RIGHT);
				$c.="0";
			}
			$particula="(objetoGasto>=".$c." and objetoGasto<=".$cFin.")";	
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		$consulta="SELECT concat('[',clave,'] ',nombreObjetoGasto),codigoControl FROM 507_objetosGasto WHERE clave>2000 AND clave<3000 AND CONCAT(clave,'') LIKE '%00'";
		$res=$con->obtenerFilas($consulta);
		$arrSubPartida=array();
		while($fila=mysql_fetch_row($res))
			$arrSubPartida[$fila[1]]["clave"]=$fila[0];
		
		
		
		$consulta="SELECT cp.idProducto,o.codigoControlPadre,CONCAT('[',cp.0bjetoGasto,'] ',o.nombreObjetoGasto) AS 'nombreObjetoGasto',cp.nombreProducto,cp.descripcion 
						FROM 9101_CatalogoProducto cp,507_objetosGasto o  
						WHERE o.clave=cp.0bjetoGasto AND ".$cadCapitulos." ".$condWhere." and  cp.status_art=1 order by nombreProducto limit ".$inicio." ,".$cantidad;		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idProducto":"'.$fila[0].'","subPartida":"'.cv($arrSubPartida[$fila[1]]["clave"]).'","nombreObjetoGasto":"'.cv($fila[2]).'","nombreProducto":"'.cv($fila[3]).'","descripcion":"'.cv($fila[4]).'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$consulta="SELECT cp.idProducto,o.codigoControlPadre,CONCAT('[',cp.0bjetoGasto,'] ',o.nombreObjetoGasto) AS 'nombreObjetoGasto',cp.nombreProducto,cp.descripcion 
						FROM 9101_CatalogoProducto cp,507_objetosGasto o  
						WHERE o.clave=cp.0bjetoGasto AND ".$cadCapitulos." and cp.status_art=1 ".$condWhere; 
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
		while($filaEtapa=mysql_fetch_row($resEtapas))
		{
			$permisos="";
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=1 and numEtapa=".$filaEtapa[0];
			$idActorProcesoEtapa=$con->obtenerValor($consulta);	   
			if($idActorProcesoEtapa=="")
				$idActorProcesoEtapa="-1";
			$consulta="SELECT idGrupoAccion,complementario FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$idActorProcesoEtapa;
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
			$pos=existeValorMatriz($arrAcciones,"1");
			if($pos!=-1)
			{
				$etapaSomete=$arrAcciones[$pos][1];
				if($permisos=="")
					$permisos="['S','".$arrAcciones[$pos][1]."']";
				else
					$permisos.=",['S','".$arrAcciones[$pos][1]."']";
			}	   
			$arrPermisosEtapa[removerCerosDerecha($filaEtapa[0])]="[".$permisos."]";
		}
//		varDump($arrPermisosEtapa);
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
					case 'date':
						$operando="";
						switch($arrFiltro[$x]["data"]["comparison"])
						{
							case "lt";
								$operando="<";
							break;	
							case "eq";
								$operando="=";
							break;	
							case "gt";
								$operando=">";
							break;	
						}
						$valor="'".cambiaraFechaMysql($arrFiltro[$x]["data"]["value"])."'";
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"].$operando.$valor;
					break;
				}
			}
		}
		$condWhere="";
		if($filtroUsuario!="")
			$condWhere=$filtroUsuario;
		$condFiltro="";
		$consulta="SELECT idGrupoAccion,complementario FROM 947_actoresProcesosEtapasVSAcciones WHERE idGrupoAccion=11 and  idActorProcesoEtapa=".$idActorProcesoEtapa;
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
			else
				$condFiltro=" and 1=2";
		}
		
		$consulta="SELECT idSolicitud,c.clave,CONCAT('[',c.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, org.unidad,montoTotal,c.modificable,
					(SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=c.numEtapa) as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,DATE_FORMAT(fechaSolicitud,'%d/%m/%Y') as fechaSolicitud,numEtapa
			   FROM 9112_solicitudesCompras c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto AND c.clave=o.clave AND 
			   ".$cadCapitulos." and p.idProducto=c.idProducto ".$condWhere." order by fechaSolicitud,nombreProducto limit ".$inicio.",".$cantidad;
		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(idSolicitud)
			   FROM 9112_solicitudesCompras c
			   WHERE idCiclo=".$idCiclo.$condFiltro."  AND 
			   ".$cadCapitulos." ".$condWhere;
		
			  
		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$conCantidades="SELECT mes,cantidad FROM 9113_cantidadSolicitudVSMes WHERE idSolicitud=".$fila[0]." order by mes";
			$filas=$con->obtenerFilas($conCantidades);
			$nFilas=$con->filasAfectadas;
			$cadenaMeses="";
			if($nFilas>0)
			{
				$cadenaAux="<table>";
				$fCabecera="<tr>";
				$fDatos="<tr>";
				
				while($fMeses=mysql_fetch_row($filas))
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
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","fechaSolicitud":"'.$fila[17].'","permisos":"'.$arrPermisosEtapa[$fila[18]].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		if($SO==2)
			$obj='{"numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$numRegistros.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function cargarProductoPantalla()
	{
		global $con;
		$idCodigoGastoCiclo=$_POST["idCodigoG"];
		$consulta="SELECT * FROM 9112_solicitudesCompras WHERE idSolicitud=".$idCodigoGastoCiclo;
		
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
			$conMeses="SELECT cantidad FROM 9113_cantidadSolicitudVSMes WHERE idSolicitud=".$idCodigoGastoCiclo." ORDER BY mes";
			$resMeses=$con->obtenerFilas($conMeses);
			$cadenaHijo="";
			while($filaMes=mysql_fetch_row($resMeses))
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
	
	function cambiarEtapaRegistros()
	{
		global $con;
		$etapa=$_POST["etapa"];
		$registros=$_POST["registros"];
		if($registros=="")
			$registros="-1";
		$consulta="update 9112_solicitudesCompras set numEtapa=".$etapa." where idSolicitud in (".$registros.")";
		eC($consulta);
	}
	
	function obtenerSumatoriaProductosValidos()
	{
		global $con;
		global $SO;
		$idCiclo=$_POST["idCiclo"];
		$codInst=$_POST["codigoInst"];
		$arrDatos="";
		$arreglo=array();
		$consulta="select idProducto from 527_concentradoProducto where ciclo=".$idCiclo." and tipoReferencia=0 and estado=0";
		$listProductos=$con->obtenerListaValores($consulta);
		if($listProductos=="")
			$listProductos="-1";
		$consulta="SELECT idCodigogastoCiclo,pa.idProducto,nombreProducto,cantidad,costoUnitario,montoTotal,'0' as tipoReferencia,'-1' as referencia FROM 525_productosAutorizados pa, 9101_CatalogoProducto p
				   WHERE p.idProducto=pa.idProducto AND idCiclo=".$idCiclo." and p.idProducto  in (".$listProductos.") ORDER BY pa.idProducto ";
		$res=$con->obtenerFilas($consulta);	
		
		while($fila=mysql_fetch_row($res))
		{
			if(!isset($arreglo[$fila[1]]))
				$arreglo[$fila[1]]["cantidad"]=$fila[3];
			else
				$arreglo[$fila[1]]["cantidad"]+=$fila[3];
				
			$consulta="SELECT mes,cantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fila[0]." ORDER BY mes";
			$res2=$con->obtenerFilas($consulta);
			while($mFila=mysql_fetch_row($res2))
			{
				$mesA=$mFila[0];
				if(!isset($arreglo[$fila[1]]["meses"]))
				{
					$arreglo[$fila[1]]["meses"]=array();
					$arreglo[$fila[1]]["meses"][$mesA]=$mFila[1];
				}
				else
				{
					if(isset($arreglo[$fila[1]]["meses"][$mesA]))
						$arreglo[$fila[1]]["meses"][$mesA]+=$mFila[1];
					else
						$arreglo[$fila[1]]["meses"][$mesA]=$mFila[1];
				}
			}
		
		}
		
		$nReg=sizeof($arreglo);
		foreach($arreglo as $idProducto=>$resto)
		{

			$consulta="SELECT nombreProducto,costoUnitario,CONCAT('[',objetoGasto,']',nombreObjetoGasto) AS nomObjeto,descripcion,'0' as tipoReferencia,'-1' as referencia  FROM 525_productosAutorizados pa, 9101_CatalogoProducto p, 507_objetosGasto o
						WHERE pa.idProducto=".$idProducto." AND pa.idProducto=p.idProducto AND o.clave=pa.clave";
			$fila=$con->obtenerPrimeraFila($consulta);
			
			$conTipoCompra="SELECT idTipoCompra FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$idCiclo;
			$idTipoCompra=$con->obtenerValor($conTipoCompra);
			
			$consultaConcentrado="SELECT idCompraVSProducto FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$idCiclo;
			$filaC=$con->obtenerValor($consultaConcentrado);
			if($filaC=="")
			{
				$existeL=0;
			}
			else
			{
				$consultaLicitacion="SELECT idProductoVSLicitacion FROM 529_licitaciones WHERE idCompraVSProducto=".$filaC;
				$existeTablaL=$con->obtenerValor($consultaLicitacion);
				if($existeTablaL=="")
				{
					$existeL=0;
				}
				else
				{
					$existeL=1;
				}
			}
			
			
			if($fila)
			{
				$nombre=$fila[0];
				$costoU=$fila[1];
				$objetoG=$fila[2];
				$descripcion=$fila[3];
			}
			else
			{
				$nombre="";
				$costoU=0;
				$objetoG="";
				$descripcion="";
			}
			
			$cadenaAux="<table>";
			$fCabecera="<tr>";
			$fDatos="<tr>";
			$arregloMeses="";
			$arrMeses=array();
			if(isset($resto["meses"]))
				$arrMeses=$resto["meses"];
				
			$tamanoA=sizeof($arrMeses);
			
			$cadenaMeses="";
			for($z=0;$z<$tamanoA;$z++)
			{
				$objAux=$z."_".$arrMeses[$z];
				
				if($cadenaMeses=="")
					$cadenaMeses=$objAux;
				else
					$cadenaMeses.=",".$objAux;
			
			}
			
			for($y=0;$y<11;$y++)
			{
				$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($y).'</span></td>';
				$mes=0;
				if(isset($resto["meses"][$y]))
					$mes=$resto["meses"][$y];
				$fDatos.='<td align="center">'.$mes .'</td>';
				
			}
			
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$arregloMeses=$cadenaAux;
			
			$total=$resto["cantidad"]*$costoU;
			
			$obj='{"referencia":"0","tipoReferencia":"0","idProducto":"'.$idProducto.'","nombre":"'.$nombre.'","cantidad":"'.$resto["cantidad"].'","costoU":"'.$costoU.'","total":"'.$total.'","meses":"'.cv($arregloMeses).'","objetoGasto":"'.$objetoG.'","descripcion":"'.$descripcion.'","arregloMeses":"'.$cadenaMeses.'","idTipoCompra":"'.$idTipoCompra.'","bandera":"'.$existeL.'"}';
				if($arrDatos=="")
					$arrDatos=$obj;
				else
					$arrDatos.=",".$obj;
			
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function guaradarConcentradoProductos()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$cantidad=$_POST["cantidad"];
		$idTipoCompra=$_POST["idTipoCompra"];
		$costoUnitario=$_POST["costoUnitario"];
		$total=$_POST["total"];
		$idCiclo=$_POST["idCiclo"];
		$cadena=$_POST["cadenaMeses"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		
		$conEsxiste="SELECT idCompraVSProducto FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$idCiclo;
		$existe=$con->obtenerValor($conEsxiste);
		
		if($existe=="")
		{
			$query1="INSERT INTO 527_concentradoProducto(idProducto,cantidad,costoUnitario,total,idTipocompra,estado,ciclo)
					VALUES(".$idProducto.",".$cantidad.",".$costoUnitario.",".$total.",".$idTipoCompra.",0,".$idCiclo.")";
		}
		else
		{
			$query1="UPDATE 527_concentradoProducto SET cantidad=".$cantidad.",total=".$total.",idTipoCompra=".$idTipoCompra." WHERE idCompraVSProducto=".$existe;
		}
		
		//echo $query1;
		if($con->ejecutarConsulta($query1))
		{
			if($existe=="")
			{
				$id=$con->obtenerUltimoID();
			}
			else
			{
				$id=$existe;
			}
			$consulta="begin";
			
			if($con->ejecutarconsulta($consulta))
			{
				$ct=0;
				for($x=0;$x<$tamano;$x++)
				{
					$elemento=explode("_",$arreglo[$x]);
					
					if($existe=="")
					{
						$query[$ct]="INSERT INTO 528_distribucionConcentrado(idCompraVSProducto,mes,cantidad) VALUES(".$id.",".$elemento[0].",".$elemento[1].")";
					}
					else
					{
						$query[$ct]="UPDATE 528_distribucionConcentrado SET cantidad=".$elemento[1]." WHERE idCompraVSProducto=".$id." AND mes=".$elemento[0];
					}
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
	}
	
	function obtenerComprasLicitacion()
	{
		global $con;
		global $SO;
		$idCiclo=$_POST["idCiclo"];
		$tCompra=$_POST["tCompra"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idProductoVSLicitacion,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as nombreProducto,
					cantidad,costoUnitario,	total,p.descripcion,c.idCompraVSProducto,pre.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen,
					noInternoLicitacion ,l.idMarca,p.clave_Art
					FROM 527_concentradoProductoTipoCompra c, 9101_CatalogoProducto p, 529_licitaciones l, 508_tiposPresupuesto pre,9030_categoriasObjetoGasto cat,9030_almacenes al
					WHERE c.idTipocompra=".$tCompra." AND  c.idProducto=p.idProducto AND c.idCompraVSProducto=l.idCompraVSProducto and pre.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen AND l.idFormulario=".$idFormulario." AND l.idReferencia=".$idRegistro;

		$res=$con->obtenerFilas($consulta);
		$nReg=$con->filasAfectadas;
		
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
		
			$consultaM="SELECT mes,cantidad FROM 528_distribucionConcentradoTipoCompra WHERE idCompraVSProducto=".$fila[6]." order by mes";
			$resM=$con->obtenerfilas($consultaM);
			
			$cadenaAux="<table>";
			$fCabecera="<tr>";
			$fDatos="<tr>";
			$cadenaMeses="";
			
			while($filaM=mysql_fetch_row($resM))
			{
				$fCabecera.="<td width='60' align='center'><span class='corpo8_bold'>".obtenerAbreviaturaMes($filaM[0])."</span></td>";
				$fDatos.="<td align='center'>".removerCerosDerecha($filaM[1])."</td>";
				
				if($cadenaMeses=="")
					$cadenaMeses=$filaM[0]."_".$filaM[1];
				else
					$cadenaMeses.=",".$filaM[0]."_".$filaM[1];
			
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera."<tr height='2'><td colspan='12' style='background:#600'></td></tr>".$fDatos;
			$cadenaAux.="</table>";
			
			$cadenaFinal=$cadenaAux;
			
			$obj='{"idProductoVSLicitacion":"'.$fila[0].'","nombre":"'.$fila[1].'","cantidad":"'.removerCerosDerecha($fila[2]).'","costoU":"'.$fila[3].'","total":"'.$fila[4].'","meses":"'.cv($cadenaFinal).'","descripcion":"'.$fila[5].'","arregloMeses":"'.$cadenaMeses.'","ciclo":"'.$idCiclo.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function obtenerProductosLicitacion()
	{
		global $con;
		global $SO;
		$idCiclo=$_POST["idCiclo"];
		$tCompra=$_POST["tCompra"];
		$arrDatos="";
		$arreglo=array();
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$consulta="SELECT * from (select idCompraVSProducto,c.idProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as nombreProducto,
					cantidad,costoUnitario,total,
					idTipoCompra,p.objetoGasto,p.descripcion,pre.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,
					concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen,p.clave_Art,c.catalogo
				   FROM 527_concentradoProductoTipoCompra c,508_tiposPresupuesto pre,9030_categoriasObjetoGasto cat,9030_almacenes al, 9101_CatalogoProducto p
                   WHERE p.idProducto=c.idProducto AND idTipoCompra=".$tCompra." AND  c.estado=0  
				   AND idCompraVSProducto NOT IN (SELECT idCompraVSProducto FROM 529_licitaciones) and pre.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen) as tmp where 1=1 and ".$condWhere." ORDER BY idProducto";

		$res=$con->obtenerFilas($consulta);
		$nReg=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
		{
			$consultaM="SELECT mes,cantidad FROM 528_distribucionConcentradoTipoCompra WHERE idCompraVSProducto=".$fila[0]." order by mes";

			$resM=$con->obtenerfilas($consultaM);
			
			$conObjeto="SELECT CONCAT('[',clave,']',nombreObjetoGasto) AS nomObjeto FROM 507_objetosGasto WHERE codigoControl='".$fila[7]."'";

			$nombreO=$con->obtenerValor($conObjeto);
			
			$cadenaAux="<table>";
			$fCabecera="<tr>";
			$fDatos="<tr>";
			$cadenaMeses="";
			
			$cadenaMeses="";
			while($filaM=mysql_fetch_row($resM))
			{
				$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($filaM[0]).'</span></td>';
				$fDatos.='<td align="center">'.removerCerosDerecha(number_format($filaM[1],2,'.',',')).'</td>';
				
				if($cadenaMeses=="")
					$cadenaMeses=$filaM[0]."_".$filaM[1];
				else
					$cadenaMeses.=",".$filaM[0]."_".$filaM[1];
			
			}
			
			
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
		
			$obj='{"idCompraVSProducto":"'.$fila[0].'","nombre":"'.$fila[2].'","cantidad":"'.removerCerosDerecha($fila[3]).'","costoU":"'.$fila[4].'","total":"'.$fila[5].'","meses":"'.cv($cadenaAux).'","objetoGasto":"'.$nombreO.'","descripcion":"'.$fila[8].'","arregloMeses":"'.$cadenaMeses.'"}';
				if($arrDatos=="")
					$arrDatos=$obj;
				else
					$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		echo $obj;
	}
	
	function guardarProductosLicitacion()
	{
		global $con;
		global $SO;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			$consulta="select max(noInternoLicitacion) from 529_licitaciones where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
			$nInterno=$con->obtenerValor($consulta);
			if($nInterno=="")
				$nInterno=1;
			for($x=0;$x<$tamano;$x++)
			{
				$elemento=$arreglo[$x];
				
				$conExiste="SELECT idProductoVSLicitacion FROM 529_licitaciones WHERE idCompraVSProducto=".$elemento;
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 529_licitaciones (idFormulario,idReferencia,idCompraVSProducto,noInternoLicitacion) VALUES(".$idFormulario.",".$idRegistro.",".$elemento.",".$nInterno.")";
					$ct++;
					$query[$ct]="UPDATE 527_concentradoProductoTipoCompra SET estado=1 WHERE idCompraVSProducto=".$elemento;
					
					$ct++;
					$nInterno++;
				}
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function eliminarProductosLicitacion()
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
				$consulta="SELECT idCompraVSProducto FROM 529_licitaciones WHERE idProductoVSLicitacion=".$arreglo[$x];
				$elemento=$con->obtenerValor($consulta);
				$query[$ct]="DELETE  FROM 529_licitaciones WHERE idProductoVSLicitacion=".$arreglo[$x];
				$ct++;
				$query[$ct]="UPDATE 527_concentradoProductoTipoCompra SET estado=0 WHERE idCompraVSProducto=".$elemento;
				$ct++;
			}
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo"|";
		}
		else
		{
			echo "|";
		}
	}
	
	function obtenerResultadosLicitacion()
	{
		global $con;
		global $SO;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$tipoCompra=$_POST["tipoCompra"];
		$consulta="SELECT idProductoVSLicitacion,CONCAT('[',objetoGasto,']',nombreProducto)AS nombreProducto,cantidad,costoUnitario,total,descripcion,c.idCompraVSProducto,c.idProducto FROM 527_concentradoProducto c, 9101_CatalogoProducto p, 529_licitaciones l
					WHERE c.idTipoCompra=".$tipoCompra." AND  c.idProducto=p.idProducto AND  c.idCompraVSProducto=l.idCompraVSProducto and l.idFormulario=".$idFormulario." and l.idReferencia=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		$nReg=$con->filasAfectadas;
		
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
		
			$consultaM="SELECT mes,cantidad FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$fila[6]." order by mes";
			$resM=$con->obtenerfilas($consultaM);
			
			$conProveedor="SELECT idProveedor,idPedido FROM 531_licitacionVSProveedorElegido WHERE idProducto=".$fila[7]." AND idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
			$idProveedor=$con->obtenerPrimeraFila($conProveedor);
			//echo $conProveedor;
			if($idProveedor)
			{
				$idProv=$idProveedor[0];
				$idPedido=$idProveedor[1];
			}
			else
			{
				$idPedido=0;
				$idProv="";
			}
			
			$cadenaAux="<table>";
			$fCabecera="<tr>";
			$fDatos="<tr>";
			$cadenaMeses="";
			
			while($filaM=mysql_fetch_row($resM))
			{
				$fCabecera.="<td width='60' align='center'><span class='corpo8_bold'>".obtenerAbreviaturaMes($filaM[0])."</span></td>";
				$fDatos.="<td align='center'>".$filaM[1]."</td>";
				
				if($cadenaMeses=="")
					$cadenaMeses=$filaM[0]."_".$filaM[1];
				else
					$cadenaMeses.=",".$filaM[0]."_".$filaM[1];
			
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera."<tr height='2'><td colspan='12' style='background:#600'></td></tr>".$fDatos;
			$cadenaAux.="</table>";
			
			$cadenaFinal=$cadenaAux;
			
			$obj='{"idProductoVSLicitacion":"'.$fila[0].'","nombre":"'.$fila[1].'","cantidad":"'.$fila[2].'","costoU":"'.$fila[3].'","total":"'.$fila[4].'","meses":"'.cv($cadenaFinal).'","descripcion":"'.$fila[5].'","arregloMeses":"'.$cadenaMeses.'","ciclo":"","idProveedor":"'.$idProv.'","idPedido":"'.$idPedido.'","idProducto":"'.$fila[7].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function guardarProveedorElegidoLicitacion()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idProveedor=$_POST["idProveedor"];
		$idProducto=$_POST["idProducto"];
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$obj=$_POST["obj"];
		$conExiste="SELECT idLicitacionVSProductoAceptado FROM 531_licitacionVSProveedorElegido WHERE idProducto=".$idProducto." AND idReferencia=".$idRegistro." and idFormulario=".$idFormulario;
		$existe=$con->obtenerValor($conExiste);
		if($existe=="")
		{
			$query="INSERT INTO 531_licitacionVSProveedorElegido(idProveedor,idProducto,idFormulario,idReferencia,detalles) VALUES(".$idProveedor.",".$idProducto.",".$idFormulario.",".$idRegistro.",'".cv($obj)."')";
		}
		else
		{
			$query="UPDATE 531_licitacionVSProveedorElegido SET idProveedor=".$idProveedor.",detalles='".cv($obj)."' WHERE idLicitacionVSProductoAceptado=".$existe;
		}
		if($con->ejecutarconsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	
	function inscribirProveedorAConvocatoria()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="insert into 530_licitacionVSProveedor(idFormulario,idReferencia,idProveedor) values(".$idFormulario.",".$idRegistro.",".$idProveedor.")";
		eC($consulta);
	}
	
	function removerProveedorPartida()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idProveedor=$_POST["idProveedor"];
		$idProducto=$_POST["idProducto"];
		$consulta="delete from 531_licitacionVSProveedorElegido where idProducto=".$idProducto." and idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idProveedor=".$idProveedor;	
		eC($consulta);
	}
	
	function cerrarLicitacion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro	=$_POST["idRegistro"];
		$listProductosRemover=$_POST["listProductosRemover"];
		$listProductosContratos=$_POST["listProductosContratos"];
		if($listProductosContratos=="")
			$listProductosContratos="-1";
		if($listProductosRemover=="")
			$listProductosRemover="-1";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 529_licitacionesCerradas(idFormulario,idRegistro,responsableCierre,fechaCierre) values(".$idFormulario.",".$idRegistro.",".$_SESSION["idUsr"].",'".date("Y-m-d")."')";
		$x++;
		$consulta[$x]="update 531_licitacionVSProveedorElegido set estado=1 where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." 
						and idProducto in(".$listProductosContratos.")";
		$x++;
		$query="select * from 531_licitacionVSProveedorElegido where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$resContratos=$con->obtenerFilas($query);	
		while($filaCon=mysql_fetch_row($resContratos))					
		{
			$obj=json_decode($filaCon[8]);						
			if(isset($obj->tipoContrato))
			{
				$consulta[$x]="INSERT INTO 9101_pedidosEsperaContrato(fechaRegistro,responsablePedido,situacion,idFormulario,idRegistro,idConcentradoProducto,tipoContrato,porcentajeMinimo,idMarca,modelo,presentacion,
								unidadMedida,contenedor,cantidad,costoUnitario,iva,subtotal,total,idProveedor) 
								VALUES('".date("Y-m-d")."',".$_SESSION["idUsr"].",0,".$idFormulario.",".$idRegistro.",".$filaCon[2].",".$obj->tipoContrato.",".$obj->porcentajeMinimo.",".$obj->idMarca.",'".cv($obj->modelo)."',".$obj->presentacion.",
								".$obj->UnidadMedida.",".$obj->contenedor.",".$obj->cantidad.",".$obj->costoUnitario.",".$obj->iva.",".$obj->subtotal.",".$obj->total.",".$filaCon[1].")";
				//echo $consulta[$x];
				$x++;
				/*foreach($obj->entregablesPHP  as $e)
				{
					$query="SELECT idProducto,objetoGasto FROM 527_concentradoProducto WHERE idCompraVSProducto=".$filaCon[2];
					$filaP=$con->obtenerPrimeraFila($query);
					$consulta[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,mes,idConcentradoProducto,idProducto)
									 VALUES(".$filaCon[1].",'".date("Y-m-d")."','".$e->fechaEntrega."',1,'',".date("m",strtotime($e->fechaEntrega)).",".$filaCon[2].",".$filaP[0].")";
					$x++;
					$consulta[$x]="set @idPedido=(select last_insert_id())";
					$x++;
					$iva=0;
					if($obj->iva!=0)
					{
						$iva=($obj->costoUnitario*$e->entregable)*($porcIva/100);
					}
					$consulta[$x]=" INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,modelo,cantidad,costoUnitario,iva,statusPedido,idContenedor,idUnidadMedida,idPresentacion,fechaPedido,partida) 
									VALUES(@idPedido,'".$filaP[0]."',".$obj->idMarca.",'".$obj->modelo."',".$e->entregable.",".$obj->costoUnitario.",".$iva.",1,".$obj->contenedor.",".$obj->UnidadMedida.",".
									$obj->presentacion.",'".$e->fechaEntrega."','".$filaP[1]."')";
					$x++;
					$consulta[$x]="update 9102_PedidoCabecera set folioPedido=idPedido where idPedido=@idPedido";
					$x++;
					
				}*/
			}
			else
			{
					if(!guardarDatosContrato($idProveedor,$filaCon[2],$obj))
					{
						return;
					}
			}
		}
		
		
		$query="select idProducto from 531_licitacionVSProveedorElegido where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
		$listProductosContratos=$con->obtenerListaValores($query);	
		if($listProductosContratos=="")	
			$listProductosContratos="-1";
		
		$query="SELECT idCompraVSProducto FROM 529_licitaciones  where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idCompraVSProducto not in (".$listProductosContratos.")";
		$listProductosRemover=$con->obtenerListaValores($query);	
		if($listProductosRemover=="")	
			$listProductosRemover="-1";
		$consulta[$x]="UPDATE 527_concentradoProductoTipoCompra SET estado=2 WHERE idCompraVSProducto in (".$listProductosContratos.")";
		$x++;
		$consulta[$x]="UPDATE 527_concentradoProductoTipoCompra SET estado=0 WHERE idCompraVSProducto in (".$listProductosRemover.")";
		$x++;
		$consulta[$x]="INSERT INTO 529_partidasDesiertasLicitaciones(idFormulario,idReferencia,idCompraVSProducto,noInternoLicitacion,idMarca) 
						select idFormulario,idReferencia,idCompraVSProducto,noInternoLicitacion,idMarca from  529_licitaciones where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idCompraVSProducto in(".$listProductosRemover.")";
		$x++;
		$consulta[$x]="delete from  529_licitaciones where idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idCompraVSProducto in(".$listProductosRemover.")";
		$x++;						
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="SELECT idProceso FROM 900_formularios WHERE idFormulario=".$idFormulario;
			$idProceso=$con->obtenerValor($query);
			$query="SELECT configuracion FROM 203_configuracionModuloDTD WHERE idModulo=16 AND idProceso=".$idProceso;
			$conf=$con->obtenerValor($query);
			if($conf!="")
			{
				$objConf=json_decode($conf);	
				if($objConf->etapaCierre!="")
				{
					if(cambiarEtapaFormulario($idFormulario,$idRegistro,$objConf->etapaCierre))
						echo "1|";
				}
				else
					echo "1|";
			}
		}
	}
	
	function obtenerPartidasDisponibles()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idPartida FROM 532_partidasPedido WHERE situacion=1 AND idProveedor=".$idProveedor;	
		$listaVal=$con->obtenerListaValores($consulta);
		if($listaVal=="")
			$listaVal="-1";
		$consulta="select * from 531_licitacionVSProveedorElegido where idLicitacionVSProductoAceptado in (".$listaVal.")";
		$resFilas=$con->obtenerFilas($consulta);
		$arrPartidas="";
		while($fila=mysql_fetch_row($resFilas))
		{
			$idProducto=$fila[2];
			$detalles=json_decode($fila[8]);
			$descripcion=$detalles->descripcion;
			$consulta="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
			$nProducto=$con->obtenerValor($consulta);
			$consulta="SELECT descripcion FROM _406_tablaDinamica WHERE id__406_tablaDinamica=".$detalles->marca;
			$marca=$con->obtenerValor($consulta);
			$consulta="SELECT cantidad,idCompraVSProducto FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$ciclo;
			$fConcentrado=$con->ObtenerPrimeraFila($consulta);
			$cantidad=$fConcentrado[0];
			$idCompraProducto=$fConcentrado[1];
			$consulta="SELECT mes,cantidad FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$idCompraProducto;
			$resCompra=$con->obtenerFilas($consulta);
			$cadenaAux="<table>";
			$fCabecera="<tr>";
			$fDatos="<tr>";
			$cadenaMeses="";
			while($filaM=mysql_fetch_row($resCompra))
			{
				$fCabecera.='<td width="60" align="center"><span class="corpo8_bold">'.obtenerAbreviaturaMes($filaM[0]).'</span></td>';
				$fDatos.='<td align="center">'.number_format($filaM[1],2,'.',',').'</td>';
				
				if($cadenaMeses=="")
					$cadenaMeses=$filaM[0]."_".$filaM[1];
				else
					$cadenaMeses.=",".$filaM[0]."_".$filaM[1];
			}
			$fCabecera.="</tr>";
			$fDatos.="</tr>";
			$cadenaAux.=$fCabecera.'<tr height="2"><td colspan="12" style="background:#600"></td></tr>'.$fDatos;
			$cadenaAux.="</table>";
			
			$obj="['".$fila[0]."','".$nProducto."','".$marca."','".$cantidad."','".$detalles->costo."','".cv($cadenaAux)."','".cv($descripcion)."']";
			if($arrPartidas=="")
				$arrPartidas=$obj;
			else
				$arrPartidas.=",".$obj;
			
		}
		echo "1|[".$arrPartidas."]";
	}
	
	function registrarPedidos()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);	
		$listPartidas=$obj->listPartidas;
		$arrPartidas=explode(",",$listPartidas);
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idProducto,detalles FROM 531_licitacionVSProveedorElegido WHERE idLicitacionVSProductoAceptado IN (".$listPartidas.")";
		$tipoEntrega=$obj->tEntrega;
		$dEntrega=$obj->diaEntrega;
		$fEntrega=$obj->fEntrega;
		$diasAntes=$obj->diasAntes;
		$diasDespues=$obj->diasDespues;
		$sancion=$obj->sancion;
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="select max(folioPedido) from 9102_PedidoCabecera";
		
		$folio=$con->obtenerValor($consulta)+1;
		if($tipoEntrega==2)
		{
			$query[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,idAlmacen)
						VALUES(".$obj->idProveedor.",'".date("Y-m-d")."','".$fEntrega."',1,'".$folio."',22)";
			$x++;
			$query[$x]="set @idRegistro=(select LAST_INSERT_ID())";
			$x++;
			foreach($arrPartidas as $p)
			{
				$consulta="select * from 531_licitacionVSProveedorElegido WHERE idLicitacionVSProductoAceptado=".$p;
				$fPartida=$con->obtenerPrimeraFila($consulta);
				$idProducto=$fPartida[2];
				$conf=json_decode($fPartida[8]);
				$consulta="SELECT cantidad FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$ciclo;
				$cantidad=$con->obtenerValor($consulta);
				$consulta="SELECT contenedor,uni_medida,presentacion,objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
				$fProducto=$con->obtenerPrimeraFila($consulta);
				$query[$x]="INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,cantidad,costoUnitario,statusPedido,idContenedor,
							idUnidadMedida,idPresentacion,fechaPedido,partida) VALUES(@idRegistro,".$idProducto.",".$conf->marca.",".$cantidad.",".$conf->costo.",0,
							".$fProducto[0].",".$fProducto[1].",".$fProducto[2].",'".date('Y-m-d')."',".$fProducto[3].")";
				$x++;						
			}
		}
		else
		{
			for($nMes=1;$nMes<=12;$nMes++)
			{
				$consulta="select max(folioPedido) from 9102_PedidoCabecera";
				$folio=$con->obtenerValor($consulta)+$nMes;
				$query[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,idAlmacen)
						VALUES(".$obj->idProveedor.",'".(date("Y")."-".$nMes."-".$dEntrega)."','".$fEntrega."',1,'".$folio."',22)";
				$x++;
				$query[$x]="set @idRegistro=(select LAST_INSERT_ID())";
				$x++;
				foreach($arrPartidas as $p)
				{
					$consulta="select * from 531_licitacionVSProveedorElegido WHERE idLicitacionVSProductoAceptado=".$p;
					$fPartida=$con->obtenerPrimeraFila($consulta);
					$idProducto=$fPartida[2];
					$conf=json_decode($fPartida[8]);
					$consulta="SELECT idCompraVSProducto FROM 527_concentradoProducto WHERE idProducto=".$idProducto." AND ciclo=".$ciclo;
					$idCompraVSProducto=$con->obtenerValor($consulta);
					$consulta="SELECT cantidad FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$idCompraVSProducto." AND mes=".($nMes-1);
					$cantidad=$con->obtenerValor($consulta);
					if($cantidad>0)
					{
						$consulta="SELECT contenedor,uni_medida,presentacion,objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
						$fProducto=$con->obtenerPrimeraFila($consulta);
						$query[$x]="INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,cantidad,costoUnitario,statusPedido,idContenedor,
							idUnidadMedida,idPresentacion,fechaPedido,partida) VALUES(@idRegistro,".$idProducto.",".$conf->marca.",".$cantidad.",".$conf->costo.",0,
							".$fProducto[0].",".$fProducto[1].",".$fProducto[2].",'".(date("Y")."-".$nMes."-".$dEntrega)."',".$fProducto[3].")";
						$x++;	
						$query[$x]="set @idRegistroDetalle=(select LAST_INSERT_ID())";
						$x++;
						$consulta="SELECT codDepto,idPrograma,clave,cantidad FROM 525_productosAutorizados WHERE idProducto=".$idProducto." AND ciclo=".$ciclo;
						$rDistribucionDetalle=$con->obtenerFilas($consulta);
						while($fila=mysql_fetch_row($rDistribucionDetalle))
						{
							$query[$x]="INSERT INTO 9301_distribucionProducto(idPedidoDetalle,codigoUnidad,idPrograma,partida,cantidad)
										VALUES(@idRegistroDetalle,'".$fila[0]."',".$fila[1].",".$fila[2].",".$fila[3].")";
							$x++;	
						}
						
						$consulta="SELECT idCodigoGastoCiclo,codDepto,idPrograma,tipoPresupuesto,clave FROM 525_productosAutorizados WHERE idProducto=".$idProducto." AND idCiclo=".$ciclo;
						$resDistribucion=$con->obtenerFilas($consulta);
						while($fDistribucion=mysql_fetch_row($resDistribucion))
						{
							$consulta="SELECT mes,cantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fDistribucion[0];
							$resDistri=$con->obtenerFilas($consulta);
							while($fDist=mysql_fetch_row($resDistri))
							{
								$nMesAsiento=$fDist[0];
								$monto=$fDist[1]*$conf->costo;
								$consulta="SELECT codigoControlPadre FROM 507_objetosGasto WHERE clave=".$fDistribucion[4];
								$cPadre=$con->obtenerValor($consulta);
								$consulta="select clave from 507_objetosGasto where codigoControl='".$cPadre."'";
								$capitulo=$con->obtenerValor($consulta);
								$query[$x]="INSERT INTO 528_asientosCuentasPresupuestales(ciclo,programa,departamento,capitulo,partida,mes,monto,fechaOperacion,responsableOperacion,
										tiempoPresupuestal,operacion,idReferencia,idProceso) 
										VALUES(".$ciclo.",".$fDistribucion[2].",'".$fDistribucion[1]."',".$capitulo.",".$fDistribucion[4].",".$nMesAsiento.",".$monto.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",1,-1,0,0)";
								$x++;
								$query[$x]="INSERT INTO 528_asientosCuentasPresupuestales(ciclo,programa,departamento,capitulo,partida,mes,monto,fechaOperacion,responsableOperacion,
										tiempoPresupuestal,operacion,idReferencia,idProceso) 
										VALUES(".$ciclo.",".$fDistribucion[2].",'".$fDistribucion[1]."',".$capitulo.",".$fDistribucion[4].",".$nMesAsiento.",".$monto.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",2,1,0,0)";
								$x++;
								
							}
						}
					}
					
				}
			}
			
		}
		$query[$x]="UPDATE 532_partidasPedido SET situacion=0 WHERE idpartida IN (".$listPartidas.")";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
	}

	function obtenerProductosEsperaCompra()
	{
		global $con;
		global $arrMeses;
		$start=$_POST["start"];
		$limit=$_POST["limit"];

		$ciclo=$_POST["ciclo"];
		$capitulo=$_POST["capitulo"];
		$consulta2="";
		$consulta="";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
			
			$consulta="select * from (SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
					cantidad,costoUnitario,total,tipoProducto,idProducto,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen 	
					FROM 527_concentradoProducto c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al  WHERE ciclo=".$ciclo."  AND 
					(c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') and (idTipoCompra is null ) AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen) as tmp where 1=1   and ".$condWhere." LIMIT ".$start.",".$limit;
			
			$consulta2="select * from (SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
					cantidad,costoUnitario,total,tipoProducto,idProducto,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen 	
					FROM 527_concentradoProducto c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al  WHERE ciclo=".$ciclo."  AND 
					(c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') and (idTipoCompra is null ) AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen) as tmp where 1=1   and ".$condWhere;				
			
		}
		else
		{
			$consulta="SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),
					(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
					cantidad,costoUnitario,total,tipoProducto,idProducto,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,
					concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen
					FROM 527_concentradoProducto c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al 
					WHERE ciclo=".$ciclo."  AND 
					(c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') and (idTipoCompra is null ) AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen LIMIT ".$start.",".$limit;

			$consulta2="SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),
					(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
					cantidad,costoUnitario,total,tipoProducto,idProducto,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,
					concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen
					FROM 527_concentradoProducto c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al 
					WHERE ciclo=".$ciclo."  AND 
					(c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') and (idTipoCompra is null ) AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen";		
		}
		
		$res=$con->obtenerFilas($consulta);
		
		$arrProductos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT SUM(cantidad) FROM 527_concentradoProductoTipoCompra WHERE idConcentradoProducto=".$fila[0];
			$nClasificados=$con->obtenerValor($consulta);
			if($nClasificados=="")
				$nClasificados=0;
			
			$cantidad=$fila[2]-$nClasificados;
			if($cantidad<=0)
				continue;
			$costoUnitario=$fila[3];
			$montoTotal=$fila[4];
			$nProducto=$fila[1];
			$campo="";
			switch($fila[5])
			{
				case 1:
					$campo="format(cantidad,0)";
				break;
				case 2:
					$campo="format(monto,2)";
				break;
			}
			$cadenaAux="<table><tr>";
			for($y=0;$y<11;$y++)
			{
				$cadenaAux.="<td width='60' align='center'><span class='corpo8_bold'>".obtenerAbreviaturaMes($y)."</span></td>";
			}
			$cadenaAux.="</tr><tr height='1'><td colspan='12' style='background-color:#900'></td></tr><tr>";
			$y=0;
			$consulta="SELECT  ".$campo." FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$fila[0]." AND mes=".$y;
			
			$cadenaAux.="</tr></table>";
			$obj='{"idProductoConcentrado":"'.$fila[0].'","idProducto":"'.$fila[6].'","tipoProducto":"'.$fila[5].'","producto":"'.cv($nProducto).'","cantidad":"'.$cantidad.'",
					"costoUnitario":"'.$costoUnitario.'","montoTotal":"'.$montoTotal.'","tabla":"","categoria":"'.$fila[8].'","fuenteFinanciamiento":"'.$fila[7].'","almacen":"'.$fila[9].'"}';
			if($arrProductos=="")
				$arrProductos=$obj;
			else
				$arrProductos.=",".$obj;
		}
		
		$con->obtenerFilas($consulta2);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrProductos.']}';
	}
	
	
	function obtenerProductosCompras()
	{
		global $con;
		global $arrMeses;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$ciclo=$_POST["ciclo"];
		$tCompra=$_POST["tCompra"];
		$capitulo=$_POST["capitulo"];
		$consulta2="";
		$consulta="";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
			
			$consulta="select * from (SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
						cantidad,costoUnitario,total,tipoProducto,idTipoCompra,c.estado,c.objetoGasto,c.solicitudesComprende,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,
						concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen, c.catalogo,
					(if(tipoProducto=1,(SELECT clave_Art FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),'')) as cve_Art 
						FROM 527_concentradoProductoTipoCompra c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al WHERE ciclo=".$ciclo." and (c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') 
						AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' 
						and p.idTipoPresupuesto=c.fuenteFinanciamiento 	and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen
					) as tmp where idTipoCompra=".$tCompra." and ".$condWhere." order by producto LIMIT ".$start.",".$limit;
			
			$consulta2="select * from (SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
						cantidad,costoUnitario,total,tipoProducto,idTipoCompra,p.tituloTipoP as fuenteFinanciamiento,
						concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen ,c.catalogo,
					(if(tipoProducto=1,(SELECT clave_Art FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),'')) as cve_Art 
						FROM 527_concentradoProductoTipoCompra c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al WHERE 
						ciclo=".$ciclo." and (c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen )  as tmp where idTipoCompra=".$tCompra." and ".$condWhere;				
			
		}
		else
		{
			$consulta="SELECT idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null
					,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,cantidad,costoUnitario,total,tipoProducto,idProducto ,c.estado,c.objetoGasto,c.solicitudesComprende
					,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) 
					as almacen ,c.catalogo,	(if(tipoProducto=1,(SELECT clave_Art FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),'')) as cve_Art
					FROM 527_concentradoProductoTipoCompra c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al WHERE ciclo=".$ciclo." and (c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') AND 
					c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND idTipoCompra=".$tCompra." and p.idTipoPresupuesto=c.fuenteFinanciamiento and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen order by producto LIMIT ".$start.",".$limit;
			
			$consulta2="select idCompraVSProducto,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null
					,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,cantidad,costoUnitario,total,tipoProducto,idProducto ,c.estado,c.objetoGasto,c.solicitudesComprende
					,p.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) 
					as almacen ,c.catalogo,	(if(tipoProducto=1,(SELECT clave_Art FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),'')) as cve_Art
					from 527_concentradoProductoTipoCompra c,508_tiposPresupuesto p,9030_categoriasObjetoGasto cat,9030_almacenes al WHERE ciclo=".$ciclo." 
					and (c.objetoGasto='".$capitulo."' OR c.objetoGasto LIKE '".$capitulo."%') AND c.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND idTipoCompra=".$tCompra."  and p.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen";		
					
					
		}

		$res=$con->obtenerFilas($consulta);
		$arrProductos="";
		while($fila=mysql_fetch_row($res))
		{
			$cantidad=$fila[2];
			$costoUnitario=$fila[3];
			$montoTotal=$fila[4];
			$nProducto=$fila[1];
			$situacion=$fila[7];
			$campo="";
			switch($fila[5])
			{
				case 1:
					$campo="format(cantidad,0)";
				break;
				case 2:
					$campo="format(monto,2)";
				break;
			}
			
			$tipoContrato=0;
			$porcentajeMinimo=0;
			if($fila[9]=="")
				$fila[9]="-1";
			$consulta="select tipoContrato,porcentajeMinimo from 525_productosAutorizados where idCodigoGastoCiclo in (".$fila[9].") and tipoContrato=1 order by  porcentajeMinimo asc";
			$filaContrato=$con->obtenerPrimeraFila($consulta);
			if($filaContrato)
			{
				$tipoContrato=$filaContrato[0];
				$porcentajeMinimo=$filaContrato[1];
			}
			$consulta="SELECT gravable FROM 507_objetosGasto WHERE codigoControl='".$fila[8]."'";
			$gravable=$con->obtenerValor($consulta);
			if($gravable=="")
				$gravable="0";
			
			$obj='{"catalogo":"'.$fila[13].'","cve_Art":"'.$fila[14].'","gravable":"'.$gravable.'","tipoContrato":"'.$tipoContrato.'","porcentajeMinimo":"'.$porcentajeMinimo.'","idProductoConcentrado":"'.$fila[0].'","situacion":"'.$situacion.'","idProducto":"'.$fila[0].
				'","tipoProducto":"'.$fila[5].'","producto":"'.cv($nProducto).'","cantidad":"'.$cantidad.'","costoUnitario":"'.$costoUnitario.'","montoTotal":"'.$montoTotal.'","tabla":"","categoria":"'.$fila[11].
				'","fuenteFinanciamiento":"'.$fila[10].'","almacen":"'.$fila[12].'"}';
			if($arrProductos=="")
				$arrProductos=$obj;
			else
				$arrProductos.=",".$obj;
		}
		
		$con->obtenerFilas($consulta2);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrProductos.']}';
	}
	
	function obtenerDepartamentosSolicitudesProductos()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$tipoProducto=$_POST["tipoProducto"];
		$ciclo=$_POST["ciclo"];
		$condWhere="";
		$arrRutas=obtenerCodigosRutas($ciclo);
		$consulta="select solicitudesComprende from 527_concentradoProducto where idCompraVSProducto=".$idProducto;
		
		$listSolicitudes=$con->obtenerListaValores($consulta);
		if($listSolicitudes=="")
			$listSolicitudes=-1;
		$consulta="SELECT mes FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$idProducto;
		$listMeses=$con->obtenerListaValores($consulta);
		$condWhere=" and idCodigoGastoCiclo in(".$listSolicitudes.")";
		$consulta="SELECT idCodigoGastoCiclo,ruta,CONCAT(cvePrograma,'] ',tituloPrograma),CONCAT('[',codigoDepto,'] ',unidad),if(s.idCabecera is null,format(cantidad,0),concat('$ ',format(montoTotal,2))),idCabecera FROM 525_productosAutorizados s,817_organigrama o,517_programas p WHERE o.codigoUnidad=s.codDepto AND p.idPrograma=s.idPrograma".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$nFilas=0;
		while($fila=mysql_fetch_row($res))
		{
			$cadenaAux="<table><tr>";
			for($y=0;$y<11;$y++)
			{
				$cadenaAux.="<td width='60' align='center'><span class='corpo8_bold'>".obtenerAbreviaturaMes($y)."</span></td>";
			}
			$cadenaAux.="</tr><tr height='1'><td colspan='12' style='background-color:#900'></td></tr><tr>";
			$cantidad=0;
			for($y=0;$y<11;$y++)
			{
				if($fila[5]=='')
					$consulta="SELECT  format(cantidad,0),cantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fila[0]." AND mes=".$y." and  mes in (".$listMeses.")";
				else
					$consulta="SELECT  concat('$ ',format(monto,2)),monto FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fila[0]." AND mes=".$y." AND mes in (".$listMeses.")";
				$fCantidad=$con->obtenerPrimeraFila($consulta);
				$cantidadAux=$fCantidad[0];
				$cantidad+=$fCantidad[1];
				if($cantidadAux=="")
					$cantidadAux=0;
				$cadenaAux.="<td align='center'><span class='letraExt'>".($cantidadAux)."</span></td>";
			}
			
			$cadenaAux.="</tr></table>";
			if($cantidad<>0)
			{
				$obj='{"programa":"['.cv($arrRutas[$fila[1]])." ".cv($fila[2]).'","departamento":"'.cv($fila[3]).'","cantidad":"'.$cantidad.'","tabla":"'.$cadenaAux.'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nFilas++;
			}
		}
		echo '{"numReg":"'.$nFilas.'","registros":['.$arrRegistros.']}';
		
	}
	
	function asignarTipoCompra()
	{
		global $con;
		$listProducto=$_POST["listProducto"];
		/*$tCompra=$_POST["tCompra"];
		
		$consulta="update 527_concentradoProducto SET idTipoCompra=".$tCompra." WHERE idCompraVSProducto IN (".$listProducto.")";
		eC($consulta);*/
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 527_concentradoProductoTipoCompra where idCompraVSProducto IN (".$listProducto.")";
		$x++;
		$consulta[$x]="delete from 528_distribucionConcentradoTipoCompra where idCompraVSProducto IN (".$listProducto.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function guardarCompraDirecta()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$porcIva=16;
		$idProveedor=$_POST["idProveedor"];
		$listProductosContratos=$_POST["idProducto"];
		if($listProductosContratos=="")
			$listProductosContratos="-1";
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
								
		if(isset($obj->tipoContrato))
		{
			foreach($obj->entregablesPHP  as $e)
			{
				$query="SELECT idProducto,objetoGasto FROM 527_concentradoProducto WHERE idCompraVSProducto=".$listProductosContratos;
				
				$filaP=$con->obtenerPrimeraFila($query);
				$consulta[$x]="INSERT INTO 9102_PedidoCabecera(idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,mes,idConcentradoProducto,idProducto)
								 VALUES(".$idProveedor.",'".date("Y-m-d")."','".$e->fechaEntrega."',1,'',".date("m",strtotime($e->fechaEntrega)).",".$listProductosContratos.",".$filaP[0].")";
				$x++;
				$consulta[$x]="set @idPedido=(select last_insert_id())";
				$x++;
				$iva=0;
				if($obj->iva!=0)
				{
					$iva=($obj->costoUnitario*$e->entregable)*($porcIva/100);
				}
				$consulta[$x]=" INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,modelo,cantidad,costoUnitario,iva,statusPedido,idContenedor,idUnidadMedida,idPresentacion,fechaPedido,partida) 
								VALUES(@idPedido,'".$filaP[0]."',".$obj->idMarca.",'".$obj->modelo."',".$e->entregable.",".$obj->costoUnitario.",".$iva.",1,".$obj->contenedor.",".$obj->UnidadMedida.",".
								$obj->presentacion.",'".$e->fechaEntrega."','".$filaP[1]."')";
				$x++;
				$consulta[$x]="update 9102_PedidoCabecera set folioPedido=idPedido where idPedido=@idPedido";
				$x++;
				
			}
		}
		else
		{
			if(!guardarDatosContrato($idProveedor,$listProductosContratos,$obj))
				return;
		}
		
		$consulta[$x]="UPDATE 527_concentradoProducto SET estado=2 WHERE idCompraVSProducto in (".$listProductosContratos.")";
		$x++;
							
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
		
	}
	
	
	function guardarDatosContrato($idProveedor,$idProductoAutorizado,$obj)
	{
		global $con;
		$iva=0.16;

		$query="SELECT * FROM 527_concentradoProducto WHERE idCompraVSProducto=".$idProductoAutorizado;
		$fila=$con->obtenerPrimeraFila($query);
		$query="SELECT * FROM 525_productosAutorizados WHERE idCodigoGastoCiclo IN (".$fila[16].")";
		$filaProd=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$importeMaximo=$obj->monto->montoContrato;
		$importeMinimo=0;
		$montoContrato=$obj->monto->montoContrato;
		if($obj->monto->tipoContrato==1)
		{
			$importeMinimo=$importeMaximo-($importeMaximo*($obj->monto->porcentajeMinimo/100));
			$montoContrato=($importeMaximo+$importeMinimo)/2;
		}
		$query="SELECT gravable FROM 507_objetosGasto WHERE codigoControl='".$fila[15]."'";
		$gravable=$con->obtenerValor($query);
		$subtotal=$montoContrato;
		$iva=0;
		if($gravable==1)
			$iva=$montoContrato*$iva;
		
		$total=$subtotal+$iva;
		$deptoResp="";
		foreach($obj->especificacion->participantes as $p)
		{
			if($p->idParticipacion==90)
			{
				$query="select codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$p->idUsuario;
				$deptoResp=$con->obtenerValor($query);
				break;
			}
		}
		$arrMonto=explode(",",$obj->monto->distribucion);
		$consulta[$x]=" INSERT INTO 9138_contratos(numContrato,idProveedor,fechaInicio,fechaFin,condPago,objetoGasto,concepto,fuenteFinanciamiento,
							tipoContrato,importeMaximo,importeMinimo,subtotal,iva,total,departamento,ruta,idPrograma,situacion,justificacion,observaciones,objetivo,porcentajeMinimo,
							periodicidadPago,incluyeParticipacion,noParticipantes,idProductoAutorizado)
							VALUES('".cv($obj->especificacion->noContrato)."',".$idProveedor.",'".$obj->entregables->fechaInicio."','".$obj->entregables->fechaFin."',".$obj->monto->condicionesPago.",'".$fila[15]."','".cv($obj->especificacion->descripcion)
							."',".$filaProd[19].",".$obj->monto->tipoContrato.",".$importeMaximo.",".$importeMinimo.",".$subtotal.",".($iva).",".$total.",'".$deptoResp."','".$filaProd[22]."',".$filaProd[11].",1,
							'".cv($obj->justificacion->justificacion)."','".cv($obj->justificacion->observaciones)."','".cv($obj->especificacion->objetivo)."',".$obj->monto->porcentajeMinimo.",".$obj->entregables->periodicidadPago.
							",".$obj->especificacion->incluyeParticipacion.",".$obj->especificacion->noParticipantes.",".$idProductoAutorizado.")";
		$x++;
		
		$consulta[$x]="set @idContrato=(select last_insert_id())";
		$x++;
		foreach($obj->especificacion->participantes as $p)
		{
			$consulta[$x]="INSERT INTO 9138_responsablesContrato(idUsuario,idParticipacion,idContrato) VALUES(".$p->idUsuario.",".$p->idParticipacion.",@idContrato)";
			$x++;
		}
		foreach($obj->entregables->arrEntregables as $e)
		{
			$consulta[$x]="INSERT INTO 9138_entregablesContrato(entregable,fechaEntrega,idContrato) VALUES('".cv($e->entregable)."','".$e->fechaEntrega."',@idContrato)";
			$x++;
			
		}
		$ct=0;
		$anio=date("Y",strtotime($obj->entregables->fechaInicio));
		foreach($arrMonto as $monto)
		{
			$consulta[$x]="INSERT INTO 9139_detalleContrato(idContrato,mes,anio,monto) VALUES(@idContrato,".$ct.",".$anio.",".$monto.");";
			$x++;
			$ct++;
		}
		$consulta[$x]="commit";
		$x++;
		return $con->ejecutarBloque($consulta);
	}
	
	function obtenerProveedoresEsperaPedido()
	{
		global $con;
		
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$comp="";
		
		
		$consulta="SELECT DISTINCT idProveedor FROM 9101_pedidosEsperaContrato WHERE situacion=0";
		
		$listProveedoresActivos=$con->obtenerListaValores($consulta);
		if($listProveedoresActivos=="")
			$listProveedoresActivos=-1;
		$consulta="SELECT id__405_tablaDinamica as idProveedor,txtRFC,txtRazonSocial2,txtTelefono1,txtTelefono2,txtFax,txtCorreo FROM _405_tablaDinamica where 
				id__405_tablaDinamica ".$comp." in(".$listProveedoresActivos.") and id__405_tablaDinamica<>-1 and  ".$condWhere." order by txtRazonSocial2 limit ".$start.",".$limit;
		
		$arrProveedores=utf8_encode($con->obtenerFilasJson($consulta));
		$consulta="SELECT count(*) FROM _405_tablaDinamica where id__405_tablaDinamica ".$comp." in(".$listProveedoresActivos.") and  ".$condWhere;
		
		$nReg=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nReg.'","registros":'.$arrProveedores.'}';
	}
	
	function obtenerProductoEsperaPedido()
	{
		global $con;
		$idProveedor=$_POST["idProveedor"];
		$consulta="SELECT idPedidoEsperaContrato,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null
					,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) nombreProducto,m.descripcion AS marca,modelo,pre.descripcion AS presentacion,p.cantidad,u.descripcion AS unidadMedida,p.costoUnitario,p.total,c.fuentefinanciamiento,
					concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen,al.idAlmacen 
					FROM 9101_pedidosEsperaContrato p,527_concentradoProductoTipoCompra c,_406_tablaDinamica m,
					_407_tablaDinamica pre,_403_tablaDinamica u,
					9101_CatalogoProducto pro,9030_categoriasObjetoGasto cat,9030_almacenes al WHERE 
					situacion=0 AND c.idCompraVSProducto=p.idConcentradoProducto AND m.id__406_tablaDinamica=p.idMarca 
					AND pre.id__407_tablaDinamica=p.presentacion AND u.id__403_tablaDinamica=p.unidadMedida 
					AND pro.idProducto=c.idProducto AND p.idProveedor=".$idProveedor." and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen";
		$arrProveedores=utf8_encode($con->obtenerFilasJson($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrProveedores.'}';
	}
	
	function obtenerListadoNecesidadesProducto()
	{
		global $con;
		$tipoUnidad=1;
		if(isset($_POST["tipoUnidad"]))
			$tipoUnidad=$_POST["tipoUnidad"];
		$listProductos=$_POST["idPedidoEsperaContrato"];
		$arrRegistros="";
		$ct=0;
		$consulta="SELECT idPedidoEsperaContrato,c.idConcentradoProducto,pro.nombreProducto,c.idCompraVSProducto FROM 9101_pedidosEsperaContrato p,9101_CatalogoProducto pro,527_concentradoProductoTipoCompra c WHERE 
					idPedidoEsperaContrato IN (".$listProductos.") and c.idCompraVSProducto=p.idConcentradoProducto and pro.idProducto=c.idProducto";
		$resFilas=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFilas))
		{
			$arrMeses="";
			$totalProducto=0;
			for($mes=0;$mes<11;$mes++)
			{
				$query="SELECT cantidad,mes,monto FROM 528_distribucionConcentradoTipoCompra WHERE idCompraVSProducto=".$fila[3]." and mes=".$mes." ORDER BY mes";
				$filaMes=$con->obtenerPrimeraFila($query);
				$cantidad=0;
				if($filaMes)
				{
					if($tipoUnidad==1)
						$cantidad=$filaMes[0];
					else
						$cantidad=$filaMes[2];
				}
				$totalProducto+=$cantidad;
				$objMes='"mes_'.$mes.'":"'.removerCerosDerecha($cantidad).'"';
				$arrMeses.=",".$objMes;
				
			}
			$obj='{"totalProducto":"'.$totalProducto.'","idPedidoEsperaContrato":"'.$fila[0].'","nombreProducto":"'.cv($fila[2]).'"'.$arrMeses.'}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$ct++;
			
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrRegistros.']}';

	}
	
	function guardarCompraPedido()
	{
		global $con;
		global $valIVA;
		$porcIva=$valIVA;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		$idProveedor=$_POST["idProveedor"];
		$arrEntregas=array();
		$arrAsientos=array();
		$aplicacionDias="-1";
		$idReglaSancion="-1";
		$conPago="-1";
		$idAlmacen=-1;
		$tMovimiento="21";
		$rPresupuesto=new cPresupuesto();
		$rContabilidad=new cContabilidad();
		$folio=$rPresupuesto->obtenerFolioSiguiente($tMovimiento);

		
		foreach($obj as $o)
		{
			if($o->cantidad>0)
			{
				if(!isset($arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]))
				{
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]=array();
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["cantidad"]=0;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["marca"]=$o->idMarca;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["contenedor"]=$o->contenedor;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["presentacion"]=$o->presentacion;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["unidadMedida"]=$o->unidadMedida;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["consideraIVA"]=$o->consideraIva;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["descripcion"]=$o->descripcion;
					$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["cadMeses"]=$o->cadMeses;
					$aplicacionDias=$o->aplicacionDias;
					$idReglaSancion=$o->idReglaSancion;
					$conPago=$o->conPago;
					$idAlmacen=$o->idAlmacen;
				}
				$arrEntregas[$o->fechaEntrega][$o->idPedidoEsperaContrato]["cantidad"]+=$o->cantidad;
				
				
				$query="SELECT idConcentradoProducto FROM 9101_pedidosEsperaContrato WHERE idPedidoEsperaContrato=".$o->idPedidoEsperaContrato;
				$idConcentrado=$con->obtenerValor($query);
				$arrMeses=explode(",",$o->cadMeses);
				$query="SELECT idConcentradoProducto FROM 527_concentradoProductoTipoCompra WHERE idCompraVSProducto=".$idConcentrado;
				$idConcentradoProducto=$con->obtenerValor($query);
				
				$query="SELECT solicitudesComprende FROM 527_concentradoProducto WHERE idCompraVSProducto=".$idConcentradoProducto;
				$sComprende=$con->obtenerValor($query);
				$arrSol=explode(",",$sComprende);
				foreach($arrSol as $s)				
				{
					$query="SELECT idCiclo,codDepto,idPrograma,ruta,tipoPresupuesto,clave FROM 525_productosAutorizados WHERE idCodigoGastoCiclo=".$s;
					$fSolicitud=$con->obtenerPrimeraFila($query);
					foreach($arrMeses as $m)
					{
						$query="SELECT monto FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$s." AND mes=".$m;
						$montoMes=$con->obtenerValor($query);
						if($montoMes>0)
						{
							$cadObj='{
										"tipoMovimiento":"'.$tMovimiento.'",
										"folio":"'.$folio.'",
										"montoOperacion":"'.$montoMes.'",
										"dimensiones":""
									}';
							
							$arrDimensiones=array();
							$arrDimensiones["mes"]=$m;
							$arrDimensiones["idPrograma"]=$fSolicitud[2];
							$arrDimensiones["ruta"]=$fSolicitud[3];
							$arrDimensiones["ciclo"]=$fSolicitud[0];
							$arrDimensiones["departamento"]=$fSolicitud[1];
							$arrDimensiones["capitulo"]=substr($fSolicitud[5],0,3);
							$arrDimensiones["partida"]=$fSolicitud[5];
							$arrDimensiones["tipoPresupuesto"]=$fSolicitud[4];	
							$o=json_decode($cadObj);
							$o->dimensiones=$arrDimensiones;
							array_push($arrAsientos,$o);
						}
					}
					
				}
				
			}
			
		}

		$folioPedido=generarFolioPedido($idAlmacen);
		$query="SELECT nombreAlmacen FROM 9030_almacenes WHERE idAlmacen=".$idAlmacen;
		$nAlmacen=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$nEntrega=1;

		$arrAsientosContables=array();
		foreach($arrEntregas as $fecha=>$resto)
		{
			$consulta[$x]="INSERT INTO 9102_PedidoCabecera(idAlmacen,idProveedor_ult,fechaPedido,fechaRecepcion,status_pedido,folioPedido,mes,idConcentradoProducto,idProducto,idReglaSancion,aplicabilidadDias,num_entrega,cond_pago)
							 VALUES(".$idAlmacen.",".$idProveedor.",'".date("Y-m-d")."','".cambiaraFechaMysql($fecha)."',1,'".$folioPedido."',".(date("m",strtotime(cambiaraFechaMysql($fecha)))-1).",NULL,NULL,".$idReglaSancion.",".$aplicacionDias.",".$nEntrega.",".$conPago.")";
			$x++;
			$consulta[$x]="set @idPedido=(select last_insert_id())";
			$x++;
			foreach($resto as $idProductoEsperaPedido=>$r)
			{
				$iva=0;
				$query="SELECT * FROM 9101_pedidosEsperaContrato WHERE idPedidoEsperaContrato=".$idProductoEsperaPedido;
				$filaProd=$con->obtenerPrimeraFila($query);
				
				$query="SELECT idProducto,objetoGasto,solicitudesComprende FROM 527_concentradoProductoTipoCompra WHERE idCompraVSProducto=".$filaProd[3];
				$filaConcentrado=$con->obtenerPrimeraFila($query);
				$query="SELECT mes FROM 528_distribucionConcentradoTipoCompra WHERE idCompraVSProducto=".$filaProd[3];
				$listaMeses=$con->obtenerListaValores($query);
				
				$partida=$filaConcentrado[1];
				$idProducto=$filaConcentrado[0];
				$subtotal=$r["cantidad"]*$filaProd[15];
				if($r["consideraIVA"]!=0)
				{
					$iva=$subtotal*($porcIva/100);
				}
				$total=$subtotal+$iva;
				$solicitudesComprende=$filaConcentrado[2];
				$consulta[$x]=" INSERT INTO 9103_PedidoDetalle(idPedido,idProducto,idMarca,modelo,cantidad,costoUnitario,iva,statusPedido,idContenedor,idUnidadMedida,idPresentacion,fechaPedido,partida,subtotal,total) 
								VALUES(@idPedido,'".$idProducto."',".$r["marca"].",'".$r["descripcion"]."',".$r["cantidad"].",".$filaProd[15].",".$iva.",1,".$r["contenedor"].",".$r["unidadMedida"].",".
								$r["presentacion"].",'".cambiaraFechaMysql($fecha)."','".$partida."',".$subtotal.",".$total.")";
				$x++;
				$consulta[$x]="update 9101_pedidosEsperaContrato set situacion=1 WHERE idPedidoEsperaContrato=".$idProductoEsperaPedido;
				$x++;
				//$arrMeses=explode(",",$r["cadMeses"]);
				$query="SELECT * FROM 525_productosAutorizados WHERE idCodigoGastoCiclo IN (".$solicitudesComprende.")";
				$resSolicitud=$con->obtenerFilas($query);
				while($fProducto=mysql_fetch_row($resSolicitud))
				{
					
					$query="SELECT SUM(cantidad) FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fProducto[0]." AND mes IN (".$r["cadMeses"].") and mes in (".$listaMeses.")";
					$cantidadDepto=$con->obtenerValor($query);
					$montoDepto=($cantidadDepto*$filaProd[15]);
					
					$codigoUnidad=$fProducto[3];
					$ivaDepto=0;
					if($r["consideraIVA"]!=0)
					{
						$ivaDepto=$montoDepto*($porcIva/100);
					}
					$totalDepto=$montoDepto+$ivaDepto;
					$idConcepto=$idProducto;
					if($cantidadDepto!=0)
					{
						$consulta[$x]="INSERT INTO 9108_distribucionPedido(idPedido,codigoUnidad,idConcepto,cantidad,subtotal,iva,total,idPrograma,ruta,partida,idCiclo,tipoPresupuesto) 
										values(@idPedido,'".$codigoUnidad."','".$idConcepto."',".$cantidadDepto.",".$montoDepto.",".$ivaDepto.",".$totalDepto.",".$fProducto[10].",'".
										$fProducto[21]."','".$fProducto[1]."',".$fProducto[2].",".$fProducto[19].")";
						$x++;
						
						
						
						$cadObj='{
									"tipoMovimiento":"'.$tMovimiento.'",
									"folio":"'.$folio.'",
									"montoOperacion":"'.$totalDepto.'",
									"dimensiones":""
								}';
						$arrDimensiones=array();
						$arrDimensiones["idPrograma"]=$fProducto[10];
						$arrDimensiones["ruta"]=$fProducto[21];
						$arrDimensiones["ciclo"]=$fProducto[2];
						$arrDimensiones["departamento"]=$codigoUnidad;
						$arrDimensiones["partida"]=$fProducto[1];
						$arrDimensiones["idAlmacen"]=$idAlmacen;
						$arrDimensiones["tipoPresupuesto"]=$fProducto[19];	
						$o=json_decode($cadObj);
						$o->dimensiones=$arrDimensiones;
						array_push($arrAsientosContables,$o);
					}

				}
			}
			
			$nEntrega++;
		}
		
		
		
		$rContabilidad->asentarArregloMovimientos($arrAsientos,$consulta,$x);
		$rContabilidad->asentarArregloMovimientos($arrAsientosContables,$consulta,$x);
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|".$folioPedido;
	
	
		
	}
	
	function obtenerProveedoresParticipantes()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta=" SELECT idLicitacionVSProveedor, id__405_tablaDinamica as idProveedor,txtRFC as rfc,txtRazonSocial2 as proveedor,l.noProveedorLicitacion 
					FROM 530_licitacionVSProveedor l,_405_tablaDinamica t WHERE t.id__405_tablaDinamica=l.idProveedor AND 
					l.idFormulario=".$idFormulario." AND l.idReferencia=".$idRegistro." order by noProveedorLicitacion";
		$arrReg=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function removerProveedorParticipante()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idProveedor=$_POST["idProveedor"];
		$consulta="DELETE FROM 530_licitacionVSProveedor WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idProveedor=".$idProveedor;
		eC($consulta);
	}
	
	function agregarProveedorParticipante()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idProveedor=$_POST["idProveedor"];
		$consulta="SELECT max(noProveedorLicitacion) FROM  530_licitacionVSProveedor WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$noProveedorLicitacion=$con->obtenerValor($consulta);
		if($noProveedorLicitacion=="")
			$noProveedorLicitacion=1;
		else
			$noProveedorLicitacion++;
		$consulta="INSERT INTO 530_licitacionVSProveedor(idFormulario,idReferencia,idProveedor,noProveedorLicitacion) 
				VALUES(".$idFormulario.",".$idRegistro.",".$idProveedor.",".$noProveedorLicitacion.")";
		eC($consulta);
	}
	
	function buscarProveedor()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$tBusqueda=$_POST["tBusqueda"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT idProveedor FROM 530_licitacionVSProveedor WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listProveedores=$con->obtenerListaValores($consulta);
		if($listProveedores=="")
			$listProveedores=-1;
		$condWhere="";
		if($tBusqueda==1)
			$condWhere="txtRFC like '".$criterio."%'";
		else
			$condWhere="txtRazonSocial2 like '".$criterio."%'";
		$consulta="SELECT id__405_tablaDinamica AS idProveedor,txtRFC AS rfc,txtRazonSocial2 AS proveedor FROM _405_tablaDinamica WHERE ".$condWhere." and id__405_tablaDinamica not in (".$listProveedores.")";
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"num":"'.$con->filasAfectadas.'","objetos":'.$arrObj.'}';
	}
	
	function obtenerPropuestaProveedor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idProveedor=$_POST["idProveedor"];
		$consulta="SELECT idProductoVSLicitacion as idPartida,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as producto,
					concat('[',cat.cveCategoria,'] ',cat.nombre) as grupo,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen,noInternoLicitacion,p.clave_Art,c.costoUnitario
					FROM 527_concentradoProductoTipoCompra c, 9101_CatalogoProducto p, 529_licitaciones l, 9030_categoriasObjetoGasto cat,9030_almacenes al,536_propuestasProveedor pro
					WHERE idProductoVSLicitacion=pro.idPartida and pro.idProveedor=".$idProveedor." and c.idProducto=p.idProducto AND c.idCompraVSProducto=l.idCompraVSProducto and 
					cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen AND l.idFormulario=".$idFormulario." AND l.idReferencia=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		$arreglo="";
		$nReg=0;
		$consulta="SELECT porcentajeIgnora FROM _971_tablaDinamica";
		$porcentajeLimite=$con->obtenerValor($consulta)/100;

		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idMarca,caracteristicas,costo,situacion,idPropuesta FROM 536_propuestasProveedor WHERE idPartida=".$fila[0]." and idProveedor=".$idProveedor;
			$fProd=$con->obtenerPrimeraFila($consulta);
			$idMarca="";
			$caracteristicas="";
			$situacion="-1";
			$idPropuesta="-1";
			$costo="0";
			if($fProd)
			{
				$idMarca=$fProd[0];
				$caracteristicas=$fProd[1];
				$situacion=$fProd[3];
				$idPropuesta=$fProd[4];
				$costo=$fProd[2];
			}
			$situacionCosto=0;
            $limite=$fila[6]-($fila[6]*$porcentajeLimite);
            if($costo<$limite)
            	$situacionCosto='1';
            if(($costo>=$limite)&&($costo<=$fila[6]))
           		$situacionCosto='3';
            if($costo>$fila[6])
            	$situacionCosto='2';
			$obj='{"cve_Art":"'.$fila[5].'","noPartida":"'.$fila[4].'","idPartida":"'.$fila[0].'","producto":"'.cv($fila[1]).'","grupo":"'.$fila[2].'","almacen":"'.$fila[3].'",
					"idMarca":"'.$idMarca.'","caracteristicas":"'.cv($caracteristicas).'","costo":"'.$costo.'","situacion":"'.$situacion.
					'","idPropuesta":"'.$idPropuesta.'","costoBase":"'.$fila[6].'","situacionCosto":"'.$situacionCosto.'"}';
			if($arreglo=="")
				$arreglo=$obj;
			else
				$arreglo.=",".$obj;
			$nReg++;
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.($arreglo).']}';
	}
	
	function guardarPartidasNoParticipaProveedor()
	{
		global $con;
		$cadObj=$_POST["listaPartidas"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idProveedor=$_POST["idProveedor"];
		$arrPartidas=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPartidas as $partida)
		{
			if($partida->idPropuesta!=-1)
			{
				$consulta[$x]="delete from 536_propuestasProveedor where idPropuesta=".$partida->idPropuesta;
				$x++;
			}
			$consulta[$x]="INSERT INTO 536_propuestasProveedor(idProveedor,idPartida,idMarca,caracteristicas,costo,participa,situacion,idFormulario,idReferencia)
								VALUES(".$idProveedor.",".$partida->idPartida.",NULL,'',0,0,0,".$idFormulario.",".$idRegistro.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarPropuestaProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idPropuesta==-1)
		{
			$consulta="INSERT INTO 536_propuestasProveedor(idProveedor,idPartida,idMarca,caracteristicas,costo,participa,situacion,idFormulario,idReferencia)
								VALUES(".$obj->idProveedor.",".$obj->idPartida.",".$obj->idMarca.",'".cv($obj->caracteristicas)."',".$obj->costo.",1,1,".$obj->idFormulario.",".$obj->idRegistro.")";
		}
		else
		{
			$consulta="update 536_propuestasProveedor set participa=1, situacion=1,idMarca=".$obj->idMarca.",caracteristicas='".cv($obj->caracteristicas)."',costo=".$obj->costo." where idPropuesta=".$obj->idPropuesta;

		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idPropuesta==-1)
				$obj->idPropuesta=$con->obtenerUltimoID();
			echo "1|".$obj->idPropuesta;
		}
		
	}
	
	function cerrarPropuestaProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE 530_licitacionVSProveedor SET propuestaCerrada=1 WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro."  AND idProveedor=".$obj->idProveedor;
		eC($consulta);
	}
	
	function obtenerParticipantesPartidas()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idPartida=$_POST["idPartida"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="	SELECT pr.id__405_tablaDinamica,pr.txtRazonSocial2, m.descripcion,caracteristicas,costo, noProveedorLicitacion as noProveedor,p.idPartida
					FROM 536_propuestasProveedor p,_406_tablaDinamica m,_405_tablaDinamica pr,530_licitacionVSProveedor l 
					WHERE l.idProveedor=p.idProveedor and l.idFormulario=p.idFormulario and l.idReferencia=p.idReferencia and 
					pr.id__405_tablaDinamica=p.idProveedor AND  m.id__406_tablaDinamica=p.idMarca AND idPartida=".$idPartida." AND situacion=1 
					and p.idFormulario=".$idFormulario." and p.idReferencia=".$idRegistro." order by noProveedorLicitacion";
		$arrObj="";
		$res=$con->obtenerFilas($consulta);
		$nReg=0;
		while($fila=mysql_fetch_row($res))
		{	
			$idPartida=$fila[6];
			$consulta="SELECT costoUnitario FROM 529_licitaciones l,527_concentradoProductoTipoCompra c WHERE l.idProductoVSLicitacion=".$idPartida."
						AND c.idCompraVSProducto=l.idCompraVSProducto";
			$costoBase=$con->obtenerValor($consulta);
			$idDictamenPropuesta="-1";
			$dictamen="-1";
			$comentarios="";
			$consulta="SELECT * FROM 537_evaluacionPropuestasProveedor WHERE idPartida=".$idPartida." AND idProveedor=".$fila[0]." AND idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$filaD=$con->obtenerPrimeraFila($consulta);
			if($filaD)
			{
				$idDictamenPropuesta=$filaD[0];
				$dictamen=$filaD[3];
				$comentarios=$filaD[4];
			}
			$obj='{"costoBase":"'.$costoBase.'","noProveedor":"'.$fila[5].'","idProveedor":"'.$fila[0].'","proveedor":"'.$fila[1].'","marca":"'.$fila[2].'","caracteristicas":"'.cv($fila[3]).'","costo":"'.$fila[4].'","idDictamenPropuesta":"'.$idDictamenPropuesta.'","dictamen":"'.cv($dictamen).'","comentarios":"'.cv($comentarios).'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrObj.']}';
	}
	
	function guardarDictamenPropuesta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idDictamenPropuesta==-1)
		{
			$consulta="INSERT INTO 537_evaluacionPropuestasProveedor(idProveedor,idPartida,dictamen,comentarios,idFormulario,idReferencia)
					VALUES(".$obj->idProveedor.",".$obj->idPartida.",".$obj->dictamen.",'".cv($obj->comentarios)."',".$obj->idFormulario.",".$obj->idRegistro.")";
		}
		else
		{	
			$consulta="update 537_evaluacionPropuestasProveedor set dictamen=".$obj->dictamen.",comentarios='".cv($obj->comentarios)."' where idDictamenPropuesta=".$obj->idDictamenPropuesta;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idDictamenPropuesta==-1)
				$obj->idDictamenPropuesta=$con->obtenerUltimoID();
			echo "1|".$obj->idDictamenPropuesta;
		}
	}
	
	function cerrarDictamenPartida()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="INSERT INTO 538_partidasDictamenCerrada(idPartida,idFormulario,idRegistro) VALUES(".$obj->idPartida.",".$obj->idFormulario.",".$obj->idRegistro.")";
		eC($consulta);
	}
	
	function obtenerPartidasLicitacion()
	{
		global $con;
		global $SO;
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idProductoVSLicitacion,(if(tipoProducto=1,(SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),(if(complementario is null,(select nombreObjetoGasto from 507_objetosGasto where codigoControl=c.objetoGasto),complementario)))) as nombreProducto,
					cantidad,costoUnitario,	total,p.descripcion,c.idCompraVSProducto,pre.tituloTipoP as fuenteFinanciamiento,concat('[',cat.cveCategoria,'] ',cat.nombre) as categoria,concat('[',al.cveAlmacen,'] ',al.nombreAlmacen) as almacen,
					p.clave_Art,l.noInternoLicitacion
					FROM 527_concentradoProductoTipoCompra c, 9101_CatalogoProducto p, 529_licitaciones l, 
					508_tiposPresupuesto pre,9030_categoriasObjetoGasto cat,9030_almacenes al
					WHERE c.idProducto=p.idProducto AND c.idCompraVSProducto=l.idCompraVSProducto and pre.idTipoPresupuesto=c.fuenteFinanciamiento 
					and cat.idCategoria=c.idCategoriaProducto and al.idAlmacen=cat.idAlmacen AND l.idFormulario=".$idFormulario." AND l.idReferencia=".$idRegistro." order by
					l.noInternoLicitacion";
		$res=$con->obtenerFilas($consulta);
		$nReg=$con->filasAfectadas;
		
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{

			$consulta="SELECT * from 531_licitacionVSProveedorElegido WHERE idPartida=".$fila[0]." AND idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$fProveedor=$con->obtenerPrimeraFila($consulta);
			$proveedorAsignado="";
			$idMarca="";
			$caracteristicas="";
			$idProveedor="";	
			$costo=0;
			$nProveedor="";
			$situacion=0;
			$comentarios="";
			if($fProveedor)
			{
				$cadObj=$fProveedor[8];
				$obj=json_decode($cadObj);
				$caracteristicas=$obj->modelo;
				$idProveedor=$fProveedor[1];
				$idMarca=$obj->idMarca;
				$costo=$obj->costoUnitario;
				$comentarios=$fProveedor[10];
				$consulta="SELECT noProveedorLicitacion FROM 530_licitacionVSProveedor WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." 
							AND idProveedor=".$idProveedor;
				$nProveedor="[".$con->obtenerValor($consulta)."]";
				$consulta="select txtRazonSocial2 from _405_tablaDinamica where id__405_tablaDinamica=".$idProveedor;
				$proveedorAsignado=$con->obtenerValor($consulta);
				$situacion="1";
			}
			else
			{
				$consulta="SELECT COUNT(*) FROM 540_registroAdjudicacionPartidas WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
				$nRegistros=$con->obtenerValor($consulta);
				if($nRegistros>0)
				{
					$consulta="SELECT idPartidasEmpatadas FROM 539_partidasEmpatadas WHERE idPartida=".$fila[0];
					$fPartidas=$con->obtenerPrimeraFila($consulta);
					if($fPartidas)
					{
						$situacion=3;
					}
					else
					{
						$consulta="SELECT COUNT(*) FROM 536_propuestasProveedor WHERE idPartida=".$fila[0];
						$nPropuestas=$con->obtenerValor($consulta);
						if($nPropuestas==0)
						{
							$situacion=2;
						}
						else
							$situacion=4;
					}
				}
				else
					$situacion=0;
			}
			$obj='{"comentarios":"'.$comentarios.'","situacion":"'.$situacion.'","noPartida":"'.$fila[11].'","cve_Art":"'.$fila[10].'","almacen":"'.$fila[9].'","categoria":"'.$fila[8].'","idProductoVSLicitacion":"'.$fila[0].'","nombre":"'.cv($fila[1]).'","cantidad":"'.$fila[2].'","costoU":"'.$costo.'","total":"'.$fila[4].'","descripcion":"'.cv($fila[5]).'",
					"proveedor":"'.$nProveedor.' '.$proveedorAsignado.'","idMarca":"'.$idMarca.'","caracteristicas":"'.$caracteristicas.'","idProveedor":"'.$idProveedor.'"}';
					
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nReg.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function obtenerGanadorPartidas()
	{
		global $con;
		$cadPartidas=$_POST["cadPartidas"];
		$idProceso=$_POST["idProceso"];
		$arrPartidas=explode(",",$cadPartidas);
		$x=0;
		$arrConsultas[$x]="begin";
		$x++;
		$arrConsultas[$x]="delete from 531_licitacionVSProveedorElegido where idPartida in (".$cadPartidas.")";
		$x++;
		$arrConsultas[$x]="delete from 539_partidasEmpatadas where idPartida in (".$cadPartidas.")";
		$x++;
		$idFormulario=-1;
		$idRegistro=-1;
		
		foreach($arrPartidas as $p)
		{
			$consulta="SELECT idCompraVSProducto,idMarca,idFormulario,idReferencia FROM 529_licitaciones WHERE idProductoVSLicitacion=".$p;
			$fCompra=$con->obtenerPrimeraFila($consulta);
			$idProductoCompra=$fCompra[0];
			$idMarca=$fCompra[1];
			$idFormulario=$fCompra[2];
			$idRegistro=$fCompra[3];
			if($idMarca=="")
				$idMarca=0;
			$existePropuesta=false;
			if(incluyeModulo($idProceso,17)!=-1)
				$existePropuesta=true;
				
			$resPropuesta=obtenerPropuestaLicitacion($p,$existePropuesta);
			$arrPropuesta=explode("|",$resPropuesta);

			if($arrPropuesta[0]=="1")
			{
				$idPropuesta=$arrPropuesta[1];
				$consulta="select * from 536_propuestasProveedor where idPropuesta=".$idPropuesta;
				$fPropuesta=$con->obtenerPrimeraFila($consulta);
				$costoUnitario=$fPropuesta[5];
				$iva="";
				$subtotal="";
				$total="";
				$consulta="SELECT cantidad,objetoGasto FROM 527_concentradoProductoTipoCompra WHERE idCompraVSProducto=".$idProductoCompra;
				$fProducto=$con->obtenerPrimeraFila($consulta);
				$cantidad=$fProducto[0];
				$iva=0;
				$subtotal=$costoUnitario*$cantidad;
				$total=$subtotal+$iva;
				$idProveedor=$fPropuesta[1];
				$idProducto=$idProductoCompra;
				$idFormulario=$fPropuesta[8];
				$idRegistro=$fPropuesta[9];
				$cadDetalle='{"tipoContrato":"0","porcentajeMinimo":"0","contenedor":"0","idMarca":"'.$idMarca.'","modelo":"'.cv($fPropuesta[4]).'","presentacion":"0","UnidadMedida":"0","cantidad":"'.$cantidad.'","costoUnitario":"'.$costoUnitario.'","iva":"'.$iva.'",
							"subtotal":"'.$subtotal.'","total":"'.$total.'","entregablesJava":"[]","entregablesPHP":[]}';
				$arrConsultas[$x]="INSERT INTO 531_licitacionVSProveedorElegido(idProveedor,idProducto,idPedido,estado,idFormulario,idReferencia,detalles,idPartida)
									VALUES(".$idProveedor.",".$idProducto.",0,0,".$idFormulario.",".$idRegistro.",'".($cadDetalle)."',".$p.")";
				$x++;
			}
			else
			{
				if($arrPropuesta[0]==2)
				{
					$arrConsultas[$x]="INSERT INTO 539_partidasEmpatadas(idPartida,listPropuestas) VALUES(".$p.",'".$arrPropuesta[1]."')";
					$x++;
				}
			}
			
		}
		$arrConsultas[$x]="INSERT INTO 540_registroAdjudicacionPartidas(idFormulario,idRegistro) VALUES(".$idFormulario.",".$idRegistro.")";
		$x++;
		$arrConsultas[$x]="commit";
		$x++;
		eB($arrConsultas);
		
	}
	
	function obtenerPropuestaLicitacion($p,$existeEvaluacionPropuesta=true)
	{
		global $con;
		$consulta="";
		$consulta="SELECT porcentajeIgnora FROM _971_tablaDinamica";

		$porcentajeLimite=$con->obtenerValor($consulta)/100;
		$consulta="SELECT costoUnitario FROM 529_licitaciones l,527_concentradoProductoTipoCompra c WHERE l.idProductoVSLicitacion=".$p." 
					AND  c.idCompraVSProducto=l.idCompraVSProducto";

		$costoBase=$con->obtenerValor($consulta);
		$limite=$costoBase-($costoBase*$porcentajeLimite);
		$listPropuestas="";
		
		$costoGanador=0;
		$idPropuesta="";
		if($existeEvaluacionPropuesta)
		{
			$consulta="SELECT p.idPropuesta,costo FROM 536_propuestasProveedor p,537_evaluacionPropuestasProveedor e WHERE p.idPartida=e.idPartida AND p.idProveedor=e.idProveedor
						AND p.idPartida=".$p." AND situacion=1 ORDER BY costo";
		}
		else
		{
			$consulta="SELECT p.idPropuesta,costo FROM 536_propuestasProveedor p  WHERE p.idPartida=".$p." ORDER BY costo";
		}
		
		$resPropuestas=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resPropuestas))
		{
			//echo $fila[1]." ".$limite." ".$costoBase."<br>";
			if(($fila[1]>=$limite)&&($fila[1]<=$costoBase))
			{

				if($idPropuesta=="")
				{
					$costoGanador=$fila[1];
					$idPropuesta=$fila[0];
				}
				else
				{
					if($costoGanador>$fila[1])
					{
						$costoGanador=$fila;
						$idPropuesta=$fila[0];
					}
					else
					{
						if($costoGanador==$fila[1])
						{
							$idPropuesta.=",".$fila[0];
						}
					}
				}
			}
			if($listPropuestas=="")
				$listPropuestas=$fila[0];
			else
				$listPropuestas.=",".$fila[0];
		}
		//$idPropuesta=$con->obtenerValor($consulta);
		$resultado=0;
		if($idPropuesta!="")	
		{
			if(strpos($idPropuesta,",")!==false)
			{
				$resultado=2;
			}
			else
			{
				$resultado=1;
			}
		}
		else
		{
			$idPropuesta=$listPropuestas;
		}
		return $resultado."|".$idPropuesta;
	}
	
	function removerPropuestaProveedor()
	{
		global $con;
		$idPropuesta=$_POST["idPropuesta"];
		$consulta="DELETE FROM 536_propuestasProveedor WHERE idPropuesta=".$idPropuesta;
		eC($consulta);	
	}
	
	function obtenerDistribucionSolicitud()
	{
		global $con;
		$listProductos=$_POST["idPedidoEsperaContrato"];
		$arrRegistros="";
		$ct=0;
		$consulta="SELECT idCompraVSProducto,pro.nombreProducto,c.catalogo, 
					(if(tipoProducto=1,(SELECT clave_Art FROM 9101_CatalogoProducto WHERE idProducto=c.idProducto),'')) as cve_art
					FROM 9101_CatalogoProducto pro,527_concentradoProducto c WHERE 
					idCompraVSProducto IN (".$listProductos.") and pro.idProducto=c.idProducto";

		$resFilas=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFilas))
		{
			$arrMeses="";
			$query="SELECT cantidad,mes FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$fila[0]." ORDER BY mes";
			$resMes=$con->obtenerFilas($query);
			$totalProducto=0;
			while($filaMes=mysql_fetch_row($resMes))
			{
				$checkBox="";
				$query="SELECT c.idCompraVSProducto FROM 527_concentradoProductoTipoCompra c,528_distribucionConcentradoTipoCompra d 
						WHERE c.idConcentradoProducto=".$fila[0]." AND d.idCompraVSProducto=c.idCompraVSProducto AND mes=".$filaMes[1];
				$idCompraVSProducto=$con->obtenerValor($query);
				if(($idCompraVSProducto=="")&&($filaMes[0]!=0))
				{
					$checkBox="<input checked=\'checked\' type='checkbox' mes='".$filaMes[1]."' name='chk_".$fila[0]."' id='".$fila[0]."_".$filaMes[1]."'> ";	
				}
				$totalProducto+=$filaMes[0];
				$objMes='"mes_'.$filaMes[1].'":"'.$checkBox.removerCerosDerecha($filaMes[0]).'"';
				$arrMeses.=",".$objMes;
			}
			$consulta="SELECT SUM(cantidad) FROM 527_concentradoProductoTipoCompra WHERE idConcentradoProducto=".$fila[0];
			$nCategorizados=$con->obtenerValor($consulta);
			if($nCategorizados=="")
				$nCategorizados=0;
			$totalProducto-=$nCategorizados;
			$obj='{"idProductoConcentrado":"'.$fila[0].'","catalogo":"'.$fila[2].'","clave_Art":"'.$fila[3].'","totalProducto":"<input checked=\'checked\' type=\'checkbox\' id=\'sel_'.$fila[0].'\' onclick=\'javascript:selDistribucion(this)\' > '.$totalProducto.'","idPedidoEsperaContrato":"'.$fila[0].'","nombreProducto":"'.cv($fila[1]).'"'.$arrMeses.'}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$ct++;
			
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarTipoCompraProducto()
	{
		global $con;
		$tipoCompra=$_POST["tCompra"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrObj as $o)
		{
			$query="select sum(cantidad) FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$o->idConcentrado." AND mes IN (".$o->meses.")";
			$total=$con->obtenerValor($query);
			$consulta[$x]="INSERT INTO 527_concentradoProductoTipoCompra(idProducto,cantidad,costoUnitario,total,idTipoCompra,estado,ciclo,referencia,
							tipoReferencia,tipoProducto,complementario,complementario2,complementario3,codigoInstitucion,objetoGasto,solicitudesComprende,
							fuenteFinanciamiento,idCategoriaProducto,catalogo,idConcentradoProducto)
							SELECT idProducto,'".$total."' AS cantidad,costoUnitario,(".$total."*costoUnitario) AS total,'".$tipoCompra."' AS tipoCompra,estado,ciclo,referencia,
							tipoReferencia,tipoProducto,complementario,complementario2,complementario3,codigoInstitucion,objetoGasto,solicitudesComprende,
							fuenteFinanciamiento,idCategoriaProducto,catalogo,'".$o->idConcentrado."' as idConcentrado from 527_concentradoProducto
							WHERE idCompraVSProducto=".$o->idConcentrado;
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 528_distribucionConcentradoTipoCompra(idCompraVSProducto,mes,cantidad,monto)
						   SELECT @idRegistro,mes,cantidad,monto FROM 528_distribucionConcentrado WHERE idCompraVSProducto=".$o->idConcentrado." and mes in (".$o->meses.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	function obtenerDepartamentosSolicitudesProductosDivididos()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$tipoProducto=$_POST["tipoProducto"];
		$ciclo=$_POST["ciclo"];
		$condWhere="";
		$arrRutas=obtenerCodigosRutas($ciclo);
		$consulta="select solicitudesComprende from 527_concentradoProductoTipoCompra where idCompraVSProducto=".$idProducto;
		
		$listSolicitudes=$con->obtenerListaValores($consulta);
		if($listSolicitudes=="")
			$listSolicitudes=-1;
		$consulta="SELECT mes FROM 528_distribucionConcentradoTipoCompra WHERE idCompraVSProducto=".$idProducto;
		$listMeses=$con->obtenerListaValores($consulta);
		$condWhere=" and idCodigoGastoCiclo in(".$listSolicitudes.")";
		$consulta="SELECT idCodigoGastoCiclo,ruta,CONCAT(cvePrograma,'] ',tituloPrograma),CONCAT('[',codigoDepto,'] ',unidad),if(s.idCabecera is null,format(cantidad,0),concat('$ ',format(montoTotal,2))),idCabecera FROM 525_productosAutorizados s,817_organigrama o,517_programas p WHERE o.codigoUnidad=s.codDepto AND p.idPrograma=s.idPrograma".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$nFilas=0;
		while($fila=mysql_fetch_row($res))
		{
			$cadenaAux="<table><tr>";
			for($y=0;$y<11;$y++)
			{
				$cadenaAux.="<td width='60' align='center'><span class='corpo8_bold'>".obtenerAbreviaturaMes($y)."</span></td>";
			}
			$cadenaAux.="</tr><tr height='1'><td colspan='12' style='background-color:#900'></td></tr><tr>";
			$cantidad=0;
			for($y=0;$y<11;$y++)
			{
				if($fila[5]=='')
					$consulta="SELECT  format(cantidad,0),cantidad FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fila[0]." AND mes=".$y." and  mes in (".$listMeses.")";
				else
					$consulta="SELECT  concat('$ ',format(monto,2)),monto FROM 526_distribucionAutorizada WHERE idCodigoGastoCiclo=".$fila[0]." AND mes=".$y." AND mes in (".$listMeses.")";
				$fCantidad=$con->obtenerPrimeraFila($consulta);
				$cantidadAux=$fCantidad[0];
				$cantidad+=$fCantidad[1];
				if($cantidadAux=="")
					$cantidadAux=0;
				$cadenaAux.="<td align='center'><span class='letraExt'>".($cantidadAux)."</span></td>";
			}
			
			$cadenaAux.="</tr></table>";
			if($cantidad<>0)
			{
				$obj='{"programa":"['.cv($arrRutas[$fila[1]])." ".cv($fila[2]).'","departamento":"'.cv($fila[3]).'","cantidad":"'.$cantidad.'","tabla":"'.$cadenaAux.'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$nFilas++;
			}
		}
		echo '{"numReg":"'.$nFilas.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function registrarContratoAbierto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 9138_contratos(idProveedor,fechaInicio,fechaFin,condPago,concepto,fuenteFinanciamiento,
					tipoContrato,importeMaximo,importeMinimo,subtotal,iva,total,situacion,porcentajeMinimo,reglaSancion,aplicacionsancion)
					VALUES(".$obj->idProveedor.",NULL,NULL,".$obj->condicionPago.",'',NULL,1,".$obj->montoContratoMaximo.",".
					$obj->montoContratoMinimo.",".$obj->montoContratoMinimo.",0,".$obj->montoContratoMinimo.",1,".$obj->porcMinimo.",".
					$obj->reglaSancion.",".$obj->aplicacionSancion.")";

		$x++;
		
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		foreach($obj->montosContrato as $m)
		{
			$consulta[$x]="INSERT INTO 9139_detalleContrato(idContrato,mes,anio,montoMaximo,montoMinimo)
							VALUES(@idRegistro,".$m->mes.",NULL,".$m->maximo.",".$m->minimo.")";
			$x++;
		}
		$listPedidos="";
		foreach($obj->listProductos as $p)
		{
			$consulta[$x]="INSERT INTO 9138_conceptosContrato(idContrato,idPedidoEsperaContrato,montoMaximo,montoMinimo,descripcion,idMarca,
							idPresentacion,idContenedor,idUnidadMedida,considerarIva)	VALUES(@idRegistro,".$p->idPedidoEsperaContrato.",".$p->montoMaximo.",".$p->montoMinimo.",
							'".cv($p->descripcion)."',".$p->idMarca.",".$p->presentacion.",".$p->contenedor.",".$p->unidadMedida.",".$p->consideraIva.")";
			$x++;
			if($listPedidos=="")
			{
				$listPedidos=$p->idPedidoEsperaContrato;
			}
			else
				$listPedidos.=",".$p->idPedidoEsperaContrato;
		}
		$consulta[$x]="UPDATE 9101_pedidosEsperaContrato SET situacion=1 WHERE idPedidoEsperaContrato IN (".$listPedidos.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerProveedoresResolucionPartida()
	{
		global $con;
		$idPartida=$_POST["idPartida"];
		$situacion=$_POST["situacion"];
		$consulta="";

		switch($situacion)
		{
			case 3:
				$consulta="SELECT listPropuestas FROM 539_partidasEmpatadas p WHERE idPartida=".$idPartida;
				$listPropuestas=$con->obtenerValor($consulta);
				$consulta="SELECT id__405_tablaDinamica AS idProveedor,t.txtRazonSocial2,costo AS costoPropuesta FROM 536_propuestasProveedor p
						,_405_tablaDinamica t WHERE idPropuesta in (".$listPropuestas.") AND p.idProveedor=t.id__405_tablaDinamica";				
			break;
			case 4:
				$consulta="SELECT id__405_tablaDinamica AS idProveedor,t.txtRazonSocial2,costo AS costoPropuesta FROM 536_propuestasProveedor p
						,_405_tablaDinamica t WHERE idPartida=".$idPartida." AND p.idProveedor=t.id__405_tablaDinamica";		
			break;
		}
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'",registros:'.utf8_encode($arrObj).'}';
	}
	
	function registrarResolucionPartidaProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT idCompraVSProducto,idMarca FROM 529_licitaciones WHERE idProductoVSLicitacion=".$obj->idPartida;
		$fCompra=$con->obtenerPrimeraFila($query);
		$idProductoCompra=$fCompra[0];
		$idMarca=$fCompra[1];
		if($idMarca=="")
			$idMarca=0;

		
		$query="select * from 536_propuestasProveedor where idProveedor=".$obj->idProveedor." and idPartida=".$obj->idPartida;
		$fPropuesta=$con->obtenerPrimeraFila($query);
		$costoUnitario=$fPropuesta[5];
		$iva="";
		$subtotal="";
		$total="";
		$query="SELECT cantidad,objetoGasto FROM 527_concentradoProductoTipoCompra WHERE idCompraVSProducto=".$idProductoCompra;
		$fProducto=$con->obtenerPrimeraFila($query);
		$cantidad=$fProducto[0];
		$iva=0;
		$subtotal=$costoUnitario*$cantidad;
		$total=$subtotal+$iva;
		$idProveedor=$fPropuesta[1];
		$idProducto=$idProductoCompra;
		$idFormulario=$fPropuesta[8];
		$idRegistro=$fPropuesta[9];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$cadDetalle='{"tipoContrato":"0","porcentajeMinimo":"0","contenedor":"0","idMarca":"'.$idMarca.'","modelo":"'.cv($fPropuesta[4]).'","presentacion":"0","UnidadMedida":"0","cantidad":"'.$cantidad.'","costoUnitario":"'.$costoUnitario.'","iva":"'.$iva.'",
							"subtotal":"'.$subtotal.'","total":"'.$total.'","entregablesJava":"[]","entregablesPHP":[]}';
		
		$consulta[$x]="INSERT INTO 531_licitacionVSProveedorElegido(idProveedor,idProducto,idPedido,estado,idFormulario,idReferencia,detalles,idPartida,comentarios)
							VALUES(".$idProveedor.",".$idProducto.",0,0,".$idFormulario.",".$idRegistro.",'".($cadDetalle)."',".$obj->idPartida.",'".cv($obj->motivo)."')";
		$x++;
		
		if($obj->situacion==3)
		{
			$consulta[$x]="DELETE FROM 539_partidasEmpatadas WHERE idPartida=".$obj->idPartida;
			$x++;
		}
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	
?>