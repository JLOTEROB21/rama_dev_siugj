<?php include_once("conexionBD.php");


	$idComprobante=-1;
	if(isset($_GET["iC"]))
		$idComprobante=bD($_GET["iC"]);
		
	$consulta="SELECT idCertificado,idSerie,folio FROM 703_relacionFoliosCFDI WHERE idFolio=".$idComprobante;
	$relacion=$con->obtenerPrimeraFila($consulta);
	$idCertificado=$relacion[0];
	$idSerie=$relacion[1];
	$folio=$relacion[2];
	$consulta="SELECT serie FROM 688_seriesCertificados WHERE idSerieCertificado=".$idSerie;
	$serie=$con->obtenerValor($consulta);
	
	$consulta="SELECT * FROM 687_certificadosSelloDigital WHERE idCertificado=".$idCertificado;

	$fCertificado=$con->obtenerPrimeraFila($consulta);
	$idEmpresa=$fCertificado[7];
	$cuerpoArchivo="";
	$archivoXML=$baseDir."/facturacionElectronica/".$idEmpresa."/".$idComprobante.".xml";
	
	
	$documento=$serie."_".$folio.".xml";
	
	header ("Content-Type:text/xml");
	header("Content-Disposition: attachment; filename=".$documento);
	readfile($archivoXML);
?>