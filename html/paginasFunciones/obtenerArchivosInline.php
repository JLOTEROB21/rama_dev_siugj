<?php
include("conexionBD.php");

if(isset($_GET['id'])) 
{	
	$idDocumento=bD($_GET['id']);
	
	if(strpos($idDocumento,"_")===false)
	{
		$sql = "SELECT nomArchivoOriginal,documento,tipoArchivo,tamano,enBD FROM 908_archivos WHERE idArchivo=".$idDocumento;
		
		$res=$con->obtenerRegistros($sql);
		$res[0]=str_replace(",","",$res[0]);
		header("Content-type: ".$res[2]);
		header("Content-length: ".$res[3]); 

		header("Content-Disposition: inline; filename=".$res[0]);
		
		
		
		if($res[4]==1)
			echo $res[1];
		else
			readfile("../documentosUsr/archivo_".bD($_GET["id"]));
	}
	else
	{
		header("Content-length: ".filesize("../archivosTemporales/".$idDocumento)); 
		header("Content-Disposition: inline; filename=".$idDocumento);
		readfile("../archivosTemporales/".$idDocumento);
	}
}
?> 