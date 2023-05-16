<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT * FROM _453_tablaDinamica WHERE id__453_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$cAdministrativaBase=obtenerCarpetaBaseOriginal($fRegistro["carpetaEjecucion"]);
	if($cAdministrativaBase=="")
		$cAdministrativaBase="SC";
	
	$consulta="SELECT folioCarpetaInvestigacion FROM _46_tablaDinamica 
			WHERE carpetaAdministrativa='".$cAdministrativaBase."' AND 
			folioCarpetaInvestigacion<>'' AND folioCarpetaInvestigacion IS NOT NULL";
		
	$folioCarpetaInvestigacion=$con->obtenerValor($consulta);	
		
		
?>

var folioCarpetaInvestigacion='<?php echo $folioCarpetaInvestigacion?>';

function inyeccionCodigo()
{
	
	gE('sp_7226').innerHTML=folioCarpetaInvestigacion;
    if(gEN('_iFormulariovch')[0].value=='-1')	
    	 gE('sp_7235').innerHTML='';
    else
	    gE('sp_7235').innerHTML='<a href="javascript:verDetalles()"><img src="../images/magnifier.png" /></a> <a href="javascript:verDetalles()">Ver detalles adicionales...</a>';
}

function verDetalles()
{
	var obj={};
    var params=[['idRegistro',gEN('_iRegistrovch')[0].value],['idFormulario',gEN('_iFormulariovch')[0].value],['dComp',bE('auto')],['actor',bE('0')]];
    obj.ancho='90%';
    obj.alto='95%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    window.parent.abrirVentanaFancy(obj)
}