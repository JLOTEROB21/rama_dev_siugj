<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	
?>

var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
    	
        
        if(gE('idRegistroG').value=='-1')
        {
           	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
          	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
          	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
    		
            gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
           	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
        }
        else
        {
           
        } 
         
         
         
         
		
         

    }
    else
    {
    	if(gE('sp_8548').innerHTML=='Otro')
        {
        	mE('div_8671')
            mE('div_8672')
       	}
        else
        {
        	oE('div_8671')
            oE('div_8672')
       	}
	}
    
    
    
    
    
    
	
}  

