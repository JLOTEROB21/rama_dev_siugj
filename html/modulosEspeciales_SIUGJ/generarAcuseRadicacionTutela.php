<?php  session_start();

		include("conexionBD.php");
	$idFormulario=717;
	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];
	
	if(!isset($_POST["idUsr"]))
	{
		aperturarSesionUsuario(2);
	}
		
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseRadicacionTutela.html");	
	
	
	$consulta="SELECT * FROM _717_tablaDinamica WHERE id__717_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$baseDir."/archivosTemporales/radicacion_".$fRegistro["carpetaAdministrativa"].".html";

	
	$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fRegistro["despachoAsignado"]."'";
	$despacho=$con->obtenerValor($consulta);
	
	
	
	
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["departamentosRegistroTutela"]."'";
	$departamento=$con->obtenerValor($consulta);
	
	$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistro["ciudadRegistroTutela"]."'";
	$municipio=$con->obtenerValor($consulta);
	
	
	
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=717 AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
	
	$rDocumentos=$con->obtenerFilas($query);
	while($fDocumento=$con->fetchRow($rDocumentos))
	{
		if($documentacion=="")
			$documentacion=$fDocumento[0];
		else
			$documentacion.="<br>".$fDocumento[0];
	}
	
	
	$derechos="";
	$query="SELECT cT.derechoCatalogoDerechosTutela FROM _717_gridDerechoVulnerableRegistroTutela rT,_716_tablaDinamica cT WHERE rT.idReferencia=".$idRegistro." AND 
			cT.id__716_tablaDinamica=rT.derechoVulnerableRegistroTutela ORDER BY cT.derechoCatalogoDerechosTutela";
	$rDerechos=$con->obtenerFilas($query);
	while($fDerecho=$con->fetchRow($rDerechos))
	{
		if($derechos=="")
			$derechos=$fDerecho[0];
		else
			$derechos.="<br>".$fDerecho[0];
	}
	
	
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
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistro["horaRecepcionRegistroTutela"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistro["fechaRecepcionRegistroTutela"],false,false);;
	$arrDocumentos["existeMedidaProvisional"]=$fRegistro["medidaProvisional"]==1?"S&iacute;":"No";
	$arrDocumentos["codigoProceso"]=$fRegistro["carpetaAdministrativa"];
	$arrDocumentos["derechos"]=$derechos;
	$arrDocumentos["departamento"]=$departamento;
	$arrDocumentos["municipio"]=$municipio;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["documentacion"]=$documentacion;
	$arrDocumentos["codigoProceso"]=$fRegistro["carpetaAdministrativa"];
	$arrDocumentos["despacho"]=$despacho;
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="actaRepartoTutela_".$arrDocumentos["codigoProceso"];
	
	
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
			registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,717,$idRegistro);
			registrarDocumentoResultadoProceso(717,$idRegistro,$idDocumentoRegistrado);
			
			header("Content-type:application/pdf"); 
			header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
			echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
			return;
			
			
		}
		else
		{
			$archivoDestino=$directorioDestino."/".$nombreDocumento.".pdf";
		}
		$nombreArchivoDestino="Tutela_".str_replace("-","",$fRegistro["carpetaAdministrativa"])."_".str_replace("/","_",$fRegistro["codigo"]).".pdf";
		header("Content-type:application/pdf"); 
		header("Content-length: ".filesize($archivoDestino)); 
		header("Content-Disposition: inline; filename=".$nombreArchivoDestino);
		readfile($archivoDestino);
		
		

	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>