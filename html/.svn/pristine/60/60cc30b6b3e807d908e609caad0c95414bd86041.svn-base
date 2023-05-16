<?php session_start();
	include_once("conexionBD.php");	
	aperturarSesionUsuario(1);
	$consulta="SELECT archivoInclude FROM 20000_conectoresServiciosNube"; 
	$res=$con->obtenerFilas($consulta);
	while($filaConector=mysql_fetch_assoc($res))
	{
		include_once($filaConector["archivoInclude"]);	
	}
	include_once("cConectoresServicios/cConectorCalendarOffice365.php");
	
	$fechaActual=date("Y-m-d H:i:s");
	$consulta="SELECT e.idRegistroEvento,valorComplementario1 AS idConector,valorComplementario2 AS idAudiencia FROM 7000_eventosAudiencia e,7000_notificacionesEventosOperadoresServicios n 
			WHERE e.grabacionConsolidada=0 AND n.idRegistroEvento=e.idRegistroEvento AND n.tipoAccion=10";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$infoComp["idConexion"]=$fila["idConector"];
		$cCalendario=new cMicrosoftCalendarOffice365("","","","",$infoComp);
		$cveAudiencia="[".$fila["idRegistroEvento"]."_".obtenerPrefijoSitio()."]";
		
		$urlAudencia=@$cCalendario->obtenerUrlGrabacionEvento($cveAudiencia);
		
		if($urlAudencia!="")
		{
			$consulta="update 7000_eventosAudiencia set grabacionConsolidada=1, situacion=2,urlMultimedia='".$urlAudencia."' where idRegistroEvento=".$fila["idRegistroEvento"];
			$con->ejecutarConsulta($consulta);
		}
		
	}
?>
