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
        	if(gEx('f_sp_fechaSentenciadte'))
          	{
                  gEx('f_sp_fechaSentenciadte').setValue('<?php echo $fechaActual?>');
               
                  gEx('f_sp_fechaSentenciadte').fireEvent('change', gEx('f_sp_fechaSentenciadte'), gEx('f_sp_fechaSentenciadte').getValue());
                  gEx('f_sp_fechaSentenciadte').fireEvent('select', gEx('f_sp_fechaSentenciadte'));
           	}
      	}
    }
    
    	
    
  
	


}


