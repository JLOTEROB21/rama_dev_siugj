<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=bD($_GET["iF"]);
	$iR=bD($_GET["iR"]);
	
	
	
?>





            
Ext.onReady(inicializar);

function inicializar()
{
	
	if(esRegistroFormulario())
    {
    	
    	
    }
    else
    {
		switch(gE('sp_7045').innerHTML)
    	{
    		case 'Cumplimentada':
    			oE('div_7051');
    			oE('div_7052');
    			oE('div_7050');
    		break;
    		case 'Prescrita':
    			oE('div_7046');
    			oE('div_7052');
    			oE('div_7050');
    		break;
    		case 'Cancelada':
    			oE('div_7051');
    			oE('div_7046');
    			oE('div_7048');
    			oE('div_7049');
    			oE('div_7047');
    		break;
    	}
    	
    }
}            