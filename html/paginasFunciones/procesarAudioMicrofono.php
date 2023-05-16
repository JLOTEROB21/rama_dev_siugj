<?php 
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
include("conexionBD.php");

if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=rand()."_".date("dmY_Hms");
	$rutaDestino=$baseDir."/archivosTemporales/".$nombreArchivo;
	$rutaDestinoSalida=$baseDir."/archivosTemporales/salida_".$nombreArchivo.".txt";
	copy($binario_nombre_temporal,$rutaDestino);
	$arrSalida=array();
	$resultado="";
	$resultado='{"ejecutado":"0","resultado":""}';
	
	$comando="pocketsphinx_continuous -infile ".$rutaDestino." -hmm /var/www/espanol/es -lm /var/www/espanol/es-20k.lm -dict /var/www/espanol/es.dict >".$rutaDestinoSalida;  
	
	exec($comando,$arrSalida,$resultado);	
	if(file_exists($rutaDestinoSalida))
	{
		$resultadoAnalisis=leerContenidoArchivo($rutaDestinoSalida);
		$resultado='{"ejecutado":"1","resultado":"'.bE($resultadoAnalisis).'"}';
		unlink($rutaDestinoSalida);
	}
	
	unlink($rutaDestino);
	
	echo "1|".$resultado;
}