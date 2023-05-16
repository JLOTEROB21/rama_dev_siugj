<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__10_tablaDinamica,nombreFormato FROM _10_tablaDinamica";
	$arrTiposFormatos=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrTiposAudiencia=$con->obtenerFilasArreglo($consulta);
	
?>

var arrTiposFormatos=<?php echo $arrTiposFormatos?>;
var arrTiposAudiencia=<?php echo $arrTiposAudiencia?>;

function formatearTipoDocumento(val)
{
	return formatearValorRenderer(arrTiposFormatos,val);
}

function formatearTipoAudiencia(val)
{
	return formatearValorRenderer(arrTiposAudiencia,val);
}