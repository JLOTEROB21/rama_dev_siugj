<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerRegistrosTareasProgramadas();
		break;
	}
	
	function obtenerRegistrosTareasProgramadas()
	{
		global $con;
		$tipoTarea=$_POST["tipoTarea"];
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$consulta="SELECT idRegistro AS idTarea,fechaInicioEjecucion AS fechaEjecucion, tipoActividad AS tipoTarea, 
					resultado,fechaTerminoEjecucion,comentariosAdicionales ,
					(SELECT COUNT(*) FROM 9076_registrosAsociados WHERE idTarea=b.idRegistro)  as totalRegistrosInvolucrados,
					(SELECT COUNT(*) FROM 9076_registrosAsociados WHERE idTarea=b.idRegistro and situacion=1)  as totalRegistrosAtendidos
					FROM 9075_bitacoraEjecucionActividadTemporal b
					WHERE tipoActividad=".$tipoTarea." AND fechaInicioEjecucion>='".$fechaInicio."' AND fechaInicioEjecucion<='".
					$fechaFin." 23:59:59' order by idRegistro desc";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
					
					
		
	}
?>
