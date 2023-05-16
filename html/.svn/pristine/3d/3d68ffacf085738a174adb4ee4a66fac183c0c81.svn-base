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
            gEx('f_sp_fechaSentenciadte').setValue(fechaActual);
            
            gEx('f_sp_fechaSentenciadte').on('change',function()
            											{
                                                        	 }
            								)
            
            gEx('f_sp_fechaSentenciadte').fireEvent('change', gEx('f_sp_fechaSentenciadte'), gEx('f_sp_fechaSentenciadte').getValue());
    
           
            
        	    
                        
                        
			                                 
            
        }
        
         
         
         
		
         

    }
    else
    {
    	
        
	}
    
    
    
    
    
    
	
}  

