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
            
        }
       
        
    }
    else
    {
    	if(gE('sp_14034').innerHTML=='No')
        {
        	oE('div_14033');	
            oE('div_14035');
            oE('div_14036');
            oE('div_14037');
        }
        
        if(gE('sp_14035').innerHTML=='No')
        {
        	oE('div_14036');
            oE('div_14037');
        }
    }
}


