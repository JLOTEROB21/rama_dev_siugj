<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
?>




function inyeccionCodigo()
{
	
	if(!esRegistroFormulario())
    {
		if(gE('sp_4948').innerHTML!='Sí')
        {
        	oE('div_4941');
            oE('div_4946');
            oE('div_4943');
            
        }
        
        if(gE('sp_4942').innerHTML=='Galeras')
        {
        	
            oE('div_4946');
            oE('div_4943');
            
        }
        else
        {
        	if(gE('sp_4942').innerHTML=='Reclusorio')
            {
                
                oE('div_4943');
                
            }
            else
            {
            	
            	oE('div_4946');
                oE('div_4945');
            }
        }
        
        
        
	} 
    
}


