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
 	             
        var _prioridadAtencionvch=gE('_prioridadAtencionvch');
        var x;
        var o;
        for(x=0;x<_prioridadAtencionvch.options.length;x++)
        {
        	o=_prioridadAtencionvch.options[x];
        	switch(o.value)
            {
            	case '1':
                	o.setAttribute('style',"background-color:#F00");
                break;
                case '2':
                	o.setAttribute('style',"background-color:#FF9A00");
                break;
                case '3':
                	o.setAttribute('style',"background-color:#DFDF81");
                break;
            }
        }              
        
       
        
    }
    else
    {
    	switch(gE('sp_15152').innerHTML)
        {
        	case 'Alta':
                gE('sp_15152').innerHTML='<span style="color:#F00">Alta</span>';
            break;
            case 'Media':
                gE('sp_15152').innerHTML='<span style="color:#FF9A00">Media</span>';
            break;
            case 'Baja':
               gE('sp_15152').innerHTML='<span style="color:#DFDF81">Baja</span>';
            break;
        }
    }
   
}


