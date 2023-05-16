<?php session_start();
	include_once("conexionBD.php");
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			obtenerAsientosLibroConciliacion();
		break;
		
		case 2:
			obtenerProcesosJudiciales();
		break;
		case 3:
			obtenerArchivosImportacion();
		break;
		case 4:
			obtenerRegistrosImportados();
		break;
		case 5:
			obtenerMovimientosPeriodoConciliacion();
		break;
		case 6:
			registrarConciliacionMovimientos();
		break;
	}
	
	function obtenerAsientosLibroConciliacion()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];

		$arrRegistros="";
		$codigoUnidad=$_POST["codigoUnidad"];
		
		$consulta="SELECT count(*) FROM _1163_libroDepositosDespacho d WHERE d.codigoUnidad IN(".$codigoUnidad.
				")  order by fechaMovimiento and fechaMovimiento>='".$fechaInicio."' and fechaMovimiento<='".$fechaFin."' limit ".$start.",".$limit;
		$numReg=$con->obtenerValor($consulta);
		$consulta="SELECT d.*,o.unidad FROM _1163_libroDepositosDespacho d,817_organigrama o WHERE d.codigoUnidad IN(".$codigoUnidad.
				") and o.codigoUnidad=d.codigoUnidad and fechaMovimiento>='".$fechaInicio."' and fechaMovimiento<='".$fechaFin."'  order by fechaMovimiento limit ".$start.",".$limit;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$carpetaAdministrativaDestino="";
			$unidadDestino="";
			if($fila["carpetaAdministrativaTraspaso"]!="")
			{
				$carpetaAdministrativaDestino=$fila["carpetaAdministrativaTraspaso"];
				$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila["unidadTraspaso"]."'";
				$unidadDestino=$con->obtenerValor($consulta);
			}
			$o='{"idRegistro":"'.$fila["idRegistro"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","codigoUnidad":"'.cv($fila["unidad"]).
			'","fechaMovimiento":"'.$fila["fechaMovimiento"].'","numeroDeposito":"'.$fila["numeroDeposito"].'","abono":"'.($fila["naturalezaAfectacion"]==1?$fila["montoDeposito"]:0).
			'","cargo":"'.($fila["naturalezaAfectacion"]==-1?$fila["montoDeposito"]:0).'","tipoMovimiento":"'.$fila["tipoMovimiento"].
			'","fechaRegistro":"'.$fila["fechaRegistro"].'","conciliado":"'.$fila["conciliado"].'","fechaConciliacion":"'.$fila["fechaConciliacion"].
			'","carpetaAdministrativaDestino":"'.$carpetaAdministrativaDestino.'","codigoUnidadDestino":"'.cv($unidadDestino).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerProcesosJudiciales()
	{
		global $con;
		$arrRegistros="";
		$numReg=0;
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT idCarpeta,carpetaAdministrativa,fechaCreacion,idFormulario,idRegistro,(SELECT unidad FROM 817_organigrama WHERE 
					codigoUnidad=c.unidadGestion) AS despacho,c.unidadGestion FROM 7006_carpetasAdministrativas c WHERE unidadGestion in(".$codigoUnidad.")
					AND tipoCarpetaAdministrativa in(60,61) ORDER BY fechaCreacion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			if($fila["idFormulario"]==1163)
			{
				$consulta="SELECT cuantia FROM _1163_tablaDinamica WHERE id__1163_tablaDinamica=".$fila["idRegistro"];
				$valorObligacion=$con->obtenerValor($consulta);
			}
			
			if($fila["idFormulario"]==1204)
			{
				$consulta="SELECT montoCostes FROM _1204_tablaDinamica WHERE id__1204_tablaDinamica=".$fila["idRegistro"];
				$valorObligacion=$con->obtenerValor($consulta);
			}
			
			
			$consulta="SELECT SUM(montoDeposito) FROM _1163_libroDepositosDespacho WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"].
					"' AND codigoUnidad='".$fila["unidadGestion"]."' AND naturalezaAfectacion=1";
			$montoDepositado=$con->obtenerValor($consulta);
			
			$consulta="SELECT SUM(montoDeposito) FROM _1163_libroDepositosDespacho WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"].
					"' AND codigoUnidad='".$fila["unidadGestion"]."' AND naturalezaAfectacion=-1 and tipoMovimiento=2";
			$montoPagado=$con->obtenerValor($consulta);
			
			$consulta="SELECT SUM(montoDeposito) FROM _1163_libroDepositosDespacho WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"].
					"' AND codigoUnidad='".$fila["unidadGestion"]."' AND  naturalezaAfectacion=-1 and tipoMovimiento=3";
			$montoPrescrito=$con->obtenerValor($consulta);
			
			$consulta="SELECT SUM(montoDeposito) FROM _1163_libroDepositosDespacho WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"].
					"' AND codigoUnidad='".$fila["unidadGestion"]."' and  naturalezaAfectacion=-1 and tipoMovimiento=4";
			$montoTrasladado=$con->obtenerValor($consulta);
			
			$saldoActual=$valorObligacion-($montoDepositado-$montoTrasladado);	
			$o='{"idRegistro":"'.$fila["idCarpeta"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","valorObligacion":"'.$valorObligacion.'","codigoUnidad":"'.
			cv($fila["despacho"]).'","fechaCreacion":"'.$fila["fechaCreacion"].'","montoDepositado":"'.$montoDepositado.'","montoPagado":"'.$montoPagado.
			'","montoPrescrito":"'.$montoPrescrito.'","montoTrasladado":"'.$montoTrasladado.'","saldoActual":"'.$saldoActual.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerArchivosImportacion()
	{
		global $con;
		$consulta="SELECT idRegistro,nombreArchivo,periodo,fechaRegistro,responsableImportacion,totalMovimientos,
					totalDepositos,totalPagos,totalPrescritos,totalTraspasos,movimientosConciliados,movimientosSinConciliar ,periodo
					FROM _1163_archivosImportacionBAC ORDER BY idRegistro DESC";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$numReg.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerRegistrosImportados()
	{
		global $con;
		$idImportacion=$_POST["idImportacion"];
		$tipoRegistros=$_POST["tipoRegistros"];
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM _1163_registrosImportacion WHERE idRegistroArchivoImportacion=".$idImportacion;
		if($tipoRegistros!=-1)
		{
			$consulta.=" and conciliado=".$tipoRegistros;
		}
		
		$consulta.=" ORDER BY noMovimiento";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o='{"idRegistro":"'.$fila["idRegistroImportacion"].'","noMovimiento":"'.$fila["noMovimiento"].
			'","numeroDeposito":"'.$fila["numeroDeposito"].'","fechaMovimiento":"'.$fila["fechaMovimiento"].
			'","valorDeposito":"'.$fila["montoDeposito"].'","comentarios":"'.cv($fila["comentarios"]).'","conciliado":"'.
			$fila["conciliado"].'","tipoMovimiento":"'.$fila["tipoMovimiento"].'","idRegistroConciliado":"'.$fila["idRegistroConciliado"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
														
														
																
	}
	
	function obtenerMovimientosPeriodoConciliacion()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];

		$arrRegistros="";
		$codigoUnidad=$_POST["codigoUnidad"];
		$tipoRegistros=$_POST["tipoRegistros"];
		
		if($codigoUnidad==0)
		{
			$consulta="SELECT claveUnidad FROM _17_tablaDinamica";
			$codigoUnidad=$con->obtenerListaValores($consulta,"'");
		}
			
		

		$consulta="SELECT count(*) FROM _1163_libroDepositosDespacho d WHERE d.codigoUnidad IN(".$codigoUnidad.
				")   and fechaMovimiento>='".$fechaInicio."' and fechaMovimiento<='".$fechaFin."' order by fechaMovimiento";
				
		if($tipoRegistros!=-1)
		{
			$consulta.=" and conciliado=".$tipoRegistros;
		}
				
		$consulta.=" limit ".$start.",".$limit;
		$numReg=$con->obtenerValor($consulta);
		$consulta="SELECT d.*,o.unidad FROM _1163_libroDepositosDespacho d,817_organigrama o WHERE d.codigoUnidad IN(".$codigoUnidad.
				") and o.codigoUnidad=d.codigoUnidad and fechaMovimiento>='".$fechaInicio."' and fechaMovimiento<='".$fechaFin.
				"'";
		if($tipoRegistros!=-1)
		{
			$consulta.=" and conciliado=".$tipoRegistros;
		}		
				
		$consulta.=" order by idRegistro limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$carpetaAdministrativaDestino="";
			$unidadDestino="";
			if($fila["carpetaAdministrativaTraspaso"]!="")
			{
				$carpetaAdministrativaDestino=$fila["carpetaAdministrativaTraspaso"];
				$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila["unidadTraspaso"]."'";
				$unidadDestino=$con->obtenerValor($consulta);
			}
			$o='{"idRegistro":"'.$fila["idRegistro"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","codigoUnidad":"'.cv($fila["unidad"]).
			'","fechaMovimiento":"'.$fila["fechaMovimiento"].'","numeroDeposito":"'.$fila["numeroDeposito"].'","abono":"'.($fila["naturalezaAfectacion"]==1?$fila["montoDeposito"]:0).
			'","cargo":"'.($fila["naturalezaAfectacion"]==-1?$fila["montoDeposito"]:0).'","tipoMovimiento":"'.$fila["tipoMovimiento"].
			'","fechaRegistro":"'.$fila["fechaRegistro"].'","conciliado":"'.$fila["conciliado"].'","fechaConciliacion":"'.$fila["fechaConciliacion"].
			'","carpetaAdministrativaDestino":"'.$carpetaAdministrativaDestino.'","codigoUnidadDestino":"'.cv($unidadDestino).
			'","montoOriginal":"'.$fila["montoOriginal"].'","fechaMovimientoOriginal":"'.$fila["fechaMovimientoOriginal"].
			'","numeroDepositoOriginal":"'.$fila["numeroDepositoOriginal"].'","naturalezaAfectacion":"'.$fila["naturalezaAfectacion"].
			'","idRegistroConciliado":"'.$fila["idRegistroConciliacion"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarConciliacionMovimientos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$consulta="SELECT * FROM _1163_registrosImportacion WHERE idRegistroImportacion=".$obj->idRegistroImportado;
		$fImportado=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoOriginal=montoDeposito,
					fechaMovimientoOriginal=fechaMovimiento,numeroDepositoOriginal=numeroDeposito 
					WHERE idRegistro=".$obj->idMovimiento;
		$x++;
		$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoDeposito=".$fImportado["montoDeposito"].",
					fechaMovimiento='".$fImportado["fechaMovimiento"]."',numeroDeposito ='".$fImportado["numeroDeposito"]."',conciliado=1,
					fechaConciliacion='".date("Y-m-d H:i:s")."',responsableConciliacion=".$_SESSION["idUsr"].
					",idRegistroConciliacion=".$obj->idRegistroImportado." WHERE idRegistro=".$obj->idMovimiento;
		$x++;
		$query[$x]="UPDATE _1163_registrosImportacion SET conciliado=1,idRegistroConciliado=".$obj->idMovimiento." WHERE idRegistroImportacion=".$obj->idRegistroImportado;
		$x++;
		
		$query[$x]="UPDATE _1163_archivosImportacionBAC SET movimientosConciliados=movimientosConciliados+1,
					movimientosSinConciliar=movimientosSinConciliar-1 WHERE idRegistro=".$fImportado["idRegistroArchivoImportacion"];
		$x++;
		
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
?>