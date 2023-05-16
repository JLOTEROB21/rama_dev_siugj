<?php session_start();
	include_once("conexionBD.php");
	include_once("webPay/WebPay.php");

	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			generarRefererenciaPagoTarjeta();
		break;
		case 2:
		
		break;
	}
	
	function generarRefererenciaPagoTarjeta()
	{
		global $con;
		$wP=new WebPay();
		$monto=$_POST["m"];
		$referencia=$_POST["r"];
		
		$url=$wP->getWebPayURL($monto,"10.19.5.9",$referencia);
		
		if($url!="")
			echo "1|".bE($url);
		else
			echo "2";

	}
?>