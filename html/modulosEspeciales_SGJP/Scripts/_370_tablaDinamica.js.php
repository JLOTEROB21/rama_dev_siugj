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
	    if(gE('idRegistroG').value=='-1')
        {
             gEx('f_sp_fechaAtenciondte').setValue('<?php echo $fechaActual?>');
             
             gEx('f_sp_fechaAtenciondte').fireEvent('change', gEx('f_sp_fechaAtenciondte'), gEx('f_sp_fechaAtenciondte').getValue());
		}
         
         
        
	}
    else
    {
    	if(gE('sp_5197').innerHTML=='Sí')
        {
        	oE('div_5202');
            oE('div_5203');
        }
        
    }
}


