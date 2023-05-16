<?php

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	
	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
		
	$PHPWord = new PHPWord();
	$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\acuseExhorto.docx');	
	
	
	$consulta="SELECT * FROM _345_tablaDinamica WHERE id__345_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$arrValores=array();
	$arrValores["folioRegistro"]=$fRegistro["codigo"];
	$arrValores["fechaRegistro"]=date("d/m/Y H:i:s",strtotime($fRegistro["fechaCreacion"]));
	$arrValores["numeroCausa"]=$fRegistro["numeroCausaOrigen"];
	$arrValores["autoridad"]=$fRegistro["autoridadExhortante"];
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["entidadFederativa"]."'";
	$entidadFederativa=$con->obtenerValor($consulta);
	$arrValores["entidadFederativa"]=$entidadFederativa;
	$arrValores["carpetaExhorto"]=$fRegistro["carpetaExhorto"];
	
	
	$consulta="SELECT CONCAT('[',ug.claveFolioCarpetas,'] ',ug.nombreUnidad) AS unidadGestion 
				FROM 7006_carpetasAdministrativas c,_17_tablaDinamica ug WHERE carpetaAdministrativa='".$fRegistro["carpetaExhorto"]."' AND
				ug.claveUnidad=c.unidadGestion";
	
	$unidadGestion=$con->obtenerValor($consulta);
	
	$arrValores["unidadGestion"]=$unidadGestion;
	
	foreach($arrValores as $llave=>$valor)
	{
		$document->setValue("[".$llave."]",utf8_decode($valor));	
	}
	
	$nombreAleatorio=generarNombreArchivoTemporal();
	$nomArchivo=$nombreAleatorio.".docx";
	$document->save($nomArchivo);
	
	$nombreFinal=str_replace(".docx",".pdf",$nomArchivo);
	generarDocumentoPDF($nomArchivo,false,false,true,$nombreFinal,"","./");
	
	header("Content-type:application/pdf"); 
	header("Content-length: ".filesize($nombreFinal)); 
	header("Content-Disposition: inline; filename=".$nombreFinal);
	readfile($nombreFinal);
	
	
	unlink($nombreFinal);
	return $nombreFinal;
	
?>