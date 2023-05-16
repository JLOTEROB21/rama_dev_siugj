<?php 
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
include("conexionBD.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=rand()."_".date("dmY_Hms");
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	echo "1|".$nombreArchivo."|".$_FILES["archivoEnvio"]["name"]."|".filesize($baseDir."/archivosTemporales/".$nombreArchivo);
}
?>
