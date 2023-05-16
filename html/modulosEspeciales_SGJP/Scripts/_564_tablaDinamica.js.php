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
        	if(gEx('f_sp_fechaOperaciondte'))
            {
             	gEx('f_sp_fechaOperaciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaOperaciondte').fireEvent('change', gEx('f_sp_fechaOperaciondte'), gEx('f_sp_fechaOperaciondte').getValue());
             	gEx('f_sp_fechaOperaciondte').fireEvent('select', gEx('f_sp_fechaOperaciondte'));
             }
            
         }
	}
    else
    {
    	if(gE('sp_9158').innerHTML!='Otro')
        {
    		oE('div_9159');
        }
    }
    
}

