<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	
?>



function inyeccionCodigo()
{
	
    
    
    
    if(esRegistroFormulario())
    {
    	
        asignarEvento(gE('_periodoBasevch'),'change',function(combo)
                                                                        {
                                                                           
                                                                            var opcionSel=combo.options[combo.selectedIndex].value;
                                                                            switch(opcionSel)
                                                                            {
                                                                            	case  '3':
                                                                                	gE('sp_10463').innerHTML='Tipo de Notificaci&oacute;n:';
                                                                                break;
                                                                            	case  '4':
                                                                                	gE('sp_10463').innerHTML='Tipo de Actuaci&oacute;n:';
                                                                                break;
                                                                                case  '5':
                                                                                	gE('sp_10463').innerHTML='Tipo de Audiencia:';
                                                                                break;
                                                                            }
                                                                            
                                                                        }
                                                        ); 
        
		if(gE('idRegistroG').value!='-1')
      	{
          	lanzarEvento(gE('_periodoBasevch'),'change');
          
         
      	}
        
	}
    else
    {
    	oE('div_10463');
        oE('div_10464');
        oE('div_10465')
        oE('div_10923')
    	if(gE('sp_10462').innerHTML=='Al agendar una audiencia')
        {
        	gE('sp_10463').innerHTML='Tipo de Audiencia:';
        	mE('div_10463');
            mE('div_10464');
        }
        
        if(gE('sp_10462').innerHTML=='Al realizar una actuación')
        {
        	gE('sp_10463').innerHTML='Tipo de Actuaci&oacute;n:';
        	mE('div_10463');
            mE('div_10465');
        }
        
        if(gE('sp_10462').innerHTML=='Una vez notificado al demando')
        {
        	gE('sp_10463').innerHTML='Tipo de Notificaci&oacute;n:';
        	mE('div_10463');
            mE('div_10923');
        }
       
    }
    	
    
  
	


}
