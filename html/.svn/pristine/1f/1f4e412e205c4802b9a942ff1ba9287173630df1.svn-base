<?php session_start();
include("conexionBD.php");
include_once("latisErrorHandler.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=generarNombreArchivoTemporal();
	copy($binario_nombre_temporal,$baseDir."/include/funcionesExternas/".$_FILES['archivoEnvio']['name']);
	
	
	
	echo "1|";
	

}
?>
