<?php
	include("conexionBD.php"); 
	include("cBBB.php"); 
	
	$idReunion=$_GET["idReunion"];
	
	$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=3,fechaRealTermino='".date("Y-m-d H:i:s")."' WHERE idRegistro=".$idReunion;
	$con->ejecutarConsulta($consulta);
	
	
?>