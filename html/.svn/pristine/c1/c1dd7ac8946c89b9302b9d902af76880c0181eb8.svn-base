<?php
include("conexionBD.php");

if(isset($_GET['d'])) 
{	
	$idDocumento=$_GET['d'];
	
	$consulta="SELECT AES_DECRYPT(UNHEX('".$idDocumento."'), '".bD($versionLatis)."')";
	$idDocumento=$con->obtenerValor($consulta);			
	$sql = "SELECT nomArchivoOriginal,documento,tipoArchivo,tamano,enBD,documentoRepositorio FROM 908_archivos WHERE idArchivo=".$idDocumento;

	$res=$con->obtenerPrimeraFila($sql);
	$arrDocumentos=explode(".",$res[0]);
	
	switch(strtolower($arrDocumentos[1]))
	{
		case "pdf":
			$res[2]="application/pdf";
		break;
	}
	

	$res[0]=str_replace(",","",$res[0]);
	header("Content-type: ".$res[2]);
	header("Content-length: ".$res[3]); 
	
	$modo="attachment";
	header("Content-Disposition: ".$modo."; filename=".$res[0]);
	$rutaDocumento=obtenerRutaDocumento($idDocumento);
	
	if($res[4]==1)
		echo $res[1];
	else
	{
		
		if($rutaDocumento!="")
		{
			if(strpos($rutaDocumento,"http")!==false)
			{
				$cuerpoDocumento=file_get_contents($rutaDocumento);
				echo bD($cuerpoDocumento);
			}
			else
				readfile($rutaDocumento);
		}
		else
		{
			if($res[5]!="")
			{
				$cadObj=file_get_contents("http://10.2.51.41:8000/api/document?instanceName=tsj&idGlobal=".$res[5]);
				$objDocumento=json_decode($cadObj);
				
				echo bD($objDocumento->file64);
				
			}
			else
				echo file_get_contents("http://10.19.5.9/paginasFunciones/obtenerDocumentoEditorArchivos.php?id=".bE($idDocumento)."&nombreArchivo=".$res[0]);
		}
	}
		
	
	
}
?>