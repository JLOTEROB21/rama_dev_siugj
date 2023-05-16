<?php session_start();
	include("conexionBD.php");
	aperturarSesionUsuario(1);
	$fechaActual=date("Y-m-d H:i:s");
	$consulta="SELECT idRegistro,iFormulario,iRegistro,idRegistroElemento FROM 00013_registrosMacroProceso WHERE idRegistro=1044";
	// '".$fechaActual."'>fechaMaximaAtencion AND situacionActual=1 ORDER BY fechaMaximaAtencion";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$idProceso=obtenerIdProcesoFormulario($fila["iFormulario"]);
		$cadParametros='{"iFormulario":"'.$fila["iFormulario"].'","iRegistro":"'.$fila["iRegistro"].
						'","idFormulario":"'.$fila["iFormulario"].'","idRegistro":"'.$fila["iRegistro"].'","idProceso":"'.$idProceso.
						'","idActorProceso":"0","campoTablaDestino":"","etapa":"0","idMacroProceso":"","idRegistroProcesoEtapaMacroProceso":"","idElementoEvaluacion":"","tipoElemento":"","idRegistroElemento":"","lblEtiquetaElemento":""}';
		$objParametros=json_decode($cadParametros);	

		$cAdmonMacroProceso=new cMacroProcesoAdmon($fila["iFormulario"],$fila["iRegistro"],$objParametros);
		$cAdmonMacroProceso->marcarRegistroMacroProcesoIncumplido($fila["idRegistro"]);
	
	}
?>