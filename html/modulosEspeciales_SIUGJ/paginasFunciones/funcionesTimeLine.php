<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	
	include_once("funcionesActores.php");
	
	
	


	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];


	switch($funcion)
	{
		case 1:
				obtenerActuacionesProceso();
		break;
		
	}
	
	function obtenerActuacionesProceso()
	{
		global $con;
		
		$cA=bD($_POST["cA"]);
		$iC=bD($_POST["iC"]);
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
		if($iC!=-1)
		{
			$consulta.=" and idCarpeta=".$iC;
		}
		$codigoUnidadCarpeta=$con->obtenerValor($consulta);
		
		$arrRegistros="";
		$numReg=0;
		
		$consulta="SELECT idRegistro,fechaRegistro AS fechaActuacion,lblEtiquetaRegistro AS actuacion,detalleComplementario AS anotacion,
					fechaInicio AS fechaInicia,fechaMaximaAtencion AS fechaTermino FROM 00013_registrosMacroProceso WHERE 
					carpetaAdministrativa='".$cA."' and codigoInstitucion='".$codigoUnidadCarpeta."'  order by idRegistro";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';			
	}
	
	
?>