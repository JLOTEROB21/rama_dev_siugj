<?php  session_start();

		include("conexionBD.php");
	
	$idFormulario=977;
	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	$contenidoPlatilla=leerContenidoArchivo($baseDir."/modulosEspeciales_SIUGJ/plantillas/actaAsignacionConJuez.html");	
	
	
	$consulta="SELECT * FROM _977_tablaDinamica WHERE id__977_tablaDinamica=".$idRegistro;

	$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	
	
	$carpetaAdministrativa=$fRegistroBase["carpetaAdministrativa"];
	
	
	
	
	/*$arrCarpetas=array();
	obtenerCarpetasPadre($carpetaAdministrativa,$arrCarpetas);
	if(sizeof($arrCarpetas)==0)
	{
		array_push($arrCarpetas,$carpetaAdministrativa);
	}
	
	$carpetaAdministrativa=$arrCarpetas[0];*/
	
	$consulta="SELECT idActividad,idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$nombreDocumento=$baseDir."/archivosTemporales/envioImpedimentoCorteConstitucional_".$fRegistroBase["carpetaAdministrativa"].".html";
	
	
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
	
	
	$consulta="SELECT * FROM _976_tablaDinamica WHERE id__976_tablaDinamica=".$fRegistroBase["idConjuezAsignado"];
	$fConjuez=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$arrDocumentos=array();
	$arrDocumentos["folioRegistro"]=$fRegistroBase["codigo"];
	$arrDocumentos["horasRecepcion"]=date("H:i",strtotime($fRegistroBase["fechaAsignacion"]));
	$arrDocumentos["fechaRecepcion"]=convertirFechaLetra($fRegistroBase["fechaAsignacion"],false,false);;
	$arrDocumentos["partes"]=$partes;
	$arrDocumentos["procesoJudicial"]=$carpetaAdministrativa;
	
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["codigoInstitucion"]."'";
	$despachoEnvia=$con->obtenerValor($consulta);
	
	$arrDocumentos["despachoEnvia"]=$despachoEnvia;
	$arrDocumentos["conjuezAsignado"]=$fConjuez["tituloConjuez"]." ".$fConjuez["nombre"]." ".$fConjuez["primerApellido"]." ".$fConjuez["segundoApellido"];
	
	
	foreach($arrDocumentos as $campo=>$valor)
	{
		$contenidoPlatilla=str_replace("[".$campo."]",utf8_decode($valor),$contenidoPlatilla);
		
	}
	$directorioDestino=$baseDir."/archivosTemporales";
	$nombreDocumento="actaAsignacionConjuez_".$idRegistro;
	
	
	escribirContenidoArchivo($directorioDestino."/".$nombreDocumento.".html",$contenidoPlatilla);

	generarDocumentoPDF($directorioDestino."/".$nombreDocumento.".html",false,false,true,$nombreDocumento.".pdf","",$directorioDestino);
	if(file_exists($directorioDestino."/".$nombreDocumento.".pdf"))
	{
		
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreDocumento.".pdf",$nombreDocumento.".pdf",102,"");
		registrarDocumentoCarpetaAdministrativa($fRegistroBase["carpetaAdministrativa"],$idDocumentoRegistrado,$idFormulario,$idRegistro);
		registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
		
		header("Content-type:application/pdf"); 
		header("Content-length: ".filesize($directorioDestino."/".$nombreDocumento.".pdf")); 
		header("Content-Disposition: inline; filename=".$nombreDocumento.".pdf");
		echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>