<?php session_start();

	include_once("conexionBD.php");
	include_once("utiles.php");
	
	
	$params=array();
	$params["iE"]=$argv[1]; 
	$params["ed"]=$argv[2]; 

	$consulta="SELECT idSala FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$params["iE"];
	$idSala=$con->obtenerValor($consulta);
	$consulta="SELECT perfilSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$idSala;
	$perfilSala=$con->obtenerValor($consulta);
	if($perfilSala==1)
		return true;
	
	$consulta="INSERT INTO 3009_bitacoraVideoGrabacion(fecha,idEvento) VALUES('".date("Y-m-d H:i:s")."',".$params["iE"].")";
	$con->ejecutarConsulta($consulta);								
	
	$idReporte=$con->obtenerUltimoID();
	
	$params["iR"]=$idReporte;
	$postData=http_build_query	(
									$params
								);
	
	
	$comando="";
	$opciones=array();
	$opciones["http"]["method"]="GET";
	$opciones["http"]["content"]=$postData;
	$opciones["http"]["header"]="Content-Type: application/x-www-form-urlencoded";
	$context  = stream_context_create($opciones);
	switch($params["ed"])
	{
		case 4://Sullivan
			$comando='http://localhost:8085/conexionVideoGrabacionSQL.aspx';
		break;
		case 5://Dr. Lavista
			$comando='http://localhost:8086/conexionVideoGrabacionSQL.aspx';
		break;
		case 2000://La Viga
			$comando='http://localhost:8087/conexionVideoGrabacionSQL.aspx';
		break;


	}
	
	
	$result = file_get_contents($comando, false, $context);

	return $result;	
?>