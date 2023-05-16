<?php session_start();
	include_once("conexionBD.php");
	include_once("cExcel.php");

	ini_set("memory_limit","256M");

	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	
	
	$libro=new cExcel("./plantillas/formatoReferenciaCruzada.xlsx",true,"Excel2007");	
	
	$consulta="SELECT * FROM _1239_tablaDinamica WHERE id__1239_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$fechaRecepcion=date("d/m/Y H:i",strtotime($fRegistro["fechaRecepcionInventario"]." ".$fRegistro["horaRecepcionInventario"]));
	
	$libro->setValor("B2",$fRegistro["codigo"]);
	$libro->setValor("B3",$fRegistro["carpetaAdministrativa"]);
	$libro->setValor("B4","=CONCATENATE(\"".$fechaRecepcion."\",\"\")");
	$libro->setValor("B5",obtenerNombreUsuario($fRegistro["responsable"]));
	$libro->setValor("B7","=CONCATENATE(\"".($fRegistro["fechaDocumentoInventario"]!=""?date("d/m/Y",strtotime($fRegistro["fechaDocumentoInventario"])):"------")."\",\"\")");
	$libro->setValor("B8",str_replace("<br />","\r",$fRegistro["descripcionDocumentoInventario"]));
	
	
	$despacho="";
	if($fRegistro["despacho"]!="")
	{
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["despacho"]."'";
		$despacho=$con->obtenerValor($consulta);
	}
	$libro->setValor("B16",$fRegistro["sedeInventario"]==""?"------":$fRegistro["sedeInventario"]);
	$libro->setValor("B17",$fRegistro["oficinaInventario"]==""?"------":$fRegistro["oficinaInventario"]);
	$libro->setValor("B18",$despacho==""?"------":$despacho);
	$libro->setValor("B19",$fRegistro["depositoInventario"]==""?"------":$fRegistro["depositoInventario"]);
	$libro->setValor("B20",$fRegistro["despachoInventario"]==""?"------":$fRegistro["despachoInventario"]);
	$libro->setValor("B21",$fRegistro["estanteInventario"]==""?"------":$fRegistro["estanteInventario"]);
	$comentariosAdicionales=str_replace("<br />","\r",$fRegistro["comentariosAdicionales"]);
	$libro->setValor("B22",$comentariosAdicionales==""?"------":$comentariosAdicionales);
	
	$libro->setValor("G2","=CONCATENATE(\"".date("d/m/Y H:i",strtotime($fRegistro["fechaCreacion"]))."\",\"\")");
	$nombreArchivoFinal="formatoReferenciaCruzada_".str_replace("/","_",str_replace("-","_",$fRegistro["codigo"]));
	$nombreTmp=generarNombreArchivoTemporal();
	$archivoDestino=$baseDir."/archivosTemporales/".$nombreTmp.".pdf";
	$libro->generarArchivoServidor("PDF",$baseDir."/archivosTemporales/".$nombreTmp);

	if(file_exists($archivoDestino))
	{
		
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa con,908_archivos a
					WHERE con.carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"].
					"' AND con.tipoContenido=1 AND a.idArchivo=con.idRegistroContenidoReferencia
					AND a.nomArchivoOriginal like '%".str_replace("_","",$nombreArchivoFinal).".pdf'";
		$numRegistros=$con->obtenerValor($consulta);
		if($numRegistros==0)
		{

			$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreTmp.".pdf",$nombreArchivoFinal.".pdf",169,"");
			registrarDocumentoCarpetaAdministrativa($fRegistro["carpetaAdministrativa"],$idDocumentoRegistrado,698,$idRegistro);
			registrarDocumentoResultadoProceso(1239,$idRegistro,$idDocumentoRegistrado);
			$cuerpoDocumento=bD(obtenerCuerpoDocumentoB64($idDocumentoRegistrado));
		}
		else
		{

			$cuerpoDocumento=leerContenidoArchivo($archivoDestino);
		}
		header("Content-type:application/pdf"); 
		header("Content-length: ".filesize($archivoDestino)); 
		header("Content-Disposition: inline; filename=".$nombreArchivoFinal.".pdf");
		
		
		echo $cuerpoDocumento;
		
	}
	
	
?>