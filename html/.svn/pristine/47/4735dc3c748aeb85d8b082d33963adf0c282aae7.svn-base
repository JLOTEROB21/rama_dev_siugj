<?php 
include_once("conexionBD.php");

function contabilizarElementosPDF($idDocumento)
{
	global $con;
	global $baseDir;
	$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$idDocumento;
	$fDatosArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
	$nombreArchivoTmp=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
	if($fDatosArchivo["repositorioDocumento"]!=0)
	{
		$conexion=generarInstanciaConectorGestor($fDatosArchivo["repositorioDocumento"]);
		
		$documento=$conexion->obtenerDocumento($fDatosArchivo["documentoRepositorio"]);
		
		escribirContenidoArchivo($nombreArchivoTmp,$documento);
	
	}
	else
	{
		$rutaDocumentoAnexo=obtenerRutaDocumento($idDocumento);
		copy($rutaDocumentoAnexo, $nombreArchivoTmp);
	}
	
	$noPaginas=0;
	$arrResultado=array();
	$valResultado=0;
	$resultado=exec("pdfinfo ".$nombreArchivoTmp,$arrResultado,$valResultado);

	foreach($arrResultado as $r)
	{
		if(strpos($r,"Pages:")!==false)
		{
			$arrPaginas=explode(":",$r);
			$noPaginas=trim($arrPaginas[1]);
			break;
		}
	}
	
	if(file_exists($nombreArchivoTmp))
	{
		
		unlink($nombreArchivoTmp);
	}
	return $noPaginas;
}

function normalizarNombreDocumento($carpetaAdministrativa,$idAcarpetaAdministrativa,$idDocumento)
{
	global $con;
	$consulta="SELECT * FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND idCarpetaAdministrativa=".$idAcarpetaAdministrativa." AND idRegistroContenidoReferencia=".$idDocumento;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$consulta="SELECT nomArchivoOriginal,nombreDocumentoOriginal FROM 908_archivos WHERE idArchivo=".$idDocumento;
	$datosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$nombreDocumento=$datosDocumento["nombreDocumentoOriginal"];
	if($nombreDocumento=='')
	{
		$nombreDocumento=$datosDocumento["nomArchivoOriginal"];
		$consulta="UPDATE 908_archivos SET nombreDocumentoOriginal='".$nombreDocumento."' WHERE idArchivo=".$idDocumento;
		$con->ejecutarConsulta($consulta);
	}

	$arrNombreDocumentos=explode(".",$nombreDocumento);
	$nombreDocumento="";
	for($x=0;$x<count($arrNombreDocumentos)-1;$x++)
	{
		$e=$arrNombreDocumentos[$x];
		
		$nombreDocumento.=$e;
	}
	

	$nombreDocumento=str_replace(" ","_",$nombreDocumento);
	$arrExplode=explode("_",$nombreDocumento);
	

	
	$nombreDocumento="";
	
	for($x=0;$x<count($arrExplode);$x++)
	{
		$e=$arrExplode[$x];

		$nombreDocumento.=ucfirst(normalizarToken($e));
	}
	
	
	
	$nombreDocumento.=".".$arrNombreDocumentos[count($arrNombreDocumentos)-1];
	
	$nDocumento=str_pad($fRegistro["ordenDocumento"],2,"0",STR_PAD_LEFT);
	
	
	$nombreDocumento=$nDocumento.$nombreDocumento;
	return $nombreDocumento;
	
}


function normalizarToken($e)
{
	$arrCarcateresReemplazo=array();
	array_push($arrCarcateresReemplazo,"(");
	array_push($arrCarcateresReemplazo,")");
	array_push($arrCarcateresReemplazo,"-");
	array_push($arrCarcateresReemplazo,"/");
	array_push($arrCarcateresReemplazo,"#");
	array_push($arrCarcateresReemplazo,"%");
	array_push($arrCarcateresReemplazo,"&");
	array_push($arrCarcateresReemplazo,":");
	array_push($arrCarcateresReemplazo,"<");
	array_push($arrCarcateresReemplazo,">");
	array_push($arrCarcateresReemplazo,".");
	array_push($arrCarcateresReemplazo,"¿");
	array_push($arrCarcateresReemplazo,"?");
	array_push($arrCarcateresReemplazo,",");
	foreach($arrCarcateresReemplazo as $c)
	{
		
		$e=str_replace($c,"",$e);
		
	}
	$e=quitarAcentos($e);
	return $e;
}
?>
