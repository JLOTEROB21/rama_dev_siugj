<?php 
include("conexionBD.php");
include_once("zip.lib.php"); 
ini_set("memory_limit","512M");

$lista=-1;
if(isset($_POST["c"]))
{
	$lista=bD($_POST["c"]);
	
}
$idUsuario=$_SESSION["idUsr"];
if(isset($_POST["u"]))
	$idUsuario=bD($_POST["u"]);


$urlComprobante=$urlSitio;
$urlComprobante.="/formatosFacturasElectronicas/cfdiNomina_1.php";
$arrCertificadosEmpresas=array();
//$consulta="SELECT folioNomina FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
$folio=date("YmdHis_".$idUsuario);
$rutaTmp=$baseDir."/archivosTemporales/".$folio;
if(file_exists($rutaTmp))
	removeDirectory($rutaTmp);

mkdir($rutaTmp);

$consulta="SELECT idComprobante,idUsuario,r.idCertificado FROM 671_asientosCalculosNomina a,703_relacionFoliosCFDI r WHERE idComprobante in (".$lista.") AND r.idFolio=a.idComprobante";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{

	if(!isset($arrCertificadosEmpresas[$fila[2]]))	
	{
		$consulta="SELECT idReferencia FROM 687_certificadosSelloDigital WHERE idCertificado=".$fila[2];
		$empresa=$con->obtenerValor($consulta);	
		$arrCertificadosEmpresas[$fila[2]]=$empresa;
	}
	$idEmpresa=$arrCertificadosEmpresas[$fila[2]];
	$nombre=obtenerNombreUsuarioPaterno($fila[1]);
	$nombre=str_replace(" ","_",$nombre);
	$nombre=str_replace(".","",$nombre);
	$nombre=str_replace(",","",$nombre);
	$nombre=str_replace("/","",$nombre);
	
	$archOrigen=$baseDir."/facturacionElectronica/".$idEmpresa."/".$fila[0].".xml";
	$nombreDestino=$nombre."_".$fila[0];
	if(file_exists($archOrigen))
		copy($archOrigen,$rutaTmp."/".$nombreDestino.".xml");
	
	
	

	$comando="wget \"".$urlComprobante."?almacenarPDF=1&idComprobante=".$fila[0]."\"";
	
	$resultado=shell_exec($comando);
	$archivoPDF=$baseDir."/archivosTemporales/".$fila[0].".pdf";

	if(file_exists($archivoPDF))
	{
		copy($archivoPDF,$rutaTmp."/".$nombreDestino.".pdf");
		unlink($archivoPDF);
	}
	
	
	
}

$zip = new zip();
$dir=opendir($rutaTmp);
$archivoZip=$baseDir."/archivosTemporales/comprobantesNomina";
while ($archivo = readdir($dir)) 
{
	
	if(is_file($rutaTmp."/".$archivo))
	{
		
		$zip->addFile($rutaTmp."/".$archivo,"comprobantesNomina/".$archivo);
	}
	
	
}
closedir($dir);
 
$pathSave = $archivoZip.'.zip';
$zip->saveZip($pathSave);
$zip->downloadZip($pathSave);
unlink($pathSave);
removeDirectory($rutaTmp);

?>