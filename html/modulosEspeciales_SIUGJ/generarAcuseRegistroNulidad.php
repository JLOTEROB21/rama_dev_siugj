<?php  session_start();

		include("conexionBD.php");

	$idFormulario="1010";
	$idRegistro=5;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRadicacionNulidad.html");	
	
	
	$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;

	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$baseDir."/archivosTemporales/radicacion_".$fRegistro["carpetaAdministrativa"].".html";

	
	
	
	
	$consulta="SELECT nombreJurisdiccion FROM _623_tablaDinamica WHERE id__623_tablaDinamica=".$fRegistro["jurisdiccion"];
	$jurisdiccion=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".$fRegistro["especialidad"];
	$especialidad=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistro["claseProceso"];
	$claseProceso=$con->obtenerValor($consulta);
	
	
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["departamento"]."'";
	$departamento=$con->obtenerValor($consulta);
	
	$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistro["municipio"]."'";
	$municipio=$con->obtenerValor($consulta);
	
	
	
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
	
	$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
	$tipoProceso=$con->obtenerValor($consulta);
	
	$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13857 AND valor=".$fRegistro["tipoSubProceso"];
	$subtipoProceso=$con->obtenerValor($consulta);
	
	$arrDocumentos=array();
	$arrDocumentos["folioRegistro"]=$fRegistro["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horaRecepcion"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["fechadeRecepcion"],false,false);;
	$arrDocumentos["codigoProceso"]=$fRegistro["carpetaAdministrativa"];
	$arrDocumentos["tipoProceso"]=$tipoProceso;
	$arrDocumentos["subtipoProceso"]=$subtipoProceso;
	
	
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica d,7006_carpetasAdministrativas cA WHERE cA.unidadGestion=d.claveUnidad
				AND cA.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		
	$arrDocumentos["despacho"]=$con->obtenerValor($consulta);

	$arrDocumentos["jurisdiccion"]=$jurisdiccion;
	$arrDocumentos["especialidad"]=$especialidad;
	$arrDocumentos["claseProceso"]=$claseProceso;
	$arrDocumentos["departamento"]=$departamento;
	$arrDocumentos["municipio"]=$municipio;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["documentacion"]=$documentacion;
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="actaReparto_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$tamano=filesize($directorioDestino."/".$nombreDocumento.".pdf");
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",11,"");
		registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,$idFormulario,$idRegistro);
		registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
		
		header("Content-type:application/pdf"); 
		header("Content-length: ".$tamano); 
		header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
		echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
		
		//cambiarEtapaFormulario($idFormulario,$idRegistro,5,"",-1,"NULL","NULL",0);
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>