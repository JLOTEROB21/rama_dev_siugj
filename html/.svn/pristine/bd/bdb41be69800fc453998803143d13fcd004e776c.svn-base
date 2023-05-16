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
        	if(gEx('f_sp_fechaLiberaciondte'))
            {
             	gEx('f_sp_fechaLiberaciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaLiberaciondte').fireEvent('change', gEx('f_sp_fechaLiberaciondte'), gEx('f_sp_fechaLiberaciondte').getValue());
             	gEx('f_sp_fechaLiberaciondte').fireEvent('select', gEx('f_sp_fechaLiberaciondte'));
             }
             if(gEx('f_sp_horaLiberaciontme'))
             {
	             gEx('f_sp_horaLiberaciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaLiberaciontme').fireEvent('change', gEx('f_sp_horaLiberaciontme'), gEx('f_sp_horaLiberaciontme').getValue());
             }
         }
         
	}
}

