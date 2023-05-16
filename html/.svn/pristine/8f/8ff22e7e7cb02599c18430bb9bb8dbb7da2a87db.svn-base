<?php session_start();

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	
	$idRegistro=6;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	
	$idFormulario=562;
	if(isset($_POST["idFormulario"]))
		$idFormulario=$_POST["idFormulario"];
		
		
		
		
	$PHPWord = new PHPWord();
	$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\formatoAccesoVideograbacion.docx');	
	
	
	$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

	$codigoAcceso=$fRegistro["codigoAcceso"];
	$fechaVigencia=strtotime($fRegistro["vigenciaAcceso"]);
	$fechaActual=strtotime($fRegistro["fechaCreacion"]);
	
	
	$consulta="SELECT ug.nombreUnidad AS unidadGestion 
				FROM 7006_carpetasAdministrativas c,_17_tablaDinamica ug WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."' AND
				ug.claveUnidad=c.unidadGestion";

	$unidadGestion=$con->obtenerValor($consulta);
	
	$arrValores=array();
	
	$arrValores["dia"]=date("d",$fechaActual);
	$arrValores["mes"]=$arrMesLetra[(date("m",$fechaActual)*1)-1];
	$arrValores["anio"]=date("Y",$fechaActual);
	
	$arrValores["unidad"]=mb_strtoupper($unidadGestion);
	

	$consulta="SELECT nombre,apellidoPaterno,apellidoMaterno FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fRegistro["solicitante"];

	$solicitante=$con->obtenerPrimeraFila($consulta);
	
	$arrValores["nombreSolicitante"]=$solicitante[0]." ".$solicitante[1]." ".$solicitante[2];
	
	
	$consulta="SELECT horaInicioEvento,
				(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) AS tipoAudiencia 
				FROM 7000_eventosAudiencia e WHERE idRegistroEvento=".$fRegistro["idEventoAudiencia"];
	$fEvento=$con->obtenerPrimeraFila($consulta);

	$fechaEvento=strtotime($fEvento[0]);
	$arrValores["fechaAudiencia"]=date("d",$fechaEvento)." de ".$arrMesLetra[(date("m",$fechaEvento)*1)-1]." de ".date("Y",$fechaEvento).
								" a las ".date("H:i",$fechaEvento)." hrs (".$fEvento[1].")";
	
	$arrValores["carpetaAdministrativa"]=$fRegistro["carpetaAdministrativa"];
	$arrValores["codigoAcceso"]=$codigoAcceso;
	$arrValores["direccion"]="http://sigue.poderjudicialcdmx.gob.mx/principalPortal/principal.php";
	$arrValores["fechaVigencia"]=date("d",$fechaVigencia)." de ".$arrMesLetra[(date("m",$fechaVigencia)*1)-1]." de ".date("Y",$fechaVigencia).
								" a las ".date("H:i",$fechaVigencia)." hrs";
	
	
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
	
?>