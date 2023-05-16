<?php  session_start();
		
		include("conexionBD.php");
	$idFormulario=698;
	$idRegistro=794;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];
	
	
	if(!isset($_POST["idUsr"]))
	{
		aperturarSesionUsuario(2);
	}
		
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRadicacionDemanda.html");	
	
	
	$consulta="SELECT * FROM _698_tablaDinamica WHERE id__698_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$baseDir."/archivosTemporales/radicacion_".$fRegistro["carpetaAdministrativa"].".html";

	
	$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["despachoAsignado"]."'";
	$despacho=$con->obtenerValor($consulta);
	
	
	
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
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".($fRegistro["departamentoRadicacion"]==""?"-1":$fRegistro["departamentoRadicacion"])."'";
	$departamentoRadicacion=$con->obtenerValor($consulta);
	
	$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".($fRegistro["municipioRadicacion"]==""?"-1":$fRegistro["municipioRadicacion"])."'";
	$municipioRadicacion=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
	$tipoProceso=$con->obtenerValor($consulta);
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=698 AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
	
	$rDocumentos=$con->obtenerFilas($query);
	while($fDocumento=$con->fetchRow($rDocumentos))
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
	while($fParte=$con->fetchRow($rParte))
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
	$arrDocumentos["despacho"]=$despacho;
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
	
	$arrDocumentos["departamentoRadicacion"]=$departamentoRadicacion;
	$arrDocumentos["municipioRadicacion"]=$municipioRadicacion;
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="actaReparto_".$arrDocumentos["codigoProceso"];


	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);

	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		
		
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa con,908_archivos a
					WHERE con.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
					"' AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
					AND a.categoriaDocumentos=11";
		$numRegistros=$con->obtenerValor($consulta);

		if($numRegistros==0)
		{
			$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",11,"");
			registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,698,$idRegistro);
			registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
			cambiarEtapaFormulario($idFormulario,$idRegistro,4,"",-1,"NULL","NULL",0);
			header("Content-type:application/pdf"); 
			header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
			echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
			return;
		}
		else
		{
			$archivoDestino=$directorioDestino."/".$nombreDocumento.".pdf";
		}
		
		header("Content-type:application/pdf"); 
		header("Content-length: ".filesize($archivoDestino)); 
		header("Content-Disposition: inline; filename=".$archivoDestino);
		readfile($archivoDestino);
		
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>
