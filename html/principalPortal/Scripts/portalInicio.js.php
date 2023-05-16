<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>

Ext.onReady(inicializar);

function inicializar()
{
	var arrDimensiones=obtenerDimensionesNavegador();
    
    if(gE('totalPublicaciones').value!='0')
    {
        $('#carousel').infiniteCarousel	(
                                            {
                                                imagePath:'../Scripts/infiniteCarousel/images/',
                                                autoPilot :true
                                            }
                                        );       
	}
    

    

    
}
