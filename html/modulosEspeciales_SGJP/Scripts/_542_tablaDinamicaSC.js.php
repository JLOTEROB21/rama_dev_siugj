<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	
?>

var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
        if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaMultadte').setValue(fechaActual);
        
            gEx('f_sp_fechaMultadte').fireEvent('change', gEx('f_sp_fechaMultadte'), gEx('f_sp_fechaMultadte').getValue());
        }
        else
        {
           
        } 
    }
    else
    {
    	
        
	}
}  

