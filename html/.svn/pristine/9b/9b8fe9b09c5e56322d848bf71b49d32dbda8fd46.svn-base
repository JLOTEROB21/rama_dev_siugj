<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

?>



function inyeccionCodigo()
{
	         
	if(esRegistroFormulario())
    {
        asignarEvento(gE('_medidaCautelarvch'),'change',medidaCautelarChange)
                  
    	medidaCautelarChange();
    
    }
    else
    {
    	var sp_2207=gE('sp_2207');
        if(sp_2207.innerHTML=='PRISION PREVENTIVA')
        {
        	gE('_importeflo').innerHTML='';
        }
        else
        {
        	gE('sp_2580').innerHTML='';
        }
    }
    
}

function medidaCautelarChange()
{

	var cmb=gE('_medidaCautelarvch');

	valor= cmb.options[cmb.selectedIndex].value;
                                                            
                                                            
    switch(valor)
    {
        case '2':  //Garantia economica
            gE('sp_2205').innerHTML='Monto de la garant&iacute;a:';
        
        break;
        case '14': //Prision preventiva
            gE('sp_2205').innerHTML='Centro de reclusi&oacute;n:';
        
        break;
    }
}