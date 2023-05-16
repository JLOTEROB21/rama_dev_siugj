<?php
include("conexionBD.php");

if(isset($_GET['Id'])) 
{	
	$consulta = "SELECT Nombre,Binario,Tipo,Tamano FROM 806_fotos WHERE idUsuario=".$_GET['Id'];
	$fila=$con->obtenerPrimeraFilaAsoc($consulta);
	
	if($fila["Nombre"]!="")
	{
		$consulta="SELECT tipoArchivo,tamano,nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fila["Nombre"];
		$fArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
		//header("Content-type: ".$fArchivo["tipoArchivo"]);
		header("Content-length: ".$fArchivo["tamano"]); 
		header("Content-Disposition: inline; filename=".$fArchivo["nomArchivoOriginal"]);
		echo bD(obtenerCuerpoDocumentoB64($fila["Nombre"]));
	}
	else
	{
		$resp = file_get_contents('../images/No_foto.png'); 
		echo $resp;
	}
}
?>