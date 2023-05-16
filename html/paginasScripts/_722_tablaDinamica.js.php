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
            gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte').setValue('<?php echo $fechaActual?>');
            gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte').fireEvent('change', gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte'), gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte').getValue());
    
            gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte').fireEvent('select', gEx('f_sp_fechaRealizacionDiligenciaResultadoNotificaciondte'));
             
		 	gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme').setValue('<?php echo $horaActual?>');
            gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme').fireEvent('change', gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme'), gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme').getValue());
    
            gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme').fireEvent('select', gEx('f_sp_horaRealizacionDiligenciaResultadoNotificaciontme'));
                  	
        }
       
        
    }
    else
    {
    	if(gE('sp_11551').innerHTML=='No')
        {
        	oE('div_11542');
            oE('div_11566');
        	oE('div_11552');
            oE('div_11553');
        }
        
        if(gE('sp_11552').innerHTML=='Física')
        {
        	oE('div_11567');
            oE('div_11566');
        }
    }
}


