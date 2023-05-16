<?php session_start();
	include("conexionBD.php");
	aperturarSesionUsuario(1);
	$fechaActual=date("Y-m-d H:i:s");
	$consulta="SELECT * FROM _665_tablaDinamica WHERE idEstado=2.5 AND tipoNotificacion=2 AND 
				CAST(CONCAT(fechaEnvio,' ',horaEnvio) AS DATETIME)<='".$fechaActual."'";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		prepararEnvioNotificacionV2(665,$fila["id__665_tablaDinamica"]);
	}
?>