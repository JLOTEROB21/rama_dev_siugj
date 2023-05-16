<?php  session_start();

		include("conexionBD.php");

	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/acuseEnvioTutelaCorteConstitucional.html");	
	
	
	$consulta="SELECT * FROM _917_tablaDinamica WHERE id__917_tablaDinamica=".$idRegistro;

	$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
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
	
	
	$nombreDocumento=$baseDir."/archivosTemporales/envioTutelaCorteConstitucional_".$fRegistroBase["carpetaAdministrativa"].".html";
	
	$consulta="SELECT * FROM _717_tablaDinamica WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$idRegistro=$fRegistro["id__717_tablaDinamica"];
	
	$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fRegistro["departamentosRegistroTutela"]."'";
	$departamento=$con->obtenerValor($consulta);
	
	$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fRegistro["ciudadRegistroTutela"]."'";
	$municipio=$con->obtenerValor($consulta);
	
	$derechos="";
	$query="SELECT cT.derechoCatalogoDerechosTutela FROM _717_gridDerechoVulnerableRegistroTutela rT,_716_tablaDinamica cT WHERE rT.idReferencia=".$idRegistro." AND 
			cT.id__716_tablaDinamica=rT.derechoVulnerableRegistroTutela ORDER BY cT.derechoCatalogoDerechosTutela";
	$rDerechos=$con->obtenerFilas($query);
	while($fDerecho=mysql_fetch_row($rDerechos))
	{
		if($derechos=="")
			$derechos=$fDerecho[0];
		else
			$derechos.="<br>".$fDerecho[0];
	}
	
	$documentacion="";
	$query="SELECT c.nombreCategoria FROM 9503_documentosRegistradosProceso r,908_categoriasDocumentos c
		WHERE r.idFormulario=717 AND r.idReferencia=".$idRegistro." and c.idCategoria=r.idTipoDocumento AND r.presentaDocumento=1 ORDER BY c.nombreCategoria";
	
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
	$arrDocumentos["folioRegistro"]=$fRegistro["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistroBase["fechaEnvioCorteConstitucional"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistroBase["fechaEnvioCorteConstitucional"],false,false);;
	$arrDocumentos["existeMedidaProvisional"]=$fRegistro["medidaProvisional"]==1?"S&iacute;":"No";
	$arrDocumentos["derechos"]=$derechos;
	$arrDocumentos["departamento"]=$departamento;
	$arrDocumentos["municipio"]=$municipio;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["despachoEnvia"]=$despachoEnvia;
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="acuseDemandaTutela_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		$tamano=filesize($directorioDestino."/".$nombreDocumento.".pdf");
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",86,"");
		registrarDocumentoCarpetaAdministrativa($fRegistroBase["carpetaAdministrativa"],$idDocumentoRegistrado,917,$idRegistro);
		
		
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