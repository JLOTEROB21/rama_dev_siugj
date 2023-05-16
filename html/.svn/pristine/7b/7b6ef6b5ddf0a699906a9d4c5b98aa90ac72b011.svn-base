<?php  session_start();

		include("conexionBD.php");

	$idFormulario=944;
	$idRegistro=148;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/actaRepartoApelacionTribunalSuperior.html");	
	
	
	$consulta="SELECT * FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;

	$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
	if($fRegistroBase["tipoApelacion"]==2)
			$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/actaRepartoApelacionTribunalSuperiorSentencia.html");	
	
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["codigoInstitucion"]."'";
	$despachoEnvia=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["despachoAsignado"]."'";
	$despachoAsignado=$con->obtenerValor($consulta);
	
	$carpetaAdministrativa=$fRegistroBase["carpetaAdministrativa"];
	$carpetaAdministrativaApelacion=$fRegistroBase["carpetaAdministrativa2daInstancia"];
	
	
	
	
	$arrCarpetas=array();
	obtenerCarpetasPadre($carpetaAdministrativa,$arrCarpetas);
	if(sizeof($arrCarpetas)==0)
	{
		array_push($arrCarpetas,$carpetaAdministrativa);
	}
	
	$carpetaAdministrativa=$arrCarpetas[0];
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistroBase["carpetaAdministrativa2daInstancia"]."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$nombreDocumento=$baseDir."/archivosTemporales/envioApelacionTribunalSuperior_".$fRegistroBase["carpetaAdministrativa2daInstancia"].".html";
	
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=".$idFormulario." AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
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
	
	$query="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND etapaActual=4.9 ORDER BY idRegistroEstado DESC";

	$fechaRepartoTS=$con->obtenerValor($query);
	$arrDocumentos=array();
	$arrDocumentos["folioRegistro"]=$fRegistroBase["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fechaRepartoTS));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fechaRepartoTS,false,false);;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["procesoJudicial"]=$carpetaAdministrativa;
	$arrDocumentos["despachoEnvia"]=$despachoEnvia;
	$arrDocumentos["despachoAsignado"]=$despachoAsignado;
	$arrDocumentos["procesoJudicialAsignado"]=$carpetaAdministrativaApelacion;
	
	$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($fRegistroBase["autoRecurso"]==""?-1:$fRegistroBase["autoRecurso"]);
	$autoApelacion=$con->obtenerValor($consulta);

	$arrDocumentos["autoApelacion"]=$autoApelacion;	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="actaRepartoApelacion";
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa con,908_archivos a
					WHERE con.carpetaAdministrativa='".$carpetaAdministrativaApelacion.
					"' AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
					AND a.categoriaDocumentos=91";
		$numRegistros=$con->obtenerValor($consulta);

		if($numRegistros==0)
		{
			$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",91,"");
			registrarDocumentoCarpetaAdministrativa($fRegistroBase["carpetaAdministrativa"],$idDocumentoRegistrado,$idFormulario,$idRegistro);
			registrarDocumentoCarpetaAdministrativa($carpetaAdministrativaApelacion,$idDocumentoRegistrado,$idFormulario,$idRegistro);
			
			registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
			
			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($directorioDestino."/".$nombreDocumento.".pdf")); 
			header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
			cambiarEtapaFormulario($idFormulario,$idRegistro,5,"",-1,"NULL","NULL",0);	
			echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
		}
		else
		{
			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($directorioDestino."/".$nombreDocumento.".pdf")); 
			header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
			readfile($directorioDestino."/".$nombreDocumento.".pdf");
		
		}
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>