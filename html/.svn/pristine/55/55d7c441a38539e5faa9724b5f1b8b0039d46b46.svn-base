<?php
	function asignarDespachoDeposito($idFormulario,$idRegistro)
	{
		global $con;
		$consulta="SELECT carpetaAdministrativa FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		$consulta="SELECT codigoInstitucion FROM _1163_tablaDinamica WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$codigoInstitucion=$con->obtenerValor($consulta);
		
		
		$consulta="UPDATE _1162_tablaDinamica SET codigoInstitucion='".$codigoInstitucion."' WHERE id__1162_tablaDinamica=".$idRegistro;
		return $con->ejecutarConsulta($consulta);
		
		
	}
	
	function asentarDepositosPagoConsignacion($idFormulario,$idRegistro)
	{
		global $con;
		$x=0;
		
		
		$consulta="SELECT carpetaAdministrativa FROM _1163_tablaDinamica WHERE id__1163_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY idCarpeta DESC";
		$unidadGestion=$con->obtenerValor($consulta);
		$query[$x]="begin";
		$x++;
		$consulta="SELECT numeroDepositoJudicial,fechaOperacion,montoOperacion FROM _1163_DepositoJudicial WHERE idReferencia=".$idRegistro." ORDER BY fechaOperacion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$llaveEntrada=bE($fila["numeroDepositoJudicial"]."_1_1");
			
			$consultaLlave="select count(*) from _1163_libroDepositosDespacho where llaveEntrada='".$llaveEntrada."'";
			$numRegLlave=$con->obtenerValor($consultaLlave);
			if($numRegLlave==0)
			{
				$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
							montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro,llaveEntrada)
							VALUES('".$carpetaAdministrativa."','".$unidadGestion."','".$fila["numeroDepositoJudicial"]."',".
							$fila["montoOperacion"].",'".$fila["fechaOperacion"]."',1,1,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].
							",'".$llaveEntrada."')";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;

		return $con->ejecutarBloque($query);
		
	}
	
	function asentarDepositosRegistrado($idFormulario,$idRegistro)
	{
		global $con;
		$x=0;
		

		$consulta="SELECT * FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$idRegistro;
		$fRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fRegistroCarpeta["carpetaAdministrativa"];
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY idCarpeta DESC";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$query[$x]="begin";
		$x++;
		$llaveEntrada=bE($fRegistroCarpeta["numeroDeposito"]."_1_1");
			
		$consultaLlave="select count(*) from _1163_libroDepositosDespacho where llaveEntrada='".$llaveEntrada."'";
		$numRegLlave=$con->obtenerValor($consultaLlave);
		if($numRegLlave==0)
		{
		
		
		
			$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
							montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro,llaveEntrada)
							VALUES('".$carpetaAdministrativa."','".$unidadGestion."','".$fRegistroCarpeta["numeroDeposito"]."',".
							$fRegistroCarpeta["montoDeposito"].",'".$fRegistroCarpeta["fechaDeposito"]."',1,1,'".date("Y-m-d H:i:s").
							"',".$_SESSION["idUsr"].",'".$llaveEntrada."')";
			$x++;
		}
		$query[$x]="commit";
		$x++;

		return $con->ejecutarBloque($query);
		
	}
	
	function asentarDepositosPrescrito($idFormulario,$idRegistro)
	{
		global $con;
		$x=0;
		

		$consulta="SELECT * FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$idRegistro;
		$fRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fRegistroCarpeta["numeroDeposito"]."' AND tipoMovimiento in(1,4) 
								and naturalezaAfectacion=1 and situacionActual=1 order by tipoMovimiento desc";
		$fRegistroDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$carpetaAdministrativa=$fRegistroDeposito["carpetaAdministrativa"];
		$unidadGestion=$fRegistroDeposito["codigoUnidad"];//$con->obtenerValor($consulta);
		
		
		$query[$x]="begin";
		$x++;
		
		
		$llaveEntrada=bE($fRegistroCarpeta["numeroDeposito"]."_-1_3");
			
		$consultaLlave="select count(*) from _1163_libroDepositosDespacho where llaveEntrada='".$llaveEntrada."'";
		$numRegLlave=$con->obtenerValor($consultaLlave);
		if($numRegLlave==0)
		{
		
			$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
							montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro,llaveEntrada)
							VALUES('".$carpetaAdministrativa."','".$unidadGestion."','".$fRegistroCarpeta["numeroDeposito"]."',".
							$fRegistroCarpeta["montoDeposito"].",'".$fRegistroCarpeta["fechaDeposito"]."',-1,3,'".date("Y-m-d H:i:s").
							"',".$_SESSION["idUsr"].",'".$llaveEntrada."')";
			$x++;
			$query[$x]="set @idRegistroLibro:=(select last_insert_id())";
			$x++;
		}
		$query[$x]="commit";
		$x++;
		return $con->ejecutarBloque($query);
		
	}
	
	function asentarDepositosPagado($idFormulario,$idRegistro)
	{
		global $con;
		$x=0;
		

		$consulta="SELECT * FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$idRegistro;
		$fRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fRegistroCarpeta["numeroDeposito"]."' AND tipoMovimiento in(1,4) 
								and naturalezaAfectacion=1 and situacionActual=1 order by tipoMovimiento desc";
		$fRegistroDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$carpetaAdministrativa=$fRegistroDeposito["carpetaAdministrativa"];
		//$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY idCarpeta DESC";
		$unidadGestion=$fRegistroDeposito["codigoUnidad"];//$con->obtenerValor($consulta);
		
		$query[$x]="begin";
		$x++;
		$llaveEntrada=bE($fRegistroCarpeta["numeroDeposito"]."_-1_2");
			
		$consultaLlave="select count(*) from _1163_libroDepositosDespacho where llaveEntrada='".$llaveEntrada."'";
		$numRegLlave=$con->obtenerValor($consultaLlave);
		if($numRegLlave==0)
		{
			$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
							montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro,llaveEntrada)
							VALUES('".$carpetaAdministrativa."','".$unidadGestion."','".$fRegistroCarpeta["numeroDeposito"]."',".
							$fRegistroCarpeta["montoDeposito"].",'".$fRegistroCarpeta["fechaDeposito"]."',-1,2,'".date("Y-m-d H:i:s").
							"',".$_SESSION["idUsr"].",'".$llaveEntrada."')";
			$x++;
		}
		$query[$x]="set @idRegistroLibro:=(select last_insert_id())";
		$x++;
		
		$query[$x]="commit";
		$x++;
		return $con->ejecutarBloque($query);
		
	}
	
	function asentarDepositosTrasladado($idFormulario,$idRegistro)
	{
		global $con;
		$x=0;
		

		$consulta="SELECT * FROM _1186_tablaDinamica WHERE id__1186_tablaDinamica=".$idRegistro;
		$fRegistroTraslado=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fRegistroTraslado["carpetaAdministrativa"];
		$carpetaAdministrativaDestino=$fRegistroTraslado["carpetaAdministrativa2aInstancia"];
		$depositoJudicial=$fRegistroTraslado["depositoJudicial"];
		
		
		
		
		$consulta="SELECT * FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$depositoJudicial;
		$fDatosDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="select * from _1163_libroDepositosDespacho where numeroDeposito='".
					$fDatosDeposito["numeroDeposito"]."' and conciliado=1";

		$fInfoConciliado=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' ORDER BY idCarpeta DESC";
		$unidadGestion=$con->obtenerValor($consulta);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaDestino."' ORDER BY idCarpeta DESC";
		$unidadGestionDestino=$con->obtenerValor($consulta);
	
		
		
		$query[$x]="begin";
		$x++;
		
		$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
						montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro,
						carpetaAdministrativaTraspaso,unidadTraspaso)
						VALUES('".$carpetaAdministrativa."','".$unidadGestion."','".$fDatosDeposito["numeroDeposito"]."',".
						$fDatosDeposito["montoDeposito"].",'".$fDatosDeposito["fechaDeposito"]."',-1,4,'".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].",'".$carpetaAdministrativaDestino."','".$unidadGestionDestino."')";
		$x++;
		$query[$x]="set @idRegistroLibroSalida:=(select last_insert_id())";
		$x++;
		$query[$x]="UPDATE _1163_libroDepositosDespacho SET situacionActual=0 where numeroDeposito='".
					$fDatosDeposito["numeroDeposito"]."' and naturalezaAfectacion=1 and situacionActual=1";
		$x++;
		
		$query[$x]="INSERT INTO _1163_libroDepositosDespacho(carpetaAdministrativa,codigoUnidad,numeroDeposito,
						montoDeposito,fechaMovimiento,naturalezaAfectacion,tipoMovimiento,fechaRegistro,responsableRegistro)
						VALUES('".$carpetaAdministrativaDestino."','".$unidadGestionDestino."','".$fDatosDeposito["numeroDeposito"]."',".
						$fDatosDeposito["montoDeposito"].",'".$fDatosDeposito["fechaDeposito"]."',1,4,'".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].")";
		$x++;
		$query[$x]="set @idRegistroLibro:=(select last_insert_id())";
		$x++;
		if($fInfoConciliado)
		{
			$query[$x]="UPDATE _1163_libroDepositosDespacho SET conciliado=1,fechaConciliacion='".$fInfoConciliado["fechaConciliacion"].
						"',responsableConciliacion='".$fInfoConciliado["responsableConciliacion"]."',idRegistroConciliacion='".$fInfoConciliado["idRegistroConciliacion"].
						"' WHERE idRegistro=@idRegistroLibro";
			$x++;
			$query[$x]="UPDATE _1163_libroDepositosDespacho SET conciliado=1,fechaConciliacion='".$fInfoConciliado["fechaConciliacion"].
						"',responsableConciliacion='".$fInfoConciliado["responsableConciliacion"]."',idRegistroConciliacion='".$fInfoConciliado["idRegistroConciliacion"].
						"' WHERE idRegistro=@idRegistroLibroSalida";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		return $con->ejecutarBloque($query);
		
	}
	
	function importacionArchivoDeposito($nombreArchivo,$nombreOriginal)
	{
		global $con;
		$idRegistroImportacion=-1;
		$arrNombreArchivo=explode("/",$nombreArchivo);
		$nArhivo=$arrNombreArchivo[count($arrNombreArchivo)-1];
		$arrMeses["Enero"]="1";
		$arrMeses["Febrero"]="2";
		$arrMeses["Marzo"]="3";
		$arrMeses["Abril"]="4";
		$arrMeses["Mayo"]="5";
		$arrMeses["Junio"]="6";
		$arrMeses["Julio"]="7";
		$arrMeses["Agosto"]="8";
		$arrMeses["Septiembre"]="9";
		$arrMeses["Octubre"]="10";
		$arrMeses["Noviembre"]="11";
		$arrMeses["Diciembre"]="12";
		
	
		$totalMovimientos=0;
		$totalDepositos=0;
		$totalPagados=0;
		$totalPrescritos=0;
		$totalTraspasos=0;
		
		$libro=new cExcel($nombreArchivo,true,"Excel2007");
		
		$periodo=$arrMeses[$libro->getValor("F15")];
		
		
		$fechaConciliacion=$libro->getValor("F17");
		$fechaConciliacion=cambiaraFechaMysql($fechaConciliacion);
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO _1163_archivosImportacionBAC(nombreArchivo,fechaRegistro,responsableImportacion,fechaConciliacion)
							VALUES('".cv($nombreOriginal)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".$fechaConciliacion."')";
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		$libro->cambiarHojaActiva(1);
		$numLinea=5;
		$lineaVacia=false;
		$noMovimiento=1;
		while(!$lineaVacia)
		{
			$numeroDeposito=$libro->getValor("A".$numLinea);
			$monto=$libro->getValor("C".$numLinea);
			$comentarios=$libro->getValor("D".$numLinea);
			if($numeroDeposito!="")
			{
				$fechaMovimiento=cambiaraFechaMysql($libro->getValor("B".$numLinea));
			
				//$fechaMovimiento=date("Y-m-d",strtotime($fechaMovimiento));
				$query[$x]="INSERT INTO _1163_registrosImportacion(idRegistroArchivoImportacion,noMovimiento,numeroDeposito,fechaMovimiento,montoDeposito,comentarios,tipoMovimiento,conciliado)
							VALUES(@idRegistro,".$noMovimiento.",'".$numeroDeposito."','".$fechaMovimiento."',".$monto.",'".cv($comentarios)."',1,0)";
				$x++;
				$totalMovimientos++;
				$numLinea++;
				$noMovimiento++;
				$totalDepositos++;
				
			}
			else
				$lineaVacia=true;
				
			
		}
		
		$libro->cambiarHojaActiva(2);
		$numLinea=5;
		$lineaVacia=false;
		$noMovimiento=1;
		while(!$lineaVacia)
		{
			$numeroDeposito=$libro->getValor("A".$numLinea);
			$monto=$libro->getValor("C".$numLinea);
			$comentarios=$libro->getValor("D".$numLinea);
			if($numeroDeposito!="")
			{
				$fechaMovimiento=cambiaraFechaMysql($libro->getValor("B".$numLinea));
			
				
	
				$query[$x]="INSERT INTO _1163_registrosImportacion(idRegistroArchivoImportacion,noMovimiento,numeroDeposito,fechaMovimiento,montoDeposito,comentarios,tipoMovimiento,conciliado)
							VALUES(@idRegistro,".$noMovimiento.",'".$numeroDeposito."','".$fechaMovimiento."',".$monto.",'".cv($comentarios)."',2,0)";
				$x++;
				$totalMovimientos++;
				$numLinea++;
				$noMovimiento++;
				$totalPagados++;
				
			}
			else
				$lineaVacia=true;
				
			
		}
		
		$libro->cambiarHojaActiva(3);
		$numLinea=5;
		$lineaVacia=false;
		$noMovimiento=1;
		while(!$lineaVacia)
		{
			$numeroDeposito=$libro->getValor("A".$numLinea);
			$monto=$libro->getValor("C".$numLinea);
			$comentarios=$libro->getValor("D".$numLinea);
			if($numeroDeposito!="")
			{
				$fechaMovimiento=cambiaraFechaMysql($libro->getValor("B".$numLinea));
			
	
				$query[$x]="INSERT INTO _1163_registrosImportacion(idRegistroArchivoImportacion,noMovimiento,numeroDeposito,fechaMovimiento,montoDeposito,comentarios,tipoMovimiento,conciliado)
							VALUES(@idRegistro,".$noMovimiento.",'".$numeroDeposito."','".$fechaMovimiento."',".$monto.",'".cv($comentarios)."',3,0)";
				$x++;
				$totalMovimientos++;
				$numLinea++;
				$noMovimiento++;
				$totalPrescritos++;
			}
			else
				$lineaVacia=true;
				
			
		}
		
		$query[$x]="UPDATE _1163_archivosImportacionBAC SET periodo=".$periodo.",totalMovimientos=".$totalMovimientos.",totalDepositos=".$totalDepositos.",totalPagos=".$totalPagados.
					",totalPrescritos=".$totalPrescritos.",totalTraspasos=".$totalTraspasos.",movimientosConciliados=0,movimientosSinConciliar=0 
					WHERE idRegistro=@idRegistro";
		$x++;
		$query[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($query))
		{
			$arrCambiosEtapas=array();
			$x=0;
			$query=array();
			$query[$x]="begin";
			$x++;
			$consulta="select @idRegistro";
			$idRegistro=$con->obtenerValor($consulta);	
			
			$consulta="SELECT * FROM _1163_registrosImportacion WHERE idRegistroArchivoImportacion=".$idRegistro;
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_assoc($res))
			{
				$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fila["numeroDeposito"]."' AND conciliado=0";
				$rConciliacion=$con->obtenerFilas($consulta);
				while($fConciliacion=mysql_fetch_assoc($rConciliacion))
				{
					$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoDeposito=".$fila["montoDeposito"].",fechaMovimiento='".$fila["fechaMovimiento"].
						"',montoOriginal=".$fConciliacion["montoDeposito"].
						",fechaMovimientoOriginal='".$fConciliacion["fechaMovimiento"]."',numeroDepositoOriginal='".$fConciliacion["numeroDeposito"].
						"' WHERE idRegistro=".$fConciliacion["idRegistro"];
					$x++;
				}
				switch($fila["tipoMovimiento"])
				{
					case 1:
						$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fila["numeroDeposito"]."' AND tipoMovimiento in(1,4) 
								and naturalezaAfectacion=1 order by tipoMovimiento desc";
						$fRegistroDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
						if($fRegistroDeposito)
						{
							$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoDeposito=".$fila["montoDeposito"].",fechaMovimiento='".$fila["fechaMovimiento"].
									"',conciliado=1,fechaConciliacion='".date("Y-m-d H:i:s")."',responsableConciliacion=".$_SESSION["idUsr"].
									",idRegistroConciliacion=".$fila["idRegistroImportacion"].",montoOriginal=".$fRegistroDeposito["montoDeposito"].
									",fechaMovimientoOriginal='".$fRegistroDeposito["fechaMovimiento"]."',numeroDepositoOriginal='".$fila["numeroDeposito"].
									"' WHERE numeroDeposito='".$fila["numeroDeposito"]."' AND naturalezaAfectacion=1 AND tipoMovimiento IN(1,4)";
							$x++;
							$query[$x]="UPDATE _1163_registrosImportacion SET conciliado=1,idRegistroConciliado=".$fRegistroDeposito["idRegistro"].
										" WHERE idRegistroImportacion=".$fila["idRegistroImportacion"];
							$x++;
						}
					break;
					case 2:
					
						
						$consulta="SELECT * FROM _1162_tablaDinamica WHERE numeroDeposito='".$fila["numeroDeposito"]."'";
						$fDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
						if($fDeposito)
						{
							cambiarEtapaFormulario(1162,$fDeposito["id__1162_tablaDinamica"],10,"",-1,"NULL","NULL",0);
							
							$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fila["numeroDeposito"]."' AND tipoMovimiento=2";
							$fRegistroDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
	
							if($fRegistroDeposito)
							{
								$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoDeposito=".$fila["montoDeposito"].",fechaMovimiento='".$fila["fechaMovimiento"].
								"',conciliado=1,fechaConciliacion='".date("Y-m-d H:i:s")."',responsableConciliacion=".$_SESSION["idUsr"].
								",idRegistroConciliacion=".$fila["idRegistroImportacion"].",montoOriginal=".$fRegistroDeposito["montoDeposito"].
								",fechaMovimientoOriginal='".$fRegistroDeposito["fechaMovimiento"]."',numeroDepositoOriginal='".$fila["numeroDeposito"].
								"' WHERE idRegistro=".$fRegistroDeposito["idRegistro"];
								$x++;
								$query[$x]="UPDATE _1163_registrosImportacion SET conciliado=1,idRegistroConciliado=".$fRegistroDeposito["idRegistro"].
											" WHERE idRegistroImportacion=".$fila["idRegistroImportacion"];
								$x++;
							}
						}
						
						
						
						
					break;
					case 3:
						
						$consulta="SELECT * FROM _1162_tablaDinamica WHERE numeroDeposito='".$fila["numeroDeposito"]."'";
						$fDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
						if($fDeposito)
						{
							cambiarEtapaFormulario(1162,$fDeposito["id__1162_tablaDinamica"],8,"",-1,"NULL","NULL",0);
							
							$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE numeroDeposito='".$fila["numeroDeposito"]."' AND tipoMovimiento=3";
							$fRegistroDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
	
							if($fRegistroDeposito)
							{
								$query[$x]="UPDATE _1163_libroDepositosDespacho SET montoDeposito=".$fila["montoDeposito"].",fechaMovimiento='".$fila["fechaMovimiento"].
								"',conciliado=1,fechaConciliacion='".date("Y-m-d H:i:s")."',responsableConciliacion=".$_SESSION["idUsr"].
								",idRegistroConciliacion=".$fila["idRegistroImportacion"].",montoOriginal=".$fRegistroDeposito["montoDeposito"].
								",fechaMovimientoOriginal='".$fRegistroDeposito["fechaMovimiento"]."',numeroDepositoOriginal='".$fila["numeroDeposito"].
								"' WHERE idRegistro=".$fRegistroDeposito["idRegistro"];
								$x++;
								$query[$x]="UPDATE _1163_registrosImportacion SET conciliado=1,idRegistroConciliado=".$fRegistroDeposito["idRegistro"].
											" WHERE idRegistroImportacion=".$fila["idRegistroImportacion"];
								$x++;
							}
						}
					break;
					
				}
			}
			$query[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($query))
			{
				$consulta="select  @idRegistro";
				$idRegistroImportacion=$con->obtenerValor($consulta);
				unlink($nombreArchivo);
			}
		}
		
		return $idRegistroImportacion;
			
	}
?>
