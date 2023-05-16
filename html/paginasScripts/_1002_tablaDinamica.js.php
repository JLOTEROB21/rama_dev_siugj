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
        	gEx('f_sp_fechaSesiondte').setValue('<?php echo $fechaActual?>');
           
            gEx('f_sp_fechaSesiondte').fireEvent('change', gEx('f_sp_fechaSesiondte'), gEx('f_sp_fechaSesiondte').getValue());
            gEx('f_sp_fechaSesiondte').fireEvent('select', gEx('f_sp_fechaSesiondte'));
            
            
            gEx('f_sp_horaSesiontme').setValue('<?php echo $horaActual?>');
           
            gEx('f_sp_horaSesiontme').fireEvent('change', gEx('f_sp_horaSesiontme'), gEx('f_sp_horaSesiontme').getValue());
            gEx('f_sp_horaSesiontme').fireEvent('select', gEx('f_sp_horaSesiontme'));
		}    	             
                      
        
       
        
    }
   
}


