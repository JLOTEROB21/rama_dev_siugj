<?php session_start();
include("conexionBD.php");

$carpetaAdministrativa=$_POST["cA"];

$idCarpetaAdministrativa=-1;
if(isset($_POST["idCarpetaAdministrativa"]))
	$idCarpetaAdministrativa=$_POST["idCarpetaAdministrativa"];

if (!empty($_FILES['archivoEnvio']['name']))
{
	
	
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=generarNombreArchivoTemporal();
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	
	
	
	$idDocumento=registrarDocumentoServidorRepositorio($nombreArchivo,$_FILES["archivoEnvio"]["name"],0,"");

	if($idDocumento!=-1)
	{
		if(registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,-1,-1,$idCarpetaAdministrativa))
			echo "1|";
	}
	
	

}
?>
