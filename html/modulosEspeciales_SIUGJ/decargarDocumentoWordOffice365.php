<?php
session_start();
include_once("conexionBD.php");	
include_once("cConectoresGestorContenido/cOneDrive.php");


$idRegistroFormato="";
$nombreDocumentoPlantilla="";
$nombreDocumento="";
$nombreDocumento="";

if(isset($_GET["idRegistroFormato"]))
{

	$arrParametros=explode("____","idRegistroFormato=".$_GET["idRegistroFormato"]);
	foreach($arrParametros as $p)
	{
		$arrValores=explode("=",$p);
		$_POST[$arrValores[0]]=$arrValores[1];
	}
	
}
$idRegistroFormato=$_POST["idRegistroFormato"];
$consulta="SELECT idRegistro FROM 3000_formatosRegistrados WHERE idRegistroFormato=".$idRegistroFormato;
$idRegistroInfo=$con->obtenerValor($consulta);

$consulta="SELECT datosParametros FROM 7035_informacionDocumentos WHERE idRegistro=".$idRegistroInfo;
$datosParametros=$con->obtenerValor($consulta);
$oConf=json_decode($datosParametros);

$nombreDocumentoPlantilla=$_POST["nombreDocumentoPlantilla"];
$nombreDocumento=$_POST["nombreDocumento"];
$printer=isset($_POST["printer"])?true:false;
	



$infoComp["idConexion"]=$oConf->idConexion;
$cDrive=new cOneDrive("","","","",$infoComp);
$cDrive->conectar();
$cuerpoDocumento=$cDrive->obtenerDocumentoPDF("/".$nombreDocumento,false);

$arrDocumento=explode(".",$nombreDocumento);


header("Content-type: application/pdf");

if($printer)
	$modo="inline";
else
	$modo="attachment";			
		
header("Content-Disposition: ".$modo."; filename=".$nombreDocumentoPlantilla.".pdf");
echo $cuerpoDocumento;

?>