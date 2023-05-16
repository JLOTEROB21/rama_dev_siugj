<?php
include("conexionBD.php");

//echo importarRegistro();
$_SESSION["debuggerConsulta"]=0;
echo procesarEventosBiometricos("2012-03-07");

//echo ejecutarCierreEventos('2012-01-2012','2012-03-04');

//function importarRegistro()
//{
//	global $con;
//	$consulta="SELECT DISTINCT department FROM 9105_registrosChecadores ORDER BY department";
//	$datos=$con->obtenerFilas($consulta);
//	while ($row= mysql_fetch_row($datos))
//	{
//		$consulta1="SELECT idRegistro,id,fechaRegistro,horaRegistro,DeviceID FROM 9105_registrosChecadores WHERE Department='".$row[0]."' order by idRegistro";
//		$datos1=$con->obtenerFilas($consulta1);
//		while ($fila= mysql_fetch_row($datos1))
//		{
//			$insertarTabla="INSERT INTO 9105_eventosRecibidos(idUsuario,fechaEvento,horaEvento,noTerminal,plantel)VALUES('".$fila[1]."',
//							'".$fila[2]."','".$fila[3]."','".$fila[4]."','".$row[0]."')";
//			$con->ejecutarConsulta($insertarTabla);
//		}
//	}
//	echo "Proceso terminado";
//}

function limpiarTablaBiometricos($cadena)
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="DELETE FROM 4559_controlDeFalta";
	$x++;
	$consulta[$x]="DELETE FROM 9105_controlAsistencia";
	$x++;
	$consulta[$x]="DELETE FROM 9105_eventosControlAsistencia";
	$x++;
	$consulta[$x]="commit";
	$x++;
	$con->ejecutarBloque($consulta);
	
	$fin=procesarEventosBiometricos($cadena);
	return $fin;
}

?>