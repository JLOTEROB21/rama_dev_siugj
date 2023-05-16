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
            if(gEx('f_sp_fechaRecepcionInventariodte')) 
            {
             	gEx('f_sp_fechaRecepcionInventariodte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRecepcionInventariodte').fireEvent('change', gEx('f_sp_fechaRecepcionInventariodte'), gEx('f_sp_fechaRecepcionInventariodte').getValue());

             	gEx('f_sp_fechaRecepcionInventariodte').fireEvent('select', gEx('f_sp_fechaRecepcionInventariodte'));
             }

             if(gEx('f_sp_horaRecepcionInventariotme'))
             {
	            gEx('f_sp_horaRecepcionInventariotme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepcionInventariotme').fireEvent('change', gEx('f_sp_horaRecepcionInventariotme'), gEx('f_sp_horaRecepcionInventariotme').getValue());
             }   
             
             
             if(gEx('f_sp_fechaDocumentoInventariodte')) 
            {
             	gEx('f_sp_fechaDocumentoInventariodte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaDocumentoInventariodte').fireEvent('change', gEx('f_sp_fechaDocumentoInventariodte'), gEx('f_sp_fechaDocumentoInventariodte').getValue());

             	gEx('f_sp_fechaDocumentoInventariodte').fireEvent('select', gEx('f_sp_fechaDocumentoInventariodte'));
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
