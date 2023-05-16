<?php  session_start();

		include("conexionBD.php");

	$idRegistro=5;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
		
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SGJ/plantillas/acuseRadicacion.html");	
	
	
	$consulta="SELECT * FROM _632_tablaDinamica WHERE id__632_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$baseDir."/archivosTemporales/radicacion_".$fRegistro["carpetaAdministrativa"].".html";

	
	$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["despachoAsignado"]."'";
	$despacho=$con->obtenerValor($consulta);
	
	
	
	$consulta="SELECT nombreJurisdiccion FROM _623_tablaDinamica WHERE id__623_tablaDinamica=".$fRegistro["jurisdiccion"];
	$jurisdiccion=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE id__637_tablaDinamica=".$fRegistro["especialidad"];
	$especialidad=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreClaseProceso FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistro["claseProceso"];
	$claseProceso=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreSubclaseProceso FROM _627_tablaDinamica WHERE id__627_tablaDinamica=".$fRegistro["subClaseProceso"];
	$subClaseProceso=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreTema FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$fRegistro["temaProceso"];
	$tema=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreSubtema FROM _629_tablaDinamica WHERE id__629_tablaDinamica=".$fRegistro["subTemaProceso"];
	$subTemaProceso=$con->obtenerValor($consulta);
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["departamento"]."'";
	$departamento=$con->obtenerValor($consulta);
	
	$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistro["municipio"]."'";
	$municipio=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
	$tipoProceso=$con->obtenerValor($consulta);
	
	$documentacion="";
	$query="SELECT  cD.nombreCategoria FROM _632_documentacionRequerida d,908_categoriasDocumentos cD 
			WHERE d.idReferencia=".$idRegistro." AND cD.idCategoria=d.idDocumento AND (presentaDocumento=1 OR documentoAdjunto IS NOT NULL) ORDER BY cD.nombreCategoria";
	
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
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horaRecepcionDemanda"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["horaRecepcionDemanda"],false,false);;
	$arrDocumentos["tipoProceso"]=$tipoProceso;
	$arrDocumentos["codigoProceso"]=$fRegistro["carpetaAdministrativa"];
	$arrDocumentos["despacho"]=$despacho;
	$arrDocumentos["jurisdiccion"]=$jurisdiccion;
	$arrDocumentos["especialidad"]=$especialidad;
	$arrDocumentos["claseProceso"]=$claseProceso;
	$arrDocumentos["subClaseProceso"]=$subClaseProceso;
	$arrDocumentos["temaProceso"]=$tema;
	$arrDocumentos["subtemaProceso"]=$subTemaProceso;	
	$arrDocumentos["departamento"]=$departamento;
	$arrDocumentos["municipio"]=$municipio;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["documentacion"]=$documentacion;
	$arrDocumentos["tituloProceso"]=$fRegistro["tituloProceso"];
	$arrDocumentos["cuantia"]="$ ".number_format($fRegistro["cuantiaProceso"],2);
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="radicacion_".$arrDocumentos["codigoProceso"];
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",11,"");
		registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,632,$idRegistro);
		
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
	
	
		
?>