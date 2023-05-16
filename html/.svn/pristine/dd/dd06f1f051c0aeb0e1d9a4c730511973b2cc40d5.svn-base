<?php session_start();
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
ini_set('memory_limit', '-1');
set_time_limit(999000);
include("conexionBD.php");
include_once("PDFMerger.php");
$scanSession=$_POST["scanSession"];

$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
$nombreArchivo=rand()."_".date("dmY_Hms");
$rutaDestino=$baseDir."/archivosTemporales/".$nombreArchivo;
$rutaDestinoArchivoFinal=$baseDir."/archivosTemporales/".$scanSession;
copy($binario_nombre_temporal,$rutaDestino);
$_SESSION[$scanSession][$nombreArchivo]=$rutaDestino;

$merge = new PDFMerger();
foreach($_SESSION[$scanSession] as $fileName=>$pathFila)
{
	
	$merge->addPDF($pathFila);
	
}

$merge->merge("file",$rutaDestinoArchivoFinal);

echo "1|".$scanSession."|".$_FILES["archivoEnvio"]["name"]."|".filesize($rutaDestinoArchivoFinal);

?>
