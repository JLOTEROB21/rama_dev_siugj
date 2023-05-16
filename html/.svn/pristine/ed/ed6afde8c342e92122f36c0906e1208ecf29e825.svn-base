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
    
    	asignarEvento(gE('_tasaFijaOVarvch'),'change',function(cmb)
        							{
                                    	var opcion=cmb.options[cmb.selectedIndex].value;
                                        
                                        
                                        switch(opcion)
                                        {
                                        	case '1':
                                            	gE('_sobretasaflo').value=0;
                                                gE('_sobretasaflo').disabled=true;
                                                gE('_tasaInteresflo').disabled=false;
                                                gE('_tasaInteresflo').value=0;
                                            break;
                                            case '3':
                                            	gE('_tasaInteresflo').value=0;
                                                gE('_tasaInteresflo').disabled=true;
                                                gE('_sobretasaflo').disabled=false;
                                                gE('_sobretasaflo').value=0;
                                            break;
                                        
                                        }
                                    }
        			);
        
        
        
    }
    else
    {
    	
    }
}

