<?php include("conexionBD.php");
	$documentoPDF=$_POST["documentoPDF"];
	$nombreDocumento=$_POST["nombreDocumento"];
	$arrPDF=explode("base64,",$documentoPDF);
	$nombreArchivo=generarNombreArchivoTemporal();
	escribirContenidoArchivo($baseDir."/archivosTemporales/".$nombreArchivo,bD($arrPDF[1]));
	header("Content-type:application/pdf"); 
	header("Content-length: ".filesize($baseDir."/archivosTemporales/".$nombreArchivo)); 
	header("Content-Disposition: inline; filename=".$nombreDocumento);
	readfile($baseDir."/archivosTemporales/".$nombreArchivo);
	
	
	unlink($baseDir."/archivosTemporales/".$nombreArchivo);
?>