<?php 
	include("conexionBD.php"); 
	include_once("funcionesNeotrai.php"); 
	
	$parametros="";
	if(isset($_GET["funcion"]))
	{
		$funcion=$_GET["funcion"];
		if(isset($_GET["param"]))
		{
			$p=$_GET["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			cerrarEventos();
		break;
	}
	
	function cerrarEventos()
	{
		global $con;
		$consulta="select MAX(fechaCierre) FROM 9105_cierreEventos";
		$fechaMax=$con->obtenerValor($consulta);
		$fechaMax=strtotime("+1 days",strtotime($fechaMax));
		$fechaInicio=date("Y-m-d",$fechaMax);
		$fechaTermino=strtotime("-1 days",strtotime(date("Y-m-d")));
		
		if(ejecutarCierreEventos($fechaInicio,date('Y-m-d',$fechaTermino)))
		{
			$consulta="insert into 9105_cierreEventos(fechaCierre) values('".date("Y-m-d",$fechaTermino)."')";
			$con->ejecutarConsulta($consulta);
		}
		
	}