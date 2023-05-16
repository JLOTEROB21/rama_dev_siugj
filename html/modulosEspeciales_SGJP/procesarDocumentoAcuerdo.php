<?php session_start();
include("conexionBD.php");

$idEvento=$_POST["idEvento"];
$carpetaAdministrativa=$_POST["cA"];

if (!empty($_FILES['archivoEnvio']['name']))
{
	
	
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=generarNombreArchivoTemporal();
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	
	echo "1|".$nombreArchivo."|".$_FILES["archivoEnvio"]["name"]."|".filesize($baseDir."/archivosTemporales/".$nombreArchivo);
	
	
	
	
	

}
?>
