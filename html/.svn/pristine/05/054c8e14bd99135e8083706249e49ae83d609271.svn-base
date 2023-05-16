<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");

	$arrTipoMovimiento=array();
	$arrTipoMovimiento[1]="Depósito";
	$arrTipoMovimiento[2]="Pagado a beneficiario";
	$arrTipoMovimiento[3]="Prescrito";
	$arrTipoMovimiento[4]="Traspasado";
	ini_set("memory_limit","256M");

	$cadObj=NULL;
	$objConf=NULL;
	$arrArchivos=array();
	$procesosJudiciales='';
	if(isset($_POST["cadObj"]))
	{
		$objConf=json_decode(bD($_POST["cadObj"]));
		
	}
	
	$libro=new cExcel("./plantillas/reporteConciliacionBancaria.xls",true);	
	
	$numFila=14;
	$idImportacion=$objConf->idImportacion;
	
	$consulta="SELECT nombreArchivo FROM _1163_archivosImportacionBAC WHERE idRegistro=".$idImportacion;
	$nombreArchivo=$con->obtenerValor($consulta);
	
	$ct=1;
	$consulta="SELECT * FROM _1163_registrosImportacion WHERE idRegistroArchivoImportacion=".$idImportacion." ORDER BY conciliado DESC,fechaMovimiento ASC";
	$res=$con->obtenerFilas($consulta);
	if($con->filasAfectadas>1)
		$libro->insertarFila(15,$con->filasAfectadas-1);
	while($fila=mysql_fetch_assoc($res))
	{
		$libro->setValor("A".$numFila,$fila["idRegistroImportacion"]);
		$libro->setValor("J".$numFila,"'".$fila["noMovimiento"]);
		$libro->setValor("K".$numFila,"'".date("d/m/Y",strtotime($fila["fechaMovimiento"])));
		$libro->setValor("L".$numFila,$fila["montoDeposito"]);
		$libro->setValor("M".$numFila,$arrTipoMovimiento[$fila["tipoMovimiento"]]);
		$libro->setValor("N".$numFila,$fila["conciliado"]==1?'Sí':'No');
		$libro->setValor("O".$numFila,$fila["comentarios"]);
		if($fila["conciliado"]==1)
		{
			$consulta="SELECT * FROM _1163_libroDepositosDespacho WHERE idRegistro=".$fila["idRegistroConciliado"];
			$fDeposito=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fDeposito)
			{
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fDeposito["codigoUnidad"]."'";
				$despacho=$con->obtenerValor($consulta);
				$libro->setValor("B".$numFila,$fDeposito["carpetaAdministrativa"]);
				$libro->setValor("C".$numFila,$despacho);
				$libro->setValor("D".$numFila,"'".$fDeposito["numeroDeposito"]);
				$libro->setValor("E".$numFila,"'".date("d/m/Y",strtotime($fDeposito["fechaMovimiento"])));
				$libro->setValor("F".$numFila,$fDeposito["naturalezaAfectacion"]==-1?$fDeposito["montoDeposito"]:0);
				$libro->setValor("G".$numFila,$fDeposito["naturalezaAfectacion"]!=-1?$fDeposito["montoDeposito"]:0);
				$libro->setValor("H".$numFila,$arrTipoMovimiento[$fDeposito["tipoMovimiento"]]);
				$libro->setValor("I".$numFila,$fDeposito["conciliado"]==1?'Sí':'No');
			}
		}
		$ct++;
		$numFila++;
	}

	
	
	$arrColumnasReporte["A"]=1;
	$arrColumnasReporte["B"]=1;
	$arrColumnasReporte["C"]=1;
	$arrColumnasReporte["D"]=1;
	$arrColumnasReporte["E"]=1;
	$arrColumnasReporte["F"]=1;
	$arrColumnasReporte["G"]=1;
	$arrColumnasReporte["H"]=1;
	$arrColumnasReporte["I"]=1;
	$arrColumnasReporte["J"]=1;
	$arrColumnasReporte["K"]=1;
	$arrColumnasReporte["L"]=1;
	$arrColumnasReporte["M"]=1;
	$arrColumnasReporte["N"]=1;
	$arrColumnasReporte["O"]=1;
	
	foreach($arrColumnasReporte as $columna=>$resto)
	{
		$enc=false;
		foreach($objConf->arrColumas as $oColumna)
		{
			if($columna==$oColumna->columna)
				$enc=true;	
		}
		
		
		if(!$enc)
		{
			$arrColumnasReporte[$columna]=0;	
		}
	}
	

	
	
	
	
	
	
	
	
	

	
	
	$numFila=24;
	$ct=1;
	
	$periodo="Del ".date("d/m/Y",strtotime($objConf->fechaInicio))." al ".date("d/m/Y",strtotime($objConf->fechaFin));
	
	$libro->setValor("B9",date("d/m/Y H:i"));
	$libro->setValor("B10",$periodo);
	$libro->setValor("B11",$nombreArchivo);
	$eliminados=0;
	foreach($arrColumnasReporte as $columna=>$resto)
	{
		if($resto==0)
		{
			$columna=$libro->obtenerDesplazamientoColumna($columna,$eliminados*-1);
			$libro->obtenerHojaActiva()->removeColumn($columna,1);
			$eliminados++;
		}
	}
	

	$libro->generarArchivo("Excel2007","informeConciliacion.xlsx");
	
?>