<?php  session_start();

		include("conexionBD.php");

	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	
	
	
	$consulta="SELECT * FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;

	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	if($fRegistro["tipoActuacion"]==17)
	{
		$tActuacion=$fRegistro["tipoActuacion"];
		$consulta="SELECT * FROM _698_tablaDinamica WHERE idProcesoPadre=285 AND idReferencia=".$fRegistro["id__699_tablaDinamica"];
		$idRegistro=$con->obtenerValor($consulta);
		$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRadicacionDemandaLaboral.html");
		$nombreDocumento=$baseDir."/archivosTemporales/actuacion_".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].".html";
	
		///
		
		$consulta="SELECT * FROM _698_tablaDinamica WHERE id__698_tablaDinamica=".$idRegistro;
	
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$nombreDocumento=$baseDir."/archivosTemporales/radicacion_".$fRegistro["carpetaAdministrativa"].".html";
	
		
		
		
		
		$consulta="SELECT nombreJurisdiccion FROM _623_tablaDinamica WHERE id__623_tablaDinamica=".$fRegistro["jurisdiccion"];
		$jurisdiccion=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".$fRegistro["especialidad"];
		$especialidad=$con->obtenerValor($consulta);
		
		/*$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistro["claseProceso"];
		$claseProceso=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreSubclaseProceso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fRegistro["subClaseProceso"];
		$subClaseProceso=$con->obtenerValor($consulta);*/
		
		$consulta="SELECT nombreTema FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRegistro["temaProceso"];
		$tema=$con->obtenerValor($consulta);
		
		$consulta="SELECT nombreSubtema FROM _629_tablaDinamica WHERE id__629_tablaDinamica=".$fRegistro["subtemaProceso"];
		$subTemaProceso=$con->obtenerValor($consulta);
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["departamentos"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistro["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
		$tipoProceso=$con->obtenerValor($consulta);
		
		$documentacion="";
		$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
			WHERE r.idFormulario=698 AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
		
		$rDocumentos=$con->obtenerFilas($query);
		while($fDocumento=mysql_fetch_row($rDocumentos))
		{
			if($documentacion=="")
				$documentacion=$fDocumento[0];
			else
				$documentacion.="<br>".$fDocumento[0];
		}
		
		$consulta="SELECT COUNT(*) FROM _698_tablaDinamica WHERE id__698_tablaDinamica=".$idRegistro." AND tipoProceso=3";
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
			$documentacion="(NO APLICA)";
		
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
		$arrDocumentos["folioRegistro"]=$fRegistro["codigo"];
		$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horadeRecepcion"]));
		$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["fechadeRecepcion"],false,false);;
		$arrDocumentos["tipoProceso"]=$tipoProceso;
		$arrDocumentos["codigoProceso"]=$fRegistro["carpetaAdministrativa"];
		
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica d,7006_carpetasAdministrativas cA WHERE cA.unidadGestion=d.claveUnidad
				AND cA.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
		
		$arrDocumentos["despacho"]=$con->obtenerValor($consulta);
		$consulta="SELECT nombreActuacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".$tActuacion;
		$arrDocumentos["lblLeyendaActuacion"]=$con->obtenerValor($consulta);
		$arrDocumentos["jurisdiccion"]=$jurisdiccion;
		$arrDocumentos["especialidad"]=$especialidad;
		/*$arrDocumentos["claseProceso"]=$claseProceso;
		$arrDocumentos["subClaseProceso"]=$subClaseProceso;*/
		$arrDocumentos["temaProceso"]=$tema;
		$arrDocumentos["subtemaProceso"]=$subTemaProceso;	
		$arrDocumentos["departamento"]=$departamento;
		$arrDocumentos["municipio"]=$municipio;
		$arrDocumentos["partes"]=$partes;
		$arrDocumentos["documentacion"]=$documentacion;
		$arrDocumentos["tituloProceso"]=$fRegistro["tituloProceso"];
		$arrDocumentos["cuantia"]=$fRegistro["tipoProceso"]==5?"NO APLICA":"$ ".number_format($fRegistro["cuantiaProceso"],2);
		
		foreach($arrDocumentos as $campo=>$valor)
		{
			$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
			
		}
		$directorioDestino=$baseDir."/archivosTemporales";
		$nombreDocumento="acuseDemanda_".$idRegistro;
		
		
		escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);
	
		generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
		if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
		{
			
			$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",11,"");
			//registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,632,$idRegistro);
			
			$archivoDestino=obtenerRutaDocumento($idDocumentoRegistrado);
			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($archivoDestino)); 
			header("Content-Disposition: inline; filename=".$archivoDestino);
			readfile($archivoDestino);
			
			
	
		}
		else
		{
			echo "NO existe";	
		}
		
		
		////
	
		return;
	
	}
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRegistroActuacion.html");	
	
	if($fRegistro["tipoActuacion"]==25)
	{
		$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRegistroActuacionApelacionAuto.html");
	}
	
	$nombreDocumento=$baseDir."/archivosTemporales/actuacion_".$fRegistro["carpetaAdministrativaActuacionesIntervinientes"].".html";
	
	$arrDocumentos=array();
	if($fRegistro["tipoActuacion"]==36)
	{
		$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRegistroActuacionSuplica.html");
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["campoComplementario"]."'";
		$arrDocumentos["despachoAtencion"]=$con->obtenerValor($consulta);
	}
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=699 AND idReferencia=".$idRegistro." AND c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
	$rDocumentos=$con->obtenerFilas($query);
	while($fDocumento=mysql_fetch_row($rDocumentos))
	{
		if($documentacion=="")
			$documentacion=$fDocumento[0];
		else
			$documentacion.="<br>".$fDocumento[0];
	}
	
	
	
	
	$arrDocumentos["folioRegistro"]=$fRegistro["codigo"];
	
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horaRec"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["fechaRecepcion"],false,false);;
	$arrDocumentos["documentacion"]=$documentacion;
	$arrDocumentos["cup"]=$fRegistro["carpetaAdministrativaActuacionesIntervinientes"];
	$arrDocumentos["interviniente"]=obtenerNombreParticipante($fRegistro["promovente"]);
	
	$consulta="SELECT nombreActuacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".$fRegistro["tipoActuacion"];
	
	$arrDocumentos["tipoActuacion"]=$con->obtenerValor($consulta);
	$arrDocumentos["resumenActuacion"]=trim($fRegistro["resumenActuacionActuaciones"])==""?"(SIN RESUMEN)":$fRegistro["resumenActuacionActuaciones"];
	
	
	$arrDocumentos["autoApelacion"]="";
	if($fRegistro["tipoActuacion"]==25)
	{
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fRegistro["autoApelacion"];
		$autoApelacion=$con->obtenerValor($consulta);
		$arrDocumentos["autoApelacion"]=$autoApelacion;
		
	}
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="acuseActuacion_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$nombreArchivoDestino="Actuacion_".str_replace("-","",$fRegistro["carpetaAdministrativaActuacionesIntervinientes"])."_".str_replace("/","_",$fRegistro["codigo"]).".pdf";
		//$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",87,"");
		//registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativaActuacionesIntervinientes"],$idDocumentoRegistrado,699,$idRegistro);
		//$archivoDestino=obtenerRutaDocumento($idDocumentoRegistrado);
		header("Content-type:application/pdf"); 
		header("Content-length: ".filesize($directorioDestino."/".$nombreDocumento.".pdf")); 
		header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
		readfile($directorioDestino."/".$nombreDocumento.".pdf");
		unlink($directorioDestino."/".$nombreDocumento.".pdf");
		
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>