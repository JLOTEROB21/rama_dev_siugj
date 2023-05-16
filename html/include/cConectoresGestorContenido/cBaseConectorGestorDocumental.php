<?php include_once("cConexion.php");

	class cBaseConectorGestorDocumental
	{
		var $conexion;
		var $ipServidor;
		var $usuario;
		var $password;
		var $raizServidor;
		var $statusActual;
		
		function conectar()
		{
			return true;

		}
		
		function existeRecurso($rutaRecurso)
		{
			return true;
			
		}
		
		
		function crearDirectorio($rutaDirectorio)
		{
			
			return true;
		}
		
		
		function normalizarRuta($ruta)
		{
			$ruta=str_replace("//","/",$ruta);
			$ruta=str_replace("-","",$ruta);
			$ruta=str_replace("*","",$ruta);
			$ruta=str_replace("\"","",$ruta);
			$ruta=str_replace("<","",$ruta);
			$ruta=str_replace(">","",$ruta);
			$ruta=str_replace("\\","",$ruta);
			$ruta=str_replace(".","",$ruta);
			$ruta=str_replace("?","",$ruta);
			$ruta=str_replace(" ","%20",$ruta);
			return $ruta;
				
		}
		
		function normalizarNombreArchivo($ruta)
		{
			$ruta=str_replace("//","/",$ruta);
			$ruta=str_replace("-","",$ruta);
			$ruta=str_replace("*","",$ruta);
			$ruta=str_replace("\"","",$ruta);
			$ruta=str_replace("<","",$ruta);
			$ruta=str_replace(">","",$ruta);
			$ruta=str_replace("\\","",$ruta);
			$ruta=str_replace("?","",$ruta);
			$ruta=str_replace(" ","%20",$ruta);
			return $ruta;
				
		}
		
		function crearDocumento($rutaDirectorio,$nombreDocumento,$contenidoDocumento)
		{
			return true;
		
		}
		
		function obtenerDocumento($recurso)
		{
			return true;
		}
	}
?>