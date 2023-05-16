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
    
    	if(gEN('_cAdministrativavch')[0].value!='N/E')
        {
        	gEx('ext__carpetaAdministrativavch').setValue(gEN('_cAdministrativavch')[0].value);
            gE('_carpetaAdministrativavch').value=gEN('_cAdministrativavch')[0].value;
            gEx('ext__carpetaAdministrativavch').disable();
            
            funcionEventoCambio(gEx('ext__carpetaAdministrativavch'),true);

            
        }
    	                
        if(gE('idRegistroG').value=='-1')
        {
        	
            if(gEx('f_sp_fechaRecepciondte')) 
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());

             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }

             if(gEx('f_sp_horaRecepciontme'))
             {
	         	gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
             }   
            
             
                  	
        }
        else
        {
        	
        }
        
        
        
    }
    else
    {
    	
    }
}

