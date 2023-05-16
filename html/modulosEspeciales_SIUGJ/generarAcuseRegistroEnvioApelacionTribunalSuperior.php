<?php  session_start();

		include("conexionBD.php");
	
	$idFormulario=944;
	$idRegistro=8;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
			
	$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;
	$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);			
			
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseEnvioApelacionTribunalSuperior.html");	
	
	if($fRegistroBase["tipoApelacion"]==2)
		$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseEnvioApelacionTribunalSuperiorSentencia.html");	
	
	
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["codigoInstitucion"]."'";
	$despachoEnvia=$con->obtenerValor($consulta);
	
	$carpetaAdministrativa=$fRegistroBase["carpetaAdministrativa"];
	
	
	
	
	$arrCarpetas=array();
	obtenerCarpetasPadre($carpetaAdministrativa,$arrCarpetas);
	if(sizeof($arrCarpetas)==0)
	{
		array_push($arrCarpetas,$carpetaAdministrativa);
	}
	
	$carpetaAdministrativa=$arrCarpetas[0];
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$nombreDocumento=$baseDir."/archivosTemporales/envioApelacionTribunalSuperior_".$fRegistroBase["carpetaAdministrativa"].".html";
	
	
	

	
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=944 AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
	$rDocumentos=$con->obtenerFilas($query);
	while($fDocumento=mysql_fetch_row($rDocumentos))
	{
		if($documentacion=="")
			$documentacion=$fDocumento[0];
		else
			$documentacion.="<br>".$fDocumento[0];
	}
	
	
	
	$partes="";
	$query="SELECT CONCAT(if (nombre IS NULL,'',nombre),' ',if( apellidoPaterno IS NULL,'',apellidoPaterno),' ',if(apellidoMaterno IS NULL,'',apellidoMaterno) ) AS nombre,
			f.nombreTipo FROM _47_tablaDinamica i,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$fRegistro["idActividad"]."
			AND r.idParticipante=i.id__47_tablaDinamica AND f.id__5_tablaDinamica=r.idFiguraJuridica ORDER BY nombre,apellidoPaterno,apellidoMaterno";
	$rParte=$con->obtenerFilas($query);
	while($fParte=mysql_fetch_row($rParte))
	{
		if($partes=="")
			$partes=$fParte[0]." (".$fParte[1].")";
		else
			$partes.="<br>".$fParte[0]." (".$fParte[1].")";
	}
	$arrDocumentos=array();
	$arrDocumentos["folioRegistro"]=$fRegistroBase["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistroBase["fechaEnvioTS"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistroBase["fechaEnvioTS"],false,false);;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["procesoJudicial"]=$carpetaAdministrativa;
	$arrDocumentos["despachoEnvia"]=$despachoEnvia;
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($fRegistroBase["autoRecurso"]==""?-1:$fRegistroBase["autoRecurso"]);
	$autoApelacion=$con->obtenerValor($consulta);

	$arrDocumentos["autoApelacion"]=$autoApelacion;	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="acuseApelacionTS_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$tamano=filesize($directorioDestino."/".$nombreDocumento.".pdf");
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",90,"");
		registrarDocumentoCarpetaAdministrativa($fRegistroBase["carpetaAdministrativa"],$idDocumentoRegistrado,944,$idRegistro);
		registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
		$archivoDestino=obtenerRutaDocumento($idDocumentoRegistrado);
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