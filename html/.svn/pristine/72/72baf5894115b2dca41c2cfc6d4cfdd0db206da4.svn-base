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
         gEx('f_sp_fechaSalidadte').setValue('<?php echo $fechaActual?>');
         
         gEx('f_sp_fechaSalidadte').fireEvent('change', gEx('f_sp_fechaSalidadte'), gEx('f_sp_fechaSalidadte').getValue());

         
         gEx('f_sp_horaSalidatme').setValue('<?php echo $horaActual?>');
         gEx('f_sp_horaSalidatme').fireEvent('change', gEx('f_sp_horaSalidatme'), gEx('f_sp_horaSalidatme').getValue());
        
	}
    else
    {
    	if(gE('sp_5045').innerHTML=='Si')
        {
        	oE('div_5049');
            oE('div_5050');
            if(gE('sp_6944').innerHTML!='Si')
            {
            	oE('div_6945');
            	oE('div_6946');
            }
            
        }
        else
        {
        	oE('div_5046');
            oE('div_5047');
            oE('div_5048');
            
            
            oE('div_6941');
            oE('div_6942');
            oE('div_6943');
            oE('div_6945');
            oE('div_6946');
            oE('div_6947');
            oE('div_6948');
            
        }
    }
}

