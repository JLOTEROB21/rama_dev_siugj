<?php
	include("conexionBDPO.php"); 
	include("cBBB.php"); 
	
	
	$idReunion=$_GET["idReunion"];
	
	$cButon=new cBigBlueButton();
	$consulta="SELECT meetingID FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
	$meetingID=$conPO->obtenerValor($consulta);
	$arrRespuesta=$cButon->obtenerGrabaciones($meetingID);
	if($arrRespuesta["resultado"])
	{
		$consulta="UPDATE 7000_eventosAudiencia SET urlMultimedia='".$arrRespuesta["urlVideo"]."' WHERE idReunionVirtual=".$idReunion;
		$conPO->ejecutarConsulta($consulta);
		$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET  urlMultimedia='".$arrRespuesta["urlVideo"]."' WHERE idRegistro=".$idReunion;
		$conPO->ejecutarConsulta($consulta);
	}
	
	
	
?>