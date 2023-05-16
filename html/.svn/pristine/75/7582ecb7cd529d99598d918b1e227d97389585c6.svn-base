<?php session_start();

include("conexionBD.php");

$carpetaAdministrativa=$_POST["cA"];
$tipoIdentificacion=0;
if(isset($_POST["tipoIdentificacion"]))
	$tipoIdentificacion=$_POST["tipoIdentificacion"];

$tipoValor=$_POST["tipoValor"];
$idParticipante=$_POST["idParticipante"];
if (!empty($_FILES['archivoEnvio']['name']))
{
	$binario_nombre_temporal=$_FILES['archivoEnvio']['tmp_name'] ;
	$nombreArchivo=generarNombreArchivoTemporal();
	copy($binario_nombre_temporal,$baseDir."/archivosTemporales/".$nombreArchivo);
	
	$idDocumento=registrarDocumentoServidorRepositorio($nombreArchivo,$_FILES["archivoEnvio"]["name"],0,"");
	$consulta="SELECT idRegistro FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' 
				AND idParticipante=".$idParticipante." AND tipoValor=".$tipoValor;

	$idRegistro=$con->obtenerValor($consulta);
	if($idRegistro=="")
	{
		$consulta="INSERT INTO 7006_documentosParticipantesCarpetaAdministrativa(carpetaAdministrativa,idParticipante,tipoIdentificacion,tipoValor,idDocumento)
					VALUES('".$carpetaAdministrativa."',".$idParticipante.",".$tipoIdentificacion.",".$tipoValor.",".$idDocumento.")";
	}
	else
	{
		$consulta="UPDATE 7006_documentosParticipantesCarpetaAdministrativa SET tipoIdentificacion=".$tipoIdentificacion.
				",idDocumento=".$idDocumento." WHERE idRegistro=".$idRegistro;	
		
	}

	eC($consulta);
	

}
?>
