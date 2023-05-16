<?php 	session_start();
	include("conexionBD.php");
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$fechaReporte=date("Y-m-d");
	$consulta="SELECT * FROM 539_calendarioReportesIndicadores WHERE fechaReporte<='".$fechaReporte.
			"' AND reportado=0";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT * FROM _539_tablaDinamica WHERE id__539_tablaDinamica=".$fila["idReferencia"];
		$filaBase=$con->obtenerPrimeraFilaAsoc($consulta);
		$arrDocumentosReferencia=NULL;
		$arrValores=array();
		$arrValores["idRegistroPlaneacion"]=$fila["idReferencia"];
		$arrValores["periodoReporte"]=$fila["noPeriodo"];
		$arrValores["idUsuarioDestinatario"]=$fila["responsable"];
		$arrValores["idRegistroCalendario"]=$fila["idRegistro"];
		$arrValores["codigoInstitucion"]=$filaBase["codigoInstitucion"];
		$idRegistroSolicitud=crearInstanciaRegistroFormulario(572,-1,1,$arrValores,$arrDocumentosReferencia,-1,1016);
		registrarNotificacionReporteIndicador("Solicitud de informe de indicadores (Periodo: ".$fila["noPeriodo"].")",$fila["responsable"],3743,"174_0",$idRegistroSolicitud);
		
		$query[$x]="UPDATE 539_calendarioReportesIndicadores SET reportado=1 WHERE idRegistro=".$fila["idRegistro"];
		$x++;
		
	}
	
	$query[$x]="commit";
	$x++;
	
	return $con->ejecutarBloque($query);
?>