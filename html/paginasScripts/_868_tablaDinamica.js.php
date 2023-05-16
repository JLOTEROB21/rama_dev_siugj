<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$idReferencia=($_GET["iRef"]);
	$idProcesoPadre=bD($_GET["iPP"]);

	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$carpetaAdministrativa="";
	if($idProcesoPadre!=-1)
	{
		$iFormulario=obtenerFormularioBase($idProcesoPadre);
		$iRegistro=$idReferencia;
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($iFormulario,$iRegistro);
	}


?>

var carpetaAdministrativa='<?php echo $carpetaAdministrativa?>';

function inyeccionCodigo()
{

    if(esRegistroFormulario())
    {
    	if(carpetaAdministrativa!="")
        {
        	gEN('_paramCAdministrativavch')[0].value=carpetaAdministrativa;
        }
        if(gEN('_paramCAdministrativavch')[0].value!='N/E')
        {
        	gEx('ext__cAdministrativavch').setValue(gEN('_paramCAdministrativavch')[0].value);
            gE('_cAdministrativavch').value=gEN('_paramCAdministrativavch')[0].value;
            gEx('ext__cAdministrativavch').disable();
            funcionEventoCambio(gEx('ext__cAdministrativavch'),true);
		}        
    }
    else
    {
    	
    }
}


