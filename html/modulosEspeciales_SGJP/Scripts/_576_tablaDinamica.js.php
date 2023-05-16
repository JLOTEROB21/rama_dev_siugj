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
        	if(gEx('f_sp_fechaPublicaciondte'))
            {
             	gEx('f_sp_fechaPublicaciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaPublicaciondte').fireEvent('change', gEx('f_sp_fechaPublicaciondte'), gEx('f_sp_fechaPublicaciondte').getValue());
             	gEx('f_sp_fechaPublicaciondte').fireEvent('select', gEx('f_sp_fechaPublicaciondte'));
             }
            
         }
	}
    else
    {
    	
    }
    
}

