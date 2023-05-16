<?php  session_start();

		include("conexionBD.php");

	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRegistroSolicitudDocumento.html");	
	
	
	$consulta="SELECT * FROM _709_tablaDinamica WHERE id__709_tablaDinamica=".$idRegistro;

	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$baseDir."/archivosTemporales/solicitudDocumento_".$fRegistro["carpetaAdministrativa"].".html";

	
	$arrDocumentos=array();
	$arrDocumentos["folioRegistro"]=$fRegistro["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horaRecepcion"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["fechaRecepcion"],false,false);;
	$arrDocumentos["descripcionSolicitud"]=$fRegistro["descripcionDocumentacionRequeridaSolicitudDocumento"];
	$arrDocumentos["cup"]=$fRegistro["carpetaAdministrativa"];
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="solicitudDocumento_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$tamano=filesize($directorioDestino."/".$nombreDocumento.".pdf");
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",87,"");
		registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,709,$idRegistro);
		
		header("Content-type:application/pdf"); 
		header("Content-length: ".$tamano); 
		header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
		echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
		
		
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>