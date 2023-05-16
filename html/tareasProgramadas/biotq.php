<?php include("conexionBD.php");
	$idFuncion=$_GET["idFuncion"];
	switch($idFuncion)
	{
		case 1:
			verificarPublicacionesBoletinPendientes();
		break;
	}
	
	function verificarPublicacionesBoletinPendientes()
	{
		verificarBoletinesPublicados();
	}
	
	
?>