<?php session_start();
	header("Content-Type:text/html;charset=utf-8");
	if(isset($_SESSION["idUsr"]))
	{
		if(($_SESSION["idUsr"]=="-1")||(!isset($_SESSION["codigoInstitucion"])))
		{
			enviarPantallaCierreSesion();
		}
	}
	else
		enviarPantallaCierreSesion();			
	
	if(!function_exists("enviarPantallaCierreSesion"))
	{
		function enviarPantallaCierreSesion()
		{
			header('Location:../principalPortal/inicio.php');
		}
	}
?>