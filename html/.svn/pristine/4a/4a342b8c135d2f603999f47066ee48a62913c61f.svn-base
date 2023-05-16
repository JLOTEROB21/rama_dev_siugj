<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");
	include_once("./funciones/funcionesReportes.php");
	
	ini_set("memory_limit","256M");

	$tituloReporte="reporteNotificaciones";

	$formato=2;
	if(isset($_POST["formato"]))
		$formato=$_POST["formato"];
	$disposicion=2;
	if(isset($_POST["disposicion"]))
		$disposicion=$_POST["disposicion"];
	
	
	$tipoNotificacion=0;
	if(isset($_POST["tipoNotificacion"]))
		$tipoNotificacion=$_POST["tipoNotificacion"];
	
	
	
	$despacho="0";
	if(isset($_POST["despacho"]))
	{

		$despacho=$_POST["despacho"];

	}
	
	$fechaInicio=date("2022-03-01");
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
	$libro=new cExcel("reporteNotificaciones.xls",true);	

	$consulta="SELECT fechaCreacion,carpetaAdministrativa,codigo,
				IF(medioNotificacion=1,'Electrónica',IF(medioNotificacion='2','Física','Ambas')) AS tipoNotificacion,
				(SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad=n.codigoInstitucion) AS despacho ,id__665_tablaDinamica as idRegistro,
				(SELECT GROUP_CONCAT(nombreDocumento) FROM _665_gridDocumentosNotificar WHERE idReferencia=n.id__665_tablaDinamica 
				ORDER by nombreDocumento) as documentosNotifica,
				(SELECT GROUP_CONCAT(nombrePersona) FROM _665_gPersonasNotificar WHERE idReferencia=n.id__665_tablaDinamica 
				 ORDER BY nombrePersona) as personaNotifica
				FROM _665_tablaDinamica n  where n.fechaCreacion>='".$fechaInicio.
							"' and n.fechaCreacion<='".$fechaFin."'";
	
	
	
	if($despacho!="0")
	{
		$consulta.=" and n.codigoInstitucion in(".$despacho.")";

	}
			
			
	$consulta.=" ORDER BY n.fechaCreacion";

	$arrRegistros=array();
	$res=$con->obtenerFilas($consulta);
	
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT fechaRealizacionDiligenciaResultadoNotificacion,
				horaRealizacionDiligenciaResultadoNotificacion,
				IF(medioNotificacionResultadoNotificacion=1,'Electrónica',
				IF(medioNotificacionResultadoNotificacion='2','Física','Sede Judicial')) AS medioNotificacion
				FROM _722_tablaDinamica WHERE idReferencia=".$fila["idRegistro"];
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		switch($tipoNotificacion)
		{
			case 0:
				array_push($arrRegistros,$fila);
			break;
			case 1:
				if($fRegistro)
				{
					array_push($arrRegistros,$fila);
				}
			break;
			case 2:
				if(!$fRegistro)
				{
					array_push($arrRegistros,$fila);
				}
			break;
		}
	}
	
	$libro->insertarFila(10,count($arrRegistros)-1);

	foreach($arrRegistros as $fila)
	{
		$consulta="SELECT fechaRealizacionDiligenciaResultadoNotificacion,
				horaRealizacionDiligenciaResultadoNotificacion,
				IF(medioNotificacionResultadoNotificacion=1,'Electrónica',
				IF(medioNotificacionResultadoNotificacion='2','Física','Sede Judicial')) AS medioNotificacion
				FROM _722_tablaDinamica WHERE idReferencia=".$fila["idRegistro"];
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$libro->setValor("A".$numFila,$posicion);
		$libro->setValor("B".$numFila,"'".date("d/m/Y",strtotime($fila["fechaCreacion"])));
		$libro->setValor("C".$numFila,$fila["codigo"]);
		$libro->setValor("D".$numFila,$fila["tipoNotificacion"]);
		$libro->setValor("E".$numFila,$fila["carpetaAdministrativa"]);
		$libro->setValor("F".$numFila,$fila["documentosNotifica"]);
		$libro->setValor("G".$numFila,$fila["personaNotifica"]);
		$libro->setValor("H".$numFila,$fila["despacho"]);
		
		$libro->setValor("I".$numFila,$fRegistro?'Sí':'No');
		if($fRegistro)
		{
			$libro->setValor("J".$numFila,"'".date("d/m/Y",strtotime($fRegistro["fechaRealizacionDiligenciaResultadoNotificacion"]." ".$fRegistro["horaRealizacionDiligenciaResultadoNotificacion"])));
			$libro->setValor("K".$numFila,$fRegistro["medioNotificacion"]);
		}
		$posicion++;
		$numFila++;
	}
	

	
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