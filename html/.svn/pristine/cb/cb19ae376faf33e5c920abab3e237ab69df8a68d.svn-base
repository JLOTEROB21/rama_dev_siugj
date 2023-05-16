<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	
	



?>



function inyeccionCodigo()
{
	
    if(esRegistroFormulario())
    {
    
    	if(gE('idRegistroG').value=='-1')
        {
             	gEx('f_sp_periodoDeldte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_periodoDeldte').fireEvent('change', gEx('f_sp_periodoDeldte'), gEx('f_sp_periodoDeldte').getValue());
             	gEx('f_sp_periodoDeldte').fireEvent('select', gEx('f_sp_periodoDeldte'));
                
			 	gEx('f_sp_periodoAldte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_periodoAldte').fireEvent('change', gEx('f_sp_periodoAldte'), gEx('f_sp_periodoAldte').getValue());
             	gEx('f_sp_periodoAldte').fireEvent('select', gEx('f_sp_periodoAldte'));
             
             
                  	
        }
       
        
        
        
    }
    else
    {
    	
    }
}

