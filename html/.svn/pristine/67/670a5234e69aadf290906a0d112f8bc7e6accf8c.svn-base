<?php session_start();
	include_once("conexionBD.php"); 
	include_once("cTTS.php"); 
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			convertirCadenaAudio();
		break;
	}
	
	
	function convertirCadenaAudio()
	{
		$cadena=bD($_POST["c"]);
		$cT=new cTTS();
		$resultado=$cT->convertirTextoToAudio($cadena);
		
		if($resultado!==false)
		{
			echo "1|".$resultado;
		}
		else
		{
			echo "1|0";
		}
	}
?>	