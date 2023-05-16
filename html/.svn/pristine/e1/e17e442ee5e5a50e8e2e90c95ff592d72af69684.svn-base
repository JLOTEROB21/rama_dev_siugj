<?php session_start();
include("conexionBD.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	//echo $binario_nombre_temporal."<br>";
	$nombreArchivo=rand()."_".date("dmY_Hms");
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	echo "1|".$nombreArchivo."|".$_FILES["archivoEnvio"]["name"];
}
?>