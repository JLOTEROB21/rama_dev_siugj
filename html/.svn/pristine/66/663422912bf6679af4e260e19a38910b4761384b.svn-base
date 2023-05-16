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
             gEx('f_sp_fechaRespuestadte').setValue('<?php echo $fechaActual?>');
             
             gEx('f_sp_fechaRespuestadte').fireEvent('change', gEx('f_sp_fechaRespuestadte'), gEx('f_sp_fechaRespuestadte').getValue());
		}
         
         
        
	}
    
}


