<?php

	function validarComponenteFirmaElectronica()
	{
		global $URLServidorFirma;
		$urlTemporal=str_replace("http://","",$URLServidorFirma);
		$urlTemporal=str_replace("https://","",$urlTemporal);
		$arrDatos=explode("/",$urlTemporal);
		$arrDatos=explode(":",$arrDatos[0]);
		$dominio="";
		if(!isset($arrDatos[1]))
			$arrDatos[1]=80;
			
		return 0;
		if(verificarDisponibilidadPuerto($arrDatos[0],$arrDatos[1]))
		{
			return 1;
		}
		
		return 0;
	}
	
	function validarComponenteMiniIOS3()
	{
		global $con;
		$consulta="SELECT urlServidor FROM 251_conexionesSistemaGestorDocumental WHERE idConexion=4";
		$URLServidorFirma=$con->obtenerValor($consulta);
		
		$urlTemporal=str_replace("http://","",$URLServidorFirma);
		$urlTemporal=str_replace("https://","",$urlTemporal);
		$arrDatos=explode("/",$urlTemporal);
		$arrDatos=explode(":",$arrDatos[0]);

		if(verificarDisponibilidadPuerto($arrDatos[0],$arrDatos[1]))
		{
			return 1;
		}
		
		return 0;
		
	}
	
	
	function validarComponenteAlfresco()
	{
		global $con;
		$consulta="SELECT urlServidor FROM 251_conexionesSistemaGestorDocumental WHERE idConexion=1";
		$URLServidorFirma=$con->obtenerValor($consulta);
		
		$urlTemporal=str_replace("http://","",$URLServidorFirma);
		$urlTemporal=str_replace("https://","",$urlTemporal);
		$arrDatos=explode("/",$urlTemporal);
		$arrDatos=explode(":",$arrDatos[0]);

		if(verificarDisponibilidadPuerto($arrDatos[0],$arrDatos[1]))
		{
			return 1;
		}
		
		return 0;
		
     

		
	}
	
	
	function verificarDisponibilidadPuerto($host,$puerto)
	{
		$starttime = microtime(true);
		$file      = @fsockopen ($host, $puerto, $errno, $errstr, 10);
		$stoptime  = microtime(true);
		$status    = 0;
	  
		if (!$file)
		{    
			$status = -1;  // Sitio caído
		} 
		else 
		{
			fclose($file);
			$status = ($stoptime - $starttime) * 1000;
			$status = floor($status);
		}
		 
		if ($status <> -1) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
?>