<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	
?>
var cadenaFuncionValidacion='validarFormulario';
var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
    	
        
        if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaEnviodte').setValue(fechaActual);
        
            gEx('f_sp_fechaEnviodte').fireEvent('change', gEx('f_sp_fechaEnviodte'), gEx('f_sp_fechaEnviodte').getValue());
    
           
        }
        else
        {
           
        } 
         
         
         
         
		
         

    }
    else
    {
    	if(gE('sp_8518').innerHTML=='Petición de expediente a Archivo Judicial')
        {
        	oE('div_8519');
        }
        
	}
    
    
    
    
    
    
	
}  


function validarFormulario()
{
	
    return true;
}