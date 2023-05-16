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
            gEx('f_sp_fechaConocimientodte').setValue(fechaActual);
        
            gEx('f_sp_fechaConocimientodte').fireEvent('change', gEx('f_sp_fechaConocimientodte'), gEx('f_sp_fechaConocimientodte').getValue());
    
            gEx('f_sp_fechaAcusedte').setValue(fechaActual);
        
            gEx('f_sp_fechaAcusedte').fireEvent('change', gEx('f_sp_fechaAcusedte'), gEx('f_sp_fechaAcusedte').getValue());
            
            
                        
                        
			                                 
            
        }
        else
        {
           
        } 
         
         
         
         
		
         

    }
    else
    {
    	
        
	}
    
    
    
    
    
    
	
}  


function validarFormulario()
{
	if(gEx('f_sp_fechaConocimientodte').getValue()>gEx('f_sp_fechaAcusedte'))
    {
    	function resp()
        {
        	gEx('f_sp_fechaConocimientodte').focus();
        }
        msgBox('La fecha del conocimiento al MP NO puede ser mayor que la fecha de acuse y firma del MP',resp);
    	return false;
    }
    return true;
}