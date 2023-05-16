<?php
include("conexionBD.php"); 
$ref=$_POST["ref"];
$arrDatosDocumento=explode("_",$ref);
$idDocumento=bD($arrDatosDocumento[1]);
$consulta="SELECT if(idDocumento is null,idDocumentoAdjunto,idDocumento) FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$idDocumento;
$idDocumento=$con->obtenerValor($consulta);

$consulta="SELECT nomArchivoOriginal,tamano FROM 908_archivos WHERE idArchivo=".$idDocumento;
$fDocumento=$con->obtenerPrimeraFila($consulta);
header("Content-type: application/pdf");
header("Content-length: ".$fDocumento[1]); 

if(!isset($_POST["attachment"]))
	header("Content-Disposition: inline; filename=".str_replace(' ','_',$fDocumento[0]));
else
	header("Content-Disposition: attachment; filename=".str_replace(' ','_',$fDocumento[0]));

$cuerpoDocumento=bD(obtenerCuerpoDocumentoB64($idDocumento));
echo ($cuerpoDocumento);
?>