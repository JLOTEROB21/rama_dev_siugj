<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");
	include_once("./funciones/funcionesReportes.php");
	
	ini_set("memory_limit","256M");

	$tituloReporte="reporte1";
	
	$formato=$_POST["formato"];
	$disposicion=$_POST["disposicion"];


	$libro=new cExcel("reporte1.xls",true);	
	
	
	//$datos=obtenerDatosReporte();
	
	$consulta1="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='20' AND temaProceso='48'";
	$res1=$con->obtenerValor($consulta1);
	
	if($res1)
	{
		$libro->setValor("C13",$res1);		
	}
	else
	{
		$libro->setValor("C13",0);		
	}

	$consulta2="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='31'";
	$res2=$con->obtenerValor($consulta2);
	
	if($res2)
	{
		$libro->setValor("C16",$res2);		
	}
	else
	{
		$libro->setValor("C16",0);		
	}

	$consulta3="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='30'";
	$res3=$con->obtenerValor($consulta3);
	if($res3)
	{
		$libro->setValor("C17",$res3);		
	}
	else
	{
		$libro->setValor("C17",0);		
	}

	$consulta4="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='36'";
	$res4=$con->obtenerValor($consulta4);
	if($res4)
	{
		$libro->setValor("C18",$res4);		
	}
	else
	{
		$libro->setValor("C18",0);		
	}

	$consulta5="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='46'";
	$res5=$con->obtenerValor($consulta5);
	if($res5)
	{
		$libro->setValor("C19",$res5);		
	}
	else
	{
		$libro->setValor("C19",0);		
	}
	

	$consulta6="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='34'";
	$res6=$con->obtenerValor($consulta6);
	if($res6)
	{
		$libro->setValor("C22",$res6);		
	}
	else
	{
		$libro->setValor("C22",0);		
	}
	

	$consulta7="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='38'";
	$res7=$con->obtenerValor($consulta7);
	if($res7)
	{
		$libro->setValor("C23",$res7);		
	}
	else
	{
		$libro->setValor("C23",0);		
	}
	

	$consulta8="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='39'";
	$res8=$con->obtenerValor($consulta8);
	if($res8)
	{
		$libro->setValor("C24",$res8);		
	}
	else
	{
		$libro->setValor("C24",0);		
	}
	

	$consulta9="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='40'";
	$res9=$con->obtenerValor($consulta9);
	if($res9)
	{
		$libro->setValor("C25",$res9);		
	}
	else
	{
		$libro->setValor("C25",0);		
	}
	

	$consulta10="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='5' ";
	$res10=$con->obtenerValor($consulta10);
	
	if($res10)
	{
		$libro->setValor("C28",$res10);		
	}
	else
	{
		$libro->setValor("C28",0);		
	}
	
	
	$consulta10="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='5' ";
	$res10=$con->obtenerValor($consulta10);
	
	if($res10)
	{
		$libro->setValor("C31",$res10);		
	}
	else
	{
		$libro->setValor("C31",0);		
	}
	
	$consulta10="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='16' ";
	$res10=$con->obtenerValor($consulta10);
	
	if($res10)
	{
		$libro->setValor("C32",$res10);		
	}
	else
	{
		$libro->setValor("C32",0);		
	}
	

	$consulta="SELECT COUNT(*) FROM 908_archivos a WHERE categoriaDocumentos=16";
	$numElementos=$con->obtenerValor($consulta);
	
	$libro->setValor("C55",$numElementos==""?0:$numElementos);
	
	$consulta="SELECT COUNT(*) FROM 908_archivos a WHERE categoriaDocumentos=63";
	$numElementos=$con->obtenerValor($consulta);
	
	$libro->setValor("C56",$numElementos==""?0:$numElementos);	

	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE tipoCarpetaAdministrativa=20";
	$numElementos=$con->obtenerValor($consulta);
	
	$libro->setValor("C59",$numElementos==""?0:$numElementos);	
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE tipoCarpetaAdministrativa=2";
	$numElementos=$con->obtenerValor($consulta);
	
	$libro->setValor("C60",$numElementos==""?0:$numElementos);	
	
	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE tipoActuacion=36 AND idEstado>1";
	$numElementos=$con->obtenerValor($consulta);
	
	$libro->setValor("C61",$numElementos==""?0:$numElementos);	
	
	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE tipoActuacion=22 AND idEstado>1";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C63",$numElementos==""?0:$numElementos);	

	$consulta="SELECT COUNT(*) FROM _899_tablaDinamica p WHERE p.providenciaAplicar=15 AND sentidoFalloSentencia=1 AND idEstado IN(4,22)";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C66",$numElementos==""?0:$numElementos);	

	$consulta="SELECT COUNT(*) FROM _899_tablaDinamica p WHERE p.providenciaAplicar=15 AND sentidoFalloSentencia=2 AND idEstado IN(4,22)";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C68",$numElementos==""?0:$numElementos);	

	$consulta="SELECT COUNT(*) FROM _899_tablaDinamica p WHERE p.providenciaAplicar=15 AND sentidoFalloSentencia=7 AND idEstado IN(4,22)";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C67",$numElementos==""?0:$numElementos);	


	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE tipoActuacion=28 AND idEstado>1";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C72",$numElementos==""?0:$numElementos);	

	$consulta="SELECT COUNT(*) FROM _944_tablaDinamica WHERE idEstado=8";
	$numElementos=$con->obtenerValor($consulta);	
	$libro->setValor("C70",$numElementos==""?0:$numElementos);	
	
	




	//$libro->generarArchivo("HTML");
	
	if($formato==2)
		$libro->generarArchivo("Excel2007",$tituloReporte.".xlsx");
	else
	{
		$libro->generarArchivoServidor("PDF",$tituloReporte.".pdf");
		header("Content-type:application/pdf"); 
		//header("Content-length: ".filesize($tituloReporte.".pdf")); 
		header("Content-Disposition: ".($disposicion==1?"inline":"attachment")."; filename=".$tituloReporte.".pdf");
		readfile($tituloReporte.".pdf");
		unlink($tituloReporte.".pdf");
	}
	function formatearFecha($fecha)
	{
		return date("d/m/Y",strtotime($fecha))	;
	}
	
	function formatearMoneda($monto)
	{
		return '$ '.number_format($monto,2);
	}
?>