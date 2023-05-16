<?php session_start();
include("conexionBD.php");
include_once("latisErrorHandler.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=generarNombreArchivoTemporal();
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	
	$nombreDocumento=$_FILES["archivoEnvio"]["name"];
	$sha512=strtoupper(hash_file("sha512" ,$baseDir."/archivosTemporales/".$nombreArchivo,false));
	$consulta="SELECT idArchivo,nomArchivoOriginal,sha512 FROM 908_archivos WHERE sha512='".$sha512."'";
	$fila=$con->obtenerPrimeraFilaAsoc($consulta);
	$permiteMostrar="true";
	if($fila)
	{
		$permiteMostrar=permiteObservarDocumento($fila["idArchivo"])?"true":"false";
	}
			
	$o='{"idArchivo":"'.(isset($fila["idArchivo"])?$fila["idArchivo"]:"").'","nomArchivoOriginal":"'.cv($_FILES['archivoEnvio']['name']).'","sha512":"'.$sha512.'","permiteMostrar":"'.$permiteMostrar.'"}';
	
	unlink($baseDir."/archivosTemporales/".$nombreArchivo);
	
	echo "1|".bE($o);
	

}
?>
