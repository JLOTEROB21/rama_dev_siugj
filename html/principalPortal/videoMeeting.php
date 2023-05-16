<?php
	include("conexionBD.php"); 
	include("cBBB.php"); 
	
	
	$idReunion=$_GET["idReunion"];
	
	$cButon=new cBigBlueButton();
	$consulta="SELECT meetingID FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
	$meetingID=$con->obtenerValor($consulta);
	$arrRespuesta=$cButon->obtenerGrabaciones($meetingID);
	if($arrRespuesta["resultado"])
	{
		$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET  urlMultimedia='".$arrRespuesta["urlVideo"]."' WHERE idRegistro=".$idReunion;
		$con->ejecutarConsulta($consulta);
	}
	
	
	
?>