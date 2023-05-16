<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
?>






function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
	    
         
         
        
	}
    else
    {
    	if(gE('sp_9649').innerHTML=='No')
        {
        	oE('div_9650');
            oE('div_9651');
        }
    }
    
}


