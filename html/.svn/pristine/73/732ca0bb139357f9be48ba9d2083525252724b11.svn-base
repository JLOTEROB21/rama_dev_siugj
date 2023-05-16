<?php
include("conexionBD.php");

if(isset($_GET['id'])) 
{	
	$sql = "SELECT nomArchivoOriginal,documento,tipoArchivo,tamano FROM 4022_alumnoVsDocumento WHERE idAlumnoVsDocumento=".base64_decode($_GET['id']);
	$res=$con->obtenerRegistros($sql);
	header("Content-type: ".$res[2]);
    header("Content-length: ".$res[3]); 
    header("Content-Disposition: inline; filename=".$res[0]);
	echo $res[1];
}
?> 