<?php 
include("conexionBD.php");
include_once("zip.lib.php"); 
ini_set("memory_limit","512M");

$idNomina=-1;
if(isset($_POST["idNomina"]))
{
	$idNomina=$_POST["idNomina"];
	
}

$normalizeChars = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
);


$urlComprobante=$urlSitio;
$urlComprobante.="/formatosFacturasElectronicas/cfdiNomina_1.php";
$arrCertificadosEmpresas=array();
$consulta="SELECT folioNomina FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;

$folio=str_replace("-","_",$con->obtenerValor($consulta));
if($folio!="")
{
	$rutaTmp=$baseDir."/archivosTemporales/".$folio;
	if(file_exists($rutaTmp))
		removeDirectory($rutaTmp);
	
	mkdir($rutaTmp);

	$consulta="SELECT idComprobante,idUsuario,r.idCertificado FROM 671_asientosCalculosNomina a,703_relacionFoliosCFDI r WHERE idNomina=".$idNomina." AND r.idFolio=a.idComprobante AND r.situacion=2";

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
		
		$nombre=strtr($nombre, $normalizeChars);
		
		
		
		$archOrigen=$baseDir."/facturacionElectronica/".$idEmpresa."/".$fila[0].".xml";
		$nombreDestino=$nombre."_".$fila[1]."_".$fila[0];
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
	$archivoZip=$baseDir."/archivosTemporales/".$folio;
	while ($archivo = readdir($dir)) 
	{
		
		if(is_file($rutaTmp."/".$archivo))
		{
			
			$zip->addFile($rutaTmp."/".$archivo,$archivo);
		}
		
		
	}
	closedir($dir);
	 
	$pathSave = $archivoZip.'.zip';
	$zip->saveZip($pathSave);
	$zip->downloadZip($pathSave);
	unlink($pathSave);
	removeDirectory($rutaTmp);
}
?>