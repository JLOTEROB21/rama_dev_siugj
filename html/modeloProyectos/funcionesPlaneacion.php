<?php session_start();
	include("conexionBD.php");
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
				$query="select numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastociclo=".$idRegistroObjeto;
				$numEtapa=$con->obtenerValor($query);
				$incUnidad=0;
				if($numEtapa>1)
				{
				
					$consulta[$x]="INSERT INTO 9110_objetosGastoVSCicloHistorico(idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,responsableModif,fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,comentarios)
									SELECT idCodigoGastoCiclo,idProducto,cantidad,idProveedorSugerido,'".$_SESSION["idUsr"]."' AS responsableModif,'".date('Y-m-d')."' AS fechaModif,costoUnitario,montoTotal,tipoPresupuesto,VERSION,'' AS comentarios from 9110_objetosGastoVSCiclo where 
									idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;
					$consulta[$x]="INSERT INTO 9111_cantidaObjVSMesHistorico(idCodigoGastoCicloHistorico,mes,cantidad) SELECT (SELECT LAST_INSERT_ID()) AS idCodigoGastoCicloHistorico,mes,cantidad FROM 9111_cantidaObjVSMes
									WHERE idCodigoGastoCiclo=".$idRegistroObjeto;
					$x++;	
					$incUnidad=1;
				}
						
				$consulta[$x]="DELETE FROM 9111_cantidaObjVSMes WHERE idCodigoGastociclo=".$idRegistroObjeto;
				$x++;
				
				$consulta[$x]=	"UPDATE 9110_objetosGastoVSCiclo SET version=version+".$incUnidad.",cantidad=".$obj->cantidad.",justificacion='".cv($obj->justificacion)."',idProveedorSugerido=".$idProveedor.",observaciones='".cv($obj->observaciones).
								"',responsableModif=".$_SESSION["idUsr"].",fechaUltimaModif='".date('Y-m-d')."',costoUnitario=".$obj->costoUnitario.",montoTotal=".$obj->costoTotal.",tipoPresupuesto=".$obj->tipoPresupuesto." WHERE idCodigoGastociclo=".$idRegistroObjeto;
				$x++;
			}
			else
			{
				$query="SELECT objetoGasto FROM 9101_CatalogoProducto WHERE idProducto=".$obj->idProducto;
				$clave=$con->obtenerValor($query);
				$query="	INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,tipoPresupuesto)
								VALUES(".$clave.",".$obj->idCiclo.",'".$obj->codDepto."','".$obj->codInstitucion."',".$obj->idProducto.",".$obj->cantidad.",'".cv($obj->justificacion)."',".
								$idProveedor.",'".cv($obj->observaciones)."',".$obj->idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$obj->costoUnitario.",".$obj->costoTotal.",".$obj->tipoPresupuesto.")";

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
				$consulta[$x]="insert into 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad) values(".$idRegistroObjeto.",".$ct.",".$arrMeses[$ct].")";
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
		$ciclo=bD($_POST["ciclo"]);
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
		
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idCiclo=".$ciclo." AND codDepto=".$codDepto." AND idPrograma=".$programa;
		$listProductos=$con->obtenerListaValores($consulta);
		if($listProductos=="")
			$listProductos="-1";
		$consulta="select idProducto,nombreProducto,descripcion,".$costo." from 9101_CatalogoProducto p  where (".$cadCapitulos.") and 
					nombreProducto like '".$criterio."%' and idProducto not in (".$listProductos.")  order by nombreProducto limit ".$inicio.",".$cantidad;

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
		$consulta="select idProducto,nombreProducto from 9101_CatalogoProducto  where objetoGasto in(".$capitulos.") and status_art=1 and nombreProducto like '".$criterio."%' and idProducto not in (".$listProductos.")";
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
			$query="select idCodigoGastociclo,numEtapa from 9110_objetosGastoVSCiclo where idCodigoGastociclo in(".$idRegistroObjeto.")";
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
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
		
		$consulta="SELECT idCodigoGastoCiclo,idProducto,cantidad,idCiclo FROM 9110_objetosGastoVSCiclo WHERE idProducto=".$idProducto." AND idCiclo<>".$idCiclo." AND idPrograma=".$idPrograma." AND codDepto='".$codDepartamento."'";	

		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		if($nFilas>0)
		{
			$conNombre="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$idProducto;
			$nombre=$con->obtenerValor($conNombre);
			
			while($filaM=mysql_fetch_row($res))
			{
				$conMeses="SELECT mes,cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$filaM[0]." ORDER BY mes";
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
		
		$consulta="select idProducto from 9110_objetosGastoVSCiclo where idCiclo=".$ciclo." AND codDepto=".$codDepto." AND idPrograma=".$programa;
		$listProductos=$con->obtenerListaValores($consulta);
		if($listProductos=="")
			$listProductos="-1";
		
		$consulta="SELECT cp.idProducto,o.codigoControlPadre,CONCAT('[',cp.0bjetoGasto,'] ',o.nombreObjetoGasto) AS 'nombreObjetoGasto',cp.nombreProducto,cp.descripcion 
						FROM 9101_CatalogoProducto cp,507_objetosGasto o  
						WHERE o.clave=cp.0bjetoGasto AND ".$cadCapitulos." ".$condWhere." and cp.idProducto not in (".$listProductos.") and cp.status_art=1 order by nombreProducto limit ".$inicio." ,".$cantidad;		
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
		while($filaEtapa=mysql_fetch_row($resEtapas))
		{
			$permisos="";
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND idProceso=".$idProceso." AND tipoActor=1 and numEtapa=".$filaEtapa[0];
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
		}
		
		$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$actor."' AND tipoActor=1 AND idProceso=".$idProceso." AND numEtapa=1";
		$filaActor=$con->obtenerPrimeraFila($consulta);
		if(!$filaActor)
			$condFiltro.=" and numEtapa=".$etapa;
		
		$consulta="SELECT idCodigoGastoCiclo,c.clave,CONCAT('[',c.clave,']',nombreObjetoGasto) AS nombreObj,idCiclo,p.nombreProducto,
					justificacion,c.cantidad,c.observaciones,costoUnitario as costo,p.descripcion, org.unidad,montoTotal,c.modificable,
					(SELECT nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=c.numEtapa) as etapa,
					(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=c.idPrograma) as programa,
					(select Nombre from 800_usuarios where idUsuario=c.idResponsable) as responsableSolicitud,
					(select tituloTipoP from 508_tiposPresupuesto where idTipoPresupuesto=c.tipoPresupuesto) as tipoPresupuesto,version,c.numEtapa
			   FROM 9110_objetosGastoVSCiclo c,507_objetosGasto o,9101_CatalogoProducto p,817_organigrama org 
			   WHERE idCiclo=".$idCiclo.$condFiltro." AND org.codigoUnidad=c.codDepto  AND c.clave=o.clave AND 
			   ".$cadCapitulos." and p.idProducto=c.idProducto ".$condWhere." order by nombreProducto limit ".$inicio.",".$cantidad;

		$res=$con->obtenerFilas($consulta);
		$consulta="SELECT count(idCodigoGastoCiclo)
			   FROM 9110_objetosGastoVSCiclo c
			   WHERE idCiclo=".$idCiclo.$condFiltro."  AND 
			   ".$cadCapitulos." ".$condWhere;
		   
		$numRegistros=$con->obtenerValor($consulta);
		$arrDatos='';
		while($fila=mysql_fetch_row($res))
		{
			$conCantidades="SELECT mes,cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
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
					'","programa":"'.$fila[14].'","responsableSolicitud":"'.$fila[15].'","tipoPresupuesto":"'.$fila[16].'","version":"'.$fila[17].'","permisos":"'.$arrPermisosEtapa[removerCerosDerecha($fila[18])].'","numEtapa":"'.$fila[18].'"}';
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
	
	function obtenerRequisicionesHistoricas()
	{
		global $con;
		$cicloActual=bD($_POST["ciclo"]);
		$codDepartamento=bD($_POST["codigoUnidad"]);
		$idPrograma=bD($_POST["idPrograma"]);
		$consulta="select distinct idCiclo from 9110_objetosGastoVSCiclo where idCiclo<>".$cicloActual." and codDepto='".$codDepartamento."' and idPrograma=".$idPrograma." order by idCiclo desc";
		$resCiclos=$con->obtenerFilas($consulta);	
		$arrCiclos="";
		while($filaCiclo=mysql_fetch_row($resCiclos))
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
		$arrCapitulos=explode(",",$capitulos);
		$cadCapitulos="";
		global $con;
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
			$particula="(clave>=".$c." and clave<=".$cFin.")";	
			if($cadCapitulos=="")
				$cadCapitulos=$particula;	
			else
				$cadCapitulos.=" or ".$particula;	
		}
		
		$query="delete FROM 9110_objetosGastoVSCiclo  WHERE idCiclo=".$cicloDestino." AND codDepto='".$codigoDepto."' and idPrograma=".$idPrograma;
		
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;	
		}
		
		$query="SELECT * FROM 9110_objetosGastoVSCiclo c WHERE 
				idCiclo=".$cicloOrigen." AND codDepto='".$codigoDepto."' and idPrograma=".$idPrograma." and ".$cadCapitulos;
		$resProductos=$con->obtenerFilas($query);
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			
			while($fila=mysql_fetch_row($resProductos))
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
					$query="	INSERT INTO 9110_objetosGastoVSCiclo(clave,idCiclo,codDepto,codInstitucion,idProducto,cantidad,justificacion,
								idProveedorSugerido,observaciones,idPrograma,idResponsable,fechaSolicitud,costoUnitario,montoTotal,numEtapa,modificable,tipoPresupuesto,situacion)
										VALUES(".$clave.",".$cicloDestino.",'".$codigoDepto."','".$fila[4]."',".$fila[5].",".$fila[6].",'',".
										$idProveedor.",'',".$idPrograma.",".$_SESSION["idUsr"].",'".date("Y-m-d")."',".$costo.",".($costo*$fila[6]).",1,1,".$fila[19].",1)";
					
					if(!$con->ejecutarConsulta($query))
					{
						$query="rollback";
						$con->ejecutarConsulta($query);
						echo "|";
						return;
					}
					$idRegistro=$con->obtenerUltimoID();
					
					$query="SELECT mes,cantidad FROM 9111_cantidaObjVSMes WHERE idCodigoGastoCiclo=".$fila[0]." order by mes";
					
					$resMes=$con->obtenerFilas($query);
					while($filaMes=mysql_fetch_row($resMes))
					{
						$query="insert into 9111_cantidaObjVSMes(idCodigoGastoCiclo,mes,cantidad) values(".$idRegistro.",".$filaMes[0].",".$filaMes[1].")";
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
					u.Nombre,DATE_FORMAT(fechaModif,'%d/%m/%Y') AS fechaModif FROM
					9110_objetosGastoVSCicloHistorico h,800_usuarios u WHERE u.idUsuario=h.responsableModif AND idCodigoGastoCiclo=".$idRegistroObjeto.
					" ORDER BY VERSION desc";	
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$conCantidades="SELECT mes,cantidad FROM 9111_cantidaObjVSMesHistorico WHERE idCodigoGastoCicloHistorico=".$fila[0]." order by mes";
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
			$obj='{"idCodigo":"'.$fila[0].'","cantidad":"'.cv($fila[2]).'","cadenaMeses":"'.cv($cadenaAux).'","costoUnitario":"'.cv($fila[3]).
					'","costoTotal":"'.($fila[4]).'","comentarios":"'.cv($fila[6]).'","responsableCambio":"'.$fila[8].'","fechaCambio":"'.$fila[9].
					'","proveedorSugerido":"'.$fila[7].'","tipoPresupuesto":"'.$fila[5].'","version":"'.$fila[1].'"}';
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
		while($fila=mysql_fetch_row($res))
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
		$idProceso=$_POST["idProceso"];
		$consulta="select idResponsablePAT as idAsignacion,(select unidad from 817_organigrama where codigoUnidad=r.codigoDepto) as departamento,r.codigoDepto as codDepto,
					idPrograma,(SELECT tituloPrograma FROM 517_programas WHERE idPrograma=r.idPrograma) as programa,
					idResponsable,(select Nombre from 800_usuarios where idUsuario=r.idResponsable) as responsable from 9116_responsablesPAT r 
					where idProceso=".$idProceso." order by departamento";	
		$arrRegistros=utf8_encode($con->obtenerFilasJson($consulta));
		echo '{"registros":'.$arrRegistros.'}';
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
				$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad 
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp."  and  Paterno like '".$criterio."%'   order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp." and  Materno like '".$criterio."%' order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,a.codigoUnidad,o.unidad 
				from 802_identifica i,801_adscripcion a ,817_organigrama o 
				where o.codigoUnidad=a.codigoUnidad and a.idUsuario=i.idUsuario ".$comp." and Nom like '".$criterio."%' order by Nom,Paterno,Materno asc)";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
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
		$consulta="INSERT INTO 9116_responsablesPAT(codigoDepto,idPrograma,idProceso,idResponsable,rolActor)
					VALUES('".$obj->depto."','".$obj->programa."',".$obj->idProceso.",".$obj->idUsuario.",'".str_replace("|","_",$obj->rolAsigna)."')";
		eC($consulta);						
	}
	?>
	