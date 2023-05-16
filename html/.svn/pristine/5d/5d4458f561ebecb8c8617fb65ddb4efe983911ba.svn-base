<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");
	include_once("./funciones/funcionesReportes.php");
	
	ini_set("memory_limit","256M");

	$tituloReporte="reporteActuaciones";

	$formato=2;
	if(isset($_POST["formato"]))
		$formato=$_POST["formato"];
	$disposicion=2;
	if(isset($_POST["disposicion"]))
		$disposicion=$_POST["disposicion"];
	
	
	$tipoProceso=0;
	if(isset($_POST["tipoProceso"]))
		$tipoProceso=$_POST["tipoProceso"];
	
	$tipoActuacion=0;
	if(isset($_POST["tipoActuacion"]))
		$tipoActuacion=$_POST["tipoActuacion"];		
	
	$despacho="0";
	if(isset($_POST["despacho"]))
	{

		$despacho=$_POST["despacho"];

	}
	
	$fechaInicio=date("Y-m-d");
	$fechaFin=date("Y-m-d");
	
	if(isset($_POST["fechaInicio"]))
	{

		$fechaInicio=$_POST["fechaInicio"];

	}
	
	if(isset($_POST["fechaFin"]))
	{

		$fechaFin=$_POST["fechaFin"];

	}
	
	if(isset($_POST["despacho"]))
	{

		$despacho=$_POST["despacho"];

	}
	
	$posicion=1;
	$numFila=9;
	$libro=new cExcel("reporteActuaciones.xls",true);	

	$consulta="SELECT p.fechaCreacion,a.nombreActuacion,c.carpetaAdministrativa,tP.nombreTipoProceso,comentariosAdicionales,d.nombreUnidad
				 FROM 
			_899_tablaDinamica p,_624_tablaDinamica a,7006_carpetasAdministrativas c,_625_tablaDinamica tP,_17_tablaDinamica d
			WHERE a.id__624_tablaDinamica=p.providenciaAplicar AND p.carpetaAdministrativa=c.carpetaAdministrativa 
			AND tP.id__625_tablaDinamica=c.tipoProceso and d.claveUnidad=p.codigoInstitucion and p.fechaCreacion>='".$fechaInicio.
			"' and p.fechaCreacion<='".$fechaFin."'";
	if($tipoProceso!=0)
	{
		$consulta.=" and c.tipoProceso in(".$tipoProceso.")";
	}
	
	if($tipoActuacion!=0)
	{
		$consulta.=" and p.providenciaAplicar in(".$tipoActuacion.")";
	}

	if($despacho!="0")
	{
		$consulta.=" and p.codigoInstitucion in(".$despacho.")";

	}
			
			
	$consulta.=" ORDER BY p.fechaCreacion";

	$res=$con->obtenerFilas($consulta);
	$libro->insertarFila(10,$con->filasAfectadas-1);
	while($fila=mysql_fetch_assoc($res))
	{
		$libro->setValor("A".$numFila,$posicion);
		$libro->setValor("B".$numFila,"'".date("d/m/Y",strtotime($fila["fechaCreacion"])));
		$libro->setValor("C".$numFila,$fila["nombreActuacion"]);
		$libro->setValor("D".$numFila,$fila["carpetaAdministrativa"]);
		$libro->setValor("E".$numFila,$fila["nombreTipoProceso"]);
		$libro->setValor("F".$numFila,$fila["nombreUnidad"]);
		$posicion++;
		$numFila++;
	}
	

	//$libro->generarArchivo("HTML");
	if($formato==2)
		$libro->generarArchivo("Excel2007",$tituloReporte.".xlsx");
	else
	{
		$libro->generarArchivoServidor("PDF",$tituloReporte.".pdf");
		header("Content-type:application/pdf"); 
		header("Content-Disposition: ".($disposicion==1?"inline":"attachment")."; filename=".$tituloReporte.".pdf");
		readfile($tituloReporte.".pdf");
		unlink($tituloReporte.".pdf");
	}

	

?>