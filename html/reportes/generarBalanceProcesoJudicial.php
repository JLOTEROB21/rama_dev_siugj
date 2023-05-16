<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");

	
	ini_set("memory_limit","256M");

	$arrArchivos=array();
	$procesosJudiciales='';
	if(isset($_POST["procesosJudiciales"]))
	{
		$procesosJudiciales=$_POST["procesosJudiciales"];
		
	}
	
	$arrProcesos=explode(",",$procesosJudiciales);

	
	
	
	foreach($arrProcesos as $p)
	{
		$nombreArchivo=generarReporteBalanceProceso($p);
		array_push($arrArchivos,$nombreArchivo);
	}
	
	$libro=NULL;
	$libro2;
	$numLibro=1;
	foreach($arrArchivos as $ruta)
	{
		if($numLibro==1)
		{
			$libro=new cExcel($ruta,true,"Excel2007");
		}
		else
		{
			$libro2=new cExcel($ruta,true,"Excel2007");
			$libro->libroExcel->addExternalSheet($libro2->obtenerHojaActiva());
		}
		$numLibro++;
		
	}
	
	$libro->cambiarHojaActiva(0);
	$libro->generarArchivo("Excel2007","balanceProyectos_".(date("Y_m_d")).".xlsx");
	foreach($arrArchivos as $ruta)
	{
		unlink($ruta);
	}
	
	function generarReporteBalanceProceso($p)
	{
		global $con;
		global $baseDir;
		
		$arrTipoMovimiento=array();
		$arrTipoMovimiento[1]="Depósito";
		$arrTipoMovimiento[2]="Pagado a beneficiario";
		$arrTipoMovimiento[3]="Prescrito";
		$arrTipoMovimiento[4]="Traspasado";
		
		
		
		
		
		$libro=new cExcel("./plantillas/balanceProceso.xls",true);	
		

		$consulta="SELECT carpetaAdministrativa,(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=c.unidadGestion) AS despacho, idActividad,
					unidadGestion, idFormulario,idRegistro
					FROM  7006_carpetasAdministrativas c WHERE carpetaAdministrativa=".$p;
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$demantante="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$fCarpeta["idActividad"]." AND r.idFiguraJuridica in(13) ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=mysql_fetch_row($res))
		{
			$nombre=trim($filaImputado[0]);
			if($demantante=="")
				$demantante=$nombre;
			else
				$demantante.=", ".$nombre;
		}
		
		$numFila=24;
		$ct=1;
		$libro->setValor("B7",$fCarpeta["carpetaAdministrativa"]);
		$libro->setValor("B8",$fCarpeta["despacho"]);
		$libro->setValor("B10",date("d/m/Y H:i"));
		$libro->setValor("B9",$demantante);
		
		$totalDepositos=0;
		$totalPagados=0;
		$totalPrescritos=0;
		$totalTraslados=0;
		
		
		
		if($fCarpeta["idFormulario"]==1163)
		{
			$consulta="SELECT cuantia FROM _1163_tablaDinamica WHERE id__1163_tablaDinamica=".$fCarpeta["idRegistro"];
			$valorObligacion=$con->obtenerValor($consulta);
		}
		
		if($fCarpeta["idFormulario"]==1204)
		{
			$consulta="SELECT montoCostes FROM _1204_tablaDinamica WHERE id__1204_tablaDinamica=".$fCarpeta["idRegistro"];
			$valorObligacion=$con->obtenerValor($consulta);
		}
		
		$libro->setValor("B11",$valorObligacion);
		$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE carpetaAdministrativa=".$p." AND codigoUnidad='".$fCarpeta["unidadGestion"].
				"' ORDER BY fechaMovimiento desc";

		$res=$con->obtenerFilas($consulta);
		if($con->filasAfectadas>1)
			$libro->insertarFila(24,$con->filasAfectadas-1);
		while($fila=mysql_fetch_assoc($res))
		{
			$cargo=0;
			$abono=0;
			if($fila["naturalezaAfectacion"]==1)
			{
				$abono=$fila["montoDeposito"];
			}
			else
			{
				$cargo=$fila["montoDeposito"];
			}
			$libro->setValor("A".$numFila,$ct);

			$libro->setValor("B".$numFila,"=CONCATENATE(\"".date("d/m/Y",strtotime($fila["fechaMovimiento"]))."\",\"\")");

			$libro->setValor("C".$numFila,"=CONCATENATE(\"".$fila["numeroDeposito"]."\",\"\")");
			$libro->setValor("D".$numFila,$cargo);
			$libro->setValor("E".$numFila,$abono);
			$libro->setValor("F".$numFila,$arrTipoMovimiento[$fila["tipoMovimiento"]]);
			$libro->setValor("G".$numFila,$fila["conciliado"]==1?"Sí":"No");
			$libro->unsetNegritas("A".$numFila.":G".$numFila);
			
			switch($fila["tipoMovimiento"])
			{
				case 1:
					$totalDepositos+=$fila["montoDeposito"];
				break;
				case 2:
					$totalPagados+=$fila["montoDeposito"];
				break;
				case 3:
					$totalPrescritos+=$fila["montoDeposito"];
				break;
				case 4:
					if($fila["naturalezaAfectacion"]==1)
						$totalDepositos+=$fila["montoDeposito"];
					else
						$totalTraslados+=$fila["montoDeposito"];
				break;
			}
			$numFila++;
			$ct++;
			
		}
		$numFila--;
		$libro->setHAlineacion("A".$numFila.":C".$numFila,"C");
		$libro->setHAlineacion("F".$numFila.":G".$numFila,"C");
		$libro->setValor("C15",$totalDepositos);
		$libro->setValor("C16",$totalPagados);
		$libro->setValor("C17",$totalPrescritos);
		$libro->setValor("C18",$totalTraslados);
		$libro->setValor("B20",$valorObligacion-($totalDepositos)+$totalTraslados);
		$libro->cambiarTituloHoja(0,$fCarpeta["carpetaAdministrativa"]);
		
		$nombreArchivo=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
		$libro->generarArchivoServidor("Excel2007",$nombreArchivo);
		
		return $nombreArchivo;
		
	}
?>