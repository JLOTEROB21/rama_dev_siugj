<?php	
	include("conexionBD.php");
	$valor=cv(utf8_decode($_POST["param"]));
	$consulta1="delete from 4082_bannerPresente";
	$consulta="insert into 4082_bannerPresente (bannerActua) values('".$valor."')";
	$con->ejecutarConsulta($consulta1);
	if($con->ejecutarConsulta($consulta))
	{
		echo "1|";
	}
	else
		echo "|";

?>