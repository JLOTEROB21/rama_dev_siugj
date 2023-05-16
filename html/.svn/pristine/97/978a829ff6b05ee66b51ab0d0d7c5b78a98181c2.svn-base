<?php
include("latis/conexionBD.php");

if(isset($_POST['iDocumento'])) 
{	
	$rutaDocumento=$baseDir."/archivosTmpPDF/".$_POST['iDocumento'].".pdf";
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=".$_POST['iDocumento'].".pdf");
	header("Content-length: ".filesize($rutaDocumento));
	readfile($rutaDocumento);
	unlink($rutaDocumento);
}
?>