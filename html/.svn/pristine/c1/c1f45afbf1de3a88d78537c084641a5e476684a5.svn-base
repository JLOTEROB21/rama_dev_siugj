<?php session_start();

	include("conexionBD.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	
	
	
	
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=rand ( 1000 , 9999)."_". rand ( 1000 , 9999);
	$pathRuta=$baseDir."/archivosTemporales/".$nombreArchivo;
	copy($binario_nombre_temporal,$pathRuta);
	
	$resultado=importacionArchivoDeposito($pathRuta,$_FILES['archivoEnvio']['name']);
	
	echo "1|".$resultado;
	
	
}


?>
