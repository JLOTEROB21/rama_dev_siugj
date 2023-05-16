<?php session_start();

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	set_time_limit(999000);
	
	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
		
	$PHPWord = new PHPWord();
	$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\plantillaAcuseExhorto.docx');	
	
	
	$consulta="SELECT * FROM _524_tablaDinamica WHERE id__524_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	while($fRegistro["carpetaExhorto"]=="N/E")
	{
		cambiarEtapaFormulario(524,$idRegistro,2,"",-1,"NULL","NULL",923);
		$consulta="SELECT * FROM _524_tablaDinamica WHERE id__524_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	}
	
	$fechaActual=strtotime(date("Y-m-d H:i:s"));
	$arrValores=array();
	$arrValores["leyendaTribunal"]=$leyendaTribunal;
	$arrValores["fecha"]=date("d/m/Y H:i:s",$fechaActual)."   ".$fRegistro["responsable"];
	$arrValores["folioRegistro"]=$fRegistro["codigo"];
	$arrValores["fechaRegistro"]=date("d/m/Y H:i:s",strtotime($fRegistro["fechaCreacion"]));
	$arrValores["numeroCausa"]=mb_strtoupper($fRegistro["numeroCausaOrigen"]);
	$arrValores["autoridad"]=mb_strtoupper($fRegistro["juezExhortante"].". ".$fRegistro["juzgadoExhortante"]);
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["estadoEntidadExhortante"]."'";
	$entidadFederativa=$con->obtenerValor($consulta);
	$arrValores["entidadFederativa"]=mb_strtoupper($entidadFederativa);
	$arrValores["carpetaExhorto"]=$fRegistro["carpetaExhorto"];
	$arrValores["noOficio"]=$fRegistro["noOficio"];

	
	$consulta="SELECT ug.nombreUnidad AS unidadGestion 
				FROM 7006_carpetasAdministrativas c,_17_tablaDinamica ug WHERE carpetaAdministrativa='".$fRegistro["carpetaExhorto"]."' AND
				ug.claveUnidad=c.unidadGestion";
	
	$unidadGestion=$con->obtenerValor($consulta);
	
	$arrValores["unidadGestion"]=mb_strtoupper($unidadGestion);
	
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