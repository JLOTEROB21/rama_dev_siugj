<?php //session_start();
include("conexionBD.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=rand ( 1000 , 9999)."_". rand ( 1000 , 9999);
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	echo "1|".$nombreArchivo."|".$_FILES["archivoEnvio"]["name"]."|".filesize($baseDir."/archivosTemporales/".$nombreArchivo);
	
}


?>
