<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
	
	$idActividad=-1;
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);
	
	
	
	$consulta="SELECT * FROM _385_tablaDinamica WHERE id__385_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$cAdministrativaBase=obtenerCarpetaBaseOriginal($fRegistro["carpetaAdministrativa"]);
	if($cAdministrativaBase=="")
		$cAdministrativaBase="SC";
	
	$consulta="SELECT folioCarpetaInvestigacion FROM _46_tablaDinamica 
			WHERE carpetaAdministrativa='".$cAdministrativaBase."' AND 
			folioCarpetaInvestigacion<>'' AND folioCarpetaInvestigacion IS NOT NULL";
		
	$folioCarpetaInvestigacion=$con->obtenerValor($consulta);		
		
?>
var folioCarpetaInvestigacion='<?php echo $folioCarpetaInvestigacion?>';

var idActividad=<?php echo $idActividad?>;

function inyeccionCodigo()
{
	
	if(!esRegistroFormulario())
    {
    	idActividad=gEN('_idActividadvch')[0].value;
        gE('sp_6703').innerHTML=folioCarpetaInvestigacion;
        
    }
    else
    {
    	
    	if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;          
            
       
	}
   
}                