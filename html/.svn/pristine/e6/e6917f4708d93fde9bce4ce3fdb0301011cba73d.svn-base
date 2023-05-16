<?php session_start();

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	$carpetaJudicial=$_POST["carpetaJudicial"];
	$nombreBusqueda=$_POST["nombreBusqueda"];
	$tipoConstancia=-1;
	if(isset($_POST["tipoConstancia"]))
		$tipoConstancia=$_POST["tipoConstancia"];
	
	$PHPWord = new PHPWord();
	$documento=null;
	if($tipoConstancia==1)
		$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\plantillaBusquedaExitosa.docx');	
	else
		$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\plantillaBusquedaSinExito.docx');	
	
	$arrValores=array();
	$fechaActual=strtotime(date("Y-m-d H:i:s"));
	
	$noCarpeta=1;
	$listaCarpetas="";
	$arrCarpetas=explode(",",$carpetaJudicial);
	foreach($arrCarpetas as $c)
	{
		if($listaCarpetas=="")
			$listaCarpetas=$noCarpeta.".- ".$c;
		else
			$listaCarpetas.="\r\n".$noCarpeta.".- ".$c;
		$noCarpeta++;
	}
	
	$arrValores["diaInforme"]=date("d",$fechaActual);
	$arrValores["mesInforme"]=ucfirst($arrMesLetra[(date("m",$fechaActual)*1)-1]);
	$arrValores["anioInforme"]=date("Y",$fechaActual);
	$arrValores["horaCreacion"]=date("d/m/Y H:i:s",$fechaActual);
	$arrValores["carpetaJudicial"]=$listaCarpetas;
	$arrValores["nombreBusqueda"]=$nombreBusqueda;
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