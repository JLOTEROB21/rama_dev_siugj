<?php 	include("conexionBD.php");
	
	$consulta="SELECT idFuncionTemporizador,idFormulario,idReferencia,idTemporizador FROM 9055_diparadoresTemporizador 
			WHERE fechaTemporizador=".date("Y-m-d")." AND situacion=1";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$cadObj='{"idTemporizador":"'.$fila[3].'","param1":"'.$fila[1].'","param2":"'.$fila[2].'"}';
		$obj=json_decode($cadObj);
		resolverExpresionCalculoPHP($fila[0],$obj);
	}
?>