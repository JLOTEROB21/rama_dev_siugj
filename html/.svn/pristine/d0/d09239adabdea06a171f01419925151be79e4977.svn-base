<?php
include("conexionBD.php");

if(isset($_GET['id'])) 
{	
	$idDocumento=bD($_GET['id']);
	
	$ruta="";	
	foreach($arrRutasAlmacenamientoDocumentos  as $directorio)
	{
		if(strpos($directorio,"http")===false)
		{
			$ruta=$directorio."\\documento_".$idDocumento;
			$ruta2=$directorio."\\archivo_".$idDocumento;
			if(file_exists($ruta))
			{
				echo bE(leerContenidoArchivo($ruta));
				return;
			}
			
			if(file_exists($ruta2))
			{
				echo bE(leerContenidoArchivo($ruta2));
				return;
			}
		}
	}
}
?>